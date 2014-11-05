<div class="col-md-4">
    <div class="row text-center">
        <a href="<?=$this->createUrl('/admin/addProblemCategory');?>" class="btn btn-warning">Добавить</a>
    </div>
    <?php
        $this->widget('zii.widgets.CListView', array(
            'dataProvider'=> $problemCategories,
            'template' => '{items}',
            'itemView'=>'_problemCategory',
            'itemsTagName' => 'ul',
            'itemsCssClass' => 'nav nav-pills nav-stacked'
        ));
    ?>
</div>
<div class="col-md-8">
    <div class="row text-center">
        <a href="<?=$this->createUrl('/admin/addProblem');?>" class="btn btn-warning">Добавить</a>
    </div>
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider'=>$problems,
        'template' => '{items}{pager}',
        'columns'=>array(
            'name',
        ),
        'itemsCssClass' => 'table',
        'pager' => array('htmlOptions'=>array('class'=>'pagination')),
    ));
    ?>
</div>