<?php
/*
Plugin Name: SpaceAPI Widget
Description: This plugin provides a widget that can display data from a Space API endpoint.
Author: Written by Coredump hackerspace in Switzerland(https://www.coredump.ch).
License: GPL version 2 or later.
*/

// Load Twig template library
require_once 'vendor/Twig/Autoloader.php';
Twig_Autoloader::register();

// Constants
define('PLUGIN_ID', 'space_api_widget');
define('PLUGIN_NAME', 'SpaceAPI Widget');
define('PLUGIN_DOMAIN', 'coredump.ch');
define('WIDGET_DESCRIPTION', 'Display data from a Space API endpoint.');

// Widget class
class SpaceApiWidget extends WP_Widget {

    function __construct() {
        parent::__construct(
            // Base ID of the widget
            PLUGIN_ID,

            // Widget name, appears in the UI
            __(PLUGIN_NAME, PLUGIN_DOMAIN),

            // Widget description
            array('description' => __(WIDGET_DESCRIPTION, PLUGIN_DOMAIN))
        );

        $loader = new Twig_Loader_Filesystem(dirname(__FILE__) . '/templates');
        $this->twig = new Twig_Environment($loader, array(
            'cache' => false,//dirname(__FILE__) . '/cache'
        ));
    }

    // Widget frontend
    public function widget($args, $instance) {
        // Enqueue JavaScript
        wp_enqueue_script(
            'space_api_query',
            plugins_url('/js/spaceapi.js', __FILE__),
            array('jquery')
        );
        wp_localize_script(
            'space_api_query',
            'php_vars',
            $instance
        );

        // Render template
        $template = $this->twig->loadTemplate('widget.html');
        $title = apply_filters('widget_title', $instance['title']);
        echo $template->render(array(
            'title' => $title,
            'args' => $args,
            'instance' => $instance
        ));
    }

    // Widget backend
    public function form($instance) {
        $template = $this->twig->loadTemplate('form.html');
        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = __('Space API Status', PLUGIN_DOMAIN);
        }
        $url = isset($instance['url']) ? $instance['url'] : '';
        echo $template->render(array(
            'title' => array(
                'value' => esc_attr($title),
                'id' => $this->get_field_id('title'),
                'name' => $this->get_field_name('title'),
                'label' => 'Title'
            ),
            'url' => array(
                'value' => esc_attr($url),
                'id' => $this->get_field_id('url'),
                'name' => $this->get_field_name('url'),
                'label' => 'API URL'
            )
        ));
    }
}

// Loading function
function spaceapi_load_widget() {
    register_widget('SpaceApiWidget');
}

add_action('widgets_init', 'spaceapi_load_widget');

?>
