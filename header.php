<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
   <meta charset="<?php bloginfo( 'charset' ); ?>">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title><?php bloginfo( 'name' ); ?> <?php wp_title( '|', true, 'left' ); ?></title>
   <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_uri(); ?>">

    <?php wp_enqueue_script('meu-script-votacao', get_template_directory_uri() . '/js/script.js', array('jquery'), null, true);?>

   <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
   <header id="site-header">
        <div class="site-branding">
            <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
            <p class="site-description"><?php bloginfo( 'description' ); ?></p>
        </div>

        <div class="header-buttons">
            <?php
            if ( is_user_logged_in() ) {
                // Se o usuário estiver logado, mostre um link para fazer logout
                echo '<a href="' . wp_logout_url( home_url() ) . '">Logout</a>';
            } else {
                // Se o usuário não estiver logado, mostre links para login e cadastro
                echo '<a href="' . wp_login_url() . '">Login</a>';
                echo '<a href="' . wp_registration_url() . '">Cadastro</a>';
            }
            ?>
        </div>
      <nav id="site-navigation" class="main-navigation">
         <!-- Adicione seu menu aqui -->
      </nav>
   </header>
   <div id="content" class="site-content">
