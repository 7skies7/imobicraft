<?php

abstract class ffThemeBuilderBlockGlobalStyle extends ffThemeBuilderBlock {
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

	protected function _mergeTwoStylesData($globalStyles, $instance) {
		return array_replace_recursive( $globalStyles, $instance );
	}


    /**
     * @param ffOptionsQueryDynamic $query
     * @param bool|true $queryExists
     * @return ffOptionsQueryDynamic
     *
     * Do all the hustle with global styles
     */
    protected function _figureOutNewGlobalOptions( $query, $queryExists = true ) {
        $globalStyles = $this->_getMergedGlobalStylesForCurrentBlock( $query, $queryExists );

        $globalStyles = new ffDataHolder( $globalStyles );

        $currentWrappingId = $this->_getInfo( ffThemeBuilderBlock::INFO_WRAPPING_ID );

        $route = $query->getPath();

        if( !$queryExists ) {
            $query->setDataValue( $route . ' '.$currentWrappingId, $globalStyles->get('o ' . $currentWrappingId));

        } else {
            $instanceStyle = $query->getOnlyDataPartAsDataHolder()->getData();
            $oldInstance = $globalStyles->get('o ' . $currentWrappingId);

            if( !is_array($oldInstance) ) {
                $oldInstance = [];
            }

            $newInstanceStyle = $this->_mergeTwoStylesData( $oldInstance, $instanceStyle );

            $query->setDataValue($route, $newInstanceStyle );
        }

        return $query;
    }

    /**
     * @param $query ffOptionsQueryDynamic
     *
     * Just acquire the global styles and merge them together, like a boss
     */
    private function _getMergedGlobalStylesForCurrentBlock( $query, $queryExists = true ) {
        $path = $query->getPath();

        if( $queryExists ) {
            $pathSplitted = explode(' ', $path );
            array_pop( $pathSplitted );
            $pathWithoutLastItem = implode(' ', $pathSplitted );

            $query->setMetaSetting( ffOptionsQuery::META_IGNORE_PATH, true );
            $styles = $query->getMultipleSelectWithNames($pathWithoutLastItem. ' st styles');
            $query->setMetaSetting( ffOptionsQuery::META_IGNORE_PATH, false );
        } else {
            $styles = $query->getMultipleSelectWithNames('st styles');
        }


        if( empty( $styles ) ) {
            return null;
        }

        $globalStylesManager = ffContainer()->getThemeFrameworkFactory()->getThemeBuilderGlobalStyles();

        $toReturn = [];

		$olderGlobalStylesDataholder=  $this->_getOriginalGlobalStylesDataToInject( $query );

		if( $olderGlobalStylesDataholder != null ) {
			$olderGlobalStyles = $olderGlobalStylesDataholder->getData();

			if( !empty($olderGlobalStyles) ) {
				$toReturn = $olderGlobalStyles;
			}

		}


        $statusHolder = $this->_getStatusHolder();
        foreach( $styles as $oneStyleId ) {

            if( !empty( $oneStyleId ) ) {
                $usedGlobalStyles = $statusHolder->getElementSpecificStack( ffThemeBuilderShortcodesStatusHolder::USED_GLOBAL_STYLES );
                $usedGlobalStyles[ $oneStyleId ] = true;
                $statusHolder->setElementSpecificStack(ffThemeBuilderShortcodesStatusHolder::USED_GLOBAL_STYLES, $usedGlobalStyles);
            }

            $data = $globalStylesManager->getGlobalStyleGroupValueById( $oneStyleId );



            if( $data != null ) {
                $toReturn = array_replace_recursive( $toReturn, $data );
            }
        }


        return $toReturn;
    }

    /**
     * @param $styleName
     * @return null
     *
     * acquire one style by Id
     */
    private function _getStyleById( $oneStyleId ) {
        $style = '';
        switch( $oneStyleId ) {
            case 'padding-style':
                $o = [];
                $o['o'] = [];

                $d = [];
                $d['b-m'] = [];
                $d['b-m']['pd-xs'] = [];
//                $d['b-m']['pd-xs']['t'] = 50;
//                $d['b-m']['pd-xs']['b'] = 50;
                $d['b-m']['pd-xs']['r'] = 50;
                $d['b-m']['pd-xs']['l'] = 50;

                $o['o']['b-m'] = $d['b-m'];

                break;

            case 'margin-style':
                $o = [];
                $o['o'] = [];

                $d = [];
                $d['b-m'] = [];
                $d['b-m']['mg-xs'] = [];
                $d['b-m']['mg-xs']['t'] = 158;
                $d['b-m']['mg-xs']['b'] = 158;
                $d['b-m']['mg-xs']['r'] = 158;
                $d['b-m']['mg-xs']['l'] = 158;

                $d['b-m']['pd-xs'] = [];
                $d['b-m']['pd-xs']['t'] = 10;
                $d['b-m']['pd-xs']['b'] = 20;
                $d['b-m']['pd-xs']['r'] = 30;
                $d['b-m']['pd-xs']['l'] = 40;

                $o['o']['b-m'] = $d['b-m'];

                break;

        }

        $currentWrappingId = $this->_getInfo( ffThemeBuilderBlock::INFO_WRAPPING_ID );

        if( isset( $o['o'] ) && isset( $o['o'][ $currentWrappingId ] )  ) {
            return $o['o'][ $currentWrappingId ];
        } else {
            return null;
        }
    }
/**********************************************************************************************************************/
/* ABSTRACT FUNCTIONS
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/
}