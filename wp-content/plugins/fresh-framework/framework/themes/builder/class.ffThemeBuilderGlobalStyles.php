<?php

class ffThemeBuilderGlobalStyles extends ffBasicObject {
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/
	/**
	 * @var ffWPLayer
	 */
	private $_WPLayer = null;

	/**
	 * @var ffEnvironment
	 */
	private $_environment = null;

	/**
	 * @var ffDataStorage_WPOptions_NamespaceFacede
	 */
	private $_options = null;

	/**
	 * @var ffDataHolder
	 */
	private $_data = null;
/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/

    /**
     * @var null
     */
    private $_globalStylesGroups = null;

/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
	/**
	 * ffThemeBuilderGlobalStyles constructor.
	 * @param ffWPLayer $WPLayer
	 * @param ffEnvironment $environment
	 * @param ffDataStorage_WPOptions_NamespaceFacede $options
	 */
	public function __construct( $WPLayer, $environment, $options ) {
		$this->_setWPLayer( $WPLayer );
		$this->_setEnvironment( $environment );
		$this->_setOptions( $options );

		$options->setNamespace( $this->_getOptionsNamespace() );

		if( $this->_getWPLayer()->is_admin() ) {
			$this->initNewGlobalStyles();
		}
	}

/**********************************************************************************************************************/
/* NEW GLOBAL STYLES
/**********************************************************************************************************************/
    public function getGlobalStylesGroup() {
        if( $this->_globalStylesGroups == null ) {
            $this->_globalStylesGroups = $this->_getOptions()->getOptionCodedJson('global_styles_group');;
        }

        return $this->_globalStylesGroups;
    }

    public function getGlobalStylesGroupWithJustNames() {
        $globalStyles = $this->getGlobalStylesGroup();

        $globalStylesFiltered = [];

		if( empty( $globalStyles ) ) {
			$globalStyles = [];
		}

        foreach( $globalStyles as $oneStyle ) {
            $oneStyle = new ffDataHolder( $oneStyle );

            if( $oneStyle->get('type') == 'group') {
                $newStyle['value'] = $oneStyle->get('id');
                $newStyle['name'] = $oneStyle->get('name');

                $globalStylesFiltered[] = $newStyle;
            }
        }

        return $globalStylesFiltered;
    }

    public function getGlobalStyleGroupById( $globalStyleGroupId ) {
        $globalStylesGroups = $this->getGlobalStylesGroup();

        if( isset( $globalStylesGroups[ $globalStyleGroupId ] ) ) {
            return $globalStylesGroups[ $globalStyleGroupId ];
        } else {
            return null;
        }
    }

    public function getGlobalStyleGroupValueById( $globalStyleGroupId ) {
        $globalStylesGroups = $this->getGlobalStylesGroup();

        if( isset( $globalStylesGroups[ $globalStyleGroupId ] ) && isset( $globalStylesGroups[ $globalStyleGroupId ]['styles'] ) ) {
            return $globalStylesGroups[ $globalStyleGroupId ]['styles'];
        } else {
            return null;
        }
    }

    public function setGlobalStylesGroup($globalStylesGroup) {
        $this->_getOptions()->setOptionCodedJson('global_styles_group', $globalStylesGroup);
    }

    public function getGlobalStyles() {
        $globalStyles = $this->_getOptions()->getOptionCodedJson('global_styles');
        return $globalStyles;
    }

	public function initNewGlobalStyles() {

		$globalStylesInit = $this->_getOptions()->getOption('global_styles_init', null);

		if( $globalStylesInit == null ) {

			$this->_initGlobalStylesDemo();
			$this->_getOptions()->setOption('global_styles_init', 'true');
		}
	}

