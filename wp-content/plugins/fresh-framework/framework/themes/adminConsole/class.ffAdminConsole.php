<?php

class ffAdminConsole extends ffBasicObject {
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/
	/**
	 * @var ffWPLayer
	 */
	private $_WPLayer = null;

	/**
	 * @var ffViewDataManager
	 */
	private $_viewDataManager = null;

//	private $_

/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
	public function __construct( $WPLayer ) {
		$this->_setWPLayer( $WPLayer );
	}

/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/

	public function enableAdminConsole() {
		$WPLayer = $this->_getWPLayer();

		if( !$WPLayer->is_admin() && $WPLayer->current_user_can('administrator') ) {
			$WPLayer->add_action('wp_footer', array($this,'actionWPFooter'));
			ffContainer()->getFrameworkScriptLoader()->requireJqueryCookie();
		}
	}

	private function _getNameForPlacementSet( $value ) {
		$name = '';
		switch( $value ) {
			case 'singular':
				$name = 'Post/Page Settings';
				break;
			case 'sitepref':
				$name = 'Sitemap';
				break;
			case 'themeopt':
				$name = 'Theme Options';
				break;
		}

		return $name;
	}

	private function _getEditUrlForPlacementSet( $value ) {
		$WPLayer = $this->_getWPLayer();
		$url = 'xx';
		switch( $value ) {
			case 'singular':
				$postId = $WPLayer->get_post_ID_outside_loop();
				$url = $WPLayer->get_edit_post_link( $postId );
				break;
			case 'sitepref':
				$url = $WPLayer->get_admin_url(null, 'admin.php?page=SitePreferences');
				break;
			case 'themeopt':
				$url = $WPLayer->get_admin_url(null, 'admin.php?page=ThemeOptions');
				break;
		}

		return $url;
	}

