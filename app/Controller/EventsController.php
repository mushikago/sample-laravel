<?php
App::uses('BasicsController', 'Controller');
/**
 * Events Controller
 */
class EventsController extends BasicsController {

/**
 * Scaffold
 *
 * @var mixed
 */
//	public $scaffold = 'admin';

	public $uses = array(
		'Event',
	);

	public function beforeFilter(){
		$this->settings['Object'] = 'Event';
		$this->settings['Model'] = $this->Event;

		$this->settings['image_dir'] = 'events';
		$this->settings['object_dir'] = 'events';
		$this->settings['object_prefix'] = 'event_';
		$this->settings['belong'] = 'application_id';
		/////

		$this->settings['icon'] = 'fas fa-flag-checkered';
		$this->settings['list_title'] = 'EVENT MANAGER TOP';
		$this->settings['edit_title'] = 'EDIT EVENT';
		$this->settings['view_title'] = 'VIEW EVENTS';

		$this->settings['list_condition'] = 'Event.application_id =';


		$this->settings['edit_post'] = array();
		if(!empty($_POST)) {
			if ($_POST['action'] == 'edited') {
				$this->settings['edit_post']['id'] = ($_POST['uid'] != 0) ? $_POST['uid'] : null;
				$this->settings['edit_post']['application_id'] = $_POST['application_id'];
				$this->settings['edit_post']['name'] = $_POST['name'];
				$this->settings['edit_post']['info'] = $_POST['info'];
				$this->settings['edit_post']['start'] = $_POST['start'];
				$this->settings['edit_post']['end'] = $_POST['end'];
				$this->settings['edit_post']['dev_start'] = $_POST['dev_start'];
			}
		}

		$this->settings['edit_new_init'] = function ($backid){
			$theInitData = array();
			$theInitData['id'] = 0;
			$theInitData['application_id'] = $backid;
			$theInitData['name'] = '';
			$theInitData['info'] = '';
			$theInitData['start'] = '';
			$theInitData['end'] = '';
			$theInitData['dev_start'] = '';
			$theInitData['image'] = ''; //？
			$theInitData['status'] = 1;
			$theInitData['event_code'] = '';
			return $theInitData;
		};

		parent::beforeFilter();
	}

}
