<?php

class ffThemeBuilderManager extends ffBasicObject {
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/
	/**
	 * @var ffThemeBuilderElementManager
	 */
	private $_themeBuilderElementManager = null;

	/**
	 * @var ffThemeBuilderShortcodesWalker
	 */
	private $_themeBuilderShortcodesWalker = null;

	/**
	 * @var ffThemeBuilderDeveloperTools
	 */
	private $_themeBuilderDeveloperTools = null;

	/**
	 * @var ffWPLayer
	 */
	private $_WPLayer = null;

	private $_supportedPostTypes = array();
/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/
	private $_isEditMode = false;

	private $_overloadedFrameworkElements = array();

	private $_removedFrameworkElements = array();

	private $_renderedCssStack = array();

	private $_renderedJsStack = array();
/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
	public function __construct() {
		$this->_setThemeBuilderElementManager( ffContainer()->getThemeFrameworkFactory()->getThemeBuilderElementManager() );
		$this->_setThemeBuilderShortcodesWalker( ffContainer()->getThemeFrameworkFactory()->getThemeBuilderShortcodesWalker() );
		$this->_setWPLayer( ffContainer()->getWPLayer() );

		$this->_hookActions();
	}
/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/
	private function _hookActions() {
		$WPLayer =$this->_getWPLayer();
		$WPLayer->add_action_also_when_executed('ff-delete-builder-cache', array( $this, 'actDeleteBuilderCache'));
	}

	public function actDeleteBuilderCache() {

		$dataStorageCache = ffContainer()->getDataStorageCache();
		$dataStorageCache->deleteNamespace('freshbuilder');
	}

	public function setIsEditMode( $value ) {
		$this->_isEditMode = $value;
		$this->_getThemeBuilderShortcodesWalker()->setIsEditMode( $value );
		$this->_getThemeBuilderElementManager()->setIsEditMode( $value );
		
	}

	public function addSupportedPostType( $postType ) {
		$this->_supportedPostTypes[] = $postType;
	}

	public function getSupportedPostTypes() {
		return $this->_supportedPostTypes;
	}


	public function enableBuilderSupport() {
		ffContainer()->getMetaBoxes()->getMetaBoxManager()->addMetaBoxClassName('ffMetaBoxThemeBuilder');

		$wpLayer = $this->_getWPLayer();

        $this->_hookYoastSeo();
 

		if( $wpLayer->is_freshface_admin_server_or_local() ) {
			$this->_setThemeBuilderDeveloperTools( ffContainer()->getThemeFrameworkFactory()->getThemeBuilderDeveloperTools() );
		}

		$this->_addFrameworkElements();

		if( $wpLayer->is_admin() ) {
			$wpLayer->add_action('admin_head', array( $this, 'actAdminPrintColorLibrary'),0);
			ffContainer()->getThemeFrameworkFactory()->getThemeBuilderCache()->deleteOldFiles();
		} else {
			if( $wpLayer->is_user_logged_in() ) {
//				$wpLayer->add_action('')
				$wpLayer->add_action('wp_head', array($this,'actionPrintRefreshBuilderScript'));

//				add_action('wp_head', 'ff_print_js_constants', 1);
//				function ff_print_js_constants() {
//					echo '<script type="text/javascript">'; echo "\n";
//					echo 'var ajaxurl = "'.admin_url('admin-ajax.php').'";'; echo "\n";
//					echo 'var ff_template_url = "'.get_template_directory_uri().'";'; echo "\n";
//					echo '</script>'; echo "\n";
//				}

			}
		}
		$this->_getWPLayer()->add_action('after_setup_theme', array( $this, 'enablePrintingInDoShortcodeFunction') );
//		$this->enablePrintingInDoShortcodeFunction();
	}

	public function enablePrintingInDoShortcodeFunction() {
		if( class_exists('ffThemeOptions')) {
			$enableJsCache = ffThemeOptions::getQuery('layout')->get('enable-builder-shortcodes', 1);

			if ($enableJsCache) {
				$elements = $this->_getThemeBuilderElementManager()->getAllElementsIds();

				// now we need to register all the elements as our shortcodes
				foreach ($elements as $elementId) {
					for ($i = 0; $i <= 0; $i++) {
						$shortcodeName = 'ffb_' . $elementId . '_' . $i;
						add_shortcode($shortcodeName, array($this, 'builderShortcodeCallback'));
//				do_shortcode()
					}
				}
			}
		}
	}

