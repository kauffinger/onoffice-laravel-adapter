<?php

use Illuminate\Support\Facades\Http;
use Kauffinger\OnOfficeApi\Actions\ReadActions\ReadAddressAction;
use Kauffinger\OnOfficeApi\Actions\ReadActions\ReadEstateAction;
use Kauffinger\OnOfficeApi\Facades\OnOfficeApi;
use Kauffinger\OnOfficeApi\OnOfficeApiRequest;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Saloon;

it('gives the onOffice status instead of the HTTP status', function () {
    Http::preventStrayRequests();
    Saloon::fake([
        MockResponse::make([
            'status' => [
                'code' => 123,
                'errorcode' => 0,
                'message' => 'OK',
            ],
        ],
            status: 200
        ),
    ]);
    $request = OnOfficeApiRequest::with(new ReadEstateAction());
    $res = OnOfficeApi::send($request);

    expect($res->status())->toBe(123);
});

it('sees 500 onOffice statuses as failed', function () {
    Http::preventStrayRequests();
    Saloon::fake([
        MockResponse::make([
            'status' => [
                'code' => 500,
                'errorcode' => 0,
                'message' => 'OK',
            ],
        ],
            status: 200
        ),
    ]);
    $request = OnOfficeApiRequest::with(new ReadEstateAction());
    $res = OnOfficeApi::send($request);

    expect($res->failed())->toBeTrue();
});

it('sees 200 onOffice statuses as ok', function () {
    Http::preventStrayRequests();
    Saloon::fake([
        MockResponse::make([
            'status' => [
                'code' => 200,
                'errorcode' => 0,
                'message' => 'OK',
            ],
        ],
            status: 200
        ),
    ]);
    $request = OnOfficeApiRequest::with(new ReadEstateAction());
    $res = OnOfficeApi::send($request);

    expect($res->ok())->toBeTrue();
});

it('can determine cacheable responses correctly', function () {
    Http::preventStrayRequests();
    Saloon::fake([
        MockResponse::make([
            'status' => [
                'code' => 200,
                'errorcode' => 0,
                'message' => 'OK',
            ],
            'response' => [
                'results' => [
                    ['cacheable' => true],
                    ['cacheable' => true],
                ],
            ],
        ],
            status: 200
        ),
    ]);
    $request = OnOfficeApiRequest::with(new ReadEstateAction());
    $res = OnOfficeApi::send($request);

    expect($res->cacheable())->toBeTrue();
});

it('can determine non-cacheable responses correctly', function () {
    Http::preventStrayRequests();
    Saloon::fake([
        MockResponse::make([
            'status' => [
                'code' => 200,
                'errorcode' => 0,
                'message' => 'OK',
            ],
            'response' => [
                'results' => [
                    ['cacheable' => true],
                    ['cacheable' => false],
                ],
            ],
        ],
            status: 200
        ),
    ]);
    $request = OnOfficeApiRequest::with(new ReadEstateAction());
    $res = OnOfficeApi::send($request);

    expect($res->cacheable())->toBeFalse();
});

it('returns the result array when results is called', function () {
    Http::preventStrayRequests();
    Saloon::fake([
        MockResponse::make([
            'status' => [
                'code' => 200,
                'errorcode' => 0,
                'message' => 'OK',
            ],
            'response' => [
                'results' => [
                    ['data' => 'test'],
                    ['data' => 'test2'],
                ],
            ],
        ],
            status: 200
        ),
    ]);
    $request = OnOfficeApiRequest::with(new ReadEstateAction());
    $res = OnOfficeApi::send($request);

    expect($res->results())->toMatchArray([
        ['data' => 'test'],
        ['data' => 'test2'],
    ]);
});

it('returns the data array when getData is called', function () {
    Http::preventStrayRequests();
    Saloon::fake([
        MockResponse::make([
            'status' => [
                'code' => 200,
                'errorcode' => 0,
                'message' => 'OK',
            ],
            'response' => [
                'results' => [
                    ['data' => ['testkey' => 'testvalue']],
                    ['data' => ['testkey2' => 'testvalue2']],
                    ['data' => []],
                ],
            ],
        ],
            status: 200
        ),
    ]);
    $request = OnOfficeApiRequest::with(new ReadEstateAction());
    $res = OnOfficeApi::send($request);

    expect($res->getData())->toMatchArray([
        ['testkey' => 'testvalue'],
        ['testkey2' => 'testvalue2'],
    ]);
});

it('can get the elements for a read request', function () {
    Http::preventStrayRequests();
    Saloon::fake([
        MockResponse::make([
            'status' => [
                'code' => 200,
                'errorcode' => 0,
                'message' => 'OK',
            ],
            'response' => [
                'results' => [
                    [
                        'actionid' => 'urn:onoffice-de-ns:smart:2.5:smartml:action:read',
                        'resourceid' => '123',
                        'resourcetype' => 'address',
                        'cacheable' => true,
                        'identifier' => '',
                        'data' => [
                            'meta' => [
                                'cntabsolute' => 1,
                            ],
                            'records' => [
                                [
                                    'id' => 123,
                                    'type' => 'address',
                                    'elements' => [
                                        'id' => 123,
                                        'Email' => 'test@example.de',
                                        'Vorname' => 'test',
                                        'Name' => 'example',
                                        'Zusatz1' => 'example llc',
                                    ],
                                ],
                            ],
                        ],
                        'status' => [
                            'errorcode' => 0,
                            'message' => 'OK',
                        ],
                    ],
                ],
            ],
        ],
            status: 200
        ),
    ]);
    $request = OnOfficeApiRequest::with(new ReadAddressAction());
    $res = OnOfficeApi::send($request);

    expect($res->elements(0))
        ->toMatchArray([
            [
                'id' => 123,
                'Email' => 'test@example.de',
                'Vorname' => 'test',
                'Name' => 'example',
                'Zusatz1' => 'example llc',
            ],
        ]);
});
