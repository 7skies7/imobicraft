<?php

abstract class ffThemeBuilderBlockBasic extends ffThemeBuilderBlockGlobalStyle {
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/
	/**
	 * @param $query ffOptionsQueryDynamic
	 * @param null $route
	 */
	protected function _advancedToggleBoxStart( $query, $route = null ) {

		if( $route != null ) {
			if( $query->exists( $route ) ) {
				$query = $query->get( $route );
			}
 		}

		// SET TEXT COLOR INHERITANCE
		$textColor = $this->_getBlock( ffThemeBuilderBlock::COLORS)->returnOnlyTextColor()->get( $query );

		if( !empty($textColor) ) {
			$this->_getStatusHolder()->addTextColorToStack( $textColor );
		}
		ob_start();
	}

	protected function _advancedToggleBoxEnd( $query, $route = null, $print = true) {

		if( $route != null ) {
			if( $query->exists( $route ) ) {
				$query = $query->get( $route );
			}
		}

		$content = ob_get_contents();
		ob_end_clean();

		$result =  $this->_applySystemThingsOnToggleBox( $content, $query, $route );
		if( $print ) {
			echo $result;
		}

		// SET TEXT COLOR INHERITANCE
		$textColor = $this->_getBlock( ffThemeBuilderBlock::COLORS)->returnOnlyTextColor()->get( $query );
		if( !empty($textColor) ) {
			$this->_getStatusHolder()->removeTextColorFromStack( $textColor );
		}

		if( !$print ) {
			return $result;
		}
	}

	/**
	 * @param $content string
	 * @param $query ffOptionsQueryDynamic
	 */
	protected function _applySystemThingsOnToggleBox( $content, $query, $route = null ) {

		if( $route == null ) {
			$route = $query->getPath();
			$routeExploded = explode(' ', $route);
			$lastRoute = end( $routeExploded);
		} else {
			$lastRoute = $route;
		}


		$className = 'ffb-'.$lastRoute;



		$this->_getAssetsRenderer()->addSelectorToCascade( $className );

		$repeatableVariationCssSelector = $className;
		$helper = $this->_getAssetsRenderer()->getElementHelper();
		$helper->parse( $content );

		$this->_getBlock( ffThemeBuilderBlock::BOX_MODEL)->get( $query );
		$this->_getBlock(ffThemeBuilderBlock::ADVANCED_TOOLS)->get( $query );
		$this->_getBlock( ffThemeBuilderBlock::CUSTOM_CODES)->render( $query );
		$this->_getBlock( ffThemeBuilderBlock::COLORS)->get( $query );

		$helper->addAttribute('class', $repeatableVariationCssSelector );


		$content = $helper->get();

		$this->_getAssetsRenderer()->removeSelectorFromCascade();

		return $content;
	}


//	protected function _getGlobalStylesForThisBlock() {
//		$systemOptions = $this->_getStatusHolder()->getSystemOptionsFromStack();
//
//	}

/**********************************************************************************************************************/
/* ABSTRACT FUNCTIONS
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/
}