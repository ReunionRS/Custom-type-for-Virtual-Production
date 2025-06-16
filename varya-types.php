<?php
/**
 * Plugin Name: Virtual Production Type Varya LLC
 * Plugin URI: https://github.com/ReunionRS/Custom-type-for-Virtual-Production
 * Description: Кастомные типы записей для портала Vprussia
 * Version: 1.0.1
 * Author: Ilya Smirnov
 * Author URI: https://www.youtube.com/@IlyaSmirnov-z4n
 * Text Domain: vp-types
 */

if (!defined('ABSPATH')) {
    exit;
}

class VP_Types {
    
    public function __construct() {
        add_action('init', array($this, 'register_post_types'));
        add_action('init', array($this, 'register_taxonomies'));
        add_action('cmb2_admin_init', array($this, 'register_metaboxes'));
        add_action('admin_init', array($this, 'check_dependencies'));
        add_action('cmb2_admin_init', array($this, 'register_relationships'));
    }
    
    public function check_dependencies() {
        if (!class_exists('CMB2')) {
            add_action('admin_notices', function() {
                ?>
                <div class="notice notice-error">
                    <p><?php _e('VP Types требует установки и активации плагина CMB2.', 'vp-types'); ?></p>
                </div>
                <?php
            });
        }
        
        if (!class_exists('WooCommerce')) {
            add_action('admin_notices', function() {
                ?>
                <div class="notice notice-warning">
                    <p><?php _e('Для полной функциональности VP Types (товары и услуги) требуется WooCommerce.', 'vp-types'); ?></p>
                </div>
                <?php
            });
        }
    }

    public function register_post_types() {
        register_post_type('vp_venue', array(
            'labels' => array(
                'name'               => __('Площадки', 'vp-types'),
                'singular_name'      => __('Площадка', 'vp-types'),
                'add_new'            => __('Добавить площадку', 'vp-types'),
                'add_new_item'       => __('Добавить новую площадку', 'vp-types'),
                'edit_item'          => __('Редактировать площадку', 'vp-types'),
                'new_item'           => __('Новая площадка', 'vp-types'),
                'view_item'          => __('Просмотр площадки', 'vp-types'),
                'search_items'       => __('Поиск площадок', 'vp-types'),
                'not_found'          => __('Площадки не найдены', 'vp-types'),
                'not_found_in_trash' => __('В корзине не найдено площадок', 'vp-types'),
                'menu_name'          => __('Площадки', 'vp-types'),
            ),
            'public'              => true,
            'publicly_queryable'  => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_icon'           => 'dashicons-building',
            'query_var'           => true,
            'rewrite'             => array('slug' => 'vp-venue'),
            'capability_type'     => 'post',
            'has_archive'         => true,
            'hierarchical'        => false,
            'menu_position'       => 5,
            'supports'            => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
            'show_in_rest'        => true,
        ));
        
        register_post_type('vp_production', array(
            'labels' => array(
                'name'               => __('Продакшены', 'vp-types'),
                'singular_name'      => __('Продакшен', 'vp-types'),
                'add_new'            => __('Добавить продакшен', 'vp-types'),
                'add_new_item'       => __('Добавить новый продакшен', 'vp-types'),
                'edit_item'          => __('Редактировать продакшен', 'vp-types'),
                'new_item'           => __('Новый продакшен', 'vp-types'),
                'view_item'          => __('Просмотр продакшена', 'vp-types'),
                'search_items'       => __('Поиск продакшенов', 'vp-types'),
                'not_found'          => __('Продакшены не найдены', 'vp-types'),
                'not_found_in_trash' => __('В корзине не найдено продакшенов', 'vp-types'),
                'menu_name'          => __('Продакшены', 'vp-types'),
            ),
            'public'              => true,
            'publicly_queryable'  => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_icon'           => 'dashicons-video-alt3',
            'query_var'           => true,
            'rewrite'             => array('slug' => 'vp-production'),
            'capability_type'     => 'post',
            'has_archive'         => true,
            'hierarchical'        => false,
            'menu_position'       => 6,
            'supports'            => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
            'show_in_rest'        => true,
        ));
        
        register_post_type('vp_manufacturer', array(
            'labels' => array(
                'name'               => __('Производители', 'vp-types'),
                'singular_name'      => __('Производитель', 'vp-types'),
                'add_new'            => __('Добавить производителя', 'vp-types'),
                'add_new_item'       => __('Добавить нового производителя', 'vp-types'),
                'edit_item'          => __('Редактировать производителя', 'vp-types'),
                'new_item'           => __('Новый производитель', 'vp-types'),
                'view_item'          => __('Просмотр производителя', 'vp-types'),
                'search_items'       => __('Поиск производителей', 'vp-types'),
                'not_found'          => __('Производители не найдены', 'vp-types'),
                'not_found_in_trash' => __('В корзине не найдено производителей', 'vp-types'),
                'menu_name'          => __('Производители', 'vp-types'),
            ),
            'public'              => true,
            'publicly_queryable'  => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_icon'           => 'dashicons-hammer',
            'query_var'           => true,
            'rewrite'             => array('slug' => 'vp-manufacturer'),
            'capability_type'     => 'post',
            'has_archive'         => true,
            'hierarchical'        => false,
            'menu_position'       => 7,
            'supports'            => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
            'show_in_rest'        => true,
        ));
        
        register_post_type('vp_rental', array(
            'labels' => array(
                'name'               => __('Ренталы', 'vp-types'),
                'singular_name'      => __('Рентал', 'vp-types'),
                'add_new'            => __('Добавить рентал', 'vp-types'),
                'add_new_item'       => __('Добавить новый рентал', 'vp-types'),
                'edit_item'          => __('Редактировать рентал', 'vp-types'),
                'new_item'           => __('Новый рентал', 'vp-types'),
                'view_item'          => __('Просмотр рентала', 'vp-types'),
                'search_items'       => __('Поиск ренталов', 'vp-types'),
                'not_found'          => __('Ренталы не найдены', 'vp-types'),
                'not_found_in_trash' => __('В корзине не найдено ренталов', 'vp-types'),
                'menu_name'          => __('Ренталы', 'vp-types'),
            ),
            'public'              => true,
            'publicly_queryable'  => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_icon'           => 'dashicons-cart',
            'query_var'           => true,
            'rewrite'             => array('slug' => 'vp-rental'),
            'capability_type'     => 'post',
            'has_archive'         => true,
            'hierarchical'        => false,
            'menu_position'       => 8,
            'supports'            => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
            'show_in_rest'        => true,
        ));
        
        register_post_type('vp_specialist', array(
            'labels' => array(
                'name'               => __('Специалисты', 'vp-types'),
                'singular_name'      => __('Специалист', 'vp-types'),
                'add_new'            => __('Добавить специалиста', 'vp-types'),
                'add_new_item'       => __('Добавить нового специалиста', 'vp-types'),
                'edit_item'          => __('Редактировать специалиста', 'vp-types'),
                'new_item'           => __('Новый специалист', 'vp-types'),
                'view_item'          => __('Просмотр специалиста', 'vp-types'),
                'search_items'       => __('Поиск специалистов', 'vp-types'),
                'not_found'          => __('Специалисты не найдены', 'vp-types'),
                'not_found_in_trash' => __('В корзине не найдено специалистов', 'vp-types'),
                'menu_name'          => __('Специалисты', 'vp-types'),
            ),
            'public'              => true,
            'publicly_queryable'  => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_icon'           => 'dashicons-businessman',
            'query_var'           => true,
            'rewrite'             => array('slug' => 'vp-specialist'),
            'capability_type'     => 'post',
            'has_archive'         => true,
            'hierarchical'        => false,
            'menu_position'       => 9,
            'supports'            => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
            'show_in_rest'        => true,
        ));
        
        if (class_exists('WooCommerce')) {
            register_taxonomy('vp_equipment_type', array('product'), array(
                'hierarchical'      => true,
                'labels'            => array(
                    'name'              => __('Типы оборудования VP', 'vp-types'),
                    'singular_name'     => __('Тип оборудования VP', 'vp-types'),
                    'search_items'      => __('Поиск типов оборудования', 'vp-types'),
                    'all_items'         => __('Все типы оборудования', 'vp-types'),
                    'parent_item'       => __('Родительский тип оборудования', 'vp-types'),
                    'parent_item_colon' => __('Родительский тип оборудования:', 'vp-types'),
                    'edit_item'         => __('Редактировать тип оборудования', 'vp-types'),
                    'update_item'       => __('Обновить тип оборудования', 'vp-types'),
                    'add_new_item'      => __('Добавить новый тип оборудования', 'vp-types'),
                    'new_item_name'     => __('Новый тип оборудования', 'vp-types'),
                    'menu_name'         => __('Типы оборудования VP', 'vp-types'),
                ),
                'show_ui'           => true,
                'show_admin_column' => true,
                'query_var'         => true,
                'rewrite'           => array('slug' => 'vp-equipment-type'),
                'show_in_rest'      => true,
            ));
            
            register_taxonomy('vp_service_type', array('product'), array(
                'hierarchical'      => true,
                'labels'            => array(
                    'name'              => __('Типы услуг VP', 'vp-types'),
                    'singular_name'     => __('Тип услуги VP', 'vp-types'),
                    'search_items'      => __('Поиск типов услуг', 'vp-types'),
                    'all_items'         => __('Все типы услуг', 'vp-types'),
                    'parent_item'       => __('Родительский тип услуги', 'vp-types'),
                    'parent_item_colon' => __('Родительский тип услуги:', 'vp-types'),
                    'edit_item'         => __('Редактировать тип услуги', 'vp-types'),
                    'update_item'       => __('Обновить тип услуги', 'vp-types'),
                    'add_new_item'      => __('Добавить новый тип услуги', 'vp-types'),
                    'new_item_name'     => __('Новый тип услуги', 'vp-types'),
                    'menu_name'         => __('Типы услуг VP', 'vp-types'),
                ),
                'show_ui'           => true,
                'show_admin_column' => true,
                'query_var'         => true,
                'rewrite'           => array('slug' => 'vp-service-type'),
                'show_in_rest'      => true,
            ));
            
            add_filter('product_type_selector', function($types) {
                $types['vp_equipment'] = __('VP оборудование', 'vp-types');
                $types['vp_service'] = __('VP услуга', 'vp-types');
                return $types;
            });
        }
    }

