
<div class="row text-center">
    <a href="<?=$this->createUrl('/admin/addDevice');?>" class="btn btn-warning">Добавить</a>
</div>
<?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider'=> $devices,
        'template' => '{items}{pager}',
        'columns'=>array(
            'name',
        ),
        'itemsCssClass' => 'table',
        'pager' => array('htmlOptions'=>array('class'=>'pagination')),
    ));
?>