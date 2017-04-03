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
define('DB_NAME', 'fcmadminwp');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '2016!Trung');

/** MySQL hostname */
define('DB_HOST', 'dbtrung.cg4hvrmu2ukm.ap-northeast-1.rds.amazonaws.com');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'x,eQ*wLh7cn(S2NA|h2uKQuJk}OFi+zai7-f9Vfda3x0xJS?d$XYSSAPA6eKj+!d');
define('SECURE_AUTH_KEY',  'G&^G_+}12Yn?`BDxR:OJQuu11mp=-)rho=RZ8+7~5N_d(Bbz>.sT3_Q->+}x81I?');
define('LOGGED_IN_KEY',    'GT{,ODlS01wEe}wP[te~O_9{#G,QqYwFv$7#Kp}#(%LR{]f4oShf-3=Rc/`F8;zq');
define('NONCE_KEY',        'e)dEV]e?7lkn ?0_Q;|a;Id{Pd)cVj]#UX/W@>xFUrQx}=(i@YJV)6LA^*@k(|Nz');
define('AUTH_SALT',        '<GtnRhzkhpP6Xjo(c!sxk|>Vz?{hZk`6r:sl7WRxN]*>L;&SQeuT;oz s>]@FX/W');
define('SECURE_AUTH_SALT', '*4+rGu5;5E4tP6Aeb xd4s!30B8VZRw_T7Q$KTS`m.iq4eP?Okz2(jtCIcvTHy8;');
define('LOGGED_IN_SALT',   'rvt)}=X%J[GNYY(|rm1M1wi66Fyd$>2%3 e<_w4Fh/<mr[Iu?Aw?_}KMOp]QhpD&');
define('NONCE_SALT',       '1A0=%mK%ddz&pqWFDDN_;[.#ZOD<@|dA0`$wlSciKjg.T%5]E4];0_*,+b!/|CC&');

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
define('WP_POST_REVISIONS', false );
define('JWT_AUTH_SECRET_KEY', 'myownsecretkey');

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
