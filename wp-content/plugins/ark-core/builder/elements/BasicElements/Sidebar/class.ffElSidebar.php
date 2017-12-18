<?php

/**
 * @link
 */

class ffElSidebar extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'sidebar');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Sidebar', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);
		$this->_setData( ffThemeBuilderElement::DATA_CAN_BE_CACHED, false);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'basic');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'sidebar');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 0);
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Info', 'ark' ) ) );

				$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('- You can add, edit and remove <strong>Sidebars</strong> in <a href="./admin.php?page=SidebarManager" target="_blank">WP Admin Menu > Ark > Sidebar Manager</a>', 'ark' ) ) );

				$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('- You can add, edit and remove <strong>Widgets</strong> in <a href="./widgets.php" target="_blank">WP Admin Menu > Appearance > Widgets</a>', 'ark' ) ) );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Select Sidebar', 'ark' ) ) );

				$opt = $s->addOptionNL(ffOneOption::TYPE_SIDEBAR_SELECTOR, 'sidebar','','');
				$opt->addSelectValue( ark_wp_kses( __( 'Content Sidebar' , 'ark' ) ), 'sidebar-content' );
				$opt->addSelectValue( ark_wp_kses( __( 'Content Sidebar 2' , 'ark' ) ), 'sidebar-content-2' );
				for( $i = 1; $i<= 4; $i++ ) {
					$opt->addSelectValue( ark_wp_kses( __( 'Footer Sidebar' , 'ark' ) ) .' #'.$i, 'sidebar-footer-'.$i );
				}

				if( class_exists('ffSidebarManager' ) ) {


					$sidebars = ffSidebarManager::getQuery('sidebars');

					if( is_object($sidebars) ) {
						foreach ( $sidebars->get('sidebars') as $sidebar) {
							$opt->addSelectValue( $sidebar->get('title'), sanitize_title( $sidebar->get('slug') ) );
						}
					}
				}

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Widgets Wrapping', 'ark' ) ) );
				$s->startAdvancedToggleBox('widget', 'Widgets Wrapper Settings');
					$s->addElement(ffOneElement::TYPE_DESCRIPTION, '', ark_wp_kses( __('This is Widgets Wrapper', 'ark' ) ) );
				$s->endAdvancedToggleBox('widget');
				$s->startAdvancedToggleBox('widget-title', 'Widgets Title Wrapper Settings');
					$s->addElement(ffOneElement::TYPE_DESCRIPTION, '', ark_wp_kses( __('This is Widgets Title Wrapper', 'ark' ) ) );
				$s->endAdvancedToggleBox('widget-title');
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Widget Settings', 'ark' ) ) );

				$s->addOptionNL(ffOneOption::TYPE_SELECT, 'header-style','','')
					->addSelectValue('Small title, with divider and padding','')
					->addSelectValue('Big title, without divider and padding','widget-title-big')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Design Style', 'ark' ) ) )
				;

				$s->addOptionNL( ffOneOption::TYPE_TEXT, 'widget-margin-bottom', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Custom vertical gap between Widgets (in px)', 'ark' ) ) );
			
				$s->startHidingBox('header-style', array('') );

					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'widget-title-bg-color', '', '#ffffff')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Title Background Color', 'ark' ) ) )
					;
					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'widget-separator-color', '', '#ebeef6')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Divider Color', 'ark' ) ) )
					;
					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'widget-body-bg-color', '', '#ffffff')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Body Background Color', 'ark' ) ) )
					;

				$s->endHidingBox();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		$title_extra_class = $query->get('header-style');

		if( empty($title_extra_class) ) {
			$this->_renderCSSRule('background-color', $query->getColor('widget-title-bg-color'), '.widget-title');
			$this->_renderCSSRule('border-color', $query->getColor('widget-separator-color'), '.widget-body .widget-title');
			$this->_renderCSSRule('background-color', $query->getColor('widget-body-bg-color'), '.widget');
			$this->_renderCSSRule('background-color', $query->getColor('widget-body-bg-color'), '.widget-body .timeline-v2 .timeline-v2-badge-icon');
		}
		$mb = $query->getColor('widget-margin-bottom');
		if (empty($mb)){
			$mb = 30;
		}
		if (!empty($mb) or (0 === $mb) or ('0' === $mb)) {
			$this->getAssetsRenderer()->createCssRule()
				->addSelector('.widget')
				->addParamsString('margin-bottom:' . $mb . 'px;');
		}

		echo '<div class="ark-sidebar ark-element-sidebar';
		if( !empty($title_extra_class) ){
			echo ' '.esc_attr( $title_extra_class );
		}
		echo '">';

		$sidebarName = 'ark-custom-sidebar-' . $query->get('sidebar');


		if (is_active_sidebar( $query->get('sidebar'))) {
			dynamic_sidebar($query->get('sidebar'));
		} else if ( in_array( $query->get('sidebar'), array('sidebar-content','sidebar-footer-1','sidebar-footer-2','sidebar-footer-3','sidebar-footer-4') ) ){
			dynamic_sidebar( $query->get('sidebar'));
		} else {
			echo '<!-- The selected Sidebar ' . esc_attr($query->get('sidebar')) . ' does not exist or does not contain any widgets -->';
		}

		echo '</div>';

		// Widget Wrapper
		$this->_advancedToggleBoxStart( $query, 'widget' );
		$this->_advancedToggleBoxEnd( $query, 'widget' );

		// Title Wrapper
		$this->_advancedToggleBoxStart( $query, 'widget-title' );
		$this->_advancedToggleBoxEnd( $query, 'widget-title' );

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $slementPreview, $slement, blocks ) {

				query.addHeadingSm( null, 'Sidebar Name: ' );
				query.addPlainText( query.get('sidebar') );

			}
		</script data-type="ffscript">
	<?php
	}


}