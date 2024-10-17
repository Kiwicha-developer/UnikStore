<?php
namespace App\Services;

interface ConfiguracionServiceInterface
{
    public function getAllCategorias();
    public function getAllRangos();
    public function getAllEmpresas();
    public function updateCorreoEmpresa($id,$correo);
    public function updateComisionEmpresa($id,$comision);
    public function updateCalculadora($igv,$fact);
    public function updateComisionValue($idGrupo,$idRango,$comision);
    public function getAllEspecificaciones();
    public function createCaracteristica($descripcion);
    public function insertCaracteristicaXGrupo($idGrupo,$idCaracteristica);
}