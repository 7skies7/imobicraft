<?php

class ffAdminNotices extends ffBasicObject {
	const TYPE_INFO = 'info';
	const TYPE_SUCCESS = 'success';
	const TYPE_WARNING = 'warning';
	const TYPE_ERROR = 'error';

	const SHOW_PERMANENT = 'permanent';
	const SHOW_ONCE = 'once';

	const LOCATION_SITE = 'site';
	const LOCATION_NETWORK = 'network';
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

	private $_adminNotices = null;

	private $_hooksHasBeenSetUp = false;

/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/

	/**
	 * ffAdminNotices constructor.
	 * @param $WPLayer ffWPLayer
	 */
	public function __construct( $WPLayer ) {
		$this->_setWPLayer( $WPLayer );
	}

/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/

	public function addNotice( $type, $message, $show, $location = 'site' ) {
		$notice = new ffDataHolder();
		$notice->type = $type;
		$notice->message = $message;
		$notice->show = $show;
		$notice->location = $location;
		$notice->hash = md5( $type . $message . $show . $location );

		$this->_adminNotices[] = $notice;

		$this->_setupHooks();
	}

	public function actAdminNotices() {
		foreach( $this->_adminNotices as $oneNotice ) {
			if( $oneNotice->location == ffAdminNotices::LOCATION_NETWORK ) {
				continue;
			}

			$attrHelper = ffContainer()->getMultiAttrHelper();

			$attrHelper->addParam('class', 'notice');
			$attrHelper->addParam('class', 'notice-' . $oneNotice->type);

			echo '<div ' . $attrHelper->getAttrString() . ' >';
				echo '<p>';
					echo $oneNotice->message;
				echo '</p>';
			echo '</div>';


		}
	}

	public function actNetworkAdminNotices() {

	}

/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/
	private function _setupHooks() {
		if( $this->_hooksHasBeenSetUp == true ) {
			return false;
		}

		$WPLayer = $this->_getWPLayer();

		$WPLayer->add_action('admin_notices', array( $this, 'actAdminNotices') );
		$WPLayer->add_action('network_admin_notices', array( $this, 'actNetworkAdminNotices') );
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