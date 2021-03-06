<?php

class ffMetaBoxOnePageFramework extends ffMetaBox {
	protected function _initMetaBox() {

		$this->_addPostType( 'page' );
		$this->_setTitle('One Page');
		$this->_setContext( ffMetaBox::CONTEXT_NORMAL);
        $this->_setPriority( ffMetaBox::PRIORITY_HIGH );
		
		$this->_setParam( ffMetaBox::PARAM_NORMALIZE_OPTIONS, true);
        $this->_setParam( ffMetaBox::PARAM_NORMALIZE_OPTIONS_TO_ONE_INPUT, true );
		$this->_addVisibility( ffMetaBox::VISIBILITY_PAGE_TEMPLATE, 'page-onepage.php');
	}
}