# peach-payments
Package to allow integration with Peach Payments using PHP

### Examples:

There is three ways to configure the client.

```php
$config = new \Peach\Oppwa\Configuration(
    'set_your_user_id',
    'set_your_password',
    'set_your_entity_id'
);

$client = new \Peach\Oppwa\Client($config);

```

```php
$client = new \Peach\Oppwa\Client([
    'set_your_user_id',
    'set_your_password',
    'set_your_entity_id']
);
```
```php
$client = new \Peach\Oppwa\Client(
    'set_your_user_id',
    'set_your_password',
    'set_your_entity_id'
);
```

If you wish to use the test server.

```php
    $client->setTestMode(true);
```