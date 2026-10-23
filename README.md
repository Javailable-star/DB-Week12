# Authentication Exercise

This project extends the previous Resume CRUD Lab with PHP Authentication.

## New Features

User registration with password hashing

Login using prepared statements and password_verify()

PHP Session authentication

Secure logout using POST and CSRF protection

User-specific Resume and Skill CRUD operations

## Authentication Flow

Users register with their email and password.

Passwords are securely hashed before being stored in MySQL.

After successful login, the system stores user_id, profile_id, and email in the PHP Session.

Users can manage only their own Skills.

Logout destroys the Session and redirects to the Login page.

## Database

Added the users table using database/this_week_migration.sql without deleting the previous database tables.

## Live Website

https://angsila.informatics.buu.ac.th/~68160197/login.php

## Previous Week

Resume CRUD Lab: INSERT, SELECT, UPDATE, DELETE.

# Resume CRUD Lab: INSERT / UPDATE / DELETE

Continue from the previous PHP/MySQL Resume Lab. Student target: manage the `skill` table.

## Setup
1. Use a separate practice database. Import `database/setup.sql` with phpMyAdmin. **Caution: this file DROPS existing resume_lab tables and resets their data.** Do not import into a database with important data.
2. Start Apache + MySQL, place this folder inside your local web root, and visit `http://localhost/<folder>/skills.php`.
3. Configure `config/db.php` for your environment. Defaults `localhost/root/empty password` are for local labs only. For Angsila, obtain real database settings from the administrator and keep credentials out of Git.
4. Read the files: `skills.php`, `skill_create.php`, `skill_edit.php`, `skill_delete.php`.

## Student activities
- Task 1 (INSERT): `skill_create.php` TODO 1, save a new skill, confirm the row appears.
- Task 2 (SELECT + UPDATE): `skill_edit.php` TODO 2a/2b, change level and verify the new value.
- Task 3 (DELETE): `skill_delete.php` TODO 3, delete one practice record and verify it disappears.
- Task 4: explain why UPDATE and DELETE require WHERE. Demonstrate parameter binding.
## Task 4: คำอธิบาย WHERE และ Parameter Binding
### 1. ทำไม UPDATE และ DELETE ต้องใช้ WHERE?
WHERE ใช้กำหนดเงื่อนไขในการเลือกข้อมูลที่ต้องการแก้ไขหรือลบออกจากฐานข้อมูล หากไม่ใช้ WHERE คำสั่ง UPDATEหรือ DELETE อาจส่งผลต่อข้อมูลทุกแถวในตารางทำให้ข้อมูลถูกแก้ไขหรือลบโดยไม่ตั้งใจ WHERE ใช้กำหนดเงื่อนไขในการเลือกข้อมูลที่ต้องการแก้ไข หรือลบออกจากฐานข้อมูล หากไม่ใช้ WHERE คำสั่ง UPDATE หรือ DELETE อาจส่งผลต่อข้อมูลทุกแถวในตาราง ทำให้ข้อมูลถูกแก้ไขหรือลบโดยไม่ตั้งใจ

### 2. Parameter Binding สำคัญอย่างไร?
Parameter Binding คือการส่งค่าตัวแปรเข้าสู่คำสั่ง SQL ผ่าน Prepared Statement โดยใช้เครื่องหมาย ? เป็น Placeholder แทนการนำข้อมูลมาต่อกับ SQL โดยตรง วิธีนี้ช่วยป้องกัน SQL Injection และทำให้การจัดการ ข้อมูลในฐานข้อมูลมีความปลอดภัยมากขึ้น

### 3. ตัวอย่างการใช้ Parameter Binding
คำสั่ง SQL สำหรับลบทักษะ:
DELETE FROM skill WHERE id = ? AND profile_id = ?;
คำสั่ง PHP สำหรับกำหนดค่า Parameter:
mysqli_stmt_bind_param($stmt, 'ii', $id, $pid);
โดย 'ii' หมายถึงข้อมูลชนิด Integer จำนวน 2 ค่า
ได้แก่ id ของทักษะ และ profile_id ของเจ้าของข้อมูล
การใช้ WHERE ร่วมกับ Parameter Binding
ช่วยให้ลบเฉพาะข้อมูลที่ต้องการและลดความเสี่ยง
จาก SQL Injection

- Task 5: Git workflow: create feature branch, commit SQL completion, push to GitHub (NO secrets), submit repository URL and screenshots.

## SQL mapping hints
- INSERT: `INSERT INTO ... (...) VALUES (?, ?, ?)`; bind order: `profile_id`, `skill_name`, `skill_level`.
- SELECT: filter using `id = ? AND profile_id = ?`.
- UPDATE: `SET skill_name = ?, skill_level = ?` with both WHERE conditions.
- DELETE: do not omit `WHERE id = ? AND profile_id = ?`.

## Security / scope
The CRUD pages use prepared statements, validation, output escaping, POST for changes, and CSRF tokens. They target the first demo profile only. This is an **unauthenticated classroom example**, not suitable for public deployment on Angsila without sign-in, authorization and production hardening. Prefer local-only access for exercises.

## Grading (100 points)
INSERT 25, SELECT+UPDATE 30, DELETE 25, screenshots/testing 10, Git commits 10.

**Starter:** fill all TODO SQL queries before submitting.
