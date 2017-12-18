<?php

abstract class ffThemeBuilderElementBasic extends ffThemeBuilderElement {
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/
	/**
	 * List of other potential tabs
	 * @var array
	 */
	protected $_tabs = array();


	protected $_systemThingsHasBeenAppliedOnRepeatable = array();


/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/
	/*----------------------------------------------------------*/
	/* DROPZONES
	/*----------------------------------------------------------*/
	protected function _addDropzoneBlacklistedElement( $elementId ) {
		$this->_dropzoneElementBlacklist[] = $elementId;
	}

	protected function _addDropzoneWhitelistedElement( $elementId ) {
		$this->_dropzoneElementWhitelist[] = $elementId;
	}

	protected function _addParentWhitelistedElement( $elementId ) {
		$this->_parentElementWhitelist[] = $elementId;
	}

	protected function _getBlacklistedElements() {
		$toReturn = null;
		if( !empty( $this->_dropzoneElementBlacklist ) ) {
			$toReturn = htmlspecialchars(json_encode($this->_dropzoneElementBlacklist));
		}

		return $toReturn;
	}

	protected function _getWhitelistedElements() {
		$toReturn = null;
		if( !empty( $this->_dropzoneElementWhitelist ) ) {
			$toReturn = htmlspecialchars(json_encode($this->_dropzoneElementWhitelist));
		}

		return $toReturn;
	}
/**********************************************************************************************************************/
/* RENDER ADMIN
/**********************************************************************************************************************/
	protected function _renderAdmin_getClasses( ffMultiAttrHelper $multiAttrHelper ) {
		$hasDropzone = $this->_getData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$multiAttrHelper->addParam('class', 'ffb-element');
		$multiAttrHelper->addParam('class', 'ffb-element-'. $this->getID() );
		if( $hasDropzone ) {
			$multiAttrHelper->addParam('class', 'ffb-element-dropzone-yes');
		} else {
			$multiAttrHelper->addParam('class', 'ffb-element-dropzone-no');
		}
	}

	protected function _renderAdmin_getParams( ffMultiAttrHelper $multiAttrHelper, ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		$dataCoded = htmlspecialchars(json_encode( $data ));
		$multiAttrHelper->setParam('data-options', $dataCoded);
		$multiAttrHelper->setParam('data-element-id', $this->getID());
		$multiAttrHelper->setParam('data-unique-id', $uniqueId);

		$blacklistedElements = $this->_getBlacklistedElements();
		$whitelistedElements = $this->_getWhitelistedElements();

		if( $blacklistedElements != null ) {
			$multiAttrHelper->setParam('data-dropzone-mode', 'blacklist');
			$multiAttrHelper->setParam('data-dropzone-list', $blacklistedElements);
		} else if( $whitelistedElements != null ) {
			$multiAttrHelper->setParam('data-dropzone-mode', 'whitelist');
			$multiAttrHelper->setParam('data-dropzone-list', $whitelistedElements);
		}

	}

	protected function _renderAdmin( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		$name = $this->_getData( ffThemeBuilderElement::DATA_NAME);
		$multiAttrHelper = ffContainer()->getMultiAttrHelper();

		$this->_renderAdmin_getClasses( $multiAttrHelper );
		$this->_renderAdmin_getParams( $multiAttrHelper, $query, $content, $data, $uniqueId );

		$otherData = new ffStdClass();
		$otherData->uniqueId = $uniqueId;
		$this->_beforeRenderingAdminWrapper( $query, $content, $multiAttrHelper, $otherData );

		$hasDropzone = $this->_getData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);

		$contextMenuClass = $hasDropzone ? 'action-toggle-context-menu-dropzone' : 'action-toggle-context-menu-no-dropzone';

