
<footer itemscope itemtype="https://schema.org/WPFooter" class="footer bg-dark">
  <div class="footer-top">
    <div class="container">
      <div class="wrap">
        <?php if (is_home()) : ?>
          <div  class="logo">
            <img class="light" src="<?php echo get_template_directory_uri(); ?>/img/logo-white.svg" alt="ООО «Источники питания»">
          </div>
          <?php else : ?>
          <a href="/" class="logo">
            <img class="light" src="<?php echo get_template_directory_uri(); ?>/img/logo-white.svg" alt="ООО «Источники питания»">
          </a>
        <?php endif; ?>
        <div class="center">
          <div class="item">
            <a href="tel:<?php echo get_field('phone', 'options'); ?>" target="blank">
              <?php echo get_field('phone', 'options'); ?>
            </a>
            <span><?php echo get_field('work_time', 'options'); ?></span>
          </div>
          <div class="item">
            <a href="mailto:<?php echo get_field('email_sales', 'options'); ?>" target="blank">
              <?php echo get_field('email_sales', 'options'); ?>
            </a>
            <span>Отдел продаж</span>
          </div>
          <div class="item">
            <a href="mailto:<?php echo get_field('email_info', 'options'); ?>" target="blank">
              <?php echo get_field('email_info', 'options'); ?>
            </a>
            <span>Общие вопросы</span>
          </div>
        </div>
        <div class="social">
          <a href="<?php echo get_field('tg', 'options'); ?>" target="blank">
            <div class="icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M2.95103 10.8534C8.29574 8.52476 11.8597 6.9896 13.643 6.24789C18.7345 4.13015 19.7925 3.76228 20.482 3.75013C20.6337 3.74746 20.9728 3.78504 21.1925 3.96329C21.378 4.11379 21.429 4.3171 21.4534 4.45979C21.4778 4.60248 21.5082 4.92754 21.4841 5.18154C21.2082 8.08056 20.0143 15.1157 19.4069 18.3627C19.1499 19.7366 18.6439 20.1972 18.154 20.2423C17.0893 20.3403 16.2808 19.5387 15.2496 18.8627C13.636 17.805 12.7244 17.1465 11.1581 16.1144C9.34796 14.9215 10.5214 14.2659 11.553 13.1945C11.823 12.9141 16.514 8.64722 16.6048 8.26015C16.6161 8.21174 16.6267 8.03129 16.5195 7.93601C16.4123 7.84073 16.254 7.87331 16.1399 7.89922C15.978 7.93596 13.4002 9.63977 8.40651 13.0107C7.67482 13.5131 7.01207 13.7579 6.41827 13.7451C5.76366 13.7309 4.50444 13.375 3.56834 13.0707C2.42017 12.6975 1.50764 12.5001 1.5871 11.8663C1.62849 11.5361 2.08313 11.1985 2.95103 10.8534Z" fill="white"/>
              </svg>
            </div>
          </a>
          <a href="<?php echo get_field('vk', 'options'); ?>" target="blank">
            <div class="icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M12.9401 18.432C5.74767 18.432 1.6453 13.603 1.47437 5.56738H5.07714C5.19548 11.4653 7.85148 13.9635 9.95529 14.4786V5.56738H13.3478V10.654C15.4253 10.4351 17.6078 8.11714 18.3441 5.56738H21.7366C21.1712 8.7095 18.8044 11.0275 17.1213 11.9804C18.8044 12.7531 21.5 14.7748 22.5256 18.432H18.7912C17.9892 15.9853 15.9907 14.0923 13.3478 13.8348V18.432H12.9401Z" fill="white"/>
              </svg>
            </div>
          </a>
          <a href="<?php echo get_field('ok', 'options'); ?>" target="blank">
            <div class="icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M12.0006 1.36523C8.86486 1.36523 6.31395 3.82768 6.31395 6.85489C6.31395 9.88186 8.86486 12.3432 12.0006 12.3432C15.1362 12.3432 17.6859 9.88186 17.6859 6.85489C17.6859 3.82768 15.1363 1.36523 12.0006 1.36523ZM12.0006 4.58166C13.2984 4.58166 14.3538 5.60191 14.3538 6.85489C14.3538 8.10733 13.2984 9.1268 12.0006 9.1268C10.7025 9.1268 9.64608 8.10735 9.64608 6.85489C9.64608 5.60191 10.7025 4.58166 12.0006 4.58166ZM7.31223 12.53C6.74961 12.5215 6.19636 12.7893 5.87541 13.2831C5.38495 14.0353 5.6199 15.028 6.39727 15.5011C7.42553 16.1239 8.54131 16.5658 9.69843 16.8205L6.52051 19.89C5.86995 20.5184 5.8705 21.5362 6.5212 22.1646C6.84734 22.4782 7.2727 22.6352 7.69915 22.6352C8.12516 22.6352 8.55195 22.478 8.8771 22.1639L11.9993 19.1483L15.1242 22.1639C15.7742 22.7922 16.8282 22.7922 17.4794 22.1639C18.1302 21.536 18.1302 20.5171 17.4794 19.8901L14.3001 16.8212C15.4575 16.5665 16.5737 16.1244 17.6012 15.5011C18.3801 15.028 18.6154 14.0342 18.1251 13.2831C17.6343 12.5307 16.6065 12.304 15.8271 12.7779C13.499 14.1917 10.4994 14.1908 8.1721 12.7779C7.90421 12.615 7.60693 12.5344 7.31223 12.53V12.53Z" fill="white"/>
              </svg>
            </div>
          </a>
          <a href="<?php echo get_field('wa', 'options'); ?>" target="blank">
            <div class="icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M1.77263 11.907C1.77199 13.7082 2.24474 15.4666 3.14365 17.0168L1.68652 22.3132L7.13095 20.892C8.63101 21.7058 10.3199 22.1354 12.0387 22.1359H12.0432C17.7035 22.1359 22.3107 17.5506 22.3132 11.9151C22.3143 9.18398 21.2469 6.61628 19.3078 4.68415C17.3689 2.75229 14.7904 1.68781 12.0427 1.68652C6.38208 1.68652 1.77483 6.27125 1.77238 11.9071L1.77263 11.907ZM12.043 22.1358H12.0431H12.043C12.0429 22.1358 12.0428 22.1358 12.043 22.1358Z" fill="white"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M9.38575 7.47709C9.18659 7.03639 8.97704 7.02757 8.78762 7.01981C8.63259 7.01325 8.45529 7.01368 8.27819 7.01368C8.10088 7.01368 7.8129 7.07991 7.56938 7.34472C7.32565 7.60955 6.63892 8.2497 6.63892 9.55164C6.63892 10.8537 7.59158 12.1118 7.72431 12.2885C7.85726 12.4649 9.56331 15.2222 12.265 16.2828C14.5106 17.1643 14.9675 16.989 15.4549 16.9448C15.9423 16.9008 17.0276 16.3049 17.2491 15.687C17.4706 15.0691 17.4706 14.5395 17.4042 14.4289C17.3378 14.3186 17.1605 14.2523 16.8947 14.1201C16.6288 13.9877 15.3219 13.3475 15.0783 13.2592C14.8346 13.171 14.6573 13.1269 14.48 13.3918C14.3028 13.6565 13.7937 14.2523 13.6386 14.4289C13.4836 14.6057 13.3284 14.6278 13.0626 14.4954C12.7967 14.3626 11.9406 14.0835 10.9249 13.1821C10.1347 12.4806 9.60121 11.6144 9.44607 11.3495C9.29104 11.0849 9.42952 10.9415 9.5628 10.8096C9.68223 10.691 9.82871 10.5006 9.96167 10.3462C10.0943 10.1916 10.1385 10.0814 10.2272 9.90483C10.3159 9.72821 10.2715 9.57366 10.2051 9.44129C10.1385 9.30893 9.62197 8.0003 9.3856 7.47701" fill="#0A3141"/>
              </svg>
            </div>
          </a>
        </div>
      </div> 
    </div>
  </div>
  <div class="footer-menu">
    <div class="container">
      <nav class="wrap" itemscope itemtype="http://schema.org/SiteNavigationElement">
        <?php if (have_rows('footer_menu_columns', 'options')) : while(have_rows('footer_menu_columns', 'options')) : the_row(); ?>
          <div class="column" itemprop="about" itemscope itemtype="http://schema.org/ItemList">
              <?php if (have_rows('block')) : while(have_rows('block')) : the_row(); ?>
                <?php if (get_sub_field('title_link')) : ?>
                  <a class="list-title" href="<?php echo get_sub_field('title_link'); ?>">
                   <span><?php echo get_sub_field('title'); ?></span>
                   <meta itemprop="name" content="<?php the_sub_field('title'); ?>">
                  </a>
                <?php else : ?>
                  <b class="list-title"><?php echo get_sub_field('title'); ?></b>
                <?php endif; ?>
                <?php if (have_rows('list')) : ?>
                  <ul class="block">
                    <?php 
                      global $wp; 
                      $current_path = $wp->request; // Получаем путь текущей страницы
                      while(have_rows('list')) : the_row(); 
                        $menu_url = get_sub_field('link'); // Получаем относительный URL из ACF
                        $menu_path = trim(parse_url($menu_url, PHP_URL_PATH), '/'); // Убираем начальный и конечный слеши и получаем путь без домена
                    ?>
                      <?php if ($menu_path == $current_path) : ?>
                        <li>
                          <span><?php the_sub_field('nazvanie'); ?></span>
                          <meta itemprop="name" content="<?php the_sub_field('nazvanie'); ?>">
                        </li>
                      <?php else : ?>
                        <li>
                          <a href="<?php echo esc_url($menu_url); ?>"><?php the_sub_field('nazvanie'); ?></a>
                          <meta itemprop="name" content="<?php the_sub_field('nazvanie'); ?>">
                        </li>
                      <?php  endif; ?>
                    <?php endwhile; ?>
                  </ul>
                <?php endif; ?>
              <?php endwhile; endif; ?>
          </div>
        <?php endwhile; endif; ?>
      </nav>
    </div>
  </div>
  <div class="footer-feat">
    <div class="container">
      <div class="wrap">
        <div class="item">
          <div class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M12.0015 1.75C8.17538 1.75 4.52505 4.01303 2.99714 7.58468C1.57518 10.9086 2.34496 13.7373 3.94771 16.1595C5.26177 18.1454 7.17835 19.9178 8.90742 21.5168L8.90824 21.5175C9.23768 21.8222 9.56031 22.1206 9.87066 22.4129L9.87231 22.4145C10.4473 22.9528 11.2112 23.25 12.0015 23.25C12.7919 23.25 13.5558 22.9528 14.1308 22.4144C14.4243 22.1396 14.7286 21.8592 15.039 21.5732C16.7869 19.9627 18.7304 18.172 20.0582 16.1609C21.6591 13.7362 22.4261 10.9045 21.0059 7.58468C19.478 4.01303 15.8277 1.75 12.0015 1.75ZM12 7.5C9.79086 7.5 8 9.29086 8 11.5C8 13.7091 9.79086 15.5 12 15.5C14.2091 15.5 16 13.7091 16 11.5C16 9.29086 14.2091 7.5 12 7.5Z" fill="#2CB4C2"/>
            </svg>
          </div>
          <div class="meta">
            <b>Производство</b>
            <a href="<?php echo get_permalink(247); ?>" class="address">
              <?php echo get_field('addr_prod', 'options'); ?>
            </a>
          </div>
        </div>
        <div class="item">
          <div class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M12.0015 1.75C8.17538 1.75 4.52505 4.01303 2.99714 7.58468C1.57518 10.9086 2.34496 13.7373 3.94771 16.1595C5.26177 18.1454 7.17835 19.9178 8.90742 21.5168L8.90824 21.5175C9.23768 21.8222 9.56031 22.1206 9.87066 22.4129L9.87231 22.4145C10.4473 22.9528 11.2112 23.25 12.0015 23.25C12.7919 23.25 13.5558 22.9528 14.1308 22.4144C14.4243 22.1396 14.7286 21.8592 15.039 21.5732C16.7869 19.9627 18.7304 18.172 20.0582 16.1609C21.6591 13.7362 22.4261 10.9045 21.0059 7.58468C19.478 4.01303 15.8277 1.75 12.0015 1.75ZM12 7.5C9.79086 7.5 8 9.29086 8 11.5C8 13.7091 9.79086 15.5 12 15.5C14.2091 15.5 16 13.7091 16 11.5C16 9.29086 14.2091 7.5 12 7.5Z" fill="#2CB4C2"/>
            </svg>
          </div>
          <div class="meta">
            <b>Офис</b>
            <a href="<?php echo get_permalink(247); ?>" class="address">
              <?php echo get_field('addr_office', 'options'); ?>
            </a>
          </div>
        </div>
        <div class="dir">
          <div class="dir-top">
            <b>Написать директору</b>
            <a href="mailto:<?php echo get_field('email_dir', 'options'); ?>" target="blank">
              <?php echo get_field('email_dir', 'options'); ?>
            </a>
          </div>
          <p>
            Свои пожелания или предложения по работе нашей компании вы можете адресовать напрямую генеральному директору, отправив письмо на почту
          </p>
        </div>
      </div>
    </div>
  </div>
  <div class="footer-subscribe">
    <div class="container">
      <div class="wrap">
        <div class="left">
          <div class="icon">
            <img src="<?php echo get_template_directory_uri(); ?>/img/icons/email.png" alt="Узнавайте о новинках первым!">
          </div>
          <b>Узнавайте о новинках первым!</b>
        </div>
        <div class="right">
          <div class="form">
            <?php echo do_shortcode('[contact-form-7 id="7a3df62" title="Подписка Unisender Подвал"]'); ?>
          </div>
         
          <small>
            Высылаем только самые полезные и интересные материалы не чаще одного раза в неделю
          </small>
        </div>
      </div>
    </div>
  </div>
  <div class="footer-bottom">
    <div class="container">
      <div class="wrap">
        <div class="left">
          <nav class="menu" itemscope itemtype="http://schema.org/SiteNavigationElement"> 
            <ul itemprop="about" itemscope itemtype="http://schema.org/ItemList">
            <?php  
              wp_nav_menu( array(
                'menu_class' => '',
                'theme_location' => 'menu-2',
                'container' => null,
                'walker'=> new True_Walker_Nav_Menu() // этот параметр нужно добавить
              )); 
            ?>
            </ul>
          </nav> 
        </div>
        <div class="right">
          <div class="button button-transparent call-tender">
            Пригласить в тендер
          </div>
        </div>
      </div>
    </div>
  </div>
  <meta itemprop="copyrightYear" content="2024">
  <meta itemprop="copyrightHolder" content="ООО «Источники питания»">
