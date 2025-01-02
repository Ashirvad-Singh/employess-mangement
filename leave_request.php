<?php
session_start();
include 'config.php';

if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

$leave_requests = $conn->query("SELECT leave_requests.*, employees.name FROM leave_requests 
                                JOIN employees ON leave_requests.employee_id = employees.id");
?>


<head>

    <title>Manage Leave Requests</title>
</head>
<body class="bg-gray-100 min-h-screen">
<?php include 'header.php'; ?>

    <div class="p-6 max-w-7xl mx-auto">
        <h1 class="text-3xl font-bold text-blue-600 mb-6">Leave Requests</h1>

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
                                <a href="update_leave_status.php?id=<?= $leave['id'] ?>&status=approved" 
                                   class="text-green-600">Approve</a> | 
                                <a href="update_leave_status.php?id=<?= $leave['id'] ?>&status=rejected" 
                                   class="text-red-600">Reject</a>
                            <?php } else {
                                echo "-";
                            } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
