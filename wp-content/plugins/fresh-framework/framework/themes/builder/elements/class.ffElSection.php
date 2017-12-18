<?php

class ffElSection extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'section');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, 'Section');
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'grid');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'grid, section');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 0);

		$this->_addDropzoneWhitelistedElement('column');

		$this->_addParentWhitelistedElement('canvas');
		$this->_addParentWhitelistedElement('if');
		$this->_addParentWhitelistedElement('shortcode-container');
	}

	public function getPreviewImageUrl() {
		return ffContainer()->getWPLayer()->getFrameworkUrl() . '/framework/themes/builder/elements/section.jpg';
	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _getElementGeneralOptions( $s ) {
		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement(ffOneElement::TYPE_TABLE_DATA_START, '', 'Container');
				$s->addOptionNL(ffOneOption::TYPE_SELECT,'type','','fg-container-large')
					->addSelectValue('Small','fg-container-small')
					->addSelectValue('Medium','fg-container-medium')
					->addSelectValue('Large (default)','fg-container-large')
					->addSelectValue('Full Width','fg-container-fluid')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, 'Container Size' )
				;
				$s->addOption(ffOneOption::TYPE_CHECKBOX,'no-padding','Remove horizontal padding from the Container',0);

			$s->addElement(ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement(ffOneElement::TYPE_TABLE_DATA_START, '', 'Row');

				$s->addOptionNL(ffOneOption::TYPE_SELECT, 'no-gutter', '', 0)
					->addSelectValue('Standard Bootstrap (30px)', 0)
					->addSelectValue('Custom Padding', 2)
					->addSelectValue('No Padding', 1)
					->addParam( ffOneOption::PARAM_TITLE_AFTER, 'Horizontal padding (gutter) between Columns' )
				;

				$s->startHidingBox('no-gutter', 2);

					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'gutter-size', '', '')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, 'Gutter (in px)' );
					;
				$s->endHidingBox();
