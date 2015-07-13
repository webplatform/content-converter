<?php

/**
 * WebPlatform Content Converter.
 *
 * export_users.php
 *
 * Helper script, make sure you run this script in the same directory
 * you run your MediaWiki installation.
 *
 * To use it, you have to use a terminal and send the script output
 * into a file name so you can use it with this project.
 *
 * Use:
 *
 *   - Copy contents of this file in your mediawiki/ folder, where you can see the "maintenance/" folder
 *   - In a terminal, on a machine that has PHP cli installed, execute;
 *
 *         php export_users.php > users.json
 *
 * @author Renoir Boulanger <hello@renoirboulanger.com>
 */

/**
 * You can also adjust the path yourself.
 */
$cli = realpath(__DIR__ . '/maintenance/commandLine.inc');

if (!file_exists($cli)) {
    throw new \Exception('Could not find MediaWiki code checkout in parent directory');
}
require $cli;

/**
 * Export all user data into a big JSON string.
 *
 * Will be an array of objects, looking like this;
 *
 * [{
 *  "user_email":"public-webplatform@w3.org",
 *  "user_id":"1","user_name":"WikiSysop",
 *  "user_real_name":"",
 *  "user_email_authenticated":null
 * }]
 **/

// ref: https://www.mediawiki.org/wiki/Manual:Database_access
$dbr = wfGetDB(DB_SLAVE);

// ref: https://www.mediawiki.org/wiki/Manual:User_table
$id_list = $dbr->select('user', array('user_email', 'user_id','user_name','user_real_name','user_email_authenticated'));

$out = array();
foreach ($id_list as $user_data) {
    $out[] = (array) $user_data;
}

echo json_encode($out);
