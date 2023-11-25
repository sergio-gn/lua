<?php
/**
 * This is file for all of your custom functions for the project
 */

/**
 * Enables the Link Manager that existed in WordPress until version 3.5.
 */
// add_filter('pre_option_link_manager_enabled', '__return_true');


function custom_breadcrumb() {
    echo '<div class="breadcrumb">';
    echo '<a href="' . home_url() . '">Home</a> / ';

    // Check if it's a single post (e.g., a single post or custom post type)
    if (is_singular('post')) {
        $categories = get_the_category();
        if ($categories) {
            $category = $categories[0]; // Assuming we only use one category per post
            echo '<a href="' . get_category_link($category->term_id) . '">' . $category->name . '</a> / ';
        }
    }

    // Add more conditions for other types of pages if needed (e.g., pages, archives, custom post types, etc.)

    echo '</div>';
}
