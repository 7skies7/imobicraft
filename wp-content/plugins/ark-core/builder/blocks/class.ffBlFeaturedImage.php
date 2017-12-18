<?php

class ffBlFeaturedImage extends ffThemeBuilderBlockBasic {
	const IMG_IS_RESPONSIVE = 'img_is_responsive';
	const IMG_IS_FULLWIDTH = 'img_is_fullwidth';
	const PARAM_MAX_WIDTH = 'max-width';
	const PARAM_FORCE_WIDTH = 'force-width'; // Porfolio Masonry
	const PARAM_FORCE_HEIGHT = 'force-height'; // Porfolio Masonry
	const PARAM_WITHOUT_IMG_LINK = 'without-img-link';

	const PARAM_POST_ID = 'post-id';
	const PARAM_IMAGE_ID = 'image-id';
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
		$this->_setInfo( ffThemeBuilderBlock::INFO_ID, 'featured-image');
		$this->_setInfo( ffThemeBuilderBlock::INFO_WRAPPING_ID, 'featured-img');
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

		$s->addOptionNL( ffOneOption::TYPE_SELECT, 'img-size', '', 'default')
			->addSelectValue( esc_attr( __('Default', 'ark' ) ), 'default')
			->addSelectValue( esc_attr( __('Original', 'ark' ) ), 'original')
			->addSelectValue( esc_attr( __('Custom', 'ark' ) ), 'custom')
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Image Size', 'ark' ) ) )
		;

		$s->startHidingBox('img-size', 'custom');

			$s->addOptionNL(ffOneOption::TYPE_TEXT, 'width', '', '')
				->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Width (in px)', 'ark' ) ) )
			;

			$s->addOptionNL(ffOneOption::TYPE_TEXT, 'height', '', '')
				->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Height (in px)', 'ark' ) ) )
			;

			if( $this->getParam( 'width', null) ||  $this->getParam( 'height', null) ){
				$width = $this->getParam( 'width', null);
				$height = $this->getParam( 'height', null);

				$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', ark_wp_kses( __('Default resizing values for this image are:', 'ark' ) ) );
				if( $width ) {
					$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', '<strong>'.ark_wp_kses( __('Width:', 'ark') ).' </strong> <code>'. $width .'</code> ' . ark_wp_kses( __('px', 'ark') ) );
				} else {
					$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', '<strong>'.ark_wp_kses( __('Width:', 'ark') ).' </strong> ' . ark_wp_kses( __('Undefined', 'ark') ) );
				}

				if( $height ) {
					$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', '<strong>'.ark_wp_kses( __('Width:', 'ark') ).' </strong> <code>'. $height .'</code> ' . ark_wp_kses( __('px', 'ark') ) );
				} else {
					$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', '<strong>'.ark_wp_kses( __('Width:', 'ark') ).' </strong> ' . ark_wp_kses( __('Undefined', 'ark') ) );
				}
			}

		$s->endHidingBox();

		$s->startHidingBox('img-size', array('default', 'custom'));
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
		$s->endHidingBox();


		$s->addOptionNL( ffOneOption::TYPE_SELECT, 'aspect-ratio', '', '')
			->addSelectValue('Original', '')
			->addSelectValue( esc_attr( __('1:1', 'ark' ) ), '1:1')
			->addSelectValue( esc_attr( __('4:3', 'ark' ) ), '4:3')
			->addSelectValue( esc_attr( __('16:9', 'ark' ) ), '16:9')
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Aspect Ratio', 'ark' ) ) )
		;

		
			$s->addElement(ffOneElement::TYPE_NEW_LINE);

