# peach-payments
Package to allow integration with Peach Payments using PHP

### Examples:

There are three ways to configure the client.

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

All responses will contain an isSuccess method to check if the result was successful

```php
if ($response->isSuccess()) {
 // was successful
}
```

Get Checkout ID for Storing a card.

```php
$storeCard = new \FlickerLeap\PeachPayments\Cards\Store($client);
$response = $storeCard->process();
```