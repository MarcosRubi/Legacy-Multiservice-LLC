<?php
class Boletos extends DB
{
    public $IdCliente;
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

    public function buscarPorId($id)
    {
        $query = "SELECT * FROM vta_listar_boletos WHERE IdBoleto='" . $id . "'";
        return $this->EjecutarQuery($query);
    }

    public function Insertar()
    {
        $query = "INSERT INTO tbl_Boletos(
            IdCliente,
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
        // return $this->EjecutarQuery($query);
        return $query;
    }

    public function Actualizar($id)
    {
        $query = "UPDATE tbl_boletos SET 
        IdCliente = '" . $this->IdCliente . "',
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
}
