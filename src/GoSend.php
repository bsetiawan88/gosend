<?php

namespace Bagus\GoSend;

use Requests;

class GoSend
{

	private $client_id;
	private $password;
	private $url;

	public function __construct($client_id, $password, $url)
	{
		$this->client_id = $client_id;
		$this->password = $password;
		$this->url = $url;
		return $this;
	}

	public function estimate($args = [])
	{
		$url = $this->url . '/gokilat/v10/calculate/price?' . http_build_query($args);
		$response = Requests::get($url, $this->_getHeader());
		if (isset($response->body)) {
			return json_decode($response->body);
		}
	}

	public function getInfo($order_no)
	{
		$url = $this->url . '/gokilat/v10/booking/orderno/' . $order_no;
		$response = Requests::get($url, $this->_getHeader());
		if (isset($response->body)) {
			return json_decode($response->body);
		}
	}

	public function makeBooking($args = [])
	{
		$url = $this->url . '/gokilat/v10/booking';
		$args = json_encode($args);
		$response = Requests::post($url, $this->_getHeader(), $args);
		if (isset($response->body)) {
			return json_decode($response->body);
		}
	}

	private function _getHeader()
	{
		return [
			'Accept' => 'application/json',
			'Content-Type' => 'application/json',
			'Client-ID' => $this->client_id,
			'Pass-Key' => $this->password
		];
	}

}