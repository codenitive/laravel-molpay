<?php namespace Molpay;

use \Config, \Closure, \Redirect, \URL, Hybrid\Curl;

class Checkout
{
	/**
	 * @staticvar MolPay entry URL
	 */
	protected static $url = 'https://www.onlinepayment.com.my/NBepay/pay/%s/%s.php';
	
	/**
	 * Make a new Checkout instance
	 *
	 * @static
	 * @access  public
	 * @return  self
	 */
	public static function make($config = array())
	{
		return new static($config);
	}
	
	/**
	 * Construct a checkout
	 *
	 * @access  protected
	 */
	protected function __construct($config = array())
	{
		$this->config = array_merge($this->config, Config::get('molpay::api', array()));

		if (is_array($config))
		{
			$this->config = array_merge($this->config, $config);
		}
	}
	
	protected $config = array();
	
	/**
	 * Set a configuration
	 *
	 * @access  public
	 * @param   string      $key
	 * @param   mixed       $value
	 */
	public function __set($key, $value)
	{
		if (is_string($key))
		{
			$this->config[$key] = $value;
		}
	}
	
	/**
	 * Get a configuration
	 * 
	 * @access  public
	 * @param   string      $key
	 * @return  mixed
	 */
	public function __get($key)
	{
		return isset($this->config[$key]) ? $this->config[$key] : null;
	}
	
	/**
	 * Check if a configuration exist
	 *
	 * @access  public
	 * @param   string      $key
	 * @return  bool
	 */
	public function __isset($key)
	{
		return isset($this->config[$key]);
	}

	/**
	 * Validate all requirement before allow to generate a checkout
	 *
	 * @access  public
	 * @throws  Molpay\Exception
	 */
	protected function validate()
	{
		// loop all required field, and throw an error if any of it is not available
		foreach (array('merchant_id', 'amount', 'order_id', 'country') as $required)
		{
			if ( ! isset($this->config[$required]) or empty($this->config[$required]))
			{
				throw new Exception("Missing [{$required}] configuration");
			}
		}

		// use default payment method if it's not provided
		if ( ! isset($this->config['payment_method'])) $this->payment_method = $this->default_payment_method;

		if ( ! array_key_exists($this->payment_method, $this->config['payment_methods']))
		{
			throw new Exception("Payment Method [".$this->payment_method."] is not available for MerchantID");
		}

		// set vcode
		$this->vcode = md5($this->amount.$this->merchant_id.$this->order_id.$this->verify_key);
	}
	
	/**
	 * Get the URL
	 *
	 * @access  public
	 * @return  self::get
	 */
	public function __toString() 
	{
		return $this->get();
	}

	/**
	 * Create a GET request to Molpay
	 *
	 * @access  public
	 * @param   Closure     $callback
	 * @return  Response
	 */
	public function get($callback = null)
	{
		if ($callback instanceof Closure)
		{
			$callback();
		}

		$this->validate();

		$url = sprintf(static::$url, $this->merchant_id, $this->payment_methods[$this->payment_method]).'?'.http_build_query(array(
			'amount'      => $this->amount,
			'orderid'     => strval($this->order_id),
			'bill_name'   => $this->name || '',
			'bill_email'  => $this->email || '',
			'bill_mobile' => $this->mobile || '',
			'bill_desc'   => $this->description || '',
			'cur'         => $this->currency,
			'returnurl'   => URL::to('molpay::return'),
			'vcode'       => $this->vcode,
		));

		return Redirect::to($url);
	}

	/**
	 * Create a post request to Molpay
	 *
	 * NOT SUPPORTED AT THE MOMENT
	 *
	 */
	public function post()
	{
		throw new Exception('Not supported at the moment');
	}
}