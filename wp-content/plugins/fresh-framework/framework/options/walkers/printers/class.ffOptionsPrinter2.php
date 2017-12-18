<?php

class ffOptionsPrinter2 extends ffBasicObject {
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/
	/**
	 * @var ffRequest
	 */
	private $_request = null;
	/**
	 * @var ffWPLayer
	 */
	private $_WPLayer = null;

/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/
	private $_data = null;

	private $_structure = null;

	private $_namePrefix = 'default';

/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
	public function __construct($data = null, $structure = null) {
		$this->_setData( $data );
		$this->_setStructure( $structure );
		$this->_setWPLayer( ffContainer()->getWPLayer() );
		$this->_setRequest( ffContainer()->getRequest() );
	}

	public function hookAjax() {
		$this->_getWPLayer()
			->getHookManager()
			->addAjaxRequestOwner('ffOptionsPrinter2', array($this,'actionOptions2Ajax'));
	}

	public function actionOptions2Ajax( ffAjaxRequest $ajaxRequest ) {
		switch( $ajaxRequest->getSpecification('action') ) {
			case 'getPostByType':
				$this->_actGetPostByType( $ajaxRequest);
				break;

			case 'getTaxonomiesByType':
				$this->_actGetTaxonomiesByType( $ajaxRequest );
				break;

			case 'getAllGoogleFonts':
				$this->_actGetAllGoogleFonts( $ajaxRequest );
				break;

            case 'getAllGlobalStyles':
                $this->_actGetAllGlobalStyles( $ajaxRequest );
                break;

			case 'getElementGlobalStyles':
				$this->_actGetElementGlobalStyles( $ajaxRequest );
				break;

			case 'setElementGlobalStyles':
				$this->_actSetElementGlobalStyles( $ajaxRequest );
				break;

			case 'getRevolutionSlider':
				$this->_actGetRevolutionSlider( $ajaxRequest );
                break;
			case 'getSidebars':
				$this->_actGetSidebars( $ajaxRequest );
                break;

			case 'getAllAcfGroups':
				$this->_actGetACFGroups( $ajaxRequest );
				break;
		}
	}

	private function _actGetRevolutionSlider( $ajaxRequest ) {
		$values = array();

		$newValue = array();
		$newValue['name'] = 'Not Selected';
		$newValue['value'] = '';

		if( class_exists('RevSlider') ) {
			$revSlider = new RevSlider();

			$slidersRevo = $revSlider->getArrSliders();

			if( !empty( $slidersRevo ) ) {

				foreach( $slidersRevo as $oneSlider ) {
					$newSlider = array();
					$newSlider['name'] = $oneSlider->getTitle();
					$newSlider['value'] = $oneSlider->getAlias();

					$values[] = $newSlider;
				}

			} else {
				$newSlider = array();
				$newSlider['name'] = 'No sliders found';
				$newSlider['value'] = 'no_sliders_found';

				$values[] = $newSlider;
			}
		} else {
			$newSlider = array();
			$newSlider['name'] = 'Revolution slider not installed';
			$newSlider['value'] = 'slider_not_installed';

			$values[] = $newSlider;
		}

		$this->_getAjaxDispatcher()->addResponse('status', 1);
		$this->_getAjaxDispatcher()->addResponse('revolutionSliders', $values );
	}

	private function _actGetElementGlobalStyles( $ajaxRequest ) {
//		$options = ffContainer()->getDataStorageFactory()->createDataStorageWPOptions();
		$themeBuilderGlobalStyles = ffContainer()->getThemeFrameworkFactory()->getThemeBuilderGlobalStyles();
		$this->_getAjaxDispatcher()->addResponse('status', 1);
		$this->_getAjaxDispatcher()->addResponse('globalStyles', $themeBuilderGlobalStyles->getElementGlobalStyles() );
	}

	/**
	 * @param ffAjaxRequest $ajaxRequest
	 */
	private function _actSetElementGlobalStyles( $ajaxRequest)  {
		$globalStyles = $ajaxRequest->getDataStripped('globalStyles');
		ffContainer()->getThemeFrameworkFactory()->getThemeBuilderGlobalStyles()->setElementGlobalStyles( $globalStyles );
	}

