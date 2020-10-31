<?php 

namespace app\controller;

use think\Controller;
use think\Request;

class Data extends Controller
{


	// index
	public function index()
	{
		return $this->fetch();
	}

	// read
	public function datatable(Request $request)
	{

		if ($request->isPost()) {

			$method = $request->post('method');

			$data = [
				['id'=> '1001', 'name'=> 'Sandy.C', 'price'=> 3000],
				['id'=> '1002', 'name'=> '熊吖BoBo', 'price'=> 2900],
				['id'=> '1003', 'name'=> '小甜心Sugar', 'price'=> 2500],
				['id'=> '1004', 'name'=> '施忆佳Kitty', 'price'=> 3000],
				['id'=> '1005', 'name'=> '唐琪儿Beauty', 'price'=> 1500],
				['id'=> '1006', 'name'=> '李七喜', 'price'=> 1800],
				['id'=> '1007', 'name'=> '刘飞儿', 'price'=> 2000],
				['id'=> '1008', 'name'=> 'Manuela', 'price'=> 1000],
				['id'=> '1009', 'name'=> '绮里嘉', 'price'=> 1500],
				['id'=> '1010', 'name'=> '刘亦宁', 'price'=> 2800],
				['id'=> '1011', 'name'=> '赵梦媛', 'price'=> 2400],
				['id'=> '1012', 'name'=> '伊小七MoMo', 'price'=> 3000],
				['id'=> '1013', 'name'=> '许诺Sabrina', 'price'=> 2100],
				['id'=> '1014', 'name'=> '夏茉GiGi', 'price'=> 2000],
				['id'=> '1015', 'name'=> 'Milk楚楚', 'price'=> 1800],
				['id'=> '1016', 'name'=> '可乐Vicky', 'price'=> 1600],
				['id'=> '1017', 'name'=> '沈佳熹', 'price'=> 900],
				['id'=> '1018', 'name'=> '于姬Una', 'price'=> 2200],
				['id'=> '1019', 'name'=> '朵比Dobby', 'price'=> 900],
				['id'=> '1020', 'name'=> '李筱乔jo', 'price'=> 1300],
				['id'=> '1021', 'name'=> '戴小唯', 'price'=> 1200],
				['id'=> '1022', 'name'=> '陆金佳Jessica', 'price'=> 800],
				['id'=> '1023', 'name'=> '淼淼萌萌哒', 'price'=> 800],
				['id'=> '1024', 'name'=> 'Lee小棠 ', 'price'=> 1100],
				['id'=> '1025', 'name'=> '程彤颜', 'price'=> 100],
				['id'=> '1026', 'name'=> '珍妮花', 'price'=> 1500],
			];

			if ($method == 'object') {
				return json($data);
			}

			if ($method == 'array') {
				foreach ($data as $key => $value) {
					$data[$key] = array_values($value);
				}
				return $data;
			}


			if ($method == 'server') {
				$params = $request->post();

				// return json($params);
				
				$total  = count($data);
				$value  = array_splice($data, $params['start'], $params['length']);
				$filter = count($value);
				$response = [
					'draw'            => intval($params['draw']),
					'recordsTotal'    => intval($total),
					// 'recordsFiltered' => intval($filter),
					'recordsFiltered' => intval($total),
					'data'            => $value,
					'error'           => 0,
				];


				if (!empty($params['search']['value'])) {

					$filters = explode(' ', $params['search']['value']);

					// return json($filters);

					$data = false;
					foreach ($filters as $filter) {
						$value = $this->array_is_value($value, $filter);
					}

					// return json($value);

					$response['data'] = $value;
				}

				return json($response);
			}
		}

	}


	public function array_is_value($data, $filter)
	{

		$result = [];

		foreach ($data as $key => $value) {
			foreach ($value as $subkey => $subvalue) {
				if ($subvalue == $filter) {
					$result[] = $value;
				}
			}
		}

		return $result;

	}


}