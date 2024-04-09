<?php

declare(strict_types=1);

use Kauffinger\OnOfficeApi\Actions\Action;
use Kauffinger\OnOfficeApi\Actions\ReadActions\ReadEstateAction;
use Kauffinger\OnOfficeApi\OnOfficeApi;
use Kauffinger\OnOfficeApi\OnOfficeApiRequest;

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
    $api = new OnOfficeApi(config('onoffice.token'), config('onoffice.secret'));
    $request = new OnOfficeApiRequest();
    $request->addAction(
        Action::read()
            ->estate()
            ->addMobileUrl()
            ->setData(['Id', 'kaufpreis'])
    );

    $response = $api->send($request);
    expect($response->collect()->get('status')['code'])->toBe(200);
});
