<?php

class ffElACF extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'acf');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Advanced Custom Field', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);
		$this->_setData( ffThemeBuilderElement::DATA_CAN_BE_CACHED, false);
		
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'acf');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'acf, advanced, custom, field');

		$this->_setColor('dark');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Info', 'ark' ) ));
				$s->addElement(ffOneElement::TYPE_HTML, 'TYPE_HTML', '<p class="description">'.
					ark_wp_kses( __('Please note that if you wish to use this element, you need to have installed and activated <a href="https://wordpress.org/plugins/advanced-custom-fields/" target="_blank">Advanced Custom Fields</a> plugin or <a href="https://www.advancedcustomfields.com/pro/" target="_blank">Advanced Custom Fields PRO</a> plugin.', 'ark') )
					.'</p>');
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Advanced Custom Fields', 'ark' ) ) );

				$s->addElement( ffOneElement::TYPE_HTML, '', '<div class="ff-acf-select-holder">');
					$acf_group = $s->addOptionNL( ffOneOption::TYPE_SELECT, 'group', 'ACF Group ', '');
					$acf_group->addSelectValue( '--- Select Group ---', '' );
//					$acf_group->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('ACF Group', 'ark' ) ) );
					$acf_group->addParam( 'class', 'ff-opt-acf-group-type');

					$acf_field = $s->addOptionNL( ffOneOption::TYPE_SELECT, 'field', 'ACF Field ', '');
					$acf_field->addSelectValue( '--- Select Field ---', '' );
					$acf_field->addParam( 'class', 'ff-opt-acf-field-type');
				$s->addElement( ffOneElement::TYPE_HTML, '', '</div>');

//				$acf_field->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('ACF Field', 'ark' ) ) );

				$acf_output = $s->addOptionNL( ffOneOption::TYPE_SELECT, 'output', 'ACF Output Type ', '');
				$acf_output->addSelectValue( 'Text and AFC default output', 'text' );
				$acf_output->addSelectValue( 'Text with WP filters', 'tinymce' );
				$acf_output->addSelectValue( 'Image', 'image' );
				$acf_output->addSelectValue( 'oEmbed, Video', 'video' );
				$acf_output->addSelectValue( 'File, URL', 'file' );
				$acf_output->addSelectValue( 'PHP', 'php' );
