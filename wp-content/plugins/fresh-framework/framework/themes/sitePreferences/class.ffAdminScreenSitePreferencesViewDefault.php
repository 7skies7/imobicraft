<?php
class ffAdminScreenSitePreferencesViewDefault extends ffAdminScreenView {
	private  $_currentTemplate = null;

	private $_currentTemplateIsInherited = false;

	private $_currentView= null;

	public function ajaxRequest( ffAdminScreenAjax $ajax ) {

//		var_dump( $ajax );
	}

	private $_dataManager = null;
	/**
	 * @return ffViewDataManager
	 */
	private function _getViewDataManager() {
		if( $this->_dataManager == null ) {
			$this->_dataManager = ffContainer()->getThemeFrameworkFactory()->getSitePreferencesFactory()->getViewDataManager();
		}
		return $this->_dataManager;
	}

	public function newAjaxRequest( ffAjaxRequest $ajaxRequest ) {

		$dispatcher =ffContainer()->getAjaxDispatcher();

		if( $ajaxRequest->getData('action') == 'add-view-item' ) {
			$newItemName = $ajaxRequest->getData('newItemName', '');
			$stringHelper = ffContainer()->getHelpersFactory()->getStringHelper();
			$newItemId = $stringHelper->convertToAlphaNumeric( $newItemName, true, true);

			$viewExists = $this->_getViewDataManager()->getTemplate( $newItemId );



			if( $viewExists->getData() != null ) {
				$dispatcher->addResponse('status', 0);
				$dispatcher->addResponse('message', 'Item already exists');
			} else {
				$this->_getViewDataManager()->addTemplate( $newItemId, $newItemName );//setTemplate()//add( $newItemId, $newItemName );
				$dispatcher->addResponse('status', 1);
				$dispatcher->addResponse('new-view-id', $newItemId );
			}
		}

		else if( $ajaxRequest->getData('action') == 'delete-view-item' ) {
			$viewId = $ajaxRequest->getData('viewId');

			$dataManager = $this->_getViewDataManager();
			$dataManager->deleteTemplate( $viewId );

			$dispatcher->addResponse('status', 1);
			$dispatcher->addResponse('message', 'Item has been deleted');
		}

		else if( $ajaxRequest->getData('action') == 'rename-view-item' ) {
			$viewId = $ajaxRequest->getData('itemId');
			$viewName = $ajaxRequest->getData('newItemName');


			$item =  $this->_getViewDataManager()->getTemplate( $viewId );
			$item->set('name', $viewName );
			$this->_getViewDataManager()->setTemplate( $viewId, $item );

			$dispatcher->addResponse('status', 1);
			$dispatcher->addResponse('message', 'Item has been renamed');

		}

		else if( $ajaxRequest->getData('action') == 'assign-template-to-view' ) {
			$settings = $ajaxRequest->getSpecification('settings');
			$currentViewId = $settings['active_item_id'];

			$templateId = $ajaxRequest->getData('templateId');

			if( $templateId == 'ff-inherited-view' ) {
				$this->_getViewDataManager()->deleteTemplateForView( $currentViewId );
			} else {
				$this->_getViewDataManager()->assignTemplateForView($templateId, $currentViewId);
			}
			$dispatcher->addResponse('status', 1);
		}

		else if ( $ajaxRequest->getData('action') == 'duplicate-template' ) {
			$templateId = $ajaxRequest->getData('templateId');
			$stringHelper = ffContainer()->getHelpersFactory()->getStringHelper();
			$newTemplateName = $ajaxRequest->getData('newName');
			$newTemplateId = $stringHelper->convertToAlphaNumeric( $newTemplateName, true, true);

			$templateExists = $this->_getViewDataManager()->getTemplate( $newTemplateId );

//			var_Dump( $templateExists );
			if( $templateExists->getData() != null ) {
				$dispatcher->addResponse('status', 0);
				$dispatcher->addResponse('message', 'Item already exists');
			} else {
				$templateCollection = $this->_getViewDataManager()->getTemplatesCollection();

				$oldTemplate = $this->_getViewDataManager()->getTemplate( $templateId );
				$oldTemplate->set('name', $newTemplateName);
				$newTemplateData = $oldTemplate->getData();

				$templateCollection->setItemToDb($newTemplateId, $newTemplateData );
				$dispatcher->addResponse('status', 1);
				$dispatcher->addResponse('new-view-id', $newTemplateId );
			}
		}

		else if ( $ajaxRequest->getData('action') == 'reset-template' ) {
			$templateId = $ajaxRequest->getData('templateId');
			$templatesCollection = $this->_getViewDataManager()->getTemplatesCollection();
			$templatesCollection->deleteItemFromDB( $templateId );
			$templatesCollection->getItemById( $templateId );

			$dispatcher->addResponse('status', 1);
		}


		else if( $ajaxRequest->getData('action') == 'themebuilder-save-ajax' ) {
			$builderSettings = $ajaxRequest->getData('builderSettings');
			$content = $ajaxRequest->getData('content');
			$viewId = $builderSettings['viewId'];


			$template = $this->_getViewDataManager()->getTemplateForView( $viewId);

			$template->set('builder', $content);
			$this->_getViewDataManager()->saveTemplatesCollection();
		}

		else if( $ajaxRequest->getData('action') == 'save-options' ) {
			$settings = $ajaxRequest->getSpecification('settings');
			$viewId = $settings['active_item_id'];

			$options = $ajaxRequest->getData('form');

			$template = $this->_getViewDataManager()->getTemplateForView( $viewId);

			$template->set('options', $options);
			$this->_getViewDataManager()->saveTemplatesCollection();
		}

	}