	// rebuild the content of shortcode, let it build through builder and then print that thing like a boss
	public function builderShortcodeCallback( $attributes, $content, $shortcodeName ) {
		$reconstructed = '';
		$uniqueId = isset( $attributes['unique_id'] ) ? $attributes['unique_id'] : '';
		$data = isset( $attributes['data'] ) ? $attributes['data'] : '';

		$reconstructed .= '[' . $shortcodeName . ' unique_id="' . $uniqueId .'" data="'.$data.'"]';
		$reconstructed .= $content;
		$reconstructed .= '[/' . $shortcodeName . ']';

		$content = $this->renderButNotPrint( $reconstructed );
		$css = $this->getRenderedCss();
		$css = str_replace("\n", '', $css );
		$content .= '<style>' . $css .'</style>';

		$js = $this->getRenderedJs();
		$content .= '<script type="text/javascript">' . $js .'</script>';

		return $content;
	}

	private function _hookYoastSeo() {
        $wpLayer = $this->_getWPLayer();
        $wpLayer->add_filter('wpseo_opengraph_desc', array($this,'getOnlyTextContent'));
        $wpLayer->add_filter('wpseo_twitter_description', array($this,'getOnlyTextContent'));

    }

    public function getOnlyTextContent( $contentWithShortcodes ) {

        $scw = $this->_getThemeBuilderShortcodesWalker();
        $scw->setModePrintOnlyText( true );

        $content = $scw->get( $contentWithShortcodes );

        $scw->setModePrintOnlyText( false );

        return $content;

    }
//$tags_to_remove = apply_filters( 'strip_shortcodes_tagnames', $tags_to_remove, $content );

	public function actionPrintRefreshBuilderScript() {
		global $post;
		$postId = '';
		if( is_object( $post ) ) {
			$postId = $post->ID;
		} else {
			$postId = 'null';
		}

		?>
			<script type="text/javascript">
				jQuery(document).ready(function($){
					if( window.frslib ) {
						frslib.messages.addListener(function (message) {

							console.log( message);
							console.log( message.post_id);

							if (message.command == "refresh" ) {
								if( message.post_id == undefined ) {
									location.reload();
								} else {
									var currentPostId = <?php echo $postId; ?>;
									if( message.post_id == currentPostId ) {
										location.reload();
									}
								}
//
							}
						});
					}
				});

			</script>
		<?php
	}



//
//	<script>
//		jQuery(document).ready(function ($) {
//			var currentPageId =
//			frslib.messages.addListener(function (message) {
//				if (message.command == 'refresh' && parseInt(message.post_id) == parseInt(currentPageId)) {
//					location.reload();
//				}
//			});
//		});
//	</script>

	public function addMenuItem( $name, $id ) {
		$this->_getThemeBuilderElementManager()->addMenuItem( $name, $id );
	}

	public function setElementDataFilter( $callback ) {
		$this->_getThemeBuilderShortcodesWalker()->setShortcodeDataFilter( $callback );
	}

	public function setIsCachingMode( $isCachingMode ) {
		return $this->_getThemeBuilderShortcodesWalker()->setIsCachingMode( $isCachingMode );
	}

	public function render( $value ) {
		$this->_getThemeBuilderShortcodesWalker()->render( $value );
		$this->addRenderdCssToStack();
		$this->addRenderedJsToStack();

		echo $this->_printRenderedStyles();
	}

	private function _printRenderedStyles() {
		$renderedJS = $this->getRenderedJsStack();
		$renderedCss = $this->getRenderedCssStack();

		$toReturn = '';
		if( !empty( $renderedJS )  ) {
			$toReturn .= '<script>' . $this->getRenderedJsStack() . '</script>';
		}

		if( !empty( $renderedCss ) ) {
			$css = $this->getRenderedCssStack();
			$css = str_replace("\n", '', $css );
			$toReturn .= '<style>' . $css .'</style>';
		}

		$this->_renderedCssStack = array();
		$this->_renderedJsStack = array();

		return $toReturn;
	}

	public function printRenderedCss() {
		$css = $this->getRenderedCss();
		$css = str_replace("\n", '', $css );
		echo '<style>' . $css .'</style>';
	}

	public function getRenderedCss() {
		return $this->_getThemeBuilderShortcodesWalker()->getRenderedCss();
	}
	
	public function getRenderedJs() {
		return $this->_getThemeBuilderShortcodesWalker()->getRenderedJs();
	}

	public function addRenderdCssToStack( $cssToAdd = null ) {
		$renderedCss = $this->getRenderedCss();
//		ffStopWatch::addVariableDump( $renderedCss );
		if( !empty( $renderedCss ) ) {
			$this->_renderedCssStack[] = $renderedCss;
		}

		if( $cssToAdd != null ) {
			$this->_renderedCssStack[] = $cssToAdd;
		}

		$this->_getThemeBuilderShortcodesWalker()->resetCss();

	}

	public function addRenderedJsToStack( $jsToAdd = null ) {
		$renderedJs = $this->getRenderedJs();
		if( !empty( $renderedJs ) ) {
			$this->_renderedJsStack[] = $renderedJs;
		}

		if( $jsToAdd != null ) {
			$this->_renderedJsStack[] = $jsToAdd;
		}

		$this->_getThemeBuilderShortcodesWalker()->resetJs();
	}

