<?php

use Kauffinger\OnOfficeApi\Actions\Action;
use Kauffinger\OnOfficeApi\Actions\ReadActions\ReadAddressAction;
use Kauffinger\OnOfficeApi\Enums\Language;
use Kauffinger\OnOfficeApi\Enums\SortOrder;
use Kauffinger\OnOfficeApi\OnOfficeApi;
use Kauffinger\OnOfficeApi\OnOfficeApiRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

it('can be retrieved from Action base class', function () {
    $instance = Action::read()->address();
    expect($instance::class)->toBe(ReadAddressAction::class);
});

it('will render a suitable action array', function () {
    $action = new ReadAddressAction();
    $actionArray = $action
        ->formatOutput()
        ->outputInLanguage(Language::German)
        ->addMobileUrl()
        ->fieldsToRead('phone', 'mobile')
        ->setListLimit(200)
        ->render();

    expect($actionArray['parameters'])->toHaveKeys(['addMobileUrl', 'data', 'formatoutput', 'listlimit']);
    expect($actionArray['parameters']['listlimit'])->toBe(200);
    expect($actionArray['parameters']['formatoutput'])->toBe(true);
    expect($actionArray['parameters']['addMobileUrl'])->toBe(true);
    expect($actionArray['parameters']['data'])->toMatchArray(['phone', 'mobile']);
});

it('will send a successful request', function () {
    $mockClient = new MockClient([
        OnOfficeApiRequest::class => MockResponse::fixture('read/ReadAddressAction'),
    ]);
    $api = new OnOfficeApi(config('onoffice.token'), config('onoffice.secret'));
    $api->withMockClient($mockClient);
    $request = new OnOfficeApiRequest();
    $request->addAction(
        Action::read()
            ->address()
            ->formatOutput()
            ->outputInLanguage(Language::German)
            ->addMobileUrl()
            ->fieldsToRead('phone', 'mobile')
            // This could be broken, or api docs are inaccurate.
            ->addSortBy('phone', SortOrder::Ascending)
            ->setListLimit(2)
    );

    $response = $api->send($request);
    expect($response->collect()->get('response')['results'][0]['status']['errorcode'])->toBe(0);
});
