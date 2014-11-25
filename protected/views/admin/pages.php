<h3 class="col-md-12 page-header">
    Страницы
</h3>
<div class="col-md-12 row">
    <?php $this->showMessages();?>
</div>
<div class="row col-md-12">
    <a href="<?=$this->createUrl('admin/newPage');?>" class="btn btn-warning"><i class="fa fa-plus"></i> Новая</a>
</div>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=> $pages,
    'template' => "{items}{pager}",
    'columns'=>array(
        'title',
        array(
            'header' => '',
            'type' => 'raw',
            'value' => 'Html::pageEditButton($data->id)',
        ),
    ),
    'itemsCssClass' => 'table table-striped',
    'pager' => array('htmlOptions'=>array('class'=>'pagination')),
));