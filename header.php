<!doctype html>
<html <?php language_attributes(); ?>>
<head>
   <meta charset="UTF-8">
   <?php
    // Получаем текущий URL
    $current_url = $_SERVER['REQUEST_URI'];
    
    // Список подстрок для проверки
    $noindex_patterns = array(
		'?calltouch_tm',
		'?s=',             
        '/search',            
        '?wpf_filter_',      
        '?feed=',            
        '?add-to-cart',         
        '?yprqee',    
        '?etext',
    );

    // Преобразуем текущий URL в нижний регистр (для исключения ошибок регистра)
    $current_url_lower = strtolower($current_url);

    // Проверяем наличие значений в URL
    $add_noindex = false;
    foreach ($noindex_patterns as $pattern) {
        if (strpos($current_url_lower, strtolower($pattern)) !== false) {
            $add_noindex = true;
            break;
        }
    }

    // Если условие выполнено, выводим meta-robots
    if ($add_noindex) {
        echo '<meta name="robots" content="noindex, nofollow"/>';
    }
  ?>
<link rel="preload" as="style" href="<?php echo get_stylesheet_directory_uri(); ?>/css/header.min.css" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/header.min.css">
    </noscript>
  
  <link rel="preload" as="style" href="<?php echo get_stylesheet_directory_uri(); ?>/css/main.min.css" onload="this.onload=null;this.rel='stylesheet'">
  <noscript>
      <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/main.min.css">
  </noscript> 
	
	 <link rel="preload" as="style" href="<?php echo get_stylesheet_directory_uri(); ?>/css/pages.min.css" onload="this.onload=null;this.rel='stylesheet'">
  <noscript>
      <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/pages.min.css">
  </noscript>
		
	 <link rel="preload" as="style" href="<?php echo get_stylesheet_directory_uri(); ?>/css/woo.min.css" onload="this.onload=null;this.rel='stylesheet'">
 <noscript>
      <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/woo.min.css">
  </noscript> 

  <?php if (is_home()) { ?>
    <link rel="preload" as="image" href="<?php echo esc_url(get_field('offer_bg', 'options')); ?>" />
  <?php } else { ?>
      <?php if (get_field('offer_img')) : ?>
          <link rel="preload" as="image" href="<?php echo esc_url(get_field('offer_img')); ?>" />
      <?php endif; ?>
      <?php if (get_field('offer_bg')) : ?>
          <link rel="preload" as="image" href="<?php echo esc_url(get_field('offer_bg')); ?>" />
      <?php endif; ?>
      <?php if ((is_singular('post') || is_singular('product')) && get_the_post_thumbnail_url()) : ?>
          <link rel="preload" as="image" href="<?php echo esc_url(get_the_post_thumbnail_url()); ?>" />
      <?php endif; ?>
      <?php if (is_product_category()) {
          $term = get_queried_object();
          $term_id = $term->term_id;
          $thumbnail_id = get_term_meta($term_id, 'thumbnail_id', true);
          if ($thumbnail_id) {
              $acf_image = wp_get_attachment_image_src($thumbnail_id, 'offer-size');
              if ($acf_image && !empty($acf_image[0])) {
                  ?>
                  <link rel="preload" as="image" href="<?php echo esc_url($acf_image[0]); ?>" />
                  <?php
              }
          }
      } ?>
<?php } ?>
  
  <meta name="viewport" id="myViewport" content="width=device-width, maximum-scale=1.0, user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="format-detection" content="telephone=no">

  <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/img/favicon/favicon.ico" sizes="any"><!-- 32×32 -->
  <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/img/favicon/icon.png" type="image/svg+xml">
  <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/img/favicon/apple-touch-icon.png"><!-- 180×180 -->
  <link rel="manifest" href="<?php echo get_template_directory_uri(); ?>/manifest.webmanifest">
  <link rel="yandex-tableau-widget" href="<?php echo get_template_directory_uri(); ?>/tableau.json">
  
  <?php wp_head(); ?>


