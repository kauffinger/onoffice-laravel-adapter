<?php

it('can render an action', function () {
    $action = new \Kauffinger\OnOfficeApi\Actions\ReadActions\ReadEstateAction();
    $request = new \Kauffinger\OnOfficeApi\OnOfficeApiRequest();
    $request->addAction($action);

    $action = $request->body()->all()['request']['actions'][0];
    expect($action['actionid'])->toBe(\Kauffinger\OnOfficeApi\Enums\ActionType::Read->value)
        ->and($action['resourceid'])->toBe('')
        ->and($action['resourcetype'])->toBe('estate')
        ->and($action['parameters'])->toMatchArray([
            'filter' => [],
            'listlimit' => 20,
            'listoffset' => 0,
        ])
        ->and($action['identifier'])->toBeUuid();
});

it('can have multiple actions without overlapping identifiers', function () {
    $request = new \Kauffinger\OnOfficeApi\OnOfficeApiRequest();
    for ($i = 0; $i < 10; $i++) {
        $request->addAction(new \Kauffinger\OnOfficeApi\Actions\ReadActions\ReadEstateAction());
    }

    $actions = $request->body()->all()['request']['actions'];
    $allIdentifiers = array_map(fn ($action) => $action['identifier'], $actions);
    expect(count($allIdentifiers))->toBe(10)
        ->and(count(array_unique($allIdentifiers)))->toBe(10);
});
