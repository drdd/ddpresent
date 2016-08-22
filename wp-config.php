<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'noname');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'g=%i1cME}+I`B4l8l@3b$]ZcL=4d4ud%&9inf!,R#mcM{2B?|!-n*Zq^i_jGUI*r');
define('SECURE_AUTH_KEY',  'IP|]Zu{9WO] +ZNT.~<WLBt}fM<Jfa-7H)1dn>:a+3CyLTeneo(i{+VcA+zDF1&+');
define('LOGGED_IN_KEY',    '6KC e(p|PsB`b),vp3hHCO+LKO8ikeelc@S9ik@/O:AdM%C$-bzhIg6 E*z{/OXl');
define('NONCE_KEY',        'BL(KR.;ae4A<d1p+$Q}i75Smvi.K:6OVzWyQwCs}.5o=S0+>j|XJ*BdXesQ~/:Wp');
define('AUTH_SALT',        'IJ9$+L+3T*$!#:|4l85c-r[Va6mklN1!UHcbb%5i`-pfq1E>5aM6]EuE$Z[KG7cb');
define('SECURE_AUTH_SALT', '-&Zz20V3V:zPs&RtmGG dc)UHTL9M2 d8:[lvAOw7-2&EKc|W>gAZ*H]M<3xr1*3');
define('LOGGED_IN_SALT',   'qx!Ihd-08~~dMhZEqIV]r][5u3GEw9[E^v9cpM;yS_LJBt|:X`R@3W/C+0;xX^O]');
define('NONCE_SALT',       'L-IkMtT-AKeS8+b9$_@{/@i;(wv6*~}qrOeA1tkJcSe#oFmY|zx:m>E-vl<WWGi-');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
