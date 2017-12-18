<?php

/**
 * Class ffThemeBuilderColorLibrary
 *
 * Color Library,
 */
class ffThemeBuilderColorLibrary extends ffBasicObject {
	const OPT_NAMESPACE = 'system';
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/
	/**
	 * @var ffDataStorage_WPOptions_NamespaceFacede
	 */
	private $_WPOptions = null;

	/**
	 * @var ffWPLayer
	 */
	private $_WPLayer = null;

	/**
	 * @var ffEnvironment
	 */
	private $_environment = null;

	private $_libraryHash = null;

/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/
	private $_colorLibrary = null;

/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
	public function __construct() {
		$this->_setWPOptions( ffContainer()->getDataStorageFactory()->createDataStorageWPOptionsNamespace() );
		$this->_getWPOptions()->setNamespace( ffThemeBuilderColorLibrary::OPT_NAMESPACE );
		$this->_setWPLayer( ffContainer()->getWPLayer() );
		$this->_setEnvironment( ffContainer()->getEnvironment() );
	}


/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/
	public function getLibrary() {
		$this->_initLibrary();

		return $this->_colorLibrary;
	}

	public function getLibraryHash() {
		if( $this->_libraryHash == null ) {
			$this->_initLibrary();
			$this->_libraryHash = md5( json_encode( $this->_colorLibrary ) );
		}

		return $this->_libraryHash;
	}

	public function setLibrary( $library ) {
		$this->_colorLibrary = $library;
		return $this;
	}

	public function setColor( $position, $color, $name = null ) {
		$this->_initLibrary();

		$this->_colorLibrary[ $position ][ 'color' ] = $color;
		if( $name != null ) {
			$this->_colorLibrary[ $position ]['name'] = $name;
 		}
	}

	public function hookAjax() {
		$this->_getWPLayer()
			->getHookManager()
			->addAjaxRequestOwner('ffThemeBuilderColorLibrary', array($this,'actAjax'));
	}

	public function getColor( $position ) {
		$this->_initLibrary();
		if( isset( $this->_colorLibrary[ $position ] ) ) {
			return $this->_colorLibrary[ $position ]['color'];
		} else {
			return '#ffffff';
		}

	}

	public function saveLibrary() {
		$this->_saveColorLibrary();
	}

	/**
	 * @param $ajaxRequest ffAjaxRequest
	 */
	public function actAjax( $ajaxRequest) {
		switch( $ajaxRequest->getSpecification('action', 'save') ) {
			case 'save':
				$colorLibrary = $ajaxRequest->getData('colorLibrary');

				$this->_colorLibrary = $colorLibrary;
				$this->_saveColorLibrary();
				break;
		}
	}


/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/
	private function _initLibrary() {
		if( $this->_colorLibrary == null ) {
			$this->_loadColorLibrary();

			if( $this->_colorLibrary == null ) {
				$this->_createColorLibrary();
			}
		}
	}

	private function _createColorLibrary() {
		$this->_colorLibrary = array();

		$fs = ffContainer()->getFileSystem();
		$defaultColorlibJSON = $fs->getContents( $this->_getWPLayer()->get_template_directory().'/default/colorlibrary.json');
		$defaultColorLib = json_decode( $defaultColorlibJSON, true);

		$this->_colorLibrary = $defaultColorLib;
		return $defaultColorLib;

	}

	private function _getDefaultColor() {
		return '#ffffff';
	}

	private function _loadColorLibrary() {
//		$this->_colorLibrary = $this->_getWPLayer()->get_option($this->_getColorLibraryOptionName(), null);
		$this->_colorLibrary = $this->_getWPOptions()->getOption( $this->_getColorLibraryOptionName(), null );
		if( $this->_colorLibrary != null ) {
			$this->_colorLibrary = json_decode( $this->_colorLibrary, true );
		}
	}

	private function _saveColorLibrary() {
		$data = $this->_colorLibrary;
		$dataJSON = json_encode( $data );

		$this->_colorLibrary = $this->_getWPOptions()->setOption( $this->_getColorLibraryOptionName(), $dataJSON );
	}

	private function _getColorLibraryOptionName() {
		$themeName = $this->_getEnvironment()->getThemeVariable(ffEnvironment::THEME_NAME);

		$optionName = 'colorlib-' . $themeName ;

		return $optionName;
	}

/**********************************************************************************************************************/
/* ABSTRACT FUNCTIONS
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/
	/**
	 * @return ffWPLayer
	 */
	private function _getWPLayer() {
		return $this->_WPLayer;
	}

	/**
	 * @param ffWPLayer $WPLayer
	 */
	private function _setWPLayer($WPLayer) {
		$this->_WPLayer = $WPLayer;
	}

	/**
	 * @return ffEnvironment
	 */
	private function _getEnvironment() {
		return $this->_environment;
	}

	/**
	 * @param ffEnvironment $environment
	 */
	private function _setEnvironment($environment) {
		$this->_environment = $environment;
	}

	/**
	 * @return ffDataStorage_WPOptions_NamespaceFacede
	 */
	private function _getWPOptions() {
		return $this->_WPOptions;
	}

	/**
	 * @param ffDataStorage_WPOptions_NamespaceFacede $WPOptions
	 */
	private function _setWPOptions($WPOptions) {
		$this->_WPOptions = $WPOptions;
	}


}