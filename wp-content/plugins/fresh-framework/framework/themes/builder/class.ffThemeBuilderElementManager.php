<?php

/**
 * Class ffThemeBuilderElementManager
 */
class ffThemeBuilderElementManager extends ffBasicObject {
	/**********************************************************************************************************************/
	/* OBJECTS
	/**********************************************************************************************************************/
	/**
	 * @var ffCollection[ffThemeBuilderElement]
	 */
	private $_elementCollection = null;

	/**
	 * @var ffThemeBuilderElementFactory
	 */
	private $_themeBuilderElementFactory = null;

	/**
	 * @var ffThemeBuilderBlockManager
	 */
	private $_themeBuilderBlockManager = null;

	/**
	 * @var ffThemeBuilderShortcodesStatusHolder
	 */
	private $_statusHolder = null;

	/**
	 * @var ffCollection
	 */
	private $_menuItemCollection = null;

	/**
	 * @var ffThemeBuilderColorLibrary
	 */
	private $_colorLibrary;

	/**********************************************************************************************************************/
	/* PRIVATE VARIABLES
	/**********************************************************************************************************************/

	private $_isEditMode = false;
	/**********************************************************************************************************************/
	/* CONSTRUCT
	/**********************************************************************************************************************/
	public function __construct( ffCollection $elementCollection,
	                             ffCollection $menuItemCollection,
	                             ffThemeBuilderElementFactory $elementFactory,
	                             ffThemeBuilderShortcodesStatusHolder $statusHolder,
	                             ffThemeBuilderColorLibrary $colorLibrary ) {

		$this->_setElementCollection( $elementCollection );
		$this->_setMenuItemCollection( $menuItemCollection );
		$this->_setThemeBuilderElementFactory( $elementFactory );
		$this->_setThemeBuilderBlockManager( ffContainer()->getThemeFrameworkFactory()->getThemeBuilderBlockManager() ) ;
		$this->_setStatusHolder( $statusHolder );
		$this->_setColorLibrary( $colorLibrary );
	}

	public function addOverloadedElement( $elementClassName, $overloadedElementClassName ) {

		$this->_getThemeBuilderElementFactory()->loadElement( $overloadedElementClassName );
		$this->addElement( $elementClassName );
	}

	public function addElement( $elementClassName ) {


		$element = $this->_getThemeBuilderElementFactory()->createElement( $elementClassName );
		$element->setIsEditMode( $this->_isEditMode );
		$this->_getElementCollection()->addItem( $element, $element->getID() );
	}

	public function addMenuItem( $name, $id ) {
		$menuItem = new ffStdClass();
		$menuItem->name = $name;
		$menuItem->id = $id;

		$menuItemArray = $menuItem->getArray();

		$this->_getMenuItemCollection()->addItem( $menuItemArray, $id );
	}

	public function getAllElementsIds() {
		$toReturn = [];

		foreach( $this->_getElementCollection() as $key => $value ) {
			$toReturn[] = $key;
		}

		return $toReturn;
	}

	public function setIsEditMode( $value ) {
		$this->_isEditMode = $value;
		foreach( $this->_getElementCollection() as $oneItem ) {
			$oneItem->setIsEditMode( $value );
		}
	}

	public function getNonCacheableElements() {
		/**
		 * @var $oneElement ffThemeBuilderElement
		 */
		$nonCacheableElements = array();
		foreach( $this->_getElementCollection() as $oneElement ) {
			if( !$oneElement->getCanBeCached() ) {
				$nonCacheableElements[] = $oneElement->getID();
			}
		}

		return $nonCacheableElements;
	}

