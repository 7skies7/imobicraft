<?php
$selected_nav = absint( get_user_option( 'nav_menu_recently_edited' ) );
$selected_nav_theme = get_term_meta($selected_nav, 'wpmm_nav_options', true);
$selected_nav_theme = maybe_unserialize($selected_nav_theme);
$selected_theme_id = null;
if ( ! empty($selected_nav_theme)){
    $selected_theme_id = $selected_nav_theme['theme_id'];
}
?>
<div id="wpmm_themes" class="wpmm_themes_div">
    <div class="wpmm_themes_metabox_content">
        <div id="wpmm_themes_response"></div>
        <?php
        $post_args = array(
            'post_type'     => 'wpmm_theme',
            'post_status'   => 'publish',
            'order_by'      => 'desc'
        );
        $query = new WP_Query($post_args);

        if ($query->have_posts()) {
            echo '<ul>';
            echo "<li> <label class='menu-item-title' > <input type='radio' value='0' name='selected_theme' ".checked(0, $selected_theme_id, false)." /> ".__('Disable Theme', 'wp-megamenu')." </li> </label>";
            while ($query->have_posts()): $query->the_post();
            echo '<li> <label class="menu-item-title" > <input type="radio" value="'.get_the_ID().'" name="selected_theme" '.checked(get_the_ID(), $selected_theme_id, false).' /> '.get_the_title().' </li> </label>';
            endwhile;

            echo '</ul>';
            $query->reset_postdata();
        }
        ?>
    </div>
    <p class="button-controls wp-clearfix">
        <span class="add-to-menu">
            <input type="submit"  class="button-secondary submit-add-to-menu right" value="<?php esc_attr_e('Save', 'wp-megamenu'); ?>" name="save_wpmm_theme_nav" id="save_wpmm_theme_nav" />
			</span>
    </p>
</div><!-- /.wpmm_themes_div -->