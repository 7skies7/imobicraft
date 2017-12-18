<?php

class ffThemeBuilderShortcodesWalker extends ffBasicObject {
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/
    /**
     * @var ffThemeBuilderElementManager
     */
    private $_themeBuilderElementManager = null;

	/**
	 * @var ffCollection[ffThemeBuilderCssRule]
	 */
	private $_cssCollection = null;

	/**
	 * @var ffCollection[ffThemeBuilderJavascriptCode]
	 */
	private $_jsCollection = null;

    /**
     * @var ffWPLayer
     */
    private $_WPLayer = null;

/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/
    private $_modePrintOnlyText = false;

    private $_isEditMode = false;

	private $_isCachingMode = false;

    private $_shortcodesRegistered = false;

    private $_contentParams = array();

    private $_renderedCss = '';

	private $_renderedJs = '';

	private $_usedTags = null;

	private $_regex = null;

	private $_noncacheableElements = null;

	private $_shortcodeDataFilter = null;

/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/

    public function __construct( ffThemeBuilderElementManager $themeBuilderElementManager,
                                $cssCollection,
								$jsCollection
    ) {
        $this->_setThemeBuilderElementManager( $themeBuilderElementManager );
        $this->_setWPLayer( ffContainer()->getWPLayer() );

	    $this->_setCssCollection( $cssCollection );
	    $this->_setJsCollection( $jsCollection );
    }

/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/
	public function render( $content ) {
		echo $this->get( $content );
	}

	public function get( $content ) {
		$this->_reset();

		$temporaryPostHolder = $this->_getWPLayer()->get_current_post();
		$result =  $this->doShortcode( $content );
		$this->_getWPLayer()->set_current_post( $temporaryPostHolder );

		
		return $result;
	}

	public function getSpecificElement( $elementId, $data, $uniqueId = null ) {
		ob_start();
		$this->renderSpecificElement( $elementId, $data, $uniqueId );
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}

	public function renderSpecificElement( $elementId, $data, $uniqueId = null)  {

		$this->_reset();

		if( $uniqueId == null ) {
			$uniqueId = rand();
		}

		$element = $this->_getThemeBuilderElementManager()->getElementById( $elementId );

		if( $element != null ) {
			$element->setDoShortcodeCallback( array( $this, 'doShortcode') );
		}

		if( $this->_getIsCachingMode() ) {
			$element->setIsCachingMode( true );
		}

		if( $data == null ) {
			$data = $element->getElementOptionsData();
		}

		if( $this->_getShortcodeDataFilter() != null ) {
			$data = call_user_func( $this->_getShortcodeDataFilter(), $data, $elementId );
		}

		$result = $element->render( $data, null, $uniqueId, null);
		$css = $element->getAssetsRenderer()->getCssCollection();
		$js = $element->getAssetsRenderer()->getJSCollection();



		$this->_getCssCollection()->addCollection( $css, true);
		$this->_getJsCollection()->addCollection( $js, true);

		$element->getAssetsRenderer()->reset();

		if( $this->_getIsCachingMode() ) {
			$element->setIsCachingMode( false );
		}

		return $result;
	}



/**********************************************************************************************************************/
/* SHORTCODES BRO
/**********************************************************************************************************************/
	/**
	 * Main shortcodes function
	 * @param $content
	 * @return mixed
	 */
	public function doShortcode( $content ) {
//		$usedTags = $this->_getUsedTags();
//		$shortcodeRegex = $this->_getRegex();
//
//		if( $usedTags == null ) {
			// TODO rozpoznat content blocks
			$usedTags  = $this->_findUsedTags( $content );
			$this->_setUsedTags( $usedTags );

			$shortcodeRegex = $this->_getShortcodeRegexp( $usedTags );
			$this->_setRegex( $shortcodeRegex );

//		}

		$content = preg_replace_callback( "/$shortcodeRegex/", array($this,'_ourShortcodeCalback'), $content );
		return $content;
	}

