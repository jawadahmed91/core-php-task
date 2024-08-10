# Dynamic Form Creation and Submission System

This project is a Core PHP application that allows for the dynamic creation, display, and submission of forms. It is built with an OOP-based architecture and uses jQuery for client-side interactivity. The project supports validation rules and includes functionality to store and view form submissions. Additionally, it is deployed using Docker.

## Features

- **Dynamic Form Creation via API**: Users can create forms dynamically by specifying the field types (input, textarea, select, radio, checkbox) and names via API calls. Users can also specify validation rules and choose which fields should be included in an email upon form submission.

- **Validation Rules**: Supports required, email, min, max validation rules both on the client and server side.

- **Form Storage**: Form metadata is stored in a MySQL database.
- **Form Display**: Dynamically generated forms are displayed using Bootstrap for a clean and responsive design.
- **Form Submission**: Forms are submitted via AJAX, validated server-side, and the submissions are stored in a database. An email is sent out for fields marked to be sent.
- **Bot Prevention**: Includes mechanisms to prevent automated bots from submitting forms.
- **OOP-based Architecture**: The application is structured using object-oriented programming principles to ensure maintainability and scalability.
- **Docker Deployment**: The application is set up to run within a Docker container, ensuring consistent environments across different stages of development and deployment.

## Code Structure
- **add_form.php**: Handles the creation of dynamic forms via API.
- **list_forms.php**: Lists all the forms that have been created.
- **submit_form.php**: Handles form submission, validation, and storage in the database.
- **list_entries.php**: Lists all the form entries submitted.
- **view_entry.php**: Displays the form for a specific entry.
- **delete_entry.php**: Handles deletion of a form entry.
- **Database.php**: A class handling database connection and queries.