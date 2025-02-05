<?php
/** @var \App\Core\LinkGenerator $link */
/** @var Array $data */

$weather_data = $data["weather_date"];
$location = $data['location'];

?>

<h3>Data in location: <?= $location->getName() ?></h3>

<table class="table admin_table">
    <thead>
    <tr>
        <th>ID</th>
        <th>Date</th>
        <th>Temperature</th>
        <th>Humidity</th>
        <th>Wind Speed</th>
        <th>Wind Direction</th>
        <th>Precipitation</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($weather_data as $datum): ?>
    <tr>
        <td><?= $datum->getId(); ?></td>
        <td><?= $datum->getDate(); ?></td>
        <td><?= $datum->getTemperature(); ?></td>
        <td><?= $datum->getHumidity(); ?></td>
        <td><?= $datum->getWindSpeed(); ?></td>
        <td><?= $datum->getWindDirection(); ?></td>
        <td><?= $datum->getPrecipitation(); ?></td>
        <td>
            <a href="<?= $link->url("data.detail", ["dataId" => $datum->getId()])?>" class="btn btn-primary btn-sm">View</a>
        </td>
    <tr>
        <?php endforeach; ?>
    </tbody>
</table>