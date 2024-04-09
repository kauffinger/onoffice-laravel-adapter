<?php

declare(strict_types=1);

use Illuminate\Support\Carbon;
use Kauffinger\OnOfficeApi\Actions\Action;
use Kauffinger\OnOfficeApi\Actions\ReadActions\ReadAppointmentAction;
use Kauffinger\OnOfficeApi\Facades\OnOfficeApi;
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

    expect($actionArray['parameters'])->toHaveKeys(['datestart', 'dateend', 'allusers', 'showcancelled'])
        ->and($actionArray['parameters']['datestart'])->toBeString()
        ->and($actionArray['parameters']['dateend'])->toBeString()
        ->and($actionArray['parameters']['allusers'])->toBeTrue()
        ->and($actionArray['parameters']['showcancelled'])->toBeTrue();
});

it('will send a successful request', function () {
    $request = new OnOfficeApiRequest();
    $request->addAction(
        Action::read()
            ->appointment()
            ->dateStart(Carbon::now()->subtract('days', 30))
            ->dateEnd(Carbon::now())
            ->showCancelled()
            ->allUsers()
    );

    $response = OnOfficeApi::send($request);

    expect($response->ok())->toBeTrue();
});
