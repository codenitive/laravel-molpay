<?php

return array(
	/*
	|--------------------------------------------------------------------------
	| MolPay Merchant ID
	|--------------------------------------------------------------------------
	|
	| Insert your MolPay Merchant ID
	*/
	'merchant_id' => null,

	/*
	|--------------------------------------------------------------------------
	| MolPay Merchant Verify Key
	|--------------------------------------------------------------------------
	|
	| Insert your MolPay Merchant Verify Key
	*/
	'verify_key' => null,

	/*
	|--------------------------------------------------------------------------
	| Molpay Default Payment Method
	|--------------------------------------------------------------------------
	|
	| Select default payment method from one of the list below
	*/
	'default_payment_method' => 'visa',

	/*
	|--------------------------------------------------------------------------
	| Molpay Currency
	|--------------------------------------------------------------------------
	|
	| By default, Molpay will use either MYR or USD
	*/
	'currency' => 'MYR',
	
	/*
	|--------------------------------------------------------------------------
	| Payment Methods
	|--------------------------------------------------------------------------
	*/
	'payment_methods' => array(
		'visa'        => 'index',
		'mastercard'  => 'index',
		'mobilemoney' => 'mobilemoney',
		'maybank2u'   => 'maybank2u',
		'fpx'         => 'fpx',
		'cimb'        => 'cimb',
		'eon'         => 'eon',
		'hongleong'   => 'hlb',
		'mepscash'    => 'mepscash',
		'webcash'     => 'webcash',
	);
);