	public function getRenderedCssStack() {
		
		$toReturn = null;
		if( !empty( $this->_renderedCssStack ) ) {
			$toReturn = implode("\n", $this->_renderedCssStack );
		}

		return $toReturn;
	}

	public function getRenderedJsStack() {
		$toReturn = null;
		if( !empty( $this->_renderedJsStack ) ) {
			$toReturn = implode("\n", $this->_renderedJsStack );
		}

		return $toReturn;
	}

	public function renderButNotPrint( $value ) {
		return $this->_getThemeBuilderShortcodesWalker()->get( $value );
	}

	public function overloadFrameworkElement( $frameworkElementClassName, $newClassName ) {
		$this->_overloadedFrameworkElements[ $frameworkElementClassName ] = $newClassName;
	}

	public function removeFrameworkElement( $frameworkElementClassName ) {
		$this->_removedFrameworkElements[] = $frameworkElementClassName;
	}

	public function addElement( $className ) {
		$this->_getThemeBuilderElementManager()->addElement( $className );
	}
/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/
	public function actAdminPrintColorLibrary() {
		$colorLibraryContent = $this->_getColorLibrary()->getLibrary();

		$colorLibraryJSON = json_encode( $colorLibraryContent );
		echo '<script>';
			echo 'var frs_theme_color_library = ' . $colorLibraryJSON;
		echo '</script>';
	}

	private function _addFrameworkElements() {
		$this->_addFrameworkElement('ffElSection');
		$this->_addFrameworkElement('ffElSectionBootstrap');
		$this->_addFrameworkElement('ffElContainer');
		$this->_addFrameworkElement('ffElRow');
		$this->_addFrameworkElement('ffElColumn');
		$this->_addFrameworkElement('ffElWrapper');
		$this->_addFrameworkElement('ffElLink');
		$this->_addFrameworkElement('ffElContentBlock');
		$this->_addFrameworkElement('ffElContentBlockAdmin');
		$this->_addFrameworkElement('ffElIf');
		$this->_addFrameworkElement('ffElShortcodeWrapper');
	}

	private function _addFrameworkElement( $elementName ) {
		$hasBeenOverloaded = isset($this->_overloadedFrameworkElements[ $elementName]);


		if( $hasBeenOverloaded ) {
			$newClassName = $this->_overloadedFrameworkElements[ $elementName];
			$oldClassName = $elementName;
			$this->_getThemeBuilderElementManager()->addOverloadedElement( $newClassName, $oldClassName );
		} else {
			$this->_getThemeBuilderElementManager()->addElement( $elementName );
		}
	}
/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/
	/**
	 * @return ffThemeBuilderElementManager
	 */
	private function _getThemeBuilderElementManager()
	{
		return $this->_themeBuilderElementManager;
	}

	public function getThemeBuilderElementManager() {
		return $this->_getThemeBuilderElementManager();
	}

	/**
	 * @param ffThemeBuilderElementManager $themeBuilderElementManager
	 */
	private function _setThemeBuilderElementManager($themeBuilderElementManager)
	{
		$this->_themeBuilderElementManager = $themeBuilderElementManager;
	}

	/**
	 * @return ffThemeBuilderShortcodesWalker
	 */
	public function getThemeBuilderShortcodesWalker() {
		return $this->_getThemeBuilderShortcodesWalker();
	}

	/**
	 * @return ffThemeBuilderShortcodesWalker
	 */
	private function _getThemeBuilderShortcodesWalker()
	{
		return $this->_themeBuilderShortcodesWalker;
	}

	/**
	 * @param ffThemeBuilderShortcodesWalker $themeBuilderShortcodesWalker
	 */
	private function _setThemeBuilderShortcodesWalker($themeBuilderShortcodesWalker)
	{
		$this->_themeBuilderShortcodesWalker = $themeBuilderShortcodesWalker;
	}

	/**
	 * @return ffWPLayer
	 */
	private function _getWPLayer() {
		return $this->_WPLayer;
	}

	/**
	 * @param ffWPLayer $WPLayer
	 */
	private function _setWPLayer($WPLayer) {
		$this->_WPLayer = $WPLayer;
	}

	/**
	 * @return ffThemeBuilderDeveloperTools
	 */
	private function _getThemeBuilderDeveloperTools() {
		return $this->_themeBuilderDeveloperTools;
	}

	/**
	 * @param ffThemeBuilderDeveloperTools $themeBuilderDeveloperTools
	 */
	private function _setThemeBuilderDeveloperTools($themeBuilderDeveloperTools) {
		$this->_themeBuilderDeveloperTools = $themeBuilderDeveloperTools;
	}

	private function _getColorLibrary() {
		return ffContainer()->getThemeFrameworkFactory()->getThemeBuilderColorLibrary();
	}


}