<?php
///////////////////////////////////////////////////////////////////////////
// Created and developed by Greg Zemskov, Revisium Company
// Email: ai@revisium.com, http://revisium.com/ai/, skype: greg_zemskov
// For non-commercial usage only
///////////////////////////////////////////////////////////////////////////

$found_dirs = array();

// exclude from scan list
$exclude_dirs = array(
    '/usr/share', 
    '/var/www',
	'/usr'
                );

// add extra dirs to scan list
$include_dirs = array(
    '/tmp', 
    '/var/tmp'
                );


////////////////////////////////////////////////////////////////////////////////////////////////////////
function scan_configs($path, $recurs) {
	global $found_dirs;
	if (!file_exists($path)) {
           return; 
        }
		
	if ($dir = opendir($path)) {
		while($file = readdir($dir)) {
			if (($file == '.') or ($file == '..'))
				continue;
			
			$name = $file;
			$file = $path . '/' . $file;
			
			if (is_dir($file) && $recurs)  {
				scan_configs($file, true);
			}

			if (is_file($file) && filesize($file) < 5000000) {
                           $content = file_get_contents($file);
                           if ((preg_match_all('~DocumentRoot\s+[\'"]?(/[^\s\'"]+)~mi', $content, $out, PREG_PATTERN_ORDER)) ||
						   	   (preg_match_all('~DocumentRoot\s+(/.+)~mi', $content, $out, PREG_PATTERN_ORDER)) ||
                               (preg_match_all('~root\s+(/.+);$~mi', $content, $out, PREG_PATTERN_ORDER))) {
				foreach ($out[1] as $index => $docroot) {
				   $found_dirs[trim($docroot)] = 1;
                                }
                           }
                        }
		}  

		closedir($dir);
 	}
}

scan_configs('/etc/apache2', true);
scan_configs('/etc/httpd', true);
scan_configs('/usr/local/nginx/conf', true);
scan_configs('/etc/nginx', true);
scan_configs('/usr/local/etc/nginx', true);
scan_configs('/usr/local/directadmin/data', true);
scan_configs('/home/admin/conf/', true);

$result_list = array_merge(array_diff(array_keys($found_dirs), $exclude_dirs), $include_dirs);

foreach ($result_list as $dir) {
   //if (file_exists($dir)) 
	   echo $dir . "\n";
}

