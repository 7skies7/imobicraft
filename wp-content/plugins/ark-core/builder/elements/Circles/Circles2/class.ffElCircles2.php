<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_piecharts.html#scrollTo__674
 * @link http://demo.freshface.net/html/h-ark/HTML/page_services_creative.html#scrollTo__1208
 */

class ffElCircles2 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'circles-2');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Circles 2', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'counter');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'circle, piechart, counter');

		$this->_setColor('dark');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );

				$s->startRepVariableSection('content');

					/*----------------------------------------------------------*/
					/* TYPE CHART
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('circle', ark_wp_kses( __('Circle', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'value', '', '72')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Value', 'ark' ) ) )
						;
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'unit', '', '%')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Unit', 'ark' ) ) )
						;
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'chart1-color', '', 'rgba(0, 188, 212, 0.6)')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background Circle Color', 'ark' ) ) )
						;
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'chart2-color', '', '[1]')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Foreground Circle Color', 'ark' ) ) )
						;
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'text-color', '', '#fff')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text Color', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE TITLE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('title', ark_wp_kses( __('Title', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Wordpress')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) );
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE DESCRIPTION
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('description', ark_wp_kses( __('Paragraph', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.')
							->addParam('print-in-content', true);
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE BUTTON
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('button', ark_wp_kses( __('Buttons', 'ark' ) ) );
						$this->_getBlock( ffThemeBlConst::BUTTON )->injectOptions( $s );
					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content Alignment', 'ark' ) ) );
				$s->addOption( ffOneOption::TYPE_SELECT, 'items-alignment', '', 'text-center')
					->addSelectValue( esc_attr( __('Left', 'ark' ) ), 'text-left')
					->addSelectValue( esc_attr( __('Center', 'ark' ) ), 'text-center')
					->addSelectValue( esc_attr( __('Right', 'ark' ) ), 'text-right');
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _enqueueScriptsAndStyles( $query ) {
		wp_enqueue_script( 'ark-pie-charts' );
	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		if( ! $query->exists('content') ) {
			return;
		}

		echo '<section class="piechart-v2 '. $query->getEscAttr('items-alignment') .'">';

			foreach( $query->get('content') as $oneItem ) {
				switch ($oneItem->getVariationType()) {

					case 'circle':



						echo '<div class="circle-v2-wrapper">';
							echo '<figure class="circle-v2 ff-piechart"
								data-chart-type=2
								data-value="'.$oneItem->getWpKses('value').'"
								data-unit="'.$oneItem->getWpKses('unit').'"
								data-color-1="'.$oneItem->getColor('chart1-color').'"
								data-color-2="'.$oneItem->getColor('chart2-color').'"
								data-text-color="'.$oneItem->getColor('text-color').'">
							</figure>';
						echo '</div>';
						break;

					case 'title':
						echo '<h3 class="piechart-v2-title">'. $oneItem->getWpKses('text') .'</h3>';
						break;

					case 'description':
						$oneItem->printWpKsesTextarea('text', '<p class="piechart-v2-text">', '</p>', '<div class="piechart-v2-text ff-richtext">', '</div>');
						break;

					case 'button':
						echo '<div class="piechart-v2-buttons-wrapper" ';
						echo '>';
							$this->_getBlock( ffThemeBlConst::BUTTON )->render( $oneItem );
						echo '</div>';
						break;

				}
			}

		echo '</section>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $slementPreview, $slement, blocks ) {

				if(query.queryExists('content')) {
					query.get('content').each(function(query, variationType ){
						switch(variationType){
							case 'circle':
								var value = query.get('value');
								var unit = query.get('unit');
								query.addHeadingLg(null, value, unit);
								break;
							case 'title':
								query.addHeadingLg('text');
								break;
							case 'description':
								query.addHeadingSm('text');
								break;
							case 'button':
								blocks.render('button', query);
								break;

						}
					});
				}
				

			}
		</script data-type="ffscript">
	<?php
	}


}