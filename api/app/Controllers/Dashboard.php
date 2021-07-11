<?php

namespace App\Controllers;
use \Appkita\CI4Restfull\RestfullApi;
use \App\Models\DashboardModel;
use \Appkita\PHPAuth\Authentication;
use \Appkita\PHPAuth\METHOD;

class Dashboard extends RestfullApi
{
	#protected $modelName = 'UserModel';
	protected $model;
    protected $allowed_format = ['json'];

	protected $auth = ['token'];

	function __construct() {
		$this->model = new DashboardModel();
	}

    public function Top() {
        $dt = $this->model->top();
         return $this->respond($dt);
    }
    
    public function Grafik() {
        $dt = $this->model->grafik();
         return $this->respond($dt);
    }
}