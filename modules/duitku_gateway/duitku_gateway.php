<?php


defined('BASEPATH') or exit('No direct script access allowed');
/*
Module Name: Duitku
Description: Module Payment Gateway by Arya Dwi Putra
Version: 1.0.0
Requires at least: 2.7.*
*/

define('DUITKU_GATEWAY_MODULE_NAME', 'duitku_gateway');

$CI = &get_instance();

register_payment_gateway('DUITKU_GATEWAY', 'duitku_gateway');

/**
 * Load helper and libraries
 */

$CI->load->helper(DUITKU_GATEWAY_MODULE_NAME . '/duitku_gateway');
$CI->load->library(DUITKU_GATEWAY_MODULE_NAME . '/duitku_gateway');

/**
 * Register activation module
 */
register_activation_hook(DUITKU_GATEWAY_MODULE_NAME, 'activation_hook');

function activation_hook()
{
    $CI = &get_instance();
    require_once(__DIR__ . '/install.php');
}

/**
 * Admin menu items on sidebar
 */

hooks()->add_action('admin_init', 'follow_up_init_admin_menu_items');

function follow_up_init_admin_menu_items()
{
    $CI = &get_instance();
    if (is_admin() || has_permission('duitku')) {
        $CI = &get_instance();
        /**
         * If the logged in user is administrator, add custom menu in Setup
         */
        // $CI->app_menu->add_setup_menu_item(
        //     'duitku',
        //     [
        //         'href'     => admin_url('duitku_gateway/settings'),
        //         'name'     => _l('settings'),
        //         'position' => 60,
        //     ]
        // );

        $CI->app_menu->add_sidebar_menu_item('duitku', [
            'name'     => 'Duitku', // The name if the item
            'collapse' => true, // Indicates that this item will have submitems
            'position' => 30, // The menu position
            'icon'     => 'fa-solid fa-money-check menu-icon', // The icon to use
        ]);

        $CI->app_menu->add_sidebar_children_item('duitku', [
            'slug'     => 'manage', // The slug of the item
            'name'     => 'Manage', // The name if the item
            'href'     => admin_url('duitku_gateway/manage'), // The url of the item
            'position' => 1, // The menu position
        ]);

        $CI->app_menu->add_sidebar_children_item('duitku', [
            'slug'     => 'payment-method', // The slug of the item
            'name'     => 'Payment Method', // The name if the item
            'href'     => admin_url('duitku_gateway/payment_method'), // The url of the item
            'position' => 1, // The menu position
        ]);
    }
}
