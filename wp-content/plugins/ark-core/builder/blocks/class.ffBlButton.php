<?php

class ffBlButton extends ffThemeBuilderBlockBasic {
	const PARAM_USE_URL = 'use-custom-url';
	const PARAM_WITHOUT_URL = 'no-link-options';
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
		$this->_setInfo( ffThemeBuilderBlock::INFO_ID, 'button');
		$this->_setInfo( ffThemeBuilderBlock::INFO_WRAPPING_ID, 'btn');
		$this->_setInfo( ffThemeBuilderBlock::INFO_WRAP_AUTOMATICALLY, true);
		$this->_setInfo( ffThemeBuilderBlock::INFO_IS_REFERENCE_SECTION, true);
		$this->_setInfo( ffThemeBuilderBlock::INFO_SAVE_ONLY_DIFFERENCE, true);
		$this->_setInfo( ffThemeBuilderBlock::INFO_APPLY_CALLBACKS, true);
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


	protected function _render( $query ){

		$cssClass = $this->getParam('css-class');

		$buttons = $query->getWithoutComparation('button');

		if( empty($buttons) ){
			return;
		}

		foreach ($buttons as $key => $oneItem) {

			$toPrint = '';
			$uniqueCssClass = $this->_getUniqueCssClass() .'-'. $key;

			$margin = '';
			if ($oneItem->getWithoutComparationDefault('use-r-margin',0)) {
				$margin = 'ff-button-block-margin-r';
			}

			switch ($oneItem->getVariationType()) {

				case 'button1':

					$buttonClasses = $uniqueCssClass.' ffb-btn ffb-btn-v1 ffb-btn-link '.$cssClass.' btn-base-brd-slide btn-slide ' . $oneItem->getWithoutComparationDefault('radius','') . ' btn-base-' . $oneItem->getWithoutComparationDefault('size','sm') . ' ' . $oneItem->getWithoutComparationDefault('hover-animation','') . ' ' . $margin . '  ' . $oneItem->getWithoutComparationDefault('width','');

					if( !$this->getParam(self::PARAM_USE_URL) ){
						$toPrint .= '<a ';
							$toPrint .= $this->_getBlock(ffThemeBuilderBlock::LINK)->setParam(ffThemeBuilderBlock_Link::PARAM_TARGET, 'same')->setParam('classes', $buttonClasses)->get($oneItem);
						$toPrint .= '>';
					} else {
						$toPrint .= '<a class="'.$buttonClasses.'" href="'. $this->getParam( self::PARAM_USE_URL) .'">';
					}

						if ($oneItem->getColorWithoutComparationDefault('text-color','[1]')) {
								$this->_getAssetsRenderer()->createCssRule()
							->setAddWhiteSpaceBetweenSelectors(false)
								->addSelector('.'.$uniqueCssClass.'.btn-base-brd-slide')
								->addParamsString('color:' . $oneItem->getColorWithoutComparationDefault('text-color','[1]') . ';');
						}

						if ($oneItem->getColorWithoutComparationDefault('text-hover-color','#ffffff')) {
							$this->_getAssetsRenderer()->createCssRule()
								->setAddWhiteSpaceBetweenSelectors(false)
								->addSelector('.'.$uniqueCssClass.'.btn-base-brd-slide:hover')
								->addParamsString('color:' . $oneItem->getColorWithoutComparationDefault('text-hover-color','#ffffff') . ';');
						}

						if ($oneItem->getColorWithoutComparationDefault('border-color','[1]')) {
							$this->_getAssetsRenderer()->createCssRule()
								->setAddWhiteSpaceBetweenSelectors(false)
								->addSelector('.'.$uniqueCssClass.'.btn-base-brd-slide')
								->addParamsString('border-color:' . $oneItem->getColorWithoutComparationDefault('border-color','[1]') . ';' );
						} else {
							$this->_getAssetsRenderer()->createCssRule()
								->setAddWhiteSpaceBetweenSelectors(false)
								->addSelector('.'.$uniqueCssClass.'.btn-base-brd-slide')
								->addParamsString('border-color: transparent;');
						}

						if ($oneItem->getColorWithoutComparationDefault('border-hover-color','[1]')) {
							$this->_getAssetsRenderer()->createCssRule()
								->setAddWhiteSpaceBetweenSelectors(false)
								->addSelector('.'.$uniqueCssClass.'.btn-base-brd-slide:hover')
								->addParamsString('border-color:' . $oneItem->getColorWithoutComparationDefault('border-hover-color','[1]') . ';');
						} else {
							$this->_getAssetsRenderer()->createCssRule()
								->setAddWhiteSpaceBetweenSelectors(false)
								->addSelector('.'.$uniqueCssClass.'.btn-base-brd-slide:hover')
								->addParamsString('border-color: transparent;');
						}

						if ($oneItem->getColorWithoutComparationDefault('bg-color','')) {
							$this->_getAssetsRenderer()->createCssRule()
								->setAddWhiteSpaceBetweenSelectors(false)
								->addSelector('.'.$uniqueCssClass.'.btn-base-brd-slide')
								->addParamsString('background-color:' . $oneItem->getColorWithoutComparationDefault('bg-color','') . ';');
						}

						if ($oneItem->getWithoutComparationDefault('hover-animation','') == '' && $oneItem->getColorWithoutComparationDefault('bg-hover-color','[1]')) {
							$this->_getAssetsRenderer()->createCssRule()
								->setAddWhiteSpaceBetweenSelectors(false)
								->addSelector('.'.$uniqueCssClass.'.btn-base-brd-slide:hover')
								->addParamsString('background-color:' . $oneItem->getColorWithoutComparationDefault('bg-hover-color','[1]'). ';');
						}

						if ($oneItem->getWithoutComparationDefault('hover-animation','') != '' && $oneItem->getColorWithoutComparationDefault('bg-hover-color','[1]')) {
							$this->_getAssetsRenderer()->createCssRule()
								->setAddWhiteSpaceBetweenSelectors(false)
								->addSelector('.'.$uniqueCssClass.'.btn-base-brd-slide:after')
								->addParamsString('background: ' . $oneItem->getColorWithoutComparationDefault('bg-hover-color', '[1]') . ';');
						}


						$toPrint .= '<span class="btn-text">';
							$toPrint .= $oneItem->getWithoutComparationDefault('text','Click me!');
						$toPrint .= '</span>';

					$toPrint .= '</a>';
					break;

				case 'button2':

					$buttonClasses = $uniqueCssClass.' ffb-btn ffb-btn-v2 ffb-btn-link '.$cssClass.' btn-base-bg animate-btn-wrap animate-btn-base-' . $oneItem->getWithoutComparationDefault('size','sm') . ' ' . $oneItem->getWithoutComparationDefault('hover-animation','animate-btn-t-') . '' . $oneItem->getWithoutComparationDefault('size','sm') . ' ' . $oneItem->getWithoutComparationDefault('radius','') . ' ' . $margin . ' ' . $oneItem->getWithoutComparationDefault('width','');

					if( !$this->getParam( self::PARAM_USE_URL) ){
						$toPrint .= '<a ';
							$toPrint .= $this->_getBlock(ffThemeBuilderBlock::LINK)->setParam(ffThemeBuilderBlock_Link::PARAM_TARGET, 'same')->setParam('classes', $buttonClasses)->get($oneItem);
						$toPrint .= '>';
					} else {
						$toPrint .= '<a class="'.$buttonClasses.'" href="'. $this->getParam( self::PARAM_USE_URL) .'">';
					}

					if ($oneItem->getColorWithoutComparationDefault('text-color','#ffffff')) {
						$this->_getAssetsRenderer()->createCssRule()
							->setAddWhiteSpaceBetweenSelectors(false)
							->addSelector('.'.$uniqueCssClass.'.btn-base-bg')
							->addParamsString('color:' . $oneItem->getColorWithoutComparationDefault('text-color','#ffffff') .';');
					}

					if ($oneItem->getColorWithoutComparationDefault('text-hover-color','#ffffff')) {
						$this->_getAssetsRenderer()->createCssRule()
							->setAddWhiteSpaceBetweenSelectors(false)
							->addSelector('.'.$uniqueCssClass.'.btn-base-bg .btn-icon')
							->addParamsString('color:' . $oneItem->getColorWithoutComparationDefault('text-hover-color','#ffffff') .';');
					}

					if ($oneItem->getColorWithoutComparationDefault('border-color','')) {
						$this->_getAssetsRenderer()->createCssRule()
							->setAddWhiteSpaceBetweenSelectors(false)
							->addSelector('.'.$uniqueCssClass.'.btn-base-bg')
							->addParamsString('border-color:' . $oneItem->getColorWithoutComparationDefault('border-color','') .';');
					} else {
						$this->_getAssetsRenderer()->createCssRule()
							->setAddWhiteSpaceBetweenSelectors(false)
							->addSelector('.'.$uniqueCssClass.'.btn-base-bg')
							->addParamsString('border-color: transparent;');
					}

					if ($oneItem->getColorWithoutComparationDefault('border-hover-color','')) {
						$this->_getAssetsRenderer()->createCssRule()
							->setAddWhiteSpaceBetweenSelectors(false)
							->addSelector('.'.$uniqueCssClass.'.btn-base-bg:hover')
							->addParamsString('border-color:' . $oneItem->getColorWithoutComparationDefault('border-hover-color','') .';');
					} else {
						$this->_getAssetsRenderer()->createCssRule()
							->setAddWhiteSpaceBetweenSelectors(false)
							->addSelector('.'.$uniqueCssClass.'.btn-base-bg:hover')
							->addParamsString('border-color: transparent;');
					}



					if ($oneItem->getColorWithoutComparationDefault('bg-color','[1]')) {
						$this->_getAssetsRenderer()->createCssRule()
							->setAddWhiteSpaceBetweenSelectors(false)
							->addSelector('.'.$uniqueCssClass.'.btn-base-bg')
							->addParamsString('background-color:' . $oneItem->getColorWithoutComparationDefault('bg-color','[1]') .';');
					}

					if ($oneItem->getColorWithoutComparationDefault('bg-hover-color','[2]') && (strpos($oneItem->getWithoutComparationDefault('hover-animation','animate-btn-t-'), 'animate-btn-bg-hover') === false) ) {
						$this->_getAssetsRenderer()->createCssRule()
							->setAddWhiteSpaceBetweenSelectors(false)
							->addSelector('.'.$uniqueCssClass.'.btn-base-bg:hover')
							->addParamsString('background-color:' . $oneItem->getColorWithoutComparationDefault('bg-hover-color','[2]') .';');
					}

					if ($oneItem->getColorWithoutComparationDefault('bg-hover-color','[2]') && (strpos($oneItem->getWithoutComparationDefault('hover-animation','animate-btn-t-'), 'animate-btn-bg-hover') !== false) ) {
						$this->_getAssetsRenderer()->createCssRule()
							->setAddWhiteSpaceBetweenSelectors(false)
							->addSelector('.'.$uniqueCssClass.'.btn-base-bg:after')
							->addParamsString('background: ' . $oneItem->getColorWithoutComparationDefault('bg-hover-color', '[2]') .';');

						$this->_getAssetsRenderer()->createCssRule()
							->setAddWhiteSpaceBetweenSelectors(false)
							->addSelector('.'.$uniqueCssClass.'.btn-base-bg:before')
							->addParamsString('background: ' . $oneItem->getColorWithoutComparationDefault('bg-hover-color', '[2]') .';');
					}

						$toPrint .= '<span class="btn-text">' . $oneItem->getWithoutComparationDefault('text','Click me!') . '</span>';
						if ($oneItem->getWithoutComparationDefault('use-icon',0)) {
							$toPrint .= '<span class="btn-icon ' . $oneItem->getWithoutComparationDefault('icon','ff-font-awesome4 icon-bell') . '"></span>';
						} else {
							$toPrint .= '<span class="btn-icon">' . $oneItem->getWithoutComparationDefault('hover-text','Click me!') . '</span>';
						}

					$toPrint .= '</a>';

					break;

				case 'button3':

					$buttonClasses = $uniqueCssClass.' '.$cssClass.' btn-base-bg ffb-btn ffb-btn-v3 ffb-btn-link btn-base-' . $oneItem->getWithoutComparationDefault('size','sm') . ' ' . $oneItem->getWithoutComparationDefault('radius','') . ' ' . $oneItem->getWithoutComparationDefault('icon-animation','btn-base-animate-to-top') . ' ' . $margin . ' ' . $oneItem->getWithoutComparationDefault('width','');

					if( !$this->getParam( self::PARAM_USE_URL) ){
						$toPrint .= '<a ';
							$toPrint .= $this->_getBlock(ffThemeBuilderBlock::LINK)->setParam(ffThemeBuilderBlock_Link::PARAM_TARGET, 'same')->setParam('classes', $buttonClasses)->get($oneItem);
						$toPrint .= '>';
					} else {
						$toPrint .= '<a class="'.$buttonClasses.'" href="'. $this->getParam( self::PARAM_USE_URL) .'">';
					}

						if ($oneItem->getColorWithoutComparationDefault('text-color','#ffffff')) {
							$this->_getAssetsRenderer()->createCssRule()
								->setAddWhiteSpaceBetweenSelectors(false)
								->addSelector('.'.$uniqueCssClass.'.btn-base-bg')
								->addParamsString('color:' . $oneItem->getColorWithoutComparationDefault('text-color','#ffffff') .';');
						}

						if ($oneItem->getColorWithoutComparationDefault('text-hover-color','#ffffff')) {
							$this->_getAssetsRenderer()->createCssRule()
								->setAddWhiteSpaceBetweenSelectors(false)
								->addSelector('.'.$uniqueCssClass.'.btn-base-bg:hover')
								->addParamsString('color:' . $oneItem->getColorWithoutComparationDefault('text-hover-color','#ffffff') .';');
						}

						if ($oneItem->getColorWithoutComparationDefault('border-color','')) {
							$this->_getAssetsRenderer()->createCssRule()
								->setAddWhiteSpaceBetweenSelectors(false)
								->addSelector('.'.$uniqueCssClass.'.btn-base-bg')
								->addParamsString('border-color:' . $oneItem->getColorWithoutComparationDefault('border-color','') .';');

							$this->_getAssetsRenderer()->createCssRule()
								->setAddWhiteSpaceBetweenSelectors(false)
								->addSelector('.'.$uniqueCssClass.'.btn-base-bg .btn-base-element-' . $oneItem->getWithoutComparationDefault('size','sm'))
								->addParamsString('border-left-color:' . $oneItem->getColorWithoutComparationDefault('border-color','') .';');
						} else {
							$this->_getAssetsRenderer()->createCssRule()
								->setAddWhiteSpaceBetweenSelectors(false)
								->addSelector('.'.$uniqueCssClass.'.btn-base-bg')
								->addParamsString('border-color: transparent;');
						}

						if ($oneItem->getColorWithoutComparationDefault('border-hover-color','')) {
							$this->_getAssetsRenderer()->createCssRule()
								->setAddWhiteSpaceBetweenSelectors(false)
								->addSelector('.'.$uniqueCssClass.'.btn-base-bg:hover')
								->addParamsString('border-color:' . $oneItem->getColorWithoutComparationDefault('border-hover-color','') .';');

							$this->_getAssetsRenderer()->createCssRule()
								->setAddWhiteSpaceBetweenSelectors(false)
								->addSelector('.'.$uniqueCssClass.'.btn-base-bg:hover .btn-base-element-' . $oneItem->getWithoutComparationDefault('size','sm'))
								->addParamsString('border-left-color:' . $oneItem->getColorWithoutComparationDefault('border-hover-color','') .';');
						} else {
							$this->_getAssetsRenderer()->createCssRule()
								->setAddWhiteSpaceBetweenSelectors(false)
								->addSelector('.'.$uniqueCssClass.'.btn-base-bg:hover')
								->addParamsString('border-color: transparent;');
						}

						if ($oneItem->getColorWithoutComparationDefault('bg-color','[1]')) {
							$this->_getAssetsRenderer()->createCssRule()
								->setAddWhiteSpaceBetweenSelectors(false)
								->addSelector('.'.$uniqueCssClass.'.btn-base-bg')
								->addParamsString('background-color:' . $oneItem->getColorWithoutComparationDefault('bg-color','[1]') .';');
						}

						if ($oneItem->getColorWithoutComparationDefault('bg-hover-color','[2]')) {
							$this->_getAssetsRenderer()->createCssRule()
								->setAddWhiteSpaceBetweenSelectors(false)
								->addSelector('.'.$uniqueCssClass.'.btn-base-bg:hover')
								->addParamsString('background-color:' . $oneItem->getColorWithoutComparationDefault('bg-hover-color','[2]') .';');
						}

						if ($oneItem->getColorWithoutComparationDefault('icon-text-color','#ffffff')) {
							$this->_getAssetsRenderer()->createCssRule()
								->setAddWhiteSpaceBetweenSelectors(false)
								->addSelector('.'.$uniqueCssClass.'.btn-base-bg .btn-base-element-' . $oneItem->getWithoutComparationDefault('size','sm'))
								->addParamsString('color:' . $oneItem->getColorWithoutComparationDefault('icon-text-color','#ffffff') .';');
						}

						if ($oneItem->getColorWithoutComparationDefault('icon-text-hover-color','#ffffff')) {
							$this->_getAssetsRenderer()->createCssRule()
								->setAddWhiteSpaceBetweenSelectors(false)
								->addSelector('.'.$uniqueCssClass.'.btn-base-bg:hover .btn-base-element-' . $oneItem->getWithoutComparationDefault('size','sm'))
								->addParamsString('color:' . $oneItem->getColorWithoutComparationDefault('icon-text-hover-color','#ffffff') .';');
						}

						if ($oneItem->getColorWithoutComparationDefault('icon-bg-color','[1]')) {
							$this->_getAssetsRenderer()->createCssRule()
								->setAddWhiteSpaceBetweenSelectors(false)
								->addSelector('.'.$uniqueCssClass.'.btn-base-bg .btn-base-element-' . $oneItem->getWithoutComparationDefault('size','sm'))
								->addParamsString('background-color:' . $oneItem->getColorWithoutComparationDefault('icon-bg-color','[1]') .';');
						}

						if ($oneItem->getColorWithoutComparationDefault('icon-bg-hover-color','[1]')) {
							$this->_getAssetsRenderer()->createCssRule()
								->setAddWhiteSpaceBetweenSelectors(false)
								->addSelector('.'.$uniqueCssClass.'.btn-base-bg:hover .btn-base-element-' . $oneItem->getWithoutComparationDefault('size','sm'))
								->addParamsString('background-color:' . $oneItem->getColorWithoutComparationDefault('icon-bg-hover-color','[1]') .';');
						}

						$toPrint .= '<span class="btn-text">';
							$toPrint .= $oneItem->getWithoutComparationDefault('text','Click me!');
						$toPrint .= '</span>';
						$toPrint .= '<span class="btn-base-element-' . $oneItem->getWithoutComparationDefault('size','sm') . '">';
						$toPrint .= '<i class="btn-base-element-icon ' . $oneItem->getWithoutComparationDefault('icon','ff-font-awesome4 icon-bell') . '"></i>';
						$toPrint .= '</span>';

					$toPrint .= '</a>';

					break;

				case 'button4':

					$buttonClasses = $uniqueCssClass.' ffb-btn ffb-btn-v4 ffb-btn-link '.$cssClass.' btn-base-brd-slide btn-slide ' . $oneItem->getWithoutComparationDefault('radius','') . ' btn-base-' . $oneItem->getWithoutComparationDefault('size','sm') . ' ' . $oneItem->getWithoutComparationDefault('hover-animation','') . ' ' . $margin . ' ' . $oneItem->getWithoutComparationDefault('width','');

					if( !$this->getParam( self::PARAM_USE_URL) ){
						$toPrint .= '<a ';
							$toPrint .= $this->_getBlock(ffThemeBuilderBlock::LINK)->setParam(ffThemeBuilderBlock_Link::PARAM_TARGET, 'same')->setParam('classes', $buttonClasses)->get($oneItem);
						$toPrint .= '>';
					} else {
						$toPrint .= '<a class="'.$buttonClasses.'" href="'. $this->getParam( self::PARAM_USE_URL) .'">';
					}

						if ($oneItem->getColorWithoutComparationDefault('text-color','[1]')) {
							$this->_getAssetsRenderer()->createCssRule()
								->setAddWhiteSpaceBetweenSelectors(false)
								->addSelector('.'.$uniqueCssClass.'.btn-base-brd-slide')
								->addParamsString('color:' . $oneItem->getColorWithoutComparationDefault('text-color','[1]') . ';');
						}

						if ($oneItem->getColorWithoutComparationDefault('text-hover-color','#ffffff')) {
							$this->_getAssetsRenderer()->createCssRule()
								->setAddWhiteSpaceBetweenSelectors(false)
								->addSelector('.'.$uniqueCssClass.'.btn-base-brd-slide:hover')
								->addParamsString('color:' . $oneItem->getColorWithoutComparationDefault('text-hover-color','#ffffff') . ';');
						}

						if ($oneItem->getColorWithoutComparationDefault('icon-text-color','[1]')) {
							$this->_getAssetsRenderer()->createCssRule()
								->setAddWhiteSpaceBetweenSelectors(false)
								->addSelector('.'.$uniqueCssClass.'.btn-base-brd-slide i')
								->addParamsString('color:' . $oneItem->getColorWithoutComparationDefault('icon-text-color','[1]') . ';');
						}

						if ($oneItem->getColorWithoutComparationDefault('icon-text-hover-color','#ffffff')) {
							$this->_getAssetsRenderer()->createCssRule()
								->setAddWhiteSpaceBetweenSelectors(false)
								->addSelector('.'.$uniqueCssClass.'.btn-base-brd-slide:hover i')
								->addParamsString('color:' . $oneItem->getColorWithoutComparationDefault('icon-text-hover-color','#ffffff') . ';');
						}

						if ($oneItem->getColorWithoutComparationDefault('border-color','[1]')) {
							$this->_getAssetsRenderer()->createCssRule()
								->setAddWhiteSpaceBetweenSelectors(false)
								->addSelector('.'.$uniqueCssClass.'.btn-base-brd-slide')
								->addParamsString('border-color:' . $oneItem->getColorWithoutComparationDefault('border-color','[1]') . ';');
						} else {
							$this->_getAssetsRenderer()->createCssRule()
								->setAddWhiteSpaceBetweenSelectors(false)
								->addSelector('.'.$uniqueCssClass.'.btn-base-brd-slide')
								->addParamsString('border-color: transparent;');
						}

						if ($oneItem->getColorWithoutComparationDefault('border-hover-color','')) {
							$this->_getAssetsRenderer()->createCssRule()
								->setAddWhiteSpaceBetweenSelectors(false)
								->addSelector('.'.$uniqueCssClass.'.btn-base-brd-slide:hover')
								->addParamsString('border-color:' . $oneItem->getColorWithoutComparationDefault('border-hover-color','') . ';' );
						} else {
							$this->_getAssetsRenderer()->createCssRule()
								->setAddWhiteSpaceBetweenSelectors(false)
								->addSelector('.'.$uniqueCssClass.'.btn-base-brd-slide:hover')
								->addParamsString('border-color: transparent;' );
						}

						if ($oneItem->getColorWithoutComparationDefault('bg-color','')) {
							$this->_getAssetsRenderer()->createCssRule()
								->setAddWhiteSpaceBetweenSelectors(false)
								->addSelector('.'.$uniqueCssClass.'.btn-base-brd-slide')
								->addParamsString('background-color:' . $oneItem->getColorWithoutComparationDefault('bg-color','') . ';' );
						}

						if ($oneItem->getWithoutComparationDefault('hover-animation','') == '' && $oneItem->getColorWithoutComparationDefault('bg-hover-color','[2]'). ';') {
							$this->_getAssetsRenderer()->createCssRule()
								->setAddWhiteSpaceBetweenSelectors(false)
								->addSelector('.'.$uniqueCssClass.'.btn-base-brd-slide:hover')
								->addParamsString('background-color:' . $oneItem->getColorWithoutComparationDefault('bg-hover-color','[2]').';');
						}

						if ($oneItem->getWithoutComparationDefault('hover-animation','') != '' && $oneItem->getColorWithoutComparationDefault('bg-hover-color','[2]'). ';') {
							$this->_getAssetsRenderer()->createCssRule()
								->setAddWhiteSpaceBetweenSelectors(false)
								->addSelector('.'.$uniqueCssClass.'.btn-base-brd-slide:after')
								->addParamsString('background: ' . $oneItem->getColorWithoutComparationDefault('bg-hover-color', '[2]') . ';');
						}

						if ($oneItem->getWithoutComparationDefault('icon-position','after') == 'before') {
							$toPrint .= '<i class="btn-text btn-base-element-icon margin-r-10 ' . $oneItem->getWithoutComparationDefault('icon','ff-font-awesome4 icon-envelope-o') . '"></i>';
						}

						$toPrint .= '<span class="btn-text">';

							$toPrint .= $oneItem->getWithoutComparationDefault('text','Click me!');

						$toPrint .= '</span>';

						if ($oneItem->getWithoutComparationDefault('icon-position','after') == 'after') {
							$toPrint .= '<i class="btn-text btn-base-element-icon margin-l-10 ' . $oneItem->getWithoutComparationDefault('icon','ff-font-awesome4 icon-envelope-o') . '"></i>';
						}

					$toPrint .= '</a>';

					break;

				case 'button5':

					if ($oneItem->getColorWithoutComparationDefault('icon-color','')) {
						$this->_getAssetsRenderer()->createCssRule()
							->setAddWhiteSpaceBetweenSelectors(false)
							->addSelector('.'.$uniqueCssClass.' .ff-button-block-v5-video-icon')
							->addParamsString('color:' . $oneItem->getColorWithoutComparationDefault('icon-color','').';');
					}

					if ($oneItem->getColorWithoutComparationDefault('icon-hover-color','')) {
						$this->_getAssetsRenderer()->createCssRule()
							->setAddWhiteSpaceBetweenSelectors(false)
							->addSelector('.'.$uniqueCssClass.':hover .ff-button-block-v5-video-icon')
							->addParamsString('color:' . $oneItem->getColorWithoutComparationDefault('icon-hover-color','').';');
					}

					if ($oneItem->getColorWithoutComparationDefault('bg-color','')) {
						$this->_getAssetsRenderer()->createCssRule()
							->setAddWhiteSpaceBetweenSelectors(false)
							->addSelector('.'.$uniqueCssClass.'.ff-button-block-v5-video-wrapper')
							->addParamsString('background-color:' . $oneItem->getColorWithoutComparationDefault('bg-color','').';');
					}

					if ($oneItem->getColorWithoutComparationDefault('bg-hover-color','')) {
						$this->_getAssetsRenderer()->createCssRule()
							->setAddWhiteSpaceBetweenSelectors(false)
							->addSelector('.'.$uniqueCssClass.'.ff-button-block-v5-video-wrapper:hover')
							->addParamsString('background-color:' . $oneItem->getColorWithoutComparationDefault('bg-hover-color','').';');
					}

					echo '<a ';
						$this->_getBlock(ffThemeBuilderBlock::LINK)->setParam(ffThemeBuilderBlock_Link::PARAM_TARGET, 'same')->setParam('classes', 'ff-button-block-v5-video-wrapper ff-image-gallery-video-player ffb-btn ffb-btn-v5 ffb-btn-link '.$uniqueCssClass.' '.$margin.' ')->render($oneItem);
					echo '>';
						echo '<i class="ff-button-block-v5-video-icon '.$oneItem->getWithoutComparationDefault('icon','ff-font-awesome4 icon-play').'"></i>';
					echo '</a>';

					break;

				case 'button6':

					if ($oneItem->getColorWithoutComparationDefault('icon-color','')) {
						$this->_getAssetsRenderer()->createCssRule()
							->setAddWhiteSpaceBetweenSelectors(false)
							->addSelector('.'.$uniqueCssClass.'')
							->addParamsString('color:' . $oneItem->getColorWithoutComparationDefault('icon-color','') . ';' );
					}

					if ($oneItem->getColorWithoutComparationDefault('icon-hover-color','')) {
						$this->_getAssetsRenderer()->createCssRule()
							->setAddWhiteSpaceBetweenSelectors(false)
							->addSelector('.'.$uniqueCssClass.':hover')
							->addParamsString('color:' . $oneItem->getColorWithoutComparationDefault('icon-hover-color','') . ';' );
					}

					if ($oneItem->getColorWithoutComparationDefault('shadow-color','')) {
						$this->_getAssetsRenderer()->createCssRule()
							->setAddWhiteSpaceBetweenSelectors(false)
							->addSelector('.'.$uniqueCssClass.'')
							->addParamsString('box-shadow: 0 0 5px 2px' . $oneItem->getColorWithoutComparationDefault('shadow-color',''). ';' );
					}

					if ($oneItem->getColorWithoutComparationDefault('shadow-hover-color','')) {
						$this->_getAssetsRenderer()->createCssRule()
							->setAddWhiteSpaceBetweenSelectors(false)
							->addSelector('.'.$uniqueCssClass.':hover')
							->addParamsString('box-shadow: 0 0 5px 2px' . $oneItem->getColorWithoutComparationDefault('shadow-hover-color',''). ';' );
					}

					if ($oneItem->getColorWithoutComparationDefault('border-color','')) {
						$this->_getAssetsRenderer()->createCssRule()
							->setAddWhiteSpaceBetweenSelectors(false)
							->addSelector('.'.$uniqueCssClass.'.ff-button-block-v1-video-effect:before')
							->addParamsString('border: 1px solid ' . $oneItem->getColorWithoutComparationDefault('border-color',''). ';');

					}

					if ($oneItem->getColorWithoutComparationDefault('border-hover-color','')) {
						$this->_getAssetsRenderer()->createCssRule()
							->setAddWhiteSpaceBetweenSelectors(false)
							->addSelector('.'.$uniqueCssClass.'.ff-button-block-v1-video-effect:hover:before')
							->addParamsString('border: 1px solid ' . $oneItem->getColorWithoutComparationDefault('border-hover-color',''). ';');
					}

					if ($oneItem->getColorWithoutComparationDefault('border-2-color','')) {
						$this->_getAssetsRenderer()->createCssRule()
							->setAddWhiteSpaceBetweenSelectors(false)
							->addSelector('.'.$uniqueCssClass.'.ff-button-block-v1-video-effect:after')
							->addParamsString('border: 1px solid ' . $oneItem->getColorWithoutComparationDefault('border-2-color',''). ';');
					}

					if ($oneItem->getColorWithoutComparationDefault('border-2-hover-color','')) {
						$this->_getAssetsRenderer()->createCssRule()
							->setAddWhiteSpaceBetweenSelectors(false)
							->addSelector('.'.$uniqueCssClass.'.ff-button-block-v1-video-effect:hover:after')
							->addParamsString('border: 1px solid ' . $oneItem->getColorWithoutComparationDefault('border-2-hover-color',''). ';');
					}

						echo '<a '.$this->_getBlock(ffThemeBuilderBlock::LINK)->setParam(ffThemeBuilderBlock_Link::PARAM_TARGET, 'same')->setParam('classes', 'ff-button-block-v1-video ff-button-block-v1-video-effect ffb-btn-link ff-button-block-v1 ffb-btn ffb-btn-v6 '.$uniqueCssClass.' ' . $margin)->get($oneItem).'>';
							echo '<i class="ff-button-block-v1-video-icon '.$oneItem->getWithoutComparationDefault('icon','ff-font-awesome4 icon-play-circle').'"></i>';
						echo '</a>';
					break;

				case 'button7':

					if ($oneItem->getColorWithoutComparationDefault('icon-color','')) {
						$this->_getAssetsRenderer()->createCssRule()
							->setAddWhiteSpaceBetweenSelectors(false)
							->addSelector('.'.$uniqueCssClass.'.ff-video-button-icon')
							->addParamsString('color:' . $oneItem->getColorWithoutComparationDefault('icon-color',''). ';');
					}

					if ($oneItem->getColorWithoutComparationDefault('icon-hover-color','')) {
						$this->_getAssetsRenderer()->createCssRule()
							->setAddWhiteSpaceBetweenSelectors(false)
							->addSelector('.'.$uniqueCssClass.'.ff-video-button-icon:hover')
							->addParamsString('color:' . $oneItem->getColorWithoutComparationDefault('icon-hover-color',''). ';');
					}

					if ($oneItem->getColorWithoutComparationDefault('border-color','')) {
						$this->_getAssetsRenderer()->createCssRule()
							->setAddWhiteSpaceBetweenSelectors(false)
							->addSelector('.'.$uniqueCssClass.'.ff-video-button-icon')
							->addParamsString('border: 1px solid ' . $oneItem->getColorWithoutComparationDefault('border-color',''). ';');
					}

					if ($oneItem->getColorWithoutComparationDefault('border-hover-color','')) {
						$this->_getAssetsRenderer()->createCssRule()
							->setAddWhiteSpaceBetweenSelectors(false)
							->addSelector('.'.$uniqueCssClass.'.ff-video-button-icon:hover')
							->addParamsString('border: 1px solid ' . $oneItem->getColorWithoutComparationDefault('border-hover-color',''). ';');
					}


					echo '<a ';
						$this->_getBlock(ffThemeBuilderBlock::LINK)->setParam(ffThemeBuilderBlock_Link::PARAM_TARGET, 'same')->setParam('classes', 'ffb-btn ffb-btn-v7 ffb-btn-link ff-video-button-icon radius-circle '.$uniqueCssClass.' '.$margin.' ')->render($oneItem);
					echo '>';
						echo '<i class="'.$oneItem->getWithoutComparationDefault('icon','ff-font-awesome4 icon-play').'"></i>';
					echo '</a>';
					break;

				case 'button8':

					if ($oneItem->getColorWithoutComparationDefault('text-color','')) {
						$this->_getAssetsRenderer()->createCssRule()
							->setAddWhiteSpaceBetweenSelectors(false)
							->addSelector('.'.$uniqueCssClass)
							->addParamsString('color:' . $oneItem->getColorWithoutComparationDefault('text-color','').';');
					}

					if ($oneItem->getColorWithoutComparationDefault('text-hover-color','')) {
						$this->_getAssetsRenderer()->createCssRule()
							->setAddWhiteSpaceBetweenSelectors(false)
							->addSelector('.'.$uniqueCssClass.':hover')
							->addParamsString('color:' . $oneItem->getColorWithoutComparationDefault('text-hover-color','').';');
					}

					if ($oneItem->getColorWithoutComparationDefault('border-color','')) {
						$this->_getAssetsRenderer()->createCssRule()
							->setAddWhiteSpaceBetweenSelectors(false)
							->addSelector('.'.$uniqueCssClass)
							->addParamsString('border-color:' . $oneItem->getColorWithoutComparationDefault('border-color','').';');
					}

					if ($oneItem->getColorWithoutComparationDefault('border-hover-color','')) {
						$this->_getAssetsRenderer()->createCssRule()
							->setAddWhiteSpaceBetweenSelectors(false)
							->addSelector('.'.$uniqueCssClass.':hover')
							->addParamsString('border-color:' . $oneItem->getColorWithoutComparationDefault('border-hover-color','').';');
					}

					echo '<a ';
						$this->_getBlock(ffThemeBuilderBlock::LINK)->setParam(ffThemeBuilderBlock_Link::PARAM_TARGET, 'same')->setParam('classes', 'ffb-btn ffb-btn-v8 ffb-btn-link ff-video-link-button '.$uniqueCssClass.' '.$margin.' ')->render($oneItem);
					echo '>';
						echo ark_wp_kses( $oneItem->getWithoutComparationDefault('text',' Watch our Video') );
					echo '</a>';


					break;

				case 'button9':
					if ($oneItem->getColorWithoutComparationDefault('icon-color','')) {
						$this->_getAssetsRenderer()->createCssRule()
							->setAddWhiteSpaceBetweenSelectors(false)
							->addSelector('.'.$uniqueCssClass.' .ff-button-block-v9-video-icon i')
							->addParamsString('color:' . $oneItem->getColorWithoutComparationDefault('icon-color','').';');
					}

					if ($oneItem->getColorWithoutComparationDefault('icon-hover-color','')) {
						$this->_getAssetsRenderer()->createCssRule()
							->setAddWhiteSpaceBetweenSelectors(false)
							->addSelector('.'.$uniqueCssClass.':hover .ff-button-block-v9-video-icon i')
							->addParamsString('color:' . $oneItem->getColorWithoutComparationDefault('icon-hover-color','').';');
					}

					if ($oneItem->getColorWithoutComparationDefault('bg-color','')) {
						$this->_getAssetsRenderer()->createCssRule()
							->setAddWhiteSpaceBetweenSelectors(false)
							->addSelector('.'.$uniqueCssClass.' .ff-button-block-v9-video-wrapper')
							->addParamsString('background-color:' . $oneItem->getColorWithoutComparationDefault('bg-color','').';');
					}

					if ($oneItem->getColorWithoutComparationDefault('bg-hover-color','')) {
						$this->_getAssetsRenderer()->createCssRule()
							->setAddWhiteSpaceBetweenSelectors(false)
							->addSelector('.'.$uniqueCssClass.':hover .ff-button-block-v9-video-wrapper')
							->addParamsString('background-color:' . $oneItem->getColorWithoutComparationDefault('bg-hover-color','').';');
					}

					if ($oneItem->getColorWithoutComparationDefault('text-color','')) {
						$this->_getAssetsRenderer()->createCssRule()
							->setAddWhiteSpaceBetweenSelectors(false)
							->addSelector('.'.$uniqueCssClass.' .ff-video-hover-button-title')
							->addParamsString('color:' . $oneItem->getColorWithoutComparationDefault('text-color','').';');
					}

					if ($oneItem->getColorWithoutComparationDefault('text-hover-color','')) {
						$this->_getAssetsRenderer()->createCssRule()
							->setAddWhiteSpaceBetweenSelectors(false)
							->addSelector('.'.$uniqueCssClass.':hover .ff-video-hover-button-title')
							->addParamsString('color:' . $oneItem->getColorWithoutComparationDefault('text-hover-color','').';');
					}
					
					echo '<a ';
						$this->_getBlock(ffThemeBuilderBlock::LINK)->setParam(ffThemeBuilderBlock_Link::PARAM_TARGET, 'same')->setParam('classes', 'ffb-btn-link ff-video-hover-button ffb-btn ffb-btn-v9 '.$uniqueCssClass.' '.$margin.' ')->render($oneItem);
					echo '>';
						echo '<span class="ff-video-hover-button-center-align">';
							$this->_advancedToggleBoxStart($oneItem, 'button9-icon');
							echo '<div class="ff-button-block-v9-video-wrapper ff-video-hover-button-player ff-button-block-v9-video-icon">';
								echo '<i class="'.$oneItem->getWithoutComparationDefault('button9-icon icon','ff-font-awesome4 icon-play').'"></i>';
							echo '</div>';
							$this->_advancedToggleBoxEnd($oneItem, 'button9-icon');
							$this->_advancedToggleBoxStart($oneItem, 'button9');
							echo '<span class="ff-video-hover-button-title">'.$oneItem->getWithoutComparationDefault('button9 text','Watch Video').'</span>';
							$this->_advancedToggleBoxEnd($oneItem, 'button9');
						echo '</span>';
					echo '</a>';


					break;

				case 'separator':

					$margin = '';
					if ($oneItem->getWithoutComparationDefault('use-r-margin',1)) {
						$margin = 'ff-button-block-margin-r';
					}

					echo '<span class="buttons-divider ' . $margin . '">';
						echo ark_wp_kses( $oneItem->getWithoutComparationDefault('text','or') );
					echo '</span>';
					break;
			}

			// Updated and escaped buttons
			echo ( $toPrint );

		}

	}

