<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
    <div class="col-md-1">
        <?php
        $this->widget('zii.widgets.CMenu',array(
            'items'=> array(
                array('label' => 'Клиенты', 'url' => array('/admin/clients')),
                array('label' => 'Заказы', 'url' => array('/admin/orders')),
                array('label' => 'Аппараты', 'url' => array('/admin/devices')),
                array('label' => 'Услуги', 'url' => array('/admin/services')),
                array('label' => 'Каталог услуг', 'url' => array('/admin/catalog')),
                array('label' => 'База резюме', 'url' => array('/admin/resume')),
                array('label' => 'Страницы', 'url' => array('/admin/pages')),
            ),
            'submenuHtmlOptions' => array('class' => 'dropdown-menu'),
            'htmlOptions' => array('class'=>'nav nav-pills nav-stacked'),
            'encodeLabel'=> false,
        ));
        ?>
    </div>
    <div class="col-md-11">
        <?php echo $content; ?>
    </div><!-- content -->
<?php $this->endContent(); ?>