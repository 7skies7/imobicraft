<?php 

class ffWPUpgrader {
	/*
	$transient->response[]
		twentysixteen' =>
			array (size=4)
			  'theme' => string 'twentysixteen' (length=13)
			  'new_version' => string '1.3' (length=3)
			  'url' => string 'https://wordpress.org/themes/twentysixteen/' (length=43)
			  'package' => string 'https://downloads.wordpress.org/theme/twentysixteen.1.3.zip' (length=59)
	*/

/******************************************************************************/
/* VARIABLES AND CONSTANTS
/******************************************************************************/
	/**
	 * 
	 * @var ffWPLayer
	 */
	private $_WPLayer = null;

	/**
	 * 
	 * @var ffPluginIdentificator
	 */
	private $_pluginIdentificator = null;
	
	/**
	 * 
	 * @var ffHttp
	 */
	private $_http = null;
	
	/**
	 * 
	 * @var ffDataStorage_WPOptions_NamespaceFacede
	 */
	private $dataStorage = null;

	/**
	 * @var ffEnvironment
	 */
	private $_environment = null;

	/**
	 *
	 * @var string
	 */
	private $_freshfaceServerUrl = null;

	/**
	 *
	 * @var string
	 */
	private $_freshfaceServerUrlTheme = null;

	private $_hasBeenLoaded = null;
	private $_hasBeenLoadedThemes = null;


	private $_responseFromOurServer = null;
	private $_responseFromOurServerTheme = null;


/******************************************************************************/
/* CONSTRUCT AND PUBLIC FUNCTIONS
/******************************************************************************/
	/**
	 * Constructor
	 */
	public function __construct( ffWPLayer $WPLayer, ffPluginIdentificator $pluginIdentificator, ffHttp $http, ffDataStorage_WPOptions_NamespaceFacede $dataStorage, $serverUrl, $serverUrlTheme, ffEnvironment $environment ) {
		$this->_setWPLayer( $WPLayer );
		$this->_setPluginIdentificator( $pluginIdentificator );
		$this->_setHttp( $http );
		$this->_setFreshfaceServerUrl($serverUrl);
		$this->_setFreshfaceServerUrlTheme($serverUrlTheme);
		$this->_setDataStorage( $dataStorage );

		$this->_getDataStorage()->setNamespace('ffWPUpgrader');
		$this->_setEnvironment( $environment );
		$this->_setHasBeenLoaded(false);
		$this->_setHasBeenLoadedThemes(false);

		$this->_hookActions();
//		die();
	}

//	private function _checkIfArkExists

	public function actionPreUpdateOptionShowThemes( $transient ) {


//		unset( $transient->response['t-ark']);
//		return $transient;
//		var_Dump( $transient );
//		die();
//		var_Dump( debug_backtrace( ));
//		var_Dump( $transient );
//		die();

//		$arkTheme = $this->_getPluginIdentificator()->findThemeByName('ark');
//
//		if( $arkTheme != false ) {
//		if( FF_DEVELOPER_MODE == true ) {
			$transient = $this->_licensedUpdateOptionThemes( $transient );
//		}


//		}

		return $this->_standardUpdateOptionThemes( $transient );
	}

	private function _makeSureTransientIsNotEmpty( $transient ) {
		if( !is_object( $transient ) ) {
			$transient = new stdClass();
		}

		if( !isset( $transient->response ) || empty( $transient->response )) {
			$transient->response = array();
		}

		return $transient;
	}

	public function licensedUpdateOptionThemes( $transient ){
		return $this->_licensedUpdateOptionThemes( $transient );
	}

