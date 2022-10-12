<?php

$chemin = './data/data.json';

$_GET = filter_input_array(INPUT_GET, FILTER_VALIDATE_INT);
$id = $_GET['id'] ?? '';

if ($id) {
    $data = file_get_contents($chemin);
    $bonnes_resolutions = json_decode($data, true) ?? [];

    if (count($bonnes_resolutions)) {
        $a_faireIndex = array_search($id, array_column($bonnes_resolutions, 'id'));
        $bonnes_resolutions[$a_faireIndex]['done'] = !$bonnes_resolutions[$a_faireIndex]['done'];
        file_put_contents($chemin, json_encode($bonnes_resolutions));
    }
}

header('Location: ./index.php');