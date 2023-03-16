<?php
date_default_timezone_set('America/El_Salvador');

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
    public $Creado;
    public $CreadoTimestamp;
    public $Agencia;
    public $Agente;
    public $FormaPagoInicial;
    public $Pnr;


    public function listarTodo()
    {
        $query = "SELECT * FROM vta_listar_facturas ORDER BY IdFactura DESC";
        return $this->EjecutarQuery($query);
    }

    public function buscarPorId($id)
    {
        $query = "SELECT * FROM vta_listar_facturas WHERE IdCliente='" . $id . "'";
        return $this->EjecutarQuery($query);
    }
    public function buscarPorIdFactura($id)
    {
        $query = "SELECT IdCliente,Pnr FROM tbl_facturas WHERE IdFactura='" . $id . "'";
        return $this->EjecutarQuery($query);
    }
    public function obtenerValoresPagos($id)
    {
        $query = "SELECT Efectivo, CreditoValor, Cheque, Banco, Cupon FROM vta_listar_facturas WHERE IdFactura='" . $id . "'";
        return $this->EjecutarQuery($query);
    }
    public function obtenerBalanceFactura($id)
    {
        $query = "SELECT Balance FROM tbl_facturas WHERE IdFactura='" . $id . "' ";
        return $this->EjecutarQuery($query);
    }

    public function ValorTotalPorCliente($id)
    {
        $query = "SELECT SUM(vta_listar_facturas.Valor) AS ValorTotal FROM vta_listar_facturas WHERE IdCliente='" . $id . "'";
        return $this->EjecutarQuery($query);
    }
    public function ValorTotalPorFactura($id)
    {
        $query = "SELECT SUM(vta_listar_facturas.Valor) AS ValorTotal FROM vta_listar_facturas WHERE IdFactura='" . $id . "'";
        return $this->EjecutarQuery($query);
    }
    public function BalanceTotalPorCliente($id)
    {
        $query = "SELECT SUM(vta_listar_facturas.Balance) AS BalanceTotal FROM vta_listar_facturas WHERE IdCliente='" . $id . "'";
        return $this->EjecutarQuery($query);
    }

    public function Insertar()
    {
        $query = "INSERT INTO tbl_facturas(
            IdCliente,
            IdTipoFactura,
            Agencia,
            Agente,
            Valor,
            Descripcion,
            Efectivo,
            CreditoValor,
            CreditoNumero,
            Cheque,
            Banco,
            Cupon,
            Balance,
            Comentario,
            Creado,
            CreadoTimestamp,
            BalanceInicial,
            FormaPagoInicial,
            Pnr,
            Eliminado )
            VALUES (
            '" . $this->IdCliente . "',
            '" . $this->IdTipoFactura . "',
            '" . $this->Agencia . "',
            '" . $this->Agente . "',
            '" . $this->Valor . "',
            '" . $this->Descripcion . "',
            '" . $this->Efectivo . "',
            '" . $this->CreditoValor . "',
            '" . $this->CreditoNumero . "',
            '" . $this->Cheque . "',
            '" . $this->Banco . "',
            '" . $this->Cupon . "',
            '" . ((doubleval($this->Efectivo) + doubleval($this->CreditoValor) + doubleval($this->Cheque) + doubleval($this->Cupon)) - doubleval($this->Valor)) . "',
            '" . $this->Comentario . "',
            '" . date("Y-m-d h:i:s ") . "',
            '" . date("A") . "',
            '" . ((doubleval($this->Efectivo) + doubleval($this->CreditoValor) + doubleval($this->Cheque) + doubleval($this->Cupon)) - doubleval($this->Valor)) . "',
            '" . $this->FormaPagoInicial . "',
            '" . $this->Pnr . "',
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
        Agencia = '" . $this->Agencia . "' 
        Agente = '" . $this->Agente . "' 
        CreditoValor = '" . $this->CreditoValor . "' 
        CreditoNumero = '" . $this->CreditoNumero . "' 
        Cheque = '" . $this->Cheque . "' 
        Banco = '" . $this->Banco . "' 
        Cupon = '" . $this->Cupon . "' 
        Comentario = '" . $this->Comentario . "' 
        WHERE IdFactura='" . $id . "' ";

        return $this->EjecutarQuery($query);
    }

    public function ActualizarBalanceFactura($id, $balance)
    {
        $query = "UPDATE tbl_facturas SET 
        Balance = '" . $balance . "'
        WHERE IdFactura='" . $id . "' ";

        return $this->EjecutarQuery($query);
    }
    public function ActualizarValoresPago($id)
    {
        $query = "UPDATE tbl_facturas SET 
        Efectivo = '" . $this->Efectivo . "',
        CreditoValor = '" . $this->CreditoValor . "',
        Cheque = '" . $this->Cheque . "',
        Banco = '" . $this->Banco . "',
        Cupon = '" . $this->Cupon . "'
        WHERE IdFactura='" . $id . "' ";

        return $this->EjecutarQuery($query);
    }

    public function Eliminar($id)
    {
        $query = "UPDATE tbl_facturas SET Eliminado='S' WHERE IdFactura='" . $id . "'";
        return $this->EjecutarQuery($query);
    }

}
