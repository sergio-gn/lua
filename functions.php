<?php

function custom_excerpt() {
  $content = get_the_content();
  $content_lines = substr_count($content, "\n");

  if ($content_lines >= 4) {
    return get_the_excerpt();
  } else {
    return get_the_content();
  }
 }

 function custom_read_more_link() {
    return '<a href="' . esc_url(get_permalink()) . '" title="' . the_title_attribute(['echo' => false]) . '" class="read-more-link">' . esc_html__('Ler mais', 'text_domain') . '</a>';
 }

// Limita o número de posts por página para 10
function custom_posts_per_page( $query ) {
  if ( is_admin() || ! $query->is_main_query() ) {
    return;
  }

  if ( is_home() || is_archive() || is_search() ) {
    $query->set( 'posts_per_page', 10 );
  }
}
add_action( 'pre_get_posts', 'custom_posts_per_page' );


function handle_vote() {
  $post_id = $_POST['post_id'];
  $vote_type = $_POST['vote_type'];

  $vote_count = intval(get_post_meta($post_id, 'vote_count', true));
  $vote_count = ($vote_count) ? $vote_count : 0;

  if (!is_user_logged_in()) {
    wp_send_json_error(array('message' => 'Usuário não autenticado.'));
  }

  if ($vote_type === 'upvote') {
    $vote_count++;
  } elseif ($vote_type === 'downvote') {
    $vote_count--;
  } elseif ($vote_type === 'reset') {
    $vote_count = 0;
  }

  update_post_meta($post_id, 'vote_count', $vote_count);

  wp_send_json_success(array('vote_count' => $vote_count));
}

add_action('wp_ajax_handle_vote', 'handle_vote');
add_action('wp_ajax_nopriv_handle_vote', 'handle_vote');


function load_jquery() {
  wp_enqueue_script('jquery');
}

add_action('wp_enqueue_scripts', 'load_jquery');


function enqueue_custom_scripts() {
  // Carregar a biblioteca jQuery
  wp_enqueue_script('jquery');

  // Carregar o script personalizado
  wp_enqueue_script('custom-script', get_template_directory_uri() . '/js/script.js', array('jquery'), '1.0', true);

  // Passar a variável ajaxurl e informações do usuário para o script
  wp_localize_script('custom-script', 'ajaxurl', admin_url('admin-ajax.php'));
  wp_localize_script('custom-script', 'userLoggedIn', is_user_logged_in());
}

add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');
