<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_piecharts.html#scrollTo__674
 */

class ffElCircles1 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'circles-1');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Circles 1', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'counter');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'circle, piechart, counter');

		$this->_setColor('dark');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Circle', 'ark' ) ) );
				$s->startAdvancedToggleBox('pie-chart', esc_attr( __('Circle', 'ark' ) ) )
					//@todo1 ->addParam('is-opened', true)
				;
					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'value', '', '55')
						->addParam('print-in-content', true)
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Value', 'ark' ) ) )
					;
					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'unit', '', '%')
						->addParam('print-in-content', true)
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Unit', 'ark' ) ) )
					;
					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'chart1-color', '', '#ffffff')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background Circle Color', 'ark' ) ) )
					;
					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'chart2-color', '', '[1]')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Foreground Circle Color', 'ark' ) ) )
					;
				$s->endAdvancedToggleBox();
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );

				$s->startRepVariableSection('content');

					/* TYPE TITLE */
					$s->startRepVariationSection('title', ark_wp_kses( __('Title', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Wordpress')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/* TYPE SUBTITLE */
					$s->startRepVariationSection('subtitle', ark_wp_kses( __('Subtitle', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Development')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/* TYPE DESCRIPTION */
					$s->startRepVariationSection('description', ark_wp_kses( __('Paragraph', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.')
							->addParam('print-in-content', true)
						;
					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content Alignment', 'ark' ) ) );
				$s->addOption( ffOneOption::TYPE_SELECT, 'align', '', 'text-left')
					->addSelectValue( esc_attr( __('Left', 'ark' ) ), 'text-left')
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



		echo '<section class="piechart-v1 '. $query->getEscAttr('align') .'">';
		
			$this->_advancedToggleBoxStart( $query->get('pie-chart') );
				echo '<div class="piechart-v1-wrap">';
					echo '<figure class="circle ff-piechart"
					data-chart-type=1
					data-value="'.$query->getWpKses('pie-chart value').'"
					data-unit="'.$query->getWpKses('pie-chart unit').'"
					data-color-1="'.$query->getColor('pie-chart chart1-color').'"
					data-color-2="'.$query->getColor('pie-chart chart2-color').'">
					</figure>';
				echo '</div>';
			$this->_advancedToggleBoxEnd( $query->get('pie-chart') );

			if( $query->exists('content') ) {
				echo '<div class="piechart-v1-body">';
					foreach( $query->get('content') as $oneItem ) {
						switch ($oneItem->getVariationType()) {

							case 'title':
								echo '<h3 class="piechart-v1-body-title">'. $oneItem->getWpKses('text') .'</h3>';
								break;

							case 'subtitle':
								echo '<span class="piechart-v1-body-subtitle">'. $oneItem->getWpKses('text') .'</span>';
								break;

							case 'description':
								$oneItem->printWpKsesTextarea('text', '<p>', '</p>', '<div class="ff-richtext">', '</div>');
								break;

						}
					}
				echo '</div>';
			}

		echo '</section>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $slementPreview, $slement ) {

				var value = query.get('pie-chart value');
				var unit = query.get('pie-chart unit');
				query.addHeadingLg(null, value, unit);

				if(query.queryExists('content')) {
					query.get('content').each(function (query, variationType) {
						switch (variationType) {
							case 'title':
								query.addHeadingLg('text');
								break;
							case 'subtitle':
								query.addHeadingSm('text');
								break;
							case 'description':
								query.addText('text');
								break;

						}
					});
				}

			}
		</script data-type="ffscript">
	<?php
	}


}