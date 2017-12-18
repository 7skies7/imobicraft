<?php

abstract class ffThemeBuilderElement extends ffBasicObject {
    const DATA_ID = 'id';
    const DATA_NAME = 'name';
    const DATA_HAS_DROPZONE = 'has_dropzone';
    const DATA_CONNECT_WITH = 'connect_with';
    const DATA_HAS_CONTENT_PARAMS = 'has_content_params';
	const DATA_PICKER_MENU_ID = 'picker_menu_id';
	const DATA_PICKER_ITEM_WIDTH = 'data_picker_item_width';
	const DATA_PICKER_TAGS = 'picker_tags';
	const DATA_CAN_BE_CACHED = 'can_be_cached';
	const DATA_HAS_SYSTEM_TABS = 'has_system_tabs';
	const DATA_HAS_WRAPPER = 'has_wrapper';
	const DATA_IS_HIDDEN = 'data_is_hidden';


/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/
    /**
     * @var ffOptionsQueryDynamic
     */
    private $_queryDynamic = null;

    /**
     * @var ffWPLayer
     */
    private $_WPLayer = null;

    /**
     * @var ffThemeBuilderOptionsExtender
     */
    private $_optionsExtender = null;

    /**
     * @var ffThemeBuilderBlockManager
     */
    private $_themeBuilderBlockManager = null;

	/**
	 * @var ffThemeBuilderAssetsRenderer
	 */
	private $_assetsRenderer = null;

	/**
	 * @var ffThemeBuilderShortcodesStatusHolder
	 */
	protected $_statusHolder = null;


	/**
	 * @var ffThemeBuilderGlobalStyles
	 */
	protected $_globalStyles = null;

/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/
    /**
     * Settings like "name, id, has dropzone" are stored here. See the constants at the top of this file
     * @var array()
     */
    private $_data = array();

	/**
	 * @var callable
	 */
	private $_doShortcodeCallback = null;

	/**
	 * Is caching mode
	 * @var bool
	 */
	protected $_isCachingMode = false;

	/**
	 * List of elements which are declined in the dropzone
	 * @var null
	 */
	protected $_dropzoneElementBlacklist = array();

	/**
	 * List of elements, which are accepted in the dropzone
	 * @var null
	 */
	protected $_dropzoneElementWhitelist = array();

	/**
	 * List of elements, which could be parents of this element
	 * @var array
	 */
	protected $_parentElementWhitelist = array();


    /**
     * If the element is printed in backend builder or fronted (For user)
     * @var bool
     */
	protected $_isEditMode = false;

	protected $_defaultOptionsData = null;

    protected $_elementOptionsStructure = null;

	protected $_variationCounter = 0;

	protected $_color = '';

/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
    public function __construct(
		    ffThemeBuilderOptionsExtender $optionsExtender,
			ffOptionsQueryDynamic $query,
		    ffWPLayer $WPLayer,
			ffThemeBuilderBlockManager $themeBuilderBlockManager,
			ffThemeBuilderAssetsRenderer $assetsRenderer,
			ffThemeBuilderShortcodesStatusHolder $statusHolder,
			ffThemeBuilderGlobalStyles $globalStyles
        )
    {
        $this->_setOptionsExtender( $optionsExtender );
        $this->_initData();

	    $query->setGetOptionsCallback( array($this, 'getElementOptionsStructure') );
	    $query->setIteratorValidationCallback( array( $this, 'queryIteratorValidation') );
	    $query->setIteratorStartCallback( array( $this, 'queryIteratorStart') );
	    $query->setIteratorEndCallback( array( $this, 'queryIteratorEnd') );

	    $query->setIteratorBeginningCallback( array( $this, 'queryIteratorBeginning'));
	    $query->setIteratorEndingCallback( array( $this, 'queryIteratorEnding'));

	    $query->setIsPrintingMode(true);


		$this->_setQueryDynamic($query);
        $this->_setWPLayer( $WPLayer );
        $this->_setThemeBuilderBlockManager( $themeBuilderBlockManager );
	    $this->_setAssetsRenderer( $assetsRenderer );
	    $this->_setStatusHolder( $statusHolder );
	    $this->_setGlobalStyles( $globalStyles );
    }
/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/
	public function getIsHidden() {
		return $this->_getData( ffThemeBuilderElement::DATA_IS_HIDDEN, false);
	}

