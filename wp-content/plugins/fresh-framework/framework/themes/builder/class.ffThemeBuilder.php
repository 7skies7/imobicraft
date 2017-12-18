<?php

class ffThemeBuilder extends ffBasicObject {
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
	private $_settings = array();

	/**
	 * @var ffAjaxRequest
	 */
	private $_currentAjaxRequest = null;

/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
    public function __construct() {
//	    $this->_setFrameworkScriptLoader( ffContainer()->getFrameworkScriptLoader());
	    $this->_setWPLayer( ffContainer()->getWPLayer() );

	    $this->setSaveAsPost( true );
    }


/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/
	public function hookAjax() {
		$WPLayer =$this->_getWPLayer();
		$WPLayer->getHookManager()
			->addAjaxRequestOwner('ffThemeBuilder', array($this,'actionThemeBuilderAjax'));
	}



	public function actionThemeBuilderAjax( ffAjaxRequest $ajaxRequest ) {
		$this->_currentAjaxRequest = $ajaxRequest;
		switch ( $ajaxRequest->getSpecification('action') ) {
			case 'getElementsData':
				$this->_getElementsData( $ajaxRequest );
				break;

			case 'deleteBuilderCache':
				$this->_deleteBuilderCache( $ajaxRequest );
				break;

			case 'saveAjax':
				$this->_saveAjax( $ajaxRequest );
				break;

			case 'saveAjaxDefaultElement':
				$this->_saveAjaxDefaultElement( $ajaxRequest );
				break;

			case 'getSectionContentFromSectionData':
				$this->_getSectionContentFromSectionData( $ajaxRequest );

		}
	}

	private function _deleteBuilderCache( ffAjaxRequest $ajaxRequest ) {
		$cache = ffContainer()->getThemeFrameworkFactory()->getThemeBuilderCache();
		
		$cache->deleteBackendCache();

		$ajaxDispatcher = $this->_getAjaxDispatcher();
		$ajaxDispatcher->addResponse('status', 1);
	}

	private function _saveAjaxDefaultElement( ffAjaxRequest $ajaxRequest ) {
		$element = $this->_getThemeBuilderElementManager()->getElementById( $ajaxRequest->getDataStripped('elementId') );
		$className = get_class( $element );

		$classPath = ffContainer()->getClassLoader()->getClassPath( $className );
		$classDir = dirname( $classPath );

		$defaultFilePath = $classDir.'/default.json';

		$defaultDataJSON = $ajaxRequest->getDataStripped('defaultData');

		$result = ffContainer()->getFileSystem()->putContents($defaultFilePath, $defaultDataJSON );

	}

	/**
	 * @param $ajaxRequest
	 */
	private function _getSectionContentFromSectionData( $ajaxRequest ) {
		$sectionDataWithoutContent = $ajaxRequest->getData('sectionData');

		$sectionDataComplete = $this->_getThemeBuilderSectionManager()->getSectionData( $sectionDataWithoutContent );

		$sectionContentShortcodes = $sectionDataComplete['content'];


		$builderManager = $this->_getThemeBuilderManager();
		$builderManager->setIsEditMode( true);

		$sectionContentForBuilder = $builderManager->renderButNotPrint( $sectionContentShortcodes );

		$ajaxDispatcher = $this->_getAjaxDispatcher();
		$ajaxDispatcher->addResponse('status', 1);
		$ajaxDispatcher->addResponse('section_data', $sectionContentForBuilder );
//		ffContainer()->getAjaxDispatcher()->addResponse('section-data', $sectionDataComplete );
	}

	private function _deleteRevisions( $postId ) {
		$maxNumberOfRevisions = 10;
		$wpLayer = $this->_getWPLayer();
		$revisions = $wpLayer->wp_get_post_revisions( $postId, array( 'order' => 'DESC' ) );

		$counter = 0;
		foreach( $revisions as $oneRevision ) {
			$counter++;
			if( $counter <= $maxNumberOfRevisions ) {
				continue;
			}

			$wpLayer->wp_delete_post_revision( $oneRevision->ID );
		}
	}
	/**
	 * @param $ajaxRequest ffAjaxRequest
	 */
	private function _saveAjax( $ajaxRequest ) {
		if( $this->_getBuilderSettings('saveAsPost') ) {
//			var_dump( $_POST );
//			die();
			$postId = $ajaxRequest->getDataStripped('postId');
			$content = $ajaxRequest->getDataStripped('content');
			$colorLibraryData = $ajaxRequest->getDataStripped('colorLibrary');
			$globalStylesData = $ajaxRequest->getDataStripped('globalStyles');

			$globalStyles = ffContainer()->getThemeFrameworkFactory()->getThemeBuilderGlobalStyles();
			$globalStyles->setElementGlobalStyles( $globalStylesData );




			$colorLibrary = $this->_getThemeColorLibrary();
			$colorLibrary->setLibrary( $colorLibraryData )->saveLibrary();

			wp_update_post( array('ID'=>$postId, 'post_content'=>$content) );

			$postMeta = ffContainer()->getDataStorageFactory()->createDataStorageWPPostMetas();
			$builderStatus = new ffDataHolder();
			$builderStatus->setDataJSON( $postMeta->getOption($postId, 'ff_builder_status', null ) );
			$builderStatus->set('usage', 'used');
			$postMeta->setOption( $postId, 'ff_builder_status', $builderStatus->getDataJSON() );

			$saveAjaxCounter = $ajaxRequest->getData('saveAjaxCounter', 1);

			if( $saveAjaxCounter == 1 || ( $saveAjaxCounter % 5 ) == 0 ) {
				$this->_deleteRevisions($postId);
			}

		} else {
			$saveAjaxOwner = $this->_getBuilderSettings('saveAjaxOwner');

			$globalStylesData = $ajaxRequest->getDataStripped('globalStyles');

			$globalStyles = ffContainer()->getThemeFrameworkFactory()->getThemeBuilderGlobalStyles();
			$globalStyles->setElementGlobalStyles( $globalStylesData );

			$owner = isset( $saveAjaxOwner['owner'] ) ? $saveAjaxOwner['owner'] : null;
			$specification = isset( $saveAjaxOwner['specification']) ? $saveAjaxOwner['specification'] : null;

			$data = $ajaxRequest->data;
			$data['action'] = 'themebuilder-save-ajax';

			$this->_getWPLayer()->getHookManager()->broadcastFakeAjaxRequest($owner, $data, $specification);
		}


	}

