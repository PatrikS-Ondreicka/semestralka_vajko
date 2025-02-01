<?php
/** @var \App\Core\LinkGenerator $link */
/** @var Array $data */

$location = $data['location'];
?>

<form action="<?= $link->url("location.edit", ["location_id" => $location->getId()]) ?>" method="post" id="locationForm">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" value="<?= $location->getName() ?>" required><br><br>

    <label for="lat" class="form-label">Latitude</label>
    <input type="number" id="lat" name="lat" class="form-control" step="0.0001" value="<?= $location->getLat(); ?>" required><br><br>

    <label for="lon" class="form-label">Longitude</label>
    <input type="number" id="lon" name="lon" class="form-control" step="0.0001" value="<?= $location->getLon(); ?>" required><br><br>

    <input type="submit" name="submit" value="Edit Location">
</form>