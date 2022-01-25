<?php

namespace Creagia\Redsys\Enums;

enum Environment: string
{
    case Test = 'test';
    case Production = 'production';
    case Custom = 'custom';
}
