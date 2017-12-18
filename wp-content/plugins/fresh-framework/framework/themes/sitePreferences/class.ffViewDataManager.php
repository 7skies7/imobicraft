<?php

class ffViewDataManager extends ffBasicObject {
	/**********************************************************************************************************************/
	/* OBJECTS
	/**********************************************************************************************************************/
	/**
	 * @var ffWPLayer
	 */
	private $_WPLayer = null;

	/**
	 * @var ffDataStorage_WPPostMetas
	 */
	private $_postMeta = null;

	/**
	 * @var ffSiteMapper
	 */
	private $_siteMapper = null;

	/**
	 * @var ffOptionsCollection
	 */
	private $_templatesCollection = null;

	/**
	 * @var ffOptionsCollection
	 */
	private $_viewsMapCollection = null;


	/**********************************************************************************************************************/
	/* PRIVATE VARIABLES
	/**********************************************************************************************************************/


	/**********************************************************************************************************************/
	/* CONSTRUCT
	/**********************************************************************************************************************/
	public function __construct() {
		$this->_setSiteMapper( ffContainer()->getThemeFrameworkFactory()->getSitePreferencesFactory()->getSiteMapper() );

		$this->_setWPLayer( ffContainer()->getWPLayer());
		$this->_setPostMeta( ffContainer()->getDataStorageFactory()->createDataStorageWPPostMetas() );



		$templatesCollection = ffContainer()->getDataStorageFactory()->createOptionsCollection();
		$viewsMapCollection = ffContainer()->getDataStorageFactory()->createOptionsCollection();

		$templatesCollection->setNamespace('templates');
		$templatesCollection->addDefaultItemCallbacksFromThemeFolder();

		$viewsMapCollection->setNamespace('views_map');
		$viewsMapCollection->addDefaultItemCallbacksFromThemeFolder();

		$this->_setTemplatesCollection( $templatesCollection );
		$this->_setViewsMapCollection( $viewsMapCollection );
	}

	public function getCurrentHeader() {
		$currentLayoutInfo = $this->getCurrentLayoutInfo();


		$headerId = $currentLayoutInfo->get('header');

		if( $headerId == 'none' ) {
			return 'none';
		}

		$headersCollection = ffContainer()->getDataStorageFactory()->createOptionsCollection();
		$headersCollection->setNamespace('header');
		$headersCollection->addDefaultItemCallbacksFromThemeFolder();
		$headerDefault = $headersCollection->getItemById( $headerId );

		if( $headerDefault->getData() == null ) {
			$headerDefault = $headersCollection->getItemById('header_default');
		}

		return $headerDefault;
	}

	public function getCurrentBoxedWrapper() {
		$currentLayoutInfo = $this->getCurrentLayoutInfo();

		$headerId = $currentLayoutInfo->get('boxed_wrapper');

		if( $headerId == 'none' ) {
			return 'none';
		}

		$itemCollection = ffContainer()->getDataStorageFactory()->createOptionsCollection();
		$itemCollection->setNamespace('boxed_wrapper');
		$itemCollection->addDefaultItemCallbacksFromThemeFolder();
		$itemDefault = $itemCollection->getItemById( $headerId );

		if( $itemDefault->getData() == null ) {
			$itemDefault = $itemCollection->getItemById('default_boxed_wrapper');
		}

		return $itemDefault;
	}

	public function getCurrentTitleBar() {
		$currentLayoutInfo = $this->getCurrentLayoutInfo();

		$titleBarId = $currentLayoutInfo->get('titlebar');

		if( $titleBarId == 'none' ) {
			return 'none';
		}

		$titleBarsCollection = ffContainer()->getDataStorageFactory()->createOptionsCollection();
		$titleBarsCollection->setNamespace('titlebar');
		$titleBarsCollection->addDefaultItemCallbacksFromThemeFolder();
		$titleBarDefault = $titleBarsCollection->getItemById( $titleBarId );

		if( $titleBarDefault->getData() == null ) {
			$titleBarDefault = $titleBarsCollection->getItemById('titlebar_default');
		}

		return $titleBarDefault;
	}

