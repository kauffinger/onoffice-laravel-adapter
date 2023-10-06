<?php

namespace Kauffinger\OnOfficeApi\Actions\ReadActions;

use Kauffinger\OnOfficeApi\Actions\ActionInterface;
use Kauffinger\OnOfficeApi\Actions\Traits\HasFilter;
use Kauffinger\OnOfficeApi\Actions\Traits\HasPagination;
use Kauffinger\OnOfficeApi\Actions\Traits\HasResourceId;
use Kauffinger\OnOfficeApi\Enums\ActionType;
use Kauffinger\OnOfficeApi\Enums\ReadResource;

/**
 * This API call reads user photos. The photos are delivered as base64 strings or as links, depending on the parameter photosAsLinks.
 * Without parameters the photos of the first 20 users are delivered. Use parameter listlimit to retrieve more. If you specify a user ID as resourceid, the photo of this user will be delivered.
 * With the parameter filter you can specify an array of user IDs whose photos you want to read. If there is no picture at all existing for the user, the parameter photo returns null.
 * If no user photo is available under “Extras >> Settings >> User >> Tab basic data “, the photo of the linked address record is delivered.
 * You need read permission to query user data via API. This can be set under “Extras->Einstellungen->Benutzer” / “Extras->Settings->User”. Choose the tab “API user”, then the tab “Rights” with the setting “Benutzerdaten über API auslesen” / “Read out user data by API”. Only API users can see this setting.
 */
class ReadUserPhotoAction implements ActionInterface
{
    use HasFilter;
    use HasPagination;
    use HasResourceId;

    private bool $photosAsLinks;

    private array $messengerUserIds;

    public function __construct(
        private readonly array $actionArray = [],
    ) {

    }

    /**
     * Array of messenger user IDs. Another way to retrieve user pictures is via the parameter messengerUIDs. For the messenger, it is easier to retrieve user pictures using the users’ messenger ID.
     * The messenger UIDs correspond to users. The messenger UIDs can be read with the calls messenger chatroom participants and messenger user list. The pictures requested with the messengerUIds parameter ignore the filter parameter.
     * When queried via messengerUIds, the response also contains the parameter messengerUIds to establish the mapping between user IDs and messengerUIds. If the messengerUIds array is empty, the messengerUIds for all users will still be output in the response.
     */
    public function messengerUserIds(int ...$userIds): self
    {
        $this->messengerUserIds = [
            ...$this->messengerUserIds ?? [],
            ...$userIds,
        ];

        return $this;
    }

    public function setPhotosAsLinks(): self
    {
        $this->photosAsLinks = true;

        return $this;
    }

    public function render(): array
    {
        $parameters = collect($this->actionArray)
            ->putIfNotNull('photosAsLinks', $this->photosAsLinks ?? null)
            ->putIfNotNull('filter', $this->filter ?? null)
            ->putIfNotNull('listlimit', $this->listLimit ?? null)
            ->putIfNotNull('listoffset', $this->listOffset ?? null)
            ->putIfNotNull('sortby', $this->sortBy ?? null)
            ->putIfNotNull('messengerUIds', $this->messengerUserIds ?? null)
            ->toArray();

        return [
            'actionid' => ActionType::Read->value,
            'resourceid' => $this->resourceId ?? '',
            'resourcetype' => ReadResource::UserPhoto->value,
            'parameters' => $parameters,
        ];
    }
}
