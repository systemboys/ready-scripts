<?php
require '../_app/Config.inc.php';
include '../includes/tables.php';
include '../func/otherFunctions.php';
include '../func/authentication.php';

$Read   = new Read;   // Consultar

// Selecionar e recuperar os dados de "Usuários".
$Read->ExeRead($CSReadyScriptsUser, "WHERE id = :id", "id={$idAdmin}");
foreach ($Read->getResult() as $readyScriptsUserDB): endforeach;
$primary_email = isset($readyScriptsUserDB['primary_email']) ? $readyScriptsUserDB['primary_email'] : NULL;

if (
    isset($_GET['page']) && $_GET['page'] == "tabRecordForm" ||
    isset($_GET['page']) && $_GET['page'] == "tabEditForm"
    ):
    $id = isset($_GET['id']) ? $_GET['id'] : NULL; // ID da Aba

    // Selecionar e recuperar os dados de "Abas".
    $Read->ExeRead($CSReadyScriptsTabs, "WHERE id = :id", "id={$id}");
    foreach ($Read->getResult() as $readyScriptsTabsDB): endforeach;
?>
        <style>
            /* mobile */
            @media (max-width: 420px) {
                .tabForm {
                    max-width: 100%;
                }
            }
            .tabForm {
                position: fixed;
                background: #e1e1e1 !important;
                width: 350px;
                top: 50%;
                left: 50%;
                box-shadow: -1px 10px 15px rgba(0,0,0,.6);
                transform: translate(-50%, -50%);
                z-index: 9999;
            }
            .tabForm .tabFormClose {
                position: absolute;
                top: 2px;
                right: 2px;
                color: #0d6efd;
                cursor: pointer;
            }
        </style>
        <div class="tabForm card mb-3">
            <i class="fas fa-window-close tabFormClose closeTabRecord"></i>
            <img src="<?= HOME . "/pic/this-page/background-top-notebook.png" ?>" class="card-img-top" alt="...">
            <div class="card-body">
                <!-- jQuery.Form -->
                <script src="<?= HOME . "/js/jquery.form.js" ?>"></script>
                <!-- Fechar o formulário ao clicar em "Cancelar". -->
                <script>
                    $(document).ready(function() {
                        //Ao clicar no objeto com id="box", executa a função.
                        $(".closeTabRecord").click(function() {
                            $("#popupPg1_tabForm").remove();
                        });
                    });
                </script>
                <!-- /Fechar o formulário ao clicar em "Cancelar". -->
                <!-- SUBMIT A VIA AJAX FORM -->
                <script>
                    $(document).ready(function () {
                        // Enviar formulário via ajax
                        $("#myFormTab").submit(function () {
                            var options = {
                                target: "#retorno_sys",
                                beforeSubmit: showRequest, // Exibir o preload
                                url: "<?= ($_GET['page'] == "tabRecordForm") ? HOME . "/func/func.tabForm.php?action=tabRecordForm" : HOME . "/func/func.tabForm.php?action=tabEditForm&id={$id}" ?>", // Arquivo de destino
                                type: "POST", // Método POST
                                resetForm: false // Não resetar o formulário
                            };
                            $("#myFormTab").fadeTo("slow", 0.3); // Nível de efeito fade no formulário
                            $(this).ajaxSubmit(options);
                            function showRequest(formData, jqForm, options) {
                                $("#retorno_sys").fadeIn("slow").html("<div id='loadSys'>Processando...</div>");
                            }
                            $("#myFormTab").fadeTo("slow", 1);
                            return false;
                        });
                    });
                </script>
                <!-- END, SUBMIT A VIA AJAX FORM -->
                <!-- <h5 class="card-title">Entre com suas credenciais</h5> -->
                <form action="javascript:func()" id="myFormTab" name="myFormTab" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome da Aba</label>
                        <input type="text" class="form-control inputNameForm" id="name" name="name"<?= $_GET['page'] == "tabEditForm" ? " value=\"{$readyScriptsTabsDB['name']}\"" : NULL ?> placeholder="Um nome para a nova Aba...">
                    </div>
                    <button type="submit" class="btn btn-primary"><?= $_GET['page'] == "tabRecordForm" ? "Registrar" : "Atualizar" ?></button>
                    <button type="button" id="closeTabRecord" class="btn btn-secondary closeTabRecord">Cancelar</button>
                </form>
            </div>
        </div>
    <?php
elseif (isset($_GET['page']) && $_GET['page'] == "deleteTab"):
    $id = isset($_GET['id']) ? $_GET['id'] : NULL; // ID da Aba

    // Selecionar e recuperar os dados de "Abas".
    $Read->ExeRead($CSReadyScriptsTabs, "WHERE id = :id", "id={$id}");
    foreach ($Read->getResult() as $readyScriptsTabsDB): endforeach;
