<?php 

namespace app\common\behavior;

use think\Request;

class Test
{

	private $debug = false;

	public function run(Request $request, $params)
	{

		if ($this->debug) {
			echo '<br />';
			echo 'Test run at app_begin:';
			echo '<br />';

			dump($params);

			echo 'Love you, Sandy.C';
		}
		
	}

}