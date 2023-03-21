<?php
date_default_timezone_set('America/El_Salvador');

class Movimientos extends DB
{
    public $IdCotizacion;
    public $Agente;
    public $Agencia;
    public $Comentario;
    public $Accion;
    public $Creado;
    public $CreadoTimestamp;


    public function listarMovimientos($id)
    {
        $query = "SELECT * FROM vta_listar_movimientos WHERE IdCotizacion='".$id."'";
        return $this->EjecutarQuery($query);
    }


    public function Insertar()
    {
        $query = "INSERT INTO tbl_movimientos(
            IdCotizacion,
            Agente,
            Agencia,
            Comentario,
            Accion,
            Creado,
            CreadoTimestamp,
            Eliminado )
            VALUES (
            '" . $this->IdCotizacion . "',
            '" . $this->Agente . "',
            '" . $this->Agencia . "',
            '" . $this->Comentario . "',
            '" . $this->Accion . "',
            '" . date("Y-m-d h:i:s ") . "',
            '" . date("A") . "',
            'N' ) ";
        return $this->EjecutarQuery($query);
    }

    public function Actualizar($id)
    {
        $query = "UPDATE tbl_movimientos 
        SET Agente = '".$this->Agente."',
        Agencia = '" . $this->Agencia . "', 
        Comentario = '" . $this->Comentario . "', 
        Accion = '" . $this->Accion . "' 
        WHERE IdMovimiento = '".$id."'";

        return $this->EjecutarQuery($query);
    }

    public function Eliminar($id)
    {
        $query = "UPDATE tbl_movimientos SET Eliminado='S' WHERE IdMovimiento='" . $id . "'";
        return $this->EjecutarQuery($query);
    }
}
