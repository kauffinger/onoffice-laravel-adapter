<?php

it('can resolve the base url from config', function () {
    $api = new \Kauffinger\OnOfficeApi\OnOfficeApi('token', 'secret');
    config(['onoffice.base_url' => 'testvalue']);
    expect($api->resolveBaseUrl())->toBe('testvalue');
});

it('can resolve the base url from default', function () {
    $api = new \Kauffinger\OnOfficeApi\OnOfficeApi('token', 'secret');
    config(['onoffice.base_url' => null]);
    expect($api->resolveBaseUrl())->toBe('https://api.onoffice.de/api/stable/api.php');
});
