<?php
$servername = 'localhost';
$username = 'root;
$password = '';
$dbname = 'database';

$conn = new mysqli($servername, $username, $password, $dbname);

// check connection 
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$email = $_POST['email'];
$comm = $_POST['comment'];


$name_error = '';
$email_error = '';
$comment_error = '';

if (empty($name)) {
    $name_error = 'Name is required';
} else {
    if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
        $name_error = 'Only letters and white space are allowed';
    }
}

if (empty($email)) {
    $email_error = 'Email is required';
} else {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error = 'Invalid email';
    }
}

if (empty($comm)) {
    $comment_error = 'Comment is required';
}

if ($name_error === "" && $email_error === "" && $comment_error === "") {
    $stmt = $conn->prepare("INSERT INTO user (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $comm);
    if ($stmt->execute()) {
        $sucess = "<div class='alert-success'>Sent successfully</div>";
        $output = array(
            "success" => $sucess,
            "name_error" => $name_error,
            "email_error" => $email_error,
            "comment_error" => $comment_error
        );
        echo json_encode($output);
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    $output = array(
        "success" => "",
        "name_error" => $name_error,
        "email_error" => $email_error,
        "comment_error" => $comment_error
    );
    echo json_encode($output);
}
$stmt->close();
$conn->close();
?>
