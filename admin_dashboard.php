<?php
session_start();
include 'config.php';

if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

$employees_count = $conn->query("SELECT COUNT(*) AS total FROM employees")->fetch_assoc()['total'];
$total_salary = $conn->query("SELECT SUM(salary) AS total FROM employees")->fetch_assoc()['total'];
$leave_requests = $conn->query("
    SELECT leave_requests.*, employees.name FROM leave_requests 
    JOIN employees ON leave_requests.employee_id = employees.id
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Admin Dashboard</title>
</head>
<body class="bg-gray-100 min-h-screen">
    <?php include 'header.php'; ?>

    <div class="p-6 max-w-7xl mx-auto">


        <div class="grid grid-cols-2 gap-6 mb-6">
            <div class="bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold">Total Employees</h2>
                <p class="text-2xl font-bold"><?= $employees_count ?></p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold">Total Salary</h2>
                <p class="text-2xl font-bold">₹<?= number_format($total_salary, 2) ?></p>
            </div>
        </div>

        <h2 class="text-2xl font-semibold mb-4">Leave Requests</h2>
        <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-4 text-left">Employee</th>
                    <th class="p-4 text-left">Start Date</th>
                    <th class="p-4 text-left">End Date</th>
                    <th class="p-4 text-left">Reason</th>
                    <th class="p-4 text-left">Status</th>
                    <th class="p-4 text-left">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($leave = $leave_requests->fetch_assoc()) { ?>
                    <tr>
                        <td class="p-4"><?= $leave['name'] ?></td>
                        <td class="p-4"><?= $leave['start_date'] ?></td>
                        <td class="p-4"><?= $leave['end_date'] ?></td>
                        <td class="p-4"><?= $leave['reason'] ?></td>
                        <td class="p-4"><?= ucfirst($leave['status']) ?></td>
                        <td class="p-4">
                            <?php if ($leave['status'] == 'pending') { ?>
                                <a href="approve_leave.php?id=<?= $leave['id'] ?>" class="text-green-600">Approve</a> | 
                                <a href="reject_leave.php?id=<?= $leave['id'] ?>" class="text-red-600">Reject</a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
