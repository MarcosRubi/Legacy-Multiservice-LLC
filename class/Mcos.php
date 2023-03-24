<?php
date_default_timezone_set('America/El_Salvador');

class Mcos extends DB
{
    public $IdCliente;
    public $Pnr;
    public $NumeroMco;
    public $Valor;
    public $IdIata;
    public $IdFormaPago;
    public $Fm;
    public $Fee;
    public $Creado;
    public $CreadoTimesTamp;


    public function listarMcos()
    {
        $query = "SELECT * FROM vta_listar_mcos";
        return $this->EjecutarQuery($query);
    }

    public function Insertar()
    {
        $query = "INSERT INTO tbl_mcos(
            IdCliente,
            Pnr,
            NumeroMco,
            Valor,
            IdIata,
            IdFormaPago,
            Fm,
            Fee,
            Creado,
            CreadoTimestamp,
            Eliminado )
            VALUES (
            '" . $this->IdCliente . "',
            '" . $this->Pnr . "',
            '" . $this->NumeroMco . "',
            '" . $this->Valor . "',
            '" . $this->IdIata . "',
            '" . $this->IdFormaPago . "',
            '" . $this->Fm . "',
            '" . $this->Fee . "',
            '" . date("Y-m-d h:i:s ") . "',
            '" . date("A") . "',
            'N' ) ";
        return $this->EjecutarQuery($query);
    }

    public function InsertarQueryPreparada($query)
    {
        return $this->EjecutarQuery($query);
    }
    
    public function InsertarPreparar()
    {
        $query = "INSERT INTO tbl_mcos(
            IdCliente,
            Pnr,
            NumeroMco,
            Valor,
            IdIata,
            IdFormaPago,
            Fm,
            Fee,
            Creado,
            CreadoTimestamp,
            Eliminado )
            VALUES (
            '" . $this->IdCliente . "',
            '" . $this->Pnr . "',
            '" . $this->NumeroMco . "',
            '" . $this->Valor . "',
            '" . $this->IdIata . "',
            '" . $this->IdFormaPago . "',
            '" . $this->Fm . "',
            '" . $this->Fee . "',
            '" . date("Y-m-d h:i:s ") . "',
            '" . date("A") . "',
            'N' ) ";
        return $query;
    }

    public function Actualizar($id)
    {
        $query = "UPDATE tbl_mcos 
        SET NumeroMco = '".$this->NumeroMco."',
        Valor = '" . $this->Valor . "',
        IdIata = '" . $this->IdIata . "',
        IdFormaPago = '" . $this->IdFormaPago . "',
        Fm = '" . $this->Fm . "',
        Fee = '" . $this->Fee . "' 
        WHERE IdMco = '".$id."'";

        return $this->EjecutarQuery($query);
    }

    public function Eliminar($id)
    {
        $query = "UPDATE tbl_mcos SET Eliminado='S' WHERE IdMco='" . $id . "'";
        return $this->EjecutarQuery($query);
    }
}
