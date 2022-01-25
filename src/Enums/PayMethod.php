<?php

namespace Creagia\Redsys\Enums;

enum PayMethod: string
{
    case Bizum = 'z';
    case PayPal = 'p';
    case Transferencia = 'R';
    case Masterpass = 'N';
    case Card = 'C';
}