</footer>

<!-- Popups -->
  <div class="overlay" style="display: none"></div>

  <div class="popup popup-video" style="display: none">
    <div class="close">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
        <path d="M18.9998 5.49995L4.99976 19.4999M4.99976 5.49995L18.9998 19.4999" stroke="#141B34" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </div>
    <iframe width="860" height="515" src="" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
  </div>

  <div class="popup popup-catalog" style="display: none">
    <div class="close">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
        <path d="M18.9998 5.49995L4.99976 19.4999M4.99976 5.49995L18.9998 19.4999" stroke="#141B34" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </div>
    <div class="wrapper">
      <div class="form form-white">
        <b>Получить каталог</b>
        <p class="subtitle">
          После оптравки формы появится кнопка для скачивания каталога
        </p>
        <?php echo do_shortcode('[contact-form-7 id="70abe10" title="Отправка каталога (попап)"]'); ?>
      </div>
    </div>
    
  </div>

  <div class="popup popup-callback" style="display: none">
    <div class="close">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
        <path d="M18.9998 5.49995L4.99976 19.4999M4.99976 5.49995L18.9998 19.4999" stroke="#141B34" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </div>
    <div class="wrapper">
      <div class="form form-white">
        <b>Есть заказ или вопросы?</b>
        <p class="subtitle">
          Оставьте заявку и мы свяжемся с вами в ближайшее время
        </p>
        <?php echo do_shortcode('[contact-form-7 id="6ef74de" title="Заказать звонок (попап)"]'); ?>
      </div>
    </div>
    
  </div>

  <div class="popup popup-tender" style="display: none">
    <div class="close">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
        <path d="M18.9998 5.49995L4.99976 19.4999M4.99976 5.49995L18.9998 19.4999" stroke="#141B34" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </div>
    <div class="wrapper">
      <div class="form form-white">
        <b>Пригласить нас в тендер</b>
        <p class="subtitle">
          Принимаем заказы от организаций и физических лиц
        </p>
        <?php echo do_shortcode('[contact-form-7 id="0069bb7" title="Пригласить в тендер (попап)"]'); ?>
      </div>
    </div>
    
  </div>

  <div class="popup popup-faq" style="display: none">
    <div class="close">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
        <path d="M18.9998 5.49995L4.99976 19.4999M4.99976 5.49995L18.9998 19.4999" stroke="#141B34" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </div>
    <div class="wrapper">
      <div class="form form-white">
        <b>Задать вопрос</b>
        <p class="subtitle">
          Мы ответим вам лично и добавим в каталог вопросов
        </p>
        <?php echo do_shortcode('[contact-form-7 id="2cb0f22" title="Задать вопрос (попап)"]'); ?>
      </div>
    </div>
    
  </div>

  <div class="popup popup-vacancy" style="display: none">
    <div class="close">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
        <path d="M18.9998 5.49995L4.99976 19.4999M4.99976 5.49995L18.9998 19.4999" stroke="#141B34" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </div>
    <div class="wrapper">
      <div class="form form-white">
        <b>Анкета соискателя</b>
        <p class="subtitle">
          Мы изучим вашу анкету и свяжемся в случае принятия положительного решения
        </p>
        <div class="mini-title">Контактные данные</div>
        <?php echo do_shortcode('[contact-form-7 id="5fd2503" title="Отклик на вакансию (попап)"]'); ?>
      </div>
    </div>
  </div>


  <div class="popup thanks" id="thx-catalog" style="display: none">
    <div class="close">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
        <path d="M18.9998 5.49995L4.99976 19.4999M4.99976 5.49995L18.9998 19.4999" stroke="#141B34" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </div>
    <div class="wrapper-thx">
      <div class="icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100" fill="none">
          <path opacity="0.4" d="M5.20837 50C5.20837 74.7379 25.2623 94.7917 50 94.7917C74.738 94.7917 94.7917 74.7379 94.7917 50C94.7917 25.2622 74.738 5.20831 50 5.20831C25.2623 5.20831 5.20837 25.2622 5.20837 50Z" fill="#2CB4C2"/>
          <path d="M70.3229 33.4183C71.427 35.4372 70.6854 37.969 68.6666 39.0732C62.9525 42.1979 57.5866 48.7396 53.4891 55.0133C51.492 58.0717 49.8895 60.9196 48.7875 63.0017C48.2375 64.0404 47.815 64.8837 47.5329 65.4604L47.1233 66.3162C46.4795 67.7233 45.1087 68.6592 43.5637 68.7446C42.0183 68.8296 40.5527 68.0513 39.7582 66.7229C38.4635 64.5583 36.4063 62.5825 34.4998 61.0754C33.5735 60.3429 32.7396 59.7654 32.1446 59.3758L31.2684 58.8279C29.2705 57.6871 28.5748 55.1433 29.7146 53.145C30.8547 51.1458 33.3993 50.4496 35.3982 51.5896L36.7109 52.405C37.47 52.9021 38.5112 53.6237 39.6682 54.5383C40.5524 55.2375 41.541 56.0779 42.5391 57.0462C43.6091 55.1237 44.9466 52.8542 46.512 50.4567C50.7483 43.9704 57.0487 35.9286 64.6683 31.7618C66.687 30.6576 69.2187 31.3993 70.3229 33.4183Z" fill="#2CB4C2"/>
        </svg>
      </div>
      <b>Каталог аккумуляторов НЭТЕР</b>
      <p>Скачать полный каталог литиевых аккумуляторных ячеек и батарей Вы можете по ссылке ниже. Так же ссылка будет продублирована на указанную Вами электронную почту.</p>
      <div class="btns">
        <a class="button" target="blank" href="<?php echo get_field('cat_file','options'); ?>" download>
          Скачать каталог
        </a>
        <div class="button button-border callback">
          Консультация
        </div>
      </div>
    </div>
  </div>

  <div class="popup thanks" id="thx" style="display: none">
    <div class="close">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
        <path d="M18.9998 5.49995L4.99976 19.4999M4.99976 5.49995L18.9998 19.4999" stroke="#141B34" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </div>
    <div class="wrapper-thx">
      <div class="icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100" fill="none">
          <path opacity="0.4" d="M5.20837 50C5.20837 74.7379 25.2623 94.7917 50 94.7917C74.738 94.7917 94.7917 74.7379 94.7917 50C94.7917 25.2622 74.738 5.20831 50 5.20831C25.2623 5.20831 5.20837 25.2622 5.20837 50Z" fill="#2CB4C2"/>
          <path d="M70.3229 33.4183C71.427 35.4372 70.6854 37.969 68.6666 39.0732C62.9525 42.1979 57.5866 48.7396 53.4891 55.0133C51.492 58.0717 49.8895 60.9196 48.7875 63.0017C48.2375 64.0404 47.815 64.8837 47.5329 65.4604L47.1233 66.3162C46.4795 67.7233 45.1087 68.6592 43.5637 68.7446C42.0183 68.8296 40.5527 68.0513 39.7582 66.7229C38.4635 64.5583 36.4063 62.5825 34.4998 61.0754C33.5735 60.3429 32.7396 59.7654 32.1446 59.3758L31.2684 58.8279C29.2705 57.6871 28.5748 55.1433 29.7146 53.145C30.8547 51.1458 33.3993 50.4496 35.3982 51.5896L36.7109 52.405C37.47 52.9021 38.5112 53.6237 39.6682 54.5383C40.5524 55.2375 41.541 56.0779 42.5391 57.0462C43.6091 55.1237 44.9466 52.8542 46.512 50.4567C50.7483 43.9704 57.0487 35.9286 64.6683 31.7618C66.687 30.6576 69.2187 31.3993 70.3229 33.4183Z" fill="#2CB4C2"/>
        </svg>
      </div>
      <b>Спасибо за заявку</b>
      <p>Мы получили вашу заявку и свяжемся с вами в течение дня</p>
      <div class="button close-button">
        Понятно
      </div>
    </div>
  </div>

  <div class="popup thanks" id="thx-sub" style="display: none">
    <div class="close">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
        <path d="M18.9998 5.49995L4.99976 19.4999M4.99976 5.49995L18.9998 19.4999" stroke="#141B34" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </div>
    <div class="wrapper-thx">
      <div class="icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100" fill="none">
          <path opacity="0.4" d="M5.20837 50C5.20837 74.7379 25.2623 94.7917 50 94.7917C74.738 94.7917 94.7917 74.7379 94.7917 50C94.7917 25.2622 74.738 5.20831 50 5.20831C25.2623 5.20831 5.20837 25.2622 5.20837 50Z" fill="#2CB4C2"/>
          <path d="M70.3229 33.4183C71.427 35.4372 70.6854 37.969 68.6666 39.0732C62.9525 42.1979 57.5866 48.7396 53.4891 55.0133C51.492 58.0717 49.8895 60.9196 48.7875 63.0017C48.2375 64.0404 47.815 64.8837 47.5329 65.4604L47.1233 66.3162C46.4795 67.7233 45.1087 68.6592 43.5637 68.7446C42.0183 68.8296 40.5527 68.0513 39.7582 66.7229C38.4635 64.5583 36.4063 62.5825 34.4998 61.0754C33.5735 60.3429 32.7396 59.7654 32.1446 59.3758L31.2684 58.8279C29.2705 57.6871 28.5748 55.1433 29.7146 53.145C30.8547 51.1458 33.3993 50.4496 35.3982 51.5896L36.7109 52.405C37.47 52.9021 38.5112 53.6237 39.6682 54.5383C40.5524 55.2375 41.541 56.0779 42.5391 57.0462C43.6091 55.1237 44.9466 52.8542 46.512 50.4567C50.7483 43.9704 57.0487 35.9286 64.6683 31.7618C66.687 30.6576 69.2187 31.3993 70.3229 33.4183Z" fill="#2CB4C2"/>
        </svg>
      </div>
      <b>Спасибо за подписку</b>
      <p>Мы высылаем только самые полезные и интересные материалы не чаще одного раза в неделю</p>
      <div class="button close-button">
        Понятно
      </div>
    </div>
  </div>

  <div class="cookie" style="display: none">
    <b>Используем куки для улучшения работы сайта</b>
    <p>Оставаясь с нами, вы соглашаетесь на использование файлов куки</p>
    <div class="button"><span>Понятно</span></div>
  </div>
