<?php
require 'Database.php';

$data = $_POST;
$formId = $data['form_id'];
$response = $db->query("SELECT * FROM forms WHERE id = ?", [$formId])->fetch_assoc();

if (!$response) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid form ID']);
    exit;
}

$fields = json_decode($response['fields'], true);
$validationRules = json_decode($response['validation_rules'], true);

$errors = [];

foreach ($fields as $key => $field) {
    $name = $field['name'];
    $value = isset($data[$name]) ? trim($data[$name]) : '';
    $fields[$key]['value'] = $value;
    // Apply validation rules
    if (isset($validationRules[$name])) {
        $rules = explode('|', $validationRules[$name]);

        foreach ($rules as $rule) {
            if ($rule === 'required' && empty($value)) {
                $errors[$name] = 'This field is required.';
            } elseif (strpos($rule, 'min:') === 0) {
                $min = (int)str_replace('min:', '', $rule);
                if (strlen($value) < $min) {
                    $errors[$name] = "Minimum length is $min characters.";
                }
            } elseif (strpos($rule, 'max:') === 0) {
                $max = (int)str_replace('max:', '', $rule);
                if (strlen($value) > $max) {
                    $errors[$name] = "Maximum length is $max characters.";
                }
            } elseif ($rule === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $errors[$name] = 'Invalid email format.';
            } 
        }
    }
}

if (!empty($errors)) {
    echo json_encode(['status' => 'error', 'errors' => $errors]);
    exit;
}

// Insert into database
$query = "INSERT INTO form_submissions (form_id, form_data) VALUES (?, ?)";
$result = $db->query($query, [$formId, json_encode($fields)]);

if ($result) {
    echo json_encode(['status' => 'success', 'message' => 'Entry added successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to add entry']);
}
?>
