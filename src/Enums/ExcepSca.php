<?php

namespace Creagia\Redsys\Enums;

enum ExcepSca: string
{
    /**
     * MIT: Operación iniciada por el comercio (sin estar asociada a una acción o evento del cliente)
     * que están fuera del alcance de la PSD2. Este es el caso de las operativas de pagos de
     * subscripciones, recurrentes, etc. todas las que requieren el almacenamiento de las credenciales
     * de pago del cliente (COF) o su equivalente mediante operativas de pagos programados tokenizados
     * (uso funcionalidad “pago por referencia” en pagos iniciados por el comercio). Toda operativa de
     * pago iniciada por el comercio (MIT) requiere que inicialmente cuando el cliente concede el permiso
     * al comercio de uso de sus credenciales de pago, dicho “permiso o mandato” se haga mediante
     * operación autenticada con SCA.
     */
    case MerchantInitiatedTransaction = 'MIT';

    /**
     * LWV: Exención por bajo importe (hasta 30 €, con máx. 5 ops. o 100 € acumulado por tarjeta, estos
     * contadores son controlados a nivel de entidad emisora de la tarjeta).
     */
    case BajoImporte = 'LWV';

    /**
     * TRA: Exención por utilizarse un sistema de análisis de riesgo (y considerarse bajo riesgo) por
     * parte del adquirente/comercio.
     */
    case SistemaAnalisisRiesgo = 'TRA';

    /**
     * COR: Exención restringida a los casos de uso de un protocolo pago corporativo seguro.
     */
    case PagoCorporativo = 'COR';

    /**
     * ATD: Exención de autenticación delegada.
     */
    case AutenticacionDelegada = 'ATD';

    /**
     * NDF: El comercio informa que no quiere aplicar ninguna exención por defecto, en caso de que aplique.
     */
    case NoAplicar = 'NDF';
}
