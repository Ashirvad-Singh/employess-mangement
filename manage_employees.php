<?php
session_start();
include 'config.php';

if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

$employees = $conn->query("SELECT * FROM employees");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Manage Employees</title>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="p-6 max-w-7xl mx-auto">
        <h1 class="text-3xl font-bold text-blue-600 mb-6">Manage Employees</h1>
        <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-4 text-left">Name</th>
                    <th class="p-4 text-left">Email</th>
                    <th class="p-4 text-left">Phone</th>
                    <th class="p-4 text-left">Role</th>
                    <th class="p-4 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($employee = $employees->fetch_assoc()) { ?>
                    <tr>
                        <td class="p-4"><?= $employee['name'] ?></td>
                        <td class="p-4"><?= $employee['email'] ?></td>
                        <td class="p-4"><?= $employee['phone'] ?></td>
                        <td class="p-4"><?= $employee['role'] ?></td>
                        <td class="p-4">
                            <a href="edit_employee.php?id=<?= $employee['id'] ?>" class="text-blue-600">Edit</a> | 
                            <a href="delete_employee.php?id=<?= $employee['id'] ?>" class="text-red-600" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
