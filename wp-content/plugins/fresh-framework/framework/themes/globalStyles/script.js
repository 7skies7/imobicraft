/*


 - co potrebuji pri tisknuti
 - jenom groupy - zkompilovane styly dosebe

 - co potrebuji pri administraci
 - styly
 - styl ma jmeno
 - kazdy styl ma jednu kategorii
 - kazdy styl muze byt v neomezene skupinach

 - styl categories
 - jmeno
 - id?
 - barvu
 - mozna dalsi veci?

 - style groups
 - jmeno
 - id
 - barvu
 - assigned styles ID
 - final style (compiled from the assigned things)
 - final style hash





- ukladani veci:

A styles_and_categories

item
    - id (unikatni vygenerovane ID)
    - type (style/cat)
    -- cat
        - name
        - id (preddefinovane)
        - barva
        // nechat options pro dalsi veci

    -- style
        - name
        - is active?
        - id
        - category (idecko)
        // nechat moznost davat dalsi options






 */

(function($){

    frslib.provide('frslib.globalStyles');

    frslib.globalStyles.app = {
        /**
         * Modal window
         */
        $el : null,

        $canvas: null,

        $canvasStyles: null,

        $currentOptions: null,

        $currentOpenedItem: null,

        _optionsManager: null,

/**********************************************************************************************************************/
/* INIT
/**********************************************************************************************************************/
        init: function(){
            this._canvas_init();
            this._modal_init();
            this._optionsManager_init();

        },

/**********************************************************************************************************************/
/* MODAL
/**********************************************************************************************************************/
        _optionsManager_init: function() {
            var dataString = $('.ff-gs-structure').html();
            var structure = JSON.parse( dataString );
            this._optionsManager = new frslib.options2.managerModal();

            this._optionsManager.setStructure( structure );
        },

        _modal_init: function() {
            var modalHtml = new window.ffbuilder.Modal({ getOnlyModalHTML: true })._generateElementHtml();
            this.$el = $(modalHtml);
            this.$el.addClass('ffb-modal__global-styles');
            this.$el.find('.ffb-modal__name span').html('Global Style');
            $('body').append( this.$el );

            this._modal_actSave();
            this._modal_actQuickSave();
            this._modal_actClose();
        },

        _modal_render: function( data ) {
            this._optionsManager_init();
            this._optionsManager.setData( data );
            this._modal_setOptions( this._optionsManager.render() );
            this._modal_show();
        },

        _modal_setOptions: function( $options ) {
            this.$currentOptions = $options;
            this.$el.find('.ffb-modal__body').html( $options );
        },

        _modal_show: function() {
            this.$el.css('display', 'block');
        },

        _modal_hide: function() {
            this.$el.find('.ffb-modal__body').html('');
            this.$el.css('display', 'none');
        },


        _modal_actSave: function(){
            var self = this;
            this.$el.find('.ffb-modal__action-save').click(function(e){
                self._modal_writeToCanvas();
                self._modal_hide();
            });
        },

        _modal_writeToCanvas: function() {
            var form = this._optionsManager.parseForm();
            var formJSON = JSON.stringify(form);
            this.$currentOpenedItem.attr('data-gs-style', formJSON);
            var query = new frslib.options2.query();
            query.setData( form );
            var name = query.get('o gen name');


            var id = this.$currentOpenedItem.attr('data-gs-id');
            $('.ff-gs-style-' + id).find('.ff-gs-style-name-label').html( name );
        },

        _modal_actQuickSave: function() {
            var self = this;
            $('.ffb-modal__action-save-all, .ff-save-ajax').click(function(){
                if( !$(this).hasClass('ff-save-ajax') ) {
                    self._modal_writeToCanvas();
                }

                self._canvas_saveCanvas(function(){
                    console.log( 'ulozeno');
                });
            });
        },

        _modal_actClose: function() {
            var self = this;
            this.$el.find('.ffb-modal__action-cancel').click(function(e){
                if(e.target != this) return;
                var optionsManager = self._optionsManager;

                if( optionsManager.hasFormBeenChanged() ) {
                    var modal = new frslib.options2.modal();
                    modal.printConfirmBox('Are you sure you want to close the window? Unsaved changes will be lost.', function( result ){
                        if( result == true ) {
                            self._modal_hide();
                        }
                    });
                } else {
                    self._modal_hide();
                }

            });
        },



/**********************************************************************************************************************/
/* CANVAS
/**********************************************************************************************************************/

        _canvas_fillStyleCat: function() {
            //this.$canvasStyles = $('.ff-gs-styles-canvas');
            var self = this;
            this.$canvasStyles.find('.ff-gs-style-cat').each(function(){
                var catName = $(this).attr('data-gs-cat-name');



                $(this).find('.ff-gs-style').each(function(){
                    $(this).find('.ff-gs-style-cat-label').html( catName )

                    var id = $(this).attr('data-gs-id');
                    self.$canvasGroup.find('.ff-gs-style-'+id).find('.ff-gs-style-cat-label').html(catName);
                    //ff-gs-style

               });
            });
        },


        _canvas_init: function() {
            if( ff_fw_video_recording == true ) {
                $('html').addClass('ffbvr');

            }

            var self = this;

            this.$canvas = $('.ff-gs-canvas-wrapper');
            this.$canvasStyles = $('.ff-gs-styles-canvas');
            this.$canvasGroup = $('.ff-gs-groups-canvas');
            this._canvas_printCanvas();
            //this._canvas_actItemClick( this.$canvas.find('.ff-gs-item'));

            // adding new style action
            /*----------------------------------------------------------*/
            /* ADD STYLE
            /*----------------------------------------------------------*/
            this.$canvasStyles.on('click', '.ff-gs-cat-header__action--add-style', function(){

                var $styleCat = $(this).parents('.ff-gs-style-cat');
                var $styleCatList = $styleCat.find('.ff-gs-style-cat-list');

                var id = 'gs-' + frslib.identificators.generateUnique();

                var $newStyleHTML = self._canvas_getStyleHTML( id, 'Style');

                //$newStyleHTML.find('.ff-gs-style-cat-label').html( catName )

                $newStyleHTML.hide();

                $styleCatList.append( $newStyleHTML );
                $newStyleHTML.addClass('ff-gs-cat-' + $styleCat.attr('data-gs-cat-id'));
                $newStyleHTML.animate({height:'toggle', opacity: 'toggle'}, 200);

                self._canvas_wasChanged();
            });

            /*----------------------------------------------------------*/
            /* CAT CONTEXT MENU
            /*----------------------------------------------------------*/
            this.$canvasStyles.on('click', '.ff-gs-action-cat-header-tool', function(){
                //alert('click');
                var $catParent = $(this).parents('.ff-gs-style-cat');

                $.freshfaceContextMenu({openAction: 'contextmenu', menuItems:[
                    { name: 'Rename', value:'rename'},
                    { name: 'Color', value: 'color', extraClasses:'ff-gs-style-menu-color-wrapper',
                        childs : [
                            {name:'', value:'#ff3300', extraClasses:'ff-gs-style-menu-color-1'},
                            {name:'', value:'#E91E63', extraClasses:'ff-gs-style-menu-color-2'},
                            {name:'', value:'#9C27B0', extraClasses:'ff-gs-style-menu-color-3'},
                            {name:'', value:'#673AB7', extraClasses:'ff-gs-style-menu-color-4'},
                            {name:'', value:'#3F51B5', extraClasses:'ff-gs-style-menu-color-5'},
                            {name:'', value:'#2196F3', extraClasses:'ff-gs-style-menu-color-6'},
                            {name:'', value:'#03A9F4', extraClasses:'ff-gs-style-menu-color-7'},
                            {name:'', value:'#00BCD4', extraClasses:'ff-gs-style-menu-color-8'},
                            {name:'', value:'#009688', extraClasses:'ff-gs-style-menu-color-9'},
                            {name:'', value:'#4CAF50', extraClasses:'ff-gs-style-menu-color-10'},
                            {name:'', value:'#8BC34A', extraClasses:'ff-gs-style-menu-color-11'},
                            {name:'', value:'#c5d743', extraClasses:'ff-gs-style-menu-color-12'},
                            {name:'', value:'#FFC107', extraClasses:'ff-gs-style-menu-color-13'},
                            {name:'', value:'#FF9800', extraClasses:'ff-gs-style-menu-color-14'},
                            {name:'', value:'#FF5722', extraClasses:'ff-gs-style-menu-color-15'},
                        ]
                    },
                    { name: 'Delete', value:'delete'},
                ]}, function(result) {
                    switch( result ) {
                        case 'rename':
                            $.freshfaceInputBox({ inputText: $catParent.find('.ff-gs-style-cat-header-name').html() }, function( value){
                                $catParent.find('.ff-gs-style-cat-header-name').html(value);
                                $catParent.attr('data-gs-cat-name', value);
                                self._canvas_wasChanged();
                            });
                            break;

                        case 'delete':
                            $.freshfaceConfirmBox('All styles in this category will be deleted across the whole website. There is no way to undo this. Are you sure you want to delete them?', function( response ){
                                if( response ) {
                                    var catId = $catParent.attr('data-gs-cat-id');
                                    var catSelector = '.ff-gs-cat-' + catId;

                                    self.$canvasGroup.find( catSelector).animate({opacity:0}, 500, function(){
                                        $(this).remove();
                                    });

                                    $catParent.animate({opacity:0}, 500, function(){
                                        $(this).remove();
                                    });
                                }
                            });
                            break;

                        default:
                            var selectedColor = result;
                            var catId = $catParent.attr('data-gs-cat-id');
                            $('#ff-gs-cat-style-' + catId).html('.ff-gs-cat-'+catId+' {background-color:'+selectedColor + ' !important;}')
                            $catParent.attr('data-gs-cat-color', selectedColor );
                            break;

                    }
                } );
            });

            /*----------------------------------------------------------*/
            /* GROUP CONTEXT MENU
            /*----------------------------------------------------------*/
            this.$canvasGroup.on('click', '.ff-gs-action-group-header-tool', function(){

                var $groupParent = $(this).parents('.ff-gs-style-group');

                $.freshfaceContextMenu({openAction: 'contextmenu', menuItems:[
                    { name: 'Rename', value:'rename'},
                    { name: 'Delete', value:'delete'},
                ]}, function(result) {
                    switch( result ) {
                        case 'rename':
                            $.freshfaceInputBox({ inputText: $groupParent.find('.ff-gs-style-group-header-name').html() }, function( value){
                                $groupParent.find('.ff-gs-style-group-header-name').html(value);
                                $groupParent.attr('data-gs-group-name', value);
                                self._canvas_wasChanged();
                            });
                            break;

                        case 'delete':
                            $.freshfaceConfirmBox('This style group will be deleted (after saving). It will be automatically removed from your elements and there is no way to take it back.', function( response ){
                                if( response ) {
                                    $groupParent.animate({opacity:0}, 500, function(){
                                        $(this).remove();
                                    });
                                }
                            });
                            break;

                    }
                } );

            });

            /*----------------------------------------------------------*/
            /* RENDER STYLE
            /*----------------------------------------------------------*/
            this.$canvasStyles.on('click', '.ff-gs-style', function(){
                var data = $(this).attr('data-gs-style');
                self.$currentOpenedItem = $(this);
                self._modal_render( data );
            });

            /*----------------------------------------------------------*/
            /* ADD CATEGORY
            /*----------------------------------------------------------*/
            this.$canvas.on('click', '.ff-gs-action__add_style_cat', function(){
                var id = 'gs-' + frslib.identificators.generateUnique();
                var name = 'General';

                var $stylesCategoryHTML = $(self._canvas_getCategoryHtml( id, name ));
                $stylesCategoryHTML.css('opacity', 0);

                var innerColorHtml = '';

                var color = '#4CAF50';

                self.$canvasStyles.append( $stylesCategoryHTML );


                $stylesCategoryHTML.animate({opacity:1}, 200);

                self._canvas_wasChanged();
            });

            /*----------------------------------------------------------*/
            /* GROUP STYLE CLICKED
            /*----------------------------------------------------------*/
            this.$canvasGroup.on('click', '.ff-gs-group-style', function(){
                var currentStyleId = $(this).attr('data-gs-id');
                var selector = '.ff-gs-style-' + currentStyleId;

                self.$canvasStyles.find( selector).trigger('click');

            });

            /*----------------------------------------------------------*/
            /* ADD STYLE GROUP
            /*----------------------------------------------------------*/
            this.$canvas.on('click', '.ff-gs-action__add_style_group', function(){
                var id = 'gs-' + frslib.identificators.generateUnique();
                var name = 'Group';

                var $stylesGroupHtml = $(self._canvas_getGroupHtml( id, name ));
                $stylesGroupHtml.css('opacity', 0);

                self.$canvasGroup.append( $stylesGroupHtml );
                $stylesGroupHtml.animate({opacity:1}, 200);

                self._canvas_wasChanged();
            });


            /*----------------------------------------------------------*/
            /* DISABLE DOCUMENT SCROLLING WHEN SCROLLING IN THE INNER DIVS
            /*----------------------------------------------------------*/

            function preventOuterScroll($element){
                $element.on('mousewheel', function(e, d) {
                    height = $element.height();
                    scrollHeight = $element.get(0).scrollHeight;

                    if((this.scrollTop === (scrollHeight - height) && d < 0) || (this.scrollTop === 0 && d > 0)) {
                        e.preventDefault();
                    }
                });
            };

            preventOuterScroll( $('.ff-gs-styles-col-inner') );
            preventOuterScroll( $('.ff-gs-groups-col-inner') );

        },

        _canvas_getStyleHTMLFromStyle: function( id, style ) {
            var query = new frslib.options2.query();
            query.setData( style );
            var name = query.get('o gen name');
            //var id = query.get('o gen id');

            return this._canvas_getStyleHTML( id, name, style );

        },

        _canvas_getStyleHTML: function( id, name, style ) {
            var styleJSON = {};
            if( style != undefined ) {
                styleJSON = JSON.stringify( style );
            } else {
                styleJSON = '{"o":{"gen":{"ffsys-disabled":"0","ffsys-info":"{}","name":"Style"}}}';
            }

            var $item = $('<div></div>');

            $item.addClass('ff-gs-style');
            $item.addClass('ff-gs-style-'+id);
            $item.attr('data-gs-id', id);
            $item.attr('data-gs-style', styleJSON );
            $item.html( '<span class="ff-gs-style-name-label">' + name + '</span><span class="ff-gs-style-cat-label"></span>' );

            this._canvas_styleInitContextMenu( $item );

            return $item;
        },

        _canvas_styleInitContextMenu: function( $style ) {
            var self = this;
            $style.freshfaceContextMenu({openAction: 'contextmenu', menuItems:[
                //{ name: 'Copy', value:'copy'},
                //{ name: 'Paste', value:'paste'},
                { name: 'Delete', value:'delete'},
            ]}, function(result, $element) { self._canvas_styleContextMenuAction( result, $element ); } );
        },

        _canvas_styleContextMenuAction: function( action, $element ) {
            if( $element.hasClass('ff-gs-group-style') ) {

                $.freshfaceConfirmBox('This style will be deleted (after saving). It will be automatically removed from all groups as well. There is no way to undo this. Are you sure you want to delete it?', function( response ){
                    if( response ) {
                        $element.remove();
                    }
                });


            } else {
                var id = $element.attr('data-gs-id');
                $.freshfaceConfirmBox('This style will be deleted (after saving). It will be automatically removed from all groups as well. There is no way to undo this. Are you sure you want to delete it?', function( response ){
                    $('.ff-gs-style-' + id).remove();
                });
            }
        },

        _canvas_getGroupHtml: function( id, name ) {
            var html = '';
            html += '<div class="ff-gs-style-group ff-gs-style-group-id-'+id+'" data-gs-group-id="' + id + '" data-gs-group-name="' + frslib.attr.escAttr( name ) + '">';
                html += '<div class="ff-gs-style-group-header clearfix">';
                    html += '<h4 class="ff-gs-style-group-header-name">' + name + '</h4>';
                    html += '<div class="ff-gs-style-group-header-toolbox clearfix">';
                        html += '<div class="ff-gs-style-group-header-tool-options ff-gs-action-group-header-tool"><i class="dashicons dashicons-admin-generic"></i></div>';
                    html += '</div>';
                html += '</div>';
                html += '<div class="ff-gs-style-group-list clearfix">';
                    //html += '<div class="ff-gs-style">Body Font Color</div>';
                    //html += '<div class="ff-gs-style">Big Heading Size</div>';
                    //html += '<div class="ff-gs-style">Text Underline</div>';
                html += '</div>';
            html += '</div>';

            return html;
        },

        _canvas_getCategoryHtml: function( id, name, color ) {
            var html = '';

            if( !color ) {
                color = '#4CAF50';
            }
            html += '<div class="ff-gs-style-cat ff-gs-style-cat-id-'+id+'" data-gs-cat-id="' + id + '" data-gs-cat-name="' + frslib.attr.escAttr( name ) + '" data-gs-cat-color="'+color+'">';
                html += '<div class="ff-gs-style-cat-header clearfix">';
                    html += '<h4 class="ff-gs-style-cat-header-name">' + name + '</h4>';
                    html += '<div class="ff-gs-style-cat-header-toolbox clearfix">';
                        html += '<div class="ff-gs-style-cat-header-tool-options ff-gs-action-cat-header-tool"><i class="dashicons dashicons-admin-generic"></i></div>';
                        html += '<div class="ff-gs-cat-header__action--add-style"><i class="dashicons dashicons-plus"></i></div>';
                    html += '</div>';
                html += '</div>';
                html += '<div class="ff-gs-style-cat-list clearfix">';

                html += '</div>';

                var innerColorHtml = '.ff-gs-cat-'+id+' {background-color:'+color + ' !important;}';
                html += '<style id="ff-gs-cat-style-' + id + '">' + innerColorHtml + '</style>';

            html += '</div>';

            return html;
        },

        _canvas_printCanvas: function() {
            var dataJSON = $('.ff-gs-data').html();
            var data = JSON.parse( dataJSON );
            var self = this;

            var info = [];

            /*
             group:
             -id
             -name
             -type (group)

             item:
             -id
             -style
             -type(item)
             -groupId
             */
            /*----------------------------------------------------------*/
            /* CATEGORIES
            /*----------------------------------------------------------*/
            var html = '';
            $.each(data, function( index, value ){
                if( value.type == 'category' ) {
                    html += self._canvas_getCategoryHtml( value.id, value.name, value.color );
                }
            });

            var $html = $(html);

            // ITEMS
            $.each(data, function( index, value ){
                if( value.type == 'item' ) {
                    var $item = self._canvas_getStyleHTMLFromStyle(value.id,value.style );

                    info[ value.id ] = {};
                    info[ value.id].name = $item.find('.ff-gs-style-name-label').html();
                    info[ value.id].catId = value.catId;
                    //names[ value.id ] = $item.html();
                    $item.addClass('ff-gs-cat-' + value.catId );

                    $html.filter('.ff-gs-style-cat-id-' + value.catId).find('.ff-gs-style-cat-list').append( $item );
                }
            });

            this.$canvasStyles.html( $html );



            dataJSON = $('.ff-gs-group-data').html();
            data = JSON.parse( dataJSON );

            /*----------------------------------------------------------*/
            /* GROUPS
            /*----------------------------------------------------------*/
            //html = '';
            $html = $('<div></div>');
            $.each(data, function( index, value ){
                var $groupHtml = $(self._canvas_getGroupHtml( value.id, value.name ));

                $html.append( $groupHtml );

                $.each(value.childs, function( index, value ){
                    if( value.type == 'item' ) {
                        var $item = self._canvas_getStyleHTML(value.id, info[value.id].name );

                        $item.addClass('ff-gs-cat-' + info[value.id].catId );
                        $item.addClass('ff-gs-group-style');
                        $item.addClass('ff-gs-group-style-' + value.id );

                        $groupHtml.find('.ff-gs-style-group-list').append( $item );
                    }
                });
            });

            //$html = $(html);
            /*----------------------------------------------------------*/
            /* ITEMS IN GROUPS
            /*----------------------------------------------------------*/
            //$.each(data, function( index, value ){
            //    if( value.type == 'item' ) {
            //        //console.log( value );
            //        var $item = self._canvas_getStyleHTML(value.id, info[value.id].name );
            //
            //        $item.addClass('ff-gs-cat-' + info[value.id].catId );
            //        $item.addClass('ff-gs-group-style');
            //        $item.addClass('ff-gs-group-style-' + value.id );
            //
            //        $html.filter('.ff-gs-style-group-id-' + value.groupId).find('.ff-gs-style-group-list').append( $item );
            //    }
            //});

            this.$canvasGroup.html( $html.children() );

            this._canvas_wasChanged();
        },

        _canvas_normalizeItems: function() {
            var self = this;
            var toReturn = {};


            var globalStyles = {};

            this.$canvasStyles.find('.ff-gs-style-cat').each(function(){
                var catId = $(this).attr('data-gs-cat-id');
                var catName = $(this).attr('data-gs-cat-name');

                var cat = {};
                cat['id'] = catId;
                cat['name'] = catName;
                cat['type'] = 'category';
                cat['color'] = $(this).attr('data-gs-cat-color');

                globalStyles[ catId ] = cat;

                $(this).find('.ff-gs-style').each(function(){
                    var itemId = $(this).attr('data-gs-id');
                    var itemStyle = $(this).attr('data-gs-style');

                    if( itemStyle != undefined ) {
                        itemStyle = JSON.parse( itemStyle );
                    }

                    var item = {};
                    item['id'] = itemId;
                    item['style'] = itemStyle;
                    item['type'] = 'item';
                    item['catId'] = catId;

                    globalStyles[ itemId ] = item;
                });
            });

            toReturn.globalStyles = globalStyles;


            var globalStylesGroup = {};
            this.$canvasGroup.find('.ff-gs-style-group').each(function(){
                var groupId = $(this).attr('data-gs-group-id');
                var groupName = $(this).attr('data-gs-group-name');

                var group = {};
                group['id'] = groupId;
                group['name'] = groupName;
                group['type'] = 'group';
                group['styles'] = {};
                group['childs'] = [];


                globalStylesGroup[ groupId ] = group;



                $(this).find('.ff-gs-style').each(function(){
                    var itemId = $(this).attr('data-gs-id');
                    //var itemStyle = $(this).attr('data-gs-style');
                    //
                    //if( itemStyle != undefined ) {
                    //    itemStyle = JSON.parse( itemStyle );
                    //}

                    var item = {};
                    item['id'] = itemId;
                    //item['style'] = itemStyle;
                    item['type'] = 'item';
                    item['groupId'] = groupId;

                    var $originalItem = self.$canvasStyles.find('.ff-gs-style-' + itemId);

                    var itemStyle = $originalItem.attr('data-gs-style');

                    //console.log( itemStyle );

                    if( itemStyle != undefined ) {
                        itemStyle = JSON.parse( itemStyle );
                        group['styles'] = frslib.array.array_replace_recursive( group['styles'], itemStyle);
                    }

                    group['childs'].push(item);
                });

                var styleJson = JSON.stringify( group['styles'] );
                group['hash'] = md5( styleJson );


            });

            toReturn.globalStylesGroup = globalStylesGroup;
            return toReturn;
        },

        _canvas_saveCanvas: function( callback ) {
            var specification = {
                adminScreenName : 'GlobalStyles',
                adminViewName: 'Default',
            };

            var data = {};

            var allData = this._canvas_normalizeItems();

            data.globalStyles = allData.globalStyles;
            data.globalStylesGroup = allData.globalStylesGroup;
            data.colorLibrary = window.frs_theme_color_library;
            data.action = 'save';


            var globalStylesForBroadcast = [];

            $.each( data.globalStylesGroup, function(index, value ){
;
                var name = value.name;
                //var itemI = value.id;

                var item = {};
                item.name = name;
                item.value = value.id;

                globalStylesForBroadcast.push( item );
            });

            console.log( data.globalStylesGroup);

            frslib.environment.notificationMamanger.addNotification('info', 'Saving ...');
            frslib.ajax.frameworkRequest( 'ffAdminScreenManager', specification,data, function( response ){
                frslib.messages.broadcast({'command' : 'refresh' });
                console.log( globalStylesForBroadcast );

                frslib.messages.broadcast({ 'command' : 'globalStylesChange', 'globalStyles': globalStylesForBroadcast } );
                frslib.messages.broadcast({ 'command' : 'colorLibraryChange', 'colorLibrary': window.frs_theme_color_library});
                frslib.environment.notificationMamanger.addNotification('success', 'Saved & Published');
            });
        },

        _canvas_normalizeNewGroupItem: function ( $clonnedItem ) {
            $clonnedItem.removeAttr('data-gs-style');
            var id = $clonnedItem.attr('data-gs-id');
            $clonnedItem.addClass('ff-gs-group-style ff-gs-group-style-' + id);

            this._canvas_styleInitContextMenu( $clonnedItem );
        },

        _canvas_wasChanged: function() {
            var self = this;

            $('.ff-gs-style-cat-list').sortable(
                {
                    connectWith: '.ff-gs-style-cat-list, .ff-gs-style-group-list',

                    stop: function( event, ui ) {

                        self._canvas_fillStyleCat();
                        var $item = ui.item;
                        var $parent = $item.parent();

                        if( $parent.hasClass('ff-gs-style-group-list') ) {

                            var itemId = $item.attr('data-gs-id');
                            var itemClass = '.ff-gs-style-' + itemId;

                            if( $parent.find(itemClass).size() > 1 ) {
                                return false;
                            }

                            var $clonnedItem = ui.item.clone();
                            self._canvas_normalizeNewGroupItem( $clonnedItem );


                            ui.item.after( $clonnedItem );

                            return false;
                        }
                        // drag and droppping between cat lists
                        else {
                            var $catList = $item.parents('.ff-gs-style-cat');
                            var catListId = $catList.attr('data-gs-cat-id');

                            var itemId = $item.attr('data-gs-id');



                            var classNameToRemove = '';
                            $item.removeClass(function(index, className){


                                var splittedClasses = className.split(' ');


                                $.each(splittedClasses, function( index, value){

                                    if( value.indexOf('ff-gs-cat-gs') != -1 ) {
                                        classNameToRemove = value;
                                    }


                                });

                                return classNameToRemove;
                            });

                            $('.ff-gs-group-style-' + itemId).removeClass( classNameToRemove).addClass('ff-gs-cat-' + catListId);
                            $item.addClass('ff-gs-cat-' + catListId);
                        }

                    },

                    placeholder: 'ui-sortable-placeholder',
                    cursorAt: { left: -10, top: 0 },
                    tolerance: 'pointer'

                }
            );


            $(' .ff-gs-style-group-list').sortable({
                connectWith: '.ff-gs-style-group-list',
                
                placeholder: 'ui-sortable-placeholder',
                cursorAt: { left: -10, top: 0 },
                tolerance: 'pointer'

            });

            //$('.ff-gs-style').each(function(){});

            this._canvas_fillStyleCat();

            //$('.ff-gs-style').freshfaceContextMenu({openAction: 'contextmenu', menuItems:[
            //    { name: 'Copy', value:'copy'},
            //    { name: 'Paste', value:'paste'},
            //    { name: 'Delete', value:'delete'},
            //]}, function(result) { self._contextMenuActions( result ); } );
        },










        getHtmlOfGlobalStyle: function() {


            return;
            var dataString = $('.ff-gs-structure').html();
            var structure = JSON.parse( dataString );

            var optionsManager = new frslib.options2.managerModal();
            optionsManager.setStructure( structure );
            optionsManager.setData( {} );
             // $optionsHolder.data('ff-optionsManager', optionsManager);

            var html = optionsManager.render();

            return html;
        },

        printModal: function(){
            var modalHTML = new window.ffbuilder.Modal({ getOnlyModalHTML: true })._generateElementHtml();
            var $modal = $(modalHTML );

            $('body').append( $modal );

            $modal.find('.ffb-modal__body').addClass('ffb-modal__global-styles');
            $modal.find('.ffb-modal__body').html( this.getHtmlOfGlobalStyle() );
            $modal.css('display', 'block');
        },




    };

    $(document).ready(function(){

        //frslib.globalStyles.appInstance = new frslib.globalStyles.app();
        var appInstance = frslib.globalStyles.app;

        appInstance.init();

        //$('.ff-gs-style-cat-list').sortable({connectWith: ".ff-gs-style-cat-list="});

        //appInstance.printModal();


        //
        //var dataString = $('.ff-globalstyles-holder').html();
        //var structure = JSON.parse( dataString );
        //
        //var optionsManager = new frslib.options2.managerModal();
        //optionsManager.setStructure( structure );
        //optionsManager.setData( {} );
        // // $optionsHolder.data('ff-optionsManager', optionsManager);
        //
        //var html = optionsManager.render();
        //
        //$('.ffholder').html( html );

    });

})(jQuery);