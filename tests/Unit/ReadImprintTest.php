<?php

declare(strict_types=1);

use Kauffinger\OnOfficeApi\Actions\Action;
use Kauffinger\OnOfficeApi\Actions\ReadActions\ReadImprintAction;
use Kauffinger\OnOfficeApi\Enums\Language;
use Kauffinger\OnOfficeApi\Facades\OnOfficeApi;
use Kauffinger\OnOfficeApi\OnOfficeApiRequest;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Saloon;

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
    $request = new OnOfficeApiRequest();
    $request->addAction(
        Action::read()
            ->imprint()
            ->setData(['title', 'firstname', 'lastname', 'ustId', 'bank'])
            ->language(Language::German)
            ->formatOutput()
    );

    Saloon::fake([
        MockResponse::make([]),
    ]);

    $response = OnOfficeApi::send($request);

    expect($response->ok())->toBeTrue();
});
