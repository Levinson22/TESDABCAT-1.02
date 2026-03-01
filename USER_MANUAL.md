# TESDA-BCAT Grade Management System 
## Comprehensive User Manual & Procedures

Welcome to the TESDA-BCAT Grade Management System User Manual! This guide provides step-by-step instructions for all users to navigate the system effectively based on their assigned roles.

---

## 📌 1. Administrator Guide
The Administrator is responsible for system configuration, auditing, and high-level user management.

### 1.1 Managing System Users
1. **Login**: Go to the login page and enter your admin credentials.
2. **Navigate to Users**: Click on `User Management` in the left sidebar menu.
3. **Add a User**: 
   - Click the `+ Add New User` button.
   - Enter their desired username, select their role (Admin, Registrar, Instructor, or Student), set an initial password, and save.
4. **Edit/Delete User**:
   - Locate the user in the data table.
   - Click the `Edit` (pencil) icon to change their username or role.
   - Click the `Delete` (trash) icon to permanently remove their access. (Note: Deleting an active user immediately voids their session).

### 1.2 System Settings Configuration
1. Click `System Settings` on the sidebar.
2. Modify global variables like `School Name`, `Current Academic Year`, `Current Semester`, or the `Grading Scale Base Weight`.
3. Click `Save Changes`. These settings will update across all generated transcripts and dashboards instantly.

### 1.3 Viewing Audit Logs
1. Click `Audit Logs` to view all tracked activity.
2. The table shows *who* performed the action, *what* action was performed (e.g., LOGIN, LOGOUT, GRADE_UPDATE), and the timestamp.

---

## 📌 2. Registrar Guide
The Registrar manages the core academic pipeline: enrolling students, assigning instructors, processing grades, and printing transcripts.

### 2.1 Managing Instructors and Students
1. Navigate to the `Instructors` or `Students` tab on the sidebar.
2. Click `+ Add New` to create a profile.
3. Fill out the required personal and academic information. The system will automatically link their profile to a User Account for login access.

### 2.2 Creating Courses and Class Sections
1. **Add a Course**: Go to `Courses` > `+ Add Course`. Enter the Course Code, Title, and Units.
2. **Create a Section**: Go to `Class Sections` > `+ Add Section`.
   - Select the Course you just created.
   - Assign a specific **Instructor**.
   - Set the Semester and Academic Year.

### 2.3 Enrolling Students
1. Navigate to `Enrollments`.
2. Click `+ New Enrollment`.
3. Select the Student from the dropdown and the specific Class Section you want to enroll them in. Save.

### 2.4 Approving Verified Grades
1. Navigate to `Grade Approvals`.
2. You will see a list of grades currently in the `Submitted` status by Instructors.
3. Review the grades. Click the checkbox next to the student names and select **Approve**.
4. Once Approved, students can view their official grades on their portal!

### 2.5 Generating Transcripts
1. Navigate to `Transcripts`.
2. Search for the specific student using their Student ID or Name.
3. Click `Generate PDF`. The system will aggregate all their **Approved** grades and automatically calculate their GWA.

---

## 📌 3. Instructor Guide
The Instructor role is dedicated strictly to evaluating students and submitting term grades for their assigned classes.

### 3.1 Viewing Assigned Classes
1. **Login**: Access your account using your Instructor credentials.
2. Click `My Classes` from the sidebar.
3. You will see a list of all Class Sections assigned to you by the Registrar.

### 3.2 Submitting Midterm and Final Grades
1. From `My Classes`, click `View Students` on the specific section you wish to grade.
2. A list of enrolled students will appear. Click `Enter Grades`.
3. Input the **Midterm** and **Final** numeric grades for each student in the provided input boxes.
4. Click `Submit Grades`. 
   > **Note**: Grades are placed in a 'Pending/Submitted' state until the Registrar formally approves them. Once approved by the Registrar, you can no longer modify them dynamically.

### 3.3 Exporting Grade Sheets
1. Navigate to your `Grade History` or `My Classes`.
2. Select the class section.
3. Click the `Export to Excel/CSV` button. This will download a structured spreadsheet containing your class roster and their assigned grades for offline keeping.

---

## 📌 4. Student Guide
The Student role is designed for read-only access to academic progress and obtaining official records.

### 4.1 Viewing Grades and GWA Status
1. **Login**: Access the portal using the credentials provided by the Registrar.
2. The main **Dashboard** immediately displays your current **General Weighted Average (GWA)**.
3. Click `My Grades` in the sidebar to securely view the breakdown of your grades per subject. 
   > **Note**: You will only see grades that have been formally **Approved** by the Registrar. Pending instructor grades will not be visible for fairness.

### 4.2 Generating an Official Transcript
1. Click `My Transcript` from the sidebar menu.
2. Click the `Download Official Transcript` button.
3. The server will generate a consistently formatted, ready-to-print official PDF transcript spanning all your enrolled semesters at TESDA-BCAT!

---

### Need Help?
If you forget your password or run into an unfamiliar "Unauthorized" error, please contact your **Administrator** to have your account session reset or credentials verified.
