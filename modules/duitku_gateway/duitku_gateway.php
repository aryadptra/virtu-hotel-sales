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
 * Register activation module
 */
register_activation_hook(DUITKU_GATEWAY_MODULE_NAME, 'activation_hook');

function activation_hook()
{
    $CI = &get_instance();
    // require_once(__DIR__ . '/install.php');
}
