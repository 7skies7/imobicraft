<?php

/**
 * @link
 */

class ffElEmbeddedCode extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'embeddedCode');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Embed Code', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'basic');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'embed, embedded, code, youtube, video, vimeo, vine, viddler, kickstarter, wistia, instagram, facebook, twitter, social, video');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 0);

		$this->_setData( ffThemeBuilderElement::DATA_HAS_SYSTEM_TABS, false );
	}


	protected function _getElementGeneralOptions( $s ) {
		$s->addElement( ffOneElement::TYPE_TABLE_START );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Note', 'ark' ) ) );
				$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', ark_wp_kses( __('Here you can insert your Embed Codes, for example YouTube video embed code would look like this: <br> <code>&lt;iframe width=&quot;560&quot; height=&quot;315&quot; src=&quot;https://www.youtube.com/embed/J7ArPgBRR94&quot; frameborder=&quot;0&quot; allowfullscreen&gt;&lt;/iframe&gt;</code>', 'ark' ) ) );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );
				$s->addOptionNL(ffOneOption::TYPE_TEXTAREA_STRICT,'iframe','','');
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Aspect Ratio', 'ark' ) ) );
				$s->addOptionNL(ffOneOption::TYPE_TEXT,'width', '', 16)
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Width', 'ark' ) ) );
				$s->addOptionNL(ffOneOption::TYPE_TEXT,'height', '', 9)
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Height', 'ark' ) ) );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);
		 $s->addElement( ffOneElement::TYPE_TABLE_END );
	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {


		$featured_video = $query->get('iframe');
		$height = absint( $query->get('height') );
		$width = absint( $query->get('width') );
		if( 0 == $width ){
			$width = 100;
		}

		if( !empty($featured_video) ) {

			echo '<div class="embed-video-external">';

			$ratio = 0.01 * absint(10000 * $height / $width);

			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .embed-responsive', false)
				->addParamsString('padding-bottom:' . $ratio . '%;');

			$div = '<div class="embed-responsive">';

			$featured_video = str_replace('<ifr' . 'ame ', $div . '<ifr' . 'ame' . "\t" . 'class="embed-responsive-item" ', $featured_video);
			$featured_video = str_replace('<embed ', $div . '<embed' . "\t" . 'class="embed-responsive-item" ', $featured_video);

			$featured_video = str_replace('</iframe>', '</iframe></div>', $featured_video);
			$featured_video = str_replace('</embed>', '</embed></div>', $featured_video);

			// Wrapped emeded iframe / video
			echo ( $featured_video );

			echo '</div>';
		}
	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementInfo, $element, blocks, preview, view ) {
				query.addHeadingLg( 'iframe' );
			}
		</script data-type="ffscript">
	<?php
	}


}