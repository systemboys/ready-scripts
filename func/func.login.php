<?php
/**
 * conf [ CONFIGURAÇÕES ]
 * Descricao
 * @copyright (c) 2015, Marcos Aurélio R. Silva CompanyServices
 */
require '../_app/Config.inc.php';
include '../includes/tables.php';
include '../func/authentication.php';
$Read = new Read; // Consultar


// Sessões e Cookies
$sessionCookie = "ReadScripts"; // Se modificar aqui, modificar também no arquivo "authentication.php"

if (isset($_GET['action']) && $_GET['action'] == "logIn"):
    #OBTER OS DADOS DO FORMULÁRIO
    $email         = $_POST['email'];
    $password      = md5($_POST['password']);
    $keepConnected = isset($_POST['keepConnected']) ? $_POST['keepConnected'] : "off";

    // Validações
    if (empty($email)):
        $msgInfor = "Informe o \"Email\"!";
        $targetField = "email";

    elseif (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)):
        $msgInfor = "Informe um \"Email\" válido!";
        $targetField = "email";

    elseif (empty($password)):
        $msgInfor = "Informe a \"Senha\"!";
        $targetField = "password";

    else:
        // Selecionar e recuperar os dados de "Usuários".
        $Read->ExeRead($CSReadyScriptsUser, "WHERE primary_email = :primary_email AND password = :password", "primary_email={$email}&password={$password}");
        foreach ($Read->getResult() as $adminDB): endforeach;
        $countUser = $Read->getRowCount();
        if ($countUser != 0):
            // CRIAR A SESSÃO
            $_SESSION['idAdmin_' . $sessionCookie] = $adminDB['id'];
            if ($keepConnected == "on"):
                // CRIAR UM COOKIE ---> EXPIRA EM 2 DIAS
                setcookie("idAdmin_{$sessionCookie}", $adminDB['id'], (time() + (2 * 24 * 3600)), "/");
            endif;
            echo "
                <div class='ok'>Logado com sucesso</div>
                <script>
                    $(function() {
                        document.getElementById('email').value='';
                        document.getElementById('password').value='';
                        $('#email').focus();

                        // Remover o formulário
                        $('#popupPg1_login').remove();

                        // Redirecionar para index.php
                        window.location.replace('" . HOME . "');

                        // Ocultar objeto em um determinado tempo
                        window.setTimeout(function() {
                            $('#retorno_sys').fadeOut();
                        }, 5000); // 1000 = 1 segundo
                    });
                </script>
            ";
        else:
            echo "
                <div class='no'>Suas credenciais não conferem!</div>
                <script>
                    $(function() {
                        document.getElementById('email').value='';
                        $('#email').focus();
                        
                        // Ocultar objeto em um determinado tempo
                        window.setTimeout(function() {
                            $('#retorno_sys').fadeOut();
                        }, 5000); // 1000 = 1 segundo
                    });
                </script>
                ";
        endif;
    endif;
    // Imprimir a mensagem
    if (isset($msgInfor)):
        echo "
            <div class='no'>{$msgInfor}</div>
            <script>
                $(function() {
                    document.getElementById('{$targetField}').value='';
                    $('#{$targetField}').focus();
                        
                    // Ocultar objeto em um determinado tempo
                    window.setTimeout(function() {
                        $('#retorno_sys').fadeOut();
                    }, 5000); // 1000 = 1 segundo
                });
            </script>
            ";
    endif;
elseif (isset($_GET['action']) && $_GET['action'] == "logOut"):
    // Apagar Sessão
    session_destroy();
    // Excluir Cookier
    if (isset($_COOKIE['idAdmin_' . $sessionCookie])):
        setcookie("idAdmin_{$sessionCookie}", "", (time() - (2 * 24 * 3600)), "/");
    endif;
    echo "
        <script>
            $(function() {
                // Redirecionar para index.php
                window.location.replace('" . HOME . "');
            });
        </script>
        ";
endif;