<?php

declare(strict_types=1);

use Kauffinger\OnOfficeApi\Actions\Action;
use Kauffinger\OnOfficeApi\Actions\ReadActions\ReadUserRightAction;
use Kauffinger\OnOfficeApi\Enums\ActionType;
use Kauffinger\OnOfficeApi\Enums\UserRightsModule;
use Kauffinger\OnOfficeApi\Facades\OnOfficeApi;
use Kauffinger\OnOfficeApi\OnOfficeApiRequest;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Saloon;

it('can be retrieved from Action base class', function () {
    $instance = Action::read()->userRight();
    expect($instance::class)->toBe(ReadUserRightAction::class);
});

it('will render a suitable action array', function () {
    $action = new ReadUserRightAction();
    $actionArray = $action
        ->actionType(ActionType::Read)
        ->module(UserRightsModule::Address)
        ->render();

    expect($actionArray['parameters'])->toHaveKeys(['action', 'module'])
        ->and($actionArray['parameters']['action'])->toBe(ActionType::Read->value)
        ->and($actionArray['parameters']['module'])->toBe(UserRightsModule::Address->value);
});

it('will send a successful request', function () {
    $request = new OnOfficeApiRequest();
    $request->addAction(
        Action::read()
            ->userRight()
            ->actionType(ActionType::Read)
            ->module(UserRightsModule::Address)
    );

    Saloon::fake([
        MockResponse::make(['status' => ['code' => 200]]),
    ]);

    $response = OnOfficeApi::send($request);

    expect($response->ok())->toBeTrue();
});
