<div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="<?= HOME . "/pic/demo-image/{$readyScriptsSettingsDB['front_cover']}" ?>" class="d-block w-100" alt="...">
        </div>
        <?php
        // Selecionar e recuperar os dados de "Links".
        $imageLimit = (!empty($readyScriptsSettingsDB['slide_image_limit']) ? " LIMIT 0, {$readyScriptsSettingsDB['slide_image_limit']}" : NULL);
        $Read->FullRead("SELECT * FROM {$CSReadyScriptsLinks} WHERE primary_email = '{$primary_email}' ORDER BY RAND(){$imageLimit}");
        if ($Read->getResult()):
            foreach ($Read->getResult() as $readyScriptsLinksDB):
                echo "
        <div class='carousel-item'>
            <img src='" . (!empty($readyScriptsLinksDB['image']) ? $readyScriptsLinksDB['image'] : $readyScriptsSettingsDB['front_cover']) . "' class='d-block w-100' alt='{$readyScriptsLinksDB['name']}'>
        </div>
                ";
            endforeach;
        endif;
        ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>