?>
        <style>
            /* mobile */
            @media (max-width: 420px) {
                .tabForm {
                    max-width: 100%;
                }
            }
            .tabForm {
                position: fixed;
                background: #e1e1e1 !important;
                width: 350px;
                top: 50%;
                left: 50%;
                box-shadow: -1px 10px 15px rgba(0,0,0,.6);
                transform: translate(-50%, -50%);
                z-index: 9999;
            }
            .tabForm .tabFormClose {
                position: absolute;
                top: 2px;
                right: 2px;
                color: #0d6efd;
                cursor: pointer;
            }
        </style>
        <div class="tabForm card mb-3">
            <i class="fas fa-window-close tabFormClose closeTabRecord"></i>
            <img src="<?= HOME . "/pic/this-page/red-alert.png" ?>" class="card-img-top" alt="...">
            <div class="card-body">
                <!-- jQuery.Form -->
                <script src="<?= HOME . "/js/jquery.form.js" ?>"></script>
                <!-- Fechar o formulário ao clicar em "Cancelar". -->
                <script>
                    $(document).ready(function() {
                        // Ao clicar no objeto com id="box", executa a função.
                        $(".closeTabRecord").click(function() {
                            $("#popupPg1_deleteTab").remove();
                        });
                    });
                </script>
                <!-- /Fechar o formulário ao clicar em "Cancelar". -->
                <!-- SUBMIT A VIA AJAX FORM -->
                <script>
                    $(document).ready(function () {
                        // Enviar formulário via ajax
                        $("#myFormDeleteTab").submit(function () {
                            var options = {
                                target: "#retorno_sys",
                                beforeSubmit: showRequest, // Exibir o preload
                                url: "<?= HOME . "/func/func.tabForm.php?action=deleteTab&id={$id}" ?>", // Arquivo de destino
                                type: "POST", // Método POST
                                resetForm: false // Não resetar o formulário
                            };
                            $("#myFormDeleteTab").fadeTo("slow", 0.3); // Nível de efeito fade no formulário
                            $(this).ajaxSubmit(options);
                            function showRequest(formData, jqForm, options) {
                                $("#retorno_sys").fadeIn("slow").html("<div id='loadSys'>Processando...</div>");
                            }
                            $("#myFormDeleteTab").fadeTo("slow", 1);
                            return false;
                        });
                    });
                </script>
                <!-- END, SUBMIT A VIA AJAX FORM -->
                <h5 class="card-title">Quer mesmo excluir esta Aba?</h5>
                <form action="javascript:func()" id="myFormDeleteTab" name="myFormDeleteTab" method="post" enctype="multipart/form-data">
                    <p><i class="fas fa-exclamation-triangle" style="color: #f90"></i> <small style="color: #f00">Cuidado, você irá apagar tudo que contém na aba "<strong><?= $readyScriptsTabsDB['name'] ?></strong>": SubAbas e Links!</small></p>
                    <button type="submit" class="btn btn-danger">Sim</button>
                    <button type="button" id="closeTabRecord" class="btn btn-secondary closeTabRecord">Não</button>
                </form>
            </div>
        </div>
    <?php
elseif (
    isset($_GET['page']) && $_GET['page'] == "subTabRecordForm" ||
    isset($_GET['page']) && $_GET['page'] == "subTabEditForm"
    ):
    $idTab    = $_GET['page'] == "subTabRecordForm" ? $_GET['id'] : $_GET['idTab']; // ID da Aba
    $idSubTab = isset($_GET['idSubTab']) ? $_GET['idSubTab'] : NULL; // ID da SubAba

    // Selecionar e recuperar os dados de "Abas".
    $Read->ExeRead($CSReadyScriptsSubTabs, "WHERE id = :id", "id={$idSubTab}");
    foreach ($Read->getResult() as $readyScriptsSubTabsDB): endforeach;
    ?>
        <style>
            /* mobile */
            @media (max-width: 420px) {
                .subTabForm {
                    max-width: 100%;
                }
            }
            .subTabForm {
                position: fixed;
                background: #e1e1e1 !important;
                width: 350px;
                top: 50%;
                left: 50%;
                box-shadow: -1px 10px 15px rgba(0,0,0,.6);
                transform: translate(-50%, -50%);
                z-index: 9999;
            }
            .subTabForm .subTabFormClose {
                position: absolute;
                top: 2px;
                right: 2px;
                color: #0d6efd;
                cursor: pointer;
            }
        </style>
        <div class="subTabForm card mb-3">
            <i class="fas fa-window-close subTabFormClose closeSubTabRecord"></i>
            <img src="<?= HOME . "/pic/this-page/background-top-notebook.png" ?>" class="card-img-top" alt="...">
            <div class="card-body">
                <!-- jQuery.Form -->
                <script src="<?= HOME . "/js/jquery.form.js" ?>"></script>
                <!-- Fechar o formulário ao clicar em "Cancelar". -->
                <script>
                    $(document).ready(function() {
                        //Ao clicar no objeto com id="box", executa a função.
                        $(".closeSubTabRecord").click(function() {
                            $("#popupPg1_subTabForm").remove();
                        });
                    });
                </script>
                <!-- /Fechar o formulário ao clicar em "Cancelar". -->
                <!-- SUBMIT A VIA AJAX FORM -->
                <script>
                    $(document).ready(function () {
                        // Enviar formulário via ajax
                        $("#myFormSubTab").submit(function () {
                            var options = {
                                target: "#retorno_sys",
                                beforeSubmit: showRequest, // Exibir o preload
                                url: "<?= ($_GET['page'] == "subTabRecordForm") ? HOME . "/func/func.tabForm.php?action=subTabRecordForm&idTab={$idTab}" : HOME . "/func/func.tabForm.php?action=subTabEditForm&idTab={$idTab}&idSubTab={$readyScriptsSubTabsDB['id']}" ?>", // Arquivo de destino
                                type: "POST", // Método POST
                                resetForm: false // Não resetar o formulário
                            };
                            $("#myFormSubTab").fadeTo("slow", 0.3); // Nível de efeito fade no formulário
                            $(this).ajaxSubmit(options);
                            function showRequest(formData, jqForm, options) {
                                $("#retorno_sys").fadeIn("slow").html("<div id='loadSys'>Processando...</div>");
                            }
                            $("#myFormSubTab").fadeTo("slow", 1);
                            return false;
                        });
                    });
                </script>
                <!-- END, SUBMIT A VIA AJAX FORM -->
                <!-- <h5 class="card-title">Entre com suas credenciais</h5> -->
                <form action="javascript:func()" id="myFormSubTab" name="myFormSubTab" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome da SubAba</label>
                        <input type="text" class="form-control inputNameForm" id="name" name="name"<?= $_GET['page'] == "subTabEditForm" ? " value=\"{$readyScriptsSubTabsDB['name']}\"" : NULL ?> placeholder="Um nome para a nova SubAba...">
                    </div>
                    <button type="submit" class="btn btn-primary"><?= $_GET['page'] == "subTabRecordForm" ? "Registrar" : "Atualizar" ?></button>
                    <button type="button" id="closeSubTabRecord" class="btn btn-secondary closeSubTabRecord">Cancelar</button>
                </form>
            </div>
        </div>
    <?php
