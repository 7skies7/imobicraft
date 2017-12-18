<?php

class ffOptionsCollection extends ffCollectionAdvanced {
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/
    private $_namespace = null;

	private $_themeName = null;

	private $_allItemsHasBeenLoaded = false;

	private $_doNotLoad = false;

	/**
	 * @var ffDataStorage_WPOptions_NamespaceFacede
	 */
	private $_WPOptions = null;

	/**
	 * @var ffArrayQueryFactory
	 */
	private $_arrayQueryFactory = null;

	private $_defaultItemId = array();

	private $_defaultItemCallback = array();

/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
	public function __construct( $WPOptions, $arrayQueryFactory) {
		parent::__construct();

		$this->_setWPOptions( $WPOptions );
		$this->_setArrayQueryFactory( $arrayQueryFactory );
	}

/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/

	public function loadAllItems() {
		if( $this->_allItemsHasBeenLoaded || $this->_doNotLoad ) {
			$this->addDefaultItemCallbacksFromThemeFolder();
			return;
		}

		$this->_allItemsHasBeenLoaded = true;

		$allItemsFromDb = $this->_getWPOptions()->getAllOptionsForNamespace();
		$allItems = $this->_addMissingDefaultItems( $allItemsFromDb );

		foreach( $allItems as $oneItemName ) {
			$data = $this->_getWPOptions()->getOptionCodedJson( $oneItemName );

			if( $data == null ) {
				continue;
			}

			$arrayQuery = $this->_getArrayQueryFactory()->createArrayQuery( $data );
			$arrayQuery->setId( $oneItemName );

			$isDefault = (int)in_array( $oneItemName, $this->_defaultItemId );
			$arrayQuery->setAttr('default', $isDefault);

			$this->addItem( $arrayQuery, $oneItemName );
		}
	}

	protected function _addMissingDefaultItems( $allItemsFromDb ) {
		$newItems = $allItemsFromDb;
		foreach( $this->_defaultItemId as $oneDefaultItemId ) {
			// this item does not exists or has been deleted
			if( !in_array( $oneDefaultItemId, $allItemsFromDb ) ) {
				$this->_createAndInsertDefaultItem( $oneDefaultItemId );
				$newItems[] = $oneDefaultItemId;
			}
		}

		return $newItems;
	}

	private $_hasBeenAdded = false;

	public function addDefaultItemCallbacksFromThemeFolder() {
		if( $this->_hasBeenAdded)  {
			return true;
		}
		$namespace = $this->_getNamespace();
		$fs = ffContainer()->getFileSystem();
		$WPLayer = ffContainer()->getWPLayer();

		$dir = $WPLayer->get_template_directory() . '/default/' . $namespace;

		$list = $fs->dirlist( $dir );

		if( empty( $list ) ) {
			return;
		}

		foreach( $list as $oneItem ) {
			$nameClean = str_replace('.json', '', $oneItem['name']);
			$this->addDefaultItemCallback( $nameClean, array( $this, '_getDefaultItemCallbackFromThemeFolder') );
		}
	}

	private function _getDefaultItemCallbackFromThemeFolder( $oneItemId ) {

		$namespace = $this->_getNamespace();
		$fs = ffContainer()->getFileSystem();
		$WPLayer = ffContainer()->getWPLayer();

		$path = $WPLayer->get_template_directory() . '/default/' . $namespace .'/' . $oneItemId . '.json';

		$contentJSON = $fs->getContents( $path );
		$content = json_decode( $contentJSON, true );

		return $content;
	}

	public function addDefaultItemCallback( $id, $callback ) {
		$this->_defaultItemId[] = $id;
		$this->_defaultItemCallback[$id] = $callback;

	}

	public function getItemFromDB( $id ) {
		return $this->_getWPOptions()->getOptionCodedJson( $id );
	}

	public function deleteItemFromDB( $id ) {
		$this->offsetUnset( $id );
		return $this->_getWPOptions()->deleteOption( $id );
	}

