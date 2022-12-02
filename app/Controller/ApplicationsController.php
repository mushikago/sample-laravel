<?php
App::uses('BasicsController', 'Controller');
/**
 * Applications Controller
 */
class ApplicationsController extends BasicsController {

/**
 * Scaffold
 *
 * @var mixed
 */
//	public $scaffold = 'admin';

	public $uses = array(
		'Application',
	);

	public function beforeFilter(){
		$this->settings['Object'] = 'Application';
		$this->settings['Model'] = $this->Application;

		$this->settings['image_dir'] = 'applications';
		$this->settings['object_dir'] = 'applications';
		$this->settings['object_prefix'] = 'app_';
		$this->settings['belong'] = '';
		/////

		$this->settings['icon'] = 'fas fa-cog';
		$this->settings['list_title'] = 'APP MANAGER TOP';
		$this->settings['edit_title'] = 'EDIT APP';
		$this->settings['view_title'] = 'VIEW APPS';

		$this->settings['list_condition'] = array(); //'Event.application_id =';


		$this->settings['edit_post'] = array();
		if(!empty($_POST)) {
			if ($_POST['action'] == 'edited') {
				$this->settings['edit_post']['id'] = ($_POST['uid'] != 0) ? $_POST['uid'] : null;
				$this->settings['edit_post']['name'] = $_POST['name'];
				$this->settings['edit_post']['info'] = $_POST['info'];
				$this->settings['edit_post']['ios_url'] = $_POST['ios_url'];
				$this->settings['edit_post']['android_url'] = $_POST['android_url'];
				$theData['image'] = $_POST['image'];
			}
		}

		$this->settings['edit_new_init'] = function ($backid){
			$theInitData = array();
			$theInitData['id'] = 0;
			$theInitData['name'] = '';
			$theInitData['info'] = '';
			$theInitData['ios_url'] = '';
			$theInitData['android_url'] = '';
			$theInitData['image'] = ''; //？

			return $theInitData;
		};





		parent::beforeFilter();
	}

	public function admin_viewObject($id = 0)
	{

		if ($id == 0) {
			$this->redirect('/admin/');
		}

		parent::admin_viewObject($id);
	}

	public function admin_listObjects($id = 0, $backid = 0){
		$this->redirect('/admin/');
	}

}