<!--   <script type="text/javascript" >
    (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
    m[i].l=1*new Date();
    for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
    k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
    (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

    ym(74565406, "init", {
          clickmap:true,
          trackLinks:true,
          accurateTrackBounce:true,
          webvisor:true
    });
  </script>

  <noscript><div><img src="https://mc.yandex.ru/watch/74565406" style="position:absolute; left:-9999px;" alt="" /></div></noscript> -->

  
</head>

<body id="top">

<div class="mob-header 
  <?php 
    if (
        is_page_template('page-development.php') // проверяем сначала шаблон
    ) { 
        echo 'mob-header-home'; 
    } elseif (
        !is_home() && 
        !is_page(346) && 
        !is_page(4620) && 
        !is_page(4508) && 
        !is_page(599) &&  
        !is_product_category() && 
        !is_tax()
    ) { 
        echo 'white'; 
    } else { 
        if (is_search()) {
            echo 'white'; 
        } elseif (is_tax('blog-category')) {
            echo 'white'; 
        } else {
            echo 'mob-header-home'; 
        }
    } 
  ?>
">
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

<header itemscope itemtype="http://schema.org/WPHeader" class="header 
  <?php 
    if (
        !is_home() && 
        !is_page(346) && 
        !is_page(4620) && 
        !is_page(4508) && 
        !is_page(599) &&  
        !is_product_category() && 
        !is_tax() && 
        !is_page_template('page-development.php') 
    ) { 
        echo 'header-white'; 
    } else { 
        // Дополнительные проверки
        if (is_search()) {
            echo 'header-white'; 
        } elseif (is_tax('blog-category')) {
            echo 'header-white'; 
        } else {
            echo 'header-home'; 
        }
    } 
  ?>
  " style="display: none"> 
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
            'theme_location' => 'menu-3',
            'container' => null,
            'walker'=> new True_Walker_Nav_Menu() // этот параметр нужно добавить
          )); 
        ?>
        </ul>
      </nav> 
      <div class="header-contacts">
        <?php if (!is_page(4617)) : ?>
        <a class="link" target="blank" href="tel:<?php echo get_field('phone', 'options'); ?>">
          <?php the_field('phone', 'options'); ?>
        </a>
        <?php endif; ?>
        <?php if (is_page(4617)) : ?>
        <a class="link" target="blank" href="mailto:info@batareon.ru">
          info@batareon.ru
        </a>
        <?php else : ?>
        <a class="link" target="blank" href="mailto:<?php echo get_field('email', 'options'); ?>">
          <?php echo get_field('email', 'options'); ?>
        </a>
        <?php endif; ?>
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

<!-- PC catalog -->
<div class="pc-catalog" style="display: none">
  <div class="container">
    <div class="wrap">
      <?php 
      $current_url = untrailingslashit($_SERVER['REQUEST_URI']); // Текущий URL без конечного слеша

      if (have_rows('menu_catalog', 'options')) : while(have_rows('menu_catalog', 'options')) : the_row(); 
          $main_link_url = untrailingslashit(parse_url(get_sub_field('main_link'), PHP_URL_PATH)); // URL для основного пункта меню
          ?>
        <div class="wrapper">
          <?php if ($current_url === $main_link_url) : ?>
            <span class="item">
              <div class="icon">
                <img src="<?php echo get_sub_field('img'); ?>" alt="<?php echo get_sub_field('title'); ?>">
              </div>
              <p><?php echo get_sub_field('title'); ?></p>
            </span>
          <?php else : ?>
            <a href="<?php echo esc_url($main_link_url); ?>" class="item">
              <div class="icon">
                <img src="<?php echo get_sub_field('img'); ?>" alt="<?php echo get_sub_field('title'); ?>">
              </div>
              <p><?php echo get_sub_field('title'); ?></p>
            </a>
          <?php endif; ?>
          
          <?php if (have_rows('sub_menu')) : ?>
          <div class="sub-menu">
            <?php while(have_rows('sub_menu')) : the_row(); ?>
              <div class="sub-menu-wrap">
                <b><?php echo get_sub_field('title_sub'); ?></b>
                <ul>
                  <?php if (have_rows('sub_links')) : while(have_rows('sub_links')) : the_row(); 
                      $sub_link_url = untrailingslashit(parse_url(get_sub_field('link'), PHP_URL_PATH)); // URL для подпункта меню
                      ?>
                    <li>
                      <?php if ($current_url === $sub_link_url) : ?>
                        <span><?php echo get_sub_field('name'); ?></span>
                      <?php else : ?>
                        <a href="<?php echo esc_url($sub_link_url); ?>">
                          <?php echo get_sub_field('name'); ?>
                        </a>
                      <?php endif; ?>
                    </li>
                  <?php endwhile; endif; ?>
                </ul>
              </div>
            <?php endwhile; ?>
          </div>
          <?php endif; ?>
        </div>
      <?php endwhile; endif; ?>
    </div>
  </div>
</div>
<!-- PC catalog END -->




	
