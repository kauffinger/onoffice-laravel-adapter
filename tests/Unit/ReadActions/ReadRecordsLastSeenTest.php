<?php

declare(strict_types=1);

use Kauffinger\OnOfficeApi\Actions\Action;
use Kauffinger\OnOfficeApi\Actions\ReadActions\ReadRecordsLastSeenAction;
use Kauffinger\OnOfficeApi\Enums\RecordsLastSeenModule;
use Kauffinger\OnOfficeApi\Facades\OnOfficeApi;
use Kauffinger\OnOfficeApi\OnOfficeApiRequest;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Saloon;

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
    $request = new OnOfficeApiRequest();
    $request->addAction(
        Action::read()
            ->recordsLastSeen()
            ->module(RecordsLastSeenModule::Address)
    );

    Saloon::fake([
        MockResponse::make(['status' => ['code' => 200]]),
    ]);

    $response = OnOfficeApi::send($request);

    expect($response->ok())->toBeTrue();
});