			$s->addOptionNL( ffOneOption::TYPE_CHECKBOX,'responsive', ark_wp_kses( __('Image is Responsive', 'ark' ) ), 1);
			$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', ark_wp_kses( __('Prevents the image to be larger than it\'s container', 'ark' ) ) );

			$s->addElement(ffOneElement::TYPE_NEW_LINE);

			$s->addOptionNL( ffOneOption::TYPE_CHECKBOX,'fullwidth', ark_wp_kses( __('Image is Full Width', 'ark' ) ), 1);
			$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', ark_wp_kses( __('Forces the image to have the same width as it\'s container', 'ark' ) ) );

			$s->addElement(ffOneElement::TYPE_NEW_LINE);


		$s->addOptionNL(ffOneOption::TYPE_SELECT, 'alt-type', '', 'title')
			->addSelectValue( esc_attr( __('None', 'ark' ) ), '')
			->addSelectValue( esc_attr( __('Image Title', 'ark' ) ), 'title')
			->addSelectValue( esc_attr( __('Image Caption', 'ark' ) ), 'caption')
			->addSelectValue( esc_attr( __('Image Description', 'ark' ) ), 'description')
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Alt Attribute', 'ark' ) ) )
		;

		$s->addOptionNL(ffOneOption::TYPE_SELECT, 'title-type', '', 'caption')
			->addSelectValue( esc_attr( __('None', 'ark' ) ), '')
			->addSelectValue( esc_attr( __('Image Title', 'ark' ) ), 'title')
			->addSelectValue( esc_attr( __('Image Caption', 'ark' ) ), 'caption')
			->addSelectValue( esc_attr( __('Image Description', 'ark' ) ), 'description')
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Title Attribute', 'ark' ) ) )
		;

		$s->addOptionNL(ffOneOption::TYPE_TEXT, 'image-opacity', '', '')
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Opacity (0.00 - 1.00)', 'ark' ) ) )
		;

		if( !$this->getParam('without-img-link', false) ) {
			$s->addOptionNL(ffOneOption::TYPE_SELECT, 'img-usage', '', 'normal')
				->addSelectValue( esc_attr( __('No link', 'ark' ) ), 'normal')
				->addSelectValue( esc_attr( __('Single Post', 'ark' ) ), 'link')
				->addSelectValue( esc_attr( __('Lightbox - Featured Image', 'ark' ) ), 'lightbox')
				->addParam(ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Image Link', 'ark' ) ) );
		}

	}

	public function imgIsFullWidth() {
		$this->setParam( ffBlFeaturedImage::IMG_IS_FULLWIDTH, true );

		return $this;
	}

	public function imgIsResponsive() {
		$this->setParam( ffBlFeaturedImage::IMG_IS_RESPONSIVE, true );

		return $this;
	}

	public function withoutImgLink() {
		$this->setParam( ffBlFeaturedImage::PARAM_WITHOUT_IMG_LINK, true );

		return $this;
	}

	protected function _render( $query ) {
		if( !$this->getParam( ffBlFeaturedImage::PARAM_POST_ID ) && !$this->getParam(  ffBlFeaturedImage::PARAM_IMAGE_ID ) ) {
			// echo "\n\n\n\n\n\n\n\n\n\n\n\n FEATURED IMAGE OPTION NOT FILLED WITH DATA \n\n\n\n\n\n\n\n\n\n\n\n";
			return;
		}


		$postId = $this->getParam(  ffBlFeaturedImage::PARAM_POST_ID  );
		$featuredImageId = $this->getParam(  ffBlFeaturedImage::PARAM_IMAGE_ID  );

		if( $featuredImageId == null ) {
			$featuredImageId = get_post_thumbnail_id( $this->getParam( ffBlFeaturedImage::PARAM_POST_ID ) );
		} else {
			$postId = $featuredImageId;
		}


		$imageOriginalUrl = wp_get_attachment_url( $featuredImageId );
		$imageUrl = $imageOriginalUrl;

		$width = null;
		$height = null;

		if( empty( $imageOriginalUrl ) ) {
			return;
		}

		$additionalCssClasses = '';
		if ($this->getParam(ffBlFeaturedImage::IMG_IS_RESPONSIVE, false)) {
			$additionalCssClasses = 'img-responsive';
		}

		if ($this->getParam(ffBlFeaturedImage::IMG_IS_FULLWIDTH, false)) {
			$additionalCssClasses = 'img-responsive full-width';
		}

		switch( $query->getWithoutComparationDefault('img-size', 'default') ) {

			case 'default':
				$width = absint( $this->getParam('width') );
				$height = absint( $this->getParam('height') );
				break;

			case 'custom':
				$width = $query->getWithoutComparationDefault('width', null);
				$height = $query->getWithoutComparationDefault('height', null);

				if( $width == null ) {
					$width = absint( $this->getParam('width') );
					$height = absint( $this->getParam('height') );
				} else {
					$width = absint( $width );
					$height = absint( $height );
				}

//				$width = absint();
//				$height = absint($query->getWithoutComparationDefault('height', 0));


				break;
		}

		$aspectRatio = $query->getColorWithoutComparationDefault('aspect-ratio', '');
		$imageSize = $query->getWithoutComparationDefault('img-size', 'default');

		if( ($imageSize == 'original' && $aspectRatio != '') || $width == 0 ) {
			$imageDimensions = fImg::getImgSize( $imageUrl );

			// can we scan image width successfully?
			if( $imageDimensions != false && isset( $imageDimensions[0] ) ) {
				$width = $imageDimensions[0];
			} else {
				$aspectRatio = '';
			}
		}

		switch( $aspectRatio ) {
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

		// do we need to enforce max width parameter?
		if( $this->getParam( ffBlFeaturedImage::PARAM_MAX_WIDTH, false ) ) {
			$maxWidth = $this->getParam( ffBlFeaturedImage::PARAM_MAX_WIDTH, false );
			$imageDimensions = fImg::getImgSize( $imageUrl );

			// can we scan image width successfully?
			if( $imageDimensions != false && isset( $imageDimensions[0] ) ) {
				$imageWidth = $imageDimensions[0];

				// is the max width actually bigger?
				if( $imageWidth > $maxWidth ) {
					$width =  $maxWidth;
				}
            }
		}

		if( $this->getParam( ffBlFeaturedImage::PARAM_FORCE_WIDTH, false ) ) {
			$forceWidth = absint( $this->getParam( ffBlFeaturedImage::PARAM_FORCE_WIDTH, false ) );
			if( $forceWidth ){
				$width = $forceWidth;
			}
		}

		if( $this->getParam( ffBlFeaturedImage::PARAM_FORCE_HEIGHT, false ) ) {
			$forceHeight = absint( $this->getParam( ffBlFeaturedImage::PARAM_FORCE_HEIGHT, false ) );
			if( $forceHeight ){
				$height = $forceHeight;
			}
		}


		if( !empty( $width ) || !empty( $height ) ) {

			$imageQuality = $query->getWithoutComparationDefault('quality', 90 );
			$imageUrl = fImg::resize($imageOriginalUrl, $width, $height, true, false, false, $imageQuality);
		}


		if( $this->getParam('get-url') ) {
			return esc_url($imageUrl);
		}

		$style = '';
		if( $query->getWithoutComparationDefault('image-opacity') ) {
			$style = 'style="opacity:' . $query->getWithoutComparationDefault('image-opacity') . '"';
		}


		$additionalCssClasses = '';
		if( $query->getWithoutComparationDefault('responsive', 1 ) ) {
			$additionalCssClasses = ' img-responsive';
		}

		if( $query->getWithoutComparationDefault('fullwidth', 1 ) ) {
			$additionalCssClasses = ' img-responsive full-width';
		}


		$imagePost = get_post($featuredImageId);

//		var_Dump( $imagePost );


		/*----------------------------------------------------------*/
		/* ALT
		/*----------------------------------------------------------*/
		$alt = '';
		switch( $query->getWithoutComparationDefault('alt-type', 'title') ) {
			case 'title':
				$post = get_post($imagePost);
				if( !empty( $post ) ) {
					$alt = $post->post_title;
				}
				break;
			case 'caption':
				$post = get_post($imagePost);
				if( !empty( $post ) ) {
					$alt = $post->post_excerpt;
				}
				break;
			case 'description':
				$post = get_post($imagePost);
				if( !empty( $post ) ) {
					$alt = $post->post_content;
				}
				break;
		}

		if( !empty( $alt ) ) {
			$alt = ' alt="' . $alt. '"';
		}


		/*----------------------------------------------------------*/
		/* TITLE
		/*----------------------------------------------------------*/
		$title = '';
		switch( $query->getWithoutComparationDefault('title-type', 'caption') ) {
			case 'title':
				$post = get_post($imagePost);
				if( !empty( $post ) ) {
					$title = $post->post_title;
				}
				break;
			case 'caption':
				$post = get_post($imagePost);
				if( !empty( $post ) ) {
					$title = $post->post_excerpt;
				}
				break;
			case 'description':
				$post = get_post($imagePost);
				if( !empty( $post ) ) {
					$title = $post->post_content;
				}
				break;
		}

		if( !empty( $title ) ) {
			$title = ' title="' . $title. '"';
		}

		$img_usage = $query->getWithoutComparationDefault('img-usage', 'normal');


		/* LINK TAG START */

		switch( $img_usage ) {
			case 'link':
				echo '<a href="'. esc_url( get_permalink( $postId ) ) .'" class="ff-post-featured-image-link-wrapper">';
				break;
			case 'lightbox':
				echo '<a class="news-v12-video-link ff-post-featured-image-link-wrapper image-popup-up radius-circle" href="'. esc_url( $imageOriginalUrl ) .'">';
				break;
		}


		/* IMAGE */


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





		echo ' class="' . esc_attr($this->getParam('css-class') . $additionalCssClasses) . ' ' . esc_attr($additionalCssClasses) . ' ff-post-featured-image"';
		echo ' '.$style.'';
		echo ' src="' . esc_url($imageUrl) . '"';
		echo ' '.$alt . $title.'>';


		/* LINK TAG CLOSE */

		switch( $img_usage ) {
			case 'link':
			case 'lightbox':
				echo '</a>';
				break;
		}
	}

	protected function _renderContentInfo_JS() {
		?>
		<script data-type="ffscript">
			function ( query, params ) {

			}
		</script data-type="ffscript">
		<?php
	}

/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/
}