	/**
	 * @param $ajaxRequest ffAjaxRequest
	 */
	private function _actGetAllGoogleFonts( $ajaxRequest ) {
		$container = ffContainer();
		$googleFontsPath = $container->getWPLayer()->getAssetsSourceHolder()->getGoogleFontsAjaxPath();
		$googleFontsJSON = $container->getFileSystem()->getContents( $googleFontsPath );

		$this->_getAjaxDispatcher()->addResponse('status', 1);
		$this->_getAjaxDispatcher()->addResponse('fonts', $googleFontsJSON );
	}

    private function _actGetAllGlobalStyles( $ajaxRequest ) {
        $container = ffContainer();

        $gs = $container->getThemeFrameworkFactory()->getThemeBuilderGlobalStyles();

        $allGlobalStyles = $gs->getGlobalStylesGroupWithJustNames();

        $this->_getAjaxDispatcher()->addResponse('status', 1 );
        $this->_getAjaxDispatcher()->addResponse('allGlobalStyles', $allGlobalStyles);
    }

	/**
	 * @param $ajaxRequest ffAjaxRequest
	 */
	private function _actGetTaxonomiesByType( $ajaxRequest ) {
		$taxType = $ajaxRequest->getData('taxType');
		
		$taxonomies = ffContainer()->getTaxLayer()->getTaxGetter()->filterByTaxonomy( $taxType)->getList();

		$taxonomiesToSelect = array();

		if( $taxonomies == null ) {
//			$item = array();
//			$item['name'] = 'Nothing Found';
//			$item['value'] = '-1--||--Nothing Found';
//
//			$taxonomiesToSelect[] = $item;
		} else {
//			$item = array();
//			$item['name'] = 'All';
//			$item['value'] = 'all--||--All';
//
//			$taxonomiesToSelect[] = $item;

			foreach( $taxonomies as $oneTax ) {
				$item = array();

				$item['name'] = $oneTax->name;
				$item['value'] = $oneTax->term_id  . '*|*' . $oneTax->name;

				$taxonomiesToSelect[] = $item;
			}
		}

		$dispatcher = $this->_getAjaxDispatcher();
		$dispatcher->addResponse('status', 1);
		$dispatcher->addResponse('tax', $taxonomiesToSelect);

	}

	private function _actGetSidebars( $ajaxRequest ) {
		$items = array();

		$items[] = array('name'=>'Content Sidebar', 'value'=>'sidebar-content');
		$items[] = array('name'=>'Content Sidebar 2', 'value'=>'sidebar-content-2');

		if (class_exists('WooCommerce')) {
			$items[] = array('name'=>'Shop Sidebar', 'value'=>'shop-sidebar');
		}

		for ($i = 1; $i <= 4; $i++) {
			$items[] = array('name'=> ark_wp_kses(__('Footer Sidebar', 'ark')) . ' #' . $i, 'value'=> 'sidebar-footer-' . $i);
		}


		if (class_exists('ffSidebarManager')) {
			$sidebars = ffSidebarManager::getQuery('sidebars sidebars');
			if( is_object( $sidebars ) ) {
				foreach( $sidebars as $oneSidebar ) {
					$name = strip_tags($oneSidebar->get('title'));
					$id = 'ark-custom-sidebar-' . sanitize_title($oneSidebar->get('slug'));

					$items[] = array('name'=>$name, 'value'=>$id);
				}
			}
		}

		$dispatcher = $this->_getAjaxDispatcher();
		$dispatcher->addResponse('status', 1);
		$dispatcher->addResponse('sidebars', $items);
	}

