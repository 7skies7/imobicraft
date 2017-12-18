<?php

class ffThemeBuilderBlock_Link extends ffThemeBuilderBlockBasic {
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/
	const PARAM_TARGET = 'param_target';
/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/

	protected $_socialShareList;

/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
	protected function _init() {
		$this->_setInfo( ffThemeBuilderBlock::INFO_ID, 'hyperlink');
		$this->_setInfo( ffThemeBuilderBlock::INFO_WRAPPING_ID, 'link');
		$this->_setInfo( ffThemeBuilderBlock::INFO_WRAP_AUTOMATICALLY, true);
		$this->_setInfo( ffThemeBuilderBlock::INFO_IS_REFERENCE_SECTION, true);
		$this->_setInfo( ffThemeBuilderBlock::INFO_SAVE_ONLY_DIFFERENCE, true);
	}
/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/

	public function urlHasBeenFilled( $query ) {
		$query = $this->_getRightQuery( $query );
		$type = $query->getWithoutComparationDefault('type');
		$filled_data = '';

		switch($type){
			case '':
				$filled_data = $query->getWithoutComparationDefault('url','');
				break;

			case 'mailto:':
				$filled_data = $query->getWithoutComparationDefault('mailto','');
				break;

			case 'callto:':
				$filled_data = $query->getWithoutComparationDefault('callto','');
				break;

			case 'tel:':
				$filled_data = $query->getWithoutComparationDefault('tel','');
				break;

			case 'lightbox-external-video':
				$filled_data = $query->getWithoutComparationDefault('url-video','');
				break;

			case 'lightbox-internal-video':
				$filled_data = $query->getWithoutComparationDefault('url-mp4' ) . $query->getWithoutComparationDefault('url-webm') . $query->getWithoutComparationDefault('url-ogg' );
				break;

			case 'lightbox-embed':
				$filled_data = $query->getWithoutComparationDefault('embed' );
				break;

			case 'lightbox-image':
				$filled_data = $query->getWithoutComparationDefault('img');
				break;

			case 'lightbox-page':
				$filled_data = $query->getWithoutComparationDefault('page-url','');
				break;

			case 'share-social':
				$filled_data = $query->getWithoutComparationDefault('share-social-network','facebook');
				break;

		}

		return ( '' != $filled_data);
	}

	/**
	 * @param $currentUrl
	 * @param $query ffOptionsQueryDynamic
	 */
	protected function _influenceUrl( $currentUrl, $query, $influenceViaPhp ) {
		if( $influenceViaPhp == false ) {
			return $currentUrl;
		}

		$phpInfluencingCode = $query->getWithoutComparationDefault('php-code', '');

		if( empty( $phpInfluencingCode ) ) {
			return $currentUrl;
		}

		eval( $phpInfluencingCode );

		return $currentUrl;
	}

