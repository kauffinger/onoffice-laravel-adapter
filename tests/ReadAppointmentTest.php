<?php

use Illuminate\Support\Carbon;
use Kauffinger\OnOfficeApi\Actions\Action;
use Kauffinger\OnOfficeApi\Actions\ReadActions\ReadAppointmentAction;
use Kauffinger\OnOfficeApi\OnOfficeApi;
use Kauffinger\OnOfficeApi\OnOfficeApiRequest;

it('can be retrieved from Action base class', function () {
    $instance = Action::read()->appointment();
    expect($instance::class)->toBe(ReadAppointmentAction::class);
});

it('will render a suitable action array', function () {
    $action = new ReadAppointmentAction();
    $actionArray = $action
        ->dateStart(Carbon::now()->subtract('days', 30))
        ->dateEnd(Carbon::now())
        ->showCancelled()
        ->allUsers()
        ->render();

    expect($actionArray['parameters'])->toHaveKeys(['datestart', 'dateend', 'allusers', 'showcancelled']);
    expect($actionArray['parameters']['datestart'])->toBeString();
    expect($actionArray['parameters']['dateend'])->toBeString();
    expect($actionArray['parameters']['allusers'])->toBeTrue();
    expect($actionArray['parameters']['showcancelled'])->toBeTrue();
});

it('will send a successful request', function () {
    $api = new OnOfficeApi(config('onoffice.token'), config('onoffice.secret'));
    $request = new OnOfficeApiRequest();
    $request->addAction(
        Action::read()
            ->appointment()
            ->dateStart(Carbon::now()->subtract('days', 30))
            ->dateEnd(Carbon::now())
            ->showCancelled()
            ->allUsers()
    );

    $response = $api->send($request);
    expect($response->collect()->get('status')['code'])->toBe(200);
});
