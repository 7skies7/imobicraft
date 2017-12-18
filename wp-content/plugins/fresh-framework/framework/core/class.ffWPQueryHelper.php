<?php

class ffWPQueryHelper extends ffBasicObject {
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/
	/**
	 * @var WP_Query
	 */
	private $_wpQuery = null;

/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/
	private $_offset = null;

	private $_numberOfPostsToPrint =  null;

	private $_currentPost = null;

	private $_printedPosts = 0;

	private $_printedRows = 0;

	private $_isFirstRun = true;
/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
	public function __construct() {

	}


/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/
	public function rowPrinted() {
		$this->_printedRows++;
	}

	public function getPrintedRows() {
		return $this->_printedRows;
	}


	private function _initLoop() {
		if( $this->_offset != null ) {
			for( $i = 0; $i < $this->_offset; $i++ ) {
				$this->_printedPosts++;
				$this->_getWpQuery()->the_post();
			}
		}

		if( $this->_numberOfPostsToPrint > 0 ) {
			$this->_numberOfPostsToPrint += $this->_printedPosts;
		} else {
			 $this->_numberOfPostsToPrint = $this->_getWpQuery()->post_count;
		}

//		var_dump( $this->_getWpQuery()->post_count );

	}

	public function havePostsForPrint() {
		if( $this->_isFirstRun ) {
			$this->_initLoop();
			$this->_isFirstRun = false;
		}

		if( $this->_printedPosts < $this->_getWpQuery()->post_count && $this->_printedPosts < $this->_numberOfPostsToPrint ) {
			return true;
		} else {
			return false;
		}
	}

	public function postHasBeenPrinted() {
		$this->_currentPost = null;
		$this->_printedPosts++;
	}

	public function setupPostData() {
		if( $this->_currentPost == null ) {
			$this->_getWpQuery()->the_post();
			$this->_currentPost = $this->_getWpQuery()->post;
		}
	}

	public function getPrintedPosts() {
		return $this->_printedPosts;
	}

//	/**
//	 * without rewinding ...
//	 */
//	public function havePosts() {
//		$wpQuery = $this->_getWpQuery();
//		if ( $wpQuery->current_post + 1 < $wpQuery->post_count ) {
//			return true;
//		} else {
//			return false;
//		}
//	}
//
//	public function setupCurrentPostData() {
//		$this->_getWpQuery()->setup_postdata( $this->_getWpQuery()->post );
//	}
//
//	public function nextPost() {
//		$this->_getWpQuery()->next_post();
//	}

/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* ABSTRACT FUNCTIONS
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/
	/**
	 * @return WP_Query
	 */
	private function _getWpQuery() {
		return $this->_wpQuery;
	}

	/**
	 * @param WP_Query $wpQuery
	 */
	public function setWpQuery($wpQuery) {
		$this->_wpQuery = $wpQuery;
	}

	/**
	 * @return null
	 */
	private function _getOffset() {
		return $this->_offset;
	}

	/**
	 * @param null $offset
	 */
	public function setOffset($offset) {
		$this->_offset = $offset;
	}

	/**
	 * @return null
	 */
	private function _getNumberOfPostsToPrint() {
		return $this->_numberOfPostsToPrint;
	}

	/**
	 * @param null $numberOfPostsToPrint
	 */
	public function setNumberOfPostsToPrint($numberOfPostsToPrint) {
		$this->_numberOfPostsToPrint = $numberOfPostsToPrint;
	}

	public function getWPQuery() {
		return $this->_getWpQuery();
	}

}