		echo '<div ' . $multiAttrHelper->getAttrString() . '>';
			echo '<div class="ffb-header clearfix">';
				echo '<div class="ffb-header__button ffb-header__button-left action-toggle-collapse"></div>';
				echo '<div class="ffb-header__button ffb-header__button-left action-column-smaller" data-ffb-tooltip="Make Narrower"></div>';
				echo '<div class="ffb-header__button ffb-header__button-left action-column-bigger" data-ffb-tooltip="Make Wider"></div>';
				echo '<a class="ffb-header-name" title="'.$name.'">'.$name.'</a>';
				echo '<div class="ffb-header__button ffb-header__button-right action-toggle-context-menu '.$contextMenuClass.'" data-ffb-tooltip="Actions"></div>';
				echo '<div class="ffb-header__button ffb-header__button-right action-edit-element" data-ffb-tooltip="Edit Element"></div>';
				echo '<div class="ffb-header__button ffb-header__button-right action-text-color" data-ffb-tooltip="Text Color Palette"></div>';
				if( !$hasDropzone ) {
					echo '<div class="ffb-header__button ffb-header__button-right action-preview-element">';
						echo '<div class="ffb-header__button-preview-content">';
							echo '<img src="'. $this->getPreviewImageUrl() .'">';
						echo '</div>';
					echo '</div>';
				}
				if( $hasDropzone ) {
					echo '<div class="ffb-header__button ffb-header__button-right action-add-element" data-ffb-tooltip="Add Element"></div>';
				}
			echo '</div>';
			echo '<div class="ffb-element-preview action-edit-element">';

			echo '</div>';
			if( $hasDropzone ) {
				echo '<div class="ffb-dropzone ffb-dropzone-'.$this->getID().' clearfix">';
				echo $this->_doShortcode($content);
				echo '</div>';
			}
		echo '</div>';
	}

	/*----------------------------------------------------------*/
	/* RENDER CONTENT
	/*----------------------------------------------------------*/
	protected function _renderContentInfo_JS() {
		//query, data.elementData, this.$el.children('.ffb-element-preview'), this.$el, this.vent.d.blocksCallbacks,  previewObject, this, $form
		?>
			<script data-type="ffscript">
				function ( query, options, $elementInfo, $element, blocks, previewObject, view ) {

				}
			</script data-type="ffscript">
		<?php
	}


	/**
	 * get the options structure (Basic options, the default ones)
	 * @return ffOneStructure
	 */
	public function getElementOptionsStructure( $injectBlocksWithoutReference = false ) {
//		if( $this->_elementOptionsStructure == null ) {
			$structure = $this->_getOptionsFactory()->createStructure();
			$s = $this->_getOptionsExtender();

			$s->setInjectBlocksWithoutReference( $injectBlocksWithoutReference );

			$s->setStructure( $structure );

			$s->startSection('o');

				$s->startTabs();

					$s->startSection('gen');

						$s->startTab('General', 'gen', true);
							$s->addOption( ffOneOption::TYPE_HIDDEN , 'ffsys-disabled', '', 0);
							$s->addOption( ffOneOption::TYPE_HIDDEN , 'ffsys-info', '', '{}');
							$this->_getElementGeneralOptions($s);
						$s->endTab();

						foreach( $this->_tabs as $oneTab ) {
							$s->startTab( $oneTab->name );
							call_user_func( $oneTab->callback, $s );
							$s->endTab();
						}

					$s->endSection();

					if( $this->_getData( ffThemeBuilderElement::DATA_HAS_SYSTEM_TABS, true) ) {

                        /*----------------------------------------------------------*/
                        /* Styles
                        /*----------------------------------------------------------*/

                        $this->_getBlock( ffThemeBuilderBlock::STYLES )->setParam(ffThemeBuilderBlock::PARAM_INJECT_WITHOUT_REFERENCE, $injectBlocksWithoutReference)->injectOptions( $s );
                        /*----------------------------------------------------------*/
                        /* Box Model
                        /*----------------------------------------------------------*/
						$this->_getBlock( ffThemeBuilderBlock::BOX_MODEL )->setParam(ffThemeBuilderBlock::PARAM_INJECT_WITHOUT_REFERENCE, $injectBlocksWithoutReference)->injectOptions( $s );
                        /*----------------------------------------------------------*/
                        /* Typography
                        /*----------------------------------------------------------*/
                        $this->_getBlock( ffThemeBuilderBlock::COLORS )
                            ->setParam(ffThemeBuilderBlock::PARAM_INJECT_WITHOUT_REFERENCE, $injectBlocksWithoutReference)
                            ->setParam(ffThemeBuilderBlock_Colors::PARAM_TEXT_COLOR, $this->_color )
                            ->injectOptions( $s );
                        /*----------------------------------------------------------*/
                        /* Element style
                        /*----------------------------------------------------------*/
                        $this->_getBlock( ffThemeBuilderBlock::ADVANCED_TOOLS )->setParam(ffThemeBuilderBlock::PARAM_INJECT_WITHOUT_REFERENCE, $injectBlocksWithoutReference)->injectOptions( $s );

                        /*----------------------------------------------------------*/
                        /* Custom Code
                        /*----------------------------------------------------------*/
                        $this->_getBlock( ffThemeBuilderBlock::CUSTOM_CODES )->setParam(ffThemeBuilderBlock::PARAM_INJECT_WITHOUT_REFERENCE, $injectBlocksWithoutReference)->injectOptions( $s );
					}
				$s->endTabs();

			$s->endSection();

			$this->_elementOptionsStructure = $s->getStructure();
//		}

		return $this->_elementOptionsStructure;
	}