	public function getElementsData() {
		return $this->_getElementsData( null, false );
	}
	/**
	 * @param $ajaxRequest ffAjaxRequest
	 */
	private function _getElementsData( $ajaxRequest, $echo = true ) {
		$cache = ffContainer()->getDataStorageCache();

		if( $ajaxRequest == null ) {
			$currentAction = 'loadElements';
		} else {
			$currentAction = $ajaxRequest->getData( 'action' );
		}

		if( $currentAction == 'loadElements' ) {

			$allEl =  $cache->getOption('freshbuilder', 'all-elements');

			if( $allEl != null ) {
				echo $allEl;
				die();
			}

			$currentLoadHash = null;
			$position = 0;

			if( $ajaxRequest != null ) {
				$currentLoadHash = $ajaxRequest->getData('currentLoadHash');
				$position = $ajaxRequest->getData('position');
			}


			$themeBuilderManager = $this->_getThemeBuilderManager();
			$themeBuilderManager->setIsEditMode( true );

			$themeBlockManager = $this->_getThemeBuilderBlockManager();
			$themeBlockManager->setIsEditMode(true);

			$elementManager = $this->_getThemeBuilderElementManager();

			$data = $elementManager->getElementsData($position, $currentLoadHash );

			if( $echo ) {
				echo $data;
			} else {
				return $data;
			}

			die();
//			var_dump( $position);

		} else if( $currentAction == 'loadRest' ) {
			$data = array();

			$data['color_library'] = $this->_getThemeColorLibrary()->getLibrary();

			$data['predefined_elements'] = $this->_getDefaultSectionsData();

			$data['sections'] = $this->_getThemeBuilderSectionManager()->getSectionDataForBuilder();

			echo json_encode( $data );
			die();
		} else  {
//			echo 'kokot';
//			$elements = $ajaxRequest->getData( 'cachedElements' );
//			$cache->getOption('freshbuilder', 'all-elements', $elements);
//			die();
		}


		return;

		/*
		 * 1.) po 20 elementech nacitat element data
		 * 2.) Jakmile to finishne, nacist zbytek
		 *
		 *
		 *
		 */


		var_dump( $ajaxRequest->getData('action') );
		die();

//		ini_set('memory_limit','16M');
		$themeBuilderManager = $this->_getThemeBuilderManager();
		$themeBuilderManager->setIsEditMode( true );

		$themeBlockManager = $this->_getThemeBuilderBlockManager();
		$themeBlockManager->setIsEditMode(true);

		$elementManager = $this->_getThemeBuilderElementManager();

		$data = $elementManager->getElementsData();
		$data['color_library'] = $this->_getThemeColorLibrary()->getLibrary();

		$data['predefined_elements'] = $this->_getDefaultSectionsData();

		$data['sections'] = $this->_getThemeBuilderSectionManager()->getSectionDataForBuilder();
//		$data['global_styles'] = ffContainer()->getThemeFrameworkFactory()->getThemeBuilderGlobalStyles()->getElementGlobalStyles();
		if( $echo ) {
			echo json_encode( $data );
		} else {
			return $data;
		}

	}


