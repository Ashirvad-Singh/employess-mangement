<?php

if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION['role'];
?>

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
