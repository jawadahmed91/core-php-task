<?php
class FormCreation {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function createForm($formData) {
        $fields = json_encode($formData['fields']);
        $emailFields = json_encode($formData['email_fields']);
        $validationRules = json_encode($formData['validation_rules']);

        $stmt = $this->db->prepare("INSERT INTO forms (fields, email_fields, validation_rules) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $fields, $emailFields, $validationRules);
        $stmt->execute();

        return $stmt->insert_id;
    }
}

// Usage example
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new mysqli("localhost", "root", "", "form_db");

    $formData = json_decode(file_get_contents('php://input'), true);
    $formCreation = new FormCreation($db);
    $formId = $formCreation->createForm($formData);

    echo json_encode(['form_id' => $formId]);
}
?>
