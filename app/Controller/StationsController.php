<?php
App::uses('BasicsController', 'Controller');
/**
 * Stations Controller
 */
class StationsController extends BasicsController {

/**
 * Scaffold
 *
 * @var mixed
 */
//	public $scaffold = 'admin';

	public $uses = array(
		'Station',
	);

	public function beforeFilter(){
		$this->settings['Object'] = 'Station';
		$this->settings['Model'] = $this->Station;

		$this->settings['image_dir'] = 'stations';
		$this->settings['object_dir'] = 'stations';
		$this->settings['object_prefix'] = 'station_';
		$this->settings['belong'] = 'event_id';
		/////

		$this->settings['icon'] = 'fas fa-stamp';
		$this->settings['list_title'] = 'STAMP POINT MANAGER TOP';
		$this->settings['edit_title'] = 'EDIT STAMP POINT';
		$this->settings['view_title'] = 'VIEW STAMPS POINT';

		$this->settings['list_condition'] = 'Station.event_id =';


		$this->settings['edit_post'] = array();
		if(!empty($_POST)) {
			if ($_POST['action'] == 'edited') {
				$this->settings['edit_post']['id'] = ($_POST['uid'] != 0) ? $_POST['uid'] : null;
				$this->settings['edit_post']['event_id'] = $_POST['event_id'];
//				$this->settings['edit_post']['station_code'] = $_POST['station_code'];
				$this->settings['edit_post']['name'] = $_POST['name'];
//				$this->settings['edit_post']['ename'] = $_POST['ename'];
//				$this->settings['edit_post']['kname'] = $_POST['kname'];
//				$this->settings['edit_post']['chname'] = $_POST['chname'];
//				$this->settings['edit_post']['ckname'] = $_POST['ckname'];
				$this->settings['edit_post']['info'] = $_POST['info'];
//				$this->settings['edit_post']['data'] = $_POST['data'];
//				$this->settings['edit_post']['point'] = $_POST['point'];
				$this->settings['edit_post']['latitude'] = $_POST['latitude'];
				$this->settings['edit_post']['longitude'] = $_POST['longitude'];
//				$this->settings['edit_post']['circler'] = $_POST['circler'];
//				$this->settings['edit_post']['zip'] = $_POST['zip'];
//				$this->settings['edit_post']['address1'] = $_POST['address1'];
//				$this->settings['edit_post']['address2'] = $_POST['address2'];
//				$this->settings['edit_post']['status'] = $_POST['status'];
//				$this->settings['edit_post']['open_time'] = $_POST['open_time'];
//				$this->settings['edit_post']['close_time'] = $_POST['close_time'];
//				$this->settings['edit_post']['open'] = $_POST['open'];
//				$this->settings['edit_post']['close'] = $_POST['close'];
//				$this->settings['edit_post']['prefecture_id'] = $_POST['prefecture_id'];
				$this->settings['edit_post']['image'] = $_POST['image'];
			}
		}

		$this->settings['edit_new_init'] = function ($backid){
			$theInitData = array();
			$theInitData['id'] = 0;
			$theInitData['event_id'] = $backid;
//			$theInitData['station_code'] = '';
			$theInitData['name'] = '';
//			$theInitData['ename'] = '';
//			$theInitData['kname'] = '';
//			$theInitData['chname'] = '';
//			$theInitData['ckname'] = '';
			$theInitData['info'] = '';
//			$theInitData['data'] = '';
//			$theInitData['point'] = 0;
			$theInitData['latitude'] = 0;
			$theInitData['longitude'] = 0;
//			$theInitData['circler'] = 0;
//			$theInitData['zip'] = '';
//			$theInitData['address1'] ='';
//			$theInitData['address2'] = '';
//			$theInitData['status'] = 0;
//			$theInitData['open_time'] = 0;
//			$theInitData['close_time'] = 0;
//			$theInitData['open'] = '';
//			$theInitData['close'] = '';
//			$theInitData['prefecture_id'] = 0;
			$theInitData['image'] = 0;
			return $theInitData;
		};

		parent::beforeFilter();
	}

}
