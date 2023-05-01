<?php

use Kauffinger\OnOfficeApi\Actions\Action;
use Kauffinger\OnOfficeApi\Actions\ReadActions\ReadEstateAction;

it('can be retrieved from Action base class', function () {
    $instance = Action::read()->estate();
    expect($instance::class)->toBe(ReadEstateAction::class);
});

it('will render a suitable action array', function () {
    $action = new ReadEstateAction();
    $actionArray = $action
        ->addMobileUrl()
        ->setData(['testfield', 'testfield2'])
        ->render();

    expect($actionArray['parameters'])->toHaveKeys(['addMobileUrl', 'data']);
    expect($actionArray['parameters']['data'])->toMatchArray(['testfield', 'testfield2']);
});
