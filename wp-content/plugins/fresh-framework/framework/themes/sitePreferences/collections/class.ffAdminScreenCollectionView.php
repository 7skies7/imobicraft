<?php
abstract class ffAdminScreenCollectionView extends ffAdminScreenView {

	protected $_hasOptions = true;

	protected $_hasBuilder = true;

	protected $_itemName = null;

	public function ajaxRequest( ffAdminScreenAjax $ajax ) {

	}

	public function newAjaxRequest( ffAjaxRequest $ajaxRequest ) {
		$this->_init();

//
		if( $ajaxRequest->getData('action') =='saveOptions' ) {
//          returnl;
			$settings = $ajaxRequest->getSpecification('settings');
			$formData = $ajaxRequest->getDataStripped('form');
//
			$activeItemID = $settings['active_item_id'];


//			var_dump( $activeItemID );

			$itemCollection = $this->_getItemCollection();
			$itemCollection->getItemById( $activeItemID )->set('options', $formData);
			$itemCollection->save();

//			$itemCollection = $this->_getItemCollection();
//			$itemCollection->setDataForItem( $activeItemID, null, $formData );
		} else if( $ajaxRequest->getData('action') == 'themebuilder-save-ajax' ) {
			$content = $ajaxRequest->getData('content');
			$builderSettings = $ajaxRequest->getData('builderSettings');
			$activeItemID = $builderSettings['viewId'];

			$colorLibrary = $ajaxRequest->getDataStripped('colorLibrary');
			ffContainer()->getThemeFrameworkFactory()->getThemeBuilderColorLibrary()->setLibrary( $colorLibrary )->saveLibrary();
//			var_dump($activeItemID, $content );
//			var_dump( $activeItemID );

			$itemCollection = $this->_getItemCollection();
			$itemCollection->getItemById( $activeItemID )->set('builder', $content);
			$itemCollection->save();
//
//			var_dump($activeItemID, 			$itemCollection->getItemById( $activeItemID ) );
//			$itemCollection->setItemBuilder( $viewId, $content );
		}

		else if( $ajaxRequest->getData('action') == 'menu-add-new-item' ) {

			$dispatcher =ffContainer()->getAjaxDispatcher();

			$newItemName = $ajaxRequest->getData('newItemName', '');

			$stringHelper = ffContainer()->getHelpersFactory()->getStringHelper();
			$newItemId = $stringHelper->convertToAlphaNumeric( $newItemName, true, true);

			$itemCollection = $this->_getItemCollection();

			$newItemAlreadyExists = !($itemCollection->getItemById($newItemId)->getData() == null );


			if( $newItemAlreadyExists ) {
				$dispatcher->addResponse('status', 0);
				$dispatcher->addResponse('message', 'Item already exists');
			} else {
				$settings = $ajaxRequest->getSpecification('settings');
				$currentUrl = $settings['current_url'];

				$urlRewriter = ffContainer()->getUrlRewriter();
				$urlRewriter->setUrl( $currentUrl );

				$urlRewriter->addQueryParameter('item_name', $newItemName );
				$urlRewriter->addQueryParameter('item_id', $newItemId);

				$dispatcher->addResponse('status', 1);
				$dispatcher->addResponse('url', str_replace('wp-admin/admin.php/', 'wp-admin/admin.php', $urlRewriter->getNewUrl()) );
//				var_dump( $currentUrl );
//				die();
				$itemCollection->setItemToDb( $newItemId, array('name'=> $newItemName ) );
			}

		}

		else if( $ajaxRequest->getData('action') == 'menu-delete-item' ) {
			$settings = $ajaxRequest->getSpecification('settings');
			$currentUrl = $settings['current_url'];

			$menuItemToDelete = ( $ajaxRequest->getData( 'itemIdToDelete') );

			$itemCollection = $this->_getItemCollection();
			$itemCollection->deleteItemFromDB( $menuItemToDelete );

			$dispatcher =ffContainer()->getAjaxDispatcher();
			$dispatcher->addResponse('status', 1);

			$currentItem = $settings['active_item_id'];

			if( $currentItem == $menuItemToDelete ) {
				$urlRewriter = ffContainer()->getUrlRewriter();
				$urlRewriter->setUrl( $currentUrl );

				$urlRewriter->removeQueryParameter('item_name');
				$urlRewriter->removeQueryParameter('item_id');

				$dispatcher->addResponse('new_url', $urlRewriter->getNewUrl() );
			} else {
//				$dispatcher->addResponse('new_url', $currentUrl);
			}
		} else if ( $ajaxRequest->getData('action') == 'menu-reset-item' ) {
			$settings = $ajaxRequest->getSpecification('settings');
			$currentItem = $ajaxRequest->getData('itemId');

			$itemCollection = $this->_getItemCollection();
			$itemCollection->deleteItemFromDB( $currentItem );
			$itemCollection->save();

			$dispatcher =ffContainer()->getAjaxDispatcher();
			$dispatcher->addResponse('aaa', $currentItem);
			$dispatcher->addResponse('status', 1);
		}

		else if ( $ajaxRequest->getData('action') == 'menu-rename-item' ) {
			$settings = $ajaxRequest->getSpecification('settings');
			$currentItem = $ajaxRequest->getData('itemId');

			$newItemName = $ajaxRequest->getData('newItemName');

			$itemCollection = $this->_getItemCollection();
			$itemCollection->getItemById($currentItem)->set('name', $newItemName);
			$itemCollection->save();

			$dispatcher =ffContainer()->getAjaxDispatcher();
			$dispatcher->addResponse('status', 1);

		}

		else if ( $ajaxRequest->getData('action') == 'menu-duplicate-item' ) {
			$settings = $ajaxRequest->getSpecification('settings');
			$currentItem = $ajaxRequest->getData('itemId');

			$itemCollection = $this->_getItemCollection();
			$oldItem = $itemCollection->getItemById($currentItem);
			$newItem = clone( $oldItem );
			$newItem->set('name', $oldItem->get('name') . ' - DUPLICATED');


			$newId = base_convert( time(), 10, 36);
			$newItemId = $currentItem.'_dup_' . $newId;



			$itemCollection->setItemToDb($newItemId, $newItem);

			$itemCollection->save();

			$dispatcher =ffContainer()->getAjaxDispatcher();
			$dispatcher->addResponse('status', 1);
		}

	}



