<?php

class ffOptionsPrinterJSONConvertor extends ffOptionsWalker {
    protected $_walkTemplates = false;


    private $_dataRouteDepth = -1;
    private $_dataRoute = array();
    private $_data = array();

    private $_referenceSections = array();

    private $_savedData = null;

    private $_automaticallyInitialiseAtFrontend = true;

	private $_hasBlocksInside = false;

    /**
     * @var ffOptionsPrinterDataBoxGenerator
     */
    private $_dataBoxGenerator = null;


    private $_namePrefix = 'ff_js_options';


    public function __construct( $optionsArrayData, $optionsStructure, $printerComponentFactory, $dataBoxGenerator ) {

        $this->_dataBoxGenerator = $dataBoxGenerator;
        $this->_savedData = $optionsArrayData;
        parent::__construct( null, $optionsStructure );

    }

    public function setAutomaticallyInitialiseAtFrontend( $automaticallyInitialiseAtFrontend ) {
        $this->_automaticallyInitialiseAtFrontend = $automaticallyInitialiseAtFrontend;
    }

    public function setNamePrefix( $namePrefix ) {
        $this->_namePrefix = $namePrefix;
    }

    public function setDataBoxGenerator( ffOptionsPrinterDataBoxGenerator $dataBox ) {
        $this->_dataBoxGenerator = $dataBox;
    }

    protected function _getNamePrefix() {
        return $this->_namePrefix;
    }


	/**
	 * @param ffOneOption $item
	 * @param $newItem
	 */
	private function _optionTypeOptionsCollection( $item, $newItem ) {
		$item->setType( ffOneOption::TYPE_SELECT );

		$namespace = $item->getParam('namespace');
		$namespaceName = $item->getParam('namespace-name');

		$optionsCollection = ffContainer()->getDataStorageFactory()->createOptionsCollection();
		$optionsCollection->setNamespace( $namespace );
		$optionsCollection->addDefaultItemCallbacksFromThemeFolder();

		
		

		foreach( $optionsCollection as $id => $oneColItem) {
			$item->addSelectValue( $oneColItem->get('name'), $id, $namespaceName);
		}
	}


    private function _optionTypeTaxonomy( $item, $newItem ) {

	    if( $item->getParam('load-dynamic', false) ) {
		    $newItem['selectValues'] = $item->getSelectValues();
		    $newItem['params'] = $item->getParams();
		    $newItem['params']['tax_type'] = $item->getParam('tax_type', 'category');
		    $newItem['type'] = 'tax_type_selector';

		    return $newItem;
	    }



        $taxType = $item->getParam('tax_type', 'category');



		$taxGetter = ffContainer::getInstance()->getTaxLayer()->getTaxGetter();//ffContainer::getInstance()->getTaxLayer()->getTaxGetter()->filterByTaxonomy('category')->getList());
		$tax = $taxGetter->filterByTaxonomy( $taxType )->getList();

        $newItem['type'] = 'select2';

            $newItem['selectValues'] = array();
        if( $tax instanceof WP_Error ) {

        } else {

            foreach( $item->getSelectValues()  as $oneSelectValue ) {
                $newItem['selectValues'][] = $oneSelectValue;
            }

            foreach( $tax as $oneTax ) {
                $newItem['selectValues'][] = array('name' => $oneTax->name, 'value'=> $oneTax->term_id);
            }
        }

        $item->addParam('type', 'multiple');

        $item->addParam('class', 'ff-taxonomy-select');
        $newItem['params'] = $item->getParams();

        return $newItem;

    }

    private function _optionTypePostSelector( $item, $newItem ) {

	    if( $item->getParam('load-dynamic', false) ) {
		    $newItem['selectValues'] = $item->getSelectValues();
		    $newItem['params'] = $item->getParams();
		    $newItem['params']['post_type'] = $item->getParam('post_type', 'page');
		    $newItem['type'] = 'post_type_selector';

		    return $newItem;
	    }


        $postType = $item->getParam('post_type', 'page');

        $postGetter = ffContainer::getInstance()->getPostLayer()->getPostGetter();
		$posts = $postGetter->setNumberOfPosts(-1)->getPostsByType( $postType );

        $selectValues = $item->getSelectValues();
		$selectValuesNew = array();

        if( $posts == null ) {
            $posts = array();
        }

		if( $posts instanceof WP_Error ) {
			$selectValuesNew = array();
		} else {

			foreach( $posts as $onePost ) {
				$selectValuesNew[] = array('name' => $onePost->getTitle(), 'value'=> $onePost->getId() );
			}
		}

		if( empty( $selectValues ) ) {
			$selectValues = array();
		}

        $selectValues = array_merge( $selectValues, $selectValuesNew );

        $item->addParam('class', 'ff-post-select');

        $newItem['selectValues'] = $selectValues;
        $newItem['params'] = $item->getParams();
        $newItem['type'] = 'select2';


        return $newItem;


    }

    private function _optionPostTypeRevoSlider( $item, $newItem ) {
//         $item->addParam('class', 'ff-revolution-slider-selector');

//        $newItem['selectValues'] = $selectValues;
//        $newItem['params'] = $item->getParams();
//        $newItem['type'] = 'select';
//
//        return $newItem;
    }

    private function _optionsPostTypeDatePicker( $item, $newItem ) {
        $item->addParam('class', 'ff-datepicker');

        $newItem['params'] = $item->getParams();
        $newItem['type'] = 'text';

        return $newItem;
    }


