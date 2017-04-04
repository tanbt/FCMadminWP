### INSTALLATION ###

#### Check:
* wp-config.php must have define('JWT_AUTH_SECRET_KEY', 'myownsecretkey');
* .htaccess must have 
    * RewriteCond %{HTTP:Authorization} ^(.*)
    * RewriteRule ^(.*) - [E=HTTP_AUTHORIZATION:%1]

