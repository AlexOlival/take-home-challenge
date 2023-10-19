<?php

namespace App\Services\Countries;

use Illuminate\Support\Collection;

class MockCountryService implements CountryService
{
    /**
     * @return Collection<CountryData>
     */
    public function getAllCountries(): Collection
    {
        return collect([
            new CountryData('Portugal', 'portugal_flag.png'),
            new CountryData('Malta', 'malta_flag.png'),
        ]);
    }
}
