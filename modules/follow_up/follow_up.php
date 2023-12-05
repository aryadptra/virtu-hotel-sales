<?php

defined('BASEPATH') or exit('No direct script access allowed');
/*
Module Name: Follow Up
Description: Default module to folowing up data leads or customers
Version: 1.0.0
Requires at least: 2.7.*
Author: Arya Dwi Putra
Author URI: https://aryadwiputra.com
*/

define('FOLLOW_UP_MODULE_NAME', 'follow_up');

$CI = &get_instance();


/**
 * Register language
 */
register_language_files(FOLLOW_UP_MODULE_NAME, [FOLLOW_UP_MODULE_NAME]);

/**
 * Register activation module hook
 */
register_activation_hook(FOLLOW_UP_MODULE_NAME, 'follow_up_activation_hook');


function follow_up_activation_hook()
{
    $CI = &get_instance();
    require_once(__DIR__ . '/install.php');
}

/**
 * Register deactivation module hook
 */
register_deactivation_hook(FOLLOW_UP_MODULE_NAME, 'follow_up_deactivation_hook');


function follow_up_deactivation_hook()
{
    $CI = &get_instance();
    require_once(__DIR__ . '/deactivate.php');
}

/**
 * Add additional settings for this module in the module list area
 * @param  array $actions current actions
 * @return array
 */

hooks()->add_filter('module_follow_up_action_links', 'follow_up_action_links');

function follow_up_action_links($actions)
{
    $actions[] = '<a href="' . admin_url('follow_up') . '">' . _l('settings') . '</a>';

    return $actions;
}

// init module menu items in setup in admin_init hook
hooks()->add_action('admin_init', 'follow_up_permission');

function follow_up_permission()
{
    $capabilities = [];

    $capabilities['capabilities'] = [
        'setting' => _l('Setting Follow Up'),
        'edit'   => _l('permission_edit'),
    ];
    register_staff_capabilities('follow_up', $capabilities, _l('Setting Follow Up'));
}

/**
 * Actions for inject the custom styles
 */

hooks()->add_action('admin_init', 'follow_up_init_admin_menu_items');

function follow_up_init_admin_menu_items()
{
    $CI = &get_instance();
    if (is_admin() || has_permission('follow_up')) {
        $CI = &get_instance();
        /**
         * If the logged in user is administrator, add custom menu in Setup
         */
        $CI->app_menu->add_setup_menu_item(
            'whatsapp',
            [
                'href'     => admin_url('follow_up/settings'),
                'name'     => _l('Setting Follow Up'),
                'position' => 60,
            ]
        );

        $CI->app_menu->add_sidebar_menu_item('follow_up', [
            'name'     => 'Follow Up', // The name if the item
            'collapse' => true, // Indicates that this item will have submitems
            'position' => 30, // The menu position
            'icon'     => 'fa-solid fa-arrow-up menu-icon', // The icon to use
        ]);

        $CI->app_menu->add_sidebar_children_item('follow_up', [
            'slug'     => 'follow_up', // The slug of the item
            'name'     => 'Leads', // The name if the item
            'href'     => admin_url('follow_up/leads'), // The url of the item
            'position' => 1, // The menu position
        ]);
    }
}