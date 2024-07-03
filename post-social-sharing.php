<?php
/*
Plugin Name: Simple Social Share
Plugin URI: http://example.com/simple-social-share
Description: A simple plugin to add social share buttons to your posts.
Version: 1.0
Author: Your Name
Author URI: http://example.com
License: GPL2
*/

/**
 * Adds a menu item for the Social Share settings page.
 */
function social_share_admin_menu() {
    add_menu_page(
        'Social Share Settings',
        'Social Share',
        'manage_options',
        'social-share',
        'social_share_settings_page',
        'dashicons-share',
        100
    );
}
add_action('admin_menu', 'social_share_admin_menu');

function enqueue_font_awesome() {
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css');
}
add_action('wp_enqueue_scripts', 'enqueue_font_awesome');

/**
 * Renders the Social Share settings page.
 */
function social_share_settings_page() {
    ?>
    <div class="wrap">
        <h1>Simple Social Share Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('social_share_settings_group');
            do_settings_sections('simple-social-share');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

/**
 * Registers settings, sections, and fields for Social Share.
 */
function social_share_register_settings() {
    register_setting('social_share_settings_group', 'social_share_settings');

    add_settings_section(
        'social_share_settings_section',
        'Display Options',
        'social_share_settings_section_callback',
        'simple-social-share'
    );

    add_settings_field(
        'social_share_facebook',
        'Display Facebook',
        'social_share_facebook_render',
        'simple-social-share',
        'social_share_settings_section'
    );

    add_settings_field(
        'social_share_twitter',
        'Display Twitter',
        'social_share_twitter_render',
        'simple-social-share',
        'social_share_settings_section'
    );

    add_settings_field(
        'social_share_pinterest',
        'Display Pinterest',
        'social_share_pinterest_render',
        'simple-social-share',
        'social_share_settings_section'
    );

    add_settings_field(
        'social_share_post_types',
        'Select Post Types',
        'social_share_post_types_render',
        'simple-social-share',
        'social_share_settings_section'
    );
}
add_action('admin_init', 'social_share_register_settings');

/**
 * Callback for the settings section description.
 */
function social_share_settings_section_callback() {
    echo 'Select which social media buttons you want to display on your posts.';
}

/**
 * Renders the Facebook option.
 */
function social_share_facebook_render() {
    $options = get_option('social_share_settings');
    ?>
    <input type="checkbox" name="social_share_settings[social_share_facebook]" <?php checked(isset($options['social_share_facebook']), true); ?> value="1">
    <?php
}

/**
 * Renders the Twitter option.
 */
function social_share_twitter_render() {
    $options = get_option('social_share_settings');
    ?>
    <input type="checkbox" name="social_share_settings[social_share_twitter]" <?php checked(isset($options['social_share_twitter']), true); ?> value="1">
    <?php
}

/**
 * Renders the Pinterest option.
 */
function social_share_pinterest_render() {
    $options = get_option('social_share_settings');
    ?>
    <input type="checkbox" name="social_share_settings[social_share_pinterest]" <?php checked(isset($options['social_share_pinterest']), true); ?> value="1">
    <?php
}

/**
 * Renders the post types selection.
 */
function social_share_post_types_render() {
    $options = get_option('social_share_settings');
    $post_types = get_post_types(array('public' => true), 'objects');

    foreach ($post_types as $post_type) {
        if ($post_type->name === 'attachment') {
            continue;
        }
        ?>
        <label>
            <input type="checkbox" name="social_share_settings[social_share_post_types][<?php echo esc_attr($post_type->name); ?>]" <?php checked(isset($options['social_share_post_types'][$post_type->name]), true); ?> value="1">
            <?php echo esc_html($post_type->label); ?>
        </label><br>
        <?php
    }
}

/**
 * Adds social share buttons to the content.
 *
 * @param string $content The content of the post.
 * @return string Modified content with social share buttons.
 */
function social_share_add_share_buttons($content) {
    if (is_single()) {
        $options = get_option('social_share_settings');
        $post_type = get_post_type();

        if (isset($options['social_share_post_types'][$post_type]) && $options['social_share_post_types'][$post_type]) {
            $share_buttons = '<div class="social-share-buttons">';

            if (isset($options['social_share_facebook']) && $options['social_share_facebook']) {
                $share_buttons .= '<a href="https://www.facebook.com/sharer/sharer.php?u=' . esc_url(get_permalink()) . '" target="_blank"><i class="fab fa-facebook-f"></i></a> | ';
            }

            if (isset($options['social_share_twitter']) && $options['social_share_twitter']) {
                $share_buttons .= '<a href="https://twitter.com/intent/tweet?url=' . esc_url(get_permalink()) . '&text=' . esc_html(get_the_title()) . '" target="_blank"><i class="fab fa-twitter"></i></a> | ';
            }

            if (isset($options['social_share_pinterest']) && $options['social_share_pinterest']) {
                $share_buttons .= '<a href="https://pinterest.com/pin/create/button/?url=' . esc_url(get_permalink()) . '&description=' . esc_html(get_the_title()) . '" target="_blank"><i class="fab fa-pinterest"></i></a>';
            }

            $share_buttons .= '</div>';

            $content .= $share_buttons;
        } 
    }
    return $content;
}
add_filter('the_content', 'social_share_add_share_buttons');
?>
