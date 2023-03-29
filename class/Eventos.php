<?php
date_default_timezone_set('America/El_Salvador');

class Eventos extends DB
{
    public $NombreEmpleado;
    public $TipoEvento;
    public $UrlEvento;
    public $Mensaje;
    public $VentanaEmergente;
    public $Creado;
    public $CreadoTimestamp;
    public $Icono;


    public function listarEventos()
    {
        $query = "SELECT * FROM vta_listar_eventos lIMIT 10";
        return $this->EjecutarQuery($query);
    }

    public function Insertar()
    {
        $query = "INSERT INTO tbl_eventos(
            NombreEmpleado,
            TipoEvento,
            UrlEvento,
            Mensaje,
            VentanaEmergente,
            Icono,
            Creado,
            CreadoTimestamp,
            Eliminado )
            VALUES (
            '" . $this->NombreEmpleado . "',
            '" . $this->TipoEvento . "',
            '" . $this->UrlEvento . "',
            '" . $this->Mensaje . "',
            '" . $this->VentanaEmergente . "',
            '" . $this->Icono . "',
            '" . date("Y-m-d h:i:s ") . "',
            '" . date("A") . "',
            'N' ) ";
        return $this->EjecutarQuery($query);
    }

    public function Eliminar($id)
    {
        $query = "UPDATE tbl_eventos SET Eliminado='S' WHERE IdEvento='" . $id . "'";
        return $this->EjecutarQuery($query);
    }
}
