<?php

declare(strict_types=1);

use Kauffinger\OnOfficeApi\Actions\Action;
use Kauffinger\OnOfficeApi\Actions\ReadActions\ReadUserAction;
use Kauffinger\OnOfficeApi\Enums\SortOrder;
use Kauffinger\OnOfficeApi\Facades\OnOfficeApi;
use Kauffinger\OnOfficeApi\OnOfficeApiRequest;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Saloon;

it('can be retrieved from Action base class', function () {
    $instance = Action::read()->user();
    expect($instance::class)->toBe(ReadUserAction::class);
});

it('will render a suitable action array', function () {
    $action = new ReadUserAction();
    $actionArray = $action
        ->fieldsToRead('Anrede', 'Titel', 'Kuerzel')
        ->addSortBy('Anrede', SortOrder::Ascending)
        ->setListLimit(200)
        ->render();

    expect($actionArray['parameters'])->toHaveKeys(['listlimit', 'data', 'sortby'])
        ->and($actionArray['parameters']['listlimit'])->toBe(200)
        ->and($actionArray['parameters']['sortby'])->toMatchArray(['Anrede' => SortOrder::Ascending->value])
        ->and($actionArray['parameters']['data'])->toMatchArray(['Anrede', 'Titel', 'Kuerzel']);
});

it('will send a successful request', function () {
    $request = new OnOfficeApiRequest();
    $request->addAction(
        Action::read()
            ->user()
            ->fieldsToRead('Anrede', 'Titel', 'Kuerzel')
            ->addSortBy('Anrede', SortOrder::Ascending)
            ->setListLimit(200)
    );

    Saloon::fake([
        MockResponse::make(['status' => ['code' => 200]]),
    ]);

    $response = OnOfficeApi::send($request);

    expect($response->ok())->toBeTrue();
});
