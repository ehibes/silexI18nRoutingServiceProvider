<?php

namespace Ibes\I18nRouting\Provider;

use Ibes\I18nRouting\I18nControllerCollection;
use Ibes\I18nRouting\I18nUrlGenerator;
use Silex\Application;
use Silex\ServiceProviderInterface;

class I18nRoutingServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['controllers_factory'] = function () use ($app) {
            return new I18nControllerCollection(
                $app['route_factory'],
                $app['locale'],
                $app['i18n_routing.locales']
            );
        };

        $app['url_generator'] = $app->share(function ($app) {
            $app->flush();

            return new I18nUrlGenerator($app['routes'], $app['request_context']);
        });

        $app['i18n_routing.locales'] = array('en');
    }

    public function boot(Application $app)
    {
    }
}
