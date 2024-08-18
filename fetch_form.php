<?php
require 'Database.php';

$id = $_GET['id'];
$formResult = $db->read('forms', ['id' => $id]);
$form = $formResult->fetch_assoc();


$fields = json_decode($form['fields'], true);
$validationRules = json_decode($form['validation_rules'], true);

?>

<?php foreach ($fields as $field): 
    
    $name = $field['name'];
    $label = htmlspecialchars($field['label']);
    $type = htmlspecialchars($field['type']);
    $validation = isset($validationRules[$name]) ? htmlspecialchars($validationRules[$name]) : '';
?>
    <div class="mb-3">
        <label for='<?= $name ?>' class='form-label'><?= $label ?></label>
        <input type='<?= $type ?>' class='form-control' id='<?= $name ?>' name='<?= $name ?>' data-validation='<?= $validation ?>'>
    </div>
<?php endforeach; ?>
