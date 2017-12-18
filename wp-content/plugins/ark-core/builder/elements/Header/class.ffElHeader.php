<?php

/**
 * @link http://demo.freshface.net/html/h-ark/HTML/page_contacts.html#scrollTo__1355
 * @link http://demo.freshface.net/html/h-ark/HTML/one-page/one-page-business/index_profile_2.html#scrollTo__7763
 */

class ffElHeader extends ffThemeBuilderElementBasic {
	protected function _initData() {
		$this->_setData( ffThemeBuilderElement::DATA_ID, 'header');
		$this->_setData( ffThemeBuilderElement::DATA_NAME, esc_attr( __('Header', 'ark' ) ) );
		$this->_setData( ffThemeBuilderElement::DATA_HAS_DROPZONE, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_CONTENT_PARAMS, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_SYSTEM_TABS, false);
		$this->_setData( ffThemeBuilderElement::DATA_IS_HIDDEN, true);
		$this->_setData( ffThemeBuilderElement::DATA_CAN_BE_CACHED, false);
		$this->_setData( ffThemeBuilderElement::DATA_HAS_SYSTEM_TABS, false);


		$this->_setColor('dark');
	}

	/**
	 * @param $s ffOneStructure|ffThemeBuilderOptionsExtender
	 */
	protected function _getElementGeneralOptions_MenuTemplate( $s ){
		$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'show', ark_wp_kses(__('Show Template', 'ark')), 0 );

		$s->addElement(ffOneElement::TYPE_NEW_LINE);

