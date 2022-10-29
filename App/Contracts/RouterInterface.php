<?php
namespace App\Contracts;
/**
 * @author Joseph Abah
 *
 * A simple router interface
 * I will do a quick regex routing  - A tree implementation would be faster
 */
interface RouterInterface
{
    public function getCurrentPath() : string;
    public function getMethodRoutes(string $method) : array;
    public function routes() : array;
}
