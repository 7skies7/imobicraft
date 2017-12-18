<?php

/**
 * @link
 */

class ffElVideo extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'video');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Video', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'basic');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'video, mp4, wemb, ogg, embedded video, embed, youtube, vimeo, spotify, ted, vine, kickstarter, instagram');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 0);

		$this->_setColor('dark');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );

				$s->startRepVariableSection('content')
					->addParam('can-be-empty', true)
				;

					/*----------------------------------------------------------*/
					/* TYPE EXTERNAL VIDEO
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('external', ark_wp_kses( __('External Video', 'ark' ) ))
						->addParam('hide-default', true)
					;

						$s->addOptionNL(ffOneOption::TYPE_TEXT,'url','','')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('External Video Link URL', 'ark' ) ) )
						;
						$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', ark_wp_kses( __('You can view the list of all compatible video platforms <a href="//codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F" target="_blank">here</a>.', 'ark' ) ) );

						$s->addOptionNL(ffOneOption::TYPE_TEXT,'width', '', 16)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Aspect Ratio Width', 'ark' ) ) );
						$s->addOptionNL(ffOneOption::TYPE_TEXT,'height', '', 9)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Aspect Ratio Height', 'ark' ) ) );

					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE LOCAL VIDEO FILE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('local', ark_wp_kses( __('Local Video File', 'ark' ) ))
						->addParam('hide-default', true)
					;

						$s->addOptionNL(ffOneOption::TYPE_TEXT,'url-mp4','','')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Local Video File URL (.mp4)', 'ark' ) ) )
						;

						$s->addOptionNL(ffOneOption::TYPE_TEXT,'url-webm','','')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Local Video File URL (.webm)', 'ark' ) ) )
						;

						$s->addOptionNL(ffOneOption::TYPE_TEXT,'url-ogg','','')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Local Video File URL (.ogg)', 'ark' ) ) )
						;
						$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', ark_wp_kses( __('You can input more than 1 video file format (up to 3) to support wider range of devices and their web browsers.', 'ark' ) ) );

						$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'show-controls', ark_wp_kses( __('Show controls', 'ark' ) ), 1);
						$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'has-autoplay', ark_wp_kses( __('Auto-play video', 'ark' ) ), 0);
						$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'has-loop', ark_wp_kses( __('Loop video', 'ark' ) ), 0);
						$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'is-muted', ark_wp_kses( __('Mute audio', 'ark' ) ), 0);

					$s->endRepVariationSection();

				$s->endRepVariableSection();

				// Do not delete, any Element needs to have at least one (hidden) option
				$s->addElement( ffOneElement::TYPE_HTML, '', '<div class="hidden">' );
					$s->addOption( ffOneOption::TYPE_TEXT, 'blank', 'blank');
				$s->addElement( ffOneElement::TYPE_HTML, '', '</div>' );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		if( ! $query->exists('content') ) {
			return;
		}

		echo '<div class="fg-video">';

			foreach( $query->get('content') as $key=> $oneLine ) {
				switch( $oneLine->getVariationType() ) {

					case 'external':

						$featured_video = wp_oembed_get($oneLine->getEscUrl('url'));

						if( !empty($featured_video) ) {

							echo '<div class="embed-video-external">';

								$ratio = 0.01 * absint(10000 * $oneLine->getWpKses('height') / $oneLine->getWpKses('width'));

								$this->getAssetsRenderer()->createCssRule()
									->setAddWhiteSpaceBetweenSelectors(false)
									->addSelector(' .embed-responsive', false)
									->addParamsString('padding-bottom:' . $ratio . '%;');

								$div = '<div class="embed-responsive">';
							
								$featured_video = str_replace('<ifr' . 'ame ', $div . '<ifr' . 'ame' . "\t" . 'class="embed-responsive-item" ', $featured_video);
								$featured_video = str_replace('<embed ', $div . '<embed' . "\t" . 'class="embed-responsive-item" ', $featured_video);

								$featured_video = str_replace('</iframe>', '</iframe></div>', $featured_video);
								$featured_video = str_replace('</embed>', '</embed></div>', $featured_video);

								// Wrapped result from wp_oembed_get() function
								echo ( $featured_video );

							echo '</div>';

						}

						break;

					case 'local':

						$url_mp4 = $oneLine->getEscUrl('url-mp4');
						$url_webm = $oneLine->getEscUrl('url-webm');
						$url_ogg = $oneLine->getEscUrl('url-ogg');

						if ( !empty($url_mp4) || !empty($url_webm) || !empty($url_ogg) ){

							echo '<div class="embed-video-local">';

								$parameters = array();

								if( $oneLine->get('has-autoplay') ){
									$parameters[] = 'autoplay ';
								}

								if( $oneLine->get('is-muted') ){
									$parameters[] = 'muted ';
								}

								if( $oneLine->get('has-loop') ){
									$parameters[] = 'loop ';
								}

								if( $oneLine->get('show-controls') ){
									$parameters[] = 'controls';
								}

								$parameters = implode(' ', $parameters);

								echo '<video '. $parameters .' style="display:block;width:100%;height:auto;">';
									if( $oneLine->get('url-mp4') ){
										echo '<source type="video/mp4" src="'. $oneLine->getWpKses('url-mp4') .'"></source>';
									}
									if( $oneLine->get('url-webm') ){
										echo '<source type="video/webm" src="'. $oneLine->getWpKses('url-webm') .'"></source>';
									}
									if( $oneLine->get('url-ogg') ){
										echo '<source type="video/ogg" src="'. $oneLine->getWpKses('url-ogg') .'"></source>';
									}
								echo '</video>';

							echo '</div>';

						}

						break;

				}
			}

		echo '</div>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $slementPreview, $slement ) {
				if(query.queryExists('content')) {
					query.addPlainText('<div class="ffb-preview-icon"><i class="ffb-preview-icon-content ff-font-et-line icon-video"></i></div>');
				}
			}
		</script data-type="ffscript">
	<?php
	}


}