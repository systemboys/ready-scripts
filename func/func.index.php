<?php
require '../_app/Config.inc.php';
$Read = new Read; //Consultar
include '../func/otherFunctions.php';
include '../includes/tables.php';
include '../func/authentication.php';

// Selecionar e recuperar os dados de "Usuários".
$Read->ExeRead($CSReadyScriptsUser, "WHERE id = :id", "id={$idAdmin}");
foreach ($Read->getResult() as $readyScriptsUserDB): endforeach;
$primary_email = isset($readyScriptsUserDB['primary_email']) ? $readyScriptsUserDB['primary_email'] : NULL;

if ($idAdmin != "deslogado"):
    if (isset($_GET['action']) && $_GET['action'] == "scriptTargetReady"):
        ######## DETALHES COMPLETO DE UM LINK ########
        $id = $_GET['id'];
        // Selecionar e recuperar os dados de "Links dos scripts prontos"
        $Read->ExeRead($CSReadyScriptsLinks, "WHERE id = :id", "id={$id}");
        foreach ($Read->getResult() as $readyScriptsLinksDB): endforeach;

        // Definir alvo (target="")
        $link = ($readyScriptsLinksDB['link_location'] == "hosted" ? HOME . "/{$readyScriptsLinksDB['link']}" : $readyScriptsLinksDB['link']); // Definição do link
        switch ($readyScriptsLinksDB['link_target']) {
            case 'popup':
                $linkTarget = "onclick='openPopupLink(`{$link}`, `{$readyScriptsLinksDB['popup_width']}`, `{$readyScriptsLinksDB['popup_height']}`);' href='#'";
                break;
            case '_blank':
                $linkTarget = "href='{$readyScriptsLinksDB['link']}' target='{$readyScriptsLinksDB['link_target']}'";
                break;
            // Onde pode ser [_blank, popup]
        }
        // Definição do link da imagem
        switch ($readyScriptsLinksDB['image_location']) {
            case 'hosted':
                $imageLink = HOME . "/pic/demo-image/" . (!empty($readyScriptsLinksDB['image']) ? $readyScriptsLinksDB['image'] : "GettyImages-1129377183-850x500.png");
                break;
            case 'external':
                $imageLink = $readyScriptsLinksDB['image'];
                break;
        }
        
        echo "
            <div class='card mb-3 cardId_{$readyScriptsLinksDB['id']}'>
                <i id='scripts_" . table($CSReadyScriptsLinks, "subtabs", "WHERE id = '{$readyScriptsLinksDB['id']}'") . "' onclick='scriptTargetReady(this.id), subTabMenuItem(this.id)' class='fas fa-window-close closeLinkDetails' title='Fechar os detalhes do link'></i>
                <img src='{$imageLink}' class='card-img-top' alt='{$readyScriptsLinksDB['name']}'>
                <div class='card-body'>
                    <div class='box_starRating' style='margin: -20px 0 5px 0;" . ($readyScriptsLinksDB['classification'] == "0.0" ? " display: none" : NULL) . "'>
                        " . starRating($readyScriptsLinksDB['classification']) . "
                    </div>
                    " . (!empty($readyScriptsLinksDB['link']) ? "<a {$linkTarget} class='btn btn-primary'>{$readyScriptsLinksDB['link_label']}</a>" : NULL) . "
                    <small><p><i id='formLink' onclick='popUpWindow(this.id, `" . HOME . "/pages/tabForm.php?page=editLink&id={$readyScriptsLinksDB['id']}`)' class='fas fa-edit editLink' title='Editar link'></i><i id='deleteLink' onclick='popUpWindow(this.id, `" . HOME . "/pages/tabForm.php?page=deleteLink&id={$readyScriptsLinksDB['id']}`)' class='fas fa-trash-alt deleteLink' title='Deletar link'></i> Post: " . reverseDate($readyScriptsLinksDB['date']) . " {$readyScriptsLinksDB['hour']}</small></p>
                    " . (!empty($readyScriptsLinksDB['url_git_hub']) ? "<a onclick='openPopupLink(`{$readyScriptsLinksDB['url_git_hub']}`, `990`, `600`);' href='#' class='btn btn-dark'>Git Hub</a>" : NULL) . "
                    <h5 class='card-title' style='margin: 15px 0 0 0'>{$readyScriptsLinksDB['name']}</h5>
                    <p class='card-text'>{$readyScriptsLinksDB['about']}</p>
                    <p class='card-text'><small class='text-muted'>&copy; {$readyScriptsLinksDB['author']}</small></p>
                </div>
            </div>
        <script>
            $(window).scrollTop(0); // Rolar página indo pro topo
        </script>
        ";
    elseif (
        isset($_GET['action']) && $_GET['action'] == "scriptTargetReadyAll" ||
        isset($_GET['action']) && $_GET['action'] == "scriptTargetReadyAllSubTab"
        ):
        ######## TODAS AS MINIATURAS DE LINKS DE UMA CATEGORIA ########
        $id = $_GET['id']; // ID das Tabs SubAbas
        echo "
        <script>
            // Se não houver nenhuma SubAba do banco de dados selecionada, será destacada a Aba 'Todos os links'
            var scriptTarget = '{$_GET['action']}';
            if (scriptTarget == 'scriptTargetReadyAll') {
                $('#allScripts_{$id}').addClass('active');
            }

            // Carregar próxima página da paginação
            function pagination_scriptTargetReady(pagina, paginas, quant_result) {
                $('#topProgressBar').addClass('progress-bar-striped progress-bar-animated');
                $.post('" . HOME . "/func/func.index.php?action=pagination_scriptTargetReadyAll&item=" . ($_GET['action'] == "scriptTargetReadyAll" ? "tab" : "subtabs") . "&id={$id}', {
                    pagina: pagina,
                    paginas: paginas,
                    quant_result: quant_result
                }, function (data) {
                    $('.pagination_scriptTargetReadyLinks').html(data);
                    $('#topProgressBar').removeClass('progress-bar-striped progress-bar-animated');
                }, 'html');
            }
        </script>
        ";
        echo "
        <div class='container'>
            ";
        if ($_GET['action'] == "scriptTargetReadyAllSubTab"):
        echo "
            <div class='subtabActionAndLinks'>
                <button type='button' id='subTabForm' onclick='popUpWindow(this.id, `" . HOME . "/pages/tabForm.php?page=subTabEditForm&idTab=" . table($CSReadyScriptsSubTabs, "tab", "WHERE id = '{$id}'") . "&idSubTab={$id}`)' class='btn btn-primary'><i class='fas fa-edit'></i> Editar SubAba</button>
                <button type='button' id='deleteSubTab' onclick='popUpWindow(this.id, `" . HOME . "/pages/tabForm.php?page=deleteSubTab&id={$id}`)' class='btn btn-danger'><i class='fas fa-trash-alt'></i> Deletar SubAba</button>
                <button type='button' id='formLink' onclick='popUpWindow(this.id, `" . HOME . "/pages/tabForm.php?page=addLink&idSubTab={$id}`)' class='btn btn-success'><i class='fas fa-link'></i> Adicionar link</button>
            </div>
            ";
        endif;
        echo "
            <div class='row pagination_scriptTargetReadyLinks'>
            ";
            // Selecionar e recuperar os dados de "Links" para para contar os resultados
            if ($_GET['action'] == "scriptTargetReadyAll"):
                $Read->FullRead("SELECT count(*) as count FROM {$CSReadyScriptsLinks} WHERE primary_email = '{$primary_email}' AND tab = '{$id}'");
            elseif ($_GET['action'] == "scriptTargetReadyAllSubTab"):
                $Read->FullRead("SELECT count(*) as count FROM {$CSReadyScriptsLinks} WHERE primary_email = '{$primary_email}' AND subtabs = '{$id}'");
            endif;
            foreach ($Read->getResult() as $tabelaCount): endforeach;
            $tabelaCount = $tabelaCount['count'];
            
            $quant_resul = "10"; // Quantidade de itens por página
            $pagina      = "1"; // Página inicial
            $paginas     = ceil($tabelaCount / $quant_resul); // Calcula a quantidade de paginas
            $limit       = $quant_resul * ($pagina - "1");
    
            if ($_GET['action'] == "scriptTargetReadyAll"):
                // Selecionar e recuperar os dados de "Links dos Scripts Prontos"
                $Read->ExeRead($CSReadyScriptsLinks, "WHERE primary_email = :primary_email AND tab = :tab ORDER BY id DESC LIMIT :limit, :offset", "primary_email={$primary_email}&tab={$id}&limit={$limit}&offset={$quant_resul}");
            elseif ($_GET['action'] == "scriptTargetReadyAllSubTab"):
                // Selecionar e recuperar os dados de "Links dos Scripts Prontos" da SubAba selecionada
                $Read->ExeRead($CSReadyScriptsLinks, "WHERE primary_email = :primary_email AND subtabs = :subtabs ORDER BY id DESC LIMIT :limit, :offset", "primary_email={$primary_email}&subtabs={$id}&limit={$limit}&offset={$quant_resul}");
            endif;
        if ($Read->getResult()):
            foreach ($Read->getResult() as $readyScriptsLinksDB):
                // Definir alvo (target="")
                $link = ($readyScriptsLinksDB['link_location'] == "hosted" ? HOME . "/{$readyScriptsLinksDB['link']}" : $readyScriptsLinksDB['link']); // Definição do link
                switch ($readyScriptsLinksDB['link_target']) {
                    case 'popup':
                        $linkTarget = "onclick='openPopupLink(`{$link}`, `{$readyScriptsLinksDB['popup_width']}`, `{$readyScriptsLinksDB['popup_height']}`);' href='#'";
                        break;
                    case '_blank':
                        $linkTarget = "href='{$readyScriptsLinksDB['link']}' target='{$readyScriptsLinksDB['link_target']}'";
                        break;
                    // Onde pode ser [_blank, popup]
                }
                // Definição do link da imagem
                switch ($readyScriptsLinksDB['image_location']) {
                    case 'hosted':
                        $imageLink = HOME . "/pic/demo-image/" . (!empty($readyScriptsLinksDB['image']) ? $readyScriptsLinksDB['image'] : "GettyImages-1129377183-850x500.png");
                        break;
                    case 'external':
                        $imageLink = $readyScriptsLinksDB['image'];
                        break;
                }
                echo "
                <div class='col-sm-6 cardId_{$readyScriptsLinksDB['id']}'>
                    <div class='card cardScriptTargetReadyAll' style='width: 18rem;'>
                        " . ($readyScriptsLinksDB['image_location'] == "external" ? "<i class='fas fa-globe-americas webIndicatorIcon' title='Imagem da Web'></i>" : NULL) . "
                        <img id='{$readyScriptsLinksDB['id']}' onclick='scriptTargetReady(this.id)' src='{$imageLink}' class='card-img-top' alt='...'>
                        <div class='card-body'>
                            <div class='box_starRating' style='margin: -10px 0 5px 0;" . ($readyScriptsLinksDB['classification'] == "0.0" ? " display: none" : NULL) . "'>
                                " . starRating($readyScriptsLinksDB['classification']) . "
                            </div>
                            <small class='text-muted'><i id='formLink' onclick='popUpWindow(this.id, `" . HOME . "/pages/tabForm.php?page=editLink&id={$readyScriptsLinksDB['id']}`)' class='fas fa-edit editLink' title='Editar link'></i><i id='deleteLink' onclick='popUpWindow(this.id, `" . HOME . "/pages/tabForm.php?page=deleteLink&id={$readyScriptsLinksDB['id']}`)' class='fas fa-trash-alt deleteLink' title='Deletar link'></i> Post: " . reverseDate($readyScriptsLinksDB['date']) . " {$readyScriptsLinksDB['hour']}</small>
                            <h5 class='card-title'>" . shortenTextByWords($readyScriptsLinksDB['name'], 30) . "</h5>
                            <p class='card-text'><small class='text-muted'>&copy; {$readyScriptsLinksDB['author']}</small></p>
                            " . (!empty($readyScriptsLinksDB['link']) ? "<a {$linkTarget} class='btn btn-primary'>{$readyScriptsLinksDB['link_label']}</a>" : NULL) . "
                            " . (!empty($readyScriptsLinksDB['url_git_hub']) ? "<a onclick='openPopupLink(`{$readyScriptsLinksDB['url_git_hub']}`, `990`, `600`);' href='#' class='btn btn-dark'>Git Hub</a>" : NULL) . "
                        </div>
                    </div>
                </div>
                ";
            endforeach;
        endif;
        if ($tabelaCount > $quant_resul):
            include './indice_scriptTargetReady.php'; // Links da paginação
        endif;
        echo "
            </div>
        </div>
        ";
    elseif (isset($_GET['action']) && $_GET['action'] == "pagination_scriptTargetReadyAll"):
        $item     = $_GET['item'];
        $idSubTab = isset($_GET['id']) ? $_GET['id'] : NULL;
        if ($item == "tab"):
            $whereSubTab = "tab = '{$idSubTab}'";
        elseif ($item == "subtabs"):
            $whereSubTab = "subtabs = '{$idSubTab}'";
        endif;
        // Recebe conteudo da pagina anterior por POST
        $pagina = $_POST['pagina'];
        $quant_resul = $_POST['quant_result'];
        $paginas = $_POST['paginas']; // Quantidade de páginas
    
        // Calculando onde o limit deve começar na consulta
        $start = $pagina * $quant_resul;
        $pagina ++;
        
        // Selecionar e recuperar os dados de "Links"
        $Read->ExeRead($CSReadyScriptsLinks, "WHERE primary_email = '{$primary_email}' AND {$whereSubTab} ORDER BY id DESC LIMIT :limit, :offset", "limit={$start}&offset={$quant_resul}");
        if ($Read->getResult()):
            foreach ($Read->getResult() as $readyScriptsLinksDB):
                // Definir alvo (target="")
                $link = ($readyScriptsLinksDB['link_location'] == "hosted" ? HOME . "/{$readyScriptsLinksDB['link']}" : $readyScriptsLinksDB['link']); // Definição do link
                switch ($readyScriptsLinksDB['link_target']) {
                    case 'popup':
                        $linkTarget = "onclick='openPopupLink(`{$link}`, `{$readyScriptsLinksDB['popup_width']}`, `{$readyScriptsLinksDB['popup_height']}`);' href='#'";
                        break;
                    case '_blank':
                        $linkTarget = "href='{$readyScriptsLinksDB['link']}' target='{$readyScriptsLinksDB['link_target']}'";
                        break;
                    // Onde pode ser [_blank, popup]
                }
                // Definição do link da imagem
                switch ($readyScriptsLinksDB['image_location']) {
                    case 'hosted':
                        $imageLink = HOME . "/pic/demo-image/" . (!empty($readyScriptsLinksDB['image']) ? $readyScriptsLinksDB['image'] : "GettyImages-1129377183-850x500.png");
                        break;
                    case 'external':
                        $imageLink = $readyScriptsLinksDB['image'];
                        break;
                }
                echo "
                <div class='col-sm-6 cardId_{$readyScriptsLinksDB['id']}'>
                    <div class='card cardScriptTargetReadyAll' style='width: 18rem;'>
                        " . ($readyScriptsLinksDB['image_location'] == "external" ? "<i class='fas fa-globe-americas webIndicatorIcon' title='Imagem da Web'></i>" : NULL) . "
                        <img id='{$readyScriptsLinksDB['id']}' onclick='scriptTargetReady(this.id)' src='{$imageLink}' class='card-img-top' alt='...'>
                        <div class='card-body'>
                            <div class='box_starRating' style='margin: -10px 0 5px 0;" . ($readyScriptsLinksDB['classification'] == "0.0" ? " display: none" : NULL) . "'>
                                " . starRating($readyScriptsLinksDB['classification']) . "
                            </div>
                            <small class='text-muted'><i id='formLink' onclick='popUpWindow(this.id, `" . HOME . "/pages/tabForm.php?page=editLink&id={$readyScriptsLinksDB['id']}`)' class='fas fa-edit editLink' title='Editar link'></i><i id='deleteLink' onclick='popUpWindow(this.id, `" . HOME . "/pages/tabForm.php?page=deleteLink&id={$readyScriptsLinksDB['id']}`)' class='fas fa-trash-alt deleteLink' title='Deletar link'></i> Post: " . reverseDate($readyScriptsLinksDB['date']) . " {$readyScriptsLinksDB['hour']}</small>
                            <h5 class='card-title'>" . shortenTextByWords($readyScriptsLinksDB['name'], 30) . "</h5>
                            <p class='card-text'><small class='text-muted'>&copy; {$readyScriptsLinksDB['author']}</small></p>
                            " . (!empty($readyScriptsLinksDB['link']) ? "<a {$linkTarget} class='btn btn-primary'>{$readyScriptsLinksDB['link_label']}</a>" : NULL) . "
                            " . (!empty($readyScriptsLinksDB['url_git_hub']) ? "<a onclick='openPopupLink(`{$readyScriptsLinksDB['url_git_hub']}`, `990`, `600`);' href='#' class='btn btn-dark'>Git Hub</a>" : NULL) . "
                        </div>
                    </div>
                </div>
                ";
            endforeach;
        endif;
        include './indice_scriptTargetReady.php'; // Links da paginação
    endif;
else:
    echo "
    <script>
        $('body').html('<div id=\"retorno_sys\" onclick=\"$(`#retorno_sys`).fadeOut()\"></div>').onload(popUpWindow('login', '" . HOME . "/pages/login.php?page=logInUser'));
    </script>
    ";
endif;
