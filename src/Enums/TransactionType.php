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
    case PreautorizacionReemplazo = 11;
    case Paygold = 15;
    case AutenticacionPuce = 17;
    case DevolucionSinOriginal = 34;
    case PremioDeApuestas = 37;
    case AnulacionPago = 45;
    case AnulacionDevolucion = 46;
    case AnulacionConfirmacionSeparada = 47;
    case ModificacionCaducidadEnlacePaygold = 51;
}
