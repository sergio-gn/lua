<?php
if ( have_posts() ) {
   while ( have_posts() ) {
       the_post();
       // Display search results with link to single page
       echo '<h2><a href="' . esc_url( get_permalink() ) . '">' . get_the_title() . '</a></h2>';
       the_excerpt();
   }
} else {
   // No search results found
   echo 'No results found.';
}
?>