		$s->startHidingBox('show', 'checked');
			$s->startAdvancedToggleBox('wrapper', ark_wp_kses(__('Template Wrapper', 'ark')) );
				$s->addElement(ffOneElement::TYPE_DESCRIPTION, '', ark_wp_kses(__('Click on <i class="dashicons dashicons-edit"></i> icon in this box in upper right corner to apply additional settings such as hiding this Template on mobile devices.', 'ark')) );
				$s->addElement(ffOneElement::TYPE_DESCRIPTION, '', ark_wp_kses(__('You can customize the content of this Template in <a href="./edit.php?post_type=ff-template" target="_blank">Ark &gt; Templates</a>.', 'ark')) );
				$s->addElement(ffOneElement::TYPE_NEW_LINE);
				$s->addOptionNL( ffOneOption::TYPE_POST_SELECTOR, 'template-id', '', '' )
					->addParam('post_type', 'ff-template')
					->addParam('load-dynamic', true)
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ' &nbsp; ' . ark_wp_kses(__('Template', 'ark')) );
				;
			$s->endAdvancedToggleBox();
		$s->endHidingBox();
	}

	/**
	 * @param $s ffOneStructure|ffThemeBuilderOptionsExtender
	 * @return mixed
	 */
	protected function _getElementGeneralOptions( $s ) {

	$sh = $s->getOptionsStructureHelper();

	$headerHorizontalArray = array('header', 'header-center-aligned', 'fullscreen');
	$headerVerticalArray = array('vertical-multi', 'vertical-onepage');
	$headerHorizontalSimpleArray = array('header', 'header-center-aligned' );
	$headerHorizontalWhiteTopArray = array('header','header-center-aligned');

	$s->addElement( ffOneElement::TYPE_HTML, '', '<div class="top-hiding-parent">' );

		$s->addElement( ffOneElement::TYPE_TABLE_START );

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses( __('Info', 'ark' ) ) );
				$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('<strong>Static</strong> Header disappears after you scroll down.', 'ark' ) ) );
				$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('<strong>Fixed</strong> Header stays fixed to the top of the screen, whether you are scrolling or not.', 'ark' ) ) );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END);

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses(__('General', 'ark')));


				/* MENU DESIGN TYPE */

				$s->addOptionNL( ffOneOption::TYPE_SELECT, 'design-type', '', 'header')
					->addParam('is_group', true)
					->addSelectValue(esc_attr(__('Horizontal Classic with Left Logo', 'ark')), 'header', esc_attr(__('Horizontal', 'ark')))
					->addSelectValue(esc_attr(__('Horizontal Classic with Centered Logo', 'ark')), 'header-center-aligned', esc_attr(__('Horizontal', 'ark')))
					->addSelectValue(esc_attr(__('Horizontal Minimal with Full Screen Navigation', 'ark')), 'fullscreen', esc_attr(__('Horizontal', 'ark')))
					->addSelectValue(esc_attr(__('Vertical Classic with Submenus', 'ark')), 'vertical-multi', esc_attr(__('Vertical', 'ark')))
					->addSelectValue(esc_attr(__('Vertical Classic without Submenus', 'ark')), 'vertical-onepage', esc_attr(__('Vertical', 'ark')))
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Header Style', 'ark')) )
				;

				$sh->startHidingBox('design-type', array('header', 'header-center-aligned') , false, '.top-hiding-parent');
					$s->addElement(ffOneElement::TYPE_NEW_LINE);
					$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'make-transparent', ark_wp_kses(__('Make Header background transparent before scrolling down', 'ark')), 0);
					$sh->startHidingBox('horizontal-position', array( 'header-sticky navbar-fixed-top', 'navbar-fixed-top header-sticky auto-hiding-navbar' ) , false, '.top-hiding-parent');
						$s->addElement(ffOneElement::TYPE_DESCRIPTION, '', ark_wp_kses(__('If you turn this ON then you might want to turn OFF the white space compensation below so your header is displayed over the content.', 'ark')) );
					$sh->endHidingBox();
					$s->addElement(ffOneElement::TYPE_DESCRIPTION, '', ark_wp_kses(__('Transparent Header will have white text color by default that you can change in the Color options below.', 'ark')) );
					$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'header-pills', ark_wp_kses(__('Header Pills', 'ark')), 0);
					$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'header-mobile-force-submenu', ark_wp_kses(__('Menu items with submenu on mobile opens submenu and not go to another page', 'ark')), 0);
				$sh->endHidingBox();

				$sh->startHidingBox('design-type', $headerHorizontalWhiteTopArray, false, '.top-hiding-parent');
					$sh->startHidingBox('horizontal-position', array( 'header-sticky navbar-fixed-top', 'navbar-fixed-top header-sticky auto-hiding-navbar' ) , false, '.top-hiding-parent');
						$s->addElement(ffOneElement::TYPE_NEW_LINE);
						$s->addOption( ffOneOption::TYPE_CHECKBOX, 'wrapper-top-space-xs', ark_wp_kses(__('Compensate white space under header on tablet (SM)', 'ark')), 0);
						$s->addElement(ffOneElement::TYPE_DESCRIPTION, '', ark_wp_kses(__('If your page content is partially hidden by the fixed Header, then you might want to turn on the compensation. This will add extra white space on top of your page content so your content will always be visible.', 'ark')) );
						$s->startHidingBox('wrapper-top-space-xs', 'checked');
							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'wrapper-top-space-bg-color-xs', '')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Space under header background color on mobile (XS) and tablet (SM)', 'ark')) );
						$s->endHidingBox();
						$s->addElement(ffOneElement::TYPE_NEW_LINE);
						$s->addOption( ffOneOption::TYPE_CHECKBOX, 'wrapper-top-space', ark_wp_kses(__('Compensate white space under header on laptop (MD) and desktop (LG)', 'ark')), 1);
						$s->startHidingBox('wrapper-top-space', 'checked');
							$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'wrapper-top-space-bg-color', '')
								->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Space under header background color on laptop (MD) and desktop (LG)', 'ark')) );
						$s->endHidingBox();
						$s->addElement(ffOneElement::TYPE_NEW_LINE);
						$s->addOption( ffOneOption::TYPE_CHECKBOX, 'wrapper-top-space--include-topbar-height', ark_wp_kses(__('Include the Topbar height in white-space compensation calculation')), 0);
					$sh->endHidingBox();
				$sh->endHidingBox();


				/* HORIZONTAL CENTER MENU - split menu after menu with index */

				$sh->startHidingBox('design-type', array( 'header-center-aligned' ) , false, '.top-hiding-parent');
					$s->addElement(ffOneElement::TYPE_NEW_LINE);
					$s->addOption( ffOneOption::TYPE_SELECT, 'split-after', ark_wp_kses(__('Split Menu after ', 'ark')), '4')
						->addSelectValue( ark_wp_kses(__('Do not split', 'ark')), 0)
						->addSelectValue( ark_wp_kses(__('1st','ark')), 1)
						->addSelectValue( ark_wp_kses(__('2nd','ark')), 2)
						->addSelectValue( ark_wp_kses(__('3rd','ark')), 3)
						->addSelectValue( ark_wp_kses(__('4th','ark')), 4)
						->addSelectValue( ark_wp_kses(__('5th','ark')), 5)
						->addSelectValue( ark_wp_kses(__('6th','ark')), 6)
						->addSelectValue( ark_wp_kses(__('7th','ark')), 7)
						->addSelectValue( ark_wp_kses(__('8th','ark')), 8)
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('menu item', 'ark')) )
					;					
					$s->addElement(ffOneElement::TYPE_DESCRIPTION, '', ark_wp_kses(__('This option splits your navigation menu into 2 parts. The first part will be shown on the left side and the other part will be shown on the right side.', 'ark')) );
				$sh->endHidingBox();

				$sh->startHidingBox('design-type', 'fullscreen', false, '.top-hiding-parent');
					$s->addElement(ffOneElement::TYPE_NEW_LINE);
					$s->addOptionNL( ffOneOption::TYPE_SELECT, 'fullscreen-menu-button-position', '', 'left')
						->addSelectValue(ark_wp_kses(__('Left', 'ark')), 'left')
						->addSelectValue(ark_wp_kses(__('Right', 'ark')), 'right')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Menu Button Position', 'ark')) )
					;
				$sh->endHidingBox();
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );
		$s->addElement( ffOneElement::TYPE_TABLE_END );

		$sh->startHidingBox('design-type', array('header', 'header-center-aligned') , false, '.top-hiding-parent');
			/* HORIZONTAL MENU - ADD TOPBAR */
			$s->addElement( ffOneElement::TYPE_TABLE_START );
				$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses(__('Header Topbar', 'ark')));

					$s->addElement(ffOneElement::TYPE_NEW_LINE);
					$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'add-topbar', ark_wp_kses(__('Show Topbar', 'ark')), 0);
					$s->addElement(ffOneElement::TYPE_DESCRIPTION, '', ark_wp_kses(__('You can customize your Topbar in the Topbar Builder which can be accessed from the left menu.', 'ark')) );


					$s->startHidingBox('add-topbar', 'checked');
						$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'topbar-mobile-button', ark_wp_kses(__('Open topbar with button on mobile (XS) and tablet (SM)', 'ark')), 1);
						$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'topbar-hidden-when-scroll', ark_wp_kses(__('Topbar is hidden when you scroll down on laptop (MD) and desktop (LG)', 'ark')), 1);
					$s->endHidingBox();

				$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );
			$s->addElement( ffOneElement::TYPE_TABLE_END );
		$sh->endHidingBox();

		$sh->startHidingBox('design-type', array('header', 'header-center-aligned', 'vertical-multi', 'vertical-onepage') , false, '.top-hiding-parent');

			$s->addElement( ffOneElement::TYPE_TABLE_START );
				$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses(__('Header Position', 'ark')));

					/* MENU - FIXED or STATIC - XS & SM */

					$s->addOptionNL( ffOneOption::TYPE_SELECT, 'horizontal-position-xs', '', '')
						->addSelectValue(ark_wp_kses(__('Fixed - Always on top', 'ark')), 'ark-header-mobile-fixed')
						->addSelectValue(ark_wp_kses(__('Static', 'ark')), '')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Header Position on mobile (XS) and tablet (SM)', 'ark') ) )
					;

					$s->addElement(ffOneElement::TYPE_NEW_LINE);

					/* VERTICAL MENU - LEFT or RIGHT - MD & LG*/

					$sh->startHidingBox('design-type', array('vertical-multi', 'vertical-onepage') , false, '.top-hiding-parent');
						$s->addOptionNL( ffOneOption::TYPE_SELECT, 'vertical-position', '', 'left')
							->addSelectValue(ark_wp_kses(__('Left', 'ark')), 'left')
							->addSelectValue(ark_wp_kses(__('Right', 'ark')), 'right')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Header Position on laptop (MD) and desktop (LG)', 'ark') ) )
						;
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'vertical-width', '', '')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Custom header width (in px)', 'ark')) )
							->addParam('placeholder', '260');
					$sh->endHidingBox();

					/* HORIZONTAL MENU - LEFT or RIGHT - MD & LG*/

					$sh->startHidingBox('design-type', array('header', 'header-center-aligned') , false, '.top-hiding-parent');

						$s->addOptionNL( ffOneOption::TYPE_SELECT, 'horizontal-position', '', 'header-sticky navbar-fixed-top')
							->addSelectValue(ark_wp_kses(__('Fixed - Always on top', 'ark')), 'header-sticky navbar-fixed-top')
							->addSelectValue(ark_wp_kses(__('Fixed Special - Hide on scroll down, show on scroll up', 'ark')), 'navbar-fixed-top header-sticky auto-hiding-navbar')
							->addSelectValue(ark_wp_kses(__('Static', 'ark')), 'header-fixed')
							->addSelectValue(ark_wp_kses(__('Static Overlay', 'ark')), 'header-fixed header-fixed-absolute')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Header Position on laptop (MD) and desktop (LG)', 'ark') ) )
						;
					$sh->endHidingBox();
				$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );
			$s->addElement( ffOneElement::TYPE_TABLE_END );
		$sh->endHidingBox();

		/* HEADER WIDTH */

		$sh->startHidingBox('design-type', $headerHorizontalArray , false, '.top-hiding-parent');
			$s->addElement( ffOneElement::TYPE_TABLE_START );
				$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses(__('Header Width', 'ark')));

					$s->addOptionNL(ffOneOption::TYPE_SELECT,'type','','fg-container-large')
						->addSelectValue('Small','fg-container-small')
						->addSelectValue('Medium','fg-container-medium')
						->addSelectValue('Large (default)','fg-container-large')
						->addSelectValue('Full Width','fg-container-fluid')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, 'Container Size' )
					;
					$s->addOption(ffOneOption::TYPE_CHECKBOX,'no-padding','Remove horizontal padding from the Container',0);

				$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );
			$s->addElement( ffOneElement::TYPE_TABLE_END );
		$sh->endHidingBox();

		/* ALL MENU - LOGO(S) */

		$s->addElement( ffOneElement::TYPE_TABLE_START );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses(__('Logo and Header height', 'ark')));
				$s->startAdvancedToggleBox('logo', 'Logo');
					$s->startHidingBoxParent();

					$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'show', ark_wp_kses(__('Show Logo', 'ark')), 1);
					$s->addElement(ffOneElement::TYPE_NEW_LINE);
					$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'has-custom-logo-url', ark_wp_kses(__('Logo leads to custom URL', 'ark')), 0);
					$s->startHidingBox('has-custom-logo-url', 'checked');
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'custom-logo-url', '', get_home_url())
							->addParam( ffOneOption::PARAM_TITLE_AFTER, 'Custom Logo URL' );
					$s->endHidingBox();
					$s->addElement(ffOneElement::TYPE_NEW_LINE);
					$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'desktop-logo-jump-out', ark_wp_kses(__('Logo Jump Out', 'ark')), 0);
					$s->addElement(ffOneElement::TYPE_DESCRIPTION, '', ark_wp_kses(__('Only for desktop. Logo height needs to be bigger than header height in order to look properly.', 'ark')) );
					$s->addElement(ffOneElement::TYPE_NEW_LINE);

					$s->addOptionNL( ffOneOption::TYPE_IMAGE, 'image', ark_wp_kses(__('Desktop logo before scrolling down', 'ark')), '');
						$s->startSection('desktop-top-height');
							$s->addOptionNL( ffOneOption::TYPE_SELECT, 'type', 'Header Height ', 'default')
								->addSelectValue('Default (91px)', 'default')
								->addSelectValue('Adjust to logo size', 'adjust-to-logo')
								->addSelectValue('Set custom size', 'custom');

							$s->startHidingBox('type', array('custom', 'adjust-to-logo') );
								$s->addOptionNL( ffOneOption::TYPE_TEXT, 'custom-logo-height', 'Logo Height (in px) ', '');
								$s->addElement(ffOneElement::TYPE_DESCRIPTION, '', ark_wp_kses(__('Keep blank for using height of your logo image, default is 45px', 'ark')) );
							$s->endHidingBox();

							$s->startHidingBox('type', 'custom');
								$s->addOptionNL( ffOneOption::TYPE_TEXT, 'custom-header-height', 'Header Height (in px) ', '90');
							$s->endHidingBox();

							$s->addElement(ffOneElement::TYPE_NEW_LINE);
							$s->addElement(ffOneElement::TYPE_NEW_LINE);
						$s->endSection();

					$sh->startHidingBox('design-type', $headerHorizontalArray , false, '.top-hiding-parent');
						$s->addOptionNL( ffOneOption::TYPE_IMAGE, 'image-desktop-fixed', ark_wp_kses(__('Desktop logo 
							after scrolling down', 'ark')), '');


						$s->startSection('desktop-scroll-height');
							$s->startHidingBoxParent();
								$s->addOptionNL( ffOneOption::TYPE_SELECT, 'type', 'Header Height ', 'default')
									->addSelectValue('Default (71px)', 'default')
									->addSelectValue('Adjust to logo size', 'adjust-to-logo')
									->addSelectValue('Set custom size', 'custom');

								$s->startHidingBox('type', array('custom', 'adjust-to-logo') );
									$s->addOptionNL( ffOneOption::TYPE_TEXT, 'custom-logo-height', 'Logo Height (in px) ', '');
									$s->addElement(ffOneElement::TYPE_DESCRIPTION, '', ark_wp_kses(__('Keep blank for using height of your logo image, default is 45px', 'ark')) );
								$s->endHidingBox();

								$s->startHidingBox('type', 'custom');
									$s->addOptionNL( ffOneOption::TYPE_TEXT, 'custom-header-height', 'Header Height (in px) ', '90');
								$s->endHidingBox();

								$s->addElement(ffOneElement::TYPE_NEW_LINE);
								$s->addElement(ffOneElement::TYPE_NEW_LINE);
							$s->endHidingBoxParent();
						$s->endSection();

					$sh->endHidingBox();

					$s->addOptionNL( ffOneOption::TYPE_IMAGE, 'image-tablet', ark_wp_kses(__('Tablet logo', 'ark')), '');

					$s->startSection('tablet-height');
						$s->startHidingBoxParent();
							$s->addOptionNL( ffOneOption::TYPE_SELECT, 'type', 'Header Height ', 'default')
								->addSelectValue('Default (91px)', 'default')
								->addSelectValue('Adjust to logo size', 'adjust-to-logo')
								->addSelectValue('Set custom size', 'custom');

							$s->startHidingBox('type', array('custom', 'adjust-to-logo') );
								$s->addOptionNL( ffOneOption::TYPE_TEXT, 'custom-logo-height', 'Logo Height (in px) ', '');
								$s->addElement(ffOneElement::TYPE_DESCRIPTION, '', ark_wp_kses(__('Keep blank for using height of your logo image, default is 45px', 'ark')) );
							$s->endHidingBox();

							$s->startHidingBox('type', 'custom');
								$s->addOptionNL( ffOneOption::TYPE_TEXT, 'custom-header-height', 'Header Height (in px) ', '90');
							$s->endHidingBox();

							$s->addElement(ffOneElement::TYPE_DESCRIPTION, '', ark_wp_kses(__('If tablet logo is empty, Mobile logo will be used. Tablet logo is for devices with 768 - 991 pixels width.', 'ark')) );

							$s->addElement(ffOneElement::TYPE_NEW_LINE);
							$s->addElement(ffOneElement::TYPE_NEW_LINE);
						$s->endHidingBoxParent();
					$s->endSection();


					$s->addOptionNL( ffOneOption::TYPE_IMAGE, 'image-mobile', ark_wp_kses(__('Mobile logo', 'ark')), '');

					$s->startSection('mobile-height');
						$s->startHidingBoxParent();
							$s->addOptionNL( ffOneOption::TYPE_SELECT, 'type', 'Header Height ', 'default')
								->addSelectValue('Default (91px)', 'default')
								->addSelectValue('Adjust to logo size', 'adjust-to-logo')
								->addSelectValue('Set custom size', 'custom');

							$s->startHidingBox('type', array('custom', 'adjust-to-logo') );
								$s->addOptionNL( ffOneOption::TYPE_TEXT, 'custom-logo-height', 'Logo Height (in px) ', '');
								$s->addElement(ffOneElement::TYPE_DESCRIPTION, '', ark_wp_kses(__('Keep blank for using height of your logo image, default is 45px', 'ark')) );
							$s->endHidingBox();

							$s->startHidingBox('type', 'custom');
								$s->addOptionNL( ffOneOption::TYPE_TEXT, 'custom-header-height', 'Header Height (in px) ', '90');
							$s->endHidingBox();

							$s->addElement(ffOneElement::TYPE_NEW_LINE);
							$s->addElement(ffOneElement::TYPE_NEW_LINE);
						$s->endHidingBoxParent();
					$s->endSection();


					$s->addElement(ffOneElement::TYPE_DESCRIPTION, '', ark_wp_kses(__('Use the advanced tools ', 'ark')) );
					$s->endHidingBoxParent();
				$s->endAdvancedToggleBox();
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );
		$s->addElement( ffOneElement::TYPE_TABLE_END );

		/* VERTICAL MENU - COPYRIGHT TEXT */

		$sh->startHidingBox('design-type', $headerVerticalArray , false, '.top-hiding-parent');
			$s->addElement( ffOneElement::TYPE_TABLE_START );
				$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses(__('Desktop Logo', 'ark')));

					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'vdl-p-t', '', '')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Custom Padding Top for Desktop Logo (in px)', 'ark')) );
					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'vdl-p-r', '', '')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Custom Padding Right for Desktop Logo (in px)', 'ark')) );
					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'vdl-p-b', '', '')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Custom Padding Bottom for Desktop Logo (in px)', 'ark')) );
					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'vdl-p-l', '', '')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Custom Padding Left for Desktop Logo (in px)', 'ark')) );

					$s->addElement(ffOneElement::TYPE_DESCRIPTION, '', ark_wp_kses(__('By default, the Desktop Logo has padding around it. If you want to remove this padding, you can input <code>0</code>in all of the padding options above. Alternatively, you can of course input any other custom values that you want as your padding.', 'ark')) );

				$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );
			$s->addElement( ffOneElement::TYPE_TABLE_END );
		$sh->endHidingBox();


		/* ALL MENU - CUSTOM NAVIGATION MENU */

		$s->addElement( ffOneElement::TYPE_TABLE_START );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses(__('Navigation Menu', 'ark')));
				$s->startSection('menu');
					$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'use-custom', ark_wp_kses(__('Ignore the Navigation Menu that is selected as <strong>Main Navigation</strong> in <a href="./nav-menus.php?action=locations" target="_blank">Appearance &gt; Menus &gt; Manage Locations</a> and use Custom Navigation Menu', 'ark')), 0 );
					$s->startHidingBox('use-custom', 'checked');

					$s->addOptionNL(ffOneOption::TYPE_TAXONOMY, 'nav-menu', '', '')
						->addParam('tax_type', 'nav_menu')
						->addParam('multiple', 'not')
						->addParam('load-dynamic', true)
						->addParam( ffOneOption::PARAM_TITLE_AFTER, '&nbsp; ' . ark_wp_kses(__('Navigation Menu', 'ark')) );

					$s->endHidingBox();

					$s->addElement(ffOneElement::TYPE_NEW_LINE);
					$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'disable-nav-menu', ark_wp_kses(__('Disable Navigation Menu (If checked, the menu will NOT be printed)', 'ark')), 0 );

				$s->endSection();
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );
		$s->addElement( ffOneElement::TYPE_TABLE_END );


		/* TEMPLATE - IN THE BEGINNING OF THE HEADER */
		$sh->startHidingBox('design-type', array('header', 'header-center-aligned', 'vertical-multi', 'vertical-onepage') , false, '.top-hiding-parent');
			$s->addElement( ffOneElement::TYPE_TABLE_START );
				$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses(__('Custom Content - Beginning of Header', 'ark')));
					$s->startSection('template-beginning-of-header');
						$this->_getElementGeneralOptions_MenuTemplate( $s );
					$s->endSection();
				$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );
			$s->addElement( ffOneElement::TYPE_TABLE_END );
		$sh->endHidingBox();


		/* HORIZONTAL ONLY (NO FULLSCREEN) - TEMPLATE BEFORE SEARCH AND SIDE MENU */
		$sh->startHidingBox('design-type', $headerHorizontalSimpleArray , false, '.top-hiding-parent');
			$s->addElement( ffOneElement::TYPE_TABLE_START );
				$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses(__('Custom Content - Before Menu Icons', 'ark')));
					$s->startSection('template-before-menu-icons');
						$this->_getElementGeneralOptions_MenuTemplate( $s );
					$s->endSection();
				$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );
			$s->addElement( ffOneElement::TYPE_TABLE_END );
		$sh->endHidingBox();


		/* VERTICAL ONLY - TEMPLATE AFTER LOGO */
		$sh->startHidingBox('design-type', $headerVerticalArray , false, '.top-hiding-parent');
			$s->addElement( ffOneElement::TYPE_TABLE_START );
				$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses(__('Custom Content - Under Logo', 'ark')));
					$s->startSection('template-under-logo');
						$this->_getElementGeneralOptions_MenuTemplate( $s );
					$s->endSection();
				$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );
			$s->addElement( ffOneElement::TYPE_TABLE_END );
		$sh->endHidingBox();


		/* TEMPLATE - THE END OF HEADER */
		$sh->startHidingBox('design-type', array('header', 'header-center-aligned', 'vertical-multi', 'vertical-onepage') , false, '.top-hiding-parent');
			$s->addElement( ffOneElement::TYPE_TABLE_START );
				$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses(__('Custom Content - End of Header', 'ark')));
					$s->startSection('template-end-of-header');
						$this->_getElementGeneralOptions_MenuTemplate( $s );
					$s->endSection();
				$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );
			$s->addElement( ffOneElement::TYPE_TABLE_END );
		$sh->endHidingBox();


		/* HORIZONTAL WITHOUT FULLSCREEN - SEARCH */

		$sh->startHidingBox('design-type', array('header', 'header-center-aligned') , false, '.top-hiding-parent');
			$s->addElement( ffOneElement::TYPE_TABLE_START );
				$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses(__('Search Style', 'ark')));
					$s->startSection('search');
						$s->addOptionNL( ffOneOption::TYPE_SELECT, 'style', '', 'search-default')
							->addSelectValue(ark_wp_kses(__('None', 'ark')), '')
							->addSelectValue(ark_wp_kses(__('Search Default', 'ark')), 'search-default')
							->addSelectValue(ark_wp_kses(__('Search Classic', 'ark')), 'search-classic')
							->addSelectValue(ark_wp_kses(__('Search Fullscreen', 'ark')), 'search-fullscreen')
							->addSelectValue(ark_wp_kses(__('Search On Header', 'ark')), 'search-on-header')
							->addSelectValue(ark_wp_kses(__('Search Push', 'ark')), 'search-push')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Search', 'ark')) );
						;
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'placeholder', '', 'Search ...')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Search Input Placeholder Text', 'ark')) );
					$s->endSection();
				$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );
			$s->addElement( ffOneElement::TYPE_TABLE_END );
		$sh->endHidingBox();


		/* HORIZONTAL WITHOUT FULL SCREEN - GET IN TOUCH SIDEBAR */

		$sh->startHidingBox('design-type', $headerHorizontalArray , false, '.top-hiding-parent');
			$s->addElement( ffOneElement::TYPE_TABLE_START );
				$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses(__('Side Menu', 'ark')));
					$s->startSection('get-in-touch');
						$s->addOptionNL( ffOneOption::TYPE_CHECKBOX, 'show', ark_wp_kses(__('Show Side Menu', 'ark')), 0 );
						$s->addElement(ffOneElement::TYPE_NEW_LINE);
						$s->startHidingBox('show', 'checked');
							$s->startAdvancedToggleBox('side-menu-wrapper', ark_wp_kses(__('Header Side Menu', 'ark')) );
								$s->addElement(ffOneElement::TYPE_DESCRIPTION, '', ark_wp_kses(__('You can customize the content of your Side Menus via Templates in <a href="./edit.php?post_type=ff-template" target="_blank">Ark &gt; Templates</a>.', 'ark')) );
								$s->addElement(ffOneElement::TYPE_NEW_LINE);
								$s->addOptionNL( ffOneOption::TYPE_POST_SELECTOR, 'get-in-touch-id', '', '' )
									->addParam('post_type', 'ff-template')
									->addParam('load-dynamic', true)
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Side Menu Template', 'ark')) );
								;

								$s->addElement(ffOneElement::TYPE_NEW_LINE);
								$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'color', '', '')
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Close Button Color', 'ark')) );
								$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'color-hover', '', '')
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Close Button Color Hover', 'ark')) );

								$s->addElement(ffOneElement::TYPE_NEW_LINE);
								$s->addOptionNL( ffOneOption::TYPE_TEXT, 'get-in-touch-width', '', '')
									->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Custom Side Menu Width (in px)', 'ark')) )
								;
								$s->addElement(ffOneElement::TYPE_DESCRIPTION, '', ark_wp_kses(__('This option changes the width for Tablets, Laptops and Desktops. On Phones, the width is always full width.', 'ark')) );
							$s->endAdvancedToggleBox();
						$s->endHidingBox();
					$s->endSection();
				$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );
			$s->addElement( ffOneElement::TYPE_TABLE_END );
		$sh->endHidingBox();

		/* VERTICAL MENU - COPYRIGHT TEXT */

		$sh->startHidingBox('design-type', array('vertical-multi', 'vertical-onepage') , false, '.top-hiding-parent');
			$s->addElement( ffOneElement::TYPE_TABLE_START );
				$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses(__('Copyright', 'ark')));
					$s->addOption( ffOneOption::TYPE_CHECKBOX, 'show-copyright-text', ark_wp_kses(__('Show Copyright', 'ark')), 1 );
					$s->startHidingBox('show-copyright-text', 'checked');
						$s->addOptionNL( ffOneOption::TYPE_TEXT, 'copyright-text', '', 'Copyright &copy; 2016 FRESHFACE')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Copyright Text', 'ark')) )
						;
						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'copyright-text-color', '', '')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Copyright Text Color', 'ark')) );
					$s->endHidingBox();

				$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );
			$s->addElement( ffOneElement::TYPE_TABLE_END );
		$sh->endHidingBox();


		/* HEADER WRAPPER DESIGN OPTIONS */

		$s->addElement( ffOneElement::TYPE_TABLE_START );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '',  ark_wp_kses(__('Header Wrapper', 'ark')) );
				$s->startAdvancedToggleBox('header-design', ark_wp_kses(__('Header Wrapper', 'ark')) );

					$types = array(
						'static' => ark_wp_kses(__('Static Colors', 'ark')),
						'fixed'  => ark_wp_kses(__('Fixed Colors', 'ark')),
						'mobile' => ark_wp_kses(__('Mobile Colors', 'ark')),
					);

					$s->addElement( ffOneElement::TYPE_HTML, '', '<div class="row">' );

						foreach( $types as $type => $title ){
							$s->addElement( ffOneElement::TYPE_HTML, '', '<div class="col-lg-4">' );

							if( 'fixed' == $type ){
								$sh->startHidingBox('design-type', $headerHorizontalArray , false, '.top-hiding-parent');
							}

								$s->addElement( ffOneElement::TYPE_HTML, '', '<h4 class="column-title">'.$title.'</h4>' );
								$s->startSection($type);
									$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', '')
										->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Background', 'ark')) );
									$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border-color', '', '#e8e8ec')
										->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Border', 'ark')) );
									$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'shadow-color', '', 'rgba(0,0,50,0.09)')
										->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Shadow', 'ark')) );
								$s->endSection();
							$s->addElement( ffOneElement::TYPE_HTML, '', '</div>' );

							if( 'fixed' == $type ){
								$sh->endHidingBox();
							}

						}

					$s->addElement( ffOneElement::TYPE_HTML, '', '</div>' );

				$s->endAdvancedToggleBox();

				$sh->startHidingBox('design-type', $headerHorizontalSimpleArray , false, '.top-hiding-parent');

					$s->startAdvancedToggleBox('header-design-inner', ark_wp_kses(__('Header Wrapper (without Topbar)', 'ark')) );
						$s->addElement( ffOneElement::TYPE_HTML, '', '<div style="display:none">' );
							$s->addOptionNL( ffOneOption::TYPE_TEXT, '_filler_', '', 1);
						$s->addElement( ffOneElement::TYPE_HTML, '', '</div>' );
						$s->addElement(ffOneElement::TYPE_DESCRIPTION, '', ark_wp_kses(__('If you wish to add Background, click on the top right corner pencil icon in this box and click on tab box model.', 'ark')) );

					$s->endAdvancedToggleBox();
				$sh->endHidingBox();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );
		$s->addElement( ffOneElement::TYPE_TABLE_END );


		/* HEADER TOP MENU DESIGN OPTIONS - HORIZONTAL */

		$s->addElement( ffOneElement::TYPE_TABLE_START );
			$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '',  ark_wp_kses(__('Header Content', 'ark')) );



				/* TOP MENU ITEMS */

				$s->startAdvancedToggleBox('ark-first-level-menu', ark_wp_kses(__('Top Level Menu Items', 'ark')) );

					$settings = array(
						'static' => array(
							ark_wp_kses(__('Static Colors', 'ark')),
							null,
							$headerVerticalArray,
						),
						'fixed'  => array(
							ark_wp_kses(__('Fixed Colors', 'ark')),
							$headerHorizontalArray,
							null,
						),
						'mobile' => array(
							ark_wp_kses(__('Mobile Colors', 'ark')),
							null,
							array( 'header', 'header-center-aligned', 'vertical-multi', 'vertical-onepage' ),
						),
					);

					$s->addElement( ffOneElement::TYPE_HTML, '', '<div class="row">' );

						foreach( $settings as $type => $o ){
							$title = $o[0];
							$design_type = $o[1];
							$design_type_border = $o[2];

							$s->addElement( ffOneElement::TYPE_HTML, '', '<div class="col-lg-4">' );

								if( $design_type ){
									$sh->startHidingBox('design-type', $design_type , false, '.top-hiding-parent');
								}

									$s->addElement( ffOneElement::TYPE_HTML, '', '<h4 class="column-title">'.$title.'</h4>' );
									$s->startSection($type);
										$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'color', '', '')
											->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Text', 'ark')) );
										$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', '')
											->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Background', 'ark')) );

										$s->addElement( ffOneElement::TYPE_NEW_LINE );

										$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'color-current', '', '')
											->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Text Current', 'ark')) );
										$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color-current', '', '')
											->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Background Current', 'ark')) );

										$s->addElement( ffOneElement::TYPE_NEW_LINE );

										$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'color-hover', '', '')
											->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Text Hover', 'ark')) );
										$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color-hover', '', '')
											->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Background Hover', 'ark')) );

										if( null != $design_type_border ){
											$sh->startHidingBox('design-type', $design_type_border , false, '.top-hiding-parent');
												$s->addElement( ffOneElement::TYPE_NEW_LINE );
												$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'border', '', '#ebeef6')
													->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Border', 'ark')) );
											$sh->endHidingBox();
										}

									$s->endSection();

								if( $design_type ){
									$sh->endHidingBox();
								}

							$s->addElement( ffOneElement::TYPE_HTML, '', '</div>' );
						}

					$s->addElement( ffOneElement::TYPE_HTML, '', '</div>' );

				$s->endAdvancedToggleBox();



				/* TOP LEVEL ICONS */

				$s->startAdvancedToggleBox('ark-first-level-menu-icons', ark_wp_kses(__('Top Level Icons', 'ark')) );

					$settings = array(
						'static' => ark_wp_kses(__('Static Colors', 'ark')),
						'fixed'  => ark_wp_kses(__('Fixed Colors', 'ark')),
						'mobile' => ark_wp_kses(__('Mobile Colors', 'ark')),
					);

					$s->addElement( ffOneElement::TYPE_HTML, '', '<div class="row">' );
						foreach( $settings as $type => $title ){
							$s->addElement( ffOneElement::TYPE_HTML, '', '<div class="col-lg-4">' );
								$s->addElement( ffOneElement::TYPE_HTML, '', '<h4 class="column-title">'.$title.'</h4>' );
								$s->startSection($type);
									$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'color', '', '')
										->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Text', 'ark')) );
									$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'color-hover', '', '')
										->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Text Hover', 'ark')) );
								$s->endSection();
							$s->addElement( ffOneElement::TYPE_HTML, '', '</div>' );
						}
					$s->addElement( ffOneElement::TYPE_HTML, '', '</div>' );
				$s->endAdvancedToggleBox();



				/* HEADER FULLSCREEN */

				$sh->startHidingBox('design-type', array('fullscreen') , false, '.top-hiding-parent');
					$s->startAdvancedToggleBox('fullscreen-menu-design', ark_wp_kses(__('Full Screen Navigation Wrapper', 'ark')) );

						$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'menu-bg-color', '', '')
							->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Full Screen Navigation Wrapper Background Color', 'ark')) );
						$s->addElement( ffOneElement::TYPE_NEW_LINE );

						$s->addElement(ffOneElement::TYPE_DESCRIPTION, '', ark_wp_kses(__('NOTE: Colors for Top Level Full Screen Navigation Items are taken from <strong>Top Level Items > Mobile Colors</strong> because the Full Screen Navigation is essentially a mobile navigation.', 'ark')) );

					$s->endAdvancedToggleBox();
				$sh->endHidingBox();


				/* HEADER SUB MENU DESIGN OPTIONS */

				$s->startAdvancedToggleBox('ark-sub-level-menu', ark_wp_kses(__('Submenu Items', 'ark')) );

					$settings = array(
						'static' => array(
							ark_wp_kses(__('Static Colors', 'ark')),
							// everything without fullscreen
							array('header', 'header-center-aligned', 'vertical-multi', 'vertical-onepage'),
						),
						'fixed'  => array(
							ark_wp_kses(__('Fixed Colors', 'ark')),
							$headerHorizontalSimpleArray,
						),
						'mobile' => array(
							ark_wp_kses(__('Mobile Colors', 'ark')),
							null,
						),
					);

					$s->addElement( ffOneElement::TYPE_HTML, '', '<div class="row">' );

						foreach( $settings as $type => $o ){
							$title = $o[0];
							$design_type = $o[1];

							$s->addElement( ffOneElement::TYPE_HTML, '', '<div class="col-lg-4">' );

								if( $design_type ){
									$sh->startHidingBox('design-type', $design_type , false, '.top-hiding-parent');
								}
									$s->addElement( ffOneElement::TYPE_HTML, '', '<h4 class="column-title">'.$title.'</h4>' );
									$s->startSection($type);
										$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'color', '', '')
											->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Text', 'ark')) );
										$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', '')
											->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Background', 'ark')) );

										$s->addElement( ffOneElement::TYPE_NEW_LINE );

										$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'color-current', '', '')
											->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Text Current', 'ark')) );
										$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color-current', '', '')
											->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Background Current', 'ark')) );

										$s->addElement( ffOneElement::TYPE_NEW_LINE );

										$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'color-hover', '', '')
											->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Text Hover', 'ark')) );
										$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color-hover', '', '')
											->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Background Hover', 'ark')) );

										if( $type != 'mobile' ){
											$sh->startHidingBox('design-type', $headerHorizontalSimpleArray , false, '.top-hiding-parent');
												$s->addElement( ffOneElement::TYPE_NEW_LINE );
												$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'shadow-color', '', 'rgba(0,0,0,0.06)')
													->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Submenu Shadow', 'ark')) );
											$sh->endHidingBox();
										}
									$s->endSection();
								if( $design_type ){
									$sh->endHidingBox();
								}

							$s->addElement( ffOneElement::TYPE_HTML, '', '</div>' );

						}

					$s->addElement( ffOneElement::TYPE_HTML, '', '</div>' );

				$s->endAdvancedToggleBox();

			$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );
		$s->addElement( ffOneElement::TYPE_TABLE_END );

		$sh->startHidingBox('design-type', array('header', 'header-center-aligned', 'vertical-multi', 'vertical-onepage') , false, '.top-hiding-parent');
			$s->addElement( ffOneElement::TYPE_TABLE_START );
				$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses(__('WooCommerce Shopping Cart Menu Icon', 'ark')));
					$s->addElement(ffOneElement::TYPE_DESCRIPTION, '', ark_wp_kses(__('The options below work only if WooCommerce plugin is installed and activated.', 'ark')) );

					$s->addOptionNL( ffOneOption::TYPE_SELECT, 'woocommerce-shopping-cart', '', 'show')
						->addSelectValue(ark_wp_kses(__('Show WooCommerce Shopping Cart', 'ark')), 'show')
						->addSelectValue(ark_wp_kses(__('Hide WooCommerce Shopping Cart', 'ark')), 'hide');

					$s->addElement(ffOneElement::TYPE_NEW_LINE);

					$s->startAdvancedToggleBox('cart-menu-item', ark_wp_kses(__('WooCommerce Shopping Cart Menu Icon', 'ark')) );
						$s->addElement(ffOneElement::TYPE_DESCRIPTION, '', ark_wp_kses(__('NOTE: Click on the <i class="dashicons dashicons-edit"></i> pencil icon in the top-right corner of this box to customize WooCommerce Shopping Cart Menu Icon.', 'ark')) );

						$s->addElement( ffOneElement::TYPE_NEW_LINE );
						$s->addElement( ffOneElement::TYPE_NEW_LINE );

						$types = array(
							'static' => ark_wp_kses(__('Static Colors', 'ark')),
							'fixed'  => ark_wp_kses(__('Fixed Colors', 'ark')),
							'mobile' => ark_wp_kses(__('Mobile Colors', 'ark')),
						);

						$s->addElement( ffOneElement::TYPE_HTML, '', '<div class="row">' );

							foreach( $types as $type => $title ){
								$s->addElement( ffOneElement::TYPE_HTML, '', '<div class="col-lg-4">' );

								if( 'fixed' == $type ){
									$sh->startHidingBox('design-type', $headerHorizontalArray , false, '.top-hiding-parent');
								}
									$s->startSection($type);

										$s->startSection('link');
											$s->addElement( ffOneElement::TYPE_HTML, '', '<h4 class="column-title">'.$title.' - '.ark_wp_kses(__('Link', 'ark')).'</h4>' );
											$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'color', '', '')
												->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Text', 'ark')) );
											$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', '')
												->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Background', 'ark')) );
											$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'color-hover', '', '')
												->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Text Hover', 'ark')) );
											$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color-hover', '', '')
												->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Background Hover', 'ark')) );
										$s->endSection();

										$s->addElement( ffOneElement::TYPE_NEW_LINE );

										$s->startSection('count');
											$s->addElement( ffOneElement::TYPE_HTML, '', '<h4 class="column-title">'.$title.' - '.ark_wp_kses(__('Item Count', 'ark')).'</h4>' );
											$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'color', '', '#FFFFFF')
												->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Text', 'ark')) );
											$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', '[1]')
												->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Background', 'ark')) );
											$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'color-hover', '', '#FFFFFF')
												->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Text Hover', 'ark')) );
											$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color-hover', '', '[1]')
												->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Background Hover', 'ark')) );
										$s->endSection();

									$s->endSection();
								$s->addElement( ffOneElement::TYPE_HTML, '', '</div>' );

								if( 'fixed' == $type ){
									$sh->endHidingBox();
								}

							}

						$s->addElement( ffOneElement::TYPE_HTML, '', '</div>' );
					$s->endAdvancedToggleBox();
				$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );
			$s->addElement( ffOneElement::TYPE_TABLE_END );
		$sh->endHidingBox();

		$sh->startHidingBox('design-type', array('header', 'header-center-aligned', 'vertical-multi', 'vertical-onepage') , false, '.top-hiding-parent');
			$s->addElement( ffOneElement::TYPE_TABLE_START );
				$s->addElement( ffOneElement::TYPE_TABLE_DATA_START, '', ark_wp_kses(__('WooCommerce Shopping Cart Submenu', 'ark')));
					$s->addElement(ffOneElement::TYPE_DESCRIPTION, '', ark_wp_kses(__('The options below work only if WooCommerce plugin is installed and activated.', 'ark')) );

					$s->addOptionNL( ffOneOption::TYPE_SELECT, 'woocommerce-shopping-cart-type-xs', '', 'ark-cart-left-side-xs')
						->addSelectValue(ark_wp_kses(__('On the left side', 'ark')), 'ark-cart-left-side-xs')
						->addSelectValue(ark_wp_kses(__('On the right side', 'ark')), 'ark-cart-right-side-xs')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Submenu position on Tablet (SM) and Mobile (XS)', 'ark')) )
					;

					$s->addElement(ffOneElement::TYPE_DESCRIPTION, '', ark_wp_kses(__('Width is set to 100% on mobile devices.', 'ark')) );

					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'cart-width-sm', '', '')
						->addParam('placeholder', '256')
						->addParam('short', true)
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Width on Tablet (SM) in px', 'ark')) )
					;

					$s->addElement( ffOneElement::TYPE_NEW_LINE );

					$s->addOptionNL( ffOneOption::TYPE_SELECT, 'woocommerce-shopping-cart-type', '', 'ark-cart-classic')
						->addSelectValue(ark_wp_kses(__('Classic (Horizontal Menu only)', 'ark')), 'ark-cart-classic')
						->addSelectValue(ark_wp_kses(__('On the left side', 'ark')), 'ark-cart-left-side')
						->addSelectValue(ark_wp_kses(__('On the right side', 'ark')), 'ark-cart-right-side')
						->addSelectValue(ark_wp_kses(__('Next to the Vertical menu (Vertical Menu Only)', 'ark')), 'ark-cart-next-to')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Submenu Position on Laptop (MD) and Desktop (LG)', 'ark')) )
					;

					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'cart-width-md', '', '')
						->addParam('placeholder', '256')
						->addParam('short', true)
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Width on Laptop (MD) in px', 'ark')) )
					;

					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'cart-width-lg', '', '')
						->addParam('placeholder', 'Inherit')
						->addParam('short', true)
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Width on Desktop (LG) in px', 'ark')) )
					;

					$s->addElement( ffOneElement::TYPE_NEW_LINE );

					$s->startAdvancedToggleBox('cart-submenu', ark_wp_kses(__('WooCommerce Shopping Cart Submenu', 'ark')) );
						$types = array(
							'static' => ark_wp_kses(__('Static Colors', 'ark')),
							'fixed'  => ark_wp_kses(__('Fixed Colors', 'ark')),
							'mobile' => ark_wp_kses(__('Mobile Colors', 'ark')),
						);

						$s->addElement( ffOneElement::TYPE_HTML, '', '<div class="row">' );

							foreach( $types as $type => $title ){
								$s->addElement( ffOneElement::TYPE_HTML, '', '<div class="col-lg-4">' );

								if( 'fixed' == $type ){
									$sh->startHidingBox('design-type', $headerHorizontalArray , false, '.top-hiding-parent');
								}
									$s->startSection($type);
										$s->addElement( ffOneElement::TYPE_HTML, '', '<h4 class="column-title">'.$title.'</h4>' );
										$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'bg-color', '', '#FFFFFF')
											->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Background', 'ark')) );
									$s->endSection();
								$s->addElement( ffOneElement::TYPE_HTML, '', '</div>' );

								if( 'fixed' == $type ){
									$sh->endHidingBox();
								}

							}

						$s->addElement( ffOneElement::TYPE_HTML, '', '</div>' );

						$sh->startHidingBox('design-type', $headerHorizontalArray , false, '.top-hiding-parent');
							$s->startSection('backdrop');
								$s->addElement( ffOneElement::TYPE_HTML, '', '<div class="row">' );
									$s->addElement( ffOneElement::TYPE_HTML, '', '<div class="col-lg-4">' );
										$s->startSection('static');
											$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'backdrop-color', '', 'rgba(0, 0, 0, 0)')
												->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Backdrop', 'ark')) );
										$s->endSection();
									$s->addElement( ffOneElement::TYPE_HTML, '', '</div>' );
									$s->addElement( ffOneElement::TYPE_HTML, '', '<div class="col-lg-4">' );
										$s->startSection('fixed');
											$s->addOptionNL( ffOneOption::TYPE_COLOR_PICKER_WITH_LIB, 'backdrop-color', '', 'rgba(0, 0, 0, 0)')
												->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Backdrop', 'ark')) );
										$s->endSection();
									$s->addElement( ffOneElement::TYPE_HTML, '', '</div>' );
								$s->addElement( ffOneElement::TYPE_HTML, '', '</div>' );
							$s->endSection();
						$sh->endHidingBox();


					$s->endAdvancedToggleBox();

				$s->addElement( ffOneElement::TYPE_TABLE_DATA_END );
			$s->addElement( ffOneElement::TYPE_TABLE_END );
		$sh->endHidingBox();

	$s->addElement( ffOneElement::TYPE_HTML, '', '</div>' ); // .top-hiding-parent


	}

	protected function _beforeRenderingAdminWrapper( ffOptionsQueryDynamic $query, $content, ffMultiAttrHelper $multiAttrHelper, ffStdClass $otherData ) {

	}

	/**
	 * @param $img stdClass
	 * @param $default string
	 * @return string
	 */
	protected function _getSingleLogoURL( $img, $default ){
		$url = $img->url;
		if( empty( $url ) ){
			return $default;
		} else {
			return $url;
		}
	}

	/**
	 * @param $class string
	 * @param $src string
	 */
	protected function _printSingleLogoImg( $class, $src ){
		echo '<img class="navbar-logo-img '.$class.'" src="';
		echo esc_url( $src );
		echo '" alt="';
		echo esc_attr( get_bloginfo('name') );
		echo '">';
	}

	protected function _getLogoHeaderSizes( $group, $logo_url, $w, $h, $queryLogo ){

		$ret = new ffStdClass();
		$imgInform = ffContainer()->getGraphicFactory()->getImageInformator();

		$imgInform->setImageUrl( $logo_url );
		$type = $queryLogo->getWithoutComparationDefault($group . ' type', 'default');

		$ret->headerHeight = $w;
		$ret->logoHeight = $h;
		$ret->imageDimensions = $imgInform->getImageDimensions();

		if( $type == 'adjust-to-logo' || $type == 'custom') {
			$ret->logoHeight = $queryLogo->getWithoutComparationDefault($group . ' custom-logo-height', '');

			if( empty( $ret->logoHeight ) )  {
				$ret->logoHeight = $ret->imageDimensions->height;
			}

			$ret->headerHeight = $ret->logoHeight + 45;
		}

		if( $type == 'custom' ) {
			$ret->headerHeight = $queryLogo->getWithoutComparationDefault($group . ' custom-header-height', '');
		}

		$ret->logoWidth = $ret->imageDimensions->aspectRatio * $ret->logoHeight;

		return $ret;
	}

	/**
	 * @param $query ffOptionsQueryDynamic
	 */
	protected function _renderLogo( $query ){

		$show_logo = 0;
		if( $query->getWithoutComparationDefault('logo show', 1) ) {
			$show_logo = 1;
		}

		$hash = md5( '1.5.1 version ' . $query->getHash( 'logo' ) . $query->getHash('design-type'));

		$namespace = 'elementsCache';
		$cache = ffContainer()->getDataStorageCache();

		$html = $cache->getOptionWithHash( $namespace, 'header-logo-html', $hash );

		if( $html != null ) {
			$css = $cache->getOptionWithHash( $namespace, 'header-logo-css', $hash );

			echo $html;
			$this->_getAssetsRenderer()->createCssRule(false)
				->setContent( $css );
			return;
		}


		ob_start();
		$queryLogo = $query->get('logo');

		$this->_advancedToggleBoxStart( $query, 'logo' );
		echo '<div class="navbar-logo">';

		$logo_url = get_home_url();
		if( $queryLogo->getWithoutComparationDefault('has-custom-logo-url', 0) ) {
			$logo_url = $queryLogo->getWithoutComparationDefault('custom-logo-url', get_home_url() ) ;
		}

		if( defined('ICL_SITEPRESS_VERSION') ) {
			echo '<a class="navbar-logo-wrap" href="' . $logo_url . '">';
		}else{
			echo '<a class="navbar-logo-wrap" href="' . $logo_url . '/">';
		}

		// STATIC

		$static_logo_url = $this->_getSingleLogoURL( $query->getImage('logo image'), get_template_directory_uri().'/assets/img/logo-default-white.png' );
		if( $show_logo ){
			$this->_printSingleLogoImg('navbar-logo-img-normal', $static_logo_url);
		}

		$desktopBeforeScroll = $this->_getLogoHeaderSizes( 'desktop-top-height', $static_logo_url, 90, 45, $queryLogo );

		// FIXED

		$desktopAfterScroll = $this->_getLogoHeaderSizes( 'desktop-top-height', $static_logo_url, 70, 45, $queryLogo );
		if( ! in_array( $query->get('design-type'), array( 'vertical-multi', 'vertical-onepage' ) ) ) {
			$fixed_logo_url = $this->_getSingleLogoURL( $query->getImage('logo image-desktop-fixed'), get_template_directory_uri().'/assets/img/logo-default.png' );
			if( $show_logo ){
				$this->_printSingleLogoImg('navbar-logo-img-fixed', $fixed_logo_url);
			}
			$desktopAfterScroll = $this->_getLogoHeaderSizes( 'desktop-scroll-height', $fixed_logo_url, 70, 45, $queryLogo );
		}

		// MOBILE

		$mobile_logo_url = $this->_getSingleLogoURL( $query->getImage('logo image-mobile'), get_template_directory_uri().'/assets/img/logo-default.png' );
		if( $show_logo ){
			$this->_printSingleLogoImg('navbar-logo-img-mobile', $mobile_logo_url);
		}
		$mobileBeforeScroll = $this->_getLogoHeaderSizes( 'mobile-height', $mobile_logo_url, 90, 45, $queryLogo );

		// TABLET

		if( $query->queryExists('logo image-tablet') ){
			$tablet_logo_url = $this->_getSingleLogoURL( $query->getImage('logo image-tablet'), $mobile_logo_url );
			if( $show_logo ){
				$this->_printSingleLogoImg('navbar-logo-img-tablet', $tablet_logo_url);
			}
			if( $query->getImage('logo image-tablet') ){
				$tabletBeforeScroll = $this->_getLogoHeaderSizes( 'tablet-height', $tablet_logo_url, 90, 45, $queryLogo );
			}else{
				$tabletBeforeScroll = $this->_getLogoHeaderSizes( 'mobile-height', $mobile_logo_url, 90, 45, $queryLogo );
			}
		}else{
			$tablet_logo_url = $mobile_logo_url;
			if( $show_logo ){
				$this->_printSingleLogoImg('navbar-logo-img-tablet', $tablet_logo_url);
			}
			$tabletBeforeScroll = $this->_getLogoHeaderSizes( 'mobile-height', $mobile_logo_url, 90, 45, $queryLogo );
		}


		echo '</a>';
		echo '<span class="hidden header-height-info" data-desktopBeforeScroll="'.$desktopBeforeScroll->headerHeight.'" data-desktopAfterScroll="'.$desktopAfterScroll->headerHeight.'" data-mobileBeforeScroll="'.$mobileBeforeScroll->headerHeight.'" data-tabletBeforeScroll="'.$tabletBeforeScroll->headerHeight.'"></span>';
		echo '</div>';
		$this->_advancedToggleBoxEnd($query, 'logo');

		$queryLogo = $query->get('logo');

		$data = new ffStdClass();
		$data->desktopLogoJumpOut = $queryLogo->getWithoutComparationDefault('desktop-logo-jump-out', 0);

		$css = $this->_getHeaderHeightCss( $data, $desktopBeforeScroll, $desktopAfterScroll, $mobileBeforeScroll, $tabletBeforeScroll );

		$html = ob_get_contents();
		ob_end_clean();

		echo $html;

		$this->_getAssetsRenderer()->createCssRule(false)
			->setContent( $css );

		$cache->setOptionWithHash( $namespace, 'header-logo-css', $css, $hash );
		$cache->setOptionWithHash( $namespace, 'header-logo-html', $html, $hash );
		}
	

	private function _getHeaderHeightCss( $data, $desktopBeforeScroll, $desktopAfterScroll, $mobileBeforeScroll, $tabletBeforeScroll ) {
		$headerPillsHeight = 30;
		$mobileNavToggleBtnHeight = 25;
		$tabletNavToggleBtnHeight = 25;
		$headerFullScreenNavToggleBtnHeight = 30;
		$mobileTopbarToggleBtnHeight = 20;
		$tabletTopbarToggleBtnHeight = 20;

		/* VARIABLES THAT CAN BE CHANGED BY USER - BELOW ARE RANDOM VALUES, NOT DEFAULT VALUES ! */

		$desktopBefScrHeadHeight = $desktopBeforeScroll->headerHeight;//91; // *****
		$desktopBefScrLogoHeight = $desktopBeforeScroll->logoHeight;//45; // *****

		$desktopAftScrHeadHeight = $desktopAfterScroll->headerHeight; // *****
		$desktopAftScrLogoHeight = $desktopAfterScroll->logoHeight; // *****

		$mobileBefScrHeadHeight = $mobileBeforeScroll->headerHeight;
		$mobileBefScrLogoHeight = $mobileBeforeScroll->logoHeight;

		$tabletBefScrHeadHeight = $tabletBeforeScroll->headerHeight;
		$tabletBefScrLogoHeight = $tabletBeforeScroll->logoHeight;





ob_start();
?>

/* RESETS - DO NOT CHANGE DYNAMICALLY */

header .navbar-logo,
header.header-shrink .navbar-logo {
	line-height: 0 !important;
}

header .navbar-logo-wrap img {
	max-height: none !important;
}

header .navbar-logo .navbar-logo-wrap {
	transition-duration: 400ms;
	transition-property: all;
	transition-timing-function: cubic-bezier(0.7, 1, 0.7, 1);
}

@media (max-width: 991px){
	header .navbar-logo .navbar-logo-img {
		max-width: none !important;
	}
}

@media (max-width: 991px){
	.header .navbar-actions .navbar-actions-shrink {
		max-height: none;
	}
}

@media (min-width: 992px){
	.header .navbar-actions .navbar-actions-shrink {
		max-height: none;
	}
}

@media (min-width: 992px) {
	.header-shrink.ark-header .navbar-actions .navbar-actions-shrink {
		max-height: none;
	}
}

@media (max-width: 991px){
	.header-fullscreen .header-fullscreen-col {
		width: calc(100% - 60px);
	}

	.header-fullscreen .header-fullscreen-col.header-fullscreen-nav-actions-left {
		width: 30px;
	}
}

.ark-header .topbar-toggle-trigger {
	padding: 0;
}

header .navbar-logo .navbar-logo-wrap {
	transition-property: width, height, opacity, padding, margin-top, margin-bottom;
}

/* DYNAMIC OVERWRITES */

.ark-header .navbar-logo .navbar-logo-wrap {
	line-height: 1px;
}

@media (min-width: 992px) {
	.wrapper>.wrapper-top-space {
	height: <?php echo $desktopBefScrHeadHeight; ?>px;
	}


	.ark-header .navbar-logo .navbar-logo-wrap {
		padding-top: <?php echo max(($desktopBefScrHeadHeight-$desktopBefScrLogoHeight)/2,0); ?>px;
		padding-bottom: <?php echo max(($desktopBefScrHeadHeight-$desktopBefScrLogoHeight)/2,0); ?>px;
	}

}

@media (min-width: 992px) {
	.header-shrink.ark-header .navbar-logo .navbar-logo-wrap {
		padding-top: <?php echo max(($desktopAftScrHeadHeight-$desktopAftScrLogoHeight)/2,0); ?>px;
		padding-bottom: <?php echo max(($desktopAftScrHeadHeight-$desktopAftScrLogoHeight)/2,0); ?>px;
	}
}

@media (min-width: 992px) {
	.ark-header .navbar-nav .nav-item {
		line-height: <?php echo $desktopBefScrHeadHeight; ?>px;
	}
	.ark-header .navbar-nav .nav-item ul {
		line-height: 1.42857143;
	}
}

@media (min-width: 992px) {
	header .navbar-logo-wrap img {
		height: <?php echo $desktopBefScrLogoHeight; ?>px !important;
	}
}

@media (min-width: 992px) {
	header.header-shrink .navbar-logo-wrap img {
		height: <?php echo $desktopAftScrLogoHeight; ?>px !important;
	}
}

.ark-header .navbar-actions .navbar-actions-shrink {
	line-height: <?php echo $desktopBefScrHeadHeight-1; ?>px;	
}

@media (min-width: 992px){
	.header-shrink.ark-header .navbar-actions .navbar-actions-shrink {
		line-height: <?php echo $desktopAftScrHeadHeight-1; ?>px;
	}
}

@media (min-width: 992px) {
	.ark-header.header-no-pills .navbar-nav .nav-item-child {
		line-height: <?php echo $desktopBefScrHeadHeight; ?>px;
	}
}

@media (min-width: 992px) {
	.ark-header.header-no-pills.header-shrink .navbar-nav .nav-item-child {
		line-height: <?php echo $desktopAftScrHeadHeight; ?>px;
	}
}

@media (min-width: 992px) {
	.ark-header.header-pills .navbar-nav .nav-item-child {
		margin-top: <?php echo ($desktopBefScrHeadHeight-$headerPillsHeight)/2; ?>px;
		margin-bottom: <?php echo ($desktopBefScrHeadHeight-$headerPillsHeight)/2; ?>px;
	}
}

@media (min-width: 992px) {
	.ark-header.header-pills.header-shrink .navbar-nav .nav-item-child {
		margin-top: <?php echo ($desktopAftScrHeadHeight-$headerPillsHeight)/2; ?>px;
		margin-bottom: <?php echo ($desktopAftScrHeadHeight-$headerPillsHeight)/2; ?>px;
	}
}

@media (max-width: 767px) {
	.header-fullscreen .header-fullscreen-nav-actions-left,
	.header-fullscreen .header-fullscreen-nav-actions-right {
		padding-top: <?php echo ($mobileBefScrHeadHeight-$headerFullScreenNavToggleBtnHeight)/2; ?>px;
		padding-bottom: <?php echo ($mobileBefScrHeadHeight-$headerFullScreenNavToggleBtnHeight)/2; ?>px;
	}
}

@media (min-width: 768px) and (max-width: 991px) {
	.header-fullscreen .header-fullscreen-nav-actions-left,
	.header-fullscreen .header-fullscreen-nav-actions-right {
		padding-top: <?php echo ($tabletBefScrHeadHeight-$headerFullScreenNavToggleBtnHeight)/2; ?>px;
		padding-bottom: <?php echo ($tabletBefScrHeadHeight-$headerFullScreenNavToggleBtnHeight)/2; ?>px;
	}
}


@media (min-width: 992px) {
	.header-fullscreen .header-fullscreen-nav-actions-left,
	.header-fullscreen .header-fullscreen-nav-actions-right {
		padding-top: <?php echo ($desktopBefScrHeadHeight-$headerFullScreenNavToggleBtnHeight)/2; ?>px;
		padding-bottom: <?php echo ($desktopBefScrHeadHeight-$headerFullScreenNavToggleBtnHeight)/2; ?>px;
	}
}

@media (min-width: 992px) {
	.header-shrink.header-fullscreen .header-fullscreen-nav-actions-left,
	.header-shrink.header-fullscreen .header-fullscreen-nav-actions-right {
		padding-top: <?php echo ($desktopAftScrHeadHeight-$headerFullScreenNavToggleBtnHeight)/2; ?>px;
		padding-bottom: <?php echo ($desktopAftScrHeadHeight-$headerFullScreenNavToggleBtnHeight)/2; ?>px;
	}
}

.ark-header.auto-hiding-navbar.nav-up {
	top: -<?php echo $desktopAftScrHeadHeight+10; ?>px;
}

.ark-header.auto-hiding-navbar.nav-up.header-has-topbar {
	top: -100%
}

.search-on-header-field .search-on-header-input {
	height: <?php echo $desktopBefScrHeadHeight-2; ?>px;
}

.header-shrink .search-on-header-field .search-on-header-input {
	height: <?php echo $desktopAftScrHeadHeight-2; ?>px;
}

@media (max-width: 767px) {
	.search-on-header-field .search-on-header-input {
		height: <?php echo $mobileBefScrHeadHeight; ?>px;
	}
}

@media (min-width: 768px) and (max-width: 991px) {
	.search-on-header-field .search-on-header-input {
		height: <?php echo $tabletBefScrHeadHeight; ?>px;
	}
}

@media (max-width: 767px) {
	.ark-header .topbar-toggle-trigger {
		height: <?php echo $mobileTopbarToggleBtnHeight; ?>px;
		margin-top: <?php echo ($mobileBefScrHeadHeight-$mobileTopbarToggleBtnHeight)/2; ?>px;
		margin-bottom: <?php echo ($mobileBefScrHeadHeight-$mobileTopbarToggleBtnHeight)/2; ?>px;
	}
}

@media (min-width: 768px) and (max-width: 991px) {
	.ark-header .topbar-toggle-trigger {
		height: <?php echo $tabletTopbarToggleBtnHeight; ?>px;
		margin-top: <?php echo ($tabletBefScrHeadHeight-$tabletTopbarToggleBtnHeight)/2; ?>px;
		margin-bottom: <?php echo ($tabletBefScrHeadHeight-$tabletTopbarToggleBtnHeight)/2; ?>px;
	}
}

/* HORIZONTAL - TABLET */

@media (min-width: 768px) and (max-width: 991px) {
	.ark-header .navbar-toggle{
		margin-top: <?php echo ($tabletBefScrHeadHeight-$tabletNavToggleBtnHeight)/2; ?>px;
		margin-bottom: <?php echo ($tabletBefScrHeadHeight-$tabletNavToggleBtnHeight)/2; ?>px;
	}
}

@media (min-width: 768px) and (max-width: 991px) {
	.ark-header .navbar-actions .navbar-actions-shrink {
		line-height: <?php echo $tabletBefScrHeadHeight; ?>px;
	}
}

@media (min-width: 768px) and (max-width: 991px) {
	header .navbar-logo-wrap img {
		height: <?php echo $tabletBefScrLogoHeight; ?>px !important;
	}
}

@media (min-width: 768px) and (max-width: 991px) {
	.wrapper-top-space-xs {
		height: <?php echo $tabletBefScrHeadHeight; ?>px;
	}

	.ark-header .navbar-logo .navbar-logo-wrap {
		padding-top: <?php echo ($tabletBefScrHeadHeight-$tabletBefScrLogoHeight)/2; ?>px;
		padding-bottom: <?php echo ($tabletBefScrHeadHeight-$tabletBefScrLogoHeight)/2; ?>px;
	}
}

/* HORIZONTAL - MOBILE */

@media (max-width: 767px) {
	.ark-header .navbar-toggle{
		margin-top: <?php echo ($mobileBefScrHeadHeight-$mobileNavToggleBtnHeight)/2; ?>px;
		margin-bottom: <?php echo ($mobileBefScrHeadHeight-$mobileNavToggleBtnHeight)/2; ?>px;
	}
}

@media (max-width: 767px) {
	.ark-header .navbar-actions .navbar-actions-shrink {
		line-height: <?php echo $mobileBefScrHeadHeight; ?>px;
	}
}

@media (max-width: 767px) {
	header .navbar-logo-wrap img {
		height: <?php echo $mobileBefScrLogoHeight; ?>px !important;
	}
}

@media (max-width: 767px) {
	.wrapper-top-space-xs {
		height: <?php echo $mobileBefScrHeadHeight; ?>px;
	}

	.ark-header .navbar-logo .navbar-logo-wrap {
		padding-top: <?php echo ($mobileBefScrHeadHeight-$mobileBefScrLogoHeight)/2; ?>px;
		padding-bottom: <?php echo ($mobileBefScrHeadHeight-$mobileBefScrLogoHeight)/2; ?>px;
	}
}

/* FULLSCREEN */
.ark-header.header-fullscreen .navbar-logo{
	min-height: 1px !important;
}

.ark-header.header-fullscreen .navbar-logo-wrap{
	width: 100% !important;
}

@media (max-width: 991px) {
	.ark-header.header-fullscreen .header-fullscreen-nav-actions-right{
		width: 30px;
	}
}


/* VERTICAL */

@media (max-width: 767px) {
	.header-vertical .navbar-toggle {
		margin-top: <?php echo ($mobileBefScrHeadHeight-$mobileNavToggleBtnHeight)/2; ?>px;
		margin-bottom: <?php echo ($mobileBefScrHeadHeight-$mobileNavToggleBtnHeight)/2; ?>px;
	}
}

@media (max-width: 767px) {
	.header-section-scroll .navbar-toggle {
		margin-top: <?php echo ($mobileBefScrHeadHeight-$mobileNavToggleBtnHeight)/2; ?>px;
		margin-bottom: <?php echo ($mobileBefScrHeadHeight-$mobileNavToggleBtnHeight)/2; ?>px;
	}
}

@media (max-width: 767px) {
	header.ark-header-vertical .navbar-logo .navbar-logo-wrap {
		padding-top: <?php echo ($mobileBefScrHeadHeight-$mobileBefScrLogoHeight)/2; ?>px !important;
		padding-bottom: <?php echo ($mobileBefScrHeadHeight-$mobileBefScrLogoHeight)/2; ?>px !important;
	}
}

@media (max-width: 767px) {
	header.ark-header-vertical .shopping-cart-wrapper {
		margin-top: -<?php echo ($mobileBefScrHeadHeight+20)/2; ?>px;
	}
}

@media (min-width: 768px) and (max-width: 991px) {
	.header-vertical .navbar-toggle {
		margin-top: <?php echo ($tabletBefScrHeadHeight-$tabletNavToggleBtnHeight)/2; ?>px;
		margin-bottom: <?php echo ($tabletBefScrHeadHeight-$tabletNavToggleBtnHeight)/2; ?>px;
	}
}

@media (min-width: 768px) and (max-width: 991px) {
	.header-section-scroll .navbar-toggle {
		margin-top: <?php echo ($tabletBefScrHeadHeight-$tabletNavToggleBtnHeight)/2; ?>px;
		margin-bottom: <?php echo ($tabletBefScrHeadHeight-$tabletNavToggleBtnHeight)/2; ?>px;
	}
}

@media (min-width: 768px) and (max-width: 991px) {
	header.ark-header-vertical .navbar-logo .navbar-logo-wrap {
		padding-top: <?php echo ($tabletBefScrHeadHeight-$tabletBefScrLogoHeight)/2; ?>px !important;
		padding-bottom: <?php echo ($tabletBefScrHeadHeight-$tabletBefScrLogoHeight)/2; ?>px !important;
	}
}

@media (min-width: 768px) and (max-width: 991px) {
	header.ark-header-vertical .shopping-cart-wrapper {
		margin-top: -<?php echo ($tabletBefScrHeadHeight+20)/2; ?>px;
	}
}

/* VERTICAL TEMPLATES */

@media (max-width: 767px) {
	.ark-header .ffb-header-template-item-vcenter{
		height:  <?php echo $mobileBefScrHeadHeight; ?>px;
	}
}

@media (min-width: 768px) and (max-width: 991px) {
	.ark-header .ffb-header-template-item-vcenter{
		height:  <?php echo $tabletBefScrHeadHeight; ?>px;
	}
}

@media (min-width: 992px) {
	.ark-header .ffb-header-template-item-vcenter{
		height:  <?php echo $desktopBefScrHeadHeight; ?>px;
	}

	.ark-header.header-shrink .ffb-header-template-item-vcenter{
		height: <?php echo $desktopAftScrHeadHeight; ?>px;
	}
}

/* HEADER HEIGHT FIX FOR IE */

@media (min-width: 992px) {
	.ark-header .navbar-nav .nav-item {
		max-height: <?php echo $desktopBefScrHeadHeight; ?>px;
		overflow: visible;
	}
}

/* LOGO JUMP OUT */

<?php if ($data->desktopLogoJumpOut){ ?>

	@media (min-width: 992px) {
		.ark-header .navbar-logo {
			position: relative;
		}
		.ark-header .navbar-logo-wrap {
			position: absolute;
		}
	}

<?php }

		$css = ob_get_contents();
		ob_end_clean();

		return $css;

	}


	/**
	* @param string $media
	* @param string $property
	* @param string $value
	* @param string|null $selector
	*
	* @return ffThemeBuilderCssRule|null
	*/
	protected function _renderCSSHeaderRule($media, $property, $value, $selector = null){
		$rule = $this->_renderCSSRule( $property, $value, $selector );
		if( empty($rule) ){
			return null;
		}
		switch($media){
			case 'min768':
				$rule->addBreakpointSmMin();
				break;
			case 'max991':
				$rule->addBreakpointSmMax();
				break;
			case 'min992':
				$rule->addBreakpointMdMin();
				break;
		}
		return $rule;
	}

	/**
	 * @param $query ffOptionsQueryDynamic
	 */
	protected function _renderContainerClass($query){

		$container_classes = '';
		if( 'fg-container-fluid' == $query->getWithoutComparationDefault('type', 'fg-container-large')){
			$container_classes = 'container-fluid fg-container-fluid';
		} else if( 'fg-container-large' == $query->getWithoutComparationDefault('type', 'fg-container-large')){
			$container_classes = 'container fg-container-large';
		} else if( 'fg-container-medium' == $query->getWithoutComparationDefault('type', 'fg-container-large')){
			$container_classes = 'container fg-container-medium';
		} else if( 'fg-container-small' == $query->getWithoutComparationDefault('type', 'fg-container-large')){
			$container_classes = 'container fg-container-small';
		}

		// NOT NEEDED $container_classes .= ' fg-container-lvl--' . $this->_getContainerNestedLevel();

		$gutter = '';
		if($query->getWithoutComparationDefault('no-padding', 0)){
			$gutter = 'fg-container-no-padding';
		}
		
		echo ' fg-container '.$container_classes.' '.$gutter.' ';

	}

	/**
	* @param string $media
	* @param string $property
	* @param string $value
	* @param string|null $selector
	*
	* @return ffThemeBuilderCssRule|null
	*/
	protected function _renderCSSHeaderRuleImportant($media, $property, $value, $selector = null){
		$rule = $this->_renderCSSRuleImportant( $property, $value, $selector );
		if( empty($rule) ){
			return null;
		}
		switch($media){
			case 'min768':
				$rule->addBreakpointSmMin();
				break;
			case 'max991':
				$rule->addBreakpointSmMax();
				break;
			case 'min992':
				$rule->addBreakpointMdMin();
				break;
		}
		return $rule;
	}

	/**
	 * @param $query ffOptionsQueryDynamic
	 */
	function _renderVerticalHeader( $query ){

		echo '<div class="wrapper ff-boxed-wrapper';
		if( ffThemeOptions::getQuery('layout enable-pageloader' ) ) {
			echo ' animsition ';
		}
		echo '">';

		wp_enqueue_script( 'ark-header-vertical-dropdown-toggle' );

		$this->_advancedToggleBoxStart( $query, 'header-design' );

		echo '<header class="ark-header-vertical ';
			if( 'vertical-multi' == $query->get('design-type') ){
				echo 'header-vertical ';
				echo 'header-vertical-'.$query->get('vertical-position').' ';
				echo 'ark-header-vertical-'.$query->get('vertical-position').' ';
			}else{
				echo 'header-section-scroll ';
				echo 'ark-header-vertical-'.$query->get('vertical-position').' ';
			}

			if( class_exists('WooCommerce') ){
				$cart_type = $query->getWithoutComparationDefault('woocommerce-shopping-cart-type', 'ark-cart-classic');
				if( 'ark-cart-classic' == $cart_type ){
					$cart_type = 'ark-cart-next-to';
				}
				echo $cart_type . ' ';
				$cart_type = $query->getWithoutComparationDefault('woocommerce-shopping-cart-type-xs', 'ark-cart-left-side-xs');
				echo $cart_type . ' ';
			}

			echo ' ' . $query->getWithoutComparationDefault('horizontal-position-xs', '');
		echo '">';
		wp_enqueue_script( 'ark-scrollbar' );
		echo '<div class="scrollbar">';
		?>
			<nav class="navbar" role="navigation">
				<div class="container">
					<div class="menu-container">

						<?php
						if( $query->queryExists('template-beginning-of-header show') ) {
							$this->_headerTemplate($query->get('template-beginning-of-header'), 'template-beginning-of-header');
						}
						?>

						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".nav-collapse">
							<span class="sr-only">Toggle navigation</span>
							<span class="toggle-icon"></span>
						</button>
						<?php $this->_renderLogo($query); ?>
						<div class="clearfix"></div>
						<?php
						if( $query->queryExists('template-under-logo show') ) {
							 $this->_headerTemplate($query->get('template-under-logo'), 'template-under-logo');
						}
						?>
					</div>

					<?php
					if( $query->getWithoutComparationDefault('menu disable-nav-menu', 0)){
						echo '<!-- Menu Disabled -->';
					}else{
					?>
					<div class="collapse navbar-collapse nav-collapse">
						<div class="menu-container">
							<ul class="nav <?php
							if( 'vertical-multi' == $query->get('design-type') ){
								echo ' header-vertical-menu ';
							}else{
								echo ' header-section-scroll-menu ';

							}
							?>">
								<?php

								locate_template('builder/helpers/Walker_Nav_Menu_Ark_Vertical.php', true, true);

								if( $query->get('menu use-custom') ){
									$menu_id = absint( $query->getSingleSelect2('menu nav-menu') );
								}else{
									$menu_id = 0;
								}

								if( empty( $menu_id ) ) {
									$locations = get_nav_menu_locations();
									if (isSet($locations['main-nav']) and !empty($locations['main-nav'])) {
										$menu_id = absint($locations['main-nav']);
									}
								}

								if( empty( $menu_id ) ){
									Walker_Nav_Menu_Ark_Vertical_fallback( null );
								}else{
									wp_nav_menu(
										array(
											'menu'           => $menu_id,
											'depth'          => 0,
											'container'      => false,
											'items_wrap'     => '%3$s',
											'walker'         => new Walker_Nav_Menu_Ark_Vertical(),
											'fallback_cb'    => 'Walker_Nav_Menu_ark_fallback',
										)
									);
								}
								?>
							</ul>
						</div>
					</div>
					<?php
					if( class_exists('WooCommerce') ){
						if( 'show' == $query->getWithoutComparationDefault('woocommerce-shopping-cart','show') ) {
							echo '<div class="shopping-cart-wrapper">';
							echo ark_woocommerce_get__cart_menu_item__content();
							echo '</div>';
						}
					}
					?>

					<?php } ?>

					<?php
					if( $query->queryExists('template-end-of-header show') ) {
						 $this->_headerTemplate($query->get('template-end-of-header'), 'template-end-of-header');
					}
					?>
					<?php

					if( $query->get('show-copyright-text') ){
						echo '<p class="header-copyright ';
						if( 'vertical-multi' == $query->get('design-type') ) {
							echo 'header-vertical-copyright';
						}else{
							echo 'header-section-scroll-copyright';
						}
						echo '">';
						echo ark_wp_kses( $query->get('copyright-text') );
						echo '</p>';
					}

					?>
				</div>
			</nav>
		<?php
		echo '</div>';
		echo '</header>';

		/* WOOCOMMERCE ICON */
		if( class_exists('WooCommerce') ){
			if( 'show' == $query->getWithoutComparationDefault('woocommerce-shopping-cart','show') ) {
				$this->_advancedToggleBoxStart( $query, 'cart-menu-item' );
				$this->_advancedToggleBoxEnd( $query, 'cart-menu-item' );

				$this->_advancedToggleBoxStart( $query, 'cart-submenu' );
				$this->_advancedToggleBoxEnd( $query, 'cart-submenu' );
			}
		}

		$this->_advancedToggleBoxEnd( $query, 'header-design' );

		if( $query->get('show-copyright-text') ) {
			$this->_renderCSSRule('color', $query->getColorWithoutComparationDefault('copyright-text-color', null), '.ark-header-vertical .header-copyright');
		}


		/* FIRST LEVEL MENU */

		$this->_advancedToggleBoxStart( $query, 'ark-first-level-menu' );
		$this->_advancedToggleBoxEnd( $query, 'ark-first-level-menu' );



		/* SUB LEVEL MENU */
		$this->_advancedToggleBoxStart( $query, 'ark-sub-level-menu' );
		$this->_advancedToggleBoxEnd( $query, 'ark-sub-level-menu' );

		/* NAVBAR TOGGLE - visible only on phones */

		$this->_renderCSSRule('background-color', $query->getColor( 'ark-first-level-menu-icons mobile color'), '.ark-header-vertical .navbar-toggle .toggle-icon:not(.is-clicked)');
		$this->_renderCSSRule('background-color', $query->getColor( 'ark-first-level-menu-icons mobile color'), '.ark-header-vertical .navbar-toggle .toggle-icon:before');
		$this->_renderCSSRule('background-color', $query->getColor( 'ark-first-level-menu-icons mobile color'), '.ark-header-vertical .navbar-toggle .toggle-icon:after');
		$this->_renderCSSRule('background-color', $query->getColor( 'ark-first-level-menu-icons mobile color-hover'), '.ark-header-vertical .navbar-toggle:hover .toggle-icon:not(.is-clicked)');
		$this->_renderCSSRule('background-color', $query->getColor( 'ark-first-level-menu-icons mobile color-hover'), '.ark-header-vertical .navbar-toggle:hover .toggle-icon:before');
		$this->_renderCSSRule('background-color', $query->getColor( 'ark-first-level-menu-icons mobile color-hover'), '.ark-header-vertical .navbar-toggle:hover .toggle-icon:after');


		/* CUSTOM DESKTOP LOGO PADDING */

		if( '' !== $query->get('vdl-p-t') ) {
			$this->_renderCSSHeaderRule('min992', 'padding-top', $query->get('vdl-p-t').'px !important', '.ark-header-vertical .navbar-logo-wrap');
		}
		if( '' !== $query->get('vdl-p-r') ) {
			$this->_renderCSSHeaderRule('min992', 'padding-right', $query->get('vdl-p-r').'px !important', '.ark-header-vertical .navbar-logo-wrap');
		}
		if( '' !== $query->get('vdl-p-b') ) {
			$this->_renderCSSHeaderRule('min992', 'padding-bottom', $query->get('vdl-p-b').'px !important', '.ark-header-vertical .navbar-logo-wrap');
		}
		if( '' !== $query->get('vdl-p-l') ) {
			$this->_renderCSSHeaderRule('min992', 'padding-left', $query->get('vdl-p-l').'px !important', '.ark-header-vertical .navbar-logo-wrap');
		}

		$customWidth = absint( $query->getWithoutComparationDefault('vertical-width', null) );
		if( empty( $customWidth ) ) {
			$customWidth = 258;
		}
		if ('left' == $query->get('vertical-position')) {
			$css = '@media (min-width: 992px){
				.header-vertical {
					width: '.$customWidth.'px;
				}
				.header-section-scroll-container {
					margin-left: '.$customWidth.'px;
				}
				.header-section-scroll-container .fg-force-fullwidth{
					padding-left: '.$customWidth.'px;
				}
				.header-vertical-container .fg-force-fullwidth{
					padding-left: '.$customWidth.'px;
				}
				.ark-boxed__body-wrapper {
					padding-left: '.$customWidth.'px;
				}
			} ';
		}else{
			$css = '@media (min-width: 992px){
				.header-vertical {
					width: '.$customWidth.'px;
				}
				.header-section-scroll-container-right {
					margin-right: '.$customWidth.'px;
				}
				.header-section-scroll-container-right .fg-force-fullwidth{
					padding-right: '.$customWidth.'px;
				}
				.header-vertical-container-right .fg-force-fullwidth{
					padding-right: '.$customWidth.'px;
				}
				.ark-boxed__body-wrapper {
					padding-right: '.$customWidth.'px;
				}
			} ';
		}

		$this->_getAssetsRenderer()->createCssRule(false)
			->setContent( $css);


		$designs = array(
			'static' => array('min992', '.ark-header-vertical'),
			'mobile' => array('max991', '.ark-header-vertical'),
		);

		foreach( $designs as $design_type => $design_settings ){
			$design_bp = $design_settings[0];
			$design_selector = $design_settings[1];

			/* HEADERS BACKGROUND AND BOTTOM SHADOW */

			$type = 'header-design '.$design_type;
			$selector = ' ' . $design_selector;

			$bgColor = $query->getColor($type . ' bg-color' );
			if( !empty($bgColor) ) {
				$this->_renderCSSHeaderRule($design_bp, 'background-color', $bgColor, $selector);
				$this->_renderCSSHeaderRule($design_bp, 'background-color', $bgColor, $selector . ':before');
			}

			$borderColor = $query->getColor($type.' border-color' );
			if( !empty($borderColor) ){
				if( 'mobile' == $design_type ){
					$this->_renderCSSHeaderRule($design_bp, 'border-bottom', '1px solid ' . $borderColor, $selector);
				}else{
					if ('left' == $query->get('vertical-position')) {
						$this->_renderCSSHeaderRule($design_bp, 'border-right', '2px solid ' . $borderColor, $selector);
					}else{
						$this->_renderCSSHeaderRule($design_bp, 'border-left', '2px solid ' . $borderColor, $selector);
					}
				}
			}

			$shadowColor = $query->getColor($type.' shadow-color' );
			if( !empty($shadowColor) ){
				$this->_renderCSSHeaderRule($design_bp, 'box-shadow', ' 0 0 15px '.$shadowColor, $selector );
			}

			/* FIRST LEVEL MENU BG, TEXT COLOR AND BORDER */

			if( 'vertical-onepage' == $query->get('design-type') ) {
				$type = 'ark-first-level-menu ' . $design_type;
				$selector = ' ' . $design_selector . ' ul.header-section-scroll-menu li a.ffb-ark-first-level-menu';
				$selector_anc = ' ' . $design_selector . ' ul.header-section-scroll-menu li.current-menu-ancestor a.ffb-ark-first-level-menu';
				$selector_curr = ' ' . $design_selector . ' ul.header-section-scroll-menu li.current-menu-item a.ffb-ark-first-level-menu';
				$selector_act = ' ' . $design_selector . ' ul.header-section-scroll-menu li.active a.ffb-ark-first-level-menu';
			}else{ //vertical-multi
				$type = 'ark-first-level-menu ' . $design_type;
				$selector = ' ' . $design_selector . ' .header-vertical-menu .nav-main-item .nav-main-item-child';
				$selector_anc = ' ' . $design_selector . ' .header-vertical-menu .current-menu-ancestor .nav-main-item-child';
				$selector_curr = ' ' . $design_selector . ' .header-vertical-menu .current-menu-item .nav-main-item-child';
				$selector_act = ' ' . $design_selector . ' .header-vertical-menu .active .nav-main-item-child';
			}

			$this->_renderCSSHeaderRule($design_bp, 'color', $query->getColor($type . ' color'), $selector);
			$this->_renderCSSHeaderRule($design_bp, 'color', $query->getColor($type . ' color-current'), $selector_anc);
			$this->_renderCSSHeaderRule($design_bp, 'color', $query->getColor($type . ' color-current'), $selector_curr);
			$this->_renderCSSHeaderRule($design_bp, 'color', $query->getColor($type . ' color-current'), $selector_act);
			$this->_renderCSSHeaderRuleImportant($design_bp, 'color', $query->getColor($type . ' color-hover'), $selector . ':hover');
			if( 'vertical-multi' == $query->get('design-type') ) {
				$this->_renderCSSHeaderRule($design_bp, 'color', $query->getColor($type . ' color'), $selector . ':after');
				$this->_renderCSSHeaderRule($design_bp, 'color', $query->getColor($type . ' color-current'), $selector_anc . ':after');
				$this->_renderCSSHeaderRule($design_bp, 'color', $query->getColor($type . ' color-current'), $selector_curr . ':after');
				$this->_renderCSSHeaderRule($design_bp, 'color', $query->getColor($type . ' color-current'), $selector_act . ':after');
				$this->_renderCSSHeaderRuleImportant($design_bp, 'color', $query->getColor($type . ' color-hover'), $selector . ':hover:after');
			}
			$this->_renderCSSHeaderRule($design_bp, 'background-color', $query->getColor($type . ' bg-color'), $selector);
			$this->_renderCSSHeaderRule($design_bp, 'background-color', $query->getColor($type . ' bg-color-current'), $selector_anc);
			$this->_renderCSSHeaderRule($design_bp, 'background-color', $query->getColor($type . ' bg-color-current'), $selector_curr);
			$this->_renderCSSHeaderRule($design_bp, 'background-color', $query->getColor($type . ' bg-color-current'), $selector_act);
			$this->_renderCSSHeaderRuleImportant($design_bp, 'background-color', $query->getColor($type . ' bg-color-hover'), $selector . ':hover');

			$borderColor = $query->getColor( $type . ' border' );
			if( !empty($borderColor) ){
				if( '#ebeef6' != $borderColor){
					// #ebeef6 is already in CSS
					$this->_renderCSSHeaderRule($design_bp, 'border-color', $borderColor, $selector);
				}
			}else{
				$this->_renderCSSHeaderRule($design_bp, 'border-color', 'transparent', $selector);
			}



			/* SUBMENU BG AND TEXT COLOR */

			$type = 'ark-sub-level-menu ' . $design_type;
			if( 'vertical-multi' == $query->get('design-type') ) {
				$selector = ' ' . $design_selector . ' .header-vertical-menu .ffb-ark-sub-level-menu';
				$selector_anc = ' ' . $design_selector . ' .header-vertical-menu .current-menu-ancestor > .ffb-ark-sub-level-menu';
				$selector_curr = ' ' . $design_selector . ' .header-vertical-menu .current-menu-item > .ffb-ark-sub-level-menu';
				$selector_act = ' ' . $design_selector . ' .header-vertical-menu .active > .ffb-ark-sub-level-menu';
			} else { // vertical-onepage
				$selector = ' ' . $design_selector . ' .header-section-scroll-menu .ffb-ark-sub-level-menu';
				$selector_anc = ' ' . $design_selector . ' .header-section-scroll-menu .current-menu-ancestor > .ffb-ark-sub-level-menu';
				$selector_curr = ' ' . $design_selector . ' .header-section-scroll-menu .current-menu-item > .ffb-ark-sub-level-menu';
				$selector_act = ' ' . $design_selector . ' .header-section-scroll-menu .active > .ffb-ark-sub-level-menu';
			}

			$this->_renderCSSHeaderRule($design_bp, 'color', $query->getColor($type . ' color' ), $selector);
			$this->_renderCSSHeaderRule($design_bp, 'color', $query->getColor($type . ' color' ), $selector . ':after');
			$this->_renderCSSHeaderRule($design_bp, 'color', $query->getColor($type . ' color-current' ), $selector_anc);
			$this->_renderCSSHeaderRule($design_bp, 'color', $query->getColor($type . ' color-current' ), $selector_anc . ':after');
			$this->_renderCSSHeaderRule($design_bp, 'color', $query->getColor($type . ' color-current' ), $selector_curr);
			$this->_renderCSSHeaderRule($design_bp, 'color', $query->getColor($type . ' color-current' ), $selector_curr . ':after');
			$this->_renderCSSHeaderRule($design_bp, 'color', $query->getColor($type . ' color-current' ), $selector_act);
			$this->_renderCSSHeaderRule($design_bp, 'color', $query->getColor($type . ' color-current' ), $selector_act . ':after');
			$this->_renderCSSHeaderRuleImportant($design_bp, 'color', $query->getColor($type . ' color-hover' ), $selector . ':hover');
			$this->_renderCSSHeaderRuleImportant($design_bp, 'color', $query->getColor($type . ' color-hover' ), $selector . ':hover:after');
			$this->_renderCSSHeaderRule($design_bp, 'background-color', $query->getColor($type . ' bg-color' ), $selector);
			$this->_renderCSSHeaderRule($design_bp, 'background-color', $query->getColor($type . ' bg-color-current' ), $selector_anc);
			$this->_renderCSSHeaderRule($design_bp, 'background-color', $query->getColor($type . ' bg-color-current' ), $selector_curr);
			$this->_renderCSSHeaderRule($design_bp, 'background-color', $query->getColor($type . ' bg-color-current' ), $selector_act);
			$this->_renderCSSHeaderRuleImportant($design_bp, 'background-color', $query->getColor($type . ' bg-color-hover' ), $selector . ':hover');


			// WooCommerce Cart
			if( class_exists('WooCommerce') ) {

				/* ICON IN THE MENU */

				$c_type = 'cart-menu-item ' . $design_type;


				$this->_renderCSSHeaderRule($design_bp, 'color', $query->getColorWithoutComparationDefault($c_type . ' link color'), '.ark-header-vertical .ffb-cart-menu-item');
				$this->_renderCSSHeaderRule($design_bp, 'background-color', $query->getColorWithoutComparationDefault($c_type . ' link bg-color'), '.ark-header-vertical .ffb-cart-menu-item');

				$this->_renderCSSHeaderRule($design_bp, 'color', $query->getColorWithoutComparationDefault($c_type . ' link color-hover'), '.ark-header-vertical .ffb-cart-menu-item:hover');
				$this->_renderCSSHeaderRule($design_bp, 'color', $query->getColorWithoutComparationDefault($c_type . ' link color-hover'), '.ark-header-vertical .ffb-cart-menu-item:hover .shopping-cart-icon-wrapper:hover');
				$this->_renderCSSHeaderRule($design_bp, 'background-color', $query->getColorWithoutComparationDefault($c_type . ' link bg-color-hover'), '.ark-header-vertical .ffb-cart-menu-item:hover');

				$this->_renderCSSHeaderRule($design_bp, 'color', $query->getColorWithoutComparationDefault($c_type . ' count color'), '.ark-header-vertical .ffb-cart-menu-item .shopping-cart-icon-wrapper:after');
				$this->_renderCSSHeaderRule($design_bp, 'background-color', $query->getColorWithoutComparationDefault($c_type . ' count bg-color'), '.ark-header-vertical .ffb-cart-menu-item .shopping-cart-icon-wrapper:after');

				$this->_renderCSSHeaderRule($design_bp, 'color', $query->getColorWithoutComparationDefault($c_type . ' count color-hover'), '.ark-header-vertical .ffb-cart-menu-item:hover .shopping-cart-icon-wrapper:after');
				$this->_renderCSSHeaderRule($design_bp, 'background-color', $query->getColorWithoutComparationDefault($c_type . ' count bg-color-hover'), '.ark-header-vertical .ffb-cart-menu-item:hover .shopping-cart-icon-wrapper:after');


				/* WOOCOMERCE SUBMENU ITEMS */

				$c_type = 'cart-submenu ' . $design_type;


				$this->_renderCSSHeaderRule($design_bp, 'background-color', $query->getColorWithoutComparationDefault($c_type . ' bg-color'), $design_selector . ' .ffb-cart-submenu');

			}

		}

		if( class_exists('WooCommerce') ) {
			$cart_width_sm = $query->getWithoutComparationDefault('cart-width-sm', null);
			$cart_width_sm = absint( $cart_width_sm );

			if( 0 != $cart_width_sm ) {
				$cart_type_sm = $query->getWithoutComparationDefault('woocommerce-shopping-cart-type-xs', 'ark-cart-left-side-xs');

				$css = '@media (min-width: 768px) and (max-width: 991px) { ';
				if( 'ark-cart-left-side-xs' == $cart_type_sm ) {
					$css .= 'header.ark-cart-left-side-xs .shopping-cart-wrapper.open .shopping-cart-menu { ';
						$css .= 'transform: translateX( ' . $cart_width_sm . 'px );';
					$css .= '}';
					$css .= 'header.ark-cart-left-side-xs .shopping-cart-menu { ';
						$css .= 'left: -'.$cart_width_sm.'px;';
						$css .= 'width: '.$cart_width_sm.'px;';
					$css .= '}';
				}else{
					$css .= 'header.ark-cart-right-side-xs .shopping-cart-wrapper.open .shopping-cart-menu { ';
						$css .= 'transform: translateX( -' . $cart_width_sm . 'px );';
					$css .= '}';
					$css .= 'header.ark-cart-right-side-xs .shopping-cart-menu { ';
						$css .= 'right: -'.$cart_width_sm.'px;';
						$css .= 'width: '.$cart_width_sm.'px;';
					$css .= '}';
				}
				$css .= '}';

				$this->_getAssetsRenderer()->createCssRule(false)->setContent($css);
			}

			$cart_width_md = absint( $query->getWithoutComparationDefault('cart-width-md', null) );
			$cart_width_lg = absint( $query->getWithoutComparationDefault('cart-width-lg', null) );

			$menuWidth = absint( $query->getWithoutComparationDefault('vertical-width', null) );

			$cart_type_md = $query->getWithoutComparationDefault('woocommerce-shopping-cart-type', 'ark-cart-classic');
			if( 'ark-cart-classic' == $cart_type_md ){
				$cart_type_md = 'ark-cart-next-to';
			}

			if( ! empty($menuWidth) and ( 'ark-cart-next-to' == $cart_type_md ) ){
				if( 0 == $cart_width_md ) {
					$cart_width_md = 258;
				}
			}

			if( ( 0 != $cart_width_md ) or ( 0 != $cart_width_lg ) ) {

				if( empty( $menuWidth ) ) {
					$menuWidth = 258;
				}

				foreach( array( 992 => $cart_width_md, 1200 => $cart_width_lg ) as $bp_size => $cart_width ){
					if( 0 == $cart_width ){
						continue;
					}

					$css = '@media (min-width: ' . $bp_size . 'px) { ';
					if( 'ark-cart-left-side' == $cart_type_md ) {
						$css .= 'header.ark-cart-left-side .shopping-cart-wrapper.open .shopping-cart-menu { ';
							$css .= 'transform: translateX( ' . $cart_width . 'px );';
						$css .= '}';
						$css .= 'header.ark-cart-left-side .shopping-cart-menu { ';
							$css .= 'left: -'.$cart_width.'px;';
							$css .= 'width: '.$cart_width.'px;';
						$css .= '}';
					} else if( 'ark-cart-right-side' == $cart_type_md ) {
						$css .= 'header.ark-cart-right-side .shopping-cart-wrapper.open .shopping-cart-menu { ';
							$css .= 'transform: translateX( -' . $cart_width . 'px );';
						$css .= '}';
						$css .= 'header.ark-cart-right-side .shopping-cart-menu { ';
							$css .= 'right: -'.$cart_width.'px;';
							$css .= 'width: '.$cart_width.'px;';
						$css .= '}';
					} else {
						if ('left' == $query->get('vertical-position')) {
							$css .= 'header.ark-cart-next-to .shopping-cart-wrapper.open .shopping-cart-menu { ';
								$css .= 'transform: translateX( ' . $cart_width . 'px ) !important;';
							$css .= '}';
							$css .= 'header.ark-cart-next-to .shopping-cart-menu { ';
								$css .= 'left: '.($menuWidth - $cart_width).'px !important;';
								$css .= 'width: '.$cart_width.'px;';
							$css .= '}';
						}else{
							$css .= 'header.ark-cart-next-to .shopping-cart-wrapper.open .shopping-cart-menu { ';
								$css .= 'transform: translateX( -' . $cart_width . 'px ) !important;';
							$css .= '}';
							$css .= 'header.ark-cart-next-to .shopping-cart-menu { ';
								$css .= 'right: '.($menuWidth - $cart_width).'px !important;';
								$css .= 'width: '.$cart_width.'px;';
							$css .= '}';
						}
					}
					$css .= '}';

					$this->_getAssetsRenderer()->createCssRule(false)->setContent($css);
				}
			}

		}

		echo '<div class="page-wrapper ';
		if( 'vertical-multi' == $query->get('design-type') ) {
			if ('right' == $query->get('vertical-position')) {
				echo 'header-section-scroll-container-right';
			} else {
				echo 'header-section-scroll-container';
			}
		} else { // vertical-onepage
			if ('right' == $query->get('vertical-position')) {
				echo 'header-vertical-container-right';
			} else {
				echo 'header-vertical-container';
			}
		}
		echo '">';
		wp_enqueue_script( 'ark-header-section-scroll' );

	}

	protected function navigation__topbar_html( $hiddenOnScroll, $topbar_mobile_button = true ){

		$class = '';
		if( $hiddenOnScroll ) {
			$class .= ' ark-topbar-hidden-on-scroll';
		}

		if( $topbar_mobile_button ) {
			$class .= ' theme-toggle-content';
		}

		echo '<div class="ark-topbar-wrapper '.$class.'">';
			echo '<div class="ark-topbar">';
				$vdm = ffContainer()->getThemeFrameworkFactory()->getSitePreferencesFactory()->getViewDataManager();
				$currentHeader = $vdm->getCurrentHeader();
				$shortcodes = $currentHeader->get('builder');
				$themebuildermanager = ffContainer()->getThemeFrameworkFactory()->getThemeBuilderManager();
				$final = $themebuildermanager->renderButNotPrint( $shortcodes );

				// Generated via framework
				echo ( $final );
				$themebuildermanager->addRenderdCssToStack();
				$themebuildermanager->addRenderedJsToStack();
//				echo ( $this->_doShortcode($shortcodes) );
			echo '</div>';
		echo '</div>';
	}

	/**
	 * @param $query ffOptionsQueryDynamic
	 * @param $class string
	 */
	protected function _headerTemplate( $query, $class ){
		if( ! $query->queryExists('show') ){
			return;
		}

		if( ! $query->getWithoutComparationDefault('show', 0) ){
			return;
		}

		$id = $query->getMultipleSelect2('wrapper template-id');
		if( empty($id[0]) ){
			$id = 0;
		}else{
			$id = $id[0];
		}

		if( empty( $id ) ){
			return;
		}


		if( 'ff-template' == get_post_type( $id ) ) {
			$post = ffContainer()->getPostLayer()->getPostGetter()->getPostByID($id);
			if (!empty($post)) {
				$post_content = $post->getContent();
				$themebuildermanager = ffContainer()->getThemeFrameworkFactory()->getThemeBuilderManager();
				$final = $themebuildermanager->renderButNotPrint($post_content);

				echo '<div class="ffb-header-template-item-vcenter-wrapper '.$class.'">';
				echo '<div class="ffb-header-template-item-vcenter">';
				echo '<div class="ffb-header-template-item-vcenter-inner">';
				$this->_advancedToggleBoxStart( $query->get('wrapper'), $class.'-header-template-item' );
				echo '<div class="'.$class.'-header-template-item header-template-item">';
				echo do_shortcode($final);

				$themebuildermanager->addRenderdCssToStack();
				$themebuildermanager->addRenderedJsToStack();

				echo '</div>';
				$this->_advancedToggleBoxEnd( $query->get('wrapper'), $class );
				echo '</div>';
				echo '</div>';
				echo '</div>';

			}
		}
	}

	protected function _getWPMLSearchInput() {
		$wpmlSearchCode = '';

		$WPLayer = ffContainer()->getWPLayer();

		if( $WPLayer->getWPMLBridge()->isWPMLActive() ) {
			$wpmlSearchCode = '<input type="hidden" name="lang" value="'. $WPLayer->getWPMLBridge()->getCurrentLanguage().'"/>';
		}
		return $wpmlSearchCode;
	}

	/**
	 * @param $query ffOptionsQueryDynamic
	 */
	protected function navigation__search_default_html( $query ){

		?>
		<div class="ark-search-field">
			<div class="<?php $this->_renderContainerClass($query) ?>">
				<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<?php echo $this->_getWPMLSearchInput(); ?>
					<input
						name="s"
						type="text"
						class="form-control ark-search-field-input"
						placeholder="<?php echo esc_attr( $query->get('search placeholder') ); ?>"
						value="<?php echo get_search_query(); ?>"
					>

				</form>
			</div>
		</div>
		<?php
	}


	/**
	 * @param $query ffOptionsQueryDynamic
	 */
	protected function navigation__search_default_icon( $query ){
		?>
		<div class="navbar-actions-shrink search-menu ffb-ark-first-level-menu">
			<div class="search-btn">
				<i class="navbar-special-icon search-btn-default ff-font-awesome4 icon-search"></i>
				<i class="navbar-special-icon search-btn-active ff-font-awesome4 icon-times"></i>
			</div>
		</div>
		<?php
	}

	/**
	 * @param $query ffOptionsQueryDynamic
	 */
	protected function navigation__search_classic_html( $query ){
		?>
		<div class="navbar-actions-shrink search-classic">
			<div class="search-classic-btn ffb-ark-first-level-menu">
				<i class="navbar-special-icon search-classic-btn-default fa fa-search"></i>
				<i class="navbar-special-icon search-classic-btn-active fa fa-times"></i>
			</div>
			<div class="search-classic-field">
				<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<div class="input-group">
						<?php echo $this->_getWPMLSearchInput(); ?>
						<input
							name="s"
							type="text"
							class="form-control search-classic-input"
							placeholder="<?php echo esc_attr( $query->get('search placeholder') ); ?>"
							value="<?php echo get_search_query(); ?>"
						>

						<span class="input-group-btn">
							<button class="btn-base-bg btn-base-sm search-classic-submit-button" type="submit"><i class="search-on-header-btn-default fa fa-search"></i></button>
						</span>
					</div>
				</form>
			</div>
		</div>
		<?php
	}

	/**
	 * @param $query ffOptionsQueryDynamic
	 */
	protected function navigation__search_fullscreen_html( $query ){
		?>
		<div class="navbar-actions-shrink search-fullscreen<?php
		if( $query->get('make-transparent') ) {
			echo ' search-fullscreen-trigger-white';
		}?>">
			<div class="search-fullscreen-trigger ffb-ark-first-level-menu">
				<i class="navbar-special-icon search-fullscreen-trigger-icon ff-font-awesome4 icon-search ffb-ark-first-level-menu"></i>
			</div>
			<div class="search-fullscreen-overlay">
				<div class="search-fullscreen-overlay-content">
					<div class="search-fullscreen-input-group">
						<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
							<?php echo $this->_getWPMLSearchInput(); ?>
							<input
								name="s"
								type="text"
								class="form-control search-fullscreen-input"
								placeholder="<?php echo esc_attr( $query->get('search placeholder') ); ?>"
								value="<?php echo get_search_query(); ?>"
							>
							<button class="search-fullscreen-search" type="submit">
								<i class="search-fullscreen-navbar-special-icon ff-font-awesome4 icon-search"></i>
							</button>
						</form>
					</div>
				</div>
			</div>
			<div class="search-fullscreen-bg-overlay">
				<div class="search-fullscreen-close">&times;</div>
			</div>
		</div>
		<?php
	}

	/**
	 * @param $query ffOptionsQueryDynamic
	 */
	protected function navigation__search_on_header_html( $query ){
		?>
		<div class="search-on-header-field">
			<div class="<?php $this->_renderContainerClass($query) ?>">
				<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<?php echo $this->_getWPMLSearchInput(); ?>
					<input
						name="s"
						type="text"
						class="form-control search-on-header-input"
						placeholder="<?php echo esc_attr( $query->get('search placeholder') ); ?>"
						value="<?php echo get_search_query(); ?>"
					>
				</form>
			</div>
		</div>
		<?php
	}

	/**
	 * @param $query ffOptionsQueryDynamic
	 */
	protected function navigation__search_on_header_icon( $query ){
		?>
		<div class="navbar-actions-shrink search-on-header">
			<div class="search-on-header-btn ffb-ark-first-level-menu">
				<i class="navbar-special-icon search-on-header-btn-default fa fa-search"></i>
				<i class="search-on-header-btn-active fa fa-times"></i>
			</div>
		</div>
		<?php
	}

	/**
	 * @param $query ffOptionsQueryDynamic
	 */
	protected function navigation__search_push_html( $query ){
		?>
		<div class="search-push-open">
			<div class="<?php $this->_renderContainerClass($query) ?> search-push-container">
				<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<?php echo $this->_getWPMLSearchInput(); ?>
					<input
						name="s"
						type="text"
						class="form-control search-push-input"
						placeholder="<?php echo esc_attr( $query->get('search placeholder') ); ?>"
						value="<?php echo get_search_query(); ?>"
					>
				</form>
			</div>
		</div>
		<?php
	}

	/**
	 * @param $query ffOptionsQueryDynamic
	 */
	protected function navigation__search_push_icon( $query ){
		?>
		<div class="navbar-actions-shrink search-push ffb-ark-first-level-menu">
			<div class="search-push-btn">
				<i class="navbar-special-icon search-push-btn-default fa fa-search"></i>
				<i class="navbar-special-icon search-push-btn-active fa fa-times"></i>
			</div>
		</div>
		<?php
	}

	/**
	 * @param $query ffOptionsQueryDynamic
	 */
	protected function navigation__get_in_touch_html( $query ){
		wp_enqueue_script( 'ark-scrollbar' );

		$id = $query->getMultipleSelect2('get-in-touch side-menu-wrapper get-in-touch-id');
		if( empty($id[0]) ){
			$id = 0;
		}else{
			$id = $id[0];
		}

		if( empty( $id ) ){
			return;
		}

		?>

		<a class="navbar-actions-shrink sidebar-trigger<?php
		if( ( $query->get('design-type') == 'fullscreen')  ){
			echo ' sidebar-trigger-style-white';
		}
		if( in_array( $query->get('design-type'), array('header', 'header-center-aligned') ) ){
			if( $query->get('make-transparent') ){
				echo ' sidebar-trigger-style-white';
			}
		}?>" href="javascript:void(0);">
			<span class="sidebar-trigger-icon"></span>
		</a>

		<div class="sidebar-content-overlay"></div>

		<?php
		$this->_advancedToggleBoxStart( $query->get('get-in-touch'), 'side-menu-wrapper' );
		echo '<div class="sidebar-nav scrollbar">';
		?>
				<a class="sidebar-trigger sidebar-nav-trigger" href="javascript:void(0);">
					<span class="sidebar-trigger-icon"></span>
				</a>
				<div class="sidebar-nav-content">

					<?php
					if( 'ff-template' == get_post_type( $id ) ) {
						$post = ffContainer()->getPostLayer()->getPostGetter()->getPostByID($id);
						if (!empty($post)) {
							$post_content = $post->getContent();
							$themebuildermanager = ffContainer()->getThemeFrameworkFactory()->getThemeBuilderManager();
							$final = $themebuildermanager->renderButNotPrint($post_content);

							echo do_shortcode($final);

							$themebuildermanager->addRenderdCssToStack();
							$themebuildermanager->addRenderedJsToStack();
						}
					}
					?>


				</div>
		<?php
		echo '</div>';

		$this->_renderCSSRule('background-color', $query->getColor('get-in-touch side-menu-wrapper color'), ' .sidebar-trigger .sidebar-trigger-icon:before' );
		$this->_renderCSSRule('background-color', $query->getColor('get-in-touch side-menu-wrapper color'), ' .sidebar-trigger .sidebar-trigger-icon:after' );
		$this->_renderCSSRule('background-color', $query->getColor('get-in-touch side-menu-wrapper color-hover'), ' .sidebar-trigger:hover .sidebar-trigger-icon:before' );
		$this->_renderCSSRule('background-color', $query->getColor('get-in-touch side-menu-wrapper color-hover'), ' .sidebar-trigger:hover .sidebar-trigger-icon:after' );


		$this->_advancedToggleBoxEnd( $query->get('get-in-touch'), 'side-menu-wrapper' );

		$width = $query->get('get-in-touch side-menu-wrapper get-in-touch-width');
		if( !empty($width) ) {
			$this->_renderCSSHeaderRule('min768', 'width', $width . 'px', ' .sidebar-nav');
			$this->_renderCSSHeaderRule('min768', 'margin-right', '-' . $width . 'px', ' .sidebar-nav');
		}


	}

	/**
	 * @param $query ffOptionsQueryDynamic
	 */
	protected function _renderHorizontalNavigation( $query ){
		echo '<div class="wrapper ff-boxed-wrapper';
		if( ffThemeOptions::getQuery('layout enable-pageloader' ) ) {
			echo ' animsition ';
		}
		echo '">';
		if( $query->getWithoutComparationDefault('header-design b-m bg', null) ){
			$css = '';
			if( $query->getWithoutComparationDefault('header-design static bg-color', null) ){ ; } else {
				$css .= '@media (min-width: 992px) { .ark-header:not(.header-shrink) .navbar { background-color:transparent; } }';
			}
			if( $query->getWithoutComparationDefault('header-design fixed bg-color', null) ){ ; } else {
				$css .= '@media (min-width: 992px) { .ark-header.header-shrink .navbar { background-color:transparent; } }';
			}
			if( $query->getWithoutComparationDefault('header-design mobile bg-color', null) ){ ; } else {
				$css .= '@media (max-width: 991px) { .ark-header .navbar { background-color:transparent; } }';
			}
			$this->_getAssetsRenderer()->createCssRule(false)->setContent($css);
		}
		if( in_array( $query->get('horizontal-position'), array( 'header-sticky navbar-fixed-top', 'navbar-fixed-top header-sticky auto-hiding-navbar' ) ) ) {
			if( $query->getWithoutComparationDefault('wrapper-top-space--include-topbar-height', 0) ){
				$include_topbar_height = ' include-topbar-height';
			}else{
				$include_topbar_height = '';
			}
			if( $query->getWithoutComparationDefault('wrapper-top-space', 1) ){
				$backgroundColor = $query->getColorWithoutComparationDefault('wrapper-top-space-bg-color');
				if( ! $query->getWithoutComparationDefault( 'topbar-hidden-when-scroll', 1 ) ){
					echo '<div class="wrapper-topbar-top-space hidden-xs hidden-sm'.$include_topbar_height.'"></div>';
				}
				echo '<div class="wrapper-top-space'.$include_topbar_height.'"></div>';
				if( $backgroundColor != null ) {
					$css = '@media (min-width: 992px) { ';
					$css .= '.wrapper-topbar-top-space, .wrapper-top-space { ';
					$css .= 'background-color:'.$backgroundColor;
					$css .= '}';
					$css .= '}';
					$this->_getAssetsRenderer()->createCssRule(false)->setContent($css);
				}
			}
			if( $query->getWithoutComparationDefault('wrapper-top-space-xs', 0) ){
				$backgroundColor = $query->getColorWithoutComparationDefault('wrapper-top-space-bg-color-xs');
				if( ! $query->getWithoutComparationDefault( 'topbar-mobile-button', 1 ) ){
					echo '<div class="wrapper-topbar-top-space-xs hidden-md hidden-lg'.$include_topbar_height.'"></div>';
				}
				echo '<div class="wrapper-top-space-xs'.$include_topbar_height.'"></div>';
				if( $backgroundColor != null ) {
					$css = '@media (max-width: 991px) { ';
					$css .= '.wrapper-topbar-top-space-xs, .wrapper-top-space-xs { ';
					$css .= 'background-color:'.$backgroundColor;
					$css .= '}';
					$css .= '}';
					$this->_getAssetsRenderer()->createCssRule(false)->setContent($css);
				}
			}
		}

		$this->_advancedToggleBoxStart( $query, 'header-design' );

		echo '<header class="ark-header ';

		$topbar_hidden_when_scroll = $query->getWithoutComparationDefault('topbar-hidden-when-scroll', 1);

		if( ! $topbar_hidden_when_scroll ){
			echo 'topbar-always-visible ';
		}

		if( class_exists('WooCommerce') ){
			$cart_type = $query->getWithoutComparationDefault('woocommerce-shopping-cart-type', 'ark-cart-classic');
			if( 'ark-cart-next-to' == $cart_type ){
				$cart_type = 'ark-cart-classic';
			}
			echo $cart_type . ' ';
			$cart_type = $query->getWithoutComparationDefault('woocommerce-shopping-cart-type-xs', 'ark-cart-left-side-xs');
			echo $cart_type . ' ';
		}

		echo $query->getWithoutComparationDefault('horizontal-position-xs', '') . ' ';

		if( $query->getWithoutComparationDefault('header-pills', 'header-pills') ){
			echo 'header-pills ';
		}else{
			echo 'header-no-pills ';
		}

		echo esc_attr($query->get('design-type'));
		if( $query->getWithoutComparationDefault('make-transparent', 0) ){
			echo '-transparent';
		}
		echo ' ' . esc_attr($query->get('horizontal-position'));
		if( $query->get('add-topbar') ){
			echo ' header-has-topbar';
		}
		echo '">';

		echo '<div class="ff-ark-header-circle-shadow"></div>';

			if( $query->get('add-topbar') ){
				$this->navigation__topbar_html( $topbar_hidden_when_scroll, $query->getWithoutComparationDefault( 'topbar-mobile-button', 1 ) );
			}

			if( 'search-on-header' == $query->get('search style') ){
				$this->navigation__search_on_header_html($query);
			}

			if( 'search-push' == $query->get('search style') ){
				$this->navigation__search_push_html($query);
			}

			if( $query->getWithoutComparationDefault( 'header-design-inner _filler_', null ) ){
				$this->_advancedToggleBoxStart( $query, 'header-design-inner' );
			}

			echo '<nav class="navbar mega-menu" role="navigation">';

				if( 'search-default' == $query->get('search style') ){
					$this->navigation__search_default_html($query);
				}
				?>

				<div class="<?php $this->_renderContainerClass($query) ?>">
					<div class="menu-container">
						<?php
						if( $query->queryExists('template-beginning-of-header show') ) {
							$this->_headerTemplate($query->get('template-beginning-of-header'), 'template-beginning-of-header');
						}
						?>

						<?php if( $query->getWithoutComparationDefault('menu disable-nav-menu', 0)){ ?>
							<!-- Menu Disabled -->
						<?php } else { ?>
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".nav-collapse">
								<span class="sr-only"><?php echo ark_wp_kses(__('Toggle navigation', 'ark')); ?></span>
								<span class="toggle-icon"></span>
							</button>
						<?php } ?>

						<?php if( $query->get('add-topbar') ){ ?>
							<?php if( $query->getWithoutComparationDefault( 'topbar-mobile-button', 1 ) ){ ?>
								<div class="theme-toggle-trigger topbar-toggle-trigger">
									<i class="topbar-toggle-trigger-icon-style ff-font-awesome4 icon-ellipsis-v"></i>
								</div>
							<?php } ?>
						<?php } ?>
						<div class="navbar-actions">

							<?php

							if( $query->queryExists('template-before-menu-icons show') ) {
								$this->_headerTemplate($query->get('template-before-menu-icons'), 'template-beginning-of-header');
							}

							if( $query->queryExists('template-end-of-header show') ) {
								$this->_headerTemplate($query->get('template-end-of-header'), 'template-end-of-header');
							}

							if( class_exists('WooCommerce') ){
								if( 'show' == $query->getWithoutComparationDefault('woocommerce-shopping-cart','show') ) {
									echo '<div class="shopping-cart-wrapper">';
									echo ark_woocommerce_get__cart_menu_item__content();
									echo '</div>';
								}
							}

							switch( $query->get('search style') ){
								case 'search-default': $this->navigation__search_default_icon( $query ); break;
								case 'search-classic': $this->navigation__search_classic_html($query); break;
								case 'search-fullscreen': $this->navigation__search_fullscreen_html($query); break;
								case 'search-on-header': $this->navigation__search_on_header_icon($query); break;
								case 'search-push': $this->navigation__search_push_icon( $query ); break;
							}

							if( $query->get('get-in-touch show') ){
								$this->navigation__get_in_touch_html($query);
							}

							?>
						</div>

						<?php $this->_renderLogo($query); ?>

					</div>

					<div class="collapse navbar-collapse nav-collapse">
						<div class="menu-container">

							<?php

							if( $query->getWithoutComparationDefault('menu disable-nav-menu', 0)){
								echo '<!-- Menu Disabled -->';
							}else{

							?>
								<ul class="nav navbar-nav navbar-nav-left"<?php
								if( $query->get('design-type') == 'header-center-aligned' ) {
									echo ' data-split-after="'.absint( $query->get('split-after') ).'"';

								}
								?>>
									<?php

									locate_template('builder/helpers/Walker_Nav_Menu_Ark.php', true, true);

									if( $query->get('menu use-custom') ){
										$menu_id = absint( $query->getSingleSelect2('menu nav-menu') );
									}else{
										$menu_id = 0;
									}

									if( empty( $menu_id ) ) {
										$locations = get_nav_menu_locations();
										if (isSet($locations['main-nav']) and !empty($locations['main-nav'])) {
											$menu_id = absint($locations['main-nav']);
										}
									}

									if( empty( $menu_id ) ){
										Walker_Nav_Menu_Ark_fallback( null );
									}else{
										$walker = new Walker_Nav_Menu_Ark();
										if( $query->get('design-type') ==  'header-center-aligned' ) {
											$walker->setSplitAfter($query->get('split-after'));
										}
										wp_nav_menu(
											array(
												'menu'        => $menu_id,
												'depth'       => 0,
												'container'   => false,
												'items_wrap'  => '%3$s',
												'walker'      => $walker,
												'fallback_cb' => 'Walker_Nav_Menu_ark_fallback',
											)
										);
									}
									?>
								</ul>
							<?php } // else menu disable-nav-menu ?>
						</div>
					</div>
				</div>
			</nav>
		<?php
		if( $query->getWithoutComparationDefault( 'header-design-inner _filler_', null ) ){
			$this->_advancedToggleBoxEnd( $query, 'header-design-inner' );
		}
		?>
		</header><?php


		/* WOOCOMMERCE ICON */
		if( class_exists('WooCommerce') ) {
			if ('show' == $query->getWithoutComparationDefault('woocommerce-shopping-cart', 'show')) {
				$this->_advancedToggleBoxStart($query, 'cart-menu-item');
				$this->_advancedToggleBoxEnd($query, 'cart-menu-item');

				$this->_advancedToggleBoxStart( $query, 'cart-submenu' );
				$this->_advancedToggleBoxEnd( $query, 'cart-submenu' );
			}
		}


		$this->_advancedToggleBoxEnd( $query, 'header-design' );



		/* FIRST LEVEL MENU */

		$this->_advancedToggleBoxStart( $query, 'ark-first-level-menu' );
		$this->_advancedToggleBoxEnd( $query, 'ark-first-level-menu' );



		/* SUB LEVEL MENU */

		$this->_advancedToggleBoxStart( $query, 'ark-sub-level-menu' );
		$this->_advancedToggleBoxEnd( $query, 'ark-sub-level-menu' );


		/* NAVBAR TOGGLE - visible only on phones */
		$this->_renderCSSRule('background-color', $query->getColor( 'ark-first-level-menu-icons mobile color' ), ' .ark-header .navbar-toggle .toggle-icon:not(.is-clicked)');
		$this->_renderCSSRule('background-color', $query->getColor( 'ark-first-level-menu-icons mobile color' ), ' .ark-header .navbar-toggle .toggle-icon:before');
		$this->_renderCSSRule('background-color', $query->getColor( 'ark-first-level-menu-icons mobile color' ), ' .ark-header .navbar-toggle .toggle-icon:after');
		$this->_renderCSSRule('background-color', $query->getColor( 'ark-first-level-menu-icons mobile color-hover' ), ' .ark-header .navbar-toggle:hover .toggle-icon:not(.is-clicked)');
		$this->_renderCSSRule('background-color', $query->getColor( 'ark-first-level-menu-icons mobile color-hover' ), ' .ark-header .navbar-toggle:hover .toggle-icon:before');
		$this->_renderCSSRule('background-color', $query->getColor( 'ark-first-level-menu-icons mobile color-hover' ), ' .ark-header .navbar-toggle:hover .toggle-icon:after');

		/* NAVBAR TOGGLE - TOPBAR - visible only on phones */
		$this->_renderCSSRule('color', $query->getColor( 'ark-first-level-menu-icons mobile color' ), ' .ark-header .topbar-toggle-trigger .topbar-toggle-trigger-icon-style:before');
		$this->_renderCSSRule('color', $query->getColor( 'ark-first-level-menu-icons mobile color-hover' ), ' .ark-header .topbar-toggle-trigger:hover .topbar-toggle-trigger-icon-style:before');


		/* WRAPPER TOP SPACE div BACKGROUND */
		if( $query->get('wrapper-top-space') ){
			if( in_array( $query->get('horizontal-position'), array( 'header-sticky navbar-fixed-top', 'navbar-fixed-top header-sticky auto-hiding-navbar' ) ) ) {
				$backgroundColor = $query->getColorWithoutComparationDefault('wrapper-top-space-bg-color');
				if( $backgroundColor != null ) {
					$this->_renderCSSHeaderRule('min992', 'background-color', $query->getColor('header-design static bg-color'), ' .wrapper-top-space');
				}
			}
		}


		/* TABLET - MENU ITEM - BORDER TOP */

		$borderColor = $query->getColor('ark-first-level-menu mobile border');
		if( !empty($borderColor) ){
			if( '#ebeef6' != $borderColor){
				// #ebeef6 is already in CSS
				$this->_renderCSSHeaderRule('max991', 'border-top-color', $borderColor, ' .ark-header .navbar-nav .nav-item');
			}
		}else{
			$this->_renderCSSHeaderRule('max991', 'border-top-color', 'transparent', ' .ark-header .navbar-nav .nav-item');
		}


		/* MOBILE SUBMENU OPENING */
		// Menu items with submenu on moblie opens submenu and not go to another page
		if( $query->getWithoutComparationDefault('header-mobile-force-submenu', null) ){
			$this->_renderCSSHeaderRule('max991', 'width', '100%', '.ark-header .navbar-nav .dropdown-toggle');
			$this->_renderCSSHeaderRule('max991', 'float', 'none', '.ark-header .navbar-nav .dropdown-toggle');
//
//			$css = '
//			​@media (max-width:991px) {​
//				.ark-header .navbar-nav .dropdown-toggle {​
//					width: 100%;​
//					float: none;
//				}
//			​} ';
//			$this->_getAssetsRenderer()->createCssRule(false)->setContent($css);
		}

		$designs = array(
			'static' => array('min992', '.ark-header:not(.header-shrink)'),
			'fixed'  => array('min992', '.ark-header.header-shrink'),
			'mobile' => array('max991', '.ark-header'),
		);

		foreach( $designs as $design_type => $design_settings ){
			$design_bp = $design_settings[0];
			$design_selector = $design_settings[1];



			/* HEADERS BG, SHADOW, BORDER */

			$type = 'header-design '.$design_type;
			$selector = ' ' . $design_selector;

			$bgColor = $query->getColor($type.' bg-color');
			if( !empty($bgColor) ){
				$this->_renderCSSHeaderRule($design_bp, 'background-color', $bgColor, $selector . ' .navbar');
				$this->_renderCSSHeaderRule($design_bp, 'background-color', 'transparent !important', $selector);
			}

			$borderColor = $query->getColor($type.' border-color');
			if( !empty($borderColor) ){
				$this->_renderCSSHeaderRule($design_bp, 'border-bottom', '1px solid ' . $borderColor, $selector);
			}

			$shadowColor = $query->getColor($type.' shadow-color');
			if( !empty($shadowColor) ){
				$this->_renderCSSHeaderRule($design_bp, 'box-shadow', ' 0 0 15px '.$shadowColor, $selector . ' .ff-ark-header-circle-shadow:before');
			}



			/* FIRST LEVEL MENU BG AND TEXT COLOR */

			$type = 'ark-first-level-menu '.$design_type;
			$selector = ' ' . $design_selector . ' .menu-container>ul>li>a.nav-item-child';

			$this->_renderCSSHeaderRule($design_bp, 'color', $query->getColor( $type . ' color' ), $selector);
			$this->_renderCSSHeaderRule($design_bp, 'color', $query->getColor( $type . ' color-current' ), ' ' . $design_selector . ' .menu-container>ul>li.current-menu-ancestor>a.nav-item-child');
			$this->_renderCSSHeaderRule($design_bp, 'color', $query->getColor( $type . ' color-current' ), ' ' . $design_selector . ' .menu-container>ul>li.current-menu-item>a.nav-item-child');
			$this->_renderCSSHeaderRule($design_bp, 'color', $query->getColor( $type . ' color-current' ), ' ' . $design_selector . ' .menu-container>ul>li.active>a.nav-item-child');
			$this->_renderCSSHeaderRuleImportant($design_bp, 'color', $query->getColor( $type . ' color-hover' ), ' ' . $design_selector . ' .menu-container>ul>li:hover>a.nav-item-child');

			if( ( $design_bp == 'max991' ) and ( $query->get('header-mobile-force-submenu' ) ) ){
				$this->_renderCSSHeaderRule($design_bp, 'background-color', $query->getColor($type . ' bg-color'), $selector.':not(.dropdown-toggle)');
				$this->_renderCSSHeaderRule($design_bp, 'background-color', $query->getColor($type . ' bg-color-current'), ' ' . $design_selector . ' .menu-container>ul>li.current-menu-ancestor>a.nav-item-child:not(.dropdown-toggle)');
				$this->_renderCSSHeaderRule($design_bp, 'background-color', $query->getColor($type . ' bg-color-current'), ' ' . $design_selector . ' .menu-container>ul>li.current-menu-item>a.nav-item-child:not(.dropdown-toggle)');
				$this->_renderCSSHeaderRule($design_bp, 'background-color', $query->getColor($type . ' bg-color-current'), ' ' . $design_selector . ' .menu-container>ul>li.active>a.nav-item-child:not(.dropdown-toggle)');
				$this->_renderCSSHeaderRuleImportant($design_bp, 'background-color', $query->getColor($type . ' bg-color-hover'), ' ' . $design_selector . ' .menu-container>ul>li:hover>a.nav-item-child:not(.dropdown-toggle)');


				$this->_renderCSSHeaderRule($design_bp, 'background',

					'linear-gradient(to right, transparent 0%,transparent 90%,'.
					$query->getColor($type . ' bg-color')
					. ' 90%, ' .
					$query->getColor($type . ' bg-color')
					. '  100%) '

					, $selector);
				$this->_renderCSSHeaderRule($design_bp, 'background',

					'linear-gradient(to right, transparent 0%,transparent 90%,'.
					$query->getColor($type . ' bg-color-current')
					. ' 90%, ' .
					$query->getColor($type . ' bg-color-current')
					. '  100%) '

					, ' ' . $design_selector . ' .menu-container>ul>li.current-menu-ancestor>a.nav-item-child.dropdown-toggle');
				$this->_renderCSSHeaderRule($design_bp, 'background',

					'linear-gradient(to right, transparent 0%,transparent 90%,'.
					$query->getColor($type . ' bg-color-current')
					. ' 90%, ' .
					$query->getColor($type . ' bg-color-current')
					. '  100%) '

					, ' ' . $design_selector . ' .menu-container>ul>li.current-menu-item>a.nav-item-child.dropdown-toggle');
				$this->_renderCSSHeaderRule($design_bp, 'background',

					'linear-gradient(to right, transparent 0%,transparent 90%,'.
					$query->getColor($type . ' bg-color-current')
					. ' 90%, ' .
					$query->getColor($type . ' bg-color-current')
					. '  100%) '

					, ' ' . $design_selector . ' .menu-container>ul>li.active>a.nav-item-child.dropdown-toggle');
				$this->_renderCSSHeaderRuleImportant($design_bp, 'background',

					'linear-gradient(to right, transparent 0%,transparent 90%,'.
					$query->getColor($type . ' bg-color-hover')
					. ' 90%, ' .
					$query->getColor($type . ' bg-color-hover')
					. '  100%) '

					, ' ' . $design_selector . ' .menu-container>ul>li:hover>a.nav-item-child.dropdown-toggle');


			}else {
				$this->_renderCSSHeaderRule($design_bp, 'background-color', $query->getColor($type . ' bg-color'), $selector);
				$this->_renderCSSHeaderRule($design_bp, 'background-color', $query->getColor($type . ' bg-color-current'), ' ' . $design_selector . ' .menu-container>ul>li.current-menu-ancestor>a.nav-item-child');
				$this->_renderCSSHeaderRule($design_bp, 'background-color', $query->getColor($type . ' bg-color-current'), ' ' . $design_selector . ' .menu-container>ul>li.current-menu-item>a.nav-item-child');
				$this->_renderCSSHeaderRule($design_bp, 'background-color', $query->getColor($type . ' bg-color-current'), ' ' . $design_selector . ' .menu-container>ul>li.active>a.nav-item-child');
				$this->_renderCSSHeaderRuleImportant($design_bp, 'background-color', $query->getColor($type . ' bg-color-hover'), ' ' . $design_selector . ' .menu-container>ul>li:hover>a.nav-item-child');
			}


			/* ICONS - WOOCOMMERCE, SEARCH */

			$type = 'ark-first-level-menu-icons '.$design_type;
			$selector = ' ' . $design_selector . '  .navbar-actions>.navbar-actions-shrink';

			$this->_renderCSSHeaderRule($design_bp, 'color', $query->getColor( $type . ' color' ), $selector . '>a');
			$this->_renderCSSHeaderRule($design_bp, 'color', $query->getColor( $type . ' color' ), $selector . '>a i');
			$this->_renderCSSHeaderRule($design_bp, 'color', $query->getColor( $type . ' color' ), $selector . ' .navbar-special-icon');
			$this->_renderCSSHeaderRule($design_bp, 'color', $query->getColor( $type . ' color-hover' ), $selector . ':hover>a');
			$this->_renderCSSHeaderRule($design_bp, 'color', $query->getColor( $type . ' color-hover' ), $selector . ':hover>a i');
			$this->_renderCSSHeaderRule($design_bp, 'color', $query->getColor( $type . ' color-hover' ), $selector . ':hover .navbar-special-icon');

			/* SIDEBAR TRIGGER */
			$this->_renderCSSHeaderRule($design_bp, 'background-color', $query->getColor( $type . ' color' ), $selector . ':not(.is-clicked) .sidebar-trigger-icon');
			$this->_renderCSSHeaderRule($design_bp, 'background-color', $query->getColor( $type . ' color' ), $selector . ' .sidebar-trigger-icon:before');
			$this->_renderCSSHeaderRule($design_bp, 'background-color', $query->getColor( $type . ' color' ), $selector . ' .sidebar-trigger-icon:after');
			$this->_renderCSSHeaderRule($design_bp, 'background-color', $query->getColor( $type . ' color-hover' ), $selector . ':hover:not(.is-clicked) .sidebar-trigger-icon');
			$this->_renderCSSHeaderRule($design_bp, 'background-color', $query->getColor( $type . ' color-hover' ), $selector . ':hover .sidebar-trigger-icon:before');
			$this->_renderCSSHeaderRule($design_bp, 'background-color', $query->getColor( $type . ' color-hover' ), $selector . ':hover .sidebar-trigger-icon:after');



			/* SUB MENU */

			$type = 'ark-sub-level-menu ' . $design_type;

			$this->_renderCSSHeaderRule($design_bp, 'color', $query->getColor( $type . ' color' ), ' ' . $design_selector . ' ul.dropdown-menu a.ffb-ark-sub-level-menu');
			$this->_renderCSSHeaderRule($design_bp, 'color', $query->getColor( $type . ' color-current' ), ' ' . $design_selector . ' ul.dropdown-menu li.current-menu-ancestor>a.ffb-ark-sub-level-menu');
			$this->_renderCSSHeaderRule($design_bp, 'color', $query->getColor( $type . ' color-current' ), ' ' . $design_selector . ' ul.dropdown-menu li.current-menu-item>a.ffb-ark-sub-level-menu');
			$this->_renderCSSHeaderRule($design_bp, 'color', $query->getColor( $type . ' color-current' ), ' ' . $design_selector . ' ul.dropdown-menu li.active>a.ffb-ark-sub-level-menu');
			$this->_renderCSSHeaderRule($design_bp, 'color', $query->getColor( $type . ' color' ), ' ' . $design_selector . ' ul.mega-menu-list .mega-menu-title');
			$this->_renderCSSHeaderRule($design_bp, 'color', $query->getColor( $type . ' color' ), ' ' . $design_selector . ' ul.mega-menu-list a.ffb-ark-sub-level-menu');
			$this->_renderCSSHeaderRule($design_bp, 'color', $query->getColor( $type . ' color-current' ), ' ' . $design_selector . ' ul.mega-menu-list li.current-menu-ancestor>a.ffb-ark-sub-level-menu');
			$this->_renderCSSHeaderRule($design_bp, 'color', $query->getColor( $type . ' color-current' ), ' ' . $design_selector . ' ul.mega-menu-list li.current-menu-item>a.ffb-ark-sub-level-menu');
			$this->_renderCSSHeaderRule($design_bp, 'color', $query->getColor( $type . ' color-current' ), ' ' . $design_selector . ' ul.mega-menu-list li.active>a.ffb-ark-sub-level-menu');
			$this->_renderCSSHeaderRuleImportant($design_bp, 'color', $query->getColor( $type . ' color-hover' ), ' ' . $design_selector . ' ul.dropdown-menu a.ffb-ark-sub-level-menu:hover');
			$this->_renderCSSHeaderRuleImportant($design_bp, 'color', $query->getColor( $type . ' color-hover' ), ' ' . $design_selector . ' ul.mega-menu-list a.ffb-ark-sub-level-menu:hover');

			$this->_renderCSSHeaderRule($design_bp, 'background-color', $query->getColor( $type . ' bg-color' ), $design_selector . ' ul.dropdown-menu');
			$this->_renderCSSHeaderRule($design_bp, 'background-color', $query->getColor( $type . ' bg-color-current' ), ' ' . $design_selector . ' ul.dropdown-menu li.current-menu-ancestor>a.ffb-ark-sub-level-menu');
			$this->_renderCSSHeaderRule($design_bp, 'background-color', $query->getColor( $type . ' bg-color-current' ), ' ' . $design_selector . ' ul.mega-menu-list li.current-menu-ancestor>a.ffb-ark-sub-level-menu');
			$this->_renderCSSHeaderRule($design_bp, 'background-color', $query->getColor( $type . ' bg-color-current' ), ' ' . $design_selector . ' ul.dropdown-menu li.current-menu-item>a.ffb-ark-sub-level-menu');
			$this->_renderCSSHeaderRule($design_bp, 'background-color', $query->getColor( $type . ' bg-color-current' ), ' ' . $design_selector . ' ul.mega-menu-list li.current-menu-item>a.ffb-ark-sub-level-menu');
			$this->_renderCSSHeaderRule($design_bp, 'background-color', $query->getColor( $type . ' bg-color-current' ), ' ' . $design_selector . ' ul.dropdown-menu li.active>a.ffb-ark-sub-level-menu');
			$this->_renderCSSHeaderRule($design_bp, 'background-color', $query->getColor( $type . ' bg-color-current' ), ' ' . $design_selector . ' ul.mega-menu-list li.active>a.ffb-ark-sub-level-menu');
			$this->_renderCSSHeaderRuleImportant($design_bp, 'background-color', $query->getColor( $type . ' bg-color-hover' ), ' ' . $design_selector . ' ul.dropdown-menu a.ffb-ark-sub-level-menu:hover');
			$this->_renderCSSHeaderRuleImportant($design_bp, 'background-color', $query->getColor( $type . ' bg-color-hover' ), ' ' . $design_selector . ' ul.mega-menu-list a.ffb-ark-sub-level-menu:hover');

			if( 'mobile' !== $design_type ) {
				$shadowColor = $query->getColorWithoutComparationDefault($type . ' shadow-color', 'rgba(0,0,0,0.06)');
				if ($shadowColor) {
					$this->_renderCSSHeaderRule($design_bp, 'box-shadow', '0 5px 20px ' . $shadowColor, $design_selector . ' ul.dropdown-menu');
				}
			}

			if( class_exists('WooCommerce') ) {

				/* ICON IN THE MENU */

				$c_type = 'cart-menu-item ' . $design_type;


				$this->_renderCSSHeaderRule($design_bp, 'color', $query->getColorWithoutComparationDefault($c_type . ' link color'), $design_selector . ' .ffb-cart-menu-item');
				$this->_renderCSSHeaderRule($design_bp, 'color', $query->getColorWithoutComparationDefault($c_type . ' link color'), $design_selector . ' .ffb-cart-menu-item .shopping-cart-icon-wrapper');
				$this->_renderCSSHeaderRule($design_bp, 'background-color', $query->getColorWithoutComparationDefault($c_type . ' link bg-color'), $design_selector . ' .ffb-cart-menu-item');

				$this->_renderCSSHeaderRule($design_bp, 'color', $query->getColorWithoutComparationDefault($c_type . ' link color-hover'), $design_selector . ' .ffb-cart-menu-item:hover');
				$this->_renderCSSHeaderRule($design_bp, 'color', $query->getColorWithoutComparationDefault($c_type . ' link color-hover'), $design_selector . ' .ffb-cart-menu-item:hover .shopping-cart-icon-wrapper:hover');
				$this->_renderCSSHeaderRule($design_bp, 'background-color', $query->getColorWithoutComparationDefault($c_type . ' link bg-color-hover'), $design_selector . ' .ffb-cart-menu-item:hover');

				$this->_renderCSSHeaderRule($design_bp, 'color', $query->getColorWithoutComparationDefault($c_type . ' count color'), $design_selector . ' .ffb-cart-menu-item .shopping-cart-icon-wrapper:after');
				$this->_renderCSSHeaderRule($design_bp, 'background-color', $query->getColorWithoutComparationDefault($c_type . ' count bg-color'), $design_selector . ' .ffb-cart-menu-item .shopping-cart-icon-wrapper:after');

				$this->_renderCSSHeaderRule($design_bp, 'color', $query->getColorWithoutComparationDefault($c_type . ' count color-hover'), $design_selector . ' .ffb-cart-menu-item:hover .shopping-cart-icon-wrapper:after');
				$this->_renderCSSHeaderRule($design_bp, 'background-color', $query->getColorWithoutComparationDefault($c_type . ' count bg-color-hover'), $design_selector . ' .ffb-cart-menu-item:hover .shopping-cart-icon-wrapper:after');

				/* WOOCOMERCE SUBMENU ITEMS */

				$c_type = 'cart-submenu ' . $design_type;

				$this->_renderCSSHeaderRule($design_bp, 'background-color', $query->getColorWithoutComparationDefault($c_type . ' bg-color'), $design_selector . ' .ffb-cart-submenu');
			}
		}
		if( class_exists('WooCommerce') ) {
			$this->_renderCSSHeaderRule('min992', 'background-color', $query->getColorWithoutComparationDefault('cart-submenu backdrop static backdrop-color'), '.ark-header:not(.header-shrink) .shopping-cart-wrapper.open:before');
			$this->_renderCSSHeaderRule('min992', 'background-color', $query->getColorWithoutComparationDefault('cart-submenu backdrop fixed backdrop-color'), '.ark-header.header-shrink .shopping-cart-wrapper.open:before');
		}

		if( class_exists('WooCommerce') ) {
			$cart_width_sm = $query->getWithoutComparationDefault('cart-width-sm', null);
			$cart_width_sm = absint( $cart_width_sm );

			if( 0 != $cart_width_sm ) {
				$cart_type_sm = $query->getWithoutComparationDefault('woocommerce-shopping-cart-type-xs', 'ark-cart-left-side-xs');

				$css = '@media (min-width: 768px) and (max-width: 991px) { ';
				if( 'ark-cart-left-side-xs' == $cart_type_sm ) {
					$css .= 'header.ark-cart-left-side-xs .shopping-cart-wrapper.open .shopping-cart-menu { ';
						$css .= 'transform: translateX( ' . $cart_width_sm . 'px );';
					$css .= '}';
					$css .= 'header.ark-cart-left-side-xs .shopping-cart-menu { ';
						$css .= 'left: -'.$cart_width_sm.'px;';
						$css .= 'width: '.$cart_width_sm.'px;';
					$css .= '}';
				}else{
					$css .= 'header.ark-cart-right-side-xs .shopping-cart-wrapper.open .shopping-cart-menu { ';
						$css .= 'transform: translateX( -' . $cart_width_sm . 'px );';
					$css .= '}';
					$css .= 'header.ark-cart-right-side-xs .shopping-cart-menu { ';
						$css .= 'right: -'.$cart_width_sm.'px;';
						$css .= 'width: '.$cart_width_sm.'px;';
					$css .= '}';
				}
				$css .= '}';

				$this->_getAssetsRenderer()->createCssRule(false)->setContent($css);
			}

			$cart_width_md = absint( $query->getWithoutComparationDefault('cart-width-md', null) );
			$cart_width_lg = absint( $query->getWithoutComparationDefault('cart-width-lg', null) );

			$menuWidth = absint( $query->getWithoutComparationDefault('vertical-width', null) );

			$cart_type_md = $query->getWithoutComparationDefault('woocommerce-shopping-cart-type', 'ark-cart-classic');
			if( 'ark-cart-classic' == $cart_type_md ){
				$cart_type_md = 'ark-cart-next-to';
			}

			if( ! empty($menuWidth) and ( 'ark-cart-next-to' == $cart_type_md ) ){
				if( 0 == $cart_width_md ) {
					$cart_width_md = 258;
				}
			}

			if( ( 0 != $cart_width_md ) or ( 0 != $cart_width_lg ) ) {

				if( empty( $menuWidth ) ) {
					$menuWidth = 258;
				}

				foreach( array( 992 => $cart_width_md, 1200 => $cart_width_lg ) as $bp_size => $cart_width ){
					if( 0 == $cart_width ){
						continue;
					}

					$css = '@media (min-width: ' . $bp_size . 'px) { ';
					if( 'ark-cart-left-side' == $cart_type_md ) {
						$css .= 'header.ark-cart-left-side .shopping-cart-wrapper.open .shopping-cart-menu { ';
							$css .= 'transform: translateX( ' . $cart_width . 'px );';
						$css .= '}';
						$css .= 'header.ark-cart-left-side .shopping-cart-menu { ';
							$css .= 'left: -'.$cart_width.'px;';
							$css .= 'width: '.$cart_width.'px;';
						$css .= '}';
					} else if( 'ark-cart-right-side' == $cart_type_md ) {
						$css .= 'header.ark-cart-right-side .shopping-cart-wrapper.open .shopping-cart-menu { ';
							$css .= 'transform: translateX( -' . $cart_width . 'px );';
						$css .= '}';
						$css .= 'header.ark-cart-right-side .shopping-cart-menu { ';
							$css .= 'right: -'.$cart_width.'px;';
							$css .= 'width: '.$cart_width.'px;';
						$css .= '}';
					} else {
						$css .= '.ark-header.ark-cart-classic .shopping-cart .shopping-cart-menu { ';
							$css .= 'width: '.$cart_width.'px;';
						$css .= '}';
					}
					$css .= '}';

					$this->_getAssetsRenderer()->createCssRule(false)->setContent($css);
				}
			}

		}


		echo  '<div class="page-wrapper">';
	}

	/**
	 * @param $query ffOptionsQueryDynamic
	 */
	protected function _renderFullscreenNavigation( $query ){
		echo '<div class="wrapper ff-boxed-wrapper';
		if ( ffThemeOptions::getQuery('layout enable-pageloader') ) {
			echo ' animsition ';
		}
		echo '">';

		$this->_advancedToggleBoxStart( $query, 'header-design' );

		?><header class="ark-header header-fullscreen <?php echo esc_attr($query->get('horizontal-position')); ?>">
			<div class="navbar-fullscreen-navbar">
				<div class="<?php $this->_renderContainerClass($query) ?>">
					<div class="header-fullscreen-nav-actions-left header-fullscreen-col">
						<?php
						if( $query->getWithoutComparationDefault('menu disable-nav-menu', 0)){
							echo '<!-- Menu Disabled -->';
						}else{
						?>
						<a class="header-fullscreen-nav-trigger ffb-ark-first-level-menu" href="javascript:void(0);"><i class="header-fullscreen-nav-trigger-icon"></i></a>
						<?php } ?>
					</div>
					<div class="header-fullscreen-col">
						<?php $this->_renderLogo($query); ?>
					</div>
					<?php if( $query->get('get-in-touch show') ){ ?>
						<div class="header-fullscreen-nav-actions-right header-fullscreen-col form-modal-nav">
							<?php $this->navigation__get_in_touch_html($query); ?>
						</div>
					<?php } ?>
				</div>
			</div>
			<?php
			if( $query->getWithoutComparationDefault('menu disable-nav-menu', 0)){
				echo '<!-- Menu Disabled -->';
			}else{
			?>
			<nav class="header-fullscreen-nav-overlay">
				<div class="header-fullscreen-nav-overlay-content">
					<ul class="header-fullscreen-menu">
						<?php

						locate_template('builder/helpers/Walker_Nav_Menu_Ark_Fullscreen.php', true, true);

						if( $query->get('menu use-custom') ){
							$menu_id = absint( $query->getSingleSelect2('menu nav-menu') );
						}else{
							$menu_id = 0;
						}

						if( empty( $menu_id ) ) {
							$locations = get_nav_menu_locations();
							if (isSet($locations['main-nav']) and !empty($locations['main-nav'])) {
								$menu_id = absint($locations['main-nav']);
							}
						}

						if( empty( $menu_id ) ){
							Walker_Nav_Menu_Ark_fallback( null );
						}else{
							wp_nav_menu(
								array(
									'menu'           => $menu_id,
									'depth'          => 0,
									'container'      => false,
									'items_wrap'     => '%3$s',
									'walker'         => new Walker_Nav_Menu_Ark_Fullscreen(),
									'fallback_cb'    => 'Walker_Nav_Menu_ark_fallback',
								)
							);
						}
						?>
					</ul>
				</div>
			</nav>
			<?php } ?>
			<?php
				$this->_advancedToggleBoxStart( $query, 'fullscreen-menu-design' );
				echo '<div class="header-fullscreen-nav-bg-overlay">
						<a class="header-fullscreen-nav-close radius-circle" href="javascript:void(0);">&times;</a>
					</div>';
				$this->_advancedToggleBoxEnd( $query, 'fullscreen-menu-design' );
			?>
		</header><?php

		$this->_advancedToggleBoxEnd( $query, 'header-design' );

		// menu opening button
		if( $query->getWithoutComparationDefault('fullscreen-menu-button-position', 'left') == 'right' ) {
			$css = '.header-fullscreen .header-fullscreen-col,' . "\n";
			$css .= '.header-fullscreen .header-fullscreen-nav-actions-left .header-fullscreen-nav-trigger {float:right;}';
			$this->_getAssetsRenderer()->createCssRule(false)->setContent($css);
			$this->_getAssetsRenderer()->createCssRule(false)->setContent('.header-fullscreen .header-fullscreen-nav-actions-right{text-align:left;}');
		}



		/* OTHERS TOGGLE BOX + FIRST LEVEL MENU */

		$this->_advancedToggleBoxStart( $query, 'ark-first-level-menu' );
		$this->_advancedToggleBoxEnd( $query, 'ark-first-level-menu' );



		/* SUB LEVEL MENU */

		$this->_advancedToggleBoxStart( $query, 'ark-sub-level-menu' );
		$this->_advancedToggleBoxEnd( $query, 'ark-sub-level-menu' );



		$designs = array(
			'static' => array('min992', '.ark-header:not(.header-shrink)'),
			'fixed'  => array('min992', '.ark-header.header-shrink'),
			'mobile' => array('max991', '.ark-header'),
		);

		foreach( $designs as $design_type => $design_settings ){
			$design_bp = $design_settings[0];
			$design_selector = $design_settings[1];



			/* HEADERS BACKGROUND AND BOTTOM SHADOW */

			$type = 'header-design '.$design_type;
			$selector = ' ' . $design_selector;

			$bgColor = $query->getColor($type.' bg-color');
			if( !empty($bgColor) ){
				$this->_renderCSSHeaderRule($design_bp, 'background-color', $bgColor, $selector . ' .navbar-fullscreen-navbar');
				$this->_renderCSSHeaderRule($design_bp, 'background-color', 'transparent !important', $selector);
			}

			$shadowColor = $query->getColor($type.' shadow-color');
			if( !empty($shadowColor) ){
				$this->_renderCSSHeaderRule($design_bp, 'box-shadow', ' 0 0 15px '.$shadowColor, $selector . ' .navbar-fullscreen-navbar');
			}

			$borderColor = $query->getColor($type.' border-color');
			if( !empty($borderColor) ){
				$this->_renderCSSHeaderRule($design_bp, 'border-bottom', '1px solid ' . $borderColor, $selector);
			}


			/* NAVIGATION TRIGGER BUTTON */
			$type = 'ark-first-level-menu-icons '.$design_type;
			$selector = ' ' . $design_selector . ' .header-fullscreen-nav-trigger';

			$this->_renderCSSHeaderRule($design_bp, 'background-color', $query->getColor( $type . ' color' ), $selector . ':not(.is-clicked) .header-fullscreen-nav-trigger-icon');
			$this->_renderCSSHeaderRule($design_bp, 'background-color', $query->getColor( $type . ' color' ), $selector . ' .header-fullscreen-nav-trigger-icon:before');
			$this->_renderCSSHeaderRule($design_bp, 'background-color', $query->getColor( $type . ' color' ), $selector . ' .header-fullscreen-nav-trigger-icon:after');
			$this->_renderCSSHeaderRule($design_bp, 'background-color', $query->getColor( $type . ' color-hover' ), $selector . ':hover:not(.is-clicked) .header-fullscreen-nav-trigger-icon');
			$this->_renderCSSHeaderRule($design_bp, 'background-color', $query->getColor( $type . ' color-hover' ), $selector . ':hover .header-fullscreen-nav-trigger-icon:before');
			$this->_renderCSSHeaderRule($design_bp, 'background-color', $query->getColor( $type . ' color-hover' ), $selector . ':hover .header-fullscreen-nav-trigger-icon:after');

			/* SIDEBAR TRIGGER */

			$type = 'ark-first-level-menu-icons '.$design_type;
			$selector = ' ' . $design_selector . ' .sidebar-trigger';

			$this->_renderCSSHeaderRule($design_bp, 'background-color', $query->getColor( $type . ' color' ), $selector . ':not(.is-clicked) .sidebar-trigger-icon');
			$this->_renderCSSHeaderRule($design_bp, 'background-color', $query->getColor( $type . ' color' ), $selector . ' .sidebar-trigger-icon:before');
			$this->_renderCSSHeaderRule($design_bp, 'background-color', $query->getColor( $type . ' color' ), $selector . ' .sidebar-trigger-icon:after');
			$this->_renderCSSHeaderRule($design_bp, 'background-color', $query->getColor( $type . ' color-hover' ), $selector . ':hover:not(.is-clicked) .sidebar-trigger-icon');
			$this->_renderCSSHeaderRule($design_bp, 'background-color', $query->getColor( $type . ' color-hover' ), $selector . ':hover .sidebar-trigger-icon:before');
			$this->_renderCSSHeaderRule($design_bp, 'background-color', $query->getColor( $type . ' color-hover' ), $selector . ':hover .sidebar-trigger-icon:after');
		}



		/* FULLSCREEN MENU - BACKGROUND */

		$this->_renderCSSRule('color', $query->getColor( 'ark-first-level-menu mobile color' ), ' .header-fullscreen .header-fullscreen-nav-bg-overlay .header-fullscreen-nav-close');
		$this->_renderCSSRule('color', $query->getColor( 'ark-first-level-menu mobile color-hover' ), ' .header-fullscreen .header-fullscreen-nav-bg-overlay .header-fullscreen-nav-close:hover');
		$this->_renderCSSRule('background-color', $query->getColor( 'ark-first-level-menu mobile bg-color' ), ' .header-fullscreen .header-fullscreen-nav-bg-overlay .header-fullscreen-nav-close');
		$this->_renderCSSRule('background-color', $query->getColor( 'ark-first-level-menu mobile bg-color-hover' ), ' .header-fullscreen .header-fullscreen-nav-bg-overlay .header-fullscreen-nav-close:hover');



		/* FULLSCREEN MENU - FIRST LEVEL */

		$this->_renderCSSRule('color', $query->getColor( 'ark-first-level-menu mobile color' ), ' .ark-header nav.header-fullscreen-nav-overlay ul.header-fullscreen-menu > li > a.nav-item-child');
		$this->_renderCSSRule('color', $query->getColor( 'ark-first-level-menu mobile color' ), ' .ark-header nav.header-fullscreen-nav-overlay ul.header-fullscreen-menu > li > a.nav-item-child:after');
		$this->_renderCSSRule('color', $query->getColor( 'ark-first-level-menu mobile color-current' ), ' .ark-header nav.header-fullscreen-nav-overlay ul.header-fullscreen-menu > li.current-menu-ancestor > a.nav-item-child');
		$this->_renderCSSRule('color', $query->getColor( 'ark-first-level-menu mobile color-current' ), ' .ark-header nav.header-fullscreen-nav-overlay ul.header-fullscreen-menu > li.current-menu-ancestor > a.nav-item-child:after');
		$this->_renderCSSRule('color', $query->getColor( 'ark-first-level-menu mobile color-current' ), ' .ark-header nav.header-fullscreen-nav-overlay ul.header-fullscreen-menu > li.current-menu-item > a.nav-item-child');
		$this->_renderCSSRule('color', $query->getColor( 'ark-first-level-menu mobile color-current' ), ' .ark-header nav.header-fullscreen-nav-overlay ul.header-fullscreen-menu > li.current-menu-item > a.nav-item-child:after');
		$this->_renderCSSRuleImportant('color', $query->getColor( 'ark-first-level-menu mobile color-hover' ), ' .ark-header nav.header-fullscreen-nav-overlay ul.header-fullscreen-menu > li > a.nav-item-child:hover');
		$this->_renderCSSRuleImportant('color', $query->getColor( 'ark-first-level-menu mobile color-hover' ), ' .ark-header nav.header-fullscreen-nav-overlay ul.header-fullscreen-menu > li > a.nav-item-child:hover:after');
		$this->_renderCSSRule('background-color', $query->getColor( 'ark-first-level-menu mobile bg-color' ), ' .ark-header nav.header-fullscreen-nav-overlay ul.header-fullscreen-menu > li > a.nav-item-child');
		$this->_renderCSSRule('background-color', $query->getColor( 'ark-first-level-menu mobile bg-color-current' ), ' .ark-header nav.header-fullscreen-nav-overlay ul.header-fullscreen-menu > li.current-menu-ancestor > a.nav-item-child');
		$this->_renderCSSRule('background-color', $query->getColor( 'ark-first-level-menu mobile bg-color-current' ), ' .ark-header nav.header-fullscreen-nav-overlay ul.header-fullscreen-menu > li.current-menu-item > a.nav-item-child');
		$this->_renderCSSRuleImportant('background-color', $query->getColor( 'ark-first-level-menu mobile bg-color-hover' ), ' .ark-header nav.header-fullscreen-nav-overlay ul.header-fullscreen-menu > li > a.nav-item-child:hover');



		/* FULLSCREEN MENU - SUB LEVEL */

		$this->_renderCSSRule('color', $query->getColor( 'ark-sub-level-menu mobile color' ), ' .ark-header nav.header-fullscreen-nav-overlay a.ffb-ark-sub-level-menu');
		$this->_renderCSSRule('color', $query->getColor( 'ark-sub-level-menu mobile color' ), ' .ark-header nav.header-fullscreen-nav-overlay a.ffb-ark-sub-level-menu:after');
		$this->_renderCSSRule('color', $query->getColor( 'ark-sub-level-menu mobile color-current' ), ' .ark-header nav.header-fullscreen-nav-overlay li.current-menu-ancestor > a.ffb-ark-sub-level-menu');
		$this->_renderCSSRule('color', $query->getColor( 'ark-sub-level-menu mobile color-current' ), ' .ark-header nav.header-fullscreen-nav-overlay li.current-menu-ancestor > a.ffb-ark-sub-level-menu:after');
		$this->_renderCSSRule('color', $query->getColor( 'ark-sub-level-menu mobile color-current' ), ' .ark-header nav.header-fullscreen-nav-overlay li.current-menu-item > a.ffb-ark-sub-level-menu');
		$this->_renderCSSRule('color', $query->getColor( 'ark-sub-level-menu mobile color-current' ), ' .ark-header nav.header-fullscreen-nav-overlay li.current-menu-item > a.ffb-ark-sub-level-menu:after');
		$this->_renderCSSRuleImportant('color', $query->getColor( 'ark-sub-level-menu mobile color-hover' ), ' .ark-header nav.header-fullscreen-nav-overlay a.ffb-ark-sub-level-menu:hover');
		$this->_renderCSSRuleImportant('color', $query->getColor( 'ark-sub-level-menu mobile color-hover' ), ' .ark-header nav.header-fullscreen-nav-overlay a.ffb-ark-sub-level-menu:hover:after');
		$this->_renderCSSRule('background-color', $query->getColor( 'ark-sub-level-menu mobile bg-color' ), ' .ark-header nav.header-fullscreen-nav-overlay a.ffb-ark-sub-level-menu');
		$this->_renderCSSRule('background-color', $query->getColor( 'ark-sub-level-menu mobile bg-color-current' ), ' .ark-header nav.header-fullscreen-nav-overlay li.current-menu-ancestor > a.ffb-ark-sub-level-menu');
		$this->_renderCSSRule('background-color', $query->getColor( 'ark-sub-level-menu mobile bg-color-current' ), ' .ark-header nav.header-fullscreen-nav-overlay li.current-menu-item > a.ffb-ark-sub-level-menu');
		$this->_renderCSSRuleImportant('background-color', $query->getColor( 'ark-sub-level-menu mobile bg-color-hover' ), ' .ark-header nav.header-fullscreen-nav-overlay a.ffb-ark-sub-level-menu:hover');


		wp_enqueue_script( 'ark-header-fullscreen' );
	}


	protected function _render( ffOptionsQueryDynamic $query, $content, $data, $uniqueId ) {

		switch( $query->get('design-type') ){
			case 'vertical-multi':
			case 'vertical-onepage':
				$this->_renderVerticalHeader($query);
				break;
			case 'fullscreen':
				$this->_renderFullscreenNavigation($query);
				break;
			case 'header':
			case 'header-center-aligned':
				$this->_renderHorizontalNavigation($query);
				break;
			default:
				break;
		}
	}

	protected function _renderContentInfo_JS() {
	?>
		<script data-type="ffscript">
			function ( query, options, $slementPreview, $slement ) {
			}
		</script data-type="ffscript">
	<?php
	}


}