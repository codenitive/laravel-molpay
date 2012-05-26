<?php

/*
|--------------------------------------------------------------------------
| Molpay Bundle Routes
|--------------------------------------------------------------------------
*/

Request::post('(:bundle)/callback', function ()
{
	Controller::call('molpay::callback@index');
});

Request::post('(:bundle)/push', function ()
{
	return Controller::call('molpay::callback@push');
});