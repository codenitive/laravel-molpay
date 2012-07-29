<?php 

<?php

Event::listen('orchestra.form: extension.molpay', function ($config, $form)
{
	$form->extend(function ($form)
	{
		$form->fieldset('Merchant Information', function ($fieldset)
		{
			$fieldset->control('input:text', 'Merchant ID', 'merchant_id');
			$fieldset->control('input:text', 'Verify Key', 'verify_key');
		});
	});
});
