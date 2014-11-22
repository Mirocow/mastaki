<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
$this->layout = '//layouts/standard';
?>

<div class="alert alert-danger">
    <?php if($code !== 0) { ?><strong>Ошибка <?php echo $code; ?></strong><?php } ?><?php echo CHtml::encode($message); ?>
</div>