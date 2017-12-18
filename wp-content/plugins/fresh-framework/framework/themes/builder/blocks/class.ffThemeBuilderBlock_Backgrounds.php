<?php

class ffThemeBuilderBlock_Backgrounds extends ffThemeBuilderBlockBasic {
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/
//	const PARAM_RETURN_AS_STRING = 'return_as_string';
//	const PARAM_WRAP_BY_MODAL = 'wrap_by_modal';
//	const PARAM_CSS_CLASS = 'css_class';
/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
	protected function _init() {
		$this->_setInfo( ffThemeBuilderBlock::INFO_ID, 'backgrounds');
		$this->_setInfo( ffThemeBuilderBlock::INFO_WRAPPING_ID, 'bg');
		$this->_setInfo( ffThemeBuilderBlock::INFO_WRAP_AUTOMATICALLY, true);
		$this->_setInfo( ffThemeBuilderBlock::INFO_IS_REFERENCE_SECTION, true);
		$this->_setInfo( ffThemeBuilderBlock::INFO_SAVE_ONLY_DIFFERENCE, true);
	}
/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/
//	public function wrapByModal() {
//		$this->setParam( ffThemeBuilderBlock_AdvancedTools::PARAM_WRAP_BY_MODAL, true );
//		return $this;
//	}
/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/
	protected function _render( $query ) {


		$allBackgrounds = array();

		$breakpoints = array('xs','sm','md','lg');
		if( $query->queryExists('bg') ) {



			foreach ($query->get('bg') as $oneLayer) {
				$oneBackground = array();
				switch ($oneLayer->getVariationType()) {
					case 'color':
						$oneBackground['type'] = 'color';
						$oneBackground['opacity'] = $oneLayer->getWithoutComparationDefault('opacity', 1);
						$oneBackground['color'] = $oneLayer->getColorWithoutComparationDefault('bg-color', '#f7f8fa');
						foreach ($breakpoints as $bp) {
							if ($oneLayer->getWithoutComparationDefault($bp)) {
								$oneBackground['hidden_' . $bp] = 'yes';
							}
						}
						if ($oneLayer->getWithoutComparation('hover-only', 0)) {
							$oneBackground['hover_only'] = 'yes';
						}
						break;

					case 'gradient-external':

//						$oneBackground['pica'] = 'pica';
						$oneBackground['type'] = 'gradient';
						$oneBackground['gradient'] = $oneLayer->getWithoutComparationDefault('gradient', '');
						$oneBackground['opacity'] = $oneLayer->getWithoutComparationDefault('opacity', 1);
						foreach ($breakpoints as $bp) {
							if ($oneLayer->getWithoutComparationDefault($bp)) {
								$oneBackground['hidden_' . $bp] = 'yes';
							}
						}
//						$oneBackground['position'] = $oneLayer->getWithoutComparationDefault('bgpos', 'center center');
						if ($oneLayer->getWithoutComparation('hover-only', 0)) {
							$oneBackground['hover_only'] = 'yes';
						}

						break;

					case 'image':
						$oneBackground['type'] = 'image';
						$oneBackground['opacity'] = $oneLayer->getWithoutComparationDefault('opacity', '1');
						$oneBackground['url'] = $oneLayer->getImage('image')->url;

						if( $oneLayer->getWithoutComparationDefault('use-featured-image') ){
//							if( is_singular() ){
								$img = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
								if( !empty( $img ) ){
									$oneBackground['url'] = $img[0];
								}
//							}
						}

						$oneBackground['size'] = $oneLayer->getWithoutComparationDefault('size', 'cover');
						$oneBackground['repeat'] = $oneLayer->getWithoutComparationDefault('repeat', 'no-repeat');
						$oneBackground['attachment'] = $oneLayer->getWithoutComparationDefault('attachment', 'scroll');

						foreach ($breakpoints as $bp) {
							if ($oneLayer->getWithoutComparationDefault($bp)) {
								$oneBackground['hidden_' . $bp] = 'yes';
							}
						}
						$oneBackground['position'] = $oneLayer->getWithoutComparationDefault('bgpos', 'center center');
						if ($oneLayer->getWithoutComparation('hover-only', 0)) {
							$oneBackground['hover_only'] = 'yes';
						}
						break;

					case 'video':
						$oneBackground['type'] = 'video';
						$oneBackground['opacity'] = $oneLayer->getWithoutComparationDefault('opacity', '1');
						$oneBackground['variant'] = $oneLayer->getWithoutComparationDefault('variant', 'youtube');
						$oneBackground['url'] = $oneLayer->getWithoutComparationDefault('url');
						$oneBackground['width'] = $oneLayer->getWithoutComparationDefault('width', '16');
						$oneBackground['height'] = $oneLayer->getWithoutComparationDefault('height', '9');

						foreach ($breakpoints as $bp) {
							if ($oneLayer->getWithoutComparationDefault($bp)) {
								$oneBackground['hidden_' . $bp] = 'yes';
							}
						}
						if ($oneLayer->getWithoutComparation('hover-only', 0)) {
							$oneBackground['hover_only'] = 'yes';
						}
						if ($oneLayer->getWithoutComparationDefault('shield-on', 1)) {
							$oneBackground['shield'] = 'on';
						}
						if ($oneLayer->getWithoutComparationDefault('has-sound', 0)) {
							$oneBackground['sound'] = 'on';
						}
						break;

					case 'slant':
						$oneBackground['type'] = 'slant';
						$oneBackground['opacity'] = $oneLayer->getWithoutComparationDefault('opacity', '1');
						$oneBackground['color'] = $oneLayer->getColorWithoutComparationDefault('slant-color', '#ffffff');
						$oneBackground['edge'] = $oneLayer->getWithoutComparationDefault('edge', 'top');
						$oneBackground['direction'] = $oneLayer->getWithoutComparationDefault('direction', 'up');
						$oneBackground['angle'] = $oneLayer->getWithoutComparationDefault('angle', '15');

						foreach ($breakpoints as $bp) {
							if ($oneLayer->getWithoutComparationDefault($bp)) {
								$oneBackground['hidden_' . $bp] = 'yes';
							}
						}
						if ($oneLayer->getWithoutComparation('hover-only', 0)) {
							$oneBackground['hover_only'] = 'yes';
						}
						break;

					case 'parallax':
						$oneBackground['type'] = 'parallax';
						$oneBackground['url'] = $oneLayer->getImage('image')->url;
						if( $oneLayer->getWithoutComparationDefault('use-featured-image') ){
							// if( is_singular() ){
								$img = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
								if( !empty( $img ) ){
									$oneBackground['url'] = $img[0];
								}
							// }
						}
						$size = fImg::getImgSize( $oneBackground['url'] );

						$oneBackground['opacity'] = $oneLayer->getWithoutComparationDefault('opacity', '1');
						$oneBackground['width'] = '' . $size[0] . '';
						$oneBackground['height'] = '' . $size[1] . '';
						$oneBackground['speed'] = $oneLayer->getWithoutComparationDefault('speed', '50');
						$oneBackground['size'] = $oneLayer->getWithoutComparationDefault('size', 'cover');
						
						$oneBackground['offset_h'] = $oneLayer->getWithoutComparationDefault('h', '50');
						$oneBackground['offset_v'] = $oneLayer->getWithoutComparationDefault('v', '50');

						foreach ($breakpoints as $bp) {
							if ($oneLayer->getWithoutComparationDefault($bp)) {
								$oneBackground['hidden_' . $bp] = 'yes';
							}
						}
						if ($oneLayer->getWithoutComparation('hover-only', 0)) {
							$oneBackground['hover_only'] = 'yes';
						}
						break;
				}

				if ($oneLayer->getWithoutComparation('php-mode', 0) ) {

					$phpCode = $oneLayer->getWithoutComparation('php-code', '');


					if( !empty( $phpCode ) ) {

						eval( $phpCode );

//						$oneBackground['color'] = 'pink';
//						var_dump( $phpCode, $oneBackground );
//						die();
					}
				}

				$allBackgrounds[] = $oneBackground;
			}
		}

		if( !empty( $allBackgrounds ) ) {

			$element = $this->_getAssetsRenderer()->getElementHelper();
			$backgroundsJson = json_encode($allBackgrounds);
			$backgroundsJson = htmlspecialchars($backgroundsJson);
//			$backgroundsJson = str_replace('&quot;',"'",$backgroundsJson);

			$element->setAttribute('data-fg-bg', $backgroundsJson );
		}
	}


