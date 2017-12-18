<?php

class ffThemeBuilderJavascriptCodeFactory extends ffFactoryAbstract {

	public function createJavascriptCode() {
		$this->_getClassloader()->loadClass('ffThemeBuilderJavascriptCode');
		$cssRule = new ffThemeBuilderJavascriptCode();

		return $cssRule;
	}

}