<?php

defined('BASEPATH') or exit('No direct script access allowed');

$CI = &get_instance();

if (!$CI->db->table_exists(db_prefix() . 'follow_up')) {
    $q = 'CREATE TABLE `' . db_prefix() . 'follow_up`  (
        `id` int(10) NOT NULL AUTO_INCREMENT,
        `name` varchar(255) NULL,
        PRIMARY KEY (`id`) USING BTREE
    ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
    ';
    $CI->db->query($q);

    // Insert 5 data ke dalam tabel follow_up
    $insertData = array(
        array('name' => 'Data 1'),
        array('name' => 'Data 2'),
        array('name' => 'Data 3'),
        array('name' => 'Data 4'),
        array('name' => 'Data 5'),
    );

    $CI->db->insert_batch(db_prefix() . 'follow_up', $insertData);
}
