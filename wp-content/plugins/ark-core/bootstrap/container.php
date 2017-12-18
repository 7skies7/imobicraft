<?php
class ffPluginArkCoreContainer extends ffPluginContainerAbstract {
	/**
	 * @var ffPluginArkCore
	 */
	private static $_instance = null;

	const STRUCTURE_NAME = 'ff_fresh_favicon';

	/**
	 * @param ffContainer $container
	 * @param string $pluginDir
	 * @return ffPluginArkCoreContainer
	 */
	public static function getInstance( ffContainer $container = null, $pluginDir = null ) {
		if( self::$_instance == null ) {
			self::$_instance = new ffPluginArkCoreContainer($container, $pluginDir);
		}

		return self::$_instance;
	}

	protected function _registerFiles() {
		$cl = $this->_getClassLoader();

		$pluginDir = $this->_getPluginDir();
		$classLoader =$this->getFrameworkContainer()->getClassLoader();

		$classLoader->addClass('ffShortcodeDropcap', $pluginDir . '/components/shortcodes/class.ffShortcodeDropcap.php' );
		$classLoader->addClass('ffShortcodeTemplate', $pluginDir . '/components/shortcodes/class.ffShortcodeTemplate.php' );
//		$classLoader->addClass('ffShortcodeHeaderUnderlined', $pluginDir . '/components/shortcodes/class.ffShortcodeHeaderUnderlined.php' );
//		$classLoader->addClass('ffShortcodeMark', $pluginDir . '/components/shortcodes/class.ffShortcodeMark.php' );

		$this->_registerThemeBuilderElements();
	}

	private function _registerThemeBuilderMenus() {
		$themeBuilderManager = ffContainer()->getThemeFrameworkFactory()->getThemeBuilderManager();

		$themeBuilderManager->addMenuItem( ark_wp_kses( __( 'All', 'ark' ) ), '*');

		$themeBuilderManager->addMenuItem( ark_wp_kses( __( '<div class="ffb-filterable-library__filters-divider"></div>', 'ark' ) ), 'filters-divider1');

		$themeBuilderManager->addMenuItem( ark_wp_kses( __( 'Basic', 'ark' ) ), 'basic');
		$themeBuilderManager->addMenuItem( ark_wp_kses( __( 'Grid', 'ark' ) ), 'grid');
		$themeBuilderManager->addMenuItem( ark_wp_kses( __( 'Loop', 'ark' ) ), 'loop');
		$themeBuilderManager->addMenuItem( ark_wp_kses( __( 'Form', 'ark' ) ), 'form');

		$themeBuilderManager->addMenuItem( ark_wp_kses( __( '<div class="ffb-filterable-library__filters-divider"></div>', 'ark' ) ), 'filters-divider2');

		$themeBuilderManager->addMenuItem( ark_wp_kses( __( 'Accordion', 'ark' ) ), 'accordion');
		$themeBuilderManager->addMenuItem( ark_wp_kses( __( 'Alert', 'ark' ) ), 'alert');
		$themeBuilderManager->addMenuItem( ark_wp_kses( __( 'Blog', 'ark' ) ), 'blog');
		$themeBuilderManager->addMenuItem( ark_wp_kses( __( 'Call To Action', 'ark' ) ), 'cta');
		// HAS BEEN MOVED TO COUNTERS $themeBuilderManager->addMenuItem( ark_wp_kses( __( 'Circle', 'ark' ) ), 'circle');
		$themeBuilderManager->addMenuItem( ark_wp_kses( __( 'Contact Form', 'ark' ) ), 'contact-form');
		$themeBuilderManager->addMenuItem( ark_wp_kses( __( 'Counter', 'ark' ) ), 'counter');
		// DO NOT USE THIS! $themeBuilderManager->addMenuItem( ark_wp_kses( __( 'Common', 'ark' ) ), 'common');
		$themeBuilderManager->addMenuItem( ark_wp_kses( __( 'Divider', 'ark' ) ), 'divider');
		$themeBuilderManager->addMenuItem( ark_wp_kses( __( 'Heading', 'ark' ) ), 'heading');
		$themeBuilderManager->addMenuItem( ark_wp_kses( __( 'Icon Box', 'ark' ) ), 'icon-box');
		$themeBuilderManager->addMenuItem( ark_wp_kses( __( 'Interactive Banner', 'ark' ) ), 'interactive-banner');
		$themeBuilderManager->addMenuItem( ark_wp_kses( __( 'Logo Grid', 'ark' ) ), 'logo-grid');
		$themeBuilderManager->addMenuItem( ark_wp_kses( __( 'Map', 'ark' ) ), 'map');
		// $themeBuilderManager->addMenuItem( ark_wp_kses( __( 'Newsletter', 'ark' ) ), 'newsletter');
		$themeBuilderManager->addMenuItem( ark_wp_kses( __( 'Portfolio', 'ark' ) ), 'portfolio');
		$themeBuilderManager->addMenuItem( ark_wp_kses( __( 'Pricing Table', 'ark' ) ), 'pricing-table');
		$themeBuilderManager->addMenuItem( ark_wp_kses( __( 'Process', 'ark' ) ), 'process');
		$themeBuilderManager->addMenuItem( ark_wp_kses( __( 'Progress Bar', 'ark' ) ), 'progress-bar');
		$themeBuilderManager->addMenuItem( ark_wp_kses( __( 'Promo', 'ark' ) ), 'promo');
		$themeBuilderManager->addMenuItem( ark_wp_kses( __( 'Quote', 'ark' ) ), 'quote');
		$themeBuilderManager->addMenuItem( ark_wp_kses( __( 'Rating', 'ark' ) ), 'rating');
		$themeBuilderManager->addMenuItem( ark_wp_kses( __( 'Revolution Slider', 'ark' ) ), 'revslider');
		$themeBuilderManager->addMenuItem( ark_wp_kses( __( 'Schedule', 'ark' ) ), 'schedule');
		$themeBuilderManager->addMenuItem( ark_wp_kses( __( 'Services', 'ark' ) ), 'services');
		$themeBuilderManager->addMenuItem( ark_wp_kses( __( 'Slider', 'ark' ) ), 'slider');
		$themeBuilderManager->addMenuItem( ark_wp_kses( __( 'Tabs', 'ark' ) ), 'tab');
		$themeBuilderManager->addMenuItem( ark_wp_kses( __( 'Team', 'ark' ) ), 'team');
		$themeBuilderManager->addMenuItem( ark_wp_kses( __( 'Testimonial', 'ark' ) ), 'testimonials');
		$themeBuilderManager->addMenuItem( ark_wp_kses( __( 'Titlebar', 'ark' ) ), 'titlebar');
		$themeBuilderManager->addMenuItem( ark_wp_kses( __( 'WooCommerce', 'ark' ) ), 'woocommerce');
		$themeBuilderManager->addMenuItem( ark_wp_kses( __( 'Work', 'ark' ) ), 'work');
	}