	private function _getACFGroupsInner() {
		if( ! class_exists('acf') ){
			return array(
				array(
					'name'  => 'Plugin ACF is not installed',
					'value' => '',
				)
			);
		}

		$ret = array();

		if( version_compare( acf()->settings['version'], '5.0.0' ) >= 0 ){
			// ACF 5.0.0 and more or ACF Pro

			$acf_groups = ffContainer()->getWPLayer()->get_posts( array('posts_per_page' => 999, 'post_type' => 'acf-field-group') );
			foreach ( $acf_groups as $group ) {
				$ret[] = array(
					'name'  => $group->post_title,
					'value' => $group->ID,
				);
			}

		} else {
			// ACF 4.X.X

			$acf_groups = ffContainer()->getWPLayer()->get_posts( array('posts_per_page' => 999, 'post_type' => 'acf') );
			foreach ( $acf_groups as $group ) {
				$ret[] = array(
					'name'  => $group->post_title,
					'value' => $group->ID,
				);
			}

		}

		if( ! empty($ret) ){
			return $ret;
		}

		return array(
			array(
				'name'  => 'Plugin ACF does not found any Field Group',
				'value' => '',
			)
		);
	}

	public function _actGetACFGroups( $ajaxRequest ) {
	 	$acfGroups = $this->_getACFGroupsInner();

		$dispatcher = $this->_getAjaxDispatcher();
		$dispatcher->addResponse('status', 1);
		$dispatcher->addResponse('allAcfGroups', $acfGroups);
		$dispatcher->addResponse('allFields', $this->_actGetACFFields() );
	}

	private function _getAcfFieldByGroupId( $field_group_post_id ) {
		if( ! class_exists('acf') ){
			return array(
				array(
					'name'  => 'Plugin ACF is not installed',
					'value' => '',
				)
			);
		}

		$ret = array();

		if( version_compare( acf()->settings['version'], '5.0.0' ) >= 0 ){
			// ACF 5.0.0 and more or ACF Pro

			$acf_field = ffContainer()->getWPLayer()->get_posts(
				array(
					'posts_per_page' => 999 ,
					'post_type' => 'acf-field' ,
					'post_parent' => $field_group_post_id ,
					'orderby' => 'menu_order' ,
					'order' => 'ASC'
				)
			);

			if( !empty( $acf_field ) ) {
				foreach ($acf_field as $field) {
					$type = unserialize( $field->post_content );
					$type = $type['type'];
					$ret[] = array(
						'name' => $field->post_title . ' (' . $type . ')',
						'value' => $field->post_excerpt,
					);
				}

				return $ret;
			}

		} else {
			// ACF 4.X.X

			$wpdb = ffContainer()->getWPLayer()->getWPDB();

			$mysql_res = $wpdb->get_results("
				SELECT meta_value
				FROM {$wpdb->prefix}postmeta
				WHERE meta_key LIKE 'field_%'
				AND post_id = '$field_group_post_id'"
				, ARRAY_N
			);

			if ($mysql_res) {

				foreach ($mysql_res as $one_res) {
					$one_res = $one_res[0];
					$one_res = unserialize($one_res);
					$ret[] = array(
						'name' => $one_res['label'] . ' (' . $one_res['type'] . ')',
						'value' => $one_res['name'],
					);
				}

				return $ret;
			}
		}

		return array(
			array(
				'name'  => 'Error in Plugin ACF - no field found',
				'value' => '',
			)
		);

	}


	private function _actGetACFFields( ) {
		$allGroups = $this->_getACFGroupsInner();

		$toReturn = [];
		foreach( $allGroups as $oneGroup ) {
			$groupId = $oneGroup['value'];

			$groupFields = $this->_getAcfFieldByGroupId( $groupId );

			$toReturn[ $groupId ] = $groupFields;
		}

		return $toReturn;
	}

