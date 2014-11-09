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
        $devices = new CActiveDataProvider('Device', array(
            'pagination'=>array(
                'pageSize' => 10,
                'pageVar' =>'page',
            ),
        ));

        $this->render('devices', array('devices' => $devices));
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

    public function actionAjaxGetOrders()
    {
        $response = array();
        $condition = '';
        if(isset($_POST['filter']))
            $condition = "t.id = '".$_POST['filter']."' OR user.name LIKE '%".$_POST['filter']."%'";

        $orders = FixOrder::model()->findAll(array(
            'condition' => $condition,
            'with' => array('user'),
        ));

        foreach($orders as $order)
            $response[] = array('id' => $order->id, 'name' => $order->user->name, 'status' => $order->status);

        print json_encode($response);
    }
    public function actionAjaxGetOrder($id)
    {
        $response = array();
        $order = FixOrder::model()->find(array(
            'condition' => 't.id = :id',
            'params' => array(':id' => $id),
            'with' => array(
                'orderProblems' => array(
                    'with' => array(
                        'deviceProblem' => array(
                            'with' => array('device', 'problem'),
                        )
                    ),
                ),
                'user',
            ),
        ));

        $response['output'] = $this->renderPartial('_order', array('data' => $order), true);
        $response['problems'] = CHtml::listData(DeviceProblem::model()->findAllByAttributes(array('device_id' => FixOrder::model()->findByPk($id)->getDevice())), 'id', 'problem.name');
        print json_encode($response);
    }


    public function actionAjaxSaveOrder()
    {
        if(isset($_POST['data']))
        {
            $data = json_decode($_POST['data']);
            $order = FixOrder::model()->findByPk($data->orderId);
            $order->status = $data->orderStatus;
            $order->save();

            $totalPrice = 0;
            $orderProblems = OrderProblem::model()->with('deviceProblem')->findAllByAttributes(array('fix_order_id' => $order->getPrimaryKey()));
            foreach($orderProblems as $orderProblem)
                $totalPrice += $orderProblem->deviceProblem->price;

            foreach($data->problemStatuses as $problemStatus)
            {
                $dbProblemStatus = OrderProblem::model()->findByPk($problemStatus->id);
                $dbProblemStatus->status = $problemStatus->status;
                $dbProblemStatus->discount = $problemStatus->discount;
                $dbProblemStatus->save();
            }
            $newPrice = $order->getTotalPrice();
            $newDiscount = $order->getTotalDiscount();
            print json_encode(array('result' => 'SUCCESS', 'orderId' => $order->getPrimaryKey(), 'newPrice' => $newPrice, 'newDiscount' => $newDiscount));
        }
        else
            print json_encode(array('result' => 'ERROR'));

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