	private function _initGlobalStylesDemo() {
		$gsDataJSON = '{"gs-1bdjlnt1":{"id":"gs-1bdjlnt1","name":"Font Size","type":"category","color":"#FF5722"},"gs-1bdjmb0j":{"id":"gs-1bdjmb0j","style":{"o":{"gen":{"ffsys-disabled":"0","ffsys-info":"{}","name":"Large Heading"},"clrs":{"font-size":"48"}}},"type":"item","catId":"gs-1bdjlnt1"},"gs-1bdjqt5r":{"id":"gs-1bdjqt5r","style":{"o":{"gen":{"ffsys-disabled":"0","ffsys-info":"{}","name":"Medium Heading"},"clrs":{"font-size":"32"}}},"type":"item","catId":"gs-1bdjlnt1"},"gs-1bdk5h2s":{"id":"gs-1bdk5h2s","style":{"o":{"gen":{"ffsys-disabled":"0","ffsys-info":"{}","name":"Small Heading"},"clrs":{"font-size":"24"}}},"type":"item","catId":"gs-1bdjlnt1"},"gs-1bdl83gh":{"id":"gs-1bdl83gh","style":{"o":{"gen":{"ffsys-disabled":"0","ffsys-info":"{}","name":"Paragraph"},"clrs":{"font-size":"18"}}},"type":"item","catId":"gs-1bdjlnt1"},"gs-1bdkdtll":{"id":"gs-1bdkdtll","name":"Text Color","type":"category","color":"#2196F3"},"gs-1bdkbr8a":{"id":"gs-1bdkbr8a","style":{"o":{"gen":{"ffsys-disabled":"0","ffsys-info":"{}","name":"Heading"},"clrs":{"text-custom-color":"#000000"}}},"type":"item","catId":"gs-1bdkdtll"},"gs-1bdkc2nq":{"id":"gs-1bdkc2nq","style":{"o":{"gen":{"ffsys-disabled":"0","ffsys-info":"{}","name":"Paragraph"},"clrs":{"text-custom-color":"#999999"}}},"type":"item","catId":"gs-1bdkdtll"}}';
		$groupDataJSON = '{"gs-1bdkfqvl":{"id":"gs-1bdkfqvl","name":"Large Heading","type":"group","styles":{"o":{"gen":{"ffsys-disabled":"0","ffsys-info":"{}","name":"Heading"},"clrs":{"font-size":"48","text-custom-color":"#000000"}}},"childs":[{"id":"gs-1bdjmb0j","type":"item","groupId":"gs-1bdkfqvl"},{"id":"gs-1bdkbr8a","type":"item","groupId":"gs-1bdkfqvl"}],"hash":"1f41e88b625690237a20ca15e2252976"},"gs-1bdkk8mc":{"id":"gs-1bdkk8mc","name":"Medium Heading","type":"group","styles":{"o":{"gen":{"ffsys-disabled":"0","ffsys-info":"{}","name":"Heading"},"clrs":{"font-size":"32","text-custom-color":"#000000"}}},"childs":[{"id":"gs-1bdjqt5r","type":"item","groupId":"gs-1bdkk8mc"},{"id":"gs-1bdkbr8a","type":"item","groupId":"gs-1bdkk8mc"}],"hash":"db1e1d94f9b1d8e73ad6a736ad95cedc"},"gs-1bdl2ss5":{"id":"gs-1bdl2ss5","name":"Small Heading","type":"group","styles":{"o":{"gen":{"ffsys-disabled":"0","ffsys-info":"{}","name":"Heading"},"clrs":{"font-size":"24","text-custom-color":"#000000"}}},"childs":[{"id":"gs-1bdk5h2s","type":"item","groupId":"gs-1bdl2ss5"},{"id":"gs-1bdkbr8a","type":"item","groupId":"gs-1bdl2ss5"}],"hash":"6b1d405abed7dcaebf0aa07f9c023048"},"gs-1bdkkp6s":{"id":"gs-1bdkkp6s","name":"Paragraph","type":"group","styles":{"o":{"gen":{"ffsys-disabled":"0","ffsys-info":"{}","name":"Paragraph"},"clrs":{"font-size":"18","text-custom-color":"#999999"}}},"childs":[{"id":"gs-1bdl83gh","type":"item","groupId":"gs-1bdkkp6s"},{"id":"gs-1bdkc2nq","type":"item","groupId":"gs-1bdkkp6s"}],"hash":"3787ee218f56c7542151f80559705363"}}';

		$gsData = json_decode( $gsDataJSON,true );
		$groupData = json_decode( $groupDataJSON, true );

//		var_dump( $gsData );
//		die();

		$this->setGlobalStyles( $gsData );
		$this->setGlobalStylesGroup( $groupData);
	}


