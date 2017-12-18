<?php

abstract class ffThemeBuilderBlock extends ffBasicObject {
    const INFO_ID = 'id';
    const INFO_WRAPPING_ID = 'wrapping_id';
    const INFO_WRAP_AUTOMATICALLY = 'wrap_automatically';
    const INFO_IS_REFERENCE_SECTION = 'is_reference_section';
    const INFO_SAVE_ONLY_DIFFERENCE = 'save_only_difference';
	const INFO_APPLY_CALLBACKS = 'apply_callbacks';
	const INFO_IS_SYSTEM = 'is_system';
	const PARAM_INJECT_WITHOUT_REFERENCE = 'inject_without_reference';


    const HTML = 'ffThemeBuilderBlock_HTML';
	const BOOTSTRAP_COLUMNS = 'ffThemeBuilderBlock_BootstrapColumns';
	const BACKGROUNDS = 'ffThemeBuilderBlock_Backgrounds';
	const PADDING_MARGIN = 'ffThemeBuilderBlock_PaddingMargin';
    const STYLES = 'ffThemeBuilderBlock_Styles';
	const BOX_MODEL = 'ffThemeBuilderBlock_BoxModel';
	const COLORS = 'ffThemeBuilderBlock_Colors';
    const ADVANCED_TOOLS = 'ffThemeBuilderBlock_AdvancedTools';
    const CUSTOM_CODES = 'ffThemeBuilderBlock_CustomCodes';
	const LINK = 'ffThemeBuilderBlock_Link';
	const LOOP = 'ffThemeBuilderBlock_Loop';



/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/
	protected $_timesRendered = 0;

	/**
	 * @var ffThemeBuilderBlockManager
	 */
	protected $_blockManager = null;

	/**
	 * @var ffThemeBuilderAssetsRenderer
	 */
	protected $_AssetsRenderer = null;

	/**
	 * @var ffThemeBuilderOptionsExtender
	 */
	protected $_optionsExtender = null;

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
     * Informations - id, wrapping ID and other stuff
     * @var array
     */
    protected $_info = array();

    /**
     * @var params for printing the block
     */
    protected $_param = array();

	protected $_queryHasBeenFilled = true;

    protected $_isEditMode = false;

	protected $_cssClasses = array();

/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
    public function __construct( ffThemeBuilderOptionsExtender $optionsExtender, $globalStyles ) {
        $this->_setOptionsExtender( $optionsExtender );
	    $this->_setGlobalStyles( $globalStyles );
        $this->_init();
    }
/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/
	/*----------------------------------------------------------*/
	/* PARAMS
	/*----------------------------------------------------------*/
    public function setParam( $name, $value ) {
        $this->_param[ $name ] = $value;

        return $this;
    }

