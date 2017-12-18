<?php

class ffImportRuleFactory extends ffFactoryAbstract {
	/**
	 * @param $name
	 * @param $path
	 * @return ffImportRuleBasic
	 * @throws Exception
	 */
	public function createImportRule( $name, $path ) {
		$cl =$this->_getClassloader();
		$cl->addClass( $name, $path );
		$cl->loadClass( $name );

		$rule = new $name();

		return $rule;
	}

	public function createImportStep( $name, $path ) {
		$cl =$this->_getClassloader();
		$cl->addClass( $name, $path );
		$cl->loadClass( $name );

		$step = new $name();

		return $step;
	}

}