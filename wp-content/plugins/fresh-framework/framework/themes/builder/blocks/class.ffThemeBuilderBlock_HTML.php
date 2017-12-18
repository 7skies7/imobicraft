<?php

class ffThemeBuilderBlock_HTML extends ffThemeBuilderBlockBasic {
	const PARAM_INSERT_DESCRIPTION = 'insert_description';
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
		$this->_setInfo( ffThemeBuilderBlock::INFO_ID, 'html');
		$this->_setInfo( ffThemeBuilderBlock::INFO_WRAPPING_ID, 'html');
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


	protected function _render( $query ) {

		if( $this->_queryIsEmpty() ) {
			return '';
		}

		$htmlValue = htmlspecialchars_decode($query->getWithoutComparationDefault('html', ''));

		$wrapper = $query->getWithoutComparationDefault('wrapper', '');

		if( $wrapper == 'custom' ) {
			$wrapper = $query->getWithoutComparationDefault('wrapper-element', '');
		}

		if( !empty( $wrapper ) ) {
			echo '<' . $wrapper . '>';
		}

		if( $query->getWithoutComparationDefault('use-as-php') ) {
			eval( $htmlValue );
		} else {
			if( $htmlValue != '' ) {
				echo do_shortcode($query->getTextarea('html', '', '', '<div class="ff-richtext">', '</div>'));
			}

		}

		if( !empty( $wrapper ) ) {
			echo '</' . $wrapper . '>';
		}


	}

	protected function _injectOptions( ffThemeBuilderOptionsExtender $s ) {

		$s->addOption( ffOneOption::TYPE_SELECT, 'wrapper', '', '', '')
			->addSelectValue('None', '')
			->addSelectValue('div', 'div')
			->addSelectValue('span', 'span')
			->addSelectValue('p', 'p')
			->addSelectValue('Custom', 'custom')
			->addParam(ffOneOption::PARAM_TITLE_AFTER, 'Wrapping element');
		;

		$description = 'IMPORTANT: All settings from the system tabs (Box Model, Typography, etc.), will be applied only if your HTML element has a wrapping element. You may encounter errors if you attempt to apply settings from system tabs on your HTML element without having any wrapping element.';

		$s->addElement(ffOneElement::TYPE_DESCRIPTION, '', $description);

		$s->startHidingBox('wrapper', 'custom');
		$s->addOption( ffOneOption::TYPE_TEXT, 'wrapper-element', '', '')
			->addParam(ffOneOption::PARAM_TITLE_AFTER, 'Custom wrapping element tag, example: <code>div</code>');
		$s->endHidingBox();

		$s->addElement( ffOneElement::TYPE_NEW_LINE );

		if( $this->getParam( ffThemeBuilderBlock_HTML::PARAM_INSERT_DESCRIPTION, true ) ) {
			$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'You can insert your HTML code below. But if you enable the PHP Mode, then you must write in PHP syntax only.');
			$s->addElement( ffOneElement::TYPE_NEW_LINE );
		}

		$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'html', 'Html', '' );
//		$s->addTinyMCE( 'html', '', '');
		$s->addOption( ffOneOption::TYPE_CHECKBOX, 'use-as-php', 'PHP Mode', 0);
		$s->startHidingBox('use-as-php', 'checked');
			$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'Please note, that you should not use the opening <code>&lt;?php</code> tag at the beginning of the file. You should start writing the PHP code directly.');
		$s->endHidingBox();
	}

	protected function _renderContentInfo_JS() {
		?>
		<script data-type="ffscript">
			function ( query, params ) {
				var toReturn = '';

				var htmlUncleaned = query.get('html');
				if ( htmlUncleaned != null ){
					toReturn = htmlUncleaned.split('<').join('&lt;').split('>').join('&gt;');

					query.addText(null, toReturn );
				}
//				return toReturn;

			}
		</script data-type="ffscript">
		<?php
	}
	
	
/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/
}