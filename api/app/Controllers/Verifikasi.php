<?php

namespace App\Controllers;
use \Appkita\CI4Restfull\RestfullApi;
use \App\Models\UserModel;
use \Appkita\PHPAuth\Authentication;
use \Appkita\PHPAuth\METHOD;

class Verifikasi extends RestfullApi
{
	#protected $modelName = 'UserModel';
	protected $model;
    protected $allowed_format = ['json'];

	protected $auth = ['token'];

	function __construct() {
		$this->model = new UserModel();
	}      

	public function create() {
		$PHPAUTH = new Authentication($this->config);
        $token = $PHPAUTH->token()->encode($this->user_api);
        return $this->respond(['status'=>true, 'token'=>$token, 'isadmin'=>true]);
	}
}
