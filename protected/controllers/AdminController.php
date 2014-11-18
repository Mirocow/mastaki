<?php

class AdminController extends Controller
{
    public $layout = '//layouts/admin';
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
        $this->redirect(array('/admin/orders'));
    }

    public function actionDevices()
    {
        $manufacturers = array();
        $devices = array();
        $deviceTypes = DeviceType::model()->findAll(array('order' => 'pos ASC'));

        if(count($deviceTypes) > 0)
            $manufacturers = Manufacturer::model()->findAllByAttributes(array('device_type_id' => $deviceTypes[0]->getPrimaryKey()), array('order' => 'pos ASC'));
        if(count($deviceTypes) > 0 && count($manufacturers) > 0)
            $devices = Device::model()->findAllByAttributes(array('manufacturer_id' => $manufacturers[0]->getPrimaryKey(), 'type_id' => $deviceTypes[0]->getPrimaryKey()), array('order' => 'pos ASC'));

        $this->render('devices', array('deviceTypes' => $deviceTypes, 'manufacturers' => $manufacturers, 'devices' => $devices));
    }
    public function actionCatalog()
    {
        $manufacturers = array();
        $devices = array();
        $problemCategories = array();
        $problems = array();
        $breakdowns = array();
        $deviceBreakdown = null;
        $deviceProblem = null;

        $deviceTypes = DeviceType::model()->findAll(array('order' => 'pos ASC'));

        if(count($deviceTypes) > 0)
            $manufacturers = Manufacturer::model()->findAllByAttributes(array('device_type_id' => $deviceTypes[0]->getPrimaryKey()), array('order' => 'pos ASC'));
        if(count($deviceTypes) > 0 && count($manufacturers) > 0)
            $devices = Device::model()->findAllByAttributes(array('manufacturer_id' => $manufacturers[0]->getPrimaryKey(), 'type_id' => $deviceTypes[0]->getPrimaryKey()), array('order' => 'pos ASC'));

        if(count($deviceTypes) > 0)
            $problemCategories = ProblemCategory::model()->findAllByAttributes(array('device_type_id' => $deviceTypes[0]->getPrimaryKey()), array('order' => 'pos ASC'));
        if(count($problemCategories) > 0 )
            $breakdowns = Problem::model()->findAllByAttributes(array('problem_category_id' => $problemCategories[0]->getPrimaryKey(), 'type' => 'BREAKDOWN'), array('order' => 'pos ASC'));
        if(count($problemCategories) > 0)
            $problems = Problem::model()->findAllByAttributes(array('problem_category_id' => $problemCategories[0]->getPrimaryKey(), 'type' => 'PROBLEM'), array('order' => 'pos ASC'));

        if(count($devices) > 0)
        {
            if(count($breakdowns) > 0)
                $deviceBreakdown = DeviceProblem::model()->findByAttributes(array('device_id' => $devices[0]->getPrimaryKey(), 'problem_id' => $breakdowns[0]->getPrimaryKey()));
            if(count($problems) > 0)
                $deviceProblem = DeviceProblem::model()->findByAttributes(array('device_id' => $devices[0]->getPrimaryKey(), 'problem_id' => $problems[0]->getPrimaryKey()));
        }

        $this->render('catalog', array('deviceTypes' => $deviceTypes, 'manufacturers' => $manufacturers, 'devices' => $devices, 'breakdowns' => $breakdowns, 'problems' => $problems, 'problemCategories' => $problemCategories, 'firstDeviceBreakdown' => $deviceBreakdown, 'firstDeviceProblem' => $deviceProblem));
    }
    public function actionServices()
    {
        $problemCategories = array();
        $problems = array();
        $breakdowns = array();

        $deviceTypes = DeviceType::model()->findAll(array('order' => 'pos ASC'));
        if(count($deviceTypes) > 0)
            $problemCategories = ProblemCategory::model()->findAllByAttributes(array('device_type_id' => $deviceTypes[0]->getPrimaryKey()), array('order' => 'pos ASC'));
        if(count($problemCategories) > 0 )
            $breakdowns = Problem::model()->findAllByAttributes(array('problem_category_id' => $problemCategories[0]->getPrimaryKey(), 'type' => 'BREAKDOWN'), array('order' => 'pos ASC'));
        if(count($problemCategories) > 0)
            $problems = Problem::model()->findAllByAttributes(array('problem_category_id' => $problemCategories[0]->getPrimaryKey(), 'type' => 'PROBLEM'), array('order' => 'pos ASC'));

        $this->render('services', array('deviceTypes' => $deviceTypes, 'problemCategories' => $problemCategories, 'breakdowns' => $breakdowns, 'problems' => $problems));
    }
    public function actionOrders()
    {
        $orders = FixOrder::model()->findAll(array(
            'with' => array('user'),
        ));

        $this->render('orders', array('orders' => $orders));
    }
    public function actionClients()
    {
        $orders = array();

        $users = User::model()->findAllByAttributes(array('role' => 'USER'));

        if(count($users) > 0)
            $orders = FixOrder::model()->findAllByAttributes(array('user_id' => $users[0]->getPrimaryKey()));

        $this->render('clients', array('clients' => $users, 'orders' => $orders));
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