	protected function _render() {


		$settings = array();
		$settings['active_item_id'] = $this->_getActiveItemId();
		$settings['current_url'] = ffContainer()->getUrlRewriter()->getCurrentUrl();

		echo '<div class="ff-collection-settings" data-settings="'.esc_attr( json_encode( $settings )).'"></div>';
        echo '<div class="ff-collection">';
			echo '<div class="ff-collection-sidebar">';
				echo '<div class="ff-collection-sidebar-title">Sitemap</div>';
				echo '<div class="ff-items-wrapper">';
					$this->_printMenu();
				echo '</div>';
			echo '</div>';

			echo '<div class="ff-collection-content">';
				if( $this->_getActiveItemId() != null ) {
				echo '<div class="ff-collection-switcher">';
					$this->_printCollectionSwitcher();
				echo '</div>';

					echo '<div class="ff-collection-content-area ff-collection-builder">';
					$this->_printBuilderArea();
					echo '</div>';

					echo '<div class="ff-collection-content-area ff-collection-options ffb-options" style="display:none;">';
					echo '<div class="ff-collection-content-options-wrapper">';
					$this->_printOptionsArea();
					echo '</div>';
					echo '</div>';
				} else {
					?>
					<div style="padding-top:100px;">
						<h1>Read this before editing</h1>
						<ul>
							<li>- Here you can edit every aspect of your website</li>
<!--							<li style="color:red;">- if you are editing footer and dont see any changes after save, <strong>you are editing the wrong (not assigned) footer</strong></li>-->
							<li>- You can assign Header, Footer and Titlebar for every part of your page</li>
						</ul>
						<br><br>
						<h1>Quick tutorial</h1>
						<iframe width="560" height="315" src="https://www.youtube.com/embed/pv-ZjmmOEcw" frameborder="0" allowfullscreen></iframe>
					</div>
					<?php
				}



			echo '</div>';
			echo '<div class="clear clearfix"></div>';


		echo '</div>';




	}

