<?php
class ffPluginFreshFileEditorContainer extends ffPluginContainerAbstract {
	/**
	 * 
	 * @var ffPluginFreshFileEditorContainer
	 */
	private static $_instance = null;
	
	
	/**
	 * 
	 * @param ffContainer $container
	 * @param string $pluginDir
	 * @return ffPluginFreshFileEditorContainer
	 */
	public static function getInstance( ffContainer $container = null, $pluginDir = null ) {
		if( self::$_instance == null ) {
			self::$_instance = new ffPluginFreshFileEditorContainer($container, $pluginDir);
		}
		
		return self::$_instance;
	}
	
	public function getJsTreeFileTreeGenerator() {
		$this->_getClassLoader()->loadClass('ffJsTreeFileTreeGenerator');
		
		$jsTreeFileGenerator = new ffJsTreeFileTreeGenerator( $this->getFrameworkContainer()->getFileSystem() );
		
		return $jsTreeFileGenerator;
	}
	
	protected function _registerFiles() {
		$pluginDir = $this->_getPluginDir();
		$classLoader =$this->getFrameworkContainer()->getClassLoader();

		$classLoader->addClass('ffAdminScreenFileEditor', $pluginDir.'/adminScreens/fileEditor/class.ffAdminScreenFileEditor.php');
		$classLoader->addClass('ffAdminScreenFileEditorViewDefault', $pluginDir.'/adminScreens/fileEditor/class.ffAdminScreenFileEditorViewDefault.php');
		
		$classLoader->addClass('ffJsTreeFileTreeGenerator', $pluginDir.'/core/class.ffJsTreeFileTreeGenerator.php');
		
		
	/*
		$classLoader->addClass('ffMetaBoxCustomCodeEditor', $pluginDir.'/adminScreens/metaBoxes/metaBoxCustomCodeEditor/class.ffMetaBoxCustomCodeEditor.php');
		$classLoader->addClass('ffMetaBoxCustomCodeEditorView', $pluginDir.'/adminScreens/metaBoxes/metaBoxCustomCodeEditor/class.ffMetaBoxCustomCodeEditorView.php');

		$classLoader->addClass('ffMetaBoxCustomCodeLogic', $pluginDir.'/adminScreens/metaBoxes/metaBoxCustomCodeLogic/class.ffMetaBoxCustomCodeLogic.php');
		$classLoader->addClass('ffMetaBoxCustomCodeLogicView', $pluginDir.'/adminScreens/metaBoxes/metaBoxCustomCodeLogic/class.ffMetaBoxCustomCodeLogicView.php');
		
		$classLoader->addClass('ffMetaBoxCustomCodeType', $pluginDir.'/adminScreens/metaBoxes/metaBoxCustomCodeType/class.ffMetaBoxCustomCodeType.php');
		$classLoader->addClass('ffMetaBoxCustomCodeTypeView', $pluginDir.'/adminScreens/metaBoxes/metaBoxCustomCodeType/class.ffMetaBoxCustomCodeTypeView.php');
		
		$classLoader->addClass('ffMetaBoxCustomCodePlacement', $pluginDir.'/adminScreens/metaBoxes/metaBoxCustomCodePlacement/class.ffMetaBoxCustomCodePlacement.php');
		$classLoader->addClass('ffMetaBoxCustomCodePlacementView', $pluginDir.'/adminScreens/metaBoxes/metaBoxCustomCodePlacement/class.ffMetaBoxCustomCodePlacementView.php');
		
		$classLoader->addClass('ffOptionsHolderCustomCodePlacement', $pluginDir.'/adminScreens/metaBoxes/metaBoxCustomCodePlacement/class.ffOptionsHolderCustomCodePlacement.php');*/
		
	}
	
}