<?php
class ffImportStepChangeContentBlocks extends ffImportStepBasic {

	/**
	 * How many posts we want to replace in one batch
	 * @var int
	 */
	private $_numberOfPostsInOneBatch = 10;

	private $_foundCBInThisPost = false;



	public function parseContentBlocks( $atts, $content, $scName  ) {


		if( !isset( $atts['data'] ) ) {
			return '';
		}

		$this->_foundCBInThisPost = true;

		$dataEncoded = $atts['data'];
		$dataJSON = urldecode( $dataEncoded );



		$data = new ffDataHolder();
		$data->setDataJSON( $dataJSON );

		$contentBlockData = $data->get('o gen content-block');

		$idSplitted = explode('--||--', $contentBlockData );

		if( !isset( $idSplitted[0] ) ) {
			return '';
		}

		$oldContentBlockId = $idSplitted[0];



		$newId = $this->_getWPImporter()->processedPostId( $oldContentBlockId );

//		var_dump( $this->_getWPImporter() );
//		die();
		$post = get_post( $newId );


		if( empty( $post ) ) {
			return '';
		}

		else {
			return $post->post_content;
		}

	}

	/**
	 * @param $posts ffPostCollection
	 */
	protected function _proceedPosts( $posts )  {

		for( $i = 0; $i<10; $i++ ) {
			add_shortcode('ffb_content-block-admin_' . $i, array( $this, 'parseContentBlocks' ) );
		}

//		$regexp = '/%7B%5C%22id%5C%22%3A([0-9]*)%2C%5C%22url%5C%22%3A%5C%22(.+?)%5C%22%2C%5C%22width%5C%22%3A([0-9]+)%2C%5C%22height%5C%22%3A([0-9]+)%7D/';
//
		foreach( $posts as $onePost ) {
			$this->_foundCBInThisPost= false;

			$contentReplaced = do_shortcode( $onePost->getContent() );


//			$contentReplaced = preg_replace_callback( $regexp, array($this, '_replaceMatchedImage'), $onePost->getContent() );
//
			if( $this->_foundCBInThisPost == true ) {
				$postUpdater = ffContainer()->getPostLayer()->getPostUpdater();
				$data = array();
				$data['ID'] = $onePost->getID();
				$data['post_content'] = $contentReplaced;

				$postUpdater->updatePost($data);
			}
		}

	}

	protected function _runStep() {
		$postsIn = $this->_getWPImporter()->processed_posts;

		$postGetter = ffContainer()->getPostLayer()->getPostGetter();
		$postsPerOneRun = $this->_numberOfPostsInOneBatch;

		$currentBatch = $this->_getStateValue('current-batch', 0);

		$offset = $currentBatch * $postsPerOneRun;

		if( $offset > 0 ) {
			$postGetter->addArg('offset', $offset );
		}
		$postGetter->addArg('post_type', 'any');
		$postGetter->addArg('post_status', 'any');
		$postGetter->setNumberOfPosts( $postsPerOneRun );

		$posts = $postGetter->getPostsByType();

		if( empty( $posts ) ) {
			return false;
		}

		$this->_message = 'Changing Content Blocks';
		$this->_stepMax = count( $postsIn );
		$this->_stepCurrent = $offset;

		$this->_proceedPosts( $posts );

		$currentBatch++;

		$this->_setStateValue('current-batch', $currentBatch);
		return true;
	}

}