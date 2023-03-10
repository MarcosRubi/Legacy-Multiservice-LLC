<?php
class Facturas extends DB
{
    public $IdCliente;
    public $IdTipoFactura;
    public $Valor;
    public $Descripcion;
    public $Efectivo;
    public $CreditoValor;
    public $CreditoNumero;
    public $Cheque;
    public $Banco;
    public $Cupon;
    public $Comentario;


    public function listarTodo()
    {
        $query = "SELECT * FROM vta_listar_facturas ORDER BY IdFactura DESC";
        return $this->EjecutarQuery($query);
    }

    public function buscarPorId($id)
    {
        $query = "SELECT * FROM vta_listar_facturas WHERE IdFactura='" . $id . "'";
        return $this->EjecutarQuery($query);
    }

    public function Insertar()
    {
        $query = "INSERT INTO tbl_facturas(
            IdCliente,
            IdTipoFactura,
            Valor,
            Descripcion,
            Efectivo,
            CreditoValor,
            CreditoNumero,
            Cheque,
            Banco,
            Cupon,
            Comentario,
            Eliminado )
            VALUES (
            '" . $this->IdCliente . "',
            '" . $this->IdTipoFactura . "',
            '" . $this->Valor . "',
            '" . $this->Descripcion . "',
            '" . $this->Efectivo . "',
            '" . $this->CreditoValor . "',
            '" . $this->CreditoNumero . "',
            '" . $this->Cheque . "',
            '" . $this->Banco . "',
            '" . $this->Cupon . "',
            '" . $this->Comentario . "',
            'N' ) ";
        return $this->EjecutarQuery($query);
    }

    public function Actualizar($id)
    {
        $query = "UPDATE tbl_facturas SET 
        IdCliente = '" . $this->IdCliente . "',
        IdTipoFactura = '" . $this->IdTipoFactura . "',
        Valor = '" . $this->Valor . "',
        Descripcion = '" . $this->Descripcion . "' 
        Efectivo = '" . $this->Efectivo . "' 
        CreditoValor = '" . $this->CreditoValor . "' 
        CreditoNumero = '" . $this->CreditoNumero . "' 
        Cheque = '" . $this->Cheque . "' 
        Banco = '" . $this->Banco . "' 
        Cupon = '" . $this->Cupon . "' 
        Comentario = '" . $this->Comentario . "' 
        WHERE IdFactura='" . $id . "' ";

        return $this->EjecutarQuery($query);
    }

    public function Eliminar($id)
    {
        $query = "UPDATE tbl_facturas SET Eliminado='S' WHERE IdFactura='" . $id . "'";
        return $this->EjecutarQuery($query);
    }
}
