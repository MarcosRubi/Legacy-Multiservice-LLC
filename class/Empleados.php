<?php
class Empleados extends DB
{
    public $NombreEmpleado;
    public $Contrasenna;
    public $Email;
    public $UrlFoto;
    public $IdRole;
    public $Agencia;
    public $Agente;
    public $FormatoFecha;

    public function listarTodo()
    {
        $query = "SELECT * FROM vta_listar_empleados";
        return $this->EjecutarQuery($query);
    }
    public function listarRoles()
    {
        $query = "SELECT * FROM vta_listar_roles";
        return $this->EjecutarQuery($query);
    }

    public function buscarPorId($id)
    {
        $query = "SELECT * FROM vta_listar_empleados WHERE IdEmpleado='" . $id . "'";
        return $this->EjecutarQuery($query);
    }

    public function buscarEmpleado()
    {
        $query = "SELECT * FROM vta_empleado WHERE Email='" . $this->Email . "' ";
        return $this->EjecutarQuery($query);
    }

    public function obtenerEmpleadoCreado()
    {
        $query = "SELECT * FROM vta_listar_empleados ORDER BY IdEmpleado desc LIMIT 1";
        return $this->EjecutarQuery($query);
    }

    public function Insertar()
    {
        $query = "INSERT INTO tbl_empleados(
            NombreEmpleado,
            Contrasenna,
            Email,
            UrlFoto,
            IdRole,
            Agencia,
            Agente,
            FormatoFecha,
            Eliminado )
            VALUES (
            '" . $this->NombreEmpleado . "',
            '" . password_hash($this->Contrasenna, PASSWORD_DEFAULT) . "',
            '" . $this->Email . "',
            '" . $this->UrlFoto . "',
            '" . $this->IdRole . "',
            '" . $this->Agencia . "',
            '" . $this->Agente . "',
            '" . $this->FormatoFecha . "',
            'N' ) ";
        return $this->EjecutarQuery($query);
    }

    public function Actualizar($id)
    {
        $query = "UPDATE tbl_empleados SET 
        NombreEmpleado = '" . $this->NombreEmpleado . "',
        Email = '" . $this->Email . "',
        UrlFoto = '" . $this->UrlFoto . "',
        Agencia = '" . $this->Agencia . "',
        Agente = '" . $this->Agente . "',
        FormatoFecha = '" . $this->FormatoFecha . "',
        IdRole = '" . $this->IdRole . "' 
        WHERE IdEmpleado='" . $id . "' ";

        return $this->EjecutarQuery($query);
    }

    public function Eliminar($id)
    {
        $query = "UPDATE tbl_empleados SET Eliminado='S' WHERE IdEmpleado='" . $id . "'";
        return $this->EjecutarQuery($query);
    }

    public function ListarEmpleados()
    {
        $query = "SELECT IdEmpleado, NombreEmpleado, Agente FROM tbl_empleados WHERE Eliminado='N'";
        return $this->EjecutarQuery($query);
    }
}
