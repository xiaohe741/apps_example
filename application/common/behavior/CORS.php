<?php 

namespace app\common\behavior;

use think\Request;

class CORS {

	private $debug = false;

	public function run(Request $request, $params)
	{
		if ($this->debug) {
			echo '<br />';
			echo 'CORS run at app_init:';
			echo '<br />';

			echo 'Access-Control-Allow-Headers: Authorization, Content-Type, If-Match, If-Modified-Since, If-None-Match, If-Unmodified-Since, X-Requested-With';
			echo '<br />';
			echo 'Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS';
			echo '<br />';
		}

		header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: token, Origin, X-Requested-With, Content-Type, Accept");
        header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE');

        if ($request->isOptions()) {
        	exit('Forbidden: You don\'t have permission to access on this server.');
        }
	}

}