	public function getCanBeCached() {
		$cachingStack = $this->_getStatusHolder()->getCustomStackCurrentValue('disableCaching');

		if( $cachingStack ) {
			return false;
		}

		return $this->_getData( ffThemeBuilderElement::DATA_CAN_BE_CACHED, true);
	}

    public function getPreviewImageUrl() {
        return $this->getBaseUrlOfElement() . '/preview.jpg';
    }

    public function getBaseUrlOfElement() {
        $className = get_class( $this );
        $classUrl = $this->_getClassLoader()->getClassUrl( $className );
        $toReturn = dirname( $classUrl );

        return $toReturn;
    }

	public function getBasePathOfElement() {
		$className = get_class( $this );
		$classPath = $this->_getClassLoader()->getClassPath( $className );
		$toReturn = dirname( $classPath );

		return $toReturn;
	}

	/**
	 * Get the element options as encoded json string
	 * @return string
	 */
    public function getElementOptionsJSONString() {
	    $themeBuilderCache = ffContainer()->getThemeFrameworkFactory()->getThemeBuilderCache();

	    $elementOptionsJSON = $themeBuilderCache->getElementOptionsFromCache( $this->getID() );

	    if( $elementOptionsJSON == null ) {
		    $elementOptionsJSON = json_encode( $this->getElementOptionsJSON() );
		    $themeBuilderCache->setElementOptionsToCache( $this->getID(), $elementOptionsJSON );
	    }

        return $elementOptionsJSON;
    }

	public function getElementOptionsValues() {
		$structure = $this->getElementOptionsStructure();
		$arrayConvertor = $this->_getOptionsFactory()->createOptionsArrayConvertor(null, $structure );
		$data = $arrayConvertor->walk();
		return $data;
	}

    /**
     * get the options json (basic options, the default ones)
     * @return array
     */
    public function getElementOptionsJSON() {
        $structure = $this->getElementOptionsStructure();
        $jsonConvertor = $this->_getOptionsFactory()->createOptionsPrinterJSONConvertor( null, $structure );
        $json = $jsonConvertor->walk();
        return $json;
    }

	/**
	 * Return default options data. If its not presented anywhere, then we generate it from basic options structure
	 * @return array
	 */
    public function getElementOptionsData() {

	    if( file_exists( $this->getBasePathOfElement() . '/default.json') ) {
		    $dataJSON = file_get_contents( $this->getBasePathOfElement() . '/default.json' );
		    $data = json_decode( $dataJSON );
		    return $data;
	    } else {
		    $structure = $this->getElementOptionsStructure();
		    $arrayConvertor = $this->_getOptionsFactory()->createOptionsArrayConvertor( null, $structure );

		    $this->_defaultOptionsData = $arrayConvertor->walk();
		    return $this->_defaultOptionsData;
	    }

//        if( $this->_defaultOptionsData == null ) {
//
//        }

    }

    /**
     * get the options structure (Basic options, the default ones)
     * @return ffOneStructure
     */
    abstract public function getElementOptionsStructure( $injectBlocksWithoutReference = false );

	protected $_renderWrapper = false;

	protected function _setRenderWrapper( $value ) {
		$this->_renderWrapper = $value;
	}

	private function _hasWrapper() {
		if( $this->_getData( ffThemeBuilderElement::DATA_HAS_WRAPPER, true) ) {
			return true;
		} else {
			if( $this->_renderWrapper ) {
				$this->_renderWrapper = false;
				return true;
			}
		}

		return false;
	}

	private function _getSystemOptions( $query ) {
		$systemOptionsJSON = $query->getWithoutComparationDefault('o gen ffsys-info', '{}');
		$systemOptions = new ffDataHolder();
		$systemOptions->setDataJSON( $systemOptionsJSON );
		$systemOptions->elementId = $this->getID();
		$systemOptions->globalStyleName = $this->_getGlobalStyles()->getElementGlobalStyleName( $systemOptions->elementId, $systemOptions->get('global-style', 0) );

		return $systemOptions;
	}


