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
