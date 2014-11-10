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

    public function actionManufacturers()
    {
        $manufacturers = new CActiveDataProvider('Manufacturer', array(
            'pagination'=>array(
                'pageSize' => 10,
                'pageVar' =>'page',
            ),
        ));

        $this->render('manufacturers', array('manufacturers' => $manufacturers));
    }

    public function actionDevices()
    {
        $deviceTypes = DeviceType::model()->findAll();
        $manufacturers = Manufacturer::model()->findAllByAttributes(array('device_type_id' => $deviceTypes[0]->getPrimaryKey()));
        $devices = Device::model()->findAllByAttributes(array('manufacturer_id' => $manufacturers[0]->getPrimaryKey(), 'type_id' => $deviceTypes[0]->getPrimaryKey()));

        $this->render('devices', array('deviceTypes' => $deviceTypes, 'manufacturers' => $manufacturers, 'devices' => $devices));
    }
    public function actionAjaxUploadImage()
    {
        $upload_handler = new UploadHandler();
    }
    public function actionProblems($problem_category_id = null)
    {
        $criteria = new CDbCriteria();
        if($problem_category_id !== null)
        {
            $criteria->condition = 'problem_category_id = :id';
            $criteria->params = array(':id' => $problem_category_id);
        }
        $problems = new CActiveDataProvider('Problem', array(
            'criteria' => $criteria,
            'pagination'=>array(
                'pageSize' => 10,
                'pageVar' =>'page',
            ),
        ));

        $problemCategories = new CActiveDataProvider('ProblemCategory', array(
            'pagination' => false,
        ));

        $this->render('problems', array('problems' => $problems, 'problemCategories' => $problemCategories, 'problem_category_id' => $problem_category_id));
    }

    public function actionAddProblemCategory()
    {
        $problemCategory = new ProblemCategory();

        if(isset($_POST['ProblemCategory']))
        {
            $problemCategory->attributes = $_POST['ProblemCategory'];

            if($problemCategory->validate())
            {
                if($problemCategory->save())
                {
                    Yii::app()->user->setFlash('SUCCESS', 'Категория проблемы добавлена');
                    $this->redirect(array('/admin/problems'));
                }
            }
        }

        $this->render('addProblemCategory', array('problemCategory' => $problemCategory));
    }
    public function actionAddProblem()
    {
        $problem= new Problem();

        if(isset($_POST['Problem']))
        {
            $problem->attributes = $_POST['Problem'];

            if($problem->validate())
            {
                if($problem->save())
                {
                    Yii::app()->user->setFlash('SUCCESS', 'Проблема добавлена');
                    $this->redirect(array('/admin/problems'));
                }
            }
        }

        $this->render('addProblem', array('problem' => $problem));
    }

    public function actionAddDevice()
    {
        $device = new Device();

        if(isset($_POST['Device']))
        {
            $device->attributes = $_POST['Device'];

            if($device->validate())
            {
                if($device->save())
                {
                    Yii::app()->user->setFlash('SUCCESS', 'Устройство добавлено');
                    $this->redirect(array('/admin/devices'));
                }
            }
        }

        $this->render('addDevice', array('device' => $device));
    }
    public function actionOrders()
    {
        $orders = FixOrder::model()->findAll(array(
            'with' => array('user'),
        ));

        $this->render('orders', array('orders' => $orders));
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