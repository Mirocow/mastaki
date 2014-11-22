<table class="table table-striped">
    <tr>
        <th>№</th><th>Имя</th><th>Телефон</th><th>К</th><th>%</th>
    </tr>
    <?php
        foreach($clients as $client)
        {
            echo '<tr class="client-row" client-id="'.$client->id.'"><td>'.$client->id.'</td><td>'.$client->name.'</td><td>'.$client->phone.'</td><td>'.count($client->orders).'</td><td>'.$client->discount.'</td></tr>';
        }
    ?>
</table>