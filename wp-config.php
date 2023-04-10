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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wadedb' );

/** Database username */
define( 'DB_USER', 'WaDe' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',         '$)aEB;u&/R<heLmYe`h<0#C4I)eG89Nk-3g|BM]^L}W-}EU53KzOeC7atCl2uE -' );
define( 'SECURE_AUTH_KEY',  '2&1],tG]= +rI;77 <_YYO} sr1^Bv/@HkD,Ib^LvnvJEGnhnX?84(yG@!B`|?q1' );
define( 'LOGGED_IN_KEY',    '~H^EKA-hK#O_wv.D]L>HwUOFTI~c E|QVK1d|1khj+B-EhiGq%9- `8 NPI/:hSM' );
define( 'NONCE_KEY',        'g9up#5(/Z.UY)_7QP5T~I0gIZ]%T6iyOn  Ds2-#e4>!kcg1&2Zm>yT-!Y6}`(;v' );
define( 'AUTH_SALT',        '#[O0?|oy(P/LY.P:`ZTAYZ0!E/h>l[TYKI;U>D.#1y4c&0IP<lB?~2 qZ88_qsLi' );
define( 'SECURE_AUTH_SALT', 'ur4-uFp})S^Y5:bsCXXDwbXL:J-6S|NH}=[Nd-*!M!X.?:i/|6xj9`Tm)]wt8N#R' );
define( 'LOGGED_IN_SALT',   'Nk(buY1:5bJ!}q/*{!Dv-.FE(qQbe*?@F+pgEPs5dh%O^T_Hrzsu2k0ty`95?7gJ' );
define( 'NONCE_SALT',       '}`9A^N=4za2|x#8Yqkr_{KlXtlur*0*izwEq{Y_1.^ZI* Vu7y |N7v-p-]|b?KR' );

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
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