	public function getCurrentFooter() {
		$currentLayoutInfo = $this->getCurrentLayoutInfo();

		$footerId = $currentLayoutInfo->get('footer');

		if( $footerId == 'none' ) {
			return 'none';
		}

		$footersCollection = ffContainer()->getDataStorageFactory()->createOptionsCollection();
		$footersCollection->setNamespace('footer');
		$footersCollection->addDefaultItemCallbacksFromThemeFolder();
		$footerDefault = $footersCollection->getItemById( $footerId );

		if( $footerDefault->getData() == null ) {
			$footerDefault = $footersCollection->getItemById('footer_default');
		}

		return $footerDefault;
	}


	private $_currentLayoutInfo = null;

	private $_consoleInfo = null;

	/**
	 * @return ffDataHolder
	 *
	 * go trough Post Single Meta -> Sitemap -> Theme Options
	 */
	public function getCurrentLayoutInfo() {

		if( $this->_currentLayoutInfo != null ) {
			return $this->_currentLayoutInfo;
		}

		/*----------------------------------------------------------*/
		/* CURRENT VIEW
		/*----------------------------------------------------------*/
		$currentView = $this->getCurrentViewInfo();


		if( $currentView == null ) {
			$layoutInfo = new ffDataHolder();
			$layoutInfo->header = 'inherited';
			$layoutInfo->titlebar = 'inherited';
			$layoutInfo->layout = 'inherited';
			$layoutInfo->footer = 'inherited';
			$layoutInfo->boxed_wrapper = 'inherited';
			if( in_array( $layoutInfo->header, array('inherit', 'inherited' ) ) ) {
				$layoutInfo->header = ffThemeOptions::getQuery()->getWithoutComparationDefault('theme_options global-layout header', 'header_default');
			}

			if( in_array( $layoutInfo->titlebar, array('inherit', 'inherited' ) ) ) {
				$layoutInfo->titlebar = ffThemeOptions::getQuery()->getWithoutComparationDefault('theme_options global-layout titlebar', 'titlebar_default');
			}

			if( in_array( $layoutInfo->footer, array('inherit', 'inherited' ) ) ) {
				$layoutInfo->footer = ffThemeOptions::getQuery()->getWithoutComparationDefault('theme_options global-layout footer', 'footer_default');
			}

			if( in_array( $layoutInfo->boxed_wrapper, array('inherit', 'inherited' ) ) ) {
				$layoutInfo->boxed_wrapper = ffThemeOptions::getQuery()->getWithoutComparationDefault('theme_options global-layout boxed_wrapper', 'none');
			}

			return $layoutInfo;
		}



//



		// we dont have any info for this
		if( $currentView == null ) {
			return null;
		}

		/*----------------------------------------------------------*/
		/* LAYOUT INFO
		/*----------------------------------------------------------*/
		$layoutInfo = new ffDataHolder();
		$layoutInfo->header = 'inherited';
		$layoutInfo->titlebar = 'inherited';
		$layoutInfo->layout = 'inherited';
		$layoutInfo->footer = 'inherited';
		$layoutInfo->boxed_wrapper = 'inherited';

		$layoutInfo->setMeta('viewName', $currentView->name);
		$layoutInfo->setMeta('viewType', $currentView->type );
		$layoutInfo->setMeta('viewSubType', $currentView->sub_type );

		/*----------------------------------------------------------*/
		/* LAYOUT CONSOLE INFO
		/*----------------------------------------------------------*/
		$consoleInfo = new ffDataHolder();
		$consoleInfo->header = 'inherited';
		$consoleInfo->header_set = 'inherited';

		$consoleInfo->titlebar = 'inherited';
		$consoleInfo->titlebar_set = 'inherited';

		$consoleInfo->footer = 'inherited';
		$consoleInfo->footer_set = 'inherited';

		$consoleInfo->boxed_wrapper = 'inherited';
		$consoleInfo->boxed_wrapper_set = 'inherited';

		$consoleInfo->layout = 'inherited';
		$consoleInfo->layout_set = 'inherited';

		$consoleInfo->viewName = $currentView->get('name');


		$placements = array('header', 'titlebar', 'footer', 'boxed_wrapper' );
		$inherit = array('inherit', 'inherited');



		if( $currentView->type == 'singular') {
			$currentPostId = $this->_getWPLayer()->get_current_post()->ID;

			$builderSettings = new ffDataHolder();
			$builderSettings->setDataJSON( $this->_getPostMeta()->getOption( $currentPostId, 'ff_builder_status'));

			$postLayoutSettings = new ffDataHolder($this->_getPostMeta()->getOptionCodedJSON( $currentPostId, 'ff-layout-settings', null ));

			$layoutInfo->header = $postLayoutSettings->get('settings header', 'inherited');
			$layoutInfo->titlebar = $postLayoutSettings->get('settings titlebar', 'inherited');
			$layoutInfo->layout = $postLayoutSettings->get('settings layout', 'inherited');
			$layoutInfo->footer = $postLayoutSettings->get('settings footer', 'inherited');
			$layoutInfo->boxed_wrapper = $postLayoutSettings->get('settings boxed_wrapper', 'inherited');

			$layoutInfo->builderUsage = $builderSettings->usage;
			$layoutInfo->builderPrintingMode = $postLayoutSettings->get('settings builder-printing-mode', 'in-content');


			foreach( $placements as $onePlacement ) {
				if( !in_array( $layoutInfo->$onePlacement, $inherit) ) {
					$setPlacement = $onePlacement .'_set';
					if( $consoleInfo->$setPlacement == 'inherited' ) {
						$consoleInfo->$setPlacement = 'singular';
					}
//
				}
			}

			$consoleInfo->layout_set = 'singular';


		}



		// is layout inherit from sitemap, or has been set up in post writepanel?
		if( $layoutInfo->layout == 'inherited' || $layoutInfo->layout == 'inherit' ) {

			$currentViewTemplate = $this->getTemplateForView( $currentView->name );



			$viewName = $currentView->name;
			$wpmlBridge =$this->_getWPLayer()->getWPMLBridge();
			if( $wpmlBridge->isWPMLActive() ) {
				$currentLangueage = $wpmlBridge->getCurrentLanguage();
				$viewName .= '-|-' . $currentLangueage;
			}

			$currentViewTemplate = $this->getTemplateForView( $viewName );




//			var_dump( $currentViewTemplate);
//			die();
			$consoleInfo->layout_set = 'sitepref';

		} else {
			$currentViewTemplate = $this->getTemplate( $layoutInfo->layout );
		}
		$currentViewTemplate = new ffDataHolder( $currentViewTemplate->getData());


		$consoleInfo->layout_name = $currentViewTemplate->get('name');
//		$consoleInfo->layout = $currentViewTemplate->get('id');


		/*----------------------------------------------------------*/
		/* GETTING INFOS FROM LAYOUTS
		/*----------------------------------------------------------*/
		if( $layoutInfo->layout != 'none' ) {
			if( $layoutInfo->header == 'inherited' || $layoutInfo->header == 'inherit' ) {
				$layoutInfo->header = $currentViewTemplate->get('options sitepref header');
			}

			if( $layoutInfo->titlebar == 'inherited' || $layoutInfo->titlebar == 'inherit' ) {
				$layoutInfo->titlebar = $currentViewTemplate->get('options sitepref titlebar');
			}

			if( $layoutInfo->footer == 'inherited' || $layoutInfo->footer == 'inherit' ) {
				$layoutInfo->footer = $currentViewTemplate->get('options sitepref footer');
			}

			if( $layoutInfo->boxed_wrapper == 'inherited' || $layoutInfo->boxed_wrapper == 'inherit' ) {
				$layoutInfo->boxed_wrapper = $currentViewTemplate->get('options sitepref boxed_wrapper', 'inherit');
			}

			foreach( $placements as $onePlacement ) {
				if( !in_array( $layoutInfo->$onePlacement, $inherit) ) {
					$setPlacement = $onePlacement .'_set';
					if( $consoleInfo->$setPlacement == 'inherited' ) {
						$consoleInfo->$setPlacement = 'sitepref';
					}
//
				}
			}
		}
		else {

			if( $layoutInfo->header == 'inherited' || $layoutInfo->header == 'inherit' ) {
				$layoutInfo->header = 'none';
			}

			if( $layoutInfo->titlebar == 'inherited' || $layoutInfo->titlebar == 'inherit' ) {
				$layoutInfo->titlebar = 'none';
			}

			if( $layoutInfo->footer == 'inherited' || $layoutInfo->footer == 'inherit' ) {
				$layoutInfo->footer = 'none';
			}

			if( $layoutInfo->boxed_wrapper == 'inherited' || $layoutInfo->boxed_wrapper == 'inherit' ) {
				$layoutInfo->boxed_wrapper = 'none';
			}

			foreach( $placements as $onePlacement ) {
//				if( !in_array( $layoutInfo->$onePlacement, $inherit) ) {
				$setPlacement = $onePlacement .'_set';
				if( $consoleInfo->$setPlacement == 'inherited' ) {
					$consoleInfo->$setPlacement = 'singular';
				}
//
//				}
			}
		}


		if( in_array( $layoutInfo->header, array('inherit', 'inherited' ) ) ) {
			$layoutInfo->header = ffThemeOptions::getQuery()->getWithoutComparationDefault('theme_options global-layout header', 'header_default');
		}

		if( in_array( $layoutInfo->titlebar, array('inherit', 'inherited' ) ) ) {
			$layoutInfo->titlebar = ffThemeOptions::getQuery()->getWithoutComparationDefault('theme_options global-layout titlebar', 'titlebar_default');
		}

		if( in_array( $layoutInfo->footer, array('inherit', 'inherited' ) ) ) {
			$layoutInfo->footer = ffThemeOptions::getQuery()->getWithoutComparationDefault('theme_options global-layout footer', 'footer_default');
		}

		if( in_array( $layoutInfo->boxed_wrapper, array('inherit', 'inherited' ) ) ) {
			$layoutInfo->boxed_wrapper = ffThemeOptions::getQuery()->getWithoutComparationDefault('theme_options global-layout boxed_wrapper', 'none');
		}

		if( ($layoutInfo->builderUsage == 'used' && $layoutInfo->builderPrintingMode == 'override-layout') || $layoutInfo->layout == 'none' ) {
			$layoutInfo->layout = 'singular';
			$layoutInfo->layoutContent = $this->_getWPLayer()->get_current_post()->post_content;
		} else if( $currentViewTemplate->get('builder') != null ) {
			$layoutInfo->layout = 'layout';
			$layoutInfo->layoutContent = $currentViewTemplate->get('builder');
		} else {
			$layoutInfo->layout = null;


		}

		foreach( $placements as $onePlacement ) {
			if( !in_array( $layoutInfo->$onePlacement, $inherit) ) {
				$setPlacement = $onePlacement .'_set';
				if( $consoleInfo->$setPlacement == 'inherited' ) {
					$consoleInfo->$setPlacement = 'themeopt';
				}
//
			}

			$consoleInfo->$onePlacement = $layoutInfo->$onePlacement;
		}


		$this->_currentLayoutInfo = $layoutInfo;
		$this->_consoleInfo = $consoleInfo;

		return $layoutInfo;
	}

