<?php

namespace App\Services\Countries;

use Illuminate\Support\Collection;

interface CountryService
{
    public function getAllCountries(): Collection;
}
