<?php 

namespace app\controller;

use think\Controller;
use think\Request;
use helper\File;

use app\model\User;

use Intervention\Image\ImageManagerStatic as Image;

class Index extends Controller
{


	// index
	public function index()
	{
		$file = 'f:/webroot/think/helper/public/static/images/01/1.jpg';

		if (is_file($file)) {
			// $image = Image::make($file)->fit(300, 300)->save('f:/webroot/think/helper/public/static/images/01/first_fit.png', 80);
			// $image = Image::make($file)->save('f:/webroot/think/helper/public/static/images/01/1_small.jpg');

			// dump($image);
		} else {
			echo 'the file is not exit or path error.';
		}

		return $this->fetch();
	}


	public function hello(User $user)
	{
		return 'hello ' . $user->name . '<br />' . $user->email;
	}


	// login
	public function login()
	{
		return $this->fetch();
	}


	// rename
	public function rename(Request $request)
	{

		// $dir_read = 'static/images/beauty';
		// $dir_save = 'static/images/beauty/02';

		// $pictures = 'c:/users/xiaoh/pictures/本机图片/05';
		// $materail = 'f:/material';
		// $photography = 'f:/backups/photography';

		// list($text_1, $test_2) = File::open(urldecode($pictures));
		// dump($text_1);
		// dump($test_2);

		// $result = dyadic_array_sort($test_2, 'filename');
		// dump($result);

		// list($read_folders, $read_files) = File::open(urldecode($dir_read));
		// list($save_folders, $save_files) = File::open(urldecode($dir_save));

		// dump($read_folders);
		// exit;

		$operate = false;
		if ($operate == true) {
			$is_dir = File::create($dir_save);
			if ($is_dir == false) {
				exit('the save-dir is not exit or can not create.');
			}

			$index = count($save_files) + 1;
			foreach ($read_files as $key => $value) {
				$filename = $value['dirname'] . '/' . $value['basename'];
				$savename = $dir_save . '/' . ($key + $index) . '.' . $value['extension'];

				if (!is_file($filename)) {
					continue;
				}

				if (rename($filename, $savename)) {
					echo $filename . ' has renamed, save to ' . $savename . '<br/>';
				}
			}
		}	

		return $this->fetch();
	}

	// select
	public function select(Request $request)
	{
		ini_set('memory_limit', '512M');

		if ($request->isPost()) {
			$read_dir = $request->post('read_dir');
			
			list($folders, $files) = File::open(urldecode($read_dir));
			// $result = [$folders, dyadic_array_sort($files, 'filename')];

			$files = dyadic_array_sort($files, 'filename');
			foreach ($files as $key => $value) {
				$filename = $value['dirname'] . '/' . $value['basename'];
				$files[$key]['base64'] = base64_image_encode($filename);
			}

			$result = [$folders, $files];
			return json($result);
		}
	}

	// upload
	public function upload(Request $request)
	{
		if ($request->isPost()) {
			$params = $request->post();
			extract($params);

			$is_dir = File::create($path);
			if ($is_dir == false) {
				return json('the save-dir is not exit or can not create.', 400);
			}

			$filename = $data['dirname'] . '/' . $data['basename'];
			if (!is_file($filename)) {
				return json('the file is not exit.', 400);
			}

			set_time_limit(600);

			switch ($type) {
				case 1:
					$savename = $path . '/' . $data['basename'];
					if (copy($filename, $savename)) {
						$result = [
							'oldname' => $data['basename'],
							'newname' => $data['basename'],
						];
						return json($result);
					} else {
						return json('the file can not to copy.', 400);
					}
					return json($result);
					break;

				case 2:
					$index = count($files) + 1;
					$savename = md5(time()) . '.' . $data['extension'];
					if (is_file($savename)) {
						return json('the file has exited.', 400);
					}
					if (rename($filename, $path . '/' . $savename)) {
						$result = [
							'oldname' => $data['basename'],
							'newname' => $savename,
						];
						return json($result);
					} else {
						return json('the file can not to rename.', 400);
					}
					break;

				case 3:
					// list($folders, $files) = File::open(urldecode($path));
					// $index = count($files) + 1;
					$savename =  $index . '.' . $data['extension'];
					if (is_file($savename)) {
						return json('the file has exited.', 400);
					}
					if (rename($filename, $path . '/' . $savename)) {
						$result = [
							'oldname' => $data['basename'],
							'newname' => $savename,
						];
						return json($result);
					} else {
						return json('the file can not to rename.', 400);
					}
					break;
				
				default:
					# code...
					break;
			}

			return json($data);
		}
	}



	// number
	public function number(Request $request)
	{
		if ($request->isPost()) {
			$folder = $request->post('folder');

			list($folders, $files) = File::open(urldecode($folder));

			return count($files);
		}
	}


}