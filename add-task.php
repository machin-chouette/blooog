<?php

// Filtre pour sécuriser les input du formulaire
$_POST = filter_input_array(INPUT_POST, [
    'task' => [
        'filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'flags' => FILTER_FLAG_NO_ENCODE_QUOTES | FILTER_FLAG_STRIP_BACKTICK
    ]
]);
// Récupération de la valeur et stocker dans une variable
$task = $_POST['task'] ?? '';

// Condition pour la gestion des erreurs
if (!$task) {
    $erreurs['task'] = ERROR_REQUIRED;
} elseif (mb_strlen($task) < 5) {
    $erreurs['task'] = ERROR_TOO_SHORT;
} elseif (mb_strlen($task) > 200) {
    $erreurs['task'] = ERROR_TOO_LONG;
} elseif (array_search(mb_strtolower($task), array_map(fn ($el) => mb_strtolower($el['task']), $bonnes_resolutions))) {
    $erreurs['task'] = ERROR_ALREADY_EXISTS;
}

// print_r($erreurs);
print_r(array_filter($erreurs, fn ($e) => $e !== ''));
// print_r($var);

if (empty(array_filter($erreurs, fn ($e) => $e !== ''))) {
    $bonnes_resolutions = [...$bonnes_resolutions, [
        'task' => $task,
        'done' => false,
        'id' => time(),
    ]];
    file_put_contents($chemin, json_encode($bonnes_resolutions));
    $task = '';
    header('Location: ./');
}