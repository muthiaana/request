<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mypdf 
{
	public function __construct()
	{
		require_once(APPPATH . 'third_party/dompdf/dompdf_config.inc.php');
		// require_once(APPPATH . '../lainnya/dompdf/autoload.inc.php');
		var_dump(APPPATH . 'third_party/dompdf/dompdf_config.inc.php');
		// use dompdf;
		$pdf = new DOMPDF();
		$CI =& get_instance();
		$CI->dompdf = $pdf;
	}
}
?>