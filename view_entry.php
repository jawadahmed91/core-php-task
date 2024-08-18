<?php
require 'Database.php';

$id = $_GET['id'];
$formResult = $db->read('form_submissions', ['id' => $id]);
$form = $formResult->fetch_assoc();

$fields = json_decode($form['form_data'], true);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Entry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <a href="list_entries.php" class="btn btn-success float-end mb-2">List Entry</a>
        <h2>View Entry</h2>

        <?php foreach ($fields as $field): 
    
            $name = $field['name'];
            $label = htmlspecialchars($field['label']);
            $type = htmlspecialchars($field['type']);
            $value = htmlspecialchars($field['value']);
        ?>
            <div class="mb-3">
                <label for='<?= $name ?>' class='form-label'><?= $label ?></label>
                <input type='<?= $type ?>' class='form-control' id='<?= $name ?>' name='<?= $name ?>' value='<?= $value ?>'>
            </div>
        <?php endforeach; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>