	private function _licensedUpdateOptionThemes( $transient ) {
		return $transient;
		/**
		 * @var $arkTheme WP_Theme
		 */
		$arkTheme = $this->_getPluginIdentificator()->findThemeByName('ark');

		if ($arkTheme == false) {
			return $transient;
		}

		$version = $arkTheme->get('Version');

		$licensing = ffContainer()->getLicensing();

		if( $licensing->getLicenseKey() == null ) {
			return $transient;
		}

		$info = $licensing->getUpdateInfo(null, 1, $version);

//		var_dump( $info );
//		die();


		if ($info['is-update'] == 1) {
			$newThemeInfo = array();
			$newThemeInfo['theme'] = $arkTheme->get_template();
			$newThemeInfo['new_version'] = $info['new-version'];
			$newThemeInfo['url'] = $arkTheme->get('ThemeURI');

			if (!empty($info['update-url'])) {
				$newThemeInfo['package'] = $info['update-url'];
			}

			$transient = $this->_makeSureTransientIsNotEmpty($transient);
			$transient->response[$arkTheme->get_template()] = $newThemeInfo;
		}



		if(isset($info['license-ok']) &&  $info['license-ok'] == 0 ) {

			if( $info['license-error-type'] == 'not_registered') {
				$licensing->setStatus( ffLicensing::STATUS_NOT_REGISTERED );
			} else if( $info['license-error-type'] == 'deactivated' ) {
				$licensing->setStatus( ffLicensing::STATUS_DEACTIVATED );
			}
			
		}

		return $transient;
	}


	private function _standardUpdateOptionThemes( $transient ) {
		if( $this->_getHasBeenLoadedThemes() == false ) {
			$action = 'update_info_themes';

			$info_themes = serialize($this->_getPluginIdentificator()->getAllThemesInfo());
			$info_plugins = serialize($this->_getPluginIdentificator()->getAllPluginInfo());
			$website_url = $this->_getWPLayer()->get_home_url();

			$infoBack = $this->_getHttp()
				->post(
					$this->_getFreshfaceServerUrlTheme(),
					array( 'action' => $action,
						'info_themes' => $info_themes,
						'info_plugins' => $info_plugins,
						'info_home' => $website_url
					)
				);
			if( !($infoBack instanceof WP_Error) && $infoBack['response']['code'] == 200 ) {
				$ourUpdateInfo = unserialize($infoBack['body']);
				if( is_array( $ourUpdateInfo ) ) {
					if( empty( $transient ) ) {
						$transient = new stdClass();
					}
					if( empty( $transient->response ) ){ $transient->response = array(); }
					if( is_object($transient) && property_exists( $transient, 'response') && is_array( $transient->response ) ) {
						$transient->response = array_merge( $transient->response, $ourUpdateInfo );
					}
					$this->_setHasBeenLoadedThemes(true);
					$this->_setResponseFromOurServerTheme( $ourUpdateInfo );
					if( empty( $transient->response ) ){ $transient->response = null; }
				}
			}
		} else {
			if( $this->_getResponseFromOurServerTheme() != null ) {
				if( empty( $transient->response ) ){ $transient->response = array(); }
				$transient->response = array_merge( $transient->response, $this->_responseFromOurServerTheme );
				if( empty( $transient->response ) ){ $transient->response = null; }
			}
		}
		return $transient;
	}