	public function actionWPFooter() {
		$vdm = ffContainer()->getThemeFrameworkFactory()->getSitePreferencesFactory()->getViewDataManager();

		$consoleInfo = $vdm->getConsoleInfo();

		$optionsCollection = ffContainer()->getDataStorageFactory()->createOptionsCollection();

		$info = new ffDataHolder();
		$WPLayer = $this->_getWPLayer();
		$urlRewriter = ffContainer()->getUrlRewriter();
		/*----------------------------------------------------------*/
		/* HEADER
		/*----------------------------------------------------------*/
		$optionsCollection->setNamespace('header');

		$info->headerName = 'None';
		$info->headerId = $consoleInfo->header;


		$info->headerSet = $consoleInfo->header_set;
		$info->headerSetName =$this->_getNameForPlacementSet( $consoleInfo->header_set );
		$info->headerSetUrl = $this->_getEditUrlForPlacementSet( $consoleInfo->header_set );

		$item = $optionsCollection->getItemById( $consoleInfo->header );
		if( $item != null ) {
			$info->headerName = $item->get('name', 'None');
		}

		$urlRewriter->reset();
		$urlRewriter->setUrl($WPLayer->get_admin_url(null, 'admin.php?page=Headers') );
		$urlRewriter->addQueryParameter('item_name', $info->headerName);
		$urlRewriter->addQueryParameter('item_id', $info->headerId);
		$info->headerEditUrl = $urlRewriter->getNewUrl();

		if( $info->headerName == 'None' ) {
			$info->headerEditUrl = '#';
		}

		/*----------------------------------------------------------*/
		/* TITLEBAR
		/*----------------------------------------------------------*/
		$optionsCollection->setNamespace('titlebar');

		$info->titlebarName = 'None';
		$info->titlebarId = $consoleInfo->titlebar;
		$info->titlebarSet = $consoleInfo->titlebar_set;
		$info->titlebarSetName =$this->_getNameForPlacementSet( $consoleInfo->titlebar_set );
		$info->titlebarSetUrl = $this->_getEditUrlForPlacementSet( $consoleInfo->titlebar_set );

		$item = $optionsCollection->getItemById( $consoleInfo->titlebar );
		if( $item != null ) {
			$info->titlebarName = $item->get('name', 'None');
		}

		$urlRewriter->reset();
		$urlRewriter->setUrl($WPLayer->get_admin_url(null, 'admin.php?page=Titlebars') );
		$urlRewriter->addQueryParameter('item_name', $info->titlebarName);
		$urlRewriter->addQueryParameter('item_id', $info->titlebarId);
		$info->titlebarEditUrl = $urlRewriter->getNewUrl();

		if( $info->titlebarName == 'None' ) {
			$info->titlebarEditUrl = '#';
		}

		/*----------------------------------------------------------*/
		/* FOOTER
		/*----------------------------------------------------------*/
		$optionsCollection->setNamespace('footer');

		$info->footerName = 'None';
		$info->footerId = $consoleInfo->footer;
		$info->footerSet = $consoleInfo->footer_set;
		$info->footerSetName =$this->_getNameForPlacementSet( $consoleInfo->footer_set );
		$info->footerSetUrl = $this->_getEditUrlForPlacementSet( $consoleInfo->footer_set );

		$item = $optionsCollection->getItemById( $consoleInfo->footer );
		if( $item != null ) {
			$info->footerName = $item->get('name', 'None');
		}

		$urlRewriter->reset();
		$urlRewriter->setUrl($WPLayer->get_admin_url(null, 'admin.php?page=Footers') );
		$urlRewriter->addQueryParameter('item_name', $info->footerName);
		$urlRewriter->addQueryParameter('item_id', $info->footerId);
		$info->footerEditUrl = $urlRewriter->getNewUrl();

		if( $info->footerName == 'None' ) {
			$info->footerEditUrl = '#';
		}

		/*----------------------------------------------------------*/
		/* BOXED WRAPPER
		/*----------------------------------------------------------*/
		$optionsCollection->setNamespace('boxed_wrapper');

		$info->boxed_wrapperName = 'None';
		$info->boxed_wrapperId = $consoleInfo->boxed_wrapper;
		$info->boxed_wrapperSet = $consoleInfo->boxed_wrapper_set;
		$info->boxed_wrapperSetName =$this->_getNameForPlacementSet( $consoleInfo->boxed_wrapper_set );
		$info->boxed_wrapperSetUrl = $this->_getEditUrlForPlacementSet( $consoleInfo->boxed_wrapper_set );

		$item = $optionsCollection->getItemById( $consoleInfo->boxed_wrapper );
		if( $item != null ) {
			$info->boxed_wrapperName = $item->get('name', 'None');
		}

		$urlRewriter->reset();
		$urlRewriter->setUrl($WPLayer->get_admin_url(null, 'admin.php?page=BoxedWrappers') );
		$urlRewriter->addQueryParameter('item_name', $info->boxed_wrapperName);
		$urlRewriter->addQueryParameter('item_id', $info->boxed_wrapperId);
		$info->boxed_wrapperEditUrl = $urlRewriter->getNewUrl();

		if( $info->boxed_wrapperName == 'None' ) {
			$info->boxed_wrapperEditUrl = '#';
		}

		/*----------------------------------------------------------*/
		/* LAYOUT
		/*----------------------------------------------------------*/
		$info->layoutName = $consoleInfo->layout_name;
		$info->layoutId = $consoleInfo->layout;
		$info->layoutSet = $consoleInfo->layout_set;
		$info->layoutSetName =$this->_getNameForPlacementSet( $consoleInfo->layout_set );
		$info->layoutSetUrl = $this->_getEditUrlForPlacementSet( $consoleInfo->layout_set );

//		var_dump( $consoleInfo );

		$layoutName = $info->layoutName;
		if( empty( $layoutName ) ) {
			$info->layoutName = '<span style="color:red;">NOT ASSIGNED</span>';
		}

		$style = '';

//		var_Dump( ffContainer()->getRequest()->cookie('ffb-hide-console')  );
		if( ffContainer()->getRequest()->cookie('ffb-hide-console') == 'true' ) {
//			$style = ' style="display:none;" ';
		}
		echo '<div class="ffb-admin-console" '.$style.'>';
//			echo '<div class="ffb-admin-console__action-close">CLOSE</div>'


			echo '<i class="ff-font-awesome4 icon-info-circle"></i>';

			echo '<div class="ffb-admin-console__table-wrapper">';
				echo '<table class="ffb-admin-console__table">';
					echo '<tbody>';

						echo '<tr class="ffb-admin-console__one-line">';
							echo '<td class="ffb-type">Layout</td>';
							echo '<td class="ffb-name-and-loc">';
								echo '<span class="ffb-name">'.$info->layoutName.'</span></br>';
								echo '<span class="ffb-loc"><a target="_blank" href="'.$info->layoutSetUrl.'">'.$info->layoutSetName.'</a></span>';
							echo '</td>';
						echo '</tr>';

						echo '<tr class="ffb-admin-console__one-line">';
							echo '<td class="ffb-type">Header</td>';
							echo '<td class="ffb-name-and-loc">';
								echo '<span class="ffb-name"><a target="_blank" href="'.$info->headerEditUrl.'">'.$info->headerName.'</a></span><br/>';
								echo '<span class="ffb-loc"><a target="_blank" href="'.$info->headerSetUrl.'">'.$info->headerSetName.'</a></span>';
							echo '</td>';
						echo '</tr>';

						echo '<tr class="ffb-admin-console__one-line">';
							echo '<td class="ffb-type">Titlebar</td>';
							echo '<td class="ffb-name-and-loc">';
								echo '<span class="ffb-name"><a target="_blank" href="'.$info->titlebarEditUrl.'">'.$info->titlebarName.'</a></span><br/>';
								echo '<span class="ffb-loc"><a target="_blank" href="'.$info->titlebarSetUrl.'">'.$info->titlebarSetName.'</a></span>';
							echo '</td>';
						echo '</tr>';

						echo '<tr class="ffb-admin-console__one-line">';
							echo '<td class="ffb-type">Footer</td>';
							echo '<td class="ffb-name-and-loc">';
								echo '<span class="ffb-name"><a target="_blank" href="'.$info->footerEditUrl.'">'.$info->footerName.'</a></span><br/>';
								echo '<span class="ffb-loc"><a target="_blank" href="'.$info->footerSetUrl.'">'.$info->footerSetName.'</a></span>';
							echo '</td>';
						echo '</tr>';

						echo '<tr class="ffb-admin-console__one-line">';
							echo '<td class="ffb-type">Boxed</td>';
							echo '<td class="ffb-name-and-loc">';
								echo '<span class="ffb-name"><a target="_blank" href="'.$info->boxed_wrapperEditUrl.'">'.$info->boxed_wrapperName.'</a></span><br/>';
								echo '<span class="ffb-loc"><a target="_blank" href="'.$info->boxed_wrapperSetUrl.'">'.$info->boxed_wrapperSetName.'</a></span>';
							echo '</td>';
						echo '</tr>';

					echo '</tbody>';
				echo '</table>';

				echo '<div class="ffb-admin-console__table-main-title-wrapper">';
					echo '<div class="ffb-admin-console__table-main-title">';
						echo 'Page Info';
					echo '</div>';
				echo '</div>';
			echo '</div>';


//		echo $header->get('name');
//			var_dump( $info );
		echo '</div>';


		$this->_renderCss();
		$this->_renderJs();
	}