    public function register_taxonomies() {
        register_taxonomy('vp_project_type', array('vp_production'), array(
            'hierarchical'      => true,
            'labels'            => array(
                'name'              => __('Типы проектов', 'vp-types'),
                'singular_name'     => __('Тип проекта', 'vp-types'),
                'search_items'      => __('Поиск типов проектов', 'vp-types'),
                'all_items'         => __('Все типы проектов', 'vp-types'),
                'parent_item'       => __('Родительский тип проекта', 'vp-types'),
                'parent_item_colon' => __('Родительский тип проекта:', 'vp-types'),
                'edit_item'         => __('Редактировать тип проекта', 'vp-types'),
                'update_item'       => __('Обновить тип проекта', 'vp-types'),
                'add_new_item'      => __('Добавить новый тип проекта', 'vp-types'),
                'new_item_name'     => __('Новый тип проекта', 'vp-types'),
                'menu_name'         => __('Типы проектов', 'vp-types'),
            ),
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'vp-project-type'),
            'show_in_rest'      => true,
        ));
        
        register_taxonomy('vp_competency', array('vp_production', 'vp_specialist'), array(
            'hierarchical'      => true,
            'labels'            => array(
                'name'              => __('Компетенции', 'vp-types'),
                'singular_name'     => __('Компетенция', 'vp-types'),
                'search_items'      => __('Поиск компетенций', 'vp-types'),
                'all_items'         => __('Все компетенции', 'vp-types'),
                'parent_item'       => __('Родительская компетенция', 'vp-types'),
                'parent_item_colon' => __('Родительская компетенция:', 'vp-types'),
                'edit_item'         => __('Редактировать компетенцию', 'vp-types'),
                'update_item'       => __('Обновить компетенцию', 'vp-types'),
                'add_new_item'      => __('Добавить новую компетенцию', 'vp-types'),
                'new_item_name'     => __('Новая компетенция', 'vp-types'),
                'menu_name'         => __('Компетенции', 'vp-types'),
            ),
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'vp-competency'),
            'show_in_rest'      => true,
        ));
        
        register_taxonomy('vp_company_type', array('vp_venue', 'vp_production', 'vp_manufacturer', 'vp_rental'), array(
            'hierarchical'      => true,
            'labels'            => array(
                'name'              => __('Категории компаний', 'vp-types'),
                'singular_name'     => __('Категория компании', 'vp-types'),
                'search_items'      => __('Поиск категорий компаний', 'vp-types'),
                'all_items'         => __('Все категории компаний', 'vp-types'),
                'parent_item'       => __('Родительская категория компании', 'vp-types'),
                'parent_item_colon' => __('Родительская категория компании:', 'vp-types'),
                'edit_item'         => __('Редактировать категорию компании', 'vp-types'),
                'update_item'       => __('Обновить категорию компании', 'vp-types'),
                'add_new_item'      => __('Добавить новую категорию компании', 'vp-types'),
                'new_item_name'     => __('Новая категория компании', 'vp-types'),
                'menu_name'         => __('Категории компаний', 'vp-types'),
            ),
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'vp-company-type'),
            'show_in_rest'      => true,
        ));
    }

    public function register_metaboxes() {
        if (!class_exists('CMB2')) {
            return;
        }
        
        $venue_metabox = new_cmb2_box(array(
            'id'            => 'vp_venue_metabox',
            'title'         => __('Характеристики площадки', 'vp-types'),
            'object_types'  => array('vp_venue'),
            'context'       => 'normal',
            'priority'      => 'high',
            'show_names'    => true,
        ));
        
        $venue_metabox->add_field(array(
            'name'    => __('Город', 'vp-types'),
            'id'      => 'vp_venue_city',
            'type'    => 'text',
            'default' => 'Москва',
        ));
        
        $venue_metabox->add_field(array(
            'name'    => __('Адрес', 'vp-types'),
            'id'      => 'vp_venue_address',
            'type'    => 'text',
            'desc'    => __('Полный адрес площадки', 'vp-types'),
        ));
        
        $venue_metabox->add_field(array(
            'name'    => __('Размер площадки (м²)', 'vp-types'),
            'id'      => 'vp_venue_size',
            'type'    => 'text',
            'desc'    => __('Площадь помещения в квадратных метрах', 'vp-types'),
        ));
        
        $venue_metabox->add_field(array(
            'name'    => __('Рабочие дни', 'vp-types'),
            'id'      => 'vp_venue_working_days',
            'type'    => 'multicheck',
            'options' => array(
                'monday'    => __('Понедельник', 'vp-types'),
                'tuesday'   => __('Вторник', 'vp-types'),
                'wednesday' => __('Среда', 'vp-types'),
                'thursday'  => __('Четверг', 'vp-types'),
                'friday'    => __('Пятница', 'vp-types'),
                'saturday'  => __('Суббота', 'vp-types'),
                'sunday'    => __('Воскресенье', 'vp-types'),
            ),
            'default' => array('monday', 'tuesday', 'wednesday', 'thursday', 'friday'),
        ));

        $chromakey_group = $venue_metabox->add_field(array(
            'id'          => 'vp_venue_chromakey',
            'type'        => 'group',
            'description' => __('Хромакей оснащение', 'vp-types'),
            'options'     => array(
                'group_title'   => __('Хромакей {#}', 'vp-types'),
                'add_button'    => __('Добавить хромакей', 'vp-types'),
                'remove_button' => __('Удалить', 'vp-types'),
                'sortable'      => true,
            ),
        ));
        
        $venue_metabox->add_group_field($chromakey_group, array(
            'name'    => __('Конструкция', 'vp-types'),
            'id'      => 'construction',
            'type'    => 'select',
            'options' => array(
                ''          => __('-- Не указана --', 'vp-types'),
                'cyclorama' => __('Циклорама', 'vp-types'),
                'cloth'     => __('Полотно', 'vp-types'),
            ),
        ));
        
        $venue_metabox->add_group_field($chromakey_group, array(
            'name'    => __('Высота (м)', 'vp-types'),
            'id'      => 'height',
            'type'    => 'text_small',
        ));
        
        $venue_metabox->add_group_field($chromakey_group, array(
            'name'    => __('Ширина (м)', 'vp-types'),
            'id'      => 'width',
            'type'    => 'text_small',
        ));
        
        $venue_metabox->add_group_field($chromakey_group, array(
            'name'    => __('Глубина (м)', 'vp-types'),
            'id'      => 'depth',
            'type'    => 'text_small',
        ));
        
        $venue_metabox->add_group_field($chromakey_group, array(
            'name'    => __('Цвет', 'vp-types'),
            'id'      => 'color',
            'type'    => 'select',
            'options' => array(
                ''      => __('-- Не указан --', 'vp-types'),
                'green' => __('Зеленый', 'vp-types'),
                'blue'  => __('Синий', 'vp-types'),
            ),
        ));
        
        $videowall_group = $venue_metabox->add_field(array(
            'id'          => 'vp_venue_videowall',
            'type'        => 'group',
            'description' => __('Видеостена', 'vp-types'),
            'options'     => array(
                'group_title'   => __('Видеостена {#}', 'vp-types'),
                'add_button'    => __('Добавить видеостену', 'vp-types'),
                'remove_button' => __('Удалить', 'vp-types'),
                'sortable'      => true,
            ),
        ));
        
        $venue_metabox->add_group_field($videowall_group, array(
    'name'    => __('Шаг пикселя', 'vp-types'),
    'id'      => 'pixel_pitch',
    'type'    => 'select',
    'options' => array(
        ''      => __('-- Не указан --', 'vp-types'),
        '0.6'   => '0.6',
        '0.7'   => '0.7', 
        '0.8'   => '0.8',
        '0.9'   => '0.9',
        '1.0'   => '1.0',
        '1.2'   => '1.2',
        '1.25'  => '1.25',
        '1.4'   => '1.4',
        '1.5'   => '1.5',
        '1.56'  => '1.56',
        '1.6'   => '1.6',
        '1.8'   => '1.8',
        '1.9'   => '1.9',
        '2.0'   => '2.0',
        '2.3'   => '2.3', 
        '2.5'   => '2.5',
        '2.6'   => '2.6',
        '2.9'   => '2.9',
        '3.0'   => '3.0',
        '3.7'   => '3.7', 
        '3.9'   => '3.9',
        '4.0'   => '4.0',
        '4.8'   => '4.8',
        '5.0'   => '5.0',
        '6.0'   => '6.0',
        '6.25'  => '6.25',
        '8.0'   => '8.0',
        '10.0'  => '10.0',
    ),
));
        
        $venue_metabox->add_group_field($videowall_group, array(
            'name'    => __('Площадь (м²)', 'vp-types'),
            'id'      => 'area',
            'type'    => 'text_small',
        ));
        
        $venue_metabox->add_group_field($videowall_group, array(
            'name'    => __('Процессор марка', 'vp-types'),
            'id'      => 'processor_brand',
            'type'    => 'text',
        ));

        $venue_metabox->add_group_field($videowall_group, array(
            'name'    => __('Возможность индивидуальной конфигурации видеостены', 'vp-types'),
            'id'      => 'custom_configuration',
            'type'    => 'checkbox',
            'desc'    => __('Отметьте, если возможна индивидуальная конфигурация', 'vp-types'),
        ));
        
        $venue_metabox->add_field(array(
            'name'    => __('Интеграция DMX', 'vp-types'),
            'id'      => 'vp_venue_dmx_integration',
            'type'    => 'checkbox',
            'desc'    => __('Отметьте, если есть интеграция DMX', 'vp-types'),
        ));
        
        $cameras_group = $venue_metabox->add_field(array(
            'id'          => 'vp_venue_cameras',
            'type'        => 'group',
            'description' => __('Видеокамеры с GenLock', 'vp-types'),
            'options'     => array(
                'group_title'   => __('Камера {#}', 'vp-types'),
                'add_button'    => __('Добавить камеру', 'vp-types'),
                'remove_button' => __('Удалить', 'vp-types'),
                'sortable'      => true,
            ),
        ));
        
        $venue_metabox->add_group_field($cameras_group, array(
            'name'    => __('Модель', 'vp-types'),
            'id'      => 'model',
            'type'    => 'text',
        ));
        
        $venue_metabox->add_group_field($cameras_group, array(
            'name'    => __('Количество', 'vp-types'),
            'id'      => 'count',
            'type'    => 'text_small',
        ));
        
        $equipment_group = $venue_metabox->add_field(array(
            'id'          => 'vp_venue_equipment',
            'type'        => 'group',
            'description' => __('Штативы/краны/тележки', 'vp-types'),
            'options'     => array(
        'group_title'   => __('Оборудование {#}', 'vp-types'),
        'add_button'    => __('Добавить оборудование', 'vp-types'),
        'remove_button' => __('Удалить', 'vp-types'),
        'sortable'      => true,
    ),
));
        
        $venue_metabox->add_group_field($equipment_group, array(
    'name'    => __('Тип оборудования', 'vp-types'),
    'id'      => 'equipment_type',
    'type'    => 'select',
    'options' => array(
        ''          => __('-- Выберите тип --', 'vp-types'),
        'tripods'   => __('Штативы', 'vp-types'),
        'cranes'    => __('Краны', 'vp-types'),
        'dollies'   => __('Тележки', 'vp-types'),
    ),
));
        
        $venue_metabox->add_group_field($equipment_group, array(
            'name'    => __('Количество', 'vp-types'),
            'id'      => 'count',
            'type'    => 'text_small',
        ));
        
        $tracking_group = $venue_metabox->add_field(array(
            'id'          => 'vp_venue_tracking',
            'type'        => 'group',
            'description' => __('Системы трекинга', 'vp-types'),
            'options'     => array(
                'group_title'   => __('Система трекинга {#}', 'vp-types'),
                'add_button'    => __('Добавить систему трекинга', 'vp-types'),
                'remove_button' => __('Удалить', 'vp-types'),
                'sortable'      => true,
            ),
        ));
        
        $venue_metabox->add_group_field($tracking_group, array(
            'name'    => __('Марка', 'vp-types'),
            'id'      => 'brand',
            'type'    => 'text',
        ));
        
        $venue_metabox->add_group_field($tracking_group, array(
            'name'    => __('Количество', 'vp-types'),
            'id'      => 'count',
            'type'    => 'text_small',
        ));
        
        $venue_metabox->add_group_field($tracking_group, array(
            'name'    => __('Площадь (м²)', 'vp-types'),
            'id'      => 'area',
            'type'    => 'text_small',
        ));
        
        $venue_metabox->add_group_field($tracking_group, array(
            'name'    => __('Высота (м)', 'vp-types'),
            'id'      => 'height',
            'type'    => 'text_small',
        ));
        
        $calibration_group = $venue_metabox->add_field(array(
            'id'          => 'vp_venue_calibration',
            'type'        => 'group',
            'description' => __('Система калибровки', 'vp-types'),
            'options'     => array(
                'group_title'   => __('Система калибровки {#}', 'vp-types'),
                'add_button'    => __('Добавить систему калибровки', 'vp-types'),
                'remove_button' => __('Удалить', 'vp-types'),
                'sortable'      => true,
            ),
        ));
        
        $venue_metabox->add_group_field($calibration_group, array(
            'name'    => __('Марка', 'vp-types'),
            'id'      => 'brand',
            'type'    => 'text',
        ));
        
        $venue_metabox->add_group_field($calibration_group, array(
            'name'    => __('Скорость калибровки', 'vp-types'),
            'id'      => 'speed_value',
            'type'    => 'text_small',
            'attributes' => array(
                'style' => 'width: 80px; display: inline-block; margin-right: 10px;'
            ),
        ));

        $venue_metabox->add_group_field($calibration_group, array(
            'name'    => __('Единица измерения', 'vp-types'),
            'id'      => 'speed_unit',
            'type'    => 'select',
            'options' => array(
                'hours'   => __('часов', 'vp-types'),
                'minutes' => __('минут', 'vp-types'),
                'seconds' => __('секунд', 'vp-types'),
            ),
            'default' => 'hours',
            'attributes' => array(
                'style' => 'width: 100px; display: inline-block;'
            ),
        ));
        
        $venue_metabox->add_group_field($calibration_group, array(
            'name'    => __('Создание lens файла', 'vp-types'),
            'id'      => 'lens_file_creation',
            'type'    => 'select',
            'options' => array(
                ''    => __('-- Не указано --', 'vp-types'),
                'yes' => __('Да', 'vp-types'),
                'no'  => __('Нет', 'vp-types'),
            ),
        ));
        
        $venue_metabox->add_group_field($calibration_group, array(
            'name'    => __('Калибровка пространств', 'vp-types'),
            'id'      => 'space_calibration',
            'type'    => 'select',
            'options' => array(
                ''    => __('-- Не указано --', 'vp-types'),
                'yes' => __('Да', 'vp-types'),
                'no'  => __('Нет', 'vp-types'),
            ),
        ));
        
        $render_group = $venue_metabox->add_field(array(
            'id'          => 'vp_venue_render_servers',
            'type'        => 'group',
            'description' => __('Рендер сервера', 'vp-types'),
            'options'     => array(
                'group_title'   => __('Рендер сервер {#}', 'vp-types'),
                'add_button'    => __('Добавить рендер сервер', 'vp-types'),
                'remove_button' => __('Удалить', 'vp-types'),
                'sortable'      => true,
            ),
        ));
        
        $venue_metabox->add_group_field($render_group, array(
            'name'    => __('Модель видеокарты', 'vp-types'),
            'id'      => 'gpu_model',
            'type'    => 'text',
        ));
        
        $venue_metabox->add_group_field($render_group, array(
            'name'    => __('Карта видеозахвата', 'vp-types'),
            'id'      => 'capture_card_model',
            'type'    => 'text',
        ));
        
        $venue_metabox->add_field(array(
            'name'    => __('UE версия', 'vp-types'),
            'id'      => 'vp_venue_ue_version',
            'type'    => 'text',
            'desc'    => __('Версия Unreal Engine', 'vp-types'),
        ));
        
        $venue_metabox->add_field(array(
            'name'    => __('Возможности VP трансляции', 'vp-types'),
            'id'      => 'vp_venue_broadcast_capabilities',
            'type'    => 'select',
            'options' => array(
                ''    => __('-- Не указано --', 'vp-types'),
                'yes' => __('Да', 'vp-types'),
                'no'  => __('Нет', 'vp-types'),
            ),
        ));
        
        $production_metabox = new_cmb2_box(array(
            'id'            => 'vp_production_metabox',
            'title'         => __('Характеристики продакшена', 'vp-types'),
            'object_types'  => array('vp_production'),
            'context'       => 'normal',
            'priority'      => 'high',
            'show_names'    => true,
        ));
        
        $production_metabox->add_field(array(
            'name'    => __('Наличие площадки', 'vp-types'),
            'id'      => 'vp_production_venue',
            'type'    => 'select',
            'desc'    => __('Выберите "Нет" или конкретную площадку', 'vp-types'),
            'options_cb' => function() {
                $options = array(
                    ''   => __('-- Выберите --', 'vp-types'),
                    'no' => __('Нет', 'vp-types'),
                );

                $venues = get_posts(array(
                    'post_type'      => 'vp_venue',
                    'posts_per_page' => -1,
                    'orderby'        => 'title',
                    'order'          => 'ASC',
                ));
                
                foreach ($venues as $venue) {
                    $options[$venue->ID] = $venue->post_title;
                }
                
                return $options;
            },
        ));

        $production_metabox->add_field(array(
            'name'    => __('Типы проектов', 'vp-types'),
            'id'      => 'vp_production_project_types',
            'type'    => 'multicheck',
            'options' => array(
                'full_length'       => __('Полный метр', 'vp-types'),
                'music_videos'      => __('Клипы', 'vp-types'),
                'advertising'       => __('Реклама', 'vp-types'),
                'sports_broadcast'  => __('Спортивные трансляции', 'vp-types'),
                'event_filming'     => __('Съемка мероприятий', 'vp-types'),
                'mocap_animation'   => __('Мокап анимация', 'vp-types'),
                'corporate_video'   => __('Корпоративное видео', 'vp-types'),
                'educational'       => __('Образовательный контент', 'vp-types'),
            ),
        ));

        $production_metabox->add_field(array(
            'name'    => __('Компетенции', 'vp-types'),
            'id'      => 'vp_production_competencies',
            'type'    => 'multicheck',
            'options' => array(
                'virtual_production' => __('Работа с Virtual Production', 'vp-types'),
                'cgi'               => __('CGI', 'vp-types'),
                'unreal_engine'     => __('Работа с Unreal Engine (UE)', 'vp-types'),
            ),
        ));
        
        $production_metabox->add_field(array(
            'name'    => __('Наличие супервайзера', 'vp-types'),
            'id'      => 'vp_production_has_supervisor',
            'type'    => 'select',
            'options' => array(
                ''    => __('-- Не указано --', 'vp-types'),
                'yes' => __('Да', 'vp-types'),
                'no'  => __('Нет', 'vp-types'),
            ),
        ));
        
        $production_metabox->add_field(array(
            'name'    => __('Подтвержденная квалификация VP (количество сертификатов)', 'vp-types'),
            'id'      => 'vp_production_certificates_count',
            'type'    => 'text_small',
            'desc'    => __('Количество VP сертификатов', 'vp-types'),
        ));
        
        $manufacturer_metabox = new_cmb2_box(array(
    'id'            => 'vp_manufacturer_metabox',
    'title'         => __('Информация о производителе', 'vp-types'),
    'object_types'  => array('vp_manufacturer'),
    'context'       => 'normal',
    'priority'      => 'high',
    'show_names'    => true,
));

$manufacturer_metabox->add_field(array(
    'name'    => __('Город', 'vp-types'),
    'id'      => 'vp_manufacturer_city',
    'type'    => 'text',
    'default' => 'Москва',
    'desc'    => __('Город расположения производителя', 'vp-types'),
));

$manufacturer_metabox->add_field(array(
    'name'    => __('Адрес', 'vp-types'),
    'id'      => 'vp_manufacturer_address',
    'type'    => 'text',
    'desc'    => __('Полный адрес производителя', 'vp-types'),
));

$equipment_group = $manufacturer_metabox->add_field(array(
    'id'          => 'vp_manufacturer_equipment',
    'type'        => 'group',
    'description' => __('Оборудование', 'vp-types'),
    'options'     => array(
        'group_title'   => __('Оборудование {#}', 'vp-types'),
        'add_button'    => __('Добавить оборудование', 'vp-types'),
        'remove_button' => __('Удалить', 'vp-types'),
        'sortable'      => true,
    ),
));

$manufacturer_metabox->add_group_field($equipment_group, array(
    'name'    => __('Название модели', 'vp-types'),
    'id'      => 'model_name',
    'type'    => 'text',
    'desc'    => __('Название/модель оборудования', 'vp-types'),
));

$manufacturer_metabox->add_group_field($equipment_group, array(
    'name'    => __('Описание (характеристики)', 'vp-types'),
    'id'      => 'description',
    'type'    => 'textarea',
    'desc'    => __('Подробное описание и характеристики оборудования', 'vp-types'),
));

$services_group = $manufacturer_metabox->add_field(array(
    'id'          => 'vp_manufacturer_services',
    'type'        => 'group',
    'description' => __('Услуги', 'vp-types'),
    'options'     => array(
        'group_title'   => __('Услуга {#}', 'vp-types'),
        'add_button'    => __('Добавить услугу', 'vp-types'),
        'remove_button' => __('Удалить', 'vp-types'),
        'sortable'      => true,
    ),
));

$manufacturer_metabox->add_group_field($services_group, array(
    'name'    => __('Описание услуги', 'vp-types'),
    'id'      => 'service_description',
    'type'    => 'textarea',
    'desc'    => __('Подробное описание предоставляемой услуги', 'vp-types'),
));
        
        $rental_metabox = new_cmb2_box(array(
            'id'            => 'vp_rental_metabox',
            'title'         => __('Информация о прокате оборудования', 'vp-types'),
            'object_types'  => array('vp_rental'),
            'context'       => 'normal',
            'priority'      => 'high',
            'show_names'    => true,
        ));
        
        $rental_metabox->add_field(array(
            'name'    => __('Условия проката', 'vp-types'),
            'id'      => 'vp_rental_conditions',
            'type'    => 'textarea',
            'desc'    => __('Общие условия проката оборудования', 'vp-types'),
        ));
        
        $specialist_metabox = new_cmb2_box(array(
            'id'            => 'vp_specialist_metabox',
            'title'         => __('Информация о специалисте', 'vp-types'),
            'object_types'  => array('vp_specialist'),
            'context'       => 'normal',
            'priority'      => 'high',
            'show_names'    => true,
        ));
        
        $specialist_metabox->add_field(array(
            'name'    => __('Должность/специализация', 'vp-types'),
            'id'      => 'vp_specialist_position',
            'type'    => 'text',
        ));
        
        $specialist_metabox->add_field(array(
            'name'    => __('Опыт работы (лет)', 'vp-types'),
            'id'      => 'vp_specialist_experience',
            'type'    => 'text_small',
        ));
        
        $specialist_metabox->add_field(array(
            'name'    => __('Контактная информация', 'vp-types'),
            'id'      => 'vp_specialist_contact',
            'type'    => 'textarea_small',
        ));

        if (class_exists('WooCommerce')) {
            $wc_equipment_metabox = new_cmb2_box(array(
                'id'            => 'vp_equipment_metabox',
                'title'         => __('Характеристики VP оборудования', 'vp-types'),
                'object_types'  => array('product'),
                'context'       => 'normal',
                'priority'      => 'high',
                'show_names'    => true,
                'show_on_cb'    => function() {
                    global $post;
                    if (!$post) return false;
                    $product_type = get_post_meta($post->ID, '_vp_product_type', true);
                    return $product_type === 'vp_equipment' || empty($product_type);
                },
            ));
            
            $wc_equipment_metabox->add_field(array(
                'name'    => __('Тип VP оборудования', 'vp-types'),
                'id'      => '_vp_product_type',
                'type'    => 'select',
                'options' => array(
                    'vp_equipment' => __('VP оборудование', 'vp-types'),
                    'vp_service'   => __('VP услуга', 'vp-types'),
                ),
                'default' => 'vp_equipment',
            ));
            
            $wc_equipment_metabox->add_field(array(
                'name'    => __('Технические характеристики', 'vp-types'),
                'id'      => '_vp_equipment_specs',
                'type'    => 'textarea',
            ));
            
            $wc_equipment_metabox->add_field(array(
                'name'    => __('Связанные компании', 'vp-types'),
                'id'      => '_vp_related_companies',
                'type'    => 'multicheck',
                'options_cb' => function() {
                    $companies = array();
                    $types = array('vp_manufacturer', 'vp_rental');
                    
                    foreach ($types as $type) {
                        $args = array(
                            'post_type'      => $type,
                            'posts_per_page' => -1,
                            'orderby'        => 'title',
                            'order'          => 'ASC',
                        );
                        
                        $posts = get_posts($args);
                        
                        foreach ($posts as $post) {
                            $companies[$post->ID] = $post->post_title . ' (' . $type . ')';
                        }
                    }
                    
                    return $companies;
                },
            ));
            
            $wc_service_metabox = new_cmb2_box(array(
                'id'            => 'vp_service_metabox',
                'title'         => __('Характеристики VP услуги', 'vp-types'),
                'object_types'  => array('product'),
                'context'       => 'normal',
                'priority'      => 'high',
                'show_names'    => true,
                'show_on_cb'    => function() {
                    global $post;
                    if (!$post) return false;
                    return get_post_meta($post->ID, '_vp_product_type', true) === 'vp_service';
                },
            ));
            
            $wc_service_metabox->add_field(array(
                'name'    => __('Описание услуги', 'vp-types'),
                'id'      => '_vp_service_description',
                'type'    => 'textarea',
            ));
            
            $wc_service_metabox->add_field(array(
                'name'    => __('Длительность услуги', 'vp-types'),
                'id'      => '_vp_service_duration',
                'type'    => 'text_small',
            ));
        }
    }

    public function register_relationships() {
        if (!class_exists('CMB2')) {
            return;
        }
        
        $venue_connections = new_cmb2_box(array(
            'id'            => 'vp_venue_connections',
            'title'         => __('Связи с компаниями', 'vp-types'),
            'object_types'  => array('vp_venue'),
            'context'       => 'side',
            'priority'      => 'default',
            'show_names'    => true,
        ));
        
        $venue_connections->add_field(array(
            'name'    => __('Связанные компании', 'vp-types'),
            'id'      => 'vp_venue_related_companies',
            'type'    => 'multicheck',
            'options_cb' => function() {
                $companies = array();
                $types = array('vp_manufacturer', 'vp_rental', 'vp_production');
                
                foreach ($types as $type) {
                    $args = array(
                        'post_type'      => $type,
                        'posts_per_page' => -1,
                        'orderby'        => 'title',
                        'order'          => 'ASC',
                    );
                    
                    $posts = get_posts($args);
                    
                    foreach ($posts as $post) {
                        $companies[$post->ID] = $post->post_title . ' (' . $type . ')';
                    }
                }
                
                return $companies;
            },
        ));
        
        $production_connections = new_cmb2_box(array(
            'id'            => 'vp_production_connections',
            'title'         => __('Связи со специалистами', 'vp-types'),
            'object_types'  => array('vp_production'),
            'context'       => 'side',
            'priority'      => 'default',
            'show_names'    => true,
        ));
        
        $production_connections->add_field(array(
            'name'    => __('Специалисты компании', 'vp-types'),
            'id'      => 'vp_production_specialists',
            'type'    => 'multicheck',
            'options_cb' => function() {
                $specialists = array();
                
                $args = array(
                    'post_type'      => 'vp_specialist',
                    'posts_per_page' => -1,
                    'orderby'        => 'title',
                    'order'          => 'ASC',
                );
                
                $posts = get_posts($args);
                
                foreach ($posts as $post) {
                    $specialists[$post->ID] = $post->post_title;
                }
                
                return $specialists;
            },
        ));
    }
}