	/**
	 * This function is injecting our plugin updates. Wordpress is calling this
	 * function twice, so I made a primitive memory caching to avoid double
	 * http requests.
	 * 
	 * @param unknown $transient
	 * @return unknown
	 */
	public function actionPreUpdateOptionShowPlugins( $transient ) {
		if( $this->_getHasBeenLoaded() == false ) {
			$action = 'update_info';

			$info_themes = serialize($this->_getPluginIdentificator()->getAllThemesInfo());
			$info_plugins = serialize($this->_getPluginIdentificator()->getAllPluginInfo());
			$website_url = $this->_getWPLayer()->get_home_url();

			$infoBack = $this->_getHttp()
								->post(
										$this->_getFreshfaceServerUrl(), 
										array( 'action' => $action, 
												'info_themes' => $info_themes,
												'info_plugins' => $info_plugins,
												'info_home' => $website_url
										)
								);

			// echo '<pre>';
			// print_r(	
			// 	array( 
			// 		'action' => $action, 
			// 		'info_themes' => unserialize( $info_themes),
			// 		'info_plugins' => unserialize( $info_plugins ),
			// 		'info_home' => unserialize( $website_url )
			// 	)
			// ); 
			// echo '</pre>';
			if( !($infoBack instanceof WP_Error) && $infoBack['response']['code'] == 200 ) {
				// echo '<pre>';var_dump( unserialize($infoBack['body']));exit;
				$ourUpdateInfo = unserialize($infoBack['body']);


				if( is_array( $ourUpdateInfo ) ) {

					if( is_object($transient) && property_exists( $transient, 'response') && is_array( $transient->response ) ) {
						$transient->response = array_merge( $transient->response, $ourUpdateInfo );
					}

					//$transient->response = array_merge( $transient->response, $ourUpdateInfo );
					$this->_setHasBeenLoaded(true);
					$this->_setResponseFromOurServer( $ourUpdateInfo );
				}
			}
		} else {
			if( $this->_getResponseFromOurServer() != null ) {
                if( property_exists( $transient, 'response') && is_array( $transient->response ) ) {
				    $transient->response = array_merge( $transient->response, $this->_responseFromOurServer['upgrades'] );
                } else {
                    $transient->response = $this->_responseFromOurServer['upgrades'];
                }
			}
		}

		return $transient;
	}

	/**
	 * Gather info about the plugin upgrade. If we have it return the info,
	 * if we dont have it, return false and wordpress will try another ways.
	 *
	 * @param unknown $false
	 * @param unknown $action
	 * @param unknown $arg
	 * @return unknown|boolean
	 */
	public function actionThemesApi($false, $action, $arg)
	{
		// echo '<pre>';
		// var_dump( $false, $action, $arg);
		// echo '</pre>';
		// die();
		
		return;
		
		
		
		// zkopirovano!
		$response = $this->_getResponseFromOurServer();
	
		$plug = null;
		if( isset( $arg->slug) && isset( $response['informations'][ $arg->slug] ) ) {
			$plug = $response['informations'][ $arg->slug];
			return $plug;
		}
	
		return false;
	}
	
	
	/**
	 * Gather info about the plugin upgrade. If we have it return the info,
	 * if we dont have it, return false and wordpress will try another ways.
	 * 
	 * @param unknown $false
	 * @param unknown $action
	 * @param unknown $arg
	 * @return unknown|boolean
	 */
	public function actionPluginsApi($false, $action, $arg)
	{
		$response = $this->_getResponseFromOurServer();

		$plug = null;
		if( isset( $arg->slug) && isset( $response['informations'][ $arg->slug] ) ) {
			$plug = $response['informations'][ $arg->slug];
			return $plug;
		}
		
		return false;
	}
	
	
/******************************************************************************/
/* PRIVATE FUNCTIONS
/******************************************************************************/
	private function _hookActions() {
		$this->_getWPLayer()->add_filter('pre_set_site_transient_update_plugins', array( $this, 'actionPreUpdateOptionShowPlugins'));
		$this->_getWPLayer()->add_filter('pre_set_site_transient_update_themes', array( $this, 'actionPreUpdateOptionShowThemes'));
		$this->_getWPLayer()->add_filter('pre_set_transient_update_themes', array( $this, 'actionPreUpdateOptionShowThemes'));
		$this->_getWPLayer()->add_filter('plugins_api', array( $this, 'actionPluginsApi' ), 10, 3);
		$this->_getWPLayer()->add_filter('themes_api', array( $this, 'actionThemesApi' ), 10, 3);
	}
/******************************************************************************/
/* SETTERS AND GETTERS
/******************************************************************************/
	
	/**
	 * @return ffWPLayer
	 */
	protected function _getWPLayer() {
		return $this->_WPLayer;
	}
	
