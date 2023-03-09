<?php
class Clientes extends DB
{
    public $PrimerNombre;
    public $SegundoNombre;
    public $Apellido;
    public $Telefono;
    public $Direccion;
    public $FechaNacimiento;


    public function listarTodo()
    {
        $query = "SELECT * FROM vta_listar_clientes";
        return $this->EjecutarQuery($query);
    }

    public function buscarPorId($id)
    {
        $query = "SELECT * FROM tbl_clientes WHERE IdCliente='" . $id . "'";
        return $this->EjecutarQuery($query);
    }

    public function buscarCliente($content)
    {
        $query = "SELECT * FROM tbl_clientes WHERE 
        IdCliente LIKE'%" . $content . "%' OR 
        PrimerNombre LIKE'%" . $content . "%' OR 
        SegundoNombre LIKE'%" . $content . "%' OR 
        Apellido LIKE'%" . $content . "%' OR 
        Telefono LIKE'%" . $content . "%' OR 
        Direccion LIKE'%" . $content . "%' OR 
        FechaNacimiento LIKE'%" . $content . "%'";
        return $this->EjecutarQuery($query);
    }

    public function Insertar()
    {
        $query = "INSERT INTO tbl_clientes(
            PrimerNombre,
            SegundoNombre,
            Apellido,
            Telefono,
            Direccion,
            FechaNacimiento,
            Eliminado )
            VALUES (
            '" . $this->PrimerNombre . "',
            '" . $this->SegundoNombre . "',
            '" . $this->Apellido . "',
            '" . $this->Telefono . "',
            '" . $this->Direccion . "',
            '" . $this->FechaNacimiento . "',
            'N' ) ";
        return $this->EjecutarQuery($query);
    }

    public function Actualizar($id)
    {
        $query = "UPDATE tbl_clientes SET 
        PrimerNombre = '" . $this->PrimerNombre . "',
        SegundoNombre = '" . $this->SegundoNombre . "',
        Apellido = '" . $this->Apellido . "',
        Telefono = '" . $this->Telefono . "' 
        Direccion = '" . $this->Direccion . "' 
        FechaNacimiento = '" . $this->FechaNacimiento . "' 
        WHERE IdCliente='" . $id . "' ";

        return $this->EjecutarQuery($query);
    }

    public function Eliminar($id)
    {
        $query = "UPDATE tbl_clientes SET Eliminado='S' WHERE IdCliente='" . $id . "'";
        return $this->EjecutarQuery($query);
    }
}
