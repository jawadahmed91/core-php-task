<?php
require 'Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formId = $_POST['id'];

    

    // Delete associated form submissions
    $form_submissions_query = "DELETE FROM form_submissions WHERE form_id = ?";
    $form_submissions_result = $db->query($form_submissions_query, [$formId]);

    echo json_encode(['status' => 'success']);
}