/**********************************************************************************************************************/
/* COLORS PART
/**********************************************************************************************************************/
//	protected function _renderOneColor( $)

/**********************************************************************************************************************/
/* QUERY PART
/**********************************************************************************************************************/

	protected function _getSystemVariationBlocks( $query ) {
		$variation = $query->getVariationType();

		if( $variation == 'html' ) {
			return $this->_getBlock(ffThemeBuilderBlock::HTML)->get($query);
		}

		return '';

	}

	protected function _disableSystemVariationBlocksTakeover() {
		$this->_enableSystemVariationBlocksPrinting = false;
	}

	protected function _enableSystemVariationBlocksTakeover() {
		$this->_enableSystemVariationBlocksPrinting = true;
	}

	private $_enableSystemVariationBlocksPrinting = true;

	/**
	 * When iterating trough repeatable, here we catch system repeatable items
	 * @param ffOptionsQueryDynamic $query
	 * @return bool;
	 */
	public function queryIteratorValidation( $query, $key ) {

		$variation = $query->getVariationType();
		if( $variation == 'html' && $this->_enableSystemVariationBlocksPrinting ) {

			$this->queryIteratorStart($query, $key);

			echo $this->_getSystemVariationBlocks( $query );

			$this->queryIteratorEnd($query, $key);
//			$content = ob_get_contents();
//			ob_end_clean();

//			echo $this->_applySystemThingsOnRepeatable( $content, $query );
			return false;
		}
		return true;
	}

	private $_queryLevel = 0;

	private $_counters = array();

	/**
	 * @param $query ffOptionsQueryDynamic
	 */
	public function queryIteratorBeginning( $query ) {
		$this->_queryLevel++;
	}

	public function queryIteratorEnding( $query ) {
		$this->_queryLevel--;
	}

	/**
	 * @param $query ffOptionsQueryDynamic
	 * @param $key int
	 * @return string
	 */
	protected function _getRepeatableVariationSelector( $query, $key ) {
		$level = $this->_queryLevel;
		$this->_counters[ $level ] = $key + 1;

		foreach( $this->_counters as $key => $value ) {
			if( $key > $level ) {
				unset( $this->_counters[ $key ]);
			}
		}

		$potentialClass = implode('-', $this->_counters);
		return 'ffb-'.$query->getVariationType() . '-' . $potentialClass;
	}


	protected $_storedSelectors = array();

	private function _addSystemThingsHasBeenAppliedOnRepeatable() {
		$this->_systemThingsHasBeenAppliedOnRepeatable[] = false;
	}

	private function _getSystemThingsHasBeenAppliedOnRepeatable() {
		return end( $this->_systemThingsHasBeenAppliedOnRepeatable );
	}

	private function _setSystemThingsHasBeenAppliedOnRepeatable( $value ) {
		array_pop( $this->_systemThingsHasBeenAppliedOnRepeatable );
		$this->_systemThingsHasBeenAppliedOnRepeatable[] = $value;
	}

	private function _removeSystemThingsHasBeenAppliedOnRepeatable() {
		array_pop( $this->_systemThingsHasBeenAppliedOnRepeatable );
	}

	/**
	 * It's called before every options query iteration
	 * @param $query ffOptionsQueryDynamic
	 */
	public function queryIteratorStart( $query, $key ) {
		$this->_variationCounter++;

		$this->_addSystemThingsHasBeenAppliedOnRepeatable();

		$repeatableVariationCssSelector = $this->_getRepeatableVariationSelector( $query, $key );
		$this->_storeSelector( $repeatableVariationCssSelector );

		// SET TEXT COLOR INHERITANCE
		$textColor = $this->_getBlock( ffThemeBuilderBlock::COLORS)->returnOnlyTextColor()->get( $query );

		if( !empty($textColor) ) {
			$this->_getStatusHolder()->addTextColorToStack( $textColor );
		}

		$this->_getAssetsRenderer()->addSelectorToCascade( $repeatableVariationCssSelector );

		ob_start();
	}
	/**
	 * It's called after every options query iteration
	 * @param $query ffOptionsQueryDynamic
	 */
	public function queryIteratorEnd( $query, $key ) {
		$content = ob_get_contents();
		ob_end_clean();

		echo $this->_applySystemThingsOnRepeatable( $content, $query );

		$this->_removeSystemThingsHasBeenAppliedOnRepeatable();
		$this->_getAssetsRenderer()->removeSelectorFromCascade();
	}

