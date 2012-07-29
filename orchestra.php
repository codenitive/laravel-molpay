<?php

Orchestra\Extension\Config::map('molpay', array(
	'merchant_id' => 'molpay::api.merchant_id',
	'verify_key'  => 'molpay::api.verify_key',
));

include_once Bundle::path('molpay').'orchestra'.DS.'configure'.EXT;