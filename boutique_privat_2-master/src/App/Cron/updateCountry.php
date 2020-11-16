<?php
namespace App\Cron;

use App\Entity\Country;
use Base\BaseApp;
use Base\Cron\AbstractCron;

/**
 * Class updateCountry
 * @package App\Cron
 */
class updateCountry extends AbstractCron
{
    /**
     * @return mixed|string
     */
    protected function Entity()
    {
        return 'App:Country';
    }

    /**
     * @return array|mixed
     */
    protected function Where()
    {
        return [];
    }

    /**
     * @return bool|mixed
     */
    protected function limit()
    {
        return false;
    }

    /**
     * @return mixed|string
     */
    protected function type()
    {
        return 'save';
    }

    /**
     * @return bool|mixed
     */
    protected function execute()
    {
        return false;
    }

    /**
     * @return bool|mixed
     * @throws \Exception
     */
    protected function algorithmRun()
    {
        $reader = BaseApp::http()->getUntrusted('https://restcountries.eu/rest/v2/all');
        $return = false;
        $existingCountries = $this->getEntities();
        if($reader->getStatusCode() == 200)
        {

            $responses = $reader->getContent();
            $currentCountries = [];
            foreach ($responses as $response)
            {
                if (!isset($existingCountries[$response->alpha2Code]))
                {
                    /** @var Country $newCountry */
                    $newCountry = $this->create($this->Entity());
                    $newCountry->country_code = $response->alpha2Code;
                    $newCountry->name = $response->name;
                    $newCountry->native_name = $response->nativeName;
                    $newCountry->iso_code = $response->alpha3Code;
                    $newCountry->save();

                    $currentCountries[$response->alpha2Code] = $newCountry;
                }
                else
                {
                    /** @var Country $newCountry */
                    $newCountry = $existingCountries[$response->alpha2Code];

                    if ($newCountry->name != $response->name)
                    {
                        $newCountry->name = $response->name;
                    }

                    $currentCountries[$response->alpha2Code] = $newCountry;
                }
            }
            $missingCountries = array_diff_key($existingCountries->toArray(), $currentCountries);

            foreach ($missingCountries as $country)
            {
                $country->delete();
            }
        }
        return $return;
    }
}