	protected function _renderContentInfo_JS() {
		?>
		<script data-type="ffscript">
			function ( query ) {
				console.log('backgroundBlock');
			}
		</script data-type="ffscript">
		<?php
	}


	protected function _injectOptions( ffThemeBuilderOptionsExtender $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', 'Background Layers');

			$s->startSection('bg', ffOneSection::TYPE_REPEATABLE_VARIABLE )
				->addParam('can-be-empty', true)
				->addParam('work-as-accordion', true)
				->addParam('all-items-opened', true)
			;

				/*----------------------------------------------------------*/
				/* BG COLOR
				/*----------------------------------------------------------*/
				$s->startSection('color', ffOneSection::TYPE_REPEATABLE_VARIATION)
					->addParam('section-name', 'Color')
					->addParam('hide-default', true)
				;

					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', '#f7f8fa')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ('Background Color'));
					$s->addElement(ffOneElement::TYPE_NEW_LINE,'');

					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'opacity', '', 1)
						->addParam('short', true)
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ('Opacity (0.00 - 1.00)'))
					;
					// $s->addElement(ffOneElement::TYPE_DESCRIPTION,'','Opacity can be between <code>0</code> and <code>1</code>, with a step of <code>0.01</code>. Valid example: <code>0.57</code>');
					$s->addElement(ffOneElement::TYPE_NEW_LINE,'');

					$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'hover-only', 'Show only on hover', 0);
					$s->addElement(ffOneElement::TYPE_NEW_LINE,'');


					$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'xs', 'Hide on Phone (XS)', 0);
					$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'sm', 'Hide on Tablet (SM)', 0);
					$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'md', 'Hide on Laptop (MD)', 0);
					$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'lg', 'Hide on Desktop (LG)', 0);


					$s->addElement(ffOneElement::TYPE_NEW_LINE,'');
					$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'php-mode', 'Influence background with PHP (e.g. for ACF)', 0);

					$s->startHidingBox('php-mode','checked');
						$s->addElement(ffOneElement::TYPE_DESCRIPTION,'','You can access the variables in code like this: <code>$oneBackground["color"] = "#fff";</code> or <code>$oneBackground["color"] = get_field("your_acf_field_name");</code> Thats all you need to do for changing the value. </code><br> List of accessible variables: color, opacity');
						$s->addElement(ffOneElement::TYPE_NEW_LINE,'');
						$s->addElement(ffOneElement::TYPE_DESCRIPTION,'','<span style="color:red;">Tricky Part: All elements are cached, including backgrounds. You need to insert this element inside "Wrapper" and disable caching in the wrapper settings </span>');
						$s->addOption(ffOneOption::TYPE_TEXTAREA_STRICT, 'php-code', '', '')
							->addParam('no-wrapping', true)
							->addParam( ffOneOption::PARAM_CODE_EDITOR, 'php')
						;
					$s->endHidingBox();

				$s->endSection();

				/*----------------------------------------------------------*/
				/* GRADIENT
				/*----------------------------------------------------------*/
				$s->startSection('gradient-external', ffOneSection::TYPE_REPEATABLE_VARIATION)
					->addParam('section-name', 'Gradient')
					->addParam('hide-default', true)
				;

					$s->addElement(ffOneElement::TYPE_DESCRIPTION, '', 'NOTE: Copy&Paste the code by this gradient generator <a href="http://www.colorzilla.com/gradient-editor/" target="_blank">http://www.colorzilla.com/gradient-editor/</a>');
					$s->addElement(ffOneElement::TYPE_NEW_LINE,'');
					$s->addOptionNL( ffOneOption::TYPE_TEXTAREA_STRICT, 'gradient', '', '')
					;
