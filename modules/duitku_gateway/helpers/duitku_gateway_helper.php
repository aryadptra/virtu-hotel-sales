<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

function insert_payment_method($paymentMethod, $paymentName, $paymentImage, $totalFee)
{
	$CI = &get_instance();

	// Cek apakah data sudah ada di database berdasarkan paymentMethod
	$existingData = $CI->db->get_where(db_prefix() . 'duitku_payment_methods', array('payment_method' => $paymentMethod))->row();

	// Jika data sudah ada, lakukan update
	if ($existingData) {
		$dataToUpdate = array(
			'payment_name' => $paymentName,
			'payment_image' => $paymentImage,
			'total_fee' => $totalFee
		);

		$CI->db->where('payment_method', $paymentMethod);
		$CI->db->update(db_prefix() . 'duitku_payment_methods', $dataToUpdate);
	} else {
		// Jika data belum ada, lakukan insert
		$dataToInsert = array(
			'payment_method' => $paymentMethod,
			'payment_name' => $paymentName,
			'payment_image' => $paymentImage,
			'total_fee' => $totalFee
		);

		$CI->db->insert(db_prefix() . 'duitku_payment_methods', $dataToInsert);
	}
}
