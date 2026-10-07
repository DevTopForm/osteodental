<?php

namespace App\Admin\Controller;

use App\Admin\Controller;
use App\Admin\LoginManager;
use App\Utils;

class Login extends Controller {

	public function isDispatchable($pathStr){
		$pathStr = $this->removePathPrefix($pathStr);
		return preg_match(
			'/^(login|logout)(\/.*)?$/',
			$pathStr
		);
	}

	public function run(){
		$path = $this->removePathPrefix(join('/', $this->path));
		$path = explode('/', $path);
		$lm = new LoginManager();
		if ('login' == reset($path)) {
			try {
				$lm->login();
				if (!empty($_SERVER['HTTP_REFERER'])){
					Utils::redirectPrevious();
				} else {
					Utils::redirect(SYS_ADMIN_PATH_PREFIX.'/');
				}
			} catch (\Exception $e) {
				Utils::redirect(SYS_ADMIN_PATH_PREFIX.'/?login_error=' . $e->getCode());
			}
		}
		if ('logout' == reset($path)) {
			$lm->logout();
			if (!empty($_SERVER['HTTP_REFERER'])){
				Utils::redirectPrevious();
			} else {
				Utils::redirect(SYS_ADMIN_PATH_PREFIX.'/');
			}
		}
	}


}
