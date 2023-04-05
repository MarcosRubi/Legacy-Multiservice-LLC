<?php
date_default_timezone_set('America/El_Salvador');

class Abonos extends DB
{
    public $IdCliente;
    public $IdFactura;
    public $IdTipoFactura;
    public $CantidadAbono;
    public $BalanceActual;
    public $Efectivo;
    public $CreditoValor;
    public $CreditoNumero;
    public $Cheque;
    public $Banco;
    public $Cupon;
    public $Comentario;
    public $Creado;
    public $CreadoTimestamp;


    public function listarAbonos($id)
    {
        $query = "SELECT * FROM vta_listar_abonos WHERE IdFactura='".$id."'";
        return $this->EjecutarQuery($query);
    }

    public function listarDatosCliente($id){
        $query = "SELECT * FROM vta_factura_cliente WHERE IdFactura='".$id."'";
        return $this->EjecutarQuery($query);
    }

    public function Insertar()
    {
        $query = "INSERT INTO tbl_abonos(
            IdCliente,
            IdFactura,
            IdTipoFactura,
            CantidadAbono,
            BalanceActual,
            Efectivo,
            CreditoValor,
            CreditoNumero,
            Cheque,
            Banco,
            Cupon,
            Comentario,
            Creado,
            CreadoTimestamp,
            Eliminado )
            VALUES (
            '" . $this->IdCliente . "',
            '" . $this->IdFactura . "',
            '" . $this->IdTipoFactura . "',
            '" . $this->CantidadAbono . "',
            '" . $this->BalanceActual . "',
            '" . $this->Efectivo . "',
            '" . $this->CreditoValor . "',
            '" . $this->CreditoNumero . "',
            '" . $this->Cheque . "',
            '" . $this->Banco . "',
            '" . $this->Cupon . "',
            '" . $this->Comentario . "',
            '" . date("Y-m-d h:i:s ") . "',
            '" . date("A") . "',
            'N' ) ";
        return $this->EjecutarQuery($query);
    }

    public function Actualizar($id)
    {
        $query = "UPDATE tbl_abonos
        SET BalanceActual = '".$this->BalanceActual."' 
        WHERE IdAbono = '".$id."'";

        return $this->EjecutarQuery($query);
    }

    public function Eliminar($id)
    {
        $query = "UPDATE tbl_abonos SET Eliminado='S' WHERE IdAbono='" . $id . "'";
        return $this->EjecutarQuery($query);
    }

    public function obtenerUltimoAbono($id){
        $query = "SELECT * FROM tbl_abonos
        WHERE IdFactura = '".$id."'
        ORDER BY Creado DESC
        LIMIT 1;";
        return $this->EjecutarQuery($query);
    }
}