	public function getItemById($id, $returnNullIfDoesNotExists = false ) {

		$item = parent::getItemById( $id );

		if( $item == null ) {
			$data = $this->getItemFromDB( $id );


			if( $data != null ) {
				$arrayQuery = $this->_getArrayQueryFactory()->createArrayQuery( $data );
				$arrayQuery->setId( $id );
				$this->addItem( $arrayQuery, $id );
			} else if( $data == null && $this->_isDefaultItem( $id ) ){

				$def = $this->_createAndInsertDefaultItem( $id );
				$arrayQuery = $this->_getArrayQueryFactory()->createArrayQuery( $def );
				$arrayQuery->setId( $id );
				return $arrayQuery;
			}
			else {
				if( $returnNullIfDoesNotExists ) {
					return null;
				} else {
					return $this->_getArrayQueryFactory()->createArrayQuery( $data );
				}
			}
		} else {
			return $item;
		}

		return parent::getItemById($id); // TODO: Change the autogenerated stub
	}

	public function setItemToDb( $id, $item ) {
		if( is_object( $item ) && get_class( $item ) == 'ffArrayQuery' ) {
			$item = $item->getData();
		}
		$this->_getWPOptions()->setOptionCodedJson( $id, $item );
	}

	public function save() {
		$this->_doNotLoad = true;
		foreach( $this as $key => $oneItem ) {
			if( $oneItem->hasBeenChanged() == false ) {
				continue;
			}

			$data = $oneItem->getData();
			$this->setItemToDb( $key, $data );
		}
		$this->_doNotLoad = false;
	}

	private function _isDefaultItem( $itemId ) {
		$this->addDefaultItemCallbacksFromThemeFolder();
		return in_array( $itemId, $this->_defaultItemId );
	}

	private function _createAndInsertDefaultItem( $id) {
		$defaultItem = $this->_getDefaultItemData( $id );
		$this->setItemToDb( $id, $defaultItem );
		return $defaultItem;
	}

	private function _getDefaultItemData( $id ) {
		return call_user_func( $this->_defaultItemCallback[ $id ], $id );
	}

/**********************************************************************************************************************/
/* OVERLOADING
/**********************************************************************************************************************/
	public function rewind() {
		$this->loadAllItems();
		parent::rewind();
	}
/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/
	private function _generateNamespaceForOptions() {
		$newNamespace = array();
		$themeName = $this->_getThemeName();
		$namespace = $this->_getNamespace();

		if( $themeName != null ) {
			$newNamespace[] = $themeName;
		}

		if( $namespace != null ) {
			$newNamespace[] = $namespace;
		}

		return implode('_', $newNamespace);
	}

/**********************************************************************************************************************/
/* ABSTRACT FUNCTIONS
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/
	/**
	 * @return null
	 */
	private function _getThemeName() {
		return $this->_themeName;
	}

	public function setNamespace( $namespace ) {
		$this->_setNamespace( $namespace );
	}

	public function setThemeName( $themeName ) {
		$this->_setThemeName( $themeName );
	}

	/**
	 * @param null $themeName
	 */
	private function _setThemeName($themeName) {
		$this->_themeName = $themeName;
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

	/**
	 * @return ffDataStorage_WPOptions_NamespaceFacede
	 */
	private function _getWPOptions() {
		$this->_WPOptions->setNamespace( $this->_generateNamespaceForOptions() );
		return $this->_WPOptions;
	}

	/**
	 * @param ffDataStorage_WPOptions_NamespaceFacede $WPOptions
	 */
	private function _setWPOptions($WPOptions) {
		$this->_WPOptions = $WPOptions;
	}

	/**
	 * @return ffArrayQueryFactory
	 */
	private function _getArrayQueryFactory() {
		return $this->_arrayQueryFactory;
	}

	/**
	 * @param ffArrayQueryFactory $arrayQueryFactory
	 */
	private function _setArrayQueryFactory($arrayQueryFactory) {
		$this->_arrayQueryFactory = $arrayQueryFactory;
	}




}