<?php

namespace Ibes\I18nRouting;

use Ibes\I18nRouting\Provider\I18nRoutingServiceProvider;
use Silex\Application;
use Silex\Provider\TranslationServiceProvider;
use Symfony\Component\HttpFoundation\Request;


class I18nRoutingServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    private function createApplication()
    {
        $app = new Application();
        $app['locale'] = 'en';

        $app->register(new I18nRoutingServiceProvider());

        $app['i18n_routing.locales'] = array('en', 'eu');

        return $app;
    }

    public function testMainBehaivorI18nRoutes()
    {
        $app = $this->createApplication();

        $app->get('/test', function () {
            return 'ok';
        })->bind('test')->getRoute()->setOption('i18n', array('eu' => '/entsegu'));

        $this->assertEquals(404, $app->handle(Request::create('/test'))->getStatusCode());
        $this->assertEquals(200, $app->handle(Request::create('/en/test'))->getStatusCode());
        $this->assertEquals(200, $app->handle(Request::create('/eu/entsegu'))->getStatusCode());
    }

    public function testRouteWithoutI18n()
    {
        $app = $this->createApplication();

        $app->get('/', function () {
            return 'ok';
        });

        $this->assertEquals(200, $app->handle(Request::create('/'))->getStatusCode());
    }

    public function testEmptyConfigI18nRoutes()
    {
        $app = $this->createApplication();

        $app->get('/', function () {
            return 'ok';
        })->getRoute()->setOption('i18n',array());

        $this->assertEquals(200, $app->handle(Request::create('/en/'))->getStatusCode());
        $this->assertEquals(200, $app->handle(Request::create('/eu/'))->getStatusCode());
    }
}