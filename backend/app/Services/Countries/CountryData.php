<?php

namespace App\Services\Countries;

class CountryData
{
    public function __construct(public readonly string $name, public readonly string $flagUrl) {}
}
