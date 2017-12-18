<?php

class ffFastSpringApi extends ffBasicObject {
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/
	/**
	 * @var ffHttp
	 */
	private $_http = null;

	/**
	 * @var ffRequest
	 */
	private $_request = null;

/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/
	private $_username = null;

	private $_password = null;

	private $_baseUrl = 'https://api.fastspring.com/';

/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
	public function __construct( $http, $request ) {
		$this->_setHttp( $http );
		$this->_setRequest( $request );
	}

/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/
	public function setCredentials( $username, $password ) {
		$this->_setUsername( $username );
		$this->_setPassword( $password );
	}

	/*----------------------------------------------------------*/
	/* ACCOUNTS
	/*----------------------------------------------------------*/
	public function getAllAccounts() {
		$result = $this->_makeRequest('accounts');
		return $result;
	}

	public function getOneAccount( $accountId ) {
		$result = $this->_makeRequest('accounts/' . $accountId );
		return $result;
	}

	/*----------------------------------------------------------*/
	/* SUBSCRIPTIONS
	/*----------------------------------------------------------*/
	public function getAllSubscriptions( $page = null ) {
		$result = $this->_makeRequest('subscriptions');
		return $result;
	}

	public function getOneSubscription( $subscriptionId ) {
		$result = $this->_makeRequest( 'subscriptions/' . $subscriptionId );

		return $result;
	}

/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/
	private function _makeRequest( $url, $method = 'GET' ) {
		$url = $this->_baseUrl . $url;
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, $this->_getUsername().':'.$this->_getPassword());
//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('User-Agent: curl/7.51.0'));
		curl_setopt($ch,CURLOPT_TIMEOUT,10000);
		$result = curl_exec($ch);
		$info = curl_getinfo($ch);
		curl_close($ch);

		if( isset( $info['http_code'] ) && $info['http_code'] != 200 ) {
			return null;
		}

		$resultDecoded = json_decode( $result, true);
		return $resultDecoded;
//		var_dump( $result );
//		var_dump( $info );
	}

/**********************************************************************************************************************/
/* ABSTRACT FUNCTIONS
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/
	/**
	 * @return ffHttp
	 */
	private function _getHttp()
	{
		return $this->_http;
	}

	/**
	 * @param ffHttp $http
	 */
	private function _setHttp($http)
	{
		$this->_http = $http;
	}

	/**
	 * @return ffRequest
	 */
	private function _getRequest()
	{
		return $this->_request;
	}

	/**
	 * @param ffRequest $request
	 */
	private function _setRequest($request)
	{
		$this->_request = $request;
	}

	/**
	 * @return null
	 */
	private function _getUsername()
	{
		return $this->_username;
	}

	/**
	 * @param null $username
	 */
	private function _setUsername($username)
	{
		$this->_username = $username;
	}

	/**
	 * @return null
	 */
	private function _getPassword()
	{
		return $this->_password;
	}

	/**
	 * @param null $password
	 */
	private function _setPassword($password)
	{
		$this->_password = $password;
	}
}