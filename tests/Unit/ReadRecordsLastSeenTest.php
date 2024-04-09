<?php

declare(strict_types=1);

use Kauffinger\OnOfficeApi\Actions\Action;
use Kauffinger\OnOfficeApi\Actions\ReadActions\ReadRecordsLastSeenAction;
use Kauffinger\OnOfficeApi\Enums\RecordsLastSeenModule;
use Kauffinger\OnOfficeApi\OnOfficeApi;
use Kauffinger\OnOfficeApi\OnOfficeApiRequest;

it('can be retrieved from Action base class', function () {
    $instance = Action::read()->recordsLastSeen();
    expect($instance::class)->toBe(ReadRecordsLastSeenAction::class);
});

it('will render a suitable action array', function () {
    $action = new ReadRecordsLastSeenAction();
    $actionArray = $action
        ->module(RecordsLastSeenModule::Address)
        ->render();

    expect($actionArray['parameters'])->toHaveKeys(['module', 'listlimit'])
        ->and($actionArray['parameters']['module'])->toBe(RecordsLastSeenModule::Address->value)
        ->and($actionArray['parameters']['listlimit'])->toBe(0);
});

it('will send a successful request', function () {
    $api = new OnOfficeApi(config('onoffice.token'), config('onoffice.secret'));
    $request = new OnOfficeApiRequest();
    $request->addAction(
        Action::read()
            ->recordsLastSeen()
            ->module(RecordsLastSeenModule::Address)
    );

    $response = $api->send($request);
    expect($response->collect()->get('status')['code'])->toBe(200);
});
