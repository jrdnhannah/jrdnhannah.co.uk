<?php

namespace Application;

use Application\Configuration\Parameters;
use Application\Controller\ContactController;
use Application\Controller\SiteController;
use Knp\Menu\Integration\Silex\KnpMenuServiceProvider;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\SwiftmailerServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\TwigServiceProvider;

class App
{
    /** @var \Silex\Application */
    protected $app;

    public function __construct()
    {
        $this->app = new \Silex\Application;
        $this->registerServiceProviders();
        $this->buildParameters();
        $this->registerControllers();
        $this->registerRoutes();
    }

    /**
     * @param bool $debug
     */
    public function debug($debug)
    {
        $this->app['debug'] = $debug;
    }

    /**
     * Register service providers
     */
    protected function registerServiceProviders()
    {
        $this->app->register(new TwigServiceProvider, ['twig.path' => __DIR__ . '/../views']);
        $this->app->register(new TranslationServiceProvider, ['locale_fallback' => 'en']);
        $this->app->register(new ServiceControllerServiceProvider);
        $this->app->register(new KnpMenuServiceProvider);
        $this->app->register(new FormServiceProvider);
        $this->app->register(new SwiftmailerServiceProvider);
    }

    /**
     * Build application parameters
     */
    protected function buildParameters()
    {
        (new Parameters($this->app))->build();
    }

    /**
     * Register application controllers
     */
    protected function registerControllers()
    {
        $this->app['site.controller'] = $this->app->share(function () {
            return new SiteController($this->app['twig']);
        });

        $this->app['contact.controller'] = $this->app->share(function() {
            return new ContactController(
                $this->app['twig'],
                $this->app['form.factory'],
                $this->app['mailer'],
                $this->app['mail.to'],
                $this->app['mail.from']
            );
        });
    }

    /**
     * Register application routes
     */
    protected function registerRoutes()
    {
        $this->app->get('/',        'site.controller:indexAction');
        $this->app->get('/contact', 'contact.controller:contactAction');
        $this->app->post('/contact', 'contact.controller:handleContactAction');
    }

    /**
     * Boot application
     */
    public function boot()
    {
        $this->app->run();
    }
}