<?php

namespace App\Controllers;
use \Appkita\CI4Restfull\RestfullApi;
use \App\Models\UserModel;
use \Appkita\PHPAuth\Authentication;
use \Appkita\PHPAuth\METHOD;
use \App\Models\CorouselModel;

class Noauth extends RestfullApi
{
	#protected $modelName = 'UserModel';
	protected $model;
    protected $allowed_format = ['json'];

	protected $auth = [];

	function __construct() {
	}      

	public function index() {
		die('test');
	}

	public function corousel() {
		$mdl = new CorouselModel();
		$data = $mdl->findAll();
		$hasil = [];
		foreach($data as $key) {
			array_push($hasil, base_url().'/'. $key->img);
		}
		return $this->respond(['status'=>true, 'data'=>$hasil]);
	}

	public function create() {
	}
}
