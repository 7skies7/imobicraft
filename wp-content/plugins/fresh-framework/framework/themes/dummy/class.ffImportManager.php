<?php

class ffImportManager extends ffBasicObject {

	const STEP_AUTHORS = 1;
	const STEP_CATEGORIES = 2;
	const STEP_TAGS = 3;
	const STEP_TERMS = 4;
	const STEP_POSTS_STARTED = 5;
	const STEP_POSTS_MIDDLE = 6;
	const STEP_FINISH = 7;

/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/
	/**
	 * @var ffWPImporter
	 */
	private $_WPImporter = null;

	/**
	 * @var ffFileSystem
	 */
	private $_fileSystem = null;

	/**
	 * @var ffImportRuleFactory
	 */
	private $_importRuleFactory = null;

	/**
	 * @var ffDataStorage_Cache
	 */
	private $_dataStorageCache = null;

	/**
	 * @var ffDummyContentManager
	 */
	private $_dummyContentManager = null;


/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/
	/**
	 * @var ffCollectionAdvanced[ ffImportRuleBasic ]
	 */
	private $_importRulesCollection = array();

	/**
	 * @var ffCollectionAdvanced[ffImportStepBasic]
	 */
	private $_importStepsCollection = array();

	/**
	 * @var string
	 */
	private $_configFilePath = null;

	/**
	 * @var array
	 */
	private $_configFile = null;

	/**
	 * Contains informations about all the steps we have done before, and which steps we have to do now
	 * @var array
	 */
	private $_environment = null;

	/**
	 * How many posts we want to import in one batch
	 * @var int
	 */
	private $_numberOfPostsInOneBatch = 10;

	/**
	 * Status message to communicate with outside world
	 * @var array
	 */
	private $_statusMessage = array();

/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
	/**
	 * ffImportManager constructor.
	 * @param $WPImporter ffWPImporter
	 */
	public function __construct( $WPImporter, $fileSystem, $importRuleFactory, $dummyContentManager ) {
		$this->_setWPImporter( $WPImporter );
		$this->_setFileSystem( $fileSystem );
		$this->_setImportRuleFactory( $importRuleFactory );
		$this->_setImportRulesCollection( ffContainer()->createNewCollectionAdvanced() );
		$this->_setImportStepsCollection(ffContainer()->createNewCollectionAdvanced() );
		$this->_setDataStorageCache( ffContainer()->getDataStorageCache() );
		$this->_setDummyContentManager( $dummyContentManager );
    }

