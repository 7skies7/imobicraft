<?php

class ffSiteMapper extends ffBasicObject {
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/
	/**
	 * @var ffCollection
	 */
	private $_viewData = null;

	/**
	 * @var ffWPLayer
	 */
	private $_WPLayer = null;

	/**
	 * @var ffWPMLBridge
	 */
	private $_wpmlBridge = null;

	/**
	 * @var null
	 */
	private $_siteMap = null;

/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
	public function __construct() {
		$this->_setViewData( ffContainer()->createNewCollectionAdvanced() );
		$this->_setWPLayer( ffContainer()->getWPLayer() );
		$this->_setWpmlBridge( ffContainer()->getWPLayer()->getWPMLBridge());
	}




/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/
	public function getViewFromId( $viewId ) {
		$siteMap = $this->getSiteMap();
		$foundItem = null;
		foreach( $siteMap as $id => $item ){
			if( $item['id'] == $viewId )  {
				$foundItem = $item;
				break;
			}
		}
		return $foundItem;
	}

	public function getViewParents( $viewId ) {
		$viewIdArray = explode( '-|-', $viewId );

		$numberOfItems = count( $viewIdArray );

		$parents = array();
		for( $i = 0; $i < $numberOfItems; $i ++ ) {
			$parents[ $i ] = array();
		}

		foreach( $viewIdArray as $key => $oneViewPart ) {
			$inverted = $numberOfItems - ($key+1);

			for( $i = 0; $i <= $inverted; $i ++ ) {
				$parents[$i][] = $oneViewPart;
			}
		}

		$toReturn = array();
		foreach( $parents as $oneParent ) {
			$toReturn[] = implode('-|-', $oneParent);
		}

		return $toReturn;
	}


	public function getSiteMap() {
		if( $this->_siteMap == null ) {
			$this->_initPages();
			$this->_initBlog();

			$this->_initCustomTypes();
			$this->_initRest();

			$this->_siteMap = $this->_getViewData();
		}

		return $this->_siteMap;
	}

	public function getSiteMapHierarchical() {
		$siteMap = $this->getSiteMap();

		if( !$this->_getWpmlBridge()->isWPMLActive() ) {
			return $siteMap;
		}

		$toReturn = array();

		foreach( $siteMap as $oneSite ) {
			switch( $oneSite['type'] ) {
				case 'top':
					$oneSite['child'] = array();
					$toReturn[ $oneSite['id'] ] = $oneSite;
					break;

				case 'lang':
					$toReturn[ $oneSite['parent'] ]['child'][] = $oneSite;
					break;
			}
		}

		return $toReturn;

//		var_dump($this->_getWpmlBridge()->isWPMLActive());
//		var_Dump( $siteMap);
//		die();
	}

/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/
	private function _initRest() {
		$this->_addOneView('Search (Results)', 'search');
		$this->_addOneView('Search (No Results)', 'search-not');
		$this->_addOneView('404', '404');
	}

	private function _addOneView( $name, $id ) {
//		$oneView = array( 'name'=> $name, 'id'=>$id) ;
		$this->_addView($name, $id, 'top');
		$this->_addLanguages( $name, $id );
	}

