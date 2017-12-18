<?php

/**
 * Class ffElementHelper
 */
class ffElementHelper extends ffBasicObject {
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/
	private $_originalString = null;

	private $_contentWithoutWrappingTag = null;

	private $_tag = null;

	private $_newTag = null;

	private $_parsedAttributes = null;

	private $_isTagParsed = false;

	private $_addAtEnd = array();

	private $_unparsableString = null;

/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/
	public function parse( $string ) {

		$this->_setOriginalString( $string );
		$parsedAttributes = $this->_htmlParser( $string );

		if( $parsedAttributes == false ) {
			$this->_unparsableString = $string;
			return $this;
		}

		$this->_setIsTagParsed( true );
		$this->_processParsedAttributes( $parsedAttributes );

		$contentWithoutWrappingTag = $this->_removeOpeningWrappingTagFromContent();
		$this->_setContentWithoutWrappingTag( $contentWithoutWrappingTag );

		return $this;
	}

	public function addStringAtEnd( $string ) {
		$this->_addAtEnd[] = $string;
	}

	public function reset() {
		$this->_originalString = null;
		$this->_contentWithoutWrappingTag = null;
		$this->_tag = null;
		$this->_parsedAttributes = null;
		$this->_isTagParsed = false;
	}

	public function get() {
		ob_start();
		$this->render();
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}

	public function render() {
		if( !$this->_getIsTagParsed() ) {
			echo $this->_unparsableString;
			return;
		}
		$openingTag = $this->_getOpeningTag();

		$closingTag = '';

		if( $this->_newTag != null ) {
			$closingTag = $this->_getClosingTag();
		}



		$newTag =  $openingTag . $this->_getContentWithoutWrappingTag() . $closingTag;

		echo $newTag;
	}
/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/
	public function addAttribute( $name, $value ) {
		if( $value == '' ) {
			return;
		}

		if( !isset( $this->_parsedAttributes[$name ] ) ) {
			$this->_parsedAttributes[ $name ] = array();
		}

		$this->_parsedAttributes[ $name ][] = $value;
	}

	public function setAttribute( $name, $value ) {
		$this->_parsedAttributes[ $name ] = array();
		$this->_parsedAttributes[ $name ][] = $value;
	}

	public function getTag() {
		return $this->_tag;
	}

	public function getNewTag() {
		return $this->_newTag;
	}

	public function setTag( $tag ) {
		$this->_newTag = $tag;
		$this->_removeClosingWrappingTagFromContent();
	}
/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/
	private function _getOpeningTag() {

		$attributes = array();

		foreach( $this->_getParsedAttributes() as $name => $values ) {

			$valuesString = implode(' ', $values );

			$attributes[] = $name . '="' . $valuesString . '"';
		}
		$attributesString = implode(' ', $attributes );

		if( !empty($this->_addAtEnd ) ) {
			$addAtEndString = implode(' ', $this->_addAtEnd );
			$attributesString .= ' ' . $addAtEndString;
		}

		$tagString = '<' . $this->_getTag() . ' ' . $attributesString . '>';

		return $tagString;
	}

	private function _getClosingTag() {
		return '</' . $this->_getTag() .'>';
	}


	private function _removeOpeningWrappingTagFromContent() {
		$content = $this->_getOriginalString();

		$contentWithoutOpeningTag = substr(strstr( $content, '>'), 1);

		return $contentWithoutOpeningTag;
	}

	private function _removeClosingWrappingTagFromContent() {
		$contentWithoutOpeningTag = $this->_getContentWithoutWrappingTag();
		$contentWithoutClosingTag = substr( $contentWithoutOpeningTag, 0, strrpos( $contentWithoutOpeningTag, '<' ));

		$this->_setContentWithoutWrappingTag( $contentWithoutClosingTag );
	}

	private function _processParsedAttributes( $parsedAttributes ) {
		$this->_setTag( $parsedAttributes['tag'] );

		unset( $parsedAttributes['tag'] );

		if( !empty( $parsedAttributes ) ) {
			foreach( $parsedAttributes as $attrName => $attrValue ) {
				$this->addAttribute( $attrName, $attrValue );
			}
		}
	}

	private function _htmlParser($htmlCode) {
		$htmlPattern = '/.(?)([^>]*)>/';
		preg_match($htmlPattern, $htmlCode, $matches);

		if( empty ($matches) ) {
			return false;
		}

		$htmlTag = strtok($matches[1], ' ');
		$htmlAttributes = array(
			'tag' => $htmlTag,
		);

		$htmlTagCode = $matches[0];

		//(\S+)=["\']?((?:.(?!["\']?\s+(?:\S+)=|[>"\']))+.)["\']?

		// $attributesPattern = '/\s([a-zA-Z0-9\\-]+)=["\']?((?:.(?!["\']?\s+(?:\S+)=|[>"\']))*.)["\']?/';

		// attribute=value

		$attributesPattern = '/\s([a-zA-Z0-9\\-]+)=([^"\'][^\s]*)/';
		preg_match_all($attributesPattern, $htmlTagCode, $matches);

		foreach($matches[1] as $key => $attribute) {
			$htmlAttributes[$attribute] = $matches[2][$key];
		}

		// attribute='value'

		$attributesPattern = '/\s([a-zA-Z0-9\\-]+)=\'([^\']*)\'/';
		preg_match_all($attributesPattern, $htmlTagCode, $matches);

		foreach($matches[1] as $key => $attribute) {
			$htmlAttributes[$attribute] = $matches[2][$key];
		}

		// attribute="value"

		$attributesPattern = '/\s([a-zA-Z0-9\\-]+)="([^"]*)"/';
		preg_match_all($attributesPattern, $htmlTagCode, $matches);

		foreach($matches[1] as $key => $attribute) {
			$htmlAttributes[$attribute] = $matches[2][$key];
		}

		return $htmlAttributes;

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
	private function _getContentWithoutWrappingTag() {
		return $this->_contentWithoutWrappingTag;
	}

	/**
	 * @param null $contentWithoutWrappingTag
	 */
	private function _setContentWithoutWrappingTag($contentWithoutWrappingTag) {
		$this->_contentWithoutWrappingTag = $contentWithoutWrappingTag;
	}


	/**
	 * @return null
	 */
	private function _getParsedAttributes() {
		if( empty( $this->_parsedAttributes ) ) {
			return array();
		}
		return $this->_parsedAttributes;
	}

	/**
	 * @param null $parsedAttributes
	 */
	private function _setParsedAttributes($parsedAttributes) {
		$this->_parsedAttributes = $parsedAttributes;
	}


	/**
	 * @return null
	 */
	private function _getOriginalString() {
		return $this->_originalString;
	}

	/**
	 * @param null $originalString
	 */
	private function _setOriginalString($originalString) {
		$this->_originalString = $originalString;
	}

	/**
	 * @return null
	 */
	private function _getTag() {
		if( $this->_newTag != null ) {
			return $this->_newTag;
		} else {
			return $this->_tag;
		}
	}

	/**
	 * @param null $tag
	 */
	private function _setTag($tag) {
		$this->_tag = $tag;
	}

	/**
	 * @return boolean
	 */
	private function _getIsTagParsed() {
		return $this->_isTagParsed;
	}

	/**
	 * @param boolean $isTagParsed
	 */
	private function _setIsTagParsed($isTagParsed) {
		$this->_isTagParsed = $isTagParsed;
	}





}