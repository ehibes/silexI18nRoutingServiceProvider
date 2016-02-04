I18n Routing Service Provider  [![Build Status](https://travis-ci.org/ehibes/silexI18nRoutingServiceProvider.svg?branch=1.0)](http://travis-ci.org/ehibes/silexI18nRoutingServiceProvider)
=============================

Silex i18n routing service provider inspired by [jenyak I18nRoutingServiceProvider](https://github.com/jenyak/I18nRoutingServiceProvider)

Installation
------------

Recommended installation is [through composer](http://getcomposer.org). Just add
the following to your `composer.json` file:
### Silex 1.3
    {
        "require": {
            "ehibes/i18n-routing-service-provider": "~1.0"
        }
    }
### Silex 2
    {
        "require": {
            "ehibes/i18n-routing-service-provider": "dev-master"
        }
    }

# Registering

```php
$app->register(new Ibes\I18nRouting\Provider\I18nRoutingServiceProvider());
```

# Parameters

* **i18n_routing.locales**: Routing locales. The default value is `array(en)`.
* **locale**: Default routing locale. The default value is `en`.

# Example

```php
$app = new Application();
//...
$app->register(new Ibes\I18nRouting\Provider\I18nRoutingServiceProvider());
$app['locale'] = 'en';
$app['i18n_routing.locales'] = array('en', 'eu', 'fr');

// There's no need to put {_locale} in route pattern
$app->get('/test', function () {
   //...
})->bind('test_route')->getRoute()->setOption('i18n', array('eu' => 'entsegu-bat'));
```
Matched URLs will be:

`/en/test` - url for default locale without prefix

`/eu/entsegu-bat` - url with prefix and translated

`/fr/test` - url with prefix