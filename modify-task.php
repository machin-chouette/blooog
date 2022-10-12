<?php
$chemin = './data/data.json';
$_POST = filter_input_array(INPUT_POST, [
    'id' => FILTER_VALIDATE_INT,
    'action' => FILTER_SANITIZE_FULL_SPECIAL_CHARS
]);
$id = $_POST['id'] ?? '';
$action = $_POST['action'] ?? '';

print_r($id);

if ($id && $action) {
    $bonnes_resolutions = json_decode(file_get_contents($chemin), true) ?? [];
    if (count($bonnes_resolutions)) {
        $taskIndex = array_search($id, array_column($bonnes_resolutions, 'id'));
        if ($action === 'remove') array_splice($bonnes_resolutions, $taskIndex, 1);
        if ($action === 'edit') $bonnes_resolutions[$taskIndex]['done'] = !$bonnes_resolutions[$taskIndex]['done'];
        file_put_contents($chemin, json_encode($bonnes_resolutions));
    }
}
header('Location: ./');