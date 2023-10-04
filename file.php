<?php
function connectDB()
{
  $servername = "localhost";
  $username = 'root';
  $password = 'ikram';
  $dbName = "form2";

  // Create a MySQLi object and establish the database connection
  $conn = new mysqli($servername, $username, $password, $dbName);

  // Check the connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  return $conn;
}

// Establish a database connection
$db = connectDB();
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve person's information
  $nom = $_POST['nom'];
  $prenom = $_POST['prenom'];
  $place = $_POST['place'];
  $phone = $_POST['phone'];
  $birth = $_POST['birth'];
  $activite = $_POST['activite'];

  // Create and execute the SQL query to insert person information
  $sql_person = "INSERT INTO person (nom, prenom, place, phone, birth, activite) 
    VALUES ('$nom', '$prenom', '$place', '$phone', '$birth', '$activite')";

  if ($db->query($sql_person) === TRUE) {
    // Get the person's unique ID
    $person_id = $db->insert_id;

    // Process each uploaded file individually
    for ($i = 0; $i < 6; $i++) {
      $input_name = "file" . $i;
      $file_name = $_FILES[$input_name]["name"];
      $file_tmp = $_FILES[$input_name]["tmp_name"];
      $file_size = $_FILES[$input_name]["size"];

      // Check if the file was uploaded without errors
      if ($file_size > 0) {
        $target_dir = "uploads/";  // Define the directory where you want to save files
        $target_file = $target_dir . basename($file_name);

        // Move the uploaded file to the desired location
        if (move_uploaded_file($file_tmp, $target_file)) {
          // Save the file path and associate it with the person's unique ID
          $filePath = $target_file;

          // Create and execute the SQL query to insert file information
          $sql_file = "INSERT INTO files (person_id, file_path) VALUES ('$person_id', '$filePath')";

          if ($db->query($sql_file) === TRUE) {
            echo "Record inserted successfully for file: $file_name.<br>";
          } else {
            echo "Error inserting record for file: $file_name. Error: " . $db->error . "<br>";
          }
        } else {
          echo "Error uploading file: $file_name.<br>";
        }
      }
    }

    echo "Person's information inserted successfully.<br>";
  } else {
    echo "Error inserting person's information. Error: " . $db->error . "<br>";
  }

  // Close the database connection
  $db->close();
}

