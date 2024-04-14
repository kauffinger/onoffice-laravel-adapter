<?php

use Kauffinger\OnOfficeApi\Actions\Action;
use Kauffinger\OnOfficeApi\Actions\CustomAction;
use Kauffinger\OnOfficeApi\Enums\ActionType;
use Kauffinger\OnOfficeApi\Facades\OnOfficeApi;
use Kauffinger\OnOfficeApi\OnOfficeApiRequest;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Saloon;

it('can make a custom action', function () {
    $instance = CustomAction::make(ActionType::Read);
    expect($instance::class)->toBe(CustomAction::class);
});

it('will render a suitable action array', function () {
    $rendered = CustomAction::make(ActionType::Read)
        ->setResourceId('123')
        ->setResourceType('address')
        ->setParameters(['foo' => 'bar'])
        ->render();

    expect($rendered)->toMatchArray([
        'actionid' => ActionType::Read->value,
        'resourceid' => '123',
        'resourcetype' => 'address',
        'parameters' => ['foo' => 'bar'],
    ]);
});

it('will send a successful request', function () {
    $request = new OnOfficeApiRequest();
    $request->addAction(
        Action::read()
            ->custom()
            ->setResourceType('estate')
            ->setResourceId(123)
            ->setParameters(['Id', 'kaufpreis'])
    );

    Saloon::fake([
        MockResponse::make(['status' => ['code' => 200]]),
    ]);

    $response = OnOfficeApi::send($request);

    expect($response->ok())->toBeTrue();
});

it('can be created from all action types', function () {
    $action = Action::create()->custom();
    expect($action::class)->toBe(CustomAction::class);

    $action = Action::edit()->custom();
    expect($action::class)->toBe(CustomAction::class);

    $action = Action::read()->custom();
    expect($action::class)->toBe(CustomAction::class);

    $action = Action::get()->custom();
    expect($action::class)->toBe(CustomAction::class);

    $action = Action::delete()->custom();
    expect($action::class)->toBe(CustomAction::class);

    $action = Action::do()->custom();
    expect($action::class)->toBe(CustomAction::class);

    $action = Action::modify()->custom();
    expect($action::class)->toBe(CustomAction::class);
});
