<?php

class ffMetaBoxCustomCodeLogicView extends ffMetaBoxView {
	
	protected function _requireAssets() {
		ffContainer::getInstance()->getScriptEnqueuer()->getFrameworkScriptLoader()->requireFrsLib();
		ffContainer::getInstance()->getScriptEnqueuer()->getFrameworkScriptLoader()->requireFrsLibOptions();
		ffContainer::getInstance()->getFrameworkScriptLoader()->requireFfAdmin();
	}
	
	protected function _render( $post ) {
		
		$fwc = ffContainer::getInstance();
		$conditionalLogic  = $fwc->getOptionsFactory()->createOptionsHolder('ffOptionsHolderConditionalLogic');
	
		
		$value = $fwc->getDataStorageFactory()->createDataStorageWPPostMetas_NamespaceFacade(  $post->ID )->getOption('customcode_logic'); 
		
		$printer = $fwc->getOptionsFactory()->createOptionsPrinterLogic( $value, $conditionalLogic->getOptions() );
		$printer->setNameprefix('customcode_logic');
		$printer->walk();
	}
	
	protected function _save( $postId ) {
		$fwc = ffContainer::getInstance();
		$saver = $fwc->getDataStorageFactory()->createDataStorageWPPostMetas_NamespaceFacade( $postId );
		$saver->setOption( 'customcode_logic' , $fwc->getOptionsFactory()->createOptionsPostReader()->getData( 'customcode_logic') );
	}
}