	/**
	 * @param $data
	 * @param $contentParams
	 *
	 * @return ffOptionsQueryDynamic
	 */
	private function _getCompleteQuery( $data, $contentParams ) {
		$query = $this->_getQueryDynamic();
		$query->setElementClassName( get_class( $this) );
		$query->setData( $data );

		//Content params are stored in shortcodes and their value is in the content of the shortcode
		if( $this->hasContentParams() && $contentParams != null ) {
			foreach( $contentParams as $route => $value ) {
				$query->setDataValue( $route, $value );
			}
		}

		return $query;
	}

	private function _getCachingHashForThisElement( $elementHash ) {
		$statusHolderHash = $this->_getStatusHolder()->getStatusHolderHash();
		$dataHash = $elementHash;
		$colorlibHash = ffContainer()->getThemeFrameworkFactory()->getThemeBuilderColorLibrary()->getLibraryHash();
		$globalStyleHash = md5(json_encode( ffContainer()->getThemeFrameworkFactory()->getThemeBuilderGlobalStyles()->getAllStylesForElement( $this->getID() ) ) );

		$finalHash = md5( $statusHolderHash . $dataHash . $colorlibHash . $globalStyleHash );

		return $finalHash;
	}

	protected function _enqueueScriptsAndStyles( $query ) {

	}

	/**
	 * @param $query ffOptionsQueryDynamic
	 * @return bool
	 */
	protected function _checkIfElementCanBeCached( $query ) {
		return true;
	}