function vp_types_init() {
    new VP_Types();
    new VP_Template_Loader(); 
}
add_action('plugins_loaded', 'vp_types_init');

function vp_venues_shortcode($atts) {
    $atts = shortcode_atts(array(
        'limit' => -1,
        'order' => 'title',
        'orderby' => 'ASC',
    ), $atts);
    
    $args = array(
        'post_type'      => 'vp_venue',
        'posts_per_page' => $atts['limit'],
        'orderby'        => $atts['order'],
        'order'          => $atts['orderby'],
    );
    
    $venues = get_posts($args);
    
    if (empty($venues)) {
        return '<p>' . __('Площадки не найдены', 'vp-types') . '</p>';
    }
    
    $output = '<div class="vp-venues-grid">';
    
    foreach ($venues as $venue) {
        $address = get_post_meta($venue->ID, 'vp_venue_address', true);
        $size = get_post_meta($venue->ID, 'vp_venue_size', true);
        $thumbnail = get_the_post_thumbnail($venue->ID, 'medium');
        
        $output .= '<div class="vp-venue-item">';
        if ($thumbnail) {
            $output .= '<div class="vp-venue-thumbnail">' . $thumbnail . '</div>';
        }
        $output .= '<h3 class="vp-venue-title"><a href="' . get_permalink($venue->ID) . '">' . $venue->post_title . '</a></h3>';
        if ($address) {
            $output .= '<div class="vp-venue-address"><strong>' . __('Адрес:', 'vp-types') . '</strong> ' . $address . '</div>';
        }
        if ($size) {
            $output .= '<div class="vp-venue-size"><strong>' . __('Размер площадки:', 'vp-types') . '</strong> ' . $size . ' м²</div>';
        }
        $output .= '<a href="' . get_permalink($venue->ID) . '" class="vp-venue-link">' . __('Подробнее', 'vp-types') . '</a>';
        $output .= '</div>';
    }
    
    $output .= '</div>';
    
    return $output;
}
add_shortcode('vp_venues', 'vp_venues_shortcode');

