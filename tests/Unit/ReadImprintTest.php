<?php

declare(strict_types=1);

use Kauffinger\OnOfficeApi\Actions\Action;
use Kauffinger\OnOfficeApi\Actions\ReadActions\ReadImprintAction;
use Kauffinger\OnOfficeApi\Enums\Language;
use Kauffinger\OnOfficeApi\OnOfficeApi;
use Kauffinger\OnOfficeApi\OnOfficeApiRequest;

it('can be retrieved from Action base class', function () {
    $instance = Action::read()->imprint();
    expect($instance::class)->toBe(ReadImprintAction::class);
});

it('will render a suitable action array', function () {
    $action = new ReadImprintAction();
    $actionArray = $action
        ->setData(['title', 'firstname', 'lastname', 'ustId', 'bank'])
        ->language(Language::German)
        ->formatOutput()
        ->render();

    expect($actionArray['parameters'])->toHaveKeys(['data'])
        ->and($actionArray['parameters']['data'])->toMatchArray(
            [
                'title',
                'firstname',
                'lastname',
                'ustId',
                'bank',
            ]
        );
});

it('will send a successful request', function () {
    $api = new OnOfficeApi(config('onoffice.token'), config('onoffice.secret'));
    $request = new OnOfficeApiRequest();
    $request->addAction(
        Action::read()
            ->imprint()
            ->setData(['title', 'firstname', 'lastname', 'ustId', 'bank'])
            ->language(Language::German)
            ->formatOutput()
    );

    $response = $api->send($request);
    expect($response->collect()->get('status')['code'])->toBe(200);
});
