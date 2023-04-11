<?php
date_default_timezone_set('America/El_Salvador');

class Cotizaciones extends DB
{
    public $IdCliente;
    public $Pnr;
    public $Comentario;
    public $Accion;
    public $Fecha;
    public $Agencia;
    public $Agente;
    public $Origen;
    public $Destino;
    public $Ida;
    public $Regreso;
    public $NumeroBoletos;
    public $Cotizado;
    public $Max;
    public $Creado;
    public $CreadoTimestamp;

    public function listarTodo()
    {
        $query = "SELECT * FROM vta_listar_cotizaciones";
        return $this->EjecutarQuery($query);
    }

    public function buscarPorClienteId($id)
    {
        $query = "SELECT * FROM vta_listar_cotizaciones WHERE IdCliente='" . $id . "'";
        return $this->EjecutarQuery($query);
    }

    public function buscarPorId($id)
    {
        $query = "SELECT * FROM vta_listar_cotizaciones WHERE IdCotizacion='" . $id . "'";
        return $this->EjecutarQuery($query);
    }

    public function obtenerCotizacionCreada()
    {
        $query = "SELECT * FROM vta_listar_cotizaciones ORDER BY IdCotizacion desc LIMIT 1";
        return $this->EjecutarQuery($query);
    }

    public function Insertar()
    {
        $query = "INSERT INTO tbl_cotizaciones(
            IdCliente,
            Pnr,
            Comentario,
            Accion,
            Fecha,
            Agencia,
            Agente,
            Origen,
            Destino,
            Ida,
            Regreso,
            NumeroBoletos,
            Cotizado,
            Max,
            Creado,
            CreadoTimestamp,
            Eliminado )
            VALUES (
            '" . $this->IdCliente . "',
            '" . $this->Pnr . "',
            '" . $this->Comentario . "',
            '" . $this->Accion . "',
            '" . $this->Fecha . "',
            '" . $this->Agencia . "',
            '" . $this->Agente . "',
            '" . $this->Origen . "',
            '" . $this->Destino . "',
            '" . $this->Ida . "',
            '" . $this->Regreso . "',
            '" . $this->NumeroBoletos . "',
            '" . $this->Cotizado . "',
            '" . $this->Max . "',
            '" . date("Y-m-d h:i:s ") . "',
            '" . date("A") . "',
            'N' ) ";
        return $this->EjecutarQuery($query);
    }

    public function Actualizar($id)
    {
        $query = "UPDATE tbl_cotizaciones SET 
        IdCliente = '" . $this->IdCliente . "',
        Pnr = '" . $this->Pnr . "',
        Comentario = '" . $this->Comentario . "',
        Accion = '" . $this->Accion . "',
        Fecha = '" . $this->Fecha . "', 
        Agencia = '" . $this->Agencia . "', 
        Agente = '" . $this->Agente . "', 
        Origen = '" . $this->Origen . "', 
        Destino = '" . $this->Destino . "', 
        Ida = '" . $this->Ida . "', 
        Regreso = '" . $this->Regreso . "', 
        NumeroBoletos = '" . $this->NumeroBoletos . "', 
        Cotizado = '" . $this->Cotizado . "', 
        Max = '" . $this->Max . "' 
        WHERE IdCotizacion='" . $id . "' ";

        return $this->EjecutarQuery($query);
    }

    public function Eliminar($id)
    {
        $query = "UPDATE tbl_cotizaciones SET Eliminado='S' WHERE IdCotizacion='" . $id . "'";
        return $this->EjecutarQuery($query);
    }

    public function cantidadContizacionesPorMes()
    {
        $query = "SELECT COUNT(IdCotizacion) AS TotalCotizaciones
        FROM tbl_cotizaciones
        WHERE Eliminado = 'N'
        AND YEAR(Creado) = YEAR(CURRENT_DATE())
        AND MONTH(Creado) = MONTH(CURRENT_DATE())";
        return $this->EjecutarQuery($query);
    }

    public function cantidadCotizacionesPorEmpleadoMesActual($agente)
    {
        $query = "SELECT COUNT(IdCotizacion) AS total_cotizaciones
        FROM tbl_cotizaciones
        WHERE Eliminado = 'N'
        AND YEAR(Creado) = YEAR(CURRENT_DATE())
        AND MONTH(Creado) = MONTH(CURRENT_DATE()) 
        AND Agente='".$agente."' " ;
        return $this->EjecutarQuery($query);
    }

    public function cantidadCotizacionesPorEmpleadoAnioActual($agente)
    {
        $query = "SELECT YEAR( Creado ) AS Anio,
        MONTH ( Creado ) AS Mes,
        COUNT(IdCotizacion) AS total_cotizaciones 
        FROM tbl_cotizaciones
        WHERE
        Creado BETWEEN '" . date("Y-01-01") . "' AND '" . date("Y-12-31") . "' 
            AND Eliminado='N'
            AND Agente = '" . $agente . "'
        GROUP BY
            YEAR ( Creado ),
            MONTH (
            Creado)";
        return $this->EjecutarQuery($query);
    }


    public function cantidadCotizacionesPorEmpleadoSemanaActual($agente)
    {
        $query = "SELECT YEAR(Creado) AS Anio,
        MONTH(Creado) AS Mes,
        WEEK(Creado) AS Semana,
        DAYOFWEEK(Creado) AS DiaSemana,
        COUNT(IdCotizacion) AS total_cotizaciones 
        FROM tbl_cotizaciones
        WHERE YEAR(Creado) = YEAR(CURRENT_DATE())
        AND MONTH(Creado) = MONTH(CURRENT_DATE())
        AND WEEK(Creado) = WEEK(CURRENT_DATE())
        AND Agente = '" . $agente . "'
        AND Eliminado='N'
        GROUP BY YEAR(Creado), MONTH(Creado), WEEK(Creado), DAYOFWEEK(Creado)";
        return $this->EjecutarQuery($query);
    }

    public function cantidadCotizacionesPorEmpleadoDiaActual($agente)
    {
        $query = "SELECT COUNT(IdCotizacion) AS total_cotizaciones 
        FROM tbl_cotizaciones 
        WHERE Agente = '" . $agente . "' AND DATE(Creado) = CURRENT_DATE();";
        return $this->EjecutarQuery($query);
    }
}
