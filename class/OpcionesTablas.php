<?php
class OpcionesTablas extends DB
{

    public function listarTiposFacturas()
    {
        $query = "SELECT * FROM vta_listar_tipos_facturas";
        return $this->EjecutarQuery($query);
    }

    public function listarIatas()
    {
        $query = "SELECT * FROM vta_listar_iatas";
        return $this->EjecutarQuery($query);
    }
    public function listarTipos()
    {
        $query = "SELECT * FROM vta_listar_tipos";
        return $this->EjecutarQuery($query);
    }
    public function listarFormasPagos()
    {
        $query = "SELECT * FROM vta_listar_formas_pagos";
        return $this->EjecutarQuery($query);
    }

    public function buscarIata($id){
        $query = "SELECT * FROM tbl_iatas WHERE IdIata='".$id."'";
        return $this->EjecutarQuery($query);
    }
    public function buscarFormaPago($id){
        $query = "SELECT * FROM tbl_formas_pagos WHERE IdFormaPago='".$id."'";
        return $this->EjecutarQuery($query);
    }
    public function buscarTipoFactura($id){
        $query = "SELECT * FROM vta_listar_tipos_facturas WHERE IdTipoFactura='".$id."'";
        return $this->EjecutarQuery($query);
    }

}
