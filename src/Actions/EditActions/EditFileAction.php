<?php

declare(strict_types=1);

namespace Kauffinger\OnOfficeApi\Actions\EditActions;

use InvalidArgumentException;
use Kauffinger\OnOfficeApi\Actions\ActionInterface;
use Kauffinger\OnOfficeApi\Enums\ActionType;
use Kauffinger\OnOfficeApi\Enums\EditResource;

/**
 * `Changes information from estate records.`
 */
class EditFileAction implements ActionInterface
{
    final public const KIND_FIELDS = [
        'Foto',
        'Grundriss',
        'Lageplan',
        'Titelbild',
        'LOGO',
        'Expose',
        'Aushang',
        'Mietaufstellung',
        'Dokument',
        'Foto_gross',
        'Link',
        'Panorama',
        'Banner',
        'Stadtplan',
        'Film-Link',
        'QR-Code',
        'Energieausweis',
        'Epass_Skala',
        'Ogulo-Link',
        'Objekt-Link',
        'Anzeigen',
        'Finanzierungsbeispiel',
    ];

    /**
     * @param  $fileId  ID of the file to be edited.
     * @param  $parentId  ID of the property record whose files you want to change.
     */
    public function __construct(
        int $fileId,
        int $parentId,
        string $relationType = 'estate',
        private array $actionArray = [],
    ) {
        if ($relationType !== 'estate') {
            throw new \InvalidArgumentException(
                "Only relationType 'estate' is supported at the moment."
            );
        }
        $this->actionArray['fileId'] = $fileId;
        $this->actionArray['parentId'] = $parentId;
        $this->actionArray['relationType'] = $relationType;
    }

    /**
     * @param  array<string, mixed>  $data  Keys of fields to change and values they should be changed to.
     */
    public function update(array $data): self
    {
        foreach ($data as $key => $value) {
            $this->actionArray['data'][$key] = $value;
        }

        return $this;
    }

    /**
     * @param  bool  $force  Force the art to be set even if it is not one of the allowed values. Make sure to open a pull request if there is a new value.
     *
     * @throws InvalidArgumentException
     */
    public function setArt(string $art, bool $force = false): self
    {
        if (! in_array($art, self::KIND_FIELDS) && ! $force) {
            throw new \InvalidArgumentException(
                "Invalid art '$art'. Choose one of: ".implode(', ', self::KIND_FIELDS).' .'
            );
        }
        $this->actionArray['data']['Art'] = $art;

        return $this;
    }

    public function setLanguage(string $language): self
    {
        $this->actionArray['data']['language'] = $language;

        return $this;
    }

    public function setTitle(string $title): self
    {
        $this->actionArray['data']['title'] = $title;

        return $this;
    }

    public function setFreeText(string $freeText): self
    {
        $this->actionArray['data']['freetext'] = $freeText;

        return $this;
    }

    public function setDocumentAttribute(string $documentAttribute): self
    {
        $this->actionArray['data']['document_attribute'] = $documentAttribute;

        return $this;
    }

    public function render(): array
    {

        return [
            'actionid' => ActionType::Edit->value,
            'resourceid' => null,
            'resourcetype' => EditResource::File->value,
            'parameters' => $this->actionArray,
        ];
    }
}
