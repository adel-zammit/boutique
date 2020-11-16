<?php
namespace App\Cron;

use Base\BaseApp;
use Base\Cron\AbstractCron;

class ClearProductImg extends AbstractCron
{
    protected function Entity()
    {
        return 'App:ProductImg';
    }
    protected function Where()
    {
        return [
            'product_id' => 0
        ];
    }
    protected function limit()
    {
        return false;
    }
    protected function type()
    {
        return 'delete';
    }
    protected function execute()
    {
        return true;
    }

    protected function algorithmRun()
    {
        return false;
    }
}