	private function _renderCss() {
		?>
		<style>

			.ffb-admin-console{
				position:fixed;
				right: 55px;
				bottom: 10px;
				/*width:100px;*/
				/*height:100px;*/
				z-index:9999999;
				color: #ffffff !important;
				font-size: 12px;
				font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif;
			}

			@media (max-width: 767px){
				.ffb-admin-console{
					display: none;
				}
			}

			.ffb-admin-console i 	{
				width: 35px;
				height: 35px;
				line-height: 35px;
				text-align: center;
				font-size: 18px;
				border-radius: 3px;
				background-color: rgba(0,0,0,1);
				opacity: 0.4;
				cursor: pointer;
			}

			.ffb-admin-console__table-wrapper 	{
				display: none;

				position: absolute;
				bottom: 0;
				right: 0;
				background-color:rgba(40,40,40,0.95);
				border-radius: 3px 3px 5px 5px;
				padding: 10px 0 0 0;
				z-index: -1;
			}

			.ffb-admin-console:hover .ffb-admin-console__table-wrapper 	{
				display: block;
			}

			.ffb-admin-console:hover i 	{
				background-color: #32d316;
				opacity: 1;
			}


			.ffb-admin-console__table 	{
				white-space: nowrap;
			}
/*
			.ffb-admin-console a 	{
				text-decoration: underline;
			}*/

			.ffb-admin-console__one-line {
			}

			.ffb-admin-console__one-line:last-child 	{
				border: none;
			}

			.ffb-type {
				font-weight: 700;
				padding: 5px 0 5px 15px;
				padding-right: 15px;
				vertical-align: top;
			}

			.ffb-name,
			.ffb-name a 	{
				font-weight: 700;
				color: #ffffff;
			}

			.ffb-name-and-loc {
				padding: 5px 15px 5px 10px;
			}

			.ffb-loc,
			.ffb-loc a 	{
				color: #999999;
			}

			.ffb-admin-console__table-main-title-wrapper{
				background-color: #32d316;
				border-radius: 0 0 3px 3px;
				line-height: 35px;
				padding: 0 15px;
				margin: 10px 0 0 0;
			}

			.ffb-admin-console__table-main-title 	{
				font-weight: 700;
			}

		</style>
		<?php
	}

	private function _renderJs() {
		?>
		<script>
			jQuery(document).ready(function( $ ){
//				var hideConsole = $.cookie('ffb-hide-console', true);




			});
		</script>
		<?php
	}

/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* ABSTRACT FUNCTIONS
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/
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
}