//					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', '#f7f8fa')
//						->addParam( ffOneOption::PARAM_TITLE_AFTER, ('Background Color'));


					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'opacity', '', 1)
						->addParam('short', true)
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ('Opacity (0.00 - 1.00)'))
					;
					// $s->addElement(ffOneElement::TYPE_DESCRIPTION,'','Opacity can be between <code>0</code> and <code>1</code>, with a step of <code>0.01</code>. Valid example: <code>0.57</code>');
					$s->addElement(ffOneElement::TYPE_NEW_LINE,'');

					$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'hover-only', 'Show only on hover', 0);
					$s->addElement(ffOneElement::TYPE_NEW_LINE,'');

					$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'xs', 'Hide on Phone (XS)', 0);
					$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'sm', 'Hide on Tablet (SM)', 0);
					$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'md', 'Hide on Laptop (MD)', 0);
					$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'lg', 'Hide on Desktop (LG)', 0);

					$s->addElement(ffOneElement::TYPE_NEW_LINE,'');
					$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'php-mode', 'Influence background with PHP (e.g. for ACF)', 0);

					$s->startHidingBox('php-mode','checked');
						$s->addElement(ffOneElement::TYPE_DESCRIPTION,'','You can access the variables in code like this: <code>$oneBackground["gradient"] = "";</code> or <code>$oneBackground["gradient"] = get_field("your_acf_field_name");</code> Thats all you need to do for changing the value. </code><br> List of accessible variables: gradient, opacity');
						$s->addElement(ffOneElement::TYPE_NEW_LINE,'');
						$s->addElement(ffOneElement::TYPE_DESCRIPTION,'','<span style="color:red;">Tricky Part: All elements are cached, including backgrounds. You need to insert this element inside "Wrapper" and disable caching in the wrapper settings </span>');
						$s->addOption(ffOneOption::TYPE_TEXTAREA_STRICT, 'php-code', '', '')
							->addParam('no-wrapping', true)
							->addParam( ffOneOption::PARAM_CODE_EDITOR, 'php')
						;
					$s->endHidingBox();

				$s->endSection();

				/*----------------------------------------------------------*/
				/* IMAGE
				/*----------------------------------------------------------*/
				$s->startSection('image', ffOneSection::TYPE_REPEATABLE_VARIATION)
					->addParam('section-name', 'Image')
					->addParam('hide-default', true)
				;

					$s->addOptionNL( ffOneOption::TYPE_IMAGE, 'image', 'Background image', '');
					$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'use-featured-image', 'Use Featured Image instead (if available)', 0 );
					$s->addElement(ffOneElement::TYPE_NEW_LINE,'');

					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'opacity', '', 1)
						->addParam('short', true)
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ('Opacity (0.00 - 1.00)'))
					;
					// $s->addElement(ffOneElement::TYPE_DESCRIPTION,'','Opacity can be between <code>0</code> and <code>1</code>, with a step of <code>0.01</code>. Valid example: <code>0.57</code>');
					$s->addElement(ffOneElement::TYPE_NEW_LINE,'');

					$s->addOptionNL( ffOneOption::TYPE_SELECT, 'size', '', 'cover')
						->addSelectValue('cover', 'cover')
						->addSelectValue('auto', 'auto')
						->addSelectValue('contain', 'contain')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, 'Background size')
					;

					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'bgpos', '', 'center center')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ('Background position'))
					;

					$s->addOptionNL( ffOneOption::TYPE_SELECT, 'repeat', '', 'no-repeat')
						->addSelectValue('no-repeat', 'no-repeat')
						->addSelectValue('repeat', 'repeat')
						->addSelectValue('repeat-x', 'repeat-x')
						->addSelectValue('repeat-y', 'repeat-y')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, 'Background repeat')
					;

					$s->addOptionNL( ffOneOption::TYPE_SELECT, 'attachment', '', 'scroll')
						->addSelectValue('scroll', 'scroll')
						->addSelectValue('fixed', 'fixed')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, 'Background attachment')
					;
					$s->addElement(ffOneElement::TYPE_NEW_LINE,'');

					$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'hover-only', 'Show only on hover', 0);
					$s->addElement(ffOneElement::TYPE_NEW_LINE,'');

					$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'xs', 'Hide on Phone (XS)', 0);
					$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'sm', 'Hide on Tablet (SM)', 0);
					$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'md', 'Hide on Laptop (MD)', 0);
					$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'lg', 'Hide on Desktop (LG)', 0);

					$s->addElement(ffOneElement::TYPE_NEW_LINE,'');
					$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'php-mode', 'Influence background with PHP (e.g. for ACF)', 0);

					$s->startHidingBox('php-mode','checked');
						$s->addElement(ffOneElement::TYPE_DESCRIPTION,'','You can access the variables in code like this: <code>$oneBackground["url"] = "http://yourimageurl.com";</code> or <code>$oneBackground["url"] = get_field("your_acf_field_name");</code> Thats all you need to do for changing the value. </code><br> List of accessible variables: url, opacity');
						$s->addElement(ffOneElement::TYPE_NEW_LINE,'');
						$s->addElement(ffOneElement::TYPE_DESCRIPTION,'','<span style="color:red;">Tricky Part: All elements are cached, including backgrounds. You need to insert this element inside "Wrapper" and disable caching in the wrapper settings </span>');
						$s->addOption(ffOneOption::TYPE_TEXTAREA_STRICT, 'php-code', '', '')
							->addParam('no-wrapping', true)
							->addParam( ffOneOption::PARAM_CODE_EDITOR, 'php')
						;
					$s->endHidingBox();

				$s->endSection();

				/*----------------------------------------------------------*/
				/* VIDEO
				/*----------------------------------------------------------*/
				$s->startSection('video', ffOneSection::TYPE_REPEATABLE_VARIATION)
					->addParam('section-name', 'Video')
					->addParam('hide-default', true)
				;

					$s->addOptionNL( ffOneOption::TYPE_SELECT, 'variant', '', 'youtube')
						->addSelectValue('YouTube', 'youtube')
						->addSelectValue('Local Video File (.mp4, .webm)', 'html')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, 'Video source')
					;

					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'url', '', '')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ('URL of YouTube video or Local Video File'))
					;
					$s->addElement(ffOneElement::TYPE_NEW_LINE,'');

					$s->addElement(ffOneElement::TYPE_DESCRIPTION, '', 'NOTE: Only the "Local Video File" backgrounds are supported by mobiles/tablets. YouTube video backgrounds will not be shown on mobiles/tablets.');
					$s->addElement(ffOneElement::TYPE_NEW_LINE,'');

					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'opacity', '', 1)
						->addParam('short', true)
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ('Opacity (0.00 - 1.00)'))
					;
					// $s->addElement(ffOneElement::TYPE_DESCRIPTION,'','Opacity can be between <code>0</code> and <code>1</code>, with a step of <code>0.01</code>. Valid example: <code>0.57</code>');
					$s->addElement(ffOneElement::TYPE_NEW_LINE,'');

					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'width', '', 16)
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ('Aspect Ratio Width'))
						->addParam('short', true)
					;
					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'height', '', 9)
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ('Aspect Ratio Height'))
						->addParam('short', true)
					;
					$s->addElement(ffOneElement::TYPE_NEW_LINE,'');

					$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'shield-on', 'Prevent clicking on/interacting with the video', 1);
					$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'has-sound', 'Play sound', 0);
					$s->addElement(ffOneElement::TYPE_NEW_LINE,'');

					$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'hover-only', 'Show only on hover', 0);
					$s->addElement(ffOneElement::TYPE_NEW_LINE,'');
					$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'xs', 'Hide on Phone (XS)', 0);
					$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'sm', 'Hide on Tablet (SM)', 0);

					$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'md', 'Hide on Laptop (MD)', 0);
					$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'lg', 'Hide on Desktop (LG)', 0);

					$s->addElement(ffOneElement::TYPE_NEW_LINE,'');
					$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'php-mode', 'Influence background with PHP (e.g. for ACF)', 0);

					$s->startHidingBox('php-mode','checked');
						$s->addElement(ffOneElement::TYPE_DESCRIPTION,'','You can access the variables in code like this: <code>$oneBackground["url"] = "http://yourvideourl.com";</code> or <code>$oneBackground["url"] = get_field("your_acf_field_name");</code> Thats all you need to do for changing the value. </code><br> List of accessible variables: opacity, variant, url, width, heigth');
						$s->addElement(ffOneElement::TYPE_NEW_LINE,'');
						$s->addElement(ffOneElement::TYPE_DESCRIPTION,'','<span style="color:red;">Tricky Part: All elements are cached, including backgrounds. You need to insert this element inside "Wrapper" and disable caching in the wrapper settings </span>');
						$s->addOption(ffOneOption::TYPE_TEXTAREA_STRICT, 'php-code', '', '')
							->addParam('no-wrapping', true)
							->addParam( ffOneOption::PARAM_CODE_EDITOR, 'php')
						;
					$s->endHidingBox();

				$s->endSection();


				/*----------------------------------------------------------*/
				/* SLANT
				/*----------------------------------------------------------*/
				$s->startSection('slant', ffOneSection::TYPE_REPEATABLE_VARIATION)
					->addParam('section-name', 'Slant')
					->addParam('hide-default', true)
				;

					$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'slant-color', '', '#ffffff')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ('Slant Color'));
					$s->addElement(ffOneElement::TYPE_NEW_LINE,'');

					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'opacity', '', 1)
						->addParam('short', true)
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ('Opacity (0.00 - 1.00)'))
					;
					// $s->addElement(ffOneElement::TYPE_DESCRIPTION,'','Opacity can be between <code>0</code> and <code>1</code>, with a step of <code>0.01</code>. Valid example: <code>0.57</code>');
					$s->addElement(ffOneElement::TYPE_NEW_LINE,'');

					$s->addOptionNL( ffOneOption::TYPE_SELECT, 'edge', '', 'top')
						->addSelectValue('Top', 'top')
						->addSelectValue('Right', 'right')
						->addSelectValue('Bottom', 'bottom')
						->addSelectValue('Left', 'left')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, 'Edge')
					;
					$s->addElement(ffOneElement::TYPE_DESCRIPTION,'','Choose the edge of the Element on which you want the Slant to be');
					$s->addElement(ffOneElement::TYPE_NEW_LINE,'');

					$s->addOptionNL( ffOneOption::TYPE_SELECT, 'direction', '', 'up')
						->addSelectValue('Up', 'up')
						->addSelectValue('Down', 'down')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, 'Direction')
					;
					$s->addElement(ffOneElement::TYPE_DESCRIPTION,'','Choose if you want the Slant to be an upwards or downwards slope');
					$s->addElement(ffOneElement::TYPE_NEW_LINE,'');

					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'angle', '', 15)
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ('Angle'))
					;
					$s->addElement(ffOneElement::TYPE_DESCRIPTION,'','The angle of the Slant, must be between <code>0</code> and <code>90</code>');
					$s->addElement(ffOneElement::TYPE_NEW_LINE,'');

					$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'hover-only', 'Show only on hover', 0);
					$s->addElement(ffOneElement::TYPE_NEW_LINE,'');

					$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'xs', 'Hide on Phone (XS)', 0);
					$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'sm', 'Hide on Tablet (SM)', 0);
					$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'md', 'Hide on Laptop (MD)', 0);
					$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'lg', 'Hide on Desktop (LG)', 0);

					$s->addElement(ffOneElement::TYPE_NEW_LINE,'');
					$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'php-mode', 'Influence background with PHP (e.g. for ACF)', 0);

					$s->startHidingBox('php-mode','checked');
						$s->addElement(ffOneElement::TYPE_DESCRIPTION,'','You can access the variables in code like this: <code>$oneBackground["opacity"] = "1";</code> or <code>$oneBackground["opacity"] = get_field("your_acf_field_name");</code> Thats all you need to do for changing the value. </code><br> List of accessible variables: opacity, color, edge, direction, angle');
						$s->addElement(ffOneElement::TYPE_NEW_LINE,'');
						$s->addElement(ffOneElement::TYPE_DESCRIPTION,'','<span style="color:red;">Tricky Part: All elements are cached, including backgrounds. You need to insert this element inside "Wrapper" and disable caching in the wrapper settings </span>');
						$s->addOption(ffOneOption::TYPE_TEXTAREA_STRICT, 'php-code', '', '')
							->addParam('no-wrapping', true)
							->addParam( ffOneOption::PARAM_CODE_EDITOR, 'php')
						;
					$s->endHidingBox();

				$s->endSection();

				$s->startSection('parallax', ffOneSection::TYPE_REPEATABLE_VARIATION)
					->addParam('section-name', 'Parallax')
					->addParam('hide-default', true)
				;

					$s->addOptionNL( ffOneOption::TYPE_IMAGE, 'image', 'Background image', '');
					$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'use-featured-image', 'Use Featured Image instead (if available)', 0 );
					$s->addElement(ffOneElement::TYPE_NEW_LINE,'');

					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'opacity', '', 1)
						->addParam('short', true)
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ('Opacity (0.00 - 1.00)'))
					;
					// $s->addElement(ffOneElement::TYPE_DESCRIPTION,'','Opacity can be between <code>0</code> and <code>1</code>, with a step of <code>0.01</code>. Valid example: <code>0.57</code>');
					$s->addElement(ffOneElement::TYPE_NEW_LINE,'');

					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'speed', 'Parallax speed', 50)
						->addParam('short', true)
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ('%'))
					;
					$s->addElement(ffOneElement::TYPE_DESCRIPTION,'','Parallax speed must be between <code>0</code> and <code>100</code> %');
					$s->addElement(ffOneElement::TYPE_NEW_LINE,'');

					$s->addOptionNL( ffOneOption::TYPE_SELECT, 'size', '', 'cover')
						->addSelectValue('cover', 'cover')
						->addSelectValue('auto', 'auto')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, 'Background size')
					;
					$s->addElement(ffOneElement::TYPE_DESCRIPTION,'','Use <code>cover</code> if you want the image to cover the whole element. But if you want a non-resized standalone image that can be moved around using the position settings (found below) then use <code>auto</code>');
					$s->addElement(ffOneElement::TYPE_NEW_LINE,'');

					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'h', 'Horizontal position', 50)
						->addParam('short', true)
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ('%'))
					;
					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'v', 'Vertical position', 50)
						->addParam('short', true)
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ('%'))
					;
					$s->addElement(ffOneElement::TYPE_DESCRIPTION,'','Position settings will be used only when the <strong>"Background size"</strong> option above is set to <code>auto</code>. Must be between <code>0</code> and <code>100</code> %');
					$s->addElement(ffOneElement::TYPE_NEW_LINE,'');

					$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'hover-only', 'Show only on hover', 0);
					$s->addElement(ffOneElement::TYPE_NEW_LINE,'');

					$s->addElement(ffOneElement::TYPE_DESCRIPTION, '', 'Due to lack of CSS support and extensive usage of CPU, parallax does not works on mobile phone and tablet. They will transform to classic background image.');
					$s->addElement(ffOneElement::TYPE_NEW_LINE,'');

					$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'xs', 'Hide on Phone (XS)', 0);
					$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'sm', 'Hide on Tablet (SM)', 0);
					$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'md', 'Hide on Laptop (MD)', 0);
					$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'lg', 'Hide on Desktop (LG)', 0);

					$s->addElement(ffOneElement::TYPE_NEW_LINE,'');
					$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'php-mode', 'Influence background with PHP (e.g. for ACF)', 0);

					$s->startHidingBox('php-mode','checked');
						$s->addElement(ffOneElement::TYPE_DESCRIPTION,'','You can access the variables in code like this: <code>$oneBackground["opacity"] = "1";</code> or <code>$oneBackground["opacity"] = get_field("your_acf_field_name");</code> Thats all you need to do for changing the value. </code><br> List of accessible variables: opacity, width, height, speed, size, offset_h, offset_v');
						$s->addElement(ffOneElement::TYPE_NEW_LINE,'');
						$s->addElement(ffOneElement::TYPE_DESCRIPTION,'','<span style="color:red;">Tricky Part: All elements are cached, including backgrounds. You need to insert this element inside "Wrapper" and disable caching in the wrapper settings </span>');
						$s->addOption(ffOneOption::TYPE_TEXTAREA_STRICT, 'php-code', '', '')
							->addParam('no-wrapping', true)
							->addParam( ffOneOption::PARAM_CODE_EDITOR, 'php')
						;
					$s->endHidingBox();
				$s->endSection();

			$s->endSection();

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);
	}

/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/
}