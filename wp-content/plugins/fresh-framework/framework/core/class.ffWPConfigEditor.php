<?php

class ffWPConfigEditor extends ffBasicObject {
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/
	/**
	 * @var ffWPLayer
	 */
	private $_WPLayer = null;

	/**
	 * @var ffFileSystem
	 */
	private $_fileSystem = null;

/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/
	private $_wpConfig = null;

/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/

	public function __construct( $WPLayer, $fileSystem ) {
		$this->_setWPLayer( $WPLayer );
		$this->_setFileSystem( $fileSystem );
	}

/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/
	public function getWPConfigContent() {
		return $this->_getWPConfigContent();
	}

	public function enableWPDebug() {
		$newWpConfig = $this->_findWPDebug(function( $matches ){
			$wpDebugLineOld = $matches[0];
			$oldValue = $matches[1];

			$wpDebugLineNew = [];

			$wpDebugLineNew = str_replace( $oldValue, 'true', $wpDebugLineOld ) . '//FFAfterDebug';

			return $wpDebugLineNew;
		});

		$afterDebugReplace = '';
		if( strpos($newWpConfig, 'error_reporting(E_ALL);') === false ) {
			$afterDebugReplace .= 'error_reporting(E_ALL);';
		}

		if( strpos($newWpConfig, "ini_set('display_errors', 1);") === false ) {
			$afterDebugReplace .= "ini_set('display_errors', 1);";
		}

		if( strpos($newWpConfig, "define( 'WP_DEBUG_DISPLAY', true );") === false ) {
			$afterDebugReplace .= "define( 'WP_DEBUG_DISPLAY', true );";
		}



		$newWpConfig = str_replace('//FFAfterDebug', $afterDebugReplace, $newWpConfig );

		$this->_setWpConfig( $newWpConfig );
		$this->_saveWPConfig();
	}

	public function disableWPDebug() {
		$newWpConfig = $this->_findWPDebug(function( $matches ){
			$wpDebugLineOld = $matches[0];
			$oldValue = $matches[1];

//			$wpDebugLineNew = [];

			$wpDebugLineNew= str_replace( $oldValue, 'false', $wpDebugLineOld ).'//FFAfterDebug';

			return $wpDebugLineNew;
		});

		$newWpConfig = str_replace("error_reporting(E_ALL);", '', $newWpConfig);
		$newWpConfig = str_replace("ini_set('display_errors', 1);", '', $newWpConfig);
		$newWpConfig = str_replace("define( 'WP_DEBUG_DISPLAY', true );", '', $newWpConfig);


		$newWpConfig = str_replace("//FFAfterDebug", '', $newWpConfig);

		$this->_setWpConfig( $newWpConfig );
		$this->_saveWPConfig();
	}

	public function getWPDebugValue( $returnWholeLine = false ) {
		//define\(['" ]WP_DEBUG['"][, ]*([a-z]*)[ ]*\);
		$matches = $this->_findWPDebug();

		if( $returnWholeLine ) {
			if( isset( $matches[0] ) ) {
				return $matches[0];
			} else {
				return null;
			}
		}

		$value = false;
		if( isset( $matches[1] ) ) {
			$value = $matches[1];
			$value = strtolower( $value );
			$value = trim( $value );

			if( strpos( $value, 'true') !== false ) {
				$value = true;
			} else {
				$value = false;
			}
		}

		return $value;
	}


/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/
	private function _findWPDebug( $replaceCallback = null) {
		$wpDebugRegexp = '/define\([\'" ]WP_DEBUG[\'"][, ]*([a-z]*)[ ]*\);/i';

		$content = $this->_getWPConfigContent();

		$matches = array();

		if( $replaceCallback == null ) {
			preg_match( $wpDebugRegexp, $content, $matches );
		} else {
			$matches = preg_replace_callback( $wpDebugRegexp, $replaceCallback, $content);
		}


		return $matches;
	}


	private function _getWPConfigContent() {
		$path = $this->_getWPConfigPath();

		if( $path == null ) {
			return null;
		}

		return $this->_getFileSystem()->getContents( $path );
	}

	private function _saveWPConfig() {
		$path = $this->_getWPConfigPath();

		if( $path == null ) {
			return null;
		}

		return $this->_getFileSystem()->putContents( $path, $this->_getWpConfig());
	}

	private function _getWPConfigPath() {
		$wpPath = $this->_getWPLayer()->get_absolute_path();
		$wpConfigPath = $wpPath . 'wp-config.php';

		if( $this->_getFileSystem()->fileExists( $wpConfigPath ) ) {
			return $wpConfigPath;
		} else {
			return null;
		}
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
	 * @return ffFileSystem
	 */
	private function _getFileSystem() {
		return $this->_fileSystem;
	}

	/**
	 * @param ffFileSystem $fileSystem
	 */
	private function _setFileSystem($fileSystem) {
		$this->_fileSystem = $fileSystem;
	}

	/**
	 * @return null
	 */
	private function _getWpConfig() {
		if( $this->_wpConfig == null ) {
			$this->_wpConfig = $this->_getWPConfigContent();
		}
		return $this->_wpConfig;
	}

	/**
	 * @param null $wpConfig
	 */
	private function _setWpConfig($wpConfig) {
		$this->_wpConfig = $wpConfig;
	}


}