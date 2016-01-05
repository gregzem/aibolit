<?php
///////////////////////////////////////////////////////////////////////////
// Created and developed by Greg Zemskov, Revisium Company
// Email: ai@revisium.com, http://revisium.com/ai/, skype: greg_zemskov

// Commercial usage is not allowed without a license purchase or written permission of the author
// Source code and signatures usage is not allowed

// Certificated in Federal Institute of Industrial Property in 2012
// http://revisium.com/ai/i/mini_aibolit.jpg

////////////////////////////////////////////////////////////////////////////
// Запрещено использование скрипта в коммерческих целях без приобретения лицензии.
// Запрещено использование исходного кода скрипта и сигнатур.
//
// По вопросам приобретения лицензии обращайтесь в компанию "Ревизиум": http://www.revisium.com
// ai@revisium.com
// На скрипт получено авторское свидетельство в Роспатенте
// http://revisium.com/ai/i/mini_aibolit.jpg
///////////////////////////////////////////////////////////////////////////

// put 1 for expert mode, 0 for basic check and 2 for paranoic mode
// установите 1 для режима "Эксперта", 0 для быстрой проверки и 2 для параноидальной проверки (для лечения сайта) 
define('AI_EXPERT_MODE', 1); 

// Put any strong password to open the script from web
// Впишите вместо put_any_strong_password_here сложный пароль	 
define('PASS', '????????????????????'); 

//define('LANG', 'EN');
define('LANG', 'RU');

define('REPORT_MASK_PHPSIGN', 1);
define('REPORT_MASK_SPAMLINKS', 2);
define('REPORT_MASK_DOORWAYS', 4);
define('REPORT_MASK_SUSP', 8);
define('REPORT_MASK_CANDI', 16);
define('REPORT_MASK_WRIT', 32);
define('REPORT_MASK_FULL', REPORT_MASK_PHPSIGN | REPORT_MASK_DOORWAYS | REPORT_MASK_SUSP
/* <-- remove this line to enable "recommendations"  

| REPORT_MASK_SPAMLINKS 

 remove this line to enable "recommendations" --> */
);

define('SMART_SCAN', 1);

define('AI_EXTRA_WARN', 0);

$defaults = array(
	'path' => dirname(__FILE__),
	'scan_all_files' => 0, // full scan (rather than just a .js, .php, .html, .htaccess)
	'scan_delay' => 0, // delay in file scanning to reduce system load
	'max_size_to_scan' => '600K',
	'site_url' => '', // website url
	'no_rw_dir' => 0,
    'skip_ext' => '',
	'report_mask' =>  0 // full-featured report
);


define('DEBUG_MODE', 0);

define('DIR_SEPARATOR', '/');

define('DOUBLECHECK_FILE', 'AI-BOLIT-DOUBLECHECK.php');

if ((isset($_SERVER['OS']) && stripos('Win', $_SERVER['OS']) !== false)/* && stripos('CygWin', $_SERVER['OS']) === false)*/) {
   define('DIR_SEPARATOR', '\\');
}

$g_SuspiciousFiles = array('cgi', 'pl', 'o', 'so', 'py', 'sh', 'phtml', 'php3', 'php4', 'php5', 'shtml', 'susp', 'suspected');
$g_SensitiveFiles = array_merge(array('php', 'js', 'htaccess', 'html', 'htm', 'tpl', 'inc', 'css', 'txt', 'sql'), $g_SuspiciousFiles);
$g_CriticalFiles = array('php', 'htaccess', 'cgi', 'pl', 'o', 'so', 'py', 'sh', 'phtml', 'php3', 'php4', 'php5', 'shtml', 'susp', 'suspected', 'infected');
$g_CriticalEntries = '<\?php|<\?=|#!/usr|#!/bin|eval|assert|base64_decode|system|create_function|exec|popen|fwrite|fputs|file_get_|call_user_func|file_put_|\$_REQUEST|ob_start|\$_GET|\$_POST|\$_SERVER|\$_FILES|move|copy|array_|reg_replace|mysql_|chr|fsockopen|\$GLOBALS|sqliteCreateFunction';
$g_VirusFiles = array('js', 'html', 'htm', 'suspicious');
$g_VirusEntries = '<\s*script|<\s*iframe|<\s*object|<\s*embed|fromCharCode|setTimeout|setInterval|location\.|document\.|window\.|navigator\.|\$(this)\.';
$g_PhishFiles = array('js', 'html', 'htm', 'suspected', 'php');
$g_PhishEntries = '<\s*title|<\s*html|<\s*form|<\s*body|bank|account';
$g_ShortListExt = array('php', 'php3', 'php4', 'php5', 'html', 'htm', 'phtml', 'shtml', 'khtml');

if (LANG == 'RU') {
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// RUSSIAN INTERFACE
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
define('AI_STR_001', 'Отчет сканера <a href="https://revisium.com/ai/">AI-Bolit</a> v@@VERSION@@:');
define('AI_STR_002', 'Обращаем внимание на то, что большинство CMS <b>без дополнительной защиты</b> рано или поздно <b>взламывают</b>.<p> Компания <a href="https://revisium.com/">"Ревизиум"</a> предлагает услугу превентивной защиты сайта от взлома с использованием уникальной <b>процедуры "цементирования сайта"</b>. Подробно на <a href="https://revisium.com/ru/client_protect/">странице услуги</a>. <p>Лучшее лечение &mdash; это профилактика.');
define('AI_STR_003', 'Не оставляйте файл отчета на сервере, и не давайте на него прямых ссылок с других сайтов. Информация из отчета может быть использована злоумышленниками для взлома сайта, так как содержит информацию о настройках сервера, файлах и каталогах.');
define('AI_STR_004', 'Путь');
define('AI_STR_005', 'Изменение свойств');
define('AI_STR_006', 'Изменение содержимого');
define('AI_STR_007', 'Размер');
define('AI_STR_008', 'Конфигурация PHP');
define('AI_STR_009', "Вы установили слабый пароль на скрипт AI-BOLIT. Укажите пароль не менее 8 символов, содержащий латинские буквы в верхнем и нижнем регистре, а также цифры. Например, такой <b>%s</b>");
define('AI_STR_010', "Сканер AI-Bolit запускается с паролем. Если это первый запуск сканера, вам нужно придумать сложный пароль и вписать его в файле ai-bolit.php в строке №28. <p>Например, <b>define('PASS', '%s');</b><p>
После этого откройте сканер в браузере, указав пароль в параметре \"p\". <p>Например, так <b>http://mysite.ru/ai-bolit.php?p=%s</b>. ");
define('AI_STR_011', 'Текущая директория не доступна для чтения скрипту. Пожалуйста, укажите права на доступ <b>rwxr-xr-x</b> или с помощью командной строки <b>chmod +r имя_директории</b>');
define('AI_STR_012', "Затрачено времени: <b>%s</b>. Сканирование начато %s, сканирование завершено %s");
define('AI_STR_013', 'Всего проверено %s директорий и %s файлов.');
define('AI_STR_014', '<div class="rep" style="color: #0000A0">Внимание, скрипт выполнил быструю проверку сайта. Проверяются только наиболее критические файлы, но часть вредоносных скриптов может быть не обнаружена. Пожалуйста, запустите скрипт из командной строки для выполнения полного тестирования. Подробнее смотрите в <a href="https://revisium.com/ai/faq.php">FAQ вопрос №10</a>.</div>');
define('AI_STR_015', '<div class="title">Критические замечания</div>');
define('AI_STR_016', 'Эти файлы могут быть вредоносными или хакерскими скриптами');
define('AI_STR_017', 'Вредоносные скрипты не найдены. Попробуйте сканер в режиме "Параноидальный".');
define('AI_STR_018', 'Эти файлы могут быть javascript вирусами');
define('AI_STR_019', 'Обнаружены сигнатуры исполняемых файлов unix и нехарактерных скриптов. Они могут быть вредоносными файлами');
define('AI_STR_020', 'Двойное расширение, зашифрованный контент или подозрение на вредоносный скрипт. Требуется дополнительный анализ');
define('AI_STR_021', 'Подозрение на вредоносный скрипт');
define('AI_STR_022', 'Символические ссылки (symlinks)');
define('AI_STR_023', 'Скрытые файлы');
define('AI_STR_024', 'Возможно, каталог с дорвеем');
define('AI_STR_025', 'Не найдено директорий c дорвеями');
define('AI_STR_026', 'Предупреждения');
define('AI_STR_027', 'Подозрение на мобильный редирект, подмену расширений или автовнедрение кода');
define('AI_STR_028', 'В не .php файле содержится стартовая сигнатура PHP кода. Возможно, там вредоносный код');
define('AI_STR_029', 'Дорвеи, реклама, спам-ссылки, редиректы');
define('AI_STR_030', 'Непроверенные файлы - ошибка чтения');
define('AI_STR_031', 'Невидимые ссылки. Подозрение на ссылочный спам');
define('AI_STR_032', 'Невидимые ссылки');
define('AI_STR_033', 'Отображены только первые ');
define('AI_STR_034', 'Подозрение на дорвей');
define('AI_STR_035', 'Скрипт использует код, который часто встречается во вредоносных скриптах');
define('AI_STR_036', 'Директории из файла .adirignore были пропущены при сканировании');
define('AI_STR_037', 'Версии найденных CMS');
define('AI_STR_038', 'Большие файлы (больше чем %s). Пропущено');
define('AI_STR_039', 'Не найдено файлов больше чем %s');
define('AI_STR_040', 'Временные файлы или файлы(каталоги) - кандидаты на удаление по ряду причин');
define('AI_STR_041', 'Потенциально небезопасно! Директории, доступные скрипту на запись');
define('AI_STR_042', 'Не найдено директорий, доступных на запись скриптом');
define('AI_STR_043', 'Использовано памяти при сканировании: ');
define('AI_STR_044', 'Просканированы только файлы, перечисленные в ' . DOUBLECHECK_FILE . '. Для полного сканирования удалите файл ' . DOUBLECHECK_FILE . ' и запустите сканер повторно.');
define('AI_STR_045', '<div class="rep">Внимание! Выполнена экспресс-проверка сайта. Просканированы только файлы с расширением .php, .js, .html, .htaccess. В этом режиме могут быть пропущены вирусы и хакерские скрипты в файлах с другими расширениями. Чтобы выполнить более тщательное сканирование, поменяйте значение настройки на <b>\'scan_all_files\' => 1</b> в строке 50 или откройте сканер в браузере с параметром full: <b><a href="ai-bolit.php?p=' . PASS . '&full">ai-bolit.php?p=' . PASS . '&full</a></b>. <p>Не забудьте перед повторным запуском удалить файл ' . DOUBLECHECK_FILE . '</div>');
define('AI_STR_050', 'Замечания и предложения по работе скрипта и не обнаруженные вредоносные скрипты присылайте на <a href="mailto:ai@revisium.com">ai@revisium.com</a>.<p>Также будем чрезвычайно благодарны за любые упоминания скрипта AI-Bolit на вашем сайте, в блоге, среди друзей, знакомых и клиентов. Ссылочку можно поставить на <a href="https://revisium.com/ai/">https://revisium.com/ai/</a>. <p>Если будут вопросы - пишите <a href="mailto:ai@revisium.com">ai@revisium.com</a>. ');
define('AI_STR_051', 'Отчет по ');
define('AI_STR_052', 'Эвристический анализ обнаружил подозрительные файлы. Проверьте их на наличие вредоносного кода.');
define('AI_STR_053', 'Много косвенных вызовов функции');
define('AI_STR_054', 'Подозрение на обфусцированные переменные');
define('AI_STR_055', 'Подозрительное использование массива глобальных переменных');
define('AI_STR_056', 'Дробление строки на символы');
define('AI_STR_057', 'Сканирование выполнено в экспресс-режиме. Многие вредоносные скрипты могут быть не обнаружены.<br> Рекомендуем проверить сайт в режиме "Эксперт" или "Параноидальный". Подробно описано в <a href="https://revisium.com/ai/faq.php">FAQ</a> и инструкции к скрипту.');
define('AI_STR_058', 'Обнаружены фишинговые страницы');

define('AI_STR_059', 'Мобильных редиректов');
define('AI_STR_060', 'Вредоносных скриптов');
define('AI_STR_061', 'JS Вирусов');
define('AI_STR_062', 'Фишинговых страниц');
define('AI_STR_063', 'Исполняемых файлов');
define('AI_STR_064', 'IFRAME вставок');
define('AI_STR_065', 'Пропущенных больших файлов');
define('AI_STR_066', 'Ошибок чтения файлов');
define('AI_STR_067', 'Зашифрованных файлов');
define('AI_STR_068', 'Подозрительных (эвристика)');
define('AI_STR_069', 'Символических ссылок');
define('AI_STR_070', 'Скрытых файлов');
define('AI_STR_072', 'Рекламных ссылок и кодов');
define('AI_STR_073', 'Пустых ссылок');
define('AI_STR_074', 'Сводный отчет');
define('AI_STR_075', 'Скрипт бесплатный только для личного некоммерческого использования. Есть <a href="https://revisium.com/ai/faq.php#faq11" target=_blank>коммерческая лицензия</a> (пункт №11).');

$tmp_str = <<<HTML_FOOTER
   <div class="disclaimer"><span class="vir">[!]</span> Отказ от гарантий: невозможно гарантировать обнаружение всех вредоносных скриптов. Поэтому разработчик сканера не несет ответственности за возможные последствия работы сканера AI-Bolit или неоправданные ожидания пользователей относительно функциональности и возможностей.
   </div>
   <div class="thanx">
      Замечания и предложения по работе скрипта, а также не обнаруженные вредоносные скрипты вы можете присылать на <a href="mailto:ai@revisium.com">ai@revisium.com</a>.<br/>
      Также будем чрезвычайно благодарны за любые упоминания сканера AI-Bolit на вашем сайте, в блоге, среди друзей, знакомых и клиентов. <br/>Ссылку можно поставить на страницу <a href="https://revisium.com/ai/">https://revisium.com/ai/</a>.<br/> 
     <p>Получить консультацию или задать вопросы можно по email <a href="mailto:ai@revisium.com">ai@revisium.com</a>.</p> 
	</div>
HTML_FOOTER;

define('AI_STR_076', $tmp_str);
define('AI_STR_077', "Подозрительные параметры времени изменения файла");
define('AI_STR_078', "Подозрительные атрибуты файла");
define('AI_STR_079', "Подозрительное местоположение файла");
define('AI_STR_080', "Обращаем внимание, что обнаруженные файлы не всегда являются вирусами и хакерскими скриптами. Сканер старается минимизировать число ложных обнаружений, но это не всегда возможно, так как найденный фрагмент может встречаться как во вредоносных скриптах, так и в обычных.");
define('AI_STR_081', "Уязвимости в скриптах");
define('AI_STR_082', "Добавленные файлы");
define('AI_STR_083', "Измененные файлы");
define('AI_STR_084', "Удаленные файлы");
define('AI_STR_085', "Добавленные каталоги");
define('AI_STR_086', "Удаленные каталоги");
define('AI_STR_087', "Изменения в файловой структуре");

$l_Offer =<<<OFFER
    <div>
	 <div class="crit" style="font-size: 17px;"><b>Внимание! Наш сканер обнаружил подозрительный или вредоносный код</b>.</div> 
	 <br/>Скорее всего, ваш сайт был взломан и заражен. Рекомендуем срочно <a href="https://revisium.com/ru/order/" target=_blank>обратиться за консультацией</a> к специалистам по информационной безопасности.
	</div>
	<br/>
	<div>
	   Пришлите нам отчет в архиве .zip на <a href="mailto:ai@revisium.com">ai@revisium.com</a> для проверки вашего сайта на вирусы и взлом.<p>
	   Компания "<a href="https://revisium.com/">Ревизиум</a>" - лечение сайта от вирусов и защита от взлома.
	</div>
	<br/>
	
    <div class="caution">@@CAUTION@@</div>
OFFER;

} else {
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// ENGLISH INTERFACE
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
define('AI_STR_001', 'AI-Bolit v@@VERSION@@ Scan Report:');
define('AI_STR_002', '');
define('AI_STR_003', 'Caution! Do not leave either ai-bolit.php or report file on server and do not provide direct links to the report file. Report file contains sensitive information about your website which could be used by hackers. So keep it in safe place and don\'t leave on website!');
define('AI_STR_004', 'Path');
define('AI_STR_005', 'iNode Changed');
define('AI_STR_006', 'Modified');
define('AI_STR_007', 'Size');
define('AI_STR_008', 'PHP Info');
define('AI_STR_009', "Your password for AI-BOLIT is too weak. Password must be more than 8 character length, contain both latin letters in upper and lower case, and digits. E.g. <b>%s</b>");
define('AI_STR_010', "Open AI-BOLIT with password specified in the beggining of file in PASS variable. <br/>E.g. http://you_website.com/ai-bolit.php?p=<b>%s</b>");
define('AI_STR_011', 'Current folder is not readable. Please change permission for <b>rwxr-xr-x</b> or using command line <b>chmod +r folder_name</b>');
define('AI_STR_012', "<div class=\"rep\">%s malicious signatures known, %s virus signatures and other malicious code. Elapsed: <b>%s</b
>.<br/>Started: %s. Stopped: %s</div> ");
define('AI_STR_013', 'Scanned %s folders and %s files.');
define('AI_STR_014', '<div class="rep" style="color: #0000A0">Attention! Script has performed quick scan. It scans only .html/.js/.php files  in quick scan mode so some of malicious scripts might not be detected. <br>Please launch script from a command line thru SSH to perform full scan.');
define('AI_STR_015', '<div class="title">Critical</div>');
define('AI_STR_016', 'Shell script signatures detected. Might be a malicious or hacker\'s scripts');
define('AI_STR_017', 'Shell scripts signatures not detected.');
define('AI_STR_018', 'Javascript virus signatures detected:');
define('AI_STR_019', 'Unix executables signatures and odd scripts detected. They might be a malicious binaries or rootkits:');
define('AI_STR_020', 'Suspicious encoded strings, extra .php extention or external includes detected in PHP files. Might be a malicious or hacker\'s script:');
define('AI_STR_021', 'Might be a malicious or hacker\'s script:');
define('AI_STR_022', 'Symlinks:');
define('AI_STR_023', 'Hidden files:');
define('AI_STR_024', 'Files might be a part of doorway:');
define('AI_STR_025', 'Doorway folders not detected');
define('AI_STR_026', 'Warnings');
define('AI_STR_027', 'Malicious code in .htaccess (redirect to external server, extention handler replacement or malicious code auto-append):');
define('AI_STR_028', 'Non-PHP file has PHP signature. Check for malicious code:');
define('AI_STR_029', 'This script has black-SEO links or linkfarm. Check if it was installed by yourself:');
define('AI_STR_030', 'Reading error. Skipped.');
define('AI_STR_031', 'These files have invisible links, might be black-seo stuff:');
define('AI_STR_032', 'List of invisible links:');
define('AI_STR_033', 'Displayed first ');
define('AI_STR_034', 'Folders contained too many .php or .html files. Might be a doorway:');
define('AI_STR_035', 'Suspicious code detected. It\'s usually used in malicious scrips:');
define('AI_STR_036', 'The following list of files specified in .adirignore has been skipped:');
define('AI_STR_037', 'CMS found:');
define('AI_STR_038', 'Large files (greater than %s! Skipped:');
define('AI_STR_039', 'Files greater than %s not found');
define('AI_STR_040', 'Files recommended to be remove due to security reason:');
define('AI_STR_041', 'Potentially unsafe! Folders which are writable for scripts:');
define('AI_STR_042', 'Writable folders not found');
define('AI_STR_043', 'Memory used: ');
define('AI_STR_044', 'Quick scan through the files from ' . DOUBLECHECK_FILE . '. For full scan remove ' . DOUBLECHECK_FILE . ' and launch scanner once again.');
define('AI_STR_045', '<div class="notice"><span class="vir">[!]</span> Ai-BOLIT is working in quick scan mode, only .php, .html, .htaccess files will be checked. Change the following setting \'scan_all_files\' => 1 to perform full scanning.</b>. </div>');
define('AI_STR_050', "I'm sincerely appreciate reports for any bugs you may found in the script. Please email me: <a href=\"mailto:audit@revisium.com\">audit@revisium.com</a>.<p> Also I appriciate any reference to the script in your blog or forum posts. Thank you for the link to download page: <a href=\"https://revisium.com/aibo/\">https://revisium.com/aibo/</a>");
define('AI_STR_051', 'Report for ');
define('AI_STR_052', 'Heuristic Analyzer has detected suspicious files. Check if they are malware.');
define('AI_STR_053', 'Function called by reference');
define('AI_STR_054', 'Suspected for obfuscated variables');
define('AI_STR_055', 'Suspected for $GLOBAL array usage');
define('AI_STR_056', 'Abnormal split of string');
define('AI_STR_057', 'Scanning has been done in simple mode. It is strongly recommended to perform scanning in "Expert" mode. See readme.txt for details.');
define('AI_STR_058', 'Phishing pages detected:');

define('AI_STR_059', 'Mobile redirects');
define('AI_STR_060', 'Malware');
define('AI_STR_061', 'JS viruses');
define('AI_STR_062', 'Phishing pages');
define('AI_STR_063', 'Unix executables');
define('AI_STR_064', 'IFRAME injections');
define('AI_STR_065', 'Skipped big files');
define('AI_STR_066', 'Reading errors');
define('AI_STR_067', 'Encrypted files');
define('AI_STR_068', 'Suspicious (heuristics)');
define('AI_STR_069', 'Symbolic links');
define('AI_STR_070', 'Hidden files');
define('AI_STR_072', 'Adware and spam links');
define('AI_STR_073', 'Empty links');
define('AI_STR_074', 'Summary');
define('AI_STR_075', 'For non-commercial use only. Please, purchase the license for commercial usage of the scanner. Email us: ai@revisium.com');

$tmp_str =<<<HTML_FOOTER
		   <div class="disclaimer"><span class="vir">[!]</span> Disclaimer: We're not liable to you for any damages, including general, special, incidental or consequential damages arising out of the use or inability to use the script (including but not limited to loss of data or report being rendered inaccurate or failure of the script). There's no warranty for the program. Use at your own risk. 
		   </div>
		   <div class="thanx">
		      We're greatly appreciate for any references in the social networks, forums or blogs to our scanner AI-BOLIT <a href="https://revisium.com/aibo/">https://revisium.com/aibo/</a>.<br/> 
		     <p>Write us if you have any questions regarding scannner usage or report <a href="mailto:ai@revisium.com">ai@revisium.com</a>.</p> 
			</div>
HTML_FOOTER;
define('AI_STR_076', $tmp_str);
define('AI_STR_077', "Suspicious file mtime and ctime");
define('AI_STR_078', "Suspicious file permissions");
define('AI_STR_079', "Suspicious file location");
define('AI_STR_081', "Vulnerable Scripts");
define('AI_STR_082', "Added files");
define('AI_STR_083', "Modified files");
define('AI_STR_084', "Deleted files");
define('AI_STR_085', "Added directories");
define('AI_STR_086', "Deleted directories");
define('AI_STR_087', "Integrity Check Report");

$l_Offer =<<<HTML_OFFER_EN
<div>
 <div class="crit" style="font-size: 17px;"><b>Attention! Malicious software has been detected on the website.</b></div> 
 <br/>Most likely the website has been compromised. Please, <a href="https://revisium.com/en/home/" target=_blank>contact information security specialist</a> or experienced webmaster to clean the malware.
</div>
<br/>
<div>
   <a href="mailto:ai@revisium.com">ai@revisium.com</a>, <a href="https://revisium.com/ru/order/">https://revisium.com</a>
</div>
<div class="caution">@@CAUTION@@</div>
HTML_OFFER_EN;

define('AI_STR_080', "Notice! Some of detected files may not contain malicious code. Scanner tries to minimize a number of false positives, but sometimes it's impossible, because same piece of code may be used either in malware or in normal scripts.");
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$l_Template =<<<MAIN_PAGE
<html>
<head>
<!-- revisium.com/ai/ -->
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
<META NAME="ROBOTS" CONTENT="NOINDEX,NOFOLLOW">
<title>@@HEAD_TITLE@@</title>
<style type="text/css" title="currentStyle">
	@import "https://revisium.com/extra/media/css/demo_page2.css";
	@import "https://revisium.com/extra/media/css/jquery.dataTables2.css";
</style>

<script type="text/javascript" language="javascript" src="https://yandex.st/jquery/2.1.0/jquery.min.js"></script>
<script type="text/javascript" language="javascript" src="https://datatables.net/download/build/jquery.dataTables.js"></script>

<style type="text/css">
 body 
 {
   font-family: Tahoma;
   color: #5a5a5a;
   background: #FFFFFF;
   font-size: 14px;
   margin: 20px;
   padding: 0;
 }

.header
 {
   font-size: 34px;
   margin: 0 0 10px 0;
 }

 .hidd
 {
    display: none;
 }
 
 .ok
 {
    color: green;
 }
 
 .line_no
 {
   -webkit-border-radius: 6px;
   -moz-border-radius: 6px;
   border-radius: 6px;

   background: #DAF2C1;
   padding: 2px 5px 2px 5px;
   margin: 0 5px 0 5px;
 }
 
 .credits_header 
 {
  -webkit-border-radius: 6px;
   -moz-border-radius: 6px;
   border-radius: 6px;

   background: #F2F2F2;
   padding: 10px;
   font-size: 11px;
    margin: 0 0 10px 0;
 }
 
 .marker
 {
    color: #FF0090;
	font-weight: 100;
	background: #FF0090;
	padding: 2px 0px 2px 0px;
	width: 2px;
 }
 
 .title
 {
   font-size: 24px;
   margin: 20px 0 10px 0;
   color: #9CA9D1;
}

.summary 
{
  float: left;
  width: 500px;
}

.summary TD
{
  font-size: 12px;
  border-bottom: 1px solid #F0F0F0;
  font-weight: 700;
  padding: 10px 0 10px 0;
}
 
.crit, .vir
{
  color: #D84B55;
}

.intitem
{
  color:#4a6975;
}

.spacer
{
   margin: 0 0 50px 0;
   clear:both;
}

.warn
{
  color: #F6B700;
}

.clear
{
   clear: both;
}

.offer
{
  -webkit-border-radius: 6px;
   -moz-border-radius: 6px;
   border-radius: 6px;

   width: 500px;
   background: #ECF7DE;
   color: #747474;
   font-size: 11px;
   font-family: Arial;
   padding: 20px;
   margin: 20px 0 0 500px;
   
   font-size: 16px;
}
 
.flist
{
   font-family: Arial;
}

.flist TD
{
   font-size: 11px;
   padding: 5px;
}

.flist TH
{
   font-size: 12px;
   height: 30px;
   padding: 5px;
   background: #CEE9EF;
}


.it
{
   font-size: 14px;
   font-weight: 100;
   margin-top: 10px;
}

.crit .it A {
   color: #E50931; 
   line-height: 25px;
   text-decoration: none;
}

.warn .it A {
   color: #F2C900; 
   line-height: 25px;
   text-decoration: none;
}



.details
{
   font-family: Calibri;
   font-size: 12px;
   margin: 10px 10px 10px 0px;
}

.crit .details
{
   color: #A08080;
}

.warn .details
{
   color: #808080;
}

.details A
{
  color: #FFF;
  font-weight: 700;
  text-decoration: none;
  padding: 2px;
  background: #E5CEDE;
  -webkit-border-radius: 7px;
   -moz-border-radius: 7px;
   border-radius: 7px;
}

.details A:hover
{
   background: #A0909B;
}

.ctd
{
   margin: 10px 0px 10px 0;
   align:center;
}

.ctd A 
{
   color: #0D9922;
}

.disclaimer
{
   color: darkgreen;
   margin: 10px 10px 10px 0;
}

.note_vir
{
   margin: 10px 0 10px 0;
   //padding: 10px;
   color: #FF4F4F;
   font-size: 15px;
   font-weight: 700;
   clear:both;
  
}

.note_warn
{
   margin: 10px 0 10px 0;
   color: #F6B700;
   font-size: 15px;
   font-weight: 700;
   clear:both;
}

.note_int
{
   margin: 10px 0 10px 0;
   color: #60b5d6;
   font-size: 15px;
   font-weight: 700;
   clear:both;
}

.updateinfo
{
  color: #FFF;
  text-decoration: none;
  background: #E5CEDE;
  -webkit-border-radius: 7px;
   -moz-border-radius: 7px;
   border-radius: 7px;

  margin: 10px 0 10px 0px;   
  padding: 10px;
}


.caution
{
  color: #EF7B75;
  text-decoration: none;
  margin: 20px 0 0px 0px;   
  font-size: 12px;
}

.footer
{
  color: #303030;
  text-decoration: none;
  background: #F4F4F4;
  -webkit-border-radius: 7px;
   -moz-border-radius: 7px;
   border-radius: 7px;

  margin: 80px 0 10px 0px;   
  padding: 10px;
}

.rep
{
  color: #303030;
  text-decoration: none;
  background: #94DDDB;
  -webkit-border-radius: 7px;
   -moz-border-radius: 7px;
   border-radius: 7px;

  margin: 10px 0 10px 0px;   
  padding: 10px;
  font-size: 12px;
}

</style>

</head>
<body>

<div class="header">@@MAIN_TITLE@@ @@PATH_URL@@ (@@MODE@@)</div>
<div class="credits_header">@@CREDITS@@</div>
<div class="details_header">
   @@STAT@@<br/>
   @@SCANNED@@ @@MEMORY@@.
 </div>

 @@WARN_QUICK@@
 
 <div class="summary">
@@SUMMARY@@
 </div>
 
 <div class="offer">
@@OFFER@@
 </div>
  
 <div class="clear"></div>
 
 @@MAIN_CONTENT@@
 
	<div class="footer">
	@@FOOTER@@
	</div>
	
<script language="javascript">

function hsig(id) {
  var divs = document.getElementsByTagName("tr");
  for(var i = 0; i < divs.length; i++){
     
     if (divs[i].getAttribute('o') == id) {
        divs[i].innerHTML = '';
     }
  }

  return false;
}


$(document).ready(function(){
    $('#table_crit').dataTable({
       "aLengthMenu": [[100 , 500, -1], [100, 500, "All"]],
       "aoColumns": [
                                     {"iDataSort": 7, "width":"70%"},
                                     {"iDataSort": 5},
                                     {"iDataSort": 6},
                                     {"bSortable": true},
                                     {"bVisible": false},
                                     {"bVisible": false},
                                     {"bVisible": false},
                                     {"bVisible": false}
                     ],
		"paging": true,
       "iDisplayLength": 500,
		"oLanguage": {
			"sLengthMenu": "Отображать по _MENU_ записей",
			"sZeroRecords": "Ничего не найдено",
			"sInfo": "Отображается c _START_ по _END_ из _TOTAL_ файлов",
			"sInfoEmpty": "Нет файлов",
			"sInfoFiltered": "(всего записей _MAX_)",
			"sSearch":       "Поиск:",
			"sUrl":          "",
			"oPaginate": {
				"sFirst": "Первая",
				"sPrevious": "Предыдущая",
				"sNext": "Следующая",
				"sLast": "Последняя"
			},
			"oAria": {
				"sSortAscending":  ": активировать для сортировки столбца по возрастанию",
				"sSortDescending": ": активировать для сортировки столбцов по убыванию"			
			}
		}

     } );

});

$(document).ready(function(){
    $('#table_vir').dataTable({
       "aLengthMenu": [[100 , 500, -1], [100, 500, "All"]],
		"paging": true,
       "aoColumns": [
                                     {"iDataSort": 7, "width":"70%"},
                                     {"iDataSort": 5},
                                     {"iDataSort": 6},
                                     {"bSortable": true},
                                     {"bVisible": false},
                                     {"bVisible": false},
                                     {"bVisible": false},
                                     {"bVisible": false}
                     ],
       "iDisplayLength": 500,
		"oLanguage": {
			"sLengthMenu": "Отображать по _MENU_ записей",
			"sZeroRecords": "Ничего не найдено",
			"sInfo": "Отображается c _START_ по _END_ из _TOTAL_ файлов",
			"sInfoEmpty": "Нет файлов",
			"sInfoFiltered": "(всего записей _MAX_)",
			"sSearch":       "Поиск:",
			"sUrl":          "",
			"oPaginate": {
				"sFirst": "Первая",
				"sPrevious": "Предыдущая",
				"sNext": "Следующая",
				"sLast": "Последняя"
			},
			"oAria": {
				"sSortAscending":  ": активировать для сортировки столбца по возрастанию",
				"sSortDescending": ": активировать для сортировки столбцов по убыванию"			
			}
		},

     } );

});

if ($('#table_warn0')) {
    $('#table_warn0').dataTable({
       "aLengthMenu": [[100 , 500, -1], [100, 500, "All"]],
		"paging": true,
       "aoColumns": [
                                     {"iDataSort": 7, "width":"70%"},
                                     {"iDataSort": 5},
                                     {"iDataSort": 6},
                                     {"bSortable": true},
                                     {"bVisible": false},
                                     {"bVisible": false},
                                     {"bVisible": false},
                                     {"bVisible": false}
                     ],
       "iDisplayLength": 500,
		"paging": true,
		"oLanguage": {
			"sLengthMenu": "Отображать по _MENU_ записей",
			"sZeroRecords": "Ничего не найдено",
			"sInfo": "Отображается c _START_ по _END_ из _TOTAL_ файлов",
			"sInfoEmpty": "Нет файлов",
			"sInfoFiltered": "(всего записей _MAX_)",
			"sSearch":       "Поиск:",
			"sUrl":          "",
			"oPaginate": {
				"sFirst": "Первая",
				"sPrevious": "Предыдущая",
				"sNext": "Следующая",
				"sLast": "Последняя"
			},
			"oAria": {
				"sSortAscending":  ": активировать для сортировки столбца по возрастанию",
				"sSortDescending": ": активировать для сортировки столбцов по убыванию"			
			}
		}

     } );
}

if ($('#table_warn1')) {
    $('#table_warn1').dataTable({
       "aLengthMenu": [[100 , 500, -1], [100, 500, "All"]],
		"paging": true,
       "aoColumns": [
                                     {"iDataSort": 7, "width":"70%"},
                                     {"iDataSort": 5},
                                     {"iDataSort": 6},
                                     {"bSortable": true},
                                     {"bVisible": false},
                                     {"bVisible": false},
                                     {"bVisible": false},
                                     {"bVisible": false}
                     ],
       "iDisplayLength": 500,
		"oLanguage": {
			"sLengthMenu": "Отображать по _MENU_ записей",
			"sZeroRecords": "Ничего не найдено",
			"sInfo": "Отображается c _START_ по _END_ из _TOTAL_ файлов",
			"sInfoEmpty": "Нет файлов",
			"sInfoFiltered": "(всего записей _MAX_)",
			"sSearch":       "Поиск:",
			"sUrl":          "",
			"oPaginate": {
				"sFirst": "Первая",
				"sPrevious": "Предыдущая",
				"sNext": "Следующая",
				"sLast": "Последняя"
			},
			"oAria": {
				"sSortAscending":  ": активировать для сортировки столбца по возрастанию",
				"sSortDescending": ": активировать для сортировки столбцов по убыванию"			
			}
		}

     } );
}


</script>
 </body>
</html>
MAIN_PAGE;

$g_AiBolitAbsolutePath = dirname(__FILE__);

if (file_exists($g_AiBolitAbsolutePath . '/ai-design.html')) {
  $l_Template = file_get_contents($g_AiBolitAbsolutePath . '/ai-design.html');
}

$l_Template = str_replace('@@MAIN_TITLE@@', AI_STR_001, $l_Template);

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//BEGIN_SIG 05/01/2016 07:47:03
$g_DBShe = unserialize(base64_decode("YTo0MTc6e2k6MDtzOjM1OiJtb3ZlX3VwbG9hZGVkX2ZpbGUoJF9GSUxFU1s8cXE+RjFsMyI7aToxO3M6NDY6IiR1c2VyQWdlbnRzID0gYXJyYXkoIkdvb2dsZSIsICJTbHVycCIsICJNU05Cb3QiO2k6MjtzOjY6IlszcmFuXSI7aTozO3M6MTA6IkRhd25fYW5nZWwiO2k6NDtzOjg6IlIzRFRVWEVTIjtpOjU7czoyMDoidmlzaXRvclRyYWNrZXJfaXNNb2IiO2k6NjtzOjI0OiJjb21fY29udGVudC9hcnRpY2xlZC5waHAiO2k6NztzOjE3OiI8dGl0bGU+RW1zUHJveHkgdiI7aTo4O3M6MTM6ImFuZHJvaWQtaWdyYS0iO2k6OTtzOjE1OiI9PT06OjptYWQ6Ojo9PT0iO2k6MTA7czo1OiJINHhPciI7aToxMTtzOjg6IlI0cEg0eDByIjtpOjEyO3M6ODoiTkc2ODlTa3ciO2k6MTM7czoxMToiZm9wby5jb20uYXIiO2k6MTQ7czo5OiI2NC42OC44MC4iO2k6MTU7czo4OiJIYXJjaGFMaSI7aToxNjtzOjE1OiJ4eFI5OW11c3ZpZWkweDAiO2k6MTc7czoxMToiUC5oLnAuUy5wLnkiO2k6MTg7czoxNDoiX3NoZWxsX2F0aWxkaV8iO2k6MTk7czo5OiJ+IFNoZWxsIEkiO2k6MjA7czo2OiIweGRkODIiO2k6MjE7czoxNDoiQW50aWNoYXQgc2hlbGwiO2k6MjI7czoxMjoiQUxFTWlOIEtSQUxpIjtpOjIzO3M6MTY6IkFTUFggU2hlbGwgYnkgTFQiO2k6MjQ7czo5OiJhWlJhaUxQaFAiO2k6MjU7czoyMjoiQ29kZWQgQnkgQ2hhcmxpY2hhcGxpbiI7aToyNjtzOjc6IkJsMG9kM3IiO2k6Mjc7czoxMjoiQlkgaVNLT1JQaVRYIjtpOjI4O3M6MTE6ImRldmlselNoZWxsIjtpOjI5O3M6MzA6IldyaXR0ZW4gYnkgQ2FwdGFpbiBDcnVuY2ggVGVhbSI7aTozMDtzOjk6ImMyMDA3LnBocCI7aTozMTtzOjIyOiJDOTkgTW9kaWZpZWQgQnkgUHN5Y2gwIjtpOjMyO3M6MTc6IiRjOTlzaF91cGRhdGVmdXJsIjtpOjMzO3M6OToiQzk5IFNoZWxsIjtpOjM0O3M6MjI6ImNvb2tpZW5hbWUgPSAid2llZWVlZSIiO2k6MzU7czozODoiQ29kZWQgYnkgOiBTdXBlci1DcnlzdGFsIGFuZCBNb2hhamVyMjIiO2k6MzY7czoxMjoiQ3J5c3RhbFNoZWxsIjtpOjM3O3M6MjM6IlRFQU0gU0NSSVBUSU5HIC0gUk9ETk9DIjtpOjM4O3M6MTE6IkN5YmVyIFNoZWxsIjtpOjM5O3M6NzoiZDBtYWlucyI7aTo0MDtzOjEzOiJEYXJrRGV2aWx6LmlOIjtpOjQxO3M6MjQ6IlNoZWxsIHdyaXR0ZW4gYnkgQmwwb2QzciI7aTo0MjtzOjMzOiJEaXZlIFNoZWxsIC0gRW1wZXJvciBIYWNraW5nIFRlYW0iO2k6NDM7czoxNToiRGV2ci1pIE1lZnNlZGV0IjtpOjQ0O3M6MzI6IkNvbWFuZG9zIEV4Y2x1c2l2b3MgZG8gRFRvb2wgUHJvIjtpOjQ1O3M6MjA6IkVtcGVyb3IgSGFja2luZyBURUFNIjtpOjQ2O3M6MjA6IkZpeGVkIGJ5IEFydCBPZiBIYWNrIjtpOjQ3O3M6MjE6IkZhVGFMaXNUaUN6X0Z4IEZ4MjlTaCI7aTo0ODtzOjI3OiJMdXRmZW4gRG9zeWF5aSBBZGxhbmRpcmluaXoiO2k6NDk7czoyMjoidGhpcyBpcyBhIHByaXYzIHNlcnZlciI7aTo1MDtzOjEzOiJHRlMgV2ViLVNoZWxsIjtpOjUxO3M6MTE6IkdIQyBNYW5hZ2VyIjtpOjUyO3M6MTQ6Ikdvb2cxZV9hbmFsaXN0IjtpOjUzO3M6MTM6IkdyaW5heSBHbzBvJEUiO2k6NTQ7czoyOToiaDRudHUgc2hlbGwgW3Bvd2VyZWQgYnkgdHNvaV0iO2k6NTU7czoyNToiSGFja2VkIEJ5IERldnItaSBNZWZzZWRldCI7aTo1NjtzOjE3OiJIQUNLRUQgQlkgUkVBTFdBUiI7aTo1NztzOjMyOiJIYWNrZXJsZXIgVnVydXIgTGFtZXJsZXIgU3VydW51ciI7aTo1ODtzOjExOiJpTUhhQmlSTGlHaSI7aTo1OTtzOjk6IktBX3VTaGVsbCI7aTo2MDtzOjc6IkxpejB6aU0iO2k6NjE7czoxMToiTG9jdXM3U2hlbGwiO2k6NjI7czozNjoiTW9yb2NjYW4gU3BhbWVycyBNYS1FZGl0aW9OIEJ5IEdoT3NUIjtpOjYzO3M6MTA6Ik1hdGFtdSBNYXQiO2k6NjQ7czo1MDoiT3BlbiB0aGUgZmlsZSBhdHRhY2htZW50IGlmIGFueSwgYW5kIGJhc2U2NF9lbmNvZGUiO2k6NjU7czo2OiJtMHJ0aXgiO2k6NjY7czo1OiJtMGh6ZSI7aTo2NztzOjEwOiJNYXRhbXUgTWF0IjtpOjY4O3M6MTY6Ik1vcm9jY2FuIFNwYW1lcnMiO2k6Njk7czoxNToiJE15U2hlbGxWZXJzaW9uIjtpOjcwO3M6OToiTXlTUUwgUlNUIjtpOjcxO3M6MTk6Ik15U1FMIFdlYiBJbnRlcmZhY2UiO2k6NzI7czoyNzoiTXlTUUwgV2ViIEludGVyZmFjZSBWZXJzaW9uIjtpOjczO3M6MTQ6Ik15U1FMIFdlYnNoZWxsIjtpOjc0O3M6ODoiTjN0c2hlbGwiO2k6NzU7czoxNjoiSGFja2VkIGJ5IFNpbHZlciI7aTo3NjtzOjc6Ik5lb0hhY2siO2k6Nzc7czoyMToiTmV0d29ya0ZpbGVNYW5hZ2VyUEhQIjtpOjc4O3M6MjA6Ik5JWCBSRU1PVEUgV0VCLVNIRUxMIjtpOjc5O3M6MjY6Ik8gQmlSIEtSQUwgVEFLTGlUIEVEaWxFTUVaIjtpOjgwO3M6MTg6IlBIQU5UQVNNQS0gTmVXIENtRCI7aTo4MTtzOjIxOiJQSVJBVEVTIENSRVcgV0FTIEhFUkUiO2k6ODI7czoyMToiYSBzaW1wbGUgcGhwIGJhY2tkb29yIjtpOjgzO3M6MjA6IkxPVEZSRUUgUEhQIEJhY2tkb29yIjtpOjg0O3M6MzE6Ik5ld3MgUmVtb3RlIFBIUCBTaGVsbCBJbmplY3Rpb24iO2k6ODU7czo5OiJQSFBKYWNrYWwiO2k6ODY7czoyMDoiUEhQIEhWQSBTaGVsbCBTY3JpcHQiO2k6ODc7czoxMzoicGhwUmVtb3RlVmlldyI7aTo4ODtzOjM1OiJQSFAgU2hlbGwgaXMgYW5pbnRlcmFjdGl2ZSBQSFAtcGFnZSI7aTo4OTtzOjY6IlBIVmF5diI7aTo5MDtzOjI2OiJQUFMgMS4wIHBlcmwtY2dpIHdlYiBzaGVsbCI7aTo5MTtzOjIyOiJQcmVzcyBPSyB0byBlbnRlciBzaXRlIjtpOjkyO3M6MjI6InByaXZhdGUgU2hlbGwgYnkgbTRyY28iO2k6OTM7czo1OiJyMG5pbiI7aTo5NDtzOjY6IlI1N1NxbCI7aTo5NTtzOjEzOiJyNTdzaGVsbFwucGhwIjtpOjk2O3M6MTU6InJnb2RgcyB3ZWJzaGVsbCI7aTo5NztzOjIwOiJyZWFsYXV0aD1TdkJEODVkSU51MyI7aTo5ODtzOjE2OiJSdTI0UG9zdFdlYlNoZWxsIjtpOjk5O3M6MjE6IktBZG90IFVuaXZlcnNhbCBTaGVsbCI7aToxMDA7czoxMDoiQ3JAenlfS2luZyI7aToxMDE7czoyMDoiU2FmZV9Nb2RlIEJ5cGFzcyBQSFAiO2k6MTAyO3M6MTc6IlNhcmFzYU9uIFNlcnZpY2VzIjtpOjEwMztzOjI1OiJTaW1wbGUgUEhQIGJhY2tkb29yIGJ5IERLIjtpOjEwNDtzOjE5OiJHLVNlY3VyaXR5IFdlYnNoZWxsIjtpOjEwNTtzOjI1OiJTaW1vcmdoIFNlY3VyaXR5IE1hZ2F6aW5lIjtpOjEwNjtzOjIwOiJTaGVsbCBieSBNYXdhcl9IaXRhbSI7aToxMDc7czoxMzoiU1NJIHdlYi1zaGVsbCI7aToxMDg7czoxMToiU3Rvcm03U2hlbGwiO2k6MTA5O3M6OToiVGhlX0JlS2lSIjtpOjExMDtzOjk6IlczRCBTaGVsbCI7aToxMTE7czoxMzoidzRjazFuZyBzaGVsbCI7aToxMTI7czoyODoiZGV2ZWxvcGVkIGJ5IERpZ2l0YWwgT3V0Y2FzdCI7aToxMTM7czozMjoiV2F0Y2ggWW91ciBzeXN0ZW0gU2hhbnkgd2FzIGhlcmUiO2k6MTE0O3M6MTI6IldlYiBTaGVsbCBieSI7aToxMTU7czoxMzoiV1NPMiBXZWJzaGVsbCI7aToxMTY7czozMzoiTmV0d29ya0ZpbGVNYW5hZ2VyUEhQIGZvciBjaGFubmVsIjtpOjExNztzOjI3OiJTbWFsbCBQSFAgV2ViIFNoZWxsIGJ5IFphQ28iO2k6MTE4O3M6MTA6Ik1ybG9vbC5leGUiO2k6MTE5O3M6NjoiU0VvRE9SIjtpOjEyMDtzOjk6Ik1yLkhpVG1hbiI7aToxMjE7czo1OiJkM2J+WCI7aToxMjI7czoxNjoiQ29ubmVjdEJhY2tTaGVsbCI7aToxMjM7czoxMDoiQlkgTU1OQk9CWiI7aToxMjQ7czoyNjoiT0xCOlBST0RVQ1Q6T05MSU5FX0JBTktJTkciO2k6MTI1O3M6MTA6IkMwZGVyei5jb20iO2k6MTI2O3M6NzoiTXJIYXplbSI7aToxMjc7czo5OiJ2MGxkM20wcnQiO2k6MTI4O3M6NjoiSyFMTDNyIjtpOjEyOTtzOjEwOiJEci5hYm9sYWxoIjtpOjEzMDtzOjMwOiIkcmFuZF93cml0YWJsZV9mb2xkZXJfZnVsbHBhdGgiO2k6MTMxO3M6ODQ6Ijx0ZXh0YXJlYSBuYW1lPVwicGhwZXZcIiByb3dzPVwiNVwiIGNvbHM9XCIxNTBcIj4iLkAkX1BPU1RbJ3BocGV2J10uIjwvdGV4dGFyZWE+PGJyPiI7aToxMzI7czoxNjoiYzk5ZnRwYnJ1dGVjaGVjayI7aToxMzM7czo5OiJCeSBQc3ljaDAiO2k6MTM0O3M6MTc6IiRjOTlzaF91cGRhdGVmdXJsIjtpOjEzNTtzOjE0OiJ0ZW1wX3I1N190YWJsZSI7aToxMzY7czoxNzoiYWRtaW5Ac3B5Z3J1cC5vcmciO2k6MTM3O3M6NzoiY2FzdXMxNSI7aToxMzg7czoxMzoiV1NDUklQVC5TSEVMTCI7aToxMzk7czo0NzoiRXhlY3V0ZWQgY29tbWFuZDogPGI+PGZvbnQgY29sb3I9I2RjZGNkYz5bJGNtZF0iO2k6MTQwO3M6MTE6ImN0c2hlbGwucGhwIjtpOjE0MTtzOjE1OiJEWF9IZWFkZXJfZHJhd24iO2k6MTQyO3M6ODY6ImNybGYuJ3VubGluaygkbmFtZSk7Jy4kY3JsZi4ncmVuYW1lKCJ+Ii4kbmFtZSwgJG5hbWUpOycuJGNybGYuJ3VubGluaygiZ3JwX3JlcGFpci5waHAiIjtpOjE0MztzOjEwNToiLzB0VlNHL1N1djBVci9oYVVZQWRuM2pNUXdiYm9jR2ZmQWVDMjlCTjl0bUJpSmRWMWxrK2pZRFU5MkM5NGpkdERpZit4T1lqRzZDTGh4MzFVbzl4OS9lQVdnc0JLNjBrSzJtTHdxenFkIjtpOjE0NDtzOjExNToibXB0eSgkX1BPU1RbJ3VyJ10pKSAkbW9kZSB8PSAwNDAwOyBpZiAoIWVtcHR5KCRfUE9TVFsndXcnXSkpICRtb2RlIHw9IDAyMDA7IGlmICghZW1wdHkoJF9QT1NUWyd1eCddKSkgJG1vZGUgfD0gMDEwMCI7aToxNDU7czozNzoia2xhc3ZheXYuYXNwP3llbmlkb3N5YT08JT1ha3RpZmtsYXMlPiI7aToxNDY7czoxMjI6Im50KShkaXNrX3RvdGFsX3NwYWNlKGdldGN3ZCgpKS8oMTAyNCoxMDI0KSkgLiAiTWIgIiAuICJGcmVlIHNwYWNlICIgLiAoaW50KShkaXNrX2ZyZWVfc3BhY2UoZ2V0Y3dkKCkpLygxMDI0KjEwMjQpKSAuICJNYiA8IjtpOjE0NztzOjc2OiJhIGhyZWY9Ijw/ZWNobyAiJGZpc3Rpay5waHA/ZGl6aW49JGRpemluLy4uLyI/PiIgc3R5bGU9InRleHQtZGVjb3JhdGlvbjogbm9uIjtpOjE0ODtzOjM4OiJSb290U2hlbGwhJyk7c2VsZi5sb2NhdGlvbi5ocmVmPSdodHRwOiI7aToxNDk7czo5MDoiPCU9UmVxdWVzdC5TZXJ2ZXJWYXJpYWJsZXMoInNjcmlwdF9uYW1lIiklPj9Gb2xkZXJQYXRoPTwlPVNlcnZlci5VUkxQYXRoRW5jb2RlKEZvbGRlci5Ecml2IjtpOjE1MDtzOjE2MDoicHJpbnQoKGlzX3JlYWRhYmxlKCRmKSAmJiBpc193cml0ZWFibGUoJGYpKT8iPHRyPjx0ZD4iLncoMSkuYigiUiIudygxKS5mb250KCdyZWQnLCdSVycsMykpLncoMSk6KCgoaXNfcmVhZGFibGUoJGYpKT8iPHRyPjx0ZD4iLncoMSkuYigiUiIpLncoNCk6IiIpLigoaXNfd3JpdGFibCI7aToxNTE7czoxNjE6IignIicsJyZxdW90OycsJGZuKSkuJyI7ZG9jdW1lbnQubGlzdC5zdWJtaXQoKTtcJz4nLmh0bWxzcGVjaWFsY2hhcnMoc3RybGVuKCRmbik+Zm9ybWF0P3N1YnN0cigkZm4sMCxmb3JtYXQtMykuJy4uLic6JGZuKS4nPC9hPicuc3RyX3JlcGVhdCgnICcsZm9ybWF0LXN0cmxlbigkZm4pIjtpOjE1MjtzOjExOiJ6ZWhpcmhhY2tlciI7aToxNTM7czozOToiSkAhVnJAKiZSSFJ3fkpMdy5HfHhsaG5MSn4/MS5id09ieGJQfCFWIjtpOjE1NDtzOjM5OiJXU09zZXRjb29raWUobWQ1KCRfU0VSVkVSWydIVFRQX0hPU1QnXSkiO2k6MTU1O3M6MTQxOiI8L3RkPjx0ZCBpZD1mYT5bIDxhIHRpdGxlPVwiSG9tZTogJyIuaHRtbHNwZWNpYWxjaGFycyhzdHJfcmVwbGFjZSgiXCIsICRzZXAsIGdldGN3ZCgpKSkuIicuXCIgaWQ9ZmEgaHJlZj1cImphdmFzY3JpcHQ6Vmlld0RpcignIi5yYXd1cmxlbmNvZGUiO2k6MTU2O3M6MTY6IkNvbnRlbnQtVHlwZTogJF8iO2k6MTU3O3M6ODY6Ijxub2JyPjxiPiRjZGlyJGNmaWxlPC9iPiAoIi4kZmlsZVsic2l6ZV9zdHIiXS4iKTwvbm9icj48L3RkPjwvdHI+PGZvcm0gbmFtZT1jdXJyX2ZpbGU+IjtpOjE1ODtzOjQ4OiJ3c29FeCgndGFyIGNmenYgJyAuIGVzY2FwZXNoZWxsYXJnKCRfUE9TVFsncDInXSkiO2k6MTU5O3M6MTQyOiI1amIyMGlLVzl5SUhOMGNtbHpkSElvSkhKbFptVnlaWElzSW1Gd2IzSjBJaWtnYjNJZ2MzUnlhWE4wY2lna2NtVm1aWEpsY2l3aWJtbG5iV0VpS1NCdmNpQnpkSEpwYzNSeUtDUnlaV1psY21WeUxDSjNaV0poYkhSaElpa2diM0lnYzNSeWFYTjBjaWdrIjtpOjE2MDtzOjc2OiJMUzBnUkhWdGNETmtJR0o1SUZCcGNuVnNhVzR1VUVoUUlGZGxZbk5vTTJ4c0lIWXhMakFnWXpCa1pXUWdZbmtnY2pCa2NqRWdPa3c9IjtpOjE2MTtzOjY1OiJpZiAoZXJlZygnXltbOmJsYW5rOl1dKmNkW1s6Ymxhbms6XV0rKFteO10rKSQnLCAkY29tbWFuZCwgJHJlZ3MpKSI7aToxNjI7czo0Njoicm91bmQoMCs5ODMwLjQrOTgzMC40Kzk4MzAuNCs5ODMwLjQrOTgzMC40KSk9PSI7aToxNjM7czoxMjoiUEhQU0hFTEwuUEhQIjtpOjE2NDtzOjIwOiJTaGVsbCBieSBNYXdhcl9IaXRhbSI7aToxNjU7czoyMjoicHJpdmF0ZSBTaGVsbCBieSBtNHJjbyI7aToxNjY7czoxMzoidzRjazFuZyBzaGVsbCI7aToxNjc7czoyMToiRmFUYUxpc1RpQ3pfRnggRngyOVNoIjtpOjE2ODtzOjQyOiJXb3JrZXJfR2V0UmVwbHlDb2RlKCRvcERhdGFbJ3JlY3ZCdWZmZXInXSkiO2k6MTY5O3M6NDA6IiRmaWxlcGF0aD1AcmVhbHBhdGgoJF9QT1NUWydmaWxlcGF0aCddKTsiO2k6MTcwO3M6ODg6IiRyZWRpcmVjdFVSTD0naHR0cDovLycuJHJTaXRlLiRfU0VSVkVSWydSRVFVRVNUX1VSSSddO2lmKGlzc2V0KCRfU0VSVkVSWydIVFRQX1JFRkVSRVInXSkiO2k6MTcxO3M6MTc6InJlbmFtZSgid3NvLnBocCIsIjtpOjE3MjtzOjU0OiIkTWVzc2FnZVN1YmplY3QgPSBiYXNlNjRfZGVjb2RlKCRfUE9TVFsibXNnc3ViamVjdCJdKTsiO2k6MTczO3M6NDQ6ImNvcHkoJF9GSUxFU1t4XVt0bXBfbmFtZV0sJF9GSUxFU1t4XVtuYW1lXSkpIjtpOjE3NDtzOjU4OiJTRUxFQ1QgMSBGUk9NIG15c3FsLnVzZXIgV0hFUkUgY29uY2F0KGB1c2VyYCwgJ0AnLCBgaG9zdGApIjtpOjE3NTtzOjIxOiIhQCRfQ09PS0lFWyRzZXNzZHRfa10iO2k6MTc2O3M6NDg6IiRhPShzdWJzdHIodXJsZW5jb2RlKHByaW50X3IoYXJyYXkoKSwxKSksNSwxKS5jKSI7aToxNzc7czo1NjoieGggLXMgIi91c3IvbG9jYWwvYXBhY2hlL3NiaW4vaHR0cGQgLURTU0wiIC4vaHR0cGQgLW0gJDEiO2k6MTc4O3M6MTg6InB3ZCA+IEdlbmVyYXNpLmRpciI7aToxNzk7czoxMjoiQlJVVEVGT1JDSU5HIjtpOjE4MDtzOjMxOiJDYXV0YW0gZmlzaWVyZWxlIGRlIGNvbmZpZ3VyYXJlIjtpOjE4MTtzOjMyOiIka2E9Jzw/Ly9CUkUnOyRrYWthPSRrYS4nQUNLLy8/PiI7aToxODI7czo4NToiJHN1Ymo9dXJsZGVjb2RlKCRfR0VUWydzdSddKTskYm9keT11cmxkZWNvZGUoJF9HRVRbJ2JvJ10pOyRzZHM9dXJsZGVjb2RlKCRfR0VUWydzZCddKSI7aToxODM7czozOToiJF9fX189QGd6aW5mbGF0ZSgkX19fXykpe2lmKGlzc2V0KCRfUE9TIjtpOjE4NDtzOjM3OiJwYXNzdGhydShnZXRlbnYoIkhUVFBfQUNDRVBUX0xBTkdVQUdFIjtpOjE4NTtzOjg6IkFzbW9kZXVzIjtpOjE4NjtzOjUwOiJmb3IoOyRwYWRkcj1hY2NlcHQoQ0xJRU5ULCBTRVJWRVIpO2Nsb3NlIENMSUVOVCkgeyI7aToxODc7czo1OToiJGl6aW5sZXIyPXN1YnN0cihiYXNlX2NvbnZlcnQoQGZpbGVwZXJtcygkZm5hbWUpLDEwLDgpLC00KTsiO2k6MTg4O3M6NDI6IiRiYWNrZG9vci0+Y2NvcHkoJGNmaWNoaWVyLCRjZGVzdGluYXRpb24pOyI7aToxODk7czoyMzoieyR7cGFzc3RocnUoJGNtZCl9fTxicj4iO2k6MTkwO3M6Mjk6IiRhW2hpdHNdJyk7IFxyXG4jZW5kcXVlcnlcclxuIjtpOjE5MTtzOjI2OiJuY2Z0cHB1dCAtdSAkZnRwX3VzZXJfbmFtZSI7aToxOTI7czozNjoiZXhlY2woIi9iaW4vc2giLCJzaCIsIi1pIiwoY2hhciopMCk7IjtpOjE5MztzOjMxOiI8SFRNTD48SEVBRD48VElUTEU+Y2dpLXNoZWxsLnB5IjtpOjE5NDtzOjM4OiJzeXN0ZW0oInVuc2V0IEhJU1RGSUxFOyB1bnNldCBTQVZFSElTVCI7aToxOTU7czoyMzoiJGxvZ2luPUBwb3NpeF9nZXR1aWQoKTsiO2k6MTk2O3M6NjA6IihlcmVnKCdeW1s6Ymxhbms6XV0qY2RbWzpibGFuazpdXSokJywgJF9SRVFVRVNUWydjb21tYW5kJ10pKSI7aToxOTc7czoyNToiISRfUkVRVUVTVFsiYzk5c2hfc3VybCJdKSI7aToxOTg7czo1MzoiUG5WbGtXTTYzIUAjQCZkS3h+bk1EV01+RH8vRXNufnh/NkRAI0AmUH5+LD9uWSxXUHtQb2oiO2k6MTk5O3M6MzY6InNoZWxsX2V4ZWMoJF9QT1NUWydjbWQnXSAuICIgMj4mMSIpOyI7aToyMDA7czozNToiaWYoISR3aG9hbWkpJHdob2FtaT1leGVjKCJ3aG9hbWkiKTsiO2k6MjAxO3M6NjE6IlB5U3lzdGVtU3RhdGUuaW5pdGlhbGl6ZShTeXN0ZW0uZ2V0UHJvcGVydGllcygpLCBudWxsLCBhcmd2KTsiO2k6MjAyO3M6MzY6IjwlPWVudi5xdWVyeUhhc2h0YWJsZSgidXNlci5uYW1lIiklPiI7aToyMDM7czo4MzoiaWYgKGVtcHR5KCRfUE9TVFsnd3NlciddKSkgeyR3c2VyID0gIndob2lzLnJpcGUubmV0Ijt9IGVsc2UgJHdzZXIgPSAkX1BPU1RbJ3dzZXInXTsiO2k6MjA0O3M6OTE6ImlmIChtb3ZlX3VwbG9hZGVkX2ZpbGUoJF9GSUxFU1snZmlsYSddWyd0bXBfbmFtZSddLCAkY3VyZGlyLiIvIi4kX0ZJTEVTWydmaWxhJ11bJ25hbWUnXSkpIHsiO2k6MjA1O3M6MjM6InNoZWxsX2V4ZWMoJ3VuYW1lIC1hJyk7IjtpOjIwNjtzOjQ3OiJpZiAoIWRlZmluZWQkcGFyYW17Y21kfSl7JHBhcmFte2NtZH09ImxzIC1sYSJ9OyI7aToyMDc7czo2MDoiaWYoZ2V0X21hZ2ljX3F1b3Rlc19ncGMoKSkkc2hlbGxPdXQ9c3RyaXBzbGFzaGVzKCRzaGVsbE91dCk7IjtpOjIwODtzOjg0OiI8YSBocmVmPSckUEhQX1NFTEY/YWN0aW9uPXZpZXdTY2hlbWEmZGJuYW1lPSRkYm5hbWUmdGFibGVuYW1lPSR0YWJsZW5hbWUnPlNjaGVtYTwvYT4iO2k6MjA5O3M6NjY6InBhc3N0aHJ1KCAkYmluZGlyLiJteXNxbGR1bXAgLS11c2VyPSRVU0VSTkFNRSAtLXBhc3N3b3JkPSRQQVNTV09SRCI7aToyMTA7czo2NjoibXlzcWxfcXVlcnkoIkNSRUFURSBUQUJMRSBgeHBsb2l0YCAoYHhwbG9pdGAgTE9OR0JMT0IgTk9UIE5VTEwpIik7IjtpOjIxMTtzOjg3OiIkcmE0NCAgPSByYW5kKDEsOTk5OTkpOyRzajk4ID0gInNoLSRyYTQ0IjskbWwgPSAiJHNkOTgiOyRhNSA9ICRfU0VSVkVSWydIVFRQX1JFRkVSRVInXTsiO2k6MjEyO3M6NTI6IiRfRklMRVNbJ3Byb2JlJ11bJ3NpemUnXSwgJF9GSUxFU1sncHJvYmUnXVsndHlwZSddKTsiO2k6MjEzO3M6NzE6InN5c3RlbSgiJGNtZCAxPiAvdG1wL2NtZHRlbXAgMj4mMTsgY2F0IC90bXAvY21kdGVtcDsgcm0gL3RtcC9jbWR0ZW1wIik7IjtpOjIxNDtzOjY5OiJ9IGVsc2lmICgkc2VydmFyZyA9fiAvXlw6KC4rPylcISguKz8pXEAoLis/KSBQUklWTVNHICguKz8pIFw6KC4rKS8pIHsiO2k6MjE1O3M6Njk6InNlbmQoU09DSzUsICRtc2csIDAsIHNvY2thZGRyX2luKCRwb3J0YSwgJGlhZGRyKSkgYW5kICRwYWNvdGVze299Kys7OyI7aToyMTY7czoxODoiJGZlKCIkY21kICAyPiYxIik7IjtpOjIxNztzOjY4OiJ3aGlsZSAoJHJvdyA9IG15c3FsX2ZldGNoX2FycmF5KCRyZXN1bHQsTVlTUUxfQVNTT0MpKSBwcmludF9yKCRyb3cpOyI7aToyMTg7czo1MjoiZWxzZWlmKEBpc193cml0YWJsZSgkRk4pICYmIEBpc19maWxlKCRGTikpICR0bXBPdXRNRiI7aToyMTk7czo3MjoiY29ubmVjdChTT0NLRVQsIHNvY2thZGRyX2luKCRBUkdWWzFdLCBpbmV0X2F0b24oJEFSR1ZbMF0pKSkgb3IgZGllIHByaW50IjtpOjIyMDtzOjg5OiJpZihtb3ZlX3VwbG9hZGVkX2ZpbGUoJF9GSUxFU1siZmljIl1bInRtcF9uYW1lIl0sZ29vZF9saW5rKCIuLyIuJF9GSUxFU1siZmljIl1bIm5hbWUiXSkpKSI7aToyMjE7czo4NzoiVU5JT04gU0VMRUNUICcwJyAsICc8PyBzeXN0ZW0oXCRfR0VUW2NwY10pO2V4aXQ7ID8+JyAsMCAsMCAsMCAsMCBJTlRPIE9VVEZJTEUgJyRvdXRmaWxlIjtpOjIyMjtzOjY4OiJpZiAoIUBpc19saW5rKCRmaWxlKSAmJiAoJHIgPSByZWFscGF0aCgkZmlsZSkpICE9IEZBTFNFKSAkZmlsZSA9ICRyOyI7aToyMjM7czoyOToiZWNobyAiRklMRSBVUExPQURFRCBUTyAkZGV6IjsiO2k6MjI0O3M6MjQ6IiRmdW5jdGlvbigkX1BPU1RbJ2NtZCddKSI7aToyMjU7czozODoiJGZpbGVuYW1lID0gJGJhY2t1cHN0cmluZy4iJGZpbGVuYW1lIjsiO2k6MjI2O3M6NDg6ImlmKCcnPT0oJGRmPUBpbmlfZ2V0KCdkaXNhYmxlX2Z1bmN0aW9ucycpKSl7ZWNobyI7aToyMjc7czo0NjoiPCUgRm9yIEVhY2ggVmFycyBJbiBSZXF1ZXN0LlNlcnZlclZhcmlhYmxlcyAlPiI7aToyMjg7czozMzoiaWYgKCRmdW5jYXJnID1+IC9ecG9ydHNjYW4gKC4qKS8pIjtpOjIyOTtzOjU1OiIkdXBsb2FkZmlsZSA9ICRycGF0aC4iLyIgLiAkX0ZJTEVTWyd1c2VyZmlsZSddWyduYW1lJ107IjtpOjIzMDtzOjI2OiIkY21kID0gKCRfUkVRVUVTVFsnY21kJ10pOyI7aToyMzE7czozODoiaWYoJGNtZCAhPSAiIikgcHJpbnQgU2hlbGxfRXhlYygkY21kKTsiO2k6MjMyO3M6Mjk6ImlmIChpc19maWxlKCIvdG1wLyRla2luY2kiKSl7IjtpOjIzMztzOjY5OiJfX2FsbF9fID0gWyJTTVRQU2VydmVyIiwiRGVidWdnaW5nU2VydmVyIiwiUHVyZVByb3h5IiwiTWFpbG1hblByb3h5Il0iO2k6MjM0O3M6NTk6Imdsb2JhbCAkbXlzcWxIYW5kbGUsICRkYm5hbWUsICR0YWJsZW5hbWUsICRvbGRfbmFtZSwgJG5hbWUsIjtpOjIzNTtzOjI3OiIyPiYxIDE+JjIiIDogIiAxPiYxIDI+JjEiKTsiO2k6MjM2O3M6NTI6Im1hcCB7IHJlYWRfc2hlbGwoJF8pIH0gKCRzZWxfc2hlbGwtPmNhbl9yZWFkKDAuMDEpKTsiO2k6MjM3O3M6MjI6ImZ3cml0ZSAoJGZwLCAiJHlhemkiKTsiO2k6MjM4O3M6NTE6IlNlbmQgdGhpcyBmaWxlOiA8SU5QVVQgTkFNRT0idXNlcmZpbGUiIFRZUEU9ImZpbGUiPiI7aToyMzk7czo0MjoiJGRiX2QgPSBAbXlzcWxfc2VsZWN0X2RiKCRkYXRhYmFzZSwkY29uMSk7IjtpOjI0MDtzOjY3OiJmb3IgKCR2YWx1ZSkgeyBzLyYvJmFtcDsvZzsgcy88LyZsdDsvZzsgcy8+LyZndDsvZzsgcy8iLyZxdW90Oy9nOyB9IjtpOjI0MTtzOjc0OiJjb3B5KCRfRklMRVNbJ3Vwa2snXVsndG1wX25hbWUnXSwia2svIi5iYXNlbmFtZSgkX0ZJTEVTWyd1cGtrJ11bJ25hbWUnXSkpOyI7aToyNDI7czo4NjoiZnVuY3Rpb24gZ29vZ2xlX2JvdCgpIHskc1VzZXJBZ2VudCA9IHN0cnRvbG93ZXIoJF9TRVJWRVJbJ0hUVFBfVVNFUl9BR0VOVCddKTtpZighKHN0cnAiO2k6MjQzO3M6NzU6ImNyZWF0ZV9mdW5jdGlvbigiJiQiLiJmdW5jdGlvbiIsIiQiLiJmdW5jdGlvbiA9IGNocihvcmQoJCIuImZ1bmN0aW9uKS0zKTsiKSI7aToyNDQ7czo0NjoibG9uZyBpbnQ6dCgwLDMpPXIoMCwzKTstMjE0NzQ4MzY0ODsyMTQ3NDgzNjQ3OyI7aToyNDU7czo0NjoiP3VybD0nLiRfU0VSVkVSWydIVFRQX0hPU1QnXSkudW5saW5rKFJPT1RfRElSLiI7aToyNDY7czozNjoiY2F0ICR7YmxrbG9nWzJdfSB8IGdyZXAgInJvb3Q6eDowOjAiIjtpOjI0NztzOjk3OiJAcGF0aDE9KCdhZG1pbi8nLCdhZG1pbmlzdHJhdG9yLycsJ21vZGVyYXRvci8nLCd3ZWJhZG1pbi8nLCdhZG1pbmFyZWEvJywnYmItYWRtaW4vJywnYWRtaW5Mb2dpbi8nIjtpOjI0ODtzOjg3OiIiYWRtaW4xLnBocCIsICJhZG1pbjEuaHRtbCIsICJhZG1pbjIucGhwIiwgImFkbWluMi5odG1sIiwgInlvbmV0aW0ucGhwIiwgInlvbmV0aW0uaHRtbCIiO2k6MjQ5O3M6Njg6IlBPU1QgeyRwYXRofXskY29ubmVjdG9yfT9Db21tYW5kPUZpbGVVcGxvYWQmVHlwZT1GaWxlJkN1cnJlbnRGb2xkZXI9IjtpOjI1MDtzOjMwOiJAYXNzZXJ0KCRfUkVRVUVTVFsnUEhQU0VTU0lEJ10iO2k6MjUxO3M6NjE6IiRwcm9kPSJzeSIuInMiLiJ0ZW0iOyRpZD0kcHJvZCgkX1JFUVVFU1RbJ3Byb2R1Y3QnXSk7JHsnaWQnfTsiO2k6MjUyO3M6MTU6InBocCAiLiR3c29fcGF0aCI7aToyNTM7czo3NzoiJEZjaG1vZCwkRmRhdGEsJE9wdGlvbnMsJEFjdGlvbiwkaGRkYWxsLCRoZGRmcmVlLCRoZGRwcm9jLCR1bmFtZSwkaWRkKTpzaGFyZWQiO2k6MjU0O3M6NTE6InNlcnZlci48L3A+XHJcbjwvYm9keT48L2h0bWw+IjtleGl0O31pZihwcmVnX21hdGNoKCI7aToyNTU7czo5NToiJGZpbGUgPSAkX0ZJTEVTWyJmaWxlbmFtZSJdWyJuYW1lIl07IGVjaG8gIjxhIGhyZWY9XCIkZmlsZVwiPiRmaWxlPC9hPiI7fSBlbHNlIHtlY2hvKCJlbXB0eSIpO30iO2k6MjU2O3M6NjA6IkZTX2Noa19mdW5jX2xpYmM9KCAkKHJlYWRlbGYgLXMgJEZTX2xpYmMgfCBncmVwIF9jaGtAQCB8IGF3ayI7aToyNTc7czo0MDoiZmluZCAvIC1uYW1lIC5zc2ggPiAkZGlyL3NzaGtleXMvc3Noa2V5cyI7aToyNTg7czozMzoicmUuZmluZGFsbChkaXJ0KycoLiopJyxwcm9nbm0pWzBdIjtpOjI1OTtzOjYwOiJvdXRzdHIgKz0gc3RyaW5nLkZvcm1hdCgiPGEgaHJlZj0nP2ZkaXI9ezB9Jz57MX0vPC9hPiZuYnNwOyIiO2k6MjYwO3M6ODM6IjwlPVJlcXVlc3QuU2VydmVydmFyaWFibGVzKCJTQ1JJUFRfTkFNRSIpJT4/dHh0cGF0aD08JT1SZXF1ZXN0LlF1ZXJ5U3RyaW5nKCJ0eHRwYXRoIjtpOjI2MTtzOjcxOiJSZXNwb25zZS5Xcml0ZShTZXJ2ZXIuSHRtbEVuY29kZSh0aGlzLkV4ZWN1dGVDb21tYW5kKHR4dENvbW1hbmQuVGV4dCkpKSI7aToyNjI7czoxMTE6Im5ldyBGaWxlU3RyZWFtKFBhdGguQ29tYmluZShmaWxlSW5mby5EaXJlY3RvcnlOYW1lLCBQYXRoLkdldEZpbGVOYW1lKGh0dHBQb3N0ZWRGaWxlLkZpbGVOYW1lKSksIEZpbGVNb2RlLkNyZWF0ZSI7aToyNjM7czo5MDoiUmVzcG9uc2UuV3JpdGUoIjxicj4oICkgPGEgaHJlZj0/dHlwZT0xJmZpbGU9IiAmIHNlcnZlci5VUkxlbmNvZGUoaXRlbS5wYXRoKSAmICJcPiIgJiBpdGVtIjtpOjI2NDtzOjEwNDoic3FsQ29tbWFuZC5QYXJhbWV0ZXJzLkFkZCgoKFRhYmxlQ2VsbClkYXRhR3JpZEl0ZW0uQ29udHJvbHNbMF0pLlRleHQsIFNxbERiVHlwZS5EZWNpbWFsKS5WYWx1ZSA9IGRlY2ltYWwiO2k6MjY1O3M6NjQ6IjwlPSAiXCIgJiBvU2NyaXB0TmV0LkNvbXB1dGVyTmFtZSAmICJcIiAmIG9TY3JpcHROZXQuVXNlck5hbWUgJT4iO2k6MjY2O3M6NTA6ImN1cmxfc2V0b3B0KCRjaCwgQ1VSTE9QVF9VUkwsICJodHRwOi8vJGhvc3Q6MjA4MiIpIjtpOjI2NztzOjU4OiJISjNIanV0Y2tvUmZwWGY5QTF6UU8yQXdEUnJSZXk5dUd2VGVlejc5cUFhbzFhMHJndWRrWmtSOFJhIjtpOjI2ODtzOjMxOiIkaW5pWyd1c2VycyddID0gYXJyYXkoJ3Jvb3QnID0+IjtpOjI2OTtzOjE4OiJwcm9jX29wZW4oJ0lIU3RlYW0iO2k6MjcwO3M6MjQ6IiRiYXNsaWs9JF9QT1NUWydiYXNsaWsnXSI7aToyNzE7czozMDoiZnJlYWQoJGZwLCBmaWxlc2l6ZSgkZmljaGVybykpIjtpOjI3MjtzOjM5OiJJL2djWi92WDBBMTBERFJEZzdFemsvZCszKzhxdnFxUzFLMCtBWFkiO2k6MjczO3M6MTY6InskX1BPU1RbJ3Jvb3QnXX0iO2k6Mjc0O3M6Mjk6In1lbHNlaWYoJF9HRVRbJ3BhZ2UnXT09J2Rkb3MnIjtpOjI3NTtzOjE0OiJUaGUgRGFyayBSYXZlciI7aToyNzY7czozOToiJHZhbHVlID1+IHMvJSguLikvcGFjaygnYycsaGV4KCQxKSkvZWc7IjtpOjI3NztzOjExOiJ3d3cudDBzLm9yZyI7aToyNzg7czozMDoidW5sZXNzKG9wZW4oUEZELCRnX3VwbG9hZF9kYikpIjtpOjI3OTtzOjEyOiJhejg4cGl4MDBxOTgiO2k6MjgwO3M6MTE6InNoIGdvICQxLiR4IjtpOjI4MTtzOjI2OiJzeXN0ZW0oInBocCAtZiB4cGwgJGhvc3QiKSI7aToyODI7czoxMzoiZXhwbG9pdGNvb2tpZSI7aToyODM7czoyMToiODAgLWIgJDEgLWkgZXRoMCAtcyA4IjtpOjI4NDtzOjI1OiJIVFRQIGZsb29kIGNvbXBsZXRlIGFmdGVyIjtpOjI4NTtzOjE1OiJOSUdHRVJTLk5JR0dFUlMiO2k6Mjg2O3M6NDc6ImlmKGlzc2V0KCRfR0VUWydob3N0J10pJiZpc3NldCgkX0dFVFsndGltZSddKSl7IjtpOjI4NztzOjgzOiJzdWJwcm9jZXNzLlBvcGVuKGNtZCwgc2hlbGwgPSBUcnVlLCBzdGRvdXQ9c3VicHJvY2Vzcy5QSVBFLCBzdGRlcnI9c3VicHJvY2Vzcy5TVERPVSI7aToyODg7czo2OToiZGVmIGRhZW1vbihzdGRpbj0nL2Rldi9udWxsJywgc3Rkb3V0PScvZGV2L251bGwnLCBzdGRlcnI9Jy9kZXYvbnVsbCcpIjtpOjI4OTtzOjY3OiJwcmludCgiWyFdIEhvc3Q6ICIgKyBob3N0bmFtZSArICIgbWlnaHQgYmUgZG93biFcblshXSBSZXNwb25zZSBDb2RlIjtpOjI5MDtzOjQyOiJjb25uZWN0aW9uLnNlbmQoInNoZWxsICIrc3RyKG9zLmdldGN3ZCgpKSsiO2k6MjkxO3M6NTA6Im9zLnN5c3RlbSgnZWNobyBhbGlhcyBscz0iLmxzLmJhc2giID4+IH4vLmJhc2hyYycpIjtpOjI5MjtzOjMyOiJydWxlX3JlcSA9IHJhd19pbnB1dCgiU291cmNlRmlyZSI7aToyOTM7czo1NzoiYXJncGFyc2UuQXJndW1lbnRQYXJzZXIoZGVzY3JpcHRpb249aGVscCwgcHJvZz0ic2N0dW5uZWwiIjtpOjI5NDtzOjU3OiJzdWJwcm9jZXNzLlBvcGVuKCclc2dkYiAtcCAlZCAtYmF0Y2ggJXMnICUgKGdkYl9wcmVmaXgsIHAiO2k6Mjk1O3M6NTk6IiRmcmFtZXdvcmsucGx1Z2lucy5sb2FkKCIje3JwY3R5cGUuZG93bmNhc2V9cnBjIiwgb3B0cykucnVuIjtpOjI5NjtzOjI4OiJpZiBzZWxmLmhhc2hfdHlwZSA9PSAncHdkdW1wIjtpOjI5NztzOjE3OiJpdHNva25vcHJvYmxlbWJybyI7aToyOTg7czo0NToiYWRkX2ZpbHRlcigndGhlX2NvbnRlbnQnLCAnX2Jsb2dpbmZvJywgMTAwMDEpIjtpOjI5OTtzOjk6IjxzdGRsaWIuaCI7aTozMDA7czo1OToiZWNobyB5IDsgc2xlZXAgMSA7IH0gfCB7IHdoaWxlIHJlYWQgOyBkbyBlY2hvIHokUkVQTFk7IGRvbmUiO2k6MzAxO3M6MTE6IlZPQlJBIEdBTkdPIjtpOjMwMjtzOjc2OiJpbnQzMigoKCR6ID4+IDUgJiAweDA3ZmZmZmZmKSBeICR5IDw8IDIpICsgKCgkeSA+PiAzICYgMHgxZmZmZmZmZikgXiAkeiA8PCA0IjtpOjMwMztzOjY5OiJAY29weSgkX0ZJTEVTW2ZpbGVNYXNzXVt0bXBfbmFtZV0sJF9QT1NUW3BhdGhdLiRfRklMRVNbZmlsZU1hc3NdW25hbWUiO2k6MzA0O3M6NDY6ImZpbmRfZGlycygkZ3JhbmRwYXJlbnRfZGlyLCAkbGV2ZWwsIDEsICRkaXJzKTsiO2k6MzA1O3M6Mjg6IkBzZXRjb29raWUoImhpdCIsIDEsIHRpbWUoKSsiO2k6MzA2O3M6NToiZS8qLi8iO2k6MzA3O3M6Mzc6IkpIWnBjMmwwWTI5MWJuUWdQU0FrU0ZSVVVGOURUMDlMU1VWZlYiO2k6MzA4O3M6MzU6IjBkMGEwZDBhNjc2YzZmNjI2MTZjMjAyNDZkNzk1ZjczNmQ3IjtpOjMwOTtzOjE5OiJmb3BlbignL2V0Yy9wYXNzd2QnIjtpOjMxMDtzOjc2OiIkdHN1MltyYW5kKDAsY291bnQoJHRzdTIpIC0gMSldLiR0c3UxW3JhbmQoMCxjb3VudCgkdHN1MSkgLSAxKV0uJHRzdTJbcmFuZCgwIjtpOjMxMTtzOjMzOiIvdXNyL2xvY2FsL2FwYWNoZS9iaW4vaHR0cGQgLURTU0wiO2k6MzEyO3M6MjA6InNldCBwcm90ZWN0LXRlbG5ldCAwIjtpOjMxMztzOjI3OiJheXUgcHIxIHByMiBwcjMgcHI0IHByNSBwcjYiO2k6MzE0O3M6MzA6ImJpbmQgZmlsdCAtICJcMDAxQUNUSU9OICpcMDAxIiI7aTozMTU7czo1MDoicmVnc3ViIC1hbGwgLS0gLCBbc3RyaW5nIHRvbG93ZXIgJG93bmVyXSAiIiBvd25lcnMiO2k6MzE2O3M6MzU6ImtpbGwgLUNITEQgXCRib3RwaWQgPi9kZXYvbnVsbCAyPiYxIjtpOjMxNztzOjEwOiJiaW5kIGRjYyAtIjtpOjMxODtzOjI0OiJyNGFUYy5kUG50RS9menRTRjFiSDNSSDAiO2k6MzE5O3M6MTM6InByaXZtc2cgJGNoYW4iO2k6MzIwO3M6MjI6ImJpbmQgam9pbiAtICogZ29wX2pvaW4iO2k6MzIxO3M6NDM6InNldCBnb29nbGUoZGF0YSkgW2h0dHA6OmRhdGEgJGdvb2dsZShwYWdlKV0iO2k6MzIyO3M6MjY6InByb2MgaHR0cDo6Q29ubmVjdCB7dG9rZW59IjtpOjMyMztzOjEzOiJwcml2bXNnICRuaWNrIjtpOjMyNDtzOjExOiJwdXRib3QgJGJvdCI7aTozMjU7czoxMjoidW5iaW5kIFJBVyAtIjtpOjMyNjtzOjI5OiItLURDQ0RJUiBbbGluZGV4ICRVc2VyKCRpKSAyXSI7aTozMjc7czoxMDoiQ3liZXN0ZXI5MCI7aTozMjg7czo0MToiZmlsZV9nZXRfY29udGVudHModHJpbSgkZlskX0dFVFsnaWQnXV0pKTsiO2k6MzI5O3M6MjE6InVubGluaygkd3JpdGFibGVfZGlycyI7aTozMzA7czoyNzoiYmFzZTY0X2RlY29kZSgkY29kZV9zY3JpcHQpIjtpOjMzMTtzOjIxOiJsdWNpZmZlckBsdWNpZmZlci5vcmciO2k6MzMyO3M6NDg6IiR0aGlzLT5GLT5HZXRDb250cm9sbGVyKCRfU0VSVkVSWydSRVFVRVNUX1VSSSddKSI7aTozMzM7czo0NzoiJHRpbWVfc3RhcnRlZC4kc2VjdXJlX3Nlc3Npb25fdXNlci5zZXNzaW9uX2lkKCkiO2k6MzM0O3M6NzQ6IiRwYXJhbSB4ICRuLnN1YnN0ciAoJHBhcmFtLCBsZW5ndGgoJHBhcmFtKSAtIGxlbmd0aCgkY29kZSklbGVuZ3RoKCRwYXJhbSkpIjtpOjMzNTtzOjM2OiJmd3JpdGUoJGYsZ2V0X2Rvd25sb2FkKCRfR0VUWyd1cmwnXSkiO2k6MzM2O3M6NjU6Imh0dHA6Ly8nLiRfU0VSVkVSWydIVFRQX0hPU1QnXS51cmxkZWNvZGUoJF9TRVJWRVJbJ1JFUVVFU1RfVVJJJ10pIjtpOjMzNztzOjgwOiJ3cF9wb3N0cyBXSEVSRSBwb3N0X3R5cGUgPSAncG9zdCcgQU5EIHBvc3Rfc3RhdHVzID0gJ3B1Ymxpc2gnIE9SREVSIEJZIGBJRGAgREVTQyI7aTozMzg7czozNzoiJHVybCA9ICR1cmxzW3JhbmQoMCwgY291bnQoJHVybHMpLTEpXSI7aTozMzk7czo0NzoicHJlZ19tYXRjaCgnLyg/PD1SZXdyaXRlUnVsZSkuKig/PVxbTFwsUlw9MzAyXF0iO2k6MzQwO3M6NDU6InByZWdfbWF0Y2goJyFNSURQfFdBUHxXaW5kb3dzLkNFfFBQQ3xTZXJpZXM2MCI7aTozNDE7czo2MDoiUjBsR09EbGhFd0FRQUxNQUFBQUFBUC8vLzV5Y0FNN09ZLy8vblAvL3p2L09uUGYzOS8vLy93QUFBQUFBIjtpOjM0MjtzOjY1OiJzdHJfcm90MTMoJGJhc2VhWygkZGltZW5zaW9uKiRkaW1lbnNpb24tMSkgLSAoJGkqJGRpbWVuc2lvbiskaildKSI7aTozNDM7czo3NToiaWYoZW1wdHkoJF9HRVRbJ3ppcCddKSBhbmQgZW1wdHkoJF9HRVRbJ2Rvd25sb2FkJ10pICYgZW1wdHkoJF9HRVRbJ2ltZyddKSl7IjtpOjM0NDtzOjE2OiJNYWRlIGJ5IERlbG9yZWFuIjtpOjM0NTtzOjQ2OiJvdmVyZmxvdy15OnNjcm9sbDtcIj4iLiRsaW5rcy4kaHRtbF9tZlsnYm9keSddIjtpOjM0NjtzOjQzOiJmdW5jdGlvbiB1cmxHZXRDb250ZW50cygkdXJsLCAkdGltZW91dCA9IDUpIjtpOjM0NztzOjY6ImQzbGV0ZSI7aTozNDg7czoxNToibGV0YWtzZWthcmFuZygpIjtpOjM0OTtzOjg6IllFTkkzRVJJIjtpOjM1MDtzOjIxOiIkT09PMDAwMDAwPXVybGRlY29kZSgiO2k6MzUxO3M6MjA6Ii1JL3Vzci9sb2NhbC9iYW5kbWluIjtpOjM1MjtzOjM3OiJmd3JpdGUoJGZwc2V0diwgZ2V0ZW52KCJIVFRQX0NPT0tJRSIpIjtpOjM1MztzOjI1OiJpc3NldCgkX1BPU1RbJ2V4ZWNnYXRlJ10pIjtpOjM1NDtzOjE1OiJXZWJjb21tYW5kZXIgYXQiO2k6MzU1O3M6MTQ6Ij09ICJiaW5kc2hlbGwiIjtpOjM1NjtzOjg6IlBhc2hrZWxhIjtpOjM1NztzOjI1OiJjcmVhdGVGaWxlc0ZvcklucHV0T3V0cHV0IjtpOjM1ODtzOjY6Ik00bGwzciI7aTozNTk7czoyMDoiX19WSUVXU1RBVEVFTkNSWVBURUQiO2k6MzYwO3M6NzoiT29OX0JveSI7aTozNjE7czoxMzoiUmVhTF9QdU5pU2hFciI7aTozNjI7czo4OiJkYXJrbWlueiI7aTozNjM7czo1OiJaZWQweCI7aTozNjQ7czo0MDoiYWJhY2hvfGFiaXpkaXJlY3Rvcnl8YWJvdXR8YWNvb258YWxleGFuYSI7aTozNjU7czozNjoicHBjfG1pZHB8d2luZG93cyBjZXxtdGt8ajJtZXxzeW1iaWFuIjtpOjM2NjtzOjQ3OiJAY2hyKCgkaFskZVskb11dPDw0KSsoJGhbJGVbKyskb11dKSk7fX1ldmFsKCRkKSI7aTozNjc7czoxMToiJHNoM2xsQ29sb3IiO2k6MzY4O3M6MTA6IlB1bmtlcjJCb3QiO2k6MzY5O3M6MTg6Ijw/cGhwIGVjaG8gIiMhISMiOyI7aTozNzA7czo3NToiJGltPXN1YnN0cigkaW0sMCwkaSkuc3Vic3RyKCRpbSwkaTIrMSwkaTQtKCRpMisxKSkuc3Vic3RyKCRpbSwkaTQrMTIsc3RybGVuIjtpOjM3MTtzOjU1OiIoJGluZGF0YSwkYjY0PTEpe2lmKCRiNjQ9PTEpeyRjZD1iYXNlNjRfZGVjb2RlKCRpbmRhdGEpIjtpOjM3MjtzOjE3OiIoJF9QT1NUWyJkaXIiXSkpOyI7aTozNzM7czoxNzoiSGFja2VkIEJ5IEVuRExlU3MiO2k6Mzc0O3M6MTA6ImFuZGV4fG9vZ2wiO2k6Mzc1O3M6MTA6Im5kcm9pfGh0Y18iO2k6Mzc2O3M6MTA6Ijxkb3Q+SXJJc1QiO2k6Mzc3O3M6MjE6IjdQMXRkK05XbGlhSS9oV2taNFZYOSI7aTozNzg7czoxNToiTmluamFWaXJ1cyBIZXJlIjtpOjM3OTtzOjMyOiIkaW09c3Vic3RyKCR0eCwkcCsyLCRwMi0oJHArMikpOyI7aTozODA7czo2OiIzeHAxcjMiO2k6MzgxO3M6MjA6IiRtZDU9bWQ1KCIkcmFuZG9tIik7IjtpOjM4MjtzOjI4OiJvVGF0OEQzRHNFOCcmfmhVMDZDQ0g1OyRnWVNxIjtpOjM4MztzOjEyOiJHSUY4OUE7PD9waHAiO2k6Mzg0O3M6MTU6IkNyZWF0ZWQgQnkgRU1NQSI7aTozODU7czozNDoiUGFzc3dvcmQ6PHM+Ii4kX1BPU1RbPHE+cGFzc3dkPHE+XSI7aTozODY7czoxNToiTmV0QGRkcmVzcyBNYWlsIjtpOjM4NztzOjI0OiIkaXNldmFsZnVuY3Rpb25hdmFpbGFibGUiO2k6Mzg4O3M6MTE6IkJhYnlfRHJha29uIjtpOjM4OTtzOjMwOiJmd3JpdGUoZm9wZW4oZGlybmFtZShfX0ZJTEVfXykiO2k6MzkwO3M6MTM6Il1dKSk7fX1ldmFsKCQiO2k6MzkxO3M6Mjc6ImVyZWdfcmVwbGFjZSg8cT4mZW1haWwmPHE+LCI7aTozOTI7czoxOToiKTsgJGkrKykkcmV0Lj1jaHIoJCI7aTozOTM7czo1NzoiJHBhcmFtMm1hc2suIilcPVtcPHFxPlwiXSguKj8pKD89W1w8cXE+XCJdIClbXDxxcT5cIl0vc2llIjtpOjM5NDtzOjk6Ii8vcmFzdGEvLyI7aTozOTU7czoyMDoiPCEtLUNPT0tJRSBVUERBVEUtLT4iO2k6Mzk2O3M6MTM6InByb2ZleG9yLmhlbGwiO2k6Mzk3O3M6MTM6Ik1hZ2VsYW5nQ3liZXIiO2k6Mzk4O3M6ODoiWk9CVUdURUwiO2k6Mzk5O3M6MjE6ImRhdGE6dGV4dC9odG1sO2Jhc2U2NCI7aTo0MDA7czo4OiJTX11AX15VXiI7aTo0MDE7czoxMzoiQCRfUE9TVFsoY2hyKCI7aTo0MDI7czoxMjoiWmVyb0RheUV4aWxlIjtpOjQwMztzOjEyOiJTdWx0YW5IYWlrYWwiO2k6NDA0O3M6MTE6IkNvdXBkZWdyYWNlIjtpOjQwNTtzOjk6ImFydGlja2xlQCI7aTo0MDY7czoxNToiZ25pdHJvcGVyX3JvcnJlIjtpOjQwNztzOjIzOiJjdXR0ZXJbYXRdcmVhbC54YWtlcC5ydSI7aTo0MDg7czoyOToiaWYoJHdwX193cD1AZ3ppbmZsYXRlKCR3cF9fd3AiO2k6NDA5O3M6NjoicjAwbml4IjtpOjQxMDtzOjIxOiIkZnVsbF9wYXRoX3RvX2Rvb3J3YXkiO2k6NDExO3M6MzA6IjxiPkRvbmUgPT0+ICR1c2VyZmlsZV9uYW1lPC9iPiI7aTo0MTI7czoxMjoiPkRhcmsgU2hlbGw8IjtpOjQxMztzOjE1OiIvLi4vKi9pbmRleC5waHAiO2k6NDE0O3M6MzI6ImlmKGlzX3VwbG9hZGVkX2ZpbGUvKjsqLygkX0ZJTEVTIjtpOjQxNTtzOjIzOiJleGVjKCRjb21tYW5kLCAkb3V0cHV0KSI7aTo0MTY7czoyMDoiQGluY2x1ZGVfb25jZSgnL3RtcC8iO30="));
$gX_DBShe = unserialize(base64_decode("YTo2Mjp7aTowO3M6NzoiZGVmYWNlciI7aToxO3M6MjQ6IllvdSBjYW4gcHV0IGEgbWQ1IHN0cmluZyI7aToyO3M6ODoicGhwc2hlbGwiO2k6MztzOjYyOiI8ZGl2IGNsYXNzPSJibG9jayBidHlwZTEiPjxkaXYgY2xhc3M9ImR0b3AiPjxkaXYgY2xhc3M9ImRidG0iPiI7aTo0O3M6ODoiYzk5c2hlbGwiO2k6NTtzOjg6InI1N3NoZWxsIjtpOjY7czo3OiJOVERhZGR5IjtpOjc7czo4OiJjaWhzaGVsbCI7aTo4O3M6NzoiRnhjOTlzaCI7aTo5O3M6MTI6IldlYiBTaGVsbCBieSI7aToxMDtzOjExOiJkZXZpbHpTaGVsbCI7aToxMTtzOjg6Ik4zdHNoZWxsIjtpOjEyO3M6MTE6IlN0b3JtN1NoZWxsIjtpOjEzO3M6MTE6IkxvY3VzN1NoZWxsIjtpOjE0O3M6MTI6InI1N3NoZWxsLnBocCI7aToxNTtzOjk6ImFudGlzaGVsbCI7aToxNjtzOjk6InJvb3RzaGVsbCI7aToxNztzOjExOiJteXNoZWxsZXhlYyI7aToxODtzOjg6IlNoZWxsIE9rIjtpOjE5O3M6MTQ6ImV4ZWMoInJtIC1yIC1mIjtpOjIwO3M6MTg6Ik5lIHVkYWxvcyB6YWdydXppdCI7aToyMTtzOjUxOiIkbWVzc2FnZSA9IGVyZWdfcmVwbGFjZSgiJTVDJTIyIiwgIiUyMiIsICRtZXNzYWdlKTsiO2k6MjI7czoxOToicHJpbnQgIlNwYW1lZCc+PGJyPiI7aToyMztzOjQwOiJzZXRjb29raWUoICJteXNxbF93ZWJfYWRtaW5fdXNlcm5hbWUiICk7IjtpOjI0O3M6Mzc6ImVsc2VpZihmdW5jdGlvbl9leGlzdHMoInNoZWxsX2V4ZWMiKSkiO2k6MjU7czo1OToiaWYgKGlzX2NhbGxhYmxlKCJleGVjIikgYW5kICFpbl9hcnJheSgiZXhlYyIsJGRpc2FibGVmdW5jKSkiO2k6MjY7czozNDoiaWYgKCgkcGVybXMgJiAweEMwMDApID09IDB4QzAwMCkgeyI7aToyNztzOjEwOiJkaXIgL09HIC9YIjtpOjI4O3M6MzY6ImluY2x1ZGUoJF9TRVJWRVJbJ0hUVFBfVVNFUl9BR0VOVCddKSI7aToyOTtzOjc6ImJyMHdzM3IiO2k6MzA7czo0OToiJ2h0dHBkLmNvbmYnLCd2aG9zdHMuY29uZicsJ2NmZy5waHAnLCdjb25maWcucGhwJyI7aTozMTtzOjM0OiIvcHJvYy9zeXMva2VybmVsL3lhbWEvcHRyYWNlX3Njb3BlIjtpOjMyO3M6MjM6ImV2YWwoZmlsZV9nZXRfY29udGVudHMoIjtpOjMzO3M6MTg6ImlzX3dyaXRhYmxlKCIvdmFyLyI7aTozNDtzOjE0OiIkR0xPQkFMU1snX19fXyI7aTozNTtzOjU1OiJpc19jYWxsYWJsZSgnZXhlYycpIGFuZCAhaW5fYXJyYXkoJ2V4ZWMnLCAkZGlzYWJsZWZ1bmNzIjtpOjM2O3M6NjoiazBkLmNjIjtpOjM3O3M6MjY6ImdtYWlsLXNtdHAtaW4ubC5nb29nbGUuY29tIjtpOjM4O3M6Nzoid2VicjAwdCI7aTozOTtzOjExOiJEZXZpbEhhY2tlciI7aTo0MDtzOjc6IkRlZmFjZXIiO2k6NDE7czoxMToiWyBQaHByb3h5IF0iO2k6NDI7czo4OiJbY29kZXJ6XSI7aTo0MztzOjMyOiI8IS0tI2V4ZWMgY21kPSIkSFRUUF9BQ0NFUFQiIC0tPiI7aTo0NDtzOjEyOiJdW3JvdW5kKDApXSgiO2k6NDU7czoxMToiU2ltQXR0YWNrZXIiO2k6NDY7czoxNToiRGFya0NyZXdGcmllbmRzIjtpOjQ3O3M6NzoiazJsbDMzZCI7aTo0ODtzOjc6IktrSzEzMzciO2k6NDk7czoxNToiSEFDS0VEIEJZIFNUT1JNIjtpOjUwO3M6MTQ6Ik1leGljYW5IYWNrZXJzIjtpOjUxO3M6MTU6Ik1yLlNoaW5jaGFuWDE5NiI7aTo1MjtzOjk6IkRlaWRhcmF+WCI7aTo1MztzOjEwOiJKaW5wYW50b216IjtpOjU0O3M6OToiMW43M2N0MTBuIjtpOjU1O3M6MTQ6IktpbmdTa3J1cGVsbG9zIjtpOjU2O3M6MTA6IkppbnBhbnRvbXoiO2k6NTc7czo5OiJDZW5naXpIYW4iO2k6NTg7czo5OiJyM3Yzbmc0bnMiO2k6NTk7czo5OiJCTEFDS1VOSVgiO2k6NjA7czo4OiJGaWxlc01hbiI7aTo2MTtzOjk6ImFydGlja2xlQCI7fQ=="));
$g_FlexDBShe = unserialize(base64_decode("YToyNzU6e2k6MDtzOjEwMDoiSU86OlNvY2tldDo6SU5FVC0+bmV3XChQcm90b1xzKj0+XHMqInRjcCJccyosXHMqTG9jYWxQb3J0XHMqPT5ccyozNjAwMFxzKixccypMaXN0ZW5ccyo9PlxzKlNPTUFYQ09OTiI7aToxO3M6OTY6IlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtccypbJyJdezAsMX1wMlsnIl17MCwxfVxzKlxdXHMqPT1ccypbJyJdezAsMX1jaG1vZFsnIl17MCwxfSI7aToyO3M6MjM6IkNhcHRhaW5ccytDcnVuY2hccytUZWFtIjtpOjM7czoxMToiYnlccytHcmluYXkiO2k6NDtzOjE5OiJoYWNrZWRccytieVxzK0htZWk3IjtpOjU7czozMzoic3lzdGVtXHMrZmlsZVxzK2RvXHMrbm90XHMrZGVsZXRlIjtpOjY7czozNToiZGVmYXVsdF9hY3Rpb25ccyo9XHMqXFxbJyJdRmlsZXNNYW4iO2k6NztzOjE3MDoiXCRpbmZvIFwuPSBcKFwoXCRwZXJtc1xzKiZccyoweDAwNDBcKVxzKlw/XChcKFwkcGVybXNccyomXHMqMHgwODAwXClccypcP1xzKlxcWyciXXNcXFsnIl1ccyo6XHMqXFxbJyJdeFxcWyciXVxzKlwpXHMqOlwoXChcJHBlcm1zXHMqJlxzKjB4MDgwMFwpXHMqXD9ccyonUydccyo6XHMqJy0nXHMqXCkiO2k6ODtzOjc4OiJXU09zZXRjb29raWVccypcKFxzKm1kNVxzKlwoXHMqQCpcJF9TRVJWRVJcW1xzKlxcWyciXUhUVFBfSE9TVFxcWyciXVxzKlxdXHMqXCkiO2k6OTtzOjc0OiJXU09zZXRjb29raWVccypcKFxzKm1kNVxzKlwoXHMqQCpcJF9TRVJWRVJcW1xzKlsnIl1IVFRQX0hPU1RbJyJdXHMqXF1ccypcKSI7aToxMDtzOjEwNzoid3NvRXhccypcKFxzKlxcWyciXVxzKnRhclxzKmNmenZccypcXFsnIl1ccypcLlxzKmVzY2FwZXNoZWxsYXJnXHMqXChccypcJF9QT1NUXFtccypcXFsnIl1wMlxcWyciXVxzKlxdXHMqXCkiO2k6MTE7czo0MDoiZXZhbFxzKlwoKlxzKmJhc2U2NF9kZWNvZGVccypcKCpccypAKlwkXyI7aToxMjtzOjc4OiJmaWxlcGF0aFxzKj1ccypAKnJlYWxwYXRoXHMqXChccypcJF9QT1NUXHMqXFtccypcXFsnIl1maWxlcGF0aFxcWyciXVxzKlxdXHMqXCkiO2k6MTM7czo3NDoiZmlsZXBhdGhccyo9XHMqQCpyZWFscGF0aFxzKlwoXHMqXCRfUE9TVFxzKlxbXHMqWyciXWZpbGVwYXRoWyciXVxzKlxdXHMqXCkiO2k6MTQ7czo0NzoicmVuYW1lXHMqXChccypccypbJyJdezAsMX13c29cLnBocFsnIl17MCwxfVxzKiwiO2k6MTU7czo5NzoiXCRNZXNzYWdlU3ViamVjdFxzKj1ccypiYXNlNjRfZGVjb2RlXHMqXChccypcJF9QT1NUXHMqXFtccypbJyJdezAsMX1tc2dzdWJqZWN0WyciXXswLDF9XHMqXF1ccypcKSI7aToxNjtzOjg3OiJTRUxFQ1RccysxXHMrRlJPTVxzK215c3FsXC51c2VyXHMrV0hFUkVccytjb25jYXRcKFxzKmB1c2VyYFxzKixccyonQCdccyosXHMqYGhvc3RgXHMqXCkiO2k6MTc7czo1NjoicGFzc3RocnVccypcKCpccypnZXRlbnZccypcKCpccypbJyJdSFRUUF9BQ0NFUFRfTEFOR1VBR0UiO2k6MTg7czo1ODoicGFzc3RocnVccypcKCpccypnZXRlbnZccypcKCpccypcXFsnIl1IVFRQX0FDQ0VQVF9MQU5HVUFHRSI7aToxOTtzOjU1OiJ7XHMqXCRccyp7XHMqcGFzc3RocnVccypcKCpccypcJGNtZFxzKlwpXHMqfVxzKn1ccyo8YnI+IjtpOjIwO3M6ODI6InJ1bmNvbW1hbmRccypcKFxzKlsnIl1zaGVsbGhlbHBbJyJdXHMqLFxzKlsnIl0oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVsnIl0iO2k6MjE7czozMToibmNmdHBwdXRccyotdVxzKlwkZnRwX3VzZXJfbmFtZSI7aToyMjtzOjM3OiJcJGxvZ2luXHMqPVxzKkAqcG9zaXhfZ2V0dWlkXCgqXHMqXCkqIjtpOjIzO3M6NDk6IiFAKlwkX1JFUVVFU1RccypcW1xzKlsnIl1jOTlzaF9zdXJsWyciXVxzKlxdXHMqXCkiO2k6MjQ7czoxMjY6IlxiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilccypcKCpccypAKlwkX1BPU1RccypcW1xzKlsnIl0uKz9bJyJdXHMqXF1ccypcLlxzKiJccyoyXHMqPlxzKiYxXHMqWyciXSI7aToyNTtzOjg4OiJcYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXHMqXCgqXHMqWyciXXVuYW1lXHMrLWFbJyJdXHMqXCkqIjtpOjI2O3M6NTM6InNldGNvb2tpZVwoKlxzKlsnIl1teXNxbF93ZWJfYWRtaW5fdXNlcm5hbWVbJyJdXHMqXCkqIjtpOjI3O3M6MTQzOiJcYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChbJyJdXCRjbWRccysxPlxzKi90bXAvY21kdGVtcFxzKzI+JjE7XHMqY2F0XHMrL3RtcC9jbWR0ZW1wO1xzKnJtXHMrL3RtcC9jbWR0ZW1wWyciXVwpOyI7aToyODtzOjI4OiJcJGZlXChbJyJdXCRjbWRccysyPiYxWyciXVwpIjtpOjI5O3M6OTY6IlwkZnVuY3Rpb25ccypcKCpccypAKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXHMqXFtccypbJyJdezAsMX1jbWRbJyJdezAsMX1ccypcXVxzKlwpKiI7aTozMDtzOjkzOiJcJGNtZFxzKj1ccypcKFxzKkAqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClccypcW1xzKlsnIl17MCwxfS4rP1snIl17MCwxfVxzKlxdXHMqXCkiO2k6MzE7czoyMToiZXZhMVthLXpBLVowLTlfXSs/U2lyIjtpOjMyO3M6ODk6IkAqYXNzZXJ0XHMqXCgqXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClccypcW1xzKlsnIl17MCwxfS4rP1snIl17MCwxfVxzKlxdXHMqIjtpOjMzO3M6Mjg6InBocFxzK1snIl1ccypcLlxzKlwkd3NvX3BhdGgiO2k6MzQ7czo1MjoiZmluZFxzKy9ccystbmFtZVxzK1wuc3NoXHMrPlxzK1wkZGlyL3NzaGtleXMvc3Noa2V5cyI7aTozNTtzOjQ1OiJzeXN0ZW1ccypcKCpccypbJyJdezAsMX13aG9hbWlbJyJdezAsMX1ccypcKSoiO2k6MzY7czo4ODoiY3VybF9zZXRvcHRccypcKFxzKlwkY2hccyosXHMqQ1VSTE9QVF9VUkxccyosXHMqWyciXXswLDF9aHR0cDovL1wkaG9zdDpcZCtbJyJdezAsMX1ccypcKSI7aTozNztzOjg4OiJcJGluaVxzKlxbXHMqWyciXXswLDF9dXNlcnNbJyJdezAsMX1ccypcXVxzKj1ccyphcnJheVxzKlwoXHMqWyciXXswLDF9cm9vdFsnIl17MCwxfVxzKj0+IjtpOjM4O3M6MzM6InByb2Nfb3BlblxzKlwoXHMqWyciXXswLDF9SUhTdGVhbSI7aTozOTtzOjEzNToiWyciXXswLDF9aHR0cGRcLmNvbmZbJyJdezAsMX1ccyosXHMqWyciXXswLDF9dmhvc3RzXC5jb25mWyciXXswLDF9XHMqLFxzKlsnIl17MCwxfWNmZ1wucGhwWyciXXswLDF9XHMqLFxzKlsnIl17MCwxfWNvbmZpZ1wucGhwWyciXXswLDF9IjtpOjQwO3M6ODE6IlxzKntccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxzKlxbXHMqWyciXXswLDF9cm9vdFsnIl17MCwxfVxzKlxdXHMqfSI7aTo0MTtzOjQ2OiJwcmVnX3JlcGxhY2VccypcKCpccypbJyJdezAsMX0vXC5cKi9lWyciXXswLDF9IjtpOjQyO3M6MzY6ImV2YWxccypcKCpccypmaWxlX2dldF9jb250ZW50c1xzKlwoKiI7aTo0MztzOjc0OiJAKnNldGNvb2tpZVxzKlwoKlxzKlsnIl17MCwxfWhpdFsnIl17MCwxfSxccyoxXHMqLFxzKnRpbWVccypcKCpccypcKSpccypcKyI7aTo0NDtzOjQxOiJldmFsXHMqXCgqQCpccypzdHJpcHNsYXNoZXNccypcKCpccypAKlwkXyI7aTo0NTtzOjU5OiJldmFsXHMqXCgqQCpccypzdHJpcHNsYXNoZXNccypcKCpccyphcnJheV9wb3BccypcKCpccypAKlwkXyI7aTo0NjtzOjQzOiJmb3BlblxzKlwoKlxzKlsnIl17MCwxfS9ldGMvcGFzc3dkWyciXXswLDF9IjtpOjQ3O3M6MjQ6IlwkR0xPQkFMU1xbWyciXXswLDF9X19fXyI7aTo0ODtzOjIxNzoiaXNfY2FsbGFibGVccypcKCpccypbJyJdezAsMX1cYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pWyciXXswLDF9XCkqXHMrYW5kXHMrIWluX2FycmF5XHMqXCgqXHMqWyciXXswLDF9XGIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVsnIl17MCwxfVxzKixccypcJGRpc2FibGVmdW5jcyI7aTo0OTtzOjExMjoiZmlsZV9nZXRfY29udGVudHNccypcKCpccyp0cmltXHMqXChccypcJC4rP1xbXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl17MCwxfS4rP1snIl17MCwxfVxdXF1cKVwpOyI7aTo1MDtzOjEzNjoid3BfcG9zdHNccytXSEVSRVxzK3Bvc3RfdHlwZVxzKj1ccypbJyJdezAsMX1wb3N0WyciXXswLDF9XHMrQU5EXHMrcG9zdF9zdGF0dXNccyo9XHMqWyciXXswLDF9cHVibGlzaFsnIl17MCwxfVxzK09SREVSXHMrQllccytgSURgXHMrREVTQyI7aTo1MTtzOjIwOiJleGVjXHMqXChccypbJyJdaXBmdyI7aTo1MjtzOjQyOiJzdHJyZXZcKCpccypbJyJdezAsMX10cmVzc2FbJyJdezAsMX1ccypcKSoiO2k6NTM7czo0OToic3RycmV2XCgqXHMqWyciXXswLDF9ZWRvY2VkXzQ2ZXNhYlsnIl17MCwxfVxzKlwpKiI7aTo1NDtzOjcwOiJmdW5jdGlvblxzK3VybEdldENvbnRlbnRzXHMqXCgqXHMqXCR1cmxccyosXHMqXCR0aW1lb3V0XHMqPVxzKlxkK1xzKlwpIjtpOjU1O3M6MjY6InN5bWxpbmtccypcKCpccypbJyJdL2hvbWUvIjtpOjU2O3M6NzE6ImZ3cml0ZVxzKlwoKlxzKlwkZnBzZXR2XHMqLFxzKmdldGVudlxzKlwoXHMqWyciXUhUVFBfQ09PS0lFWyciXVxzKlwpXHMqIjtpOjU3O3M6NjY6Imlzc2V0XHMqXCgqXHMqXCRfUE9TVFxzKlxbXHMqWyciXXswLDF9ZXhlY2dhdGVbJyJdezAsMX1ccypcXVxzKlwpKiI7aTo1ODtzOjIwMDoiVU5JT05ccytTRUxFQ1RccytbJyJdezAsMX0wWyciXXswLDF9XHMqLFxzKlsnIl17MCwxfTxcPyBzeXN0ZW1cKFxcXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW2NwY1xdXCk7ZXhpdDtccypcPz5bJyJdezAsMX1ccyosXHMqMFxzKiwwXHMqLFxzKjBccyosXHMqMFxzK0lOVE9ccytPVVRGSUxFXHMrWyciXXswLDF9XCRbJyJdezAsMX0iO2k6NTk7czoxNDk6IlwkR0xPQkFMU1xbWyciXXswLDF9Lis/WyciXXswLDF9XF09QXJyYXlccypcKFxzKmJhc2U2NF9kZWNvZGVccypcKFxzKlsnIl17MCwxfS4rP1snIl17MCwxfVxzKlwpXHMqLFxzKmJhc2U2NF9kZWNvZGVccypcKFxzKlsnIl17MCwxfS4rP1snIl17MCwxfVxzKlwpIjtpOjYwO3M6NzM6InByZWdfcmVwbGFjZVxzKlwoKlxzKlsnIl17MCwxfS9cLlwqXFsuKz9cXVw/L2VbJyJdezAsMX1ccyosXHMqc3RyX3JlcGxhY2UiO2k6NjE7czoxMDE6IlwkR0xPQkFMU1xbXHMqWyciXXswLDF9Lis/WyciXXswLDF9XHMqXF1cW1xzKlxkK1xzKlxdXChccypcJF9cZCtccyosXHMqX1xkK1xzKlwoXHMqXGQrXHMqXClccypcKVxzKlwpIjtpOjYyO3M6MTE1OiJcJGJlZWNvZGVccyo9QCpmaWxlX2dldF9jb250ZW50c1xzKlwoKlsnIl17MCwxfVxzKlwkdXJscHVyc1xzKlsnIl17MCwxfVwpKlxzKjtccyplY2hvXHMrWyciXXswLDF9XCRiZWVjb2RlWyciXXswLDF9IjtpOjYzO3M6Nzk6IlwkeFxkK1xzKj1ccypbJyJdLis/WyciXVxzKjtccypcJHhcZCtccyo9XHMqWyciXS4rP1snIl1ccyo7XHMqXCR4XGQrXHMqPVxzKlsnIl0iO2k6NjQ7czo0MzoiPFw/cGhwXHMrXCRfRlxzKj1ccypfX0ZJTEVfX1xzKjtccypcJF9YXHMqPSI7aTo2NTtzOjY4OiJpZlxzK1woKlxzKm1haWxccypcKFxzKlwkcmVjcFxzKixccypcJHN1YmpccyosXHMqXCRzdHVudFxzKixccypcJGZybSI7aTo2NjtzOjEzOToiaWZccytcKFxzKnN0cnBvc1xzKlwoXHMqXCR1cmxccyosXHMqWyciXWpzL21vb3Rvb2xzXC5qc1snIl1ccypcKVxzKj09PVxzKmZhbHNlXHMrJiZccytzdHJwb3NccypcKFxzKlwkdXJsXHMqLFxzKlsnIl1qcy9jYXB0aW9uXC5qc1snIl17MCwxfSI7aTo2NztzOjgxOiJldmFsXHMqXCgqXHMqc3RyaXBzbGFzaGVzXHMqXCgqXHMqYXJyYXlfcG9wXCgqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVCkiO2k6Njg7czoyNjE6ImlmXHMqXCgqXHMqaXNzZXRccypcKCpccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxzKlxbXHMqWyciXXswLDF9W2EtekEtWl8wLTldK1snIl17MCwxfVxzKlxdXHMqXCkqXHMqXClccyp7XHMqXCRbYS16QS1aXzAtOV0rXHMqPVxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXHMqXFtccypbJyJdezAsMX1bYS16QS1aXzAtOV0rWyciXXswLDF9XHMqXF07XHMqZXZhbFxzKlwoKlxzKlwkW2EtekEtWl8wLTldK1xzKlwpKiI7aTo2OTtzOjEyMzoicHJlZ19yZXBsYWNlXHMqXChccypbJyJdL1xeXCh3d3dcfGZ0cFwpXFxcLi9pWyciXVxzKixccypbJyJdWyciXSxccypAXCRfU0VSVkVSXHMqXFtccypbJyJdezAsMX1IVFRQX0hPU1RbJyJdezAsMX1ccypcXVxzKlwpIjtpOjcwO3M6MTAxOiJpZlxzKlwoIWZ1bmN0aW9uX2V4aXN0c1xzKlwoXHMqWyciXXBvc2l4X2dldHB3dWlkWyciXVxzKlwpXHMqJiZccyohaW5fYXJyYXlccypcKFxzKlsnIl1wb3NpeF9nZXRwd3VpZCI7aTo3MTtzOjg4OiI9XHMqcHJlZ19zcGxpdFxzKlwoXHMqWyciXS9cXCxcKFxcIFwrXClcPy9bJyJdLFxzKkAqaW5pX2dldFxzKlwoXHMqWyciXWRpc2FibGVfZnVuY3Rpb25zIjtpOjcyO3M6NDc6IlwkYlxzKlwuXHMqXCRwXHMqXC5ccypcJGhccypcLlxzKlwka1xzKlwuXHMqXCR2IjtpOjczO3M6MjM6IlwoXHMqWyciXUlOU0hFTExbJyJdXHMqIjtpOjc0O3M6NTQ6IihHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXHMqXFtccypbJyJdX19fWyciXVxzKiI7aTo3NTtzOjk0OiJhcnJheV9wb3BccypcKCpccypcJHdvcmtSZXBsYWNlXHMqLFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXHMqLFxzKlwkY291bnRLZXlzTmV3IjtpOjc2O3M6MzU6ImlmXHMqXCgqXHMqQCpwcmVnX21hdGNoXHMqXCgqXHMqc3RyIjtpOjc3O3M6NDM6IkBcJF9DT09LSUVcW1snIl17MCwxfXN0YXRDb3VudGVyWyciXXswLDF9XF0iO2k6Nzg7czoxMDU6ImZvcGVuXHMqXCgqXHMqWyciXWh0dHA6Ly9bJyJdXHMqXC5ccypcJGNoZWNrX2RvbWFpblxzKlwuXHMqWyciXTo4MFsnIl1ccypcLlxzKlwkY2hlY2tfZG9jXHMqLFxzKlsnIl1yWyciXSI7aTo3OTtzOjU1OiJAKmd6aW5mbGF0ZVxzKlwoXHMqQCpiYXNlNjRfZGVjb2RlXHMqXChccypAKnN0cl9yZXBsYWNlIjtpOjgwO3M6Mjg6ImZpbGVfcHV0X2NvbnRlbnR6XHMqXCgqXHMqXCQiO2k6ODE7czo4NzoiJiZccypmdW5jdGlvbl9leGlzdHNccypcKCpccypbJyJdezAsMX1nZXRteHJyWyciXXswLDF9XClccypcKVxzKntccypAZ2V0bXhyclxzKlwoKlxzKlwkIjtpOjgyO3M6NDE6IlwkcG9zdFJlc3VsdFxzKj1ccypjdXJsX2V4ZWNccypcKCpccypcJGNoIjtpOjgzO3M6MjU6ImZ1bmN0aW9uXHMrc3FsMl9zYWZlXHMqXCgiO2k6ODQ7czo4NToiZXhpdFxzKlwoXHMqWyciXXswLDF9PHNjcmlwdD5ccypzZXRUaW1lb3V0XHMqXChccypcXFsnIl17MCwxfWRvY3VtZW50XC5sb2NhdGlvblwuaHJlZiI7aTo4NTtzOjM4OiJldmFsXChccypzdHJpcHNsYXNoZXNcKFxzKlxcXCRfUkVRVUVTVCI7aTo4NjtzOjM2OiIhdG91Y2hcKFsnIl17MCwxfVwuXC4vXC5cLi9sYW5ndWFnZS8iO2k6ODc7czoxMDoiRGMwUkhhWyciXSI7aTo4ODtzOjYwOiJoZWFkZXJccypcKFsnIl1Mb2NhdGlvbjpccypbJyJdXHMqXC5ccypcJHRvXHMqXC5ccyp1cmxkZWNvZGUiO2k6ODk7czoxNTY6ImlmXHMqXChccypzdHJpcG9zXHMqXChccypcJF9TRVJWRVJcW1snIl17MCwxfUhUVFBfVVNFUl9BR0VOVFsnIl17MCwxfVxdXHMqLFxzKlsnIl17MCwxfUFuZHJvaWRbJyJdezAsMX1cKVxzKiE9PWZhbHNlXHMqJiZccyohXCRfQ09PS0lFXFtbJyJdezAsMX1kbGVfdXNlcl9pZCI7aTo5MDtzOjM4OiJlY2hvXHMrQGZpbGVfZ2V0X2NvbnRlbnRzXHMqXChccypcJGdldCI7aTo5MTtzOjQ3OiJkZWZhdWx0X2FjdGlvblxzKj1ccypbJyJdezAsMX1GaWxlc01hblsnIl17MCwxfSI7aTo5MjtzOjMzOiJkZWZpbmVccypcKFxzKlsnIl1ERUZDQUxMQkFDS01BSUwiO2k6OTM7czoxNzoiTXlzdGVyaW91c1xzK1dpcmUiO2k6OTQ7czozNDoicHJlZ19yZXBsYWNlXHMqXCgqXHMqWyciXS9cLlwrL2VzaSI7aTo5NTtzOjQ1OiJkZWZpbmVccypcKCpccypbJyJdU0JDSURfUkVRVUVTVF9GSUxFWyciXVxzKiwiO2k6OTY7czo2MDoiXCR0bGRccyo9XHMqYXJyYXlccypcKFxzKlsnIl1jb21bJyJdLFsnIl1vcmdbJyJdLFsnIl1uZXRbJyJdIjtpOjk3O3M6MTc6IkJyYXppbFxzK0hhY2tUZWFtIjtpOjk4O3M6MTQ1OiJpZlwoIWVtcHR5XChcJF9GSUxFU1xbWyciXXswLDF9bWVzc2FnZVsnIl17MCwxfVxdXFtbJyJdezAsMX1uYW1lWyciXXswLDF9XF1cKVxzK0FORFxzK1wobWQ1XChcJF9QT1NUXFtbJyJdezAsMX1uaWNrWyciXXswLDF9XF1cKVxzKj09XHMqWyciXXswLDF9IjtpOjk5O3M6NzU6InRpbWVcKFwpXHMqXCtccyoxMDAwMFxzKixccypbJyJdL1snIl1cKTtccyplY2hvXHMrXCRtX3p6O1xzKmV2YWxccypcKFwkbV96eiI7aToxMDA7czoxMDY6InJldHVyblxzKlwoXHMqc3Ryc3RyXHMqXChccypcJHNccyosXHMqJ2VjaG8nXHMqXClccyo9PVxzKmZhbHNlXHMqXD9ccypcKFxzKnN0cnN0clxzKlwoXHMqXCRzXHMqLFxzKidwcmludCciO2k6MTAxO3M6Njc6InNldF90aW1lX2xpbWl0XHMqXChccyowXHMqXCk7XHMqaWZccypcKCFTZWNyZXRQYWdlSGFuZGxlcjo6Y2hlY2tLZXkiO2k6MTAyO3M6NzM6IkBoZWFkZXJcKFsnIl1Mb2NhdGlvbjpccypbJyJdXC5bJyJdaFsnIl1cLlsnIl10WyciXVwuWyciXXRbJyJdXC5bJyJdcFsnIl0iO2k6MTAzO3M6OToiSXJTZWNUZWFtIjtpOjEwNDtzOjk3OiJcJHJCdWZmTGVuXHMqPVxzKm9yZFxzKlwoXHMqVkNfRGVjcnlwdFxzKlwoXHMqZnJlYWRccypcKFxzKlwkaW5wdXQsXHMqMVxzKlwpXHMqXClccypcKVxzKlwqXHMqMjU2IjtpOjEwNTtzOjc0OiJjbGVhcnN0YXRjYWNoZVwoXHMqXCk7XHMqaWZccypcKFxzKiFpc19kaXJccypcKFxzKlwkZmxkXHMqXClccypcKVxzKnJldHVybiI7aToxMDY7czo5NzoiY29udGVudD1bJyJdezAsMX1uby1jYWNoZVsnIl17MCwxfTtccypcJGNvbmZpZ1xbWyciXXswLDF9ZGVzY3JpcHRpb25bJyJdezAsMX1cXVxzKlwuPVxzKlsnIl17MCwxfSI7aToxMDc7czoxMjoidG1oYXBiemNlcmZmIjtpOjEwODtzOjcwOiJmaWxlX2dldF9jb250ZW50c1xzKlwoKlxzKkFETUlOX1JFRElSX1VSTFxzKixccypmYWxzZVxzKixccypcJGN0eFxzKlwpIjtpOjEwOTtzOjg3OiJpZlxzKlwoXHMqXCRpXHMqPFxzKlwoXHMqY291bnRccypcKFxzKlwkX1BPU1RcW1xzKlsnIl17MCwxfXFbJyJdezAsMX1ccypcXVxzKlwpXHMqLVxzKjEiO2k6MTEwO3M6MjMyOiJpc3NldFxzKlwoXHMqXCRfRklMRVNcW1xzKlsnIl17MCwxfXhbJyJdezAsMX1ccypcXVxzKlwpXHMqXD9ccypcKFxzKmlzX3VwbG9hZGVkX2ZpbGVccypcKFxzKlwkX0ZJTEVTXFtccypbJyJdezAsMX14WyciXXswLDF9XHMqXF1cW1xzKlsnIl17MCwxfXRtcF9uYW1lWyciXXswLDF9XHMqXF1ccypcKVxzKlw/XHMqXChccypjb3B5XHMqXChccypcJF9GSUxFU1xbXHMqWyciXXswLDF9eFsnIl17MCwxfVxzKlxdIjtpOjExMTtzOjgyOiJcJFVSTFxzKj1ccypcJHVybHNcW1xzKnJhbmRcKFxzKjBccyosXHMqY291bnRccypcKFxzKlwkdXJsc1xzKlwpXHMqLVxzKjFccypcKVxzKlxdIjtpOjExMjtzOjIxMzoiQCptb3ZlX3VwbG9hZGVkX2ZpbGVccypcKFxzKlwkX0ZJTEVTXFtccypbJyJdezAsMX1tZXNzYWdlWyciXXswLDF9XHMqXF1cW1xzKlsnIl17MCwxfXRtcF9uYW1lWyciXXswLDF9XHMqXF1ccyosXHMqXCRzZWN1cml0eV9jb2RlXHMqXC5ccyoiLyJccypcLlxzKlwkX0ZJTEVTXFtbJyJdezAsMX1tZXNzYWdlWyciXXswLDF9XF1cW1snIl17MCwxfW5hbWVbJyJdezAsMX1cXVwpIjtpOjExMztzOjM5OiJldmFsXHMqXCgqXHMqc3RycmV2XHMqXCgqXHMqc3RyX3JlcGxhY2UiO2k6MTE0O3M6ODE6IlwkcmVzPW15c3FsX3F1ZXJ5XChbJyJdezAsMX1TRUxFQ1RccytcKlxzK0ZST01ccytgd2F0Y2hkb2dfb2xkXzA1YFxzK1dIRVJFXHMrcGFnZSI7aToxMTU7czo3MjoiXF5kb3dubG9hZHMvXChcWzAtOVxdXCpcKS9cKFxbMC05XF1cKlwpL1wkXHMrZG93bmxvYWRzXC5waHBcP2M9XCQxJnA9XCQyIjtpOjExNjtzOjkyOiJwcmVnX3JlcGxhY2VccypcKFxzKlwkZXhpZlxbXHMqXFxbJyJdTWFrZVxcWyciXVxzKlxdXHMqLFxzKlwkZXhpZlxbXHMqXFxbJyJdTW9kZWxcXFsnIl1ccypcXSI7aToxMTc7czozODoiZmNsb3NlXChcJGZcKTtccyplY2hvXHMqWyciXW9cLmtcLlsnIl0iO2k6MTE4O3M6NDE6ImZ1bmN0aW9uXHMraW5qZWN0XChcJGZpbGUsXHMqXCRpbmplY3Rpb249IjtpOjExOTtzOjcxOiJleGVjbFwoWyciXS9iaW4vc2hbJyJdXHMqLFxzKlsnIl0vYmluL3NoWyciXVxzKixccypbJyJdLWlbJyJdXHMqLFxzKjBcKSI7aToxMjA7czo0MzoiZmluZFxzKy9ccystdHlwZVxzK2ZccystcGVybVxzKy0wNDAwMFxzKy1scyI7aToxMjE7czo0NDoiaWZccypcKFxzKmZ1bmN0aW9uX2V4aXN0c1xzKlwoXHMqJ3BjbnRsX2ZvcmsiO2k6MTIyO3M6NjU6InVybGVuY29kZVwocHJpbnRfclwoYXJyYXlcKFwpLDFcKVwpLDUsMVwpXC5jXCksXCRjXCk7fWV2YWxcKFwkZFwpIjtpOjEyMztzOjg5OiJhcnJheV9rZXlfZXhpc3RzXHMqXChccypcJGZpbGVSYXNccyosXHMqXCRmaWxlVHlwZVwpXHMqXD9ccypcJGZpbGVUeXBlXFtccypcJGZpbGVSYXNccypcXSI7aToxMjQ7czo5OToiaWZccypcKFxzKmZ3cml0ZVxzKlwoXHMqXCRoYW5kbGVccyosXHMqZmlsZV9nZXRfY29udGVudHNccypcKFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjEyNTtzOjE3ODoiaWZccypcKFxzKlwkX1BPU1RcW1xzKlsnIl17MCwxfXBhdGhbJyJdezAsMX1ccypcXVxzKj09XHMqWyciXXswLDF9WyciXXswLDF9XHMqXClccyp7XHMqXCR1cGxvYWRmaWxlXHMqPVxzKlwkX0ZJTEVTXFtccypbJyJdezAsMX1maWxlWyciXXswLDF9XHMqXF1cW1xzKlsnIl17MCwxfW5hbWVbJyJdezAsMX1ccypcXSI7aToxMjY7czo4MzoiaWZccypcKFxzKlwkZGF0YVNpemVccyo8XHMqQk9UQ1JZUFRfTUFYX1NJWkVccypcKVxzKnJjNFxzKlwoXHMqXCRkYXRhLFxzKlwkY3J5cHRrZXkiO2k6MTI3O3M6OTA6IixccyphcnJheVxzKlwoJ1wuJywnXC5cLicsJ1RodW1ic1wuZGInXClccypcKVxzKlwpXHMqe1xzKmNvbnRpbnVlO1xzKn1ccyppZlxzKlwoXHMqaXNfZmlsZSI7aToxMjg7czo1MToiXClccypcLlxzKnN1YnN0clxzKlwoXHMqbWQ1XHMqXChccypzdHJyZXZccypcKFxzKlwkIjtpOjEyOTtzOjI4OiJhc3NlcnRccypcKFxzKkAqc3RyaXBzbGFzaGVzIjtpOjEzMDtzOjE1OiJbJyJdZS9cKlwuL1snIl0iO2k6MTMxO3M6NTI6ImVjaG9bJyJdezAsMX08Y2VudGVyPjxiPkRvbmVccyo9PT5ccypcJHVzZXJmaWxlX25hbWUiO2k6MTMyO3M6MTM0OiJpZlxzKlwoXCRrZXlccyohPVxzKlsnIl17MCwxfW1haWxfdG9bJyJdezAsMX1ccyomJlxzKlwka2V5XHMqIT1ccypbJyJdezAsMX1zbXRwX3NlcnZlclsnIl17MCwxfVxzKiYmXHMqXCRrZXlccyohPVxzKlsnIl17MCwxfXNtdHBfcG9ydCI7aToxMzM7czo1OToic3RycG9zXChcJHVhLFxzKlsnIl17MCwxfXlhbmRleGJvdFsnIl17MCwxfVwpXHMqIT09XHMqZmFsc2UiO2k6MTM0O3M6NDU6ImlmXChDaGVja0lQT3BlcmF0b3JcKFwpXHMqJiZccyohaXNNb2RlbVwoXClcKSI7aToxMzU7czozNDoidXJsPTxcP3BocFxzKmVjaG9ccypcJHJhbmRfdXJsO1w/PiI7aToxMzY7czoyNzoiZWNob1xzKlsnIl1hbnN3ZXI9ZXJyb3JbJyJdIjtpOjEzNztzOjMyOiJcJHBvc3Rccyo9XHMqWyciXVxceDc3XFx4NjdcXHg2NSI7aToxMzg7czo0NjoiaWZccypcKGRldGVjdF9tb2JpbGVfZGV2aWNlXChcKVwpXHMqe1xzKmhlYWRlciI7aToxMzk7czo5OiJJcklzVFwuSXIiO2k6MTQwO3M6ODk6IlwkbGV0dGVyXHMqPVxzKnN0cl9yZXBsYWNlXHMqXChccypcJEFSUkFZXFswXF1cW1wkalxdXHMqLFxzKlwkYXJyXFtcJGluZFxdXHMqLFxzKlwkbGV0dGVyIjtpOjE0MTtzOjkyOiJjcmVhdGVfZnVuY3Rpb25ccypcKFxzKlsnIl1cJG1bJyJdXHMqLFxzKlsnIl1pZlxzKlwoXHMqXCRtXHMqXFtccyoweDAxXHMqXF1ccyo9PVxzKlsnIl1MWyciXSI7aToxNDI7czo3MjoiXCRwXHMqPVxzKnN0cnBvc1woXCR0eFxzKixccypbJyJdezAsMX17XCNbJyJdezAsMX1ccyosXHMqXCRwMlxzKlwrXHMqMlwpIjtpOjE0MztzOjExMjoiXCR1c2VyX2FnZW50XHMqPVxzKnByZWdfcmVwbGFjZVxzKlwoXHMqWyciXVx8VXNlclxcXC5BZ2VudFxcOlxbXFxzIFxdXD9cfGlbJyJdXHMqLFxzKlsnIl1bJyJdXHMqLFxzKlwkdXNlcl9hZ2VudCI7aToxNDQ7czozMToicHJpbnRcKCJcI1xzK2luZm9ccytPS1xcblxcbiJcKSI7aToxNDU7czo1MToiXF1ccyp9XHMqPVxzKnRyaW1ccypcKFxzKmFycmF5X3BvcFxzKlwoXHMqXCR7XHMqXCR7IjtpOjE0NjtzOjY0OiJcXT1bJyJdezAsMX1pcFsnIl17MCwxfVxzKjtccyppZlxzKlwoXHMqaXNzZXRccypcKFxzKlwkX1NFUlZFUlxbIjtpOjE0NztzOjM0OiJwcmludFxzKlwkc29jayAiUFJJVk1TRyAiXC5cJG93bmVyIjtpOjE0ODtzOjYzOiJpZlwoL1xeXFw6XCRvd25lciFcLlwqXFxAXC5cKlBSSVZNU0dcLlwqOlwubXNnZmxvb2RcKFwuXCpcKS9cKXsiO2k6MTQ5O3M6MjY6IlxbLVxdXHMrQ29ubmVjdGlvblxzK2ZhaWxkIjtpOjE1MDtzOjU0OiI8IS0tXCNleGVjXHMrY21kPVsnIl17MCwxfVwkSFRUUF9BQ0NFUFRbJyJdezAsMX1ccyotLT4iO2k6MTUxO3M6MTY3OiJbJyJdezAsMX1Gcm9tOlxzKlsnIl17MCwxfVwuXCRfUE9TVFxbWyciXXswLDF9cmVhbG5hbWVbJyJdezAsMX1cXVwuWyciXXswLDF9IFsnIl17MCwxfVwuWyciXXswLDF9IDxbJyJdezAsMX1cLlwkX1BPU1RcW1snIl17MCwxfWZyb21bJyJdezAsMX1cXVwuWyciXXswLDF9PlxcblsnIl17MCwxfSI7aToxNTI7czo5OToiaWZccypcKFxzKmlzX2RpclxzKlwoXHMqXCRGdWxsUGF0aFxzKlwpXHMqXClccypBbGxEaXJccypcKFxzKlwkRnVsbFBhdGhccyosXHMqXCRGaWxlc1xzKlwpO1xzKn1ccyp9IjtpOjE1MztzOjc4OiJcJHBccyo9XHMqc3RycG9zXHMqXChccypcJHR4XHMqLFxzKlsnIl17MCwxfXtcI1snIl17MCwxfVxzKixccypcJHAyXHMqXCtccyoyXCkiO2k6MTU0O3M6MTIzOiJwcmVnX21hdGNoX2FsbFwoWyciXXswLDF9LzxhIGhyZWY9IlxcL3VybFxcXD9xPVwoXC5cK1w/XClcWyZcfCJcXVwrL2lzWyciXXswLDF9LCBcJHBhZ2VcW1snIl17MCwxfWV4ZVsnIl17MCwxfVxdLCBcJGxpbmtzXCkiO2k6MTU1O3M6ODA6IlwkdXJsXHMqPVxzKlwkdXJsXHMqXC5ccypbJyJdezAsMX1cP1snIl17MCwxfVxzKlwuXHMqaHR0cF9idWlsZF9xdWVyeVwoXCRxdWVyeVwpIjtpOjE1NjtzOjgzOiJwcmludFxzK1wkc29ja1xzK1snIl17MCwxfU5JQ0sgWyciXXswLDF9XHMrXC5ccytcJG5pY2tccytcLlxzK1snIl17MCwxfVxcblsnIl17MCwxfSI7aToxNTc7czozMjoiUFJJVk1TR1wuXCo6XC5vd25lclxcc1wrXChcLlwqXCkiO2k6MTU4O3M6MTU6Ii91c3Ivc2Jpbi9odHRwZCI7aToxNTk7czo3NToiXCRyZXN1bHRGVUxccyo9XHMqc3RyaXBjc2xhc2hlc1xzKlwoXHMqXCRfUE9TVFxbWyciXXswLDF9cmVzdWx0RlVMWyciXXswLDF9IjtpOjE2MDtzOjE1MjoiXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl17MCwxfVthLXpBLVowLTlfXSs/WyciXXswLDF9XF1cKFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtbJyJdezAsMX1bYS16QS1aMC05X10rP1snIl17MCwxfVxdXHMqXCkiO2k6MTYxO3M6NjA6ImlmXHMqXChccypAKm1kNVxzKlwoXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcWyI7aToxNjI7czo5NDoiZWNob1xzK2ZpbGVfZ2V0X2NvbnRlbnRzXHMqXChccypiYXNlNjRfdXJsX2RlY29kZVxzKlwoXHMqQCpcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKSI7aToxNjM7czo4NDoiZndyaXRlXHMqXChccypcJGZoXHMqLFxzKnN0cmlwc2xhc2hlc1xzKlwoXHMqQCpcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbIjtpOjE2NDtzOjgzOiJpZlxzKlwoXHMqbWFpbFxzKlwoXHMqXCRtYWlsc1xbXCRpXF1ccyosXHMqXCR0ZW1hXHMqLFxzKmJhc2U2NF9lbmNvZGVccypcKFxzKlwkdGV4dCI7aToxNjU7czo2MjoiXCRnemlwXHMqPVxzKkAqZ3ppbmZsYXRlXHMqXChccypAKnN1YnN0clxzKlwoXHMqXCRnemVuY29kZV9hcmciO2k6MTY2O3M6NzM6Im1vdmVfdXBsb2FkZWRfZmlsZVwoXCRfRklMRVNcW1snIl17MCwxfWVsaWZbJyJdezAsMX1cXVxbWyciXXswLDF9dG1wX25hbWUiO2k6MTY3O3M6ODA6ImhlYWRlclwoWyciXXswLDF9czpccypbJyJdezAsMX1ccypcLlxzKnBocF91bmFtZVxzKlwoXHMqWyciXXswLDF9blsnIl17MCwxfVxzKlwpIjtpOjE2ODtzOjEyOiJCeVxzK1dlYlJvb1QiO2k6MTY5O3M6NTc6IlwkT09PME8wTzAwPV9fRklMRV9fO1xzKlwkT08wME8wMDAwXHMqPVxzKjB4MWI1NDA7XHMqZXZhbCI7aToxNzA7czo1MjoiXCRtYWlsZXJccyo9XHMqXCRfUE9TVFxbWyciXXswLDF9eF9tYWlsZXJbJyJdezAsMX1cXSI7aToxNzE7czo3NzoicHJlZ19tYXRjaFwoWyciXS9cKHlhbmRleFx8Z29vZ2xlXHxib3RcKS9pWyciXSxccypnZXRlbnZcKFsnIl1IVFRQX1VTRVJfQUdFTlQiO2k6MTcyO3M6NDc6ImVjaG9ccytcJGlmdXBsb2FkPVsnIl17MCwxfVxzKkl0c09rXHMqWyciXXswLDF9IjtpOjE3MztzOjQyOiJmc29ja29wZW5ccypcKFxzKlwkQ29ubmVjdEFkZHJlc3NccyosXHMqMjUiO2k6MTc0O3M6NjQ6IlwkX1NFU1NJT05cW1snIl17MCwxfXNlc3Npb25fcGluWyciXXswLDF9XF1ccyo9XHMqWyciXXswLDF9XCRQSU4iO2k6MTc1O3M6NjM6IlwkdXJsWyciXXswLDF9XHMqXC5ccypcJHNlc3Npb25faWRccypcLlxzKlsnIl17MCwxfS9sb2dpblwuaHRtbCI7aToxNzY7czo0NDoiZlxzKj1ccypcJHFccypcLlxzKlwkYVxzKlwuXHMqXCRiXHMqXC5ccypcJHgiO2k6MTc3O3M6NTU6ImlmXHMqXChtZDVcKHRyaW1cKFwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFsiO2k6MTc4O3M6MzM6ImRpZVxzKlwoXHMqUEhQX09TXHMqXC5ccypjaHJccypcKCI7aToxNzk7czoxOTI6ImNyZWF0ZV9mdW5jdGlvblxzKlwoWyciXVsnIl1ccyosXHMqXGIoZXZhbHxiYXNlNjRfZGVjb2RlfHN0cnJldnxwcmVnX3JlcGxhY2V8cHJlZ19yZXBsYWNlX2NhbGxiYWNrfHVybGRlY29kZXxzdHJzdHJ8Z3ppbmZsYXRlfHNwcmludGZ8Z3p1bmNvbXByZXNzfGFzc2VydHxzdHJfcm90MTN8bWQ1fGFycmF5X3dhbGt8YXJyYXlfZmlsdGVyKSI7aToxODA7czo4MDoiXCRoZWFkZXJzXHMqPVxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtbJyJdezAsMX1oZWFkZXJzWyciXXswLDF9XF0iO2k6MTgxO3M6ODY6ImZpbGVfcHV0X2NvbnRlbnRzXHMqXChbJyJdezAsMX0xXC50eHRbJyJdezAsMX1ccyosXHMqcHJpbnRfclxzKlwoXHMqXCRfUE9TVFxzKixccyp0cnVlIjtpOjE4MjtzOjM1OiJmd3JpdGVccypcKFxzKlwkZmx3XHMqLFxzKlwkZmxccypcKSI7aToxODM7czozODoiXCRzeXNfcGFyYW1zXHMqPVxzKkAqZmlsZV9nZXRfY29udGVudHMiO2k6MTg0O3M6NTE6IlwkYWxsZW1haWxzXHMqPVxzKkBzcGxpdFwoIlxcbiJccyosXHMqXCRlbWFpbGxpc3RcKSI7aToxODU7czo1MDoiZmlsZV9wdXRfY29udGVudHNcKFNWQ19TRUxGXHMqXC5ccypbJyJdL1wuaHRhY2Nlc3MiO2k6MTg2O3M6NTc6ImNyZWF0ZV9mdW5jdGlvblwoWyciXVsnIl0sXHMqXCRvcHRcWzFcXVxzKlwuXHMqXCRvcHRcWzRcXSI7aToxODc7czo5NToiPHNjcmlwdFxzK3R5cGU9WyciXXswLDF9dGV4dC9qYXZhc2NyaXB0WyciXXswLDF9XHMrc3JjPVsnIl17MCwxfWpxdWVyeS11XC5qc1snIl17MCwxfT48L3NjcmlwdD4iO2k6MTg4O3M6Mjg6IlVSTD08XD9lY2hvXHMrXCRpbmRleDtccytcPz4iO2k6MTg5O3M6MjM6IlwjXHMqc2VjdXJpdHlzcGFjZVwuY29tIjtpOjE5MDtzOjE4OiJcI1xzKnN0ZWFsdGhccypib3QiO2k6MTkxO3M6MjE6IkFwcGxlXHMrU3BBbVxzK1JlWnVsVCI7aToxOTI7czo1MjoiaXNfd3JpdGFibGVcKFwkZGlyXC5bJyJdd3AtaW5jbHVkZXMvdmVyc2lvblwucGhwWyciXSI7aToxOTM7czo0MjoiaWZcKGVtcHR5XChcJF9DT09LSUVcW1snIl14WyciXVxdXClcKXtlY2hvIjtpOjE5NDtzOjI5OiJcKVxdO31pZlwoaXNzZXRcKFwkX1NFUlZFUlxbXyI7aToxOTU7czo2NjoiaWZcKEBcJHZhcnNcKGdldF9tYWdpY19xdW90ZXNfZ3BjXChcKVxzKlw/XHMqc3RyaXBzbGFzaGVzXChcJHVyaVwpIjtpOjE5NjtzOjMwOiJiYXNlWyciXXswLDF9XC5cKDMyXHMqXCpccyoyXCkiO2k6MTk3O3M6NzU6IlwkcGFyYW1ccyo9XHMqXCRwYXJhbVxzKnhccypcJG5cLnN1YnN0clxzKlwoXCRwYXJhbVxzKixccypsZW5ndGhcKFwkcGFyYW1cKSI7aToxOTg7czo1MzoicmVnaXN0ZXJfc2h1dGRvd25fZnVuY3Rpb25cKFxzKlsnIl17MCwxfXJlYWRfYW5zX2NvZGUiO2k6MTk5O3M6MzU6ImJhc2U2NF9kZWNvZGVcKFwkX1BPU1RcW1snIl17MCwxfV8tIjtpOjIwMDtzOjU0OiJpZlwoaXNzZXRcKFwkX1BPU1RcW1snIl17MCwxfW1zZ3N1YmplY3RbJyJdezAsMX1cXVwpXCkiO2k6MjAxO3M6MTMzOiJtYWlsXChcJGFyclxbWyciXXswLDF9dG9bJyJdezAsMX1cXSxcJGFyclxbWyciXXswLDF9c3VialsnIl17MCwxfVxdLFwkYXJyXFtbJyJdezAsMX1tc2dbJyJdezAsMX1cXSxcJGFyclxbWyciXXswLDF9aGVhZFsnIl17MCwxfVxdXCk7IjtpOjIwMjtzOjM4OiJmaWxlX2dldF9jb250ZW50c1wodHJpbVwoXCRmXFtcJF9HRVRcWyI7aToyMDM7czo2MDoiaW5pX2dldFwoWyciXXswLDF9ZmlsdGVyXC5kZWZhdWx0X2ZsYWdzWyciXXswLDF9XClcKXtmb3JlYWNoIjtpOjIwNDtzOjUwOiJjaHVua19zcGxpdFwoYmFzZTY0X2VuY29kZVwoZnJlYWRcKFwke1wke1snIl17MCwxfSI7aToyMDU7czo1MjoiXCRzdHI9WyciXXswLDF9PGgxPjQwM1xzK0ZvcmJpZGRlbjwvaDE+PCEtLVxzKnRva2VuOiI7aToyMDY7czozMzoiPFw/cGhwXHMrcmVuYW1lXChbJyJdd3NvXC5waHBbJyJdIjtpOjIwNztzOjY2OiJcJFthLXpBLVowLTlfXSs/L1wqLnsxLDEwfVwqL1xzKlwuXHMqXCRbYS16QS1aMC05X10rPy9cKi57MSwxMH1cKi8iO2k6MjA4O3M6NTE6IkAqbWFpbFwoXCRtb3NDb25maWdfbWFpbGZyb20sIFwkbW9zQ29uZmlnX2xpdmVfc2l0ZSI7aToyMDk7czo5NToiXCR0PVwkcztccypcJG9ccyo9XHMqWyciXVsnIl07XHMqZm9yXChcJGk9MDtcJGk8c3RybGVuXChcJHRcKTtcJGlcK1wrXCl7XHMqXCRvXHMqXC49XHMqXCR0e1wkaX0iO2k6MjEwO3M6NDc6Im1tY3J5cHRcKFwkZGF0YSwgXCRrZXksIFwkaXYsIFwkZGVjcnlwdCA9IEZBTFNFIjtpOjIxMTtzOjE1OiJ0bmVnYV9yZXN1X3B0dGgiO2k6MjEyO3M6OToidHNvaF9wdHRoIjtpOjIxMztzOjEyOiJSRVJFRkVSX1BUVEgiO2k6MjE0O3M6MzE6IndlYmlcLnJ1L3dlYmlfZmlsZXMvcGhwX2xpYm1haWwiO2k6MjE1O3M6NDA6InN1YnN0cl9jb3VudFwoZ2V0ZW52XChcXFsnIl1IVFRQX1JFRkVSRVIiO2k6MjE2O3M6Mzc6ImZ1bmN0aW9uIHJlbG9hZFwoXCl7aGVhZGVyXCgiTG9jYXRpb24iO2k6MjE3O3M6MjU6ImltZyBzcmM9WyciXW9wZXJhMDAwXC5wbmciO2k6MjE4O3M6NDY6ImVjaG9ccyptZDVcKFwkX1BPU1RcW1snIl17MCwxfWNoZWNrWyciXXswLDF9XF0iO2k6MjE5O3M6MzM6ImVWYUxcKFxzKnRyaW1cKFxzKmJhU2U2NF9kZUNvRGVcKCI7aToyMjA7czo0MjoiZnNvY2tvcGVuXChcJG1cWzBcXSxcJG1cWzEwXF0sXCRfLFwkX18sXCRtIjtpOjIyMTtzOjE5OiJbJyJdPT5cJHtcJHtbJyJdXFx4IjtpOjIyMjtzOjM4OiJwcmVnX3JlcGxhY2VcKFsnIl0uVVRGXFwtODpcKC5cKlwpLlVzZSI7aToyMjM7czozMDoiOjpbJyJdXC5waHB2ZXJzaW9uXChcKVwuWyciXTo6IjtpOjIyNDtzOjQwOiJAc3RyZWFtX3NvY2tldF9jbGllbnRcKFsnIl17MCwxfXRjcDovL1wkIjtpOjIyNTtzOjE4OiI9PTBcKXtqc29uUXVpdFwoXCQiO2k6MjI2O3M6NDY6ImxvY1xzKj1ccypbJyJdezAsMX08XD9lY2hvXHMrXCRyZWRpcmVjdDtccypcPz4iO2k6MjI3O3M6Mjg6ImFycmF5XChcJGVuLFwkZXMsXCRlZixcJGVsXCkiO2k6MjI4O3M6Mzc6IlsnIl17MCwxfS5jLlsnIl17MCwxfVwuc3Vic3RyXChcJHZiZywiO2k6MjI5O3M6MTg6ImZ1Y2tccyt5b3VyXHMrbWFtYSI7aToyMzA7czo3ODoiY2FsbF91c2VyX2Z1bmNcKFxzKlsnIl1hY3Rpb25bJyJdXHMqXC5ccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbIjtpOjIzMTtzOjU5OiJzdHJfcmVwbGFjZVwoXCRmaW5kXHMqLFxzKlwkZmluZFxzKlwuXHMqXCRodG1sXHMqLFxzKlwkdGV4dCI7aToyMzI7czozMzoiZmlsZV9leGlzdHNccypcKCpccypbJyJdL3Zhci90bXAvIjtpOjIzMztzOjQxOiImJlxzKiFlbXB0eVwoXHMqXCRfQ09PS0lFXFtbJyJdZmlsbFsnIl1cXSI7aToyMzQ7czoyMToiZnVuY3Rpb25ccytpbkRpYXBhc29uIjtpOjIzNTtzOjM1OiJtYWtlX2Rpcl9hbmRfZmlsZVwoXHMqXCRwYXRoX2pvb21sYSI7aToyMzY7czo0MToibGlzdGluZ19wYWdlXChccypub3RpY2VcKFxzKlsnIl1zeW1saW5rZWQiO2k6MjM3O3M6NjI6Imxpc3RccypcKFxzKlwkaG9zdFxzKixccypcJHBvcnRccyosXHMqXCRzaXplXHMqLFxzKlwkZXhlY190aW1lIjtpOjIzODtzOjUyOiJmaWxlbXRpbWVcKFwkYmFzZXBhdGhccypcLlxzKlsnIl0vY29uZmlndXJhdGlvblwucGhwIjtpOjIzOTtzOjU4OiJmdW5jdGlvblxzK3JlYWRfcGljXChccypcJEFccypcKVxzKntccypcJGFccyo9XHMqXCRfU0VSVkVSIjtpOjI0MDtzOjY0OiJjaHJcKFxzKlwkdGFibGVcW1xzKlwkc3RyaW5nXFtccypcJGlccypcXVxzKlwqXHMqcG93XCg2NFxzKixccyoxIjtpOjI0MTtzOjQwOiJcXVxzKlwpe2V2YWxcKFxzKlwkW2EtekEtWjAtOV9dKz9cW1xzKlwkIjtpOjI0MjtzOjU0OiJMb2NhdGlvbjo6aXNGaWxlV3JpdGFibGVcKFxzKkVuY29kZUV4cGxvcmVyOjpnZXRDb25maWciO2k6MjQzO3M6MTM6ImJ5XHMrU2h1bmNlbmciO2k6MjQ0O3M6MTQ6IntldmFsXChcJHtcJHMyIjtpOjI0NTtzOjE4OiJldmFsXChcJHMyMVwoXCR7XCQiO2k6MjQ2O3M6MjE6IlJhbVpraUVccystXHMrZXhwbG9pdCI7aToyNDc7czo0NzoiWyciXXJlbW92ZV9zY3JpcHRzWyciXVxzKj0+XHMqYXJyYXlcKFsnIl1SZW1vdmUiO2k6MjQ4O3M6Mjg6IlwkYmFja19jb25uZWN0X3BsXHMqPVxzKlsnIl0iO2k6MjQ5O3M6NDA6Ilwkc2l0ZV9yb290XC5cJGZpbGV1bnBfZGlyXC5cJGZpbGV1bnBfZm4iO2k6MjUwO3M6MjQ6IkBwcmVnX3JlcGxhY2VcKFsnIl0vYWQvZSI7aToyNTE7czoyNjoiPGI+XCR1aWRccypcKFwkdW5hbWVcKTwvYj4iO2k6MjUyO3M6MTE6IkZ4MjlHb29nbGVyIjtpOjI1MztzOjg6ImVudmlyMG5uIjtpOjI1NDtzOjQ2OiJhcnJheVwoWyciXVwqL1snIl0sWyciXS9cKlsnIl1cKSxiYXNlNjRfZGVjb2RlIjtpOjI1NTtzOjI4OiI8XD89XHMqQHBocF91bmFtZVwoXCk7XHMqXD8+IjtpOjI1NjtzOjExOiJzVXhDcmV3XHMrViI7aToyNTc7czoxNjoiV2FyQm90XHMrc1V4Q3JldyI7aToyNTg7czo0MzoiZXhlY1woWyciXWNkXHMrL3RtcDtjdXJsXHMrLU9ccytbJyJdXC5cJHVybCI7aToyNTk7czoxNToiQmF0YXZpNFxzK1NoZWxsIjtpOjI2MDtzOjM2OiJAZXh0cmFjdFwoXCRfUkVRVUVTVFxbWyciXWZ4MjlzaGNvb2siO2k6MjYxO3M6MTA6IlR1WF9TaGFkb3ciO2k6MjYyO3M6NDA6Ij1AZm9wZW5ccypcKFsnIl1waHBcLmluaVsnIl1ccyosXHMqWyciXXciO2k6MjYzO3M6OToiTGViYXlDcmV3IjtpOjI2NDtzOjc5OiJcJGhlYWRlcnNccypcLj1ccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbXHMqWyciXWVNYWlsQWRkWyciXVxzKlxdIjtpOjI2NTtzOjE5OiJib2dlbFxzKi1ccypleHBsb2l0IjtpOjI2NjtzOjU5OiJcW3VuYW1lXF1bJyJdXHMqXC5ccypwaHBfdW5hbWVcKFxzKlwpXHMqXC5ccypbJyJdXFsvdW5hbWVcXSI7aToyNjc7czozMjoiXF1cKFwkXzEsXCRfMVwpXCk7ZWxzZXtcJEdMT0JBTFMiO2k6MjY4O3M6MTQ6ImZpbGU6ZmlsZTovLy8vIjtpOjI2OTtzOjMyOiJmdW5jdGlvblxzK01DTG9naW5cKFwpXHMqe1xzKmRpZSI7aToyNzA7czo1NToie2VjaG8gWyciXXllc1snIl07IGV4aXQ7fWVsc2V7ZWNobyBbJyJdbm9bJyJdOyBleGl0O319fSI7aToyNzE7czozOToiO1w/PjxcPz1cJHtbJyJdX1snIl1cLlwkX31cW1snIl1fWyciXVxdIjtpOjI3MjtzOjQxOiJcJGFcWzFcXT09WyciXWJ5cGFzc2lwWyciXVwpO1wkYz1zZWxmOjpjMSI7aToyNzM7czo0MjoiXCRkaXJcLlsnIl0vWyciXVwuXCRmXC5bJyJdL3dwLWNvbmZpZ1wucGhwIjtpOjI3NDtzOjIzOiJldmFsXChbJyJdcmV0dXJuXHMrZXZhbCI7fQ=="));
$gX_FlexDBShe = unserialize(base64_decode("YTozMDA6e2k6MDtzOjQxOiJMb2NhdGlvbjpccypbYS16QS1aMC05X10rP1wuZG9jdW1lbnRcLmV4ZSI7aToxO3M6NDg6IlwkW2EtekEtWjAtOV9dKz9cW2NoclwoXGQrXClcXVwoW2EtekEtWjAtOV9dKz9cKCI7aToyO3M6NDA6ImlmXCghcHJlZ19tYXRjaFwoWyciXS9IYWNrZWQgYnkvaVsnIl0sXCQiO2k6MztzOjEwODoiXCRbYS16QS1aMC05X10rP1xbXCRbYS16QS1aMC05X10rP1xdPWNoclwoXCRbYS16QS1aMC05X10rP1xbb3JkXChcJFthLXpBLVowLTlfXSs/XFtcJFthLXpBLVowLTlfXSs/XF1cKVxdXCk7IjtpOjQ7czo5OiJCeVxzK0FtIXIiO2k6NTtzOjE5OiJDb250ZW50LVR5cGU6XHMqXCRfIjtpOjY7czo0MDoiZXZhbFxzKlwoKlxzKmd6aW5mbGF0ZVxzKlwoKlxzKnN0cl9yb3QxMyI7aTo3O3M6MTA5OiJpZlxzKlwoXHMqaXNfY2FsbGFibGVccypcKCpccypbJyJdezAsMX1cYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pWyciXXswLDF9XHMqXCkqIjtpOjg7czo1MDoiZXZhbFxzKlwoKlxzKkAqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVCkiO2k6OTtzOjUyOiJhc3NlcnRccypcKCpccypAKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjEwO3M6MTA2OiJcYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXHMqXCgqXHMqQCpcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxzKlxbIjtpOjExO3M6Mjk6ImV2YWxccypcKCpccypnZXRfb3B0aW9uXHMqXCgqIjtpOjEyO3M6OTU6ImFkZF9maWx0ZXJccypcKCpccypbJyJdezAsMX10aGVfY29udGVudFsnIl17MCwxfVxzKixccypbJyJdezAsMX1fYmxvZ2luZm9bJyJdezAsMX1ccyosXHMqLis/XCkqIjtpOjEzO3M6MzI6ImlzX3dyaXRhYmxlXHMqXCgqXHMqWyciXS92YXIvdG1wIjtpOjE0O3M6OTU6Imlzc2V0XChccypAKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtbJyJdW2EtekEtWjAtOV9dKz9bJyJdXF1cKVxzKm9yXHMqZGllXCgqLis/XCkqIjtpOjE1O3M6MTQ1OiJcJFthLXpBLVowLTlfXSs/XHMqXChccypcZCtccypcXlxzKlxkK1xzKlwpXHMqXC5ccypcJFthLXpBLVowLTlfXSs/XHMqXChccypcZCtccypcXlxzKlxkK1xzKlwpXHMqXC5ccypcJFthLXpBLVowLTlfXSs/XHMqXChccypcZCtccypcXlxzKlxkK1xzKlwpIjtpOjE2O3M6NDk6Imd6dW5jb21wcmVzc1xzKlwoKlxzKnN1YnN0clxzKlwoKlxzKmJhc2U2NF9kZWNvZGUiO2k6MTc7czo5OiJcJF9fX1xzKj0iO2k6MTg7czozMToiPVxzKmFycmF5X21hcFxzKlwoKlxzKnN0cnJldlxzKiI7aToxOTtzOjQwOiJpZlxzKlwoXHMqcHJlZ19tYXRjaFxzKlwoXHMqWyciXVwjeWFuZGV4IjtpOjIwO3M6MTc3OiI8Yj5ldmFsXHMqXChccypcYihldmFsfGJhc2U2NF9kZWNvZGV8c3RycmV2fHByZWdfcmVwbGFjZXxwcmVnX3JlcGxhY2VfY2FsbGJhY2t8dXJsZGVjb2RlfHN0cnN0cnxnemluZmxhdGV8c3ByaW50ZnxnenVuY29tcHJlc3N8YXNzZXJ0fHN0cl9yb3QxM3xtZDV8YXJyYXlfd2Fsa3xhcnJheV9maWx0ZXIpXHMqXCgiO2k6MjE7czo3MjoiXGIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVxzKlwoKlxzKlsnIl13Z2V0IjtpOjIyO3M6NzI6IkBzZXRjb29raWVcKFsnIl1tWyciXSxccypbJyJdW2EtekEtWjAtOV9dKz9bJyJdLFxzKnRpbWVcKFwpXHMqXCtccyo4NjQwMCI7aToyMztzOjI4OiJlY2hvXHMrWyciXW9cLmtcLlsnIl07XHMqXD8+IjtpOjI0O3M6MzM6InN5bWJpYW5cfG1pZHBcfHdhcFx8cGhvbmVcfHBvY2tldCI7aToyNTtzOjQ4OiJmdW5jdGlvblxzKmNobW9kX1JccypcKFxzKlwkcGF0aFxzKixccypcJHBlcm1ccyoiO2k6MjY7czozODoiZXZhbFxzKlwoXHMqZ3ppbmZsYXRlXHMqXChccypzdHJfcm90MTMiO2k6Mjc7czoyMToiZXZhbFxzKlwoXHMqc3RyX3JvdDEzIjtpOjI4O3M6MzA6InByZWdfcmVwbGFjZVxzKlwoXHMqWyciXS9cLlwqLyI7aToyOTtzOjU4OiJcJG1haWxlclxzKj1ccypcJF9QT1NUXFtccypbJyJdezAsMX14X21haWxlclsnIl17MCwxfVxzKlxdIjtpOjMwO3M6NTc6InByZWdfcmVwbGFjZVxzKlwoXHMqQCpcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKSI7aTozMTtzOjM1OiJlY2hvXHMrWyciXXswLDF9aW5zdGFsbF9va1snIl17MCwxfSI7aTozMjtzOjE2OiJTcGFtXHMrY29tcGxldGVkIjtpOjMzO3M6MjE6Ij09WyciXVwpXCk7cmV0dXJuO1w/PiI7aTozNDtzOjQ0OiJhcnJheVwoXHMqWyciXUdvb2dsZVsnIl1ccyosXHMqWyciXVNsdXJwWyciXSI7aTozNTtzOjIzOiIvdmFyL3FtYWlsL2Jpbi9zZW5kbWFpbCI7aTozNjtzOjMyOiI8aDE+NDAzIEZvcmJpZGRlbjwvaDE+PCEtLSB0b2tlbiI7aTozNztzOjIwOiIvZVsnIl1ccyosXHMqWyciXVxceCI7aTozODtzOjM1OiJwaHBfWyciXVwuXCRleHRcLlsnIl1cLmRsbFsnIl17MCwxfSI7aTozOTtzOjE3OiJteDJcLmhvdG1haWxcLmNvbSI7aTo0MDtzOjM2OiJwcmVnX3JlcGxhY2VcKFxzKlsnIl1lWyciXSxbJyJdezAsMX0iO2k6NDE7czo1MzoiZm9wZW5cKFsnIl17MCwxfVwuXC4vXC5cLi9cLlwuL1snIl17MCwxfVwuXCRmaWxlcGF0aHMiO2k6NDI7czo1MToiXCRkYXRhXHMqPVxzKmFycmF5XChbJyJdezAsMX10ZXJtaW5hbFsnIl17MCwxfVxzKj0+IjtpOjQzO3M6Mjk6IlwkYlxzKj1ccyptZDVfZmlsZVwoXCRmaWxlYlwpIjtpOjQ0O3M6MzM6InBvcnRsZXRzL2ZyYW1ld29yay9zZWN1cml0eS9sb2dpbiI7aTo0NTtzOjMxOiJcJGZpbGViXHMqPVxzKmZpbGVfZ2V0X2NvbnRlbnRzIjtpOjQ2O3M6MTA0OiJzaXRlX2Zyb209WyciXXswLDF9XC5cJF9TRVJWRVJcW1snIl17MCwxfUhUVFBfSE9TVFsnIl17MCwxfVxdXC5bJyJdezAsMX0mc2l0ZV9mb2xkZXI9WyciXXswLDF9XC5cJGZcWzFcXSI7aTo0NztzOjU2OiJ3aGlsZVwoY291bnRcKFwkbGluZXNcKT5cJGNvbF96YXBcKSBhcnJheV9wb3BcKFwkbGluZXNcKSI7aTo0ODtzOjg1OiJcJHN0cmluZ1xzKj1ccypcJF9TRVNTSU9OXFtbJyJdezAsMX1kYXRhX2FbJyJdezAsMX1cXVxbWyciXXswLDF9bnV0emVybmFtZVsnIl17MCwxfVxdIjtpOjQ5O3M6NDE6ImlmIFwoIXN0cnBvc1woXCRzdHJzXFswXF0sWyciXXswLDF9PFw/cGhwIjtpOjUwO3M6MjU6IlwkaXNldmFsZnVuY3Rpb25hdmFpbGFibGUiO2k6NTE7czoxNDoiRGF2aWRccytCbGFpbmUiO2k6NTI7czo0NzoiaWYgXChkYXRlXChbJyJdezAsMX1qWyciXXswLDF9XClccyotXHMqXCRuZXdzaWQiO2k6NTM7czo3OiJ1Z2djOi8vIjtpOjU0O3M6MTU6IjwhLS1ccytqcy10b29scyI7aTo1NTtzOjM0OiJpZlwoQHByZWdfbWF0Y2hcKHN0cnRyXChbJyJdezAsMX0vIjtpOjU2O3M6Mzc6Il9bJyJdezAsMX1cXVxbMlxdXChbJyJdezAsMX1Mb2NhdGlvbjoiO2k6NTc7czoyODoiXCRfUE9TVFxbWyciXXswLDF9c210cF9sb2dpbiI7aTo1ODtzOjI4OiJpZlxzKlwoQGlzX3dyaXRhYmxlXChcJGluZGV4IjtpOjU5O3M6ODY6IkBpbmlfc2V0XHMqXChbJyJdezAsMX1pbmNsdWRlX3BhdGhbJyJdezAsMX0sWyciXXswLDF9aW5pX2dldFxzKlwoWyciXXswLDF9aW5jbHVkZV9wYXRoIjtpOjYwO3M6Mzg6IlplbmRccytPcHRpbWl6YXRpb25ccyt2ZXJccysxXC4wXC4wXC4xIjtpOjYxO3M6NjI6IlwkX1NFU1NJT05cW1snIl17MCwxfWRhdGFfYVsnIl17MCwxfVxdXFtcJG5hbWVcXVxzKj1ccypcJHZhbHVlIjtpOjYyO3M6NDI6ImlmXHMqXChmdW5jdGlvbl9leGlzdHNcKFsnIl1zY2FuX2RpcmVjdG9yeSI7aTo2MztzOjY3OiJhcnJheVwoXHMqWyciXWhbJyJdXHMqLFxzKlsnIl10WyciXVxzKixccypbJyJddFsnIl1ccyosXHMqWyciXXBbJyJdIjtpOjY0O3M6MzU6IlwkY291bnRlclVybFxzKj1ccypbJyJdezAsMX1odHRwOi8vIjtpOjY1O3M6MTA4OiJmb3JcKFwkW2EtekEtWjAtOV9dKz89XGQrO1wkW2EtekEtWjAtOV9dKz88XGQrO1wkW2EtekEtWjAtOV9dKz8tPVxkK1wpe2lmXChcJFthLXpBLVowLTlfXSs/IT1cZCtcKVxzKmJyZWFrO30iO2k6NjY7czozNjoiaWZcKEBmdW5jdGlvbl9leGlzdHNcKFsnIl17MCwxfWZyZWFkIjtpOjY3O3M6MzM6Ilwkb3B0XHMqPVxzKlwkZmlsZVwoQCpcJF9DT09LSUVcWyI7aTo2ODtzOjM4OiJwcmVnX3JlcGxhY2VcKFwpe3JldHVyblxzK19fRlVOQ1RJT05fXyI7aTo2OTtzOjM5OiJpZlxzKlwoY2hlY2tfYWNjXChcJGxvZ2luLFwkcGFzcyxcJHNlcnYiO2k6NzA7czozNjoicHJpbnRccytbJyJdezAsMX1kbGVfbnVsbGVkWyciXXswLDF9IjtpOjcxO3M6NjM6ImlmXChtYWlsXChcJGVtYWlsXFtcJGlcXSxccypcJHN1YmplY3QsXHMqXCRtZXNzYWdlLFxzKlwkaGVhZGVycyI7aTo3MjtzOjEyOiJUZWFNXHMrTW9zVGEiO2k6NzM7czoxNDoiWyciXXswLDF9RFplMXIiO2k6NzQ7czoxNToicGFja1xzKyJTbkE0eDgiIjtpOjc1O3M6MzI6IlwkX1Bvc3RcW1snIl17MCwxfVNTTlsnIl17MCwxfVxdIjtpOjc2O3M6Mjc6IkV0aG5pY1xzK0FsYmFuaWFuXHMrSGFja2VycyI7aTo3NztzOjk6IkJ5XHMrRFoyNyI7aTo3ODtzOjc0OiJcYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChbJyJdezAsMX1jbWRcLmV4ZSI7aTo3OTtzOjEwNDoiXGIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVwoWyciXXswLDF9XCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcWyIiO2k6ODA7czoxNToiQXV0b1xzKlhwbG9pdGVyIjtpOjgxO3M6OToiYnlccytnMDBuIjtpOjgyO3M6Mjg6ImlmXChcJG88MTZcKXtcJGhcW1wkZVxbXCRvXF0iO2k6ODM7czo5NDoiaWZcKGlzX2RpclwoXCRwYXRoXC5bJyJdezAsMX0vd3AtY29udGVudFsnIl17MCwxfVwpXHMrQU5EXHMraXNfZGlyXChcJHBhdGhcLlsnIl17MCwxfS93cC1hZG1pbiI7aTo4NDtzOjYwOiJpZlxzKlwoXHMqZmlsZV9wdXRfY29udGVudHNccypcKFxzKlwkaW5kZXhfcGF0aFxzKixccypcJGNvZGUiO2k6ODU7czo1MToiQGFycmF5XChccypcKHN0cmluZ1wpXHMqc3RyaXBzbGFzaGVzXChccypcJF9SRVFVRVNUIjtpOjg2O3M6NDA6InN0cl9yZXBsYWNlXHMqXChccypbJyJdezAsMX0vcHVibGljX2h0bWwiO2k6ODc7czo0MToiaWZcKFxzKmlzc2V0XChccypcJF9SRVFVRVNUXFtbJyJdezAsMX1jaWQiO2k6ODg7czoxNToiY2F0YXRhblxzK3NpdHVzIjtpOjg5O3M6ODU6Ii9pbmRleFwucGhwXD9vcHRpb249Y29tX2pjZSZ0YXNrPXBsdWdpbiZwbHVnaW49aW1nbWFuYWdlciZmaWxlPWltZ21hbmFnZXImdmVyc2lvbj1cZCsiO2k6OTA7czozNzoic2V0Y29va2llXChccypcJHpcWzBcXVxzKixccypcJHpcWzFcXSI7aTo5MTtzOjMyOiJcJFNcW1wkaVwrXCtcXVwoXCRTXFtcJGlcK1wrXF1cKCI7aTo5MjtzOjMyOiJcW1wkb1xdXCk7XCRvXCtcK1wpe2lmXChcJG88MTZcKSI7aTo5MztzOjgxOiJ0eXBlb2ZccypcKGRsZV9hZG1pblwpXHMqPT1ccypbJyJdezAsMX11bmRlZmluZWRbJyJdezAsMX1ccypcfFx8XHMqZGxlX2FkbWluXHMqPT0iO2k6OTQ7czozNjoiY3JlYXRlX2Z1bmN0aW9uXChzdWJzdHJcKDIsMVwpLFwkc1wpIjtpOjk1O3M6NjA6InBsdWdpbnMvc2VhcmNoL3F1ZXJ5XC5waHBcP19fX19wZ2ZhPWh0dHAlM0ElMkYlMkZ3d3dcLmdvb2dsZSI7aTo5NjtzOjM2OiJyZXR1cm5ccytiYXNlNjRfZGVjb2RlXChcJGFcW1wkaVxdXCkiO2k6OTc7czo0NToiXCRmaWxlXChAKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjk4O3M6Mjc6ImN1cmxfaW5pdFwoXHMqYmFzZTY0X2RlY29kZSI7aTo5OTtzOjMyOiJldmFsXChbJyJdXD8+WyciXVwuYmFzZTY0X2RlY29kZSI7aToxMDA7czoyOToiWyciXVsnIl1ccypcLlxzKkJBc2U2NF9kZUNvRGUiO2k6MTAxO3M6Mjg6IlsnIl1bJyJdXHMqXC5ccypnelVuY29NcHJlU3MiO2k6MTAyO3M6MTk6ImdyZXBccystdlxzK2Nyb250YWIiO2k6MTAzO3M6MzQ6ImNyYzMyXChccypcJF9QT1NUXFtccypbJyJdezAsMX1jbWQiO2k6MTA0O3M6MTk6IlwkYmtleXdvcmRfYmV6PVsnIl0iO2k6MTA1O3M6NjA6ImZpbGVfZ2V0X2NvbnRlbnRzXChiYXNlbmFtZVwoXCRfU0VSVkVSXFtbJyJdezAsMX1TQ1JJUFRfTkFNRSI7aToxMDY7czo1NDoiXHMqWyciXXswLDF9cm9va2VlWyciXXswLDF9XHMqLFxzKlsnIl17MCwxfXdlYmVmZmVjdG9yIjtpOjEwNztzOjQ4OiJccypbJyJdezAsMX1zbHVycFsnIl17MCwxfVxzKixccypbJyJdezAsMX1tc25ib3QiO2k6MTA4O3M6MjA6ImV2YWxccypcKFxzKlRQTF9GSUxFIjtpOjEwOTtzOjgyOiJAKmFycmF5X2RpZmZfdWtleVwoXHMqQCphcnJheVwoXHMqXChzdHJpbmdcKVxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjExMDtzOjEwNToiXCRwYXRoXHMqPVxzKlwkX1NFUlZFUlxbXHMqWyciXXswLDF9RE9DVU1FTlRfUk9PVFsnIl17MCwxfVxzKlxdXHMqXC5ccypbJyJdezAsMX0vaW1hZ2VzL3N0b3JpZXMvWyciXXswLDF9IjtpOjExMTtzOjg5OiJcJHNhcGVfb3B0aW9uXFtccypbJyJdezAsMX1mZXRjaF9yZW1vdGVfdHlwZVsnIl17MCwxfVxzKlxdXHMqPVxzKlsnIl17MCwxfXNvY2tldFsnIl17MCwxfSI7aToxMTI7czo4ODoiZmlsZV9wdXRfY29udGVudHNcKFxzKlwkbmFtZVxzKixccypiYXNlNjRfZGVjb2RlXChccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKSI7aToxMTM7czo4MjoiZXJlZ19yZXBsYWNlXChbJyJdezAsMX0lNUMlMjJbJyJdezAsMX1ccyosXHMqWyciXXswLDF9JTIyWyciXXswLDF9XHMqLFxzKlwkbWVzc2FnZSI7aToxMTQ7czo4NToiXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl17MCwxfXVyWyciXXswLDF9XF1cKVwpXHMqXCRtb2RlXHMqXHw9XHMqMDQwMCI7aToxMTU7czo0MToiL3BsdWdpbnMvc2VhcmNoL3F1ZXJ5XC5waHBcP19fX19wZ2ZhPWh0dHAiO2k6MTE2O3M6NDk6IkAqZmlsZV9wdXRfY29udGVudHNcKFxzKlwkdGhpcy0+ZmlsZVxzKixccypzdHJyZXYiO2k6MTE3O3M6NDg6InByZWdfbWF0Y2hfYWxsXChccypbJyJdXHxcKFwuXCpcKTxcXCEtLSBqcy10b29scyI7aToxMTg7czozMDoiaGVhZGVyXChbJyJdezAsMX1yOlxzKm5vXHMrY29tIjtpOjExOTtzOjc1OiJcYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChbJyJdbHNccysvdmFyL21haWwiO2k6MTIwO3M6MjY6IlwkZG9yX2NvbnRlbnQ9cHJlZ19yZXBsYWNlIjtpOjEyMTtzOjIzOiJfX3VybF9nZXRfY29udGVudHNcKFwkbCI7aToxMjI7czo1NDoiXCRHTE9CQUxTXFtbJyJdezAsMX1bYS16QS1aMC05X10rP1snIl17MCwxfVxdXChccypOVUxMIjtpOjEyMztzOjYyOiJ1bmFtZVxdWyciXXswLDF9XHMqXC5ccypwaHBfdW5hbWVcKFwpXHMqXC5ccypbJyJdezAsMX1cWy91bmFtZSI7aToxMjQ7czozMzoiQFwkZnVuY1woXCRjZmlsZSwgXCRjZGlyXC5cJGNuYW1lIjtpOjEyNTtzOjM2OiJldmFsXChccypcJFthLXpBLVowLTlfXSs/XChccypcJDxhbWMiO2k6MTI2O3M6NzE6IlwkX1xbXHMqXGQrXHMqXF1cKFxzKlwkX1xbXHMqXGQrXHMqXF1cKFwkX1xbXHMqXGQrXHMqXF1cKFxzKlwkX1xbXHMqXGQrIjtpOjEyNztzOjI5OiJlcmVnaVwoXHMqc3FsX3JlZ2Nhc2VcKFxzKlwkXyI7aToxMjg7czo0MDoiXCNVc2VbJyJdezAsMX1ccyosXHMqZmlsZV9nZXRfY29udGVudHNcKCI7aToxMjk7czoyMDoibWtkaXJcKFxzKlsnIl0vaG9tZS8iO2k6MTMwO3M6MjA6ImZvcGVuXChccypbJyJdL2hvbWUvIjtpOjEzMTtzOjM2OiJcJHVzZXJfYWdlbnRfdG9fZmlsdGVyXHMqPVxzKmFycmF5XCgiO2k6MTMyO3M6NDQ6ImZpbGVfcHV0X2NvbnRlbnRzXChbJyJdezAsMX1cLi9saWJ3b3JrZXJcLnNvIjtpOjEzMztzOjY0OiJcIyEvYmluL3NobmNkXHMrWyciXXswLDF9WyciXXswLDF9XC5cJFNDUFwuWyciXXswLDF9WyciXXswLDF9bmlmIjtpOjEzNDtzOjgyOiJcYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChccypbJyJdezAsMX1hdFxzK25vd1xzKy1mIjtpOjEzNTtzOjMzOiJjcm9udGFiXHMrLWxcfGdyZXBccystdlxzK2Nyb250YWIiO2k6MTM2O3M6MTQ6IkRhdmlkXHMqQmxhaW5lIjtpOjEzNztzOjIzOiJleHBsb2l0LWRiXC5jb20vc2VhcmNoLyI7aToxMzg7czozNjoiZmlsZV9wdXRfY29udGVudHNcKFxzKlsnIl17MCwxfS9ob21lIjtpOjEzOTtzOjYwOiJtYWlsXChccypcJE1haWxUb1xzKixccypcJE1lc3NhZ2VTdWJqZWN0XHMqLFxzKlwkTWVzc2FnZUJvZHkiO2k6MTQwO3M6MTE3OiJcJGNvbnRlbnRccyo9XHMqaHR0cF9yZXF1ZXN0XChbJyJdezAsMX1odHRwOi8vWyciXXswLDF9XHMqXC5ccypcJF9TRVJWRVJcW1snIl17MCwxfVNFUlZFUl9OQU1FWyciXXswLDF9XF1cLlsnIl17MCwxfS8iO2k6MTQxO3M6Nzg6IiFmaWxlX3B1dF9jb250ZW50c1woXHMqXCRkYm5hbWVccyosXHMqXCR0aGlzLT5nZXRJbWFnZUVuY29kZWRUZXh0XChccypcJGRibmFtZSI7aToxNDI7czo0NDoic2NyaXB0c1xbXHMqZ3p1bmNvbXByZXNzXChccypiYXNlNjRfZGVjb2RlXCgiO2k6MTQzO3M6NzI6InNlbmRfc210cFwoXHMqXCRlbWFpbFxbWyciXXswLDF9YWRyWyciXXswLDF9XF1ccyosXHMqXCRzdWJqXHMqLFxzKlwkdGV4dCI7aToxNDQ7czo0NjoiPVwkZmlsZVwoQCpcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKSI7aToxNDU7czo1MjoidG91Y2hcKFxzKlsnIl17MCwxfVwkYmFzZXBhdGgvY29tcG9uZW50cy9jb21fY29udGVudCI7aToxNDY7czoyNzoiXChbJyJdXCR0bXBkaXIvc2Vzc19mY1wubG9nIjtpOjE0NztzOjM1OiJmaWxlX2V4aXN0c1woXHMqWyciXS90bXAvdG1wLXNlcnZlciI7aToxNDg7czo0OToibWFpbFwoXHMqXCRyZXRvcm5vXHMqLFxzKlwkYXN1bnRvXHMqLFxzKlwkbWVuc2FqZSI7aToxNDk7czo4MjoiXCRVUkxccyo9XHMqXCR1cmxzXFtccypyYW5kXChccyowXHMqLFxzKmNvdW50XChccypcJHVybHNccypcKVxzKi1ccyoxXClccypcXVwucmFuZCI7aToxNTA7czo0MDoiX19maWxlX2dldF91cmxfY29udGVudHNcKFxzKlwkcmVtb3RlX3VybCI7aToxNTE7czoxMzoiPWJ5XHMrRFJBR09OPSI7aToxNTI7czo5ODoic3Vic3RyXChccypcJHN0cmluZzJccyosXHMqc3RybGVuXChccypcJHN0cmluZzJccypcKVxzKi1ccyo5XHMqLFxzKjlcKVxzKj09XHMqWyciXXswLDF9XFtsLHI9MzAyXF0iO2k6MTUzO3M6MzM6IlxbXF1ccyo9XHMqWyciXVJld3JpdGVFbmdpbmVccytvbiI7aToxNTQ7czo3NToiZndyaXRlXChccypcJGZccyosXHMqZ2V0X2Rvd25sb2FkXChccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbIjtpOjE1NTtzOjQ3OiJ0YXJccystY3pmXHMrIlxzKlwuXHMqXCRGT1JNe3Rhcn1ccypcLlxzKiJcLnRhciI7aToxNTY7czoxMToic2NvcGJpblsnIl0iO2k6MTU3O3M6NjY6IjxkaXZccytpZD1bJyJdbGluazFbJyJdPjxidXR0b24gb25jbGljaz1bJyJdcHJvY2Vzc1RpbWVyXChcKTtbJyJdPiI7aToxNTg7czozNToiPGd1aWQ+PFw/cGhwXHMrZWNob1xzK1wkY3VycmVudF91cmwiO2k6MTU5O3M6NjI6ImludDMyXChcKFwoXCR6XHMqPj5ccyo1XHMqJlxzKjB4MDdmZmZmZmZcKVxzKlxeXHMqXCR5XHMqPDxccyoyIjtpOjE2MDtzOjQzOiJmb3BlblwoXHMqXCRyb290X2RpclxzKlwuXHMqWyciXS9cLmh0YWNjZXNzIjtpOjE2MTtzOjIzOiJcJGluX1Blcm1zXHMrJlxzKzB4NDAwMCI7aToxNjI7czozNDoiZmlsZV9nZXRfY29udGVudHNcKFxzKlsnIl0vdmFyL3RtcCI7aToxNjM7czo5OiIvcG10L3Jhdi8iO2k6MTY0O3M6NDk6ImZ3cml0ZVwoXCRmcFxzKixccypzdHJyZXZcKFxzKlwkY29udGV4dFxzKlwpXHMqXCkiO2k6MTY1O3M6MjA6Ik1hc3JpXHMrQ3liZXJccytUZWFtIjtpOjE2NjtzOjE4OiJVczNccytZMHVyXHMrYnI0MW4iO2k6MTY3O3M6MjA6Ik1hc3IxXHMrQ3liM3JccytUZTRtIjtpOjE2ODtzOjIwOiJ0SEFOS3Nccyt0T1xzK1Nub3BweSI7aToxNjk7czo2NjoiLFxzKlsnIl0vaW5kZXhcXFwuXChwaHBcfGh0bWxcKS9pWyciXVxzKixccypSZWN1cnNpdmVSZWdleEl0ZXJhdG9yIjtpOjE3MDtzOjQ3OiJmaWxlX3B1dF9jb250ZW50c1woXHMqXCRpbmRleF9wYXRoXHMqLFxzKlwkY29kZSI7aToxNzE7czo1NToiZ2V0cHJvdG9ieW5hbWVcKFxzKlsnIl10Y3BbJyJdXHMqXClccytcfFx8XHMrZGllXHMrc2hpdCI7aToxNzI7czo3ODoiXGIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVwoXHMqWyciXWNkXHMrL3RtcDt3Z2V0IjtpOjE3MztzOjIyOiI8YVxzK2hyZWY9WyciXW9zaGlia2EtIjtpOjE3NDtzOjg1OiJpZlwoXHMqXCRfR0VUXFtccypbJyJdaWRbJyJdXHMqXF0hPVxzKlsnIl1bJyJdXHMqXClccypcJGlkPVwkX0dFVFxbXHMqWyciXWlkWyciXVxzKlxdIjtpOjE3NTtzOjgzOiJpZlwoWyciXXN1YnN0cl9jb3VudFwoWyciXVwkX1NFUlZFUlxbWyciXVJFUVVFU1RfVVJJWyciXVxdXHMqLFxzKlsnIl1xdWVyeVwucGhwWyciXSI7aToxNzY7czozODoiXCRmaWxsID0gXCRfQ09PS0lFXFtcXFsnIl1maWxsXFxbJyJdXF0iO2k6MTc3O3M6NjI6IlwkcmVzdWx0PXNtYXJ0Q29weVwoXHMqXCRzb3VyY2VccypcLlxzKlsnIl0vWyciXVxzKlwuXHMqXCRmaWxlIjtpOjE3ODtzOjQwOiJcJGJhbm5lZElQXHMqPVxzKmFycmF5XChccypbJyJdXF42NlwuMTAyIjtpOjE3OTtzOjM1OiI8bG9jPjxcP3BocFxzK2VjaG9ccytcJGN1cnJlbnRfdXJsOyI7aToxODA7czoyODoiXCRzZXRjb29rXCk7c2V0Y29va2llXChcJHNldCI7aToxODE7czoyODoiXCk7ZnVuY3Rpb25ccytzdHJpbmdfY3B0XChcJCI7aToxODI7czo1MDoiWyciXVwuWyciXVsnIl1cLlsnIl1bJyJdXC5bJyJdWyciXVwuWyciXVsnIl1cLlsnIl0iO2k6MTgzO3M6NTM6ImlmXChwcmVnX21hdGNoXChbJyJdXCN3b3JkcHJlc3NfbG9nZ2VkX2luXHxhZG1pblx8cHdkIjtpOjE4NDtzOjQxOiJnX2RlbGV0ZV9vbl9leGl0XHMqPVxzKm5ld1xzK0RlbGV0ZU9uRXhpdCI7aToxODU7czozMDoiU0VMRUNUXHMrXCpccytGUk9NXHMrZG9yX3BhZ2VzIjtpOjE4NjtzOjE4OiJBY2FkZW1pY29ccytSZXN1bHQiO2k6MTg3O3M6Nzc6InZhbHVlPVsnIl08XD9ccytcYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChbJyJdIjtpOjE4ODtzOjI3OiJcZCsmQHByZWdfbWF0Y2hcKFxzKnN0cnRyXCgiO2k6MTg5O3M6Mzg6ImNoclwoXHMqaGV4ZGVjXChccypzdWJzdHJcKFxzKlwkbWFrZXVwIjtpOjE5MDtzOjMwOiJyZWFkX2ZpbGVfbmV3XzJcKFwkcmVzdWx0X3BhdGgiO2k6MTkxO3M6MjM6IlwkaW5kZXhfcGF0aFxzKixccyowNDA0IjtpOjE5MjtzOjY3OiJcJGZpbGVfZm9yX3RvdWNoXHMqPVxzKlwkX1NFUlZFUlxbWyciXXswLDF9RE9DVU1FTlRfUk9PVFsnIl17MCwxfVxdIjtpOjE5MztzOjYxOiJcJF9TRVJWRVJcW1snIl17MCwxfVJFTU9URV9BRERSWyciXXswLDF9XF07aWZcKFwocHJlZ19tYXRjaFwoIjtpOjE5NDtzOjE5OiI9PVxzKlsnIl1jc2hlbGxbJyJdIjtpOjE5NTtzOjI5OiJmaWxlX2V4aXN0c1woXHMqXCRGaWxlQmF6YVRYVCI7aToxOTY7czoxODoicmVzdWx0c2lnbl93YXJuaW5nIjtpOjE5NztzOjI0OiJmdW5jdGlvblxzK2dldGZpcnN0c2h0YWciO2k6MTk4O3M6OTA6ImZpbGVfZ2V0X2NvbnRlbnRzXChST09UX0RJUlwuWyciXS90ZW1wbGF0ZXMvWyciXVwuXCRjb25maWdcW1snIl1za2luWyciXVxdXC5bJyJdL21haW5cLnRwbCI7aToxOTk7czoyNToibmV3XHMrY29uZWN0QmFzZVwoWyciXWFIUiI7aToyMDA7czo4MzoiXCRpZFxzKlwuXHMqWyciXVw/ZD1bJyJdXHMqXC5ccypiYXNlNjRfZW5jb2RlXChccypcJF9TRVJWRVJcW1xzKlsnIl1IVFRQX1VTRVJfQUdFTlQiO2k6MjAxO3M6Mjk6ImRvX3dvcmtcKFxzKlwkaW5kZXhfZmlsZVxzKlwpIjtpOjIwMjtzOjIwOiJoZWFkZXJccypcKFxzKl9cZCtcKCI7aToyMDM7czoxMjoiQnlccytXZWJSb29UIjtpOjIwNDtzOjE2OiJDb2RlZFxzK2J5XHMrRVhFIjtpOjIwNTtzOjcxOiJ0cmltXChccypcJGhlYWRlcnNccypcKVxzKlwpXHMqYXNccypcJGhlYWRlclxzKlwpXHMqaGVhZGVyXChccypcJGhlYWRlciI7aToyMDY7czo1NjoiQFwkX1NFUlZFUlxbXHMqSFRUUF9IT1NUXHMqXF0+WyciXVxzKlwuXHMqWyciXVxcclxcblsnIl0iO2k6MjA3O3M6ODE6ImZpbGVfZ2V0X2NvbnRlbnRzXChccypcJF9TRVJWRVJcW1xzKlsnIl1ET0NVTUVOVF9ST09UWyciXVxzKlxdXHMqXC5ccypbJyJdL2VuZ2luZSI7aToyMDg7czo2OToidG91Y2hcKFxzKlwkX1NFUlZFUlxbXHMqWyciXURPQ1VNRU5UX1JPT1RbJyJdXHMqXF1ccypcLlxzKlsnIl0vZW5naW5lIjtpOjIwOTtzOjE2OiJQSFBTSEVMTF9WRVJTSU9OIjtpOjIxMDtzOjI2OiI8XD9ccyo9QGBcJFthLXpBLVowLTlfXSs/YCI7aToyMTE7czoyMToiJl9TRVNTSU9OXFtwYXlsb2FkXF09IjtpOjIxMjtzOjQ3OiJnenVuY29tcHJlc3NcKFxzKmZpbGVfZ2V0X2NvbnRlbnRzXChccypbJyJdaHR0cCI7aToyMTM7czo4NDoiaWZcKFxzKiFlbXB0eVwoXHMqXCRfUE9TVFxbXHMqWyciXXswLDF9dHAyWyciXXswLDF9XHMqXF1cKVxzKmFuZFxzKmlzc2V0XChccypcJF9QT1NUIjtpOjIxNDtzOjQ5OiJpZlwoXHMqdHJ1ZVxzKiZccypAcHJlZ19tYXRjaFwoXHMqc3RydHJcKFxzKlsnIl0vIjtpOjIxNTtzOjM4OiI9PVxzKjBcKVxzKntccyplY2hvXHMqUEhQX09TXHMqXC5ccypcJCI7aToyMTY7czoxMDc6Imlzc2V0XChccypcJF9TRVJWRVJcW1xzKl9cZCtcKFxzKlxkK1xzKlwpXHMqXF1ccypcKVxzKlw/XHMqXCRfU0VSVkVSXFtccypfXGQrXChcZCtcKVxzKlxdXHMqOlxzKl9cZCtcKFxkK1wpIjtpOjIxNztzOjk5OiJcJGluZGV4XHMqPVxzKnN0cl9yZXBsYWNlXChccypbJyJdPFw/cGhwXHMqb2JfZW5kX2ZsdXNoXChcKTtccypcPz5bJyJdXHMqLFxzKlsnIl1bJyJdXHMqLFxzKlwkaW5kZXgiO2k6MjE4O3M6MzM6Ilwkc3RhdHVzX2xvY19zaFxzKj1ccypmaWxlX2V4aXN0cyI7aToyMTk7czo0ODoiXCRQT1NUX1NUUlxzKj1ccypmaWxlX2dldF9jb250ZW50c1woInBocDovL2lucHV0IjtpOjIyMDtzOjQ4OiJnZVxzKj1ccypzdHJpcHNsYXNoZXNccypcKFxzKlwkX1BPU1RccypcW1snIl1tZXMiO2k6MjIxO3M6NjY6IlwkdGFibGVcW1wkc3RyaW5nXFtcJGlcXVxdXHMqXCpccypwb3dcKDY0XHMqLFxzKjJcKVxzKlwrXHMqXCR0YWJsZSI7aToyMjI7czozMzoiaWZcKFxzKnN0cmlwb3NcKFxzKlsnIl1cKlwqXCpcJHVhIjtpOjIyMztzOjQ5OiJmbHVzaF9lbmRfZmlsZVwoXHMqXCRmaWxlbmFtZVxzKixccypcJGZpbGVjb250ZW50IjtpOjIyNDtzOjU2OiJwcmVnX21hdGNoXChccypbJyJdezAsMX1+TG9jYXRpb246XChcLlwqXD9cKVwoXD86XFxuXHxcJCI7aToyMjU7czoyODoidG91Y2hcKFxzKlwkdGhpcy0+Y29uZi0+cm9vdCI7aToyMjY7czozNzoiZXZhbFwoXHMqXCR7XHMqXCRbYS16QS1aMC05X10rP1xzKn1cWyI7aToyMjc7czo0MzoiaWZccypcKFxzKkBmaWxldHlwZVwoXCRsZWFkb25ccypcLlxzKlwkZmlsZSI7aToyMjg7czo1OToiZmlsZV9wdXRfY29udGVudHNcKFxzKlwkZGlyXHMqXC5ccypcJGZpbGVccypcLlxzKlsnIl0vaW5kZXgiO2k6MjI5O3M6MjY6ImZpbGVzaXplXChccypcJHB1dF9rX2ZhaWx1IjtpOjIzMDtzOjYwOiJhZ2Vccyo9XHMqc3RyaXBzbGFzaGVzXHMqXChccypcJF9QT1NUXHMqXFtbJyJdezAsMX1tZXNbJyJdXF0iO2k6MjMxO3M6NDM6ImZ1bmN0aW9uXHMrZmluZEhlYWRlckxpbmVccypcKFxzKlwkdGVtcGxhdGUiO2k6MjMyO3M6NDM6Ilwkc3RhdHVzX2NyZWF0ZV9nbG9iX2ZpbGVccyo9XHMqY3JlYXRlX2ZpbGUiO2k6MjMzO3M6Mzg6ImVjaG9ccytzaG93X3F1ZXJ5X2Zvcm1cKFxzKlwkc3Fsc3RyaW5nIjtpOjIzNDtzOjM1OiI9PVxzKkZBTFNFXHMqXD9ccypcZCtccyo6XHMqaXAybG9uZyI7aToyMzU7czoyMjoiZnVuY3Rpb25ccyttYWlsZXJfc3BhbSI7aToyMzY7czozNDoiRWRpdEh0YWNjZXNzXChccypbJyJdUmV3cml0ZUVuZ2luZSI7aToyMzc7czoxMToiXCRwYXRoVG9Eb3IiO2k6MjM4O3M6NDA6IlwkY3VyX2NhdF9pZFxzKj1ccypcKFxzKmlzc2V0XChccypcJF9HRVQiO2k6MjM5O3M6OTk6IkBcJF9DT09LSUVcW1xzKlsnIl1bYS16QS1aMC05X10rP1snIl1ccypcXVwoXHMqQFwkX0NPT0tJRVxbXHMqWyciXVthLXpBLVowLTlfXSs/WyciXVxzKlxdXHMqXClccypcKSI7aToyNDA7czo0MDoiaGVhZGVyXChbJyJdTG9jYXRpb246XHMqaHR0cDovL1wkcHBcLm9yZyI7aToyNDE7czo0OToicmV0dXJuXHMrWyciXS9ob21lL1thLXpBLVowLTlfXSs/L1thLXpBLVowLTlfXSs/LyI7aToyNDI7czozOToiWyciXXdwLVsnIl1ccypcLlxzKmdlbmVyYXRlUmFuZG9tU3RyaW5nIjtpOjI0MztzOjY4OiJcJFthLXpBLVowLTlfXSs/PT1bJyJdZmVhdHVyZWRbJyJdXHMqXClccypcKXtccyplY2hvXHMrYmFzZTY0X2RlY29kZSI7aToyNDQ7czoxMDg6IlwkW2EtekEtWjAtOV9dKz9ccyo9XHMqXCRqcVxzKlwoXHMqQCpcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXXswLDF9W2EtekEtWjAtOV9dKz9bJyJdezAsMX1cXSI7aToyNDU7czoyMjoiZXhwbG9pdFxzKjo6XC48L3RpdGxlPiI7aToyNDY7czo0MToiXCRbYS16QS1aMC05X10rPz1zdHJfcmVwbGFjZVwoWyciXVwqYVwkXCoiO2k6MjQ3O3M6NjI6ImNoclwoXHMqXCRbYS16QS1aMC05X10rP1xzKlwpO1xzKn1ccypldmFsXChccypcJFthLXpBLVowLTlfXSs/IjtpOjI0ODtzOjQ4OiJpZlwoXHMqaXNJblN0cmluZzEqXChcJFthLXpBLVowLTlfXSs/LFsnIl1nb29nbGUiO2k6MjQ5O3M6OTM6IlwkcHBccyo9XHMqXCRwXFtcZCtcXVxzKlwuXHMqXCRwXFtcZCtcXVxzKlwuXHMqXCRwXFtcZCtcXVxzKlwuXHMqXCRwXFtcZCtcXVxzKlwuXHMqXCRwXFtcZCtcXSI7aToyNTA7czo0OToiZmlsZV9wdXRfY29udGVudHNcKERJUlwuWyciXS9bJyJdXC5bJyJdaW5kZXhcLnBocCI7aToyNTE7czoyOToiQGdldF9oZWFkZXJzXChccypcJGZ1bGxwYXRoXCkiO2k6MjUyO3M6MjE6IkBcJF9HRVRcW1snIl1wd1snIl1cXSI7aToyNTM7czoyNToianNvbl9lbmNvZGVcKGFsZXh1c01haWxlciI7aToyNTQ7czoxNjg6ImV2YWxcKFxzKlxiKGV2YWx8YmFzZTY0X2RlY29kZXxzdHJyZXZ8cHJlZ19yZXBsYWNlfHByZWdfcmVwbGFjZV9jYWxsYmFja3x1cmxkZWNvZGV8c3Ryc3RyfGd6aW5mbGF0ZXxzcHJpbnRmfGd6dW5jb21wcmVzc3xhc3NlcnR8c3RyX3JvdDEzfG1kNXxhcnJheV93YWxrfGFycmF5X2ZpbHRlcilcKCI7aToyNTU7czoxOToiPVsnIl1cKVwpO1snIl1cKVwpOyI7aToyNTY7czoxODE6Ij1ccypcJFthLXpBLVowLTlfXSs/XChcYihldmFsfGJhc2U2NF9kZWNvZGV8c3RycmV2fHByZWdfcmVwbGFjZXxwcmVnX3JlcGxhY2VfY2FsbGJhY2t8dXJsZGVjb2RlfHN0cnN0cnxnemluZmxhdGV8c3ByaW50ZnxnenVuY29tcHJlc3N8YXNzZXJ0fHN0cl9yb3QxM3xtZDV8YXJyYXlfd2Fsa3xhcnJheV9maWx0ZXIpXCgiO2k6MjU3O3M6NTU6IlxdXHMqfVxzKlwoXHMqe1xzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFsiO2k6MjU4O3M6Nzc6InJlcXVlc3RcLnNlcnZlcnZhcmlhYmxlc1woXHMqWyciXUhUVFBfVVNFUl9BR0VOVFsnIl1ccypcKVxzKixccypbJyJdR29vZ2xlYm90IjtpOjI1OTtzOjQ4OiJldmFsXChbJyJdXD8+WyciXVxzKlwuXHMqam9pblwoWyciXVsnIl0sZmlsZVwoXCQiO2k6MjYwO3M6Njg6InNldG9wdFwoXCRjaFxzKixccypDVVJMT1BUX1BPU1RGSUVMRFNccyosXHMqaHR0cF9idWlsZF9xdWVyeVwoXCRkYXRhIjtpOjI2MTtzOjExODoibXlzcWxfY29ubmVjdFwoXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl1bYS16QS1aMC05X10rP1snIl1cXVxzKixccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKSI7aToyNjI7czo2NDoicmVxdWVzdFwuc2VydmVydmFyaWFibGVzXChbJyJdSFRUUF9VU0VSX0FHRU5UWyciXVwpLFsnIl1haWR1WyciXSI7aToyNjM7czozNjoiXF1ccypcKVxzKlwpXHMqe1xzKmV2YWxccypcKFxzKlwke1wkIjtpOjI2NDtzOjE2OiJieVxzK0Vycm9yXHMrN3JCIjtpOjI2NTtzOjMzOiJAaXJjc2VydmVyc1xbcmFuZFxzK0BpcmNzZXJ2ZXJzXF0iO2k6MjY2O3M6NTk6InNldF90aW1lX2xpbWl0XChpbnR2YWxcKFwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjI2NztzOjI0OiJuaWNrXHMrWyciXWNoYW5zZXJ2WyciXTsiO2k6MjY4O3M6MjM6Ik1hZ2ljXHMrSW5jbHVkZVxzK1NoZWxsIjtpOjI2OTtzOjEwMToiXCRbYS16QS1aMC05X10rP1wpO1wkW2EtekEtWjAtOV9dKz89Y3JlYXRlX2Z1bmN0aW9uXChbJyJdWyciXSxcJFthLXpBLVowLTlfXSs/XCk7XCRbYS16QS1aMC05X10rP1woXCkiO2k6MjcwO3M6Mzg6ImN1cmxPcGVuXChcJHJlbW90ZV9wYXRoXC5cJHBhcmFtX3ZhbHVlIjtpOjI3MTtzOjQ3OiJmd3JpdGVcKFwkZnAsWyciXVxceEVGXFx4QkJcXHhCRlsnIl1cLlwkYm9keVwpOyI7aToyNzI7czoxMzg6IlwkW2EtekEtWjAtOV9dKz9cK1wrXClccyp7XHMqXCRbYS16QS1aMC05X10rP1xzKj1ccyphcnJheV91bmlxdWVcKGFycmF5X21lcmdlXChcJFthLXpBLVowLTlfXSs/XHMqLFxzKlthLXpBLVowLTlfXSs/XChbJyJdXCRbYS16QS1aMC05X10rPyI7aToyNzM7czo0MjoiYW5kXHMqXCghXHMqc3Ryc3RyXChcJHVhLFsnIl1ydjoxMVsnIl1cKVwpIjtpOjI3NDtzOjM1OiJlY2hvXHMrXCRva1xzK1w/XHMrWyciXVNIRUxMX09LWyciXSI7aToyNzU7czoyNzoiO2V2YWxcKFwkdG9kb2NvbnRlbnRcWzBcXVwpIjtpOjI3NjtzOjQwOiJvclxzK3N0cnRvbG93ZXJcKEBpbmlfZ2V0XChbJyJdc2FmZV9tb2RlIjtpOjI3NztzOjI5OiJpZlwoIWlzc2V0XChcJF9SRVFVRVNUXFtjaHJcKCI7aToyNzg7czo0NDoiXCRwcm9jZXNzb1xzKj1ccypcJHBzXFtyYW5kXHMrc2NhbGFyXHMrQHBzXF0iO2k6Mjc5O3M6MzI6ImVjaG9ccytbJyJddW5hbWVccystYTtccypcJHVuYW1lIjtpOjI4MDtzOjIxOiJcLnRjcGZsb29kXHMrPHRhcmdldD4iO2k6MjgxO3M6NTA6IlwkYm90XFtbJyJdc2VydmVyWyciXVxdPVwkc2VydmJhblxbcmFuZFwoMCxjb3VudFwoIjtpOjI4MjtzOjE2OiJcLjpccyt3MzNkXHMrOlwuIjtpOjI4MztzOjE2OiJCTEFDS1VOSVhccytDUkVXIjtpOjI4NDtzOjEyMzoiO1wkW2EtekEtWjAtOV9dKz9cW1wkW2EtekEtWjAtOV9dKz9cW1snIl1bYS16QS1aMC05X10rP1snIl1cXVxbXGQrXF1cLlwkW2EtekEtWjAtOV9dKz9cW1snIl1bYS16QS1aMC05X10rP1snIl1cXVxbXGQrXF1cLlwkIjtpOjI4NTtzOjMwOiJjYXNlXHMqWyciXWNyZWF0ZV9zeW1saW5rWyciXToiO2k6Mjg2O3M6OTg6IlwkW2EtekEtWjAtOV9dKz89YXJyYXlcKFsnIl1cJFthLXpBLVowLTlfXSs/XFtccypcXT1hcnJheV9wb3BcKFwkW2EtekEtWjAtOV9dKz9cKTtcJFthLXpBLVowLTlfXSs/IjtpOjI4NztzOjExMDoiXCRbYS16QS1aMC05X10rPz1wYWNrXChbJyJdSFwqWyciXSxzdWJzdHJcKFwkW2EtekEtWjAtOV9dKz8sXHMqLVxkK1wpXCk7XHMqcmV0dXJuXHMrXCRbYS16QS1aMC05X10rP1woc3Vic3RyXCgiO2k6Mjg4O3M6OTc6InNvY2tldF9jb25uZWN0XChcJFthLXpBLVowLTlfXSs/LFxzKlsnIl1nbWFpbC1zbXRwLWluXC5sXC5nb29nbGVcLmNvbVsnIl1ccyosXHMqMjVcKVxzKj09XHMqRkFMU0UiO2k6Mjg5O3M6MTQyOiJcJFthLXpBLVowLTlfXSs/XFtbJyJdezAsMX1bYS16QS1aMC05X10rP1snIl17MCwxfVxdXFtbJyJdezAsMX1bYS16QS1aMC05X10rP1snIl17MCwxfVxdXChcJFthLXpBLVowLTlfXSs/LFwkW2EtekEtWjAtOV9dKz8sXCRbYS16QS1aMC05X10rP1xbIjtpOjI5MDtzOjQ3OiJjYWxsX3VzZXJfZnVuY1woQHVuaGV4XCgweFthLXpBLVowLTlfXSs/XClcKFwkXyI7aToyOTE7czo2MzoiXCRfPUBcJF9SRVFVRVNUXFtbJyJdW2EtekEtWjAtOV9dKz9bJyJdXF1cKVwuQFwkX1woXCRfUkVRVUVTVFxbIjtpOjI5MjtzOjY2OiJcJEdMT0JBTFNcW1wkR0xPQkFMU1xbWyciXVthLXpBLVowLTlfXSs/WyciXVxdXFtcZCtcXVwuXCRHTE9CQUxTXFsiO2k6MjkzO3M6NjU6IlwuXCRbYS16QS1aMC05X10rP1xbXCRbYS16QS1aMC05X10rP1xdXC5bJyJde1snIl1cKVwpO307dW5zZXRcKFwkIjtpOjI5NDtzOjg2OiJodHRwX2J1aWxkX3F1ZXJ5XChcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVwpXC5bJyJdJmlwPVsnIl1ccypcLlxzKlwkX1NFUlZFUiI7aToyOTU7czo4MjoiXGIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVwoXHMqWyciXS9zYmluL2lmY29uZmlnWyciXSI7aToyOTY7czo4OToiPFw/cGhwXHMraWZccypcKGlzc2V0XHMqXChcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXWltYWdlc1snIl1cXVwpXClccyp7XCQiO2k6Mjk3O3M6MTc6Ijx0aXRsZT5HT1JET1xzKzIwIjtpOjI5ODtzOjE0MDoiY29weVwoXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl1bYS16QS1aMC05X10rP1snIl1cXVxzKixccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXVthLXpBLVowLTlfXSs/WyciXVxdXCkiO2k6Mjk5O3M6NzE6InNwcmludGZcKFthLXpBLVowLTlfXSs/XChcJFthLXpBLVowLTlfXSs/XHMqLFxzKlwkW2EtekEtWjAtOV9dKz9cKVxzKlwpIjt9"));
$gXX_FlexDBShe = unserialize(base64_decode("YTo0NDE6e2k6MDtzOjk6IlJvb3RTaGVsbCI7aToxO3M6MTQ6IkJPVE5FVFxzK1BBTkVMIjtpOjI7czoxNToiWyciXS9ldGMvcGFzc3dkIjtpOjM7czoxNToiWyciXS92YXIvY3BhbmVsIjtpOjQ7czoxNDoiWyciXS9ldGMvaHR0cGQiO2k6NTtzOjIwOiJbJyJdL2V0Yy9uYW1lZFwuY29uZiI7aTo2O3M6MTM6Ijg5XC4yNDlcLjIxXC4iO2k6NztzOjE1OiIxMDlcLjIzOFwuMjQyXC4iO2k6ODtzOjE4OiI9PVxzKlsnIl00NlwuMjI5XC4iO2k6OTtzOjE4OiI9PVxzKlsnIl05MVwuMjQzXC4iO2k6MTA7czo1OiJKVGVybSI7aToxMTtzOjU6Ik9uZXQ3IjtpOjEyO3M6OToiXCRwYXNzX3VwIjtpOjEzO3M6NToieENlZHoiO2k6MTQ7czoxMTY6ImlmXHMqXChccypmdW5jdGlvbl9leGlzdHNccypcKFxzKlsnIl17MCwxfVxiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilbJyJdezAsMX1ccypcKVxzKlwpIjtpOjE1O3M6OTE6IlxiKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKlwoKlxzKkAqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVCkiO2k6MTY7czo2NToiXGIoaW5jbHVkZXxpbmNsdWRlX29uY2V8cmVxdWlyZXxyZXF1aXJlX29uY2UpXHMqXCgqXHMqWyciXWltYWdlcy8iO2k6MTc7czo3MToiXGIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVxzKlwoQCp1cmxlbmNvZGUiO2k6MTg7czoyNzoiXCRPT08uKz89XHMqdXJsZGVjb2RlXHMqXCgqIjtpOjE5O3M6NzE6IlxiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilcKCpbJyJdY2RccysvdG1wIjtpOjIwO3M6Mzg6InN0cmVhbV9zb2NrZXRfY2xpZW50XHMqXChccypbJyJddGNwOi8vIjtpOjIxO3M6MTU6InBjbnRsX2V4ZWNccypcKCI7aToyMjtzOjMyOiJzdHJfaXJlcGxhY2VccypcKCpccypbJyJdPC9oZWFkPiI7aToyMztzOjMyNzoiXGIoZXZhbHxiYXNlNjRfZGVjb2RlfHN0cnJldnxwcmVnX3JlcGxhY2V8cHJlZ19yZXBsYWNlX2NhbGxiYWNrfHVybGRlY29kZXxzdHJzdHJ8Z3ppbmZsYXRlfHNwcmludGZ8Z3p1bmNvbXByZXNzfGFzc2VydHxzdHJfcm90MTN8bWQ1fGFycmF5X3dhbGt8YXJyYXlfZmlsdGVyKVxzKlwoXHMqXGIoZXZhbHxiYXNlNjRfZGVjb2RlfHN0cnJldnxwcmVnX3JlcGxhY2V8cHJlZ19yZXBsYWNlX2NhbGxiYWNrfHVybGRlY29kZXxzdHJzdHJ8Z3ppbmZsYXRlfHNwcmludGZ8Z3p1bmNvbXByZXNzfGFzc2VydHxzdHJfcm90MTN8bWQ1fGFycmF5X3dhbGt8YXJyYXlfZmlsdGVyKVxzKlwoIjtpOjI0O3M6MjM6ImNvcHlccypcKFxzKlsnIl1odHRwOi8vIjtpOjI1O3M6MTkwOiJtb3ZlX3VwbG9hZGVkX2ZpbGVccypcKCpccypcJF9GSUxFU1xbXHMqWyciXXswLDF9ZmlsZW5hbWVbJyJdezAsMX1ccypcXVxbXHMqWyciXXswLDF9dG1wX25hbWVbJyJdezAsMX1ccypcXVxzKixccypcJF9GSUxFU1xbXHMqWyciXXswLDF9ZmlsZW5hbWVbJyJdezAsMX1ccypcXVxbXHMqWyciXXswLDF9bmFtZVsnIl17MCwxfVxzKlxdIjtpOjI2O3M6Mjg6ImVjaG9ccypcKCpccypbJyJdTk8gRklMRVsnIl0iO2k6Mjc7czoxNToiWyciXS9cLlwqL2VbJyJdIjtpOjI4O3M6NDg3OiJcYihldmFsfGJhc2U2NF9kZWNvZGV8c3RycmV2fHByZWdfcmVwbGFjZXxwcmVnX3JlcGxhY2VfY2FsbGJhY2t8dXJsZGVjb2RlfHN0cnN0cnxnemluZmxhdGV8c3ByaW50ZnxnenVuY29tcHJlc3N8YXNzZXJ0fHN0cl9yb3QxM3xtZDV8YXJyYXlfd2Fsa3xhcnJheV9maWx0ZXIpXHMqXChccypcYihldmFsfGJhc2U2NF9kZWNvZGV8c3RycmV2fHByZWdfcmVwbGFjZXxwcmVnX3JlcGxhY2VfY2FsbGJhY2t8dXJsZGVjb2RlfHN0cnN0cnxnemluZmxhdGV8c3ByaW50ZnxnenVuY29tcHJlc3N8YXNzZXJ0fHN0cl9yb3QxM3xtZDV8YXJyYXlfd2Fsa3xhcnJheV9maWx0ZXIpXHMqXChccypcYihldmFsfGJhc2U2NF9kZWNvZGV8c3RycmV2fHByZWdfcmVwbGFjZXxwcmVnX3JlcGxhY2VfY2FsbGJhY2t8dXJsZGVjb2RlfHN0cnN0cnxnemluZmxhdGV8c3ByaW50ZnxnenVuY29tcHJlc3N8YXNzZXJ0fHN0cl9yb3QxM3xtZDV8YXJyYXlfd2Fsa3xhcnJheV9maWx0ZXIpIjtpOjI5O3M6NjQ6ImVjaG9ccytzdHJpcHNsYXNoZXNccypcKFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFsiO2k6MzA7czo2NDoiPVxzKlwkR0xPQkFMU1xbXHMqWyciXV8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVsnIl1ccypcXSI7aTozMTtzOjE1OiJcJGF1dGhfcGFzc1xzKj0iO2k6MzI7czoyOToiZWNob1xzK1snIl17MCwxfWdvb2RbJyJdezAsMX0iO2k6MzM7czoyMjoiZXZhbFxzKlwoXHMqZ2V0X29wdGlvbiI7aTozNDtzOjM1OiJcJFthLXpBLVowLTlfXSs/XHMqPVxzKlsnIl1ldmFsWyciXSI7aTozNTtzOjQ0OiJcJFthLXpBLVowLTlfXSs/XHMqPVxzKlsnIl1iYXNlNjRfZGVjb2RlWyciXSI7aTozNjtzOjQ2OiJcJFthLXpBLVowLTlfXSs/XHMqPVxzKlsnIl1jcmVhdGVfZnVuY3Rpb25bJyJdIjtpOjM3O3M6Mzc6IlwkW2EtekEtWjAtOV9dKz9ccyo9XHMqWyciXWFzc2VydFsnIl0iO2k6Mzg7czo0MzoiXCRbYS16QS1aMC05X10rP1xzKj1ccypbJyJdcHJlZ19yZXBsYWNlWyciXSI7aTozOTtzOjgwOiJXQlNfRElSXHMqXC5ccypbJyJdezAsMX10ZW1wL1snIl17MCwxfVxzKlwuXHMqXCRhY3RpdmVGaWxlXHMqXC5ccypbJyJdezAsMX1cLnRtcCI7aTo0MDtzOjg0OiJtb3ZlX3VwbG9hZGVkX2ZpbGVccypcKFxzKlwkX0ZJTEVTXFtbJyJdW2EtekEtWjAtOV9dKz9bJyJdXF1cW1snIl10bXBfbmFtZVsnIl1cXVxzKiwiO2k6NDE7czo4MToibWFpbFwoXCRfUE9TVFxbWyciXXswLDF9ZW1haWxbJyJdezAsMX1cXSxccypcJF9QT1NUXFtbJyJdezAsMX1zdWJqZWN0WyciXXswLDF9XF0sIjtpOjQyO3M6Nzc6Im1haWxccypcKFwkZW1haWxccyosXHMqWyciXXswLDF9PVw/VVRGLThcP0JcP1snIl17MCwxfVwuYmFzZTY0X2VuY29kZVwoXCRmcm9tIjtpOjQzO3M6NjQ6IlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXHMqXFtccypbYS16QS1aMC05X10rP1xzKlxdXCgiO2k6NDQ7czoxOToiWyciXS9cZCsvXFthLXpcXVwqZSI7aTo0NTtzOjM4OiJKUmVzcG9uc2U6OnNldEJvZHlccypcKFxzKnByZWdfcmVwbGFjZSI7aTo0NjtzOjU2OiJAKmZpbGVfcHV0X2NvbnRlbnRzXChcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKSI7aTo0NztzOjM2OiJYLU1haWxlcjpccypNaWNyb3NvZnQgT2ZmaWNlIE91dGxvb2siO2k6NDg7czo5MToibWFpbFwoXHMqc3RyaXBzbGFzaGVzXChcJHRvXClccyosXHMqc3RyaXBzbGFzaGVzXChcJHN1YmplY3RcKVxzKixccypzdHJpcHNsYXNoZXNcKFwkbWVzc2FnZSI7aTo0OTtzOjY2OiJcJFthLXpBLVowLTlfXSs/XHMqXChccypcJFthLXpBLVowLTlfXSs/XHMqXChccypcJFthLXpBLVowLTlfXSs/XCgiO2k6NTA7czoyMjI6IlwkW2EtekEtWjAtOV9dKz9cW1xzKlxkK1xzKlxdXHMqXC5ccypcJFthLXpBLVowLTlfXSs/XFtccypcZCtccypcXVxzKlwuXHMqXCRbYS16QS1aMC05X10rP1xbXHMqXGQrXHMqXF1ccypcLlxzKlwkW2EtekEtWjAtOV9dKz9cW1xzKlxkK1xzKlxdXHMqXC5ccypcJFthLXpBLVowLTlfXSs/XFtccypcZCtccypcXVxzKlwuXHMqXCRbYS16QS1aMC05X10rP1xbXHMqXGQrXHMqXF1ccypcLlxzKiI7aTo1MTtzOjE1NToiXCRbYS16QS1aMC05X10rP1xbXHMqXCRbYS16QS1aMC05X10rP1xzKlxdXFtccypcJFthLXpBLVowLTlfXSs/XFtccypcZCtccypcXVxzKlwuXHMqXCRbYS16QS1aMC05X10rP1xbXHMqXGQrXHMqXF1ccypcLlxzKlwkW2EtekEtWjAtOV9dKz9cW1xzKlxkK1xzKlxdXHMqXC4iO2k6NTI7czoyMzoiaXNfd3JpdGFibGU9aXNfd3JpdGFibGUiO2k6NTM7czozODoiQG1vdmVfdXBsb2FkZWRfZmlsZVwoXHMqXCR1c2VyZmlsZV90bXAiO2k6NTQ7czoyNjoiZXhpdFwoXCk6ZXhpdFwoXCk6ZXhpdFwoXCkiO2k6NTU7czo2NzoiXGIoaW5jbHVkZXxpbmNsdWRlX29uY2V8cmVxdWlyZXxyZXF1aXJlX29uY2UpXHMqXCgqXHMqWyciXS92YXIvdG1wLyI7aTo1NjtzOjE3OiI9XHMqWyciXS92YXIvdG1wLyI7aTo1NztzOjU5OiJcKFxzKlwkc2VuZFxzKixccypcJHN1YmplY3RccyosXHMqXCRtZXNzYWdlXHMqLFxzKlwkaGVhZGVycyI7aTo1ODtzOjQ1OiJcJFthLXpBLVowLTlfXSs/XHMqXChccypcJFthLXpBLVowLTlfXSs/XHMqXFsiO2k6NTk7czo2NjoiXCRbYS16QS1aMC05X10rP1xzKlwoXHMqXCRbYS16QS1aMC05X10rP1xzKlwoXHMqXCRbYS16QS1aMC05X10rP1xbIjtpOjYwO3M6NTI6IlwkW2EtekEtWjAtOV9dKz9ccypcKFxzKlwkW2EtekEtWjAtOV9dKz9ccypcKFxzKlsnIl0iO2k6NjE7czo3MzoiXCRbYS16QS1aMC05X10rP1xzKlwoXHMqXCRbYS16QS1aMC05X10rP1xzKlwoXHMqXCRbYS16QS1aMC05X10rP1xzKlwpXHMqLCI7aTo2MjtzOjcxOiJcJFthLXpBLVowLTlfXSs/XHMqXChccypbJyJdWyciXVxzKixccypldmFsXChcJFthLXpBLVowLTlfXSs/XHMqXClccypcKSI7aTo2MztzOjgzOiJcYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChbJyJdbHdwLWRvd25sb2FkXHMraHR0cDovLyI7aTo2NDtzOjEwMToic3RyX3JlcGxhY2VcKFsnIl0uWyciXVxzKixccypbJyJdLlsnIl1ccyosXHMqc3RyX3JlcGxhY2VcKFsnIl0uWyciXVxzKixccypbJyJdLlsnIl1ccyosXHMqc3RyX3JlcGxhY2UiO2k6NjU7czozNjoiL2FkbWluL2NvbmZpZ3VyYXRpb25cLnBocC9sb2dpblwucGhwIjtpOjY2O3M6NzE6InNlbGVjdFxzKmNvbmZpZ3VyYXRpb25faWQsXHMrY29uZmlndXJhdGlvbl90aXRsZSxccytjb25maWd1cmF0aW9uX3ZhbHVlIjtpOjY3O3M6NTA6InVwZGF0ZVxzKmNvbmZpZ3VyYXRpb25ccytzZXRccytjb25maWd1cmF0aW9uX3ZhbHVlIjtpOjY4O3M6Mzc6InNlbGVjdFxzKmxhbmd1YWdlc19pZCxccytuYW1lLFxzK2NvZGUiO2k6Njk7czo1MjoiY1wubGVuZ3RoXCk7fXJldHVyblxzKlxcWyciXVxcWyciXTt9aWZcKCFnZXRDb29raWVcKCI7aTo3MDtzOjUzOiJcJFthLXpBLVowLTlfXSs/ID0gXCRbYS16QS1aMC05X10rP1woWyciXXswLDF9aHR0cDovLyI7aTo3MTtzOjQ1OiJpZlwoZmlsZV9wdXRfY29udGVudHNcKFwkaW5kZXhfcGF0aCxccypcJGNvZGUiO2k6NzI7czozNjoiZXhlY1xzK3tbJyJdL2Jpbi9zaFsnIl19XHMrWyciXS1iYXNoIjtpOjczO3M6NTA6IjxpZnJhbWVccytzcmM9WyciXWh0dHBzOi8vZG9jc1wuZ29vZ2xlXC5jb20vZm9ybXMvIjtpOjc0O3M6MjI6IixbJyJdPFw/cGhwXFxuWyciXVwuXCQiO2k6NzU7czo3MjoiPFw/cGhwXHMrXGIoaW5jbHVkZXxpbmNsdWRlX29uY2V8cmVxdWlyZXxyZXF1aXJlX29uY2UpXHMqXChccypbJyJdL2hvbWUvIjtpOjc2O3M6MjI6InhydW1lcl9zcGFtX2xpbmtzXC50eHQiO2k6Nzc7czozMzoiQ29tZmlybVxzK1RyYW5zYWN0aW9uXHMrUGFzc3dvcmQ6IjtpOjc4O3M6Nzc6ImFycmF5X21lcmdlXChcJGV4dFxzKixccyphcnJheVwoWyciXXdlYnN0YXRbJyJdLFsnIl1hd3N0YXRzWyciXSxbJyJddGVtcG9yYXJ5IjtpOjc5O3M6OTI6IlxiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilcKFsnIl1teXNxbGR1bXBccystaFxzK2xvY2FsaG9zdFxzKy11IjtpOjgwO3M6Mjg6Ik1vdGhlclsnIl1zXHMrTWFpZGVuXHMrTmFtZToiO2k6ODE7czozOToibG9jYXRpb25cLnJlcGxhY2VcKFxcWyciXVwkdXJsX3JlZGlyZWN0IjtpOjgyO3M6MzY6ImNobW9kXChkaXJuYW1lXChfX0ZJTEVfX1wpLFxzKjA1MTFcKSI7aTo4MztzOjg1OiJcYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChbJyJdezAsMX1jdXJsXHMrLU9ccytodHRwOi8vIjtpOjg0O3M6Mjk6IlwpXCksUEhQX1ZFUlNJT04sbWQ1X2ZpbGVcKFwkIjtpOjg1O3M6Nzk6IlwkW2EtekEtWjAtOV9dKz9cW1wkW2EtekEtWjAtOV9dKz9cXVxbXCRbYS16QS1aMC05X10rP1xbXGQrXF1cLlwkW2EtekEtWjAtOV9dKz8iO2k6ODY7czozNDoiXCRxdWVyeVxzKyxccytbJyJdZnJvbSUyMGpvc191c2VycyI7aTo4NztzOjE1OiJldmFsXChbJyJdXHMqLy8iO2k6ODg7czoxNjoiZXZhbFwoWyciXVxzKi9cKiI7aTo4OTtzOjEwOToiXCRbYS16QS1aMC05X10rP1xzKj1cJFthLXpBLVowLTlfXSs/XHMqXChcJFthLXpBLVowLTlfXSs/XHMqLFxzKlwkW2EtekEtWjAtOV9dKz9ccypcKFsnIl1ccyp7XCRbYS16QS1aMC05X10rPyI7aTo5MDtzOjMxOiIhZXJlZ1woWyciXVxeXCh1bnNhZmVfcmF3XClcP1wkIjtpOjkxO3M6MzU6IlwkYmFzZV9kb21haW5ccyo9XHMqZ2V0X2Jhc2VfZG9tYWluIjtpOjkyO3M6OToic2V4c2V4c2V4IjtpOjkzO3M6MjM6IlwrdW5pb25cK3NlbGVjdFwrMCwwLDAsIjtpOjk0O3M6Mzc6ImNvbmNhdFwoMHgyMTdlLHBhc3N3b3JkLDB4M2EsdXNlcm5hbWUiO2k6OTU7czozNDoiZ3JvdXBfY29uY2F0XCgweDIxN2UscGFzc3dvcmQsMHgzYSI7aTo5NjtzOjU3OiJcKi9ccypcYihpbmNsdWRlfGluY2x1ZGVfb25jZXxyZXF1aXJlfHJlcXVpcmVfb25jZSlccyovXCoiO2k6OTc7czo4OiJhYmFrby9BTyI7aTo5ODtzOjQ4OiJpZlwoXHMqc3RycG9zXChccypcJHZhbHVlXHMqLFxzKlwkbWFza1xzKlwpXHMqXCkiO2k6OTk7czoxMDY6InVubGlua1woXHMqXCRfU0VSVkVSXFtccypbJyJdezAsMX1ET0NVTUVOVF9ST09UWyciXXswLDF9XF1ccypcLlxzKlsnIl17MCwxfS9hc3NldHMvY2FjaGUvdGVtcC9GaWxlU2V0dGluZ3MiO2k6MTAwO3M6MTQ0OiJcYihpbmNsdWRlfGluY2x1ZGVfb25jZXxyZXF1aXJlfHJlcXVpcmVfb25jZSlccypcKCpccypcJF9TRVJWRVJcW1snIl17MCwxfURPQ1VNRU5UX1JPT1RbJyJdezAsMX1cXVxzKlwuXHMqWyciXVtccyVcLkBcLVwrXChcKS9hLXpBLVowLTlfXSs/XC5qcGciO2k6MTAxO3M6MTQ0OiJcYihpbmNsdWRlfGluY2x1ZGVfb25jZXxyZXF1aXJlfHJlcXVpcmVfb25jZSlccypcKCpccypcJF9TRVJWRVJcW1snIl17MCwxfURPQ1VNRU5UX1JPT1RbJyJdezAsMX1cXVxzKlwuXHMqWyciXVtccyVcLkBcLVwrXChcKS9hLXpBLVowLTlfXSs/XC5naWYiO2k6MTAyO3M6MTQ0OiJcYihpbmNsdWRlfGluY2x1ZGVfb25jZXxyZXF1aXJlfHJlcXVpcmVfb25jZSlccypcKCpccypcJF9TRVJWRVJcW1snIl17MCwxfURPQ1VNRU5UX1JPT1RbJyJdezAsMX1cXVxzKlwuXHMqWyciXVtccyVcLkBcLVwrXChcKS9hLXpBLVowLTlfXSs/XC5wbmciO2k6MTAzO3M6MTIyOiJcYihpbmNsdWRlfGluY2x1ZGVfb25jZXxyZXF1aXJlfHJlcXVpcmVfb25jZSlccypcKCpccypbJyJdW1xzJVwuQFwtXCtcKFwpL2EtekEtWjAtOV9dKz8vW1xzJVwuQFwtXCtcKFwpL2EtekEtWjAtOV9dKz9cLnBuZyI7aToxMDQ7czoxMjI6IlxiKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKlwoKlxzKlsnIl1bXHMlXC5AXC1cK1woXCkvYS16QS1aMC05X10rPy9bXHMlXC5AXC1cK1woXCkvYS16QS1aMC05X10rP1wuanBnIjtpOjEwNTtzOjEyMjoiXGIoaW5jbHVkZXxpbmNsdWRlX29uY2V8cmVxdWlyZXxyZXF1aXJlX29uY2UpXHMqXCgqXHMqWyciXVtccyVcLkBcLVwrXChcKS9hLXpBLVowLTlfXSs/L1tccyVcLkBcLVwrXChcKS9hLXpBLVowLTlfXSs/XC5naWYiO2k6MTA2O3M6MTIyOiJcYihpbmNsdWRlfGluY2x1ZGVfb25jZXxyZXF1aXJlfHJlcXVpcmVfb25jZSlccypcKCpccypbJyJdW1xzJVwuQFwtXCtcKFwpL2EtekEtWjAtOV9dKz8vW1xzJVwuQFwtXCtcKFwpL2EtekEtWjAtOV9dKz9cLmljbyI7aToxMDc7czoxMDg6IlxiKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKlwoXHMqZGlybmFtZVwoXHMqX19GSUxFX19ccypcKVxzKlwuXHMqWyciXS93cC1jb250ZW50L3VwbG9hZCI7aToxMDg7czozODoic2V0VGltZW91dFwoXHMqWyciXWxvY2F0aW9uXC5yZXBsYWNlXCgiO2k6MTA5O3M6NDM6InN0cnBvc1woXCRpbVxzKixccypbJyJdPFw/WyciXVxzKixccypcJGlcKzEiO2k6MTEwO3M6MjA6IlwkX1JFUVVFU1RcW1snIl1sYWxhIjtpOjExMTtzOjIzOiIwXHMqXChccypnenVuY29tcHJlc3NcKCI7aToxMTI7czoxNToiZ3ppbmZsYXRlXChcKFwoIjtpOjExMztzOjQyOiJcJGtleVxzKj1ccypcJF9HRVRcW1snIl17MCwxfXFbJyJdezAsMX1cXTsiO2k6MTE0O3M6Mjc6InN0cmxlblwoXHMqXCRwYXRoVG9Eb3JccypcKSI7aToxMTU7czo2NDoiaXNzZXRcKFxzKlwkX0NPT0tJRVxbXHMqbWQ1XChccypcJF9TRVJWRVJcW1xzKlsnIl17MCwxfUhUVFBfSE9TVCI7aToxMTY7czoyNzoiQGNoZGlyXChccypcJF9QT1NUXFtccypbJyJdIjtpOjExNztzOjg0OiIvaW5kZXhcLnBocFw/b3B0aW9uPWNvbV9jb250ZW50JnZpZXc9YXJ0aWNsZSZpZD1bJyJdXC5cJHBvc3RcW1snIl17MCwxfWlkWyciXXswLDF9XF0iO2k6MTE4O3M6NTU6Ilwkb3V0XHMqXC49XHMqXCR0ZXh0e1xzKlwkaVxzKn1ccypcXlxzKlwka2V5e1xzKlwkalxzKn0iO2k6MTE5O3M6OToiTDNaaGNpOTNkIjtpOjEyMDtzOjQ3OiJzdHJ0b2xvd2VyXChccypzdWJzdHJcKFxzKlwkdXNlcl9hZ2VudFxzKixccyowLCI7aToxMjE7czo1MjoiY2htb2RcKFxzKlwkW1xzJVwuQFwtXCtcKFwpL2EtekEtWjAtOV9dKz9ccyosXHMqMDQwNCI7aToxMjI7czo1MjoiY2htb2RcKFxzKlwkW1xzJVwuQFwtXCtcKFwpL2EtekEtWjAtOV9dKz9ccyosXHMqMDc1NSI7aToxMjM7czo0MjoiQHVtYXNrXChccyowNzc3XHMqJlxzKn5ccypcJGZpbGVwZXJtaXNzaW9uIjtpOjEyNDtzOjIzOiJbJyJdXHMqXHxccyovYmluL3NoWyciXSI7aToxMjU7czoxNjoiO1xzKi9iaW4vc2hccyotaSI7aToxMjY7czo0MToiaWZccypcKGZ1bmN0aW9uX2V4aXN0c1woXHMqWyciXXBjbnRsX2ZvcmsiO2k6MTI3O3M6MjY6Ij1ccypbJyJdc2VuZG1haWxccyotdFxzKi1mIjtpOjEyODtzOjE1OiIvdG1wL3RtcC1zZXJ2ZXIiO2k6MTI5O3M6MTU6Ii90bXAvXC5JQ0UtdW5peCI7aToxMzA7czoyOToiZXhlY1woXHMqWyciXS9iaW4vc2hbJyJdXHMqXCkiO2k6MTMxO3M6Mjc6IlwuXC4vXC5cLi9cLlwuL1wuXC4vbW9kdWxlcyI7aToxMzI7czozMzoidG91Y2hccypcKFxzKmRpcm5hbWVcKFxzKl9fRklMRV9fIjtpOjEzMztzOjQ5OiJAdG91Y2hccypcKFxzKlwkY3VyZmlsZVxzKixccypcJHRpbWVccyosXHMqXCR0aW1lIjtpOjEzNDtzOjE4OiItXCotXHMqY29uZlxzKi1cKi0iO2k6MTM1O3M6NDQ6Im9wZW5ccypcKFxzKk1ZRklMRVxzKixccypbJyJdXHMqPlxzKnRhclwudG1wIjtpOjEzNjtzOjc0OiJcJHJldCA9IFwkdGhpcy0+X2RiLT51cGRhdGVPYmplY3RcKCBcJHRoaXMtPl90YmwsIFwkdGhpcywgXCR0aGlzLT5fdGJsX2tleSI7aToxMzc7czoxOToiZGllXChccypbJyJdbm8gY3VybCI7aToxMzg7czo1NDoic3Vic3RyXChccypcJHJlc3BvbnNlXHMqLFxzKlwkaW5mb1xbXHMqWyciXWhlYWRlcl9zaXplIjtpOjEzOTtzOjEwODoiaWZcKFxzKiFzb2NrZXRfc2VuZHRvXChccypcJHNvY2tldFxzKixccypcJGRhdGFccyosXHMqc3RybGVuXChccypcJGRhdGFccypcKVxzKixccyowXHMqLFxzKlwkaXBccyosXHMqXCRwb3J0IjtpOjE0MDtzOjUwOiI8aW5wdXRccyt0eXBlPXN1Ym1pdFxzK3ZhbHVlPVVwbG9hZFxzKi8+XHMqPC9mb3JtPiI7aToxNDE7czo1ODoicm91bmRccypcKFxzKlwoXHMqXCRwYWNrZXRzXHMqXCpccyo2NVwpXHMqL1xzKjEwMjRccyosXHMqMiI7aToxNDI7czo1NzoiQGVycm9yX3JlcG9ydGluZ1woXHMqMFxzKlwpO1xzKmlmXHMqXChccyohaXNzZXRccypcKFxzKlwkIjtpOjE0MztzOjMwOiJlbHNlXHMqe1xzKmVjaG9ccypbJyJdZmFpbFsnIl0iO2k6MTQ0O3M6NTE6InR5cGU9WyciXXN1Ym1pdFsnIl1ccyp2YWx1ZT1bJyJdVXBsb2FkIGZpbGVbJyJdXHMqPiI7aToxNDU7czozNzoiaGVhZGVyXChccypbJyJdTG9jYXRpb246XHMqXCRsaW5rWyciXSI7aToxNDY7czozMToiZWNob1xzKlsnIl08Yj5VcGxvYWQ8c3M+U3VjY2VzcyI7aToxNDc7czo0MzoibmFtZT1bJyJddXBsb2FkZXJbJyJdXHMraWQ9WyciXXVwbG9hZGVyWyciXSI7aToxNDg7czoyMToiLUkvdXNyL2xvY2FsL2JhbmRtYWluIjtpOjE0OTtzOjI0OiJ1bmxpbmtcKFxzKl9fRklMRV9fXHMqXCkiO2k6MTUwO3M6NTY6Im1haWxcKFxzKlwkYXJyXFtbJyJddG9bJyJdXF1ccyosXHMqXCRhcnJcW1snIl1zdWJqWyciXVxdIjtpOjE1MTtzOjEzMDoiaWZcKGlzc2V0XChcJF9SRVFVRVNUXFtbJyJdW2EtekEtWjAtOV9dKz9bJyJdXF1cKVwpXHMqe1xzKlwkW2EtekEtWjAtOV9dKz9ccyo9XHMqXCRfUkVRVUVTVFxbWyciXVthLXpBLVowLTlfXSs/WyciXVxdO1xzKmV4aXRcKFwpOyI7aToxNTI7czoxMzoibnVsbF9leHBsb2l0cyI7aToxNTM7czo0ODoiPFw/XHMqXCRbYS16QS1aMC05X10rP1woXHMqXCRbYS16QS1aMC05X10rP1xzKlwpIjtpOjE1NDtzOjk6InRtdmFzeW5nciI7aToxNTU7czoxMjoidG1oYXBiemNlcmZmIjtpOjE1NjtzOjEzOiJvbmZyNjRfcXJwYnFyIjtpOjE1NztzOjE0OiJbJyJdbmZmcmVnWyciXSI7aToxNTg7czo5OiJmZ2VfZWJnMTMiO2k6MTU5O3M6NzoiY3VjdmFzYiI7aToxNjA7czoxNDoiWyciXWZsZmdyelsnIl0iO2k6MTYxO3M6MTI6IlsnIl1yaW55WyciXSI7aToxNjI7czo5OiJldGFsZm5pemciO2k6MTYzO3M6MTI6InNzZXJwbW9jbnV6ZyI7aToxNjQ7czoxMzoiZWRvY2VkXzQ2ZXNhYiI7aToxNjU7czoxNDoiWyciXXRyZXNzYVsnIl0iO2k6MTY2O3M6MTc6IlsnIl0zMXRvcl9ydHNbJyJdIjtpOjE2NztzOjE1OiJbJyJdb2ZuaXBocFsnIl0iO2k6MTY4O3M6MTQ6IlsnIl1mbGZncnpbJyJdIjtpOjE2OTtzOjEyOiJbJyJdcmlueVsnIl0iO2k6MTcwO3M6NDQ6IkBcJFthLXpBLVowLTlfXSs/XChccypcJFthLXpBLVowLTlfXSs/XHMqXCk7IjtpOjE3MTtzOjQ4OiJwYXJzZV9xdWVyeV9zdHJpbmdcKFxzKlwkRU5We1xzKlsnIl1RVUVSWV9TVFJJTkciO2k6MTcyO3M6MzE6ImV2YWxccypcKFxzKm1iX2NvbnZlcnRfZW5jb2RpbmciO2k6MTczO3M6MjQ6IlwpXHMqe1xzKnBhc3N0aHJ1XChccypcJCI7aToxNzQ7czoxNToiSFRUUF9BQ0NFUFRfQVNFIjtpOjE3NTtzOjIxOiJmdW5jdGlvblxzKkN1cmxBdHRhY2siO2k6MTc2O3M6MTg6IkBzeXN0ZW1cKFxzKlsnIl1cJCI7aToxNzc7czoyMzoiZWNob1woXHMqaHRtbFwoXHMqYXJyYXkiO2k6MTc4O3M6NTY6IlwkY29kZT1bJyJdJTFzY3JpcHRccyp0eXBlPVxcWyciXXRleHQvamF2YXNjcmlwdFxcWyciXSUzIjtpOjE3OTtzOjIyOiJhcnJheVwoXHMqWyciXSUxaHRtbCUzIjtpOjE4MDtzOjE5OiJidWRha1xzKi1ccypleHBsb2l0IjtpOjE4MTtzOjkyOiJcYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXHMqXChccypbJyJdXCRbYS16QS1aMC05X10rP1snIl1ccypcKSI7aToxODI7czo5OiJHQUdBTDwvYj4iO2k6MTgzO3M6Mzg6ImV4aXRcKFsnIl08c2NyaXB0PmRvY3VtZW50XC5sb2NhdGlvblwuIjtpOjE4NDtzOjM3OiJkaWVcKFsnIl08c2NyaXB0PmRvY3VtZW50XC5sb2NhdGlvblwuIjtpOjE4NTtzOjM2OiJzZXRfdGltZV9saW1pdFwoXHMqaW50dmFsXChccypcJGFyZ3YiO2k6MTg2O3M6MzM6ImVjaG9ccypcJHByZXd1ZVwuXCRsb2dcLlwkcG9zdHd1ZSI7aToxODc7czo0MjoiY29ublxzKj1ccypodHRwbGliXC5IVFRQQ29ubmVjdGlvblwoXHMqdXJpIjtpOjE4ODtzOjM2OiJpZlxzKlwoXHMqXCRfUE9TVFxbWyciXXswLDF9Y2htb2Q3NzciO2k6MTg5O3M6MjY6IjxcP1xzKmVjaG9ccypcJGNvbnRlbnQ7XD8+IjtpOjE5MDtzOjg2OiJcJHVybFxzKlwuPVxzKlsnIl1cP1thLXpBLVowLTlfXSs/PVsnIl1ccypcLlxzKlwkX0dFVFxbXHMqWyciXVthLXpBLVowLTlfXSs/WyciXVxzKlxdOyI7aToxOTE7czoxMDk6ImNvcHlcKFxzKlwkX0ZJTEVTXFtccypbJyJdezAsMX1bYS16QS1aMC05X10rP1snIl17MCwxfVxzKlxdXFtccypbJyJdezAsMX10bXBfbmFtZVsnIl17MCwxfVxzKlxdXHMqLFxzKlwkX1BPU1QiO2k6MTkyO3M6MTE2OiJtb3ZlX3VwbG9hZGVkX2ZpbGVcKFxzKlwkX0ZJTEVTXFtccypbJyJdezAsMX1bYS16QS1aMC05X10rP1snIl17MCwxfVxzKlxdXFtbJyJdezAsMX10bXBfbmFtZVsnIl17MCwxfVxdXFtccypcJGlccypcXSI7aToxOTM7czozMjoiZG5zX2dldF9yZWNvcmRcKFxzKlwkZG9tYWluXHMqXC4iO2k6MTk0O3M6MzQ6ImZ1bmN0aW9uX2V4aXN0c1xzKlwoXHMqWyciXWdldG14cnIiO2k6MTk1O3M6MjQ6Im5zbG9va3VwXC5leGVccyotdHlwZT1NWCI7aToxOTY7czoxMjoibmV3XHMqTUN1cmw7IjtpOjE5NztzOjQ0OiJcJGZpbGVfZGF0YVxzKj1ccypbJyJdPHNjcmlwdFxzKnNyYz1bJyJdaHR0cCI7aToxOTg7czo0MDoiZnB1dHNcKFwkZnAsXHMqWyciXUlQOlxzKlwkaXBccyotXHMqREFURSI7aToxOTk7czoyODoiY2htb2RcKFxzKl9fRElSX19ccyosXHMqMDQwMCI7aToyMDA7czo0MDoiQ29kZU1pcnJvclwuZGVmaW5lTUlNRVwoXHMqWyciXXRleHQvbWlyYyI7aToyMDE7czo0MzoiXF1ccypcKVxzKlwuXHMqWyciXVxcblw/PlsnIl1ccypcKVxzKlwpXHMqeyI7aToyMDI7czo2NzoiXCRnenBccyo9XHMqXCRiZ3pFeGlzdFxzKlw/XHMqQGd6b3BlblwoXCR0bXBmaWxlLFxzKlsnIl1yYlsnIl1ccypcKSI7aToyMDM7czo3NToiZnVuY3Rpb248c3M+c210cF9tYWlsXChcJHRvXHMqLFxzKlwkc3ViamVjdFxzKixccypcJG1lc3NhZ2VccyosXHMqXCRoZWFkZXJzIjtpOjIwNDtzOjY0OiJcJF9QT1NUXFtbJyJdezAsMX1hY3Rpb25bJyJdezAsMX1cXVxzKj09XHMqWyciXWdldF9hbGxfbGlua3NbJyJdIjtpOjIwNTtzOjM4OiI9XHMqZ3ppbmZsYXRlXChccypiYXNlNjRfZGVjb2RlXChccypcJCI7aToyMDY7czo0MToiY2htb2RcKFwkZmlsZS0+Z2V0UGF0aG5hbWVcKFwpXHMqLFxzKjA3NzciO2k6MjA3O3M6NjM6IlwkX1BPU1RcW1snIl17MCwxfXRwMlsnIl17MCwxfVxdXHMqXClccyphbmRccyppc3NldFwoXHMqXCRfUE9TVCI7aToyMDg7czoyNDU6IlwkW2EtekEtWjAtOV9dKz9ccyo9XHMqXCRbYS16QS1aMC05X10rP1woWyciXVsnIl1ccyosXHMqXCRbYS16QS1aMC05X10rP1woXHMqXCRbYS16QS1aMC05X10rP1woXHMqWyciXVthLXpBLVowLTlfXSs/WyciXVxzKixccypbJyJdWyciXVxzKixccypcJFthLXpBLVowLTlfXSs/XHMqXC5ccypcJFthLXpBLVowLTlfXSs/XHMqXC5ccypcJFthLXpBLVowLTlfXSs/XHMqXC5ccypcJFthLXpBLVowLTlfXSs/XHMqXClccypcKVxzKlwpIjtpOjIwOTtzOjExMDoiaGVhZGVyXChccypbJyJdQ29udGVudC1UeXBlOlxzKmltYWdlL2pwZWdbJyJdXHMqXCk7XHMqcmVhZGZpbGVcKFxzKlsnIl1bYS16QS1aMC05X10rP1snIl1ccypcKTtccypleGl0XChccypcKTsiO2k6MjEwO3M6MzE6Ij0+XHMqQFwkZjJcKF9fRklMRV9fXHMqLFxzKlwkZjEiO2k6MjExO3M6ODQ6ImV2YWxcKFxzKlthLXpBLVowLTlfXSs/XChccypcJFthLXpBLVowLTlfXSs/XHMqLFxzKlwkW2EtekEtWjAtOV9dKz9ccypcKVxzKlwpO1xzKlw/PiI7aToyMTI7czozNzoiaWZccypcKFxzKmlzX2NyYXdsZXIxXChccypcKVxzKlwpXHMqeyI7aToyMTM7czo0ODoiXCRlY2hvXzFcLlwkZWNob18yXC5cJGVjaG9fM1wuXCRlY2hvXzRcLlwkZWNob181IjtpOjIxNDtzOjM1OiJmaWxlX2dldF9jb250ZW50c1woXHMqX19GSUxFX19ccypcKSI7aToyMTU7czo4MzoiQFxiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilcKFxzKkB1cmxlbmNvZGVcKFxzKlwkX1BPU1QiO2k6MjE2O3M6OTc6IlwkR0xPQkFMU1xbWyciXVthLXpBLVowLTlfXSs/WyciXVxdXFtcJEdMT0JBTFNcW1snIl1bYS16QS1aMC05X10rP1snIl1cXVxbXGQrXF1cKHJvdW5kXChcZCtcKVwpXF0iO2k6MjE3O3M6MjU6ImZ1bmN0aW9uXHMrZXJyb3JfNDA0XChcKXsiO2k6MjE4O3M6Njg6IlxiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilcKFxzKlsnIl1wZXJsIjtpOjIxOTtzOjcwOiJcYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChccypbJyJdcHl0aG9uIjtpOjIyMDtzOjc0OiJpZlxzKlwoaXNzZXRcKFwkX0dFVFxbWyciXVthLXpBLVowLTlfXSs/WyciXVxdXClcKVxzKntccyplY2hvXHMqWyciXW9rWyciXSI7aToyMjE7czozOToicmVscGF0aHRvYWJzcGF0aFwoXHMqXCRfR0VUXFtccypbJyJdY3B5IjtpOjIyMjtzOjQ2OiJodHRwOi8vLis/Ly4rP1wucGhwXD9hPVxkKyZjPVthLXpBLVowLTlfXSs/JnM9IjtpOjIyMztzOjE1MDoiXCRbYS16QS1aMC05X10rP1xzKj1ccypbJyJdXCRbYS16QS1aMC05X10rPz1AW2EtekEtWjAtOV9dKz9cKFsnIl0uKz9bJyJdXCk7W2EtekEtWjAtOV9dKz9cKCFcJFthLXpBLVowLTlfXSs/XCl7XCRbYS16QS1aMC05X10rPz1AW2EtekEtWjAtOV9dKz9cKFxzKlwpIjtpOjIyNDtzOjE2OiJmdW5jdGlvblxzK3dzb0V4IjtpOjIyNTtzOjUxOiJmb3JlYWNoXChccypcJHRvc1xzKmFzXHMqXCR0b1wpXHMqe1xzKm1haWxcKFxzKlwkdG8iO2k6MjI2O3M6MTAyOiJoZWFkZXJcKFxzKlsnIl1Db250ZW50LVR5cGU6XHMqaW1hZ2UvanBlZ1snIl1ccypcKTtccypyZWFkZmlsZVwoWyciXWh0dHA6Ly8uKz9cLmpwZ1snIl1cKTtccypleGl0XChcKTsiO2k6MjI3O3M6MTI6IjxcPz1cJGNsYXNzOyI7aToyMjg7czo1MDoiPGlucHV0XHMqdHlwZT0iZmlsZSJccypzaXplPSJcZCsiXHMqbmFtZT0idXBsb2FkIj4iO2k6MjI5O3M6MTEwOiJcJG1lc3NhZ2VzXFtcXVxzKj1ccypcJF9GSUxFU1xbXHMqWyciXXswLDF9dXNlcmZpbGVbJyJdezAsMX1ccypcXVxbXHMqWyciXXswLDF9bmFtZVsnIl17MCwxfVxzKlxdXFtccypcJGlccypcXSI7aToyMzA7czo1NToiPGlucHV0XHMqdHlwZT1bJyJdZmlsZVsnIl1ccypuYW1lPVsnIl11c2VyZmlsZVsnIl1ccyovPiI7aToyMzE7czoxMzoiRGV2YXJ0XHMrSFRUUCI7aToyMzI7czo5MDoiQFwke1xzKlthLXpBLVowLTlfXSs/XHMqfVwoXHMqWyciXVsnIl1ccyosXHMqXCR7XHMqW2EtekEtWjAtOV9dKz9ccyp9XChccypcJFthLXpBLVowLTlfXSs/IjtpOjIzMztzOjk1OiJcJEdMT0JBTFNcW1xzKlsnIl17MCwxfVthLXpBLVowLTlfXSs/WyciXXswLDF9XHMqXF1cKFxzKlwkW2EtekEtWjAtOV9dKz9cW1xzKlwkW2EtekEtWjAtOV9dKz9cXSI7aToyMzQ7czo1MzoiZXJyb3JfcmVwb3J0aW5nXChccyowXHMqXCk7XHMqXCR1cmxccyo9XHMqWyciXWh0dHA6Ly8iO2k6MjM1O3M6NjA6IlwkW2EtekEtWjAtOV9dKz9cW1xzKlxkK1xzKi5ccypcZCtccypcXVwoXHMqW2EtekEtWjAtOV9dKz9cKCI7aToyMzY7czoxMjQ6IlwkW2EtekEtWjAtOV9dKz89WyciXWh0dHA6Ly8uKz9bJyJdO1xzKlwkW2EtekEtWjAtOV9dKz89Zm9wZW5cKFwkW2EtekEtWjAtOV9dKz8sWyciXXJbJyJdXCk7XHMqcmVhZGZpbGVcKFwkW2EtekEtWjAtOV9dKz9cKTsiO2k6MjM3O3M6NzU6ImFycmF5XChccypbJyJdPCEtLVsnIl1ccypcLlxzKm1kNVwoXHMqXCRyZXF1ZXN0X3VybFxzKlwuXHMqcmFuZFwoXGQrLFxzKlxkKyI7aToyMzg7czoxNDoid3NvSGVhZGVyXHMqXCgiO2k6MjM5O3M6Njk6ImVjaG9cKFsnIl08Zm9ybSBtZXRob2Q9WyciXXBvc3RbJyJdXHMqZW5jdHlwZT1bJyJdbXVsdGlwYXJ0L2Zvcm0tZGF0YSI7aToyNDA7czo0MzoiZmlsZV9nZXRfY29udGVudHNcKFxzKmJhc2U2NF9kZWNvZGVcKFxzKlwkXyI7aToyNDE7czo1ODoicmVscGF0aHRvYWJzcGF0aFwoXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcWyI7aToyNDI7czo0MDoibWFpbFwoXCR0b1xzKixccypbJyJdLis/WyciXVxzKixccypcJHVybCI7aToyNDM7czo1MToiaWZccypcKFxzKiFmdW5jdGlvbl9leGlzdHNcKFxzKlsnIl1zeXNfZ2V0X3RlbXBfZGlyIjtpOjI0NDtzOjE3OiI8dGl0bGU+XHMqVmFSVmFSYSI7aToyNDU7czozODoiZWxzZWlmXChccypcJHNxbHR5cGVccyo9PVxzKlsnIl1zcWxpdGUiO2k6MjQ2O3M6MTk6Ij1bJyJdXClccypcKTtccypcPz4iO2k6MjQ3O3M6MjQ6ImVjaG9ccytiYXNlNjRfZGVjb2RlXChcJCI7aToyNDg7czo1MjoiXCNbYS16QS1aMC05X10rP1wjLis/PC9zY3JpcHQ+Lis/XCMvW2EtekEtWjAtOV9dKz9cIyI7aToyNDk7czozNDoiZnVuY3Rpb25ccytfX2ZpbGVfZ2V0X3VybF9jb250ZW50cyI7aToyNTA7czoyNToiZXZhbFwoXHMqXCRbYS16QS1aMC05X10rPyI7aToyNTE7czo1NToiXCRmXHMqPVxzKlwkZlxkK1woWyciXVsnIl1ccyosXHMqZXZhbFwoXCRbYS16QS1aMC05X10rPyI7aToyNTI7czozMjoiZXZhbFwoXCRjb250ZW50XCk7XHMqZWNob1xzKlsnIl0iO2k6MjUzO3M6Mjk6IkNVUkxPUFRfVVJMXHMqLFxzKlsnIl1zbXRwOi8vIjtpOjI1NDtzOjc3OiI8aGVhZD5ccyo8c2NyaXB0PlxzKndpbmRvd1wudG9wXC5sb2NhdGlvblwuaHJlZj1bJyJdLis/XHMqPC9zY3JpcHQ+XHMqPC9oZWFkPiI7aToyNTU7czo3MjoiXCRbYS16QS1aMC05X10rP1xzKj1ccypmb3BlblwoXHMqWyciXVthLXpBLVowLTlfXSs/XC5waHBbJyJdXHMqLFxzKlsnIl13IjtpOjI1NjtzOjE2OiJAYXNzZXJ0XChccypbJyJdIjtpOjI1NztzOjgzOiJcJFthLXpBLVowLTlfXSs/PVwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtccypbJyJdZG9bJyJdXHMqXF07XHMqaW5jbHVkZSI7aToyNTg7czo3OToiZWNob1xzK1wkW2EtekEtWjAtOV9dKz87bWtkaXJcKFxzKlsnIl1bYS16QS1aMC05X10rP1snIl1ccypcKTtmaWxlX3B1dF9jb250ZW50cyI7aToyNTk7czo2MToiXCRmcm9tXHMqPVxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtccypbJyJdZnJvbSI7aToyNjA7czoxOToiPVxzKnhkaXJcKFxzKlwkcGF0aCI7aToyNjE7czozMToiXCRfW2EtekEtWjAtOV9dKz9cKFxzKlwpO1xzKlw/PiI7aToyNjI7czoxMDoidGFyXHMrLXpjQyI7aToyNjM7czo4MzoiZWNob1xzK3N0cl9yZXBsYWNlXChccypbJyJdXFtQSFBfU0VMRlxdWyciXVxzKixccypiYXNlbmFtZVwoXCRfU0VSVkVSXFtbJyJdUEhQX1NFTEYiO2k6MjY0O3M6NDE6ImZ1bmN0aW9uX2V4aXN0c1woXHMqWyciXWZcJFthLXpBLVowLTlfXSs/IjtpOjI2NTtzOjQwOiJcJGN1cl9jYXRfaWRccyo9XHMqXChccyppc3NldFwoXHMqXCRfR0VUIjtpOjI2NjtzOjM1OiJocmVmPVsnIl08XD9waHBccytlY2hvXHMrXCRjdXJfcGF0aCI7aToyNjc7czozMzoiPVxzKmVzY191cmxcKFxzKnNpdGVfdXJsXChccypbJyJdIjtpOjI2ODtzOjg1OiJeXHMqPFw/cGhwXHMqaGVhZGVyXChccypbJyJdTG9jYXRpb246XHMqWyciXVxzKlwuXHMqWyciXVxzKmh0dHA6Ly8uKz9bJyJdXHMqXCk7XHMqXD8+IjtpOjI2OTtzOjE0OiI8dGl0bGU+XHMqaXZueiI7aToyNzA7czo2MzoiXlxzKjxcP3BocFxzKmhlYWRlclwoWyciXUxvY2F0aW9uOlxzKmh0dHA6Ly8uKz9bJyJdXHMqXCk7XHMqXD8+IjtpOjI3MTtzOjYxOiJnZXRfdXNlcnNcKFxzKmFycmF5XChccypbJyJdcm9sZVsnIl1ccyo9PlxzKlsnIl1hZG1pbmlzdHJhdG9yIjtpOjI3MjtzOjY1OiJcJHRvXHMqPVxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtccypbJyJddG9fYWRkcmVzcyI7aToyNzM7czoxOToiaW1hcF9oZWFkZXJpbmZvXChcJCI7aToyNzQ7czo1ODoiXCRbYS16QS1aMC05X10rP1xbXHMqX1thLXpBLVowLTlfXSs/XChccypcZCtccypcKVxzKlxdXHMqPSI7aToyNzU7czozNDoiZXZhbFwoXHMqWyciXVw/PlsnIl1ccypcLlxzKmpvaW5cKCI7aToyNzY7czozNToiYmVnaW5ccyttb2Q6XHMrVGhhbmtzXHMrZm9yXHMrcG9zdHMiO2k6Mjc3O3M6OTM6IlwkW2EtekEtWjAtOV9dKz89WyciXVthLXpBLVowLTlcK1w9X10rWyciXTtccyplY2hvXHMrYmFzZTY0X2RlY29kZVwoXCRbYS16QS1aMC05X10rP1wpO1xzKlw/PiI7aToyNzg7czo2MzoiXCRbYS16QS1aMC05X10rPy0+X3NjcmlwdHNcW1xzKmd6dW5jb21wcmVzc1woXHMqYmFzZTY0X2RlY29kZVwoIjtpOjI3OTtzOjMyOiJbJyJdXHMqXF5ccypcJFthLXpBLVowLTlfXSs/XHMqOyI7aToyODA7czo2ODoiXCRbYS16QS1aMC05X10rP1xzKlwuXHMqXCRbYS16QS1aMC05X10rP1xzKlxeXHMqXCRbYS16QS1aMC05X10rP1xzKjsiO2k6MjgxO3M6MTIyOiJpZlwoaXNzZXRcKFwkX1JFUVVFU1RcW1snIl1bYS16QS1aMC05X10rP1snIl1cXVwpXHMqJiZccyptZDVcKFwkX1JFUVVFU1RcW1snIl17MCwxfVthLXpBLVowLTlfXSs/WyciXXswLDF9XF1cKVxzKj09XHMqWyciXSI7aToyODI7czoxMjoiXC53d3cvLzpwdHRoIjtpOjI4MztzOjYzOiIlNjMlNzIlNjklNzAlNzQlMkUlNzMlNzIlNjMlM0QlMjclNjglNzQlNzQlNzAlM0ElMkYlMkYlNzMlNkYlNjEiO2k6Mjg0O3M6Mjc6IndwLW9wdGlvbnNcLnBocFxzKj5ccypFcnJvciI7aToyODU7czo4OToic3RyX3JlcGxhY2VcKGFycmF5XChbJyJdZmlsdGVyU3RhcnRbJyJdLFsnIl1maWx0ZXJFbmRbJyJdXCksXHMqYXJyYXlcKFsnIl1cKi9bJyJdLFsnIl0vXCoiO2k6Mjg2O3M6Mzc6ImZpbGVfZ2V0X2NvbnRlbnRzXChfX0ZJTEVfX1wpLFwkbWF0Y2giO2k6Mjg3O3M6MzA6InRvdWNoXChccypkaXJuYW1lXChccypfX0ZJTEVfXyI7aToyODg7czoxNToiWyciXVwpXClcKTsiXCk7IjtpOjI4OTtzOjIxOiJcfGJvdFx8c3BpZGVyXHx3Z2V0L2kiO2k6MjkwO3M6NjM6InN0cl9yZXBsYWNlXChbJyJdPC9ib2R5PlsnIl0sW2EtekEtWjAtOV9dKz9cLlsnIl08L2JvZHk+WyciXSxcJCI7aToyOTE7czozNDoiZXhwbG9kZVwoWyciXTt0ZXh0O1snIl0sXCRyb3dcWzBcXSI7aToyOTI7czo5MjoibWFpbFwoXHMqc3RyaXBzbGFzaGVzXChccypcJFthLXpBLVowLTlfXSs/XHMqXClccyosXHMqc3RyaXBzbGFzaGVzXChccypcJFthLXpBLVowLTlfXSs/XHMqXCkiO2k6MjkzO3M6MjExOiI9XHMqbWFpbFwoXHMqc3RyaXBzbGFzaGVzXChccypcJF9QT1NUXFtbJyJdezAsMX1bYS16QS1aMC05X10rP1snIl17MCwxfVxdXClccyosXHMqc3RyaXBzbGFzaGVzXChccypcJF9QT1NUXFtbJyJdezAsMX1bYS16QS1aMC05X10rP1snIl17MCwxfVxdXClccyosXHMqc3RyaXBzbGFzaGVzXChccypcJF9QT1NUXFtbJyJdezAsMX1bYS16QS1aMC05X10rP1snIl17MCwxfVxdIjtpOjI5NDtzOjE1NjoiPVxzKm1haWxcKFxzKlwkX1BPU1RcW1snIl17MCwxfVthLXpBLVowLTlfXSs/WyciXXswLDF9XF1ccyosXHMqXCRfUE9TVFxbWyciXXswLDF9W2EtekEtWjAtOV9dKz9bJyJdezAsMX1cXVxzKixccypcJF9QT1NUXFtbJyJdezAsMX1bYS16QS1aMC05X10rP1snIl17MCwxfVxdIjtpOjI5NTtzOjE0OiJMaWJYbWwySXNCdWdneSI7aToyOTY7czo5OiJtYWFmXHMreWEiO2k6Mjk3O3M6MzU6ImVjaG8gW2EtekEtWjAtOV9dKz9ccypcKFsnIl1odHRwOi8vIjtpOjI5ODtzOjQ4OiJcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXWFzc3VudG8iO2k6Mjk5O3M6MTI6ImBjaGVja3N1ZXhlYyI7aTozMDA7czoxODoid2hpY2hccytzdXBlcmZldGNoIjtpOjMwMTtzOjQ1OiJybWRpcnNcKFwkZGlyXHMqXC5ccypbJyJdL1snIl1ccypcLlxzKlwkY2hpbGQiO2k6MzAyO3M6NDI6ImV4cGxvZGVcKFxzKlxcWyciXTt0ZXh0O1xcWyciXVxzKixccypcJHJvdyI7aTozMDM7czozNzoiPVxzKlsnIl1waHBfdmFsdWVccythdXRvX3ByZXBlbmRfZmlsZSI7aTozMDQ7czozNToiaWZccypcKFxzKmlzX3dyaXRhYmxlXChccypcJHd3d1BhdGgiO2k6MzA1O3M6NDc6ImZvcGVuXChccypcJFthLXpBLVowLTlfXSs/XHMqXC5ccypbJyJdL3dwLWFkbWluIjtpOjMwNjtzOjIyOiJyZXR1cm5ccypbJyJdL3Zhci93d3cvIjtpOjMwNztzOjY3OiJcYihpbmNsdWRlfGluY2x1ZGVfb25jZXxyZXF1aXJlfHJlcXVpcmVfb25jZSlccypcKCpccypbJyJdL3Zhci93d3cvIjtpOjMwODtzOjY0OiJcYihpbmNsdWRlfGluY2x1ZGVfb25jZXxyZXF1aXJlfHJlcXVpcmVfb25jZSlccypcKCpccypbJyJdL2hvbWUvIjtpOjMwOTtzOjE5MjoiXCRbYS16QS1aMC05X10rP1xzKntccypcZCtccyp9XC5cJFthLXpBLVowLTlfXSs/XHMqe1xzKlxkK1xzKn1cLlwkW2EtekEtWjAtOV9dKz9ccyp7XHMqXGQrXHMqfVwuXCRbYS16QS1aMC05X10rP1xzKntccypcZCtccyp9XC5cJFthLXpBLVowLTlfXSs/XHMqe1xzKlxkK1xzKn1cLlwkW2EtekEtWjAtOV9dKz9ccyp7XHMqXGQrXHMqfVwuIjtpOjMxMDtzOjE2OiJ0YWdzL1wkNi9cJDQvXCQ3IjtpOjMxMTtzOjMwOiJzdHJfcmVwbGFjZVwoXHMqWyciXVwuaHRhY2Nlc3MiO2k6MzEyO3M6NDQ6ImZ1bmN0aW9uXHMrX1xkK1woXHMqXCRbYS16QS1aMC05X10rP1xzKlwpe1wkIjtpOjMxMztzOjIxOiJleHBsb2RlXChcXFsnIl07dGV4dDsiO2k6MzE0O3M6MTI2OiJzdWJzdHJcKFxzKlwkW2EtekEtWjAtOV9dKz9ccyosXHMqXGQrXHMqLFxzKlxkK1xzKlwpO1xzKlwkW2EtekEtWjAtOV9dKz9ccyo9XHMqcHJlZ19yZXBsYWNlXChccypcJFthLXpBLVowLTlfXSs/XHMqLFxzKnN0cnRyXCgiO2k6MzE1O3M6NjY6ImFycmF5X2ZsaXBcKFxzKmFycmF5X21lcmdlXChccypyYW5nZVwoXHMqWyciXUFbJyJdXHMqLFxzKlsnIl1aWyciXSI7aTozMTY7czo2MzoiXCRfU0VSVkVSXFtccypbJyJdRE9DVU1FTlRfUk9PVFsnIl1ccypcXVxzKlwuXHMqWyciXS9cLmh0YWNjZXNzIjtpOjMxNztzOjMxOiJcJGluc2VydF9jb2RlXHMqPVxzKlsnIl08aWZyYW1lIjtpOjMxODtzOjQxOiJhc3NlcnRfb3B0aW9uc1woXHMqQVNTRVJUX1dBUk5JTkdccyosXHMqMCI7aTozMTk7czoxNToiTXVzdEBmQFxzK1NoZWxsIjtpOjMyMDtzOjY3OiJldmFsXChccypcJFthLXpBLVowLTlfXSs/XChccypcJFthLXpBLVowLTlfXSs/XChccypcJFthLXpBLVowLTlfXSs/IjtpOjMyMTtzOjM0OiJmdW5jdGlvbl9leGlzdHNcKFxzKlsnIl1wY250bF9mb3JrIjtpOjMyMjtzOjQwOiJzdHJfcmVwbGFjZVwoWyciXVwuaHRhY2Nlc3NbJyJdXHMqLFxzKlwkIjtpOjMyMztzOjMzOiI9XHMqQCpnemluZmxhdGVcKFxzKnN0cnJldlwoXHMqXCQiO2k6MzI0O3M6NTc6IlwkW2EtekEtWjAtOV9dKz89WyciXS9ob21lL1thLXpBLVowLTlfXSs/L1thLXpBLVowLTlfXSs/LyI7aTozMjU7czoyMjoiZ1woXHMqWyciXUZpbGVzTWFuWyciXSI7aTozMjY7czoxMTc6IlwkW2EtekEtWjAtOV9dKz9cW1xzKlxkK1xzKlxdXChccypbJyJdWyciXVxzKixccypcJFthLXpBLVowLTlfXSs/XFtccypcZCtccypcXVwoXHMqXCRbYS16QS1aMC05X10rP1xbXHMqXGQrXHMqXF1ccypcKSI7aTozMjc7czozMzoiXCRbYS16QS1aMC05X10rP1woXHMqQFwkX0NPT0tJRVxbIjtpOjMyODtzOjI4OiJzdHJfcmVwbGFjZVwoWyciXS9cP2FuZHJbJyJdIjtpOjMyOTtzOjIwOToiXCRbYS16QS1aMC05X10rP1xzKj1ccypcJF9SRVFVRVNUXFtbJyJdezAsMX1bYS16QS1aMC05X10rP1snIl17MCwxfVxdO1xzKlwkW2EtekEtWjAtOV9dKz9ccyo9XHMqYXJyYXlcKFxzKlwkX1JFUVVFU1RcW1xzKlsnIl17MCwxfVthLXpBLVowLTlfXSs/WyciXXswLDF9XHMqXF1ccypcKTtccypcJFthLXpBLVowLTlfXSs/XHMqPVxzKmFycmF5X2ZpbHRlclwoXHMqXCQiO2k6MzMwO3M6MTMzOiJcJFthLXpBLVowLTlfXSs/XHMqXC49XHMqXCRbYS16QS1aMC05X10rP3tcZCt9XHMqXC5ccypcJFthLXpBLVowLTlfXSs/e1xkK31ccypcLlxzKlwkW2EtekEtWjAtOV9dKz97XGQrfVxzKlwuXHMqXCRbYS16QS1aMC05X10rP3tcZCt9IjtpOjMzMTtzOjc0OiJzdHJwb3NcKFwkbCxbJyJdTG9jYXRpb25bJyJdXCkhPT1mYWxzZVx8XHxzdHJwb3NcKFwkbCxbJyJdU2V0LUNvb2tpZVsnIl1cKSI7aTozMzI7czo5NzoiYWRtaW4vWyciXSxbJyJdYWRtaW5pc3RyYXRvci9bJyJdLFsnIl1hZG1pbjEvWyciXSxbJyJdYWRtaW4yL1snIl0sWyciXWFkbWluMy9bJyJdLFsnIl1hZG1pbjQvWyciXSI7aTozMzM7czoxNToiWyciXWNoZWNrc3VleGVjIjtpOjMzNDtzOjU1OiJpZlxzKlwoXHMqXCR0aGlzLT5pdGVtLT5oaXRzXHMqPj1bJyJdXGQrWyciXVwpXHMqe1xzKlwkIjtpOjMzNTtzOjQ3OiJleHBsb2RlXChbJyJdXFxuWyciXSxccypcJF9QT1NUXFtbJyJddXJsc1snIl1cXSI7aTozMzY7czoxMTY6ImlmXChpbmlfZ2V0XChbJyJdYWxsb3dfdXJsX2ZvcGVuWyciXVwpXHMqPT1ccyoxXClccyp7XHMqXCRbYS16QS1aMC05X10rP1xzKj1ccypmaWxlX2dldF9jb250ZW50c1woXCRbYS16QS1aMC05X10rP1wpIjtpOjMzNztzOjEyMjoiaWZcKFxzKlwkZnBccyo9XHMqZnNvY2tvcGVuXChcJHVcW1snIl1ob3N0WyciXVxdLCFlbXB0eVwoXCR1XFtbJyJdcG9ydFsnIl1cXVwpXHMqXD9ccypcJHVcW1snIl1wb3J0WyciXVxdXHMqOlxzKjgwXHMqXClcKXsiO2k6MzM4O3M6ODM6ImluY2x1ZGVcKFxzKlsnIl1kYXRhOnRleHQvcGxhaW47YmFzZTY0XHMqLFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFs7IjtpOjMzOTtzOjIxOiJpbmNsdWRlXChccypbJyJdemxpYjoiO2k6MzQwO3M6MjE6ImluY2x1ZGVcKFxzKlsnIl0vdG1wLyI7aTozNDE7czo3MDoiXCRkb2Nccyo9XHMqSkZhY3Rvcnk6OmdldERvY3VtZW50XChcKTtccypcJGRvYy0+YWRkU2NyaXB0XChbJyJdaHR0cDovLyI7aTozNDI7czozMDoiXCRkZWZhdWx0X3VzZV9hamF4XHMqPVxzKnRydWU7IjtpOjM0MztzOjEwOiJkZWtjYWhbJyJdIjtpOjM0NDtzOjIzOiJzdWJzdHJcKG1kNVwoc3RycmV2XChcJCI7aTozNDU7czoxMzoiPT1bJyJdXClccypcLiI7aTozNDY7czoxMDU6ImlmXHMqXChccypcKFxzKlwkW2EtekEtWjAtOV9dKz9ccyo9XHMqc3RycnBvc1woXCRbYS16QS1aMC05X10rP1xzKixccypbJyJdXD8+WyciXVxzKlwpXHMqXClccyo9PT1ccypmYWxzZSI7aTozNDc7czoxNTY6IlwkX1NFUlZFUlxbWyciXURPQ1VNRU5UX1JPT1RbJyJdXHMqXC5ccypbJyJdL1snIl1ccypcLlxzKlwkW2EtekEtWjAtOV9dKz9ccypcLlxzKlsnIl0vWyciXVxzKlwuXHMqXCRbYS16QS1aMC05X10rP1xzKlwuXHMqWyciXS9bJyJdXHMqXC5ccypcJFthLXpBLVowLTlfXSs/LCI7aTozNDg7czozMDoiZm9wZW5ccypcKFxzKlsnIl1iYWRfbGlzdFwudHh0IjtpOjM0OTtzOjQ5OiJAKmZpbGVfZ2V0X2NvbnRlbnRzXChAKmJhc2U2NF9kZWNvZGVcKEAqdXJsZGVjb2RlIjtpOjM1MDtzOjI2OiJcJHtbYS16QS1aMC05X10rP31cKFxzKlwpOyI7aTozNTE7czo2MDoic3Vic3RyXChzcHJpbnRmXChbJyJdJW9bJyJdLFxzKmZpbGVwZXJtc1woXCRmaWxlXClcKSxccyotNFwpIjtpOjM1MjtzOjU3OiJcJFthLXpBLVowLTlfXSs/XChbJyJdWyciXVxzKixccypldmFsXChcJFthLXpBLVowLTlfXSs/XCkiO2k6MzUzO3M6MTY6Indzb1NlY1BhcmFtXHMqXCgiO2k6MzU0O3M6MTg6IndoaWNoXHMrc3VwZXJmZXRjaCI7aTozNTU7czo2ODoiY29weVwoXHMqWyciXWh0dHA6Ly8uKz9cLnR4dFsnIl1ccyosXHMqWyciXVthLXpBLVowLTlfXSs/XC5waHBbJyJdXCkiO2k6MzU2O3M6Mjg6Ilwkc2V0Y29va1xzKlwpO3NldGNvb2tpZVwoXCQiO2k6MzU3O3M6NDkyOiJAKlxiKGV2YWx8YmFzZTY0X2RlY29kZXxzdHJyZXZ8cHJlZ19yZXBsYWNlfHByZWdfcmVwbGFjZV9jYWxsYmFja3x1cmxkZWNvZGV8c3Ryc3RyfGd6aW5mbGF0ZXxzcHJpbnRmfGd6dW5jb21wcmVzc3xhc3NlcnR8c3RyX3JvdDEzfG1kNXxhcnJheV93YWxrfGFycmF5X2ZpbHRlcilccypcKEAqXGIoZXZhbHxiYXNlNjRfZGVjb2RlfHN0cnJldnxwcmVnX3JlcGxhY2V8cHJlZ19yZXBsYWNlX2NhbGxiYWNrfHVybGRlY29kZXxzdHJzdHJ8Z3ppbmZsYXRlfHNwcmludGZ8Z3p1bmNvbXByZXNzfGFzc2VydHxzdHJfcm90MTN8bWQ1fGFycmF5X3dhbGt8YXJyYXlfZmlsdGVyKVxzKlwoQCpcYihldmFsfGJhc2U2NF9kZWNvZGV8c3RycmV2fHByZWdfcmVwbGFjZXxwcmVnX3JlcGxhY2VfY2FsbGJhY2t8dXJsZGVjb2RlfHN0cnN0cnxnemluZmxhdGV8c3ByaW50ZnxnenVuY29tcHJlc3N8YXNzZXJ0fHN0cl9yb3QxM3xtZDV8YXJyYXlfd2Fsa3xhcnJheV9maWx0ZXIpXHMqXCgiO2k6MzU4O3M6NDE6IlwuXHMqYmFzZTY0X2RlY29kZVwoXHMqXCRpbmplY3RccypcKVxzKlwuIjtpOjM1OTtzOjQ3OiIoY2hyXChbXHMwLTlBLVphLXpfXCRcXlwrXC1cKi9dK1wpXHMqXC5ccyopezQsfSI7aTozNjA7czo0MjoiPVxzKkAqZnNvY2tvcGVuXChccypcJGFyZ3ZcW1xkK1xdXHMqLFxzKjgwIjtpOjM2MTtzOjM1OiJcLlwuL1wuXC4vZW5naW5lL2RhdGEvZGJjb25maWdcLnBocCI7aTozNjI7czo4NToicmVjdXJzZV9jb3B5XChccypcJHNyY1xzKixccypcJGRzdFxzKlwpO1xzKmhlYWRlclwoXHMqWyciXWxvY2F0aW9uOlxzKlwkZHN0WyciXVxzKlwpOyI7aTozNjM7czoxNzoiR2FudGVuZ2Vyc1xzK0NyZXciO2k6MzY0O3M6MTQ1OiJcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXXswLDF9XHMqW2EtekEtWjAtOV9dKz9ccypbJyJdezAsMX1cXVwoXHMqWyciXXswLDF9XCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1xzKlthLXpBLVowLTlfXSs/IjtpOjM2NTtzOjQxOiJmd3JpdGVcKFwkW2EtekEtWjAtOV9dKz9ccyosXHMqWyciXTxcP3BocCI7aTozNjY7czo1NjoiQCpjcmVhdGVfZnVuY3Rpb25cKFxzKlsnIl1bJyJdXHMqLFxzKkAqZmlsZV9nZXRfY29udGVudHMiO2k6MzY3O3M6OTk6IlxdXChbJyJdXCRfWyciXVxzKixccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbXHMqWyciXXswLDF9W2EtekEtWjAtOV9dKz9bJyJdezAsMX1ccypcXSI7aTozNjg7czozOToiaWZccypcKFxzKmlzc2V0XChccypcJF9HRVRcW1xzKlsnIl1waW5nIjtpOjM2OTtzOjMwOiJyZWFkX2ZpbGVcKFxzKlsnIl1kb21haW5zXC50eHQiO2k6MzcwO3M6Mzc6ImV2YWxcKFxzKlsnIl17XHMqXCRbYS16QS1aMC05X10rP1xzKn0iO2k6MzcxO3M6MTEwOiJpZlxzKlwoXHMqZmlsZV9leGlzdHNcKFxzKlwkW2EtekEtWjAtOV9dKz9ccypcKVxzKlwpXHMqe1xzKmNobW9kXChccypcJFthLXpBLVowLTlfXSs/XHMqLFxzKjBcZCtcKTtccyp9XHMqZWNobyI7aTozNzI7czoxMToiPT1bJyJdXClcKTsiO2k6MzczO3M6NTY6IlwkW2EtekEtWjAtOV9dKz89dXJsZGVjb2RlXChbJyJdLis/WyciXVwpO2lmXChwcmVnX21hdGNoIjtpOjM3NDtzOjgzOiJcJFthLXpBLVowLTlfXSs/XHMqPVxzKmRlY3J5cHRfU09cKFxzKlwkW2EtekEtWjAtOV9dKz9ccyosXHMqWyciXVthLXpBLVowLTlfXSs/WyciXSI7aTozNzU7czoxMDc6Ij1ccyptYWlsXChccypiYXNlNjRfZGVjb2RlXChccypcJFthLXpBLVowLTlfXSs/XFtcZCtcXVxzKlwpXHMqLFxzKmJhc2U2NF9kZWNvZGVcKFxzKlwkW2EtekEtWjAtOV9dKz9cW1xkK1xdIjtpOjM3NjtzOjI2OiJldmFsXChccypbJyJdcmV0dXJuXHMrZXZhbCI7aTozNzc7czo5NToiPVxzKmJhc2U2NF9lbmNvZGVcKFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtbJyJdW2EtekEtWjAtOV9dKz9bJyJdXF1cKTtccypoZWFkZXIiO2k6Mzc4O3M6MTA3OiJAaW5pX3NldFwoWyciXWVycm9yX2xvZ1snIl0sTlVMTFwpO1xzKkBpbmlfc2V0XChbJyJdbG9nX2Vycm9yc1snIl0sMFwpO1xzKmZ1bmN0aW9uXHMrcmVhZF9maWxlXChcJGZpbGVfbmFtZSI7aTozNzk7czozNzoiXCR0ZXh0XHMqPVxzKmh0dHBfZ2V0XChccypbJyJdaHR0cDovLyI7aTozODA7czoxNDY6IlwkW2EtekEtWjAtOV9dKz9ccyo9XHMqc3RyX3JlcGxhY2VcKFsnIl08L2JvZHk+WyciXVxzKixccypbJyJdWyciXVxzKixccypcJFthLXpBLVowLTlfXSs/XCk7XHMqXCRbYS16QS1aMC05X10rP1xzKj1ccypzdHJfcmVwbGFjZVwoWyciXTwvaHRtbD5bJyJdIjtpOjM4MTtzOjE2MzoiXCNbYS16QS1aMC05X10rP1wjXHMqaWZcKGVtcHR5XChcJFthLXpBLVowLTlfXSs/XClcKVxzKntccypcJFthLXpBLVowLTlfXSs/XHMqPVxzKlsnIl08c2NyaXB0Lis/PC9zY3JpcHQ+WyciXTtccyplY2hvXHMrXCRbYS16QS1aMC05X10rPztccyp9XHMqXCMvW2EtekEtWjAtOV9dKz9cIyI7aTozODI7czo2NzoiXC5cJF9SRVFVRVNUXFtccypbJyJdW2EtekEtWjAtOV9dKz9bJyJdXHMqXF1ccyosXHMqdHJ1ZVxzKixccyozMDJcKSI7aTozODM7czoxMDc6Ij1ccypjcmVhdGVfZnVuY3Rpb25ccypcKFxzKm51bGxccyosXHMqW2EtekEtWjAtOV9dKz9cKFxzKlwkW2EtekEtWjAtOV9dKz9ccypcKVxzKlwpO1xzKlwkW2EtekEtWjAtOV9dKz9cKFwpIjtpOjM4NDtzOjU0OiI9XHMqZmlsZV9nZXRfY29udGVudHNcKFsnIl1odHRwcyo6Ly9cZCtcLlxkK1wuXGQrXC5cZCsiO2k6Mzg1O3M6NTc6IkNvbnRlbnQtdHlwZTpccyphcHBsaWNhdGlvbi92bmRcLmFuZHJvaWRcLnBhY2thZ2UtYXJjaGl2ZSI7aTozODY7czoyMDoic2x1cnBcfG1zbmJvdFx8dGVvbWEiO2k6Mzg3O3M6Mjc6IlwkR0xPQkFMU1xbbmV4dFxdXFtbJyJdbmV4dCI7aTozODg7czoxODA6IjtAKlwkW2EtekEtWjAtOV9dKz9cKFxiKGV2YWx8YmFzZTY0X2RlY29kZXxzdHJyZXZ8cHJlZ19yZXBsYWNlfHByZWdfcmVwbGFjZV9jYWxsYmFja3x1cmxkZWNvZGV8c3Ryc3RyfGd6aW5mbGF0ZXxzcHJpbnRmfGd6dW5jb21wcmVzc3xhc3NlcnR8c3RyX3JvdDEzfG1kNXxhcnJheV93YWxrfGFycmF5X2ZpbHRlcilcKCI7aTozODk7czozMDoiaGVhZGVyXChfW2EtekEtWjAtOV9dKz9cKFxkK1wpIjtpOjM5MDtzOjE4NjoiaWZccypcKGlzc2V0XChcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXVthLXpBLVowLTlfXSs/WyciXVxdXClccyomJlxzKm1kNVwoXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl1bYS16QS1aMC05X10rP1snIl1cXVwpXHMqPT09XHMqWyciXVthLXpBLVowLTlfXSs/WyciXVwpIjtpOjM5MTtzOjkyOiJcLj1ccypjaHJcKFwkW2EtekEtWjAtOV9dKz9ccyo+PlxzKlwoXGQrXHMqXCpccypcKFxkK1xzKi1ccypcJFthLXpBLVowLTlfXSs/XClcKVxzKiZccypcZCtcKSI7aTozOTI7czozMToiLT5wcmVwYXJlXChbJyJdU0hPV1xzK0RBVEFCQVNFUyI7aTozOTM7czoyMzoic29ja3Nfc3lzcmVhZFwoXCRjbGllbnQiO2k6Mzk0O3M6MjQ6IjwlZXZhbFwoXHMqUmVxdWVzdFwuSXRlbSI7aTozOTU7czoxMDI6IlwkX1BPU1RcW1snIl1bYS16QS1aMC05X10rP1snIl1cXTtccypcJFthLXpBLVowLTlfXSs/XHMqPVxzKmZvcGVuXChccypcJF9HRVRcW1snIl1bYS16QS1aMC05X10rP1snIl1cXSI7aTozOTY7czo0MDoidXJsPVsnIl1odHRwOi8vc2NhbjR5b3VcLm5ldC9yZW1vdGVcLnBocCI7aTozOTc7czo2MjoiY2FsbF91c2VyX2Z1bmNcKFxzKlwkW2EtekEtWjAtOV9dKz9ccyosXHMqXCRbYS16QS1aMC05X10rP1wpO30iO2k6Mzk4O3M6NzM6InByZWdfcmVwbGFjZVwoXHMqWyciXS8uKz8vZVsnIl1ccyosXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVCkiO2k6Mzk5O3M6MTA4OiI9XHMqZmlsZV9nZXRfY29udGVudHNcKFxzKlsnIl0uKz9bJyJdXCk7XHMqXCRbYS16QS1aMC05X10rP1xzKj1ccypmb3BlblwoXHMqXCRbYS16QS1aMC05X10rP1xzKixccypbJyJdd1snIl0iO2k6NDAwO3M6NjE6ImlmXChccypcJFthLXpBLVowLTlfXSs/XClccyp7XHMqZXZhbFwoXCRbYS16QS1aMC05X10rP1wpO1xzKn0iO2k6NDAxO3M6MTc5OiJhcnJheV9tYXBcKFxzKlsnIl1cYihldmFsfGJhc2U2NF9kZWNvZGV8c3RycmV2fHByZWdfcmVwbGFjZXxwcmVnX3JlcGxhY2VfY2FsbGJhY2t8dXJsZGVjb2RlfHN0cnN0cnxnemluZmxhdGV8c3ByaW50ZnxnenVuY29tcHJlc3N8YXNzZXJ0fHN0cl9yb3QxM3xtZDV8YXJyYXlfd2Fsa3xhcnJheV9maWx0ZXIpWyciXSI7aTo0MDI7czoxODU6Ij1ccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXVthLXpBLVowLTlfXSs/WyciXVxdO1xzKlwkW2EtekEtWjAtOV9dKz9ccyo9XHMqZmlsZV9wdXRfY29udGVudHNcKFxzKlwkW2EtekEtWjAtOV9dKz9ccyosXHMqZmlsZV9nZXRfY29udGVudHNcKFxzKlwkW2EtekEtWjAtOV9dKz9ccypcKVxzKlwpIjtpOjQwMztzOjM5OiJbYS16QS1aMC05X10rP1woXHMqW2EtekEtWjAtOV9dKz89XHMqXCkiO2k6NDA0O3M6NjI6IjxcP1xzKlwkW2EtekEtWjAtOV9dKz89WyciXS4rP1snIl07XHMqaGVhZGVyXHMqXChbJyJdTG9jYXRpb246IjtpOjQwNTtzOjI1OiI8IS0tXCNleGVjXHMrY21kXHMqPVxzKlwkIjtpOjQwNjtzOjgyOiJpZlwoXHMqc3RyaXBvc1woXHMqXCRbYS16QS1aMC05X10rP1xzKixccypbJyJdYW5kcm9pZFsnIl1ccypcKVxzKiE9PVxzKmZhbHNlXClccyp7IjtpOjQwNztzOjkxOiJcLj1ccypbJyJdPGRpdlxzK3N0eWxlPVsnIl1kaXNwbGF5Om5vbmU7WyciXT5bJyJdXHMqXC5ccypcJFthLXpBLVowLTlfXSs/XHMqXC5ccypbJyJdPC9kaXY+IjtpOjQwODtzOjExODoiPWZpbGVfZXhpc3RzXChcJFthLXpBLVowLTlfXSs/XClcP0BmaWxlbXRpbWVcKFwkW2EtekEtWjAtOV9dKz9cKTpcJFthLXpBLVowLTlfXSs/O0BmaWxlX3B1dF9jb250ZW50c1woXCRbYS16QS1aMC05X10rPyI7aTo0MDk7czo5MzoiXCRbYS16QS1aMC05X10rP1xzKlxbXHMqW2EtekEtWjAtOV9dKz9ccypcXVwoXHMqXCRbYS16QS1aMC05X10rP1xbXHMqW2EtekEtWjAtOV9dKz9ccypcXVxzKlwpIjtpOjQxMDtzOjk4OiJcJFthLXpBLVowLTlfXSs/LFsnIl1zbHVycFsnIl1cKVxzKiE9PVxzKmZhbHNlXHMqXHxcfFxzKnN0cnBvc1woXHMqXCRbYS16QS1aMC05X10rPyxbJyJdc2VhcmNoWyciXSI7aTo0MTE7czo2NjoiXCRbYS16QS1aMC05X10rP1woXHMqXCRbYS16QS1aMC05X10rP1woXHMqXCRbYS16QS1aMC05X10rP1wpXHMqXCk7IjtpOjQxMjtzOjE3OiJjbGFzc1xzK01DdXJsXHMqeyI7aTo0MTM7czo1NjoiQGluaV9zZXRcKFsnIl1kaXNwbGF5X2Vycm9yc1snIl0sMFwpO1xzKkBlcnJvcl9yZXBvcnRpbmciO2k6NDE0O3M6Njk6ImlmXChccypmaWxlX2V4aXN0c1woXHMqXCRmaWxlcGF0aFxzKlwpXHMqXClccyp7XHMqZWNob1xzK1snIl11cGxvYWRlZCI7aTo0MTU7czozMDoicmV0dXJuXHMrUkM0OjpFbmNyeXB0XChcJGEsXCRiIjtpOjQxNjtzOjMyOiJmdW5jdGlvblxzK2dldEhUVFBQYWdlXChccypcJHVybCI7aTo0MTc7czoyMToiPVxzKnJlcXVlc3RcKFxzKmNoclwoIjtpOjQxODtzOjU2OiI7XHMqYXJyYXlfZmlsdGVyXChcJFthLXpBLVowLTlfXSs/XHMqLFxzKmJhc2U2NF9kZWNvZGVcKCI7aTo0MTk7czoyMjg6ImNhbGxfdXNlcl9mdW5jXChccypbJyJdXGIoZXZhbHxiYXNlNjRfZGVjb2RlfHN0cnJldnxwcmVnX3JlcGxhY2V8cHJlZ19yZXBsYWNlX2NhbGxiYWNrfHVybGRlY29kZXxzdHJzdHJ8Z3ppbmZsYXRlfHNwcmludGZ8Z3p1bmNvbXByZXNzfGFzc2VydHxzdHJfcm90MTN8bWQ1fGFycmF5X3dhbGt8YXJyYXlfZmlsdGVyKVsnIl1ccyosXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcWyI7aTo0MjA7czoyNDE6ImNhbGxfdXNlcl9mdW5jX2FycmF5XChccypbJyJdXGIoZXZhbHxiYXNlNjRfZGVjb2RlfHN0cnJldnxwcmVnX3JlcGxhY2V8cHJlZ19yZXBsYWNlX2NhbGxiYWNrfHVybGRlY29kZXxzdHJzdHJ8Z3ppbmZsYXRlfHNwcmludGZ8Z3p1bmNvbXByZXNzfGFzc2VydHxzdHJfcm90MTN8bWQ1fGFycmF5X3dhbGt8YXJyYXlfZmlsdGVyKVsnIl1ccyosXHMqYXJyYXlcKFwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFsiO2k6NDIxO3M6ODc6ImlmIFwoISpcJF9TRVJWRVJcW1snIl1IVFRQX1VTRVJfQUdFTlRbJyJdXF1ccypPUlxzKlwoc3Vic3RyXChcJF9TRVJWRVJcW1snIl1SRU1PVEVfQUREUiI7aTo0MjI7czo1MzoicmVscGF0aHRvYWJzcGF0aFwoXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVCkiO2k6NDIzO3M6Njg6IlwkZGF0YVxbWyciXWNjX2V4cF9tb250aFsnIl1cXVxzKixccypzdWJzdHJcKFwkZGF0YVxbWyciXWNjX2V4cF95ZWFyIjtpOjQyNDtzOjQxOiJcJFthLXpBLVowLTlfXSs/XHMqKFxbLnsxLDQwfVxdKXsxLH1ccypcKCI7aTo0MjU7czozMzoiY2FsbF91c2VyX2Z1bmNcKFxzKkAqdW5oZXhcKFxzKjB4IjtpOjQyNjtzOjI5OiJcLlwuOjpcW1xzKnBocHJveHlccypcXTo6XC5cLiI7aTo0Mjc7czo0NDoiWyciXVxzKlwuXHMqY2hyXChccypcZCsuXGQrXHMqXClccypcLlxzKlsnIl0iO2k6NDI4O3M6MzI6InByZWdfcmVwbGFjZS4qPy9lWyciXVxzKixccypbJyJdIjtpOjQyOTtzOjkwOiJcJFthLXpBLVowLTlfXSs/XChcJFthLXpBLVowLTlfXSs/XChcJFthLXpBLVowLTlfXSs/XChcJFthLXpBLVowLTlfXSs/XChcJFthLXpBLVowLTlfXSs/XCkiO2k6NDMwO3M6MjM6In1ldmFsXChiemRlY29tcHJlc3NcKFwkIjtpOjQzMTtzOjU4OiIvdXNyL2xvY2FsL3BzYS9hcGFjaGUvYmluL2h0dHBkXHMrLURGUk9OVFBBR0VccystREhBVkVfU1NMIjtpOjQzMjtzOjU3OiJpY29udlwoYmFzZTY0X2RlY29kZVwoWyciXS4rP1snIl1cKVxzKixccypiYXNlNjRfZGVjb2RlXCgiO2k6NDMzO3M6MzA6IlwkW2EtekEtWjAtOV9dKz9cKFsnIl0uLmVbJyJdLCI7aTo0MzQ7czo3NDoiQFwkW2EtekEtWjAtOV9dKz8mJkBcJFthLXpBLVowLTlfXSs/XChcJFthLXpBLVowLTlfXSs/LFwkW2EtekEtWjAtOV9dKz9cKTsiO2k6NDM1O3M6MzM6Ijxicj5bJyJdXC5waHBfdW5hbWVcKFwpXC5bJyJdPGJyPiI7aTo0MzY7czo2ODoiXCk7QFwkW2EtekEtWjAtOV9dKz9cW2NoclwoXGQrXClcXVwoXCRbYS16QS1aMC05X10rP1xbY2hyXChcZCtcKVxdXCgiO2k6NDM3O3M6MTA5OiJcYihmb3BlbnxmaWxlX2dldF9jb250ZW50c3xmaWxlX3B1dF9jb250ZW50c3xzdGF0fGNobW9kfGZpbGV8c3ltbGluaylcKFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjQzODtzOjE4OToiXGIoZXZhbHxiYXNlNjRfZGVjb2RlfHN0cnJldnxwcmVnX3JlcGxhY2V8cHJlZ19yZXBsYWNlX2NhbGxiYWNrfHVybGRlY29kZXxzdHJzdHJ8Z3ppbmZsYXRlfHNwcmludGZ8Z3p1bmNvbXByZXNzfGFzc2VydHxzdHJfcm90MTN8bWQ1fGFycmF5X3dhbGt8YXJyYXlfZmlsdGVyKVwoZmlsZV9nZXRfY29udGVudHNcKFsnIl1odHRwOi8vIjtpOjQzOTtzOjIzMjoiXGIoZXZhbHxiYXNlNjRfZGVjb2RlfHN0cnJldnxwcmVnX3JlcGxhY2V8cHJlZ19yZXBsYWNlX2NhbGxiYWNrfHVybGRlY29kZXxzdHJzdHJ8Z3ppbmZsYXRlfHNwcmludGZ8Z3p1bmNvbXByZXNzfGFzc2VydHxzdHJfcm90MTN8bWQ1fGFycmF5X3dhbGt8YXJyYXlfZmlsdGVyKVwoXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl17MCwxfVthLXpBLVowLTlfXSs/WyciXXswLDF9XF1cKSI7aTo0NDA7czo5NToiXGIoZm9wZW58ZmlsZV9nZXRfY29udGVudHN8ZmlsZV9wdXRfY29udGVudHN8c3RhdHxjaG1vZHxmaWxlfHN5bWxpbmspXChbJyJdaHR0cDovL3Bhc3RlYmluXC5jb20iO30="));
$g_ExceptFlex = unserialize(base64_decode("YToxNDM6e2k6MDtzOjM3OiJlY2hvICI8c2NyaXB0PiBhbGVydFwoJyJcLlwkZGItPmdldEVyIjtpOjE7czo0MDoiZWNobyAiPHNjcmlwdD4gYWxlcnRcKCciXC5cJG1vZGVsLT5nZXRFciI7aToyO3M6ODoic29ydFwoXCkiO2k6MztzOjEwOiJtdXN0LXJldmFsIjtpOjQ7czo2OiJyaWV2YWwiO2k6NTtzOjk6ImRvdWJsZXZhbCI7aTo2O3M6NjY6InJlcXVpcmVccypcKCpccypcJF9TRVJWRVJcW1xzKlsnIl17MCwxfURPQ1VNRU5UX1JPT1RbJyJdezAsMX1ccypcXSI7aTo3O3M6NzE6InJlcXVpcmVfb25jZVxzKlwoKlxzKlwkX1NFUlZFUlxbXHMqWyciXXswLDF9RE9DVU1FTlRfUk9PVFsnIl17MCwxfVxzKlxdIjtpOjg7czo2NjoiaW5jbHVkZVxzKlwoKlxzKlwkX1NFUlZFUlxbXHMqWyciXXswLDF9RE9DVU1FTlRfUk9PVFsnIl17MCwxfVxzKlxdIjtpOjk7czo3MToiaW5jbHVkZV9vbmNlXHMqXCgqXHMqXCRfU0VSVkVSXFtccypbJyJdezAsMX1ET0NVTUVOVF9ST09UWyciXXswLDF9XHMqXF0iO2k6MTA7czoxNzoiXCRzbWFydHktPl9ldmFsXCgiO2k6MTE7czozMDoicHJlcFxzK3JtXHMrLXJmXHMrJXtidWlsZHJvb3R9IjtpOjEyO3M6MjI6IlRPRE86XHMrcm1ccystcmZccyt0aGUiO2k6MTM7czoyNzoia3Jzb3J0XChcJHdwc21pbGllc3RyYW5zXCk7IjtpOjE0O3M6NjM6ImRvY3VtZW50XC53cml0ZVwodW5lc2NhcGVcKCIlM0NzY3JpcHQgc3JjPSciIFwrIGdhSnNIb3N0IFwrICJnbyI7aToxNTtzOjY6IlwuZXhlYyI7aToxNjtzOjg6ImV4ZWNcKFwpIjtpOjE3O3M6MjI6IlwkeDE9XCR0aGlzLT53IC0gXCR4MTsiO2k6MTg7czozMToiYXNvcnRcKFwkQ2FjaGVEaXJPbGRGaWxlc0FnZVwpOyI7aToxOTtzOjEzOiJcKCdyNTdzaGVsbCcsIjtpOjIwO3M6MjM6ImV2YWxcKCJsaXN0ZW5lcj0iXCtsaXN0IjtpOjIxO3M6ODoiZXZhbFwoXCkiO2k6MjI7czozMzoicHJlZ19yZXBsYWNlX2NhbGxiYWNrXCgnL1xce1woaW1hIjtpOjIzO3M6MjA6ImV2YWxcKF9jdE1lbnVJbml0U3RyIjtpOjI0O3M6Mjk6ImJhc2U2NF9kZWNvZGVcKFwkYWNjb3VudEtleVwpIjtpOjI1O3M6Mzg6ImJhc2U2NF9kZWNvZGVcKFwkZGF0YVwpXCk7XCRhcGktPnNldFJlIjtpOjI2O3M6NDg6InJlcXVpcmVcKFwkX1NFUlZFUlxbXFwiRE9DVU1FTlRfUk9PVFxcIlxdXC5cXCIvYiI7aToyNztzOjY0OiJiYXNlNjRfZGVjb2RlXChcJF9SRVFVRVNUXFsncGFyYW1ldGVycydcXVwpO2lmXChDaGVja1NlcmlhbGl6ZWREIjtpOjI4O3M6NjE6InBjbnRsX2V4ZWMnPT4gQXJyYXlcKEFycmF5XCgxXCksXCRhclJlc3VsdFxbJ1NFQ1VSSU5HX0ZVTkNUSU8iO2k6Mjk7czozOToiZWNobyAiPHNjcmlwdD5hbGVydFwoJyJcLkNVdGlsOjpKU0VzY2FwIjtpOjMwO3M6NjY6ImJhc2U2NF9kZWNvZGVcKFwkX1JFUVVFU1RcWyd0aXRsZV9jaGFuZ2VyX2xpbmsnXF1cKTtpZlwoc3RybGVuXChcJCI7aTozMTtzOjQ0OiJldmFsXCgnXCRoZXhkdGltZT0iJ1wuXCRoZXhkdGltZVwuJyI7J1wpO1wkZiI7aTozMjtzOjUyOiJlY2hvICI8c2NyaXB0PmFsZXJ0XCgnXCRyb3ctPnRpdGxlIC0gIlwuX01PRFVMRV9JU19FIjtpOjMzO3M6Mzc6ImVjaG8gIjxzY3JpcHQ+YWxlcnRcKCdcJGNpZHMgIlwuX0NBTk4iO2k6MzQ7czozNzoiaWZcKDFcKXtcJHZfaG91cj1cKFwkcF9oZWFkZXJcWydtdGltZSI7aTozNTtzOjY4OiJkb2N1bWVudFwud3JpdGVcKHVuZXNjYXBlXCgiJTNDc2NyaXB0JTIwc3JjPSUyMmh0dHAiIFwrXChcKCJodHRwczoiPSI7aTozNjtzOjU3OiJkb2N1bWVudFwud3JpdGVcKHVuZXNjYXBlXCgiJTNDc2NyaXB0IHNyYz0nIiBcKyBwa0Jhc2VVUkwiO2k6Mzc7czozMjoiZWNobyAiPHNjcmlwdD5hbGVydFwoJyJcLkpUZXh0OjoiO2k6Mzg7czoyNDoiJ2ZpbGVuYW1lJ1wpLFwoJ3I1N3NoZWxsIjtpOjM5O3M6Mzk6ImVjaG8gIjxzY3JpcHQ+YWxlcnRcKCciXC5cJGVyck1zZ1wuIidcKSI7aTo0MDtzOjQyOiJlY2hvICI8c2NyaXB0PmFsZXJ0XChcXCJFcnJvciB3aGVuIGxvYWRpbmciO2k6NDE7czo0MzoiZWNobyAiPHNjcmlwdD5hbGVydFwoJyJcLkpUZXh0OjpfXCgnVkFMSURfRSI7aTo0MjtzOjg6ImV2YWxcKFwpIjtpOjQzO3M6ODoiJ3N5c3RlbSciO2k6NDQ7czo2OiInZXZhbCciO2k6NDU7czo2OiIiZXZhbCIiO2k6NDY7czo3OiJfc3lzdGVtIjtpOjQ3O3M6OToic2F2ZTJjb3B5IjtpOjQ4O3M6MTA6ImZpbGVzeXN0ZW0iO2k6NDk7czo4OiJzZW5kbWFpbCI7aTo1MDtzOjg6ImNhbkNobW9kIjtpOjUxO3M6MTM6Ii9ldGMvcGFzc3dkXCkiO2k6NTI7czoyNDoidWRwOi8vJ1wuc2VsZjo6XCRfY19hZGRyIjtpOjUzO3M6MzM6ImVkb2NlZF80NmVzYWJcKCcnXHwiXClcXFwpJywncmVnZSI7aTo1NDtzOjk6ImRvdWJsZXZhbCI7aTo1NTtzOjE2OiJvcGVyYXRpbmcgc3lzdGVtIjtpOjU2O3M6MTA6Imdsb2JhbGV2YWwiO2k6NTc7czoyNzoiZXZhbFwoZnVuY3Rpb25cKHAsYSxjLGssZSxyIjtpOjU4O3M6MTk6IndpdGggMC8wLzAgaWZcKDFcKXsiO2k6NTk7czo0NjoiXCR4Mj1cJHBhcmFtXFtbJyJdezAsMX14WyciXXswLDF9XF0gXCsgXCR3aWR0aCI7aTo2MDtzOjk6InNwZWNpYWxpcyI7aTo2MTtzOjg6ImNvcHlcKFwpIjtpOjYyO3M6MTk6IndwX2dldF9jdXJyZW50X3VzZXIiO2k6NjM7czo3OiItPmNobW9kIjtpOjY0O3M6NzoiX21haWxcKCI7aTo2NTtzOjc6Il9jb3B5XCgiO2k6NjY7czo3OiImY29weVwoIjtpOjY3O3M6NDU6InN0cnBvc1woXCRfU0VSVkVSXFsnSFRUUF9VU0VSX0FHRU5UJ1xdLCdEcnVwYSI7aTo2ODtzOjE2OiJldmFsXChjbGFzc1N0clwpIjtpOjY5O3M6MzE6ImZ1bmN0aW9uX2V4aXN0c1woJ2Jhc2U2NF9kZWNvZGUiO2k6NzA7czo0NDoiZWNobyAiPHNjcmlwdD5hbGVydFwoJyJcLkpUZXh0OjpfXCgnVkFMSURfRU0iO2k6NzE7czo0MzoiXCR4MT1cJG1pbl94O1wkeDI9XCRtYXhfeDtcJHkxPVwkbWluX3k7XCR5MiI7aTo3MjtzOjQ4OiJcJGN0bVxbJ2EnXF1cKVwpe1wkeD1cJHggXCogXCR0aGlzLT5rO1wkeT1cKFwkdGgiO2k6NzM7czo1OToiWyciXXswLDF9Y3JlYXRlX2Z1bmN0aW9uWyciXXswLDF9LFsnIl17MCwxfWdldF9yZXNvdXJjZV90eXAiO2k6NzQ7czo0ODoiWyciXXswLDF9Y3JlYXRlX2Z1bmN0aW9uWyciXXswLDF9LFsnIl17MCwxfWNyeXB0IjtpOjc1O3M6Njg6InN0cnBvc1woXCRfU0VSVkVSXFtbJyJdezAsMX1IVFRQX1VTRVJfQUdFTlRbJyJdezAsMX1cXSxbJyJdezAsMX1MeW54IjtpOjc2O3M6Njc6InN0cnN0clwoXCRfU0VSVkVSXFtbJyJdezAsMX1IVFRQX1VTRVJfQUdFTlRbJyJdezAsMX1cXSxbJyJdezAsMX1NU0kiO2k6Nzc7czoyNToic29ydFwoXCREaXN0cmlidXRpb25cW1wkayI7aTo3ODtzOjI1OiJzb3J0XChmdW5jdGlvblwoYSxiXCl7cmV0IjtpOjc5O3M6MjU6Imh0dHA6Ly93d3dcLmZhY2Vib29rXC5jb20iO2k6ODA7czoyNToiaHR0cDovL21hcHNcLmdvb2dsZVwuY29tLyI7aTo4MTtzOjQ4OiJ1ZHA6Ly8nXC5zZWxmOjpcJGNfYWRkciw4MCxcJGVycm5vLFwkZXJyc3RyLDE1MDAiO2k6ODI7czoyMDoiXChcLlwqXCh2aWV3XClcP1wuXCoiO2k6ODM7czo0NDoiZWNobyBbJyJdezAsMX08c2NyaXB0PmFsZXJ0XChbJyJdezAsMX1cJHRleHQiO2k6ODQ7czoxNzoic29ydFwoXCR2X2xpc3RcKTsiO2k6ODU7czo3NToibW92ZV91cGxvYWRlZF9maWxlXChcJF9GSUxFU1xbJ3VwbG9hZGVkX3BhY2thZ2UnXF1cWyd0bXBfbmFtZSdcXSxcJG1vc0NvbmZpIjtpOjg2O3M6MTI6ImZhbHNlXClcKTtcIyI7aTo4NztzOjQ2OiJzdHJwb3NcKFwkX1NFUlZFUlxbJ0hUVFBfVVNFUl9BR0VOVCdcXSwnTWFjIE9TIjtpOjg4O3M6NTA6ImRvY3VtZW50XC53cml0ZVwodW5lc2NhcGVcKCIlM0NzY3JpcHQgc3JjPScvYml0cml4IjtpOjg5O3M6MjU6IlwkX1NFUlZFUiBcWyJSRU1PVEVfQUREUiIiO2k6OTA7czoxNzoiYUhSMGNEb3ZMMk55YkRNdVoiO2k6OTE7czo1NDoiSlJlc3BvbnNlOjpzZXRCb2R5XChwcmVnX3JlcGxhY2VcKFwkcGF0dGVybnMsXCRyZXBsYWNlIjtpOjkyO3M6ODoiH4sIAAAAAAAiO2k6OTM7czo4OiJQSwUGAAAAACI7aTo5NDtzOjE0OiIJCgsMDSAvPlxdXFtcXiI7aTo5NTtzOjg6IolQTkcNChoKIjtpOjk2O3M6MTA6IlwpO1wjaScsJyYiO2k6OTc7czoxNToiXCk7XCNtaXMnLCcnLFwkIjtpOjk4O3M6MTk6IlwpO1wjaScsXCRkYXRhLFwkbWEiO2k6OTk7czozNDoiXCRmdW5jXChcJHBhcmFtc1xbXCR0eXBlXF0tPnBhcmFtcyI7aToxMDA7czo4OiIfiwgAAAAAACI7aToxMDE7czo5OiIAAQIDBAUGBwgiO2k6MTAyO3M6MTI6IiFcI1wkJSYnXCpcKyI7aToxMDM7czo3OiKDi42bnp+hIjtpOjEwNDtzOjY6IgkKCwwNICI7aToxMDU7czozMzoiXC5cLi9cLlwuL1wuXC4vXC5cLi9tb2R1bGVzL21vZF9tIjtpOjEwNjtzOjMwOiJcJGRlY29yYXRvclwoXCRtYXRjaGVzXFsxXF1cWzAiO2k6MTA3O3M6MjE6IlwkZGVjb2RlZnVuY1woXCRkXFtcJCI7aToxMDg7czoxNzoiX1wuXCtfYWJicmV2aWF0aW8iO2k6MTA5O3M6NDU6InN0cmVhbV9zb2NrZXRfY2xpZW50XCgndGNwOi8vJ1wuXCRwcm94eS0+aG9zdCI7aToxMTA7czoyNzoiZXZhbFwoZnVuY3Rpb25cKHAsYSxjLGssZSxkIjtpOjExMTtzOjI1OiIncnVua2l0X2Z1bmN0aW9uX3JlbmFtZScsIjtpOjExMjtzOjY6IoCBgoOEhSI7aToxMTM7czo2OiIBAgMEBQYiO2k6MTE0O3M6NjoiAAAAAAAAIjtpOjExNTtzOjIxOiJcJG1ldGhvZFwoXCRhcmdzXFswXF0iO2k6MTE2O3M6MjE6IlwkbWV0aG9kXChcJGFyZ3NcWzBcXSI7aToxMTc7czoyNDoiXCRuYW1lXChcJGFyZ3VtZW50c1xbMFxdIjtpOjExODtzOjMxOiJzdWJzdHJcKG1kNVwoc3Vic3RyXChcJHRva2VuLDAsIjtpOjExOTtzOjI0OiJzdHJyZXZcKHN1YnN0clwoc3RycmV2XCgiO2k6MTIwO3M6Mzk6InN0cmVhbV9zb2NrZXRfY2xpZW50XCgndGNwOi8vJ1wuXCRwcm94eSI7aToxMjE7czozNjoiXCRlbGVtZW50XFtiXF1cKDBcKSx0aGlzXC50cmFuc2l0aW9uIjtpOjEyMjtzOjMxOiJcJG1ldGhvZFwoXCRyZWxhdGlvblxbJ2l0ZW1OYW1lIjtpOjEyMztzOjM2OiJcJHZlcnNpb25cWzFcXVwpO31lbHNlaWZcKHByZWdfbWF0Y2giO2k6MTI0O3M6MzQ6IlwkY29tbWFuZFwoXCRjb21tYW5kc1xbXCRpZGVudGlmaWUiO2k6MTI1O3M6NDI6IlwkY2FsbGFibGVcKFwkcmF3XFsnY2FsbGJhY2snXF1cKFwkY1wpLFwkYyI7aToxMjY7czo0MjoiXCRlbFxbdmFsXF1cKFwpXCkgXCRlbFxbdmFsXF1cKGRhdGFcW3N0YXRlIjtpOjEyNztzOjQ3OiJcJGVsZW1lbnRcW3RcXVwoMFwpLHRoaXNcLnRyYW5zaXRpb25cKCJhZGRDbGFzcyI7aToxMjg7czozMToiXCk7XCNtaXMnLCcgJyxcJGlucHV0XCk7XCRpbnB1dCI7aToxMjk7czozMToia2lsbCAtOSAnXC5cJHBpZFwpO1wkdGhpcy0+Y2xvcyI7aToxMzA7czozMjoiY2FsbF91c2VyX2Z1bmNcKFwkZmlsdGVyLFwkdmFsdWUiO2k6MTMxO3M6MzM6ImNhbGxfdXNlcl9mdW5jXChcJG9wdGlvbnMsXCRlcnJvciI7aToxMzI7czozNjoiY2FsbF91c2VyX2Z1bmNcKFwkbGlzdGVuZXIsXCRldmVudFwpIjtpOjEzMztzOjY1OiJpZlwoc3RyaXBvc1woXCR1c2VyQWdlbnQsJ0FuZHJvaWQnXCkhPT1mYWxzZVwpe1wkdGhpcy0+bW9iaWxlPXRydSI7aToxMzQ7czo1MzoiYmFzZTY0X2RlY29kZVwodXJsZGVjb2RlXChcJGZpbGVcKVwpPT0naW5kZXhcLnBocCdcKXsiO2k6MTM1O3M6NjA6InVybGRlY29kZVwoYmFzZTY0X2RlY29kZVwoXCRpbnB1dFwpXCk7XCRleHBsb2RlQXJyYXk9ZXhwbG9kZSI7aToxMzY7czozNzoiYmFzZTY0X2RlY29kZVwodXJsZGVjb2RlXChcJHJldHVyblVyaSI7aToxMzc7czo0NzoidXJsZGVjb2RlXCh1cmxkZWNvZGVcKHN0cmlwY3NsYXNoZXNcKFwkc2VnbWVudHMiO2k6MTM4O3M6NTM6Im1haWxcKFwkdG8sXCRzdWJqZWN0LFwkYm9keSxcJGhlYWRlclwpO31lbHNle1wkcmVzdWx0IjtpOjEzOTtzOjM4OiI9aW5pX2dldFwoJ2Rpc2FibGVfZnVuY3Rpb25zJ1wpO1wkdGhpcyI7aToxNDA7czo0MjoiPWluaV9nZXRcKCdkaXNhYmxlX2Z1bmN0aW9ucydcKTtpZlwoIWVtcHR5IjtpOjE0MTtzOjM5OiJldmFsXChcJHBocENvZGVcKTt9ZWxzZXtjbGFzc19hbGlhc1woXCQiO2k6MTQyO3M6NDg6ImV2YWxcKFwkc3RyXCk7fXB1YmxpYyBmdW5jdGlvbiBjb3VudE1lbnVDaGlsZHJlbiI7fQ=="));
$g_AdwareSig = unserialize(base64_decode("YToxNDU6e2k6MDtzOjI1OiJzbGlua3NcLnN1L2dldF9saW5rc1wucGhwIjtpOjE7czoxMzoiTUxfbGNvZGVcLnBocCI7aToyO3M6MTM6Ik1MXyVjb2RlXC5waHAiO2k6MztzOjE5OiJjb2Rlc1wubWFpbmxpbmtcLnJ1IjtpOjQ7czoxOToiX19saW5rZmVlZF9yb2JvdHNfXyI7aTo1O3M6MTM6IkxJTktGRUVEX1VTRVIiO2k6NjtzOjE0OiJMaW5rZmVlZENsaWVudCI7aTo3O3M6MTg6Il9fc2FwZV9kZWxpbWl0ZXJfXyI7aTo4O3M6Mjk6ImRpc3BlbnNlclwuYXJ0aWNsZXNcLnNhcGVcLnJ1IjtpOjk7czoxMToiTEVOS19jbGllbnQiO2k6MTA7czoxMToiU0FQRV9jbGllbnQiO2k6MTE7czoxNjoiX19saW5rZmVlZF9lbmRfXyI7aToxMjtzOjE2OiJTTEFydGljbGVzQ2xpZW50IjtpOjEzO3M6MjA6Im5ld1xzK0xMTV9jbGllbnRcKFwpIjtpOjE0O3M6MTc6ImRiXC50cnVzdGxpbmtcLnJ1IjtpOjE1O3M6NjM6IlwkX1NFUlZFUlxbXHMqWyciXUhUVFBfUkVGRVJFUlsnIl1ccypcXVxzKixccypbJyJddHJ1c3RsaW5rXC5ydSI7aToxNjtzOjQzOiJcJFthLXpBLVowLTlfXSs/XHMqPVxzKm5ld1xzKkJTXChcKTtccyplY2hvIjtpOjE3O3M6Mzc6ImNsYXNzXHMrQ01fY2xpZW50XHMrZXh0ZW5kc1xzKkNNX2Jhc2UiO2k6MTg7czoxOToibmV3XHMrQ01fY2xpZW50XChcKSI7aToxOTtzOjE2OiJ0bF9saW5rc19kYl9maWxlIjtpOjIwO3M6MjA6ImNsYXNzXHMrbG1wX2Jhc2Vccyt7IjtpOjIxO3M6MTU6IlRydXN0bGlua0NsaWVudCI7aToyMjtzOjEzOiItPlxzKlNMQ2xpZW50IjtpOjIzO3M6MTY2OiJpc3NldFxzKlwoKlxzKlwkX1NFUlZFUlxzKlxbXHMqWyciXXswLDF9SFRUUF9VU0VSX0FHRU5UWyciXXswLDF9XHMqXF1ccypcKVxzKiYmXHMqXCgqXHMqXCRfU0VSVkVSXHMqXFtccypbJyJdezAsMX1IVFRQX1VTRVJfQUdFTlRbJyJdezAsMX1cXVxzKj09XHMqWyciXXswLDF9TE1QX1JvYm90IjtpOjI0O3M6NDM6IlwkbGlua3MtPlxzKnJldHVybl9saW5rc1xzKlwoKlxzKlwkbGliX3BhdGgiO2k6MjU7czo0NDoiXCRsaW5rc19jbGFzc1xzKj1ccypuZXdccytHZXRfbGlua3NccypcKCpccyoiO2k6MjY7czo1MjoiWyciXXswLDF9XHMqLFxzKlsnIl17MCwxfVwuWyciXXswLDF9XHMqXCkqXHMqO1xzKlw/PiI7aToyNztzOjc6Imxldml0cmEiO2k6Mjg7czoxMDoiZGFwb3hldGluZSI7aToyOTtzOjY6InZpYWdyYSI7aTozMDtzOjY6ImNpYWxpcyI7aTozMTtzOjg6InByb3ZpZ2lsIjtpOjMyO3M6MTk6ImNsYXNzXHMrVFdlZmZDbGllbnQiO2k6MzM7czoxODoibmV3XHMrU0xDbGllbnRcKFwpIjtpOjM0O3M6MjQ6Il9fbGlua2ZlZWRfYmVmb3JlX3RleHRfXyI7aTozNTtzOjE2OiJfX3Rlc3RfdGxfbGlua19fIjtpOjM2O3M6MTg6InM6MTE6ImxtcF9jaGFyc2V0IiI7aTozNztzOjIwOiI9XHMrbmV3XHMrTUxDbGllbnRcKCI7aTozODtzOjQ3OiJlbHNlXHMraWZccypcKFxzKlwoXHMqc3RycG9zXChccypcJGxpbmtzX2lwXHMqLCI7aTozOTtzOjMzOiJmdW5jdGlvblxzK3Bvd2VyX2xpbmtzX2Jsb2NrX3ZpZXciO2k6NDA7czoyMDoiY2xhc3NccytJTkdPVFNDbGllbnQiO2k6NDE7czoxMDoiX19MSU5LX188YSI7aTo0MjtzOjIxOiJjbGFzc1xzK0xpbmtwYWRfc3RhcnQiO2k6NDM7czoxMzoiY2xhc3NccytUTlhfbCI7aTo0NDtzOjIyOiJjbGFzc1xzK01FR0FJTkRFWF9iYXNlIjtpOjQ1O3M6MTU6Il9fTElOS19fX19FTkRfXyI7aTo0NjtzOjIyOiJuZXdccytUUlVTVExJTktfY2xpZW50IjtpOjQ3O3M6NzU6InJcLnBocFw/aWQ9W2EtekEtWjAtOV9dKz8mcmVmZXJlcj0le0hUVFBfSE9TVH0vJXtSRVFVRVNUX1VSSX1ccytcW1I9MzAyLExcXSI7aTo0ODtzOjM5OiJVc2VyLWFnZW50OlxzKkdvb2dsZWJvdFxzKkRpc2FsbG93OlxzKi8iO2k6NDk7czoxODoibmV3XHMrTExNX2NsaWVudFwoIjtpOjUwO3M6MzY6IiZyZWZlcmVyPSV7SFRUUF9IT1NUfS8le1JFUVVFU1RfVVJJfSI7aTo1MTtzOjI5OiJcLnBocFw/aWQ9XCQxJiV7UVVFUllfU1RSSU5HfSI7aTo1MjtzOjMzOiJBZGRUeXBlXHMrYXBwbGljYXRpb24veC1odHRwZC1waHAiO2k6NTM7czoyMzoiQWRkSGFuZGxlclxzK3BocC1zY3JpcHQiO2k6NTQ7czoyMzoiQWRkSGFuZGxlclxzK2NnaS1zY3JpcHQiO2k6NTU7czo1MjoiUmV3cml0ZVJ1bGVccytcLlwqXHMraW5kZXhcLnBocFw/dXJsPVwkMFxzK1xbTCxRU0FcXSI7aTo1NjtzOjEyOiJwaHBpbmZvXChcKTsiO2k6NTc7czoxNToiXChtc2llXHxvcGVyYVwpIjtpOjU4O3M6MjI6IjxoMT5Mb2FkaW5nXC5cLlwuPC9oMT4iO2k6NTk7czoyOToiRXJyb3JEb2N1bWVudFxzKzUwMFxzK2h0dHA6Ly8iO2k6NjA7czoyOToiRXJyb3JEb2N1bWVudFxzKzQwMFxzK2h0dHA6Ly8iO2k6NjE7czoyOToiRXJyb3JEb2N1bWVudFxzKzQwNFxzK2h0dHA6Ly8iO2k6NjI7czo0OToiUmV3cml0ZUNvbmRccyole0hUVFBfVVNFUl9BR0VOVH1ccypcLlwqbmRyb2lkXC5cKiI7aTo2MztzOjEwMToiPHNjcmlwdFxzK2xhbmd1YWdlPVsnIl17MCwxfUphdmFTY3JpcHRbJyJdezAsMX0+XHMqcGFyZW50XC53aW5kb3dcLm9wZW5lclwubG9jYXRpb25ccyo9XHMqWyciXWh0dHA6Ly8iO2k6NjQ7czo5OToiY2hyXHMqXChccyoxMDFccypcKVxzKlwuXHMqY2hyXHMqXChccyoxMThccypcKVxzKlwuXHMqY2hyXHMqXChccyo5N1xzKlwpXHMqXC5ccypjaHJccypcKFxzKjEwOFxzKlwpIjtpOjY1O3M6MzA6ImN1cmxcLmhheHhcLnNlL3JmYy9jb29raWVfc3BlYyI7aTo2NjtzOjE4OiJKb29tbGFfYnJ1dGVfRm9yY2UiO2k6Njc7czozNDoiUmV3cml0ZUNvbmRccyole0hUVFA6eC13YXAtcHJvZmlsZSI7aTo2ODtzOjQyOiJSZXdyaXRlQ29uZFxzKiV7SFRUUDp4LW9wZXJhbWluaS1waG9uZS11YX0iO2k6Njk7czo2NjoiUmV3cml0ZUNvbmRccyole0hUVFA6QWNjZXB0LUxhbmd1YWdlfVxzKlwocnVcfHJ1LXJ1XHx1a1wpXHMqXFtOQ1xdIjtpOjcwO3M6MjY6InNsZXNoXCtzbGVzaFwrZG9tZW5cK3BvaW50IjtpOjcxO3M6MTc6InRlbGVmb25uYXlhLWJhemEtIjtpOjcyO3M6MTg6ImljcS1kbHlhLXRlbGVmb25hLSI7aTo3MztzOjI0OiJwYWdlX2ZpbGVzL3N0eWxlMDAwXC5jc3MiO2k6NzQ7czoyMDoic3ByYXZvY2huaWstbm9tZXJvdi0iO2k6NzU7czoxNzoiS2F6YW4vaW5kZXhcLmh0bWwiO2k6NzY7czo1MDoiR29vZ2xlYm90WyciXXswLDF9XHMqXClcKXtlY2hvXHMrZmlsZV9nZXRfY29udGVudHMiO2k6Nzc7czoyNjoiaW5kZXhcLnBocFw/aWQ9XCQxJiV7UVVFUlkiO2k6Nzg7czoyMDoiVm9sZ29ncmFkaW5kZXhcLmh0bWwiO2k6Nzk7czozODoiQWRkVHlwZVxzK2FwcGxpY2F0aW9uL3gtaHR0cGQtY2dpXHMrXC4iO2k6ODA7czoxOToiLWtseWNoLWstaWdyZVwuaHRtbCI7aTo4MTtzOjE5OiJsbXBfY2xpZW50XChzdHJjb2RlIjtpOjgyO3M6MTc6Ii9cP2RvPWthay11ZGFsaXQtIjtpOjgzO3M6MTQ6Ii9cP2RvPW9zaGlia2EtIjtpOjg0O3M6MTk6Ii9pbnN0cnVrdHNpeWEtZGx5YS0iO2k6ODU7czo0MzoiY29udGVudD0iXGQrO1VSTD1odHRwczovL2RvY3NcLmdvb2dsZVwuY29tLyI7aTo4NjtzOjU5OiIlPCEtLVxcc1wqXCRtYXJrZXJcXHNcKi0tPlwuXCtcPzwhLS1cXHNcKi9cJG1hcmtlclxcc1wqLS0+JSI7aTo4NztzOjc5OiJSZXdyaXRlUnVsZVxzK1xeXChcLlwqXCksXChcLlwqXClcJFxzK1wkMlwucGhwXD9yZXdyaXRlX3BhcmFtcz1cJDEmcGFnZV91cmw9XCQyIjtpOjg4O3M6NDI6IlJld3JpdGVSdWxlXHMqXChcLlwrXClccyppbmRleFwucGhwXD9zPVwkMCI7aTo4OTtzOjE4OiJSZWRpcmVjdFxzKmh0dHA6Ly8iO2k6OTA7czo0NToiUmV3cml0ZVJ1bGVccypcXlwoXC5cKlwpXHMqaW5kZXhcLnBocFw/aWQ9XCQxIjtpOjkxO3M6NDQ6IlJld3JpdGVSdWxlXHMqXF5cKFwuXCpcKVxzKmluZGV4XC5waHBcP209XCQxIjtpOjkyO3M6MTk4OiJcYihwZXJjb2NldHxhZGRlcmFsbHx2aWFncmF8Y2lhbGlzfGxldml0cmF8a2F1ZmVufGFtYmllbnxibHVlXHMrcGlsbHxjb2NhaW5lfG1hcmlqdWFuYXxsaXBpdG9yfHBoZW50ZXJtaW58cHJvW3N6XWFjfHNhbmR5YXVlcnx0cmFtYWRvbHx0cm95aGFtYnl1bHRyYW18dW5pY2F1Y2F8dmFsaXVtfHZpY29kaW58eGFuYXh8eXB4YWllbylccytvbmxpbmUiO2k6OTM7czo1MDoiUmV3cml0ZVJ1bGVccypcLlwqL1wuXCpccypbYS16QS1aMC05X10rP1wucGhwXD9cJDAiO2k6OTQ7czozOToiUmV3cml0ZUNvbmRccysle1JFTU9URV9BRERSfVxzK1xeODVcLjI2IjtpOjk1O3M6NDE6IlJld3JpdGVDb25kXHMrJXtSRU1PVEVfQUREUn1ccytcXjIxN1wuMTE4IjtpOjk2O3M6NTM6IlJld3JpdGVFbmdpbmVccytPblxzKlJld3JpdGVCYXNlXHMrL1w/W2EtekEtWjAtOV9dKz89IjtpOjk3O3M6MzI6IkVycm9yRG9jdW1lbnRccys0MDRccytodHRwOi8vdGRzIjtpOjk4O3M6NTE6IlJld3JpdGVSdWxlXHMrXF5cKFwuXCpcKVwkXHMraHR0cDovL1xkK1wuXGQrXC5cZCtcLiI7aTo5OTtzOjY3OiI8IS0tY2hlY2s6WyciXVxzKlwuXHMqbWQ1XChccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbIjtpOjEwMDtzOjE4OiJSZXdyaXRlQmFzZVxzKy93cC0iO2k6MTAxO3M6MzY6IlNldEhhbmRsZXJccythcHBsaWNhdGlvbi94LWh0dHBkLXBocCI7aToxMDI7czo0MjoiJXtIVFRQX1VTRVJfQUdFTlR9XHMrIXdpbmRvd3MtbWVkaWEtcGxheWVyIjtpOjEwMztzOjU4OiJcKCpccypcJF9TRVJWRVJcW1xzKlsnIl17MCwxfUhUVFBfVVNFUl9BR0VOVFsnIl17MCwxfVxzKlxdIjtpOjEwNDtzOjU4OiJcKCpccypcJF9TRVJWRVJcW1xzKlsnIl17MCwxfUhUVFBfVVNFUl9BR0VOVFsnIl17MCwxfVxzKlxdIjtpOjEwNTtzOjU4OiJcKCpccypcJF9TRVJWRVJcW1xzKlsnIl17MCwxfUhUVFBfVVNFUl9BR0VOVFsnIl17MCwxfVxzKlxdIjtpOjEwNjtzOjgyOiJcKFxzKlwkX1NFUlZFUlxbXHMqWyciXXswLDF9SFRUUF9VU0VSX0FHRU5UWyciXXswLDF9XHMqXF1ccyosXHMqWyciXXswLDF9WWFuZGV4Qm90IjtpOjEwNztzOjc2OiJcKFxzKlwkX1NFUlZFUlxbXHMqWyciXXswLDF9SFRUUF9SRUZFUkVSWyciXXswLDF9XHMqXF1ccyosXHMqWyciXXswLDF9eWFuZGV4IjtpOjEwODtzOjc2OiJcKFxzKlwkX1NFUlZFUlxbXHMqWyciXXswLDF9SFRUUF9SRUZFUkVSWyciXXswLDF9XHMqXF1ccyosXHMqWyciXXswLDF9Z29vZ2xlIjtpOjEwOTtzOjg6Ii9rcnlha2kvIjtpOjExMDtzOjEwOiJcLnBocFw/XCQwIjtpOjExMTtzOjcxOiJyZXF1ZXN0XC5zZXJ2ZXJ2YXJpYWJsZXNcKFsnIl1IVFRQX1VTRVJfQUdFTlRbJyJdXClccyosXHMqWyciXUdvb2dsZWJvdCI7aToxMTI7czo4MDoiaW5kZXhcLnBocFw/bWFpbl9wYWdlPXByb2R1Y3RfaW5mbyZwcm9kdWN0c19pZD1bJyJdXHMqXC5ccypzdHJfcmVwbGFjZVwoWyciXWxpc3QiO2k6MTEzO3M6MzE6ImZzb2Nrb3BlblwoXHMqWyciXXNoYWR5a2l0XC5jb20iO2k6MTE0O3M6MTA6ImVvamlldVwuY24iO2k6MTE1O3M6MjI6Ij5ccyo8L2lmcmFtZT5ccyo8XD9waHAiO2k6MTE2O3M6ODE6IjxtZXRhXHMraHR0cC1lcXVpdj1bJyJdezAsMX1yZWZyZXNoWyciXXswLDF9XHMrY29udGVudD1bJyJdezAsMX1cZCs7XHMqdXJsPTxcP3BocCI7aToxMTc7czo4MjoiPG1ldGFccytodHRwLWVxdWl2PVsnIl17MCwxfVJlZnJlc2hbJyJdezAsMX1ccytjb250ZW50PVsnIl17MCwxfVxkKztccypVUkw9aHR0cDovLyI7aToxMTg7czo2NzoiXCRmbFxzKj1ccyoiPG1ldGEgaHR0cC1lcXVpdj1cXCJSZWZyZXNoXFwiXHMrY29udGVudD1cXCJcZCs7XHMqVVJMPSI7aToxMTk7czozODoiUmV3cml0ZUNvbmRccyole0hUVFBfUkVGRVJFUn1ccyp5YW5kZXgiO2k6MTIwO3M6Mzg6IlJld3JpdGVDb25kXHMqJXtIVFRQX1JFRkVSRVJ9XHMqZ29vZ2xlIjtpOjEyMTtzOjU3OiJPcHRpb25zXHMrRm9sbG93U3ltTGlua3NccytNdWx0aVZpZXdzXHMrSW5kZXhlc1xzK0V4ZWNDR0kiO2k6MTIyO3M6Mjg6Imdvb2dsZVx8eWFuZGV4XHxib3RcfHJhbWJsZXIiO2k6MTIzO3M6NDE6ImNvbnRlbnQ9WyciXXswLDF9MTtVUkw9Y2dpLWJpblwuaHRtbFw/Y21kIjtpOjEyNDtzOjEyOiJhbmRleFx8b29nbGUiO2k6MTI1O3M6NDQ6ImhlYWRlclwoXHMqWyciXVJlZnJlc2g6XHMqXGQrO1xzKlVSTD1odHRwOi8vIjtpOjEyNjtzOjQ1OiJNb3ppbGxhLzVcLjBccypcKGNvbXBhdGlibGU7XHMqR29vZ2xlYm90LzJcLjEiO2k6MTI3O3M6NTA6Imh0dHA6Ly93d3dcLmJpbmdcLmNvbS9zZWFyY2hcP3E9XCRxdWVyeSZwcT1cJHF1ZXJ5IjtpOjEyODtzOjQzOiJodHRwOi8vZ29cLm1haWxcLnJ1L3NlYXJjaFw/cT1bJyJdXC5cJHF1ZXJ5IjtpOjEyOTtzOjYzOiJodHRwOi8vd3d3XC5nb29nbGVcLmNvbS9zZWFyY2hcP3E9WyciXVwuXCRxdWVyeVwuWyciXSZobD1cJGxhbmciO2k6MTMwO3M6MzY6IlNldEhhbmRsZXJccythcHBsaWNhdGlvbi94LWh0dHBkLXBocCI7aToxMzE7czo0OToiaWZcKHN0cmlwb3NcKFwkdWEsWyciXWFuZHJvaWRbJyJdXClccyohPT1ccypmYWxzZSI7aToxMzI7czoxNTI6IihzZXh5XHMrbGVzYmlhbnN8Y3VtXHMrdmlkZW98c2V4XHMrdmlkZW98QW5hbFxzK0Z1Y2t8dGVlblxzK3NleHxmdWNrXHMrdmlkZW98QmVhY2hccytOdWRlfHdvbWFuXHMrcHVzc3l8c2V4XHMrcGhvdG98bmFrZWRccyt0ZWVufHh4eFxzK3ZpZGVvfHRlZW5ccytwaWMpIjtpOjEzMztzOjU2OiJodHRwLWVxdWl2PVsnIl1Db250ZW50LUxhbmd1YWdlWyciXVxzK2NvbnRlbnQ9WyciXWphWyciXSI7aToxMzQ7czo1NjoiaHR0cC1lcXVpdj1bJyJdQ29udGVudC1MYW5ndWFnZVsnIl1ccytjb250ZW50PVsnIl1jaFsnIl0iO2k6MTM1O3M6MTE6IktBUFBVU1RPQk9UIjtpOjEzNjtzOjM4OiJjbGFzc1xzK2xUcmFuc21pdGVye1xzKnZhclxzKlwkdmVyc2lvbiI7aToxMzc7czozODoiXCRbYS16QS1aMC05X10rP1xzKj1ccypbJyJdL3RtcC9zc2Vzc18iO2k6MTM4O3M6OTI6ImZpbGVfZ2V0X2NvbnRlbnRzXChiYXNlNjRfZGVjb2RlXChcJFthLXpBLVowLTlfXSs/XClcLlsnIl1cP1snIl1cLmh0dHBfYnVpbGRfcXVlcnlcKFwkX0dFVFwpIjtpOjEzOTtzOjUwOiJpbmlfc2V0XChbJyJdezAsMX11c2VyX2FnZW50WyciXVxzKixccypbJyJdSlNMSU5LUyI7aToxNDA7czo2MzoiXCRkYi0+cXVlcnlcKFsnIl1TRUxFQ1QgXCogRlJPTSBhcnRpY2xlIFdIRVJFIHVybD1bJyJdXCRyZXF1ZXN0IjtpOjE0MTtzOjI0OiI8aHRtbFxzK2xhbmc9WyciXWphWyciXT4iO2k6MTQyO3M6Mzc6InhtbDpsYW5nPVsnIl1qYVsnIl1ccytsYW5nPVsnIl1qYVsnIl0iO2k6MTQzO3M6MTY6Imxhbmc9WyciXWphWyciXT4iO2k6MTQ0O3M6MzM6InN0cnBvc1woXCRpbSxbJyJdXFsvVVBEX0NPTlRFTlRcXSI7fQ=="));
$g_PhishingSig = unserialize(base64_decode("YTo4OTp7aTowO3M6MTE6IkNWVjpccypcJGN2IjtpOjE7czoxMzoiSW52YWxpZFxzK1RWTiI7aToyO3M6MTE6IkludmFsaWQgUlZOIjtpOjM7czo0MDoiZGVmYXVsdFN0YXR1c1xzKj1ccypbJyJdSW50ZXJuZXQgQmFua2luZyI7aTo0O3M6Mjg6Ijx0aXRsZT5ccypDYXBpdGVjXHMrSW50ZXJuZXQiO2k6NTtzOjI3OiI8dGl0bGU+XHMqSW52ZXN0ZWNccytPbmxpbmUiO2k6NjtzOjM5OiJpbnRlcm5ldFxzK1BJTlxzK251bWJlclxzK2lzXHMrcmVxdWlyZWQiO2k6NztzOjExOiI8dGl0bGU+U2FycyI7aTo4O3M6MTM6Ijxicj5BVE1ccytQSU4iO2k6OTtzOjE4OiJDb25maXJtYXRpb25ccytPVFAiO2k6MTA7czoyNToiPHRpdGxlPlxzKkFic2FccytJbnRlcm5ldCI7aToxMTtzOjIxOiItXHMqUGF5UGFsXHMqPC90aXRsZT4iO2k6MTI7czoxOToiPHRpdGxlPlxzKlBheVxzKlBhbCI7aToxMztzOjIyOiItXHMqUHJpdmF0aVxzKjwvdGl0bGU+IjtpOjE0O3M6MTk6Ijx0aXRsZT5ccypVbmlDcmVkaXQiO2k6MTU7czoxOToiQmFua1xzK29mXHMrQW1lcmljYSI7aToxNjtzOjI1OiJBbGliYWJhJm5ic3A7TWFudWZhY3R1cmVyIjtpOjE3O3M6MjA6IlZlcmlmaWVkXHMrYnlccytWaXNhIjtpOjE4O3M6MjE6IkhvbmdccytMZW9uZ1xzK09ubGluZSI7aToxOTtzOjMwOiJZb3VyXHMrYWNjb3VudFxzK1x8XHMrTG9nXHMraW4iO2k6MjA7czoyNDoiPHRpdGxlPlxzKk9ubGluZSBCYW5raW5nIjtpOjIxO3M6MjQ6Ijx0aXRsZT5ccypPbmxpbmUtQmFua2luZyI7aToyMjtzOjIyOiJTaWduXHMraW5ccyt0b1xzK1lhaG9vIjtpOjIzO3M6MTY6IllhaG9vXHMqPC90aXRsZT4iO2k6MjQ7czoxMToiQkFOQ09MT01CSUEiO2k6MjU7czoxNjoiPHRpdGxlPlxzKkFtYXpvbiI7aToyNjtzOjE1OiI8dGl0bGU+XHMqQXBwbGUiO2k6Mjc7czoxNToiPHRpdGxlPlxzKkdtYWlsIjtpOjI4O3M6Mjg6Ikdvb2dsZVxzK0FjY291bnRzXHMqPC90aXRsZT4iO2k6Mjk7czoyNToiPHRpdGxlPlxzKkdvb2dsZVxzK1NlY3VyZSI7aTozMDtzOjMxOiI8dGl0bGU+XHMqTWVyYWtccytNYWlsXHMrU2VydmVyIjtpOjMxO3M6MjY6Ijx0aXRsZT5ccypTb2NrZXRccytXZWJtYWlsIjtpOjMyO3M6MjE6Ijx0aXRsZT5ccypcW0xfUVVFUllcXSI7aTozMztzOjM0OiI8dGl0bGU+XHMqQU5aXHMrSW50ZXJuZXRccytCYW5raW5nIjtpOjM0O3M6MzM6ImNvbVwud2Vic3RlcmJhbmtcLnNlcnZsZXRzXC5Mb2dpbiI7aTozNTtzOjE1OiI8dGl0bGU+XHMqR21haWwiO2k6MzY7czoxODoiPHRpdGxlPlxzKkZhY2Vib29rIjtpOjM3O3M6MzY6IlxkKztVUkw9aHR0cHM6Ly93d3dcLndlbGxzZmFyZ29cLmNvbSI7aTozODtzOjIzOiI8dGl0bGU+XHMqV2VsbHNccypGYXJnbyI7aTozOTtzOjQ5OiJwcm9wZXJ0eT0ib2c6c2l0ZV9uYW1lIlxzKmNvbnRlbnQ9IkZhY2Vib29rIlxzKi8+IjtpOjQwO3M6MjI6IkFlc1wuQ3RyXC5kZWNyeXB0XHMqXCgiO2k6NDE7czoxNzoiPHRpdGxlPlxzKkFsaWJhYmEiO2k6NDI7czoxOToiUmFib2Jhbmtccyo8L3RpdGxlPiI7aTo0MztzOjM1OiJcJG1lc3NhZ2VccypcLj1ccypbJyJdezAsMX1QYXNzd29yZCI7aTo0NDtzOjYzOiJcJENWVjJDXHMqPVxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtccypbJyJdQ1ZWMkMiO2k6NDU7czoxNDoiQ1ZWMjpccypcJENWVjIiO2k6NDY7czoxODoiXC5odG1sXD9jbWQ9bG9naW49IjtpOjQ3O3M6MTg6IldlYm1haWxccyo8L3RpdGxlPiI7aTo0ODtzOjIzOiI8dGl0bGU+XHMqVVBDXHMrV2VibWFpbCI7aTo0OTtzOjE3OiJcLnBocFw/Y21kPWxvZ2luPSI7aTo1MDtzOjE3OiJcLmh0bVw/Y21kPWxvZ2luPSI7aTo1MTtzOjIzOiJcLnN3ZWRiYW5rXC5zZS9tZHBheWFjcyI7aTo1MjtzOjI0OiJcLlxzKlwkX1BPU1RcW1xzKlsnIl1jdnYiO2k6NTM7czoyMDoiPHRpdGxlPlxzKkxBTkRFU0JBTksiO2k6NTQ7czoxMDoiQlktU1AxTjBaQSI7aTo1NTtzOjQ1OiJTZWN1cml0eVxzK3F1ZXN0aW9uXHMrOlxzK1snIl1ccypcLlxzKlwkX1BPU1QiO2k6NTY7czo0MDoiaWZcKFxzKmZpbGVfZXhpc3RzXChccypcJHNjYW1ccypcLlxzKlwkaSI7aTo1NztzOjIwOiI8dGl0bGU+XHMqQmVzdC50aWdlbiI7aTo1ODtzOjIwOiI8dGl0bGU+XHMqTEFOREVTQkFOSyI7aTo1OTtzOjUyOiJ3aW5kb3dcLmxvY2F0aW9uXHMqPVxzKlsnIl1pbmRleFxkKypcLnBocFw/Y21kPWxvZ2luIjtpOjYwO3M6NTQ6IndpbmRvd1wubG9jYXRpb25ccyo9XHMqWyciXWluZGV4XGQrKlwuaHRtbCpcP2NtZD1sb2dpbiI7aTo2MTtzOjI1OiI8dGl0bGU+XHMqTWFpbFxzKjwvdGl0bGU+IjtpOjYyO3M6Mjg6IlNpZVxzK0loclxzK0tvbnRvXHMqPC90aXRsZT4iO2k6NjM7czoyOToiUGF5cGFsXHMrS29udG9ccyt2ZXJpZml6aWVyZW4iO2k6NjQ7czozMDoiXCRfR0VUXFtccypbJyJdY2NfY291bnRyeV9jb2RlIjtpOjY1O3M6Mjk6Ijx0aXRsZT5PdXRsb29rXHMrV2ViXHMrQWNjZXNzIjtpOjY2O3M6OToiX0NBUlRBU0lfIjtpOjY3O3M6NzY6IjxtZXRhXHMraHR0cC1lcXVpdj1bJyJdcmVmcmVzaFsnIl1ccypjb250ZW50PSJcZCs7XHMqdXJsPWRhdGE6dGV4dC9odG1sO2h0dHAiO2k6Njg7czozMDoiY2FuXHMqc2lnblxzKmluXHMqdG9ccypkcm9wYm94IjtpOjY5O3M6MzU6IlxkKztccypVUkw9aHR0cHM6Ly93d3dcLmdvb2dsZVwuY29tIjtpOjcwO3M6MjY6Im1haWxcLnJ1L3NldHRpbmdzL3NlY3VyaXR5IjtpOjcxO3M6NTk6IkxvY2F0aW9uOlxzKmh0dHBzOi8vc2VjdXJpdHlcLmdvb2dsZVwuY29tL3NldHRpbmdzL3NlY3VyaXR5IjtpOjcyO3M6NjU6IlwkaXBccyo9XHMqZ2V0ZW52XChccypbJyJdUkVNT1RFX0FERFJbJyJdXHMqXCk7XHMqXCRtZXNzYWdlXHMqXC49IjtpOjczO3M6MTc6ImxvZ2luXC5lYzIxXC5jb20vIjtpOjc0O3M6NjA6IlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtbJyJdezAsMX1jdnZbJyJdezAsMX1cXSI7aTo3NTtzOjM0OiJcJGFkZGRhdGU9ZGF0ZVwoIkQgTSBkLCBZIGc6aSBhIlwpIjtpOjc2O3M6MzY6IlwkZGF0YW1hc2lpPWRhdGVcKCJEIE0gZCwgWSBnOmkgYSJcKSI7aTo3NztzOjI3OiJodHRwczovL2FwcGxlaWRcLmFwcGxlXC5jb20iO2k6Nzg7czoxNDoiLUFwcGxlX1Jlc3VsdC0iO2k6Nzk7czoxMzoiQU9MXHMrRGV0YWlscyI7aTo4MDtzOjQzOiJcJF9QT1NUXFtccypbJyJdezAsMX1lTWFpbEFkZFsnIl17MCwxfVxzKlxdIjtpOjgxO3M6NDA6ImJhc2VccytocmVmPVsnIl1odHRwczovL2xvZ2luXC5saXZlXC5jb20iO2k6ODI7czoyNDoiPHRpdGxlPkhvdG1haWxccytBY2NvdW50IjtpOjgzO3M6NDE6IjwhLS1ccytzYXZlZFxzK2Zyb21ccyt1cmw9XChcZCtcKWh0dHBzOi8vIjtpOjg0O3M6MjA6IkJhbmtccytvZlxzK01vbnRyZWFsIjtpOjg1O3M6MjE6InNlY3VyZVwudGFuZ2VyaW5lXC5jYSI7aTo4NjtzOjIyOiJibW9cLmNvbS9vbmxpbmViYW5raW5nIjtpOjg3O3M6NDE6InBtX2ZwPXZlcnNpb24mc3RhdGU9MSZzYXZlRkJDPSZGQkNfTnVtYmVyIjtpOjg4O3M6MjE6ImNpYmNvbmxpbmVcLmNpYmNcLmNvbSI7fQ=="));
$g_JSVirSig = unserialize(base64_decode("YToxMzI6e2k6MDtzOjE0OiJ2PTA7dng9WyciXUNvZCI7aToxO3M6MjM6IkF0WyciXVxdXCh2XCtcK1wpLTFcKVwpIjtpOjI7czozMjoiQ2xpY2tVbmRlcmNvb2tpZVxzKj1ccypHZXRDb29raWUiO2k6MztzOjcwOiJ1c2VyQWdlbnRcfHBwXHxodHRwXHxkYXphbHl6WyciXXswLDF9XC5zcGxpdFwoWyciXXswLDF9XHxbJyJdezAsMX1cKSwwIjtpOjQ7czoyMjoiXC5wcm90b3R5cGVcLmF9Y2F0Y2hcKCI7aTo1O3M6Mzc6InRyeXtCb29sZWFuXChcKVwucHJvdG90eXBlXC5xfWNhdGNoXCgiO2k6NjtzOjM0OiJpZlwoUmVmXC5pbmRleE9mXCgnXC5nb29nbGVcLidcKSE9IjtpOjc7czo4NjoiaW5kZXhPZlx8aWZcfHJjXHxsZW5ndGhcfG1zblx8eWFob29cfHJlZmVycmVyXHxhbHRhdmlzdGFcfG9nb1x8YmlcfGhwXHx2YXJcfGFvbFx8cXVlcnkiO2k6ODtzOjYwOiJBcnJheVwucHJvdG90eXBlXC5zbGljZVwuY2FsbFwoYXJndW1lbnRzXClcLmpvaW5cKFsnIl1bJyJdXCkiO2k6OTtzOjgyOiJxPWRvY3VtZW50XC5jcmVhdGVFbGVtZW50XCgiZCJcKyJpIlwrInYiXCk7cVwuYXBwZW5kQ2hpbGRcKHFcKyIiXCk7fWNhdGNoXChxd1wpe2g9IjtpOjEwO3M6Nzk6Ilwreno7c3M9XFtcXTtmPSdmcidcKydvbSdcKydDaCc7ZlwrPSdhckMnO2ZcKz0nb2RlJzt3PXRoaXM7ZT13XFtmXFsic3Vic3RyIlxdXCgiO2k6MTE7czoxMTU6InM1XChxNVwpe3JldHVybiBcK1wrcTU7fWZ1bmN0aW9uIHlmXChzZix3ZVwpe3JldHVybiBzZlwuc3Vic3RyXCh3ZSwxXCk7fWZ1bmN0aW9uIHkxXCh3Ylwpe2lmXCh3Yj09MTY4XCl3Yj0xMDI1O2Vsc2UiO2k6MTI7czo2NDoiaWZcKG5hdmlnYXRvclwudXNlckFnZW50XC5tYXRjaFwoL1woYW5kcm9pZFx8bWlkcFx8ajJtZVx8c3ltYmlhbiI7aToxMztzOjEwNjoiZG9jdW1lbnRcLndyaXRlXCgnPHNjcmlwdCBsYW5ndWFnZT0iSmF2YVNjcmlwdCIgdHlwZT0idGV4dC9qYXZhc2NyaXB0IiBzcmM9IidcK2RvbWFpblwrJyI+PC9zY3InXCsnaXB0PidcKSI7aToxNDtzOjMxOiJodHRwOi8vcGhzcFwucnUvXy9nb1wucGhwXD9zaWQ9IjtpOjE1O3M6NjY6Ij1uYXZpZ2F0b3JcW2FwcFZlcnNpb25fdmFyXF1cLmluZGV4T2ZcKCJNU0lFIlwpIT0tMVw/JzxpZnJhbWUgbmFtZSI7aToxNjtzOjc6IlxceDY1QXQiO2k6MTc7czo5OiJcXHg2MXJDb2QiO2k6MTg7czoyMjoiImZyIlwrIm9tQyJcKyJoYXJDb2RlIiI7aToxOTtzOjExOiI9ImV2IlwrImFsIiI7aToyMDtzOjc4OiJcW1woXChlXClcPyJzIjoiIlwpXCsicCJcKyJsaXQiXF1cKCJhXCQiXFtcKFwoZVwpXD8ic3UiOiIiXClcKyJic3RyIlxdXCgxXClcKTsiO2k6MjE7czozOToiZj0nZnInXCsnb20nXCsnQ2gnO2ZcKz0nYXJDJztmXCs9J29kZSc7IjtpOjIyO3M6MjA6ImZcKz1cKGhcKVw/J29kZSc6IiI7IjtpOjIzO3M6NDE6ImY9J2YnXCsncidcKydvJ1wrJ20nXCsnQ2gnXCsnYXJDJ1wrJ29kZSc7IjtpOjI0O3M6NTA6ImY9J2Zyb21DaCc7ZlwrPSdhckMnO2ZcKz0ncWdvZGUnXFsic3Vic3RyIlxdXCgyXCk7IjtpOjI1O3M6MTY6InZhclxzK2Rpdl9jb2xvcnMiO2k6MjY7czo5OiJ2YXJccytfMHgiO2k6Mjc7czoyMDoiQ29yZUxpYnJhcmllc0hhbmRsZXIiO2k6Mjg7czo3OiJwaW5nbm93IjtpOjI5O3M6ODoic2VyY2hib3QiO2k6MzA7czoxMDoia20wYWU5Z3I2bSI7aTozMTtzOjY6ImMzMjg0ZCI7aTozMjtzOjg6IlxceDY4YXJDIjtpOjMzO3M6ODoiXFx4NmRDaGEiO2k6MzQ7czo3OiJcXHg2ZmRlIjtpOjM1O3M6NzoiXFx4NmZkZSI7aTozNjtzOjg6IlxceDQzb2RlIjtpOjM3O3M6NzoiXFx4NzJvbSI7aTozODtzOjc6IlxceDQzaGEiO2k6Mzk7czo3OiJcXHg3MkNvIjtpOjQwO3M6ODoiXFx4NDNvZGUiO2k6NDE7czoxMDoiXC5keW5kbnNcLiI7aTo0MjtzOjk6IlwuZHluZG5zLSI7aTo0MztzOjc5OiJ9XHMqZWxzZVxzKntccypkb2N1bWVudFwud3JpdGVccypcKFxzKlsnIl17MCwxfVwuWyciXXswLDF9XClccyp9XHMqfVxzKlJcKFxzKlwpIjtpOjQ0O3M6NDU6ImRvY3VtZW50XC53cml0ZVwodW5lc2NhcGVcKCclM0NkaXYlMjBpZCUzRCUyMiI7aTo0NTtzOjE4OiJcLmJpdGNvaW5wbHVzXC5jb20iO2k6NDY7czo0MToiXC5zcGxpdFwoIiYmIlwpO2g9MjtzPSIiO2lmXChtXClmb3JcKGk9MDsiO2k6NDc7czo0MToiPGlmcmFtZVxzK3NyYz0iaHR0cDovL2RlbHV4ZXNjbGlja3NcLnByby8iO2k6NDg7czo0NToiM0Jmb3JcfGZyb21DaGFyQ29kZVx8MkMyN1x8M0RcfDJDODhcfHVuZXNjYXBlIjtpOjQ5O3M6NTg6Ijtccypkb2N1bWVudFwud3JpdGVcKFsnIl17MCwxfTxpZnJhbWVccypzcmM9Imh0dHA6Ly95YVwucnUiO2k6NTA7czoxMTA6IndcLmRvY3VtZW50XC5ib2R5XC5hcHBlbmRDaGlsZFwoc2NyaXB0XCk7XHMqY2xlYXJJbnRlcnZhbFwoaVwpO1xzKn1ccyp9XHMqLFxzKlxkK1xzKlwpXHMqO1xzKn1ccypcKVwoXHMqd2luZG93IjtpOjUxO3M6MTEwOiJpZlwoIWdcKFwpJiZ3aW5kb3dcLm5hdmlnYXRvclwuY29va2llRW5hYmxlZFwpe2RvY3VtZW50XC5jb29raWU9IjE9MTtleHBpcmVzPSJcK2VcLnRvR01UU3RyaW5nXChcKVwrIjtwYXRoPS8iOyI7aTo1MjtzOjcwOiJubl9wYXJhbV9wcmVsb2FkZXJfY29udGFpbmVyXHw1MDAxXHxoaWRkZW5cfGlubmVySFRNTFx8aW5qZWN0XHx2aXNpYmxlIjtpOjUzO3M6MzA6IjwhLS1bYS16QS1aMC05X10rP1x8XHxzdGF0IC0tPiI7aTo1NDtzOjg1OiImcGFyYW1ldGVyPVwka2V5d29yZCZzZT1cJHNlJnVyPTEmSFRUUF9SRUZFUkVSPSdcK2VuY29kZVVSSUNvbXBvbmVudFwoZG9jdW1lbnRcLlVSTFwpIjtpOjU1O3M6NDg6IndpbmRvd3NcfHNlcmllc1x8NjBcfHN5bWJvc1x8Y2VcfG1vYmlsZVx8c3ltYmlhbiI7aTo1NjtzOjM1OiJcW1snIl1ldmFsWyciXVxdXChzXCk7fX19fTwvc2NyaXB0PiI7aTo1NztzOjU5OiJrQzcwRk1ibHlKa0ZXWm9kQ0tsMVdZT2RXWVVsblF6Um5ibDFXWnNWRWRsZG1MMDVXWnRWM1l2UkdJOSI7aTo1ODtzOjU1OiJ7az1pO3M9c1wuY29uY2F0XChzc1woZXZhbFwoYXNxXChcKVwpLTFcKVwpO316PXM7ZXZhbFwoIjtpOjU5O3M6MTMwOiJkb2N1bWVudFwuY29va2llXC5tYXRjaFwobmV3XHMrUmVnRXhwXChccyoiXChcPzpcXlx8OyBcKSJccypcK1xzKm5hbWVcLnJlcGxhY2VcKC9cKFxbXFxcLlwkXD9cKlx8e31cXFwoXFxcKVxcXFtcXFxdXFwvXFxcK1xeXF1cKS9nIjtpOjYwO3M6ODY6InNldENvb2tpZVxzKlwoKlxzKiJhcnhfdHQiXHMqLFxzKjFccyosXHMqZHRcLnRvR01UU3RyaW5nXChcKVxzKixccypbJyJdezAsMX0vWyciXXswLDF9IjtpOjYxO3M6MTQ0OiJkb2N1bWVudFwuY29va2llXC5tYXRjaFxzKlwoXHMqbmV3XHMrUmVnRXhwXHMqXChccyoiXChcPzpcXlx8O1xzKlwpIlxzKlwrXHMqbmFtZVwucmVwbGFjZVxzKlwoL1woXFtcXFwuXCRcP1wqXHx7fVxcXChcXFwpXFxcW1xcXF1cXC9cXFwrXF5cXVwpL2ciO2k6NjI7czo5ODoidmFyXHMrZHRccys9XHMrbmV3XHMrRGF0ZVwoXCksXHMrZXhwaXJ5VGltZVxzKz1ccytkdFwuc2V0VGltZVwoXHMrZHRcLmdldFRpbWVcKFwpXHMrXCtccys5MDAwMDAwMDAiO2k6NjM7czoxMDU6ImlmXHMqXChccypudW1ccyo9PT1ccyowXHMqXClccyp7XHMqcmV0dXJuXHMqMTtccyp9XHMqZWxzZVxzKntccypyZXR1cm5ccytudW1ccypcKlxzKnJGYWN0XChccypudW1ccyotXHMqMSI7aTo2NDtzOjQxOiJcKz1TdHJpbmdcLmZyb21DaGFyQ29kZVwocGFyc2VJbnRcKDBcKyd4JyI7aTo2NTtzOjgzOiI8c2NyaXB0XHMrbGFuZ3VhZ2U9IkphdmFTY3JpcHQiPlxzKnBhcmVudFwud2luZG93XC5vcGVuZXJcLmxvY2F0aW9uPSJodHRwOi8vdmtcLmNvbSI7aTo2NjtzOjQ0OiJsb2NhdGlvblwucmVwbGFjZVwoWyciXXswLDF9aHR0cDovL3Y1azQ1XC5ydSI7aTo2NztzOjEyOToiO3RyeXtcK1wrZG9jdW1lbnRcLmJvZHl9Y2F0Y2hcKHFcKXthYT1mdW5jdGlvblwoZmZcKXtmb3JcKGk9MDtpPHpcLmxlbmd0aDtpXCtcK1wpe3phXCs9U3RyaW5nXFtmZlxdXChlXCh2XCtcKHpcW2lcXVwpXCktMTJcKTt9fTt9IjtpOjY4O3M6MTQyOiJkb2N1bWVudFwud3JpdGVccypcKFsnIl17MCwxfTxbJyJdezAsMX1ccypcK1xzKnhcWzBcXVxzKlwrXHMqWyciXXswLDF9IFsnIl17MCwxfVxzKlwrXHMqeFxbNFxdXHMqXCtccypbJyJdezAsMX0+XC5bJyJdezAsMX1ccypcK3hccypcWzJcXVxzKlwrIjtpOjY5O3M6NjA6ImlmXCh0XC5sZW5ndGg9PTJcKXt6XCs9U3RyaW5nXC5mcm9tQ2hhckNvZGVcKHBhcnNlSW50XCh0XClcKyI7aTo3MDtzOjc0OiJ3aW5kb3dcLm9ubG9hZFxzKj1ccypmdW5jdGlvblwoXClccyp7XHMqaWZccypcKGRvY3VtZW50XC5jb29raWVcLmluZGV4T2ZcKCI7aTo3MTtzOjk3OiJcLnN0eWxlXC5oZWlnaHRccyo9XHMqWyciXXswLDF9MHB4WyciXXswLDF9O3dpbmRvd1wub25sb2FkXHMqPVxzKmZ1bmN0aW9uXChcKVxzKntkb2N1bWVudFwuY29va2llIjtpOjcyO3M6MTIyOiJcLnNyYz1cKFsnIl17MCwxfWh0cHM6WyciXXswLDF9PT1kb2N1bWVudFwubG9jYXRpb25cLnByb3RvY29sXD9bJyJdezAsMX1odHRwczovL3NzbFsnIl17MCwxfTpbJyJdezAsMX1odHRwOi8vWyciXXswLDF9XClcKyI7aTo3MztzOjMwOiI0MDRcLnBocFsnIl17MCwxfT5ccyo8L3NjcmlwdD4iO2k6NzQ7czo3NjoicHJlZ19tYXRjaFwoWyciXXswLDF9L3NhcGUvaVsnIl17MCwxfVxzKixccypcJF9TRVJWRVJcW1snIl17MCwxfUhUVFBfUkVGRVJFUiI7aTo3NTtzOjc0OiJkaXZcLmlubmVySFRNTFxzKlwrPVxzKlsnIl17MCwxfTxlbWJlZFxzK2lkPSJkdW1teTIiXHMrbmFtZT0iZHVtbXkyIlxzK3NyYyI7aTo3NjtzOjczOiJzZXRUaW1lb3V0XChbJyJdezAsMX1hZGROZXdPYmplY3RcKFwpWyciXXswLDF9LFxkK1wpO319fTthZGROZXdPYmplY3RcKFwpIjtpOjc3O3M6NTE6IlwoYj1kb2N1bWVudFwpXC5oZWFkXC5hcHBlbmRDaGlsZFwoYlwuY3JlYXRlRWxlbWVudCI7aTo3ODtzOjMwOiJDaHJvbWVcfGlQYWRcfGlQaG9uZVx8SUVNb2JpbGUiO2k6Nzk7czoxOToiXCQ6XCh7fVwrIiJcKVxbXCRcXSI7aTo4MDtzOjQ5OiI8L2lmcmFtZT5bJyJdXCk7XHMqdmFyXHMraj1uZXdccytEYXRlXChuZXdccytEYXRlIjtpOjgxO3M6NTM6Intwb3NpdGlvbjphYnNvbHV0ZTt0b3A6LTk5OTlweDt9PC9zdHlsZT48ZGl2XHMrY2xhc3M9IjtpOjgyO3M6MTI4OiJpZlxzKlwoXCh1YVwuaW5kZXhPZlwoWyciXXswLDF9Y2hyb21lWyciXXswLDF9XClccyo9PVxzKi0xXHMqJiZccyp1YVwuaW5kZXhPZlwoIndpbiJcKVxzKiE9XHMqLTFcKVxzKiYmXHMqbmF2aWdhdG9yXC5qYXZhRW5hYmxlZCI7aTo4MztzOjU4OiJwYXJlbnRcLndpbmRvd1wub3BlbmVyXC5sb2NhdGlvbj1bJyJdezAsMX1odHRwOi8vdmtcLmNvbVwuIjtpOjg0O3M6NDE6IlxdXC5zdWJzdHJcKDAsMVwpXCk7fX1yZXR1cm4gdGhpczt9LFxcdTAwIjtpOjg1O3M6Njg6ImphdmFzY3JpcHRcfGhlYWRcfHRvTG93ZXJDYXNlXHxjaHJvbWVcfHdpblx8amF2YUVuYWJsZWRcfGFwcGVuZENoaWxkIjtpOjg2O3M6MjE6ImxvYWRQTkdEYXRhXChzdHJGaWxlLCI7aTo4NztzOjIwOiJcKTtpZlwoIX5cKFsnIl17MCwxfSI7aTo4ODtzOjIzOiIvL1xzKlNvbWVcLmRldmljZXNcLmFyZSI7aTo4OTtzOjMyOiJ3aW5kb3dcLm9uZXJyb3Jccyo9XHMqa2lsbGVycm9ycyI7aTo5MDtzOjEwNToiY2hlY2tfdXNlcl9hZ2VudD1cW1xzKlsnIl17MCwxfUx1bmFzY2FwZVsnIl17MCwxfVxzKixccypbJyJdezAsMX1pUGhvbmVbJyJdezAsMX1ccyosXHMqWyciXXswLDF9TWFjaW50b3NoIjtpOjkxO3M6MTUzOiJkb2N1bWVudFwud3JpdGVcKFsnIl17MCwxfTxbJyJdezAsMX1cK1snIl17MCwxfWlbJyJdezAsMX1cK1snIl17MCwxfWZbJyJdezAsMX1cK1snIl17MCwxfXJbJyJdezAsMX1cK1snIl17MCwxfWFbJyJdezAsMX1cK1snIl17MCwxfW1bJyJdezAsMX1cK1snIl17MCwxfWUiO2k6OTI7czo0ODoic3RyaXBvc1wobmF2aWdhdG9yXC51c2VyQWdlbnRccyosXHMqbGlzdF9kYXRhXFtpIjtpOjkzO3M6MjY6ImlmXHMqXCghc2VlX3VzZXJfYWdlbnRcKFwpIjtpOjk0O3M6NDY6ImNcLmxlbmd0aFwpO31yZXR1cm5ccypbJyJdWyciXTt9aWZcKCFnZXRDb29raWUiO2k6OTU7czo3MDoiPHNjcmlwdFxzKnR5cGU9WyciXXswLDF9dGV4dC9qYXZhc2NyaXB0WyciXXswLDF9XHMqc3JjPVsnIl17MCwxfWZ0cDovLyI7aTo5NjtzOjQ4OiJpZlxzKlwoZG9jdW1lbnRcLmNvb2tpZVwuaW5kZXhPZlwoWyciXXswLDF9c2FicmkiO2k6OTc7czoxMjI6IndpbmRvd1wubG9jYXRpb249Yn1ccypcKVwoXHMqbmF2aWdhdG9yXC51c2VyQWdlbnRccypcfFx8XHMqbmF2aWdhdG9yXC52ZW5kb3JccypcfFx8XHMqd2luZG93XC5vcGVyYVxzKixccypbJyJdezAsMX1odHRwOi8vIjtpOjk4O3M6MTE2OiJcKTtccyppZlwoXHMqW2EtekEtWjAtOV9dKz9cLnRlc3RcKFxzKmRvY3VtZW50XC5yZWZlcnJlclxzKlwpXHMqJiZccypbYS16QS1aMC05X10rP1wpXHMqe1xzKmRvY3VtZW50XC5sb2NhdGlvblwuaHJlZiI7aTo5OTtzOjUzOiJpZlwoL0FuZHJvaWQvaVxbXzB4W2EtekEtWjAtOV9dKz9cW1xkK1xdXF1cKG5hdmlnYXRvciI7aToxMDA7czo2OToiZnVuY3Rpb25cKGFcKXtpZlwoYSYmWyciXWRhdGFbJyJdaW5cZCthJiZhXC5kYXRhXC5hXGQrJiZhXC5kYXRhXC5hXGQrIjtpOjEwMTtzOjU4OiJzXChvXCl9XCl9LGY9ZnVuY3Rpb25cKFwpe3ZhciB0LGk9SlNPTlwuc3RyaW5naWZ5XChlXCk7b1woIjtpOjEwMjtzOjEwNjoiPFxkK1xzK1xkKz1bJyJdXGQrL1xkK1xcWyciXVwrXFxbJyJdLlxcWyciXVwrXFxbJyJdLlsnIl1ccysuPVsnIl0uOi8vXGQrXFxbJyJdXCtcXFsnIl0uXC5cZCtcXFsnIl1cK1xcWyciXSI7aToxMDM7czoxMDc6InNldFRpbWVvdXRcKFxkK1wpO1xzKnZhclxzK2RlZmF1bHRfa2V5d29yZFxzKj1ccyplbmNvZGVVUklDb21wb25lbnRcKGRvY3VtZW50XC50aXRsZVwpO1xzKnZhclxzK3NlX3JlZmVycmVyIjtpOjEwNDtzOjk4OiI9ZG9jdW1lbnRcLnJlZmVycmVyO2lmXChSZWZcLmluZGV4T2ZcKFsnIl1cLmdvb2dsZVwuWyciXVwpIT0tMVx8XHxSZWZcLmluZGV4T2ZcKFsnIl1cLmJpbmdcLlsnIl1cKSI7aToxMDU7czoxNzoic2V4ZnJvbWluZGlhXC5jb20iO2k6MTA2O3M6MTE6ImZpbGVreFwuY29tIjtpOjEwNztzOjEzOiJzdHVtbWFublwubmV0IjtpOjEwODtzOjE0OiJ0b3BsYXlnYW1lXC5ydSI7aToxMDk7czoxNDoiaHR0cDovL3h6eFwucG0iO2k6MTEwO3M6MTg6IlwuaG9wdG9cLm1lL2pxdWVyeSI7aToxMTE7czoxMToibW9iaS1nb1wuaW4iO2k6MTEyO3M6MTg6ImJhbmtvZmFtZXJpY2FcLmNvbSI7aToxMTM7czoxNjoibXlmaWxlc3RvcmVcLmNvbSI7aToxMTQ7czoxNzoiZmlsZXN0b3JlNzJcLmluZm8iO2k6MTE1O3M6MTY6ImZpbGUyc3RvcmVcLmluZm8iO2k6MTE2O3M6MTU6InVybDJzaG9ydFwuaW5mbyI7aToxMTc7czoxODoiZmlsZXN0b3JlMTIzXC5pbmZvIjtpOjExODtzOjEyOiJ1cmwxMjNcLmluZm8iO2k6MTE5O3M6MTQ6ImRvbGxhcmFkZVwuY29tIjtpOjEyMDtzOjExOiJzZWNjbGlrXC5ydSI7aToxMjE7czoxMToibW9ieS1hYVwucnUiO2k6MTIyO3M6MTI6InNlcnZsb2FkXC5ydSI7aToxMjM7czo3OiJubm5cLnBtIjtpOjEyNDtzOjc6Im5ubVwucG0iO2k6MTI1O3M6MTY6Im1vYi1yZWRpcmVjdFwucnUiO2k6MTI2O3M6MTY6IndlYi1yZWRpcmVjdFwucnUiO2k6MTI3O3M6MTY6InRvcC13ZWJwaWxsXC5jb20iO2k6MTI4O3M6MTk6Imdvb2RwaWxsc2VydmljZVwucnUiO2k6MTI5O3M6MTQ6InlvdXR1aWJlc1wuY29tIjtpOjEzMDtzOjE0OiJ1bnNjcmV3aW5nXC5ydSI7aToxMzE7czoyNjoibG9hZG1lXC5jaGlja2Vua2lsbGVyXC5jb20iO30="));
$gX_JSVirSig = unserialize(base64_decode("YTo2Nzp7aTowO3M6NDg6ImRvY3VtZW50XC53cml0ZVxzKlwoXHMqdW5lc2NhcGVccypcKFsnIl17MCwxfSUzYyI7aToxO3M6Njk6ImRvY3VtZW50XC5nZXRFbGVtZW50c0J5VGFnTmFtZVwoWyciXWhlYWRbJyJdXClcWzBcXVwuYXBwZW5kQ2hpbGRcKGFcKSI7aToyO3M6Mjg6ImlwXChob25lXHxvZFwpXHxpcmlzXHxraW5kbGUiO2k6MztzOjQ4OiJzbWFydHBob25lXHxibGFja2JlcnJ5XHxtdGtcfGJhZGFcfHdpbmRvd3MgcGhvbmUiO2k6NDtzOjMwOiJjb21wYWxcfGVsYWluZVx8ZmVubmVjXHxoaXB0b3AiO2k6NTtzOjIyOiJlbGFpbmVcfGZlbm5lY1x8aGlwdG9wIjtpOjY7czoyOToiXChmdW5jdGlvblwoYSxiXCl7aWZcKC9cKGFuZHIiO2k6NztzOjQ5OiJpZnJhbWVcLnN0eWxlXC53aWR0aFxzKj1ccypbJyJdezAsMX0wcHhbJyJdezAsMX07IjtpOjg7czo1NToic3RyaXBvc1xzKlwoXHMqZl9oYXlzdGFja1xzKixccypmX25lZWRsZVxzKixccypmX29mZnNldCI7aTo5O3M6MTAxOiJkb2N1bWVudFwuY2FwdGlvbj1udWxsO3dpbmRvd1wuYWRkRXZlbnRcKFsnIl17MCwxfWxvYWRbJyJdezAsMX0sZnVuY3Rpb25cKFwpe3ZhciBjYXB0aW9uPW5ldyBKQ2FwdGlvbiI7aToxMDtzOjEyOiJodHRwOi8vZnRwXC4iO2k6MTE7czo3ODoiPHNjcmlwdFxzKnR5cGU9WyciXXswLDF9dGV4dC9qYXZhc2NyaXB0WyciXXswLDF9XHMqc3JjPVsnIl17MCwxfWh0dHA6Ly9nb29cLmdsIjtpOjEyO3M6Njc6IiJccypcK1xzKm5ldyBEYXRlXChcKVwuZ2V0VGltZVwoXCk7XHMqZG9jdW1lbnRcLmJvZHlcLmFwcGVuZENoaWxkXCgiO2k6MTM7czozNDoiXC5pbmRleE9mXChccypbJyJdSUJyb3dzZVsnIl1ccypcKSI7aToxNDtzOjg3OiI9ZG9jdW1lbnRcLnJlZmVycmVyO1xzKlthLXpBLVowLTlfXSs/PXVuZXNjYXBlXChccypbYS16QS1aMC05X10rP1xzKlwpO1xzKnZhclxzK0V4cERhdGUiO2k6MTU7czo3NDoiPCEtLVxzKlthLXpBLVowLTlfXSs/XHMqLS0+PHNjcmlwdC4rPzwvc2NyaXB0PjwhLS0vXHMqW2EtekEtWjAtOV9dKz9ccyotLT4iO2k6MTY7czozNToiZXZhbFxzKlwoXHMqZGVjb2RlVVJJQ29tcG9uZW50XHMqXCgiO2k6MTc7czo3Mjoid2hpbGVcKFxzKmY8XGQrXHMqXClkb2N1bWVudFxbXHMqW2EtekEtWjAtOV9dKz9cK1snIl10ZVsnIl1ccypcXVwoU3RyaW5nIjtpOjE4O3M6ODE6InNldENvb2tpZVwoXHMqXzB4W2EtekEtWjAtOV9dKz9ccyosXHMqXzB4W2EtekEtWjAtOV9dKz9ccyosXHMqXzB4W2EtekEtWjAtOV9dKz9cKSI7aToxOTtzOjI5OiJcXVwoXHMqdlwrXCtccypcKS0xXHMqXClccypcKSI7aToyMDtzOjQ0OiJkb2N1bWVudFxbXHMqXzB4W2EtekEtWjAtOV9dKz9cW1xkK1xdXHMqXF1cKCI7aToyMTtzOjI4OiIvZyxbJyJdWyciXVwpXC5zcGxpdFwoWyciXVxdIjtpOjIyO3M6NDM6IndpbmRvd1wubG9jYXRpb249Yn1cKVwobmF2aWdhdG9yXC51c2VyQWdlbnQiO2k6MjM7czoyMjoiWyciXXJlcGxhY2VbJyJdXF1cKC9cWyI7aToyNDtzOjEyNzoiaVxbXzB4W2EtekEtWjAtOV9dKz9cW1xkK1xdXF1cKFthLXpBLVowLTlfXSs/XFtfMHhbYS16QS1aMC05X10rP1xbXGQrXF1cXVwoXGQrLFxkK1wpXClcKXt3aW5kb3dcW18weFthLXpBLVowLTlfXSs/XFtcZCtcXVxdPWxvYyI7aToyNTtzOjQ5OiJkb2N1bWVudFwud3JpdGVcKFxzKlN0cmluZ1wuZnJvbUNoYXJDb2RlXC5hcHBseVwoIjtpOjI2O3M6NTE6IlsnIl1cXVwoW2EtekEtWjAtOV9dKz9cK1wrXCktXGQrXCl9XChGdW5jdGlvblwoWyciXSI7aToyNztzOjY1OiI7d2hpbGVcKFthLXpBLVowLTlfXSs/PFxkK1wpZG9jdW1lbnRcWy4rP1xdXChTdHJpbmdcW1snIl1mcm9tQ2hhciI7aToyODtzOjEwOToiaWZccypcKFthLXpBLVowLTlfXSs/XC5pbmRleE9mXChkb2N1bWVudFwucmVmZXJyZXJcLnNwbGl0XChbJyJdL1snIl1cKVxbWyciXTJbJyJdXF1cKVxzKiE9XHMqWyciXS0xWyciXVwpXHMqeyI7aToyOTtzOjExNDoiZG9jdW1lbnRcLndyaXRlXChccypbJyJdPHNjcmlwdFxzK3R5cGU9WyciXXRleHQvamF2YXNjcmlwdFsnIl1ccypzcmM9WyciXS8vWyciXVxzKlwrXHMqU3RyaW5nXC5mcm9tQ2hhckNvZGVcLmFwcGx5IjtpOjMwO3M6Mzg6InByZWdfbWF0Y2hcKFsnIl1AXCh5YW5kZXhcfGdvb2dsZVx8Ym90IjtpOjMxO3M6MTM3OiJmYWxzZX07W2EtekEtWjAtOV9dKz89W2EtekEtWjAtOV9dKz9cKFsnIl1bYS16QS1aMC05X10rP1snIl1cKVx8W2EtekEtWjAtOV9dKz9cKFsnIl1bYS16QS1aMC05X10rP1snIl1cKTtbYS16QS1aMC05X10rP1x8PVthLXpBLVowLTlfXSs/OyI7aTozMjtzOjY1OiJTdHJpbmdcLmZyb21DaGFyQ29kZVwoXHMqW2EtekEtWjAtOV9dKz9cLmNoYXJDb2RlQXRcKGlcKVxzKlxeXHMqMiI7aTozMztzOjE2OiIuPVsnIl0uOi8vLlwuLi8uIjtpOjM0O3M6NTg6IlxbWyciXWNoYXJbJyJdXHMqXCtccypbYS16QS1aMC05X10rP1xzKlwrXHMqWyciXUF0WyciXVxdXCgiO2k6MzU7czo0OToic3JjPVsnIl0vL1snIl1ccypcK1xzKlN0cmluZ1wuZnJvbUNoYXJDb2RlXC5hcHBseSI7aTozNjtzOjU2OiJTdHJpbmdcW1xzKlsnIl1mcm9tQ2hhclsnIl1ccypcK1xzKlthLXpBLVowLTlfXSs/XHMqXF1cKCI7aTozNztzOjI4OiIuPVsnIl0uOi8vLlwuLlwuLlwuLi8uXC4uXC4uIjtpOjM4O3M6NDA6Ijwvc2NyaXB0PlsnIl1cKTtccyovXCovW2EtekEtWjAtOV9dKz9cKi8iO2k6Mzk7czo3MzoiZG9jdW1lbnRcW18weFxkK1xbXGQrXF1cXVwoXzB4XGQrXFtcZCtcXVwrXzB4XGQrXFtcZCtcXVwrXzB4XGQrXFtcZCtcXVwpOyI7aTo0MDtzOjUxOiJcKHNlbGY9PT10b3BcPzA6MVwpXCtbJyJdXC5qc1snIl0sYVwoZixmdW5jdGlvblwoXCkiO2k6NDE7czo5OiImYWR1bHQ9MSYiO2k6NDI7czo5ODoiZG9jdW1lbnRcLnJlYWR5U3RhdGVccys9PVxzK1snIl1jb21wbGV0ZVsnIl1cKVxzKntccypjbGVhckludGVydmFsXChbYS16QS1aMC05X10rP1wpO1xzKnNcLnNyY1xzKj0iO2k6NDM7czoxOToiLjovLy5cLi5cLi4vLlwuLlw/LyI7aTo0NDtzOjM5OiJcZCtccyo+XHMqXGQrXHMqXD9ccypbJyJdXFx4XGQrWyciXVxzKjoiO2k6NDU7czo0NToiWyciXVxbXHMqWyciXWNoYXJDb2RlQXRbJyJdXHMqXF1cKFxzKlxkK1xzKlwpIjtpOjQ2O3M6MTc6IjwvYm9keT5ccyo8c2NyaXB0IjtpOjQ3O3M6MTc6IjwvaHRtbD5ccyo8c2NyaXB0IjtpOjQ4O3M6MTc6IjwvaHRtbD5ccyo8aWZyYW1lIjtpOjQ5O3M6NDI6ImRvY3VtZW50XC53cml0ZVwoXHMqU3RyaW5nXC5mcm9tQ2hhckNvZGVcKCI7aTo1MDtzOjIyOiJzcmM9ImZpbGVzX3NpdGUvanNcLmpzIjtpOjUxO3M6OTQ6IndpbmRvd1wucG9zdE1lc3NhZ2VcKHtccyp6b3JzeXN0ZW06XHMqMSxccyp0eXBlOlxzKlsnIl11cGRhdGVbJyJdLFxzKnBhcmFtczpccyp7XHMqWyciXXVybFsnIl0iO2k6NTI7czoxMTM6IlthLXpBLVowLTlfXSs/XC5hdHRhY2hFdmVudFwoWyciXW9ubG9hZFsnIl0sYVwpOlthLXpBLVowLTlfXSs/XC5hZGRFdmVudExpc3RlbmVyXChbJyJdbG9hZFsnIl0sYSwhMVwpO2xvYWRNYXRjaGVyIjtpOjUzO3M6Nzg6ImlmXChcKGE9ZVwuZ2V0RWxlbWVudHNCeVRhZ05hbWVcKFsnIl1hWyciXVwpXCkmJmFcWzBcXSYmYVxbMFxdXC5ocmVmXClmb3JcKHZhciI7aTo1NDtzOjgxOiI7XHMqZWxlbWVudFwuaW5uZXJIVE1MXHMqPVxzKlsnIl08aWZyYW1lXHMrc3JjPVsnIl1ccypcK1xzKnhoclwucmVzcG9uc2VUZXh0XHMqXCsiO2k6NTU7czoxOToiWEhGRVIxXHMqPVxzKlhIRkVSMSI7aTo1NjtzOjUxOiJkb2N1bWVudFwud3JpdGVccypcKFxzKnVuZXNjYXBlXHMqXChccypbJyJdezAsMX0lM0MiO2k6NTc7czo3ODoiZG9jdW1lbnRcLndyaXRlXHMqXChccypbJyJdezAsMX08c2NyaXB0XHMrc3JjPVsnIl17MCwxfWh0dHA6Ly88XD89XCRkb21haW5cPz4vIjtpOjU4O3M6NTU6IndpbmRvd1wubG9jYXRpb25ccyo9XHMqWyciXWh0dHA6Ly9cZCtcLlxkK1wuXGQrXC5cZCsvXD8iO2k6NTk7czo2Njoic2V0VGltZW91dFwoZnVuY3Rpb25cKFwpe3ZhclxzK3BhdHRlcm5ccyo9XHMqbmV3XHMqUmVnRXhwXCgvZ29vZ2xlIjtpOjYwO3M6NjY6IndvPVsnIl1cKyEhXChbJyJdb250b3VjaHN0YXJ0WyciXVxzK2luXHMrd2luZG93XClcK1snIl0mc3Q9MSZ0aXRsZSI7aTo2MTtzOjU2OiJyZWZlcnJlclxzKiE9PVxzKlsnIl1bJyJdXCl7ZG9jdW1lbnRcLndyaXRlXChbJyJdPHNjcmlwdCI7aTo2MjtzOjM3OiJpZlwoYSYmWyciXWRhdGFbJyJdaW5ccyphJiZhXC5kYXRhXC5hIjtpOjYzO3M6NjA6ImpxdWVyeVwubWluXC5waHBbJyJdOyB2YXIgbl91cmwgPSBiYXNlIFwrICJcP2RlZmF1bHRfa2V5d29yZCI7aTo2NDtzOjkwOiJkb2N1bWVudFxbW2EtekEtWjAtOV9dKz9cKFthLXpBLVowLTlfXSs/XFtcZCtcXVwpXF1cKFthLXpBLVowLTlfXSs/XChbYS16QS1aMC05X10rP1xbXGQrXF0iO2k6NjU7czoxNToiXC50cnlteWZpbmdlclwuIjtpOjY2O3M6MTk6Ilwub25lc3RlcHRvd2luXC5jb20iO30="));
$g_SusDB = unserialize(base64_decode("YToxMzE6e2k6MDtzOjE0OiJAKmV4dHJhY3RccypcKCI7aToxO3M6MTQ6IkAqZXh0cmFjdFxzKlwkIjtpOjI7czoxMjoiWyciXWV2YWxbJyJdIjtpOjM7czoyMToiWyciXWJhc2U2NF9kZWNvZGVbJyJdIjtpOjQ7czoyMzoiWyciXWNyZWF0ZV9mdW5jdGlvblsnIl0iO2k6NTtzOjE0OiJbJyJdYXNzZXJ0WyciXSI7aTo2O3M6NDM6ImZvcmVhY2hccypcKFxzKlwkZW1haWxzXHMrYXNccytcJGVtYWlsXHMqXCkiO2k6NztzOjc6IlNwYW1tZXIiO2k6ODtzOjE1OiJldmFsXHMqWyciXChcJF0iO2k6OTtzOjE3OiJhc3NlcnRccypbJyJcKFwkXSI7aToxMDtzOjI4OiJzcnBhdGg6Ly9cLlwuL1wuXC4vXC5cLi9cLlwuIjtpOjExO3M6MTI6InBocGluZm9ccypcKCI7aToxMjtzOjE2OiJTSE9XXHMrREFUQUJBU0VTIjtpOjEzO3M6MTI6IlxicG9wZW5ccypcKCI7aToxNDtzOjk6ImV4ZWNccypcKCI7aToxNTtzOjEzOiJcYnN5c3RlbVxzKlwoIjtpOjE2O3M6MTU6IlxicGFzc3RocnVccypcKCI7aToxNztzOjE2OiJcYnByb2Nfb3BlblxzKlwoIjtpOjE4O3M6MTU6InNoZWxsX2V4ZWNccypcKCI7aToxOTtzOjE2OiJpbmlfcmVzdG9yZVxzKlwoIjtpOjIwO3M6OToiXGJkbFxzKlwoIjtpOjIxO3M6MTQ6Ilxic3ltbGlua1xzKlwoIjtpOjIyO3M6MTI6IlxiY2hncnBccypcKCI7aToyMztzOjE0OiJcYmluaV9zZXRccypcKCI7aToyNDtzOjEzOiJcYnB1dGVudlxzKlwoIjtpOjI1O3M6MTM6ImdldG15dWlkXHMqXCgiO2k6MjY7czoxNDoiZnNvY2tvcGVuXHMqXCgiO2k6Mjc7czoxNzoicG9zaXhfc2V0dWlkXHMqXCgiO2k6Mjg7czoxNzoicG9zaXhfc2V0c2lkXHMqXCgiO2k6Mjk7czoxODoicG9zaXhfc2V0cGdpZFxzKlwoIjtpOjMwO3M6MTU6InBvc2l4X2tpbGxccypcKCI7aTozMTtzOjI3OiJhcGFjaGVfY2hpbGRfdGVybWluYXRlXHMqXCgiO2k6MzI7czoxMjoiXGJjaG1vZFxzKlwoIjtpOjMzO3M6MTI6IlxiY2hkaXJccypcKCI7aTozNDtzOjE1OiJwY250bF9leGVjXHMqXCgiO2k6MzU7czoxNDoiXGJ2aXJ0dWFsXHMqXCgiO2k6MzY7czoxNToicHJvY19jbG9zZVxzKlwoIjtpOjM3O3M6MjA6InByb2NfZ2V0X3N0YXR1c1xzKlwoIjtpOjM4O3M6MTk6InByb2NfdGVybWluYXRlXHMqXCgiO2k6Mzk7czoxNDoicHJvY19uaWNlXHMqXCgiO2k6NDA7czoxMzoiZ2V0bXlnaWRccypcKCI7aTo0MTtzOjE5OiJwcm9jX2dldHN0YXR1c1xzKlwoIjtpOjQyO3M6MTU6InByb2NfY2xvc2VccypcKCI7aTo0MztzOjE5OiJlc2NhcGVzaGVsbGNtZFxzKlwoIjtpOjQ0O3M6MTk6ImVzY2FwZXNoZWxsYXJnXHMqXCgiO2k6NDU7czoxNjoic2hvd19zb3VyY2VccypcKCI7aTo0NjtzOjEzOiJcYnBjbG9zZVxzKlwoIjtpOjQ3O3M6MTM6InNhZmVfZGlyXHMqXCgiO2k6NDg7czoxNjoiaW5pX3Jlc3RvcmVccypcKCI7aTo0OTtzOjEwOiJjaG93blxzKlwoIjtpOjUwO3M6MTA6ImNoZ3JwXHMqXCgiO2k6NTE7czoxNzoic2hvd25fc291cmNlXHMqXCgiO2k6NTI7czoxOToibXlzcWxfbGlzdF9kYnNccypcKCI7aTo1MztzOjIxOiJnZXRfY3VycmVudF91c2VyXHMqXCgiO2k6NTQ7czoxMjoiZ2V0bXlpZFxzKlwoIjtpOjU1O3M6MTE6IlxibGVha1xzKlwoIjtpOjU2O3M6MTU6InBmc29ja29wZW5ccypcKCI7aTo1NztzOjIxOiJnZXRfY3VycmVudF91c2VyXHMqXCgiO2k6NTg7czoxMToic3lzbG9nXHMqXCgiO2k6NTk7czoxODoiXCRkZWZhdWx0X3VzZV9hamF4IjtpOjYwO3M6MjE6ImV2YWxccypcKCpccyp1bmVzY2FwZSI7aTo2MTtzOjc6IkZMb29kZVIiO2k6NjI7czozMToiZG9jdW1lbnRcLndyaXRlXHMqXChccyp1bmVzY2FwZSI7aTo2MztzOjExOiJcYmNvcHlccypcKCI7aTo2NDtzOjIzOiJtb3ZlX3VwbG9hZGVkX2ZpbGVccypcKCI7aTo2NTtzOjg6IlwuMzMzMzMzIjtpOjY2O3M6ODoiXC42NjY2NjYiO2k6Njc7czoyMToicm91bmRccypcKCpccyowXHMqXCkqIjtpOjY4O3M6MjQ6Im1vdmVfdXBsb2FkZWRfZmlsZXNccypcKCI7aTo2OTtzOjUwOiJpbmlfZ2V0XHMqXChccypbJyJdezAsMX1kaXNhYmxlX2Z1bmN0aW9uc1snIl17MCwxfSI7aTo3MDtzOjM2OiJVTklPTlxzK1NFTEVDVFxzK1snIl17MCwxfTBbJyJdezAsMX0iO2k6NzE7czoxMDoiMlxzKj5ccyomMSI7aTo3MjtzOjU3OiJlY2hvXHMqXCgqXHMqXCRfU0VSVkVSXFtbJyJdezAsMX1ET0NVTUVOVF9ST09UWyciXXswLDF9XF0iO2k6NzM7czozNzoiPVxzKkFycmF5XHMqXCgqXHMqYmFzZTY0X2RlY29kZVxzKlwoKiI7aTo3NDtzOjE0OiJraWxsYWxsXHMrLVxkKyI7aTo3NTtzOjc6ImVyaXVxZXIiO2k6NzY7czoxMDoidG91Y2hccypcKCI7aTo3NztzOjc6InNzaGtleXMiO2k6Nzg7czo4OiJAaW5jbHVkZSI7aTo3OTtzOjg6IkByZXF1aXJlIjtpOjgwO3M6NjI6ImlmXHMqXChtYWlsXHMqXChccypcJHRvLFxzKlwkc3ViamVjdCxccypcJG1lc3NhZ2UsXHMqXCRoZWFkZXJzIjtpOjgxO3M6Mzg6IkBpbmlfc2V0XHMqXCgqWyciXXswLDF9YWxsb3dfdXJsX2ZvcGVuIjtpOjgyO3M6MTg6IkBmaWxlX2dldF9jb250ZW50cyI7aTo4MztzOjE3OiJmaWxlX3B1dF9jb250ZW50cyI7aTo4NDtzOjQ2OiJhbmRyb2lkXHMqXHxccyptaWRwXHMqXHxccypqMm1lXHMqXHxccypzeW1iaWFuIjtpOjg1O3M6Mjg6IkBzZXRjb29raWVccypcKCpbJyJdezAsMX1oaXQiO2k6ODY7czoxMDoiQGZpbGVvd25lciI7aTo4NztzOjY6IjxrdWt1PiI7aTo4ODtzOjU6InN5cGV4IjtpOjg5O3M6OToiXCRiZWVjb2RlIjtpOjkwO3M6MTQ6InJvb3RAbG9jYWxob3N0IjtpOjkxO3M6ODoiQmFja2Rvb3IiO2k6OTI7czoxNDoicGhwX3VuYW1lXHMqXCgiO2k6OTM7czo1NToibWFpbFxzKlwoKlxzKlwkdG9ccyosXHMqXCRzdWJqXHMqLFxzKlwkbXNnXHMqLFxzKlwkZnJvbSI7aTo5NDtzOjI5OiJlY2hvXHMqWyciXTxzY3JpcHQ+XHMqYWxlcnRcKCI7aTo5NTtzOjY3OiJtYWlsXHMqXCgqXHMqXCRzZW5kXHMqLFxzKlwkc3ViamVjdFxzKixccypcJGhlYWRlcnNccyosXHMqXCRtZXNzYWdlIjtpOjk2O3M6NjU6Im1haWxccypcKCpccypcJHRvXHMqLFxzKlwkc3ViamVjdFxzKixccypcJG1lc3NhZ2VccyosXHMqXCRoZWFkZXJzIjtpOjk3O3M6MTIwOiJzdHJwb3NccypcKCpccypcJG5hbWVccyosXHMqWyciXXswLDF9SFRUUF9bJyJdezAsMX1ccypcKSpccyohPT1ccyowXHMqJiZccypzdHJwb3NccypcKCpccypcJG5hbWVccyosXHMqWyciXXswLDF9UkVRVUVTVF8iO2k6OTg7czo1MzoiaXNfZnVuY3Rpb25fZW5hYmxlZFxzKlwoXHMqWyciXXswLDF9aWdub3JlX3VzZXJfYWJvcnQiO2k6OTk7czozMDoiZWNob1xzKlwoKlxzKmZpbGVfZ2V0X2NvbnRlbnRzIjtpOjEwMDtzOjI2OiJlY2hvXHMqXCgqWyciXXswLDF9PHNjcmlwdCI7aToxMDE7czozMToicHJpbnRccypcKCpccypmaWxlX2dldF9jb250ZW50cyI7aToxMDI7czoyNzoicHJpbnRccypcKCpbJyJdezAsMX08c2NyaXB0IjtpOjEwMztzOjg1OiI8bWFycXVlZVxzK3N0eWxlXHMqPVxzKlsnIl17MCwxfXBvc2l0aW9uXHMqOlxzKmFic29sdXRlXHMqO1xzKndpZHRoXHMqOlxzKlxkK1xzKnB4XHMqIjtpOjEwNDtzOjQyOiI9XHMqWyciXXswLDF9XC5cLi9cLlwuL1wuXC4vd3AtY29uZmlnXC5waHAiO2k6MTA1O3M6NzoiZWdnZHJvcCI7aToxMDY7czo5OiJyd3hyd3hyd3giO2k6MTA3O3M6MTU6ImVycm9yX3JlcG9ydGluZyI7aToxMDg7czoxNzoiXGJjcmVhdGVfZnVuY3Rpb24iO2k6MTA5O3M6NDM6Intccypwb3NpdGlvblxzKjpccyphYnNvbHV0ZTtccypsZWZ0XHMqOlxzKi0iO2k6MTEwO3M6MTU6IjxzY3JpcHRccythc3luYyI7aToxMTE7czo2NjoiX1snIl17MCwxfVxzKlxdXHMqPVxzKkFycmF5XHMqXChccypiYXNlNjRfZGVjb2RlXHMqXCgqXHMqWyciXXswLDF9IjtpOjExMjtzOjMzOiJBZGRUeXBlXHMrYXBwbGljYXRpb24veC1odHRwZC1jZ2kiO2k6MTEzO3M6NDQ6ImdldGVudlxzKlwoKlxzKlsnIl17MCwxfUhUVFBfQ09PS0lFWyciXXswLDF9IjtpOjExNDtzOjQ1OiJpZ25vcmVfdXNlcl9hYm9ydFxzKlwoKlxzKlsnIl17MCwxfTFbJyJdezAsMX0iO2k6MTE1O3M6MjE6IlwkX1JFUVVFU1RccypcW1xzKiUyMiI7aToxMTY7czo1MToidXJsXHMqXChbJyJdezAsMX1kYXRhXHMqOlxzKmltYWdlL3BuZztccypiYXNlNjRccyosIjtpOjExNztzOjUxOiJ1cmxccypcKFsnIl17MCwxfWRhdGFccyo6XHMqaW1hZ2UvZ2lmO1xzKmJhc2U2NFxzKiwiO2k6MTE4O3M6MzA6Ijpccyp1cmxccypcKFxzKlsnIl17MCwxfTxcP3BocCI7aToxMTk7czoxNzoiPC9odG1sPi4rPzxzY3JpcHQiO2k6MTIwO3M6MTc6IjwvaHRtbD4uKz88aWZyYW1lIjtpOjEyMTtzOjY2OiJcYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXHMqWyciXChcJF0iO2k6MTIyO3M6MTE6IlxibWFpbFxzKlwoIjtpOjEyMztzOjQ2OiJmaWxlX2dldF9jb250ZW50c1xzKlwoKlxzKlsnIl17MCwxfXBocDovL2lucHV0IjtpOjEyNDtzOjExODoiPG1ldGFccytodHRwLWVxdWl2PVsnIl17MCwxfUNvbnRlbnQtdHlwZVsnIl17MCwxfVxzK2NvbnRlbnQ9WyciXXswLDF9dGV4dC9odG1sO1xzKmNoYXJzZXQ9d2luZG93cy0xMjUxWyciXXswLDF9Pjxib2R5PiI7aToxMjU7czo2MjoiPVxzKmRvY3VtZW50XC5jcmVhdGVFbGVtZW50XChccypbJyJdezAsMX1zY3JpcHRbJyJdezAsMX1ccypcKTsiO2k6MTI2O3M6Njk6ImRvY3VtZW50XC5ib2R5XC5pbnNlcnRCZWZvcmVcKGRpdixccypkb2N1bWVudFwuYm9keVwuY2hpbGRyZW5cWzBcXVwpOyI7aToxMjc7czo3NzoiPHNjcmlwdFxzK3R5cGU9InRleHQvamF2YXNjcmlwdCJccytzcmM9Imh0dHA6Ly9bYS16QS1aMC05X10rP1wucGhwIj48L3NjcmlwdD4iO2k6MTI4O3M6Mjc6ImVjaG9ccytbJyJdezAsMX1va1snIl17MCwxfSI7aToxMjk7czoxODoiL3Vzci9zYmluL3NlbmRtYWlsIjtpOjEzMDtzOjIzOiIvdmFyL3FtYWlsL2Jpbi9zZW5kbWFpbCI7fQ=="));
$g_SusDBPrio = unserialize(base64_decode("YToxMjE6e2k6MDtpOjA7aToxO2k6MDtpOjI7aTowO2k6MztpOjA7aTo0O2k6MDtpOjU7aTowO2k6NjtpOjA7aTo3O2k6MDtpOjg7aToxO2k6OTtpOjE7aToxMDtpOjA7aToxMTtpOjA7aToxMjtpOjA7aToxMztpOjA7aToxNDtpOjA7aToxNTtpOjA7aToxNjtpOjA7aToxNztpOjA7aToxODtpOjA7aToxOTtpOjA7aToyMDtpOjA7aToyMTtpOjA7aToyMjtpOjA7aToyMztpOjA7aToyNDtpOjA7aToyNTtpOjA7aToyNjtpOjA7aToyNztpOjA7aToyODtpOjA7aToyOTtpOjE7aTozMDtpOjE7aTozMTtpOjA7aTozMjtpOjA7aTozMztpOjA7aTozNDtpOjA7aTozNTtpOjA7aTozNjtpOjA7aTozNztpOjA7aTozODtpOjA7aTozOTtpOjA7aTo0MDtpOjA7aTo0MTtpOjA7aTo0MjtpOjA7aTo0MztpOjA7aTo0NDtpOjA7aTo0NTtpOjA7aTo0NjtpOjA7aTo0NztpOjA7aTo0ODtpOjA7aTo0OTtpOjA7aTo1MDtpOjA7aTo1MTtpOjA7aTo1MjtpOjA7aTo1MztpOjA7aTo1NDtpOjA7aTo1NTtpOjA7aTo1NjtpOjE7aTo1NztpOjA7aTo1ODtpOjA7aTo1OTtpOjI7aTo2MDtpOjE7aTo2MTtpOjA7aTo2MjtpOjA7aTo2MztpOjA7aTo2NDtpOjI7aTo2NTtpOjA7aTo2NjtpOjA7aTo2NztpOjA7aTo2ODtpOjI7aTo2OTtpOjE7aTo3MDtpOjA7aTo3MTtpOjA7aTo3MjtpOjE7aTo3MztpOjA7aTo3NDtpOjE7aTo3NTtpOjE7aTo3NjtpOjI7aTo3NztpOjE7aTo3ODtpOjM7aTo3OTtpOjI7aTo4MDtpOjA7aTo4MTtpOjI7aTo4MjtpOjA7aTo4MztpOjA7aTo4NDtpOjI7aTo4NTtpOjA7aTo4NjtpOjA7aTo4NztpOjA7aTo4ODtpOjA7aTo4OTtpOjE7aTo5MDtpOjE7aTo5MTtpOjE7aTo5MjtpOjE7aTo5MztpOjA7aTo5NDtpOjI7aTo5NTtpOjI7aTo5NjtpOjI7aTo5NztpOjI7aTo5ODtpOjI7aTo5OTtpOjE7aToxMDA7aToxO2k6MTAxO2k6MztpOjEwMjtpOjM7aToxMDM7aToxO2k6MTA0O2k6MztpOjEwNTtpOjM7aToxMDY7aToyO2k6MTA3O2k6MDtpOjEwODtpOjM7aToxMDk7aToxO2k6MTEwO2k6MTtpOjExMTtpOjM7aToxMTI7aTozO2k6MTEzO2k6MztpOjExNDtpOjE7aToxMTU7aToxO2k6MTE2O2k6MTtpOjExNztpOjQ7aToxMTg7aToxO2k6MTE5O2k6MztpOjEyMDtpOjA7fQ=="));

//END_SIG


////////////////////////////////////////////////////////////////////////////
if (!isCli() && !isset($_SERVER['HTTP_USER_AGENT'])) {
  echo "#####################################################\n";
  echo "# Error: cannot run on php-cgi. Requires php as cli #\n";
  echo "#                                                   #\n";
  echo "# See FAQ: http://revisium.com/ai/faq.php           #\n";
  echo "#####################################################\n";
  exit;
}


if (version_compare(phpversion(), '5.3.1', '<')) {
  echo "#####################################################\n";
  echo "# Warning: PHP Version < 5.3.1                      #\n";
  echo "# Some function might not work properly             #\n";
  echo "# See FAQ: http://revisium.com/ai/faq.php           #\n";
  echo "#####################################################\n";
  exit;
}

if (!(function_exists("file_put_contents") && is_callable("file_put_contents"))) {
    echo "#####################################################\n";
	echo "file_put_contents() is disabled. Cannot proceed.\n";
    echo "#####################################################\n";	
    exit;
}
                              
define('AI_VERSION', '20160105_BEGET');

////////////////////////////////////////////////////////////////////////////

$l_Res = '';

$g_Structure = array();
$g_Counter = 0;

$g_NotRead = array();
$g_FileInfo = array();
$g_Iframer = array();
$g_PHPCodeInside = array();
$g_CriticalJS = array();
$g_Phishing = array();
$g_Base64 = array();
$g_HeuristicDetected = array();
$g_HeuristicType = array();
$g_UnixExec = array();
$g_SkippedFolders = array();
$g_UnsafeFilesFound = array();
$g_CMS = array();
$g_SymLinks = array();
$g_HiddenFiles = array();
$g_Vulnerable = array();

$g_TotalFolder = 0;
$g_TotalFiles = 0;

$g_FoundTotalDirs = 0;
$g_FoundTotalFiles = 0;

if (!isCli()) {
   $defaults['site_url'] = 'http://' . $_SERVER['HTTP_HOST'] . '/'; 
}

define('CRC32_LIMIT', pow(2, 31) - 1);
define('CRC32_DIFF', CRC32_LIMIT * 2 -2);

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
srand(time());

set_time_limit(0);
ini_set('max_execution_time', '900000');
ini_set('realpath_cache_size','16M');
ini_set('realpath_cache_ttl','1200');

if (!function_exists('stripos')) {
	function stripos($par_Str, $par_Entry, $Offset = 0) {
		return strpos(strtolower($par_Str), strtolower($par_Entry), $Offset);
	}
}

define('CMS_BITRIX', 'Bitrix');
define('CMS_WORDPRESS', 'Wordpress');
define('CMS_JOOMLA', 'Joomla');
define('CMS_DLE', 'Data Life Engine');
define('CMS_IPB', 'Invision Power Board');
define('CMS_WEBASYST', 'WebAsyst');
define('CMS_OSCOMMERCE', 'OsCommerce');
define('CMS_DRUPAL', 'Drupal');
define('CMS_MODX', 'MODX');
define('CMS_INSTANTCMS', 'Instant CMS');
define('CMS_PHPBB', 'PhpBB');
define('CMS_VBULLETIN', 'vBulletin');
define('CMS_SHOPSCRIPT', 'PHP ShopScript Premium');

define('CMS_VERSION_UNDEFINED', '0.0');

class CmsVersionDetector {
    private $root_path;
    private $versions;
    private $types;

    public function __construct($root_path = '.') {
        $this->root_path = $root_path;
        $this->versions = array();
        $this->types = array();

        $version = '';

        $dir_list = $this->getDirList($root_path);
        $dir_list[] = $root_path;

        foreach ($dir_list as $dir) {
            if ($this->checkBitrix($dir, $version)) {
               $this->addCms(CMS_BITRIX, $version);
            }

            if ($this->checkWordpress($dir, $version)) {
               $this->addCms(CMS_WORDPRESS, $version);
            }

            if ($this->checkJoomla($dir, $version)) {
               $this->addCms(CMS_JOOMLA, $version);
            }

            if ($this->checkDle($dir, $version)) {
               $this->addCms(CMS_DLE, $version);
            }

            if ($this->checkIpb($dir, $version)) {
               $this->addCms(CMS_IPB, $version);
            }

            if ($this->checkWebAsyst($dir, $version)) {
               $this->addCms(CMS_WEBASYST, $version);
            }

            if ($this->checkOsCommerce($dir, $version)) {
               $this->addCms(CMS_OSCOMMERCE, $version);
            }

            if ($this->checkDrupal($dir, $version)) {
               $this->addCms(CMS_DRUPAL, $version);
            }

            if ($this->checkMODX($dir, $version)) {
               $this->addCms(CMS_MODX, $version);
            }

            if ($this->checkInstantCms($dir, $version)) {
               $this->addCms(CMS_INSTANTCMS, $version);
            }

            if ($this->checkPhpBb($dir, $version)) {
               $this->addCms(CMS_PHPBB, $version);
            }

            if ($this->checkVBulletin($dir, $version)) {
               $this->addCms(CMS_VBULLETIN, $version);
            }

            if ($this->checkPhpShopScript($dir, $version)) {
               $this->addCms(CMS_SHOPSCRIPT, $version);
            }

        }
    }

    function getDirList($target) {
       $remove = array('.', '..'); 
       $directories = array_diff(scandir($target), $remove);

       $res = array();
           
       foreach($directories as $value) 
       { 
          if(is_dir($target . '/' . $value)) 
          {
             $res[] = $target . '/' . $value; 
          } 
       }

       return $res;
    }

    function isCms($name, $version) {
		for ($i = 0; $i < count($this->types); $i++) {
			if ((strpos($this->types[$i], $name) !== false) 
				&& 
			    (strpos($this->versions[$i], $version) !== false)) {
				return true;
			}
		}
    	
		return false;
    }

    function getCmsList() {
      return $this->types;
    }

    function getCmsVersions() {
      return $this->versions;
    }

    function getCmsNumber() {
      return count($this->types);
    }

    function getCmsName($index = 0) {
      return $this->types[$index];
    }

    function getCmsVersion($index = 0) {
      return $this->versions[$index];
    }

    private function addCms($type, $version) {
       $this->types[] = $type;
       $this->versions[] = $version;
    }

    private function checkBitrix($dir, &$version) {
       $version = CMS_VERSION_UNDEFINED;
       $res = false;

       if (file_exists($dir .'/bitrix')) {
          $res = true;

          $tmp_content = @file_get_contents($this->root_path .'/bitrix/modules/main/classes/general/version.php');
          if (preg_match('|define\("SM_VERSION","(.+?)"\)|smi', $tmp_content, $tmp_ver)) {
             $version = $tmp_ver[1];
          }

       }

       return $res;
    }

    private function checkWordpress($dir, &$version) {
       $version = CMS_VERSION_UNDEFINED;
       $res = false;

       if (file_exists($dir .'/wp-admin')) {
          $res = true;

          $tmp_content = @file_get_contents($dir .'/wp-includes/version.php');
          if (preg_match('|\$wp_version\s*=\s*\'(.+?)\'|smi', $tmp_content, $tmp_ver)) {
             $version = $tmp_ver[1];
          }
       }

       return $res;
    }

    private function checkJoomla($dir, &$version) {
       $version = CMS_VERSION_UNDEFINED;
       $res = false;

       if (file_exists($dir .'/libraries/joomla')) {
          $res = true;

          // for 1.5.x
          $tmp_content = @file_get_contents($dir .'/libraries/joomla/version.php');
          if (preg_match('|var\s+\$RELEASE\s*=\s*\'(.+?)\'|smi', $tmp_content, $tmp_ver)) {
             $version = $tmp_ver[1];

             if (preg_match('|var\s+\$DEV_LEVEL\s*=\s*\'(.+?)\'|smi', $tmp_content, $tmp_ver)) {
                $version .= '.' . $tmp_ver[1];
             }
          }

          // for 1.7.x
          $tmp_content = @file_get_contents($dir .'/includes/version.php');
          if (preg_match('|public\s+\$RELEASE\s*=\s*\'(.+?)\'|smi', $tmp_content, $tmp_ver)) {
             $version = $tmp_ver[1];

             if (preg_match('|public\s+\$DEV_LEVEL\s*=\s*\'(.+?)\'|smi', $tmp_content, $tmp_ver)) {
                $version .= '.' . $tmp_ver[1];
             }
          }

          // for 2.5.x and 3.x
          $tmp_content = @file_get_contents($dir .'/libraries/cms/version/version.php');
          if (preg_match('|public\s+\$RELEASE\s*=\s*\'(.+?)\'|smi', $tmp_content, $tmp_ver)) {
             $version = $tmp_ver[1];

             if (preg_match('|public\s+\$DEV_LEVEL\s*=\s*\'(.+?)\'|smi', $tmp_content, $tmp_ver)) {
                $version .= '.' . $tmp_ver[1];
             }
          }

       }

       return $res;
    }

    private function checkDle($dir, &$version) {
       $version = CMS_VERSION_UNDEFINED;
       $res = false;

       if (file_exists($dir .'/engine/engine.php')) {
          $res = true;

          $tmp_content = @file_get_contents($dir . '/engine/data/config.php');
          if (preg_match('|\'version_id\'\s*=>\s*"(.+?)"|smi', $tmp_content, $tmp_ver)) {
             $version = $tmp_ver[1];
          }

          $tmp_content = @file_get_contents($dir . '/install.php');
          if (preg_match('|\'version_id\'\s*=>\s*"(.+?)"|smi', $tmp_content, $tmp_ver)) {
             $version = $tmp_ver[1];
          }

       }

       return $res;
    }

    private function checkIpb($dir, &$version) {
       $version = CMS_VERSION_UNDEFINED;
       $res = false;

       if (file_exists($dir . '/ips_kernel')) {
          $res = true;

          $tmp_content = @file_get_contents($dir . '/ips_kernel/class_xml.php');
          if (preg_match('|IP.Board\s+v([0-9\.]+)|si', $tmp_content, $tmp_ver)) {
             $version = $tmp_ver[1];
          }

       }

       return $res;
    }

    private function checkWebAsyst($dir, &$version) {
       $version = CMS_VERSION_UNDEFINED;
       $res = false;

       if (file_exists($dir . '/wbs/installer')) {
          $res = true;

          $tmp_content = @file_get_contents($dir . '/license.txt');
          if (preg_match('|v([0-9\.]+)|si', $tmp_content, $tmp_ver)) {
             $version = $tmp_ver[1];
          }

       }

       return $res;
    }

    private function checkOsCommerce($dir, &$version) {
       $version = CMS_VERSION_UNDEFINED;
       $res = false;

       if (file_exists($dir . '/includes/version.php')) {
          $res = true;

          $tmp_content = @file_get_contents($dir . '/includes/version.php');
          if (preg_match('|([0-9\.]+)|smi', $tmp_content, $tmp_ver)) {
             $version = $tmp_ver[1];
          }

       }

       return $res;
    }

    private function checkDrupal($dir, &$version) {
       $version = CMS_VERSION_UNDEFINED;
       $res = false;

       if (file_exists($dir . '/sites/all')) {
          $res = true;

          $tmp_content = @file_get_contents($dir . '/CHANGELOG.txt');
          if (preg_match('|Drupal\s+([0-9\.]+)|smi', $tmp_content, $tmp_ver)) {
             $version = $tmp_ver[1];
          }

       }

       return $res;
    }

    private function checkMODX($dir, &$version) {
       $version = CMS_VERSION_UNDEFINED;
       $res = false;

       if (file_exists($dir . '/manager/assets')) {
          $res = true;

          // no way to pick up version
       }

       return $res;
    }

    private function checkInstantCms($dir, &$version) {
       $version = CMS_VERSION_UNDEFINED;
       $res = false;

       if (file_exists($dir . '/plugins/p_usertab')) {
          $res = true;

          $tmp_content = @file_get_contents($dir . '/index.php');
          if (preg_match('|InstantCMS\s+v([0-9\.]+)|smi', $tmp_content, $tmp_ver)) {
             $version = $tmp_ver[1];
          }

       }

       return $res;
    }

    private function checkPhpBb($dir, &$version) {
       $version = CMS_VERSION_UNDEFINED;
       $res = false;

       if (file_exists($dir . '/includes/acp')) {
          $res = true;

          $tmp_content = @file_get_contents($dir . '/config.php');
          if (preg_match('|phpBB\s+([0-9\.x]+)|smi', $tmp_content, $tmp_ver)) {
             $version = $tmp_ver[1];
          }

       }

       return $res;
    }

    private function checkVBulletin($dir, &$version) {
       $version = CMS_VERSION_UNDEFINED;
       $res = false;

       if (file_exists($dir . '/core/admincp')) {
          $res = true;

          $tmp_content = @file_get_contents($dir . '/core/api.php');
          if (preg_match('|vBulletin\s+([0-9\.x]+)|smi', $tmp_content, $tmp_ver)) {
             $version = $tmp_ver[1];
          }

       }

       return $res;
    }

    private function checkPhpShopScript($dir, &$version) {
       $version = CMS_VERSION_UNDEFINED;
       $res = false;

       if (file_exists($dir . '/install/consts.php')) {
          $res = true;

          $tmp_content = @file_get_contents($dir . '/install/consts.php');
          if (preg_match('|STRING_VERSION\',\s*\'(.+?)\'|smi', $tmp_content, $tmp_ver)) {
             $version = $tmp_ver[1];
          }

       }

       return $res;
    }
}

/**
 * Print file
*/
function printFile() {
	$l_FileName = $_GET['fn'];
	$l_CRC = isset($_GET['c']) ? (int)$_GET['c'] : 0;
	$l_Content = file_get_contents($l_FileName);
	$l_FileCRC = realCRC($l_Content);
	if ($l_FileCRC != $l_CRC) {
		echo 'Доступ запрещен.';
		exit;
	}
	
	echo '<pre>' . htmlspecialchars($l_Content) . '</pre>';
}

/**
 *
 */
function realCRC($str_in, $full = false)
{
        $in = crc32( $full ? normal($str_in) : $str_in );
        return ($in > CRC32_LIMIT) ? ($in - CRC32_DIFF) : $in;
}


/**
 * Determine php script is called from the command line interface
 * @return bool
 */
function isCli()
{
	return php_sapi_name() == 'cli';
}

function myCheckSum($str) {
  return str_replace('-', 'x', crc32($str));
}

 function generatePassword ($length = 9)
  {

    // start with a blank password
    $password = "";

    // define possible characters - any character in this string can be
    // picked for use in the password, so if you want to put vowels back in
    // or add special characters such as exclamation marks, this is where
    // you should do it
    $possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";

    // we refer to the length of $possible a few times, so let's grab it now
    $maxlength = strlen($possible);
  
    // check for length overflow and truncate if necessary
    if ($length > $maxlength) {
      $length = $maxlength;
    }
	
    // set up a counter for how many characters are in the password so far
    $i = 0; 
    
    // add random characters to $password until $length is reached
    while ($i < $length) { 

      // pick a random character from the possible ones
      $char = substr($possible, mt_rand(0, $maxlength-1), 1);
        
      // have we already used this character in $password?
      if (!strstr($password, $char)) { 
        // no, so it's OK to add it onto the end of whatever we've already got...
        $password .= $char;
        // ... and increase the counter by one
        $i++;
      }

    }

    // done!
    return $password;

  }

/**
 * Print to console
 * @param mixed $text
 * @param bool $add_lb Add line break
 * @return void
 */
function stdOut($text, $add_lb = true)
{
	global $BOOL_RESULT;

	if (!isCli())
		return;
		
	if (is_bool($text))
	{
		$text = $text ? 'true' : 'false';
	}
	else if (is_null($text))
	{
		$text = 'null';
	}
	if (!is_scalar($text))
	{
		$text = print_r($text, true);
	}

 	if (!$BOOL_RESULT)
 	{
 		@fwrite(STDOUT, $text . ($add_lb ? "\n" : ''));
 	}
}

/**
 * Print progress
 * @param int $num Current file
 */
function printProgress($num, &$par_File)
{
	global $g_CriticalPHP, $g_Base64, $g_Phishing, $g_CriticalJS, $g_Iframer;
	$total_files = $GLOBALS['g_FoundTotalFiles'];
	$elapsed_time = microtime(true) - START_TIME;
	$percent = number_format($total_files ? $num*100/$total_files : 0, 1);
	$stat = '';
	if ($elapsed_time >= 1)
	{
		$elapsed_seconds = round($elapsed_time, 0);
		$fs = floor($num / $elapsed_seconds);
		$left_files = $total_files - $num;
		if ($fs > 0) 
		{
		   $left_time = ($left_files / $fs); //ceil($left_files / $fs);
		   $stat = ' [Avg: ' . round($fs,2) . ' files/s' . ($left_time > 0  ? ' Left: ' . seconds2Human($left_time) : '') . '] [Mlw:' . (count($g_CriticalPHP) + count($g_Base64))  . '|' . (count($g_CriticalJS) + count($g_Iframer) + count($g_Phishing)) . ']';
        }
	}

	$l_FN = substr($par_File, -60);

	$text = "$percent% [$l_FN] $num of {$total_files}. " . $stat;
	$text = str_pad($text, 160, ' ', STR_PAD_RIGHT);
	stdOut(str_repeat(chr(8), 160) . $text, false);
}

/**
 * Seconds to human readable
 * @param int $seconds
 * @return string
 */
function seconds2Human($seconds)
{
	$r = '';
	$_seconds = floor($seconds);
	$ms = $seconds - $_seconds;
	$seconds = $_seconds;
	if ($hours = floor($seconds / 3600))
	{
		$r .= $hours . (isCli() ? ' h ' : ' час ');
		$seconds = $seconds % 3600;
	}

	if ($minutes = floor($seconds / 60))
	{
		$r .= $minutes . (isCli() ? ' m ' : ' мин ');
		$seconds = $seconds % 60;
	}

	if ($minutes < 3) $r .= ' ' . $seconds + ($ms > 0 ? round($ms) : 0) . (isCli() ? ' s' : ' сек'); 

	return $r;
}

if (isCli())
{

	$cli_options = array(
		'm:' => 'memory:',
		's:' => 'size:',
		'a' => 'all',
		'd:' => 'delay:',
		'l:' => 'list:',
		'r:' => 'report:',
		'f' => 'fast',
		'j:' => 'file:',
		'p:' => 'path:',
		'q' => 'quite',
		'e:' => 'cms:',
		'x:' => 'mode:',
		'k:' => 'skip:',
		'i:' => 'idb:',
		'h' => 'help'
	);

	$cli_longopts = array(
		'cmd:',
		'noprefix:',
		'addprefix:',
		'one-pass',
		'quarantine',
		'with-2check',
		'imake',
		'icheck'
	);
	$cli_longopts = array_merge($cli_longopts, array_values($cli_options));

	$options = getopt(implode('', array_keys($cli_options)), $cli_longopts);

	if (isset($options['h']) OR isset($options['help']))
	{
		$memory_limit = ini_get('memory_limit');
		echo <<<HELP
AI-Bolit - Script to search for shells and other malicious software.

Usage: php {$_SERVER['PHP_SELF']} [OPTIONS] [PATH]
Current default path is: {$defaults['path']}

  -j, --file=FILE      Full path to single file to check
  -l, --list=FILE      Full path to create plain text file with a list of found malware
  -p, --path=PATH      Directory path to scan, by default the file directory is used
                       Current path: {$defaults['path']}
  -m, --memory=SIZE    Maximum amount of memory a script may consume. Current value: $memory_limit
                       Can take shorthand byte values (1M, 1G...)
  -s, --size=SIZE      Scan files are smaller than SIZE. 0 - All files. Current value: {$defaults['max_size_to_scan']}
  -a, --all            Scan all files (by default scan. js,. php,. html,. htaccess)
  -d, --delay=INT      delay in milliseconds when scanning files to reduce load on the file system (Default: 1)
  -e, --cms=FILE       cms filename to load .aknown files from. E.g. --cms=wordpress
  -x, --mode=INT       Set scan mode. 0 - for basic, 1 - for expert and 2 for paranoic.
  -k, --skip=jpg,...   Skip specific extensions. E.g. --skip=jpg,gif,png,xls,pdf
  -r, --report=PATH/EMAILS
                       Full path to create report or email address to send report to.
                       You can also specify multiple email separated by commas.
  -q, 		       Use only with -j. Quiet result check of file, 1=Infected 
      --cmd="command [args...]"
                       Run command after scanning
      --one-pass       Do not calculate remaining time
      --quarantine     Archive all malware from report
      --with-2check    Create or use AI-BOLIT-DOUBLECHECK.php file
      --imake
      --icheck
      --idb=file	   Integrity Check database file

      --help           Display this help and exit

* Mandatory arguments listed below are required for both full and short way of usage.

HELP;
		exit;
	}

	$l_FastCli = false;
	
	if (
		(isset($options['memory']) AND !empty($options['memory']) AND ($memory = $options['memory']))
		OR (isset($options['m']) AND !empty($options['m']) AND ($memory = $options['m']))
	)
	{
		$memory = getBytes($memory);
		if ($memory > 0)
		{
			$defaults['memory_limit'] = $memory;
			ini_set('memory_limit', $memory);
		}
	}

	if (
		(isset($options['file']) AND !empty($options['file']) AND ($file = $options['file']) !== false)
		OR (isset($options['j']) AND !empty($options['j']) AND ($file = $options['j']) !== false)
	)
	{
		define('SCAN_FILE', $file);
	}


	if (
		(isset($options['list']) AND !empty($options['list']) AND ($file = $options['list']) !== false)
		OR (isset($options['l']) AND !empty($options['l']) AND ($file = $options['l']) !== false)
	)
	{

		define('PLAIN_FILE', $file);
	}
	if (
		(isset($options['size']) AND !empty($options['size']) AND ($size = $options['size']) !== false)
		OR (isset($options['s']) AND !empty($options['s']) AND ($size = $options['s']) !== false)
	)
	{
		$size = getBytes($size);
		$defaults['max_size_to_scan'] = $size > 0 ? $size : 0;
	}

 	if (
 		(isset($options['file']) AND !empty($options['file']) AND ($file = $options['file']) !== false)
 		OR (isset($options['j']) AND !empty($options['j']) AND ($file = $options['j']) !== false)
 		AND (isset($options['q'])) 
 	
 	)
 	{
 		$BOOL_RESULT = true;
 	}
 
	if (isset($options['f'])) 
	 {
	   $l_FastCli = true;
	 }
		
	if (
		(isset($options['delay']) AND !empty($options['delay']) AND ($delay = $options['delay']) !== false)
		OR (isset($options['d']) AND !empty($options['d']) AND ($delay = $options['d']) !== false)
	)
	{
		$delay = (int) $delay;
		if (!($delay < 0))
		{
			$defaults['scan_delay'] = $delay;
		}
	}

	if (
		(isset($options['skip']) AND !empty($options['skip']) AND ($ext_list = $options['skip']) !== false)
		OR (isset($options['k']) AND !empty($options['k']) AND ($ext_list = $options['k']) !== false)
	)
	{
		$defaults['skip_ext'] = $ext_list;
	}

	if (isset($options['all']) OR isset($options['a']))
	{
		$defaults['scan_all_files'] = 1;
	}

    if (isset($options['cms'])) {
        define('CMS', $options['cms']);
    } else if (isset($options['e'])) {
        define('CMS', $options['e']);
    }

    if (isset($options['x'])) {
        define('AI_EXPERT', $options['x']);
    } else if (isset($options['mode'])) {
        define('AI_EXPERT', $options['mode']);
    } else {
		define('AI_EXPERT', AI_EXPERT_MODE); 
    }

	$l_SpecifiedPath = false;
	if (
		(isset($options['path']) AND !empty($options['path']) AND ($path = $options['path']) !== false)
		OR (isset($options['p']) AND !empty($options['p']) AND ($path = $options['p']) !== false)
	)
	{
		$defaults['path'] = $path;
		$l_SpecifiedPath = true;
	}

	if (
		isset($options['noprefix']) AND !empty($options['noprefix']) AND ($g_NoPrefix = $options['noprefix']) !== false)
		
	{
	} else {
		$g_NoPrefix = '';
	}

	if (
		isset($options['addprefix']) AND !empty($options['addprefix']) AND ($g_AddPrefix = $options['addprefix']) !== false)
		
	{
	} else {
		$g_AddPrefix = '';
	}



	$l_SuffixReport = str_replace('/var/www', '', $defaults['path']);
	$l_SuffixReport = str_replace('/home', '', $l_SuffixReport);
    $l_SuffixReport = preg_replace('#[/\\\.\s]#', '_', $l_SuffixReport);
	$l_SuffixReport .=  "-" . rand(1, 999999);
		
	if (
		(isset($options['report']) AND ($report = $options['report']) !== false)
		OR (isset($options['r']) AND ($report = $options['r']) !== false)
	)
	{
		$report = str_replace('@PATH@', $l_SuffixReport, $report);
		$report = str_replace('@RND@', rand(1, 999999), $report);
		$report = str_replace('@DATE@', date('d-m-Y-h-i'), $report);
		define('REPORT', $report);
	}

	if (
		(isset($options['idb']) AND ($ireport = $options['idb']) !== false)
	)
	{
		$ireport = str_replace('@PATH@', $l_SuffixReport, $ireport);
		$ireport = str_replace('@RND@', rand(1, 999999), $ireport);
		$ireport = str_replace('@DATE@', date('d-m-Y-h-i'), $ireport);
		define('INTEGRITY_DB_FILE', $ireport);
	}

  
    $l_ReportDirName = dirname($report);
	define('QUEUE_FILENAME', ($l_ReportDirName != '' ? $l_ReportDirName . '/' : '') . 'AI-BOLIT-QUEUE-' . md5($defaults['path']) . '.txt');

	defined('REPORT') OR define('REPORT', 'AI-BOLIT-REPORT-' . $l_SuffixReport . '-' . date('d-m-Y_H-i') . '.html');
	
	defined('INTEGRITY_DB_FILE') OR define('INTEGRITY_DB_FILE', 'AINTEGRITY-' . $l_SuffixReport . '-' . date('d-m-Y_H-i'));

	$last_arg = max(1, sizeof($_SERVER['argv']) - 1);
	if (isset($_SERVER['argv'][$last_arg]))
	{
		$path = $_SERVER['argv'][$last_arg];
		if (
			substr($path, 0, 1) != '-'
			AND (substr($_SERVER['argv'][$last_arg - 1], 0, 1) != '-' OR array_key_exists(substr($_SERVER['argv'][$last_arg - 1], -1), $cli_options)))
		{
			$defaults['path'] = $path;
		}
	}	
	
	
	define('ONE_PASS', isset($options['one-pass']));

	define('IMAKE', isset($options['imake']));
	define('ICHECK', isset($options['icheck']));

	if (IMAKE && ICHECK) die('One of the following options must be used --imake or --icheck.');

} else {
   define('AI_EXPERT', AI_EXPERT_MODE); 
   define('ONE_PASS', true);
}

OptimizeSignatures();

$g_DBShe  = array_map('strtolower', $g_DBShe);
$gX_DBShe = array_map('strtolower', $gX_DBShe);

if (!defined('PLAIN_FILE')) { define('PLAIN_FILE', ''); }

// Init
define('MAX_ALLOWED_PHP_HTML_IN_DIR', 600);
define('BASE64_LENGTH', 69);
define('MAX_PREVIEW_LEN', 80);
define('MAX_EXT_LINKS', 1001);

// Perform full scan when running from command line
if (isCli() || isset($_GET['full'])) {
  $defaults['scan_all_files'] = 1;
}

if ($l_FastCli) {
  $defaults['scan_all_files'] = 0; 
}

if (!isCli()) {
  	define('ICHECK', isset($_GET['icheck']));
  	define('IMAKE', isset($_GET['imake']));
	
	define('INTEGRITY_DB_FILE', 'ai-integrity-db');
}

define('SCAN_ALL_FILES', (bool) $defaults['scan_all_files']);
define('SCAN_DELAY', (int) $defaults['scan_delay']);
define('MAX_SIZE_TO_SCAN', getBytes($defaults['max_size_to_scan']));

if ($defaults['memory_limit'] AND ($defaults['memory_limit'] = getBytes($defaults['memory_limit'])) > 0) {
	ini_set('memory_limit', $defaults['memory_limit']);
    stdOut("Changed memory limit to " . $defaults['memory_limit']);
}

define('START_TIME', microtime(true));

define('ROOT_PATH', realpath($defaults['path']));

if (!ROOT_PATH)
{
    if (isCli())  {
		die(stdOut("Directory '{$defaults['path']}' not found!"));
	}
}
elseif(!is_readable(ROOT_PATH))
{
        if (isCli())  {
		die(stdOut("Cannot read directory '" . ROOT_PATH . "'!"));
	}
}

define('CURRENT_DIR', getcwd());
chdir(ROOT_PATH);

// Проверяем отчет
if (isCli() AND REPORT !== '' AND !getEmails(REPORT))
{
	$report = str_replace('\\', '/', REPORT);
	$abs = strpos($report, '/') === 0 ? DIR_SEPARATOR : '';
	$report = array_values(array_filter(explode('/', $report)));
	$report_file = array_pop($report);
	$report_path = realpath($abs . implode(DIR_SEPARATOR, $report));

	define('REPORT_FILE', $report_file);
	define('REPORT_PATH', $report_path);

	if (REPORT_FILE AND REPORT_PATH AND is_file(REPORT_PATH . DIR_SEPARATOR . REPORT_FILE))
	{
		@unlink(REPORT_PATH . DIR_SEPARATOR . REPORT_FILE);
	}
}


if (function_exists('phpinfo')) {
   ob_start();
   phpinfo();
   $l_PhpInfo = ob_get_contents();
   ob_end_clean();

   $l_PhpInfo = str_replace('border: 1px', '', $l_PhpInfo);
   preg_match('|<body>(.*)</body>|smi', $l_PhpInfo, $l_PhpInfoBody);
}

////////////////////////////////////////////////////////////////////////////
$l_Template = str_replace("@@MODE@@", AI_EXPERT . '/' . SMART_SCAN, $l_Template);

if (AI_EXPERT == 0) {
   $l_Result .= '<div class="rep">' . AI_STR_057 . '</div>'; 
} else {
}

$l_Template = str_replace('@@HEAD_TITLE@@', AI_STR_051 . $g_AddPrefix . str_replace($g_NoPrefix, '', ROOT_PATH), $l_Template);

define('QCR_INDEX_FILENAME', 'fn');
define('QCR_INDEX_TYPE', 'type');
define('QCR_INDEX_WRITABLE', 'wr');
define('QCR_SVALUE_FILE', '1');
define('QCR_SVALUE_FOLDER', '0');

/**
 * Extract emails from the string
 * @param string $email
 * @return array of strings with emails or false on error
 */
function getEmails($email)
{
	$email = preg_split('#[,\s;]#', $email, -1, PREG_SPLIT_NO_EMPTY);
	$r = array();
	for ($i = 0, $size = sizeof($email); $i < $size; $i++)
	{
	        if (function_exists('filter_var')) {
   		   if (filter_var($email[$i], FILTER_VALIDATE_EMAIL))
   		   {
   		   	$r[] = $email[$i];
    		   }
                } else {
                   // for PHP4
                   if (strpos($email[$i], '@') !== false) {
   		   	$r[] = $email[$i];
                   }
                }
	}
	return empty($r) ? false : $r;
}

/**
 * Get bytes from shorthand byte values (1M, 1G...)
 * @param int|string $val
 * @return int
 */
function getBytes($val)
{
	$val = trim($val);
	$last = strtolower($val{strlen($val) - 1});
	switch($last) {
		case 't':
			$val *= 1024;
		case 'g':
			$val *= 1024;
		case 'm':
			$val *= 1024;
		case 'k':
			$val *= 1024;
	}
	return intval($val);
}

/**
 * Format bytes to human readable
 * @param int $bites
 * @return string
 */
function bytes2Human($bites)
{
	if ($bites < 1024)
	{
		return $bites . ' b';
	}
	elseif (($kb = $bites / 1024) < 1024)
	{
		return number_format($kb, 2) . ' Kb';
	}
	elseif (($mb = $kb / 1024) < 1024)
	{
		return number_format($mb, 2) . ' Mb';
	}
	elseif (($gb = $mb / 1024) < 1024)
	{
		return number_format($gb, 2) . ' Gb';
	}
	else
	{
		return number_format($gb / 1024, 2) . 'Tb';
	}
}

///////////////////////////////////////////////////////////////////////////
function needIgnore($par_FN, $par_CRC) {
  global $g_IgnoreList;
  
  for ($i = 0; $i < count($g_IgnoreList); $i++) {
     if (strpos($par_FN, $g_IgnoreList[$i][0]) !== false) {
		if ($par_CRC == $g_IgnoreList[$i][1]) {
			return true;
		}
	 }
  }
  
  return false;
}

///////////////////////////////////////////////////////////////////////////
function makeSafeFn($par_Str, $replace_path = false) {
  global $g_AddPrefix, $g_NoPrefix;
  if ($replace_path) {
     $lines = explode("\n", $par_Str);
     array_walk($lines, function(&$n) {
          global $g_AddPrefix, $g_NoPrefix;
          $n = $g_AddPrefix . str_replace($g_NoPrefix, '', $n); 
     }); 

     $par_Str = implode("\n", $lines);
  }
 
  return htmlspecialchars($par_Str, ENT_SUBSTITUTE | ENT_QUOTES);
}

function replacePathArray($par_Arr) {
  global $g_AddPrefix, $g_NoPrefix;
     array_walk($par_Arr, function(&$n) {
          global $g_AddPrefix, $g_NoPrefix;
          $n = $g_AddPrefix . str_replace($g_NoPrefix, '', $n); 
     }); 

  return $par_Arr;
}

///////////////////////////////////////////////////////////////////////////
function printList($par_List, $par_Details = null, $par_NeedIgnore = false, $par_SigId = null, $par_TableName = null) {
  global $g_Structure, $g_NoPrefix, $g_AddPrefix;
  
  if ($par_TableName == null) {
     $par_TableName = 'table_' . rand(1000000,9000000);
  }

  $l_Result = '';
  $l_Result .= "<div class=\"flist\"><table cellspacing=1 cellpadding=4 border=0 id=\"" . $par_TableName . "\">";

  $l_Result .= "<thead><tr class=\"tbgh" . ( $i % 2 ). "\">";
  $l_Result .= "<th width=70%>" . AI_STR_004 . "</th>";
  $l_Result .= "<th>" . AI_STR_005 . "</th>";
  $l_Result .= "<th>" . AI_STR_006 . "</th>";
  $l_Result .= "<th width=90>" . AI_STR_007 . "</th>";
  $l_Result .= "<th width=0 class=\"hidd\">CRC32</th>";
  $l_Result .= "<th width=0 class=\"hidd\"></th>";
  $l_Result .= "<th width=0 class=\"hidd\"></th>";
  $l_Result .= "<th width=0 class=\"hidd\"></th>";
  
  $l_Result .= "</tr></thead><tbody>";

  for ($i = 0; $i < count($par_List); $i++) {
    if ($par_SigId != null) {
       $l_SigId = 'id_' . $par_SigId[$i];
    } else {
       $l_SigId = 'id_z' . rand(1000000,9000000);
    }
    
    $l_Pos = $par_List[$i];
        if ($par_NeedIgnore) {
         	if (needIgnore($g_Structure['n'][$par_List[$i]], $g_Structure['crc'][$l_Pos])) {
         		continue;
         	}
        }
  
     $l_Creat = $g_Structure['c'][$l_Pos] > 0 ? date("d/m/Y H:i:s", $g_Structure['c'][$l_Pos]) : '-';
     $l_Modif = $g_Structure['m'][$l_Pos] > 0 ? date("d/m/Y H:i:s", $g_Structure['m'][$l_Pos]) : '-';
     $l_Size = $g_Structure['s'][$l_Pos] > 0 ? bytes2Human($g_Structure['s'][$l_Pos]) : '-';

     if ($par_Details != null) {
        $l_WithMarker = preg_replace('|__AI_MARKER__|smi', '<span class="marker">&nbsp;</span>', $par_Details[$i]);
        $l_WithMarker = preg_replace('|__AI_LINE1__|smi', '<span class="line_no">', $l_WithMarker);
        $l_WithMarker = preg_replace('|__AI_LINE2__|smi', '</span>', $l_WithMarker);
		
        $l_Body = '<div class="details">';

        if ($par_SigId != null) {
           $l_Body .= '<a href="#" onclick="return hsig(\'' . $l_SigId . '\')">[x]</a> ';
        }

        $l_Body .= $l_WithMarker . '</div>';
     } else {
        $l_Body = '';
     }

     $l_Result .= '<tr class="tbg' . ( $i % 2 ). '" o="' . $l_SigId .'">';
	 
	 if (is_file($g_Structure['n'][$l_Pos])) {
//		$l_Result .= '<td><div class="it"><a class="it" target="_blank" href="'. $defaults['site_url'] . 'ai-bolit.php?fn=' .
//	              $g_Structure['n'][$l_Pos] . '&ph=' . realCRC(PASS) . '&c=' . $g_Structure['crc'][$l_Pos] . '">' . $g_Structure['n'][$l_Pos] . '</a></div>' . $l_Body . '</td>';
		$l_Result .= '<td><div class="it"><a class="it">' . makeSafeFn($g_AddPrefix . str_replace($g_NoPrefix, '', $g_Structure['n'][$l_Pos])) . '</a></div>' . $l_Body . '</td>';
	 } else {
		$l_Result .= '<td><div class="it"><a class="it">' . makeSafeFn($g_AddPrefix . str_replace($g_NoPrefix, '', $g_Structure['n'][$par_List[$i]])) . '</a></div></td>';
	 }
	 
     $l_Result .= '<td align=center><div class="ctd">' . $l_Creat . '</div></td>';
     $l_Result .= '<td align=center><div class="ctd">' . $l_Modif . '</div></td>';
     $l_Result .= '<td align=center><div class="ctd">' . $l_Size . '</div></td>';
     $l_Result .= '<td class="hidd"><div class="hidd">-</div></td>';
     $l_Result .= '<td class="hidd"><div class="hidd">' . $g_Structure['c'][$l_Pos] . '</div></td>';
     $l_Result .= '<td class="hidd"><div class="hidd">' . $g_Structure['m'][$l_Pos] . '</div></td>';
     $l_Result .= '<td class="hidd"><div class="hidd">' . $l_SigId . '</div></td>';
     $l_Result .= '</tr>';

  }

  $l_Result .= "</tbody></table></div><div class=clear style=\"margin: 20px 0 0 0\"></div>";

  return $l_Result;
}

///////////////////////////////////////////////////////////////////////////
function printPlainList($par_List, $par_Details = null, $par_NeedIgnore = false, $par_SigId = null, $par_TableName = null) {
  global $g_Structure, $g_NoPrefix, $g_AddPrefix;
  
//  $l_Result = "\n#\n";

  $l_Src = array('&quot;', '&lt;', '&gt;', '&amp;', '&#039;');
  $l_Dst = array('"',      '<',    '>',    '&', '\'');

  for ($i = 0; $i < count($par_List); $i++) {
    $l_Pos = $par_List[$i];
        if ($par_NeedIgnore) {
         	if (needIgnore($g_Structure['n'][$par_List[$i]], $g_Structure['crc'][$l_Pos])) {
         		continue;
         	}                      
        }
  

     if ($par_Details != null) {
        $l_Body = preg_replace('|(L\d+).+__AI_MARKER__|smi', '$1: ...', $par_Details[$i]);
        $l_Body = preg_replace('/[^\x21-\x7F]/', '.', $l_Body);
        $l_Body = str_replace($l_Src, $l_Dst, $l_Body);

     } else {
        $l_Body = '';
     }

	 if (is_file($g_Structure['n'][$l_Pos])) {		 
		$l_Result .= $g_AddPrefix . str_replace($g_NoPrefix, '', $g_Structure['n'][$l_Pos]) . "\t\t\t" . $l_Body . "\n";
	 } else {
		$l_Result .= $g_AddPrefix . str_replace($g_NoPrefix, '', $g_Structure['n'][$par_List[$i]]) . "\n";
	 }
	 
  }

  return $l_Result;
}

///////////////////////////////////////////////////////////////////////////
function extractValue(&$par_Str, $par_Name) {
  if (preg_match('|<tr><td class="e">\s*'.$par_Name.'\s*</td><td class="v">(.+?)</td>|sm', $par_Str, $l_Result)) {
     return str_replace('no value', '', strip_tags($l_Result[1]));
  }
}

///////////////////////////////////////////////////////////////////////////
function QCR_ExtractInfo($par_Str) {
   $l_PhpInfoSystem = extractValue($par_Str, 'System');
   $l_PhpPHPAPI = extractValue($par_Str, 'Server API');
   $l_AllowUrlFOpen = extractValue($par_Str, 'allow_url_fopen');
   $l_AllowUrlInclude = extractValue($par_Str, 'allow_url_include');
   $l_DisabledFunction = extractValue($par_Str, 'disable_functions');
   $l_DisplayErrors = extractValue($par_Str, 'display_errors');
   $l_ErrorReporting = extractValue($par_Str, 'error_reporting');
   $l_ExposePHP = extractValue($par_Str, 'expose_php');
   $l_LogErrors = extractValue($par_Str, 'log_errors');
   $l_MQGPC = extractValue($par_Str, 'magic_quotes_gpc');
   $l_MQRT = extractValue($par_Str, 'magic_quotes_runtime');
   $l_OpenBaseDir = extractValue($par_Str, 'open_basedir');
   $l_RegisterGlobals = extractValue($par_Str, 'register_globals');
   $l_SafeMode = extractValue($par_Str, 'safe_mode');


   $l_DisabledFunction = ($l_DisabledFunction == '' ? '-?-' : $l_DisabledFunction);
   $l_OpenBaseDir = ($l_OpenBaseDir == '' ? '-?-' : $l_OpenBaseDir);

   $l_Result = '<div class="title">' . AI_STR_008 . ': ' . phpversion() . '</div>';
   $l_Result .= 'System Version: <span class="php_ok">' . $l_PhpInfoSystem . '</span><br/>';
   $l_Result .= 'PHP API: <span class="php_ok">' . $l_PhpPHPAPI. '</span><br/>';
   $l_Result .= 'allow_url_fopen: <span class="php_' . ($l_AllowUrlFOpen == 'On' ? 'bad' : 'ok') . '">' . $l_AllowUrlFOpen. '</span><br/>';
   $l_Result .= 'allow_url_include: <span class="php_' . ($l_AllowUrlInclude == 'On' ? 'bad' : 'ok') . '">' . $l_AllowUrlInclude. '</span><br/>';
   $l_Result .= 'disable_functions: <span class="php_' . ($l_DisabledFunction == '-?-' ? 'bad' : 'ok') . '">' . $l_DisabledFunction. '</span><br/>';
   $l_Result .= 'display_errors: <span class="php_' . ($l_DisplayErrors == 'On' ? 'ok' : 'bad') . '">' . $l_DisplayErrors. '</span><br/>';
   $l_Result .= 'error_reporting: <span class="php_ok">' . $l_ErrorReporting. '</span><br/>';
   $l_Result .= 'expose_php: <span class="php_' . ($l_ExposePHP == 'On' ? 'bad' : 'ok') . '">' . $l_ExposePHP. '</span><br/>';
   $l_Result .= 'log_errors: <span class="php_' . ($l_LogErrors == 'On' ? 'ok' : 'bad') . '">' . $l_LogErrors . '</span><br/>';
   $l_Result .= 'magic_quotes_gpc: <span class="php_' . ($l_MQGPC == 'On' ? 'ok' : 'bad') . '">' . $l_MQGPC. '</span><br/>';
   $l_Result .= 'magic_quotes_runtime: <span class="php_' . ($l_MQRT == 'On' ? 'bad' : 'ok') . '">' . $l_MQRT. '</span><br/>';
   $l_Result .= 'register_globals: <span class="php_' . ($l_RegisterGlobals == 'On' ? 'bad' : 'ok') . '">' . $l_RegisterGlobals . '</span><br/>';
   $l_Result .= 'open_basedir: <span class="php_' . ($l_OpenBaseDir == '-?-' ? 'bad' : 'ok') . '">' . $l_OpenBaseDir . '</span><br/>';
   
   if (phpversion() < '5.3.0') {
      $l_Result .= 'safe_mode (PHP < 5.3.0): <span class="php_' . ($l_SafeMode == 'On' ? 'ok' : 'bad') . '">' . $l_SafeMode. '</span><br/>';
   }

   return $l_Result . '<p>';
}

///////////////////////////////////////////////////////////////////////////
   function addSlash($dir) {
      return rtrim($dir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
   }

///////////////////////////////////////////////////////////////////////////
function QCR_Debug($par_Str = "") {
  if (!DEBUG_MODE) {
     return;
  }

  $l_MemInfo = ' ';  
  if (function_exists('memory_get_usage')) {
     $l_MemInfo .= ' curmem=' .  bytes2Human(memory_get_usage());
  }

  if (function_exists('memory_get_peak_usage')) {
     $l_MemInfo .= ' maxmem=' .  bytes2Human(memory_get_peak_usage());
  }

  stdOut("\n" . date('H:i:s') . ': ' . $par_Str . $l_MemInfo . "\n");
}


///////////////////////////////////////////////////////////////////////////
function QCR_ScanDirectories($l_RootDir)
{
	global $g_Structure, $g_Counter, $g_Doorway, $g_FoundTotalFiles, $g_FoundTotalDirs, 
			$defaults, $g_SkippedFolders, $g_UrlIgnoreList, $g_DirIgnoreList, $g_UnsafeDirArray, 
                        $g_UnsafeFilesFound, $g_SymLinks, $g_HiddenFiles, $g_UnixExec, $g_IgnoredExt, $g_SensitiveFiles, 
						$g_SuspiciousFiles, $g_ShortListExt;

	static $l_Buffer = '';

	$l_DirCounter = 0;
	$l_DoorwayFilesCounter = 0;
	$l_SourceDirIndex = $g_Counter - 1;

	QCR_Debug('Scan ' . $l_RootDir);

        $l_QuotedSeparator = quotemeta(DIR_SEPARATOR); 
 	if ($l_DIRH = @opendir($l_RootDir))
	{
		while (($l_FileName = readdir($l_DIRH)) !== false)
		{
			if ($l_FileName == '.' || $l_FileName == '..') continue;

			$l_FileName = $l_RootDir . DIR_SEPARATOR . $l_FileName;

			$l_Type = filetype($l_FileName);
            if ($l_Type == "link") 
            {
                $g_SymLinks[] = $l_FileName;
                continue;
            } else			
			if ($l_Type != "file" && $l_Type != "dir" ) {
			        if (!in_array($l_FileName, $g_UnixExec)) {
				   $g_UnixExec[] = $l_FileName;
				}

				continue;
			}	
						
			$l_Ext = strtolower(pathinfo($l_FileName, PATHINFO_EXTENSION));
			$l_IsDir = is_dir($l_FileName);

			if (in_array($l_Ext, $g_SuspiciousFiles)) 
			{
			        if (!in_array($l_FileName, $g_UnixExec)) {
                		   $g_UnixExec[] = $l_FileName;
                                } 
            		}

			// which files should be scanned
			$l_NeedToScan = SCAN_ALL_FILES || (in_array($l_Ext, $g_SensitiveFiles));
			
			if (in_array(strtolower($l_Ext), $g_IgnoredExt)) {    
		       $l_NeedToScan = false;
            }

			if ($l_IsDir)
			{
				// if folder in ignore list
				$l_Skip = false;
				for ($dr = 0; $dr < count($g_DirIgnoreList); $dr++) {
					if (($g_DirIgnoreList[$dr] != '') &&
						preg_match('#' . $g_DirIgnoreList[$dr] . '#', $l_FileName, $l_Found)) {
						$l_Skip = true;
					}
				}
			
				// skip on ignore
				if ($l_Skip) {
					$g_SkippedFolders[] = $l_FileName;
					continue;
				}
				
				$l_BaseName = basename($l_FileName);

				if ((strpos($l_BaseName, '.') === 0) && ($l_BaseName != '.htaccess')) {
	               $g_HiddenFiles[] = $l_FileName;
	            }

//				$g_Structure['d'][$g_Counter] = $l_IsDir;
//				$g_Structure['n'][$g_Counter] = $l_FileName;
				if (ONE_PASS) {
					$g_Structure['n'][$g_Counter] = $l_FileName . DIR_SEPARATOR;
				} else {
					$l_Buffer .= $l_FileName . DIR_SEPARATOR . "\n";
				}

				$l_DirCounter++;

				if ($l_DirCounter > MAX_ALLOWED_PHP_HTML_IN_DIR)
				{
					$g_Doorway[] = $l_SourceDirIndex;
					$l_DirCounter = -655360;
				}

				$g_Counter++;
				$g_FoundTotalDirs++;

				QCR_ScanDirectories($l_FileName);
			} else
			{
				if ($l_NeedToScan)
				{
					$g_FoundTotalFiles++;
					if (in_array($l_Ext, $g_ShortListExt)) 
					{
						$l_DoorwayFilesCounter++;
						
						if ($l_DoorwayFilesCounter > MAX_ALLOWED_PHP_HTML_IN_DIR)
						{
							$g_Doorway[] = $l_SourceDirIndex;
							$l_DoorwayFilesCounter = -655360;
						}
					}

					if (ONE_PASS) {
						QCR_ScanFile($l_FileName, $g_Counter++);
					} else {
						$l_Buffer .= $l_FileName."\n";
					}

					$g_Counter++;
				}
			}

			if (strlen($l_Buffer) > 32000)
			{ 
				file_put_contents(QUEUE_FILENAME, $l_Buffer, FILE_APPEND) or die("Cannot write to file ".QUEUE_FILENAME);
				$l_Buffer = '';
			}

		}

		closedir($l_DIRH);
	}
	
	if (($l_RootDir == ROOT_PATH) && !empty($l_Buffer)) {
		file_put_contents(QUEUE_FILENAME, $l_Buffer, FILE_APPEND) or die("Cannot write to file " . QUEUE_FILENAME);
		$l_Buffer = '';                                                                            
	}

}


///////////////////////////////////////////////////////////////////////////
function getFragment($par_Content, $par_Pos) {
  $l_MaxChars = MAX_PREVIEW_LEN;
  $l_MaxLen = strlen($par_Content);
  $l_RightPos = min($par_Pos + $l_MaxChars, $l_MaxLen); 
  $l_MinPos = max(0, $par_Pos - $l_MaxChars);

  $l_FoundStart = substr($par_Content, 0, $par_Pos);
  $l_FoundStart = str_replace("\r", '', $l_FoundStart);
  $l_LineNo = strlen($l_FoundStart) - strlen(str_replace("\n", '', $l_FoundStart)) + 1;

  $par_Content = preg_replace('/[\x00-\x1F\x80-\xFF]/', '~', $par_Content);

  $l_Res = '__AI_LINE1__' . $l_LineNo . "__AI_LINE2__  " . ($l_MinPos > 0 ? '…' : '') . substr($par_Content, $l_MinPos, $par_Pos - $l_MinPos) . 
           '__AI_MARKER__' . 
           substr($par_Content, $par_Pos, $l_RightPos - $par_Pos - 1);

  $l_Res = makeSafeFn(UnwrapObfu($l_Res));
  $l_Res = str_replace('~', '·', $l_Res);

  return $l_Res;
}

///////////////////////////////////////////////////////////////////////////
function escapedHexToHex($escaped)
{ $GLOBALS['g_EncObfu']++; return chr(hexdec($escaped[1])); }
function escapedOctDec($escaped)
{ $GLOBALS['g_EncObfu']++; return chr(octdec($escaped[1])); }
function escapedDec($escaped)
{ $GLOBALS['g_EncObfu']++; return chr($escaped[1]); }

///////////////////////////////////////////////////////////////////////////
if (!defined('T_ML_COMMENT')) {
   define('T_ML_COMMENT', T_COMMENT);
} else {
   define('T_DOC_COMMENT', T_ML_COMMENT);
}

function UnwrapObfu($par_Content) {
  $GLOBALS['g_EncObfu'] = 0;
  
  $search  = array( ' ;', ' =', ' ,', ' .', ' (', ' )', ' {', ' }', '; ', '= ', ', ', '. ', '( ', '( ', '{ ', '} ', ' !', ' >', ' <', ' _', '_ ', '< ',  '> ', ' $', ' %',   '% ', '# ', ' #', '^ ', ' ^', ' &', '& ', ' ?', '? ');
  $replace = array(  ';',  '=',  ',',  '.',  '(',  ')',  '{',  '}', ';',  '=',  ',',  '.',  '(',   ')', '{',  '}',   '!',  '>',  '<',  '_', '_',  '<',   '>',   '$',  '%',   '%',  '#',   '#', '^',   '^',  '&', '&',   '?', '?');
  $par_Content = str_replace('@', '', $par_Content);
  $par_Content = preg_replace('~\s+~', ' ', $par_Content);
  $par_Content = str_replace($search, $replace, $par_Content);
  $par_Content = preg_replace_callback('~\bchr\(\s*([0-9a-fA-FxX]+)\s*\)~', function ($m) { return "'".chr(intval($m[1], 0))."'"; }, $par_Content );

  $par_Content = preg_replace_callback('/\\\\x([a-fA-F0-9]{1,2})/i','escapedHexToHex', $par_Content);
  $par_Content = preg_replace_callback('/\\\\([0-9]{1,3})/i','escapedOctDec', $par_Content);

  $par_Content = preg_replace('/[\'"]\s*?\.+\s*?[\'"]/smi', '', $par_Content);

  return $par_Content;
}


///////////////////////////////////////////////////////////////////////////
// Unicode BOM is U+FEFF, but after encoded, it will look like this.
define ('UTF32_BIG_ENDIAN_BOM'   , chr(0x00) . chr(0x00) . chr(0xFE) . chr(0xFF));
define ('UTF32_LITTLE_ENDIAN_BOM', chr(0xFF) . chr(0xFE) . chr(0x00) . chr(0x00));
define ('UTF16_BIG_ENDIAN_BOM'   , chr(0xFE) . chr(0xFF));
define ('UTF16_LITTLE_ENDIAN_BOM', chr(0xFF) . chr(0xFE));
define ('UTF8_BOM'               , chr(0xEF) . chr(0xBB) . chr(0xBF));

function detect_utf_encoding($text) {
    $first2 = substr($text, 0, 2);
    $first3 = substr($text, 0, 3);
    $first4 = substr($text, 0, 3);
    
    if ($first3 == UTF8_BOM) return 'UTF-8';
    elseif ($first4 == UTF32_BIG_ENDIAN_BOM) return 'UTF-32BE';
    elseif ($first4 == UTF32_LITTLE_ENDIAN_BOM) return 'UTF-32LE';
    elseif ($first2 == UTF16_BIG_ENDIAN_BOM) return 'UTF-16BE';
    elseif ($first2 == UTF16_LITTLE_ENDIAN_BOM) return 'UTF-16LE';

    return false;
}

///////////////////////////////////////////////////////////////////////////
function QCR_SearchPHP($src)
{
  if (preg_match("/(<\?php[\w\s]{5,})/smi", $src, $l_Found, PREG_OFFSET_CAPTURE)) {
	  return $l_Found[0][1];
  }

  if (preg_match("/(<script[^>]*language\s*=\s*)('|\"|)php('|\"|)([^>]*>)/i", $src, $l_Found, PREG_OFFSET_CAPTURE)) {
    return $l_Found[0][1];
  }

  return false;
}


///////////////////////////////////////////////////////////////////////////
function knowUrl($par_URL) {
  global $g_UrlIgnoreList;

  for ($jk = 0; $jk < count($g_UrlIgnoreList); $jk++) {
     if  (stripos($par_URL, $g_UrlIgnoreList[$jk]) !== false) {
     	return true;
     }
  }

  return false;
}

///////////////////////////////////////////////////////////////////////////

function makeSummary($par_Str, $par_Number, $par_Style) {
   return '<tr><td class="' . $par_Style . '" width=400>' . $par_Str . '</td><td class="' . $par_Style . '">' . $par_Number . '</td></tr>';
}

///////////////////////////////////////////////////////////////////////////

function CheckVulnerability($par_Filename, $par_Index, $par_Content) {
    global $g_Vulnerable, $g_CmsListDetector;
	
	$l_Vuln = array();

        $par_Filename = strtolower($par_Filename);


	if (
	    (strpos($par_Filename, 'libraries/joomla/session/session.php') !== false) &&
		(strpos($par_Content, '&& filter_var($_SERVER[\'HTTP_X_FORWARDED_FOR') === false)
		) 
	{		
			$l_Vuln['id'] = 'RCE : https://docs.joomla.org/Security_hotfixes_for_Joomla_EOL_versions';
			$l_Vuln['ndx'] = $par_Index;
			$g_Vulnerable[] = $l_Vuln;
			return true;
	}

	if (
	    (strpos($par_Filename, 'administrator/components/com_media/helpers/media.php') !== false) &&
		(strpos($par_Content, '$format == \'\' || $format == false ||') === false)
		) 
	{		
		if ($g_CmsListDetector->isCms(CMS_JOOMLA, '1.5')) {
			$l_Vuln['id'] = 'AFU : https://docs.joomla.org/Security_hotfixes_for_Joomla_EOL_versions';
			$l_Vuln['ndx'] = $par_Index;
			$g_Vulnerable[] = $l_Vuln;
			return true;
		}
		
		return false;
	}

	if (
	    (strpos($par_Filename, 'joomla/filesystem/file.php') !== false) &&
		(strpos($par_Content, '$file = rtrim($file, \'.\');') === false)
		) 
	{		
		if ($g_CmsListDetector->isCms(CMS_JOOMLA, '1.5')) {
			$l_Vuln['id'] = 'AFU : https://docs.joomla.org/Security_hotfixes_for_Joomla_EOL_versions';
			$l_Vuln['ndx'] = $par_Index;
			$g_Vulnerable[] = $l_Vuln;
			return true;
		}
		
		return false;
	}

	if ((strpos($par_Filename, 'editor/filemanager/upload/test.html') !== false) ||
		(stripos($par_Filename, 'editor/filemanager/browser/default/connectors/php/') !== false) ||
		(stripos($par_Filename, 'editor/filemanager/connectors/uploadtest.html') !== false) ||
	   (strpos($par_Filename, 'editor/filemanager/browser/default/connectors/test.html') !== false)) {
		$l_Vuln['id'] = 'AFU : FCKEDITOR : http://www.exploit-db.com/exploits/17644/ & /exploit/249';
		$l_Vuln['ndx'] = $par_Index;
		$g_Vulnerable[] = $l_Vuln;
		return true;
	}

	if ((strpos($par_Filename, 'inc_php/image_view.class.php') !== false) ||
	    (strpos($par_Filename, '/inc_php/framework/image_view.class.php') !== false)) {
		if (strpos($par_Content, 'showImageByID') === false) {
			$l_Vuln['id'] = 'AFU : REVSLIDER : http://www.exploit-db.com/exploits/35385/';
			$l_Vuln['ndx'] = $par_Index;
			$g_Vulnerable[] = $l_Vuln;
			return true;
		}
		
		return false;
	}

	if ((strpos($par_Filename, 'elfinder/php/connector.php') !== false) ||
	    (strpos($par_Filename, 'elfinder/elfinder.') !== false)) {
			$l_Vuln['id'] = 'AFU : elFinder';
			$l_Vuln['ndx'] = $par_Index;
			$g_Vulnerable[] = $l_Vuln;
			return true;
	}

	if (strpos($par_Filename, 'includes/database/database.inc') !== false) {
		if (strpos($par_Content, 'foreach ($data as $i => $value)') !== false) {
			$l_Vuln['id'] = 'SQLI : DRUPAL : CVE-2014-3704';
			$l_Vuln['ndx'] = $par_Index;
			$g_Vulnerable[] = $l_Vuln;
			return true;
		}
		
		return false;
	}

	if (strpos($par_Filename, 'engine/classes/min/index.php') !== false) {
		if (strpos($par_Content, 'tr_replace(chr(0)') === false) {
			$l_Vuln['id'] = 'AFD : MINIFY : CVE-2013-6619';
			$l_Vuln['ndx'] = $par_Index;
			$g_Vulnerable[] = $l_Vuln;
			return true;
		}
		
		return false;
	}

	if (( strpos($par_Filename, 'timthumb.php') !== false ) || 
	    ( strpos($par_Filename, 'thumb.php') !== false ) || 
	    ( strpos($par_Filename, 'cache.php') !== false ) || 
	    ( strpos($par_Filename, '_img.php') !== false )) {
		if (strpos($par_Content, 'code.google.com/p/timthumb') !== false && strpos($par_Content, '2.8.14') === false ) {
			$l_Vuln['id'] = 'RCE : TIMTHUMB : CVE-2011-4106,CVE-2014-4663';
			$l_Vuln['ndx'] = $par_Index;
			$g_Vulnerable[] = $l_Vuln;
			return true;
		}
		
		return false;
	}

	if (strpos($par_Filename, 'components/com_rsform/helpers/rsform.php') !== false) {
		if (strpos($par_Content, 'eval($form->ScriptDisplay);') !== false) {
			$l_Vuln['id'] = 'RCE : RSFORM : rsform.php, LINE 1605';
			$l_Vuln['ndx'] = $par_Index;
			$g_Vulnerable[] = $l_Vuln;
			return true;
		}
		
		return false;
	}

	if (strpos($par_Filename, 'fancybox-for-wordpress/fancybox.php') !== false) {
		if (strpos($par_Content, '\'reset\' == $_REQUEST[\'action\']') !== false) {
			$l_Vuln['id'] = 'CODE INJECTION : FANCYBOX';
			$l_Vuln['ndx'] = $par_Index;
			$g_Vulnerable[] = $l_Vuln;
			return true;
		}
		
		return false;
	}


	if (strpos($par_Filename, 'cherry-plugin/admin/import-export/upload.php') !== false) {
		if (strpos($par_Content, 'verify nonce') === false) {
			$l_Vuln['id'] = 'AFU : Cherry Plugin';
			$l_Vuln['ndx'] = $par_Index;
			$g_Vulnerable[] = $l_Vuln;
			return true;
		}
		
		return false;
	}
	
	
	if (strpos($par_Filename, 'tiny_mce/plugins/tinybrowser/tinybrowser.php') !== false) {	
		$l_Vuln['id'] = 'AFU : TINYMCE : http://www.exploit-db.com/exploits/9296/';
		$l_Vuln['ndx'] = $par_Index;
		$g_Vulnerable[] = $l_Vuln;
		
		return true;
	}

	if (strpos($par_Filename, 'scripts/setup.php') !== false) {		
		if (strpos($par_Content, 'PMA_Config') !== false) {
			$l_Vuln['id'] = 'CODE INJECTION : PHPMYADMIN : http://1337day.com/exploit/5334';
			$l_Vuln['ndx'] = $par_Index;
			$g_Vulnerable[] = $l_Vuln;
			return true;
		}
		
		return false;
	}

	if (strpos($par_Filename, '/uploadify.php') !== false) {		
		if (strpos($par_Content, 'move_uploaded_file($tempFile,$targetFile') !== false) {
			$l_Vuln['id'] = 'AFU : UPLOADIFY : CVE: 2012-1153';
			$l_Vuln['ndx'] = $par_Index;
			$g_Vulnerable[] = $l_Vuln;
			return true;
		}
		
		return false;
	}

	if (strpos($par_Filename, 'com_adsmanager/controller.php') !== false) {		
		if (strpos($par_Content, 'move_uploaded_file($file[\'tmp_name\'], $tempPath.\'/\'.basename($file[') !== false) {
			$l_Vuln['id'] = 'AFU : https://revisium.com/ru/blog/adsmanager_afu.html';
			$l_Vuln['ndx'] = $par_Index;
			$g_Vulnerable[] = $l_Vuln;
			return true;
		}
		
		return false;
	}
}

///////////////////////////////////////////////////////////////////////////
function QCR_GoScan($par_Offset)
{
	global $g_IframerFragment, $g_Iframer, $g_Redirect, $g_Doorway, $g_EmptyLink, $g_Structure, $g_Counter, 
		   $g_HeuristicType, $g_HeuristicDetected, $g_TotalFolder, $g_TotalFiles, $g_WarningPHP, $g_AdwareList,
		   $g_CriticalPHP, $g_Phishing, $g_CriticalJS, $g_UrlIgnoreList, $g_CriticalJSFragment, $g_PHPCodeInside, $g_PHPCodeInsideFragment, 
		   $g_NotRead, $g_WarningPHPFragment, $g_WarningPHPSig, $g_BigFiles, $g_RedirectPHPFragment, $g_EmptyLinkSrc, $g_CriticalPHPSig, $g_CriticalPHPFragment, 
           $g_Base64Fragment, $g_UnixExec, $g_PhishingSigFragment, $g_PhishingFragment, $g_PhishingSig, $g_CriticalJSSig, $g_IframerFragment, $g_CMS, $defaults, $g_AdwareListFragment, $g_KnownList,$g_Vulnerable;

    QCR_Debug('QCR_GoScan ' . $par_Offset);

	$i = 0;
	
	try {
		$s_file = new SplFileObject(QUEUE_FILENAME);
		$s_file->setFlags(SplFileObject::READ_AHEAD | SplFileObject::SKIP_EMPTY | SplFileObject::DROP_NEW_LINE);

		foreach ($s_file as $l_Filename) {
			QCR_ScanFile($l_Filename, $i++);
		}
		
		unset($s_file);	
	}
	catch (Exception $e) { QCR_Debug( $e->getMessage() ); }
}

///////////////////////////////////////////////////////////////////////////
function QCR_ScanFile($l_Filename, $i = 0)
{
	global $g_IframerFragment, $g_Iframer, $g_Redirect, $g_Doorway, $g_EmptyLink, $g_Structure, $g_Counter, 
		   $g_HeuristicType, $g_HeuristicDetected, $g_TotalFolder, $g_TotalFiles, $g_WarningPHP, $g_AdwareList,
		   $g_CriticalPHP, $g_Phishing, $g_CriticalJS, $g_UrlIgnoreList, $g_CriticalJSFragment, $g_PHPCodeInside, $g_PHPCodeInsideFragment, 
		   $g_NotRead, $g_WarningPHPFragment, $g_WarningPHPSig, $g_BigFiles, $g_RedirectPHPFragment, $g_EmptyLinkSrc, $g_CriticalPHPSig, $g_CriticalPHPFragment, 
           $g_Base64Fragment, $g_UnixExec, $g_PhishingSigFragment, $g_PhishingFragment, $g_PhishingSig, $g_CriticalJSSig, $g_IframerFragment, $g_CMS, $defaults, $g_AdwareListFragment, $g_KnownList,$g_Vulnerable;

	global $g_CRC;
	static $_files_and_ignored = 0;

			$l_CriticalDetected = false;
			$l_Stat = stat($l_Filename);

			if (substr($l_Filename, -1) == DIR_SEPARATOR) {
				// FOLDER
				$g_Structure['n'][$i] = $l_Filename;
				$g_TotalFolder++;
				printProgress($_files_and_ignored, $l_Filename);
				return;
			}

			QCR_Debug('Scan file ' . $l_Filename);
			printProgress(++$_files_and_ignored, $l_Filename);

			// FILE
			if ((MAX_SIZE_TO_SCAN > 0 AND $l_Stat['size'] > MAX_SIZE_TO_SCAN) || ($l_Stat['size'] < 0))
			{
				$g_BigFiles[] = $i;
				AddResult($l_Filename, $i);
			}
			else
			{
				$g_TotalFiles++;

			$l_TSStartScan = microtime(true);

		if (filetype($l_Filename) == 'file') {
                   $l_Content = @file_get_contents($l_Filename);
                   $l_Unwrapped = @php_strip_whitespace($l_Filename);
                }

		        $l_Ext = strtolower(pathinfo($l_Filename, PATHINFO_EXTENSION));
		
                if (($l_Content == '') && ($l_Stat['size'] > 0)) {
                   $g_NotRead[] = $i;
                   AddResult($l_Filename, $i);
                   return;
                }

				// ignore itself
				if (strpos($l_Content, 'b0c64b734d0ae00f4ec9749fb882d127') !== false) {
					return;
				}

				// unix executables
				if (strpos($l_Content, chr(127) . 'ELF') !== false) 
				{
			        	if (!in_array($l_Filename, $g_UnixExec)) {
                    				$g_UnixExec[] = $l_Filename;
					}

				        return;
                		}

				$g_CRC = realCRC($l_Content);

                                $l_KnownCRC = $g_CRC + realCRC(basename($l_Filename));
                                if ( isset($g_KnownList[$l_KnownCRC]) ) {
	        		   //printProgress(++$_files_and_ignored, $l_Filename);
                                   return;
                                }

				$l_UnicodeContent = detect_utf_encoding($l_Content);
				//$l_Unwrapped = $l_Content;

				// check vulnerability in files
				$l_CriticalDetected = CheckVulnerability($l_Filename, $i, $l_Content);
				
				if ($l_UnicodeContent !== false) {
       				   if (function_exists('mb_convert_encoding')) {
                                      $l_Unwrapped = mb_convert_encoding($l_Unwrapped, "CP1251");
                                   } else {
                                      $g_NotRead[] = $i;
                                      AddResult($l_Filename, $i);
				   }
                                }

				$l_Unwrapped = UnwrapObfu($l_Unwrapped);
				
				// critical
				$g_SkipNextCheck = false;
				if (CriticalPHP($l_Filename, $i, $l_Unwrapped, $l_Pos, $l_SigId))
				{
					$g_CriticalPHP[] = $i;
					$g_CriticalPHPFragment[] = getFragment($l_Unwrapped, $l_Pos);
					$g_CriticalPHPSig[] = $l_SigId;
					$g_SkipNextCheck = true;
				} else {
         				if (CriticalPHP($l_Filename, $i, $l_Content, $l_Pos, $l_SigId))
         				{
         					$g_CriticalPHP[] = $i;
         					$g_CriticalPHPFragment[] = getFragment($l_Content, $l_Pos);
							$g_CriticalPHPSig[] = $l_SigId;
         					$g_SkipNextCheck = true;
         				}
				}

				$l_TypeDe = 0;
			    if ((!$g_SkipNextCheck) && HeuristicChecker($l_Content, $l_TypeDe, $l_Filename)) {
					$g_HeuristicDetected[] = $i;
					$g_HeuristicType[] = $l_TypeDe;
					$l_CriticalDetected = true;
				}

				// critical JS
				if (!$g_SkipNextCheck) {
					$l_Pos = CriticalJS($l_Filename, $i, $l_Unwrapped, $l_SigId);
					if ($l_Pos !== false)
					{
						$g_CriticalJS[] = $i;
						$g_CriticalJSFragment[] = getFragment($l_Unwrapped, $l_Pos);
						$g_CriticalJSSig[] = $l_SigId;
						$g_SkipNextCheck = true;
					}
			    }

				// phishing
				if (!$g_SkipNextCheck) {
					$l_Pos = Phishing($l_Filename, $i, $l_Unwrapped, $l_SigId);
					if ($l_Pos !== false)
					{
						$g_Phishing[] = $i;
						$g_PhishingFragment[] = getFragment($l_Unwrapped, $l_Pos);
						$g_PhishingSigFragment[] = $l_SigId;
						$g_SkipNextCheck = true;
					}
				}

			
			if (!$g_SkipNextCheck) {
				if (SCAN_ALL_FILES || stripos($l_Filename, 'index.'))
				{
					// check iframes
					if (preg_match_all('|<iframe[^>]+src.+?>|smi', $l_Unwrapped, $l_Found, PREG_SET_ORDER)) 
					{
						for ($kk = 0; $kk < count($l_Found); $kk++) {
						    $l_Pos = stripos($l_Found[$kk][0], 'http://');
						    $l_Pos = $l_Pos || stripos($l_Found[$kk][0], 'https://');
						    $l_Pos = $l_Pos || stripos($l_Found[$kk][0], 'ftp://');
							if  (($l_Pos !== false ) && (!knowUrl($l_Found[$kk][0]))) {
         						$g_Iframer[] = $i;
         						$g_IframerFragment[] = getFragment($l_Found[$kk][0], $l_Pos);
         						$l_CriticalDetected = true;
							}
						}
					}

					// check empty links
					if ((($defaults['report_mask'] & REPORT_MASK_SPAMLINKS) == REPORT_MASK_SPAMLINKS) &&
					   (preg_match_all('|<a[^>]+href([^>]+?)>(.*?)</a>|smi', $l_Unwrapped, $l_Found, PREG_SET_ORDER)))
					{
						for ($kk = 0; $kk < count($l_Found); $kk++) {
							if  ((stripos($l_Found[$kk][1], 'http://') !== false) &&
                                                            (trim(strip_tags($l_Found[$kk][2])) == '')) {

								$l_NeedToAdd = true;

							    if  ((stripos($l_Found[$kk][1], $defaults['site_url']) !== false)
                                                                 || knowUrl($l_Found[$kk][1])) {
										$l_NeedToAdd = false;
								}
								
								if ($l_NeedToAdd && (count($g_EmptyLink) < MAX_EXT_LINKS)) {
									$g_EmptyLink[] = $i;
									$g_EmptyLinkSrc[$i][] = substr($l_Found[$kk][0], 0, MAX_PREVIEW_LEN);
									$l_CriticalDetected = true;
								}
							}
						}
					}
				}

				// check for PHP code inside any type of file
				if (stripos($l_Ext, 'ph') === false)
				{
					$l_Pos = QCR_SearchPHP($l_Content);
					if ($l_Pos !== false)
					{
						$g_PHPCodeInside[] = $i;
						$g_PHPCodeInsideFragment[] = getFragment($l_Unwrapped, $l_Pos);
						$l_CriticalDetected = true;
					}
				}

				// htaccess
				if (stripos($l_Filename, '.htaccess'))
				{
				
					if (stripos($l_Content, 'index.php?name=$1') !== false ||
						stripos($l_Content, 'index.php?m=1') !== false
					)
					{
						$g_SuspDir[] = $i;
					}

					$l_HTAContent = preg_replace('|^\s*#.+$|m', '', $l_Content);

					$l_Pos = stripos($l_Content, 'auto_prepend_file');
					if ($l_Pos !== false) {
						$g_Redirect[] = $i;
						$g_RedirectPHPFragment[] = getFragment($l_Content, $l_Pos);
						$l_CriticalDetected = true;
					}
					
					$l_Pos = stripos($l_Content, 'auto_append_file');
					if ($l_Pos !== false) {
						$g_Redirect[] = $i;
						$g_RedirectPHPFragment[] = getFragment($l_Content, $l_Pos);
						$l_CriticalDetected = true;
					}

					$l_Pos = stripos($l_Content, '^(%2d|-)[^=]+$');
					if ($l_Pos !== false)
					{
						$g_Redirect[] = $i;
                        			$g_RedirectPHPFragment[] = getFragment($l_Content, $l_Pos);
						$l_CriticalDetected = true;
					}

					if (!$l_CriticalDetected) {
						$l_Pos = stripos($l_Content, '%{HTTP_USER_AGENT}');
						if ($l_Pos !== false)
						{
							$g_Redirect[] = $i;
							$g_RedirectPHPFragment[] = getFragment($l_Content, $l_Pos);
							$l_CriticalDetected = true;
						}
					}

					if (!$l_CriticalDetected) {
						if (
							preg_match_all("|RewriteRule\s+.+?\s+http://(.+?)/.+\s+\[.*R=\d+.*\]|smi", $l_HTAContent, $l_Found, PREG_SET_ORDER)
						)
						{
							$l_Host = str_replace('www.', '', $_SERVER['HTTP_HOST']);
							for ($j = 0; $j < sizeof($l_Found); $j++)
							{
								$l_Found[$j][1] = str_replace('www.', '', $l_Found[$j][1]);
								if ($l_Found[$j][1] != $l_Host)
								{
									$g_Redirect[] = $i;
									$l_CriticalDetected = true;
									break;
								}
							}
						}
					}

					unset($l_HTAContent);
			    }
			

			    // warnings
				$l_Pos = '';
				
			    if (WarningPHP($l_Filename, $l_Unwrapped, $l_Pos, $l_SigId))
				{       
					$l_Prio = 1;
					if (strpos($l_Filename, '.ph') !== false) {
					   $l_Prio = 0;
					}
					
					$g_WarningPHP[$l_Prio][] = $i;
					$g_WarningPHPFragment[$l_Prio][] = getFragment($l_Unwrapped, $l_Pos);
					$g_WarningPHPSig[] = $l_SigId;

					$l_CriticalDetected = true;
				}
				

				// adware
				if (Adware($l_Filename, $l_Unwrapped, $l_Pos))
				{
					$g_AdwareList[] = $i;
					$g_AdwareListFragment[] = getFragment($l_Unwrapped, $l_Pos);
					$l_CriticalDetected = true;
				}

				// articles
				if (stripos($l_Filename, 'article_index'))
				{
					$g_AdwareList[] = $i;
					$l_CriticalDetected = true;
				}
			}
		} // end of if (!$g_SkipNextCheck) {
			
			unset($l_Unwrapped);
			unset($l_Content);
			
			//printProgress(++$_files_and_ignored, $l_Filename);

			$l_TSEndScan = microtime(true);
                        if ($l_TSEndScan - $l_TSStartScan >= 0.5) {
			   			   usleep(SCAN_DELAY * 1000);
                        }

			if ($g_SkipNextCheck || $l_CriticalDetected) {
				AddResult($l_Filename, $i);
			}
}

function AddResult($l_Filename, $i)
{
	global $g_Structure, $g_CRC;
	
	$l_Stat = stat($l_Filename);
	$g_Structure['n'][$i] = $l_Filename;
	$g_Structure['s'][$i] = $l_Stat['size'];
	$g_Structure['c'][$i] = $l_Stat['ctime'];
	$g_Structure['m'][$i] = $l_Stat['mtime'];
	$g_Structure['crc'][$i] = $g_CRC;
}

///////////////////////////////////////////////////////////////////////////
function WarningPHP($l_FN, $l_Content, &$l_Pos, &$l_SigId)
{
	   global $g_SusDB,$g_ExceptFlex, $gXX_FlexDBShe, $gX_FlexDBShe, $g_FlexDBShe, $gX_DBShe, $g_DBShe, $g_Base64, $g_Base64Fragment;

  $l_Res = false;

  if (AI_EXTRA_WARN) {
  	foreach ($g_SusDB as $l_Item) {
    	if (preg_match('#(' . $l_Item . ')#smiS', $l_Content, $l_Found, PREG_OFFSET_CAPTURE)) {
       	 	if (!CheckException($l_Content, $l_Found)) {
           	 	$l_Pos = $l_Found[0][1];
           	 	$l_SigId = myCheckSum($l_Item);
           	 	return true;
       	 	}
    	}
  	}
  }

  if (AI_EXPERT < 2) {
    	foreach ($gXX_FlexDBShe as $l_Item) {
      		if (preg_match('#(' . $l_Item . ')#smiS', $l_Content, $l_Found, PREG_OFFSET_CAPTURE)) {
             	$l_Pos = $l_Found[0][1];
             	$l_SigId = myCheckSum($l_Item);
        	    return true;
	  		}
    	}

	}

    if (AI_EXPERT < 1) {
    	foreach ($gX_FlexDBShe as $l_Item) {
      		if (preg_match('#(' . $l_Item . ')#smiS', $l_Content, $l_Found, PREG_OFFSET_CAPTURE)) {
             	$l_Pos = $l_Found[0][1];
             	$l_SigId = myCheckSum($l_Item);
        	    return true;
	  		}
    	}

	    $l_Content_lo = strtolower($l_Content);

	    foreach ($gX_DBShe as $l_Item) {
	      $l_Pos = strpos($l_Content_lo, $l_Item);
	      if ($l_Pos !== false) {
	         $l_SigId = myCheckSum($l_Item);
	         return true;
	      }
		}
	}

}

///////////////////////////////////////////////////////////////////////////
function Adware($l_FN, $l_Content, &$l_Pos)
{
  global $g_AdwareSig;

  $l_Res = false;

  foreach ($g_AdwareSig as $l_Item) {
    if (preg_match('#(' . $l_Item . ')#smi', $l_Content, $l_Found, PREG_OFFSET_CAPTURE)) {
       if (!CheckException($l_Content, $l_Found)) {
           $l_Pos = $l_Found[0][1];
           return true;
       }
    }
  }

  return $l_Res;
}

///////////////////////////////////////////////////////////////////////////
function CheckException(&$l_Content, &$l_Found) {
  global $g_ExceptFlex, $gX_FlexDBShe, $gXX_FlexDBShe, $g_FlexDBShe, $gX_DBShe, $g_DBShe, $g_Base64, $g_Base64Fragment;
   $l_FoundStrPlus = substr($l_Content, max($l_Found[0][1] - 10, 0), 70);

   foreach ($g_ExceptFlex as $l_ExceptItem) {
      if (@preg_match('#(' . $l_ExceptItem . ')#smi', $l_FoundStrPlus, $l_Detected)) {
//         print("\n\nEXCEPTION FOUND\n[" . $l_ExceptItem .  "]\n" . $l_Content . "\n\n----------\n\n");
         return true;
      }
   }

   return false;
}

///////////////////////////////////////////////////////////////////////////
function Phishing($l_FN, $l_Index, $l_Content, &$l_SigId)
{
  global $g_PhishingSig, $g_PhishFiles, $g_PhishEntries;

  $l_Res = false;

  // need check file (by extension) ?
  $l_SkipCheck = SMART_SCAN;

if ($l_SkipCheck) {
  	foreach($g_PhishFiles as $l_Ext) {
  		  if (strpos($l_FN, $l_Ext) !== false) {
		  			$l_SkipCheck = false;
		  		  	break;
  	  	  }
  	  }
  }

  // need check file (by signatures) ?
  if ($l_SkipCheck && preg_match('~' . $g_PhishEntries . '~smiS', $l_Content, $l_Found)) {
	  $l_SkipCheck = false;
  }

  if ($l_SkipCheck && SMART_SCAN) {
      if (DEBUG_MODE) {
         echo "Skipped phs file, not critical.\n";
      }

	  return false;
  }


  foreach ($g_PhishingSig as $l_Item) {
    if (preg_match('#(' . $l_Item . ')#smi', $l_Content, $l_Found, PREG_OFFSET_CAPTURE)) {
       if (!CheckException($l_Content, $l_Found)) {
           $l_Pos = $l_Found[0][1];
           $l_SigId = myCheckSum($l_Item);

           if (DEBUG_MODE) {
              echo "Phis: $l_FN matched [$l_Item] in $l_Pos\n";
           }

           return $l_Pos;
       }
    }
  }

  return $l_Res;
}

///////////////////////////////////////////////////////////////////////////
function CriticalJS($l_FN, $l_Index, $l_Content, &$l_SigId)
{
  global $g_JSVirSig, $gX_JSVirSig, $g_VirusFiles, $g_VirusEntries;

  $l_Res = false;
  
    // need check file (by extension) ?
    $l_SkipCheck = SMART_SCAN;
	
	if ($l_SkipCheck) {
    	foreach($g_VirusFiles as $l_Ext) {
    		  if (strpos($l_FN, $l_Ext) !== false) {
  		  			$l_SkipCheck = false;
  		  		  	break;
    	  	  }
    	  }
	  }
  
    // need check file (by signatures) ?
    if ($l_SkipCheck && preg_match('~' . $g_VirusEntries . '~smiS', $l_Content, $l_Found)) {
  	  $l_SkipCheck = false;
    }
  
    if ($l_SkipCheck && SMART_SCAN) {
        if (DEBUG_MODE) {
           echo "Skipped js file, not critical.\n";
        }

  	  return false;
    }
  

  foreach ($g_JSVirSig as $l_Item) {
    if (preg_match('#(' . $l_Item . ')#smi', $l_Content, $l_Found, PREG_OFFSET_CAPTURE)) {
       if (!CheckException($l_Content, $l_Found)) {
           $l_Pos = $l_Found[0][1];
           $l_SigId = myCheckSum($l_Item);

           if (DEBUG_MODE) {
              echo "JS: $l_FN matched [$l_Item] in $l_Pos\n";
           }

           return $l_Pos;
       }
    }
  }

if (AI_EXPERT > 1) {
  foreach ($gX_JSVirSig as $l_Item) {
    if (preg_match('#(' . $l_Item . ')#smi', $l_Content, $l_Found, PREG_OFFSET_CAPTURE)) {
       if (!CheckException($l_Content, $l_Found)) {
           $l_Pos = $l_Found[0][1];
           $l_SigId = myCheckSum($l_Item);

           if (DEBUG_MODE) {
              echo "JS PARA: $l_FN matched [$l_Item] in $l_Pos\n";
           }

           return $l_Pos;
       }
    }
  }
}

  return $l_Res;
}


////////////////////////////////////////////////////////////////////////////
define('SUSP_MTIME', 1); // suspicious mtime (greater than ctime)
define('SUSP_PERM', 2); // suspicious permissions 
define('SUSP_PHP_IN_UPLOAD', 3); // suspicious .php file in upload or image folder 

  function get_descr_heur($type) {
     switch ($type) {
	     case SUSP_MTIME: return AI_STR_077; 
	     case SUSP_PERM: return AI_STR_078;  
	     case SUSP_PHP_IN_UPLOAD: return AI_STR_079; 
	 }
	 
	 return "---";
  }

  ///////////////////////////////////////////////////////////////////////////
  function HeuristicChecker($l_Content, &$l_Type, $l_Filename) {
     $res = false;
	 
	 $l_Stat = stat($l_Filename);
	 // most likely changed by touch
	 if ($l_Stat['ctime'] < $l_Stat['mtime']) {
	     $l_Type = SUSP_MTIME;
		 return true;
	 }

	 	 
	 $l_Perm = fileperms($l_Filename) & 0777;
	 if (($l_Perm & 0400 != 0400) || // not readable by owner
		($l_Perm == 0000) ||
		($l_Perm == 0404) ||
		($l_Perm == 0505))
	 {
		 $l_Type = SUSP_PERM;
		 return true;
	 }

	 
     if ((strpos($l_Filename, '.ph')) && (
	     strpos($l_Filename, '/images/stories/') ||
	     //strpos($l_Filename, '/img/') ||
		 //strpos($l_Filename, '/images/') ||
	     //strpos($l_Filename, '/uploads/') ||
		 strpos($l_Filename, '/wp-content/upload/') 
	    )	    
	 ) {
		$l_Type = SUSP_PHP_IN_UPLOAD;
	 	return true;
	 }

	 	 
	 /*
•	стартует с цифры
•	кол-во цифр в подстроке > 50%
•	паттерн <строчные символы или цифры><2+ заглавные>
•	паттерн <цифры><1-3 символов><цифра>
•	паттерн <символ><3+ цифры><символ>
•	паттерн <символ><4+ цифры>
•	нет гласных букв в строке
•	есть заглавные, строчные и цифры
•	три гласных подряд
•	две цифры не рядом
	 */
	 

     return false;
  }

///////////////////////////////////////////////////////////////////////////
function CriticalPHP($l_FN, $l_Index, $l_Content, &$l_Pos, &$l_SigId)
{
  global $g_ExceptFlex, $gXX_FlexDBShe, $gX_FlexDBShe, $g_FlexDBShe, $gX_DBShe, $g_DBShe, $g_Base64, $g_Base64Fragment,
  $g_CriticalFiles, $g_CriticalEntries;

  // b0c64b734d0ae00f4ec9749fb882d127 H24LKHGHCGHFHGKJHGKJHGGGHJ

  // need check file (by extension) ?
  $l_SkipCheck = SMART_SCAN;

  if ($l_SkipCheck) {
	  foreach($g_CriticalFiles as $l_Ext) {
  	  	if (strpos($l_FN, $l_Ext) !== false) {
			  $l_SkipCheck = false;
		  	break;
  	  		}
  		}
	}
  
  // need check file (by signatures) ?
  if ($l_SkipCheck && preg_match('~' . $g_CriticalEntries . '~smiS', $l_Content, $l_Found)) {
	  $l_SkipCheck = false;
  }
  
  
  // if not critical - skip it 
  if ($l_SkipCheck && SMART_SCAN) {
      if (DEBUG_MODE) {
         echo "Skipped file, not critical.\n";
      }

	  return false;
  }

  if (AI_EXPERT > 1) {
    if (strpos($l_FN, '.php.') !== false ) {
       $g_Base64[] = $l_Index;
       $g_Base64Fragment[] = '".php."';
       $l_Pos = 0;

       if (DEBUG_MODE) {
            echo "CRIT 7: $l_FN matched [$l_Item] in $l_Pos\n";
       }

       AddResult($l_FN, $l_Index);
    }
  }
 
  foreach ($g_FlexDBShe as $l_Item) {
    if (preg_match('#(' . $l_Item . ')#smiS', $l_Content, $l_Found, PREG_OFFSET_CAPTURE)) {
       if (!CheckException($l_Content, $l_Found)) {
           $l_Pos = $l_Found[0][1];
           $l_SigId = myCheckSum($l_Item);

           if (DEBUG_MODE) {
              echo "CRIT 1: $l_FN matched [$l_Item] in $l_Pos\n";
           }

           return true;
       }
    }
  }

if (AI_EXPERT > 1) {
  foreach ($gXX_FlexDBShe as $l_Item) {
    if (preg_match('#(' . $l_Item . ')#smiS', $l_Content, $l_Found, PREG_OFFSET_CAPTURE)) {
       if (!CheckException($l_Content, $l_Found)) {
           $l_Pos = $l_Found[0][1];
           $l_SigId = myCheckSum($l_Item);

           if (DEBUG_MODE) {
              echo "CRIT 2: $l_FN matched [$l_Item] in $l_Pos\n";
           }

           return true;
       }
    }
  }
}

if (AI_EXPERT > 0) {
  foreach ($gX_FlexDBShe as $l_Item) {
    if (preg_match('#(' . $l_Item . ')#smiS', $l_Content, $l_Found, PREG_OFFSET_CAPTURE)) {
       if (!CheckException($l_Content, $l_Found)) {
           $l_Pos = $l_Found[0][1];
           $l_SigId = myCheckSum($l_Item);

           if (DEBUG_MODE) {
              echo "CRIT 3: $l_FN matched [$l_Item] in $l_Pos\n";
           }

           return true;
       }
    }
  }
}

  $l_Content_lo = strtolower($l_Content);

  foreach ($g_DBShe as $l_Item) {
    $l_Pos = strpos($l_Content_lo, $l_Item);
    if ($l_Pos !== false) {
       $l_SigId = myCheckSum($l_Item);

       if (DEBUG_MODE) {
          echo "CRIT 4: $l_FN matched [$l_Item] in $l_Pos\n";
       }

       return true;
    }
  }

if (AI_EXPERT > 0) {
  foreach ($gX_DBShe as $l_Item) {
    $l_Pos = strpos($l_Content_lo, $l_Item);
    if ($l_Pos !== false) {
       $l_SigId = myCheckSum($l_Item);

       if (DEBUG_MODE) {
          echo "CRIT 5: $l_FN matched [$l_Item] in $l_Pos\n";
       }

       return true;
    }
  }

  if ((strpos($l_FN, '.ph') !== false) && (AI_EXPERT > 1)) {
     // for php only
     $g_Specials = ');#';

       $l_Pos = stripos($l_Content, $g_Specials);
       if (($l_Pos !== false) && ($l_Content[$l_Pos + 3] != '#')) {
          $l_SigId = myCheckSum($g_Specials);
          return true;
     }
  }

}

if (AI_EXPERT > 0) {
  if ((strpos($l_Content, 'GIF89') === 0) && (strpos($l_FN, '.php') !== false )) {
     $l_Pos = 0;

     if (DEBUG_MODE) {
          echo "CRIT 6: $l_FN matched [$l_Item] in $l_Pos\n";
     }

     return true;
  }
}

  // detect uploaders / droppers
if (AI_EXPERT > 1) {
  $l_Found = null;
  if (
     (filesize($l_FN) < 1024) &&
     (strpos($l_FN, '.ph') !== false) &&
     (
       (($l_Pos = strpos($l_Content, 'multipart/form-data')) > 0) || 
       (($l_Pos = strpos($l_Content, '$_FILE[') > 0)) ||
       (($l_Pos = strpos($l_Content, 'move_uploaded_file')) > 0) ||
       (preg_match('|\bcopy\s*\(|smi', $l_Content, $l_Found, PREG_OFFSET_CAPTURE))
     )
     ) {
       if ($l_Found != null) {
          $l_Pos = $l_Found[0][1];
       } 
     if (DEBUG_MODE) {
          echo "CRIT 7: $l_FN matched [$l_Item] in $l_Pos\n";
     }

     return true;
  }
}

  return false;
}

///////////////////////////////////////////////////////////////////////////
if (!isCli()) {
   header('Content-type: text/html; charset=utf-8');
}

if (!isCli()) {

  $l_PassOK = false;
  if (strlen(PASS) > 8) {
     $l_PassOK = true;   
  } 

  if ($l_PassOK && preg_match('|[0-9]|', PASS, $l_Found) && preg_match('|[A-Z]|', PASS, $l_Found) && preg_match('|[a-z]|', PASS, $l_Found) ) {
     $l_PassOK = true;   
  }
  
  if (!$l_PassOK) {  
    echo sprintf(AI_STR_009, generatePassword());
    exit;
  }

  if (isset($_GET['fn']) && ($_GET['ph'] == crc32(PASS))) {
     printFile();
     exit;
  }

  if ($_GET['p'] != PASS) {
    $generated_pass = generatePassword(); 
    echo sprintf(AI_STR_010, $generated_pass, $generated_pass);
    exit;
  }
}

if (!is_readable(ROOT_PATH)) {
  echo AI_STR_011;
  exit;
}

if (isCli()) {
	if (defined('REPORT_PATH') AND REPORT_PATH)
	{
		if (!is_writable(REPORT_PATH))
		{
			die("\nCannot write report. Report dir " . REPORT_PATH . " is not writable.");
		}

		else if (!REPORT_FILE)
		{
			die("\nCannot write report. Report filename is empty.");
		}

		else if (($file = REPORT_PATH . DIR_SEPARATOR . REPORT_FILE) AND is_file($file) AND !is_writable($file))
		{
			die("\nCannot write report. Report file '$file' exists but is not writable.");
		}
	}
}


$g_IgnoreList = array();
$g_DirIgnoreList = array();
$g_UrlIgnoreList = array();
$g_KnownList = array();

$l_IgnoreFilename = $g_AiBolitAbsolutePath . '/.aignore';
$l_DirIgnoreFilename = $g_AiBolitAbsolutePath . '/.adirignore';
$l_UrlIgnoreFilename = $g_AiBolitAbsolutePath . '/.aurlignore';
$l_KnownFilename = '.aknown';

if (file_exists($l_IgnoreFilename)) {
    $l_IgnoreListRaw = file($l_IgnoreFilename);
    for ($i = 0; $i < count($l_IgnoreListRaw); $i++) 
    {
    	$g_IgnoreList[] = explode("\t", trim($l_IgnoreListRaw[$i]));
    }
    unset($l_IgnoreListRaw);
}

if (file_exists($l_DirIgnoreFilename)) {
    $g_DirIgnoreList = file($l_DirIgnoreFilename);
	
	for ($i = 0; $i < count($g_DirIgnoreList); $i++) {
		$g_DirIgnoreList[$i] = trim($g_DirIgnoreList[$i]);
	}
}

if (file_exists($l_UrlIgnoreFilename)) {
    $g_UrlIgnoreList = file($l_UrlIgnoreFilename);
	
	for ($i = 0; $i < count($g_UrlIgnoreList); $i++) {
		$g_UrlIgnoreList[$i] = trim($g_UrlIgnoreList[$i]);
	}
}

$g_AiBolitAbsolutePathKnownFiles = dirname($g_AiBolitAbsolutePath) . '/known_files';
$g_AiBolitKnownFilesDirs = array('.');

if ($l_DIRH = @opendir($g_AiBolitAbsolutePathKnownFiles))
{
    while (($l_FileName = readdir($l_DIRH)) !== false)
    {
	   if ($l_FileName == '.' || $l_FileName == '..') continue;
   	   if (defined('CMS') && $l_FileName != CMS) continue;
       array_push($g_AiBolitKnownFilesDirs, $l_FileName);
    }

    closedir($l_DIRH);
}


foreach ($g_AiBolitKnownFilesDirs as $l_PathKnownFiles)
{
    if ($l_PathKnownFiles != '.') {
       $l_AbsolutePathKnownFiles = $g_AiBolitAbsolutePathKnownFiles . '/' . $l_PathKnownFiles;
    } else {
      $l_AbsolutePathKnownFiles = $l_PathKnownFiles;
    }

    if ($l_DIRH = opendir($l_AbsolutePathKnownFiles))
    {
        while (($l_FileName = readdir($l_DIRH)) !== false)
        {
            if ($l_FileName == '.' || $l_FileName == '..') continue;
               if (strpos($l_FileName, $l_KnownFilename) !== false) {
                           stdOut("Loading " . $l_FileName);
                           foreach (new SplFileObject($l_AbsolutePathKnownFiles . '/' . $l_FileName) as $line) {
                               $g_KnownList[(int) $line] = 1;
                           }
                       }
        }
        closedir($l_DIRH);
    }
}

stdOut("Loaded " . count($g_KnownList) . ' known files');

// detect version CMS
$g_CmsListDetector = new CmsVersionDetector(ROOT_PATH);
$l_CmsDetectedNum = $g_CmsListDetector->getCmsNumber();
for ($tt = 0; $tt < $l_CmsDetectedNum; $tt++) {
    $g_CMS[] = $g_CmsListDetector->getCmsName($tt) . ' v' . makeSafeFn($g_CmsListDetector->getCmsVersion($tt));
}

QCR_Debug();

try {
	$s_file = new SplFileObject($g_AiBolitAbsolutePath."/ai-bolit.sig");
	$s_file->setFlags(SplFileObject::READ_AHEAD | SplFileObject::SKIP_EMPTY | SplFileObject::DROP_NEW_LINE);
	foreach ($s_file as $line) {
		$g_FlexDBShe[] = preg_replace('~\G(?:[^#\\\\]+|\\\\.)*+\K#~', '\\#', $line); // escaping #
	}
	stdOut("Loaded " . $s_file->key() . " signatures from ai-bolit.sig");
	$s_file = null; // file handler is closed
} catch (Exception $e) { QCR_Debug( "Import ai-bolit.sig " . $e->getMessage() ); }

QCR_Debug();

	$defaults['skip_ext'] = strtolower(trim($defaults['skip_ext']));
         if ($defaults['skip_ext'] != '') {
	    $g_IgnoredExt = explode(',', $defaults['skip_ext']);
	    for ($i = 0; $i < count($g_IgnoredExt); $i++) {
                $g_IgnoredExt[$i] = trim($g_IgnoredExt[$i]);
             }

	    QCR_Debug('Skip files with extensions: ' . implode(',', $g_IgnoredExt));
	    stdOut('Skip extensions: ' . implode(',', $g_IgnoredExt));
         } 

// scan single file
if (defined('SCAN_FILE')) {
   if (file_exists(SCAN_FILE) && is_file(SCAN_FILE) && is_readable(SCAN_FILE)) {
       stdOut("Start scanning file '" . SCAN_FILE . "'.");
       QCR_ScanFile(SCAN_FILE); 
   } else { 
       stdOut("Error:" . SCAN_FILE . " either is not a file or readable");
   }
} else {
	if (isset($_GET['2check'])) {
		$options['with-2check'] = 1;
	}
   
   // scan list of files from file
   if (!(ICHECK || IMAKE) && isset($options['with-2check']) && file_exists(DOUBLECHECK_FILE)) {
      stdOut("Start scanning the list from '" . DOUBLECHECK_FILE . "'.\n");
      $lines = file(DOUBLECHECK_FILE);
      for ($i = 0, $size = count($lines); $i < $size; $i++) {
         $lines[$i] = trim($lines[$i]);
         if (empty($lines[$i])) unset($lines[$i]);
      }
      /* skip first line with <?php die("Forbidden"); ?> */
      unset($lines[0]);
      $g_FoundTotalFiles = count($lines);
      $i = 1;
      foreach ($lines as $l_FN) {
         is_dir($l_FN) && $g_TotalFolder++;
         printProgress( $i++, $l_FN);
         $BOOL_RESULT = true; // display disable
         is_file($l_FN) && QCR_ScanFile($l_FN, $i);
         $BOOL_RESULT = false; // display enable
      }

      $g_FoundTotalDirs = $g_TotalFolder;
      $g_FoundTotalFiles = $g_TotalFiles;

   } else {
      // scan whole file system
      stdOut("Start scanning '" . ROOT_PATH . "'.\n");
      
      file_exists(QUEUE_FILENAME) && unlink(QUEUE_FILENAME);
      if (ICHECK || IMAKE) {
      // INTEGRITY CHECK
        IMAKE and unlink(INTEGRITY_DB_FILE);
        ICHECK and load_integrity_db();
        QCR_IntegrityCheck(ROOT_PATH);
        stdOut("Found $g_FoundTotalFiles files in $g_FoundTotalDirs directories.");
        if (IMAKE) exit(0);
        if (ICHECK) {
            $i = $g_Counter;
            $g_CRC = 0;
            $changes = array();
            $ref =& $g_IntegrityDB;
            foreach ($g_IntegrityDB as $l_FileName => $type) {
                unset($g_IntegrityDB[$l_FileName]);
                $l_Ext2 = substr(strstr(basename($l_FileName), '.'), 1);
                if (in_array(strtolower($l_Ext2), $g_IgnoredExt)) {
                    continue;
                }
                for ($dr = 0; $dr < count($g_DirIgnoreList); $dr++) {
                    if (($g_DirIgnoreList[$dr] != '') && preg_match('#' . $g_DirIgnoreList[$dr] . '#', $l_FileName, $l_Found)) {
                        continue 2;
                    }
                }
                $type = in_array($type, array('added', 'modified')) ? $type : 'deleted';
                $type .= substr($l_FileName, -1) == '/' ? 'Dirs' : 'Files';
                $changes[$type][] = ++$i;
                AddResult($l_FileName, $i);
            }
            $g_FoundTotalFiles = count($changes['addedFiles']) + count($changes['modifiedFiles']);
            stdOut("Found changes " . count($changes['modifiedFiles']) . " files and added " . count($changes['addedFiles']) . " files.");
        }
        
      } else {
      QCR_ScanDirectories(ROOT_PATH);
      stdOut("Found $g_FoundTotalFiles files in $g_FoundTotalDirs directories.");
      }

      QCR_Debug();
      stdOut(str_repeat(' ', 160),false);
      QCR_GoScan(0);
      unlink(QUEUE_FILENAME);
   }
}

QCR_Debug();



////////////////////////////////////////////////////////////////////////////
 if ($BOOL_RESULT) {
  if ((count($g_CriticalPHP) > 0) OR (count($g_CriticalJS) > 0) OR (count($g_Base64) > 0) OR  (count($g_Iframer) > 0) OR  (count($g_UnixExec) > 0))
  {
  echo "1\n";
  exit(0);
  }
 }
////////////////////////////////////////////////////////////////////////////

$l_Template = str_replace("@@PATH_URL@@", (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $g_AddPrefix . str_replace($g_NoPrefix, '', addSlash(ROOT_PATH))), $l_Template);

$time_taken = seconds2Human(microtime(true) - START_TIME);

$l_Template = str_replace("@@SCANNED@@", sprintf(AI_STR_013, $g_TotalFolder, $g_TotalFiles), $l_Template);

$l_ShowOffer = false;

stdOut("\nBuilding report [ mode = " . AI_EXPERT . " ]\n");

////////////////////////////////////////////////////////////////////////////
// save 
if (!(ICHECK || IMAKE))
if (isset($options['with-2check']) || isset($options['quarantine']))
if ((count($g_CriticalPHP) > 0) OR (count($g_CriticalJS) > 0) OR (count($g_Base64) > 0) OR 
   (count($g_Iframer) > 0) OR  (count($g_UnixExec))) 
{
  if (!file_exists(DOUBLECHECK_FILE)) {	  
      if ($l_FH = fopen(DOUBLECHECK_FILE, 'w')) {
         fputs($l_FH, '<?php die("Forbidden"); ?>' . "\n");

         $l_CurrPath = dirname(__FILE__);
		 
		 if (!isset($g_CriticalPHP)) { $g_CriticalPHP = array(); }
		 if (!isset($g_CriticalJS)) { $g_CriticalJS = array(); }
		 if (!isset($g_Iframer)) { $g_Iframer = array(); }
		 if (!isset($g_Base64)) { $g_Base64 = array(); }
		 if (!isset($g_Phishing)) { $g_Phishing = array(); }
		 if (!isset($g_AdwareList)) { $g_AdwareList = array(); }
		 if (!isset($g_Redirect)) { $g_Redirect = array(); }
		 
         $tmpIndex = array_merge($g_CriticalPHP, $g_CriticalJS, $g_Phishing, $g_Base64, $g_Iframer, $g_AdwareList, $g_Redirect);
         $tmpIndex = array_values(array_unique($tmpIndex));

         for ($i = 0; $i < count($tmpIndex); $i++) {
             $tmpIndex[$i] = str_replace($l_CurrPath, '.', $g_Structure['n'][$tmpIndex[$i]]);
         }

         for ($i = 0; $i < count($g_UnixExec); $i++) {
             $tmpIndex[] = str_replace($l_CurrPath, '.', $g_UnixExec[$i]);
         }

         $tmpIndex = array_values(array_unique($tmpIndex));

         for ($i = 0; $i < count($tmpIndex); $i++) {
             fputs($l_FH, $tmpIndex[$i] . "\n");
         }

         fclose($l_FH);
      } else {
         stdOut("Error! Cannot create " . DOUBLECHECK_FILE);
      }      
  } else {
      stdOut(DOUBLECHECK_FILE . ' already exists.');
      if (AI_STR_044 != '') $l_Result .= '<div class="rep">' . AI_STR_044 . '</div>';
  }
 
}

////////////////////////////////////////////////////////////////////////////

$l_Summary = '<div class="title">' . AI_STR_074 . '</div>';
$l_Summary .= '<table cellspacing=0 border=0>';

if (count($g_Redirect) > 0) {
   $l_Summary .= makeSummary(AI_STR_059, count($g_Redirect), "crit");
}

if (count($g_CriticalPHP) > 0) {
   $l_Summary .= makeSummary(AI_STR_060, count($g_CriticalPHP), "crit");
}

if (count($g_CriticalJS) > 0) {
   $l_Summary .= makeSummary(AI_STR_061, count($g_CriticalJS), "crit");
}

if (count($g_Phishing) > 0) {
   $l_Summary .= makeSummary(AI_STR_062, count($g_Phishing), "crit");
}

if (count($g_UnixExec) > 0) {
   $l_Summary .= makeSummary(AI_STR_063, count($g_UnixExec), (AI_EXPERT > 1 ? 'crit' : 'warn'));
}

if (count($g_Iframer) > 0) {
   $l_Summary .= makeSummary(AI_STR_064, count($g_Iframer), "crit");
}

if (count($g_NotRead) > 0) {
   $l_Summary .= makeSummary(AI_STR_066, count($g_NotRead), "crit");
}

if (count($g_Base64) > 0) {
   $l_Summary .= makeSummary(AI_STR_067, count($g_Base64), (AI_EXPERT > 1 ? 'crit' : 'warn'));
}

if (count($g_BigFiles) > 0) {
   $l_Summary .= makeSummary(AI_STR_065, count($g_BigFiles), "warn");
}

if (count($g_HeuristicDetected) > 0) {
   $l_Summary .= makeSummary(AI_STR_068, count($g_HeuristicDetected), "warn");
}

if (count($g_SymLinks) > 0) {
   $l_Summary .= makeSummary(AI_STR_069, count($g_SymLinks), "warn");
}

if (count($g_HiddenFiles) > 0) {
   $l_Summary .= makeSummary(AI_STR_070, count($g_HiddenFiles), "warn");
}

if (count($g_AdwareList) > 0) {
   $l_Summary .= makeSummary(AI_STR_072, count($g_AdwareList), "warn");
}

if (count($g_EmptyLink) > 0) {
   $l_Summary .= makeSummary(AI_STR_073, count($g_EmptyLink), "warn");
}

 $l_Summary .= "</table><div class=details style=\"margin: 20px 20px 20px 0\">" . AI_STR_080 . "</div>\n";

 $l_Template = str_replace("@@SUMMARY@@", $l_Summary, $l_Template);


 $l_Result .= AI_STR_015;
 
 $l_Template = str_replace("@@VERSION@@", AI_VERSION, $l_Template);
 
////////////////////////////////////////////////////////////////////////////



if (function_exists("gethostname") && is_callable("gethostname")) {
  $l_HostName = gethostname();
} else {
  $l_HostName = '???';
}

$l_PlainResult = "# Malware list detected by AI-Bolit (https://revisium.com/ai/) on " . date("d/m/Y H:i:s", time()) . " " . $l_HostName .  "\n\n";

stdOut("Building list of vulnerable scripts " . count($g_Vulnerable));

if (count($g_Vulnerable) > 0) {
    $l_Result .= '<div class="note_vir">' . AI_STR_081 . ' (' . count($g_Vulnerable) . ')</div><div class="crit">';
 	foreach ($g_Vulnerable as $l_Item) {
	    $l_Result .= '<li>' . makeSafeFn($g_Structure['n'][$l_Item['ndx']], true) . ' - ' . $l_Item['id'] . '</li>';
            $l_PlainResult .= '[VULNERABILITY] ' . replacePathArray($g_Structure['n'][$l_Item['ndx']]) . ' - ' . $l_Item['id'] . "\n";
 	}
	
  $l_Result .= '</div><p>' . PHP_EOL;
  $l_PlainResult .= "\n";
}


stdOut("Building list of shells " . count($g_CriticalPHP));

if (count($g_CriticalPHP) > 0) {
  $l_Result .= '<div class="note_vir">' . AI_STR_016 . ' (' . count($g_CriticalPHP) . ')</div><div class="crit">';
  $l_Result .= printList($g_CriticalPHP, $g_CriticalPHPFragment, true, $g_CriticalPHPSig, 'table_crit');
  $l_PlainResult .= '[SERVER MALWARE]' . "\n" . printPlainList($g_CriticalPHP, $g_CriticalPHPFragment, true, $g_CriticalPHPSig, 'table_crit') . "\n";
  $l_Result .= '</div>' . PHP_EOL;

  $l_ShowOffer = true;
} else {
  $l_Result .= '<div class="ok"><b>' . AI_STR_017. '</b></div>';
}

stdOut("Building list of js " . count($g_CriticalJS));

if (count($g_CriticalJS) > 0) {
  $l_Result .= '<div class="note_vir">' . AI_STR_018 . ' (' . count($g_CriticalJS) . ')</div><div class="crit">';
  $l_Result .= printList($g_CriticalJS, $g_CriticalJSFragment, true, $g_CriticalJSSig, 'table_vir');
  $l_PlainResult .= '[CLIENT MALWARE / JS]'  . "\n" . printPlainList($g_CriticalJS, $g_CriticalJSFragment, true, $g_CriticalJSSig, 'table_vir') . "\n";
  $l_Result .= "</div>" . PHP_EOL;

  $l_ShowOffer = true;
}

stdOut("Building phishing pages " . count($g_Phishing));

if (count($g_Phishing) > 0) {
  $l_Result .= '<div class="note_vir">' . AI_STR_058 . ' (' . count($g_Phishing) . ')</div><div class="crit">';
  $l_Result .= printList($g_Phishing, $g_PhishingFragment, true, $g_PhishingSigFragment, 'table_vir');
  $l_PlainResult .= '[PHISHING]'  . "\n" . printPlainList($g_Phishing, $g_PhishingFragment, true, $g_PhishingSigFragment, 'table_vir') . "\n";
  $l_Result .= "</div>". PHP_EOL;

  $l_ShowOffer = true;
}

stdOut("Building list of iframes " . count($g_Iframer));

if (count($g_Iframer) > 0) {
  $l_ShowOffer = true;
  $l_Result .= '<div class="note_vir">' . AI_STR_021 . ' (' . count($g_Iframer) . ')</div><div class="crit">';
  $l_Result .= printList($g_Iframer, $g_IframerFragment, true);
  $l_Result .= "</div>" . PHP_EOL;

}

stdOut("Building list of base64s " . count($g_Base64));

if (count($g_Base64) > 0) {
  if (AI_EXPERT > 1) $l_ShowOffer = true;
  
  $l_Result .= '<div class="note_' . (AI_EXPERT > 1 ? 'vir' : 'warn') . '">' . AI_STR_020 . ' (' . count($g_Base64) . ')</div><div class="' . (AI_EXPERT > 1 ? 'crit' : 'warn') . '">';
  $l_Result .= printList($g_Base64, $g_Base64Fragment, true);
  $l_PlainResult .= '[ENCODED / SUSP_EXT]' . "\n" . printPlainList($g_Base64, $g_Base64Fragment, true) . "\n";
  $l_Result .= "</div>" . PHP_EOL;

}

stdOut("Building list of redirects " . count($g_Redirect));
if (count($g_Redirect) > 0) {
  $l_ShowOffer = true;
  $l_Result .= '<div class="note_vir">' . AI_STR_027 . ' (' . count($g_Redirect) . ')</div><div class="crit">';
  $l_Result .= printList($g_Redirect, $g_RedirectPHPFragment, true);
  $l_Result .= "</div>" . PHP_EOL;
}


stdOut("Building list of unread files " . count($g_NotRead));

if (count($g_NotRead) > 0) {
  $l_Result .= '<div class="note_vir">' . AI_STR_030 . ' (' . count($g_NotRead) . ')</div><div class="crit">';
  $l_Result .= printList($g_NotRead);
  $l_Result .= "</div><div class=\"spacer\"></div>" . PHP_EOL;
  $l_PlainResult .= '[SCAN ERROR / SKIPPED]' . "\n" . implode("\n", replacePathArray($g_NotRead)) . "\n\n";
}

stdOut("Building list of symlinks " . count($g_SymLinks));

if (count($g_SymLinks) > 0) {
  $l_Result .= '<div class="note_vir">' . AI_STR_022 . ' (' . count($g_SymLinks) . ')</div><div class="crit">';
  $l_Result .= nl2br(makeSafeFn(implode("\n", $g_SymLinks), true));
  $l_Result .= "</div><div class=\"spacer\"></div>";
}

stdOut("Building list of unix executables and odd scripts " . count($g_UnixExec));

if (count($g_UnixExec) > 0) {
  $l_Result .= '<div class="note_' . (AI_EXPERT > 1 ? 'vir' : 'warn') . '">' . AI_STR_019 . ' (' . count($g_UnixExec) . ')</div><div class="' . (AI_EXPERT > 1 ? 'crit' : 'warn') . '">';
  $l_Result .= nl2br(makeSafeFn(implode("\n", $g_UnixExec), true));
  $l_PlainResult .= '[UNIX EXEC]' . "\n" . implode("\n", replacePathArray($g_UnixExec)) . "\n\n";
  $l_Result .= "</div>" . PHP_EOL;

  if (AI_EXPERT > 1) $l_ShowOffer = true;
}

////////////////////////////////////
$l_WarningsNum = count($g_HeuristicDetected) + count($g_HiddenFiles) + count($g_BigFiles) + count($g_PHPCodeInside) + count($g_AdwareList) + count($g_EmptyLink) + count($g_Doorway) + (count($g_WarningPHP[0]) + count($g_WarningPHP[1]) + count($g_SkippedFolders));

if ($l_WarningsNum > 0) {
	$l_Result .= "<div style=\"margin-top: 20px\" class=\"title\">" . AI_STR_026 . "</div>";
}

stdOut("Building list of links/adware " . count($g_AdwareList));

if (count($g_AdwareList) > 0) {
  $l_Result .= '<div class="note_warn">' . AI_STR_029 . '</div><div class="warn">';
  $l_Result .= printList($g_AdwareList, $g_AdwareListFragment, true);
  $l_PlainResult .= '[ADWARE]' . "\n" . printPlainList($g_AdwareList, $g_AdwareListFragment, true) . "\n";
  $l_Result .= "</div>" . PHP_EOL;

}

stdOut("Building list of heuristics " . count($g_HeuristicDetected));

if (count($g_HeuristicDetected) > 0) {
  $l_Result .= '<div class="note_warn">' . AI_STR_052 . ' (' . count($g_HeuristicDetected) . ')</div><div class="warn">';
  for ($i = 0; $i < count($g_HeuristicDetected); $i++) {
	   $l_Result .= '<li>' . makeSafeFn($g_Structure['n'][$g_HeuristicDetected[$i]], true) . ' (' . get_descr_heur($g_HeuristicType[$i]) . ')</li>';
  }
  
  $l_Result .= '</ul></div><div class=\"spacer\"></div>' . PHP_EOL;
}

stdOut("Building list of hidden files " . count($g_HiddenFiles));
if (count($g_HiddenFiles) > 0) {
  $l_Result .= '<div class="note_warn">' . AI_STR_023 . ' (' . count($g_HiddenFiles) . ')</div><div class="warn">';
  $l_Result .= nl2br(makeSafeFn(implode("\n", $g_HiddenFiles), true));
  $l_Result .= "</div><div class=\"spacer\"></div>" . PHP_EOL;
  $l_PlainResult .= '[HIDDEN]' . "\n" . implode("\n", replacePathArray($g_HiddenFiles)) . "\n\n";
}

stdOut("Building list of bigfiles " . count($g_BigFiles));
$max_size_to_scan = getBytes(MAX_SIZE_TO_SCAN);
$max_size_to_scan = $max_size_to_scan > 0 ? $max_size_to_scan : getBytes('1m');

if (count($g_BigFiles) > 0) {
  $l_Result .= "<div class=\"note_warn\">" . sprintf(AI_STR_038, bytes2Human($max_size_to_scan)) . '</div><div class="warn">';
  $l_Result .= printList($g_BigFiles);
  $l_Result .= "</div>";
  $l_PlainResult .= '[BIG FILES / SKIPPED]' . "\n" . printPlainList($g_BigFiles) . "\n\n";
} 

stdOut("Building list of php inj " . count($g_PHPCodeInside));

if ((count($g_PHPCodeInside) > 0) && (($defaults['report_mask'] & REPORT_MASK_PHPSIGN) == REPORT_MASK_PHPSIGN)) {
  $l_Result .= '<div class="note_warn">' . AI_STR_028 . '</div><div class="warn">';
  $l_Result .= printList($g_PHPCodeInside, $g_PHPCodeInsideFragment, true);
  $l_Result .= "</div>" . PHP_EOL;

}

stdOut("Building list of empty links " . count($g_EmptyLink));
if (count($g_EmptyLink) > 0) {
  $l_Result .= '<div class="note_warn">' . AI_STR_031 . '</div><div class="warn">';
  $l_Result .= printList($g_EmptyLink, '', true);

  $l_Result .= AI_STR_032 . '<br/>';
  
  if (count($g_EmptyLink) == MAX_EXT_LINKS) {
      $l_Result .= '(' . AI_STR_033 . MAX_EXT_LINKS . ')<br/>';
    }
   
  for ($i = 0; $i < count($g_EmptyLink); $i++) {
	$l_Idx = $g_EmptyLink[$i];
    for ($j = 0; $j < count($g_EmptyLinkSrc[$l_Idx]); $j++) {
      $l_Result .= '<span class="details">' . makeSafeFn($g_Structure['n'][$g_EmptyLink[$i]], true) . ' &rarr; ' . htmlspecialchars($g_EmptyLinkSrc[$l_Idx][$j]) . '</span><br/>';
	}
  }

  $l_Result .= "</div>";

}

stdOut("Building list of doorways " . count($g_Doorway));

if ((count($g_Doorway) > 0) && (($defaults['report_mask'] & REPORT_MASK_DOORWAYS) == REPORT_MASK_DOORWAYS)) {
  $l_Result .= '<div class="note_warn">' . AI_STR_034 . '</div><div class="warn">';
  $l_Result .= printList($g_Doorway);
  $l_Result .= "</div>" . PHP_EOL;

}

stdOut("Building list of php warnings " . (count($g_WarningPHP[0]) + count($g_WarningPHP[1])));

if (($defaults['report_mask'] & REPORT_MASK_SUSP) == REPORT_MASK_SUSP) {
   if ((count($g_WarningPHP[0]) + count($g_WarningPHP[1])) > 0) {
     $l_Result .= '<div class="note_warn">' . AI_STR_035 . '</div><div class="warn">';

     for ($i = 0; $i < count($g_WarningPHP); $i++) {
         if (count($g_WarningPHP[$i]) > 0) 
            $l_Result .= printList($g_WarningPHP[$i], $g_WarningPHPFragment[$i], true, $g_WarningPHPSig, 'table_warn' . $i);
     }                                                                                                                    
     $l_Result .= "</div>" . PHP_EOL;

   } 
}

stdOut("Building list of skipped dirs " . count($g_SkippedFolders));
if (count($g_SkippedFolders) > 0) {
  $l_Result .= '<div class="note_warn">' . AI_STR_036 . '</div><div class="warn">';
     $l_Result .= nl2br(makeSafeFn(implode("\n", $g_SkippedFolders), true));   
     $l_Result .= "</div>" . PHP_EOL;
 }

 if (count($g_CMS) > 0) {
      $l_Result .= "<div class=\"note_warn\">" . AI_STR_037 . "<br/>";
      $l_Result .= nl2br(makeSafeFn(implode("\n", $g_CMS)));
      $l_Result .= "</div>";
 }


if (ICHECK) {
	$l_Result .= "<div style=\"margin-top: 20px\" class=\"title\">" . AI_STR_087 . "</div>";
	
    stdOut("Building list of added files " . count($changes['addedFiles']));
    if (count($changes['addedFiles']) > 0) {
      $l_Result .= '<div class="note_int">' . AI_STR_082 . ' (' . count($changes['addedFiles']) . ')</div><div class="intitem">';
      $l_Result .= printList($changes['addedFiles']);
      $l_Result .= "</div>" . PHP_EOL;
    }

    stdOut("Building list of modified files " . count($changes['modifiedFiles']));
    if (count($changes['modifiedFiles']) > 0) {
      $l_Result .= '<div class="note_int">' . AI_STR_083 . ' (' . count($changes['modifiedFiles']) . ')</div><div class="intitem">';
      $l_Result .= printList($changes['modifiedFiles']);
      $l_Result .= "</div>" . PHP_EOL;
    }

    stdOut("Building list of deleted files " . count($changes['deletedFiles']));
    if (count($changes['deletedFiles']) > 0) {
      $l_Result .= '<div class="note_int">' . AI_STR_084 . ' (' . count($changes['deletedFiles']) . ')</div><div class="intitem">';
      $l_Result .= printList($changes['deletedFiles']);
      $l_Result .= "</div>" . PHP_EOL;
    }

    stdOut("Building list of added dirs " . count($changes['addedDirs']));
    if (count($changes['addedDirs']) > 0) {
      $l_Result .= '<div class="note_int">' . AI_STR_085 . ' (' . count($changes['addedDirs']) . ')</div><div class="intitem">';
      $l_Result .= printList($changes['addedDirs']);
      $l_Result .= "</div>" . PHP_EOL;
    }

    stdOut("Building list of deleted dirs " . count($changes['deletedDirs']));
    if (count($changes['deletedDirs']) > 0) {
      $l_Result .= '<div class="note_int">' . AI_STR_086 . ' (' . count($changes['deletedDirs']) . ')</div><div class="intitem">';
      $l_Result .= printList($changes['deletedDirs']);
      $l_Result .= "</div>" . PHP_EOL;
    }
}

if (!isCli()) {
   $l_Result .= QCR_ExtractInfo($l_PhpInfoBody[1]);
}


if (function_exists('memory_get_peak_usage')) {
  $l_Template = str_replace("@@MEMORY@@", AI_STR_043 . bytes2Human(memory_get_peak_usage()), $l_Template);
}

$l_Template = str_replace('@@WARN_QUICK@@', (SCAN_ALL_FILES ? '' : AI_STR_045), $l_Template);

if ($l_ShowOffer) {
	$l_Template = str_replace('@@OFFER@@', $l_Offer, $l_Template);
} else {
	$l_Template = str_replace('@@OFFER@@', AI_STR_002, $l_Template);
}

$l_Template = str_replace('@@CAUTION@@', AI_STR_003, $l_Template);

$l_Template = str_replace('@@CREDITS@@', AI_STR_075, $l_Template);

$l_Template = str_replace('@@FOOTER@@', AI_STR_076, $l_Template);

$l_Template = str_replace('@@STAT@@', sprintf(AI_STR_012, $time_taken, date('d-m-Y в H:i:s', floor(START_TIME)) , date('d-m-Y в H:i:s')), $l_Template);

////////////////////////////////////////////////////////////////////////////
$l_Template = str_replace("@@MAIN_CONTENT@@", $l_Result, $l_Template);

if (!isCli())
{
    echo $l_Template;
    exit;
}

if (!defined('REPORT') OR REPORT === '')
{
	die('Report not written.');
}
 
// write plain text result
if (PLAIN_FILE != '') {
	
    $l_PlainResult = preg_replace('|__AI_LINE1__|smi', '[', $l_PlainResult);
    $l_PlainResult = preg_replace('|__AI_LINE2__|smi', '] ', $l_PlainResult);
    $l_PlainResult = preg_replace('|__AI_MARKER__|smi', ' %> ', $l_PlainResult);

   if ($l_FH = fopen(PLAIN_FILE, "w")) {
      fputs($l_FH, $l_PlainResult);
      fclose($l_FH);
   }
}

$emails = getEmails(REPORT);

if (!$emails) {
	if ($l_FH = fopen($file, "w")) {
	   fputs($l_FH, $l_Template);
	   fclose($l_FH);
	   stdOut("\nReport written to '$file'.");
	} else {
		stdOut("\nCannot create '$file'.");
	}
}	else	{
		$headers = array(
			'MIME-Version: 1.0',
			'Content-type: text/html; charset=UTF-8',
			'From: ' . ($defaults['email_from'] ? $defaults['email_from'] : 'AI-Bolit@myhost')
		);

		for ($i = 0, $size = sizeof($emails); $i < $size; $i++)
		{
			mail($emails[$i], 'AI-Bolit Report ' . date("d/m/Y H:i", time()), $l_Result, implode("\r\n", $headers));
		}

		stdOut("\nReport sended to " . implode(', ', $emails));
}


$time_taken = microtime(true) - START_TIME;
$time_taken = number_format($time_taken, 5);

stdOut("Scanning complete! Time taken: " . seconds2Human($time_taken));

stdOut("\n\n!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!");
stdOut("Attention! DO NOT LEAVE either ai-bolit.php or AI-BOLIT-REPORT-<xxxx>-<yy>.html \nfile on server. COPY it locally then REMOVE from server. ");
stdOut("!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!");

if (isset($options['quarantine'])) {
	Quarantine();
}

if (isset($options['cmd'])) {
	stdOut("Run \"{$options['cmd']}\" ");
	system($options['cmd']);
}

QCR_Debug();

# exit with code

$l_EC1 = count($g_CriticalPHP);
$l_EC2 = count($g_CriticalJS) + count($g_Phishing) + count($g_WarningPHP[0]) + count($g_WarningPHP[1]);

if ($l_EC1 > 0) {
	stdOut('Exit code 2');
	exit(2);
} else {
	if ($l_EC2 > 0) {
		stdOut('Exit code 1');
		exit(1);
	}
}

stdOut('Exit code 0');
exit(0);

############################################# END ###############################################

function Quarantine()
{
	if (!file_exists(DOUBLECHECK_FILE)) {
		return;
	}
	
	$g_QuarantinePass = 'aibolit';
	
	$archive = "AI-QUARANTINE-" .rand(100000, 999999) . ".zip";
	$infoFile = substr($archive, 0, -3) . "txt";
	$report = REPORT_PATH . DIR_SEPARATOR . REPORT_FILE;
	

	foreach (file(DOUBLECHECK_FILE) as $file) {
		$file = trim($file);
		if (!is_file($file)) continue;
	
		$lStat = stat($file);
		
		// skip files over 300KB
		if ($lStat['size'] > 300*1024) continue;

		// http://www.askapache.com/security/chmod-stat.html
		$p = $lStat['mode'];
		$perm ='-';
		$perm.=(($p&0x0100)?'r':'-').(($p&0x0080)?'w':'-');
		$perm.=(($p&0x0040)?(($p&0x0800)?'s':'x'):(($p&0x0800)?'S':'-'));
		$perm.=(($p&0x0020)?'r':'-').(($p&0x0010)?'w':'-');
		$perm.=(($p&0x0008)?(($p&0x0400)?'s':'x'):(($p&0x0400)?'S':'-'));
		$perm.=(($p&0x0004)?'r':'-').(($p&0x0002)?'w':'-');
		$perm.=(($p&0x0001)?(($p&0x0200)?'t':'x'):(($p&0x0200)?'T':'-'));
		
		$owner = (function_exists('posix_getpwuid'))? @posix_getpwuid($lStat['uid']) : array('name' => $lStat['uid']);
		$group = (function_exists('posix_getgrgid'))? @posix_getgrgid($lStat['gid']) : array('name' => $lStat['uid']);

		$inf['permission'][] = $perm;
		$inf['owner'][] = $owner['name'];
		$inf['group'][] = $group['name'];
		$inf['size'][] = $lStat['size'] > 0 ? bytes2Human($lStat['size']) : '-';
		$inf['ctime'][] = $lStat['ctime'] > 0 ? date("d/m/Y H:i:s", $lStat['ctime']) : '-';
		$inf['mtime'][] = $lStat['mtime'] > 0 ? date("d/m/Y H:i:s", $lStat['mtime']) : '-';
		$files[] = strpos($file, './') === 0 ? substr($file, 2) : $file;
	}
	
	// get config files for cleaning
	$configFilesRegex = 'config(uration|\.in[ic])?\.php$|dbconn\.php$';
	$configFiles = preg_grep("~$configFilesRegex~", $files);

	// get columns width
	$width = array();
	foreach (array_keys($inf) as $k) {
		$width[$k] = strlen($k);
		for ($i = 0; $i < count($inf[$k]); ++$i) {
			$len = strlen($inf[$k][$i]);
			if ($len > $width[$k])
				$width[$k] = $len;
		}
	}

	// headings of columns
	$info = '';
	foreach (array_keys($inf) as $k) {
		$info .= str_pad($k, $width[$k], ' ', STR_PAD_LEFT). ' ';
	}
	$info .= "name\n";
	
	for ($i = 0; $i < count($files); ++$i) {
		foreach (array_keys($inf) as $k) {
			$info .= str_pad($inf[$k][$i], $width[$k], ' ', STR_PAD_LEFT). ' ';
		}
		$info .= $files[$i]."\n";
	}
	unset($inf, $width);

	exec("zip -v 2>&1", $output,$code);

	if ($code == 0) {
		$filter = '';
		if ($configFiles && exec("grep -V 2>&1", $output, $code) && $code == 0) {
			$filter = "|grep -v -E '$configFilesRegex'";
		}

		exec("cat AI-BOLIT-DOUBLECHECK.php $filter |zip -@ --password $g_QuarantinePass $archive", $output, $code);
		if ($code == 0) {
			file_put_contents($infoFile, $info);
			$m = array();
			if (!empty($filter)) {
				foreach ($configFiles as $file) {
					$tmp = file_get_contents($file);
					// remove  passwords
					$tmp = preg_replace('~^.*?pass.*~im', '', $tmp);
					// new file name
					$file = preg_replace('~.*/~', '', $file) . '-' . rand(100000, 999999);
					file_put_contents($file, $tmp);
					$m[] = $file;
				}
			}

			exec("zip -j --password $g_QuarantinePass $archive $infoFile $report " . DOUBLECHECK_FILE . ' ' . implode(' ', $m));
			stdOut("\nCreate archive '" . realpath($archive) . "'");
			stdOut("This archive have password '$g_QuarantinePass'");
			foreach ($m as $file) unlink($file);
			unlink($infoFile);
			return;
		}
	}
	
	$zip = new ZipArchive;
	
	if ($zip->open($archive, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE) === false) {
		stdOut("Cannot create '$archive'.");
		return;
	}

	foreach ($files as $file) {
		if (in_array($file, $configFiles)) {
			$tmp = file_get_contents($file);
			// remove  passwords
			$tmp = preg_replace('~^.*?pass.*~im', '', $tmp);
			$zip->addFromString($file, $tmp);
		} else {
			$zip->addFile($file);
		}
	}
	$zip->addFile(DOUBLECHECK_FILE, DOUBLECHECK_FILE);
	$zip->addFile($report, REPORT_FILE);
	$zip->addFromString($infoFile, $info);
	$zip->close();

	stdOut("\nCreate archive '" . realpath($archive) . "'.");
	stdOut("This archive has no password!");
}



///////////////////////////////////////////////////////////////////////////
function QCR_IntegrityCheck($l_RootDir)
{
	global $g_Structure, $g_Counter, $g_Doorway, $g_FoundTotalFiles, $g_FoundTotalDirs, 
			$defaults, $g_SkippedFolders, $g_UrlIgnoreList, $g_DirIgnoreList, $g_UnsafeDirArray, 
                        $g_UnsafeFilesFound, $g_SymLinks, $g_HiddenFiles, $g_UnixExec, $g_IgnoredExt, $g_SuspiciousFiles;
	global $g_IntegrityDB, $g_ICheck;
	static $l_Buffer = '';
	
	$l_DirCounter = 0;
	$l_DoorwayFilesCounter = 0;
	$l_SourceDirIndex = $g_Counter - 1;
	
	QCR_Debug('Check ' . $l_RootDir);

 	if ($l_DIRH = @opendir($l_RootDir))
	{
		while (($l_FileName = readdir($l_DIRH)) !== false)
		{
			if ($l_FileName == '.' || $l_FileName == '..') continue;

			$l_FileName = $l_RootDir . DIR_SEPARATOR . $l_FileName;

			$l_Type = filetype($l_FileName);
			$l_IsDir = ($l_Type == "dir");
            if ($l_Type == "link") 
            {
				$g_SymLinks[] = $l_FileName;
                continue;
            } else 
			if ($l_Type != "file" && (!$l_IsDir)) {
				$g_UnixExec[] = $l_FileName;
				continue;
			}	
						
			$l_Ext = substr($l_FileName, strrpos($l_FileName, '.') + 1);

			$l_NeedToScan = true;
			$l_Ext2 = substr(strstr(basename($l_FileName), '.'), 1);
			if (in_array(strtolower($l_Ext2), $g_IgnoredExt)) {
                           $l_NeedToScan = false;
            }
			
			if (getRelativePath($l_FileName) == "./" . INTEGRITY_DB_FILE) $l_NeedToScan = false;

			if ($l_IsDir)
			{
				// if folder in ignore list
				$l_Skip = false;
				for ($dr = 0; $dr < count($g_DirIgnoreList); $dr++) {
					if (($g_DirIgnoreList[$dr] != '') &&
						preg_match('#' . $g_DirIgnoreList[$dr] . '#', $l_FileName, $l_Found)) {
						$l_Skip = true;
					}
				}
			
				// skip on ignore
				if ($l_Skip) {
					$g_SkippedFolders[] = $l_FileName;
					continue;
				}
				
				$l_BaseName = basename($l_FileName);

				$l_DirCounter++;

				$g_Counter++;
				$g_FoundTotalDirs++;

				QCR_IntegrityCheck($l_FileName);

			} else
			{
				if ($l_NeedToScan)
				{
					$g_FoundTotalFiles++;
					$g_Counter++;
				}
			}
			
			if (!$l_NeedToScan) continue;

			if (IMAKE) {
				write_integrity_db_file($l_FileName);
				continue;
			}

			// ICHECK
			// skip if known and not modified.
			if (icheck($l_FileName)) continue;
			
			$l_Buffer .= getRelativePath($l_FileName);
			$l_Buffer .= $l_IsDir ? DIR_SEPARATOR . "\n" : "\n";

			if (strlen($l_Buffer) > 32000)
			{
				file_put_contents(QUEUE_FILENAME, $l_Buffer, FILE_APPEND) or die("Cannot write to file " . QUEUE_FILENAME);
				$l_Buffer = '';
			}

		}

		closedir($l_DIRH);
	}
	
	if (($l_RootDir == ROOT_PATH) && !empty($l_Buffer)) {
		file_put_contents(QUEUE_FILENAME, $l_Buffer, FILE_APPEND) or die("Cannot write to file ".QUEUE_FILENAME);
		$l_Buffer = '';
	}

	if (($l_RootDir == ROOT_PATH)) {
		write_integrity_db_file();
	}

}


function getRelativePath($l_FileName) {
	return "./" . substr($l_FileName, strlen(ROOT_PATH) + 1) . (is_dir($l_FileName) ? DIR_SEPARATOR : '');
}
/**
 *
 * @return true if known and not modified
 */
function icheck($l_FileName) {
	global $g_IntegrityDB, $g_ICheck;
	static $l_Buffer = '';
	static $l_status = array( 'modified' => 'modified', 'added' => 'added' );
    
	$l_RelativePath = getRelativePath($l_FileName);
	$l_known = isset($g_IntegrityDB[$l_RelativePath]);

	if (is_dir($l_FileName)) {
		if ( $l_known ) {
			unset($g_IntegrityDB[$l_RelativePath]);
		} else {
			$g_IntegrityDB[$l_RelativePath] =& $l_status['added'];
		}
		return $l_known;
	}

	if ($l_known == false) {
		$g_IntegrityDB[$l_RelativePath] =& $l_status['added'];
		return false;
	}

	$hash = is_file($l_FileName) ? hash_file('sha1', $l_FileName) : '';
	
	if ($g_IntegrityDB[$l_RelativePath] != $hash) {
		$g_IntegrityDB[$l_RelativePath] =& $l_status['modified'];
		return false;
	}

	unset($g_IntegrityDB[$l_RelativePath]);
	return true;
}

function write_integrity_db_file($l_FileName = '') {
	static $l_Buffer = '';

	if (empty($l_FileName)) {
		empty($l_Buffer) or file_put_contents('compress.zlib://' . INTEGRITY_DB_FILE, $l_Buffer, FILE_APPEND) or die("Cannot write to file " . INTEGRITY_DB_FILE);
		$l_Buffer = '';
		return;
	}

	$l_RelativePath = getRelativePath($l_FileName);
		
	$hash = is_file($l_FileName) ? hash_file('sha1', $l_FileName) : '';

	$l_Buffer .= "$l_RelativePath|$hash\n";
	
	if (strlen($l_Buffer) > 32000)
	{
		file_put_contents('compress.zlib://' . INTEGRITY_DB_FILE, $l_Buffer, FILE_APPEND) or die("Cannot write to file " . INTEGRITY_DB_FILE);
		$l_Buffer = '';
	}
}

function load_integrity_db() {
	global $g_IntegrityDB;
	file_exists(INTEGRITY_DB_FILE) or die('Not found ' . INTEGRITY_DB_FILE);

	$s_file = new SplFileObject('compress.zlib://'.INTEGRITY_DB_FILE);
	$s_file->setFlags(SplFileObject::READ_AHEAD | SplFileObject::SKIP_EMPTY | SplFileObject::DROP_NEW_LINE);

	foreach ($s_file as $line) {
		$i = strrpos($line, '|');
		if (!$i) continue;
		$g_IntegrityDB[substr($line, 0, $i)] = substr($line, $i+1);
	}

	$s_file = null;
}


function OptimizeSignatures()
{
	global $g_DBShe, $g_FlexDBShe, $gX_FlexDBShe, $gXX_FlexDBShe;
	global $g_JSVirSig, $gX_JSVirSig;
	global $g_AdwareSig;
	global $g_PhishingSig;
	global $g_ExceptFlex, $g_SusDBPrio, $g_SusDB;

	(AI_EXPERT == 2) && ($g_FlexDBShe = array_merge($g_FlexDBShe, $gX_FlexDBShe, $gXX_FlexDBShe));
	(AI_EXPERT == 1) && ($g_FlexDBShe = array_merge($g_FlexDBShe, $gX_FlexDBShe));
	$gX_FlexDBShe = $gXX_FlexDBShe = array();

	(AI_EXPERT == 2) && ($g_JSVirSig = array_merge($g_JSVirSig, $gX_JSVirSig));
	$gX_JSVirSig = array();

	$count = count($g_FlexDBShe);

	for ($i = 0; $i < $count; $i++) {
		if ($g_FlexDBShe[$i] == 'http://.+?/.+?\.php\?a=\d+&c=[a-zA-Z0-9_]+?&s=') $g_FlexDBShe[$i] = 'http://[^?\s]++(?<=\.php)\?a=\d+&c=[a-zA-Z0-9_]+?&s=';
		if ($g_FlexDBShe[$i] == '[a-zA-Z0-9_]+?\(\s*[a-zA-Z0-9_]+?=\s*\)') $g_FlexDBShe[$i] = '\((?<=[a-zA-Z0-9_].)\s*[a-zA-Z0-9_]++=\s*\)';
		if ($g_FlexDBShe[$i] == '([^\?\s])\({0,1}\.[\+\*]\){0,1}\2[a-z]*e') $g_FlexDBShe[$i] = '(?J)\.[+*](?<=(?<d>[^\?\s])\(..|(?<d>[^\?\s])..)\)?\g{d}[a-z]*e';
		if ($g_FlexDBShe[$i] == '$[a-zA-Z0-9_]\{\d+\}\s*\.$[a-zA-Z0-9_]\{\d+\}\s*\.$[a-zA-Z0-9_]\{\d+\}\s*\.') $g_FlexDBShe[$i] = '\$[a-zA-Z0-9_]\{\d+\}\s*\.\$[a-zA-Z0-9_]\{\d+\}\s*\.\$[a-zA-Z0-9_]\{\d+\}\s*\.';

		$g_FlexDBShe[$i] = preg_replace('~\[a-zA-Z0-9_\]\+\K\?~', '+', $g_FlexDBShe[$i]);
		$g_FlexDBShe[$i] = preg_replace('~^\\\\[d]\+&@~', '&@(?<=\d..)', $g_FlexDBShe[$i]);
		$g_FlexDBShe[$i] = str_replace('\s*[\'"]{0,1}.+?[\'"]{0,1}\s*', '.+?', $g_FlexDBShe[$i]);
		$g_FlexDBShe[$i] = str_replace('[\'"]{0,1}.+?[\'"]{0,1}', '.+?', $g_FlexDBShe[$i]);

		$g_FlexDBShe[$i] = preg_replace('~^\[\'"\]\{0,1\}\.?|^@\*|^\\\\s\*~', '', $g_FlexDBShe[$i]);
		$g_FlexDBShe[$i] = preg_replace('~^\[\'"\]\{0,1\}\.?|^@\*|^\\\\s\*~', '', $g_FlexDBShe[$i]);
	}

	optSig($g_FlexDBShe);
	optSig($g_JSVirSig);
	optSig($g_AdwareSig);
	optSig($g_PhishingSig);
        optSig($g_SusDB);
        optSig($g_SusDBPrio);
        //optSig($g_ExceptFlex);

        // convert exception rules
        $cnt = count($g_ExceptFlex);
        for ($i = 0; $i < $cnt; $i++) {                		
            $g_ExceptFlex[$i] = trim(UnwrapObfu($g_ExceptFlex[$i]));
            if (!strlen($g_ExceptFlex[$i])) unset($g_ExceptFlex[$i]);
        }

        $g_ExceptFlex = array_values($g_ExceptFlex);
}


function optSig(&$sigs)
{
	optSigCheck($sigs);
	
	usort($sigs, 'strcasecmp');
	$txt = implode("\n", $sigs);

	for ($i = 24; $i >= 1; ($i > 4 ) ? $i-=4 : --$i) {
		$txt = preg_replace_callback('#^((?>(?:\\\\.|\\[.+?\\]|[^(\n]|\((?:\\\\.|[^)(\n])++\))(?:[*?+]\+?|)){' . $i . ',}).*(?:\\n\\1(?![{?*+]).+)+#im', 'optMergePrefixes', $txt);
	}

	$sigs = explode("\n", $txt);
	
	optSigCheck($sigs);
}

function optMergePrefixes($m)
{
	$prefix = $m[1];
	$prefix_len = strlen($prefix);

	$suffixes = array();
	foreach (explode("\n", $m[0]) as $line) {
		$suffixes[] = substr($line, $prefix_len);
	}
	
	return $prefix . '(?:' . implode('|', $suffixes) . ')';
}

/*
 * Checking errors in pattern
 */
function optSigCheck(&$sigs)
{
	$result = true;

	foreach ($sigs as $k => $sig) {
		if (@preg_match('#(' . $sig . ')#smiS', '') === false) {
			$error = error_get_last();
			//echo($error['message'] . "\n     pattern: " . $sig . "\n");
			unset($sigs[$k]);
			$result = false;
		}
	}
	
	return $result;
}
