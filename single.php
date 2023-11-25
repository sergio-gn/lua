<?php get_header('single'); ?>
<?php get_template_part( 'template-parts/menu', '1' );?>

<main class="main mt-xl-3" role="main">
    <div class="container-blog">
        <?php custom_breadcrumb(); ?>
        <div class="d-flex gap-5 flex-d-columb-mb">
            <div class="mainpost">
                <?php while ( have_posts() ) : the_post(); ?>
                    <article <?php post_class(); ?>>
                        <?php if (has_post_thumbnail()): ?>
                            <div class="featured-image-wrapper">
                                <?php the_post_thumbnail('full', ['class' => 'featured-image']); ?>
                            </div>
                        <?php endif; ?>
                        <header class="post__header" role="heading">
                            <h1 class="post__title"><?php the_title(); ?></h1>
                        </header>
                        <hr>
                        <div class="post__content">
                            <?php the_content(); ?>
                        </div>
            
                        <footer class="post__footer">
                            <p class="post__date"><time><?php echo human_time_diff(strtotime($post->post_date)) . ' ' . __('ago'); ?></time></p>
                            <div class="comments-area">
                                <?php
                                    if (comments_open() || get_comments_number()) {
                                        comments_template();
                                    }
                                ?>
                            </div>
                            <p class="post__comments">
                                <?php comments_popup_link(__('No comments yet'), __('1 comment'), __('% comments')); ?>
                            </p>
                        </footer>
                    </article>
                <?php endwhile; ?>
                <div class="share pt-4">
                    <div class="d-flex align-items-center gap-1">
                        <div class="ff-1_bold">
                            Share:
                        </div>
                        <div>
                            <div class="whatsapp-share-button">
                                <button class="button-share" onclick="shareOnWhatsApp()">
                                    <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M32.0827 16.4587C23.6 16.4587 16.704 23.3547 16.7013 31.8347C16.6987 35.296 17.7147 37.888 19.4187 40.6L17.8667 46.2747L23.6853 44.7467C26.2933 46.2933 28.7813 47.2213 32.072 47.224C40.5467 47.224 47.4507 40.3253 47.4533 31.848C47.456 23.3493 40.5867 16.4613 32.0827 16.4587ZM41.128 38.4427C40.744 39.5227 38.896 40.5067 38.008 40.64C37.2107 40.76 36.2027 40.808 35.096 40.456C34.424 40.2427 33.5627 39.9573 32.4613 39.4827C27.824 37.48 24.7973 32.8107 24.5653 32.504C24.3333 32.1947 22.6773 29.9973 22.6773 27.7227C22.6773 25.448 23.872 24.328 24.296 23.8667C24.72 23.4053 25.2187 23.288 25.528 23.288L26.4133 23.304C26.696 23.3173 27.0773 23.1973 27.4533 24.0987C27.8373 25.024 28.7627 27.2987 28.8773 27.5307C28.992 27.7627 29.0693 28.032 28.9147 28.3413C28.76 28.6507 28.6827 28.8427 28.4533 29.112L27.76 29.9227C27.528 30.152 27.288 30.4027 27.5573 30.8667C27.8267 31.3307 28.7547 32.8427 30.128 34.0693C31.8933 35.6453 33.384 36.1333 33.8453 36.3627C34.3067 36.592 34.576 36.5547 34.848 36.248C35.1173 35.9387 36.0027 34.8987 36.312 34.4347C36.6213 33.9733 36.928 34.048 37.352 34.2027C37.776 34.3573 40.048 35.4747 40.5093 35.7067C40.9707 35.9387 41.28 36.0533 41.3947 36.2453C41.5147 36.4373 41.5147 37.3627 41.128 38.4427ZM32 0C14.328 0 0 14.328 0 32C0 49.672 14.328 64 32 64C49.672 64 64 49.672 64 32C64 14.328 49.672 0 32 0ZM32.0773 50.3467C28.9813 50.3467 25.9307 49.568 23.2293 48.096L13.424 50.6667L16.048 41.08C14.4293 38.2747 13.576 35.0907 13.5787 31.832C13.5813 21.632 21.88 13.3333 32.0773 13.3333C37.0267 13.336 41.672 15.2613 45.1627 18.7573C48.656 22.2533 50.5787 26.9013 50.576 31.8453C50.5733 42.0453 42.2747 50.3467 32.0773 50.3467Z" fill="#29A71A"/>
                                    </svg>
                                </button>
                                <script>
                                    function shareOnWhatsApp() {
                                        var url = window.location.href;
                                        var whatsappUrl = "https://api.whatsapp.com/send?text=" + encodeURIComponent(document.title + " - " + url);
                                        window.open(whatsappUrl, '_blank');
                                    }
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sidebar">
                <div class="py-2">
                    <p class="sidebar-title">Tags</p>
                    <?php
                    $tags = get_the_tags();
                    if ( $tags ) {
                      echo '<div class="post-tags">';
                      foreach ( $tags as $tag ) {
                        echo '<a href="' . get_tag_link( $tag->term_id ) . '" class="tag-' . $tag->slug . '">' . $tag->name . '</a> ';
                      }
                      echo '</div>';
                    }?>
                </div>
                <div>
                    <p class="sidebar-title">Recent Posts</p>
                    <?php
                            // set up the arguments for the query to select the main post
                            $args = array(
                                'post_type' => 'post',
                                'post_status' => 'publish',
                                'posts_per_page' => 5, // Set the number of recent posts to display
                                'orderby' => 'date',
                                'order' => 'DESC'
                            );
                        
                            // create a new WP_Query instance with the arguments
                            $query = new WP_Query( $args );
                        
                            // start the loop
                            if ( $query->have_posts() ) : 
                                while ( $query->have_posts() ) : $query->the_post(); 
                        ?>
                                <div style="border-top: 1px solid #414141;">
                                    <article <?php post_class(); ?>>
                                        <div style="padding: 1rem 0;" class="d-flex align-items-center">
                                            <?php if(has_post_thumbnail()): ?>
                                                <div class="img-wrapper_sixpack_sidebar">
                                                    <div style="border-radius:.5rem" class="img-wrapper_thumbnail">
                                                        <?php the_post_thumbnail( array(80, 80) ); ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                            <header class="post__header px-1" role="heading">
                                                <p class="recent-posts-title">
                                                    <a href="<?php the_permalink(); ?>">
                                                        <?php the_title(); ?>
                                                    </a>
                                                </p>
                                            </header>
                                        </div>
                                    </article>
                                </div>
                        <?php
                                endwhile;
                            endif;
                            // reset the query
                            wp_reset_postdata();
                        ?>
                </div>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>