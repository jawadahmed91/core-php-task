<?php
require 'Database.php';

header('Content-Type: application/json');


// Retrieve JSON input
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!isset($data['fields']) || !is_array($data['fields'])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
    exit;
}

$fields = json_encode($data['fields']);
$emailFields = isset($data['emailFields']) ? json_encode($data['emailFields']) : '[]';
$validationRules = isset($data['validationRules']) ? json_encode($data['validationRules']) : '[]';

$query = "INSERT INTO forms (fields, email_fields, validation_rules) VALUES (?, ?, ?)";
$result = $db->query($query, [$fields, $emailFields, $validationRules]);

if ($result) {
    echo json_encode(['status' => 'success', 'message' => 'Form created successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to create form']);
}
?>
