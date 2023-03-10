<?php
class Ajustes
{

    public function FechaInvertir($fecha)
    {
        return implode('-', array_reverse(explode('-', $fecha)));
    }
    public function RemoverEtiquetas($content)
    {
        return strip_tags($content);
    }

}