	public function importFileInSteps( $configFile ) {
		$this->_setConfigFilePath( $configFile );
		$this->_loadImportRules();
		$this->_loadImportSteps();
		$this->_loadEnvironment();

		return $this->_runImportStep();
	}

/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/
	public function getStatusMessage() {
		$this->_setStatusStepMax( 7 + $this->_getImportStepsCollection()->count() );
		return $this->_statusMessage;
	}

/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/
	private function _runImportStep() {
		$lastStep = $this->_getEnvironmentValue('last-step', 0 );

		$currentStep = $lastStep + 1;

		$importFilePath = $this->_getDemoFolderPath() . '/' . $this->_getConfigValue('demo-file');
//		var_dump( $importFilePath );

		$wpImporter = $this->_getWPImporter();

		$wpImporter->setImportFile( $importFilePath );

		if( $this->_getEnvironmentValue('importer-state' ) != null ) {
			$wpImporter->setState( $this->_getEnvironmentValue('importer-state') );
		}

		$rulesCollection = $this->_getImportRulesCollection();

		ob_start();
		switch( $currentStep ) {
			// import never started
			case ffImportManager::STEP_AUTHORS:
				$rulesCollection->callFunctionOnItems('beforeImportAuthors');
				$wpImporter->importAuthors();
				$this->_setStatusStep(1);
				$this->_setStatusMessage('Authors imported');
				$rulesCollection->callFunctionOnItems('afterImportAuthors');
				break;

			case ffImportManager::STEP_CATEGORIES:
				$rulesCollection->callFunctionOnItems('beforeImportCategories');
				$wpImporter->importCategories();
				$this->_setStatusStep(2);
				$this->_setStatusMessage('Categories imported');
				$rulesCollection->callFunctionOnItems('afterImportCategories');
				break;

			case ffImportManager::STEP_TAGS:
				$rulesCollection->callFunctionOnItems('beforeImportTags');
				$wpImporter->importTags();
				$this->_setStatusStep(3);
				$this->_setStatusMessage('Tags imported');
				$rulesCollection->callFunctionOnItems('afterImportTags');
				break;

			case ffImportManager::STEP_TERMS:
				$rulesCollection->callFunctionOnItems('beforeImportTerms');
				$wpImporter->importTerms();
				$this->_setStatusStep(4);
				$this->_setStatusMessage('Terms imported');
				$rulesCollection->callFunctionOnItems('afterImportTerms');
				break;

			case ffImportManager::STEP_POSTS_STARTED:
				$rulesCollection->callFunctionOnItems('beforeImportPostsAll');

				$numberOfPostsInOneBatch = $this->_getNumberOfPostsInOneBatch();

				$this->_setEnvironmentValue('last-post-batch', 0);
				$this->_setStatusStep(5);
				$this->_setStatusMessage('Post importing');
				$this->_setStatusProgress($numberOfPostsInOneBatch, $wpImporter->getNumberOfPosts() );
				$wpImporter->setNumberOfPostsForImport(0, $numberOfPostsInOneBatch );
				$rulesCollection->callFunctionOnItems('beforeImportPostsBatch');

				$wpImporter->importPosts();
				$rulesCollection->callFunctionOnItems('afterImportPosts');
				break;

			case ffImportManager::STEP_POSTS_MIDDLE:

				$numberOfPosts = $wpImporter->getNumberOfPosts();
				$lastBatchNumber = $this->_getEnvironmentValue('last-post-batch');
				$currentBatchNumber = $lastBatchNumber + 1;

				$numberOfBatches = ceil ($numberOfPosts / $this->_getNumberOfPostsInOneBatch() ) ;

				if( $currentBatchNumber < $numberOfBatches ) {
					$postOffset = $this->_getNumberOfPostsInOneBatch()  * $currentBatchNumber;
					$rulesCollection->callFunctionOnItems('beforeImportPostsAll');


					$this->_setStatusStep(6);
					$this->_setStatusMessage('Post importing');
					$this->_setStatusProgress($postOffset + $this->_getNumberOfPostsInOneBatch(), $wpImporter->getNumberOfPosts() );
					$wpImporter->setNumberOfPostsForImport( $postOffset, $this->_getNumberOfPostsInOneBatch() );


					$rulesCollection->callFunctionOnItems('beforeImportPostsBatch');
					$wpImporter->importPosts();
					$currentStep = $currentStep -1;
					$rulesCollection->callFunctionOnItems('afterImportPosts');
					$this->_setEnvironmentValue('last-post-batch', $currentBatchNumber );

					echo '<script>';
						echo 'location.reload();';
					echo '</script>';
				}
				break;

			case ffImportManager::STEP_FINISH;

				$this->_setStatusStep(7);
				$this->_setStatusMessage('Import Finalisation');

				$wpImporter->importEnd();
				break;
		}
		ob_end_clean();
 


		if( $currentStep > ffImportManager::STEP_FINISH ) {
			$importStepId = $currentStep - 8;

			if( $this->_getImportStepsCollection()->offsetExists( $importStepId ) ) {
				/**
				 * @var $importStep ffImportStepBasic
				 */
				$importStep =$this->_getImportStepsCollection()->getItemById( $importStepId );
				$stateForThisImportStep = $this->_getEnvironmentValue( $importStep->getNamespace() );
				$importStep->setState( $stateForThisImportStep );

				$shouldWeContinue = $importStep->runStep();
				$this->_setStatusMessage( $importStep->getMessage() );
				if( $importStep->getMessageStepMax() != null ) {
					$this->_setStatusProgress( $importStep->getMessageStepCurrent(), $importStep->getMessageStepMax() );
				}

				if( $shouldWeContinue ) {
					$stateForSaving = $importStep->getState();
					$this->_setEnvironmentValue( $importStep->getNamespace(), $stateForSaving );
					$currentStep = $currentStep - 1;
				}

			} else {
				/*----------------------------------------------------------*/
				/* THIS IS ACTUAL END HERE MOFOS
				/*----------------------------------------------------------*/
				$this->_addContentToDummyManager();
				$this->_deleteEnvironment();
				return true;
			}
		}

		$this->_setEnvironmentValue( 'last-step', $currentStep );
		$this->_setEnvironmentValue('importer-state', $wpImporter->getState() );
		$this->_saveEnvironment();
		return false;
	}

