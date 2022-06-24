<?php
$backButton = "<i class='fas fa-angle-left'></i>"; // Botão voltar
$nextButton = "<i class='fas fa-angle-right'></i>";  // Botão próximo

echo "
<script>
    // Ao cliente em um link da paginação
    function clickOnTheLinkToRise() {
        $(window).scrollTop(0); // Rolar página indo pro topo
    }
</script>
";

echo "<div id='paginationBox'>";
// Verifica se está na primeira página, se não estiver exibe o botão anterior e o numero da página inicial
// Se não ele desativa o botão de anterior e seta a primeira página
if ($pagina > 1):
    echo "<a class='btn-yt btnDefault' onclick='pagination_scriptTargetReady(" . ($pagina - 2) . ", {$paginas}, {$quant_resul}), clickOnTheLinkToRise()'>{$backButton}</a>";
    echo "<a class='btn-yt btnDefault' onclick='pagination_scriptTargetReady(0, {$paginas}, {$quant_resul}), clickOnTheLinkToRise()'>1</a>";
else:
    echo "<a class='btn-yt btnDefault'>{$backButton}</a>";
    echo "<a class='btn-yt btnDefault btnToggled'>1</a>";
endif;
// Mostrando as demais páginas
for ($i = $pagina; $i <= ($pagina + 1); $i ++) {
    // Imprindo o botão da página antes da atual, ela necessita ser diferente da primeira página
    if (($i - 1) == ($pagina - 1) and ( $i - 1) != 1 and ( $i != 1)):
        echo "&nbsp;...&nbsp;<a class='btn-yt btnDefault' onclick='pagination_scriptTargetReady(" . ($i - 2) . ", {$paginas}, {$quant_resul}), clickOnTheLinkToRise()'>" . ($i - 1) . "</a>";
    endif;
    // Verificando se estamos na primeira página ou na ultima se estiver ele não imprime nada.
    if ($i == 1 or $i == $paginas or $i == $paginas):
        // echo "";
    elseif ($pagina == $i):
        // Se a página for igual a página atual ele seta o indicador na página e desativa o botão
        echo "<a class='btn-yt btnDefault btnToggled'>{$i}</a>"; // Página atual
    elseif ($i < $pagina):
        // Imprimindo a página após a página atual,
        echo "<a class='btn-yt btnDefault' onclick='pagination_scriptTargetReady(" . ($i - 1) . ", {$paginas}, {$quant_resul}), clickOnTheLinkToRise()'>{$i}</a>";
    endif;
    if (($i + 1) == ($pagina + 1) and ( $i + 1) != $paginas and $i != $paginas):
        echo "<a class='btn-yt btnDefault' onclick='pagination_scriptTargetReady(" . ($i) . ", {$paginas}, {$quant_resul}), clickOnTheLinkToRise()'>" . ($i + 1) . "</a>&nbsp;...&nbsp;";
    endif;
}
// Verificando novamente se existe apenas a primeira página, se so existir ela é impresso o botão proximo desativado
if ($paginas == 1):
    echo "<a class='btn-yt btnDefault'>{$nextButton}</a>";
elseif ($pagina < $paginas):
    // Verificando se a página atual é diferente  da ultima página se for diferente ele imprime a ultima página e ativa o botão próximo
    echo "<a class='btn-yt btnDefault' onclick='pagination_scriptTargetReady(" . ($paginas - 1) . ", {$paginas}, {$quant_resul}), clickOnTheLinkToRise()'>{$paginas}</a>";
    echo "<a class='btn-yt btnDefault' onclick='pagination_scriptTargetReady({$pagina}, {$paginas}, {$quant_resul}), clickOnTheLinkToRise()'>{$nextButton}</a>";
else:
    // Se a leitura estiver na ultima página, o indicador é setado na página e o botão próximo é desativado
    echo "<a class='btn-yt btnDefault btnToggled'>{$paginas}</a>";
    echo "<a class='btn-yt btnDefault'>{$nextButton}</a>";
endif;
echo "</div>";
