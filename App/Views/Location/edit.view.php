<?php
/** @var \App\Core\LinkGenerator $link */
/** @var Array $data */

$location = $data['location'];
?>

<form action="<?= $link->url("location.edit", ["location_id" => $location->getId()])?>" method="post" id="locationForm">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Edit Location</h5>  </div>
        <div class="card-body">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" class="form-control" value="<?= $location->getName()?>" required>
            </div>

            <div class="form-group">
                <label for="lat">Latitude:</label>
                <input type="number" id="lat" name="lat" class="form-control" step="0.0001" value="<?= $location->getLat();?>" required>
            </div>

            <div class="form-group">
                <label for="lon">Longitude:</label>
                <input type="number" id="lon" name="lon" class="form-control" step="0.0001" value="<?= $location->getLon();?>" required>
            </div>

            <button type="submit" name="submit" class="btn btn-primary">Edit Location</button>
        </div>
    </div>
</form>