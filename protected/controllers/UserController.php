<?php
class UserController extends Controller {
	
	/**
	 * @var string specifies the default action to be 'list'.
	 */
	public $defaultAction='list';

	/**
	 * Specifies the action filters.
	 * This method overrides the parent implementation.
	 * @return array action filters
	 */
	public function filters() {
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	public function accessRules() {
		return array(
			'logout, update',
			'login, create, recover' => array(Group::GUEST, 'equal'),
			'delete' => array(Group::ADMIN, 'min'),
		);
	}


	public function actionLogin() {
		$user = new User;
		if (Yii::app()->request->isPostRequest) {
			// collect user input data
			if (isset($_POST['User']))
				$user->setAttributes($_POST['User']);
			// validate user input and redirect to previous page if valid
			if ($user->validate('login'))// ;
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('user' => $user));
	}

	public function actionLogout() {
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

	public function actionList() {
		$criteria = new CDbCriteria;

		$pages = new CPagination(User::model()->count());
		$pages->pageSize = 25;
		$pages->applyLimit($criteria);
		
		$sort = new CSort('user');
		$sort->attributes = array(
			'user.username'=>'username',
			'user.group_id'=>'group_id',
			'user.email'=>'email',
			'user.created'=>'created',
			'user.email_confirmed'=>'email_confirmed',
		);
		$sort->applyOrder($criteria);
		
		$users=User::model()->with('group')->findAll($criteria);
		
		//The user list supports AJAX.  Not sure if this is a good thing in this case,
		//but I'll leave it as an example
		if (Yii::app()->request->isAjaxRequest)
			$this->renderPartial('listPage', compact('users', 'pages', 'sort'));
		else
			$this->render('list', compact('users', 'pages', 'sort'));
	}

	public function actionShow() {
		$user = $this->loadUser(isset($_GET['id']) ? $_GET['id'] : Yii::app()->user->id);

		$this->render('show', array('user' => $user));
	}

	public function actionCreate() {
		$user = new User;
		//print_r($user->getSafeAttributeNames('register'));
		
		if (isset($_POST['User'])) {
			$user->setAttributes($_POST['User'], 'register');
			//print_r($user->attributes);
			//print_r($user->getSafeAttributeNames('register'));
			$user->unconfirmEmail();
			if ($user->validate('register') && $user->save(false)) {
				$this->redirect(array('site/index'));
			}
		}
		$this->render('create',array('user' => $user));
	}

	public function actionUpdate() {
		$id = isset($_GET['id']) ? $_GET['id'] : Yii::app()->user->id;
		
		if ((!Yii::app()->user->hasAuth(Group::ADMIN)) && ($id != Yii::app()->user->id))
			throw new CHttpException(404, 'Permission Denied');

		$user = $this->loadUser($id);
		
		//print_r($user->getSafeAttributeNames('update'));
		if (isset($_POST['User'])) {
			$updatedUser = clone $user;
			$updatedUser->setAttributes($_POST['User'], 'update');

			if ($updatedUser->validate('update')) {
				$redirect = array('show', 'id'=>$id);
				
				//email logic
				if ($updatedUser->email != $user->email) {
					$updatedUser->unconfirmEmail();
					$redirect = array('site/index');
				}
				
				//so not to save blank password
				if (empty($updatedUser->password))
					unset($updatedUser->password);
				else {
					//email notification of new password
					$updatedUser->changePassword();
				}

				if ($updatedUser->save(false))
					$this->redirect($redirect);
			}
			$user = $updatedUser; //for errors and updated values
		}
		unset($user->password);
		$this->render('update', array('user' => $user));
	}
	
	public function actionRecover() {
		$user = new User;

		if (isset($_POST['User'])) {
			$user->setAttributes($_POST['User']);

			if ($user->validate('recover')) {				
				$found = User::model()->findByAttributes(array('email'=>$user->email));
				
				if ($found !== null) {
					$email = Yii::app()->email;
					$email->to = $found->email;
					$email->view = 'UserRecover';
					$email->send(array('user' => $found));
					Yii::app()->user->setFlash('recover', "An email has been sent to {$user->email}.  Please check your email.");
				} else {
					$user->addError('email', 'Email not found');
				}
			}
		}

		$this->render('recover',array('user' => $user));
	}

	public function actionDelete() {
		//throw new CHttpException(404,'bad'); //was used for testing ajax
		
		//  --  Sorry for the commented out code.  I may need it but just ignore  --
		//if (Yii::app()->request->isPostRequest) {
			// we only allow deletion via POST request
			$this->loadUser()->delete();
			if (!Yii::app()->request->isAjaxRequest)
				$this->redirect(array('list'));
		//}
		//else
			//throw new CHttpException(404,'Invalid request. Please do not repeat this request again.  You must have JavaScript turned on!');
	}

	protected function loadUser($id = null) {
		if ($id == null)
			$id = $_GET['id'];
		if (isset($id))
			$user = User::model()->findbyPk($id);
		if (isset($user))
			return $user;
		else
			throw new CHttpException(404,'The requested user does not exist.');
	}

}