<?php

defined('BASEPATH') or exit('No direct script access allowed');

$CI = &get_instance();

if (!$CI->db->table_exists(db_prefix() . 'follow_up')) {
    $q = 'CREATE TABLE `' . db_prefix() . 'follow_up`  (
        `id` int(10) NOT NULL AUTO_INCREMENT,
        `reference_id` int(10) NOT NULL,
        `type` varchar(255) NOT NULL,
        `name` varchar(255) NULL,
        PRIMARY KEY (`id`) USING BTREE
    ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ';
    $CI->db->query($q);

    $insertData = array(
        array(
            'reference_id' => '2',
            'type' => 'Leads',
            'name' => 'Data 1 Arya Dwi Putra'
        ),
        array(
            'reference_id' => '3',
            'type' => 'Leads',
            'name' => 'Data 2 Arya Putra Niyuh'
        ),
    );

    $CI->db->insert_batch(db_prefix() . 'follow_up', $insertData);
}
