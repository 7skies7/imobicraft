<?php
class ffImportStepDeleteContentBlocks extends ffImportStepBasic {

	/**
	 * How many posts we want to replace in one batch
	 * @var int
	 */
	private $_numberOfPostsInOneBatch = 10;


	protected function _runStep() {

		$this->_message = 'Deleting Content Blocks';
//		$this->_stepMax = count( $postsIn );
//		$this->_stepCurrent = $offset;

		global $wpdb;
		$sql = 'DELETE FROM '.$wpdb->posts.' WHERE post_type="ff-content-block-a"';
		$wpdb->query( $sql );

//		$wpdb->posts

//		$postGetter = ffContainer()->getPostLayer()->getPostGetter();
//		$postsPerOneRun = $this->_numberOfPostsInOneBatch;
//
//		$currentBatch = $this->_getStateValue('current-batch', 0);
//
//		$offset = $currentBatch * $postsPerOneRun;
//
//		if( $offset > 0 ) {
//			$postGetter->addArg('offset', $offset );
//		}
//		$postGetter->addArg('post_type', 'any');
//		$postGetter->addArg('post_status', 'any');
//		$postGetter->setNumberOfPosts( $postsPerOneRun );
//
//		$posts = $postGetter->getPostsByType();
//
//		if( empty( $posts ) ) {
//			return false;
//		}
//
//		$this->_proceedPosts( $posts );
//
//		$currentBatch++;
//
//		$this->_setStateValue('current-batch', $currentBatch);
		return false;
	}

}