<?php
namespace Point_Calc_Php\services\database;

abstract class Connection {
    public abstract function connect(): void; // This varies from driver to driver
    public abstract function getConfig() : void;
    public abstract function executeCommand(string $command): void;
    public abstract function getData(string $command): array;
}
?>