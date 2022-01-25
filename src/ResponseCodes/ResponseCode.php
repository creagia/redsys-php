<?php

namespace Creagia\Redsys\ResponseCodes;

class ResponseCode
{
    public static array $messages = [
        '0101' => 'Tarjeta caducada',
        '0102' => 'Tarjeta en excepción transitoria o bajo sospecha de fraude',
        '0106' => 'Intentos de PIN excedidos',
        '0125' => 'Tarjeta no efectiva',
        '0129' => 'Código de seguridad (CVV2/CVC2) incorrecto',
        '0180' => 'Tarjeta ajena al servicio',
        '0184' => 'Error en la autenticación del titular',
        '0190' => 'Denegación del emisor sin especificar motivo',
        '0191' => 'Fecha de caducidad errónea',
        '0195' => 'Requiere autenticación SCA',
        '0202' => 'Tarjeta en excepción transitoria o bajo sospecha de fraude con retirada de tarjeta',
        '0904' => 'Comercio no registrado en FUC',
        '0909' => 'Error de sistema',
        '0913' => 'Pedido repetido',
        '0944' => 'Sesión Incorrecta',
        '0950' => 'Operación de devolución no permitida',
        '9912' => 'Emisor no disponible',
        '0912' => 'Emisor no disponible',
        '9064' => 'Número de posiciones de la tarjeta incorrecto',
        '9078' => 'Tipo de operación no permitida para esa tarjeta',
        '9093' => 'Tarjeta no existente',
        '9094' => 'Rechazo servidores internacionales',
        '9104' => 'Comercio con "titular seguro" y titular sin clave de compra segura',
        '9218' => 'El comercio no permite op. seguras por entrada /operaciones',
        '9253' => 'Tarjeta no cumple el check-digit',
        '9256' => 'El comercio no puede realizar preautorizaciones',
        '9257' => 'Esta tarjeta no permite operativa de preautorizaciones',
        '9261' => 'Operación detenida por superar el control de restricciones en la entrada al SIS',
        '9915' => 'A petición del usuario se ha cancelado el pago',
        '9997' => 'Se está procesando otra transacción en SIS con la misma tarjeta',
        '9998' => 'Operación en proceso de solicitud de datos de tarjeta',
        '9999' => 'Operación que ha sido redirigida al emisor a autenticar',
    ];

    public static function fromCode(string $code)
    {
        return self::$messages[$code] ?? $code;
    }
}
