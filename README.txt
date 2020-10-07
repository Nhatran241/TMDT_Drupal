
https://weebpal.com/guides/drupal-8-marketplace-theme-guide-developers?fbclid=IwAR3mlxTpOCrnQ2oiMr1tPTU5yjTOF6k6Ys9z-kUa1Ybhp7SvhAvK28orfjM
step 1 : Clone project
step 2 : Import database with sql file in database folder
step 3 : Delete C:\xampp\htdocs\[foldername]\sites\default\settings.php
step 4 : Copy C:\xampp\htdocs\[foldername]\sites\default\default.settings.php and rename to setting.php
step 5 : open localhost\[foldername] then install with dbname = [dbname] , dbuser = root , dbpassword = ""

//Import db error fix
Changing php.ini at C:\xampp\php\php.ini
max_execution_time = 600
max_input_time = 600
memory_limit = 1024M
post_max_size = 1024M

Changing my.ini at C:\xampp\mysql\bin\my.ini
max_allowed_packet = 1024M

//admin account
username : admin
password : admin
