<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/page_about_us_classic.html#scrollTo__1100
 */

class ffElIconBox10 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'iconbox-10');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Icon Box 10', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'icon-box');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'icon, icon box');

		$this->_setColor('dark');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );

				$s->startRepVariableSection('content');

					/*----------------------------------------------------------*/
					/* TYPE IMAGE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('image', ark_wp_kses( __('Image', 'ark' ) ) );
						$this->_getBlock( ffThemeBlConst::IMAGE )->imgIsResponsive()->injectOptions( $s );
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE TITLE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('title', ark_wp_kses( __('Title', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Stunning design')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) );
					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE DESCRIPTION
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('description', ark_wp_kses( __('Paragraph', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', 'Lorem ipsum dolor sit amet, consectetur eturadipis cingelit. Mauris mollis tempus dui, nec bibendum augue faucibus quis.')
							->addParam('print-in-content', true);
					$s->endRepVariationSection(); 

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Icon Box Settings', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'content-align', '', 'text-left')
					->addSelectValue( esc_attr( __('Left', 'ark' ) ), 'text-left')
					->addSelectValue( esc_attr( __('Center', 'ark' ) ), 'text-center')
					->addSelectValue( esc_attr( __('Right', 'ark' ) ), 'text-right')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text align', 'ark' ) ) )
				;

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Box Link', 'ark' ) ) );
				$this->_getBlock( ffThemeBuilderBlock::LINK)->injectOptions( $s );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		if( ! $query->exists('content') ) {
			return;
		}

		echo '<section class="icon-box-v4 '. $query->getEscAttr('content-align') .'">';

			foreach( $query->get('content') as $oneLine ) {
				switch( $oneLine->getVariationType() ) {

					case 'image':
						echo '<div class="icon-box-v4-image">';
						$this->_getBlock( ffThemeBlConst::IMAGE )->imgIsResponsive()->render( $oneLine );
						echo '</div>';
						break;

					case 'title':
						echo '<h3 class="icon-box-v4-body-title">'. $oneLine->getWpKses('text') .'</h3>';
						break;

					case 'description':
						$oneLine->printWpKsesTextarea( 'text', '<p class="icon-box-v4-body-text">', '</p>', '<div class="icon-box-v4-body-text ff-richtext">', '</div>' );
						break;

				}
			}

			if( $this->_getBlock( ffThemeBuilderBlock::LINK )->urlHasBeenFilled( $query ) ) {
				echo '<a ';
					$this->_getBlock( ffThemeBuilderBlock::LINK )->setParam('classes', 'icon-box-v4-link')->render( $query );
				echo '></a>';
			}

		echo '</section>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks, preview ) {

				if(query.queryExists('content')) {
					query.get('content').each(function (query, variationType) {
						switch (variationType) {
							case 'image':
								blocks.render('image', query);
								break;
							case 'title':
								query.addHeadingLg('text');
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