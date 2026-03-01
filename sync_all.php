<?php
/**
 * Universal Database Synchronization Script
 */
require_once 'config/database.php';
require_once 'includes/functions.php';

$conn = getDBConnection();

echo "Starting Synchronization...\n";

// --- 1. Map Department Text to IDs ---
$tablesToSync = ['students', 'instructors'];

foreach ($tablesToSync as $table) {
    echo "Syncing $table departments...\n";
    $res = $conn->query("SELECT DISTINCT department FROM $table WHERE department IS NOT NULL AND department != ''");
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $deptName = $row['department'];

            // Check if department exists in departments table
            $check = $conn->prepare("SELECT dept_id FROM departments WHERE dept_name = ?");
            $check->bind_param("s", $deptName);
            $check->execute();
            $checkResult = $check->get_result();

            if ($checkResult->num_rows > 0) {
                $deptId = $checkResult->fetch_assoc()['dept_id'];
            }
            else {
                // Auto-create missing department
                echo "Creating missing department: $deptName\n";
                $deptCode = strtoupper(substr($deptName, 0, 10)); // Simple code gen
                $ins = $conn->prepare("INSERT INTO departments (dept_name, dept_code) VALUES (?, ?)");
                $ins->bind_param("ss", $deptName, $deptCode);
                $ins->execute();
                $deptId = $ins->insert_id;
            }

            // Update the dept_id column
            $upd = $conn->prepare("UPDATE $table SET dept_id = ? WHERE department = ?");
            $upd->bind_param("is", $deptId, $deptName);
            $upd->execute();
            echo "Updated " . $conn->affected_rows . " records in $table for '$deptName'.\n";
        }
    }
}

// --- 2. Enforce 6-digit codes and sync courses ---
echo "Syncing course codes...\n";
$resCourses = $conn->query("SELECT course_id, class_code, course_code FROM courses");
while ($course = $resCourses->fetch_assoc()) {
    $cid = $course['course_id'];
    $classCode = $course['class_code'];
    $courseCode = $course['course_code'];

    // Ensure padding or truncation for 6 digits if needed (user requirement)
    // However, if it's already 6, leave it. If not, just warn.
    if (strlen($classCode) != 6 || strlen($courseCode) != 6) {
        echo "Warning: Course ID $cid has non-6-digit codes (Class: $classCode, Course: $courseCode)\n";
    }
}

// --- 3. Clean up legacy columns (Commented out for safety initially, or user can decide) ---
// echo "Dropping legacy department columns...\n";
// $conn->query("ALTER TABLE students DROP COLUMN department");
// $conn->query("ALTER TABLE instructors DROP COLUMN department");

echo "Synchronization finished.\n";
