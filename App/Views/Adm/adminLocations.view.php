<?php
/** @var \App\Core\LinkGenerator $link */
/** @var Array $data */

$locations = $data["locations"];

?>

<h3>Locations</h3>

<table class="table admin_table">
    <thead>
    <tr>
        <th>ID</th>
        <th>Lon</th>
        <th>Lat</th>
        <th>Name</th>
    </tr>
    </thead>
    <tbody>
        <?php foreach ($locations as $location): ?>
        <tr>
            <td><?= $location->getId(); ?></td>
            <td><?= $location->getLon(); ?></td>
            <td><?= $location->getLat(); ?></td>
            <td><?= $location->getName(); ?></td>
            <td class="buttons_col">
                <a href="<?= $link->url("location.edit", ["location_id" => $location->getId()])?>" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i>Edit</a>
                <a href="<?= $link->url("location.delete", ["location_id" => $location->getId()])?>" class="btn btn-danger btn-sm"><i class="bi bi-trash3-fill"></i>Delete</a>
            </td>
        <tr>
        <?php endforeach; ?>
    </tbody>
</table>