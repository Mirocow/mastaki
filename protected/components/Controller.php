<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/main';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

    public function filterCart($filterChain)
    {
        if(!isset(Yii::app()->user->cart) && !Yii::app()->user->isGuest)
            Yii::app()->user->setState('cart', array());

        $filterChain->run();
    }

    public function sqlDateTime()
    {
        $now = new DateTime();
        return $now->format('Y-m-d H:i:s');
    }

    public function showMessages($model = null)
    {
        if($model === null)
            $errors = array();
        else
            $errors = $model->getErrors();

        if(count($errors) > 0)
        {
            echo '<div class="row">';
            foreach($errors as $error)
            {
                echo '<div class="alert alert-dismissable alert-danger">';
                echo '<button type="button" class="close" data-dismiss="alert">×</button>';
                echo '<strong>'.$error[0].'</strong>';
                echo '</div>';
                break;
            }
            echo '</div>';
        }
        elseif(Yii::app()->user->hasFlash('SUCCESS'))
        {
            echo '<div class="alert alert-dismissable alert-success">';
            echo '<button type="button" class="close" data-dismiss="alert">×</button>';
            echo '<strong>'.Yii::app()->user->getFlash('SUCCESS').'</strong>';
            echo '</div>';
        }
        elseif(Yii::app()->user->hasFlash('ERROR'))
        {
            echo '<div class="alert alert-dismissable alert-danger">';
            echo '<button type="button" class="close" data-dismiss="alert">×</button>';
            echo '<strong>'.Yii::app()->user->getFlash('ERROR').'</strong>';
            echo '</div>';
        }
    }

    public function getNavBar()
    {
        $deviceTypes = DeviceType::model()->findAll();


        $items = array();

        foreach($deviceTypes as $category)
        {
            $items[] = array('label'=>  $category->name  , 'url' => array('/site/deviceType', 'type_id' => $category->id));
        }

        $items[] = array('label' => 'Личный кабинет', 'url' => array('/cabinet/index'), 'visible' => !Yii::app()->user->isGuest);

        if(isset(Yii::app()->user->role))
        {
            if(Yii::app()->user->role == 'ADMIN')
                $items[] = array('label' => 'Админка', 'url' => array('/admin/index'), 'visible' => !Yii::app()->user->isGuest);
        }

        $this->widget('zii.widgets.CMenu',array(
            'items'=> $items,
            'submenuHtmlOptions' => array('class' => 'dropdown-menu'),
            'htmlOptions' => array('class'=>'nav navbar-nav'),
            'encodeLabel'=> false,
        ));
    }

    public function getCart()
    {
        return Yii::app()->user->cart;
    }



}