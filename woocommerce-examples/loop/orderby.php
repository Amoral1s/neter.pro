<?php
/**
 * Show options for ordering
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/orderby.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


?>
<div class="mobi-sort">
	<div class="mobi-sort-left">
		<?php echo do_shortcode('[wpf-filters id=3]'); ?>
	</div>
	<div class="mobi-sort-right">
		<div class="icon">
			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
				<path d="M3 7H6" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
				<path d="M3 17H9" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
				<path d="M18 17H21" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
				<path d="M15 7H21" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
				<path d="M6 7C6 6.06812 6 5.60218 6.15224 5.23463C6.35523 4.74458 6.74458 4.35523 7.23463 4.15224C7.60218 4 8.06812 4 9 4C9.93188 4 10.3978 4 10.7654 4.15224C11.2554 4.35523 11.6448 4.74458 11.8478 5.23463C12 5.60218 12 6.06812 12 7C12 7.93188 12 8.39782 11.8478 8.76537C11.6448 9.25542 11.2554 9.64477 10.7654 9.84776C10.3978 10 9.93188 10 9 10C8.06812 10 7.60218 10 7.23463 9.84776C6.74458 9.64477 6.35523 9.25542 6.15224 8.76537C6 8.39782 6 7.93188 6 7Z" stroke="white" stroke-width="1.5"/>
				<path d="M12 17C12 16.0681 12 15.6022 12.1522 15.2346C12.3552 14.7446 12.7446 14.3552 13.2346 14.1522C13.6022 14 14.0681 14 15 14C15.9319 14 16.3978 14 16.7654 14.1522C17.2554 14.3552 17.6448 14.7446 17.8478 15.2346C18 15.6022 18 16.0681 18 17C18 17.9319 18 18.3978 17.8478 18.7654C17.6448 19.2554 17.2554 19.6448 16.7654 19.8478C16.3978 20 15.9319 20 15 20C14.0681 20 13.6022 20 13.2346 19.8478C12.7446 19.6448 12.3552 19.2554 12.1522 18.7654C12 18.3978 12 17.9319 12 17Z" stroke="white" stroke-width="1.5"/>
			</svg>
		</div>
		<span>Фильтры</span>
	</div>
</div>
<div class="catalog-sort">
	<?php echo do_shortcode('[wpf-filters id=2]'); ?>

	<?php 
		$current_view = get_transient('product_view') ? get_transient('product_view') : 'grid'; // Загружаем сохраненный вид или устанавливаем по умолчанию
	?>
	<!-- Добавьте этот HTML для переключателя вида -->
	<div class="view-switcher">
			<button data-view="grid" <?php echo ($current_view === 'grid') ? 'class="active"' : ''; ?>>
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
					<path d="M2 18C2 16.4596 2 15.6893 2.34673 15.1235C2.54074 14.8069 2.80693 14.5407 3.12353 14.3467C3.68934 14 4.45956 14 6 14C7.54044 14 8.31066 14 8.87647 14.3467C9.19307 14.5407 9.45926 14.8069 9.65327 15.1235C10 15.6893 10 16.4596 10 18C10 19.5404 10 20.3107 9.65327 20.8765C9.45926 21.1931 9.19307 21.4593 8.87647 21.6533C8.31066 22 7.54044 22 6 22C4.45956 22 3.68934 22 3.12353 21.6533C2.80693 21.4593 2.54074 21.1931 2.34673 20.8765C2 20.3107 2 19.5404 2 18Z" stroke="#24B642" stroke-width="1.5"/>
					<path d="M14 18C14 16.4596 14 15.6893 14.3467 15.1235C14.5407 14.8069 14.8069 14.5407 15.1235 14.3467C15.6893 14 16.4596 14 18 14C19.5404 14 20.3107 14 20.8765 14.3467C21.1931 14.5407 21.4593 14.8069 21.6533 15.1235C22 15.6893 22 16.4596 22 18C22 19.5404 22 20.3107 21.6533 20.8765C21.4593 21.1931 21.1931 21.4593 20.8765 21.6533C20.3107 22 19.5404 22 18 22C16.4596 22 15.6893 22 15.1235 21.6533C14.8069 21.4593 14.5407 21.1931 14.3467 20.8765C14 20.3107 14 19.5404 14 18Z" stroke="#24B642" stroke-width="1.5"/>
					<path d="M2 6C2 4.45956 2 3.68934 2.34673 3.12353C2.54074 2.80693 2.80693 2.54074 3.12353 2.34673C3.68934 2 4.45956 2 6 2C7.54044 2 8.31066 2 8.87647 2.34673C9.19307 2.54074 9.45926 2.80693 9.65327 3.12353C10 3.68934 10 4.45956 10 6C10 7.54044 10 8.31066 9.65327 8.87647C9.45926 9.19307 9.19307 9.45926 8.87647 9.65327C8.31066 10 7.54044 10 6 10C4.45956 10 3.68934 10 3.12353 9.65327C2.80693 9.45926 2.54074 9.19307 2.34673 8.87647C2 8.31066 2 7.54044 2 6Z" stroke="#24B642" stroke-width="1.5"/>
					<path d="M14 6C14 4.45956 14 3.68934 14.3467 3.12353C14.5407 2.80693 14.8069 2.54074 15.1235 2.34673C15.6893 2 16.4596 2 18 2C19.5404 2 20.3107 2 20.8765 2.34673C21.1931 2.54074 21.4593 2.80693 21.6533 3.12353C22 3.68934 22 4.45956 22 6C22 7.54044 22 8.31066 21.6533 8.87647C21.4593 9.19307 21.1931 9.45926 20.8765 9.65327C20.3107 10 19.5404 10 18 10C16.4596 10 15.6893 10 15.1235 9.65327C14.8069 9.45926 14.5407 9.19307 14.3467 8.87647C14 8.31066 14 7.54044 14 6Z" stroke="#24B642" stroke-width="1.5"/>
				</svg>
			</button>
			<button data-view="list" <?php echo ($current_view === 'list') ? 'class="active"' : ''; ?>>
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
					<path d="M21.5 17.5C21.5 18.9045 21.5 19.6067 21.0997 20.1111C20.9265 20.3295 20.7038 20.517 20.4444 20.6629C19.8454 21 19.0115 21 17.3438 21H6.65625C4.98845 21 4.15455 21 3.55552 20.6629C3.29619 20.517 3.07354 20.3295 2.90026 20.1111C2.5 19.6067 2.5 18.9045 2.5 17.5C2.5 16.0955 2.5 15.3933 2.90026 14.8889C3.07354 14.6705 3.29619 14.483 3.55552 14.3371C4.15455 14 4.98845 14 6.65625 14H17.3438C19.0115 14 19.8454 14 20.4444 14.3371C20.7038 14.483 20.9265 14.6705 21.0997 14.8889C21.5 15.3933 21.5 16.0955 21.5 17.5Z" stroke="#9CA3AF" stroke-width="1.5"/>
					<path d="M21.5 6.5C21.5 7.9045 21.5 8.6067 21.0997 9.1111C20.9265 9.3295 20.7038 9.517 20.4444 9.6629C19.8454 10 19.0115 10 17.3438 10H6.65625C4.98845 10 4.15455 10 3.55552 9.6629C3.29619 9.517 3.07354 9.3295 2.90026 9.1111C2.5 8.6067 2.5 7.9045 2.5 6.5C2.5 5.0955 2.5 4.3933 2.90026 3.8889C3.07354 3.6705 3.29619 3.483 3.55552 3.3371C4.15455 3 4.98845 3 6.65625 3H17.3438C19.0115 3 19.8454 3 20.4444 3.3371C20.7038 3.483 20.9265 3.6705 21.0997 3.8889C21.5 4.3933 21.5 5.0955 21.5 6.5Z" stroke="#9CA3AF" stroke-width="1.5"/>
				</svg>
			</button>
			<button data-view="carousel" <?php echo ($current_view === 'carousel') ? 'class="active"' : ''; ?>>
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
					<path d="M20.1068 20.1088C18.7156 21.5 16.4764 21.5 11.998 21.5C7.5197 21.5 5.28053 21.5 3.88929 20.1088C2.49805 18.7175 2.49805 16.4783 2.49805 12C2.49805 7.52166 2.49805 5.28249 3.88929 3.89124C5.28053 2.5 7.5197 2.5 11.998 2.5C16.4764 2.5 18.7156 2.5 20.1068 3.89124C21.498 5.28249 21.498 7.52166 21.498 12C21.498 16.4783 21.498 18.7175 20.1068 20.1088Z" stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M8.99805 21.5V2.5" stroke="#9CA3AF" stroke-width="1.5"/>
					<path d="M21.498 8H2.49805" stroke="#9CA3AF" stroke-width="1.5"/>
					<path d="M21.498 16H2.49805" stroke="#9CA3AF" stroke-width="1.5"/>
				</svg>
			</button>
	</div>
</div>
<script>
	document.addEventListener('DOMContentLoaded', () => {
		const pcSort = document.querySelector('.catalog-sort');
		if (window.screen.width < 993) {
			pcSort.remove();
		}
	});
</script>
