<?php
require 'Database.php';

// Fetch the list of forms to dynamically generate the form fields
$forms = $db->query("SELECT * FROM forms");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Entry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <a href="list_entries.php" class="btn btn-success float-end mb-2">List Entry</a>
        <h2>Add Entry</h2>

        <form id="dynamic-form">
            <div class="mb-3">
                <label for="form_id" class="form-label">Select Form</label>
                <select class="form-select" id="form_id" name="form_id" required>
                    <option value="">Choose a form</option>
                    <?php while ($form = $forms->fetch_assoc()): ?>
                        <option value="<?= $form['id'] ?>"><?= 'Form #' . $form['id'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div id="form-fields" class="mb-3"></div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#form_id').on('change', function() {
            var formId = $(this).val();
            $('#form-fields').empty();

            if (formId) {
                $.ajax({
                    url: 'fetch_form.php',
                    method: 'GET',
                    data: { id: formId },
                    success: function(response) {

                        $('#form-fields').html(response);
                        applyClientValidation();
                    }
                });
            }
        });

        function applyClientValidation() {
            $('#dynamic-form').on('submit', function(e) {
                e.preventDefault();
                var isValid = true;
                $('.form-error').remove();

                $('#dynamic-form .form-control').each(function() {
                    var field = $(this);
                    var name = field.attr('name');
                    var value = field.val().trim();
                    var validationRules = field.data('validation').split('|');
                    
                    validationRules.forEach(function(rule) {
                        if (rule === 'required' && !value) {
                            field.after('<div class="form-error">This field is required.</div>');
                            isValid = false;
                        } else if (rule.startsWith('min:')) {
                            var min = parseInt(rule.split(':')[1]);
                            if (value.length < min) {
                                field.after('<div class="form-error">Minimum length is ' + min + ' characters.</div>');
                                isValid = false;
                            }
                        } else if (rule.startsWith('max:')) {
                            var max = parseInt(rule.split(':')[1]);
                            if (value.length > max) {
                                field.after('<div class="form-error">Maximum length is ' + max + ' characters.</div>');
                                isValid = false;
                            }
                        } else if (rule === 'email' && !/\S+@\S+\.\S+/.test(value)) {
                            field.after('<div class="form-error">Invalid email format.</div>');
                            isValid = false;
                        }
                    });
                });

                if (isValid) {
                    $.ajax({
                        url: 'submit_form.php',
                        method: 'POST',
                        data: $('#dynamic-form').serialize(),
                        success: function(response) {
                            
                            console.log(response);
                            alert(response);
                            $('#dynamic-form')[0].reset();
                        }
                    });
                }
            });
        }
    </script>
</body>
</html>