	protected function _injectOptions( ffThemeBuilderOptionsExtender $s ) {
		$s->startRepVariableSection('button');

					$s->startRepVariationSection('button1', ark_wp_kses( __('Button 1 (Classic)', 'ark' ) ) );
						$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_START, '', ark_wp_kses( __('Basic Options', 'ark' ) ) );

							$s->addOptionNL(ffOneOption::TYPE_TEXT, 'text', '', 'Click me!')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Button Text', 'ark' ) ) )
							;
							
							$s->addElement(ffOneElement::TYPE_NEW_LINE);

							$s->addOptionNL(ffOneOption::TYPE_SELECT, 'size', '', 'sm')
								->addSelectValue(esc_attr( __('Extra small', 'ark' ) ), 'xs')
								->addSelectValue(esc_attr( __('Small', 'ark' ) ), 'sm')
								->addSelectValue(esc_attr( __('Medium', 'ark' ) ), 'md')
								->addSelectValue(esc_attr( __('Large', 'ark' ) ), 'lg')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Size', 'ark' ) ) );

							$s->addOptionNL(ffOneOption::TYPE_SELECT, 'width', '', 'auto')
								->addSelectValue(esc_attr( __('Auto', 'ark' ) ), 'btn-w-auto')
								->addSelectValue(esc_attr( __('Full Width', 'ark' ) ), 'btn-w-full')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Width', 'ark' ) ) );

