<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/page_contacts.html#scrollTo__0
 */

class ffElAnimatedHeading extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'animated-heading');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Animated Heading', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'heading');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'heading, animated');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 2);

		$this->_setColor('light');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );

		$s->startRepVariableSection('content');

		/* TITLE */
		$s->startRepVariationSection('title', ark_wp_kses( __('Text', 'ark' ) ));
		$s->addOptionNL(ffOneOption::TYPE_TEXT,'text','','I\'d like to talk <br> about')
			->addParam('print-in-content', true)
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
		;
		$s->endRepVariationSection();

		/* SEPARATOR */
		$s->startRepVariationSection('separator', ark_wp_kses( __('Text Separator', 'ark' ) ));
		$s->addOptionNL(ffOneOption::TYPE_TEXT,'text','',' ... ')
			->addParam('print-in-content', true)
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
		;
		$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'color', '', '[1]')
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text color', 'ark' ) ) )
		;
		$s->endRepVariationSection();

		/* ANIMATED LABELS */
		$s->startRepVariationSection('animated-labels', ark_wp_kses( __('Animated Text', 'ark' ) ));

		$s->startRepVariableSection('content');

		$s->startRepVariationSection('label', ark_wp_kses( __('One Animation', 'ark' ) ));
		$s->addOptionNL(ffOneOption::TYPE_TEXT, 'text', '', ark_wp_kses( __('Graphic Design', 'ark' ) ) )
			->addParam('print-in-content', true)
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
		;
		$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'color', '', '[1]')
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text color', 'ark' ) ) )
		;
		$s->endRepVariationSection();

		$s->endRepVariableSection();

		$s->endRepVariationSection();

		$s->endRepVariableSection();

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('HTML Tag', 'ark' ) ) );
		$s->addOptionNL(ffOneOption::TYPE_SELECT,'type','','h2')
			->addSelectValue('H1','h1')
			->addSelectValue('H2','h2')
			->addSelectValue('H3','h3')
			->addSelectValue('H4','h4')
			->addSelectValue('H5','h5')
			->addSelectValue('H6','h6')
			->addSelectValue('P','p')
			->addSelectValue('DIV','div')
			->addSelectValue('SPAN','span')
		;
		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Text Alignment', 'ark' ) ) );
		$this->_getElementGeneralOptionsTextAlignClasses( $s, 'align', 'text-center' );
		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Colors', 'ark' ) ) );
		$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', 'rgba(52,52,60,0.5)')
			->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Background', 'ark' ) ) )
		;
		$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		$s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _renderColor( $query, $cssAttribute, $cssAfterAttribute = null, $selector = null ) {

		if( $query && $selector ){
			$this->getAssetsRenderer()->createCssRule()
				->addSelector($selector)
				->addParamsString( $cssAttribute .': '. $query .' '. $cssAfterAttribute .';');;
		} else if( $query ){
			$this->getAssetsRenderer()->createCssRule()
				->addParamsString( $cssAttribute .': '. $query .';');
		}

	}

	protected function _enqueueScriptsAndStyles( $query ) {
		wp_enqueue_script( 'ark-animated-headline' );
	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		if( ! $query->exists('content') ) {
			return;
		}

//		wp_enqueue_script( 'ark-animated-headline');

		$this->_renderCSSRule( 'background-color', $query->getColor( 'bg-color' ) );

		echo '<section class="animated-headline-v1 '
			. esc_attr( $this->_getGeneralTextAlignClasses( $query, 'align', 'text-center' ) )
			. '">';

		echo '<'.$query->getEscAttr('type').' class="animated-headline-title letters type">';

		foreach( $query->get('content') as $oneLine ) {
			switch( $oneLine->getVariationType() ) {

				case 'title':
					echo '<span class="animated-headline-v1-title">'. ark_wp_kses($oneLine->get('text')) .'</span>';
					break;

				case 'separator':
					ffElAnimatedHeading::_renderColor( $oneLine->getColor('color'), 'color' );

					echo '<span class="animated-headline-v1-separator">'. $oneLine->getWpKses('text') .'</span>';
					break;

				case 'animated-labels':
					if ( !$oneLine->exists('content') ){
						break;
					}
					echo '<span class="animated-headline-wrap waiting">';
					foreach( $oneLine->get('content') as $key => $oneLabel ) {

						ffElAnimatedHeading::_renderColor( $oneLabel->getColor('color'), 'color' );

						if( 0 == $key ){
							echo '<b class="is-visible">'. $oneLabel->getWpKses('text') .'</b>';
						} else {
							echo '<b>'. $oneLabel->getWpKses('text') .'</b>';
						}

					}
					echo '</span>';
					echo '&nbsp;';
					break;

			}
		}

		echo '</'.$query->getEscAttr('type').'>';
		echo '</section>';

	}

	protected function _renderContentInfo_JS() {
		?>
		<script data-type="ffscript">
			function ( query, options, $slementPreview, $slement ) {

				if(query.queryExists('content')) {
					query.get('content').each(function (query, variationType) {
						switch (variationType) {
							case 'title':
								query.addHeadingSm('text');
								break;
							case 'separator':
								query.addHeadingSm('text');
								break;
							case 'animated-labels':
								query.get('content').each(function (query, variationType) {
									switch (variationType) {
										case 'label':
											query.addHeadingSm('text');
											break;
									}
								});

						}
					});
				}


			}
		</script data-type="ffscript">
		<?php
	}


}