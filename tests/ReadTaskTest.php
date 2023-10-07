<?php

declare(strict_types=1);

use Kauffinger\OnOfficeApi\Actions\Action;
use Kauffinger\OnOfficeApi\Actions\ReadActions\ReadTaskAction;
use Kauffinger\OnOfficeApi\OnOfficeApi;
use Kauffinger\OnOfficeApi\OnOfficeApiRequest;

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

    expect($actionArray['parameters'])->toHaveKeys(['addMobileUrl', 'data', 'relatedEstateId', 'relatedProjectIds', 'listlimit']);
    expect($actionArray['parameters']['listlimit'])->toBe(200);
    expect($actionArray['parameters']['relatedEstateId'])->toBe(2);
    expect($actionArray['parameters']['relatedProjectIds'])->toBe(1);
    expect($actionArray['parameters']['addMobileUrl'])->toBe(true);
    expect($actionArray['parameters']['data'])->toMatchArray(['Eintragsdatum', 'modified']);
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

    $response = OnOfficeApi::for(
        config('onoffice.token'), config('onoffice.secret')
    )
        ->send($request);

    expect($response->collect()->get('status')['code'])->toBe(200);
});
