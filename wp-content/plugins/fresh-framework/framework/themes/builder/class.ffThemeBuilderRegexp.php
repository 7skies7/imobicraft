<?php
/**
 * Class ffThemeBuilderRegexp
 * Contains all regexp functions for parsing output of our builder and figuring out advanced things
 */
class ffThemeBuilderRegexp extends ffBasicObject {
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/
	/**
	 * @var ffWPLayer
	 */
	private $_WPLayer = null;

/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/
	/**
	 * @var string regexp for replacing images
	 */
	private $_imageRegexp = '/%7B%5C%22id%5C%22%3A([0-9]*)%2C%5C%22url%5C%22%3A%5C%22(.+?)%5C%22%2C%5C%22width%5C%22%3A([0-9]+)%2C%5C%22height%5C%22%3A([0-9]+)%7D/';

	private $_temporaryCallbackHolder = null;

	private $_foundImageInPost = false;
/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/
	public function imageFind( $content, $callback ) {
		$this->_setFoundImageInPost( false );
		$this->_setTemporaryCallbackHolder( $callback );

		$regexp = $this->_getImageRegexp();
		$content = preg_replace_callback( $regexp, array($this, '_imageFindCallback'), $content );

		return $content;
	}


/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/
	private function _imageFindCallback( $match) {
		$originalString = $match[0];
		$id = $match[1];
		$url = $match[2];
		$width = $match[3];
		$height = $match[4];

		$newImage = array();
		$newImage['id'] = intval($id);
		$newImage['url'] = urldecode($url);
		$newImage['width'] = intval($width);
		$newImage['height'] = intval($height);

		if( is_callable( $this->_temporaryCallbackHolder ) ) {
			$result = call_user_func( $this->_temporaryCallbackHolder, $newImage );

			if( !empty( $result ) ) {
				$result['id'] = intval($result['id']);
				$result['url'] = strval($result['url']);
				$result['width'] = intval($result['width']);
				$result['height'] = intval($result['height']);


				$newImage = $result;
				$this->_setFoundImageInPost( true );
			}
		}
		
		$imageJson = json_encode( $newImage, JSON_UNESCAPED_SLASHES);
		$imageJsonWithSlashes = addslashes( $imageJson );
		$imageJsonEncoded = rawurlencode( $imageJsonWithSlashes );



		return $imageJsonEncoded;

	}

/**********************************************************************************************************************/
/* ABSTRACT FUNCTIONS
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/

	/**
	 * @return string
	 */
	private function _getImageRegexp() {
		return $this->_imageRegexp;
	}

	/**
	 * @param string $imageRegexp
	 */
	private function _setImageRegexp($imageRegexp) {
		$this->_imageRegexp = $imageRegexp;
	}

	/**
	 * @return null
	 */
	private function _getTemporaryCallbackHolder() {
		return $this->_temporaryCallbackHolder;
	}

	/**
	 * @param null $temporaryCallbackHolder
	 */
	private function _setTemporaryCallbackHolder($temporaryCallbackHolder) {
		$this->_temporaryCallbackHolder = $temporaryCallbackHolder;
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

	/**
	 * @return boolean
	 */
	public function getFoundImageInPost() {
		return $this->_foundImageInPost;
	}

	/**
	 * @param boolean $foundImageInPost
	 */
	private function _setFoundImageInPost($foundImageInPost) {
		$this->_foundImageInPost = $foundImageInPost;
	}




}