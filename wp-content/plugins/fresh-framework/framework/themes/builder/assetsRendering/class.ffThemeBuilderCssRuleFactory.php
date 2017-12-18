<?php

class ffThemeBuilderCssRuleFactory extends ffFactoryAbstract {

	public function createCssRule() {
		$this->_getClassloader()->loadClass('ffThemeBuilderCssRule');
		$cssRule = new ffThemeBuilderCssRule();

		return $cssRule;
	}
	
}