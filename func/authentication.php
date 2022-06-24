<?php
/*
 * CONFIGURAÇÕES
 * Todas as configurações do arquivo "authentication.php"
 * Copyright (c) 2007 CompanyServices
 * Todos os direitos reservados a GLOBAL TEC Informática
 * Desenvolvido por GLOBAL TEC Informática
 */

ob_start();
session_start();

// Sessões e Cookies
$sessionCookie = "ReadScripts"; // Se modificar aqui, modificar também no arquivo "func.login.php"

if (isset($_COOKIE['idAdmin_' . $sessionCookie]) && !isset($_SESSION['idAdmin_' . $sessionCookie])):
        $idAdmin = $_COOKIE['idAdmin_' . $sessionCookie];
elseif (!isset($_COOKIE['idAdmin_' . $sessionCookie]) && isset($_SESSION['idAdmin_' . $sessionCookie])):
        $idAdmin = $_SESSION['idAdmin_' . $sessionCookie];
elseif (isset($_COOKIE['idAdmin_' . $sessionCookie]) && isset($_SESSION['idAdmin_' . $sessionCookie])):
        $idAdmin = $_COOKIE['idAdmin_' . $sessionCookie];
else:
        $idAdmin = "deslogado";
endif;