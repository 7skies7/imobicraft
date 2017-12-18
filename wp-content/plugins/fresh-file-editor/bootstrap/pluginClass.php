<?php
 
class ffPluginFreshFileEditor extends ffPluginAbstract {
	/**
	 *
	 * @var ffPluginFreshFileEditorContainer
	 */
	protected $_container = null;

	
	protected function _registerAssets() {
		$fwc = $this->_getContainer()->getFrameworkContainer();
		
		$fwc->getAdminScreenManager()->addAdminScreenClassName('ffAdminScreenFileEditor');
	}

	protected function _run() {
		
	//	$fwc = $this->_getContainer()->getFrameworkContainer();
	  
		 
	}
 
	
	protected function _registerActions() {
		 
	}
	
	protected function _setDependencies() {
	
	}
	

	/**
	 * @return ffPluginFreshFileEditorContainer
	 */
	protected function _getContainer() {
		return $this->_container;
	}
}