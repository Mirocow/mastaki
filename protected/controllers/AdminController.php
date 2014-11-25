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
        $this->redirect(array('/admin/clients'));
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
    public function actionOrders($id = null)
    {
        $counters = array();
        $problems = array();
        $reviews = array();

        $showOrder = null;

        if($id !== null)
        {
            $showOrder = FixOrder::model()->find(array(
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
            $problems = CHtml::listData(DeviceProblem::model()->findAllByAttributes(array('device_id' => FixOrder::model()->findByPk($id)->getDevice())), 'id', 'problem.name');

            if($showOrder !== null)
                $reviews = OrderComment::model()->findAllByAttributes(array('fix_order_id' => $showOrder->getPrimaryKey()));
        }


        $counters['ALL'] = FixOrder::model()->count();

        foreach(Core::orderStatuses() as $status=>$val)
            $counters[$status] = FixOrder::model()->countByAttributes(array('status' => $status));

        $orders = FixOrder::model()->findAll(array(
            'with' => array('user'),
        ));

        $this->render('orders', array('orders' => $orders, 'counters' => $counters, 'showOrder' => $showOrder, 'problems' => $problems, 'reviews' => $reviews));
    }
    public function actionClients()
    {
        $orders = array();
        $reviews = array();

        $users = User::model()->findAllByAttributes(array('role' => 'USER'));

        if(count($users) > 0)
        {
            $orders = FixOrder::model()->findAllByAttributes(array('user_id' => $users[0]->getPrimaryKey()));
            $reviews = Review::model()->findAllByAttributes(array('user_id' => $users[0]->getPrimaryKey()));
        }

        $this->render('clients', array('clients' => $users, 'orders' => $orders, 'reviews' => $reviews));
    }

    public function actionResume()
    {
        $mastaki = Mastak::model()->findAll();
        if(count($mastaki) > 0)
            $reviews = MastakReview::model()->findAllByAttributes(array('mastak_id' => $mastaki[0]->getPrimaryKey()));

        $this->render('resume', array('mastaki' => $mastaki, 'reviews' => $reviews));
    }

    public function actionPages()
    {
        $pages = new CActiveDataProvider('Page', array(
            'criteria' => array(
                'order' => 'id DESC',
            ),
            'pagination' => array(
                'pageSize' => 20,
            ),
        ));

        $this->render('pages', compact('pages'));
    }
    public function actionPage($id)
    {
        $page = Page::model()->findByPk($id);

        if($page !== null)
        {
            if(isset($_POST['Page']))
            {
                $page->attributes = $_POST['Page'];
                if($page->validate())
                {
                    if($page->save())
                        Yii::app()->user->setFlash('SUCCESS', 'Страница сохранена!');

                    $this->redirect(array('/admin/pages'));
                }
            }
            $this->render('page', compact('page'));
        }
        else
            $this->redirect(array('/admin/pages'));
    }
    public function actionNewPage()
    {
        $page = new Page();
        if(isset($_POST['Page']))
        {
            $page->attributes = $_POST['Page'];
            if($page->validate())
            {
                if($page->save())
                    Yii::app()->user->setFlash('SUCCESS', 'Страница создана!');

                $this->redirect(array('/admin/pages'));
            }
        }
        $this->render('newPage', compact('page'));
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