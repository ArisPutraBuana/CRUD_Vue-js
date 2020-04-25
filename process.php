<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "crud_vue_php");

if ($conn->connect_error) {
    die("Koneksi Error" . $conn->connect_error);
}

$result = ['error' => FALSE];
$action = '';

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

// Menampilkan data
if ($action == 'read') {
    $sql = $conn->query("SELECT * FROM users");
    $users = [];

    while ($row = $sql->fetch_assoc()) {
        array_push($users, $row);
    }
    $result['users'] = $users;
}

// Tambah data
if ($action == 'create') {
    $name   = $_POST['name'];
    $email  = $_POST['email'];
    $phone  = $_POST['phone'];

    $sql = $conn->query("INSERT INTO users (name,email,phone) VALUES ('$name','$email','$phone')");

    if ($sql) {
        $result['message'] = "Data User berhasil di tambah";
    } else {
        $result['error'] = TRUE;
        $result['message'] = "Data User sudah ada!";
    }
}

// Update data
if ($action == 'update') {
    $id     = $_POST['id'];
    $name   = $_POST['name'];
    $email  = $_POST['email'];
    $phone  = $_POST['phone'];

    $sql = $conn->query("UPDATE users SET name='$name', email='$email', phone='$phone' WHERE id='$id'");

    if ($sql) {
        $result['message'] = "Data User berhasil di update";
    } else {
        $result['error'] = TRUE;
        $result['message'] = "Failed to add user!";
    }
}

// Delete data
if ($action == 'delete') {

    $id     = $_POST['id'];

    $sql = $conn->query("DELETE FROM users WHERE id='$id'");

    if ($sql) {
        $result['message'] = "Data User berhasil di delete";
    } else {
        $result['error'] = TRUE;
        $result['message'] = "Failed to add user!";
    }
}

$conn->close();
echo json_encode($result);