elseif (isset($_GET['page']) && $_GET['page'] == "deleteSubTab"):
    $id = isset($_GET['id']) ? $_GET['id'] : NULL; // ID da SubAba

    // Selecionar e recuperar os dados de "SubAbas".
    $Read->ExeRead($CSReadyScriptsSubTabs, "WHERE id = :id", "id={$id}");
    foreach ($Read->getResult() as $readyScriptsSubTabsDB): endforeach;
?>
        <style>
            /* mobile */
            @media (max-width: 420px) {
                .tabForm {
                    max-width: 100%;
                }
            }
            .tabForm {
                position: fixed;
                background: #e1e1e1 !important;
                width: 350px;
                top: 50%;
                left: 50%;
                box-shadow: -1px 10px 15px rgba(0,0,0,.6);
                transform: translate(-50%, -50%);
                z-index: 9999;
            }
            .tabForm .tabFormClose {
                position: absolute;
                top: 2px;
                right: 2px;
                color: #0d6efd;
                cursor: pointer;
            }
        </style>
        <div class="tabForm card mb-3">
            <i class="fas fa-window-close tabFormClose closeSubTabRecord"></i>
            <img src="<?= HOME . "/pic/this-page/red-alert.png" ?>" class="card-img-top" alt="...">
            <div class="card-body">
                <!-- jQuery.Form -->
                <script src="<?= HOME . "/js/jquery.form.js" ?>"></script>
                <!-- Fechar o formulário ao clicar em "Cancelar". -->
                <script>
                    $(document).ready(function() {
                        //Ao clicar no objeto com id="box", executa a função.
                        $(".closeSubTabRecord").click(function() {
                            $("#popupPg1_deleteSubTab").remove();
                        });
                    });
                </script>
                <!-- /Fechar o formulário ao clicar em "Cancelar". -->
                <!-- SUBMIT A VIA AJAX FORM -->
                <script>
                    $(document).ready(function () {
                        // Enviar formulário via ajax
                        $("#myFormDeleteSubTab").submit(function () {
                            var options = {
                                target: "#retorno_sys",
                                beforeSubmit: showRequest, // Exibir o preload
                                url: "<?= HOME . "/func/func.tabForm.php?action=deleteSubTab&id={$id}" ?>", // Arquivo de destino
                                type: "POST", // Método POST
                                resetForm: false // Não resetar o formulário
                            };
                            $("#myFormDeleteSubTab").fadeTo("slow", 0.3); // Nível de efeito fade no formulário
                            $(this).ajaxSubmit(options);
                            function showRequest(formData, jqForm, options) {
                                $("#retorno_sys").fadeIn("slow").html("<div id='loadSys'>Processando...</div>");
                            }
                            $("#myFormDeleteSubTab").fadeTo("slow", 1);
                            return false;
                        });
                    });
                </script>
                <!-- END, SUBMIT A VIA AJAX FORM -->
                <h5 class="card-title">Quer mesmo excluir esta SubAba?</h5>
                <form action="javascript:func()" id="myFormDeleteSubTab" name="myFormDeleteSubTab" method="post" enctype="multipart/form-data">
                    <p><i class="fas fa-exclamation-triangle" style="color: #f90"></i> <small style="color: #f00">Cuidado, você irá apagar tudo que contém na aba "<strong><?= $readyScriptsSubTabsDB['name'] ?></strong>": Os Links!</small></p>
                    <button type="submit" class="btn btn-danger">Sim</button>
                    <button type="button" id="closeSubTabRecord" class="btn btn-secondary closeSubTabRecord">Não</button>
                </form>
            </div>
        </div>
    <?php
