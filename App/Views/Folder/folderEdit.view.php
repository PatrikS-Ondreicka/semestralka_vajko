<?php
/** @var \App\Core\LinkGenerator $link */
/** @var Array $data */
/** @var \App\Core\IAuthenticator $auth */

$folder = $data['folder'];

?>

<div class="container">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title text-center">Create New Folder</h4>
        </div>
        <div class="card-body">
            <form action="<?= $link->url("folder.update", ['folder' => $folder->getId()])?>" method="post">
                <div class="mb-3">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= $folder->getName() ?>" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description:</label>
                    <textarea class="form-control" id="description" name="description" rows="3"><?= $folder->getDescription() ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="color" class="form-label">Color:</label>
                    <select class="form-select" id="color" name="color">
                        <option value="#FF0000" style="background-color: #FF0000;" <?php if ($folder->getColor() == "#FF0000") {echo 'selected';} ?>></option>
                        <option value="#00FF00" style="background-color: #00FF00;" <?php if ($folder->getColor() == "#00FF00") {echo 'selected';} ?>></option>
                        <option value="#0000FF" style="background-color: #0000FF;" <?php if ($folder->getColor() == "#0000FF") {echo 'selected';} ?>></option>
                        <option value="#FFFF00" style="background-color: #FFFF00;" <?php if ($folder->getColor() == "#FFFF00") {echo 'selected';} ?>></option>
                        <option value="#FF00FF" style="background-color: #FF00FF;" <?php if ($folder->getColor() == "#FF00FF") {echo 'selected';} ?>></option>
                        <option value="#00FFFF" style="background-color: #00FFFF;" <?php if ($folder->getColor() == "#00FFFF") {echo 'selected';} ?>></option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Edit Folder</button>
            </form>
        </div>
    </div>
</div>
