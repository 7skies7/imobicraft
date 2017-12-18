<?php

class ffOptionsQueryDynamic extends ffOptionsQuery {



    private $_getOptionsCallback = null;

    public function setGetOptionsCallback( $callback ) {
        $this->_getOptionsCallback = $callback;
    }

    public function setData( $data ) {
        $this->_setData( $data );
        $this->_setOptionsstructureHasBeenCompared( false );

        return $this;
    }

	


    protected function _compareDataWithStructure() {
		if ($this->_getOptionsstructureHasBeenCompared() == false && $this->_getOptionsCallback != null ) {
			$this->_setOptionsstructureHasBeenCompared(true);

            $options = call_user_func( $this->_getOptionsCallback );

            $this->_getArrayConvertor()->setOptionsArrayData( $this->_data );
			$this->_getArrayConvertor()->setOptionsStructure( $options );
			$this->_data = $this->_getArrayConvertor()->walk();
			$this->_setOptionsstructureHasBeenCompared(true);
		} else if( $this->_getOptionsstructureHasBeenCompared() == false && $this->_getOptionsCallback == null ) {
			$this->_setOptionsstructureHasBeenCompared(true);
		}
	}


	public function getColorWithoutComparationDefault( $query, $default = null ) {
		if( $this->exists( $query ) ) {
			return $this->getColor( $query );
		} else {

			if( $this->_isColorFromLibrary( $default) ) {
				return $this->_getColorFromLibrary( $default );
			} else {
				return $default;
			}

		}
	}

	public function getHash( $query = null ) {
		$data = $this->getOnlyDataPartWithCurrentPath( $query );
		if( is_array( $data ) ) {
			$data = json_encode( $data );
		}

		return md5( $data );
	}

    public function getNew( $query = null ) {
        if( $this->_getPath() !== null && $query == null ) {
			$newQuery = $this->_getPath();

            if( $query != null ) {
                $newQuery .= ' ' . $query;
            }

            $query = $newQuery;
		}

		$query =  new ffOptionsQueryDynamic( $this->_data, $this->_getOptionsHolder(), $this->_getArrayConvertor(), $query, $this->_optionsStructureHasBeenCompared );
        $query->setGetOptionsCallback( $this->_getOptionsCallback );
		$query->setIteratorValidationCallback( $this->_getIteratorValidationCallback() );
		$query->setIteratorStartCallback( $this->_iteratorStartCallback );
		$query->setIteratorEndCallback( $this->_iteratorEndCallback );
	    $query->setIteratorBeginningCallback( $this->_iteratorBeginningCallback );
	    $query->setIteratorEndingCallback( $this->_iteratorEndingCallback );
	    $query->setCallTheCallbacks( $this->_callTheCallbacks );
	    $query->setIsPrintingMode( $this->_isPrintingMode );
	    $query->setElementClassName( $this->_currentElementClassName );
        $query->setMetaSettings( $this->_getMetaSettings() );

		$query->setWPLayer( $this->_getWPLayer() );
		return $query;
	}

	protected function _isColorFromLibrary( $color ) {
		return strpos($color, '[') !== false;
	}

	protected function _getColorFromLibrary( $color ) {
		$positionInLibrary = str_replace( array('[', ']'), array('', ''), $color );
		$colorFromLibrary = ffContainer()->getThemeFrameworkFactory()->getThemeBuilderColorLibrary()->getColor( $positionInLibrary );

		if( $colorFromLibrary == 'null' ) {
			$colorFromLibrary = '';
		}

		return $colorFromLibrary;
	}

	public function getColor( $query ) {
		$color = $this->get( $query );

		if( $this->_isColorFromLibrary( $color ) ) {
			$color = $this->_getColorFromLibrary( $color );
		}

		if( $color == 'null' ) {
			$color = '';
		}

		return $color;
	}

	public function getPost( $query ) {
		$post = $this->get($query);

		$toReturn = new stdClass();
		$toReturn->id = null;
		$toReturn->title = null;

		if( empty( $post ) ) {
			return $toReturn;
		}

		$postSplitted = explode('--||--', $post );

		$toReturn->id = $postSplitted[0];
		$toReturn->title = $postSplitted[1];

		return $toReturn;
	}
}