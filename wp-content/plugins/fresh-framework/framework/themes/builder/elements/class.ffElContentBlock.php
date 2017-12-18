<?php

/**
 * Class ffElContentBlock
 */
class ffElContentBlock extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'content-block');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, 'Template');

		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_CAN_BE_CACHED, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, false);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'basic');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'template, reference, dynamic, global');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 0);

		$this->_setData( ffThemeBuilderElement::DATA_HAS_SYSTEM_TABS, false );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_WRAPPER, false );
	}

	public function getPreviewImageUrl() {
		return ffContainer()->getWPLayer()->getFrameworkUrl() . '/framework/themes/builder/elements/content-block.jpg';
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement(ffOneElement::TYPE_TABLE_DATA_START, '', 'Info' );

				$description = '<strong>Templates allow you to insert your content into multiple places without duplication.</strong> You can customize a Template from one central place and have these changes automatially reflected anywhere you have inserted that Template.';
				
				$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', $description );
				$s->addElement( ffOneElement::TYPE_DESCRIPTION, '', '<a href="'.esc_attr(admin_url('post-new.php?post_type=ff-content-block')).'" target="_blank">Create New Template</a>' );

			$s->addElement(ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement(ffOneElement::TYPE_TABLE_DATA_START, '', 'Selected Template' );
				
				$s->addElement(ffOneElement::TYPE_HTML,'', '<div class="ff-content-block-area">');

					$s->addOptionNL(ffOneOption::TYPE_POST_SELECTOR,'content-block','','not--||--Not Selected')
						->addParam('post_type', 'ff-template')
						->addParam('load-dynamic', true)
						->addSelectValue('Not Selected', 'not--||--Not Selected' )
					;

					$s->addElement( ffOneElement::TYPE_NEW_LINE);

					$s->addElement(ffOneElement::TYPE_HTML,'', '<a class="ff-post-edit-link" target="_blank" href="" data-edit-url="' .esc_attr(admin_url('post.php?post=!!!POST_ID!!!&action=edit')) . '">Edit selected Template</a>' );
				$s->addElement(ffOneElement::TYPE_HTML,'', '</div>');

			$s->addElement(ffOneElement::TYPE_TABLE_DATA_END);

		$s->addElement( ffOneElement::TYPE_TABLE_END );
	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		$contentBlockId = $query->getPost('content-block')->id;

		if( $contentBlockId == null || $contentBlockId == 'not' ) {
			return false;
		}

		$contentBlock = $this->_getWPLayer()->get_post( $contentBlockId );

		if( empty( $contentBlock) ) {
			return false;
		}

		echo $this->_doShortcode( $contentBlock->post_content );
	}

	protected function _renderContentInfo_JS() {
		?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, blocks, preview, elementView, $form ) {
				var value = query.get('content-block');

				if( value == '' ) {
					preview.addHeadingLg('Not Selected');
				} else {
					var valueSplitted = value.split('--||--');
					var name = valueSplitted[1];
//
					preview.addHeadingLg( name );
				}
 
			}
		</script data-type="ffscript">
		<?php
	}
}