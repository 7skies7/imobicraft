<?php

class ffFramework extends ffBasicObject {
/******************************************************************************/
/* VARIABLES AND CONSTANTS
/******************************************************************************/
	/**
	 * 
	 * @var ffContainer
	 */
	
	private $_container = null;
	
	
	/**
	 * 
	 * @var ffPluginLoader
	 */
	private $_pluginLoader = null;

    /**
     * @var bool
     */
    private $_isOurTheme = false;
	
	/**
	 * 
	 * @var ffThemeLoader
	 */
	private $_themeLoader = null;
	
/******************************************************************************/
/* CONSTRUCT AND PUBLIC FUNCTIONS
/******************************************************************************/
	public function __construct( ffContainer $container, ffPluginLoader $pluginLoader, ffThemeLoader $themeLoader ) {
		$this->_setContainer( $container );
		$this->_setPluginloader( $pluginLoader );
		$this->_setThemeLoader($themeLoader);
	}

	
	public function run() {
		$this->_getPluginloader()->createPluginClasses();
		$this->_getPluginloader()->getActivePluginClasses();

		$this->_getContainer()->getWPUpgrader();
		$this->_frameworkRun();

		if( $this->_getContainer()->getWPLayer()->is_admin() ) {
			$this->_isAdmin();		
		}
		
		if( $this->_getContainer()->getWPLayer()->is_ajax() ) {
			$this->_isAjaxRequest();
		}
	}

    public function isOurTheme() {
        return $this->_isOurTheme;
    }

	public function loadOurTheme() {
        $this->_isOurTheme;
        $this->_getContainer()->getWPLayer()->setIsOurTheme( true );
		return $this->_getThemeLoader()->loadOurTheme();
	}
/******************************************************************************/
/* PRIVATE FUNCTIONS
/******************************************************************************/


	private function _frameworkRun() {

        $this->_hookActions();

        if( $this->_getContainer()->getWPLayer()->is_admin() ) {
            $this->_getContainer()->getLessScssCompiler();
            $this->_getContainer()->getDataStorageFactory()->createDataStoragePostTypeRegistrator()->registerOptionsPostType();
            $this->_getContainer()->getAssetsIncludingFactory()->getLessManager()->addOneLessFile( ffOneLessFile::TYPE_BOOTSTRAP, FF_FRAMEWORK_URL.'/framework/extern/bootstrap/less/variables.less', 10,'Bootstrap');
        }

        $this->_getContainer()->getHttpAction()->checkForOurActionFired();
		$this->_requireAssets();
	}

	private function _requireAssets(){
		$style = $this->_getContainer()->getStyleEnqueuer();
		$script = $this->_getContainer()->getScriptEnqueuer();

		$style->addStyleFramework('ff-logo', '/framework/extern/ff-logo/ff-logo.css');
	}
	
	private function _isAdmin() {
        $fwc = $this->_getContainer();
        $fwc->getCompatibilityTester();
        $this->_requireClassesInWidgetsAdmin();
        $fwc->getDataStorageFactory()->createDataStoragePostTypeRegistrator()->registerOptionsPostType();
        $fwc->getThemeFrameworkFactory()->getLayoutsNamespaceFactory()->getLayoutsEmojiManager()->unregisterEmojiAtLayoutAdminScreen();

        $fwc->getWPLayer()->add_action('admin_head', array( $this, 'actAdminHeadPrintJsConstants'),0);
	}

