<?php
    $this->widget('zii.widgets.CListView', array(
        'dataProvider'=> $orders,
        'template' => '{items}',
        'itemView'=>'_order',
        'itemsCssClass' => 'table-responsive'
        /*'sortableAttributes'=>array(
            'rating',
            'create_time',
        ),*/
    ));
?>
