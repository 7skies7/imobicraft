<?php

class ffExternalPluginsTweakers extends ffBasicObject {
/**********************************************************************************************************************/
/* OBJECTS
/************************************************************************************************************************/
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
    }

/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/
    public function removeUpgradeNotices() {

        $this->_getWPLayer()->add_action('admin_print_styles', array($this,'actAdminPrintStyles') );
    }

    public function actAdminPrintStyles() {
        echo '<style>.rs-update-notice-wrap, .vc_license-activation-notice {display:none !important; opacity:0; visibility: hidden;}</style>';
    }
/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/

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
}