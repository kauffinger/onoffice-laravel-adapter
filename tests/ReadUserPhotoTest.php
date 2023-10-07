<?php

declare(strict_types=1);

use Kauffinger\OnOfficeApi\Actions\Action;
use Kauffinger\OnOfficeApi\Actions\ReadActions\ReadUserPhotoAction;
use Kauffinger\OnOfficeApi\Enums\SortOrder;
use Kauffinger\OnOfficeApi\OnOfficeApi;
use Kauffinger\OnOfficeApi\OnOfficeApiRequest;

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

    expect($actionArray['parameters'])->toHaveKeys(['listlimit', 'sortby']);
    expect($actionArray['parameters']['listlimit'])->toBe(200);
    expect($actionArray['parameters']['sortby'])->toMatchArray(['id' => SortOrder::Ascending->value]);
});

it('will send a successful request', function () {
    $api = new OnOfficeApi(config('onoffice.token'), config('onoffice.secret'));
    $request = new OnOfficeApiRequest();
    $request->addAction(
        Action::read()
            ->userPhoto()
            ->setPhotosAsLinks()
            ->addSortBy('id', SortOrder::Ascending)
            ->setListLimit(200)
    );

    $response = $api->send($request);
    expect($response->collect()->get('status')['code'])->toBe(200);
});
