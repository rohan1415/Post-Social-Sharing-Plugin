<?php
/**
 * Adds social share buttons to the content.
 *
 * @param string $content The content of the post.
 * @return string Modified content with social share buttons.
 */
function sss_add_share_buttons($content) {
    if (is_single()) {
        $options = get_option('social_share_settings');
        $post_type = get_post_type();

        if (isset($options['social_share_post_types'][$post_type]) && $options['social_share_post_types'][$post_type]) {
            $share_buttons = '<div class="social-share-buttons">';

            if (isset($options['social_share_facebook']) && $options['social_share_facebook']) {
                $share_buttons .= '<a href="https://www.facebook.com/sharer/sharer.php?u=' . esc_url(get_permalink()) . '" target="_blank"><i class="fab fa-facebook-f"></i></a> ';
            }

            if (isset($options['social_share_twitter']) && $options['social_share_twitter']) {
                $share_buttons .= '<a href="https://twitter.com/intent/tweet?url=' . esc_url(get_permalink()) . '&text=' . esc_html(get_the_title()) . '" target="_blank"><i class="fab fa-twitter"></i></a> ';
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
add_filter('the_content', 'sss_add_share_buttons');
?>
