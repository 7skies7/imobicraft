<?php

class ffLicensing extends ffBasicObject {
	const OPT_NAMESPACE = 'fflicensing';

	const STATUS_NOT_REGISTERED = 'not_registered';
	const STATUS_ACTIVE = 'active';
	const STATUS_DEACTIVATED = 'deactivated';

/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/

	/**
	 * @var ffHttp
	 */
	private $_http = null;

	/**
	 * @var ffUrlRewriter
	 */
	private $_urlRewriter = null;

	/**
	 * @var ffDataStorage_WPSiteOptions_NamespaceFacade
	 */
	private $_wpOptions = null;

	/**
	 * @var ffEnvironment
	 */
	private $_environment = null;



/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/
	/**
	 * @var
	 */
//	private $_licenseApiUrl = 'http://localhost/framework/licensing/?ff_http_action_trigger=1&ff_http_action_name=ff-license-api-hook';
	private $_licenseApiUrl = 'http://update.freshcdn.net/?ff_http_action_trigger=1&ff_http_action_name=ff-license-api-hook';
	//&ff_http_action_params
//
/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
	public function __construct() {
		$this->_setHttp( ffContainer()->getHttp() );
		$this->_setUrlRewriter( ffContainer()->getUrlRewriter() );
		$this->_setWpOptions( ffContainer()->getDataStorageFactory()->createDataStorageWPSiteOptionsNamespace( ffLicensing::OPT_NAMESPACE ) );
		$this->_setEnvironment( ffContainer()->getEnvironment() );

		$this->_getUrlRewriter()->setUrl( $this->_getLicenseApiUrl() );
	}

/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/
	public function getThisSite() {
		return $this->_getEnvironment()->getDomain();
	}

	/*----------------------------------------------------------*/
	/* GET INFORMATIONS ABOUT LICENSE KEY
	/*----------------------------------------------------------*/
	public function getInformationsForLicenseKey( $licenseKey = null ) {
		$licenseKey = $this->_ensureWeHaveLicenseKey( $licenseKey );
		$env =  $this->_getEnvironment();

		$params = array();
		$params['key'] = $licenseKey;
		$params['product'] = $env->getThemeVariable( ffEnvironment::THEME_NAME );
		$params['site'] = $env->getDomain();
		$params['action'] = 'get-history-of-key';

		$response = $this->_sendApiRequest( $params );

		return $response;
	}

	/*----------------------------------------------------------*/
	/* REGISTER THIS SITE
	/*----------------------------------------------------------*/
	public function registerThisSite( $licenseKey = null ) {
		$licenseKey = $this->_ensureWeHaveLicenseKey( $licenseKey );
		$env =  $this->_getEnvironment();

		$params = array();
		$params['key'] = $licenseKey;
		$params['product'] = $env->getThemeVariable( ffEnvironment::THEME_NAME );
		$params['site'] = $env->getDomain();
//		$params['site'] = 'knesl.com';
		$params['action'] = 'register-site';
		$params['email'] = $this->getEmail();

		$response = $this->_sendApiRequest( $params );

		return $response;
	}

	/*----------------------------------------------------------*/
	/* GET UPDATE Info
	/*----------------------------------------------------------*/
	public function getUpdateInfo( $licenseKey = null, $product = 1, $productVersion = null ) {
		$licenseKey = $this->_ensureWeHaveLicenseKey( $licenseKey );

//		var_dump( $licenseKey );
//		die();
//		$licenseKey = '';

		$params = array();

		$params['key'] = $licenseKey;
//		$params['product'] = $this->_getEnvironment()->getThemeVariable( ffEnvironment::THEME_NAME );
		$params['product'] = 'ark';
		$params['site'] = $this->_getHostName();
		$params['action'] = 'get-update-url';
		$params['product-version'] = ($productVersion == null )? $this->_getEnvironment()->getThemeVersion() : $productVersion;

		$response = $this->_sendApiRequest( $params );

		return $response;
	}



	private function _getHostName() {
		if( $this->_getEnvironment()->isLocalhost() ) {
			return 'localhost';
		} else {
			return $this->_getEnvironment()->getDomain();
		}
	}

	public function setStatus( $status ) {
		$this->_getWpOptions()->setOption('status', $status );
	}

	public function getStatus() {
		$status =  $this->_getWpOptions()->getOption('status', ffLicensing::STATUS_NOT_REGISTERED );
		if( $status == null ) {
			return ffLicensing::STATUS_NOT_REGISTERED;
		} else {
			return $status;
		}
	}

	public function setEmail( $email ) {
		$this->_getWpOptions()->setOption('email', $email );
	}

	public function getEmail() {
		return $this->_getWpOptions()->getOption('email');
	}

	public function setLicenseKey( $licenseKey = null ) {
		$this->_getWpOptions()->setOption('license-key', $licenseKey );
	}

	public function getLicenseKey() {
		return $this->_getWpOptions()->getOption( 'license-key' );
	}

	private function _ensureWeHaveLicenseKey( $licenseKey ) {
		if( $licenseKey == null ) {
			return $this->getLicenseKey();
		} else {
			return $licenseKey;
		}
	}


	private function _sendApiRequest( $params ) {
		$urlRewriter = $this->_getUrlRewriter();
		$urlRewriter->setUrl(  $this->_getLicenseApiUrl() );

		$urlRewriter->addQueryParameter('ff_http_action_params', $params );

		$newUrl = $urlRewriter->getNewUrl();

		$newUrl = str_replace('&amp;', '&', $newUrl );
//		var_dump

		$response = $this->_getHttp()->get( $newUrl );

		if( $response instanceof WP_Error ) {
			var_dump( $response );
		}
//		var_dump( $response );
//		die();

		$toReturn = false;

		if( isset( $response['response'] ) && isset( $response['response']['code'] ) && $response['response']['code'] == 200 ) {
			$responseContent = json_decode( $response['body'], true );
			$toReturn = $responseContent;
		} else {
//			return false;
		}

		$toReturn['api_url'] = $newUrl;

		$toReturn['send_params'] = $params;

		return $toReturn;

	}
/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/


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
	 * @return ffHttp
	 */
	private function _getHttp() {
		return $this->_http;
	}

	/**
	 * @param ffHttp $http
	 */
	private function _setHttp($http) {
		$this->_http = $http;
	}

	/**
	 * @return ffUrlRewriter
	 */
	private function _getUrlRewriter() {
		return $this->_urlRewriter;
	}

	/**
	 * @param ffUrlRewriter $urlRewriter
	 */
	private function _setUrlRewriter($urlRewriter) {
		$this->_urlRewriter = $urlRewriter;
	}

	/**
	 * @return mixed
	 */
	private function _getLicenseApiUrl() {
		return $this->_licenseApiUrl;
	}

	/**
	 * @param mixed $licenseApiUrl
	 */
	private function _setLicenseApiUrl($licenseApiUrl) {
		$this->_licenseApiUrl = $licenseApiUrl;
	}


	/**
	 * @return ffDataStorage_WPOptions_NamespaceFacede
	 */
	private function _getWpOptions() {
		return $this->_wpOptions;
	}

	/**
	 * @param ffDataStorage_WPOptions_NamespaceFacede $wpOptions
	 */
	private function _setWpOptions($wpOptions) {
		$this->_wpOptions = $wpOptions;
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