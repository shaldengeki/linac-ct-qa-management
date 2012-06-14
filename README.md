linac-ct-qa-management
======================

PHP QA app for UChicago Medical Center linear accelerators and CT machines.

To deploy this app on your stack, create `/global/config.php` with your database credentials as follows:

    define('MYSQL_HOST', 'localhost');
    define('MYSQL_USERNAME', 'username');
    define('MYSQL_PASSWORD', 'password');

I inherited this application from [Bing Xiao](http://www.linkedin.com/profile/view?id=146802554), who previously worked for the University of Chicago Medical Center's Radiation Oncology department. Full credit for the original source code goes to him.