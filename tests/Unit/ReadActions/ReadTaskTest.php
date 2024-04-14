<?php

declare(strict_types=1);

use Kauffinger\OnOfficeApi\Actions\Action;
use Kauffinger\OnOfficeApi\Actions\ReadActions\ReadTaskAction;
use Kauffinger\OnOfficeApi\Facades\OnOfficeApi;
use Kauffinger\OnOfficeApi\OnOfficeApiRequest;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Saloon;

it('can be retrieved from Action base class', function () {
    $instance = Action::read()->task();
    expect($instance::class)->toBe(ReadTaskAction::class);
});

it('will render a suitable action array', function () {
    $action = new ReadTaskAction();
    $actionArray = $action
        ->addMobileUrl()
        ->fieldsToRead('Eintragsdatum', 'modified')
        ->setRelatedEstateId(2)
        ->setRelatedProjectId(1)
        ->setListLimit(200)
        ->render();

    expect($actionArray['parameters'])->toHaveKeys(['addMobileUrl', 'data', 'relatedEstateId', 'relatedProjectIds', 'listlimit'])
        ->and($actionArray['parameters']['listlimit'])->toBe(200)
        ->and($actionArray['parameters']['relatedEstateId'])->toBe(2)
        ->and($actionArray['parameters']['relatedProjectIds'])->toBe(1)
        ->and($actionArray['parameters']['addMobileUrl'])->toBe(true)
        ->and($actionArray['parameters']['data'])->toMatchArray(['Eintragsdatum', 'modified']);
});

it('will send a successful request', function () {
    $request = OnOfficeApiRequest::with(
        Action::read()
            ->task()
            ->fieldsToRead('Eintragsdatum', 'modified')
            ->setRelatedEstateId(2)
            ->setRelatedProjectId(1)
            ->setListLimit(200)
    );

    Saloon::fake([
        MockResponse::make(['status' => ['code' => 200]]),
    ]);

    $response = OnOfficeApi::send($request);

    expect($response->ok())->toBeTrue();
});
