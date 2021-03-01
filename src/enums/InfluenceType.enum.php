<?php
namespace Point_Calc_Php\Enums;

abstract class InfluenceType extends BasicEnum {
    public const DATA_EXCHANGE = 1;
    public const DISTRIBUTED_COMPUTING = 2;
    public const PERFORMANCE = 3;
    public const HIGH_USE = 4;
    public const TRANSACTION_VOLUME = 5;
    public const ONLINE_DATA_INPUT = 6;
    public const END_USER_EFICIENCY = 7;
    public const ONLINE_UPDATES = 8;
    public const COMPLEX_PROCESSING = 9;
    public const REUSABILITY = 10;
    public const EASE_OF_INSTALLATION = 11;
    public const EASE_OF_USE = 12;
    public const MULTIPLE_PROCESSING_SITES = 13;
    public const EASE_OF_CHANGES = 14;
}