	private function _getDefaultSectionsData() {
		$builderManager = $this->_getThemeBuilderManager();
		$builderManager->setIsEditMode( true);

		$section1Columns = '[ffb_section_0 unique_id="ppah7ph" data="%7B%22o%22%3A%7B%22gen%22%3A%7B%22ffsys-disabled%22%3A0%2C%22ffsys-info%22%3A%22%7B%7D%22%2C%22type%22%3A%22fg-container-large%22%2C%22no-padding%22%3A0%2C%22no-gutter%22%3A0%2C%22gutter-size%22%3A%22%22%2C%22match-col%22%3A0%2C%22force-fullwidth%22%3A0%7D%7D%7D"][ffb_column_1 unique_id="ppai5sk" data="%7B%22o%22%3A%7B%22gen%22%3A%7B%22ffsys-disabled%22%3A%220%22%2C%22ffsys-info%22%3A%22%7B%7D%22%2C%22xs%22%3A%2212%22%2C%22sm%22%3A%22unset%22%2C%22md%22%3A%2212%22%2C%22lg%22%3A%22unset%22%2C%22is-centered%22%3A%220%22%2C%22is-bg-clipped%22%3A%220%22%2C%22xs-last%22%3A%22no%22%2C%22sm-last%22%3A%22unset%22%2C%22md-last%22%3A%22unset%22%2C%22lg-last%22%3A%22unset%22%2C%22xs-offset%22%3A%22unset%22%2C%22sm-offset%22%3A%22unset%22%2C%22md-offset%22%3A%22unset%22%2C%22lg-offset%22%3A%22unset%22%2C%22xs-pull%22%3A%22unset%22%2C%22sm-pull%22%3A%22unset%22%2C%22md-pull%22%3A%22unset%22%2C%22lg-pull%22%3A%22unset%22%2C%22xs-push%22%3A%22unset%22%2C%22sm-push%22%3A%22unset%22%2C%22md-push%22%3A%22unset%22%2C%22lg-push%22%3A%22unset%22%2C%22xs-overlap%22%3A%22no%22%2C%22sm-overlap%22%3A%22unset%22%2C%22md-overlap%22%3A%22unset%22%2C%22lg-overlap%22%3A%22unset%22%7D%7D%7D"][/ffb_column_1][/ffb_section_0]';
		$section2Columns = '[ffb_section_0 unique_id="ppah7ph" data="%7B%22o%22%3A%7B%22gen%22%3A%7B%22ffsys-disabled%22%3A0%2C%22ffsys-info%22%3A%22%7B%7D%22%2C%22type%22%3A%22fg-container-large%22%2C%22no-padding%22%3A0%2C%22no-gutter%22%3A0%2C%22gutter-size%22%3A%22%22%2C%22match-col%22%3A0%2C%22force-fullwidth%22%3A0%7D%7D%7D"][ffb_column_1 unique_id="ppah96e" data="%7B%22o%22%3A%7B%22gen%22%3A%7B%22ffsys-disabled%22%3A%220%22%2C%22ffsys-info%22%3A%22%7B%7D%22%2C%22xs%22%3A%2212%22%2C%22sm%22%3A%22unset%22%2C%22md%22%3A%226%22%2C%22lg%22%3A%22unset%22%2C%22is-centered%22%3A%220%22%2C%22is-bg-clipped%22%3A%220%22%2C%22xs-last%22%3A%22no%22%2C%22sm-last%22%3A%22unset%22%2C%22md-last%22%3A%22unset%22%2C%22lg-last%22%3A%22unset%22%2C%22xs-offset%22%3A%22unset%22%2C%22sm-offset%22%3A%22unset%22%2C%22md-offset%22%3A%22unset%22%2C%22lg-offset%22%3A%22unset%22%2C%22xs-pull%22%3A%22unset%22%2C%22sm-pull%22%3A%22unset%22%2C%22md-pull%22%3A%22unset%22%2C%22lg-pull%22%3A%22unset%22%2C%22xs-push%22%3A%22unset%22%2C%22sm-push%22%3A%22unset%22%2C%22md-push%22%3A%22unset%22%2C%22lg-push%22%3A%22unset%22%2C%22xs-overlap%22%3A%22no%22%2C%22sm-overlap%22%3A%22unset%22%2C%22md-overlap%22%3A%22unset%22%2C%22lg-overlap%22%3A%22unset%22%7D%7D%7D"][/ffb_column_1][ffb_column_1 unique_id="ppai5sk" data="%7B%22o%22%3A%7B%22gen%22%3A%7B%22ffsys-disabled%22%3A%220%22%2C%22ffsys-info%22%3A%22%7B%7D%22%2C%22xs%22%3A%2212%22%2C%22sm%22%3A%22unset%22%2C%22md%22%3A%226%22%2C%22lg%22%3A%22unset%22%2C%22is-centered%22%3A%220%22%2C%22is-bg-clipped%22%3A%220%22%2C%22xs-last%22%3A%22no%22%2C%22sm-last%22%3A%22unset%22%2C%22md-last%22%3A%22unset%22%2C%22lg-last%22%3A%22unset%22%2C%22xs-offset%22%3A%22unset%22%2C%22sm-offset%22%3A%22unset%22%2C%22md-offset%22%3A%22unset%22%2C%22lg-offset%22%3A%22unset%22%2C%22xs-pull%22%3A%22unset%22%2C%22sm-pull%22%3A%22unset%22%2C%22md-pull%22%3A%22unset%22%2C%22lg-pull%22%3A%22unset%22%2C%22xs-push%22%3A%22unset%22%2C%22sm-push%22%3A%22unset%22%2C%22md-push%22%3A%22unset%22%2C%22lg-push%22%3A%22unset%22%2C%22xs-overlap%22%3A%22no%22%2C%22sm-overlap%22%3A%22unset%22%2C%22md-overlap%22%3A%22unset%22%2C%22lg-overlap%22%3A%22unset%22%7D%7D%7D"][/ffb_column_1][/ffb_section_0]';
		$section3Columns = '[ffb_section_0 unique_id="ppah7ph" data="%7B%22o%22%3A%7B%22gen%22%3A%7B%22ffsys-disabled%22%3A0%2C%22ffsys-info%22%3A%22%7B%7D%22%2C%22type%22%3A%22fg-container-large%22%2C%22no-padding%22%3A0%2C%22no-gutter%22%3A0%2C%22gutter-size%22%3A%22%22%2C%22match-col%22%3A0%2C%22force-fullwidth%22%3A0%7D%7D%7D"][ffb_column_1 unique_id="ppah96e" data="%7B%22o%22%3A%7B%22gen%22%3A%7B%22ffsys-disabled%22%3A%220%22%2C%22ffsys-info%22%3A%22%7B%7D%22%2C%22xs%22%3A%2212%22%2C%22sm%22%3A%22unset%22%2C%22md%22%3A%224%22%2C%22lg%22%3A%22unset%22%2C%22is-centered%22%3A%220%22%2C%22is-bg-clipped%22%3A%220%22%2C%22xs-last%22%3A%22no%22%2C%22sm-last%22%3A%22unset%22%2C%22md-last%22%3A%22unset%22%2C%22lg-last%22%3A%22unset%22%2C%22xs-offset%22%3A%22unset%22%2C%22sm-offset%22%3A%22unset%22%2C%22md-offset%22%3A%22unset%22%2C%22lg-offset%22%3A%22unset%22%2C%22xs-pull%22%3A%22unset%22%2C%22sm-pull%22%3A%22unset%22%2C%22md-pull%22%3A%22unset%22%2C%22lg-pull%22%3A%22unset%22%2C%22xs-push%22%3A%22unset%22%2C%22sm-push%22%3A%22unset%22%2C%22md-push%22%3A%22unset%22%2C%22lg-push%22%3A%22unset%22%2C%22xs-overlap%22%3A%22no%22%2C%22sm-overlap%22%3A%22unset%22%2C%22md-overlap%22%3A%22unset%22%2C%22lg-overlap%22%3A%22unset%22%7D%7D%7D"][/ffb_column_1][ffb_column_1 unique_id="ppai5sk" data="%7B%22o%22%3A%7B%22gen%22%3A%7B%22ffsys-disabled%22%3A%220%22%2C%22ffsys-info%22%3A%22%7B%7D%22%2C%22xs%22%3A%2212%22%2C%22sm%22%3A%22unset%22%2C%22md%22%3A%224%22%2C%22lg%22%3A%22unset%22%2C%22is-centered%22%3A%220%22%2C%22is-bg-clipped%22%3A%220%22%2C%22xs-last%22%3A%22no%22%2C%22sm-last%22%3A%22unset%22%2C%22md-last%22%3A%22unset%22%2C%22lg-last%22%3A%22unset%22%2C%22xs-offset%22%3A%22unset%22%2C%22sm-offset%22%3A%22unset%22%2C%22md-offset%22%3A%22unset%22%2C%22lg-offset%22%3A%22unset%22%2C%22xs-pull%22%3A%22unset%22%2C%22sm-pull%22%3A%22unset%22%2C%22md-pull%22%3A%22unset%22%2C%22lg-pull%22%3A%22unset%22%2C%22xs-push%22%3A%22unset%22%2C%22sm-push%22%3A%22unset%22%2C%22md-push%22%3A%22unset%22%2C%22lg-push%22%3A%22unset%22%2C%22xs-overlap%22%3A%22no%22%2C%22sm-overlap%22%3A%22unset%22%2C%22md-overlap%22%3A%22unset%22%2C%22lg-overlap%22%3A%22unset%22%7D%7D%7D"][/ffb_column_1][ffb_column_1 unique_id="ppake3v" data="%7B%22o%22%3A%7B%22gen%22%3A%7B%22ffsys-disabled%22%3A%220%22%2C%22ffsys-info%22%3A%22%7B%7D%22%2C%22xs%22%3A%2212%22%2C%22sm%22%3A%22unset%22%2C%22md%22%3A%224%22%2C%22lg%22%3A%22unset%22%2C%22is-centered%22%3A%220%22%2C%22is-bg-clipped%22%3A%220%22%2C%22xs-last%22%3A%22no%22%2C%22sm-last%22%3A%22unset%22%2C%22md-last%22%3A%22unset%22%2C%22lg-last%22%3A%22unset%22%2C%22xs-offset%22%3A%22unset%22%2C%22sm-offset%22%3A%22unset%22%2C%22md-offset%22%3A%22unset%22%2C%22lg-offset%22%3A%22unset%22%2C%22xs-pull%22%3A%22unset%22%2C%22sm-pull%22%3A%22unset%22%2C%22md-pull%22%3A%22unset%22%2C%22lg-pull%22%3A%22unset%22%2C%22xs-push%22%3A%22unset%22%2C%22sm-push%22%3A%22unset%22%2C%22md-push%22%3A%22unset%22%2C%22lg-push%22%3A%22unset%22%2C%22xs-overlap%22%3A%22no%22%2C%22sm-overlap%22%3A%22unset%22%2C%22md-overlap%22%3A%22unset%22%2C%22lg-overlap%22%3A%22unset%22%7D%7D%7D"][/ffb_column_1][/ffb_section_0]';
		$section4Columns = '[ffb_section_0 unique_id="ppah7ph" data="%7B%22o%22%3A%7B%22gen%22%3A%7B%22ffsys-disabled%22%3A0%2C%22ffsys-info%22%3A%22%7B%7D%22%2C%22type%22%3A%22fg-container-large%22%2C%22no-padding%22%3A0%2C%22no-gutter%22%3A0%2C%22gutter-size%22%3A%22%22%2C%22match-col%22%3A0%2C%22force-fullwidth%22%3A0%7D%7D%7D"][ffb_column_1 unique_id="ppah96e" data="%7B%22o%22%3A%7B%22gen%22%3A%7B%22ffsys-disabled%22%3A0%2C%22ffsys-info%22%3A%22%7B%7D%22%2C%22xs%22%3A%2212%22%2C%22sm%22%3A%22unset%22%2C%22md%22%3A3%2C%22lg%22%3A%22unset%22%2C%22is-centered%22%3A0%2C%22is-bg-clipped%22%3A0%2C%22xs-last%22%3A%22no%22%2C%22sm-last%22%3A%22unset%22%2C%22md-last%22%3A%22unset%22%2C%22lg-last%22%3A%22unset%22%2C%22xs-offset%22%3A%22unset%22%2C%22sm-offset%22%3A%22unset%22%2C%22md-offset%22%3A%22unset%22%2C%22lg-offset%22%3A%22unset%22%2C%22xs-pull%22%3A%22unset%22%2C%22sm-pull%22%3A%22unset%22%2C%22md-pull%22%3A%22unset%22%2C%22lg-pull%22%3A%22unset%22%2C%22xs-push%22%3A%22unset%22%2C%22sm-push%22%3A%22unset%22%2C%22md-push%22%3A%22unset%22%2C%22lg-push%22%3A%22unset%22%2C%22xs-overlap%22%3A%22no%22%2C%22sm-overlap%22%3A%22unset%22%2C%22md-overlap%22%3A%22unset%22%2C%22lg-overlap%22%3A%22unset%22%7D%7D%7D"][/ffb_column_1][ffb_column_1 unique_id="ppai5sk" data="%7B%22o%22%3A%7B%22gen%22%3A%7B%22ffsys-disabled%22%3A0%2C%22ffsys-info%22%3A%22%7B%7D%22%2C%22xs%22%3A%2212%22%2C%22sm%22%3A%22unset%22%2C%22md%22%3A3%2C%22lg%22%3A%22unset%22%2C%22is-centered%22%3A0%2C%22is-bg-clipped%22%3A0%2C%22xs-last%22%3A%22no%22%2C%22sm-last%22%3A%22unset%22%2C%22md-last%22%3A%22unset%22%2C%22lg-last%22%3A%22unset%22%2C%22xs-offset%22%3A%22unset%22%2C%22sm-offset%22%3A%22unset%22%2C%22md-offset%22%3A%22unset%22%2C%22lg-offset%22%3A%22unset%22%2C%22xs-pull%22%3A%22unset%22%2C%22sm-pull%22%3A%22unset%22%2C%22md-pull%22%3A%22unset%22%2C%22lg-pull%22%3A%22unset%22%2C%22xs-push%22%3A%22unset%22%2C%22sm-push%22%3A%22unset%22%2C%22md-push%22%3A%22unset%22%2C%22lg-push%22%3A%22unset%22%2C%22xs-overlap%22%3A%22no%22%2C%22sm-overlap%22%3A%22unset%22%2C%22md-overlap%22%3A%22unset%22%2C%22lg-overlap%22%3A%22unset%22%7D%7D%7D"][/ffb_column_1][ffb_column_1 unique_id="ppake3v" data="%7B%22o%22%3A%7B%22gen%22%3A%7B%22ffsys-disabled%22%3A0%2C%22ffsys-info%22%3A%22%7B%7D%22%2C%22xs%22%3A%2212%22%2C%22sm%22%3A%22unset%22%2C%22md%22%3A3%2C%22lg%22%3A%22unset%22%2C%22is-centered%22%3A0%2C%22is-bg-clipped%22%3A0%2C%22xs-last%22%3A%22no%22%2C%22sm-last%22%3A%22unset%22%2C%22md-last%22%3A%22unset%22%2C%22lg-last%22%3A%22unset%22%2C%22xs-offset%22%3A%22unset%22%2C%22sm-offset%22%3A%22unset%22%2C%22md-offset%22%3A%22unset%22%2C%22lg-offset%22%3A%22unset%22%2C%22xs-pull%22%3A%22unset%22%2C%22sm-pull%22%3A%22unset%22%2C%22md-pull%22%3A%22unset%22%2C%22lg-pull%22%3A%22unset%22%2C%22xs-push%22%3A%22unset%22%2C%22sm-push%22%3A%22unset%22%2C%22md-push%22%3A%22unset%22%2C%22lg-push%22%3A%22unset%22%2C%22xs-overlap%22%3A%22no%22%2C%22sm-overlap%22%3A%22unset%22%2C%22md-overlap%22%3A%22unset%22%2C%22lg-overlap%22%3A%22unset%22%7D%7D%7D"][/ffb_column_1][ffb_column_1 unique_id="ppal4ot" data="%7B%22o%22%3A%7B%22gen%22%3A%7B%22ffsys-disabled%22%3A0%2C%22ffsys-info%22%3A%22%7B%7D%22%2C%22xs%22%3A%2212%22%2C%22sm%22%3A%22unset%22%2C%22md%22%3A3%2C%22lg%22%3A%22unset%22%2C%22is-centered%22%3A0%2C%22is-bg-clipped%22%3A0%2C%22xs-last%22%3A%22no%22%2C%22sm-last%22%3A%22unset%22%2C%22md-last%22%3A%22unset%22%2C%22lg-last%22%3A%22unset%22%2C%22xs-offset%22%3A%22unset%22%2C%22sm-offset%22%3A%22unset%22%2C%22md-offset%22%3A%22unset%22%2C%22lg-offset%22%3A%22unset%22%2C%22xs-pull%22%3A%22unset%22%2C%22sm-pull%22%3A%22unset%22%2C%22md-pull%22%3A%22unset%22%2C%22lg-pull%22%3A%22unset%22%2C%22xs-push%22%3A%22unset%22%2C%22sm-push%22%3A%22unset%22%2C%22md-push%22%3A%22unset%22%2C%22lg-push%22%3A%22unset%22%2C%22xs-overlap%22%3A%22no%22%2C%22sm-overlap%22%3A%22unset%22%2C%22md-overlap%22%3A%22unset%22%2C%22lg-overlap%22%3A%22unset%22%7D%7D%7D"][/ffb_column_1][/ffb_section_0]';
		$section5Columns = '[ffb_section-bootstrap_0 unique_id="qr6d40m" data="%7B%22o%22%3A%7B%22gen%22%3A%7B%22ffsys-disabled%22%3A0%2C%22ffsys-info%22%3A%22%7B%7D%22%7D%7D%7D"][ffb_container_1 unique_id="qr6d7in" data="%7B%22o%22%3A%7B%22gen%22%3A%7B%22ffsys-disabled%22%3A0%2C%22ffsys-info%22%3A%22%7B%7D%22%2C%22type%22%3A%22fg-container-large%22%2C%22no-padding%22%3A0%7D%7D%7D"][ffb_row_2 unique_id="qr6dat3" data="%7B%22o%22%3A%7B%22gen%22%3A%7B%22ffsys-disabled%22%3A0%2C%22ffsys-info%22%3A%22%7B%7D%22%2C%22no-gutter%22%3A0%2C%22gutter-size%22%3A%22%22%2C%22match-col%22%3A0%2C%22match-col-sm%22%3A%22inherit%22%2C%22match-col-md%22%3A%22inherit%22%2C%22match-col-lg%22%3A%22inherit%22%7D%7D%7D"][ffb_column_3 unique_id="qr6dbka" data="%7B%22o%22%3A%7B%22gen%22%3A%7B%22ffsys-disabled%22%3A0%2C%22ffsys-info%22%3A%22%7B%7D%22%2C%22xs%22%3A%2212%22%2C%22sm%22%3A%22unset%22%2C%22md%22%3A6%2C%22lg%22%3A%22unset%22%2C%22not-equalize%22%3A0%2C%22is-centered%22%3A0%2C%22is-bg-clipped%22%3A0%2C%22xs-last%22%3A%22no%22%2C%22sm-last%22%3A%22unset%22%2C%22md-last%22%3A%22unset%22%2C%22lg-last%22%3A%22unset%22%2C%22xs-offset%22%3A%22unset%22%2C%22sm-offset%22%3A%22unset%22%2C%22md-offset%22%3A%22unset%22%2C%22lg-offset%22%3A%22unset%22%2C%22xs-pull%22%3A%22unset%22%2C%22sm-pull%22%3A%22unset%22%2C%22md-pull%22%3A%22unset%22%2C%22lg-pull%22%3A%22unset%22%2C%22xs-push%22%3A%22unset%22%2C%22sm-push%22%3A%22unset%22%2C%22md-push%22%3A%22unset%22%2C%22lg-push%22%3A%22unset%22%2C%22xs-overlap%22%3A%22no%22%2C%22sm-overlap%22%3A%22unset%22%2C%22md-overlap%22%3A%22unset%22%2C%22lg-overlap%22%3A%22unset%22%7D%7D%7D"][/ffb_column_3][ffb_column_3 unique_id="qr6ddl6" data="%7B%22o%22%3A%7B%22gen%22%3A%7B%22ffsys-disabled%22%3A0%2C%22ffsys-info%22%3A%22%7B%7D%22%2C%22xs%22%3A%2212%22%2C%22sm%22%3A%22unset%22%2C%22md%22%3A6%2C%22lg%22%3A%22unset%22%2C%22not-equalize%22%3A0%2C%22is-centered%22%3A0%2C%22is-bg-clipped%22%3A0%2C%22xs-last%22%3A%22no%22%2C%22sm-last%22%3A%22unset%22%2C%22md-last%22%3A%22unset%22%2C%22lg-last%22%3A%22unset%22%2C%22xs-offset%22%3A%22unset%22%2C%22sm-offset%22%3A%22unset%22%2C%22md-offset%22%3A%22unset%22%2C%22lg-offset%22%3A%22unset%22%2C%22xs-pull%22%3A%22unset%22%2C%22sm-pull%22%3A%22unset%22%2C%22md-pull%22%3A%22unset%22%2C%22lg-pull%22%3A%22unset%22%2C%22xs-push%22%3A%22unset%22%2C%22sm-push%22%3A%22unset%22%2C%22md-push%22%3A%22unset%22%2C%22lg-push%22%3A%22unset%22%2C%22xs-overlap%22%3A%22no%22%2C%22sm-overlap%22%3A%22unset%22%2C%22md-overlap%22%3A%22unset%22%2C%22lg-overlap%22%3A%22unset%22%7D%7D%7D"][/ffb_column_3][/ffb_row_2][/ffb_container_1][/ffb_section-bootstrap_0]';

		$data = array();
		$data['section_1_columns'] = $builderManager->renderButNotPrint( $section1Columns );
		$data['section_2_columns'] = $builderManager->renderButNotPrint( $section2Columns );
		$data['section_3_columns'] = $builderManager->renderButNotPrint( $section3Columns );
		$data['section_4_columns'] = $builderManager->renderButNotPrint( $section4Columns );
		$data['section_5_columns'] = $builderManager->renderButNotPrint( $section5Columns );

		return $data;
	}