	private function _getShortcodeRegexp( $tagNames ) {

		$tagregexp = join( '|', array_map('preg_quote', $tagNames) );

		// WARNING! Do not change this regex without changing do_shortcode_tag() and strip_shortcode_tag()
		// Also, see shortcode_unautop() and shortcode.js.
		return
			'\\['                              // Opening bracket
			. '(\\[?)'                           // 1: Optional second opening bracket for escaping shortcodes: [[tag]]
			. "($tagregexp)"                     // 2: Shortcode name
			. '(?![\\w-])'                       // Not followed by word character or hyphen
			. '('                                // 3: Unroll the loop: Inside the opening shortcode tag
			.     '[^\\]\\/]*'                   // Not a closing bracket or forward slash
			.     '(?:'
			.         '\\/(?!\\])'               // A forward slash not followed by a closing bracket
			.         '[^\\]\\/]*'               // Not a closing bracket or forward slash
			.     ')*?'
			. ')'
			. '(?:'
			.     '(\\/)'                        // 4: Self closing tag ...
			.     '\\]'                          // ... and closing bracket
			. '|'
			.     '\\]'                          // Closing bracket
			.     '(?:'
			.         '('                        // 5: Unroll the loop: Optionally, anything between the opening and closing shortcode tags
			.             '[^\\[]*+'             // Not an opening bracket
			.             '(?:'
			.                 '\\[(?!\\/\\2\\])' // An opening bracket not followed by the closing shortcode tag
			.                 '[^\\[]*+'         // Not an opening bracket
			.             ')*+'
			.         ')'
			.         '\\[\\/\\2\\]'             // Closing shortcode tag
			.     ')?'
			. ')'
			. '(\\]?)';                          // 6: Optional second closing brocket for escaping shortcodes: [[tag]]
	}

	/**
	 * Parse shortcodes - function directly from wordpress core
	 * @param $m
	 * @return mixed|string
	 */
	private function _ourShortcodeCalback( $m ) {

		if ( $m[1] == '[' && $m[6] == ']' ) {
			return substr($m[0], 1, -1);
		}

		$tag = $m[2];
		$atts = shortcode_parse_atts( $m[3] );
		$content = null;
		if( isset( $m[5] ) ) {
			$content = $m[5];
		}
		return call_user_func( array($this, 'shortcodesCallback'), $atts, $content, $tag, $m[0] );
	}

	/**
	 * Function which handle parsed shortcode
	 * @param $atts
	 * @param $content
	 * @param $shortcodeNameWithDepth
	 * @return string|void
	 */
	public function shortcodesCallback( $atts, $content, $shortcodeNameWithDepth, $originalCode ) {
        if( $this->_isModePrintOnlyText() ) {
            if( $shortcodeNameWithDepth == 'ffb_param' ) {
                return $content . ' ';
            } else {
                return $this->doShortcode( $content );
            }
        } else {
            if( $shortcodeNameWithDepth == 'ffb_param' ) {
                return $this->getContentsParamCallback( $atts, $content, $shortcodeNameWithDepth, $originalCode );
            } else {
                return $this->_printShortcode( $atts, $content, $shortcodeNameWithDepth, $originalCode );
            }
        }
	}

	/**
	 * Find which shortcode tags are used, which starts with ffb_
	 * @param $content
	 * @return array
	 */
	private function _findUsedTags( $content ) {
		return $this->_getWPLayer()->findUsedShortcodesFreshbuilder( $content );
	}

	/**
	 * Its backend / front end
	 * @param $value
	 */
    public function setIsEditMode( $value ) {
        $this->_isEditMode = $value;
        $this->_getThemeBuilderElementManager()->setIsEditMode( $value );
    }

	/**
	 * Content params are stored here
	 * @param $atts
	 * @param $content
	 * @param $shortcodeName
	 */
    public function getContentsParamCallback( $atts, $content, $shortcodeName ) {
        $route = $atts['route'];
        $this->_contentParams[ $route ] = $content;
    }

	/**
	 * Extract shortocde name from ffb_section_0 to "section"
	 * @param $shortcodeNameWithDepth
	 * @return string
	 */
    private function _getOriginalShortcodeName( $shortcodeNameWithDepth ) {
        $lastStr = strrpos( $shortcodeNameWithDepth, '_');
        $shortcodeName = substr($shortcodeNameWithDepth, 0, $lastStr );
        return $shortcodeName;
    }

	/**
	 * Extract shortcode depth from ffb_section_5 to "5"
	 * @param $shortcodeNameWithDepth
	 * @return string
	 */
    private function _getShortcodeDepth( $shortcodeNameWithDepth ) {
        $lastStr = strrpos( $shortcodeNameWithDepth, '_');
        $strLen = strlen( $shortcodeNameWithDepth );
        $shortcodeDepth = substr( $shortcodeNameWithDepth, $lastStr + 1, $strLen - $lastStr );

        return $shortcodeDepth;
    }


