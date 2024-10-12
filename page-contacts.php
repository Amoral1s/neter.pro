<?php
/**
 Template Name: Контакты
 */

get_header();
?>

<div class="page-top">
  <div class="container">
    <?php
      if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<p class="breadcrumbs">', '</p>'); }
    ?>
    
  </div>
</div>

<section class="contacts-top">
  <div class="container">
    <h1 class="page-title sub"><?php the_title(); ?></h1>
    <div class="wrap">
      <div class="left">
        <div class="item">
          <a target="blank" href="tel:<?php echo get_field('phone', 'options'); ?>">
            <?php echo get_field('phone', 'options'); ?>
          </a>
          <p>Единый номер по России</p>
        </div>
        <div class="item">
          <div>
            <?php echo get_field('work_time', 'options'); ?>
          </div>
          <p>Режим работы</p>
        </div>
        <div class="item">
          <a target="blank" href="mailto:<?php echo get_field('email_info', 'options'); ?>">
            <?php echo get_field('email_info', 'options'); ?>
          </a>
          <p>Общие вопросы</p>
        </div>
        <div class="item">
          <a target="blank" href="mailto:<?php echo get_field('email', 'options'); ?>">
            <?php echo get_field('email', 'options'); ?>
          </a>
          <p>Отдел продаж</p>
        </div>
      </div>
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
              <path d="M1.77361 11.9072C1.77297 13.7084 2.24571 15.4668 3.14462 17.017L1.6875 22.3134L7.13193 20.8922C8.63198 21.7059 10.3209 22.1355 12.0397 22.1361H12.0441C17.7045 22.1361 22.3117 17.5508 22.3142 11.9152C22.3152 9.18416 21.2479 6.61646 19.3087 4.68433C17.3699 2.75248 14.7913 1.68799 12.0437 1.68671C6.38306 1.68671 1.77581 6.27143 1.77335 11.9072L1.77361 11.9072ZM12.044 22.136H12.0441H12.044C12.0439 22.136 12.0438 22.136 12.044 22.136Z" fill="#2CB4C2"/>
              <path fill-rule="evenodd" clip-rule="evenodd" d="M9.38746 7.47752C9.1883 7.03681 8.97875 7.02799 8.78933 7.02024C8.6343 7.01368 8.457 7.0141 8.2799 7.0141C8.10259 7.0141 7.81461 7.08034 7.57109 7.34515C7.32735 7.60998 6.64062 8.25013 6.64062 9.55207C6.64062 10.8541 7.59329 12.1122 7.72601 12.289C7.85897 12.4654 9.56502 15.2226 12.2667 16.2833C14.5123 17.1648 14.9692 16.9894 15.4566 16.9453C15.944 16.9012 17.0294 16.3053 17.2508 15.6874C17.4723 15.0695 17.4723 14.5399 17.4059 14.4293C17.3395 14.319 17.1622 14.2528 16.8964 14.1205C16.6305 13.9882 15.3236 13.3479 15.08 13.2596C14.8363 13.1714 14.6591 13.1273 14.4817 13.3923C14.3045 13.6569 13.7954 14.2528 13.6403 14.4293C13.4853 14.6061 13.3301 14.6282 13.0643 14.4958C12.7984 14.3631 11.9423 14.0839 10.9266 13.1825C10.1364 12.4811 9.60292 11.6149 9.44778 11.3499C9.29275 11.0853 9.43123 10.942 9.56451 10.81C9.68394 10.6914 9.83042 10.501 9.96338 10.3466C10.096 10.1921 10.1403 10.0818 10.2289 9.90526C10.3176 9.72863 10.2732 9.57409 10.2068 9.44172C10.1403 9.30936 9.62368 8.00072 9.3873 7.47744" fill="white"/>
            </svg>
          </div>
        </a> 
      </div>
    </div>
  </div>
</section>

<?php if (get_field('map_title', 'options')) : ?>
<section class="map contacts-map">
  <div class="container">
    <div class="wrap">
      <b class="title">Адреса</b>
      <div class="item" data-coords="[55.833424, 49.040046]">
        <p>Производство</p>
        <address><?php echo get_field('addr_prod', 'options'); ?></address>
        <span><?php echo get_field('work_time','options'); ?></span>
      </div>
      <div class="item" data-coords="[55.816265, 49.145723]">
        <p>Офис продаж в Казани</p>
        <address><?php echo get_field('addr_office', 'options'); ?></address>
        <span><?php echo get_field('work_time','options'); ?></span>
      </div>
      <div class="item" data-coords="[55.766233, 37.581101]">
        <p>Офис продаж в Москве</p>
        <address><?php echo get_field('addr_office_msk', 'options'); ?></address>
        <span><?php echo get_field('work_time','options'); ?></span>
      </div>
    </div>
  </div>
  <div id="map"></div>
</section>
<?php endif; ?>

<section class="contacts-release">
  <div class="container">
    <div class="wrap">
      <b class="title">Поможем реализовать ваш проект</b>
      <p class="subtitle">
        Оставьте контактные данные и мы свяжемся с вами в ближайшее время и ответим на любые вопросы
      </p>
      <div class="form">
        <?php echo do_shortcode('[contact-form-7 id="f34c36e" title="Поможем реализовать проект"]'); ?>
      </div>
    </div>
  </div>
