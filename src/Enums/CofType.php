<?php

namespace Creagia\Redsys\Enums;

/**
 * Docs: https://pagosonline.redsys.es/funcionalidades-COF.html
 */
enum CofType: string
{
    /**
     * Installments: Pago aplazado. Siempre referido a una compra INDIVIDUAL, el importe de las diferentes transacciones es fijo, y con un intervalo de tiempo definido
     */
    case Installments = "I";

    /**
     * Recurring: Pago recurrente. El importe de las transacciones puede ser fijo o variable, y con un intervalo de tiempo definido
     */
    case Recurring = "R";

    /**
     * Reauthorization: Normalmente ante envíos parciales. También cuando el cliente amplía la estancia en hotel / alquiler del vehículo o cuando habiendo una autorización estimada, se solicita el importe final (“remate”)
     */
    case Reauthorization = "H";

    /**
     * Resubmission: Original denegada por “saldo”; solo para ciertos sectores de actividad (para más detalle revisar la normativa de las marcas) y con un máximo de días desde la compra. Ejemplo relevante: “Transporte”
     */
    case Resubmission = "E";

    /**
     * Delayed: los que suceden con posterioridad a la operación por servicios prestados / usados desconocidos al principio. (Minibar, daños vehículo, multas, ...)
     */
    case Delayed = "D";

    /**
     * Incremental: cuando durante el periodo de contrato se incurren en servicios adicionales
     */
    case Incremental = "M";

    /**
     * No Show: cuando el comercio cobra servicios a los que el titular se comprometió, pero luego no cumplió con los términos acordados. Ejemplo relevante: reservas en hoteles no atendidas sin cancelar.
     */
    case NoShow = "N";

    case Others = "C";
}
