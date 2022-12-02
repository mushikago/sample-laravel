<?php
App::uses('AppController', 'Controller');
/**
 * AdminsController Controller
 */
class AdminsController extends AppController {

/**
 * Scaffold
 *
 * @var mixed
 */
	public $scaffold = 'admin';

//	public $components = array(
//		'Auth' => array(
//			'loginRedirect' => array(
//				'controller' => 'pages',
//				'action' => 'top',
//				'admin' => true
//			),
//			'logoutRedirect' => array(
//				'controller' => 'pages',
//				'action' => 'home'
//			),
//			'authenticate' => array(
//				'Form' => array(
//					'passwordHasher' => 'Blowfish'
//				)
//			),
//			'authorize' => array('Controller')
//		)
//	);

//	public $components = array('Auth');


	public $components = array(
		'Auth' => array(
			'loginRedirect'  => array(
				'controller' => 'admins',
				'action' => 'top',
				'admin' => true),
			'logoutRedirect'  => array(
				'controller' => 'users',
				'action' => 'login',
				'admin' => true),
			'authenticate' => array(
				'Form' => array(
					'passwordHasher' => 'Blowfish'
				)
			),
		)
	);

	public $uses = array(
		'Application'
	);

//	public $components = array(
//		'Auth' => array(
//			'authenticate' => array(
//				'Form' => array(
//					'passwordHasher' => 'Blowfish'
//				)
//			)
//		)
//	);

	public function beforeFilter()
	{
		switch ($this->action) {
			case 'admin_top':
			case 'admin_login' :
			case 'admin_logout' :
			case 'admin_editUser' :
			case 'admin_listStations' : //StationsController
			case 'admin_listObjects' : //EventsController
			case 'admin_editObject' : //EventsController
			case 'admin_viewObject' : //EventsController
				$this->layout = 'mskg_admin';
				break;
			default:
				$this->layout = 'default';
				break;
		}

		// 認証コンポーネントをViewで利用可能にしておく
		$this->set('auth', $this->Auth->user());

		parent::beforeFilter();
	}

	public function admin_top()
	{
		$theConditions = array(
			'conditions' => array(
//				'User.id =' => $thisUser['id'],
			),
			'order' => array(
//				'Order.id' => 'DESC',
			),
			'fields' => array(
//				'User.id',

			),
//            'recursive' => 2 //第二階層まで
		);

		$myApplications = $this->Application->find('all',$theConditions);
//		$this->outputJson($myApplications);
		$this->Set(compact('myApplications'));
	}
}
