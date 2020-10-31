<?php 

namespace app\common\behavior;

use think\Request;

class Auth {

	private $debug = false;

	public function run(Request $request, $params)
	{

		if ($this->debug == true) {
			echo '<br />';
			echo 'Auth run at action_begin:';
			echo '<br />';

			dump($params);

			exit('Forbidden: You don\'t have permission to access on this server.');
		}

	}

}