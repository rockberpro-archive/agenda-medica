<?php 

class DataHora {

    public static function dataHoraAtual() : DateTime {
        $data_hora = new DateTime();
        $data_hora->setTimezone(new DateTimeZone('America/Sao_Paulo'));
        
        return $data_hora;
    }

    public static function dataHoraAtualString() : string {
        $data_hora = new DateTime();
        $data_hora->setTimezone(new DateTimeZone('America/Sao_Paulo'));
        
        return date_format($data_hora, 'Y-m-d H:i:s');
    }

}