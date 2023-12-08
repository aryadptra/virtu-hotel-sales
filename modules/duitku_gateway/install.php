<?php

defined('BASEPATH') or exit('No direct script access allowed');

$CI = &get_instance();

if (!$CI->db->table_exists(db_prefix() . 'duitku_payment_methods')) {
    $q = 'CREATE TABLE `' . db_prefix() . 'duitku_payment_methods`  (
        `id` int(10) NOT NULL AUTO_INCREMENT,
        `payment_method` varchar(50) NOT NULL,
        `payment_name` varchar(100) NOT NULL,
        `payment_image` varchar(255) NOT NULL,
        `total_fee` decimal(10,2) NOT NULL,
        PRIMARY KEY (`id`) USING BTREE
    ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';';

    $CI->db->query($q);
}


if (!$CI->db->table_exists(db_prefix() . 'duitku_transactions')) {
    $q = 'CREATE TABLE `' . db_prefix() . 'duitku_transactions`  (
        `id` int(10) NOT NULL AUTO_INCREMENT,
        `merchant_code` varchar(50) NOT NULL,
        `reference` varchar(255) NOT NULL,
        `payment_url` varchar(255) NOT NULL,
        `va_number` varchar(255) NOT NULL,
        `amount` varchar(255) NOT NULL,
        `status_code` varchar(255) NOT NULL,
        `status_message` varchar(255) NOT NULL,
        PRIMARY KEY (`id`) USING BTREE
    ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';';

    $CI->db->query($q);
}
