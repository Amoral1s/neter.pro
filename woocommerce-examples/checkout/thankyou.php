<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.1.0
 *
 * @var WC_Order $order
 */

defined( 'ABSPATH' ) || exit;

?>

<div class="order">
	<div class="wrap">
		<div class="left">
			<b style="display: none" class="page-title sub">Заказ принят</b>
			<script>
				const h1 = document.querySelector('h1');
				if (h1 && window.screen.width < 993) { h1.style.display = 'none'; }
			</script>
			<p class="subtitle">Мы свяжемся с вами для подтверждения заказа</p>
			<a href="/" class="btn">
				<span>На главную страницу</span>
			</a>
		</div>
		<div class="right">
			<img class="line-mob" src="<?php echo get_template_directory_uri(); ?>/img/line-order-mob.svg" alt="icon">
			<img class="man" src="<?php echo get_template_directory_uri(); ?>/img/recived.png" alt="Спасибо за покупку">
		</div>
	</div>
	<img class="line" style="display: none" src="<?php echo get_template_directory_uri(); ?>/img/line-order.svg" alt="icon">
</div>

<?php if (get_field('map_title', 'options')) : ?>
<section class="map order-map">
  <?php if (get_field('map', 'options')) : ?>
  <div class="map-wrap">
    <iframe data-city="map" src="<?php echo get_field('map_msk', 'options'); ?>" frameborder="0"></iframe>
  </div>
  <?php endif; ?>
  <div class="wrap">
    <h2 class="title"><?php echo get_field('map_title', 'options') ?></h2>
    <div class="top">
      <div class="icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
          <path d="M3.77762 11.9424C2.8296 10.2893 2.37185 8.93948 2.09584 7.57121C1.68762 5.54758 2.62181 3.57081 4.16938 2.30947C4.82345 1.77638 5.57323 1.95852 5.96 2.6524L6.83318 4.21891C7.52529 5.46057 7.87134 6.08139 7.8027 6.73959C7.73407 7.39779 7.26737 7.93386 6.33397 9.00601L3.77762 11.9424ZM3.77762 11.9424C5.69651 15.2883 8.70784 18.3013 12.0576 20.2224M12.0576 20.2224C13.7107 21.1704 15.0605 21.6282 16.4288 21.9042C18.4524 22.3124 20.4292 21.3782 21.6905 19.8306C22.2236 19.1766 22.0415 18.4268 21.3476 18.04L19.7811 17.1668C18.5394 16.4747 17.9186 16.1287 17.2604 16.1973C16.6022 16.2659 16.0661 16.7326 14.994 17.666L12.0576 20.2224Z" stroke="#24B642" stroke-width="1.5" stroke-linejoin="round"/>
          <path d="M14 6.83185C15.4232 7.43624 16.5638 8.57677 17.1682 10M14.654 2C18.1912 3.02076 20.9791 5.80852 22 9.34563" stroke="#24B642" stroke-width="1.5" stroke-linecap="round"/>
        </svg>
      </div>
      <div class="meta">
        <a class="phone" target="blank" href="tel:<?php the_field('phone', 'options'); ?>"><?php the_field('phone', 'options'); ?></a>
        <span>Единый номер по России</span>
      </div>
    </div>
    <div class="wrap-inner">
      <?php $i = 1; if (have_rows('filialy','options')) : while(have_rows('filialy','options')) : the_row(); ?>
        <div class="item" data-src="<?php echo get_sub_field('map'); ?>">
          <div class="item-top <?php if ($i == 1) { echo 'active'; } ?>">
            <b><?php echo get_sub_field('nazvanie'); ?></b>
            <div class="icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M6 9L11.2929 14.2929C11.6262 14.6262 11.7929 14.7929 12 14.7929C12.2071 14.7929 12.3738 14.6262 12.7071 14.2929L18 9" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </div>
          </div>
          <div class="item-bot" <?php if ($i == 1) { echo 'style="display: block;"'; } ?>>
            <p><?php echo get_sub_field('adres'); ?></p>
            <a target="blank" href="tel:<?php echo get_sub_field('telefon'); ?>"><?php echo get_sub_field('telefon'); ?></a>
            <time><?php echo get_sub_field('vremya_raboty'); ?></time>
            <?php if (get_sub_field('marshrut')) : ?>
            <a target="blank" href="<?php echo get_sub_field('marshrut'); ?>" class="travel">
              <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="23" height="24" viewBox="0 0 23 24" fill="none">
                  <path d="M11.5 1.5C6.73641 1.5 2.875 5.5293 2.875 10.5C2.875 12.9845 3.83971 15.234 5.39997 16.8626C6.96066 18.492 10.6375 20.85 10.8531 23.325C10.8855 23.6961 11.1429 24 11.5 24C11.8571 24 12.1145 23.6961 12.1469 23.325C12.3625 20.85 16.0393 18.492 17.6 16.8626C19.1603 15.234 20.125 12.9845 20.125 10.5C20.125 5.5293 16.2636 1.5 11.5 1.5Z" fill="#FF4433"/>
                  <path d="M11.5 13.6506C13.1672 13.6506 14.5187 12.2403 14.5187 10.5006C14.5187 8.76089 13.1672 7.35059 11.5 7.35059C9.83283 7.35059 8.48128 8.76089 8.48128 10.5006C8.48128 12.2403 9.83283 13.6506 11.5 13.6506Z" fill="white"/>
                </svg>
              </div>
              <span>Построить маршрут</span>
            </a>
            <?php endif; ?>
          </div>
        </div>
      <?php $i++; endwhile; endif; ?>
    </div>
  </div>
</section>
<?php endif; ?>