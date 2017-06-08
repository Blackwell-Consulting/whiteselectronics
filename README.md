# Whites Electronics #

This is a Wordpress site.

## Installation

1. `git clone git@github.com:Blackwell-Consulting/whiteselectronics.git` into your webroot
1. `cd whiteselectronics`
1. `git clone -b '4.7.5' --single-branch --depth 1 git@github.com:WordPress/WordPress.git wp` to clone Wordpress into a sub directory (you can replace '4.7.5' with the version of wordpress you want)
1. From the project root create a local copy of `index.php`: `cp wp/index.php ./index.php`
1. Edit the `index.php` that you just copied ( the one in the site root not "wp" folder) to be `require( dirname( __FILE__ ) . '/wp/wp-blog-header.php' );` (note the addition of the `/wp` in front of `/wp-blog-header.php`)
1. From the project root, create a local copy of `wp-config.php`: `cp wp/wp-config-sample.php ./wp-config.php`
    Add the following to `wp-config.php` under the top comments:
    ````
    @define('WP_SITEURL', 'http://local.whiteselectronics.com/wp');
    @define('WP_HOME', 'http://local.whiteselectronics.com' );
    @define('WP_CONTENT_URL', 'http://local.whiteselectronics.com/wp-content');
    @define('WP_CONTENT_DIR', dirname(__FILE__).'/wp-content');
    ````
1. Ensure `WP_DEBUG` constant in `wp-config.php` is set to `true`: `define( 'WP_DEBUG', true );`
1. Copy `sample-htaccess.txt` to `.htaccess` file into your webroot
1. Create a `plugins` folder under `wp-content`
1. Create an `uploads` folder under `wp-content`
1. Log into the staging server via SFTP (credentials found in [Basecamp](https://3.basecamp.com/3542477/buckets/3913575/documents/545118669)) and download `wp-content/uploads` and `wp-content/plugins` directories into the same folder in your local project ( ignore themes and mu-plugins folders )
1. Log into the WP Engine control panel https://my.wpengine.com/
1. Navigate to the whiteselectronics install
1. Click on `phpmyadmin` in the side left menu
1. Click on `snapshot_welectronics`
1. Click "Export" at the top menu
1. Click "Go" and download "snapshot_welectronics.sql"
1. Create an empty database locally via "http://localhost/phpmyadmin" called "whiteselectronics"
1. Import the "snapshot_welectronics.sql" that you just downloaded
1. Update wp-config.php with your local database credentials
	1. define('DB_NAME', 'database_name_here'); // The name of the database for WordPress
	1. define('DB_USER', 'username_here'); // MySQL database username
	1. define('DB_PASSWORD', 'password_here'); // MySQL database password
	1. define('DB_HOST', 'localhost'); // MySQL hostname
1. CD to the theme root `cd wp-content/themes/whiteselectronics`
1. Run `npm install && gulp install` to install Node dependencies
1. Log into your local Wordpress dashboard at http://local.whiteselectronics.com/wp/wp-login.php using the staging credentials found below
1. If a database update is required, do the update
1. Navigate to `Appearance > Themes` and activate the Majestic Swing IQ theme.
1. Run `gulp` ( from the theme root ) to compile assets
1. Start gulp watch `gulp watch` and begin development

## Production / Staging Info ##

### Prod

URL: https://www.whiteselectronics.com/

### Staging

URL: https://welectronics.staging.wpengine.com/

#### WP Creds

Username: matt@mattblackwell.co

Password: P@$$w0rd