	private function _printCollectionSwitcher() {

//		$siteMapper = ffContainer()->getThemeFrameworkFactory()->getSitePreferencesFactory()->getSiteMapper();
//		$views = $siteMapper->getSiteMapHierarchical();


		$dataManager = ffContainer()->getThemeFrameworkFactory()->getSitePreferencesFactory()->getViewDataManager();
		$viewsMappedItems = $dataManager->getViewsWithMappedItems();

//		var_dump( $viewsMappedItems );

		$currentItemId=  $this->_getActiveItemId();

		$selectOptions = '';
		$editOptions = '';

		$siteMapper = ffContainer()->getThemeFrameworkFactory()->getSitePreferencesFactory()->getSiteMapper();
		$views = $siteMapper->getSiteMap();

		$this->_currentView = $siteMapper->getViewFromId( $this->_getActiveItemId());//$views[ $this->_getActiveItemId() ];


//		var_dump( $this->_currentView);
//		var_dump( $this->_getActiveItemId(), $views );

		$currentTemplate = $dataManager->getTemplateForView( $this->_getActiveItemId() );
		$this->_currentTemplate = $currentTemplate;
		$this->_currentTemplateIsInherited = $currentTemplate->getAttr('inherited', false);

//		var_Dump( $this->_currentView,$currentTemplate->getId() );

//		var_dump( $currentTemplate );
		echo '<div class="ff-current-template">';
			echo '<span class="ff-current-template-label">Currently active Layout for <span class="ff-current-view-label">'. $this->_currentView['name'].'</span> view is: </span>';
			echo '<div class="ff-current-template-name ff-edit-views" data-ffb-tooltip="Select Layout">';
				echo $currentTemplate->get('name', '<span style="color:red">NOT ASSIGNED</span>');
			echo '</div>';
			echo '<div class="ff-current-template-additional-data">';
				if( $currentTemplate->getAttr('inherited') == true ) {
					echo '- Inherited from parent (' . $currentTemplate->getAttr('parent-name').')';
				}
			echo '</div>';
//			echo 'Current template: ' . $currentTemplate
		echo '</div>';

		$viewNames = array();

		foreach( $views as $oneView)  {
			$viewNames[ $oneView['id'] ] = $oneView['name'];
		}



//		var_dump( $viewNames );

		$editViewsContent = '';

		if( $this->_currentView['type'] != 'top') {
			$editOptionsAttr = ffContainer()->getMultiAttrHelper();

			$editOptionsAttr->addParam('data-view-id', 'ff-inherited-view' );
			$editOptionsAttr->addParam('data-is-default', 1 );
			$editOptionsAttr->addParam('class', 'ff-one-view-default');

			$editOptionsAttr->addParam('class', 'ff-one-view');

			if( $this->_currentTemplateIsInherited) {
				$editOptionsAttr->addParam('class', 'ff-one-view-active');
			}

			$editViewsContent .= '<div ' . $editOptionsAttr . '>';
			$editViewsContent .= '<div class="ff-act-use ff-act-use-inherited-view">';
			$editViewsContent .= '<div class="ff-name">Inherited';
//			$editViewsContent .= $oneView->get('name');
			$editViewsContent .= '</div>';
//			$editViewsContent .= '<div class="ff-assigned-views">' . $assignedLabel . implode( ', ', $assignedItems) . '</div>';
			$editViewsContent .= '</div>';
//			$editViewsContent .= '<div class="ff-one-view-edit-button"></div>';
			// $editViewsContent .= '<div class="ff-act-rename">Rename</div>';
			// $editViewsContent .= '<div class="ff-act-delete">Delete</div>';
			$editViewsContent .= '</div>';
		}

		foreach( $viewsMappedItems as $oneView ) {


			$isActive = in_array( $currentItemId, $oneView->get('assigned_items', array()) );

			if( $this->_currentTemplateIsInherited == true ) {
				$isActive = false;
			}


			$editOptionsAttr = ffContainer()->getMultiAttrHelper();

			$editOptionsAttr->addParam('data-view-id', $oneView->getId() );
			$editOptionsAttr->addParam('data-is-default', $oneView->getAttr('default', 0) );

			if( $oneView->getAttr('default', 0) == 1 ) {
				$editOptionsAttr->addParam('class', 'ff-one-view-default');
			}


			$editOptionsAttr->addParam('class', 'ff-one-view');

			if( $isActive ) {
				$editOptionsAttr->addParam('class', 'ff-one-view-active');
			}

			$assignedItems = array();

//			var_dump( $viewNames );

			foreach( $oneView->get('assigned_items', array()) as $oneAssignedItemId ) {
//				$view = $views->getItemById( $oneAssignedItemId );

				if( !isset( $viewNames[ $oneAssignedItemId ] ) ) {
					continue;
				}
				$assignedItemName = ( $viewNames[$oneAssignedItemId]);
//				var_dump( $views );
				$assignedItems[] = ( $assignedItemName );

			}

			$editOptionsAttr->addParam('data-is-assigned', (int)!empty($assignedItems) );

			$assignedLabel = 'Unassigned';
			if ( !empty($assignedItems) ) 	{
				$assignedLabel = 'Assigned to: ';
			}


			$editViewsContent .= '<div ' . $editOptionsAttr . '>';
			$editViewsContent .= '<div class="ff-act-use">';
				$editViewsContent .= '<div class="ff-name">';
					$editViewsContent .= $oneView->get('name');
				$editViewsContent .= '</div>';
				$editViewsContent .= '<div class="ff-assigned-views">' . $assignedLabel . implode( ', ', $assignedItems) . '</div>';
			$editViewsContent .= '</div>';
			$editViewsContent .= '<div class="ff-one-view-edit-button"></div>';
			// $editViewsContent .= '<div class="ff-act-rename">Rename</div>';
			// $editViewsContent .= '<div class="ff-act-delete">Delete</div>';
			$editViewsContent .= '</div>';

		}


		$currentView = $this->_getActiveItemId();
		$templateForView = $this->_getViewDataManager()->getTemplateForView( $currentView );

		echo '<div class="ff-edit-views-content">';
			echo '<div class="ff-views-title">Select Layout</div>';
			echo '<div class="ff-edit-views-list">';
				echo $editViewsContent;
			echo '</div>';
			echo '<div class="ff-add-new-view"></div>';
		echo '</div>';
	}

