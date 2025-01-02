<?php
session_start();
include 'config.php';  

$message = '';
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];  

    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if ($password == $user['password']) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['user_id'] = $user['id'];

            if ($user['role'] == 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: employee_dashboard.php");
            }
            exit();
        } else {
            $message = "Invalid password.";
        }
    } else {
      
        $message = "No user found with that username.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Login</title>
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
        <h1 class="text-2xl font-bold mb-4 text-center">Login</h1>

        <form action="" method="post">
            <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
            <input type="text" id="username" name="username" class="mt-1 p-2 border border-gray-300 rounded w-full" required>

            <label for="password" class="block text-sm font-medium text-gray-700 mt-4">Password</label>
            <input type="password" id="password" name="password" class="mt-1 p-2 border border-gray-300 rounded w-full" required>

            

            <button type="submit" class="mt-6 w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                Login
            </button>
        </form>

        <!-- Popup Modal -->
        <?php if ($message): ?>
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="bg-white p-6 rounded-lg shadow-md w-1/3">
                <h3 class="text-xl font-semibold text-center text-red-600"><?= $message ?></h3>
                <div class="mt-4 text-center">
                    <button onclick="closeModal()" class="bg-blue-500 text-white px-4 py-2 rounded">
                        Close
                    </button>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <script>
        // Function to close the popup modal
        function closeModal() {
            const modal = document.querySelector('.fixed');
            modal.style.display = 'none';
        }
    </script>
</body>
</html>
