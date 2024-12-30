<?php
session_start();
include 'config.php';

// Ensure the user is an admin
if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Check if the employee ID is set in the URL
if (isset($_GET['id'])) {
    $employee_id = $_GET['id'];

    // First, delete the associated user from the `users` table
    $delete_user_query = "DELETE FROM users WHERE id = (SELECT user_id FROM employees WHERE id = '$employee_id')";
    
    // Then, delete the employee from the `employees` table
    $delete_employee_query = "DELETE FROM employees WHERE id = '$employee_id'";

    // Start transaction to ensure both queries are executed
    $conn->begin_transaction();

    try {
        // Execute both queries
        if ($conn->query($delete_user_query) && $conn->query($delete_employee_query)) {
            // Commit the transaction if both queries succeed
            $conn->commit();
            // Redirect to the manage employees page with a success message
            header("Location: manage_employees.php?message=Employee deleted successfully.");
            exit();
        } else {
            // If something goes wrong, rollback the transaction
            $conn->rollback();
            echo "Error deleting employee.";
        }
    } catch (Exception $e) {
        // Rollback in case of error
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request. No employee ID provided.";
}
?>
