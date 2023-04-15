<?php
date_default_timezone_set('America/El_Salvador');

class Boletos extends DB
{
    public $IdCliente;
    public $Pnr;
    public $NumeroBoletos;
    public $NombrePasajero;
    public $Aerolinea;
    public $Origen;
    public $Destino;
    public $FechaIda;
    public $FechaRegreso;
    public $IdIata;
    public $IdTipo;
    public $IdFormaPago;
    public $Precio;
    public $Base;
    public $Tax;
    public $Fm;
    public $Fee;
    public $Itinerario;
    public $Dob;
    public $Agencia;
    public $Agente;

    public function listarTodo()
    {
        $query = "SELECT * FROM vta_listar_boletos";
        return $this->EjecutarQuery($query);
    }

    public function buscarPorClienteId($id)
    {
        $query = "SELECT * FROM vta_listar_boletos WHERE IdCliente='" . $id . "'";
        return $this->EjecutarQuery($query);
    }
    public function buscarNombreClientePorId($id)
    {
        $query = "SELECT PrimerNombre, SegundoNombre, Apellido FROM vta_listar_clientes WHERE IdCliente='" . $id . "'";
        return $this->EjecutarQuery($query);
    }

    public function buscarPorId($id)
    {
        $query = "SELECT * FROM vta_listar_boletos WHERE IdBoleto='" . $id . "'";
        return $this->EjecutarQuery($query);
    }

    public function buscarPorPnr($idCliente, $pnr)
    {
        $query = "SELECT * FROM vta_listar_boletos WHERE IdCliente='" . $idCliente . "' AND Pnr='".$pnr."'";
        return $this->EjecutarQuery($query);
    }

    public function obtenerBoletoCreado($id)
    {
        $query = "SELECT * FROM vta_listar_boletos WHERE IdCliente='" . $id . "'" . " ORDER BY IdBoleto desc LIMIT 1";
        return $this->EjecutarQuery($query);
    }

