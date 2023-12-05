<?php

defined('BASEPATH') or exit('No direct script access allowed');
/*
Module Name: WhatsApp
Description: Send notification to client or leads via WhatsApp
Version: 1.0.0
Requires at least: 2.7.*
Author: Arya Dwi Putra
Author URI: https://aryadwiputra.com
*/

define('WHATSAPP_MODULE_NAME', 'whatsapp');

$CI = &get_instance();

/**
 * Load the module helper
 */
$CI->load->helper(WHATSAPP_MODULE_NAME . '/whatsapp');

/**
 * Register activation module hook
 */
register_activation_hook(WHATSAPP_MODULE_NAME, 'whatsapp_activation_hook');


function whatsapp_activation_hook()
{
    $CI = &get_instance();
    require_once(__DIR__ . '/install.php');
}

/**
 * Register deactivation module hook
 */
register_deactivation_hook(WHATSAPP_MODULE_NAME, 'whatsapp_deactivation_hook');


function whatsapp_deactivation_hook()
{
    $CI = &get_instance();
    require_once(__DIR__ . '/deactivate.php');
}

/**
 * Add additional settings for this module in the module list area
 * @param  array $actions current actions
 * @return array
 */

hooks()->add_filter('module_whatsapp_action_links', 'whatsapp_action_links');

function whatsapp_action_links($actions)
{
    $actions[] = '<a href="' . admin_url('whatsapp') . '">' . _l('settings') . '</a>';

    return $actions;
}

/**
 * After client added
 * @param  int $id client id
 */

hooks()->add_action('after_client_added', 'whatsapp_after_client_added');

function whatsapp_after_client_added()
{
}

/**
 * After invoice added
 * @param  int $id invoice id
 */

hooks()->add_action('after_invoice_added', 'whatsapp_after_invoice_add');

function whatsapp_after_invoice_add($id)
{
    $CI = &get_instance();

    $CI->load->helper('sales');

    $CI->db->select('clientid,duedate,total,number, hash');
    $CI->db->from('tblinvoices');
    $CI->db->where('id', $id);
    $invoice = $CI->db->get()->result_array();

    $CI->db->select('phonenumber, company');
    $CI->db->from('tblclients');
    $CI->db->where('userid', $invoice[0]['clientid']);
    $client = $CI->db->get()->result_array();

    $urlInvoice = site_url('invoice/' . $id . '/' . $invoice[0]['hash']);

    sendTemplateInvoice($receiver = $client[0]['phonenumber'], $invoiceId = $id, $companyName = $client[0]['company'], $invoiceNumber = $invoice[0]['number'], $invoiceLink = $urlInvoice, $invoiceTotal = app_format_money($invoice[0]['total'], 'Rp. '), $invoiceDueDate = $invoice[0]['duedate']);
}

/**
 * After payment added
 * @param  int $id payment id
 */

hooks()->add_action('after_payment_added', 'whatsapp_after_payment_add');

function whatsapp_after_payment_add($id)
{
    $CI = &get_instance();

    // Cek apakah payment sudah terbayar
    $payment = $CI->db->select('*')
        ->from('tblinvoicepaymentrecords')
        ->where('id', $id)
        ->get()
        ->result_array();

    // Ambil data dari tabel invoices berdasarkan pembayaran
    $invoice = $CI->db->select('*')
        ->from('tblinvoices')
        ->where('id', $payment[0]['invoiceid'])
        ->get()
        ->result_array();

    if ($invoice[0]['status'] == 2) {
        // Ambil data dari tabel clients berdasarkan invoice
        $client = $CI->db->select('*')
            ->from('tblclients')
            ->where('userid', $invoice[0]['clientid'])
            ->get()
            ->result_array();

        sendTemplatePaymentSuccess($client[0]['phonenumber'], $invoice[0]['id'], $client[0]['company'], $invoice[0]['prefix'] . $invoice[0]['id'], site_url('invoice/' . $invoice[0]['id'] . '/' . $invoice[0]['hash']), app_format_money($invoice[0]['total'], 'Rp. '));
    }
}

/**
 * Send invoice to client via WhatsApp
 * @param  int $id invoice id
 */

hooks()->add_action('invoice_sent', 'whatsapp_agetway_invoice_sent');

function whatsapp_agetway_invoice_sent($id)
{
    $CI = &get_instance();

    $invoice = $CI->db->select('*,tblinvoices.id as invoiceid')
        ->from('tblinvoices')
        ->join('tblclients', 'tblclients.userid = tblinvoices.clientid')
        ->where('tblinvoices.id', $id)
        ->get()
        ->result_array();

    foreach ($invoice as $invoice) {
        $invoiceId = $invoice['invoiceid'];
        $companyName = $invoice['company'];
        $receiver = $invoice['phonenumber'];
        $hash = $invoice['hash'];
        $invoiceTotal = $invoice['total'];

        sendTemplateInvoice($receiver, $invoiceId, $companyName, $invoice['prefix']  . $invoice['number'], site_url('invoice/' . $invoiceId . '/' . $hash), app_format_money($invoiceTotal, 'Rp. '), _d($invoice['duedate']));
    }
}


// init module menu items in setup in admin_init hook
hooks()->add_action('admin_init', 'whatsapp_permission');

function whatsapp_permission()
{
    $capabilities = [];

    $capabilities['capabilities'] = [
        'setting' => _l('Setting WhatsApp Gateway'),
        // 'edit'   => _l('permission_edit'),
        // 'delete' => _l('permission_delete'),
    ];
    register_staff_capabilities('whatsapp', $capabilities, _l('Setting WhatsApp Gateway'));
}

/**
 * Actions for inject the custom styles
 */

hooks()->add_action('admin_init', 'whatsapp_init_admin_menu_items');

function whatsapp_init_admin_menu_items()
{
    $CI = &get_instance();
    if (is_admin() || has_permission('whatsapp')) {
        $CI = &get_instance();
        /**
         * If the logged in user is administrator, add custom menu in Setup
         */
        $CI->app_menu->add_setup_menu_item(
            'whatsapp',
            [
                'href'     => admin_url('whatsapp/settings'),
                'name'     => _l('Setting WhatsApp'),
                'position' => 60,
            ]
        );

        $CI->app_menu->add_sidebar_menu_item('whatsapp', [
            'name'     => 'Whatsapp', // The name if the item
            'collapse' => true, // Indicates that this item will have submitems
            'position' => 30, // The menu position
            'icon'     => 'fa-solid fa-phone menu-icon', // The icon to use
        ]);

        $CI->app_menu->add_sidebar_children_item('whatsapp', [
            'slug'     => 'whatsapp', // The slug of the item
            'name'     => 'Template', // The name if the item
            'href'     => admin_url('whatsapp/template'), // The url of the item
            'position' => 1, // The menu position
        ]);
    }
}
