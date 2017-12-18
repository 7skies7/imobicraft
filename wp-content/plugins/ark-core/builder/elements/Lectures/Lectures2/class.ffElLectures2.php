<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_timeline.html#scrollTo__1954
 */

class ffElLectures2 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'lectures-2');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Schedule 2', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'schedule');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'lecture, lectures 2, schedule, time, table');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 2);

		$this->_setColor('dark');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Content', 'ark' ) ) );

				$s->startRepVariableSection('content');

					/*----------------------------------------------------------*/
					/* TYPE LECTURE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('date', ark_wp_kses( __('Date', 'ark' ) ) );

						$s->startRepVariableSection('content');

							/* TYPE DAY */
							$s->startRepVariationSection('day', ark_wp_kses( __('Day', 'ark' ) ) );
								$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Tuesday')
									->addParam('print-in-content', true)
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
								;
								$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'day-color', '', '[1]')
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text color', 'ark' ) ) )
								;
							$s->endRepVariationSection();

							/* TYPE MONTH */
							$s->startRepVariationSection('month', ark_wp_kses( __('Month & Year', 'ark' ) ) );
								$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'August, 08, 2016')
									->addParam('print-in-content', true)
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
								;
								$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'date-color', '', '[1]')
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text color', 'ark' ) ) )
								;
							$s->endRepVariationSection();

						$s->endRepVariableSection();

					$s->endRepVariationSection();

					/*----------------------------------------------------------*/
					/* TYPE LECTURE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('lecture', ark_wp_kses( __('Schedule', 'ark' ) ) );

						$s->addOptionNL( ffOneOption::TYPE_ICON, 'icon', ark_wp_kses( __('Icon', 'ark' ) ), 'ff-font-awesome4 icon-comments-o')
							->addParam('print-in-content', true)
						;
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'color', '', '#a3a3a3')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Color', 'ark' ) ) )
						;
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'icon-bg-color', '', '#ffffff')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon Background Color', 'ark' ) ) )
						;
						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$s->startRepVariableSection('content');

							/* TYPE TITLE */
							$s->startRepVariationSection('title', ark_wp_kses( __('Title', 'ark' ) ) );
								$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Commented')
									->addParam('print-in-content', true)
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
								;
								$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'text-color', '', '#e57287')
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text color', 'ark' ) ) )
								;
								$this->_getBlock( ffThemeBuilderBlock::LINK)->injectOptions( $s );

							$s->endRepVariationSection();

							/* TYPE DESCRIPTION */
							$s->startRepVariationSection('description', ark_wp_kses( __('Paragraph', 'ark' ) ) );
								$s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'text', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.')
									->addParam('print-in-content', true)
								;
								$this->_getBlock( ffThemeBuilderBlock::LINK)->injectOptions( $s );

							$s->endRepVariationSection();

						$s->endRepVariableSection();

					$s->endRepVariationSection();

				$s->endRepVariableSection();

				// Do not delete, any Element needs to have at least one (hidden) option
				$s->addElement( ffOneElement::TYPE_HTML, '', '<div class="hidden">' );
					$s->addOption( ffOneOption::TYPE_TEXT, 'blank', 'blank');
				$s->addElement( ffOneElement::TYPE_HTML, '', '</div>' );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Schedule Colors', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'vert-line-color', '', '#e7eaf0')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Vertical Line Color', 'ark' ) ) )
				;

				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'hor-line-color', '', '#e7eaf0')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Horizontal Line Color', 'ark' ) ) )
				;

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		 $s->addElement( ffOneElement::TYPE_TABLE_END );

	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

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

	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {
		if( ! $query->exists('content') ) {
			return;
		}

		ffElLectures2::_renderColor( $query->getColor('vert-line-color'), 'background-color', null, '.timeline-v2:before' );
		ffElLectures2::_renderColor( $query->getColor('hor-line-color'), 'border-top-color', null, '.timeline-v2-current-date' );

		echo '<section class="lectures-v2">';
			echo '<ul class="timeline-v2">';

				foreach( $query->get('content') as $oneItem ) {
					switch ($oneItem->getVariationType()) {

						case 'date':
							if( $oneItem->exists('content')  ) {
								echo '<li class="timeline-v2-current-date">';

									foreach( $oneItem->get('content') as $oneLabel ) {
										switch ($oneLabel->getVariationType()) {
											case 'day':
												ffElLectures2::_renderColor( $oneLabel->getColor('day-color'), 'color' );

												echo '<h5 class="timeline-v2-current-day">' . $oneLabel->getWpKses('text') . '</h5>';
												break;

											case 'month':
												ffElLectures2::_renderColor( $oneLabel->getColor('date-color'), 'color' );

												echo '<small class="timeline-v2-current-time">' . $oneLabel->getWpKses('text') . '</small>';
												break;
										}
									}

								echo '</li>';
							}
							break;

						case 'lecture':
							echo '<li class="timeline-v2-list-item">';

								ffElLectures2::_renderColor( $oneItem->getColor('color'), 'color', null, '.timeline-v2-badge-icon' );
								ffElLectures2::_renderColor( $oneItem->getColor('icon-bg-color'), 'background-color', null, '.timeline-v2-badge-icon' );

								echo '<i class="timeline-v2-badge-icon radius-circle '. $oneItem->getEscAttr('icon') .'"></i>';

								if( $oneItem->exists('content')  ) {
									foreach( $oneItem->get('content') as $oneLabel ) {
										switch ($oneLabel->getVariationType()) {

											case 'title':
												if( $this->_getBlock( ffThemeBuilderBlock::LINK )->urlHasBeenFilled( $oneLabel ) ) {
													echo '<a ';
														$this->_getBlock( ffThemeBuilderBlock::LINK )->render( $oneLabel );
													echo '>';
												}

													ffElLectures2::_renderColor( $oneLabel->getColor('text-color'), 'color' );

													echo '<small class="timeline-v2-news-date">'. $oneLabel->getWpKses('text') .'</small>';
												if( $this->_getBlock( ffThemeBuilderBlock::LINK )->urlHasBeenFilled( $oneLabel ) ) {
													echo '</a>';
												}
												break;

											case 'description':
												echo '<h5 class="timeline-v2-news-title">';
													if( $this->_getBlock( ffThemeBuilderBlock::LINK )->urlHasBeenFilled( $oneLabel ) ) {
														echo '<a ';
															$this->_getBlock( ffThemeBuilderBlock::LINK )->render( $oneLabel );
														echo '>';
													}
														$oneLabel->printWpKses('text');
													if( $this->_getBlock( ffThemeBuilderBlock::LINK )->urlHasBeenFilled( $oneLabel ) ) {
														echo '</a>';
													}
												echo '</h5>';
												break;
										}
									}
								}

							echo '</li>';
							break;
					}
				}

			echo '</ul>';
		echo '</section>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, preview ) {

				if(query.queryExists('content')) {
					query.get('content').each(function (query, variationType) {
						switch (variationType) {
							case 'date':
								query.get('content').each(function (query, variationType) {
									switch (variationType) {
										case 'day':
											query.addHeadingLg('text');
											break;
										case 'month':
											query.addHeadingSm('text');
											query.addPlainText('<br/>');
											break;
									}
								});
								break;

						}
					});
				}

			}
		</script data-type="ffscript">
	<?php
	}


}