<?php

declare(strict_types=1);

use Kauffinger\OnOfficeApi\Actions\Action;
use Kauffinger\OnOfficeApi\Actions\ReadActions\ReadUserPhotoAction;
use Kauffinger\OnOfficeApi\Enums\SortOrder;
use Kauffinger\OnOfficeApi\Facades\OnOfficeApi;
use Kauffinger\OnOfficeApi\OnOfficeApiRequest;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Saloon;

it('can be retrieved from Action base class', function () {
    $instance = Action::read()->userPhoto();
    expect($instance::class)->toBe(ReadUserPhotoAction::class);
});

it('will render a suitable action array', function () {
    $action = new ReadUserPhotoAction();
    $actionArray = $action
        ->setPhotosAsLinks()
        ->addSortBy('id', SortOrder::Ascending)
        ->setListLimit(200)
        ->render();

    expect($actionArray['parameters'])->toHaveKeys(['listlimit', 'sortby'])
        ->and($actionArray['parameters']['listlimit'])->toBe(200)
        ->and($actionArray['parameters']['sortby'])->toMatchArray(['id' => SortOrder::Ascending->value]);
});

it('will send a successful request', function () {
    $request = new OnOfficeApiRequest();
    $request->addAction(
        Action::read()
            ->userPhoto()
            ->setPhotosAsLinks()
            ->addSortBy('id', SortOrder::Ascending)
            ->setListLimit(200)
    );

    Saloon::fake([
        MockResponse::make(['status' => ['code' => 200]]),
    ]);

    $response = OnOfficeApi::send($request);

    expect($response->ok())->toBeTrue();
});
