<?php
App::uses('AdminsController', 'Controller');
/**
 * Users Controller
 */
class UsersController extends AdminsController {

/**
 * Scaffold
 *
 * @var mixed
 */
//	public $scaffold = 'admin';

	public function admin_login() {

		//POSTデータが、Users['username']とUsers['password']である場合、$this->Auth->login()で認証が可能。
//		var_dump($this->Auth->login());

		if ($this->request->is('post')) {
			// Important: Use login() without arguments! See warning below.

			if ($this->Auth->login()) {
				return $this->redirect($this->Auth->redirectUrl());
				// 2.3より前なら
				// `return $this->redirect($this->Auth->redirect());`
			}
			$this->Flash->admin_flash(
				__('ユーザー名もしくはパスワードに誤りがないかご確認ください。'),
				array(
					'params' => array(
						'class' => 'alert-danger'
					)
				)
			);

			return $this->redirect($this->Auth->login());

			// 2.7 より前なら
			// $this->Session->setFlash(__('Username or password is incorrect'));
		}


//		$this->layout = 'mskg_admin';
//		if($this->Auth->user()){
//			$this->redirect($this->Auth->redirectUrl());
//			return;
//		}
//
//		if ($this->request->is('post')) {
//			if ($this->Auth->login()) {
//				if ($this->Auth->redirectUrl() == "/"){
//					$this->redirect("/admin");
//				}else{
//					$this->redirect($this->Auth->redirectUrl());
//				}
//			} else {
//				$this->Flash->error(__('Invalid username or password, try again'));
//			}
//		}
	}

	public function admin_logout() {
		$this->redirect($this->Auth->logout());
	}

	public function admin_info(){
		$this->layout = 'direct';
		$authUser = $this->Auth->user();
		$theConditions = array(
			'conditions' => array(
				'User.id =' => $authUser['id'],
			),
			'order' => array(
//                    'Item.orderby' => 'DESC',
			),
			'fields' => array(
//                'Category.id',
//                'Category.name',
//                'Category.Item.id'
			),
			'recursive' => 2 //第二階層まで
		);

		$res = $this->User->find('first', $theConditions);
		$userinfo = null;
		if (0 < count($res)){
			$userinfo = $res;
		}
		$this->Set(compact('userinfo'));
	}

	public function admin_editUser(){
//		$this->layout = 'mskg';
		$authUser = $this->Auth->user();
//		if($authUser == null){
//			$this->redirect('/users/login');
//		}

		if($this->request->data('action') == 'edited'){
			$msgOpt = '';
			$theData = array();
			$theData['id'] = $authUser['id'];
			if ($this->request->data('password') != ''){
				$msgOpt = 'パスワードも';
				$theData['password'] = $this->request->data('password');
			}
//			$theData['target'] = $this->request->data('target');
//			$theData['kana'] = $this->request->data('kana');
//			$theData['payee'] = $this->request->data('payee');
//			$theData['bankname'] = $this->request->data('bankname');
//			$theData['branch'] = $this->request->data('branch');
//			$theData['accountnum'] = $this->request->data('accountnum');
			$theData['division_id'] = $this->request->data('division');

			if($this->User->save($theData)){

				//$this->Session->write('Auth', $user);
//				$user = $this->User->find('first', array('conditions' => array('id' => $this->Auth->user('id')), 'recursive' => -1));
//				unset($user['User']['password']); // 念のためパスワードは除外。どうでもよければ消してもOK
//				var_dump($user['User']);
//				var_dump('---------');
//				var_dump($this->Auth->user());
//				$this->Session->write('Auth', $user);

//				$this->Session->write('Auth.User', $this->User->read(null, $this->Auth->User('id')));

				$this->Flash->admin_flash(__($msgOpt.'更新しました。'));
			}else{
				$this->Flash->admin_flash(__('更新に失敗しました。'),
					array(
						'params' => array(
							'class' => 'alert-danger'
						)
					));
			}


		}

		$theConditions = array(
			'conditions' => array(
				'User.id =' => $authUser['id'],
			),
			'order' => array(
//                    'Item.orderby' => 'DESC',
			),
			'fields' => array(
//                'Category.id',
//                'Category.name',
//                'Category.Item.id'
			),
			'recursive' => 2 //第二階層まで
		);

		$res = $this->User->find('first', $theConditions);

//		$thisUser = $this->User->findById($authUser['id'])['User'];

		$thisUser = $res['User'];
		$this->Set(compact('thisUser'));

	}
}
