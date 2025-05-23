<?php
/**
 * Plugin Name: Virtual Production Type Varya LLC
 * Plugin URI: https://github.com/ReunionRS/Custom-type-for-Virtual-Production
 * Description: Кастомные типы записей для портала Vprussia
 * Version: 1.0.0
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
            'name'    => __('Адрес расположения', 'vp-types'),
            'id'      => 'vp_venue_address',
            'type'    => 'text',
            'desc'    => __('Полный адрес площадки', 'vp-types'),
        ));
        
        $venue_metabox->add_field(array(
            'name'    => __('Размер площадки (кв.м)', 'vp-types'),
            'id'      => 'vp_venue_size',
            'type'    => 'text',
            'desc'    => __('Площадь помещения в квадратных метрах', 'vp-types'),
        ));
        
        $venue_metabox->add_field(array(
            'name'    => __('Режим работы', 'vp-types'),
            'id'      => 'vp_venue_working_hours',
            'type'    => 'textarea_small',
            'desc'    => __('Часы работы площадки', 'vp-types'),
        ));
        
        $venue_equipment_group = $venue_metabox->add_field(array(
            'id'          => 'vp_venue_equipment',
            'type'        => 'group',
            'description' => __('Техническое оснащение площадки', 'vp-types'),
            'options'     => array(
                'group_title'   => __('Оснащение {#}', 'vp-types'),
                'add_button'    => __('Добавить оснащение', 'vp-types'),
                'remove_button' => __('Удалить', 'vp-types'),
                'sortable'      => true,
            ),
        ));
        
        $venue_metabox->add_group_field($venue_equipment_group, array(
            'name'    => __('Тип оснащения', 'vp-types'),
            'id'      => 'type',
            'type'    => 'select',
            'options' => array(
                'chromakey'      => __('Хромакей', 'vp-types'),
                'videowall'      => __('Видеостена', 'vp-types'),
                'other'          => __('Другое', 'vp-types'),
            ),
        ));

        $venue_metabox->add_group_field($venue_equipment_group, array(
            'name'    => __('Название оснащения', 'vp-types'),
            'id'      => 'other_name',
            'type'    => 'text',
            'attributes' => array(
            'data-conditional-id'    => '{#}type',
            'data-conditional-value' => 'other',
            ),
        ));
        
        $venue_metabox->add_group_field($venue_equipment_group, array(
            'name'    => __('Описание', 'vp-types'),
            'id'      => 'description',
            'type'    => 'textarea_small',
        ));
        
        $venue_metabox->add_group_field($venue_equipment_group, array(
            'name'    => __('Площадь видеостены (кв.м)', 'vp-types'),
            'id'      => 'videowall_size',
            'type'    => 'text',
            'attributes' => array(
                'data-conditional-id'    => '{#}type',
                'data-conditional-value' => 'videowall',
            ),
        ));
        
        $venue_metabox->add_group_field($venue_equipment_group, array(
            'name'    => __('Зерно (пиксель)', 'vp-types'),
            'id'      => 'videowall_pixel_pitch',
            'type'    => 'text',
            'attributes' => array(
                'data-conditional-id'    => '{#}type',
                'data-conditional-value' => 'videowall',
            ),
        ));
        
        $venue_lighting_group = $venue_metabox->add_field(array(
            'id'          => 'vp_venue_lighting',
            'type'        => 'group',
            'description' => __('Освещение', 'vp-types'),
            'options'     => array(
                'group_title'   => __('Освещение {#}', 'vp-types'),
                'add_button'    => __('Добавить освещение', 'vp-types'),
                'remove_button' => __('Удалить', 'vp-types'),
                'sortable'      => true,
            ),
        ));

        $venue_metabox->add_group_field($venue_lighting_group, array(
            'name'    => __('Название освещения', 'vp-types'),
            'id'      => 'name',
            'type'    => 'text',
        ));
        
        $venue_metabox->add_group_field($venue_lighting_group, array(
            'name'    => __('Мощность', 'vp-types'),
            'id'      => 'power',
            'type'    => 'text',
        ));
        
        $venue_metabox->add_group_field($venue_lighting_group, array(
            'name'    => __('Интеграция с VP трактом', 'vp-types'),
            'id'      => 'vp_integration',
            'type'    => 'checkbox',
        ));
        
        $venue_metabox->add_group_field($venue_lighting_group, array(
            'name'    => __('Описание оборудования', 'vp-types'),
            'id'      => 'equipment_description',
            'type'    => 'textarea_small',
        ));
        
        $video_system_group = $venue_metabox->add_field(array(
            'id'          => 'vp_venue_video_system',
            'type'        => 'group',
            'description' => __('Видеотракт', 'vp-types'),
            'options'     => array(
                'group_title'   => __('Видеотракт', 'vp-types'),
                'add_button'    => __('Добавить компонент', 'vp-types'),
                'remove_button' => __('Удалить', 'vp-types'),
                'sortable'      => true,
            ),
        ));
        
        $venue_metabox->add_group_field($video_system_group, array(
            'name'    => __('Количество видеокамер', 'vp-types'),
            'id'      => 'camera_count',
            'type'    => 'text',
        ));
        
        $venue_metabox->add_group_field($video_system_group, array(
            'name'    => __('Наличие генлока', 'vp-types'),
            'id'      => 'genlock',
            'type'    => 'checkbox',
        ));
        
        $venue_metabox->add_group_field($video_system_group, array(
            'name'    => __('Штативы', 'vp-types'),
            'id'      => 'tripods',
            'type'    => 'textarea_small',
        ));
        
        $venue_metabox->add_field(array(
            'name'    => __('Наличие звукового тракта', 'vp-types'),
            'id'      => 'vp_venue_audio_system',
            'type'    => 'checkbox',
            'desc'    => __('Отметьте, если площадка имеет звуковой тракт', 'vp-types'),
        ));
        
        $venue_metabox->add_field(array(
            'name'    => __('Описание звукового тракта', 'vp-types'),
            'id'      => 'vp_venue_audio_system_desc',
            'type'    => 'textarea_small',
            'attributes' => array(
                'data-conditional-id'    => 'vp_venue_audio_system',
                'data-conditional-value' => 'on',
            ),
        ));
        
        $vp_system_group = $venue_metabox->add_field(array(
            'id'          => 'vp_venue_vp_system',
            'type'        => 'group',
            'description' => __('VP тракт', 'vp-types'),
            'options'     => array(
                'group_title'   => __('VP система {#}', 'vp-types'),
                'add_button'    => __('Добавить компонент VP тракта', 'vp-types'),
                'remove_button' => __('Удалить', 'vp-types'),
                'sortable'      => true,
            ),
        ));
        
        $venue_metabox->add_group_field($vp_system_group, array(
            'name'    => __('Системы трекинга', 'vp-types'),
            'id'      => 'tracking_systems',
            'type'    => 'textarea_small',
        ));
        
        $venue_metabox->add_group_field($vp_system_group, array(
            'name'    => __('Рендер-сервера', 'vp-types'),
            'id'      => 'render_servers',
            'type'    => 'textarea_small',
        ));
        
        $venue_metabox->add_group_field($vp_system_group, array(
            'name'    => __('3D движок', 'vp-types'),
            'id'      => 'game_engine',
            'type'    => 'text',
        ));
        
        $venue_metabox->add_field(array(
            'name'    => __('Возможности трансляции', 'vp-types'),
            'id'      => 'vp_venue_broadcast',
            'type'    => 'textarea_small',
            'desc'    => __('Информация о возможностях трансляции с площадки', 'vp-types'),
        ));
        
        $production_metabox = new_cmb2_box(array(
            'id'            => 'vp_production_metabox',
            'title'         => __('Характеристики продакшена', 'vp-types'),
            'object_types'  => array('vp_production'),
            'context'       => 'normal',
            'priority'      => 'high',
            'show_names'    => true,
        ));
        
        $projects_group = $production_metabox->add_field(array(
            'id'          => 'vp_production_projects',
            'type'        => 'group',
            'description' => __('Проекты', 'vp-types'),
            'options'     => array(
                'group_title'   => __('Проект {#}', 'vp-types'),
                'add_button'    => __('Добавить проект', 'vp-types'),
                'remove_button' => __('Удалить', 'vp-types'),
                'sortable'      => true,
            ),
        ));
        
        $production_metabox->add_group_field($projects_group, array(
            'name'    => __('Название проекта', 'vp-types'),
            'id'      => 'name',
            'type'    => 'text',
        ));
        
        $production_metabox->add_group_field($projects_group, array(
            'name'    => __('Тип проекта', 'vp-types'),
            'id'      => 'type',
            'type'    => 'select',
            'options' => array(
                'movie'          => __('Полный метр', 'vp-types'),
                'music_video'    => __('Клип', 'vp-types'),
                'commercial'     => __('Реклама', 'vp-types'),
                'sports'         => __('Спортивные трансляции', 'vp-types'),
                'events'         => __('Съемка мероприятий', 'vp-types'),
                'mocap'          => __('Макап анимация', 'vp-types'),
                'corporate'      => __('Корпоративное видео', 'vp-types'),
                'education'      => __('Образовательный контент', 'vp-types'),
                'other'          => __('Другое', 'vp-types'),
            ),
        ));
        
        $production_metabox->add_group_field($projects_group, array(
            'name'    => __('Описание проекта', 'vp-types'),
            'id'      => 'description',
            'type'    => 'textarea_small',
        ));
        
        $production_metabox->add_field(array(
            'name'          => __('Детали компетенций', 'vp-types'),
            'id'            => 'vp_production_competency_details',
            'type'          => 'textarea',
            'desc'          => __('Дополнительная информация о компетенциях компании', 'vp-types'),
        ));
        
        $production_metabox->add_field(array(
            'name'    => __('Используемое ПО для монтажа', 'vp-types'),
            'id'      => 'vp_production_software',
            'type'    => 'text',
        ));
        
        $production_metabox->add_field(array(
            'name'    => __('Наличие операторов', 'vp-types'),
            'id'      => 'vp_production_has_operators',
            'type'    => 'checkbox',
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
            'name'    => __('Описание продукции', 'vp-types'),
            'id'      => 'vp_manufacturer_products_description',
            'type'    => 'textarea',
            'desc'    => __('Описание продукции, связанной с VP', 'vp-types'),
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
            $output .= '<div class="vp-venue-size"><strong>' . __('Размер площадки:', 'vp-types') . '</strong> ' . $size . ' кв.м</div>';
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
        $output .= '<div class="vp-service-price">' . $product->get_price_html() . '</div>';
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
            return $content . $custom_content;
        }
        
        return $content;
    }
    
    public function bunyad_custom_content() {
        global $post;
        
        $vp_post_types = array('vp_venue', 'vp_production', 'vp_manufacturer', 'vp_rental', 'vp_specialist');
        
        if (in_array($post->post_type, $vp_post_types)) {
            echo $this->get_vp_custom_content($post);
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
    
    private function display_venue_content($post) {
    ?>
    <div class="vp-venue-details">
        <?php
        $address = get_post_meta($post->ID, 'vp_venue_address', true);
        $size = get_post_meta($post->ID, 'vp_venue_size', true);
        $working_hours = get_post_meta($post->ID, 'vp_venue_working_hours', true);
        $equipment = get_post_meta($post->ID, 'vp_venue_equipment', true);
        $lighting = get_post_meta($post->ID, 'vp_venue_lighting', true);
        $video_system = get_post_meta($post->ID, 'vp_venue_video_system', true);
        $audio_system = get_post_meta($post->ID, 'vp_venue_audio_system', true);
        $audio_system_desc = get_post_meta($post->ID, 'vp_venue_audio_system_desc', true);
        $vp_system = get_post_meta($post->ID, 'vp_venue_vp_system', true);
        $broadcast = get_post_meta($post->ID, 'vp_venue_broadcast', true);
        ?>
        
        <?php if ($address): ?>
            <div class="vp-venue-info">
                <h3><?php _e('Адрес', 'vp-types'); ?></h3>
                <p><?php echo esc_html($address); ?></p>
            </div>
        <?php endif; ?>
        
        <?php if ($size): ?>
            <div class="vp-venue-info">
                <h3><?php _e('Размер площадки', 'vp-types'); ?></h3>
                <p><?php echo esc_html($size); ?> кв.м</p>
            </div>
        <?php endif; ?>
        
        <?php if ($working_hours): ?>
            <div class="vp-venue-info">
                <h3><?php _e('Режим работы', 'vp-types'); ?></h3>
                <p><?php echo nl2br(esc_html($working_hours)); ?></p>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($equipment)): ?>
            <div class="vp-venue-equipment">
                <h3><?php _e('Техническое оснащение', 'vp-types'); ?></h3>
                <?php foreach ($equipment as $item): ?>
                    <div class="equipment-item">
                        <h4><?php 
                            $type = $item['type'];
                            $type_labels = array(
                                'chromakey' => 'Хромакей',
                                'videowall' => 'Видеостена',
                                'other' => isset($item['other_name']) && !empty($item['other_name']) ? 
                                    esc_html($item['other_name']) : 'Другое'
                            );
                            echo isset($type_labels[$type]) ? $type_labels[$type] : $type;
                        ?></h4>
                        <?php if (!empty($item['description'])): ?>
                            <p><?php echo esc_html($item['description']); ?></p>
                        <?php endif; ?>
                        <?php if ($type === 'videowall' && !empty($item['videowall_size'])): ?>
                            <p><strong>Площадь видеостены:</strong> <?php echo esc_html($item['videowall_size']); ?> кв.м</p>
                        <?php endif; ?>
                        <?php if ($type === 'videowall' && !empty($item['videowall_pixel_pitch'])): ?>
                            <p><strong>Зерно (пиксель):</strong> <?php echo esc_html($item['videowall_pixel_pitch']); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($lighting)): ?>
            <div class="vp-venue-lighting">
                <h3><?php _e('Освещение', 'vp-types'); ?></h3>
                <?php foreach ($lighting as $item): ?>
                    <div class="lighting-item">
                        <?php if (!empty($item['name'])): ?>
                            <h4><?php echo esc_html($item['name']); ?></h4>
                        <?php endif; ?>
                        <?php if (!empty($item['power'])): ?>
                            <p><strong><?php _e('Мощность:', 'vp-types'); ?></strong> <?php echo esc_html($item['power']); ?></p>
                        <?php endif; ?>
                        <?php if (!empty($item['vp_integration'])): ?>
                            <p><strong><?php _e('Интеграция с VP трактом:', 'vp-types'); ?></strong> <?php _e('Да', 'vp-types'); ?></p>
                        <?php endif; ?>
                        <?php if (!empty($item['equipment_description'])): ?>
                            <p><?php echo esc_html($item['equipment_description']); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($video_system)): ?>
            <div class="vp-venue-video-system">
                <h3><?php _e('Видеотракт', 'vp-types'); ?></h3>
                <?php foreach ($video_system as $item): ?>
                    <div class="video-system-item">
                        <?php if (!empty($item['camera_count'])): ?>
                            <p><strong>Количество видеокамер:</strong> <?php echo esc_html($item['camera_count']); ?></p>
                        <?php endif; ?>
                        <?php if (!empty($item['genlock'])): ?>
                            <p><strong>Наличие генлока:</strong> Да</p>
                        <?php endif; ?>
                        <?php if (!empty($item['tripods'])): ?>
                            <p><strong>Штативы:</strong> <?php echo esc_html($item['tripods']); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($audio_system)): ?>
            <div class="vp-venue-audio-system">
                <h3><?php _e('Звуковой тракт', 'vp-types'); ?></h3>
                <?php if (!empty($audio_system_desc)): ?>
                    <p><?php echo nl2br(esc_html($audio_system_desc)); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($vp_system)): ?>
            <div class="vp-venue-vp-system">
                <h3><?php _e('VP тракт', 'vp-types'); ?></h3>
                <?php foreach ($vp_system as $item): ?>
                    <div class="vp-system-item">
                        <?php if (!empty($item['tracking_systems'])): ?>
                            <p><strong>Системы трекинга:</strong> <?php echo esc_html($item['tracking_systems']); ?></p>
                        <?php endif; ?>
                        <?php if (!empty($item['render_servers'])): ?>
                            <p><strong>Рендер-сервера:</strong> <?php echo esc_html($item['render_servers']); ?></p>
                        <?php endif; ?>
                        <?php if (!empty($item['game_engine'])): ?>
                            <p><strong>3D движок:</strong> <?php echo esc_html($item['game_engine']); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($broadcast)): ?>
            <div class="vp-venue-broadcast">
                <h3><?php _e('Возможности трансляции', 'vp-types'); ?></h3>
                <p><?php echo nl2br(esc_html($broadcast)); ?></p>
            </div>
        <?php endif; ?>
    </div>
    <?php
}
    

    private function display_production_content($post) {
    ?>
    <div class="vp-production-details">
        <?php
        $projects = get_post_meta($post->ID, 'vp_production_projects', true);
        $competency_details = get_post_meta($post->ID, 'vp_production_competency_details', true);
        $software = get_post_meta($post->ID, 'vp_production_software', true);
        $has_operators = get_post_meta($post->ID, 'vp_production_has_operators', true);
        
        
        $project_type_labels = array(
            'movie'          => __('Полный метр', 'vp-types'),
            'music_video'    => __('Клип', 'vp-types'),
            'commercial'     => __('Реклама', 'vp-types'),
            'sports'         => __('Спортивные трансляции', 'vp-types'),
            'events'         => __('Съемка мероприятий', 'vp-types'),
            'mocap'          => __('Мокап анимация', 'vp-types'),
            'corporate'      => __('Корпоративное видео', 'vp-types'),
            'education'      => __('Образовательный контент', 'vp-types'),
            'other'          => __('Другое', 'vp-types'),
        );
        ?>
        
        <?php if (!empty($projects)): ?>
            <div class="vp-production-projects">
                <h3><?php _e('Проекты', 'vp-types'); ?></h3>
                <?php foreach ($projects as $index => $project): ?>
                    <div class="vp-project-accordion">
                        <input type="checkbox" id="project-<?php echo $index; ?>" class="vp-project-toggle">
                        <label for="project-<?php echo $index; ?>" class="vp-project-title">
                            <?php echo esc_html($project['name']); ?>
                            <span class="vp-project-type">
                                (<?php echo isset($project_type_labels[$project['type']]) ? 
                                    $project_type_labels[$project['type']] : 
                                    esc_html($project['type']); ?>)
                            </span>
                        </label>
                        <div class="vp-project-content">
                            <?php if (!empty($project['description'])): ?>
                                <div class="vp-project-description">
                                    <?php echo wpautop(esc_html($project['description'])); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <?php if ($competency_details): ?>
            <div class="vp-production-competencies">
                <h3><?php _e('Детали компетенций', 'vp-types'); ?></h3>
                <p><?php echo nl2br(esc_html($competency_details)); ?></p>
            </div>
        <?php endif; ?>
        
        <?php if ($software): ?>
            <div class="vp-production-software">
                <h3><?php _e('Используемое ПО', 'vp-types'); ?></h3>
                <p><?php echo esc_html($software); ?></p>
            </div>
        <?php endif; ?>
        
        <?php if ($has_operators): ?>
            <div class="vp-production-operators">
                <h3><?php _e('Операторы', 'vp-types'); ?></h3>
                <p><?php _e('Компания имеет собственных операторов', 'vp-types'); ?></p>
            </div>
        <?php endif; ?>
    </div>
    <?php
}
    
    private function display_manufacturer_content($post) {
        ?>
        <div class="vp-manufacturer-details">
            <?php
            $products_description = get_post_meta($post->ID, 'vp_manufacturer_products_description', true);
            ?>
            
            <?php if ($products_description): ?>
                <div class="vp-manufacturer-products">
                    <h3><?php _e('Описание продукции', 'vp-types'); ?></h3>
                    <p><?php echo nl2br(esc_html($products_description)); ?></p>
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
    
    /**
     * Все стили для фронта
     */
    public function enqueue_vp_styles() {
        global $post;
        
        $vp_post_types = array('vp_venue', 'vp_production', 'vp_manufacturer', 'vp_rental', 'vp_specialist');
        
        if (is_single() && isset($post->post_type) && in_array($post->post_type, $vp_post_types)) {
            wp_add_inline_style('wp-block-library', '
            .vp-venue-details, .vp-production-details, .vp-manufacturer-details, 
            .vp-rental-details, .vp-specialist-details {
                border-radius: 5px;
                background: #fff;
                font-size:1.3rem;
            }
            .vp-venue-info, .vp-production-projects, .vp-production-competencies,
            .vp-manufacturer-products, .vp-rental-conditions, .vp-specialist-position,
            .vp-venue-equipment, .vp-venue-lighting, .vp-venue-video-system,
            .vp-venue-audio-system, .vp-venue-vp-system, .vp-venue-broadcast {
                margin-bottom: 0px;
                border-bottom: 1px solid #eee;
            }
            .vp-venue-details h3, .vp-production-details h3, .vp-manufacturer-details h3,
            .vp-rental-details h3, .vp-specialist-details h3 {
                color: #333;
                margin-bottom: 10px;
            }
            .equipment-item, .project-item, .lighting-item, 
            .video-system-item, .vp-system-item {
                margin-bottom: 15px;
                padding: 10px;
                background: #f9f9f9;
                border-radius: 3px;
            }
            .equipment-item h4, .project-item h4 {
                margin-top: 0;
                color: #444;
            }
            .vp-production-details {
                margin: 20px 0;
                padding: 20px;
                border-radius: 5px;
            }

            .vp-production-projects,
            .vp-production-competencies,
            .vp-production-software,
            .vp-production-operators {
                margin-bottom: 20px;
                padding-bottom: 20px;
                border-bottom: 1px solid #eee;
            }

            .project-item {
                margin-bottom: 15px;
                padding: 15px;
                background: #fff;
                border-radius: 3px;
                box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            }
            .vp-project-accordion {
                margin-bottom: 15px;
            }
            
            .vp-project-toggle {
                display: none;
            }
            
            .vp-project-title {
                display: block;
                padding: 12px 15px;
                background: #f5f5f5;
                color: #333;
                cursor: pointer;
                border-radius: 3px;
                transition: all 0.3s ease;
                border-left: 4px solid #7f96ff;
                font-weight: 600;
            }
            
            .vp-project-title:hover {
                background: #e9e9e9;
            }
            
            .vp-project-type {
                color: #7f8c8d;
                font-weight: normal;
                font-size: 0.9em;
            }
            
            .vp-project-content {
                display: none;
                padding: 15px;
                background: #fafafa;
                border-left: 4px solid #bdc3c7;
                margin-top: 5px;
                border-radius: 0 0 3px 3px;
            }
            
            .vp-project-toggle:checked ~ .vp-project-content {
                display: block;
            }
            
            .vp-project-toggle:checked + .vp-project-title {
                background: #2c3e50;
                color: #fff;
                border-radius: 3px 3px 0 0;
            }
            
            .vp-project-toggle:checked + .vp-project-title .vp-project-type {
                color: #ecf0f1;
            }
            
            .vp-project-description {
                line-height: 1.6;
            }
            
            
            .vp-production-competencies,
            .vp-production-software,
            .vp-production-operators {
                margin-bottom: 20px;
                padding-bottom: 20px;
                border-bottom: 1px solid #eee;
            }

            .lighting-item h4 {
                margin-top: 0;
                margin-bottom: 10px;
                color: #2c3e50;
                font-size: 1.1em;
            }
            
            .lighting-item p {
                margin: 5px 0;
                line-height: 1.5;
            }
            
            .lighting-item p strong {
                color: #34495e;
            }
            ');
        }
    }
}