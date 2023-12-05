<?php

defined('BASEPATH') or exit('No direct script access allowed');

$CI = &get_instance();

if (!$CI->db->table_exists(db_prefix() . 'log_wa')) {
    $q = 'CREATE TABLE `' . db_prefix() . 'log_wa`  (
		`id` int(10) NOT NULL AUTO_INCREMENT,
		`isi` text NULL,
		`no_tujuan` varchar(100) NULL,
		`status` varchar(100) NULL,
		`tanggal` varchar(64) NULL,
		`is_proses` integer(10) NULL,
		`created_at` varchar(100) NULL,
		`created_by` varchar(100) NULL,
		`disable` int(1) DEFAULT 0,
		PRIMARY KEY (`id`) USING BTREE
		) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';
		';
    $CI->db->query($q);
}
