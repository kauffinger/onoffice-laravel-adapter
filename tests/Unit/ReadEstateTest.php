<?php

declare(strict_types=1);

use Kauffinger\OnOfficeApi\Actions\Action;
use Kauffinger\OnOfficeApi\Actions\ReadActions\ReadEstateAction;
use Kauffinger\OnOfficeApi\Facades\OnOfficeApi;
use Kauffinger\OnOfficeApi\OnOfficeApiRequest;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Saloon;

it('can be retrieved from Action base class', function () {
    $instance = Action::read()->estate();
    expect($instance::class)->toBe(ReadEstateAction::class);
});

it('will render a suitable action array', function () {
    $action = new ReadEstateAction();
    $actionArray = $action
        ->addMobileUrl()
        ->setData(['Id', 'kaufpreis'])
        ->render();

    expect($actionArray['parameters'])->toHaveKeys(['addMobileUrl', 'data'])
        ->and($actionArray['parameters']['data'])->toMatchArray(['Id', 'kaufpreis']);
});

it('will send a successful request', function () {
    $request = new OnOfficeApiRequest();
    $request->addAction(
        Action::read()
            ->estate()
            ->addMobileUrl()
            ->setData(['Id', 'kaufpreis'])
    );

    Saloon::fake([
        MockResponse::make([]),
    ]);

    $response = OnOfficeApi::send($request);

    expect($response->ok())->toBeTrue();
});
