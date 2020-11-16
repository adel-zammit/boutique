<?php
namespace Base;

use Base\BaseApp;
use Base\Router\Router;

class App
{
    /**
     * @var string
     */
    protected $type;

    /**
     * @var Router
     */
    protected $router;

    /**
     * @var array
     */
    protected $globalRoute = [];

    /**
     * App constructor.
     * @param $type
     */
    public function __construct($type)
    {
        $this->type = $type;
        $this->router = new Router($this);
        $this->setRouters();
    }
    /**
     *
     */
    protected function setRouters()
    {
        $this->globalRoute = [
            'Admin' => [
                'DefaultRouter' => [
                    '' => [
                        'controller' => 'App:Home',
                        'context' => 'home',
                        'title' => '<!--TITLE-->',
                        'description' => false
                    ]
                ],
                'connexion' => [
                    '' => [
                        'controller' => 'App:Connexion',
                        'context' => 'connexion',
                        'title' => '<!--TITLE-->',
                        'RouteFormat' => null,
                        'description' => false,
                        'newPage' => true
                    ]
                ],
                'product' => [
                    '' => [
                        'controller' => 'App:Product',
                        'context' => 'product',
                        'title' => '<!--TITLE-->',
                        'RouteFormat' => ':int<product_id,title>/',
                        'description' => false,
                    ]
                ],
                'coupon' => [
                    '' => [
                        'controller' => 'App:Coupon',
                        'context' => 'coupon',
                        'title' => '<!--TITLE-->',
                        'RouteFormat' => ':int<coupon_id,title>/',
                        'description' => false,
                    ]
                ],
                'users' => [
                    '' => [
                        'controller' => 'App:Users',
                        'context' => 'users',
                        'title' => '<!--TITLE-->',
                        'RouteFormat' => ':int<user_id,username>/',
                        'description' => false,
                    ]
                ],
                'category' => [
                    'technical-data-sheet' => [
                        'controller' => 'App:Category',
                        'context' => 'technical-data-sheet',
                        'title' => '<!--TITLE-->',
                        'RouteFormat' => 'technical-data-sheet/:int<technical_data_sheet_id>/',
                        'description' => false,
                    ],
                    '' => [
                        'controller' => 'App:Category',
                        'context' => 'category',
                        'title' => '<!--TITLE-->',
                        'RouteFormat' => ':int<category_id,name>/',
                        'description' => false,
                    ]
                ],
                'address' => [
                    '' => [
                        'controller' => 'App:Address',
                        'context' => 'address',
                        'title' => '<!--TITLE-->',
                        'RouteFormat' => ':int<address_id,name>/:page',
                        'description' => false
                    ]
                ],
                'cron' => [
                    '' => [
                        'controller' => 'App:Cron',
                        'context' => 'cron',
                        'title' => '<!--TITLE-->',
                        'RouteFormat' => ':int<cron_id,title>/',
                        'description' => false
                    ]
                ],
                'sales-tax' => [
                    '' => [
                        'controller' => 'App:SalesTax',
                        'context' => 'sales-tax',
                        'title' => '<!--TITLE-->',
                        'RouteFormat' => ':str<country_code>/:page',
                        'description' => false
                    ]
                ],
                'log' => [
                    'order' => [
                        'controller' => 'App:Log',
                        'context' => 'log-order',
                        'title' => '<!--TITLE-->',
                        'RouteFormat' => 'order/:int<invoice_id>/:page',
                        'description' => false,
                    ],
                    'coupon' => [
                        'controller' => 'App:Log',
                        'context' => 'log-coupon',
                        'title' => '<!--TITLE-->',
                        'RouteFormat' => 'coupon/:int<coupon_log_id>/:page',
                        'description' => false,
                    ],
                    'payment' => [
                        'controller' => 'App:Log',
                        'context' => 'log-payment',
                        'title' => '<!--TITLE-->',
                        'RouteFormat' => 'payment/:int<provider_log_id>/:page',
                        'description' => false,
                    ],
                    'addresses' => [
                        'controller' => 'App:Log',
                        'context' => 'log-addresses',
                        'title' => '<!--TITLE-->',
                        'RouteFormat' => 'addresses/:int_int<address_id,invoice_id>/:page',
                        'description' => false,
                    ],
                    '' => [
                        'controller' => 'App:Log',
                        'context' => 'log',
                        'title' => '<!--TITLE-->',
                        'RouteFormat' => null,
                        'description' => false,
                    ]
                ],
            ],
            'Pub' => [
                'DefaultRouter' => [
                    '' => [
                        'controller' => 'App:Home',
                        'context' => 'home',
                        'title' => '<!--TITLE-->',
                        'description' => true
                    ]
                ],
                'login' => [
                    '' => [
                        'controller' => 'App:Login',
                        'context' => 'login',
                        'title' => '<!--TITLE-->',
                        'RouteFormat' => null,
                        'description' => false
                    ]
                ],
                'product' => [
                    'categories' => [
                        'controller' => 'App:Product',
                        'context' => 'product',
                        'title' => '<!--TITLE-->',
                        'RouteFormat' => 'categories/:int<category_id,name>/:page',
                        'description' => false
                    ],
                    '' => [
                        'controller' => 'App:Product',
                        'context' => 'product',
                        'title' => '<!--TITLE-->',
                        'RouteFormat' => ':int<product_id,title>/:page',
                        'description' => false
                    ]
                ],
                'carts' => [
                    '' => [
                        'controller' => 'App:Carts',
                        'context' => 'carts',
                        'title' => '<!--TITLE-->',
                        'RouteFormat' => null,
                        'description' => false
                    ]
                ],
                'address' => [
                    '' => [
                        'controller' => 'App:Address',
                        'context' => 'address',
                        'title' => '<!--TITLE-->',
                        'RouteFormat' => ':int<address_id,name>/',
                        'description' => false
                    ]
                ],
                'invoices' => [
                    '' => [
                        'controller' => 'App:Invoices',
                        'context' => 'invoices',
                        'title' => '<!--TITLE-->',
                        'RouteFormat' => ':int<invoice_id>/',
                        'description' => false
                    ]
                ],
                'purchase' => [
                    '' => [
                        'controller' => 'App:Purchase',
                        'context' => 'purchase',
                        'title' => '<!--TITLE-->',
                        'RouteFormat' => ':str<purchasable_type_id>/',
                        'description' => false
                    ]
                ],
                'account' => [
                    '' => [
                        'controller' => 'App:Account',
                        'context' => 'account',
                        'title' => '<!--TITLE-->',
                        'RouteFormat' => null,
                        'description' => false
                    ]
                ],
                'search' => [
                    '' => [
                        'controller' => 'App:Search',
                        'context' => 'search',
                        'title' => '<!--TITLE-->',
                        'RouteFormat' => null,
                        'description' => false
                    ]
                ],
            ]
        ];
    }
    /**
     * @return mixed|null
     */
    public function currentRoute()
    {
        return $this->router->currentRoute($this->getRoutersByType());
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return array
     */
    public function getRouters()
    {
        return $this->globalRoute;
    }

    /**
     * @return mixed
     */
    public function getRoutersByType()
    {
        return $this->globalRoute[$this->type];
    }

    /**
     * @param array $routes
     */
    public function addRouter(array $routes = [])
    {
        foreach ($routes as $prefix => $route)
        {
            foreach ($route as $subName => $router)
            {
                $setRouter = $this->router->get($prefix, $router['controller'], $this->type);

                if (isset($router['forceAction']))
                {
                    $setRouter->forceAction($router['forceAction']);
                }
                if (isset($subName))
                {
                    $setRouter->subName($subName);
                }
                if (isset($router['RouteFormat']))
                {
                    $setRouter->RouteFormat($router['RouteFormat']);
                }
                if($router['context'])
                {
                    $setRouter->context($router['context']);
                }
                if(isset($router['newPage']))
                {
                    $setRouter->newPage($router['newPage']);
                }
                if(isset($router['ajaxJason']))
                {
                    $setRouter->ajaxJason($router['ajaxJason']);
                }
                if(isset($router['title']))
                {
                    $setRouter->setTitle($router['title']);
                }
                if(isset($router['description']))
                {
                    $setRouter->setDescription($router['description']);
                }
            }
        }
    }
    /**
     * @param $title
     */
    public function setTitle($title)
    {

        $pageContents = ob_get_contents();
        ob_end_clean ();
        if($title == null)
        {
            $ConfigOptions = BaseApp::getConfigOptions();
            $title = $ConfigOptions->defaultNameSite;
        }

        echo str_replace ('<!--TITLE-->', $title, $pageContents);
    }

    /**
     * @return null
     * @throws \Base\Router\RouterException
     */
    public function runRouter()
    {
        return $this->router->run();
    }

    /**
     * @param string $code
     * @param string $controller
     * @param string $action
     */
    public function methodNotFound($code = "", $controller = "", $action = "")
    {
        include "src/Template/" . $this->type . "/methodNotFound.php";
        $this->setTitle('Oops! Nous avons rencontré des problèmes.');
    }
    /**
     * @param $link
     * @param null $data
     * @param array $parameters
     * @return mixed|string
     */
    public function buildLink($link, $data = null, array $parameters = [])
    {
        return $this->router->buildLink($link, $data, $parameters);
    }
    public function getBaseLink()
    {
        $base = BaseApp::request()->getBaseUrl();
        $base = preg_replace('#(index|admin)\.php#', '', $base);
        return $base;
    }
}