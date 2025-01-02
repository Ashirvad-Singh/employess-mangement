<?php
session_start();
include 'config.php';

if ($_SESSION['role'] != 'employee') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$employee = $conn->query("SELECT * FROM employees WHERE user_id = '$user_id'")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $reason = $_POST['reason'];
    $employee_id = $employee['id']; 

    $query = "INSERT INTO leave_requests (employee_id, start_date, end_date, reason, status) 
              VALUES ('$employee_id', '$start_date', '$end_date', '$reason', 'pending')";
    
    if ($conn->query($query)) {
        header("Location: employee_dashboard.php?message=Leave request submitted successfully.");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<?php

$user_id = $_SESSION['user_id'];
$employee = $conn->query("SELECT * FROM employees WHERE user_id = '$user_id'")->fetch_assoc();
$leave_requests = $conn->query("SELECT * FROM leave_requests WHERE employee_id = '{$employee['id']}'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Employee Dashboard</title>
    <style>
        .profile-photo {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
<?php include 'header.php'; ?>
    <div class="p-6 max-w-5xl mx-auto">
        <?php if (isset($_GET['message'])): ?>
            <div class="bg-green-500 text-white p-4 rounded-lg mb-4"><?= htmlspecialchars($_GET['message']); ?></div>
        <?php endif; ?>

     
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-xl font-semibold mb-4">Leave Requests</h2>
            <table class="w-full bg-gray-50 shadow-md rounded-lg overflow-hidden">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-4 text-left">Start Date</th>
                        <th class="p-4 text-left">End Date</th>
                        <th class="p-4 text-left">Reason</th>
                        <th class="p-4 text-left">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($leave = $leave_requests->fetch_assoc()) { 
                       
                        $status_class = '';
                        $status_text = '';
                        
                        if ($leave['status'] == 'approved') {
                            $status_class = 'bg-green-500 text-white';
                            $status_text = 'Approved';
                        } elseif ($leave['status'] == 'rejected') {
                            $status_class = 'bg-red-500 text-white';
                            $status_text = 'Rejected';
                        } else {
                            $status_class = 'bg-yellow-500 text-white';
                            $status_text = 'Pending';
                        }
                    ?>
                        <tr>
                            <td class="p-4"><?= $leave['start_date'] ?></td>
                            <td class="p-4"><?= $leave['end_date'] ?></td>
                            <td class="p-4"><?= $leave['reason'] ?></td>
                            <td class="p-4">
                                <span class="px-3 py-1 rounded-full <?= $status_class ?>">
                                    <?= $status_text ?>
                                </span>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <h2 class="text-xl font-semibold my-6">Request Leave</h2>
        <form action="request_leave.php" method="post" class="bg-white p-6 rounded-lg shadow-md">
            <label class="block text-sm font-medium text-gray-700">Start Date</label>
            <input type="date" name="start_date" class="mt-1 mb-4 p-2 border border-gray-300 rounded w-full" required>

            <label class="block text-sm font-medium text-gray-700">End Date</label>
            <input type="date" name="end_date" class="mt-1 mb-4 p-2 border border-gray-300 rounded w-full" required>

            <label class="block text-sm font-medium text-gray-700">Reason</label>
            <textarea name="reason" class="mt-1 mb-4 p-2 border border-gray-300 rounded w-full" required></textarea>

            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Submit</button>
        </form>
    </div>

</body>
</html>