//	private $_systemTabsContent = null;

	protected function _applySystemTabsOnRepeatableStart( $query ) {
		ob_start();
	}

	protected function _applySystemTabsOnRepeatableEnd( $query ) {
		$content = ob_get_contents();
		ob_end_clean();

		echo $this->_applySystemThingsOnRepeatable( $content, $query );
	}

	protected function _applySystemThingsOnRepeatable( $content, $query ) {

		if( $this->_getSystemThingsHasBeenAppliedOnRepeatable() == true ) {
			return $content;
		}

		$this->_setSystemThingsHasBeenAppliedOnRepeatable( true );

		$toReturn = $this->_applySystemOptionsOnContent( $content, $query );
		// SET TEXT COLOR INHERITANCE
		$textColor = $this->_getBlock( ffThemeBuilderBlock::COLORS)->returnOnlyTextColor()->get( $query );
		if( !empty($textColor) ) {
			$this->_getStatusHolder()->removeTextColorFromStack( $textColor );
		}

		return $toReturn;
	}

	protected function _advancedToggleBoxStart( $query, $path = null ) {
		$newQuery = $query;

		if( $path == null ) {
			$route = $newQuery->getPath();
			$routeExploded = explode(' ', $route);
			$lastRoute = end( $routeExploded);

			$className = 'ffb-'.$lastRoute;
		} else {
			$className = 'ffb-'.$path;
		}

		$this->_storeSelector( $className );
		$this->_getAssetsRenderer()->addSelectorToCascade( $className );


		if( $path != null ) {
			if( !$newQuery->exists( $path) ) {
//				return null;
			} else {
				$newQuery = $newQuery->get( $path );
			}
		}

		// SET TEXT COLOR INHERITANCE
		$textColor = $this->_getBlock( ffThemeBuilderBlock::COLORS)->returnOnlyTextColor()->get( $newQuery );

		if( !empty($textColor) ) {
			$this->_getStatusHolder()->addTextColorToStack( $textColor );
		}
		ob_start();
	}

	protected function _advancedToggleBoxEnd( $query, $path = null, $print = true) {
		$newQuery = $query;
		$content = ob_get_contents();
		ob_end_clean();


		if( $path != null ) {
			if( !$newQuery->exists( $path) ) {
//				return null;
			} else {
				$newQuery = $newQuery->get( $path );
			}
		}

		$result =  $this->_applySystemThingsOnToggleBox( $content, $newQuery );

		if( $print ) {
			echo $result;
		}
		$this->_getAssetsRenderer()->removeSelectorFromCascade();

		// SET TEXT COLOR INHERITANCE
		$textColor = $this->_getBlock( ffThemeBuilderBlock::COLORS)->returnOnlyTextColor()->get( $newQuery );
		if( !empty($textColor) ) {
			$this->_getStatusHolder()->removeTextColorFromStack( $newQuery );
		}

		if( !$print ) {
			return $result;
		}
	}

	/**
	 * @param $content string
	 * @param $query ffOptionsQueryDynamic
	 */
	protected function _applySystemThingsOnToggleBox( $content, $query ) {

		$content = $this->_applySystemOptionsOnContent( $content, $query );

		return $content;
	}


	protected function _applySystemOptionsOnContent( $content, $query ) {
		$repeatableVariationCssSelector = $this->_getSelectorFromStorage();
		$helper = $this->_getAssetsRenderer()->getElementHelper();
		$helper->parse( $content );

		$this->_getBlock( ffThemeBuilderBlock::BOX_MODEL)->get( $query );
		$this->_getBlock(ffThemeBuilderBlock::ADVANCED_TOOLS)->get( $query );
		$this->_getBlock( ffThemeBuilderBlock::CUSTOM_CODES)->render( $query );
		$this->_getBlock( ffThemeBuilderBlock::COLORS)->get( $query );

		$helper->addAttribute('class', $repeatableVariationCssSelector );


		return $helper->get();
	}



	protected function _storeSelector( $selector ) {
		$this->_storedSelectors[] = $selector;
	}

	protected function _getSelectorFromStorage() {
		return array_pop( $this->_storedSelectors );
	}

	protected  function _getSelectorFromStorageWithoutRemovingIt() {
		return end( $this->_storedSelectors );
	}

