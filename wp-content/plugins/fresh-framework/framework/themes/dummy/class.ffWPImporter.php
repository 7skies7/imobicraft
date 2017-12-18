<?php

class ffWPImporter extends WP_Import {

	/**
	 * The main controller for the actual import stage.
	 *
	 * @param string $file Path to the WXR file for importing
	 */
	function setImportFile( $file ) {


		add_filter( 'import_post_meta_key', array( $this, 'is_valid_meta_key' ) );
		add_filter( 'http_request_timeout', array( &$this, 'bump_request_timeout' ) );

		$this->import_start( $file );
		$this->fetch_attachments = true;
		wp_suspend_cache_invalidation( true );

	}

	function importAuthors() {
		$this->get_author_mapping();
	}

	function importCategories() {
		$this->process_categories();
	}

	function importTags() {
		$this->process_tags();
	}

	function importTerms() {
		$this->process_terms();
	}

	function importPosts() {
		$this->process_posts();
	}

	function processedPostId( $oldId ) {
		if( isset( $this->processed_posts[ $oldId ] ) ) {
			return $this->processed_posts[ $oldId ];
		} else {
			return null;
		}
	}

	function importEnd() {
		wp_suspend_cache_invalidation( false );

//		 update incorrect/missing information in the DB
		$this->backfill_parents();
		$this->backfill_attachment_urls();
		$this->remap_featured_images();

		$this->import_end();
	}

	private function _getStateVariables() {
		$stateVariables = array();


		$stateVariables[] ='processed_authors';
		$stateVariables[] ='author_mapping';
		$stateVariables[] ='processed_terms';
		$stateVariables[] ='processed_posts';
		$stateVariables[] ='post_orphans';
		$stateVariables[] ='processed_menu_items';
		$stateVariables[] ='menu_item_orphans';
		$stateVariables[] ='missing_menu_items';

		$stateVariables[] ='url_remap';
		$stateVariables[] ='featured_images';

		return $stateVariables;
	}

	public function setState( $state ) {
		$stateVariables = $this->_getStateVariables();

		foreach( $stateVariables as $name ) {
			$this->$name = $state[ $name ];
		}
	}

	public function getState() {
		$stateVariables = $this->_getStateVariables();

		$state = array();

		foreach( $stateVariables as $name ) {
			$state[ $name ] = $this->$name;
		}

		return $state;
	}

	function getNumberOfPosts() {
		return count( $this->posts );
	}

	function setNumberOfPostsForImport($start, $numberOfPosts ) {
		$this->posts = array_slice( $this->posts, $start, $numberOfPosts );
	}

}