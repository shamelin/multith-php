# multith-php
## Multi-theme support on your websites

(This script has been written in ~1 hour, as a challenge.)

Do you want to test new themes on some users? Do you want to create new themes in 2 seconds? This PHP script is perfect for you!
Multith is able to load theme from a database and apply it to the page.

### How does it work? (MySQL version)
It's simple: in a database, there is projects. For each project, there is themes that can be called whatever you want (ex.: v1, v2, v3, etc.).
A default theme is set in a table, so that users that don't have a custom token will get the default theme choosed by the server administrator.
You can add stylesheets and javascript scripts simply by adding them in the appropriate column of the 'multith_themes' table. Just don't forget
to separate your links by ";" so that the script will know that it's a new resource to get!

Do you want to enable or disable a theme? No problem! Just change the column 'enable' to the appropriate value.

### How to add a token with a custom theme (MySQL version)
Simply add a new row in the 'multith_tokens' table. Set the project column to your project name, the theme column to the theme you want the token
to use, and add a name to the token! After inserting the row in the table, every user with the cookie 'theme' containing the token you just set will
have the theme you selected.

### How to initiate it?
1) You need to create the database. To do so, create a database with the name you want (default is multith), then import the .sql included in
this repository;<br>
2) Fill any informations you want in the database;<br>
3) Enter the credentials to access the database in the file 'multith-php-master/multith/Multith.php';<br>
3) Initiate the PHP script on your website like so:

```php
require_once('multith-php-master/autoload.php'); # The path to the autoloader of the plugin
$multith->Initiate('{PROJECT NAME}', '{THEME YOU WANT} (OPTIONAL)');
```

You are good to go!

### My database does not support this plugin, HELP!
Fortunaly, Multith contains a simple interface that ables you to create a class to get informations from your database. See the file
'multith-php-master/multith/Database/DatabaseType.php' for more informations.

## If you need help, don't hesitate to contact me!
