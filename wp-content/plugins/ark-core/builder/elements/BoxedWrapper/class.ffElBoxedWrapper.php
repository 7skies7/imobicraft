<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_dividers.html#scrollTo__1450
 */

class ffElBoxedWrapper extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'boxed-wrapper');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Boxed Wrapper', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, false);
		$this->_setData( ffThemeBuilderElement::DATA_IS_HIDDEN, true);
		$this->_setData( ffThemeBuilderElement::DATA_CAN_BE_CACHED, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_SYSTEM_TABS, false);


		$this->_setColor('dark');
	}

	protected function _getElementGeneralOptions( $s ) {

		$sh = $s->getOptionsStructureHelper();

		$s->addElement( ffOneElement::TYPE_HTML, '', '<div class="top-hiding-parent">' );

			$s->addElement( ffOneElement::TYPE_TABLE_START );

				$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Body Wrapper', 'ark' ) ) );
					$s->startAdvancedToggleBox('body-wrapper', 'Body Wrapper');
						$s->addOption(ffOneOption::TYPE_HIDDEN, 'hidden', '','');
						$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'NOTE: Click on the <i class="dashicons dashicons-edit"></i> pencil icon in the top-right corner of this box to customize your Body Wrapper.');
					$s->endAdvancedToggleBox();
				$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


				$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Boxed Wrapper', 'ark' ) ) );
					$s->startAdvancedToggleBox('boxed-wrapper', 'Boxed Wrapper');
						$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'NOTE: Click on the <i class="dashicons dashicons-edit"></i> pencil icon in the top-right corner of this box to customize your Boxed Wrapper.');

						$s->addElement(ffOneElement::TYPE_NEW_LINE);
						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$s->addElement(ffOneElement::TYPE_HTML, '', '<table class="ffb-box-model-table" border="0" cellpadding="0" cellspacing="0">');

						$s->addElement(ffOneElement::TYPE_HTML, '', '<tbody><tr><td></td><td>Boxed Wrapper Position</td></tr>');

						$s->startSection( 'xs' );

							$s->addElement(ffOneElement::TYPE_HTML, '', '<tr>');

								$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
									$s->addElement(ffOneElement::TYPE_HTML, '', 'Phone (XS)');
								$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

								$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
									$s->addOptionNL( ffOneOption::TYPE_SELECT, 'boxed-wrapper-align', '', 'center')
										->addSelectValue( esc_attr( __('Center', 'ark' ) ), 'center')
										->addSelectValue( esc_attr( __('Left', 'ark' ) ), 'left')
										->addSelectValue( esc_attr( __('Right', 'ark' ) ), 'right')
									;
								$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

							$s->addElement(ffOneElement::TYPE_HTML, '', '</tr>');

						$s->endSection();

						$s->startSection( 'sm' );

							$s->addElement(ffOneElement::TYPE_HTML, '', '<tr>');

								$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
									$s->addElement(ffOneElement::TYPE_HTML, '', 'Tablet (SM)');
								$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

								$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
									$s->addOptionNL( ffOneOption::TYPE_SELECT, 'boxed-wrapper-align', '', '')
										->addSelectValue( esc_attr( __('Inherit', 'ark' ) ), '')
										->addSelectValue( esc_attr( __('Center', 'ark' ) ), 'center')
										->addSelectValue( esc_attr( __('Left', 'ark' ) ), 'left')
										->addSelectValue( esc_attr( __('Right', 'ark' ) ), 'right')
									;
								$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

							$s->addElement(ffOneElement::TYPE_HTML, '', '</tr>');

						$s->endSection();

						$s->startSection( 'md' );

							$s->addElement(ffOneElement::TYPE_HTML, '', '<tr>');

								$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
									$s->addElement(ffOneElement::TYPE_HTML, '', 'Laptop (MD)');
								$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

								$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
									$s->addOptionNL( ffOneOption::TYPE_SELECT, 'boxed-wrapper-align', '', '')
										->addSelectValue( esc_attr( __('Inherit', 'ark' ) ), '')
										->addSelectValue( esc_attr( __('Center', 'ark' ) ), 'center')
										->addSelectValue( esc_attr( __('Left', 'ark' ) ), 'left')
										->addSelectValue( esc_attr( __('Right', 'ark' ) ), 'right')
									;
								$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

							$s->addElement(ffOneElement::TYPE_HTML, '', '</tr>');

						$s->endSection();

						$s->startSection( 'lg' );

							$s->addElement(ffOneElement::TYPE_HTML, '', '<tr>');

								$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
									$s->addElement(ffOneElement::TYPE_HTML, '', 'Desktop (LG)&nbsp;&nbsp;&nbsp;&nbsp;');
								$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

								$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
									$s->addOptionNL( ffOneOption::TYPE_SELECT, 'boxed-wrapper-align', '', '')
										->addSelectValue( esc_attr( __('Inherit', 'ark' ) ), '')
										->addSelectValue( esc_attr( __('Center', 'ark' ) ), 'center')
										->addSelectValue( esc_attr( __('Left', 'ark' ) ), 'left')
										->addSelectValue( esc_attr( __('Right', 'ark' ) ), 'right')
									;
								$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

							$s->addElement(ffOneElement::TYPE_HTML, '', '</tr>');

						$s->endSection();

						$s->addElement(ffOneElement::TYPE_HTML, '', '</tbody></table>');

					$s->endAdvancedToggleBox();
				$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_END );

			$s->startSection('custom-container-sizes');

				$s->addElement( ffOneElement::TYPE_TABLE_START );

					$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Boxed + Container Size', 'ark' ) ) );

						$s->addOptionNL( ffOneOption::TYPE_SELECT, 'allow-custom-container-sizes', '', '')
							->addSelectValue( esc_attr( __('Inherit from Theme Options', 'ark' ) ), '')
							->addSelectValue( esc_attr( __('Custom', 'ark' ) ), 'yes')
						;

						// $s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'NOTE: By activating this option, you will be replacing all Container settings from Theme Options with the Container settings below. But it will apply only on pages where you have this Boxed Wrapper active.');
						$sh->startHidingBox('allow-custom-container-sizes', 'yes' , false, '.top-hiding-parent');
							$s->addElement(ffOneElement::TYPE_NEW_LINE);
							$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', '<strong><span style="color: red;">NOTE: The width of the "Boxed Wrapper" is defined by the "Boxed (Full Width)" settings below.</strong>');
						$sh->endHidingBox();

					$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

				$s->addElement( ffOneElement::TYPE_TABLE_END );

				$sh->startHidingBox('allow-custom-container-sizes', 'yes' , false, '.top-hiding-parent');

					$s->addElement( ffOneElement::TYPE_TABLE_START );

						/* CONTAINER WIDTH */

						$s->startSection( 'container-width' );
							$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Container Width');
								$s->addElement(ffOneElement::TYPE_HTML, '', '<table class="ffb-box-model-table" border="0" cellpadding="0" cellspacing="0">');

								$s->addElement(ffOneElement::TYPE_HTML, '', '<tbody><tr><td></td><td>Small</td><td>Medium</td><td>Large</td><td><strong>Boxed</strong> (Full Width)</td></tr>');

								$s->startSection( 'xs' );

									$s->addElement(ffOneElement::TYPE_HTML, '', '<tr>');

										$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
											$s->addElement(ffOneElement::TYPE_HTML, '', 'Phone (XS)');
										$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

										$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
											$s->addOption( ffOneOption::TYPE_TEXT, 'small', '', '')
												->addParam('placeholder', '100%')
												->addParam('short', true);
										$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

										$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
											$s->addOption( ffOneOption::TYPE_TEXT, 'medium', '', '')
												->addParam('placeholder', '100%')
												->addParam('short', true);
										$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

										$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
											$s->addOption( ffOneOption::TYPE_TEXT, 'large', '', '')
												->addParam('placeholder', '100%')
												->addParam('short', true);
										$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

										$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
											$s->addOption( ffOneOption::TYPE_TEXT, 'fluid', '', '')
												->addParam('placeholder', '100%')
												->addParam('short', true);
										$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

									$s->addElement(ffOneElement::TYPE_HTML, '', '</tr>');

								$s->endSection();

								$s->startSection( 'sm' );

									$s->addElement(ffOneElement::TYPE_HTML, '', '<tr>');

										$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
											$s->addElement(ffOneElement::TYPE_HTML, '', 'Tablet (SM)');
										$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

										$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
											$s->addOption( ffOneOption::TYPE_TEXT, 'small', '', '')
												->addParam('placeholder', '750')
												->addParam('short', true);
										$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

										$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
											$s->addOption( ffOneOption::TYPE_TEXT, 'medium', '', '')
												->addParam('placeholder', '750')
												->addParam('short', true);
										$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

										$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
											$s->addOption( ffOneOption::TYPE_TEXT, 'large', '', '')
												->addParam('placeholder', '750')
												->addParam('short', true);
										$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

										$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
											$s->addOption( ffOneOption::TYPE_TEXT, 'fluid', '', '')
												->addParam('placeholder', 'Inherit')
												->addParam('short', true);
										$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

									$s->addElement(ffOneElement::TYPE_HTML, '', '</tr>');

								$s->endSection();

								$s->startSection( 'md' );

									$s->addElement(ffOneElement::TYPE_HTML, '', '<tr>');

										$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
											$s->addElement(ffOneElement::TYPE_HTML, '', 'Laptop (MD)');
										$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

										$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
											$s->addOption( ffOneOption::TYPE_TEXT, 'small', '', '')
												->addParam('placeholder', 'Inherit')
												->addParam('short', true);
										$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

										$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
											$s->addOption( ffOneOption::TYPE_TEXT, 'medium', '', '')
												->addParam('placeholder', '970')
												->addParam('short', true);
										$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

										$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
											$s->addOption( ffOneOption::TYPE_TEXT, 'large', '', '')
												->addParam('placeholder', '970')
												->addParam('short', true);
										$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

										$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
											$s->addOption( ffOneOption::TYPE_TEXT, 'fluid', '', '')
												->addParam('placeholder', 'Inherit')
												->addParam('short', true);
										$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

									$s->addElement(ffOneElement::TYPE_HTML, '', '</tr>');

								$s->endSection();

								$s->startSection( 'lg' );

									$s->addElement(ffOneElement::TYPE_HTML, '', '<tr>');

										$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
											$s->addElement(ffOneElement::TYPE_HTML, '', 'Desktop (LG)&nbsp;&nbsp;&nbsp;&nbsp;');
										$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

										$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
											$s->addOption( ffOneOption::TYPE_TEXT, 'small', '', '')
												->addParam('placeholder', 'Inherit')
												->addParam('short', true);
										$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

										$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
											$s->addOption( ffOneOption::TYPE_TEXT, 'medium', '', '')
												->addParam('placeholder', 'Inherit')
												->addParam('short', true);
										$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

										$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
											$s->addOption( ffOneOption::TYPE_TEXT, 'large', '', '')
												->addParam('placeholder', '1170')
												->addParam('short', true);
										$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

										$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
											$s->addOption( ffOneOption::TYPE_TEXT, 'fluid', '', '')
												->addParam('placeholder', 'Inherit')
												->addParam('short', true);
										$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

									$s->addElement(ffOneElement::TYPE_HTML, '', '</tr>');

								$s->endSection();

								$s->addElement(ffOneElement::TYPE_HTML, '', '</tbody></table>');

							$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);
						$s->endSection();

					$s->addElement( ffOneElement::TYPE_TABLE_END );

				$sh->endHidingBox();

				$sh->startHidingBox('allow-custom-container-sizes', 'yes' , false, '.top-hiding-parent');

					$s->addElement( ffOneElement::TYPE_TABLE_START );

						/* CONTAINER PADDING */

						$s->startSection( 'container-padding' );
							$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Container Padding');
								$s->addElement(ffOneElement::TYPE_HTML, '', '<table class="ffb-box-model-table" border="0" cellpadding="0" cellspacing="0">');

								$s->addElement(ffOneElement::TYPE_HTML, '', '<tbody><tr><td></td><td>Small</td><td>Medium</td><td>Large</td><td><strong>Boxed</strong> (Full Width)</td></tr>');

								$s->startSection( 'xs' );

									$s->addElement(ffOneElement::TYPE_HTML, '', '<tr>');

										$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
											$s->addElement(ffOneElement::TYPE_HTML, '', 'Phone (XS)');
										$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

										$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
											$s->addOption( ffOneOption::TYPE_TEXT, 'small', '', '')
												->addParam('placeholder', '15')
												->addParam('short', true);
										$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

										$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
											$s->addOption( ffOneOption::TYPE_TEXT, 'medium', '', '')
												->addParam('placeholder', '15')
												->addParam('short', true);
										$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

										$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
											$s->addOption( ffOneOption::TYPE_TEXT, 'large', '', '')
												->addParam('placeholder', '15')
												->addParam('short', true);
										$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

										$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
											$s->addOption( ffOneOption::TYPE_TEXT, 'fluid', '', '')
												->addParam('placeholder', '15')
												->addParam('short', true);
										$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

									$s->addElement(ffOneElement::TYPE_HTML, '', '</tr>');

								$s->endSection();

								$s->startSection( 'sm' );

									$s->addElement(ffOneElement::TYPE_HTML, '', '<tr>');

										$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
											$s->addElement(ffOneElement::TYPE_HTML, '', 'Tablet (SM)');
										$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

										$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
											$s->addOption( ffOneOption::TYPE_TEXT, 'small', '', '')
												->addParam('placeholder', 'Inherit')
												->addParam('short', true);
										$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

										$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
											$s->addOption( ffOneOption::TYPE_TEXT, 'medium', '', '')
												->addParam('placeholder', 'Inherit')
												->addParam('short', true);
										$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

										$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
											$s->addOption( ffOneOption::TYPE_TEXT, 'large', '', '')
												->addParam('placeholder', 'Inherit')
												->addParam('short', true);
										$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

										$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
											$s->addOption( ffOneOption::TYPE_TEXT, 'fluid', '', '')
												->addParam('placeholder', 'Inherit')
												->addParam('short', true);
										$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

									$s->addElement(ffOneElement::TYPE_HTML, '', '</tr>');

								$s->endSection();

								$s->startSection( 'md' );

									$s->addElement(ffOneElement::TYPE_HTML, '', '<tr>');

										$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
											$s->addElement(ffOneElement::TYPE_HTML, '', 'Laptop (MD)');
										$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

										$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
											$s->addOption( ffOneOption::TYPE_TEXT, 'small', '', '')
												->addParam('placeholder', 'Inherit')
												->addParam('short', true);
										$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

										$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
											$s->addOption( ffOneOption::TYPE_TEXT, 'medium', '', '')
												->addParam('placeholder', 'Inherit')
												->addParam('short', true);
										$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

										$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
											$s->addOption( ffOneOption::TYPE_TEXT, 'large', '', '')
												->addParam('placeholder', 'Inherit')
												->addParam('short', true);
										$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

										$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
											$s->addOption( ffOneOption::TYPE_TEXT, 'fluid', '', '')
												->addParam('placeholder', 'Inherit')
												->addParam('short', true);
										$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

									$s->addElement(ffOneElement::TYPE_HTML, '', '</tr>');

								$s->endSection();

								$s->startSection( 'lg' );

									$s->addElement(ffOneElement::TYPE_HTML, '', '<tr>');

										$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
											$s->addElement(ffOneElement::TYPE_HTML, '', 'Desktop (LG)&nbsp;&nbsp;&nbsp;&nbsp;');
										$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

										$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
											$s->addOption( ffOneOption::TYPE_TEXT, 'small', '', '')
												->addParam('placeholder', 'Inherit')
												->addParam('short', true);
										$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

										$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
											$s->addOption( ffOneOption::TYPE_TEXT, 'medium', '', '')
												->addParam('placeholder', 'Inherit')
												->addParam('short', true);
										$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

										$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
											$s->addOption( ffOneOption::TYPE_TEXT, 'large', '', '')
												->addParam('placeholder', 'Inherit')
												->addParam('short', true);
										$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

										$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
											$s->addOption( ffOneOption::TYPE_TEXT, 'fluid', '', '')
												->addParam('placeholder', 'Inherit')
												->addParam('short', true);
										$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

									$s->addElement(ffOneElement::TYPE_HTML, '', '</tr>');

								$s->endSection();

								$s->addElement(ffOneElement::TYPE_HTML, '', '</tbody></table>');

							$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);
						$s->endSection();

					$s->addElement( ffOneElement::TYPE_TABLE_END );

				$sh->endHidingBox();

			$s->endSection(); // END custom-container-sizes

		$s->addElement( ffOneElement::TYPE_HTML, '', '</div>' );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		$outerWrapper = '<div class="ark-boxed__body-wrapper"></div>';
		$innerWrapper = '<div class="ark-boxed__boxed-wrapper"></div>';

		/*----------------------------------------------------------*/
		/* OUTER WRAPPER
		/*----------------------------------------------------------*/
		$this->_advancedToggleBoxStart( $query, 'body-wrapper');
		echo $outerWrapper;
		$outerWrapper = $this->_advancedToggleBoxEnd( $query, 'body-wrapper', false);

		$outerWrapper = str_replace('fg-text-dark', '', $outerWrapper);
		$outerWrapper = str_replace('</div>', '', $outerWrapper);

		/*----------------------------------------------------------*/
		/* INNER WRAPPER
		/*----------------------------------------------------------*/
		$this->_advancedToggleBoxStart( $query, 'boxed-wrapper');
		echo $innerWrapper;
		$innerWrapper = $this->_advancedToggleBoxEnd( $query, 'boxed-wrapper', false);

		$innerWrapper = str_replace('fg-text-dark', '', $innerWrapper);
		$innerWrapper = str_replace('</div>', '', $innerWrapper);

		echo $outerWrapper;
		echo $innerWrapper;

		/*----------------------------------------------------------*/
		/* CSS OUTER WRAPPER
		/*----------------------------------------------------------*/
