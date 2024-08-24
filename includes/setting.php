<?php
/**
 * Registers settings, sections, and fields for Social Share.
 */
function sss_register_settings() {
    register_setting('social_share_settings_group', 'social_share_settings');

    add_settings_section(
        'social_share_settings_section',
        'Display Options',
        'sss_settings_section_callback',
        'simple-social-share'
    );

    add_settings_field(
        'social_share_facebook',
        'Display Facebook',
        'sss_facebook_render',
        'simple-social-share',
        'social_share_settings_section'
    );

    add_settings_field(
        'social_share_twitter',
        'Display Twitter',
        'sss_twitter_render',
        'simple-social-share',
        'social_share_settings_section'
    );

    add_settings_field(
        'social_share_pinterest',
        'Display Pinterest',
        'sss_pinterest_render',
        'simple-social-share',
        'social_share_settings_section'
    );

    add_settings_field(
        'social_share_post_types',
        'Select Post Types',
        'sss_post_types_render',
        'simple-social-share',
        'social_share_settings_section'
    );
}
add_action('admin_init', 'sss_register_settings');

/**
 * Callback for the settings section description.
 */
function sss_settings_section_callback() {
    echo '<p>' . esc_html__('Select which social media buttons you want to display on your posts.', 'simple-social-share') . '</p>';
}

/**
 * Renders the Facebook option.
 */
function sss_facebook_render() {
    $options = get_option('social_share_settings');
    ?>
    <input type="checkbox" name="social_share_settings[social_share_facebook]" <?php checked(isset($options['social_share_facebook']), true); ?> value="1">
    <label for="social_share_settings[social_share_facebook]"><?php esc_html_e('Enable Facebook sharing button.', 'simple-social-share'); ?></label>
    <?php
}

/**
 * Renders the Twitter option.
 */
function sss_twitter_render() {
    $options = get_option('social_share_settings');
    ?>
    <input type="checkbox" name="social_share_settings[social_share_twitter]" <?php checked(isset($options['social_share_twitter']), true); ?> value="1">
    <label for="social_share_settings[social_share_twitter]"><?php esc_html_e('Enable Twitter sharing button.', 'simple-social-share'); ?></label>
    <?php
}

/**
 * Renders the Pinterest option.
 */
function sss_pinterest_render() {
    $options = get_option('social_share_settings');
    ?>
    <input type="checkbox" name="social_share_settings[social_share_pinterest]" <?php checked(isset($options['social_share_pinterest']), true); ?> value="1">
    <label for="social_share_settings[social_share_pinterest]"><?php esc_html_e('Enable Pinterest sharing button.', 'simple-social-share'); ?></label>
    <?php
}

/**
 * Renders the post types selection.
 */
function sss_post_types_render() {
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
?>