	protected function _render( $query ) {

		$extraCssClasses = $this->getParam('classes');
		$classAttr = '';
		if ( !empty($extraCssClasses) ){
			$classAttr = ' class="' . $extraCssClasses . '" ';
			$extraCssClasses = ' ' . $extraCssClasses . ' ';
		}

		$type = $query->getWithoutComparationDefault('type');


		$influenceUrlViaPhp = false;

		if( $query->getWithoutComparationDefault('php-mode') && in_array($type, array('', 'mailto:', 'callto:', 'tel:', 'lightbox-external-video', 'lightbox-image', 'lightbox-page') ) ) {
			$influenceUrlViaPhp = true;
		}

		switch($type){

			case '':
				$url = $query->getWithoutComparationDefault('url','');
				$url = $this->_influenceUrl( $url, $query, $influenceUrlViaPhp );

				if( !empty( $url ) ) {
					echo 'href="'. esc_url( $url ) . '" ';
				}
				$target_default = $this->getParam( ffThemeBuilderBlock_Link::PARAM_TARGET, '_blank');
				$target = $query->getWithoutComparationDefault('target', $target_default);
				if( empty($target) or ( '_blank' == $target ) ){
					echo ' target="_blank" ';
				}

				$nofollow = $query->getWithoutComparationDefault('nofollow', 0);

				if( $nofollow ) {
					echo ' rel="nofollow" ';
				}

				echo $classAttr;
				break;

			case 'mailto:':
				$url = $query->getWithoutComparationDefault('mailto','');
				$url = $this->_influenceUrl( $url, $query, $influenceUrlViaPhp );
				if( !empty( $url ) ) {
					echo 'href="'. esc_attr( 'mailto:' . $url ) . '" ';
				}
				echo $classAttr;
				break;

			case 'callto:':
				$url = $query->getWithoutComparationDefault('callto','');
				$url = $this->_influenceUrl( $url, $query, $influenceUrlViaPhp );
				if( !empty( $url ) ) {
					echo 'href="'. esc_attr( 'callto:' . $url ) . '" ';
				}
				echo $classAttr;
				break;

			case 'tel:':
				$url = $query->getWithoutComparationDefault('tel','');
				$url = $this->_influenceUrl( $url, $query, $influenceUrlViaPhp );
				if( !empty( $url ) ) {
					echo 'href="'. esc_attr( 'tel:' . $url ) . '" ';
				}
				echo $classAttr;
				break;

			case 'lightbox-external-video':
				$url = $query->getWithoutComparationDefault('url-video','');
				$url = $this->_influenceUrl( $url, $query, $influenceUrlViaPhp );
				if( !empty( $url ) ) {
					echo ' href="'. esc_attr($url ) . '" ';
					echo ' class="' . $extraCssClasses . 'freshframework-lightbox-external-video" ';
					if($query->getWithoutComparationDefault('set-lightbox-sizes', 0) ){

						$breakpoints = array(
							''    => array('', ''),
							'-sm' => array('@media (min-width: 768px){', '}'),
							'-md' => array('@media (min-width: 992px){', '}'),
							'-lg' => array('@media (min-width: 1200px){', '}'),
						);

						$extra_style = '';

						foreach( $breakpoints as $suffix => $bp_css ) {
							$box_width = $query->getWithoutComparationDefault( 'lightbox-width' . $suffix , '');
							if( empty( $box_width ) ) {
								continue;
							}

							if( is_numeric( $box_width ) ) {
								$box_width = $box_width . 'px';
							}

							$extra_style .= $bp_css[0] . '.mfp-content{max-width:'.$box_width.' !important}' . $bp_css[1];
						}

						if( empty($extra_style) ){
							break;
						}

						$data_modal = '';
						$data_modal .= '<div class="mfp-iframe-scaler">';
						$data_modal .= '<div class="mfp-close"></div>';
						$data_modal .= '<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>';
						$data_modal .= '<style>'.$extra_style.'</style>';
						$data_modal .= '</div>';
						echo 'data-freshframework-internal-html="'.esc_attr($data_modal).'" ';
					}
				} else {
					echo $classAttr;
				}
				break;

			case 'lightbox-internal-video':
				$url_mp4  = esc_url( $query->getWithoutComparationDefault('url-mp4' ) );
				$url_webm = esc_url( $query->getWithoutComparationDefault('url-webm') );
				$url_ogg  = esc_url( $query->getWithoutComparationDefault('url-ogg' ) );

				$data_modal = '';

				if ( !empty($url_mp4) || !empty($url_webm) || !empty($url_ogg) ) {

					$data_modal .= '<div class="container">';
					$data_modal .= '<div class="embed-video-local">';

					if($query->getWithoutComparationDefault('set-lightbox-sizes', 0) ) {
						$breakpoints = array(
							'' => array('', ''),
							'-sm' => array('@media (min-width: 768px){', '}'),
							'-md' => array('@media (min-width: 992px){', '}'),
							'-lg' => array('@media (min-width: 1200px){', '}'),
						);

						$extra_style = '';

						foreach ($breakpoints as $suffix => $bp_css) {
							$box_width = $query->getWithoutComparationDefault('lightbox-width' . $suffix, '');
							if (empty($box_width)) {
								continue;
							}

							if (is_numeric($box_width)) {
								$box_width = $box_width . 'px';
							}

							$extra_style .= $bp_css[0] . '.embed-video-local{max-width:' . $box_width . ' !important;margin:0 auto}' . $bp_css[1];
						}

						if( !empty($extra_style) ){
							$data_modal .= '<style>'.$extra_style.'</style>';
						}
					}

					$parameters = array();
					if( $query->getWithoutComparationDefault('has-autoplay')    ) { $parameters[] = 'autoplay '; }
					if( $query->getWithoutComparationDefault('is-muted')        ) { $parameters[] = 'muted '; }
					if( $query->getWithoutComparationDefault('has-loop')        ) { $parameters[] = 'loop '; }
					if( $query->getWithoutComparationDefault('show-controls',1) ) { $parameters[] = 'controls'; }

					$parameters = implode(' ', $parameters);

					$data_modal .= '<video ' . $parameters . ' style="display:block;width:100%;height:auto;">';
					if ($url_mp4 ) { $data_modal .= '<source type="video/mp4"  src="' . $url_mp4 . '"></source>'; }
					if ($url_webm) { $data_modal .= '<source type="video/webm" src="' . $url_webm . '"></source>'; }
					if ($url_ogg ) { $data_modal .= '<source type="video/ogg"  src="' . $url_ogg . '"></source>'; }
					$data_modal .= '</video>';

					$data_modal .= '</div>';
					$data_modal .= '</div>';
				}

				$data_modal = esc_attr($data_modal);
				$data_modal = str_replace('=', '&#61;', $data_modal);

				echo 'href="#" ';
				echo 'class="' . $extraCssClasses . 'freshframework-internal-html" ';
				echo 'data-freshframework-internal-html="'.$data_modal.'" ';
				break;

			case 'lightbox-embed':
				echo 'href="#" ';

				$embed = $query->getWithoutComparationDefault('embed' );
				if ( empty($embed) ) {
					break;
				}

				$extra_style = '';

				if($query->getWithoutComparationDefault('set-lightbox-sizes', 0) ) {

					$breakpoints = array(
						''    => array('', ''),
						'-sm' => array('@media (min-width: 768px){', '}'),
						'-md' => array('@media (min-width: 992px){', '}'),
						'-lg' => array('@media (min-width: 1200px){', '}'),
					);

					foreach ($breakpoints as $suffix => $bp_css) {
						$box_width = $query->getWithoutComparationDefault('lightbox-width' . $suffix, '');
						$box_height = $query->getWithoutComparationDefault('lightbox-height' . $suffix, '');
						if (empty($box_width) and empty($box_height)) {
							continue;
						}

						if (is_numeric($box_width)) {
							$box_width = $box_width . 'px';
						}

						if (is_numeric($box_height)) {
							$box_height = $box_height . 'px';
						}

						$extra_style .= $bp_css[0];
						if (!empty($box_width)) {
							$extra_style .= '.mfp-iframe-holder{ max-width:' . $box_width . ' !important}';
						}
						if (!empty($box_height)) {
							$extra_style .= '.ff-lightbox-embed-inner{ max-height:' . $box_height . ' !important}';
						}
						$extra_style .= $bp_css[1];
					}
				}

				$data_modal = '';
				$bgColor = $query->getColorWithoutComparationDefault('bgcolor', '#FFF');
				$data_modal .= '<div class="lightbox-html-code-wrapper">';
					$data_modal .= '<div class="mfp-iframe-holder">';
						$data_modal .= '<div class="ff-lightbox-embed-inner" style="background:'.$bgColor.'">';
							$data_modal .= do_shortcode($embed);
						$data_modal .= '</div>';
						$data_modal .= '<button title="Close (Esc)" type="button" class="mfp-close">×</button>';
						if( !empty($extra_style) ) {
							$data_modal .= '<style>' . $extra_style . '</style>';
						}
					$data_modal .= '</div>';
				$data_modal .= '</div>';

				echo 'class="' . $extraCssClasses . 'freshframework-internal-html" ';
				echo 'data-freshframework-internal-html="'.esc_attr($data_modal).'" ';
				break;

			case 'lightbox-image':
				$url = $query->getImage('img')->url;
				$url = $this->_influenceUrl( $url, $query, $influenceUrlViaPhp );
				if( !empty( $url ) ) {
					echo 'href="'. esc_attr($url ) . '" ';
					echo 'class="' . $extraCssClasses . 'freshframework-lightbox-image" ';
					if($query->getWithoutComparationDefault('set-lightbox-sizes', 0) ){

						$breakpoints = array(
							''    => array('', ''),
							'-sm' => array('@media (min-width: 768px){', '}'),
							'-md' => array('@media (min-width: 992px){', '}'),
							'-lg' => array('@media (min-width: 1200px){', '}'),
						);

						$extra_style = '';

						foreach( $breakpoints as $suffix => $bp_css ) {
							$box_width = $query->getWithoutComparationDefault( 'lightbox-width' . $suffix , '');
							if( empty( $box_width ) ) {
								continue;
							}

							if( is_numeric( $box_width ) ) {
								$box_width = $box_width . 'px';
							}

							$extra_style .= $bp_css[0] . '.mfp-content{max-width:'.$box_width.' !important}' . $bp_css[1];
						}

						if( empty($extra_style) ){
							break;
						}

						$data_modal = '';
						$data_modal .= '<div class="mfp-figure">';
							$data_modal .= '<style>'.$extra_style.'</style>';
							$data_modal .= '<div class="mfp-close"></div>';
							$data_modal .= '<div class="mfp-img"></div>';
							$data_modal .= '<div class="mfp-bottom-bar">';
								$data_modal .= '<div class="mfp-title"></div>';
								$data_modal .= '<div class="mfp-counter"></div>';
							$data_modal .= '</div>';
						$data_modal .= '</div>';
						echo 'data-freshframework-internal-html="'.esc_attr($data_modal).'" ';
					}
				} else {
					echo $classAttr;
				}
				break;

			case 'lightbox-page':
				$url = $query->getWithoutComparationDefault('page-url','');
				$url = $this->_influenceUrl( $url, $query, $influenceUrlViaPhp );
				if( !empty( $url ) ) {
					echo 'href="'. esc_attr($url ) . '" ';
					echo 'class="' . $extraCssClasses . 'freshframework-lightbox-page" ';

					if($query->getWithoutComparationDefault('set-lightbox-sizes', 0) ){

						$breakpoints = array(
							''    => array('', ''),
							'-sm' => array('@media (min-width: 768px){', '}'),
							'-md' => array('@media (min-width: 992px){', '}'),
							'-lg' => array('@media (min-width: 1200px){', '}'),
						);

						$extra_style = '';

						foreach( $breakpoints as $suffix => $bp_css ) {
							$box_width  = $query->getWithoutComparationDefault( 'lightbox-width' . $suffix , '');
							$box_height = $query->getWithoutComparationDefault( 'lightbox-height' . $suffix , '');
							if( empty( $box_width ) and empty( $box_height ) ) {
								continue;
							}

							if( is_numeric( $box_width ) ) {
								$box_width = $box_width . 'px';
							}

							if( is_numeric( $box_height ) ) {
								$box_height = $box_height . 'px';
							}

							$extra_style .= $bp_css[0];
							if( !empty( $box_width ) ) {
								$extra_style .= '.mfp-content, .mfp-iframe-scaler{ max-width:' . $box_width . ' !important}';
							}
							if( !empty( $box_height ) ) {
								$extra_style .= '.mfp-iframe-scaler{ padding-top:' . $box_height . ' !important}';
							}
							$extra_style .= $bp_css[1];
						}

						if( empty($extra_style) ){
							break;
						}

						$data_modal = '';
						$data_modal .= '<div class="mfp-figure">';
						$data_modal .= '<style>'.$extra_style.' .mfp-iframe-scaler{position: relative;margin:0 auto;overflow:visible;}</style>';
						$data_modal .= '<div class="mfp-iframe-scaler">';
						$data_modal .= '<div class="mfp-close"></div>';
						$data_modal .= '<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>';
						$data_modal .= '</div>';
						echo 'data-freshframework-internal-html="'.esc_attr($data_modal).'" ';
					}
				} else {
					echo $classAttr;
				}
				break;

			case 'share-social':
				$socialNetwork = $query->getWithoutComparationDefault('share-social-network','facebook');
				$networks = $this->_getSocialShareList();
				if( empty( $networks[$socialNetwork] ) ){
					$socialNetwork = 'facebook';
				}
				$socialSettings = $networks[$socialNetwork];
				$url_params = $socialSettings[ 'url_params' ];

				$link = $socialSettings['url'] . '?';
				if( $query->getWithoutComparationDefault('share-social-target-page','') ){
					$socLink = $query->getWithoutComparationDefault('share-social-page-url','');
				}else{
					$socLink = get_the_permalink();
				}
				$params = array();
				foreach ($url_params as $key=>$_GET_param) {
					switch ($key) {
						case 'URL':
							$params[] = $_GET_param . '=' . urlencode( $socLink );
							break;
						case 'ADD':
							if( !empty( $_GET_param ) ) {
								$params[] = $_GET_param;
							}
							break;
					}
				}
				new ffElementHelper();
				echo $classAttr;
				$link = ( $link . implode("&amp;",$params) );
				echo 'href="'. $link . '" target="_blank" ';
				break;
		}

		$title = $query->getWithoutComparationDefault('title');
		if( !empty($title) ){
			echo ' title="'. esc_attr($title) .'" ';
		}
	}

