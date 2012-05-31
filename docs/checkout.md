# Molpay Checkout

## Table of Contents

- [Introduction](#introduction)
- [Configurations](#configurations)
- [Methods](#methods)

<a name="introduction"></a>
## Introduction

Molpay Checkout invoke a payment request to Molpay Payment Gateway.

	$checkout = Molpay\Checkout::make();
	
	// list of orders/items
	$orders = array(
		array('id' => 5, 'name' => 'Shoe', 'quantity' => 1, 'price' => 5),
		array('id' => 10, 'name' => 'Cloth', 'quantity' => 1, 'price' => 2),
	);
	
	$amounts = 0;
	
	foreach ($orders as $order)
	{
		$amounts += $order['price'];
	}
	
	// The idea is to create an invoice number as your order id, so
	// you can map receipt number as transaction id from Molpay.
	
	$invoice = new Invoice(array(
		'amounts' => $amounts,
		'details' => serialize($orders),
	));
	
	$invoice->save();
	
	// set the amount total
	$checkout->amount   = $amounts;
	$checkout->order_id = $invoice->id;
	$checkout->country  = 'MY';
	
	return $checkout->get();

<a name="configurations"></a>
## Configurations

	$checkout->merchant_id		@ Merchant ID	
	$checkout->verify_key		@ Merchant Verify Key
	$checkout->amount			@ Payment Amount
	$checkout->currency			@ Payment Currency
	$checkout->country          @ Destination Country for delivery
	$checkout->order_id         @ Unique alpha-numeric order id
	$checkout->payment_method   @ Payment method for this checkout
	
	# Optionals
	$checkout->name				@ Buyer Name
	$checkout->email			@ Buyer E-mail Address
	$checkout->mobile			@ Buyer Phone Number
	$checkout->description		@ Description of Payment

### Supported Country

Please refer to <http://www.iso.org/iso/country_codes/iso_3166_code_lists.htm>, and take note that United Kingdom is GB (instead of UK).

<a name="methods"></a>	
## Methods

### make($config = array())

### get()


	