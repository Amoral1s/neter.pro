<?php 

function register_blocks() {
 
    // Проверяем, что функция доступна.
    if( function_exists( 'acf_register_block_type' ) ) {
 
        // Регистрируем блок 
        acf_register_block_type(array(
            'name'              => 'important_text',
            'title'             => __('Важный текст (NEW)'),
            'description'       => __('Важный текст для статьи (NEW)'),
            'render_template'   => '/blocks/important_text.php',
            'category'          => 'formatting',
        ));

        acf_register_block_type(array(
            'name'              => 'products_ids',
            'title'             => __('Товары (NEW)'),
            'description'       => __('Товары (NEW)'),
            'render_template'   => '/blocks/products.php',
            'category'          => 'formatting',
        ));

        acf_register_block_type(array(
            'name'              => 'citata',
            'title'             => __('Цитата (NEW)'),
            'description'       => __('Цитата (NEW)'),
            'render_template'   => '/blocks/citata.php',
            'category'          => 'formatting',
        ));
        acf_register_block_type(array(
            'name'              => 'consultation',
            'title'             => __('Консультация (Баннер) (NEW)'),
            'description'       => __('Консультация (Баннер) (NEW)'),
            'render_template'   => '/blocks/consultation.php',
            'category'          => 'formatting',
        ));
        acf_register_block_type(array(
            'name'              => 'category',
            'title'             => __('Категории (NEW)'),
            'description'       => __('Категории (NEW)'),
            'render_template'   => '/blocks/category.php',
            'category'          => 'formatting',
        ));
        acf_register_block_type(array(
            'name'              => 'service',
            'title'             => __('Услуги (NEW)'),
            'description'       => __('Услуги (NEW)'),
            'render_template'   => '/blocks/service.php',
            'category'          => 'formatting',
        ));
        acf_register_block_type(array(
            'name'              => 'garanty',
            'title'             => __('Баннер сервиса (NEW)'),
            'description'       => __('Баннер сервиса (NEW)'),
            'render_template'   => '/blocks/garanty.php',
            'category'          => 'formatting',
        ));
    }
}
add_action('acf/init', 'register_blocks');