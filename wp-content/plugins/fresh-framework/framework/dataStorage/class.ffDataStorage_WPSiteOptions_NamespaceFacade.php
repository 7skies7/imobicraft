<?php

class ffDataStorage_WPSiteOptions_NamespaceFacade extends ffBasicObject {
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/
	/**
	 * @var ffDataStorage_WPSiteOptions
	 */
    private $_WPSiteOptions = null;

/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/

	private $_namespace = null;

/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
	/**
	 * ffDataStorage_WPSiteOptions_NamespaceFacade constructor.
	 * @param ffDataStorage_WPSiteOptions $WPSiteOptions
	 * @param null $namespace
	 */
	public function __construct( $WPSiteOptions, $namespace = null ) {
		$this->_setWPSiteOptions( $WPSiteOptions );
		$this->_setNamespace( $namespace );
	}

/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/

	public function getOption( $name, $default = null ) {
		return $this->_getWPSiteOptions()->getOption( $this->_getNamespace(), $name, $default );
	}

	public function setOption( $name, $value ) {
		return $this->_getWPSiteOptions()->setOption( $this->_getNamespace(), $name, $value );
	}

	public function deleteOption( $name ) {
		return $this->_getWPSiteOptions()->deleteOption( $this->_getNamespace(), $name);
	}


/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/
	public function setNamespace( $namespace ) {
		$this->_namespace = $namespace;
	}

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
	 * @return ffDataStorage_WPSiteOptions
	 */
	private function _getWPSiteOptions() {
		return $this->_WPSiteOptions;
	}

	/**
	 * @param ffDataStorage_WPSiteOptions $WPSiteOptions
	 */
	private function _setWPSiteOptions($WPSiteOptions) {
		$this->_WPSiteOptions = $WPSiteOptions;
	}

	/**
	 * @return null
	 */
	private function _getNamespace() {
		return $this->_namespace;
	}

	/**
	 * @param null $namespace
	 */
	private function _setNamespace($namespace) {
		$this->_namespace = $namespace;
	}

}