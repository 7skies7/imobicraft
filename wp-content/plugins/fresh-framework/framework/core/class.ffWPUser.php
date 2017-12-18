<?php

class ffWPUser extends ffBasicObject {
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/
	/**
	 * @var ffWPLayer
	 */
	protected $_WPLayer = null;

	protected $_WPUser = null;

/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/

	protected $_userHasBeenLoaded = false;

/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
	public function __construct( $WPLayer ) {
		$this->_setWPLayer( $WPLayer );
		$this->loadCurrentUser();
	}


/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/
	public function reset() {
		$this->_WPUser = null;
		$this->_userHasBeenLoaded = false;
	}

	public function loadUserById( $userId ) {
		$this->reset();
		$this->_loadUserByField('id', $userId);

		return $this;
	}

	public function loadUserByEmail( $email ) {
		$this->reset();
		$this->_loadUserByField('email', $email);

		return $this;
	}

	public function loadUserByNicename( $nicename ) {
		$this->reset();
		$this->_loadUserByField('nicename', $nicename);

		return $this;
	}

	public function loadCurrentUser() {
		$this->reset();
		$currentUser = $this->_getWPLayer()->wp_get_current_user();
		$this->_userHasBeenLoaded = true;
		$this->_WPUser = $currentUser;
		if( isset( $currentUser->ID ) && $currentUser->ID != 0 ) {
			return true;
		} else {
			return false;
		}
	}

	protected function _loadUserByField( $fieldName, $fieldValue ) {
		$user = $this->_getWPLayer()->get_user_by($fieldName, $fieldValue );
		$this->_WPUser = $user;
		$this->_userHasBeenLoaded = true;

		return $this;
	}

/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/

	/*----------------------------------------------------------*/
	/* LOADING USER
	/*----------------------------------------------------------*/
	public function userExists() {
		$this->_makeSureUserIsLoaded();

		if( !isset( $this->_WPUser->ID ) ) {
			return false;
		}

		if( $this->_WPUser->ID == 0 ) {
			return false;
		} else {
			return true;
		}
	}

	public function getWPUserObject() {
		return $this->_WPUser;
	}


	protected function _getUserData( $name ) {
		if( isset( $this->_WPUser->$name ) ) {
			return $this->_WPUser->$name;
		} else {
			return null;
		}
	}

	public function getUserId() {
		return $this->_getUserData('ID');
	}

	public function getUserLogin() {
		return $this->_getUserData('user_login');
	}

	public function getUserNicename() {
		return $this->_getUserData('user_nicename');
	}

	public function getUserEmail() {
		return $this->_getUserData('user_email');
	}

	/*----------------------------------------------------------*/
	/* USER META
	/*----------------------------------------------------------*/
	public function setMeta( $name, $value ) {
		$userId = $this->getUserId();
		return $this->_getWPLayer()->update_user_meta( $userId, $name, $value );
	}

	public function getMeta( $name, $default = null) {
		$userId = $this->getUserId();
		$userMeta = $this->_getWPLayer()->get_user_meta( $userId, $name, true);
		if( empty( $userMeta ) ) {
			return $default;
		}
		return $userMeta;
	}

	public function deleteMeta( $name ) {
		$userId = $this->getUserId();
		$this->_getWPLayer()->delete_user_meta( $userId, $name );
	}


/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/

	protected function _makeSureUserIsLoaded() {
		if( $this->_userHasBeenLoaded == false ) {
			$this->loadCurrentUser();
		}
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