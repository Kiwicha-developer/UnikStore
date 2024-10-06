<?php
namespace App\Services;

interface CalculadoraServiceInterface
{
    public function get();
    public function getTasaCambio();
    public function getIgv();
    public function getComisionByRelation($table);
    public function getAllLabelCategory(); 
    public function allComision();
}