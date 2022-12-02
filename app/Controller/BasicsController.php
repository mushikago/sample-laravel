<?php
App::uses('AdminsController', 'Controller');
/**
 * Basics Controller
 */
class BasicsController extends AdminsController {

/**
 * Scaffold
 *
 * @var mixed
 */
//	public $scaffold = 'admin';




	protected $settings = array();

	public $components = array('Auth','Paginator');

	public $uses = array(
//		'Event',
	);

	public function admin_listObjects($id = 0, $backid = 0){
		$title = $this->settings['list_title'];
		$icon = $this->settings['icon'];
		$queryStr = ($_SERVER['QUERY_STRING'] != '') ? '?'.$_SERVER['QUERY_STRING'] : '';

		$theConditions = array(
			'limit' => 20,
			'conditions' => array(
				$this->settings['list_condition'] => $id,
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

//		$myEvents = $this->Event->find('all', $theConditions);
		$this->Paginator->settings = $theConditions;
		$myObjects = $this->Paginator->paginate();

		$isAdmin = $this->isAdmin();
//		$this->_renderJson($myObjects);
		$this->Set(compact('title', 'icon','myObjects', 'id', 'backid', 'isAdmin', 'queryStr'));
	}

	public function admin_editObject($id = 0, $backid = 0)
	{
		$title = $this->settings['edit_title'];
		$icon = $this->settings['icon'];
		$belong = $this->settings['belong'];
		$queryStr = ($_SERVER['QUERY_STRING'] != '') ? '?'.$_SERVER['QUERY_STRING'] : '';


		if(!empty($_POST)){
//			Debugger::dump('更新');
			if ($_POST['action'] == 'edited') {
				$theData = $this->settings['edit_post'];

				if($_POST['uid'] == 0){ //新規作成なら紐付ける

					//新規作成して新規のID取得
					$this->settings['Model']->create(); //$this->Event->create(); // Create a new record
					$myObject = $this->settings['Model']->save($theData); //$this->Event->save($theData); // And save it
					$updatedId = $myObject[$this->settings['Object']]['id'];
					$msg = '#' . $updatedId . 'を新規作成しました。';
				}else{
					$myObject = $this->settings['Model']->save($theData); //$this->Event->save($theData); //更新
					$updatedId = $id;
					$msg = '#' . $updatedId . 'を更新しました。';
				}

				$isAdmin = $this->isAdmin();
				$this->Set(compact('title', 'icon','myObject', 'id', 'backid', 'isAdmin', 'belong', 'queryStr'));
//				return;
			}

			$this->Flash->admin_flash($msg);
			$this->redirect( '/admin/'.$this->settings['object_dir'].'/editObject/'.$updatedId.'/'.$backid.$queryStr );
			return;
		}

		if($id != 0) {
			$myObject = $this->settings['Model']->findById($id); //$this->Event->findById($id);
		}else{

//			Debugger::dump('新規');
//			$theInitData = array();
//			$theInitData['id'] = 0;
//			$theInitData['application_id'] = $backid;
//			$theInitData['name'] = '';
//			$theInitData['info'] = '';
//			$theInitData['start'] = '';
//			$theInitData['end'] = '';
//			$theInitData['dev_start'] = '';
//			$theInitData['image'] = ''; //？
//			$theInitData['status'] = 1;
//			$theInitData['event_code'] = '';
//
//			$myEvent = $this->Event->set($theInitData);
			$myObject = $this->settings['Model']->set($this->settings['edit_new_init']($backid));
		}
//		$this->_renderJson($myApplication);
		$isAdmin = $this->isAdmin();
		$this->Set(compact('title', 'icon','myObject', 'id', 'backid', 'isAdmin', 'belong', 'queryStr'));
	}

	public function admin_viewObject($id = 0){
		$title = $this->settings['view_title'];
		$icon = $this->settings['icon'];
		$queryStr = ($_SERVER['QUERY_STRING'] != '') ? '?'.$_SERVER['QUERY_STRING'] : '';

		$myObject = $this->settings['Model']->findById($id); //$this->Event->findById($id);
		$isAdmin = $this->isAdmin();
		$this->Set(compact('title', 'icon','myObject', 'id', 'isAdmin', 'queryStr'));
	}

	public function admin_deleteObject($id = 0, $backid = 1){
		$queryStr = ($_SERVER['QUERY_STRING'] != '') ? '?'.$_SERVER['QUERY_STRING'] : '';
		if($id != 0) {

			$this->settings['Model']->delete($id, false); //$this->Event->delete($id, false);
			$this->Flash->admin_flash(
				__('#' . $id . 'を削除しました。'),
				array(
					'params' => array(
						'class' => 'alert-danger'
					)
				)
			);
		}else{
			$this->Flash->admin_flash(
				__('何も削除されませんでした。'),
				array(
					'params' => array(
						'class' => 'alert-warning'
					)
				)
			);
		}
		$this->redirect( '/admin/'.$this->settings['object_dir'].'/listObjects/'.$backid.'/' );
	}

	public function admin_duplicateObject($id = 0, $backid = 1){
		$queryStr = ($_SERVER['QUERY_STRING'] != '') ? '?'.$_SERVER['QUERY_STRING'] : '';
		if($id != 0) {

			$row = $this->settings['Model']->findById($id);//$this->Event->findById($id);
			$row[$this->settings['Object']]['id'] = null;

			$this->settings['Model']->create(); //$this->Event->create(); // Create a new record
			$res = $this->settings['Model']->save($row); //$this->Event->save($row); // And save it

			$this->Flash->admin_flash(
				__('#' . $id . 'を複製し、'. $res[$this->settings['Object']]['id'] .'を新規に作成しました。'),
				array(
					'params' => array(
						'class' => 'alert-info'
					)
				)
			);
		}else{
			$this->Flash->admin_flash(
				__('何も複製されませんでした。'),
				array(
					'params' => array(
						'class' => 'alert-warning'
					)
				)
			);
		}
		$this->redirect( '/admin/'.$this->settings['object_dir'].'/editObject/'.$id.'/'.$backid.'/' );
	}


	public function admin_uploadfile($id = 0, $backid = 0){ //redirectのための引数

		$queryStr = ($_SERVER['QUERY_STRING'] != '') ? '?'.$_SERVER['QUERY_STRING'] : '';

		// mysqlにデータを格納する方法もあるようだが、ここでは単純にファイルアップロードに。
		// http://cakephpクッキング.jp/image-save-db/

		//パラメータよりイメージ情報を取得
//		$image = $this->request->data('upload_file');
		$image = $this->params['form']['upload_file'];

		//イメージ保存先パス
		$img_save_path = IMAGES.$this->settings['image_dir'] ;

		//拡張子取得
		$ext = pathinfo($image['name'], PATHINFO_EXTENSION);
		$isOkExt = false;
		switch ($ext){
			case "gif":
			case "GIF":
			case "png":
			case "PNG":
			case "jpg":
			case "JPG":
			case "jpeg":
			case "JPEG":
				$isOkExt = true;
				break;
			default:
				$isOkExt = false;
				break;
		}

//		if($id == 0 || $backId == 0){
//			$isOkExt = false;
//		}

		$msg = '';
		if ($isOkExt && $this->request->data('action') == 'uploaded'){

			$id = $this->request->data('upload_id');
			$existing_file = $this->request->data('existing_file');

			//イメージの保存処理
			$randomFileName = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 16);
			$theFileName = $this->settings['object_prefix'].sprintf('%04d', $id).'_'.$randomFileName.'.'.$ext;
			move_uploaded_file($image['tmp_name'], $img_save_path.DS.$theFileName);
			$msg = 'アップロードしました。';

			$theData = array();
			$theData['id'] = $id;
			$theData['image'] = $theFileName;

			$this->settings['Model']->save($theData); //$this->Event->save($theData);

			//既存ファイル削除処理
			if($existing_file != ''){
				$deleteMsg = $this->deleteLocalFile($this->settings['image_dir'], $existing_file);
				$msg = $msg.'既存ファイルについては、'.$deleteMsg;
			}

		}else{
			$msg = 'エラーが発生してアップロードできませんでした。';
		}


		$this->Flash->admin_flash(__($msg));

		$this->redirect( '/admin/'.$this->settings['object_dir'].'/editObject/'.$id.'/'.$backid.'/');
	}

	public function admin_deletefile($id = 0, $backid = 0){ //redirectのための引数
		$queryStr = ($_SERVER['QUERY_STRING'] != '') ? '?'.$_SERVER['QUERY_STRING'] : '';

		$target = $this->settings['Model']->findById($id); //$this->Event->findById($id);
		$filename = $target[$this->settings['Object']]['image'];
		$msg = $this->deleteLocalFile($this->settings['image_dir'], $filename);

		$theData = array();
		$theData['id'] = $id;
		$theData['image'] = null;

		$this->settings['Model']->save($theData); //$this->Event->save($theData);

		$this->Flash->admin_flash(__('画像ファイル'.$msg));
		$this->redirect( '/admin/'.$this->settings['object_dir'].'/editObject/'.$id.'/'.$backid.'/');
	}

	protected function deleteLocalFile($filepath, $filename){
		$img_save_path = IMAGES.$filepath; //イメージ保存先パス
		$filefullpath = $img_save_path.DS.$filename;
		$this->log(file_exists($filefullpath));

		if(file_exists($filefullpath)){
			unlink($filefullpath);
			$msg = 'ファイルを削除しました。';
		}else{
			$msg = 'ファイルが存在せず削除できませんでした。';
		}
		return $msg;
	}
}
