<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// .aknow file producer for AI-BOLIT, http://revisium.com/ai/
// Revisium, Greg Zemskov, ai@revisium.com
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

define('CRC32_LIMIT', pow(2, 31) - 1);
define('CRC32_DIFF', CRC32_LIMIT * 2 -2);

if ($argc == 3) {
// ------------------------------------------------------------
   $global_list = array();
   $all_files = scan_directory_recursively(trim($argv[1]));

   if ($f = fopen('.aknown.' . trim($argv[2]), 'w')) {
      foreach ($global_list as $item) {
          if ($item['acrc'] != '') {
             fputs($f, $item['acrc'] . "\n");
          }
      }

      fclose($f);
   } else {
     die('Cannot create .aknown file.');
   }
} else {
  echo "Usage: php aknown_producer.php <root_folder> <postfix>\n\n";
  echo "Example: php aknown_producer.php ./wordpress-3.9 wp_3.9\n";
  echo ".aknown.wp_3.9 will be generated.\n\n";
}

exit;

// ------------------------------------------------------------
function realCRC($str_in, $full = false)
{
        $in = crc32( $full ? normal($str_in) : $str_in );
        return ($in > CRC32_LIMIT) ? ($in - CRC32_DIFF) : $in;
}


// ------------------------------------------------------------
function scan_directory_recursively($directory, $filter = FALSE)
{
        global $global_list, $global_ignore_dir, $global_ignore_file;

       for ($i = 0; $i < count($global_ignore_dir); $i++) 
       {
           if (stripos($directory, $global_ignore_dir[$i]) !== false) {
              return; 
           }
       } 

	// if the path has a slash at the end we remove it here
	if(substr($directory,-1) == '/')
	{
		$directory = substr($directory,0,-1);
	}

	// if the path is not valid or is not a directory ...
	if(!file_exists($directory) || !is_dir($directory))
	{
		// ... we return false and exit the function
		return FALSE;

	// ... else if the path is readable
	} elseif(is_readable($directory))
	{
		// initialize directory tree variable
		$directory_tree = array();

		// we open the directory
		$directory_list = opendir($directory);

		// and scan through the items inside
		while (FALSE !== ($file = readdir($directory_list)))
		{

                  $ignore_file = false;
                  for ($i = 0; $i < count($global_ignore_file); $i++) 
                  {
                      if (stripos($file, $global_ignore_file[$i]) !== false) {
                         $ignore_file = true;
			    break;
                      }
                  } 

                  if ($ignore_file) continue;

			// if the filepointer is not the current directory
			// or the parent directory
			if($file != '.' && $file != '..')
			{
				// we build the new path to scan
				$path = $directory . '/' . $file;

				print $path . ' // mem=' . memory_get_usage() . "\n";

				// if the path is readable
				if(is_readable($path))
				{
					// we split the new path by directories
					$subdirectories = explode('/', $path);


                                        $inf = null;
                                        $stat = stat($path);

					// if the new path is a directory
					if(is_dir($path))
					{
						// add the directory details to the file list
						$inf = array(
							//'pth'    => $path,
							//'nme'    => end($subdirectories),
							'knd'    => 0,
							'c'      => $stat[10],
							'm'      => $stat[9],
							'ino'      => $stat['ino'],
							'uid'    => $stat['uid'],
							'gid'    => $stat['gid'],
							'perm'   => fileperms($path),

							// we scan the new path by calling this function
							'sub' => scan_directory_recursively($path, $filter));

                                                //$directory_tree[] = $inf;

					// if the new path is a file
					} else
					{
						// get the file extension by taking everything after the last dot
                                                $path_info = pathinfo($path);
						$extension = $path_info['extension'];

						// if there is no filter set or the filter is set and matches
						if($filter === FALSE || $filter == $extension)
						{
							// add the file details to the file list
                                                 $crc = 0; 
                                                 if (($stat[7] < 5 * 1024 * 1024)) {  
							$content = implode('', file($path));
							$crc = realCRC($content);
                                                 	unset($content); 
                                                 }
                                                        $adv_crc = $crc + realCRC(basename($path));

							$inf = array(
								//'pth'      => $path,
								//'nme'      => end($subdirectories),
								'crc'      => $crc,
								'acrc'      => $adv_crc,
								'ext' 	=> $extension,
								'sze'      => $stat[7],
								'c'      => $stat[10],
								'm'      => $stat[9],
								'ino'      => $stat['ino'],
							        'uid'    => $stat['uid'],
							        'gid'    => $stat['gid'],
							        'perm'   => fileperms($path),
								'knd'      => 1);

                                                        //$directory_tree[] = $inf;
						}
					}

 					if ($inf != null) 
					{
                                            $sum_crc = '';
                                            foreach($inf as $field) {
                                               $sum_crc .= $field;
                                            }

                                                $inf['chk'] = realCRC($sum_crc);
 						if (isset($inf['sub'])) 
						{
							$inf['chd'] = count($inf['sub']);
							unset($inf['sub']);
						}
						$global_list[$path] = $inf;
						unset($inf);					

                                        }
				}
			}
		}

		// close the directory
		closedir($directory_list);

		// return file list
		return $directory_tree;

	// if the path is not readable ...
	} else{
		// ... we return false
		return FALSE;
	}
}

?>