	protected function _printOptionsArea() {
		if( $this->_currentTemplateIsInherited ) {
			echo '<div class="ff-current-template-is-inherited">Current Layout is inherited. You need to set one, or edit parent. You can create the layout here, by clicking the : "inherited" options</div>';
			return;
		}
		$s = ffContainer()->getOptionsFactory()->createOptionsHolder('ffOptionsHolder_SitePreferences')->getOptions();

		$viewId = $this->_getActiveItemId();
		$dataManager = ffContainer()->getThemeFrameworkFactory()->getSitePreferencesFactory()->getViewDataManager();

		$viewData = $dataManager->getTemplateForView( $viewId );

		$printer2 = ffContainer()->getOptionsFactory()->createOptionsPrinter2( $viewData->get('options'), $s );
		$printer2->printOptions();
	}

	protected function _printBuilderArea() {

		$hideBuilder = false;

		if( $this->_currentTemplateIsInherited ) {
			echo '<div class="ff-current-template-is-inherited">Current Layout is inherited. You need to set one, or edit parent. You can create the layout here, by clicking the : "inherited" options</div>';
			$hideBuilder = true;
		}

		if( is_object($this->_currentTemplate) && $this->_currentTemplate->getId() == null ) {
			echo '<div class="ff-current-template-is-not-assigned" style="padding-left:19px;">Current view does not have assigned Layout. You need to create new one or set already existing</div>';
			echo '<div class="ff-current-template-is-not-assigned" style="padding-left:19px;">This happens mainly when you create new custom post type.</div>';
			$hideBuilder = true;
		}

		echo '<div class="ff-freshbuilder" style="padding-left:19px;">If you wish the Fresh Builder to fallback to your files (For example single-events.php, etc), just keep the Fresh Builder empty</div>';

		if( $hideBuilder ) {
			echo '<div style="display:none">';
		}


		$viewId = $this->_getActiveItemId();
		$dataManager = ffContainer()->getThemeFrameworkFactory()->getSitePreferencesFactory()->getViewDataManager();
		$viewData = $dataManager->getTemplateForView( $viewId );

//		var_dump( $viewData );

		$themeBuilder = ffContainer()->getThemeFrameworkFactory()->getThemeBuilder();
		$themeBuilder->setSaveAsPost(false)
			->setSaveAjaxOwner('ffAdminScreenManager', array('adminScreenName'=>'SitePreferences', 'adminViewName'=>'Default'));

		$themeBuilder->addSetting( 'viewId', $viewId );
		$themeBuilder->addSetting('broadcastRefreshAfterSave', 0);
		$themeBuilder->renderBuilderArea( $viewData->get('builder') );

		if( $hideBuilder ) {
			echo '</div>';
		}
	}

