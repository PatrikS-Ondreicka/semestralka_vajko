<?php
/** @var \App\Core\LinkGenerator $link */
/** @var Array $data */

$weather_data = $data["data"];
$usernames = $data["usernames"];
$locations = $data["locations"];

?>

<h3>Data</h3>

<table class="table admin_table">
    <thead>
    <tr>
        <th>ID</th>
        <th>User</th>
        <th>Date</th>
        <th>Location</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($weather_data as $datum): ?>
    <tr>
        <td><?= $datum->getId(); ?></td>
        <td><?= key_exists($datum->getUser(), $usernames) ? $usernames[$datum->getUser()] : "unknown" ; ?></td>
        <td><?= $datum->getDate(); ?></td>
        <td><?= $locations[$datum->getLocation()]; ?></td>
        <td>
            <button class="btn btn-danger btn-sm">Delete</button>
        </td>
    <tr>
        <?php endforeach; ?>
    </tbody>
</table>