elseif (
    isset($_GET['page']) && $_GET['page'] == "addLink" ||
    isset($_GET['page']) && $_GET['page'] == "editLink"
    ):
    // Obtendo os ID's das Abas, SubAbas e Links
    $idTab    = $_GET['page'] == "addLink" ? table($CSReadyScriptsSubTabs, "tab", "WHERE id = '{$_GET['idSubTab']}'") : table($CSReadyScriptsLinks,"tab", "WHERE id = '{$_GET['id']}'"); // ID da Aba obtido via GET
    $idSubTab = $_GET['page'] == "addLink" ? $_GET['idSubTab'] : table($CSReadyScriptsLinks, "subtabs", "WHERE id = '{$_GET['id']}'"); // ID da SubAba obitido via GET
    $idLink   = isset($_GET['id']) ? $_GET['id'] : NULL; // ID do Link obitido via GET

    // Selecionar e recuperar os dados de "Links".
    $Read->ExeRead($CSReadyScriptsLinks, "WHERE id = :id", "id={$idLink}");
    foreach ($Read->getResult() as $readyScriptsLinksDB): endforeach;
    ?>
        <style>
            /* mobile */
            @media (max-width: 420px) {
                .linksForm {
                    max-width: 100%;
                }
            }
            .linksForm {
                position: fixed;
                background: #e1e1e1 !important;
                width: 700px;
                height: 500px;
                top: 50%;
                left: 50%;
                box-shadow: -1px 10px 15px rgba(0,0,0,.6);
                transform: translate(-50%, -50%);
                overflow-y: scroll;
                z-index: 9999;
            }
            .linksForm .closeLinkRecord {
                position: absolute;
                top: 2px;
                right: 20px;
                color: #0d6efd;
                opacity: 50%;
                transition-duration: 0.5s;
                font-size: 2em;
                cursor: pointer;
            }
            .linksForm .closeLinkRecord:hover {
                opacity: 80%;
                transition-duration: 0.5s;
            }
            /* Alertas do campo do Linkda imagem */
            .alert_getVideoCoverOnYouTube {
                position: fixed;
                background: #e1e1e1 !important;
                margin: 0;
                padding: 10px 0;
                top: 50%;
                left: 50%;
                border-radius: 5px;
                box-shadow: -1px 10px 15px rgba(0,0,0,.6);
                transform: translate(-50%, -50%);
                z-index: 9999;
            }
            .alert_getVideoCoverOnYouTube h1 {
                background: #ededed;
                text-align: center;
                margin: 0;
                padding: 0 10px;
            }
            .alert_getVideoCoverOnYouTube p {
                background: #f7f7f7;
                text-align: center;
                margin: 0;
                padding: 0 10px;
            }
            .alert_getVideoCoverOnYouTube .fa-exclamation-triangle {
                color: #f90;
            }
            .alert_getVideoCoverOnYouTube .YouTube_text_logo {
                background: #000;
                margin: 0;
                padding: 2px 5px;
                border-radius: 5px;
                color: #fff;
                font-weight: bold;
            }
            .alert_getVideoCoverOnYouTube .thumbnailBox {
                margin: 0 5px 0 0;
            }
            .alert_getVideoCoverOnYouTube .thumbnailBox .thumbnailBox_FrontCover span {
                position: absolute;
                background: rgba(0,0,0,.75);
                margin: 5px;
                padding: 1px 5px;
                border-radius: 3px;
                color: #fff;
                text-shadow: -1px 1px 2px #000;
                z-index: 1;
            }
            .alert_getVideoCoverOnYouTube .thumbnailBox .thumbnailBox_FrontCover img {
                opacity: 80%;
                transition-duration: 0.5s;
                margin: 2px;
                border-radius: 5px;
            }
            .alert_getVideoCoverOnYouTube .thumbnailBox .thumbnailBox_FrontCover img:hover {
                opacity: 100%;
                transition-duration: 0.5s;
                cursor: pointer;
            }
            .alert_getVideoCoverOnYouTube .closeLinkPopup {
                position: absolute;
                top: 15px;
                right: 18px;
                color: #f00;
                opacity: 50%;
                transition-duration: 0.5s;
                font-size: 2em;
                cursor: pointer;
            }
            .alert_getVideoCoverOnYouTube .closeLinkPopup:hover {
                opacity: 80%;
                transition-duration: 0.5s;
            }
            /* /Alertas do campo do Linkda imagem */
        </style>
        <div class="linksForm card mb-3">
            <i class="fas fa-window-close closeFormLinks closeLinkRecord" title="Fechar"></i>
            <img src="<?= HOME . "/pic/this-page/background-top-notebook.png" ?>" class="card-img-top" alt="...">
            <div class="card-body">
                <!-- jQuery.Form -->
                <script src="<?= HOME . "/js/jquery.form.js" ?>"></script>
                <!-- Fechar o formulário ao clicar em "Cancelar". -->
                <script>
                    $(document).ready(function() {
                        //Ao clicar no objeto com id="box", executa a função.
                        $(".closeFormLinks").click(function() {
                            $("#popupPg1_formLink").remove();
                        });
                    });
                </script>
                <!-- /Fechar o formulário ao clicar em "Cancelar". -->
                <!-- SUBMIT A VIA AJAX FORM -->
                <script>
                    $(document).ready(function () {
                        // Enviar formulário via ajax
                        $("#myFormLinks").submit(function () {
                            // CKEditor
                            for ( instance in CKEDITOR.instances ) {
                                CKEDITOR.instances[instance].updateElement();
                            }
                            // /CKEditor
                            var options = {
                                target: "#retorno_sys",
                                beforeSubmit: showRequest, // Exibir o preload
                                url: "<?= ($_GET['page'] == "addLink") ? HOME . "/func/func.tabForm.php?action=addLink&idTab={$idTab}&idSubTab={$idSubTab}" : HOME . "/func/func.tabForm.php?action=editLink&idTab={$idTab}&idSubTab={$idSubTab}&idLink={$idLink}" ?>", // Arquivo de destino
                                type: "POST", // Método POST
                                resetForm: false // Não resetar o formulário
                            };
                            $("#myFormLinks").fadeTo("slow", 0.3); // Nível de efeito fade no formulário
                            $(this).ajaxSubmit(options);
                            function showRequest(formData, jqForm, options) {
                                $("#retorno_sys").fadeIn("slow").html("<div id='loadSys'>Processando...</div>");
                            }
                            $("#myFormLinks").fadeTo("slow", 1);
                            return false;
                        });
                    });
                </script>
                <!-- END, SUBMIT A VIA AJAX FORM -->
                <script>
                    //JQUERY MEIO MASK 
                    $(function() {
                        jQuery(function($) {
                            $("#hour").setMask('time-2');
                            $("#date").setMask('date');
                        });
                    });
                </script>
                <!-- CKEditor -->
                <script src="<?= HOME . "/plugins/ckeditor/ckeditor.js" ?>"></script>
                <script src="<?= HOME . "/plugins/ckeditor/samples/js/sample.js" ?>"></script>
                <script>
                    // Definição do textárea
                    CKEDITOR.replace("about");

                    // Iniciar o plugin
                    initSample();
                </script>
                <!-- /CKEditor -->
                <!-- Action for your selection -->
                <script>
                    $(function () {
                        $("select[name=link_target]").change(function () {
                            var link = $("select[name=link_target]").val();

                            // Limpar os campos da PopUp
                            document.getElementById("popup_width").value="";
                            document.getElementById("popup_height").value="";
                            
                            if (link == "_blank") {
                                // Ocultar os campos de "Largura" e "Altura" da PopUp.
                                $(".popupWidthField").css({"display": "none"});
                                $(".popupHeightField").css({"display": "none"});

                                // Tamanho do campo "Nome / botão".
                                $(".nameLinkField").removeClass("col-sm-4");
                                $(".nameLinkField").addClass("col-sm-6");

                                // Tamanho do campo "Alvo do Link".
                                $(".targetLinkField").removeClass("col-sm-4");
                                $(".targetLinkField").addClass("col-sm-6");
                            } else if (link == "popup") {
                                // Exibir os campos de "Largura" e "Altura" da PopUp.
                                $(".popupWidthField").css({"display": "block"});
                                $(".popupHeightField").css({"display": "block"});
                                
                                // Tamanho do campo "Nome / botão".
                                $(".nameLinkField").removeClass("col-sm-6");
                                $(".nameLinkField").addClass("col-sm-4");
                                
                                // Tamanho do campo "Alvo do Link".
                                $(".targetLinkField").removeClass("col-sm-6");
                                $(".targetLinkField").addClass("col-sm-4");
                            }
                        });
                    });
                </script>
                <!-- /Action for your selection -->
                <form action="javascript:func()" id="myFormLinks" name="myFormLinks" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="mb-3 col-sm-6">
                            <label for="name" class="form-label">Aba</label>
                            <!-- Bring list in the list field -->
                            <script>
                                $(function () {
                                    $("select[name=tab]").change(function () {
                                        var tab = $("select[name=tab]").val();
                                        if (tab !== "") {
                                            $(".listReturn").html("<option value=''>Carregando...</option>");
                                            document.myFormLinks.subTab.disabled = false; // Enable
                                            var url = "<?= HOME . "/func/func.tabForm.php?action=subTab&tab=\" + tab + \"" ?>";
                                            $.get(url, function (dataReturn) {
                                                $(".listReturn").html(dataReturn);
                                            });
                                        } else {
                                            $(".listReturn").html("<option value=''>&raquo; Selecione &laquo;</option>");
                                            document.myFormLinks.subTab.disabled = true; // Disable
                                        }
                                    });
                                });
                            </script>
                            <!-- /Bring list in the list field -->
                            <select id="tab" name="tab" class="form-select" size="3" aria-label="size 3 select example">
                                <?php
                                // Selecionar e recuperar os dados de "Abas".
                                $Read->FullRead("SELECT * FROM {$CSReadyScriptsTabs} WHERE primary_email = '{$primary_email}' ORDER BY name ASC");
                                if ($Read->getResult()):
                                    foreach ($Read->getResult() as $readyScriptsTabsDB):
                                        echo "<option value='{$readyScriptsTabsDB['id']}'" . ($readyScriptsTabsDB['id'] == $idTab ? " selected" : NULL) . ">{$readyScriptsTabsDB['name']}</option>";
                                    endforeach;
                                endif;
                                ?>
                            </select>
                        </div>
                        <div class="mb-3 col-sm-6">
                            <label for="name" class="form-label">SubAba</label>
                            <select id="subTab" name="subTab" class="form-select listReturn" size="3" aria-label="size 3 select example">
                                <?php
                                // Selecionar e recuperar os dados de "SubTabs".
                                $Read->FullRead("SELECT * FROM {$CSReadyScriptsSubTabs} WHERE primary_email = '{$primary_email}' AND tab = '{$idTab}' ORDER BY name ASC");
                                if ($Read->getResult()):
                                    foreach ($Read->getResult() as $readyScriptsSubTabsDB):
                                        echo "<option value='{$readyScriptsSubTabsDB['id']}'" . ($readyScriptsSubTabsDB['id'] == $idSubTab ? " selected" : NULL) . ">{$readyScriptsSubTabsDB['name']}</option>";
                                    endforeach;
                                endif;
                                ?>
                            </select>
                        </div>
                        <div class="mb-3 col-sm-9">
                            <label for="name" class="form-label">Nome do Link</label>
                            <input type="text" class="form-control inputNameForm" id="name" name="name"<?= $_GET['page'] == "editLink" ? " value=\"{$readyScriptsLinksDB['name']}\"" : NULL ?> placeholder="Um nome para o Link...">
                        </div>
                        <div class="mb-3 col-sm-3">
                            <label for="classification" class="form-label">Classificação</label>
                            <select id="classification" name="classification" class="form-select" aria-label="Default select example">
                                <option value="0.0"<?= $_GET['page'] == "editLink" && $readyScriptsLinksDB['classification'] == "0.0" ? " selected" : NULL ?>>0.0 estrela</option>
                                <option value="0.5"<?= $_GET['page'] == "editLink" && $readyScriptsLinksDB['classification'] == "0.5" ? " selected" : NULL ?>>0.5 estrela</option>
                                <option value="1.0"<?= $_GET['page'] == "editLink" && $readyScriptsLinksDB['classification'] == "1.0" ? " selected" : NULL ?>>1.0 estrela</option>
                                <option value="1.5"<?= $_GET['page'] == "editLink" && $readyScriptsLinksDB['classification'] == "1.5" ? " selected" : NULL ?>>1.5 estrela</option>
                                <option value="2.0"<?= $_GET['page'] == "editLink" && $readyScriptsLinksDB['classification'] == "2.0" ? " selected" : NULL ?>>2.0 estrela</option>
                                <option value="2.5"<?= $_GET['page'] == "editLink" && $readyScriptsLinksDB['classification'] == "2.5" ? " selected" : NULL ?>>2.5 estrela</option>
                                <option value="3.0"<?= $_GET['page'] == "editLink" && $readyScriptsLinksDB['classification'] == "3.0" ? " selected" : NULL ?>>3.0 estrela</option>
                                <option value="3.5"<?= $_GET['page'] == "editLink" && $readyScriptsLinksDB['classification'] == "3.5" ? " selected" : NULL ?>>3.5 estrela</option>
                                <option value="4.0"<?= $_GET['page'] == "editLink" && $readyScriptsLinksDB['classification'] == "4.0" ? " selected" : NULL ?>>4.0 estrela</option>
                                <option value="4.5"<?= $_GET['page'] == "editLink" && $readyScriptsLinksDB['classification'] == "4.5" ? " selected" : NULL ?>>4.5 estrela</option>
                                <option value="5.0"<?= $_GET['page'] == "editLink" && $readyScriptsLinksDB['classification'] == "5.0" ? " selected" : NULL ?>>5.0 estrela</option>
                            </select>
                        </div>
                        <div class="mb-6 col-sm-12">
                            <label for="link" class="form-label">Link (Copie e cole a URL)</label>
                            <input type="text" class="form-control inputNameForm" id="link" name="link"<?= $_GET['page'] == "editLink" ? " value=\"{$readyScriptsLinksDB['link']}\"" : NULL ?> placeholder="https://www.site.com/">
                        </div>
                        <div class="mb-3 <?= $_GET['page'] == "addLink" || $readyScriptsLinksDB['link_target'] == "_blank" ? "col-sm-6" : "col-sm-4" ?> nameLinkField">
                            <label for="link_label" class="form-label">Nome / botão</label>
                            <input type="text" class="form-control inputNameForm" id="link_label" name="link_label"<?= $_GET['page'] == "editLink" ? " value=\"{$readyScriptsLinksDB['link_label']}\"" : NULL ?> placeholder="Acessar...">
                        </div>
                        <div class="mb-3 <?= $_GET['page'] == "addLink" || $readyScriptsLinksDB['link_target'] == "_blank" ? "col-sm-6" : "col-sm-4" ?> targetLinkField">
                            <label for="link_target" class="form-label">Alvo do Link</label>
                            <select id="link_target" name="link_target" class="form-select" aria-label="Default select example">
                                <option value="_blank"<?= $_GET['page'] == "editLink" && $readyScriptsLinksDB['link_target'] == "_blank" ? " selected" : NULL ?>>Nova página</option>
                                <option value="popup"<?= $_GET['page'] == "editLink" && $readyScriptsLinksDB['link_target'] == "popup" ? " selected" : NULL ?>>PopUp</option>
                            </select>
                        </div>
                        <div class="mb-3 col-sm-2 popupWidthField"<?= $readyScriptsLinksDB['link_target'] == "popup" ? NULL : " style='display: none'" ?>>
                            <label for="popup_width" class="form-label">Largura</label>
                            <input type="text" class="form-control inputNameForm" id="popup_width" name="popup_width"<?= $_GET['page'] == "editLink" ? " value=\"{$readyScriptsLinksDB['popup_width']}\"" : NULL ?> placeholder="800">
                        </div>
                        <div class="mb-3 col-sm-2 popupHeightField"<?= $readyScriptsLinksDB['link_target'] == "popup" ? NULL : " style='display: none'" ?>>
                            <label for="popup_height" class="form-label">Altura</label>
                            <input type="text" class="form-control inputNameForm" id="popup_height" name="popup_height"<?= $_GET['page'] == "editLink" ? " value=\"{$readyScriptsLinksDB['popup_height']}\"" : NULL ?> placeholder="600">
                        </div>
                        <div class="mb-3 col-sm-12">
                            <script>
                                // Enviar imagem para o campo
                                function sendToTheField(id) {
                                    var link = $("#link").val();
                                    // Explode do Link indicado
                                    var string = link;
                                    var linkReturnExplode = string.split("v=");
                                    var linkReturn = linkReturnExplode[1]; // ID do Link
                                    switch (id) {
                                        case "hqdefault":
                                            var videoLinkOnYouTube = "https://img.youtube.com/vi/" + linkReturn + "/hqdefault.jpg";
                                            break;
                                        case "mqdefault":
                                            var videoLinkOnYouTube = "https://img.youtube.com/vi/" + linkReturn + "/mqdefault.jpg";
                                            break;
                                        case "maxresdefault":
                                            var videoLinkOnYouTube = "https://img.youtube.com/vi/" + linkReturn + "/maxresdefault.jpg";
                                            break;
                                        default:
                                            var videoLinkOnYouTube = "";
                                    }
                                    document.getElementById("image").value=videoLinkOnYouTube;
                                    $('.alert_getVideoCoverOnYouTube').fadeOut();
                                }
                                // Limar o campo "Link da imagem"
                                $(".clearImageLinkField").click(function() {
                                    document.getElementById("image").value="";
                                });
                                $(document).ready(function() {
                                    // Ao clicar no objeto com id="searchGoogleImages", procurar no Google Imagens o que está digitado no campo "Nome do link".
                                    $("#searchGoogleImages").click(function() {
                                        var name = $("#name").val();
                                        var newName = name.split(" ").join("+"); // Substituir os espaçso " " por outro caractere.
                                        if (name != "") {
                                            window.open("https://www.google.com.br/search?q=" + newName + "&sxsrf=ALiCzsbMeZSVtG1phI4Rel_tIlF4WZjfig:1655921023170&source=lnms&tbm=isch&sa=X&ved=2ahUKEwjju_LC0sH4AhVWs5UCHSCpDtQQ_AUoAnoECAEQBA&biw=1366&bih=649&dpr=1", "_blank");
                                        } else {
                                            $("body").append("<div class='alert_getVideoCoverOnYouTube' style='width: 300px;'><i onclick='this.parentElement.style.display=`none`;' class='fas fa-window-close closeLinkPopup' title='Fechar'></i><h1><i class='fas fa-exclamation-triangle'></i>Ops!</h1><p>O campo \"Nome do Link\" está vazio! </p></div>");
                                        }
                                    });
                                    $("#getVideoCoverOnYouTube").click(function() {
                                        var link = $("#link").val();
                                        if (link != "") {
                                            // Verificar se existe o trecho "youtube" no Link
                                            var currentUrl = link;
                                            if (currentUrl.includes("youtube")) {
                                                // Explode do Link indicado
                                                var string = link;
                                                var linkReturnExplode = string.split("v=");
                                                var linkReturn = linkReturnExplode[1];
                                                $("body").append("<div class='alert_getVideoCoverOnYouTube' style='overflow: scroll; width: 300px; height: 400px;'><i onclick='this.parentElement.style.display=`none`;' class='fas fa-window-close closeLinkPopup' title='Fechar'></i><h1><i class='fas fa-exclamation-triangle'></i>Ops!</h1><p>Cabas do vídeo do <span class='YouTube_text_logo'><i class='fab fa-youtube' style='color: #f00'></i> YouTube</span> encontradas, clique em uma delas!</p><div class='thumbnailBox'><div class='thumbnailBox_FrontCover'><span>Média (480 x 360)</span><img id='hqdefault' onclick='sendToTheField(this.id)' src='https://img.youtube.com/vi/" + linkReturn + "/hqdefault.jpg' class='img-fluid' alt='...'></div><div class='thumbnailBox_FrontCover'><span>Média (320 x 180)</span><img id='mqdefault' onclick='sendToTheField(this.id)' src='https://img.youtube.com/vi/" + linkReturn + "/mqdefault.jpg' class='img-fluid' alt='...'></div><div class='thumbnailBox_FrontCover'><span>Média (1280 x 720)</span><img id='maxresdefault' onclick='sendToTheField(this.id)' src='https://img.youtube.com/vi/" + linkReturn + "/maxresdefault.jpg' class='img-fluid' alt='...'></div></div></div>");
                                            } else {
                                                $("body").append("<div class='alert_getVideoCoverOnYouTube' style='width: 300px;'><i onclick='this.parentElement.style.display=`none`;' class='fas fa-window-close closeLinkPopup' title='Fechar'></i><h1><i class='fas fa-exclamation-triangle'></i>Ops!</h1><p>O link informado parece não ser do <span class='YouTube_text_logo'><i class='fab fa-youtube' style='color: #f00'></i> YouTube</span>!</p></div>");
                                            }
                                        } else {
                                            // Exibir a PopUp de alerta de campo vazio
                                            $("body").append("<div class='alert_getVideoCoverOnYouTube' style='width: 300px;'><i onclick='this.parentElement.style.display=`none`;' class='fas fa-window-close closeLinkPopup' title='Fechar'></i><h1><i class='fas fa-exclamation-triangle'></i>Ops!</h1><p>Link não encontrado, informe o link do vídeo no <span class='YouTube_text_logo'><i class='fab fa-youtube' style='color: #f00'></i> YouTube</span>!</p></div>");
                                        }
                                    });
                                });
                            </script>
                            <label for="image" class="form-label">Link da imagem <i id="searchGoogleImages" class="fab fa-google" style="color: #f90; cursor: pointer;" title="Procurar no Google Imagens"></i> <i id="getVideoCoverOnYouTube" class="fab fa-youtube" style="color: #f00; cursor: pointer;" title="Obter capa se o link for do YouTube"></i> <i class="fas fa-broom clearImageLinkField" style="color: #f60; cursor: pointer;" title="Limpar o campo do Link da imagem"></i></label>
                            <input type="text" class="form-control inputNameForm" id="image" name="image"<?= $_GET['page'] == "editLink" ? " value=\"{$readyScriptsLinksDB['image']}\"" : NULL ?> placeholder="https://www.site.com/imgs/img.png">
                        </div>
                        <div class="mb-3 col-sm-12">
                            <label for="about" class="form-label">Sobre o link</label>
                            <textarea class="form-control" id="about" name="about" rows="3"><?= $_GET['page'] == "editLink" ? $readyScriptsLinksDB['about'] : NULL ?></textarea>
                        </div>
                        <div class="mb-3 col-sm-6">
                            <label for="author" class="form-label">Autor (de onde ou a quem pertence)</label>
                            <textarea class="form-control" id="author" name="author" rows="1" style="resize: none"><?= $_GET['page'] == "editLink" ? $readyScriptsLinksDB['author'] : NULL ?></textarea>
                        </div>
                        <div class="mb-3 col-sm-3">
                            <label for="date" class="form-label">Data (Postagem)</label>
                            <input type="text" class="form-control inputNameForm" id="date" name="date"<?= $_GET['page'] == "editLink" ? " value=\"" . reverseDate($readyScriptsLinksDB['date']) . "\"" : " value=\"" . date('d/m/Y') . "\"" ?> placeholder="__/__/____">
                        </div>
                        <div class="mb-3 col-sm-3">
                            <label for="hour" class="form-label">Hora (Postagem)</label>
                            <input type="text" class="form-control inputNameForm" id="hour" name="hour"<?= $_GET['page'] == "editLink" ? " value=\"" . $readyScriptsLinksDB['hour'] . "\"" : " value=\"" . date('H:i:s') . "\"" ?> placeholder="__:__:__">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary"><?= $_GET['page'] == "addLink" ? "Registrar" : "Atualizar" ?></button>
                    <button type="button" id="closeFormLinks" class="btn btn-secondary closeFormLinks">Cancelar</button>
                </form>
            </div>
        </div>
    <?php
