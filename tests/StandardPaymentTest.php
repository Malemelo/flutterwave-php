<?php

namespace ChrisIdakwo\Flutterwave\Tests;

use ChrisIdakwo\Flutterwave\Exceptions\InvalidRequestDataException;
use ChrisIdakwo\Flutterwave\StandardPayment\StandardPaymentRequest;

class StandardPaymentTest extends TestCase {
    public function testRequestBodyIsProperlySet() {
        $requestBody = [
            'amount' => '100',
            'currency' => 'NGN',
            'customer' => [
                'name' => 'John Doe',
                'phonenumber' => '08044000000',
                'email' => 'johndoe@email.com'
            ]
        ];

        $standardPayment = (new StandardPaymentRequest(''))->setBody($requestBody);

        self::assertNotEmpty($standardPayment->getBody());

        $bodyJson = json_encode($requestBody);
        self::assertSame($bodyJson, $standardPayment->getBody());
    }

    public function testStandardPaymentValidatorWorks() {
        $requestBody = [
            'tx_ref' => '',
            'amount' => 100,
            'currency' => 'NGN',
            'payment_options' => 'card,account',
            'redirect_url' => '',
            'customer' => [
                'name' => 'John Doe',
                'phonenumber' => '08044000000',
                'email' => 'johndoe'
            ],
            'customizations' => [
                'title' => '',
                'description' => 'Lorem ipsum dolor sit amet',
                'logo' => 'https=>//d1yjjnpx0p53s8.cloudfront.net/styles/logo-thumbnail/s3/052016/untitled-1_183.png'
            ]
        ];

        $this->setExpectedException(InvalidRequestDataException::class);

        $response = $this->rave->standardPayment($requestBody);
    }

    public function testPaymentLinkIsReturned() {
        $requestBody = [
            'tx_ref' => 'CICXRDAR-' . random_int(6, 12),
            'amount' => 5000,
            'currency' => 'NGN',
            'payment_options' => 'card,account',
            'redirect_url' => 'http://localhost:9700/payment/callback',
            'customer' => [
                'name' => 'John Doe',
                'phonenumber' => '08044000000',
                'email' => 'johndoe@email.com'
            ],
            'customizations' => [
                'title' => 'Test Limited',
                'description' => 'Lorem ipsum dolor sit amet',
                'logo' => 'https=>//d1yjjnpx0p53s8.cloudfront.net/styles/logo-thumbnail/s3/052016/untitled-1_183.png'
            ]
        ];

        $response = $this->rave->standardPayment($requestBody);

        self::assertTrue(is_array($response));

        //	    var_dump('PAYMENT_LINK', $response['data']['link']);
        //	    die();

        self::assertArrayHasKey('data', $response);
    }
}
