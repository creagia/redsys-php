<?php

namespace Creagia\Redsys\Enums;

enum ProcessedPayMethod: int
{
    case VisaSecure = 1;
    case TradicionalMundial = 3;
    case Finanet = 5;
    case CapacidadFINANET = 11;
    case CapacidadVisaSecure = 13;
    case TradicionalUE = 14;
    case MasterCardIdentityCheck = 22;
    case CapacidadIdentityCheck = 23;
    case PagoAMEX = 24;
    case PagoMOTO = 25;
    case PagoJCB = 28;
    case PagoDINERS = 31;
    case JCB_JSecure = 39;
    case CapacidadJSecure = 40;
    case Domiciliacion = 41;
    case Transferencia = 42;
    case PayPal = 54;
    case SafeKey = 57;
    case CapacidadSafeKey = 58;
    case MasterPassWallet = 59;
    case Bizum = 68;
    case UPI_ExpressPay = 70;
    case GooglePay = 71;
    case ApplePay = 72;
    case UPI_SecurePlus = 73;
    case CapacidadDiscover = 74;
    case DiscoverProtectBuy = 75;
    case Discover = 76;
    case AmazonPay = 77;
    case ChallengeVisa = 78;
    case ChallengeMasterCard = 79;
    case FrictionlessVisa = 80;
    case FrictionlessMasterCard = 81;
    case AttemptVisa = 82;
    case AttemptMasterCard = 83;
    case ChallengeAmex = 85;
    case ChallengeDiscover = 86;
    case FrictionlessAmex = 87;
    case FrictionlessDiscover = 88;
    case AttemptAmex = 89;
    case AttemptDiscover = 90;
    case PagoDinersProtectBuy = 92;
    case ChallengeDinersProtectBuy = 93;
    case FrictionlessDinersProtectBuy = 94;
    case PagoAttemptDinersProtectBuy = 95;
    case ChallengeJCB = 96;
    case FrictionlessJCB = 97;
    case AttemptJCB = 98;
    case PagoConCuenta = 107;
}
