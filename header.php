<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta name="robots" content="noindex">
  <!-- Прелоад header.min.css -->
  <link rel="preload" as="style" href="<?php echo get_stylesheet_directory_uri(); ?>/css/header.min.css" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/header.min.css">
    </noscript>
  <!-- Прелоад main.min.css -->
  <link rel="preload" as="style" href="<?php echo get_stylesheet_directory_uri(); ?>/css/main.min.css" onload="this.onload=null;this.rel='stylesheet'">
  <noscript>
      <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/main.min.css">
  </noscript>
  <?php if (is_home()) { ?>
    <link rel="preload" as="image" href="<?php echo get_field('offer_bg', 'options'); ?>" />
  <?php } else { ?>
    <?php if (get_field('offer_img')) :  ?>
      <link rel="preload" as="image" href="<?php the_field('offer_img'); ?>" />
    <?php endif; ?>
    <?php if (get_field('offer_bg')) :  ?>
      <link rel="preload" as="image" href="<?php the_field('offer_bg'); ?>" />
    <?php endif; ?>
    <?php if (get_the_post_thumbnail_url()) : ?>
      <link rel="preload" as="image" href="<?php the_post_thumbnail_url(); ?>" />
    <?php endif; ?>
  <?php } ?>
  <meta charset="UTF-8">
  <meta name="viewport" id="myViewport" content="width=device-width, maximum-scale=1.0, user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="format-detection" content="telephone=no">

  <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/img/favicon/favicon.ico" sizes="any"><!-- 32×32 -->
  <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/img/favicon/icon.png" type="image/svg+xml">
  <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/img/favicon/apple-touch-icon.png"><!-- 180×180 -->
  <link rel="manifest" href="<?php echo get_template_directory_uri(); ?>/manifest.webmanifest">
  
  <?php wp_head(); ?>
  
</head>

<body id="top">

<div class="mob-header <?php if (!is_home() && !is_page(346) && !is_page(599)) { echo 'white not-home'; }?>">
  <div class="container">
    <div class="wrap">
      <?php if (is_home()) : ?>
        <div  class="logo">
          <img class="light" src="<?php echo get_template_directory_uri(); ?>/img/logo-white.svg" alt="ООО «Источники питания»">
          <img style="display: none" class="dark" src="<?php echo get_template_directory_uri(); ?>/img/logo-dark.svg" alt="ООО «Источники питания»">
        </div>
        <?php else : ?>
        <a href="/" class="logo">
          <img class="dark" src="<?php echo get_template_directory_uri(); ?>/img/logo-dark.svg" alt="ООО «Источники питания»">
          <img style="display: none" class="light" src="<?php echo get_template_directory_uri(); ?>/img/logo-white.svg" alt="ООО «Источники питания»">
        </a>
      <?php endif; ?> 
      <div class="burger icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
          <path d="M4 5H20" stroke="white" stroke-opacity="0.5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M4 12H20" stroke="white" stroke-opacity="0.5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M4 19H20" stroke="white" stroke-opacity="0.5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>
    </div>
  </div>
</div> 