    public function setGlobalStyles( $globalStyles) {
        $this->_getOptions()->setOptionCodedJson('global_styles', $globalStyles);
    }

    public function getGlobalStyleHash( $globalStyleIds ) {
        $hash = '';

        foreach( $globalStyleIds as $oneId ) {
            $style = $this->getGlobalStyleGroupById( $oneId );

//            ffStopWatch::addVariableDump( $style );

            if( isset( $style['hash'] ) ) {
                $hash .= $style['hash'];
            }

//            $hash .= $oneIdHash;
        }

        return md5( $hash );
    }
/**********************************************************************************************************************/
/* OLD GLOBAL STYLEs
/**********************************************************************************************************************/

	public function getElementGlobalStyles() {
		$globalStyles = $this->_getOptions()->getOptionCodedJson('element_global_styles');
		return $globalStyles;
	}

	public function setElementGlobalStyles( $globalStyles ) {
		$this->_getOptions()->setOptionCodedJson('element_global_styles', $globalStyles);
	}

	public function getElementGlobalStyleName( $elementId, $globalStyleName ) {

		$data = $this->_getData();
//		ffStopWatch::addVariableDump( $globalStyleName !== 0 && $globalStyleName !== '0' );
		if( $globalStyleName !== 0 && $globalStyleName !== '0' ) {

			// if style exists
			$styleName = $data->get($elementId . ' ' . $globalStyleName . ' name');

//			ffStopWatch::addVariableDump( $style );
//			ffStopWatch::addVariableDump( $elementId . ' ' . $globalStyleName . ' name' );
//			ffStopWatch::addVariableDump( $elementId . ' ' . $globalStyleName . ' name' );

			if( $styleName != null > 0 ) {
				return $globalStyleName;
			} else if( $styleName == null ) {

				$defaultStyle = $data->get( $elementId . ' 0' );

				if( $defaultStyle != null ) {

					return 0;
				}
			}
		}

		$defaultStyle = $data->get( $elementId . ' 0' );
		if( $defaultStyle != null ) {
			return 0;
		}

		return null;
	}

//	public function elementHasGlobalStyle( $elementId, $globalStyleName ) {
//		if( $this->_getData()->get($elementId . ' ' . $globalStyleName ) == null ) {
//			return false;
//		} else {
//			return true;
//		}
//	}

	public function getAllStylesForElement( $elementId ) {
		$data = $this->_getData()->get($elementId );
		return $data;
	}

	public function getStyleForElement( $elementId, $globalStyleName, $route, $tabId ){
		$newData = $this->_getData()->getNewHolder( $elementId .' ' . $globalStyleName );
//		ffStopWatch::addVariableDump( $this->_getData() );
//		ffStopWatch::addVariableDump( $newData );
		if( $newData[ $route ] != null ) {
			$newData = new ffDataHolder( $newData[ $route ] );
			$toReturn = $newData->getNewHolder( $tabId);

//		ffStopWatch::addVariableDump( $toReturn );
			return $toReturn;
		}

		return new ffDataHolder();
	}


/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/

	private function _getOptionsNamespace() {
		return 'ff_builder_styles_' . $this->_getEnvironment()->getThemeVariable( ffEnvironment::THEME_NAME );
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
	 * @return ffEnvironment
	 */
	private function _getEnvironment() {
		return $this->_environment;
	}

	/**
	 * @param ffEnvironment $environment
	 */
	private function _setEnvironment($environment) {
		$this->_environment = $environment;
	}

	/**
	 * @return ffDataStorage_WPOptions_NamespaceFacede
	 */
	private function _getOptions() {
		return $this->_options;
	}

	/**
	 * @param ffDataStorage_WPOptions_NamespaceFacede $options
	 */
	private function _setOptions($options) {
		$this->_options = $options;
	}

	/**
	 * @return ffDataHolder
	 */
	private function _getData() {
		if( $this->_data == null ) {
			$styles = $this->getElementGlobalStyles();
			$this->_data = new ffDataHolder( $styles );
		}

		return $this->_data;
	}


}