<?php

Autoloader::directories(array(
	Bundle::path('molpay').'libraries',
	Bundle::path('molpay').'models',
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