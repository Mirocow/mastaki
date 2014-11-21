<div class="col-md-4 mastak-info">
    <div class="well col-md-12">
        <div class="col-md-12" id="name-well">
            <?=$mastak->name;?>
        </div>
        <div class="col-md-12" id="skills-well">
            <?=$mastak->skillsDetail();?>
        </div>
    </div>
    <div class="well col-md-12" id="education-well">
        <?=$mastak->education; ?>
    </div>
</div>
<div class="col-md-8 mastak-info">
    <div class="well col-md-12" id="address-well">
        <?=$mastak->address; ?>
    </div>
    <div class="well col-md-12" id="experience-well">
        <?=$mastak->experience; ?>
    </div>
    <div class="well col-md-12" id="qualities-well">
        <?=$mastak->qualities; ?>
    </div>
</div>