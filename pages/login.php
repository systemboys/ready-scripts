<?php
require '../_app/Config.inc.php';
if (isset($_GET['page']) && $_GET['page'] == "logInUser"):
?>
        <style>
            /* mobile */
            @media (max-width: 420px) {
                .loginScreen {
                    max-width: 100%;
                }
            }
            .loginScreen {
                position: absolute;
                background: #e1e1e1 !important;
                width: 350px;
                top: 50%;
                left: 50%;
                box-shadow: -1px 10px 15px rgba(0,0,0,.6);
                transform: translate(-50%, -50%);
                z-index: 9999;
            }
        </style>
        <div class="loginScreen card mb-3">
            <img src="<?= HOME . "/pic/this-page/topo1.png" ?>" class="card-img-top" alt="...">
            <div class="card-body">
                <!-- jQuery.Form -->
                <script src="<?= HOME . "/js/jquery.form.js" ?>"></script>
                <!-- SUBMIT A VIA AJAX FORM -->
                <script>
                    $(document).ready(function () {
                        // Enviar formulário via ajax
                        $("#myFormLogin").submit(function () {
                            var options = {
                                target: "#retorno_sys",
                                beforeSubmit: showRequest, // Exibir o preload
                                url: "<?= HOME . "/func/func.login.php?action=logIn" ?>", // Arquivo de destino
                                type: "POST", // Método POST
                                resetForm: false // Não resetar o formulário
                            };
                            $("#myFormLogin").fadeTo("slow", 0.3); // Nível de efeito fade no formulário
                            $(this).ajaxSubmit(options);
                            function showRequest(formData, jqForm, options) {
                                $("#retorno_sys").fadeIn("slow").html("<div id='loadSys'>Processando...</div>");
                            }
                            $("#myFormLogin").fadeTo("slow", 1);
                            return false;
                        });
                    });
                </script>
                <!-- END, SUBMIT A VIA AJAX FORM -->
                <h5 class="card-title">Entre com suas credenciais</h5>
                <form action="javascript:func()" id="myFormLogin" name="myFormLogin" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="email" class="form-label">Endereço de email</label>
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" autofocus>
                        <div id="emailHelp" class="form-text">Nunca compartilharemos seu e-mail com mais ninguém.</div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="keepConnected" id="keepConnected" name="keepConnected">
                        <label class="form-check-label" for="keepConnected">Manter logado</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Acessar</button>
                </form>
            </div>
        </div>
    <?php
endif;