    /**
     * @param $data
     * @param $content
     * @param $uniqueId
     * @param $query
     * @param $elementHash string whole shortcode md5 (only if the element can be cached)
     * @return string|void
     */
	private function _renderElementWithCaching( $data, $content, $uniqueId, $query, $elementHash ) {

        $cache = ffContainer()->getDataStorageCache();

        $cachingNamespace = ffThemeBuilderCache::CACHE_NAMESPACE;
        $cachingName = $name = $this->getID() . '-' . $uniqueId;

        // load all styles and scripts, no matter if cached or not
        $this->_enqueueScriptsAndStyles( $query );
        $finalHash = '';
        // can we run caching?
        if(
            FF_DEVELOPER_MODE == false &&  // is not developer mode
            $this->getCanBeCached() &&  // element supports caching
			$this->_checkIfElementCanBeCached( $query ) && // figure out if the element can be cached
            $this->_getData(ffThemeBuilderElement::DATA_HAS_DROPZONE, true ) == false // element does not have any dropzones
        ) {
            /*
             * Hash of:
             * - status holder
             * - color library
             * - global styles (old)
             */

            $finalHash = $this->_getCachingHashForThisElement( $elementHash );
            // load currently cached files
            $elementCachedData = $cache->getOption( $cachingNamespace, $cachingName );

            if( $elementCachedData != null ) {
                $elementCachedData = json_decode( $elementCachedData, true );
            }

            $cacheIsGood = true;
            if( $elementCachedData == null ) $cacheIsGood = false;
            if( !isset( $elementCachedData['hash'] ) ) $cacheIsGood = false;
            if( $elementCachedData['hash'] != $finalHash ) $cacheIsGood = false;

//            ffStopWatch::addVariableDump( $elementCachedData['global_styles_used'] );

            // are there used any global styles?
            if( isset($elementCachedData['global_styles_used']) ) {
                if( isset( $elementCachedData['global_styles_hash'] ) ) {
                    $currentGlobalStylesHash = $this->_getGlobalStyles()->getGlobalStyleHash( $elementCachedData['global_styles_used'] );

                    if( $currentGlobalStylesHash != $elementCachedData['global_styles_hash'] ) {
                        $cacheIsGood = false;
                    }

                } else {
                    $cacheIsGood = false;
                }
            }

            // serve files from cache
            if( $cacheIsGood ) {
                // CSS - serve and check if is the CSS file still up to date?
                $timeout = ffContainer()->getThemeFrameworkFactory()->getPrivateUpdateManager()->getCacheTimeout();
                if( isset( $elementCachedData['css'] ) && !empty( $elementCachedData['css'] ) && !($timeout != null && $timeout < time())) {
                    $this->getAssetsRenderer()->createCssRule()->setContent($elementCachedData['css']);
                }

                // JS - server
                if( isset( $elementCachedData['js'] ) && !empty( $elementCachedData['js'] ) ) {
                    $this->getAssetsRenderer()->createJavascriptCode()->setCode($elementCachedData['js']);
                }

                return $elementCachedData['content'];
            }
        }

        // cache is apparently not good
//        $elementContent = $this->_renderJustTheElement( $data, $content, $uniqueId, $query );
        $elementData['content'] = $this->_renderJustTheElement( $data, $content, $uniqueId, $query );


        if(
            FF_DEVELOPER_MODE == false &&  // is not developer mode
            $this->getCanBeCached() &&  // element supports caching
            $this->_getData(ffThemeBuilderElement::DATA_HAS_DROPZONE, true ) == false // element does not have any dropzones
        ) {
            $elementData['hash'] = $finalHash;
            $elementData['css'] = $this->getAssetsRenderer()->getCssAsString();
            $elementData['js'] = $this->getAssetsRenderer()->getJavascriptAsString();

            /*----------------------------------------------------------*/
            /* GLOBAL STYLES HUSTLING
            /*----------------------------------------------------------*/
            $usedGlobalStyles = $this->_getStatusHolder()->getElementSpecificStack( ffThemeBuilderShortcodesStatusHolder::USED_GLOBAL_STYLES );
            if( !empty( $usedGlobalStyles) ) {
                $usedGlobalStyles = array_keys( $usedGlobalStyles );
                $usedGlobalStylesHash = $this->_getGlobalStyles()->getGlobalStyleHash( $usedGlobalStyles );

                $elementData['global_styles_used'] = $usedGlobalStyles;
                $elementData['global_styles_hash'] = $usedGlobalStylesHash;
            }


            $timeout = ffContainer()->getThemeFrameworkFactory()->getPrivateUpdateManager()->getCacheTimeout();

            if(  $timeout != null && $timeout < time() ) {
                $cacheData['css'] = '';
            }

            $elementDataJSON = json_encode( $elementData );
            $cache->setOption( $cachingNamespace, $cachingName, $elementDataJSON );
        }

        return $elementData['content'];


        return;
		$namespace = ffThemeBuilderCache::CACHE_NAMESPACE;
		$name = $this->getID() . '-' . $uniqueId;
		$cache = ffContainer()->getDataStorageCache();
		$this->_enqueueScriptsAndStyles( $query );

		if( FF_DEVELOPER_MODE == false && $this->getCanBeCached() && $this->_getData(ffThemeBuilderElement::DATA_HAS_DROPZONE, true ) == false ) {

			ffStopWatch::timeStart();
			$finalHash = $this->_getCachingHashForThisElement( $elementHash );
			$cacheData = $cache->getOption($namespace, $name);
			ffStopWatch::addVariableDump( ffStopWatch::timeEnd());
			if( $cacheData != null ) {
				$cacheData = json_decode( $cacheData, true );
			}

//            $cacheData = null;

			if( $cacheData == null || !isset($cacheData['hash']) || $cacheData['hash'] != $finalHash ) {
				$cacheData['content'] = $this->_renderJustTheElement( $data, $content, $uniqueId, $query );
//                $styles = $this->_getStatusHolder()->getElementSpecificStack( ffThemeBuilderShortcodesStatusHolder::USED_GLOBAL_STYLES );
//                ffStopWatch::addVariableDump( 'sulin' );

				$cacheData['hash'] = $finalHash;
				$cacheData['css'] = $this->getAssetsRenderer()->getCssAsString();
				$cacheData['js'] = $this->getAssetsRenderer()->getJavascriptAsString();

				$timeout = ffContainer()->getThemeFrameworkFactory()->getPrivateUpdateManager()->getCacheTimeout();

				if(  $timeout != null && $timeout < time() ) {
					$cacheData['css'] = '';
				}

				$cacheDataJSON = json_encode( $cacheData );
				$cache->setOption( $namespace, $name, $cacheDataJSON );





                return $cacheData['content'];
			} else {

				$timeout = ffContainer()->getThemeFrameworkFactory()->getPrivateUpdateManager()->getCacheTimeout();

				if( isset( $cacheData['css'] ) && !empty( $cacheData['css'] ) && !($timeout != null && $timeout < time())) {
					$this->getAssetsRenderer()->createCssRule()->setContent($cacheData['css']);
				}
//
				if( isset( $cacheData['js'] ) && !empty( $cacheData['js'] ) ) {
					$this->getAssetsRenderer()->createJavascriptCode()->setCode($cacheData['js']);
				}

                $styles = $this->_getStatusHolder()->getElementSpecificStack( ffThemeBuilderShortcodesStatusHolder::USED_GLOBAL_STYLES );
                ffStopWatch::addVariableDump( 'xxx' );



                return $cacheData['content'];
			}

		}

		$element = $this->_renderJustTheElement( $data, $content, $uniqueId, $query );
		$timeout = ffContainer()->getThemeFrameworkFactory()->getPrivateUpdateManager()->getCacheTimeout();

		if(  $timeout != null && $timeout < time() ) {
			$this->getAssetsRenderer()->getCssCollection()->remove(true);
		}

        $styles = $this->_getStatusHolder()->getElementSpecificStack( ffThemeBuilderShortcodesStatusHolder::USED_GLOBAL_STYLES );
        ffStopWatch::addVariableDump($styles );

		return $element;

	}

