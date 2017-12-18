<?php
 
class ffPluginFreshMenuItemLimitFix extends ffPluginAbstract {
	/**
	 *
	 * @var ffPluginFreshMenuItemLimitFixContainer
	 */
	protected $_container = null;


	protected function _registerAssets() {

	}

	protected function _run() {
		if( $this->_getContainer()->getFrameworkContainer()->getWPLayer()->is_admin() ) {
			if( FALSE !== strpos( $_SERVER['REQUEST_URI'], 'nav-menus.php' ) ){
				$this->_getContainer()->getFrameworkContainer()->getThemeFrameworkFactory()->getMenuJavascriptSaver()->enableMenuJavascriptSave();
			}
		}
	}

	protected function _registerActions() {

	}

	protected function _setDependencies() {

	}

	/**
	 * @return ffPluginFreshMenuItemLimitFixContainer
	 */
	protected function _getContainer() {
		return $this->_container;
	}
}