							$s->addOptionNL(ffOneOption::TYPE_SELECT, 'radius', '', '')
								->addSelectValue(esc_attr( __('None', 'ark' ) ), '')
								->addSelectValue(esc_attr( __('Small (3px)', 'ark' ) ), 'radius-3')
								->addSelectValue(esc_attr( __('Medium (6px)', 'ark' ) ), 'radius-6')
								->addSelectValue(esc_attr( __('Large (10px)', 'ark' ) ), 'radius-10')
								->addSelectValue(esc_attr( __('Extra large (50px)', 'ark' ) ), 'radius-50')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Border Radius', 'ark' ) ) );

							$s->addOptionNL(ffOneOption::TYPE_SELECT, 'hover-animation', '', '')
								->addSelectValue(esc_attr( __('None', 'ark' ) ), '')
								->addSelectValue(esc_attr( __('Slide top', 'ark' ) ), 'btn-slide-top')
								->addSelectValue(esc_attr( __('Slide left', 'ark' ) ), 'btn-slide-left')
								->addSelectValue(esc_attr( __('Slide right', 'ark' ) ), 'btn-slide-right')
								->addSelectValue(esc_attr( __('Slide bottom', 'ark' ) ), 'btn-slide-bottom')
								->addSelectValue(esc_attr( __('Slide center v1', 'ark' ) ), 'btn-slide-center-v1')
								->addSelectValue(esc_attr( __('Slide center v2', 'ark' ) ), 'btn-slide-center-v2')
								->addSelectValue(esc_attr( __('Slide center v3', 'ark' ) ), 'btn-slide-center-v3')
								->addSelectValue(esc_attr( __('Slide corner', 'ark' ) ), 'btn-slide-corner')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Hover Animation', 'ark' ) ) );

