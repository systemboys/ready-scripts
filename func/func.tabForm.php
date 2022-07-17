<?php
/**
 * conf [ CONFIGURAÇÕES ]
 * Descricao
 * @copyright (c) 2015, Marcos Aurélio R. Silva CompanyServices
 */
require '../_app/Config.inc.php';
include '../includes/tables.php';
include '../func/otherFunctions.php';
include '../func/authentication.php';

$Create = new Create; // Cadastrar
$Update = new Update; // Atualizar
$Read   = new Read;   // Consultar
$Delete = new Delete; // Deletar

// Selecionar e recuperar os dados de "Usuários".
$Read->ExeRead($CSReadyScriptsUser, "WHERE id = :id", "id={$idAdmin}");
foreach ($Read->getResult() as $readyScriptsUserDB): endforeach;
$primary_email = isset($readyScriptsUserDB['primary_email']) ? $readyScriptsUserDB['primary_email'] : NULL;

// Sessões e Cookies
$sessionCookie = "ReadScripts"; // Se modificar aqui, modificar também no arquivo "authentication.php"

if (
    isset($_GET['action']) && $_GET['action'] == "tabRecordForm" ||
    isset($_GET['action']) && $_GET['action'] == "tabEditForm"
    ):
    $id = isset($_GET['id']) ? $_GET['id'] : NULL; // ID da Aba

    #OBTER OS DADOS DO FORMULÁRIO
    $name = AntiSQLInjection($_POST['name']);

    // Validações
    if (empty($name)):
        $msgInfor = "Informe um \"Nome\" para a nova Aba!";
        $targetField = "name";

    else:
        // Registrar ou Atualizar dados na tabela "Abas".
        if ($_GET['action'] == "tabRecordForm"):
            $Dados = [
                'primary_email'   => $primary_email,
                'name'            => $name,
                'slug'            => slug($name),
                'links_per_page'  => '10',
                'pagination_page' => '1'
            ];
            $Create->ExeCreate($CSReadyScriptsTabs, $Dados);
        elseif ($_GET['action'] == "tabEditForm"):
            $Dados = [
                'primary_email'   => $primary_email,
                'name'            => $name,
                'slug'            => slug($name)
            ];
            $Update->ExeUpdate($CSReadyScriptsTabs, $Dados, "WHERE id = :id", "id={$id}");
        endif;
        echo "
        <script>
            // Ao salvar uma nova Aba, a página será atualizada.
            location.reload();
        </script>
        ";
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
elseif (isset($_GET['action']) && $_GET['action'] == "deleteTab"):
    $id = isset($_GET['id']) ? $_GET['id'] : NULL; // ID da Aba

    // Deletar dados de "Links" da Aba deletada.
    $Delete->ExeDelete($CSReadyScriptsLinks, "WHERE tab = :tab", "tab={$id}");

    // Deletar dados de "SubAbas" da Aba deletada.
    $Delete->ExeDelete($CSReadyScriptsSubTabs, "WHERE tab = :tab", "tab={$id}");

    // Deletar dados de "Abas".
    $Delete->ExeDelete($CSReadyScriptsTabs, "WHERE id = :id", "id={$id}");

    if ($Delete->getResult()):
        echo "
            <script>
                // Ao salvar uma nova Aba, a página será atualizada.
                location.reload();
            </script>
        ";
    endif;
