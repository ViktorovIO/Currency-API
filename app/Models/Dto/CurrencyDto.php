<?php

namespace App\Models\Dto;

class CurrencyDto
{
    private string $numCode;
    private string $charCode;
    private int $nominal;
    private string $nameSingle;
    private string $nameMany;
    private float $value;

    public function __construct(
        string $numCode,
        string $charCode,
        int $nominal,
        string $nameSingle,
        string $nameMany,
        float $value
    ) {
        $this->numCode = $numCode;
        $this->charCode = $charCode;
        $this->nominal = $nominal;
        $this->nameSingle = $nameSingle;
        $this->nameMany = $nameMany;
        $this->value = $value;
    }

    public function getNumCode(): string
    {
        return $this->numCode;
    }

    public function getCharCode(): string
    {
        return $this->charCode;
    }

    public function getNominal(): int
    {
        return $this->nominal;
    }

    public function getNameSingle(): string
    {
        return $this->nameSingle;
    }

    public function getNameMany(): string
    {
        return $this->nameMany;
    }

    public function getValue(): float
    {
        return $this->value;
    }
}
