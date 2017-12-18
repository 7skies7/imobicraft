<?php

class ffAdminScreenFileEditorViewDefault extends ffAdminScreenView {
	
	private function _checkRights() {
		$WPLayer = ffContainer::getInstance()->getWPLayer();
		if( ffContainer::getInstance()->getFileSystem()->getFileSystemMethod() !== ffFileSystem::FILE_SYSTEM_METHOD_DIRECT || !$WPLayer->current_user_can('edit_files') ) {
			echo '<div style="background-color: #FFEBE8 !important;" class="error fade" id="message"><p>Warning: You do not have sufficient permission to work with files. Please contact your hosting.</p></div>';
			return false;
		}
		
		return true;
	}
	
	protected function _render() {
		
		if( !$this->_checkRights() ) {
			return;
		}
		
		$container = ffPluginFreshFileEditorContainer::getInstance();
		$fwc = $container->getFrameworkContainer();
		?>
		
		<div class="wrap">
			<h2>Edit Files</h2>
			<table class="ff-file-editor">
				<tr>
					<td>

						<?php
						//START TREE
						echo '<div class="ff-file-editor-tree-wrapper"><div id="jstree_demo_div" class="ff-jstree">';
						//	echo '<ul>';
						//		echo $container->getJsTreeFileTreeGenerator()->getListForDir(ABSPATH);
						//	echo '</ul>';
						echo '</div></div>';
						//END TREE
						?>

					</td>

					<td class="ff-file-editor-editor-cell">
						<div class="ff-file-editor-editor-cell-inner">
							<div class="ff-file-editor-controls-top"></div>
							<?php
							//START EDITOR
							$fwc = ffContainer::getInstance();
							$s = $fwc->getOptionsFactory()->createStructure('code');
									
							$s->startSection('code');			
							
								$s->addOption(ffOneOption::TYPE_CODE, 'code')
									->addParam('minLines', '')
									->addParam('maxLines', '');
							
							$s->endSection();
									
							//$value = $fwc->getDataStorageFactory()->createDataStorageWPPostMetas_NamespaceFacade(  $post->ID )->getOption('customcode_code');
									
							$printer = $fwc->getOptionsFactory()->createOptionsPrinterBoxed( array(), $s );
							$printer->setNameprefix('fileeditor');
							$printer->walk();
							//END EDITOR
							?>
							<div class="ff-file-editor-controls-bottom">
								<input type="submit" class="button button-primary ff-file-editor-save-button" value="Save File"/>
							</div>
						</div>
						<div class="ff-file-editor-image-preview"><img src="" alt=""/></div>
					</td>
				</tr>
			</table>
		</div>

		<?php
	}
	protected function _requireAssets() {
		$container = ffPluginFreshFileEditorContainer::getInstance();
		$fwc = $container->getFrameworkContainer();
		$pluginUrl = $container->getPluginUrl();
		$scriptEnqueuer = $fwc->getScriptEnqueuer();
		$scriptLoader = $fwc->getFrameworkScriptLoader();
		$styleEnqueuer = $fwc->getStyleEnqueuer();
		$lessOptionManager = ffContainer::getInstance()->getLessWPOptionsManager();
		
		// code
		
		$scriptLoader->requireJsTree();

		$styleEnqueuer->addStyle('ff-file-editor-less', $pluginUrl.'/assets/css/fileEditor.less');
		$styleEnqueuer->addLessImportFile('ff-file-editor-less', 'ff-mixins-less', $lessOptionManager->getFrameworkFreshMixinsLessUrl() );
		$scriptEnqueuer->addScript('ff-file-editor-js', $pluginUrl.'/assets/js/adminScreenFileEditor.js');
	}
	
	protected function _setDependencies() {
		
	}
	
	public function ajaxRequest( ffAdminScreenAjax $ajax ) {
		if( !$this->_checkRights() ) {
			return;
		}
 
		
		switch( $ajax->specification ) {
			
/********* LOAD TREE *********/
			case 'action-load-tree';
				$path = ABSPATH;
		
				if( !empty($ajax->data['path'] ) ) {
					$path = $ajax->data['path'].'/';
				}
				
				if( $path == ABSPATH ) {
					echo '<ul><li data-jstree=\'{"opened":true,"selected":true, "type":"folder"}\' data-is-top="true" data-path="'.substr($path,0,-1).'">WordPress';
				}
				
				echo '<ul>';
				echo ffPluginFreshFileEditorContainer::getInstance()->getJsTreeFileTreeGenerator()->getListForDir($path);
				echo '</ul>';
				
				if( $path == ABSPATH ) {
					echo '</li></ul>';
				}
				
				break;

/********* LOAD FILE *********/				
			case 'action-load-file':
					echo ffContainer::getInstance()->getFileSystem()->getContents( $ajax->data['path'] );
					break;
					
/********* SAVE FILE *********/
			case 'action-save-file':
				echo ffContainer::getInstance()->getFileSystem()->putContents( $ajax->data['path'], $ajax->data['value'] );//->getContents( $ajax->data['path'] );
				break;					

					
/********* CREATE FILE OR FOLDER *********/
			case 'action-create-file-or-folder':
				
					if( $ajax->data['type'] == 'folder' ) {
						ffContainer::getInstance()->getFileSystem()->makeDirRecursive( $ajax->data['path']);
					} else if ( $ajax->data['type'] == 'file' ) {
						ffContainer::getInstance()->getFileSystem()->putContents( $ajax->data['path'], '');
					}
				break;
				
/********* RENAME FILE OR FOLDER *********/
			case 'action-rename-file-or-folder':
				$newName = $ajax->data['newName'];
				$oldName = $ajax->data['oldName'];
				$path = $ajax->data['path'];
				
				ffContainer::getInstance()->getFileSystem()->move($path.'/'.$oldName, $path.'/'.$newName, false);
				
				break;

				
/********* DELETE FILE OR FOLDER *********/
			case 'action-delete-file-or-folder':
				$path = $ajax->data['path'];
			
				ffContainer::getInstance()->getFileSystem()->delete($path, true);//->move($path.'/'.$oldName, $path.'/'.$newName, false);
			
				break;				
		}
		
	}
}