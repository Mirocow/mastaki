<?php
/** @var $data ProblemCategory */

$problem_category_id = (isset($_GET['problem_category_id'])) ? $_GET['problem_category_id'] : '';
?>

<li <?php echo ($problem_category_id == $data->id) ? 'class="active"' : '';?>>
    <a href="<?=$this->createUrl('/admin/problems', array('problem_category_id' => $data->id));?>"><?=$data->name;?></a>
</li>