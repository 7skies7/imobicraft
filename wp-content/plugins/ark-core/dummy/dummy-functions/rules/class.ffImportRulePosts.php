<?php

class ffImportRulePosts extends ffImportRuleBasic {
	/**
	 * @param $WPImporter ffWPImporter
	 */
	public function beforeImportPostsBatch() {


		$newPosts = [];

		$regex = '/%22taxonomies%22%3A%22([0-9a-zA-Z\*\%\-\ ]*)%22/';

		foreach( $this->_getWPImporter()->posts as $onePost ) {
//			var_dump( $onePost );
//			$onePost['post_content'] = preg_replace_callback($regString, array($this, '_replaceRegString'), $onePost['post_content'] );
			$onePost['post_content'] = preg_replace_callback($regex, array($this, '_replaceEncodedStringNew'), $onePost['post_content'] );
//
//			if( strpos(  $onePost['post_content'], 'taxonomies') !== false ) {
//				var_dump( $onePost );
//				die();
//			}
//
//			if( strpos( 'taxonomies',  $onePost['post_content']) !== false ) {
//				var_dump( $onePost );
//				die();
//			}

			$newPosts[] = $onePost;
		}

		$this->_getWPImporter()->posts = $newPosts;

		// %7C%7Ctax-s%7C%7C([0-9a-zA-Z%]*)%7C%7Ctax-e%7C%7C%
		// \|\|tax-s\|\|([0-9\*\|]*)\|\|tax-e\|\|

//		$regString = '/\|\|tax-s\|\|([0-9]*)\|\|tax-e\|\|/';
//		$encodedString = '/%7C%7Ctax-s%7C%7C([0-9]*)%7C%7Ctax-e%7C%7C/';

//		$regString = '/\|\|tax-s\|\|([0-9\*\|]*)\|\|tax-e\|\|/';
//		$encodedString = '/%7C%7Ctax-s%7C%7C([0-9a-zA-Z%*]*)%7C%7Ctax-e%7C%7C/';
//
//		foreach( $this->_getWPImporter()->posts as $onePost ) {
//			$onePost['post_content'] = preg_replace_callback($regString, array($this, '_replaceRegString'), $onePost['post_content'] );
//			$onePost['post_content'] = preg_replace_callback($encodedString, array($this, '_replaceEncodedString'), $onePost['post_content'] );
//
//			$newPosts[] = $onePost;
//		}
//		$this->_getWPImporter()->posts = $newPosts;
		//$reg = '/%7C%7Ctax-s%7C%7C([0-9]*)%7C%7Ctax-e%7C%7C/';
//		$reg = '\|\|tax-s\|\|([0-9]*)\|\|tax-e\|\|';

	}

	private function _replaceEncodedStringNew( $matches ) {
		$wholeMatch = $matches[0];
		$oldIdPart= $matches[1];


		$match = urldecode( $oldIdPart);

		$matchMultiple = explode('--||--', $match );
		$newMatchMultiple = array();

		foreach( $matchMultiple as $oneMatch ) {
			$oneMatchExploded = explode('*|*', $oneMatch );

			$newId = '1';
			if( isset( $oneMatchExploded[0] ) ) {
				$oneOldId = $oneMatchExploded[0];
				$newId = $this->_getWPImporter()->processed_terms[ $oneOldId ];
			}

			$name = '';
			if( isset( $oneMatchExploded[1] ) ) {
				$name = $oneMatchExploded[1];
			}

			$newMatchExploded = array();
			$newMatchExploded[0] = $newId;
			$newMatchExploded[1] = $name;

			$newMatch = implode( '*|*', $newMatchExploded);
			$newMatchMultiple[] = $newMatch;
		}

		$newMatchesString = implode('--||--', $newMatchMultiple );
		$newMatchesStringEncoded =  rawurlencode( $newMatchesString );

		$replaced = str_replace( $oldIdPart, $newMatchesStringEncoded, $wholeMatch );

		return $replaced;
	}

	private function _replaceRegString( $matches ) {
		$oldId = $matches[1];

		$oldIdSplitted = explode('*|*', $oldId );

		$newIdSplitted = array();

		foreach( $oldIdSplitted as $oneOldId ) {
			$newId = $this->_getWPImporter()->processed_terms[ $oneOldId ];
			$newIdSplitted[] = $newId;
		}

		return $this->_getTaxonomyString( $newIdSplitted );
	}

	private function _replaceEncodedString( $matches ) {
		$oldId = $matches[1];

		$oldIdSplitted = explode('%2A%7C%2A', $oldId );

		$newIdSplitted = array();

		foreach( $oldIdSplitted as $oneOldId ) {
			$newId = $this->_getWPImporter()->processed_terms[ $oneOldId ];
			$newIdSplitted[] = $newId;
		}

		return $this->_getTaxonomyString( $newIdSplitted, true );
	}


	private function _getTaxonomyString( $taxId, $urlEncoded = false ) {
		$taxString = '||tax-s||' . implode('*|*', $taxId ). '||tax-e||';

		if( $urlEncoded ) {
			$taxString = rawurlencode( $taxString ) ;
		}

		return $taxString;
	}
}