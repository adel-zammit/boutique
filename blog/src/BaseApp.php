<?php 

class BaseApp
{
    protected function __loader($class)
    {
        include 'src/' . preg_replace('#\\\\#', '/', $class) . '.php';
    }
    public function autoload()
    {
        spl_autoload_register([$this, '__loader']);
    }
}