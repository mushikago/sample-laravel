<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		https://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

	public $components = array(
		'Session',
		'Cookie',
		'Flash',
		'DebugKit.Toolbar'
	);

	var $uses = array(
		'User',
	);

	protected $jsonf = false;

	//symbol==mskg で、403が表示されるバグが発生するので要注意
//	public function isAuthorized($user) {
//		if (isset($user['Role']) && $user['Role']['symbol'] === 'admin') {
//			return true;
//		}
//		return false;
//	}

	//methods
	protected function _ng( $err = -1 , $errMsg = "") {
		if ($errMsg == "") {
			$this->_renderJson( array( 'error'=>$err ));
		}else{
			$this->_renderJson( array( 'error'=>$err , 'errorMsg'=>$errMsg) );
		}
	}
	protected function _ok($msg = "") {
		if ($msg == "") {
			$this->_renderJson( array( 'error'=>0 ) );
		}else{
			$this->_renderJson( array( 'error'=>0 , 'message'=>$msg) );
		}
	}
	protected function _renderJson( $inOutput ) {
		$this->autoRender = false;
		echo new CakeResponse(array('type' => 'json', 'body' => json_encode($inOutput)));
	}
	protected function outputJson($theResults){
		$ret = array();
		$ret["error"] = 0;
		$ret["result"] = $theResults;
		$this->_renderJson($ret);
	}

	protected function setLang($lang){
		Configure::write('Config.language', $lang);
		$this->Session->write('Config.language', $lang);
	}

	protected function isAdmin(){
		$isAdmin = 0;
		if($this->Cookie->check('Admin')){
			$isAdmin = ($this->Cookie->read('Admin') == 1);
		}
		return $isAdmin;
	}

	public function beforeFilter()
	{
		parent::beforeFilter();

		//format
		$jsonstr = Hash::get($this->request->query, 'format');
		if($jsonstr == 'json'){
			$this->jsonf = true;
		}

		//Lang
		$paramLang = Hash::get($this->request->query, 'lang');
		if ($paramLang == null){
			if ($this->Session->check('Config.language')) {
				Configure::write('Config.language', $this->Session->read('Config.language'));
			}
		}else{
			$this->setLang($paramLang);
		}
	}

}
