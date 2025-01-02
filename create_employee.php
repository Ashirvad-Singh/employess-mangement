<?php
session_start();
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
<?php include 'header.php'; ?>

    <div class="p-6 max-w-5xl mx-auto">
        <h1 class="text-3xl font-bold text-blue-600 mb-6">Create Employee</h1>
        <form action="create_employee_process.php" method="post" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" class="mt-1 mb-4 p-2 border border-gray-300 rounded w-full" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Address</label>
                    <input type="text" name="address" class="mt-1 mb-4 p-2 border border-gray-300 rounded w-full" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Phone</label>
                    <input type="text" name="phone" class="mt-1 mb-4 p-2 border border-gray-300 rounded w-full" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" class="mt-1 mb-4 p-2 border border-gray-300 rounded w-full" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Aadhar Card</label>
                    <input type="text" name="adhar_card" class="mt-1 mb-4 p-2 border border-gray-300 rounded w-full" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">PAN Card</label>
                    <input type="text" name="pan_card" class="mt-1 mb-4 p-2 border border-gray-300 rounded w-full" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Salary</label>
                    <input type="number" step="0.01" name="salary" class="mt-1 mb-4 p-2 border border-gray-300 rounded w-full" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Role</label>
                    <input type="text" name="role" class="mt-1 mb-4 p-2 border border-gray-300 rounded w-full" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Photo</label>
                    <input type="file" name="photo" class="mt-1 mb-4 p-2 border border-gray-300 rounded w-full" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" name="username" class="mt-1 mb-4 p-2 border border-gray-300 rounded w-full" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" class="mt-1 mb-4 p-2 border border-gray-300 rounded w-full" required>
                </div>
            </div>
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Create Employee</button>
        </form>
    </div>
</body>
</html>
