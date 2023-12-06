<?php
defined('BASEPATH') or exit('No direct script access allowed');

$CI = &get_instance();

$aColumns = [
    'id',
    'payment_method',
    'payment_name',
    'payment_image',
    'total_fee',
];

$sIndexColumn = 'id';
$sTable       = db_prefix() . 'duitku_payment_methods';

$result = data_tables_init($aColumns, $sIndexColumn, $sTable, [], [], []);

$output  = $result['output'];
$rResult = $result['rResult'];

$no = 1;

foreach ($rResult as $aRow) {
    $row = [];
    for ($i = 0; $i < count($aColumns); $i++) {
        $_data = $aRow[$aColumns[$i]];

        if ($aColumns[$i] == 'id') {
            $_data = $no;
        } elseif ($aColumns[$i] == 'payment_image') {
            $_data =  $aRow[$aColumns[$i]];
            $_data = '<img src="' . $aRow[$aColumns[$i]] . '" style="height:20px">';
        }

        $row[] = $_data;
    }
    $output['aaData'][] = $row;
    $no++;
}
