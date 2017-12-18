<?php
class ffOptionsHolder_SitePreferences extends ffOptionsHolder {
	public function getOptions() {

		// == startSection


		$s = $this->_getOnestructurefactory()
			->createOneStructure( 'sitepref' );

		$sh = $s->getOptionsStructureHelper();

		$s->startSection('sitepref');
			$s->addElement( ffOneElement::TYPE_TABLE_START );

				$s->addElement( ffOneElement::TYPE_TABLE_DATA_START,'', 'Header');

					$s->addOptionNL( ffOneOption::TYPE_OPTIONS_COLLECTION, 'header', '', 'header_default')
						->addParam('namespace', 'header')
						->addParam('namespace-name', 'Headers')
						->addSelectValue('Inherit from Theme Options', 'inherit', 'System')
						->addSelectValue('None', 'none', 'System')
					;

				$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

				$s->addElement( ffOneElement::TYPE_TABLE_DATA_START,'', 'Titlebar');

					$s->addOptionNL( ffOneOption::TYPE_OPTIONS_COLLECTION, 'titlebar', '', 'titlebar_default')
						->addParam('namespace', 'titlebar')
						->addParam('namespace-name', 'Titlebars')
						->addSelectValue('Inherit from Theme Options', 'inherit', 'System')
						->addSelectValue('None', 'none', 'System')
					;

				$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

				$s->addElement( ffOneElement::TYPE_TABLE_DATA_START,'', 'Footer');

					$s->addOptionNL( ffOneOption::TYPE_OPTIONS_COLLECTION, 'footer', '', 'footer_default')
						->addParam('namespace', 'footer')
						->addParam('namespace-name', 'Footers')
						->addSelectValue('Inherit from Theme Options', 'inherit', 'System')
						->addSelectValue('None', 'none', 'System')
					;

				$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );

				$s->addElement( ffOneElement::TYPE_TABLE_DATA_START,'', 'Boxed Wrappers');

					$s->addOptionNL( ffOneOption::TYPE_OPTIONS_COLLECTION, 'boxed_wrapper', '', 'boxed_wrapper_default')
						->addParam('namespace', 'boxed_wrapper')
						->addParam('namespace-name', 'Boxed Wrappers')
						->addSelectValue('None', 'none', 'System')
						->addSelectValue('Inherit from Theme Options', 'inherit', 'System')
					;

				$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );


			$s->addElement( ffOneElement::TYPE_TABLE_END );

			$fixedToolbarToPrint = '';
			$fixedToolbarToPrint .= '<div class="ffb-builder-toolbar-fixed-wrapper">';
				$fixedToolbarToPrint .= '<div class="ffb-builder-toolbar-fixed clearfix">';
					$fixedToolbarToPrint .= '<div class="ffb-builder-toolbar-fixed-left">';
						$fixedToolbarToPrint .= '<input type="submit" value="Quick Save" class="ff-save-ajax ffb-main-save-ajax-btn ffb-builder-toolbar-fixed-btn">';
					$fixedToolbarToPrint .= '</div>';
					$fixedToolbarToPrint .= '<div class="ffb-builder-toolbar-fixed-right">';
					$fixedToolbarToPrint .= '</div>';
				$fixedToolbarToPrint .= '</div>';
			$fixedToolbarToPrint .= '</div>';

			$s->addElement(ffOneElement::TYPE_HTML, '', $fixedToolbarToPrint );

		$s->endSection();



		return $s;
	}
}