<header itemscope itemtype="http://schema.org/WPHeader" class="header <?php if (!is_home() && !is_page(346) && !is_page(599)) { echo 'header-white'; } else { echo 'header-home'; } ?>" style="display: none"> 
  <div class="container header-pc" style="display: block"> 
    <div class="wrap">
      <?php if (is_home()) : ?>
        <div  class="logo">
          <img class="light" src="<?php echo get_template_directory_uri(); ?>/img/logo-white.svg" alt="ООО «Источники питания»">
          <img style="display: none" class="dark" src="<?php echo get_template_directory_uri(); ?>/img/logo-dark.svg" alt="ООО «Источники питания»">
        </div>
        <?php else : ?>
        <a href="/" class="logo">
          <img class="dark" src="<?php echo get_template_directory_uri(); ?>/img/logo-dark.svg" alt="ООО «Источники питания»">
          <img style="display: none" class="light" src="<?php echo get_template_directory_uri(); ?>/img/logo-white.svg" alt="ООО «Источники питания»">
        </a>
      <?php endif; ?> 
      <div class="search">
        <div class="search-toggle">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path d="M17.5 17.5L22 22" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M20 11C20 6.02944 15.9706 2 11 2C6.02944 2 2 6.02944 2 11C2 15.9706 6.02944 20 11 20C15.9706 20 20 15.9706 20 11Z" stroke="white" stroke-width="1.5" stroke-linejoin="round"/>
          </svg>
        </div>
        <div class="search-wrap" style="display: none">
          <?php echo do_shortcode('[fibosearch]'); ?>
        </div>
      </div>
      <div class="catalog-toggle">
        <div class="icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
            <path d="M1.66663 15C1.66663 13.7163 1.66663 13.0744 1.95557 12.6029C2.11724 12.3391 2.33907 12.1173 2.6029 11.9556C3.07441 11.6667 3.71626 11.6667 4.99996 11.6667C6.28366 11.6667 6.92551 11.6667 7.39702 11.9556C7.66085 12.1173 7.88268 12.3391 8.04435 12.6029C8.33329 13.0744 8.33329 13.7163 8.33329 15C8.33329 16.2837 8.33329 16.9256 8.04435 17.3971C7.88268 17.6609 7.66085 17.8828 7.39702 18.0444C6.92551 18.3333 6.28366 18.3333 4.99996 18.3333C3.71626 18.3333 3.07441 18.3333 2.6029 18.0444C2.33907 17.8828 2.11724 17.6609 1.95557 17.3971C1.66663 16.9256 1.66663 16.2837 1.66663 15Z" stroke="white" stroke-width="1.25"/>
            <path d="M11.6666 15C11.6666 13.7163 11.6666 13.0744 11.9555 12.6029C12.1172 12.3391 12.339 12.1173 12.6029 11.9556C13.0744 11.6667 13.7163 11.6667 15 11.6667C16.2836 11.6667 16.9255 11.6667 17.397 11.9556C17.6609 12.1173 17.8827 12.3391 18.0444 12.6029C18.3333 13.0744 18.3333 13.7163 18.3333 15C18.3333 16.2837 18.3333 16.9256 18.0444 17.3971C17.8827 17.6609 17.6609 17.8828 17.397 18.0444C16.9255 18.3333 16.2836 18.3333 15 18.3333C13.7163 18.3333 13.0744 18.3333 12.6029 18.0444C12.339 17.8828 12.1172 17.6609 11.9555 17.3971C11.6666 16.9256 11.6666 16.2837 11.6666 15Z" stroke="white" stroke-width="1.25"/>
            <path d="M1.66663 5C1.66663 3.7163 1.66663 3.07445 1.95557 2.60294C2.11724 2.33911 2.33907 2.11728 2.6029 1.95561C3.07441 1.66667 3.71626 1.66667 4.99996 1.66667C6.28366 1.66667 6.92551 1.66667 7.39702 1.95561C7.66085 2.11728 7.88268 2.33911 8.04435 2.60294C8.33329 3.07445 8.33329 3.7163 8.33329 5C8.33329 6.2837 8.33329 6.92555 8.04435 7.39706C7.88268 7.66089 7.66085 7.88272 7.39702 8.04439C6.92551 8.33333 6.28366 8.33333 4.99996 8.33333C3.71626 8.33333 3.07441 8.33333 2.6029 8.04439C2.33907 7.88272 2.11724 7.66089 1.95557 7.39706C1.66663 6.92555 1.66663 6.2837 1.66663 5Z" stroke="white" stroke-width="1.25"/>
            <path d="M11.6666 5C11.6666 3.7163 11.6666 3.07445 11.9555 2.60294C12.1172 2.33911 12.339 2.11728 12.6029 1.95561C13.0744 1.66667 13.7163 1.66667 15 1.66667C16.2836 1.66667 16.9255 1.66667 17.397 1.95561C17.6609 2.11728 17.8827 2.33911 18.0444 2.60294C18.3333 3.07445 18.3333 3.7163 18.3333 5C18.3333 6.2837 18.3333 6.92555 18.0444 7.39706C17.8827 7.66089 17.6609 7.88272 17.397 8.04439C16.9255 8.33333 16.2836 8.33333 15 8.33333C13.7163 8.33333 13.0744 8.33333 12.6029 8.04439C12.339 7.88272 12.1172 7.66089 11.9555 7.39706C11.6666 6.92555 11.6666 6.2837 11.6666 5Z" stroke="white" stroke-width="1.25"/>
          </svg>
        </div>
        <span>Продукция</span>
      </div>
      <nav class="menu" itemscope itemtype="http://schema.org/SiteNavigationElement"> 
        <ul itemprop="about" itemscope itemtype="http://schema.org/ItemList">
        <?php  
          wp_nav_menu( array(
            'menu_class' => '',
            'theme_location' => 'menu-1',
            'container' => null,
            'walker'=> new True_Walker_Nav_Menu() // этот параметр нужно добавить
          )); 
        ?>
        </ul>
      </nav> 
      <div class="header-contacts">
        <a class="link" target="blank" href="tel:<?php the_field('phone', 'options'); ?>">
          <?php the_field('phone', 'options'); ?>
        </a>
        <a class="link" target="blank" href="mailto:<?php the_field('email', 'options'); ?>">
          <?php the_field('email', 'options'); ?>
        </a>
        <div class="button button-transparent callback">
          Заказать звонок
        </div>
        <div class="lang">
          <?php echo do_shortcode('[gtranslate]'); ?>
        </div>
      </div>
    </div>
  </div>
</header>





	