	private function _addContentToDummyManager() {
		$configPath = $this->_getConfigFilePath();
		$configFile = $this->_configFile;

		$this->_getDummyContentManager()
			->addInstalledDemo( $configPath, $configFile, $this->_getWPImporter() );
	}

	private function _loadEnvironment() {
		$environmentDataJSON = $this->_getDataStorageCache()->getOption('ff-demo-importer', 'environment');
		if( $environmentDataJSON != null ) {
			$environmentData = json_decode( $environmentDataJSON, true);
			$this->_environment = $environmentData;
		}
	}

	private function _loadImportRules() {
		$importRules = $this->_getConfigValue( 'rules', array());
		$demoFolderPath = $this->_getDemoFolderPath();
		$factory = $this->_getImportRuleFactory();

		$fs = ffContainer()->getFileSystem();

		foreach( $importRules as $oneRuleName ) {
			$rulePath = $this->_getDummyFolderPath() .'/dummy-functions/rules/class.' . $oneRuleName . '.php';


//			var_Dump( $rulePath );
			if( !$fs->fileExists( $rulePath ) ) {
				$rulePath = $demoFolderPath .'/rules/class.' . $oneRuleName . '.php';
			}

//			var_Dump( $rulePath );

//			$rulePath = $demoFolderPath .'/rules/class.' . $oneRuleName . '.php';

			$rule = $factory->createImportRule( $oneRuleName, $rulePath );
			$rule->setWPImporter( $this->_getWPImporter() );
			$rule->setConfig( $this->_configFile );
			$rule->register();
			$this->_getImportRulesCollection()
				->addItem( $rule );
		}
	}

	private function _loadImportSteps() {
		$importSteps = $this->_getConfigValue( 'steps', array());
		$demoFolderPath = $this->_getDemoFolderPath();
		$factory = $this->_getImportRuleFactory();

		$fs = ffContainer()->getFileSystem();

		foreach( $importSteps as $oneStepName ) {
			$stepPath = $this->_getDummyFolderPath() .'/dummy-functions/steps/class.' . $oneStepName . '.php';

			if( !$fs->fileExists( $stepPath ) ) {
				$stepPath = $demoFolderPath .'/steps/class.' . $oneStepName . '.php';
			}


			$step = $factory->createImportStep( $oneStepName, $stepPath );

			$step->setWPImporter( $this->_getWPImporter() );
			$step->setConfig( $this->_configFile );
			$this->_getImportStepsCollection()
				->addItem( $step );
		}
	}

/**********************************************************************************************************************/
/* ABSTRACT FUNCTIONS
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/

	private function _setStatusStep( $step ) {
		$this->_statusMessage[ 'step' ] = $step;
	}

	private function _setStatusStepMax( $stepMax ) {
		$this->_statusMessage['step_max'] = $stepMax;
	}

	private function _setStatusMessage( $message ) {
		$this->_statusMessage[ 'message' ] = $message;
	}

	private function _setStatusProgress( $current, $max ) {
		$this->_statusMessage['progress_current'] = $current;
		$this->_statusMessage['progress_max'] = $max;
	}

	private function _getEnvironmentValue( $name, $default = null ) {
		if( isset( $this->_environment[ $name ] ) ) {
			return $this->_environment[ $name ];
		} else {
			return $default;
		}
	}

	private function _setEnvironmentValue( $name, $value ) {
		$this->_environment[ $name ] = $value;
	}

	private function _saveEnvironment() {
		$environmentJSON = json_encode( $this->_environment );
		$this->_getDataStorageCache()->setOption('ff-demo-importer', 'environment', $environmentJSON );
	}

	private function _deleteEnvironment() {
		$this->_getDataStorageCache()->deleteNamespace('ff-demo-importer');
	}

	/**
	 * Get any value from our json configuration file
	 * @param $name
	 * @return mixed
	 */
	private function _getConfigValue( $name, $default = null) {
		if( $this->_configFile == null ) {
			$configFileString = $this->_getFileSystem()->getContents( $this->_getConfigFilePath() );
			$this->_configFile = json_decode( $configFileString, true );
		}

		if( isset($this->_configFile[ $name ]) ) {
			return $this->_configFile[ $name ];
		} else {
			return $default;
		}
	}

