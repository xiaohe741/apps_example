<?php 

namespace app\controller;

use think\Controller;
use think\Request;

use helper\File;
use helper\Image;

class Photo extends Controller
{


	// index
	public function index(Request $request)
	{

		// $basedir = 'C:/Users/Charlie/Pictures' . str_replace('/photos', '', $request->url());
		$basedir = 'static/images' . str_replace('/photos', '', $request->url());

		list($folders, $files) = File::open(urldecode($basedir));

		foreach ($files as $key => $value) {
			if (strpos('jpg, jpeg, gif, png', $value['extension']) === false) {
				unset($files[$key]);
			}
		}

		$files = dyadic_array_sort($files, 'basename', SORT_ASC, SORT_NUMERIC);

		// dump($folders);
		// dump($files);
		

		// $result = scandir('static/images/beauty/02');
		// dump($result);

		// unset($result[0], $result[1]);
		// echo count(scandir('static/images/beauty/02')) - 1;

		$this->assign('basedir', $basedir);
		$this->assign('folders', $folders);
		$this->assign('files', $files);
		return $this->fetch();
	}


	// create
	public function create(Request $request)
	{
		if (!$request->isPost()) {
			return false;
		}

		$params = $request->param();
		extract($params);

		$result = File::create($dir, $name);
		if ($result) {
			return json('the folder has created.', 200);
		} else {
			return json('unable to create folder.', 400);
		}
	}


	// update
	public function update(Request $request)
	{
		if (!$request->isPost()) {
			return false;
		}

		if ($params = $request->param()) {
			extract($params);
			asort($files);
		} else {
			return false;
		}

		$basedir = urldecode($basedir);
		$savedir = urldecode($savedir);

		if (!is_dir($savedir)) {
			if (!mkdir($savedir)) {
				return json('the savedir is not exist and unable to create.', 400);
			}
		}

		set_time_limit(600);
		
		foreach ($files as $key => $value) {
			$oldname  = $basedir . '/' . $value;
			$pathinfo = pathinfo($oldname);
			if ($mode == 0) {
				$newname = $savedir . '/' . $value;
			}
			if ($mode == 1) {
				$newname = $savedir . '/' . md5($value) . '.' . $pathinfo['extension'];
			}
			if ($mode == 2) {
				$index = count(scandir($savedir)) - 1;
				$newname = $savedir . '/' . ($key + $index) . '.' . $pathinfo['extension'];
			}

			// if ($quality == 0 || $quality > 100 || $quality < 30) {
			// 	$quality = 100;
			// }

			if ($quality == 0) {
				if ($type == 0) {
					copy($oldname, $newname);
				}
				if ($type == 1) {
					rename($oldname, $newname);
				}
			} else {
				Image::open($oldname)->upload($newname, $quality);
				if ($type == 1) {
					unlink($oldname);
				}
			}
			
			$result[] = $value;
		}

		return json($result);
	}


	// remove
	public function remove(Request $request)
	{
		if (!$request->isPost()) {
			return json('bad request.', 400);
		}

		if ($folder = urldecode($request->param('folder'))) {
			if (File::remove($folder)) {
				return json($folder);
			} else {
				return json('unable to remove folder.', 400);
			}
		}

		if ($file = urldecode($request->param('file'))) {
			if (file_exists($file)) {
				unlink($file);
				return json($file);
			} else {
				return json('unable to delete.', 400);
			}
		}
	}


	// rename
	public function rename(Request $request)
	{
		if (!$request->isPost()) {
			return json('bad request.', 400);
		}

		$params = $request->param();
		extract($params);

		foreach ($data as $key => $value) {
			File::update($dir, $value['oldname'], $value['newname']);
		}

		return json('update successfully.', 200);
	}





	// get
	public function get(Request $request)
	{

		$basedir = $request->post('rootdir');


		list($folders, $files) = File::open(urldecode($basedir));

		foreach ($files as $key => $value) {
			if (strpos('jpg, jpeg, gif, png', $value['extension']) === false) {
				unset($files[$key]);
			}
		}

		$files = dyadic_array_sort($files, 'basename', SORT_ASC, SORT_NUMERIC);

		// dump($folders);
		// dump($files);
		

		// $result = scandir('static/images/beauty/02');
		// dump($result);

		// unset($result[0], $result[1]);
		// echo count(scandir('static/images/beauty/02')) - 1;


		$data = [
			'basedir' => $basedir,
			'folders' => $folders,
			'files' => $files,
		];

		return json($data);
	}


}