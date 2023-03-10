<?php
class Empleados extends DB
{
    public $NombreEmpleado;
    public $Contrasenna;
    public $Email;
    public $UrlFoto;
    public $IdRole;

    public function listarTodo()
    {
        $query = "SELECT * FROM vta_listar_empleados";
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

    public function Insertar()
    {
        $query = "INSERT INTO tbl_empleados(
            NombreEmpleado,
            Contrasenna,
            Email,
            UrlFoto,
            IdRole,
            Eliminado )
            VALUES (
            '" . $this->NombreEmpleado . "',
            '" . password_hash($this->Contrasenna, PASSWORD_DEFAULT) . "',
            '" . $this->Email . "',
            'dist/img/avatar.png',
            '" . $this->IdRole . "',
            'N' ) ";
        return $this->EjecutarQuery($query);
    }

    public function Actualizar($id)
    {
        $query = "UPDATE tbl_empleados SET 
        NombreEmpleado = '" . $this->NombreEmpleado . "',
        Contrasenna = '" . password_hash($this->Contrasenna, PASSWORD_DEFAULT) . "',
        Email = '" . $this->Email . "',
        UrlFoto = '" . $this->UrlFoto . "',
        IdRole = '" . $this->IdRole . "' 
        WHERE IdEmpleado='" . $id . "' ";

        return $this->EjecutarQuery($query);
    }

    public function Eliminar($id)
    {
        $query = "UPDATE tbl_empleados SET Eliminado='S' WHERE IdEmpleado='" . $id . "'";
        return $this->EjecutarQuery($query);
    }
}
