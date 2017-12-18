<?php

class ffThemeBuilderBlockManager extends ffBasicObject {
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/
	/**
	 * @var ffThemeBuilderBlockFactory
	 */
	private $_themeBuilderBlockFactory = null;

	/**
	 * @var ffCollection
	 */
	private $_blockCollection = null;

	/**
	 * @var ffCollection
	 */
	private $_blockStructureCollection = null;

/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/

	/**
	 * @var bool
	 */
	private $_isEditMode = false;

/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
	public function __construct() {
		$this->_setThemeBuilderBlockFactory( ffContainer()->getThemeFrameworkFactory()->getThemeBuilderBlockFactory() );
		$this->_setBlockCollection( ffContainer()->createNewCollection() );
		$this->_setBlockStructureCollection( ffContainer()->createNewCollection() );
	}

/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/

	public function getBlocksData() {
		return $this->_getBlockStructureCollection()->convertToArray();
	}

	public function getBlocksJSFunctions() {
		$toReturn = array();

		foreach( $this->_getBlockCollection() as $key => $block ) {
			$toReturn[ $block->getId() ] = $block->getJSFunction();
		}

		return $toReturn;
	}

	public function blockOptionsStructureExists( $id ) {
		return $this->_getBlockStructureCollection()->offsetExists( $id );
	}

	public function addBlockOptionsStructure( $id, $structure ) {
		$collection = $this->_getBlockStructureCollection();

		if( !$collection->offsetExists( $id ) ) {

			$structureJSON = json_encode(ffContainer()->getOptionsFactory()->createOptionsPrinterJSONConvertor( null, $structure )->walk());

			$this->_getBlockStructureCollection()->addItem( $structureJSON, $id );
		}

	}

	/**
	 * @param $className
	 * @return ffThemeBuilderBlock
	 */
	public function getBlock( $className ) {
		$block = $this->_getBlockCollection()->getItemById( $className );
		if( $block == null ) {
			$this->addBlock( $className );
		}

		return $this->_getBlockCollection()->getItemById( $className )->reset();
	}

	public function addBlock( $className ) {
		$block = $this->_getThemeBuilderBlockFactory()->createBlock( $className );
		$block->setIsEditMode( $this->_getIsEditMode() );
		$block->setBlockManager( $this );
		$this->_getBlockCollection()->addItem( $block, $className );
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
	 * @return ffThemeBuilderBlockFactory
	 */
	private function _getThemeBuilderBlockFactory() {
		return $this->_themeBuilderBlockFactory;
	}

	/**
	 * @param ffThemeBuilderBlockFactory $themeBuilderBlockFactory
	 */
	private function _setThemeBuilderBlockFactory($themeBuilderBlockFactory) {
		$this->_themeBuilderBlockFactory = $themeBuilderBlockFactory;
	}

	/**
	 * @return ffThemeBuilderBlock[]
	 */
	private function _getBlockCollection() {
		return $this->_blockCollection;
	}

	/**
	 * @param ffCollection $blockCollection
	 */
	private function _setBlockCollection($blockCollection) {
		$this->_blockCollection = $blockCollection;
	}

	/**
	 * @return boolean
	 */
	private function _getIsEditMode() {
		return $this->_isEditMode;
	}

	/**
	 * @param boolean $isEditMode
	 */
	public function setIsEditMode($isEditMode) {
		$this->_isEditMode = $isEditMode;
	}

	/**
	 * @return ffCollection
	 */
	private function _getBlockStructureCollection() {
		return $this->_blockStructureCollection;
	}

	/**
	 * @param ffCollection $blockStructureCollection
	 */
	private function _setBlockStructureCollection($blockStructureCollection) {
		$this->_blockStructureCollection = $blockStructureCollection;
	}

	

}