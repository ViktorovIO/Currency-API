<?php

namespace App\Models\News\Dto;

class NewsDto
{
    private string $name;
    private string $link;
    private string $shortDescription;
    private string $image;

    public function __construct(
        string $name,
        string $link,
        string $image = '',
        string $shortDescription = ''
    ) {
        $this->name = $name;
        $this->link = $link;
        $this->image = $image;
        $this->shortDescription = $shortDescription;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getShortDescription(): string
    {
        return $this->shortDescription;
    }
}
