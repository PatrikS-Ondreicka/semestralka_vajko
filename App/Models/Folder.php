<?php

namespace App\Models;

use App\Core\Model;
use App\Core\DB\Connection;
use PDO;

class Folder extends Model
{
    protected ?int $id = null;

    protected ?string $name = null;
    protected ?string $description = null;
    protected ?string $color = null;
    protected ?int $owner = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): void
    {
        $this->color = $color;
    }

    public function getOwner(): ?int
    {
        return $this->owner;
    }

    public function setOwner(?int $owner): void
    {
        $this->owner = $owner;
    }

    public function getAllFromFolder(): array
    {
        $in_folder_data = InFolder::getAll("folder = ?", [$this->id]);
        $res_array = [];
        foreach ($in_folder_data as $in_folder)
        {
            $res_array[] = Data::getOne($in_folder->getData());
        }
        return $res_array;
    }
}