function vp_productions_shortcode($atts) {
    $atts = shortcode_atts(array(
        'limit' => -1,
        'order' => 'title',
        'orderby' => 'ASC',
        'project_type' => '',
    ), $atts);
    
    $args = array(
        'post_type'      => 'vp_production',
        'posts_per_page' => $atts['limit'],
        'orderby'        => $atts['order'],
        'order'          => $atts['orderby'],
    );
    
    if (!empty($atts['project_type'])) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'vp_project_type',
                'field'    => 'slug',
                'terms'    => explode(',', $atts['project_type']),
            ),
        );
    }
    
    $productions = get_posts($args);
    
    if (empty($productions)) {
        return '<p>' . __('Продакшены не найдены', 'vp-types') . '</p>';
    }
    
    $output = '<div class="vp-productions-grid">';
    
    foreach ($productions as $production) {
        $competencies = get_the_terms($production->ID, 'vp_competency');
        $thumbnail = get_the_post_thumbnail($production->ID, 'medium');
        
        $output .= '<div class="vp-production-item">';
        if ($thumbnail) {
            $output .= '<div class="vp-production-thumbnail">' . $thumbnail . '</div>';
        }
        $output .= '<h3 class="vp-production-title"><a href="' . get_permalink($production->ID) . '">' . $production->post_title . '</a></h3>';
        
        if (!empty($competencies) && !is_wp_error($competencies)) {
            $output .= '<div class="vp-production-competencies"><strong>' . __('Компетенции:', 'vp-types') . '</strong> ';
            $comp_names = array();
            foreach ($competencies as $comp) {
                $comp_names[] = $comp->name;
            }
            $output .= implode(', ', $comp_names);
            $output .= '</div>';
        }
        
        $output .= '<a href="' . get_permalink($production->ID) . '" class="vp-production-link">' . __('Подробнее', 'vp-types') . '</a>';
        $output .= '</div>';
    }
    
    $output .= '</div>';
    
    return $output;
}
add_shortcode('vp_productions', 'vp_productions_shortcode');

