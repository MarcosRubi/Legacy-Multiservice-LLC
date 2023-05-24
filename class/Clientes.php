<?php
date_default_timezone_set('America/El_Salvador');

class Clientes extends DB
{
    public $PrimerNombre;
    public $SegundoNombre;
    public $Apellido;
    public $Telefono;
    public $Cp;
    public $Ciudad;
    public $Provincia;
    public $Direccion;
    public $FechaNacimiento;
    public $IdEmpleado;
    public $Informacion;


    public function listarTodo()
    {
        $query = "SELECT * FROM vta_listar_clientes ORDER BY IdCliente DESC";
        return $this->EjecutarQuery($query);
    }

    public function buscarPorId($id)
    {
        $query = "SELECT * FROM tbl_clientes WHERE IdCliente='" . $id . "'";
        return $this->EjecutarQuery($query);
    }

    public function buscarCliente($content)
    {
        $query = "SELECT * FROM vta_listar_clientes WHERE 
        IdCliente LIKE'%" . $content . "%' OR 
        PrimerNombre LIKE'%" . $content . "%' OR 
        SegundoNombre LIKE'%" . $content . "%' OR 
        Apellido LIKE'%" . $content . "%' OR 
        Telefono LIKE'%" . $content . "%' OR 
        Cp LIKE'%" . $content . "%' OR 
        Ciudad LIKE'%" . $content . "%' OR 
        Provincia LIKE'%" . $content . "%' OR 
        Direccion LIKE'%" . $content . "%' OR 
        FechaNacimiento LIKE'%" . $content . "%'";
        return $this->EjecutarQuery($query);
    }

    public function obtenerClienteCreado()
    {
        $query = "SELECT * FROM vta_listar_clientes ORDER BY IdCliente desc LIMIT 1";
        return $this->EjecutarQuery($query);
    }

