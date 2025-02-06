<?php
/** @var \App\Core\LinkGenerator $link */
/** @var Array $data */
/** @var \App\Core\IAuthenticator $auth */

$folder = $data['folder'];
$errors = $data['errors'];

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
                        <option value="#FF6666" style="background-color: #FF6666;" <?php if ($folder->getColor() == "#FF6666") {echo 'selected';} ?>></option>
                        <option value="#66FF66" style="background-color: #66FF66;" <?php if ($folder->getColor() == "#66FF66") {echo 'selected';} ?>></option>
                        <option value="#6666FF" style="background-color: #6666FF;" <?php if ($folder->getColor() == "#6666FF") {echo 'selected';} ?>></option>
                        <option value="#FFFF99" style="background-color: #FFFF99;" <?php if ($folder->getColor() == "#FFFF99") {echo 'selected';} ?>></option>
                        <option value="#FF66FF" style="background-color: #FF66FF;" <?php if ($folder->getColor() == "#FF66FF") {echo 'selected';} ?>></option>
                        <option value="#66FFFF" style="background-color: #66FFFF;" <?php if ($folder->getColor() == "#66FFFF") {echo 'selected';} ?>></option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Edit Folder</button>
            </form>
        </div>
        <div class="card-footer">
            <?php foreach($errors as $error):?>
                <p class="error_message"><?= $error; ?></p>
            <?php endforeach;?>
        </div>
    </div>
</div>

<script>
    let colorSelect = document.getElementById("color");
    colorSelect.style.backgroundColor = colorSelect.value;
    colorSelect.onchange = function () {
        colorSelect.style.backgroundColor = colorSelect.value;
    }
</script>
