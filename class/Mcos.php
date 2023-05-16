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
        return $query;
    }

    public function Actualizar($id)
    {
        $query = "UPDATE tbl_mcos 
        SET NumeroMco = '" . $this->NumeroMco . "',
        Valor = '" . $this->Valor . "',
        IdIata = '" . $this->IdIata . "',
        IdFormaPago = '" . $this->IdFormaPago . "',
        Comision = '" . $this->Comision . "',
        GananciaNeta = '" . $this->GananciaNeta . "' 
        WHERE IdMco = '" . $id . "'";

        return $this->EjecutarQuery($query);
    }

    public function Eliminar($id)
    {
        $query = "UPDATE tbl_mcos SET Eliminado='S' WHERE IdMco='" . $id . "'";
        return $this->EjecutarQuery($query);
    }

    // PARA GRAFICA GENERAL

    public function obtenerIngresosFechaPersonalizada($fechaInicio, $fechaFin)
    {
        $query = "SELECT 
        COALESCE(SUM(GananciaNeta), 0) AS Total
        FROM
            tbl_mcos 
        WHERE
            Creado BETWEEN '" . $fechaInicio . "' AND '" . $fechaFin . "' 
            AND Eliminado='N'";
        return $this->EjecutarQuery($query);
    }

    public function obtenerIngresosPorMesMcos()
    {
        $query = "SELECT YEAR( Creado ) AS Anio,
        MONTH ( Creado ) AS Mes,
        SUM( GananciaNeta ) AS Total 
        FROM
            tbl_mcos 
        WHERE
            Creado BETWEEN '" . date("Y-01-01") . "' AND '" . date("Y-12-31") . "' 
            AND Eliminado='N'
        GROUP BY
            YEAR ( Creado ),
            MONTH (
            Creado)";
        return $this->EjecutarQuery($query);
    }

    public function obtenerIngresosDelMesActual()
    {
        $query = "SELECT YEAR(Creado) AS Anio,
            MONTH(Creado) AS Mes,
        WEEK(Creado) AS Semana,
            SUM(GananciaNeta) AS Total 
        FROM tbl_mcos
        WHERE YEAR(Creado) = YEAR(CURRENT_DATE())
        AND MONTH(Creado) = MONTH(CURRENT_DATE())
        AND Eliminado='N'
        GROUP BY YEAR(Creado), MONTH(Creado), WEEK(Creado)";
        return $this->EjecutarQuery($query);
    }

    public function obtenerIngresosPorSemanaActual()
    {
        $query = "SELECT YEAR(Creado) AS Anio,
        MONTH(Creado) AS Mes,
        WEEK(Creado) AS Semana,
        DAYOFWEEK(Creado) AS DiaSemana,
        COUNT(GananciaNeta) AS total_mcos 
        FROM tbl_mcos
        WHERE YEAR(Creado) = YEAR(CURRENT_DATE())
        AND MONTH(Creado) = MONTH(CURRENT_DATE())
        AND WEEK(Creado) = WEEK(CURRENT_DATE())
        AND Eliminado='N'";
        return $this->EjecutarQuery($query);
    }

    public function obtenerIngresosDiaActual()
    {
        $query = "SELECT Anio, Mes, Dia, 
        CASE 
            WHEN Hora >= 18 THEN '19:00-23:59'
            ELSE CONCAT(Hora, ':00-', Hora, ':59')
        END AS Hora_Rango,
        SUM(Total) AS Total 
        FROM (
            SELECT YEAR(Creado) AS Anio,
                MONTH(Creado) AS Mes,
                DAY(Creado) AS Dia,
                HOUR(Creado) AS Hora,
                SUM(Valor) AS Total 
            FROM tbl_mcos
            WHERE DATE(Creado) = CURDATE() AND Eliminado='N'
            GROUP BY YEAR(Creado), MONTH(Creado), DAY(Creado), HOUR(Creado)
        ) AS subconsulta
        GROUP BY Anio, Mes, Dia, Hora_Rango";

        return $this->EjecutarQuery($query);
    }
}
