<?php
/** @var \App\Core\LinkGenerator $link */
/** @var Array $data */
/** @var \App\Core\IAuthenticator $auth */

$folder = $data['folder'];

?>

<div class="container">
    <form action="<?= $link->url("folder.update", ['folder' => $folder->getId()])?>" method="post">
        <div class="mb-3">
            <label for="name" class="form-label">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= $folder->getName() ?>" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description:</label>
            <textarea class="form-control" id="description" name="description"><?= $folder->getDescription() ?></textarea>
        </div>

        <div class="mb-3">
            <label for="color" class="form-label">Color:</label>
            <select class="form-select" id="color" name="color">
                <option value="#FF4040" <?php if ($folder->getColor() == "#FF4040") {echo 'selected';} ?>>
                    <span class="color-option" style="background-color: #FF4040;"></span>Red
                </option>
                <option value="#40FF40" <?php if ($folder->getColor() == "#40FF40") {echo 'selected';} ?>>
                    <span class="color-option" style="background-color: #40FF40;"></span>Green
                </option>
                <option value="#4040FF" <?php if ($folder->getColor() == "#4040FF") {echo 'selected';} ?>>
                    <span class="color-option" style="background-color: #4040FF;"></span>Blue
                </option>
                <option value="#FFFF40" <?php if ($folder->getColor() == "#FFFF40") {echo 'selected';} ?>>
                    <span class="color-option" style="background-color: #FFFF40;"></span>Yellow
                </option>
                <option value="#FF40FF" <?php if ($folder->getColor() == "#FF40FF") {echo 'selected';} ?>>
                    <span class="color-option" style="background-color: #FF40FF;"></span>Magenta
                </option>
                <option value="#40FFFF" <?php if ($folder->getColor() == "#40FFFF") {echo 'selected';} ?>>
                    <span class="color-option" style="background-color: #40FFFF;"></span>Cyan
                </option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Edit Folder</button>
    </form>
</div>
