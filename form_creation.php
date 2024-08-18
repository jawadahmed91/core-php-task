<?php
require 'Database.php';

function createForm($formData) {
    $fields = json_encode($formData['fields']);
    $emailFields = json_encode($formData['email_fields']);
    $validationRules = json_encode($formData['validation_rules']);

    $result = $db->create('forms', ['fields' => $fields, 'email_fields' => $emailFields, 'validation_rules' => $validationRules]);
    return $result->insert_id;
}

// Usage example
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formData = json_decode(file_get_contents('php://input'), true);
    $formId = createForm($formData);

    echo json_encode(['form_id' => $formId]);
}
?>
