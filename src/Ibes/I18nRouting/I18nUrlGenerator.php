<?php

namespace Ibes\I18nRouting;

use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\Generator\UrlGenerator as UrlGeneratorBase;

/**
 * {@inheritdoc}
 */
class I18nUrlGenerator extends UrlGeneratorBase
{
    /**
     * {@inheritdoc}
     */
    public function generate($name, $parameters = array(), $referenceType = self::ABSOLUTE_PATH)
    {
        // determine the most suitable locale to use for route generation
        $currentLocale = $this->context->getParameter('_locale');

        if (isset($parameters['_locale'])) {
            $locale = $parameters['_locale'];
        } else if ($currentLocale) {
            $locale = $currentLocale;
        } else {
            $locale = 'en';
        }

        try {
            if (false !== $pos = strpos($name, I18nControllerCollection::ROUTING_PREFIX)) {
                $name = substr($name, $pos + strlen(I18nControllerCollection::ROUTING_PREFIX));
            }
            $url = parent::generate($locale.I18nControllerCollection::ROUTING_PREFIX.$name, $parameters, $referenceType);

            return $url;
        } catch (RouteNotFoundException $ex) {
            // fallback to default behavior
        }

        // use the default behavior if no localized route exists
        return parent::generate($name, $parameters, $referenceType);
    }
}
