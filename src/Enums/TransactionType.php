<?php

namespace Creagia\Redsys\Enums;

enum TransactionType: int
{
    case Autorizacion = 0;
    case Preautorizacion = 1;
    case Confirmacion = 2;
    case Devolucion = 3;
    case PreautorizacionSeparada = 7;
    case ConfirmacionSeparada = 8;
    case Anulacion = 9;
    case Paygold = 15;
    case AutenticacionPuce = 17;
    case DevolucionSinOriginal = 34;
    case PremioDeApuestas = 37;
}