elseif(isset($_GET['page']) && $_GET['page'] == "deleteLink"):
    $id = isset($_GET['id']) ? $_GET['id'] : NULL; // ID do Link

    // Selecionar e recuperar os dados de "Links".
    $Read->ExeRead($CSReadyScriptsLinks, "WHERE id = :id", "id={$id}");
    foreach ($Read->getResult() as $readyScriptsLinksDB): endforeach;
?>
        <style>
            /* mobile */
            @media (max-width: 420px) {
                .tabForm {
                    max-width: 100%;
                }
            }
            .tabForm {
                position: fixed;
                background: #e1e1e1 !important;
                width: 350px;
                top: 50%;
                left: 50%;
                box-shadow: -1px 10px 15px rgba(0,0,0,.6);
                transform: translate(-50%, -50%);
                z-index: 9999;
            }
        </style>
        <div class="tabForm card mb-3">
            <img src="<?= HOME . "/pic/this-page/red-alert.png" ?>" class="card-img-top" alt="...">
            <div class="card-body">
                <!-- jQuery.Form -->
                <script src="<?= HOME . "/js/jquery.form.js" ?>"></script>
                <!-- Fechar o formulário ao clicar em "Cancelar". -->
                <script>
                    $(document).ready(function() {
                        //Ao clicar no objeto com id="box", executa a função.
                        $("#closeLinkForm").click(function() {
                            $("#popupPg1_deleteLink").remove();
                        });
                    });
                </script>
                <!-- /Fechar o formulário ao clicar em "Cancelar". -->
                <!-- SUBMIT A VIA AJAX FORM -->
                <script>
                    $(document).ready(function () {
                        // Enviar formulário via ajax
                        $("#myFormDeleteLink").submit(function () {
                            var options = {
                                target: "#retorno_sys",
                                beforeSubmit: showRequest, // Exibir o preload
                                url: "<?= HOME . "/func/func.tabForm.php?action=deleteLink&id={$id}" ?>", // Arquivo de destino
                                type: "POST", // Método POST
                                resetForm: false // Não resetar o formulário
                            };
                            $("#myFormDeleteLink").fadeTo("slow", 0.3); // Nível de efeito fade no formulário
                            $(this).ajaxSubmit(options);
                            function showRequest(formData, jqForm, options) {
                                $("#retorno_sys").fadeIn("slow").html("<div id='loadSys'>Processando...</div>");
                            }
                            $("#myFormDeleteLink").fadeTo("slow", 1);
                            return false;
                        });
                    });
                </script>
                <!-- END, SUBMIT A VIA AJAX FORM -->
                <h5 class="card-title">Quer mesmo excluir este Link?</h5>
                <form action="javascript:func()" id="myFormDeleteLink" name="myFormDeleteLink" method="post" enctype="multipart/form-data">
                    <p><i class="fas fa-exclamation-triangle" style="color: #f90"></i> <small style="color: #f00">Cuidado, você irá apagar o link "<strong><?= $readyScriptsLinksDB['name'] ?></strong>" e no tem mais volta!</small></p>
                    <button type="submit" class="btn btn-danger">Sim</button>
                    <button type="button" id="closeLinkForm" class="btn btn-secondary">Não</button>
                </form>
            </div>
        </div>
    <?php
endif;