//				$s->addOptionNL(ffOneOption::TYPE_CHECKBOX,'no-gutter','Remove horizontal padding (gutters) between Columns and negative margin from Row',0);
			$s->addElement(ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement(ffOneElement::TYPE_TABLE_DATA_START, '', 'Columns');
				$s->addElement(ffOneElement::TYPE_DESCRIPTION, '', 'Equalize the height of all inner Columns (calculated from the tallest one)');
//				$s->addOptionNL(ffOneOption::TYPE_SELECT, 'match-col', '', 0)
//					->addSelectValue('Natural Height', 0)
//					->addSelectValue('Equalize Column Height (only direct children)', 1)
//					->addSelectValue('Equalize Column Height (all inner Columns)', 2)
//					->addParam( ffOneOption::PARAM_TITLE_AFTER, 'Column height (calculated from the tallest one)' )
//				;
				$s->addOptionNL(ffOneOption::TYPE_SELECT,'match-col','Phone (XS)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',0)
					->addSelectValue('No', 0)
					->addSelectValue('Yes', 1)
				;
				$s->addOptionNL(ffOneOption::TYPE_SELECT,'match-col-sm','Tablet (SM)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;','inherit')
					->addSelectValue('Inherit', 'inherit')
					->addSelectValue('No', 0)
					->addSelectValue('Yes', 1)
				;

				$s->addOptionNL(ffOneOption::TYPE_SELECT,'match-col-md','Laptop (MD)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;','inherit')
					->addSelectValue('Inherit', 'inherit')
					->addSelectValue('No', 0)
					->addSelectValue('Yes', 1)
				;

				$s->addOptionNL(ffOneOption::TYPE_SELECT,'match-col-lg','Desktop (LG)&nbsp;&nbsp;&nbsp;&nbsp;','inherit')
					->addSelectValue('Inherit', 'inherit')
					->addSelectValue('No', 0)
					->addSelectValue('Yes', 1)
				;

				$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'If this option is enabled, you can then also enable vertical centering on inner Columns. You can enable vertical centering directly on any inner Column element by simply changing it\'s settings.');
			$s->addElement(ffOneElement::TYPE_TABLE_DATA_END);

			/* Dividers - START */
			$s->addElement(ffOneElement::TYPE_TABLE_DATA_START, '', 'Dividers');

				$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'show-divider', 'Show dividing vertical lines between Columns', 0);

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->startHidingBox('show-divider', 'checked');

					$s->startSection('divider');

						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'divider-width', '', '1')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Divider Width', 'ark' ) ) );
						;

						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'divider-height', '', '100%')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Divider Height', 'ark' ) ) );
						;

						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$s->addOptionNL( ffOneOption::TYPE_SELECT, 'divider-h-alignment', '', 'left')
							->addSelectValue( esc_attr( __('Left', 'ark' ) ), 'left')
							->addSelectValue( esc_attr( __('Center', 'ark' ) ), 'center')
							->addSelectValue( esc_attr( __('Right', 'ark' ) ), 'right')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Horizontal Alignment', 'ark' ) ) )
						;

						$s->addOptionNL( ffOneOption::TYPE_SELECT, 'divider-v-alignment', '', 'center')
							->addSelectValue( esc_attr( __('Top', 'ark' ) ), 'top')
							->addSelectValue( esc_attr( __('Center', 'ark' ) ), 'center')
							->addSelectValue( esc_attr( __('Bottom', 'ark' ) ), 'bottom')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Vertical Alignment', 'ark' ) ) )
						;

						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'divider-color', '', '#c4c4c4')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Divider Color', 'ark' ) ) )
						;

						$s->addElement(ffOneElement::TYPE_DESCRIPTION, '', 'NOTE: If you see an unwanted Divider at the start of new line of Columns, you can <strong>fix it on the Column element which is preceding that unwanted Divider</strong> via <code>preceding Column element > Advanced > Last Column > Yes</code>. Currently, this is the only way the system can detect at which point your Columns break onto new lines.');

					$s->endSection();

				$s->endHidingBox();

			$s->addElement(ffOneElement::TYPE_TABLE_DATA_END);
			/* Dividers - END */

			$s->addElement(ffOneElement::TYPE_TABLE_DATA_START, '', 'Special');
				$s->addOption(ffOneOption::TYPE_CHECKBOX,'force-fullwidth','Force Full Width',0);
				$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'This will force the Section element to be full width even if the Section is inside smaller elements (for example Bootstrap Container). Please note that JavaScript will be used to make this happen so only use this sparringly in order to maintain a good performance of your website. If you are not sure why this option is here and what it does then you don\'t probably need it.');
			$s->addElement(ffOneElement::TYPE_TABLE_DATA_END); 

		$s->addElement(ffOneElement::TYPE_TABLE_END);

	}

	private function _getMatchColBreakpoints() {
		$bp = array();
		$bp['xs'] = '';
		$bp['sm'] = '-sm';
		$bp['md'] = '-md';
		$bp['lg'] = '-lg';

		return $bp;
	}
	
	private function _getContainerNestedLevel() {
		$elementStack = $this->_getStatusHolder()->getElementStackStatic();
		$elementsWithContainer = array('section', 'container');
		$level = 0;

		foreach( $elementStack as $oneItem ) {
			if( in_array( $oneItem, $elementsWithContainer ) ) {
				$level++;
			}
		}

		return $level;
	}

	private function _addUnitToInteger( $value, $unit = 'px' ) {
		if( is_numeric( $value ) ) {
			return $value . $unit;
		} else {
			return $value;
		}
	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		$statusHolder = $this->_getStatusHolder();

		$gutterContainer = '';
		if($query->get('no-padding')){
			$gutterContainer = 'fg-container-no-padding';
		}

		$gutterType = $query->getWithoutComparationDefault('no-gutter', 0);
		$gutterRow = '';
		if( $gutterType == 1){
			$gutterRow = 'fg-row-no-gutter';
		} else if( $gutterType == 2 ) {
			$gutterSize = $query->get('gutter-size');

			$onePadding = ((float)$gutterSize / 2 );

			$rowStyle = 'margin-left:-' . $onePadding . 'px;' . PHP_EOL;
			$rowStyle .= 'margin-right:-' . $onePadding . 'px;' . PHP_EOL;

			$colStyle = 'padding-left:' . $onePadding . 'px;' . PHP_EOL;
			$colStyle .= 'padding-right:' . $onePadding . 'px' . PHP_EOL;

			$ar = $this->_getAssetsRenderer();

			$ar->createCssRule()
				->addSelector('> .fg-container > .fg-row')
				->addParamsString( $rowStyle );

			$ar->createCssRule()
				->addSelector('> .fg-container  > .fg-row > .fg-col')
				->addParamsString( $colStyle );
		}

		$matchColData = array();
		$matchColBp = $this->_getMatchColBreakpoints();

		$lastBp = null;
		$isMatchCol = false;
		$counter = 1;
		foreach( $matchColBp as $bpName => $bpQueryNotation ) {
			$value = null;
			if( $bpName == 'xs' ) {
				$value = $query->get('match-col');
				$lastBp = $value;
			} else {
				$value = $query->getWithoutComparationDefault('match-col' . $bpQueryNotation, 'inherit');
			}

			if( $value == 1 ) {
				$isMatchCol = true;
			}

			if( $value == 'inherit' ) {
				$value = $lastBp;
			} else {
				$lastBp = $value;
			}

			$matchColData[ $counter ] = $value;
			$counter++;
		}

		$match_col = '';
		$matchColAttr = '';
		if( $isMatchCol  ){
			$match_col = 'fg-row-match-cols';
			$statusHolder->addMatchColumnsHeightToStack( 1 );
			$matchColAttr = ' data-fg-match-cols="' . esc_attr( json_encode( $matchColData ) ) . '" ';
		}
//		else if( $query->get('match-col') == 2 ) {
//			$match_col = 'fg-row-match-cols fg-row-match-cols-all';
//			$statusHolder->addMatchColumnsHeightToStack( 1 );
//		}
		else {
			$statusHolder->addMatchColumnsHeightToStack( 0 );
		}

		$container_classes = '';
		if( 'fg-container-fluid' == $query->get('type')){
			$container_classes = 'container-fluid fg-container-fluid';
		} else if( 'fg-container-large' == $query->get('type')){
			$container_classes = 'container fg-container-large';
		} else if( 'fg-container-medium' == $query->get('type')){
			$container_classes = 'container fg-container-medium';
		} else if( 'fg-container-small' == $query->get('type')){
			$container_classes = 'container fg-container-small';
		}

		$container_classes .= ' fg-container-lvl--' . $this->_getContainerNestedLevel();

		$forceFullwidthClass = '';
		if( $query->getWithoutComparationDefault('force-fullwidth', 0) ) {
			$forceFullwidthClass = ' fg-force-fullwidth';
		}

		/* Dividers - START */

		$showDivider = $query->getWithoutComparationDefault('show-divider', false);
		$showDividerClass = ' ';
		if( $showDivider ){

			$showDividerClass = 'fg-row-show-dividers';

			$ar = $this->_getAssetsRenderer();

			$dividerColor = $query->getWithoutComparationDefault('divider divider-color', '#c4c4c4');

			if ( 'right' == $query->getWithoutComparationDefault('divider divider-h-alignment', 'left') ){
				$dividerAlignH = 'translateX(0)';
			}
			if ( 'center' == $query->getWithoutComparationDefault('divider divider-h-alignment', 'left') ){
				$dividerAlignH = 'translateX(-50%)';
			}
			if ( 'left' == $query->getWithoutComparationDefault('divider divider-h-alignment', 'left') ){
				$dividerAlignH = 'translateX(-100%)';
			}

			if ( 'top' == $query->getWithoutComparationDefault('divider divider-v-alignment', 'center') ){
				$dividerAlignVPos = 'top:0';
				$dividerAlignVOffset = 'translateY(0)';
			}
			if ( 'center' == $query->getWithoutComparationDefault('divider divider-v-alignment', 'center') ){
				$dividerAlignVPos = 'top:50%';
				$dividerAlignVOffset = 'translateY(-50%)';
			}
			if ( 'bottom' == $query->getWithoutComparationDefault('divider divider-v-alignment', 'center') ){
				$dividerAlignVPos = 'bottom:0';
				$dividerAlignVOffset = 'translateY(0)';
			}

			$dividerWidth = $query->getWithoutComparationDefault('divider divider-width', '1');
			$dividerWidth = $this->_addUnitToInteger( $dividerWidth );

			$dividerHeight = $query->getWithoutComparationDefault('divider divider-height', '100%');
			$dividerHeight = $this->_addUnitToInteger( $dividerHeight );

			$dividerCSS = 'background:'. $dividerColor . ';' . PHP_EOL;
			$dividerCSS .= $dividerAlignVPos . ';' . PHP_EOL;
			$dividerCSS .= 'transform:'.$dividerAlignH.' '.$dividerAlignVOffset. ';' . PHP_EOL;
			$dividerCSS .= 'width:'.$dividerWidth.';' . PHP_EOL;
			$dividerCSS .= 'height:'.$dividerHeight.';' . PHP_EOL;

			$ar->createCssRule()
				->addSelector('> .fg-container > .fg-row > .fg-col:before')
				->addParamsString( $dividerCSS );

			$showDividerClass = 'fg-row-show-dividers';

		}

		/* Dividers - END */

		echo '<section class="fg-section'.$forceFullwidthClass.'" >';
			echo '<div class="fg-container '.$container_classes.' '.$gutterContainer.'">';
				echo '<div class="fg-row row '.$gutterRow.' '.$showDividerClass.' '.$match_col.'" '.$matchColAttr.'>';
					echo $this->_doShortcode( $content );
				echo '</div>';
			echo '</div>';
		echo '</section>';

		$statusHolder->removeMatchColumnsHeightFromStack();

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element ) {

			}
		</script data-type="ffscript">
	<?php
	}

}