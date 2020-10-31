<?php 

namespace app\controller;

use think\ReController;

class Execute extends ReController
{


	// index
	public function index()
	{
		return $this->fetch();
	}


}