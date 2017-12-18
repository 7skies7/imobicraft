<?php
/**
 * @link http://demo.freshface.net/html/h-ark/HTML/portfolio_single_video_youtube.html#scrollTo__1382
 * @link http://demo.freshface.net/html/h-ark/HTML/portfolio_single_video_vimeo.html#scrollTo__1382
 * @link http://demo.freshface.net/html/h-ark/HTML/portfolio_single_slider.html#scrollTo__1438
 * @link http://demo.freshface.net/html/h-ark/HTML/portfolio_load_more_infinite_scrolling.html#scrollTo__382
 * */

class ffElGallery extends ffThemeBuilderElementBasic {
    protected function _initData(){
        $this->_setData(ffThemeBuilderElement::DATA_ID, 'gallery');
        $this->_setData(ffThemeBuilderElement::DATA_NAME, esc_attr( __('Gallery', 'ark' ) ) );
        $this->_setData(ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
        $this->_setData(ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, true);
        $this->_setData( ffThemeBuilderElement::DATA_CAN_BE_CACHED, false);

        $this->_setData(ffThemeBuilderElement::DATA_PICKER_MENU_ID, 'portfolio');
        $this->_setData(ffThemeBuilderElement::DATA_PICKER_TAGS, 'gallery, portfolio, loop, mosaic, masonry, grid, packery, work, projects');
        $this->_setData( ffThemeBuilderElement::DATA_PICKER_ITEM_WIDTH, 2);

        $this->_addTab('Loop', array($this, '_wpLoopSettings'));
//		$this->_addTab('Pagination', array($this, '_wpPagination'));

        $this->_setColor('dark');
    }

    /**
     * @param $s ffThemeBuilderOptionsExtender
     */
    protected function _injectLightboxOptions( $s ) {

        $s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'lightbox-icon-color', '', '')
            ->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Popup Button Icon', 'ark' ) ) )
        ;

        $s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'lightbox-icon-color-hover', '', '')
            ->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Popup Button Icon Hover', 'ark' ) ) )
        ;

        $s->addElement(ffOneElement::TYPE_NEW_LINE);

        $s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'lightbox-icon-background', '', '#ffffff')
            ->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Popup Button Background', 'ark' ) ) )
        ;

        $s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'lightbox-icon-background-hover', '', '[1]')
            ->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Popup Button Background Hover', 'ark' ) ) )
        ;
    }

    protected function _getElementGeneralOptions($s) {

        $s->addElement(ffOneElement::TYPE_TABLE_START);

        $s->addElement(ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Gallery Settings', 'ark' ) ));

        $s->addOptionNL(ffOneOption::TYPE_SELECT, 'grid-variant', '', 'grid-variant-1')
            ->addSelectValue('Columns Grid', 'grid-variant-1')
//					->addSelectValue('Mosaic Grid', 'grid-variant-2')
            ->addSelectValue('Slider', 'grid-variant-3')
            ->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Gallery Design', 'ark' ) ) )
        ;

        $s->startHidingBox('grid-variant', array('grid-variant-2') );
        $s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'In Mosaic type, you should change the size of every Portfolio Post individually by editing invididual Portfolio Posts. Please see "Portfolio Category (Archive) Settings" that you can at the bottom of the editing page of any Portfolio Post.');
        $s->endHidingBox();

        $s->startHidingBox('grid-variant', array('grid-variant-3') );
        $s->addElement(ffOneElement::TYPE_NEW_LINE);

        $s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'show-nav', ark_wp_kses( __('Show arrows', 'ark' ) ), 1);
        $s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'show-pag', ark_wp_kses( __('Show navigation dots', 'ark' ) ), 1);

        $s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'enable-loop', ark_wp_kses( __('Loop slides', 'ark' ) ), 0);
        $s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'scroll-by-page', ark_wp_kses( __('Scroll by visible group and not by item', 'ark' ) ), 0);

        $s->addOption(ffOneOption::TYPE_CHECKBOX,'enable-auto',ark_wp_kses( __('Autoplay with an interval of &nbsp;', 'ark' ) ),0);
        $s->addOptionNL(ffOneOption::TYPE_TEXT,'auto-speed','',5000)
            ->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('ms', 'ark' ) ) )
        ;

        $s->startHidingBox('enable-auto', 'checked' );
        $s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'enable-pause', ark_wp_kses( __('Pause autoplay on hover', 'ark' ) ), 0);
        $s->endHidingBox();
        $s->endHidingBox();

        $s->addElement(ffOneElement::TYPE_TABLE_DATA_END);

        $s->addElement(ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Gallery Item', 'ark' ) ));

        $s->startRepVariableSection('content');

        /*----------------------------------------------------------*/
        /* TYPE FEATURED IMAGE
        /*----------------------------------------------------------*/
        $s->startRepVariationSection('featured-image', ark_wp_kses( __('Featured Image', 'ark' ) ));
        $this->_getBlock( ffThemeBlConst::FEATUREDIMG )->injectOptions( $s );
        $s->endRepVariationSection();

        /*----------------------------------------------------------*/
        /* TYPE POST CONTENT
        /*----------------------------------------------------------*/
        $s->startRepVariationSection('portfolio-content', ark_wp_kses( __('Labels', 'ark' ) ));

        $s->startRepVariableSection('content');


        /* TYPE POST TITLE */
        $s->startRepVariationSection('title', ark_wp_kses( __('Title', 'ark' ) ) );
        $s->addOptionNL( ffOneOption::TYPE_SELECT, 'feed-type', 'Type', 'title')
            ->addSelectValue('Title', 'title')
            ->addSelectValue('Caption', 'caption')
            ->addSelectValue('Alt Text', 'alt-text')
            ->addSelectValue('Description', 'description')
        ;

        $s->AddOptionNL( ffOneOption::TYPE_CHECKBOX, 'clickable', 'Clickable', 1);

        $s->endRepVariationSection();

        /* TYPE POST CONTENT */
        $s->startRepVariationSection('subtitle', ark_wp_kses( __('Subtitle', 'ark' ) ) );
        $s->addOptionNL( ffOneOption::TYPE_SELECT, 'feed-type', 'Type', 'title')
            ->addSelectValue('Title', 'title')
            ->addSelectValue('Caption', 'caption')
            ->addSelectValue('Alt Text', 'alt-text')
            ->addSelectValue('Description', 'description')
        ;

        $s->AddOptionNL( ffOneOption::TYPE_CHECKBOX, 'clickable', 'Clickable', 1);

        $s->endRepVariationSection();

        $s->endRepVariableSection();

        $s->endRepVariationSection();

        $s->endRepVariableSection();

        $s->addElement(ffOneElement::TYPE_TABLE_DATA_END);

        $s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Gallery Item Wrapper', 'ark' ) ) );

        $s->startAdvancedToggleBox('post-wrapper', 'Gallery Item Wrapper');

        $s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'This is the Gallery Item Wrapper that you can edit and style');
        $s->addOption(ffOneOption::TYPE_HIDDEN, 'blank', '', 'blank');

        $s->endAdvancedToggleBox();

        $s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

