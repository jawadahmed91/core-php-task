<?php
require 'Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formId = $_POST['id'];

    // Delete associated form submissions
    $form_submissions_query = "DELETE FROM form_submissions WHERE form_id = ?";
    $form_submissions_result = $db->query($form_submissions_query, [$formId]);

    // Delete the form itself
    $forms_query = "DELETE FROM forms WHERE id = ?";
    $forms_result = $db->query($forms_query, [$formId]);

    echo json_encode(['status' => 'success']);
}
