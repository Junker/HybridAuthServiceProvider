# HybridAuthServiceProvider
HybridAuth Service Provider for Silex

## Requirements
silex 1.x

##Installation
The best way to install HybridAuthServiceProvider is to use a [Composer](https://getcomposer.org/download):

    php composer.phar require junker/hybridauth-service-provider

## Examples

```php
use Junker\Silex\Provider\HybridAuthServiceProvider;

$app->register(new HybridAuthServiceProvider(), [
	'hybridauth.config' => [
		'providers' => [ 
		    'Facebook' => [
		        'enabled' => true,
		        'keys' => [ 
		            'id' => 1090817398,
		            'secret' => 'c9131f36717babbasdafewrfdase'
		        ],
		        'scope' => 'public_profile,email,user_birthday,user_location'
		    ],
		    'Twitter' => [
		        'enabled' => true,
		        'keys' => [
		            'key' => 'wwqKLOHNhequwhe',
		            'secret' => 'hiwedfrwe4trDKkVyIHiBdceN4Ed1ASDWdsfarewREFRtMk'
		        ]
		    ]
		]
	]
]);



$app->get('/login/{provider}', function($provider) use ($app) {

	$adapter = $app['hybridauth']->authenticate($provider);

	$user_profile = $adapter->getUserProfile();

	if ($user_profile)
	{
		$uid = $user_profile->identifier;
		$login = $app['db']->fetchColumn('SELECT login FROM user WHERE oauth_type=? AND oauth_uid=?', [$provider, $uid]);

		if ($id)
		{
			//force login. i.e.:
			$user_provider = new \MySite\UserProvider($app['db']);
			$user = $user_provider->loadUserByUsername($login);
			$token = new UsernamePasswordToken($user, NULL, 'main', $user->getRoles());
			$app['security']->setToken($token);

			return $app->redirect('/');
		}
		else
		{
			//redirect to registration
			...
		}
	}
});

```

