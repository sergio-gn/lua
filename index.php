<?php get_header(); ?>
<?php get_template_part( 'template-parts/menu', '1' );?>

<div class="row">


    <?php
    if (have_posts()) :
        while (have_posts()) : the_post();
         // Início da estrutura da postagem
    ?>
        <div class="post-container">
            <!-- Coluna Adicional (Informações Relacionadas) -->
            <div class="related-info-column">
              <div class="voting-buttons">
                  <a href="#" class="vote-button vote-up" data-post-id="<?php echo get_the_ID(); ?>">▲</a>
                  <a href="#" class="vote-button vote-down" data-post-id="<?php echo get_the_ID(); ?>">▼</a>
              </div>
              <div class="voting-info" data-post-id="<?php echo get_the_ID(); ?>">
                  <span class="vote-count"><?php echo intval(get_post_meta(get_the_ID(), 'vote_count', true)); ?></span> Votos
              </div>
              <div class="vote-message" data-post-id="<?php echo get_the_ID(); ?>"></div>
            </div>




            <!-- Coluna do Post -->
            <article class="post-box" id="post-<?php the_ID(); ?>" <?php post_class('post-box'); ?>>
               <!-- Título da postagem (clicável) -->
               <header class="entry-header">
                    <a class="entry-title" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                        <?php the_title('<h2 class="entry-title">', '</h2>'); ?>
                    </a>
               </header>

               <!-- Trecho (Excerpt) ou conteúdo completo -->
               <div class="entry-content">
                    <?php echo custom_excerpt(); ?>
               </div>

               <!-- "Ler mais" link -->
                <footer class="entry-footer">
                    <?php echo custom_read_more_link(); ?>
                </footer>
            </article>

        </div>
    <?php
         // Fim da estrutura da postagem
        endwhile;
    else:
      // Se não houver postagens
    ?>
        <p><?php esc_html_e('Desculpe, não encontramos nenhum conteúdo.', 'text_domain'); ?></p>
    <?php
    endif;
    ?>

</div>





<?php get_footer(); ?>
