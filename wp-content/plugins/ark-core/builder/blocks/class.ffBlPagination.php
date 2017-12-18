<?php

class ffBlPagination extends ffThemeBuilderBlockBasic {
	CONST PARAM_WP_QUERY = 'wp_query';
	CONST PARAM_POST_GRID_UNIQUE_ID = 'post-grid-unique-id';
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
		$this->_setInfo( ffThemeBuilderBlock::INFO_ID, 'pagination');
		$this->_setInfo( ffThemeBuilderBlock::INFO_WRAPPING_ID, 'pagination');
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
	public function setWpQuery( $wpQuery ) {
		$this->setParam( ffBlPagination::PARAM_WP_QUERY, $wpQuery );

		return $this;
	}
/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS 
/**********************************************************************************************************************/

	protected function _injectOptions( ffThemeBuilderOptionsExtender $s ) {

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Pagination Settings', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_CHECKBOX,'show', ark_wp_kses( __('Show pagination', 'ark' ) ), 1);

				$s->addOptionNL(ffOneOption::TYPE_TEXT, 'range', '', '3')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Range', 'ark' ) ) )
				;
				$s->addElement(ffOneElement::TYPE_DESCRIPTION,'', ark_wp_kses( __('Set how many page numbers will be displayed before and after the current page before it only shows the three dots', 'ark' ) ) );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Design', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'design', '', '1')
					->addSelectValue( esc_attr( __('1: Bubbled page numbers & distanced Previous - Next', 'ark' ) ), '1')
					->addSelectValue( esc_attr( __('2: Underline page numbers & distanced Previous - Next', 'ark' ) ), '2')
					->addSelectValue( esc_attr( __('3: Squared page numbers & closely Previous - Next', 'ark' ) ), '3')
				;
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Prev & Next Buttons', 'ark' ) ) );

				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'use-icons', '', '0')
					->addSelectValue( esc_attr( __('Text Labels', 'ark' ) ), '0')
					->addSelectValue( esc_attr( __('Icons', 'ark' ) ), '1')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Style', 'ark' ) ) )
				;

				$s->startHidingBox('use-icons', array( '0' ) );

					$s->addOptionNL(ffOneOption::TYPE_TEXT, 'prev-text', '', '&amp;larr;')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Previous label', 'ark' ) ) )
					;
					$s->addOptionNL(ffOneOption::TYPE_TEXT, 'next-text', '', '&amp;rarr;')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Next label', 'ark' ) ) )
					;

				$s->endHidingBox();

				$s->startHidingBox('use-icons', array( '1' ) );

					$s->addOptionNL(ffOneOption::TYPE_ICON, 'prev-icon', ark_wp_kses( __('Previous icon', 'ark' ) ), 'ff-font-awesome4 icon-angle-double-left');
					$s->addOptionNL(ffOneOption::TYPE_ICON, 'next-icon', ark_wp_kses( __('Next icon', 'ark' ) ), 'ff-font-awesome4 icon-angle-double-right');

