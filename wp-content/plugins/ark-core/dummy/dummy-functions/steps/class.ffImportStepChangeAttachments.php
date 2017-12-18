<?php
class ffImportStepChangeAttachments extends ffImportStepBasic {

	/**
	 * How many posts we want to replace in one batch
	 * @var int
	 */
	private $_numberOfPostsInOneBatch = 10;

	private $_foundImageInThisPost = false;

	protected function _replaceMatchedImage( $match ) {

		$originalString = $match[0];
		$originalId = $match[1];
		$url = $match[2];
		$width = $match[3];
		$height = $match[4];

		// is our demo content image
		if( $originalId == -1 ) {
			return $originalString;
		}

		$newId = $this->_getWPImporter()->processedPostId( $originalId );

		// post does not exists
		if( $newId == null ) {
			return $originalString;
		}

		$newUrl = wp_get_attachment_url( $newId );

		$newImage = array();
		$newImage['id'] = $newId;
		$newImage['url'] = $newUrl;
		$newImage['width'] = $width;
		$newImage['height'] = $height;

		$imageJson = json_encode( $newImage, JSON_UNESCAPED_SLASHES);
		$imageJsonWithSlashes = addslashes( $imageJson );
		$imageJsonEncoded = rawurlencode( $imageJsonWithSlashes );

		$this->_foundImageInThisPost = true;

		return $imageJsonEncoded;
	}

	/**
	 * @param $posts ffPostCollection
	 */
	protected function _proceedPosts( $posts )  {
		$regexp = '/%7B%5C%22id%5C%22%3A([0-9]*)%2C%5C%22url%5C%22%3A%5C%22(.+?)%5C%22%2C%5C%22width%5C%22%3A([0-9]+)%2C%5C%22height%5C%22%3A([0-9]+)%7D/';

		foreach( $posts as $onePost ) {
			$this->_foundImageInThisPost = false;
			$contentReplaced = preg_replace_callback( $regexp, array($this, '_replaceMatchedImage'), $onePost->getContent() );

			if( $this->_foundImageInThisPost == true ) {
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

		$postGetter->addArg('inc'.'lude', $postsIn );

		$posts = $postGetter->getPostsByType();

		$this->_message = 'Changing images';
		$this->_stepMax = count( $postsIn );
		$this->_stepCurrent = $offset;

		if( empty( $posts ) ) {
			return false;
		}

		$this->_proceedPosts( $posts );

		$currentBatch++;

		$this->_setStateValue('current-batch', $currentBatch);
		return true;
	}

}