//				$acf_output->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('ACF Output type', 'ark' ) ) );


				$s->startHidingBox('output', 'video');
					$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', ark_wp_kses( __('You can view the list of all compatible video platforms <a href="//codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F" target="_blank">here</a>.', 'ark' ) ) );

					$s->addOptionNL(ffOneOption::TYPE_TEXT,'video-width', '', 16)
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Aspect Ratio Width', 'ark' ) ) );
					$s->addOptionNL(ffOneOption::TYPE_TEXT,'video-height', '', 9)
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Aspect Ratio Height', 'ark' ) ) );
				$s->endHidingBox();

				$s->startHidingBox('output', 'file');
					$s->addOptionNL( ffOneOption::TYPE_SELECT, 'file-format-output', '', '')
						->addSelectValue( 'Text', '' )
						->addSelectValue( 'Icon', 'icon' )
						->addSelectValue( 'Custom', 'custom' )
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('File Field Design', 'ark' ) ) );

					$s->startHidingBox('file-format-output', '');
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'file-format-text', '', 'Download' )
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Link text', 'ark' ) ) );
					$s->endHidingBox();

					$s->startHidingBox('file-format-output', 'icon');
						$s->addOptionNL( ffOneOption::TYPE_ICON, 'file-format-icon', 'Icon', 'ff-font-awesome4 icon-file-o' );
					$s->endHidingBox();

					$s->startHidingBox('file-format-output', 'custom');
						$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', ark_wp_kses( __('You can mark the file link with <strong>%1$s</strong> sting.', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXTAREA_STRICT, 'file-format-custom', '', '<a href="%1$s"><i class="ff-font-awesome4 icon-file-o"></i> &nbsp Documentation</a>' );
					$s->endHidingBox();

				$s->endHidingBox();

				$s->startHidingBox('output', 'php');
					$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', ark_wp_kses( __('You can mark the field name with <strong>$acf_field</strong> sting.', 'ark' ) ) );
					$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', ark_wp_kses( __('IMPORTANT: All settings from the system tabs (Box Model, Typography, etc.), will be applied only if your HTML element has a wrapping element. You may encounter errors if you attempt to apply settings from system tabs on your HTML element without having any wrapping element.', 'ark' ) ) );
					$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', ark_wp_kses( __('You can insert your HTML code below. But if you enable the PHP Mode, then you must write in PHP syntax only.', 'ark' ) ) );

					$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', ark_wp_kses( __('This code is executed before, so you have access to variables $acfFieldName and $acfFieldContent', 'ark' ) ) );
					$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', ark_wp_kses( __('<code>$acfFieldContent = get_field($acfFieldName);</code>', 'ark' ) ) );
					$s->addOptionNL( ffOneOption::TYPE_TEXTAREA_STRICT, 'php-code', '', "echo \$acfFieldContent;" )
						->addParam( ffOneOption::PARAM_CODE_EDITOR, 'php')
					;

				$s->endHidingBox();


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Wrapping', 'ark' ) ) );

				$s->addOption( ffOneOption::TYPE_SELECT, 'wrapper', '', 'div')
					->addSelectValue('None', '')
					->addSelectValue('div', 'div')
					->addSelectValue('span', 'span')
					->addSelectValue('p', 'p')
					->addSelectValue('Custom', 'custom')
					->addParam(ffOneOption::PARAM_TITLE_AFTER, 'Wrapping HTML Tag');
				;

				$s->addElement(ffOneElement::TYPE_DESCRIPTION, '', 'IMPORTANT: All settings from the system tabs (Box Model, Typography, etc.), will be applied only if your HTML element has a wrapping element. You may encounter errors if you attempt to apply settings from system tabs on your HTML element without having any wrapping element.');

				$s->startHidingBox('wrapper', 'custom');
				$s->addOption( ffOneOption::TYPE_TEXT, 'wrapper-element', '', '')
					->addParam(ffOneOption::PARAM_TITLE_AFTER, 'Custom wrapping element tag, example: <code>div</code>');
				$s->endHidingBox();

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOption( ffOneOption::TYPE_CHECKBOX, 'add-html-before', 'Add HTML Code inside Wrapping HTML tag and BEFORE custom Field', '');
				$s->startHidingBox('add-html-before', 'checked');
					$s->addOptionNL( ffOneOption::TYPE_TEXTAREA_STRICT, 'html-before', '', '' );
				$s->endHidingBox();
				$s->addElement(ffOneElement::TYPE_NEW_LINE);
				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOption( ffOneOption::TYPE_CHECKBOX, 'add-html-after', 'Add HTML Code inside Wrapping HTML tag and AFTER custom Field', '');
				$s->startHidingBox('add-html-after', 'checked');
					$s->addOptionNL( ffOneOption::TYPE_TEXTAREA_STRICT, 'html-after', '', '' );
				$s->endHidingBox();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		$s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _renderCSS( ffOptionsQueryDynamic $query ) {

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		$acf_field = $query->get('field');
		$acf_group = $query->get('group');
		$acf_output = $query->get('output');

		if( empty($acf_field) ){
			return;
		}

		if( empty($acf_group) ){
			return;
		}


		$wrapper = $query->getWithoutComparationDefault('wrapper', '');

		if( $wrapper == 'custom' ) {
			$wrapper = $query->getWithoutComparationDefault('wrapper-element', '');
		}

		if( !empty( $wrapper ) ) {
			echo '<' . $wrapper . '>';
		}

		if( $query->getWithoutComparationDefault('add-html-before', '') ){
			echo $query->getWithoutComparationDefault('html-before', '');
		}

		switch ( $acf_output ) {
			case 'text':
				echo get_field( $acf_field );
				break;
			case 'tinymce':
				echo do_shortcode( get_field( $acf_field ) );
				break;
			case 'image':
				$acf_image = get_field( $acf_field );
				$acf_image_alt = '';
				if( is_array( $acf_image ) ){
					if( ! empty( $acf_image['url'] ) ){
						$acf_image = $acf_image['url'];
					}
					if( ! empty( $acf_image['alt'] ) ){
						$acf_image_alt = $acf_image['alt'];
					}
				}
				if( ! is_string( $acf_image ) ){
					break;
				}

				echo '<img src="'.esc_url( $acf_image ).'" alt="'.strip_tags($acf_image_alt).'" class="img-responsive">';
				break;
			case 'video':
				$acf_video = get_field( $acf_field );

				if( ( FALSE === strpos($acf_video, '<ifr' . 'ame') ) and ( FALSE === strpos($acf_video, '<embed') ) ){
					$acf_video = wp_oembed_get( $acf_video );
				}


				if( !empty($acf_video) ) {

					$video_width =  abs( floatval( $query->getWpKses('video-width')  ) );
					$video_height = abs( floatval( $query->getWpKses('video-height') ) );

					if( 0 == $video_width ){
						$ratio = 56.25;
					} else {
						$ratio = 0.01 * absint(10000 * $video_height / $video_width );
					}

					$this->getAssetsRenderer()->createCssRule()
						->setAddWhiteSpaceBetweenSelectors(false)
						->addSelector(' .embed-responsive', false)
						->addParamsString('padding-bottom:' . $ratio . '%;');

					echo '<div class="embed-video-external">';

					$div = '<div class="embed-responsive">';

					$acf_video = str_replace('<ifr' . 'ame ', $div . '<ifr' . 'ame' . "\t" . 'class="embed-responsive-item" ', $acf_video);
					$acf_video = str_replace('<embed ', $div . '<embed' . "\t" . 'class="embed-responsive-item" ', $acf_video);

					$acf_video = str_replace('</iframe>', '</iframe></div>', $acf_video);
					$acf_video = str_replace('</embed>', '</embed></div>', $acf_video);

					echo ( $acf_video );

					echo '</div>';

				}
				break;
			case 'file':

				$acf_file = get_field( $acf_field );

				if( is_array($acf_file) ){
					if( !empty( $acf_file[ 'url' ] ) ){
						$acf_file = $acf_file[ 'url' ];
					}
				}

				if( is_array( $acf_file ) or is_object( $acf_file ) ){
					break;
				}

				$file_format_output = $query->get('file-format-output');

				if( '' == $file_format_output ){
					// $s->addOptionNL( ffOneOption::TYPE_TEXT, 'file-format-text', '', 'Download' )
					echo '<a href="'.$acf_file.'">';
					echo $query->get('file-format-text');
					echo '</a>';
				}else if( 'icon' == $file_format_output ){
					echo '<a href="'.$acf_file.'">';
					echo '<i class="' . $query->get('file-format-icon') . '"></i>';
					echo '</a>';
				}else if( 'custom' == $file_format_output ){
					printf( $query->get('file-format-custom'), $acf_file );
				}

				break;
			case 'php':
				$acfFieldName = $acf_field;
				$acfFieldContent = get_field( $acfFieldName );
				eval( $query->get('php-code') );
				break;
		}

		if( $query->getWithoutComparationDefault('add-html-after', '') ){
			echo $query->getWithoutComparationDefault('html-after', '');
		}

		if( !empty( $wrapper ) ) {
			echo '</' . $wrapper . '>';
		}

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, preview ) {
				query.addText('output');
				query.addText('field');
			}
		</script data-type="ffscript">
	<?php
	}
}