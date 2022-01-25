<?php

it('requires custom url if environment is set to Custom', function () {
    $redsysClient = new \Creagia\Redsys\RedsysClient(
        merchantCode: 123123,
        secretKey: 123123,
        terminal: 1,
        environment: \Creagia\Redsys\Enums\Environment::Custom
    );
})->throws(Exception::class, 'Redsys custom environment without custom URL defined');
