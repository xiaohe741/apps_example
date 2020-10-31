<?php 

namespace app\controller;

use think\Controller;
use think\Request;

class Collection extends Controller
{


	// index
	public function index()
	{
		return $this->fetch();
	}

}