    public function Insertar()
    {
        $query = "INSERT INTO tbl_clientes(
            PrimerNombre,
            SegundoNombre,
            Apellido,
            Telefono,
            Cp,
            Ciudad,
            Provincia,
            Direccion,
            FechaNacimiento,
            IdEmpleado,
            Creado,
            CreadoTimestamp,
            Informacion,
            Eliminado )
            VALUES (
            '" . $this->PrimerNombre . "',
            '" . $this->SegundoNombre . "',
            '" . $this->Apellido . "',
            '" . $this->Telefono . "',
            '" . $this->Cp . "',
            '" . $this->Ciudad . "',
            '" . $this->Provincia . "',
            '" . $this->Direccion . "',
            '" . $this->FechaNacimiento . "',
            '" . $_SESSION['IdEmpleado'] . "',
            '" . date("Y-m-d h:i:s ") . "',
            '" . date("A") . "',
            '" . $this->Informacion . "',
            'N' ) ";
        return $this->EjecutarQuery($query);
    }

    public function Actualizar($id)
    {
        $query = "UPDATE tbl_clientes SET 
        PrimerNombre = '" . $this->PrimerNombre . "',
        SegundoNombre = '" . $this->SegundoNombre . "',
        Apellido = '" . $this->Apellido . "',
        Telefono = '" . $this->Telefono . "', 
        Cp = '" . $this->Cp . "', 
        Ciudad = '" . $this->Ciudad . "', 
        Provincia = '" . $this->Provincia . "', 
        Direccion = '" . $this->Direccion . "', 
        FechaNacimiento = '" . $this->FechaNacimiento . "' 
        WHERE IdCliente='" . $id . "' ";

        return $this->EjecutarQuery($query);
    }
    public function ActualizarInformacion($id)
    {
        $query = "UPDATE tbl_clientes SET 
        Informacion = '" . $this->Informacion . "'
        WHERE IdCliente='" . $id . "' ";

        return $this->EjecutarQuery($query);
    }

    public function Eliminar($id)
    {
        $query = "UPDATE tbl_clientes SET Eliminado='S' WHERE IdCliente='" . $id . "'";
        return $this->EjecutarQuery($query);
    }

    //PARA GRAFICO DE RESUMEN DE ESTADISTICAS
    public function cantidadClientesPorFechaPersonalizada($fechaInicio, $fechaFin)
    {
        $query = "SELECT COUNT(IdCliente) AS total_clientes 
        FROM tbl_clientes
        WHERE Creado BETWEEN '" . $fechaInicio . "' AND '" . $fechaFin . "' 
        AND Eliminado='N'";
        return $this->EjecutarQuery($query);
    }
    public function cantidadClientesPorAnioActual()
    {
        $query = "SELECT COUNT(IdCliente) AS total_clientes 
        FROM tbl_clientes
        WHERE Creado BETWEEN '" . date("Y-01-01") . "' AND '" . date("Y-12-31") . "' 
        AND Eliminado='N'";
        return $this->EjecutarQuery($query);
    }

    public function cantidadClientesPorMesActual()
    {
        $query = "SELECT COUNT(IdCliente) AS total_clientes
        FROM tbl_clientes
        WHERE Eliminado = 'N'
        AND YEAR(Creado) = YEAR(CURRENT_DATE())
        AND MONTH(Creado) = MONTH(CURRENT_DATE())";
        return $this->EjecutarQuery($query);
    }

    public function cantidadClientesPorSemanaActual()
    {
        $query = "SELECT IFNULL(COUNT(IdCliente), 0) AS total_clientes 
        FROM tbl_clientes
        WHERE YEAR(Creado) = YEAR(CURRENT_DATE())
        AND MONTH(Creado) = MONTH(CURRENT_DATE())
        AND WEEK(Creado) = WEEK(CURRENT_DATE())
        AND Eliminado='N'";
        return $this->EjecutarQuery($query);
    }

    public function cantidadClientesPorDiaActual()
    {
        $query = "SELECT COUNT(IdCliente) AS total_clientes 
        FROM tbl_clientes
        WHERE DATE(Creado) = CURRENT_DATE() AND Eliminado='N';";
        return $this->EjecutarQuery($query);
    }

    // PARA GRAFICOS DE REPORTE DIARIOS
    public function cantidadClientesPorEmpleadoPersonalizado($agente,  $fechaInicio, $fechaFin)
    {
        $query = "SELECT YEAR( Creado ) AS Anio,
        MONTH ( Creado ) AS Mes,
        COUNT(IdCliente) AS total_clientes 
        FROM vta_listar_clientes
        WHERE
        Creado BETWEEN '" . $fechaInicio . "' AND '" . $fechaFin . "' 
            AND Eliminado='N'
            AND Agente = '" . $agente . "'
        GROUP BY
            YEAR ( Creado ),
            MONTH (
            Creado)";
        return $this->EjecutarQuery($query);
    }
    public function cantidadClientesPorEmpleadoAnioActual($agente)
    {
        $query = "SELECT YEAR( Creado ) AS Anio,
        MONTH ( Creado ) AS Mes,
        COUNT(IdCliente) AS total_clientes 
        FROM vta_listar_clientes
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

    public function cantidadClientesPorEmpleadoMesActual($agente)
    {
        $query = "SELECT COUNT(IdCliente) AS total_clientes
        FROM vta_listar_clientes
        WHERE Eliminado = 'N'
        AND YEAR(Creado) = YEAR(CURRENT_DATE())
        AND MONTH(Creado) = MONTH(CURRENT_DATE()) 
        AND Agente='" . $agente . "' ";
        return $this->EjecutarQuery($query);
    }

    public function cantidadClientesPorEmpleadoSemanaActual($agente)
    {
        $query = "SELECT YEAR(Creado) AS Anio,
        MONTH(Creado) AS Mes,
        WEEK(Creado) AS Semana,
        DAYOFWEEK(Creado) AS DiaSemana,
        COUNT(IdCliente) AS total_clientes 
        FROM vta_listar_clientes
        WHERE YEAR(Creado) = YEAR(CURRENT_DATE())
        AND MONTH(Creado) = MONTH(CURRENT_DATE())
        AND WEEK(Creado) = WEEK(CURRENT_DATE())
        AND Agente = '" . $agente . "'
        AND Eliminado='N'
        GROUP BY YEAR(Creado), MONTH(Creado), WEEK(Creado), DAYOFWEEK(Creado)";
        return $this->EjecutarQuery($query);
    }

    public function cantidadClientesPorEmpleadoDiaActual($agente)
    {
        $query = "SELECT COUNT(IdCliente) AS total_clientes 
        FROM vta_listar_clientes
        WHERE Agente = '" . $agente . "' AND DATE(Creado) = CURRENT_DATE() AND Eliminado='N';";
        return $this->EjecutarQuery($query);
    }
}
