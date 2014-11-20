<table class="table table-striped">
    <?php
        foreach($mastaki as $mastak)
        {
            echo '<tr class="mastak-row" mastak-id="'.$mastak->id.'"><td>'.$mastak->id.'</td><td>'.$mastak->name.'</td><td>'.$mastak->phone.'</td><td>'.$mastak->skillsLine().'</td><td>'.$mastak->status.'</td></tr>';
        }
    ?>
</table>