				$s->endHidingBox();


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);


			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Colors', 'ark' ) ) );

				$s->startHidingBox('design', array( '1' ) );
					$s->startSection('colors-1');
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'arrows', ' ')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Arrows', 'ark' ) ) )
						;

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'arrows-hover', ' ')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Arrows Hover', 'ark' ) ) )
						;
						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'numbers', ' ')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Numbers', 'ark' ) ) )
						;

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'numbers-hover', ' ')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Numbers Hover', 'ark' ) ) )
						;
						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'numbers-hover-background', ' ')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Numbers Background Hover', 'ark' ) ) )
						;
						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'numbers-active', ' ')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Numbers Active', 'ark' ) ) )
						;
						$s->addElement(ffOneElement::TYPE_NEW_LINE);

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'numbers-active-background', ' ')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Numbers Background Active', 'ark' ) ) )
						;

					$s->endSection();
				$s->endHidingBox();

				$s->startHidingBox('design', array( '2' ) );
					$s->startSection('colors-2');
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'arrows', ' ')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Arrows', 'ark' ) ) )
						;

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'arrows-hover', ' ')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Arrows Hover', 'ark' ) ) )
						;

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'numbers', ' ')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Numbers', 'ark' ) ) )
						;

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'numbers-hover', ' ')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Numbers Hover', 'ark' ) ) )
						;

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'numbers-active', ' ')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Numbers Active', 'ark' ) ) )
						;

					$s->endSection();
				$s->endHidingBox();

				$s->startHidingBox('design', array( '3' ) );
					$s->startSection('colors-3');
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'arrows-numbers', ' ')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Arrows and Numbers', 'ark' ) ) )
						;

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'arrows-numbers-hover', ' ')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Arrows and Numbers Hover', 'ark' ) ) )
						;

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'active', ' ')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Active', 'ark' ) ) )
						;

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'active-background', ' ')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Active Background', 'ark' ) ) )
						;

					$s->endSection();
				$s->endHidingBox();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

		$s->addElement( ffOneElement::TYPE_TABLE_END );
	}

	public function showPagination( $query )  {
		if( !$query->getWithoutComparationDefault('show', 1) ) {
			return false;
		}

		$wpQuery = $this->_getWpQuery();

		$postsPerPage = $wpQuery->get('posts_per_page');
		$postsFound = $wpQuery->found_posts;

		if( $postsFound <= $postsPerPage ) {
			return false;
		}

		return true;

	}

	protected function _render( $query ) {

		$postGridUniqueId = $this->getParam( ffBlPagination::PARAM_POST_GRID_UNIQUE_ID );

		$paginationClass = 'ffb-pagination-' . $postGridUniqueId;


		$wpQuery = $this->_getWpQuery();


		if( !$query->getWithoutComparationDefault('show', 1) ) {
			return false;
		}


		$currentPage = $wpQuery->get('paged', 1);
		$postsPerPage = $wpQuery->get('posts_per_page');
		$postsFound = $wpQuery->found_posts;

		$paginationComputer = ffContainer()->getThemeFrameworkFactory()->getPaginationComputer();
		$paginationComputer->setInfoFromWpQuery( $currentPage, $postsPerPage, $postsFound );
		$paginationComputer->setRange( $query->getWithoutComparationDefault('range', 3) );

		$pagination = $paginationComputer->getComputedPagination();

		if( !empty( $pagination ) && $query->getWithoutComparationDefault('show', true) ) {
			$beforePagination = '';
			$afterPagination = '';
			$paginationContent = '';

			$this->_renderColors( $query, $paginationClass );

			echo '<section class="'.$paginationClass.' ff-pagination paginations-v'. $query->getWithoutComparationDefault('design', '1') .' text-center">';
				echo '<ul class="paginations-v'. $query->getWithoutComparationDefault('design', '1') .'-list">';

					foreach( $pagination as $oneItem ) {
						switch( $oneItem->type ) {

							/* PREVIOUS */
							case ffPaginationComputer::TYPE_PREV:
								$beforePagination .= '<li class="previous"><a aria-label="Previous" href="'.get_pagenum_link( $oneItem->page).'"><span aria-hidden="true">';

								/* TEXT or ICON */
								if( $query->getWithoutComparationDefault('use-icons') ){
									$beforePagination .= '<i class="'. $query->getWithoutComparationDefault('prev-icon', 'ff-font-awesome4 icon-angle-double-left') .'"></i>';
								} else {
									$beforePagination .= $query->getWithoutComparationDefault('prev-text', '&larr;');
								}

								 $beforePagination .= '</span></a></li>';
								break;

							case ffPaginationComputer::TYPE_DOTS_START:
								break;

							case ffPaginationComputer::TYPE_LAST_NUMBER_BUTTON:
							case ffPaginationComputer::TYPE_FIRST_NUMBER_BUTTON:
							case ffPaginationComputer::TYPE_STD_BUTTON;
								$class = '';
								$href = 'href="'.get_pagenum_link( $oneItem->page).'"';
								$class = 'normal';
								if( $oneItem->selected == true ) {
									$class = 'active';
								}
								$paginationContent .= '<li class="'.$class.'">';
								$paginationContent .= '<a '.$href.'>';
								$paginationContent .= $oneItem->page;
								$paginationContent .= '</a>';
								$paginationContent .= '</li>';
								$paginationContent .= '';

								break;

							case ffPaginationComputer::TYPE_DOTS_END:
								$paginationContent .= '<li><a class="no-active">...</a></li>';
								break;

							/* NEXT */
							case ffPaginationComputer::TYPE_NEXT:
								$afterPagination .= '<li class="next"><a aria-label="Next" href="'.get_pagenum_link( $oneItem->page).'"><span aria-hidden="true">';

								/* TEXT or ICON */
								if( $query->getWithoutComparationDefault('use-icons') ){
									$afterPagination .= '<i class="'. $query->getWithoutComparationDefault('next-icon', 'ff-font-awesome4 icon-angle-double-right') .'"></i>';
								} else {
									$afterPagination .= $query->getWithoutComparationDefault('next-text', '&rarr;');
								}

								$afterPagination .= '</span></a></li>';
								break;
						}
					}
					echo ($beforePagination);
					echo ($paginationContent);
					echo ($afterPagination);

				echo '</ul>';
			echo '</section>';
		}


	}

	/**
	 * @param $query ffOptionsQueryDynamic
	 */
	protected function _renderColors( $query, $paginationClass ) {
		$design = $query->getWithoutComparationDefault('design', 1);
		$assetsRenderer = $this->_getAssetsRenderer();

		switch( $design ) {
			case 1:
				$query = $query->getMustBeQueryNotEmpty('colors-1');

				$arrows = $query->getWithoutComparationDefault('arrows');
				$arrowsHover = $query->getWithoutComparationDefault('arrows-hover');
				$numbers = $query->getWithoutComparationDefault('numbers');
				$numbersHover = $query->getWithoutComparationDefault('numbers-hover');
				$numbersHoverBackground = $query->getWithoutComparationDefault('numbers-hover-background');

				$numbersActive = $query->getWithoutComparationDefault('numbers-active');
				$numbersActiveBackground = $query->getWithoutComparationDefault('numbers-active-background');

				if( !empty( $arrows ) ) {
					$assetsRenderer->createCssRule()
						->useScope(false)
						->addSelector($paginationClass)
						->addSelector('li.previous a span', false)
						->createNewSelectorBranch( $paginationClass)
						->addSelector('li.next a span', false)
						->addParamsString('color: ' . $arrows . ' !important;');
				}

				if( !empty( $arrowsHover ) ) {
					$assetsRenderer->createCssRule()
						->useScope(false)
						->addSelector($paginationClass)
						->addSelector('li.previous:hover a span', false)
						->createNewSelectorBranch( $paginationClass)
						->addSelector('li.next:hover a span', false)
						->addParamsString('color: ' . $arrowsHover . ' !important;');
				}

				if( !empty( $numbers ) ) {
					$assetsRenderer->createCssRule()
						->useScope(false)
						->addSelector($paginationClass)
						->addSelector('li a.normal', false)
						->addParamsString('color: ' . $numbers . ' !important;');
				}

				if( !empty( $numbersHover ) ) {
					$assetsRenderer->createCssRule()
						->useScope(false)
						->addSelector($paginationClass)
						->addSelector('li.normal:hover a', false)
						->addParamsString('color: ' . $numbersHover . ' !important;');
				}

				if( !empty( $numbersHoverBackground ) ) {
					$assetsRenderer->createCssRule()
						->useScope(false)
						->addSelector($paginationClass)
						->addSelector('li.normal:hover a', false)
						->addParamsString('background: ' . $numbersHoverBackground . ' !important;');
				}

				if( !empty( $numbersActive ) ) {
					$assetsRenderer->createCssRule()
						->useScope(false)
						->addSelector($paginationClass)
						->addSelector('li.active a', false)
						->addParamsString('color: ' . $numbersActive . ' !important;');
				}

				if( !empty( $numbersActiveBackground ) ) {
					$assetsRenderer->createCssRule()
						->useScope(false)
						->addSelector($paginationClass)
						->addSelector('li.active a', false)
						->addParamsString('background: ' . $numbersActiveBackground . ' !important;');
				}

				break;

			case 2:

				$query = $query->getMustBeQueryNotEmpty('colors-2');

				$arrows = $query->getWithoutComparationDefault('arrows');
				$arrowsHover = $query->getWithoutComparationDefault('arrows-hover');
				$numbers = $query->getWithoutComparationDefault('numbers');
				$numbersHover = $query->getWithoutComparationDefault('numbers-hover');

				$numbersActive = $query->getWithoutComparationDefault('numbers-active');

				if( !empty( $arrows ) ) {

					$assetsRenderer->createCssRule()
						->useScope(false)
						->addSelector($paginationClass)
						->addSelector('li.previous a span', false)
						->createNewSelectorBranch( $paginationClass)
						->addSelector('li.next a span', false)
						->addParamsString('color: ' . $arrows . ' !important; ');
				}

				if( !empty( $arrowsHover ) ) {
					$assetsRenderer->createCssRule()
						->useScope(false)
						->addSelector($paginationClass)
						->addSelector('li.previous:hover a span', false)
						->createNewSelectorBranch( $paginationClass)
						->addSelector('li.next:hover a span', false)
						->addParamsString('color: ' . $arrowsHover . ' !important;');

					$assetsRenderer->createCssRule()
						->useScope(false)
						->addSelector($paginationClass)
						->addSelector('li.previous:hover a', false)
						->createNewSelectorBranch( $paginationClass)
						->addSelector('li.next:hover a', false)
						->addParamsString('border-bottom-color: ' . $arrowsHover . ' !important;');
				}

				if( !empty( $numbers ) ) {
					$assetsRenderer->createCssRule()
						->useScope(false)
						->addSelector($paginationClass)
						->addSelector('li.normal a', false)
						->addParamsString('color: ' . $numbers . ' !important;');
				}

				if( !empty( $numbersHover ) ) {
					$assetsRenderer->createCssRule()
						->useScope(false)
						->addSelector($paginationClass)
						->addSelector('li.normal:hover a', false)
						->addParamsString('color: ' . $numbersHover . ' !important; border-bottom-color:' . $numbersHover . '!important;');
				}

				if( !empty( $numbersActive ) ) {
					$assetsRenderer->createCssRule()
						->useScope(false)
						->addSelector($paginationClass)
						->addSelector('li.active a', false)
						->addParamsString('color: ' . $numbersActive . ' !important; border-bottom-color: ' . $numbersActive .' !important;');
				}

				break;

			case 3:

				$query = $query->getMustBeQueryNotEmpty('colors-3');

				$arrowsNumbers = $query->getWithoutComparationDefault('arrows-numbers');
				$arrowsNumbersHover = $query->getWithoutComparationDefault('arrows-numbers-hover');
				$active = $query->getWithoutComparationDefault('active');
				$activeBackground = $query->getWithoutComparationDefault('active-background');

				if( !empty( $arrowsNumbers ) ) {
					$assetsRenderer->createCssRule()
						->useScope(false)
						->addSelector($paginationClass)
						->addSelector('li.normal a', false)
						->createNewSelectorBranch( $paginationClass)
						->addSelector('li.previous a', false)
						->createNewSelectorBranch( $paginationClass)
						->addSelector('li.next a', false)
						->addParamsString('color: ' . $arrowsNumbers . ' !important;');
				}


				if( !empty( $arrowsNumbersHover ) ) {
					$assetsRenderer->createCssRule()
						->useScope(false)
						->addSelector($paginationClass)
						->addSelector('li.normal:hover a', false)
						->createNewSelectorBranch( $paginationClass)
						->addSelector('li.previous:hover a', false)
						->createNewSelectorBranch( $paginationClass)
						->addSelector('li.next:hover a', false)
						->addParamsString('color: ' . $arrowsNumbersHover . ' !important;');
				}

				if( !empty( $active ) ) {
					$assetsRenderer->createCssRule()
						->useScope(false)
						->addSelector($paginationClass)
						->addSelector('li.active a', false)
						->addParamsString('color: ' . $active . ' !important;');
				}

				if( !empty( $activeBackground ) ) {
					$assetsRenderer->createCssRule()
						->useScope(false)
						->addSelector($paginationClass)
						->addSelector('li.active a', false)
						->addParamsString('background: ' . $activeBackground . ' !important;');
				}

				break;
		}
	}



	protected function _renderContentInfo_JS() {
		?>
		<script data-type="ffscript">
			function ( query, params ) {
				var toReturn = '';
				if( query == null ) {
					toReturn = 'Button not filled';
				} else {
					var newImage = query.getWithoutComparationDefault('img', null);

					if( newImage != null ) {
						query.addImage('img');
					} else {
						toReturn = 'Button not filled';
					}
				}

				return toReturn;

			}
		</script data-type="ffscript">
		<?php
	}

/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS 
/**********************************************************************************************************************/

	/**
	 * @return WP_Query
	 */
	private function _getWpQuery() {
		return $this->getParam( ffBlPagination::PARAM_WP_QUERY );
	}

}