	private function _printShortcode( $atts, $content, $shortcodeNameWithDepth, $originalShortcodeContent ){

		if( $shortcodeNameWithDepth == '' ) {
			echo $content;
			return;
		}

		$shortcodeName = $this->_getOriginalShortcodeName( $shortcodeNameWithDepth );
		$elementId = $this->_getElementIdFromShortcodeName( $shortcodeName );

		if( !$this->_canBeElementCached( $elementId, $atts ) ) {
			return $originalShortcodeContent;
		}

		$data = null;

		if( isset( $atts['data'] ) ) {
			$data = $this->_decodeDataAttrFromShortcode( $atts['data'] );
		}

		$uniqueId = null;
		if( isset( $atts['unique_id'] ) ) {
			$uniqueId = $atts['unique_id'];
		} else {
			$uniqueId = rand();
		}

		$element = $this->_getThemeBuilderElementManager()->getElementById( $elementId );

		if( $element == null ) {
			return;
		}

		if( $element != null ) {
			$element->setDoShortcodeCallback( array( $this, 'doShortcode') );
		}

		$this->_contentParams = null;
		if( $element->hasContentParams() ) {
			$this->_contentParams = array();
			$this->doShortcode( $content );
		}

		if( $this->_getIsCachingMode() ) {
			$element->setIsCachingMode( true );
		}

		if( $data == null ) {
			$data = $element->getElementOptionsData();
		}

		if( $this->_getShortcodeDataFilter() != null ) {
			$data = call_user_func( $this->_getShortcodeDataFilter(), $data, $elementId );
		}

		$elementHash = null;
		if( $element->getCanBeCached() ) {
			$elementHash = md5( $originalShortcodeContent );
		}

		$result = $element->render( $data, $content, $uniqueId, $this->_contentParams, $elementHash );
		$css = $element->getAssetsRenderer()->getCssCollection();
		$js = $element->getAssetsRenderer()->getJSCollection();

		$this->_getCssCollection()->addCollection( $css, true);
		$this->_getJsCollection()->addCollection( $js, true);

		$element->getAssetsRenderer()->reset();

		if( $this->_getIsCachingMode() ) {
			$element->setIsCachingMode( false );
		}

		return $result;
	}

    private function _decodeDataAttrFromShortcode( $data ) {

        $data = urldecode( $data );
//	    var_dump( $data );

        return json_decode($data, true);
    }

    public function registerShortcodes() {
	    throw new ffException('Dont use this yet');
        return $this->_registerShortcodes();
    }

/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/
	private function _reset() {
		$this->_setUsedTags( null );
		$this->_setRegex( null );
		$this->_renderedCss = null;
		$this->_renderedJs = null;
		$this->_getCssCollection()->clean();
		$this->_getJsCollection()->clean();
	}

	/**
	 * Register shortcodes in wordpress
	 * @return bool
	 */
    private function _registerShortcodes() {
        if( $this->_shortcodesRegistered == true ) {
            return false;
        }

        $shortcodesId = $this->_getThemeBuilderElementManager()->getAllElementsIds();
        $WPLayer = $this->_getWPLayer();

        foreach( $shortcodesId as $oneId ) {
            $shortcodeName = $this->_getShortcodeNameFromElementId( $oneId );

            $WPLayer->add_shortcode( $shortcodeName, array( $this, 'shortcodesCallback' ) );

            for( $i = 0; $i < 10; $i++ ) {
                $WPLayer->add_shortcode( $shortcodeName.'_'.$i, array( $this, 'shortcodesCallback' ) );
            }
        }

        $WPLayer->add_shortcode('ffb_param', array( $this, 'getContentsParamCallback'));
    }


    private function _renderEditor( $content ) {

    }

    private function _getShortcodeNameFromElementId( $elementId ) {
        return 'ffb_' . $elementId;
    }

    private function _getElementIdFromShortcodeName( $elementId ) {
        return str_replace( 'ffb_', '', $elementId );
    }

/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/
	private function _canBeElementCached( $elementId, $elementAtts ) {
		if( $this->_getIsCachingMode() == false ) {
			return true;
		}

		if( isset( $elementAtts['data'] ) && strpos( $elementAtts['data'], 'use-as-php') !== false ) {
			return false;
		}
//		if( strpos( $elementAtts))

		if( in_array( $elementId, $this->_getNoncacheableElements() ) ) {
			return false;
		} else {
			return true;
		}
	}