    public function getParam( $name, $default = null ) {
        if( isset( $this->_param[ $name ] ) ) {
            return $this->_param[ $name ];
        } else {
            return $default;
        }
    }
/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/
	/**
	 * @param $s ffOneStructure|ffThemeBuilderOptionsExtender
	 */
    public function injectOptions( $s ) {

	    if( !$this->_getIsEditMode() ) {
//		    return;
	    }

//	    die();

	    // is reference and are we printing options for editor
	    if( $this->_getInfo( ffThemeBuilderBlock::INFO_IS_REFERENCE_SECTION, false ) && $this->_getIsEditMode() && !$this->getParam( ffThemeBuilderBlock::PARAM_INJECT_WITHOUT_REFERENCE, false) ) {
		    $uniqueHash = $this->_getParamHash();


		    $s->startSection( $this->getWrappingId() )
			    ->addParam('is-block', true)
			    ->addParam('unique-hash',  $uniqueHash )
		    ;
		    $s->endSection();

		    // if the structure does not exists, we have to create it
		    if( !$this->_getBlockManager()->blockOptionsStructureExists( $uniqueHash ) ) {
				$structure= $this->_getOptionsFactory()->createStructure();
				$s2 = $this->_getNewOptionsExtender();
			    $s2->setStructure( $structure );

			    $section = $s2->startSection( $this->getWrappingId() );

			    if( $this->_getInfo( ffThemeBuilderBlock::INFO_SAVE_ONLY_DIFFERENCE, false) ) {
				    $section->addParam('save-only-difference', true);
			    }

			    $this->_injectOptions( $s2 );

			    $s2->endSection();

			    $this->_getBlockManager()->addBlockOptionsStructure( $uniqueHash, $s2->getStructure() );
		    }
	    } else {

		    if( $this->getWrapAutomatically() ) {

			    if( $this->_getInfo( ffThemeBuilderBlock::INFO_IS_REFERENCE_SECTION, false ) && !$this->getParam( ffThemeBuilderBlock::PARAM_INJECT_WITHOUT_REFERENCE, false) ) {
				    $section = $s->startReferenceSection( $this->getWrappingId() );
			    } else {
				    $section =  $s->startSection( $this->getWrappingId() );
			    }

			    if( $this->_getInfo( ffThemeBuilderBlock::INFO_SAVE_ONLY_DIFFERENCE, false) ) {
				    $section->addParam('save-only-difference', true);
			    }
		    }

		    $this->_injectOptions( $s );

		    if( $this->getWrapAutomatically() ) {
			    if( $this->_getInfo( ffThemeBuilderBlock::INFO_IS_REFERENCE_SECTION, false ) && !$this->getParam( ffThemeBuilderBlock::PARAM_INJECT_WITHOUT_REFERENCE, false) ) {
				    $s->endReferenceSection( $this->getWrappingId() );
			    } else {
				    $s->endSection( $this->getWrappingId() );
			    }
		    }

//		    if( $this->getWrapAutomatically() && !$this->getParam( ffThemeBuilderBlock::PARAM_INJECT_WITHOUT_REFERENCE, false) ) {
//			    if( $this->_getInfo( ffThemeBuilderBlock::INFO_IS_REFERENCE_SECTION, false ) ) {
//				    $s->endReferenceSection();
//			    } else {
//				    $s->endSection();
//			    }
//		    }

	    }
    }


    public function getWrapAutomatically() {
        return $this->_getInfo( ffThemeBuilderBlock::INFO_WRAP_AUTOMATICALLY, true );
    }

    public function getId() {
        return $this->_getInfo( ffThemeBuilderBlock::INFO_ID);
    }

    public function getWrappingId() {
        return $this->_getInfo( ffThemeBuilderBlock::INFO_WRAPPING_ID );
    }

    public function setWrappingId( $wrappingId ) {
        $this->_setInfo( ffThemeBuilderBlock::INFO_WRAPPING_ID, $wrappingId );

	    return $this;
    }

/**********************************************************************************************************************/
/* RENDERING
/**********************************************************************************************************************/
	public function get( ffOptionsQueryDynamic $query ) {
		ob_start();
			$returnFromRendered = $this->render( $query );
			$toReturn = ob_get_contents();
		ob_end_clean();

		if( !empty( $returnFromRendered ) ) {
			return $returnFromRendered;
		} else {
			return $toReturn;
		}
	}
	
    public function render( ffOptionsQueryDynamic $query ) {
	    $this->_timesRendered++;
        if( $this->getWrapAutomatically() ) {
            $wrappingId = $this->getWrappingId();

			if( $query->queryExists( $wrappingId ) ) {

				if( $this->_shouldApplyCallbacks() ) {
					$query = $query->get( $wrappingId );
				} else {
					$query = $query->getWithoutCallbacks( $wrappingId );
				}
//				$query = $this->_figureOutGlobalOptions( $query );
                $query = $this->_figureOutNewGlobalOptions( $query );
				return $this->_render( $query );

			} else {
				$this->_queryHasBeenFilled = false;
//				$query = $this->_figureOutGlobalOptions( $query, false );
                $query = $this->_figureOutNewGlobalOptions( $query, false );

                if( $query->queryExists( $wrappingId ) ) {
                    $this->_queryHasBeenFilled = true;

                    if( $this->_shouldApplyCallbacks() ) {
                        $query = $query->get( $wrappingId );
                    } else {
                        $query = $query->getWithoutCallbacks( $wrappingId );
                    }

                }


				$rendered = $this->_render( $query );
				$this->_queryHasBeenFilled = true;

				return $rendered;
			}
        } else {
            return $this->_render( $query );
        }
    }

    /**
     * @param $query ffOptionsQueryDynamic
     */
    abstract protected function _figureOutNewGlobalOptions( $query, $queryExists = true );

