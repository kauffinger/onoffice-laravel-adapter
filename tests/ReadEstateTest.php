<?php

use Kauffinger\OnOfficeApi\Actions\Action;
use Kauffinger\OnOfficeApi\Actions\ReadActions\ReadEstateAction;
use Kauffinger\OnOfficeApi\Enums\ReadResource;

it('can be retrieved from Action base class', function () {
    $instance = Action::read(ReadResource::Estate);
    expect($instance::class)->toBe(ReadEstateAction::class);
});

it('will render a suitable action array', function () {
    $action = new ReadEstateAction();
    $actionArray = $action
        ->addMobileUrl()
        ->setData(['testfield', 'testfield2'])
        ->render();

    expect($actionArray)->toHaveKeys(['addMobileUrl', 'data']);
    expect($actionArray['data'])->toMatchArray(['testfield', 'testfield2']);
});
