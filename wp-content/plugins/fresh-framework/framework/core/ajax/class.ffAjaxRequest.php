<?php
/**
 * This class automatically loads all necessary files. It will be also used
* across the whole template, when you need to load something dynamically
* @author freshface
* @since 1.1.2
*/
class ffAjaxRequest extends ffBasicObject {
/******************************************************************************/
/* VARIABLES AND CONSTANTS
/******************************************************************************/
	public $owner = NULL;
	
	public $specification = NULL;

	public $data = NULL;
/******************************************************************************/
/* CONSTRUCT AND PUBLIC FUNCTIONS
/******************************************************************************/
	public function getData( $name, $default = null ) {
        if( isset( $this->data[ $name ] ) ) {
            if( is_array( $this->data[$name ])  ) {
                return $this->data[ $name ];
            } else {
                return stripslashes($this->data[ $name ]);
            }
        } else {
            return $default;
        }
    }

	public function getSpecification( $name, $default = null ) {
		if( isset( $this->specification[ $name ] ) ) {
			if( is_array( $this->specification[$name ])  ) {
				return $this->specification[ $name ];
			} else {
				return stripslashes($this->specification[ $name ]);
			}
		} else {
			return $default;
		}
	}

	public function getDataStripped( $name = null, $default = null ) {

		if( $name == null ) {
			if( is_array( $this->data ) ) {
				return stripslashes_deep( $this->data );
			} else {
				return stripslashes( $this->data );
			}
		}

		if( isset( $this->data[ $name ] ) ) {
			if( is_array( $this->data[$name ])  ) {
				return stripslashes_deep($this->data[ $name ]);
			} else {
				return stripslashes($this->data[ $name ]);
			}
		} else {
			return $default;
		}
	}

//	function stripslashesFull($input)
//	{
//		if (is_array($input)) {
//			$input = array_map('stripslashesFull', $input);
//		} elseif (is_object($input)) {
//			$vars = get_object_vars($input);
//			foreach ($vars as $k=>$v) {
//				$input->{$k} = $this->stripslashesFull($v);
//			}
//		} else {
//			$input = stripslashes($input);
//		}
//		return $input;
//	}
/******************************************************************************/
/* PRIVATE FUNCTIONS
/******************************************************************************/	
	
/******************************************************************************/
/* SETTERS AND GETTERS
/******************************************************************************/
}