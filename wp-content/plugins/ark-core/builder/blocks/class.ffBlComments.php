<?php

class ffBlComments extends ffThemeBuilderBlockBasic {
/**********************************************************************************************************************/
/* OBJECTS
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* PRIVATE VARIABLES
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* CONSTRUCT
/**********************************************************************************************************************/
	protected function _init() {
		$this->_setInfo( ffThemeBuilderBlock::INFO_ID, 'comments');
		$this->_setInfo( ffThemeBuilderBlock::INFO_WRAPPING_ID, 'cmnts');
		$this->_setInfo( ffThemeBuilderBlock::INFO_WRAP_AUTOMATICALLY, true);
		$this->_setInfo( ffThemeBuilderBlock::INFO_IS_REFERENCE_SECTION, true);
		$this->_setInfo( ffThemeBuilderBlock::INFO_SAVE_ONLY_DIFFERENCE, true);
		$this->_setInfo( ffThemeBuilderBlock::INFO_APPLY_CALLBACKS, true);
	}
/**********************************************************************************************************************/
/* PUBLIC FUNCTIONS
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* PUBLIC PROPERTIES
/**********************************************************************************************************************/

/**********************************************************************************************************************/
/* PRIVATE FUNCTIONS
/**********************************************************************************************************************/


	/**
	 * @param $query ffOptionsQueryDynamic
	 */
	protected function _renderContactForm( $query ){

//		comment_form();return;

		$args = array();

		$args['class_form'] = 'comment-form';
		$args['comment_notes_before'] = '';
		$args['comment_notes_after'] = '';


		/* COMMENT FORM TITLE */

		$this->_advancedToggleBoxStart($query, 'heading');
		echo '<span>'.$query->getWithoutComparationDefault( 'heading text', ark_wp_kses( __('Leave a comment', 'ark')) ).'</span>';
		$args['title_reply'] = $this->_advancedToggleBoxEnd($query, 'heading', false);


		/* COMMENT CANCEL REPLY */

		$this->_advancedToggleBoxStart($query, 'cancel');
		echo '<span>' . $query->getWithoutComparationDefault( 'cancel text', ark_wp_kses( __('Cancel reply', 'ark')) ) . '</span>';
		$args['cancel_reply_link'] = $this->_advancedToggleBoxEnd($query, 'cancel', false);


		/* LOGGED IN AS */

		$user = wp_get_current_user();
		$user_identity = $user->exists() ? $user->display_name : '';

		$this->_advancedToggleBoxStart($query, 'logged-in');
		echo '<p class="logged-in-as">' . sprintf(
				$query->getWithoutComparationDefault( 'logged-in text', ark_wp_kses( __('Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>','ark')) )
				, admin_url( 'profile.php' )
				, $user_identity
				, wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) )
			) . '</p>';
		$args['logged_in_as'] = $this->_advancedToggleBoxEnd($query, 'logged-in', false);


		/* for fields NAME, EMAIL, URL */

		$args['fields'] = array();

		$require_name_email_required_string = '';
		if( get_option('require_name_email') ){
			$require_name_email_required_string = ' required';
		}

		/* NAME */

		$this->_advancedToggleBoxStart($query, 'name');
		echo '<div class="col-xs-12 col-md-4 margin-b-30">'
			. '<input class="form-control blog-single-post-form radius-3" id="author" name="author" type="text" placeholder="'
			. esc_attr( $query->getWithoutComparationDefault( 'name placeholder', __('Full Name *', 'ark')) )
			. '" '.$require_name_email_required_string.'>'
			. '</div>'
		;
		$args['fields']['author'] = $this->_advancedToggleBoxEnd($query, 'name', false);


		/* EMAIL */

		$this->_advancedToggleBoxStart($query, 'email');
		echo
			'<div class="col-xs-12 col-md-4 margin-b-30">'
			. '<input class="form-control blog-single-post-form radius-3" id="email" name="email" type="email" placeholder="'
			. esc_attr( $query->getWithoutComparationDefault( 'email placeholder', __('E-mail *', 'ark')) )
			. '"'.$require_name_email_required_string.'>'
			. '</div>'
		;
		$args['fields']['email'] = $this->_advancedToggleBoxEnd($query, 'email', false);


		/* URL */

		$this->_advancedToggleBoxStart($query, 'url');
		echo
			'<div class="col-xs-12 col-md-4 margin-b-30">'
			. '<input class="form-control blog-single-post-form radius-3" id="url" type="text" name="url" placeholder="'
			. esc_attr( $query->getWithoutComparationDefault( 'url placeholder', __('Website', 'ark')) )
			. '">'
			.'</div>'
		;
		$args['fields']['url'] = $this->_advancedToggleBoxEnd($query, 'url', false);


		/* MESSAGE */

		$this->_advancedToggleBoxStart($query, 'message');
		echo '<div class="message col-xs-12 margin-b-30">'
			. '<textarea id="comment" name="comment" class="form-control blog-single-post-form radius-3" rows="6" placeholder="'
			. esc_attr( $query->getWithoutComparationDefault( 'message placeholder', __('Message *', 'ark')) )
			. '"></textarea>'
			. '</div>'
		;
		$args[ 'comment_field' ] = $this->_advancedToggleBoxEnd($query, 'message', false);


		/* BUTTON SUBMIT */

		$args['label_submit'] = $query->getWithoutComparationDefault( 'submit-button text', esc_attr( __('Submit', 'ark')) );

		$this->_advancedToggleBoxStart($query, 'submit-button');
		echo '<button name="%1$s" type="submit" id="%2$s" class="%3$s btn-dark-brd btn-base-sm footer-v5-btn radius-3">%4$s</button>';
		$args['submit_button'] = $this->_advancedToggleBoxEnd($query, 'submit-button', false);

		ob_start();
		echo '<div class="ark-comment-form" id="respond-wrapper">';
		comment_form( $args );
		echo '</div>';
		$comment_form = ob_get_clean();


		$comment_form = str_replace('id="respond"', '', $comment_form);
		$comment_form = str_replace('id=\'respond\'', '', $comment_form);
		$comment_form = str_replace('id="respond-wrapper"', 'id="respond"', $comment_form);


		$comment_form = str_replace('logged-in-as', 'logged-in-as col-xs-12', $comment_form);
		$comment_form = str_replace('<p class="form-submit">', '<p class="form-submit col-xs-12">', $comment_form);
		$comment_form = str_replace('</form>', '<div class="clearfix"><br /></div></form>', $comment_form);

		echo ( $comment_form );
		echo '<br/>';
	}

	/**
	 * @param $query ffOptionsQueryDynamic
	 * @return mixed
	 */
	protected function _render( $query ){
		$comments_content = $query->getWithoutComparation('comments-content');

		if( empty($comments_content) ){
			return;
		}

		if ( ! is_single() and ! is_page() )
			return;

		if( post_password_required() ) {
			return;
		}

		if( ! comments_open() and ( 0 == get_comments_number()) ) {
			return;
		}

		if( Ark_Comments::OVERWRITTEN == Ark_Comments::$comment_template_state ){
			return;
		}

		/* It does nothing, it just initialize comments */
		comments_template();

		/* Case when some plugin rewrites comments */
		if( Ark_Comments::PRINTED != Ark_Comments::$comment_template_state ){
			Ark_Comments::$comment_template_state = Ark_Comments::OVERWRITTEN;
			return;
		}

		echo '<div id="comments" class="comments-area">';

		foreach( $comments_content as $key => $oneItem ) {
			switch( $oneItem->getVariationType() ) {
				case 'comment-form':
					$this->_renderContactForm($oneItem);
					break;

				case 'comment-list':

					Ark_Comments::setTranslation('date-format',
						$oneItem->getWithoutComparationDefault( 'date-format', esc_attr( __('%s ago', 'ark'))) );
					Ark_Comments::setTranslation('reply',
						$oneItem->getWithoutComparationDefault( 'reply', esc_attr( __('Reply', 'ark'))) );
					Ark_Comments::setTranslation('moderation',
						$oneItem->getWithoutComparationDefault( 'moderation', ark_wp_kses( __('Your comment is awaiting moderation.', 'ark'))) );

					echo '<div class="ark-comment-list">';
					Ark_Comments::ark_wp_list_comments();
					echo '</div>';
					break;

				case 'comment-pagination':

					Ark_Comments::setTranslation( 'prev-text',
						$oneItem->getWithoutComparationDefault( 'prev-text', '') );
					Ark_Comments::setTranslation( 'prev-icon',
						$oneItem->getWithoutComparationDefault( 'prev-icon', 'ff-font-awesome4 icon-angle-double-left') );
					Ark_Comments::setTranslation('next-text',
						$oneItem->getWithoutComparationDefault( 'next-text', '') );
					Ark_Comments::setTranslation( 'next-icon',
						$oneItem->getWithoutComparationDefault( 'next-icon', 'ff-font-awesome4 icon-angle-double-right') );

					echo '<div class="ark-comment-pagination">';
					Ark_Comments::ark_paginate_comments_links();
					echo '</div>';
					break;
			}
		}

		echo '</div>';
	}

	protected function _injectOptions( ffThemeBuilderOptionsExtender $s ) {

		$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('Please note, that:', 'ark' ) ) );
		$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __(' - Whole Block is printed only on Single Page, Single Post, Single Attachment or similar pages.', 'ark' ) ) );
		$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __(' - Comment Form is printed only if comments are enabled.', 'ark' ) ) );
		$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __(' - Comment List is printed only if there exists some comments already.', 'ark' ) ) );
		$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __(' - Comment Pagination is printed only if there are at least 2 pages of comments.', 'ark' ) ) );

		$s->addElement(ffOneElement::TYPE_NEW_LINE);

		$s->startRepVariableSection('comments-content');

			/* Posts Comments */
			$s->startRepVariationSection('comment-form', ark_wp_kses( __('Comment Form', 'ark' ) ) );
				$s->startAdvancedToggleBox('heading', ark_wp_kses(__('Title - Leave a comment', 'ark')) );
					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Leave a comment');
				$s->endAdvancedToggleBox();

				$s->startAdvancedToggleBox('cancel', ark_wp_kses(__('Title - Cancel reply', 'ark')) );
					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Cancel reply');
				$s->endAdvancedToggleBox();

				$s->startAdvancedToggleBox( 'name', ark_wp_kses(__('Full Name' , 'ark')) );
					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'placeholder', '', 'Full Name')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Placeholder text', 'ark')) );
				$s->endAdvancedToggleBox();

				$s->startAdvancedToggleBox( 'email', ark_wp_kses(__('Email Address' , 'ark')) );
					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'placeholder', '', 'Email Address')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Placeholder text', 'ark')) );
				$s->endAdvancedToggleBox();

				$s->startAdvancedToggleBox( 'url', ark_wp_kses(__('Website' , 'ark')) );
					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'placeholder', '', 'Website')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Placeholder text', 'ark')) );
				$s->endAdvancedToggleBox();

				$s->startAdvancedToggleBox( 'message', ark_wp_kses(__('Your Message' , 'ark')) );
					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'placeholder', '', 'Your Message')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Placeholder text', 'ark')) );
				$s->endAdvancedToggleBox();

				$s->startAdvancedToggleBox( 'submit-button', ark_wp_kses(__('Submit' , 'ark')) );
					$s->addOptionNL( ffOneOption::TYPE_TEXT, 'text', '', 'Submit')
						->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Submit Button Label', 'ark')) );
				$s->endAdvancedToggleBox();

				$s->startAdvancedToggleBox( 'logged-in', ark_wp_kses(__('Logged in text', 'ark')) );
					$s->addOption( ffOneOption::TYPE_TEXTAREA, 'text', '', 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>');
					$s->addElement(ffOneElement::TYPE_DESCRIPTION,'',ark_wp_kses( __('In format <code>Logged in as &lt;a&gt; href="%1$s"&gt;%2$s&lt;/a&gt;. &lt;a&gt; href="%3$s" title="Log out of this account"&gt;Log out?&lt;/a&gt;</code>', 'ark' ) ) );
				$s->endAdvancedToggleBox();

			$s->endRepVariationSection();

			$s->startRepVariationSection('comment-list', ark_wp_kses( __('Comments List', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_TEXT, 'date-format', '', '%s ago')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('How much ago in format <code>%s ago</code>', 'ark')) );

				$s->addOptionNL( ffOneOption::TYPE_TEXT, 'trans-reply', '', 'Reply')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Reply comment', 'ark')) );

				$s->addOption( ffOneOption::TYPE_TEXT, 'trans-moderation', '', 'Your comment is awaiting moderation.')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Awaiting for moderation', 'ark')) );
			$s->endRepVariationSection();

			$s->startRepVariationSection('comment-pagination', ark_wp_kses( __('Comments Pagination', 'ark' ) ) );
				$s->addOptionNL( ffOneOption::TYPE_TEXT, 'prev-text', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Previous comments text', 'ark')) );
				$s->addOptionNL( ffOneOption::TYPE_ICON, 'prev-icon', ark_wp_kses(__('Previous Icon', 'ark')), 'ff-font-awesome4 icon-angle-double-left');
				$s->addOptionNL( ffOneOption::TYPE_TEXT, 'next-text', '', '')
					->addParam( ffOneOption::PARAM_TITLE_AFTER, ark_wp_kses(__('Next comments text', 'ark')) );
				$s->addOptionNL( ffOneOption::TYPE_ICON, 'next-icon', ark_wp_kses(__('Next Icon', 'ark')), 'ff-font-awesome4 icon-angle-double-right');
			$s->endRepVariationSection();

		$s->endRepVariableSection();

	}

	protected function _renderContentInfo_JS() {
		?>
		<script data-type="ffscript">
			function ( query, params ) {

				if( query == null || !query.exists('comments-content') ) {
				} else {
					query.get('comments-content').each(function (query, variationType) {
						switch (variationType) {
							case 'comment-form':
								query.addPlainText('Comment Form');
								query.addBreak();
								break;
							case 'comment-list':
								query.addPlainText('Comment List');
								query.addBreak();
								break;
							case 'comment-pagination':
								query.addPlainText('Comment Pagination');
								query.addBreak();
								break;
						}
					});
				}
			}
		</script data-type="ffscript">
	<?php
	}
/**********************************************************************************************************************/
/* PRIVATE GETTERS & SETTERS
/**********************************************************************************************************************/
}