	private function _registerPluginFile( $className, $relativePath ) {
		$path = $this->_getPluginDir() . $relativePath;
		$this->_getClassLoader()->addClass( $className, $path );
	}

	private function _registerThemeBuilderElements() {
		$this->_registerThemeBuilderMenus();

		$cl = $this->_getClassLoader();

		$this->_registerPluginFile('ffThemeBlConst', '/builder/const/class.ffThemeBlConst.php');
		$this->_registerPluginFile('ffThemeElConst', '/builder/const/class.ffThemeElConst.php');
		$this->getFrameworkContainer()->getClassLoader()->loadClass( 'externFreshizer' );


		$cl->loadClass('ffThemeBlConst');
		$cl->loadClass('ffThemeElConst');

		/*----------------------------------------------------------*/
		/* BLOCKS
		/*----------------------------------------------------------*/

		$this->_registerPluginFile('ffBlAnimation', '/builder/blocks/class.ffBlAnimation.php');
		$this->_registerPluginFile('ffBlBlogContent', '/builder/blocks/class.ffBlBlogContent.php');
		$this->_registerPluginFile('ffBlButton', '/builder/blocks/class.ffBlButton.php');
		$this->_registerPluginFile('ffBlComments', '/builder/blocks/class.ffBlComments.php');
		$this->_registerPluginFile('ffBlFeaturedImage', '/builder/blocks/class.ffBlFeaturedImage.php');
		$this->_registerPluginFile('ffBlImage', '/builder/blocks/class.ffBlImage.php');
		$this->_registerPluginFile('ffBlIcons', '/builder/blocks/class.ffBlIcons.php');
		$this->_registerPluginFile('ffBlList', '/builder/blocks/class.ffBlList.php');
		$this->_registerPluginFile('ffBlPageTitle', '/builder/blocks/class.ffBlPageTitle.php');
		$this->_registerPluginFile('ffBlPagination', '/builder/blocks/class.ffBlPagination.php');
		$this->_registerPluginFile('ffBlProgressBar', '/builder/blocks/class.ffBlProgressBar.php');

		foreach( $this->getElementsCollection() as $key=>$el ){
			$this->_registerPluginFile( $key, $el);
		}

	}

	/**
	 * @var ffCollection
	 */
	protected $_elementsCollection = null;