	public function getConsoleInfo() {
		return $this->_consoleInfo;
	}

	private $_currentViewInfo = null;

	private function getCurrentViewInfo() {

		if( $this->_currentViewInfo != null ) {
			return $this->_currentViewInfo;
		}

		$currentView = new ffDataHolder();

		$identificator = ffContainer()->getFrontendQueryIdentificator();
		$WPLayer = ffContainer()->getWPLayer();

		$queryInformations = $identificator->getQueryInformations();


		if( !isset( $queryInformations->query) ) {
			return null;
		}


//		$viewName = null;

		if( $queryInformations->query == 'singular' ) {
			$currentView->type = 'singular';

			if( $queryInformations->post_type == 'post' ) {
				$currentView->name = 'post';
			} else if( $queryInformations->post_type == 'page' ) {
				$currentView->name = str_replace('.php', '', basename($WPLayer->get_page_template()) );
			} else {
				$currentView->name = $queryInformations->post_type;
			}

		}

		else if( $queryInformations->query == 'taxonomy' ) {
			$currentView->type = 'archive';
			$currentView->sub_type = 'taxonomy';


			if( $queryInformations->taxonomy_type == 'category' || $queryInformations->taxonomy_type == 'post_tag' ) {
				$currentView->name = 'blog-archive';
			}

			else if( $queryInformations->taxonomy_type == 'ff-portfolio-category' || $queryInformations->taxonomy_type == 'ff-portfolio-tag' ) {
				$currentView->type = 'archive';
				$currentView->sub_type = 'post_type_archive';
				$currentView->name = 'portfolio_archive';
			} else if( $queryInformations->taxonomy_type == 'product_cat' || $queryInformations->taxonomy_type == 'product_tag' ) {
				$currentView->type = 'archive';
				$currentView->sub_type = 'post_type_archive';
				$currentView->name = 'product_archive';
			} else {
				$currentView->name = $queryInformations->taxonomy_type;
//				var_Dump( $queryInformations );
//				die();
			}




		}
		else if( $queryInformations->query == 'author') {
			$currentView->type = 'archive';
			$currentView->sub_type = 'author';
			$currentView->name = 'blog-archive';
		}
		else if( $queryInformations->query == 'date' ) {
			$currentView->type = 'archive';
			$currentView->sub_type = 'date';
			$currentView->name = 'blog-archive';
		}
		else if( $queryInformations->query == 'search' ) {
//			var_Dump( $queryInformations );
//			die();
			if( $queryInformations->posts_found == 0 ) {
				$currentView->type='search-not';
				$currentView->name = 'search-not';
			} else {
				$currentView->type='search';
				$currentView->name = 'search';
			}
		} else if( $queryInformations->query == '404' ) {
			$currentView->type = '404';
			$currentView->name ='404';
		}

		else if( $queryInformations->query == 'home' ) {



//			$currentView->type = 'home';
//			$currentView->name ='home';
			$currentView->type = 'archive';
			$currentView->sub_type = 'author';
			$currentView->name = 'blog-archive';
		}

		else if( $queryInformations->query == 'post_type_archive' ) {
			$currentView->type = 'archive';
			$currentView->sub_type = 'post_type_archive';
			$currentView->name = $queryInformations->type . '_archive';
		}




		$this->_currentViewInfo = $currentView;
		return $currentView;
	}


