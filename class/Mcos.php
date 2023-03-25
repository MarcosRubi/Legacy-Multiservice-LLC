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
    public $Comision;
    public $GananciaNeta;
    public $Creado;
    public $CreadoTimesTamp;


    public function listarMcos()
    {
        $query = "SELECT * FROM vta_listar_mcos";
        return $this->EjecutarQuery($query);
    }

    public function Insertar()
    {
        $this->GananciaNeta = round(($this->Valor * 0.965), 2);
        $this->Comision = round(($this->Valor - $this->GananciaNeta), 2);

        $query = "INSERT INTO tbl_mcos(
            IdCliente,
            Pnr,
            NumeroMco,
            Valor,
            IdIata,
            IdFormaPago,
            Comision,
            GananciaNeta,
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
            '" . $this->Comision . "',
            '" . $this->GananciaNeta . "',
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
        $this->GananciaNeta = round(($this->Valor * 0.965),2);
        $this->Comision = round(($this->Valor - $this->GananciaNeta),2);

        $query = "INSERT INTO tbl_mcos(
            IdCliente,
            Pnr,
            NumeroMco,
            Valor,
            IdIata,
            IdFormaPago,
            Comision,
            GananciaNeta,
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
            '" . $this->Comision. "',
            '" . $this->GananciaNeta . "',
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
        Comision = '" . $this->Comision . "',
        GananciaNeta = '" . $this->GananciaNeta . "' 
        WHERE IdMco = '".$id."'";

        return $this->EjecutarQuery($query);
    }

    public function Eliminar($id)
    {
        $query = "UPDATE tbl_mcos SET Eliminado='S' WHERE IdMco='" . $id . "'";
        return $this->EjecutarQuery($query);
    }
}