	/**
	 * @param ffOptionsQuery $query
	 */
	private function _getGlobalStyleRouteFromQuery( $query ) {
		$path = $query->getPathWithoutRepeatables(true); // o gen header [b-m] -- the b-m thing does not have to be there, so be sure its removed
		$wrappingId = $this->_getInfo( ffThemeBuilderBlock::INFO_WRAPPING_ID );  // b-m

		// "b-m" == "b-m"
		if( end($path) == $wrappingId ) {
			array_pop( $path );
		}

		return implode('_', $path);
	}


	protected function _getOriginalGlobalStylesDataToInject( $query ) {
		$systemOptions = $this->_getStatusHolder()->getSystemOptionsFromStack();

		if( $systemOptions->globalStyleName === null) {
			return null;
		} else {
			$globalStyleName = $systemOptions->get('globalStyleName', 0);

			$elementId = $systemOptions->get('elementId');
			$route = $this->_getGlobalStyleRouteFromQuery( $query );
			$blockId = $this->_getInfo( ffThemeBuilderBlock::INFO_WRAPPING_ID );


			$dataToInject = $this->_getGlobalStyles()->getStyleForElement( $elementId, $globalStyleName, $route, $blockId );

//			ffStopWatch::addVariableDump( $dataToInject);
			$dataToReturn = new ffArrayQuery();
			$dataToReturn->set('o ' .  $blockId, $dataToInject->getData() );
			return $dataToReturn;
		}
	}

	/**
	 * @param ffOptionsQueryDynamic $query
	 * @return mixed
	 */
	protected function _figureOutGlobalOptions( $query, $queryExists = true ) {
		$systemOptions = $this->_getStatusHolder()->getSystemOptionsFromStack();

		if( $systemOptions->globalStyleName === null) {
			return $query;
		} else {
			$globalStyleName = $systemOptions->get('globalStyleName', 0);
			$elementId = $systemOptions->get('elementId');
			$route = $this->_getGlobalStyleRouteFromQuery( $query );
			$blockId = $this->_getInfo( ffThemeBuilderBlock::INFO_WRAPPING_ID );

			$dataToInject = $this->_getGlobalStyles()->getStyleForElement( $elementId, $globalStyleName, $route, $blockId );

			if( $dataToInject->getData() != null ) {
				if( $queryExists ) {
					$elementData = $query->getOnlyDataPartAsDataHolder('');
				} else {
					$elementData = new ffDataHolder();
				}
				$newData = $this->_mergeTwoStylesData( $elementData, $dataToInject );
				$query = ffContainer()->getOptionsFactory()->createQueryDynamic( $newData );
				$this->_queryHasBeenFilled = true;
				return $query;
			} else {
				return $query;
			}
		}
	}

	/**
	 * @param ffDataHolder $importantData
	 * @param ffDataHolder $lessImportantData
	 * @param string $query
	 */
	protected function _mergeTwoStylesData_repeatable( $importantData, $lessImportantData, $query ) {
		if( $importantData->get( $query ) == null ) {

//			ffStopWatch::addVariableDump( $importantData );

			$importantData->set( $query, $lessImportantData->get( $query ) );


		}

		$lessImportantData->set( $query, null );
	}

	/**
	 * @param ffDataHolder $importantData
	 * @param ffDataHolder $lessImportantData
	 * @return mixed
	 */
	protected function _mergeTwoStylesData( $importantData, $lessImportantData ) {
		return $importantData;
	}

	/**
	 * @param $query ffOptionsQueryDynamic
	 */
	protected function _getRightQuery( $query ) {
		if( $this->getWrapAutomatically() ) {
			$wrappingId = $this->getWrappingId();

			if( $query->queryExists( $wrappingId ) ) {
				if( $this->_shouldApplyCallbacks() ) {
					return $query->get( $wrappingId );
				} else {
					return $query->getWithoutCallbacks( $wrappingId );
				}
			} else {

				$query = $query->getMustBeQueryNotEmpty( $wrappingId );

				if( !$this->_shouldApplyCallbacks() ) {
					$query->resetCallbacks();
				}

				return $query;
			}
		}
	}

	protected function _shouldApplyCallbacks() {
		return $this->_getInfo( ffThemeBuilderBlock::INFO_APPLY_CALLBACKS, false);
	}

	public function addCssClass( $class ) {
		$this->_cssClasses[] = $class;
	}

	public function reset() {
		$this->_param = array();
		$this->_cssRenderer = null;
		$this->_cssClasses = null;

		$this->_reset();

		return $this;
	}

	public function getJSFunction() {
		return $this->_getJSFunction('_renderContentInfo_JS');
	}




/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/