	/**
	 * @param $item ffOneOption
	 * @param $newItem
	 */
	protected function _optionTypeTextareaStrict( $item, $newItem ) {
		$item->setType( ffOneOption::TYPE_TEXTAREA);
		$item->addParam('can-be-richtext', false);
	}
    /**
     * @param ffOneOption $item
     */
    protected function _oneOption( $item ) {

        $this->_dataBoxGenerator->addPrintedComponent( $item->getType() );



	    switch ( $item->getType() ) {
		    case ffOneOption::TYPE_OPTIONS_COLLECTION:
			    $this->_optionTypeOptionsCollection( $item, array() );
//				die();
			    break;

		    case ffOneOption::TYPE_TEXTAREA_STRICT:
			    $this->_optionTypeTextareaStrict( $item, array() );
			    break;

		    case ffOneOption::TYPE_FONT:

			    $item->addParam('font-ajax-url', ffContainer::getInstance()->getWPLayer()->getAssetsSourceHolder()->getGoogleFontsAjax());
			    break;
	    }


	    $newItem = $this->_getNewItem( $item );
//	    die();



        $newItem['title'] = $item->getTitle();
        $newItem['defaultValue'] = $item->getDefaultValue();
        $newItem['description'] = $item->getDescription();
        $newItem['selectValues'] = $item->getSelectValues();
        $newItem['params'] = $item->getParams();
        $newItem['value'] = $item->getValue();

	    unset( $newItem['childs'] );
	    if( empty( $newItem['params']) ) {
		    unset( $newItem['params'] );
	    }

        $newItem['overall_type'] = 'option';

        switch( $item->getType() ) {
            case ffOneOption::TYPE_TAXONOMY:
                    $newItem = $this->_optionTypeTaxonomy( $item, $newItem );
                break;

            case ffOneOption::TYPE_POST_SELECTOR:
                $newItem = $this->_optionTypePostSelector( $item, $newItem );
                break;
            case ffOneOption::TYPE_REVOLUTION_SLIDER:
//                $newItem = $this->_optionPostTypeRevoSlider( $item, $newItem );
                break;

            case ffOneOption::TYPE_DATEPICKER:
                $newItem = $this->_optionsPostTypeDatePicker( $item, $newItem );
                break;

            case ffOneOption::TYPE_TEXT_FULLWIDTH:
                $item->addParam('fullwidth', true);
                $newItem['params'] = $item->getParams();
                $newItem['type'] = ffOneOption::TYPE_TEXT;
                break;
        }

        $this->_dataBoxGenerator->addPrintedComponent( $item->getType() );

        $this->_dataRoute[ $this->_dataRouteDepth ]['childs'][] = &$newItem;

    }

    public function setOptionsArrayData( $optionsArrayData ) {
		$this->_savedData = $optionsArrayData;
	}

    protected function _oneElement( ffOneElement $item ) {
        $this->_dataBoxGenerator->addPrintedElement( $item->getType() );

        $newItem = $this->_getNewItem( $item );

        $newItem['overall_type'] = 'element';
        $newItem['params'] = $item->getParams();
        $newItem['title'] = $item->getTitle();

	    unset( $newItem['childs'] );
	    if( empty( $newItem['params']) ) {
		    unset( $newItem['params'] );
	    }

        $this->_dataRoute[ $this->_dataRouteDepth ]['childs'][] = &$newItem;

    }



    protected function _getNewItem( $item ) {
        $newItem['id'] = $item->getId();
        $newItem['type'] = $item->getType();
        $newItem['childs'] = array();

        return $newItem;
    }

    protected function _insertNewItem() {

    }


    protected  function _beforeContainer( $item ) {
	    if( $item->getParam('is-block') == true ) {
		    $this->_hasBlocksInside = true;
	    }

        $this->_dataRouteDepth++;

        $newItem = $this->_getNewItem( $item );

        $newItem['overall_type'] = 'section';

        $newItem['params'] = $item->getParams();

		unset( $newItem['childs'] );
	    if( empty( $newItem['params']) ) {
		    unset( $newItem['params'] );
	    }

        if( $item->getType() == null ) {
            $newItem['type'] = 'section';
        }

        if( $item->getParam('is-reference') == true ) {


        } else {

        }



        if( empty( $this->_data ) ) {
            $this->_data = &$newItem;
            $this->_dataRoute[  $this->_dataRouteDepth ] = &$newItem;
        } else {

            if( $item->getParam('is-reference') == true ) {
                $this->_referenceSections[ $item->getId() ] = &$newItem;

                $referenceSubstitute = array();
                $referenceSubstitute['type'] = 'reference';
                $referenceSubstitute['overall_type'] = 'reference';
                $referenceSubstitute['id'] = $item->getId();



                $this->_dataRoute[ $this->_dataRouteDepth -1 ]['childs'][] = $referenceSubstitute;
            } else {
                $this->_dataRoute[ $this->_dataRouteDepth -1 ]['childs'][] = &$newItem;
            }


            $this->_dataRoute[ $this->_dataRouteDepth ] = &$newItem;
        }

//        var_dump( $this->_data );

    }

	public function hasBlockInside() {
		return $this->_hasBlocksInside;
	}

    protected function _afterContainer( $item ) {
        unset( $this->_dataRoute[ $this->_dataRouteDepth ] );
        $this->_dataRouteDepth--;
    }


    public function walk() {
        $this->_walk();
        return $this->_data;
    }




}