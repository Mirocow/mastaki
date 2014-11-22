<table class="table table-striped">
    <?php
        foreach($reviews as $review)
        {
            echo '<tr><td>'.$review->created.'</td><td>'.$review->content.'</td></tr>';
        }
    ?>
</table>