function vp_manufacturers_shortcode($atts) {
    $atts = shortcode_atts(array(
        'limit' => -1,
        'order' => 'title',
        'orderby' => 'ASC',
    ), $atts);
    
    $args = array(
        'post_type'      => 'vp_manufacturer',
        'posts_per_page' => $atts['limit'],
        'orderby'        => $atts['order'],
        'order'          => $atts['orderby'],
    );
    
    $manufacturers = get_posts($args);
    
    if (empty($manufacturers)) {
        return '<p>' . __('Производители не найдены', 'vp-types') . '</p>';
    }
    
    $output = '<div class="vp-manufacturers-grid">';
    
    foreach ($manufacturers as $manufacturer) {
        $thumbnail = get_the_post_thumbnail($manufacturer->ID, 'medium');
        
        $output .= '<div class="vp-manufacturer-item">';
        if ($thumbnail) {
            $output .= '<div class="vp-manufacturer-thumbnail">' . $thumbnail . '</div>';
        }
        $output .= '<h3 class="vp-manufacturer-title"><a href="' . get_permalink($manufacturer->ID) . '">' . $manufacturer->post_title . '</a></h3>';
        $output .= '<div class="vp-manufacturer-excerpt">' . get_the_excerpt($manufacturer->ID) . '</div>';
        $output .= '<a href="' . get_permalink($manufacturer->ID) . '" class="vp-manufacturer-link">' . __('Подробнее', 'vp-types') . '</a>';
        $output .= '</div>';
    }
    
    $output .= '</div>';
    
    return $output;
}
add_shortcode('vp_manufacturers', 'vp_manufacturers_shortcode');

function vp_rentals_shortcode($atts) {
    $atts = shortcode_atts(array(
        'limit' => -1,
        'order' => 'title',
        'orderby' => 'ASC',
    ), $atts);
    
    $args = array(
        'post_type'      => 'vp_rental',
        'posts_per_page' => $atts['limit'],
        'orderby'        => $atts['order'],
        'order'          => $atts['orderby'],
    );
    
    $rentals = get_posts($args);
    
    if (empty($rentals)) {
        return '<p>' . __('Ренталы не найдены', 'vp-types') . '</p>';
    }
    
    $output = '<div class="vp-rentals-grid">';
    
    foreach ($rentals as $rental) {
        $thumbnail = get_the_post_thumbnail($rental->ID, 'medium');
        
        $output .= '<div class="vp-rental-item">';
        if ($thumbnail) {
            $output .= '<div class="vp-rental-thumbnail">' . $thumbnail . '</div>';
        }
        $output .= '<h3 class="vp-rental-title"><a href="' . get_permalink($rental->ID) . '">' . $rental->post_title . '</a></h3>';
        $output .= '<div class="vp-rental-excerpt">' . get_the_excerpt($rental->ID) . '</div>';
        $output .= '<a href="' . get_permalink($rental->ID) . '" class="vp-rental-link">' . __('Подробнее', 'vp-types') . '</a>';
        $output .= '</div>';
    }
    
    $output .= '</div>';
    
    return $output;
}
add_shortcode('vp_rentals', 'vp_rentals_shortcode');

function vp_equipment_shortcode($atts) {
    if (!class_exists('WooCommerce')) {
        return '<p>' . __('Для вывода оборудования требуется WooCommerce', 'vp-types') . '</p>';
    }
    
    $atts = shortcode_atts(array(
        'limit' => -1,
        'order' => 'title',
        'orderby' => 'ASC',
        'equipment_type' => '',
    ), $atts);
    
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => $atts['limit'],
        'orderby'        => $atts['order'],
        'order'          => $atts['orderby'],
        'meta_query'     => array(
            array(
                'key'     => '_vp_product_type',
                'value'   => 'vp_equipment',
                'compare' => '=',
            ),
        ),
    );
    
    if (!empty($atts['equipment_type'])) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'vp_equipment_type',
                'field'    => 'slug',
                'terms'    => explode(',', $atts['equipment_type']),
            ),
        );
    }
    
    $equipment = get_posts($args);
    
    if (empty($equipment)) {
        return '<p>' . __('Оборудование не найдено', 'vp-types') . '</p>';
    }
    
    $output = '<div class="vp-equipment-grid">';
    
    foreach ($equipment as $item) {
        $product = wc_get_product($item->ID);
        $thumbnail = get_the_post_thumbnail($item->ID, 'medium');
        
        $output .= '<div class="vp-equipment-item">';
        if ($thumbnail) {
            $output .= '<div class="vp-equipment-thumbnail">' . $thumbnail . '</div>';
        }
        $output .= '<h3 class="vp-equipment-title"><a href="' . get_permalink($item->ID) . '">' . $item->post_title . '</a></h3>';
        
        if ($product) {
            $output .= '<div class="vp-equipment-price">' . $product->get_price_html() . '</div>';
        }
        
        $output .= '<a href="' . get_permalink($item->ID) . '" class="vp-equipment-link">' . __('Подробнее', 'vp-types') . '</a>';
        $output .= '</div>';
    }
    
    $output .= '</div>';
    
    return $output;
}
add_shortcode('vp_equipment', 'vp_equipment_shortcode');

function vp_services_shortcode($atts) {
    if (!class_exists('WooCommerce')) {
        return '<p>' . __('Для вывода услуг требуется WooCommerce', 'vp-types') . '</p>';
    }
    
    $atts = shortcode_atts(array(
        'limit' => -1,
        'order' => 'title',
        'orderby' => 'ASC',
        'service_type' => '',
    ), $atts);
    
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => $atts['limit'],
        'orderby'        => $atts['order'],
        'order'          => $atts['orderby'],
        'meta_query'     => array(
            array(
                'key'     => '_vp_product_type',
                'value'   => 'vp_service',
                'compare' => '=',
            ),
        ),
    );
    
    if (!empty($atts['service_type'])) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'vp_service_type',
                'field'    => 'slug',
                'terms'    => explode(',', $atts['service_type']),
            ),
        );
    }
    
    $services = get_posts($args);
    
    if (empty($services)) {
        return '<p>' . __('Услуги не найдены', 'vp-types') . '</p>';
    }
    
    $output = '<div class="vp-services-grid">';
    
    foreach ($services as $service) {
        $product = wc_get_product($service->ID);
        $thumbnail = get_the_post_thumbnail($service->ID, 'medium');
        
        $output .= '<div class="vp-service-item">';
        if ($thumbnail) {
            $output .= '<div class="vp-service-thumbnail">' . $thumbnail . '</div>';
        }
        $output .= '<h3 class="vp-service-title"><a href="' . get_permalink($service->ID) . '">' . $service->post_title . '</a></h3>';
        
        if ($product) {
            $output .= '<div class="vp-service-price">' . $product->get_price_html() . '</div>';
        }
        
        $output .= '<a href="' . get_permalink($service->ID) . '" class="vp-service-link">' . __('Подробнее', 'vp-types') . '</a>';
        $output .= '</div>';
    }

    $output .= '</div>';

    return $output;
}
add_shortcode('vp_services', 'vp_services_shortcode');

class VP_Template_Loader {
    
    public function __construct() {
        add_filter('single_template', array($this, 'load_single_template'));
        add_filter('template_include', array($this, 'template_include'), 99);
        add_action('wp_enqueue_scripts', array($this, 'enqueue_vp_styles'));
    }
    