	protected function _injectOptions( ffThemeBuilderOptionsExtender $s ) {

//		$url_recommendations = __( 'We recommend not using the <code>http(s)://</code> prefix. Use a more reliable <code>//</code> prefix instead. Example: <code>//www.mysite.com/about</code>', 'ark');


		$s->startHidingBoxParent();

		$s->addOptionNL(ffOneOption::TYPE_SELECT, 'type', '', '')
			->addSelectValue( __('Link - Normal'), '')
			->addSelectValue( __('Link - Email'), 'mailto:')
			->addSelectValue( __('Link - Skype'), 'callto:')
			->addSelectValue( __('Link - Telephone'), 'tel:')
			->addSelectValue( __('Lightbox - YouTube or Vimeo'), 'lightbox-external-video')
			->addSelectValue( __('Lightbox - Local Video File'), 'lightbox-internal-video')
			->addSelectValue( __('Lightbox - HTML or Embed'), 'lightbox-embed')
			->addSelectValue( __('Lightbox - Image'), 'lightbox-image')
			->addSelectValue( __('Lightbox - Web Page'), 'lightbox-page')
			->addSelectValue( __('Social - Share'), 'share-social')
			->addParam( ffOneOption::PARAM_TITLE_AFTER, 'Link Type' );
		;

		$s->startHidingBox('type', '');
			$target = $this->getParam( ffThemeBuilderBlock_Link::PARAM_TARGET, '_blank');

			$s->addOptionNL(ffOneOption::TYPE_SELECT, 'target','', $target)
				->addSelectValue( __('Same Window'), 'same')
				->addSelectValue( __('New Window'), '_blank')
				->addParam( ffOneOption::PARAM_TITLE_AFTER, 'Link Target' );
			;

			$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'nofollow', 'Enable <code>rel="nofollow"</code>', 0);

