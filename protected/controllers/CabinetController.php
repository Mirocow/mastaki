<?php

class CabinetController extends Controller
{
    public $layout = '//layouts/cabinet';

    public function actionIndex()
    {
        $orders = new CActiveDataProvider('FixOrder', array(
            'criteria' => array(
                'with' => array(
                    'orderProblems' => array(
                        'with' => array(
                            'deviceProblem' => array(
                                'with' => array('device', 'problem'),
                            )
                        ),
                    )
                ),
            ),
            'pagination'=>array(
                'pageSize' => 10,
                'pageVar' =>'page',
            ),
        ));

        $this->render('index', array('orders' => $orders));
    }

    public function actionSettings()
    {
        $user = User::model()->findByPk(Yii::app()->user->getId());
        $review = new Review();

        if(isset($_POST['User']))
        {
            $user->attributes = $_POST['User'];
            if($user->validate())
            {
                if($user->save())
                    Yii::app()->user->setFlash('SUCCESS', 'Данные профиля сохранены');
                else
                    Yii::app()->user->setFlash('ERROR', 'Данные профиля не сохранены');

                $this->redirect(array('cabinet/settings'));
            }
        }
        if(isset($_POST['Review']))
        {
            $review->attributes = $_POST['Review'];
            $review->user_id = (int)Yii::app()->user->getId();
            $review->created = $this->sqlDateTime();
            if($review->validate())
            {
                if($review->save())
                    Yii::app()->user->setFlash('SUCCESS', 'Отзыв отправлен');
                else
                    Yii::app()->user->setFlash('ERROR', 'Отзыв не отправлен');

                $this->redirect(array('cabinet/settings'));
            }
        }

        $this->render('settings', array('user' => $user, 'review' => $review));
    }
}