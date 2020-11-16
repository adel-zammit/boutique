<?php
namespace App\Cron;

use App\Entity\Country;
use Base\BaseApp;
use Base\Cron\AbstractCron;

/**
 * Class updateCountry
 * @package App\Cron
 */
class updateSalesTaxRate extends AbstractCron
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
        $existingCountries = $this->getEntities();

        $reader = BaseApp::http()->getUntrusted('https://euvat.dbtech.co/api/rates/');
        if($reader->getStatusCode() == 301)
        {
            $vatRates = $reader->getContent();
            foreach ($vatRates->rates as $countryCode => $rate)
            {

                if (!isset($existingCountries[$countryCode]))
                {
                    continue;
                }

                /** @var Country $country */
                $country = $existingCountries[$countryCode];

                $country->sales_tax_rate = $rate->standard_rate;
                $country->save();
            }
        }
        return false;
    }
}