elseif (
    isset($_GET['action']) && $_GET['action'] == "subTabRecordForm" ||
    isset($_GET['action']) && $_GET['action'] == "subTabEditForm"
    ):
    $idTab    = $_GET['idTab'];
    $idSubTab = isset($_GET['idSubTab']) ? $_GET['idSubTab'] : NULL; // ID da Aba

    #OBTER OS DADOS DO FORMULÁRIO
    $name = AntiSQLInjection($_POST['name']);

    // Validações
    if (empty($name)):
        $msgInfor = "Informe um \"Nome\" para a nova SubAba!";
        $targetField = "name";

    else:
        // Registrar ou Atualizar dados na tabela "SubAbas".
        if ($_GET['action'] == "subTabRecordForm"):
            $Dados = [
                'primary_email'   => $primary_email,
                'tab'             => $idTab,
                'name'            => $name,
                'slug'            => slug($name),
                'links_per_page'  => '10',
                'pagination_page' => '1'
            ];
            $Create->ExeCreate($CSReadyScriptsSubTabs, $Dados);
        elseif ($_GET['action'] == "subTabEditForm"):
            $Dados = [
                'primary_email'   => $primary_email,
                'tab'             => $idTab,
                'name'            => $name,
                'slug'            => slug($name)
            ];
            $Update->ExeUpdate($CSReadyScriptsSubTabs, $Dados, "WHERE id = :id", "id={$idSubTab}");
        endif;
        echo "
        <script>
            // Ao salvar uma nova Aba, a página será atualizada.
            location.reload();
        </script>
        ";
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
elseif (isset($_GET['action']) && $_GET['action'] == "deleteSubTab"):
    $id = isset($_GET['id']) ? $_GET['id'] : NULL; // ID da SubAba

    // Deletar dados de "Links" da Aba deletada.
    $Delete->ExeDelete($CSReadyScriptsLinks, "WHERE subtabs = :subtabs", "subtabs={$id}");

    // Deletar dados de "Abas".
    $Delete->ExeDelete($CSReadyScriptsSubTabs, "WHERE id = :id", "id={$id}");

    if ($Delete->getResult()):
        echo "
            <script>
                // Ao salvar uma nova Aba, a página será atualizada.
                location.reload();
            </script>
        ";
    endif;
