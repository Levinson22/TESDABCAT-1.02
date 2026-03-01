-- TESDA-BCAT Database Synchronization Script
-- This script ensures all tables have the necessary columns for the latest updates.

USE tesda_db;

-- 1. Add Schedule and Room to class_sections
-- These fields are used for student availability and scheduling.
ALTER TABLE class_sections 
ADD COLUMN IF NOT EXISTS schedule VARCHAR(100) DEFAULT NULL AFTER school_year,
ADD COLUMN IF NOT EXISTS room VARCHAR(50) DEFAULT NULL AFTER schedule;

-- 2. Add Grade Review Tracking to grades
-- This allows Department Heads to mark grades as internally reviewed.
ALTER TABLE grades 
ADD COLUMN IF NOT EXISTS is_reviewed TINYINT(1) DEFAULT 0 AFTER status;

-- 3. Add Dept_ID to core tables for departmental association
-- Ensure users, students, instructors, and courses are linked to a department.

-- Students
ALTER TABLE students 
ADD COLUMN IF NOT EXISTS dept_id INT(11) DEFAULT NULL AFTER department;

-- Instructors
ALTER TABLE instructors 
ADD COLUMN IF NOT EXISTS dept_id INT(11) DEFAULT NULL AFTER department;

-- Courses
ALTER TABLE courses 
ADD COLUMN IF NOT EXISTS dept_id INT(11) DEFAULT NULL AFTER course_name;

-- Users
ALTER TABLE users 
ADD COLUMN IF NOT EXISTS dept_id INT(11) DEFAULT NULL AFTER role;

-- 4. Ensure indices for performance
CREATE INDEX IF NOT EXISTS idx_class_sections_schedule ON class_sections(schedule);
CREATE INDEX IF NOT EXISTS idx_class_sections_room ON class_sections(room);
CREATE INDEX IF NOT EXISTS idx_grades_is_reviewed ON grades(is_reviewed);
CREATE INDEX IF NOT EXISTS idx_students_dept_id ON students(dept_id);
CREATE INDEX IF NOT EXISTS idx_instructors_dept_id ON instructors(dept_id);
CREATE INDEX IF NOT EXISTS idx_courses_dept_id ON courses(dept_id);
CREATE INDEX IF NOT EXISTS idx_users_dept_id ON users(dept_id);

-- 5. New System Settings for Official Documents (Logo Size, Titles)
INSERT IGNORE INTO system_settings (setting_key, setting_value, setting_type, description, updated_by) VALUES 
('logo_size', '120', 'number', 'Logo size in pixels for official documents (TOR/COR)', 1),
('student_doc_title', 'CERTIFICATION OF RECORD (COR)', 'text', 'Main title for the grade report in the student portal', 1),
('registrar_doc_title', 'OFFICIAL TRANSCRIPT OF RECORDS', 'text', 'Main title for the official TOR in the registrar portal', 1);

-- 6. Verification: Done.
