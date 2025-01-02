<?php

if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION['role'];
?>
<?php
include 'config.php';

if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Create Employee</title>
</head>
<body class="bg-gray-100 min-h-screen">
<nav class="bg-blue-600 p-4">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
        <a href="<?= $role == 'admin' ? 'admin_dashboard.php' : 'employee_dashboard.php'; ?>" class="text-white text-2xl font-semibold">
            <?= $role == 'admin' ? 'Admin Dashboard' : 'Employee Dashboard'; ?>
        </a>
        <div class="space-x-4">
            <?php if ($role == 'admin'): ?>
                <a href="admin_dashboard.php" class="text-white hover:text-blue-200">Dashboard</a>
                <a href="create_employee.php" class="text-white hover:text-blue-200">Create Employee</a>
                <a href="manage_employees.php" class="text-white hover:text-blue-200">Manage Employees</a>
            <?php elseif ($role == 'employee'): ?>
                <a href="employee_dashboard.php" class="text-white hover:text-blue-200">Dashboard</a>
                <a href="request_leave.php" class="text-white hover:text-blue-200">Request Leave</a>
            <?php endif; ?>
            <a href="logout.php" class="text-white hover:text-blue-200">Logout</a>
        </div>
    </div>
</nav>