	/**********************************************************************************************************************/
	/* PUBLIC FUNCTIONS
	/**********************************************************************************************************************/
	public function getTemplate( $templateId ) {
		return $this->_getTemplatesCollection()->getItemById( $templateId );
	}

	public function setTemplate( $templateId, $item ) {
		return $this->_getTemplatesCollection()->setItemToDb( $templateId, $item );
	}

	public function addTemplate( $templateId, $templateName ) {
		$this->_getTemplatesCollection()->setItemToDb( $templateId, array('name'=> $templateName ) );
	}

	public function deleteTemplate( $templateId ) {
		return $this->_getTemplatesCollection()->deleteItemFromDB( $templateId );
	}

	public function saveTemplatesCollection() {
		$this->_getTemplatesCollection()->save();
	}


	public function getTemplateForView( $viewId ) {

//		var_dump( $viewId );
//		die();
//		$wpmlBridge =$this->_getWPLayer()->getWPMLBridge();
//		if( $wpmlBridge->isWPMLActive() ) {
//			$currentLangueage = $wpmlBridge->getCurrentLanguage();
//			$viewId .= '-|-' . $currentLangueage;
//		}



		$parents = $this->_getSiteMapper()
			->getViewParents( $viewId  );


		$assignedTemplate = null;

		foreach( $parents as $key => $oneParent ) {
			$assignedTemplate = $this->_getViewsMapCollection()->getItemById( $oneParent );

			if( $assignedTemplate->getData() != null ) {
				$assignedTemplate = $this->_getTemplatesCollection()->getItemById( $assignedTemplate->getData() );

				if( $key > 0 ) {
					$viewInfo = $this->_getSiteMapper()->getViewFromId( $oneParent );

					$assignedTemplate->setAttr('inherited', true);
					$assignedTemplate->setAttr('parent-name', $viewInfo['name'] );
					$assignedTemplate->setAttr('parent-id', $viewInfo['id'] );
				} else {
					$assignedTemplate->setAttr('inherited', false);
				}

				break;
			}
		}

		return $assignedTemplate;
	}

