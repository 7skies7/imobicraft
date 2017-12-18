<?php

//NGCD
class ffThemeBuilderSectionManager extends ffBasicObject {
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/

	/**
	 * @var ffFileSystem
	 */
	private $_fileSystem = null;
/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
	public function __construct() {
		$this->_setFileSystem( ffContainer()->getFileSystem() );
	}


/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/
	public function getSectionDataForBuilder() {
		if( !ffContainer()->getWPLayer()->isArkTheme() ) {
			return array();
		}

		$sectionsItems = $this->_getListOfAllItemsInSectionFolder();
		$info = $this->_getInfoAboutSections( $sectionsItems );



		return $info;
	}

	public function getSectionData( $sectionData ) {
		if( empty( $sectionData['type'] ) ) {
			$sectionData['type'] = 'main';
		}
		$sectionPath = $this->_getSectionPath() .'/' . $sectionData['type'] . '/' . $sectionData['id'] . '.json';
//		var_Dump( $sectionPath );
		$sectionContentJSON = $this->_getFileSystem()->getContents( $sectionPath );

		$sectionContent = json_decode( $sectionContentJSON, true );

		return $sectionContent;
	}



/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/
	private function _getInfoAboutSections( $sectionItems ) {
		$info = array();

		$fileSystem = $this->_getFileSystem();

		foreach( $sectionItems as $oneItem ) {
			$pathInfo = pathinfo( $oneItem['name' ]);
			$extension = $pathInfo['extension'];

			if( $extension != 'json' ) {
				continue;
			}

			$url = $fileSystem->getUrlFromPath( $oneItem['dir']);
			$imageName = str_replace('.json', '.jpg', $oneItem['name'] );
			$imagePath = $url .'/'. $imageName;

			$itemContentJSON = $this->_getFileSystem()->getContents( $oneItem['path'] );
			$item = json_decode( $itemContentJSON, true );

			$item['id'] = str_replace('.json','',$oneItem['name']);
			unset( $item['content'] );
			$item['image'] = $imagePath;

			$info[] = $item;
		}

		return $info;
	}

	private function _getListOfAllItemsInSectionFolder(){
		$sectionPath = $this->_getSectionPath();
		$sections = $this->_getFileSystem()->getFilesFromDirRecursive( $sectionPath );
		return $sections;
	}

	private function _getSectionPath() {
		return $this->_getFileSystem()->getThemePath('/builder/sections');
	}

/**********************************************************************************************************************/
/* ABSTRACT FUNCTIONS
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/
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
}