<?php

abstract class ffImportRuleBasic extends ffBasicObject {

	protected $_config = null;

	/**
	 * @var ffWPImporter
	 */
	protected $_WPImporter = null;

	protected function _getWPImporter() {
		return $this->_WPImporter;
	}

	public function setWPImporter( $WPImporter ) {
		$this->_WPImporter = $WPImporter;
	}

	public function setConfig( $config ) {
		$this->_config = $config;
	}

	protected function _getConfigValue( $name, $default) {
		if( isset( $this->_config[ $name ] ) ) {
			return $this->_config[ $name ];
		} else {
			return $default;
		}
	}

	public function register() {

	}

	/**
	 * @param $WPImporter ffWPImporter
	 */
	public function beforeImportAuthors() {

	}

	/**
	 * @param $WPImporter ffWPImporter
	 */
	public function afterImportAuthors() {

	}

	/**
	 * @param $WPImporter ffWPImporter
	 */
	public function beforeImportCategories() {

	}

	/**
	 * @param $WPImporter ffWPImporter
	 */
	public function afterImportCategories() {

	}

	/**
	 * @param $WPImporter ffWPImporter
	 */
	public function beforeImportTags() {

	}

	/**
	 * @param $WPImporter ffWPImporter
	 */
	public function afterImportTags() {

	}

	/**
	 * @param $WPImporter ffWPImporter
	 */
	public function beforeImportTerms() {

	}

	/**
	 * @param $WPImporter ffWPImporter
	 */
	public function afterImportTerms() {

	}

	/**
	 * @param $WPImporter ffWPImporter
	 */
	public function beforeImportPostsAll() {

	}

	/**
	 * @param $WPImporter ffWPImporter
	 */
	public function beforeImportPostsBatch() {

	}

	/**
	 * @param $WPImporter ffWPImporter
	 */
	public function afterImportPosts() {

	}


}