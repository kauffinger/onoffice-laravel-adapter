<?php

namespace Kauffinger\OnOfficeApi\Enums;

enum DoResource: string
{
    case FileUpload = 'uploadfile';
    case SendEmail = 'sendmail';
    case CreateEmailLinks = 'emailassignments';
    case CreateEstateTrackingAccount = 'createestatetrackingaccount';
    case SendAddressCompletion = 'sendaddresscompletion';
    case NewsletterRegistration = 'registerNewsletter';
    case ExecuteWehook = 'executeMarketplaceWebhooks';
    case SellingPriceOffer = 'priceOffer';
    case MarketPlaceUnlockProvider = 'unlockProvider';
    case MarketPlaceCancelSubscription = 'marketplaceCancelAbo';
    case MarketPlaceGenerateSubsequentPaymentLink = 'subsequentPaymentLink';
    case MarketPlaceRefundTransaction = 'transactionRefund';
}
