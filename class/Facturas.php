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
    public function buscarFactura($id)
    {
        $query = "SELECT * FROM vta_listar_facturas WHERE IdFactura='" . $id . "'";
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

    public function obtenerFacturaCreada()
    {
        $query = "SELECT * FROM vta_listar_facturas ORDER BY IdFactura desc LIMIT 1";
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
            '" . ((doubleval($this->Efectivo) + doubleval($this->CreditoValor) + doubleval($this->Cheque) + doubleval($this->Cupon) + doubleval($this->Banco)) - doubleval($this->Valor)) . "',
            '" . $this->Comentario . "',
            '" . date("Y-m-d h:i:s ") . "',
            '" . date("A") . "',
            '" . ((doubleval($this->Efectivo) + doubleval($this->CreditoValor) + doubleval($this->Cheque) + doubleval($this->Cupon) + doubleval($this->Banco)) - doubleval($this->Valor)) . "',
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

    public function obtenerTotalesPorMesFacturas()
    {
        $query = "SELECT YEAR( Creado ) AS Anio,
        MONTH ( Creado ) AS Mes,
        SUM( Valor ) AS Total,
        SUM( Balance ) AS Balance 
        FROM
            tbl_facturas 
        WHERE
            Creado BETWEEN '2023-01-01' AND '2023-12-31' 
        GROUP BY
            YEAR ( Creado ),
            MONTH (
            Creado)";
        return $this->EjecutarQuery($query);
    }

    public function obtenerTotalesDelMesActual()
    {
        $query = "SELECT YEAR(Creado) AS Anio,
            MONTH(Creado) AS Mes,
        WEEK(Creado) AS Semana,
            SUM(Valor) AS Total,
            SUM(Balance) AS Balance
        FROM tbl_facturas
        WHERE YEAR(Creado) = YEAR(CURRENT_DATE())
        AND MONTH(Creado) = MONTH(CURRENT_DATE())
        GROUP BY YEAR(Creado), MONTH(Creado), WEEK(Creado)";
        return $this->EjecutarQuery($query);
    }

    public function obtenerTotalesPorSemana()
    {
        $query = "SELECT YEAR(Creado) AS Anio,
        MONTH(Creado) AS Mes,
        WEEK(Creado) AS Semana,
        DAYOFWEEK(Creado) AS DiaSemana,
        SUM(Valor) AS Total,
        SUM(Balance) AS Balance
        FROM tbl_facturas
        WHERE YEAR(Creado) = YEAR(CURRENT_DATE())
        AND MONTH(Creado) = MONTH(CURRENT_DATE())
        AND WEEK(Creado) = WEEK(CURRENT_DATE())
        GROUP BY YEAR(Creado), MONTH(Creado), WEEK(Creado), DAYOFWEEK(Creado)";
        return $this->EjecutarQuery($query);
    }

    public function obtenerTotalesDiaActual()
    {
        $query = "SELECT Anio, Mes, Dia, 
        CASE 
            WHEN Hora >= 18 THEN '19:00-23:59'
            ELSE CONCAT(Hora, ':00-', Hora, ':59')
        END AS Hora_Rango,
        SUM(Total) AS Total,
        SUM(Balance) AS Balance
        FROM (
            SELECT YEAR(Creado) AS Anio,
                MONTH(Creado) AS Mes,
                DAY(Creado) AS Dia,
                HOUR(Creado) AS Hora,
                SUM(Valor) AS Total,
                SUM(Balance) AS Balance
            FROM tbl_facturas
            WHERE DATE(Creado) = CURDATE()
            GROUP BY YEAR(Creado), MONTH(Creado), DAY(Creado), HOUR(Creado)
        ) AS subconsulta
        GROUP BY Anio, Mes, Dia, Hora_Rango";

        return $this->EjecutarQuery($query);
    }

    public function cantidadFacturasPorEmpleado($Agente)
    {
        $query = "SELECT COUNT(IdFactura) AS total_facturas 
        FROM tbl_facturas
        WHERE Agente = '" . $Agente . "' AND DATE(Creado) = CURRENT_DATE() AND Eliminado = 'N'";
        return $this->EjecutarQuery($query);
    }
}
