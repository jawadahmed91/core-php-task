<?php
require 'Database.php';

// Fetch all form submissions
$results = $db->query("SELECT * FROM form_submissions ORDER BY submitted_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Entries</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <a href="add_entry.php" class="btn btn-success float-end mb-2">Add Entry</a>
        <h2>List of Entries</h2>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Form ID</th>
                    <th>Submitted At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($results->num_rows > 0): ?>
                    <?php while ($row = $results->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['form_id'] ?></td>
                            <td><?= date('Y-m-d H:i:s', strtotime($row['submitted_at'])) ?></td>
                            <td>
                                <a href="view_entry.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm">View</a>
                                <a href="delete_entry.php?id=<?= $row['form_id'] ?>" id="delete-form" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this entry?')" data-id="<?= $row['form_id'] ?>">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">No entries found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
    $('#delete-form').on('click', function(e) {
        e.preventDefault();
        var formId = $(this).attr('data-id');

        $.ajax({
            url: 'delete_entry.php',
            method: 'POST',
            data: { id: formId },
            success: function(response) {
                console.log(response);
                alert(response);
            }
        });
    });
    </script>
</body>
</html>