	protected function _printMenu() {
		$siteMapper = ffContainer()->getThemeFrameworkFactory()->getSitePreferencesFactory()->getSiteMapper();
		$views = $siteMapper->getSiteMapHierarchical();

		$urlRewriter = ffContainer()->getUrlRewriter();
		$activeItemId = $this->_getActiveItemId();


		$isWPMLActive = false;
		$isTopLevelObjectActive = true;

		foreach( $views as $oneView)  {

			$isActiveParent = true;
			$haveChilds = isset( $oneView['child'] );



			if( $haveChilds ) {
				$isActiveParent = false;
				$isWPMLActive = true;
			}

			if( $haveChilds ) {
				foreach ($oneView['child'] as $oneChild) {
					if ($oneChild['id'] == $activeItemId) {
						$isActiveParent = true;
					}
				}
			}

			$isActive = ($activeItemId == $oneView['id']);

			if( $isWPMLActive == false ) {
//				$isActiveParent = true;
//				$isActiveParen
				$isActiveParent = $isActive;
			} else {
//				$isActiveParent = false;
			}


			$attrHelper = ffContainer()->getMultiAttrHelper();
			$attrHelper->addParam('data-item-id',  $oneView['id'] );
			$attrHelper->addParam('class', 'ff-one-item');



			if( $isActiveParent || $isActive ) {
				$attrHelper->addParam('class', 'ff-one-item-active');
			}

			$urlRewriter->reset();
			$urlRewriter->addQueryParameter('view_name', $oneView['name']);
			$urlRewriter->addQueryParameter('view_id', $oneView['id']);

			echo '<div ' . $attrHelper->getAttrString(). '>';
				echo '<a href="'.$urlRewriter->getNewUrl().'">' . $oneView['name'] . '</a>';

				if( $haveChilds && ($isActive || $isActiveParent)) {
					echo '<div class="ff-sub-items-wrapper">';

					$childAttrHelper = ffContainer()->getMultiAttrHelper();
					$childAttrHelper->addParam('class', 'ff-one-sub-item');


					if( $isActive && $isActiveParent ) {
						$childAttrHelper->addParam('class', 'ff-one-sub-item-active' );
					}
					$childAttrHelper->addParam('data-type', 'lang');

					$urlRewriter->reset();
					$urlRewriter->addQueryParameter('view_name', $oneView['name']);
					$urlRewriter->addQueryParameter('view_id', $oneView['id']);
					echo '<div '.$childAttrHelper.'>';
					echo '<a href="'.$urlRewriter->getNewUrl().'">'.$oneView['name'].' - General</a>';

					if( $isActive ) {
						echo '<div class="ff-sub-items-wrapper">';
						echo '<div class="ff-one-sub-item ff-one-content-switcher ff-one-sub-item-active" data-type="options"><a href="">Layout Settings</a></div>';
						echo '<div class="ff-one-sub-item ff-one-content-switcher" data-type="builder"><a href="">Layout Builder</a></div>';
						echo '</div>';
					}

					echo '</div>';

					foreach( $oneView['child'] as $oneChild ) {
						$isChildActive = ($activeItemId == $oneChild['id']);

						$childAttrHelper = ffContainer()->getMultiAttrHelper();
						$childAttrHelper->addParam('class', 'ff-one-sub-item');

						if( $isChildActive ) {
							$isTopLevelObjectActive = false;
							$childAttrHelper->addParam('class', 'ff-one-sub-item-active' );
						}
						$childAttrHelper->addParam('data-type', 'lang');

						$urlRewriter->reset();
						$urlRewriter->addQueryParameter('view_name', $oneChild['name']);
						$urlRewriter->addQueryParameter('view_id', $oneChild['id']);
						echo '<div '.$childAttrHelper.'>';
						echo '<a href="'.$urlRewriter->getNewUrl().'">'.$oneChild['name'].'</a>';

						if( $isChildActive ) {
							echo '<div class="ff-sub-items-wrapper">';
							echo '<div class="ff-one-sub-item ff-one-content-switcher ff-one-sub-item-active" data-type="options"><a href="">Layout Settings</a></div>';
							echo '<div class="ff-one-sub-item ff-one-content-switcher" data-type="builder"><a href="">Layout Builder</a></div>';
							echo '</div>';
						}

						echo '</div>';
					}

					echo '</div>';
				} else if( $isActiveParent ) {
					echo '<div class="ff-sub-items-wrapper">';

					echo '<div class="ff-one-sub-item ff-one-content-switcher ff-one-sub-item-active" data-type="builder"><a href="">Layout Builder</a></div>';
					echo '<div class="ff-one-sub-item ff-one-content-switcher" data-type="options"><a href="">Layout Settings</a></div>';

					echo '</div>';
				}

			echo '</div>';

			$isActive = false;
		}
	}

