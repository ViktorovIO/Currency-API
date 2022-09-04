<?php

namespace App\Models\Dto;

class NewsDto
{
    private string $name;
    private string $link;
    private string $shortDescription;
    private string $image;

    public function __construct(
        string $name,
        string $link,
        string $shortDescription = '',
        string $image = ''
    ) {
        $this->name = $name;
        $this->link = $link;
        $this->shortDescription = $shortDescription;
        $this->image = $image;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function getShortDescription(): string
    {
        return $this->shortDescription;
    }

    public function getImage(): string
    {
        return $this->image;
    }
}