	/**
	 * @return ffCollection
	 */
	public function getElementsCollection(){
		if( null != $this->_elementsCollection ){
			return $this->_elementsCollection;
		}

		$this->_registerPluginFile( 'ffElBlog', '/builder/elements/Blog/class.ffElBlog.php' );
		$this->_registerPluginFile( 'ffElPortfolio', '/builder/elements/Portfolio/class.ffElPortfolio.php' );
		$this->_getClassLoader()->loadClass('ffThemeBuilderElement');
		$this->_getClassLoader()->loadClass('ffThemeBuilderElementBasic');
		$this->_getClassLoader()->loadClass('ffElPortfolio');
		$this->_getClassLoader()->loadClass('ffElBlog');

		$this->_elementsCollection = ffContainer()->createNewCollection();

		$elementsCollection = $this->_elementsCollection;

		$elementsCollection->addItem( '/builder/elements/BasicElements/SectionHeading/class.ffElSectionHeading.php', 'ffElSectionHeading' );
		$elementsCollection->addItem( '/builder/elements/BasicElements/Buttons/class.ffElButtons.php', 'ffElButtons' );
		$elementsCollection->addItem( '/builder/elements/BasicElements/EmbeddedCode/class.ffElEmbeddedCode.php', 'ffElEmbeddedCode' );
		$elementsCollection->addItem( '/builder/elements/BasicElements/EmptySpace/class.ffElEmptySpace.php', 'ffElEmptySpace' );
		$elementsCollection->addItem( '/builder/elements/BasicElements/Heading/class.ffElHeading.php', 'ffElHeading' );
		$elementsCollection->addItem( '/builder/elements/BasicElements/HTML/class.ffElHTML.php', 'ffElHTML' );
		$elementsCollection->addItem( '/builder/elements/BasicElements/Icons/class.ffElIcons.php', 'ffElIcons' );
		$elementsCollection->addItem( '/builder/elements/BasicElements/Image/class.ffElImage.php', 'ffElImage' );
		$elementsCollection->addItem( '/builder/elements/BasicElements/BeforeAfterSlider/class.ffElBeforeAfterSlider.php', 'ffElBeforeAfterSlider' );
		$elementsCollection->addItem( '/builder/elements/BasicElements/ImageSlider/class.ffElImageSlider.php', 'ffElImageSlider' );
		$elementsCollection->addItem( '/builder/elements/BasicElements/JavaScript/class.ffElJavaScript.php', 'ffElJavaScript' );
		$elementsCollection->addItem( '/builder/elements/BasicElements/List/class.ffElList.php', 'ffElList' );
		$elementsCollection->addItem( '/builder/elements/BasicElements/Paragraph/class.ffElParagraph.php', 'ffElParagraph' );
		$elementsCollection->addItem( '/builder/elements/BasicElements/Sidebar/class.ffElSidebar.php', 'ffElSidebar' );
		$elementsCollection->addItem( '/builder/elements/BasicElements/Slider/class.ffElSlider.php', 'ffElSlider' );
		$elementsCollection->addItem( '/builder/elements/BasicElements/CustomSlider2/class.ffElCustomSlider2.php', 'ffElCustomSlider2' );
		$elementsCollection->addItem( '/builder/elements/BasicElements/Slide/class.ffElSlide.php', 'ffElSlide' );
		$elementsCollection->addItem( '/builder/elements/BasicElements/Video/class.ffElVideo.php', 'ffElVideo' );
		$elementsCollection->addItem( '/builder/elements/BasicElements/ScrollTo/class.ffElScrollTo.php', 'ffElScrollTo' );

		$elementsCollection->addItem( '/builder/elements/Loop/LoopWrapper/class.ffElLoopWrapper.php', 'ffElLoopWrapper' );
		$elementsCollection->addItem( '/builder/elements/Loop/PostWrapper/class.ffElPostWrapper.php', 'ffElPostWrapper' );
		$elementsCollection->addItem( '/builder/elements/Loop/LoopRow/class.ffElLoopRow.php', 'ffElLoopRow' );
		$elementsCollection->addItem( '/builder/elements/Loop/LoopPost/class.ffElLoopPost.php', 'ffElLoopPost' );
		$elementsCollection->addItem( '/builder/elements/Loop/FeaturedArea/class.ffElFeaturedArea.php', 'ffElFeaturedArea' );
		$elementsCollection->addItem( '/builder/elements/Loop/FeaturedImage/class.ffElFeaturedImage.php', 'ffElFeaturedImage' );
		$elementsCollection->addItem( '/builder/elements/Loop/PostTitle/class.ffElPostTitle.php', 'ffElPostTitle' );
		$elementsCollection->addItem( '/builder/elements/Loop/PostMeta/class.ffElPostMeta.php', 'ffElPostMeta' );
		$elementsCollection->addItem( '/builder/elements/Loop/PostContent/class.ffElPostContent.php', 'ffElPostContent' );
		$elementsCollection->addItem( '/builder/elements/Loop/PostTags/class.ffElPostTags.php', 'ffElPostTags' );
		$elementsCollection->addItem( '/builder/elements/Loop/Comments/class.ffElComments.php', 'ffElComments' );

		$elementsCollection->addItem( '/builder/elements/ContactForm/ContactFormWrapper/class.ffElContactFormWrapper.php', 'ffElContactFormWrapper' );
		$elementsCollection->addItem( '/builder/elements/ContactForm/ContactFormInput/class.ffElContactFormInput.php', 'ffElContactFormInput' );
		$elementsCollection->addItem( '/builder/elements/ContactForm/ContactFormCaptcha/class.ffElContactFormCaptcha.php', 'ffElContactFormCaptcha' );
		$elementsCollection->addItem( '/builder/elements/ContactForm/ContactFormButton/class.ffElContactFormButton.php', 'ffElContactFormButton' );
		$elementsCollection->addItem( '/builder/elements/ContactForm/ContactFormMessages/class.ffElContactFormMessages.php', 'ffElContactFormMessages' );

		$elementsCollection->addItem( '/builder/elements/Accordion/Accordion1/class.ffElAccordion1.php', 'ffElAccordion1' );
		$elementsCollection->addItem( '/builder/elements/Accordion/Accordion2/class.ffElAccordion2.php', 'ffElAccordion2' );
		$elementsCollection->addItem( '/builder/elements/Accordion/Accordion3/class.ffElAccordion3.php', 'ffElAccordion3' );
		$elementsCollection->addItem( '/builder/elements/Accordion/Accordion4/class.ffElAccordion4.php', 'ffElAccordion4' );
		$elementsCollection->addItem( '/builder/elements/Accordion/Accordion5/class.ffElAccordion5.php', 'ffElAccordion5' );
		$elementsCollection->addItem( '/builder/elements/Accordion/Accordion6/class.ffElAccordion6.php', 'ffElAccordion6' );

		$elementsCollection->addItem( '/builder/elements/Alerts/Alert1/class.ffElAlert1.php', 'ffElAlert1' );
		$elementsCollection->addItem( '/builder/elements/Alerts/Alert2/class.ffElAlert2.php', 'ffElAlert2' );
		$elementsCollection->addItem( '/builder/elements/Alerts/Alert3/class.ffElAlert3.php', 'ffElAlert3' );
		$elementsCollection->addItem( '/builder/elements/Alerts/Alert4/class.ffElAlert4.php', 'ffElAlert4' );
		$elementsCollection->addItem( '/builder/elements/Alerts/Alert5/class.ffElAlert5.php', 'ffElAlert5' );
		$elementsCollection->addItem( '/builder/elements/Alerts/Alert6/class.ffElAlert6.php', 'ffElAlert6' );
		$elementsCollection->addItem( '/builder/elements/Alerts/Alert7/class.ffElAlert7.php', 'ffElAlert7' );
		$elementsCollection->addItem( '/builder/elements/Alerts/Alert8/class.ffElAlert8.php', 'ffElAlert8' );
		$elementsCollection->addItem( '/builder/elements/Alerts/Alert9/class.ffElAlert9.php', 'ffElAlert9' );
		$elementsCollection->addItem( '/builder/elements/Alerts/Alert10/class.ffElAlert10.php', 'ffElAlert10' );
		$elementsCollection->addItem( '/builder/elements/Alerts/Alert11/class.ffElAlert11.php', 'ffElAlert11' );
		$elementsCollection->addItem( '/builder/elements/Alerts/Alert12/class.ffElAlert12.php', 'ffElAlert12' );


		$elementsCollection->addItem( '/builder/elements/Blog/BlogDefault1/class.ffElBlogDefault1.php', 'ffElBlogDefault1' );
		$elementsCollection->addItem( '/builder/elements/Blog/BlogDefault2/class.ffElBlogDefault2.php', 'ffElBlogDefault2' );
		$elementsCollection->addItem( '/builder/elements/Blog/BlogDefault3/class.ffElBlogDefault3.php', 'ffElBlogDefault3' );
		$elementsCollection->addItem( '/builder/elements/Blog/BlogClassic1/class.ffElBlogClassic1.php', 'ffElBlogClassic1' );
		$elementsCollection->addItem( '/builder/elements/Blog/BlogClassic2/class.ffElBlogClassic2.php', 'ffElBlogClassic2' );
		$elementsCollection->addItem( '/builder/elements/Blog/BlogClassic3/class.ffElBlogClassic3.php', 'ffElBlogClassic3' );
// @TODO for v2		$elementsCollection->addItem( '/builder/elements/Blog/BlogClassic4/class.ffElBlogClassic4.php', 'ffElBlogClassic4' );
		$elementsCollection->addItem( '/builder/elements/Blog/BlogClassic5/class.ffElBlogClassic5.php', 'ffElBlogClassic5' );
		$elementsCollection->addItem( '/builder/elements/Blog/BlogClassic6/class.ffElBlogClassic6.php', 'ffElBlogClassic6' );
		$elementsCollection->addItem( '/builder/elements/Blog/BlogLatest/class.ffElBlogLatest.php', 'ffElBlogLatest' );
		$elementsCollection->addItem( '/builder/elements/Blog/BlogMasonry1/class.ffElBlogMasonry1.php', 'ffElBlogMasonry1' );
		$elementsCollection->addItem( '/builder/elements/Blog/BlogMasonry2/class.ffElBlogMasonry2.php', 'ffElBlogMasonry2' );
		$elementsCollection->addItem( '/builder/elements/Blog/BlogSimple1/class.ffElBlogSimple1.php', 'ffElBlogSimple1' );
		$elementsCollection->addItem( '/builder/elements/Blog/BlogSimple2/class.ffElBlogSimple2.php', 'ffElBlogSimple2' );
		$elementsCollection->addItem( '/builder/elements/Blog/BlogSimple3/class.ffElBlogSimple3.php', 'ffElBlogSimple3' );
		$elementsCollection->addItem( '/builder/elements/Blog/BlogSimple4/class.ffElBlogSimple4.php', 'ffElBlogSimple4' );
		$elementsCollection->addItem( '/builder/elements/Blog/BlogSimpleSlider/class.ffElBlogSimpleSlider.php', 'ffElBlogSimpleSlider' );
		$elementsCollection->addItem( '/builder/elements/Blog/BlogSlider1/class.ffElBlogSlider1.php', 'ffElBlogSlider1' );
		$elementsCollection->addItem( '/builder/elements/Blog/BlogSlider2/class.ffElBlogSlider2.php', 'ffElBlogSlider2' );
		$elementsCollection->addItem( '/builder/elements/Blog/BlogTeaser/class.ffElBlogTeaser.php', 'ffElBlogTeaser' );
		$elementsCollection->addItem( '/builder/elements/Blog/BlogTimeline1/class.ffElBlogTimeline1.php', 'ffElBlogTimeline1' );
		$elementsCollection->addItem( '/builder/elements/Blog/BlogTimeline2/class.ffElBlogTimeline2.php', 'ffElBlogTimeline2' );

		$elementsCollection->addItem( '/builder/elements/CallToAction/CallToAction1/class.ffElCallToAction1.php', 'ffElCallToAction1' );
		$elementsCollection->addItem( '/builder/elements/CallToAction/CallToAction2/class.ffElCallToAction2.php', 'ffElCallToAction2' );
		$elementsCollection->addItem( '/builder/elements/CallToAction/CallToAction3/class.ffElCallToAction3.php', 'ffElCallToAction3' );
		$elementsCollection->addItem( '/builder/elements/CallToAction/CallToAction4/class.ffElCallToAction4.php', 'ffElCallToAction4' );

		$elementsCollection->addItem( '/builder/elements/ContactForm/ContactForm1/class.ffElContactForm1.php', 'ffElContactForm1' );

		$elementsCollection->addItem( '/builder/elements/Counters/Countdown/class.ffElCountdown.php', 'ffElCountdown' );
		$elementsCollection->addItem( '/builder/elements/Counters/Counters1/class.ffElCounters1.php', 'ffElCounters1' );
		$elementsCollection->addItem( '/builder/elements/Counters/Counters2/class.ffElCounters2.php', 'ffElCounters2' );
		$elementsCollection->addItem( '/builder/elements/Counters/Counters3/class.ffElCounters3.php', 'ffElCounters3' );
		$elementsCollection->addItem( '/builder/elements/Counters/Counters4/class.ffElCounters4.php', 'ffElCounters4' );
		$elementsCollection->addItem( '/builder/elements/Counters/Counters5/class.ffElCounters5.php', 'ffElCounters5' );
		$elementsCollection->addItem( '/builder/elements/Counters/Counters6/class.ffElCounters6.php', 'ffElCounters6' );
		$elementsCollection->addItem( '/builder/elements/Circles/Circles1/class.ffElCircles1.php', 'ffElCircles1' );
		$elementsCollection->addItem( '/builder/elements/Circles/Circles2/class.ffElCircles2.php', 'ffElCircles2' );

		$elementsCollection->addItem( '/builder/elements/Dividers/CustomDivider/class.ffElCustomDivider.php', 'ffElCustomDivider' );
		$elementsCollection->addItem( '/builder/elements/Dividers/SimpleDivider1/class.ffElSimpleDivider1.php', 'ffElSimpleDivider1' );
		$elementsCollection->addItem( '/builder/elements/Dividers/SimpleDividerWithIcon/class.ffElSimpleDividerWithIcon.php', 'ffElSimpleDividerWithIcon' );
		$elementsCollection->addItem( '/builder/elements/Dividers/SimpleDividerWithTitle/class.ffElSimpleDividerWithTitle.php', 'ffElSimpleDividerWithTitle' );
		$elementsCollection->addItem( '/builder/elements/Dividers/ColoredDividerWithTitle/class.ffElColoredDividerWithTitle.php', 'ffElColoredDividerWithTitle' );
		$elementsCollection->addItem( '/builder/elements/Dividers/ColoredDividerWithIcon/class.ffElColoredDividerWithIcon.php', 'ffElColoredDividerWithIcon' );

		$elementsCollection->addItem( '/builder/elements/BasicElements/AnimatedHeading/class.ffElAnimatedHeading.php', 'ffElAnimatedHeading' );
		$elementsCollection->addItem( '/builder/elements/BasicElements/AnimatedHeading2/class.ffElAnimatedHeading2.php', 'ffElAnimatedHeading2' );
		$elementsCollection->addItem( '/builder/elements/Headings/Heading1/class.ffElHeading1.php', 'ffElHeading1' );
		$elementsCollection->addItem( '/builder/elements/Headings/Heading2/class.ffElHeading2.php', 'ffElHeading2' );
		$elementsCollection->addItem( '/builder/elements/Headings/Heading3/class.ffElHeading3.php', 'ffElHeading3' );
		$elementsCollection->addItem( '/builder/elements/Headings/Heading4/class.ffElHeading4.php', 'ffElHeading4' );

		$elementsCollection->addItem( '/builder/elements/IconBox/IconBox1/class.ffElIconBox1.php', 'ffElIconBox1' );
		$elementsCollection->addItem( '/builder/elements/IconBox/IconBox2/class.ffElIconBox2.php', 'ffElIconBox2' );
		$elementsCollection->addItem( '/builder/elements/IconBox/IconBox3/class.ffElIconBox3.php', 'ffElIconBox3' );
		$elementsCollection->addItem( '/builder/elements/IconBox/IconBox4/class.ffElIconBox4.php', 'ffElIconBox4' );
		$elementsCollection->addItem( '/builder/elements/IconBox/IconBox5/class.ffElIconBox5.php', 'ffElIconBox5' );
		$elementsCollection->addItem( '/builder/elements/IconBox/IconBox6/class.ffElIconBox6.php', 'ffElIconBox6' );
		$elementsCollection->addItem( '/builder/elements/IconBox/IconBox7/class.ffElIconBox7.php', 'ffElIconBox7' );
		$elementsCollection->addItem( '/builder/elements/IconBox/IconBox8/class.ffElIconBox8.php', 'ffElIconBox8' );
		$elementsCollection->addItem( '/builder/elements/IconBox/IconBox9/class.ffElIconBox9.php', 'ffElIconBox9' );
		$elementsCollection->addItem( '/builder/elements/IconBox/IconBox10/class.ffElIconBox10.php', 'ffElIconBox10' );
		$elementsCollection->addItem( '/builder/elements/IconBox/IconBox11/class.ffElIconBox11.php', 'ffElIconBox11' );
		$elementsCollection->addItem( '/builder/elements/IconBox/IconBox12/class.ffElIconBox12.php', 'ffElIconBox12' );
		$elementsCollection->addItem( '/builder/elements/Faq/class.ffElFaq.php', 'ffElFaq' );

		$elementsCollection->addItem( '/builder/elements/InteractiveBanners/InteractiveBanner1/class.ffElInteractiveBanner1.php', 'ffElInteractiveBanner1' );
		$elementsCollection->addItem( '/builder/elements/InteractiveBanners/InteractiveBanner2/class.ffElInteractiveBanner2.php', 'ffElInteractiveBanner2' );
		$elementsCollection->addItem( '/builder/elements/InteractiveBanners/InteractiveBanner3/class.ffElInteractiveBanner3.php', 'ffElInteractiveBanner3' );

		$elementsCollection->addItem( '/builder/elements/LogoGrid/class.ffElLogoGrid.php', 'ffElLogoGrid' );

		$elementsCollection->addItem( '/builder/elements/Map/class.ffElMap.php', 'ffElMap' );

//		$elementsCollection->addItem( '/builder/elements/Newsletter/Newsletter1/class.ffElNewsletter1.php', 'ffElNewsletter1' );
//		$elementsCollection->addItem( '/builder/elements/Newsletter/Newsletter2/class.ffElNewsletter2.php', 'ffElNewsletter2' );
//		$elementsCollection->addItem( '/builder/elements/Newsletter/Newsletter3/class.ffElNewsletter3.php', 'ffElNewsletter3' );
//		$elementsCollection->addItem( '/builder/elements/Newsletter/Newsletter4/class.ffElNewsletter4.php', 'ffElNewsletter4' );
//		$elementsCollection->addItem( '/builder/elements/Newsletter/Newsletter5/class.ffElNewsletter5.php', 'ffElNewsletter5' );
//		$elementsCollection->addItem( '/builder/elements/Newsletter/Newsletter6/class.ffElNewsletter6.php', 'ffElNewsletter6' );
//		$elementsCollection->addItem( '/builder/elements/Newsletter/Newsletter7/class.ffElNewsletter7.php', 'ffElNewsletter7' );

		$elementsCollection->addItem( '/builder/elements/Gallery/class.ffElGallery.php', 'ffElGallery' );
		$elementsCollection->addItem( '/builder/elements/Gallery/class.ffElAcfGallery.php', 'ffElAcfGallery' );
		$elementsCollection->addItem( '/builder/elements/Portfolio/PortfolioClassic/class.ffElPortfolioClassic.php', 'ffElPortfolioClassic' );
		$elementsCollection->addItem( '/builder/elements/Portfolio/PortfolioSidebar/class.ffElPortfolioSidebar.php', 'ffElPortfolioSidebar' );

		$elementsCollection->addItem( '/builder/elements/PricingLists/PricingLists1/class.ffElPricingLists1.php', 'ffElPricingLists1' );
		$elementsCollection->addItem( '/builder/elements/PricingLists/PricingLists2/class.ffElPricingLists2.php', 'ffElPricingLists2' );
		$elementsCollection->addItem( '/builder/elements/PricingLists/PricingLists3/class.ffElPricingLists3.php', 'ffElPricingLists3' );
		$elementsCollection->addItem( '/builder/elements/PricingLists/PricingLists4/class.ffElPricingLists4.php', 'ffElPricingLists4' );
		$elementsCollection->addItem( '/builder/elements/PricingLists/PricingLists5/class.ffElPricingLists5.php', 'ffElPricingLists5' );
		$elementsCollection->addItem( '/builder/elements/PricingLists/PricingLists6/class.ffElPricingLists6.php', 'ffElPricingLists6' );
		$elementsCollection->addItem( '/builder/elements/PricingLists/PricingLists7/class.ffElPricingLists7.php', 'ffElPricingLists7' );

		$elementsCollection->addItem( '/builder/elements/Process/Process1/class.ffElProcess.php', 'ffElProcess' );
		$elementsCollection->addItem( '/builder/elements/Process/Process2/class.ffElProcess2.php', 'ffElProcess2' );
		$elementsCollection->addItem( '/builder/elements/Process/Process3/class.ffElProcess3.php', 'ffElProcess3' );

		$elementsCollection->addItem( '/builder/elements/ProgressBar/ProgressBar1/class.ffElProgressBar1.php', 'ffElProgressBar1' );
		$elementsCollection->addItem( '/builder/elements/ProgressBar/ProgressBar2/class.ffElProgressBar2.php', 'ffElProgressBar2' );
		$elementsCollection->addItem( '/builder/elements/ProgressBar/ProgressBar3/class.ffElProgressBar3.php', 'ffElProgressBar3' );

		$elementsCollection->addItem( '/builder/elements/Promo/Promo1/class.ffElPromo1.php', 'ffElPromo1' );
		$elementsCollection->addItem( '/builder/elements/Promo/Promo2/class.ffElPromo2.php', 'ffElPromo2' );
		$elementsCollection->addItem( '/builder/elements/Promo/Promo3/class.ffElPromo3.php', 'ffElPromo3' );
		$elementsCollection->addItem( '/builder/elements/Promo/Promo4/class.ffElPromo4.php', 'ffElPromo4' );
		$elementsCollection->addItem( '/builder/elements/Promo/Promo6/class.ffElPromo6.php', 'ffElPromo6' );
		$elementsCollection->addItem( '/builder/elements/Promo/Promo8/class.ffElPromo8.php', 'ffElPromo8' );
		$elementsCollection->addItem( '/builder/elements/Promo/Promo9/class.ffElPromo9.php', 'ffElPromo9' );
		$elementsCollection->addItem( '/builder/elements/Promo/Promo11/class.ffElPromo11.php', 'ffElPromo11' );

		$elementsCollection->addItem( '/builder/elements/Quotes/SimpleQuote1/class.ffElSimpleQuote1.php', 'ffElSimpleQuote1' );
		$elementsCollection->addItem( '/builder/elements/Quotes/SimpleQuote2/class.ffElSimpleQuote2.php', 'ffElSimpleQuote2' );
		$elementsCollection->addItem( '/builder/elements/Quotes/SimpleQuote3/class.ffElSimpleQuote3.php', 'ffElSimpleQuote3' );
		$elementsCollection->addItem( '/builder/elements/Quotes/SimpleQuote4/class.ffElSimpleQuote4.php', 'ffElSimpleQuote4' );
		$elementsCollection->addItem( '/builder/elements/Quotes/QuoteWithSocials/class.ffElQuoteWithSocials.php', 'ffElQuoteWithSocials' );
		$elementsCollection->addItem( '/builder/elements/Quotes/OneQuote/class.ffElOneQuote.php', 'ffElOneQuote' );

		$elementsCollection->addItem( '/builder/elements/RatingStars/class.ffElRatingStars.php', 'ffElRatingStars' );

		$elementsCollection->addItem( '/builder/elements/RevSlider/class.ffElRevSlider.php', 'ffElRevSlider' );

		$elementsCollection->addItem( '/builder/elements/Lectures/Lectures1/class.ffElLectures1.php', 'ffElLectures1' );
		$elementsCollection->addItem( '/builder/elements/Lectures/Lectures2/class.ffElLectures2.php', 'ffElLectures2' );

		$elementsCollection->addItem( '/builder/elements/OfficeHours/class.ffElOfficeHours.php', 'ffElOfficeHours' );
		$elementsCollection->addItem( '/builder/elements/OpeningHours/class.ffElOpeningHours.php', 'ffElOpeningHours' );
		$elementsCollection->addItem( '/builder/elements/Specification/class.ffElSpecification.php', 'ffElSpecification' );

		$elementsCollection->addItem( '/builder/elements/Services/Services1/class.ffElServices1.php', 'ffElServices1' );
		$elementsCollection->addItem( '/builder/elements/Services/Services3/class.ffElServices3.php', 'ffElServices3' );
		$elementsCollection->addItem( '/builder/elements/Services/Services4/class.ffElServices4.php', 'ffElServices4' );
		$elementsCollection->addItem( '/builder/elements/Services/Services5/class.ffElServices5.php', 'ffElServices5' );
		$elementsCollection->addItem( '/builder/elements/Services/Services6/class.ffElServices6.php', 'ffElServices6' );
		$elementsCollection->addItem( '/builder/elements/Services/Services7/class.ffElServices7.php', 'ffElServices7' );
		$elementsCollection->addItem( '/builder/elements/Services/Services8/class.ffElServices8.php', 'ffElServices8' );
		$elementsCollection->addItem( '/builder/elements/Services/Services9/class.ffElServices9.php', 'ffElServices9' );
		$elementsCollection->addItem( '/builder/elements/Services/Services10/class.ffElServices10.php', 'ffElServices10' );
		$elementsCollection->addItem( '/builder/elements/Services/Services11/class.ffElServices11.php', 'ffElServices11' );
		$elementsCollection->addItem( '/builder/elements/Services/Services12/class.ffElServices12.php', 'ffElServices12' );
		$elementsCollection->addItem( '/builder/elements/Services/Services13/class.ffElServices13.php', 'ffElServices13' );
		$elementsCollection->addItem( '/builder/elements/Services/Services14/class.ffElServices14.php', 'ffElServices14' );
		$elementsCollection->addItem( '/builder/elements/Services/Services15/class.ffElServices15.php', 'ffElServices15' );
		$elementsCollection->addItem( '/builder/elements/Download/class.ffElDownload.php', 'ffElDownload' );

		$elementsCollection->addItem( '/builder/elements/Sliders/Slider1/class.ffElSlider1.php', 'ffElSlider1' );
		$elementsCollection->addItem( '/builder/elements/Sliders/Slider2/class.ffElSlider2.php', 'ffElSlider2' );
		$elementsCollection->addItem( '/builder/elements/Sliders/Slider3/class.ffElSlider3.php', 'ffElSlider3' );

		$elementsCollection->addItem( '/builder/elements/Tab/Tab1/class.ffElTab1.php', 'ffElTab1' );
		$elementsCollection->addItem( '/builder/elements/Tab/Tab2/class.ffElTab2.php', 'ffElTab2' );
		$elementsCollection->addItem( '/builder/elements/Tab/Tab3/class.ffElTab3.php', 'ffElTab3' );
		$elementsCollection->addItem( '/builder/elements/Tab/Tab4/class.ffElTab4.php', 'ffElTab4' );
		$elementsCollection->addItem( '/builder/elements/Tab/Tab5/class.ffElTab5.php', 'ffElTab5' );
		$elementsCollection->addItem( '/builder/elements/Tab/Tab6/class.ffElTab6.php', 'ffElTab6' );
		$elementsCollection->addItem( '/builder/elements/Tab/Tab7/class.ffElTab7.php', 'ffElTab7' );
		$elementsCollection->addItem( '/builder/elements/Tab/Tab8/class.ffElTab8.php', 'ffElTab8' );

		$elementsCollection->addItem( '/builder/elements/Team/Team1/class.ffElTeam1.php', 'ffElTeam1' );
		$elementsCollection->addItem( '/builder/elements/Team/Team2/class.ffElTeam2.php', 'ffElTeam2' );
		$elementsCollection->addItem( '/builder/elements/Team/Team3/class.ffElTeam3.php', 'ffElTeam3' );
		$elementsCollection->addItem( '/builder/elements/Team/Team4/class.ffElTeam4.php', 'ffElTeam4' );
		$elementsCollection->addItem( '/builder/elements/Team/Team5/class.ffElTeam5.php', 'ffElTeam5' );
		$elementsCollection->addItem( '/builder/elements/Team/Team6/class.ffElTeam6.php', 'ffElTeam6' );
		$elementsCollection->addItem( '/builder/elements/Team/Team7/class.ffElTeam7.php', 'ffElTeam7' );
		$elementsCollection->addItem( '/builder/elements/Team/Team8/class.ffElTeam8.php', 'ffElTeam8' );
		$elementsCollection->addItem( '/builder/elements/Team/Team9/class.ffElTeam9.php', 'ffElTeam9' );
		$elementsCollection->addItem( '/builder/elements/Team/Team10/class.ffElTeam10.php', 'ffElTeam10' );
		$elementsCollection->addItem( '/builder/elements/Team/Team11/class.ffElTeam11.php', 'ffElTeam11' );
		$elementsCollection->addItem( '/builder/elements/Team/Team12/class.ffElTeam12.php', 'ffElTeam12' );
		$elementsCollection->addItem( '/builder/elements/Team/Team13/class.ffElTeam13.php', 'ffElTeam13' );

		$elementsCollection->addItem( '/builder/elements/Testimonials/Testimonials1/class.ffElTestimonials1.php', 'ffElTestimonials1' );
		$elementsCollection->addItem( '/builder/elements/Testimonials/Testimonials2/class.ffElTestimonials2.php', 'ffElTestimonials2' );
		$elementsCollection->addItem( '/builder/elements/Testimonials/Testimonials3/class.ffElTestimonials3.php', 'ffElTestimonials3' );
		$elementsCollection->addItem( '/builder/elements/Testimonials/Testimonials4/class.ffElTestimonials4.php', 'ffElTestimonials4' );
		$elementsCollection->addItem( '/builder/elements/Testimonials/Testimonials5/class.ffElTestimonials5.php', 'ffElTestimonials5' );
		$elementsCollection->addItem( '/builder/elements/Testimonials/Testimonials6/class.ffElTestimonials6.php', 'ffElTestimonials6' );
		$elementsCollection->addItem( '/builder/elements/Testimonials/Testimonials7/class.ffElTestimonials7.php', 'ffElTestimonials7' );
		$elementsCollection->addItem( '/builder/elements/Testimonials/Testimonials8/class.ffElTestimonials8.php', 'ffElTestimonials8' );
		$elementsCollection->addItem( '/builder/elements/Testimonials/Testimonials9/class.ffElTestimonials9.php', 'ffElTestimonials9' );
		$elementsCollection->addItem( '/builder/elements/Testimonials/Testimonials10/class.ffElTestimonials10.php', 'ffElTestimonials10' );
		$elementsCollection->addItem( '/builder/elements/Testimonials/Testimonials11/class.ffElTestimonials11.php', 'ffElTestimonials11' );

		$elementsCollection->addItem( '/builder/elements/Breadcrumbs/Breadcrumbs1/class.ffElBreadcrumbs1.php', 'ffElBreadcrumbs1' );
		$elementsCollection->addItem( '/builder/elements/Breadcrumbs/Breadcrumbs2/class.ffElBreadcrumbs2.php', 'ffElBreadcrumbs2' );
		$elementsCollection->addItem( '/builder/elements/Breadcrumbs/Breadcrumbs3/class.ffElBreadcrumbs3.php', 'ffElBreadcrumbs3' );
		$elementsCollection->addItem( '/builder/elements/Breadcrumbs/Breadcrumbs4/class.ffElBreadcrumbs4.php', 'ffElBreadcrumbs4' );
		$elementsCollection->addItem( '/builder/elements/Breadcrumbs/Breadcrumbs5/class.ffElBreadcrumbs5.php', 'ffElBreadcrumbs5' );
		$elementsCollection->addItem( '/builder/elements/Breadcrumbs/BreadcrumbsTitle/class.ffElBreadcrumbsTitle.php', 'ffElBreadcrumbsTitle' );
		$elementsCollection->addItem( '/builder/elements/Breadcrumbs/BreadcrumbsNoTitle/class.ffElBreadcrumbsNoTitle.php', 'ffElBreadcrumbsNoTitle' );

		$elementsCollection->addItem( '/builder/elements/WooCommerce/Products/class.ffElProducts.php', 'ffElProducts' );
		$elementsCollection->addItem( '/builder/elements/ACF/class.ffElACF.php', 'ffElACF' );

		$elementsCollection->addItem( '/builder/elements/Work/class.ffElWork.php', 'ffElWork' );

		$elementsCollection->addItem( '/builder/elements/Header/class.ffElHeader.php', 'ffElHeader' );
		$elementsCollection->addItem( '/builder/elements/System/class.ffElGlobalStyle.php', 'ffElGlobalStyle' );
		$elementsCollection->addItem( '/builder/elements/BoxedWrapper/class.ffElBoxedWrapper.php', 'ffElBoxedWrapper' );

		return $this->_elementsCollection;

	}

}

