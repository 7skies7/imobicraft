<?php
  
class ffPostTypeRegistratorMessages extends ffBasicObject {

	protected $singular_name;
	protected $name;
	protected $type;

	function __construct( $name, $singular_name, $type ){
		$this->name = $name;
		if( empty( $singular_name ) ){
			if( 's' == substr($name, -1) ){
				$this->singular_name = substr($name, 0, -1);
			}else{
				$this->singular_name = $name;
			}
		}else{
			$this->singular_name = $singular_name;
		}

		$this->type = $type;

	}

	function getMessages(){
		
		$singular_name = $this->singular_name;
		$name = $this->name;

		$low_name = strtolower($singular_name);
		$low_name_s = strtolower($name);

		$messages = $this->getMessagesTemplate( $this->type );
		
		foreach ($messages as $key=>$value) {
			$value = str_replace( "---NAME---s",     $name,          $value);
			$value = str_replace( "---NAME---",      $singular_name, $value);
			$value = str_replace( "---LOW-NAME---s", $low_name_s,    $value);
			$value = str_replace( "---LOW-NAME---",  $low_name,      $value);
			$messages[$key] = $value;
		}

		return $messages;
	}

	protected function getMessagesTemplate( $type ){

		global $post, $post_ID;
		
		switch( $type ){

			case 'hidden':

				return array(
						0 => '', // Unused. Messages start at index 1.
						1 => sprintf( '---NAME--- updated.', esc_url( get_permalink($post_ID) ) ),
						2 => 'Custom field updated.',
						3 => 'Custom field deleted.',
						4 => '---NAME--- updated.',
						/* translators: %s: date and time of the revision */
						5 => isset($_GET['revision']) ? sprintf( '---NAME--- restored to revision from %s', wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
						6 => sprintf( '---NAME--- published.', esc_url( get_permalink($post_ID) ) ),
						7 => '---NAME--- saved.',
						8 => sprintf( '---NAME--- submitted.', esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
						9 => sprintf( '---NAME--- scheduled for: <strong>%1$s</strong>. ????',
							// translators: Publish box date format, see http://php.net/date
							date_i18n( __( 'M j, Y @ G:i', 'default' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
						10 => sprintf( '---NAME--- draft updated.', esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
				);

			default: // = normal

				return array(
						0 => '', // Unused. Messages start at index 1.
						1 => sprintf( '---NAME--- updated. <a href="%s">View ---LOW-NAME---</a>', esc_url( get_permalink($post_ID) ) ),
						2 => 'Custom field updated.',
						3 => 'Custom field deleted.',
						4 => '---NAME--- updated.',
						/* translators: %s: date and time of the revision */
						5 => isset($_GET['revision']) ? sprintf( '---NAME--- restored to revision from %s', wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
						6 => sprintf( '---NAME--- published. <a href="%s">View ---LOW-NAME---</a>', esc_url( get_permalink($post_ID) ) ),
						7 => '---NAME--- saved.',
						8 => sprintf( '---NAME--- submitted. <a target="_blank" href="%s">Preview ---LOW-NAME---</a>', esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
						9 => sprintf( '---NAME--- scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview ---LOW-NAME---</a>',
							// translators: Publish box date format, see http://php.net/date
							date_i18n( __( 'M j, Y @ G:i', 'default' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
						10 => sprintf( '---NAME--- draft updated. <a target="_blank" href="%s">Preview ---LOW-NAME---</a>', esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
				);

		}
	}
	
}