			$s->addOptionNL(ffOneOption::TYPE_TEXT, 'url', '', '')
				->addParam( ffOneOption::PARAM_TITLE_AFTER, 'Link URL' );
		$s->endHidingBox();

		$s->startHidingBox('type', 'mailto:');
			$s->addOptionNL(ffOneOption::TYPE_TEXT, 'mailto', '', '')
				->addParam( ffOneOption::PARAM_TITLE_AFTER, __('E-mail address (without <code>mailto:</code> prefix)') );
		$s->endHidingBox();

		$s->startHidingBox('type', 'callto:');
			$s->addOptionNL(ffOneOption::TYPE_TEXT, 'callto', '', '')
				->addParam( ffOneOption::PARAM_TITLE_AFTER, __('Skype  (without <code>callto:</code> prefix)') );
		$s->endHidingBox();

		$s->startHidingBox('type', 'tel:');
			$s->addOptionNL(ffOneOption::TYPE_TEXT, 'tel', '', '')
				->addParam( ffOneOption::PARAM_TITLE_AFTER, __('Telephone Number  (without <code>tel:</code> prefix)') );
		$s->endHidingBox();

		$s->startHidingBox('type', array('', 'mailto:', 'callto:', 'tel:', 'lightbox-external-video', 'lightbox-image', 'lightbox-page') );
			$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'php-mode', 'Influence link URL with PHP (e.g. for ACF)', 0);

			$s->startHidingBox('php-mode','checked');
				$s->addElement(ffOneElement::TYPE_NEW_LINE,'');
				$s->addElement(ffOneElement::TYPE_DESCRIPTION,'','You can access current URL with <code>$currentUrl</code>. If you want to set new URL, write this code <code>$currentUrl = "some new url";</code>');
				$s->addElement(ffOneElement::TYPE_NEW_LINE,'');
				$s->addElement(ffOneElement::TYPE_DESCRIPTION,'','<span style="color:red;">Tricky Part: All elements are cached, including links. You need to insert this element inside "Wrapper" and disable caching in the wrapper settings in order to make your PHP scripts working</span>');
				$s->addOption(ffOneOption::TYPE_TEXTAREA_STRICT, 'php-code', '', '')
					->addParam('no-wrapping', true)
					->addParam( ffOneOption::PARAM_CODE_EDITOR, 'php')
				;
			$s->endHidingBox();
		$s->endHidingBox();

		$s->startHidingBox('type', array( 'lightbox-external-video', 'lightbox-internal-video', 'lightbox-embed', 'lightbox-image', 'lightbox-page' ));
			$s->addElement(ffOneElement::TYPE_NEW_LINE );
			$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'set-lightbox-sizes', __('Set Lightbox maximum sizes'), 0);

			$s->startHidingBox('set-lightbox-sizes', 'checked');
				$breakpoints = array(
					''    => 'Phone (XS)&nbsp;&nbsp;&nbsp;&nbsp;',
					'-sm' => 'Tablet (SM)&nbsp;&nbsp;&nbsp;',
					'-md' => 'Laptop (MD)&nbsp;',
					'-lg' => 'Desktop (LG)',
				);

					$s->addElement(ffOneElement::TYPE_HTML, '', '<table class="ffb-box-model-table" border="0" cellpadding="0" cellspacing="0">');

					$s->addElement(ffOneElement::TYPE_HTML, '', '<tbody><tr><td></td><td>Max Width</td><td>');
					$s->startHidingBox('type', array( 'lightbox-embed', 'lightbox-page' ));
						$s->addElement(ffOneElement::TYPE_HTML, '', 'Max Height');
					$s->endHidingBox();

					$s->addElement(ffOneElement::TYPE_HTML, '', '</td></tr>');

					foreach( $breakpoints as $suffix => $title ) {
						$s->addElement(ffOneElement::TYPE_HTML, '', '<tr>');
							$s->addElement(ffOneElement::TYPE_HTML, '', '<td>' . $title . '</td>');

							if( empty($suffix) ){
								$placeholder = 'Default';
							}else{
								$placeholder = 'Inherit';
							}

							$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
								$s->addOption( ffOneOption::TYPE_TEXT, 'lightbox-width'.$suffix, '', '')
									->addParam('short', true)
									->addParam('placeholder', $placeholder);
							$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');

							$s->addElement(ffOneElement::TYPE_HTML, '', '<td>');
								$s->startHidingBox('type', array( 'lightbox-embed', 'lightbox-page' ));
									$s->addOption( ffOneOption::TYPE_TEXT, 'lightbox-height'.$suffix, '', '')
										->addParam('short', true)
										->addParam('placeholder', $placeholder);
								$s->endHidingBox();
							$s->addElement(ffOneElement::TYPE_HTML, '', '</td>');
						$s->addElement(ffOneElement::TYPE_HTML, '', '</tr>');
					}

					$s->addElement(ffOneElement::TYPE_HTML, '', '</tbody></table>');
					$s->addElement(ffOneElement::TYPE_DESCRIPTION, '', __('Please reconsider to use units like <strong>vw</strong> (viewport width) and <strong>vh</strong> (viewport height) instead of <strong>%</strong> (percentage)'));

			$s->endHidingBox();
			$s->addElement(ffOneElement::TYPE_NEW_LINE );
		$s->endHidingBox();

		$s->startHidingBox('type', 'lightbox-external-video');
			$s->addOptionNL(ffOneOption::TYPE_TEXT,'url-video','','')
				->addParam( ffOneOption::PARAM_TITLE_AFTER, __('External Video Link URL') );
		$s->endHidingBox();

		$s->startHidingBox('type', 'lightbox-internal-video');
			$s->addOptionNL(ffOneOption::TYPE_TEXT,'url-mp4','','')->addParam( ffOneOption::PARAM_TITLE_AFTER, __('Local Video File URL (.mp4)') );
			$s->addOptionNL(ffOneOption::TYPE_TEXT,'url-webm','','')->addParam( ffOneOption::PARAM_TITLE_AFTER, __('Local Video File URL (.webm)') );
			$s->addOptionNL(ffOneOption::TYPE_TEXT,'url-ogg','','')->addParam( ffOneOption::PARAM_TITLE_AFTER, __('Local Video File URL (.ogg)') );
			$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', __('You can input more than 1 video file format (up to 3) to support wider range of devices and their web browsers.') );

			$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'show-controls', __('Show controls'), 1);
			$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'has-autoplay', __('Auto-play video'), 0);
			$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'has-loop', __('Loop video'), 0);
			$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'is-muted', __('Mute audio'), 0);
		$s->endHidingBox();

		$s->startHidingBox('type', 'lightbox-embed');
			$s->addOptionNL(ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bgcolor', '','#fff')
				->addParam( ffOneOption::PARAM_TITLE_AFTER, __('Background Color') );
			$s->addElement(ffOneElement::TYPE_NEW_LINE);
			$s->addOptionNL(ffOneOption::TYPE_TEXTAREA_STRICT, 'embed', __('Embed or HTML Code'),'');
		$s->endHidingBox();

		$s->startHidingBox('type', 'lightbox-image');
			$s->addOptionNL( ffOneOption::TYPE_IMAGE, 'img', __('Image'), '');
			$s->addOptionNL(ffOneOption::TYPE_TEXT,'img_title','','')->addParam( ffOneOption::PARAM_TITLE_AFTER, __('Image Label') );
		$s->endHidingBox();

		$s->startHidingBox('type', 'lightbox-page');
			$s->addOptionNL(ffOneOption::TYPE_TEXT,'page-url','','')->addParam( ffOneOption::PARAM_TITLE_AFTER, __('Web Page URL') );
		$s->endHidingBox();

		$s->startHidingBox('type', 'share-social');
			$opt = $s->addOptionNL(ffOneOption::TYPE_SELECT, 'share-social-network', '', 'facebook');
			foreach( $this->_getSocialShareList() as $key => $object ){
				$opt->addSelectValue($key ,$key);
			}
			$opt->addParam( ffOneOption::PARAM_TITLE_AFTER, __('Social Network') );
			$s->addOptionNL(ffOneOption::TYPE_SELECT, 'share-social-target-page', '', '')
				->addSelectValue( __('Share Actual Page'), '')
				->addSelectValue( __('Share Custom URL'), 'custom')
				->addParam( ffOneOption::PARAM_TITLE_AFTER, __('Shared Page') );

			$s->startHidingBox('share-social-target-page', 'custom');
				$s->addOptionNL(ffOneOption::TYPE_TEXT,'share-social-page-url','','')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, __('Custom URL') );
			$s->endHidingBox();

		$s->endHidingBox();

		$s->addOptionNL(ffOneOption::TYPE_TEXT, 'title', '',  '')
			->addParam( ffOneOption::PARAM_TITLE_AFTER, __('Link Title') );
		;

		$s->endHidingBoxParent();

	}

	protected function _getSocialShareList(){
		if( !empty( $this->_socialShareList ) ){
			return $this->_socialShareList;
		}

		return $this->_socialShareList = array(
			'blinklist' => array(
				'title' => 'Blinklist',
				'url' => 'http://www.blinklist.com/index.php', // ?Action=Blink/Addblink.php&amp;Url=[url]&amp;Title=[title]
				'url_params' => array(
					'URL' => 'Url',
					'TITLE' => 'Title',
					'ADD' => 'Action=Blink/Addblink.php',
				),
			),

			'delicious' => array(
				'title' => 'Delicious',
				'url' => 'http://del.icio.us/post', // ?url=[URL]&title=[TITLE]]&notes=[DESCRIPTION]
				'url_params' => array(
					'URL' => 'url',
					'TITLE' => 'title',
					'DSCR' => 'notes',
				),
			),

			'designbump' => array(
				'title' => 'Design Bump',
				'url' => 'http://www.designbump.com/node/add/drigg/', // ?url=[URL]&title=[title]&body=[desc]
				'url_params' => array(
					'URL' => 'url',
					'TITLE' => 'title',
					'DSCR' => 'body',
				),
			),

			'designmoo' => array(
				'title' => 'Design Moo',
				'url' => 'http://www.designmoo.com/node/add/drigg/', // ?url=[URL]&title=[title]&body=[desc]
				'url_params' => array(
					'URL' => 'url',
					'TITLE' => 'title',
					'DSCR' => 'body',
				),
			),

			'digg' => array(
				'title' => 'Digg',
				'url' => 'http://digg.com/submit', // ?url=[URL]&title=[TITLE]
				'url_params' => array(
					'URL' => 'url',
					'TITLE' => 'title',
				),
			),

			'dzone' => array(
				'title' => 'DZone',
				'url' => 'http://dzone.com/links/add.html', // ?url=[URL]&amp;title=[title]&amp;description=[desc]
				'url_params' => array(
					'URL' => 'url',
					'TITLE' => 'title',
					'DSCR' => 'description',
				),
			),

			'email' => array(
				'title' => 'Email',
				'url' => 'mailto:', // ?subject=[title]&amp;body=[URL]
				'url_params' => array(
					'URL' => 'body',
					'TITLE' => 'subject',
				),
			),

			'evernote' => array(
				'title' => 'Evernote',
				'url' => 'http://www.evernote.com/clip.action', // ?url=[URL]&amp;title=[title]
				'url_params' => array(
					'URL' => 'url',
					'TITLE' => 'title',
				),
			),

			'facebook' => array(
				'title' => 'Facebook',
				'url' => 'https://www.facebook.com/sharer/sharer.php', // ?u=[URL]&t=[TITLE]
				'url_params' => array(
					'URL' => 'u',
				),
			),

			'fark' => array(
				'title' => 'Fark',
				'url' => 'http://cgi.fark.com/cgi/fark/farkit.pl', // ?u=[url]&amp;h=[title]
				'url_params' => array(
					'URL' => 'u',
					'TITLE' => 'h',
				),
			),

			'friendfeed' => array(
				'title' => 'Friendfeed',
				'url' => 'http://www.friendfeed.com/share', // ?url=[URL]&amp;title=[title]
				'url_params' => array(
					'URL' => 'url',
					'TITLE' => 'title',
				),
			),

			'googleplus' => array(
				'title' => 'Google+',
				'url' => 'https://plus.google.com/share', // ?url=[URL]
				'url_params' => array(
					'URL' => 'url',
				),
			),

			'googlebookmarks' =>array(
				'title' => 'Google Bookmarks',
				'url' => 'http://www.google.com/bookmarks/mark', // ?op=edit&amp;bkmk=[URL]&amp;title=[title]&amp;annotation=[desc]
				'url_params' => array(
					'URL' => 'bkmk',
					'TITLE' => 'title',
					'DSCR' => 'annotation',
					'ADD' => 'op=edit',
				),
			),

			// http://www.linkedin.com/shareArticle?mini=true&url=[URL]&title=[TITLE]&source=[SOURCE/DOMAIN]
			'linkedin' => array(
				'title' => 'linkedIn',
				'url' => 'http://www.linkedin.com/shareArticle', //?mini=true&url={articleUrl}&title={articleTitle}&summary={articleSummary}&source={articleSource}
				'url_params' => array(
					'URL' => 'url',
					'TITLE' => 'title',
					'DSCR' => 'summary',
					'SRC' => 'source',
				),
			),

			'myspace' => array(
				'title' => 'Myspace',
				'url' => 'http://www.myspace.com/Modules/PostTo/Pages/', // ?u=[url]&amp;t=[title]
				'url_params' => array(
					'URL' => 'u',
					'TITLE' => 't',
				),
			),

			'netvouz' => array(
				'title' => 'Netvouz',
				'url' => 'http://www.netvouz.com/action/submitBookmark', // ?url=[url]&amp;title=[title]&amp;popup=no
				'url_params' => array(
					'URL' => 'url',
					'TITLE' => 'title',
					'ADD' => 'popup=no',
				),
			),

			'newsvine' => array(
				'title' => 'Newsvine',
				'url' => 'http://www.newsvine.com/_tools/seed&amp;save', // ?u=[URL]&h=[TITLE]
				'url_params' => array(
					'URL' => 'u',
					'TITLE' => 'h',
				),
			),

			'reddit' => array(
				'title' => 'Reddit',
				'url' => 'http://reddit.com/submit', //?url=[URL]&title=[TITLE]
				'url_params' => array(
					'URL' => 'url',
					'TITLE' => 'title',
				),
			),

			'stumbleupon' => array(
				'title' => 'Stumbleupon',
				'url' => 'http://www.stumbleupon.com/submit', //?url=[URL]&title=[TITLE]
				'url_params' => array(
					'URL' => 'url',
					'TITLE' => 'title',
				),
			),

			'technorati' => array(
				'title' => 'Technorati',
				'url' => 'http://technorati.com/faves', // ?add=[URL]&amp;title=[title]
				'url_params' => array(
					'URL' => 'add',
					'TITLE' => 'title',
				),
			),

			// http://www.tumblr.com/share?v=3&u=[URL]&t=[TITLE]
			// http://www.tumblr.com/share?v=3&amp;u=[url]&amp;t=[title]&amp;s=[description]
			'tumblr' => array(
				'title' => 'Tumblr',
				'url' => 'http://www.tumblr.com/share/link', //?url=[URL]&name=[TITLE]&description=[DESCRIPTION]
				'url_params' => array(
					'URL' => 'url',
					'TITLE' => 'name',
					'DSCR' => 'description',
				),
			),

			// http://twitter.com/home?status=[TITLE]+[URL]
			'twitter' => array(
				'title' => 'Twitter',
				'url' => 'http://twitter.com/intent/tweet', //?source=[SRC]&text=[TITLE]&url=[URL]
				'url_params' => array(
					'URL' => 'url',
					'TITLE' => 'text',
					'SRC' => 'source',
				),
			),

			// http://www.addtoany.com/add_to/viadeo?linkurl=PAGE_URL_ENCODED&amp;linkname=PAGE_TITLE_ENCODED
			'viadeo' => array(
				'title' => 'Viadeo',
				'url' => 'http://www.addtoany.com/add_to/viadeo', // ?linkurl=PAGE_URL_ENCODED&amp;linkname=PAGE_TITLE_ENCODED
				'url_params' => array(
					'URL' => 'linkurl',
					'TITLE' => 'linkname',
				),
			),

			// http://vkontakte.ru/share.php?url={page address}
			'vk' => array(
				'title' => 'VK',
				'url' => 'http://vkontakte.ru/share.php', // ?url={page address}
				'url_params' => array(
					'URL' => 'url',
				),
			),

			// https://www.xing.com/app/user?op=share&url=testlink.de;title=Test;provider=testprovider
			'xing' => array(
				'title' => 'XING',
				'url' => 'https://www.xing.com/app/user', // ?op=share&url=testlink.de;title=Test;provider=testprovider
				'url_params' => array(
					'URL' => 'url',
					'TITLE' => 'title',
					'SRC' => 'provider',
					'ADD' => 'op=share',
				),
			),

		);
	}
/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/
}