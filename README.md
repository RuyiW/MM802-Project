# MM802-Project
MM811-course project about data mining
Sweta Bedmutha, Queenie Luc, Ruyi Wang

Files under MM802-Project folder:
charts folder
css folder
dataset folder
img folder
js folder
311Data.csv
Bylaw.csv
Bylaw.json
details.php
knn.php
knn_new.php
LoadData.html
main.php
main_new.php
map.html
map_page.php
map_page_new.php
ProjNNdays.php
ProjNNdistance.php
ProjNNneighbour.php
README.md


Requirements:
Google Chrome browser
XAMPP v3.2.1/v3.2.2

Initialization:
1. Place the folder MM811-Project under xampp/htdocs directory
2. Run XAMPP, start Apache and MySQL
3. Click "Config" button for Apache, select "PHP (php.ini)"
4. Search for "memory_limit" and change the limit from "128M" to "1024M"
5. Search for "max_execution_time" and change it from "30" to "3000"
6. Save and close php.ini
7. Click "Admin" button form MySQL to open phpMyAdmin page
8. Under "Import" tab, select "database.sql" in dataset directory, and click go, to create a new database: db_relations_short
9. Select the created database, under "Import" tab, select "tables.sql" in dataset directory, and click go, to create tables
10. Run page "http://localhost/MM802-Project/dataset/read_311.php" in the browser to read data from "311 explorer" dataset
11. Run page "http://localhost/MM802-Project/dataset/read_complaints.php" in the browser to read data from "bylaw infraction" dataset
12. Run page "http://localhost/MM802-Project/main_new.php" and finish the initialization


