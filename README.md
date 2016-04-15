# MM811-Project
MM811-course project about data mining


Requirements:
Google Chrome browser
XAMPP

Initialization:
1. Place the folder MM811-Project under xampp/htdocs directory
2. Run XAMPP, start Apache and MySQL
3. Click "Config" button for Apache, select "PHP (php.ini)"
4. Search for "memory_limit" and change the limit from "128M" to "1024M"
5. Search for "max_execution_time" and change it from "30" to "3000"
6. Close php.ini
7. Click "Admin" button form MySQL to open phpMyAdmin page
8. Under "Import" tab, select "database.sql" in dataset directory, and click go, to create a new database: db_relations_short
9. Select the created database, under "Import" tab, select "tables.sql" in dataset directory, and click go, to create tables
10. Run page "http://localhost/MM811-Project/dataset/read_311.php" in the browser to read data from "311 explorer" dataset
11. Run page "http://localhost/MM811-Project/dataset/read_complaints.php" in the browser to read data from "bylaw infraction" dataset
12. Run page "http://localhost/MM811-Project/main.php" and finish the initialization


