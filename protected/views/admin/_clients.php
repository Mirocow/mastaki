<table class="table table-striped">
    <tr>
        <th>№</th><th>Имя</th><th>Телефон</th><th>К</th><th>%</th>
    </tr>
    <?php
        foreach($clients as $client)
        {
            echo '<tr client-id="'.$client->id.'"><td>'.$client->id.'</td><td>'.$client->name.'</td><td>'.$client->phone.'</td><td></td><td>'.$client->discount.'</td></tr>';
        }
    ?>
</table>