<?php

echo json_encode([
    'name' => $_POST['name'],
    'time' => $_POST['time'],
    'message' => 'Remcodex Client Signed'
]);