//			$this->_injectFilterablePanelOptions( $s );

        $s->addElement(ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Gallery Items', 'ark' ) ));

        $s->addOptionNL(ffOneOption::TYPE_SELECT, 'post-style', '', 'post-style-1')
            ->addSelectValue('Labels next to the Image', 'post-style-1')
            ->addSelectValue('Labels over the Image', 'post-style-2')
            ->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Gallery Item Design Variant', 'ark' ) ) )
        ;

        $s->addElement(ffOneElement::TYPE_NEW_LINE);

        $s->addOptionNL(ffOneOption::TYPE_TEXT,'post-custom-padding','','')
            ->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Gallery Item custom padding (in px)', 'ark' ) ) )
        ;

        $s->addElement(ffOneElement::TYPE_NEW_LINE);

        $s->addOptionNL(ffOneOption::TYPE_SELECT, 'portfolio-animation', '', 'bottomToTop')
            ->addSelectValue('default', 'default')
            ->addSelectValue('lazyLoading', 'lazyLoading')
            ->addSelectValue('fadeInToTop', 'fadeInToTop')
            ->addSelectValue('sequentially', 'sequentially')
            ->addSelectValue('bottomToTop', 'bottomToTop')
            ->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Gallery Item Reveal Animation Type', 'ark' ) ) )
        ;
        $s->addOptionNL(ffOneOption::TYPE_TEXT, 'display-type-speed', '', '250')
            ->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Gallery Item Reveal Animation Delay (in ms)', 'ark' ) ) )
        ;

        $s->addElement(ffOneElement::TYPE_NEW_LINE);

        $s->addOptionNL(ffOneOption::TYPE_SELECT, 'columns-xs', '', 1)
            ->addSelectNumberRange(1,6)
            ->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Number of Gallery Items in an extra small wrapper', 'ark' ) ) )
        ;
        $s->addOptionNL(ffOneOption::TYPE_SELECT, 'columns-sm', '', 2)
            ->addSelectNumberRange(1,6)
            ->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Number of Gallery Items in a small wrapper', 'ark' ) ) )
        ;
        $s->addOptionNL(ffOneOption::TYPE_SELECT, 'columns-md', '', 3)
            ->addSelectNumberRange(1,6)
            ->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Number of Gallery Items in a medium wrapper', 'ark' ) ) )
        ;
        $s->addOptionNL(ffOneOption::TYPE_SELECT, 'columns-lg', '', 3)
            ->addSelectNumberRange(1,6)
            ->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Number of Gallery Items in a large wrapper', 'ark' ) ) )
        ;

        $s->addElement(ffOneElement::TYPE_NEW_LINE);

        $s->addOptionNL(ffOneOption::TYPE_TEXT, 'horizontal-gap', '', '')
            ->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Custom horizontal gap between Gallery Items (in px)', 'ark' ) ) )
        ;

        $s->startHidingBox('grid-variant', array('grid-variant-1', 'grid-variant-2') );
        $s->addOptionNL(ffOneOption::TYPE_TEXT, 'vertical-gap', '', '')
            ->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Custom vertical gap between Gallery Items (in px)', 'ark' ) ) )
        ;
        $s->endHidingBox();

        $s->addElement(ffOneElement::TYPE_TABLE_DATA_END);

        $s->addElement(ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Popup Button', 'ark' ) ));

        $s->addOptionNL(ffOneOption::TYPE_SELECT, 'points-to', '', 'cbp-lightbox')
            ->addSelectValue( esc_attr( __('Image Lightbox', 'ark' ) ), 'cbp-lightbox')
            ->addSelectValue( esc_attr( __('Single Post / Custom URL / Lightbox', 'ark' ) ), 'single')
            ->addSelectValue( esc_attr( __('No Link (disabled)', 'ark' ) ), '')
            ->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Popup Button Links To', 'ark' ) ) )
        ;

        $s->startHidingBox('points-to', 'single' );
        $s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'You can specify Custom URL in individual Gallery Items.');
        $s->addElement( ffOneElement::TYPE_DESCRIPTION, '', 'Same with target - same window / new window / lightbox.');
        $s->endHidingBox();

        $s->addElement(ffOneElement::TYPE_NEW_LINE);

        $s->startHidingBox('points-to', array('cbp-lightbox', 'single') );

        $s->addOptionNL(ffOneOption::TYPE_SELECT, 'popup-button-variant', '', 'icon')
            ->addSelectValue('Custom Icon', 'icon')
            ->addSelectValue('Cross', 'cross')
            ->addSelectValue('Whole image is clickable', 'all')
            ->addSelectValue('None', 'none')
            ->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Popup Button Variant', 'ark' ) ) )
        ;

        $s->addElement(ffOneElement::TYPE_NEW_LINE);

        $s->startHidingBox('popup-button-variant', 'icon');
        $s->addOptionNL(ffOneOption::TYPE_ICON,'icon',ark_wp_kses( __('Popup Button Icon', 'ark' ) ), 'ff-font-et-line icon-focus');
        $s->endHidingBox();

        $s->endHidingBox();

        $s->startHidingBox('points-to', 'cbp-lightbox');

        $s->addElement(ffOneElement::TYPE_NEW_LINE);

        $s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'enable-lightbox-gallery', ark_wp_kses( __('Group all Lightbox images into a Gallery', 'ark' ) ), 1);

        $s->addOptionNL( ffOneOption::TYPE_TEXT, 'lightbox-title', '', 'Gallery')
            ->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Lightbox Title', 'ark' ) ) )
        ;

        $s->addElement(ffOneElement::TYPE_NEW_LINE);

        $s->addOptionNL( ffOneOption::TYPE_TEXTAREA, 'lightbox-counter', 'Lightbox Counter Text', '{{current}} of {{total}}');

        $s->endHidingBox();

        $s->addElement(ffOneElement::TYPE_TABLE_DATA_END);

        $s->addElement(ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Colors', 'ark' ) ));

        $s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'portfolio-content-color', '', '#ffffff')
            ->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Gallery Item Background', 'ark' ) ) );

        $s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'post-shadow', '', '#eff1f8')
            ->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Gallery Item Box Shadow', 'ark' ) ) );

        $s->addElement(ffOneElement::TYPE_NEW_LINE);

        $s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'image-hover-color', '', '[2]')
            ->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Image Hover Overlay', 'ark' ) ) );

        $s->addElement(ffOneElement::TYPE_NEW_LINE);

        $s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'portfolio-title-color', '', '')
            ->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Gallery Item Title', 'ark' ) ) );

        $s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'portfolio-title-color-hover', '', '')
            ->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Gallery Item Title Hover', 'ark' ) ) );

        $s->addElement(ffOneElement::TYPE_NEW_LINE);

        $s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'portfolio-subtitle-color', '', '')
            ->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Gallery Item Subtitle', 'ark' ) ) );

        $s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'portfolio-subtitle-color-hover', '', '')
            ->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Gallery Item Subtitle Hover', 'ark' ) ) );

        $s->addElement(ffOneElement::TYPE_NEW_LINE);

        $s->startHidingBox('points-to', array('cbp-lightbox', 'single') );

        $s->startHidingBox('popup-button-variant', 'icon');

        $s->addElement(ffOneElement::TYPE_NEW_LINE);

        $this->_injectLightboxOptions( $s );

        $s->endHidingBox();

        $s->startHidingBox('popup-button-variant', 'cross');

        $s->addElement(ffOneElement::TYPE_NEW_LINE);

        $s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'cross-icon', '', '')
            ->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Popup Button Cross Icon', 'ark' ) ) );
        $s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'cross-icon-hover', '', '')
            ->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Popup Button Cross Icon Hover', 'ark' ) ) );

        $s->endHidingBox();

        $s->endHidingBox();

        $s->startHidingBox('grid-variant', array('grid-variant-3'));

        $s->addElement(ffOneElement::TYPE_NEW_LINE);

        $s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'arrows-icon', '', '')
            ->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Slider Arrows Icon', 'ark' ) ) );
        $s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'arrows-icon-hover', '', '')
            ->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Slider Arrows Icon Hover', 'ark' ) ) );

        $s->addElement(ffOneElement::TYPE_NEW_LINE);

        $s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'arrows-background', '', '')
            ->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Slider Arrows Background', 'ark' ) ) );
        $s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'arrows-background-hover', '', '')
            ->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Slider Arrows Background Hover', 'ark' ) ) );

        $s->addElement(ffOneElement::TYPE_NEW_LINE);

        $s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'nav-dot', '', '')
            ->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Slider Navigation Dot', 'ark' ) ) );
        $s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'nav-dot-hover', '', '')
            ->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Slider Navigation Dot Hover', 'ark' ) ) );

        $s->addElement(ffOneElement::TYPE_NEW_LINE);

        $s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'nav-dot-active', '', '')
            ->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Slider Navigation Dot Active', 'ark' ) ) );
        $s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'nav-dot-active-hover', '', '')
            ->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Slider Navigation Dot Active Hover', 'ark' ) ) );

        $s->endHidingBox();

        $s->startHidingBox('grid-variant', array('grid-variant-1', 'grid-variant-2'));

        $s->startHidingBox('show-filter-panel', 'checked');

        $s->addElement(ffOneElement::TYPE_NEW_LINE);

        $s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'filter-text', '', '')
            ->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Filter Text', 'ark' ) ) );

        $s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'filter-text-hover', '', '')
            ->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Filter Text Hover', 'ark' ) ) );

        $s->addElement(ffOneElement::TYPE_NEW_LINE);

        $s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'filter-active', '', '')
            ->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Filter Active Text', 'ark' ) ) );

        $s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'filter-active-hover', '', '')
            ->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Filter Active Text Hover', 'ark' ) ) );

        $s->startHidingBox('filters-pos', 'top');

        $s->addElement(ffOneElement::TYPE_NEW_LINE);

        $s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'filter-active-border', '', '[1]')
            ->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Filter Active Border', 'ark' ) ) );

        $s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'filter-active-border-hover', '', '[1]')
            ->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Filter Active Border Hover', 'ark' ) ) );

        $s->addElement(ffOneElement::TYPE_NEW_LINE);

        $s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'filter-tooltip-text', '', '#ffffff')
            ->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Filter Counter Text', 'ark' ) ) );

        $s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'filter-tooltip-background', '', '[1]')
            ->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses( __('Filter Counter Background', 'ark' ) ) );

        $s->endHidingBox();

        $s->endHidingBox();

        $s->endHidingBox();

        $s->addElement(ffOneElement::TYPE_TABLE_DATA_END);

        $s->addElement(ffOneElement::TYPE_TABLE_END);


    }


    protected function _wpPagination( $s ) {
//		$this->_getBlock( ffThemeBlConst::PAGINATION )->injectOptions( $s );
    }


    /**
     * @param $s ffThemeBuilderOptionsExtender
     */
    protected function _wpLoopSettings($s) {

        $s->addElement(ffOneElement::TYPE_TABLE_START);

        $s->addElement(ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Image Gallery', 'ark' ) ));

        $s->addOption( ffOneOption::TYPE_IMAGE_GALLERY, 'images', 'Image Gallery', '');

        $s->addElement(ffOneElement::TYPE_TABLE_DATA_END);

        $s->addElement(ffOneElement::TYPE_TABLE_END);
//		$this->_getWpLoop()->injectOptions($s);
    }


    /**
     * @param $query ffOptionsQuery
     */
    protected function _enqueueScriptsAndStyles( $query ) {
//		$query->debug_dump();
        if ( 'grid-variant-3' == $query->get('o gen grid-variant') ){
            $ffPortTypeClass = 'ff-portfolio-slider theme-portfolio-nav-v2';
            wp_enqueue_script( 'ark-portfolio-slider' );
        } else {
            $ffPortTypeClass = 'ff-portfolio-columns-js';
            wp_enqueue_script( 'ark-portfolio' );
        }
    }


    protected function _render(ffOptionsQueryDynamic $query, $content, $data, $uniqueId) {
        $galleryImages = $query->getGallery('images');

//		var_dump( $images );


//		echo 'gallery start ty kurvo';
//		return;

        if( !$query->exists('content') ){
            return;
        }



        $this->_printLightboxImageColors( $query );



        $filterOrder = '';//$this->_getOrderInSlugs( $query->get('filter filter-order') );

        /**
         * @var $wpQuery WP_Query
         */
//		$loopBlock = $this->_getWpLoop();
//		$wpQuery = $loopBlock->get($query);

        $featuredImageDefaultWidth = $this->_getImageDefaultWidthInColumns( $query->get('columns-lg') );

        if ( 'grid-variant-1' == $query->get('grid-variant') ){
            $settings['portfolio-type'] = 'grid';
        } else if ( 'grid-variant-2' == $query->get('grid-variant') ) {
            $settings['portfolio-type'] = 'mosaic';
        }



        $settings['columns-lg'] = $query->getWpKses('columns-lg');
        $settings['columns-md'] = $query->getWpKses('columns-md');
        $settings['columns-sm'] = $query->getWpKses('columns-sm');
        $settings['columns-xs'] = $query->getWpKses('columns-xs');

        if( '' == $query->getWpKses('vertical-gap') ){
            $settings['vertical-gap'] = 30;
        } else {
            $settings['vertical-gap'] = $query->getWpKses('vertical-gap');
        }

        if( '' == $query->getWpKses('horizontal-gap') ){
            $settings['horizontal-gap'] = 30;
        } else {
            $settings['horizontal-gap'] = $query->getWpKses('horizontal-gap');
        }

//		if($query->get('filter default-filter') && '*' != $query->get('filter default-filter') ) {
//			$settings['default-filter'] = '.'.$this->_getSlugByTitle( $query->get('filter default-filter') );
//		}else{
        $settings['default-filter'] = '*';
//		}

        $settings['lightbox-counter'] = $query->getWpKses('lightbox-counter');

        $settings['points-to'] = $query->getWpKses('points-to');
        $settings['portfolio-animation'] = $query->getWpKses('portfolio-animation');

        $settings['display-type-speed'] = $query->getWpKses('display-type-speed');

//		$settings['filter-animation'] = $query->getWpKses('filter filter-animation');
        if($query->get('enable-lightbox-gallery')) {
            $settings['lightbox-gallery'] = true;
        }else{
            $settings['lightbox-gallery'] = false;
        }

        if ( 'grid-variant-3' == $query->get('grid-variant') ){
            if($query->get('show-nav')) {
                $settings['show-nav'] = true;
            }else{
                $settings['show-nav'] = false;
            }

            if($query->get('show-pag')) {
                $settings['show-pag'] = true;
            }else{
                $settings['show-pag'] = false;
            }

            if($query->get('enable-auto')) {
                $settings['enable-auto'] = true;
                $settings['speed-auto'] = $query->get('auto-speed');
            }else{
                $settings['enable-auto'] = false;
            }

            if($query->get('enable-loop')) {
                $settings['enable-loop'] = true;
            }else{
                $settings['enable-loop'] = false;
            }

            $settings['enable-drag'] = true;

            if($query->get('enable-pause')) {
                $settings['enable-pause'] = true;
            }else{
                $settings['enable-pause'] = false;
            }

            if($query->get('scroll-by-page')) {
                $settings['scroll-by-page'] = true;
            }else{
                $settings['scroll-by-page'] = false;
            }

        }

        $settingsJson = json_encode($settings);

        $ffPortTypeClass = 'ff-portfolio';
        if ( 'grid-variant-3' == $query->get('grid-variant') ){
            $ffPortTypeClass = 'ff-portfolio-slider theme-portfolio-nav-v2';
            wp_enqueue_script( 'ark-portfolio-slider' );
        } else {
            $ffPortTypeClass = 'ff-portfolio-columns-js';
            wp_enqueue_script( 'ark-portfolio' );
        }

        echo '<section class="'.$ffPortTypeClass.' theme-portfolio portfolio-classic-1 ff-gallery-based-on-portfolio" data-settings="'.esc_attr($settingsJson).'">';

        echo '<div class="row">';

        echo '<div class="col-xs-12">';


        echo '<div class="ff-portfolio-grid-wrapper">';
        echo '<div class="ff-portfolio-grid cbp">';
        if ( !empty( $galleryImages ) ) {
            foreach( $galleryImages as $oneImage ) {

                $oneImage = new ffDataHolder( $oneImage );

                $postID = $oneImage->id;

                $themePortVar = '';
                if ( 'post-style-1' == $query->get('post-style') ) 	{
                    $themePortVar = 'theme-portfolio-item-v2';
                } else if ( 'post-style-2' == $query->get('post-style') ){
                    $themePortVar = 'theme-portfolio-item-v3';
                }

                $this->_advancedToggleBoxStart( $query, 'post-wrapper' );
                echo '<div class="cbp-item '.$themePortVar.' ">';
                if( $query->exists('content') ) {
                    foreach ($query->get('content') as $postItem) {
                        switch ($postItem->getVariationType()) {


                            case 'featured-image':
                                echo '<div class="cbp-caption">';
                                echo '<div class="cbp-caption-defaultWrap theme-portfolio-active-wrap">';

                                $maxColWidth = $query->get('columns-lg');
                                $gridWidth = 1440;

                                $imgWidth = 0;
                                $imgHeight = 0;

                                if( $query->get('popup-button-variant') == 'all' ) {
                                    $this->_generateGalleryLinkStart($query, $oneImage->url, false);
                                }

                                if( empty($imgWidth) ){
                                    $this->_getBlock(ffThemeBlConst::FEATUREDIMG)
                                        ->setParam( ffBlFeaturedImage::PARAM_IMAGE_ID, $postID)
                                        ->setParam('width', $featuredImageDefaultWidth)
                                        ->render($postItem);
                                }else if( empty($imgHeight) ){
                                    $this->_getBlock(ffThemeBlConst::FEATUREDIMG)
                                        ->setParam( ffBlFeaturedImage::PARAM_IMAGE_ID, $postID)
                                        ->setParam( ffBlFeaturedImage::PARAM_FORCE_WIDTH, $imgWidth )
                                        ->render($postItem);
                                }else{
                                    $this->_getBlock(ffThemeBlConst::FEATUREDIMG)
                                        ->setParam( ffBlFeaturedImage::PARAM_IMAGE_ID, $postID)
                                        ->setParam( ffBlFeaturedImage::PARAM_FORCE_HEIGHT, $imgHeight )
                                        ->setParam( ffBlFeaturedImage::PARAM_FORCE_WIDTH, $imgWidth )
                                        ->render($postItem);
                                }

                                if( $query->get('popup-button-variant') == 'all' ) {
//									echo '</a>';
                                    $this->_generateGalleryLinkEnd();
                                }


                                if( '' != $query->get('points-to') ) {
                                    echo '<div class="theme-icons-wrap theme-portfolio-lightbox">';
                                    $this->_generateGalleryLinkStart($query, $oneImage->url, true );
                                    $this->_generateGalleryLinkEnd();

                                    echo '</div>';
                                }
                                echo '</div>';
                                echo '</div>';

                                break;

                            case 'portfolio-content':
                                if( $postItem->exists('content') ) {

                                    $themePortHeadingVar = '';
                                    if ( 'post-style-1' == $query->get('post-style') ) 	{
                                        $themePortHeadingVar = '';
                                    } else if ( 'post-style-2' == $query->get('post-style') ){
                                        $themePortHeadingVar = 'theme-portfolio-item-v3-heading text-left';
                                    }

                                    $themePortTitleVar = '';
                                    if ( 'post-style-1' == $query->get('post-style') ) 	{
                                        $themePortTitleVar = '';
                                    } else if ( 'post-style-2' == $query->get('post-style') ){
                                        $themePortTitleVar = 'theme-portfolio-item-v3-title';
                                    }

                                    $themePortSubtitleVar = '';
                                    if ( 'post-style-1' == $query->get('post-style') ) 	{
                                        $themePortSubtitleVar = '';
                                    } else if ( 'post-style-2' == $query->get('post-style') ){
                                        $themePortSubtitleVar = 'theme-portfolio-item-v3-subtitle';
                                    }

                                    echo '<div class="theme-portfolio-title-heading '.$themePortHeadingVar.' ">';
                                    foreach( $postItem->get('content') as $oneContent ) {
                                        switch ($oneContent->getVariationType()) {

                                            case 'title':
                                                echo '<h4 class="theme-portfolio-title '.$themePortTitleVar.'">';


                                                $feedType = $oneContent->get('feed-type');
                                                $data = $this->_getImageData( $feedType, $oneImage->id );

                                                if( $oneContent->get('clickable') ) {
                                                    $this->_generateGalleryLinkStart( $query, $oneImage->url, false);
                                                }

                                                echo ark_wp_kses( $data );

                                                if( $oneContent->get('clickable') ) {
                                                    $this->_generateGalleryLinkEnd();
                                                }

                                                echo '</h4>';
                                                break;

                                            case 'subtitle':

                                                $feedType = $oneContent->get('feed-type');
                                                $data = $this->_getImageData( $feedType, $oneImage->id );

                                                if( empty( $data ) ) {
                                                    continue;
                                                }

                                                if( $oneContent->get('clickable') ) {
                                                    $this->_generateGalleryLinkStart( $query, $oneImage->url, false);
                                                }
                                                echo '<span class="theme-portfolio-subtitle '.$themePortSubtitleVar.'">'.$data.'</span>';

                                                if( $oneContent->get('clickable') ) {
                                                    $this->_generateGalleryLinkEnd();
                                                }
                                                break;
                                        }
                                    }
                                    echo '</div>';
                                }
                                break;
                        }
                    }
                }
                echo '</div>';
                $this->_advancedToggleBoxEnd( $query, 'post-wrapper' );
            }
        }
        echo '</div>';
        echo '</div>';

        echo '</div>'; // end main col
        echo '</div>'; // end row

//		$paginationBlock = $this->_getBlock( ffThemeBlConst::PAGINATION )->setParam(ffBlPagination::PARAM_POST_GRID_UNIQUE_ID, $uniqueId)->setWpQuery( $wpQuery );

//		if( $paginationBlock->showPagination( $query ) ) {
//			echo '<div class="portfolio-pagination row">';
//			echo '<div class="col-xs-12">';
//			$paginationBlock->render($query);
//			echo '</div>';
//			echo '</div>';
//		}
        echo '</section>';

        $assetsRenderer = $this->getAssetsRenderer();
        /* PORTFOLIO POST CUSTOM PADDING */

        if( $query->get('post-custom-padding') ) {
            $assetsRenderer->createCssRule()
                ->setAddWhiteSpaceBetweenSelectors(false)
                ->addSelector(' .cbp-item .cbp-item-wrapper', false)
                ->addParamsString('padding: '.$query->get('post-custom-padding').'px;');
        }

        /* COLORS */

        if( $query->getColor('portfolio-content-color') ) {
            $assetsRenderer->createCssRule()
                ->setAddWhiteSpaceBetweenSelectors(false)
                ->addSelector(' .cbp-item .cbp-item-wrapper', false)
                ->addParamsString('background-color: '.$query->getColor('portfolio-content-color').';');
        }

        if( $query->getColor('post-shadow') ) {
            $assetsRenderer->createCssRule()
                ->setAddWhiteSpaceBetweenSelectors(false)
                ->addSelector(' .cbp-item .cbp-item-wrapper', false)
                ->addParamsString('box-shadow: 0 2px 5px 3px '.$query->getColor('post-shadow').';');
        }


        if( $query->getColor('image-hover-color') ) {
            $assetsRenderer->createCssRule()
                ->setAddWhiteSpaceBetweenSelectors(false)
                ->addSelector(' .cbp-item:hover .theme-portfolio-active-wrap:before', false)
                ->addParamsString('background-color: '.$query->getColor('image-hover-color').';');
        }


        if( $query->getColor('portfolio-title-color') ) {
            $assetsRenderer->createCssRule()
                ->setAddWhiteSpaceBetweenSelectors(false)
                ->addSelector(' .theme-portfolio-title', false)
                ->addParamsString('color: '.$query->getColor('portfolio-title-color').';');
        }

        if( $query->getColor('portfolio-title-color') ) {
            $assetsRenderer->createCssRule()
                ->setAddWhiteSpaceBetweenSelectors(false)
                ->addSelector(' .theme-portfolio-title a:not(:hover)', false)
                ->addParamsString('color: '.$query->getColor('portfolio-title-color').';');
        }

        if( $query->getColor('portfolio-title-color-hover') ) {
            $assetsRenderer->createCssRule()
                ->setAddWhiteSpaceBetweenSelectors(false)
                ->addSelector(' .theme-portfolio-title:hover', false)
                ->addParamsString('color: '.$query->getColor('portfolio-title-color-hover').';');
        }


        if( $query->getColor('portfolio-subtitle-color') ) {
            $assetsRenderer->createCssRule()
                ->setAddWhiteSpaceBetweenSelectors(false)
                ->addSelector(' .theme-portfolio-subtitle', false)
                ->addParamsString('color: '.$query->getColor('portfolio-subtitle-color').' !important;');
        }


        if( $query->getColor('portfolio-subtitle-color-hover') ) {
            $assetsRenderer->createCssRule()
                ->setAddWhiteSpaceBetweenSelectors(false)
                ->addSelector(' .theme-portfolio-subtitle:hover', false)
                ->addParamsString('color: '.$query->getColor('portfolio-subtitle-color-hover').' !important;');
        }


        if( $query->getColor('cross-icon') ) {
            $assetsRenderer->createCssRule()
                ->setAddWhiteSpaceBetweenSelectors(false)
                ->addSelector(' .cbp-item .cbp-item-wrapper .theme-portfolio-item-v3-icon:before', false)
                ->addParamsString('background-color: '.$query->getColor('cross-icon').';');
        }

        if( $query->getColor('cross-icon') ) {
            $assetsRenderer->createCssRule()
                ->setAddWhiteSpaceBetweenSelectors(false)
                ->addSelector(' .cbp-item .cbp-item-wrapper .theme-portfolio-item-v3-icon:after', false)
                ->addParamsString('background-color: '.$query->getColor('cross-icon').';');
        }

        if( $query->getColor('cross-icon-hover') ) {
            $assetsRenderer->createCssRule()
                ->setAddWhiteSpaceBetweenSelectors(false)
                ->addSelector(' .cbp-item .cbp-item-wrapper .theme-portfolio-item-v3-icon:hover:before', false)
                ->addParamsString('background-color: '.$query->getColor('cross-icon-hover').';');
        }

        if( $query->getColor('cross-icon-hover') ) {
            $assetsRenderer->createCssRule()
                ->setAddWhiteSpaceBetweenSelectors(false)
                ->addSelector(' .cbp-item .cbp-item-wrapper .theme-portfolio-item-v3-icon:hover:after', false)
                ->addParamsString('background-color: '.$query->getColor('cross-icon-hover').';');
        }




        if( $query->getColor('arrows-icon') ) {
            $assetsRenderer->createCssRule()
                ->setAddWhiteSpaceBetweenSelectors(false)
                ->addSelector(' .ff-portfolio-grid .cbp-nav .cbp-nav-controls .cbp-nav-prev:after', false)
                ->addParamsString('color: '.$query->getColor('arrows-icon').';');
        }

        if( $query->getColor('arrows-icon') ) {
            $assetsRenderer->createCssRule()
                ->setAddWhiteSpaceBetweenSelectors(false)
                ->addSelector(' .ff-portfolio-grid .cbp-nav .cbp-nav-controls .cbp-nav-next:after', false)
                ->addParamsString('color: '.$query->getColor('arrows-icon').';');
        }

        if( $query->getColor('arrows-icon-hover') ) {
            $assetsRenderer->createCssRule()
                ->setAddWhiteSpaceBetweenSelectors(false)
                ->addSelector(' .ff-portfolio-grid .cbp-nav .cbp-nav-controls .cbp-nav-prev:hover:after', false)
                ->addParamsString('color: '.$query->getColor('arrows-icon-hover').';');
        }

        if( $query->getColor('arrows-icon-hover') ) {
            $assetsRenderer->createCssRule()
                ->setAddWhiteSpaceBetweenSelectors(false)
                ->addSelector(' .ff-portfolio-grid .cbp-nav .cbp-nav-controls .cbp-nav-next:hover:after', false)
                ->addParamsString('color: '.$query->getColor('arrows-icon-hover').';');
        }

        if( $query->getColor('arrows-background') ) {
            $assetsRenderer->createCssRule()
                ->setAddWhiteSpaceBetweenSelectors(false)
                ->addSelector(' .ff-portfolio-grid .cbp-nav .cbp-nav-controls .cbp-nav-prev:after', false)
                ->addParamsString('background-color: '.$query->getColor('arrows-background').';');
        }

        if( $query->getColor('arrows-background') ) {
            $assetsRenderer->createCssRule()
                ->setAddWhiteSpaceBetweenSelectors(false)
                ->addSelector(' .ff-portfolio-grid .cbp-nav .cbp-nav-controls .cbp-nav-next:after', false)
                ->addParamsString('background-color: '.$query->getColor('arrows-background').';');
        }

        if( $query->getColor('arrows-background-hover') ) {
            $assetsRenderer->createCssRule()
                ->setAddWhiteSpaceBetweenSelectors(false)
                ->addSelector(' .ff-portfolio-grid .cbp-nav .cbp-nav-controls .cbp-nav-prev:hover:after', false)
                ->addParamsString('background-color: '.$query->getColor('arrows-background-hover').';');
        }

        if( $query->getColor('arrows-background-hover') ) {
            $assetsRenderer->createCssRule()
                ->setAddWhiteSpaceBetweenSelectors(false)
                ->addSelector(' .ff-portfolio-grid .cbp-nav .cbp-nav-controls .cbp-nav-next:hover:after', false)
                ->addParamsString('background-color: '.$query->getColor('arrows-background-hover').';');
        }


        if( $query->getColor('nav-dot') ) {
            $assetsRenderer->createCssRule()
                ->setAddWhiteSpaceBetweenSelectors(false)
                ->addSelector(' .ff-portfolio-grid .cbp-nav .cbp-nav-pagination .cbp-nav-pagination-item', false)
                ->addParamsString('background-color: '.$query->getColor('nav-dot').';');
        }

        if( $query->getColor('nav-dot-hover') ) {
            $assetsRenderer->createCssRule()
                ->setAddWhiteSpaceBetweenSelectors(false)
                ->addSelector(' .ff-portfolio-grid .cbp-nav .cbp-nav-pagination .cbp-nav-pagination-item:hover', false)
                ->addParamsString('background-color: '.$query->getColor('nav-dot-hover').';');
        }

        if( $query->getColor('nav-dot-active') ) {
            $assetsRenderer->createCssRule()
                ->setAddWhiteSpaceBetweenSelectors(false)
                ->addSelector(' .ff-portfolio-grid .cbp-nav .cbp-nav-pagination .cbp-nav-pagination-item.cbp-nav-pagination-active', false)
                ->addParamsString('background-color: '.$query->getColor('nav-dot-active').';');
        }

        if( $query->getColor('nav-dot-active-hover') ) {
            $assetsRenderer->createCssRule()
                ->setAddWhiteSpaceBetweenSelectors(false)
                ->addSelector(' .ff-portfolio-grid .cbp-nav .cbp-nav-pagination .cbp-nav-pagination-item.cbp-nav-pagination-active:hover', false)
                ->addParamsString('background-color: '.$query->getColor('nav-dot-active-hover').';');
        }

//		$loopBlock->resetOnTheEnd();


    }

    /**
     * @param $query ffOptionsQueryDynamic
     * @param $destinationUrl
     */
    private function _generateGalleryLinkStart( $query, $destinationUrl, $printIcons = true ) {
        echo '<a';
        echo ' href="' . esc_url( $destinationUrl ) . '"';
        if( 'single' == $query->get('points-to' )){
            echo ' target="_blank"';
        }
        echo ' class="';
        echo $query->get('points-to') . '"';
        echo ' data-title="' . esc_attr( $query->get('lightbox-title') ) . '"';
        echo '>';
        if( $printIcons ) {
            if ( 'icon' == $query->get('popup-button-variant') ) 	{
                echo '<i class="ff-lightbox-icon theme-icons theme-icons-white-bg theme-icons-md radius-3 ' . esc_attr( $query->get('icon') ) . '"></i>';
            } else if ( 'cross' == $query->get('popup-button-variant') ){
                echo '<i class="theme-portfolio-item-v3-icon"></i>';
            }
        }
    }

    private function _generateGalleryLinkEnd() {
        echo '</a>';
    }

    private function _getImageData( $type, $imageId) {
        $WPLayer = $this->_getWPLayer();

        $metaData = $WPLayer->getAttachmentMetaData( $imageId );

        $toReturn = '';
        switch( $type ) {
            case 'title':
                $toReturn = $metaData->title;
                break;
            case 'caption':
                $toReturn = $metaData->caption;
                break;
            case 'alt-text':
                $toReturn = $metaData->alt;
                break;
            case 'description':
                $toReturn = $metaData->description;
                break;
        }

        return $toReturn;
    }


    protected function _renderContentInfo_JS() {
        ?>
        <script data-type="ffscript">
            function ( query, options, $elementPreview, $element, blocks, preview ) {

                query.get('content').each(function(query, variationType ){
                    switch(variationType){
                        case 'featured-image':
                            query.addPlainText( 'Featured Image' );
                            query.addBreak();
                            break;

                        case 'portfolio-content':

                            if( query.get('content') != null ) {
                                query.get('content').each(function (query, variationType) {
                                    switch (variationType) {
                                        case 'title':
                                            query.addPlainText('Portfolio Title');
                                            query.addBreak();
                                            break;
                                        case 'subtitle':
                                            query.addPlainText('Portfolio Subtitle');
                                            query.addBreak();
                                            break;
                                    }
                                });
                            }

                            break;
                    }

                });

            }
        </script data-type="ffscript">
        <?php
    }

    /**
     * @param $query ffOptionsQueryDynamic
     */
    protected function _printLightboxImageColors( $query ) {

        $lightboxIconColor = $query->getColor('lightbox-icon-color');
        $lightboxIconBackground = $query->getColor('lightbox-icon-background');
        $lightboxIconColorHover = $query->getColor('lightbox-icon-color-hover');
        $lightboxIconBackgroundHover = $query->getColor('lightbox-icon-background-hover');

        $ar = $this->_getAssetsRenderer();

        if( $lightboxIconColor ) {
            $ar->createCssRule()
                ->addSelector('.ff-lightbox-icon')
                ->addParamsString('color: ' . $lightboxIconColor . ' !important;');
        }

        if( $lightboxIconBackground ) {
            $ar->createCssRule()
                ->addSelector('.ff-lightbox-icon')
                ->addParamsString('background-color: ' . $lightboxIconBackground . ' !important;');
        }


        if( $lightboxIconColorHover ) {
            $ar->createCssRule()
                ->addSelector('.ff-lightbox-icon:hover')
                ->addParamsString('color: ' . $lightboxIconColorHover . ' !important;');
        }

        if( $lightboxIconBackgroundHover ) {
            $ar->createCssRule()
                ->addSelector('.ff-lightbox-icon:hover')
                ->addParamsString('background-color: ' . $lightboxIconBackgroundHover . ' !important;');
        }

    }

    protected function _getImageDefaultWidthInColumns( $numberOfColumns ) {

        switch( $numberOfColumns ) {
            case 1:
                $width = 1440;
                break;
            case 2:
                $width = 768;
                break;
            case 3:
                $width = 768;
                break;
            default:
                $width = 768;
                break;
        }

        return $width;
    }



}