	private function _wrapBuilderContentByParagraph( $builderContent ) {

		if( empty( $builderContent )  ){
			return $builderContent;
		}

		$builderContent = '[ffb_paragraph_0 unique_id="pk3copb" data="%7B%22o%22%3A%7B%22gen%22%3A%7B%22ffsys-disabled%22%3A%220%22%2C%22ffsys-info%22%3A%22%7B%7D%22%2C%22text-is-richtext%22%3A%220%22%7D%7D%7D"][ffb_param route="o gen text"]'.$builderContent.'[/ffb_param][ffb_param route="o gen align"]text-center[/ffb_param][/ffb_paragraph_0]';
		return $builderContent;
	}

	public function renderBuilderArea( $builderContent, $builderContentAsParagraph = false ) {
//		$this->_getThemeBuilderSectionManager()
//			->getSectionDataForBuilder();

		if( $builderContentAsParagraph ) {
			$builderContent = $this->_wrapBuilderContentByParagraph( $builderContent );
		}

		$builderManager = $this->_getThemeBuilderManager();
		$builderManager->setIsEditMode( true) ;

		echo '<div class="ffb-builder-wrapper clearfix">';
			echo '<div class="ffb-builder-loader">';
				echo '<div class="ffb-builder-loader-spinner spinner is-active" style="display:none;"></div>'; // styles are here so they are loaded super-fast - do NOT move these styles into CSS!
				echo '<div class="ffb-builder-loader-status-wrapper">';
					echo '<div class="ffb-builder-loader-status">Loading</div>';
					echo '<div class="ffb-builder-loader-info" style="display:none;">(Re)building Fresh Builder cache for this computer. This can take upto 3 minutes on slower servers and usually happens only after installing/updating the theme or when using a new computer. Once built, everything will be much faster.</div>';
				echo '</div>';
			echo '</div>';
			echo '<div class="ffb-builder" style="overflow: hidden; height: 0; visibility: hidden;">'; // styles are here so they are loaded super-fast - do NOT move these styles into CSS!
			echo '<div class="ffb-builder-toolbar clearfix">';
				echo '<div class="ffb-builder-toolbar-left">';
					echo '<div class="ffb-builder-toolbar-max-builder-btn ffb-builder-toolbar-btn"><i class="ff-font-awesome4 icon-arrows-alt"></i> Maximize</div>';
					echo '<div class="ffb-builder-toolbar-min-builder-btn ffb-builder-toolbar-btn"><i class="ff-font-awesome4 icon-close"></i> Close</div>';
				echo '</div>';	
				echo '<div class="ffb-builder-toolbar-right">';
					echo '<div class="ffb-builder-toolbar-cm-menu-btn ffb-builder-toolbar-btn ffb-builder-toolbar-cm-menu--action_shortcuts"><i class="ff-font-awesome4 icon-keyboard-o"></i> Shortcuts</div>';
					echo '<div class="ffb-builder-toolbar-cm-menu-btn ffb-builder-toolbar-btn ffb-builder-toolbar-cm-menu--action_options"><i class="ff-font-awesome4 icon-cog"></i> Options</div>';
				echo '</div>';
			echo '</div>';
			echo '<div class="ffb-canvas-wrapper">';
				echo '<div class="ffb-canvas" data-element-id="canvas">';
				echo '<div class="ffb-dropzone ffb-dropzone-canvas">';

				$builderManager->render( $builderContent );

				echo '</div>';
				echo '</div>';

				echo '<div class="ffb-canvas__add-section-button-wrapper action-add-section">';
				echo '<a href="" class="ffb-canvas__add-section-button"></a>';
				echo '<div class="ffb-canvas__add-section-items">';
				echo '<div class="ffb-canvas__add-section-item ffb-canvas__add-section-item__library" data-ffb-tooltip="Add Section From Library"></div>';
				echo '<div class="ffb-canvas__add-section-item ffb-canvas__add-section-item__element" data-ffb-tooltip="Add Element"></div>';
				// echo '&nbsp;&nbsp;';
				echo '<div class="ffb-canvas__add-section-item ffb-canvas__add-section-item__grid-1 ffb-canvas__add-section-item__grid" data-number-of-columns="1" data-ffb-tooltip="Add Section with 1 Empty Column"></div>';
				echo '<div class="ffb-canvas__add-section-item ffb-canvas__add-section-item__grid-2 ffb-canvas__add-section-item__grid" data-number-of-columns="2" data-ffb-tooltip="Add Section with 2 Empty Columns"></div>';
				echo '<div class="ffb-canvas__add-section-item ffb-canvas__add-section-item__grid-3 ffb-canvas__add-section-item__grid" data-number-of-columns="3" data-ffb-tooltip="Add Section with 3 Empty Columns"></div>';
				echo '<div class="ffb-canvas__add-section-item ffb-canvas__add-section-item__grid-4 ffb-canvas__add-section-item__grid" data-number-of-columns="4" data-ffb-tooltip="Add Section with 4 Empty Columns"></div>';
				echo '<div class="ffb-canvas__add-section-item ffb-canvas__add-section-item__grid-bs ffb-canvas__add-section-item__grid" data-number-of-columns="5" data-ffb-tooltip="Add Advanced Bootstrap Grid Section"></div>';
				// echo '<div class="ffb-canvas__add-section-item ffb-canvas__add-section-item__cancel" data-ffb-tooltip="Add Cancel"></div>';
				echo '</div>';
				echo '</div>';
			echo '</div>';
			echo '<div class="ffb-builder-toolbar-fixed-wrapper">';
				echo '<div class="ffb-builder-toolbar-fixed clearfix">';
					echo '<div class="ffb-builder-toolbar-fixed-left">';
						echo '<input type="submit" value="Quick Save" class="ffb-save-ajax ffb-main-save-ajax-btn ffb-builder-toolbar-fixed-btn">';
					echo '</div>';	
					echo '<div class="ffb-builder-toolbar-fixed-right">';
					echo '</div>';
				echo '</div>';
			echo '</div>';
			echo '<input type="hidden" class="ffb-settings-holder" value="'. $this->_getBuilderSettingsJSON() .'">';
			if( $this->_getBuilderSettings('saveAsPost') == false ) {
				echo '<input type="hidden" class="ffb-data-holder" name="ffb_data_holder" value="">';
			}
			echo '<div class="ffb-modal ffb-builder-shortcuts-popup">';
				echo '<div class="ffb-modal__vcenter-wrapper">';
					echo '<div class="ffb-modal__vcenter ffb-builder-shortcuts-popup-action-close">';
						echo '<div class="ffb-builder-shortcuts-popup-inner ffb-options">';

							echo '<h1>Keyboard Shortcuts</h1>';

							echo '<div class="row">';

								echo '<div class="col-md-6">';

									echo '<div class="ffb-builder-one-shortcut">';
										echo '<div class="ffb-builder-one-shortcut-key">E</div>';
										echo '<div class="ffb-builder-one-shortcut-label">Edit</div>';
									echo '</div>';
									echo '<div class="ffb-builder-one-shortcut">';
										echo '<div class="ffb-builder-one-shortcut-key">D</div>';
										echo '<div class="ffb-builder-one-shortcut-label">Duplicate</div>';
									echo '</div>';
									echo '<div class="ffb-builder-one-shortcut">';
										echo '<div class="ffb-builder-one-shortcut-key">C</div>';
										echo '<div class="ffb-builder-one-shortcut-label">Copy</div>';
									echo '</div>';
									echo '<div class="ffb-builder-one-shortcut">';
										echo '<div class="ffb-builder-one-shortcut-key">V</div>';
										echo '<div class="ffb-builder-one-shortcut-label">Paste</div>';
									echo '</div>';
									echo '<div class="ffb-builder-one-shortcut">';
										echo '<div class="ffb-builder-one-shortcut-key">T</div>';
										echo '<div class="ffb-builder-one-shortcut-label">Enable/Disable</div>';
									echo '</div>';
									echo '<div class="ffb-builder-one-shortcut">';
										echo '<div class="ffb-builder-one-shortcut-key">R</div>';
										echo '<div class="ffb-builder-one-shortcut-label">Remove</div>';
									echo '</div>';

								echo '</div>';

								echo '<div class="col-md-6">';
									
									echo '<div class="ffb-builder-one-shortcut">';
										echo '<div class="ffb-builder-one-shortcut-key">A</div>';
										echo '<div class="ffb-builder-one-shortcut-label">Add Below/After</div>';
									echo '</div>';
									echo '<div class="ffb-builder-one-shortcut">';
										echo '<div class="ffb-builder-one-shortcut-key">S</div>';
										echo '<div class="ffb-builder-one-shortcut-label">Quick Save</div>';
									echo '</div>';
									echo '<div class="ffb-builder-one-shortcut">';
										echo '<div class="ffb-builder-one-shortcut-key">Enter</div>';
										echo '<div class="ffb-builder-one-shortcut-label">Yes (OK)</div>';
									echo '</div>';
									echo '<div class="ffb-builder-one-shortcut">';
										echo '<div class="ffb-builder-one-shortcut-key">Space</div>';
										echo '<div class="ffb-builder-one-shortcut-label">Yes (OK)</div>';
									echo '</div>';
									echo '<div class="ffb-builder-one-shortcut">';
										echo '<div class="ffb-builder-one-shortcut-key">Esc</div>';
										echo '<div class="ffb-builder-one-shortcut-label">Cancel (Close)</div>';
									echo '</div>';
									echo '<div class="ffb-builder-one-shortcut">';
										echo '<div class="ffb-builder-one-shortcut-key">Q</div>';
										echo '<div class="ffb-builder-one-shortcut-label">Cancel (Close)</div>';
									echo '</div>';

									echo '<br>';

								echo '</div>';

							echo '</div>';

							echo '<button class="ffb-builder-shortcuts-popup-action-close ff-font-awesome4 icon-close"></button>';
						echo '</div>';
					echo '</div>';
				echo '</div>';
			echo '</div>';
			echo '</div>';
			echo '<div class="ffb-builder-info-area" style="display:none;">';
				echo '<div class="ffb-builder-version-hash">';
					echo ffContainer()->getThemeFrameworkFactory()->getSystemEnvironment()->getVersionHash();
				echo '</div>';
				echo '<div class="ffb-builder-color-lib">';
					echo json_encode( ffContainer()->getThemeFrameworkFactory()->getThemeBuilderColorLibrary()->getLibrary() );
				echo '</div>';

				$enableJsCache = 1;
				if( class_exists('ffThemeOptions') ) {
					$enableJsCache = ffThemeOptions::getQuery('layout')->get('enable-builder-jscache', 1);
				}


		 		echo '<div class="ffb-builder-jscache" data-builder-jscache="'. $enableJsCache .'">';
				echo '</div>';
				$themeBuilderGlobalStyles = ffContainer()->getThemeFrameworkFactory()->getThemeBuilderGlobalStyles();
				echo '<textarea class="ffb-builder-globalstyles">' . json_encode($themeBuilderGlobalStyles->getElementGlobalStyles() ) . '</textarea>';
			echo '</div>';
		echo '</div>';

		if( $this->_settings['saveAsPost'] == false ) {
			echo '<div style="display:none;">';
			wp_editor('', 'blank_id');
			echo '</div>';
		}

		$this->_getWPLayer()->add_action('admin_footer', array($this,'requireModalWindows'), 1);
	}

/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/
    public function requireBuilderScriptsAndStyles() {
	    $scriptEnqueuer = $this->_getFrameworkScriptLoader()->getScriptEnqueuer();
	    $styleEnqueuer = $this->_getFrameworkScriptLoader()->getStyleEnqueuer();

	    // framework scripts part
	    $scriptEnqueuer->getFrameworkScriptLoader()->disableOldFrsLibOptions();
	    $scriptEnqueuer->getFrameworkScriptLoader()
		    ->requireFfAdmin()
		    ->requireJqueryHotkeys()
		    ->requireBackboneDeepModel()
		    ->requireFrsLibOptions2();

	    $scriptEnqueuer->addScript('backbone');
	    $scriptEnqueuer->addScript('underscore');

	    $deps = array('backbone', 'underscore');

	    $styleEnqueuer->addStyleFramework('ffb-builder-animate-css', '/framework/themes/builder/metaBoxThemeBuilder/assets/extern/animate.css/animate.min.css');
	    $styleEnqueuer->addStyleFramework('ffb-builder-spectrum', '/framework/themes/builder/metaBoxThemeBuilder/assets/extern/jquery.spectrum/jquery.spectrum.css');
	    $styleEnqueuer->addStyleFramework('ffb-builder-style', '/framework/themes/builder/metaBoxThemeBuilder/assets/style.css');

	    $scriptEnqueuer->addScriptFramework('ffb-builder-scroll-lock', '/framework/themes/builder/metaBoxThemeBuilder/assets/extern/jquery.scrollLock.min.js', $deps, null, true);
	    $scriptEnqueuer->addScriptFramework('ffb-builder-jquery-ui-position', '/framework/themes/builder/metaBoxThemeBuilder/assets/extern/jquery.contextMenu/jquery.ui.position.min.js', $deps, null, true);
	    $scriptEnqueuer->addScriptFramework('ffb-builder-context-menu', '/framework/themes/builder/metaBoxThemeBuilder/assets/extern/jquery.contextMenu/jquery.contextMenu.min.js', $deps, null, true);
	    $scriptEnqueuer->addScriptFramework('ffb-builder-spectrum', '/framework/themes/builder/metaBoxThemeBuilder/assets/extern/jquery.spectrum/jquery.spectrum.min.js', $deps, null, true);
	    $scriptEnqueuer->addScriptFramework('ffb-builder-frslib-options-addons', '/framework/themes/builder/metaBoxThemeBuilder/assets/frslib-options-addons.js', $deps, null, true);
	    $scriptEnqueuer->addScriptFramework('ffb-builder-toScConvertor', '/framework/themes/builder/metaBoxThemeBuilder/assets/options-walker-toScConvertor.js', $deps, null, true);
	    $scriptEnqueuer->addScriptFramework('ffb-builder-element-picker', '/framework/themes/builder/metaBoxThemeBuilder/assets/elementPicker.js', $deps, null, true);
	    


	    $scriptEnqueuer->addScriptFramework('ffb-builder-class-canvas', '/framework/themes/builder/metaBoxThemeBuilder/assets/class.Canvas.js', $deps, null, true);
	    $scriptEnqueuer->addScriptFramework('ffb-builder-class-modal', '/framework/themes/builder/metaBoxThemeBuilder/assets/class.Modal.js', $deps, null, true);
	    $scriptEnqueuer->addScriptFramework('ffb-builder-class-vent', '/framework/themes/builder/metaBoxThemeBuilder/assets/class.Vent.js', $deps, null, true);
	    $scriptEnqueuer->addScriptFramework('ffb-builder-class-preview-view', '/framework/themes/builder/metaBoxThemeBuilder/assets/class.PreviewView.js', $deps, null, true);
	    $scriptEnqueuer->addScriptFramework('ffb-builder-class-element-model', '/framework/themes/builder/metaBoxThemeBuilder/assets/class.ElementModel.js', $deps, null, true);
	    $scriptEnqueuer->addScriptFramework('ffb-builder-class-element-view', '/framework/themes/builder/metaBoxThemeBuilder/assets/class.ElementView.js', $deps, null, true);
	    $scriptEnqueuer->addScriptFramework('ffb-builder-class-data-manager', '/framework/themes/builder/metaBoxThemeBuilder/assets/class.DataManager.js', $deps, null, true);
	    $scriptEnqueuer->addScriptFramework('ffb-builder-class-app', '/framework/themes/builder/metaBoxThemeBuilder/assets/class.App.js', $deps, null, true);
	    $scriptEnqueuer->addScriptFramework('ffb-builder-script', '/framework/themes/builder/metaBoxThemeBuilder/assets/main.js', $deps, null, true);

	    $this->_getFrameworkScriptLoader()->requireEnvironment( array('ffb-builder-class-app' ));
    }

