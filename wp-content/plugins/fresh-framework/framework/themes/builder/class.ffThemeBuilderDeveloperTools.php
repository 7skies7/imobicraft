<?php

class ffThemeBuilderDeveloperTools extends ffBasicObject {
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/

	/**
	 * @var ffWPLayer
	 */
	private $_WPLayer = null;

/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/

	public function __construct( ffWPLayer $WPLayer) {
		$this->_setWPLayer( $WPLayer );

		$this->_hookActions();
	}

/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/
	public function actLoadPlaceholders( ffAjaxRequest $ajaxRequest ) {

		$placeholdersDir = FF_ARK_CORE_PLUGIN_DIR . '/builder/placeholders';
		$placeholdersDirUri = FF_ARK_CORE_PLUGIN_URL . '/builder/placeholders';

		$fileSystem = ffContainer()->getFileSystem();

		$dirList = $fileSystem->dirlist( $placeholdersDir );

//		var_dump( $dirList, $placeholdersDir );
		$images = array();

		foreach( $dirList as $oneFile => $fileInfo ) {

			$imagePath = ( $placeholdersDir. '/' . $oneFile );
			$imageDimensions = getimagesize( $imagePath );

			$image = array();
			$image['url_real'] = $placeholdersDirUri .'/' . $oneFile;
			$image['url'] = $oneFile;
			$image['width'] = $imageDimensions[0];
			$image['height'] = $imageDimensions[1];
			$image['id'] = -1;

			$images[] = $image;
		}

		$imagesJSON = json_encode( $images );

		echo $imagesJSON;
	}


	public function actSaveDefaultElementData( ffAjaxRequest $ajaxRequest ) {
		$elementId = $ajaxRequest->getData('elementId');
		$elementDefaultData = $ajaxRequest->getDataStripped('elementDefaultData');

		var_dump( $elementDefaultData );



		$elementsManager = ffContainer()->getThemeFrameworkFactory()->getThemeBuilderElementManager();

		$currentElementInstance = $elementsManager->getElementById( $elementId );
		$currentElementClassName = get_class( $currentElementInstance );

		$classLoader = ffContainer()->getClassLoader();

		$currentElementDirPath = dirname($classLoader->getClassPath( $currentElementClassName ));

		var_dump( $currentElementDirPath );

		$defaultDataPath = $currentElementDirPath . '/default.json';
		$elementDefaultDataJSON = json_encode( $elementDefaultData );

		var_dump( $elementDefaultDataJSON );

		file_put_contents( $defaultDataPath, $elementDefaultDataJSON );

	}

/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/
	private function _hookActions() {
		$hookManager = $this->_getWPLayer()->getHookManager();
		$hookManager->addAjaxRequestOwner('ff-builder-load-placeholders', array( $this, 'actLoadPlaceholders' ) );
		$hookManager->addAjaxRequestOwner('ff-builder-save-default-element-data', array( $this, 'actSaveDefaultElementData' ) );
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

}