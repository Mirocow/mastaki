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
            $devices = Device::model()->with('manufacturer')->with('type')->findAllByAttributes(array('type_id' => $type_id, 'active' => '1'),array('order' => 't.pos ASC'));

            $manufacturers = Manufacturer::model()->with('devices')->findAll(array(
                'condition' => 'devices.type_id = :type_id AND t.active = 1 AND devices.active = 1',
                'order' => 't.pos ASC',
                'params' => array(':type_id' => $type_id),
            ));


            if($manufacturer_id === null)
            {
                if(count($manufacturers) === 0)
                    throw new CHttpException(0, 'В данном разделе отсутствуют устройства');
                else
                    $manufacturer_id = $manufacturers[0]->id;
            }

            $devices = Device::model()->with('manufacturer')->with('type')->findAllByAttributes(array('type_id' => $type_id, 'manufacturer_id' => $manufacturer_id, 'active' => '1'));

            if($device_id === null)
                $device_id = $devices[0]->id;

            $currentDevice = Device::model()->with('manufacturer')->findByPk($device_id);

            $problemCategories = ProblemCategory::model()->with(array(
                'problems' => array(
                    'with' => array(
                        'devicesProblem',
                    ),
                    'order' => 'problems.pos ASC',
                )
            ))->findAll(array(
                'condition' => 'devicesProblem.device_id = :device_id AND problems.type = :problem_type AND device_type_id = :type_id AND devicesProblem.active = 1',
                'params' => array(
                    ':device_id' => $device_id,
                    ':problem_type' => $problem_type,
                    ':type_id' => $type_id,
                ),
            ));


            $col = count($problemCategories);
            $newProblemCategories = array(array(), array(), array());
            $column = 0;

            foreach($problemCategories as $problemCategory)
            {
                $newProblemCategories[$column][] = $problemCategory;

                $column = ($column + 1) % 3;
            }

            $this->render('deviceType',
                array(
                    'type_id' => $type_id,
                    'devices' => $devices,
                    'manufacturers' => $manufacturers,
                    'manufacturer_id' => $manufacturer_id,
                    'currentDevice' => $currentDevice,
                    'device_id' => $device_id,
                    'problemCategories' => $newProblemCategories,
                    'problem_type' => $problem_type,
            ));
        }
    }
    public function actionResume()
    {
        $mastak = new Mastak();
        $skillCategories = SkillCategory::model()->with('skills')->findAll();

        if(isset($_POST['Mastak']))
        {
            $mastak->attributes = $_POST['Mastak'];

            if(isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['second_name']))
            {
                $mastak->name = $_POST['last_name'].' '.$_POST['first_name'].' '.$_POST['second_name'];
                if($mastak->validate())
                {
                    if($mastak->save())
                    {
                        if(isset($_POST['Skills']))
                        {
                            foreach($_POST['Skills'] as $skillId => $skillState)
                            {
                                $skill = Skill::model()->findByPk($skillId);
                                if(isset($_POST['SkillCategories'][$skill->skill_category_id]))
                                {
                                    if($_POST['SkillCategories'][$skill->skill_category_id] == 'on' && $skillState == 'on')
                                    {
                                        $mastakSkill = new MastakSkill();
                                        $mastakSkill->mastak_id = $mastak->getPrimaryKey();
                                        $mastakSkill->skill_id = $skillId;
                                        $mastakSkill->save();
                                    }
                                }
                            }
                        }

                        Yii::app()->user->setFlash('SUCCESS', 'Ваша анкета отправлена!');
                        $this->redirect(array('/site/resume'));
                    }
                }
            }
        }

        $this->render('resume', array('skillCategories' => $skillCategories, 'mastak' => $mastak));
    }
    public function actionInit()
    {
        foreach (Problem::model()->findAll() as $problem)
        {
            foreach(Device::model()->findAll() as $device)
            {
                $price = floor(rand(1,10)) * 1000;
                $deviceProblem = new DeviceProblem();
                $deviceProblem->price = $price / 2;
                $deviceProblem->part_price = $price / 2;
                $deviceProblem->device_id = $device->getPrimaryKey();
                $deviceProblem->problem_id = $problem->getPrimaryKey();
                $deviceProblem->active = 1;
                $deviceProblem->save();
            }
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