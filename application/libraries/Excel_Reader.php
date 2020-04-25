<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Excel_Reader
{

	private $controller;

	function __construct()
	{
		$this->controller =& get_instance();

		$this->controller->load->library("API_Excel_Reader");
		$this->controller->api_excel_reader->setOutputEncoding('CP1251');
	}


	public function load($file = "")
	{
		$this->controller->api_excel_reader->read($file);
		return $this->controller->api_excel_reader->sheets;
	}
}