    public function load_single_template($template) {
        global $post;
        
        $vp_post_types = array('vp_venue', 'vp_production', 'vp_manufacturer', 'vp_rental', 'vp_specialist');
        
        if (is_single() && isset($post->post_type) && in_array($post->post_type, $vp_post_types)) {
            $theme_template = locate_template(array(
                'single-' . $post->post_type . '.php',
                'vp-templates/single-' . $post->post_type . '.php'
            ));
            
            if ($theme_template) {
                return $theme_template;
            }
            
            $plugin_template = plugin_dir_path(__FILE__) . 'templates/single-' . $post->post_type . '.php';
            if (file_exists($plugin_template)) {
                return $plugin_template;
            }
        }
        
        return $template;
    }
    
    public function template_include($template) {
        global $post;
        
        if (!is_single() || !isset($post->post_type)) {
            return $template;
        }
        
        $vp_post_types = array('vp_venue', 'vp_production', 'vp_manufacturer', 'vp_rental', 'vp_specialist');
        
        if (in_array($post->post_type, $vp_post_types)) {
            add_filter('the_content', array($this, 'override_vp_content'), 20);
            
            if (function_exists('bunyad') || class_exists('Bunyad_Core')) {
                add_action('bunyad_single_content_before', array($this, 'bunyad_custom_content'));
                add_filter('bunyad_get_template_part', array($this, 'bunyad_template_override'), 10, 2);
            }
        }
        
        return $template;
    }
    
    public function override_vp_content($content) {
        global $post;
        
        if (!is_main_query() || !is_single()) {
            return $content;
        }
        
        $vp_post_types = array('vp_venue', 'vp_production', 'vp_manufacturer', 'vp_rental', 'vp_specialist');
        
        if (in_array($post->post_type, $vp_post_types)) {
            $custom_content = $this->get_vp_custom_content($post);
            $contact_form = do_shortcode('[contact-form-7 id="cf51d9b" title="contact-offer"]');
            return $content . $custom_content . $contact_form;
        }
        
        return $content;
    }
    
    public function bunyad_custom_content() {
        global $post;
        
        $vp_post_types = array('vp_venue', 'vp_production', 'vp_manufacturer', 'vp_rental', 'vp_specialist');
        
        if (in_array($post->post_type, $vp_post_types)) {
            echo $this->get_vp_custom_content($post);
            echo do_shortcode('[contact-form-7 id="cf51d9b" title="contact-offer"]');
        }
    }
    
    public function bunyad_template_override($template, $slug) {
        global $post;
        
        if (!isset($post->post_type)) {
            return $template;
        }
        
        $vp_post_types = array('vp_venue', 'vp_production', 'vp_manufacturer', 'vp_rental', 'vp_specialist');
        
        if (in_array($post->post_type, $vp_post_types) && $slug === 'single/content') {
            $custom_template = plugin_dir_path(__FILE__) . 'templates/bunyad-single-content-' . $post->post_type . '.php';
            if (file_exists($custom_template)) {
                return $custom_template;
            }
        }
        
        return $template;
    }
    
    private function get_vp_custom_content($post) {
        ob_start();
        
        switch ($post->post_type) {
            case 'vp_venue':
                $this->display_venue_content($post);
                break;
            case 'vp_production':
                $this->display_production_content($post);
                break;
            case 'vp_manufacturer':
                $this->display_manufacturer_content($post);
                break;
            case 'vp_rental':
                $this->display_rental_content($post);
                break;
            case 'vp_specialist':
                $this->display_specialist_content($post);
                break;
        }
        
        return ob_get_clean();
    }

    private function has_group_data($group_data) {
        if (empty($group_data) || !is_array($group_data)) {
            return false;
        }
        
        foreach ($group_data as $item) {
            if (!empty($item) && is_array($item)) {
                foreach ($item as $value) {
                    if (!empty(trim($value))) {
                        return true;
                    }
                }
            }
        }
        
        return false;
    }

    private function display_venue_content($post) {
    ?>
    <div class="vp-venue-details">
        <?php
        $city = get_post_meta($post->ID, 'vp_venue_city', true);
        $address = get_post_meta($post->ID, 'vp_venue_address', true);
        $size = get_post_meta($post->ID, 'vp_venue_size', true);
        $working_days = get_post_meta($post->ID, 'vp_venue_working_days', true);
        $chromakey = get_post_meta($post->ID, 'vp_venue_chromakey', true);
        $videowall = get_post_meta($post->ID, 'vp_venue_videowall', true);
        $dmx_integration = get_post_meta($post->ID, 'vp_venue_dmx_integration', true);
        $cameras = get_post_meta($post->ID, 'vp_venue_cameras', true);
        $equipment = get_post_meta($post->ID, 'vp_venue_equipment', true);
        $tracking = get_post_meta($post->ID, 'vp_venue_tracking', true);
        $calibration = get_post_meta($post->ID, 'vp_venue_calibration', true);
        $render_servers = get_post_meta($post->ID, 'vp_venue_render_servers', true);
        $ue_version = get_post_meta($post->ID, 'vp_venue_ue_version', true);
        $broadcast_capabilities = get_post_meta($post->ID, 'vp_venue_broadcast_capabilities', true);
        ?>
        
        <?php if ($city || $address): ?>
            <div class="vp-venue-info">
                <h3><?php _e('Адрес расположения', 'vp-types'); ?></h3>
                <?php if ($city): ?>
                    <p><strong><?php _e('Город:', 'vp-types'); ?></strong> <?php echo esc_html($city); ?></p>
                <?php endif; ?>
                <?php if ($address): ?>
                    <p><strong><?php _e('Адрес:', 'vp-types'); ?></strong> <?php echo esc_html($address); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
        <?php if ($size): ?>
            <div class="vp-venue-info">
                <h3><?php _e('Размер площадки', 'vp-types'); ?></h3>
                <p><?php echo esc_html($size); ?> м²</p>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($working_days)): ?>
            <div class="vp-venue-info">
                <h3><?php _e('Режим работы', 'vp-types'); ?></h3>
                <div class="working-days">
                    <?php 
                    $day_labels = array(
                        'monday'    => 'Пн',
                        'tuesday'   => 'Вт',
                        'wednesday' => 'Ср',
                        'thursday'  => 'Чт',
                        'friday'    => 'Пт',
                        'saturday'  => 'Сб',
                        'sunday'    => 'Вс'
                    );
                    
                    $working_day_names = array();
                    foreach ($working_days as $day) {
                        if (isset($day_labels[$day])) {
                            $working_day_names[] = $day_labels[$day];
                        }
                    }
                    echo implode(', ', $working_day_names);
                    ?>
                </div>
            </div>
        <?php endif; ?>
        
        <?php if ($this->has_group_data($chromakey)): ?>
            <div class="vp-venue-chromakey">
                <h3><?php _e('Хромакей оснащение', 'vp-types'); ?></h3>
                <?php foreach ($chromakey as $item): ?>
                    <?php if (!empty($item) && is_array($item) && array_filter($item)): ?>
                        <div class="chromakey-item">
                            <h4><?php _e('Хромакей', 'vp-types'); ?></h4>
                            <?php if (!empty($item['construction'])): ?>
                                <p><strong><?php _e('Конструкция:', 'vp-types'); ?></strong> 
                                    <?php echo $item['construction'] === 'cyclorama' ? 'Циклорама' : 'Полотно'; ?>
                                </p>
                            <?php endif; ?>
                            <div class="dimensions">
                                <?php if (!empty($item['height'])): ?>
                                    <span><strong><?php _e('Высота:', 'vp-types'); ?></strong> <?php echo esc_html($item['height']); ?> м</span>
                                <?php endif; ?>
                                <?php if (!empty($item['width'])): ?>
                                    <span><strong><?php _e('Ширина:', 'vp-types'); ?></strong> <?php echo esc_html($item['width']); ?> м</span>
                                <?php endif; ?>
                                <?php if (!empty($item['depth'])): ?>
                                    <span><strong><?php _e('Глубина:', 'vp-types'); ?></strong> <?php echo esc_html($item['depth']); ?> м</span>
                                <?php endif; ?>
                            </div>
                            <?php if (!empty($item['color'])): ?>
                                <p><strong><?php _e('Цвет:', 'vp-types'); ?></strong> 
                                    <?php echo $item['color'] === 'green' ? 'Зеленый' : 'Синий'; ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <?php if ($this->has_group_data($videowall)): ?>
    <div class="vp-venue-videowall">
        <h3><?php _e('Видеостена', 'vp-types'); ?></h3>
        <?php foreach ($videowall as $item): ?>
            <?php if (!empty($item) && is_array($item) && array_filter($item)): ?>
                <div class="videowall-item">
                    <?php if (!empty($item['pixel_pitch'])): ?>
                        <p><strong><?php _e('Шаг пикселя:', 'vp-types'); ?></strong> <?php echo esc_html($item['pixel_pitch']); ?></p>
                    <?php endif; ?>
                    <?php if (!empty($item['area'])): ?>
                        <p><strong><?php _e('Площадь:', 'vp-types'); ?></strong> <?php echo esc_html($item['area']); ?> м²</p>
                    <?php endif; ?>
                    <?php if (!empty($item['processor_brand'])): ?>
                        <p><strong><?php _e('Процессор марка:', 'vp-types'); ?></strong> <?php echo esc_html($item['processor_brand']); ?></p>
                    <?php endif; ?>
                    <?php if (!empty($item['custom_configuration'])): ?>
                        <p><strong><?php _e('Индивидуальная конфигурация:', 'vp-types'); ?></strong> 
                            <span class="custom-config-yes"><?php _e('Возможна', 'vp-types'); ?></span>
                        </p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

        <?php if ($dmx_integration): ?>
            <div class="vp-venue-lighting">
                <h3><?php _e('Освещение', 'vp-types'); ?></h3>
                <p><strong><?php _e('Интеграция DMX:', 'vp-types'); ?></strong> <?php _e('Есть', 'vp-types'); ?></p>
            </div>
        <?php endif; ?>
        
