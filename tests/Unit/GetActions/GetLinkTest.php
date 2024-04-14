<?php

declare(strict_types=1);

use Kauffinger\OnOfficeApi\Actions\Action;
use Kauffinger\OnOfficeApi\Actions\GetActions\GetLinkAction;
use Kauffinger\OnOfficeApi\Enums\AgentsLogLinkType;
use Kauffinger\OnOfficeApi\Enums\GetLinkModule;
use Kauffinger\OnOfficeApi\Facades\OnOfficeApi;
use Kauffinger\OnOfficeApi\OnOfficeApiRequest;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Saloon;

it('can be retrieved from Action base class', function () {
    $instance = Action::get()->link(GetLinkModule::Address, 1);
    expect($instance::class)->toBe(\Kauffinger\OnOfficeApi\Actions\GetActions\GetLinkAction::class);
});

it('will render a suitable action array', function () {
    $action = new \Kauffinger\OnOfficeApi\Actions\GetActions\GetLinkAction(GetLinkModule::Address, 1);
    $actionArray = $action
        ->render();

    expect(data_get($actionArray, 'parameters.recordId'))->toBe(1)
        ->and($actionArray['resourceid'])->toBe(GetLinkModule::Address->value);
});

it('will only allow setType for module AgentsLog', function () {
    $action = new GetLinkAction(GetLinkModule::Estate, 1);
    expect(fn () => $action->setType(AgentsLogLinkType::Address))->toThrow(InvalidArgumentException::class);

    $action = new GetLinkAction(GetLinkModule::Address, 1);
    expect(fn () => $action->setType(AgentsLogLinkType::Address))->toThrow(InvalidArgumentException::class);

    $action = new GetLinkAction(GetLinkModule::AgentsLog, 1);
    expect(fn () => $action->setType(AgentsLogLinkType::Address))->not()->toThrow(InvalidArgumentException::class);
});

it('will send a successful request', function () {

    $request = new OnOfficeApiRequest();
    $request->addAction(
        Action::get()
            ->link(GetLinkModule::Address, 1)
    );

    Saloon::fake([
        MockResponse::make(['status' => ['code' => 200]]),
    ]);

    $response = OnOfficeApi::send($request);
    expect($response->ok())->toBeTrue();
});