	protected function _getCssString( $wrapByAttr = false ) {
		if( empty( $this->_cssClasses ) ) {
			return '';
		}

		$classes = implode(' ', $this->_cssClasses );

		if( $wrapByAttr ) {
			$classes = 'class="' . $classes .'"';
		}

		return $classes;
	}

    protected function _setInfo( $name, $value ) {
        $this->_info[ $name ] = $value;
    }

    protected function _getInfo( $name, $default = null ) {
        if( isset( $this->_info[ $name ] ) ) {
            return $this->_info[ $name ];
        } else {
            return $default;
        }
    }

	protected function _queryIsEmpty() {
		return !$this->_queryHasBeenFilled;
	}

	private function _getParamHash() {
		$md5 = '';
		if( !empty( $this->_param ) ) {
			$md5 = md5( $this->getWrappingId() . json_encode( $this->_param ) );
		}

		return $this->getWrappingId() . '-' . $md5;
	}


	/*----------------------------------------------------------*/
	/* RENDER CONTENT
	/*----------------------------------------------------------*/
	protected function _renderContentInfo_JS() {
		?>
		<script data-type="ffscript">
			function ( query ) {

			}
		</script data-type="ffscript">
		<?php
	}

	protected function _getJSFunction( $functionName ) {
		ob_start();
		call_user_func( array( $this, $functionName) );
		$content = ob_get_contents();
		ob_end_clean();

		$content = str_replace('<script data-type="ffscript">', '', $content);
		$content = str_replace('</script data-type="ffscript">', '', $content);

		if( $this->getWrapAutomatically() ) {
			$toReplace = '{ if( query == undefined ) return null; query = query.getMustBeQuery("'.$this->getWrappingId().'"); ';
			$content = preg_replace('/\{/', $toReplace, $content, 1 );
		}

		return $content;
	}

	protected function _reset() {

	}

    abstract protected function _injectOptions( ffThemeBuilderOptionsExtender $s );
    abstract protected function _init();

	/**
	 * @param $query ffOptionsQueryDynamic
	 * @return mixed
	 */
    abstract protected function _render( $query );

	protected function _getUniqueCssClass() {
		$class = 'ffb-block-' . $this->getId() . '-' . $this->_getTimesRendered();

		return $class;
	}

/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/
	protected function _getBlock( $blockClassName ) {
		$block = $this->_getBlockManager()->getBlock( $blockClassName );
		$block->setAssetsRenderer( $this->_getAssetsRenderer() );
		$block->setStatusHolder( $this->_statusHolder );
		return $block;
	}


	/**
	 * @return ffThemeBuilderBlockManager
	 */
	private function _getBlockManager() {
		return $this->_blockManager;
	}

	/**
	 * @param ffThemeBuilderBlockManager $blockManager
	 */
	public function setBlockManager($blockManager) {
		$this->_blockManager = $blockManager;
	}



    protected function _setId( $id ) {
        $this->_id = $id;
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
	 * @return boolean
	 */
	private function _getIsEditMode() {
		return $this->_isEditMode;
	}

	/**
	 * @param boolean $isEditMode
	 */
	public function setIsEditMode($isEditMode) {
		$this->_isEditMode = $isEditMode;
	}

	protected function _getOptionsFactory() {
		return ffContainer()->getOptionsFactory();
	}

	/**
	 * @return ffThemeBuilderOptionsExtender
	 */
	protected function _getNewOptionsExtender() {
		return new ffThemeBuilderOptionsExtender();
	}

	/**
	 * @return ffThemeBuilderAssetsRenderer
	 */
	protected function _getAssetsRenderer() {
		return $this->_AssetsRenderer;
	}

	protected function _getTimesRendered() {
		return $this->_timesRendered;
	}

	/**
	 * @param ffThemeBuilderAssetsRenderer $AssetsRenderer
	 */
	public function setAssetsRenderer($AssetsRenderer) {
		$this->_AssetsRenderer = $AssetsRenderer;
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
	public function setStatusHolder($statusHolder) {
		$this->_statusHolder = $statusHolder;
	}

	/**
	 * @return ffThemeBuilderGlobalStyles
	 */
	protected function _getGlobalStyles() {
		return $this->_globalStyles;
	}

	/**
	 * @param ffThemeBuilderGlobalStyles $globalStyles
	 */
	private function _setGlobalStyles($globalStyles) {
		$this->_globalStyles = $globalStyles;
	}


	
}