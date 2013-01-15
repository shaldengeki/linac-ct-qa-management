linac-ct-qa-management
======================

PHP QA app for UChicago Medical Center linear accelerators and CT machines.

To deploy this app on your stack, simply edit `global/config.php.example` to fit your production parameters and rename it to `global/config.php`. You'll need MySQL and wkhtmltopdf installed, and your PHP user will need permissions in /tmp/.

I inherited this application from [Bing Xiao](http://www.linkedin.com/profile/view?id=146802554), who previously worked for the University of Chicago Medical Center's Radiation Oncology department. Full credit for the original source code goes to him.