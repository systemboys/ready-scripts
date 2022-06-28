<?php
require './_app/Config.inc.php';
$Read = new Read; //Consultar
include './func/otherFunctions.php';
include './includes/tables.php';
include './func/authentication.php';

// Selecionar e recuperar os dados de "Usuários".
$Read->ExeRead($CSReadyScriptsUser, "WHERE id = :id", "id={$idAdmin}");
foreach ($Read->getResult() as $readyScriptsUserDB): endforeach;
$primary_email = isset($readyScriptsUserDB['primary_email']) ? $readyScriptsUserDB['primary_email'] : NULL;

// Selecionar e recuperar os dados de "Configurações da Página"
$Read->ExeRead($CSReadyScriptsSettings, "WHERE primary_email = :primary_email", "primary_email={$primary_email}");
foreach ($Read->getResult() as $readyScriptsSettingsDB): endforeach;

// Selecionar e recuperar os dados de "Planos de fundo".
$Read->ExeRead($CSreadyScriptsBackgrounds, "WHERE primary_email = :primary_email AND id = :id", "primary_email={$primary_email}&id=" . (isset($readyScriptsSettingsDB['background_image']) ? $readyScriptsSettingsDB['background_image'] : NULL));
foreach ($Read->getResult() as $readyScriptsBackgroundsDB): endforeach;
?>
<!doctype html>
<html lang="en">
    <head>
            <!-- Required meta tags -->
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">

            <!-- Bootstrap CSS 5.1.3 -->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

            <title>Scripts Prontos</title>
            <!-- Favicon -->
            <link rel="apple-touch-icon" sizes="57x57" href="<?= HOME . "/pic/this-page/favicon1/apple-icon-57x57.png" ?>">
            <link rel="apple-touch-icon" sizes="60x60" href="<?= HOME . "/pic/this-page/favicon1/apple-icon-60x60.png" ?>">
            <link rel="apple-touch-icon" sizes="72x72" href="<?= HOME . "/pic/this-page/favicon1/apple-icon-72x72.png" ?>">
            <link rel="apple-touch-icon" sizes="76x76" href="<?= HOME . "/pic/this-page/favicon1/apple-icon-76x76.png" ?>">
            <link rel="apple-touch-icon" sizes="114x114" href="<?= HOME . "/pic/this-page/favicon1/apple-icon-114x114.png" ?>">
            <link rel="apple-touch-icon" sizes="120x120" href="<?= HOME . "/pic/this-page/favicon1/apple-icon-120x120.png" ?>">
            <link rel="apple-touch-icon" sizes="144x144" href="<?= HOME . "/pic/this-page/favicon1/apple-icon-144x144.png" ?>">
            <link rel="apple-touch-icon" sizes="152x152" href="<?= HOME . "/pic/this-page/favicon1/apple-icon-152x152.png" ?>">
            <link rel="apple-touch-icon" sizes="180x180" href="<?= HOME . "/pic/this-page/favicon1/apple-icon-180x180.png" ?>">
            <link rel="icon" type="image/png" sizes="192x192"  href="<?= HOME . "/pic/this-page/favicon1/android-icon-192x192.png" ?>">
            <link rel="icon" type="image/png" sizes="32x32" href="<?= HOME . "/pic/this-page/favicon1/favicon-32x32.png" ?>">
            <link rel="icon" type="image/png" sizes="96x96" href="<?= HOME . "/pic/this-page/favicon1/favicon-96x96.png" ?>">
            <link rel="icon" type="image/png" sizes="16x16" href="<?= HOME . "/pic/this-page/favicon1/favicon-16x16.png" ?>">
            <link rel="manifest" href="<?= HOME . "/pic/this-page/favicon1/manifest.json" ?>">
            <!-- Font Awesome 5.15.4 -->
            <script src="https://kit.fontawesome.com/ab11a77a3a.js" crossorigin="anonymous"></script>

            <!-- Optional JavaScript; choose one of the two! -->
            <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
            
            <!-- ajaxLoad -->
            <script src="<?= HOME . "/js/ajaxLoad.js" ?>"></script>

            <!-- Option 1: Bootstrap Bundle with Popper 5.1.3 -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

            <!-- Option 2: Separate Popper and Bootstrap JS -->
            <!--
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
            -->
            <meta name="msapplication-TileColor" content="#ffffff">
            <meta name="msapplication-TileImage" content="<?= HOME . "/pic/this-page/favicon1/ms-icon-144x144.png" ?>">
            <meta name="theme-color" content="#ffffff">
            <!-- /Favicon -->
            <style>
                body {
                    <?php
                    // Propriedades do plano de fundo
                    if ($idAdmin != 0 && $readyScriptsSettingsDB['background_applied'] == "image"):
                        echo "
                    background-image: url({$readyScriptsBackgroundsDB['image']});
                    background-color: #1c1c1c;
                    background-size: 100% auto;
                    background-repeat: no-repeat;
                    background-attachment: fixed;
                        ";
                    elseif ($idAdmin != 0 && $readyScriptsSettingsDB['background_applied'] == "color"):
                        echo "
                    background: {$readyScriptsSettingsDB['background_color']}; /* Cor padrão #d1ccc0 */
                        ";
                    elseif ($idAdmin == 0):
                        echo "
                    background-image: url(https://wallpaperbat.com/img/354495-debian-wallpaper.jpg);
                    background-color: #1c1c1c;
                    background-size: 100% auto;
                    background-repeat: no-repeat;
                    background-attachment: fixed;
                        ";
                    endif;
                    ?>
                    padding: 55px 0 0 0;
                }
                .row .col-sm-3 #list-tab {
                    box-shadow: -1px 1px 5px rgba(0,0,0,.2);
                }
                .col-sm-9 #nav-tabContent .container .row .col-sm-3 .list-group {
                    box-shadow: -1px 1px 5px rgba(0,0,0,.2);
                }
                .row .col-sm-9 #nav-tabContent #list-home .card .row .col-md-8 {
                    padding: 5px;
                }
                .row .col-sm-9 #nav-tabContent #list-home .card .row .col-md-8 img {
                    border-radius: 3px;
                    box-shadow: -1px 1px 5px rgba(0,0,0,.4);
                }
                .row .col-sm-3, .col-sm-9 {
                    margin: 0 0 10px 0;
                }
                .alertNotFoundScript {
                    background: #fff;
                    height: 50px;
                    border-radius: 5px;
                    margin: 30px 0 0 0;
                    padding: 10px;
                    box-shadow: -1px 1px 3px rgba(0,0,0,.2);
                    color: #f90;
                }
                body .row .col-sm-9 .tab-content .tab-pane .container .row .scriptTargetReady .container .row div .cardScriptTargetReadyAll {
                    margin: 0 0 20px 0;
                }
                /* Ícone indicador de Web que fica no canto superior direito da capa do link */
                body .row .col-sm-9 .tab-content .tab-pane .container .row .scriptTargetReady .container .row .col-sm-6 .cardScriptTargetReadyAll .webIndicatorIcon {
                    position: absolute;
                    top: 15px;
                    right: -20px;
                    color: #090;
                    opacity: 80%;
                    z-index: 2;
                }
                /* /Ícone indicador de Web que fica no canto superior direito da capa do link */
                body .row .col-sm-9 .tab-content .tab-pane .container .row .scriptTargetReady .container .row div .cardScriptTargetReadyAll img {
                    background: rgba(255,255,255,.8);
                    margin: 10px auto 0 -5%;
                    width: 110%;
                    border-radius: 4px;
                    box-shadow: -1px 1px 10px rgba(0,0,0,.6);
                    z-index: 1;
                    cursor: pointer;
                }
                body .row .col-sm-9 .tab-content .tab-pane .container .row .scriptTargetReady .container .row div .cardScriptTargetReadyAll .card-body {
                    background: #ededed;
                    margin: -5px auto 10px -2.5%;
                    width: 105%;
                    border-radius: 4px;
                    box-shadow: -1px 1px 10px rgba(0,0,0,.6);
                }
                /* Botões: Adicionar Aba e SubAba */
                body .row .list-group .list-group-item .fa-folder-plus {
                    color: #060;
                }
                body .row .col-sm-9 .tab-content .tab-pane .container .row .col-sm-3 .list-group .list-group-item .fa-folder-plus {
                    color: #060;
                }
                /* /Botões: Adicionar Aba e SubAba */
                /* Editar ou Deletar Aba */
                body .row .col-sm-9 .tab-content div .container .row .col-sm-3 .editOrDeleteTab {
                    width: 100%;
                    padding: 20px 0 0 0;
                }
                /* /Editar ou Deletar Aba */
                /* Botões: Editar e Deletar */
                body .row .col-sm-9 .tab-content .tab-pane .container .row .scriptTargetReady .container .row div .cardScriptTargetReadyAll .card-body i {
                    position: relative;
                    font-size: 1.3em;
                    cursor: pointer;
                    top: 3px;
                }
                body .row .col-sm-9 .tab-content .tab-pane .container .row .scriptTargetReady .container .row div .cardScriptTargetReadyAll .card-body .editLink {
                    margin: 0 5px 0 0;
                    color: #089;
                }
                body .row .col-sm-9 .tab-content .tab-pane .container .row .scriptTargetReady .container .row div .cardScriptTargetReadyAll .card-body .deleteLink {
                    margin: 0 5px;
                    color: #f00;
                }
                body .row .col-sm-9 .tab-content .tab-pane .container .row .scriptTargetReady .card .card-body i {
                    position: relative;
                    font-size: 1.3em;
                    cursor: pointer;
                    top: 3px;
                }
                body .row .col-sm-9 .tab-content .tab-pane .container .row .scriptTargetReady .card .card-body .editLink {
                    margin: 0 5px 0 0;
                    color: #089;
                }
                body .row .col-sm-9 .tab-content .tab-pane .container .row .scriptTargetReady .card .closeLinkDetails {
                    position: absolute;
                    top: 10px;
                    left: 12px;
                    font-size: 2em;
                    color: #fff;
                    opacity: 50%;
                    text-shadow: -1px 1px 3px rgba(0,0,0,.4);
                    transition-duration: 0.5s;
                    cursor: pointer;
                }
                body .row .col-sm-9 .tab-content .tab-pane .container .row .scriptTargetReady .card .closeLinkDetails:hover {
                    color: #fff;
                    opacity: 80%;
                    transition-duration: 0.5s;
                }
                body .row .col-sm-9 .tab-content .tab-pane .container .row .scriptTargetReady .card .card-body .deleteLink {
                    margin: 0 5px;
                    color: #f00;
                }
                /* /Botões: Editar e Deletar */
                body .row .col-sm-9 .tab-content .tab-pane .container .row .scriptTargetReady .card-img-top {
                    width: 98%;
                    margin: 7px auto;
                }
                body .row .col-sm-9 .tab-content .tab-pane .container .row .scriptTargetReady .container .subtabActionAndLinks {
                    margin: 0 10px 20px -15px;
                }
                body .row .col-sm-9 .tab-content .tab-pane .container .row .scriptTargetReady .container .subtabActionAndLinks button {
                    margin: 2.5px 0;
                }
                .alertNotFoundScript img {
                    position: relative;
                    width: 30px;
                    margin: 0;
                    top: 0px;
                }
                .alertNotFoundScript p {
                    position: relative;
                    margin: 3px 0 0 40px;
                    padding: 0;
                    top: -30px;
                }
                .sticky-top {
                    top: 55px;
                    margin: 0;
                    z-index: 9999;
                }
                /* Screen até 320px */
                #loadSys {
                    position: fixed;
                    background: rgba(210, 218, 226,.9);
                    border-bottom: 3px solid rgba(128, 142, 155,.4);
                    width: 150px;
                    min-height: 20px;
                    top: 50%;
                    left: 50%;
                    margin: -48px 0 0 -80px;
                    font: 14px Tahoma, Geneva, sans-serif;
                    text-align: center;
                    font-weight: bold;
                    color: #666;
                    padding: 10px 10px 6px 10px;
                    border-radius: 0;
                    box-shadow: -1px 1px 4px rgba(0,0,0,.4);
                }
                #retorno_sys {
                    display: none;
                    position: fixed;
                    width: 100%;
                    bottom: 0;
                    right: 0;
                    margin: 0;
                    padding: 0;
                    z-index: 9999;
                }
                .no {
                    background: url(./pic/1438494886_Alert.png) no-repeat #FF5722;
                    background-position: 15px 15px;
                    font: 14px Tahoma, Geneva, sans-serif;
                    color: #fff;
                    font-weight: bold;
                    margin: 0;
                    padding: 15px 15px 15px 45px;
                }
                .ok {
                    background: url(./pic/1438495473_gem_okay.png) no-repeat #8BC34A;
                    background-position: 15px 15px;
                    font: 14px Tahoma, Geneva, sans-serif;
                    color: #FFF;
                    font-weight: bold;
                    margin: 0;
                    padding: 15px 15px 15px 45px;
                }
                /* Classificação por estrelas */
                body .box_starRating {
                    background: #fff;
                    width: 150px;
                    padding: 0 5px;
                    border-radius: 50%;
                    text-align: left;
                    box-shadow: -1px 1px 2px rgba(0,0,0,.4);
                }
                body .box_starRating .starRating {
                    color: #f90;
                    text-shadow: -1px 1px 2px rgba(0,0,0,.4);
                }
                /* /Classificação por estrelas */
                /* Screen a partir de 400px */
                @media only screen and (min-width: 410px) {
                    #retorno_sys {
                        width: 400px;
                        margin: 0 5px 5px 5px;
                    }
                    .no {
                        box-shadow: 1px 1px 2px rgba(0,0,0,.4);
                    }
                    .ok {
                        box-shadow: 1px 1px 2px rgba(0,0,0,.2);
                    }
                }
                /* PAGINAÇÃO:
                Botão ativo:  class="btn-yt btnDefault btnToggled"
                Botão normal: class="btn-yt btnDefault"
                */
                .btn-yt {
                    height: 2.95em;
                    padding: 0 .91em;
                    font:14px "Segoe UI", Tahoma, Geneva, sans-serif;
                    border-width: 1px;
                    border-style: solid;
                    outline: 0;
                    font-weight: bold;
                    font-size: 11px;
                    white-space: nowrap;
                    word-wrap: normal;
                    vertical-align: middle;
                    cursor: pointer;
                    *overflow:visible;
                    border-radius: 2px;
                }
                a.btn-yt {
                    display: inline-block;
                    line-height: 2.8em;
                    height: 2.78em;
                    text-decoration: none;
                    margin:0 1px;
                    padding:0 10px;
                }
                .btnDefault, body .btnDefault[disabled] {
                    text-shadow: 0 1px 0 #fff;
                    border-color: #ccc #ccc #aaa;
                    background-color: #e0e0e0;
                    color: #555;
                    box-shadow: inset 0 0 1px #fff;
                    filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=0, StartColorStr=#fffafafa, EndColorStr=#ffdcdcdc);
                    background-image: linear-gradient(top bottom, #fafafa 0, #dcdcdc 100%);
                }
                .btnDefault:active, .btnDefault.btnToggled {border-color: #888 #aaa #ccc;-moz-box-shadow: inset 0 1px 5px rgba(0,0,0,0.25), 0 1px 0 #fff;-ms-box-shadow: inset 0 1px 5px rgba(0,0,0,0.25), 0 1px 0 #fff;-webkit-box-shadow: inset 0 1px 5px rgba(0,0,0,0.25), 0 1px 0 #fff;box-shadow: inset 0 1px 5px rgba(0,0,0,0.25), 0 1px 0 #fff;filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=0, StartColorStr=#ffc8c8c8, EndColorStr=#ffe6e6e6);background-image: -moz-linear-gradient(top, #c8c8c8 0, #e6e6e6 100%);background-image: -ms-linear-gradient(top, #c8c8c8 0, #e6e6e6 100%);background-image: -o-linear-gradient(top, #c8c8c8 0, #e6e6e6 100%);background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0, #c8c8c8), color-stop(100%, #e6e6e6));background-image: -webkit-linear-gradient(top, #c8c8c8 0, #e6e6e6 100%);background-image: linear-gradient(to bottom, #c8c8c8 0, #e6e6e6 100%)}
                /* Classes:
                Botão ativo:  class="btn-yt btnDefault btnToggled"
                Botão normal: class="btn-yt btnDefault"
                PAGINAÇÃO */

                #paginationBox {
                    background: #ededed;
                    text-align: center;
                    margin: 0;
                    padding: 10px;
                    border-radius: 5px;
                    box-shadow: -1px 1px 5px rgba(0,0,0,.4);
                }
                #loadSys {
                    position: fixed;
                    background: rgba(255,255,255,.8);
                    width: 150px;
                    min-height: 20px;
                    top: 50%;
                    left: 50%;
                    margin: -48px 0 0 -80px;
                    text-align: center;
                    color: #999;
                    padding: 15px;
                    border-radius: 4px;
                    box-shadow: -1px 1px 10px rgba(0,0,0,.4);
                }
            </style>
            <script>
                // Função que executa os detalhes do Script Pronto no Alvo
                function scriptTargetReady(id) {
                    // Obter o ID do registro a partir do ID allScripts_99
                    var idTab = id.split("_"); // Exe.: idTab[0]
                    // Carregar arquivo em uma determinada DIV.
                    $("#topProgressBar").addClass("progress-bar-striped progress-bar-animated");
                    $(".scriptTargetReady").html("");
                    if (idTab[0] == "allScripts") {
                        var url = "<?= HOME . "/func/func.index.php?action=scriptTargetReadyAll&id=" ?>" + idTab[1];
                    } else if (idTab[0] == "scripts") {
                        var url = "<?= HOME . "/func/func.index.php?action=scriptTargetReadyAllSubTab&id=" ?>" + idTab[1];
                    } else if (idTab[0] != "scripts" && idTab[0] != "allScripts") {
                        var url = "<?= HOME . "/func/func.index.php?action=scriptTargetReady&id=" ?>" + idTab[0];
                    }
                    $.ajax({
                        url: url,
                        type: "GET", // Método GET
                        success: function(scriptTargetReady) {
                            $("#topProgressBar").removeClass("progress-bar-striped progress-bar-animated");
                            $(".scriptTargetReady").html(scriptTargetReady); // DIV de destino.
                        }
                    });
                }
                // Destacar a SubAba quando for clicada
                function subTabMenuItem(id) {
                    var idSubTab = id.split("_"); // Exe.: idSubTab[1]
                    // Destacar a SubAba clicada
                    if (idSubTab[0] == "scripts") {
                        $('.subTabMenuItem').removeClass('active');
                        $('#scripts_' + idSubTab[1]).addClass('active');
                    } else {
                        $('.subTabMenuItem').removeClass('active'); // Eliminar o destaque das SubAbas
                    }
                }
                // Função que centraliza a PopUp e/ou com dimessões definidas no link
                function openPopupLink(popurl, width, height) {
                    if (width !== "" && height !== "") {
                        var w = width;
                        var h = (height - 107);
                    } else {
                        var w = screen.width;
                        var h = (screen.height - 107);
                    }
                    var W = w;
                    var H = h;
                    var l = w / 2 - W / 2;
                    var t = h / 2 - H / 2;
                    winpops=window.open(popurl, "", "width=" + W + ", height=" + H + ", scrollbars, top=" + t + ", left=" + l + ", status");
                }
                // Ao cliente em um link do menu, limpar o Alvo do Script Pronto
                function clearScriptTarget(idTab) {
                    $(".scriptTargetReady").html("");
                    scriptTargetReady("allScripts_" + idTab);
                    $(window).scrollTop(0); // Rolar página indo pro topo
                    $('.subTabMenuItem').removeClass('active'); // Remover o destaque da SubAba quando for clicado em uma Aba
                }
            </script>
    </head>
    <body <?= $idAdmin == "deslogado" ? "onload='popUpWindow(`login`, `" . HOME . "/pages/login.php?page=logInUser`)'" : NULL ?>>
        <?php
        if ($idAdmin != "deslogado"):
        ?>
        <nav class="navbar navbar-dark bg-dark fixed-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="<?= HOME ?>"><?= $readyScriptsSettingsDB['page_title'] ?></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasNavbarLabel"><?= $readyScriptsSettingsDB['page_title'] ?></h5>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                            <div class="list-group">
                                <a href="<?= HOME ?>" class="list-group-item list-group-item-action list-group-item-secondary" aria-current="true">Home</a>
                                <a href="#" class="list-group-item list-group-item-action list-group-item-secondary">Configurações</a>
                                <a href="#" class="list-group-item list-group-item-action list-group-item-secondary">Abas e SubAbas</a>
                                <a href="#" class="list-group-item list-group-item-action list-group-item-secondary">links</a>
                            </div>
                            <li class="nav-item dropdown" style="margin: 0 0 15px 0">
                                <a class="nav-link dropdown-toggle list-group-item list-group-item-action list-group-item-secondary" href="#" id="offcanvasNavbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span style="color: #333; margin: 0 15px">Usuário</span>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="offcanvasNavbarDropdown">
                                    <li><a class="dropdown-item" href="#">Alterar dados</a></li>
                                    <li><a class="dropdown-item" href="#">Configurações do usuário</a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                    <li><a id="logOutOfThePage" onclick="popUpWindow(this.id, '<?= HOME . "/func/func.login.php?action=logOut" ?>')" class="dropdown-item" href="#">Sair</a></li>
                                </ul>
                            </li>
                        </ul>
                        <form class="d-flex">
                            <input class="form-control me-2" type="search" placeholder="Buscar..." aria-label="Search">
                            <button class="btn btn-outline-success" type="submit">Ir</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
        <div class="sticky-top">
            <div class="progress" style="border-radius: 0">
                <div id="topProgressBar" class="progress-bar bg-dark" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
            </div>
        </div>
        <div class="row" style="margin: 0; padding: 10px">
            <div class="col-sm-3">
                <div class="list-group tabList" id="list-tab" role="tablist">
                    <a class="list-group-item list-group-item-action active list-group-item-dark" id="list-home-list" data-bs-toggle="list" href="#list-home" role="tab" aria-controls="list-home">Home</a>
                    <?php
                    // Selecionar e recuperar os dados de "Scripts Prontos - Tabs"
                    $Read->FullRead("SELECT * FROM $CSReadyScriptsTabs WHERE primary_email = '{$primary_email}' ORDER BY name ASC");
                    if ($Read->getResult()):
                        foreach ($Read->getResult() as $readyScriptsTabsDB):
                            // Selecionar e recuperar os dados de "Links de Scripts Prontos" para contar os registros
                            $Read->ExeRead($CSReadyScriptsLinks, "WHERE tab = :tab", "tab={$readyScriptsTabsDB['id']}");
                            $countLinks = $Read->getRowCount();
                            echo "
                    <a class='list-group-item list-group-item-action list-group-item-secondary list-group-item d-flex justify-content-between align-items-start' id='list-{$readyScriptsTabsDB['slug']}-list' onclick='clearScriptTarget({$readyScriptsTabsDB['id']})' data-bs-toggle='list' href='#list-{$readyScriptsTabsDB['slug']}' role='tab' aria-controls='list-{$readyScriptsTabsDB['slug']}'>{$readyScriptsTabsDB['name']}
                        <span class='badge bg-primary rounded-pill'>{$countLinks}</span>
                    </a>
                            ";
                        endforeach;
                    endif;
                    ?>
                    <a class="list-group-item list-group-item-action list-group-item-secondary" id="list-aboutTheSystem-list" data-bs-toggle="list" href="#list-aboutTheSystem" role="tab" aria-controls="list-aboutTheSystem"><i class="fas fa-info-circle"></i> Sobre o sistema</a>
                    <a id="tabForm" onclick="popUpWindow(this.id, '<?= HOME . '/pages/tabForm.php?page=tabRecordForm' ?>')" class="list-group-item list-group-item-action list-group-item-dark" href="#"><i class="fas fa-folder-plus"></i> Adicionar nova Aba...</a>
                </div>
            </div>
            <div class="col-sm-9">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
                        <div class="card mb-3" style="max-width: 100%;">
                            <div class="row g-0">
                                <div class="col-md-8">
                                    <?php include './includes/carousel.php'; ?>
                                </div>
                                <div class="col-md-4">
                                    <div class="card-body">
                                        <?php
                                        // Selecionar e recuperar os dados de "Links de Scripts Prontos" para contar os hospedados
                                        $Read->FullRead("SELECT * FROM {$CSReadyScriptsLinks} WHERE primary_email = '{$primary_email}' AND link_location = 'hosted'");
                                        $quantityOfScripts = $Read->getRowCount();

                                        // Selecionar e recuperar os dados de "Links de Scripts Prontos" para contar links externos
                                        $Read->FullRead("SELECT * FROM {$CSReadyScriptsLinks} WHERE primary_email = '{$primary_email}' AND link_location = 'external'");
                                        $quantityOfLinks = $Read->getRowCount();
                                        ?>
                                        <h5 class="card-title"><?= $readyScriptsSettingsDB['page_title'] . "<br>Scripts: <strong>" . $quantityOfScripts . "</strong><br>Links externos: <strong>{$quantityOfLinks}</strong><br>Total de itens: <strong>" . ($quantityOfScripts + $quantityOfLinks) . "</strong>" ?></h5>
                                        <p class="card-text"><?= $readyScriptsSettingsDB['about'] ?></p>
                                        <p class="card-text"><small class="text-muted"><?= "&copy; " . $readyScriptsSettingsDB['copyright'] ?></small></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    // Selecionar e recuperar os dados de "Scripts Prontos - Tabs"
                    $Read->FullRead("SELECT * FROM $CSReadyScriptsTabs WHERE primary_email = '{$primary_email}' ORDER BY name ASC");
                    if ($Read->getResult()):
                        foreach ($Read->getResult() as $readyScriptsTabsDB):
                            echo "
                    <div class='tab-pane fade' id='list-{$readyScriptsTabsDB['slug']}' role='tabpanel' aria-labelledby='list-{$readyScriptsTabsDB['slug']}-list'>
                        <div class='container' style='padding: 0'>
                            <div class='row'>
                                <div class='col-sm-3'>
                                    <div class='list-group'>
                                        <button id='allScripts_{$readyScriptsTabsDB['id']}' onclick='scriptTargetReady(this.id), subTabMenuItem(this.id)' type='button' class='list-group-item list-group-item-action list-group-item-secondary d-flex justify-content-between align-items-start subTabMenuItem'>
                                            Todos os links&nbsp;
                                            <i class='fa-solid fa-table-cells'></i>
                                        </button>
                            ";
                            // Selecionar e recuperar os dados de "Scripts Prontos - Links"
                            $Read->FullRead("SELECT * FROM {$CSReadyScriptsSubTabs} WHERE primary_email = '{$primary_email}' AND tab = '{$readyScriptsTabsDB['id']}' ORDER BY name ASC");
                            if ($Read->getResult()):
                                foreach ($Read->getResult() as $readyScriptsSubTabsDB):
                                    echo "
                                        <button id='scripts_{$readyScriptsSubTabsDB['id']}' onclick='scriptTargetReady(this.id), subTabMenuItem(this.id)' type='button' class='list-group-item list-group-item-action list-group-item-secondary d-flex justify-content-between align-items-start subTabMenuItem'>
                                            " . shortenTextByWords($readyScriptsSubTabsDB['name'], 20) . "&nbsp;
                                            <i class='fa-solid fa-earth-americas'></i>
                                        </button>
                                    ";
                                endforeach;
                            endif;
                            echo "
                                        <button id='subTabForm' onclick='popUpWindow(this.id, `" . HOME . "/pages/tabForm.php?page=subTabRecordForm&id={$readyScriptsTabsDB['id']}`), subTabMenuItem(this.id)' type='button' class='list-group-item list-group-item-action list-group-item-secondary align-items-start'>
                                            <i class='fas fa-folder-plus'></i> Nova SubAba...
                                        </button>
                                    </div>
                                    <div class='btn-group editOrDeleteTab' role='group' aria-label='Basic mixed styles example'>
                                        <button type='button' id='tabForm' onclick='popUpWindow(this.id, `" . HOME . "/pages/tabForm.php?page=tabEditForm&id={$readyScriptsTabsDB['id']}`)' class='btn btn-primary'><i class='fas fa-edit'></i> Editar</button>
                                        <button type='button' id='deleteTab' onclick='popUpWindow(this.id, `" . HOME . "/pages/tabForm.php?page=deleteTab&id={$readyScriptsTabsDB['id']}`)' class='btn btn-danger'><i class='fas fa-trash-alt'></i> Excluir</button>
                                    </div>
                                </div>
                                <div class='col-sm-9 scriptTargetReady'></div>
                            </div>
                        </div>
                    </div>
                            ";
                        endforeach;
                    endif;
                    ?>
                    <div class="tab-pane fade show" id="list-aboutTheSystem" role="tabpanel" aria-labelledby="list-aboutTheSystem-list">
                        <h1>A construir...</h1>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botão para ir ao topo -->
        <style>
            .scrollButtton {
                display: none;
            }
            .scrollButtton:before {
                content: '⬆';
                color: rgba(255,255,255,.6);
                font: normal 40px 'dashicons';
                -webkit-font-smoothing: antialiased;

                background-color: rgba(0, 0, 0, 0.35);
                border-radius: 4px;
                position: fixed;
                padding: 0 7px;
                right: 20px;
                bottom: 20px;
                cursor: pointer;
                z-index: 999;

                display: flex;
                justify-content: center;
                align-items: center;
            }
        </style>
        <script>
            // Create the div on the main screen and add the elements and show it on the screen
            let divEl = document.createElement('div')
            divEl.classList.add('scrollButtton')
            divEl.addEventListener('click', topScreen)
            document.querySelector('body').appendChild(divEl)

            // Up to top the page
            function topScreen() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                })
            }

            // Show or hide button on screen
            function scrollButton() {
                if (window.scrollY === 0) {
                    /* Hide button */
                    document.querySelector('.scrollButtton').style.display = 'none'
                } else {
                    /* show button */
                    document.querySelector('.scrollButtton').style.display = 'block'
                }
            }

            /* Monitor page scroll */
            window.addEventListener('scroll', scrollButton);
        </script>
        <!-- /Botão para ir ao topo -->
        <?php
        endif;
        ?>
        <div id="retorno_sys" onclick="$('#retorno_sys').fadeOut()"></div>

        <!-- Máscaras nos campos com MeioMask -->
        <script src="<?= HOME . "/js/meiomask.js" ?>"></script>
    </body>
</html>

