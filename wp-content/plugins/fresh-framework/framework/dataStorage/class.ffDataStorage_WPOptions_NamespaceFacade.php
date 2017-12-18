<?php

class ffDataStorage_WPOptions_NamespaceFacede {
	/**
	 * 
	 * @var ffDataStorage_WPOptions
	 */
	private $_WPOptions = null;
	
	private $_namespace = null;
	
	public function __construct( ffDataStorage_WPOptions $WPOptions, $namespace = null) {
		$this->_WPOptions = $WPOptions;
		$this->_namespace = $namespace;
	}
	
	public function setNamespace( $namespace ) {
		$this->_namespace = $namespace;
	}

	public function getAllOptionsForNamespace( $namespace = null ) {

		if( $namespace == null ) {
			$namespace = $this->_namespace;
		}

		$nameToSearch = $this->_WPOptions->getFullOptionName( $namespace, '');

		$wpdb = ffContainer()->getWPLayer()->getWPDB();

		$sql = 'SELECT option_name FROM '. $wpdb->options . ' WHERE option_name LIKE "' . $nameToSearch . '%"';

		$result = $wpdb->get_results( $sql );

		$options = array();

		if( !empty( $result ) ) {
			foreach( $result as $oneItem ) {
				$itemNameClean = str_replace( $nameToSearch, '', $oneItem->option_name);
				$options[] = $itemNameClean;
			}
		}

		return $options;
	}
	
	public function getOption( $name, $default = null ) {
		return $this->_WPOptions->getOption( $this->_namespace, $name, $default);
	}
	
	public function setOption( $name, $value ) {
		return $this->_WPOptions->setOption( $this->_namespace, $name, $value);
	}

	public function getOptionCodedJson( $name, $default = null ) {
		$value = $this->getOption($name, $default);

		if( is_string( $value ) ) {
			$value = json_decode( $value, true );
		}

		return $value;
	}

	public function setOptionCodedJson( $name, $value ) {
//		$value = serialize( $value );
//		$value = base64_encode( $value );

		$value = json_encode( $value );
		$this->setOption( $name, $value);
	}

	public function getOptionCoded( $name, $default = null ) {
		$value = $this->getOption($name, $default);
		
		$value = base64_decode( $value );
		$value = unserialize( $value );
		
		return $value;
	}
	
	public function setOptionCoded( $name, $value ) {
		$value = serialize( $value );
		$value = base64_encode( $value );
		
		$this->setOption( $name, $value);
	}
	
	public function deleteOption( $name ) {
		return $this->_WPOptions->deleteOption( $this->_namespace, $name);
	}
	
	public function deleteNamespace() {
		// TODO
	}
	
	
	public function addToOption( $name, $value ) {
		$optionCurrentValue = $this->getOption( $name );
		if( empty( $optionCurrentValue ) ) {
			$optionCurrentValue = array();
		}
		
		if( !is_array( $optionCurrentValue ) ) {
			return false;
		}
		
		if( !is_array($value ) ) {
			$value = array($value);
		} 
		
		$optionCurrentValue = array_merge( $optionCurrentValue, $value);
		
		$this->setOption( $name, $optionCurrentValue);
	}
}