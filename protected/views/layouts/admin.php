<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
    <div class="col-md-2">
        <?php
        $this->widget('zii.widgets.CMenu',array(
            'items'=> array(
                array('label' => 'Заказы', 'url' => array('/admin/orders')),
                array('label' => 'Производители', 'url' => array('/admin/manufacturers')),
                array('label' => 'Аппараты', 'url' => array('/admin/devices')),
                array('label' => 'Услуги', 'url' => array('/admin/services')),
            ),
            'submenuHtmlOptions' => array('class' => 'dropdown-menu'),
            'htmlOptions' => array('class'=>'nav nav-pills nav-stacked'),
            'encodeLabel'=> false,
        ));
        ?>
    </div>
    <div class="col-md-10">
        <?php echo $content; ?>
    </div><!-- content -->
<?php $this->endContent(); ?>