	public function getElementsData( $position = 0, $loadHash = null) {

		$data = array();
		$data['elements'] = array();
		/**
		 * @var $element ffThemeBuilderElementBasic
		 */

		$cache = ffContainer()->getDataStorageCache();

//		$lastPositionHash = $cache->getOption('freshbuilder-loading', 'hash-' . $loadHash);

//		if( $lastPositionHash > $position ) {
//			$position = $lastPositionHash;
//		}


		$data['blocks'] = $cache->getOption('freshbuilder', 'blocks');
		$data['blocks'] = json_decode( $data['blocks'], true );
		if( !is_array( $data['blocks'] ) ) {
			$data['blocks'] = array();
		}

		$data['blocks_functions'] = $cache->getOption('freshbuilder', 'blocks_functions');
		$data['blocks_functions'] = json_decode( $data['blocks_functions'], true );
		if( !is_array( $data['blocks_functions'] ) ) {
			$data['blocks_functions'] = array();
		}

		$counter = -1;

		$made = 0;

		$currentCounter = 0;

		$startUsage = (memory_get_usage() / (1024*1024));

		foreach( $this->_getElementCollection() as $id => $element ) {

			$counter++;

			if ($counter < $position) {
				continue;
			}

			$time = $cache->getScriptExecutionTime();
			$maxTime = (int)ini_get('max_execution_time');

			if( $maxTime < 30 ) {
				$maxTime = 30;
			}

			if( $time > ( $maxTime - 7 ) ) {
				break;
			}

			$currentCounter++;

			if( $element->getIsHidden() ) {
				$made++;
				continue;
			}

			$currentUsage = (memory_get_usage() / (1024*1024));

			if( $currentUsage > $startUsage + 6  ) {
				break;
			}

			$data['elements'][$id ] = $element->getElementDataForBuilder();

			$data['blocks'] = array_merge( $data['blocks'],  $this->_getThemeBuilderBlockManager()->getBlocksData() );
			$cache->setOption('freshbuilder', 'blocks', json_encode($data['blocks']));

			$data['blocks_functions'] = array_merge( $data['blocks_functions'],  $this->_getThemeBuilderBlockManager()->getBlocksJSFunctions() );
			$cache->setOption('freshbuilder', 'blocks_functions', json_encode($data['blocks_functions']));

			$made++;

//			$cache->setOption('freshbuilder-loading', 'hash-' . $loadHash, $position + $made);
		}

		$data['should_continue'] = $position + $made;
		$numberOfAllElements = $this->_getElementCollection()->count();
		$data['builder_message'] = 'Loading elements ' . $data['should_continue'] . ' / ' .$numberOfAllElements;


		if( $counter < ( $position + $made ) ) {
			$data['should_continue'] = 0;
			$data['builder_message'] = 'Loading environment - last step';
		}

		$data['menuItems'] = array();
		foreach( $this->_getMenuItemCollection() as $id => $menuItem ) {
			$data['menuItems'][$id] = $menuItem;
		}

		$data = json_encode( $data );

		$cache->setOption('freshbuilder', 'all-positions-' . $position, $data);

		return $data;







		return;

		$step = 30;

		$cache = ffContainer()->getDataStorageCache();

		$data = $cache->getOption('freshbuilder', 'all-positions-' . $position);

		$data = null;

//		ini_set('memory_limit','10M');
		if( $data == null ) {

//			$rand = rand(1,10);
//
//			if( $rand <  5) {
//				die();
//			}

			$data = array();
			$data['elements'] = array();
			/**
			 * @var $element ffThemeBuilderElementBasic
			 */

			$data['blocks'] = $cache->getOption('freshbuilder', 'blocks');
			$data['blocks'] = json_decode( $data['blocks'], true );
			if( !is_array( $data['blocks'] ) ) {
				$data['blocks'] = array();
			}

			$data['blocks_functions'] = $cache->getOption('freshbuilder', 'blocks_functions');
			$data['blocks_functions'] = json_decode( $data['blocks_functions'], true );
			if( !is_array( $data['blocks_functions'] ) ) {
				$data['blocks_functions'] = array();
			}

			$counter = -1;

			$made = 0;

			foreach( $this->_getElementCollection() as $id => $element ) {

				$counter++;

				if( $counter < $position ) {
					continue;
				}

				if( $counter >= ( $position + $step ) ) {
					break;
				}

				$made++;



				if( $element->getIsHidden() ) {
					continue;
				}

				$time = $cache->getScriptExecutionTime();
				$maxTime = (int)ini_get('max_execution_time');

				if( $maxTime < 30 ) {
					$maxTime = 30;
				}

				if( $time > ( $maxTime - 5 ) ) {
					break;
				}


				$data['elements'][$id ] = $element->getElementDataForBuilder();

				$data['blocks'] = array_merge( $data['blocks'],  $this->_getThemeBuilderBlockManager()->getBlocksData() );
				$cache->setOption('freshbuilder', 'blocks', json_encode($data['blocks']));

				$data['blocks_functions'] = array_merge( $data['blocks_functions'],  $this->_getThemeBuilderBlockManager()->getBlocksJSFunctions() );
				$cache->setOption('freshbuilder', 'blocks_functions', json_encode($data['blocks_functions']));

			}

			$data['should_continue'] = $position + $made;
			$numberOfAllElements = $this->_getElementCollection()->count();
			$data['builder_message'] = 'Loading elements ' . $data['should_continue'] . ' / ' .$numberOfAllElements;


			if( $counter < ( $position + $made ) ) {
				$data['should_continue'] = 0;
				$data['builder_message'] = 'Loading environment - last step';
			}





			$data['menuItems'] = array();
			foreach( $this->_getMenuItemCollection() as $id => $menuItem ) {
				$data['menuItems'][$id] = $menuItem;
			}

			$data = json_encode( $data );

			$cache->setOption('freshbuilder', 'all-positions-' . $position, $data);
		}

		return $data;















		return;

//		ini_set('memory_limit','20M');
		$cache = ffContainer()->getDataStorageCache();
		$data = null;

		if( defined('FF_BUILDER_CACHE') && FF_BUILDER_CACHE == false ) {
			$data = null;
		} else {
			$data = $cache->getOption('freshbuilder', 'all' );
		}
//
//
		if( empty( $data ) ) {



			$data = array();
			$data['elements'] = array();
			/**
			 * @var $element ffThemeBuilderElementBasic
			 */

			$data['blocks'] = $cache->getOption('freshbuilder', 'blocks');
			$data['blocks'] = json_decode( $data['blocks'], true );
			if( !is_array( $data['blocks'] ) ) {
				$data['blocks'] = array();
			}

			$data['blocks_functions'] = $cache->getOption('freshbuilder', 'blocks_functions');
			$data['blocks_functions'] = json_decode( $data['blocks_functions'], true );
			if( !is_array( $data['blocks_functions'] ) ) {
				$data['blocks_functions'] = array();
			}

//			if( $data['blocks'] == null ) $data['blocks'] = array();
//			else $data['blocks'] = json_decode( $data['blocks'], true );



//			$data['blocks_functions'] = $cache->getOption('freshbuilder', 'blocks_functions');
//			if( $data['blocks_functions'] == null ) $data['blocks_functions'] = array();
//			else $data['blocks_functions'] = json_decode( $data['blocks_functions'], true );

			foreach( $this->_getElementCollection() as $id => $element ) {
				if( $element->getIsHidden() ) {
					continue;
				}

				$time = $cache->getScriptExecutionTime();
				if( $time > 25 ) {
					die();
				}

				$data['elements'][$id ] = $element->getElementDataForBuilder();

				$data['blocks'] = array_merge( $data['blocks'],  $this->_getThemeBuilderBlockManager()->getBlocksData() );
				$cache->setOption('freshbuilder', 'blocks', json_encode($data['blocks']));

				$data['blocks_functions'] = array_merge( $data['blocks_functions'],  $this->_getThemeBuilderBlockManager()->getBlocksJSFunctions() );
				$cache->setOption('freshbuilder', 'blocks_functions', json_encode($data['blocks_functions']));

			}

			$data['menuItems'] = array();
			foreach( $this->_getMenuItemCollection() as $id => $menuItem ) {
				$data['menuItems'][$id] = $menuItem;
			}

			$cache->setOption('freshbuilder', 'all', json_encode($data));

		} else {
			$data = json_decode( $data, true );
		}


		return $data;
	}

