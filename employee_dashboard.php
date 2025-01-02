<?php
session_start();
include 'config.php';

if ($_SESSION['role'] != 'employee') {
    header("Location: login.php");
    exit();
}

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
    <title>Requested Leave</title>
   
</head>
<body class="bg-gray-100 min-h-screen">
<?php include 'header.php'; ?>
    <div class="p-6 max-w-5xl mx-auto">

     

        <div class="bg-white p-8 rounded-lg shadow-lg mb-6 flex items-center">
            <div class="mr-6">
                <img src="uploads/<?= $employee['photo'] ?>" alt="Employee Photo" class="profile-photo border-4 border-blue-600 shadow-lg">
            </div>
            <div class="space-y-4">
                <h2 class="text-2xl font-semibold text-gray-800"><?= $employee['name'] ?></h2>
                <p class="text-gray-600"><strong>Email:</strong> <?= $employee['email'] ?></p>
                <p class="text-gray-600"><strong>Phone:</strong> <?= $employee['phone'] ?></p>
                <p class="text-gray-600"><strong>Address:</strong> <?= $employee['address'] ?></p>
                <p class="text-gray-600"><strong>Role:</strong> <?= $employee['role'] ?></p>
                <p class="text-gray-600"><strong>Salary:</strong> ₹<?= number_format($employee['salary'], 2) ?></p>
                <p class="text-gray-600"><strong>Aadhar Card:</strong> <?= $employee['adhar_card'] ?></p>
                <p class="text-gray-600"><strong>PAN Card:</strong> <?= $employee['pan_card'] ?></p>
            </div>
        </div>

      
    </div>

</body>
</html>
