<?php
	if ( post_password_required() ) {
		return;
	}
?>

<div id="comments" class="comments-area">
	<?php

	 // You can start editing here -- including this comment!
	if ( have_comments() ) :
		?>
		<b class="title">Комментарии к статье</b>
		<?php the_comments_navigation(); ?>
		<ul>
			<?php
				wp_list_comments([
					'style'      => 'ul',
					'short_ping' => true,
					'callback'   => 'custom_wp_comments',
					'max_depth'  => 2,
				]);
			?>
		</ul>
		<?php
			the_comments_navigation();

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) :
			?>
			<p class="no-comments"><?php esc_html_e( 'Комментарии закрыты.', 'main-theme' ); ?></p>
			<?php
		endif;


	endif; // Check for have_comments().

	comment_form([
		'class_form'           => 'form', // Классы для формы
		'class_submit'         => 'button half', // Классы для кнопки отправки
		'title_reply'          => 'Написать комментарий', // Заголовок формы
		'title_reply_before'   => '<b class="mini-title">', // Обертка до заголовка
		'title_reply_after'    => '</b><div class="reply-to-wrap"></div>', // Обертка после заголовка
		'comment_notes_before' => '', // Убираем "Ваш email не будет опубликован"
		'comment_notes_after'  => '',
		'label_submit'         => 'Отправить',

		'fields' => [
				'author' => '
						<div class="input half">
								<p>Ваше имя</p>
								<input id="author" name="author" type="text" placeholder="Ваше имя" required />
						</div>',
				'email' => '
						<div class="input half">
								<p>Email</p>
								<input id="email" name="email" type="email" placeholder="Email" required />
						</div>',
				'url' => '', // Убираем поле "Сайт"
				
		],

		'comment_field' => '
				<div class="input full">
						<p>Ваш комментарий</p>
						<textarea id="comment" name="comment" class="textarea" placeholder="Ваш комментарий" required></textarea>
				</div>',

	]);
?>
</div>
