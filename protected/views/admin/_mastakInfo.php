<div class="col-md-4 mastak-info">
    <div class="well col-md-12">
        <div class="col-md-12" id="name-well">
            <?=$mastak->name;?>
        </div>
        <div class="col-md-12" id="skills-well">
            <?=$mastak->skillsDetail();?>
        </div>
    </div>
    <div class="col-md-12 table-responsive mastak-reviews" id="mastak-reviews" mastak-id="<?=$mastak->id;?>">
        <?php $this->renderPartial('_reviews', array('reviews' => $reviews)); ?>
    </div>
    <div class="col-md-12 mastak-review-form">
        <div class="col-md-12">
            <textarea class="col-md-12 form-control" id="mastak-review-content"></textarea>
        </div>
        <div class="text-center col-md-12">
            <button class="btn btn-success" id="mastak-add-review">Добавить комментарий</button>
        </div>
    </div>
</div>
<div class="col-md-8 mastak-info">
    <div class="well col-md-12" id="address-well">
        <?=$mastak->address; ?>
    </div>
    <div class="well col-md-12" id="education-well">
        <?=$mastak->education; ?>
    </div>
    <div class="well col-md-12" id="experience-well">
        <?=$mastak->experience; ?>
    </div>
    <div class="well col-md-12" id="qualities-well">
        <?=$mastak->qualities; ?>
    </div>
</div>