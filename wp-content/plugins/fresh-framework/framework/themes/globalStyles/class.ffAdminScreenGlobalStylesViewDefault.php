<?php
class ffAdminScreenGlobalStylesViewDefault extends ffAdminScreenView {


	public function ajaxRequest( ffAdminScreenAjax $ajax ) {

	}



	public function newAjaxRequest( ffAjaxRequest $ajaxRequest ) {
        switch( $ajaxRequest->getData('action') ) {
            case 'save':
                $this->_saveGlobalStyles( $ajaxRequest );
        }
	}

    /**
     * @param $ajaxRequest ffAjaxRequest
     */
    private function _saveGlobalStyles( $ajaxRequest ) {
        $globalStyles = $ajaxRequest->getDataStripped('globalStyles');
        $globalStylesGroup = $ajaxRequest->getDataStripped('globalStylesGroup');

        $globalStylesDataManager = ffContainer()->getThemeFrameworkFactory()->getThemeBuilderGlobalStyles();

        $globalStylesDataManager->setGlobalStyles( $globalStyles );
        $globalStylesDataManager->setGlobalStylesGroup( $globalStylesGroup );

		$colorLibrary = $ajaxRequest->getData('colorLibrary');

		ffContainer()->getThemeFrameworkFactory()->getThemeBuilderColorLibrary()->setLibrary( $colorLibrary )->saveLibrary();
    }

	private function _getSystemTabsJSON() {
		$structureJSON = ffContainer()->getThemeFrameworkFactory()->getThemeBuilderElementManager()->getElementById('globalStyle')->getElementOptionsJSONString();

		return $structureJSON;
	}


	protected function _render() {


		// vyresit jak vytisknout optiony v modalu
		// jak to potom navazat na dalsi veci
		// jak potom udelat komplit global styly

         $this->_renderSystemSettings();
         $this->_renderGlobalStyles();
//        sdsd

        return;


//		echo '<textarea class="ff-globalstyles-holder">' . $this->_getSystemTabsJSON() . '</textarea>';

//		echo '<div class="ffholder"></div>';

//		return ffContainer()->getThemeFrameworkFactory()->getThemeBuilderElementManager()->getElementById('header')->getElementOptionsStructure(true);
//		systemTabsGetter

		$structure =ffContainer()->getThemeFrameworkFactory()->getThemeBuilderElementManager()->getElementById('globalStyle')->getElementOptionsStructure(true);

//		$structureJSON = ffContainer()->getThemeFrameworkFactory()->getThemeBuilderElementManager()->getElementById('systemTabsGetter')->getElementOptionsJSONString();


//		var_dump( $structureJSON );

//		$structureJSON
//		echo '<br><br><br><br>';

		$jsonConvertor = ffContainer()->getOptionsFactory()->createOptionsPrinterJSONConvertor();
		$jsonConvertor->setOptionsStructure( $structure );

		$optionsArray = ($jsonConvertor->walk());
		$optionsJSON = json_encode( $optionsArray );
		echo '<textarea class="ff-globalstyles-holder">'.$optionsJSON.'</textarea>';

		echo '<div class="ffholder ffb-options ff-options2"></div>';

//		$printer2 = ffContainer()->getOptionsFactory()->createOptionsPrinter2( array(), $structure );
//		echo '<textarea>';
//		$printer2->printOptions();
//		echo '</textarea>';

//		echo 'globalni styly ty kurvo';
	}

    private function _renderSystemSettings() {
        //-------------------------------
        // Get structure of global styles and render it
        //-------------------------------

        $structure =ffContainer()->getThemeFrameworkFactory()->getThemeBuilderElementManager()->getElementById('globalStyle')->getElementOptionsStructure(true);
        $jsonConvertor = ffContainer()->getOptionsFactory()->createOptionsPrinterJSONConvertor();
        $jsonConvertor->setOptionsStructure( $structure );

        $optionsArray = ($jsonConvertor->walk());
        $optionsJSON = json_encode( $optionsArray );

        $globalStyles = ffContainer()->getThemeFrameworkFactory()->getThemeBuilderGlobalStyles();
        $globalStylesData = $globalStyles->getGlobalStyles();
        $globalStylesGroupData = $globalStyles->getGlobalStylesGroup();

        $globalStyles->getGlobalStylesGroupWithJustNames();

        echo '<div class="ff-gs-data-holder">';
            echo '<textarea class="ff-gs-structure">'.$optionsJSON.'</textarea>';
            echo '<textarea class="ff-gs-data">' . json_encode( $globalStylesData ) .'</textarea>';
            echo '<textarea class="ff-gs-group-data">' . json_encode( $globalStylesGroupData ) .'</textarea>';
        echo '</div>';

//        echo '<div class="ffholder ffb-options ff-options2"></div>';
    }

