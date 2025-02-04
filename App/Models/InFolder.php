<?php

namespace App\Models;

use App\Core\Model;

class InFolder extends Model
{
    protected ?int $id = null;

    protected ?int $data = null;
    protected ?int $folder = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getData(): ?int
    {
        return $this->data;
    }

    public function setData(?int $data): void
    {
        $this->data = $data;
    }

    public function getFolder(): ?int
    {
        return $this->folder;
    }

    public function setFolder(?int $folder): void
    {
        $this->folder = $folder;
    }

    public static function getTableName() : string
    {
        return "in_folder";
    }

    public static function exists(?int $folder, ?int $data) : bool
    {
        $fetched = InFolder::getAll("`folder` = ? and `data` = ?", [$folder, $data]);
        return count($fetched) > 0;
    }
}