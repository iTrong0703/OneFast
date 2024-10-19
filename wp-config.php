<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'onefast_db' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost:3307' );

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
define( 'AUTH_KEY',         'T(Ugv::mwVs|.QCS3<N;ogXerLBs`0D.y(z>&?xq7d+ewuG3V/Fp8ydvMNDS9ytV' );
define( 'SECURE_AUTH_KEY',  'Q68?|F/3 S]TH6+$QNknw<6/?,A/^A1nM!u6A6G64tOk}Px&;8x-,oSOCm-%15TU' );
define( 'LOGGED_IN_KEY',    '`%0{nY ^wQV9[;Zk q,U?]75lB$ =Ga5@(Nx/d)Fg]L3)s-Nj@/f >W8&g-A93Je' );
define( 'NONCE_KEY',        '%r0&Gyp.^=Afnic#:k:C!wgbyq.m*398i@E;N-Q<Yb06`mtzL@Xh]AR*Kzzm:ZDB' );
define( 'AUTH_SALT',        '-?t05dz3&3lm:A+Gr<5|0c7F<JbW&oVxDhzHVksi@5lrc3Cq!w.-:|0N:51ohg+q' );
define( 'SECURE_AUTH_SALT', 'bTtUe4kUyq%E&(:a{#8so?/w7kyH9RdhpsDZGzRo&^19M?5ZF;V`_Y+6C%&WG?MA' );
define( 'LOGGED_IN_SALT',   ')15Z?02~!2@;CNv+01MST*dqu&OFuR|xrCj8$XJfR15[jMnxc[Sr:~Xy]];62NU`' );
define( 'NONCE_SALT',       'GUjns=b|Y.0:+p]4U?er*)`fsjE>xCd-ijOhIkl-ROq nN4zk9#5ImC8=wU>Wx%$' );

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
