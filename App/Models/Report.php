<?php

namespace App\Models;

use App\Core\Model;

class Report extends Model
{
    protected ?int $id;
    protected ?int $data;
    protected ?int $user;
    protected ?int $reports_type;

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

    public function getUser(): ?int
    {
        return $this->user;
    }

    public function setUser(?int $user): void
    {
        $this->user = $user;
    }

    public function getReportsType(): ?int
    {
        return $this->reports_type;
    }

    public function setReportsType(?int $reports_type): void
    {
        $this->reports_type = $reports_type;
    }

}