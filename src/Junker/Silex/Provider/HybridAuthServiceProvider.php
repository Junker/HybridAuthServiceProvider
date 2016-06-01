<?php

namespace Junker\Silex\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;

class HybridAuthServiceProvider implements ServiceProviderInterface
{

    const URI = '/hybridauth';

    public function register(Application $app)
    {
        $app['hybridauth'] = $app->share(function(Application $app) {

            $config = $app['hybridauth.config'];

            $config['base_url'] = $app['request']->getSchemeAndHttpHost() . self::URI;

            return new \Hybrid_Auth($config);
        });
    }

    public function boot(Application $app)
    {
        $app->get(self::URI, function() use ($app)
        {
            \Hybrid_Endpoint::process();
        });
    }
}