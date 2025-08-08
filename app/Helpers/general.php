<?php

use Illuminate\Support\Facades\DB;

if (!function_exists('get_option')) {
    function get_option($name)
    {
        $setting = DB::table('settings')->where('name', $name)->get();
        if (!$setting->isEmpty()) {
            return $setting[0]->value;
        }
        return "";
    }
}
if (!function_exists('whatsapp_link')) {
    function whatsapp_link()
    {
        return preg_replace('/[^a-zA-Z0-9\s]/', '',  get_option('whatsapp'));
    }
}
if (!function_exists('dataFormatada')) {
    function dataFormatada()
    {
        // Array com os nomes dos meses em português em maiúsculas
        $meses = array(
            1 => 'JANEIRO',
            2 => 'FEVEREIRO',
            3 => 'MARÇO',
            4 => 'ABRIL',
            5 => 'MAIO',
            6 => 'JUNHO',
            7 => 'JULHO',
            8 => 'AGOSTO',
            9 => 'SETEMBRO',
            10 => 'OUTUBRO',
            11 => 'NOVEMBRO',
            12 => 'DEZEMBRO'
        );

        // Obtém a data atual
        $dia = date('d');
        $mes = date('n');
        $ano = date('Y');

        // Formata a string conforme solicitado
        $dataFormatada = "<span>$dia</span> de <span>{$meses[$mes]}</span> de <span>$ano</span>";

        return $dataFormatada;
    }
}
