<?php

/*
|--------------------------------------------------------------------------
| Molpay Bundle Routes
|--------------------------------------------------------------------------
*/

Route::post('(:bundle)/callback', function ()
{
	return Controller::call('molpay::callback@index');
});

Route::post('(:bundle)/push', function ()
{
	return Controller::call('molpay::callback@push');
});