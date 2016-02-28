<?php

// Enable logging
define('LOG', true);
define('LOG_FILE', 'aibolit-wl-generator.log');

date_default_timezone_set('Europe/Moscow');

define('DB_FILE', 'AIBOLIT-WHITELIST.db');

define('MAX_SIZE_TO_SCAN', 600 * 1000);

$extensions_list = array('php', 'php5', 'php7', 'phtml', 'htm', 'html', 'htaccess', 'cgi', 'js', 'css', 'pl', 'py', 'sh', 'shtml', 'txt', 'inc', 'tpl', 'dat');

if ($argc != 2) {
	die("Usage: php $argv[0] <root_folder>\n\n");
}


$db = load_db(DB_FILE);

if (LOG) _log_("\nStart " . date("d/m/Y H:i:s", time()));

scan_directory_recursively($argv[1]);

save_db($db, DB_FILE);

if (LOG) _log_("Finish " . date("d/m/Y H:i:s", time()), true);

exit;



function scan_directory_recursively($directory, $filter = FALSE)
{
	global $extensions_list;

	echo "Scan: " . $directory . "\n";

	$handle = @opendir($directory);
	
	if ($handle === false) return;
	
	while (false !== ($file = readdir($handle)))
	{
		if ($file == '.' || $file == '..') continue;

		$path = $directory . '/' . $file;
		
		$type = filetype($path);
		
		if ($type == 'dir') scan_directory_recursively($path);

		if ($type == 'file') {
			$extension = pathinfo($path, PATHINFO_EXTENSION);

			if (!in_array($extension, $extensions_list)) continue;

			if (filesize($path) > MAX_SIZE_TO_SCAN) continue;

			$hash = _hash_($path);
			
			$ok = insert_into_whitelist(pack("H*", $hash));
			
			if (LOG) _log_( ($ok ? "new" : "dup") . " $hash|$path" );
		}
	}

	closedir($handle);
}


function _hash_($file)
{
	static $r;
	
	if (empty($r)) {
		for ($i = 0; $i < 256; $i++) {
			if ($i < 33 OR $i > 127 ) $r[chr($i)] = '';
		}
	}

	$content = @php_strip_whitespace($file);

	$content = strtr($content, $r);

	return sha1($content);
}


function insert_into_whitelist($item)
{
	global $db;

	$str =& $db[ord($item[0])];
	
	$item_size = strlen($item);
	
	if ( $item_size == 0 ) return false;
	
	$first = 0;

	$last = floor(strlen($str)/$item_size);
	
	/* Если просматриваемый участок непустой, first < last */
	while ($first < $last) {
		$mid = $first + (($last - $first) >> 1);
		$b = substr($str, $mid * $item_size, $item_size);
		if (strcmp($item, $b) <= 0)
			$last = $mid;
		else
			$first = $mid + 1;
	}

	$b = substr($str, $last * $item_size, $item_size);
	if ($b == $item) {
        /* Искомый элемент уже добавлен. */
		return false;
	} else {
        /* Искомый элемент не найден.
         * Вставляем со сдвигом в позицию - last.
         */
		$str = substr_replace($str, $item, $last * $item_size, 0);
		return true;
	}
}


function load_db($file)
{
	$db = array_fill(0, 256, '');

	$fp = fopen($file, 'rb');
	
	if (false === $fp) return $db;

	$header = unpack('V256', fread($fp, 1024));

	foreach ($header as $key => $size) {
		if ($size > 0) $db[$key-1] = fread($fp, $size);
	}

	fclose($fp);

	return $db;
}


function save_db($db, $file)
{
	$header = array();
	foreach ($db as $key => $value) {
		$header[$key] = pack('V', strlen($value));
	}
	
	$fp = fopen($file, 'wb') or die("Cannot create $file.");
	
	fwrite($fp, implode($header));
	foreach ($db as $s) {
		fwrite($fp, $s);
	}
	
	fclose($fp);
}


function _log_($line, $flush = false)
{
	static $l_Buffer = '';
	
	$l_Buffer .= $line . "\n";
	
	if ($flush || strlen($l_Buffer) > 32000)
	{
		file_put_contents(LOG_FILE, $l_Buffer, FILE_APPEND);
		$l_Buffer = '';
	}
}