	private function _initCustomTypes() {
		$taxonomyIdentificator = ffContainer()->getCustomTaxonomyIdentificator();
		$postIdentificator = ffContainer()->getCustomPostTypeIdentificator();

		$postTypes = $postIdentificator->resetBlacklist()->getActivePublicPostTypesCollection();

//		$jsTree = $this->_getJsTreeDataBuilder();
		$bannedPostTypes = array();
		$bannedPostTypes[] = 'revision';
		$bannedPostTypes[] = 'post';
		$bannedPostTypes[] = 'page';
		$bannedPostTypes[] = 'webhooks';
		$bannedPostTypes[] = 'media';
		$bannedPostTypes[] = 'variations';
		$bannedPostTypes[] = 'orders';
		$bannedPostTypes[] = 'refunds';
		$bannedPostTypes[] = 'coupons';
//		$bannedPostTypes[] = 'product';
		$bannedPostTypes[] = 'attachment';

		$bannedPostTypes[] = 'ff-footer';
		$bannedPostTypes[] = 'ff-header';
		$bannedPostTypes[] = 'ff-content-block';
		$bannedPostTypes[] = 'ff-content-block-a';
		$bannedPostTypes[] = 'ff-template';

		$itemArray = array();

		foreach( $postTypes as $onePostType ) {

			if( in_array( $onePostType->id, $bannedPostTypes ) ) {
				continue;
			}
			$taxonomyIdentificator->resetBlacklist();
			$taxonomyIdentificator->addBlacklistedTaxonomy('pa_color');
			$taxonomyIdentificator->addBlacklistedTaxonomy('product_shipping_class');
			$taxonomyIdentificator->addBlacklistedTaxonomy('product_type');

			$taxonomyIdentificator->addBlacklistedTaxonomy('ff-portfolio-tag');
			$taxonomyIdentificator->addBlacklistedTaxonomy('ff-portfolio-category');


			$taxonomyIdentificator->addBlacklistedTaxonomy('product_cat');
			$taxonomyIdentificator->addBlacklistedTaxonomy('product_tag');

			$taxonomiesForPost = $taxonomyIdentificator->getActiveTaxonomyCollectionForPostType( $onePostType->id);

			foreach( $taxonomiesForPost as $oneTax ) {
				$this->_addView( $oneTax->label, $oneTax->id, 'top');
				$this->_addLanguages( $oneTax->label, $oneTax->id );
			}

			$this->_addView( $onePostType->label . ' Archive', $onePostType->id.'_archive', 'top');
			$this->_addView( $onePostType->label . ' Single', $onePostType->id, 'top');
			$this->_addLanguages( $onePostType->label, $onePostType->id );


		}


//		return $jsTree;
	}

	private function _addView( $name, $id, $type ) {
		$oneView = array('name'=>$name, 'id'=>$id, 'type' => $type );

		$this->_getViewData()->addItem( $oneView );
	}

	private function _initBlog() {

		$oneView = array();
		$oneView['name'] = 'Blog Archive';
		$oneView['id'] = 'blog-archive';
		$oneView['type'] = 'top';

//		$this->_addView('Blog Archive', 'blog-archive', 'top');
		$this->_getViewData()->addItem( $oneView );

		$this->_getViewNameForLanguages($oneView);

		$oneView = array();
		$oneView['name'] = 'Blog Single';
		$oneView['id'] = 'post';
		$oneView['type'] = 'top';

		$this->_getViewData()->addItem( $oneView );
		$this->_getViewNameForLanguages($oneView);

	}


	private function _initPages() {
		$pageTemplates =  $this->_getWPLayer()->get_page_templates();

		$pageTemplates = array_merge( array('Page'=>'page'), $pageTemplates );

		foreach( $pageTemplates as $templateName => $templateId ) {
			$oneView = array();

			$templateIdWithoutPHP = str_replace( '.php', '', $templateId );

			$oneView['name'] = $templateName;
			$oneView['id'] = $templateIdWithoutPHP;
			$oneView['type'] = 'top';

			$this->_getViewData()->addItem( $oneView );
			$this->_getViewNameForLanguages( $oneView );
		}

	}

	private function _addLanguages( $name, $id ) {
		$oneView = array( 'name' => $name, 'id' => $id );
		$this->_getViewNameForLanguages( $oneView );
	}

	private function _getViewNameForLanguages( $oneView ) {
		$languages = $this->_getLanguagesArray();


		if( empty( $languages ) ){
			return null;
		}

		foreach( $languages as $code => $name ) {
			$newView = array();
			$newView['name'] = $oneView['name'] . ' - ' . $name;
			$newView['id'] = $oneView['id'] .'-|-' . $code;
			$newView['type'] = 'lang';
			$newView['parent'] = $oneView['id'];

			$this->_getViewData()->addItem( $newView );
		}
	}

	private function _getLanguagesArray(){
		$toReturn = array();
		$languages = $this->_getWpmlBridge()->getLanguages();

		if( empty( $languages) ) {
			return $toReturn;
		}

		foreach( $languages as $code => $value ) {
			$toReturn[ $code ] = $value['display_name'];
		}

		return $toReturn;
	}

/**********************************************************************************************************************/
/* ABSTRACT FUNCTIONS
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/
	/**
	 * @return ffCollection
	 */
	private function _getViewData() {
		return $this->_viewData;
	}

	/**
	 * @param ffCollection $viewData
	 */
	private function _setViewData($viewData) {
		$this->_viewData = $viewData;
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
	 * @return ffWPMLBridge
	 */
	private function _getWpmlBridge() {
		return $this->_wpmlBridge;
	}

	/**
	 * @param ffWPMLBridge $wpmlBridge
	 */
	private function _setWpmlBridge($wpmlBridge) {
		$this->_wpmlBridge = $wpmlBridge;
	}



}