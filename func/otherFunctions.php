<?php
/* 
 * CONFIGURAÇÕES
 * Todas as configurações do arquivo "otherFunctions.php"
 * Copyright (c) 2007 CompanyServices
 * Todos os direitos reservados a GLOBAL TEC Informática
 * Desenvolvido por GLOBAL TEC Informática
 */

// Anti SQL Injection.
function AntiSQLInjection($string) {
    $a = '"!#&*()+={[}]/?;\\\'<>'; // Substituir isto
    $b = '                      '; // Por isto
    $string = strtr($string, $a, $b);
    $string = strip_tags(trim($string));
    return $string;
    // Recupere o campo desta forma -> AntiSQLInjection($_POST['campo']);
}

// Slug
function slug($string) {
    $a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]/?;:.,\\\'<>';
    $b = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                              ';
    $string = utf8_decode($string);
    $string = strtr($string, utf8_decode($a), $b);
    $string = strip_tags(trim($string));
    $string = str_replace(" ", "-", $string);
    $string = str_replace(array('-----', '----', '---', '--'), '-', $string);
    return strtolower(utf8_encode($string));
    // Exemplo: echo slug($string);
}

// Encurtar texto por palavras
function shortenTextByWords($string, $amount) {
    $text = strip_tags($string);
    if (strlen($text) > $amount) {
        // Limitando string
        $textCut = substr($text, 0, $amount);
        // certifique-se que termina em uma palavra...
	$text = "<span title=\"{$string}\">" . substr($textCut, 0, strrpos($textCut, ' ')) . "...</span>"; 
    }
    return $text;
    // Exemplo: shortenTextByWords($string, 50);
}

// Converter datas [aaaa-mm-dd] para [dd/mm/aaaa] ou [dd/mm/yyyy] para [yyyy-mm-dd]
function reverseDate($date) {
    if (count(explode("/",$date)) > 1):
        return implode("-",array_reverse(explode("/",$date)));
    elseif (count(explode("-",$date)) > 1):
        return implode("/",array_reverse(explode("-",$date)));
    endif;
    // Exemplo 1: echo reverseDate("2017-05-14"); // Result: 14/05/2017
    // Exemplo 2: echo reverseDate("14/05/2017"); // Result: 2017-05-14
}

// Obter os dados de uma tabela a partir do ID
function table($table, $column, $condition) {
    $Read = new Read; // Consultar

    // Selecionar e recuperar os dados do usuário no sistema
    $Read->ExeRead($table, $condition);
    foreach ($Read->getResult() as $tableDB): endforeach;

    // Impressão dos dados
    if (!empty($tableDB[$column])):
        return $tableDB[$column];
    else:
        return "-";
    endif;
    // Recupere os desta forma -> table($table, "coluna", "WHERE id = '{$id}'");
}

// Somar os valores de uma coluna de uma tabela
function columnValues($table, $column, $where) {
    $Read = new Read; // Consultar
    // Selecionar e recuperar os dados da "tabela" especificada.
    $Read->FullRead("SELECT SUM($column) AS sum FROM {$table} {$where}");
    foreach ($Read->getResult() as $count): endforeach;
    $totalValueInBag = $count['sum'];
    
    return $totalValueInBag;
    // Exemplo: columnValues("table", "coluna_valor", "condition")
}

// Classificação por estrelas
function starRating($string) {
    switch ($string) {
        case "0.5": return "<i class='fas fa-star-half starRating' aria-hidden='true'></i>"; break;
        case "1.0": return "<i class='fas fa-star starRating' aria-hidden='true'></i>"; break;
        case "1.5": return "<i class='fas fa-star starRating' aria-hidden='true'></i><i class='fas fa-star-half starRating' aria-hidden='true'></i>"; break;
        case "2.0": return "<i class='fas fa-star starRating' aria-hidden='true'></i><i class='fas fa-star starRating' aria-hidden='true'></i>"; break;
        case "2.5": return "<i class='fas fa-star starRating' aria-hidden='true'></i><i class='fas fa-star starRating' aria-hidden='true'></i><i class='fas fa-star-half starRating' aria-hidden='true'></i>"; break;
        case "3.0": return "<i class='fas fa-star starRating' aria-hidden='true'></i><i class='fas fa-star starRating' aria-hidden='true'></i><i class='fas fa-star starRating' aria-hidden='true'></i>"; break;
        case "3.5": return "<i class='fas fa-star starRating' aria-hidden='true'></i><i class='fas fa-star starRating' aria-hidden='true'></i><i class='fas fa-star starRating' aria-hidden='true'></i><i class='fas fa-star-half starRating' aria-hidden='true'></i>"; break;
        case "4.0": return "<i class='fas fa-star starRating' aria-hidden='true'></i><i class='fas fa-star starRating' aria-hidden='true'></i><i class='fas fa-star starRating' aria-hidden='true'></i><i class='fas fa-star starRating' aria-hidden='true'></i>"; break;
        case "4.5": return "<i class='fas fa-star starRating' aria-hidden='true'></i><i class='fas fa-star starRating' aria-hidden='true'></i><i class='fas fa-star starRating' aria-hidden='true'></i><i class='fas fa-star starRating' aria-hidden='true'></i><i class='fas fa-star-half starRating' aria-hidden='true'></i>"; break;
        case "5.0": return "<i class='fas fa-star starRating' aria-hidden='true'></i><i class='fas fa-star starRating' aria-hidden='true'></i><i class='fas fa-star starRating' aria-hidden='true'></i><i class='fas fa-star starRating' aria-hidden='true'></i><i class='fas fa-star starRating' aria-hidden='true'></i>"; break;
    }
    // Exemplo: starRating($string)
}