	private function _getNoncacheableElements() {
		if( $this->_noncacheableElements == null ) {
			$this->_noncacheableElements = $this->_getThemeBuilderElementManager()->getNonCacheableElements();
		}

		return $this->_noncacheableElements;
	}

    /**
     * @return ffThemeBuilderElementManager
     */
    private function _getThemeBuilderElementManager()
    {
        return $this->_themeBuilderElementManager;
    }

    /**
     * @param ffThemeBuilderElementManager $themeBuilderElementManager
     */
    private function _setThemeBuilderElementManager($themeBuilderElementManager)
    {
        $this->_themeBuilderElementManager = $themeBuilderElementManager;
    }

    /**
     * @return ffWPLayer
     */
    private function _getWPLayer()
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
	 * @return null
	 */
	private function _getUsedTags() {
		return $this->_usedTags;
	}

	/**
	 * @param null $usedTags
	 */
	private function _setUsedTags($usedTags) {
		$this->_usedTags = $usedTags;
	}

	/**
	 * @return null
	 */
	private function _getRegex() {
		return $this->_regex;
	}

	/**
	 * @param null $regex
	 */
	private function _setRegex($regex) {
		$this->_regex = $regex;
	}

	private function _addRenderedCss( $css ) {
		if( !empty( $css ) ) {
			$this->_renderedCss .= PHP_EOL;
			$this->_renderedCss .= $css;
		}
	}

	private function _addRenderedJs( $js ) {
		if( !empty( $js ) ) {
			$this->_renderedJs .= PHP_EOL;
			$this->_renderedJs .= $js;
		}
	}

	public function getRenderedCss() {

		$renderedCss = '';
		/**
		 * @var $oneRule ffThemeBuilderCssRule
		 */

		foreach( $this->_getCssCollection() as $oneRule ) {
			$renderedCss .= $oneRule->getCssAsString();
		}

		return $renderedCss;

	}

	public function resetCss() {
//		return $this->_reset();

		$this->_renderedCss = null;
//		$this->_renderedJs = null;
		$this->_getCssCollection()->clean();
//		$this->_getJsCollection()->clean();

		return $this;
	}

	public function resetJs() {
		$this->_renderedJs = null;
		$this->_getJsCollection()->clean();

		return $this;
	}

	public function getRenderedJs() {
		$renderedJs = '';

		/**
		 * @var $oneScript ffThemeBuilderJavascriptCode
		 */
		foreach( $this->_getJsCollection() as $oneScript ) {
			$renderedJs .= $oneScript->getJsAsString();
		}
//		var_dump( $renderedJs );
		return $renderedJs;
	}

	/**
	 * @return boolean
	 */
	private function _getIsCachingMode() {
		return $this->_isCachingMode;
	}

	private function _getStatusHolder() {
		return $this->_getThemeBuilderElementManager()->getStatusHolder();
	}

	/**
	 * @param boolean $isCachingMode
	 */
	public function setIsCachingMode($isCachingMode) {
		$this->_isCachingMode = $isCachingMode;
		return $this;
	}

	public function setShortcodeDataFilter( $callback ) {
		$this->_shortcodeDataFilter = $callback;
	}

	private function _getShortcodeDataFilter() {
		return $this->_shortcodeDataFilter;
	}

	/**
	 * @return ffCollection
	 */
	private function _getCssCollection() {
		return $this->_cssCollection;
	}

	/**
	 * @param ffCollection $cssCollection
	 */
	private function _setCssCollection($cssCollection) {
		$this->_cssCollection = $cssCollection;
	}

	/**
	 * @return ffCollection
	 */
	private function _getJsCollection() {
		return $this->_jsCollection;
	}

	/**
	 * @param ffCollection $jsCollection
	 */
	private function _setJsCollection($jsCollection) {
		$this->_jsCollection = $jsCollection;
	}

    /**
     * @return boolean
     */
    private function _isModePrintOnlyText() {
        return $this->_modePrintOnlyText;
    }

    /**
     * @param boolean $modePrintOnlyText
     */
    public function setModePrintOnlyText($modePrintOnlyText) {
        $this->_modePrintOnlyText = $modePrintOnlyText;

        return $this;
    }

}