	private function _renderJustTheElement( $data, $content, $uniqueId, $query ) {
		/*----------------------------------------------------------*/
		/* PRINTING
		/*----------------------------------------------------------*/
		ob_start();
		$this->_render( $query->get('o gen'), $content, $query->getOnlyData(), $uniqueId );
		$content = ob_get_contents();
		ob_end_clean();

		// re-set data to query, because of same elements nested inside
		$query->setElementClassName( get_class( $this) );
		$query->setData( $data );

		/*----------------------------------------------------------*/
		/* PRINTING SYSTEM THINGS
		/*----------------------------------------------------------*/
		// if it has wrapper, we have to apply all our system things on it
		if( $this->_hasWrapper()  ) {

			$elementHelper = $this->_getAssetsRenderer()->getElementHelper();
			// unique css class
			$elementHelper->addAttribute('class', $this->_getCssSelectorFromUniqueId($uniqueId));
			$elementHelper->parse($content);

			if ($this->_getData(ffThemeBuilderElement::DATA_HAS_SYSTEM_TABS, true)) {

				$this->_getBlock(ffThemeBuilderBlock::BOX_MODEL)->get($query->get('o'));
				$this->_getBlock(ffThemeBuilderBlock::ADVANCED_TOOLS)->get($query->get('o'));
				$this->_getBlock(ffThemeBuilderBlock::COLORS)->setParam(ffThemeBuilderBlock_Colors::PARAM_TEXT_COLOR, $this->_color)->get($query->get('o'));
				$this->_getBlock(ffThemeBuilderBlock::CUSTOM_CODES)->get($query->get('o'));
			}

			$content = $elementHelper->get();
		}



		return $content;
	}

    public function render( $data, $content = null, $uniqueId = null, $contentParams = null , $elementHash = null ) {

		$query = $this->_getCompleteQuery( $data, $contentParams);

	    /*----------------------------------------------------------*/
	    /* RENDERING THE ADMIN
	    /*----------------------------------------------------------*/
	    if( $this->_isEditMode ) {
		    ob_start();
		    $this->_renderAdmin( $query->getMustBeQueryNotEmpty('o gen'), $content, $query->getOnlyData(), $uniqueId);
		    $content = ob_get_contents();
		    ob_end_clean();
		    return $content;
	    }

	    /*----------------------------------------------------------*/
	    /* DISABLING THE ELEMENT
	    /*----------------------------------------------------------*/
	    if( $query->getWithoutComparationDefault('o gen ffsys-disabled', 0) ) {
		    return '';
	    }

	    /*----------------------------------------------------------*/
	    /* STACKING AND CONFIGURATION BEFORE PRINTING
	    /*----------------------------------------------------------*/
	    $systemOptions = $this->_getSystemOptions( $query );

	    // stacking the elements
	    $this->_getStatusHolder()->addElementToStack( $this->getID() );
	    $this->_getStatusHolder()->addSystemOptionsToStack( $systemOptions );
	    $this->_getAssetsRenderer()->addSelectorToCascade( $this->_getCssSelectorFromUniqueId( $uniqueId ) );

	    // text color inheritance
	    $textColor = $this->_getBlock( ffThemeBuilderBlock::COLORS)->setParam( ffThemeBuilderBlock_Colors::PARAM_TEXT_COLOR, $this->_color)->returnOnlyTextColor()->get( $query->get('o') );

	    if( !empty($textColor) ) {
		    $this->_getStatusHolder()->addTextColorToStack( $textColor );
	    }

	    $content = $this->_renderElementWithCaching($data, $content, $uniqueId, $query, $elementHash);

	    /*----------------------------------------------------------*/
	    /* REMOVING THINGS FROM STACK
	    /*----------------------------------------------------------*/
	    // remove stacking from selector cascade
	    $this->_getAssetsRenderer()->removeSelectorFromCascade();

	    // remove text color inheritance, if its presented
	    if( !empty($textColor) ) {
		    $this->_getStatusHolder()->removeTextColorFromStack();
	    }

	    $this->_getStatusHolder()->removeSystemOptionsFromStack();
	    // remove lement from stack
	    $this->_getStatusHolder()->removeElementFromStack();

	    return $content;
    }


/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/
    public function setIsEditMode( $value ) {
        $this->_isEditMode = $value;
        $this->_getThemeBuilderBlockManager()->setIsEditMode( $value );
    }

