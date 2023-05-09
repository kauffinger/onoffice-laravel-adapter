<?php

namespace Kauffinger\OnOfficeApi\Actions;

use Kauffinger\OnOfficeApi\Actions\ReadActions\ReadAddressAction;
use Kauffinger\OnOfficeApi\Actions\ReadActions\ReadAppointmentAction;
use Kauffinger\OnOfficeApi\Actions\ReadActions\ReadBasicSettingAction;
use Kauffinger\OnOfficeApi\Actions\ReadActions\ReadEstateAction;
use Kauffinger\OnOfficeApi\Actions\ReadActions\ReadImprintAction;
use Kauffinger\OnOfficeApi\Actions\ReadActions\ReadTaskAction;
use Kauffinger\OnOfficeApi\Actions\ReadActions\ReadUserAction;
use Kauffinger\OnOfficeApi\Actions\ReadActions\ReadUserPhotoAction;

class ReadAction
{
    public function estate(): ReadEstateAction
    {
        return new ReadEstateAction();
    }

    public function task(): ReadTaskAction
    {
        return new ReadTaskAction();
    }

    public function address(): ReadAddressAction
    {
        return new ReadAddressAction();
    }

    public function appointment(): ReadAppointmentAction
    {
        return new ReadAppointmentAction();
    }

    public function user(): ReadUserAction
    {
        return new ReadUserAction();
    }

    public function userPhoto(): ReadUserPhotoAction
    {
        return new ReadUserPhotoAction();
    }

    public function basicSetting(): ReadBasicSettingAction
    {
        return new ReadBasicSettingAction();
    }

    public function imprint(): ReadImprintAction
    {
        return new ReadImprintAction();
    }
}
