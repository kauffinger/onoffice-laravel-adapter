<?php

declare(strict_types=1);

use Kauffinger\OnOfficeApi\Actions\Action;
use Kauffinger\OnOfficeApi\Actions\CreateActions\CreateEstateAction;
use Kauffinger\OnOfficeApi\Actions\EditActions\EditEstateAction;
use Kauffinger\OnOfficeApi\Enums\EstateStatus;
use Kauffinger\OnOfficeApi\Enums\Language;
use Kauffinger\OnOfficeApi\Facades\OnOfficeApi;
use Kauffinger\OnOfficeApi\OnOfficeApiRequest;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Saloon;

it('can be retrieved from Action base class', function () {
    $instance = Action::create()->estate();
    expect($instance::class)->toBe(CreateEstateAction::class);
});

it('will render a suitable action array', function () {
    $action = new CreateEstateAction();
    $actionArray = $action
        ->set(
            [
                'objektart' => 'haus',
                'nutzungsart' => 'wohnen',
                'vermarktungsart' => 'kauf',
                'objekttyp' => 'einfamilienhaus',
                'plz' => 52068,
                'ort' => 'Aachen',
                'land' => 'DEU',
                'heizungsart' => ['gas', 'fussboden'],
            ]
        )
        ->setStatus(EstateStatus::Pending)
        ->setSold(false)
        ->setReserved(true)
        ->estateLanguage(Language::German)
        ->render();

    expect($actionArray['parameters']['data'])
        ->toHaveKeys([
            'objektart',
            'objekttyp',
            'vermarktungsart',
            'objekttyp',
            'plz',
            'ort',
            'land',
            'heizungsart',
            'status',
            'verkauft',
            'reserviert',
        ])
        ->and($actionArray['parameters']['estatelanguage'])->toBe(Language::German->value)
        ->and($actionArray['parameters']['data']['status'])->toBe(EstateStatus::Pending->value);

});

it('will not allow illegal arguments in update', function () {
    $invalidKeys = array_fill_keys(EditEstateAction::SPECIAL_FIELDS, 0);
    (new CreateEstateAction())
        ->set($invalidKeys);
})->throws(InvalidArgumentException::class);

it('will send a successful request', function () {

    $request = new OnOfficeApiRequest();
    $request->addAction(
        Action::create()
            ->estate()
            ->set(
                [
                    'Vorname' => 'Peter',
                    'Name' => 'Lustig',
                    'Strasse' => 'Hauptst. 2',
                    'Land' => 'DEU',
                    'Geburtsdatum' => '2017-01-31 12:00:00',
                ]
            )
    );

    Saloon::fake([
        MockResponse::make([]),
    ]);

    $response = OnOfficeApi::send($request);
    expect($response->ok())->toBeTrue();
});
