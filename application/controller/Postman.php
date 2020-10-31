<?php 

namespace app\controller;

use think\Controller;
use think\Request;

class Postman extends Controller
{

	// index
	public function index(Request $request)
	{
		return json($request->param(), 200);
	}

	// post
	public function post(Request $request)
	{
		if ($request->isPost()) {
			return json($request->param(), 200);
		} else {
			return false;
		}		
	}

}