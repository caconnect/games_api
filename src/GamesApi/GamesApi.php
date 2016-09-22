<?php
namespace Caconnect;

class GamesApi {

	private $apiUrl = 'http://api.licente-jocuri.ro/';
	private $jwtAuth = null;
	private $testMode = false;
	private $loginCredentials = array();

	private $_curlWrap;
	private $_jwtToken;

	public function __construct($username, $password)
	{
		if(!isset($username)) throw new InvalidUsername("You need to specify username to perform login action.");
		$this->loginCredentials['username'] = filter_var($username, FILTER_SANITIZE_EMAIL);

		if(!isset($password)) throw new InvalidPassword("You need to specify password to perform login action.");
		
		$this->_curlWrap = new Curl();


		if(!isset($_SESSION['gamesApi_jwt'])) {
			$this->_jwtToken = $this->obtainJwt(true);
		} else {
			$this->_jwtToken = $_SESSION['gamesApi_jwt'];
		}

		$this->_curlWrap->setHeader('Authorization', 'Bearer '.$_SESSION['gamesApi_jwt']);
	}


	private function obtainJwt($clean = false)
	{
		$this->_curlWrap->get($apiUrl.'/jwt');
	}

}