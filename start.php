<?php

Autoloader::map(array(
	'Molpay\\Checkout'           => Bundle::path('molpay').'classes/checkout'.EXT;
	'Molpay\\Exception'          => Bundle::path('molpay').'classes/exception'.EXT;
	'Molpay\\Model\\Transaction' => Bundle::path('molpay').'classes/models/transaction'.EXT,
));