/**********************************************************************************************************************/
/* EXTRA CLASS FUNCTIONS
/**********************************************************************************************************************/

	/**
	 * @param $s ffOneStructure
	 * @param $name string
	 * @param $xs_default string
	 */
	protected function _getElementGeneralOptionsTextAlignClasses($s, $name, $xs_default){
		$breakpoints = array(
			'' => 'Phone (XS)&nbsp;&nbsp;&nbsp;&nbsp;',
			'-sm' => 'Tablet (SM)&nbsp;&nbsp;&nbsp;',
			'-md' => 'Laptop (MD)&nbsp;',
			'-lg' => 'Desktop (LG)',
		);

		foreach( $breakpoints as $prefix => $title ) {

			$default_value = $xs_default;
			if( ! empty($prefix) ){
				$default_value = '';
			}

			$option = $s->addOptionNL( ffOneOption::TYPE_SELECT, $name.$prefix, $title . '&nbsp;&nbsp;&nbsp;', $default_value);

			if( ! empty($prefix) ){
				$option->addSelectValue( esc_attr( __('Inherit', 'ark' ) ), '');
			}

			$option->addSelectValue( esc_attr( __('Left', 'ark' ) ), 'text'.$prefix.'-left');
			$option->addSelectValue( esc_attr( __('Center', 'ark' ) ), 'text'.$prefix.'-center');
			$option->addSelectValue( esc_attr( __('Right', 'ark' ) ), 'text'.$prefix.'-right');
		}
	}

	/**
	 * @param $query ffOptionsQueryDynamic
	 * @param $name string
	 * @param $xs_default string
	 * @return string
	 */
	protected function _getGeneralTextAlignClasses($query, $name, $xs_default){
		$textAlign = array();

		$textAlign[] = $query->getWithoutComparationDefault( $name. '', $xs_default);
		$textAlign[] = $query->getWithoutComparationDefault( $name. '-sm', '');
		$textAlign[] = $query->getWithoutComparationDefault( $name. '-md', '');
		$textAlign[] = $query->getWithoutComparationDefault( $name. '-lg', '');

		$textAlign = implode(' ', $textAlign);

		return $textAlign;
	}

/**********************************************************************************************************************/
/* CSS FUNCTIONS
/**********************************************************************************************************************/

	/**
	 * @param string $property
	 * @param string $value
	 * @param string|null $selector
	 * @param boolean   $removeWhiteSpace
	 *
	 * @return ffThemeBuilderCssRule
	 */
	protected function _renderCSSRule($property, $value, $selector = null, $removeWhiteSpace = false ){
		if( empty($value) ){
			return null;
		}

		$rule = $this->getAssetsRenderer()->createCssRule();

		if( $removeWhiteSpace ) {
			$rule->setAddWhiteSpaceBetweenSelectors( false );
		}

		if( !empty( $selector ) ){
			$rule = $rule->addSelector( $selector, false );
		}



		$rule->addParamsString( $property . ':' . $value . ';');
		return $rule;
	}

	/**
	 * @param string $property
	 * @param string $value
	 * @param string|null $selector
	 * @param boolean   $removeWhiteSpace
	 *
	 * @return ffThemeBuilderCssRule
	 */
	protected function _renderCSSRuleImportant($property, $value, $selector = null, $removeWhiteSpace = false ){
		if( empty($value) ){
			return null;
		}

		$rule = $this->getAssetsRenderer()->createCssRule();

		if( $removeWhiteSpace ) {
			$rule->setAddWhiteSpaceBetweenSelectors( false );
		}

		if( !empty( $selector ) ){
			$rule = $rule->addSelector( $selector, false );
		}

		$rule->addParamsString( $property . ':' . $value . ' !important;');
		return $rule;
	}

/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/
	protected function _addTab( $name, $callbackFunction, $position = null ) {
		$newTab = new ffStdClass();
		$newTab->name = $name;
		$newTab->callback = $callbackFunction;

		$this->_tabs[] = $newTab;
	}

	protected function _setColor( $name ) {
		$this->_color = $name;
	}
}