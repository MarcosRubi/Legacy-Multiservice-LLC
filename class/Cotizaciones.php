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

    public function listarTodo()
    {
        $query = "SELECT * FROM vta_listar_cotizaciones";
        return $this->EjecutarQuery($query);
    }

    public function buscarPorId($id)
    {
        $query = "SELECT * FROM vta_listar_cotizaciones WHERE IdCotizacion='" . $id . "'";
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
            '" . date("Y-m-d h:i:s") . "',
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
}