	abstract protected function _init();

	protected $_transTitle = '';

	protected function _nothingSelected() {
	}

	protected function _render() {
		$this->_init();

		$builderStyle = '';
		$collectionStyle = '';

		if( $this->_hasOptions ) {
			$builderStyle = 'style="display:none;"';
		} else {
			$collectionStyle = 'style="display:none;"';
		}

		$activeItemId =  $this->_getActiveItemId();


		echo '<div class="ff-collection">';
			echo '<div class="ff-collection-sidebar">';
				echo '<div class="ff-collection-sidebar-title">' . $this->_transTitle . '</div>';
					$this->_printMenu();
				echo '</div>';

				echo '<div class="ff-collection-content">';
					if( $activeItemId == null ) {
						$this->_nothingSelected();
						wp_enqueue_style('freshframework-font-awesome4', ffContainer()->getWPLayer()->getFrameworkUrl() . '/framework/extern/iconfonts/ff-font-awesome4/ff-font-awesome4.css' );
					} else {


					echo '<div class="ff-collection-content-area ff-collection-options ffb-options" '.$collectionStyle.'>';

						echo '<div class="ff-collection-content-options-wrapper">';
							$this->_printOptionsArea();

							echo '<div class="ffb-builder-toolbar-fixed-wrapper">';
								echo '<div class="ffb-builder-toolbar-fixed clearfix">';
									echo '<div class="ffb-builder-toolbar-fixed-left">';
										echo '<input type="submit" value="Quick Save" class="ff-save-ajax ffb-main-save-ajax-btn ffb-builder-toolbar-fixed-btn">';
									echo '</div>';	
									echo '<div class="ffb-builder-toolbar-fixed-right">';
									echo '</div>';
								echo '</div>';
							echo '</div>';

						echo '</div>';

					echo '</div>';

					echo '<div class="ff-collection-content-area ff-collection-builder" '.$builderStyle.'>';
					$this->_printBuilderArea();
					echo '</div>';

					}

			echo '</div>';
			
		echo '<div class="clear clearfix"></div>';


//		$request = ffContainer()->getRequest();
//		$viewId = $request->get('view_id');

		$settings = array();
		$settings['active_item_id'] = $this->_getActiveItemId();
		$settings['current_url'] = ffContainer()->getUrlRewriter()->getCurrentUrl();
		echo '<div class="ff-collection-settings" data-settings="'.esc_attr( json_encode( $settings )).'"></div>';
		echo '</div>';

		return;


	}

	/*----------------------------------------------------------*/
	/* OPTIONS AREA
	/*----------------------------------------------------------*/
	protected function _printOptionsArea() {
//<<<<<<< HEAD
//		$s = ffContainer()->getThemeFrameworkFactory()->getThemeBuilderElementManager()->getElementById('header')->getElementOptionsStructure(true);

//=======
		$s = $this->_getOptionsStructure();

		if( $s == null ) {
			echo '<div class="ff-has-no-options"></div>';
			return;
		}

//>>>>>>> headers
		$item = $this->_getItemCollection()->getItemById( $this->_getActiveItemId() );

		$printer2 = ffContainer()->getOptionsFactory()->createOptionsPrinter2( $item->get('options'), $s );
		$printer2->printOptions();
	}

