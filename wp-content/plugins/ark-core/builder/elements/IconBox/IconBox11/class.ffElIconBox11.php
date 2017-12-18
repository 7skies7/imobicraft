<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/page_team_members.html#scrollTo__4800
 */

class ffElIconBox11 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'iconbox-11');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Icon Box 11', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'icon-box');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'icon, icon box');

		$this->_setColor('dark');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Image', 'ark' ) ) );

				$s->startAdvancedToggleBox('one-image', esc_attr( __('Image', 'ark' ) ) );

					$this->_getBlock( ffThemeBlConst::IMAGE )
						->imgIsResponsive()
						->imgIsFullWidth()
						->setParam('width', 698)
						->injectOptions( $s );

				$s->endAdvancedToggleBox();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Image Link', 'ark' ) ) );
				$this->_getBlock( ffThemeBuilderBlock::LINK)->injectOptions( $s );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Icon', 'ark' ) ) );

				$s->startAdvancedToggleBox('one-icon', esc_attr( __('Icon', 'ark' ) ) );

					$s->addOptionNL( ffOneOption::TYPE_ICON, 'icon', ark_wp_kses( __('Icon', 'ark' ) ), 'ff-font-awesome4 icon-plus')
						->addParam('print-in-content', true)
					;

				$s->endAdvancedToggleBox();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Horizontal Alignment', 'ark' ) ) );
				$s->addOption(ffOneOption::TYPE_SELECT, 'align', '', 'text-right')
					->addSelectValue('Left','text-left')
					->addSelectValue('Center','text-center')
					->addSelectValue('Right','text-right')
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Vertical Alignment', 'ark' ) ) );
				$s->addOption(ffOneOption::TYPE_SELECT, 'vert-align', '', 'vert-bottom')
					->addSelectValue('Top','vert-top')
					->addSelectValue('Middle','vert-middle')
					->addSelectValue('Bottom','vert-bottom')
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Icon Colors', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-color', '', 'rgba(255,255,255,0.5)')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Color', 'ark' ) ) )
				;
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-hover-color', '', '#ffffff')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Hover Color', 'ark' ) ) )
				;
				$s->addElement(ffOneElement::TYPE_NEW_LINE);
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-color', '', 'rgba(255,255,255,0.5)')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Border Color', 'ark' ) ) )
				;
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-hover-color', '', '#ffffff')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Border Hover Color', 'ark' ) ) )
				;
				$s->addElement(ffOneElement::TYPE_NEW_LINE);
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background Color', 'ark' ) ) )
				;
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-hover-color', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background Hover Color', 'ark' ) ) )
				;

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _renderColor( $query ) {
		if( $query->getColor('icon-color') ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector('.icon-box-v11-img-wrap .icon-box-v11-icon')
				->addParamsString('color: '. $query->getColor('icon-color') .';');
		}

		if( $query->getColor('icon-hover-color') ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector('.icon-box-v11-img-wrap:hover .icon-box-v11-icon')
				->addParamsString('color: '. $query->getColor('icon-hover-color') .';');
		}
		if( $query->getColor('border-color') ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector('.icon-box-v11-img-wrap .icon-box-v11-icon')
				->addParamsString('border-color: '. $query->getColor('border-color') .';');
		}

		if( $query->getColor('border-hover-color') ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector('.icon-box-v11-img-wrap:hover .icon-box-v11-icon')
				->addParamsString('border-color: '. $query->getColor('border-hover-color') .';');
		}

		if( $query->getColor('bg-color') ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector('.icon-box-v11-img-wrap .icon-box-v11-icon')
				->addParamsString('background-color: '. $query->getColor('bg-color') .';');
		}

		if( $query->getColor('bg-hover-color') ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector('.icon-box-v11-img-wrap:hover .icon-box-v11-icon')
				->addParamsString('background-color: '. $query->getColor('bg-hover-color') .';');
		}
	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		ffElIconBox11::_renderColor( $query );

		echo '<section class="icon-box-v11">';
			echo '<a ';
				$this->_getBlock( ffThemeBuilderBlock::LINK )->setParam('classes', 'icon-box-v11-img-wrap')->render( $query );
			echo '>';

				$this->_advancedToggleBoxStart( $query->get('one-image') );

					$this->_getBlock( ffThemeBlConst::IMAGE )
						->imgIsResponsive()
						->imgIsFullWidth()
						->setParam('width', 698)
						->render( $query->get('one-image') );

				$this->_advancedToggleBoxEnd( $query->get('one-image') );

				echo '<ul class="list-inline icon-box-v11-overlay-content ul-li-lr-2 '. $query->getEscAttr('align') .' '. $query->getEscAttr('vert-align') .'">';

					$this->_advancedToggleBoxStart( $query->get('one-icon') );

						echo '<i class="icon-box-v11-icon '. $query->getEscAttr('one-icon icon') .'"></i>';

					$this->_advancedToggleBoxEnd( $query->get('one-icon') );

				echo '</ul>';

			echo '</a>';
		echo '</section>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks, preview ) {

				blocks.render('image', query.get('one-image'));
				query.get('one-icon').addIcon('icon');

			}
		</script data-type="ffscript">
	<?php
	}


}