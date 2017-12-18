<?php

class ffArrayQuery extends ffBasicObject {
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/
	private $_id = null;

	private $_data = null;

	private $_changed = false;

	private $_attributes = array();

/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
	public function __construct( $data = null ) {
		$this->_setData( $data );
	}



/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/
	public function get( $query, $default = null ) {
		return $this->_get( $query, $default );
	}

	public function set( $query, $value ) {
		$dataPointer = &$this->_data;
		$queryArray = $this->_parseQuery( $query );

		$queryCount = count( $queryArray );
		foreach( $queryArray as $key => $route ) {
			$route = (string)$route;

			if( !isset( $dataPointer[ $route ] ) ) {
				if( !is_array( $dataPointer ) ) {
					$dataPointer = array();
				}
				$dataPointer[ $route ] = array();
			}
			if( ( $key+1) == $queryCount ) { //if( $route == $routeEnd ) {
				$dataPointer[ $route ] = $value;
			}
			if( is_array( $dataPointer ) ) {
				$dataPointer = &$dataPointer[$route ];
			}
		}

		$this->_changed = true;
		return $this;
	}

	public function add( $query, $value ) {
		$originalValue = $this->get( $query );

		if( $originalValue == null ) {
			$this->set( $query, array( $value ) );
		} else {
			$originalValue[] = $value;
			$this->set( $query, $originalValue );
		}

	}

/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/
	private function _get( $query, $default = null ) {
		$queryArray = $this->_parseQuery( $query );

		$dataPointer = &$this->_data;

		if( empty( $dataPointer ) ) {
			return $default;
		}

		foreach( $queryArray as $oneArraySection ) {
			if( isset( $dataPointer[ $oneArraySection ] ) ) {
				$dataPointer = &$dataPointer[ $oneArraySection ];
			} else {
				return $default;
			}
		}

		return $dataPointer;
	}

	private function _parseQuery( $query ) {
		return explode( ' ', $query );
	}

	public function hasBeenChanged() {
		return $this->_changed;
	}

/**********************************************************************************************************************/
/* ABSTRACT FUNCTIONS
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/
	public function setAttr( $name, $value ) {
		$this->_attributes[ $name ] = $value;
	}

	public function getAttr( $name, $default = null ) {
		if( isset( $this->_attributes[ $name ] ) ) {
			return $this->_attributes[ $name ];
		} else {
			return $default;
		}
	}

	public function setData( $data ) {
		$this->_setData( $data);
	}

	public function getData() {
		return $this->_getData();
	}
	/**
	 * @return null
	 */
	private function _getData() {
		return $this->_data;
	}

	/**
	 * @param null $data
	 */
	private function _setData($data) {
		$this->_data = $data;
	}

	public function getId() {
		return $this->_getId();
	}

	public function setId( $id ) {
		$this->_setId( $id );
	}

	/**
	 * @return null
	 */
	private function _getId() {
		return $this->_id;
	}

	/**
	 * @param null $id
	 */
	private function _setId($id) {
		$this->_id = $id;
	}


}