	/*----------------------------------------------------------*/
	/* BUILDER AREA
	/*----------------------------------------------------------*/
	protected function _printBuilderArea() {
		$request = ffContainer()->getRequest();

		$viewId = $this->_getActiveItemId();


		$builderData = $this->_getItemCollection()->getItemById($viewId)->get('builder');

		$themeBuilder = ffContainer()->getThemeFrameworkFactory()->getThemeBuilder();
		$themeBuilder->setSaveAsPost(false)
			->setSaveAjaxOwner('ffAdminScreenManager', array('adminScreenName' => $this->_transTitle, 'adminViewName' => 'Default'));

		if ($this->_hasOptions) {
			$themeBuilder->addSetting('broadcastRefreshAfterSave', 0);
		}

		$themeBuilder->addSetting('viewId', $viewId);
		$themeBuilder->renderBuilderArea($builderData);
	}

	/*----------------------------------------------------------*/
	/* CURRENT ITEM
	/*----------------------------------------------------------*/
	private function _getActiveItemId() {
		$request = ffContainer()->getRequest();
//		$itemId = $request->get('item_id', $this->_itemName.'_default');

		$itemId = $request->get('item_id', null);

		return $itemId;
	}

	/**
	 * @return ffOptionsCollection
	 */
	abstract protected function _getItemCollection();

	/**
	 * @return ffOneStructure
	 */
	abstract protected function _getOptionsStructure();

	/*----------------------------------------------------------*/
	/* MENU
	/*----------------------------------------------------------*/

	protected $_transOptionsName = '';
	protected $_transBuilderName = '';

	protected function _printMenu() {
		$itemPartCollection = $this->_getItemCollection();
		$activeItemId = $this->_getActiveItemId();

		$urlRewriter = ffContainer()->getUrlRewriter();

		echo '<div class="ff-items-wrapper">';

			foreach( $itemPartCollection as $id => $oneItem ) {
				$isActive = ($activeItemId == $id);

				$attrHelper = ffContainer()->getMultiAttrHelper();
				$attrHelper->addParam('data-item-id', $id );
				$attrHelper->addParam('class', 'ff-one-item');

				$urlRewriter->reset();
				$urlRewriter->addQueryParameter('item_name', $oneItem->get('name') );
				$urlRewriter->addQueryParameter('item_id', $id);

	//			$attrHelper->addParam('href',  );
				$attrHelper->addParam('data-is-default', $oneItem->getAttr('default') );

				if( $isActive ) {
					$attrHelper->addParam('class', 'ff-one-item-active');
				}

				echo '<div ' . $attrHelper->getAttrString(). '>';
				echo '<a href="'.$urlRewriter->getNewUrl().'">' . $oneItem->get('name') . '</a>';
				echo '<span class="ff-toggle-context-menu"></span>';

				if ($isActive && ($this->_hasOptions && $this->_hasBuilder) ){
					echo '<div class="ff-sub-items-wrapper">';
						echo '<div class="ff-one-sub-item ff-one-sub-item-active" data-type="options"><a href="">' . $this->_transOptionsName . '</a></div>';
						echo '<div class="ff-one-sub-item" data-type="builder"><a href="">' . $this->_transBuilderName . '</a>';

							// extra - start
//							echo '<div class="ff-sub-items-wrapper">';
//								echo '<div class="ff-one-sub-item" data-type="options"><a href="">Extra Submenu Level</a></div>';
//								echo '<div class="ff-one-sub-item" data-type="builder"><a href="">Extra Submenu Level</a></div>';
//							echo '</div>';
							// extra - end

						echo '</div>';


					echo '</div>';
				}
				echo '</div>';
			}

		echo '</div>';

		// echo '<a href="#" class="ff-collection__button ff-collection__button-add-item ff-collection__action-add-item">Add Item</a>';
		// echo '<div class="ff-add-new-item"><span class="ff-add-new-item-icon"></span></div>';
		echo '<button class="ff-add-new-item"></button>';
		echo '<div class="ff-collection-sidebar-buttons clearfix">';
			// echo '<a href="#" class="ff-collection__button ff-collection__button-addd ff-collection__action-addd">Add New</a>';
			echo '<a href="#" class="ff-collection__button ff-collection__button-save-all ff-collection__action-save-all">Quick Save</a>';
		echo '</div>';
	}

	/*----------------------------------------------------------*/
	/* SCRIPT INCLUDER
	/*----------------------------------------------------------*/
	protected function _requireAssets() {
		$themeBuilder = ffContainer()->getThemeFrameworkFactory()->getThemeBuilder();
		$themeBuilder->requireBuilderScriptsAndStyles();

		ffContainer()->getFrameworkScriptLoader()->requireFrsLib()->requireFrsLibOptions2();

		$this->_getScriptEnqueuer()
			->addScriptFramework('ff-perfect-scrollbar', '/framework/extern/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js');

		$this->_getStyleEnqueuer()
			->addStyleFramework('ff-perfect-scrollbar', '/framework/extern/perfect-scrollbar/css/perfect-scrollbar.min.css');
		$this->_getScriptEnqueuer()
			->addScriptFramework('ff-site-preferences', '/framework/themes/sitePreferences/collections/script.js');
		

	}


	protected function _setDependencies() {

	}
}