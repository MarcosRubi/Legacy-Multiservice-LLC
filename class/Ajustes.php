<?php
class Ajustes
{
    
    public function FechaInvertir($fecha)
    {
        if($_SESSION['FormatoFecha'] === 'mdy'){
            $fechaOrdenar = explode('-' , $fecha);
            $fechaOrdenada = $fechaOrdenar[1] . "-" . $fechaOrdenar[2] . "-" . $fechaOrdenar[0];
            return $fechaOrdenada;
        }
        if($_SESSION['FormatoFecha'] === 'dmy'){
            return implode('-', array_reverse(explode('-', $fecha)));
        }
    }
    
    public function FechaInvertirGuardar($fecha)
    {
        if($_SESSION['FormatoFecha'] === 'mdy'){
            $fechaOrdenar = explode('-' , $fecha);
            $fechaOrdenada = $fechaOrdenar[2] . "-" . $fechaOrdenar[0] . "-" . $fechaOrdenar[1];
            return $fechaOrdenada;
        }
        if($_SESSION['FormatoFecha'] === 'dmy'){
            return implode('-', array_reverse(explode('-', $fecha)));
        }
    }

    public function RemoverEtiquetas($content)
    {
        return strip_tags(trim($content));
    }
    
    public function FormatoDinero($content){
        setlocale(LC_MONETARY, 'en_US');
        if($content === ''){
            return "$0.0";
        }
        return "$".number_format($content, 2);
    }

    public function ConvertirFormatoDolar($valor){
        if($valor === ''){
            return 0.0;
        }
        return doubleval($valor);
    }

}
