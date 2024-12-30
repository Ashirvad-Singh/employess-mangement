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
        <form action="login_process.php" method="post">
            <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
            <input type="text" id="username" name="username" class="mt-1 p-2 border border-gray-300 rounded w-full" required>

            <label for="password" class="block text-sm font-medium text-gray-700 mt-4">Password</label>
            <input type="password" id="password" name="password" class="mt-1 p-2 border border-gray-300 rounded w-full" required>

            <label for="role" class="block text-sm font-medium text-gray-700 mt-4">Login as</label>
            <select name="role" id="role" class="mt-1 p-2 border border-gray-300 rounded w-full">
                <option value="admin">Admin</option>
                <option value="employee">Employee</option>
            </select>

            <button type="submit" class="mt-6 w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                Login
            </button>
        </form>
    </div>
</body>
</html>