    public function Insertar()
    {
        $query = "INSERT INTO tbl_boletos(
            IdCliente,
            Pnr,
            NumeroBoletos,
            NombrePasajero,
            Aerolinea,
            Origen,
            Destino,
            FechaIda,
            FechaRegreso,
            IdIata,
            IdTipo,
            IdFormaPago,
            Precio,
            Base,
            Tax,
            Fm,
            Fee,
            Itinerario,
            Dob,
            Agencia,
            Agente,
            Creado,
            CreadoTimestamp
            Eliminado )
            VALUES (
            '" . $this->IdCliente . "',
            '" . $this->Pnr . "',
            '" . $this->NumeroBoletos . "',
            '" . $this->NombrePasajero . "',
            '" . $this->Aerolinea . "',
            '" . $this->Origen . "',
            '" . $this->Destino . "',
            '" . $this->FechaIda . "',
            '" . $this->FechaRegreso . "',
            '" . $this->IdIata . "',
            '" . $this->IdTipo . "',
            '" . $this->IdFormaPago . "',
            '" . $this->Precio . "',
            '" . $this->Base . "',
            '" . $this->Tax . "',
            '" . $this->Fm . "',
            '" . $this->Fee . "',
            '" . $this->Itinerario . "',
            '" . $this->Dob . "',
            '" . $this->Agencia . "',
            '" . $this->Agente . "',
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
        $query = "INSERT INTO tbl_boletos(
            IdCliente,
            Pnr,
            NumeroBoletos,
            NombrePasajero,
            Aerolinea,
            Origen,
            Destino,
            FechaIda,
            FechaRegreso,
            IdIata,
            IdTipo,
            IdFormaPago,
            Precio,
            Base,
            Tax,
            Fm,
            Fee,
            Itinerario,
            Dob,
            Agencia,
            Agente,
            Eliminado )
            VALUES (
            '" . $this->IdCliente . "',
            '" . $this->Pnr . "',
            '" . $this->NumeroBoletos . "',
            '" . $this->NombrePasajero . "',
            '" . $this->Aerolinea . "',
            '" . $this->Origen . "',
            '" . $this->Destino . "',
            '" . $this->FechaIda . "',
            '" . $this->FechaRegreso . "',
            '" . $this->IdIata . "',
            '" . $this->IdTipo . "',
            '" . $this->IdFormaPago . "',
            '" . $this->Precio . "',
            '" . $this->Base . "',
            '" . $this->Tax . "',
            '" . $this->Fm . "',
            '" . $this->Fee . "',
            '" . $this->Itinerario . "',
            '" . $this->Dob . "',
            '" . $this->Agencia . "',
            '" . $this->Agente . "',
            'N' ) ";
        return $query;
    }

    public function Actualizar($id)
    {
        $query = "UPDATE tbl_boletos SET 
        IdCliente = '" . $this->IdCliente . "',
        Pnr = '" . $this->Pnr . "',
        NumeroBoletos = '" . $this->NumeroBoletos . "',
        NombrePasajero = '" . $this->NombrePasajero . "',
        Aerolinea = '" . $this->Aerolinea . "', 
        Origen = '" . $this->Origen . "', 
        Destino = '" . $this->Destino . "', 
        FechaIda = '" . $this->FechaIda . "', 
        FechaRegreso = '" . $this->FechaRegreso . "', 
        IdIata = '" . $this->IdIata . "', 
        IdTipo = '" . $this->IdTipo . "', 
        IdFormaPago = '" . $this->IdFormaPago . "', 
        Precio = '" . $this->Precio . "', 
        Base = '" . $this->Base . "' 
        Tax = '" . $this->Tax . "' 
        Fm = '" . $this->Fm . "' 
        Fee = '" . $this->Fee . "' 
        Itinerario = '" . $this->Itinerario . "' 
        Dob = '" . $this->Dob . "' 
        Agencia = '" . $this->Agencia . "' 
        Agente = '" . $this->Agente . "' 
        WHERE IdCotizacion='" . $id . "' ";

        return $this->EjecutarQuery($query);
    }

    public function Eliminar($id)
    {
        $query = "UPDATE tbl_boletos SET Eliminado='S' WHERE IdBoleto='" . $id . "'";
        return $this->EjecutarQuery($query);
    }

    public function valorTotalBoletos($idCliente, $pnr){
        $query = "SELECT SUM(vta_listar_boletos.Precio) AS 'Valor' FROM vta_listar_boletos WHERE IdCliente='".$idCliente."' AND Pnr='".$pnr."'";
        return $this->EjecutarQuery($query);
    }


    // PARA GRAFICA GENERAL
    
    public function cantidadBoletosPorAnioActual()
    {
        $query = "SELECT YEAR( Creado ) AS Anio,
        MONTH ( Creado ) AS Mes,
        COUNT(IdBoleto) AS total_boletos 
        FROM tbl_boletos
        WHERE
        Creado BETWEEN '" . date("Y-01-01") . "' AND '" . date("Y-12-31") . "' 
            AND Eliminado='N'";
        return $this->EjecutarQuery($query);
    }

    public function cantidadBoletosPorMesActual(){
        $query = "SELECT COUNT(IdBoleto) AS total_boletos
        FROM tbl_boletos
        WHERE Eliminado = 'N'
        AND YEAR(Creado) = YEAR(CURRENT_DATE())
        AND MONTH(Creado) = MONTH(CURRENT_DATE())";
        return $this->EjecutarQuery($query);
    }

    public function cantidadBoletosPorSemanaActual()
    {
        $query = "SELECT YEAR(Creado) AS Anio,
        MONTH(Creado) AS Mes,
        WEEK(Creado) AS Semana,
        DAYOFWEEK(Creado) AS DiaSemana,
        COUNT(IdBoleto) AS total_boletos 
        FROM tbl_boletos
        WHERE YEAR(Creado) = YEAR(CURRENT_DATE())
        AND MONTH(Creado) = MONTH(CURRENT_DATE())
        AND WEEK(Creado) = WEEK(CURRENT_DATE())
        AND Eliminado='N'";
        return $this->EjecutarQuery($query);
    }

    public function cantidadBoletosPorDiaActual()
    {
        $query = "SELECT COUNT(IdBoleto) AS total_boletos 
        FROM tbl_boletos 
        WHERE DATE(Creado) = CURRENT_DATE();";
        return $this->EjecutarQuery($query);
    }

    // PARA GRAFICA EN REPORTE DIARIO
    public function cantidadBoletosPorEmpleadoAnioActual($agente)
    {
        $query = "SELECT YEAR( Creado ) AS Anio,
        MONTH ( Creado ) AS Mes,
        COUNT(IdBoleto) AS total_boletos 
        FROM tbl_boletos
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

    public function cantidadBoletosPorEmpleadoMesActual($agente)
    {
        $query = "SELECT COUNT(IdBoleto) AS total_boletos
        FROM tbl_boletos
        WHERE Eliminado = 'N'
        AND YEAR(Creado) = YEAR(CURRENT_DATE())
        AND MONTH(Creado) = MONTH(CURRENT_DATE()) 
        AND Agente='".$agente."' " ;
        return $this->EjecutarQuery($query);
    }

    public function cantidadBoletosPorEmpleadoSemanaActual($agente)
    {
        $query = "SELECT YEAR(Creado) AS Anio,
        MONTH(Creado) AS Mes,
        WEEK(Creado) AS Semana,
        DAYOFWEEK(Creado) AS DiaSemana,
        COUNT(IdBoleto) AS total_boletos 
        FROM tbl_boletos
        WHERE YEAR(Creado) = YEAR(CURRENT_DATE())
        AND MONTH(Creado) = MONTH(CURRENT_DATE())
        AND WEEK(Creado) = WEEK(CURRENT_DATE())
        AND Agente = '" . $agente . "'
        AND Eliminado='N'
        GROUP BY YEAR(Creado), MONTH(Creado), WEEK(Creado), DAYOFWEEK(Creado)";
        return $this->EjecutarQuery($query);
    }

    public function cantidadBoletosPorEmpleadoDiaActual($agente)
    {
        $query = "SELECT COUNT(IdBoleto) AS total_boletos 
        FROM tbl_boletos 
        WHERE Agente = '".$agente."' AND DATE(Creado) = CURRENT_DATE() AND Eliminado='N';";
        return $this->EjecutarQuery($query);
    }
}