//		$this->_getAssetsRenderer()
//			->createCssRule(false)
//			->addSelector('.ark-boxed__body-wrapper')
//			->addParamsString('padding-left:300px;');


		/*----------------------------------------------------------*/
		/* CSS INNER WRAPPER
		/*----------------------------------------------------------*/
		$this->_renderCSSRule('margin', '0 auto', '.ark-header');
		$this->_renderCSSRule('max-width', '100%', '.ark-header');
//		$this->_renderCSSRule('max-width', '100%', '.ark-header .container');
		$this->_renderCSSRule('margin', '0 auto', '.ark-boxed__boxed-wrapper');
		$this->_renderCSSRule('max-width', '100%', '.ark-boxed__boxed-wrapper');
//		$this->_renderCSSRule('max-width', '100%', '.fg-container');


		/*
		$breakpoints_default = array(
			'xs' => null,
			'sm' => 750,
			'md' => 970,
			'lg' => 1170,
		);

		$breakpoints = array(
			'xs' => 320,
			'sm' => 768,
			'md' => 992,
			'lg' => 1200,
		);

		foreach( $breakpoints as $bp => $bp_size ){
			if( $query->get('boxed-wrapper '.$bp) ) {
				$new_width = absint( $query->get('boxed-wrapper '.$bp.'_width') );
				if( $new_width ) {
					$rule = $this->_renderCSSRule('width', $new_width.'px', '.ark-boxed__boxed-wrapper');
					$rule->addBreakpoint('min-width:' . $bp_size . 'px');
					$rule = $this->_renderCSSRule('width', $new_width.'px', '.ark-header');
					$rule->addBreakpoint('min-width:' . $bp_size . 'px');
					$rule = $this->_renderCSSRule('width', $new_width.'px', '.ark-header .container');
					$rule->addBreakpoint('min-width:' . $bp_size . 'px');
				}
			}else{
				// Use default
				$new_width = $breakpoints_default[$bp];
				if( $new_width ) {
					$rule = $this->_renderCSSRule('width', $new_width.'px', '.ark-boxed__boxed-wrapper');
					$rule->addBreakpoint('min-width:' . $bp_size . 'px');
					$rule = $this->_renderCSSRule('width', $new_width.'px', '.ark-header');
					$rule->addBreakpoint('min-width:' . $bp_size . 'px');
					$rule = $this->_renderCSSRule('width', $new_width.'px', '.ark-header .container');
					$rule->addBreakpoint('min-width:' . $bp_size . 'px');
				}
			}
		}

		*/

		// Left and Right menu
		$css = '@media (min-width: 992px){
			.ark-boxed__boxed-wrapper .header-section-scroll-container {
				margin-left: 0;
			}
			.ark-boxed__boxed-wrapper .header-section-scroll-container-right {
				margin-right: 0;
			}
			.ark-boxed__boxed-wrapper .header-vertical-container{
				margin-left: 0;
			}
			.ark-boxed__boxed-wrapper .header-vertical-container-right{
				margin-right: 0;
			}
		}
		'."\n";


		// Container Align
		$boxedFullWidthElementsSelector = ark_get_boxed_full_width_elements_selector();
							// if ( 'left' == $query->get('boxed-wrapper boxed-wrapper-align') ){
							// 	$css .= $boxedFullWidthElementsSelector.'{'."\n";
							// 		$css .= 'margin-left: 0 !important;';
							// 	$css .= '}'."\n";
							// } else if ( 'right' == $query->get('boxed-wrapper boxed-wrapper-align') ){
							// 	$css .= $boxedFullWidthElementsSelector.'{'."\n";
							// 		$css .= 'margin-right: 0 !important;';
							// 	$css .= '}'."\n";
							// }


		$bp_boxed_aligns = array(
			'xs' => array('', '', 'center'),
			'sm' => array('@media (min-width: 768px){', '}', ''),
			'md' => array('@media (min-width: 992px){', '}', ''),
			'lg' => array('@media (min-width: 1200px){', '}', '')
		);

		foreach ($bp_boxed_aligns as $bp => $bp_values) {
			$before = $bp_values[0];
			$after = $bp_values[1];
			$default = $bp_values[2];

			$align = $query->getWithoutComparationDefault('boxed-wrapper '.$bp.' boxed-wrapper-align', $default);

			if ( $align == '' ){
				continue;
			}

			$css .= $before;

				$css .= $boxedFullWidthElementsSelector.'{'."\n";			
					
					switch ($align) {
						case 'left':
							$css .= 'margin-left: 0 !important;';
							$css .= 'margin-right: auto !important;';
							break;
						case 'right':
							$css .= 'margin-left: auto !important;';
							$css .= 'margin-right: 0 !important;';
							break;
						case 'center':
							$css .= 'margin-left: auto !important;';
							$css .= 'margin-right: auto !important;';
							break;
					}

				$css .= '}'."\n";

			$css .= '/* qqqqqqqqqqq '.$align.'*/';

			$css .= $after;

		}
		
		// Render container dimensions from function via functions.php - this function is shared with Theme Options
		if ( $query->get('custom-container-sizes allow-custom-container-sizes') && function_exists('ark_get_theme_options_container_sizes') ){
			$css .= ark_get_theme_options_container_sizes( $query->get('custom-container-sizes') );
		}

		$this->_getAssetsRenderer()->createCssRule(false)->setContent( $css );
	}

	protected function _renderContentInfo_JS() {
		?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, preview ) {

				query.addDivider();

			}
		</script data-type="ffscript">
		<?php
	}


}