# turfsurfer
Custom Google Maps Manager

Setup
--------------

Before using the app, ensure you have a MySQL database with a "markers" table for the app to use:

    CREATE TABLE `markers` (
      `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
      `name` VARCHAR( 60 ) NOT NULL ,
      `address` VARCHAR( 80 ) NOT NULL ,
      `lat` FLOAT( 10, 6 ) NOT NULL ,
      `lng` FLOAT( 10, 6 ) NOT NULL
    ) ENGINE = MYISAM ;


Then sure to update the config.php settings to match your own database settings:

    $db_username = 'XXXXXXXXXXXXXX';
    $db_password = 'XXXXXXXXXXXXXX';
    $db_name = 'XXXXXXXXXXXXXX';

Finally, edit index.html and replace the following string (on line 7) with [your own API key from Google](https://developers.google.com/maps/documentation/javascript/get-api-key):

    {YOUR_API_KEY_HERE}

*Note: the '{' and '}' characters should be replaced, too - they should not be present in the final URL you use.*

Once the above steps are completed, you can load the index.html page in your browser and use TurfSurfer!
