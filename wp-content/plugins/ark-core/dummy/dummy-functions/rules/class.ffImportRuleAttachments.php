<?php

class ffImportRuleAttachments extends ffImportRuleBasic {
	/**
	 * @param $WPImporter ffWPImporter
	 */
	public function beforeImportPostsBatch() {


		$newPosts = array();

		foreach( $this->_getWPImporter()->posts as $onePost ) {
			if( $onePost['post_type'] == 'attachment' ) {
				$oldUrl = $onePost['attachment_url'];

				$urlRewriter = ffContainer()->getUrlRewriter();

				if( strpos( $oldUrl, '/ark-demos/') !== false ) {
					$urlRewriter->setUrl('http://themes.freshface.net/ark-demos/?ff_http_action_trigger=1&ff_http_action_name=get-demo-image');
				} else {
					$urlRewriter->setUrl('http://themes.freshface.net/ark/?ff_http_action_trigger=1&ff_http_action_name=get-demo-image');
				}

				$urlRewriter->addQueryParameter('imageUrl', $onePost['attachment_url']);
				$newUrl = $urlRewriter->getNewUrl();
				$onePost['attachment_url'] = $newUrl;
			}

			$newPosts[] = $onePost;
		}
		$this->_getWPImporter()->posts = $newPosts;
		//http://themes.freshface.net/ark-demos/?ff_http_action_trigger=1&ff_http_action_name=get-demo-image&imageUrl=http%3A%2F%2Fthemes.freshface.net%2Fark-demos%2Fgym%2Fwp-content%2Fuploads%2Fsites%2F2%2F2016%2F11%2Fhome1.jpg

		$newPosts = [];

		$regex = '/%22taxonomies%22%3A%22([0-9a-zA-Z\*\%\-\ ]*)%22/';

		foreach( $this->_getWPImporter()->posts as $onePost ) {
			$onePost['post_content'] = preg_replace_callback($regex, array($this, '_replaceEncodedStringNew'), $onePost['post_content'] );

			$newPosts[] = $onePost;
		}

		$this->_getWPImporter()->posts = $newPosts;

		// %7C%7Ctax-s%7C%7C([0-9a-zA-Z%]*)%7C%7Ctax-e%7C%7C%
		// \|\|tax-s\|\|([0-9\*\|]*)\|\|tax-e\|\|

//		$regString = '/\|\|tax-s\|\|([0-9]*)\|\|tax-e\|\|/';
//		$encodedString = '/%7C%7Ctax-s%7C%7C([0-9]*)%7C%7Ctax-e%7C%7C/';

//		$regString = '/\|\|tax-s\|\|([0-9\*\|]*)\|\|tax-e\|\|/';
//		$encodedString = '/%7C%7Ctax-s%7C%7C([0-9a-zA-Z%*]*)%7C%7Ctax-e%7C%7C/';
//
//		foreach( $this->_getWPImporter()->posts as $onePost ) {
//			$onePost['post_content'] = preg_replace_callback($regString, array($this, '_replaceRegString'), $onePost['post_content'] );
//			$onePost['post_content'] = preg_replace_callback($encodedString, array($this, '_replaceEncodedString'), $onePost['post_content'] );
//
//			$newPosts[] = $onePost;
//		}
//		$this->_getWPImporter()->posts = $newPosts;
		//$reg = '/%7C%7Ctax-s%7C%7C([0-9]*)%7C%7Ctax-e%7C%7C/';
//		$reg = '\|\|tax-s\|\|([0-9]*)\|\|tax-e\|\|';

	}

}