<?php 

namespace app\controller;

use think\ReController;

class Notepad extends ReController
{


	// index
	public function index()
	{
		return $this->fetch();
	}


	// create
	public function create()
	{
		return $this->fetch();
	}


}