        <?php if ($this->has_group_data($cameras)): ?>
            <div class="vp-venue-cameras">
                <h3><?php _e('Видеокамеры с GenLock', 'vp-types'); ?></h3>
                <?php foreach ($cameras as $camera): ?>
                    <?php if (!empty($camera) && is_array($camera) && array_filter($camera)): ?>
                        <div class="camera-item">
                            <?php if (!empty($camera['model'])): ?>
                                <p><strong><?php _e('Модель:', 'vp-types'); ?></strong> <?php echo esc_html($camera['model']); ?></p>
                            <?php endif; ?>
                            <?php if (!empty($camera['count'])): ?>
                                <p><strong><?php _e('Количество:', 'vp-types'); ?></strong> <?php echo esc_html($camera['count']); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ($this->has_group_data($equipment)): ?>
    <div class="vp-venue-equipment">
        <h3><?php _e('Штативы/краны/тележки', 'vp-types'); ?></h3>
        <?php foreach ($equipment as $item): ?>
            <?php if (!empty($item) && is_array($item) && array_filter($item)): ?>
                <div class="equipment-item">
                    <?php if (!empty($item['equipment_type'])): ?>
                        <p><strong><?php _e('Тип оборудования:', 'vp-types'); ?></strong> 
                            <?php 
                            $equipment_types = array(
                                'tripods' => 'Штативы',
                                'cranes'  => 'Краны', 
                                'dollies' => 'Тележки'
                            );
                            echo isset($equipment_types[$item['equipment_type']]) ? $equipment_types[$item['equipment_type']] : $item['equipment_type'];
                            ?>
                        </p>
                    <?php endif; ?>
                    <?php if (!empty($item['count'])): ?>
                        <p><strong><?php _e('Количество:', 'vp-types'); ?></strong> <?php echo esc_html($item['count']); ?></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
        
        <?php if ($this->has_group_data($tracking)): ?>
            <div class="vp-venue-tracking">
                <h3><?php _e('Системы трекинга', 'vp-types'); ?></h3>
                <?php foreach ($tracking as $item): ?>
                    <?php if (!empty($item) && is_array($item) && array_filter($item)): ?>
                        <div class="tracking-item">
                            <?php if (!empty($item['brand'])): ?>
                                <p><strong><?php _e('Марка:', 'vp-types'); ?></strong> <?php echo esc_html($item['brand']); ?></p>
                            <?php endif; ?>
                            <?php if (!empty($item['count'])): ?>
                                <p><strong><?php _e('Количество:', 'vp-types'); ?></strong> <?php echo esc_html($item['count']); ?></p>
                            <?php endif; ?>
                            <?php if (!empty($item['area'])): ?>
                                <p><strong><?php _e('Площадь:', 'vp-types'); ?></strong> <?php echo esc_html($item['area']); ?> м²</p>
                            <?php endif; ?>
                            <?php if (!empty($item['height'])): ?>
                                <p><strong><?php _e('Высота:', 'vp-types'); ?></strong> <?php echo esc_html($item['height']); ?> м</p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ($this->has_group_data($calibration)): ?>
            <div class="vp-venue-calibration">
                <h3><?php _e('Система калибровки', 'vp-types'); ?></h3>
                <?php foreach ($calibration as $item): ?>
                    <?php if (!empty($item) && is_array($item) && array_filter($item)): ?>
                        <div class="calibration-item">
                            <?php if (!empty($item['brand'])): ?>
                                <p><strong><?php _e('Марка:', 'vp-types'); ?></strong> <?php echo esc_html($item['brand']); ?></p>
                            <?php endif; ?>
                            <?php if (!empty($item['speed_value'])): ?>
                                <p><strong><?php _e('Скорость калибровки:', 'vp-types'); ?></strong> 
                                    <?php echo esc_html($item['speed_value']); ?>
                                    <?php 
                                    $unit = !empty($item['speed_unit']) ? $item['speed_unit'] : 'hours';
                                    $unit_labels = array(
                                        'hours'   => 'часов',
                                        'minutes' => 'минут', 
                                        'seconds' => 'секунд'
                                    );
                                    echo isset($unit_labels[$unit]) ? $unit_labels[$unit] : 'часов';
                                    ?>
                                </p>
                            <?php endif; ?>
                            <?php if (!empty($item['lens_file_creation'])): ?>
                                <p><strong><?php _e('Создание lens файла:', 'vp-types'); ?></strong> 
                                    <?php echo $item['lens_file_creation'] === 'yes' ? 'Да' : 'Нет'; ?>
                                </p>
                            <?php endif; ?>
                            <?php if (!empty($item['space_calibration'])): ?>
                                <p><strong><?php _e('Калибровка пространств:', 'vp-types'); ?></strong> 
                                    <?php echo $item['space_calibration'] === 'yes' ? 'Да' : 'Нет'; ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <?php if ($this->has_group_data($render_servers)): ?>
            <div class="vp-venue-render-servers">
                <h3><?php _e('Рендер сервера', 'vp-types'); ?></h3>
                <?php foreach ($render_servers as $server): ?>
                    <?php if (!empty($server) && is_array($server) && array_filter($server)): ?>
                        <div class="render-server-item">
                            <?php if (!empty($server['gpu_model'])): ?>
                                <p><strong><?php _e('Модель видеокарты:', 'vp-types'); ?></strong> <?php echo esc_html($server['gpu_model']); ?></p>
                            <?php endif; ?>
                            <?php if (!empty($server['capture_card_model'])): ?>
                                <p><strong><?php _e('Карта видеозахвата:', 'vp-types'); ?></strong> <?php echo esc_html($server['capture_card_model']); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <?php if ($ue_version): ?>
            <div class="vp-venue-3d-engine">
                <h3><?php _e('3D движок', 'vp-types'); ?></h3>
                <p><strong><?php _e('UE версия:', 'vp-types'); ?></strong> <?php echo esc_html($ue_version); ?></p>
            </div>
        <?php endif; ?>
        
        <?php if ($broadcast_capabilities && $broadcast_capabilities !== ''): ?>
            <div class="vp-venue-broadcast">
                <h3><?php _e('Возможности VP трансляции', 'vp-types'); ?></h3>
                <p><?php echo $broadcast_capabilities === 'yes' ? 'Да' : 'Нет'; ?></p>
            </div>
        <?php endif; ?>
    </div>
    <?php
}