	public function requireModalWindows() {
		$fwc = ffContainer();

		$fwc->getModalWindowFactory()->printModalWindowManagerLibraryColor();
		$fwc->getModalWindowFactory()->printModalWindowManagerLibraryIcon();
	}

/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/
    private function _getBuilderSettingsJSON() {
        $settingsJSON = json_encode( $this->_settings );
	    return $this->_getWPLayer()->esc_attr( $settingsJSON );
    }

/**********************************************************************************************************************/
/* ABSTRACT FUNCTIONS
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/
	public function setSaveAjaxOwner( $owner, $specification = null ) {
		$saveAjaxOwner = array();
		$saveAjaxOwner['owner'] = $owner;
		$saveAjaxOwner['specification'] = $specification;

		$this->_settings['saveAjaxOwner'] = $saveAjaxOwner;

		return $this;
	}

	public function setSaveAsPost( $saveAsPost ) {
		$this->_settings['saveAsPost'] = (int)$saveAsPost ;

		return $this;
	}

	private function _getBuilderSettings( $name, $default = null ) {
		if( $this->_currentAjaxRequest != null ) {
			$settings = $this->_currentAjaxRequest->getData('builderSettings');
		} else {
			$settings = $this->_settings;
		}

		if( isset( $settings[ $name ] ) ) {
			return $settings[ $name ];
		} else {
			return $default;
		}
	}
	public function addSetting( $name, $value ) {
		$this->_settings[ $name ] = $value;
		return $this;
	}


	/**
	 * @return ffFrameworkScriptLoader
	 */
	private function _getFrameworkScriptLoader() {
		return ffContainer()->getFrameworkScriptLoader();
	}

