<?php

declare(strict_types=1);

use Kauffinger\OnOfficeApi\Actions\Action;
use Kauffinger\OnOfficeApi\Actions\ReadActions\ReadBasicSettingAction;
use Kauffinger\OnOfficeApi\OnOfficeApi;
use Kauffinger\OnOfficeApi\OnOfficeApiRequest;

it('can be retrieved from Action base class', function () {
    $instance = Action::read()->basicSetting();
    expect($instance::class)->toBe(ReadBasicSettingAction::class);
});

it('will render a suitable action array', function () {
    $action = new ReadBasicSettingAction();
    $actionArray = $action
        ->render();

    expect($actionArray['parameters'])->toHaveKeys(['data'])
        ->and($actionArray['parameters']['data'])->toMatchArray([
            'basicData' => [
                'logo',
                'color',
                'color2',
                'textcolorMail',
                'claim',
            ],
            'permissions' => ['/onOfficeApp/timetracking/enabled'],
            'team' => ['about'],
        ],);
});

it('will send a successful request', function () {
    $api = new OnOfficeApi(config('onoffice.token'), config('onoffice.secret'));
    $request = new OnOfficeApiRequest();
    $request->addAction(
        Action::read()
            ->basicSetting()
    );

    $response = $api->send($request);
    expect($response->collect()->get('status')['code'])->toBe(200);
});
