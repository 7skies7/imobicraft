<?php

class ffEnvironment extends ffBasicObject {
	const THEME_NAME = 'theme_name';
	const THEME_USE_LICENSED_UPGRADER = 'theme_use_licensed_upgrader';
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/
	/**
	 * @var ffWPLayer
	 */
	private $_WPLayer = null;

	private $_isOurTheme = false;

	private $_themeVariables = array();

/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
	/**
	 * ffEnvironment constructor.
	 * @param $WPLayer ffWPLayer
	 */
	public function __construct( $WPLayer ) {
		$this->_setWPLayer( $WPLayer );
	}

/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/

	public function setIsOurTheme( $value ) {
		$this->_isOurTheme = $value;
	}

	public function getThemeName() {
		return $this->_getWPLayer()->wp_get_theme()->get('Name');
	}

	public function getThemeVersion() {
		return $this->_getWPLayer()->wp_get_theme()->get('Version');
	}

	public function getThemeTemplate() {
		return $this->_getWPLayer()->wp_get_theme()->get_template();
	}

	public function getThemeUri() {
		return $this->_getWPLayer()->wp_get_theme()->get('ThemeURI');
	}

	public function getThemeVariable( $name, $default = null ) {
		if( isset($this->_themeVariables[ $name ]) ) {
			return $this->_themeVariables[ $name ];
		} else {
			return $default;
		}
	}

	public function setThemeVariable( $name, $value ) {
		$this->_themeVariables[ $name ] = $value;
	}

	public function isLocalhost() {
		$server = $_SERVER['HTTP_HOST'];

		if( strpos( $server, '127.0.0.1') !== false ) {
			return true;
		}

		if( $server == 'localhost' ) {
			return true;
		}

		$whitelist = array( '127.0.0.1', '::1' );
		if( in_array( $_SERVER['REMOTE_ADDR'], $whitelist) ) {
			return true;
		}

		return false;
	}

	public function getDomain() {
		if( $this->isLocalhost() ) {
			return 'localhost';
		} else {
			return $_SERVER['HTTP_HOST'];
		}
	}

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
}