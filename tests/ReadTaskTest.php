<?php

use Kauffinger\OnOfficeApi\Actions\Action;
use Kauffinger\OnOfficeApi\Actions\ReadActions\ReadTaskAction;
use Kauffinger\OnOfficeApi\Enums\ReadResource;

it('can be retrieved from Action base class', function () {
    $instance = Action::read(ReadResource::Task);
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

    expect($actionArray)->toHaveKeys(['addMobileUrl', 'data', 'relatedEstateId', 'relatedProjectIds', 'listlimit']);
    expect($actionArray['listlimit'])->toBe(200);
    expect($actionArray['relatedEstateId'])->toBe(2);
    expect($actionArray['relatedProjectIds'])->toBe(1);
    expect($actionArray['addMobileUrl'])->toBe(true);
    expect($actionArray['data'])->toMatchArray(['Eintragsdatum', 'modified']);
});
