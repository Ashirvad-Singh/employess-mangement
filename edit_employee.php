<?php
session_start();
include 'config.php';

// Ensure the user is an admin
if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch the employee ID from the URL
if (isset($_GET['id'])) {
    $employee_id = $_GET['id'];

    // Fetch employee details from the database
    $query = "SELECT * FROM employees WHERE id = '$employee_id'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $employee = $result->fetch_assoc();
    } else {
        echo "Employee not found.";
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}

// Handle the form submission to update employee details
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $adhar_card = $_POST['adhar_card'];
    $pan_card = $_POST['pan_card'];
    $salary = $_POST['salary'];
    $role = $_POST['role'];
    $username = $_POST['username'];
    
    // Photo Upload Handling (optional, if you want to allow the admin to change the photo)
    $photo = $_FILES['photo']['name'];
    $photo_tmp = $_FILES['photo']['tmp_name'];
    $photo_folder = 'uploads/' . $photo;

    if ($photo != "") {
        // Move the uploaded photo to the folder if a new one is provided
        if (move_uploaded_file($photo_tmp, $photo_folder)) {
            $photo_query = ", photo = '$photo'";
        } else {
            echo "Failed to upload the photo.";
            exit();
        }
    } else {
        $photo_query = "";
    }

    // Update employee details in the database
    $update_query = "UPDATE employees SET 
        name = '$name', 
        address = '$address', 
        phone = '$phone', 
        email = '$email', 
        adhar_card = '$adhar_card', 
        pan_card = '$pan_card', 
        salary = '$salary', 
        role = '$role' 
        $photo_query 
        WHERE id = '$employee_id'";

    if ($conn->query($update_query)) {
        header("Location: manage_employees.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Edit Employee</title>
</head>
<body class="bg-gray-100 min-h-screen">

<!-- Navbar -->
<nav class="bg-blue-600 p-4">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
        <a href="admin_dashboard.php" class="text-white text-2xl font-semibold">Admin Dashboard</a>
        <div class="space-x-4">
            <a href="admin_dashboard.php" class="text-white hover:text-blue-200">Dashboard</a>
            <a href="create_employee.php" class="text-white hover:text-blue-200">Create Employee</a>
            <a href="manage_employees.php" class="text-white hover:text-blue-200">Manage Employees</a>
            <a href="request_leave.php" class="text-white hover:text-blue-200">Leave Requests</a>
            <a href="logout.php" class="text-white hover:text-blue-200">Logout</a>
        </div>
    </div>
</nav>

<!-- Edit Employee Form -->
<div class="p-6 max-w-7xl mx-auto">
    <h1 class="text-3xl font-bold text-blue-600 mb-6">Edit Employee</h1>

    <form action="edit_employee.php?id=<?= $employee['id'] ?>" method="POST" enctype="multipart/form-data">
        <div class="grid grid-cols-2 gap-6">
            <!-- Employee Information -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" value="<?= $employee['name'] ?>" class="mt-1 p-2 w-full border border-gray-300 rounded-lg" required>
            </div>
            <div>
                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                <input type="text" name="address" value="<?= $employee['address'] ?>" class="mt-1 p-2 w-full border border-gray-300 rounded-lg" required>
            </div>
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                <input type="text" name="phone" value="<?= $employee['phone'] ?>" class="mt-1 p-2 w-full border border-gray-300 rounded-lg" required>
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" value="<?= $employee['email'] ?>" class="mt-1 p-2 w-full border border-gray-300 rounded-lg" required>
            </div>
            <div>
                <label for="adhar_card" class="block text-sm font-medium text-gray-700">Adhar Card</label>
                <input type="text" name="adhar_card" value="<?= $employee['adhar_card'] ?>" class="mt-1 p-2 w-full border border-gray-300 rounded-lg" required>
            </div>
            <div>
                <label for="pan_card" class="block text-sm font-medium text-gray-700">Pan Card</label>
                <input type="text" name="pan_card" value="<?= $employee['pan_card'] ?>" class="mt-1 p-2 w-full border border-gray-300 rounded-lg" required>
            </div>
            <div>
                <label for="salary" class="block text-sm font-medium text-gray-700">Salary</label>
                <input type="number" name="salary" value="<?= $employee['salary'] ?>" class="mt-1 p-2 w-full border border-gray-300 rounded-lg" required>
            </div>
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                <input type="text" name="role" value="<?= $employee['role'] ?>" class="mt-1 p-2 w-full border border-gray-300 rounded-lg" required>
            </div>
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" name="username" value="<?= $employee['username'] ?>" class="mt-1 p-2 w-full border border-gray-300 rounded-lg" required>
            </div>
            <div>
                <label for="photo" class="block text-sm font-medium text-gray-700">Photo</label>
                <input type="file" name="photo" class="mt-1 p-2 w-full border border-gray-300 rounded-lg">
                <img src="uploads/<?= $employee['photo'] ?>" alt="Employee Photo" class="mt-2 w-32 h-32 object-cover">
            </div>
        </div>

        <div class="mt-6">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg">Update Employee</button>
        </div>
    </form>
</div>

</body>
</html>