	/**
	 * @param $ajaxRequest ffAjaxRequest
	 */
	private function _actGetPostByType( $ajaxRequest)  {
		$postType = $ajaxRequest->getData('postType');

		$posts = ffContainer()->getPostLayer()->getPostGetter()->setNumberOfPosts(-1)->getPostsByType( $postType );

		$postsToSelect = array();

		if( $posts == null ) {
//			$item = array();
//			$item['name'] = 'Nothing Found';
//			$item['value'] = 'not--||--Nothing Found';

//			$postsToSelect[] = $item;
		} else {
//			$item = array();
//			$item['name'] = 'Not Selected';
//			$item['value'] = 'not--||--Not Selected';
//
//			$postsToSelect[] = $item;

			foreach( $posts as $onePost )  {
				$item = array();
				$item['name'] = $onePost->getTitle();
				$item['value'] = $onePost->getID() . '--||--' . $onePost->getTitle();

				$postsToSelect[] = $item;
			}
		}

		$dispatcher = $this->_getAjaxDispatcher();
		$dispatcher->addResponse('status', 1);
		$dispatcher->addResponse('posts', $postsToSelect);
	}

/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/
	public function printOptions() {
		ffContainer()->getFrameworkScriptLoader()->requireFrsLibOptions2();

		$jsonConvertor = ffContainer()->getOptionsFactory()->createOptionsPrinterJSONConvertor();
		$jsonConvertor->setOptionsStructure( $this->_getStructure() );

		$optionsArray = ($jsonConvertor->walk());
		$optionsJSON = json_encode( $optionsArray );

		$hasBlockInside = $jsonConvertor->hasBlockInside();

		$optionsJSONEscaped = $this->_escapeData( $optionsJSON );
		$optionsDataEscaped = $this->_escapeData( json_encode($this->_getData()) );
		
		$colorLibrary = ffContainer()->getThemeFrameworkFactory()->getThemeBuilderColorLibrary()->getLibrary();
		$colorLibraryJSON = json_encode( $colorLibrary);
		$colorLibraryEscaped = $this->_escapeData( $colorLibraryJSON );

		echo '<div class="ff-options-2-holder" data-has-block-inside="' . (int)$hasBlockInside.'" data-settings="'.$this->_getSettingsJSON().'">';
			echo '<div class="ff-options2-data-holder" style="display:none;">' ;
				echo '<textarea class="ff-options2-structure">' . $optionsJSONEscaped .'</textarea>';
				echo '<textarea class="ff-options2-data">' . $optionsDataEscaped .'</textarea>';
				echo '<textarea class="ff-options2-color-library">' . $colorLibraryEscaped .'</textarea>';
			echo '</div>';
			echo '<div class="ff-options2 ffb-options">';
			echo '</div>';
		echo '</div>';
	}

	public function setName( $namePrefix)  {
		$this->_namePrefix = $namePrefix;
	}

	public function getSubmittedOptions() {
		$optionsFullName = $this->_namePrefix . '-parsed';
		$optionsValue = $this->_getRequest()->post( $optionsFullName );

		if( $optionsValue != null ) {
			$optionsValue = json_decode( $optionsValue, true );
		}

		return $optionsValue;
	}

/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/
	private function _getSettingsJSON() {
		$settings = array();
		$settings['prefix'] = $this->_namePrefix;

		return $this->_escapeData(json_encode( $settings ));
	}

	private function _escapeData( $data ) {
		return $this->_getWPLayer()->esc_attr( $data );
	}
	private function _getOptionsJSON() {
		$jsonConvertor = ffContainer()->getOptionsFactory()->createOptionsPrinterJSONConvertor();
		$jsonConvertor->setOptionsStructure( $this->_getStructure() );

		$optionsArray = ($jsonConvertor->walk());
		$optionsJSON = json_encode( $optionsArray );

		return $optionsJSON;
	}

/**********************************************************************************************************************/
/* ABSTRACT FUNCTIONS
/**********************************************************************************************************************/


/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/	/**
 * @return null
 */
	private function _getData() {
		return $this->_data;
	}

	/**
	 * @param null $data
	 */
	private function _setData($data) {
		$this->_data = $data;
	}

	/**
	 * @return null
	 */
	private function _getStructure() {
		return $this->_structure;
	}

	/**
	 * @param null $structure
	 */
	private function _setStructure($structure) {
		$this->_structure = $structure;
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
	 * @return ffRequest
	 */
	private function _getRequest() {
		return $this->_request;
	}

	/**
	 * @param ffRequest $request
	 */
	private function _setRequest($request) {
		$this->_request = $request;
	}

	/**
	 * @return ffAjaxDispatcher
	 */
	private function _getAjaxDispatcher() {
		return ffContainer()->getAjaxDispatcher();
	}

}