<?php

namespace App\Services\Countries;

use App\Exceptions\CouldNotGetCountriesException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class RestCountriesCountryService implements CountryService
{
    private string $url = 'https://restcountries.com/v3.1/all?fields=name,flags';

    /**
     * @return Collection<CountryData>
     * @throws CouldNotGetCountriesException
     */
    public function getAllCountries(): Collection
    {
        $response = Http::get($this->url);

        if ($response->failed()) {
            throw new CouldNotGetCountriesException($response->status(), $response->reason());
        }

        return collect($response->json())
            ->map(function (array $country) {
                return new CountryData(
                    data_get($country, 'name.common', ''),
                    data_get($country, 'flags.png', '')
                );
            });
    }
}
