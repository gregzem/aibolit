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
ini_set('memory_limit', '1G');
//@mb_internal_encoding('');

$int_enc = @ini_get('mbstring.internal_encoding');
        
define('SHORT_PHP_TAG', strtolower(ini_get('short_open_tag')) == 'on' || strtolower(ini_get('short_open_tag')) == 1 ? true : false);

// put 1 for expert mode, 0 for basic check and 2 for paranoic mode
// установите 1 для режима "Эксперта", 0 для быстрой проверки и 2 для параноидальной проверки (для лечения сайта) 
define('AI_EXPERT_MODE', 2); 

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

define('SMART_SCAN', 0);

define('AI_EXTRA_WARN', 0);

$defaults = array(
	'path' => dirname(__FILE__),
	'scan_all_files' => 0, // full scan (rather than just a .js, .php, .html, .htaccess)
	'scan_delay' => 0, // delay in file scanning to reduce system load
	'max_size_to_scan' => '600K',
	'site_url' => '', // website url
	'no_rw_dir' => 0,
    	'skip_ext' => '',
	'report_mask' =>  REPORT_MASK_FULL // full-featured report
);


define('DEBUG_MODE', 0);

define('DIR_SEPARATOR', '/');

define('DOUBLECHECK_FILE', 'AI-BOLIT-DOUBLECHECK.php');

if ((isset($_SERVER['OS']) && stripos('Win', $_SERVER['OS']) !== false)/* && stripos('CygWin', $_SERVER['OS']) === false)*/) {
   define('DIR_SEPARATOR', '\\');
}

$g_SuspiciousFiles = array('cgi', 'pl', 'o', 'so', 'py', 'sh', 'phtml', 'php3', 'php4', 'php5', 'php6', 'php7', 'pht', 'shtml', 'susp', 'suspected');
$g_SensitiveFiles = array_merge(array('php', 'js', 'htaccess', 'html', 'htm', 'tpl', 'inc', 'css', 'txt', 'sql'), $g_SuspiciousFiles);
$g_CriticalFiles = array('php', 'htaccess', 'cgi', 'pl', 'o', 'so', 'py', 'sh', 'phtml', 'php3', 'php4', 'php5', 'php6', 'php7', 'pht', 'shtml', 'susp', 'suspected', 'infected', 'vir');
$g_CriticalEntries = '<\?php|<\?=|#!/usr|#!/bin|eval|assert|base64_decode|system|create_function|exec|popen|fwrite|fputs|file_get_|call_user_func|file_put_|\$_REQUEST|ob_start|\$_GET|\$_POST|\$_SERVER|\$_FILES|move|copy|array_|reg_replace|mysql_|chr|fsockopen|\$GLOBALS|sqliteCreateFunction';
$g_VirusFiles = array('js', 'html', 'htm', 'suspicious');
$g_VirusEntries = '<\s*script|<\s*iframe|<\s*object|<\s*embed|fromCharCode|setTimeout|setInterval|location\.|document\.|window\.|navigator\.|\$(this)\.';
$g_PhishFiles = array('js', 'html', 'htm', 'suspected', 'php');
$g_PhishEntries = '<\s*title|<\s*html|<\s*form|<\s*body|bank|account';
$g_ShortListExt = array('php', 'php3', 'php4', 'php5', 'php6', 'php7', 'pht', 'html', 'htm', 'phtml', 'shtml', 'khtml');

if (LANG == 'RU') {
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// RUSSIAN INTERFACE
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$msg1 = "\"Отображать по _MENU_ записей\"";
$msg2 = "\"Ничего не найдено\"";
$msg3 = "\"Отображается c _START_ по _END_ из _TOTAL_ файлов\"";
$msg4 = "\"Нет файлов\"";
$msg5 = "\"(всего записей _MAX_)\"";
$msg6 = "\"Поиск:\"";
$msg7 = "\"Первая\"";
$msg8 = "\"Предыдущая\"";
$msg9 = "\"Следующая\"";
$msg10 = "\"Последняя\"";
$msg11 = "\": активировать для сортировки столбца по возрастанию\"";
$msg12 = "\": активировать для сортировки столбцов по убыванию\"";

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
$msg1 = "\"Display _MENU_ records\"";
$msg2 = "\"Not found\"";
$msg3 = "\"Display from _START_ to _END_ of _TOTAL_ files\"";
$msg4 = "\"No files\"";
$msg5 = "\"(total _MAX_)\"";
$msg6 = "\"Filter/Search:\"";
$msg7 = "\"First\"";
$msg8 = "\"Previous\"";
$msg9 = "\"Next\"";
$msg10 = "\"Last\"";
$msg11 = "\": activate to sort row ascending order\"";
$msg12 = "\": activate to sort row descending order\"";

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
 <div class="crit" style="font-size: 17px;"><b>Danger! Malicious or suspicious files have been detected on the website.</b></div> 
 <br/>Most likely the website has been compromised. Please, <a href="https://revisium.com/en/home/" target=_blank>contact security experts</a> or experienced webmaster immediately to clean up the website from malware.
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
			"sLengthMenu": $msg1,
			"sZeroRecords": $msg2,
			"sInfo": $msg3,
			"sInfoEmpty": $msg4,
			"sInfoFiltered": $msg5,
			"sSearch":       $msg6,
			"sUrl":          "",
			"oPaginate": {
				"sFirst": $msg7,
				"sPrevious": $msg8,
				"sNext": $msg9,
				"sLast": $msg10
			},
			"oAria": {
				"sSortAscending": $msg11,
				"sSortDescending": $msg12	
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
			"sLengthMenu": $msg1,
			"sZeroRecords": $msg2,
			"sInfo": $msg3,
			"sInfoEmpty": $msg4,
			"sInfoFiltered": $msg5,
			"sSearch":       $msg6,
			"sUrl":          "",
			"oPaginate": {
				"sFirst": $msg7,
				"sPrevious": $msg8,
				"sNext": $msg9,
				"sLast": $msg10
			},
			"oAria": {
				"sSortAscending":  $msg11,
				"sSortDescending": $msg12	
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
			  		"oLanguage": {
			  			"sLengthMenu": $msg1,
			  			"sZeroRecords": $msg2,
			  			"sInfo": $msg3,
			  			"sInfoEmpty": $msg4,
			  			"sInfoFiltered": $msg5,
			  			"sSearch":       $msg6,
			  			"sUrl":          "",
			  			"oPaginate": {
			  				"sFirst": $msg7,
			  				"sPrevious": $msg8,
			  				"sNext": $msg9,
			  				"sLast": $msg10
			  			},
			  			"oAria": {
			  				"sSortAscending":  $msg11,
			  				"sSortDescending": $msg12	
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
			  			"sLengthMenu": $msg1,
			  			"sZeroRecords": $msg2,
			  			"sInfo": $msg3,
			  			"sInfoEmpty": $msg4,
			  			"sInfoFiltered": $msg5,
			  			"sSearch":       $msg6,
			  			"sUrl":          "",
			  			"oPaginate": {
			  				"sFirst": $msg7,
			  				"sPrevious": $msg8,
			  				"sNext": $msg9,
			  				"sLast": $msg10
			  			},
			  			"oAria": {
			  				"sSortAscending":  $msg11,
			  				"sSortDescending": $msg12	
			  			}
		}

     } );
}


</script>
<!-- @@SERVICE_INFO@@  -->
 </body>
</html>
MAIN_PAGE;

$g_AiBolitAbsolutePath = dirname(__FILE__);

if (file_exists($g_AiBolitAbsolutePath . '/ai-design.html')) {
  $l_Template = file_get_contents($g_AiBolitAbsolutePath . '/ai-design.html');
}

$l_Template = str_replace('@@MAIN_TITLE@@', AI_STR_001, $l_Template);

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//BEGIN_SIG 03/05/2016 11:46:11
$g_DBShe = unserialize(base64_decode("YTo0Mjc6e2k6MDtzOjU6InJhaHVpIjtpOjE7czoxNToidzRsM1h6WTMgTWFpbGVyIjtpOjI7czozNToibW92ZV91cGxvYWRlZF9maWxlKCRfRklMRVNbPHFxPkYxbDMiO2k6MztzOjEzOiJCeTxzMT5LeW1Mam5rIjtpOjQ7czoxMzoiQnk8czE+U2g0TGluayI7aTo1O3M6MTY6IkJ5PHMxPkFub25Db2RlcnMiO2k6NjtzOjQ2OiIkdXNlckFnZW50cyA9IGFycmF5KCJHb29nbGUiLCAiU2x1cnAiLCAiTVNOQm90IjtpOjc7czo2OiJbM3Jhbl0iO2k6ODtzOjEwOiJEYXduX2FuZ2VsIjtpOjk7czo4OiJSM0RUVVhFUyI7aToxMDtzOjIwOiJ2aXNpdG9yVHJhY2tlcl9pc01vYiI7aToxMTtzOjI0OiJjb21fY29udGVudC9hcnRpY2xlZC5waHAiO2k6MTI7czoxNzoiPHRpdGxlPkVtc1Byb3h5IHYiO2k6MTM7czoxMzoiYW5kcm9pZC1pZ3JhLSI7aToxNDtzOjE1OiI9PT06OjptYWQ6Ojo9PT0iO2k6MTU7czo1OiJINHhPciI7aToxNjtzOjg6IlI0cEg0eDByIjtpOjE3O3M6ODoiTkc2ODlTa3ciO2k6MTg7czoxMToiZm9wby5jb20uYXIiO2k6MTk7czo5OiI2NC42OC44MC4iO2k6MjA7czo4OiJIYXJjaGFMaSI7aToyMTtzOjE1OiJ4eFI5OW11c3ZpZWkweDAiO2k6MjI7czoxMToiUC5oLnAuUy5wLnkiO2k6MjM7czoxNDoiX3NoZWxsX2F0aWxkaV8iO2k6MjQ7czo5OiJ+IFNoZWxsIEkiO2k6MjU7czo2OiIweGRkODIiO2k6MjY7czoxNDoiQW50aWNoYXQgc2hlbGwiO2k6Mjc7czoxMjoiQUxFTWlOIEtSQUxpIjtpOjI4O3M6MTY6IkFTUFggU2hlbGwgYnkgTFQiO2k6Mjk7czo5OiJhWlJhaUxQaFAiO2k6MzA7czoyMjoiQ29kZWQgQnkgQ2hhcmxpY2hhcGxpbiI7aTozMTtzOjc6IkJsMG9kM3IiO2k6MzI7czoxMjoiQlkgaVNLT1JQaVRYIjtpOjMzO3M6MTE6ImRldmlselNoZWxsIjtpOjM0O3M6MzA6IldyaXR0ZW4gYnkgQ2FwdGFpbiBDcnVuY2ggVGVhbSI7aTozNTtzOjk6ImMyMDA3LnBocCI7aTozNjtzOjIyOiJDOTkgTW9kaWZpZWQgQnkgUHN5Y2gwIjtpOjM3O3M6MTc6IiRjOTlzaF91cGRhdGVmdXJsIjtpOjM4O3M6OToiQzk5IFNoZWxsIjtpOjM5O3M6MjI6ImNvb2tpZW5hbWUgPSAid2llZWVlZSIiO2k6NDA7czozODoiQ29kZWQgYnkgOiBTdXBlci1DcnlzdGFsIGFuZCBNb2hhamVyMjIiO2k6NDE7czoxMjoiQ3J5c3RhbFNoZWxsIjtpOjQyO3M6MjM6IlRFQU0gU0NSSVBUSU5HIC0gUk9ETk9DIjtpOjQzO3M6MTE6IkN5YmVyIFNoZWxsIjtpOjQ0O3M6NzoiZDBtYWlucyI7aTo0NTtzOjEzOiJEYXJrRGV2aWx6LmlOIjtpOjQ2O3M6MjQ6IlNoZWxsIHdyaXR0ZW4gYnkgQmwwb2QzciI7aTo0NztzOjMzOiJEaXZlIFNoZWxsIC0gRW1wZXJvciBIYWNraW5nIFRlYW0iO2k6NDg7czoxNToiRGV2ci1pIE1lZnNlZGV0IjtpOjQ5O3M6MzI6IkNvbWFuZG9zIEV4Y2x1c2l2b3MgZG8gRFRvb2wgUHJvIjtpOjUwO3M6MjA6IkVtcGVyb3IgSGFja2luZyBURUFNIjtpOjUxO3M6MjA6IkZpeGVkIGJ5IEFydCBPZiBIYWNrIjtpOjUyO3M6MjE6IkZhVGFMaXNUaUN6X0Z4IEZ4MjlTaCI7aTo1MztzOjI3OiJMdXRmZW4gRG9zeWF5aSBBZGxhbmRpcmluaXoiO2k6NTQ7czoyMjoidGhpcyBpcyBhIHByaXYzIHNlcnZlciI7aTo1NTtzOjEzOiJHRlMgV2ViLVNoZWxsIjtpOjU2O3M6MTE6IkdIQyBNYW5hZ2VyIjtpOjU3O3M6MTQ6Ikdvb2cxZV9hbmFsaXN0IjtpOjU4O3M6MTM6IkdyaW5heSBHbzBvJEUiO2k6NTk7czoyOToiaDRudHUgc2hlbGwgW3Bvd2VyZWQgYnkgdHNvaV0iO2k6NjA7czoyNToiSGFja2VkIEJ5IERldnItaSBNZWZzZWRldCI7aTo2MTtzOjE3OiJIQUNLRUQgQlkgUkVBTFdBUiI7aTo2MjtzOjMyOiJIYWNrZXJsZXIgVnVydXIgTGFtZXJsZXIgU3VydW51ciI7aTo2MztzOjExOiJpTUhhQmlSTGlHaSI7aTo2NDtzOjk6IktBX3VTaGVsbCI7aTo2NTtzOjc6IkxpejB6aU0iO2k6NjY7czoxMToiTG9jdXM3U2hlbGwiO2k6Njc7czozNjoiTW9yb2NjYW4gU3BhbWVycyBNYS1FZGl0aW9OIEJ5IEdoT3NUIjtpOjY4O3M6MTA6Ik1hdGFtdSBNYXQiO2k6Njk7czo1MDoiT3BlbiB0aGUgZmlsZSBhdHRhY2htZW50IGlmIGFueSwgYW5kIGJhc2U2NF9lbmNvZGUiO2k6NzA7czo2OiJtMHJ0aXgiO2k6NzE7czo1OiJtMGh6ZSI7aTo3MjtzOjEwOiJNYXRhbXUgTWF0IjtpOjczO3M6MTY6Ik1vcm9jY2FuIFNwYW1lcnMiO2k6NzQ7czoxNToiJE15U2hlbGxWZXJzaW9uIjtpOjc1O3M6OToiTXlTUUwgUlNUIjtpOjc2O3M6MTk6Ik15U1FMIFdlYiBJbnRlcmZhY2UiO2k6Nzc7czoyNzoiTXlTUUwgV2ViIEludGVyZmFjZSBWZXJzaW9uIjtpOjc4O3M6MTQ6Ik15U1FMIFdlYnNoZWxsIjtpOjc5O3M6ODoiTjN0c2hlbGwiO2k6ODA7czoxNjoiSGFja2VkIGJ5IFNpbHZlciI7aTo4MTtzOjc6Ik5lb0hhY2siO2k6ODI7czoyMToiTmV0d29ya0ZpbGVNYW5hZ2VyUEhQIjtpOjgzO3M6MjA6Ik5JWCBSRU1PVEUgV0VCLVNIRUxMIjtpOjg0O3M6MjY6Ik8gQmlSIEtSQUwgVEFLTGlUIEVEaWxFTUVaIjtpOjg1O3M6MTg6IlBIQU5UQVNNQS0gTmVXIENtRCI7aTo4NjtzOjIxOiJQSVJBVEVTIENSRVcgV0FTIEhFUkUiO2k6ODc7czoyMToiYSBzaW1wbGUgcGhwIGJhY2tkb29yIjtpOjg4O3M6MjA6IkxPVEZSRUUgUEhQIEJhY2tkb29yIjtpOjg5O3M6MzE6Ik5ld3MgUmVtb3RlIFBIUCBTaGVsbCBJbmplY3Rpb24iO2k6OTA7czo5OiJQSFBKYWNrYWwiO2k6OTE7czoyMDoiUEhQIEhWQSBTaGVsbCBTY3JpcHQiO2k6OTI7czoxMzoicGhwUmVtb3RlVmlldyI7aTo5MztzOjM1OiJQSFAgU2hlbGwgaXMgYW5pbnRlcmFjdGl2ZSBQSFAtcGFnZSI7aTo5NDtzOjY6IlBIVmF5diI7aTo5NTtzOjI2OiJQUFMgMS4wIHBlcmwtY2dpIHdlYiBzaGVsbCI7aTo5NjtzOjIyOiJQcmVzcyBPSyB0byBlbnRlciBzaXRlIjtpOjk3O3M6MjI6InByaXZhdGUgU2hlbGwgYnkgbTRyY28iO2k6OTg7czo1OiJyMG5pbiI7aTo5OTtzOjY6IlI1N1NxbCI7aToxMDA7czoxMzoicjU3c2hlbGxcLnBocCI7aToxMDE7czoxNToicmdvZGBzIHdlYnNoZWxsIjtpOjEwMjtzOjIwOiJyZWFsYXV0aD1TdkJEODVkSU51MyI7aToxMDM7czoxNjoiUnUyNFBvc3RXZWJTaGVsbCI7aToxMDQ7czoyMToiS0Fkb3QgVW5pdmVyc2FsIFNoZWxsIjtpOjEwNTtzOjEwOiJDckB6eV9LaW5nIjtpOjEwNjtzOjIwOiJTYWZlX01vZGUgQnlwYXNzIFBIUCI7aToxMDc7czoxNzoiU2FyYXNhT24gU2VydmljZXMiO2k6MTA4O3M6MjU6IlNpbXBsZSBQSFAgYmFja2Rvb3IgYnkgREsiO2k6MTA5O3M6MTk6IkctU2VjdXJpdHkgV2Vic2hlbGwiO2k6MTEwO3M6MjU6IlNpbW9yZ2ggU2VjdXJpdHkgTWFnYXppbmUiO2k6MTExO3M6MjA6IlNoZWxsIGJ5IE1hd2FyX0hpdGFtIjtpOjExMjtzOjEzOiJTU0kgd2ViLXNoZWxsIjtpOjExMztzOjExOiJTdG9ybTdTaGVsbCI7aToxMTQ7czo5OiJUaGVfQmVLaVIiO2k6MTE1O3M6OToiVzNEIFNoZWxsIjtpOjExNjtzOjEzOiJ3NGNrMW5nIHNoZWxsIjtpOjExNztzOjI4OiJkZXZlbG9wZWQgYnkgRGlnaXRhbCBPdXRjYXN0IjtpOjExODtzOjMyOiJXYXRjaCBZb3VyIHN5c3RlbSBTaGFueSB3YXMgaGVyZSI7aToxMTk7czoxMjoiV2ViIFNoZWxsIGJ5IjtpOjEyMDtzOjEzOiJXU08yIFdlYnNoZWxsIjtpOjEyMTtzOjMzOiJOZXR3b3JrRmlsZU1hbmFnZXJQSFAgZm9yIGNoYW5uZWwiO2k6MTIyO3M6Mjc6IlNtYWxsIFBIUCBXZWIgU2hlbGwgYnkgWmFDbyI7aToxMjM7czoxMDoiTXJsb29sLmV4ZSI7aToxMjQ7czo2OiJTRW9ET1IiO2k6MTI1O3M6OToiTXIuSGlUbWFuIjtpOjEyNjtzOjU6ImQzYn5YIjtpOjEyNztzOjE2OiJDb25uZWN0QmFja1NoZWxsIjtpOjEyODtzOjEwOiJCWSBNTU5CT0JaIjtpOjEyOTtzOjI2OiJPTEI6UFJPRFVDVDpPTkxJTkVfQkFOS0lORyI7aToxMzA7czoxMDoiQzBkZXJ6LmNvbSI7aToxMzE7czo3OiJNckhhemVtIjtpOjEzMjtzOjk6InYwbGQzbTBydCI7aToxMzM7czo2OiJLIUxMM3IiO2k6MTM0O3M6MTA6IkRyLmFib2xhbGgiO2k6MTM1O3M6MzA6IiRyYW5kX3dyaXRhYmxlX2ZvbGRlcl9mdWxscGF0aCI7aToxMzY7czo4NDoiPHRleHRhcmVhIG5hbWU9XCJwaHBldlwiIHJvd3M9XCI1XCIgY29scz1cIjE1MFwiPiIuQCRfUE9TVFsncGhwZXYnXS4iPC90ZXh0YXJlYT48YnI+IjtpOjEzNztzOjE2OiJjOTlmdHBicnV0ZWNoZWNrIjtpOjEzODtzOjk6IkJ5IFBzeWNoMCI7aToxMzk7czoxNzoiJGM5OXNoX3VwZGF0ZWZ1cmwiO2k6MTQwO3M6MTQ6InRlbXBfcjU3X3RhYmxlIjtpOjE0MTtzOjE3OiJhZG1pbkBzcHlncnVwLm9yZyI7aToxNDI7czo3OiJjYXN1czE1IjtpOjE0MztzOjEzOiJXU0NSSVBULlNIRUxMIjtpOjE0NDtzOjQ3OiJFeGVjdXRlZCBjb21tYW5kOiA8Yj48Zm9udCBjb2xvcj0jZGNkY2RjPlskY21kXSI7aToxNDU7czoxMToiY3RzaGVsbC5waHAiO2k6MTQ2O3M6MTU6IkRYX0hlYWRlcl9kcmF3biI7aToxNDc7czo4NjoiY3JsZi4ndW5saW5rKCRuYW1lKTsnLiRjcmxmLidyZW5hbWUoIn4iLiRuYW1lLCAkbmFtZSk7Jy4kY3JsZi4ndW5saW5rKCJncnBfcmVwYWlyLnBocCIiO2k6MTQ4O3M6MTA1OiIvMHRWU0cvU3V2MFVyL2hhVVlBZG4zak1Rd2Jib2NHZmZBZUMyOUJOOXRtQmlKZFYxbGsrallEVTkyQzk0amR0RGlmK3hPWWpHNkNMaHgzMVVvOXg5L2VBV2dzQks2MGtLMm1Md3F6cWQiO2k6MTQ5O3M6MTE1OiJtcHR5KCRfUE9TVFsndXInXSkpICRtb2RlIHw9IDA0MDA7IGlmICghZW1wdHkoJF9QT1NUWyd1dyddKSkgJG1vZGUgfD0gMDIwMDsgaWYgKCFlbXB0eSgkX1BPU1RbJ3V4J10pKSAkbW9kZSB8PSAwMTAwIjtpOjE1MDtzOjM3OiJrbGFzdmF5di5hc3A/eWVuaWRvc3lhPTwlPWFrdGlma2xhcyU+IjtpOjE1MTtzOjEyMjoibnQpKGRpc2tfdG90YWxfc3BhY2UoZ2V0Y3dkKCkpLygxMDI0KjEwMjQpKSAuICJNYiAiIC4gIkZyZWUgc3BhY2UgIiAuIChpbnQpKGRpc2tfZnJlZV9zcGFjZShnZXRjd2QoKSkvKDEwMjQqMTAyNCkpIC4gIk1iIDwiO2k6MTUyO3M6NzY6ImEgaHJlZj0iPD9lY2hvICIkZmlzdGlrLnBocD9kaXppbj0kZGl6aW4vLi4vIj8+IiBzdHlsZT0idGV4dC1kZWNvcmF0aW9uOiBub24iO2k6MTUzO3M6Mzg6IlJvb3RTaGVsbCEnKTtzZWxmLmxvY2F0aW9uLmhyZWY9J2h0dHA6IjtpOjE1NDtzOjkwOiI8JT1SZXF1ZXN0LlNlcnZlclZhcmlhYmxlcygic2NyaXB0X25hbWUiKSU+P0ZvbGRlclBhdGg9PCU9U2VydmVyLlVSTFBhdGhFbmNvZGUoRm9sZGVyLkRyaXYiO2k6MTU1O3M6MTYwOiJwcmludCgoaXNfcmVhZGFibGUoJGYpICYmIGlzX3dyaXRlYWJsZSgkZikpPyI8dHI+PHRkPiIudygxKS5iKCJSIi53KDEpLmZvbnQoJ3JlZCcsJ1JXJywzKSkudygxKTooKChpc19yZWFkYWJsZSgkZikpPyI8dHI+PHRkPiIudygxKS5iKCJSIikudyg0KToiIikuKChpc193cml0YWJsIjtpOjE1NjtzOjE2MToiKCciJywnJnF1b3Q7JywkZm4pKS4nIjtkb2N1bWVudC5saXN0LnN1Ym1pdCgpO1wnPicuaHRtbHNwZWNpYWxjaGFycyhzdHJsZW4oJGZuKT5mb3JtYXQ/c3Vic3RyKCRmbiwwLGZvcm1hdC0zKS4nLi4uJzokZm4pLic8L2E+Jy5zdHJfcmVwZWF0KCcgJyxmb3JtYXQtc3RybGVuKCRmbikiO2k6MTU3O3M6MTE6InplaGlyaGFja2VyIjtpOjE1ODtzOjM5OiJKQCFWckAqJlJIUnd+Skx3Lkd8eGxobkxKfj8xLmJ3T2J4YlB8IVYiO2k6MTU5O3M6Mzk6IldTT3NldGNvb2tpZShtZDUoJF9TRVJWRVJbJ0hUVFBfSE9TVCddKSI7aToxNjA7czoxNDE6IjwvdGQ+PHRkIGlkPWZhPlsgPGEgdGl0bGU9XCJIb21lOiAnIi5odG1sc3BlY2lhbGNoYXJzKHN0cl9yZXBsYWNlKCJcIiwgJHNlcCwgZ2V0Y3dkKCkpKS4iJy5cIiBpZD1mYSBocmVmPVwiamF2YXNjcmlwdDpWaWV3RGlyKCciLnJhd3VybGVuY29kZSI7aToxNjE7czoxNjoiQ29udGVudC1UeXBlOiAkXyI7aToxNjI7czo4NjoiPG5vYnI+PGI+JGNkaXIkY2ZpbGU8L2I+ICgiLiRmaWxlWyJzaXplX3N0ciJdLiIpPC9ub2JyPjwvdGQ+PC90cj48Zm9ybSBuYW1lPWN1cnJfZmlsZT4iO2k6MTYzO3M6NDg6Indzb0V4KCd0YXIgY2Z6diAnIC4gZXNjYXBlc2hlbGxhcmcoJF9QT1NUWydwMiddKSI7aToxNjQ7czoxNDI6IjVqYjIwaUtXOXlJSE4wY21semRISW9KSEpsWm1WeVpYSXNJbUZ3YjNKMElpa2diM0lnYzNSeWFYTjBjaWdrY21WbVpYSmxjaXdpYm1sbmJXRWlLU0J2Y2lCemRISnBjM1J5S0NSeVpXWmxjbVZ5TENKM1pXSmhiSFJoSWlrZ2IzSWdjM1J5YVhOMGNpZ2siO2k6MTY1O3M6NzY6IkxTMGdSSFZ0Y0ROa0lHSjVJRkJwY25Wc2FXNHVVRWhRSUZkbFluTm9NMnhzSUhZeExqQWdZekJrWldRZ1lua2djakJrY2pFZ09rdz0iO2k6MTY2O3M6NjU6ImlmIChlcmVnKCdeW1s6Ymxhbms6XV0qY2RbWzpibGFuazpdXSsoW147XSspJCcsICRjb21tYW5kLCAkcmVncykpIjtpOjE2NztzOjQ2OiJyb3VuZCgwKzk4MzAuNCs5ODMwLjQrOTgzMC40Kzk4MzAuNCs5ODMwLjQpKT09IjtpOjE2ODtzOjEyOiJQSFBTSEVMTC5QSFAiO2k6MTY5O3M6MjA6IlNoZWxsIGJ5IE1hd2FyX0hpdGFtIjtpOjE3MDtzOjIyOiJwcml2YXRlIFNoZWxsIGJ5IG00cmNvIjtpOjE3MTtzOjEzOiJ3NGNrMW5nIHNoZWxsIjtpOjE3MjtzOjIxOiJGYVRhTGlzVGlDel9GeCBGeDI5U2giO2k6MTczO3M6NDI6Ildvcmtlcl9HZXRSZXBseUNvZGUoJG9wRGF0YVsncmVjdkJ1ZmZlciddKSI7aToxNzQ7czo0MDoiJGZpbGVwYXRoPUByZWFscGF0aCgkX1BPU1RbJ2ZpbGVwYXRoJ10pOyI7aToxNzU7czo4ODoiJHJlZGlyZWN0VVJMPSdodHRwOi8vJy4kclNpdGUuJF9TRVJWRVJbJ1JFUVVFU1RfVVJJJ107aWYoaXNzZXQoJF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddKSI7aToxNzY7czoxNzoicmVuYW1lKCJ3c28ucGhwIiwiO2k6MTc3O3M6NTQ6IiRNZXNzYWdlU3ViamVjdCA9IGJhc2U2NF9kZWNvZGUoJF9QT1NUWyJtc2dzdWJqZWN0Il0pOyI7aToxNzg7czo0NDoiY29weSgkX0ZJTEVTW3hdW3RtcF9uYW1lXSwkX0ZJTEVTW3hdW25hbWVdKSkiO2k6MTc5O3M6NTg6IlNFTEVDVCAxIEZST00gbXlzcWwudXNlciBXSEVSRSBjb25jYXQoYHVzZXJgLCAnQCcsIGBob3N0YCkiO2k6MTgwO3M6MjE6IiFAJF9DT09LSUVbJHNlc3NkdF9rXSI7aToxODE7czo0ODoiJGE9KHN1YnN0cih1cmxlbmNvZGUocHJpbnRfcihhcnJheSgpLDEpKSw1LDEpLmMpIjtpOjE4MjtzOjU2OiJ4aCAtcyAiL3Vzci9sb2NhbC9hcGFjaGUvc2Jpbi9odHRwZCAtRFNTTCIgLi9odHRwZCAtbSAkMSI7aToxODM7czoxODoicHdkID4gR2VuZXJhc2kuZGlyIjtpOjE4NDtzOjEyOiJCUlVURUZPUkNJTkciO2k6MTg1O3M6MzE6IkNhdXRhbSBmaXNpZXJlbGUgZGUgY29uZmlndXJhcmUiO2k6MTg2O3M6MzI6IiRrYT0nPD8vL0JSRSc7JGtha2E9JGthLidBQ0svLz8+IjtpOjE4NztzOjg1OiIkc3Viaj11cmxkZWNvZGUoJF9HRVRbJ3N1J10pOyRib2R5PXVybGRlY29kZSgkX0dFVFsnYm8nXSk7JHNkcz11cmxkZWNvZGUoJF9HRVRbJ3NkJ10pIjtpOjE4ODtzOjM5OiIkX19fXz1AZ3ppbmZsYXRlKCRfX19fKSl7aWYoaXNzZXQoJF9QT1MiO2k6MTg5O3M6Mzc6InBhc3N0aHJ1KGdldGVudigiSFRUUF9BQ0NFUFRfTEFOR1VBR0UiO2k6MTkwO3M6ODoiQXNtb2RldXMiO2k6MTkxO3M6NTA6ImZvcig7JHBhZGRyPWFjY2VwdChDTElFTlQsIFNFUlZFUik7Y2xvc2UgQ0xJRU5UKSB7IjtpOjE5MjtzOjU5OiIkaXppbmxlcjI9c3Vic3RyKGJhc2VfY29udmVydChAZmlsZXBlcm1zKCRmbmFtZSksMTAsOCksLTQpOyI7aToxOTM7czo0MjoiJGJhY2tkb29yLT5jY29weSgkY2ZpY2hpZXIsJGNkZXN0aW5hdGlvbik7IjtpOjE5NDtzOjIzOiJ7JHtwYXNzdGhydSgkY21kKX19PGJyPiI7aToxOTU7czoyOToiJGFbaGl0c10nKTsgXHJcbiNlbmRxdWVyeVxyXG4iO2k6MTk2O3M6MjY6Im5jZnRwcHV0IC11ICRmdHBfdXNlcl9uYW1lIjtpOjE5NztzOjM2OiJleGVjbCgiL2Jpbi9zaCIsInNoIiwiLWkiLChjaGFyKikwKTsiO2k6MTk4O3M6MzE6IjxIVE1MPjxIRUFEPjxUSVRMRT5jZ2ktc2hlbGwucHkiO2k6MTk5O3M6Mzg6InN5c3RlbSgidW5zZXQgSElTVEZJTEU7IHVuc2V0IFNBVkVISVNUIjtpOjIwMDtzOjIzOiIkbG9naW49QHBvc2l4X2dldHVpZCgpOyI7aToyMDE7czo2MDoiKGVyZWcoJ15bWzpibGFuazpdXSpjZFtbOmJsYW5rOl1dKiQnLCAkX1JFUVVFU1RbJ2NvbW1hbmQnXSkpIjtpOjIwMjtzOjI1OiIhJF9SRVFVRVNUWyJjOTlzaF9zdXJsIl0pIjtpOjIwMztzOjUzOiJQblZsa1dNNjMhQCNAJmRLeH5uTURXTX5Efy9Fc25+eH82REAjQCZQfn4sP25ZLFdQe1BvaiI7aToyMDQ7czozNjoic2hlbGxfZXhlYygkX1BPU1RbJ2NtZCddIC4gIiAyPiYxIik7IjtpOjIwNTtzOjM1OiJpZighJHdob2FtaSkkd2hvYW1pPWV4ZWMoIndob2FtaSIpOyI7aToyMDY7czo2MToiUHlTeXN0ZW1TdGF0ZS5pbml0aWFsaXplKFN5c3RlbS5nZXRQcm9wZXJ0aWVzKCksIG51bGwsIGFyZ3YpOyI7aToyMDc7czozNjoiPCU9ZW52LnF1ZXJ5SGFzaHRhYmxlKCJ1c2VyLm5hbWUiKSU+IjtpOjIwODtzOjgzOiJpZiAoZW1wdHkoJF9QT1NUWyd3c2VyJ10pKSB7JHdzZXIgPSAid2hvaXMucmlwZS5uZXQiO30gZWxzZSAkd3NlciA9ICRfUE9TVFsnd3NlciddOyI7aToyMDk7czo5MToiaWYgKG1vdmVfdXBsb2FkZWRfZmlsZSgkX0ZJTEVTWydmaWxhJ11bJ3RtcF9uYW1lJ10sICRjdXJkaXIuIi8iLiRfRklMRVNbJ2ZpbGEnXVsnbmFtZSddKSkgeyI7aToyMTA7czoyMzoic2hlbGxfZXhlYygndW5hbWUgLWEnKTsiO2k6MjExO3M6NDc6ImlmICghZGVmaW5lZCRwYXJhbXtjbWR9KXskcGFyYW17Y21kfT0ibHMgLWxhIn07IjtpOjIxMjtzOjYwOiJpZihnZXRfbWFnaWNfcXVvdGVzX2dwYygpKSRzaGVsbE91dD1zdHJpcHNsYXNoZXMoJHNoZWxsT3V0KTsiO2k6MjEzO3M6ODQ6IjxhIGhyZWY9JyRQSFBfU0VMRj9hY3Rpb249dmlld1NjaGVtYSZkYm5hbWU9JGRibmFtZSZ0YWJsZW5hbWU9JHRhYmxlbmFtZSc+U2NoZW1hPC9hPiI7aToyMTQ7czo2NjoicGFzc3RocnUoICRiaW5kaXIuIm15c3FsZHVtcCAtLXVzZXI9JFVTRVJOQU1FIC0tcGFzc3dvcmQ9JFBBU1NXT1JEIjtpOjIxNTtzOjY2OiJteXNxbF9xdWVyeSgiQ1JFQVRFIFRBQkxFIGB4cGxvaXRgIChgeHBsb2l0YCBMT05HQkxPQiBOT1QgTlVMTCkiKTsiO2k6MjE2O3M6ODc6IiRyYTQ0ICA9IHJhbmQoMSw5OTk5OSk7JHNqOTggPSAic2gtJHJhNDQiOyRtbCA9ICIkc2Q5OCI7JGE1ID0gJF9TRVJWRVJbJ0hUVFBfUkVGRVJFUiddOyI7aToyMTc7czo1MjoiJF9GSUxFU1sncHJvYmUnXVsnc2l6ZSddLCAkX0ZJTEVTWydwcm9iZSddWyd0eXBlJ10pOyI7aToyMTg7czo3MToic3lzdGVtKCIkY21kIDE+IC90bXAvY21kdGVtcCAyPiYxOyBjYXQgL3RtcC9jbWR0ZW1wOyBybSAvdG1wL2NtZHRlbXAiKTsiO2k6MjE5O3M6Njk6In0gZWxzaWYgKCRzZXJ2YXJnID1+IC9eXDooLis/KVwhKC4rPylcQCguKz8pIFBSSVZNU0cgKC4rPykgXDooLispLykgeyI7aToyMjA7czo2OToic2VuZChTT0NLNSwgJG1zZywgMCwgc29ja2FkZHJfaW4oJHBvcnRhLCAkaWFkZHIpKSBhbmQgJHBhY290ZXN7b30rKzs7IjtpOjIyMTtzOjE4OiIkZmUoIiRjbWQgIDI+JjEiKTsiO2k6MjIyO3M6Njg6IndoaWxlICgkcm93ID0gbXlzcWxfZmV0Y2hfYXJyYXkoJHJlc3VsdCxNWVNRTF9BU1NPQykpIHByaW50X3IoJHJvdyk7IjtpOjIyMztzOjUyOiJlbHNlaWYoQGlzX3dyaXRhYmxlKCRGTikgJiYgQGlzX2ZpbGUoJEZOKSkgJHRtcE91dE1GIjtpOjIyNDtzOjcyOiJjb25uZWN0KFNPQ0tFVCwgc29ja2FkZHJfaW4oJEFSR1ZbMV0sIGluZXRfYXRvbigkQVJHVlswXSkpKSBvciBkaWUgcHJpbnQiO2k6MjI1O3M6ODk6ImlmKG1vdmVfdXBsb2FkZWRfZmlsZSgkX0ZJTEVTWyJmaWMiXVsidG1wX25hbWUiXSxnb29kX2xpbmsoIi4vIi4kX0ZJTEVTWyJmaWMiXVsibmFtZSJdKSkpIjtpOjIyNjtzOjg3OiJVTklPTiBTRUxFQ1QgJzAnICwgJzw/IHN5c3RlbShcJF9HRVRbY3BjXSk7ZXhpdDsgPz4nICwwICwwICwwICwwIElOVE8gT1VURklMRSAnJG91dGZpbGUiO2k6MjI3O3M6Njg6ImlmICghQGlzX2xpbmsoJGZpbGUpICYmICgkciA9IHJlYWxwYXRoKCRmaWxlKSkgIT0gRkFMU0UpICRmaWxlID0gJHI7IjtpOjIyODtzOjI5OiJlY2hvICJGSUxFIFVQTE9BREVEIFRPICRkZXoiOyI7aToyMjk7czoyNDoiJGZ1bmN0aW9uKCRfUE9TVFsnY21kJ10pIjtpOjIzMDtzOjM4OiIkZmlsZW5hbWUgPSAkYmFja3Vwc3RyaW5nLiIkZmlsZW5hbWUiOyI7aToyMzE7czo0ODoiaWYoJyc9PSgkZGY9QGluaV9nZXQoJ2Rpc2FibGVfZnVuY3Rpb25zJykpKXtlY2hvIjtpOjIzMjtzOjQ2OiI8JSBGb3IgRWFjaCBWYXJzIEluIFJlcXVlc3QuU2VydmVyVmFyaWFibGVzICU+IjtpOjIzMztzOjMzOiJpZiAoJGZ1bmNhcmcgPX4gL15wb3J0c2NhbiAoLiopLykiO2k6MjM0O3M6NTU6IiR1cGxvYWRmaWxlID0gJHJwYXRoLiIvIiAuICRfRklMRVNbJ3VzZXJmaWxlJ11bJ25hbWUnXTsiO2k6MjM1O3M6MjY6IiRjbWQgPSAoJF9SRVFVRVNUWydjbWQnXSk7IjtpOjIzNjtzOjM4OiJpZigkY21kICE9ICIiKSBwcmludCBTaGVsbF9FeGVjKCRjbWQpOyI7aToyMzc7czoyOToiaWYgKGlzX2ZpbGUoIi90bXAvJGVraW5jaSIpKXsiO2k6MjM4O3M6Njk6Il9fYWxsX18gPSBbIlNNVFBTZXJ2ZXIiLCJEZWJ1Z2dpbmdTZXJ2ZXIiLCJQdXJlUHJveHkiLCJNYWlsbWFuUHJveHkiXSI7aToyMzk7czo1OToiZ2xvYmFsICRteXNxbEhhbmRsZSwgJGRibmFtZSwgJHRhYmxlbmFtZSwgJG9sZF9uYW1lLCAkbmFtZSwiO2k6MjQwO3M6Mjc6IjI+JjEgMT4mMiIgOiAiIDE+JjEgMj4mMSIpOyI7aToyNDE7czo1MjoibWFwIHsgcmVhZF9zaGVsbCgkXykgfSAoJHNlbF9zaGVsbC0+Y2FuX3JlYWQoMC4wMSkpOyI7aToyNDI7czoyMjoiZndyaXRlICgkZnAsICIkeWF6aSIpOyI7aToyNDM7czo1MToiU2VuZCB0aGlzIGZpbGU6IDxJTlBVVCBOQU1FPSJ1c2VyZmlsZSIgVFlQRT0iZmlsZSI+IjtpOjI0NDtzOjQyOiIkZGJfZCA9IEBteXNxbF9zZWxlY3RfZGIoJGRhdGFiYXNlLCRjb24xKTsiO2k6MjQ1O3M6Njc6ImZvciAoJHZhbHVlKSB7IHMvJi8mYW1wOy9nOyBzLzwvJmx0Oy9nOyBzLz4vJmd0Oy9nOyBzLyIvJnF1b3Q7L2c7IH0iO2k6MjQ2O3M6NzQ6ImNvcHkoJF9GSUxFU1sndXBrayddWyd0bXBfbmFtZSddLCJray8iLmJhc2VuYW1lKCRfRklMRVNbJ3Vwa2snXVsnbmFtZSddKSk7IjtpOjI0NztzOjg2OiJmdW5jdGlvbiBnb29nbGVfYm90KCkgeyRzVXNlckFnZW50ID0gc3RydG9sb3dlcigkX1NFUlZFUlsnSFRUUF9VU0VSX0FHRU5UJ10pO2lmKCEoc3RycCI7aToyNDg7czo3NToiY3JlYXRlX2Z1bmN0aW9uKCImJCIuImZ1bmN0aW9uIiwiJCIuImZ1bmN0aW9uID0gY2hyKG9yZCgkIi4iZnVuY3Rpb24pLTMpOyIpIjtpOjI0OTtzOjQ2OiJsb25nIGludDp0KDAsMyk9cigwLDMpOy0yMTQ3NDgzNjQ4OzIxNDc0ODM2NDc7IjtpOjI1MDtzOjQ2OiI/dXJsPScuJF9TRVJWRVJbJ0hUVFBfSE9TVCddKS51bmxpbmsoUk9PVF9ESVIuIjtpOjI1MTtzOjM2OiJjYXQgJHtibGtsb2dbMl19IHwgZ3JlcCAicm9vdDp4OjA6MCIiO2k6MjUyO3M6OTc6IkBwYXRoMT0oJ2FkbWluLycsJ2FkbWluaXN0cmF0b3IvJywnbW9kZXJhdG9yLycsJ3dlYmFkbWluLycsJ2FkbWluYXJlYS8nLCdiYi1hZG1pbi8nLCdhZG1pbkxvZ2luLyciO2k6MjUzO3M6ODc6IiJhZG1pbjEucGhwIiwgImFkbWluMS5odG1sIiwgImFkbWluMi5waHAiLCAiYWRtaW4yLmh0bWwiLCAieW9uZXRpbS5waHAiLCAieW9uZXRpbS5odG1sIiI7aToyNTQ7czo2ODoiUE9TVCB7JHBhdGh9eyRjb25uZWN0b3J9P0NvbW1hbmQ9RmlsZVVwbG9hZCZUeXBlPUZpbGUmQ3VycmVudEZvbGRlcj0iO2k6MjU1O3M6MzA6IkBhc3NlcnQoJF9SRVFVRVNUWydQSFBTRVNTSUQnXSI7aToyNTY7czo2MToiJHByb2Q9InN5Ii4icyIuInRlbSI7JGlkPSRwcm9kKCRfUkVRVUVTVFsncHJvZHVjdCddKTskeydpZCd9OyI7aToyNTc7czoxNToicGhwICIuJHdzb19wYXRoIjtpOjI1ODtzOjc3OiIkRmNobW9kLCRGZGF0YSwkT3B0aW9ucywkQWN0aW9uLCRoZGRhbGwsJGhkZGZyZWUsJGhkZHByb2MsJHVuYW1lLCRpZGQpOnNoYXJlZCI7aToyNTk7czo1MToic2VydmVyLjwvcD5cclxuPC9ib2R5PjwvaHRtbD4iO2V4aXQ7fWlmKHByZWdfbWF0Y2goIjtpOjI2MDtzOjk1OiIkZmlsZSA9ICRfRklMRVNbImZpbGVuYW1lIl1bIm5hbWUiXTsgZWNobyAiPGEgaHJlZj1cIiRmaWxlXCI+JGZpbGU8L2E+Ijt9IGVsc2Uge2VjaG8oImVtcHR5Iik7fSI7aToyNjE7czo2MDoiRlNfY2hrX2Z1bmNfbGliYz0oICQocmVhZGVsZiAtcyAkRlNfbGliYyB8IGdyZXAgX2Noa0BAIHwgYXdrIjtpOjI2MjtzOjQwOiJmaW5kIC8gLW5hbWUgLnNzaCA+ICRkaXIvc3Noa2V5cy9zc2hrZXlzIjtpOjI2MztzOjMzOiJyZS5maW5kYWxsKGRpcnQrJyguKiknLHByb2dubSlbMF0iO2k6MjY0O3M6NjA6Im91dHN0ciArPSBzdHJpbmcuRm9ybWF0KCI8YSBocmVmPSc/ZmRpcj17MH0nPnsxfS88L2E+Jm5ic3A7IiI7aToyNjU7czo4MzoiPCU9UmVxdWVzdC5TZXJ2ZXJ2YXJpYWJsZXMoIlNDUklQVF9OQU1FIiklPj90eHRwYXRoPTwlPVJlcXVlc3QuUXVlcnlTdHJpbmcoInR4dHBhdGgiO2k6MjY2O3M6NzE6IlJlc3BvbnNlLldyaXRlKFNlcnZlci5IdG1sRW5jb2RlKHRoaXMuRXhlY3V0ZUNvbW1hbmQodHh0Q29tbWFuZC5UZXh0KSkpIjtpOjI2NztzOjExMToibmV3IEZpbGVTdHJlYW0oUGF0aC5Db21iaW5lKGZpbGVJbmZvLkRpcmVjdG9yeU5hbWUsIFBhdGguR2V0RmlsZU5hbWUoaHR0cFBvc3RlZEZpbGUuRmlsZU5hbWUpKSwgRmlsZU1vZGUuQ3JlYXRlIjtpOjI2ODtzOjkwOiJSZXNwb25zZS5Xcml0ZSgiPGJyPiggKSA8YSBocmVmPT90eXBlPTEmZmlsZT0iICYgc2VydmVyLlVSTGVuY29kZShpdGVtLnBhdGgpICYgIlw+IiAmIGl0ZW0iO2k6MjY5O3M6MTA0OiJzcWxDb21tYW5kLlBhcmFtZXRlcnMuQWRkKCgoVGFibGVDZWxsKWRhdGFHcmlkSXRlbS5Db250cm9sc1swXSkuVGV4dCwgU3FsRGJUeXBlLkRlY2ltYWwpLlZhbHVlID0gZGVjaW1hbCI7aToyNzA7czo2NDoiPCU9ICJcIiAmIG9TY3JpcHROZXQuQ29tcHV0ZXJOYW1lICYgIlwiICYgb1NjcmlwdE5ldC5Vc2VyTmFtZSAlPiI7aToyNzE7czo1MDoiY3VybF9zZXRvcHQoJGNoLCBDVVJMT1BUX1VSTCwgImh0dHA6Ly8kaG9zdDoyMDgyIikiO2k6MjcyO3M6NTg6IkhKM0hqdXRja29SZnBYZjlBMXpRTzJBd0RSclJleTl1R3ZUZWV6NzlxQWFvMWEwcmd1ZGtaa1I4UmEiO2k6MjczO3M6MzE6IiRpbmlbJ3VzZXJzJ10gPSBhcnJheSgncm9vdCcgPT4iO2k6Mjc0O3M6MzE6ImZ3cml0ZSgkZnAsIlx4RUZceEJCXHhCRiIuJGJvZHkiO2k6Mjc1O3M6MTg6InByb2Nfb3BlbignSUhTdGVhbSI7aToyNzY7czoyNDoiJGJhc2xpaz0kX1BPU1RbJ2Jhc2xpayddIjtpOjI3NztzOjMwOiJmcmVhZCgkZnAsIGZpbGVzaXplKCRmaWNoZXJvKSkiO2k6Mjc4O3M6Mzk6IkkvZ2NaL3ZYMEExMEREUkRnN0V6ay9kKzMrOHF2cXFTMUswK0FYWSI7aToyNzk7czoxNjoieyRfUE9TVFsncm9vdCddfSI7aToyODA7czoyOToifWVsc2VpZigkX0dFVFsncGFnZSddPT0nZGRvcyciO2k6MjgxO3M6MTQ6IlRoZSBEYXJrIFJhdmVyIjtpOjI4MjtzOjM5OiIkdmFsdWUgPX4gcy8lKC4uKS9wYWNrKCdjJyxoZXgoJDEpKS9lZzsiO2k6MjgzO3M6MTE6Ind3dy50MHMub3JnIjtpOjI4NDtzOjMwOiJ1bmxlc3Mob3BlbihQRkQsJGdfdXBsb2FkX2RiKSkiO2k6Mjg1O3M6MTI6ImF6ODhwaXgwMHE5OCI7aToyODY7czoxMToic2ggZ28gJDEuJHgiO2k6Mjg3O3M6MjY6InN5c3RlbSgicGhwIC1mIHhwbCAkaG9zdCIpIjtpOjI4ODtzOjEzOiJleHBsb2l0Y29va2llIjtpOjI4OTtzOjIxOiI4MCAtYiAkMSAtaSBldGgwIC1zIDgiO2k6MjkwO3M6MjU6IkhUVFAgZmxvb2QgY29tcGxldGUgYWZ0ZXIiO2k6MjkxO3M6MTU6Ik5JR0dFUlMuTklHR0VSUyI7aToyOTI7czo0NzoiaWYoaXNzZXQoJF9HRVRbJ2hvc3QnXSkmJmlzc2V0KCRfR0VUWyd0aW1lJ10pKXsiO2k6MjkzO3M6ODM6InN1YnByb2Nlc3MuUG9wZW4oY21kLCBzaGVsbCA9IFRydWUsIHN0ZG91dD1zdWJwcm9jZXNzLlBJUEUsIHN0ZGVycj1zdWJwcm9jZXNzLlNURE9VIjtpOjI5NDtzOjY5OiJkZWYgZGFlbW9uKHN0ZGluPScvZGV2L251bGwnLCBzdGRvdXQ9Jy9kZXYvbnVsbCcsIHN0ZGVycj0nL2Rldi9udWxsJykiO2k6Mjk1O3M6Njc6InByaW50KCJbIV0gSG9zdDogIiArIGhvc3RuYW1lICsgIiBtaWdodCBiZSBkb3duIVxuWyFdIFJlc3BvbnNlIENvZGUiO2k6Mjk2O3M6NDI6ImNvbm5lY3Rpb24uc2VuZCgic2hlbGwgIitzdHIob3MuZ2V0Y3dkKCkpKyI7aToyOTc7czo1MDoib3Muc3lzdGVtKCdlY2hvIGFsaWFzIGxzPSIubHMuYmFzaCIgPj4gfi8uYmFzaHJjJykiO2k6Mjk4O3M6MzI6InJ1bGVfcmVxID0gcmF3X2lucHV0KCJTb3VyY2VGaXJlIjtpOjI5OTtzOjU3OiJhcmdwYXJzZS5Bcmd1bWVudFBhcnNlcihkZXNjcmlwdGlvbj1oZWxwLCBwcm9nPSJzY3R1bm5lbCIiO2k6MzAwO3M6NTc6InN1YnByb2Nlc3MuUG9wZW4oJyVzZ2RiIC1wICVkIC1iYXRjaCAlcycgJSAoZ2RiX3ByZWZpeCwgcCI7aTozMDE7czo1OToiJGZyYW1ld29yay5wbHVnaW5zLmxvYWQoIiN7cnBjdHlwZS5kb3duY2FzZX1ycGMiLCBvcHRzKS5ydW4iO2k6MzAyO3M6Mjg6ImlmIHNlbGYuaGFzaF90eXBlID09ICdwd2R1bXAiO2k6MzAzO3M6MTc6Iml0c29rbm9wcm9ibGVtYnJvIjtpOjMwNDtzOjQ1OiJhZGRfZmlsdGVyKCd0aGVfY29udGVudCcsICdfYmxvZ2luZm8nLCAxMDAwMSkiO2k6MzA1O3M6OToiPHN0ZGxpYi5oIjtpOjMwNjtzOjU5OiJlY2hvIHkgOyBzbGVlcCAxIDsgfSB8IHsgd2hpbGUgcmVhZCA7IGRvIGVjaG8geiRSRVBMWTsgZG9uZSI7aTozMDc7czoxMToiVk9CUkEgR0FOR08iO2k6MzA4O3M6NzY6ImludDMyKCgoJHogPj4gNSAmIDB4MDdmZmZmZmYpIF4gJHkgPDwgMikgKyAoKCR5ID4+IDMgJiAweDFmZmZmZmZmKSBeICR6IDw8IDQiO2k6MzA5O3M6Njk6IkBjb3B5KCRfRklMRVNbZmlsZU1hc3NdW3RtcF9uYW1lXSwkX1BPU1RbcGF0aF0uJF9GSUxFU1tmaWxlTWFzc11bbmFtZSI7aTozMTA7czo0NjoiZmluZF9kaXJzKCRncmFuZHBhcmVudF9kaXIsICRsZXZlbCwgMSwgJGRpcnMpOyI7aTozMTE7czoyODoiQHNldGNvb2tpZSgiaGl0IiwgMSwgdGltZSgpKyI7aTozMTI7czo1OiJlLyouLyI7aTozMTM7czozNzoiSkhacGMybDBZMjkxYm5RZ1BTQWtTRlJVVUY5RFQwOUxTVVZmViI7aTozMTQ7czozNToiMGQwYTBkMGE2NzZjNmY2MjYxNmMyMDI0NmQ3OTVmNzM2ZDciO2k6MzE1O3M6MTk6ImZvcGVuKCcvZXRjL3Bhc3N3ZCciO2k6MzE2O3M6NzY6IiR0c3UyW3JhbmQoMCxjb3VudCgkdHN1MikgLSAxKV0uJHRzdTFbcmFuZCgwLGNvdW50KCR0c3UxKSAtIDEpXS4kdHN1MltyYW5kKDAiO2k6MzE3O3M6MzM6Ii91c3IvbG9jYWwvYXBhY2hlL2Jpbi9odHRwZCAtRFNTTCI7aTozMTg7czoyMDoic2V0IHByb3RlY3QtdGVsbmV0IDAiO2k6MzE5O3M6Mjc6ImF5dSBwcjEgcHIyIHByMyBwcjQgcHI1IHByNiI7aTozMjA7czozMDoiYmluZCBmaWx0IC0gIlwwMDFBQ1RJT04gKlwwMDEiIjtpOjMyMTtzOjUwOiJyZWdzdWIgLWFsbCAtLSAsIFtzdHJpbmcgdG9sb3dlciAkb3duZXJdICIiIG93bmVycyI7aTozMjI7czozNToia2lsbCAtQ0hMRCBcJGJvdHBpZCA+L2Rldi9udWxsIDI+JjEiO2k6MzIzO3M6MTA6ImJpbmQgZGNjIC0iO2k6MzI0O3M6MjQ6InI0YVRjLmRQbnRFL2Z6dFNGMWJIM1JIMCI7aTozMjU7czoxMzoicHJpdm1zZyAkY2hhbiI7aTozMjY7czoyMjoiYmluZCBqb2luIC0gKiBnb3Bfam9pbiI7aTozMjc7czo0Mzoic2V0IGdvb2dsZShkYXRhKSBbaHR0cDo6ZGF0YSAkZ29vZ2xlKHBhZ2UpXSI7aTozMjg7czoyNjoicHJvYyBodHRwOjpDb25uZWN0IHt0b2tlbn0iO2k6MzI5O3M6MTM6InByaXZtc2cgJG5pY2siO2k6MzMwO3M6MTE6InB1dGJvdCAkYm90IjtpOjMzMTtzOjEyOiJ1bmJpbmQgUkFXIC0iO2k6MzMyO3M6Mjk6Ii0tRENDRElSIFtsaW5kZXggJFVzZXIoJGkpIDJdIjtpOjMzMztzOjEwOiJDeWJlc3RlcjkwIjtpOjMzNDtzOjQxOiJmaWxlX2dldF9jb250ZW50cyh0cmltKCRmWyRfR0VUWydpZCddXSkpOyI7aTozMzU7czoyMToidW5saW5rKCR3cml0YWJsZV9kaXJzIjtpOjMzNjtzOjI3OiJiYXNlNjRfZGVjb2RlKCRjb2RlX3NjcmlwdCkiO2k6MzM3O3M6MjE6Imx1Y2lmZmVyQGx1Y2lmZmVyLm9yZyI7aTozMzg7czo0ODoiJHRoaXMtPkYtPkdldENvbnRyb2xsZXIoJF9TRVJWRVJbJ1JFUVVFU1RfVVJJJ10pIjtpOjMzOTtzOjQ3OiIkdGltZV9zdGFydGVkLiRzZWN1cmVfc2Vzc2lvbl91c2VyLnNlc3Npb25faWQoKSI7aTozNDA7czo3NDoiJHBhcmFtIHggJG4uc3Vic3RyICgkcGFyYW0sIGxlbmd0aCgkcGFyYW0pIC0gbGVuZ3RoKCRjb2RlKSVsZW5ndGgoJHBhcmFtKSkiO2k6MzQxO3M6MzY6ImZ3cml0ZSgkZixnZXRfZG93bmxvYWQoJF9HRVRbJ3VybCddKSI7aTozNDI7czo2NToiaHR0cDovLycuJF9TRVJWRVJbJ0hUVFBfSE9TVCddLnVybGRlY29kZSgkX1NFUlZFUlsnUkVRVUVTVF9VUkknXSkiO2k6MzQzO3M6ODA6IndwX3Bvc3RzIFdIRVJFIHBvc3RfdHlwZSA9ICdwb3N0JyBBTkQgcG9zdF9zdGF0dXMgPSAncHVibGlzaCcgT1JERVIgQlkgYElEYCBERVNDIjtpOjM0NDtzOjM3OiIkdXJsID0gJHVybHNbcmFuZCgwLCBjb3VudCgkdXJscyktMSldIjtpOjM0NTtzOjQ3OiJwcmVnX21hdGNoKCcvKD88PVJld3JpdGVSdWxlKS4qKD89XFtMXCxSXD0zMDJcXSI7aTozNDY7czo0NToicHJlZ19tYXRjaCgnIU1JRFB8V0FQfFdpbmRvd3MuQ0V8UFBDfFNlcmllczYwIjtpOjM0NztzOjYwOiJSMGxHT0RsaEV3QVFBTE1BQUFBQUFQLy8vNXljQU03T1kvLy9uUC8venYvT25QZjM5Ly8vL3dBQUFBQUEiO2k6MzQ4O3M6NjU6InN0cl9yb3QxMygkYmFzZWFbKCRkaW1lbnNpb24qJGRpbWVuc2lvbi0xKSAtICgkaSokZGltZW5zaW9uKyRqKV0pIjtpOjM0OTtzOjc1OiJpZihlbXB0eSgkX0dFVFsnemlwJ10pIGFuZCBlbXB0eSgkX0dFVFsnZG93bmxvYWQnXSkgJiBlbXB0eSgkX0dFVFsnaW1nJ10pKXsiO2k6MzUwO3M6MTY6Ik1hZGUgYnkgRGVsb3JlYW4iO2k6MzUxO3M6NDY6Im92ZXJmbG93LXk6c2Nyb2xsO1wiPiIuJGxpbmtzLiRodG1sX21mWydib2R5J10iO2k6MzUyO3M6NDM6ImZ1bmN0aW9uIHVybEdldENvbnRlbnRzKCR1cmwsICR0aW1lb3V0ID0gNSkiO2k6MzUzO3M6NjoiZDNsZXRlIjtpOjM1NDtzOjE1OiJsZXRha3Nla2FyYW5nKCkiO2k6MzU1O3M6ODoiWUVOSTNFUkkiO2k6MzU2O3M6MjE6IiRPT08wMDAwMDA9dXJsZGVjb2RlKCI7aTozNTc7czoyMDoiLUkvdXNyL2xvY2FsL2JhbmRtaW4iO2k6MzU4O3M6Mzc6ImZ3cml0ZSgkZnBzZXR2LCBnZXRlbnYoIkhUVFBfQ09PS0lFIikiO2k6MzU5O3M6MjU6Imlzc2V0KCRfUE9TVFsnZXhlY2dhdGUnXSkiO2k6MzYwO3M6MTU6IldlYmNvbW1hbmRlciBhdCI7aTozNjE7czoxNDoiPT0gImJpbmRzaGVsbCIiO2k6MzYyO3M6ODoiUGFzaGtlbGEiO2k6MzYzO3M6MjU6ImNyZWF0ZUZpbGVzRm9ySW5wdXRPdXRwdXQiO2k6MzY0O3M6NjoiTTRsbDNyIjtpOjM2NTtzOjIwOiJfX1ZJRVdTVEFURUVOQ1JZUFRFRCI7aTozNjY7czo3OiJPb05fQm95IjtpOjM2NztzOjEzOiJSZWFMX1B1TmlTaEVyIjtpOjM2ODtzOjg6ImRhcmttaW56IjtpOjM2OTtzOjU6IlplZDB4IjtpOjM3MDtzOjQwOiJhYmFjaG98YWJpemRpcmVjdG9yeXxhYm91dHxhY29vbnxhbGV4YW5hIjtpOjM3MTtzOjM2OiJwcGN8bWlkcHx3aW5kb3dzIGNlfG10a3xqMm1lfHN5bWJpYW4iO2k6MzcyO3M6NDc6IkBjaHIoKCRoWyRlWyRvXV08PDQpKygkaFskZVsrKyRvXV0pKTt9fWV2YWwoJGQpIjtpOjM3MztzOjExOiIkc2gzbGxDb2xvciI7aTozNzQ7czoxMDoiUHVua2VyMkJvdCI7aTozNzU7czoxODoiPD9waHAgZWNobyAiIyEhIyI7IjtpOjM3NjtzOjc1OiIkaW09c3Vic3RyKCRpbSwwLCRpKS5zdWJzdHIoJGltLCRpMisxLCRpNC0oJGkyKzEpKS5zdWJzdHIoJGltLCRpNCsxMixzdHJsZW4iO2k6Mzc3O3M6NTU6IigkaW5kYXRhLCRiNjQ9MSl7aWYoJGI2ND09MSl7JGNkPWJhc2U2NF9kZWNvZGUoJGluZGF0YSkiO2k6Mzc4O3M6MTc6IigkX1BPU1RbImRpciJdKSk7IjtpOjM3OTtzOjE3OiJIYWNrZWQgQnkgRW5ETGVTcyI7aTozODA7czoxMDoiYW5kZXh8b29nbCI7aTozODE7czoxMDoibmRyb2l8aHRjXyI7aTozODI7czoxMDoiPGRvdD5JcklzVCI7aTozODM7czoyMToiN1AxdGQrTldsaWFJL2hXa1o0Vlg5IjtpOjM4NDtzOjE1OiJOaW5qYVZpcnVzIEhlcmUiO2k6Mzg1O3M6MzI6IiRpbT1zdWJzdHIoJHR4LCRwKzIsJHAyLSgkcCsyKSk7IjtpOjM4NjtzOjY6IjN4cDFyMyI7aTozODc7czoyMDoiJG1kNT1tZDUoIiRyYW5kb20iKTsiO2k6Mzg4O3M6Mjg6Im9UYXQ4RDNEc0U4JyZ+aFUwNkNDSDU7JGdZU3EiO2k6Mzg5O3M6MTI6IkdJRjg5QTs8P3BocCI7aTozOTA7czoxNToiQ3JlYXRlZCBCeSBFTU1BIjtpOjM5MTtzOjM0OiJQYXNzd29yZDo8cz4iLiRfUE9TVFs8cT5wYXNzd2Q8cT5dIjtpOjM5MjtzOjE1OiJOZXRAZGRyZXNzIE1haWwiO2k6MzkzO3M6MjQ6IiRpc2V2YWxmdW5jdGlvbmF2YWlsYWJsZSI7aTozOTQ7czoxMToiQmFieV9EcmFrb24iO2k6Mzk1O3M6MzA6ImZ3cml0ZShmb3BlbihkaXJuYW1lKF9fRklMRV9fKSI7aTozOTY7czoxMzoiXV0pKTt9fWV2YWwoJCI7aTozOTc7czoyNzoiZXJlZ19yZXBsYWNlKDxxPiZlbWFpbCY8cT4sIjtpOjM5ODtzOjE5OiIpOyAkaSsrKSRyZXQuPWNocigkIjtpOjM5OTtzOjU3OiIkcGFyYW0ybWFzay4iKVw9W1w8cXE+XCJdKC4qPykoPz1bXDxxcT5cIl0gKVtcPHFxPlwiXS9zaWUiO2k6NDAwO3M6OToiLy9yYXN0YS8vIjtpOjQwMTtzOjIwOiI8IS0tQ09PS0lFIFVQREFURS0tPiI7aTo0MDI7czoxMzoicHJvZmV4b3IuaGVsbCI7aTo0MDM7czoxMzoiTWFnZWxhbmdDeWJlciI7aTo0MDQ7czo4OiJaT0JVR1RFTCI7aTo0MDU7czoxMzoiRmFrZVNlbmRlciBieSI7aTo0MDY7czoyMToiZGF0YTp0ZXh0L2h0bWw7YmFzZTY0IjtpOjQwNztzOjg6IlNfXUBfXlVeIjtpOjQwODtzOjEzOiJAJF9QT1NUWyhjaHIoIjtpOjQwOTtzOjEyOiJaZXJvRGF5RXhpbGUiO2k6NDEwO3M6MTI6IlN1bHRhbkhhaWthbCI7aTo0MTE7czoxMToiQ291cGRlZ3JhY2UiO2k6NDEyO3M6OToiYXJ0aWNrbGVAIjtpOjQxMztzOjE1OiJnbml0cm9wZXJfcm9ycmUiO2k6NDE0O3M6MjM6ImN1dHRlclthdF1yZWFsLnhha2VwLnJ1IjtpOjQxNTtzOjI5OiJpZigkd3BfX3dwPUBnemluZmxhdGUoJHdwX193cCI7aTo0MTY7czo2OiJyMDBuaXgiO2k6NDE3O3M6MjE6IiRmdWxsX3BhdGhfdG9fZG9vcndheSI7aTo0MTg7czozMDoiPGI+RG9uZSA9PT4gJHVzZXJmaWxlX25hbWU8L2I+IjtpOjQxOTtzOjEyOiI+RGFyayBTaGVsbDwiO2k6NDIwO3M6MTU6Ii8uLi8qL2luZGV4LnBocCI7aTo0MjE7czozMjoiaWYoaXNfdXBsb2FkZWRfZmlsZS8qOyovKCRfRklMRVMiO2k6NDIyO3M6MjM6ImV4ZWMoJGNvbW1hbmQsICRvdXRwdXQpIjtpOjQyMztzOjIwOiJAaW5jbHVkZV9vbmNlKCcvdG1wLyI7aTo0MjQ7czo4MToidHJpbSgnaHR0cDovLycuJHNjLjxxcT4/Q29tbWFuZD1HZXRGb2xkZXJzQW5kRmlsZXMmVHlwZT1GaWxlJkN1cnJlbnRGb2xkZXI9JTJGJTAwIjtpOjQyNTtzOjU5OiIkc2NyaXB0X2ZpbmQgPSBzdHJfcmVwbGFjZSgibG9hZGVyIiwgImZpbmQiLCAkc2NyaXB0X2xvYWRlciI7aTo0MjY7czoxODoiPHRpdGxlPi4vSGFja2VkIEJ5Ijt9"));
$gX_DBShe = unserialize(base64_decode("YTo2Mzp7aTowO3M6ODoiRmlsZXNNYW4iO2k6MTtzOjc6ImRlZmFjZXIiO2k6MjtzOjI0OiJZb3UgY2FuIHB1dCBhIG1kNSBzdHJpbmciO2k6MztzOjg6InBocHNoZWxsIjtpOjQ7czo2MjoiPGRpdiBjbGFzcz0iYmxvY2sgYnR5cGUxIj48ZGl2IGNsYXNzPSJkdG9wIj48ZGl2IGNsYXNzPSJkYnRtIj4iO2k6NTtzOjg6ImM5OXNoZWxsIjtpOjY7czo4OiJyNTdzaGVsbCI7aTo3O3M6NzoiTlREYWRkeSI7aTo4O3M6ODoiY2loc2hlbGwiO2k6OTtzOjc6IkZ4Yzk5c2giO2k6MTA7czoxMjoiV2ViIFNoZWxsIGJ5IjtpOjExO3M6MTE6ImRldmlselNoZWxsIjtpOjEyO3M6MjU6IkhhY2tlZCBieSBBbGZhYmV0b1ZpcnR1YWwiO2k6MTM7czo4OiJOM3RzaGVsbCI7aToxNDtzOjExOiJTdG9ybTdTaGVsbCI7aToxNTtzOjExOiJMb2N1czdTaGVsbCI7aToxNjtzOjEyOiJyNTdzaGVsbC5waHAiO2k6MTc7czo5OiJhbnRpc2hlbGwiO2k6MTg7czo5OiJyb290c2hlbGwiO2k6MTk7czoxMToibXlzaGVsbGV4ZWMiO2k6MjA7czo4OiJTaGVsbCBPayI7aToyMTtzOjE0OiJleGVjKCJybSAtciAtZiI7aToyMjtzOjE4OiJOZSB1ZGFsb3MgemFncnV6aXQiO2k6MjM7czo1MToiJG1lc3NhZ2UgPSBlcmVnX3JlcGxhY2UoIiU1QyUyMiIsICIlMjIiLCAkbWVzc2FnZSk7IjtpOjI0O3M6MTk6InByaW50ICJTcGFtZWQnPjxicj4iO2k6MjU7czo0MDoic2V0Y29va2llKCAibXlzcWxfd2ViX2FkbWluX3VzZXJuYW1lIiApOyI7aToyNjtzOjM3OiJlbHNlaWYoZnVuY3Rpb25fZXhpc3RzKCJzaGVsbF9leGVjIikpIjtpOjI3O3M6NTk6ImlmIChpc19jYWxsYWJsZSgiZXhlYyIpIGFuZCAhaW5fYXJyYXkoImV4ZWMiLCRkaXNhYmxlZnVuYykpIjtpOjI4O3M6MzQ6ImlmICgoJHBlcm1zICYgMHhDMDAwKSA9PSAweEMwMDApIHsiO2k6Mjk7czoxMDoiZGlyIC9PRyAvWCI7aTozMDtzOjM2OiJpbmNsdWRlKCRfU0VSVkVSWydIVFRQX1VTRVJfQUdFTlQnXSkiO2k6MzE7czo3OiJicjB3czNyIjtpOjMyO3M6NDk6IidodHRwZC5jb25mJywndmhvc3RzLmNvbmYnLCdjZmcucGhwJywnY29uZmlnLnBocCciO2k6MzM7czozNDoiL3Byb2Mvc3lzL2tlcm5lbC95YW1hL3B0cmFjZV9zY29wZSI7aTozNDtzOjIzOiJldmFsKGZpbGVfZ2V0X2NvbnRlbnRzKCI7aTozNTtzOjE4OiJpc193cml0YWJsZSgiL3Zhci8iO2k6MzY7czoxNDoiJEdMT0JBTFNbJ19fX18iO2k6Mzc7czo1NToiaXNfY2FsbGFibGUoJ2V4ZWMnKSBhbmQgIWluX2FycmF5KCdleGVjJywgJGRpc2FibGVmdW5jcyI7aTozODtzOjY6ImswZC5jYyI7aTozOTtzOjI2OiJnbWFpbC1zbXRwLWluLmwuZ29vZ2xlLmNvbSI7aTo0MDtzOjc6IndlYnIwMHQiO2k6NDE7czoxMToiRGV2aWxIYWNrZXIiO2k6NDI7czo3OiJEZWZhY2VyIjtpOjQzO3M6MTE6IlsgUGhwcm94eSBdIjtpOjQ0O3M6ODoiW2NvZGVyel0iO2k6NDU7czozMjoiPCEtLSNleGVjIGNtZD0iJEhUVFBfQUNDRVBUIiAtLT4iO2k6NDY7czoxMjoiXVtyb3VuZCgwKV0oIjtpOjQ3O3M6MTE6IlNpbUF0dGFja2VyIjtpOjQ4O3M6MTU6IkRhcmtDcmV3RnJpZW5kcyI7aTo0OTtzOjc6ImsybGwzM2QiO2k6NTA7czo3OiJLa0sxMzM3IjtpOjUxO3M6MTU6IkhBQ0tFRCBCWSBTVE9STSI7aTo1MjtzOjE0OiJNZXhpY2FuSGFja2VycyI7aTo1MztzOjE1OiJNci5TaGluY2hhblgxOTYiO2k6NTQ7czo5OiJEZWlkYXJhflgiO2k6NTU7czoxMDoiSmlucGFudG9teiI7aTo1NjtzOjk6IjFuNzNjdDEwbiI7aTo1NztzOjE0OiJLaW5nU2tydXBlbGxvcyI7aTo1ODtzOjEwOiJKaW5wYW50b216IjtpOjU5O3M6OToiQ2VuZ2l6SGFuIjtpOjYwO3M6OToicjN2M25nNG5zIjtpOjYxO3M6OToiQkxBQ0tVTklYIjtpOjYyO3M6OToiYXJ0aWNrbGVAIjt9"));
$g_FlexDBShe = unserialize(base64_decode("YTozMjY6e2k6MDtzOjM1OiJkZWZhdWx0X2FjdGlvblxzKj1ccypcXFsnIl1GaWxlc01hbiI7aToxO3M6MzM6ImRlZmF1bHRfYWN0aW9uXHMqPVxzKlsnIl1GaWxlc01hbiI7aToyO3M6MTAwOiJJTzo6U29ja2V0OjpJTkVULT5uZXdcKFByb3RvXHMqPT5ccyoidGNwIlxzKixccypMb2NhbFBvcnRccyo9PlxzKjM2MDAwXHMqLFxzKkxpc3RlblxzKj0+XHMqU09NQVhDT05OIjtpOjM7czo5NjoiXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1xzKlsnIl17MCwxfXAyWyciXXswLDF9XHMqXF1ccyo9PVxzKlsnIl17MCwxfWNobW9kWyciXXswLDF9IjtpOjQ7czoyMzoiQ2FwdGFpblxzK0NydW5jaFxzK1RlYW0iO2k6NTtzOjExOiJieVxzK0dyaW5heSI7aTo2O3M6MTk6ImhhY2tlZFxzK2J5XHMrSG1laTciO2k6NztzOjMzOiJzeXN0ZW1ccytmaWxlXHMrZG9ccytub3RccytkZWxldGUiO2k6ODtzOjE3MDoiXCRpbmZvIFwuPSBcKFwoXCRwZXJtc1xzKiZccyoweDAwNDBcKVxzKlw/XChcKFwkcGVybXNccyomXHMqMHgwODAwXClccypcP1xzKlxcWyciXXNcXFsnIl1ccyo6XHMqXFxbJyJdeFxcWyciXVxzKlwpXHMqOlwoXChcJHBlcm1zXHMqJlxzKjB4MDgwMFwpXHMqXD9ccyonUydccyo6XHMqJy0nXHMqXCkiO2k6OTtzOjc4OiJXU09zZXRjb29raWVccypcKFxzKm1kNVxzKlwoXHMqQCpcJF9TRVJWRVJcW1xzKlxcWyciXUhUVFBfSE9TVFxcWyciXVxzKlxdXHMqXCkiO2k6MTA7czo3NDoiV1NPc2V0Y29va2llXHMqXChccyptZDVccypcKFxzKkAqXCRfU0VSVkVSXFtccypbJyJdSFRUUF9IT1NUWyciXVxzKlxdXHMqXCkiO2k6MTE7czoxMDc6Indzb0V4XHMqXChccypcXFsnIl1ccyp0YXJccypjZnp2XHMqXFxbJyJdXHMqXC5ccyplc2NhcGVzaGVsbGFyZ1xzKlwoXHMqXCRfUE9TVFxbXHMqXFxbJyJdcDJcXFsnIl1ccypcXVxzKlwpIjtpOjEyO3M6NDA6ImV2YWxccypcKCpccypiYXNlNjRfZGVjb2RlXHMqXCgqXHMqQCpcJF8iO2k6MTM7czo3ODoiZmlsZXBhdGhccyo9XHMqQCpyZWFscGF0aFxzKlwoXHMqXCRfUE9TVFxzKlxbXHMqXFxbJyJdZmlsZXBhdGhcXFsnIl1ccypcXVxzKlwpIjtpOjE0O3M6NzQ6ImZpbGVwYXRoXHMqPVxzKkAqcmVhbHBhdGhccypcKFxzKlwkX1BPU1RccypcW1xzKlsnIl1maWxlcGF0aFsnIl1ccypcXVxzKlwpIjtpOjE1O3M6NDc6InJlbmFtZVxzKlwoXHMqXHMqWyciXXswLDF9d3NvXC5waHBbJyJdezAsMX1ccyosIjtpOjE2O3M6OTc6IlwkTWVzc2FnZVN1YmplY3Rccyo9XHMqYmFzZTY0X2RlY29kZVxzKlwoXHMqXCRfUE9TVFxzKlxbXHMqWyciXXswLDF9bXNnc3ViamVjdFsnIl17MCwxfVxzKlxdXHMqXCkiO2k6MTc7czo4NzoiU0VMRUNUXHMrMVxzK0ZST01ccytteXNxbFwudXNlclxzK1dIRVJFXHMrY29uY2F0XChccypgdXNlcmBccyosXHMqJ0AnXHMqLFxzKmBob3N0YFxzKlwpIjtpOjE4O3M6NTY6InBhc3N0aHJ1XHMqXCgqXHMqZ2V0ZW52XHMqXCgqXHMqWyciXUhUVFBfQUNDRVBUX0xBTkdVQUdFIjtpOjE5O3M6NTg6InBhc3N0aHJ1XHMqXCgqXHMqZ2V0ZW52XHMqXCgqXHMqXFxbJyJdSFRUUF9BQ0NFUFRfTEFOR1VBR0UiO2k6MjA7czo1NToie1xzKlwkXHMqe1xzKnBhc3N0aHJ1XHMqXCgqXHMqXCRjbWRccypcKVxzKn1ccyp9XHMqPGJyPiI7aToyMTtzOjgyOiJydW5jb21tYW5kXHMqXChccypbJyJdc2hlbGxoZWxwWyciXVxzKixccypbJyJdKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClbJyJdIjtpOjIyO3M6MzE6Im5jZnRwcHV0XHMqLXVccypcJGZ0cF91c2VyX25hbWUiO2k6MjM7czozNzoiXCRsb2dpblxzKj1ccypAKnBvc2l4X2dldHVpZFwoKlxzKlwpKiI7aToyNDtzOjQ5OiIhQCpcJF9SRVFVRVNUXHMqXFtccypbJyJdYzk5c2hfc3VybFsnIl1ccypcXVxzKlwpIjtpOjI1O3M6NTM6InNldGNvb2tpZVwoKlxzKlsnIl1teXNxbF93ZWJfYWRtaW5fdXNlcm5hbWVbJyJdXHMqXCkqIjtpOjI2O3M6MTQzOiJcYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChbJyJdXCRjbWRccysxPlxzKi90bXAvY21kdGVtcFxzKzI+JjE7XHMqY2F0XHMrL3RtcC9jbWR0ZW1wO1xzKnJtXHMrL3RtcC9jbWR0ZW1wWyciXVwpOyI7aToyNztzOjI4OiJcJGZlXChbJyJdXCRjbWRccysyPiYxWyciXVwpIjtpOjI4O3M6OTY6IlwkZnVuY3Rpb25ccypcKCpccypAKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXHMqXFtccypbJyJdezAsMX1jbWRbJyJdezAsMX1ccypcXVxzKlwpKiI7aToyOTtzOjkzOiJcJGNtZFxzKj1ccypcKFxzKkAqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClccypcW1xzKlsnIl17MCwxfS4rP1snIl17MCwxfVxzKlxdXHMqXCkiO2k6MzA7czoyMDoiZXZhMVthLXpBLVowLTlfXStTaXIiO2k6MzE7czo4ODoiXCRpbmlccypcW1xzKlsnIl17MCwxfXVzZXJzWyciXXswLDF9XHMqXF1ccyo9XHMqYXJyYXlccypcKFxzKlsnIl17MCwxfXJvb3RbJyJdezAsMX1ccyo9PiI7aTozMjtzOjMzOiJwcm9jX29wZW5ccypcKFxzKlsnIl17MCwxfUlIU3RlYW0iO2k6MzM7czoxMzU6IlsnIl17MCwxfWh0dHBkXC5jb25mWyciXXswLDF9XHMqLFxzKlsnIl17MCwxfXZob3N0c1wuY29uZlsnIl17MCwxfVxzKixccypbJyJdezAsMX1jZmdcLnBocFsnIl17MCwxfVxzKixccypbJyJdezAsMX1jb25maWdcLnBocFsnIl17MCwxfSI7aTozNDtzOjgxOiJccyp7XHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClccypcW1xzKlsnIl17MCwxfXJvb3RbJyJdezAsMX1ccypcXVxzKn0iO2k6MzU7czo0NjoicHJlZ19yZXBsYWNlXHMqXCgqXHMqWyciXXswLDF9L1wuXCovZVsnIl17MCwxfSI7aTozNjtzOjM2OiJldmFsXHMqXCgqXHMqZmlsZV9nZXRfY29udGVudHNccypcKCoiO2k6Mzc7czo3NDoiQCpzZXRjb29raWVccypcKCpccypbJyJdezAsMX1oaXRbJyJdezAsMX0sXHMqMVxzKixccyp0aW1lXHMqXCgqXHMqXCkqXHMqXCsiO2k6Mzg7czo0MToiZXZhbFxzKlwoKkAqXHMqc3RyaXBzbGFzaGVzXHMqXCgqXHMqQCpcJF8iO2k6Mzk7czo1OToiZXZhbFxzKlwoKkAqXHMqc3RyaXBzbGFzaGVzXHMqXCgqXHMqYXJyYXlfcG9wXHMqXCgqXHMqQCpcJF8iO2k6NDA7czo0MzoiZm9wZW5ccypcKCpccypbJyJdezAsMX0vZXRjL3Bhc3N3ZFsnIl17MCwxfSI7aTo0MTtzOjI0OiJcJEdMT0JBTFNcW1snIl17MCwxfV9fX18iO2k6NDI7czoyMTc6ImlzX2NhbGxhYmxlXHMqXCgqXHMqWyciXXswLDF9XGIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVsnIl17MCwxfVwpKlxzK2FuZFxzKyFpbl9hcnJheVxzKlwoKlxzKlsnIl17MCwxfVxiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilbJyJdezAsMX1ccyosXHMqXCRkaXNhYmxlZnVuY3MiO2k6NDM7czoxMTI6ImZpbGVfZ2V0X2NvbnRlbnRzXHMqXCgqXHMqdHJpbVxzKlwoXHMqXCQuKz9cW1wkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtbJyJdezAsMX0uKz9bJyJdezAsMX1cXVxdXClcKTsiO2k6NDQ7czoxMzY6IndwX3Bvc3RzXHMrV0hFUkVccytwb3N0X3R5cGVccyo9XHMqWyciXXswLDF9cG9zdFsnIl17MCwxfVxzK0FORFxzK3Bvc3Rfc3RhdHVzXHMqPVxzKlsnIl17MCwxfXB1Ymxpc2hbJyJdezAsMX1ccytPUkRFUlxzK0JZXHMrYElEYFxzK0RFU0MiO2k6NDU7czoyMDoiZXhlY1xzKlwoXHMqWyciXWlwZnciO2k6NDY7czo0Mjoic3RycmV2XCgqXHMqWyciXXswLDF9dHJlc3NhWyciXXswLDF9XHMqXCkqIjtpOjQ3O3M6NDk6InN0cnJldlwoKlxzKlsnIl17MCwxfWVkb2NlZF80NmVzYWJbJyJdezAsMX1ccypcKSoiO2k6NDg7czo3MDoiZnVuY3Rpb25ccyt1cmxHZXRDb250ZW50c1xzKlwoKlxzKlwkdXJsXHMqLFxzKlwkdGltZW91dFxzKj1ccypcZCtccypcKSI7aTo0OTtzOjcxOiJmd3JpdGVccypcKCpccypcJGZwc2V0dlxzKixccypnZXRlbnZccypcKFxzKlsnIl1IVFRQX0NPT0tJRVsnIl1ccypcKVxzKiI7aTo1MDtzOjY2OiJpc3NldFxzKlwoKlxzKlwkX1BPU1RccypcW1xzKlsnIl17MCwxfWV4ZWNnYXRlWyciXXswLDF9XHMqXF1ccypcKSoiO2k6NTE7czoyMDA6IlVOSU9OXHMrU0VMRUNUXHMrWyciXXswLDF9MFsnIl17MCwxfVxzKixccypbJyJdezAsMX08XD8gc3lzdGVtXChcXFwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtjcGNcXVwpO2V4aXQ7XHMqXD8+WyciXXswLDF9XHMqLFxzKjBccyosMFxzKixccyowXHMqLFxzKjBccytJTlRPXHMrT1VURklMRVxzK1snIl17MCwxfVwkWyciXXswLDF9IjtpOjUyO3M6MTQ5OiJcJEdMT0JBTFNcW1snIl17MCwxfS4rP1snIl17MCwxfVxdPUFycmF5XHMqXChccypiYXNlNjRfZGVjb2RlXHMqXChccypbJyJdezAsMX0uKz9bJyJdezAsMX1ccypcKVxzKixccypiYXNlNjRfZGVjb2RlXHMqXChccypbJyJdezAsMX0uKz9bJyJdezAsMX1ccypcKSI7aTo1MztzOjczOiJwcmVnX3JlcGxhY2VccypcKCpccypbJyJdezAsMX0vXC5cKlxbLis/XF1cPy9lWyciXXswLDF9XHMqLFxzKnN0cl9yZXBsYWNlIjtpOjU0O3M6MTAxOiJcJEdMT0JBTFNcW1xzKlsnIl17MCwxfS4rP1snIl17MCwxfVxzKlxdXFtccypcZCtccypcXVwoXHMqXCRfXGQrXHMqLFxzKl9cZCtccypcKFxzKlxkK1xzKlwpXHMqXClccypcKSI7aTo1NTtzOjExNToiXCRiZWVjb2RlXHMqPUAqZmlsZV9nZXRfY29udGVudHNccypcKCpbJyJdezAsMX1ccypcJHVybHB1cnNccypbJyJdezAsMX1cKSpccyo7XHMqZWNob1xzK1snIl17MCwxfVwkYmVlY29kZVsnIl17MCwxfSI7aTo1NjtzOjc5OiJcJHhcZCtccyo9XHMqWyciXS4rP1snIl1ccyo7XHMqXCR4XGQrXHMqPVxzKlsnIl0uKz9bJyJdXHMqO1xzKlwkeFxkK1xzKj1ccypbJyJdIjtpOjU3O3M6NDM6IjxcP3BocFxzK1wkX0Zccyo9XHMqX19GSUxFX19ccyo7XHMqXCRfWFxzKj0iO2k6NTg7czo2ODoiaWZccytcKCpccyptYWlsXHMqXChccypcJHJlY3BccyosXHMqXCRzdWJqXHMqLFxzKlwkc3R1bnRccyosXHMqXCRmcm0iO2k6NTk7czoxMzk6ImlmXHMrXChccypzdHJwb3NccypcKFxzKlwkdXJsXHMqLFxzKlsnIl1qcy9tb290b29sc1wuanNbJyJdXHMqXClccyo9PT1ccypmYWxzZVxzKyYmXHMrc3RycG9zXHMqXChccypcJHVybFxzKixccypbJyJdanMvY2FwdGlvblwuanNbJyJdezAsMX0iO2k6NjA7czo4MToiZXZhbFxzKlwoKlxzKnN0cmlwc2xhc2hlc1xzKlwoKlxzKmFycmF5X3BvcFwoKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjYxO3M6MjIxOiJpZlxzKlwoKlxzKmlzc2V0XHMqXCgqXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClccypcW1xzKlsnIl17MCwxfVx3K1snIl17MCwxfVxzKlxdXHMqXCkqXHMqXClccyp7XHMqXCRcdytccyo9XHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClccypcW1xzKlsnIl17MCwxfVx3K1snIl17MCwxfVxzKlxdO1xzKmV2YWxccypcKCpccypcJFx3K1xzKlwpKiI7aTo2MjtzOjEyMzoicHJlZ19yZXBsYWNlXHMqXChccypbJyJdL1xeXCh3d3dcfGZ0cFwpXFxcLi9pWyciXVxzKixccypbJyJdWyciXSxccypAXCRfU0VSVkVSXHMqXFtccypbJyJdezAsMX1IVFRQX0hPU1RbJyJdezAsMX1ccypcXVxzKlwpIjtpOjYzO3M6MTAxOiJpZlxzKlwoIWZ1bmN0aW9uX2V4aXN0c1xzKlwoXHMqWyciXXBvc2l4X2dldHB3dWlkWyciXVxzKlwpXHMqJiZccyohaW5fYXJyYXlccypcKFxzKlsnIl1wb3NpeF9nZXRwd3VpZCI7aTo2NDtzOjg4OiI9XHMqcHJlZ19zcGxpdFxzKlwoXHMqWyciXS9cXCxcKFxcIFwrXClcPy9bJyJdLFxzKkAqaW5pX2dldFxzKlwoXHMqWyciXWRpc2FibGVfZnVuY3Rpb25zIjtpOjY1O3M6NDc6IlwkYlxzKlwuXHMqXCRwXHMqXC5ccypcJGhccypcLlxzKlwka1xzKlwuXHMqXCR2IjtpOjY2O3M6MjM6IlwoXHMqWyciXUlOU0hFTExbJyJdXHMqIjtpOjY3O3M6NTQ6IihHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXHMqXFtccypbJyJdX19fWyciXVxzKiI7aTo2ODtzOjk0OiJhcnJheV9wb3BccypcKCpccypcJHdvcmtSZXBsYWNlXHMqLFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXHMqLFxzKlwkY291bnRLZXlzTmV3IjtpOjY5O3M6MzU6ImlmXHMqXCgqXHMqQCpwcmVnX21hdGNoXHMqXCgqXHMqc3RyIjtpOjcwO3M6NDM6IkBcJF9DT09LSUVcW1snIl17MCwxfXN0YXRDb3VudGVyWyciXXswLDF9XF0iO2k6NzE7czoxMDU6ImZvcGVuXHMqXCgqXHMqWyciXWh0dHA6Ly9bJyJdXHMqXC5ccypcJGNoZWNrX2RvbWFpblxzKlwuXHMqWyciXTo4MFsnIl1ccypcLlxzKlwkY2hlY2tfZG9jXHMqLFxzKlsnIl1yWyciXSI7aTo3MjtzOjU1OiJAKmd6aW5mbGF0ZVxzKlwoXHMqQCpiYXNlNjRfZGVjb2RlXHMqXChccypAKnN0cl9yZXBsYWNlIjtpOjczO3M6Mjg6ImZpbGVfcHV0X2NvbnRlbnR6XHMqXCgqXHMqXCQiO2k6NzQ7czo4NzoiJiZccypmdW5jdGlvbl9leGlzdHNccypcKCpccypbJyJdezAsMX1nZXRteHJyWyciXXswLDF9XClccypcKVxzKntccypAZ2V0bXhyclxzKlwoKlxzKlwkIjtpOjc1O3M6NDE6IlwkcG9zdFJlc3VsdFxzKj1ccypjdXJsX2V4ZWNccypcKCpccypcJGNoIjtpOjc2O3M6MjU6ImZ1bmN0aW9uXHMrc3FsMl9zYWZlXHMqXCgiO2k6Nzc7czo4NToiZXhpdFxzKlwoXHMqWyciXXswLDF9PHNjcmlwdD5ccypzZXRUaW1lb3V0XHMqXChccypcXFsnIl17MCwxfWRvY3VtZW50XC5sb2NhdGlvblwuaHJlZiI7aTo3ODtzOjM4OiJldmFsXChccypzdHJpcHNsYXNoZXNcKFxzKlxcXCRfUkVRVUVTVCI7aTo3OTtzOjM2OiIhdG91Y2hcKFsnIl17MCwxfVwuXC4vXC5cLi9sYW5ndWFnZS8iO2k6ODA7czoxMDoiRGMwUkhhWyciXSI7aTo4MTtzOjYwOiJoZWFkZXJccypcKFsnIl1Mb2NhdGlvbjpccypbJyJdXHMqXC5ccypcJHRvXHMqXC5ccyp1cmxkZWNvZGUiO2k6ODI7czoxNTY6ImlmXHMqXChccypzdHJpcG9zXHMqXChccypcJF9TRVJWRVJcW1snIl17MCwxfUhUVFBfVVNFUl9BR0VOVFsnIl17MCwxfVxdXHMqLFxzKlsnIl17MCwxfUFuZHJvaWRbJyJdezAsMX1cKVxzKiE9PWZhbHNlXHMqJiZccyohXCRfQ09PS0lFXFtbJyJdezAsMX1kbGVfdXNlcl9pZCI7aTo4MztzOjM4OiJlY2hvXHMrQGZpbGVfZ2V0X2NvbnRlbnRzXHMqXChccypcJGdldCI7aTo4NDtzOjQ3OiJkZWZhdWx0X2FjdGlvblxzKj1ccypbJyJdezAsMX1GaWxlc01hblsnIl17MCwxfSI7aTo4NTtzOjMzOiJkZWZpbmVccypcKFxzKlsnIl1ERUZDQUxMQkFDS01BSUwiO2k6ODY7czoxNzoiTXlzdGVyaW91c1xzK1dpcmUiO2k6ODc7czozNDoicHJlZ19yZXBsYWNlXHMqXCgqXHMqWyciXS9cLlwrL2VzaSI7aTo4ODtzOjQ1OiJkZWZpbmVccypcKCpccypbJyJdU0JDSURfUkVRVUVTVF9GSUxFWyciXVxzKiwiO2k6ODk7czo2MDoiXCR0bGRccyo9XHMqYXJyYXlccypcKFxzKlsnIl1jb21bJyJdLFsnIl1vcmdbJyJdLFsnIl1uZXRbJyJdIjtpOjkwO3M6MTc6IkJyYXppbFxzK0hhY2tUZWFtIjtpOjkxO3M6MTQ1OiJpZlwoIWVtcHR5XChcJF9GSUxFU1xbWyciXXswLDF9bWVzc2FnZVsnIl17MCwxfVxdXFtbJyJdezAsMX1uYW1lWyciXXswLDF9XF1cKVxzK0FORFxzK1wobWQ1XChcJF9QT1NUXFtbJyJdezAsMX1uaWNrWyciXXswLDF9XF1cKVxzKj09XHMqWyciXXswLDF9IjtpOjkyO3M6NzU6InRpbWVcKFwpXHMqXCtccyoxMDAwMFxzKixccypbJyJdL1snIl1cKTtccyplY2hvXHMrXCRtX3p6O1xzKmV2YWxccypcKFwkbV96eiI7aTo5MztzOjEwNjoicmV0dXJuXHMqXChccypzdHJzdHJccypcKFxzKlwkc1xzKixccyonZWNobydccypcKVxzKj09XHMqZmFsc2VccypcP1xzKlwoXHMqc3Ryc3RyXHMqXChccypcJHNccyosXHMqJ3ByaW50JyI7aTo5NDtzOjY3OiJzZXRfdGltZV9saW1pdFxzKlwoXHMqMFxzKlwpO1xzKmlmXHMqXCghU2VjcmV0UGFnZUhhbmRsZXI6OmNoZWNrS2V5IjtpOjk1O3M6NzM6IkBoZWFkZXJcKFsnIl1Mb2NhdGlvbjpccypbJyJdXC5bJyJdaFsnIl1cLlsnIl10WyciXVwuWyciXXRbJyJdXC5bJyJdcFsnIl0iO2k6OTY7czo5OiJJclNlY1RlYW0iO2k6OTc7czo5NzoiXCRyQnVmZkxlblxzKj1ccypvcmRccypcKFxzKlZDX0RlY3J5cHRccypcKFxzKmZyZWFkXHMqXChccypcJGlucHV0LFxzKjFccypcKVxzKlwpXHMqXClccypcKlxzKjI1NiI7aTo5ODtzOjc0OiJjbGVhcnN0YXRjYWNoZVwoXHMqXCk7XHMqaWZccypcKFxzKiFpc19kaXJccypcKFxzKlwkZmxkXHMqXClccypcKVxzKnJldHVybiI7aTo5OTtzOjk3OiJjb250ZW50PVsnIl17MCwxfW5vLWNhY2hlWyciXXswLDF9O1xzKlwkY29uZmlnXFtbJyJdezAsMX1kZXNjcmlwdGlvblsnIl17MCwxfVxdXHMqXC49XHMqWyciXXswLDF9IjtpOjEwMDtzOjEyOiJ0bWhhcGJ6Y2VyZmYiO2k6MTAxO3M6NzA6ImZpbGVfZ2V0X2NvbnRlbnRzXHMqXCgqXHMqQURNSU5fUkVESVJfVVJMXHMqLFxzKmZhbHNlXHMqLFxzKlwkY3R4XHMqXCkiO2k6MTAyO3M6ODc6ImlmXHMqXChccypcJGlccyo8XHMqXChccypjb3VudFxzKlwoXHMqXCRfUE9TVFxbXHMqWyciXXswLDF9cVsnIl17MCwxfVxzKlxdXHMqXClccyotXHMqMSI7aToxMDM7czoyMzI6Imlzc2V0XHMqXChccypcJF9GSUxFU1xbXHMqWyciXXswLDF9eFsnIl17MCwxfVxzKlxdXHMqXClccypcP1xzKlwoXHMqaXNfdXBsb2FkZWRfZmlsZVxzKlwoXHMqXCRfRklMRVNcW1xzKlsnIl17MCwxfXhbJyJdezAsMX1ccypcXVxbXHMqWyciXXswLDF9dG1wX25hbWVbJyJdezAsMX1ccypcXVxzKlwpXHMqXD9ccypcKFxzKmNvcHlccypcKFxzKlwkX0ZJTEVTXFtccypbJyJdezAsMX14WyciXXswLDF9XHMqXF0iO2k6MTA0O3M6ODI6IlwkVVJMXHMqPVxzKlwkdXJsc1xbXHMqcmFuZFwoXHMqMFxzKixccypjb3VudFxzKlwoXHMqXCR1cmxzXHMqXClccyotXHMqMVxzKlwpXHMqXF0iO2k6MTA1O3M6MjEzOiJAKm1vdmVfdXBsb2FkZWRfZmlsZVxzKlwoXHMqXCRfRklMRVNcW1xzKlsnIl17MCwxfW1lc3NhZ2VbJyJdezAsMX1ccypcXVxbXHMqWyciXXswLDF9dG1wX25hbWVbJyJdezAsMX1ccypcXVxzKixccypcJHNlY3VyaXR5X2NvZGVccypcLlxzKiIvIlxzKlwuXHMqXCRfRklMRVNcW1snIl17MCwxfW1lc3NhZ2VbJyJdezAsMX1cXVxbWyciXXswLDF9bmFtZVsnIl17MCwxfVxdXCkiO2k6MTA2O3M6Mzk6ImV2YWxccypcKCpccypzdHJyZXZccypcKCpccypzdHJfcmVwbGFjZSI7aToxMDc7czo4MToiXCRyZXM9bXlzcWxfcXVlcnlcKFsnIl17MCwxfVNFTEVDVFxzK1wqXHMrRlJPTVxzK2B3YXRjaGRvZ19vbGRfMDVgXHMrV0hFUkVccytwYWdlIjtpOjEwODtzOjcyOiJcXmRvd25sb2Fkcy9cKFxbMC05XF1cKlwpL1woXFswLTlcXVwqXCkvXCRccytkb3dubG9hZHNcLnBocFw/Yz1cJDEmcD1cJDIiO2k6MTA5O3M6OTI6InByZWdfcmVwbGFjZVxzKlwoXHMqXCRleGlmXFtccypcXFsnIl1NYWtlXFxbJyJdXHMqXF1ccyosXHMqXCRleGlmXFtccypcXFsnIl1Nb2RlbFxcWyciXVxzKlxdIjtpOjExMDtzOjM4OiJmY2xvc2VcKFwkZlwpO1xzKmVjaG9ccypbJyJdb1wua1wuWyciXSI7aToxMTE7czo0MToiZnVuY3Rpb25ccytpbmplY3RcKFwkZmlsZSxccypcJGluamVjdGlvbj0iO2k6MTEyO3M6NzE6ImV4ZWNsXChbJyJdL2Jpbi9zaFsnIl1ccyosXHMqWyciXS9iaW4vc2hbJyJdXHMqLFxzKlsnIl0taVsnIl1ccyosXHMqMFwpIjtpOjExMztzOjQzOiJmaW5kXHMrL1xzKy10eXBlXHMrZlxzKy1wZXJtXHMrLTA0MDAwXHMrLWxzIjtpOjExNDtzOjQ0OiJpZlxzKlwoXHMqZnVuY3Rpb25fZXhpc3RzXHMqXChccyoncGNudGxfZm9yayI7aToxMTU7czo2NToidXJsZW5jb2RlXChwcmludF9yXChhcnJheVwoXCksMVwpXCksNSwxXClcLmNcKSxcJGNcKTt9ZXZhbFwoXCRkXCkiO2k6MTE2O3M6ODk6ImFycmF5X2tleV9leGlzdHNccypcKFxzKlwkZmlsZVJhc1xzKixccypcJGZpbGVUeXBlXClccypcP1xzKlwkZmlsZVR5cGVcW1xzKlwkZmlsZVJhc1xzKlxdIjtpOjExNztzOjk5OiJpZlxzKlwoXHMqZndyaXRlXHMqXChccypcJGhhbmRsZVxzKixccypmaWxlX2dldF9jb250ZW50c1xzKlwoXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVCkiO2k6MTE4O3M6MTc4OiJpZlxzKlwoXHMqXCRfUE9TVFxbXHMqWyciXXswLDF9cGF0aFsnIl17MCwxfVxzKlxdXHMqPT1ccypbJyJdezAsMX1bJyJdezAsMX1ccypcKVxzKntccypcJHVwbG9hZGZpbGVccyo9XHMqXCRfRklMRVNcW1xzKlsnIl17MCwxfWZpbGVbJyJdezAsMX1ccypcXVxbXHMqWyciXXswLDF9bmFtZVsnIl17MCwxfVxzKlxdIjtpOjExOTtzOjgzOiJpZlxzKlwoXHMqXCRkYXRhU2l6ZVxzKjxccypCT1RDUllQVF9NQVhfU0laRVxzKlwpXHMqcmM0XHMqXChccypcJGRhdGEsXHMqXCRjcnlwdGtleSI7aToxMjA7czo5MDoiLFxzKmFycmF5XHMqXCgnXC4nLCdcLlwuJywnVGh1bWJzXC5kYidcKVxzKlwpXHMqXClccyp7XHMqY29udGludWU7XHMqfVxzKmlmXHMqXChccyppc19maWxlIjtpOjEyMTtzOjUxOiJcKVxzKlwuXHMqc3Vic3RyXHMqXChccyptZDVccypcKFxzKnN0cnJldlxzKlwoXHMqXCQiO2k6MTIyO3M6Mjg6ImFzc2VydFxzKlwoXHMqQCpzdHJpcHNsYXNoZXMiO2k6MTIzO3M6MTU6IlsnIl1lL1wqXC4vWyciXSI7aToxMjQ7czo1MjoiZWNob1snIl17MCwxfTxjZW50ZXI+PGI+RG9uZVxzKj09PlxzKlwkdXNlcmZpbGVfbmFtZSI7aToxMjU7czoxMzQ6ImlmXHMqXChcJGtleVxzKiE9XHMqWyciXXswLDF9bWFpbF90b1snIl17MCwxfVxzKiYmXHMqXCRrZXlccyohPVxzKlsnIl17MCwxfXNtdHBfc2VydmVyWyciXXswLDF9XHMqJiZccypcJGtleVxzKiE9XHMqWyciXXswLDF9c210cF9wb3J0IjtpOjEyNjtzOjU5OiJzdHJwb3NcKFwkdWEsXHMqWyciXXswLDF9eWFuZGV4Ym90WyciXXswLDF9XClccyohPT1ccypmYWxzZSI7aToxMjc7czo0NToiaWZcKENoZWNrSVBPcGVyYXRvclwoXClccyomJlxzKiFpc01vZGVtXChcKVwpIjtpOjEyODtzOjM0OiJ1cmw9PFw/cGhwXHMqZWNob1xzKlwkcmFuZF91cmw7XD8+IjtpOjEyOTtzOjI3OiJlY2hvXHMqWyciXWFuc3dlcj1lcnJvclsnIl0iO2k6MTMwO3M6MzI6IlwkcG9zdFxzKj1ccypbJyJdXFx4NzdcXHg2N1xceDY1IjtpOjEzMTtzOjQ2OiJpZlxzKlwoZGV0ZWN0X21vYmlsZV9kZXZpY2VcKFwpXClccyp7XHMqaGVhZGVyIjtpOjEzMjtzOjk6IklySXNUXC5JciI7aToxMzM7czo4OToiXCRsZXR0ZXJccyo9XHMqc3RyX3JlcGxhY2VccypcKFxzKlwkQVJSQVlcWzBcXVxbXCRqXF1ccyosXHMqXCRhcnJcW1wkaW5kXF1ccyosXHMqXCRsZXR0ZXIiO2k6MTM0O3M6OTI6ImNyZWF0ZV9mdW5jdGlvblxzKlwoXHMqWyciXVwkbVsnIl1ccyosXHMqWyciXWlmXHMqXChccypcJG1ccypcW1xzKjB4MDFccypcXVxzKj09XHMqWyciXUxbJyJdIjtpOjEzNTtzOjcyOiJcJHBccyo9XHMqc3RycG9zXChcJHR4XHMqLFxzKlsnIl17MCwxfXtcI1snIl17MCwxfVxzKixccypcJHAyXHMqXCtccyoyXCkiO2k6MTM2O3M6MTEyOiJcJHVzZXJfYWdlbnRccyo9XHMqcHJlZ19yZXBsYWNlXHMqXChccypbJyJdXHxVc2VyXFxcLkFnZW50XFw6XFtcXHMgXF1cP1x8aVsnIl1ccyosXHMqWyciXVsnIl1ccyosXHMqXCR1c2VyX2FnZW50IjtpOjEzNztzOjMxOiJwcmludFwoIlwjXHMraW5mb1xzK09LXFxuXFxuIlwpIjtpOjEzODtzOjUxOiJcXVxzKn1ccyo9XHMqdHJpbVxzKlwoXHMqYXJyYXlfcG9wXHMqXChccypcJHtccypcJHsiO2k6MTM5O3M6NjQ6IlxdPVsnIl17MCwxfWlwWyciXXswLDF9XHMqO1xzKmlmXHMqXChccyppc3NldFxzKlwoXHMqXCRfU0VSVkVSXFsiO2k6MTQwO3M6MzQ6InByaW50XHMqXCRzb2NrICJQUklWTVNHICJcLlwkb3duZXIiO2k6MTQxO3M6NjM6ImlmXCgvXF5cXDpcJG93bmVyIVwuXCpcXEBcLlwqUFJJVk1TR1wuXCo6XC5tc2dmbG9vZFwoXC5cKlwpL1wpeyI7aToxNDI7czoyNjoiXFstXF1ccytDb25uZWN0aW9uXHMrZmFpbGQiO2k6MTQzO3M6NTQ6IjwhLS1cI2V4ZWNccytjbWQ9WyciXXswLDF9XCRIVFRQX0FDQ0VQVFsnIl17MCwxfVxzKi0tPiI7aToxNDQ7czoxNjc6IlsnIl17MCwxfUZyb206XHMqWyciXXswLDF9XC5cJF9QT1NUXFtbJyJdezAsMX1yZWFsbmFtZVsnIl17MCwxfVxdXC5bJyJdezAsMX0gWyciXXswLDF9XC5bJyJdezAsMX0gPFsnIl17MCwxfVwuXCRfUE9TVFxbWyciXXswLDF9ZnJvbVsnIl17MCwxfVxdXC5bJyJdezAsMX0+XFxuWyciXXswLDF9IjtpOjE0NTtzOjk5OiJpZlxzKlwoXHMqaXNfZGlyXHMqXChccypcJEZ1bGxQYXRoXHMqXClccypcKVxzKkFsbERpclxzKlwoXHMqXCRGdWxsUGF0aFxzKixccypcJEZpbGVzXHMqXCk7XHMqfVxzKn0iO2k6MTQ2O3M6Nzg6IlwkcFxzKj1ccypzdHJwb3NccypcKFxzKlwkdHhccyosXHMqWyciXXswLDF9e1wjWyciXXswLDF9XHMqLFxzKlwkcDJccypcK1xzKjJcKSI7aToxNDc7czoxMjM6InByZWdfbWF0Y2hfYWxsXChbJyJdezAsMX0vPGEgaHJlZj0iXFwvdXJsXFxcP3E9XChcLlwrXD9cKVxbJlx8IlxdXCsvaXNbJyJdezAsMX0sIFwkcGFnZVxbWyciXXswLDF9ZXhlWyciXXswLDF9XF0sIFwkbGlua3NcKSI7aToxNDg7czo4MDoiXCR1cmxccyo9XHMqXCR1cmxccypcLlxzKlsnIl17MCwxfVw/WyciXXswLDF9XHMqXC5ccypodHRwX2J1aWxkX3F1ZXJ5XChcJHF1ZXJ5XCkiO2k6MTQ5O3M6ODM6InByaW50XHMrXCRzb2NrXHMrWyciXXswLDF9TklDSyBbJyJdezAsMX1ccytcLlxzK1wkbmlja1xzK1wuXHMrWyciXXswLDF9XFxuWyciXXswLDF9IjtpOjE1MDtzOjMyOiJQUklWTVNHXC5cKjpcLm93bmVyXFxzXCtcKFwuXCpcKSI7aToxNTE7czo3NToiXCRyZXN1bHRGVUxccyo9XHMqc3RyaXBjc2xhc2hlc1xzKlwoXHMqXCRfUE9TVFxbWyciXXswLDF9cmVzdWx0RlVMWyciXXswLDF9IjtpOjE1MjtzOjE1MDoiXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl17MCwxfVthLXpBLVowLTlfXStbJyJdezAsMX1cXVwoXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl17MCwxfVthLXpBLVowLTlfXStbJyJdezAsMX1cXVxzKlwpIjtpOjE1MztzOjYwOiJpZlxzKlwoXHMqQCptZDVccypcKFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFsiO2k6MTU0O3M6OTQ6ImVjaG9ccytmaWxlX2dldF9jb250ZW50c1xzKlwoXHMqYmFzZTY0X3VybF9kZWNvZGVccypcKFxzKkAqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVCkiO2k6MTU1O3M6ODQ6ImZ3cml0ZVxzKlwoXHMqXCRmaFxzKixccypzdHJpcHNsYXNoZXNccypcKFxzKkAqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcWyI7aToxNTY7czo4MzoiaWZccypcKFxzKm1haWxccypcKFxzKlwkbWFpbHNcW1wkaVxdXHMqLFxzKlwkdGVtYVxzKixccypiYXNlNjRfZW5jb2RlXHMqXChccypcJHRleHQiO2k6MTU3O3M6NjI6IlwkZ3ppcFxzKj1ccypAKmd6aW5mbGF0ZVxzKlwoXHMqQCpzdWJzdHJccypcKFxzKlwkZ3plbmNvZGVfYXJnIjtpOjE1ODtzOjczOiJtb3ZlX3VwbG9hZGVkX2ZpbGVcKFwkX0ZJTEVTXFtbJyJdezAsMX1lbGlmWyciXXswLDF9XF1cW1snIl17MCwxfXRtcF9uYW1lIjtpOjE1OTtzOjgwOiJoZWFkZXJcKFsnIl17MCwxfXM6XHMqWyciXXswLDF9XHMqXC5ccypwaHBfdW5hbWVccypcKFxzKlsnIl17MCwxfW5bJyJdezAsMX1ccypcKSI7aToxNjA7czoxMjoiQnlccytXZWJSb29UIjtpOjE2MTtzOjU3OiJcJE9PTzBPME8wMD1fX0ZJTEVfXztccypcJE9PMDBPMDAwMFxzKj1ccyoweDFiNTQwO1xzKmV2YWwiO2k6MTYyO3M6NTI6IlwkbWFpbGVyXHMqPVxzKlwkX1BPU1RcW1snIl17MCwxfXhfbWFpbGVyWyciXXswLDF9XF0iO2k6MTYzO3M6Nzc6InByZWdfbWF0Y2hcKFsnIl0vXCh5YW5kZXhcfGdvb2dsZVx8Ym90XCkvaVsnIl0sXHMqZ2V0ZW52XChbJyJdSFRUUF9VU0VSX0FHRU5UIjtpOjE2NDtzOjQ3OiJlY2hvXHMrXCRpZnVwbG9hZD1bJyJdezAsMX1ccypJdHNPa1xzKlsnIl17MCwxfSI7aToxNjU7czo0MjoiZnNvY2tvcGVuXHMqXChccypcJENvbm5lY3RBZGRyZXNzXHMqLFxzKjI1IjtpOjE2NjtzOjY0OiJcJF9TRVNTSU9OXFtbJyJdezAsMX1zZXNzaW9uX3BpblsnIl17MCwxfVxdXHMqPVxzKlsnIl17MCwxfVwkUElOIjtpOjE2NztzOjYzOiJcJHVybFsnIl17MCwxfVxzKlwuXHMqXCRzZXNzaW9uX2lkXHMqXC5ccypbJyJdezAsMX0vbG9naW5cLmh0bWwiO2k6MTY4O3M6NDQ6ImZccyo9XHMqXCRxXHMqXC5ccypcJGFccypcLlxzKlwkYlxzKlwuXHMqXCR4IjtpOjE2OTtzOjU1OiJpZlxzKlwobWQ1XCh0cmltXChcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbIjtpOjE3MDtzOjMzOiJkaWVccypcKFxzKlBIUF9PU1xzKlwuXHMqY2hyXHMqXCgiO2k6MTcxO3M6MTkyOiJjcmVhdGVfZnVuY3Rpb25ccypcKFsnIl1bJyJdXHMqLFxzKlxiKGV2YWx8YmFzZTY0X2RlY29kZXxzdHJyZXZ8cHJlZ19yZXBsYWNlfHByZWdfcmVwbGFjZV9jYWxsYmFja3x1cmxkZWNvZGV8c3Ryc3RyfGd6aW5mbGF0ZXxzcHJpbnRmfGd6dW5jb21wcmVzc3xhc3NlcnR8c3RyX3JvdDEzfG1kNXxhcnJheV93YWxrfGFycmF5X2ZpbHRlcikiO2k6MTcyO3M6ODA6IlwkaGVhZGVyc1xzKj1ccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXXswLDF9aGVhZGVyc1snIl17MCwxfVxdIjtpOjE3MztzOjg2OiJmaWxlX3B1dF9jb250ZW50c1xzKlwoWyciXXswLDF9MVwudHh0WyciXXswLDF9XHMqLFxzKnByaW50X3JccypcKFxzKlwkX1BPU1RccyosXHMqdHJ1ZSI7aToxNzQ7czozNToiZndyaXRlXHMqXChccypcJGZsd1xzKixccypcJGZsXHMqXCkiO2k6MTc1O3M6Mzg6Ilwkc3lzX3BhcmFtc1xzKj1ccypAKmZpbGVfZ2V0X2NvbnRlbnRzIjtpOjE3NjtzOjUxOiJcJGFsbGVtYWlsc1xzKj1ccypAc3BsaXRcKCJcXG4iXHMqLFxzKlwkZW1haWxsaXN0XCkiO2k6MTc3O3M6NTA6ImZpbGVfcHV0X2NvbnRlbnRzXChTVkNfU0VMRlxzKlwuXHMqWyciXS9cLmh0YWNjZXNzIjtpOjE3ODtzOjU3OiJjcmVhdGVfZnVuY3Rpb25cKFsnIl1bJyJdLFxzKlwkb3B0XFsxXF1ccypcLlxzKlwkb3B0XFs0XF0iO2k6MTc5O3M6OTU6IjxzY3JpcHRccyt0eXBlPVsnIl17MCwxfXRleHQvamF2YXNjcmlwdFsnIl17MCwxfVxzK3NyYz1bJyJdezAsMX1qcXVlcnktdVwuanNbJyJdezAsMX0+PC9zY3JpcHQ+IjtpOjE4MDtzOjI4OiJVUkw9PFw/ZWNob1xzK1wkaW5kZXg7XHMrXD8+IjtpOjE4MTtzOjIzOiJcI1xzKnNlY3VyaXR5c3BhY2VcLmNvbSI7aToxODI7czoxODoiXCNccypzdGVhbHRoXHMqYm90IjtpOjE4MztzOjIxOiJBcHBsZVxzK1NwQW1ccytSZVp1bFQiO2k6MTg0O3M6NTI6ImlzX3dyaXRhYmxlXChcJGRpclwuWyciXXdwLWluY2x1ZGVzL3ZlcnNpb25cLnBocFsnIl0iO2k6MTg1O3M6NDI6ImlmXChlbXB0eVwoXCRfQ09PS0lFXFtbJyJdeFsnIl1cXVwpXCl7ZWNobyI7aToxODY7czoyOToiXClcXTt9aWZcKGlzc2V0XChcJF9TRVJWRVJcW18iO2k6MTg3O3M6NjY6ImlmXChAXCR2YXJzXChnZXRfbWFnaWNfcXVvdGVzX2dwY1woXClccypcP1xzKnN0cmlwc2xhc2hlc1woXCR1cmlcKSI7aToxODg7czozMzoiYmFzZVsnIl17MCwxfVwuXChcZCtccypcKlxzKlxkK1wpIjtpOjE4OTtzOjc1OiJcJHBhcmFtXHMqPVxzKlwkcGFyYW1ccyp4XHMqXCRuXC5zdWJzdHJccypcKFwkcGFyYW1ccyosXHMqbGVuZ3RoXChcJHBhcmFtXCkiO2k6MTkwO3M6NTM6InJlZ2lzdGVyX3NodXRkb3duX2Z1bmN0aW9uXChccypbJyJdezAsMX1yZWFkX2Fuc19jb2RlIjtpOjE5MTtzOjM1OiJiYXNlNjRfZGVjb2RlXChcJF9QT1NUXFtbJyJdezAsMX1fLSI7aToxOTI7czo1NDoiaWZcKGlzc2V0XChcJF9QT1NUXFtbJyJdezAsMX1tc2dzdWJqZWN0WyciXXswLDF9XF1cKVwpIjtpOjE5MztzOjEzMzoibWFpbFwoXCRhcnJcW1snIl17MCwxfXRvWyciXXswLDF9XF0sXCRhcnJcW1snIl17MCwxfXN1YmpbJyJdezAsMX1cXSxcJGFyclxbWyciXXswLDF9bXNnWyciXXswLDF9XF0sXCRhcnJcW1snIl17MCwxfWhlYWRbJyJdezAsMX1cXVwpOyI7aToxOTQ7czozODoiZmlsZV9nZXRfY29udGVudHNcKHRyaW1cKFwkZlxbXCRfR0VUXFsiO2k6MTk1O3M6NjA6ImluaV9nZXRcKFsnIl17MCwxfWZpbHRlclwuZGVmYXVsdF9mbGFnc1snIl17MCwxfVwpXCl7Zm9yZWFjaCI7aToxOTY7czo1MDoiY2h1bmtfc3BsaXRcKGJhc2U2NF9lbmNvZGVcKGZyZWFkXChcJHtcJHtbJyJdezAsMX0iO2k6MTk3O3M6NTI6Ilwkc3RyPVsnIl17MCwxfTxoMT40MDNccytGb3JiaWRkZW48L2gxPjwhLS1ccyp0b2tlbjoiO2k6MTk4O3M6MzM6IjxcP3BocFxzK3JlbmFtZVwoWyciXXdzb1wucGhwWyciXSI7aToxOTk7czo2NDoiXCRbYS16QS1aMC05X10rL1wqLnsxLDEwfVwqL1xzKlwuXHMqXCRbYS16QS1aMC05X10rL1wqLnsxLDEwfVwqLyI7aToyMDA7czo1MToiQCptYWlsXChcJG1vc0NvbmZpZ19tYWlsZnJvbSwgXCRtb3NDb25maWdfbGl2ZV9zaXRlIjtpOjIwMTtzOjk1OiJcJHQ9XCRzO1xzKlwkb1xzKj1ccypbJyJdWyciXTtccypmb3JcKFwkaT0wO1wkaTxzdHJsZW5cKFwkdFwpO1wkaVwrXCtcKXtccypcJG9ccypcLj1ccypcJHR7XCRpfSI7aToyMDI7czo0NzoibW1jcnlwdFwoXCRkYXRhLCBcJGtleSwgXCRpdiwgXCRkZWNyeXB0ID0gRkFMU0UiO2k6MjAzO3M6MTU6InRuZWdhX3Jlc3VfcHR0aCI7aToyMDQ7czo5OiJ0c29oX3B0dGgiO2k6MjA1O3M6MTI6IlJFUkVGRVJfUFRUSCI7aToyMDY7czozMToid2ViaVwucnUvd2ViaV9maWxlcy9waHBfbGlibWFpbCI7aToyMDc7czo0MDoic3Vic3RyX2NvdW50XChnZXRlbnZcKFxcWyciXUhUVFBfUkVGRVJFUiI7aToyMDg7czozNzoiZnVuY3Rpb24gcmVsb2FkXChcKXtoZWFkZXJcKCJMb2NhdGlvbiI7aToyMDk7czoyNToiaW1nIHNyYz1bJyJdb3BlcmEwMDBcLnBuZyI7aToyMTA7czo0NjoiZWNob1xzKm1kNVwoXCRfUE9TVFxbWyciXXswLDF9Y2hlY2tbJyJdezAsMX1cXSI7aToyMTE7czozMzoiZVZhTFwoXHMqdHJpbVwoXHMqYmFTZTY0X2RlQ29EZVwoIjtpOjIxMjtzOjQyOiJmc29ja29wZW5cKFwkbVxbMFxdLFwkbVxbMTBcXSxcJF8sXCRfXyxcJG0iO2k6MjEzO3M6MTk6IlsnIl09Plwke1wke1snIl1cXHgiO2k6MjE0O3M6Mzg6InByZWdfcmVwbGFjZVwoWyciXS5VVEZcXC04OlwoLlwqXCkuVXNlIjtpOjIxNTtzOjMwOiI6OlsnIl1cLnBocHZlcnNpb25cKFwpXC5bJyJdOjoiO2k6MjE2O3M6NDA6IkBzdHJlYW1fc29ja2V0X2NsaWVudFwoWyciXXswLDF9dGNwOi8vXCQiO2k6MjE3O3M6MTg6Ij09MFwpe2pzb25RdWl0XChcJCI7aToyMTg7czo0NjoibG9jXHMqPVxzKlsnIl17MCwxfTxcP2VjaG9ccytcJHJlZGlyZWN0O1xzKlw/PiI7aToyMTk7czoyODoiYXJyYXlcKFwkZW4sXCRlcyxcJGVmLFwkZWxcKSI7aToyMjA7czozNzoiWyciXXswLDF9LmMuWyciXXswLDF9XC5zdWJzdHJcKFwkdmJnLCI7aToyMjE7czoxODoiZnVja1xzK3lvdXJccyttYW1hIjtpOjIyMjtzOjc4OiJjYWxsX3VzZXJfZnVuY1woXHMqWyciXWFjdGlvblsnIl1ccypcLlxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFsiO2k6MjIzO3M6NTk6InN0cl9yZXBsYWNlXChcJGZpbmRccyosXHMqXCRmaW5kXHMqXC5ccypcJGh0bWxccyosXHMqXCR0ZXh0IjtpOjIyNDtzOjMzOiJmaWxlX2V4aXN0c1xzKlwoKlxzKlsnIl0vdmFyL3RtcC8iO2k6MjI1O3M6NDE6IiYmXHMqIWVtcHR5XChccypcJF9DT09LSUVcW1snIl1maWxsWyciXVxdIjtpOjIyNjtzOjIxOiJmdW5jdGlvblxzK2luRGlhcGFzb24iO2k6MjI3O3M6MzU6Im1ha2VfZGlyX2FuZF9maWxlXChccypcJHBhdGhfam9vbWxhIjtpOjIyODtzOjQxOiJsaXN0aW5nX3BhZ2VcKFxzKm5vdGljZVwoXHMqWyciXXN5bWxpbmtlZCI7aToyMjk7czo2MjoibGlzdFxzKlwoXHMqXCRob3N0XHMqLFxzKlwkcG9ydFxzKixccypcJHNpemVccyosXHMqXCRleGVjX3RpbWUiO2k6MjMwO3M6NTI6ImZpbGVtdGltZVwoXCRiYXNlcGF0aFxzKlwuXHMqWyciXS9jb25maWd1cmF0aW9uXC5waHAiO2k6MjMxO3M6NTg6ImZ1bmN0aW9uXHMrcmVhZF9waWNcKFxzKlwkQVxzKlwpXHMqe1xzKlwkYVxzKj1ccypcJF9TRVJWRVIiO2k6MjMyO3M6NjQ6ImNoclwoXHMqXCR0YWJsZVxbXHMqXCRzdHJpbmdcW1xzKlwkaVxzKlxdXHMqXCpccypwb3dcKDY0XHMqLFxzKjEiO2k6MjMzO3M6Mzk6IlxdXHMqXCl7ZXZhbFwoXHMqXCRbYS16QS1aMC05X10rXFtccypcJCI7aToyMzQ7czo1NDoiTG9jYXRpb246OmlzRmlsZVdyaXRhYmxlXChccypFbmNvZGVFeHBsb3Jlcjo6Z2V0Q29uZmlnIjtpOjIzNTtzOjEzOiJieVxzK1NodW5jZW5nIjtpOjIzNjtzOjE0OiJ7ZXZhbFwoXCR7XCRzMiI7aToyMzc7czoxODoiZXZhbFwoXCRzMjFcKFwke1wkIjtpOjIzODtzOjIxOiJSYW1aa2lFXHMrLVxzK2V4cGxvaXQiO2k6MjM5O3M6NDc6IlsnIl1yZW1vdmVfc2NyaXB0c1snIl1ccyo9PlxzKmFycmF5XChbJyJdUmVtb3ZlIjtpOjI0MDtzOjI4OiJcJGJhY2tfY29ubmVjdF9wbFxzKj1ccypbJyJdIjtpOjI0MTtzOjQwOiJcJHNpdGVfcm9vdFwuXCRmaWxldW5wX2RpclwuXCRmaWxldW5wX2ZuIjtpOjI0MjtzOjI0OiJAcHJlZ19yZXBsYWNlXChbJyJdL2FkL2UiO2k6MjQzO3M6MjY6IjxiPlwkdWlkXHMqXChcJHVuYW1lXCk8L2I+IjtpOjI0NDtzOjExOiJGeDI5R29vZ2xlciI7aToyNDU7czo4OiJlbnZpcjBubiI7aToyNDY7czo0NjoiYXJyYXlcKFsnIl1cKi9bJyJdLFsnIl0vXCpbJyJdXCksYmFzZTY0X2RlY29kZSI7aToyNDc7czoyODoiPFw/PVxzKkBwaHBfdW5hbWVcKFwpO1xzKlw/PiI7aToyNDg7czoxMToic1V4Q3Jld1xzK1YiO2k6MjQ5O3M6MTY6IldhckJvdFxzK3NVeENyZXciO2k6MjUwO3M6NDM6ImV4ZWNcKFsnIl1jZFxzKy90bXA7Y3VybFxzKy1PXHMrWyciXVwuXCR1cmwiO2k6MjUxO3M6MTU6IkJhdGF2aTRccytTaGVsbCI7aToyNTI7czozNjoiQGV4dHJhY3RcKFwkX1JFUVVFU1RcW1snIl1meDI5c2hjb29rIjtpOjI1MztzOjEwOiJUdVhfU2hhZG93IjtpOjI1NDtzOjQwOiI9QGZvcGVuXHMqXChbJyJdcGhwXC5pbmlbJyJdXHMqLFxzKlsnIl13IjtpOjI1NTtzOjk6IkxlYmF5Q3JldyI7aToyNTY7czo3OToiXCRoZWFkZXJzXHMqXC49XHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1xzKlsnIl1lTWFpbEFkZFsnIl1ccypcXSI7aToyNTc7czoxOToiYm9nZWxccyotXHMqZXhwbG9pdCI7aToyNTg7czo1OToiXFt1bmFtZVxdWyciXVxzKlwuXHMqcGhwX3VuYW1lXChccypcKVxzKlwuXHMqWyciXVxbL3VuYW1lXF0iO2k6MjU5O3M6MzI6IlxdXChcJF8xLFwkXzFcKVwpO2Vsc2V7XCRHTE9CQUxTIjtpOjI2MDtzOjE0OiJmaWxlOmZpbGU6Ly8vLyI7aToyNjE7czozMjoiZnVuY3Rpb25ccytNQ0xvZ2luXChcKVxzKntccypkaWUiO2k6MjYyO3M6NTU6IntlY2hvIFsnIl15ZXNbJyJdOyBleGl0O31lbHNle2VjaG8gWyciXW5vWyciXTsgZXhpdDt9fX0iO2k6MjYzO3M6Mzk6IjtcPz48XD89XCR7WyciXV9bJyJdXC5cJF99XFtbJyJdX1snIl1cXSI7aToyNjQ7czo0MToiXCRhXFsxXF09PVsnIl1ieXBhc3NpcFsnIl1cKTtcJGM9c2VsZjo6YzEiO2k6MjY1O3M6NDI6IlwkZGlyXC5bJyJdL1snIl1cLlwkZlwuWyciXS93cC1jb25maWdcLnBocCI7aToyNjY7czoyMzoiZXZhbFwoWyciXXJldHVyblxzK2V2YWwiO2k6MjY3O3M6OTA6ImZ3cml0ZVwoXCRbYS16QS1aMC05X10rLCJcXHhFRlxceEJCXFx4QkYiXC5pY29udlwoWyciXWdia1snIl0sWyciXXV0Zi04Ly9JR05PUkVbJyJdLFwkYm9keSI7aToyNjg7czo3MjoiZWNob1xzK1snIl1fX3N1Y2Nlc3NfX1snIl1ccypcLlxzKlwkTm93U3ViRm9sZGVyc1xzKlwuXHMqWyciXV9fc3VjY2Vzc19fIjtpOjI2OTtzOjc3OiJvYl9zdGFydFwoXCk7XHMqdmFyX2R1bXBcKFwkX1BPU1RccyosXHMqXCRfR0VUXHMqLFxzKlwkX0NPT0tJRVxzKixccypcJF9GSUxFUyI7aToyNzA7czozNDoiZ2V0ZW52XCgiSFRUUF9IT1NUIlwpXC4nIH4gU2hlbGwgSSI7aToyNzE7czo0MzoiZXZhbC9cKlwqL1woImV2YWxcKGd6aW5mbGF0ZVwoYmFzZTY0X2RlY29kZSI7aToyNzI7czoyNToiYXNzZXJ0XChcJFthLXpBLVowLTlfXStcKCI7aToyNzM7czoxODoiXCRkZWZhY2VyPSdSZVpLMkxMIjtpOjI3NDtzOjE5OiI8JVxzKmV2YWxccytyZXF1ZXN0IjtpOjI3NTtzOjMxOiJuZXdfdGltZVwoXCRwYXRoMmZpbGUsXCRHTE9CQUxTIjtpOjI3NjtzOjUzOiJcJHN0cj1zdHJfcmVwbGFjZVwoIlxbdFxkK1xdIlxzKixccyoiPFw/IixccypcJHJlc1wpOyI7aToyNzc7czo5NjoiXCRfX2E9IlthLXpBLVowLTlfXSsiO1xzKlwkX19hXHMqPVxzKnN0cl9yZXBsYWNlXCgiW2EtekEtWjAtOV9dKyIsXHMqIlthLXpBLVowLTlfXSsiLFxzKlwkX19hXCk7IjtpOjI3ODtzOjQ0OiI8IS0tXHd7MzJ9LS0+PFw/cGhwXHMqQG9iX3N0YXJ0XChcKTtAaW5pX3NldCI7aToyNzk7czo0MjoiaWZcKGlzc2V0XChcJF9HRVRcW3BocFxdXClcKVxzKntcJGZ1bmN0aW9uIjtpOjI4MDtzOjI4OiJcJHNcKCJ+XFtkaXNjdXpcXX5lIixcJF9QT1NUIjtpOjI4MTtzOjQxOiJQbGdTeXN0ZW1YY2FsZW5kYXJIZWxwZXI6OmdldEluc3RhbmNlXChcKSI7aToyODI7czo2MjoiaXNfZGlyX2VtcHR5XChcJF9QT1NUXFtbJyJdZGlyZWN0b3J5WyciXVxdXClcKVxzKntccyplY2hvXHMrMTsiO2k6MjgzO3M6MzI6ImlmXChpc3NldFwoXCRfUE9TVFxbWyciXV9fYnNjb2RlIjtpOjI4NDtzOjM1OiJiYXNlNjRfZW5jb2RlXChjbGVhbl91cmxcKFwkX1NFUlZFUiI7aToyODU7czozMDoiXCRfR0VUXFtbJyJdbW9kWyciXVxdPT1bJyJdMFhYIjtpOjI4NjtzOjQ0OiJcJGZvbGRlclwuWyciXS9wbGVhc2VfcmVuYW1lX1VOWklQRklSU1RcLnppcCI7aToyODc7czo0MzoiQFwkc3RyaW5nc1woc3RyX3JvdDEzXCgncmlueVwob25mcjY0X3FycGJxciI7aToyODg7czo2NzoiXCR0aGlzLT5zZXJ2ZXJccyo9XHMqWyciXWh0dHA6Ly9bJyJdXC5cJHRoaXMtPnNlcnZlclwuWyciXS9pbWcvXD9xPSI7aToyODk7czo0NzoiZWNob1xzKiI8Y2VudGVyPjxiPkRvbmVccyo9PT5ccypcJHVzZXJmaWxlX25hbWUiO2k6MjkwO3M6OTQ6ImZpbGVfZ2V0X2NvbnRlbnRzXChcJFthLXpBLVowLTlfXStcKTtccypbYS16QS1aMC05X10rXChbJyJdaHR0cHM6Ly9kbFwuZHJvcGJveHVzZXJjb250ZW50XC5jb20iO2k6MjkxO3M6NjA6ImlmXChmaWxlX2V4aXN0c1woXCRuZXdQYXRoXClcKVxzKntccyplY2hvXHMqInB1Ymxpc2ggc3VjY2VzcyI7aToyOTI7czo1MzoiZnVuY3Rpb25ccytLaWxsTWVcKFwpXHMqe1xzKnVubGlua1woXHMqTXlGaWxlTmFtZVwoXCkiO2k6MjkzO3M6NjE6IjxcP3BocFxzKmVycm9yX3JlcG9ydGluZ1woRV9FUlJPUlwpO1xzKlwkcmVtb3RlX3BhdGg9Imh0dHA6Ly8iO2k6Mjk0O3M6NDQ6ImVjaG9ccytwaHBfdW5hbWVcKFwpO1xzKkB1bmxpbmtcKF9fRklMRV9fXCk7IjtpOjI5NTtzOjUxOiI8dGl0bGU+PFw/cGhwXHMrZWNob1xzK1wkc2hlbGxfdGl0bGU7XHMrXD8+PC90aXRsZT4iO2k6Mjk2O3M6NTY6ImNoclwob3JkXChcJHN0clxbXCRpXF1cKVxzKlxeXHMqXCRrZXlcKTtccypldmFsXChcJGV2XCk7IjtpOjI5NztzOjMwOiJcJHdwX193cD1cJHdwX193cFwoc3RyX3JlcGxhY2UiO2k6Mjk4O3M6MTg6IjxcP3BocFxzKlwkd3BfX3dwPSI7aToyOTk7czoyNDoiPFw/cGhwXHMqZXZhbFwoWyciXVxceDY1IjtpOjMwMDtzOjc3OiJAcHJlZ19yZXBsYWNlXChbJyJdL1woXC5cKlwpL2VbJyJdXHMqLFxzKkBcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKSI7aTozMDE7czoyMjoiPHRpdGxlPlczTGNvbWU8L3RpdGxlPiI7aTozMDI7czo3NToiaWZcKHN0cmlzdHJcKFwkZmlsZXNcW1wkaVxdLFxzKlsnIl1waHBbJyJdXClcKVxzKntccypcJHRpbWVccyo9XHMqZmlsZW10aW1lIjtpOjMwMztzOjc0OiJcKVwpe1xzKmluY2x1ZGVcKGdldGN3ZFwoXClcLlsnIl0vW2EtekEtWjAtOV9dK1wucGhwWyciXVwpO1xzKmV4aXQ7fVxzKlw/PiI7aTozMDQ7czoyOToiPHRpdGxlPlsnIl1cLnVjZmlyc3RcKFwka2V5XCkiO2k6MzA1O3M6MTg6IjxcP3BocFxzKi9cKlxzKldTTyI7aTozMDY7czozMDoiZnVuY3Rpb25fZXhpc3RzXCgiYzk5X3Nlc3NfcHV0IjtpOjMwNztzOjIxOiIzeHAxcjNccypDeWJlclxzKkFybXkiO2k6MzA4O3M6Mzg6ImZpbGVfZ2V0X2NvbnRlbnRzXCh+XHMqYmFzZTY0X2RlY29kZVwoIjtpOjMwOTtzOjQ3OiJoZXhkZWNcKHN1YnN0clwobWQ1XChcJF9TRVJWRVJcW1snIl1SRVFVRVNUX1VSSSI7aTozMTA7czo4Njoicm9vdF9wYXRoPXN1YnN0clwoXCRhYnNvbHV0ZXBhdGgsMCxzdHJwb3NcKFwkYWJzb2x1dGVwYXRoLFwkbG9jYWxwYXRoXClcKTtpbmNsdWRlX29uY2UiO2k6MzExO3M6NTU6IlwkX1NFUlZFUlxbIlJFTU9URV9BRERSIlxdO2lmXChcKHByZWdfbWF0Y2hcKCIvNjlcLjQyXC4iO2k6MzEyO3M6NDE6IjxcP3BocFxzKmlmXChpc3NldFwoXCRfR0VUXFtwaHBcXVwpXClccyp7IjtpOjMxMztzOjU5OiJcKVwpe2lmXChpc3NldFwoXCRfRklMRVNcW1snIl1pbVsnIl1cXVwpXCl7XCRkaW09Z2V0Y3dkXChcKSI7aTozMTQ7czozMzoiY2xhc3NccytKU1lTT1BFUkFUSU9OX1NldFBhc3N3b3JkIjtpOjMxNTtzOjQ3OiJcKTthcnJheV9maWx0ZXJcKFwkbWNkYXRhXHMqLFxzKmJhc2U2NF9kZWNvZGVcKCI7aTozMTY7czo1OToiPFw/cGhwIGlmXChcJG1lc3NhZ2VcKSBlY2hvICI8cD5cJG1lc3NhZ2U8L3A+IjsgXD8+XHMqPGZvcm0iO2k6MzE3O3M6ODM6InRvdWNoXChkaXJuYW1lXChfX0ZJTEVfX1wpLFxzKlwkdGltZVwpO3RvdWNoXChcJF9TRVJWRVJcW1snIl1TQ1JJUFRfRklMRU5BTUVbJyJdXF0sIjtpOjMxODtzOjE3OiI8dGl0bGU+RmFrZVNlbmRlciI7aTozMTk7czoxMjY6IlxiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilccypcKCpccypAKlwkX1BPU1RccypcW1xzKlsnIl0uKz9bJyJdXHMqXF1ccypcLlxzKiJccyoyXHMqPlxzKiYxXHMqWyciXSI7aTozMjA7czo4ODoiXGIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVxzKlwoKlxzKlsnIl11bmFtZVxzKy1hWyciXVxzKlwpKiI7aTozMjE7czo4OToiQCphc3NlcnRccypcKCpccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxzKlxbXHMqWyciXXswLDF9Lis/WyciXXswLDF9XHMqXF1ccyoiO2k6MzIyO3M6Mjg6InBocFxzK1snIl1ccypcLlxzKlwkd3NvX3BhdGgiO2k6MzIzO3M6NTI6ImZpbmRccysvXHMrLW5hbWVccytcLnNzaFxzKz5ccytcJGRpci9zc2hrZXlzL3NzaGtleXMiO2k6MzI0O3M6NDU6InN5c3RlbVxzKlwoKlxzKlsnIl17MCwxfXdob2FtaVsnIl17MCwxfVxzKlwpKiI7aTozMjU7czo4ODoiY3VybF9zZXRvcHRccypcKFxzKlwkY2hccyosXHMqQ1VSTE9QVF9VUkxccyosXHMqWyciXXswLDF9aHR0cDovL1wkaG9zdDpcZCtbJyJdezAsMX1ccypcKSI7fQ=="));
$gX_FlexDBShe = unserialize(base64_decode("YTozMjc6e2k6MDtzOjY4OiJmaWxlX2dldF9jb250ZW50c1woU1JWX05BTUVccypcLlxzKlsnIl1cP2FjdGlvbj1nZXRfc2l0ZXMmbm9kYV9uYW1lPSI7aToxO3M6NDA6IkxvY2F0aW9uOlxzKlthLXpBLVowLTlfXStcLmRvY3VtZW50XC5leGUiO2k6MjtzOjQwOiJpZlwoIXByZWdfbWF0Y2hcKFsnIl0vSGFja2VkIGJ5L2lbJyJdLFwkIjtpOjM7czo5OiJCeVxzK0FtIXIiO2k6NDtzOjE5OiJDb250ZW50LVR5cGU6XHMqXCRfIjtpOjU7czo0MDoiZXZhbFxzKlwoKlxzKmd6aW5mbGF0ZVxzKlwoKlxzKnN0cl9yb3QxMyI7aTo2O3M6MTA5OiJpZlxzKlwoXHMqaXNfY2FsbGFibGVccypcKCpccypbJyJdezAsMX1cYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pWyciXXswLDF9XHMqXCkqIjtpOjc7czoyOToiZXZhbFxzKlwoKlxzKmdldF9vcHRpb25ccypcKCoiO2k6ODtzOjk1OiJhZGRfZmlsdGVyXHMqXCgqXHMqWyciXXswLDF9dGhlX2NvbnRlbnRbJyJdezAsMX1ccyosXHMqWyciXXswLDF9X2Jsb2dpbmZvWyciXXswLDF9XHMqLFxzKi4rP1wpKiI7aTo5O3M6MzI6ImlzX3dyaXRhYmxlXHMqXCgqXHMqWyciXS92YXIvdG1wIjtpOjEwO3M6MjY6InN5bWxpbmtccypcKCpccypbJyJdL2hvbWUvIjtpOjExO3M6OTQ6Imlzc2V0XChccypAKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtbJyJdW2EtekEtWjAtOV9dK1snIl1cXVwpXHMqb3JccypkaWVcKCouKz9cKSoiO2k6MTI7czo0OToiZ3p1bmNvbXByZXNzXHMqXCgqXHMqc3Vic3RyXHMqXCgqXHMqYmFzZTY0X2RlY29kZSI7aToxMztzOjk6IlwkX19fXHMqPSI7aToxNDtzOjQwOiJpZlxzKlwoXHMqcHJlZ19tYXRjaFxzKlwoXHMqWyciXVwjeWFuZGV4IjtpOjE1O3M6NzE6IkBzZXRjb29raWVcKFsnIl1tWyciXSxccypbJyJdW2EtekEtWjAtOV9dK1snIl0sXHMqdGltZVwoXClccypcK1xzKjg2NDAwIjtpOjE2O3M6Mjg6ImVjaG9ccytbJyJdb1wua1wuWyciXTtccypcPz4iO2k6MTc7czozMzoic3ltYmlhblx8bWlkcFx8d2FwXHxwaG9uZVx8cG9ja2V0IjtpOjE4O3M6NDg6ImZ1bmN0aW9uXHMqY2htb2RfUlxzKlwoXHMqXCRwYXRoXHMqLFxzKlwkcGVybVxzKiI7aToxOTtzOjM4OiJldmFsXHMqXChccypnemluZmxhdGVccypcKFxzKnN0cl9yb3QxMyI7aToyMDtzOjIxOiJldmFsXHMqXChccypzdHJfcm90MTMiO2k6MjE7czozMDoicHJlZ19yZXBsYWNlXHMqXChccypbJyJdL1wuXCovIjtpOjIyO3M6NTg6IlwkbWFpbGVyXHMqPVxzKlwkX1BPU1RcW1xzKlsnIl17MCwxfXhfbWFpbGVyWyciXXswLDF9XHMqXF0iO2k6MjM7czo1NzoicHJlZ19yZXBsYWNlXHMqXChccypAKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjI0O3M6MzU6ImVjaG9ccytbJyJdezAsMX1pbnN0YWxsX29rWyciXXswLDF9IjtpOjI1O3M6MTY6IlNwYW1ccytjb21wbGV0ZWQiO2k6MjY7czo0NDoiYXJyYXlcKFxzKlsnIl1Hb29nbGVbJyJdXHMqLFxzKlsnIl1TbHVycFsnIl0iO2k6Mjc7czozMjoiPGgxPjQwMyBGb3JiaWRkZW48L2gxPjwhLS0gdG9rZW4iO2k6Mjg7czoyMDoiL2VbJyJdXHMqLFxzKlsnIl1cXHgiO2k6Mjk7czozNToicGhwX1snIl1cLlwkZXh0XC5bJyJdXC5kbGxbJyJdezAsMX0iO2k6MzA7czoxNzoibXgyXC5ob3RtYWlsXC5jb20iO2k6MzE7czozNjoicHJlZ19yZXBsYWNlXChccypbJyJdZVsnIl0sWyciXXswLDF9IjtpOjMyO3M6NTM6ImZvcGVuXChbJyJdezAsMX1cLlwuL1wuXC4vXC5cLi9bJyJdezAsMX1cLlwkZmlsZXBhdGhzIjtpOjMzO3M6NTE6IlwkZGF0YVxzKj1ccyphcnJheVwoWyciXXswLDF9dGVybWluYWxbJyJdezAsMX1ccyo9PiI7aTozNDtzOjI5OiJcJGJccyo9XHMqbWQ1X2ZpbGVcKFwkZmlsZWJcKSI7aTozNTtzOjMzOiJwb3J0bGV0cy9mcmFtZXdvcmsvc2VjdXJpdHkvbG9naW4iO2k6MzY7czozMToiXCRmaWxlYlxzKj1ccypmaWxlX2dldF9jb250ZW50cyI7aTozNztzOjEwNDoic2l0ZV9mcm9tPVsnIl17MCwxfVwuXCRfU0VSVkVSXFtbJyJdezAsMX1IVFRQX0hPU1RbJyJdezAsMX1cXVwuWyciXXswLDF9JnNpdGVfZm9sZGVyPVsnIl17MCwxfVwuXCRmXFsxXF0iO2k6Mzg7czo1Njoid2hpbGVcKGNvdW50XChcJGxpbmVzXCk+XCRjb2xfemFwXCkgYXJyYXlfcG9wXChcJGxpbmVzXCkiO2k6Mzk7czo4NToiXCRzdHJpbmdccyo9XHMqXCRfU0VTU0lPTlxbWyciXXswLDF9ZGF0YV9hWyciXXswLDF9XF1cW1snIl17MCwxfW51dHplcm5hbWVbJyJdezAsMX1cXSI7aTo0MDtzOjQxOiJpZiBcKCFzdHJwb3NcKFwkc3Ryc1xbMFxdLFsnIl17MCwxfTxcP3BocCI7aTo0MTtzOjI1OiJcJGlzZXZhbGZ1bmN0aW9uYXZhaWxhYmxlIjtpOjQyO3M6MTQ6IkRhdmlkXHMrQmxhaW5lIjtpOjQzO3M6NDc6ImlmIFwoZGF0ZVwoWyciXXswLDF9alsnIl17MCwxfVwpXHMqLVxzKlwkbmV3c2lkIjtpOjQ0O3M6MTU6IjwhLS1ccytqcy10b29scyI7aTo0NTtzOjM0OiJpZlwoQHByZWdfbWF0Y2hcKHN0cnRyXChbJyJdezAsMX0vIjtpOjQ2O3M6Mzc6Il9bJyJdezAsMX1cXVxbMlxdXChbJyJdezAsMX1Mb2NhdGlvbjoiO2k6NDc7czoyODoiXCRfUE9TVFxbWyciXXswLDF9c210cF9sb2dpbiI7aTo0ODtzOjI4OiJpZlxzKlwoQGlzX3dyaXRhYmxlXChcJGluZGV4IjtpOjQ5O3M6ODY6IkBpbmlfc2V0XHMqXChbJyJdezAsMX1pbmNsdWRlX3BhdGhbJyJdezAsMX0sWyciXXswLDF9aW5pX2dldFxzKlwoWyciXXswLDF9aW5jbHVkZV9wYXRoIjtpOjUwO3M6Mzg6IlplbmRccytPcHRpbWl6YXRpb25ccyt2ZXJccysxXC4wXC4wXC4xIjtpOjUxO3M6NjI6IlwkX1NFU1NJT05cW1snIl17MCwxfWRhdGFfYVsnIl17MCwxfVxdXFtcJG5hbWVcXVxzKj1ccypcJHZhbHVlIjtpOjUyO3M6NDI6ImlmXHMqXChmdW5jdGlvbl9leGlzdHNcKFsnIl1zY2FuX2RpcmVjdG9yeSI7aTo1MztzOjY3OiJhcnJheVwoXHMqWyciXWhbJyJdXHMqLFxzKlsnIl10WyciXVxzKixccypbJyJddFsnIl1ccyosXHMqWyciXXBbJyJdIjtpOjU0O3M6MzU6IlwkY291bnRlclVybFxzKj1ccypbJyJdezAsMX1odHRwOi8vIjtpOjU1O3M6MTA0OiJmb3JcKFwkW2EtekEtWjAtOV9dKz1cZCs7XCRbYS16QS1aMC05X10rPFxkKztcJFthLXpBLVowLTlfXSstPVxkK1wpe2lmXChcJFthLXpBLVowLTlfXSshPVxkK1wpXHMqYnJlYWs7fSI7aTo1NjtzOjM2OiJpZlwoQGZ1bmN0aW9uX2V4aXN0c1woWyciXXswLDF9ZnJlYWQiO2k6NTc7czozMzoiXCRvcHRccyo9XHMqXCRmaWxlXChAKlwkX0NPT0tJRVxbIjtpOjU4O3M6Mzg6InByZWdfcmVwbGFjZVwoXCl7cmV0dXJuXHMrX19GVU5DVElPTl9fIjtpOjU5O3M6Mzk6ImlmXHMqXChjaGVja19hY2NcKFwkbG9naW4sXCRwYXNzLFwkc2VydiI7aTo2MDtzOjM2OiJwcmludFxzK1snIl17MCwxfWRsZV9udWxsZWRbJyJdezAsMX0iO2k6NjE7czo2MzoiaWZcKG1haWxcKFwkZW1haWxcW1wkaVxdLFxzKlwkc3ViamVjdCxccypcJG1lc3NhZ2UsXHMqXCRoZWFkZXJzIjtpOjYyO3M6MTI6IlRlYU1ccytNb3NUYSI7aTo2MztzOjE0OiJbJyJdezAsMX1EWmUxciI7aTo2NDtzOjE1OiJwYWNrXHMrIlNuQTR4OCIiO2k6NjU7czozMjoiXCRfUG9zdFxbWyciXXswLDF9U1NOWyciXXswLDF9XF0iO2k6NjY7czoyNzoiRXRobmljXHMrQWxiYW5pYW5ccytIYWNrZXJzIjtpOjY3O3M6OToiQnlccytEWjI3IjtpOjY4O3M6NzQ6IlxiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilcKFsnIl17MCwxfWNtZFwuZXhlIjtpOjY5O3M6MTU6IkF1dG9ccypYcGxvaXRlciI7aTo3MDtzOjk6ImJ5XHMrZzAwbiI7aTo3MTtzOjI4OiJpZlwoXCRvPDE2XCl7XCRoXFtcJGVcW1wkb1xdIjtpOjcyO3M6OTQ6ImlmXChpc19kaXJcKFwkcGF0aFwuWyciXXswLDF9L3dwLWNvbnRlbnRbJyJdezAsMX1cKVxzK0FORFxzK2lzX2RpclwoXCRwYXRoXC5bJyJdezAsMX0vd3AtYWRtaW4iO2k6NzM7czo2MDoiaWZccypcKFxzKmZpbGVfcHV0X2NvbnRlbnRzXHMqXChccypcJGluZGV4X3BhdGhccyosXHMqXCRjb2RlIjtpOjc0O3M6NTE6IkBhcnJheVwoXHMqXChzdHJpbmdcKVxzKnN0cmlwc2xhc2hlc1woXHMqXCRfUkVRVUVTVCI7aTo3NTtzOjQwOiJzdHJfcmVwbGFjZVxzKlwoXHMqWyciXXswLDF9L3B1YmxpY19odG1sIjtpOjc2O3M6NDE6ImlmXChccyppc3NldFwoXHMqXCRfUkVRVUVTVFxbWyciXXswLDF9Y2lkIjtpOjc3O3M6MTU6ImNhdGF0YW5ccytzaXR1cyI7aTo3ODtzOjg1OiIvaW5kZXhcLnBocFw/b3B0aW9uPWNvbV9qY2UmdGFzaz1wbHVnaW4mcGx1Z2luPWltZ21hbmFnZXImZmlsZT1pbWdtYW5hZ2VyJnZlcnNpb249XGQrIjtpOjc5O3M6Mzc6InNldGNvb2tpZVwoXHMqXCR6XFswXF1ccyosXHMqXCR6XFsxXF0iO2k6ODA7czozMjoiXCRTXFtcJGlcK1wrXF1cKFwkU1xbXCRpXCtcK1xdXCgiO2k6ODE7czozMjoiXFtcJG9cXVwpO1wkb1wrXCtcKXtpZlwoXCRvPDE2XCkiO2k6ODI7czo4MToidHlwZW9mXHMqXChkbGVfYWRtaW5cKVxzKj09XHMqWyciXXswLDF9dW5kZWZpbmVkWyciXXswLDF9XHMqXHxcfFxzKmRsZV9hZG1pblxzKj09IjtpOjgzO3M6MzY6ImNyZWF0ZV9mdW5jdGlvblwoc3Vic3RyXCgyLDFcKSxcJHNcKSI7aTo4NDtzOjYwOiJwbHVnaW5zL3NlYXJjaC9xdWVyeVwucGhwXD9fX19fcGdmYT1odHRwJTNBJTJGJTJGd3d3XC5nb29nbGUiO2k6ODU7czozNjoicmV0dXJuXHMrYmFzZTY0X2RlY29kZVwoXCRhXFtcJGlcXVwpIjtpOjg2O3M6NDU6IlwkZmlsZVwoQCpcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKSI7aTo4NztzOjI3OiJjdXJsX2luaXRcKFxzKmJhc2U2NF9kZWNvZGUiO2k6ODg7czozMjoiZXZhbFwoWyciXVw/PlsnIl1cLmJhc2U2NF9kZWNvZGUiO2k6ODk7czoyOToiWyciXVsnIl1ccypcLlxzKkJBc2U2NF9kZUNvRGUiO2k6OTA7czoyODoiWyciXVsnIl1ccypcLlxzKmd6VW5jb01wcmVTcyI7aTo5MTtzOjE5OiJncmVwXHMrLXZccytjcm9udGFiIjtpOjkyO3M6MzQ6ImNyYzMyXChccypcJF9QT1NUXFtccypbJyJdezAsMX1jbWQiO2k6OTM7czoxOToiXCRia2V5d29yZF9iZXo9WyciXSI7aTo5NDtzOjYwOiJmaWxlX2dldF9jb250ZW50c1woYmFzZW5hbWVcKFwkX1NFUlZFUlxbWyciXXswLDF9U0NSSVBUX05BTUUiO2k6OTU7czo1NDoiXHMqWyciXXswLDF9cm9va2VlWyciXXswLDF9XHMqLFxzKlsnIl17MCwxfXdlYmVmZmVjdG9yIjtpOjk2O3M6NDg6IlxzKlsnIl17MCwxfXNsdXJwWyciXXswLDF9XHMqLFxzKlsnIl17MCwxfW1zbmJvdCI7aTo5NztzOjIwOiJldmFsXHMqXChccypUUExfRklMRSI7aTo5ODtzOjgyOiJAKmFycmF5X2RpZmZfdWtleVwoXHMqQCphcnJheVwoXHMqXChzdHJpbmdcKVxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjk5O3M6MTA1OiJcJHBhdGhccyo9XHMqXCRfU0VSVkVSXFtccypbJyJdezAsMX1ET0NVTUVOVF9ST09UWyciXXswLDF9XHMqXF1ccypcLlxzKlsnIl17MCwxfS9pbWFnZXMvc3Rvcmllcy9bJyJdezAsMX0iO2k6MTAwO3M6ODk6Ilwkc2FwZV9vcHRpb25cW1xzKlsnIl17MCwxfWZldGNoX3JlbW90ZV90eXBlWyciXXswLDF9XHMqXF1ccyo9XHMqWyciXXswLDF9c29ja2V0WyciXXswLDF9IjtpOjEwMTtzOjg4OiJmaWxlX3B1dF9jb250ZW50c1woXHMqXCRuYW1lXHMqLFxzKmJhc2U2NF9kZWNvZGVcKFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjEwMjtzOjgyOiJlcmVnX3JlcGxhY2VcKFsnIl17MCwxfSU1QyUyMlsnIl17MCwxfVxzKixccypbJyJdezAsMX0lMjJbJyJdezAsMX1ccyosXHMqXCRtZXNzYWdlIjtpOjEwMztzOjg1OiJcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXXswLDF9dXJbJyJdezAsMX1cXVwpXClccypcJG1vZGVccypcfD1ccyowNDAwIjtpOjEwNDtzOjQxOiIvcGx1Z2lucy9zZWFyY2gvcXVlcnlcLnBocFw/X19fX3BnZmE9aHR0cCI7aToxMDU7czo0OToiQCpmaWxlX3B1dF9jb250ZW50c1woXHMqXCR0aGlzLT5maWxlXHMqLFxzKnN0cnJldiI7aToxMDY7czo0ODoicHJlZ19tYXRjaF9hbGxcKFxzKlsnIl1cfFwoXC5cKlwpPFxcIS0tIGpzLXRvb2xzIjtpOjEwNztzOjMwOiJoZWFkZXJcKFsnIl17MCwxfXI6XHMqbm9ccytjb20iO2k6MTA4O3M6NzU6IlxiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilcKFsnIl1sc1xzKy92YXIvbWFpbCI7aToxMDk7czoyNjoiXCRkb3JfY29udGVudD1wcmVnX3JlcGxhY2UiO2k6MTEwO3M6MjM6Il9fdXJsX2dldF9jb250ZW50c1woXCRsIjtpOjExMTtzOjUzOiJcJEdMT0JBTFNcW1snIl17MCwxfVthLXpBLVowLTlfXStbJyJdezAsMX1cXVwoXHMqTlVMTCI7aToxMTI7czo2MjoidW5hbWVcXVsnIl17MCwxfVxzKlwuXHMqcGhwX3VuYW1lXChcKVxzKlwuXHMqWyciXXswLDF9XFsvdW5hbWUiO2k6MTEzO3M6MzM6IkBcJGZ1bmNcKFwkY2ZpbGUsIFwkY2RpclwuXCRjbmFtZSI7aToxMTQ7czozNToiZXZhbFwoXHMqXCRbYS16QS1aMC05X10rXChccypcJDxhbWMiO2k6MTE1O3M6NzE6IlwkX1xbXHMqXGQrXHMqXF1cKFxzKlwkX1xbXHMqXGQrXHMqXF1cKFwkX1xbXHMqXGQrXHMqXF1cKFxzKlwkX1xbXHMqXGQrIjtpOjExNjtzOjI5OiJlcmVnaVwoXHMqc3FsX3JlZ2Nhc2VcKFxzKlwkXyI7aToxMTc7czo0MDoiXCNVc2VbJyJdezAsMX1ccyosXHMqZmlsZV9nZXRfY29udGVudHNcKCI7aToxMTg7czoyMDoibWtkaXJcKFxzKlsnIl0vaG9tZS8iO2k6MTE5O3M6MjA6ImZvcGVuXChccypbJyJdL2hvbWUvIjtpOjEyMDtzOjM2OiJcJHVzZXJfYWdlbnRfdG9fZmlsdGVyXHMqPVxzKmFycmF5XCgiO2k6MTIxO3M6NDQ6ImZpbGVfcHV0X2NvbnRlbnRzXChbJyJdezAsMX1cLi9saWJ3b3JrZXJcLnNvIjtpOjEyMjtzOjY0OiJcIyEvYmluL3NobmNkXHMrWyciXXswLDF9WyciXXswLDF9XC5cJFNDUFwuWyciXXswLDF9WyciXXswLDF9bmlmIjtpOjEyMztzOjgyOiJcYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChccypbJyJdezAsMX1hdFxzK25vd1xzKy1mIjtpOjEyNDtzOjMzOiJjcm9udGFiXHMrLWxcfGdyZXBccystdlxzK2Nyb250YWIiO2k6MTI1O3M6MTQ6IkRhdmlkXHMqQmxhaW5lIjtpOjEyNjtzOjIzOiJleHBsb2l0LWRiXC5jb20vc2VhcmNoLyI7aToxMjc7czozNjoiZmlsZV9wdXRfY29udGVudHNcKFxzKlsnIl17MCwxfS9ob21lIjtpOjEyODtzOjYwOiJtYWlsXChccypcJE1haWxUb1xzKixccypcJE1lc3NhZ2VTdWJqZWN0XHMqLFxzKlwkTWVzc2FnZUJvZHkiO2k6MTI5O3M6MTE3OiJcJGNvbnRlbnRccyo9XHMqaHR0cF9yZXF1ZXN0XChbJyJdezAsMX1odHRwOi8vWyciXXswLDF9XHMqXC5ccypcJF9TRVJWRVJcW1snIl17MCwxfVNFUlZFUl9OQU1FWyciXXswLDF9XF1cLlsnIl17MCwxfS8iO2k6MTMwO3M6Nzg6IiFmaWxlX3B1dF9jb250ZW50c1woXHMqXCRkYm5hbWVccyosXHMqXCR0aGlzLT5nZXRJbWFnZUVuY29kZWRUZXh0XChccypcJGRibmFtZSI7aToxMzE7czo0NDoic2NyaXB0c1xbXHMqZ3p1bmNvbXByZXNzXChccypiYXNlNjRfZGVjb2RlXCgiO2k6MTMyO3M6NzI6InNlbmRfc210cFwoXHMqXCRlbWFpbFxbWyciXXswLDF9YWRyWyciXXswLDF9XF1ccyosXHMqXCRzdWJqXHMqLFxzKlwkdGV4dCI7aToxMzM7czo0NjoiPVwkZmlsZVwoQCpcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKSI7aToxMzQ7czo1MjoidG91Y2hcKFxzKlsnIl17MCwxfVwkYmFzZXBhdGgvY29tcG9uZW50cy9jb21fY29udGVudCI7aToxMzU7czoyNzoiXChbJyJdXCR0bXBkaXIvc2Vzc19mY1wubG9nIjtpOjEzNjtzOjM1OiJmaWxlX2V4aXN0c1woXHMqWyciXS90bXAvdG1wLXNlcnZlciI7aToxMzc7czo0OToibWFpbFwoXHMqXCRyZXRvcm5vXHMqLFxzKlwkYXN1bnRvXHMqLFxzKlwkbWVuc2FqZSI7aToxMzg7czo4MjoiXCRVUkxccyo9XHMqXCR1cmxzXFtccypyYW5kXChccyowXHMqLFxzKmNvdW50XChccypcJHVybHNccypcKVxzKi1ccyoxXClccypcXVwucmFuZCI7aToxMzk7czo0MDoiX19maWxlX2dldF91cmxfY29udGVudHNcKFxzKlwkcmVtb3RlX3VybCI7aToxNDA7czoxMzoiPWJ5XHMrRFJBR09OPSI7aToxNDE7czo5ODoic3Vic3RyXChccypcJHN0cmluZzJccyosXHMqc3RybGVuXChccypcJHN0cmluZzJccypcKVxzKi1ccyo5XHMqLFxzKjlcKVxzKj09XHMqWyciXXswLDF9XFtsLHI9MzAyXF0iO2k6MTQyO3M6MzM6IlxbXF1ccyo9XHMqWyciXVJld3JpdGVFbmdpbmVccytvbiI7aToxNDM7czo3NToiZndyaXRlXChccypcJGZccyosXHMqZ2V0X2Rvd25sb2FkXChccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbIjtpOjE0NDtzOjQ3OiJ0YXJccystY3pmXHMrIlxzKlwuXHMqXCRGT1JNe3Rhcn1ccypcLlxzKiJcLnRhciI7aToxNDU7czoxMToic2NvcGJpblsnIl0iO2k6MTQ2O3M6NjY6IjxkaXZccytpZD1bJyJdbGluazFbJyJdPjxidXR0b24gb25jbGljaz1bJyJdcHJvY2Vzc1RpbWVyXChcKTtbJyJdPiI7aToxNDc7czozNToiPGd1aWQ+PFw/cGhwXHMrZWNob1xzK1wkY3VycmVudF91cmwiO2k6MTQ4O3M6NjI6ImludDMyXChcKFwoXCR6XHMqPj5ccyo1XHMqJlxzKjB4MDdmZmZmZmZcKVxzKlxeXHMqXCR5XHMqPDxccyoyIjtpOjE0OTtzOjQzOiJmb3BlblwoXHMqXCRyb290X2RpclxzKlwuXHMqWyciXS9cLmh0YWNjZXNzIjtpOjE1MDtzOjIzOiJcJGluX1Blcm1zXHMrJlxzKzB4NDAwMCI7aToxNTE7czozNDoiZmlsZV9nZXRfY29udGVudHNcKFxzKlsnIl0vdmFyL3RtcCI7aToxNTI7czo5OiIvcG10L3Jhdi8iO2k6MTUzO3M6NDk6ImZ3cml0ZVwoXCRmcFxzKixccypzdHJyZXZcKFxzKlwkY29udGV4dFxzKlwpXHMqXCkiO2k6MTU0O3M6MjA6Ik1hc3JpXHMrQ3liZXJccytUZWFtIjtpOjE1NTtzOjE4OiJVczNccytZMHVyXHMrYnI0MW4iO2k6MTU2O3M6MjA6Ik1hc3IxXHMrQ3liM3JccytUZTRtIjtpOjE1NztzOjIwOiJ0SEFOS3Nccyt0T1xzK1Nub3BweSI7aToxNTg7czo2NjoiLFxzKlsnIl0vaW5kZXhcXFwuXChwaHBcfGh0bWxcKS9pWyciXVxzKixccypSZWN1cnNpdmVSZWdleEl0ZXJhdG9yIjtpOjE1OTtzOjQ3OiJmaWxlX3B1dF9jb250ZW50c1woXHMqXCRpbmRleF9wYXRoXHMqLFxzKlwkY29kZSI7aToxNjA7czo1NToiZ2V0cHJvdG9ieW5hbWVcKFxzKlsnIl10Y3BbJyJdXHMqXClccytcfFx8XHMrZGllXHMrc2hpdCI7aToxNjE7czo3ODoiXGIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVwoXHMqWyciXWNkXHMrL3RtcDt3Z2V0IjtpOjE2MjtzOjIyOiI8YVxzK2hyZWY9WyciXW9zaGlia2EtIjtpOjE2MztzOjg1OiJpZlwoXHMqXCRfR0VUXFtccypbJyJdaWRbJyJdXHMqXF0hPVxzKlsnIl1bJyJdXHMqXClccypcJGlkPVwkX0dFVFxbXHMqWyciXWlkWyciXVxzKlxdIjtpOjE2NDtzOjgzOiJpZlwoWyciXXN1YnN0cl9jb3VudFwoWyciXVwkX1NFUlZFUlxbWyciXVJFUVVFU1RfVVJJWyciXVxdXHMqLFxzKlsnIl1xdWVyeVwucGhwWyciXSI7aToxNjU7czozODoiXCRmaWxsID0gXCRfQ09PS0lFXFtcXFsnIl1maWxsXFxbJyJdXF0iO2k6MTY2O3M6NjI6IlwkcmVzdWx0PXNtYXJ0Q29weVwoXHMqXCRzb3VyY2VccypcLlxzKlsnIl0vWyciXVxzKlwuXHMqXCRmaWxlIjtpOjE2NztzOjQwOiJcJGJhbm5lZElQXHMqPVxzKmFycmF5XChccypbJyJdXF42NlwuMTAyIjtpOjE2ODtzOjM1OiI8bG9jPjxcP3BocFxzK2VjaG9ccytcJGN1cnJlbnRfdXJsOyI7aToxNjk7czoyODoiXCRzZXRjb29rXCk7c2V0Y29va2llXChcJHNldCI7aToxNzA7czoyODoiXCk7ZnVuY3Rpb25ccytzdHJpbmdfY3B0XChcJCI7aToxNzE7czo1MDoiWyciXVwuWyciXVsnIl1cLlsnIl1bJyJdXC5bJyJdWyciXVwuWyciXVsnIl1cLlsnIl0iO2k6MTcyO3M6NTM6ImlmXChwcmVnX21hdGNoXChbJyJdXCN3b3JkcHJlc3NfbG9nZ2VkX2luXHxhZG1pblx8cHdkIjtpOjE3MztzOjQxOiJnX2RlbGV0ZV9vbl9leGl0XHMqPVxzKm5ld1xzK0RlbGV0ZU9uRXhpdCI7aToxNzQ7czozMDoiU0VMRUNUXHMrXCpccytGUk9NXHMrZG9yX3BhZ2VzIjtpOjE3NTtzOjE4OiJBY2FkZW1pY29ccytSZXN1bHQiO2k6MTc2O3M6Nzc6InZhbHVlPVsnIl08XD9ccytcYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChbJyJdIjtpOjE3NztzOjI3OiJcZCsmQHByZWdfbWF0Y2hcKFxzKnN0cnRyXCgiO2k6MTc4O3M6Mzg6ImNoclwoXHMqaGV4ZGVjXChccypzdWJzdHJcKFxzKlwkbWFrZXVwIjtpOjE3OTtzOjMwOiJyZWFkX2ZpbGVfbmV3XzJcKFwkcmVzdWx0X3BhdGgiO2k6MTgwO3M6MjM6IlwkaW5kZXhfcGF0aFxzKixccyowNDA0IjtpOjE4MTtzOjY3OiJcJGZpbGVfZm9yX3RvdWNoXHMqPVxzKlwkX1NFUlZFUlxbWyciXXswLDF9RE9DVU1FTlRfUk9PVFsnIl17MCwxfVxdIjtpOjE4MjtzOjYxOiJcJF9TRVJWRVJcW1snIl17MCwxfVJFTU9URV9BRERSWyciXXswLDF9XF07aWZcKFwocHJlZ19tYXRjaFwoIjtpOjE4MztzOjE5OiI9PVxzKlsnIl1jc2hlbGxbJyJdIjtpOjE4NDtzOjI5OiJmaWxlX2V4aXN0c1woXHMqXCRGaWxlQmF6YVRYVCI7aToxODU7czoxODoicmVzdWx0c2lnbl93YXJuaW5nIjtpOjE4NjtzOjI0OiJmdW5jdGlvblxzK2dldGZpcnN0c2h0YWciO2k6MTg3O3M6OTA6ImZpbGVfZ2V0X2NvbnRlbnRzXChST09UX0RJUlwuWyciXS90ZW1wbGF0ZXMvWyciXVwuXCRjb25maWdcW1snIl1za2luWyciXVxdXC5bJyJdL21haW5cLnRwbCI7aToxODg7czoyNToibmV3XHMrY29uZWN0QmFzZVwoWyciXWFIUiI7aToxODk7czo4MzoiXCRpZFxzKlwuXHMqWyciXVw/ZD1bJyJdXHMqXC5ccypiYXNlNjRfZW5jb2RlXChccypcJF9TRVJWRVJcW1xzKlsnIl1IVFRQX1VTRVJfQUdFTlQiO2k6MTkwO3M6Mjk6ImRvX3dvcmtcKFxzKlwkaW5kZXhfZmlsZVxzKlwpIjtpOjE5MTtzOjIwOiJoZWFkZXJccypcKFxzKl9cZCtcKCI7aToxOTI7czoxMjoiQnlccytXZWJSb29UIjtpOjE5MztzOjE2OiJDb2RlZFxzK2J5XHMrRVhFIjtpOjE5NDtzOjcxOiJ0cmltXChccypcJGhlYWRlcnNccypcKVxzKlwpXHMqYXNccypcJGhlYWRlclxzKlwpXHMqaGVhZGVyXChccypcJGhlYWRlciI7aToxOTU7czo1NjoiQFwkX1NFUlZFUlxbXHMqSFRUUF9IT1NUXHMqXF0+WyciXVxzKlwuXHMqWyciXVxcclxcblsnIl0iO2k6MTk2O3M6ODE6ImZpbGVfZ2V0X2NvbnRlbnRzXChccypcJF9TRVJWRVJcW1xzKlsnIl1ET0NVTUVOVF9ST09UWyciXVxzKlxdXHMqXC5ccypbJyJdL2VuZ2luZSI7aToxOTc7czo2OToidG91Y2hcKFxzKlwkX1NFUlZFUlxbXHMqWyciXURPQ1VNRU5UX1JPT1RbJyJdXHMqXF1ccypcLlxzKlsnIl0vZW5naW5lIjtpOjE5ODtzOjE2OiJQSFBTSEVMTF9WRVJTSU9OIjtpOjE5OTtzOjI1OiI8XD9ccyo9QGBcJFthLXpBLVowLTlfXStgIjtpOjIwMDtzOjIxOiImX1NFU1NJT05cW3BheWxvYWRcXT0iO2k6MjAxO3M6NDc6Imd6dW5jb21wcmVzc1woXHMqZmlsZV9nZXRfY29udGVudHNcKFxzKlsnIl1odHRwIjtpOjIwMjtzOjg0OiJpZlwoXHMqIWVtcHR5XChccypcJF9QT1NUXFtccypbJyJdezAsMX10cDJbJyJdezAsMX1ccypcXVwpXHMqYW5kXHMqaXNzZXRcKFxzKlwkX1BPU1QiO2k6MjAzO3M6NDk6ImlmXChccyp0cnVlXHMqJlxzKkBwcmVnX21hdGNoXChccypzdHJ0clwoXHMqWyciXS8iO2k6MjA0O3M6Mzg6Ij09XHMqMFwpXHMqe1xzKmVjaG9ccypQSFBfT1NccypcLlxzKlwkIjtpOjIwNTtzOjEwNzoiaXNzZXRcKFxzKlwkX1NFUlZFUlxbXHMqX1xkK1woXHMqXGQrXHMqXClccypcXVxzKlwpXHMqXD9ccypcJF9TRVJWRVJcW1xzKl9cZCtcKFxkK1wpXHMqXF1ccyo6XHMqX1xkK1woXGQrXCkiO2k6MjA2O3M6OTk6IlwkaW5kZXhccyo9XHMqc3RyX3JlcGxhY2VcKFxzKlsnIl08XD9waHBccypvYl9lbmRfZmx1c2hcKFwpO1xzKlw/PlsnIl1ccyosXHMqWyciXVsnIl1ccyosXHMqXCRpbmRleCI7aToyMDc7czozMzoiXCRzdGF0dXNfbG9jX3NoXHMqPVxzKmZpbGVfZXhpc3RzIjtpOjIwODtzOjQ4OiJcJFBPU1RfU1RSXHMqPVxzKmZpbGVfZ2V0X2NvbnRlbnRzXCgicGhwOi8vaW5wdXQiO2k6MjA5O3M6NDg6ImdlXHMqPVxzKnN0cmlwc2xhc2hlc1xzKlwoXHMqXCRfUE9TVFxzKlxbWyciXW1lcyI7aToyMTA7czo2NjoiXCR0YWJsZVxbXCRzdHJpbmdcW1wkaVxdXF1ccypcKlxzKnBvd1woNjRccyosXHMqMlwpXHMqXCtccypcJHRhYmxlIjtpOjIxMTtzOjMzOiJpZlwoXHMqc3RyaXBvc1woXHMqWyciXVwqXCpcKlwkdWEiO2k6MjEyO3M6NDk6ImZsdXNoX2VuZF9maWxlXChccypcJGZpbGVuYW1lXHMqLFxzKlwkZmlsZWNvbnRlbnQiO2k6MjEzO3M6NTY6InByZWdfbWF0Y2hcKFxzKlsnIl17MCwxfX5Mb2NhdGlvbjpcKFwuXCpcP1wpXChcPzpcXG5cfFwkIjtpOjIxNDtzOjI4OiJ0b3VjaFwoXHMqXCR0aGlzLT5jb25mLT5yb290IjtpOjIxNTtzOjM2OiJldmFsXChccypcJHtccypcJFthLXpBLVowLTlfXStccyp9XFsiO2k6MjE2O3M6NDM6ImlmXHMqXChccypAZmlsZXR5cGVcKFwkbGVhZG9uXHMqXC5ccypcJGZpbGUiO2k6MjE3O3M6NTk6ImZpbGVfcHV0X2NvbnRlbnRzXChccypcJGRpclxzKlwuXHMqXCRmaWxlXHMqXC5ccypbJyJdL2luZGV4IjtpOjIxODtzOjI2OiJmaWxlc2l6ZVwoXHMqXCRwdXRfa19mYWlsdSI7aToyMTk7czo2MDoiYWdlXHMqPVxzKnN0cmlwc2xhc2hlc1xzKlwoXHMqXCRfUE9TVFxzKlxbWyciXXswLDF9bWVzWyciXVxdIjtpOjIyMDtzOjQzOiJmdW5jdGlvblxzK2ZpbmRIZWFkZXJMaW5lXHMqXChccypcJHRlbXBsYXRlIjtpOjIyMTtzOjQzOiJcJHN0YXR1c19jcmVhdGVfZ2xvYl9maWxlXHMqPVxzKmNyZWF0ZV9maWxlIjtpOjIyMjtzOjM4OiJlY2hvXHMrc2hvd19xdWVyeV9mb3JtXChccypcJHNxbHN0cmluZyI7aToyMjM7czozNToiPT1ccypGQUxTRVxzKlw/XHMqXGQrXHMqOlxzKmlwMmxvbmciO2k6MjI0O3M6MjI6ImZ1bmN0aW9uXHMrbWFpbGVyX3NwYW0iO2k6MjI1O3M6MzQ6IkVkaXRIdGFjY2Vzc1woXHMqWyciXVJld3JpdGVFbmdpbmUiO2k6MjI2O3M6MTE6IlwkcGF0aFRvRG9yIjtpOjIyNztzOjQwOiJcJGN1cl9jYXRfaWRccyo9XHMqXChccyppc3NldFwoXHMqXCRfR0VUIjtpOjIyODtzOjk3OiJAXCRfQ09PS0lFXFtccypbJyJdW2EtekEtWjAtOV9dK1snIl1ccypcXVwoXHMqQFwkX0NPT0tJRVxbXHMqWyciXVthLXpBLVowLTlfXStbJyJdXHMqXF1ccypcKVxzKlwpIjtpOjIyOTtzOjQwOiJoZWFkZXJcKFsnIl1Mb2NhdGlvbjpccypodHRwOi8vXCRwcFwub3JnIjtpOjIzMDtzOjQ3OiJyZXR1cm5ccytbJyJdL2hvbWUvW2EtekEtWjAtOV9dKy9bYS16QS1aMC05X10rLyI7aToyMzE7czozOToiWyciXXdwLVsnIl1ccypcLlxzKmdlbmVyYXRlUmFuZG9tU3RyaW5nIjtpOjIzMjtzOjY3OiJcJFthLXpBLVowLTlfXSs9PVsnIl1mZWF0dXJlZFsnIl1ccypcKVxzKlwpe1xzKmVjaG9ccytiYXNlNjRfZGVjb2RlIjtpOjIzMztzOjEwNjoiXCRbYS16QS1aMC05X10rXHMqPVxzKlwkanFccypcKFxzKkAqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl17MCwxfVthLXpBLVowLTlfXStbJyJdezAsMX1cXSI7aToyMzQ7czoyMjoiZXhwbG9pdFxzKjo6XC48L3RpdGxlPiI7aToyMzU7czo0MDoiXCRbYS16QS1aMC05X10rPXN0cl9yZXBsYWNlXChbJyJdXCphXCRcKiI7aToyMzY7czo2MDoiY2hyXChccypcJFthLXpBLVowLTlfXStccypcKTtccyp9XHMqZXZhbFwoXHMqXCRbYS16QS1aMC05X10rIjtpOjIzNztzOjQ3OiJpZlwoXHMqaXNJblN0cmluZzEqXChcJFthLXpBLVowLTlfXSssWyciXWdvb2dsZSI7aToyMzg7czo5MzoiXCRwcFxzKj1ccypcJHBcW1xkK1xdXHMqXC5ccypcJHBcW1xkK1xdXHMqXC5ccypcJHBcW1xkK1xdXHMqXC5ccypcJHBcW1xkK1xdXHMqXC5ccypcJHBcW1xkK1xdIjtpOjIzOTtzOjQ5OiJmaWxlX3B1dF9jb250ZW50c1woRElSXC5bJyJdL1snIl1cLlsnIl1pbmRleFwucGhwIjtpOjI0MDtzOjI5OiJAZ2V0X2hlYWRlcnNcKFxzKlwkZnVsbHBhdGhcKSI7aToyNDE7czoyMToiQFwkX0dFVFxbWyciXXB3WyciXVxdIjtpOjI0MjtzOjI1OiJqc29uX2VuY29kZVwoYWxleHVzTWFpbGVyIjtpOjI0MztzOjE2ODoiZXZhbFwoXHMqXGIoZXZhbHxiYXNlNjRfZGVjb2RlfHN0cnJldnxwcmVnX3JlcGxhY2V8cHJlZ19yZXBsYWNlX2NhbGxiYWNrfHVybGRlY29kZXxzdHJzdHJ8Z3ppbmZsYXRlfHNwcmludGZ8Z3p1bmNvbXByZXNzfGFzc2VydHxzdHJfcm90MTN8bWQ1fGFycmF5X3dhbGt8YXJyYXlfZmlsdGVyKVwoIjtpOjI0NDtzOjE5OiI9WyciXVwpXCk7WyciXVwpXCk7IjtpOjI0NTtzOjE4MDoiPVxzKlwkW2EtekEtWjAtOV9dK1woXGIoZXZhbHxiYXNlNjRfZGVjb2RlfHN0cnJldnxwcmVnX3JlcGxhY2V8cHJlZ19yZXBsYWNlX2NhbGxiYWNrfHVybGRlY29kZXxzdHJzdHJ8Z3ppbmZsYXRlfHNwcmludGZ8Z3p1bmNvbXByZXNzfGFzc2VydHxzdHJfcm90MTN8bWQ1fGFycmF5X3dhbGt8YXJyYXlfZmlsdGVyKVwoIjtpOjI0NjtzOjU1OiJcXVxzKn1ccypcKFxzKntccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbIjtpOjI0NztzOjc3OiJyZXF1ZXN0XC5zZXJ2ZXJ2YXJpYWJsZXNcKFxzKlsnIl1IVFRQX1VTRVJfQUdFTlRbJyJdXHMqXClccyosXHMqWyciXUdvb2dsZWJvdCI7aToyNDg7czo0ODoiZXZhbFwoWyciXVw/PlsnIl1ccypcLlxzKmpvaW5cKFsnIl1bJyJdLGZpbGVcKFwkIjtpOjI0OTtzOjY4OiJzZXRvcHRcKFwkY2hccyosXHMqQ1VSTE9QVF9QT1NURklFTERTXHMqLFxzKmh0dHBfYnVpbGRfcXVlcnlcKFwkZGF0YSI7aToyNTA7czoxMTc6Im15c3FsX2Nvbm5lY3RcKFwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtbJyJdW2EtekEtWjAtOV9dK1snIl1cXVxzKixccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKSI7aToyNTE7czo2NDoicmVxdWVzdFwuc2VydmVydmFyaWFibGVzXChbJyJdSFRUUF9VU0VSX0FHRU5UWyciXVwpLFsnIl1haWR1WyciXSI7aToyNTI7czozNjoiXF1ccypcKVxzKlwpXHMqe1xzKmV2YWxccypcKFxzKlwke1wkIjtpOjI1MztzOjE2OiJieVxzK0Vycm9yXHMrN3JCIjtpOjI1NDtzOjMzOiJAaXJjc2VydmVyc1xbcmFuZFxzK0BpcmNzZXJ2ZXJzXF0iO2k6MjU1O3M6NTk6InNldF90aW1lX2xpbWl0XChpbnR2YWxcKFwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjI1NjtzOjI0OiJuaWNrXHMrWyciXWNoYW5zZXJ2WyciXTsiO2k6MjU3O3M6MjM6Ik1hZ2ljXHMrSW5jbHVkZVxzK1NoZWxsIjtpOjI1ODtzOjk3OiJcJFthLXpBLVowLTlfXStcKTtcJFthLXpBLVowLTlfXSs9Y3JlYXRlX2Z1bmN0aW9uXChbJyJdWyciXSxcJFthLXpBLVowLTlfXStcKTtcJFthLXpBLVowLTlfXStcKFwpIjtpOjI1OTtzOjM4OiJjdXJsT3BlblwoXCRyZW1vdGVfcGF0aFwuXCRwYXJhbV92YWx1ZSI7aToyNjA7czo0NzoiZndyaXRlXChcJGZwLFsnIl1cXHhFRlxceEJCXFx4QkZbJyJdXC5cJGJvZHlcKTsiO2k6MjYxO3M6MTMzOiJcJFthLXpBLVowLTlfXStcK1wrXClccyp7XHMqXCRbYS16QS1aMC05X10rXHMqPVxzKmFycmF5X3VuaXF1ZVwoYXJyYXlfbWVyZ2VcKFwkW2EtekEtWjAtOV9dK1xzKixccypbYS16QS1aMC05X10rXChbJyJdXCRbYS16QS1aMC05X10rIjtpOjI2MjtzOjQyOiJhbmRccypcKCFccypzdHJzdHJcKFwkdWEsWyciXXJ2OjExWyciXVwpXCkiO2k6MjYzO3M6MzU6ImVjaG9ccytcJG9rXHMrXD9ccytbJyJdU0hFTExfT0tbJyJdIjtpOjI2NDtzOjI3OiI7ZXZhbFwoXCR0b2RvY29udGVudFxbMFxdXCkiO2k6MjY1O3M6NDA6Im9yXHMrc3RydG9sb3dlclwoQGluaV9nZXRcKFsnIl1zYWZlX21vZGUiO2k6MjY2O3M6Mjk6ImlmXCghaXNzZXRcKFwkX1JFUVVFU1RcW2NoclwoIjtpOjI2NztzOjQ0OiJcJHByb2Nlc3NvXHMqPVxzKlwkcHNcW3JhbmRccytzY2FsYXJccytAcHNcXSI7aToyNjg7czozMjoiZWNob1xzK1snIl11bmFtZVxzKy1hO1xzKlwkdW5hbWUiO2k6MjY5O3M6MjE6IlwudGNwZmxvb2Rccys8dGFyZ2V0PiI7aToyNzA7czo1MDoiXCRib3RcW1snIl1zZXJ2ZXJbJyJdXF09XCRzZXJ2YmFuXFtyYW5kXCgwLGNvdW50XCgiO2k6MjcxO3M6MTY6IlwuOlxzK3czM2Rccys6XC4iO2k6MjcyO3M6MTY6IkJMQUNLVU5JWFxzK0NSRVciO2k6MjczO3M6MTE4OiI7XCRbYS16QS1aMC05X10rXFtcJFthLXpBLVowLTlfXStcW1snIl1bYS16QS1aMC05X10rWyciXVxdXFtcZCtcXVwuXCRbYS16QS1aMC05X10rXFtbJyJdW2EtekEtWjAtOV9dK1snIl1cXVxbXGQrXF1cLlwkIjtpOjI3NDtzOjMwOiJjYXNlXHMqWyciXWNyZWF0ZV9zeW1saW5rWyciXToiO2k6Mjc1O3M6OTY6InNvY2tldF9jb25uZWN0XChcJFthLXpBLVowLTlfXSssXHMqWyciXWdtYWlsLXNtdHAtaW5cLmxcLmdvb2dsZVwuY29tWyciXVxzKixccyoyNVwpXHMqPT1ccypGQUxTRSI7aToyNzY7czo0NjoiY2FsbF91c2VyX2Z1bmNcKEB1bmhleFwoMHhbYS16QS1aMC05X10rXClcKFwkXyI7aToyNzc7czo2MjoiXCRfPUBcJF9SRVFVRVNUXFtbJyJdW2EtekEtWjAtOV9dK1snIl1cXVwpXC5AXCRfXChcJF9SRVFVRVNUXFsiO2k6Mjc4O3M6NjU6IlwkR0xPQkFMU1xbXCRHTE9CQUxTXFtbJyJdW2EtekEtWjAtOV9dK1snIl1cXVxbXGQrXF1cLlwkR0xPQkFMU1xbIjtpOjI3OTtzOjYzOiJcLlwkW2EtekEtWjAtOV9dK1xbXCRbYS16QS1aMC05X10rXF1cLlsnIl17WyciXVwpXCk7fTt1bnNldFwoXCQiO2k6MjgwO3M6ODY6Imh0dHBfYnVpbGRfcXVlcnlcKFwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXClcLlsnIl0maXA9WyciXVxzKlwuXHMqXCRfU0VSVkVSIjtpOjI4MTtzOjgyOiJcYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChccypbJyJdL3NiaW4vaWZjb25maWdbJyJdIjtpOjI4MjtzOjg5OiI8XD9waHBccytpZlxzKlwoaXNzZXRccypcKFwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtbJyJdaW1hZ2VzWyciXVxdXClcKVxzKntcJCI7aToyODM7czoxNzoiPHRpdGxlPkdPUkRPXHMrMjAiO2k6Mjg0O3M6MTM4OiJjb3B5XChccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXVthLXpBLVowLTlfXStbJyJdXF1ccyosXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl1bYS16QS1aMC05X10rWyciXVxdXCkiO2k6Mjg1O3M6Njg6InNwcmludGZcKFthLXpBLVowLTlfXStcKFwkW2EtekEtWjAtOV9dK1xzKixccypcJFthLXpBLVowLTlfXStcKVxzKlwpIjtpOjI4NjtzOjY4OiI9XHMqc3RyX3JlcGxhY2VcKFxzKlsnIl1cfFx8XHxbYS16QS1aMC05X10rXHxcfFx8WyciXVxzKixccypbJyJdWyciXSI7aToyODc7czoxMzI6IlwkW2EtekEtWjAtOV9dK1xbMFxdPXBhY2tcKFsnIl1IXCpbJyJdLFsnIl1bYS16QS1aMC05X10rWyciXVwpO2FycmF5X2ZpbHRlclwoXCRbYS16QS1aMC05X10rLHBhY2tcKFsnIl1IXCpbJyJdLFsnIl1bYS16QS1aMC05X10rWyciXSI7aToyODg7czo2MToiaWZccypcKHdpbmRvd1wucGx1c29cKVxzKmlmXHMqXCh0eXBlb2Zccyp3aW5kb3dcLnBsdXNvXC5zdGFydCI7aToyODk7czoxMzoiZXZhbFwoXCR7XCR7IiI7aToyOTA7czoxODoiLS12aXNpdG9yVHJhY2tlci0tIjtpOjI5MTtzOjEzOiI8JS0tU3VFeHAtLSU+IjtpOjI5MjtzOjczOiJcJF9fYVxzKj1ccypzdHJfcmVwbGFjZVwoIi4iLFxzKiIuIixccypcJF9fLlwpO1xzKlwkX18uXHMqPVxzKnN0cl9yZXBsYWNlIjtpOjI5MztzOjMwOiJlY2hvXHMqZXhlY1woWyciXXdob2FtaVsnIl1cKTsiO2k6Mjk0O3M6MTIxOiJmaWxlX3B1dF9jb250ZW50c1woWyciXVthLXpBLVowLTlfXStcLnBocFsnIl0sXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl1bYS16QS1aMC05X10rWyciXVxdLEZJTEVfQVBQRU5EXCk7IjtpOjI5NTtzOjU4OiJcJGRpcnBhdGhcLlsnIl0vWyciXVwuXCR2YWx1ZVwuWyciXS93cC1jb25maWdcLnBocFsnIl1cKVwuIjtpOjI5NjtzOjU0OiJhcnJheV9kaWZmX3VrZXlcKFwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFsiO2k6Mjk3O3M6Njc6IlwkW2EtekEtWjAtOV9dKz1maWxlX2dldF9jb250ZW50c1woWyciXWh0dHA6Ly93d3dcLmFza1wuY29tL3dlYlw/cT0iO2k6Mjk4O3M6MjY1OiJpZlwoIWVtcHR5XChccypcJF9GSUxFU1xbWyciXXswLDF9W2EtekEtWjAtOV9dK1snIl17MCwxfVxdXFtbJyJdezAsMX1bYS16QS1aMC05X10rWyciXXswLDF9XF1cKVwpe2NvcHlcKFwkX0ZJTEVTXFtbJyJdezAsMX1bYS16QS1aMC05X10rWyciXXswLDF9XF1cW1snIl17MCwxfVthLXpBLVowLTlfXStbJyJdezAsMX1cXSxcJF9GSUxFU1xbWyciXXswLDF9W2EtekEtWjAtOV9dK1snIl17MCwxfVxdXFtbJyJdezAsMX1bYS16QS1aMC05X10rWyciXXswLDF9XF1cKTt9IjtpOjI5OTtzOjIwNzoicmVnaXN0ZXJfc2h1dGRvd25fZnVuY3Rpb25ccypcKFxzKmNyZWF0ZV9mdW5jdGlvblwoXHMqQCpcJHtccypbJyJdezAsMX1bYS16QS1aMC05X10rWyciXXswLDF9XHMqfVxzKixccypAKlwke1xzKlsnIl1fKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClbJyJdXHMqfXtccypbJyJdezAsMX1bYS16QS1aMC05X10rWyciXXswLDF9XHMqfVxzKlwpXHMqXCk7IjtpOjMwMDtzOjI3NToiQCpmaWx0ZXJfdmFyXHMqXChAKlxzKlwke1snIl1fKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClbJyJdfXtbJyJdezAsMX1bYS16QS1aMC05X10rWyciXXswLDF9fVxzKixccypGSUxURVJfQ0FMTEJBQ0tccyosXHMqYXJyYXlccypcKFxzKlsnIl1bYS16QS1aMC05X10rWyciXVxzKj0+XHMqXCR7XHMqWyciXV8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVsnIl1ccyp9e1xzKlsnIl17MCwxfVthLXpBLVowLTlfXStbJyJdezAsMX1ccyp9XHMqXClccypcKVxzKjsiO2k6MzAxO3M6MjQxOiJpZlwoXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl17MCwxfVthLXpBLVowLTlfXStbJyJdezAsMX1cXSE9XCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl17MCwxfVthLXpBLVowLTlfXStbJyJdezAsMX1cXVwpe2V4dHJhY3RcKFwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXCk7XHMqdXNvcnRcKFwkW2EtekEtWjAtOV9dKyxcJFthLXpBLVowLTlfXStcKTt9IjtpOjMwMjtzOjIzODoiZGVjbGFyZVwoXHMqdGlja3M9XGQrXHMqXClccyo7QCpyZWdpc3Rlcl90aWNrX2Z1bmN0aW9uXChccypcJHtbJyJdXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpWyciXX1ccyp7WyciXXswLDF9W2EtekEtWjAtOV9dK1snIl17MCwxfX1ccyosXCR7WyciXXswLDF9XyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpWyciXXswLDF9fVxzKntbJyJdezAsMX1bYS16QS1aMC05X10rWyciXXswLDF9fVwpOyI7aTozMDM7czoxNDc6ImRlZmluZVwoW2EtekEtWjAtOV9dK1xzKixccypcJF9TRVJWRVJcW1thLXpBLVowLTlfXStcXVwpO1xzKkAqcmVnaXN0ZXJfc2h1dGRvd25fZnVuY3Rpb25cKFxzKmNyZWF0ZV9mdW5jdGlvblwoXCRbYS16QS1aMC05X10rLFthLXpBLVowLTlfXStcKVxzKlwpOyI7aTozMDQ7czozMDg6Ilwke1snIl17MCwxfVthLXpBLVowLTlfXStbJyJdezAsMX19PUAqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVCk7QCohXChAKlwke1snIl17MCwxfVthLXpBLVowLTlfXStbJyJdezAsMX19XFtcZCtcXSYmQCpcJHtAKlsnIl17MCwxfVthLXpBLVowLTlfXStbJyJdezAsMX19XFtcZCtcXVwpXD9cJHtAKlsnIl17MCwxfVthLXpBLVowLTlfXStbJyJdezAsMX19OkAqQCpcJHtbJyJdezAsMX1bYS16QS1aMC05X10rWyciXXswLDF9fVxbXGQrXF1cKEAqXCR7WyciXXswLDF9W2EtekEtWjAtOV9dK1snIl17MCwxfX1cW1xkK1xdXCk7IjtpOjMwNTtzOjg3OiJzZXRjb29raWVcKFsnIl1bYS16QS1aMC05X10rWyciXVxzKixccypzZXJpYWxpemVcKEAqXCRfPEdQQz5cW1snIl1bYS16QS1aMC05X10rWyciXVxdXCkiO2k6MzA2O3M6MjU6IjwvZGl2PlxzKjwlLS1Qb3J0U2Nhbi0tJT4iO2k6MzA3O3M6MTQ6IkdJRjg5Li4uPFw/cGhwIjtpOjMwODtzOjE3ODoiXCRbYS16QS1aMC05X10rXHMqPVxzKmZvcGVuXChbJyJdW2EtekEtWjAtOV9dK1wucGhwWyciXVxzKixccypbJyJdd1wrKlsnIl1cKTtccypmcHV0c1woXCRbYS16QS1aMC05X10rXHMqLFxzKlwkW2EtekEtWjAtOV9dK1wpO1xzKmZjbG9zZVwoXCRbYS16QS1aMC05X10rXCk7XHMqdW5saW5rXChfX0ZJTEVfX1wpOyI7aTozMDk7czozNDoiQ3JlYXRlSm9vbUNvZGVcKFwkW2EtekEtWjAtOV9dK1wpOyI7aTozMTA7czoyMzoiZnVuY3Rpb25ccytDcmVhdGVXcENvZGUiO2k6MzExO3M6Mzc6Ijxicj5bJyJdXC5waHBfdW5hbWVcKFwpXC5bJyJdPGJyPjwvYj4iO2k6MzEyO3M6NzM6ImlmXChcJFthLXpBLVowLTlfXStccyo9XHMqQCpzdHJwb3NcKFwkW2EtekEtWjAtOV9dKywiY2hlY2tfbWV0YVwoXCk7IlwpXCkiO2k6MzEzO3M6NTA6ImV2YWxccypcKCpccypAKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjMxNDtzOjUyOiJhc3NlcnRccypcKCpccypAKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjMxNTtzOjEwNjoiXGIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVxzKlwoKlxzKkAqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClccypcWyI7aTozMTY7czoxNzc6IjxiPmV2YWxccypcKFxzKlxiKGV2YWx8YmFzZTY0X2RlY29kZXxzdHJyZXZ8cHJlZ19yZXBsYWNlfHByZWdfcmVwbGFjZV9jYWxsYmFja3x1cmxkZWNvZGV8c3Ryc3RyfGd6aW5mbGF0ZXxzcHJpbnRmfGd6dW5jb21wcmVzc3xhc3NlcnR8c3RyX3JvdDEzfG1kNXxhcnJheV93YWxrfGFycmF5X2ZpbHRlcilccypcKCI7aTozMTc7czo3MjoiXGIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVxzKlwoKlxzKlsnIl13Z2V0IjtpOjMxODtzOjIxOiI9PVsnIl1cKVwpO3JldHVybjtcPz4iO2k6MzE5O3M6NzoidWdnYzovLyI7aTozMjA7czoxMDM6IlwkW2EtekEtWjAtOV9dK1xbXCRbYS16QS1aMC05X10rXF09Y2hyXChcJFthLXpBLVowLTlfXStcW29yZFwoXCRbYS16QS1aMC05X10rXFtcJFthLXpBLVowLTlfXStcXVwpXF1cKTsiO2k6MzIxO3M6NDY6IlwkW2EtekEtWjAtOV9dK1xbY2hyXChcZCtcKVxdXChbYS16QS1aMC05X10rXCgiO2k6MzIyO3M6MTQyOiJcJFthLXpBLVowLTlfXStccypcKFxzKlxkK1xzKlxeXHMqXGQrXHMqXClccypcLlxzKlwkW2EtekEtWjAtOV9dK1xzKlwoXHMqXGQrXHMqXF5ccypcZCtccypcKVxzKlwuXHMqXCRbYS16QS1aMC05X10rXHMqXChccypcZCtccypcXlxzKlxkK1xzKlwpIjtpOjMyMztzOjEwNDoiXGIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVwoWyciXXswLDF9XCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcWyIiO2k6MzI0O3M6OTQ6IlwkW2EtekEtWjAtOV9dKz1hcnJheVwoWyciXVwkW2EtekEtWjAtOV9dK1xbXHMqXF09YXJyYXlfcG9wXChcJFthLXpBLVowLTlfXStcKTtcJFthLXpBLVowLTlfXSsiO2k6MzI1O3M6MTA3OiJcJFthLXpBLVowLTlfXSs9cGFja1woWyciXUhcKlsnIl0sc3Vic3RyXChcJFthLXpBLVowLTlfXSssXHMqLVxkK1wpXCk7XHMqcmV0dXJuXHMrXCRbYS16QS1aMC05X10rXChzdWJzdHJcKCI7aTozMjY7czoxMzY6IlwkW2EtekEtWjAtOV9dK1xbWyciXXswLDF9W2EtekEtWjAtOV9dK1snIl17MCwxfVxdXFtbJyJdezAsMX1bYS16QS1aMC05X10rWyciXXswLDF9XF1cKFwkW2EtekEtWjAtOV9dKyxcJFthLXpBLVowLTlfXSssXCRbYS16QS1aMC05X10rXFsiO30="));
$gXX_FlexDBShe = unserialize(base64_decode("YTo0OTI6e2k6MDtzOjU0OiJcJFthLXpBLVowLTlfXSs9WyciXS9ob21lL1thLXpBLVowLTlfXSsvW2EtekEtWjAtOV9dKy8iO2k6MTtzOjQ0OiJccyo9XHMqaW5pX2dldFwoXHMqWyciXWRpc2FibGVfZnVuY3Rpb25zWyciXSI7aToyO3M6NDE6IlsnIl1maW5kXHMrL1xzKy10eXBlXHMrZlxzKy1wZXJtXHMrLTA0MDAwIjtpOjM7czo0MToiWyciXWZpbmRccysvXHMrLXR5cGVccytmXHMrLXBlcm1ccystMDIwMDAiO2k6NDtzOjQ1OiJbJyJdZmluZFxzKy9ccystdHlwZVxzK2ZccystbmFtZVxzK1wuaHRwYXNzd2QiO2k6NTtzOjI4OiJhbmRyb2lkXHxhdmFudGdvXHxibGFja2JlcnJ5IjtpOjY7czozNzoiaW5pX3NldFwoXHMqWyciXXswLDF9bWFnaWNfcXVvdGVzX2dwYyI7aTo3O3M6MTI6IlsnIl1sc1xzKy1sYSI7aTo4O3M6MTk6InJvdW5kXHMqXChccyowXHMqXCsiO2k6OTtzOjU5OiJiYXNlNjRfZGVjb2RlXHMqXCgqXHMqQCpcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKSI7aToxMDtzOjEyOiJbJyJdcm1ccystcmYiO2k6MTE7czoxMjoiWyciXXJtXHMrLWZyIjtpOjEyO3M6MTY6IlsnIl1ybVxzKy1yXHMrLWYiO2k6MTM7czoxNjoiWyciXXJtXHMrLWZccystciI7aToxNDtzOjEwOiJbJyJdYUhSMGNEIjtpOjE1O3M6OToia2lsbFxzKy05IjtpOjE2O3M6NTE6IkNVUkxPUFRfUkVGRVJFUixccypbJyJdezAsMX1odHRwczovL3d3d1wuZ29vZ2xlXC5jbyI7aToxNztzOjQzOiIoXFxbMC05XVswLTldWzAtOV18XFx4WzAtOWEtZl1bMC05YS1mXSl7Nyx9IjtpOjE4O3M6NDA6IihbXlw/XHNdKVwoezAsMX1cLltcK1wqXVwpezAsMX1cMlthLXpdKmUiO2k6MTk7czoxMzoiQGV4dHJhY3RccypcKCI7aToyMDtzOjEzOiJAZXh0cmFjdFxzKlwkIjtpOjIxO3M6MzE6IlwkYlxzKj1ccypjcmVhdGVfZnVuY3Rpb25cKFsnIl0iO2k6MjI7czo0MjoiPVxzKmNyZWF0ZV9mdW5jdGlvblwoWyciXXswLDF9XCRhWyciXXswLDF9IjtpOjIzO3M6NzA6Im1haWxcKFxzKlwkYVxbXGQrXF1ccyosXHMqXCRhXFtcZCtcXVxzKixccypcJGFcW1xkK1xdXHMqLFxzKlwkYVxbXGQrXF0iO2k6MjQ7czoyMToiZGlzYWJsZV9mdW5jdGlvbnNccyo9IjtpOjI1O3M6NzM6IlxibWFpbFwoXHMqXCRbYS16QS1aMC05X10rXHMqLFxzKlwkW2EtekEtWjAtOV9dK1xzKixccypcJFthLXpBLVowLTlfXStccyoiO2k6MjY7czoyOToiZm9wZW5cKFxzKlsnIl1cLlwuL1wuaHRhY2Nlc3MiO2k6Mjc7czoxNDoiIS91c3IvYmluL3BlcmwiO2k6Mjg7czo0NjoiQGVycm9yX3JlcG9ydGluZ1woMFwpO1xzKkBzZXRfdGltZV9saW1pdFwoMFwpOyI7aToyOTtzOjIyOiJydW5raXRfZnVuY3Rpb25fcmVuYW1lIjtpOjMwO3M6MTg0OiJcYihldmFsfGJhc2U2NF9kZWNvZGV8c3RycmV2fHByZWdfcmVwbGFjZXxwcmVnX3JlcGxhY2VfY2FsbGJhY2t8dXJsZGVjb2RlfHN0cnN0cnxnemluZmxhdGV8c3ByaW50ZnxnenVuY29tcHJlc3N8YXNzZXJ0fHN0cl9yb3QxM3xtZDV8YXJyYXlfd2Fsa3xhcnJheV9maWx0ZXIpXChccypcJFthLXpBLVowLTlfXStcKFxzKlwkIjtpOjMxO3M6NTc6IiRbYS16QS1aMC05X11ce1xkK1x9XHMqXC4kXHcrXHtcZCtcfVxzKlwuJFx3K1x7XGQrXH1ccypcLiI7aTozMjtzOjIzOiJcYmV2YWxcKFthLXpBLVowLTlfXStcKCI7aTozMztzOjI4OiJkaXNrX2ZyZWVfc3BhY2VcKFxzKlsnIl0vdG1wIjtpOjM0O3M6OToiUm9vdFNoZWxsIjtpOjM1O3M6MjQ6ImV2YWxcKFxzKlwkW2EtekEtWjAtOV9dKyI7aTozNjtzOjE0OiJCT1RORVRccytQQU5FTCI7aTozNztzOjE4OiI9PVxzKlsnIl00NlwuMjI5XC4iO2k6Mzg7czoxODoiPT1ccypbJyJdOTFcLjI0M1wuIjtpOjM5O3M6NToiSlRlcm0iO2k6NDA7czo1OiJPbmV0NyI7aTo0MTtzOjk6IlwkcGFzc191cCI7aTo0MjtzOjU6InhDZWR6IjtpOjQzO3M6MTE2OiJpZlxzKlwoXHMqZnVuY3Rpb25fZXhpc3RzXHMqXChccypbJyJdezAsMX1cYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pWyciXXswLDF9XHMqXClccypcKSI7aTo0NDtzOjI3OiJcJE9PTy4rPz1ccyp1cmxkZWNvZGVccypcKCoiO2k6NDU7czozODoic3RyZWFtX3NvY2tldF9jbGllbnRccypcKFxzKlsnIl10Y3A6Ly8iO2k6NDY7czoxNToicGNudGxfZXhlY1xzKlwoIjtpOjQ3O3M6MzE6Ij1ccyphcnJheV9tYXBccypcKCpccypzdHJyZXZccyoiO2k6NDg7czozMjoic3RyX2lyZXBsYWNlXHMqXCgqXHMqWyciXTwvaGVhZD4iO2k6NDk7czoyMzoiY29weVxzKlwoXHMqWyciXWh0dHA6Ly8iO2k6NTA7czoxOTA6Im1vdmVfdXBsb2FkZWRfZmlsZVxzKlwoKlxzKlwkX0ZJTEVTXFtccypbJyJdezAsMX1maWxlbmFtZVsnIl17MCwxfVxzKlxdXFtccypbJyJdezAsMX10bXBfbmFtZVsnIl17MCwxfVxzKlxdXHMqLFxzKlwkX0ZJTEVTXFtccypbJyJdezAsMX1maWxlbmFtZVsnIl17MCwxfVxzKlxdXFtccypbJyJdezAsMX1uYW1lWyciXXswLDF9XHMqXF0iO2k6NTE7czoyODoiZWNob1xzKlwoKlxzKlsnIl1OTyBGSUxFWyciXSI7aTo1MjtzOjE1OiJbJyJdL1wuXCovZVsnIl0iO2k6NTM7czo0ODc6IlxiKGV2YWx8YmFzZTY0X2RlY29kZXxzdHJyZXZ8cHJlZ19yZXBsYWNlfHByZWdfcmVwbGFjZV9jYWxsYmFja3x1cmxkZWNvZGV8c3Ryc3RyfGd6aW5mbGF0ZXxzcHJpbnRmfGd6dW5jb21wcmVzc3xhc3NlcnR8c3RyX3JvdDEzfG1kNXxhcnJheV93YWxrfGFycmF5X2ZpbHRlcilccypcKFxzKlxiKGV2YWx8YmFzZTY0X2RlY29kZXxzdHJyZXZ8cHJlZ19yZXBsYWNlfHByZWdfcmVwbGFjZV9jYWxsYmFja3x1cmxkZWNvZGV8c3Ryc3RyfGd6aW5mbGF0ZXxzcHJpbnRmfGd6dW5jb21wcmVzc3xhc3NlcnR8c3RyX3JvdDEzfG1kNXxhcnJheV93YWxrfGFycmF5X2ZpbHRlcilccypcKFxzKlxiKGV2YWx8YmFzZTY0X2RlY29kZXxzdHJyZXZ8cHJlZ19yZXBsYWNlfHByZWdfcmVwbGFjZV9jYWxsYmFja3x1cmxkZWNvZGV8c3Ryc3RyfGd6aW5mbGF0ZXxzcHJpbnRmfGd6dW5jb21wcmVzc3xhc3NlcnR8c3RyX3JvdDEzfG1kNXxhcnJheV93YWxrfGFycmF5X2ZpbHRlcikiO2k6NTQ7czo2NDoiZWNob1xzK3N0cmlwc2xhc2hlc1xzKlwoXHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcWyI7aTo1NTtzOjE1OiIvdXNyL3NiaW4vaHR0cGQiO2k6NTY7czo2NDoiPVxzKlwkR0xPQkFMU1xbXHMqWyciXV8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVsnIl1ccypcXSI7aTo1NztzOjE1OiJcJGF1dGhfcGFzc1xzKj0iO2k6NTg7czoyOToiZWNob1xzK1snIl17MCwxfWdvb2RbJyJdezAsMX0iO2k6NTk7czoyMjoiZXZhbFxzKlwoXHMqZ2V0X29wdGlvbiI7aTo2MDtzOjgwOiJXQlNfRElSXHMqXC5ccypbJyJdezAsMX10ZW1wL1snIl17MCwxfVxzKlwuXHMqXCRhY3RpdmVGaWxlXHMqXC5ccypbJyJdezAsMX1cLnRtcCI7aTo2MTtzOjgzOiJtb3ZlX3VwbG9hZGVkX2ZpbGVccypcKFxzKlwkX0ZJTEVTXFtbJyJdW2EtekEtWjAtOV9dK1snIl1cXVxbWyciXXRtcF9uYW1lWyciXVxdXHMqLCI7aTo2MjtzOjgxOiJtYWlsXChcJF9QT1NUXFtbJyJdezAsMX1lbWFpbFsnIl17MCwxfVxdLFxzKlwkX1BPU1RcW1snIl17MCwxfXN1YmplY3RbJyJdezAsMX1cXSwiO2k6NjM7czo3NzoibWFpbFxzKlwoXCRlbWFpbFxzKixccypbJyJdezAsMX09XD9VVEYtOFw/Qlw/WyciXXswLDF9XC5iYXNlNjRfZW5jb2RlXChcJGZyb20iO2k6NjQ7czo2MzoiXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClccypcW1xzKlthLXpBLVowLTlfXStccypcXVwoIjtpOjY1O3M6MTk6IlsnIl0vXGQrL1xbYS16XF1cKmUiO2k6NjY7czozODoiSlJlc3BvbnNlOjpzZXRCb2R5XHMqXChccypwcmVnX3JlcGxhY2UiO2k6Njc7czo1NjoiQCpmaWxlX3B1dF9jb250ZW50c1woXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVCkiO2k6Njg7czo5MToibWFpbFwoXHMqc3RyaXBzbGFzaGVzXChcJHRvXClccyosXHMqc3RyaXBzbGFzaGVzXChcJHN1YmplY3RcKVxzKixccypzdHJpcHNsYXNoZXNcKFwkbWVzc2FnZSI7aTo2OTtzOjYzOiJcJFthLXpBLVowLTlfXStccypcKFxzKlwkW2EtekEtWjAtOV9dK1xzKlwoXHMqXCRbYS16QS1aMC05X10rXCgiO2k6NzA7czoyMzoiaXNfd3JpdGFibGU9aXNfd3JpdGFibGUiO2k6NzE7czozODoiQG1vdmVfdXBsb2FkZWRfZmlsZVwoXHMqXCR1c2VyZmlsZV90bXAiO2k6NzI7czoyNjoiZXhpdFwoXCk6ZXhpdFwoXCk6ZXhpdFwoXCkiO2k6NzM7czo2NzoiXGIoaW5jbHVkZXxpbmNsdWRlX29uY2V8cmVxdWlyZXxyZXF1aXJlX29uY2UpXHMqXCgqXHMqWyciXS92YXIvdG1wLyI7aTo3NDtzOjE3OiI9XHMqWyciXS92YXIvdG1wLyI7aTo3NTtzOjU5OiJcKFxzKlwkc2VuZFxzKixccypcJHN1YmplY3RccyosXHMqXCRtZXNzYWdlXHMqLFxzKlwkaGVhZGVycyI7aTo3NjtzOjgzOiJcYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChbJyJdbHdwLWRvd25sb2FkXHMraHR0cDovLyI7aTo3NztzOjEwMToic3RyX3JlcGxhY2VcKFsnIl0uWyciXVxzKixccypbJyJdLlsnIl1ccyosXHMqc3RyX3JlcGxhY2VcKFsnIl0uWyciXVxzKixccypbJyJdLlsnIl1ccyosXHMqc3RyX3JlcGxhY2UiO2k6Nzg7czozNjoiL2FkbWluL2NvbmZpZ3VyYXRpb25cLnBocC9sb2dpblwucGhwIjtpOjc5O3M6NzE6InNlbGVjdFxzKmNvbmZpZ3VyYXRpb25faWQsXHMrY29uZmlndXJhdGlvbl90aXRsZSxccytjb25maWd1cmF0aW9uX3ZhbHVlIjtpOjgwO3M6NTA6InVwZGF0ZVxzKmNvbmZpZ3VyYXRpb25ccytzZXRccytjb25maWd1cmF0aW9uX3ZhbHVlIjtpOjgxO3M6Mzc6InNlbGVjdFxzKmxhbmd1YWdlc19pZCxccytuYW1lLFxzK2NvZGUiO2k6ODI7czo1MjoiY1wubGVuZ3RoXCk7fXJldHVyblxzKlxcWyciXVxcWyciXTt9aWZcKCFnZXRDb29raWVcKCI7aTo4MztzOjQ1OiJpZlwoZmlsZV9wdXRfY29udGVudHNcKFwkaW5kZXhfcGF0aCxccypcJGNvZGUiO2k6ODQ7czozNjoiZXhlY1xzK3tbJyJdL2Jpbi9zaFsnIl19XHMrWyciXS1iYXNoIjtpOjg1O3M6NTA6IjxpZnJhbWVccytzcmM9WyciXWh0dHBzOi8vZG9jc1wuZ29vZ2xlXC5jb20vZm9ybXMvIjtpOjg2O3M6MjI6IixbJyJdPFw/cGhwXFxuWyciXVwuXCQiO2k6ODc7czo3MjoiPFw/cGhwXHMrXGIoaW5jbHVkZXxpbmNsdWRlX29uY2V8cmVxdWlyZXxyZXF1aXJlX29uY2UpXHMqXChccypbJyJdL2hvbWUvIjtpOjg4O3M6MjI6InhydW1lcl9zcGFtX2xpbmtzXC50eHQiO2k6ODk7czozMzoiQ29tZmlybVxzK1RyYW5zYWN0aW9uXHMrUGFzc3dvcmQ6IjtpOjkwO3M6Nzc6ImFycmF5X21lcmdlXChcJGV4dFxzKixccyphcnJheVwoWyciXXdlYnN0YXRbJyJdLFsnIl1hd3N0YXRzWyciXSxbJyJddGVtcG9yYXJ5IjtpOjkxO3M6OTI6IlxiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilcKFsnIl1teXNxbGR1bXBccystaFxzK2xvY2FsaG9zdFxzKy11IjtpOjkyO3M6Mjg6Ik1vdGhlclsnIl1zXHMrTWFpZGVuXHMrTmFtZToiO2k6OTM7czozOToibG9jYXRpb25cLnJlcGxhY2VcKFxcWyciXVwkdXJsX3JlZGlyZWN0IjtpOjk0O3M6MzY6ImNobW9kXChkaXJuYW1lXChfX0ZJTEVfX1wpLFxzKjA1MTFcKSI7aTo5NTtzOjg1OiJcYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChbJyJdezAsMX1jdXJsXHMrLU9ccytodHRwOi8vIjtpOjk2O3M6Mjk6IlwpXCksUEhQX1ZFUlNJT04sbWQ1X2ZpbGVcKFwkIjtpOjk3O3M6NzU6IlwkW2EtekEtWjAtOV9dK1xbXCRbYS16QS1aMC05X10rXF1cW1wkW2EtekEtWjAtOV9dK1xbXGQrXF1cLlwkW2EtekEtWjAtOV9dKyI7aTo5ODtzOjM0OiJcJHF1ZXJ5XHMrLFxzK1snIl1mcm9tJTIwam9zX3VzZXJzIjtpOjk5O3M6MTU6ImV2YWxcKFsnIl1ccyovLyI7aToxMDA7czoxNjoiZXZhbFwoWyciXVxzKi9cKiI7aToxMDE7czoxMDQ6IlwkW2EtekEtWjAtOV9dK1xzKj1cJFthLXpBLVowLTlfXStccypcKFwkW2EtekEtWjAtOV9dK1xzKixccypcJFthLXpBLVowLTlfXStccypcKFsnIl1ccyp7XCRbYS16QS1aMC05X10rIjtpOjEwMjtzOjMxOiIhZXJlZ1woWyciXVxeXCh1bnNhZmVfcmF3XClcP1wkIjtpOjEwMztzOjM1OiJcJGJhc2VfZG9tYWluXHMqPVxzKmdldF9iYXNlX2RvbWFpbiI7aToxMDQ7czo5OiJzZXhzZXhzZXgiO2k6MTA1O3M6MjM6IlwrdW5pb25cK3NlbGVjdFwrMCwwLDAsIjtpOjEwNjtzOjM3OiJjb25jYXRcKDB4MjE3ZSxwYXNzd29yZCwweDNhLHVzZXJuYW1lIjtpOjEwNztzOjM0OiJncm91cF9jb25jYXRcKDB4MjE3ZSxwYXNzd29yZCwweDNhIjtpOjEwODtzOjU3OiJcKi9ccypcYihpbmNsdWRlfGluY2x1ZGVfb25jZXxyZXF1aXJlfHJlcXVpcmVfb25jZSlccyovXCoiO2k6MTA5O3M6ODoiYWJha28vQU8iO2k6MTEwO3M6NDg6ImlmXChccypzdHJwb3NcKFxzKlwkdmFsdWVccyosXHMqXCRtYXNrXHMqXClccypcKSI7aToxMTE7czoxMDY6InVubGlua1woXHMqXCRfU0VSVkVSXFtccypbJyJdezAsMX1ET0NVTUVOVF9ST09UWyciXXswLDF9XF1ccypcLlxzKlsnIl17MCwxfS9hc3NldHMvY2FjaGUvdGVtcC9GaWxlU2V0dGluZ3MiO2k6MTEyO3M6Mzg6InNldFRpbWVvdXRcKFxzKlsnIl1sb2NhdGlvblwucmVwbGFjZVwoIjtpOjExMztzOjQzOiJzdHJwb3NcKFwkaW1ccyosXHMqWyciXTxcP1snIl1ccyosXHMqXCRpXCsxIjtpOjExNDtzOjIwOiJcJF9SRVFVRVNUXFtbJyJdbGFsYSI7aToxMTU7czoyMzoiMFxzKlwoXHMqZ3p1bmNvbXByZXNzXCgiO2k6MTE2O3M6MTU6Imd6aW5mbGF0ZVwoXChcKCI7aToxMTc7czo0MjoiXCRrZXlccyo9XHMqXCRfR0VUXFtbJyJdezAsMX1xWyciXXswLDF9XF07IjtpOjExODtzOjI3OiJzdHJsZW5cKFxzKlwkcGF0aFRvRG9yXHMqXCkiO2k6MTE5O3M6NjQ6Imlzc2V0XChccypcJF9DT09LSUVcW1xzKm1kNVwoXHMqXCRfU0VSVkVSXFtccypbJyJdezAsMX1IVFRQX0hPU1QiO2k6MTIwO3M6Mjc6IkBjaGRpclwoXHMqXCRfUE9TVFxbXHMqWyciXSI7aToxMjE7czo4NDoiL2luZGV4XC5waHBcP29wdGlvbj1jb21fY29udGVudCZ2aWV3PWFydGljbGUmaWQ9WyciXVwuXCRwb3N0XFtbJyJdezAsMX1pZFsnIl17MCwxfVxdIjtpOjEyMjtzOjU1OiJcJG91dFxzKlwuPVxzKlwkdGV4dHtccypcJGlccyp9XHMqXF5ccypcJGtleXtccypcJGpccyp9IjtpOjEyMztzOjk6IkwzWmhjaTkzZCI7aToxMjQ7czo0Nzoic3RydG9sb3dlclwoXHMqc3Vic3RyXChccypcJHVzZXJfYWdlbnRccyosXHMqMCwiO2k6MTI1O3M6NDQ6ImNobW9kXChccypcJFtccyVcLkBcLVwrXChcKS9cd10rP1xzKixccyowNDA0IjtpOjEyNjtzOjQ0OiJjaG1vZFwoXHMqXCRbXHMlXC5AXC1cK1woXCkvXHddKz9ccyosXHMqMDc1NSI7aToxMjc7czo0MjoiQHVtYXNrXChccyowNzc3XHMqJlxzKn5ccypcJGZpbGVwZXJtaXNzaW9uIjtpOjEyODtzOjIzOiJbJyJdXHMqXHxccyovYmluL3NoWyciXSI7aToxMjk7czoxNjoiO1xzKi9iaW4vc2hccyotaSI7aToxMzA7czo0MToiaWZccypcKGZ1bmN0aW9uX2V4aXN0c1woXHMqWyciXXBjbnRsX2ZvcmsiO2k6MTMxO3M6MjY6Ij1ccypbJyJdc2VuZG1haWxccyotdFxzKi1mIjtpOjEzMjtzOjE1OiIvdG1wL3RtcC1zZXJ2ZXIiO2k6MTMzO3M6MTU6Ii90bXAvXC5JQ0UtdW5peCI7aToxMzQ7czoyOToiZXhlY1woXHMqWyciXS9iaW4vc2hbJyJdXHMqXCkiO2k6MTM1O3M6Mjc6IlwuXC4vXC5cLi9cLlwuL1wuXC4vbW9kdWxlcyI7aToxMzY7czozMzoidG91Y2hccypcKFxzKmRpcm5hbWVcKFxzKl9fRklMRV9fIjtpOjEzNztzOjQ5OiJAdG91Y2hccypcKFxzKlwkY3VyZmlsZVxzKixccypcJHRpbWVccyosXHMqXCR0aW1lIjtpOjEzODtzOjE4OiItXCotXHMqY29uZlxzKi1cKi0iO2k6MTM5O3M6NDQ6Im9wZW5ccypcKFxzKk1ZRklMRVxzKixccypbJyJdXHMqPlxzKnRhclwudG1wIjtpOjE0MDtzOjc0OiJcJHJldCA9IFwkdGhpcy0+X2RiLT51cGRhdGVPYmplY3RcKCBcJHRoaXMtPl90YmwsIFwkdGhpcywgXCR0aGlzLT5fdGJsX2tleSI7aToxNDE7czoxOToiZGllXChccypbJyJdbm8gY3VybCI7aToxNDI7czo1NDoic3Vic3RyXChccypcJHJlc3BvbnNlXHMqLFxzKlwkaW5mb1xbXHMqWyciXWhlYWRlcl9zaXplIjtpOjE0MztzOjEwODoiaWZcKFxzKiFzb2NrZXRfc2VuZHRvXChccypcJHNvY2tldFxzKixccypcJGRhdGFccyosXHMqc3RybGVuXChccypcJGRhdGFccypcKVxzKixccyowXHMqLFxzKlwkaXBccyosXHMqXCRwb3J0IjtpOjE0NDtzOjUwOiI8aW5wdXRccyt0eXBlPXN1Ym1pdFxzK3ZhbHVlPVVwbG9hZFxzKi8+XHMqPC9mb3JtPiI7aToxNDU7czo1ODoicm91bmRccypcKFxzKlwoXHMqXCRwYWNrZXRzXHMqXCpccyo2NVwpXHMqL1xzKjEwMjRccyosXHMqMiI7aToxNDY7czo1NzoiQGVycm9yX3JlcG9ydGluZ1woXHMqMFxzKlwpO1xzKmlmXHMqXChccyohaXNzZXRccypcKFxzKlwkIjtpOjE0NztzOjMwOiJlbHNlXHMqe1xzKmVjaG9ccypbJyJdZmFpbFsnIl0iO2k6MTQ4O3M6NTE6InR5cGU9WyciXXN1Ym1pdFsnIl1ccyp2YWx1ZT1bJyJdVXBsb2FkIGZpbGVbJyJdXHMqPiI7aToxNDk7czozNzoiaGVhZGVyXChccypbJyJdTG9jYXRpb246XHMqXCRsaW5rWyciXSI7aToxNTA7czozMToiZWNob1xzKlsnIl08Yj5VcGxvYWQ8c3M+U3VjY2VzcyI7aToxNTE7czo0MzoibmFtZT1bJyJddXBsb2FkZXJbJyJdXHMraWQ9WyciXXVwbG9hZGVyWyciXSI7aToxNTI7czoyMToiLUkvdXNyL2xvY2FsL2JhbmRtYWluIjtpOjE1MztzOjI0OiJ1bmxpbmtcKFxzKl9fRklMRV9fXHMqXCkiO2k6MTU0O3M6NTY6Im1haWxcKFxzKlwkYXJyXFtbJyJddG9bJyJdXF1ccyosXHMqXCRhcnJcW1snIl1zdWJqWyciXVxdIjtpOjE1NTtzOjEyNzoiaWZcKGlzc2V0XChcJF9SRVFVRVNUXFtbJyJdW2EtekEtWjAtOV9dK1snIl1cXVwpXClccyp7XHMqXCRbYS16QS1aMC05X10rXHMqPVxzKlwkX1JFUVVFU1RcW1snIl1bYS16QS1aMC05X10rWyciXVxdO1xzKmV4aXRcKFwpOyI7aToxNTY7czoxMzoibnVsbF9leHBsb2l0cyI7aToxNTc7czo0NjoiPFw/XHMqXCRbYS16QS1aMC05X10rXChccypcJFthLXpBLVowLTlfXStccypcKSI7aToxNTg7czo5OiJ0bXZhc3luZ3IiO2k6MTU5O3M6MTI6InRtaGFwYnpjZXJmZiI7aToxNjA7czoxMzoib25mcjY0X3FycGJxciI7aToxNjE7czoxNDoiWyciXW5mZnJlZ1snIl0iO2k6MTYyO3M6OToiZmdlX2ViZzEzIjtpOjE2MztzOjc6ImN1Y3Zhc2IiO2k6MTY0O3M6MTQ6IlsnIl1mbGZncnpbJyJdIjtpOjE2NTtzOjEyOiJbJyJdcmlueVsnIl0iO2k6MTY2O3M6OToiZXRhbGZuaXpnIjtpOjE2NztzOjEyOiJzc2VycG1vY251emciO2k6MTY4O3M6MTM6ImVkb2NlZF80NmVzYWIiO2k6MTY5O3M6MTQ6IlsnIl10cmVzc2FbJyJdIjtpOjE3MDtzOjE3OiJbJyJdMzF0b3JfcnRzWyciXSI7aToxNzE7czoxNToiWyciXW9mbmlwaHBbJyJdIjtpOjE3MjtzOjE0OiJbJyJdZmxmZ3J6WyciXSI7aToxNzM7czoxMjoiWyciXXJpbnlbJyJdIjtpOjE3NDtzOjQyOiJAXCRbYS16QS1aMC05X10rXChccypcJFthLXpBLVowLTlfXStccypcKTsiO2k6MTc1O3M6NDg6InBhcnNlX3F1ZXJ5X3N0cmluZ1woXHMqXCRFTlZ7XHMqWyciXVFVRVJZX1NUUklORyI7aToxNzY7czozMToiZXZhbFxzKlwoXHMqbWJfY29udmVydF9lbmNvZGluZyI7aToxNzc7czoyNDoiXClccyp7XHMqcGFzc3RocnVcKFxzKlwkIjtpOjE3ODtzOjE1OiJIVFRQX0FDQ0VQVF9BU0UiO2k6MTc5O3M6MjE6ImZ1bmN0aW9uXHMqQ3VybEF0dGFjayI7aToxODA7czoxODoiQHN5c3RlbVwoXHMqWyciXVwkIjtpOjE4MTtzOjIzOiJlY2hvXChccypodG1sXChccyphcnJheSI7aToxODI7czo1NjoiXCRjb2RlPVsnIl0lMXNjcmlwdFxzKnR5cGU9XFxbJyJddGV4dC9qYXZhc2NyaXB0XFxbJyJdJTMiO2k6MTgzO3M6MjI6ImFycmF5XChccypbJyJdJTFodG1sJTMiO2k6MTg0O3M6MTk6ImJ1ZGFrXHMqLVxzKmV4cGxvaXQiO2k6MTg1O3M6OTE6IlxiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilccypcKFxzKlsnIl1cJFthLXpBLVowLTlfXStbJyJdXHMqXCkiO2k6MTg2O3M6OToiR0FHQUw8L2I+IjtpOjE4NztzOjM4OiJleGl0XChbJyJdPHNjcmlwdD5kb2N1bWVudFwubG9jYXRpb25cLiI7aToxODg7czozNzoiZGllXChbJyJdPHNjcmlwdD5kb2N1bWVudFwubG9jYXRpb25cLiI7aToxODk7czozNjoic2V0X3RpbWVfbGltaXRcKFxzKmludHZhbFwoXHMqXCRhcmd2IjtpOjE5MDtzOjMzOiJlY2hvXHMqXCRwcmV3dWVcLlwkbG9nXC5cJHBvc3R3dWUiO2k6MTkxO3M6NDI6ImNvbm5ccyo9XHMqaHR0cGxpYlwuSFRUUENvbm5lY3Rpb25cKFxzKnVyaSI7aToxOTI7czozNjoiaWZccypcKFxzKlwkX1BPU1RcW1snIl17MCwxfWNobW9kNzc3IjtpOjE5MztzOjI2OiI8XD9ccyplY2hvXHMqXCRjb250ZW50O1w/PiI7aToxOTQ7czo4NDoiXCR1cmxccypcLj1ccypbJyJdXD9bYS16QS1aMC05X10rPVsnIl1ccypcLlxzKlwkX0dFVFxbXHMqWyciXVthLXpBLVowLTlfXStbJyJdXHMqXF07IjtpOjE5NTtzOjEwODoiY29weVwoXHMqXCRfRklMRVNcW1xzKlsnIl17MCwxfVthLXpBLVowLTlfXStbJyJdezAsMX1ccypcXVxbXHMqWyciXXswLDF9dG1wX25hbWVbJyJdezAsMX1ccypcXVxzKixccypcJF9QT1NUIjtpOjE5NjtzOjExNToibW92ZV91cGxvYWRlZF9maWxlXChccypcJF9GSUxFU1xbXHMqWyciXXswLDF9W2EtekEtWjAtOV9dK1snIl17MCwxfVxzKlxdXFtbJyJdezAsMX10bXBfbmFtZVsnIl17MCwxfVxdXFtccypcJGlccypcXSI7aToxOTc7czozMjoiZG5zX2dldF9yZWNvcmRcKFxzKlwkZG9tYWluXHMqXC4iO2k6MTk4O3M6MzQ6ImZ1bmN0aW9uX2V4aXN0c1xzKlwoXHMqWyciXWdldG14cnIiO2k6MTk5O3M6MjQ6Im5zbG9va3VwXC5leGVccyotdHlwZT1NWCI7aToyMDA7czoxMjoibmV3XHMqTUN1cmw7IjtpOjIwMTtzOjQ0OiJcJGZpbGVfZGF0YVxzKj1ccypbJyJdPHNjcmlwdFxzKnNyYz1bJyJdaHR0cCI7aToyMDI7czo0MDoiZnB1dHNcKFwkZnAsXHMqWyciXUlQOlxzKlwkaXBccyotXHMqREFURSI7aToyMDM7czoyODoiY2htb2RcKFxzKl9fRElSX19ccyosXHMqMDQwMCI7aToyMDQ7czo0MDoiQ29kZU1pcnJvclwuZGVmaW5lTUlNRVwoXHMqWyciXXRleHQvbWlyYyI7aToyMDU7czo0MzoiXF1ccypcKVxzKlwuXHMqWyciXVxcblw/PlsnIl1ccypcKVxzKlwpXHMqeyI7aToyMDY7czo2NzoiXCRnenBccyo9XHMqXCRiZ3pFeGlzdFxzKlw/XHMqQGd6b3BlblwoXCR0bXBmaWxlLFxzKlsnIl1yYlsnIl1ccypcKSI7aToyMDc7czo3NToiZnVuY3Rpb248c3M+c210cF9tYWlsXChcJHRvXHMqLFxzKlwkc3ViamVjdFxzKixccypcJG1lc3NhZ2VccyosXHMqXCRoZWFkZXJzIjtpOjIwODtzOjY0OiJcJF9QT1NUXFtbJyJdezAsMX1hY3Rpb25bJyJdezAsMX1cXVxzKj09XHMqWyciXWdldF9hbGxfbGlua3NbJyJdIjtpOjIwOTtzOjM4OiI9XHMqZ3ppbmZsYXRlXChccypiYXNlNjRfZGVjb2RlXChccypcJCI7aToyMTA7czo0MToiY2htb2RcKFwkZmlsZS0+Z2V0UGF0aG5hbWVcKFwpXHMqLFxzKjA3NzciO2k6MjExO3M6NjM6IlwkX1BPU1RcW1snIl17MCwxfXRwMlsnIl17MCwxfVxdXHMqXClccyphbmRccyppc3NldFwoXHMqXCRfUE9TVCI7aToyMTI7czoxMDk6ImhlYWRlclwoXHMqWyciXUNvbnRlbnQtVHlwZTpccyppbWFnZS9qcGVnWyciXVxzKlwpO1xzKnJlYWRmaWxlXChccypbJyJdW2EtekEtWjAtOV9dK1snIl1ccypcKTtccypleGl0XChccypcKTsiO2k6MjEzO3M6MzE6Ij0+XHMqQFwkZjJcKF9fRklMRV9fXHMqLFxzKlwkZjEiO2k6MjE0O3M6ODE6ImV2YWxcKFxzKlthLXpBLVowLTlfXStcKFxzKlwkW2EtekEtWjAtOV9dK1xzKixccypcJFthLXpBLVowLTlfXStccypcKVxzKlwpO1xzKlw/PiI7aToyMTU7czozNzoiaWZccypcKFxzKmlzX2NyYXdsZXIxXChccypcKVxzKlwpXHMqeyI7aToyMTY7czo0ODoiXCRlY2hvXzFcLlwkZWNob18yXC5cJGVjaG9fM1wuXCRlY2hvXzRcLlwkZWNob181IjtpOjIxNztzOjM1OiJmaWxlX2dldF9jb250ZW50c1woXHMqX19GSUxFX19ccypcKSI7aToyMTg7czo4MzoiQFxiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilcKFxzKkB1cmxlbmNvZGVcKFxzKlwkX1BPU1QiO2k6MjE5O3M6OTU6IlwkR0xPQkFMU1xbWyciXVthLXpBLVowLTlfXStbJyJdXF1cW1wkR0xPQkFMU1xbWyciXVthLXpBLVowLTlfXStbJyJdXF1cW1xkK1xdXChyb3VuZFwoXGQrXClcKVxdIjtpOjIyMDtzOjI1OiJmdW5jdGlvblxzK2Vycm9yXzQwNFwoXCl7IjtpOjIyMTtzOjY4OiJcYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXChccypbJyJdcGVybCI7aToyMjI7czo3MDoiXGIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVwoXHMqWyciXXB5dGhvbiI7aToyMjM7czo3MzoiaWZccypcKGlzc2V0XChcJF9HRVRcW1snIl1bYS16QS1aMC05X10rWyciXVxdXClcKVxzKntccyplY2hvXHMqWyciXW9rWyciXSI7aToyMjQ7czozOToicmVscGF0aHRvYWJzcGF0aFwoXHMqXCRfR0VUXFtccypbJyJdY3B5IjtpOjIyNTtzOjQ1OiJodHRwOi8vLis/Ly4rP1wucGhwXD9hPVxkKyZjPVthLXpBLVowLTlfXSsmcz0iO2k6MjI2O3M6MTY6ImZ1bmN0aW9uXHMrd3NvRXgiO2k6MjI3O3M6NTE6ImZvcmVhY2hcKFxzKlwkdG9zXHMqYXNccypcJHRvXClccyp7XHMqbWFpbFwoXHMqXCR0byI7aToyMjg7czoxMDI6ImhlYWRlclwoXHMqWyciXUNvbnRlbnQtVHlwZTpccyppbWFnZS9qcGVnWyciXVxzKlwpO1xzKnJlYWRmaWxlXChbJyJdaHR0cDovLy4rP1wuanBnWyciXVwpO1xzKmV4aXRcKFwpOyI7aToyMjk7czoxMjoiPFw/PVwkY2xhc3M7IjtpOjIzMDtzOjUwOiI8aW5wdXRccyp0eXBlPSJmaWxlIlxzKnNpemU9IlxkKyJccypuYW1lPSJ1cGxvYWQiPiI7aToyMzE7czoxMTA6IlwkbWVzc2FnZXNcW1xdXHMqPVxzKlwkX0ZJTEVTXFtccypbJyJdezAsMX11c2VyZmlsZVsnIl17MCwxfVxzKlxdXFtccypbJyJdezAsMX1uYW1lWyciXXswLDF9XHMqXF1cW1xzKlwkaVxzKlxdIjtpOjIzMjtzOjU1OiI8aW5wdXRccyp0eXBlPVsnIl1maWxlWyciXVxzKm5hbWU9WyciXXVzZXJmaWxlWyciXVxzKi8+IjtpOjIzMztzOjEzOiJEZXZhcnRccytIVFRQIjtpOjIzNDtzOjg3OiJAXCR7XHMqW2EtekEtWjAtOV9dK1xzKn1cKFxzKlsnIl1bJyJdXHMqLFxzKlwke1xzKlthLXpBLVowLTlfXStccyp9XChccypcJFthLXpBLVowLTlfXSsiO2k6MjM1O3M6OTI6IlwkR0xPQkFMU1xbXHMqWyciXXswLDF9W2EtekEtWjAtOV9dK1snIl17MCwxfVxzKlxdXChccypcJFthLXpBLVowLTlfXStcW1xzKlwkW2EtekEtWjAtOV9dK1xdIjtpOjIzNjtzOjUzOiJlcnJvcl9yZXBvcnRpbmdcKFxzKjBccypcKTtccypcJHVybFxzKj1ccypbJyJdaHR0cDovLyI7aToyMzc7czo1ODoiXCRbYS16QS1aMC05X10rXFtccypcZCtccyouXHMqXGQrXHMqXF1cKFxzKlthLXpBLVowLTlfXStcKCI7aToyMzg7czoxMjA6IlwkW2EtekEtWjAtOV9dKz1bJyJdaHR0cDovLy4rP1snIl07XHMqXCRbYS16QS1aMC05X10rPWZvcGVuXChcJFthLXpBLVowLTlfXSssWyciXXJbJyJdXCk7XHMqcmVhZGZpbGVcKFwkW2EtekEtWjAtOV9dK1wpOyI7aToyMzk7czo3NToiYXJyYXlcKFxzKlsnIl08IS0tWyciXVxzKlwuXHMqbWQ1XChccypcJHJlcXVlc3RfdXJsXHMqXC5ccypyYW5kXChcZCssXHMqXGQrIjtpOjI0MDtzOjE0OiJ3c29IZWFkZXJccypcKCI7aToyNDE7czo2OToiZWNob1woWyciXTxmb3JtIG1ldGhvZD1bJyJdcG9zdFsnIl1ccyplbmN0eXBlPVsnIl1tdWx0aXBhcnQvZm9ybS1kYXRhIjtpOjI0MjtzOjQzOiJmaWxlX2dldF9jb250ZW50c1woXHMqYmFzZTY0X2RlY29kZVwoXHMqXCRfIjtpOjI0MztzOjU4OiJyZWxwYXRodG9hYnNwYXRoXChccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbIjtpOjI0NDtzOjQwOiJtYWlsXChcJHRvXHMqLFxzKlsnIl0uKz9bJyJdXHMqLFxzKlwkdXJsIjtpOjI0NTtzOjUxOiJpZlxzKlwoXHMqIWZ1bmN0aW9uX2V4aXN0c1woXHMqWyciXXN5c19nZXRfdGVtcF9kaXIiO2k6MjQ2O3M6MTc6Ijx0aXRsZT5ccypWYVJWYVJhIjtpOjI0NztzOjM4OiJlbHNlaWZcKFxzKlwkc3FsdHlwZVxzKj09XHMqWyciXXNxbGl0ZSI7aToyNDg7czoxOToiPVsnIl1cKVxzKlwpO1xzKlw/PiI7aToyNDk7czoyNDoiZWNob1xzK2Jhc2U2NF9kZWNvZGVcKFwkIjtpOjI1MDtzOjUwOiJcI1thLXpBLVowLTlfXStcIy4rPzwvc2NyaXB0Pi4rP1wjL1thLXpBLVowLTlfXStcIyI7aToyNTE7czozNDoiZnVuY3Rpb25ccytfX2ZpbGVfZ2V0X3VybF9jb250ZW50cyI7aToyNTI7czo1NDoiXCRmXHMqPVxzKlwkZlxkK1woWyciXVsnIl1ccyosXHMqZXZhbFwoXCRbYS16QS1aMC05X10rIjtpOjI1MztzOjMyOiJldmFsXChcJGNvbnRlbnRcKTtccyplY2hvXHMqWyciXSI7aToyNTQ7czoyOToiQ1VSTE9QVF9VUkxccyosXHMqWyciXXNtdHA6Ly8iO2k6MjU1O3M6Nzc6IjxoZWFkPlxzKjxzY3JpcHQ+XHMqd2luZG93XC50b3BcLmxvY2F0aW9uXC5ocmVmPVsnIl0uKz9ccyo8L3NjcmlwdD5ccyo8L2hlYWQ+IjtpOjI1NjtzOjcwOiJcJFthLXpBLVowLTlfXStccyo9XHMqZm9wZW5cKFxzKlsnIl1bYS16QS1aMC05X10rXC5waHBbJyJdXHMqLFxzKlsnIl13IjtpOjI1NztzOjE2OiJAYXNzZXJ0XChccypbJyJdIjtpOjI1ODtzOjgyOiJcJFthLXpBLVowLTlfXSs9XCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1xzKlsnIl1kb1snIl1ccypcXTtccyppbmNsdWRlIjtpOjI1OTtzOjc3OiJlY2hvXHMrXCRbYS16QS1aMC05X10rO21rZGlyXChccypbJyJdW2EtekEtWjAtOV9dK1snIl1ccypcKTtmaWxlX3B1dF9jb250ZW50cyI7aToyNjA7czo2MToiXCRmcm9tXHMqPVxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtccypbJyJdZnJvbSI7aToyNjE7czoxOToiPVxzKnhkaXJcKFxzKlwkcGF0aCI7aToyNjI7czozMDoiXCRfW2EtekEtWjAtOV9dK1woXHMqXCk7XHMqXD8+IjtpOjI2MztzOjEwOiJ0YXJccystemNDIjtpOjI2NDtzOjgzOiJlY2hvXHMrc3RyX3JlcGxhY2VcKFxzKlsnIl1cW1BIUF9TRUxGXF1bJyJdXHMqLFxzKmJhc2VuYW1lXChcJF9TRVJWRVJcW1snIl1QSFBfU0VMRiI7aToyNjU7czo0MDoiZnVuY3Rpb25fZXhpc3RzXChccypbJyJdZlwkW2EtekEtWjAtOV9dKyI7aToyNjY7czo0MDoiXCRjdXJfY2F0X2lkXHMqPVxzKlwoXHMqaXNzZXRcKFxzKlwkX0dFVCI7aToyNjc7czozNToiaHJlZj1bJyJdPFw/cGhwXHMrZWNob1xzK1wkY3VyX3BhdGgiO2k6MjY4O3M6MzM6Ij1ccyplc2NfdXJsXChccypzaXRlX3VybFwoXHMqWyciXSI7aToyNjk7czo4NToiXlxzKjxcP3BocFxzKmhlYWRlclwoXHMqWyciXUxvY2F0aW9uOlxzKlsnIl1ccypcLlxzKlsnIl1ccypodHRwOi8vLis/WyciXVxzKlwpO1xzKlw/PiI7aToyNzA7czoxNDoiPHRpdGxlPlxzKml2bnoiO2k6MjcxO3M6NjM6Il5ccyo8XD9waHBccypoZWFkZXJcKFsnIl1Mb2NhdGlvbjpccypodHRwOi8vLis/WyciXVxzKlwpO1xzKlw/PiI7aToyNzI7czo2MToiZ2V0X3VzZXJzXChccyphcnJheVwoXHMqWyciXXJvbGVbJyJdXHMqPT5ccypbJyJdYWRtaW5pc3RyYXRvciI7aToyNzM7czo2NToiXCR0b1xzKj1ccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbXHMqWyciXXRvX2FkZHJlc3MiO2k6Mjc0O3M6MTk6ImltYXBfaGVhZGVyaW5mb1woXCQiO2k6Mjc1O3M6NTY6IlwkW2EtekEtWjAtOV9dK1xbXHMqX1thLXpBLVowLTlfXStcKFxzKlxkK1xzKlwpXHMqXF1ccyo9IjtpOjI3NjtzOjM0OiJldmFsXChccypbJyJdXD8+WyciXVxzKlwuXHMqam9pblwoIjtpOjI3NztzOjM1OiJiZWdpblxzK21vZDpccytUaGFua3Nccytmb3Jccytwb3N0cyI7aToyNzg7czozMToiWyciXVxzKlxeXHMqXCRbYS16QS1aMC05X10rXHMqOyI7aToyNzk7czo2NToiXCRbYS16QS1aMC05X10rXHMqXC5ccypcJFthLXpBLVowLTlfXStccypcXlxzKlwkW2EtekEtWjAtOV9dK1xzKjsiO2k6MjgwO3M6MTIwOiJpZlwoaXNzZXRcKFwkX1JFUVVFU1RcW1snIl1bYS16QS1aMC05X10rWyciXVxdXClccyomJlxzKm1kNVwoXCRfUkVRVUVTVFxbWyciXXswLDF9W2EtekEtWjAtOV9dK1snIl17MCwxfVxdXClccyo9PVxzKlsnIl0iO2k6MjgxO3M6MTI6Ilwud3d3Ly86cHR0aCI7aToyODI7czo2MzoiJTYzJTcyJTY5JTcwJTc0JTJFJTczJTcyJTYzJTNEJTI3JTY4JTc0JTc0JTcwJTNBJTJGJTJGJTczJTZGJTYxIjtpOjI4MztzOjI3OiJ3cC1vcHRpb25zXC5waHBccyo+XHMqRXJyb3IiO2k6Mjg0O3M6ODk6InN0cl9yZXBsYWNlXChhcnJheVwoWyciXWZpbHRlclN0YXJ0WyciXSxbJyJdZmlsdGVyRW5kWyciXVwpLFxzKmFycmF5XChbJyJdXCovWyciXSxbJyJdL1wqIjtpOjI4NTtzOjM3OiJmaWxlX2dldF9jb250ZW50c1woX19GSUxFX19cKSxcJG1hdGNoIjtpOjI4NjtzOjMwOiJ0b3VjaFwoXHMqZGlybmFtZVwoXHMqX19GSUxFX18iO2k6Mjg3O3M6MjE6Ilx8Ym90XHxzcGlkZXJcfHdnZXQvaSI7aToyODg7czo2Mjoic3RyX3JlcGxhY2VcKFsnIl08L2JvZHk+WyciXSxbYS16QS1aMC05X10rXC5bJyJdPC9ib2R5PlsnIl0sXCQiO2k6Mjg5O3M6MzQ6ImV4cGxvZGVcKFsnIl07dGV4dDtbJyJdLFwkcm93XFswXF0iO2k6MjkwO3M6OTA6Im1haWxcKFxzKnN0cmlwc2xhc2hlc1woXHMqXCRbYS16QS1aMC05X10rXHMqXClccyosXHMqc3RyaXBzbGFzaGVzXChccypcJFthLXpBLVowLTlfXStccypcKSI7aToyOTE7czoyMDg6Ij1ccyptYWlsXChccypzdHJpcHNsYXNoZXNcKFxzKlwkX1BPU1RcW1snIl17MCwxfVthLXpBLVowLTlfXStbJyJdezAsMX1cXVwpXHMqLFxzKnN0cmlwc2xhc2hlc1woXHMqXCRfUE9TVFxbWyciXXswLDF9W2EtekEtWjAtOV9dK1snIl17MCwxfVxdXClccyosXHMqc3RyaXBzbGFzaGVzXChccypcJF9QT1NUXFtbJyJdezAsMX1bYS16QS1aMC05X10rWyciXXswLDF9XF0iO2k6MjkyO3M6MTUzOiI9XHMqbWFpbFwoXHMqXCRfUE9TVFxbWyciXXswLDF9W2EtekEtWjAtOV9dK1snIl17MCwxfVxdXHMqLFxzKlwkX1BPU1RcW1snIl17MCwxfVthLXpBLVowLTlfXStbJyJdezAsMX1cXVxzKixccypcJF9QT1NUXFtbJyJdezAsMX1bYS16QS1aMC05X10rWyciXXswLDF9XF0iO2k6MjkzO3M6MTQ6IkxpYlhtbDJJc0J1Z2d5IjtpOjI5NDtzOjk6Im1hYWZccyt5YSI7aToyOTU7czozNDoiZWNobyBbYS16QS1aMC05X10rXHMqXChbJyJdaHR0cDovLyI7aToyOTY7czo0ODoiXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl1hc3N1bnRvIjtpOjI5NztzOjEyOiJgY2hlY2tzdWV4ZWMiO2k6Mjk4O3M6MTg6IndoaWNoXHMrc3VwZXJmZXRjaCI7aToyOTk7czo0NToicm1kaXJzXChcJGRpclxzKlwuXHMqWyciXS9bJyJdXHMqXC5ccypcJGNoaWxkIjtpOjMwMDtzOjQyOiJleHBsb2RlXChccypcXFsnIl07dGV4dDtcXFsnIl1ccyosXHMqXCRyb3ciO2k6MzAxO3M6Mzc6Ij1ccypbJyJdcGhwX3ZhbHVlXHMrYXV0b19wcmVwZW5kX2ZpbGUiO2k6MzAyO3M6MzU6ImlmXHMqXChccyppc193cml0YWJsZVwoXHMqXCR3d3dQYXRoIjtpOjMwMztzOjQ2OiJmb3BlblwoXHMqXCRbYS16QS1aMC05X10rXHMqXC5ccypbJyJdL3dwLWFkbWluIjtpOjMwNDtzOjIyOiJyZXR1cm5ccypbJyJdL3Zhci93d3cvIjtpOjMwNTtzOjE4NjoiXCRbYS16QS1aMC05X10rXHMqe1xzKlxkK1xzKn1cLlwkW2EtekEtWjAtOV9dK1xzKntccypcZCtccyp9XC5cJFthLXpBLVowLTlfXStccyp7XHMqXGQrXHMqfVwuXCRbYS16QS1aMC05X10rXHMqe1xzKlxkK1xzKn1cLlwkW2EtekEtWjAtOV9dK1xzKntccypcZCtccyp9XC5cJFthLXpBLVowLTlfXStccyp7XHMqXGQrXHMqfVwuIjtpOjMwNjtzOjE2OiJ0YWdzL1wkNi9cJDQvXCQ3IjtpOjMwNztzOjMwOiJzdHJfcmVwbGFjZVwoXHMqWyciXVwuaHRhY2Nlc3MiO2k6MzA4O3M6NDM6ImZ1bmN0aW9uXHMrX1xkK1woXHMqXCRbYS16QS1aMC05X10rXHMqXCl7XCQiO2k6MzA5O3M6MjE6ImV4cGxvZGVcKFxcWyciXTt0ZXh0OyI7aTozMTA7czoxMjM6InN1YnN0clwoXHMqXCRbYS16QS1aMC05X10rXHMqLFxzKlxkK1xzKixccypcZCtccypcKTtccypcJFthLXpBLVowLTlfXStccyo9XHMqcHJlZ19yZXBsYWNlXChccypcJFthLXpBLVowLTlfXStccyosXHMqc3RydHJcKCI7aTozMTE7czo2NjoiYXJyYXlfZmxpcFwoXHMqYXJyYXlfbWVyZ2VcKFxzKnJhbmdlXChccypbJyJdQVsnIl1ccyosXHMqWyciXVpbJyJdIjtpOjMxMjtzOjYzOiJcJF9TRVJWRVJcW1xzKlsnIl1ET0NVTUVOVF9ST09UWyciXVxzKlxdXHMqXC5ccypbJyJdL1wuaHRhY2Nlc3MiO2k6MzEzO3M6MzE6IlwkaW5zZXJ0X2NvZGVccyo9XHMqWyciXTxpZnJhbWUiO2k6MzE0O3M6NDE6ImFzc2VydF9vcHRpb25zXChccypBU1NFUlRfV0FSTklOR1xzKixccyowIjtpOjMxNTtzOjE1OiJNdXN0QGZAXHMrU2hlbGwiO2k6MzE2O3M6NjQ6ImV2YWxcKFxzKlwkW2EtekEtWjAtOV9dK1woXHMqXCRbYS16QS1aMC05X10rXChccypcJFthLXpBLVowLTlfXSsiO2k6MzE3O3M6MzQ6ImZ1bmN0aW9uX2V4aXN0c1woXHMqWyciXXBjbnRsX2ZvcmsiO2k6MzE4O3M6NDA6InN0cl9yZXBsYWNlXChbJyJdXC5odGFjY2Vzc1snIl1ccyosXHMqXCQiO2k6MzE5O3M6MzM6Ij1ccypAKmd6aW5mbGF0ZVwoXHMqc3RycmV2XChccypcJCI7aTozMjA7czoyMjoiZ1woXHMqWyciXUZpbGVzTWFuWyciXSI7aTozMjE7czoyODoic3RyX3JlcGxhY2VcKFsnIl0vXD9hbmRyWyciXSI7aTozMjI7czoyMDQ6IlwkW2EtekEtWjAtOV9dK1xzKj1ccypcJF9SRVFVRVNUXFtbJyJdezAsMX1bYS16QS1aMC05X10rWyciXXswLDF9XF07XHMqXCRbYS16QS1aMC05X10rXHMqPVxzKmFycmF5XChccypcJF9SRVFVRVNUXFtccypbJyJdezAsMX1bYS16QS1aMC05X10rWyciXXswLDF9XHMqXF1ccypcKTtccypcJFthLXpBLVowLTlfXStccyo9XHMqYXJyYXlfZmlsdGVyXChccypcJCI7aTozMjM7czoxMjg6IlwkW2EtekEtWjAtOV9dK1xzKlwuPVxzKlwkW2EtekEtWjAtOV9dK3tcZCt9XHMqXC5ccypcJFthLXpBLVowLTlfXSt7XGQrfVxzKlwuXHMqXCRbYS16QS1aMC05X10re1xkK31ccypcLlxzKlwkW2EtekEtWjAtOV9dK3tcZCt9IjtpOjMyNDtzOjc0OiJzdHJwb3NcKFwkbCxbJyJdTG9jYXRpb25bJyJdXCkhPT1mYWxzZVx8XHxzdHJwb3NcKFwkbCxbJyJdU2V0LUNvb2tpZVsnIl1cKSI7aTozMjU7czo5NzoiYWRtaW4vWyciXSxbJyJdYWRtaW5pc3RyYXRvci9bJyJdLFsnIl1hZG1pbjEvWyciXSxbJyJdYWRtaW4yL1snIl0sWyciXWFkbWluMy9bJyJdLFsnIl1hZG1pbjQvWyciXSI7aTozMjY7czoxNToiWyciXWNoZWNrc3VleGVjIjtpOjMyNztzOjU1OiJpZlxzKlwoXHMqXCR0aGlzLT5pdGVtLT5oaXRzXHMqPj1bJyJdXGQrWyciXVwpXHMqe1xzKlwkIjtpOjMyODtzOjQ3OiJleHBsb2RlXChbJyJdXFxuWyciXSxccypcJF9QT1NUXFtbJyJddXJsc1snIl1cXSI7aTozMjk7czoxMTQ6ImlmXChpbmlfZ2V0XChbJyJdYWxsb3dfdXJsX2ZvcGVuWyciXVwpXHMqPT1ccyoxXClccyp7XHMqXCRbYS16QS1aMC05X10rXHMqPVxzKmZpbGVfZ2V0X2NvbnRlbnRzXChcJFthLXpBLVowLTlfXStcKSI7aTozMzA7czoxMjI6ImlmXChccypcJGZwXHMqPVxzKmZzb2Nrb3BlblwoXCR1XFtbJyJdaG9zdFsnIl1cXSwhZW1wdHlcKFwkdVxbWyciXXBvcnRbJyJdXF1cKVxzKlw/XHMqXCR1XFtbJyJdcG9ydFsnIl1cXVxzKjpccyo4MFxzKlwpXCl7IjtpOjMzMTtzOjgzOiJpbmNsdWRlXChccypbJyJdZGF0YTp0ZXh0L3BsYWluO2Jhc2U2NFxzKixccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbOyI7aTozMzI7czoyMToiaW5jbHVkZVwoXHMqWyciXXpsaWI6IjtpOjMzMztzOjIxOiJpbmNsdWRlXChccypbJyJdL3RtcC8iO2k6MzM0O3M6NzA6IlwkZG9jXHMqPVxzKkpGYWN0b3J5OjpnZXREb2N1bWVudFwoXCk7XHMqXCRkb2MtPmFkZFNjcmlwdFwoWyciXWh0dHA6Ly8iO2k6MzM1O3M6MzA6IlwkZGVmYXVsdF91c2VfYWpheFxzKj1ccyp0cnVlOyI7aTozMzY7czoxMDoiZGVrY2FoWyciXSI7aTozMzc7czoyMzoic3Vic3RyXChtZDVcKHN0cnJldlwoXCQiO2k6MzM4O3M6MTM6Ij09WyciXVwpXHMqXC4iO2k6MzM5O3M6MTAzOiJpZlxzKlwoXHMqXChccypcJFthLXpBLVowLTlfXStccyo9XHMqc3RycnBvc1woXCRbYS16QS1aMC05X10rXHMqLFxzKlsnIl1cPz5bJyJdXHMqXClccypcKVxzKj09PVxzKmZhbHNlIjtpOjM0MDtzOjE1MzoiXCRfU0VSVkVSXFtbJyJdRE9DVU1FTlRfUk9PVFsnIl1ccypcLlxzKlsnIl0vWyciXVxzKlwuXHMqXCRbYS16QS1aMC05X10rXHMqXC5ccypbJyJdL1snIl1ccypcLlxzKlwkW2EtekEtWjAtOV9dK1xzKlwuXHMqWyciXS9bJyJdXHMqXC5ccypcJFthLXpBLVowLTlfXSssIjtpOjM0MTtzOjMwOiJmb3BlblxzKlwoXHMqWyciXWJhZF9saXN0XC50eHQiO2k6MzQyO3M6NDk6IkAqZmlsZV9nZXRfY29udGVudHNcKEAqYmFzZTY0X2RlY29kZVwoQCp1cmxkZWNvZGUiO2k6MzQzO3M6MjU6Ilwke1thLXpBLVowLTlfXSt9XChccypcKTsiO2k6MzQ0O3M6NjA6InN1YnN0clwoc3ByaW50ZlwoWyciXSVvWyciXSxccypmaWxlcGVybXNcKFwkZmlsZVwpXCksXHMqLTRcKSI7aTozNDU7czo1NToiXCRbYS16QS1aMC05X10rXChbJyJdWyciXVxzKixccypldmFsXChcJFthLXpBLVowLTlfXStcKSI7aTozNDY7czoxNjoid3NvU2VjUGFyYW1ccypcKCI7aTozNDc7czoxODoid2hpY2hccytzdXBlcmZldGNoIjtpOjM0ODtzOjY3OiJjb3B5XChccypbJyJdaHR0cDovLy4rP1wudHh0WyciXVxzKixccypbJyJdW2EtekEtWjAtOV9dK1wucGhwWyciXVwpIjtpOjM0OTtzOjI4OiJcJHNldGNvb2tccypcKTtzZXRjb29raWVcKFwkIjtpOjM1MDtzOjQ5MjoiQCpcYihldmFsfGJhc2U2NF9kZWNvZGV8c3RycmV2fHByZWdfcmVwbGFjZXxwcmVnX3JlcGxhY2VfY2FsbGJhY2t8dXJsZGVjb2RlfHN0cnN0cnxnemluZmxhdGV8c3ByaW50ZnxnenVuY29tcHJlc3N8YXNzZXJ0fHN0cl9yb3QxM3xtZDV8YXJyYXlfd2Fsa3xhcnJheV9maWx0ZXIpXHMqXChAKlxiKGV2YWx8YmFzZTY0X2RlY29kZXxzdHJyZXZ8cHJlZ19yZXBsYWNlfHByZWdfcmVwbGFjZV9jYWxsYmFja3x1cmxkZWNvZGV8c3Ryc3RyfGd6aW5mbGF0ZXxzcHJpbnRmfGd6dW5jb21wcmVzc3xhc3NlcnR8c3RyX3JvdDEzfG1kNXxhcnJheV93YWxrfGFycmF5X2ZpbHRlcilccypcKEAqXGIoZXZhbHxiYXNlNjRfZGVjb2RlfHN0cnJldnxwcmVnX3JlcGxhY2V8cHJlZ19yZXBsYWNlX2NhbGxiYWNrfHVybGRlY29kZXxzdHJzdHJ8Z3ppbmZsYXRlfHNwcmludGZ8Z3p1bmNvbXByZXNzfGFzc2VydHxzdHJfcm90MTN8bWQ1fGFycmF5X3dhbGt8YXJyYXlfZmlsdGVyKVxzKlwoIjtpOjM1MTtzOjQxOiJcLlxzKmJhc2U2NF9kZWNvZGVcKFxzKlwkaW5qZWN0XHMqXClccypcLiI7aTozNTI7czozOToiKGNoclwoW1xzXHdcJFxeXCtcLVwqL10rXClccypcLlxzKil7NCx9IjtpOjM1MztzOjQyOiI9XHMqQCpmc29ja29wZW5cKFxzKlwkYXJndlxbXGQrXF1ccyosXHMqODAiO2k6MzU0O3M6MzU6IlwuXC4vXC5cLi9lbmdpbmUvZGF0YS9kYmNvbmZpZ1wucGhwIjtpOjM1NTtzOjg1OiJyZWN1cnNlX2NvcHlcKFxzKlwkc3JjXHMqLFxzKlwkZHN0XHMqXCk7XHMqaGVhZGVyXChccypbJyJdbG9jYXRpb246XHMqXCRkc3RbJyJdXHMqXCk7IjtpOjM1NjtzOjE3OiJHYW50ZW5nZXJzXHMrQ3JldyI7aTozNTc7czoxNDM6IlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtbJyJdezAsMX1ccypbYS16QS1aMC05X10rXHMqWyciXXswLDF9XF1cKFxzKlsnIl17MCwxfVwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtccypbYS16QS1aMC05X10rIjtpOjM1ODtzOjQwOiJmd3JpdGVcKFwkW2EtekEtWjAtOV9dK1xzKixccypbJyJdPFw/cGhwIjtpOjM1OTtzOjU2OiJAKmNyZWF0ZV9mdW5jdGlvblwoXHMqWyciXVsnIl1ccyosXHMqQCpmaWxlX2dldF9jb250ZW50cyI7aTozNjA7czo5ODoiXF1cKFsnIl1cJF9bJyJdXHMqLFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtccypbJyJdezAsMX1bYS16QS1aMC05X10rWyciXXswLDF9XHMqXF0iO2k6MzYxO3M6Mzk6ImlmXHMqXChccyppc3NldFwoXHMqXCRfR0VUXFtccypbJyJdcGluZyI7aTozNjI7czozMDoicmVhZF9maWxlXChccypbJyJdZG9tYWluc1wudHh0IjtpOjM2MztzOjM2OiJldmFsXChccypbJyJde1xzKlwkW2EtekEtWjAtOV9dK1xzKn0iO2k6MzY0O3M6MTA4OiJpZlxzKlwoXHMqZmlsZV9leGlzdHNcKFxzKlwkW2EtekEtWjAtOV9dK1xzKlwpXHMqXClccyp7XHMqY2htb2RcKFxzKlwkW2EtekEtWjAtOV9dK1xzKixccyowXGQrXCk7XHMqfVxzKmVjaG8iO2k6MzY1O3M6MTE6Ij09WyciXVwpXCk7IjtpOjM2NjtzOjU1OiJcJFthLXpBLVowLTlfXSs9dXJsZGVjb2RlXChbJyJdLis/WyciXVwpO2lmXChwcmVnX21hdGNoIjtpOjM2NztzOjgwOiJcJFthLXpBLVowLTlfXStccyo9XHMqZGVjcnlwdF9TT1woXHMqXCRbYS16QS1aMC05X10rXHMqLFxzKlsnIl1bYS16QS1aMC05X10rWyciXSI7aTozNjg7czoxMDU6Ij1ccyptYWlsXChccypiYXNlNjRfZGVjb2RlXChccypcJFthLXpBLVowLTlfXStcW1xkK1xdXHMqXClccyosXHMqYmFzZTY0X2RlY29kZVwoXHMqXCRbYS16QS1aMC05X10rXFtcZCtcXSI7aTozNjk7czoyNjoiZXZhbFwoXHMqWyciXXJldHVyblxzK2V2YWwiO2k6MzcwO3M6OTQ6Ij1ccypiYXNlNjRfZW5jb2RlXChccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbWyciXVthLXpBLVowLTlfXStbJyJdXF1cKTtccypoZWFkZXIiO2k6MzcxO3M6MTA3OiJAaW5pX3NldFwoWyciXWVycm9yX2xvZ1snIl0sTlVMTFwpO1xzKkBpbmlfc2V0XChbJyJdbG9nX2Vycm9yc1snIl0sMFwpO1xzKmZ1bmN0aW9uXHMrcmVhZF9maWxlXChcJGZpbGVfbmFtZSI7aTozNzI7czozNzoiXCR0ZXh0XHMqPVxzKmh0dHBfZ2V0XChccypbJyJdaHR0cDovLyI7aTozNzM7czoxNDM6IlwkW2EtekEtWjAtOV9dK1xzKj1ccypzdHJfcmVwbGFjZVwoWyciXTwvYm9keT5bJyJdXHMqLFxzKlsnIl1bJyJdXHMqLFxzKlwkW2EtekEtWjAtOV9dK1wpO1xzKlwkW2EtekEtWjAtOV9dK1xzKj1ccypzdHJfcmVwbGFjZVwoWyciXTwvaHRtbD5bJyJdIjtpOjM3NDtzOjE1ODoiXCNbYS16QS1aMC05X10rXCNccyppZlwoZW1wdHlcKFwkW2EtekEtWjAtOV9dK1wpXClccyp7XHMqXCRbYS16QS1aMC05X10rXHMqPVxzKlsnIl08c2NyaXB0Lis/PC9zY3JpcHQ+WyciXTtccyplY2hvXHMrXCRbYS16QS1aMC05X10rO1xzKn1ccypcIy9bYS16QS1aMC05X10rXCMiO2k6Mzc1O3M6NjY6IlwuXCRfUkVRVUVTVFxbXHMqWyciXVthLXpBLVowLTlfXStbJyJdXHMqXF1ccyosXHMqdHJ1ZVxzKixccyozMDJcKSI7aTozNzY7czoxMDQ6Ij1ccypjcmVhdGVfZnVuY3Rpb25ccypcKFxzKm51bGxccyosXHMqW2EtekEtWjAtOV9dK1woXHMqXCRbYS16QS1aMC05X10rXHMqXClccypcKTtccypcJFthLXpBLVowLTlfXStcKFwpIjtpOjM3NztzOjU0OiI9XHMqZmlsZV9nZXRfY29udGVudHNcKFsnIl1odHRwcyo6Ly9cZCtcLlxkK1wuXGQrXC5cZCsiO2k6Mzc4O3M6NTc6IkNvbnRlbnQtdHlwZTpccyphcHBsaWNhdGlvbi92bmRcLmFuZHJvaWRcLnBhY2thZ2UtYXJjaGl2ZSI7aTozNzk7czoyMDoic2x1cnBcfG1zbmJvdFx8dGVvbWEiO2k6MzgwO3M6Mjc6IlwkR0xPQkFMU1xbbmV4dFxdXFtbJyJdbmV4dCI7aTozODE7czoxNzk6IjtAKlwkW2EtekEtWjAtOV9dK1woXGIoZXZhbHxiYXNlNjRfZGVjb2RlfHN0cnJldnxwcmVnX3JlcGxhY2V8cHJlZ19yZXBsYWNlX2NhbGxiYWNrfHVybGRlY29kZXxzdHJzdHJ8Z3ppbmZsYXRlfHNwcmludGZ8Z3p1bmNvbXByZXNzfGFzc2VydHxzdHJfcm90MTN8bWQ1fGFycmF5X3dhbGt8YXJyYXlfZmlsdGVyKVwoIjtpOjM4MjtzOjI5OiJoZWFkZXJcKF9bYS16QS1aMC05X10rXChcZCtcKSI7aTozODM7czoxODM6ImlmXHMqXChpc3NldFwoXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl1bYS16QS1aMC05X10rWyciXVxdXClccyomJlxzKm1kNVwoXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl1bYS16QS1aMC05X10rWyciXVxdXClccyo9PT1ccypbJyJdW2EtekEtWjAtOV9dK1snIl1cKSI7aTozODQ7czo5MDoiXC49XHMqY2hyXChcJFthLXpBLVowLTlfXStccyo+PlxzKlwoXGQrXHMqXCpccypcKFxkK1xzKi1ccypcJFthLXpBLVowLTlfXStcKVwpXHMqJlxzKlxkK1wpIjtpOjM4NTtzOjMxOiItPnByZXBhcmVcKFsnIl1TSE9XXHMrREFUQUJBU0VTIjtpOjM4NjtzOjIzOiJzb2Nrc19zeXNyZWFkXChcJGNsaWVudCI7aTozODc7czoyNDoiPCVldmFsXChccypSZXF1ZXN0XC5JdGVtIjtpOjM4ODtzOjk5OiJcJF9QT1NUXFtbJyJdW2EtekEtWjAtOV9dK1snIl1cXTtccypcJFthLXpBLVowLTlfXStccyo9XHMqZm9wZW5cKFxzKlwkX0dFVFxbWyciXVthLXpBLVowLTlfXStbJyJdXF0iO2k6Mzg5O3M6NDA6InVybD1bJyJdaHR0cDovL3NjYW40eW91XC5uZXQvcmVtb3RlXC5waHAiO2k6MzkwO3M6NjA6ImNhbGxfdXNlcl9mdW5jXChccypcJFthLXpBLVowLTlfXStccyosXHMqXCRbYS16QS1aMC05X10rXCk7fSI7aTozOTE7czo3MzoicHJlZ19yZXBsYWNlXChccypbJyJdLy4rPy9lWyciXVxzKixccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKSI7aTozOTI7czoxMDY6Ij1ccypmaWxlX2dldF9jb250ZW50c1woXHMqWyciXS4rP1snIl1cKTtccypcJFthLXpBLVowLTlfXStccyo9XHMqZm9wZW5cKFxzKlwkW2EtekEtWjAtOV9dK1xzKixccypbJyJdd1snIl0iO2k6MzkzO3M6NTk6ImlmXChccypcJFthLXpBLVowLTlfXStcKVxzKntccypldmFsXChcJFthLXpBLVowLTlfXStcKTtccyp9IjtpOjM5NDtzOjE3OToiYXJyYXlfbWFwXChccypbJyJdXGIoZXZhbHxiYXNlNjRfZGVjb2RlfHN0cnJldnxwcmVnX3JlcGxhY2V8cHJlZ19yZXBsYWNlX2NhbGxiYWNrfHVybGRlY29kZXxzdHJzdHJ8Z3ppbmZsYXRlfHNwcmludGZ8Z3p1bmNvbXByZXNzfGFzc2VydHxzdHJfcm90MTN8bWQ1fGFycmF5X3dhbGt8YXJyYXlfZmlsdGVyKVsnIl0iO2k6Mzk1O3M6MTgxOiI9XHMqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl1bYS16QS1aMC05X10rWyciXVxdO1xzKlwkW2EtekEtWjAtOV9dK1xzKj1ccypmaWxlX3B1dF9jb250ZW50c1woXHMqXCRbYS16QS1aMC05X10rXHMqLFxzKmZpbGVfZ2V0X2NvbnRlbnRzXChccypcJFthLXpBLVowLTlfXStccypcKVxzKlwpIjtpOjM5NjtzOjYxOiI8XD9ccypcJFthLXpBLVowLTlfXSs9WyciXS4rP1snIl07XHMqaGVhZGVyXHMqXChbJyJdTG9jYXRpb246IjtpOjM5NztzOjI1OiI8IS0tXCNleGVjXHMrY21kXHMqPVxzKlwkIjtpOjM5ODtzOjgxOiJpZlwoXHMqc3RyaXBvc1woXHMqXCRbYS16QS1aMC05X10rXHMqLFxzKlsnIl1hbmRyb2lkWyciXVxzKlwpXHMqIT09XHMqZmFsc2VcKVxzKnsiO2k6Mzk5O3M6OTA6IlwuPVxzKlsnIl08ZGl2XHMrc3R5bGU9WyciXWRpc3BsYXk6bm9uZTtbJyJdPlsnIl1ccypcLlxzKlwkW2EtekEtWjAtOV9dK1xzKlwuXHMqWyciXTwvZGl2PiI7aTo0MDA7czoxMTQ6Ij1maWxlX2V4aXN0c1woXCRbYS16QS1aMC05X10rXClcP0BmaWxlbXRpbWVcKFwkW2EtekEtWjAtOV9dK1wpOlwkW2EtekEtWjAtOV9dKztAZmlsZV9wdXRfY29udGVudHNcKFwkW2EtekEtWjAtOV9dKyI7aTo0MDE7czo4OToiXCRbYS16QS1aMC05X10rXHMqXFtccypbYS16QS1aMC05X10rXHMqXF1cKFxzKlwkW2EtekEtWjAtOV9dK1xbXHMqW2EtekEtWjAtOV9dK1xzKlxdXHMqXCkiO2k6NDAyO3M6OTY6IlwkW2EtekEtWjAtOV9dKyxbJyJdc2x1cnBbJyJdXClccyohPT1ccypmYWxzZVxzKlx8XHxccypzdHJwb3NcKFxzKlwkW2EtekEtWjAtOV9dKyxbJyJdc2VhcmNoWyciXSI7aTo0MDM7czo2MzoiXCRbYS16QS1aMC05X10rXChccypcJFthLXpBLVowLTlfXStcKFxzKlwkW2EtekEtWjAtOV9dK1wpXHMqXCk7IjtpOjQwNDtzOjE3OiJjbGFzc1xzK01DdXJsXHMqeyI7aTo0MDU7czo1NjoiQGluaV9zZXRcKFsnIl1kaXNwbGF5X2Vycm9yc1snIl0sMFwpO1xzKkBlcnJvcl9yZXBvcnRpbmciO2k6NDA2O3M6Njk6ImlmXChccypmaWxlX2V4aXN0c1woXHMqXCRmaWxlcGF0aFxzKlwpXHMqXClccyp7XHMqZWNob1xzK1snIl11cGxvYWRlZCI7aTo0MDc7czozMDoicmV0dXJuXHMrUkM0OjpFbmNyeXB0XChcJGEsXCRiIjtpOjQwODtzOjMyOiJmdW5jdGlvblxzK2dldEhUVFBQYWdlXChccypcJHVybCI7aTo0MDk7czoyMToiPVxzKnJlcXVlc3RcKFxzKmNoclwoIjtpOjQxMDtzOjU1OiI7XHMqYXJyYXlfZmlsdGVyXChcJFthLXpBLVowLTlfXStccyosXHMqYmFzZTY0X2RlY29kZVwoIjtpOjQxMTtzOjIyODoiY2FsbF91c2VyX2Z1bmNcKFxzKlsnIl1cYihldmFsfGJhc2U2NF9kZWNvZGV8c3RycmV2fHByZWdfcmVwbGFjZXxwcmVnX3JlcGxhY2VfY2FsbGJhY2t8dXJsZGVjb2RlfHN0cnN0cnxnemluZmxhdGV8c3ByaW50ZnxnenVuY29tcHJlc3N8YXNzZXJ0fHN0cl9yb3QxM3xtZDV8YXJyYXlfd2Fsa3xhcnJheV9maWx0ZXIpWyciXVxzKixccypcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKVxbIjtpOjQxMjtzOjI0MToiY2FsbF91c2VyX2Z1bmNfYXJyYXlcKFxzKlsnIl1cYihldmFsfGJhc2U2NF9kZWNvZGV8c3RycmV2fHByZWdfcmVwbGFjZXxwcmVnX3JlcGxhY2VfY2FsbGJhY2t8dXJsZGVjb2RlfHN0cnN0cnxnemluZmxhdGV8c3ByaW50ZnxnenVuY29tcHJlc3N8YXNzZXJ0fHN0cl9yb3QxM3xtZDV8YXJyYXlfd2Fsa3xhcnJheV9maWx0ZXIpWyciXVxzKixccyphcnJheVwoXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcWyI7aTo0MTM7czo4NzoiaWYgXCghKlwkX1NFUlZFUlxbWyciXUhUVFBfVVNFUl9BR0VOVFsnIl1cXVxzKk9SXHMqXChzdWJzdHJcKFwkX1NFUlZFUlxbWyciXVJFTU9URV9BRERSIjtpOjQxNDtzOjUzOiJyZWxwYXRodG9hYnNwYXRoXChcJF8oR0VUfFBPU1R8U0VSVkVSfENPT0tJRXxSRVFVRVNUKSI7aTo0MTU7czo2ODoiXCRkYXRhXFtbJyJdY2NfZXhwX21vbnRoWyciXVxdXHMqLFxzKnN1YnN0clwoXCRkYXRhXFtbJyJdY2NfZXhwX3llYXIiO2k6NDE2O3M6NDA6IlwkW2EtekEtWjAtOV9dK1xzKihcWy57MSw0MH1cXSl7MSx9XHMqXCgiO2k6NDE3O3M6MzM6ImNhbGxfdXNlcl9mdW5jXChccypAKnVuaGV4XChccyoweCI7aTo0MTg7czoyOToiXC5cLjo6XFtccypwaHByb3h5XHMqXF06OlwuXC4iO2k6NDE5O3M6NDQ6IlsnIl1ccypcLlxzKmNoclwoXHMqXGQrLlxkK1xzKlwpXHMqXC5ccypbJyJdIjtpOjQyMDtzOjMyOiJwcmVnX3JlcGxhY2UuKj8vZVsnIl1ccyosXHMqWyciXSI7aTo0MjE7czo4NToiXCRbYS16QS1aMC05X10rXChcJFthLXpBLVowLTlfXStcKFwkW2EtekEtWjAtOV9dK1woXCRbYS16QS1aMC05X10rXChcJFthLXpBLVowLTlfXStcKSI7aTo0MjI7czoyMzoifWV2YWxcKGJ6ZGVjb21wcmVzc1woXCQiO2k6NDIzO3M6NTg6Ii91c3IvbG9jYWwvcHNhL2FwYWNoZS9iaW4vaHR0cGRccystREZST05UUEFHRVxzKy1ESEFWRV9TU0wiO2k6NDI0O3M6NTc6Imljb252XChiYXNlNjRfZGVjb2RlXChbJyJdLis/WyciXVwpXHMqLFxzKmJhc2U2NF9kZWNvZGVcKCI7aTo0MjU7czozMzoiPGJyPlsnIl1cLnBocF91bmFtZVwoXClcLlsnIl08YnI+IjtpOjQyNjtzOjY2OiJcKTtAXCRbYS16QS1aMC05X10rXFtjaHJcKFxkK1wpXF1cKFwkW2EtekEtWjAtOV9dK1xbY2hyXChcZCtcKVxdXCgiO2k6NDI3O3M6MTA5OiJcYihmb3BlbnxmaWxlX2dldF9jb250ZW50c3xmaWxlX3B1dF9jb250ZW50c3xzdGF0fGNobW9kfGZpbGV8c3ltbGluaylcKFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjQyODtzOjk1OiJcYihmb3BlbnxmaWxlX2dldF9jb250ZW50c3xmaWxlX3B1dF9jb250ZW50c3xzdGF0fGNobW9kfGZpbGV8c3ltbGluaylcKFsnIl1odHRwOi8vcGFzdGViaW5cLmNvbSI7aTo0Mjk7czoxMDk6IjtcJFthLXpBLVowLTlfXSs9XCRbYS16QS1aMC05X10rXChcJFthLXpBLVowLTlfXSssXCRbYS16QS1aMC05X10rXCk7XCRbYS16QS1aMC05X10rXChcJFthLXpBLVowLTlfXStcKTtccypcPz4iO2k6NDMwO3M6ODM6IlwkX1NFUlZFUlxbWyciXVJFUVVFU1RfVVJJWyciXVxdXCksWyciXVthLXpBLVowLTlfXStbJyJdXClcKXtccyppbmNsdWRlXChnZXRjd2RcKFwpIjtpOjQzMTtzOjg0OiJ3cF9zZXRfYXV0aF9jb29raWVcKFwkdXNlcl9pZFwpO1xzKmRvX2FjdGlvblwoWyciXXdwX2xvZ2luWyciXVxzKixccypcJHVzZXJfbG9naW5cKTsiO2k6NDMyO3M6NTI6ImFycmF5X2RpZmZfdWtleVwoXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVCkiO2k6NDMzO3M6NjA6Ij1mb3BlblwoYmFzZTY0X2RlY29kZVwoXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcWyI7aTo0MzQ7czoxOToiLWV4ZWMgdG91Y2ggLWFjbSAtciI7aTo0MzU7czoyMzQ6IlwkW2EtekEtWjAtOV9dK1xzKlwuPVxzKnN1YnN0clwoXCRbYS16QS1aMC05X10rLFxzKlwkW2EtekEtWjAtOV9dK1xzKlwrXHMqXGQrLFxzKlwkR0xPQkFMU1xbWyciXVthLXpBLVowLTlfXStbJyJdXF1cKFwkW2EtekEtWjAtOV9dK1xbXCRbYS16QS1aMC05X10rXF1cKVwpO1xzKlwkW2EtekEtWjAtOV9dK1xzKlwrPVxzKlwkR0xPQkFMU1xbWyciXVthLXpBLVowLTlfXStbJyJdXF1cKFwkW2EtekEtWjAtOV9dKyI7aTo0MzY7czo4MDoibW92ZV91cGxvYWRlZF9maWxlXChccypcJGltYWdlLFxzKmRpcm5hbWVcKF9fRklMRV9fXClccypcLlxzKlsnIl0vWyciXVxzKlwuXHMqXCQiO2k6NDM3O3M6Mzk6Ilwkc3RyPSI8aDE+NDAzIEZvcmJpZGRlbjwvaDE+PCEtLSB0b2tlbiI7aTo0Mzg7czo2OToiQCppbmNsdWRlX29uY2VccypcKFxzKmRpcm5hbWVcKF9fRklMRV9fXClccypcLlxzKicvJ1xzKlwuXHMqdXJsZGVjb2RlIjtpOjQzOTtzOjExMzoiXCRsb2NhbHBhdGg9Z2V0ZW52XCgiU0NSSVBUX05BTUUiXCk7XCRhYnNvbHV0ZXBhdGg9Z2V0ZW52XCgiU0NSSVBUX0ZJTEVOQU1FIlwpO1wkcm9vdF9wYXRoPXN1YnN0clwoXCRhYnNvbHV0ZXBhdGgiO2k6NDQwO3M6MTI1OiJcJHRwbFxzKj1ccypcJHRwbF9wYXRoXD9ccypAZmlsZV9nZXRfY29udGVudHNcKFwkcm9vdF9wYXRoXC5cJHRwbF9wYXRoXCk6XHMqWyciXVsnIl07XHMqaWYgXChzdHJwb3NcKFwkdHBsLFxzKlsnIl1cW0NPTlRFTlRcXSI7aTo0NDE7czoxNToiWyciXS9ldGMvcGFzc3dkIjtpOjQ0MjtzOjE1OiJbJyJdL3Zhci9jcGFuZWwiO2k6NDQzO3M6MTQ6IlsnIl0vZXRjL2h0dHBkIjtpOjQ0NDtzOjIwOiJbJyJdL2V0Yy9uYW1lZFwuY29uZiI7aTo0NDU7czoxMzoiODlcLjI0OVwuMjFcLiI7aTo0NDY7czoxNToiMTA5XC4yMzhcLjI0MlwuIjtpOjQ0NztzOjkxOiJcYihpbmNsdWRlfGluY2x1ZGVfb25jZXxyZXF1aXJlfHJlcXVpcmVfb25jZSlccypcKCpccypAKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpIjtpOjQ0ODtzOjY1OiJcYihpbmNsdWRlfGluY2x1ZGVfb25jZXxyZXF1aXJlfHJlcXVpcmVfb25jZSlccypcKCpccypbJyJdaW1hZ2VzLyI7aTo0NDk7czo3MToiXGIoZnRwX2V4ZWN8c3lzdGVtfHNoZWxsX2V4ZWN8cGFzc3RocnV8cG9wZW58cHJvY19vcGVuKVxzKlwoQCp1cmxlbmNvZGUiO2k6NDUwO3M6NzE6IlxiKGZ0cF9leGVjfHN5c3RlbXxzaGVsbF9leGVjfHBhc3N0aHJ1fHBvcGVufHByb2Nfb3BlbilcKCpbJyJdY2RccysvdG1wIjtpOjQ1MTtzOjMyNzoiXGIoZXZhbHxiYXNlNjRfZGVjb2RlfHN0cnJldnxwcmVnX3JlcGxhY2V8cHJlZ19yZXBsYWNlX2NhbGxiYWNrfHVybGRlY29kZXxzdHJzdHJ8Z3ppbmZsYXRlfHNwcmludGZ8Z3p1bmNvbXByZXNzfGFzc2VydHxzdHJfcm90MTN8bWQ1fGFycmF5X3dhbGt8YXJyYXlfZmlsdGVyKVxzKlwoXHMqXGIoZXZhbHxiYXNlNjRfZGVjb2RlfHN0cnJldnxwcmVnX3JlcGxhY2V8cHJlZ19yZXBsYWNlX2NhbGxiYWNrfHVybGRlY29kZXxzdHJzdHJ8Z3ppbmZsYXRlfHNwcmludGZ8Z3p1bmNvbXByZXNzfGFzc2VydHxzdHJfcm90MTN8bWQ1fGFycmF5X3dhbGt8YXJyYXlfZmlsdGVyKVxzKlwoIjtpOjQ1MjtzOjIzOiIvdmFyL3FtYWlsL2Jpbi9zZW5kbWFpbCI7aTo0NTM7czo1MToiXCRbYS16QS1aMC05X10rID0gXCRbYS16QS1aMC05X10rXChbJyJdezAsMX1odHRwOi8vIjtpOjQ1NDtzOjEzNjoiXGIoaW5jbHVkZXxpbmNsdWRlX29uY2V8cmVxdWlyZXxyZXF1aXJlX29uY2UpXHMqXCgqXHMqXCRfU0VSVkVSXFtbJyJdezAsMX1ET0NVTUVOVF9ST09UWyciXXswLDF9XF1ccypcLlxzKlsnIl1bXHMlXC5AXC1cK1woXCkvXHddKz9cLmpwZyI7aTo0NTU7czoxMzY6IlxiKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKlwoKlxzKlwkX1NFUlZFUlxbWyciXXswLDF9RE9DVU1FTlRfUk9PVFsnIl17MCwxfVxdXHMqXC5ccypbJyJdW1xzJVwuQFwtXCtcKFwpL1x3XSs/XC5naWYiO2k6NDU2O3M6MTM2OiJcYihpbmNsdWRlfGluY2x1ZGVfb25jZXxyZXF1aXJlfHJlcXVpcmVfb25jZSlccypcKCpccypcJF9TRVJWRVJcW1snIl17MCwxfURPQ1VNRU5UX1JPT1RbJyJdezAsMX1cXVxzKlwuXHMqWyciXVtccyVcLkBcLVwrXChcKS9cd10rP1wucG5nIjtpOjQ1NztzOjEwNjoiXGIoaW5jbHVkZXxpbmNsdWRlX29uY2V8cmVxdWlyZXxyZXF1aXJlX29uY2UpXHMqXCgqXHMqWyciXVtccyVcLkBcLVwrXChcKS9cd10rPy9bXHMlXC5AXC1cK1woXCkvXHddKz9cLnBuZyI7aTo0NTg7czoxMDY6IlxiKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKlwoKlxzKlsnIl1bXHMlXC5AXC1cK1woXCkvXHddKz8vW1xzJVwuQFwtXCtcKFwpL1x3XSs/XC5qcGciO2k6NDU5O3M6MTA2OiJcYihpbmNsdWRlfGluY2x1ZGVfb25jZXxyZXF1aXJlfHJlcXVpcmVfb25jZSlccypcKCpccypbJyJdW1xzJVwuQFwtXCtcKFwpL1x3XSs/L1tccyVcLkBcLVwrXChcKS9cd10rP1wuZ2lmIjtpOjQ2MDtzOjEwNjoiXGIoaW5jbHVkZXxpbmNsdWRlX29uY2V8cmVxdWlyZXxyZXF1aXJlX29uY2UpXHMqXCgqXHMqWyciXVtccyVcLkBcLVwrXChcKS9cd10rPy9bXHMlXC5AXC1cK1woXCkvXHddKz9cLmljbyI7aTo0NjE7czoxMDg6IlxiKGluY2x1ZGV8aW5jbHVkZV9vbmNlfHJlcXVpcmV8cmVxdWlyZV9vbmNlKVxzKlwoXHMqZGlybmFtZVwoXHMqX19GSUxFX19ccypcKVxzKlwuXHMqWyciXS93cC1jb250ZW50L3VwbG9hZCI7aTo0NjI7czo2NzoiXGIoaW5jbHVkZXxpbmNsdWRlX29uY2V8cmVxdWlyZXxyZXF1aXJlX29uY2UpXHMqXCgqXHMqWyciXS92YXIvd3d3LyI7aTo0NjM7czo2NDoiXGIoaW5jbHVkZXxpbmNsdWRlX29uY2V8cmVxdWlyZXxyZXF1aXJlX29uY2UpXHMqXCgqXHMqWyciXS9ob21lLyI7aTo0NjQ7czoxODk6IlxiKGV2YWx8YmFzZTY0X2RlY29kZXxzdHJyZXZ8cHJlZ19yZXBsYWNlfHByZWdfcmVwbGFjZV9jYWxsYmFja3x1cmxkZWNvZGV8c3Ryc3RyfGd6aW5mbGF0ZXxzcHJpbnRmfGd6dW5jb21wcmVzc3xhc3NlcnR8c3RyX3JvdDEzfG1kNXxhcnJheV93YWxrfGFycmF5X2ZpbHRlcilcKGZpbGVfZ2V0X2NvbnRlbnRzXChbJyJdaHR0cDovLyI7aTo0NjU7czoyMzE6IlxiKGV2YWx8YmFzZTY0X2RlY29kZXxzdHJyZXZ8cHJlZ19yZXBsYWNlfHByZWdfcmVwbGFjZV9jYWxsYmFja3x1cmxkZWNvZGV8c3Ryc3RyfGd6aW5mbGF0ZXxzcHJpbnRmfGd6dW5jb21wcmVzc3xhc3NlcnR8c3RyX3JvdDEzfG1kNXxhcnJheV93YWxrfGFycmF5X2ZpbHRlcilcKFwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtbJyJdezAsMX1bYS16QS1aMC05X10rWyciXXswLDF9XF1cKSI7aTo0NjY7czoxNToiWyciXVwpXClcKTsiXCk7IjtpOjQ2NztzOjkyOiJcJFthLXpBLVowLTlfXSs9WyciXVthLXpBLVowLTkvXCtcPV9dK1snIl07XHMqZWNob1xzK2Jhc2U2NF9kZWNvZGVcKFwkW2EtekEtWjAtOV9dK1wpO1xzKlw/PiI7aTo0Njg7czo2MjoiXCRbYS16QS1aMC05X10rLT5fc2NyaXB0c1xbXHMqZ3p1bmNvbXByZXNzXChccypiYXNlNjRfZGVjb2RlXCgiO2k6NDY5O3M6MzQ6IlwkW2EtekEtWjAtOV9dK1xzKj1ccypbJyJdZXZhbFsnIl0iO2k6NDcwO3M6NDM6IlwkW2EtekEtWjAtOV9dK1xzKj1ccypbJyJdYmFzZTY0X2RlY29kZVsnIl0iO2k6NDcxO3M6NDU6IlwkW2EtekEtWjAtOV9dK1xzKj1ccypbJyJdY3JlYXRlX2Z1bmN0aW9uWyciXSI7aTo0NzI7czozNjoiXCRbYS16QS1aMC05X10rXHMqPVxzKlsnIl1hc3NlcnRbJyJdIjtpOjQ3MztzOjQyOiJcJFthLXpBLVowLTlfXStccyo9XHMqWyciXXByZWdfcmVwbGFjZVsnIl0iO2k6NDc0O3M6MjE2OiJcJFthLXpBLVowLTlfXStcW1xzKlxkK1xzKlxdXHMqXC5ccypcJFthLXpBLVowLTlfXStcW1xzKlxkK1xzKlxdXHMqXC5ccypcJFthLXpBLVowLTlfXStcW1xzKlxkK1xzKlxdXHMqXC5ccypcJFthLXpBLVowLTlfXStcW1xzKlxkK1xzKlxdXHMqXC5ccypcJFthLXpBLVowLTlfXStcW1xzKlxkK1xzKlxdXHMqXC5ccypcJFthLXpBLVowLTlfXStcW1xzKlxkK1xzKlxdXHMqXC5ccyoiO2k6NDc1O3M6MTUwOiJcJFthLXpBLVowLTlfXStcW1xzKlwkW2EtekEtWjAtOV9dK1xzKlxdXFtccypcJFthLXpBLVowLTlfXStcW1xzKlxkK1xzKlxdXHMqXC5ccypcJFthLXpBLVowLTlfXStcW1xzKlxkK1xzKlxdXHMqXC5ccypcJFthLXpBLVowLTlfXStcW1xzKlxkK1xzKlxdXHMqXC4iO2k6NDc2O3M6NDM6IlwkW2EtekEtWjAtOV9dK1xzKlwoXHMqXCRbYS16QS1aMC05X10rXHMqXFsiO2k6NDc3O3M6NjM6IlwkW2EtekEtWjAtOV9dK1xzKlwoXHMqXCRbYS16QS1aMC05X10rXHMqXChccypcJFthLXpBLVowLTlfXStcWyI7aTo0Nzg7czo1MDoiXCRbYS16QS1aMC05X10rXHMqXChccypcJFthLXpBLVowLTlfXStccypcKFxzKlsnIl0iO2k6NDc5O3M6NzA6IlwkW2EtekEtWjAtOV9dK1xzKlwoXHMqXCRbYS16QS1aMC05X10rXHMqXChccypcJFthLXpBLVowLTlfXStccypcKVxzKiwiO2k6NDgwO3M6Njk6IlwkW2EtekEtWjAtOV9dK1xzKlwoXHMqWyciXVsnIl1ccyosXHMqZXZhbFwoXCRbYS16QS1aMC05X10rXHMqXClccypcKSI7aTo0ODE7czoyMzY6IlwkW2EtekEtWjAtOV9dK1xzKj1ccypcJFthLXpBLVowLTlfXStcKFsnIl1bJyJdXHMqLFxzKlwkW2EtekEtWjAtOV9dK1woXHMqXCRbYS16QS1aMC05X10rXChccypbJyJdW2EtekEtWjAtOV9dK1snIl1ccyosXHMqWyciXVsnIl1ccyosXHMqXCRbYS16QS1aMC05X10rXHMqXC5ccypcJFthLXpBLVowLTlfXStccypcLlxzKlwkW2EtekEtWjAtOV9dK1xzKlwuXHMqXCRbYS16QS1aMC05X10rXHMqXClccypcKVxzKlwpIjtpOjQ4MjtzOjE0MzoiXCRbYS16QS1aMC05X10rXHMqPVxzKlsnIl1cJFthLXpBLVowLTlfXSs9QFthLXpBLVowLTlfXStcKFsnIl0uKz9bJyJdXCk7W2EtekEtWjAtOV9dK1woIVwkW2EtekEtWjAtOV9dK1wpe1wkW2EtekEtWjAtOV9dKz1AW2EtekEtWjAtOV9dK1woXHMqXCkiO2k6NDgzO3M6MTE0OiJcJFthLXpBLVowLTlfXStcW1xzKlxkK1xzKlxdXChccypbJyJdWyciXVxzKixccypcJFthLXpBLVowLTlfXStcW1xzKlxkK1xzKlxdXChccypcJFthLXpBLVowLTlfXStcW1xzKlxkK1xzKlxdXHMqXCkiO2k6NDg0O3M6MzI6IlwkW2EtekEtWjAtOV9dK1woXHMqQFwkX0NPT0tJRVxbIjtpOjQ4NTtzOjI5OiJcJFthLXpBLVowLTlfXStcKFsnIl0uLmVbJyJdLCI7aTo0ODY7czo3MDoiQFwkW2EtekEtWjAtOV9dKyYmQFwkW2EtekEtWjAtOV9dK1woXCRbYS16QS1aMC05X10rLFwkW2EtekEtWjAtOV9dK1wpOyI7aTo0ODc7czoyMjg6IlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtccypbJyJdW2EtekEtWjAtOV9dK1snIl1ccypcXVwoXHMqXGIoZXZhbHxiYXNlNjRfZGVjb2RlfHN0cnJldnxwcmVnX3JlcGxhY2V8cHJlZ19yZXBsYWNlX2NhbGxiYWNrfHVybGRlY29kZXxzdHJzdHJ8Z3ppbmZsYXRlfHNwcmludGZ8Z3p1bmNvbXByZXNzfGFzc2VydHxzdHJfcm90MTN8bWQ1fGFycmF5X3dhbGt8YXJyYXlfZmlsdGVyKSI7aTo0ODg7czoxODY6IlxiKGV2YWx8YmFzZTY0X2RlY29kZXxzdHJyZXZ8cHJlZ19yZXBsYWNlfHByZWdfcmVwbGFjZV9jYWxsYmFja3x1cmxkZWNvZGV8c3Ryc3RyfGd6aW5mbGF0ZXxzcHJpbnRmfGd6dW5jb21wcmVzc3xhc3NlcnR8c3RyX3JvdDEzfG1kNXxhcnJheV93YWxrfGFycmF5X2ZpbHRlcilcKFxzKlwkW2EtekEtWjAtOV9dK1woXHMqWyciXSI7aTo0ODk7czoyMjc6IkAqXCRfKEdFVHxQT1NUfFNFUlZFUnxDT09LSUV8UkVRVUVTVClcW1snIl1bYS16QS1aMC05X10rWyciXVxdXChcYihldmFsfGJhc2U2NF9kZWNvZGV8c3RycmV2fHByZWdfcmVwbGFjZXxwcmVnX3JlcGxhY2VfY2FsbGJhY2t8dXJsZGVjb2RlfHN0cnN0cnxnemluZmxhdGV8c3ByaW50ZnxnenVuY29tcHJlc3N8YXNzZXJ0fHN0cl9yb3QxM3xtZDV8YXJyYXlfd2Fsa3xhcnJheV9maWx0ZXIpXChbJyJdIjtpOjQ5MDtzOjE4MToiXCRbYS16QS1aMC05X10rPVwkW2EtekEtWjAtOV9dK1woWyciXS4rP1snIl0sXCRbYS16QS1aMC05X10rLFwkW2EtekEtWjAtOV9dK1wpO1wkW2EtekEtWjAtOV9dKz1cJFthLXpBLVowLTlfXStcKFwkW2EtekEtWjAtOV9dKyxcJFthLXpBLVowLTlfXStcKTtcJFthLXpBLVowLTlfXStcKFwkW2EtekEtWjAtOV9dK1wpOyI7aTo0OTE7czo2NjoiPVxbIidcXVwuezEsMTB9XD9cWyciXF1cW1xcXF4mXHxcXVxbJyJcXVwuezEsMTB9XD9cWyciXF1cWztcXFwuL1xdIjt9"));
$g_ExceptFlex = unserialize(base64_decode("YToxNDM6e2k6MDtzOjM3OiJlY2hvICI8c2NyaXB0PiBhbGVydFwoJyJcLlwkZGItPmdldEVyIjtpOjE7czo0MDoiZWNobyAiPHNjcmlwdD4gYWxlcnRcKCciXC5cJG1vZGVsLT5nZXRFciI7aToyO3M6ODoic29ydFwoXCkiO2k6MztzOjEwOiJtdXN0LXJldmFsIjtpOjQ7czo2OiJyaWV2YWwiO2k6NTtzOjk6ImRvdWJsZXZhbCI7aTo2O3M6NjY6InJlcXVpcmVccypcKCpccypcJF9TRVJWRVJcW1xzKlsnIl17MCwxfURPQ1VNRU5UX1JPT1RbJyJdezAsMX1ccypcXSI7aTo3O3M6NzE6InJlcXVpcmVfb25jZVxzKlwoKlxzKlwkX1NFUlZFUlxbXHMqWyciXXswLDF9RE9DVU1FTlRfUk9PVFsnIl17MCwxfVxzKlxdIjtpOjg7czo2NjoiaW5jbHVkZVxzKlwoKlxzKlwkX1NFUlZFUlxbXHMqWyciXXswLDF9RE9DVU1FTlRfUk9PVFsnIl17MCwxfVxzKlxdIjtpOjk7czo3MToiaW5jbHVkZV9vbmNlXHMqXCgqXHMqXCRfU0VSVkVSXFtccypbJyJdezAsMX1ET0NVTUVOVF9ST09UWyciXXswLDF9XHMqXF0iO2k6MTA7czoxNzoiXCRzbWFydHktPl9ldmFsXCgiO2k6MTE7czozMDoicHJlcFxzK3JtXHMrLXJmXHMrJXtidWlsZHJvb3R9IjtpOjEyO3M6MjI6IlRPRE86XHMrcm1ccystcmZccyt0aGUiO2k6MTM7czoyNzoia3Jzb3J0XChcJHdwc21pbGllc3RyYW5zXCk7IjtpOjE0O3M6NjM6ImRvY3VtZW50XC53cml0ZVwodW5lc2NhcGVcKCIlM0NzY3JpcHQgc3JjPSciIFwrIGdhSnNIb3N0IFwrICJnbyI7aToxNTtzOjY6IlwuZXhlYyI7aToxNjtzOjg6ImV4ZWNcKFwpIjtpOjE3O3M6MjI6IlwkeDE9XCR0aGlzLT53IC0gXCR4MTsiO2k6MTg7czozMToiYXNvcnRcKFwkQ2FjaGVEaXJPbGRGaWxlc0FnZVwpOyI7aToxOTtzOjEzOiJcKCdyNTdzaGVsbCcsIjtpOjIwO3M6MjM6ImV2YWxcKCJsaXN0ZW5lcj0iXCtsaXN0IjtpOjIxO3M6ODoiZXZhbFwoXCkiO2k6MjI7czozMzoicHJlZ19yZXBsYWNlX2NhbGxiYWNrXCgnL1xce1woaW1hIjtpOjIzO3M6MjA6ImV2YWxcKF9jdE1lbnVJbml0U3RyIjtpOjI0O3M6Mjk6ImJhc2U2NF9kZWNvZGVcKFwkYWNjb3VudEtleVwpIjtpOjI1O3M6Mzg6ImJhc2U2NF9kZWNvZGVcKFwkZGF0YVwpXCk7XCRhcGktPnNldFJlIjtpOjI2O3M6NDg6InJlcXVpcmVcKFwkX1NFUlZFUlxbXFwiRE9DVU1FTlRfUk9PVFxcIlxdXC5cXCIvYiI7aToyNztzOjY0OiJiYXNlNjRfZGVjb2RlXChcJF9SRVFVRVNUXFsncGFyYW1ldGVycydcXVwpO2lmXChDaGVja1NlcmlhbGl6ZWREIjtpOjI4O3M6NjE6InBjbnRsX2V4ZWMnPT4gQXJyYXlcKEFycmF5XCgxXCksXCRhclJlc3VsdFxbJ1NFQ1VSSU5HX0ZVTkNUSU8iO2k6Mjk7czozOToiZWNobyAiPHNjcmlwdD5hbGVydFwoJyJcLkNVdGlsOjpKU0VzY2FwIjtpOjMwO3M6NjY6ImJhc2U2NF9kZWNvZGVcKFwkX1JFUVVFU1RcWyd0aXRsZV9jaGFuZ2VyX2xpbmsnXF1cKTtpZlwoc3RybGVuXChcJCI7aTozMTtzOjQ0OiJldmFsXCgnXCRoZXhkdGltZT0iJ1wuXCRoZXhkdGltZVwuJyI7J1wpO1wkZiI7aTozMjtzOjUyOiJlY2hvICI8c2NyaXB0PmFsZXJ0XCgnXCRyb3ctPnRpdGxlIC0gIlwuX01PRFVMRV9JU19FIjtpOjMzO3M6Mzc6ImVjaG8gIjxzY3JpcHQ+YWxlcnRcKCdcJGNpZHMgIlwuX0NBTk4iO2k6MzQ7czozNzoiaWZcKDFcKXtcJHZfaG91cj1cKFwkcF9oZWFkZXJcWydtdGltZSI7aTozNTtzOjY4OiJkb2N1bWVudFwud3JpdGVcKHVuZXNjYXBlXCgiJTNDc2NyaXB0JTIwc3JjPSUyMmh0dHAiIFwrXChcKCJodHRwczoiPSI7aTozNjtzOjU3OiJkb2N1bWVudFwud3JpdGVcKHVuZXNjYXBlXCgiJTNDc2NyaXB0IHNyYz0nIiBcKyBwa0Jhc2VVUkwiO2k6Mzc7czozMjoiZWNobyAiPHNjcmlwdD5hbGVydFwoJyJcLkpUZXh0OjoiO2k6Mzg7czoyNDoiJ2ZpbGVuYW1lJ1wpLFwoJ3I1N3NoZWxsIjtpOjM5O3M6Mzk6ImVjaG8gIjxzY3JpcHQ+YWxlcnRcKCciXC5cJGVyck1zZ1wuIidcKSI7aTo0MDtzOjQyOiJlY2hvICI8c2NyaXB0PmFsZXJ0XChcXCJFcnJvciB3aGVuIGxvYWRpbmciO2k6NDE7czo0MzoiZWNobyAiPHNjcmlwdD5hbGVydFwoJyJcLkpUZXh0OjpfXCgnVkFMSURfRSI7aTo0MjtzOjg6ImV2YWxcKFwpIjtpOjQzO3M6ODoiJ3N5c3RlbSciO2k6NDQ7czo2OiInZXZhbCciO2k6NDU7czo2OiIiZXZhbCIiO2k6NDY7czo3OiJfc3lzdGVtIjtpOjQ3O3M6OToic2F2ZTJjb3B5IjtpOjQ4O3M6MTA6ImZpbGVzeXN0ZW0iO2k6NDk7czo4OiJzZW5kbWFpbCI7aTo1MDtzOjg6ImNhbkNobW9kIjtpOjUxO3M6MTM6Ii9ldGMvcGFzc3dkXCkiO2k6NTI7czoyNDoidWRwOi8vJ1wuc2VsZjo6XCRfY19hZGRyIjtpOjUzO3M6MzM6ImVkb2NlZF80NmVzYWJcKCcnXHwiXClcXFwpJywncmVnZSI7aTo1NDtzOjk6ImRvdWJsZXZhbCI7aTo1NTtzOjE2OiJvcGVyYXRpbmcgc3lzdGVtIjtpOjU2O3M6MTA6Imdsb2JhbGV2YWwiO2k6NTc7czoyNzoiZXZhbFwoZnVuY3Rpb25cKHAsYSxjLGssZSxyIjtpOjU4O3M6MTk6IndpdGggMC8wLzAgaWZcKDFcKXsiO2k6NTk7czo0NjoiXCR4Mj1cJHBhcmFtXFtbJyJdezAsMX14WyciXXswLDF9XF0gXCsgXCR3aWR0aCI7aTo2MDtzOjk6InNwZWNpYWxpcyI7aTo2MTtzOjg6ImNvcHlcKFwpIjtpOjYyO3M6MTk6IndwX2dldF9jdXJyZW50X3VzZXIiO2k6NjM7czo3OiItPmNobW9kIjtpOjY0O3M6NzoiX21haWxcKCI7aTo2NTtzOjc6Il9jb3B5XCgiO2k6NjY7czo3OiImY29weVwoIjtpOjY3O3M6NDU6InN0cnBvc1woXCRfU0VSVkVSXFsnSFRUUF9VU0VSX0FHRU5UJ1xdLCdEcnVwYSI7aTo2ODtzOjE2OiJldmFsXChjbGFzc1N0clwpIjtpOjY5O3M6MzE6ImZ1bmN0aW9uX2V4aXN0c1woJ2Jhc2U2NF9kZWNvZGUiO2k6NzA7czo0NDoiZWNobyAiPHNjcmlwdD5hbGVydFwoJyJcLkpUZXh0OjpfXCgnVkFMSURfRU0iO2k6NzE7czo0MzoiXCR4MT1cJG1pbl94O1wkeDI9XCRtYXhfeDtcJHkxPVwkbWluX3k7XCR5MiI7aTo3MjtzOjQ4OiJcJGN0bVxbJ2EnXF1cKVwpe1wkeD1cJHggXCogXCR0aGlzLT5rO1wkeT1cKFwkdGgiO2k6NzM7czo1OToiWyciXXswLDF9Y3JlYXRlX2Z1bmN0aW9uWyciXXswLDF9LFsnIl17MCwxfWdldF9yZXNvdXJjZV90eXAiO2k6NzQ7czo0ODoiWyciXXswLDF9Y3JlYXRlX2Z1bmN0aW9uWyciXXswLDF9LFsnIl17MCwxfWNyeXB0IjtpOjc1O3M6Njg6InN0cnBvc1woXCRfU0VSVkVSXFtbJyJdezAsMX1IVFRQX1VTRVJfQUdFTlRbJyJdezAsMX1cXSxbJyJdezAsMX1MeW54IjtpOjc2O3M6Njc6InN0cnN0clwoXCRfU0VSVkVSXFtbJyJdezAsMX1IVFRQX1VTRVJfQUdFTlRbJyJdezAsMX1cXSxbJyJdezAsMX1NU0kiO2k6Nzc7czoyNToic29ydFwoXCREaXN0cmlidXRpb25cW1wkayI7aTo3ODtzOjI1OiJzb3J0XChmdW5jdGlvblwoYSxiXCl7cmV0IjtpOjc5O3M6MjU6Imh0dHA6Ly93d3dcLmZhY2Vib29rXC5jb20iO2k6ODA7czoyNToiaHR0cDovL21hcHNcLmdvb2dsZVwuY29tLyI7aTo4MTtzOjQ4OiJ1ZHA6Ly8nXC5zZWxmOjpcJGNfYWRkciw4MCxcJGVycm5vLFwkZXJyc3RyLDE1MDAiO2k6ODI7czoyMDoiXChcLlwqXCh2aWV3XClcP1wuXCoiO2k6ODM7czo0NDoiZWNobyBbJyJdezAsMX08c2NyaXB0PmFsZXJ0XChbJyJdezAsMX1cJHRleHQiO2k6ODQ7czoxNzoic29ydFwoXCR2X2xpc3RcKTsiO2k6ODU7czo3NToibW92ZV91cGxvYWRlZF9maWxlXChcJF9GSUxFU1xbJ3VwbG9hZGVkX3BhY2thZ2UnXF1cWyd0bXBfbmFtZSdcXSxcJG1vc0NvbmZpIjtpOjg2O3M6MTI6ImZhbHNlXClcKTtcIyI7aTo4NztzOjQ2OiJzdHJwb3NcKFwkX1NFUlZFUlxbJ0hUVFBfVVNFUl9BR0VOVCdcXSwnTWFjIE9TIjtpOjg4O3M6NTA6ImRvY3VtZW50XC53cml0ZVwodW5lc2NhcGVcKCIlM0NzY3JpcHQgc3JjPScvYml0cml4IjtpOjg5O3M6MjU6IlwkX1NFUlZFUiBcWyJSRU1PVEVfQUREUiIiO2k6OTA7czoxNzoiYUhSMGNEb3ZMMk55YkRNdVoiO2k6OTE7czo1NDoiSlJlc3BvbnNlOjpzZXRCb2R5XChwcmVnX3JlcGxhY2VcKFwkcGF0dGVybnMsXCRyZXBsYWNlIjtpOjkyO3M6ODoiH4sIAAAAAAAiO2k6OTM7czo4OiJQSwUGAAAAACI7aTo5NDtzOjE0OiIJCgsMDSAvPlxdXFtcXiI7aTo5NTtzOjg6IolQTkcNChoKIjtpOjk2O3M6MTA6IlwpO1wjaScsJyYiO2k6OTc7czoxNToiXCk7XCNtaXMnLCcnLFwkIjtpOjk4O3M6MTk6IlwpO1wjaScsXCRkYXRhLFwkbWEiO2k6OTk7czozNDoiXCRmdW5jXChcJHBhcmFtc1xbXCR0eXBlXF0tPnBhcmFtcyI7aToxMDA7czo4OiIfiwgAAAAAACI7aToxMDE7czo5OiIAAQIDBAUGBwgiO2k6MTAyO3M6MTI6IiFcI1wkJSYnXCpcKyI7aToxMDM7czo3OiKDi42bnp+hIjtpOjEwNDtzOjY6IgkKCwwNICI7aToxMDU7czozMzoiXC5cLi9cLlwuL1wuXC4vXC5cLi9tb2R1bGVzL21vZF9tIjtpOjEwNjtzOjMwOiJcJGRlY29yYXRvclwoXCRtYXRjaGVzXFsxXF1cWzAiO2k6MTA3O3M6MjE6IlwkZGVjb2RlZnVuY1woXCRkXFtcJCI7aToxMDg7czoxNzoiX1wuXCtfYWJicmV2aWF0aW8iO2k6MTA5O3M6NDU6InN0cmVhbV9zb2NrZXRfY2xpZW50XCgndGNwOi8vJ1wuXCRwcm94eS0+aG9zdCI7aToxMTA7czoyNzoiZXZhbFwoZnVuY3Rpb25cKHAsYSxjLGssZSxkIjtpOjExMTtzOjI1OiIncnVua2l0X2Z1bmN0aW9uX3JlbmFtZScsIjtpOjExMjtzOjY6IoCBgoOEhSI7aToxMTM7czo2OiIBAgMEBQYiO2k6MTE0O3M6NjoiAAAAAAAAIjtpOjExNTtzOjIxOiJcJG1ldGhvZFwoXCRhcmdzXFswXF0iO2k6MTE2O3M6MjE6IlwkbWV0aG9kXChcJGFyZ3NcWzBcXSI7aToxMTc7czoyNDoiXCRuYW1lXChcJGFyZ3VtZW50c1xbMFxdIjtpOjExODtzOjMxOiJzdWJzdHJcKG1kNVwoc3Vic3RyXChcJHRva2VuLDAsIjtpOjExOTtzOjI0OiJzdHJyZXZcKHN1YnN0clwoc3RycmV2XCgiO2k6MTIwO3M6Mzk6InN0cmVhbV9zb2NrZXRfY2xpZW50XCgndGNwOi8vJ1wuXCRwcm94eSI7aToxMjE7czozNjoiXCRlbGVtZW50XFtiXF1cKDBcKSx0aGlzXC50cmFuc2l0aW9uIjtpOjEyMjtzOjMxOiJcJG1ldGhvZFwoXCRyZWxhdGlvblxbJ2l0ZW1OYW1lIjtpOjEyMztzOjM2OiJcJHZlcnNpb25cWzFcXVwpO31lbHNlaWZcKHByZWdfbWF0Y2giO2k6MTI0O3M6MzQ6IlwkY29tbWFuZFwoXCRjb21tYW5kc1xbXCRpZGVudGlmaWUiO2k6MTI1O3M6NDI6IlwkY2FsbGFibGVcKFwkcmF3XFsnY2FsbGJhY2snXF1cKFwkY1wpLFwkYyI7aToxMjY7czo0MjoiXCRlbFxbdmFsXF1cKFwpXCkgXCRlbFxbdmFsXF1cKGRhdGFcW3N0YXRlIjtpOjEyNztzOjQ3OiJcJGVsZW1lbnRcW3RcXVwoMFwpLHRoaXNcLnRyYW5zaXRpb25cKCJhZGRDbGFzcyI7aToxMjg7czozMToiXCk7XCNtaXMnLCcgJyxcJGlucHV0XCk7XCRpbnB1dCI7aToxMjk7czozMToia2lsbCAtOSAnXC5cJHBpZFwpO1wkdGhpcy0+Y2xvcyI7aToxMzA7czozMjoiY2FsbF91c2VyX2Z1bmNcKFwkZmlsdGVyLFwkdmFsdWUiO2k6MTMxO3M6MzM6ImNhbGxfdXNlcl9mdW5jXChcJG9wdGlvbnMsXCRlcnJvciI7aToxMzI7czozNjoiY2FsbF91c2VyX2Z1bmNcKFwkbGlzdGVuZXIsXCRldmVudFwpIjtpOjEzMztzOjY1OiJpZlwoc3RyaXBvc1woXCR1c2VyQWdlbnQsJ0FuZHJvaWQnXCkhPT1mYWxzZVwpe1wkdGhpcy0+bW9iaWxlPXRydSI7aToxMzQ7czo1MzoiYmFzZTY0X2RlY29kZVwodXJsZGVjb2RlXChcJGZpbGVcKVwpPT0naW5kZXhcLnBocCdcKXsiO2k6MTM1O3M6NjA6InVybGRlY29kZVwoYmFzZTY0X2RlY29kZVwoXCRpbnB1dFwpXCk7XCRleHBsb2RlQXJyYXk9ZXhwbG9kZSI7aToxMzY7czozNzoiYmFzZTY0X2RlY29kZVwodXJsZGVjb2RlXChcJHJldHVyblVyaSI7aToxMzc7czo0NzoidXJsZGVjb2RlXCh1cmxkZWNvZGVcKHN0cmlwY3NsYXNoZXNcKFwkc2VnbWVudHMiO2k6MTM4O3M6NTM6Im1haWxcKFwkdG8sXCRzdWJqZWN0LFwkYm9keSxcJGhlYWRlclwpO31lbHNle1wkcmVzdWx0IjtpOjEzOTtzOjM4OiI9aW5pX2dldFwoJ2Rpc2FibGVfZnVuY3Rpb25zJ1wpO1wkdGhpcyI7aToxNDA7czo0MjoiPWluaV9nZXRcKCdkaXNhYmxlX2Z1bmN0aW9ucydcKTtpZlwoIWVtcHR5IjtpOjE0MTtzOjM5OiJldmFsXChcJHBocENvZGVcKTt9ZWxzZXtjbGFzc19hbGlhc1woXCQiO2k6MTQyO3M6NDg6ImV2YWxcKFwkc3RyXCk7fXB1YmxpYyBmdW5jdGlvbiBjb3VudE1lbnVDaGlsZHJlbiI7fQ=="));
$g_AdwareSig = unserialize(base64_decode("YToxNTc6e2k6MDtzOjI1OiJzbGlua3NcLnN1L2dldF9saW5rc1wucGhwIjtpOjE7czoxMzoiTUxfbGNvZGVcLnBocCI7aToyO3M6MTM6Ik1MXyVjb2RlXC5waHAiO2k6MztzOjE5OiJjb2Rlc1wubWFpbmxpbmtcLnJ1IjtpOjQ7czoxOToiX19saW5rZmVlZF9yb2JvdHNfXyI7aTo1O3M6MTM6IkxJTktGRUVEX1VTRVIiO2k6NjtzOjE0OiJMaW5rZmVlZENsaWVudCI7aTo3O3M6MTg6Il9fc2FwZV9kZWxpbWl0ZXJfXyI7aTo4O3M6Mjk6ImRpc3BlbnNlclwuYXJ0aWNsZXNcLnNhcGVcLnJ1IjtpOjk7czoxMToiTEVOS19jbGllbnQiO2k6MTA7czoxMToiU0FQRV9jbGllbnQiO2k6MTE7czoxNjoiX19saW5rZmVlZF9lbmRfXyI7aToxMjtzOjE2OiJTTEFydGljbGVzQ2xpZW50IjtpOjEzO3M6MjA6Im5ld1xzK0xMTV9jbGllbnRcKFwpIjtpOjE0O3M6MTc6ImRiXC50cnVzdGxpbmtcLnJ1IjtpOjE1O3M6NjM6IlwkX1NFUlZFUlxbXHMqWyciXUhUVFBfUkVGRVJFUlsnIl1ccypcXVxzKixccypbJyJddHJ1c3RsaW5rXC5ydSI7aToxNjtzOjQyOiJcJFthLXpBLVowLTlfXStccyo9XHMqbmV3XHMqQlNcKFwpO1xzKmVjaG8iO2k6MTc7czozNzoiY2xhc3NccytDTV9jbGllbnRccytleHRlbmRzXHMqQ01fYmFzZSI7aToxODtzOjE5OiJuZXdccytDTV9jbGllbnRcKFwpIjtpOjE5O3M6MTY6InRsX2xpbmtzX2RiX2ZpbGUiO2k6MjA7czoyMDoiY2xhc3NccytsbXBfYmFzZVxzK3siO2k6MjE7czoxNToiVHJ1c3RsaW5rQ2xpZW50IjtpOjIyO3M6MTM6Ii0+XHMqU0xDbGllbnQiO2k6MjM7czoxNjY6Imlzc2V0XHMqXCgqXHMqXCRfU0VSVkVSXHMqXFtccypbJyJdezAsMX1IVFRQX1VTRVJfQUdFTlRbJyJdezAsMX1ccypcXVxzKlwpXHMqJiZccypcKCpccypcJF9TRVJWRVJccypcW1xzKlsnIl17MCwxfUhUVFBfVVNFUl9BR0VOVFsnIl17MCwxfVxdXHMqPT1ccypbJyJdezAsMX1MTVBfUm9ib3QiO2k6MjQ7czo0MzoiXCRsaW5rcy0+XHMqcmV0dXJuX2xpbmtzXHMqXCgqXHMqXCRsaWJfcGF0aCI7aToyNTtzOjQ0OiJcJGxpbmtzX2NsYXNzXHMqPVxzKm5ld1xzK0dldF9saW5rc1xzKlwoKlxzKiI7aToyNjtzOjUyOiJbJyJdezAsMX1ccyosXHMqWyciXXswLDF9XC5bJyJdezAsMX1ccypcKSpccyo7XHMqXD8+IjtpOjI3O3M6NzoibGV2aXRyYSI7aToyODtzOjEwOiJkYXBveGV0aW5lIjtpOjI5O3M6NjoidmlhZ3JhIjtpOjMwO3M6NjoiY2lhbGlzIjtpOjMxO3M6ODoicHJvdmlnaWwiO2k6MzI7czoxOToiY2xhc3NccytUV2VmZkNsaWVudCI7aTozMztzOjE4OiJuZXdccytTTENsaWVudFwoXCkiO2k6MzQ7czoyNDoiX19saW5rZmVlZF9iZWZvcmVfdGV4dF9fIjtpOjM1O3M6MTY6Il9fdGVzdF90bF9saW5rX18iO2k6MzY7czoxODoiczoxMToibG1wX2NoYXJzZXQiIjtpOjM3O3M6MjA6Ij1ccytuZXdccytNTENsaWVudFwoIjtpOjM4O3M6NDc6ImVsc2VccytpZlxzKlwoXHMqXChccypzdHJwb3NcKFxzKlwkbGlua3NfaXBccyosIjtpOjM5O3M6MzM6ImZ1bmN0aW9uXHMrcG93ZXJfbGlua3NfYmxvY2tfdmlldyI7aTo0MDtzOjIwOiJjbGFzc1xzK0lOR09UU0NsaWVudCI7aTo0MTtzOjEwOiJfX0xJTktfXzxhIjtpOjQyO3M6MjE6ImNsYXNzXHMrTGlua3BhZF9zdGFydCI7aTo0MztzOjEzOiJjbGFzc1xzK1ROWF9sIjtpOjQ0O3M6MjI6ImNsYXNzXHMrTUVHQUlOREVYX2Jhc2UiO2k6NDU7czoxNToiX19MSU5LX19fX0VORF9fIjtpOjQ2O3M6MjI6Im5ld1xzK1RSVVNUTElOS19jbGllbnQiO2k6NDc7czo3NDoiclwucGhwXD9pZD1bYS16QS1aMC05X10rJnJlZmVyZXI9JXtIVFRQX0hPU1R9LyV7UkVRVUVTVF9VUkl9XHMrXFtSPTMwMixMXF0iO2k6NDg7czozOToiVXNlci1hZ2VudDpccypHb29nbGVib3RccypEaXNhbGxvdzpccyovIjtpOjQ5O3M6MTg6Im5ld1xzK0xMTV9jbGllbnRcKCI7aTo1MDtzOjM2OiImcmVmZXJlcj0le0hUVFBfSE9TVH0vJXtSRVFVRVNUX1VSSX0iO2k6NTE7czoyOToiXC5waHBcP2lkPVwkMSYle1FVRVJZX1NUUklOR30iO2k6NTI7czozMzoiQWRkVHlwZVxzK2FwcGxpY2F0aW9uL3gtaHR0cGQtcGhwIjtpOjUzO3M6MjM6IkFkZEhhbmRsZXJccytwaHAtc2NyaXB0IjtpOjU0O3M6MjM6IkFkZEhhbmRsZXJccytjZ2ktc2NyaXB0IjtpOjU1O3M6NTI6IlJld3JpdGVSdWxlXHMrXC5cKlxzK2luZGV4XC5waHBcP3VybD1cJDBccytcW0wsUVNBXF0iO2k6NTY7czoxMjoicGhwaW5mb1woXCk7IjtpOjU3O3M6MTU6IlwobXNpZVx8b3BlcmFcKSI7aTo1ODtzOjIyOiI8aDE+TG9hZGluZ1wuXC5cLjwvaDE+IjtpOjU5O3M6Mjk6IkVycm9yRG9jdW1lbnRccys1MDBccytodHRwOi8vIjtpOjYwO3M6Mjk6IkVycm9yRG9jdW1lbnRccys0MDBccytodHRwOi8vIjtpOjYxO3M6Mjk6IkVycm9yRG9jdW1lbnRccys0MDRccytodHRwOi8vIjtpOjYyO3M6NDk6IlJld3JpdGVDb25kXHMqJXtIVFRQX1VTRVJfQUdFTlR9XHMqXC5cKm5kcm9pZFwuXCoiO2k6NjM7czoxMDE6IjxzY3JpcHRccytsYW5ndWFnZT1bJyJdezAsMX1KYXZhU2NyaXB0WyciXXswLDF9PlxzKnBhcmVudFwud2luZG93XC5vcGVuZXJcLmxvY2F0aW9uXHMqPVxzKlsnIl1odHRwOi8vIjtpOjY0O3M6OTk6ImNoclxzKlwoXHMqMTAxXHMqXClccypcLlxzKmNoclxzKlwoXHMqMTE4XHMqXClccypcLlxzKmNoclxzKlwoXHMqOTdccypcKVxzKlwuXHMqY2hyXHMqXChccyoxMDhccypcKSI7aTo2NTtzOjMwOiJjdXJsXC5oYXh4XC5zZS9yZmMvY29va2llX3NwZWMiO2k6NjY7czoxODoiSm9vbWxhX2JydXRlX0ZvcmNlIjtpOjY3O3M6MzQ6IlJld3JpdGVDb25kXHMqJXtIVFRQOngtd2FwLXByb2ZpbGUiO2k6Njg7czo0MjoiUmV3cml0ZUNvbmRccyole0hUVFA6eC1vcGVyYW1pbmktcGhvbmUtdWF9IjtpOjY5O3M6NjY6IlJld3JpdGVDb25kXHMqJXtIVFRQOkFjY2VwdC1MYW5ndWFnZX1ccypcKHJ1XHxydS1ydVx8dWtcKVxzKlxbTkNcXSI7aTo3MDtzOjI2OiJzbGVzaFwrc2xlc2hcK2RvbWVuXCtwb2ludCI7aTo3MTtzOjE3OiJ0ZWxlZm9ubmF5YS1iYXphLSI7aTo3MjtzOjE4OiJpY3EtZGx5YS10ZWxlZm9uYS0iO2k6NzM7czoyNDoicGFnZV9maWxlcy9zdHlsZTAwMFwuY3NzIjtpOjc0O3M6MjA6InNwcmF2b2NobmlrLW5vbWVyb3YtIjtpOjc1O3M6MTc6IkthemFuL2luZGV4XC5odG1sIjtpOjc2O3M6NTA6Ikdvb2dsZWJvdFsnIl17MCwxfVxzKlwpXCl7ZWNob1xzK2ZpbGVfZ2V0X2NvbnRlbnRzIjtpOjc3O3M6MjY6ImluZGV4XC5waHBcP2lkPVwkMSYle1FVRVJZIjtpOjc4O3M6MjA6IlZvbGdvZ3JhZGluZGV4XC5odG1sIjtpOjc5O3M6Mzg6IkFkZFR5cGVccythcHBsaWNhdGlvbi94LWh0dHBkLWNnaVxzK1wuIjtpOjgwO3M6MTk6Ii1rbHljaC1rLWlncmVcLmh0bWwiO2k6ODE7czoxOToibG1wX2NsaWVudFwoc3RyY29kZSI7aTo4MjtzOjE3OiIvXD9kbz1rYWstdWRhbGl0LSI7aTo4MztzOjE0OiIvXD9kbz1vc2hpYmthLSI7aTo4NDtzOjE5OiIvaW5zdHJ1a3RzaXlhLWRseWEtIjtpOjg1O3M6NDM6ImNvbnRlbnQ9IlxkKztVUkw9aHR0cHM6Ly9kb2NzXC5nb29nbGVcLmNvbS8iO2k6ODY7czo1OToiJTwhLS1cXHNcKlwkbWFya2VyXFxzXCotLT5cLlwrXD88IS0tXFxzXCovXCRtYXJrZXJcXHNcKi0tPiUiO2k6ODc7czo3OToiUmV3cml0ZVJ1bGVccytcXlwoXC5cKlwpLFwoXC5cKlwpXCRccytcJDJcLnBocFw/cmV3cml0ZV9wYXJhbXM9XCQxJnBhZ2VfdXJsPVwkMiI7aTo4ODtzOjQyOiJSZXdyaXRlUnVsZVxzKlwoXC5cK1wpXHMqaW5kZXhcLnBocFw/cz1cJDAiO2k6ODk7czoxODoiUmVkaXJlY3RccypodHRwOi8vIjtpOjkwO3M6NDU6IlJld3JpdGVSdWxlXHMqXF5cKFwuXCpcKVxzKmluZGV4XC5waHBcP2lkPVwkMSI7aTo5MTtzOjQ0OiJSZXdyaXRlUnVsZVxzKlxeXChcLlwqXClccyppbmRleFwucGhwXD9tPVwkMSI7aTo5MjtzOjE5ODoiXGIocGVyY29jZXR8YWRkZXJhbGx8dmlhZ3JhfGNpYWxpc3xsZXZpdHJhfGthdWZlbnxhbWJpZW58Ymx1ZVxzK3BpbGx8Y29jYWluZXxtYXJpanVhbmF8bGlwaXRvcnxwaGVudGVybWlufHByb1tzel1hY3xzYW5keWF1ZXJ8dHJhbWFkb2x8dHJveWhhbWJ5dWx0cmFtfHVuaWNhdWNhfHZhbGl1bXx2aWNvZGlufHhhbmF4fHlweGFpZW8pXHMrb25saW5lIjtpOjkzO3M6NDk6IlJld3JpdGVSdWxlXHMqXC5cKi9cLlwqXHMqW2EtekEtWjAtOV9dK1wucGhwXD9cJDAiO2k6OTQ7czozOToiUmV3cml0ZUNvbmRccysle1JFTU9URV9BRERSfVxzK1xeODVcLjI2IjtpOjk1O3M6NDE6IlJld3JpdGVDb25kXHMrJXtSRU1PVEVfQUREUn1ccytcXjIxN1wuMTE4IjtpOjk2O3M6NTI6IlJld3JpdGVFbmdpbmVccytPblxzKlJld3JpdGVCYXNlXHMrL1w/W2EtekEtWjAtOV9dKz0iO2k6OTc7czozMjoiRXJyb3JEb2N1bWVudFxzKzQwNFxzK2h0dHA6Ly90ZHMiO2k6OTg7czo1MToiUmV3cml0ZVJ1bGVccytcXlwoXC5cKlwpXCRccytodHRwOi8vXGQrXC5cZCtcLlxkK1wuIjtpOjk5O3M6Njc6IjwhLS1jaGVjazpbJyJdXHMqXC5ccyptZDVcKFxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFsiO2k6MTAwO3M6MTg6IlJld3JpdGVCYXNlXHMrL3dwLSI7aToxMDE7czozNjoiU2V0SGFuZGxlclxzK2FwcGxpY2F0aW9uL3gtaHR0cGQtcGhwIjtpOjEwMjtzOjQyOiIle0hUVFBfVVNFUl9BR0VOVH1ccyshd2luZG93cy1tZWRpYS1wbGF5ZXIiO2k6MTAzO3M6ODI6IlwoXHMqXCRfU0VSVkVSXFtccypbJyJdezAsMX1IVFRQX1VTRVJfQUdFTlRbJyJdezAsMX1ccypcXVxzKixccypbJyJdezAsMX1ZYW5kZXhCb3QiO2k6MTA0O3M6NzY6IlwoXHMqXCRfU0VSVkVSXFtccypbJyJdezAsMX1IVFRQX1JFRkVSRVJbJyJdezAsMX1ccypcXVxzKixccypbJyJdezAsMX15YW5kZXgiO2k6MTA1O3M6NzY6IlwoXHMqXCRfU0VSVkVSXFtccypbJyJdezAsMX1IVFRQX1JFRkVSRVJbJyJdezAsMX1ccypcXVxzKixccypbJyJdezAsMX1nb29nbGUiO2k6MTA2O3M6ODoiL2tyeWFraS8iO2k6MTA3O3M6MTA6IlwucGhwXD9cJDAiO2k6MTA4O3M6NzE6InJlcXVlc3RcLnNlcnZlcnZhcmlhYmxlc1woWyciXUhUVFBfVVNFUl9BR0VOVFsnIl1cKVxzKixccypbJyJdR29vZ2xlYm90IjtpOjEwOTtzOjgwOiJpbmRleFwucGhwXD9tYWluX3BhZ2U9cHJvZHVjdF9pbmZvJnByb2R1Y3RzX2lkPVsnIl1ccypcLlxzKnN0cl9yZXBsYWNlXChbJyJdbGlzdCI7aToxMTA7czozMToiZnNvY2tvcGVuXChccypbJyJdc2hhZHlraXRcLmNvbSI7aToxMTE7czoxMDoiZW9qaWV1XC5jbiI7aToxMTI7czoyMjoiPlxzKjwvaWZyYW1lPlxzKjxcP3BocCI7aToxMTM7czo4MToiPG1ldGFccytodHRwLWVxdWl2PVsnIl17MCwxfXJlZnJlc2hbJyJdezAsMX1ccytjb250ZW50PVsnIl17MCwxfVxkKztccyp1cmw9PFw/cGhwIjtpOjExNDtzOjgyOiI8bWV0YVxzK2h0dHAtZXF1aXY9WyciXXswLDF9UmVmcmVzaFsnIl17MCwxfVxzK2NvbnRlbnQ9WyciXXswLDF9XGQrO1xzKlVSTD1odHRwOi8vIjtpOjExNTtzOjY3OiJcJGZsXHMqPVxzKiI8bWV0YSBodHRwLWVxdWl2PVxcIlJlZnJlc2hcXCJccytjb250ZW50PVxcIlxkKztccypVUkw9IjtpOjExNjtzOjM4OiJSZXdyaXRlQ29uZFxzKiV7SFRUUF9SRUZFUkVSfVxzKnlhbmRleCI7aToxMTc7czozODoiUmV3cml0ZUNvbmRccyole0hUVFBfUkVGRVJFUn1ccypnb29nbGUiO2k6MTE4O3M6NTc6Ik9wdGlvbnNccytGb2xsb3dTeW1MaW5rc1xzK011bHRpVmlld3NccytJbmRleGVzXHMrRXhlY0NHSSI7aToxMTk7czoyODoiZ29vZ2xlXHx5YW5kZXhcfGJvdFx8cmFtYmxlciI7aToxMjA7czo0MToiY29udGVudD1bJyJdezAsMX0xO1VSTD1jZ2ktYmluXC5odG1sXD9jbWQiO2k6MTIxO3M6MTI6ImFuZGV4XHxvb2dsZSI7aToxMjI7czo0NDoiaGVhZGVyXChccypbJyJdUmVmcmVzaDpccypcZCs7XHMqVVJMPWh0dHA6Ly8iO2k6MTIzO3M6NDU6Ik1vemlsbGEvNVwuMFxzKlwoY29tcGF0aWJsZTtccypHb29nbGVib3QvMlwuMSI7aToxMjQ7czo1MDoiaHR0cDovL3d3d1wuYmluZ1wuY29tL3NlYXJjaFw/cT1cJHF1ZXJ5JnBxPVwkcXVlcnkiO2k6MTI1O3M6NDM6Imh0dHA6Ly9nb1wubWFpbFwucnUvc2VhcmNoXD9xPVsnIl1cLlwkcXVlcnkiO2k6MTI2O3M6NjM6Imh0dHA6Ly93d3dcLmdvb2dsZVwuY29tL3NlYXJjaFw/cT1bJyJdXC5cJHF1ZXJ5XC5bJyJdJmhsPVwkbGFuZyI7aToxMjc7czozNjoiU2V0SGFuZGxlclxzK2FwcGxpY2F0aW9uL3gtaHR0cGQtcGhwIjtpOjEyODtzOjQ5OiJpZlwoc3RyaXBvc1woXCR1YSxbJyJdYW5kcm9pZFsnIl1cKVxzKiE9PVxzKmZhbHNlIjtpOjEyOTtzOjE1MjoiKHNleHlccytsZXNiaWFuc3xjdW1ccyt2aWRlb3xzZXhccyt2aWRlb3xBbmFsXHMrRnVja3x0ZWVuXHMrc2V4fGZ1Y2tccyt2aWRlb3xCZWFjaFxzK051ZGV8d29tYW5ccytwdXNzeXxzZXhccytwaG90b3xuYWtlZFxzK3RlZW58eHh4XHMrdmlkZW98dGVlblxzK3BpYykiO2k6MTMwO3M6NTY6Imh0dHAtZXF1aXY9WyciXUNvbnRlbnQtTGFuZ3VhZ2VbJyJdXHMrY29udGVudD1bJyJdamFbJyJdIjtpOjEzMTtzOjU2OiJodHRwLWVxdWl2PVsnIl1Db250ZW50LUxhbmd1YWdlWyciXVxzK2NvbnRlbnQ9WyciXWNoWyciXSI7aToxMzI7czoxMToiS0FQUFVTVE9CT1QiO2k6MTMzO3M6Mzg6ImNsYXNzXHMrbFRyYW5zbWl0ZXJ7XHMqdmFyXHMqXCR2ZXJzaW9uIjtpOjEzNDtzOjM3OiJcJFthLXpBLVowLTlfXStccyo9XHMqWyciXS90bXAvc3Nlc3NfIjtpOjEzNTtzOjkxOiJmaWxlX2dldF9jb250ZW50c1woYmFzZTY0X2RlY29kZVwoXCRbYS16QS1aMC05X10rXClcLlsnIl1cP1snIl1cLmh0dHBfYnVpbGRfcXVlcnlcKFwkX0dFVFwpIjtpOjEzNjtzOjUwOiJpbmlfc2V0XChbJyJdezAsMX11c2VyX2FnZW50WyciXVxzKixccypbJyJdSlNMSU5LUyI7aToxMzc7czo2MzoiXCRkYi0+cXVlcnlcKFsnIl1TRUxFQ1QgXCogRlJPTSBhcnRpY2xlIFdIRVJFIHVybD1bJyJdXCRyZXF1ZXN0IjtpOjEzODtzOjI0OiI8aHRtbFxzK2xhbmc9WyciXWphWyciXT4iO2k6MTM5O3M6Mzc6InhtbDpsYW5nPVsnIl1qYVsnIl1ccytsYW5nPVsnIl1qYVsnIl0iO2k6MTQwO3M6MTY6Imxhbmc9WyciXWphWyciXT4iO2k6MTQxO3M6MzM6InN0cnBvc1woXCRpbSxbJyJdXFsvVVBEX0NPTlRFTlRcXSI7aToxNDI7czo1OToiPT1ccypbJyJdaW5kZXhcLnBocFsnIl1cKVxzKntccypwcmludFxzK2ZpbGVfZ2V0X2NvbnRlbnRzXCgiO2k6MTQzO3M6MTU6ImNsYXNzXHMrRmF0bGluayI7aToxNDQ7czo0MDoiXCRmPWZpbGVfZ2V0X2NvbnRlbnRzXCgia2V5cy8iXC5cJGtleWZcKSI7aToxNDU7czo1NjoiUmV3cml0ZVJ1bGVccytcXlwoXC5cKlwpXFxcLmh0bWxcJFxzK2luZGV4XC5waHBccytcW25jXF0iO2k6MTQ2O3M6NDU6Im1rZGlyXChbJyJdcGFnZS9bJyJdXC5tYl9zdWJzdHJcKG1kNVwoXCRrZXlcKSI7aToxNDc7czo0NzoiZWxzZWlmIFwoQFwkX0dFVFxbWyciXXBbJyJdXF0gPT0gWyciXWh0bWxbJyJdXCkiO2k6MTQ4O3M6ODg6IlJld3JpdGVSdWxlXHMrXF5cKFwuXCpcKVxcL1wkXHMraW5kZXhcLnBocFxzK1Jld3JpdGVSdWxlXHMrXF5yb2JvdHNcLnR4dFwkXHMrcm9ib3RzXC5waHAiO2k6MTQ5O3M6MTE1OiJpZlwoc3RyaXBvc1woXCRfU0VSVkVSXFtbJyJdSFRUUF9VU0VSX0FHRU5UWyciXVxdLFxzKlsnIl1Hb29nbGVib3RbJyJdXClccyohPT1ccypmYWxzZVwpe1xzKlwkdXJsXHMqPVxzKlsnIl1odHRwOi8vIjtpOjE1MDtzOjIxOiJcJHBhdGhfdG9fZG9yXHMqPVxzKiIiO2k6MTUxO3M6Mzk6InN0cnJldlwoc3RydG91cHBlclwoWyciXXRuZWdhX3Jlc3VfcHR0aCI7aToxNTI7czo2MjoiZmlsZV9wdXRfY29udGVudHNcKFsnIl1jb25mXC5waHBbJyJdXHMqLFxzKlsnIl1cXG5cXFwkc3RvcHBhZ2UiO2k6MTUzO3M6MzM6InNlc3Npb25fbmFtZVwoWyciXXVzZXJvaW50ZXJmZWlzbyI7aToxNTQ7czo4MToiUmV3cml0ZVJ1bGVccypcXlwoXFtBLVphLXowLTktXF1cK1wpXC5odG1sXCRccypbYS16QS1aMC05X10rXC5waHBcP2hsPVwkMVxzKlxbTFxdIjtpOjE1NTtzOjc5OiJcJGlkXHMqPVxzKlwkX1JFUVVFU1RcW1snIl1pZFsnIl1cXTtccypcJGNoXHMqPVxzKmN1cmxfaW5pdFwoXCk7XHMqXCR1cmxfc3RyaW5nIjtpOjE1NjtzOjYwOiJcJHBhZ2VwYXJzZT1maWxlX2dldF9jb250ZW50c1woImh0dHA6Ly93d3dcLmFza1wuY29tL3dlYlw/cT0iO30="));
$g_PhishingSig = unserialize(base64_decode("YTo5Mjp7aTowO3M6MTE6IkNWVjpccypcJGN2IjtpOjE7czoxMzoiSW52YWxpZFxzK1RWTiI7aToyO3M6MTE6IkludmFsaWQgUlZOIjtpOjM7czo0MDoiZGVmYXVsdFN0YXR1c1xzKj1ccypbJyJdSW50ZXJuZXQgQmFua2luZyI7aTo0O3M6Mjg6Ijx0aXRsZT5ccypDYXBpdGVjXHMrSW50ZXJuZXQiO2k6NTtzOjI3OiI8dGl0bGU+XHMqSW52ZXN0ZWNccytPbmxpbmUiO2k6NjtzOjM5OiJpbnRlcm5ldFxzK1BJTlxzK251bWJlclxzK2lzXHMrcmVxdWlyZWQiO2k6NztzOjExOiI8dGl0bGU+U2FycyI7aTo4O3M6MTM6Ijxicj5BVE1ccytQSU4iO2k6OTtzOjE4OiJDb25maXJtYXRpb25ccytPVFAiO2k6MTA7czoyNToiPHRpdGxlPlxzKkFic2FccytJbnRlcm5ldCI7aToxMTtzOjIxOiItXHMqUGF5UGFsXHMqPC90aXRsZT4iO2k6MTI7czoxOToiPHRpdGxlPlxzKlBheVxzKlBhbCI7aToxMztzOjIyOiItXHMqUHJpdmF0aVxzKjwvdGl0bGU+IjtpOjE0O3M6MTk6Ijx0aXRsZT5ccypVbmlDcmVkaXQiO2k6MTU7czoxOToiQmFua1xzK29mXHMrQW1lcmljYSI7aToxNjtzOjI1OiJBbGliYWJhJm5ic3A7TWFudWZhY3R1cmVyIjtpOjE3O3M6MjA6IlZlcmlmaWVkXHMrYnlccytWaXNhIjtpOjE4O3M6MjE6IkhvbmdccytMZW9uZ1xzK09ubGluZSI7aToxOTtzOjMwOiJZb3VyXHMrYWNjb3VudFxzK1x8XHMrTG9nXHMraW4iO2k6MjA7czoyNDoiPHRpdGxlPlxzKk9ubGluZSBCYW5raW5nIjtpOjIxO3M6MjQ6Ijx0aXRsZT5ccypPbmxpbmUtQmFua2luZyI7aToyMjtzOjIyOiJTaWduXHMraW5ccyt0b1xzK1lhaG9vIjtpOjIzO3M6MTY6IllhaG9vXHMqPC90aXRsZT4iO2k6MjQ7czoxMToiQkFOQ09MT01CSUEiO2k6MjU7czoxNjoiPHRpdGxlPlxzKkFtYXpvbiI7aToyNjtzOjE1OiI8dGl0bGU+XHMqQXBwbGUiO2k6Mjc7czoxNToiPHRpdGxlPlxzKkdtYWlsIjtpOjI4O3M6Mjg6Ikdvb2dsZVxzK0FjY291bnRzXHMqPC90aXRsZT4iO2k6Mjk7czoyNToiPHRpdGxlPlxzKkdvb2dsZVxzK1NlY3VyZSI7aTozMDtzOjMxOiI8dGl0bGU+XHMqTWVyYWtccytNYWlsXHMrU2VydmVyIjtpOjMxO3M6MjY6Ijx0aXRsZT5ccypTb2NrZXRccytXZWJtYWlsIjtpOjMyO3M6MjE6Ijx0aXRsZT5ccypcW0xfUVVFUllcXSI7aTozMztzOjM0OiI8dGl0bGU+XHMqQU5aXHMrSW50ZXJuZXRccytCYW5raW5nIjtpOjM0O3M6MzM6ImNvbVwud2Vic3RlcmJhbmtcLnNlcnZsZXRzXC5Mb2dpbiI7aTozNTtzOjE1OiI8dGl0bGU+XHMqR21haWwiO2k6MzY7czoxODoiPHRpdGxlPlxzKkZhY2Vib29rIjtpOjM3O3M6MzY6IlxkKztVUkw9aHR0cHM6Ly93d3dcLndlbGxzZmFyZ29cLmNvbSI7aTozODtzOjIzOiI8dGl0bGU+XHMqV2VsbHNccypGYXJnbyI7aTozOTtzOjQ5OiJwcm9wZXJ0eT0ib2c6c2l0ZV9uYW1lIlxzKmNvbnRlbnQ9IkZhY2Vib29rIlxzKi8+IjtpOjQwO3M6MjI6IkFlc1wuQ3RyXC5kZWNyeXB0XHMqXCgiO2k6NDE7czoxNzoiPHRpdGxlPlxzKkFsaWJhYmEiO2k6NDI7czoxOToiUmFib2Jhbmtccyo8L3RpdGxlPiI7aTo0MztzOjM1OiJcJG1lc3NhZ2VccypcLj1ccypbJyJdezAsMX1QYXNzd29yZCI7aTo0NDtzOjYzOiJcJENWVjJDXHMqPVxzKlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtccypbJyJdQ1ZWMkMiO2k6NDU7czoxNDoiQ1ZWMjpccypcJENWVjIiO2k6NDY7czoxODoiXC5odG1sXD9jbWQ9bG9naW49IjtpOjQ3O3M6MTg6IldlYm1haWxccyo8L3RpdGxlPiI7aTo0ODtzOjIzOiI8dGl0bGU+XHMqVVBDXHMrV2VibWFpbCI7aTo0OTtzOjE3OiJcLnBocFw/Y21kPWxvZ2luPSI7aTo1MDtzOjE3OiJcLmh0bVw/Y21kPWxvZ2luPSI7aTo1MTtzOjIzOiJcLnN3ZWRiYW5rXC5zZS9tZHBheWFjcyI7aTo1MjtzOjI0OiJcLlxzKlwkX1BPU1RcW1xzKlsnIl1jdnYiO2k6NTM7czoyMDoiPHRpdGxlPlxzKkxBTkRFU0JBTksiO2k6NTQ7czoxMDoiQlktU1AxTjBaQSI7aTo1NTtzOjQ1OiJTZWN1cml0eVxzK3F1ZXN0aW9uXHMrOlxzK1snIl1ccypcLlxzKlwkX1BPU1QiO2k6NTY7czo0MDoiaWZcKFxzKmZpbGVfZXhpc3RzXChccypcJHNjYW1ccypcLlxzKlwkaSI7aTo1NztzOjIwOiI8dGl0bGU+XHMqQmVzdC50aWdlbiI7aTo1ODtzOjIwOiI8dGl0bGU+XHMqTEFOREVTQkFOSyI7aTo1OTtzOjUyOiJ3aW5kb3dcLmxvY2F0aW9uXHMqPVxzKlsnIl1pbmRleFxkKypcLnBocFw/Y21kPWxvZ2luIjtpOjYwO3M6NTQ6IndpbmRvd1wubG9jYXRpb25ccyo9XHMqWyciXWluZGV4XGQrKlwuaHRtbCpcP2NtZD1sb2dpbiI7aTo2MTtzOjI1OiI8dGl0bGU+XHMqTWFpbFxzKjwvdGl0bGU+IjtpOjYyO3M6Mjg6IlNpZVxzK0loclxzK0tvbnRvXHMqPC90aXRsZT4iO2k6NjM7czoyOToiUGF5cGFsXHMrS29udG9ccyt2ZXJpZml6aWVyZW4iO2k6NjQ7czozMDoiXCRfR0VUXFtccypbJyJdY2NfY291bnRyeV9jb2RlIjtpOjY1O3M6Mjk6Ijx0aXRsZT5PdXRsb29rXHMrV2ViXHMrQWNjZXNzIjtpOjY2O3M6OToiX0NBUlRBU0lfIjtpOjY3O3M6NzY6IjxtZXRhXHMraHR0cC1lcXVpdj1bJyJdcmVmcmVzaFsnIl1ccypjb250ZW50PSJcZCs7XHMqdXJsPWRhdGE6dGV4dC9odG1sO2h0dHAiO2k6Njg7czozMDoiY2FuXHMqc2lnblxzKmluXHMqdG9ccypkcm9wYm94IjtpOjY5O3M6MzU6IlxkKztccypVUkw9aHR0cHM6Ly93d3dcLmdvb2dsZVwuY29tIjtpOjcwO3M6MjY6Im1haWxcLnJ1L3NldHRpbmdzL3NlY3VyaXR5IjtpOjcxO3M6NTk6IkxvY2F0aW9uOlxzKmh0dHBzOi8vc2VjdXJpdHlcLmdvb2dsZVwuY29tL3NldHRpbmdzL3NlY3VyaXR5IjtpOjcyO3M6NjU6IlwkaXBccyo9XHMqZ2V0ZW52XChccypbJyJdUkVNT1RFX0FERFJbJyJdXHMqXCk7XHMqXCRtZXNzYWdlXHMqXC49IjtpOjczO3M6MTc6ImxvZ2luXC5lYzIxXC5jb20vIjtpOjc0O3M6NjA6IlwkXyhHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFfFJFUVVFU1QpXFtbJyJdezAsMX1jdnZbJyJdezAsMX1cXSI7aTo3NTtzOjM0OiJcJGFkZGRhdGU9ZGF0ZVwoIkQgTSBkLCBZIGc6aSBhIlwpIjtpOjc2O3M6MzY6IlwkZGF0YW1hc2lpPWRhdGVcKCJEIE0gZCwgWSBnOmkgYSJcKSI7aTo3NztzOjI3OiJodHRwczovL2FwcGxlaWRcLmFwcGxlXC5jb20iO2k6Nzg7czoxNDoiLUFwcGxlX1Jlc3VsdC0iO2k6Nzk7czoxMzoiQU9MXHMrRGV0YWlscyI7aTo4MDtzOjQzOiJcJF9QT1NUXFtccypbJyJdezAsMX1lTWFpbEFkZFsnIl17MCwxfVxzKlxdIjtpOjgxO3M6NDA6ImJhc2VccytocmVmPVsnIl1odHRwczovL2xvZ2luXC5saXZlXC5jb20iO2k6ODI7czoyNDoiPHRpdGxlPkhvdG1haWxccytBY2NvdW50IjtpOjgzO3M6NDE6IjwhLS1ccytzYXZlZFxzK2Zyb21ccyt1cmw9XChcZCtcKWh0dHBzOi8vIjtpOjg0O3M6MjA6IkJhbmtccytvZlxzK01vbnRyZWFsIjtpOjg1O3M6MjE6InNlY3VyZVwudGFuZ2VyaW5lXC5jYSI7aTo4NjtzOjIyOiJibW9cLmNvbS9vbmxpbmViYW5raW5nIjtpOjg3O3M6NDE6InBtX2ZwPXZlcnNpb24mc3RhdGU9MSZzYXZlRkJDPSZGQkNfTnVtYmVyIjtpOjg4O3M6MjE6ImNpYmNvbmxpbmVcLmNpYmNcLmNvbSI7aTo4OTtzOjMxOiJodHRwczovL3d3d1wudGRjYW5hZGF0cnVzdFwuY29tIjtpOjkwO3M6MjY6IlZpc2l0ZWQgVEQgQkFOSzpccyoiXC5cJGlwIjtpOjkxO3M6NjI6IndpbmRvd1wubG9jYXRpb249ImluZGV4XC5odG1sXD9jbWQ9bG9naW49dXNtYWlsPWNoZWNrPXZhbGlkYXRlIjt9"));
$g_JSVirSig = unserialize(base64_decode("YToxNDU6e2k6MDtzOjE0OiJ2PTA7dng9WyciXUNvZCI7aToxO3M6MjM6IkF0WyciXVxdXCh2XCtcK1wpLTFcKVwpIjtpOjI7czozMjoiQ2xpY2tVbmRlcmNvb2tpZVxzKj1ccypHZXRDb29raWUiO2k6MztzOjcwOiJ1c2VyQWdlbnRcfHBwXHxodHRwXHxkYXphbHl6WyciXXswLDF9XC5zcGxpdFwoWyciXXswLDF9XHxbJyJdezAsMX1cKSwwIjtpOjQ7czoyMjoiXC5wcm90b3R5cGVcLmF9Y2F0Y2hcKCI7aTo1O3M6Mzc6InRyeXtCb29sZWFuXChcKVwucHJvdG90eXBlXC5xfWNhdGNoXCgiO2k6NjtzOjM0OiJpZlwoUmVmXC5pbmRleE9mXCgnXC5nb29nbGVcLidcKSE9IjtpOjc7czo4NjoiaW5kZXhPZlx8aWZcfHJjXHxsZW5ndGhcfG1zblx8eWFob29cfHJlZmVycmVyXHxhbHRhdmlzdGFcfG9nb1x8YmlcfGhwXHx2YXJcfGFvbFx8cXVlcnkiO2k6ODtzOjYwOiJBcnJheVwucHJvdG90eXBlXC5zbGljZVwuY2FsbFwoYXJndW1lbnRzXClcLmpvaW5cKFsnIl1bJyJdXCkiO2k6OTtzOjgyOiJxPWRvY3VtZW50XC5jcmVhdGVFbGVtZW50XCgiZCJcKyJpIlwrInYiXCk7cVwuYXBwZW5kQ2hpbGRcKHFcKyIiXCk7fWNhdGNoXChxd1wpe2g9IjtpOjEwO3M6Nzk6Ilwreno7c3M9XFtcXTtmPSdmcidcKydvbSdcKydDaCc7ZlwrPSdhckMnO2ZcKz0nb2RlJzt3PXRoaXM7ZT13XFtmXFsic3Vic3RyIlxdXCgiO2k6MTE7czoxMTU6InM1XChxNVwpe3JldHVybiBcK1wrcTU7fWZ1bmN0aW9uIHlmXChzZix3ZVwpe3JldHVybiBzZlwuc3Vic3RyXCh3ZSwxXCk7fWZ1bmN0aW9uIHkxXCh3Ylwpe2lmXCh3Yj09MTY4XCl3Yj0xMDI1O2Vsc2UiO2k6MTI7czo2NDoiaWZcKG5hdmlnYXRvclwudXNlckFnZW50XC5tYXRjaFwoL1woYW5kcm9pZFx8bWlkcFx8ajJtZVx8c3ltYmlhbiI7aToxMztzOjEwNjoiZG9jdW1lbnRcLndyaXRlXCgnPHNjcmlwdCBsYW5ndWFnZT0iSmF2YVNjcmlwdCIgdHlwZT0idGV4dC9qYXZhc2NyaXB0IiBzcmM9IidcK2RvbWFpblwrJyI+PC9zY3InXCsnaXB0PidcKSI7aToxNDtzOjMxOiJodHRwOi8vcGhzcFwucnUvXy9nb1wucGhwXD9zaWQ9IjtpOjE1O3M6NjY6Ij1uYXZpZ2F0b3JcW2FwcFZlcnNpb25fdmFyXF1cLmluZGV4T2ZcKCJNU0lFIlwpIT0tMVw/JzxpZnJhbWUgbmFtZSI7aToxNjtzOjc6IlxceDY1QXQiO2k6MTc7czo5OiJcXHg2MXJDb2QiO2k6MTg7czoyMjoiImZyIlwrIm9tQyJcKyJoYXJDb2RlIiI7aToxOTtzOjExOiI9ImV2IlwrImFsIiI7aToyMDtzOjc4OiJcW1woXChlXClcPyJzIjoiIlwpXCsicCJcKyJsaXQiXF1cKCJhXCQiXFtcKFwoZVwpXD8ic3UiOiIiXClcKyJic3RyIlxdXCgxXClcKTsiO2k6MjE7czozOToiZj0nZnInXCsnb20nXCsnQ2gnO2ZcKz0nYXJDJztmXCs9J29kZSc7IjtpOjIyO3M6MjA6ImZcKz1cKGhcKVw/J29kZSc6IiI7IjtpOjIzO3M6NDE6ImY9J2YnXCsncidcKydvJ1wrJ20nXCsnQ2gnXCsnYXJDJ1wrJ29kZSc7IjtpOjI0O3M6NTA6ImY9J2Zyb21DaCc7ZlwrPSdhckMnO2ZcKz0ncWdvZGUnXFsic3Vic3RyIlxdXCgyXCk7IjtpOjI1O3M6MTY6InZhclxzK2Rpdl9jb2xvcnMiO2k6MjY7czo5OiJ2YXJccytfMHgiO2k6Mjc7czoyMDoiQ29yZUxpYnJhcmllc0hhbmRsZXIiO2k6Mjg7czoxMDoia20wYWU5Z3I2bSI7aToyOTtzOjY6ImMzMjg0ZCI7aTozMDtzOjg6IlxceDY4YXJDIjtpOjMxO3M6ODoiXFx4NmRDaGEiO2k6MzI7czo3OiJcXHg2ZmRlIjtpOjMzO3M6NzoiXFx4NmZkZSI7aTozNDtzOjg6IlxceDQzb2RlIjtpOjM1O3M6NzoiXFx4NzJvbSI7aTozNjtzOjc6IlxceDQzaGEiO2k6Mzc7czo3OiJcXHg3MkNvIjtpOjM4O3M6ODoiXFx4NDNvZGUiO2k6Mzk7czoxMDoiXC5keW5kbnNcLiI7aTo0MDtzOjk6IlwuZHluZG5zLSI7aTo0MTtzOjc5OiJ9XHMqZWxzZVxzKntccypkb2N1bWVudFwud3JpdGVccypcKFxzKlsnIl17MCwxfVwuWyciXXswLDF9XClccyp9XHMqfVxzKlJcKFxzKlwpIjtpOjQyO3M6NDU6ImRvY3VtZW50XC53cml0ZVwodW5lc2NhcGVcKCclM0NkaXYlMjBpZCUzRCUyMiI7aTo0MztzOjE4OiJcLmJpdGNvaW5wbHVzXC5jb20iO2k6NDQ7czo0MToiXC5zcGxpdFwoIiYmIlwpO2g9MjtzPSIiO2lmXChtXClmb3JcKGk9MDsiO2k6NDU7czo0MToiPGlmcmFtZVxzK3NyYz0iaHR0cDovL2RlbHV4ZXNjbGlja3NcLnByby8iO2k6NDY7czo0NToiM0Jmb3JcfGZyb21DaGFyQ29kZVx8MkMyN1x8M0RcfDJDODhcfHVuZXNjYXBlIjtpOjQ3O3M6NTg6Ijtccypkb2N1bWVudFwud3JpdGVcKFsnIl17MCwxfTxpZnJhbWVccypzcmM9Imh0dHA6Ly95YVwucnUiO2k6NDg7czoxMTA6IndcLmRvY3VtZW50XC5ib2R5XC5hcHBlbmRDaGlsZFwoc2NyaXB0XCk7XHMqY2xlYXJJbnRlcnZhbFwoaVwpO1xzKn1ccyp9XHMqLFxzKlxkK1xzKlwpXHMqO1xzKn1ccypcKVwoXHMqd2luZG93IjtpOjQ5O3M6MTEwOiJpZlwoIWdcKFwpJiZ3aW5kb3dcLm5hdmlnYXRvclwuY29va2llRW5hYmxlZFwpe2RvY3VtZW50XC5jb29raWU9IjE9MTtleHBpcmVzPSJcK2VcLnRvR01UU3RyaW5nXChcKVwrIjtwYXRoPS8iOyI7aTo1MDtzOjcwOiJubl9wYXJhbV9wcmVsb2FkZXJfY29udGFpbmVyXHw1MDAxXHxoaWRkZW5cfGlubmVySFRNTFx8aW5qZWN0XHx2aXNpYmxlIjtpOjUxO3M6Mjk6IjwhLS1bYS16QS1aMC05X10rXHxcfHN0YXQgLS0+IjtpOjUyO3M6ODU6IiZwYXJhbWV0ZXI9XCRrZXl3b3JkJnNlPVwkc2UmdXI9MSZIVFRQX1JFRkVSRVI9J1wrZW5jb2RlVVJJQ29tcG9uZW50XChkb2N1bWVudFwuVVJMXCkiO2k6NTM7czo0ODoid2luZG93c1x8c2VyaWVzXHw2MFx8c3ltYm9zXHxjZVx8bW9iaWxlXHxzeW1iaWFuIjtpOjU0O3M6MzU6IlxbWyciXWV2YWxbJyJdXF1cKHNcKTt9fX19PC9zY3JpcHQ+IjtpOjU1O3M6NTk6ImtDNzBGTWJseUprRldab2RDS2wxV1lPZFdZVWxuUXpSbmJsMVdac1ZFZGxkbUwwNVdadFYzWXZSR0k5IjtpOjU2O3M6NTU6IntrPWk7cz1zXC5jb25jYXRcKHNzXChldmFsXChhc3FcKFwpXCktMVwpXCk7fXo9cztldmFsXCgiO2k6NTc7czoxMzA6ImRvY3VtZW50XC5jb29raWVcLm1hdGNoXChuZXdccytSZWdFeHBcKFxzKiJcKFw/OlxeXHw7IFwpIlxzKlwrXHMqbmFtZVwucmVwbGFjZVwoL1woXFtcXFwuXCRcP1wqXHx7fVxcXChcXFwpXFxcW1xcXF1cXC9cXFwrXF5cXVwpL2ciO2k6NTg7czo4Njoic2V0Q29va2llXHMqXCgqXHMqImFyeF90dCJccyosXHMqMVxzKixccypkdFwudG9HTVRTdHJpbmdcKFwpXHMqLFxzKlsnIl17MCwxfS9bJyJdezAsMX0iO2k6NTk7czoxNDQ6ImRvY3VtZW50XC5jb29raWVcLm1hdGNoXHMqXChccypuZXdccytSZWdFeHBccypcKFxzKiJcKFw/OlxeXHw7XHMqXCkiXHMqXCtccypuYW1lXC5yZXBsYWNlXHMqXCgvXChcW1xcXC5cJFw/XCpcfHt9XFxcKFxcXClcXFxbXFxcXVxcL1xcXCtcXlxdXCkvZyI7aTo2MDtzOjk4OiJ2YXJccytkdFxzKz1ccytuZXdccytEYXRlXChcKSxccytleHBpcnlUaW1lXHMrPVxzK2R0XC5zZXRUaW1lXChccytkdFwuZ2V0VGltZVwoXClccytcK1xzKzkwMDAwMDAwMCI7aTo2MTtzOjEwNToiaWZccypcKFxzKm51bVxzKj09PVxzKjBccypcKVxzKntccypyZXR1cm5ccyoxO1xzKn1ccyplbHNlXHMqe1xzKnJldHVyblxzK251bVxzKlwqXHMqckZhY3RcKFxzKm51bVxzKi1ccyoxIjtpOjYyO3M6NDE6IlwrPVN0cmluZ1wuZnJvbUNoYXJDb2RlXChwYXJzZUludFwoMFwrJ3gnIjtpOjYzO3M6ODM6IjxzY3JpcHRccytsYW5ndWFnZT0iSmF2YVNjcmlwdCI+XHMqcGFyZW50XC53aW5kb3dcLm9wZW5lclwubG9jYXRpb249Imh0dHA6Ly92a1wuY29tIjtpOjY0O3M6NDQ6ImxvY2F0aW9uXC5yZXBsYWNlXChbJyJdezAsMX1odHRwOi8vdjVrNDVcLnJ1IjtpOjY1O3M6MTI5OiI7dHJ5e1wrXCtkb2N1bWVudFwuYm9keX1jYXRjaFwocVwpe2FhPWZ1bmN0aW9uXChmZlwpe2ZvclwoaT0wO2k8elwubGVuZ3RoO2lcK1wrXCl7emFcKz1TdHJpbmdcW2ZmXF1cKGVcKHZcK1woelxbaVxdXClcKS0xMlwpO319O30iO2k6NjY7czoxNDI6ImRvY3VtZW50XC53cml0ZVxzKlwoWyciXXswLDF9PFsnIl17MCwxfVxzKlwrXHMqeFxbMFxdXHMqXCtccypbJyJdezAsMX0gWyciXXswLDF9XHMqXCtccyp4XFs0XF1ccypcK1xzKlsnIl17MCwxfT5cLlsnIl17MCwxfVxzKlwreFxzKlxbMlxdXHMqXCsiO2k6Njc7czo2MDoiaWZcKHRcLmxlbmd0aD09Mlwpe3pcKz1TdHJpbmdcLmZyb21DaGFyQ29kZVwocGFyc2VJbnRcKHRcKVwrIjtpOjY4O3M6NzQ6IndpbmRvd1wub25sb2FkXHMqPVxzKmZ1bmN0aW9uXChcKVxzKntccyppZlxzKlwoZG9jdW1lbnRcLmNvb2tpZVwuaW5kZXhPZlwoIjtpOjY5O3M6OTc6Ilwuc3R5bGVcLmhlaWdodFxzKj1ccypbJyJdezAsMX0wcHhbJyJdezAsMX07d2luZG93XC5vbmxvYWRccyo9XHMqZnVuY3Rpb25cKFwpXHMqe2RvY3VtZW50XC5jb29raWUiO2k6NzA7czoxMjI6Ilwuc3JjPVwoWyciXXswLDF9aHRwczpbJyJdezAsMX09PWRvY3VtZW50XC5sb2NhdGlvblwucHJvdG9jb2xcP1snIl17MCwxfWh0dHBzOi8vc3NsWyciXXswLDF9OlsnIl17MCwxfWh0dHA6Ly9bJyJdezAsMX1cKVwrIjtpOjcxO3M6MzA6IjQwNFwucGhwWyciXXswLDF9PlxzKjwvc2NyaXB0PiI7aTo3MjtzOjc2OiJwcmVnX21hdGNoXChbJyJdezAsMX0vc2FwZS9pWyciXXswLDF9XHMqLFxzKlwkX1NFUlZFUlxbWyciXXswLDF9SFRUUF9SRUZFUkVSIjtpOjczO3M6NzQ6ImRpdlwuaW5uZXJIVE1MXHMqXCs9XHMqWyciXXswLDF9PGVtYmVkXHMraWQ9ImR1bW15MiJccytuYW1lPSJkdW1teTIiXHMrc3JjIjtpOjc0O3M6NzM6InNldFRpbWVvdXRcKFsnIl17MCwxfWFkZE5ld09iamVjdFwoXClbJyJdezAsMX0sXGQrXCk7fX19O2FkZE5ld09iamVjdFwoXCkiO2k6NzU7czo1MToiXChiPWRvY3VtZW50XClcLmhlYWRcLmFwcGVuZENoaWxkXChiXC5jcmVhdGVFbGVtZW50IjtpOjc2O3M6MzA6IkNocm9tZVx8aVBhZFx8aVBob25lXHxJRU1vYmlsZSI7aTo3NztzOjE5OiJcJDpcKHt9XCsiIlwpXFtcJFxdIjtpOjc4O3M6NDk6IjwvaWZyYW1lPlsnIl1cKTtccyp2YXJccytqPW5ld1xzK0RhdGVcKG5ld1xzK0RhdGUiO2k6Nzk7czo1Mzoie3Bvc2l0aW9uOmFic29sdXRlO3RvcDotOTk5OXB4O308L3N0eWxlPjxkaXZccytjbGFzcz0iO2k6ODA7czoxMjg6ImlmXHMqXChcKHVhXC5pbmRleE9mXChbJyJdezAsMX1jaHJvbWVbJyJdezAsMX1cKVxzKj09XHMqLTFccyomJlxzKnVhXC5pbmRleE9mXCgid2luIlwpXHMqIT1ccyotMVwpXHMqJiZccypuYXZpZ2F0b3JcLmphdmFFbmFibGVkIjtpOjgxO3M6NTg6InBhcmVudFwud2luZG93XC5vcGVuZXJcLmxvY2F0aW9uPVsnIl17MCwxfWh0dHA6Ly92a1wuY29tXC4iO2k6ODI7czo0MToiXF1cLnN1YnN0clwoMCwxXClcKTt9fXJldHVybiB0aGlzO30sXFx1MDAiO2k6ODM7czo2ODoiamF2YXNjcmlwdFx8aGVhZFx8dG9Mb3dlckNhc2VcfGNocm9tZVx8d2luXHxqYXZhRW5hYmxlZFx8YXBwZW5kQ2hpbGQiO2k6ODQ7czoyMToibG9hZFBOR0RhdGFcKHN0ckZpbGUsIjtpOjg1O3M6MjA6IlwpO2lmXCghflwoWyciXXswLDF9IjtpOjg2O3M6MjM6Ii8vXHMqU29tZVwuZGV2aWNlc1wuYXJlIjtpOjg3O3M6MzI6IndpbmRvd1wub25lcnJvclxzKj1ccypraWxsZXJyb3JzIjtpOjg4O3M6MTA1OiJjaGVja191c2VyX2FnZW50PVxbXHMqWyciXXswLDF9THVuYXNjYXBlWyciXXswLDF9XHMqLFxzKlsnIl17MCwxfWlQaG9uZVsnIl17MCwxfVxzKixccypbJyJdezAsMX1NYWNpbnRvc2giO2k6ODk7czoxNTM6ImRvY3VtZW50XC53cml0ZVwoWyciXXswLDF9PFsnIl17MCwxfVwrWyciXXswLDF9aVsnIl17MCwxfVwrWyciXXswLDF9ZlsnIl17MCwxfVwrWyciXXswLDF9clsnIl17MCwxfVwrWyciXXswLDF9YVsnIl17MCwxfVwrWyciXXswLDF9bVsnIl17MCwxfVwrWyciXXswLDF9ZSI7aTo5MDtzOjQ4OiJzdHJpcG9zXChuYXZpZ2F0b3JcLnVzZXJBZ2VudFxzKixccypsaXN0X2RhdGFcW2kiO2k6OTE7czoyNjoiaWZccypcKCFzZWVfdXNlcl9hZ2VudFwoXCkiO2k6OTI7czo0NjoiY1wubGVuZ3RoXCk7fXJldHVyblxzKlsnIl1bJyJdO31pZlwoIWdldENvb2tpZSI7aTo5MztzOjcwOiI8c2NyaXB0XHMqdHlwZT1bJyJdezAsMX10ZXh0L2phdmFzY3JpcHRbJyJdezAsMX1ccypzcmM9WyciXXswLDF9ZnRwOi8vIjtpOjk0O3M6NDg6ImlmXHMqXChkb2N1bWVudFwuY29va2llXC5pbmRleE9mXChbJyJdezAsMX1zYWJyaSI7aTo5NTtzOjEyMjoid2luZG93XC5sb2NhdGlvbj1ifVxzKlwpXChccypuYXZpZ2F0b3JcLnVzZXJBZ2VudFxzKlx8XHxccypuYXZpZ2F0b3JcLnZlbmRvclxzKlx8XHxccyp3aW5kb3dcLm9wZXJhXHMqLFxzKlsnIl17MCwxfWh0dHA6Ly8iO2k6OTY7czoxMTQ6IlwpO1xzKmlmXChccypbYS16QS1aMC05X10rXC50ZXN0XChccypkb2N1bWVudFwucmVmZXJyZXJccypcKVxzKiYmXHMqW2EtekEtWjAtOV9dK1wpXHMqe1xzKmRvY3VtZW50XC5sb2NhdGlvblwuaHJlZiI7aTo5NztzOjUyOiJpZlwoL0FuZHJvaWQvaVxbXzB4W2EtekEtWjAtOV9dK1xbXGQrXF1cXVwobmF2aWdhdG9yIjtpOjk4O3M6Njk6ImZ1bmN0aW9uXChhXCl7aWZcKGEmJlsnIl1kYXRhWyciXWluXGQrYSYmYVwuZGF0YVwuYVxkKyYmYVwuZGF0YVwuYVxkKyI7aTo5OTtzOjU4OiJzXChvXCl9XCl9LGY9ZnVuY3Rpb25cKFwpe3ZhciB0LGk9SlNPTlwuc3RyaW5naWZ5XChlXCk7b1woIjtpOjEwMDtzOjEwNjoiPFxkK1xzK1xkKz1bJyJdXGQrL1xkK1xcWyciXVwrXFxbJyJdLlxcWyciXVwrXFxbJyJdLlsnIl1ccysuPVsnIl0uOi8vXGQrXFxbJyJdXCtcXFsnIl0uXC5cZCtcXFsnIl1cK1xcWyciXSI7aToxMDE7czoxMDc6InNldFRpbWVvdXRcKFxkK1wpO1xzKnZhclxzK2RlZmF1bHRfa2V5d29yZFxzKj1ccyplbmNvZGVVUklDb21wb25lbnRcKGRvY3VtZW50XC50aXRsZVwpO1xzKnZhclxzK3NlX3JlZmVycmVyIjtpOjEwMjtzOjk4OiI9ZG9jdW1lbnRcLnJlZmVycmVyO2lmXChSZWZcLmluZGV4T2ZcKFsnIl1cLmdvb2dsZVwuWyciXVwpIT0tMVx8XHxSZWZcLmluZGV4T2ZcKFsnIl1cLmJpbmdcLlsnIl1cKSI7aToxMDM7czoyMDoidmlzaXRvclRyYWNrZXJfaXNNb2IiO2k6MTA0O3M6NDE6Ii9cKlx3ezMyfVwqL3ZhclxzK18weFthLXpBLVowLTlfXSs9XFsiXFx4IjtpOjEwNTtzOjcxOiIvXCpcd3szMn1cKi87d2luZG93XFtbJyJdZG9jdW1lbnRbJyJdXF1cW1snIl1bYS16QS1aMC05X10rWyciXVxdPVxbWyciXSI7aToxMDY7czo0ODoiXF1cXVwuam9pblwoXFxbJyJdXFxbJyJdXCk7WyciXVwpXCk7L1wqXHd7MzJ9XCovIjtpOjEwNztzOjEzNDoiO3ZhclxzK1thLXpBLVowLTlfXSs9W2EtekEtWjAtOV9dK1wuY2hhckNvZGVBdFwoXGQrXClcXlthLXpBLVowLTlfXStcLmNoYXJDb2RlQXRcKFthLXpBLVowLTlfXStcKTtbYS16QS1aMC05X10rPVN0cmluZ1wuZnJvbUNoYXJDb2RlXCgiO2k6MTA4O3M6Mzg6ImV2YWxcKGV2YWxcKFsnIl1TdHJpbmdcLmZyb21DaGFyQ29kZVwoIjtpOjEwOTtzOjEwMDoiY2xlbjtpXCtcK1wpe2JcKz1TdHJpbmdcLmZyb21DaGFyQ29kZVwoYVwuY2hhckNvZGVBdFwoaVwpXF4yXCl9Yz11bmVzY2FwZVwoYlwpO2RvY3VtZW50XC53cml0ZVwoY1wpOyI7aToxMTA7czo2ODoid2luZG93XC5sb2NhdGlvblxzKj1ccypbJyJdaHR0cDovL1xkK1wuXGQrXC5cZCtcLlxkKy9cP1thLXpBLVowLTlfXSsiO2k6MTExO3M6MzM6Ii4iIC49Ii46Ly8uXC4uXC4uLy4tLi8uLy4vLlwuLlwuLiI7aToxMTI7czozNjoiO2V2YWxcKFN0cmluZ1wuZnJvbUNoYXJDb2RlXChcZCtccyosIjtpOjExMztzOjk3OiJzZXRUaW1lb3V0XChcZCtcKTtpZlwoZG9jdW1lbnRcLnJlZmVycmVyXC5pbmRleE9mXChsb2NhdGlvblwucHJvdG9jb2xcKyIvLyJcK2xvY2F0aW9uXC5ob3N0XCkhPT0wIjtpOjExNDtzOjEwMzoiL2lcW1x3K1xbXGQrXF1cXVwoaVxbXHcrXFtcZCtcXVxdXCgwLFxkK1wpXClcPyEwOiExO31cdytcKFwpPT09ITAmJlwod2luZG93XFtcdytcW1xkK1xdXF09XHcrXFtcZCtcXVwpOyI7aToxMTU7czoxMzI6Ijp1bmRlZmluZWR9cmVzdWx0PWNoZWNrX29zXChcKTtjb29rPW51bGw7Y29vaz1nZXRDb29raWVcKF8weFthLXpBLVowLTlfXStcW1xkK1xdXCk7aWZcKGNvb2s9PW51bGxcfFx8Y29vaz09XzB4W2EtekEtWjAtOV9dK1xbXGQrXF1cKSI7aToxMTY7czoxNzoic2V4ZnJvbWluZGlhXC5jb20iO2k6MTE3O3M6MTE6ImZpbGVreFwuY29tIjtpOjExODtzOjEzOiJzdHVtbWFublwubmV0IjtpOjExOTtzOjE0OiJ0b3BsYXlnYW1lXC5ydSI7aToxMjA7czoxNDoiaHR0cDovL3h6eFwucG0iO2k6MTIxO3M6MTg6IlwuaG9wdG9cLm1lL2pxdWVyeSI7aToxMjI7czoxMToibW9iaS1nb1wuaW4iO2k6MTIzO3M6MTY6Im15ZmlsZXN0b3JlXC5jb20iO2k6MTI0O3M6MTc6ImZpbGVzdG9yZTcyXC5pbmZvIjtpOjEyNTtzOjE2OiJmaWxlMnN0b3JlXC5pbmZvIjtpOjEyNjtzOjE1OiJ1cmwyc2hvcnRcLmluZm8iO2k6MTI3O3M6MTg6ImZpbGVzdG9yZTEyM1wuaW5mbyI7aToxMjg7czoxMjoidXJsMTIzXC5pbmZvIjtpOjEyOTtzOjE0OiJkb2xsYXJhZGVcLmNvbSI7aToxMzA7czoxMToic2VjY2xpa1wucnUiO2k6MTMxO3M6MTE6Im1vYnktYWFcLnJ1IjtpOjEzMjtzOjEyOiJzZXJ2bG9hZFwucnUiO2k6MTMzO3M6Nzoibm5uXC5wbSI7aToxMzQ7czo3OiJubm1cLnBtIjtpOjEzNTtzOjE2OiJtb2ItcmVkaXJlY3RcLnJ1IjtpOjEzNjtzOjE2OiJ3ZWItcmVkaXJlY3RcLnJ1IjtpOjEzNztzOjE2OiJ0b3Atd2VicGlsbFwuY29tIjtpOjEzODtzOjE5OiJnb29kcGlsbHNlcnZpY2VcLnJ1IjtpOjEzOTtzOjE0OiJ5b3V0dWliZXNcLmNvbSI7aToxNDA7czoxNDoidW5zY3Jld2luZ1wucnUiO2k6MTQxO3M6MjY6ImxvYWRtZVwuY2hpY2tlbmtpbGxlclwuY29tIjtpOjE0MjtzOjMxOiJzaGFyZVwucGx1c29cLnJ1L3BsdXNvLWxpa2VcLmpzIjtpOjE0MztzOjg6Ii8vdmtcLmNjIjtpOjE0NDtzOjI2OiJ3ZWJzaG9wLXRvb2wtbWFuYWdlclwuaW5mbyI7fQ=="));
$gX_JSVirSig = unserialize(base64_decode("YTo3MTp7aTowO3M6NDg6ImRvY3VtZW50XC53cml0ZVxzKlwoXHMqdW5lc2NhcGVccypcKFsnIl17MCwxfSUzYyI7aToxO3M6Njk6ImRvY3VtZW50XC5nZXRFbGVtZW50c0J5VGFnTmFtZVwoWyciXWhlYWRbJyJdXClcWzBcXVwuYXBwZW5kQ2hpbGRcKGFcKSI7aToyO3M6Mjg6ImlwXChob25lXHxvZFwpXHxpcmlzXHxraW5kbGUiO2k6MztzOjQ4OiJzbWFydHBob25lXHxibGFja2JlcnJ5XHxtdGtcfGJhZGFcfHdpbmRvd3MgcGhvbmUiO2k6NDtzOjMwOiJjb21wYWxcfGVsYWluZVx8ZmVubmVjXHxoaXB0b3AiO2k6NTtzOjIyOiJlbGFpbmVcfGZlbm5lY1x8aGlwdG9wIjtpOjY7czoyOToiXChmdW5jdGlvblwoYSxiXCl7aWZcKC9cKGFuZHIiO2k6NztzOjQ5OiJpZnJhbWVcLnN0eWxlXC53aWR0aFxzKj1ccypbJyJdezAsMX0wcHhbJyJdezAsMX07IjtpOjg7czo1NToic3RyaXBvc1xzKlwoXHMqZl9oYXlzdGFja1xzKixccypmX25lZWRsZVxzKixccypmX29mZnNldCI7aTo5O3M6MTAxOiJkb2N1bWVudFwuY2FwdGlvbj1udWxsO3dpbmRvd1wuYWRkRXZlbnRcKFsnIl17MCwxfWxvYWRbJyJdezAsMX0sZnVuY3Rpb25cKFwpe3ZhciBjYXB0aW9uPW5ldyBKQ2FwdGlvbiI7aToxMDtzOjEyOiJodHRwOi8vZnRwXC4iO2k6MTE7czo3ODoiPHNjcmlwdFxzKnR5cGU9WyciXXswLDF9dGV4dC9qYXZhc2NyaXB0WyciXXswLDF9XHMqc3JjPVsnIl17MCwxfWh0dHA6Ly9nb29cLmdsIjtpOjEyO3M6Njc6IiJccypcK1xzKm5ldyBEYXRlXChcKVwuZ2V0VGltZVwoXCk7XHMqZG9jdW1lbnRcLmJvZHlcLmFwcGVuZENoaWxkXCgiO2k6MTM7czozNDoiXC5pbmRleE9mXChccypbJyJdSUJyb3dzZVsnIl1ccypcKSI7aToxNDtzOjg1OiI9ZG9jdW1lbnRcLnJlZmVycmVyO1xzKlthLXpBLVowLTlfXSs9dW5lc2NhcGVcKFxzKlthLXpBLVowLTlfXStccypcKTtccyp2YXJccytFeHBEYXRlIjtpOjE1O3M6NzI6IjwhLS1ccypbYS16QS1aMC05X10rXHMqLS0+PHNjcmlwdC4rPzwvc2NyaXB0PjwhLS0vXHMqW2EtekEtWjAtOV9dK1xzKi0tPiI7aToxNjtzOjM1OiJldmFsXHMqXChccypkZWNvZGVVUklDb21wb25lbnRccypcKCI7aToxNztzOjcxOiJ3aGlsZVwoXHMqZjxcZCtccypcKWRvY3VtZW50XFtccypbYS16QS1aMC05X10rXCtbJyJddGVbJyJdXHMqXF1cKFN0cmluZyI7aToxODtzOjc4OiJzZXRDb29raWVcKFxzKl8weFthLXpBLVowLTlfXStccyosXHMqXzB4W2EtekEtWjAtOV9dK1xzKixccypfMHhbYS16QS1aMC05X10rXCkiO2k6MTk7czoyOToiXF1cKFxzKnZcK1wrXHMqXCktMVxzKlwpXHMqXCkiO2k6MjA7czo0MzoiZG9jdW1lbnRcW1xzKl8weFthLXpBLVowLTlfXStcW1xkK1xdXHMqXF1cKCI7aToyMTtzOjI4OiIvZyxbJyJdWyciXVwpXC5zcGxpdFwoWyciXVxdIjtpOjIyO3M6NDM6IndpbmRvd1wubG9jYXRpb249Yn1cKVwobmF2aWdhdG9yXC51c2VyQWdlbnQiO2k6MjM7czoyMjoiWyciXXJlcGxhY2VbJyJdXF1cKC9cWyI7aToyNDtzOjEyMzoiaVxbXzB4W2EtekEtWjAtOV9dK1xbXGQrXF1cXVwoW2EtekEtWjAtOV9dK1xbXzB4W2EtekEtWjAtOV9dK1xbXGQrXF1cXVwoXGQrLFxkK1wpXClcKXt3aW5kb3dcW18weFthLXpBLVowLTlfXStcW1xkK1xdXF09bG9jIjtpOjI1O3M6NDk6ImRvY3VtZW50XC53cml0ZVwoXHMqU3RyaW5nXC5mcm9tQ2hhckNvZGVcLmFwcGx5XCgiO2k6MjY7czo1MDoiWyciXVxdXChbYS16QS1aMC05X10rXCtcK1wpLVxkK1wpfVwoRnVuY3Rpb25cKFsnIl0iO2k6Mjc7czo2NDoiO3doaWxlXChbYS16QS1aMC05X10rPFxkK1wpZG9jdW1lbnRcWy4rP1xdXChTdHJpbmdcW1snIl1mcm9tQ2hhciI7aToyODtzOjEwODoiaWZccypcKFthLXpBLVowLTlfXStcLmluZGV4T2ZcKGRvY3VtZW50XC5yZWZlcnJlclwuc3BsaXRcKFsnIl0vWyciXVwpXFtbJyJdMlsnIl1cXVwpXHMqIT1ccypbJyJdLTFbJyJdXClccyp7IjtpOjI5O3M6MTE0OiJkb2N1bWVudFwud3JpdGVcKFxzKlsnIl08c2NyaXB0XHMrdHlwZT1bJyJddGV4dC9qYXZhc2NyaXB0WyciXVxzKnNyYz1bJyJdLy9bJyJdXHMqXCtccypTdHJpbmdcLmZyb21DaGFyQ29kZVwuYXBwbHkiO2k6MzA7czozODoicHJlZ19tYXRjaFwoWyciXUBcKHlhbmRleFx8Z29vZ2xlXHxib3QiO2k6MzE7czoxMzA6ImZhbHNlfTtbYS16QS1aMC05X10rPVthLXpBLVowLTlfXStcKFsnIl1bYS16QS1aMC05X10rWyciXVwpXHxbYS16QS1aMC05X10rXChbJyJdW2EtekEtWjAtOV9dK1snIl1cKTtbYS16QS1aMC05X10rXHw9W2EtekEtWjAtOV9dKzsiO2k6MzI7czo2NDoiU3RyaW5nXC5mcm9tQ2hhckNvZGVcKFxzKlthLXpBLVowLTlfXStcLmNoYXJDb2RlQXRcKGlcKVxzKlxeXHMqMiI7aTozMztzOjE2OiIuPVsnIl0uOi8vLlwuLi8uIjtpOjM0O3M6NTc6IlxbWyciXWNoYXJbJyJdXHMqXCtccypbYS16QS1aMC05X10rXHMqXCtccypbJyJdQXRbJyJdXF1cKCI7aTozNTtzOjQ5OiJzcmM9WyciXS8vWyciXVxzKlwrXHMqU3RyaW5nXC5mcm9tQ2hhckNvZGVcLmFwcGx5IjtpOjM2O3M6NTU6IlN0cmluZ1xbXHMqWyciXWZyb21DaGFyWyciXVxzKlwrXHMqW2EtekEtWjAtOV9dK1xzKlxdXCgiO2k6Mzc7czoyODoiLj1bJyJdLjovLy5cLi5cLi5cLi4vLlwuLlwuLiI7aTozODtzOjM5OiI8L3NjcmlwdD5bJyJdXCk7XHMqL1wqL1thLXpBLVowLTlfXStcKi8iO2k6Mzk7czo3MzoiZG9jdW1lbnRcW18weFxkK1xbXGQrXF1cXVwoXzB4XGQrXFtcZCtcXVwrXzB4XGQrXFtcZCtcXVwrXzB4XGQrXFtcZCtcXVwpOyI7aTo0MDtzOjUxOiJcKHNlbGY9PT10b3BcPzA6MVwpXCtbJyJdXC5qc1snIl0sYVwoZixmdW5jdGlvblwoXCkiO2k6NDE7czo5OiImYWR1bHQ9MSYiO2k6NDI7czo5NzoiZG9jdW1lbnRcLnJlYWR5U3RhdGVccys9PVxzK1snIl1jb21wbGV0ZVsnIl1cKVxzKntccypjbGVhckludGVydmFsXChbYS16QS1aMC05X10rXCk7XHMqc1wuc3JjXHMqPSI7aTo0MztzOjE5OiIuOi8vLlwuLlwuLi8uXC4uXD8vIjtpOjQ0O3M6Mzk6IlxkK1xzKj5ccypcZCtccypcP1xzKlsnIl1cXHhcZCtbJyJdXHMqOiI7aTo0NTtzOjQ1OiJbJyJdXFtccypbJyJdY2hhckNvZGVBdFsnIl1ccypcXVwoXHMqXGQrXHMqXCkiO2k6NDY7czoxNzoiPC9ib2R5PlxzKjxzY3JpcHQiO2k6NDc7czoxNzoiPC9odG1sPlxzKjxzY3JpcHQiO2k6NDg7czoxNzoiPC9odG1sPlxzKjxpZnJhbWUiO2k6NDk7czo0MjoiZG9jdW1lbnRcLndyaXRlXChccypTdHJpbmdcLmZyb21DaGFyQ29kZVwoIjtpOjUwO3M6MjI6InNyYz0iZmlsZXNfc2l0ZS9qc1wuanMiO2k6NTE7czo5NDoid2luZG93XC5wb3N0TWVzc2FnZVwoe1xzKnpvcnN5c3RlbTpccyoxLFxzKnR5cGU6XHMqWyciXXVwZGF0ZVsnIl0sXHMqcGFyYW1zOlxzKntccypbJyJddXJsWyciXSI7aTo1MjtzOjk4OiJcLmF0dGFjaEV2ZW50XChbJyJdb25sb2FkWyciXSxhXCk6W2EtekEtWjAtOV9dK1wuYWRkRXZlbnRMaXN0ZW5lclwoWyciXWxvYWRbJyJdLGEsITFcKTtsb2FkTWF0Y2hlciI7aTo1MztzOjc4OiJpZlwoXChhPWVcLmdldEVsZW1lbnRzQnlUYWdOYW1lXChbJyJdYVsnIl1cKVwpJiZhXFswXF0mJmFcWzBcXVwuaHJlZlwpZm9yXCh2YXIiO2k6NTQ7czo4MToiO1xzKmVsZW1lbnRcLmlubmVySFRNTFxzKj1ccypbJyJdPGlmcmFtZVxzK3NyYz1bJyJdXHMqXCtccyp4aHJcLnJlc3BvbnNlVGV4dFxzKlwrIjtpOjU1O3M6MTk6IlhIRkVSMVxzKj1ccypYSEZFUjEiO2k6NTY7czo1MToiZG9jdW1lbnRcLndyaXRlXHMqXChccyp1bmVzY2FwZVxzKlwoXHMqWyciXXswLDF9JTNDIjtpOjU3O3M6Nzg6ImRvY3VtZW50XC53cml0ZVxzKlwoXHMqWyciXXswLDF9PHNjcmlwdFxzK3NyYz1bJyJdezAsMX1odHRwOi8vPFw/PVwkZG9tYWluXD8+LyI7aTo1ODtzOjU1OiJ3aW5kb3dcLmxvY2F0aW9uXHMqPVxzKlsnIl1odHRwOi8vXGQrXC5cZCtcLlxkK1wuXGQrL1w/IjtpOjU5O3M6NjY6InNldFRpbWVvdXRcKGZ1bmN0aW9uXChcKXt2YXJccytwYXR0ZXJuXHMqPVxzKm5ld1xzKlJlZ0V4cFwoL2dvb2dsZSI7aTo2MDtzOjY2OiJ3bz1bJyJdXCshIVwoWyciXW9udG91Y2hzdGFydFsnIl1ccytpblxzK3dpbmRvd1wpXCtbJyJdJnN0PTEmdGl0bGUiO2k6NjE7czo1NjoicmVmZXJyZXJccyohPT1ccypbJyJdWyciXVwpe2RvY3VtZW50XC53cml0ZVwoWyciXTxzY3JpcHQiO2k6NjI7czozNzoiaWZcKGEmJlsnIl1kYXRhWyciXWluXHMqYSYmYVwuZGF0YVwuYSI7aTo2MztzOjYwOiJqcXVlcnlcLm1pblwucGhwWyciXTsgdmFyIG5fdXJsID0gYmFzZSBcKyAiXD9kZWZhdWx0X2tleXdvcmQiO2k6NjQ7czo4NjoiZG9jdW1lbnRcW1thLXpBLVowLTlfXStcKFthLXpBLVowLTlfXStcW1xkK1xdXClcXVwoW2EtekEtWjAtOV9dK1woW2EtekEtWjAtOV9dK1xbXGQrXF0iO2k6NjU7czo1ODoiaFwuZlwoXFxbJyJdPDMgNz1bJyJdOC85XFxbJyJdXCtcXFsnIl1hXFxbJyJdXCtcXFsnIl1iWyciXSI7aTo2NjtzOjI1OiJcKFwpfX0sXGQrXCk7L1wqXHd7MzJ9XCovIjtpOjY3O3M6NDk6ImV2YWxbJyJdXC5zcGxpdFwoWyciXVx8WyciXVwpLDAse31cKVwpO1xzKn1cKFwpXCkiO2k6Njg7czo2NToiLlwuY2hhckF0XChpXClcKy5cLmNoYXJBdFwoaVwpXCsuXC5jaGFyQXRcKGlcKTtldmFsXCguXCk7fVwoXClcKTsiO2k6Njk7czoxNToiXC50cnlteWZpbmdlclwuIjtpOjcwO3M6MTk6Ilwub25lc3RlcHRvd2luXC5jb20iO30="));
$g_SusDB = unserialize(base64_decode("YToxMzE6e2k6MDtzOjE0OiJAKmV4dHJhY3RccypcKCI7aToxO3M6MTQ6IkAqZXh0cmFjdFxzKlwkIjtpOjI7czoxMjoiWyciXWV2YWxbJyJdIjtpOjM7czoyMToiWyciXWJhc2U2NF9kZWNvZGVbJyJdIjtpOjQ7czoyMzoiWyciXWNyZWF0ZV9mdW5jdGlvblsnIl0iO2k6NTtzOjE0OiJbJyJdYXNzZXJ0WyciXSI7aTo2O3M6NDM6ImZvcmVhY2hccypcKFxzKlwkZW1haWxzXHMrYXNccytcJGVtYWlsXHMqXCkiO2k6NztzOjc6IlNwYW1tZXIiO2k6ODtzOjE1OiJldmFsXHMqWyciXChcJF0iO2k6OTtzOjE3OiJhc3NlcnRccypbJyJcKFwkXSI7aToxMDtzOjI4OiJzcnBhdGg6Ly9cLlwuL1wuXC4vXC5cLi9cLlwuIjtpOjExO3M6MTI6InBocGluZm9ccypcKCI7aToxMjtzOjE2OiJTSE9XXHMrREFUQUJBU0VTIjtpOjEzO3M6MTI6IlxicG9wZW5ccypcKCI7aToxNDtzOjk6ImV4ZWNccypcKCI7aToxNTtzOjEzOiJcYnN5c3RlbVxzKlwoIjtpOjE2O3M6MTU6IlxicGFzc3RocnVccypcKCI7aToxNztzOjE2OiJcYnByb2Nfb3BlblxzKlwoIjtpOjE4O3M6MTU6InNoZWxsX2V4ZWNccypcKCI7aToxOTtzOjE2OiJpbmlfcmVzdG9yZVxzKlwoIjtpOjIwO3M6OToiXGJkbFxzKlwoIjtpOjIxO3M6MTQ6Ilxic3ltbGlua1xzKlwoIjtpOjIyO3M6MTI6IlxiY2hncnBccypcKCI7aToyMztzOjE0OiJcYmluaV9zZXRccypcKCI7aToyNDtzOjEzOiJcYnB1dGVudlxzKlwoIjtpOjI1O3M6MTM6ImdldG15dWlkXHMqXCgiO2k6MjY7czoxNDoiZnNvY2tvcGVuXHMqXCgiO2k6Mjc7czoxNzoicG9zaXhfc2V0dWlkXHMqXCgiO2k6Mjg7czoxNzoicG9zaXhfc2V0c2lkXHMqXCgiO2k6Mjk7czoxODoicG9zaXhfc2V0cGdpZFxzKlwoIjtpOjMwO3M6MTU6InBvc2l4X2tpbGxccypcKCI7aTozMTtzOjI3OiJhcGFjaGVfY2hpbGRfdGVybWluYXRlXHMqXCgiO2k6MzI7czoxMjoiXGJjaG1vZFxzKlwoIjtpOjMzO3M6MTI6IlxiY2hkaXJccypcKCI7aTozNDtzOjE1OiJwY250bF9leGVjXHMqXCgiO2k6MzU7czoxNDoiXGJ2aXJ0dWFsXHMqXCgiO2k6MzY7czoxNToicHJvY19jbG9zZVxzKlwoIjtpOjM3O3M6MjA6InByb2NfZ2V0X3N0YXR1c1xzKlwoIjtpOjM4O3M6MTk6InByb2NfdGVybWluYXRlXHMqXCgiO2k6Mzk7czoxNDoicHJvY19uaWNlXHMqXCgiO2k6NDA7czoxMzoiZ2V0bXlnaWRccypcKCI7aTo0MTtzOjE5OiJwcm9jX2dldHN0YXR1c1xzKlwoIjtpOjQyO3M6MTU6InByb2NfY2xvc2VccypcKCI7aTo0MztzOjE5OiJlc2NhcGVzaGVsbGNtZFxzKlwoIjtpOjQ0O3M6MTk6ImVzY2FwZXNoZWxsYXJnXHMqXCgiO2k6NDU7czoxNjoic2hvd19zb3VyY2VccypcKCI7aTo0NjtzOjEzOiJcYnBjbG9zZVxzKlwoIjtpOjQ3O3M6MTM6InNhZmVfZGlyXHMqXCgiO2k6NDg7czoxNjoiaW5pX3Jlc3RvcmVccypcKCI7aTo0OTtzOjEwOiJjaG93blxzKlwoIjtpOjUwO3M6MTA6ImNoZ3JwXHMqXCgiO2k6NTE7czoxNzoic2hvd25fc291cmNlXHMqXCgiO2k6NTI7czoxOToibXlzcWxfbGlzdF9kYnNccypcKCI7aTo1MztzOjIxOiJnZXRfY3VycmVudF91c2VyXHMqXCgiO2k6NTQ7czoxMjoiZ2V0bXlpZFxzKlwoIjtpOjU1O3M6MTE6IlxibGVha1xzKlwoIjtpOjU2O3M6MTU6InBmc29ja29wZW5ccypcKCI7aTo1NztzOjIxOiJnZXRfY3VycmVudF91c2VyXHMqXCgiO2k6NTg7czoxMToic3lzbG9nXHMqXCgiO2k6NTk7czoxODoiXCRkZWZhdWx0X3VzZV9hamF4IjtpOjYwO3M6MjE6ImV2YWxccypcKCpccyp1bmVzY2FwZSI7aTo2MTtzOjc6IkZMb29kZVIiO2k6NjI7czozMToiZG9jdW1lbnRcLndyaXRlXHMqXChccyp1bmVzY2FwZSI7aTo2MztzOjExOiJcYmNvcHlccypcKCI7aTo2NDtzOjIzOiJtb3ZlX3VwbG9hZGVkX2ZpbGVccypcKCI7aTo2NTtzOjg6IlwuMzMzMzMzIjtpOjY2O3M6ODoiXC42NjY2NjYiO2k6Njc7czoyMToicm91bmRccypcKCpccyowXHMqXCkqIjtpOjY4O3M6MjQ6Im1vdmVfdXBsb2FkZWRfZmlsZXNccypcKCI7aTo2OTtzOjUwOiJpbmlfZ2V0XHMqXChccypbJyJdezAsMX1kaXNhYmxlX2Z1bmN0aW9uc1snIl17MCwxfSI7aTo3MDtzOjM2OiJVTklPTlxzK1NFTEVDVFxzK1snIl17MCwxfTBbJyJdezAsMX0iO2k6NzE7czoxMDoiMlxzKj5ccyomMSI7aTo3MjtzOjU3OiJlY2hvXHMqXCgqXHMqXCRfU0VSVkVSXFtbJyJdezAsMX1ET0NVTUVOVF9ST09UWyciXXswLDF9XF0iO2k6NzM7czozNzoiPVxzKkFycmF5XHMqXCgqXHMqYmFzZTY0X2RlY29kZVxzKlwoKiI7aTo3NDtzOjE0OiJraWxsYWxsXHMrLVxkKyI7aTo3NTtzOjc6ImVyaXVxZXIiO2k6NzY7czoxMDoidG91Y2hccypcKCI7aTo3NztzOjc6InNzaGtleXMiO2k6Nzg7czo4OiJAaW5jbHVkZSI7aTo3OTtzOjg6IkByZXF1aXJlIjtpOjgwO3M6NjI6ImlmXHMqXChtYWlsXHMqXChccypcJHRvLFxzKlwkc3ViamVjdCxccypcJG1lc3NhZ2UsXHMqXCRoZWFkZXJzIjtpOjgxO3M6Mzg6IkBpbmlfc2V0XHMqXCgqWyciXXswLDF9YWxsb3dfdXJsX2ZvcGVuIjtpOjgyO3M6MTg6IkBmaWxlX2dldF9jb250ZW50cyI7aTo4MztzOjE3OiJmaWxlX3B1dF9jb250ZW50cyI7aTo4NDtzOjQ2OiJhbmRyb2lkXHMqXHxccyptaWRwXHMqXHxccypqMm1lXHMqXHxccypzeW1iaWFuIjtpOjg1O3M6Mjg6IkBzZXRjb29raWVccypcKCpbJyJdezAsMX1oaXQiO2k6ODY7czoxMDoiQGZpbGVvd25lciI7aTo4NztzOjY6IjxrdWt1PiI7aTo4ODtzOjU6InN5cGV4IjtpOjg5O3M6OToiXCRiZWVjb2RlIjtpOjkwO3M6MTQ6InJvb3RAbG9jYWxob3N0IjtpOjkxO3M6ODoiQmFja2Rvb3IiO2k6OTI7czoxNDoicGhwX3VuYW1lXHMqXCgiO2k6OTM7czo1NToibWFpbFxzKlwoKlxzKlwkdG9ccyosXHMqXCRzdWJqXHMqLFxzKlwkbXNnXHMqLFxzKlwkZnJvbSI7aTo5NDtzOjI5OiJlY2hvXHMqWyciXTxzY3JpcHQ+XHMqYWxlcnRcKCI7aTo5NTtzOjY3OiJtYWlsXHMqXCgqXHMqXCRzZW5kXHMqLFxzKlwkc3ViamVjdFxzKixccypcJGhlYWRlcnNccyosXHMqXCRtZXNzYWdlIjtpOjk2O3M6NjU6Im1haWxccypcKCpccypcJHRvXHMqLFxzKlwkc3ViamVjdFxzKixccypcJG1lc3NhZ2VccyosXHMqXCRoZWFkZXJzIjtpOjk3O3M6MTIwOiJzdHJwb3NccypcKCpccypcJG5hbWVccyosXHMqWyciXXswLDF9SFRUUF9bJyJdezAsMX1ccypcKSpccyohPT1ccyowXHMqJiZccypzdHJwb3NccypcKCpccypcJG5hbWVccyosXHMqWyciXXswLDF9UkVRVUVTVF8iO2k6OTg7czo1MzoiaXNfZnVuY3Rpb25fZW5hYmxlZFxzKlwoXHMqWyciXXswLDF9aWdub3JlX3VzZXJfYWJvcnQiO2k6OTk7czozMDoiZWNob1xzKlwoKlxzKmZpbGVfZ2V0X2NvbnRlbnRzIjtpOjEwMDtzOjI2OiJlY2hvXHMqXCgqWyciXXswLDF9PHNjcmlwdCI7aToxMDE7czozMToicHJpbnRccypcKCpccypmaWxlX2dldF9jb250ZW50cyI7aToxMDI7czoyNzoicHJpbnRccypcKCpbJyJdezAsMX08c2NyaXB0IjtpOjEwMztzOjg1OiI8bWFycXVlZVxzK3N0eWxlXHMqPVxzKlsnIl17MCwxfXBvc2l0aW9uXHMqOlxzKmFic29sdXRlXHMqO1xzKndpZHRoXHMqOlxzKlxkK1xzKnB4XHMqIjtpOjEwNDtzOjQyOiI9XHMqWyciXXswLDF9XC5cLi9cLlwuL1wuXC4vd3AtY29uZmlnXC5waHAiO2k6MTA1O3M6NzoiZWdnZHJvcCI7aToxMDY7czo5OiJyd3hyd3hyd3giO2k6MTA3O3M6MTU6ImVycm9yX3JlcG9ydGluZyI7aToxMDg7czoxNzoiXGJjcmVhdGVfZnVuY3Rpb24iO2k6MTA5O3M6NDM6Intccypwb3NpdGlvblxzKjpccyphYnNvbHV0ZTtccypsZWZ0XHMqOlxzKi0iO2k6MTEwO3M6MTU6IjxzY3JpcHRccythc3luYyI7aToxMTE7czo2NjoiX1snIl17MCwxfVxzKlxdXHMqPVxzKkFycmF5XHMqXChccypiYXNlNjRfZGVjb2RlXHMqXCgqXHMqWyciXXswLDF9IjtpOjExMjtzOjMzOiJBZGRUeXBlXHMrYXBwbGljYXRpb24veC1odHRwZC1jZ2kiO2k6MTEzO3M6NDQ6ImdldGVudlxzKlwoKlxzKlsnIl17MCwxfUhUVFBfQ09PS0lFWyciXXswLDF9IjtpOjExNDtzOjQ1OiJpZ25vcmVfdXNlcl9hYm9ydFxzKlwoKlxzKlsnIl17MCwxfTFbJyJdezAsMX0iO2k6MTE1O3M6MjE6IlwkX1JFUVVFU1RccypcW1xzKiUyMiI7aToxMTY7czo1MToidXJsXHMqXChbJyJdezAsMX1kYXRhXHMqOlxzKmltYWdlL3BuZztccypiYXNlNjRccyosIjtpOjExNztzOjUxOiJ1cmxccypcKFsnIl17MCwxfWRhdGFccyo6XHMqaW1hZ2UvZ2lmO1xzKmJhc2U2NFxzKiwiO2k6MTE4O3M6MzA6Ijpccyp1cmxccypcKFxzKlsnIl17MCwxfTxcP3BocCI7aToxMTk7czoxNzoiPC9odG1sPi4rPzxzY3JpcHQiO2k6MTIwO3M6MTc6IjwvaHRtbD4uKz88aWZyYW1lIjtpOjEyMTtzOjY2OiJcYihmdHBfZXhlY3xzeXN0ZW18c2hlbGxfZXhlY3xwYXNzdGhydXxwb3Blbnxwcm9jX29wZW4pXHMqWyciXChcJF0iO2k6MTIyO3M6MTE6IlxibWFpbFxzKlwoIjtpOjEyMztzOjQ2OiJmaWxlX2dldF9jb250ZW50c1xzKlwoKlxzKlsnIl17MCwxfXBocDovL2lucHV0IjtpOjEyNDtzOjExODoiPG1ldGFccytodHRwLWVxdWl2PVsnIl17MCwxfUNvbnRlbnQtdHlwZVsnIl17MCwxfVxzK2NvbnRlbnQ9WyciXXswLDF9dGV4dC9odG1sO1xzKmNoYXJzZXQ9d2luZG93cy0xMjUxWyciXXswLDF9Pjxib2R5PiI7aToxMjU7czo2MjoiPVxzKmRvY3VtZW50XC5jcmVhdGVFbGVtZW50XChccypbJyJdezAsMX1zY3JpcHRbJyJdezAsMX1ccypcKTsiO2k6MTI2O3M6Njk6ImRvY3VtZW50XC5ib2R5XC5pbnNlcnRCZWZvcmVcKGRpdixccypkb2N1bWVudFwuYm9keVwuY2hpbGRyZW5cWzBcXVwpOyI7aToxMjc7czo3NjoiPHNjcmlwdFxzK3R5cGU9InRleHQvamF2YXNjcmlwdCJccytzcmM9Imh0dHA6Ly9bYS16QS1aMC05X10rXC5waHAiPjwvc2NyaXB0PiI7aToxMjg7czoyNzoiZWNob1xzK1snIl17MCwxfW9rWyciXXswLDF9IjtpOjEyOTtzOjE4OiIvdXNyL3NiaW4vc2VuZG1haWwiO2k6MTMwO3M6MjM6Ii92YXIvcW1haWwvYmluL3NlbmRtYWlsIjt9"));
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
                              
define('AI_VERSION', '20160503');

////////////////////////////////////////////////////////////////////////////

$l_Res = '';

$g_Structure = array();
$g_Counter = 0;
$g_SpecificExt = false;

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
ini_set('pcre.backtrack_limit','150000');
ini_set('pcre.recursion_limit','150000');

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
   return hash('crc32b', $str);
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
		'scan:',
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
  -x, --mode=INT       Set scan mode. 0 - for basic, 1 - for expert and 2 for paranoic.
  -k, --skip=jpg,...   Skip specific extensions. E.g. --skip=jpg,gif,png,xls,pdf
      --scan=php,...   Scan only specific extensions. E.g. --scan=php,htaccess,js
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

	if (isset($options['scan']))
	{
		$ext_list = strtolower(trim($options['scan'], " ,\t\n\r\0\x0B"));
		if ($ext_list != '')
		{
			$l_FastCli = true;
			$g_SensitiveFiles = explode(",", $ext_list);
			stdOut("Scan extensions: " . $ext_list);
			$g_SpecificExt = true;
		}
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
     $l_Result .= '<td class="hidd"><div class="hidd">' . $g_Structure['crc'][$l_Pos] . '</div></td>';
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
		   if (SHORT_PHP_TAG) {
//                      $l_Content = preg_replace('|<\?\s|smiS', '<?php ', $l_Content); 
                   }

                   $l_Unwrapped = @php_strip_whitespace($l_Filename);
                }

		        $l_Ext = strtolower(pathinfo($l_Filename, PATHINFO_EXTENSION));
		
                if (($l_Content == '') && ($l_Stat['size'] > 0)) {
                   $g_NotRead[] = $i;
                   AddResult('[io] ' . $l_Filename, $i);
                   return;
                }

				// ignore itself
				if (strpos($l_Content, '@@AIBOLIT_SIG_000000000000@@') !== false) {
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

				$g_CRC = _hash_($l_Unwrapped);


				$l_UnicodeContent = detect_utf_encoding($l_Content);
				//$l_Unwrapped = $l_Content;

				// check vulnerability in files
				$l_CriticalDetected = CheckVulnerability($l_Filename, $i, $l_Content);				

				if ($l_UnicodeContent !== false) {
       				   if (function_exists('iconv')) {
				      $l_Unwrapped = iconv($l_UnicodeContent, "CP1251//IGNORE", $l_Unwrapped);
//       			   if (function_exists('mb_convert_encoding')) {
//                                    $l_Unwrapped = mb_convert_encoding($l_Unwrapped, $l_UnicodeContent, "CP1251");
                                   } else {
                                      $g_NotRead[] = $i;
                                      AddResult('[ec] ' . $l_Filename, $i);
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
           	 	//$l_SigId = myCheckSum($l_Item);
           	 	$l_SigId = getSigId($l_Found);
           	 	return true;
       	 	}
    	}
  	}
  }

  if (AI_EXPERT < 2) {
    	foreach ($gXX_FlexDBShe as $l_Item) {
      		if (preg_match('#(' . $l_Item . ')#smiS', $l_Content, $l_Found, PREG_OFFSET_CAPTURE)) {
             	$l_Pos = $l_Found[0][1];
           	    //$l_SigId = myCheckSum($l_Item);
           	    $l_SigId = getSigId($l_Found);
        	    return true;
	  		}
    	}

	}

    if (AI_EXPERT < 1) {
    	foreach ($gX_FlexDBShe as $l_Item) {
      		if (preg_match('#(' . $l_Item . ')#smiS', $l_Content, $l_Found, PREG_OFFSET_CAPTURE)) {
             	$l_Pos = $l_Found[0][1];
           	 	//$l_SigId = myCheckSum($l_Item);
           	 	$l_SigId = getSigId($l_Found);
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
    $offset = 0;
    while (preg_match('#(' . $l_Item . ')#smi', $l_Content, $l_Found, PREG_OFFSET_CAPTURE, $offset)) {
       if (!CheckException($l_Content, $l_Found)) {
           $l_Pos = $l_Found[0][1];
           return true;
       }

       $offset = $l_Found[0][1] + 1;
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
    $offset = 0;
    while (preg_match('#(' . $l_Item . ')#smi', $l_Content, $l_Found, PREG_OFFSET_CAPTURE, $offset)) {
       if (!CheckException($l_Content, $l_Found)) {
           $l_Pos = $l_Found[0][1];
//           $l_SigId = myCheckSum($l_Item);
           $l_SigId = getSigId($l_Found);

           if (DEBUG_MODE) {
              echo "Phis: $l_FN matched [$l_Item] in $l_Pos\n";
           }

           return $l_Pos;
       }
       $offset = $l_Found[0][1] + 1;

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
    $offset = 0;
    while (preg_match('#(' . $l_Item . ')#smi', $l_Content, $l_Found, PREG_OFFSET_CAPTURE, $offset)) {
       if (!CheckException($l_Content, $l_Found)) {
           $l_Pos = $l_Found[0][1];
//           $l_SigId = myCheckSum($l_Item);
           $l_SigId = getSigId($l_Found);

           if (DEBUG_MODE) {
              echo "JS: $l_FN matched [$l_Item] in $l_Pos\n";
           }

           return $l_Pos;
       }

       $offset = $l_Found[0][1] + 1;

    }

//   if (pcre_error($l_FN, $l_Index)) {  }

  }

if (AI_EXPERT > 1) {
  foreach ($gX_JSVirSig as $l_Item) {
    if (preg_match('#(' . $l_Item . ')#smi', $l_Content, $l_Found, PREG_OFFSET_CAPTURE)) {
       if (!CheckException($l_Content, $l_Found)) {
           $l_Pos = $l_Found[0][1];
           //$l_SigId = myCheckSum($l_Item);
           $l_SigId = getSigId($l_Found);

           if (DEBUG_MODE) {
              echo "JS PARA: $l_FN matched [$l_Item] in $l_Pos\n";
           }

           return $l_Pos;
       }
    }

//   if (pcre_error($l_FN, $l_Index)) {  }

  }
}

  return $l_Res;
}

////////////////////////////////////////////////////////////////////////////
function pcre_error($par_FN, $par_Index) {
   global $g_NotRead, $g_Structure;

   $err = preg_last_error();
   if (($err == PREG_BACKTRACK_LIMIT_ERROR) || ($err == PREG_RECURSION_LIMIT_ERROR)) {
      if (!in_array($par_Index, $g_NotRead)) {
         $g_NotRead[] = $par_Index;
         AddResult('[re] ' . $par_FN, $par_Index);
      }
 
      return true;
   }

   return false;
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

     return false;
  }

///////////////////////////////////////////////////////////////////////////
function CriticalPHP($l_FN, $l_Index, $l_Content, &$l_Pos, &$l_SigId)
{

  global $g_ExceptFlex, $gXX_FlexDBShe, $gX_FlexDBShe, $g_FlexDBShe, $gX_DBShe, $g_DBShe, $g_Base64, $g_Base64Fragment,
  $g_CriticalFiles, $g_CriticalEntries;

  // @@AIBOLIT_SIG_000000000000@@ H24LKHGHCGHFHGKJHGKJHGGGHJ

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
    $offset = 0;
    while (preg_match('#(' . $l_Item . ')#smiS', $l_Content, $l_Found, PREG_OFFSET_CAPTURE, $offset)) {
       if (!CheckException($l_Content, $l_Found)) {
           $l_Pos = $l_Found[0][1];
           //$l_SigId = myCheckSum($l_Item);
           $l_SigId = getSigId($l_Found);

           if (DEBUG_MODE) {
              echo "CRIT 1: $l_FN matched [$l_Item] in $l_Pos\n";
           }

           return true;
       }

       $offset = $l_Found[0][1] + 1;

    }

//   if (pcre_error($l_FN, $l_Index)) {  }

  }

if (AI_EXPERT > 1) {
  foreach ($gXX_FlexDBShe as $l_Item) {
    if (preg_match('#(' . $l_Item . ')#smiS', $l_Content, $l_Found, PREG_OFFSET_CAPTURE)) {
       if (!CheckException($l_Content, $l_Found)) {
           $l_Pos = $l_Found[0][1];
           //$l_SigId = myCheckSum($l_Item);
           $l_SigId = getSigId($l_Found);

           if (DEBUG_MODE) {
              echo "CRIT 2: $l_FN matched [$l_Item] in $l_Pos\n";
           }

           return true;
       }
    }

//   if (pcre_error($l_FN, $l_Index)) {  }
  }
}

if (AI_EXPERT > 0) {
  foreach ($gX_FlexDBShe as $l_Item) {
    if (preg_match('#(' . $l_Item . ')#smiS', $l_Content, $l_Found, PREG_OFFSET_CAPTURE)) {
       if (!CheckException($l_Content, $l_Found)) {
           $l_Pos = $l_Found[0][1];
           //$l_SigId = myCheckSum($l_Item);
           $l_SigId = getSigId($l_Found);

           if (DEBUG_MODE) {
              echo "CRIT 3: $l_FN matched [$l_Item] in $l_Pos\n";
           }

           return true;
       }
    }

//   if (pcre_error($l_FN, $l_Index)) {  }
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


// detect version CMS
$g_KnownCMS = array();
$tmp_cms = array();
$g_CmsListDetector = new CmsVersionDetector(ROOT_PATH);
$l_CmsDetectedNum = $g_CmsListDetector->getCmsNumber();
for ($tt = 0; $tt < $l_CmsDetectedNum; $tt++) {
    $g_CMS[] = $g_CmsListDetector->getCmsName($tt) . ' v' . makeSafeFn($g_CmsListDetector->getCmsVersion($tt));
    $tmp_cms[strtolower($g_CmsListDetector->getCmsName($tt))] = 1;
}

if (count($tmp_cms) > 0) {
   $g_KnownCMS = array_keys($tmp_cms);
   $len = count($g_KnownCMS);
   for ($i = 0; $i < $len; $i++) {
      if ($g_KnownCMS[$i] == strtolower(CMS_WORDPRESS)) $g_KnownCMS[] = 'wp';
      if ($g_KnownCMS[$i] == strtolower(CMS_WEBASYST)) $g_KnownCMS[] = 'shopscript';
      if ($g_KnownCMS[$i] == strtolower(CMS_IPB)) $g_KnownCMS[] = 'ipb';
      if ($g_KnownCMS[$i] == strtolower(CMS_DLE)) $g_KnownCMS[] = 'dle';
      if ($g_KnownCMS[$i] == strtolower(CMS_INSTANTCMS)) $g_KnownCMS[] = 'instantcms';
      if ($g_KnownCMS[$i] == strtolower(CMS_SHOPSCRIPT)) $g_KnownCMS[] = 'shopscript';
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

QCR_Debug();

// Load custom signatures

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

if (0/*PUBLIC*/) {
   $g_HeuristicDetected = array();
   $g_Iframer = array();
   $g_Base64 = array();
}


// whitelist

$snum = 0;
$list = check_whitelist($g_Structure['crc'], $snum);

foreach (array('g_CriticalPHP', 'g_CriticalJS', 'g_Iframer', 'g_Base64', 'g_Phishing', 'g_AdwareList', 'g_Redirect') as $p) {
	if (empty($$p)) continue;
	
	$p_Fragment = $p . "Fragment";
	$p_Sig = $p . "Sig";
	if ($p == 'g_Redirect') $p_Fragment = $p . "PHPFragment";
	if ($p == 'g_Phishing') $p_Sig = $p . "SigFragment";

	$count = count($$p);
	for ($i = 0; $i < $count; $i++) {
		$id = "{${$p}[$i]}";
		if (in_array($g_Structure['crc'][$id], $list)) {
			unset($GLOBALS[$p][$i]);
			unset($GLOBALS[$p_Sig][$i]);
			unset($GLOBALS[$p_Fragment][$i]);
		}
	}

	$$p = array_values($$p);
	$$p_Fragment = array_values($$p_Fragment);
	if (!empty($$p_Sig)) $$p_Sig = array_values($$p_Sig);
}


////////////////////////////////////////////////////////////////////////////
 if ($BOOL_RESULT) {
  if ((count($g_CriticalPHP) > 0) OR (count($g_CriticalJS) > 0) OR (count($g_Base64) > 0) OR  (count($g_Iframer) > 0) OR  (count($g_UnixExec) > 0))
  {
  echo "1\n";
  exit(0);
  }
 }
////////////////////////////////////////////////////////////////////////////
$l_Template = str_replace("@@SERVICE_INFO@@", htmlspecialchars("[" . $int_enc . "][" . $snum . "]"), $l_Template);

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

$l_Template = str_replace('@@WARN_QUICK@@', ((SCAN_ALL_FILES || $g_SpecificExt) ? '' : AI_STR_045), $l_Template);

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
		if ($g_FlexDBShe[$i] == '[a-zA-Z0-9_]+?\(\s*[a-zA-Z0-9_]+?=\s*\)') $g_FlexDBShe[$i] = '\((?<=[a-zA-Z0-9_].)\s*[a-zA-Z0-9_]++=\s*\)';
		if ($g_FlexDBShe[$i] == '([^\?\s])\({0,1}\.[\+\*]\){0,1}\2[a-z]*e') $g_FlexDBShe[$i] = '(?J)\.[+*](?<=(?<d>[^\?\s])\(..|(?<d>[^\?\s])..)\)?\g{d}[a-z]*e';
		if ($g_FlexDBShe[$i] == '$[a-zA-Z0-9_]\{\d+\}\s*\.$[a-zA-Z0-9_]\{\d+\}\s*\.$[a-zA-Z0-9_]\{\d+\}\s*\.') $g_FlexDBShe[$i] = '\$[a-zA-Z0-9_]\{\d+\}\s*\.\$[a-zA-Z0-9_]\{\d+\}\s*\.\$[a-zA-Z0-9_]\{\d+\}\s*\.';

		$g_FlexDBShe[$i] = str_replace('http://.+?/.+?\.php\?a', 'http://[^?\s]++(?<=\.php)\?a', $g_FlexDBShe[$i]);
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
        //optSig($g_SusDBPrio);
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
	$sigs = array_unique($sigs);

	// Add SigId
	// ��������� � ������ ��������� ����������� ������ � ���������� ������� (?<NAME>)
	// ����� ����� ������ ����� �� ��� ����������� � ����������.
	foreach ($sigs as &$s) {
		$s .= '(?<X' . myCheckSum($s) . '>)';
	}
	unset($s);
	
	$fix = array(
		'([^\?\s])\({0,1}\.[\+\*]\){0,1}\2[a-z]*e' => '(?J)\.[+*](?<=(?<d>[^\?\s])\(..|(?<d>[^\?\s])..)\)?\g{d}[a-z]*e',
		'http://.+?/.+?\.php\?a' => 'http://[^?\s]++(?<=\.php)\?a',
		'\s*[\'"]{0,1}.+?[\'"]{0,1}\s*' => '.+?',
		'[\'"]{0,1}.+?[\'"]{0,1}' => '.+?'
	);
	$sigs = str_replace(array_keys($fix), array_values($fix), $sigs);
	
	$fix = array(
		'~^\\\\[d]\+&@~' => '&@(?<=\d..)',
		'~^((\[\'"\]|\\\\s|@)(\{0,1\}\.?|[?*]))+~' => ''
	);
	$sigs = preg_replace(array_keys($fix), array_values($fix), $sigs);

	optSigCheck($sigs);

	$tmp = array();
	foreach ($sigs as $i => $s) {
		if (strpos($s, '.+') !== false || strpos($s, '.*') !== false) {
			unset($sigs[$i]);
			$tmp[] = $s;
		}
	}
	
	usort($sigs, 'strcasecmp');
	$txt = implode("\n", $sigs);

	for ($i = 24; $i >= 1; ($i > 4 ) ? $i -= 4 : --$i) {
		$txt = preg_replace_callback('#^((?>(?:\\\\.|\\[.+?\\]|[^(\n]|\((?:\\\\.|[^)(\n])++\))(?:[*?+]\+?|)){' . $i . ',}).*(?:\\n\\1(?![{?*+]).+)+#im', 'optMergePrefixes', $txt);
	}

	$sigs = array_merge(explode("\n", $txt), $tmp);
	
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


function _hash_($text)
{
	static $r;
	
	if (empty($r)) {
		for ($i = 0; $i < 256; $i++) {
			if ($i < 33 OR $i > 127 ) $r[chr($i)] = '';
		}
	}

	return sha1(strtr($text, $r));
}

function check_whitelist($list, &$snum) 
{
	if (empty($list)) return array();
	
	$file = dirname(__FILE__) . '/AIBOLIT-WHITELIST.db';

	$snum = max(0, @filesize($file)) / 20;
	echo "\nLoaded " . ceil($snum) . " known files\n";
	
	sort($list);

	$hash = reset($list);
	
	$fp = @fopen($file, 'rb');
	
	if (false === $fp) return array();
	
	$header = unpack('V256', fread($fp, 1024));
	
	$result = array();
	
	foreach ($header as $chunk_id => $chunk_size) {
		if ($chunk_size > 0) {
			$str = fread($fp, $chunk_size);
			
			do {
				$raw = pack("H*", $hash);
				$id = ord($raw[0]) + 1;
				
				if ($chunk_id == $id AND binarySearch($str, $raw)) {
					$result[] = $hash;
				}
				
			} while ($chunk_id >= $id AND $hash = next($list));
			
			if ($hash === false) break;
		}
	}
	
	fclose($fp);

	return $result;
}


function binarySearch($str, $item)
{
	$item_size = strlen($item);
	
	if ( $item_size == 0 ) return false;
	
	$first = 0;

	$last = floor(strlen($str) / $item_size);
	
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
		return true;
	} else {
		return false;
	}
}

function getSigId($l_Found)
{
	foreach ($l_Found as $key => &$v) {
		if (is_string($key) AND $v[1] != -1 AND strlen($key) == 9) {
			return substr($key, 1);
		}
	}
	
	return null;
}