elseif (
    isset($_GET['action']) && $_GET['action'] == "addLink" ||
    isset($_GET['action']) && $_GET['action'] == "editLink"
    ):
    $idLink   = isset($_GET['idLink']) ? $_GET['idLink'] : NULL; // ID do Link quando for editado obitido via GET

    #OBTER OS DADOS DO FORMULÁRIO
    $tab                    = $_POST['tab'];
    $subtabs                = $_POST['subTab'];
    $name                   = AntiSQLInjection($_POST['name']);
    $link                   = $_POST['link'];
    $link_label             = $_POST['link_label'];
    $link_target            = $_POST['link_target'];
    $popup_width            = $_POST['popup_width'];
    $popup_height           = $_POST['popup_height'];
    $image                  = $_POST['image'];
    $image_padding          = $_POST['image_padding'];
    $image_background_color = $_POST['image_background_color'];
    $about                  = $_POST['about'];
    $author                 = $_POST['author'];
    $url_git_hub            = isset($_POST['url_git_hub']) ? $_POST['url_git_hub'] : "";
    $date                   = reverseDate($_POST['date']);
    $hour                   = $_POST['hour'];
    $classification         = $_POST['classification'];

    // Validações
    if (empty($_POST['tab'])):
        $msgInfor = "Informe uma \"Aba\"!";
        $targetField = "tab";

    elseif (empty($_POST['subTab'])):
        $msgInfor = "Informe uma \"SubAba\"!";
        $targetField = "subTab";

    elseif (empty($name)):
        $msgInfor = "Informe um \"Nome\"!";
        $targetField = "name";

    elseif (empty($classification)):
        $msgInfor = "Informe ums \"Classificação\"!";
        $targetField = "classification";

    elseif (empty($link)):
        $msgInfor = "Informe um \"Link\"!";
        $targetField = "link";

    elseif (empty($link_label)):
        $msgInfor = "Informe um \"Nome\" para o botão!";
        $targetField = "link_label";

    elseif (empty($link_target)):
        $msgInfor = "Informe um \"Alvo\"!";
        $targetField = "link_target";

    elseif ($link_target == "popup" && empty($popup_width)):
        $msgInfor = "Informe uma \"Largura\"!";
        $targetField = "popup_width";

    elseif ($link_target == "popup" && empty($popup_height)):
        $msgInfor = "Informe uma \"Altura\"!";
        $targetField = "popup_height";

    elseif ($image_padding == ""):
        $msgInfor = "Informe um \"Valor\"!";
        $targetField = "image_padding";

    elseif (empty($image_background_color)):
        $msgInfor = "Informe uma \"Colo\"!";
        $targetField = "image_background_color";

    elseif (empty($about)):
        $msgInfor = "Informe algo \"Sobre\" o link!";
        $targetField = "about";

    elseif (empty($author)):
        $msgInfor = "Informe o \"Autor\" ou de onde vem!";
        $targetField = "author";

    // elseif (empty($url_git_hub)):
    //     $msgInfor = "Informe um \"Link do GitHub\"!";
    //     $targetField = "url_git_hub";

    elseif (empty($date)):
        $msgInfor = "Informe uma \"Data\" de postagem!";
        $targetField = "date";

    elseif (empty($hour)):
        $msgInfor = "Informe uma \"Hora\" de postagem!";
        $targetField = "hour";

    else:
        // Registrar ou Editar "SubAbas".
            $Dados = [
                'primary_email'          => $primary_email,
                'tab'                    => $tab,
                'subtabs'                => $subtabs,
                'name'                   => $name,
                'link'                   => $link,
                'link_label'             => $link_label,
                'link_target'            => $link_target,
                'popup_width'            => $popup_width,
                'popup_height'           => $popup_height,
                'image'                  => $image,
                'image_padding'          => $image_padding,
                'image_background_color' => $image_background_color,
                'about'                  => $about,
                'author'                 => $author,
                'url_git_hub'            => $url_git_hub,
                'date'                   => $date,
                'hour'                   => $hour,
                'classification'         => $classification
            ];
        if ($_GET['action'] == "addLink"):
            $Create->ExeCreate($CSReadyScriptsLinks, $Dados);
        elseif ($_GET['action'] == "editLink"):
            $Update->ExeUpdate($CSReadyScriptsLinks, $Dados, "WHERE id = :id", "id={$idLink}");
        endif;
        echo "
        <script>
            // Ao salvar uma nova Aba, a página será atualizada.
            $('#popupPg1_formLink').remove();
            onload(scriptTargetReady('scripts_{$subtabs}'));
        </script>
        ";
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
elseif (isset($_GET['action']) && $_GET['action'] == "deleteLink"):
    $id = $_GET['id']; // ID do Link

    // Deletar dados de "Links" da Aba deletada.
    $Delete->ExeDelete($CSReadyScriptsLinks, "WHERE id = :id", "id={$id}");

    if ($Delete->getResult()):
        echo "
            <script>
                $(document).ready(function() {
                    $('.cardId_{$id}').remove();
                    $('#popupPg1_deleteLink').remove();
                });
            </script>
        ";
    endif;
elseif (isset($_GET['action']) && $_GET['action'] == "subTab"):
    $idTab = $_GET['tab'];
    // Selecionar e recuperar os dados de "SubTabs".
    $Read->FullRead("SELECT * FROM {$CSReadyScriptsSubTabs} WHERE primary_email = '{$primary_email}' AND tab = '{$idTab}' ORDER BY name ASC");
    if ($Read->getResult()):
        foreach ($Read->getResult() as $readyScriptsSubTabsDB):
            echo "<option value='{$readyScriptsSubTabsDB['id']}'" . ($readyScriptsSubTabsDB['id'] == $idSubTab ? " selected" : NULL) . ">{$readyScriptsSubTabsDB['name']}</option>";
        endforeach;
    endif;
    echo "
        <script>
            $(function() {
                $('#subTab').focus(); //Setar o cursor (focus) no campo
            });
        </script>
        ";
endif;

