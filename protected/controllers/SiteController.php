<?php

class SiteController extends Controller
{
    public $layout = '//layouts/standard';
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

    public function actionDeviceType($type_id, $manufacturer_id = null, $device_id = null, $problem_type = 'BREAKDOWN')
    {
        $this->layout = '//layouts/deviceType';

        $deviceType = DeviceType::model()->findByPk($type_id);

        if($deviceType !== null)
        {
            $devices = Device::model()->with('manufacturer')->with('type')->findAllByAttributes(array('type_id' => $type_id));

            $manufacturers = Manufacturer::model()->with('devices')->findAll(array(
                'condition' => 'devices.type_id = :type_id',
                'order' => 't.id DESC',
                'params' => array(':type_id' => $type_id),
            ));


            if($manufacturer_id === null)
            {
                if(count($manufacturers) === 0)
                    throw new CHttpException(0, 'В данном разделе отсутствуют устройства');
                else
                    $manufacturer_id = $manufacturers[0]->id;
            }

            $devices = Device::model()->with('manufacturer')->with('type')->findAllByAttributes(array('type_id' => $type_id, 'manufacturer_id' => $manufacturer_id));

            if($device_id === null)
                $device_id = $devices[0]->id;

            $currentDevice = Device::model()->with('manufacturer')->findByPk($device_id);

            $problemCategories = ProblemCategory::model()->with(array('problems' => array('with' => 'devicesProblem')))->findAll(array(
                'condition' => 'devicesProblem.device_id = :device_id AND problems.type = :problem_type',
                'params' => array(
                    ':device_id' => $device_id,
                    ':problem_type' => $problem_type,
                ),
            ));




            $this->render('deviceType',
                array(
                    'type_id' => $type_id,
                    'devices' => $devices,
                    'manufacturers' => $manufacturers,
                    'manufacturer_id' => $manufacturer_id,
                    'currentDevice' => $currentDevice,
                    'device_id' => $device_id,
                    'problemCategories' => $problemCategories,
                    'problem_type' => $problem_type,
            ));
        }
    }

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}