	public function assignTemplateForView( $templateId, $viewId ) {
		$this->_getViewsMapCollection()->setItemToDb( $viewId, $templateId);
	}

	public function deleteTemplateForView( $viewId ) {
		$this->_getViewsMapCollection()->deleteItemFromDB( $viewId );
	}


	public function getViewsWithMappedItems() {


		$views = array();


		foreach( $this->_getViewsMapCollection() as $itemId =>  $oneItemToViewMap ) {

			$viewId = $oneItemToViewMap->getData();
//			var_Dump( $viewId );
			if( !isset($views[ $viewId ]) ) {
				$views[$viewId] = array();
			}



			$views[ $viewId ][] = $itemId;
		}

		foreach( $this->_getTemplatesCollection() as $itemId => $oneItem ) {
			if( isset( $views[ $itemId ] ) ) {
				$oneItem->set('assigned_items', $views[$itemId] );
			}
		}

//		var_dump( $this->_getTemplatesCollection() );
//		die();

		return $this->_getTemplatesCollection();

	}


//
	public function getOptionsForView( $viewId ) {
		$viewData = $this->getDataForView( $viewId );
		return $viewData->get('options');

	}

	public function getTemplatesCollection() {
		return $this->_getTemplatesCollection();
	}

	public function getViewsMapCollection() {
		return $this->_getViewsMapCollection();
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
	 * @return ffOptionsCollection
	 */
	private function _getViewsMapCollection() {
		return $this->_viewsMapCollection;
	}

	/**
	 * @param ffOptionsCollection $viewsMapCollection
	 */
	private function _setViewsMapCollection($viewsMapCollection) {
		$this->_viewsMapCollection = $viewsMapCollection;
	}

	/**
	 * @return ffOptionsCollection
	 */
	private function _getTemplatesCollection() {
		return $this->_templatesCollection;
	}

	/**
	 * @param ffOptionsCollection $viewsDataCollection
	 */
	private function _setTemplatesCollection($templatesCollection) {
		$this->_templatesCollection = $templatesCollection;
	}

	/**
	 * @return ffSiteMapper
	 */
	private function _getSiteMapper() {
		return $this->_siteMapper;
	}

	/**
	 * @param ffSiteMapper $siteMapper
	 */
	private function _setSiteMapper($siteMapper) {
		$this->_siteMapper = $siteMapper;
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
	 * @return ffDataStorage_WPPostMetas
	 */
	private function _getPostMeta() {
		return $this->_postMeta;
	}

	/**
	 * @param ffDataStorage_WPPostMetas $postMeta
	 */
	private function _setPostMeta($postMeta) {
		$this->_postMeta = $postMeta;
	}


}