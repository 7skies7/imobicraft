<?php

class ffMultiAttrHelper extends ffBasicObject {
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
    private $_attributes = array();

	private $_tag = null;

	private $_content = null;


/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/

	public function __construct( ffWPLayer $WPLayer ) {
		$this->_setWPLayer( $WPLayer );
	}

/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/
	public function setTag( $tag ) {
		$this->_tag = $tag;
	}

	public function setContent( $content ) {
		$this->_content = $content;
	}

	public function getElement() {
		$toReturn = '';
		$toReturn .= '<' . $this->_tag . ' ' . $this->getAttrString( ) . '>';

		if( $this->_content != null ) {
			$toReturn .= $this->_content;
			$toReturn .= '</' . $this->_tag . '>';
		}

		return $toReturn;
	}

    public function setParam( $name, $value ) {
        $this->_attributes[ $name ] = array();
        $this->_attributes[ $name ][] = $value;
    }

    public function addParam( $name, $value ) {
        if( $this->isParamSet( $name ) ) {
            $this->_attributes[ $name ][] = $value;
        } else {
            $this->setParam( $name, $value );
        }
    }

    public function isParamSet( $name ) {
        return isset( $this->_attributes[ $name ] );
    }

    public function removeParam( $name ) {
        unset( $this->_attributes[ $name ] );
    }

    public function getParamValueAsArray( $name ) {
        if( $this->isParamSet( $name ) ) {
            return $this->_attributes[ $name ];
        } else {
            return array();
        }
    }

    public function getParamValueAsString( $name, $separator = ' ') {
        if( !$this->isParamSet( $name ) ) {
            return '';
        }

        return $this->_getWPLayer()->esc_attr(implode( $separator, $this->_attributes[ $name ] ));
    }

    public function getParamString( $name, $separator = ' ')  {
        return $name .'="'. $this->getParamValueAsString( $name, $separator ) .'"';
    }

    public function getAttrString( $separator = ' ' ) {
        $toReturn = array();

        foreach( $this->_attributes as $name => $value ) {
            $toReturn[] = $this->getParamString( $name, $separator );
        }

        return implode( ' ', $toReturn );
    }

    public function reset() {
        $this->_attributes = array();
    }

	public function __toString() {
		return $this->getAttrString();
		// TODO: Implement __toString() method.
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