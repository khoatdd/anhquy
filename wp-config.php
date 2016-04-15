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
define('DB_NAME', 'anhquy');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         'h*:lk,fYe?Mfn~&cVGy$em2q>Vv_t*d-Qe;ROY^NCZYOQw@ZQ,n2W[vX2+mj,=[ ');
define('SECURE_AUTH_KEY',  'J*70al4nK`oLQ3C71;^:WQ>zd|gowz;D +>-])%Gsn|=whb+c[F~Uo,0WnvD74-@');
define('LOGGED_IN_KEY',    'm`DQ&;q,G>T4|^>dobDF(~BWcAmnewe@$kuNW^0hfnuQ,,g:4^YWblYP(xp0Q0-2');
define('NONCE_KEY',        '|o4dKgMGW++qd$ 5zH}fZS]?U<e~/_[HX*igv2G(]9Y6+8@_@vOJ?S^$]}%bYugQ');
define('AUTH_SALT',        'Mn22g|2t-A|:QcM8 @-|#(Yt$agyW8$VLk1o;Y+50Tc0HUt+-E-ON@/2@ky4/$~K');
define('SECURE_AUTH_SALT', 'D/FX[Sw!V:mdkP?@~=1u/PZO/`9i~**r4n-p)|VgDL)A*(6&c---6396az]C^A(e');
define('LOGGED_IN_SALT',   'fl5~L48%$pRO*7<I:`MJe}Mh|oXJC+h]2,5XIQVOH%0,lu_N3vh>{BE?Y;A0-:}?');
define('NONCE_SALT',       '0!1FgdTtrtc(?_Jso#s_ZW+^r5uP%zrN(|#+i*i~b-9l0*QUp4L)AL-&&=^##^tL');

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
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
