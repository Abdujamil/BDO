<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', "BDO" );

/** Database username */
define( 'DB_USER', "root" );

/** Database password */
define( 'DB_PASSWORD', "" );

/** Database hostname */
define( 'DB_HOST', "localhost" );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'M3Cd-efF3S4%LWasp%(im4]uaL`tpMnmEO0odRe-|uhxIp9OyHvF8s)l,p8z r}(' );
define( 'SECURE_AUTH_KEY',  '<WWk.,VgvX-S#S>uE0m7Cc b^2{e?7u%|.3AKH<$v7.FOw;qXq`1I@R9+?>hogGG' );
define( 'LOGGED_IN_KEY',    'ETL$SVV]Eg-,!x_8+L`R%qU[O{p<|68d suJ{@ x!:]i1~lcx[7n*ePi*JHYKpm ' );
define( 'NONCE_KEY',        'vCH_38n+btRxfw4Pl*Rs`Ur>!V!hcJ~n(O0b=;Z]LE1fu*H<: {|Pq 8hUcdV~;y' );
define( 'AUTH_SALT',        'z$sr!L$dXxEw0zGM_6*HbuDh!K(D,L{2|6L^4rOXA!vxfGcmkMO7gF.BayJjlpHo' );
define( 'SECURE_AUTH_SALT', '7~aFK55q-r&K}C6=T +/B[LefX`;V~01ViBCT&F@i=Jh^zqYOS_(U9EmITX/Lw~V' );
define( 'LOGGED_IN_SALT',   '1Bchte/:v+!2zk+LQrLWATNA2}|t/?x;j~<;1c*W]4hdttI..3cK8ZdZ%8<EVI1@' );
define( 'NONCE_SALT',       '|Tah!-Q4R|qvMX/I4KI59H4!T%Sv>=>c=4`m}`v%I@[~SlaxqNjA8FB&zPdnkG<`' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', true );

/* Add any custom values between this line and the "stop editing" line. */



define( 'WP_SITEURL', 'http://bdo/' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname(__FILE__) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
