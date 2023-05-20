<?php
date_default_timezone_set('America/El_Salvador');

class Recordatorios extends DB
{
    public $IdCliente;
    public $Fecha;
    public $Estado;
    public $Titulo;
    public $Descripcion;
    public $IdEmpleado;
    public $Hora;


    public function listarRecordatorios($idEmpleado)
    {
        $query = "SELECT * FROM vta_listar_recordatorios WHERE IdEmpleado='" . $idEmpleado . "'";
        return $this->EjecutarQuery($query);
    }

    public function Insertar()
    {
        $query = "INSERT INTO tbl_recordatorios(
            IdCliente,
            IdEmpleado,
            Fecha,
            Hora,
            Estado,
            Titulo,
            Descripcion,
            Eliminado )
            VALUES (
            '" . $this->IdCliente . "',
            '" . $this->IdEmpleado . "',
            '" . $this->Fecha . "',
            '" . $this->Hora . "',
            '" . $this->Estado . "',
            '" . $this->Titulo . "',
            '" . $this->Descripcion . "',
            'N' ) ";
        return $this->EjecutarQuery($query);
    }

    public function ActualizarEstado($id)
    {
        $query = "UPDATE tbl_recordatorios
        SET Estado = '" . $this->Estado . "' 
        WHERE IdRecordatorio = '" . $id . "'";

        return $this->EjecutarQuery($query);
    }

    public function Eliminar($id)
    {
        $query = "UPDATE tbl_recordatorios SET Eliminado='S' WHERE IdRecordatorio='" . $id . "'";
        return $this->EjecutarQuery($query);
    }
}