    public function getIsEditMode() {
        return $this->_isEditMode;
    }

    public function getID() {
        return $this->_getData( ffThemeBuilderElement::DATA_ID );
    }

    public function getData() {
        return $this->_data;
    }

	/**
	 * Data json for the javascript side
	 * @return array
	 */
    public function getElementDataForBuilder() {

	    $className = get_class( $this );

        $data = array();
        $data['id'] = $this->_getData( ffThemeBuilderElement::DATA_ID );
        $data['name'] = $this->_getData( ffThemeBuilderElement::DATA_NAME );
	    $data['defaultColor'] = $this->_color;

        $data['optionsStructure'] = $this->getElementOptionsJSONString();

	    $data['picker'] = array();
	    $data['picker']['menuId'] = $this->_getData( ffThemeBuilderElement::DATA_PICKER_MENU_ID );
	    $data['picker']['tags'] = $this->_getData( ffThemeBuilderElement::DATA_PICKER_TAGS );
	    $data['picker']['itemWidth'] = $this->_getData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 1 );

        $data['functions'] = array();
        $data['functions']['renderContentInfo_JS'] = $this->_getJSFunction('_renderContentInfo_JS');

        $data['defaultHtml'] = $this->_getDefaultHTML();

        $data['previewImage'] = $this->getPreviewImageUrl();

	    $data['dropzoneWhitelistedElements'] = $this->_dropzoneElementWhitelist;
	    $data['dropzoneBlacklistedElements'] = $this->_dropzoneElementBlacklist;

	    $data['parentWhitelistedElement'] = $this->_parentElementWhitelist;
//
        return $data;
    }

    public function hasContentParams() {
        return $this->_getData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, false);
    }

	public function getAssetsRenderer() {
		return $this->_getAssetsRenderer();
	}

/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/
	protected function _reset() {
		$this->_variationCounter = 0;
	}

    protected function _getDefaultHTML() {
        $query = $this->_getQueryDynamic()->setData(null);
        $data = $this->getElementOptionsData();


        ob_start();
        $this->_renderAdmin( $query, '', $data, null );
        $defaultHTML = ob_get_contents();
        ob_end_clean();

        return $defaultHTML;
    }

	protected function _getCssSelectorFromUniqueId( $uniqueId ) {
		return 'ffb-id-'. $uniqueId;
	}
    protected abstract function _initData();

	/**
	 * @param $s ffOneStructure|ffThemeBuilderOptionsExtender
	 * @return mixed
	 */
    protected abstract function _getElementGeneralOptions( $s );
    protected abstract function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId );
    protected abstract function _renderAdmin( ffOptionsQueryDynamic $query, $content, $data, $uniqueId );
    protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {}
	public abstract function queryIteratorValidation( $query, $key );
	public abstract function queryIteratorStart( $query, $key );
	public abstract function queryIteratorEnd( $query, $key );

	public abstract function queryIteratorBeginning( $query );
	public abstract function queryIteratorEnding( $query );


    protected abstract function _renderContentInfo_JS();

    protected function _getJSFunction( $functionName ) {
        ob_start();
            call_user_func( array( $this, $functionName) );
        $content = ob_get_contents();
        ob_end_clean();

        $content = str_replace('<script data-type="ffscript">', '', $content);
        $content = str_replace('</script data-type="ffscript">', '', $content);

        return $content;
    }

    protected function _setData( $name, $value ) {
        $this->_data[ $name ] = $value;
    }

    protected function _doShortcode( $content ) {
	    if( $this->_doShortcodeCallback == null ) {
		    return null;
	    } else {
		    return call_user_func( $this->_doShortcodeCallback, $content );
	    }
    }

    protected function _getData( $name, $default = null ) {
        if( isset( $this->_data[ $name ] ) ) {
            return $this->_data[ $name ];
        } else {
            return $default;
        }
    }

    /**
     * @param $blockClassName
     * @return ffThemeBuilderBlock
     */
    protected function _getBlock( $blockClassName ) {
        $block = $this->_getThemeBuilderBlockManager()->getBlock( $blockClassName );
	    $block->setAssetsRenderer( $this->_getAssetsRenderer() );
	    $block->setStatusHolder( $this->_statusHolder );
        return $block;
    }


