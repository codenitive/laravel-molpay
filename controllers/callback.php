<?php

use \Input, \Event, Molpay\Transaction;

class Molpay_Callback_Controller extends Controller
{
	protected $input = null;

	/**
	 * Initalize the Callback Controller
	 *
	 * @access  public
	 * @return  void
	 */
	public function __construct()
	{
		$input = Input::all();
		$input['order_id'] = $input['orderid'];

		$this->input = $input;
	}

	/**
	 * Used as Molpay Return URL callback
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_index() 
	{
		$input = $this->input;

		// verify origin of transaction using the hash
		$this->validation();

		// save the transaction
		$molpay = $this->save();

		switch ($input['status'])
		{
			case '00' :
				// payment is made
				Event::fire('molpay.checkout.paid', array($input['order_id']));
				break;

			case '11' :
				Event::fire('molpay.checkout.failed', array($input['order_id']));
				break;

			case '22' :
				Event::fire('molpay.checkout.pending', array($input['order_id']));
				break;
		}

		if (Event::listeners('molpay.response.return_url'))
		{
			$response = Event::until('molpay.response.return_url', array($molpay));

			if ( ! is_null($response)) return $response;
		}

		return Response::make('', 200);
	}

	/**
	 * Used as Molpay callback query beta-1 (PUSH Notification)
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_push() 
	{
		$input = $this->input;

		// only accept molpay callback query
		if ($input['nbcb'] != '1')
		{
			throw new Exception("Not a valid Molpay Callback Query");
		}

		// verify origin of transaction using the hash
		$this->validation();

		// save the transaction
		$molpay = $this->save();

		switch ($input['status'])
		{
			case '00' :
				// payment is made
				Event::fire('molpay.checkout.paid', array($input['order_id']));
				break;

			case '11' :
				Event::fire('molpay.checkout.failed', array($input['order_id']));
				break;

			case '22' :
				Event::fire('molpay.checkout.pending', array($input['order_id']));
				break;
		}

		if (Event::listeners('molpay.response.callback'))
		{
			$response = Event::until('molpay.response.callback', array($molpay));

			if ( ! is_null($response)) return $response;
		}

		return Response::make('', 200);
	}

	/**
	 * Save all payment transaction
	 *
	 * @access  protected
	 * @return  Eloquent
	 */
	protected function save()
	{
		$input = $this->input;

		// check for transaction id.
		$molpay = Transaction::where('transaction_id', '=', $input['tranID'])->first();

		if (is_null($molpay))
		{
			$molpay = new Transaction(array(
				'transaction_id' => $input['tranID'],
			));
		}

		$molpay->amount       = $input['amount'];
		$molpay->domain       = $input['domain'];
		$molpay->app_code     = $input['appcode'];
		$molpay->order_id     = $input['order_id'];
		$molpay->channel      = $input['channel'];
		$molpay->status       = $input['status'];
		$molpay->currency     = $input['currency'];
		$molpay->paid_at      = $input['paydate'];
		$molpay->security_key = $input['skey'];

		if ('00' !== $input['status'])
		{
			$input['error_code'] and $molpay->error_code = $input['error_code'];
			$input['error_desc'] and $molpay->error_description = $input['error_desc'];
		}

		$molpay->save();
		
		return $molpay;
	}

	/**
	 * Validate hash to ensure that the request actually came from Molpay
	 *
	 * @access  protected
	 * @return  void
	 * @throws  Molpay\Exception
	 */
	protected function validation()
	{
		extract($this->input);

		$vkey    = Config::get('molpay::api.verify_key', '');
		$confirm = md5($paydate.$domain.md5($tranID.$orderid.$status.$domain.$amount.$currency).$appcode.$vkey);

		if ($skey !== $confirm)
		{
			throw new Exception("Invalid Transaction Key");
		}

	}

}