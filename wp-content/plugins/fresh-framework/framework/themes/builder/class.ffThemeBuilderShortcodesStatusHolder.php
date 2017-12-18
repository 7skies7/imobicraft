<?php

/**
 * Class ffThemeBuilderShortcodesStatusHolder
 */
class ffThemeBuilderShortcodesStatusHolder extends ffBasicObject {
    const USED_GLOBAL_STYLES = 'ugs';

/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/
	private $_elementStack = array();

    private $_elementSpecificStack = array();

	private $_systemOptionsStack = array();

	private $_textColorStack = array();

	private $_matchColumnsHeightStack = array();

	private $_customStack = array();

    private $_deep = 0;

	private static $_elementStackStatic = array();

/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
	public function __construct() {
		$this->addTextColorToStack('fg-text-dark');
	}

	public function getStatusHolderHash() {
		$stringToHash = json_encode( $this->_elementStack ) . $this->getCurrentTextColor() . $this->getMatchColumnsHeight() . json_encode( $this->_systemOptionsStack ) . json_encode( $this->_customStack);
		return md5( $stringToHash );
	}

/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/

	public function addValueToCustomStack( $stackName, $value ) {
		$this->_makeSureCustomStackIsArray( $stackName );

		$this->_customStack[ $stackName ][] = $value;
	}

    public function setValueToCustomStack( $stackName, $value ) {

    }

	public function removeValueFromCustomStack( $stackName ) {
		$this->_makeSureCustomStackIsArray( $stackName );

		return array_pop( $this->_customStack[ $stackName ] );
	}

	public function getCustomStack( $stackName ) {
		$this->_makeSureCustomStackIsArray( $stackName );

		return $this->_customStack[ $stackName ];
	}

	public function isInCustomStack( $stackName, $value ) {
		$this->_makeSureCustomStackIsArray( $stackName );

		return in_array( $value, $this->_customStack[ $stackName ] );
	}

	public function getCustomStackCurrentValue( $stackName ) {
		$this->_makeSureCustomStackIsArray( $stackName );

		return end( $this->_customStack[ $stackName ] );
	}

	public function addMatchColumnsHeightToStack( $value ) {
		$this->_matchColumnsHeightStack[] = $value;
	}

	public function getMatchColumnsHeight() {
		return end( $this->_matchColumnsHeightStack );
	}

	public function removeMatchColumnsHeightFromStack() {
		return array_pop( $this->_matchColumnsHeightStack );
	}

	/*----------------------------------------------------------*/
	/* TEXT COLOR STACK
	/*----------------------------------------------------------*/
	public function addTextColorToStack( $textColor ) {
		$this->_textColorStack[] = $textColor;
	}

	public function removeTextColorFromStack() {
		return array_pop( $this->_textColorStack );
	}

	public function getCurrentTextColor() {
		if( empty( $this->_textColorStack ) ) {
			return null;
		} else {
			return end( $this->_textColorStack );
		}
	}

	/*----------------------------------------------------------*/
	/* ELEMENT STACK
	/*----------------------------------------------------------*/
	public function addElementToStack( $elementId ) {
		$this->_elementStack[] = $elementId;
        $this->_deep++;
		self::$_elementStackStatic[] = $elementId;
	}

	public function removeElementFromStack() {
        unset( $this->_elementSpecificStack[ $this->_deep ] );
        $this->_deep--;
		array_pop( $this->_elementStack );
		return array_pop( self::$_elementStackStatic);
	}

	public function isElementInStack( $elementId ) {
		return in_array( $elementId, $this->_elementStack );
	}

	public function getElementStack() {
		return $this->_elementStack;
	}

	public function getElementStackStatic() {
		return self::$_elementStackStatic;
	}

	public function addSystemOptionsToStack( $systemOptions ) {
		$this->_systemOptionsStack[] = $systemOptions;
	}

	public function removeSystemOptionsFromStack() {
		return array_pop( $this->_systemOptionsStack);
	}

	public function getSystemOptionsFromStack() {
		return end( $this->_systemOptionsStack );
	}

    public function getElementSpecificStack( $name = null) {
        $deep = $this->_deep;

        if( $name == null && isset( $this->_elementSpecificStack[ $deep ])) {
            return $this->_elementSpecificStack[ $deep ];
        } else if( $name == null ) {
            return null;
        }

        if( isset( $this->_elementSpecificStack[ $deep ] ) && isset( $this->_elementSpecificStack[ $deep ][ $name ] ) ) {
            return $this->_elementSpecificStack[ $deep ][ $name ];
        }

        return null;
    }

    public function setElementSpecificStack( $name, $value ) {
        $deep = $this->_deep;

        if( !isset( $this->_elementSpecificStack[ $deep ] ) ) {
            $this->_elementSpecificStack[ $deep ] = [];
        }

        $this->_elementSpecificStack[ $deep ][ $name ] = $value;
    }

    public function addToElementSpecificStack( $name, $value ) {
        $deep = $this->_deep;

        if( !isset( $this->_elementSpecificStack[ $deep ] ) ) {
            $this->_elementSpecificStack[ $deep ] = [];
        }

        if( !isset( $this->_elementSpecificStack[ $deep ][ $name ] ) ) {
            $this->_elementSpecificStack[ $deep ][ $name ] = [];
        }

        if( is_array( $this->_elementSpecificStack[ $deep ][ $name ] ) ) {
            $this->_elementSpecificStack[ $deep ][ $name ][] = $value;
        } else {
            ffStopWatch::addVariableDumpString('Element Status Holder -> AddToElementSpecificStack - value is not array, but trying to add array');
        }
    }


/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/
	private function _makeSureCustomStackIsArray( $stackName ) {
		if( !isset( $this->_customStack[ $stackName ] ) ) {
			$this->_customStack[ $stackName ] = array();
		}
	}
/**********************************************************************************************************************/
/* ABSTRACT FUNCTIONS
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/
}