	/**
	 * @param ffWPLayer $WPLayer
	 */
	protected function _setWPLayer(ffWPLayer $WPLayer) {
		$this->_WPLayer = $WPLayer;
		return $this;
	}

	protected function _getFreshfaceServerUrlTheme() {
		return $this->_freshfaceServerUrlTheme;
	}

	protected function _setFreshfaceServerUrlTheme( $freshfaceServerUrlTheme) {
		$this->_freshfaceServerUrlTheme = $freshfaceServerUrlTheme;
		return $this;
	}

	protected function _getFreshfaceServerUrl() {
		return $this->_freshfaceServerUrl;
	}

	protected function _setFreshfaceServerUrl( $freshfaceServerUrl) {
		$this->_freshfaceServerUrl = $freshfaceServerUrl;
		return $this;
	}

	/**
	 * @return ffPluginIdentificator
	 */
	protected function _getPluginIdentificator() {
		return $this->_pluginIdentificator;
	}
	
	/**
	 * @param ffPluginIdentificator $pluginIdentificator
	 */
	protected function _setPluginIdentificator(ffPluginIdentificator $pluginIdentificator) {
		$this->_pluginIdentificator = $pluginIdentificator;
		return $this;
	}
	
	/**
	 * @return ffHttp
	 */
	protected function _getHttp() {
		return $this->_http;
	}
	
	/**
	 * @param ffHttp $http
	 */
	protected function _setHttp(ffHttp $http) {
		$this->_http = $http;
		return $this;
	}

	protected function _getHasBeenLoadedThemes() {
		return $this->_hasBeenLoadedThemes;
	}

	protected function _setHasBeenLoadedThemes($hasBeenLoadedThemes) {
		$this->_hasBeenLoadedThemes = $hasBeenLoadedThemes;
		return $this;
	}

	protected function _getHasBeenLoaded() {
		return $this->_hasBeenLoaded;
	}

	protected function _setHasBeenLoaded($hasBeenLoaded) {
		$this->_hasBeenLoaded = $hasBeenLoaded;
		return $this;
	}

	protected function _getResponseFromOurServer() {
		if( $this->_responseFromOurServer == null ) {
			$this->_responseFromOurServer = $this->_getDataStorage()->getOption('response_from_our_server');
		}
		return $this->_responseFromOurServer;
	}

	protected function _setResponseFromOurServerTheme($responseFromOurServerTheme) {
		$this->_responseFromOurServerTheme = $responseFromOurServerTheme;
		$this->_getDataStorage()->setOption('response_from_our_serverTheme', $responseFromOurServerTheme );
		return $this;
	}

	protected function _getResponseFromOurServerTheme() {
		if( $this->_responseFromOurServerTheme == null ) {
			$this->_responseFromOurServerTheme = $this->_getDataStorage()->getOption('response_from_our_serverTheme');
		}
		return $this->_responseFromOurServerTheme;
	}

	protected function _setResponseFromOurServer($responseFromOurServer) {
		$this->_responseFromOurServer = $responseFromOurServer;
		$this->_getDataStorage()->setOption('response_from_our_server', $responseFromOurServer );
		return $this;
	}

	/**
	 * @return ffDataStorage_WPOptions_NamespaceFacede
	 */
	protected function _getDataStorage() {
		return $this->_dataStorage;
	}
	
	/**
	 * @param ffDataStorage_WPOptions_NamespaceFacede $dataStorage
	 */
	protected function _setDataStorage(ffDataStorage_WPOptions_NamespaceFacede $dataStorage) {
		$this->_dataStorage = $dataStorage;
		return $this;
	}

	/**
	 * @return ffEnvironment
	 */
	private function _getEnvironment() {
		return $this->_environment;
	}

	/**
	 * @param ffEnvironment $environment
	 */
	private function _setEnvironment($environment) {
		$this->_environment = $environment;
	}


}