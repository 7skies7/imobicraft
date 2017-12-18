<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/index_landing_2.html#scrollTo__2223
 */

class ffElIconBox5 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'iconbox-5');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Icon Box 5', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'icon-box');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'icon, icon box');

		$this->_setColor('dark');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Image', 'ark' ) ) );
				$this->_getBlock( ffThemeBlConst::IMAGE )->injectOptions( $s );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );

				$s->startRepVariableSection('repeated-lines');

					/* TYPE OF FILE */
					$s->startRepVariationSection('file-extension', ark_wp_kses( __('Sub Title', 'ark' ) ));
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'PDF')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) );
					$s->endRepVariationSection();

					/* TYPE TITLE */
					$s->startRepVariationSection('title', ark_wp_kses( __('Title', 'ark' ) ));
						$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', 'The Startup\'s guide to Design')
							->addParam('print-in-content', true);
					$s->endRepVariationSection();

					/* TYPE LINK */
					$s->startRepVariationSection('link', ark_wp_kses( __('Link', 'ark' ) ));
						$s->addOptionNL( ffOneOption::TYPE_ICON, 'icon', ark_wp_kses( __('Icon', 'ark' ) ), 'ff-font-awesome4 icon-angle-right')
							->addParam('print-in-content', true);

						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Download')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) );

						$this->_getBlock( ffThemeBuilderBlock::LINK )->injectOptions( $s );
					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content Alignment', 'ark' ) ) );
				$s->addOption( ffOneOption::TYPE_SELECT, 'align', '', '')
					->addSelectValue( esc_attr( __('Left', 'ark' ) ), '')
					->addSelectValue( esc_attr( __('Center', 'ark' ) ), 'center')
					->addSelectValue( esc_attr( __('Right', 'ark' ) ), 'right')
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		$this->_renderCSSRule( 'text-align', $query->getColor( 'align' ), '.icon-box-v5-content' );

		echo '<section class="icon-box-v5">';

			echo '<div class="icon-box-v5-media">';
				$this->_getBlock( ffThemeBlConst::IMAGE )->setParam('css-class', 'icon-box-v5-icon')->render( $query );
			echo '</div>';

			if( $query->exists('repeated-lines') ) {

				echo '<div class="icon-box-v5-content">';

					foreach( $query->get('repeated-lines') as $oneItem ) {
						switch ($oneItem->getVariationType()) {

							case 'file-extension':
								echo '<span class="icon-box-v5-subtitle">'. $oneItem->getWpKses('text') .'</span>';
								break;

							case 'title':
								echo '<h3 class="icon-box-v5-title">'. $oneItem->getWpKses('text') .'</h3>';
								break;

							case 'link':
								echo '<a ';
									$this->_getBlock( ffThemeBuilderBlock::LINK )->setParam('classes', 'icon-box-v5-link')->render( $oneItem );
								echo '>';
								$oneItem->printWpKses('text');
								echo '&nbsp;<i class="'. $oneItem->getEscAttr('icon') .'"></i></a>';
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
			function ( query, options, $elementPreview, $element, blocks, preview ) {

				blocks.render('image', query);

				if(query.queryExists('repeated-lines')) {
					query.get('repeated-lines').each(function (query, variationType) {
						switch (variationType) {
							case 'file-extension':
								query.addHeadingSm('text');
								break;
							case 'title':
								query.addHeadingLg('text');
								break;
							case 'link':
								query.addLink('text');
								break;
						}
					});
				}

			}
		</script data-type="ffscript">
	<?php
	}


}