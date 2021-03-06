# Flutterwave-PHP

A PHP client for the Flutterwave payment processing system. This is intended for cases where the payment process is initiated from an API server but carried-out by a web application or SPA. 

## Installation
As expected:

```bash
composer require chrisidakwo/flutterwave-php
```

## Usage
```php
use ChrisIdakwo\Flutterwave\Rave;
$secretKey = 'FLW-SECRET-KEY';
$baseUrl = 'https://baseurl.com/v3';
$rave = new Rave($secretKey, $baseUrl);

// To generate a payment link
$requestData = []; // See https://developer.flutterwave.com/docs/flutterwave-standard
$paymentLink = $rave->standardPayment($requestData)['data']['link'];

// To verify a transaction
$transactionID = '123456';
$transaction = $rave->verifyTransaction($transactionID);

$amount = 34000;
$customerEmail = 'customer@email.com';

$isVerified = $transaction->amount === $amount && $transaction->currency === 'NGN' 
                && $transaction->customer->email === $customerEmail;

// Refund a transaction
$transactionID = '9408294';
$amount = 300;
$refund = $rave->refundTransaction($transactionID, $amount);
```


## Contribution
Feel free to make contributions following the existing patterns. If you do, please format your code before creating a PR. This will format all files as specified in `.php_cs`:
                                                                                                                          
```bash
vendor/bin/php-cs-fixer fix
```

Please write tests and make use of micro commits, that is, you should commit even the slightest change you make. Do not wait till you've written a lot of intertwined implementations before making one commit. 
Use the rule of one commit to one action. It makes reverting a whole lot easier, and allows one to easily follow through your implementation. Not clear? You can go through the present commit history to understand.
