<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/portfolio_single_video_youtube.html#scrollTo__590
 * */

class ffElPortfolioSidebar extends ffElPortfolio {
	protected function _initData() {
		$this->_setData(ffThemeBuilderElement::DATA_ID, 'portfolio-sidebar');
		$this->_setData(ffThemeBuilderElement::DATA_NAME, esc_attr( __('Portfolio Sidebar', 'ark' ) ) );
		$this->_setData(ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData(ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);
		$this->_setData( ffThemeBuilderElement::DATA_CAN_BE_CACHED, false);

		$this->_setData(ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'portfolio');
		$this->_setData(ffThemeBuilderElement::DATA_PICKER_TAGS, 'portfolio, single, sidebar');

		$this->_setColor('dark');
	}

	protected function _getElementGeneralOptions($s) {

		$s->addElement(ffOneElement::TYPE_TABLE_START);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Info', 'ark' ) ) );
				$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('NOTE: This element must be placed within Single Portfolio Post to be fully functional.', 'ark' ) ) );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );

				$s->startRepVariableSection('content');

					/* PUBLISHED */
					$s->startRepVariationSection('published', ark_wp_kses( __('Published', 'ark' ) ));
						$s->startAdvancedToggleBox('title', esc_attr( __('Title', 'ark' ) ));
							$s->addOptionNL( ffOneOption::TYPE_TEXT, 'title', '', 'Published')
								->addParam('print-in-content', true);
						$s->endAdvancedToggleBox();

						$s->startAdvancedToggleBox('date-format', esc_attr( __('Date', 'ark' ) ));
							$s->addOptionNL( ffOneOption::TYPE_TEXT, 'date-format', '', get_option( 'date_format' ) )
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Date Format', 'ark' ) ) );
							$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', ark_wp_kses( __('Available date formats: <a href="//php.net/manual/en/function.date.php" target="_blank">Date PHP function manual</a>', 'ark' ) ) );
						$s->endAdvancedToggleBox();

					$s->endRepVariationSection();

					/* CATEGORIES */
					$s->startRepVariationSection('categories', ark_wp_kses( __('Categories', 'ark' ) ));
						$s->startAdvancedToggleBox('title', esc_attr( __('Title', 'ark' ) ));
							$s->addOptionNL( ffOneOption::TYPE_TEXT, 'title', '', 'Categories')
								->addParam('print-in-content', true);
						$s->endAdvancedToggleBox();
					$s->endRepVariationSection();

					/* TAGS */
					$s->startRepVariationSection('tags', ark_wp_kses( __('Tags', 'ark' ) ));
						$s->startAdvancedToggleBox('title', esc_attr( __('Title', 'ark' ) ));
							$s->addOptionNL( ffOneOption::TYPE_TEXT, 'title', '', 'Tags')
								->addParam('print-in-content', true);
						$s->endAdvancedToggleBox();
					$s->endRepVariationSection();

					/* TAGS */
					$s->startRepVariationSection('share', ark_wp_kses( __('Share', 'ark' ) ));
						$s->startAdvancedToggleBox('title', esc_attr( __('Title', 'ark' ) ));
							$s->addOptionNL( ffOneOption::TYPE_TEXT, 'title', '', 'Share')
								->addParam('print-in-content', true);
						$s->endAdvancedToggleBox();

						$s->addElement(ffOneElement::TYPE_NEW_LINE);
						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$this->_getBlock( ffThemeBlConst::ICONS )->injectOptions( $s );

					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content Alignment', 'ark' ) ) );
				$s->addOption( ffOneOption::TYPE_SELECT, 'text-alignment', '', 'text-left')
					->addSelectValue( esc_attr( __('Left', 'ark' ) ), 'text-left')
					->addSelectValue( esc_attr( __('Center', 'ark' ) ), 'text-center')
					->addSelectValue( esc_attr( __('Right', 'ark' ) ), 'text-right');
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Colors', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'widget-title', '' , '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Widget Title', 'ark' ) ) );

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'widget-text', '' , '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Widget Text', 'ark' ) ) );

				$s->addElement(ffOneElement::TYPE_NEW_LINE);
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'widget-link', '' , '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Widget Links', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'widget-link-hover', '' , '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Widget Links Hover', 'ark' ) ) );

				$s->addElement(ffOneElement::TYPE_NEW_LINE);

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-line', '' , '#eeeeee')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Line Divider between Widgets', 'ark' ) ) );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


		$s->addElement(ffOneElement::TYPE_TABLE_END);


	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		if( ! $query->exists('content') ) {
			return;
		}

		echo '<section class="portfolio-sidebar '. $query->getEscAttr('text-alignment') .'">';

		foreach( $query->get('content') as $oneLine ) {
			switch ($oneLine->getVariationType()) {

				case 'published':
					echo '<div class="portfolio-sidebar-widget portfolio-sidebar-published">';
					$this->_advancedToggleBoxStart( $oneLine->get('title') );
						echo '<h3 class="portfolio-item-subitem-title">'. $oneLine->getEscAttr('title title') .'</h3>';
					$this->_advancedToggleBoxEnd( $oneLine->get('title') );
					$this->_advancedToggleBoxStart( $oneLine->get('date-format') );
						echo '<p class="portfolio-item-subitem-paragraph">'. get_the_date( $oneLine->getEscAttr('date-format date-format') ) .'</p>';
					$this->_advancedToggleBoxEnd( $oneLine->get('date-format') );
					echo '</div>';
					break;

				case 'categories':
					$tax = wp_get_post_terms(get_the_ID(), 'ff-portfolio-category');
					if( empty($tax) ){
						break;
					}
					echo '<div class="portfolio-sidebar-widget portfolio-sidebar-categories">';
					$this->_advancedToggleBoxStart( $oneLine->get('title') );
						echo '<h3 class="portfolio-item-subitem-title">'. $oneLine->getEscAttr('title title') .'</h3>';
					$this->_advancedToggleBoxEnd( $oneLine->get('title') );
					echo '<ul class="list-unstyled tags-v2 margin-b-0">';
					foreach( $tax as $oneTax ) {
						echo '<li><a href="'.get_term_link($oneTax).'">';
						echo ark_wp_kses( $oneTax->name );
						echo '</a></li>';
					}
					echo '</ul>';
					echo '</div>';
					break;

				case 'tags':
					$tax = wp_get_post_terms(get_the_ID(), 'ff-portfolio-tag');
					if( empty($tax) ){
						break;
					}
					echo '<div class="portfolio-sidebar-widget portfolio-sidebar-tags">';
					$this->_advancedToggleBoxStart( $oneLine->get('title') );
						echo '<h3 class="portfolio-item-subitem-title">'. $oneLine->getEscAttr('title title') .'</h3>';
					$this->_advancedToggleBoxEnd( $oneLine->get('title') );
					echo '<ul class="list-unstyled tags-v2 margin-b-0">';
					foreach( $tax as $oneTax ) {
						echo '<li><a href="'.get_term_link($oneTax).'">';
							echo ark_wp_kses( $oneTax->name );
						echo '</a></li>';
					}
					echo '</ul>';
					echo '</div>';
					break;

				case 'share':

					echo '<div class="portfolio-sidebar-widget portfolio-sidebar-share">';
					$this->_advancedToggleBoxStart( $oneLine->get('title') );
						echo '<h3 class="portfolio-item-subitem-title">'. $oneLine->getEscAttr('title title') .'</h3>';
					$this->_advancedToggleBoxEnd( $oneLine->get('title') );

					$this->_getBlock(ffThemeBlConst::ICONS)->render($oneLine);

					echo '</div>';
					break;

			}
		}

		echo '</section>';

		if( $query->getColor('widget-title') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .portfolio-item-subitem-title', false)
				->addParamsString('color: '.$query->getColor('widget-title').';');
		}

		if( $query->getColor('widget-text') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .portfolio-sidebar-widget', false)
				->addParamsString('color: '.$query->getColor('widget-text').';');
		}

		if( $query->getColor('widget-text') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .portfolio-sidebar-widget p', false)
				->addParamsString('color: '.$query->getColor('widget-text').';');
		}

		if( $query->getColor('widget-link') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .portfolio-sidebar-widget a:not(:hover)', false)
				->addParamsString('color: '.$query->getColor('widget-link').';');
		}

		if( $query->getColor('widget-link-hover') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .portfolio-sidebar-widget a:hover', false)
				->addParamsString('color: '.$query->getColor('widget-link-hover').';');
		}

		if( $query->getColor('border-line') ) {
			$this->getAssetsRenderer()->createCssRule()
				->setAddWhiteSpaceBetweenSelectors(false)
				->addSelector(' .portfolio-sidebar-widget:not(:last-child)', false)
				->addParamsString('border-bottom: 1px solid '.$query->getColor('border-line').';');
		}

	}

	protected function _renderContentInfo_JS() {
		?>
		<script data-type="ffscript">
			function ( query, options, $slementPreview, $slement, blocks ) {

				if(query.queryExists('content')) {
					query.get('content').each(function (query, variationType) {
						switch (variationType) {
							case 'published':
							case 'tags':
							case 'categories':
							case 'share':
								query.addText('title title');
								break;
						}
					});
				}

			}
		</script data-type="ffscript">
		<?php
	}


}