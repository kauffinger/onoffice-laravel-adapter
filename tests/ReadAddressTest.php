<?php

use Kauffinger\OnOfficeApi\Actions\Action;
use Kauffinger\OnOfficeApi\Actions\ReadActions\ReadAddressAction;
use Kauffinger\OnOfficeApi\Enums\Language;
use Kauffinger\OnOfficeApi\OnOfficeApi;
use Kauffinger\OnOfficeApi\OnOfficeApiRequest;

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
    $api = new OnOfficeApi(config('onoffice.token'), config('onoffice.secret'));
    $request = new OnOfficeApiRequest();
    $request->addAction(
        Action::read()
            ->address()
            ->formatOutput()
            ->outputInLanguage(Language::German)
            ->addMobileUrl()
            ->fieldsToRead('phone', 'mobile')
            ->setListLimit(200)
    );

    $response = $api->send($request);
    expect($response->status())->toBe(200);
});