<!-- Popup's END -->

<div id="up-arr" style="display: none">
  <div class="icon">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
      <path d="M12 4.99998L12 20" stroke="#818793" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
      <path d="M17 9L12.7071 4.7071C12.3738 4.3738 12.2071 4.2071 12 4.2071C11.7929 4.2071 11.6262 4.3738 11.2929 4.7071L7 9" stroke="#818793" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
  </div>
</div>

<!-- PC catalog -->
<div class="pc-catalog" style="display: none">
  <div class="container">
    <div class="wrap">
      <?php if (have_rows('menu_catalog', 'options')) : while(have_rows('menu_catalog', 'options')) : the_row(); ?>
        <div class="wrapper">
          <a href="<?php echo get_sub_field('main_link'); ?>" class="item">
            <div class="icon">
              <img src="<?php echo get_sub_field('img'); ?>" alt="<?php echo get_sub_field('title'); ?>">
            </div>
            <p><?php echo get_sub_field('title'); ?></p>
          </a>
          <?php if (have_rows('sub_menu')) : ?>
          <div class="sub-menu">
            <?php while(have_rows('sub_menu')) : the_row(); ?>
              <div class="sub-menu-wrap">
                <b><?php echo get_sub_field('title_sub'); ?></b>
                <ul>
                  <?php if (have_rows('sub_links')) : while(have_rows('sub_links')) : the_row(); ?>
                    <li>
                      <a href="<?php echo get_sub_field('link'); ?>">
                        <?php echo get_sub_field('name'); ?>
                      </a>
                    </li>
                  <?php endwhile; endif; ?>
                </ul>
              </div>
            <?php endwhile;  ?>
          </div>
          <?php endif; ?>
        </div>
      <?php endwhile; endif; ?>
    </div>
  </div>
