<?php

class ffUrlRewriter extends ffBasicObject {
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/
    /**
     * @var ffWPLayer
     */
    private $_WPLayer = null;

    /**
     * @var ffRequest
     */
    private $_request = null;
/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/
    private $_siteUrl = null;

    private $_pathUrl = null;

    private $_queryParams = null;

    private $_urlHasBeenDisassembled = false;

    private $_url = null;
/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
    public function __construct() {
        $this->_setWPLayer( ffContainer()->getWPLayer() );
        $this->_setRequest( ffContainer()->getRequest() );
    }
/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/
    public function reset() {
        $this->_siteUrl = null;
        $this->_pathUrl = null;
        $this->_queryParams = null;
        $this->_urlHasBeenDisassembled = false;
        $this->_url = null;

        return $this;
    }

    public function setSiteUrl() {
        $this->setUrl( $this->_getWPLayer()->get_site_url() );

        return $this;
    }


    public function setUrl( $url ) {
        $this->_setUrl( $url );

        return $this;
    }

    public function getCurrentUrl() {
        return $this->_currentUrl();
    }

    public function getNewUrl() {
        $this->_disassembleUrl();

        return $this->_assembleUrl();
    }

    public function addQueryParameter( $name, $value ) {
        $this->_disassembleUrl();

        $this->_queryParams[ $name ] = $value;

        return $this;
    }

    public function removeQueryParameter( $name ) {
        $this->_disassembleUrl();
        unset( $this->_queryParams[ $name ] );

        return $this;
    }
/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/



/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/
    private function _assembleUrl() {
        $base = $this->_getWPLayer()->trailingslashit($this->_siteUrl);

	    $path = '';
	    if( is_array( $this->_pathUrl ) ) {
		    $path = implode('/', $this->_pathUrl );
	    }

        $query = '';

        if( is_array( $this->_queryParams ) ) {
            $query = http_build_query( $this->_queryParams );
        }

        if( !empty( $query ) ) {
            $query = '?' .$query;
        }

        $fullUrl = $base . $path . $query;

        return $fullUrl;
    }

    private function _disassembleUrl() {
        if( $this->_urlHasBeenDisassembled == true ) {
            return false;
        }

        // site url == localhost/wordpress
	    if( $this->_url == null ) {
		    $this->_siteUrl = $this->_getWPLayer()->get_site_url();
	    } else {
		    $fullUrl = $this->_url;

		    $this->_siteUrl = strstr( $fullUrl, '?', true);
	    }



        // currentUrl = something like localhost/wordpress/wp-admin/tools.php?page=import&someVariable=xx
        $currentUrl = $this->_currentUrl();


        
        // currentUrlWithoutsite = wp-admin/tools.php?page=import&someVariable=xx
        $currentUrlWithoutSite = str_replace( $this->_siteUrl, '', $currentUrl );

        if( $currentUrlWithoutSite[0] == ':' ) {
            $firstPos = strpos($currentUrlWithoutSite, '/');
            $currentUrlWithoutSite = substr( $currentUrlWithoutSite, $firstPos);
        }


        $urlParsed = parse_url( $currentUrlWithoutSite);


        // path = wp-admin/tools.php
        if( isset( $urlParsed['path'] ) ) {
            $pathSplitted = explode('/', ltrim($urlParsed['path'],'/') );

            $this->_pathUrl = $pathSplitted;
        }
        // query = page=import&someVariable=xx
        if( isset( $urlParsed['query'] ) ) {
            $query = $urlParsed['query'];

            $queryParsed = array();

            parse_str( $query, $queryParsed );

            $this->_queryParams = $queryParsed;
        }

        $this->_urlHasBeenDisassembled = true;
    }

    private function _currentUrl() {

        if( $this->_getUrl() != null ) {
            return $this->_getUrl();
        }

        $pageURL = 'http';
        $request = $this->_getRequest();

        if ( $request->server('HTTPS') == 'on' ) {
            $pageURL .= "s";
        }
        $pageURL .= "://";


//        var_Dump( $request->server('SERVER_POST')  );

		$serverName = $request->server('SERVER_NAME');
		$httpHost = $request->server('HTTP_HOST');

		$finalHostName = $httpHost;

		if( empty( $httpHost ) ) {
			$finalHostName = $serverName;
		}
		
	


        if ( $request->server('SERVER_PORT') != 80 && $request->server('SERVER_PORT') != 443 ){
            $pageURL .=
				$finalHostName . ':' . $request->server('SERVER_PORT') . $request->server('REQUEST_URI');
        }
        else {
            $pageURL .= $finalHostName . $request->server('REQUEST_URI');
        }
        
        return $pageURL;
    }

    public function getServerName( $addProtocol = false, $addPort = false ) {
        $request = $this->_getRequest();
        $serverName = '';

        if( $addProtocol ) {

            $serverName = 'http';
            $request = $this->_getRequest();

            if ( $request->server('HTTPS') == 'on' ) {
                $serverName = 'https';
            }
            $serverName .= "://";

        }

        $serverName .= $request->server('HTTP_HOST');

        if( $addPort && $request->server('SERVER_PORT') != 80 ) {
            $serverName .= ':' . $request->server('SERVER_PORT');
        }

        return $serverName;
    }
/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/
    /**
     * @return ffWPLayer
     */
    private function _getWPLayer()
    {
        return $this->_WPLayer;
    }

    /**
     * @param ffWPLayer $WPLayer
     */
    private function _setWPLayer($WPLayer)
    {
        $this->_WPLayer = $WPLayer;
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
    private function _getUrl()
    {
        return $this->_url;
    }

    /**
     * @param null $url
     */
    private function _setUrl($url)
    {
        $this->_url = $url;
    }


}