/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/
    /**
     * @return ffOptionsQueryDynamic
     */
    private function _getQueryDynamic()
    {
        return $this->_queryDynamic;
    }

    /**
     * @param ffOptionsQueryDynamic $queryDynamic
     */
    private function _setQueryDynamic($queryDynamic)
    {
        $this->_queryDynamic = $queryDynamic;
    }

    /**
     * @return ffWPLayer
     */
    protected function _getWPLayer()
    {
        return $this->_WPLayer;
    }

    /**
     * @param ffWPLayer $WPLayer
     */
    private function _setWPLayer($WPLayer)
    {
        $this->_WPLayer = $WPLayer;
    }

    /**
     * @return ffThemeBuilderOptionsExtender
     */
    protected function _getOptionsExtender()
    {
        return $this->_optionsExtender;
    }

    /**
     * @param ffThemeBuilderOptionsExtender $optionsExtender
     */
    private function _setOptionsExtender($optionsExtender)
    {
        $this->_optionsExtender = $optionsExtender;
    }

    /**
     * @return ffThemeBuilderBlockManager
     */
    private function _getThemeBuilderBlockManager() {
        return $this->_themeBuilderBlockManager;
    }

    /**
     * @param ffThemeBuilderBlockManager $themeBuilderBlockManager
     */
    private function _setThemeBuilderBlockManager($themeBuilderBlockManager) {
        $this->_themeBuilderBlockManager = $themeBuilderBlockManager;
    }

	/**
	 * @return ffClassLoader
	 */
	private function _getClassLoader() {
		return ffContainer()->getClassLoader();
	}

	/**
	 * @return ffOptions_Factory
	 */
	protected function _getOptionsFactory() {
		return ffContainer()->getOptionsFactory();
	}

	/**
	 * @return ffThemeBuilderAssetsRenderer
	 */
	protected function _getAssetsRenderer() {
		return $this->_assetsRenderer;
	}

	/**
	 * @param ffThemeBuilderAssetsRenderer $assetsRenderer
	 */
	protected function _setAssetsRenderer($assetsRenderer) {
		$this->_assetsRenderer = $assetsRenderer;
	}

	public function setDoShortcodeCallback( $callback ) {
		$this->_doShortcodeCallback = $callback;
	}

	/**
	 * @return boolean
	 */
	protected function _getIsCachingMode() {
		return $this->_isCachingMode;
	}

	/**
	 * @param boolean $isCachingMode
	 */
	public function setIsCachingMode($isCachingMode) {
		$this->_isCachingMode = $isCachingMode;
	}

	/**
	 * @return ffThemeBuilderShortcodesStatusHolder
	 */
	protected function _getStatusHolder() {
		return $this->_statusHolder;
	}

	/**
	 * @param ffThemeBuilderShortcodesStatusHolder $statusHolder
	 */
	private function _setStatusHolder($statusHolder) {
		$this->_statusHolder = $statusHolder;
	}

	/**
	 * @return ffThemeBuilderGlobalStyles
	 */
	private function _getGlobalStyles() {
		return $this->_globalStyles;
	}

	/**
	 * @param ffThemeBuilderGlobalStyles $globalStyles
	 */
	private function _setGlobalStyles($globalStyles) {
		$this->_globalStyles = $globalStyles;
	}
}