</section>

<?php if (get_field('req_title', 'options')) : ?>
<section class="req">
  <div class="container">
    <h2 class="title"><?php echo get_field('req_title', 'options') ?></h2>
    <div class="wrap">
      <div class="left">
        <?php if (have_rows('req', 'options')) : while(have_rows('req', 'options')) : the_row(); ?>
          <div class="item">
            <p><?php echo get_sub_field('name'); ?></p>
            <b><?php echo get_sub_field('value'); ?></b>
          </div>
        <?php endwhile; endif; ?>
      </div>
      <div class="right">
        <?php if (get_field('req_team', 'options')) : ?>
        <div class="persons">
          <?php if (have_rows('req_team', 'options')) : while(have_rows('req_team', 'options')) : the_row(); ?>
            <div class="item">
              <span><?php echo get_sub_field('place'); ?></span>
              <b><?php echo get_sub_field('name'); ?></b>
              <?php if (get_sub_field('email')) : ?>
              <a target="blank" href="mailto:<?php echo get_sub_field('email'); ?>"><?php echo get_sub_field('email'); ?></a>
              <?php endif; ?>
            </div>
          <?php endwhile; endif; ?>
        </div>
        <?php endif; ?>
        <?php if (have_rows('req_doc', 'options')) : while(have_rows('req_doc', 'options')) : the_row(); ?>
          <a target="blank" download href="<?php echo get_sub_field('dokument'); ?>" class="doc">
            <div class="icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.25 17.5C8.25 17.0858 8.58579 16.75 9 16.75L15 16.75C15.4142 16.75 15.75 17.0858 15.75 17.5C15.75 17.9142 15.4142 18.25 15 18.25L9 18.25C8.58579 18.25 8.25 17.9142 8.25 17.5Z" fill="#2CB4C2"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.4697 14.0303C11.7626 14.3232 12.2374 14.3232 12.5303 14.0303L16.0303 10.5303C16.3232 10.2374 16.3232 9.76256 16.0303 9.46967C15.7374 9.17678 15.2626 9.17678 14.9697 9.46967L12.75 11.6893V6.5C12.75 6.08579 12.4142 5.75 12 5.75C11.5858 5.75 11.25 6.08579 11.25 6.5V11.6893L9.03033 9.46967C8.73744 9.17678 8.26256 9.17678 7.96967 9.46967C7.67678 9.76256 7.67678 10.2374 7.96967 10.5303L11.4697 14.0303Z" fill="#2CB4C2"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 3.25C6.89137 3.25 2.75 7.39137 2.75 12.5C2.75 17.6086 6.89137 21.75 12 21.75C17.1086 21.75 21.25 17.6086 21.25 12.5C21.25 7.39137 17.1086 3.25 12 3.25ZM1.25 12.5C1.25 6.56294 6.06294 1.75 12 1.75C17.9371 1.75 22.75 6.56294 22.75 12.5C22.75 18.4371 17.9371 23.25 12 23.25C6.06294 23.25 1.25 18.4371 1.25 12.5Z" fill="#2CB4C2"/>
              </svg>
            </div>
            <div class="meta">
              <b><?php echo get_sub_field('imya_dokumenta'); ?></b>
              <span><?php echo get_sub_field('format_i_ves'); ?></span>
            </div>
          </a>
        <?php endwhile; endif; ?>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>

<script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "ContactPage",
    "breadcrumb": {
      "@type": "BreadcrumbList",
      "itemListElement": [{
        "@type": "ListItem",
        "position": 1,
        "item": {
          "@id": "https://neter.pro/",
          "name": "Главная"
        }
      },{
        "@type": "ListItem",
        "position": 2,
        "item": {
          "@id": "https://neter.pro/contacts",
          "name": "Контакты"
        }
      }]
    },
    "lastReviewed": "2024-03-20",
    "mainContentOfPage": {
      "@type": "WebPageElement",
      "description": "Контактная информация и форма обратной связи."
    }
  }
</script>
<!-- Schema org -->
<div itemscope itemtype="http://schema.org/Organization" style="display: none;">
  <span itemprop="name">ООО «Источники питания»</span>
  <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
    <span itemprop="streetAddress">ул. Сибгата Хакима, д. 51, помещ. 1029, офис 2</span>,
    <span itemprop="addressLocality">г. Казань</span>,
    <span itemprop="postalCode">421001</span>
  </div>
  Телефон: <span itemprop="telephone"><?php the_field('phone','options'); ?></span>
</div>
<div itemscope itemtype="http://schema.org/LocalBusiness" style="display: none;">
  <span itemprop="name">ООО «Источники питания»</span>
  <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
    <span itemprop="streetAddress">ул. Сибгата Хакима, д. 51, помещ. 1029, офис 2</span>,
    <span itemprop="addressLocality">г. Казань</span>,
    <span itemprop="postalCode">421001</span>
  </div>
  Телефон: <span itemprop="telephone"><?php the_field('phone','options'); ?></span><br>
  Часы работы: <span itemprop="openingHours">09:00 - 18:00</span><br>
  <span itemprop="description">Аккумуляторы от производителя</span>
</div>
<!-- Schema end -->
<?php
get_footer();
