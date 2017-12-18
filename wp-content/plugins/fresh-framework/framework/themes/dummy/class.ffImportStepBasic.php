<?php

abstract class ffImportStepBasic extends ffBasicObject {
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/
	/**
	 * @var ffWPImporter
	 */
	private $_WPImporter = null;

/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/
    private $_state = array();

	protected $_message = '';

	protected $_stepCurrent = null;

	protected $_stepMax = null;

	protected $_config = null;

/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
	public function getMessage() {
		return $this->_message;
	}

	public function getMessageStepCurrent() {
		return $this->_stepCurrent;
	}

	public function getMessageStepMax() {
		return $this->_stepMax;
	}

/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/
	public function runStep() {
		$result = $this->_runStep();

		return $result;
	}
/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/
	protected function _runStep() {
		return false;
	}

/**********************************************************************************************************************/
/* ABSTRACT FUNCTIONS
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/
	public function setConfig( $config ) {
		$this->_config = $config;
	}

	protected function _getConfigValue( $name, $default = null ) {
		if( isset( $this->_config[ $name ] ) ) {
			return $this->_config[ $name ];
		} else {
			return $default;
		}
	}

	public function getNamespace() {
		return get_class( $this );
	}

	public function getState() {
		return $this->_state;
	}

	public function setState( $state ) {
		$this->_state = $state;
	}


	public function setWPImporter( $WPImporter ) {
		$this->_WPImporter = $WPImporter;
	}

	/**
	 * @return ffWPImporter
	 */
	protected function _getWPImporter() {
		return $this->_WPImporter;
	}

	protected function _setStateValue( $name, $value ) {
		$this->_state[ $name ] = $value;
	}

	protected function _getStateValue( $name, $default = null ) {
		if( isset( $this->_state[ $name] ) ) {
			return $this->_state[ $name ];
		} else {
			return $default;
		}
	}
}