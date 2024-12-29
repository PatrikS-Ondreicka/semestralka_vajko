<?php

namespace App\Models;

use App\Core\Model;

class Profile extends Model
{
    protected ?int $id;
    protected ?int $user;
    protected ?string $description;
    protected ?string $profile_pic;

    protected ?string $date_created;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getUser(): ?int
    {
        return $this->user;
    }

    public function setUser(?int $user): void
    {
        $this->user = $user;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getProfilePic(): ?string
    {
        return $this->profile_pic;
    }

    public function setProfilePic(?string $profile_pic): void
    {
        $this->profile_pic = $profile_pic;
    }

    public function getDateCreated(): ?string
    {
        return $this->date_created;
    }

    public function setDateCreated(?string $date_created): void
    {
        $this->date_created = $date_created;
    }


}