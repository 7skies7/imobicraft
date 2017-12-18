<?php

class ffBlImage extends ffThemeBuilderBlockBasic {
	const IMG_IS_RESPONSIVE = 'img_is_responsive';
	const IMG_IS_FULLWIDTH = 'img_is_fullwidth';

	const IMG_IS_FORCED_RESPONSIVE = 'img_is_forced_responsive';
	const IMG_IS_FORCED_FULLWIDTH = 'img_is_forced_fullwidth';
	const IMG_HAS_FORCED_WIDTH_AND_HEIGHT = 'img_has_forced_width_and_height';

	const RETURN_JSON_INSTEAD_IF_IMAGE = 'return_json_instead_of_image';

	const PARAM_CSS_CLASS = 'css-class';
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
	protected function _init() {
		$this->_setInfo( ffThemeBuilderBlock::INFO_ID, 'image');
		$this->_setInfo( ffThemeBuilderBlock::INFO_WRAPPING_ID, 'img');
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

	protected function _injectOptions( ffThemeBuilderOptionsExtender $s ) {

		$s->addOption(ffOneOption::TYPE_IMAGE, 'img', ark_wp_kses( __('Image', 'ark' ) ), '');

		$s->addElement( ffOneElement::TYPE_TOGGLE_BOX_START, '', 'Image Settings' )
			->addParam('is-opened', false)
		;


		$s->addOptionNL( ffOneOption::TYPE_CHECKBOX,'resize', ark_wp_kses( __('Resize', 'ark' ) ), 0);

		$s->startHidingBox('resize', 'checked');

		$s->addOptionNL(ffOneOption::TYPE_TEXT, 'width', '', '')
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Width (in px)', 'ark' ) ) )
		;

		$s->addOptionNL(ffOneOption::TYPE_TEXT, 'height', '', '')
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Height (in px)', 'ark' ) ) )
		;



		$width = '';
		$height = '';
		if( $this->getParam( 'width', null) ||  $this->getParam( 'height', null) ){
			$width = $this->getParam( 'width', null);
			$height = $this->getParam( 'height', null);

			$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', ark_wp_kses( __('Default resizing values for this image are:', 'ark' ) ) );
			if( $width ) {
				$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', '<strong>'.ark_wp_kses( __('Width:', 'ark') ) .' </strong> <code>'. $width .'</code> px' );
			} else {
				$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', '<strong>'.ark_wp_kses( __('Width:', 'ark') ) .' </strong>' . ark_wp_kses( __('Undefined', 'ark') ) );
			}

			if( $height ) {
				$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', '<strong>' . ark_wp_kses( __('Height:', 'ark') ) .' </strong> <code>'. $height .'</code> px' );
			} else {
				$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', '<strong>' . ark_wp_kses( __('Height:', 'ark') ) .' </strong>' . ark_wp_kses( __('Undefined', 'ark') ) );
			}
		}

		if( $this->getParam( 'width', null) ||  $this->getParam( 'height', null) ) {
			$s->endHidingBox();
		}

		$s->addElement(ffOneElement::TYPE_NEW_LINE);

		$s->addOptionNL( ffOneOption::TYPE_SELECT, 'quality', '', 90)
			->addSelectValue('100%', 100)
			->addSelectValue('90%', 90)
			->addSelectValue('80%', 80)
			->addSelectValue('70%', 70)
			->addSelectValue('60%', 60)
			->addSelectValue('50%', 50)
			->addSelectValue('40%', 40)
			->addSelectValue('30%', 30)
			->addSelectValue('20%', 20)
			->addSelectValue('10%', 10)
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Image Quality', 'ark' ) ) )
		;

		$s->addOptionNL( ffOneOption::TYPE_SELECT, 'aspect-ratio', '', '')
			->addSelectValue('Original', '')
			->addSelectValue( '1:1', '1:1')
			->addSelectValue( '4:3', '4:3')
			->addSelectValue( '16:9', '16:9')
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Aspect Ratio', 'ark' ) ) )
		;

		if( !($this->getParam( 'width', null) ||  $this->getParam( 'height', null)) ) {
			$s->endHidingBox();
		}

		if( (int)$this->getParam( ffBlImage::IMG_IS_FORCED_RESPONSIVE, 0) ){
			$s->addElement(ffOneElement::TYPE_HTML,'', '<div class="hidden">' );
		}

		$s->addElement(ffOneElement::TYPE_NEW_LINE);
		$responsive = (int)$this->getParam( ffBlImage::IMG_IS_RESPONSIVE, 1);
		$s->addOptionNL( ffOneOption::TYPE_CHECKBOX,'responsive', ark_wp_kses( __('Image is Responsive', 'ark' ) ), $responsive);
		$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', ark_wp_kses( __('Prevents the image to be larger than it\'s container', 'ark' ) ) );

		if( (int)$this->getParam( ffBlImage::IMG_IS_FORCED_RESPONSIVE, 0) ){
			$s->addElement(ffOneElement::TYPE_HTML,'', '</div>' );
		}

		if( (int)$this->getParam( ffBlImage::IMG_IS_FORCED_FULLWIDTH, 0) ){
			$s->addElement(ffOneElement::TYPE_HTML,'', '<div class="hidden">' );
		}

		$s->addElement(ffOneElement::TYPE_NEW_LINE);
		$fullwidth = (int)$this->getParam( ffBlImage::IMG_IS_FULLWIDTH, 0);
		$s->addOptionNL( ffOneOption::TYPE_CHECKBOX,'fullwidth', ark_wp_kses( __('Image is Full Width', 'ark' ) ), $fullwidth);
		$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', ark_wp_kses( __('Forces the image to have the same width as it\'s container', 'ark' ) ) );
		if( (int)$this->getParam( ffBlImage::IMG_IS_FORCED_FULLWIDTH, 0) ){
			$s->addElement(ffOneElement::TYPE_HTML,'', '</div>' );
		}

		$s->addElement(ffOneElement::TYPE_NEW_LINE);

		$s->addOptionNL(ffOneOption::TYPE_SELECT, 'alt-type', '', 'title')
			->addSelectValue( esc_attr( __('None', 'ark' ) ), '')
			->addSelectValue( esc_attr( __('Image Title', 'ark' ) ), 'title')
			->addSelectValue( esc_attr( __('Image Caption', 'ark' ) ), 'caption')
			->addSelectValue( esc_attr( __('Image Description', 'ark' ) ), 'description')
			->addSelectValue( esc_attr( __('Custom', 'ark' ) ), 'own-alt')
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Alt Attribute', 'ark' ) ) )
		;

		$s->startHidingBox('alt-type', 'own-alt');

		$s->addOptionNL(ffOneOption::TYPE_TEXT, 'alt', '',  '')
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Custom Alt Attribute', 'ark' ) ) )
		;

		$s->endHidingBox();


		$s->addOptionNL(ffOneOption::TYPE_TEXT, 'title',  '',  '')
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Title Attribute', 'ark' ) ) )
		;
		$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', ark_wp_kses( __('Title attribute shows up in a little tooltip when you hover over the image', 'ark' ) ) );
		$s->addElement( ffOneElement::TYPE_TOGGLE_BOX_END );

	}

	public function imgIsFullWidth() {
		$this->setParam( ffBlImage::IMG_IS_FULLWIDTH, true );

		return $this;
	}

	public function imgIsForcedFullWidth() {
		$this->setParam( ffBlImage::IMG_IS_FORCED_FULLWIDTH, true );

		return $this;
	}

	public function imgIsResponsive() {
		$this->setParam( ffBlImage::IMG_IS_RESPONSIVE, true );

		return $this;
	}

	public function imgIsForcedResponsive() {
		$this->setParam( ffBlImage::IMG_IS_FORCED_RESPONSIVE, true );

		return $this;
	}

	public function imgHasForcedWidthAndHeight() {
		$this->setParam( ffBlImage::IMG_HAS_FORCED_WIDTH_AND_HEIGHT, true );

		return $this;
	}

	public function returnJsonInsteadOfImage() {
		$this->setParam( ffBlImage::RETURN_JSON_INSTEAD_IF_IMAGE, true );

		return $this;
	}

	protected function _render( $query ) {
		if( $this->_queryIsEmpty() ) {
			// echo "\n\n\n\n\n\n\n\n\n\n\n\n IMAGE OPTION NOT FILLED WITH DATA \n\n\n\n\n\n\n\n\n\n\n\n";
			return;
		}

		if( !$query->queryExists('img') ){
			// echo "\n\n\n\n\n\n\n\n\n\n\n\n IMAGE OPTION NOT FILLED WITH DATA \n\n\n\n\n\n\n\n\n\n\n\n";
			return;
		}

		$image = $query->getImage('img');
		$imageID = $image->id;
		$imageUrl = $image->url;

		$width = null;
		$height = null;

		if( $query->getWithoutComparationDefault('resize', 0) ) {
			$width = absint( $query->getWithoutComparationDefault('width') );
			$height = absint( $query->getWithoutComparationDefault('height') );

		} else if( $this->getParam('width') ){
			$width = absint( $this->getParam('width') );
			$height = absint( $this->getParam('height') );


		}

		$aspectRatio = $query->getColorWithoutComparationDefault('aspect-ratio', '');

		if( !empty( $aspectRatio ) && $width == null  ){
			$imagePath = ffContainer()->getFileSystem()->findFileFromUrl( $image->url );

			if( file_exists( $imagePath ) ) {
				$dimensions = getimagesize( $imagePath );
				if( isset( $dimensions[0]) ) {
					$width = $dimensions[0];
				}
			}
		}

		if( $width != null ) {
			switch( $query->getColorWithoutComparationDefault('aspect-ratio', '') ) {
				case '1:1' :
					$height = $width;
					break;

				case '4:3' :
					$height = round(($width / 4) * 3);
					break;

				case '16:9' :
					$height = round(($width / 16) * 9);
					break;
			}
		}

		$imageQuality = $query->getWithoutComparationDefault('quality', 90 );

		if( (int)$this->getParam( ffBlImage::IMG_HAS_FORCED_WIDTH_AND_HEIGHT ) ){
			$width  = absint( $this->getParam('width' ) );
			$height = absint( $this->getParam('height') );
		}

		if( $width != null || $height != null ) {
			$imageUrl = fImg::resize( $imageUrl, $width, $height, true, false, false, $imageQuality);
		}

		$additionalCssClasses = '';
		$responsive = (int)$this->getParam( ffBlImage::IMG_IS_RESPONSIVE, 1);
		if( $query->getWithoutComparationDefault('responsive', $responsive ) ) { //$this->getParam( ffBlImage::IMG_IS_RESPONSIVE, false) ) {
			$additionalCssClasses = 'img-responsive';
		}

		$fullwidth = (int)$this->getParam( ffBlImage::IMG_IS_FULLWIDTH, 0);
		if( $query->getWithoutComparationDefault('fullwidth', $fullwidth ) ) {//$this->getParam( ffBlImage::IMG_IS_FULLWIDTH, false) ) {
			$additionalCssClasses = 'img-responsive full-width';
		}

		$alt = '';

		switch( $query->getWithoutComparationDefault('alt-type', 'title') ) {
			case 'title':
				if( $image->id != -1 ) {
					$post = get_post($image->id);
					if( !empty( $post ) ) {
						$alt = $post->post_title;
					}
				}
				break;
			case 'caption':
				if( $image->id != -1 ) {
					$post = get_post($image->id);
					if( !empty( $post ) ) {
						$alt = $post->post_excerpt;
					}
				}
				break;
			case 'description':
				if( $image->id != -1 ) {
					$post = get_post($image->id);
					if( !empty( $post ) ) {
						$alt = $post->post_content;
					}
				}
				break;
			default:
				$alt = $query->getWithoutComparationDefault('alt'); break;
		}

		if( empty( $alt ) and ( $image->id != -1 ) ){
			$alt = get_post_meta( $image->id, '_wp_attachment_image_alt', true);
		}

		$title = $query->getWithoutComparationDefault('title', '');

		if( $this->getParam( ffBlImage::RETURN_JSON_INSTEAD_IF_IMAGE ) ){
			if( empty($width) or empty($height) ){
				$imagePath = ffContainer()->getFileSystem()->findFileFromUrl( $image->url );
				if( file_exists( $imagePath ) ) {
					$dimensions = getimagesize( $imagePath );
					if( empty($width) and empty($height) ) {
						$width = $dimensions[0];
						$height = $dimensions[1];
					} else if( empty($width) ){
						$width = absint( $dimensions[0] / $dimensions[1] * $height );
					} else if( empty($height) ){
						$height = absint( $dimensions[1] / $dimensions[0] * $width );
					}
				}
			}
			echo json_encode(
					array(
						'width' => $width,
						'height' => $height,
						'img_url' => $query->getImage('img')->url,
						'img_html' => '<img'
							. ' class="fg-image '. esc_attr($this->getParam('css-class')) .' '. esc_attr($additionalCssClasses) .'"'
							. ' src="'. esc_url($imageUrl) .'"'
							. ' alt="'. esc_attr($alt) .'"'
							. ' title="'. esc_attr($title) .'"'
							. ' '. esc_attr($this->getParam('animation')) .'>',
					)
				);
			return;
		}

		if( $this->getParam('get-url') ) {
			echo esc_url($query->getImage('img')->url);
		} else {


			$imagePath = ffContainer()->getFileSystem()->findFileFromUrl( $imageUrl );
			if( !empty( $imagePath ) ) {
				$dimensions = getimagesize( $imagePath );
				$width = $dimensions[0];
			} else {
				$width = 1;
			}


			echo '<img';

			if( $width > 768 ){
				$srcset = array();
				$srcset[] = $imageUrl . ' ' . $width . 'w';
				$srcset[] = fImg::resize( $imageUrl, 320, null, true, false, true, 90) . ' 320w';
				$srcset[] = fImg::resize( $imageUrl, 768, null, true, false, true, 90) . ' 768w';
				if( $width > 992 ){
					$srcset[] = fImg::resize( $imageUrl, 992, null, true, false, true, 90) . ' 992w';
				}
				if( $width > 1200 ){
					$srcset[] = fImg::resize( $imageUrl, 1200, null, true, false, true, 90) . ' 1200w';
				}
				echo ' srcset="' . esc_attr( implode( ", ", $srcset) ) . '"';
				echo ' sizes="(max-width: '.$width.'px) 100vw, '.$width.'px"';
			}



			echo ' class="fg-image '. esc_attr($this->getParam('css-class')) .' '. esc_attr($additionalCssClasses) .'"';
			echo ' src="'. esc_url($imageUrl) .'"';
			echo ' alt="'. esc_attr($alt) .'"';
			echo ' title="'. esc_attr($title) .'"';
			echo ' '. esc_attr($this->getParam('animation')) .'';
			echo '>';
		}

	}



	protected function _renderContentInfo_JS() {
		?>
		<script data-type="ffscript">
			function ( query, params ) {
				var imgJSON = query.getWithoutComparationDefault('img', null);
				if( imgJSON != null ) {
					query.addImage('img');
				}
			}
		</script data-type="ffscript">
		<?php
	}

/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/
}