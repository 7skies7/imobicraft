<?php
/**
 * Class ffThemeBuilderElementFactory
 */
class ffThemeBuilderElementFactory extends ffFactoryAbstract {

	private $_elementClassesLoaded = false;

	private $_statusHolder = null;

	public function setStatusHolder( $statusHolder ) {
		$this->_statusHolder = $statusHolder;
	}

    public function loadElement( $elementClassName ){
//	    ffStopWatch::timeStart();
	    if( !$this->_elementClassesLoaded ) {
		    $this->_getClassloader()->loadClass('ffThemeBuilderElement');
		    $this->_getClassloader()->loadClass('ffThemeBuilderElementBasic');
		    $this->_getClassloader()->loadClass('ffThemeBuilderOptionsExtender');
		    $this->_elementClassesLoaded = true;
	    }

//	    ffStopWatch::timeEndDump();
	    $this->_getClassloader()->loadClass( $elementClassName );
    }

    /**
     * @param $elementClassName
     * @return ffThemeBuilderElement
     * @throws Exception
     */

    public function createElement( $elementClassName ) {
        $this->loadElement( $elementClassName );
        $optionsExtender = new ffThemeBuilderOptionsExtender();

		$fwc = ffContainer();
        return new $elementClassName(
            $optionsExtender,
	        $fwc->getOptionsFactory()->createQueryDynamic(),
	        $fwc->getWPLayer(),
	        $fwc->getThemeFrameworkFactory()->getThemeBuilderBlockManager(),
	        $fwc->getThemeFrameworkFactory()->getThemeBuilderAssetsRenderer(),
	        $this->_statusHolder,
	        $fwc->getThemeFrameworkFactory()->getThemeBuilderGlobalStyles()
        );
    }

}