	/**
	 * @param ffFrameworkScriptLoader $frameworkScriptLoader
	 */
	private function _setFrameworkScriptLoader($frameworkScriptLoader) {
		$this->_frameworkScriptLoader = $frameworkScriptLoader;
	}

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
	 * @return ffThemeBuilderColorLibrary
	 */
	private function _getThemeColorLibrary() {
		return ffContainer()->getThemeFrameworkFactory()->getThemeBuilderColorLibrary();
	}

	/**
	 * @return ffThemeBuilderManager
	 */
	private function _getThemeBuilderManager() {
		return ffContainer()->getThemeFrameworkFactory()->getThemeBuilderManager();
	}

	/**
	 * @return ffThemeBuilderBlockManager
	 */
	private function _getThemeBuilderBlockManager() {
		return ffContainer()->getThemeFrameworkFactory()->getThemeBuilderBlockManager();
	}

	/**
	 * @return ffThemeBuilderElementManager
	 */
	private function _getThemeBuilderElementManager() {
		return ffContainer()->getThemeFrameworkFactory()->getThemeBuilderElementManager();
	}

	private function _getThemeBuilderSectionManager() {
		return ffContainer()->getThemeFrameworkFactory()->getThemeBuilderSectionManager();
	}

	/**
	 * @return ffAjaxDispatcher
	 */
	private function _getAjaxDispatcher() {
		return ffContainer()->getAjaxDispatcher();
	}
}