private function display_production_content($post) {
        ?>
        <div class="vp-production-details">
            <?php
            $venue_selection = get_post_meta($post->ID, 'vp_production_venue', true);
            $project_types = get_post_meta($post->ID, 'vp_production_project_types', true);
            $competencies = get_post_meta($post->ID, 'vp_production_competencies', true);
            $has_supervisor = get_post_meta($post->ID, 'vp_production_has_supervisor', true);
            $certificates_count = get_post_meta($post->ID, 'vp_production_certificates_count', true);
            
            $project_type_labels = array(
                'full_length'       => __('Полный метр', 'vp-types'),
                'music_videos'      => __('Клипы', 'vp-types'),
                'advertising'       => __('Реклама', 'vp-types'),
                'sports_broadcast'  => __('Спортивные трансляции', 'vp-types'),
                'event_filming'     => __('Съемка мероприятий', 'vp-types'),
                'mocap_animation'   => __('Мокап анимация', 'vp-types'),
                'corporate_video'   => __('Корпоративное видео', 'vp-types'),
                'educational'       => __('Образовательный контент', 'vp-types'),
            );
            
            $competency_labels = array(
                'virtual_production' => __('Работа с Virtual Production', 'vp-types'),
                'cgi'               => __('CGI', 'vp-types'),
                'unreal_engine'     => __('Работа с Unreal Engine (UE)', 'vp-types'),
            );
            ?>
            
            <?php if ($venue_selection): ?>
                <div class="vp-production-venue-status">
                    <h3><?php _e('Наличие площадки', 'vp-types'); ?></h3>
                    <?php if ($venue_selection === 'no'): ?>
                        <p class="venue-status-no"><?php _e('Нет', 'vp-types'); ?></p>
                    <?php elseif (is_numeric($venue_selection) && get_post($venue_selection)): ?>
                        <p class="venue-status-yes">
                            <a href="<?php echo get_permalink($venue_selection); ?>">
                                <?php echo get_the_title($venue_selection); ?>
                            </a>
                        </p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($project_types)): ?>
                <div class="vp-production-project-types">
                    <h3><?php _e('Типы проектов', 'vp-types'); ?></h3>
                    <ul class="project-types-list">
                        <?php foreach ($project_types as $type): ?>
                            <?php if (isset($project_type_labels[$type])): ?>
                                <li><?php echo $project_type_labels[$type]; ?></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($competencies)): ?>
                <div class="vp-production-competencies">
                    <h3><?php _e('Компетенции', 'vp-types'); ?></h3>
                    <ul class="competencies-list">
                        <?php foreach ($competencies as $competency): ?>
                            <?php if (isset($competency_labels[$competency])): ?>
                                <li><?php echo $competency_labels[$competency]; ?></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            
            <?php if ($has_supervisor && $has_supervisor !== ''): ?>
                <div class="vp-production-supervisor">
                    <h3><?php _e('Наличие супервайзера', 'vp-types'); ?></h3>
                    <p><?php echo $has_supervisor === 'yes' ? 'Да' : 'Нет'; ?></p>
                </div>
            <?php endif; ?>
            <?php if ($certificates_count): ?>
                    <div class="vp-production-certificates">
                    <h3><a href="https://vprussia.ru/education/intensives/" target="_blank" rel="noopener noreferrer"><?php _e('Подтвержденная квалификация VP', 'vp-types'); ?></a></h3>
                     <p><?php echo esc_html($certificates_count); ?> сертификатов</p>
                    </div>
            <?php endif; ?>
        </div>
        <?php
    }
    
    private function display_manufacturer_content($post) {
    ?>
    <div class="vp-manufacturer-details">
        <?php
        $city = get_post_meta($post->ID, 'vp_manufacturer_city', true);
        $address = get_post_meta($post->ID, 'vp_manufacturer_address', true);
        $equipment = get_post_meta($post->ID, 'vp_manufacturer_equipment', true);
        $services = get_post_meta($post->ID, 'vp_manufacturer_services', true);
        ?>
        
        <?php if ($city || $address): ?>
            <div class="vp-manufacturer-location">
                <h3><?php _e('Адрес расположения', 'vp-types'); ?></h3>
                <?php if ($city): ?>
                    <p><strong><?php _e('Город:', 'vp-types'); ?></strong> <?php echo esc_html($city); ?></p>
                <?php endif; ?>
                <?php if ($address): ?>
                    <p><strong><?php _e('Адрес:', 'vp-types'); ?></strong> <?php echo esc_html($address); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
        <?php if ($this->has_group_data($equipment)): ?>
            <div class="vp-manufacturer-equipment">
                <h3><?php _e('Оборудование', 'vp-types'); ?></h3>
                <?php foreach ($equipment as $item): ?>
                    <?php if (!empty($item) && is_array($item) && array_filter($item)): ?>
                        <div class="equipment-item">
                            <?php if (!empty($item['model_name'])): ?>
                                <h4><?php echo esc_html($item['model_name']); ?></h4>
                            <?php endif; ?>
                            <?php if (!empty($item['description'])): ?>
                                <p><?php echo nl2br(esc_html($item['description'])); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <?php if ($this->has_group_data($services)): ?>
            <div class="vp-manufacturer-services">
                <h3><?php _e('Услуги', 'vp-types'); ?></h3>
                <?php foreach ($services as $service): ?>
                    <?php if (!empty($service) && is_array($service) && array_filter($service)): ?>
                        <div class="service-item">
                            <?php if (!empty($service['service_description'])): ?>
                                <p><?php echo nl2br(esc_html($service['service_description'])); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    <?php
}
    
    private function display_rental_content($post) {
        ?>
        <div class="vp-rental-details">
            <?php
            $conditions = get_post_meta($post->ID, 'vp_rental_conditions', true);
            ?>
            
            <?php if ($conditions): ?>
                <div class="vp-rental-conditions">
                    <h3><?php _e('Условия проката', 'vp-types'); ?></h3>
                    <p><?php echo nl2br(esc_html($conditions)); ?></p>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }
    
    private function display_specialist_content($post) {
        ?>
        <div class="vp-specialist-details">
            <?php
            $position = get_post_meta($post->ID, 'vp_specialist_position', true);
            $experience = get_post_meta($post->ID, 'vp_specialist_experience', true);
            $contact = get_post_meta($post->ID, 'vp_specialist_contact', true);
            ?>
            
            <?php if ($position): ?>
                <div class="vp-specialist-position">
                    <h3><?php _e('Должность/специализация', 'vp-types'); ?></h3>
                    <p><?php echo esc_html($position); ?></p>
                </div>
            <?php endif; ?>
            
            <?php if ($experience): ?>
                <div class="vp-specialist-experience">
                    <h3><?php _e('Опыт работы', 'vp-types'); ?></h3>
                    <p><?php echo esc_html($experience); ?> лет</p>
                </div>
            <?php endif; ?>
            
            <?php if ($contact): ?>
                <div class="vp-specialist-contact">
                    <h3><?php _e('Контактная информация', 'vp-types'); ?></h3>
                    <p><?php echo nl2br(esc_html($contact)); ?></p>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }


    public function enqueue_vp_styles() {
        global $post;
        
        $vp_post_types = array('vp_venue', 'vp_production', 'vp_manufacturer', 'vp_rental', 'vp_specialist');
        
        if (is_single() && isset($post->post_type) && in_array($post->post_type, $vp_post_types)) {
            wp_add_inline_style('wp-block-library', '
            .vp-venue-details, .vp-production-details, .vp-manufacturer-details, 
            .vp-rental-details, .vp-specialist-details {
                margin: 15px 0;
                padding: 15px;
                line-height: 1.4;
                font-size: 16px;
            }
            
            .vp-venue-info, .vp-production-project-types, .vp-production-competencies,
            .vp-manufacturer-products, .vp-rental-conditions, .vp-specialist-position,
            .vp-venue-chromakey, .vp-venue-videowall, .vp-venue-lighting, 
            .vp-venue-cameras, .vp-venue-equipment, .vp-venue-tracking,
            .vp-venue-calibration, .vp-venue-render-servers, .vp-venue-3d-engine,
            .vp-venue-broadcast, .vp-production-supervisor, .vp-production-certificates,
            .vp-production-venue-status {
                margin-bottom: 15px;
                padding-bottom: 8px;
                border-bottom: 1px solid #ddd;
            }
            
            .vp-venue-details h3, .vp-production-details h3, .vp-manufacturer-details h3,
            .vp-rental-details h3, .vp-specialist-details h3 {
                margin-bottom: 8px;
                margin-top: 10px;
                font-weight: bold;
                font-size: 18px;
                color: #333;
            }
            
            .vp-venue-details p, .vp-production-details p, .vp-manufacturer-details p,
            .vp-rental-details p, .vp-specialist-details p {
                margin-bottom: 2px !important;
                margin-top: 0 !important;
                line-height: 1.4;
            }
            
            /* Переопределяем стандартные отступы темы для entry-content */
            .entry-content .vp-venue-details p, .entry-content .vp-production-details p, 
            .entry-content .vp-manufacturer-details p, .entry-content .vp-rental-details p, 
            .entry-content .vp-specialist-details p {
                margin-bottom: 2px !important;
                margin-top: 0 !important;
            }
            
            /* Убираем отступы сверху у первых элементов в секциях */
            .vp-venue-info p:first-child, .vp-production-venue-status p:first-child {
                margin-top: 0 !important;
                padding-top: 0 !important;
            }
            
            .chromakey-item, .videowall-item, .camera-item, .equipment-item,
            .tracking-item, .calibration-item, .render-server-item {
                margin-bottom: 8px;
                padding: 8px;
                border: 1px solid #eee;
                background: #f9f9f9;
            }
            
            .chromakey-item h4, .videowall-item h4, .camera-item h4 {
                margin-top: 0 !important;
                margin-bottom: 3px;
                font-size: 16px;
                font-weight: bold;
                padding-top: 0 !important;
            }
            
            .chromakey-item > *:first-child, .videowall-item > *:first-child, 
            .camera-item > *:first-child, .equipment-item > *:first-child,
            .tracking-item > *:first-child, .calibration-item > *:first-child, 
            .render-server-item > *:first-child {
                margin-top: 0 !important;
                padding-top: 0 !important;
            }
            
            .chromakey-item p:first-of-type, .videowall-item p:first-of-type, 
            .camera-item p:first-of-type, .equipment-item p:first-of-type,
            .tracking-item p:first-of-type, .calibration-item p:first-of-type, 
            .render-server-item p:first-of-type {
                margin-top: 0 !important;
            }

            .vp-production-certificates h3 a {
                color: #0073aa;
                text-decoration: none;
                border-bottom: 1px dotted #0073aa;
                transition: all 0.3s ease;
            }

            .vp-production-certificates h3 a:hover {
                color: #005a87;
                text-decoration: none;
                border-bottom: 1px solid #005a87;
            }
            
            .dimensions {
                margin: 5px 0;
            }
            
            .dimensions span {
                margin-right: 12px;
                display: inline-block;
                margin-bottom: 2px;
            }
            
            .working-days {
                font-weight: bold;
                font-size: 16px;
            }
            
            .project-types-list, .competencies-list {
                list-style: none;
                padding: 0;
                margin: 8px 0;
            }
            
            .vp-manufacturer-location, .vp-manufacturer-equipment, .vp-manufacturer-services {
                margin-bottom: 15px;
                padding-bottom: 8px;
                border-bottom: 1px solid #ddd;
            }

            .vp-manufacturer-equipment .equipment-item, .vp-manufacturer-services .service-item {
                margin-bottom: 8px;
                padding: 8px;
                border: 1px solid #eee;
                background: #f9f9f9;
            }

            .vp-manufacturer-equipment .equipment-item h4 {
                margin-top: 0 !important;
                margin-bottom: 5px;
                font-size: 16px;
                font-weight: bold;
                color: #333;
                padding-top: 0 !important;
            }

            .vp-manufacturer-equipment .equipment-item p, .vp-manufacturer-services .service-item p {
                margin-bottom: 3px !important;
                line-height: 1.4;
            }

            .vp-manufacturer-equipment .equipment-item > *:first-child, 
            .vp-manufacturer-services .service-item > *:first-child {
                margin-top: 0 !important;
                padding-top: 0 !important;
            }
            
            .project-types-list li, .competencies-list li {
                margin: 3px 0;
                padding: 5px 8px;
                background: #f5f5f5;
                list-style: none;
                border-left: 3px solid #666;
            }
            
            .venue-status-yes, .venue-status-no {
                padding: 6px 10px;
                margin: 5px 0;
                font-weight: bold;
            }
            
            .venue-status-yes {
                background: #e8f5e8;
                border-left: 3px solid #4caf50;
            }
            
            .venue-status-no {
                background: #ffeaea;
                border-left: 3px solid #f44336;
            }

            .custom-config-yes {
                background: #e8f5e8;
                color: #2e7d32;
                padding: 2px 8px;
                border-radius: 3px;
                font-weight: bold;
                font-size: 14px;
            }
            
            .venue-status-yes a {
                color: #2e7d32;
                text-decoration: none;
            }
            
            .venue-status-yes a:hover {
                text-decoration: underline;
            }
            
            .calibration-item p, .chromakey-item p, .videowall-item p, .camera-item p, 
            .equipment-item p, .tracking-item p, .render-server-item p {
                margin-bottom: 3px !important;
                line-height: 1.3;
            }
            
            @media (max-width: 768px) {
                .vp-venue-details, .vp-production-details, .vp-manufacturer-details,
                .vp-rental-details, .vp-specialist-details {
                    padding: 12px;
                    font-size: 14px;
                }
                
                .vp-venue-details h3, .vp-production-details h3, .vp-manufacturer-details h3,
                .vp-rental-details h3, .vp-specialist-details h3 {
                    font-size: 16px;
                }
                
                .dimensions span {
                    display: block;
                    margin-bottom: 5px;
                }
                
                .custom-config-yes {
                font-size: 12px;
                padding: 1px 6px;
                }
            }');
        }
    }
}
?>