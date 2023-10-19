<?php

namespace App\Http\Controllers;

use App\Exceptions\CouldNotGetCountriesException;
use App\Http\Resources\CountryResource;
use App\Services\Countries\CountryService;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpFoundation\Response;

class CountryController extends Controller
{
    public function __construct(private CountryService $countryService) {}

    public function index()
    {
        if (Redis::exists('countries')) {
            $countries = json_decode(Redis::get('countries'));

            return CountryResource::collection($countries);
        }

        try {
            $countries = $this->countryService->getAllCountries();
        } catch (CouldNotGetCountriesException $exception) {
            abort(
                Response::HTTP_SERVICE_UNAVAILABLE,
                "Could not obtain country data.
                 Request to external API failed with status code {$exception->getStatusCode()} and
                 message '{$exception->getMessage()}'"
            );
        }

        // Cache the countries for just one day - the world can be crazy!
        Redis::setex('countries', 86_400, json_encode($countries));

        return CountryResource::collection($countries);
    }
}
