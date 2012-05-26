<?php

Autoloader::map(array(
	'Molpay\\Checkout'           => Bundle::path('molpay').'classes/checkout'.EXT;
	'Molpay\\Exception'          => Bundle::path('molpay').'classes/exception'.EXT;
	'Molpay\\Model\\Transaction' => Bundle::path('molpay').'classes/models/transaction'.EXT,
));


/*
|--------------------------------------------------------------------------
| On Payment Received
|--------------------------------------------------------------------------
|
| Trigger an event when payment is made by client.
|
*/
Event::listen('molpay.checkout.paid', function ($order_id) 
{
	// Transaction paid and done.
});

/*
|--------------------------------------------------------------------------
| On Payment Failed
|--------------------------------------------------------------------------
|
| Trigger an event when payment is marked as failed.
|
*/
Event::listen('molpay.checkout.failed', function ($order_id, $status) 
{
	// Transaction is failed
});

/*
|--------------------------------------------------------------------------
| On Payment Pending
|--------------------------------------------------------------------------
|
| Trigger an event when payment is marked as pending.
|
*/
Event::listen('molpay.checkout.pending', function ($order_id, $status) 
{
	// Transaction is pending
});