</div>
<!-- PC catalog END -->

<!-- Mob header menu's -->
<div class="mob-menu" style="display: none">
  <div class="top">
    <div class="container">
      <?php if (is_home()) : ?>
        <div class="logo">
          <img class="dark" src="<?php echo get_template_directory_uri(); ?>/img/logo-dark.svg" alt="ООО «Источники питания»">
        </div>
        <?php else : ?>
        <a href="/" class="logo">
          <img class="dark" src="<?php echo get_template_directory_uri(); ?>/img/logo-dark.svg" alt="ООО «Источники питания»">
        </a>
      <?php endif; ?> 
      <div class="right">
        <div class="lang">
          <?php echo do_shortcode('[gtranslate]'); ?>
        </div>
        <div class="close icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path d="M18.9998 5L4.9998 19M4.9998 5L18.9998 19" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="menu">
      <div class="search-wrap" style="display: block">
        <?php echo do_shortcode('[fibosearch]'); ?>
      </div>
      <nav class="mob-cats">
        <?php if (have_rows('menu_catalog', 'options')) : while(have_rows('menu_catalog', 'options')) : the_row(); ?>
          <div class="wrapper">
            <a href="<?php echo get_sub_field('main_link'); ?>" class="item">
              <img src="<?php echo get_sub_field('img'); ?>" alt="<?php echo get_sub_field('title'); ?>">
              <p><?php echo get_sub_field('title'); ?></p>
              <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                  <path d="M9.00014 6L14.293 11.2929C14.6264 11.6262 14.793 11.7929 14.793 12C14.793 12.2071 14.6264 12.3738 14.293 12.7071L9.00014 18" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </div>
            </a>
            <?php 
              $main_link = get_sub_field('main_link');
              $main_name = get_sub_field('title');
            ?>
            <?php if (have_rows('sub_menu')) : ?>
            <div class="sub-menu">
              <div class="container">
                <div class="back-btn">
                  <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                      <path d="M5 12L20 11.9998" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M9.00001 7L4.70712 11.2929C4.37378 11.6262 4.20712 11.7929 4.20712 12C4.20712 12.2071 4.37378 12.3738 4.70712 12.7071L9.00001 17" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                  </div>
                  <span>Назад</span>
                </div>
                <a href="<?php echo $main_link; ?>" class="main-link">
                  <?php echo $main_name; ?>
                </a>
                <?php while(have_rows('sub_menu')) : the_row(); ?>
                  <div class="sub-menu-wrap">
                    <?php if (get_sub_field('title_sub')) : ?>
                      <b><?php echo get_sub_field('title_sub'); ?></b>
                    <?php else : ?>
                      <div class="mt-top"></div>
                    <?php endif; ?>
                    <ul>
                      <?php if (have_rows('sub_links')) : while(have_rows('sub_links')) : the_row(); ?>
                        <li>
                          <a href="<?php echo get_sub_field('link'); ?>">
                            <?php echo get_sub_field('name'); ?>
                          </a>
                        </li>
                      <?php endwhile; endif; ?>
                    </ul>
                  </div>
                <?php endwhile;  ?>
              </div>
            </div>
            <?php endif; ?>
          </div>
        <?php endwhile; endif; ?>
      </nav>
      <nav class="mob-nav" itemscope itemtype="http://schema.org/SiteNavigationElement"> 
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
      <div class="mob-contacts">
        <a class="link" target="blank" href="tel:<?php the_field('phone', 'options'); ?>">
          <span><?php the_field('phone', 'options'); ?></span>
          <p>Единый номер по России</p>
        </a>
        <div class="link">
          <span><?php the_field('work_time', 'options'); ?></span>
          <p>Режим работы</p>
        </div>
        <a class="link" target="blank" href="mailto:<?php the_field('email_info', 'options'); ?>">
          <span><?php the_field('email_info', 'options'); ?></span>
          <p>Общие вопросы</p>
        </a>
        <a class="link" target="blank" href="mailto:<?php the_field('email', 'options'); ?>">
          <span><?php the_field('email', 'options'); ?></span>
          <p>Отдел продаж</p>
        </a>
        <div class="social">
          <a href="<?php echo get_field('tg', 'options'); ?>" target="blank">
            <div class="icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M2.95078 10.8534C8.2955 8.52476 11.8595 6.9896 13.6427 6.24789C18.7342 4.13015 19.7922 3.76228 20.4818 3.75013C20.6335 3.74746 20.9726 3.78504 21.1922 3.96329C21.3777 4.11379 21.4287 4.3171 21.4532 4.45979C21.4776 4.60248 21.508 4.92754 21.4838 5.18154C21.2079 8.08056 20.014 15.1157 19.4067 18.3627C19.1497 19.7366 18.6436 20.1972 18.1537 20.2423C17.089 20.3403 16.2806 19.5387 15.2494 18.8627C13.6357 17.805 12.7241 17.1465 11.1578 16.1144C9.34771 14.9215 10.5211 14.2659 11.5527 13.1945C11.8227 12.9141 16.5137 8.64722 16.6045 8.26015C16.6159 8.21174 16.6264 8.03129 16.5192 7.93601C16.412 7.84073 16.2538 7.87331 16.1396 7.89922C15.9778 7.93596 13.4 9.63977 8.40627 13.0107C7.67457 13.5131 7.01183 13.7579 6.41803 13.7451C5.76341 13.7309 4.50419 13.375 3.56809 13.0707C2.41993 12.6975 1.50739 12.5001 1.58685 11.8663C1.62824 11.5361 2.08289 11.1985 2.95078 10.8534Z" fill="#2CB4C2"/>
              </svg>
            </div>
          </a>
          <a href="<?php echo get_field('vk', 'options'); ?>" target="blank">
            <div class="icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M12.9403 18.432C5.74791 18.432 1.64554 13.603 1.47461 5.56738H5.07739C5.19573 11.4653 7.85172 13.9635 9.95554 14.4786V5.56738H13.3481V10.654C15.4256 10.4351 17.608 8.11714 18.3444 5.56738H21.7368C21.1714 8.7095 18.8046 11.0275 17.1216 11.9804C18.8046 12.7531 21.5003 14.7748 22.5259 18.432H18.7915C17.9894 15.9853 15.991 14.0923 13.3481 13.8348V18.432H12.9403Z" fill="#2CB4C2"/>
              </svg>
            </div>
          </a>
          <a href="<?php echo get_field('ok', 'options'); ?>" target="blank">
            <div class="icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M12.0006 1.36523C8.86486 1.36523 6.31395 3.82768 6.31395 6.85489C6.31395 9.88186 8.86486 12.3432 12.0006 12.3432C15.1362 12.3432 17.6859 9.88186 17.6859 6.85489C17.6859 3.82768 15.1363 1.36523 12.0006 1.36523ZM12.0006 4.58166C13.2984 4.58166 14.3538 5.60191 14.3538 6.85489C14.3538 8.10733 13.2984 9.1268 12.0006 9.1268C10.7025 9.1268 9.64608 8.10735 9.64608 6.85489C9.64608 5.60191 10.7025 4.58166 12.0006 4.58166ZM7.31223 12.53C6.74961 12.5215 6.19636 12.7893 5.87541 13.2831C5.38495 14.0353 5.6199 15.028 6.39727 15.5011C7.42553 16.1239 8.54131 16.5658 9.69843 16.8205L6.52051 19.89C5.86995 20.5184 5.8705 21.5362 6.5212 22.1646C6.84734 22.4782 7.2727 22.6352 7.69915 22.6352C8.12516 22.6352 8.55195 22.478 8.8771 22.1639L11.9993 19.1483L15.1242 22.1639C15.7742 22.7922 16.8282 22.7922 17.4794 22.1639C18.1302 21.536 18.1302 20.5171 17.4794 19.8901L14.3001 16.8212C15.4575 16.5665 16.5737 16.1244 17.6012 15.5011C18.3801 15.028 18.6154 14.0342 18.1251 13.2831C17.6343 12.5307 16.6065 12.304 15.8271 12.7779C13.499 14.1917 10.4994 14.1908 8.1721 12.7779C7.90421 12.615 7.60693 12.5344 7.31223 12.53V12.53Z" fill="#2CB4C2"/>
              </svg>
            </div>
          </a>
          <a href="<?php echo get_field('wa', 'options'); ?>" target="blank">
            <div class="icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M1.77361 11.9073C1.77297 13.7084 2.24571 15.4669 3.14462 17.0171L1.6875 22.3134L7.13193 20.8922C8.63198 21.706 10.3209 22.1356 12.0397 22.1361H12.0441C17.7045 22.1361 22.3117 17.5508 22.3142 11.9153C22.3152 9.18422 21.2479 6.61652 19.3087 4.68439C17.3699 2.75254 14.7913 1.68805 12.0437 1.68677C6.38306 1.68677 1.77581 6.27149 1.77335 11.9073L1.77361 11.9073ZM12.044 22.1361H12.0441H12.044C12.0439 22.1361 12.0438 22.1361 12.044 22.1361Z" fill="#2CB4C2"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M9.38746 7.47758C9.1883 7.03688 8.97875 7.02805 8.78933 7.0203C8.6343 7.01374 8.457 7.01417 8.2799 7.01417C8.10259 7.01417 7.81461 7.0804 7.57109 7.34521C7.32735 7.61004 6.64062 8.25019 6.64062 9.55213C6.64062 10.8542 7.59329 12.1123 7.72601 12.289C7.85897 12.4654 9.56502 15.2227 12.2667 16.2833C14.5123 17.1648 14.9692 16.9895 15.4566 16.9453C15.944 16.9013 17.0294 16.3054 17.2508 15.6874C17.4723 15.0696 17.4723 14.5399 17.4059 14.4293C17.3395 14.3191 17.1622 14.2528 16.8964 14.1206C16.6305 13.9882 15.3236 13.348 15.08 13.2597C14.8363 13.1715 14.6591 13.1274 14.4817 13.3923C14.3045 13.6569 13.7954 14.2528 13.6403 14.4293C13.4853 14.6062 13.3301 14.6283 13.0643 14.4959C12.7984 14.3631 11.9423 14.084 10.9266 13.1825C10.1364 12.4811 9.60292 11.6149 9.44778 11.35C9.29275 11.0854 9.43123 10.942 9.56451 10.8101C9.68394 10.6915 9.83042 10.5011 9.96338 10.3467C10.096 10.1921 10.1403 10.0818 10.2289 9.90532C10.3176 9.72869 10.2732 9.57415 10.2068 9.44178C10.1403 9.30942 9.62368 8.00079 9.3873 7.4775" fill="white"/>
              </svg>
            </div>
          </a>
        </div>
      </div>
      <div class="back-btn main-btn" style="display: none">
        <div class="icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path d="M5 12L20 11.9998" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M9.00001 7L4.70712 11.2929C4.37378 11.6262 4.20712 11.7929 4.20712 12C4.20712 12.2071 4.37378 12.3738 4.70712 12.7071L9.00001 17" stroke="#2CB4C2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
        <span>Назад</span>
      </div>
    </div>
  </div>
