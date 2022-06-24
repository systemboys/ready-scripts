function popUpWindow(id, url) {
    $(document).ready(function() {
        // Ocultar menu e remover a máscara escura
        $("#offcanvasNavbar").removeClass("show");
        $(".offcanvas-backdrop").removeClass("show");

        // Carregar em uma DIV criada na hora do clique (PopUp) no body
        $("#popupPg1_" + id).remove();
        $("#topProgressBar").addClass("progress-bar-striped progress-bar-animated");
        $.ajax({
            type: "POST",
            url: url,
            data: "",
            cache: false,
            success: function(popup) {
                $("#topProgressBar").removeClass("progress-bar-striped progress-bar-animated");
                $("body").append("<div id=\"popupPg1_" + id + "\" style=\"display: none\"></div>");
                $("#popupPg1_" + id).html(popup); // DIV de destino.
                $("#popupPg1_" + id).fadeIn("fast");
            }
        });
    });
}
