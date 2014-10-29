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

    public function getNavBar()
    {
        $deviceTypes = DeviceType::model()->findAll();


        $items = array();

        foreach($deviceTypes as $category)
        {
            $items[] = array('label'=>  $category->name  , 'url' => array('/site/deviceType', 'type_id' => $category->id));
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