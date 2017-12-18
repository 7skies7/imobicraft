<?php

class ffDummyContentManager extends ffBasicObject {
	const OPTIONS_NAMESPACE = 'dummy_content_info';
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/

	/**
	 * @var ffDataStorage_WPOptions_NamespaceFacede
	 */
	private $_dataStorageOptions = null;

	/**
	 * @var ffWPLayer
	 */
	private $_WPLayer = null;


/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
	/**
	 * ffDummyContentManager constructor.
	 * @param $dataStorageOptions ffDataStorage_WPOptions_NamespaceFacede
	 * @param $WPLayer ffWPLayer
	 */
	public function __construct( $dataStorageOptions, $WPLayer ) {
		$dataStorageOptions->setNamespace( ffDummyContentManager::OPTIONS_NAMESPACE );
		$this->_setDataStorageOptions( $dataStorageOptions );
		$this->_setWPLayer( $WPLayer );
	}

/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/
	/**
	 * @param $configFilePath   string
	 * @param $configFile       string
	 * @param $wpImporter       ffWPImporter
	 */
	public function addInstalledDemo( $configFilePath, $configFileData, $wpImporter ) {
		$demoInfoObject = $this->_getDemoObject( $configFilePath, $configFileData, $wpImporter );
		$options = $this->_getDataStorageOptions();

		$options->setOptionCodedJson( $configFileData['name'], $demoInfoObject );
	}

	public function getAllInstalledDemos() {
		$options = $this->_getDataStorageOptions();
		$namespaces = $options->getAllOptionsForNamespace( ffDummyContentManager::OPTIONS_NAMESPACE );
		$demos = array();

		foreach( $namespaces as $oneName ) {
			$oneDemo = $options->getOptionCodedJson( $oneName );

			$demos[] = $oneDemo;
		}

		return $demos;
	}

	public function removeInstalledDemo( $demoName ) {
		$demoData = $this->_getDataStorageOptions()->getOptionCodedJson( $demoName );
		if( empty( $demoData ) ) {
			return true;
		}

		$WPLayer = $this->_getWPLayer();

		// first we gonna delete posts
		foreach( $demoData['processedPosts'] as $onePostId ) {
			$WPLayer->wp_delete_post( $onePostId, true);
		}

		// then we gonna delete terms
		foreach( $demoData['processedTerms'] as $oldTermId => $newTermId ) {

			$termTaxonomy = $demoData['termTaxonomies'][ $oldTermId ];

			$WPLayer->wp_delete_term( $newTermId, $termTaxonomy );
		}
	}

/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/
	/**
	 * @param $configFilePath
	 * @param $configFile
	 * @param $wpImporter ffWPImporter
	 */
	private function _getDemoObject( $configFilePath, $configFileData, $wpImporter ) {
		$demoObject = new ffStdClass();

		$demoObject->configFilePath = $configFilePath;
		$demoObject->configFileData = $configFileData;
		$demoObject->processedPosts = $wpImporter->processed_posts;
		$demoObject->processedTerms = $wpImporter->processed_terms;

		$termTaxonomies = array();

		foreach( $wpImporter->categories as $oneTerm ) {
			$oldTermId = $oneTerm['term_id'];
			$termTaxonomies[ $oldTermId ] = 'category';
		}

		foreach( $wpImporter->tags as $oneTerm ) {
			$oldTermId = $oneTerm['term_id'];
			$termTaxonomies[ $oldTermId ] = 'tag';
		}

		foreach( $wpImporter->terms as $oneTerm ) {
			$oldTermId = $oneTerm['term_id'];
			$termTaxonomy = $oneTerm['term_taxonomy'];
			$termTaxonomies[ $oldTermId ] = $termTaxonomy;
		}

		$demoObject->termTaxonomies = $termTaxonomies;


		return $demoObject;
	}

/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* ABSTRACT FUNCTIONS
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/
	/**
	 * @return ffDataStorage_WPOptions_NamespaceFacede
	 */
	private function _getDataStorageOptions() {
		return $this->_dataStorageOptions;
	}

	/**
	 * @param ffDataStorage_WPOptions_NamespaceFacede $dataStorageOptions
	 */
	private function _setDataStorageOptions($dataStorageOptions) {
		$this->_dataStorageOptions = $dataStorageOptions;
	}

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