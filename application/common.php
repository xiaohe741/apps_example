<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Charlie / xiaohe741@sina.com
// +----------------------------------------------------------------------



// extra_vars_shift
function extra_vars_shift($vars)
{
	return substr($vars, 0, strripos($vars, '/'));
}

// dyadic_array_sort
function dyadic_array_sort($data, $key, $order= SORT_ASC, $flags= SORT_REGULAR)
{
	$keys = array_column($data, $key);

	array_multisort($keys, $order, $flags, $data);

	return $data;
}


function base64_image_encode($file) {
    $result = '';

    $image_info = getimagesize($file);
    $image_data = fread(fopen($file, 'r'), filesize($file));

    $result = 'data:' . $image_info['mime'] . ';base64,' . chunk_split(base64_encode($image_data));
    return $result;

}

function base64_image_decode($content, $path){
    if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $content, $result)){
        $type = $result[2];
        $new_file = $path."/".date('Ymd',time())."/";
        if(!file_exists($new_file)){
            //检查是否有该文件夹，如果没有就创建，并给予最高权限
            mkdir($new_file, 0700);
        }
        $new_file = $new_file.time().".{$type}";
        if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $content)))){
            return '/'.$new_file;
        }else{
            return false;
        }
    }else{
        return false;
    }
}