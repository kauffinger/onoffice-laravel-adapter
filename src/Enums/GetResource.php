<?php

declare(strict_types=1);

namespace Kauffinger\OnOfficeApi\Enums;

enum GetResource: string
{
    case Search = 'search';
    case EmailLink = 'emailassignments';
    case Link = 'getlink';
    case MailSignature = 'emailsignature';
    case Template = 'templates';
    case FieldConfiguration = 'fields';
    case KindOfActionAndTypeOfAction = 'actionkindtypes';
    case Relation = 'idsfromrelation';
    case AddressCompletionFields = 'addressCompletionFields';
    case SearchCriteria = 'searchcriterias';
    case SearchCriteriaFields = 'searchCriteriaFields';
    case RegionsLiveSearch = 'regionsLiveSearch';
    case TeanantOrBuyerSeeker = 'qualifiedsuitors';
    case EstateImagesPublishedOnHomepage = 'estatepictures';
    case Region = 'regions';
    case PDF = 'pdf';
    case Filter = 'filter';
    case File = 'file';
    case Survey = 'appointmentdocument';
    case MacroResolve = 'macroresolve';
    case User = 'users';
    case Group = 'groups';
    case EstateTrackingDetails = 'estatetrackingdetails';
    case EstateCategories = 'estateCategories';
    case CalendarResources = 'calendarResources';
    case DefaultAttachments = 'defaultAttachments';
    case NumberOfLogEntries = 'log';
    case SellingPriceOffer = 'priceOffer';
    case MarketPlaceGetInvoiceRecipient = 'getMarketplaceInvoiceRecipient';
}