    private function _renderGlobalStyles() {

        // echo '<div class="ff-gs-canvas">';

        //     echo '<div class="ff-gs-group" data-gs-group-id="gs-65143" data-gs-group-name="Paddings and Margins">';
        //         echo '<div class="ff-gs-item" data-gs-id="gs-a68d3354">One Item</div>';
        //         echo '<div class="ff-gs-item" data-gs-id="gs-6942asd">One Item</div>';
        //     echo '</div>';

        // echo '</div>';
        // echo '<div class="ff-gs-save">SAVE</div>';

        echo '<div class="wrap">';
            echo '<div class="ff-gs-canvas-backdrop"></div>';
            echo '<div class="ff-gs-screen ff-collection-options">';
                echo '<div class="ff-collection-content-options-wrapper">';
                    echo '<div class="ff-gs-canvas-wrapper ff-options2 ffb-options clearfix">';

                        echo '<div class="ff-gs-styles-col">';
                            echo '<div class="ff-gs-col-header clearfix">';
                                echo '<h3 class="ff-gs-col-name">Styles</h3>';
                                echo '<div class="ff-gs-col-tools clearfix">';
                                    echo '<div class="ff-gs-action__add_style_cat"><i class="dashicons dashicons-plus"></i></div>';
                                echo '</div>';
                            echo '</div>';
                            echo '<div class="ff-gs-styles-col-inner">';
                                echo '<div class="ff-gs-styles-canvas">';


                                echo '</div>';
                            echo '</div>';
                        echo '</div>';

                        echo '<div class="ff-gs-groups-col">';
                            echo '<div class="ff-gs-col-header clearfix">';
                                echo '<h3 class="ff-gs-col-name">Style Groups</h3>';
                                   echo '<div class="ff-gs-col-tools clearfix">';
                                    echo '<div class="ff-gs-action__add_style_group"><i class="dashicons dashicons-plus"></i></div>';
                                echo '</div>';
                            echo '</div>';
                            echo '<div class="ff-gs-groups-col-inner">';
                                echo '<div class="ff-gs-groups-canvas">';



                                echo '</div>';
                            echo '</div>';
                        echo '</div>';

                    echo '</div>';
                    echo '<div class="ffb-builder-toolbar-fixed-wrapper">';
                        echo '<div class="ffb-builder-toolbar-fixed clearfix" style="position:relative;">';
                            echo '<div class="ffb-builder-toolbar-fixed-left">';
                                echo '<input type="submit" value="Quick Save" class="ff-save-ajax ffb-main-save-ajax-btn ffb-builder-toolbar-fixed-btn">';
                                echo '<a href="https://youtu.be/R8qgz1WLSeg" target="_blank" value="Watch Video Tutorial" class="ffb-gs-video-tut-btn">Watch Video Tutorial</a>';
                            echo '</div>';
                            echo '<div class="ffb-builder-toolbar-fixed-right"></div>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
    }



	protected function _requireAssets() {
		$themeBuilder = ffContainer()->getThemeFrameworkFactory()->getThemeBuilder();
		$themeBuilder->requireBuilderScriptsAndStyles();

//		$pluginUrl = ffPluginFreshMinificatorContainer::getInstance()->getPluginUrl();
//		$this->_getScriptEnqueuer()->addScript('ffAdminScreenMinificatorViewDefault', $pluginUrl .'/adminScreens/minificator/assets/adminScreen.js', array('jquery') );
		$this->_getStyleEnqueuer()->addStyleFramework('ff-global-styles', '/framework/themes/globalStyles/style.css');
        $this->_getStyleEnqueuer()->addStyleFramework('freshframework-font-awesome4-css', '/framework/extern/iconfonts/ff-font-awesome4/ff-font-awesome4.css');

		$this->_getScriptEnqueuer()->addScriptFramework('ff-global-styles', '/framework/themes/globalStyles/script.js');
	}


	protected function _setDependencies() {

	}

}