<?php

namespace App\Models;

use App\Core\Model;

class ReportType extends Model
{
    protected ?int $id;
    protected ?string $description;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public static function asValueKeyPairs(): array
    {
        $types = ReportType::getAll();
        $result = [];
        foreach ($types as $type) {
            $result[$type->getId()] = $type->getDescription();
        }
        return $result;
    }

    public static function getTableName() : string
    {
        return "report_types";
    }
}