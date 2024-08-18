<?php
require 'Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formId = $_POST['id'];

    // Delete associated form submissions
    $form_submissions_result =  $db->delete('form_submissions', ['id' => $formId]); 
   
    echo json_encode(['status' => 'success']);
}
