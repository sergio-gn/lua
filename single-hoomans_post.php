<?php
/* Template Name: Single Hoomans Post */
get_header('hoomans');
get_template_part( 'template-parts/menu', '1' );
?>

<div class="container py-5">
    <div class="row">
        <div class="col">
            <?php while (have_posts()): the_post(); ?>
                <h1><?php the_title(); ?></h1>
                <div class="content">
                    <?php the_content(); ?>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
