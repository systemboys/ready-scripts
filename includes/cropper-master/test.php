<?php
// CROPPER-MASTER
require __DIR__ . "/src/Cropper.php";
$cropperMaster = new \CoffeeCode\Cropper\Cropper("./cache"); // Local do diretorio cache

echo "<img src='{$cropperMaster->make("./images_test/img1.jpg", 500)}' alt='Happy Coffee' title='Happy Coffee'>";
echo "<img src='{$cropperMaster->make("./images_test/img1.jpg", 500, 300)}' alt='Happy Coffee' title='Happy Coffee'>";

echo "<img src='{$cropperMaster->make("./images_test/img2.jpg", 500)}' alt='Happy Coffee' title='Happy Coffee'>";
echo "<img src='{$cropperMaster->make("./images_test/img2.jpg", 500, 300)}' alt='Happy Coffee' title='Happy Coffee'>";

echo "<img src='{$cropperMaster->make("./images_test/img3.jpg", 500)}' alt='Happy Coffee' title='Happy Coffee'>";
echo "<img src='{$cropperMaster->make("./images_test/img3.jpg", 500, 300)}' alt='Happy Coffee' title='Happy Coffee'>";

echo "<img src='{$cropperMaster->make("./images_test/img4.jpeg", 500)}' alt='Happy Coffee' title='Happy Coffee'>";
echo "<img src='{$cropperMaster->make("./images_test/img4.jpeg", 500, 300)}' alt='Happy Coffee' title='Happy Coffee'>";