	protected function _requireAssets() {
		$themeBuilder = ffContainer()->getThemeFrameworkFactory()->getThemeBuilder();

		$themeBuilder->requireBuilderScriptsAndStyles();

//		$pluginUrl = ffPluginFreshMinificatorContainer::getInstance()->getPluginUrl();
//		$this->_getScriptEnqueuer()->addScript('ffAdminScreenMinificatorViewDefault', $pluginUrl .'/adminScreens/minificator/assets/adminScreen.js', array('jquery') );
		$this->_getStyleEnqueuer()
			->addStyleFramework('ff-site-preferences', '/framework/themes/sitePreferences/style.css');

		$this->_getScriptEnqueuer()
			->addScriptFramework('ff-perfect-scrollbar', '/framework/extern/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js');

		$this->_getStyleEnqueuer()
			->addStyleFramework('ff-perfect-scrollbar', '/framework/extern/perfect-scrollbar/css/perfect-scrollbar.min.css');
		$this->_getScriptEnqueuer()
			->addScriptFramework('ff-site-preferences', '/framework/themes/sitePreferences/script.js');
	}


	protected function _setDependencies() {

	}

	private function _getActiveItemType() {
		$activeId = $this->_getActiveItemId();

		$splittedId = explode('-|-', $activeId );

		if( isset( $splittedId[1]) ) {
			return 'language';
		} else {
			return 'top';
		}
	}

	private function _getActiveItemPrimaryParent() {
		$activeId = $this->_getActiveItemId();
		$splittedId = explode('-|-', $activeId );

		return $splittedId[0];
	}

	private function _getActiveItemId() {
		$request = ffContainer()->getRequest();
		$itemId = $request->get('view_id', null);

//		$itemSplitted = explode('-|-', 'page');
//		var_dump( $itemSplitted );
//		die();

		return $itemId;
	}
}