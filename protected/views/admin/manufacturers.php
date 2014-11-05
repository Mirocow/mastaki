<?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider'=>$manufacturers,
        'template' => '{items}{pager}',
        'columns'=>array(
            'name',
        ),
        'itemsCssClass' => 'table',
        'pager' => array('htmlOptions'=>array('class'=>'pagination')),
    ));
?>