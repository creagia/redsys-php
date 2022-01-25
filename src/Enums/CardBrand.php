<?php

namespace Creagia\Redsys\Enums;

enum CardBrand: int
{
    case Visa = 1;
    case Mastercard = 2;
    case Diners = 6;
    case Privada = 7;
    case Amex = 8;
    case JCB = 9;
    case UPI = 22;
}