	/**
	 * @param $id
	 * @return ffThemeBuilderElement
	 */
	public function getElementById( $id ) {
		return $this->_getElementCollection()->getItemById( $id );
	}
	/**********************************************************************************************************************/
	/* PUBLIC FUNCTIONS
	/**********************************************************************************************************************/

	/**********************************************************************************************************************/
	/* PUBLIC PROPERTIES
	/**********************************************************************************************************************/
	public function getElementsCollection() {
		return $this->_getElementCollection();
	}
	/**********************************************************************************************************************/
	/* PRIVATE FUNCTIONS
	/**********************************************************************************************************************/

	/**********************************************************************************************************************/
	/* PRIVATE GETTERS & SETTERS
	/**********************************************************************************************************************/
	/**
	 * @return ffCollection
	 */
	private function _getElementCollection()
	{
		return $this->_elementCollection;
	}

	/**
	 * @param ffCollection $elementCollection
	 */
	private function _setElementCollection($elementCollection)
	{
		$this->_elementCollection = $elementCollection;
	}

	/**
	 * @return ffThemeBuilderElementFactory
	 */
	private function _getThemeBuilderElementFactory()
	{
		return $this->_themeBuilderElementFactory;
	}

	/**
	 * @param ffThemeBuilderElementFactory $themeBuilderElementFactory
	 */
	private function _setThemeBuilderElementFactory($themeBuilderElementFactory)
	{
		$this->_themeBuilderElementFactory = $themeBuilderElementFactory;
	}

	/**
	 * @return ffCollection
	 */
	private function _getMenuItemCollection()
	{
		return $this->_menuItemCollection;
	}

	/**
	 * @param ffCollection $menuItemCollection
	 */
	private function _setMenuItemCollection($menuItemCollection)
	{
		$this->_menuItemCollection = $menuItemCollection;
	}

	/**
	 * @return ffThemeBuilderBlockManager
	 */
	private function _getThemeBuilderBlockManager() {
		return $this->_themeBuilderBlockManager;
	}

	/**
	 * @param ffThemeBuilderBlockManager $themeBuilderBlockManager
	 */
	private function _setThemeBuilderBlockManager($themeBuilderBlockManager) {
		$this->_themeBuilderBlockManager = $themeBuilderBlockManager;
	}

	/**
	 * @return ffThemeBuilderShortcodesStatusHolder
	 */
	public function getStatusHolder() {
		return $this->_statusHolder;
	}

	/**
	 * @param ffThemeBuilderShortcodesStatusHolder $statusHolder
	 */
	private function _setStatusHolder($statusHolder) {
		$this->_statusHolder = $statusHolder;
	}

	/**
	 * @return ffThemeBuilderColorLibrary
	 */
	private function _getColorLibrary() {
		return $this->_colorLibrary;
	}

	/**
	 * @param ffThemeBuilderColorLibrary $colorLibrary
	 */
	private function _setColorLibrary($colorLibrary) {
		$this->_colorLibrary = $colorLibrary;
	}

}