    public function actAdminHeadPrintJsConstants() {
        $fwc = ffContainer();
        $wpLayer = $fwc->getWPLayer();
        $templateUrl = $wpLayer->get_stylesheet_directory_uri();
        $frameworkUrl = $wpLayer->getFrameworkUrl();

        echo '<script type=\'text/javascript\'>' . PHP_EOL;
            echo 'ff_fw_framework_url="'.$frameworkUrl.'";' . PHP_EOL;
            echo 'ff_fw_template_url="'.$templateUrl.'";' . PHP_EOL;

	        if( defined('FF_DEVELOPER_MODE') && FF_DEVELOPER_MODE == true ) {
		        $developerMode = 'true';
	        } else {
		        $developerMode = 'false';
	        }

		    if( defined('FF_VIDEO_RECORDING') && FF_VIDEO_RECORDING == true ) {
			    $videoRecording = 'true';
		    } else {
			    $videoRecording = 'false';
		    }

	    echo 'ff_fw_developer_mode=' . $developerMode .'; ' . PHP_EOL;

	    echo 'ff_fw_video_recording=' . $videoRecording .'; ' . PHP_EOL;

	    $isArk = $fwc->getWPLayer()->isArkTheme();

	    if( $isArk ) {
		    $isArk = 'true';
	    } else {
		    $isArk = 'false';
	    }

	    echo 'ff_fw_is_ark=' . $isArk .';' . PHP_EOL;

	    if( defined( 'FF_ARK_CORE_PLUGIN_URL' ) ) {
		    echo 'ff_ark_core_plugin_url="' . FF_ARK_CORE_PLUGIN_URL .'";';
	    }

        echo '</script>' . PHP_EOL;

    }

    private function _requireClassesInWidgetsAdmin() {
        $request = $this->_getContainer()->getRequest();

        if( strpos( $request->server('SCRIPT_FILENAME'), 'widgets.php' ) !== false ) {
            $this->_getContainer()->getWPLayer()->add_action('admin_enqueue_scripts', array($this,'actWidgetsEnqueueMedia'));
            $this->_getContainer()->getFrameworkScriptLoader()->requireFfAdmin()->requireFrsLibModal();


            $this->_getContainer()->getWPLayer()->add_action('admin_footer', array( $this, 'actWidgetAdminFooter') );
        }
    }

    public function actWidgetAdminFooter() {
        $this->_getContainer()->getModalWindowFactory()->printModalWindowManagerLibraryIcon();
    }

    public function actWidgetsEnqueueMedia() {
        $this->_getContainer()->getWPLayer()->wp_enqueue_media();
    }

	private function _isAjaxRequest() {
		$container = $this->_getContainer();
		$container->getAjaxDispatcher()->hookActions();
		$container->getModalWindowAjaxManager()->hookAjax();
		$container->getOptionsFactory()->createOptionsPrinterDataboxGenerator()->hookAjax();
		$container->getMetaBoxes()->getMetaBoxManager()->hookAjax();
		$container->getThemeFrameworkFactory()->getThemeBuilderColorLibrary()->hookAjax();
		$container->getThemeFrameworkFactory()->getThemeBuilder()->hookAjax();

		$container->getOptionsFactory()->createOptionsPrinter2()->hookAjax();
	}

    private function _hookActions() {
        $this->_getContainer()->getGraphicFactory()->getImageHttpManager()->hookActions();
    }
/******************************************************************************/
/* SETTERS AND GETTERS
/******************************************************************************/	
	
	/**
	 * @return ffContainer
	 */
	protected function _getContainer() {
		return $this->_container;
	}
	
	/**
	 * @param ffContainer $_container
	 */
	protected function _setContainer(ffContainer $container) {
		$this->_container = $container;
		return $this;
	}

	/**
	 * @return ffPluginLoader
	 */
	protected function _getPluginloader() {
		return $this->_pluginLoader;
	}
	
	/**
	 * @param ffPluginLoader $_pluginLoader
	 */
	protected function _setPluginloader(ffPluginLoader $pluginLoader) {
		$this->_pluginLoader = $pluginLoader;
		return $this;
	}
	
	/**
	 *
	 * @return ffThemeLoader
	 */
	protected function _getThemeLoader() {
		return $this->_themeLoader;
	}
	
	/**
	 *
	 * @param ffThemeLoader $themeLoader        	
	 */
	protected function _setThemeLoader(ffThemeLoader $themeLoader) {
		$this->_themeLoader = $themeLoader;
		return $this;
	}
	
	
	
}