<?php

class ffDataHolder extends ffBasicObject implements ArrayAccess {
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/
	private $_data = array();

	private $_meta = array();

/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
	public function __construct( $data = null ) {
		if( $data != null ) {
			$this->setData( $data );
		}
	}



/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/
	public function setMeta( $name, $value ) {
		$this->_meta[ $name ] = $value;
	}

	public function getMeta( $name, $default = null ) {
		if( isset( $this->_meta[ $name ] ) ) {
			return $this->_meta[ $name ];
		} else {
			return $default;
		}
	}

	public function getData()  {
		return $this->_getData();
	}

	public function setData( $data ) {
		$this->_setData( $data );
	}

	public function setDataJSON( $jsonData ) {
		$data = json_decode( $jsonData, true );
		$this->_setData( $data );
	}

	public function getDataJSON() {
		return json_encode( $this->_data );
	}

	public function getNewHolder( $query ) {
		return new ffDataHolder( $this->_get( $query ) );
	}

	public function get( $query, $default = null ) {
		return $this->_get( $query, $default );
	}

	public function setIfNotExists( $query, $value ) {
		$oldValue = $this->get( $query, null );

		if( $oldValue == null ) {
			$this->set( $query, $value );
		}

		return $this;
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

//		$this->_changed = true;
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
/* MAGIC METHODS
/**********************************************************************************************************************/
	public function __set( $name, $value ) {
		$this->_data[ $name ] = $value;
	}

	public function __get( $name ) {
		if( $this->offsetExists( $name ) ) {
			return $this->offsetGet( $name );
		} else {
			return null;
		}
	}
/**********************************************************************************************************************/
/* ARRAY ACCESS
/**********************************************************************************************************************/
	public function offsetExists ( $offset ) {
		return isset( $this->_data[ $offset ] );
	}
	public function offsetGet ( $offset ) {
		if( isset( $this->_data[ $offset ] ) ) {
			return $this->_data[ $offset ];
		} else {
			return null;
		}

	}
	public function offsetSet ( $offset , $value ) {
		$this->_data[ $offset ] = $value;
	}
	public function offsetUnset ( $offset ) {
		unset( $this->_data[ $offset ] );
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

/**********************************************************************************************************************/
/* ABSTRACT FUNCTIONS
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/

	/**
	 * @return array
	 */
	private function _getData() {
		return $this->_data;
	}

	/**
	 * @param array $data
	 */
	private function _setData($data) {
		$this->_data = $data;
	}

	/**
	 * @return array
	 */
	private function _getMeta() {
		return $this->_meta;
	}

	/**
	 * @param array $meta
	 */
	private function _setMeta($meta) {
		$this->_meta = $meta;
	}

}

function ffDataHolder( $data ) {
	return new ffDataHolder( $data );
}