							$s->addElement(ffOneElement::TYPE_NEW_LINE);

							$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'use-r-margin', ark_wp_kses( __('Add right margin', 'ark' ) ), 0);
							$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', ark_wp_kses( __('Adds spacing between this and the next button.', 'ark' ) ) );

						$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_END);
						// $s->addElement(ffOneElement::TYPE_NEW_LINE);

						/****************************************************************************************/
						/* LINK */
						/****************************************************************************************/
						if( !$this->getParam(self::PARAM_WITHOUT_URL) ) {
							$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_START, '', ark_wp_kses( __('Link Options', 'ark' ) ) );
								$this->_getBlock(ffThemeBuilderBlock::LINK)->setParam(ffThemeBuilderBlock_Link::PARAM_TARGET, 'same')->injectOptions($s);
							$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_END);
							// $s->addElement(ffOneElement::TYPE_NEW_LINE);
						}

						/****************************************************************************************/
						/* COLORS */
						/****************************************************************************************/
						$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_START, '', ark_wp_kses( __('Button Colors', 'ark' ) ) );
							$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', ark_wp_kses( __('The default color will be applied if you won\'t select background and/or background hover color.', 'ark' ) ) );
							$s->addElement(ffOneElement::TYPE_NEW_LINE);
							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'text-color','', '[1]')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text Color', 'ark' ) ) );
							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'text-hover-color', '', '#ffffff')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text Hover Color', 'ark' ) ) );
							$s->addElement(ffOneElement::TYPE_NEW_LINE);

							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-color', '', '[1]')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Border Color', 'ark' ) ) );
							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-hover-color', '', '[1]')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Border Hover Color', 'ark' ) ) );
							$s->addElement(ffOneElement::TYPE_NEW_LINE);

							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', '')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background Color', 'ark' ) ) );
							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-hover-color', '' , '[1]')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background Hover Color', 'ark' ) ) );
						$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_END);
					$s->endRepVariationSection();

					$s->startRepVariationSection('button2', ark_wp_kses( __('Button 2 (Classic With Animated Text)', 'ark' ) ) );

						$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_START, '', ark_wp_kses( __('Basic Options', 'ark' ) ) );

							$s->addOptionNL(ffOneOption::TYPE_TEXT, 'text', '', 'Click me!')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Button Text', 'ark' ) ) )
							;

							$s->addOptionNL(ffOneOption::TYPE_TEXT, 'hover-text', '', 'Click me!')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Button Text Hover', 'ark' ) ) )
							;

							$s->addOptionNL(ffOneOption::TYPE_CHECKBOX,'use-icon',ark_wp_kses( __('Show Icon instead of Text on hover', 'ark' ) ),0);
							$s->startHidingBox('use-icon', 'checked');
								$s->addOptionNL(ffOneOption::TYPE_ICON, 'icon', ark_wp_kses( __('Icon', 'ark' ) ), 'ff-font-awesome4 icon-bell');
							$s->endHidingBox();
							$s->addElement(ffOneElement::TYPE_NEW_LINE);

							$s->addOptionNL(ffOneOption::TYPE_SELECT, 'size', '', 'sm')
								->addSelectValue( esc_attr( __('Extra small', 'ark' ) ), 'xs')
								->addSelectValue(esc_attr( __('Small', 'ark' ) ), 'sm')
								->addSelectValue(esc_attr( __('Medium', 'ark' ) ), 'md')
								->addSelectValue(esc_attr( __('Large', 'ark' ) ), 'lg')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Size', 'ark' ) ) );

							$s->addOptionNL(ffOneOption::TYPE_SELECT, 'width', '', 'auto')
								->addSelectValue(esc_attr( __('Auto', 'ark' ) ), 'btn-w-auto')
								->addSelectValue(esc_attr( __('Fullwidth', 'ark' ) ), 'btn-w-full')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Width', 'ark' ) ) );

							$s->addOptionNL(ffOneOption::TYPE_SELECT, 'radius', '', '')
								->addSelectValue(esc_attr( __('None', 'ark' ) ), '')
								->addSelectValue(esc_attr( __('Small (3px)', 'ark' ) ), 'radius-3')
								->addSelectValue(esc_attr( __('Medium (6px)', 'ark' ) ), 'radius-6')
								->addSelectValue(esc_attr( __('Large (10px)', 'ark' ) ), 'radius-10')
								->addSelectValue(esc_attr( __('Extra large (50px)', 'ark' ) ), 'radius-50')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Border Radius', 'ark' ) ) );

							$s->addOptionNL(ffOneOption::TYPE_SELECT, 'hover-animation', '', 'animate-btn-t-')
								->addSelectValue(esc_attr( __('Slide top', 'ark' ) ), 'animate-btn-t-')
								->addSelectValue(esc_attr( __('Slide left', 'ark' ) ), 'animate-btn-l-')
								->addSelectValue(esc_attr( __('Slide right', 'ark' ) ), 'animate-btn-r-')
								->addSelectValue(esc_attr( __('Slide bottom', 'ark' ) ), 'animate-btn-b-')
								->addSelectValue(esc_attr( __('Slide top corner', 'ark' ) ), 'animate-btn-bg-hover animate-btn-t-')
								->addSelectValue(esc_attr( __('Slide left corner', 'ark' ) ), 'animate-btn-bg-hover animate-btn-l-')
								->addSelectValue(esc_attr( __('Slide right corner', 'ark' ) ), 'animate-btn-bg-hover animate-btn-r-')
								->addSelectValue(esc_attr( __('Slide bottom corner', 'ark' ) ), 'animate-btn-bg-hover animate-btn-b-')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Hover Animation', 'ark' ) ) );

							$s->addElement(ffOneElement::TYPE_NEW_LINE);

							$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'use-r-margin', ark_wp_kses( __('Add right margin', 'ark' ) ), 0);
							$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', ark_wp_kses( __('Adds spacing between this and the next button.', 'ark' ) ) );

						$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_END);
						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						/****************************************************************************************/
						/* LINK */
						/****************************************************************************************/
						if(!$this->getParam(self::PARAM_WITHOUT_URL)) {
							$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_START, '', ark_wp_kses( __('Link Options', 'ark' ) ) );
								$this->_getBlock(ffThemeBuilderBlock::LINK)->setParam(ffThemeBuilderBlock_Link::PARAM_TARGET, 'same')->injectOptions($s);
							$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_END);
							$s->addElement(ffOneElement::TYPE_NEW_LINE);
						}

						/****************************************************************************************/
						/* COLORS */
						/****************************************************************************************/
						$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_START, '', ark_wp_kses( __('Button Colors', 'ark' ) ) );
							$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('The default color will be applied if you won\'t select background and/or background hover color.', 'ark' ) ) );
							$s->addElement(ffOneElement::TYPE_NEW_LINE);
							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'text-color','', '#ffffff')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text Color', 'ark' ) ) );
							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'text-hover-color', '', '#ffffff')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text Hover Color', 'ark' ) ) );
							$s->addElement(ffOneElement::TYPE_NEW_LINE);

							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-color', '', '')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Border Color', 'ark' ) ) );
							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-hover-color', '', '')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Border Hover Color', 'ark' ) ) );
							$s->addElement(ffOneElement::TYPE_NEW_LINE);

							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', '[1]')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background Color', 'ark' ) ) );
							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-hover-color', '' , '[2]')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background Hover Color', 'ark' ) ) );
						$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_END);

					$s->endRepVariationSection();

					$s->startRepVariationSection('button3', ark_wp_kses( __('Button 3 (Classic With Animated Icon)', 'ark' ) ) );
						$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_START, '', ark_wp_kses( __('Basic Options', 'ark' ) ) );

							$s->addOptionNL(ffOneOption::TYPE_TEXT, 'text', '', 'Click me!')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Button Text', 'ark' ) ) )
							;
							$s->addElement(ffOneElement::TYPE_NEW_LINE);
							$s->addOptionNL(ffOneOption::TYPE_ICON, 'icon', ark_wp_kses( __('Icon', 'ark' ) ), 'ff-font-awesome4 icon-bell');
							$s->addElement(ffOneElement::TYPE_NEW_LINE);

							$s->addOptionNL(ffOneOption::TYPE_SELECT, 'size', '', 'sm')
								->addSelectValue(esc_attr( __('Extra small', 'ark' ) ), 'xs')
								->addSelectValue(esc_attr( __('Small', 'ark' ) ), 'sm')
								->addSelectValue(esc_attr( __('Medium', 'ark' ) ), 'md')
								->addSelectValue(esc_attr( __('Large', 'ark' ) ), 'lg')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Size', 'ark' ) ) );

							$s->addOptionNL(ffOneOption::TYPE_SELECT, 'width', '', 'auto')
								->addSelectValue(esc_attr( __('Auto', 'ark' ) ), 'btn-w-auto')
								->addSelectValue(esc_attr( __('Fullwidth', 'ark' ) ), 'btn-w-full')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Width', 'ark' ) ) );

							$s->addOptionNL(ffOneOption::TYPE_SELECT, 'radius', '', '')
								->addSelectValue(esc_attr( __('None', 'ark' ) ), '')
								->addSelectValue(esc_attr( __('Extra Small (3px)', 'ark' ) ), 'radius-3')
								->addSelectValue(esc_attr( __('Small (5px)', 'ark' ) ), 'radius-5')
								->addSelectValue(esc_attr( __('Medium (6px)', 'ark' ) ), 'radius-6')
								->addSelectValue(esc_attr( __('Medium (7px)', 'ark' ) ), 'radius-7')
								->addSelectValue(esc_attr( __('Medium (8px)', 'ark' ) ), 'radius-8')
								->addSelectValue(esc_attr( __('Large (9px)', 'ark' ) ), 'radius-9')
								->addSelectValue(esc_attr( __('Large (10px)', 'ark' ) ), 'radius-10')
								->addSelectValue(esc_attr( __('Extra large (50px)', 'ark' ) ), 'radius-50')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Border Radius', 'ark' ) ) );

							$s->addOptionNL(ffOneOption::TYPE_SELECT, 'icon-animation', '', 'btn-base-animate-to-top')
								->addSelectValue(esc_attr( __('Slide Top', 'ark' ) ), 'btn-base-animate-to-top')
								->addSelectValue(esc_attr( __('Slide Right', 'ark' ) ), 'btn-base-animate-to-right')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Animation', 'ark' ) ) );

							$s->addElement(ffOneElement::TYPE_NEW_LINE);

							$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'use-r-margin', ark_wp_kses( __('Add right margin', 'ark' ) ), 0);
							$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('Adds spacing between this and the next button.', 'ark' ) ) ) ;

						$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_END);
						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						/****************************************************************************************/
						/* LINK */
						/****************************************************************************************/
						if(!$this->getParam(self::PARAM_WITHOUT_URL)) {
							$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_START, '', ark_wp_kses( __('Link Options', 'ark' ) ) );
								$this->_getBlock(ffThemeBuilderBlock::LINK)->setParam(ffThemeBuilderBlock_Link::PARAM_TARGET, 'same')->injectOptions($s);
							$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_END);
							$s->addElement(ffOneElement::TYPE_NEW_LINE);
						}

						/****************************************************************************************/
						/* COLORS */
						/****************************************************************************************/
						$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_START, '', ark_wp_kses( __('Button Colors', 'ark' ) ) );
							$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('The default color will be applied if you won\'t select background and/or background hover color.', 'ark' ) ) );
							$s->addElement(ffOneElement::TYPE_NEW_LINE);
							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'text-color','', '#ffffff')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text Color', 'ark' ) ) );
							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'text-hover-color', '', '#ffffff')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text Hover Color', 'ark' ) ) );
							$s->addElement(ffOneElement::TYPE_NEW_LINE);

							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-color', '', '')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Border Color', 'ark' ) ) );
							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-hover-color', '', '')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Border Hover Color', 'ark' ) ) );
							$s->addElement(ffOneElement::TYPE_NEW_LINE);

							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', '[1]')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background Color', 'ark' ) ) );
							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-hover-color', '' , '[2]')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background Hover Color', 'ark' ) ) );

							$s->addElement(ffOneElement::TYPE_NEW_LINE);

							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-text-color', '', '#ffffff')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Color', 'ark' ) ) );
							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-text-hover-color', '' , '#ffffff')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Hover Color', 'ark' ) ) );

							$s->addElement(ffOneElement::TYPE_NEW_LINE);

							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-bg-color', '', '[1]')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Background Color', 'ark' ) ) );
							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-bg-hover-color', '' , '[1]')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Background Hover Color', 'ark' ) ) );
						$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_END);
					$s->endRepVariationSection();

					$s->startRepVariationSection('button4', ark_wp_kses( __('Button 4 (Classic With Icon)', 'ark' ) ) );
						$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_START, '', ark_wp_kses( __('Basic Options', 'ark' ) ) );

							$s->addOptionNL(ffOneOption::TYPE_TEXT, 'text', '', 'Click me!')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Button Text', 'ark' ) ) )
							;

							$s->addElement(ffOneElement::TYPE_NEW_LINE);

							$s->addOptionNL( ffOneOption::TYPE_ICON, 'icon', ark_wp_kses( __('Icon', 'ark' ) ), 'ff-font-awesome4 icon-envelope-o');

							$s->addOptionNL(ffOneOption::TYPE_SELECT, 'icon-position', '', 'after')
								->addSelectValue(esc_attr( __('Left', 'ark' ) ), 'before')
								->addSelectValue(esc_attr( __('Right', 'ark' ) ), 'after')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Position', 'ark' ) ) );

							$s->addElement(ffOneElement::TYPE_NEW_LINE);

							$s->addOptionNL(ffOneOption::TYPE_SELECT, 'size', '', 'sm')
								->addSelectValue(esc_attr( __('Extra small', 'ark' ) ), 'xs')
								->addSelectValue(esc_attr( __('Small', 'ark' ) ), 'sm')
								->addSelectValue(esc_attr( __('Medium', 'ark' ) ), 'md')
								->addSelectValue(esc_attr( __('Large', 'ark' ) ), 'lg')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Size', 'ark' ) ) );

							$s->addOptionNL(ffOneOption::TYPE_SELECT, 'width', '', 'auto')
								->addSelectValue(esc_attr( __('Auto', 'ark' ) ), 'btn-w-auto')
								->addSelectValue(esc_attr( __('Fullwidth', 'ark' ) ), 'btn-w-full')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Width', 'ark' ) ) );

							$s->addOptionNL(ffOneOption::TYPE_SELECT, 'radius', '', '')
								->addSelectValue(esc_attr( __('None', 'ark' ) ), '')
								->addSelectValue(esc_attr( __('Small (3px)', 'ark' ) ), 'radius-3')
								->addSelectValue(esc_attr( __('Medium (6px)', 'ark' ) ), 'radius-6')
								->addSelectValue(esc_attr( __('Large (10px)', 'ark' ) ), 'radius-10')
								->addSelectValue(esc_attr( __('Extra large (50px)', 'ark' ) ), 'radius-50')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Border Radius', 'ark' ) ) );

							$s->addOptionNL(ffOneOption::TYPE_SELECT, 'hover-animation', '', '')
								->addSelectValue(esc_attr( __('None', 'ark' ) ), '')
								->addSelectValue(esc_attr( __('Slide Top', 'ark' ) ), 'btn-slide-top')
								->addSelectValue(esc_attr( __('Slide Left', 'ark' ) ), 'btn-slide-left')
								->addSelectValue(esc_attr( __('Slide Right', 'ark' ) ), 'btn-slide-right')
								->addSelectValue(esc_attr( __('Slide Bottom', 'ark' ) ), 'btn-slide-bottom')
								->addSelectValue(esc_attr( __('Slide Center v1', 'ark' ) ), 'btn-slide-center-v1')
								->addSelectValue(esc_attr( __('Slide Center v2', 'ark' ) ), 'btn-slide-center-v2')
								->addSelectValue(esc_attr( __('Slide Center v3', 'ark' ) ), 'btn-slide-center-v3')
								->addSelectValue(esc_attr( __('Slide Corner', 'ark' ) ), 'btn-slide-corner')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Hover Animation', 'ark' ) ) );

							$s->addElement(ffOneElement::TYPE_NEW_LINE);

							$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'use-r-margin', ark_wp_kses( __('Add right margin', 'ark' ) ), 0);
							$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', ark_wp_kses( __('Adds spacing between this and the next button.', 'ark' ) ) );

						$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_END);
						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						/****************************************************************************************/
						/* LINK */
						/****************************************************************************************/
						if(!$this->getParam(self::PARAM_WITHOUT_URL)) {
							$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_START, '', ark_wp_kses( __('Link Options', 'ark' ) ) );
								$this->_getBlock(ffThemeBuilderBlock::LINK)->setParam(ffThemeBuilderBlock_Link::PARAM_TARGET, 'same')->injectOptions($s);
							$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_END);
							$s->addElement(ffOneElement::TYPE_NEW_LINE);
						}

						/****************************************************************************************/
						/* COLORS */
						/****************************************************************************************/
						$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_START, '', ark_wp_kses( __('Button Colors', 'ark' ) ) );
							$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('The default color will be applied if you won\'t select background and/or background hover color.', 'ark' ) ) );
							$s->addElement(ffOneElement::TYPE_NEW_LINE);
							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'text-color','', '[1]')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text Color', 'ark' ) ) );
							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'text-hover-color', '', '#ffffff')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text Hover Color', 'ark' ) ) );
							$s->addElement(ffOneElement::TYPE_NEW_LINE);

							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-color', '', '[1]')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Border Color', 'ark' ) ) );
							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-hover-color', '', '')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Border Hover Color', 'ark' ) ) );
							$s->addElement(ffOneElement::TYPE_NEW_LINE);

							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-text-color', '', '[1]')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Color', 'ark' ) ) );
							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-text-hover-color', '' , '#ffffff')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Hover Color', 'ark' ) ) );

							$s->addElement(ffOneElement::TYPE_NEW_LINE);

							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', '')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background Color', 'ark' ) ) );
							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-hover-color', '' , '[2]')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background Hover Color', 'ark' ) ) );
						$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_END);
					$s->endRepVariationSection();

					if( !$this->getParam(self::PARAM_WITHOUT_URL) ) {

						$s->startRepVariationSection('button5', ark_wp_kses( __('Button 5 (Play Button Classic)', 'ark' ) ) );

								$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_START, '', ark_wp_kses( __('Basic Options', 'ark' ) ) );
									$s->addOptionNL(ffOneOption::TYPE_ICON,'icon', ark_wp_kses( __('Icon', 'ark' ) ),'ff-font-awesome4 icon-play');
									$s->addElement(ffOneElement::TYPE_NEW_LINE);
									$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'use-r-margin', ark_wp_kses( __('Add right margin', 'ark' ) ), 0);
									$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('Adds spacing between this and the next button.', 'ark' ) ) ) ;
								$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_END);
								$s->addElement(ffOneElement::TYPE_NEW_LINE);

								$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_START, '', ark_wp_kses( __('Link Options', 'ark' ) ) );
									$this->_getBlock(ffThemeBuilderBlock::LINK)->setParam(ffThemeBuilderBlock_Link::PARAM_TARGET, 'same')->injectOptions($s);
								$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_END);
								$s->addElement(ffOneElement::TYPE_NEW_LINE);

								$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_START, '', ark_wp_kses( __('Button Colors', 'ark' ) ) );
									$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-color', '', '')
										->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Color', 'ark' ) ) );
									$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-hover-color', '', '')
										->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Hover Color', 'ark' ) ) );
										$s->addElement(ffOneElement::TYPE_NEW_LINE);
									$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', '')
										->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background Color', 'ark' ) ) );
									$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-hover-color', '', '')
										->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background Hover Color', 'ark' ) ) );
								$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_END);

						$s->endRepVariationSection();

						$s->startRepVariationSection('button6', ark_wp_kses( __('Button 6 (Play Button With Ripples)', 'ark' ) ) );

								$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_START, '', ark_wp_kses( __('Basic Options', 'ark' ) ) );
									$s->addOptionNL(ffOneOption::TYPE_ICON,'icon', ark_wp_kses( __('Icon', 'ark' ) ),'ff-font-awesome4 icon-play-circle');
									$s->addElement(ffOneElement::TYPE_NEW_LINE);
									$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'use-r-margin', ark_wp_kses( __('Add right margin', 'ark' ) ), 0);
									$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('Adds spacing between this and the next button.', 'ark' ) ) ) ;
								$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_END);
								$s->addElement(ffOneElement::TYPE_NEW_LINE);


								$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_START, '', ark_wp_kses( __('Link Options', 'ark' ) ) );
									$this->_getBlock(ffThemeBuilderBlock::LINK)->setParam(ffThemeBuilderBlock_Link::PARAM_TARGET, 'same')->injectOptions($s);
								$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_END);
								$s->addElement(ffOneElement::TYPE_NEW_LINE);

								$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_START, '', ark_wp_kses( __('Button Colors', 'ark' ) ) );
									$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-color', '', '')
										->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Color', 'ark' ) ) );
									$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-hover-color', '', '')
										->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Hover Color', 'ark' ) ) );
									$s->addElement(ffOneElement::TYPE_NEW_LINE);
									$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'shadow-color', '' , '')
										->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Shadow Color', 'ark' ) ) );
									$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'shadow-hover-color', '' , '')
										->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Shadow Hover Color', 'ark' ) ) );
									$s->addElement(ffOneElement::TYPE_NEW_LINE);
									$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-color', '' , '')
										->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Border 1 Color', 'ark' ) ) );
									$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-hover-color', '' , '')
										->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Border 1 Hover Color', 'ark' ) ) );
									$s->addElement(ffOneElement::TYPE_NEW_LINE);
									$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-2-color', '' , '')
										->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Border 2 Color', 'ark' ) ) );
									$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-2-hover-color', '' , '')
										->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Border 2 Hover Color', 'ark' ) ) );
								$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_END);

						$s->endRepVariationSection();



						$s->startRepVariationSection('button7', ark_wp_kses( __('Button 7 (Play Button With Border)', 'ark' ) ) );

								$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_START, '', ark_wp_kses( __('Basic Options', 'ark' ) ) );
										$s->addOptionNL(ffOneOption::TYPE_ICON,'icon',ark_wp_kses( __('Icon', 'ark' ) ),'ff-font-awesome4 icon-play');
										$s->addElement(ffOneElement::TYPE_NEW_LINE);
										$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'use-r-margin', ark_wp_kses( __('Add right margin', 'ark' ) ), 0);
										$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('Adds spacing between this and the next button.', 'ark' ) ) ) ;
								$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_END);
								$s->addElement(ffOneElement::TYPE_NEW_LINE);

								$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_START, '', ark_wp_kses( __('Link Options', 'ark' ) ) );
									$this->_getBlock(ffThemeBuilderBlock::LINK)->setParam(ffThemeBuilderBlock_Link::PARAM_TARGET, 'same')->injectOptions($s);
								$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_END);
								$s->addElement(ffOneElement::TYPE_NEW_LINE);

								$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_START, '', ark_wp_kses( __('Button Colors', 'ark' ) ) );
									$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-color', '', '')
										->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Color', 'ark' ) ) );
									$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-hover-color', '', '')
										->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Hover Color', 'ark' ) ) );
										$s->addElement(ffOneElement::TYPE_NEW_LINE);
									$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-color', '' , '')
										->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Border Color', 'ark' ) ) );
									$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-hover-color', '' , '')
										->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Border Hover Color', 'ark' ) ) );
								$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_END);

						$s->endRepVariationSection();

						$s->startRepVariationSection('button8', ark_wp_kses( __('Button 8 (Underlined Text)', 'ark' ) ) );

								$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_START, '', ark_wp_kses( __('Basic Options', 'ark' ) ) );

									$s->addOptionNL(ffOneOption::TYPE_TEXT, 'text', '', 'Watch our Video')
										->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Button Text', 'ark' ) ) )
									;
									$s->addElement(ffOneElement::TYPE_NEW_LINE);
									$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'use-r-margin', ark_wp_kses( __('Add right margin', 'ark' ) ), 0);
									$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('Adds spacing between this and the next button.', 'ark' ) ) ) ;

								$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_END);

								$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_START, '', ark_wp_kses( __('Link Options', 'ark' ) ) );
									$this->_getBlock(ffThemeBuilderBlock::LINK)->setParam(ffThemeBuilderBlock_Link::PARAM_TARGET, 'same')->injectOptions($s);
								$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_END);
								$s->addElement(ffOneElement::TYPE_NEW_LINE);

								$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_START, '', ark_wp_kses( __('Button Colors', 'ark' ) ) );
									$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'text-color', '', '')
										->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text Color', 'ark' ) ) );
									$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'text-hover-color', '', '')
										->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text Hover Color', 'ark' ) ) );
										$s->addElement(ffOneElement::TYPE_NEW_LINE);
								$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-color', '', '')
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Border Color', 'ark' ) ) );
								$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-hover-color', '', '')
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Border Hover Color', 'ark' ) ) );
								$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_END);

						$s->endRepVariationSection();


						$s->startRepVariationSection('button9', ark_wp_kses( __('Button 9 (Play Button With Hover)', 'ark' ) ) );

								$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_START, '', ark_wp_kses( __('Basic Options', 'ark' ) ) );

									$s->startAdvancedToggleBox('button9-icon',esc_attr( __('Icon', 'ark' ) ) );
										$s->addOptionNL(ffOneOption::TYPE_ICON,'icon', ark_wp_kses( __('Icon', 'ark' ) ),'ff-font-awesome4 icon-play');
									$s->endAdvancedToggleBox();
									$s->startAdvancedToggleBox('button9',esc_attr( __('Button Text Hover', 'ark' ) ) );
										$s->addOptionNL(ffOneOption::TYPE_TEXT, 'text', '', 'Watch Video')
											->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Button Text Hover', 'ark' ) ) )
										;
									$s->endAdvancedToggleBox();
								$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_END);
								$s->addElement(ffOneElement::TYPE_NEW_LINE);

								$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_START, '', ark_wp_kses( __('Link Options', 'ark' ) ) );
									$this->_getBlock(ffThemeBuilderBlock::LINK)->setParam(ffThemeBuilderBlock_Link::PARAM_TARGET, 'same')->injectOptions($s);
								$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_END);
								$s->addElement(ffOneElement::TYPE_NEW_LINE);

								$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_START, '', ark_wp_kses( __('Button Colors', 'ark' ) ) );
									$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-color', '', '')
										->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Color', 'ark' ) ) );
									$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-hover-color', '', '')
										->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Hover Color', 'ark' ) ) );
										$s->addElement(ffOneElement::TYPE_NEW_LINE);
									$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', '')
										->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background Color', 'ark' ) ) );
									$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-hover-color', '', '')
										->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background Hover Color', 'ark' ) ) );
										$s->addElement(ffOneElement::TYPE_NEW_LINE);
									$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'text-color', '', '')
										->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text Color', 'ark' ) ) );
									$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'text-hover-color', '', '')
										->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text Hover Color', 'ark' ) ) );
								$s->addElement(ffOneElement::TYPE_TOGGLE_BOX_END);

						$s->endRepVariationSection();

						$s->startRepVariationSection('separator', ark_wp_kses( __('Separator', 'ark' ) ) );
								$s->addOptionNL(ffOneOption::TYPE_TEXT, 'text', '', 'or')
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
								;
								$s->addElement(ffOneElement::TYPE_NEW_LINE);
								$s->addOptionNL(ffOneOption::TYPE_CHECKBOX, 'use-r-margin', ark_wp_kses( __('Add right margin', 'ark' ) ), 1);
								$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('Adds spacing between this and the next button.', 'ark' ) ) ) ;
						$s->endRepVariationSection();

					}

				$s->endRepVariableSection();

	}

	protected function _renderContentInfo_JS() {
		?>
		<script data-type="ffscript">
			function ( query, params ) {

				if( query == null || !query.exists('button') ) {
				} else{
					query.get('button').each(function(query, variationType ) {
						switch(variationType) {
							case 'button1':
								var buttonText = query.getWithoutComparationDefault('text', 'Click me!');
								if( ( null != buttonText ) && ( '' != buttonText ) ) {
									query.addLink(null, buttonText);
								}
								break;
							case 'button2':
								var buttonText = query.getWithoutComparationDefault('text', 'Click me!');
								if( ( null != buttonText ) && ( '' != buttonText ) ) {
									query.addLink(null, buttonText);
								}
								break;
							case 'button3':
								var buttonText = query.getWithoutComparationDefault('text', 'Click me!');
								if( ( null != buttonText ) && ( '' != buttonText ) ) {
									query.addLink(null, buttonText);
								}
								break;
							case 'button4':
								var buttonText = query.getWithoutComparationDefault('text', 'Click me!');
								if( ( null != buttonText ) && ( '' != buttonText ) ) {
									query.addLink(null, buttonText);
								}
								break;
							case 'button5':
								var iconClass = query.getWithoutComparationDefault('icon', 'ff-font-awesome4 icon-play');
								var toPrint = '<div class="ffb-preview-icon"><i class="ffb-preview-icon-content ' + iconClass + '"></i></div>';
								query.addPlainText( toPrint );
								break;
							case 'button6':
								var iconClass = query.getWithoutComparationDefault('icon', 'ff-font-awesome4 icon-play-circle');
								var toPrint = '<div class="ffb-preview-icon"><i class="ffb-preview-icon-content ' + iconClass + '"></i></div>';
								query.addPlainText( toPrint );
								break;
							case 'button7':
								var iconClass = query.getWithoutComparationDefault('icon', 'ff-font-awesome4 icon-play');
								var toPrint = '<div class="ffb-preview-icon"><i class="ffb-preview-icon-content ' + iconClass + '"></i></div>';
								query.addPlainText( toPrint );
								break;
							case 'button8':
								var buttonText = query.getWithoutComparationDefault('text', 'Watch our Video');
								if( ( null != buttonText ) && ( '' != buttonText ) ) {
									query.addLink(null, buttonText);
								}
								break;
							case 'button9':
								var iconClass = query.getWithoutComparationDefault('button9-icon icon', 'ff-font-awesome4 icon-play');
								var toPrint = '<div class="ffb-preview-icon"><i class="ffb-preview-icon-content ' + iconClass + '"></i></div>';
								query.addPlainText( toPrint );
								break;
								
						}
					});
				}
			}
		</script data-type="ffscript">
	<?php
	}
/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS 
/**********************************************************************************************************************/
}