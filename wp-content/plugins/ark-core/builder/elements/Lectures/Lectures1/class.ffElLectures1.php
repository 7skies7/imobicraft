<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/shortcodes_timeline.html#scrollTo__1954
 */

class ffElLectures1 extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'lectures-1');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Schedule 1', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);

		$this->_setData( ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'schedule');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_TAGS, 'lecture, lectures 1, schedule, time, table');
		$this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 2);

		$this->_setColor('dark');
	}

	protected function _getElementGeneralOptions( $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Date Content', 'ark' ) ) );

				$s->startRepVariableSection('date-content');

					/* TYPE DAY */
					$s->startRepVariationSection('day', ark_wp_kses( __('Day', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Monday')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'day-color', '', '[1]')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text color', 'ark' ) ) )
						;
					$s->endRepVariationSection();

					/* TYPE MONTH */
					$s->startRepVariationSection('month', ark_wp_kses( __('Month & Year', 'ark' ) ) );
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'August 23, 2016')
							->addParam('print-in-content', true)
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
						;
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'date-color', '', '[1]')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text color', 'ark' ) ) )
						;
					$s->endRepVariationSection();

				$s->endRepVariableSection();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Date Settings', 'ark' ) ) );

				$this->_getBlock( ffThemeBuilderBlock::BOOTSTRAP_COLUMNS )->setParam('default', array('sm'=>2, 'md'=>4))->injectOptions( $s );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);




			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Schedule Content', 'ark' ) ) );

				$s->startRepVariableSection('content');

					/*----------------------------------------------------------*/
					/* TYPE LECTURE
					/*----------------------------------------------------------*/
					$s->startRepVariationSection('lecture', ark_wp_kses( __('Schedule', 'ark' ) ) );

						$s->addOptionNL( ffOneOption::TYPE_ICON, 'icon', ark_wp_kses( __('Icon', 'ark' ) ), 'ff-font-awesome4 icon-circle-o')
							->addParam('print-in-content', true)
						;
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'color', '', '[1]')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Icon color', 'ark' ) ) )
						;
						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$s->startRepVariableSection('content');

							/* TYPE TITLE */
							$s->startRepVariationSection('title', ark_wp_kses( __('Title', 'ark' ) ) );
								$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Politics')
									->addParam('print-in-content', true)
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
								;
								$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'text-color', '', '#e57287')
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text color', 'ark' ) ) )
								;
								$this->_getBlock( ffThemeBuilderBlock::LINK)->injectOptions( $s );

							$s->endRepVariationSection();

							/* TYPE TIME */
							$s->startRepVariationSection('time', ark_wp_kses( __('Time', 'ark' ) ) );
								$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', '12.45 am')
									->addParam('print-in-content', true)
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Text', 'ark' ) ) )
								;
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

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Schedule Settings', 'ark' ) ) );

				$s->startSection('lecture-bootstrap');
					$this->_getBlock( ffThemeBuilderBlock::BOOTSTRAP_COLUMNS )->setParam('default', array('sm'=>5, 'md'=>8))->injectOptions( $s );
				$s->endSection();


				$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'vert-line-color', '', '#e7eaf0')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Vertical Line Color', 'ark' ) ) )
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

		ffElLectures1::_renderColor( $query->getColor('vert-line-color'), 'background-color', null, '.timeline-v1:before' );

		echo '<section class="lectures-v1 row">';
			echo '<div class="'. $this->_getBlock( ffThemeBuilderBlock::BOOTSTRAP_COLUMNS )->render( $query ) .'">';
				if( $query->exists('date-content') ) {
					echo '<div class="timeline-v1-current-date">';

						foreach( $query->get('date-content') as $oneItem ) {
							switch( $oneItem->getVariationType() ) {

								case 'day':
									$this->getAssetsRenderer()->createCssRule()
										->addParamsString('color:'. $oneItem->getColor('day-color').'');
									echo '<h2 class="timeline-v1-current-day">'. $oneItem->getWpKses('text') .'</h2>';
									break;

								case 'month':
									ffElLectures1::_renderColor( $oneItem->getColor('date-color'), 'color', '.timeline-v1-current-time' );

									echo '<small class="timeline-v1-current-time">'.$oneItem->getWpKses('text').'</small>';
									break;

							}
						}

					echo '</div>';
				}
			echo '</div>';

			echo '<div class="'. $this->_getBlock( ffThemeBuilderBlock::BOOTSTRAP_COLUMNS )->render( $query->get('lecture-bootstrap') ) .'">';
				if( $query->exists('content') ) {

					echo '<ul class="timeline-v1">';
						foreach( $query->get('content') as $oneItem ) {
							echo '<li class="timeline-v1-list-item">';

								ffElLectures1::_renderColor( $oneItem->getColor('color'), 'color', '.timeline-v1-badge-icon' );

								echo '<i class="timeline-v1-badge-icon '. $oneItem->getEscAttr('icon') .'"></i>';

								if ( $oneItem->exists('content') ){

									foreach( $oneItem->get('content') as $oneLabel ) {
										switch ($oneLabel->getVariationType()) {

											case 'title':
												if( $this->_getBlock( ffThemeBuilderBlock::LINK )->urlHasBeenFilled( $oneLabel ) ) {
													echo '<a ';
														$this->_getBlock(ffThemeBuilderBlock::LINK)->setParam('classes', 'services-v4-link')->render($oneLabel);
													echo '>';
												}

													$this->getAssetsRenderer()->createCssRule()
														->addParamsString('color: '. $oneLabel->getColor('text-color') .';');

													echo '<small class="timeline-v1-news-label">'. $oneLabel->getWpKses('text') .'</small>';

												if( $this->_getBlock( ffThemeBuilderBlock::LINK )->urlHasBeenFilled( $oneLabel ) ) {
													echo '</a>';
												}

												break;

											case 'time':
												echo '<small class="timeline-v1-news-time">'. $oneLabel->getWpKses('text') .'</small>';
												break;

											case 'description':
												echo '<h5 class="timeline-v1-news-title">';
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
						}

					echo '</ul>';
				echo '</div>';
			}
		echo '</section>';

	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $elementPreview, $element, preview ) {

				if(query.queryExists('date-content')) {
					query.get('date-content').each(function (query, variationType) {
						switch (variationType) {
							case 'day':
								query.addHeadingLg('text');
								break;
							case 'month':
								query.addText('text');
								break;
						}
					});
				}

			}
		</script data-type="ffscript">
	<?php
	}


}