</div>
<!-- Mob header menu's END -->

<!-- Cart -->
  <div class="mini-cart" style="display: none">
    <div class="wrapper">
      <div class="close">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
          <path d="M19 5.49995L5 19.5M5 5.49995L19 19.5" stroke="#141B34" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>
      <b class="mini-title">Рассчитать стоимость</b>
      <p class="mini-subtitle">
        Мы отправим расчет на указанный электронный адрес и позвоним для уточнения деталей поставки
      </p>
      <div class="clear-cart">
        Очистить корзину
      </div>
      <div class="mini-cart-content">
      </div>
      <div class="form">
        <b class="form-title">Контактные данные</b>
        <?php echo do_shortcode('[contact-form-7 id="5865448" title="Корзина (popup)"]'); ?>
      </div>
    </div>
  </div>
  <div class="cart-toggle" style="display: none">
    <div class="wrapper">
      <div class="load-circle"></div>
      <div class="icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
          <path d="M8.39996 16L17.1201 15.2733C19.8486 15.046 20.4611 14.45 20.7635 11.7289L21.4 6" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
          <path d="M6.39996 6H22.4" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
          <path d="M6.39996 22C7.50453 22 8.39996 21.1046 8.39996 20C8.39996 18.8954 7.50453 18 6.39996 18C5.29539 18 4.39996 18.8954 4.39996 20C4.39996 21.1046 5.29539 22 6.39996 22Z" stroke="white" stroke-width="1.5"/>
          <path d="M17.4 22C18.5045 22 19.4 21.1046 19.4 20C19.4 18.8954 18.5045 18 17.4 18C16.2954 18 15.4 18.8954 15.4 20C15.4 21.1046 16.2954 22 17.4 22Z" stroke="white" stroke-width="1.5"/>
          <path d="M8.39996 20H15.4" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
          <path d="M2.39996 2H3.36596C4.31064 2 5.1341 2.62459 5.36322 3.51493L8.33848 15.0765C8.48883 15.6608 8.36016 16.2797 7.9882 16.7616L7.03209 18" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
        </svg>
      </div>
      <p>Рассчитать стоимость</p>
      <div class="cart-count">0</div>
    </div>
  </div>
<!-- Cart END -->

<!-- Filters popup -->
<div class="filters-popup">
  <div class="wrap">
    <div class="close-row">
      <b class="mini-title">
        Фильтры
      </b>
      <div class="close">
        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
          <path d="M31.6663 8.33334L8.33301 31.6667M8.33301 8.33334L31.6663 31.6667" stroke="#141B34" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>
    </div>
    <div class="filters-wrapper">
      <?php echo do_shortcode('[wpf-filters id=2]'); ?>
      <?php //echo do_shortcode('[wpf-filters id=6]'); ?>
    </div>
    <div class="buttons">
      <div class="button filers-popup-confirm">
        Применить
      </div>
      <div class="button button-white filters-popup-reset">
        Сбросить
      </div>
    </div>
  </div>
</div>
<!-- Filters popup END -->


<?php wp_footer(); ?>


</body>
</html>
