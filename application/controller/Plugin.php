<?php 

namespace app\controller;

use think\ReController;
use think\facade\Cache;

class Plugin extends ReController
{


	// index
	public function index($name= false)
	{

		$categories = Cache::get('plugin.categories', []);
		$this->assign('categories',$categories);

		$plugins = Cache::get('plugin.item', []);
		$this->assign('plugins',$plugins);


		if ($name !== false) {
			$name = 'plugin/item/' . $name;
		}

		return $this->fetch($name);
	}


	// create
	public function create()
	{
		return json(['qweqweqweqwe'], 200);
	}



	// save
	public function save()
	{
		if ($data = $this->method('post')->params()) {

			extract($data);

			switch ($type) {
				case 1:
					if ($value == '') {
						return json('the value is empty.', 400);
					}

					$item = Cache::get('plugin.item', []);

					$name = strtolower($value['name']);
					if (!in_array($name, $item)) {

						$item[$name] = $value;
						Cache::set('plugin.item',$item);
					}
					return json($item, 200);
					break;
				
				case 2:
					if ($value == '') {
						return json('the value is empty.', 400);
					}

					$categories = Cache::get('plugin.categories', []);

					if (!in_array($value, $categories)) {

						array_push($categories, $value);
						sort($categories);
						Cache::set('plugin.categories',$categories);
					}
					return json($categories, 200);
					break;

				default:
					throw new \think\Exception('the type is wrong.', 400);
					break;
			}
		}
	}



	// delete
	public function delete()
	{
		if ($data = $this->method('delete')->params()) {

			extract($data);

			if ($value == '') {
						return json('the value is empty.', 400);
					}
			
			switch ($type) {
				case 1:
					$plugins = Cache::get('plugin.item', []);

					if (array_key_exists($value, $plugins)) {
						unset($plugins[$value]);
						sort($plugins);
						Cache::set('plugin.item',$plugins);
					}
					return json($plugins, 200);
					break;
				
				case 2:
					$categories = Cache::get('plugin.categories', []);

					if (in_array($value, $categories)) {
						$categories = array_diff($categories, [$value]);
						sort($categories);
						Cache::set('plugin.categories',$categories);
					}
					return json($categories, 200);
					break;

				default:
					throw new \think\Exception('the type is wrong.', 400);
					break;
			}

			return json($data, 200);
		}
	}


}