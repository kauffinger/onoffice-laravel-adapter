<?php

declare(strict_types=1);

namespace Kauffinger\OnOfficeApi\Actions\ReadActions;

use Kauffinger\OnOfficeApi\Actions\Traits\HasFilter;
use Kauffinger\OnOfficeApi\Actions\Traits\HasPagination;
use Kauffinger\OnOfficeApi\Actions\Traits\HasResourceId;
use Kauffinger\OnOfficeApi\Contracts\ActionInterface;
use Kauffinger\OnOfficeApi\Enums\ActionType;
use Kauffinger\OnOfficeApi\Enums\OnOfficeResources\ReadResource;

/**
 * Class ReadUserAction
 * Reads all specified fields from user records. Most user fields are valid here and are passed as elements of an array in the parameter data. You cannot read the user passwort via API.
 * If you specify a user ID as resourceid, only data for this user will be read. If you need to retrieve the user IDs, then query all users first with parameter data and without a filter. In the response are the user IDs included.
 * Each parameter is returned with the appropriate value of the record.
 * In enterprise these user data are found under “Extras->Settings->User” / “Extras->Einstellungen->Benutzer”.
 * You need read permission to query user data via API. This can be set under “Extras->Einstellungen->Benutzer” / “Extras->Settings->User”. Choose the tab “API user”, then the tab “Rights” with the setting “Benutzerdaten über API auslesen” / “Read out user data by API”. Only API users can see this setting.
 * The own user can be queried via resourceid even without the right “Benutzerdaten über API auslesen / Read out user data by API”.
 */
class ReadUserAction implements ActionInterface
{
    use HasFilter;
    use HasPagination;
    use HasResourceId;

    public function __construct(
        private array $actionArray = [],
    ) {

    }

    /**
     * @param  string[]  $data  Following fields can be queried: Anrede, Titel, Kuerzel, Vorname, Nachname, Firma, PLZ, Ort, Strasse, Hausnummer, Land, province, Mobil, Telefon, Fax, Url, UstID, taxNumber, Gerichtsstand, imprintFurthermore (Weiteres), Firmazusatz1, PositionUnternehmen, Namezusatz1, Namezusatz2, Bank, IBAN, BIC, Finanzamt, Hinweis, Sonstiges, Nr, Name (user name), email, Emailname, adrId:adressen.ID (linked user address), anbieter, Prefix, usesAccount:account.id (Account approved or blocked), Sprache, meetingUrl (user link for video conference), online (status of a user: active, permanently deactivated, locked, etc.)
     */
    public function setData(array $data): self
    {
        $this->actionArray['data'] = $data;

        return $this;
    }

    /**
     * Alternative way to set data, see setData()
     */
    public function fieldsToRead(string ...$fields): self
    {
        $this->actionArray['data'] = [...$fields];

        return $this;
    }

    public function render(): array
    {
        $parameters = collect($this->actionArray)
            ->putIfNotNull('filter', $this->filter ?? null)
            ->putIfNotNull('listlimit', $this->listLimit ?? null)
            ->putIfNotNull('listoffset', $this->listOffset ?? null)
            ->putIfNotNull('sortby', $this->sortBy ?? null)
            ->toArray();

        return [
            'actionid' => ActionType::Read->value,
            'resourceid' => $this->resourceId ?? '',
            'resourcetype' => ReadResource::User->value,
            'parameters' => $parameters,
        ];
    }
}