	/**
	 * @return ffWPImporter
	 */
	private function _getWPImporter() {
		return $this->_WPImporter;
	}

	/**
	 * @param ffWPImporter $WPImporter
	 */
	private function _setWPImporter($WPImporter) {
		$this->_WPImporter = $WPImporter;
	}

	private function _getDemoFolderPath() {
		return dirname( $this->_getConfigFilePath() );
	}

	private function _getDummyFolderPath() {
		return dirname(dirname( $this->_getConfigFilePath() ));
	}

	/**
	 * @return null
	 */
	private function _getConfigFilePath() {
		return $this->_configFilePath;
	}

	/**
	 * @param null $configFilePath
	 */
	private function _setConfigFilePath($configFilePath) {
		$this->_configFilePath = $configFilePath;
	}

	/**
	 * @return ffFileSystem
	 */
	private function _getFileSystem() {
		return $this->_fileSystem;
	}

	/**
	 * @param ffFileSystem $fileSystem
	 */
	private function _setFileSystem($fileSystem) {
		$this->_fileSystem = $fileSystem;
	}

	/**
	 * @return ffImportRuleFactory
	 */
	private function _getImportRuleFactory() {
		return $this->_importRuleFactory;
	}

	/**
	 * @param ffImportRuleFactory $importRuleFactory
	 */
	private function _setImportRuleFactory($importRuleFactory) {
		$this->_importRuleFactory = $importRuleFactory;
	}

	/**
	 * @return ffCollectionAdvanced[ffImportRule]
	 */
	private function _getImportRulesCollection() {
		return $this->_importRulesCollection;
	}

	/**
	 * @param array $importRulesCollection
	 */
	private function _setImportRulesCollection($importRulesCollection) {
		$this->_importRulesCollection = $importRulesCollection;
	}

	/**
	 * @return ffDataStorage_Cache
	 */
	private function _getDataStorageCache() {
		return $this->_dataStorageCache;
	}

	/**
	 * @param ffDataStorage_Cache $dataStorageCache
	 */
	private function _setDataStorageCache($dataStorageCache) {
		$this->_dataStorageCache = $dataStorageCache;
	}

	private function _setEnvironment( $environment) {
		$this->_environment = $environment;
	}

	/**
	 * @return int
	 */
	private function _getNumberOfPostsInOneBatch() {
		return $this->_numberOfPostsInOneBatch;
	}

	/**
	 * @param int $numberOfPostsInOneBatch
	 */
	private function _setNumberOfPostsInOneBatch($numberOfPostsInOneBatch) {
		$this->_numberOfPostsInOneBatch = $numberOfPostsInOneBatch;
	}

	/**
	 * @return ffCollectionAdvanced
	 */
	private function _getImportStepsCollection() {
		return $this->_importStepsCollection;
	}

	/**
	 * @param ffCollectionAdvanced $importStepsCollection
	 */
	private function _setImportStepsCollection($importStepsCollection) {
		$this->_importStepsCollection = $importStepsCollection;
	}

	/**
	 * @return ffDummyContentManager
	 */
	private function _getDummyContentManager() {
		return $this->_dummyContentManager;
	}

	/**
	 * @param ffDummyContentManager $dummyContentManager
	 */
	private function _setDummyContentManager($dummyContentManager) {
		$this->_dummyContentManager = $dummyContentManager;
	}


}