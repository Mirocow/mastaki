<table class="table table-striped">
    <?php
        foreach($mastaki as $mastak)
        {
            echo '<tr class="mastak-row" mastak-id="'.$mastak->id.'" old-status="'.$mastak->status.'"><td>'.$mastak->id.'</td><td>'.$mastak->name.'</td><td>'.$mastak->phone.'</td><td>'.$mastak->skillsLine().'</td><td>'.CHtml::dropDownList('mastakStatus', $mastak->status, Core::mastakStatuses(), array('class' => 'form-control input-sm mastak-status-select','mastak-id' => $mastak->id)).'</td></tr>';
        }
    ?>
</table>