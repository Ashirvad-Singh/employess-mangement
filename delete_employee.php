<?php
session_start();
include 'config.php';

if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $employee_id = $_GET['id'];

    $delete_user_query = "DELETE FROM users WHERE id = (SELECT user_id FROM employees WHERE id = '$employee_id')";
    
    $delete_employee_query = "DELETE FROM employees WHERE id = '$employee_id'";

    $conn->begin_transaction();

    try {
        if ($conn->query($delete_user_query) && $conn->query($delete_employee_query)) {
            $conn->commit();
            header("Location: manage_employees.php?message=Employee deleted successfully.");
            exit();
        } else {
            $conn->rollback();
            echo "Error deleting employee.";
        }
    } catch (Exception $e) {
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request. No employee ID provided.";
}
?>
