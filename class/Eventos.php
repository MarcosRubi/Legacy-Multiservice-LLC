<?php
date_default_timezone_set('America/El_Salvador');

class Eventos extends DB
{
    public $NombreEmpleado;
    public $TipoEvento;
    public $UrlEvento;
    public $Mensaje;
    public $Creado;
    public $CreadoTimestamp;


    public function listarEventos()
    {
        $query = "SELECT * FROM vta_listar_eventos";
        return $this->EjecutarQuery($query);
    }

    public function Insertar()
    {
        $query = "INSERT INTO tbl_eventos(
            NombreEmpleado,
            TipoEvento,
            UrlEvento,
            Mensaje,
            Creado,
            CreadoTimestamp,
            Eliminado )
            VALUES (
            '" . $this->NombreEmpleado . "',
            '" . $this->TipoEvento . "',
            '" . $this->UrlEvento . "',
            '" . $this->Mensaje . "',
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