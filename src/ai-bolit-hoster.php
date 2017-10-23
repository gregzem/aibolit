<?php
///////////////////////////////////////////////////////////////////////////
// Created and developed by Greg Zemskov, Revisium Company
// Email: audit@revisium.com, http://revisium.com/ai/

// Commercial usage is not allowed without a license purchase or written permission of the author
// Source code and signatures usage is not allowed

// Certificated in Federal Institute of Industrial Property in 2012
// http://revisium.com/ai/i/mini_aibolit.jpg

////////////////////////////////////////////////////////////////////////////
// Запрещено использование скрипта в коммерческих целях без приобретения лицензии.
// Запрещено использование исходного кода скрипта и сигнатур.
//
// По вопросам приобретения лицензии обращайтесь в компанию "Ревизиум": http://www.revisium.com
// audit@revisium.com
// На скрипт получено авторское свидетельство в Роспатенте
// http://revisium.com/ai/i/mini_aibolit.jpg
///////////////////////////////////////////////////////////////////////////
ini_set('memory_limit', '1G');
ini_set('xdebug.max_nesting_level', 500);

$int_enc = @ini_get('mbstring.internal_encoding');
        
define('SHORT_PHP_TAG', strtolower(ini_get('short_open_tag')) == 'on' || strtolower(ini_get('short_open_tag')) == 1 ? true : false);

// Put any strong password to open the script from web
// Впишите вместо put_any_strong_password_here сложный пароль	 

define('PASS', '????????????????'); 

//////////////////////////////////////////////////////////////////////////

if (isCli()) {
	if (strpos('--eng', $argv[$argc - 1]) !== false) {
		  define('LANG', 'EN');  
	}
} else {
   define('NEED_REPORT', true);
}
	
if (!defined('LANG')) {
   define('LANG', 'RU');  
}	

// put 1 for expert mode, 0 for basic check and 2 for paranoic mode
// установите 1 для режима "Эксперта", 0 для быстрой проверки и 2 для параноидальной проверки (для лечения сайта) 
define('AI_EXPERT_MODE', 2); 

define('REPORT_MASK_PHPSIGN', 1);
define('REPORT_MASK_SPAMLINKS', 2);
define('REPORT_MASK_DOORWAYS', 4);
define('REPORT_MASK_SUSP', 8);
define('REPORT_MASK_CANDI', 16);
define('REPORT_MASK_WRIT', 32);
define('REPORT_MASK_FULL',0# REPORT_MASK_PHPSIGN | REPORT_MASK_DOORWAYS | REPORT_MASK_SUSP
/* <-- remove this line to enable "recommendations"  

| REPORT_MASK_SPAMLINKS 

 remove this line to enable "recommendations" --> */
);

define('AI_HOSTER', 1); 

define('AI_EXTRA_WARN', 0);

$defaults = array(
	'path' => dirname(__FILE__),
	'scan_all_files' => 0, // full scan (rather than just a .js, .php, .html, .htaccess)
	'scan_delay' => 0, // delay in file scanning to reduce system load
	'max_size_to_scan' => '600K',
	'site_url' => '', // website url
	'no_rw_dir' => 0,
    	'skip_ext' => '',
        'skip_cache' => false,
	'report_mask' => REPORT_MASK_FULL
);


define('DEBUG_MODE', 0);

define('AIBOLIT_START_TIME', time());
define('START_TIME', microtime(true));

define('DIR_SEPARATOR', '/');

define('AIBOLIT_MAX_NUMBER', 200);

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
$g_PhishFiles = array('js', 'html', 'htm', 'suspected', 'php', 'pht', 'php7');
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
define('AI_STR_010', "Сканер AI-Bolit запускается с паролем. Если это первый запуск сканера, вам нужно придумать сложный пароль и вписать его в файле ai-bolit.php в строке №34. <p>Например, <b>define('PASS', '%s');</b><p>
После этого откройте сканер в браузере, указав пароль в параметре \"p\". <p>Например, так <b>http://mysite.ru/ai-bolit.php?p=%s</b>. ");
define('AI_STR_011', 'Текущая директория не доступна для чтения скрипту. Пожалуйста, укажите права на доступ <b>rwxr-xr-x</b> или с помощью командной строки <b>chmod +r имя_директории</b>');
define('AI_STR_012', "Затрачено времени: <b>%s</b>. Сканирование начато %s, сканирование завершено %s");
define('AI_STR_013', 'Всего проверено %s директорий и %s файлов.');
define('AI_STR_014', '<div class="rep" style="color: #0000A0">Внимание, скрипт выполнил быструю проверку сайта. Проверяются только наиболее критические файлы, но часть вредоносных скриптов может быть не обнаружена. Пожалуйста, запустите скрипт из командной строки для выполнения полного тестирования. Подробнее смотрите в <a href="https://revisium.com/ai/faq.php">FAQ вопрос №10</a>.</div>');
define('AI_STR_015', '<div class="title">Критические замечания</div>');
define('AI_STR_016', 'Эти файлы могут быть вредоносными или хакерскими скриптами');
define('AI_STR_017', 'Вирусы и вредоносные скрипты не обнаружены.');
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
define('AI_STR_075', 'Сканер бесплатный только для личного некоммерческого использования. Информация по <a href="https://revisium.com/ai/faq.php#faq11" target=_blank>коммерческой лицензии</a> (пункт №11). <a href="https://revisium.com/images/mini_aibolit.jpg">Авторское свидетельство</a> о гос. регистрации в РосПатенте №2012619254 от 12 октября 2012 г.');

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
define('AI_STR_080', "Обращаем внимание, что обнаруженные файлы не всегда являются вирусами и хакерскими скриптами. Сканер минимизирует число ложных обнаружений, но это не всегда возможно, так как найденный фрагмент может встречаться как во вредоносных скриптах, так и в обычных.<p>Для диагностического сканирования без ложных срабатываний мы разработали специальную версию <u><a href=\"https://revisium.com/ru/blog/ai-bolit-4-ISP.html\" target=_blank style=\"background: none; color: #303030\">сканера для хостинг-компаний</a></u>.");
define('AI_STR_081', "Уязвимости в скриптах");
define('AI_STR_082', "Добавленные файлы");
define('AI_STR_083', "Измененные файлы");
define('AI_STR_084', "Удаленные файлы");
define('AI_STR_085', "Добавленные каталоги");
define('AI_STR_086', "Удаленные каталоги");
define('AI_STR_087', "Изменения в файловой структуре");

$l_Offer =<<<OFFER
    <div>
	 <div class="crit" style="font-size: 17px; margin-bottom: 20px"><b>Внимание! Наш сканер обнаружил подозрительный или вредоносный код</b>.</div> 
	 <p>Возможно, ваш сайт был взломан. Рекомендуем срочно <a href="https://revisium.com/ru/order/" target=_blank>проконсультироваться со специалистами</a> по данному отчету.</p>
	 <p>Отправьте отчет в запароленном архиве .zip в компанию "Ревизиум" на <b><a href="mailto:ai@revisium.com">ai@revisium.com</a></b> для бесплатной консультации.</p>
	 <p>Компания "<a href="https://revisium.com/">Ревизиум</a>" более 7 лет специализируется на лечении и защите сайтов от взлома.</p>
	   <p><hr size=1></p>
	   <p>Дополнительную проверку вирусов на страницах необходимо выполнить бесплатным <b><a href="http://rescan.pro/?utm=aibolit" target=_blank>веб-сканером ReScan.Pro</a></b>.</p>
	   <p><hr size=1></p>
           <div class="caution">@@CAUTION@@</div>
    </div>
OFFER;

$l_Offer2 =<<<OFFER2
	   <b>Наши новые продукты:</b><br/>
              <ul>
               <li style="margin-top: 10px">облачный <a href="https://cloudscan.pro/ru/" target=_blank>антивирус CloudScan.Pro</a> для веб-специалистов</li>
               <li style="margin-top: 10px"><a href="https://revisium.com/ru/blog/ai-bolit-4-ISP.html" target=_blank>антивирус для хостинг-компаний</a></li>
              </ul>  
	</div>
OFFER2;

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
define('AI_STR_075', 'For non-commercial use only. In order to purchase the commercial license of the scanner contact us at ai@revisium.com');

$tmp_str =<<<HTML_FOOTER
		   <div class="disclaimer"><span class="vir">[!]</span> Disclaimer: We're not liable to you for any damages, including general, special, incidental or consequential damages arising out of the use or inability to use the script (including but not limited to loss of data or report being rendered inaccurate or failure of the script). There's no warranty for the program. Use at your own risk. 
		   </div>
		   <div class="thanx">
		      We're greatly appreciate for any references in the social medias, forums or blogs to our scanner AI-BOLIT <a href="https://revisium.com/aibo/">https://revisium.com/aibo/</a>.<br/> 
		     <p>Contact us via email if you have any questions regarding the scanner or need report analysis: <a href="mailto:ai@revisium.com">ai@revisium.com</a>.</p> 
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
 <div class="crit" style="font-size: 17px;"><b>Attention! The scanner has detected suspicious or malicious files.</b></div> 
 <br/>Most likely the website has been compromised. Please, <a href="https://revisium.com/en/contacts/" target=_blank>contact website security experts</a> from Revisium to check the report or clean the malware.
 <p><hr size=1></p>
 Also check your website for viruses in our free <b><a href="http://rescan.pro/?en&utm=aibo" target=_blank>online scanner ReScan.Pro</a></b>.
</div>
<br/>
<div>
   Revisium contacts: <a href="mailto:ai@revisium.com">ai@revisium.com</a>, <a href="https://revisium.com/en/contacts/">https://revisium.com/en/home/</a>
</div>
<div class="caution">@@CAUTION@@</div>
HTML_OFFER_EN;

$l_Offer2 = 'Professional virus/malware clean up and website protection service with 6 month support for only $99 (one-time payment): <a href="https://revisium.com/en/home/#order_form">https://revisium.com/en/home/</a>.';

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
   -webkit-border-radius: 4px;
   -moz-border-radius: 4px;
   border-radius: 4px;

   background: #DAF2C1;
   padding: 2px 5px 2px 5px;
   margin: 0 5px 0 5px;
 }
 
 .credits_header 
 {
  -webkit-border-radius: 4px;
   -moz-border-radius: 4px;
   border-radius: 4px;

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
  -webkit-border-radius: 4px;
   -moz-border-radius: 4px;
   border-radius: 4px;

   width: 500px;
   background: #F2F2F2;
   color: #747474;
   font-family: Helvetica, Arial;
   padding: 30px;
   margin: 20px 0 0 550px;
   font-size: 14px;
}

.offer2
{
  -webkit-border-radius: 4px;
   -moz-border-radius: 4px;
   border-radius: 4px;

   width: 500px;
   background: #f6f5e0;
   color: #747474;
   font-family: Helvetica, Arial;
   padding: 30px;
   margin: 20px 0 0 550px;
   font-size: 14px;
}


HR {
  margin-top: 15px;
  margin-bottom: 15px;
  opacity: .2;
}
 
.flist
{
   font-family: Henvetica, Arial;
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

 <div class="offer2">
@@OFFER2@@
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

//BEGIN_SIG 19/10/2017 02:03:50
$g_DBShe = unserialize(base64_decode("YTowOnt9"));
$gX_DBShe = unserialize(base64_decode("YTowOnt9"));
$g_FlexDBShe = unserialize(base64_decode("YTo4OTQ6e2k6MDtzOjM2OiI8XD9waHBccytcJHFWPSJzdG9wXy4rP1xdXCk7XH1cPz5ccyoiO2k6MTtzOjM1OiI8XD9waHBccytcJHNGPSJcdytfLis/XClcKTtcfVw/PlxzKiI7aToyO3M6NTE6IjxcP3BocFxzK1wkR0xPQkFMUy4rP1xbXGQrXF1cXVwpO31leGl0XChcKTtcfVxzK1w/PiI7aTozO3M6NDc6IjxcP3BocFxzKlxAcHJlZ19yZXBsYWNlXCguL1woXC5cKlwpL2UuKz8sIC4uXCk7IjtpOjQ7czo3ODoiPFw/cGhwIGdsb2JhbCBcJFthLXowLTldKzsgXCRbYS16MC05XSs9YXJyYXlcKC4rP1wpXCk7XH07dW5zZXRcKFwkW2EtejAtOV0rXCk7IjtpOjU7czo2NzoiaWZccypcKFwkX0ZJTEVTXFsuRjFsMy4rP1wkX1BPU1RcWy5OYW1lLlxdXCk7XHMqZWNob1xzKi5PSy47IEV4aXQ7fSI7aTo2O3M6MTI4OiJpZlxzKlwoXCRfUkVRVUVTVFxbLnBhcmFtMS5cXSYmXCRfUkVRVUVTVFxbLnBhcmFtMi5cXVwpXHMqe1wkZi4rP2FycmF5XChcJF9SRVFVRVNUXFsucGFyYW0yLlxdXCk7Lis/YXJyYXlfZmlsdGVyLis/T0suO1xzKkV4aXQ7fSI7aTo3O3M6MTE2OiI8XD9waHBccytcJFthLXpdLis/c3RydG91cHBlci4rP2lzc2V0Lis/ZXZhbFxzKlwoXHMqXCR7XHMqXCRbYS16MC05XStccyp9XHMqXFtccyonW2EtejAtOV0rJ1xzKlxdXHMqXCk7XHMqfVxzKlw/PlxzKiI7aTo4O3M6Mjc1OiJpZlxzKlwoXHMqaXNzZXRccypcKFxzKlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXFsnXHcqJ1xdXHMqXClccypcKVxzKlx7XHMqXChccypcJHd3d1xzKj1ccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxbJ1x3KidcXVxzKlwpXHMqJiZccypAcHJlZ19yZXBsYWNlXChccyonLmFkLmUnXHMqLFxzKidAJ1xzKi5ccypzdHJfcm90MTNcKFxzKidyaW55J1xzKlwpXHMqXC5ccyonXChcJHd3d1wpJ1xzKixccyonYWRkJ1xzKlwpO1xzKmV4aXQ7XHMqfSI7aTo5O3M6MTg3OiJccyo8XD9waHBccypcKFwkXHcrXHMqPVxzKlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXFsnXHcrJ1xdXCkgJiYgQHByZWdfcmVwbGFjZVwoXHMqJy9hZC9lJ1xzKixccyonQCdccypcLlxzKnN0cl9yb3QxM1woXHMqJ3JpbnknXHMqXClccypcLlxzKidcKFwkXHcrXCknXHMqLFxzKidhZGQnXCk7XHMqXD8+XHMqIjtpOjEwO3M6NTQ6IjxcP3BocCBldmFsXCgiW14iXSsiXC5cJF9SRVFVRVNUXFsnLidcXVwuIlteIl0rIlwpO1w/PiI7aToxMTtzOjEyOToiXCQuXHMqPVxzKlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpO1xzKkBcKFwkLlxbXGRcXVxzKiE9XHMqXCQuXFtcZFxdXClccypcP1xzKkBcJC5cW1xkXF1cKFwkLlxbXGRcXVwpXHMqOlxzKlwoaW50XClcJC47IjtpOjEyO3M6MTE0OiI8XD9waHBccypwcmVnX3JlcGxhY2VcKCIvXHcrL2UiXHMqLFxzKiJlWyInLnZhXStsXCgnIlwuXCRfUkVRVUVTVFxbJ1x3KydcXVwuIidcKSJccyosXHMqIlthLXpBLVpcczAtOV9dKyJcKTtccypcPz4iO2k6MTM7czo1MjoicHJlZ19yZXBsYWNlXCgiXFx4MmYoXFx4Li4pKyJccyosXHMqIihcXHguLikrIiwiIlwpOyI7aToxNDtzOjg5OiI8XD9waHBccypldmFsXChnemluZmxhdGVcKHN0cl9yb3QxM1woYmFzZTY0X2RlY29kZVwoJ1thLXpBLVowLTkrL1xzXStBUT09J1wpXClcKVwpO1xzKlw/PiI7aToxNTtzOjc2OiI8XD9waHBccypldmFsXChnemluZmxhdGVcKGJhc2U2NF9kZWNvZGVcKCdbYS16QS1aMC05Ky9cc10rQVE9PSdcKVwpXCk7XHMqXD8+IjtpOjE2O3M6Mjk6Ii8vXCNcKz1cK1wjXCsuKz8vL1wjXCs9XCtcI1wrIjtpOjE3O3M6ODc6ImlmXChcKG1kNVwoQFwkX0NPT0tJRVxbc3NpZFxdXCk9PSJcd3szMn0iXClcKVx7ZXJyb3JfcmVwb3J0aW5nXCgwXCk7QGFycmF5X21hcFwoLipcKTtcfSI7aToxODtzOjk5OiJcJFthLXpdK1xzKj1ccypcJF9DT09LSUU7XHMqXCRbYS16XStccyo9XHMqXCRbYS16XStcW1xzKlthLXpdK1xzKlxdO1xzKmlmLis/XCRbYS16XStcKFxzKlwpXHMqO1xzKn0iO2k6MTk7czo4MDoiZXZhbFwoYmFzZTY0X2RlY29kZVwoQFwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXFsnW2EtekEtWjAtOV0rJ1xdXClcKTsiO2k6MjA7czoxMTY6IjxcP3BocFxzKlwkdmVyc2lvblxzKj1ccyoiXGQrXC5cZCsiOy4rP2lmXChAZmlsZV9wdXRfY29udGVudHNcKFwkLis/QGluY2x1ZGVfb25jZVwoLis/QHVubGlua1woLis/NDA0IE5vdCBGb3VuZC4rXD8+IjtpOjIxO3M6NDQ6Ii8vaXN0YXJ0XHMuKz9mdW5jdGlvblxzK2RlY3J5cHRfdXJsLis/Ly9pZW5kIjtpOjIyO3M6NTU6ImVycm9yX3JlcG9ydGluZ1woMFwpO1xzKlwkc3RyaW5ncyA9ICJhcyI7Lis/XClcKTsnXClcKTsiO2k6MjM7czo0MzoiY29weVwoJ2h0dHA6Ly8uKz8nXHMqLFxzKidcdytcLnBocCdcKTtleGl0OyI7aToyNDtzOjEzNToiaWZccypcKFxzKmlzc2V0XChccypcJF9SRVFVRVNUXFtccyoiXHcrIlxzKlxdXHMqXClccypcKVxzKnsuKj9AP3ByZWdfcmVwbGFjZVwoJy9cKFwuXCpcKS9lJ1xzKixccypAP1wkX1JFUVVFU1RcWydcdysnXF0sXHMqJydccypcKTsuKj99IjtpOjI1O3M6MTE0OiJpZlxzKlwoXHMqaXNzZXRcKFxzKlwkX1JFUVVFU1RcW1xzKiJcdysiXHMqXF1ccypcKVxzKlwpXHMqey4qP0A/ZXh0cmFjdFwoXCRfUkVRVUVTVFwpO0A/ZGllXChcJFx3K1woXCRcdytcKVwpOy4qP30iO2k6MjY7czoyMDM6IjxcP3BocFxzP2lmXHM/XChccz9tZDVccz9cKFxzP1wkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXFsicGFzc3dvcmQiXF1ccz9cKVxzPz09XHM/IlswLTlhLXpdezMyfSJccz9cKVxzP1x7XHM/cHJlZ19yZXBsYWNlXHM/XChccz8iXFwuKlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXFsiY29kZSJcXS4qO1xzP1x9XHM/XD8+IjtpOjI3O3M6ODE6IjxcP3BocFxzKihldmFsfGFzc2VydClcKFwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXFtccypcdytccypcXVwpO1xzKlw/PiI7aToyODtzOjEzODoiPFw/cGhwXHMqaWZccypcKCFpc3NldFwoXCRfUkVRVUVTVFxbJ1x3KydcXVwpXCkgaGVhZGVyXCgiSFRUUC4rPyJcKTtccypAcHJlZ19yZXBsYWNlXCgnLlwoXC5cKlwpLmUnLFxzKkBcJF9SRVFVRVNUXFsnXHcrJ1xdLFxzKicnXCk7XHMqXD8+IjtpOjI5O3M6MTEzOiJcJFx3K1xzKj1ccyoiXHcrIjtccypwcmVnX3JlcGxhY2VcKCIoXFx4P1thLWYwLTlBLUZdezIsM30pKyJccyosIihcXHg/W2EtZkEtRjAtOV0rKSsiXHMqLCIoXFx4P1thLWZBLUYwLTldKykrIlwpOyI7aTozMDtzOjczOiI8XD9waHBccypAZXZhbFwoXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClcWydcd3sxLDV9J1xdXCk7XHMqXD8+IjtpOjMxO3M6MTU4OiI8XD9waHBccytmdW5jdGlvbiAoXHcrKVwoXCRmaWxlX3VybCwuKz9maWxlX2dldF9jb250ZW50c1woXCRmaWxlX3VybFwpO1wxXCgnaHR0cHM6Ly9kbFwuZHJvcGJveHVzZXJjb250ZW50XC5jb20uKz91bmxpbmtcKFwkX1NFUlZFUlxbJ1NDUklQVF9GSUxFTkFNRSdcXVwpO1w/PiI7aTozMjtzOjc0OiI8XD9waHBccysvL1x3ezAsMjEwMH1ccypldmFsXChiYXNlNjRfZGVjb2RlXCgiW2EtekEtWjAtOS9cKz1dKyJcKVwpO1xzKlw/PiI7aTozMztzOjczOiI8XD9waHBccypldmFsXCgiKFxceFtBLUYwLTldKykrJ1thLXpBLVowLTkvKz1dKycoXFx4W0EtRjAtOV0rKSsiXCk7XHMqXD8+IjtpOjM0O3M6Nzc6IjxcP3BocFxzKmV2YWxcKGd6aW5mbGF0ZVwoYmFzZTY0X2RlY29kZVwoJ1thLXpBLVowLTkvKz1dezUwMDAsfSdcKVwpXCk7XHMqXD8+IjtpOjM1O3M6MTIzOiI8XD9waHBccypcJFx3Kz0nXCNcI1wjLitcJ1wpXCk7JztccypcJFx3Kz1zdHJfcmVwbGFjZVwoJ1wjJywgJycsIFwkXHcrXCk7XCRcdys9Y3JlYXRlX2Z1bmN0aW9uXCgnJyxcJFx3K1wpO1wkXHcrXChcKTtccypcPz4iO2k6MzY7czo5ODoiPFw/cGhwXHMqXCRfXHcrPSIoXFx4W0EtRmEtZjAtOV17Mn0pezEsNTAwfSI7XCRfXHcrXCgiKFxceFthLWZBLUYwLTldezJ9KXsxLDUwMH0iLCIuKz8iLCdcLidcKTtcPz4iO2k6Mzc7czo1NjoiPFw/XHMqXCRfPSIiO1wkX1xbXCsiIlxdPScnO1wkXz0iXCRfLipcJF99XFsnX18nXF1cKTtcPz4iO2k6Mzg7czoxNDk6IjxcP3BocFxzKmlmXChwcmVnX21hdGNoXCgoY2hyXChcZCtcKVwuKSsuK2lmXChcJFx3Kz09PWZhbHNlXCljb250aW51ZTtcJFx3Kz1zdHJfcmVwZWF0LitiYXNlNjRfZGVjb2RlXCgnW2EtekEtWjAtOVwrLz1dKydcKSwuKz9cJFx3K1wpXCk7YnJlYWs7fX19XD8+IjtpOjM5O3M6NzU6IjxcP3BocFxzKlwkXHcrPSIuKyI7ZXZhbC9cKlwqL1woc3RycmV2XChzdHJfcmVwbGFjZVwoIi4iLCIiLFwkXHcrXClcKVwpO1w/PiI7aTo0MDtzOjg3OiJcJF9SRVFVRVNUXFsuXF1ccypcP1xzKmV2YWxcKFxzKmJhc2U2NF9kZWNvZGVcKFxzKlwkX1JFUVVFU1RcWy5cXVxzKlwpXHMqXClccyo6XHMqZXhpdDsiO2k6NDE7czo2MDoiXCRcdytccyo9XHMqQXJyYXlcKC4rc3ByaW50ZlwoXHcrXChcJFx3K1xzKixccypcJFx3K1wpXCk7XD8+IjtpOjQyO3M6MTI0OiJccyppZlwoaXNzZXRcKFwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXFtcdytcXVwpXCl7XHMqXCRkPXN1YnN0clwoOCwxXCk7Zm9yZWFjaFwoYXJyYXlcKChcZCssKSsuKz9ldmFsXChcJGRcKTtccyp9IjtpOjQzO3M6MTI3OiJcJHVybHNccyo9XHMqYXJyYXlccypcKC4rP1wpO1xzKlwkVVJMXHMqPVxzKlwkdXJsc1xbcmFuZFwoMCxccypjb3VudFwoXCR1cmxzXClccyotXHMqMVwpXF07XHMqaGVhZGVyXHMqXCgiTG9jYXRpb246XHMqXCRVUkwiXCk7IjtpOjQ0O3M6MTM5OiI8XD9ccypzZXRfdGltZV9saW1pdFwoXGQrXCk7XHMqZXJyb3JfcmVwb3J0aW5nXCgwXCk7XHMqXCRcdytccys9XHMqJy4rJztccypldmFsXChnemluZmxhdGVcKHN0cl9yb3QxM1woYmFzZTY0X2RlY29kZVwoXCRyaHNcKVwpXClcKVw7XHMqXD8+IjtpOjQ1O3M6MTYzOiJcJFx3K1xzKj1ccypAXCRfQ09PS0lFXFsnXHcrJ1xdO1xzKmlmXHMqXChcJFx3K1wpIHtccypcJFx3K1xzKj1ccypcJFx3K1woQFwkX0NPT0tJRVxbJ1x3KydcXVwpO1xzKlwkXHcrPVwkXHcrXChAXCRfQ09PS0lFXFsnXHcrJ1xdXCk7IFwkXHcrXCgiL1x3Ky9lIixcJFx3KyxcdytcKTt9IjtpOjQ2O3M6MTE5OiJcJGdpZj1maWxlXChkaXJuYW1lXChfX0ZJTEVfX1wpXC4nL2ltYWdlcy9cdytcLmdpZicsMlwpO1wkZ2lmPVwkZ2lmXFtcZCtcXVwoIiIsXCRnaWZcW1xkK1xdXChcJGdpZlxbXGQrXVwpXCk7XCRnaWZcKFwpOyI7aTo0NztzOjg5OiI8XD9ccyppZiBcKFwkX0ZJTEVTXFsnRjFsMydcXVwpIHttb3ZlX3VwbG9hZGVkX2ZpbGUuK2VjaG8gJ1lvdSBhcmUgZm9yYmlkZGVuISc7XHMqfVxzKlw/PiI7aTo0ODtzOjEzNjoiaWYgXChcJF9GSUxFU1xbJ0YxbDMnXF1cKSB7bW92ZV91cGxvYWRlZF9maWxlXChcJF9GSUxFU1xbJ0YxbDMnXF1cWyd0bXBfbmFtZSdcXSwgXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClcWydOYW1lJ1xdXCk7IEV4aXQ7fSI7aTo0OTtzOjI4MToiPFw/cGhwXHMqKGlmXChpc3NldFwoXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClcWyJcdysiXVwpXClccypcJFx3KyA9IGJhc2U2NF9kZWNvZGVcKFwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXFsiXHcrIlxdXCk7XHMqZWxzZVxzKntccyplY2hvICJpbmRhdGFfZXJyb3IiO1xzKmV4aXQ7XHMqfVxzKikraWZcKG1haWxcKFwkXHcrLFwkXHcrLFwkXHcrLFwkXHcrXClcKVxzKmVjaG8gInNlbnRfb2siO1xzKmVsc2VccyplY2hvICJzZW50X2Vycm9yIjtccypcPz4iO2k6NTA7czoxNDA6IjxcP3BocFxzKlwkYT1pc3NldFwoXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClcWydudWxsX3ByaW1lJ1xdXCk7XHMqXCRjPSJbXiJdKyI7Lis/c3RycmV2XChcJGNcKVwpXCk7ZmNsb3NlXChcJGZcKTsgZGllOyB9XHMqXD8+XHMqIjtpOjUxO3M6MzY4OiJcJFx3K1xzKj1ccyoiLnszMn0iO1xzKmlmXChpc3NldFwoXCRfUkVRVUVTVFxbJ1x3KydcXVwpXClccyp7XHMqXCRcdytccyo9XHMqXCRfUkVRVUVTVFxbJ1x3KydcXTtccypldmFsXChcJFx3K1wpO1xzKmV4aXRcKFwpO1xzKn1ccyppZlwoaXNzZXRcKFwkX1JFUVVFU1RcWydcdysnXF1cKVwpXHMqe1xzKlwkXHcrXHMqPVxzKlwkX1JFUVVFU1RcWydcdysnXF07XHMqXCRcdytccyo9XHMqXCRfUkVRVUVTVFxbJ1x3KydcXTtccypcJFx3K1xzKj1ccypmb3BlblwoXCRcdyssXHMqJ3cnXCk7XHMqXCRcdytccyo9XHMqZndyaXRlXChcJFx3KyxccypcJFx3K1wpO1xzKmZjbG9zZVwoXCRcdytcKTtccyplY2hvXHMqXCRcdys7XHMqZXhpdFwoXCk7XHMqfSI7aTo1MjtzOjE5OToiL1wqXHMqLnszMn1ccypcKi9ccypmdW5jdGlvbiB4bWFpbFxzKlwoXClccyp7XHMqXCRhPWZ1bmNfZ2V0X2FyZ3NcKFwpO1xzKmZpbGVfcHV0X2NvbnRlbnRzXCgnLis/bWFpbFwoXHMqXCRhXFswXF0sXHMqXCRhXFsxXF0sXHMqXCRhXFsyXF0sXHMqXCRhXFszXF1ccypcKTt9XHMqZnVuY3Rpb24geC4rP1xeXHMqJzAnO31ccypyZXR1cm5ccypcJG87fSI7aTo1MztzOjgxOiJpZlxzKlwoaXNzZXRcKFwkX0NPT0tJRVxbIlx3KyJcXVwpXClccypAXCRfQ09PS0lFXFsiXHcrIlxdXChcJF9DT09LSUVcWyJcdysiXF1cKTsiO2k6NTQ7czo3MzoiQGV4dHJhY3RccypcKFxzKlwkX1JFUVVFU1RccypcKTtccypAZGllXHMqXChccypcJFx3K1woXHMqXCRcdytccypcKVxzKlwpOyI7aTo1NTtzOjE0NzoiPFw/cGhwXHMqXCRcdytccyo9XHMqIlx3KyI7XHMqaWZcKGlzc2V0XChcJF9SRVFVRVNUXFtcJFx3K1xdXClcKVxzKntccypldmFsXChccypzdHJpcHNsYXNoZXNcKFxzKlwkX1JFUVVFU1RcW1wkXHcrXF1cKVwpO1xzKmV4aXRcKFwpO1xzKn07XHMqXD8+XHMqIjtpOjU2O3M6NzI6IlxzKi9cKlxzKlRFU1QtVFJBQ0stTElORVxzKlwqL1xzKlwkXHcrLis/L1wqXHMqL1RFU1QtVFJBQ0stTElORVxzKlwqL1xzKiI7aTo1NztzOjExNzoiaWYgXChpc3NldFwoXCRfUkVRVUVTVFxbIlx3KyJcXVwpXCkgeygvXCpcdytcKi8pP0BleHRyYWN0XChcJF9SRVFVRVNUXCk7L1wqXHcrXCovQGRpZVwoXCRcdytcKFwkXHcrXClcKTsoL1wqXHcrXCovKT99IjtpOjU4O3M6MTk2OiJccyo8XD9ccyppZlwoaXNzZXRcKFwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXFsnXHcrJ1xdXClcKVxzKnByZWdfcmVwbGFjZVwoJy9cdysvZScsIFwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXFsnXHcrJ1xdLFxzKlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXFsnXHcrJ1xdXCk7XD8+XHMqIjtpOjU5O3M6MTYzOiJpZlwoaXNzZXRcKFwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXFsnXHcrJ11cKVwpXHMqY29weVwoXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClcWydcdysnXF0sXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClcWydcdysnXF1cKTtlbHNlIjtpOjYwO3M6MTA5OiJcJFx3KyA9IEFycmF5XCgnW2FzZXJ0XC5cJ10rJ1wpO0BcJFx3K1xbY2hyXChcZCtcKVxdXChcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxbW2FzZXJ0XC5cJ10rJ1xdXCk7IjtpOjYxO3M6MjMyOiI8XD9waHBccyppZlwoXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClcWydcdysnXF1cKXtlY2hvXHMqJ1x3Kyc7fWVsc2V7XChcJHd3dz1ccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxbJ1x3KydcXVwpXHMqJiZccypAcHJlZ19yZXBsYWNlXCgnL2FkL2UnLCdAJ1wuc3RyX3JvdDEzXCgncmlueSdcKVwuJ1woXCR3d3dcKSdccyosXHMqJ1x3KydccypcKTtccyp9XD8+XHMqIjtpOjYyO3M6MzQ6ImV2YWxcKGJhc2U2NF9kZWNvZGVcKCdKR1kuKz8nXClcKTsiO2k6NjM7czo3MToiPFw/cGhwLlwkW2EtekEtWl17MTB9XHcqPS4qZmFsc2U7aWZcKGlzc2V0LipjaHJcKFxkLipcPSJcKVwpO2V4aXRcKFwpOyQiO2k6NjQ7czoxMDQ6IjxcP3BocCBwcmludCc8Zm9ybSBlbmN0eXBlPW11bHRpcGFydC9mb3JtLWRhdGEuKz9cKVwpe2lmXChpc191cGxvYWRlZF9maWxlXChcJF9GSUxFUy4rP1wpO319ZXhpdDtcPz5ccyokIjtpOjY1O3M6MTAxOiJpZlwoaXNzZXRcKFwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXFtcdytcXVwpXCl7ZWNob1xzKic8Zm9ybSAuKz9lY2hvJ1wrJzt9ZWxzZXtlY2hvJy0nO319fSI7aTo2NjtzOjgzOiI8XD9waHBccypldmFsXChnemluZmxhdGVcKHN0cl9yb3QxM1woYmFzZTY0X2RlY29kZVwoJ1teJ117NTAwMCx9J1wpXClcKVwpO1xzKlw/PlxzKiI7aTo2NztzOjkxOiIoR0lGODlhXHMqKT88XD9waHAgZWNobyAnLis/JztAcHJlZ19yZXBsYWNlXCgnL1xbXHcrXF0vZScsXCRfUkVRVUVTVFxbJ1x3KydcXSwnZXJyb3InXCk7XD8+IjtpOjY4O3M6OTU6IjxcP3BocCBcJGEgPSBzdHJfcmVwbGFjZVwoeCwiIiwiXHcrIlwpO1wkYVwoXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClcWyJcdysiXF1cKTsgXD8+IjtpOjY5O3M6MjE5OiI8Zm9ybVxzK2VuY3R5cGU9bXVsdGlwYXJ0L2Zvcm0tZGF0YVxzK21ldGhvZD1wb3N0PlxzKjxpbnB1dFxzK25hbWU9ZmlsZU1hc3Nccyt0eXBlPWZpbGU+Lis/QGNvcHlcKFwkX0ZJTEVTXFtmaWxlTWFzc1xdXFt0bXBfbmFtZVxdLFwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXFtwYXRoXF1cLlwkX0ZJTEVTXFtmaWxlTWFzc1xdXFtuYW1lXF1cKTtccyp9fTtccypcPz4iO2k6NzA7czoxNjY6IlwkXHcrXHMqPVxzKiJcdysiXHMqO1xzKlwkXHcrXHMqPVxzKnN0cnRvbG93ZXJccypcKFxzKihccypcJFx3K1xbXGQrXF1ccypcLj9ccyopK1wpXHMqO1xzKi4rP2V2YWxccypcKFxzKlwkXHcrXHMqXChccypcJHtccypcJFx3K1xzKn1ccypcW1xzKidcdysnXHMqXF1ccypcKVxzKlwpO1xzKn0iO2k6NzE7czoyMTc6IlwkXHcrXHMqPVxzKiJcdysiXHMqO1xzKlwkXHcrXHMqPVxzKnN0cnRvdXBwZXJccypcKFxzKihccypcJFx3K1xbXGQrXF1ccypcLj9ccyopK1wpXHMqO1xzKmlmXChccyppc3NldFxzKlwoXHMqXCR7XHMqXCRcdytccyp9XHMqXFtccyonXHcrJ1xzKl1ccypcKVxzKlwpXHMqe1xzKmV2YWxccypcKFxzKlwkXHMqe1xzKlwkXHcrXHMqfVxzKlxbXHMqJ1x3KydccypcXVxzKlwpO1xzKn0iO2k6NzI7czoxNTQ6ImZ1bmN0aW9uXHMqXHcrXHMqXChccypcJFx3K1xzKlwpXHMqXHtccypcJFx3K1xzKj1ccypnemluZmxhdGVccypcKFxzKmJhc2U2NF9kZWNvZGVccypcKFxzKlwkXHcrXHMqXClccypcKTtccypmb3JccypcKFxzKlwkLis/Y2hyXHMqXChccypvcmQuKz9ldmFsLis/XClcKTsiO2k6NzM7czo0OToiZXZhbFwoYmFzZTY0X2RlY29kZVwoIkNtVltBLVphLXowLTlcK1wvXD1dKyJcKVwpOyI7aTo3NDtzOjE1NDoiaWZcKGlzc2V0XChcJF8oR0VUfFBPU1R8Q09PS0lFKVxbJ1x3KydcXVwpXCl7XCRzdHIgPSBcJF8oR0VUfFBPU1R8Q09PS0lFKVxbJ1x3KydcXTsgXCRcdytbXC9cKi9cLV0qXChbL1wqXC9cLV0qXCRfKEdFVHxQT1NUfENPT0tJRSlcWydcdysnXF1bL1wqXC9cLV0qXCk7fSI7aTo3NTtzOjEzMToiaWZcKGlzc2V0XChcJF8oR0VUfFBPU1R8Q09PS0lFKVxbJ1x3KydcXVwpXClce1wkXHcrXHMqPVxzKidcdytcJy4qP1wkXHcrWy9cKlwtXSpcKFsvXCpcLV0qXCRfKEdFVHxQT1NUfENPT0tJRSlcWydcdysnXF1bL1wqXC1dKlwpO30iO2k6NzY7czo1MjoiXjxcP3BocFxzKmhlYWRlclwoIkxvY2F0aW9uOlxzKmh0dHA6Ly9bXi9dKy8iXCk7XD8+JCI7aTo3NztzOjYyOiJePFw/cGhwXHMqaGVhZGVyXCgiTG9jYXRpb246IlxzKlwuXHMqIlxzKmh0dHA6Ly9bXi9dKy8iXCk7XD8+JCI7aTo3ODtzOjc3OiI8XD9waHBccypwcmVnX3JlcGxhY2VcKCIvXC5cKi9lIiwiKFxceFthLWZBLUYwLTldKyl7NSx9LisiLCIiXCk7XHMqKFw/Pik/XHMqJCI7aTo3OTtzOjE2MDoiPFw/cGhwXHMqXCRcdytccyo9XHMqZmlsZV9nZXRfY29udGVudHNcKFxzKiJodHRwOi8vLis/IlxzKlwpO1xzKmlmXChcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxbIlx3KyJcXT09Ilx3KyJcKXtccypldmFsXChcJFx3K1wpO1xzKmV4aXQ7XHMqfVxzKlw/PlxzKiI7aTo4MDtzOjg0OiJccypcJFtPMF0rXHMqPVxzKnVybGRlY29kZVwoIlteIl0rIlwpOy57MTAwLDQwMH1ldmFsXChcJFtPMF0rXCgiLnsxMDAsMTAwMH0iXClcKTtccyoiO2k6ODE7czoxNTA6IlwkX1tPMF0qPSJbYS1mMC05XXszMn0iO1wkX1tPMF0qPXN0cl9yb3QxM1woLio/ZXZhbFwoc3RycmV2XCgnLio/Jy4qP2V2YWxcKF9bME9dKlwoX1swT10qXCgiLioiXCksXCRfWzBPXSpcKVwpO2V2YWxcKF9bME9dKlwoXCRfWzBPXSpcKVwpO1wkXHcrPScuKj8nOyI7aTo4MjtzOjYxOiIvXCpcdytcLnBocFxzKlwqL1xzKkByZXF1aXJlX29uY2VcKC4qP1wpO1xzKi9cKlx3K1wucGhwXHMqXCovIjtpOjgzO3M6MTQwOiJcJFx3Kz0nYmFzZTY0X2RlY29kZSc7XCRcdys9XCRcdytcKFwkX1tQT1NUfEdFVF0rXFsnXHcrJ1xdXCk7ZmlsZV9wdXRfY29udGVudHNcKCdcdysnLCc8XD9waHBccyonXC5cJFx3K1wpO2luY2x1ZGVcKCdcdysnXCk7dW5saW5rXCgnXHcrJ1wpOyI7aTo4NDtzOjIzNjoiPFw/cGhwXHMrXCRcdytccyo9Lis/XCRcdytccyo9XHMqZXhwbG9kZVwoY2hyXChcKFxkK1tcLVwrXCpcL11cZCtcKVwpLFxzKicoXGQrLD8pKydcKTtccypcJFx3K1xzKj1ccypcJGNlbmdoZmdxb1woIiIsZXJqY3F3ZFwoXCRcdyssXCRcdyssXCRcdytcKVwpO1xzKlwkXHcrPVwkXHcrO1xzKlwkXHcrXCgiIlwpO1xzKlwkXHcrPVwoXGQrW1wtXCtcL1wqXVxkK1wpO1xzKlwkXHcrPVwkXHcrLVxkKztccypcPz5ccyoiO2k6ODU7czoyNDA6IjxcP3BocFxzKlwkXHcrXHMqPVxzKlwkX0ZJTEVTXFsnXHcrJ1xdXFsnXHcrJ1xdO1xzKm1vdmVfdXBsb2FkZWRfZmlsZVwoXCRfRklMRVNcWydcdysnXF1cWydcdysnXF0sXHMqXCRcdytcKTtccyppZlxzKlwoaXNzZXRccypcKFwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXFsnbWFpbidcXVwpXClccyp7XHMqZWNob1xzKic8Zm9ybSBtZXRob2Rccyo9XHMqInBvc3QiLio/PC9mb3JtPic7XHMqfVxzKlw/PiI7aTo4NjtzOjEzODoiPFw/XHMqXCRpcCA9IGdldGVudlwoIlJFTU9URV9BRERSIlwpOy4rP1wkaGVhZGVycyBcLj0gXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClcWydlTWFpbEFkZCdcXVwuIlxcbiI7Lis/aGVhZGVyXCgiTG9jYXRpb246Lis/XD8+IjtpOjg3O3M6MzY4OiI8XD9waHBccyplY2hvIlx3KyI7ZXJyb3JfcmVwb3J0aW5nXCgwXCk7XHMqaWZcKGlzc2V0XChcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxbJ1x3KydcXVwpICYmIG1kNVwoXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClcWydjb20nXF1cKVxzKj09XHMqJ1x3KydccyomJlxzKmlzc2V0XChcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxbJ1x3KydcXVwpXClccypcJGtrXHMqPVxzKnN0cnRyXChcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxbJ1x3KydcXSxccyonLV8sJyxccyonXCsvPSdcKTtldmFsXChiYXNlNjRfZGVjb2RlXChcJFx3K1wpXCk7XHMqZWNobyJcdysiO1xzKlw/PiI7aTo4ODtzOjQ1OiI8XD9waHBccypcJFx3Kz0oJy57NjAsODB9J1wuXHMqKXs3LH0nLisnO1xzKiQiO2k6ODk7czo2NzoiXCRcdys9J1x3K1woXCFcdytcKCJcdysiXClcKS4qPztyZXR1cm5ccytcJG1vZHVsZS0+Y29udGVudFwuaHRtbDtcfSI7aTo5MDtzOjIwMDoiPFw/aWZcKFwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpLitcJHNoPT0nMTI3XC4wXC4xXC5cZCsnXCl7XHMqaGVhZGVyXCgnSFRUUC8xXC4xIDIwMydcKTtleGl0O319aGVhZGVyXCgnSFRUUC8xXC4xIDIwMSdcKTtleGl0O31oZWFkZXJcKCdIVFRQLzFcLjEgMzAyIEZvdW5kJ1wpO2hlYWRlclwoJ0xvY2F0aW9uOiBbXiddKydcKTtcPz4iO2k6OTE7czozNTQ6IjxcP3BocFxzKmlmXHMqXChccyohaXNzZXRcKFxzKlwkR0xPQkFMUy4rXCRcd3sxLDQwfVxzKj1ccypzdWJzdHJccypcKFxzKlwkXHd7MSw0MH1ccyosXHMqXChccypcZCtccypbXC0rL15dXHMqXGQrXHMqXClccyosXHMqXChccypcZCtccypbXC0rL15dXHMqXGQrXHMqXClccypcKVxzKjtccypcJFx3ezEsNDB9XHMqXChccypcJFx3ezEsNDB9XHMqLFxzKlwkXHd7MSw0MH1ccyosXHMqTlVMTFxzKlwpXHMqO1xzKlwkXHd7MSw0MH1ccyo9XCRcd3sxLDQwfVxzKjtccypcJFx3ezEsNDB9XHMqPVxzKlwoXHMqXGQrXHMqW1wtKy9eXVxzKlxkK1xzKlwpXHMqO1xzKlwkXHd7MSw0MH1ccyo9XCRcd3sxLDQwfS0xXHMqO1xzKlw/PiI7aTo5MjtzOjIyMDoiPFw/cGhwIGlmXCghaXNzZXRcKFwkR0xPQkFMUy4rP307fVxzKlwkXHcrPSJbYS16QS1aeFxcXGRdKyI7XHMqXCRcdys9c3Vic3RyXChcJFx3KyxcKFtcZFwtXCtcKi9dK1wpLFwoW1xkXC1cK1wqL10rXClcKTtccypcJFx3K1woXCRcdyssXHMqXCRcdyssXHMqTlVMTFwpO1xzKlwkXHcrPVwkXHcrO1xzKlwkXHcrPVwoW1xkXC1cK1wqL10rXCk7XHMqXCRcdys9XCRcdystXGQrO1xzKlw/PiI7aTo5MztzOjI0NDoiaWZcKGlzc2V0XChcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxbJ1x3KydcXVwpXCllY2hvXHMrc2hlbGxfZXhlY1woXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClcWydcdysnXF1cKTtpZlwoaXNzZXRcKFwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXFsnXHcrJ1xdXClcKWVjaG9ccytldmFsXChcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxbJ1x3KydcXVwpOyI7aTo5NDtzOjg2OiIoKFwkXHcrPScuJzspK1wkXHcrPShcJFx3K1wuPykrOykrZXZhbFwoXCRcdytcKFwkXHcrXChcJFx3K1woXCRcdytcKCdbXiddKydcKVwpXClcKVwpOyI7aTo5NTtzOjgwOiI8XD9waHBccyooXCQuXHMqPVxzKltcd2NoclwoXClcZCtcLi9cKjtccyInXSspK1wkLlwoW2NoclwoXClcZFwuLFxzKlwkYWJjXSs7XHMqJCI7aTo5NjtzOjMyMzoiaWZcKGlzc2V0XChcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxbJ1x3KydcXVwpXCl7aWZcKGlzc2V0XChcJF9GSUxFU1xbJyhcdyspJ1xdXClcKXsoXCRcdyspPWdldGN3ZFwoXClcLicvJzsoXCRcdyspPVwkX0ZJTEVTXFsnXDEnXF07QG1vdmVfdXBsb2FkZWRfZmlsZVwoXDNcWyd0bXBfbmFtZSdcXSwgXDJcLlwzXFsnbmFtZSdcXVwpOy4qPzxmb3JtIG1ldGhvZD0iUE9TVCIgZW5jdHlwZT0ibXVsdGlwYXJ0L2Zvcm0tZGF0YSI+PGlucHV0IHR5cGU9ImZpbGUiIG5hbWU9IlwxIi8+PGlucHV0IHR5cGU9IlN1Ym1pdCIvPjwvZm9ybT48XD9waHAgfX0iO2k6OTc7czoxMjY0OiJpZlwoaXNzZXRcKFwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXFsnXHcrJ1xdXClcKXtccyooXCRcdyspID0gXCRfU0VSVkVSXFtET0NVTUVOVF9ST09UXF07XHMqKFwkXHcrKSA9IDw8PCdFT0QnXHMqaWZcKGlzc2V0XChcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxbJ1x3KydcXVwpXCl7aWZcKGlzc2V0XChcJF9GSUxFU1xbJyhcdyspJ1xdXClcKXsoXCRcdyspPWdldGN3ZFwoXClcLicvJzsoXCRcdyspPVwkX0ZJTEVTXFsnXDMnXF07QG1vdmVfdXBsb2FkZWRfZmlsZVwoXDVcWyd0bXBfbmFtZSdcXSwgXDRcLlw1XFsnbmFtZSdcXVwpOy4qPzxmb3JtIG1ldGhvZD0iUE9TVCIgZW5jdHlwZT0ibXVsdGlwYXJ0L2Zvcm0tZGF0YSI+PGlucHV0IHR5cGU9ImZpbGUiIG5hbWU9IlwzIi8+PGlucHV0IHR5cGU9IlN1Ym1pdCIvPjwvZm9ybT48XD9waHAgfX1ccypFT0Q7XHMqKFwkXHcrKSA9IDw8PCdFT0QnXHMqPFw/cGhwIGlmXChpc3NldFwoXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClcWydcdysnXF1cKVwpe2lmXChpc3NldFwoXCRfRklMRVNcWycoXHcrKSdcXVwpXCl7KFwkXHcrKT1nZXRjd2RcKFwpXC4nLyc7KFwkXHcrKT1cJF9GSUxFU1xbJ1wzJ1xdO0Btb3ZlX3VwbG9hZGVkX2ZpbGVcKFw1XFsndG1wX25hbWUnXF0sIFw0XC5cNVxbJ25hbWUnXF1cKTsuKj88Zm9ybSBtZXRob2Q9IlBPU1QiIGVuY3R5cGU9Im11bHRpcGFydC9mb3JtLWRhdGEiPjxpbnB1dCB0eXBlPSJmaWxlIiBuYW1lPSJcMyIvPjxpbnB1dCB0eXBlPSJTdWJtaXQiLz48L2Zvcm0+PFw/cGhwIH19IFw/PlxzKkVPRDtccyooXCRcdyspID0gYXJyYXlcKChcMVwuIi9bYS16MC05XC1fXHNcL10rXC5waHAiPyw/XHMqKStcKTtccypmb3JlYWNoXChcMTAgYXMgKFwkXHcrKVwpe1xzKihcJFx3KykgPSBmaWxlX2dldF9jb250ZW50c1woXDEyXCk7XHMqaWYgXChzdHJpcG9zXChcMTMsICdcdysnXCkgPT0gZmFsc2VcKXtccyppZlwocHJlZ19tYXRjaFwoJy9cXFw/PlwoXFxzXCtcKVw/XCQvaScsIFwxM1wpID09IGZhbHNlXCl7XHMqXDEzIFwuPSBcMjtccypmaWxlX3B1dF9jb250ZW50c1woXDEyLCBcMTNcKTtccyp9ZWxzZXtccyooXCRcdyspID0gJy9cXFw/PlwoXFxzXCtcKVw/XCQvaSc7XHMqKFwkXHcrKSA9ICdcPz4nO1xzKlwxM1xzKj0gcHJlZ19yZXBsYWNlXChcMTQsIFwxNSwgXDEzXCk7XHMqXDEzIFwuPSBcNjtccypmaWxlX3B1dF9jb250ZW50c1woXDEyLCBcMTNcKTtccyp9XHMqfVxzKn1ccyp9IjtpOjk4O3M6MTMyOiI8XD9waHBccyppZlwoc3RycG9zXChzdHJ0b2xvd2VyXChcJF9TRVJWRVJcWydSRVFVRVNUX1VSSSdcXVwpLCdlc3NheSdcKVwpe2luY2x1ZGVcKGdldGN3ZFwoXClcLicvY29uZmlnLWluZm9cLnBocCdcKTtccypleGl0O31ccypcPz4iO2k6OTk7czo1MTk6IjxcP3BocFxzKmVycm9yX3JlcG9ydGluZ1woMFwpO1xzKihcJFx3Kyk9YXJyYXlcKFwpO1xzKmlmIFwoc3RybGVuXChcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxbJyhcdyspJ1xdXCk+MFwpe1wxPWV4cGxvZGVcKCcgOjogJyx1cmxkZWNvZGVcKFwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXFsnXDInXF1cKVwpO31ccyppZiBcKHN0cmxlblwoXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClcWycoXHcrKSdcXVwpPjBcKXthcnJheV9wdXNoXChcMSxcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxbJ1wzJ1xdXCk7fVxzKihcJFx3Kyk9XCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClcWydcdysnXF07XHMqKFwkXHcrKSA9IHVybGRlY29kZVwoXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClcWydcdysnXF1cKTtccypmb3JlYWNoIFwoXDEgYXMgKFwkXHcrKVwpLio/XCRcdys9ZndyaXRlXChcJFx3KyxcNVwpOy4qP1w/PiI7aToxMDA7czoxNTE6ImlmXChpc3NldFwoXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClcWycoXHcrKSdcXVwpXCl7IFwkKFx3KykgPSBiYXNlNjRfZGVjb2RlXChcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxbJ1wxJ1xdXCk7IEBldmFsXChcJFwyXCk7IH0iO2k6MTAxO3M6MzAzOiI8XD9waHBccyovXCpccypcdytccypcKi9ccypcPz48XD9waHBccyooXCRcdyspXHMqPVxzKiJbXiJdKyI7XHMqKFwkXHcrKVxzKj1ccypiYXNlNjRfZGVjb2RlXChcMVwpO1xzKihcJFx3Kylccyo9XHMqJyc7XHMqZm9yXHMqXChcJFx3K1xzKj1ccyowO1xzKlwkXHcrXHMqPFxzKnN0cmxlblwoXDJcKTtccypcJFx3K1wrXCtcKVxzKntccypcM1xzKlwuPVxzKmNoclwob3JkXChcMlxbXCRcdytcXVwpXHMqXF5ccypvcmRcKCd4J1wpXCk7XHMqfVxzKmV2YWxcKFwzXClccypcPz5ccyo8XD9waHBccyovXCpccypcdytccypcKi9ccypcPz4iO2k6MTAyO3M6MzQ0OiIoXCRcdyspXHMqPVxzKlsnfCJdW2Fzc2VydF0rKFx8XHxcfFx3K1x8XHxcfClbYXNzZXJ0XStbJ3wiXTtccyooXCRcdyspXHMqPVxzKlsnfCJdW2Jhc2U2NF9kZWNvZGVdKyhcMilbYmFzZTY0X2RlY29kZV0rWyd8Il07XHMqKFwkXHcrKVxzKj1ccypzdHJfcmVwbGFjZVwoWyd8Il1cMlsnfCJdLFsnfCJdKyxcMVwpO1xzKihcJFx3Kylccyo9XHMqc3RyX3JlcGxhY2VcKFsnfCJdXDJbJ3wiXSxbJ3wiXSssXDNcKTtccyooXCRcdyspXHMqPVxzKlsnfCJdW1x3PV0rXDJbXHcrPV0rJztccypcJFx3K1xzKj1ccypzdHJfcmVwbGFjZVwoWyd8Il1cMlsnfCJdLFsnfCJdKyxcN1wpO1xzKlwxXChcM1woXDdcKVwpOyI7aToxMDM7czo4MDc6IihcJFx3Kylccyo9XHMqc2NhbmRpclwoXCRfU0VSVkVSXFsnRE9DVU1FTlRfUk9PVCdcXVwpO1xzKmZvclxzKlwoKFwkXHcrKT0wO1wyPGNvdW50XChcMVwpO1wyXCtcK1wpXHMqe1xzKmlmXChzdHJpc3RyXChcMVxbXDJcXSxccyoncGhwJ1wpXClccyp7XHMqKFwkXHcrKVxzKj1ccypmaWxlbXRpbWVcKFwkX1NFUlZFUlxbJ0RPQ1VNRU5UX1JPT1QnXF0uIi8iLlwxXFtcMlxdXCk7XHMqYnJlYWs7XHMqfVxzKn1ccyp0b3VjaFwoZGlybmFtZVwoX19GSUxFX19cKSxccypcM1wpO3RvdWNoXChcJF9TRVJWRVJcWydTQ1JJUFRfRklMRU5BTUUnXF0sXHMqXDNcKTtccypAXCRfUkVRVUVTVFxbJ1x3KydcXVwoc3RyX3JvdDEzXCgncmlueVwoXCRfRVJESFJGR1xbIlx3KyJcXVwpOydcKVwpO1xzKmlmXChccyohXHMqZGVmaW5lZFwoXHMqJ0RBVEFMSUZFRU5HSU5FJ1xzKlwpXHMqXClccyp7XHMqZGllXChccyoiSGFja2luZ1xzKmF0dGVtcHQhIlxzKlwpO1xzKn1ccyppZlwoXHMqaXNzZXRcKFxzKlwkdmlld190ZW1wbGF0ZVxzKlwpXHMqYW5kXHMqXCR2aWV3X3RlbXBsYXRlXHMqPT1ccyoicnNzIlxzKlwpXHMqe1xzKn1ccyplbHNlaWZcKFxzKlwkY2F0ZWdvcnlfaWRccyphbmRccypcJGNhdF9pbmZvXFtcJGNhdGVnb3J5X2lkXF1cWydzaG90X3RwbCdcXVxzKiE9XHMqJydccypcKVxzKlwkdHBsLT5sb2FkX3RlbXBsYXRlXChccypcJGNhdF9pbmZvXFtcJGNhdGVnb3J5X2lkXF1cWydzaG90X3RwbCdcXVxzKi5ccyonLnRwbCdccypcKTtccyplbHNlXHMqXCR0cGwtPmxvYWRfdGVtcGxhdGVcKFxzKidcdysudHBsJ1xzKlwpO1xzKiI7aToxMDQ7czozNzI6IihcJFx3Kylccyo9XHMqc2NhbmRpclwoXCRfU0VSVkVSXFsnRE9DVU1FTlRfUk9PVCdcXVwpO1xzKmZvclxzKlwoKFwkXHcrKT0wO1wyPGNvdW50XChcMVwpO1wyXCtcK1wpXHMqe1xzKmlmXChzdHJpc3RyXChcMVxbXDJcXSxccyoncGhwJ1wpXClccyp7XHMqKFwkXHcrKVxzKj1ccypmaWxlbXRpbWVcKFwkX1NFUlZFUlxbJ0RPQ1VNRU5UX1JPT1QnXF1cLiIvIlwuXDFcW1wyXF1cKTtccypicmVhaztccyp9XHMqfVxzKnRvdWNoXChkaXJuYW1lXChfX0ZJTEVfX1wpLFxzKlwzXCk7XHMqdG91Y2hcKFwkX1NFUlZFUlxbJ1NDUklQVF9GSUxFTkFNRSdcXSxccypcM1wpO1xzKmNobW9kXChcJF9TRVJWRVJcWydTQ1JJUFRfRklMRU5BTUUnXF0sXHMqMDQ0NFwpOyI7aToxMDU7czoyNjU6IihcJFx3Kyk9Wyd8Il0oXHcrKVwuemlwWyd8Il07XHMqKFwkXHcrKVxzKj1ccypmaWxlX2dldF9jb250ZW50c1woWyd8Il1bXid8XiJdK1snfCJdXCk7XHMqZmlsZV9wdXRfY29udGVudHNcKFwxLFxzKlwzXCk7Lio/cGNsemlwXC5saWJcLnBocC4qKFwkXHcrKVxzKj1ccypuZXdccypQY2xaaXBcKFwxXCk7XHMqaWZccypcKFw0LT5leHRyYWN0XChcKVxzKj09XHMqMFwpXHMqe1xzKmRpZVwoIkVycm9yXHMqOlxzKiJcLlw0LT5lcnJvckluZm9cKHRydWVcKVwpO1xzKn0iO2k6MTA2O3M6NTkzOiI8aHRtbD5ccyo8aGVhZD5ccyo8bWV0YSBodHRwLWVxdWl2PSJDb250ZW50LVR5cGUiIGNvbnRlbnQ9InRleHQvaHRtbDsgY2hhcnNldD13aW5kb3dzLXV0Zi04Ij5ccyo8dGl0bGU+XHcrPC90aXRsZT5ccyo8L2hlYWQ+XHMqPGJvZHk+XHMqPFw/cGhwXHMqcHJpbnQgJzxoMT4uKj88L2gxPic7XHMqZWNobyAiLio/IjsuKj9lY2hvXHMqXCRfU0VSVkVSXFsnUkVNT1RFX0FERFInXF07XHMqZWNob1xzKiI8Zm9ybSBtZXRob2Q9XFwicG9zdFxcIlxzKmVuY3R5cGU9XFwibXVsdGlwYXJ0L2Zvcm0tZGF0YVxcIj4uKj9pZlxzKlwoXHMqQGlzX3VwbG9hZGVkX2ZpbGVcKFxzKlwkX0ZJTEVTXFsiXHcrIlxdXFsiXHcrIlxdXHMqXClcKVxzKntccyouKj9tb3ZlX3VwbG9hZGVkX2ZpbGVcKFwkX0ZJTEVTXFsiXHcrIlxdXFsidG1wX25hbWUiXSwuKj9cJF9GSUxFU1xbIlx3KyJcXVxbIm5hbWUiXF1cKTsuKj9lY2hvXHMqIjxhXHMqaHJlZj1cXCJcJFx3K1xcIj5cJFx3KzwvYT4iO1xzKi4qP1wkXHcrXHMqPVxzKlwkX1NFUlZFUlxbJ1NDUklQVF9GSUxFTkFNRSdcXTtccyp0b3VjaFwoXHMqXCRcdytccypcKTtccypcPz5ccyo8L2JvZHk+XHMqPC9odG1sPiI7aToxMDc7czoyNDU6ImlmXHMqXChcJG1vZGU9PSd1cGxvYWQnXClccyp7XHMqaWZcKGlzX3VwbG9hZGVkX2ZpbGVcKFwkX0ZJTEVTXFsiZmlsZW5hbWUiXF1cWyJ0bXBfbmFtZSJcXVwpXClccyp7XHMqbW92ZV91cGxvYWRlZF9maWxlXChcJF9GSUxFU1xbImZpbGVuYW1lIlxdXFsidG1wX25hbWUiXF0sXHMqXCRfRklMRVNcWyJmaWxlbmFtZSJcXVxbIm5hbWUiXF1cKTtccyplY2hvIFwkX0ZJTEVTXFsiZmlsZW5hbWUiXF1cWyJuYW1lIlxdO1xzKn1ccyp9IjtpOjEwODtzOjM5NToiZXJyb3JfcmVwb3J0aW5nXCgwXCk7XHMqc2V0X3RpbWVfbGltaXRcKDBcKTtccyppZlxzKlwoXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClcWydcdysnXF09PScxJ1wpe2VjaG9ccyonMjAwJztccypleGl0O31ccyppZlwoXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClcWydcdysnXF09PSdcdysnXClldmFsXChiYXNlNjRfZGVjb2RlXChcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxbJ1x3KydcXVwpXCk7XHMqaWZcKG1kNVwoXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClcWydcdysnXF1cKT09J1x3KydcKWV2YWxcKGJhc2U2NF9kZWNvZGVcKFwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXFsnXHcrJ1xdXClcKTsiO2k6MTA5O3M6NDk6IihcJFx3Kyk9ImJhc2U2NF9kZWNvZGUiO2Fzc2VydFwoXDFcKCdbXHc9XSsnXClcKTsiO2k6MTEwO3M6MTIzOiIoXCRcdytccyo9XHMqKGNoclwoXHMqKFxkK3xvcmRcKFsiJ11cdytbIiddXCkpXHMqW1xeXCtcLS9cKl1ccyooXGQrfG9yZFwoWyInXVx3K1siJ11cKSlccypcKVwuPykrO1xzKil7Mix9Lis/ZXhpdFwoXCR7XHcrXCgiO2k6MTExO3M6MTUwOiI8XD9waHBccypcJFx3K1xzKj1ccypBcnJheVwoKCdcdysnPT4nXHcrJyw/XHMqKXsyMCx9XHMqXCk7XHMqZnVuY3Rpb25ccypcdytcKFwkXHcrLFxzKlwkXHcrXCl7XCRcdysuKz9iYXNlNjRfZGVjb2RlLitldmFsXChcdytcKFwkXHcrLFxzKlwkXHcrXClcKTtcPz4iO2k6MTEyO3M6NTg6IjxcP3BocFxzKmV2YWxcKCIoXFx4P1tcd10rKXs2LH0uKyhcXHg/W1x3XXszLH0pIlwpO1xzKlw/PiQiO2k6MTEzO3M6NTU6Ii8vXCNcI1wjPUNBQ0hFIFNUQVJUPVwjXCNcIy4qPy8vXCNcI1wjPUNBQ0hFIEVORD1cI1wjXCMiO2k6MTE0O3M6MTIyOiI8XD9waHBccyppZlwoIVwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXFsnXHcrJ1xdXCl7XHMqaGVhZGVyXCgnSFRUUC8xXC4xIDQwNCBOb3QgRm91bmQnXCk7XHMqZXhpdFwoXCk7Lis/fVxzKlw/PiI7aToxMTU7czo5NzoiPFw/cGhwXHMqXCRcdytccyo9XHMqWyJiYXNlNjRcc1wuX2RlY29kZSJdKztccyphc3NlcnRcKFwkXHcrXCgnW2EtekEtWjAtOVxkXC4vXXs1MDAsfSdcKVwpO1xzKlw/PiI7aToxMTY7czo4MToiPFw/cGhwXHMqL1wqLis/XCovXHMqQGV2YWxcKFwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXFsnXHcrJ1xdXCk7XHMqXD8+IjtpOjExNztzOjEwODoiaWZccypcKFxzKlwhXHMqZGVmaW5lZFxzKlwoXHMqXCdJUEJfRklSRVdBTEwnLipfZmluZElwYlJvb3QuKmNvbmZfZ2xvYmFsXC5waHAuKklQQl9GaXJld2FsbFw6XDpydW5cKFwpO1xzKlx9IjtpOjExODtzOjI5ODoiXCQoXHcrKT0iY3JlYXRlXyI7Z2xvYmFsXHMrXCQoXHcrKTtccypcJFwyPWFycmF5XCgnXCRcMltcZCtdPWFycmF5X3BvcChcJFwyKTtcJChcdyspPVwzXChcZCtcKTtcJFwyW1xkK109XCRcM1woXCRcMltcZCtdXCk7Lj9cJFwyW1xkK109Z3p1bmNvbXByZXNzXCguKz9cKTtpZlwoZnVuY3Rpb25fZXhpc3RzXChcJFwxXC49J2Z1bmN0aW9uJ1wpJiYhZnVuY3Rpb25fZXhpc3RzXCgnXDMnXClcKXtccypmdW5jdGlvblxzK1wzXChcJFx3KyxcJFx3Kz1cZCtcKXtnbG9iYWxccytcJFwyOy4/O1wkXDEuPzt1bnNldFwoXCRcMlwpOyI7aToxMTk7czoxNjI6IlxzK2lmXChAP2lzc2V0XChcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxbXHcrXF1cKVwpe1xzKmVjaG9ccyonPGZvcm1ccythY3Rpb249IlxzKiJccyttZXRob2Q9Ii4rP2Fzc2VydFwoc3RyaXBzbGFzaGVzXChcJF9SRVFVRVNUXFtcdytcXVwpXCk7ZWxzZSBleGl0OyI7aToxMjA7czo4NToiXHMraWZcKGlzc2V0XChcJF9SRVFVRVNUXFsnP1x3Kyc/XF1cKVwpXHMqYXNzZXJ0XChzdHJpcHNsYXNoZXNcKFwkX1JFUVVFU1RcW1x3K11cKVwpOyI7aToxMjE7czozMjoiYXJyMmh0bWxcKFwkX1JFUVVFU1RcWydcdysnXF1cKTsiO2k6MTIyO3M6MTkxOiJcKFwkXHcrXHMqPVxzKlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXFtccyonXHcrJ1xzKlxdXClccyomJlxzKkBwcmVnX3JlcGxhY2VcKCcvXHcrL2UnXHMqLFxzKidAJ1xzKlwuXHMqYmFzZTY0X2RlY29kZVwoXHMqIltcdz0rL10rIlxzKlwpXHMqXC4nXHMqXChccypcJFx3K1xzKlwpJ1xzKixccyonXHcrJ1xzKlwpOyI7aToxMjM7czo1MDoiZXZhbFwoc3RycmV2XChmaWxlX2dldF9jb250ZW50c1woJ1tcLVx3Ll0rJ1wpXClcKTsiO2k6MTI0O3M6MTE1OiJlcnJvcl9yZXBvcnRpbmcoMCk7XHMqaW5pX3NldChccyoiZGlzcGxheV9lcnJvcnMiXHMqLFxzKjApXDtccyppbmNsdWRlX29uY2Uoc3lzX2dldF90ZW1wX2RpcigpXC4iL1NFU1NfW2EtZjAtOV0rIik7IjtpOjEyNTtzOjUwMDoiXCR1cmxccyo9XHMqIi4qPyI7XHMqaWZccypcKGlzc2V0XChcJF9TRVJWRVJcWydIVFRQX1JFRkVSRVInXF1cKVxzKkFORFxzKiFpc3NldFwoXCRfQ09PS0lFXFsiXHcrIlxdXClcKVxzKntccypzZXRjb29raWVcKCJcdysiLFxzKiIxIixccyp0aW1lXChcKVwrXGQrXCk7XHMqXCR1cmxzXHMqPVxzKmFycmF5XCgiZ29vZ2xlXC4iLFxzKiJ5YW5kZXhcLiIsXHMqInlhaG9vXC4iLFxzKiJhb2xcLiIsXHMqIm1zblwuIixccyoicmFtYmxlclwuIixccyoibWFpbFwuIixccyoieWFcLiIsXHMqImJpbmdcLiIsXCk7XHMqZm9yXHMqXChcJGk9MDtccypcJGlccyo8XHMqY291bnRcKFwkdXJsc1wpO1xzKlwkaVwrXCtcKVxzKmlmXHMqXChzdHJwb3NcKFwkX1NFUlZFUlxbJ0hUVFBfUkVGRVJFUidcXSxccypcJHVybHNcW1wkaVxdXCkhPT1mYWxzZVwpXHMqZXhpdFwoJzxzY3JpcHQ+ZG9jdW1lbnRcLmxvY2F0aW9uXC5ocmVmXHMqPVxzKiInXC5cJHVybFwuJyI7PC9zY3JpcHQ+J1wpO1xzKn0iO2k6MTI2O3M6MTM4OiJlcnJvcl9yZXBvcnRpbmdcKDBcKTtccyppbmlfc2V0XChccyoiZGlzcGxheV9lcnJvcnMiXHMqLFxzKjBcKVw7XHMqaW5jbHVkZV9vbmNlXChccypzeXNfZ2V0X3RlbXBfZGlyXChccypcKVxzKlwuXHMqIi9TRVNTX1thLWYwLTldezMyfSJcKTsiO2k6MTI3O3M6MjY2OiJcJEdMT0JBTFNcWydfKFxkKylfJ1xdPUFycmF5XChiYXNlNjRfZGVjb2RlXCguKj9pZlwoaXNzZXRcKFwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXFtfKFxkKylcKFxkK1wpXF1cKVwpe1wkX1xkKz1cJEdMT0JBTFNcWydfXDFfJ1xdXFtcZCtcXVwoXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClcW19cMlwoXGQrXClcXVwpO1wkR0xPQkFMU1xbJ19cMV8nXF1cW1xkK1xdXChcJF9cZCssXCRfXGQrXCk7fWVjaG8gXCRfXGQrO2V4aXQ7fSI7aToxMjg7czo0ODM6ImlmXHMqXChcJF9TRVJWRVJcWydRVUVSWV9TVFJJTkcnXF1ccyo9PVxzKidpbmRleCdcKVxzKntccyplY2hvXHMqJzxmb3JtXHMqYWN0aW9uPSIiXHMqbWV0aG9kPXBvc3RccyplbmN0eXBlPW11bHRpcGFydC9mb3JtLWRhdGE+PGlucHV0XHMqdHlwZT1maWxlXHMqbmFtZT11cGxvYWRmaWxlPjxpbnB1dFxzKnR5cGU9c3VibWl0XHMqdmFsdWU9VXBsb2FkPjwvZm9ybT4nO1xzKlwkdXBsb2FkZGlyXHMqPVxzKicnO1xzKlwkdXBsb2FkZmlsZVxzKj1ccypcJHVwbG9hZGRpclwuYmFzZW5hbWVcKFwkX0ZJTEVTXFsndXBsb2FkZmlsZSdcXVxbJ25hbWUnXF1cKTtccyppZlxzKlwoY29weVwoXCRfRklMRVNcWyd1cGxvYWRmaWxlJ1xdXFsndG1wX25hbWUnXF0sXHMqXCR1cGxvYWRmaWxlXClcKVxzKntccyplY2hvXHMqIjxoMz5PSzwvaDM+IjtccypleGl0O1xzKn1lbHNle1xzKmVjaG9ccyoiPGgzPk5PPC9oMz4iO1xzKmV4aXQ7XHMqfVxzKmV4aXQ7XHMqfSI7aToxMjk7czo4MToiaWZcKGlzc2V0XChcJF9SRVFVRVNUXFsiKFx3KykiXF1cKVwpXHMqXCRfUkVRVUVTVFxbIlwxIlxdXChcJF9SRVFVRVNUXFsiXHcrIlxdXCk7IjtpOjEzMDtzOjIxMzoiPFw/cGhwXHMqXCRcdytccyo9XHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClcWydcdysnXF07XHMqaWZccypcKFwkXHcrXHMqIT1ccyoiIlwpXHMqe1xzKlwkXHcrPWJhc2U2NF9kZWNvZGVcKFwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXFsnXHcrJ1xdXCk7XHMqQGV2YWxcKCJcXFwkXHcrXHMqPVxzKlwkXHcrOyJcKTtccyp9XHMqXD8+IjtpOjEzMTtzOjEwNToiQHByZWdfcmVwbGFjZVwoIi9cW1x3K1xdL2UiXHMqLFxzKlwkXyhDT09LSUV8UE9TVHxHRVR8UkVRVUVTVHxTRVJWRVIpXHMqXFtccyonXHcrJ1xzKlxdXHMqLFxzKiJcdysiXHMqXCk7IjtpOjEzMjtzOjE0NjoiPFw/cGhwXHMqXCRHTE9CQUxTXFsnXHcrJ1xdXHMqPVxzKiJcdysiO1xzKlwkXHcrPSJbY3JlYXRlX2Z1bmN0aW9uXC5cIlxzXSsiO1wkXHcrPVwkXHcrXCgnW1wkZXZhbHgnLFwuKFwiXD8+Z3ppbmZsdGJzNjRkY29kZV8pO10rXCRcdytcKCIuKyJcKTtcPz4iO2k6MTMzO3M6MjE4OiI8XD9waHBccypcJFx3Kz1cIi4rP1wiO1wkR0xPQkFMU1xbJ1x3KydcXVxzKj1ccypcJHsoXCRcdytcW1xkK1xdXC4/KSt9O1wkR0xPQkFMU1xbJ1x3KydcXVxzKj1ccyooXCRcdytcW1xkK1xdXC4/KSs7aWZccypcKCFlbXB0eVwoXCRHTE9CQUxTXFsnXHcrJ1xdXFsnXHcrJ1xdXClcKVxzKntccypldmFsXChcJEdMT0JBTFNcWy4rP2VjaG9ccysoXCRcdytcW1xkK1xdXC4/KXsxMCx9OyI7aToxMzQ7czoxMTg6IlwkXHcrXHMqPVxzKiJbcHJlZ19yZXBsYWNlXHNcLlwiXSsiO1xzKlwkXHcrXCgiL1xbZGlzY3V6XF0vZSIsXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClcWydcdysnXF0sIlteXCJdKyJcKTsiO2k6MTM1O3M6MTQ1OiJSZXdyaXRlRW5naW5lXHMrb25ccypSZXdyaXRlQ29uZFxzKyV7SFRUUF9VU0VSX0FHRU5UfVxzK2FuZHJvaWRcfGF2YW50Z29cfGJhZGEuKz96ZXRvXHx6dGVcXC1cKVxzKlxbTkNcXVxzK1Jld3JpdGVSdWxlXHMqXF5cJFxzK2h0dHA6Ly8uKz9cW1IsTFxdIjtpOjEzNjtzOjIzMjoiPElmTW9kdWxlXHMrbW9kX3Jld3JpdGVcLmM+XHMqUmV3cml0ZUNvbmRccysle0hUVFBfVVNFUl9BR0VOVH1ccytcKGdvb2dsZVx8eWFob29cfG1zblx8YW9sXHxiaW5nXCkgXFtPUlxdXHMqUmV3cml0ZUNvbmRccysle0hUVFBfUkVGRVJFUn1ccytcKGdvb2dsZVx8eWFob29cfG1zblx8YW9sXHxiaW5nXClccypSZXdyaXRlUnVsZSBcXlwuXCpcJFxzK2luZGV4XC5waHBccytcW0xcXVxzKjxcL0lmTW9kdWxlPiI7aToxMzc7czoxNTE6ImlmXChpc3NldFwoXCRfKEdFVHxQT1NUfENPT0tJRXxSRVFVRVNUKVxbIlx3KyJcXVwpXCl7QFwkXyhHRVR8UE9TVHxDT09LSUV8UkVRVUVTVClcWyJcdysiXF1cKHN0cmlwc2xhc2hlc1woXCRfKEdFVHxQT1NUfENPT0tJRXxSRVFVRVNUKVxbIlx3KyJcXVwpXCk7fTsiO2k6MTM4O3M6MTUyOiJpZlxzKlwoXHMqXCRfUkVRVUVTVFxbIlx3KyJcXVxzKlwpXHMqe1xzKkBhc3NlcnRcKFxzKmJhc2U2NF9kZWNvZGVcKFxzKlwkX1JFUVVFU1RcW1xzKiJcdysiXHMqXF1cKVwpO1xzKi8vW1x3XHNdK1xzKmVjaG9ccyoiW1x3XHNdKyI7XHMqZXhpdFwoXHMqXCk7XHMqfSI7aToxMzk7czoxMzY6Ii9cKi4rP1wqL1xzKihcJFx3K1xzKj1ccyonW14nXSsnXHMqXF5ccyonW14nXSsnXHMqO1xzKil7MywxMH1cJFx3K1xzKj1ccypcJFx3K1woJycsXCRcdytcKFwkXHcrXCgnW14nXSsnXF4nW14nXSsnXClcKVwpO1xzKlwkXHcrXChccypcKTsiO2k6MTQwO3M6MTEzOiIoLy9cdytccyopPyhcJFx3K1xzKj1ccyoiW14iXSsiXHMqXF5ccyoiW14iXSsiO1xzKikrXCRcdytcKFwkXHcrXHMqLFxzKiJbXiJdKyJcXiJbXiJdKyJccyosXHMqIlx3KyJcKTsoLy9cdytccyopPyI7aToxNDE7czo2NzoiPFw/cGhwXHMrQD9ldmFsXChcJF8oR0VUfFBPU1R8Q09PS0lFfFJFUVVFU1R8U0VSVkVSKVxbIlx3KyJcXVwpO1w/PiI7aToxNDI7czoyNjY6IjxcP3BocFxzKmlmXChccyppc3NldFwoXHMqXCRfKFJFUVVFU1R8R0VUfFBPU1R8Q09PS0lFfFNFUlZFUilcWyJcdysiXF1ccypcKVxzKlwpXHMqe1xzKmVjaG9ccyoiW14iXSsiO1xzKn1ccypcJGZccyo9XHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClcWyJcdysiXF07XHMqXCRpZD1cJGY7XHMqXCRjdXJyZW50XHMqPVxzKmZpbGVfZ2V0X2NvbnRlbnRzXCgiW14iXSsiXCk7XHMqZmlsZV9wdXRfY29udGVudHNcKFwkXHcrXHMqLFxzKlwkXHcrXCk7IjtpOjE0MztzOjE2NzoiPFw/cGhwXHMqXCRwYXNzd29yZD0uKz9pZlxzKlwoIWVtcHR5XHMqXChcJF9GSUxFU1xbJ1x3KydcXVwpXClccyp7XHMqbW92ZV91cGxvYWRlZF9maWxlLis/PGlucHV0IHR5cGU9InN1Ym1pdCIgbmFtZT0ibG9naW4iIHZhbHVlPSJnbyEiIC9ccyo+PC9mb3JtPlxzKjxcP3BocFxzKn1ccypcPz4iO2k6MTQ0O3M6MTAyOiI8XD9waHBccypcJFx3K1xzKj1ccyoiW2Fzc2VydGV2bCJcLl0rIlxzKjtccypcJFx3K1woXHMqXCRfKEdFVHxQT1NUfENPT0tJRXxSRVFVRVNUfFNFUlZFUilcWyJcdysiXF1cKTsiO2k6MTQ1O3M6MjQ2OiJlcnJvcl9yZXBvcnRpbmdcKEVfQUxMXCk7XHMqXCRcdytccyo9XHMqJyc7XHMqXCRcdytccyo9XHMqJ1Jld3JpdGVFbmdpbmUgT24uK2lmXHMqXChmaWxlX2V4aXN0c1woJ2luZGV4XC5waHAnXClcKVxzKntccypmaWxlX3B1dF9jb250ZW50c1woJ2luZGV4XC5waHAnXHMqLFxzKnN0cl9yZXBsYWNlXChhcnJheVwoXCRcdyssXCRcdytcKSxccyonJ1xzKixccypmaWxlX2dldF9jb250ZW50c1woJ2luZGV4XC5waHAnXClcKVwpO1xzKn0iO2k6MTQ2O3M6NDMyOiI8XD9waHBccyphZGRfYWN0aW9uXChccyond3BfaGVhZCdccyosXHMqJ1x3KydccypcKTtccypmdW5jdGlvblxzK1x3K1woXClccyp7XHMqaWZccypcKFxzKm1kNVwoXHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClcWydcdysnXF1ccypcKVxzKj09XHMqJ1x3KydccypcKVxzKntccypyZXF1aXJlXChccyond3AtaW5jbHVkZXMvcmVnaXN0cmF0aW9uXC5waHAnXHMqXCk7XHMqaWZccypcKFxzKiF1c2VybmFtZV9leGlzdHNcKFxzKidcdysnXHMqXClccypcKVxzKntccypcJHVzZXJfaWRccyo9XHMqd3BfY3JlYXRlX3VzZXJcKFxzKidcdysnLFxzKidcdysnXHMqXCk7XHMqXCRcdytccyo9XHMqbmV3XHMrV1BfVXNlclwoXHMqXCR1c2VyX2lkXHMqXCk7XHMqXCR1c2VyLT5zZXRfcm9sZVwoXHMqJ1x3KydccypcKTtccyp9XHMqfVxzKn1ccypcPz4iO2k6MTQ3O3M6OTk6IjxcP3BocFxzKmVjaG9ccyonPGI+PGJyPjxicj4nXC5waHBfdW5hbWVcKFxzKlwpLitlY2hvXHMqJzxiPlVwbG9hZFtePF0rPC9iPjxicj48YnI+Jztccyp9XHMqfVxzKlw/PiI7aToxNDg7czo2NDoiPFw/cGhwXHMqQD9ldmFsXChcJF8oUE9TVHxHRVR8Q09PS0lFfFJFUVVFU1R8U0VSVkVSKVxbJ1x3KydcXVwpOyI7aToxNDk7czoyNjQ6IjxcP3BocFxzK2Z1bmN0aW9uXHMrXHcrXChcJFx3K1wpe1xzKlwkXHcrXHMqPVxzKidbYmFzZTY0ZGVjb2RlX1wuJ10rJztccypcJFx3K1xzKj1ccypnemluZmxhdGVcKFwkY29kZVwoXCRcdytcKVwpO1xzKmZvclwoXCRpPTA7XCRpPHN0cmxlblwoXCRcdytcKTtcJGlcK1wrXClccyp7XHMqXCRcdytcW1wkaVxdXHMqPVxzKmNoclwob3JkXChcJFx3K1xbXCRpXF1cKS0xXCk7XHMqfVxzKnJldHVyblxzK1wkXHcrO1xzKn1ldmFsXChcdytcKCJbXiJdKyJcKVwpO1w/PiI7aToxNTA7czoyMjc6IjxcP3BocFxzKihcJFx3K1xzKj1ccyoiW2EtekEtWl89LzAtOVw/XSsiO1xzKikrXHMqKFwkXHcrXHMqPVxzKihzdHJfcmVwbGFjZXxcJFx3KylccypcKFxzKiJcdysiXHMqLFxzKiIiXHMqLFxzKiJcdysiXCk7XHMqKStcJFx3K1xzKj1ccypcJFx3K1xzKlwoXHMqJydccyosXHMqXCRcdytccypcKFxzKlwkXHcrXHMqXChccypcJFx3K1woIlteIl0rIlxzKixccyoiIlxzKixccyouKz9cJFx3K1woXCk7IjtpOjE1MTtzOjE4NzoiPFw/cGhwXHMqKFwkXHcrXHMqPVxzKiJbYS16QS1aMC05Lz1fXSsiO1xzKlwkXHcrXHMqPVxzKihzdHJfcmVwbGFjZXxcJFx3KylcKFxzKiJcdysiXHMqLFxzKiIiXHMqLFxzKiJcdysiXHMqXCk7XHMqKStcJFx3K1xzKj1ccyoiXHcrIjtccypcJFx3K1xzKj1ccypcJFx3K1xzKlwoXHMqJydccyosXHMqXCQqLis/XCRcdytcKFwpOyI7aToxNTI7czoxMDk6IjxcP3BocFxzKlwkXHcrXHMqPVxzKmJhc2U2NF9kZWNvZGVcKCcuKz87QD9cJGNcKFwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXFtbJyJdP1x3K1snIl0/XF1cKTtccypcPz4iO2k6MTUzO3M6MTM2OiI8XD9waHBccypcJFx3K1xzKj1ccyoiW3ByZWdfcmVwbGFjZVwuXCJdKyI7XHMqQD9cJFx3K1woXHMqIi9cW1x3K1xdL2UiXHMqLFxzKlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXFsiXHcrIlxdLCJcdysiXCk7XHMqXD8+IjtpOjE1NDtzOjEwODoiPFw/KHBocCk/XHMqXCRcdytccyo9XHMqQD9cJF9TRVJWRVJcWyJIVFRQX1VTRVJfQUdFTlQiXF0uKz9AZXZhbFwoXHMqXCRcdytcW1x3K1xdXHMqXCk7XHMqZWNob1xzKiJbXiJdKyI7XD8+IjtpOjE1NTtzOjE3MjoiXHMrXCRcdytccyo9XHMqIlx3KyJccyo7XHMqXCRcdytccyo9XHMqc3RydG91cHBlclxzKlwoKFxzKlwkXHcrXFtccypcZCtccypdXHMqXC4/KStcKVxzKjtccyppZlxzKlwoXHMqaXNzZXQuKz97XHMqZXZhbFxzKlwoXHMqXCR7XHMqXCRcdytccyp9XHMqXFtccyonXHcrJ1xzKlxdXHMqXClccyo7XHMqfSI7aToxNTY7czoxNzc6IlxzK1wkXHcrXHMqPVxzKiJcdysiXHMqO1xzKlwkXHcrXHMqPVxzKnN0cnRvbG93ZXJccypcKChccypcJFx3K1xbXHMqXGQrXHMqXVxzKlwuPykrXClccyo7Lis/ZXZhbFxzKlwoXHMqXCRcdytccypcdytccypcKFxzKlwkXHMqe1xzKlwkXHcrXHMqfVxzKlxbXHMqJ1x3KydccypcXVxzKlwpXHMqXClccyo7XHMqfSI7aToxNTc7czoxODM6IlxzK1wkXHcrXHMqPVxzKiJcdysiXHMqO1xzKlwkXHcrXHMqPShccypcJFx3K1xbXGQrXF1ccypcLj8pezMsfTtccypcJFx3K1xzKj1ccypcJFx3K1xzKlwoKFxzKlwkXHcrXFtcZCtcXVxzKlwuPyl7Myx9XClccyo7Lis/ZXZhbFxzKlwoXHMqXCR7XHMqXCRcdytccyp9XHMqXFtccyonXHcrJ1xzKlxdXHMqXClccyo7XHMqfSI7aToxNTg7czoyNDA6IlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXHMqXFtccyonXHcrJ1xzKlxdXChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqJ1x3KydccypcXVwoJydccyosXHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKidcdysnXHMqXF1cKFwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXHMqXFsnXHcrJ1xdXHMqXClccypcKVxzKlwpOyI7aToxNTk7czoyMzE6ImlmXChccyohZW1wdHlcKFxzKlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXHMqXClcKXtccypleHRyYWN0XChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlwpO1wkKFxzKlx3K1xzKilccyo9XHMqXCRcdytcKFxzKicnXHMqLFxzKlwkXHcrXChcJFx3K1woXHMqIlx3KyJccyosXHMqIiJccyosXHMqXCRcdytcKVxzKlwpXHMqXCk7XHMqXCRcMVwoXHMqXCk7XHMqfSI7aToxNjA7czo2NjoiPFw/cGhwXHMqXCRzdHJccyo9XHMqJ1teJ10rJztccyplY2hvIGJhc2U2NF9kZWNvZGVcKFwkc3RyXCk7XHMqXD8+IjtpOjE2MTtzOjEyOToiXCRcdys9ImNyZWF0ZS4rP3JldHVyblwoW159XSt9O2ZvclwoXCRcdys9LVxkKztcK1wrXCRcdys8XGQrO1wkXHcrXCgnJywnfSdcLlwkXHcrXFtccypcJFx3K1xzKlxdXHMqXC5ccyoneydcKVwpO307dW5zZXRcKFwkXHcrXCk7IjtpOjE2MjtzOjEyNzoiPFw/KHBocCk/XHMqQFwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXFsnXHcqJ1xdXHMqXChzdHJfcm90MTNccypcKCdcdypccypcKFxzKlwkX1x3KlxbIlx3KiJcXVxzKlwpOydccypcKVxzKlwpO1xzKlw/PiI7aToxNjM7czo5MjoiPElmTW9kdWxlIG1vZF9yZXdyaXRlXC5jPi4rP2dvb2dsZVx8eWFob29cfG1zblx8YW9sXHxiaW5nLis/aW5kZXhcLnBocFxzK1xbTFxdXHMqPC9JZk1vZHVsZT4iO2k6MTY0O3M6NTQwOiJcJFx3K1xzKj1ccypnZXRlbnZcKCJTQ1JJUFRfTkFNRSJcKTtccypcJFx3K1xzKj1ccypnZXRlbnZcKCJTQ1JJUFRfRklMRU5BTUUiXCk7XHMqXCRcdytccyo9XHMqc3Vic3RyXChcJFx3KyxccyowLFxzKnN0cnBvc1woXCRcdyssXHMqXCRcdytcKVwpO1xzKlwkXHcrXHMqPVxzKlwkXHcrXHMqXC5ccyonL3htMXJwY1wucGhwJztccyppZlxzKlwoIWZpbGVfZXhpc3RzXChcJFx3K1wpXHMqXHxcfFxzKmZpbGVfZXhpc3RzXChcJFx3K1wpXHMqJiZccypcKGZpbGVzaXplXChcJFx3K1wpXHMqPFxzKjMwMDBcKVxzKlx8XHxccypmaWxlX2V4aXN0c1woXCRcdytcKVxzKiYmXHMqXCh0aW1lXChcKVxzKi1ccypmaWxlbXRpbWVcKFwkXHcrXClccyo+XHMqNjBccypcKlxzKjYwXHMqXCpccyoxXClcKVxzKntccypmaWxlX3B1dF9jb250ZW50Lis/XCRlbmMxXHMqPVxzKlwkZW5jMlxzKj1ccypcJGVuYzNccyo9XHMqXCRlbmM0XHMqPVxzKiIiO1xzKn1ccyp3aGlsZVxzKlwoXCRpXHMqPFxzKnN0cmxlblwoXCRcdytcKVwpO1xzKnJldHVyblxzKlwkXHcrO1xzKn0iO2k6MTY1O3M6MzEwOiJcJHVzZXJfYWdlbnRfdG9fZmlsdGVyXHMqPVxzKmFycmF5XChccyonXCNBc2suKz9cJGNoXHMqPVxzKmN1cmxfaW5pdFwoXHMqXCk7XHMqY3VybF9zZXRvcHRcKFwkY2gsXHMqQ1VSTE9QVF9VUkwsXHMqImh0dHBzPzovLy4rP1w/dXNlcmFnZW50PVwkX1NFUlZFUlxbXHMqSFRUUF9VU0VSX0FHRU5UXHMqXF0mZG9tYWluPVwkX1NFUlZFUlxbXHMqSFRUUF9IT1NUXHMqXF0iXCk7XHMqXCRyZXN1bHRccyo9XHMqY3VybF9leGVjXChccypcJGNoXHMqXCk7XHMqY3VybF9jbG9zZVxzKlwoXHMqXCRjaFxzKlwpO1xzKmVjaG9ccypcJHJlc3VsdDtccyp9IjtpOjE2NjtzOjMxMjoiXCRxdWVyeVxzKj1ccyppc3NldFwoXCRfU0VSVkVSXFsnUVVFUllfU1RSSU5HJ1xdXClcP1xzKlwkX1NFUlZFUlxbJ1FVRVJZX1NUUklORydcXTpccyonJztccyppZlxzKlwoZmFsc2VccyohPT1ccypzdHJwb3NcKFwkcXVlcnksXHMqJ1tcdy1dKydcKVwpXHMqe1xzKl9fXHcrX1x3K1woXCk7Lis/c3RyZWFtX2NvbnRleHRfY3JlYXRlXChcJG9wdGlvbnNcKTtccypcJGNvbnRlbnRzXHMqPVxzKkBmaWxlX2dldF9jb250ZW50c1woXCR1cmwsXHMqZmFsc2UsXHMqXCRjb250ZXh0XCk7XHMqfVxzKn1ccyp9XHMqcmV0dXJuXHMqXCRjb250ZW50cztccyp9IjtpOjE2NztzOjE3MDoiaWZccypcKFxzKnN0cnBvc1woXHMqc3RydG9sb3dlclwoXHMqXCRfU0VSVkVSXFtccyonUkVRVUVTVF9VUkknXHMqXF1ccypcKVxzKixccyonXHcrJ1xzKlwpXHMqXClccyp7XHMqaW5jbHVkZVxzKlwoXHMqZ2V0Y3dkXHMqXChccypcKVxzKlwuXHMqJy9cdytcLnBocCdccypcKTtccypleGl0O1xzKn0iO2k6MTY4O3M6MjIzOiJpZlxzKlwoXHMqaXNzZXRcKFxzKlwkXyhHRVR8UE9TVHxDT09LSUV8UkVRVUVTVHxTRVJWRVIpXFtccypbJyJdXHcrWyciXVxzKlxdXHMqXClccypcKVxzKntccyooXHMqL1wqXHcrXCovKT9AP3ByZWdfcmVwbGFjZVwoXHMqWyciXS9cKFwuXCpcKS9lJ1xzKixccypAP1wkX1JFUVVFU1RcW1xzKlsnIl1cdytbJyJdXHMqXF1ccyosXHMqWyciXVsnIl1ccypcKTtccyooL1wqXHcrXCovKT9ccyp9IjtpOjE2OTtzOjE5NDoiaWZccypcKFxzKmlzc2V0XChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFJFUVVFU1R8U0VSVkVSKVxbWyInXVx3K1siJ11cXVwpXClccyp7KC9cKlx3K1wqLyk/QD9leHRyYWN0XChcJF8oR0VUfFBPU1R8Q09PS0lFfFJFUVVFU1R8U0VSVkVSKVwpO1xzKigvXCpcdytcKi8pP0A/ZGllXChcJFx3K1woXCRcdytcKVwpO1xzKigvXCpcdytcKi8pP30iO2k6MTcwO3M6MjQ4OiJAP2ZpbHRlcl92YXJccypcKFxzKlwkXyhHRVR8UE9TVHxSRVFVRVNUfFNFUlZFUnxDT09LSUUpe1xzKigvXCpcdytcKi8pP1snIl1cdytbJyJdL1wqXHcrXCovXHMqfVxzKixccypGSUxURVJfQ0FMTEJBQ0tccyosXHMqYXJyYXlcKFxzKigvXCpcdytcKi8pP1snIl1cdytbJyJdXHMqPT5ccypAP1wkXyhHRVR8UE9TVHxSRVFVRVNUfFNFUlZFUnxDT09LSUUpe1xzKigvXCpcdytcKi8pP1x3KygvXCpcdytcKi8pP1xzKn1ccypcKVxzKlwpOyI7aToxNzE7czoyMTc6IkA/YXJyYXlfZmlsdGVyXChccyovXCpcdytcKi9ccyphcnJheVwoXHMqL1wqXHcrXCovQD9cJF8oR0VUfFBPU1R8Q09PS0lFfFJFUVVFU1R8U0VSVkVSKXtccyooL1wqXHcrXCovKT8iXHcrIi9cKlx3K1wqL31cKVxzKixccypcJF8oR0VUfFBPU1R8Q09PS0lFfFJFUVVFU1R8U0VSVkVSKXtccyovXCpcdytcKi9bJyJdXHcrWyciXS9cKlx3K1wqL1xzKn1ccyovXCpcdytcKi9ccypcKTsiO2k6MTcyO3M6Mzk2OiJcJFx3K1xzKj1ccyonXHcrJztccyppZlwoXHMqaXNzZXRcKFxzKlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXFtccyonXHcrJ1xzKlxdXClcKVxzKntccyppZlxzKlwoXHMqbWQ1XChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxbXHMqJ1x3KydccypcXVwpXHMqPT09XHMqXCRcdytccypcKVxzKkA/ZXZhbFwoXHMqYmFzZTY0X2RlY29kZVwoXHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClcW1xzKidcdysnXHMqXF1ccypcKVxzKlwpO1xzKmV4aXQ7XHMqfVxzKmlmXChccyppc3NldFwoXHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClcW1xzKidcdysnXHMqXF1ccypcKVxzKlwpe1xzKnBocGluZm9cKFxzKlwpO1xzKn0iO2k6MTczO3M6Mjc1OiJcJFx3Kz1cJF8oR0VUfFBPU1R8Q09PS0lFfFJFUVVFU1R8U0VSVkVSKTtccypcJFx3K1xzKj1ccypcJFx3K1xbXHMqXHcrXHMqXF07XHMqaWZccypcKFxzKlwkXHcrXHMqXClccyp7XHMqXCRcdys9XHMqXCRcdytccypcKFwkXHcrXHMqXFtccypcdytccypcXVxzKlwpO1xzKlwkXHcrXHMqPVxzKlwkXHcrXHMqXChccypcJFx3K1xzKlxbXHMqXHcrXHMqXF1ccypcKTtccypcJFx3K1xzKj1ccypcJFx3K1xzKlwoIiJccyosXHMqXCRcdytccypcKTtccypcJFx3K1xzKlwoXHMqXCk7XHMqfSI7aToxNzQ7czoyMDE6ImlmXHMqXChccyptZDVcKFxzKkA/XCRfKEdFVHxQT1NUfENPT0tJRXxSRVFVRVNUfFNFUlZFUilcW1xzKlx3K1xzKlxdXClccyo9PVxzKidcdysnXHMqXClccypccypcKFxzKlwkXz1ccypAXCRfUkVRVUVTVFxbXHMqXHcrXHMqXF1cKVxzKlwuXHMqQD9cJF9cKFwkXyhHRVR8UE9TVHxDT09LSUV8UkVRVUVTVHxTRVJWRVIpXFtccypcdytccypcXVxzKlwpOyI7aToxNzU7czoxODI6IjxcP3BocFxzKlwkXHcrXHMqPVxzKmZpbGVfZ2V0X2NvbnRlbnRzXChccyoiaHR0cHM/W14iXSsiXHMqXCk7XHMqXCRcdytccyo9XHMqZm9wZW5cKFxzKiJcdytcLnBocCJccyosXHMqIndcKyJccypcKTtccypmd3JpdGVcKFxzKlwkXHcrXHMqLFxzKlwkXHcrXCk7XHMqZmNsb3NlXChccypcJGZvXHMqXCk7XHMqKFw/Pik/IjtpOjE3NjtzOjcxOiJSZXdyaXRlUnVsZVxzK1xeXChcW0EtWmEtejAtOS1cXVwrXClcLmh0bWxcJFxzK1x3K1wucGhwXD9obD1cJDFccytcW0xcXSI7aToxNzc7czoxODE6InNldF90aW1lX2xpbWl0XCgwXCk7XHMqaWdub3JlX3VzZXJfYWJvcnRcKFwpO1xzKmlmXHMqXChccypmaWxlc2l6ZVwoXHMqIlwuaHRhY2Nlc3MiXHMqXClccyo+XHMqXGQrXHMqXClccyp7XHMqXCRcdytccyo9XHMqZm9wZW4uKz9cKFxzKnN5c19nZXRfdGVtcF9kaXJcKFwpXHMqXC5ccyoiL1wkXHcrIlxzKlwpO1xzKn0iO2k6MTc4O3M6MjQ3OiI8XD9waHBccyplcnJvcl9yZXBvcnRpbmdcKDBcKTtpbmlfc2V0XCgiZGlzcGxheV9lcnJvcnMiLCAwXCk7XCRsb2NhbHBhdGg9Z2V0ZW52XCgiU0NSSVBUX05BTUUiXCk7XCRhYnNvbHV0ZXBhdGg9Z2V0ZW52XCgiU0NSSVBUX0ZJTEVOQU1FIlwpO1wkXHcrPXN1YnN0clwoXCRcdyssMCxzdHJwb3NcKFwkYWJzb2x1dGVwYXRoLFwkbG9jYWxwYXRoXClcKTtpbmNsdWRlX29uY2VcKFwkcm9vdF9wYXRoXC4iL1x3Ky56aXAiXCk7XHMqXD8+IjtpOjE3OTtzOjMxMzoiXCR2YXI9IFwkX1NFUlZFUlxbJ1BIUF9TRUxGJ1xdO1xzKlwkZm9ybSA9PDw8SFRNTFxzKjxmb3JtIGVuY3R5cGU9Im11bHRpcGFydC9mb3JtLWRhdGEiIGFjdGlvbj0iXCR2YXIiIG1ldGhvZD0iUE9TVCI+XHMqPGlucHV0IG5hbWU9InVwbG9hZEZpbGUiIHR5cGU9ImZpbGUiLz48YnIvPlxzKjxpbnB1dCB0eXBlPSJzdWJtaXQiIHZhbHVlPSJVcGxvYWQiIC8+XHMqPC9mb3JtPlxzKkhUTUw7XHMqaWYgXCghZW1wdHlcKFwkX0ZJTEVTXFsndXBsb2FkRmlsZScuKz9wcmludFxzKiJPSyI7XHMqfVxzKmVsc2Vccyp7XHMqcHJpbnRccypcJGZvcm07XHMqfSI7aToxODA7czoyNTY6ImVycm9yX3JlcG9ydGluZ1woMFwpO2luaV9zZXRcKCJkaXNwbGF5X2Vycm9ycyIsIDBcKTtcJGxvY2FscGF0aD1nZXRlbnZcKCJTQ1JJUFRfTkFNRSJcKTtcJGFic29sdXRlcGF0aD1nZXRlbnZcKCJTQ1JJUFRfRklMRU5BTUUiXCk7XCRyb290X3BhdGg9c3Vic3RyXChcJGFic29sdXRlcGF0aCwwLHN0cnBvc1woXCRhYnNvbHV0ZXBhdGgsXCRsb2NhbHBhdGhcKVwpO2luY2x1ZGVfb25jZVwoXCRyb290X3BhdGhcLiIvU0VTU19cd3szMn1cLnBocCJcKTsiO2k6MTgxO3M6NDk6IjxcP3BocFxzKmV2YWxcKGJhc2U2NF9kZWNvZGVcKCJJR1Z5Y205eVguKz0iXClcKTsiO2k6MTgyO3M6MTc4OiJcJEdMT0JBTFNcWydcdysnXF07Z2xvYmFsXCRcdys7XCRcdys9XCRHTE9CQUxTO1wke1snIl0oXFx4W2EtZjAtOUEtRl0rKStbJyJdfVxbWyciXVx3K1snIl1cXT0iKFxceFthLWYwLTlBLUZdKykrIjsuKz9cXVwpe2V2YWxcKFwkXHcrXFtcJFx3K1xbWyInXVx3K1siJ11cXVxbXGQrXF1cXVwpO31leGl0XChcKTt9IjtpOjE4MztzOjIwNjoiaWZccypcKHN0cnBvc1woXCRfU0VSVkVSXFsnUkVRVUVTVF9VUkknXF1ccyosXHMqJy4rPydcKVxzKiE9PVxzKmZhbHNlXClccyp7XHMqZXJyb3JfcmVwb3J0aW5nXCgwXCk7XHMqaW5pX3NldFwoJ2Rpc3BsYXlfZXJyb3JzJyxccyowXCk7XHMqc2V0X3RpbWVfbGltaXRcKDBcKTsuK2FkZF9maWx0ZXJcKCAnd3BfdGl0bGUnLFxzKidcdysnXHMqXCk7XHMqfVxzKn0iO2k6MTg0O3M6MjkyOiI8XD9ccypcJEdMT0JBTFNcWydfXGQrXydcXT1BcnJheVwoYmFzZTY0X2RlY29kZVwoKFxzKidbXHc9XSsnXHMqXC4/KStcKVwpO1xzKlw/PjxcP1xzKmZ1bmN0aW9uXHMqKF9cZCspXCgoXCRcdyspXClceyhcJFx3Kyk9QXJyYXlcKChccyonW1x3PV0rJ1xzKlwuPyw/KStcKTtyZXR1cm5ccypiYXNlNjRfZGVjb2RlXChcNFxbXDNcXVwpO31ccypcPz48XD9waHBccypcJHBhc3N3b3JkPVwyXChcZCtcKTtcJEdMT0JBTFNcWydfXGQrXydcXVxbXGQrXF1cKFwyXChcZFwpLFwyXChcZFwpLFwyXChcZFwpXCk7XHMqXD8+IjtpOjE4NTtzOjQxMDoiXCRsb2NhbHBhdGhccyo9XHMqZ2V0ZW52XCgiU0NSSVBUX05BTUUiXCk7XHMqXCRhYnNvbHV0ZXBhdGhccyo9XHMqZ2V0ZW52XCgiU0NSSVBUX0ZJTEVOQU1FIlwpO1xzKlwkcm9vdF9wYXRoXHMqPVxzKnN1YnN0clwoXCRhYnNvbHV0ZXBhdGgsXHMqMCxccypzdHJwb3NcKFwkYWJzb2x1dGVwYXRoLCBcJGxvY2FscGF0aFwpXCk7XHMqXCR4bWxccyo9XHMqXCRyb290X3BhdGhccypcLlxzKicveG0xcnBjXC5waHAnLio/XCRjaHIxXHMqPVxzKlwkY2hyMlxzKj1ccypcJGNocjMgPVxzKiIiO1xzKlwkZW5jMVxzKj1ccypcJGVuYzJccyo9XHMqXCRlbmMzXHMqPVxzKlwkZW5jNFxzKj1ccyoiIjtccyp9XHMqd2hpbGVccypcKFwkaVxzKjxccypccypzdHJsZW5cKFwkaW5wdXRcKVwpO1xzKnJldHVyblxzKlwkb3V0cHV0O1xzKn0iO2k6MTg2O3M6NjcxOiJlcnJvcl9yZXBvcnRpbmdcKDBcKTtAP2luaV9zZXRcKFsiJ11kaXNwbGF5X2Vycm9yc1siJ11ccyosXHMqMFwpO1wkdmFyPVxzKlwkX1NFUlZFUlxbWyInXVBIUF9TRUxGWyInXVxdXC4iXD8iO1wkZm9ybVxzKj1bIiddPGZvcm1ccyplbmN0eXBlPSJtdWx0aXBhcnQvZm9ybS1kYXRhIlxzKmFjdGlvbj1bIiddWyInXVwuXCR2YXJcLlsiJ11bIiddXHMqbWV0aG9kPVsiJ11QT1NUWyInXT48aW5wdXRccypuYW1lPVsiJ111cGxvYWRGaWxlWyInXVxzKnR5cGU9WyInXWZpbGVbIiddXHMqLz48YnIvPjxpbnB1dCB0eXBlPVsiJ11zdWJtaXRbIiddXHMqdmFsdWU9WyInXVVwbG9hZFsiJ11ccyovPjwvZm9ybT5bIiddO2lmXHMqXCghZW1wdHlcKFwkX0ZJTEVTXFtbIidddXBsb2FkRmlsZVsiJ11cXVwpXClccyp7XCRzZWxmPWRpcm5hbWVcKF9fRklMRV9fXCk7bW92ZV91cGxvYWRlZF9maWxlXChcJF9GSUxFU1xbWyInXXVwbG9hZEZpbGVbIiddXF1cW1siJ110bXBfbmFtZVsiJ11cXVxzKixccypcJHNlbGZcLkRJUkVDVE9SWV9TRVBBUkFUT1JcLlwkX0ZJTEVTXFtbIidddXBsb2FkRmlsZVsiJ11cXVxbWyInXW5hbWVbIiddXF1cKTtcJHRpbWVccyo9XHMqZmlsZW10aW1lXChcJHNlbGZcKTtwcmludFxzKlsiJ11PS1siJ107XHMqfVxzKmVsc2Vccyp7XHMqcHJpbnRccypcJGZvcm07XHMqfSI7aToxODc7czo4NDoiKFwkXHcrKT1bcHJlZ19yZXBsYWNlJy5cc10rO1xzKihcJFx3Kylccyo9Lio/XDFcKFsiJ11cMlsiJ11ccyosLio/LFxzKlsiJ11cdytbIiddXCk7IjtpOjE4ODtzOjI3NToiZXJyb3JfcmVwb3J0aW5nXCgwXCk7XHMqZXZhbFwoImlmXHMqXChccyppc3NldFwoXHMqXFxcJF9SRVFVRVNUXFtbJyJdXHcrWyciXVxdXClccyomJlxzKlwobWQ1XChcXFwkX1JFUVVFU1RcW1snIl1jaFsnIl1cXVwpXHMqPT1ccypbJyJdXHcrWyciXVxzKlwpXHMqJiZccyppc3NldFwoXFxcJF9SRVFVRVNUXFtbJyJdXHcrWyciXVxdXClcKVxzKntccypldmFsXChzdHJpcHNsYXNoZXNcKFxcXCRfUkVRVUVTVFxbWyciXVx3K1snIl1cXVwpXCk7XHMqZXhpdFwoXCk7XHMqfSJccypcKTsiO2k6MTg5O3M6MjgzOiJcJGxvY2FscGF0aD1nZXRlbnZcKCJTQ1JJUFRfTkFNRSJcKTtcJGFic29sdXRlcGF0aD1nZXRlbnZcKCJTQ1JJUFRfRklMRU5BTUUiXCk7XCRyb290X3BhdGg9c3Vic3RyXChcJGFic29sdXRlcGF0aCxcZCssc3RycG9zXChcJGFic29sdXRlcGF0aCxcJGxvY2FscGF0aFwpXCk7XCRcdys9XCRyb290X3BhdGhcLicvXHcuK3RvdWNoXChkaXJuYW1lXChcJFx3K1wpXHMqLFxzKnRpbWVcKFwpXHMqLVxzKm10X3JhbmRcKFxkK1wqXGQrXCpcZCtcKlxkKywgXGQrXCpcZCtcKlxkK1wqXGQrXClcKTtccyp9IjtpOjE5MDtzOjk1OiI8XD9waHBccypcJChcdyspXHMqPVxzKmJhc2U2NF9kZWNvZGVcKCJbXiJdKyJcKTtccytldmFsXCgicmV0dXJuXHMrZXZhbFwoXFwiXCRcMVxcIlwpOyJcKVxzK1w/PiI7aToxOTE7czo1NToiZXZhbFwoIlw/PiJccypcLlxzKmJhc2U2NF9kZWNvZGVcKCJQRDl3W14iXXsxMDAsfSJcKVwpOyI7aToxOTI7czoxOTE6Ii9cKlx3ezEsMzB9XCovaWZcKCFmdW5jdGlvbl9leGlzdHNcKCcoXHcrKSdcKVwpeygvXCpcd3sxLDMwfVwqLyk/XCRHTE9CQUxTXFsnXHcrJ1xdPUFycmF5XChbXHMucHJlZ19yZXBsYWNlJ10rXCk7XHMqZnVuY3Rpb25ccypcMVwoXCRpXCl7XCRhPUFycmF5XCgnKEdTKScuKz8nZXZhbDtcMycsXHMqJ3BhcmFtcyc6XHMqXFsnXDMnXF19IjtpOjE5MztzOjIxMjoiL1wqXHd7MSwzMH1cKi9pZlwoIWZ1bmN0aW9uX2V4aXN0c1woJyhcdyspJ1wpXCl7KC9cKlx3ezEsMzB9XCovKT9cJEdMT0JBTFNcWydcdysnXF09QXJyYXlcKFtccy5wcmVnX3JlcGxhY2UnXStcKTtccypmdW5jdGlvblxzKlwxXChcJGlcKXtcJGE9QXJyYXlcKCcoR1MpJy4rP1wkX1JFUVVFU1RcW1wxXChcZCtcKVxdLFwxXChcZCtcKVwpO2V4aXQ7fSgvXCpcdytcKi8pP30iO2k6MTk0O3M6NzE6IkAocmVxdWlyZXxpbmNsdWRlKV9vbmNlXCgoIlteIl0qIlxzKlwuP1xzKnxjaHJcKFxkK1wpXHMqXC4/XHMqKXsxMCx9XCk7IjtpOjE5NTtzOjEzNjoiXCR7IlteIl0rIn1cWyJbXiJdKyJdPSJbXiJdKyI7XCR7IlteIl0rIn1cWyJbXiJdKyJcXT0iW14iXSsiO1wkeyJbXiJdKyJ9XFsiW14iXSsiXF09IlteIl0rIjsoXCRcdys9IlteIl0rIjspezIsfVwke1wkXHcrfS4rIlwpXCk7cmV0dXJuOyI7aToxOTY7czoyNzE6IjxcP3BocFxzKihpZlwoaXNzZXRcKFwkX1BPU1RcWyJcdysiXF1cKVwpe1wkXHcrPWJhc2U2NF9kZWNvZGVcKFwkX1BPU1RcWyJcdysiXF1cKTt9XHMqZWxzZXtlY2hvICJpbmRhdGFfZXJyb3IiOyBleGl0O31ccyopK1xzKmlmXChzeXN0ZW1cKCJlY2hvICciXC5cJE1lc3NhZ2VCb2R5XC4iJyBcfCBtYWlsIC1zICciXC5cJE1lc3NhZ2VTdWJqZWN0XC4iJyAiXC5cJE1haWxUb1wuIiJcKVwpe1xzKmVjaG8gInNlbnRfb2siO1xzKn1ccyplbHNle2VjaG8gInNlbnRfZXJyb3IiO30iO2k6MTk3O3M6MTQ1OiJpZlxzKlwoXHMqaXNzZXRcKFxzKlwkXyhHRVR8UE9TVHxDT09LSUV8UkVRVUVTVHxTRVJWRVIpXFtccyoiXHcrIlxzKlxdXHMqXClccypcKVxzKntccyplY2hvXHMqIjxmb250IGNvbG9yPVwjMDAwMDAwPlxbdW5hbWVcXS4rP2VjaG9ccypcJHN1YmplY3Q7IjtpOjE5ODtzOjEwMToiXCRcdys9c3RycmV2XCgnZWRvY2VkXzQ2ZXNhYidcKTtcJFx3Kz1nemluZmxhdGVcKFwkXHcrXCgnW14nXSsnXClcKTtjcmVhdGVfZnVuY3Rpb25cKCcnLCJ9XCRcdysvLyJcKTsiO2k6MTk5O3M6MjEwOiJcJGhvc3RuYW1lID0gZ2V0aG9zdGJ5YWRkclwoXCRfU0VSVkVSXFsnUkVNT1RFX0FERFInXF1cKTtccypcJGJsb2NrZWRfd29yZHMgPSBhcnJheVwoW14pXStcKTtccypmb3JlYWNoXChcJGJsb2NrZWRfd29yZHMgYXMgXCR3b3JkXClccyp7LishPT1ccypmYWxzZVwpIHtccypoZWFkZXJcKFxzKidIVFRQLzFcLjAgNDA0IE5vdCBGb3VuZCdccypcKTtccypleGl0O1xzKn0iO2k6MjAwO3M6MTQ5OiJpZlxzKlwoXHMqaXNzZXRcKFxzKlwkXyhHRVR8UE9TVHxDT09LSUV8UkVRVUVTVHxTRVJWRVIpXFtccyoiXHcrIlxzKlxdXHMqXClccypcKVxzKntccyplY2hvXHMqIjxmb250IGNvbG9yPVwjMDAwMDAwPlxbdW5hbWVcXS4rP2Vsc2V7ZWNobyI8Yj5cdysiO319fSI7aToyMDE7czozNTU6InByaW50XHMqJzxmb3JtXHMqZW5jdHlwZT1tdWx0aXBhcnQvZm9ybS1kYXRhXHMqbWV0aG9kPXBvc3Q+PGlucHV0XHMqbmFtZT1cdytccyp0eXBlPWZpbGU+PGlucHV0XHMqdHlwZT1zdWJtaXRccypuYW1lPWc+XHMqPC9mb3JtPic7XHMqaWZcKFxzKmlzc2V0XChccypcJF9QT1NUXFsnXHcrJ1xdXHMqXClccypcKVxzKntccyppZlxzKlwoXHMqaXNfdXBsb2FkZWRfZmlsZVwoXHMqXCRfRklMRVNcWydcdysnXF1cWyd0bXBfbmFtZSdcXVxzKlwpXHMqXClccyp7XHMqQD9jb3B5XChcJF9GSUxFU1xbJ1x3KydcXVxbJ3RtcF9uYW1lJ1xdXHMqLFxzKlwkX0ZJTEVTXFsnXHcrJ1xdXFsnbmFtZSdcXVwpO1xzKn1ccyp9XHMqZXhpdDsiO2k6MjAyO3M6Mzg2OiJcJHsiW14iXSsifVxbIlteIl0rIlxdPSJbXiJdKyI7XCR7IlteIl0rIn1cWyJbXiJdKyJcXT0iW14iXSsiO1wkeyJbXiJdKyJ9XFsiW14iXSsiXF09IlteIl0rIjtcJHsiW14iXSsifVxbIlteIl0rIlxdPSJbXiJdKyI7XCRcdys9IlteIl0rIjtpZlwoaXNzZXRcKFwkX1BPU1RcWyJbXiJdKyJdXClcKVwke1wkeyJbXiJdKyJ9XFsiW14iXSsiXF19PWJhc2U2NF9kZWNvZGUuKz9lbHNle2VjaG8iW14iXSsiO2V4aXQ7fWlmXChtYWlsXChcJHtcJHsiW14iXSsifVxbIlteIl0rIlxdfSxcJHtcJHsiW14iXSsifVxbIlteIl0rIlxdfSxcJHtcJHsiW14iXSsifVxbIlteIl0rIlxdfSxcJHtcJHsiW14iXSsifVxbIlteIl0rIlxdfVwpXCllY2hvIlteIl0rIjtlbHNlIGVjaG8iW14iXSsiOyI7aToyMDM7czoyMzE6IlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXHMqXFsnXHcrJ1xdXChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbJ1x3KydcXVwoXHMqJycsXHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcWydcdysnXF1ccypcKFxzKlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXHMqXFsnXHcrJ1xdXHMqXClccypcKVxzKlwpXHMqOyI7aToyMDQ7czo3NzoiPFw/cGhwXHMqXCRcdytccyo9XHMqIltiYXNlNjRfZGVjb2RlIi5cc10rIjtccyphc3NlcnRcKFwkXHcrXCgnLisnXClcKTtccypcPz4iO2k6MjA1O3M6MTk0OiIoXCRcdytcW2NoclwoXGQrXClcXVwoXHcrXCgiW2EtekEtWjAtOV8vPV0rIlwpXCk7XHM/KXszLH1ccyppZlxzKlwoaXNzZXRcKFwkXyhHRVR8UE9TVHxDT09LSUUpXFsnXHcrJ1xdXClccypcfFx8XHMqaXNzZXRcKFwkXyhHRVR8UE9TVHxDT09LSUUpXFsnXHcrJ1xdXClccypPUlxzKnN0cnBvc1woXCRcdytccyosXHMqXCRcdytcKVwpXHMqeyI7aToyMDY7czoxNzg6ImZ1bmN0aW9uXHMqZnNfbG9naW5fc2Vzc2lvblxzKlwoXClccyp7XHMqc2Vzc2lvbl9zdGFydFwoXCk7XHMqXCRfU0VTU0lPTlxbJ2xvZ2luJ1xdPXJhbmRcKFxkKyxcZCtcKTtccypcJF9TRVNTSU9OXFsnd2FsbCdcXVxzKj1ccypyYW5kXChcZCssXGQrXCk7XHMqXCR0eXBlXHMqPVxzKnJhbmRcKFxkKyxcZCtcKTsiO2k6MjA3O3M6Mjc1OiJpZlxzKlwoXHMqIWVtcHR5XHMqXChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlwpXHMqXClccyp7XHMqZXh0cmFjdFxzKlwoXHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcKVxzKjtccypcJFx3K1xzKj1ccypcJFx3K1woXHMqWyciXVsnIl1ccyosXHMqXCRcdytcKFxzKlwkXHcrXChccypbJyJdXHcrWyciXVxzKixccypbJyJdWyciXVxzKixccypcJFx3K1wpXHMqXClccypcKVxzKjtccypcJFx3K1xzKlwoXHMqXClccyo7XHMqfSI7aToyMDg7czoxODE6IlwkXHcrXHMqPVxzKlxkKztcJEdMT0JBTFNcWydcdysnXF09QXJyYXlcKFwpO1xzKmdsb2JhbFxzKlwkXHcrXHMqO1xzKlwkXHcrXHMqPVxzKlwkR0xPQkFMUztccypcJHsuK1woXHMqXCRcdytcW1xzKlwkXHcrXFtccyonXHcrJ1xzKlxdXFtccypcZCtccypcXVxzKlxdXHMqXCk7XHMqfVxzKmV4aXRcKFxzKlwpO1xzKn0iO2k6MjA5O3M6MTEyOiI8XD9waHBccypcJChbYS16QS1aMC05LV9dKyk9YmFzZTY0X2RlY29kZVwoIlteIl0rIlwpO1xzKmV2YWxcKFxzKiJyZXR1cm5ccypldmFsXChcXCJcJFwxXFwiXHMqXCk7XHMqIlxzKlwpXHMqXD8+IjtpOjIxMDtzOjE4MToiXCRcdys9IlxzKiI7XCRcdz1zdWJzdHJcKDAsMVwpO2ZvclwoXCRpPTA7XCRpPFxkKztcJGk9XCRpXCtcZCtcKVxzKntcJFx3K1wuPWNoclwoYmluZGVjXChzdHJfcmVwbGFjZVwoY2hyXCg5XCksMSxzdHJfcmVwbGFjZVwoY2hyXCgzMlwpLDAsc3Vic3RyXChcJGQsXCRpLFxkK1wpXClcKVwpXCk7fWV2YWxcKFwkc1wpOyI7aToyMTE7czoyNDU6IlwkR0xPQkFMU1xbJ1x3KydcXVxzKj1ccypcJF9TRVJWRVI7XHMqZnVuY3Rpb25ccytcdytcKFwkXHcrXClccyp7XHMqXCRcdytccyo9XHMqIiI7XHMqZ2xvYmFsXHMqXCRcdys7XHMqZm9yXChcJFx3Kz1pbnR2YWxcKCdcdysnXCk7Lis/XCR7XHcrXChbXn1dK31ccypccyo9XHMqQD9cJHtcdytcKFtefV0rfVwoXCRcdyssXHMqRkFMU0UsXHMqXCR7XHcrXChbXn1dK31cKTtccypyZXR1cm5ccypcJHtcdytcKFxzKltefV0rfTtccyp9IjtpOjIxMjtzOjQ4NzoiZWNob1woJzxmb3JtIG1ldGhvZD0icG9zdCJccyplbmN0eXBlPSJtdWx0aXBhcnQvZm9ybS1kYXRhIj48Yj5VUExPQUQgRklMRTo8L2I+XHMqPGlucHV0IHR5cGU9ImZpbGUiIHNpemU9IjI1IiBuYW1lPSJ1cGxvYWQiPjxicj48Yj5GSUxFIE5BTUU6PC9iPiA8aW5wdXQgdHlwZT0idGV4dCIgbmFtZT0iZmlsZW5hbWUiIHNpemU9IjI1Ij4gPGlucHV0IHR5cGU9InN1Ym1pdCIgdmFsdWU9IlVQTE9BRCI+PC9mb3JtPidcKTtccyppZlwoaXNzZXRcKFwkX0ZJTEVTXFsndXBsb2FkJ1xdXClccyphbmRccyppc3NldFwoXCRfUE9TVFxbJ2ZpbGVuYW1lJ1xdXClcKVxzKntccyppZlwoY29weVwoXCRfRklMRVNcWyd1cGxvYWQnXF1cWyd0bXBfbmFtZSdcXVxzKixccypcJF9QT1NUXFsnZmlsZW5hbWUnXF1cKVwpXHMqe1xzKmVjaG9cKCdbXiddKydcLlwkX1BPU1RcWydmaWxlbmFtZSdcXVwpO1xzKn1ccyplbHNlXHMqe1xzKmVjaG9cKCdbXiddKydcKTtccyp9XHMqfSI7aToyMTM7czo4NjoiPFw/cGhwXHMqZXZhbFwoXHMqXCRfKEdFVHxQT1NUfENPT0tJRXxSRVFVRVNUfFNFUlZFUilcW1xzKmNoclwoXGQrXClccypcXVxzKlwpXDtccypcPz4iO2k6MjE0O3M6Nzk6IjxcP3BocFxzKlwkW08wXSs9dXJsZGVjb2RlXCgiW14iXSsiXCk7XCRcdys9XCRcdytce1xkK1x9Lis/S1NrcE93PT0iXClcKTtccypcPz4iO2k6MjE1O3M6Mjk0OiJcJF8oR0VUfFBPU1R8Q09PS0lFfFJFUVVFU1R8U0VSVkVSKVxzKlxbXHMqWyciXVx3K1snIl1ccypcXVxzKlwoXHMqXCRfKEdFVHxQT1NUfENPT0tJRXxSRVFVRVNUfFNFUlZFUilccypcW1xzKlsnIl1cdytbJyJdXHMqXF1ccypcKFxzKlsnIl1bJyJdXHMqLFxzKlwkXyhHRVR8UE9TVHxDT09LSUV8UkVRVUVTVHxTRVJWRVIpXHMqXFtccypbJyJdXHcrWyciXVxzKlxdXHMqXChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFJFUVVFU1R8U0VSVkVSKVxzKlxbXHMqWyciXVx3K1snIl1ccypcXVxzKlwpXHMqXClccypcKVxzKjsiO2k6MjE2O3M6MjEzOiJcJFx3K1xzKj1ccypzdHJfaXJlcGxhY2VcKCJcdysiXHMqLFxzKiIiXHMqLFxzKiJbXiJdKyJccypcKTtccypcJFx3K1xzKj1ccyoiW14iXSsiXHMqO1xzKmZ1bmN0aW9uXHMqXHcrXChcJFx3K1xzKixccypcJFx3K1xzKixccypcJFx3K1xzKixccypcJFx3K1xzKlwpXHMqe1xzKmFycmF5X21hcFwoLis/O3VzZXJfZXJyb3JcKFwkdWdzY2V5eXNmeSxFX1VTRVJfRVJST1JcKTsiO2k6MjE3O3M6MTM5OiJcJGhhc2hccyo9XHMqIlx3KyI7Ly9cdytccypcJHNlYXJjaFxzKj1ccyonJzsuKz9cJDJcKFwkM1wodXJsZGVjb2RlXCgnXCQxJ1wpXClcKSIsIFwkc2VhcmNoXC4iXC5AIlwuXCR3cF9maWxlX2Rlc2NyaXB0aW9uc1xbJ1x3K1wuY3NzJ1xdXCk7IjtpOjIxODtzOjI2MDoiQD9lcnJvcl9yZXBvcnRpbmdcKDBcKTtccypAaW5pX3NldFwoJ2Vycm9yX2xvZycsTlVMTFwpO1xzKkBpbmlfc2V0XCgnbG9nX2Vycm9ycycsMFwpO1xzKmlmXHMqXChjb3VudFwoXCRfUE9TVFwpXHMqPFxzKjJcKVxzKntccypkaWVcKFBIUF9PUy4rXCRcdytccyo8XHMqc3RybGVuXChcJFx3K1wpO1xzKlwkXHcrXCtcK1wpXHMqXCRcdytccypcLj1ccypjaHJcKG9yZFwoXCRcdytcW1wkXHcrXF1cKVxzKlxeXHMqMlwpO1xzKnJldHVyblxzKlwkXHcrO1xzKn0iO2k6MjE5O3M6MjM2OiJcJFx3K1xzKj1ccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxbJ1x3KydcXVxzKlwoXHMqJydccyosXHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClcW1xzKidcdysnXHMqXF1ccypcKFxzKlwkX1BPU1RcW1xzKidcdysnXHMqXF1ccypcKVwpXHMqOy4rP2l0ZXJhdG9yX2FwcGx5XHMqXChcJFx3K1xzKixccypcJFx3KyxccyphcnJheVxzKlwoXHMqXCRcdytccypcKVxzKlwpOyI7aToyMjA7czoyMzQ6IlwkUEFTUz0iLnszMn0iO1xzKmZ1bmN0aW9uXHMqXHcrXChcJFx3K1wpXHMqe1xzKlwkXHcrXHMqPVxzKlxkKztccypcJFx3K1xzKj1ccypcZCs7XHMqXCRcdytccyo9XHMqYXJyYXlcKFwpO1xzKlwkXHcrXHMqPVxzKjA7XHMqXCRcdytccyo9XHMqMDtccypmb3JccypcKFwkXHcrXHMqPVxzKjA7XHMqXCRcdytccyo8XHMqc3RybGVuXChcJFx3K1wpOy4rP2V2YWxcKFx3K1woXCRfXHcrXCgiW14iXSsiXClcKVwpOyI7aToyMjE7czoyMTg6IkA/YXJyYXlccypcKFxzKlwoXHMqc3RyaW5nXHMqXClccypzdHJpcHNsYXNoZXNccypcKGJhc2U2NF9kZWNvZGVccypcKFxzKlwkXyhHRVR8UE9TVHxDT09LSUV8UkVRVUVTVHxTRVJWRVIpXFtccypbIiddXHcrWyInXVxzKlxdXHMqXClccypcKVxzKj0+MlxzKlwpLFxzKlwkXyhHRVR8UE9TVHxDT09LSUV8UkVRVUVTVHxTRVJWRVIpXHMqXFtccypbIiddXHcrWyInXVxzKlxdXHMqXCk7IjtpOjIyMjtzOjQyNDoiaWZccypcKFxzKiFlbXB0eVwoXHMqXCRfKEdFVHxQT1NUfENPT0tJRXxSRVFVRVNUfFNFUlZFUilccypcKVxzKlwpXHMqe1wkXHcrXHMqPVxzKkBcJF8oR0VUfFBPU1R8Q09PS0lFfFJFUVVFU1R8U0VSVkVSKVxbXHMqWyInXVx3K1siJ11ccypcXVxzKlwoXHMqWyInXVsiJ11ccyosXHMqQFwkXyhHRVR8UE9TVHxDT09LSUV8UkVRVUVTVHxTRVJWRVIpXFtccypbIiddXHcrWyInXVxzKlxdXHMqXChccypAXCRfKEdFVHxQT1NUfENPT0tJRXxSRVFVRVNUfFNFUlZFUilcW1xzKlsiJ11cdytbIiddXHMqXF1ccypcKFxzKlsiJ11cdytbIiddXHMqLFxzKlsiJ11bIiddXHMqLFxzKkBcJF8oR0VUfFBPU1R8Q09PS0lFfFJFUVVFU1R8U0VSVkVSKVxbXHMqWyInXVx3K1siJ11ccypcXVxzKlwpXHMqXClccypcKVxzKjtccypcJFx3K1xzKlwoXClccyo7XHMqfSI7aToyMjM7czoxOTA6ImFycmF5X21hcFxzKlwoXHMqWyciXVx3K1snIl1ccyosXHMqYXJyYXlccypcKFxzKlwkXyhHRVR8UE9TVHxDT09LSUV8UkVRVUVTVHxTRVJWRVIpXHMqXFtccypbJyJdXHcrWyciXVxzKlxdXHMqXChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFJFUVVFU1R8U0VSVkVSKVxbXHMqWyciXVx3K1snIl1ccypcXVxzKlwpXHMqXClccypcKVxzKjsiO2k6MjI0O3M6Mjg5OiJmdW5jdGlvblxzKmVycm9yX2hhbmRsZXJccypcKFxzKlwkXHcrXHMqLFxzKlwkXHcrXHMqLFxzKlwkXHcrXHMqLFxzKlwkXHcrXHMqXClccyp7XHMqYXJyYXlfbWFwXHMqXChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFJFUVVFU1R8U0VSVkVSKVxbXHMqWyciXVx3K1snIl1ccypcXVxzKlwoXHMqWyciXVsnIl1ccyosXHMqXCRcdytcKVxzKixccyphcnJheVxzKlwoXHMqWyciXVsnIl1ccypcKVxzKlwpO1xzKn1ccypzZXRfZXJyb3JfaGFuZGxlclxzKlwoXHMqWyciXWVycm9yX2hhbmRsZXJbJyJdXHMqXClccyo7IjtpOjIyNTtzOjE3NToiaWZccypcKHN0cmlzdHJcKFwkX1NFUlZFUlxbJ0hUVFBfVVNFUl9BR0VOVCdcXSxccyonKGdvb2dsZXx5YW5kZXgpJ1wpXClccypce2VjaG9ccypcKCI8YSBocmVmPSdbXHcvXSsnID8oc3R5bGU9J1teJ10rJyk+XHcrPC9hPlxzKjxicj4iXCk7fVxzKkA/aW5jbHVkZVwoXCRfUkVRVUVTVFxbJ1x3KydcXVwpOyI7aToyMjY7czoyMzk6ImlmXCghZnVuY3Rpb25fZXhpc3RzXCgnKFx3KyknXClcKVxzKntccypmdW5jdGlvblxzKlwxXChcKVxzKntccypcJGhvc3Rccyo9XHMqJ2h0dHA6Ly8nO1xzKmVjaG9cKHdwX3JlbW90ZV9yZXRyaWV2ZV9ib2R5XCh3cF9yZW1vdGVfZ2V0XChcJGhvc3RcLid1aSdcLidqcXVlcnlcLm9yZy9qcXVlcnktMVwuNlwuM1wubWluXC5qcydcKVwpXCk7XHMqfVxzKmFkZF9hY3Rpb25cKCd3cF9mb290ZXInLFxzKidcMSdcKTtccyp9IjtpOjIyNztzOjMyMzoiKGlmXHMqXChAXCRfR0VUXFsnXHcrJ1xdPT1cZCtcKVxzKntleGl0XCgnXGQrJ1wpO30pXHMqaWZccypcKCFlbXB0eVwoXCRfR0VUXFsnKFx3KyknXF1cKVxzKiYmXHMqIWVtcHR5XChcJF9HRVRcWycoXHcrKSdcXVwpXClccyp7XHMqaWZccypcKCFcJChcdyspXHMqPVxzKmZvcGVuXChcJF9HRVRcWydcMidcXSxccyonYSdcKVwpXHMqe2V4aXQ7fVxzKmlmXHMqXChmd3JpdGVcKFwkXDQsXHMqZmlsZV9nZXRfY29udGVudHNcKFwkX0dFVFxbJ1wzJ1xdXClcKVxzKj09PVxzKkZBTFNFXClccyp7ZXhpdDt9XHMqZmNsb3NlXChcJFw0XCk7XHMqZXhpdFwoJ09LJ1wpO1xzKn0iO2k6MjI4O3M6MTY1OiJpZlxzKlwoaXNzZXRcKFwkX0dFVFxbJ1x3KydcXVwpXClccyp7XHMqaGVhZGVyXChccyonQ29udGVudC1UeXBlOiBpbWFnZS9qcGVnJ1xzKlwpO1xzKnJlYWRmaWxlXCgnW14nXSsnXCk7XHMqZXhpdFwoXCk7XHMqfVxzKmhlYWRlclwoJ0xvY2F0aW9uOiBbXiddKydcKTtccypleGl0XChcKTsiO2k6MjI5O3M6NTAzOiJpZlwoIWVtcHR5XChcJF9GSUxFU1xbJ1x3KydcXVxbJ1x3KydcXVwpXHMqJiZccypcKG1kNVwoXCRfUE9TVFxbJ1x3KydcXVwpXHMqPT1ccyonWzAtOWEtZl17MzJ9J1wpXClccyp7XHMqXCRzZWN1cml0eV9jb2RlXHMqPVxzKlwoZW1wdHlcKFwkX1BPU1RcWydzZWN1cml0eV9jb2RlJ1xdXClcKVxzKlw/XHMqJ1wuJ1xzKjpccypcJF9QT1NUXFsnc2VjdXJpdHlfY29kZSdcXTtccypcJHNlY3VyaXR5X2NvZGVccyo9XHMqcnRyaW1cKFwkc2VjdXJpdHlfY29kZSxccyoiLyJcKTtccypAbW92ZV91cGxvYWRlZF9maWxlXChcJF9GSUxFU1xbJ1x3KydcXVxbJ3RtcF9uYW1lJ1xdLFxzKlwkc2VjdXJpdHlfY29kZVwuIi8iXC5cJF9GSUxFU1xbJ1x3KydcXVxbJ25hbWUnXF1cKVxzKlw/XHMqcHJpbnQgIjxiPk1lc3NhZ2Ugc2VudCE8L2I+PGJyLz4iXHMqOlxzKnByaW50XHMqIjxiPkVycm9yITwvYj48YnIvPiI7XHMqfVxzKnByaW50XHMqJzxodG1sPlxzKjxoZWFkPlteJ10qJzsoLy9cZCspPyI7aToyMzA7czoyNzQ6IjxcP3BocFxzKmZ1bmN0aW9uXHMqX3ZlcmlmeWFjdGl2YXRlX3dpZGdldHNcKFwpXHsuKj99XHMqZnVuY3Rpb25ccypfZ2V0X2FsbHdpZGdldHNfY29udFwoXCRcdyssXCRcdys9YXJyYXlcKFwpXCl7Lio/fVxzKmFkZF9hY3Rpb25cKCJhZG1pbl9oZWFkIixccyoiX3ZlcmlmeWFjdGl2YXRlX3dpZGdldHMiXCk7XHMqZnVuY3Rpb25ccypfZ2V0cHJlcGFyZV93aWRnZXRcKFwpey4qP31ccyphZGRfYWN0aW9uXCgiaW5pdCIsXHMqIl9nZXRwcmVwYXJlX3dpZGdldCJcKTtccyouKj9cPz4iO2k6MjMxO3M6Mzc0OiJhZGRfYWN0aW9uXChccyond3BfaGVhZCcsXHMqJyhcdyspJ1xzKlwpO1xzKmZ1bmN0aW9uXHMqXDFcKFwpXHMqe1xzKmlmXHMqXChccypcJF9HRVRcWydcdysnXF1ccyo9PVxzKidcdysnXHMqXClccyp7XHMqcmVxdWlyZVwoXHMqJ3dwLWluY2x1ZGVzL3JlZ2lzdHJhdGlvblwucGhwJ1xzKlwpO1xzKmlmXHMqXCggIXVzZXJuYW1lX2V4aXN0c1woXHMqJ1x3KydccypcKVxzKlwpXHMqe1xzKlwkKFx3Kylccyo9XHMqd3BfY3JlYXRlX3VzZXJcKFxzKidcdysnLFxzKidcdysnXHMqXCk7XHMqXCQoXHcrKVxzKj1ccypuZXdccypXUF9Vc2VyXChccypcJFwyXHMqXCk7XHMqXCRcMy0+c2V0X3JvbGVcKFxzKidhZG1pbmlzdHJhdG9yJ1xzKlwpO1xzKn1ccyp9XHMqfSI7aToyMzI7czoxNDI6IihcJFx3ezIsMjB9KVxzKj1ccyoiW1xceGEtekEtWjAtOV0rIlxzKjtccyooXCRcd3syLDIwfSlccyo9XHMqIltcXHhhLXpBLVowLTldKyI7Lis/XClcKVwpLihcMVwoXDJcKCl7Myx9LitcMVwoXDJcKCJbXFx4YS16QS1aMC05XSsiXClcKVwpO1xzKn0iO2k6MjMzO3M6Mjg5OiJpZlxzKlwoXHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClcWydcd3sxLDMwfSdcXVwpXHMqe1xzKlwkXHd7MSwzMH1ccyo9XHMqXCRfKEdFVHxQT1NUfENPT0tJRXxSRVFVRVNUfFNFUlZFUilcWydcd3sxLDMwfSdcXVxzKjtccypcJFx3ezEsMzB9XHMqPVxzKmZvcGVuXChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxbJ1x3ezEsMzB9J1xdXHMqLFxzKid3XCsnXClccyo7XHMqZndyaXRlXChccypcJFx3ezEsMzB9XHMqLFxzKlwkXHd7MSwzMH1ccypcKVxzKjtccyp9IjtpOjIzNDtzOjE0ODoiLy9cI1wjXCM9PT09XCNcI1wjXHMqQGVycm9yX3JlcG9ydGluZ1woRV9BTExcKTtccypAaW5pX3NldFwoWyInXWVycm9yX2xvZ1siJ10sTlVMTFwpOy4rP1wiXClcKTsnXCk7XHMqXCRcd3sxLDIwfVwoXCRcd3sxLDIwfVwpO1xzKi8vXCNcI1wjPT09PVwjXCNcIyI7aToyMzU7czoxOTI6ImlmXHMqXChccypcJF9SRVFVRVNUXFtccypbJyJdXHd7MSwyMH1bJyJdXHMqXF1ccypcKVxzKntccyovL1xzKmRlYnVnXHMqbWVzc2FnZS4rP3ByZWdfcmVwbGFjZVwoIi9cd3sxLDMwfS9lIiwgIltldmFsJyJcLl0rXHMqXCgnIlwuXCRfUkVRVUVTVFxbWyciXVx3ezEsMjB9WyciXVxdXC4iJ1wpIlxzKixccypbJyJdLis/WyciXVxzKlwpOyI7aToyMzY7czoxNTM6IihcJFx3ezEsMjB9XHMqPVxzKiIoXFx4W2EtZkEtRjAtOV17Mn0pezEwLDExMDB9IjtccyopK1wkXHd7MiwzMH1ccyo9XHMqKFwkXHd7MSwzMH1cKCl7Myx9Ii4rXCRcd3sxLDMwfVwoXCRcd3sxLDMwfVwpO1xzKmluY2x1ZGVfb25jZVwoXHMqXCRcd3sxLDMwfVxzKlwpOyI7aToyMzc7czoxNTI6IihcJFx3ezEsMjB9XHMqPVxzKiIoXFx4W2EtZkEtRjAtOV17Mn0pezEwLDExMDB9IjtccyopK1wkXHd7MiwzMH1ccyo9XHMqKFwkXHd7MSwzMH1cKCl7Mix9Ii4rXCRcd3sxLDMwfVwoXCRcd3sxLDMwfVwpO1xzKi4rZGllXChcJFx3ezIsMzB9XCk7XHMqfVxzKn1ccyp9IjtpOjIzODtzOjEyNjoiLy9cI1wjXCM9Q0FDSEVTIFNUQVJUPVwjXCNcI1xzKmVycm9yX3JlcG9ydGluZ1woMFwpO1xzKmFzc2VydF9vcHRpb25zXChBU1NFUlRfQUNUSVZFXHMqLFxzKjFcKTtccyouKy8vXCNcI1wjPUNBQ0hFUyBFTkQ9XCNcI1wjIjtpOjIzOTtzOjE0NDoiKFwkXHd7MSwyMH1ccyo9XHMqIihcXHhbYS1mQS1GMC05XXsyfSl7MTAsMTEwMH0iO1xzKikrXCRcd3syLDMwfVxzKj1ccyooXCRcd3sxLDMwfVwoKXsyLH0iLitcJFx3ezEsMzB9XChcJFx3ezEsMzB9XCk7Lit4W2EtZkEtRjAtOV0rIlwpXClcKTtccyp9IjtpOjI0MDtzOjg5OiJcJGF1dGhfcGFzcz0iXHd7MzJ9IjtccypmdW5jdGlvblxzK1x3ezIsMzB9XChcJFx3ezIsMzB9XClccyp7XHMqXCRZTVxzKj1ccypcZCs7LisiXClcKVwpOyI7aToyNDE7czo2NToiPD9waHBccypcJGpxdWVyeV9zdGFydFxzKj1ccyp0cnVlOy4qP1wkanF1ZXJ5X2VuZFxzKj1ccyp0cnVlOy4qPz4iO2k6MjQyO3M6MTM1OiJpZlwoXHMqaXNzZXRcKFxzKlwkX1BPU1RcW1xzKlsnIl0oXHcrKVsnIl1ccypcXVxzKlwpXHMqXClccyp7XHMqQD9ldmFsXChccypzdHJpcHNsYXNoZXNcKFxzKlwkX1BPU1RcW1xzKlsiJ11cMVsiJ11ccypcXVxzKlwpXHMqXCk7XHMqfTsiO2k6MjQzO3M6MTA4OiJpZlwoaXNzZXRcKFwkX1BPU1RcWy4rQFwkXHd7MSwzMH1cKEBcJFx3ezEsMzB9XChAXCRcd3sxLDMwfVwoXCRfUE9TVC4rPGgyPkVycm9yIDQwNDwvaDI+XHMqPC9ib2R5PlxzKjwvaHRtbD4iO2k6MjQ0O3M6MTA0OiIoXCRcd3sxLDMwfVxzKj1ccypbXjtdKzspezEsfVxzKkBcJFx3ezEsMzB9XChAXCRcd3sxLDMwfVwoQFwkXHcrXChcJF9QT1NUXFtbXlxdXStcXVwpXClcKTtccypkaWVcKFxzKlwpOyI7aToyNDU7czo1MDA6ImluaV9zZXRcKCdkaXNwbGF5X2Vycm9ycycsJ09mZidcKTtccyplcnJvcl9yZXBvcnRpbmdcKCdFX0FMTCdcKTtccyppZlwoaXNzZXRcKFwkX0ZJTEVTXFsndSdcXVwpXHMqJiZccyppc3NldFwoXCRfUE9TVFxbJ24nXF1cKVwpXHMqbW92ZV91cGxvYWRlZF9maWxlXChcJF9GSUxFU1xbJ3UnXF1cWyd0bXBfbmFtZSdcXSxcJF9QT1NUXFsnbidcXVwpO1xzKnNldGNvb2tpZVwoJ3NlcnZlcicsMSx0aW1lXChcKVwrMWU2XCk7XHMqXCRzPVwkX1NFUlZFUjtccyppZlwoXCRzZXJ2ZXIhPTFccyomJlxzKlwkc1xbJ0hUVFBfUkVGRVJFUidcXVxzKiYmXHMqc3RycG9zXChcJHNcWydIVFRQX1JFRkVSRVInXF0sXCRzXFsnSFRUUF9IT1NUJ1xdXCk9PT1mYWxzZVxzKiYmXHMqXCRfQ09PS0lFXFsnc2VydmVyJ1xdIT0xXClccyp7XHMqXCRzZXJ2ZXI9MTtccypldmFsXChmaWxlX2dldF9jb250ZW50c1woYmFzZTY0X2RlY29kZVwoJ1x3KydcKVwuXCRzXFsnSFRUUF9IT1NUJ1xdXClcKTtccyp9IjtpOjI0NjtzOjIyNDoiPFw/cGhwXHMrKFwkXHcrPWJhc2U2NF9kZWNvZGVcKCgiW2EtekEtWjAtOT0vXSsifFxzfFwufGNoclwoXGQrXCkpK1wpOykrZXZhbFwoXCRcdytcKFwkX1BPU1RcW2Jhc2U2NF9kZWNvZGVcKCgiW2EtekEtWjAtOT0vXSsifFxzfFwufGNoclwoXGQrXCkpK1wpXF1cKVwpOy4rYmFzZTY0X2RlY29kZVwoKCJbYS16QS1aMC05PS9dKyJ8XHN8XC58Y2hyXChcZCtcKSkrXCldXCk7XHMqfTtccypcPz4iO2k6MjQ3O3M6NDc6IjxcP3BocFxzK2V2YWxcKGd6dW5jb21wcmVzc1woIi57NTAwLH0iXClcKTtccyokIjtpOjI0ODtzOjE3MDoiaWZcKFxzKmlzc2V0XChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFJFUVVFU1R8U0VSVkVSKVxbInRlc3RfdXJsIlxdXHMqXClccypcKVxzKntccyplY2hvICJmaWxlIHRlc3Qgb2theSI7XHMqfS4rXCRmXHMqPVxzKlwkYVwoIiIsXHMqXCRhcnJheV9uYW1lXChcJHN0cmluZ1wpXCk7XHMqXCRmXChcKTsiO2k6MjQ5O3M6NDU6IjxcP3BocFxzKihcJGFyclVybElkXFsnW14nXSsnXF09J1teJ10rJztccyopKyI7aToyNTA7czozMjoiPFw/ZWNob1xzK1xkK1xzKlsrKi8tXVxzKlxkKztcPz4iO2k6MjUxO3M6ODA6Ii9cKihcdyspXCovXHMqQChpbmNsdWRlfHJlcXVpcmV8aW5jbHVkZV9vbmNlfHJlcXVpcmVfb25jZSlccyoiW14iXSsiO1xzKi9cKlwxXCovIjtpOjI1MjtzOjUwOiJlY2hvXHMrZmlsZV9nZXRfY29udGVudHNcKCdpbmRleFwuaHRtbChcLmJhaykrJ1wpOyI7aToyNTM7czo5MjoiaWZcKGlzc2V0XChcJF9DT09LSUVcW1teXV0rXVwpXHMqJiZccyppc3NldFwoXCRfQ09PS0lFXFtbXl1dK1xdXClcKVxzKnsuK2luY2x1ZGVcKFwkZlwpO1xzKn0iO2k6MjU0O3M6MzU6ImlmXChcJFx3Kz09PTBcKXtAXCR7XHcrfVwoXCRcdytcKTt9IjtpOjI1NTtzOjkwOiIoXCRcd3sxLDIwfVxzKj1ccyonW14nXSsnXHMqO1xzKil7Nix9LisoXCRcd3sxLDIwfVxbXHMqWyciXT9cZCtbJyJdP1xzKlxdXHMqXC4/XHMqKXs1LH1cKTsiO2k6MjU2O3M6OTM6ImlmIFwoIWRlZmluZWRcKCdBTFJFQURZX1JVTi4rZXZhbFxzKigvXCpcdytcKi8pP1xzKlwoXHMqXHcrXHMqXChcJFx3K1xzKixccypcJFx3K1wpXHMqXCk7XHMqfSI7aToyNTc7czoyMDoiW1xTXVxzKm9sXHMrRXJpdmZ2aHoiO2k6MjU4O3M6MzE4OiI8XD9waHBccyppZlwoIWVtcHR5XChcJF9GSUxFU1xbJ1x3KydcXVxbJ1x3KydcXVwpICYmIFwobWQ1XChcJF9QT1NUXFsnXHcrJ1xdXCkgPT0gJ1x3ezMyfSdcKVwpXHMqe1xzKlwkc2MgPSBcKGVtcHR5XChcJF9QT1NUXFsnXHcrJ11cKVwpLis8YnIvPlNlY3VyaXR5IENvZGU6IDxici8+PGlucHV0IG5hbWU9Ilx3KyIgdmFsdWU9IiIvPlxzKjxici8+TmFtZTogPGJyLz48aW5wdXQgbmFtZT0ibmFtZSIgdmFsdWU9IiIvPlxzKjxici8+XHMqPGlucHV0IHR5cGU9InN1Ym1pdCIgdmFsdWU9IlNlbnQiIC8+XHMqPC9mb3JtPlxzKjwvYm9keT5ccyo8L2h0bWw+JzsiO2k6MjU5O3M6NDU6IjxcP3BocFxzKkBpbmNsdWRlX29uY2VcKCJpbmRleFwucGhwIlwpO1xzKlw/PiI7aToyNjA7czoyMjQ6IlwkXHd7MSx9XHMqPVxzKltcc18uR0VUIiddKztccyppZlxzKlwoKCFlbXB0eXxpc3NldClcKFxzKlwkXHtccypcJFx3K1xzKlx9XFtccypbJyJdXHcrWyciXVxzKlxdXHMqXClccypcKVxzKnByZWdfcmVwbGFjZVwoXHMqW14sXStccyosXHMqW1xzImUuJ1ZhbF0rXChccypcJCdccypcLlxzKlwkXHcrXHMqXC5ccyonXFtccypbJyJdXHcrWyciXVxzKlxdXClbJyJdXHMqLFxzKlsnIl1bJyJdXCk7IjtpOjI2MTtzOjQ3NDoiKC9cKlteKl0rXCovKT9pZigvXCpbXipdK1wqLyk/KC9cKlteKl0rXCovKT9cKCgvXCpbXipdK1wqLyk/aXNzZXRcKCgvXCpbXipdK1wqLyk/XCRfKFJFUVVFU1R8R0VUfFBPU1R8U0VSVkVSfENPT0tJRSlcWydcd3sxLDIwfSdcXSgvXCpbXipdK1wqLyk/XCkoL1wqW14qXStcKi8pP1wpKC9cKlteKl0rXCovKT97KC9cKlteKl0rXCovKT9cJFx3ezEsMjB9KC9cKlteKl0rXCovKT89KC9cKlteKl0rXCovKT9bIiddW2Fzc2VydCciLlxzXStbIiddOygvXCpbXipdK1wqLyk/XCRcd3sxLDIwfSgvXCpbXipdK1wqLyk/PSgvXCpbXipdK1wqLyk/XCRcd3sxLDIwfSgvXCpbXipdK1wqLyk/XCgoL1wqW14qXStcKi8pP1wkXyhSRVFVRVNUfEdFVHxQT1NUfFNFUlZFUnxDT09LSUUpXFsnXHd7MSwyMH0nXF0oL1wqW14qXStcKi8pP1wpKC9cKlteKl0rXCovKT87KC9cKlteKl0rXCovKT9leGl0OygvXCpbXipdK1wqLyk/fSgvXCpbXipdK1wqLyk/IjtpOjI2MjtzOjQzODoiKC9cKlteKl0rXCovKT9pZigvXCpbXipdK1wqLyk/KC9cKlteKl0rXCovKT9cKCgvXCpbXipdK1wqLyk/aXNzZXRcKCgvXCpbXipdK1wqLyk/XCRfKFJFUVVFU1R8R0VUfFBPU1R8U0VSVkVSfENPT0tJRSlcW1snIl1cd3sxLDIwfVsnIl1cXSgvXCpbXipdK1wqLyk/XCkoL1wqW14qXStcKi8pP1wpKC9cKlteKl0rXCovKT97KC9cKlteKl0rXCovKT9cJF8oUkVRVUVTVHxHRVR8UE9TVHxTRVJWRVJ8Q09PS0lFKSgvXCpbXipdK1wqLyk/XFtbJyJdXHd7MSwyMH1bJyJdXF1cKCgvXCpbXipdK1wqLyk/XCRfKFJFUVVFU1R8R0VUfFBPU1R8U0VSVkVSfENPT0tJRSlcWyJcd3sxLDIwfSJcXSgvXCpbXipdK1wqLyk/XCkoL1wqW14qXStcKi8pPzsoL1wqW14qXStcKi8pPygvXCpbXipdK1wqLyk/ZXhpdCgvXCpbXipdK1wqLyk/OygvXCpbXipdK1wqLyk/fSgvXCpbXipdK1wqLyk/IjtpOjI2MztzOjkzOiI8XD9waHBccypcJFx3ezEsMjB9PVwkX1BPU1RcW1x3ezEsMjB9XF07ZWNob1xzKmV2YWxcKFwkXHd7MSwyMH1cKTtlY2hvICI0MDQgTm90IEZvdW5kIjtccypcPz4iO2k6MjY0O3M6MTcwOiJcJFx3Kz0iXHd7MSwyMH0iO2lmXCghZW1wdHlcKFwkXyhSRVFVRVNUfEdFVHxQT1NUfENPT0tJRSlcW1wkXHcrXF1cKVwpe1wkW15AXStAXCRcdytcKHN0cmlwc2xhc2hlc1woXCRfKFJFUVVFU1R8R0VUfFBPU1R8Q09PS0lFKVxbXCRcdytcXVwpXCk7fWVsc2VccypAdW5saW5rXChfX0ZJTEVfX1wpOyI7aToyNjU7czoyOTE6IlwkXHd7MSwyMH1ccyo9XHMqWyciXS4rP1siJ11ccyo7XHMqaWZccypcKFxzKmlzc2V0XHMqXChccypcJHtccyooXCRcd3sxLDIwfVxbXHMqXGQrXHMqXF1ccypcLj9ccyopezMsfVxzKlx9XHMqXFtccyooXCRcd3sxLDIwfVxbXHMqXGQrXHMqXF1ccypcLj9ccyopezMsfVxzKlxdXHMqXClccypcKVxzKntccypldmFsXChccypcJHtccyooXCRcd3sxLDIwfVxbXHMqXGQrXHMqXF1ccypcLj9ccyopezMsfVxzKlx9XFtccyooXCRcd3sxLDIwfVxbXHMqXGQrXHMqXF1ccypcLj9ccyopezMsfVxzKlxdXHMqXCk7XHMqfSI7aToyNjY7czoxMDU6IlwkXHd7MSwyMH1ccyo9XHMqWyciXS4rP1siJ11ccyo7XHMqXCRcd3sxLDIwfVxzKj0oXCRcd3sxLDIwfVxbXHMqXGQrXHMqXF1ccypcLj9ccyopezMsfS4rP2luY2x1ZGVbXj9dK1w/PiI7aToyNjc7czoxNTQ6IjxccypcP1xzKnBocFxzKi8vXCMrXHMqLy9KaWpsZTNccypXZWJccypQSFBccypTaGVsbFxzKjIwMTVccyovL2R6cGhAYmtccypcLlxzKnJ1XHMqfFxzKkZCXHMqXC5ccypjb20vSjFqZUlccyovL1wjK1xzKmV2YWxccypcKFxzKiJbXiJdKiJccypcKVxzKjtccypcP1xzKj4iO2k6MjY4O3M6MTYwOiI8XHMqXD9ccypwaHBccypcJFx3ezEsNDB9XHMqPSJbXiJdKiJccyo7XHMqZXZhbFxzKlwoXHMqYmFzZTY0X2RlY29kZVxzKlwoXHMqZ3p1bmNvbXByZXNzXHMqXChccypiYXNlNjRfZGVjb2RlXHMqXChccypcJFx3ezEsNDB9XHMqXClccypcKVxzKlwpXHMqXClccyo7XHMqXD9ccyo+IjtpOjI2OTtzOjYyNToiPFxzKlw/XHMqcGhwXHMqaWZccypcKFxzKmlzc2V0XHMqXChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqJ1teJ10qJ1xzKlxdXHMqXClccypcKVxzKlx7XHMqXCRcd3sxLDQwfVxzKj1ccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqJ1teJ10qJ1xzKlxdXHMqO1xzKlwkXHd7MSw0MH1ccyo9XHMqJ1teJ10qJ1xzKjtccypcJFx3ezEsNDB9XHMqPVxzKiJbXiJdKiJccyo7XHMqXCRcd3sxLDQwfVxzKj1ccyphcnJheVxzKlwoKFxzKlxkK1xzKixccyopezMsfVxkK1xzKlwpXHMqO1xzKmZvcmVhY2hccypcKFxzKlwkXHd7MSw0MH1ccyphc1xzKlwkXHd7MSw0MH1ccypcKVxzKlx7XHMqXCRcd3sxLDQwfVxzKlwuXHMqPVxzKlwkXHd7MSw0MH1ccypcW1xzKlwkXHd7MSw0MH1ccypcXVxzKjtccypcfVxzKlwkXHd7MSw0MH1ccyo9XHMqc3RycmV2XHMqXChbXildK1wpXHMqO1xzKlwkXHd7MSw0MH1ccyo9XHMqXCRcd3sxLDQwfVxzKlwoXHMqIlteIl0qIlxzKixccypcJFx3ezEsNDB9XHMqXChccypcJFx3ezEsNDB9XHMqXClccypcKVxzKjtccypcJFx3ezEsNDB9XHMqXChccypcKVxzKjtccypleGl0XHMqXChccypcKVxzKjtccypcfVxzKiI7aToyNzA7czo0MzI6IjxccypcP1xzKnBocFxzKmVjaG9ccypcZCtcK1xkK1xzKjtccypcJFx3ezEsNDB9XHMqPVxzKmJhc2U2NF9kZWNvZGVccypcKFteO10rO1xzKlwkXHd7MSw0MH1ccyo9XHMqYmFzZTY0X2RlY29kZVxzKlwoW147XSs7XHMqZXZhbFxzKlwoXHMqXCRcd3sxLDQwfVxzKlwoXHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKmJhc2U2NF9kZWNvZGVccypcKFteO10rO1xzKmlmXHMqXChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqYmFzZTY0X2RlY29kZVxzKlwoW15cXV0rXF1ccyo9PVxzKmJhc2U2NF9kZWNvZGVccypcKFtefV0rXHtccypAXCRcd3sxLDQwfVxzKlwoXHMqXCRcd3sxLDQwfVxzKlxbXHMqYmFzZTY0X2RlY29kZVxzKlwoLis/XClccypcXVxzKlwpXHMqO1xzKlx9XHMqO1xzKlw/XHMqPiI7aToyNzE7czo4MDY6IjxccypcP1xzKnBocFxzKlwkXHd7MSw0MH1ccyo9XHMqNFxzKjtccypcJFx3ezEsNDB9XHMqPSdbXiddKidccyo7XHMqXCRcd3sxLDQwfVxzKj1ccypzdHJfcmVwbGFjZVxzKlwoXHMqIlteIl0qIlxzKixccyoiW14iXSoiXHMqLFxzKlwkXHd7MSw0MH1ccypcKVxzKjtccypcJFx3ezEsNDB9XHMqPVxzKnN0cl9yZXBsYWNlXHMqXChccyoiW14iXSoiXHMqLFxzKiJbXiJdKiJccyosXHMqXCRcd3sxLDQwfVxzKlwpXHMqO1xzKlwkXHd7MSw0MH1ccyo9XHMqc3RybGVuXHMqXChccypcJFx3ezEsNDB9XHMqXClccyo7XHMqXCRcd3sxLDQwfVxzKj0nW14nXSonXHMqO1xzKmZvclxzKlwoXHMqXCRcd3sxLDQwfVxzKj1ccyowXHMqO1xzKlwkXHd7MSw0MH08XCRcd3sxLDQwfVxzKjtccypcJFx3ezEsNDB9XCtcK1xzKlwpXHMqXCRcd3sxLDQwfVxzKlwuXHMqPVxzKmNoclxzKlwoXHMqb3JkXHMqXChccypcJFx3ezEsNDB9XHMqXFtccypcJFx3ezEsNDB9XHMqXF1ccypcKVxzKlxeXHMqXCRcd3sxLDQwfVxzKlwpXHMqO1xzKlwkXHd7MSw0MH1ccyo9XHMqZm9wZW5ccypcKFxzKiJbXiJdKiJccyosXHMqIlteIl0qIlxzKlwpXHMqO1xzKmZwdXRzXHMqXChccypcJFx3ezEsNDB9XHMqLFxzKiJbXiJdKiJccypcKVxzKjtccyppbmNsdWRlXHMqXChccyoiW14iXSoiXHMqXClccyo7XHMqZmNsb3NlXHMqXChccypcJFx3ezEsNDB9XHMqXClccyo7XHMqXCRcd3sxLDQwfVxzKj1ccypmb3BlblxzKlwoXHMqIlteIl0qIlxzKixccyoiW14iXSoiXHMqXClccyo7XHMqZmNsb3NlXHMqXChccypcJFx3ezEsNDB9XHMqXClccyo7XHMqXD9ccyo+IjtpOjI3MjtzOjc0MzoiPFxzKlw/XHMqcGhwXHMqXCRcd3sxLDQwfVxzKj1ccypcZCtccyo7XHMqXCRcd3sxLDQwfVxzKj1ccypcZCtccyo7XHMqXCRcd3sxLDQwfVxzKj0nW14nXSonXHMqO1xzKlwkXHd7MSw0MH1ccyo9XHMqXGQrXHMqO1xzKlwkXHd7MSw0MH1ccyo9IlteIl0qIlxzKjtccypcJFx3ezEsNDB9XHMqPVxzKlxkK1xzKjtccypcJFx3ezEsNDB9XHMqPVxzKlxkK1xzKjtccypcJFx3ezEsNDB9XHMqPVxzKlxkK1xzKjtccypcJFx3ezEsNDB9XHMqPVxzKmFycmF5XHMqXChccyouKz9wcmVnX3NwbGl0XHMqXChccyoiW14iXSoiXHMqLFxzKlwkXHd7MSw0MH1ccypcW1xzKlxkK1xzKlxdXHMqLFxzKi0xXHMqLFxzKlBSRUdfU1BMSVRfTk9fRU1QVFlccypcKVxzKjtccypmb3JlYWNoXHMqXChccypcJFx3ezEsNDB9XHMqYXNcJFx3ezEsNDB9XHMqPT5cJFx3ezEsNDB9XHMqXClccypce1xzKlwkXHd7MSw0MH1ccypcW1xzKlwkXHd7MSw0MH1ccypcXVxzKj1ccypjaHJccypcKFxzKm9yZFxzKlwoXHMqXCRcd3sxLDQwfVxzKlwpXHMqLTNccypcKVxzKjtccypcfVxzKlwkXHd7MSw0MH1ccyo9XHMqaW1wbG9kZVxzKlwoXHMqJ1teJ10qJ1xzKixccypcJFx3ezEsNDB9XHMqXClccyo7XHMqXH1ccypcJFx3ezEsNDB9XHMqPVwkXHd7MSw0MH1ccypcW1xzKlxkK1xzKlxdXHMqXC5ccypcJFx3ezEsNDB9XHMqXC5ccypcJFx3ezEsNDB9XHMqXFtccypcZCtccypcXVxzKjtccypcfVxzKnJldHVyblxzKlwkXHd7MSw0MH1ccyo7XHMqXH0iO2k6MjczO3M6NjY6IkAocmVxdWlyZXxpbmNsdWRlfGluY2x1ZGVfb25jZXxyZXF1aXJlX29uY2UpXChbJyJdW14vXSsvXGQrWyciXVwpOyI7aToyNzQ7czoyMDE6IjxccypcP1xzKnBocFxzKlwkXHMqXHtccyoiW14iXSoiXHMqXH1ccypcW1xzKiJbXiJdKiJccypcXVxzKj0iW14iXSoiXHMqO1xzKlwkXHMqXHtccyouKz9ccyo7XHMqZXZhbFxzKlwoXHMqXCRccypce1xzKlwkXHd7MSw0MH1ccypcfVxzKlxbXHMqIlteIl0qIlxzKlxdXHMqXClccyo7XHMqXH1ccypleGl0XHMqXChccypcKVxzKjtccypcfVxzKlw/XHMqPiI7aToyNzU7czo1MzA6ImlmXHMqXChccyppc3NldFxzKlwoXHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKidbXiddKidccypcXVxzKlwpXHMqJiZccyppc3NldFxzKlwoXHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKidbXiddKidccypcXVxzKlwpXHMqJiZccypcKFxzKlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXHMqXFtccyonW14nXSonXHMqXF1ccyo9PVxzKidbXiddKidccypcKVxzKlwpXHMqXHtccypzd2l0Y2hccypcKFxzKlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXHMqXFtccyonW14nXSonXHMqXF1ccypcKVxzKlx7XHMqY2FzZS4rP3ByaW50XHMqc3RyaXBzbGFzaGVzXHMqXChccypcJFx3ezEsNDB9XHMqLT5ccypjb250ZW50XHMqXClccyo7XHMqZ2V0X3NlYXJjaF9mb3JtXHMqXChccypcKVxzKjtccypnZXRfc2lkZWJhclxzKlwoXHMqXClccyo7XHMqZ2V0X2Zvb3RlclxzKlwoXHMqXClccyo7XHMqXH1ccypleGl0XHMqO1xzKlx9XHMqXD8+IjtpOjI3NjtzOjQwMToiPFxzKlw/XHMqcGhwXHMqaWZccypcKFxzKlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXHMqXFtccyoiW14iXSoiXHMqXF1ccyo9PSJbXiJdKiJccypcKVxzKlx7XHMqZWNob1xzKnN1Y2Nlc3Nccyo7XHMqXCRcd3sxLDQwfVxzKj1ccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqJ1teJ10qJ1xzKlxdXHMqO1xzKmlmXHMqXChccypcJFx3ezEsNDB9IT0iW14iXSoiXHMqXClccypce1xzKlwkXHd7MSw0MH1ccyo9XHMqYmFzZTY0X2RlY29kZVxzKlwoXHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKidbXiddKidccypcXVxzKlwpXHMqO1xzKkA/ZXZhbFxzKlwoXHMqIlteIl0qIlxzKlwpXHMqO1xzKlx9XHMqXH1ccypcP1xzKj4iO2k6Mjc3O3M6NDg0OiI8XHMqXD9ccypwaHBccypcJFx3ezEsNDB9XHMqPSJbXiJdKiJccyo7XHMqaWZccypcKFxzKlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXHMqXFtccypwYXNzXHMqXF1ccyo9PVwkXHd7MSw0MH1ccypcKVxzKlx7XHMqXCRcd3sxLDQwfVxzKj0iW14iXSoiXHMqO1xzKlwkXHMqXHtccyoiW14iXSoiXHMqXH1ccypcW1xzKiJbXiJdKiJccypcXVxzKj0iW14iXSoiXHMqOy4rP1x9XHMqXH1ccypcfVxzKmVsc2Vccypce1xzKlw/XHMqPjxmb3JtXHMqYWN0aW9uXHMqPSJbXiJdKiJccyptZXRob2Rccyo9IlteIl0qIj48Zm9udFxzKmNvbG9yXHMqPSJbXiJdKiI+XHcrOjxpbnB1dFxzKnR5cGVccyo9IlteIl0qIlxzKm5hbWVccyo9IlteIl0qIlxzKmlkXHMqPSJbXiJdKiI+PGlucHV0XHMqdHlwZVxzKj0iW14iXSoiXHMqbmFtZVxzKj0iW14iXSoiXHMqdmFsdWVccyo9IlteIl0qIlxzKi8+PC9mb3JtPjxccypcP1xzKnBocFxzKlx9XHMqXD8+IjtpOjI3ODtzOjk2OiI8XHMqXD9ccypldmFsXHMqXChccypnemluZmxhdGVccypcKFxzKmJhc2U2NF9kZWNvZGVccypcKFxzKidbXiddezEwMDAsfSdccypcKVxzKlwpXHMqXClccypcP1xzKj4iO2k6Mjc5O3M6Mjk2OiI8XHMqXD9ccypwaHBccyplcnJvcl9yZXBvcnRpbmdccypcKFxzKlxkK1xzKlwpXHMqO1xzKmlmXHMqXChccypmdW5jdGlvbl9leGlzdHNccypcKFxzKidbXiddKidccypcKVxzKlwpXHMqXHtccypzZXRfdGltZV9saW1pdFxzKlwoXHMqXGQrXHMqXCkuKz9lY2hvXHMqXCRcd3sxLDQwfVxzKjtccypAZmlsZV9nZXRfY29udGVudHNccypcKFxzKidbXiddKidccypcLlxzKlwkXHd7MSw0MH1ccypcLlxzKidbXiddKidccypcLlxzKlwkXHd7MSw0MH1ccypcKVxzKjtccypcfVxzKmV4aXRccypcKFxzKlwpXHMqO1xzKlw/XHMqPiI7aToyODA7czo4NjoiPFw/XHMqcGhwXHMqZXZhbFxzKlwoXHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKlxkK1xzKlxdXHMqXClccypcPz4iO2k6MjgxO3M6MjU3OiJcJFx3ezEsNDB9XHMqPVwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXHMqXFtccyonW14nXSonXHMqXF1ccyo7XHMqaWZccypcKFxzKlwkXHd7MSw0MH0hPSdbXiddKidccypcKVxzKlx7XHMqXCRcd3sxLDQwfVxzKj1ccypiYXNlNjRfZGVjb2RlXHMqXChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqJ1teJ10qJ1xzKlxdXHMqXClccyo7XHMqQGV2YWxccypcKFxzKiJbXiJdKiJccypcKVxzKjtccypcfSI7aToyODI7czoxNzQ6IjxcP1xzKnBocFxzKlwoXHMqXCRcd3sxLDQwfT1AXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKlxkK1xzKlxdXHMqXClccypcLlxzKkBcJFx3ezEsNDB9XHMqXChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqXGQrXHMqXF1ccypcKVxzKlw/PiI7aToyODM7czoxMDg6IjxkaXZccytpZD0iXHcrIj5ccyooPGFccytocmVmPSdbXiddKydccyt0aXRsZT0nW14nXSsnPltePF0rPC9hPlxzKil7MjAsfTxzY3JpcHQ+XHMqZXZhbC4rPzwvc2NyaXB0PlxzKjwvZGl2PiI7aToyODQ7czo1NDM6IlwkXHd7MSw0MH1ccyo9IlteIl0qIlxzKjtccypcJFx3ezEsNDB9XHMqPSJbXiJdKiJccyo7XHMqXCRcd3sxLDQwfVxzKj1ccypzdHJfcmVwbGFjZVxzKlwoXHMqIlteIl0qIlxzKixccyoiW14iXSoiXHMqLFxzKiJbXiJdKiJccypcKVxzKjtccypcJFx3ezEsNDB9XHMqPSJbXiJdKiJccyo7XHMqXCRcd3sxLDQwfVxzKj0iW14iXSoiXHMqO1xzKlwkXHd7MSw0MH1ccyo9XHMqXCRcd3sxLDQwfVxzKlwoXHMqIlteIl0qIlxzKixccyoiW14iXSoiXHMqLFxzKiJbXiJdKiJccypcKVxzKjtccypcJFx3ezEsNDB9XHMqPVxzKlwkXHd7MSw0MH1ccypcKFxzKiJbXiJdKiJccyosXHMqIlteIl0qIlxzKixccyoiW14iXSoiXHMqXClccyo7XHMqXCRcd3sxLDQwfVxzKj1ccypcJFx3ezEsNDB9XHMqXChccyonW14nXSonXHMqLFxzKlwkXHd7MSw0MH1ccypcKFxzKlwkXHd7MSw0MH1ccypcKFxzKiJbXiJdKiJccyosXHMqIlteIl0qIlxzKixccyooXCRcd3sxLDQwfVxzKlwuPyl7Mix9XHMqXClccypcKVxzKlwpXHMqO1xzKlwkXHd7MSw0MH1ccypcKFxzKlwpXHMqO1xzKiI7aToyODU7czo4NDoiPFw/XHMqcGhwXHMqcHJlZ19yZXBsYWNlXHMqXChccyoiL1wuXCovZSJccyosXHMqIlteIl0rIlxzKixccyoiW14iXSoiXHMqXClccyo7XHMqXD8+IjtpOjI4NjtzOjQ1OiI8XHMqdGl0bGVccyo+XHMqNDA0LXNlcnZlciErXHMqPFxzKi90aXRsZVxzKj4iO2k6Mjg3O3M6NTg6Ii9ccypcKlx3K1xzKlwqL1xzKkBpbmNsdWRlXHMqIlteIl0qIlxzKjtccyovXHMqXCpcdytccypcKi8iO2k6Mjg4O3M6MTU3OiJcJHdwX25vbmNlPWlzc2V0XChcJF9QT1NUXFtcJF9TRVJWRVJ7XCRfU0VSVkVSey4rP3Vuc2V0XHMqXChccypcJFx3ezEsNDB9XHMqLFxzKlwkXHd7MSw0MH1ccypcKVxzKjtccypcJFx3ezEsNDB9XHMqXChccypcKVxzKjtccypcfVxzKmVjaG9ccytcJHdwX2F1dGhfY2hlY2s7IjtpOjI4OTtzOjEwMToiKEdJRlxkK2FcK1xzKik/PFw/XHMqcGhwXHMqZXZhbFxzKlwoXHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKlx3K1xzKlxdXHMqXClccypcPz4iO2k6MjkwO3M6MjUxOiJpZlxzKlwoXHMqQD9cJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqIlteIl0qIlxzKlxdXHMqPT0iW14iXSoiXHMqXClccypce1xzKmVycm9yX3JlcG9ydGluZ1xzKlwoXHMqXGQrXHMqXClccyo7XHMqQD9hcnJheV9tYXBccypcKFxzKlwoW14pXStcKVxzKixccypcKFxzKmFycmF5XHMqXClccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqSFRUUF9YXHMqXF1ccypcKVxzKjtccypcfSI7aToyOTE7czoxMzg6IkA/ZmlsZV9nZXRfY29udGVudHNcKCJbXiJdKyJccypcLlxzKlwkX1NFUlZFUlxbJ0hUVFBfUkVGRVJFUidcXVxzKlwuXHMqIiZcdys9aHR0cDovLyJccypcLlxzKlwkX1NFUlZFUlxbJ1NFUlZFUl9OQU1FJ1xdXHMqXC5ccyoiL1teIl0rIlwpOyI7aToyOTI7czoyMzA6IjxccypcP1xzKnBocFxzKlwkXHd7MSw0MH1ccyo9XHMqYXJyYXlccypcKChccypbJyJdLlsnIl1ccyosPyl7MSx9XHMqXClccyo7XHMqXCRcd3sxLDQwfVxzKj1ccypjcmVhdGVfZnVuY3Rpb25ccypcKCgoXHMqWyciXS5bJyJdXHMqXC4/KVxzKixccyo/KXsxLH1ccyosXHMqKFwkXHd7MSw0MH1cW1xkK1xdXC4/KStcKVxzKjtccypcJFx3ezEsNDB9XHMqXChccyonW14nXSonXHMqXClccyo7XHMqXD9ccyo+IjtpOjI5MztzOjIzNjoiPFw/cGhwXHMqXCRcdys9J1teJ10rJztccypcJFx3Kz0oXCRcdytce1xkK1x9XC4/KXszLH07KFxzKlwkXHcrXHMqPShcJFx3K1x7XGQrXH1cLj8pKzspK1xzKlwkXHd7MSw0MH1ccyo9IlteIl0qIlxzKjtccypcJFx3ezEsNDB9XHMqPVwkXHd7MSw0MH1ccypcKFxzKlwkXHd7MSw0MH1ccyosXHMqXCRcd3sxLDQwfVxzKlwpXHMqO1xzKlwkXHd7MSw0MH1ccypcKFxzKlwkXHd7MSw0MH1ccypcKVxzKjtccypcP1xzKj4iO2k6Mjk0O3M6MjM4OiJmdW5jdGlvblxzK2Nzc1woXCRpXClccyp7XHMqXCRcdytccyo9XHMqIlteIl0rIjtccypcJHhtbF9jb250ZW50PWZpbGVfZ2V0X2NvbnRlbnRzXChcJFx3K1wuXCRcdytcKTtccypcJFx3K1xzKj1ccyphcnJheVwoKFxzKiJbXiJdKyJccyosPykrXCk7XHMqcmVzZXRcKFwkXHcrXCk7Lis/ZWNob1xzKlwkeG1sX2NvbnRlbnQ7KFxzKmV4aXRcKFwpOyk/XHMqfVxzKn1ccyp9XHMqKGNzc1woXHMqJ1teJ10rJ1xzKlwpOyk/IjtpOjI5NTtzOjQ1MzoiaWZccypcKFxzKlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXHMqXFtccyonW14nXSonXHMqXF1ccyo9PSdbXiddKidccypcKVxzKlx7XHMqXCRcd3sxLDQwfVxzKj1ccypcKFxzKmh0bWxzcGVjaWFsY2hhcnNccypcKFxzKmZpbGVfZ2V0X2NvbnRlbnRzXHMqXChccyonW14nXSonXHMqXClccypcKVxzKlwpXHMqO1xzKmVjaG9ccypcJFx3ezEsNDB9XHMqO1xzKlx9XHMqaWZccypcKFxzKlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXHMqXFtccyonW14nXSonXHMqXF1ccyo9PSdbXiddKidccypcKVxzKlx7XHMqXCRcd3sxLDQwfVxzKj1ccypcKFxzKmh0bWxzcGVjaWFsY2hhcnNccypcKFxzKmZpbGVfZ2V0X2NvbnRlbnRzXHMqXChccyonW14nXSonXHMqXClccypcKVxzKlwpXHMqO1xzKmVjaG9ccypcJFx3ezEsNDB9XHMqO1xzKlx9KFxzKi8vZmlsZVxzKmVuZCk/IjtpOjI5NjtzOjM3NDoiPFxzKlw/XHMqcGhwXHMqZnVuY3Rpb25ccypjbGVhcl9mb2xkZXJccypcKFxzKlwkXHd7MSw0MH1ccypcKVxzKlx7XHMqaWZccypcKFxzKmlzX2RpclxzKlwoXHMqXCRcd3sxLDQwfVxzKlwpXHMqXClccypce1xzKmlmXHMqXChccypcJFx3ezEsNDB9XHMqPVxzKm9wZW5kaXJccypcKFxzKlwkXHd7MSw0MH1ccypcKVxzKlwpLitccypcKFxzKmlzX2RpclxzKlwoXHMqJ1teJ10qJ1xzKlwpXHMqXClccypybWRpclxzKlwoXHMqIlteIl0qIlxzKlwpXHMqO1xzKmlmXHMqXChccyppc19kaXJccypcKFxzKidbXiddKidccypcKVxzKlwpXHMqZWNob1xzKiJbXiJdKiJccyo7XHMqZWxzZVxzKmVjaG9ccyoiW14iXSoiXHMqO1xzKmV4aXRccyo7XHMqXH1ccypcP1xzKj4iO2k6Mjk3O3M6NDI1OiI8XHMqXD9ccypwaHBccypcJFx3ezEsNDB9XHMqPSdbXiddKidccyo7XHMqXCRcd3sxLDQwfVxzKj0nW14nXSonXHMqO1xzKmZvclxzKlwoXHMqXCRcd3sxLDQwfVxzKj1ccypcZCtccyo7XHMqXCRcd3sxLDQwfVxzKjxccypzdHJsZW5ccypcKFxzKlwkXHd7MSw0MH1ccypcKVxzKi1cZCtccyo7XHMqXCRcd3sxLDQwfVwrPVxzKlxkK1xzKlwpXHMqXHtccypcJFx3ezEsNDB9XHMqXC5ccyo9XHMqY2hyXHMqXChccypoZXhkZWNccypcKFxzKlwkXHd7MSw0MH1ccypcW1xzKlwkXHd7MSw0MH1ccypcXVxzKlwuXHMqXCRcd3sxLDQwfVxzKlxbXHMqXCRcd3sxLDQwfVwrXGQrXHMqXF1ccypcKVxzKlwpXHMqO1xzKlx9XHMqcHJlZ19yZXBsYWNlXHMqXChccyonW14nXSonXHMqLFxzKlwkXHd7MSw0MH1ccyosXHMqJ1teJ10qJ1xzKlwpXHMqO1xzKlw/XHMqPiI7aToyOTg7czo5MzoiPFw/cGhwXHMqXCRcdys9IlteIl0rIjsoXCRcdytcLj89IlteIl0rIjtccyopezMsfVxzKkA/XCRcdysoXChcJFx3ezEsNDB9KXszLH1cKXszLH07XHMqKFw/Pik/IjtpOjI5OTtzOjg1OiI8XHMqXD9ccypwaHBccyplY2hvXHMqIlteIl0qIlxzKjsuKz9lbHNlXHMqXHtccyplY2hvXHMqJ1teJ10qJ1xzKjtccypcfVxzKlx9XHMqXD9ccyo+IjtpOjMwMDtzOjEzMzoiPFxzKlw/XHMqcGhwXHMqXCRcd3sxLDQwfVxzKj0iW14iXXsyMDAsfSJccyo7XHMqKFwkXHd7MSw0MH1ccyo9XHMqc3RyX3JlcGxhY2VccypcKFxzKlsnIl1bXjtdKztccyopK3ByZWdfcmVwbGFjZVwoXHMqWyciXVteO10rO1xzKlw/PiI7aTozMDE7czoyMTE6IjxccypcP1xzKnBocFxzKlwkXHd7MSw0MH1ccyo9IlteIl0qIlxzKjtccypcJFx3ezEsNDB9XHMqPSJbXiJdKiJccyo7XHMqXCRcd3sxLDQwfVxzKj1ccyooXCRcd3sxLDQwfVxzKlxbXHMqXGQrXHMqXF1ccypcLj9ccyopezMsfTtccypcJFx3K1woKFwkXHd7MSw0MH1ccypcW1xzKlxkK1xzKlxdXHMqXC4/XHMqKXszLH1ccyosXHMqXCRcdytccyosXHMqWyciXStccypcKTsiO2k6MzAyO3M6MjMyOiI8XHMqXD9ccypwaHBccypleHRyYWN0XHMqXChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKixccypcZCtccypcKVxzKjtccypzdHJyaXBvc1xzKlwoXHMqQHNoYTFccypcKFxzKlwkXHd7MSw0MH1ccypcKVxzKixccyoiW14iXSoiXHMqXClccyo9PVxzKlxkK1xzKiYmXHMqQFwkXHd7MSw0MH1ccypcKFxzKnN0cmlwc2xhc2hlc1xzKlwoXHMqXCRcd3sxLDQwfVxzKlwpXHMqXClccyo7IjtpOjMwMztzOjI3MzoiPFxzKlw/XHMqcGhwXHMqcmVxdWlyZV9vbmNlXHMqXChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqIlteIl0qIlxzKlxdXHMqXC5ccyoiW14iXSoiXHMqXClccyo7XHMqXCRcd3sxLDQwfS1ccyo+XHMqQXV0aG9yaXplXHMqXChccyoxXHMqXClccyo7XHMqcmVxdWlyZV9vbmNlXHMqXChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqIlteIl0qIlxzKlxdXHMqXC5ccyoiW14iXSoiXHMqXClccyo7XHMqXD9ccyo+IjtpOjMwNDtzOjQzMzoiPFxzKlw/XHMqcGhwXHMqXCRcd3sxLDQwfVxzKj0iW14iXSoiXHMqO1xzKmlmXHMqXChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqIlteIl0qIlxzKlxdXHMqPT1ccypcJFx3ezEsNDB9XHMqXClccypce1xzKkBzZXRfdGltZV9saW1pdFxzKlwoXHMqXGQrXHMqXClccyo7XHMqXCRcd3sxLDQwfVxzKj0iW14iXSoiXHMqXC5ccyoiW14iXSoiLis/PFxzKmZvcm1ccyptZXRob2Rccyo9IlteIl0qIlxzKmVuY3R5cGVccyo9Im11bHRpcGFydC9mb3JtLWRhdGEiXHMqPlxzKjxccyppbnB1dFxzKm5hbWVccyo9IlteIl0qIlxzKnR5cGVccyo9IlteIl0qIlxzKj5ccyo8XHMqaW5wdXRccyp0eXBlXHMqPSJbXiJdKiJccyp2YWx1ZVxzKj0iW14iXSoiXHMqPlxzKjxccyovZm9ybVxzKj5ccyo8XHMqXD9ccypwaHBccypcfVxzKlw/XHMqPiI7aTozMDU7czoxMzk6IjxcP3BocFxzKmVjaG9ccypldmFsXHMqXChiYXNlNjRfZGVjb2RlXHMqXChccyooc3RyX3JlcGxhY2VccypcKFxzKlsnIl1bXiciXStbJyJdXHMqLFxzKlsnIl1bXiciXStbJyJdXHMqXHMqLCkrXHMqWyciXVteJyJdK1snIl1ccyooXClccyopKzsiO2k6MzA2O3M6NDk0OiJpbmNsdWRlXHMqXChccypkaXJuYW1lXHMqXChccypfX0ZJTEVfX1xzKlwpXHMqXC5ccyonL2luY2x1ZGVzL19iYl9wcmVzc19wbHVnaW4uY2xhc3MucGhwJ1xzKlwpXHMqO1xzKnJlZ2lzdGVyX2FjdGl2YXRpb25faG9va1xzKlwoXHMqX19GSUxFX19ccyosXHMqYXJyYXlccypcKFxzKidbXiddKidccyosXHMqJ1teJ10qJ1xzKlwpXHMqXClccyo7XHMqLy9ccypNXHMqcmVnaXN0ZXJfZGVhY3RpdmF0aW9uX2hvb2tccypcKFxzKl9fRklMRV9fXHMqLFxzKmFycmF5XHMqXChccyonW14nXSonXHMqLFxzKidbXiddKidccypcKVxzKlwpXHMqO1xzKmFkZF9maWx0ZXJccypcKFxzKidbXiddKidccyosXHMqYXJyYXlccypcKFxzKlwkXHd7MSw0MH1ccyosXHMqJ1teJ10qJ1xzKlwpXHMqLFxzKjEwXHMqLFxzKjNccypcKVxzKjtccyphZGRfYWN0aW9uXHMqXChccyonW14nXSonXHMqLFxzKmFycmF5XHMqXChccypcJFx3ezEsNDB9XHMqLFxzKidbXiddKidccypcKVxzKlwpXHMqOyI7aTozMDc7czo1MTU6IlwkXHd7MSw0MH1ccyo9XHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKidbXiddKidccypcXVxzKjtccypcJFx3ezEsNDB9XHMqPVxzKlsnIl1bXiInXSpbJyJdXHMqO1xzKlwkXHd7MSw0MH1ccyo9XHMqWyciXVteIiddKlsiJ11ccyo7XHMqXCRcd3sxLDQwfVxzKj1ccyphcnJheVxzKlwoKFxzKlxkK1xzKixccyopezIsfVxzKlxkK1xzKlwpXHMqO1xzKmZvcmVhY2hccypcKFxzKlwkXHd7MSw0MH1ccyphc1xzKlwkXHd7MSw0MH1ccypcKVxzKlx7XHMqXCRcd3sxLDQwfVxzKlwuXHMqPVxzKlwkXHd7MSw0MH1ccypcW1xzKlwkXHd7MSw0MH1ccypcXVxzKjtccypcfVxzKlwkXHd7MSw0MH1ccyo9XHMqc3RycmV2XHMqXChbXildK1wpXHMqO1xzKlwkXHd7MSw0MH1ccyo9XHMqXCRcd3sxLDQwfVxzKlwoXHMqIlteIl0qIlxzKixccypcJFx3ezEsNDB9XHMqXChccypcJFx3ezEsNDB9XHMqXClccypcKVxzKjtccypcJFx3ezEsNDB9XHMqXChccypcKVxzKjtccypyZXR1cm5ccyo7IjtpOjMwODtzOjIxODoiaWZccypcKFxzKmlzc2V0XHMqXChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqIlteIl0qIlxzKlxdXHMqXClccypcKVxzKlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXHMqXFtccyoiW14iXSoiXHMqXF1ccypcKFxzKlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXHMqXFtccyoiW14iXSoiXHMqXF1ccypcKVxzKjsiO2k6MzA5O3M6Mzg4OiI8XHMqXD9ccypwaHBccyppZlxzKlwoXHMqXCRcd3sxLDQwfVxzKj09J3VwbG9hZCdccypcKVxzKlx7XHMqaWZccypcKFxzKmlzX3VwbG9hZGVkX2ZpbGVccypcKFxzKlwkXHd7MSw0MH1ccypcW1xzKiJbXiJdKiJccypcXVxzKlxbXHMqIlteIl0qIlxzKlxdXHMqXClccypcKVxzKlx7XHMqbW92ZV91cGxvYWRlZF9maWxlXHMqXChccypcJFx3ezEsNDB9XHMqXFtccyoiW14iXSoiXHMqXF1ccypcW1xzKiJbXiJdKiJccypcXVxzKixccypcJFx3ezEsNDB9XHMqXFtccyoiW14iXSoiXHMqXF1ccypcW1xzKiJbXiJdKiJccypcXVxzKlwpXHMqO1xzKmVjaG9ccypcJFx3ezEsNDB9XHMqXFtccyoiW14iXSoiXHMqXF1ccypcW1xzKiJbXiJdKiJccypcXVxzKjtccypcfVxzKlx9XHMqXD9ccyo+IjtpOjMxMDtzOjQxODoiPFxzKlw/XHMqcGhwXHMqaWZccypcKFxzKlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXHMqXFtccypbIiddW14iJ10qWyInXVxzKlxdXHMqPT1bIiddW14nIl0qWyInXVxzKlwpXHMqXHtccyplY2hvXHMqXHcrXHMqO1xzKlwkXHd7MSw0MH1ccyo9XHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKidbXiddKidccypcXVxzKjtccyppZlxzKlwoXHMqXCRcd3sxLDQwfSE9IlteIl0qIlxzKlwpXHMqXHtccypcJFx3ezEsNDB9XHMqPVxzKmJhc2U2NF9kZWNvZGVccypcKFxzKlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXHMqXFtccyonW14nXSonXHMqXF1ccypcKVxzKjtccypAP2V2YWxccypcKFxzKlsiJ11bXiInXSpbIiddXHMqXClccyo7XHMqXH1ccypcfVxzKlw/XHMqPiI7aTozMTE7czo3MToiPFw/cGhwXHMqXCRzdHJccyo9XHMqJ1BHUnBkaVteJ10rJztccyplY2hvXHMrYmFzZTY0X2RlY29kZVwoXCRzdHJcKTtcPz4iO2k6MzEyO3M6MzY0OiI8XD9ccypwaHBccypcJFx3ezEsNDB9XHMqXFtccyonW14nXSonXHMqXF1ccyo9XHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccyo7XHMqZnVuY3Rpb25ccypcdytccypcKFxzKlwkXHd7MSw0MH1ccypcKVxzKlx7XHMqXCRcd3sxLDQwfVxzKj1ccyoiW14iXSoiXHMqO1xzKmdsb2JhbFxzK1wkXHcuK0BcJFxzKlx7XHMqXHcrXHMqXChccyoiW14iXSoiXHMqXClccypcfVxzKlwoXHMqXCRcd3sxLDQwfVxzKixccypGQUxTRVxzKixccypcJFxzKlx7XHMqXHcrXHMqXChccyoiW14iXSoiXHMqXClccypcfVxzKlwpXHMqO1xzKnJldHVyblxzKlwkXHMqXHtccypcdytccypcKFxzKiJbXiJdKiJccypcKVxzKlx9XHMqO1xzKlx9IjtpOjMxMztzOjg4OiIvL2luc3RhXHcrXHMqKHJlcXVpcmV8aW5jbHVkZXxyZXF1aXJlX29uY2V8aW5jbHVkZV9vbmNlKVwoWyInXVteJyJdK1snIl1cKTtccyovL2luc3RhXHcrIjtpOjMxNDtzOjQxOiIoXCRhcnJfd29yZFxbXGQrXF1cW1xdXHMqPVxzKiJcZCsiOyl7MTAsfSI7aTozMTU7czo5ODoiKFwkXHcrPVteO10rOykrQFwkXHcrXChAXCRcdytcKEBcJFx3K1woXCRfKEdFVHxQT1NUfENPT0tJRXxSRVFVRVNUfFNFUlZFUilcW1teXV0rXF1cKVwpXCk7ZGllXChcKTsiO2k6MzE2O3M6MTM3OiI8XD9waHBccy9cKlxzKi0tXHMqZW5waHAuK3Vuc2V0XHMqXChccypcJFx3ezEsNDB9XHMqLFxzKlwkXHd7MSw0MH1ccypcKVxzKjtccypcJFx3ezEsNDB9XHMqXChccypcKVxzKjtccypcfVxzKmVjaG9ccypcJFx3ezEsNDB9XHMqO1xzKlw/PiI7aTozMTc7czo0NjU6IjxcP1xzKnBocFxzKmlmXHMqXChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqJ1teJ10qJ1xzKlxdXHMqPT0nW14nXSonXHMqXClccypce1xzKlwkXHd7MSw0MH1ccyo9XHMqXChccypodG1sc3BlY2lhbGNoYXJzXHMqXChccypmaWxlX2dldF9jb250ZW50c1xzKlwoXHMqJ1teJ10qJ1xzKlwpXHMqXClccypcKVxzKjtccyplY2hvXHMqXCRcd3sxLDQwfVxzKjtccypcfVxzKmlmXHMqXChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqJ1teJ10qJ1xzKlxdXHMqPT0nW14nXSonXHMqXClccypce1xzKlwkXHd7MSw0MH1ccyo9XHMqXChccypodG1sc3BlY2lhbGNoYXJzXHMqXChccypmaWxlX2dldF9jb250ZW50c1xzKlwoXHMqJ1teJ10qJ1xzKlwpXHMqXClccypcKVxzKjtccyplY2hvXHMqXCRcd3sxLDQwfVxzKjtccypcfShccyovL2ZpbGVccyplbmQpPyI7aTozMTg7czozOTQ6ImlmXHMqXChccyppc3NldFxzKlwoXHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKiJbXiJdKiJccypcXVxzKlwpXHMqXClccypce1xzKlwkXHd7MSw0MH1ccyo9XHMqKCJbXiJdKiJccypcLik/XHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKidbXiddKidccypcXVxzKjtccypcJFx3ezEsNDB9XHMqPVxzKmFycmF5XHMqXChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqJ1teJ10qJ1xzKlxdXHMqXClccyo7XHMqQGFycmF5X2ZpbHRlclxzKlwoXHMqXCRcd3sxLDQwfVxzKixccypcJFx3ezEsNDB9XHMqXClccyo7XHMqZWNob1xzKiJbXiJdKiJccyo7XHMqZXhpdFxzKlwoXHMqXClccyo7XHMqXH0iO2k6MzE5O3M6NDAxOiJkZWZpbmVccypcKFxzKidbXiddKicvJ1teJ10qJ1xzKixccypESVJFQ1RPUllfU0VQQVJBVE9SXHMqXClccyo7XHMqXCRcd3sxLDQwfVxzKj1ccypyZWFscGF0aFxzKlwoXHMqZGlybmFtZVxzKlwoXHMqX19GSUxFX19ccypcKVxzKlwuXHMqW14pXStcKVxzKjtccyppZlxzKlwoXHMqIWZpbGVfZXhpc3RzXHMqXChccypcJFx3ezEsNDB9XHMqXC5ccypbXildK1wpXHMqJiZccyppc3NldFxzKlwoXHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKidbXiddKidccypcXVxzKlwpXHMqXClccypce1xzKlwkXHd7MSw0MH1ccyo9XHMqc3RyX3JlcGxhY2VccypcKFxzKlteKV0rXClccyo7XHMqXH1ccypkZWZpbmVccypcKFxzKidbXiddKidccyosXHMqXCRcd3sxLDQwfVxzKlwpXHMqOyI7aTozMjA7czoyNTc6IlwjIS91c3IvYmluL2Vudi4rP1xdXHMqXFtccypcZCtccypcXVxzKlwoXHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKl9cZCtccypcKFxzKjlccypcKVxzKlxdXHMqXClccyo7XHMqXCRcd3sxLDQwfVxzKlxbXHMqJ1teJ10qJ1xzKlxdXHMqXFtccypcZCtccypcXVxzKlwoXHMqXCRcd3sxLDQwfVxzKixccypcJFx3ezEsNDB9XHMqXClccyo7XHMqXH1ccyplY2hvXHMqXCRcd3sxLDQwfVxzKjtccypleGl0XHMqO1xzKlx9IjtpOjMyMTtzOjEzOToiPFw/XHMqXCRHTE9CQUxTXFsnX1xkK18nXF09QXJyYXlcKGJhc2U2NF9kZWNvZGVcKC4rXCRwYXNzd29yZD1fXGQrXCgwXCk7XCRHTE9CQUxTXFsnX1xkK18nXF1cW1xkK1xdXChfXGQrXChcZCtcKSxfXGQrXChcZCtcKSxfXGQrXChcZCtcKVwpOyI7aTozMjI7czozNjI6IjxcP1xzKnBocFxzKmlmXHMqXChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqImxvZ2luIlxzKlxdXHMqPT0iW14iXSoiXHMqXClccypce1xzKlwkXHd7MSw0MH1ccyo9IlteIl0qIlxzKjtccypcJFx3ezEsNDB9XHMqPSJbXiJdKiJccyo7XHMqXCRcd3sxLDQwfVxzKj0iW14iXSoiXHMqOy4rPzxccypmb3JtXHMqZW5jdHlwZVxzKj0iW14iXSoiXHMqbWV0aG9kXHMqPSJbXiJdKiJccyo+XHMqPFxzKmlucHV0XHMqbmFtZVxzKj0iW14iXSoiXHMqdHlwZVxzKj0iW14iXSoiL1xzKj5ccyo8XHMqaW5wdXRccyp0eXBlXHMqPSJbXiJdKiJccyp2YWx1ZVxzKj0iW14iXSoiL1xzKj5ccyo8XHMqL2Zvcm1ccyo+IjtpOjMyMztzOjIwOToiXCRHTE9CQUxTXFtbXl1dK1xdXHMqPVxzKlwkX1NFUlZFUjtccypmdW5jdGlvblxzKlx3K1woXCRcdytcKVxzKntccypcJFx3K1xzKj1ccypbIiddWyciXVxzKjtccypnbG9iYWwuKz9cKFxzKlwkdXJsXHMqLFxzKkZBTFNFXHMqLFxzKlwke1xzKlx3K1woXHMqW14pXStcKVxzKn1ccypcKTtccypyZXR1cm5ccypcJHtccypcdytcKFxzKlteKV0rXClccyp9XHMqO1xzKn0iO2k6MzI0O3M6Njg6IkA/Y29weVwoXHMqWyJdaHR0cHM/Oi8vW14iJ10rWyJdXHMqLFxzKlsiJ11bXlwkXVteLl0rXC5waHBbIiddXHMqXCk7IjtpOjMyNTtzOjI5MToiaWZccypcKFxzKm1kNVxzKlwoXHMqQD9cJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqXHcrXHMqXF1ccypcKVxzKj09WyciXVteJyJdKlsnIl1ccypcKVxzKlwoXHMqXCRcd3sxLDQwfT1AXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKlx3K1xzKlxdXHMqXClccypcLlxzKkBcJFx3ezEsNDB9XHMqXChccypzdHJpcHNsYXNoZXNccypcKFxzKlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXHMqXFtccypcdytccypcXVxzKlwpXHMqXClccyo7IjtpOjMyNjtzOjMyNzoiaWZccypcKFxzKmlzc2V0XHMqXChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqJ1teJ10qJ1xzKlxdXHMqXClccyomJlxzKmlzc2V0XHMqXChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqJ1teJ10qJ1xzKlxdXHMqXClccypcKVxzKlx7XHMqZWNob1xzKlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXHMqXFtccyonW14nXSonXHMqXF1ccypbKisvLV5dXHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKidbXiddKidccypcXVxzKjtccypleGl0XHMqO1xzKlx9IjtpOjMyNztzOjUxNjoiaWZccypcKFxzKmlzc2V0XHMqXChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqJ1teJ10qJ1xzKlxdXHMqXClccypcKVxzKlx7XHMqZXJyb3JfcmVwb3J0aW5nXHMqXChccypFX0FMTFxzKlwpXHMqO1xzKkBpbmlfc2V0XHMqXChccyonW14nXSonXHMqLFxzKlRSVUVccypcKVxzKjtccypAaW5pX3NldFxzKlwoXHMqJ1teJ10qJ1xzKixccyonW14nXSonXHMqXClccyo7XHMqQHNldF90aW1lX2xpbWl0XHMqXChccypcZCtccypcKVxzKjsuKz9odHRwX2J1aWxkX3F1ZXJ5XHMqXChccyphcnJheVxzKlwoXHMqJ1teJ10qJ1xzKj1ccyo+XHMqXCRcd3sxLDQwfVxzKlwpXHMqXClccypcKVxzKlwpXHMqO1xzKlwkXHd7MSw0MH1ccyo9XHMqc3RyZWFtX2NvbnRleHRfY3JlYXRlXHMqXChccypcJFx3ezEsNDB9XHMqXClccyo7XHMqcmV0dXJuXHMqZmlsZV9nZXRfY29udGVudHNccypcKFxzKlwkXHd7MSw0MH1ccyosXHMqZmFsc2VccyosXHMqXCRcd3sxLDQwfVxzKlwpXHMqO1xzKlx9IjtpOjMyODtzOjM4NToiaWZccypcKFxzKiFmdW5jdGlvbl9leGlzdHNccypcKFxzKidbXiddKidccypcKVxzKlwpXHMqXHtccypmdW5jdGlvblxzKmZpbmRzeXNmb2xkZXJccypcKFxzKlwkXHd7MSw0MH1ccypcKVxzKlx7XHMqXCRcd3sxLDQwfVxzKj1ccypkaXJuYW1lXHMqXChccypcJFx3ezEsNDB9XHMqXClccyo7XHMqXCRcd3sxLDQwfVxzKj1cJFx3ezEsNDB9XHMqXC5ccyonW14nXSonXHMqO1xzKmNsZWFyc3RhdGNhY2hlXHMqXChccypcKVxzKjtccyppZlxzKlwoXHMqIWlzX2RpclxzKlwoXHMqXCRcd3sxLDQwfVxzKlwpXHMqXClccypyZXR1cm5ccypmaW5kc3lzZm9sZGVyXHMqXChccypcJFx3ezEsNDB9XHMqXClccyo7XHMqZWxzZVxzKnJldHVyblxzKlwkXHd7MSw0MH1ccyo7XHMqXH1ccypcfSI7aTozMjk7czoyNjk6InJlcXVpcmVfb25jZVxzKlwoXHMqZmluZHN5c2ZvbGRlclxzKlwoXHMqX19GSUxFX19ccypcKVxzKlwuXHMqJ1teJ10qJ1xzKlwpXHMqO1xzKlwkXHd7MSw0MH1ccyo9J1teJ10qJ1xzKjtccypcdytccypcKFxzKlx3K1xzKlwoXHMqX19GSUxFX19ccypcKVxzKlwpXHMqO1wkXHcrPSdbXiddKyc7XCRcd3sxLDQwfVxzKj0nW14nXSonXHMqO1xzKmV2YWxccypcKFxzKlx3K1xzKlwoXHMqWyciXVteJyJdKlsnIl1ccyosXHMqXCRcd3sxLDQwfVxzKlwpXHMqXClccyo7XHMqXD8+IjtpOjMzMDtzOjM5NzoiPFxzKlw/XHMqaWZccypcKFxzKiFpc3NldFxzKlwoXHMqXCRcd3sxLDQwfVxzKlwpXHMqXClccypce1xzKkBpbXBvcnRfcmVxdWVzdF92YXJpYWJsZXNccypcKFxzKiJbXiJdKiJccyosXHMqIlteIl0qIlxzKlwpXHMqO1xzKlx9XHMqaWZccypcKFxzKm1kNVxzKlwoXHMqXCRcd3sxLDQwfVxzKlwpXHMqIT0nW14nXSonXHMqXClccypce1xzKmVjaG9ccyoiW14iXSoiXHMqO1xzKlx9XHMqZWxzZVxzKlx7XHMqaWZccypcKFxzKmdldF9tYWdpY19xdW90ZXNfZ3BjXHMqXChccypcKVxzKlwpXHMqXCRcd3sxLDQwfVxzKj1ccypzdHJpcHNsYXNoZXNccypcKFxzKlwkXHd7MSw0MH1ccypcKVxzKjtccypldmFsXHMqXChccypcJFx3ezEsNDB9XHMqXClccyo7XHMqXH1ccyo7XHMqcmV0dXJuXHMqO1xzKlw/PiI7aTozMzE7czo1ODM6IjxcP3BocFxzKmVycm9yX3JlcG9ydGluZ1xzKlwoXHMqXGQrXHMqXClccyo7XHMqZWNob1xzKiJbXiJdKiJccyo7XHMqaWZccypcKFxzKlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXHMqXFtccypbIiddW14iJ10rWyInXVxzKlxdXHMqPT1ccyoiW14iXSoiXHMqXClccypce1xzKlwkXHd7MSw0MH1ccyo9XHMqZmlsZV9nZXRfY29udGVudHNccypcKFxzKlsiJ11bXiInXSpbIiddXHMqXClccyo7XHMqXCRcd3sxLDQwfVxzKj1ccypmb3BlblxzKlwoXHMqIlteIl0qIlxzKixccyoiW14iXSoiXHMqXClccyo7XHMqZndyaXRlXHMqXChccypcJFx3ezEsNDB9XHMqLFxzKlwkXHd7MSw0MH1ccypcKVxzKjtccypmY2xvc2VccypcKFxzKlwkXHd7MSw0MH1ccypcKVxzKjtccypcJFx3ezEsNDB9XHMqPVxzKmZvcGVuXHMqXChccypbJyJdW14iJ10rWyciXVxzKixccyoiW14iXSoiXHMqXClccyo7XHMqZndyaXRlXHMqXChccypcJFx3ezEsNDB9XHMqLFxzKlwkXHd7MSw0MH1ccypcKVxzKjtccypmY2xvc2VccypcKFxzKlwkXHd7MSw0MH1ccypcKVxzKjtccyplY2hvXHMqWyInXVteJyJdK1siJ11ccyo7XHMqXH1ccypcPz4iO2k6MzMyO3M6NDc2OiI8XD9waHBccypcJFx3ezEsNDB9XHMqPSJbXiJdKiJccyo7XHMqXCRcd3sxLDQwfVxzKj0iW14iXSoiXHMqO1xzKlwkXHd7MSw0MH1ccyo9IlteIl0qIlxzKjtccypcJFx3ezEsNDB9XHMqPSJbXiJdKiJccyo7XHMqXCRcd3sxLDQwfVxzKj0iW14iXSoiXHMqO1xzKlwkXHd7MSw0MH1ccyo9J1teJ10qJ1xzKjtccypcJFx3ezEsNDB9XHMqPVxzKnN0cl9yb3QxM1xzKlwoXHMqJ1teJ10qJ1xzKlwpXHMqO1xzKlwkXHd7MSw0MH1ccyo9XCRcd3sxLDQwfVxzKlwoXHMqJ1teJ10qJ1xzKlwpXHMqO1xzKlwkXHd7MSw0MH1ccyo9XCRcd3sxLDQwfVxzKlwoXHMqJ1teJ10qJ1xzKlwpXHMqO1xzKlwkXHd7MSw0MH1ccyo9J1teJ10qJ1xzKjtccypcJFx3ezEsNDB9XHMqPSdbXiddKidccyo7XHMqXCRcd3sxLDQwfVxzKlwuXHMqPSdbXiddKidccypcLlxzKlwkXHd7MSw0MH1ccyo7XHMqQFwkXHd7MSw0MH1ccypcKFxzKlwkXHcrXHMqXCguKz9cKVwpOyI7aTozMzM7czo0MjU6IjxcP3BocFxzKmZ1bmN0aW9uXHMrZ2V0Qm90XChccypcJFx3ezEsNDB9XHMqXCkuK2lmXHMqXChccypAXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKiJbXiJdKiJccypcXVxzKj09XHMqIlteIl0qIlxzKlwpXHMqXHtccyppZlxzKlwoXHMqQD8oY29weXxtb3ZlX3VwbG9hZGVkX2ZpbGUpXHMqXChccypcJF9GSUxFU1xzKlxbXHMqIlteIl0qIlxzKlxdXHMqXFtccyoiW14iXSoiXHMqXF1ccyosXHMqXCRcd3sxLDQwfVxzKlxbXHMqIlteIl0qIlxzKlxdXHMqXFtccyoiW14iXSoiXHMqXF1ccypcKVxzKlwpXHMqXHtccyplY2hvXHMqIlteIl0qIlxzKjtccypcfVxzKmVsc2Vccypce1xzKmVjaG9ccyoiW14iXSoiXHMqO1xzKlx9XHMqXH1ccypcfVxzKmVsc2Vccypce1xzKmV4aXRccypcKFxzKlwpXHMqO1xzKlx9XHMqXD8+IjtpOjMzNDtzOjcwMzoiPFw/cGhwXHMqXCRcd3sxLDQwfVxzKj1bIiddW14nIl0rWyInXVxzKjtccypcJFx3ezEsNDB9XHMqPVxzKlxkK1xzKjtccypoZWFkZXJccypcKFxzKiJbXiJdKiJccypcKVxzKjtccypAZGF0ZV9kZWZhdWx0X3RpbWV6b25lX3NldFxzKlwoXHMqIlteIl0qIlxzKlwpXHMqO1xzKkBpbmlfc2V0XHMqXChccyoiW14iXSoiXHMqLFxzKiJbXiJdKiJccypcKVxzKjtccyplcnJvcl9yZXBvcnRpbmdccypcKFxzKkVfQUxMXHMqXClccyo7XHMqaW5pX3NldFxzKlwoXHMqJ1teJ10qJ1xzKixccyonW14nXSonXHMqXClccyo7XHMqXCRcd3sxLDQwfVxzKj1cJFx3ezEsNDB9XHMqXD9ccypsMUhYeGswXHMqXChccypcKVxzKjpsMTF4XHMqXChccypcKVxzKjtccypsMTVPZVxzKlwoXHMqXClccyo7XHMqXCRcd3sxLDQwfVxzKj1cJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqIlteIl0qIlxzKlxdXHMqO1xzKlwkXHd7MSw0MH1ccyo9XCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKiJbXiJdKiJccypcXVxzKjsuKz9icmVha1xzKjtccypcfVxzKlwkXHd7MSw0MH1ccyo9XCRcd3sxLDQwfVxzKjxccyowXHMqXD9ccyphYnNccypcKFxzKlwkXHd7MSw0MH1ccypcKVxzKjpcJFx3ezEsNDB9XHMqO1xzKlwkXHd7MSw0MH0lPVwkXHd7MSw0MH1ccyo7XHMqcmV0dXJuXHMqXCRcd3sxLDQwfVxzKjtccypcfSI7aTozMzU7czoyOTc6IjxcP3BocFxzKmlmXHMqXChccyppc3NldFxzKlwoXHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKidbXiddKidccypcXVxzKlwpXHMqXClccypkaWVccypcKFxzKnBpXHMqXChccypcKVxzKlwpXHMqO1xzKlwkXHMqXHtccyoiW14iXSoiXHMqXH1ccypcW1xzKiJbXiJdKiJccypcXVxzKj0iW14iXSoiXHMqOy4rZXZhbFxzKlwoXHMqXCRccypce1xzKlwkXHd7MSw0MH1ccypcfVxzKlxbXHMqIlteIl0qIlxzKlxdXHMqXClccyo7XHMqXH1ccypleGl0XHMqXChccypcKVxzKjtccypcfVxzKlw/PiI7aTozMzY7czoyMzk6IjxcP3BocFxzKmVycm9yX3JlcG9ydGluZ1xzKlwoXHMqRV9BTExccypcKVxzKjtccyppbmlfc2V0XHMqXChccyonW14nXSonXHMqLFxzKjFccypcKVxzKjtccypmdW5jdGlvblxzKnN0cl9iZXR3ZWVuLittYWdlbnRvXHMqbm90XHMqZm91bmQnW14nXSonQ29udGVudC10eXBlOlxzKmFwcGxpY2F0aW9uL2pzb24nXHMqXClccyo7XHMqZWNob1xzKmpzb25fZW5jb2RlXHMqXChccypcJFx3ezEsNDB9XHMqXClccyo7XHMqXD8+IjtpOjMzNztzOjIyNToiPFw/cGhwXHMqL1wqXCpccypcKlxzKlBsdWdpblxzKk5hbWU6XHMqTG9naW5ccypXYWxsLis/XHMqO1xzKmV4aXRccypcKFxzKlwpXHMqO1xzKlx9XHMqZXhpdFxzKlwoXHMqXClccyo7XHMqXH1ccyphZGRfYWN0aW9uXHMqXChccyonW14nXSonXHMqLFxzKidbXiddKidccyosXHMqMFxzKlwpXHMqO1xzKmFkZF9hY3Rpb25ccypcKFxzKidbXiddKidccyosXHMqJ1teJ10qJ1xzKlwpXHMqO1xzKlx9IjtpOjMzODtzOjYxNzoiKFwkXHd7MSw0MH1ccyo9IlteIl0qIlxzKjtccyopK1xzKlwkXHd7MSw0MH1ccyo9XHMqJ1teJ10qJ1xzKjtccypcJFx3ezEsNDB9XHMqPVxzKlwkXHd7MSw0MH1ccypcKFxzKlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXHMqXClccyo7XHMqaWZccypcKFxzKiFlbXB0eVxzKlwoXHMqXCRcd3sxLDQwfVxzKlwpXHMqXClccypce1xzKmZvcmVhY2hccypcKC4rP1wkXHd7MSw0MH1ccyo9XHMqJ1teJ10qJ1xzKjtccypcJFx3ezEsNDB9XHMqPVxzKlwkXHd7MSw0MH1ccypcKFxzKlwpXHMqO1xzKlwkXHd7MSw0MH1ccypcKFxzKlwkXHd7MSw0MH1ccyosXHMqQ1VSTE9QVF9VUkxccyosXHMqXCRcd3sxLDQwfVxzKlwpXHMqO1xzKlwkXHd7MSw0MH1ccypcKFxzKlwkXHd7MSw0MH1ccyosXHMqQ1VSTE9QVF9QT1NUXHMqLFxzKjFccypcKVxzKjtccypcJFx3ezEsNDB9XHMqXChccypcJFx3ezEsNDB9XHMqLFxzKkNVUkxPUFRfUE9TVEZJRUxEU1xzKixccypcJFx3ezEsNDB9XHMqXClccyo7XHMqXCRcd3sxLDQwfVxzKj1ccypcJFx3ezEsNDB9XHMqXChccypcJFx3ezEsNDB9XHMqXClccyo7XHMqXCRcd3sxLDQwfVxzKlwoXHMqXCRcd3sxLDQwfVxzKlwpXHMqO1xzKlx9XHMqXH0iO2k6MzM5O3M6MTQ4OiI8XD9waHBccyplY2hvXHMqIlteIl0qIlxzKjtccyoocGFzc3RocnV8ZXhlY3xzaGVsbF9leGVjfHBvcGVufHN5c3RlbXxldmFsKVxzKlwoXHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKlx3K1xzKlxdXHMqXClccyo7XHMqXD8+IjtpOjM0MDtzOjQ0MToiaWZccypcKFxzKmlzc2V0XHMqXChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqWyciXVteJyJdK1siJ11ccypcXVxzKlwpXHMqXClccypce1xzKmVjaG9ccyouKz9ccypcfVxzKmVsc2Vccypce1xzKm1vdmVfdXBsb2FkZWRfZmlsZVxzKlwoXHMqXCRcd3sxLDQwfVxzKlxbXHMqWyInXVteJyJdK1siJ11ccypcXVxzKlxbXHMqWyInXVteJyJdK1siJ11ccypcXVxzKixccypbIiddW14iJ10qWyInXVxzKlwuXHMqXCRcd3sxLDQwfVxzKlxbXHMqWyInXVteIiddK1siJ11ccypcXVxzKlxbXHMqWyInXVteJyJdK1siJ11ccypcXVxzKlwpXHMqO1xzKmVjaG9bXiRdK1wkX0ZJTEVTXHMqXFtccypbIiddW14iJ10rWyInXVxzKlxdXHMqXFtccypbIiddW14iJ10rWyInXVxzKlxdXHMqO1xzKmVjaG9ccypbIiddW14nIl0rWyInXVxzKjtccypcfVxzKlx9IjtpOjM0MTtzOjE3NToiY2xhc3NccypNYVx3K1xzKmV4dGVuZHNccypNYWdlX1x3K1xzKlx7XHMqcHVibGljXHMqZnVuY3Rpb25ccyppbmRleEFjdGlvblxzKlwoXHMqXClccypce1xzKkA/ZXZhbFxzKlwoXHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKlx3K1xzKlxdXHMqXClccyo7XHMqXH1ccypcfSI7aTozNDI7czo3MDoiXCRcd3sxLDQwfS1ccyo+XHMqc2VuZENjTnVtYmVyXHMqXChccypcKVxzKjtccypyZXR1cm5ccypcJFx3ezEsNDB9XHMqOyI7aTozNDM7czo2MjU6IlwkXHd7MSw0MH1ccyo9J1teJ10qJ1xzKjtccypcJFx3ezEsNDB9XHMqPSdbXiddKidccyo7XHMqXCRcd3sxLDQwfVxzKj0nW14nXSonXHMqO1xzKlwkXHd7MSw0MH1ccyo9IlteIl0qIlxzKjtccyppZlxzKlwoXHMqQFwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXHMqXFtccyonW14nXSonXHMqXF1ccyo9PSdbXiddKidccypcKVxzKlx7XHMqaWZccypcKFxzKmlzc2V0XHMqXChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqXCRcd3sxLDQwfVxzKlxdXHMqXClccypcKVxzKlx7XHMqXCRcd3sxLDQwfVxzKj1ccypmaWxlX2V4aXN0cy4rP2ZpbGVfZXhpc3RzXHMqXChccypcJFx3ezEsNDB9XHMqXClccypcP1xzKkBmaWxlbXRpbWVccypcKFxzKlwkXHd7MSw0MH1ccypcKVxzKjpcJFx3ezEsNDB9XHMqO1xzKkBmaWxlX3B1dF9jb250ZW50c1xzKlwoXHMqXCRcd3sxLDQwfVxzKixccyonW14nXSonXHMqXC5ccypiYXNlNjRfZW5jb2RlXHMqXChccypcJFx3ezEsNDB9XHMqXClccyosXHMqRklMRV9BUFBFTkRccypcKVxzKjtccypAdG91Y2hccypcKFxzKlwkXHd7MSw0MH1ccyosXHMqXCRcd3sxLDQwfVxzKixccypcJFx3ezEsNDB9XHMqXClccyo7XHMqXH0iO2k6MzQ0O3M6NzA6IjxcP3BocFxzKmV2YWxccypcKFxzKmJhc2U2NF9kZWNvZGVccypcKFxzKlx3K1teKV17MTAwMCx9XClccypcKTtccypcPz4iO2k6MzQ1O3M6MjU1OiJccyo8XHMqXD9ccypcJFx3ezEsNDB9XHMqPSJbXiJdKiJccyo7XHMqaWZccypcKFxzKlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXHMqXFtccypwYXNzXHMqXF1ccyo9PVwkXHd7MSw0MH1ccypcKVxzKlx7XHMqXCRcd3sxLDQwfVxzKj1ccypnZXRjd2RccypcKFxzKlwpXHMqO1xzKkVjaG8uKz88aW5wdXRccyt0eXBlPSJzdWJtaXQiIG5hbWU9Ilx3KyJccyt2YWx1ZT0iZ28hIlxzKy8+PC9mb3JtPlxzKjxcP3BocFxzKn1ccypcPz4iO2k6MzQ2O3M6MTA4OiI8XD9waHBccyovXCpccypcdytccypcKi9ccypoZWFkZXJccypcKFxzKiJMb2NhdGlvbjpccypodHRwW14iXSoiXHMqXClccyo7XHMqL1wqXHMqXHcrXHMqXCovXHMqZXhpdFxzKjtccypcPz4iO2k6MzQ3O3M6NTU1OiI8XD9waHBccyplcnJvcl9yZXBvcnRpbmdccypcKFxzKlxkK1xzKlwpXHMqO1xzKmVjaG9ccyoiW14iXSoiXHMqO1xzKmlmXHMqXChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqIlteIl0qIlxzKlxdXHMqPT1ccyoiW14iXSoiXHMqXClccypce1xzKlwkXHd7MSw0MH1ccyo9XHMqZmlsZV9nZXRfY29udGVudHNccypcKFxzKidbXiddKidccypcKVxzKjtccypcJFx3ezEsNDB9XHMqPVxzKmZvcGVuXHMqXChccyoiW14iXSoiXHMqLFxzKiJbXiJdKiJccypcKVxzKjtccypmd3JpdGVccypcKFxzKlwkXHd7MSw0MH1ccyosXHMqXCRcd3sxLDQwfVxzKlwpXHMqO1xzKmZjbG9zZVxzKlwoXHMqXCRcd3sxLDQwfVxzKlwpXHMqO1xzKlwkXHd7MSw0MH1ccyo9XHMqZm9wZW5ccypcKFxzKiJbXiJdKiJccyosXHMqIlteIl0qIlxzKlwpXHMqO1xzKmZ3cml0ZVxzKlwoXHMqXCRcd3sxLDQwfVxzKixccypcJFx3ezEsNDB9XHMqXClccyo7XHMqZmNsb3NlXHMqXChccypcJFx3ezEsNDB9XHMqXClccyo7XHMqZWNob1xzKiJbXiJdKiJccyo7XHMqXH1ccypcPz4iO2k6MzQ4O3M6ODg6Il5ccyo8XD9waHBccypoZWFkZXJccypcKFxzKidMb2NhdGlvbjpccypodHRwcz86Ly9bXi9dKy9cP2E9XHcrJmM9XHcrJ1xzKlwpXHMqO1xzKlw/PlxzKiQiO2k6MzQ5O3M6Mjk4OiI8XD9waHBccypcJFx3ezEsNDB9XHMqPSJbXiJdKiJccyo7XHMqXCRccypce1xzKiJbXiJdKiJccypcfVxzKlxbXHMqIlteIl0qIlxzKlxdXHMqPSJbXiJdKiJccyo7XHMqXCRcd3sxLDQwfVxzKj0iW14iXSoiXHMqO1xzKlwkXHMqXHtccypcJFx3ezEsNDB9XHMqXH1ccyo9XCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1teO10rO1xzKlx3K1wkXHMqXHtccypcJFx3ezEsNDB9XHMqXH1ccypcLlxzKiJbXiJdKiJccyo7XHMqU21hcnR5Mzo6cmVkaXJlY3RccypcKFxzKlteKV0rXHMqXClccyo7XHMqXD8+IjtpOjM1MDtzOjQzNToiaWZccypcKFxzKiFpc3NldFxzKlwoXHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKidbXiddKidccypcXVxzKlwpXHMqXClccypce1xzKmhlYWRlclxzKlwoXHMqJ1teJ10qJ1xzKlwpXHMqO1xzKmV4aXRccyo7XHMqXH1ccypcPz5ccyo8XHMqXD9ccypcJFx3ezEsNDB9XHMqXFtccyonW14nXSonXHMqXF1ccyo9XHMqQXJyYXlccypcKFxzKmJhc2U2NF9kZWNvZGVccypcKFxzKidbXiddKidccypcLlxzKidbXiddKidccypcKVxzKixccypiYXNlNjRfZGVjb2RlXHMqXChccypbXntdK3tccypcJFx3ezEsNDB9XHMqPVxzKkFycmF5XChbXj5dKz5ccyo8XD9waHBccypcJFx3ezEsNDB9XHMqPV9cZCtccypcKFxzKlxkK1xzKlwpXHMqO1xzKi4rP1xzKixccypcJFx3ezEsNDB9XHMqLFxzKl9cZCtccypcKFxzKlxkK1xzKlwpXHMqXClccyo7IjtpOjM1MTtzOjU3MDoiXCRcd3sxLDQwfVxzKj1bXjtdKztccypcJFx3ezEsNDB9XHMqPVxzKmNyZWF0ZV9mdW5jdGlvblxzKlwoXHMqJ1teJ10qJ1xzKixccypcdytccypcKFxzKmJhc2U2NF9kZWNvZGVccypcKFxzKlteKV0rXClccyosXHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKnN0cl9yZXBsYWNlXHMqXChccyonW14nXSonXHMqLFxzKidbXiddKidccyosXHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKidbXiddKidccypcXVxzKlwpXHMqXF1ccypcKVxzKlwuXHMqJ1teJ10qJ1xzKlwpXHMqO1xzKlwkXHd7MSw0MH1ccypcKFxzKlwkXHd7MSw0MH1ccypcKVxzKjtccypmdW5jdGlvblxzKlx3K1xzKlwoXHMqXCRcd3sxLDQwfVxzKixccypcJFx3ezEsNDB9XHMqXClccypce1xzKnJldHVyblxzKlwkXHd7MSw0MH1ccypcXlxzKnN0cl9yZXBlYXRccypcKFxzKlwkXHd7MSw0MH1ccyosXHMqY2VpbFxzKlwoXHMqc3RybGVuXHMqXChccypcJFx3ezEsNDB9XHMqXClccyovXHMqc3RybGVuXHMqXChccypcJFx3ezEsNDB9XHMqXClccypcKVxzKlwpXHMqO1xzKlx9IjtpOjM1MjtzOjIzOToiPFw/cGhwXHMqKC8vaGVhZGVyXHMqXChccyonW14nXSonXHMqXClccyo7KT9ccypccypcJFx3ezEsNDB9XHMqPSdbXiddKidccyo7XHMqXCRcd3sxLDQwfT0nW14nXSonXHMqO1xzKlwkXHd7MSw0MH1ccyo9J1teJ10qJ1xzKjtccypcJFx3ezEsNDB9XHMqPVxzKnVybGRlY29kZVxzKlwoXHMqLis/O1wkeyIoXFx4WzAtOWEtZkEtRl17MiwzfSkrIn1ccypcWyIoXFx4WzAtOWEtZkEtRl17MiwzfSkrIlxdXChcKTtccypcPz4iO2k6MzUzO3M6MjY3OiJpZlxzKlwoXHMqQD9cJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqWyInXVteIiddKlsiJ11ccypcXVxzKj09XHMqWyInXVteIiddKlsiJ11ccypcKVxzKlx7XHMqZXJyb3JfcmVwb3J0aW5nXHMqXChccypcZCtccypcKVxzKjtccypAYXJyYXlfbWFwXHMqXChccypcKFteKV0rXClccyosXHMqXChccyphcnJheVxzKlwpXHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKkhUVFBfWFxzKlxdXHMqXClccyo7XHMqXH0iO2k6MzU0O3M6MTE0OiJcJGNvb2tleVxzKj1ccyoiW14iXSoiXHMqO1xzKnByZWdfcmVwbGFjZVxzKlwoXHMqWyInXVteIiddKlsiJ11ccyosXHMqWyInXVteJyJdKlsiJ11ccyosXHMqWyInXVteJyJdKlsiJ11ccypcKVxzKjsiO2k6MzU1O3M6MTcyOiJcJFx3ezEsNDB9XHMqPVxzKlsiJ108XD9waHBccypcKFsiJ11ccyo7Lis/XCRcd3sxLDQwfVxzKj1ccypAZm9wZW5ccypcKFxzKlsiJ11bXiciXSpbIiddXHMqLFxzKlsiJ11bXiciXSpbIiddXHMqXClccyo7XHMqQGZ3cml0ZVxzKlwoXHMqXCRcd3sxLDQwfVxzKixccypcJFx3ezEsNDB9XHMqXClccyo7IjtpOjM1NjtzOjYxNDoicHJpbnRccypbJyJdW14nXSpbIiddXHMqO1xzKmlmXHMqXChccyppc3NldFxzKlwoXHMqXCRcd3sxLDQwfVxzKlxbXHMqWyInXVteIiddKlsnIl1ccypcXVxzKlxbXHMqWyInXVteIiddKlsnIl1ccypcXVxzKlwpXHMqXClccypce1xzKmZvcmVhY2hccypcKFxzKlwkXHd7MSw0MH1ccypcW1xzKlsiJ11bXiInXSpbJyJdXHMqXF1ccypcW1xzKlsiJ11bXiInXSpbJyJdXHMqXF1ccyphc1xzKlwkXHd7MSw0MH1ccyo9XHMqPlxzKlwkXHd7MSw0MH1ccypcKVxzKlx7XHMqaWZccypcKFxzKlwkXHd7MSw0MH1ccyo9PVxzKlVQTE9BRF9FUlJfT0tccypcKVxzKlx7XHMqXCRcd3sxLDQwfVxzKj1ccypcJFx3ezEsNDB9XHMqXFtccyoiW14iXSoiXHMqXF1ccypcW1xzKlsiJ11bXiInXSpbJyJdXHMqXF1ccypcW1xzKlwkXHd7MSw0MH1ccypcXVxzKjtccypcJFx3ezEsNDB9XHMqPVxzKlwkXHd7MSw0MH1ccypcW1xzKlsiJ11bXiInXSpbJyJdXHMqXF1ccypcW1xzKlsiJ11bXiInXSpbJyJdXHMqXF1ccypcW1xzKlwkXHd7MSw0MH1ccypcXVxzKjtccyptb3ZlX3VwbG9hZGVkX2ZpbGVccypcKFxzKlwkXHd7MSw0MH1ccyosXHMqWyInXVteIiddKlsnIl1ccypcKVxzKjtccypcfVxzKlx9XHMqXH0iO2k6MzU3O3M6MjI5OiI8XD9waHBccypcJFxzKlx7XHMqIlteIl0qIlxzKlx9XHMqXFtccyoiW14iXSoiXHMqXF1ccyo9IlteIl0qIlxzKjtccypcJFx3ezEsNDB9XHMqPSJbXiJdKiJccyo7XCR7Lis/O1xzKkBcJFxzKlx7XHMqXCRcd3sxLDQwfVxzKlx9XHMqXChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqIlteIl0qIlxzKlxdXHMqXClccyo7XHMqZWNob1xzKiJbXiJdKiJccyo7XHMqXD8+IjtpOjM1ODtzOjU3NjoiXCRcd3sxLDQwfVxzKj1ccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqWyInXVteJyJdKlsnIl1ccypcXVxzKjtccyplY2hvXHMqXCRcd3sxLDQwfVxzKj1ccyppc3NldFxzKlwoXHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKidbXiddKidccypcXVxzKlwpXHMqXD9ccypiYXNlNjRfZGVjb2RlXHMqXChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqJ1teJ10qJ1xzKlxdXHMqXClccyo6WyInXVteIiddKlsnIl1ccyo7XHMqXCRcd3sxLDQwfVxzKj1ccypbJyJdW14nIl0qWyciXVxzKjtccypmb3JlYWNoXHMqXChccyphcnJheVxzKlwoXHMqXCRcd3sxLDQwfVxzKlwpXHMqYXNccypcJFx3ezEsNDB9XHMqXClccypce1xzKlwkXHd7MSw0MH1ccypcLlxzKj1cJFx3ezEsNDB9XHMqO1xzKlx9XHMqb2Jfc3RhcnRccypcKFxzKlwkXHd7MSw0MH1ccypcKVxzKjtccyppZlxzKlwoXHMqXCRcd3sxLDQwfVxzKlwpXHMqXHtccyplY2hvXHMqXCRcd3sxLDQwfVxzKjtccypcfVxzKm9iX2VuZF9mbHVzaFxzKlwoXHMqXClccyo7IjtpOjM1OTtzOjI2MDoiaXNzZXRccypcKFxzKlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXHMqXFtccypbJyJdW14nIl0qWyciXVxzKlxdXHMqXClccyomJlxzKlwoXHMqXCRcd3sxLDQwfVxzKj1ccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqWyddW14iJ10qWyciXVxzKlxdXHMqXClccyomJlxzKkBwcmVnX3JlcGxhY2VccypcKFxzKlsnIl1bXiciXSplWyciXVxzKixccypbXixdK1xzKixccypbJ11bXiInXSpbJ11ccypcKVxzKjsiO2k6MzYwO3M6MjA2OiI8XD9waHBccyppc3NldFxzKlwoXHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKidbXiddKidccypcXVxzKlwpXHMqJiZccyphcnJheV9tYXBccypcKFxzKiJbXiJdKiJccyosXHMqXChccyphcnJheVxzKlwpXHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKidbXiddKidccypcXVxzKlwpXHMqO1xzKiI7aTozNjE7czo1MzQ6IlwkXHd7MSw0MH1ccyo9XHMqYmFzZTY0X2RlY29kZVxzKlwoXHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKidbXiddKidccypcXVxzKlwpXHMqO1xzKlwkXHd7MSw0MH1ccyo9XHMqIlteIl0qIlxzKjtccypcJFx3ezEsNDB9XHMqPSJbXiJdKiJccyo7XHMqaGVhZGVyXHMqXChccyoiW14iXSoiXHMqXClccyo7XHMqaGVhZGVyXHMqXChccyoiUHJhZ21hOiBoYWNrIlxzKlwpXHMqO1xzKmhlYWRlclxzKlwoXHMqIlteIl0qIlxzKlwuXHMqXCRcd3sxLDQwfVxzKlwpXHMqO1xzKmhlYWRlclxzKlwoXHMqIlteIl0qIlxzKlwuXHMqXChccypzdHJpbmdccypcKVxzKlwoXHMqZmlsZXNpemVccypcKFxzKlwkXHd7MSw0MH1ccypcKVxzKlwpXHMqXClccyo7XHMqaGVhZGVyXHMqXChccyonW14nXSonXHMqXC5ccypcJFx3ezEsNDB9XHMqXC5ccyonW14nXSonXHMqXClccyo7XHMqaGVhZGVyXHMqXChccyoiW14iXSoiXHMqXClccyo7XHMqcmVhZGZpbGVccypcKFxzKlwkXHd7MSw0MH1ccypcKVxzKjtccypleGl0XHMqOyI7aTozNjI7czoxODI6IjxcP3BocFxzKlwoXHMqXCRcd3sxLDQwfT1AXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKlx3K1xzKlxdXHMqXClccypcLlxzKkBcJFx3ezEsNDB9XHMqXChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqWyInXVteIiddKlsiJ11ccypcXVxzKlwpXHMqXD8+IjtpOjM2MztzOjUxMToiPFw/cGhwXHMqaWZccypcKFxzKm1kNVxzKlwoXHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKlsiJ11bXiInXSpbIiddXHMqXF1ccypcKVxzKj09WyInXVteIiddKlsiJ11ccypcKVxzKlx7XHMqXCRcd3sxLDQwfVxzKj1cJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqJ1teJ10qJ1xzKlxdXHMqO1xzKnN5c3RlbVxzKlwoXHMqXCRcd3sxLDQwfVxzKlwpXHMqO1xzKlwkXHd7MSw0MH1ccyo9XCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKiJbXiJdKiJccypcXVxzKjtccypcJFx3ezEsNDB9XHMqPVxzKmRpcm5hbWVccypcKFxzKl9fRklMRV9fXHMqXClccyo7XHMqZWNob1xzKjxccyo8XHMqPFxzKkhUTUxccyo8XHMqZm9ybVxzKmVuY3R5cGVccyo9IlteIl0qIlxzKm1ldGhvZFxzKj0iW14iXSoiXHMqPlxzKi4rP1xzKlx9XHMqZWxzZVxzKlx7XHMqcHJpbnRccyoiW14iXSoiXHMqO1xzKlx9XHMqXH1ccypcfVxzKiI7aTozNjQ7czo4NzoiPFw/cGhwXHMqaWZcKCgvXCpbXipdK1wqLyk/aXNzZXRcKCgvXCpbXipdK1wqLyk/XCR7KC9cKlteKl0rXCovKT8iXy57MSwyNTB9P2V4aXQ7W159XSt9IjtpOjM2NTtzOjE2OToiaWZccypcKFxzKmlzc2V0XChccypcJHtccypbXn1dK1xzKn1ccypcW1teXF1dK1xdXHMqXClccypcKVxzKntccypcJFx3ezEsNDB9XHMqPVxzKlsiJ2V2YWxiczY0c3J0cHJnbGNcc1wuXSs7XHMqXCRcd3sxLDQwfVxzKlwoXHMqXCR7W159XSt9XHMqXFtbXlxdXStcXVxzKlwpO1xzKmV4aXQ7XHMqfSI7aTozNjY7czozNzE6IigvXCpbXlwqXStcKi8pP2lmKC9cKlteXCpdK1wqLyk/XHMqXCgoL1wqW15cKl0rXCovKT9ccyppc3NldFxzKlwoXHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKidbXiddKidccypcXVxzKigvXCpbXlwqXStcKi8pP1xzKlwpXHMqKC9cKlteXCpdK1wqLyk/XHMqXCkoL1wqW15cKl0rXCovKT9ccypce1xzKigvXCpbXlwqXStcKi8pP1xzKihldmFsfGFzc2VydClccyooL1wqW15cKl0rXCovKT9ccypcKFxzKlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXHMqXFtccyonW14nXSonXHMqXF1ccypcKSgvXCpbXlwqXStcKi8pPztccyooL1wqW15cKl0rXCovKT9leGl0XHMqOygvXCpbXlwqXStcKi8pP1xzKlx9IjtpOjM2NztzOjY1OiI8XD9waHBccypkaWVcKFwkXHd7MSw0MH1cKFwkXHd7MSw0MH1cKFwkXHd7MSw0MH1cKFtefV0rXHMqfVxzKlw/PiI7aTozNjg7czoyNDc6IigvXCpbXipdK1wqLyk/XHMqaWZcKFxzKigvXCpbXipdK1wqLyk/XHMqKC9cKlteKl0rXCovKT9ccyppc3NldFwoXCR7WyInXVtfUkVRVUVTVEdQT1ZDS0ldK1siJ119XFtbXlxdXStcXVwpXCkuKz8sXHMqKC9cKlteKl0rXCovKT9ccypbJyJdK1xzKigvXCpbXipdK1wqLyk/XHMqXClccyooL1wqW14qXStcKi8pP1xzKjtccyooL1wqW14qXStcKi8pP1xzKmV4aXRccyooL1wqW14qXStcKi8pP1xzKjtccyooL1wqW14qXStcKi8pP1xzKn0iO2k6MzY5O3M6MTk4OiIoL1wqW14qXStcKi8pP1xzKmlmXChccyohZnVuY3Rpb25fZXhpc3RzXChbXlwpXStcKVxzKlxzKlwpXHMqeygvXCpbXipdK1wqLyk/XCRHTE9CQUxTLis/KC9cKlteKl0rXCovKT9ccypcKVxzKigvXCpbXipdK1wqLyk/XHMqO1xzKigvXCpbXipdK1wqLyk/XHMqZXhpdFxzKigvXCpbXipdK1wqLyk/XHMqO1xzKigvXCpbXipdK1wqLyk/XHMqfVxzKn0iO2k6MzcwO3M6MTEzOiI8XD9waHBccyplY2hvXHMqWyciXVteJyJdK1snIl07XHMqcHJlZ19yZXBsYWNlXHMqXChbJyJdW14nIl0rWyciXVxzKixccypbIl1bXiJdK1siXVxzKixccypbIl1bXiJdK1siXVxzKlwpO1xzKlw/PiI7aTozNzE7czozMzE6IjxcP3BocFxzKmlmXHMqKC9cKlteXCpdK1wqLyk/XHMqXChccyooL1wqW15cKl0rXCovKT9ccyppc3NldFwoXHMqKC9cKlteXCpdK1wqLyk/XHMqXCRfKEdFVHxQT1NUfENPT0tJRXxSRVFVRVNUfFNFUlZFUilccyooL1wqW15cKl0rXCovKT9ccypcWy4rP1wkXyhHRVR8UE9TVHxDT09LSUV8UkVRVUVTVHxTRVJWRVIpXFtbXlxdXStcXVwpXHMqKC9cKlteXCpdK1wqLyk/XHMqO1xzKigvXCpbXlwqXStcKi8pP1xzKmV4aXRcKFxzKigvXCpbXlwqXStcKi8pP1xzKlwpXHMqKC9cKlteXCpdK1wqLyk/XHMqO1xzKigvXCpbXlwqXStcKi8pP1xzKn1ccyooL1wqW15cKl0rXCovKT9ccypcPz4iO2k6MzcyO3M6MTUzOiI8XD9waHBccypcJFx3ezEsNDB9XHMqPVxzKlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXHMqXFtccyonW14nXSonXHMqXF1ccyo7XHMqZWNob1xzKmZpbGVfZ2V0X2NvbnRlbnRzXHMqXChccyoiW14iXSoiXHMqXClccyo7XHMqZXhpdFxzKjtccypcPz4iO2k6MzczO3M6NjY6IjxcP3BocFxzK2V2YWxcKFxzKmJhc2U2NF9kZWNvZGVcKFxzKiJbXiJdezIwMDAsfSJccypcKVxzKlwpO1xzK1w/PiI7aTozNzQ7czozMTc6IjxcP3BocFxzKkBlcnJvcl9yZXBvcnRpbmdccypcKFxzKlxkK1xzKlwpXHMqO1xzKlwkXHd7MSw0MH1ccyo9XHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKlsnIl1bXiInXSpbJyJdXHMqXF1ccyo7XHMqaWZccypcKFxzKmlzc2V0XHMqXChccypcJFx3ezEsNDB9XHMqXClccypcKVxzKlx7XHMqZXZhbFxzKlwoXHMqYmFzZTY0X2RlY29kZVxzKlwoXHMqWyciXVteJyJdKlsnIl1ccypcKVxzKlwpXHMqO1xzKlx9XHMqZWxzZVxzKlx7XHMqZWNob1xzKmJhc2U2NF9kZWNvZGVccypcKFxzKlx3K1xzKlwpXHMqO1xzKlx9XHMqXD8+IjtpOjM3NTtzOjY2OiI8XD9waHBccypcJHsiXFx4W14iXSsifVxbIlteIl0rIlxdPS4rP1wpO1xzKmV4aXRcKFxzKlwpO1xzKn1ccypcPz4iO2k6Mzc2O3M6MjY3OiI8XHMqXD9ccyppZlxzKlwoXHMqXCRfRklMRVNcWydGMWwzJ1xdXHMqXClccypce1xzKm1vdmVfdXBsb2FkZWRfZmlsZVxzKlwoXHMqXCRcd3sxLDQwfVxzKlxbXHMqJ1teJ10qJ1xzKlxdXHMqXFtccyonW14nXSonXHMqXF1ccyosXHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKidbXiddKidccypcXVxzKlwpXHMqO1xzKmVjaG9ccyonW14nXSonXHMqO1xzKlx9XHMqZWxzZVxzKlx7XHMqZWNob1xzKidbXiddKidccyo7XHMqXH1ccypcPz4iO2k6Mzc3O3M6MTQ1OiJcJFx3ezEsNDB9XHMqPSJbXiJdKiJccyo7XHMqc3ByaW50ZlxzKlwoXHMqYmFzZTY0X2RlY29kZVxzKlwoXHMqZ3p1bmNvbXByZXNzXHMqXChccypiYXNlNjRfZGVjb2RlXHMqXChccypcJFx3ezEsNDB9XHMqXClccypcKVxzKlwpXHMqXClccyo7XHMqXD8+IjtpOjM3ODtzOjkzOiI8XD9waHBccypldmFsXHMqXChccyp0cmltXHMqXChccypiYXNlNjRfZGVjb2RlXHMqXChccypbIiddW14nIl0qWyciXVxzKlwpXHMqXClccypcKVxzKjtccypcPz4iO2k6Mzc5O3M6MTcyOiI8XD9waHBccypcJFx3ezEsNDB9XHMqPSJbXiJdKiJccyo7XHMqXCRcd3sxLDQwfVxzKj1ccypiYXNlNjRfZGVjb2RlXHMqXChccypcJFx3ezEsNDB9XHMqXClccyo7XHMqaWZccypcKFxzKlwkXHd7MSw0MH1ccypcKVxzKlx7XHMqZXZhbFxzKlwoXHMqXCRcd3sxLDQwfVxzKlwpXHMqO1xzKlx9XHMqXD8+IjtpOjM4MDtzOjE0OToiY2xhc3NccytHZXRfbGlua3Nccyp7XHMqdmFyXHMqXCRob3N0XHMqPS4rPyhyZXR1cm5ccyonPCEtLWxpbmsgZXJyb3ItLT4nO1xzKn1ccyp9fFwkZGF0YSA9IGZpbGVfZ2V0X2NvbnRlbnRzXChcJGZpbGVcKTtccypyZXR1cm4gXCRkYXRhO1xzKn1ccyp9XHMqfSkiO2k6MzgxO3M6MTUwOiJcJFx3ezEsNDB9XHMqPVxzKm5ld1xzKkdldF9saW5rc1xzKlwoXHMqXClccyo7XHMqXCRcd3sxLDQwfVxzKj1ccypcJFx3ezEsNDB9LVxzKj5ccypyZXR1cm5fbGlua3NccypcKFxzKlwkXHd7MSw0MH1ccypcKVxzKjtccyplY2hvXHMqXCRcd3sxLDQwfVxzKjtccyoiO2k6MzgyO3M6MjA1OiJkZWZpbmVccypcKFxzKidbXiddKidccyosXHMqY2xhc3NfZXhpc3RzXHMqXChccypbJyJdQ09NWyciXVxzKlwpXHMqXD9ccyoxXHMqOlxzKjBccypcKVxzKjtccypkZWZpbmVccypcKFxzKidQSFBJTkZPX0lTJ1xzKixccypcKFxzKiFlcmVnaVxzKlwoXHMqIlteIl0qIlxzKixccypcJFx3ezEsNDB9XHMqXClccypcKVxzKlw/XHMqMVxzKjpccyowXHMqXClccyo7IjtpOjM4MztzOjIxNzoiPFw/cGhwXHMqXCRcd3sxLDQwfVxzKj1ccyoiW14iXSoiXHMqO1xzKlwkXHd7MSw0MH1ccyo9XHMqbWQ1XHMqXChccypcJFx3ezEsNDB9XHMqXC5ccyoiW14iXSoiXHMqXClccyo7XHMqZXZhbFxzKlwoXHMqZ3p1bmNvbXByZXNzXHMqXChccypzdHJfcm90MTNccypcKFxzKmJhc2U2NF9kZWNvZGVccypcKFxzKidbXiddKidccypcKVxzKlwpXHMqXClccypcKVxzKjtccypleGl0XHMqOyI7aTozODQ7czo1ODY6IjxcP3BocFxzKmNsYXNzXHMqXHcrXHMqXHtccypwdWJsaWNccypmdW5jdGlvblxzKl9fY29uc3RydWN0XHMqXChccypcKVxzKlx7XHMqXCRcd3sxLDQwfVxzKj1ccypAXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKlsnIl1bXiciXSpbJyJdXHMqXF1ccyo7XHMqaWZccypcKFxzKlwkXHd7MSw0MH1ccypcKVxzKlx7XHMqXCRcd3sxLDQwfVxzKj1ccypcJFx3ezEsNDB9XHMqXChccypAXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKlsnIl1bXiciXSpbJyJdXHMqXF1ccypcKVxzKjtccypcJFx3ezEsNDB9XHMqPVxzKlwkXHd7MSw0MH1ccypcKFxzKkBcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqJ1teJ10qJ1xzKlxdXHMqXClccyo7XHMqXCRcd3sxLDQwfVxzKlwoXHMqWyInXVteJyJdKlsiJ11ccyosXHMqXCRcd3sxLDQwfVxzKixccyo0MzhccypcKVxzKjtccypcfVxzKmVsc2Vccypce1xzKmhlYWRlclxzKlwoXHMqWyInXVteJyJdKlsiJ11ccypcKVxzKjtccypcfVxzKlx9XHMqXH1ccypcJFx3ezEsNDB9XHMqPVxzKm5ld1xzKlx3K1xzKjtccyoiO2k6Mzg1O3M6MTkwOiI8XD9waHBccypcJFxzKlx7XHMqIlteIl0qIlxzKlx9XHMqXFtccyoiW14iXSoiXHMqXF1ccyo9IlteIl0qIlxzKjsuKz9ccyo7XHMqZXZhbFxzKlwoXHMqXCRccypce1xzKlwkXHMqXHtccyoiW14iXSoiXHMqXH1ccypcW1xzKiJbXiJdKiJccypcXVxzKlx9XHMqXFtccyoiW14iXSoiXHMqXF1ccypcKVxzKjtccypcfVxzKlx9XHMqXD8+IjtpOjM4NjtzOjI3NDoiaWZccypcKFxzKnN0cmlwb3NccypcKFxzKkBcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqXHcrXHMqXChccyonW14nXSonXHMqLFxzKlxkK1xzKlwpXHMqXF1ccyosXHMqXHcrXHMqXChccypbJyJdW14nIl0qWyciXVxzKixccypcZCtccypcKVxzKlwpXHMqPT09XHMqZmFsc2VccypcKVxzKlx7Lis/YWRkX2FjdGlvblxzKlwoXHMqXHcrXHMqXChccypbJyJdW14nIl0qWyciXVxzKixccypcdytccypcKVxzKixccypbIiddW14nIl0qWyInXVxzKlwpXHMqOyI7aTozODc7czo5MjoiXCovXHMqWyInXShcXHgyZnwvKVtcXFwtXCpcc2EtekEtWjAtOV8vXC5dKz8oXC58XFx4MmUpKHB8XFx4NzApKGh8XFx4NjgpKHB8XFx4NzApWyInXTtccyovXCoiO2k6Mzg4O3M6MTc3OiI8XD9waHBccypcJFx3ezEsNDB9XHMqPV9fRklMRV9fXHMqO1xzKlwkXHd7MSw0MH1ccyo9X19MSU5FX19ccyo7XHMqXCRcd3sxLDQwfVxzKj1ccypcZCtccyo7XHMqZXZhbFxzKlwoXHMqXChccypiYXNlNjRfZGVjb2RlXHMqXChccyonW14nXSonXHMqXClccypcKVxzKlwpXHMqO1xzKnJldHVyblxzKjtccypcPz4iO2k6Mzg5O3M6MTk4OiI8XD9waHBccyovXCpbXipdK1wqL1xzKlwkXHcrXHMqPVsnIl1bXiciXStbJyJdO1xzKlwkXHcrXHMqPVxzKnN0cl9yb3QxM1xzKlwoXHMqZ3ppbmZsYXRlXHMqXChccypzdHJfcm90MTNccypcKFxzKmJhc2U2NF9kZWNvZGVccypcKFxzKlwkXHcrXHMqXClccypcKVxzKlwpXHMqXClccyo7XHMqZXZhbFxzKlwoXHMqXCRcdytccypcKVxzKjtccypcPz4iO2k6MzkwO3M6NDg4OiJcJFx3ezEsNDB9XHMqPVxzKlsnIl1bXjtdKztccypcJFx3ezEsNDB9XHMqPShcJFx3ezEsNDB9XHMqXFtccypcZCtccypcXVxzKlwuXHMqKXsyLH1cJFx3ezEsNDB9XHMqXFtccypcZCtccypcXVxzKjtccypcJFx3ezEsNDB9XHMqPShcJFx3ezEsNDB9XHMqXFtccypcZCtccypcXVxzKlwuXHMqKXsyLH1cJFx3ezEsNDB9XHMqXFtccypcZCtccypcXVxzKjtccyppZlxzKlwoXHMqaXNzZXRccypcKFxzKlwkXHMqXHtccyooXCRcd3sxLDQwfVxzKlxbXHMqXGQrXHMqXF1ccypcLj9ccyopezIsfVxzKn1ccypcW1xzKlwkXHd7MSw0MH1ccypcKFxzKihcJFx3ezEsNDB9XHMqXFtccypcZCtccypcXVxzKlwuP1xzKil7Mix9XHMqXClccypcXVxzKlwpXHMqXClccyp7XHMqZXZhbFxzKlwoXHMqXCRccypce1xzKihcJFx3ezEsNDB9XHMqXFtccypcZCtccypcXVxzKlwuP1xzKil7Mix9fVxbXCRcd3sxLDQwfVxzKlwoKFwkXHcrXFtcZCtcXVxzKlwuPyl7Mix9XCldXCk7fSI7aTozOTE7czoxODA6ImlmXHMqXChccyppc3NldFxzKlwoXHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKidbXiddKidccypcXVxzKlwpXHMqXClccypce1xzKmV2YWxccypcKFxzKlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXHMqXFtccyonW14nXSonXHMqXF1ccypcKVxzKjtccypcfVxzKiI7aTozOTI7czoyODA6IlwkXHd7MSw0MH1ccyo9XHMqKFsnIl1bXiInXSpbJyJdXHMqXC5ccyopK1snIl1bXiInXStbJyJdOy4rP2Z1bmN0aW9uXHMqXHcrXHMqXChccypcJFx3ezEsNDB9XHMqLFxzKlwkXHd7MSw0MH1ccypcKVxzKlx7XHMqcmV0dXJuXHMqXCRcd3sxLDQwfVxzKlxeXHMqc3RyX3JlcGVhdFxzKlwoXHMqXCRcd3sxLDQwfVxzKixccypjZWlsXHMqXChccypzdHJsZW5ccypcKFxzKlwkXHd7MSw0MH1ccypcKVxzKi9ccypzdHJsZW5ccypcKFxzKlwkXHd7MSw0MH1ccypcKVxzKlwpXHMqXClccyo7XHMqXH0iO2k6MzkzO3M6MTk4OiI8XHMqXD9ccypyZXF1aXJlXHMqXChccypcJF9TRVJWRVJccypcW1xzKiJbXiJdKiJccypcXVxzKlwuXHMqIlteIl0qIlxzKlwpXHMqO1xzKmdsb2JhbFxzKlwkXHd7MSw0MH1ccyo7XHMqXCRcd3sxLDQwfS1ccyo+XHMqQXV0aG9yaXplXHMqXChccypbXildK1wpXHMqO1xzKkxvY2FsUmVkaXJlY3RccypcKFxzKiJbXiJdKiJccypcKVxzKjtccypcPz4iO2k6Mzk0O3M6NTU4OiJmdW5jdGlvblxzKlx3K1xzKlwoXHMqXCRcd3sxLDQwfVxzKixccypcJFx3ezEsNDB9XHMqXClccypce1xzKlwkXHd7MSw0MH1ccyo9XHMqWyciXVteJyJdKlsnIl1ccyo7XHMqZm9yXHMqXChccypcJFx3ezEsNDB9XHMqPVxzKlxkK1xzKjtccypcJFx3ezEsNDB9XHMqPFxzKnN0cmxlblxzKlwoXHMqXCRcd3sxLDQwfVxzKlwpXHMqO1xzKlwkXHd7MSw0MH1cK1wrXHMqXClccypce1xzKlwkXHd7MSw0MH1ccypcLlxzKj1ccyppc3NldFxzKlwoXHMqXCRcd3sxLDQwfVxzKlxbXHMqXCRcd3sxLDQwfVxzKlxbXHMqXCRcd3sxLDQwfVxzKlxdXHMqXF1ccypcKVxzKlw/XHMqXCRcd3sxLDQwfVxzKlxbXHMqXCRcd3sxLDQwfVxzKlxbXHMqXCRcd3sxLDQwfVxzKlxdXHMqXF1ccyo6XHMqXCRcd3sxLDQwfVxzKlxbXHMqXCRcd3sxLDQwfVxzKlxdXHMqO1xzKlx9XHMqXCRcd3sxLDQwfVxzKj1bIiddW14iJ10qWyInXVxzKjtccypyZXR1cm5ccypcJFx3ezEsNDB9XHMqXChccypcJFx3ezEsNDB9XHMqXClccyo7XHMqXH1ccypcJFx3K1xzKj1ccyooWyciXVteIiddKlsnIl1ccypcLj9ccyopKzsiO2k6Mzk1O3M6MzQ6IjxcP3BocCBlY2hvXHMrXGQrKFsrXC0qXi9dKVxkKztcPz4iO2k6Mzk2O3M6MTEwOiIoPFxzKlw/XHMqZXZhbFxzKlwoXHMqZ3p1bmNvbXByZXNzXHMqXChccypiYXNlNjRfZGVjb2RlXHMqXChccypbJyJdW14nIl0qWyciXVxzKlwpXHMqXClccypcKVxzKjtccypcPz5ccyopezMsfSI7aTozOTc7czo1NToiXCovXHMqKGluY2x1ZGV8cmVxdWlyZXxpbmNsdWRlX29uY2V8cmVxdWlyZV9vbmNlKVxzKi9cKiI7aTozOTg7czoyNDE6IjxcP3BocFxzKi9cKlwqLis/XCpcKi9ccypcJFx3ezEsNDB9XHMqPVxzKiJbXiJdKiJccyo7KFxzKi8vXHMqUGFzc3dvcmRccyopP1wkXHd7MSw0MH09J1teJ10qJ1xzKjtccypcJFx3ezEsNDB9XHMqPVxzKnN0cl9yb3QxM1xzKlwoXHMqZ3ppbmZsYXRlXHMqXChccypiYXNlNjRfZGVjb2RlXHMqXChccypcJFx3ezEsNDB9XHMqXClccypcKVxzKlwpXHMqO1xzKmV2YWxccypcKFxzKlwkXHd7MSw0MH1ccypcKVxzKjtccypcPz4iO2k6Mzk5O3M6NTU4OiI8XD9waHBccypcJFx3ezEsNDB9XHMqPVxzKlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXHMqXFtccyonW14nXSonXHMqXF1ccyo7XHMqaWZccypcKFxzKlwkXHd7MSw0MH1ccyo9PSdbXiddKidccypcKVxzKlx7XHMqXCRcd3sxLDQwfVxzKj1ccypiYXNlNjRfZGVjb2RlXHMqXChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqJ1teJ10qJ1xzKlxdXHMqXClccyo7XHMqXCRcd3sxLDQwfVxzKj1ccypiYXNlNjRfZGVjb2RlXHMqXChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqJ1teJ10qJ1xzKlxdXHMqXClccyo7XHMqXCRcd3sxLDQwfVxzKj1ccypjdXJsX2luaXRccypcKFxzKlwpXHMqOy4rP2N1cmxfY2xvc2VccypcKFxzKlwkXHd7MSw0MH1ccypcKVxzKjtccyppZlxzKlwoXHMqXCRcd3sxLDQwfVxzKlwpXHMqXHtccypwcmludFxzKiJbXiJdKiJccyo7XHMqcHJpbnRccypcJFx3ezEsNDB9XHMqO1xzKlx9XHMqZWxzZVxzKlx7XHMqcHJpbnRccyoiW14iXSoiXHMqO1xzKlx9XHMqXH1ccypcPz4iO2k6NDAwO3M6NTI5OiJpZlxzKlwoXHMqcHJlZ19tYXRjaFxzKlwoXHMqJ1teJ10qJ1xzKixccypcJF9TRVJWRVJccypcW1xzKidIVFRQX1VTRVJfQUdFTlQnXHMqXF1ccypcKVxzKlwpXHMqXHtccypcJFx3ezEsNDB9XHMqPVxzKmN1cmxfaW5pdFxzKlwoXHMqXClccyo7XHMqXCRcd3sxLDQwfVxzKj1ccypcZCtccyo7XHMqY3VybF9zZXRvcHRccypcKFxzKlwkXHd7MSw0MH1ccyosXHMqQ1VSTE9QVF9VUkxccyosXHMqJ1teJ10qJ1xzKlwpXHMqO1xzKmN1cmxfc2V0b3B0XHMqXChccypcJFx3ezEsNDB9XHMqLFxzKkNVUkxPUFRfUkVUVVJOVFJBTlNGRVJccyosXHMqMVxzKlwpXHMqO1xzKmN1cmxfc2V0b3B0XHMqXChccypcJFx3ezEsNDB9XHMqLFxzKkNVUkxPUFRfQ09OTkVDVFRJTUVPVVRccyosXHMqXCRcd3sxLDQwfVxzKlwpXHMqO1xzKlwkXHd7MSw0MH1ccyo9XHMqY3VybF9leGVjXHMqXChccypcJFx3ezEsNDB9XHMqXClccyo7XHMqY3VybF9jbG9zZVxzKlwoXHMqXCRcd3sxLDQwfVxzKlwpXHMqO1xzKmVjaG9ccypcJFx3ezEsNDB9XHMqO1xzKlx9IjtpOjQwMTtzOjExNjI6IlwkXHd7MSw0MH1ccyo9J1teJ10qJ1xzKjtccyppZlxzKlwoXHMqcHJlZ19tYXRjaFxzKlwoXHMqJ1teJ10qJ1xzKixccypcJF9TRVJWRVJccypcW1xzKidbXiddKidccypcXVxzKlwpXHMqXClccypce1xzKlwkXHd7MSw0MH1ccyo9XHMqXCRcd3sxLDQwfS1ccyo+XHMqc3VwZXJfcXVlcnlccypcKFxzKiJbXiJdKiJccypcLlxzKlBSRUZJWFxzKlwuXHMqIlteIl0qIlxzKixccyp0cnVlXHMqXClccyo7XHMqXCRcd3sxLDQwfVxzKj1ccypleHBsb2RlXHMqXChccyonW14nXSonXHMqLFxzKlwkXHd7MSw0MH1ccypcW1xzKlxkK1xzKlxdXHMqXFtccyonW14nXSonXHMqXF1ccypcKVxzKjtccyppZlxzKlwoXHMqXChccypcKFxzKlwkXHd7MSw0MH1ccypcW1xzKlxkK1xzKlxdXHMqXCs4NjQwMFxzKlwpXHMqPFxzKnRpbWVccypcKFxzKlwpXHMqXClccypcfFx8IVwkXHd7MSw0MH1ccypcW1xzKlxkK1xzKlxdXHMqXClccypce1xzKlwkXHd7MSw0MH1ccyo9QGZpbGVfZ2V0X2NvbnRlbnRzXHMqXChccypiYXNlNjRfZGVjb2RlXHMqXChccyonW14nXSonXHMqXClccypcKVxzKjtccyppZlxzKlwoXHMqIVwkXHd7MSw0MH1ccypcKVxzKlx7XHMqXCRcd3sxLDQwfVxzKj1cJFx3ezEsNDB9XHMqXFtccypcZCtccypcXVxzKjtccypcfVxzKlwkXHd7MSw0MH0tXHMqPlxzKnF1ZXJ5XHMqXChccyoiW14iXSoiXHMqXC5ccypQUkVGSVhccypcLlxzKiJbXiJdKiJccypcKVxzKjtccypcJFx3ezEsNDB9LVxzKj5ccypxdWVyeVxzKlwoXHMqIlteIl0qIlxzKlwuXHMqUFJFRklYXHMqXC5ccyoiW14iXSoiXHMqXC5ccyp0aW1lXHMqXChccypcKVxzKlwuXHMqIlteIl0qIlxzKlwuXHMqXCRcd3sxLDQwfS1ccyo+XHMqc2FmZXNxbFxzKlwoXHMqXCRcd3sxLDQwfVxzKlwpXHMqXC5ccyoiW14iXSoiXHMqXClccyo7XHMqXCRcd3sxLDQwfVxzKj1ccypcKFxzKmJhc2U2NF9kZWNvZGVccypcKFxzKidbXiddKidccypcKVxzKlwpXHMqXC5ccypcJF9TRVJWRVJccypcW1xzKidbXiddKidccypcXVxzKjtccypAZmlsZV9nZXRfY29udGVudHNccypcKFxzKlwkXHd7MSw0MH1ccypcKVxzKjtccypcJFx3ezEsNDB9XHMqPVwkXHd7MSw0MH1ccyo7XHMqXH1ccyplbHNlXHMqXHtccypcJFx3ezEsNDB9XHMqPVxzKlwkXHd7MSw0MH1ccypcW1xzKlxkK1xzKlxdXHMqO1xzKlx9XHMqXH0iO2k6NDAyO3M6NjM3OiJpZlxzKlwoXHMqaXNzZXRccypcKFxzKlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXHMqXFtccyonW14nXSonXHMqXF1ccypcKVxzKkFORFxzKiFpc3NldFxzKlwoXHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKiJbXiJdKiJccypcXVxzKlwpXHMqXClccypce1xzKnNldGNvb2tpZVxzKlwoXHMqIlteIl0qIlxzKixccyoiW14iXSoiXHMqLFxzKnRpbWVccypcKFxzKlwpXHMqXCtcZCtccypcKVxzKjtccypcJFx3ezEsNDB9XHMqPVxzKmFycmF5XHMqXChbXildK1wpXHMqO1xzKmZvclxzKlwoXHMqXCRcd3sxLDQwfVxzKj1ccypcZCtccyo7XHMqXCRcd3sxLDQwfVxzKjxccypjb3VudFxzKlwoXHMqXCRcd3sxLDQwfVxzKlwpXHMqO1xzKlwkXHd7MSw0MH1cK1wrXHMqXClccyppZlxzKlwoXHMqc3RycG9zXHMqXChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqJ1teJ10qJ1xzKlxdXHMqLFxzKlwkXHd7MSw0MH1ccypcW1xzKlwkXHd7MSw0MH1ccypcXVxzKlwpXHMqIT09XHMqZmFsc2VccypcKVxzKlx7XHMqaWZccypcKFxzKmlzX21vYmlsZVxzKlwoXHMqXClccypcKVxzKmV4aXRccypcKFxzKidbXiddKidccypcKVxzKjtccypcfVxzKlx9IjtpOjQwMztzOjQ3MToiaWZccypcKFxzKmlzc2V0XHMqXChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqIlteIl0qIlxzKlxdXHMqXClccyomJlxzKmlzc2V0XHMqXChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqIlteIl0qIlxzKlxdXHMqXClccypcKVxzKlx7XHMqXCRcd3sxLDQwfVxzKj1ccypmb3BlblxzKlwoXHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKiJbXiJdKiJccypcXVxzKixccyoiW14iXSoiXHMqXClccyo7XHMqZnB1dHNccypcKFxzKlwkXHd7MSw0MH1ccyosXHMqYmFzZTY0X2RlY29kZVxzKlwoXHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKiJbXiJdKiJccypcXVxzKlwpXHMqXClccyo7XHMqZmNsb3NlXHMqXChccypcJFx3ezEsNDB9XHMqXClccyo7XHMqcHJpbnRccyoiW14iXSoiXHMqO1xzKlx9IjtpOjQwNDtzOjE0NjoiKFwkXHcrXHMqPVxzKlteO10rXHMqO1xzKikrQFwkXHcrXHMqXChccypAXCRcdytccypcKFxzKkBcJFx3K1xzKlwoXCRfKEdFVHxQT1NUfENPT0tJRXxSRVFVRVNUfFNFUlZFUilcW1teXV0rXF1ccypcKVxzKlwpXHMqXClccyo7XHMqZGllKFwoXCkpP1xzKjsiO2k6NDA1O3M6Mzk4OiI8XD9waHBccyppZlxzKlwoXHMqIlteIl0qIj09XCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKiJbXiJdKiJccypcXVxzKlwpXHMqXHtccyplY2hvXHMqIlteIl0qIlxzKjtccypcfVxzKmlmXHMqXChccyppc191cGxvYWRlZF9maWxlXHMqXChccypcJFx3ezEsNDB9XHMqXFtccyoiW14iXSoiXHMqXF1ccypcW1xzKiJbXiJdKiJccypcXVxzKlwpXHMqXClccypce1xzKm1vdmVfdXBsb2FkZWRfZmlsZVxzKlwoXHMqXCRcd3sxLDQwfVxzKlxbXHMqIlteIl0qIlxzKlxdXHMqXFtccyoiW14iXSoiXHMqXF1ccyosXHMqXCRcd3sxLDQwfVxzKlxbXHMqIlteIl0qIlxzKlxdXHMqXFtccyoiW14iXSoiXHMqXF1ccypcKVxzKjtccyplY2hvXHMqIlteIl0qIlxzKjtccypcfVxzKlw/PiI7aTo0MDY7czoxNjA6IjxcPyhwaHApP1xzKkA/cHJlZ19yZXBsYWNlXChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxbXHMqW15dXStcXVxzKixccyogXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClcW1xzKlteXV0rXF1ccyosXHMqWyciXVsnIl1ccypcKTtccypcPz4iO2k6NDA3O3M6MjExOiJpZlxzKlwoXHMqaXNzZXRccypcKFxzKlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXHMqXFtccyoiW14iXSoiXHMqXF1ccypcKVxzKlwpXHMqXHtccypldmFsXHMqXChccypmaWxlX2dldF9jb250ZW50c1xzKlwoXHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKiJbXiJdKiJccypcXVxzKlwpXHMqXClccyo7XHMqXH1ccyo7IjtpOjQwODtzOjE0MToiPFw/cGhwXHMrXCRcdytccyo9XHMqXCRfU0VSVkVSXFtbXl1dK1xdXHMqXC5ccypbIiddW14iXStbIiddXHMqO1xzKmluY2x1ZGVccypcJFx3K1xzKlwuXHMqWyInXVteIl0rWyInXTtccyogU21hcnR5Mzo6cmVkaXJlY3RcKFteKV0rXCk7XHMqXD8+IjtpOjQwOTtzOjQ1MjoiaWZccypcKFxzKm1kNVxzKlwoXHMqQFwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXHMqXFtccyoiW14iXSoiXHMqXF1ccypcKVxzKj09XHMqIlteIl0qIlxzKlwpXHMqXHtccypwcmludFxzKiJbXiJdKiJccyo7XHMqXCRcd3sxLDQwfVxzKj1ccyoiW14iXSoiXHMqO1xzKlwkXHd7MSw0MH1ccyo9XHMqXCRcd3sxLDQwfVxzKlwuXHMqYmFzZW5hbWVccypcKFxzKlwkXHd7MSw0MH1ccypcW1xzKidbXiddKidccypcXVxzKlxbXHMqJ1teJ10qJ1xzKlxdXHMqXClccyo7XHMqXCRcd3sxLDQwfVxzKj1ccypcZCtccyo7XHMqaWZccypcKFxzKm1vdmVfdXBsb2FkZWRfZmlsZVxzKlwoXHMqXCRcd3sxLDQwfVxzKlxbXHMqJ1teJ10qJ1xzKlxdXHMqXFtccyonW14nXSonXHMqXF1ccyosXHMqXCRcd3sxLDQwfVxzKlwpXHMqXClccypce1xzKmVjaG9ccyoiW14iXSoiXHMqO1xzKlx9XHMqXH0iO2k6NDEwO3M6Njg6IjxcP3BocFxzKkBhc3NlcnRccypcKFxzKnN0cl9yb3QxM1xzKlwoXHMqJ1teJ10rJ1xzKlwpXHMqXClccyo7XHMqXD8+IjtpOjQxMTtzOjIxMToiXCRcd3sxLDEwfVxzKj1ccypBcnJheVxzKlwoXHMqc3RyX3JvdDEzXHMqXChbXjtdKztccypcJFx3ezEsNDB9XHMqPVxzKkFycmF5XHMqXChbXjtdKztccypAXCRcd3sxLDQwfVxzKlxbXHMqY2hyXHMqXChccypcZCtccypcKVxzKlxdXHMqXChccypcJFx3ezEsNDB9XHMqXFtccypjaHJccypcKFxzKlxkK1xzKlwpXHMqXF1ccypcKFxzKiJbXiJdKiJccypcKVxzKlwpXHMqOyI7aTo0MTI7czoyNDk6Imlnbm9yZV91c2VyX2Fib3J0XHMqXChccyp0cnVlXHMqXClccyo7XHMqc2V0X3RpbWVfbGltaXRccypcKFxzKlxkK1xzKlwpXHMqO1xzKkBpbmlfc2V0XHMqXChccyonW14nXSonXHMqLFxzKk5VTExccypcKVxzKjtccypAaW5pX3NldFxzKlwoXHMqJ1teJ10qJ1xzKixccyowXHMqXClccyo7XHMqZnVuY3Rpb25ccypnZXRVUkwuKz9nZXRVUkxccypcKFxzKlwkXHd7MSw0MH1ccypcKVxzKjtccypcfVxzKmV4aXRccyo7XHMqXH1ccypcfVxzKiI7aTo0MTM7czoyMTc6ImlmXHMqXChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqIlteIl0qIlxzKlxdXHMqPT0iW14iXSoiXHMqXClccypce1xzKmV2YWxccypcKFxzKmJhc2U2NF9kZWNvZGVccypcKFxzKlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXHMqXFtccyoiW14iXSoiXHMqXF1ccypcKVxzKlwpXHMqO1xzKmRpZVxzKlwoXHMqXClccyo7XHMqXH0iO2k6NDE0O3M6MzUxOiJccypcJFx3ezEsNDB9XHMqPVxzKlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXHMqXFtccyonW14nXSonXHMqXF1ccyo7XHMqXCRcd3sxLDQwfVxzKj1ccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqJ1teJ10qJ1xzKlxdXHMqO1xzKlwkXHd7MSw0MH1ccyo9XHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKidbXiddKidccypcXVxzKjtccypcJFx3ezEsNDB9XHMqPVxzKmljb252XHMqXChccyoiW14iXSoiXHMqLFxzKiJbXiJdKiJccyosXHMqZmlsZV9nZXRfY29udGVudHNccypcKFxzKiJodHRwOi8vW14iXSoiXHMqXClccypcKVxzKjsiO2k6NDE1O3M6NzY6IjxcP3BocHNcKkA/YXNzZXJ0XChAP2Jhc2U2NF9kZWNvZGVcKEA/c3RyX3JvdDEzXChcJF9QT1NUXFsiZGF0YSJcXVwpXClcKTtcPz4iO2k6NDE2O3M6MjA3OiJmdW5jdGlvblxzKlx3ezEsNDB9XHMqXChccypcJFx3ezEsNDB9XHMqXClccypce1xzKlwkXHd7MSw0MH1ccyo9XHMqXGQrXHMqO1xzKlwkXHd7MSw0MH1ccyo9XHMqXGQrXHMqO1xzKlwkXHd7MSw0MH1ccyo9XHMqYXJyYXlccypcKFxzKlwpXHMqOy4rPztccypldmFsXHMqXChccypcdytccypcKFxzKlwkXHd7MSw0MH1ccypcKFxzKiJbXiJdKyJccyooXClccyopKzsiO2k6NDE3O3M6NTAwOiJpZlxzKlwoXHMqXChccyppc3NldFxzKlwoXHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKidbXiddKidccypcXVxzKlwpXHMqXClccyomJlxzKlwoXHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKidbXiddKidccypcXVxzKj09XHMqWyciXTFbJyJdXHMqXClccypcKVxzKlx7XHMqXD8+Lis/c2NhbmRpclxzKlwoXHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKidbXiddKidccypcXVxzKlwpXHMqO1xzKmZvclxzKlwoXHMqXCRcd3sxLDQwfVxzKj1ccypcZCtccyo7XHMqXCRcd3sxLDQwfVxzKjxccyo9XHMqY291bnRccypcKFxzKlwkXHd7MSw0MH1ccypcKVxzKjtccypcJFx3ezEsNDB9XCtcK1xzKlwpXHMqXHtccyplY2hvXHMqXCRcd3sxLDQwfVxzKlxbXHMqXCRcd3sxLDQwfVxzKlxdXHMqXC5ccyoiW14iXSoiXHMqO1xzKlx9XHMqXH1ccypleGl0XHMqXChccypcKVxzKjtccypcfSI7aTo0MTg7czoxMzU6ImlmXHMqXChccypcJF9SRVFVRVNUXFtccypcXFwnLlxcXCdccypcXVxzKlwpXHMqe1xzKmV2YWxcKFxzKnN0cmlwc2xhc2hlc1woXHMqXCRfUkVRVUVTVFxbXHMqXFxcJy5cXFwnXHMqXF1ccypcKVxzKlwpO1xzKmRpZVwoXHMqXCk7XHMqfSI7aTo0MTk7czo1MzA6IjxcP3BocFxzKlwkXHd7MSw0MH1ccyo9XHMqXCRfUE9TVFxzKlxbXHMqJ1teJ10qJ1xzKlxdXHMqO1xzKmlmXHMqXChccyohXCRcd3sxLDQwfVxzKlwpXHMqXCRcd3sxLDQwfVxzKj1ccyoiW14iXSoiXHMqO1xzKlwkXHd7MSw0MH1ccyo9XHMqcnRyaW1ccypcKFxzKlwkXHd7MSw0MH1ccyosXHMqIlteIl0qIlxzKlwpXHMqO1xzKlwkXHd7MSw0MH1ccyo9XHMqXCRcd3sxLDQwfVxzKlxbXHMqJ1teJ10qJ1xzKlxdXHMqXFtccyonW14nXSonXHMqXF1ccyo7XHMqXCRcd3sxLDQwfVxzKj1ccypcJFx3ezEsNDB9XHMqXFtccyonW14nXSonXHMqXF1ccypcW1xzKidbXiddKidccypcXVxzKjtccypAbW92ZV91cGxvYWRlZF9maWxlXHMqXChccypcJFx3ezEsNDB9XHMqLFxzKlwkXHd7MSw0MH1ccypcLlxzKiJbXiJdKiJccypcLlxzKlwkXHd7MSw0MH1ccypcKVxzKlw/XHMqcHJpbnRccyoiW14iXSoiXHMqOlxzKnByaW50XHMqWyInXVteIiddKlsiJ11ccyo7XHMqXH1ccyovXCpbXlwqXStcKi9ccypwcmludFxzKlsnIl1bXiddK1snIl1ccyo7IjtpOjQyMDtzOjQwMToiZnVuY3Rpb25ccypfcGFyc2VSZXFSb3V0ZVxzKlwoXHMqXCRcd3sxLDQwfVxzKlwpXHMqXHtccyppZlxzKlwoXHMqXCRcd3sxLDQwfVxzKj1ccypKUmVxdWVzdDo6Z2V0VmFyXHMqXChccyonW14nXSonXHMqXClccypBTkRccyptZDVccypcKFxzKlwkX1NFUlZFUlxzKlxbXHMqJ1teJ10qJ1xzKlxdXHMqXClccyo9PVxzKidbXiddKidccypcKVxzKlx7XHMqXCRcd3sxLDQwfVxzKj1ccyoiW14iXSoiXHMqO1xzKmlmXHMqXChccypAXCRcd3sxLDQwfVxzKlwoXHMqZ2V0X21hZ2ljX3F1b3Rlc19ncGNccypcKFxzKlwpXHMqXD9ccypzdHJpcHNsYXNoZXNccypcKFxzKlwkXHd7MSw0MH1ccypcKVxzKjpccypcJFx3ezEsNDB9XHMqXClccypcKVxzKlx7XHMqcmV0dXJuXHMqdHJ1ZVxzKjtccypcfVxzKlx9XHMqXH0iO2k6NDIxO3M6MzIyOiI8XD9waHBccypldmFsXHMqXChccypnemluZmxhdGVccypcKFxzKmJhc2U2NF9kZWNvZGVccypcKFxzKiJbXiJdKiJccypcKVxzKlwpXHMqXClccyo7KFxzKmV2YWxccypcKFxzKlwkXHd7MSw0MH1ccypcKFxzKlwkXHd7MSw0MH1ccypcKFxzKiJbXiJdKiJccypcKVxzKlwpXHMqXClccyo7XHMqZXZhbFxzKlwoXHMqXCRcd3sxLDQwfVxzKlwoXHMqXCRcd3sxLDQwfVxzKlwoXHMqIlteIl0qIlxzKlwpXHMqXClccypcKVxzKjtccyopK1xzKmV2YWxccypcKFxzKlwkXHd7MSw0MH1ccypcKFxzKlwkXHd7MSw0MH1ccypcKFxzKiJbXiJdKiJccypcKVxzKlwpXHMqXClccyo7IjtpOjQyMjtzOjk5OiI8XD9waHBccypcJFx3ezEsNDB9XHMqPVxzKidQR1JwZGlbXiddKidccyo7XHMqZWNob1xzKmJhc2U2NF9kZWNvZGVccypcKFxzKlwkXHd7MSw0MH1ccypcKVxzKjtccypcPz4iO2k6NDIzO3M6MTgzOiI8XD8ocGhwKT9ccypcJFx3K1xzKj0oXHMqY2hyXChccypcZCtccypcKVxzKlwuP1xzKikrXHMqO1xzKihccypcJFx3K1xzKj0oXCRcdytcKFxzKlxkK1xzKlwpXHMqXC4/XHMqKXsxMCx9O1xzKil7Mix9XCRcdys9XCRcdytccypcKFxzKlsiJ10rXHMqLFxzKlwkXHcrXHMqXClccyo7XHMqQFwkXHcrXChccypcKTtccypcPz4iO2k6NDI0O3M6Mjg4OiI8XD9waHBccyppZlxzKlwoXHMqaXNzZXRccypcKFxzKlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXHMqXFtccypbIiddW14nIl0qWyInXVxzKlxdXHMqXClccypcKVxzKlx7XHMqXCRcd3sxLDQwfT1ccypleHBsb2RlXHMqXChccypbIl1bXiInXSpbIiddXHMqLFxzKlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXHMqXFtccypbIiddW14iJ10qWyInXVxzKlxdXHMqXClccyo7XHMqQGRpZVxzKlwoXHMqXCRcdytcW1xkK1xdXChcJFx3K1xbXGQrXF1cKVwpO1xzKn1ccypcPz4iO2k6NDI1O3M6MTAyOiI8XD9waHBccypldmFsXHMqXChccypnemluZmxhdGVccypcKFxzKmJhc2U2NF9kZWNvZGVccypcKFxzKihbJyJdW14nIl0qWyciXVxzKlwuP1xzKil7MTUsfVwpXHMqXClccypcKTsiO2k6NDI2O3M6MTg1OiJcJFx3ezEsNDB9XHMqPVxzKkFycmF5XChbXjtdKztcJFx3ezEsNDB9XHMqPVxzKkFycmF5XChbXjtdKztccypAXCRcd3sxLDQwfVxzKlxbXHMqY2hyXHMqXChccypcZCtccypcKVxzKlxdXHMqXChccypcJFx3ezEsNDB9XHMqXFtccypjaHJccypcKFxzKlxkK1xzKlwpXHMqXF1ccypcKFxzKiJbXiJdKiJccypcKVxzKlwpXHMqOyI7aTo0Mjc7czo2MzoiQGFzc2VydFwoQGJhc2U2NF9kZWNvZGVcKEBzdHJfcm90MTNcKFwkX1BPU1RcWyJkYXRhIl1cKVwpXCk7XD8+IjtpOjQyODtzOjc2OiI8XD9waHAuKj9cJFtPbzBfXSo9dXJsZGVjb2RlXCgoLio/O1wkeyIuKj99XFsiLio/XF1cKFwpXDspLio8XC9ib2R5PlxcLio/XD8+IjtpOjQyOTtzOjM2ODoiPFw/cGhwXHMqKGVjaG9bXjtdKzspP1xzKmlmXHMqXChccyppc3NldFxzKlwoXHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKidbXiddKidccypcXVxzKlwpXHMqXClccypce1xzKlwkXHd7MSw0MH1ccyo9XHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKidbXiddKidccypcXVxzKjtccypcJFx3ezEsNDB9XHMqPVxzKmFycmF5XHMqXChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqJ1teJ10qJ1xzKlxdXHMqLFxzKlwpXHMqO1xzKmFycmF5X2ZpbHRlclxzKlwoXHMqXCRcd3sxLDQwfVxzKixccypcJFx3ezEsNDB9XHMqXClccyo7XHMqXH1ccypcPz4iO2k6NDMwO3M6OTI6IjxcP3BocFxzKmVjaG9ccypbXjtdKztccypcJFx3ezEsNDB9XHMrPVteO10rO1xzKkBccypcJFx3ezEsNDB9XHMqXChbXjtdKztbJyJdXHMqXClccyo7XHMqXD8+IjtpOjQzMTtzOjQxODoiPFw/cGhwXHMqaWZccypcKFxzKmlzc2V0XHMqXChccypcJFx3ezEsNDB9XHMqXFtccyonW14nXSonXHMqXF1ccypcKVxzKiYmXHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKidbXiddKidccypcXVxzKj09J1teJ10qJ1xzKlwpXHMqXHtccypcJFx3ezEsNDB9XHMqPVxzKmFycmF5XHMqXChccyonW14pXStcKVxzKjtccyplY2hvXHMqXCRcd3sxLDQwfVxzKlxbXHMqY2hyXHMqXChccypcZCtccypcKVxzKlxdXHMqXChccypcJFx3ezEsNDB9XHMqXFtccyonW14nXSonXHMqXF1ccypcW1xzKidbXiddKidccypcXVxzKixccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqJ1teJ10qJ1xzKlxdXHMqXClccyo7XHMqZXhpdFxzKjtccypcfVxzKlw/PlxzKjxmb3JtLis/PC9mb3JtPiI7aTo0MzI7czoxODE6IjxcP3BocFxzKmVycm9yX3JlcG9ydGluZ1woXHMqRV9BTExccyomXHMqLkVfTk9USUNFXHMqXCk7Lis/ZXhpdFxzKlwoXHMqIj5cfDFcfDwiXHMqXClccyo7XHMqXH1ccypcfVxzKlx9XHMqZWxzZVxzKlx7XHMqaGVhZGVyXHMqXChccyoiW14iXSoiXHMqXClccyo7XHMqZXhpdFxzKlwoXHMqXClccyo7XHMqXH1ccypcPz4iO2k6NDMzO3M6MTA5OiI8XD9waHBccypAPyhhc3NlcnR8ZXZhbClccypcKFxzKlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXHMqXFtccypbJyJdW14iJ10qWyciXVxzKlxdXHMqXClccyo7XHMqXD8+IjtpOjQzNDtzOjkzOiI8XD9waHBccypcJFx3ezEsNDB9XHMqPVxzKiJbXiJdKiJccyo7XHMqZXZhbFxzKlwoXHMqZ3p1bmNvbXByZXNzXHMqXChccyoiW14iXSoiXHMqXClccypcKVxzKjsiO2k6NDM1O3M6MTU4OiI8XD9waHBccypAbW92ZV91cGxvYWRlZF9maWxlXHMqXChccypcJFx3ezEsNDB9XHMqXFtccyonW14nXSonXHMqXF1ccypcW1xzKidbXiddKidccypcXVxzKixccypcJFx3ezEsNDB9XHMqXFtccyonW14nXSonXHMqXF1ccypcW1xzKidbXiddKidccypcXVxzKlwpXHMqO1xzKlw/PiI7aTo0MzY7czozNDI6ImFkZF9maWx0ZXJccypcKFxzKidbXiddKidccyosXHMqJ1teJ10qJ1xzKixccyoxMDAwMVxzKlwpXHMqO1xzKmZ1bmN0aW9uXHMqX2Jsb2dpbmZvXHMqXChccypcJFx3ezEsNDB9XHMqXClccypce1xzKmdsb2JhbFxzKlwkXHd7MSw0MH1ccyo7XHMqaWZccypcKFxzKmlzX3NpbmdsZVxzKlwoXHMqXClccyomJlxzKlwoXHMqXCRcd3sxLDQwfVxzKj1AZXZhbFxzKlwoXHMqZ2V0X29wdGlvblxzKlwoXHMqJ1teJ10qJ1xzKlwpXHMqXClccypcKVxzKiE9PVxzKmZhbHNlXHMqXClccypce1xzKnJldHVyblxzKlwkXHd7MSw0MH1ccyo7XHMqXH1ccyplbHNlXHMqcmV0dXJuXHMqXCRcd3sxLDQwfVxzKjtccypcfSI7aTo0Mzc7czo3NzoiXCgiL3Vzci9sb2NhbC9hcGFjaGUvYmluL2h0dHBkIC1EU1NMIiwiL3NiaW4vc3lzbG9nZCIsIlxbZXRoMFxdIiwiL3NiaW4va2xvZ2QiO2k6NDM4O3M6MzE2OiI8XD9waHBccyplcnJvcl9yZXBvcnRpbmdcKFxkK1wpO1xzKlwkZmlsZW5hbWVccyo9XHMqIlx3KyI7XHMqXCR0YXNrX2lkPSJcdysiO1xzKmlmXChccyohZmlsZV9leGlzdHNcKFwkZmlsZW5hbWVcKVxzKiYmXHMqZnVuY3Rpb25fZXhpc3RzXChccyoicGFyc2VfdXJsIlxzKlwpXHMqJiZccypmdW5jdGlvbl9leGlzdHNcKFxzKiJzb2NrZXRfY3JlYXRlIlxzKlwpLis/XCRmXHMqPVxzKkBmb3BlblwoXHMqXCRmaWxlbmFtZVxzKixccyoidyJccypcKTtccypmY2xvc2VcKFwkZlwpO1xzKn1ccypzb2NrZXRfY2xvc2VcKFxzKlwkZnBccypcKTtccyp9XHMqXD8+IjtpOjQzOTtzOjIxODoiKDxcP3BocFxzKik/aWZccypcKFxzKihjb3B5fG1vdmVfdXBsb2FkZWRfZmlsZSlccypcKFxzKlwkXHd7MSw0MH1ccypcW1xzKlsnIl1bXiciXStbJyJdXHMqXF1ccypcW1xzKlsnIl1bXiciXStbJyJdXHMqXF1ccyosXHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKlsnIl1bXiciXSpbJyJdXHMqXF1ccypcKVxzKlwpXHMqZXhpdFxzKjtccyooXD8+KT8iO2k6NDQwO3M6MTgzOiJpZlxzKlwoXHMqbWQ1XChccypyZXNldFwoXHMqXCRfQ09PS0lFXHMqXClccypcKVxzKj09XHMqJ1x3KydccyomJlxzKmNvdW50XChccypcJF9DT09LSUVccypcKVxzKj5ccypcZCtccypcKVxzKntccypcJF9zZXNzaW9uc19kZWJ1Z19kYXRhLis/dW5saW5rXChccypcJF9zZXNzaW9uX2RlYnVnX3N0cmVhbVxzKlwpO1xzKn0iO2k6NDQxO3M6MjY1OiI8XD9waHBccypcJFxzKlx7XHMqIlteIl0qIlxzKlx9XHMqXFtccyoiW14iXSoiXHMqXF1ccyo9IlteIl0qIlxzKjtccypcJFxzKlx7XHMqIlteIl0qIlxzKlx9XHMqXFtccyoiW14iXSoiXHMqXF1ccyo9Lis/U21hcnR5Mzo6cmVkaXJlY3RccypcKFxzKiJbXiJdKiJccyosXHMqIlteIl0qIlxzKixccyp0cnVlXHMqLFxzKnRydWVccyosXHMqXCRccypce1xzKlwkXHMqXHtccyoiW14iXSoiXHMqXH1ccypcW1xzKiJbXiJdKiJccypcXVxzKlx9XHMqXClccyo7XHMqXD8+IjtpOjQ0MjtzOjc2OiJcLlxzKic8L2Rpdj4nO1xzKlwkXHcrXHMqPVxzKidQR1JwZGlbXiddKyc7XHMqZWNob1xzK2Jhc2U2NF9kZWNvZGVcKFwkXHcrXCk7IjtpOjQ0MztzOjE2NDoiPFxzKlw/XHMqZXJyb3JfcmVwb3J0aW5nXHMqXChccypcZCtccypcKVxzKjtccyphc3NlcnRfb3B0aW9uc1xzKlwoXHMqQVNTRVJUX0FDVElWRVxzKixccyoxXHMqXClccyo7Lis/XCRcd3sxLDQwfVxzKlwoXHMqc3RyX3JvdDEzXHMqXChccyonW14nXSonXHMqXClccypcKVxzKjtccypcPz4iO2k6NDQ0O3M6MTM2OiJcJHBhdGhccyo9XHMqXCRfU0VSVkVSXFsnRE9DVU1FTlRfUk9PVCdcXVxzKlwuXHMqJy91cGxvYWQvXHcrLydcLlNJVEVfSUQuKz9mY2xvc2VcKFwkZnBcKTtccyppbmNsdWRlX29uY2VcKFwkcGF0aFwuIi9mb290ZXJcLnBocCJcKTtccyp9IjtpOjQ0NTtzOjEyMzoiY2xhc3NccypsVHJhbnNtaXRlclxzKntccyp2YXJccypcJHZlcnNpb24uK3JldHVybiBcJHRoaXMtPnJhaXNlX2Vycm9yXCgnPCEtLUVSUk9SOiBVbmFibGUgdG8gdXNlIHRyYW5zcG9ydFwuLS0+J1wpO1xzKn1ccyp9IjtpOjQ0NjtzOjMxOiJcJFVTRVItPkF1dGhvcml6ZVxzKlwoXHMqMVxzKlwpIjtpOjQ0NztzOjcxOiI8XD9ccyppbmNsdWRlXHMqXChccyonLy4rPy9iaXRyaXgvaW1hZ2VzL2libG9jay9pYlwucGhwJ1xzKlwpXHMqO1xzKlw/PiI7aTo0NDg7czo5OToiY2xhc3NccypNTENsaWVudFxzKntccyp2YXJccypcJGZpbGVfY29kZS4rcmV0dXJuICc8IS0tRVJST1I6IFVuYWJsZSB0byB1c2UgdHJhbnNwb3J0XC4tLT4nO1xzKn1ccyp9IjtpOjQ0OTtzOjQ3OiJcJGNsaWVudF9sbmtccyo9XHMqbmV3XHMqTUxDbGllbnRcKFxzKlwkb1xzKlwpOyI7aTo0NTA7czo0MDoiZWNob1xzKlwkY2xpZW50X2xuay0+YnVpbGRfbGlua3NcKFxzKlwpOyI7aTo0NTE7czoxMTI6IihpbmNsdWRlfGluY2x1ZGVfb25jZSlccyooXCgpP1xzKiJcXHgyZlteLl0rXC4ocFxceDY4cHxcXHg3MGhcXHg3MHxcXHg3MGhwfHBcXHg2OFxceDcwfFxceDcwXFx4NjhwKSJccyooXCkpP1xzKjsiO2k6NDUyO3M6ODE6Ii8vXHMqaW5zdGFsbGJnXHMqXCRcd3sxLDQwfT0nW14nXSsnO1xzKnJlcXVpcmVcKCJcJFx3ezEsNDB9IlwpO1xzKi8vXHMqaW5zdGFsbGVuZCI7aTo0NTM7czoxMTg6IlwkYXBwPUpGYWN0b3J5OjpnZXRBcHBsaWNhdGlvblwoXCk7XHMqXCRvcHRpb241PVwkYXBwLitcKFwkbGF5b3V0NT09J2RlZmF1bHQnXClcKXtlY2hvXHMqYmFzZTY0X2RlY29kZVwoJ1teJ10rJ1wpO1xzKn0iO2k6NDU0O3M6MTMzOiJpZlxzKlwoXHMqaXNzZXRcKFwkX1JFUVVFU1RcWydcdysnXVxzKlwpXHMqXClccypkaWVcKFxzKnBpLitldmFsXChccypcJHtccypcJFx3K1xzKn1ccypcWyJbXiJdKyJccypcXVxzKlwpXHMqO1xzKn1ccypleGl0XChccypcKTtccyp9IjtpOjQ1NTtzOjMyNToiXCRccypce1xzKiJbXiJdKiJccypcfVxzKlxbXHMqIlteIl0qIlxzKlxdXHMqPSJbXiJdKiJccyo7XHMqXCRccypce1xzKiJbXiJdKiJccypcfVxzKlxbXHMqIlteIl0qIlxzKlxdXHMqPSJbXiJdKiJccyo7XHMqXCRccypce1xzKlwkXHMqXHtccyoiW14iXSoiXHMqXH1ccypcW1xzKiJbXiJdKiJccypcXVxzKlx9XHMqPV9fRklMRV9fXHMqO1xzKlwkXHMqXHtccypcJFxzKlx7XHMqIlteIl0qIlxzKlx9XHMqXFtccyoiW14iXSoiXHMqXF1ccypcfVxzKj0iW14iXSoiXHMqO1xzKmV2YWxccypcKFxzKmJhc2U2NF9kZWNvZGVccypcKFxzKiJbXiJdKiJccypcKVxzKlwpXHMqOyI7aTo0NTY7czoxMDg6IlwkXHd7MSw0MH1ccyo9XHMqJ1teO10rOyhcJFx3ezEsNDB9XHMqPVxzKihcJFx3ezEsNDB9XFtcZCtcXVwuPyl7Myx9OykrLis/O1wkeyhcJFx3ezEsNDB9XFtcZCtcXVwuPykrfVwoXCk7fSI7aTo0NTc7czozMDI6IlwkXHd7MSw0MH1ccyo9XHMqYXJyYXlccypcKFteKV0rXClccyo7XHMqXCRcd3sxLDQwfVxzKj1ccyppbXBsb2RlXHMqXChccyoiW14iXSoiXHMqLFxzKlwkXHd7MSw0MH1ccypcKVxzKjtccypcJFx3ezEsNDB9XHMqPVxzKiJbXiJdKiJccyo7XHMqXCRcd3sxLDQwfVxzKj1ccyoiW14iXSoiXHMqO1xzKlwkXHd7MSw0MH1ccyo9XHMqIlteIl0qIlxzKjtccypldmFsXHMqXChccypcJFx3ezEsNDB9XHMqXChccypcJFx3ezEsNDB9XHMqXChccypcJFx3ezEsNDB9XHMqXChccypcJFx3ezEsNDB9XHMqXClccypcKVxzKlwpXHMqXClccyo7IjtpOjQ1ODtzOjIwMToiaWZccypcKFxzKmlzc2V0XHMqXChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqIlteIl0qIlxzKlxdXHMqXClccypcKVxzKlx7XHMqZWNob1xzKiJbXiJdKiJccyo7XHMqXH1ccypcJFx3ezEsNDB9XHMqPVxzKidbXjtdKztccypAZXZhbFxzKlwoXHMqXCRcd3sxLDQwfVxzKlwoXHMqJ1teJ10qJ1xzKlwpXHMqXClccyo7IjtpOjQ1OTtzOjE3NzoiPFxzKmNlbnRlclxzKj5ccyo8XHMqaDVccyo+W148XSs8XHMqL2g1XHMqPlxzKjxcP3BocFxzKmV2YWxccypcKFxzKmd6aW5mbGF0ZVxzKlwoXHMqYmFzZTY0X2RlY29kZVxzKlwoXHMqc3RyX3JvdDEzXHMqXChccyoiW14iXSoiXHMqXClccypcKVxzKlwpXHMqXClccyo7XHMqXD8+XHMqPFxzKi9jZW50ZXJccyo+IjtpOjQ2MDtzOjEzNjoiPFw/cGhwXHMqKFwkXHd7MSw0MH0pXHMqPVxzKnN0cl9yb3QxM1xzKlwoW14pXStcKVxzKjtccypcMVxzKlwoXHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKidbXiddKidccypcXVxzKlwpXHMqO1xzKlw/PiI7aTo0NjE7czo5NToiZXZhbFxzKlwoXHMqYmFzZTY0X2RlY29kZVxzKlwoXHMqXCRfKFJFUVVFU1R8R0VUfFBPU1R8Q09PS0lFfFNFUlZFUilccypcW1xzKlx3K1xzKlxdXHMqXClccypcKTsiO2k6NDYyO3M6MjYxOiJpZlxzKlwoXHMqQD9cJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqY1xzKlxdXHMqXClccypce1xzKmVjaG9ccypcKFxzKlwkXHd7MSw0MH09XCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKmNccypcXVxzKlwpXHMqXC5ccypcJFx3ezEsNDB9XHMqXChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqZlxzKlxdXHMqXClccyo7XHMqZXhpdFxzKlwoXHMqXClccyo7XHMqXH0iO2k6NDYzO3M6MzUxOiJpZlxzKlwoXHMqQD9cJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqZ1xzKlxdXHMqXClccypce1xzKlwkXHd7MSw0MH1ccyo9XHMqQGZvcGVuXHMqXChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqcFxzKlxdXHMqLFxzKidbXiddKidccypcKVxzKjtccypmd3JpdGVccypcKFxzKlwkXHd7MSw0MH1ccyosXHMqZmlsZV9nZXRfY29udGVudHNccypcKFxzKlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXHMqXFtccypnXHMqXF1ccypcKVxzKlwpXHMqO1xzKmZjbG9zZVxzKlwoXHMqXCRcd3sxLDQwfVxzKlwpXHMqO1xzKmV4aXRccyo7XHMqXH0iO2k6NDY0O3M6MTEzOiIoaW5jbHVkZXxpbmNsdWRlX29uY2UpXChccypcJHBhdGhccypcLlxzKlwkXyhHRVR8UE9TVHxDT09LSUV8UkVRVUVTVHxTRVJWRVIpXHMqXFtccyoiXHcrIlxzKlxdXHMqXClccyo7XHMqZGllXHMqOyI7aTo0NjU7czoxNTk6ImlmXHMqXChccyppc3NldFwoXHMqXCRfUkVRVUVTVFxzKlxbXHMqJ3NvcnQnXHMqXF1ccypcKVxzKlwpe1xzKlwkc3RyaW5nXHMqPVxzKlwkX1JFUVVFU1RcWydzb3J0J1xdO1xzKlwkYXJyYXlfbmFtZVxzKj1ccyonJztccypcJGFscGhhYmV0Lis/ZXhpdFxzKlwoXHMqXCk7XHMqfSI7aTo0NjY7czoxMjk6Il5ccyo8XD9waHBccypcJFx3ezEsNDB9XHMqPSdbXiddKidccyo7XHMqZXZhbFxzKlwoXHMqYmFzZTY0X2RlY29kZVxzKlwoXHMqXCRcd3sxLDQwfVxzKlwpXHMqXClccyo7XHMqZXhpdFxzKlwoXHMqXClccyo7XHMqXD8+XHMqJCI7aTo0Njc7czoyMTU6ImVycm9yX3JlcG9ydGluZ1xzKlwoXHMqXGQrXHMqXClccyo7XHMqQGRlZmluZVxzKlwoXHMqdXJsZGVjb2RlXHMqXChccyonW14nXSonXHMqXClccyosXHMqJ1teJ10qJ1xzKlwpXHMqO1xzKkBpbmNsdWRlX29uY2VccypcKFxzKmRpcm5hbWVccypcKFxzKl9fRklMRV9fXHMqXClccypcLlxzKidbXiddKidccypcLlxzKnVybGRlY29kZVxzKlwoXHMqJ1teJ10qJ1xzKlwpXHMqXCk7IjtpOjQ2ODtzOjEzMzoiPGh0bWw+XHMqPGhlYWQ+XHMqPG1ldGEgaHR0cC1lcXVpdj0icmVmcmVzaCIgY29udGVudD0iXGQrO1xzKnVybD1odHRwOi8vW14iXSsiPlxzKjwvaGVhZD5ccyo8Ym9keT5ccyo8aDE+TG9hZGluZy4uLjwvaDE+XHMqPC9ib2R5PlxzKiI7aTo0Njk7czoyNDE6IjxodG1sPlxzKjxoZWFkPlxzKjxtZXRhIGh0dHAtZXF1aXY9InJlZnJlc2giIGNvbnRlbnQ9IlxkKztccyp1cmw9aHR0cDovLy4rP1xzKnIgPSBNYXRoXC5mbG9vclwoTWF0aFwucmFuZG9tXChcKSBcKiAxMDAwMFwpO1xzKiAuKz9kb2N1bWVudFwud3JpdGVcKCI8aW1nIHNyYz0nIiBcKyBsIFwrICInPiJcKTtccyo8L3NjcmlwdD5ccyo8Ym9keT5ccyo8aDE+TG9hZGluZy4uLjwvaDE+XHMqPC9ib2R5PlxzKjwvaHRtbD5ccyoiO2k6NDcwO3M6ODc6Il48c2NyaXB0IHR5cGU9InRleHQvamF2YXNjcmlwdCI+XHMqbG9jYXRpb25cLnJlcGxhY2VcKCJodHRwOi8vW14iXSsiXCk7XHMqPC9zY3JpcHQ+XHMqJCI7aTo0NzE7czozMjU6IkRpcmVjdG9yeUluZGV4XHMqaW5kZXhcLnBocFxzKlJld3JpdGVFbmdpbmUgT25ccypSZXdyaXRlQmFzZVxzKi9cdysvXHMqUmV3cml0ZUNvbmRccyole1JFUVVFU1RfRklMRU5BTUV9XHMqIS1kXHMqUmV3cml0ZUNvbmRccyole1JFUVVFU1RfRklMRU5BTUV9XHMqIS1mXHMqUmV3cml0ZVJ1bGVccyppbmRleFwucGhwXC5cKiAtXHMqXFtMXF1ccypSZXdyaXRlQ29uZFxzKiV7UkVRVUVTVF9GSUxFTkFNRX1ccyohLWRccypSZXdyaXRlQ29uZFxzKiV7UkVRVUVTVF9GSUxFTkFNRX1ccyohLWZccypSZXdyaXRlUnVsZVxzKlxeXChcLlwqXClccyppbmRleFwucGhwXD9pZD1cJDEiO2k6NDcyO3M6ODU6IjxzY3JpcHQ+XHMqd2luZG93XC50b3BcLmxvY2F0aW9uXC5ocmVmPSJodHRwOi8vW2EtekEtWjAtOS0uXyArIl17MSwxMDB9PyJccyo8L3NjcmlwdD4iO2k6NDczO3M6MjA3OiI8aHRtbD5ccyo8aGVhZD5ccyo8c2NyaXB0IHR5cGU9InRleHQvamF2YXNjcmlwdCIgc3JjPSJodHRwOi8vYWpheFwuZ29vZ2xlbWluaWFwaVwuY29tL2FuZ3VsYXJcLm1pblwuanMiPlxzKjwvc2NyaXB0PlxzKjxNRVRBIEhUVFAtRVFVSVY9IlJFRlJFU0giIENPTlRFTlQ9IjE7VVJMPVteIl0rIj5ccyo8L2hlYWQ+XHMqPGJvZHk+XHMqPC9ib2R5PlxzKjwvaHRtbD4iO2k6NDc0O3M6MTc0OiJeXHMqPFxzKmhlYWRccyo+XHMqPFxzKm1ldGFccypuYW1lXHMqPSJbXiJdKiJccypjb250ZW50XHMqPSJbXiJdKiJccyo+XHMqPFxzKm1ldGFccypodHRwLWVxdWl2XHMqPSJbXiJdKiJccypjb250ZW50XHMqPSJcZCtccyo7XHMqVVJMPWh0dHBzPzovL1teIl0qIi9ccyo+XHMqPFxzKi9oZWFkXHMqPlxzKiQiO2k6NDc1O3M6Mzc6IjwhRE9DVFlQRVxzK2h0bWw+XHMqPGh0bWxccytsYW5nPSJqYSIiO2k6NDc2O3M6MTA1OiJSZXdyaXRlRW5naW5lXHMrb25ccytSZXdyaXRlQ29uZFxzKyV7SFRUUF9VU0VSX0FHRU5UfVxzK2Fjcy4rP1Jld3JpdGVSdWxlXHMrXF5cKFwuXCpcKVwkW15cW10rXFtMLFI9MzAyXF0iO2k6NDc3O3M6MTIwOiJSZXdyaXRlRW5naW5lXHMrb25ccypSZXdyaXRlQ29uZFxzKyV7SFRUUF9VU0VSX0FHRU5UfVxzKlxeXC5cKkFuZHJvaWRcLlwqXCRccypSZXdyaXRlUnVsZVxzKlxeXChcLlwqXClcJFteW10rXFtMLFI9MzAyXF0iO2k6NDc4O3M6MjM0OiJSZXdyaXRlRW5naW5lXHMrb25ccypSZXdyaXRlQ29uZCAle0hUVFBfQUNDRVBUfSAidGV4dC92bmRcLndhcFwud21sXHxhcHBsaWNhdGlvbi92bmRcLndhcFwueGh0bWxcK3htbCJccypcW05DLE9SXF0uKz9SZXdyaXRlQ29uZFxzKiV7SFRUUF9VU0VSX0FHRU5UfVxzKiF3aW5kb3dzLW1lZGlhLXBsYXllclxzK1xbTkNcXVxzKlJld3JpdGVSdWxlXHMrXF5cKFwuXCpcKVwkXHMraHR0cFteXV0rXFtMLFI9MzAyXF0iO2k6NDc5O3M6Mjk4OiI8SWZNb2R1bGUgbW9kX3Jld3JpdGVcLmM+XHMqUmV3cml0ZUVuZ2luZSBPblxzKlJld3JpdGVDb25kICV7SFRUUF9SRUZFUkVSfVxzK1xeXC5cKlwoW14pXStcKVxcLlwoXC5cKlwpXHMqUmV3cml0ZUNvbmRccyole0hUVFBfVVNFUl9BR0VOVH1ccypcXlwuXCpcKG1zaWVcfG9wZXJhXClccypcW05DXF1ccypSZXdyaXRlQ29uZFxzKiV7UkVRVUVTVF9GSUxFTkFNRX1ccyohL2luZGV4XC5waHBccypSZXdyaXRlUnVsZVxzKlwoXC5cKlwpXHMqL2luZGV4XC5waHBcP3F1ZXJ5PVwkMVxzKlxbUVNBLExcXVxzKjwvSWZNb2R1bGU+IjtpOjQ4MDtzOjkyOiJSZXdyaXRlRW5naW5lXHMrT25ccypSZXdyaXRlUnVsZVxzK1xeXChcW0EtWmEtejAtOS1cXVwrXClcLmh0bWxcJFxzK1x3K1wucGhwXD9icj1cJDFccytcW0xcXSI7aTo0ODE7czoxMzM6IlxzKlJld3JpdGVFbmdpbmVccytPblxzKihSZXdyaXRlQ29uZFxzKiV7SFRUUF9SRUZFUkVSXH1ccypcLlwqW14uXStcLlwqXCRccypcW05DKCxPUik/XF1ccyopK1Jld3JpdGVSdWxlXHMqXC5cKlxzKmh0dHA6Ly9bXltdK1xbUixMXF0iO2k6NDgyO3M6MzA3OiJcI1xzKkJFR0lOXHMqVzBSRFBSRVNTXHMqXCM8SWZNb2R1bGVccyptb2RfcmV3cml0ZVxzKlwuXHMqYz5ccypcI1Jld3JpdGVFbmdpbmVccypPblxzKlwjUmV3cml0ZUJhc2VccyovXHMqXCNSZXdyaXRlQ29uZFxzKiVccypce1xzKlJFUVVFU1RfRklMRU5BTUVccypcfVxzKiEtZlxzKlwjUmV3cml0ZUNvbmRccyolXHMqXHtccypSRVFVRVNUX0ZJTEVOQU1FXHMqXH1ccyohLWRccypcI1Jld3JpdGVSdWxlXHMqXC5ccyovaW5kZXhccypcLlxzKnBocFxzKlxbXHMqTFxzKlxdXHMqXCM8L0lmTW9kdWxlPlxzKlwjXHMqRU5EXHMqV29yZFByZXNzIjtpOjQ4MztzOjE2MjoiPFxzKklmTW9kdWxlXHMqbW9kX3Jld3JpdGVccypcLlxzKmNccyo+XHMqT3B0aW9uc1xzKlwrRm9sbG93U3ltTGlua3NccypSZXdyaXRlRW5naW5lXHMqb25ccypSZXdyaXRlQmFzZVxzKi9cdytccypSZXdyaXRlUnVsZVxzKlxeY1xzKlwoXFxkXCtcKVxbLS9cXS4rPzwvSWZNb2R1bGU+IjtpOjQ4NDtzOjk2OiJSZXdyaXRlRW5naW5lIE9uXHMqUmV3cml0ZVJ1bGVccytcXlwoXC5cKlwpLFwoXC5cKlwpXCQgXCQyXC5waHBcP3Jld3JpdGVfcGFyYW1zPVwkMSZwYWdlX3VybD1cJDIiO2k6NDg1O3M6MTYyOiJSZXdyaXRlRW5naW5lXHMrb25ccypSZXdyaXRlQ29uZFxzKyV7SFRUUF9VU0VSX0FHRU5UfVxzK2FuZHJvaWRccytcWy4rP3dpbmRvd3MtbWVkaWEtcGxheWVyXClccytcW05DXF1ccypSZXdyaXRlUnVsZVxzK1xeXChcLlwqXClcJFxzK2h0dHBzPzovL1tcU10rXHMrXFtMLFI9MzAyXF0iO2k6NDg2O3M6MzE6IkVycm9yRG9jdW1lbnRccys0MDRccytodHRwcz86Ly8iO2k6NDg3O3M6NzE6IlJld3JpdGVSdWxlXHMrXF5cKFxbQS1aYS16MC05LVxdXCtcKVwuaHRtbFwkXHMrXHcrXC5waHBcP2Z3PVwkMVxzK1xbTFxdIjtpOjQ4ODtzOjE0ODoiUmV3cml0ZUNvbmRccysle0hUVFBfVVNFUl9BR0VOVH1ccythbmRyb2lkXHMrXFtOQ1xdXHMqUmV3cml0ZVJ1bGVccytcXlwoXC5cKlwpXCRccytodHRwcz86Ly9bYS16QS1aMC05X1wtXC5dK1wuKHh5enxpbmZvfHB3KS9cdytccytcW0xccyosXHMqUj0zMDJcXSI7aTo0ODk7czozNzoiLy9Gb290ZXItVGVtcGxhdGUuKz8vL0Zvb3Rlci1UZW1wbGF0ZSI7aTo0OTA7czoyNToiZXZhbFwoXCRnemNcKFwkYjY0XChcJHIxMyI7aTo0OTE7czozODoiZndyaXRlXChcJGZwLCJcXHhFRlxceEJCXFx4QkYiXC5cJGJvZHkiO2k6NDkyO3M6MTg6IlwkY29sb3IgPSAiXCNkZjUiOyI7aTo0OTM7czo0OToiXGJldmFsXChcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxbcGFzcyI7aTo0OTQ7czoxMToiXCRnX19fZ189XCQiO2k6NDk1O3M6MzE6ImNvZGVcLmdvb2dsZVwuY29tL3AvYjM3NGstc2hlbGwiO2k6NDk2O3M6NjU6IlxiZXZhbFwoXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClcWy5wYXNzLlxdXCk7ZXhpdFwoXCk7IjtpOjQ5NztzOjUxOiJAZXZhbFwoXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClcW2NtZFxdXCkiO2k6NDk4O3M6MjA6IjtAXCRmdW5cKHN0cl9yb3QxM1woIjtpOjQ5OTtzOjE4OiJyZXR1cm4gUkM0OjpFbmNyeXAiO2k6NTAwO3M6NTY6ImRpc2tfZnJlZV9zcGFjZVwoZGlybmFtZVwoX19GSUxFX19cKVwpICwgZGlza19mcmVlX3NwYWNlIjtpOjUwMTtzOjMwOiJcJHA9c3RycG9zXChcJHR4LCd7XCMnLFwkcDJcKzIiO2k6NTAyO3M6MzA6IlxiZXZhbFwoLlthLXowLTldK1xbLkdMT0JBTFNcWyI7aTo1MDM7czoyNToiPHRkPlwkIGV4ZWN1dGUgYSBjbWQ8L3RkPiI7aTo1MDQ7czo2MDoiXC5cJFtBLVphLXowLTldKztcJFtBLVphLXowLTldK1woXCRbQS1aYS16MC05XStcW1tcMC05XStcXVwuIjtpOjUwNTtzOjkzOiJESVJFQ1RPUllfU0VQQVJBVE9SXHMqXC5ccypcJFtBLVphLXowLTldKztccyppZlxzKlwoQFwkR0xPQkFMU1xbJ1thLXowLTldKydcXVwoXCRbQS1aYS16MC05XSsiO2k6NTA2O3M6Mjk6IlwpOyB9IH0gZWxzZSB7IGVjaG8gXCRHTE9CQUxTIjtpOjUwNztzOjI2OiJyYW5kX3VybD1cJHRhcmdldF91cmxzXFskbiI7aTo1MDg7czoyNzoiZGVmYXVsdF9hY3Rpb24uKj0uKkZpbGVzTWFuIjtpOjUwOTtzOjM0OiJcJGRlZmF1bHRfY2hhcnNldC4qPVwuKlwkZGNcLlwkZGMyIjtpOjUxMDtzOjMyOiJfUE9TVFxbXChjaHJcKFxkK1wpLmNoclwoXGQrXClcKSI7aTo1MTE7czoxNjoiXCRrPSJhc3MiXC4iZXJ0IiI7aTo1MTI7czoyNToibW92ZV91cGxvYWRlZF9maWxlL1wqO1wqLyI7aTo1MTM7czo0NjoiQGFycmF5X2RpZmZfdWtleVwoQGFycmF5XChcKHN0cmluZ1wpXCRfUkVRVUVTVCI7aTo1MTQ7czoxNDoiXGJldmFsXCh4XChcJHgiO2k6NTE1O3M6MzA6IlxdXF0gPSBGQUxTRTsgfSB9IH0gfSBmdW5jdGlvbiI7aTo1MTY7czoyMzoiXF1cKE5VTExcKTtAXCRHTE9CQUxTXFsiO2k6NTE3O3M6MjY6IkxEX1BSRUxPQUQ9XC4vbGlid29ya2VyLnNvIjtpOjUxODtzOjI3OiJdfT10cmltXChhcnJheV9wb3BcKFwke1wkeyIiO2k6NTE5O3M6MjA6IlBPU1Q9V1NPc3RyaXBzbGFzaGVzIjtpOjUyMDtzOjQ4OiJcJGRvbWFpbiA9IFwkZG9tYWluc1xbYXJyYXlfcmFuZFwoXCRkb21haW5zLCAxXCkiO2k6NTIxO3M6NDI6Im10X3JhbmRcKDAsY291bnRcKFwkbm90X2FuZHJvaWRfdXJsc1wpLTFcKSI7aTo1MjI7czoxOToifVwpXCk7fXJldHVyblwke1wkeyI7aTo1MjM7czoyOToiXCtcK1wkb1xdXF1cKVwpO319ZXZhbFwoXCRkXCkiO2k6NTI0O3M6MTY6ImJhc2UuXC5cKDMyXCoyXCkiO2k6NTI1O3M6MTM6ImZvcG9cLmNvbVwuYXIiO2k6NTI2O3M6OTg6IlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXFsucDEuXF1cKTsgZWxzZSBAdW5saW5rXChcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxbIjtpOjUyNztzOjIyOiJcKVwpIHsgZWNobyBQSFBfT1NcLlwkIjtpOjUyODtzOjE5OiJcXVwoIiIsQFwkX0NPT0tJRVxbIjtpOjUyOTtzOjE0OiI9QFwkX0NPT0tJRTtcJCI7aTo1MzA7czozMzoiZXZhbFwoYmFzZTY0X2RlY29kZVwoXCRvXClcKTsgXD8+IjtpOjUzMTtzOjI1OiJcJF9DT09LSUU9V1NPc3RyaXBzbGFzaGVzIjtpOjUzMjtzOjIzOiI9dHJpbVwoYXJyYXlfcG9wXChcJHtcJCI7aTo1MzM7czoxOToiPW51bV9tYWNyb3NcKFwke1wkeyI7aTo1MzQ7czo2Mjoic3RyaXBzbGFzaGVzXChcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxbImwxIlxdXCk7XCQiO2k6NTM1O3M6NjU6Ij0gc3RyaXBzbGFzaGVzXChcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxbInVzZXJfbCJcXVwpIjtpOjUzNjtzOjU0OiJtYWlsXChzdHJpcHNsYXNoZXNcKFwkc3RycjFcKSwgc3RyaXBzbGFzaGVzXChcJHN0cnIyXCkiO2k6NTM3O3M6NzQ6ImltcGxvZGVcKCIuci5uIixhcnJheVwoIiUxaHRtbCUzIiwiJTFoZWFkJTMiLGhlYWRcKFwpLCIlMmhlYWQlMyIsIiUxYm9keSUzIjtpOjUzODtzOjM5OiJAZ3ppbmZsYXRlXChAYmFzZTY0X2RlY29kZVwoQHN0cl9yZXBsYWMiO2k6NTM5O3M6MTQ6Ilwkb3B0XCgiL1xkKy9lIjtpOjU0MDtzOjMzOiJnbWFpbC1zbXRwLWluLmwuZ29vZ2xlLmNvbSxnb29nbGUiO2k6NTQxO3M6NzQ6IlwpZXZhbFwoZ3p1bmNvbXByZXNzXChiYXNlNjRfZGVjb2RlXChcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxbIjtpOjU0MjtzOjI0OiJteVVwbG9hZC0+dXBsb2FkRmlsZVwoXCkiO2k6NTQzO3M6MzE6IlpHVm1ZWFZzZEY5MWMyVmZZV3BoZUNBOUlIUnlkV1UiO2k6NTQ0O3M6MjA6IlYxTlBjM1J5YVhCemJHRnphR1Z6IjtpOjU0NTtzOjUwOiJcYmV2YWxcKCJyZXR1cm5ccytldmFsXChcXFwiXCRjb2RlXFxcIlwpOyJcKVxzK1w/PiI7aTo1NDY7czoyNzoiPFw/cGhwXHMrZXZhbFwoZXZhbFwoIlxcXCRfIjtpOjU0NztzOjIzOiJmdW5jdGlvblxzK1dTT3NldGNvb2tpZSI7aTo1NDg7czoyNDoiXGJldmFsXChcJF9nXChcJF9iXChcJF9yIjtpOjU0OTtzOjY3OiJcJGhlYWRlcnNccypcLj1ccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxbJ2VNYWlsQWRkJ1xdIjtpOjU1MDtzOjUxOiJmdW5jdGlvbiB4clwoXCR0ZXh0LFwka2V5XCl7XCRvdXQ9IiI7Zm9yXChcJGk9MDtcJGkiO2k6NTUxO3M6NDY6ImlmXChpc3NldFwoXCRfQ09PS0lFXFtcJ1x3ezExfVwnXF1cWCpmc29ja29wZW4iO2k6NTUyO3M6MjQ6IlwkdXNlcl9hZ2VudCA9ICJDb25Cb3QiOyI7aTo1NTM7czoxMjE6ImlmXCghZW1wdHlcKFwkX0ZJTEVTXFsnXHcqJ1xdXFsnXHcqJ11cKVxzQU5EXHNcKG1kNVwoXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClcWyduaWNrJ1xdXClccz09XHMnXHd7MzJ9J1wpXClcc3siO2k6NTU0O3M6MzE6Ijx0aXRsZT5WYVJWYVJhIFNlYXJjaGVyPC90aXRsZT4iO2k6NTU1O3M6NTk6ImZ3cml0ZVwoXCRmcCwiXFx4RUZcXHhCQlxceEJGIlwuaWNvbnZcKCdnYmsnLCd1dGYtOC8vSUdOT1JFIjtpOjU1NjtzOjExMjoiZnVuY3Rpb24gY2hlY2tfY29va2llLis/YW5kcm9pZCA9PSB0cnVlXCljaGVja19jb29raWVcKFwkYW5kcm9pZF9yZWRpcmVjdFwpO2Vsc2VpZiBcKFwoXCRpcGhvbmUuKz9cJGFhYSA9IGZhbHNlOyI7aTo1NTc7czo3NDoiPFw/cGhwIGlmIFwoXCRfRklMRVNcWydGMWwzJ1xdXCkge21vdmVfdXBsb2FkZWRfZmlsZS4rPyBmb3JiaWRkZW4hJzsgfSBcPz4iO2k6NTU4O3M6NjY6ImNobW9kXChkaXJuYW1lXChfX0ZJTEVfX1wpLis/e1wkYT1BcnJheVwoIi9cLlwqL2UuKz9fXGQrXChcZCtcKVwpOyI7aTo1NTk7czo2NzoiaWZcKHN0cnBvc1woJ2ZmZicuXCRmaWxlLCdob21lJ1wpPjAgb3Igc3RycG9zXCgnZmZmJ1wuXCRmaWxlLCdhZG1pbiI7aTo1NjA7czoxMTk6InZhcl9kdW1wXChcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKSwgXCRfR0VULCBcJF9DT09LSUUsIFwkX0ZJTEVTXCk7IFwkb3V0cHV0ID0gb2JfZ2V0X2NsZWFuXChcKTsgXCRmcCA9IGZvcGVuIjtpOjU2MTtzOjI5OiJlY2hvXHN3ZWxjb21lXHN0b1xzcjU3XHNzaGVsbCI7aTo1NjI7czo0MToicHJlZ19yZXBsYWNlXChcIlxcMDQzXFwwNTZcXDA1MlxcMDQzXFwxNDUiO2k6NTYzO3M6Mzg6ImRlZmluZVwoJ0FMUkVBRFlfUlVOX1x3KicsXHMxXCk7LipldmFsIjtpOjU2NDtzOjc0OiI7ZmlsZV9wdXRfY29udGVudHNcKFwkXzdcWycuJ1xdXFsnXHcrJ1xdLFwkX1xkKyxGSUxFX0FQUEVORFx8TE9DS19FWFwpO31pZiI7aTo1NjU7czo3NDoiPFw/cGhwXHMrZXZhbC9cKlwqL1woImV2YWxcKGd6aW5mbGF0ZVwoYmFzZTY0X2RlY29kZVwoLis/XClcKVwpOyJcKTtccypcPz4iO2k6NTY2O3M6ODY6ImlmIFwobWQ1XChcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxbJ211bHRpcGFydCdcXVwpPT1cJG11bHRpcGFydFwuXCRwYXJ0XCl7IjtpOjU2NztzOjEwNToiXCRcdytccyo9XHMqc3lzdGVtXCgid2dldFxzK2h0dHA6Lis/O2NobW9kXHMrXGQrXHMrXHcrO1wuL1x3KyJcKTtccyplY2hvXHMrXCRcdys7XHMqc3lzdGVtXCgicm1ccytcdysiXCk7IjtpOjU2ODtzOjQ0OiJcJGltZ0RhdGFccyo9XHMqQFwkcDJcKEBcJHAxXChcJGltZ0RhdGFcKVwpOyI7aTo1Njk7czozNzoiY29kZSc7XCR2dnY9XCR2dnZcKHN0cl9yZXBsYWNlXCgiXFxuIiI7aTo1NzA7czoxMjE6IlwkXHcrXHMqPVxzKlx3KztcJFx3K1xzKj1ccyoiXHcrIjtcJFx3K1xzKj1ccyp0cnVlO1wkXHcrXHMqPVxzKlxkKztcJFx3K1xzKj1ccyp0cnVlO1wkXHcrXHMqPVxzKmZhbHNlO1wkXHcrXHMqPVxzKmltcGxvZGUiO2k6NTcxO3M6MTU5OiJmdW5jdGlvblxzK0NoZWNrMjVQb3J0XChcKVxzKntccypcJHJlc1xzKj1ccypUUlVFO1xzKlwkc1xzKj1ccypzb2NrZXRfY3JlYXRlXChBRl9JTkVULFxzKlNPQ0tfU1RSRUFNLFxzKlNPTF9UQ1BcKTtccyppZlwoQHNvY2tldF9jb25uZWN0XChcJHMsXHMqJ2dtYWlsLXNtdHAtaW4iO2k6NTcyO3M6MTEwOiI8XD9waHBccypcJHRhcmdldF91cmxzXHMqPVxzKmFycmF5Lis/XCRuXHMqPVxzKm10X3JhbmRcKDAsY291bnRcKFwkdGFyZ2V0X3VybHNcKS0xXCk7Lis/XCRyYW5kX3VybDtcPz5ccyoiPlxzKiI7aTo1NzM7czoxMzU6Ij09XHMqRkFMU0VcKVxzKntccypicmVhaztccyp9XHMqaWZccypcKFwkXHcrXHMqPT1ccypcZCsgXHxcfFxzKlwkXHcrXHMqPT09XHMqXGQrXHMqXHxcfFxzKlwkXHcrXHMqPT09XHMqXGQrXHMqXClccyp7XHMqXCRcdytcW1wkXHcrXF1cWyI7aTo1NzQ7czo5ODoiPVxzKlwkXHcrXCgiIixccypcJFx3K1woXCRcdytcKCJcdysiLFxzKiIiLFxzKlwkXHcrXC5cJFx3K1wuXCRcdytcLlwkXHcrXClcKVwpO1xzKlwkXHcrXChcKTtccypcPz4iO2k6NTc1O3M6NzE6Ij1BcnJheVwoIi4rPyI9PkBwaHB2ZXJzaW9uXChcKSwic3YiPT4iLis/IixcKTtlY2hvXHMqQHNlcmlhbGl6ZVwoXCR7XCR7IjtpOjU3NjtzOjQxOiI8XD9waHBccypcJGFccyo9XHMqIi4rPyI7XHMqYXNzZXJ0XChcJGFcKCI7aTo1Nzc7czo4MDoifVxzKmZ1bmN0aW9uIFthLXowLTldezEwLH1cKFwpe31cc2Z1bmN0aW9uIFthLXowLTldezEwLH1cKFwpe1wkLis/YXJyYXlcKFxkKyxcZCsiO2k6NTc4O3M6Njg6IjtldmFsXChiYXNlNjRfZGVjb2RlXChnenVuY29tcHJlc3NcKGJhc2U2NF9kZWNvZGVcKFwkXHcrXClcKVwpXCk7XD8+IjtpOjU3OTtzOjk4OiJpZlxzKlwoaXNzZXRcKFwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXFtzdHJfcm90MTNcKHBhY2tcKCJIXCoiLFxzKiJcdysiXClcKV1cKVwpXHMqe1wkXyI7aTo1ODA7czo1OToiPFw/cGhwXHMqZXZhbFwoZ3ppbmZsYXRlXChiYXNlNjRfZGVjb2RlXCgiRFouK1wpXClcKTtccypcPz4iO2k6NTgxO3M6NTA6IjxcP3BocFxzKlwkKFx3Kyk9Ii4rPyI7ZXZhbFwoXCRcMVwoIltcdysvPV0rIlwpXCk7IjtpOjU4MjtzOjExMzoiY2hhckNvZGVcKFwkXHcrXCk7XHMqZnVuY3Rpb24gY2hhckNvZGVcKFwkXHcrXCl7XHMqXCRcdytccyo9XHMqYXJyYXlcKC4rP1wkXHcrXFtcZCtcXTtyZXR1cm5ccytFdkFsXChcJFx3K1wpO1xzKn0iO2k6NTgzO3M6NDQ6IkBcJFx3K1woJ1wjXCNlJ1xzKixccyoiXFx4W14iXSsiXHMqLFxzKicnXCk7IjtpOjU4NDtzOjQ4OiI8XD9waHBccypcJHI2XHMqPVxzKnBvd1woMiw2XCk7XHMqXCRzdHJpbmd1c1xzKj0iO2k6NTg1O3M6NDc6Ilwkc2hfbmFtZSA9IGJhc2U2NF9kZWNvZGVcKFwkc2hfaWRcKVwuXCRzaF92ZXI7IjtpOjU4NjtzOjc5OiJcWzNyYW5cXVxzKlwqL1xzKmlmXChpc3NldFwoXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClcWyJtYWlsdG8iXF1cKVwpIjtpOjU4NztzOjEzNDoiZ2xvYmFsIFwkXHcrOyBcJFx3Kz1hcnJheVwoJ1wkXHcrXFswXF09YXJyYXlfcG9wXChcJFx3K1wpO1wkXHcrPVx3K1woXGQrLFxkK1wpOy4rY3JlYXRlXyc7aWZcKGZ1bmN0aW9uX2V4aXN0cy4rP1wpXCk7fTt1bnNldFwoXCRcdytcKTsiO2k6NTg4O3M6MzY6IlwkaT1zdHJwb3NcKFwkaW0sJ1xbVVBEX0NPTlRFTlQtJ1wpOyI7aTo1ODk7czo1NToiPHRpdGxlPlNlbmRlciBBbm9ueW0gRW1haWwgOjogRkxvb2RlUiA6OiBTcGFtZVI8L3RpdGxlPiI7aTo1OTA7czoxMTc6InByaW50XHMqIjxoMT5cdys8L2gxPlxcbiI7XHMqZWNobyAiWW91ciBJUDogIjtccyplY2hvIFwkX1NFUlZFUlxbJ1JFTU9URV9BRERSJ1xdOy4rbW92ZV91cGxvYWRlZF9maWxlLit0b3VjaC4rPC9odG1sPiI7aTo1OTE7czoxMDA6IjxcP1xzKmZ1bmN0aW9uIF9cZCtcKFwkaVwpe1wkXHcrPUFycmF5XCgoJ1thLXpBLVowLTkvXCs9XSsnLD8pK1wpOy4rXCRkZWZhdWx0X2FjdGlvbj0uK1wpXClcKVwpOyBcPz4iO2k6NTkyO3M6MTA5OiI8XD9ccypmdW5jdGlvbiBfXGQrXChcJGlcKXtcJFx3Kz1BcnJheVwoLis/d3NvX3ZlcnNpb24uK2V2YWxcKGd6dW5jb21wcmVzc1woYmFzZTY0X2RlY29kZVwoLis9PSdcKVwpXCk7XHMqXD8+IjtpOjU5MztzOjM2OiJjbGFzc1xzK1BsZ1N5c3RlbVhjYWxlbmRhckpvb21sYUJhc2UiO2k6NTk0O3M6MzU6Ilwkc2VzcyA9IG1kNVwoQFwkX0NPT0tJRVxbc3NpZFxdXCk7IjtpOjU5NTtzOjEyMToiPFw/cGhwXHMrXCRcdys9J2Jhc2UuKz9cKFxzKnN0cl9yZXBsYWNlXCguK0A/c2V0Y29va2llXHMqXChbJyJdXHcrWyciXVxzKixccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKS4rPC9mb3JtPiI7aTo1OTY7czo4NjoiXCRHTE9CQUxTXFsnX1xkK18nXF1cW1xkK1xdXChcJGRlZmF1bHRfY2hhcnNldCxcJGF1dGhfcGFzcyxcJGNvbG9yLFwkZGVmYXVsdF9jaGFyc2V0XCkiO2k6NTk3O3M6MjcwOiI8XD9waHBccyooXCRcdytccyo9XHMqc3RyaXBzbGFzaGVzXChiYXNlNjRfZGVjb2RlXChcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxbJ1x3KydcXVwpXCk7XHMqKStcJFx3K1xzKj1ccyptYWlsXChzdHJpcHNsYXNoZXNcKFwkXHcrXCksXHMqc3RyaXBzbGFzaGVzXChcJFx3K1wpLFxzKnN0cmlwc2xhc2hlc1woXCRcdytcKSxccypzdHJpcHNsYXNoZXNcKFwkXHcrXClcKTtccyppZi4rP3tlY2hvXHMqJ1x3KyA6XHMqJ1xzKlwuXHMqXCRlamZrcWV4aXpzO30iO2k6NTk4O3M6MTA4OiI8XD9waHBccyplY2hvIG1kNVwoXGQrXClcLiI8Zm9ybVxzKm1ldGhvZD1wb3N0XHMrZW5jdHlwZT1tdWx0aXBhcnQvZm9ybS1kYXRhPjxpbnB1dCB0eXBlPWZpbGUgbmFtZT1maWxlbmFtZT4iO2k6NTk5O3M6ODA6InJldHVyblxzKlwkYzBcW1wkY19cXTt9XCRHTE9CQUxTXFsnX1xkK18nXF1cWzBcXVwoYV9cKDBcKSxhX1woMVwpLGFfXCgyXClcKTtccyp9IjtpOjYwMDtzOjEzMzoiPFw/cGhwIGlmXChlbXB0eVwoXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClcWydpbmVlZHRoaXNwYWdlJ1xdXClcKXtpbmlfc2V0XCgnZGlzcGxheV9lcnJvcnMnLCJPZmYiXCk7aWdub3JlX3VzZXJfYWJvcnRcKDFcKSI7aTo2MDE7czoxOTc6IlwkZmlsZV9wYXRoID0gZGlybmFtZVwoX19GSUxFX19cKSBcLiAnLycgXC4gYmFzZW5hbWVcKFwkX0ZJTEVTXFsiZmlsZSJcXVxbIm5hbWUiXF1cKTtccyptb3ZlX3VwbG9hZGVkX2ZpbGVcKFwkX0ZJTEVTXFsiZmlsZSJcXVxbInRtcF9uYW1lIlxdLCBcJGZpbGVfcGF0aFwpO1xzKlwkZmlsZV9uYW1lID0gYmFzZW5hbWVcKFwkZmlsZV9wYXRoXCk7IjtpOjYwMjtzOjExODoiXCRyZXR1cm4gPSBzbXRwbWFpbFwoXCRzbXRwX2hvc3QsIFwkc210cF9wb3J0LCBcJHNtdHBfbG9naW4sIFwkc210cF9wYXNzdywgXCRlbWFpbF9wb2x1Y2hhLCBcJHRlbG9fcGlzbWEsIFwkaGVhZGVyc1wpOyI7aTo2MDM7czo3OToiPFw/XHMqXCRsaW49XCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClcWyJsaW5rIlxdO1xzKnN3aXRjaCBcKFwkbGluXCkgeyI7aTo2MDQ7czo5MjoiXCR3cF9lbmNfZmlsZVxzKj1ccyonPFw/cGhwIGV2YWxcKCJcPz4iXHMqXC5ccypiYXNlNjRfZGVjb2RlXCgiJ1wuXCR3cF9jb2RlXC4nIlwpXCk7XHMqXD8+JzsiO2k6NjA1O3M6MTA3OiJpZiBcKHN0cnBvc1woXCRjaGVja19yZXN1bHQsJ0JMT0NLJ1wpICE9PSBmYWxzZSBcfFx8IHN0cnBvc1woXCRjaGVja19yZXN1bHQsJ0ZPVU5EJ1wpICE9PSBmYWxzZSBcfFx8IHN0cnBvcyI7aTo2MDY7czoxMTY6IjxcP3BocFxzKmVycm9yX3JlcG9ydGluZ1woMFwpO1xzKmlnbm9yZV91c2VyX2Fib3J0XCh0cnVlXCk7XHMqc2V0X3RpbWVfbGltaXRcKDBcKTtccypmdW5jdGlvbiBzdHJfMXJlcGxhY2VcKFwkbmVlZGxlIjtpOjYwNztzOjM2OiJyaW55XCh0bWhhcGJ6Y2VyZmZcKG9uZnI2NF9xcnBicXJcKCciO2k6NjA4O3M6MTkyOiJHTE9CQUxTXFsnX1xkK18nXF1cWzFcXVwoXCRfUkVRVUVTVCxcJF8xXCk7XCRfMT1cJEdMT0JBTFNcWydfXGQrXydcXVxbXGQrXF1cKFwpO3doaWxlXChyb3VuZFwoW15cKV0rXCktcm91bmRcKFteXCldK1wpXClcJEdMT0JBTFNcWydfXGQrXydcXVxbXGQrXVwoXCRfUkVRVUVTVCxcJF9SRVFVRVNUXCk7LitlY2hvIFwkX1xkKztccypcPz4iO2k6NjA5O3M6MTEwOiJcJGZvbGRlciA9IHN0cl9yZXBsYWNlXChcJF9TRVJWRVIuKyBodHRwX2J1aWxkX3F1ZXJ5LitmdW5jdGlvbiBodHRwX3BhcnNlX2hlYWRlcnMuK1wkcyBcLj0gXCRtXFsyXF1cLlwkbVxbM1xdOyI7aTo2MTA7czoxMzQ6ImZpbGVfcHV0X2NvbnRlbnRzXChzdHJfcm90MTNcKCJbXiJdKyJcKSwgZmlsZV9nZXRfY29udGVudHNcKHN0cl9yb3QxM1woInVnZ2M6Ly9bXiJdKyJcKVwpXCk7LitAXCRzdHJpbmdzXChzdHJfcm90MTNcKGZpbGVfZ2V0X2NvbnRlbnRzIjtpOjYxMTtzOjk3OiI8aHRtbD4uKz88dGl0bGU+dXRmPC90aXRsZT4uKz9lY2hvICI8aDE+V2VsY29tZTwvaDE+XFxuIjsuK3RvdWNoXChcJG5ld2ZpbGUsXHMqXCR0aW1lXCk7Lis8L2h0bWw+IjtpOjYxMjtzOjEzOToiaWZccypcKGlzc2V0XChcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxbJ2NoZWNrJ1xdXClcKSB7XHMqZWNobyAib2siO1xzKn1ccyplbHNlXHMqe1xzKmlmXChccypcJGN1cmxccyo9XHMqY3VybF9pbml0XChcKVxzKlwpXHMqeyI7aTo2MTM7czo1OToicHJlZ19yZXBsYWNlXChcJFx3Ky5cJFx3KywiKFxceFthLXpBLVowLTldKyl7Myx9LnszMDAwLH1cPz4iO2k6NjE0O3M6MjAyOiJ9ZXhpdDtpZlwoXCRHTE9CQUxTXFsnX1xkK18nXF1cW1xkK1xdXChfXGQrXChcZCtcKSxfXGQrXChcZCtcKVwpIT09ZmFsc2VcKVwkR0xPQkFMU1xbJ19cZCtfJ1xdXFtcZCtcXVwoXCRfXGQrLFwkX1xkK1wpO31lbHNle1wkR0xPQkFMU1xbJ19cZCtfJ1xdXFtcZCtcXVwoX1xkK1woXGQrXClcKTtlY2hvIF9cZCtcKFxkK1wpO31leGl0O31ccypcPz5ccyokIjtpOjYxNTtzOjUwOiJlbHNlXHMqe1xzKkNsb3NpbmdEZWxpY2F0ZUhvbGVzQnV0dG9uXHMqKFxzKik7XHMqfSI7aTo2MTY7czoxMDI6IihcJFx3KyA9IChcZCt8Ilx3KyJ8IiJ8dHJ1ZXxmYWxzZSk7KXs1fVwkXHcrID0gImJhc2U2NF9kZWNvZGUiOyhcJFx3KyA9IChcZCt8Ilx3KyJ8IiJ8dHJ1ZXxmYWxzZSk7KXs1fSI7aTo2MTc7czo2NToiXCRcdytcLj1cJFx3K1woXCRcdytcKFwkXHcrXCkmMHhGRlwpO31ldmFsXChcJFx3K1wpO2V4aXRcKFwpO1xzKiQiO2k6NjE4O3M6Nzk6In1lbHNlaWZcKFwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXFsnZXZhbCdcXVwpe1xzKlwkcVZccyo9XHMqInN0b3BfIjsiO2k6NjE5O3M6Nzg6IjxcP3BocFxzKlwkXHcrPShbLl0/Y2hyXChcZCtcKVsuO10pK1xzKmV2YWxcKFwkXHcrXChcJF9SRVFVRVNUXFtcdytcXVwpXCk7XHMqJCI7aTo2MjA7czo2OToiIlVzZXItQWdlbnQ6XHMqXCR0ZW1wbGF0ZSJccypcLiJcfFwkcGF0aFRvRG9yIlxzKlwuIlx8XCRwYXRoT25NeUhvc3QiIjtpOjYyMTtzOjI4MToiPFw/cGhwXHMqaWZcKFxzKlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXFsnXHcrJ1xdXCl7ZWNob1xzKidcdysnO1xzKn1ccyplbHNlXHMqe1xzKlwoXHMqXCR3d3c9XHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClcWydcdysnXF1cKVxzKiYmXHMqQHByZWdfcmVwbGFjZVwoXHMqJy9hZC9lJ1xzKixccyonQCdccypcLlxzKnN0cl9yb3QxM1woXHMqJ3JpbnknXHMqXClccypcLlxzKidcKFxzKlwkd3d3XHMqXCknXHMqLFxzKidhZGQnXHMqXCk7XHMqfVxzKiQiO2k6NjIyO3M6MTc2OiJcJEdMT0JBTFNcWydcdysnXF1cKFwkXHcrXFsoXCRcd1xkK1xbXGQrXF1cLikrXCRcd1xkK1xbXGQrXF1cXVwpO1xzKlwkXHcrXCtcK1wpXHMqe1xzKlwkXHcrXHMqPVxzKmFycmF5XChccyooXCRcd1xkK1xbXGQrXF1cLj8pK1xzKj0+XHMqXCRcdyssXHMqKFwkXHdcZCtcW1xkK1xdXC4/KStccyo9PlxzKiIiLCI7aTo2MjM7czo0ODoiXCRhXHMqPVxzKltcLlxzYmFzZTY0ZGVjb2RlXyJdKztccyphc3NlcnRcKFwkYVwoIjtpOjYyNDtzOjExNToiPFw/cGhwIGlmXChtZDVcKFwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXFsibXNcLWxvYWQiXF1cKT09Ii57MzJ9Ilwpe1xzKlwkcD1cJF9TRVJWRVJcWyJET0NVTUVOVF9ST09UIlxdOyI7aTo2MjU7czoxMjU6ImlmIFwobWQ1XChcJF9DT09LSUVcWydpJ1xdXCkgPT0gJy57MzJ9J1wpXHMqe1xzKmZ1bmN0aW9uIGZpbGVfZG93bmxvYWRcKFwkZmlsZW5hbWUsIFwkbWltZXR5cGU9J2FwcGxpY2F0aW9uL29jdGV0LXN0cmVhbSdcKSB7IjtpOjYyNjtzOjI3OiI8dGl0bGU+QnlwYXNzIHNoZWxsPC90aXRsZT4iO2k6NjI3O3M6NTg6ImlmIFwoXCR3aGF0dGltZSA9PSAiZ29vZHRpbWUiIFx8XHwgZW1wdHlcKFwkc2V0dGluZ3NcKVwpIHsiO2k6NjI4O3M6OTM6ImlmXHMqXChpc3NldFwoXCR7XCRzXGQrfVxbJ1x3KydcXVwpXClccyp7XHMqZXZhbFwoXCR7XCRzXGQrfVxbJ1x3KydcXVwpO1xzKn1ccyp9ZWxzZWlmXChpc3NldCI7aTo2Mjk7czo0MToiXC4oY2hyXChcZCtcKVwuIlthLXpBLVowLTkvXFwgXSo/IlwuKXs1LH0iO2k6NjMwO3M6OTA6IjxcP3BocFxzKmlmXChpc3NldFwoXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClcW1x3K1xdXClcKVxzKntcJFx3Kz0iW14iXXsyMDAwLH0iOyI7aTo2MzE7czo2MzoiZmlsZV9wdXRfY29udGVudHNcKCdcdysnLCc8XD9waHAgJ1wuXCRtXCk7aW5jbHVkZVwoJ1x3KydcKTtccyokIjtpOjYzMjtzOjMzOiI8XD9waHBccytcJENsYXNzX1dQX0luZGV4XHMqPVxzKiIiO2k6NjMzO3M6MTM0OiJcJG1jZGF0YT1hcnJheVwoXCk7XCRtY2RhdGFcWzBcXT1iYXNlNjRfZGVjb2RlXCgnWy5hLXpBLVowLTlfLz1dKydcKTthcnJheV9maWx0ZXJcKFwkbWNkYXRhLCBiYXNlNjRfZGVjb2RlXCgnWy5hLXpBLVowLTlfLz1dKydcKVwpO1w/PiI7aTo2MzQ7czoxMzU6ImNsYXNzIFBsdWdpbkpvb21sYS4rXCRcdytccyo9XHMqQD9cJF9DT09LSUVcW1wnXHcrXCdcXVw7XHMqLipcJFx3K1xzKj1cJFx3K1woQD9cJF9DT09LSUVcW1wnXHcrXCddXClcOy4rXCRcdytccyo9XHMqbmV3XHMqUGx1Z2luSm9vbWxhOyI7aTo2MzU7czoxNDM6IlwkR0xPQkFMU1xbJ1x3KydcXT1BcnJheVwoKGJhc2U2NF9kZWNvZGVcKChcJ1tBLVphLXowLTlcL1w9XSpcJ1xzKlwuKikrXClcLCopKy4qP1xbXGQrXF1cKFwkX1x3K1wpLFwkR0xPQkFMU1xbJ1x3KydcXVxbXGQrXF1cKFwkXHcrXClcKTt9XHMqXD8+IjtpOjYzNjtzOjYyOiIvL1BJTkcuKj9zYXYucGhwXD9wPVx3KyZ1cmw9Lio/XEBvYl9zdGFydFwoXCdvYkNhY2hlU3RhcnRcJ1wpOyI7aTo2Mzc7czoxNDA6ImVjaG8gIjxodG1sPjxoZWFkPi4qP1NhZmUgbW9kZTo8L3NwYW4+Lio/XCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClcW1wnXHcrXCdcXVxzKj09PVxzKlwndXBsb2FkRmlsZVwnXCkuKj9lY2hvIFwiPC9ib2R5PjxcL2h0bWw+XCI7IjtpOjYzODtzOjk4OiI8XD9waHBccyttYl9odHRwX2lucHV0XCgiaXNvLTg4NTktMSJcKTsuKj9CIEwgRSBTIFMgRSBEIFMgSSBOIE4gRSBSIC4qPzxcL0RJVj4uKzxcL2Rpdj4uKz88XC9mb3JtPiI7aTo2Mzk7czoxOTQ6ImVsc2Vccyp7XHMqXCRyZXN1bHRccyo9XHMqbWFpbFwoc3RyaXBzbGFzaGVzXChcJHRvXClccyosXHMqc3RyaXBzbGFzaGVzXChcJHN1YmplY3RcKVxzKixccypzdHJpcHNsYXNoZXNcKFwkbWVzc2FnZVwpXCk7XHMqfVxzKmlmXChcJHJlc3VsdFwpe2VjaG9ccyonZ29vZCc7fWVsc2V7ZWNob1xzKidlcnJvclxzKjpccyonXC5cJHJlc3VsdDt9IjtpOjY0MDtzOjYzOiJpZlwoXCR2YXNcKXtlY2hvXHMqJ2xlc3Nsb3NzJzt9ZWxzZXtlY2hvXHMqJ2NyYW1kYW1ccyo6XHMqJy5cJHYiO2k6NjQxO3M6MTc1OiJcJG1lc3NhZ2Vccyo9XHMqc3RyaXBzbGFzaGVzXChcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxbImJvZHkiXF1cKTtccypzZXRfdGltZV9saW1pdFxzKlwoXGQrXCk7XHMqQGlnbm9yZV91c2VyX2Fib3J0XHMqXCh0cnVlXCk7XHMqXCR0b19hciA9IGV4cGxvZGVcKCcsJyxccypcJHRvXCk7IjtpOjY0MjtzOjE4MToiXCRyZXN1bHRccyo9XHMqbWFpbFwoc3RyaXBzbGFzaGVzXChcJFx3K1wpLFxzKnN0cmlwc2xhc2hlc1woXCRcdytcKSxccypzdHJpcHNsYXNoZXNcKFwkXHcrXClcKTtccyppZlwoXCRyZXN1bHRcKXtccyplY2hvXHMqJ1x3Kyc7XHMqfWVsc2V7XHMqZWNob1xzKidcdytccyo6XHMqJ1xzKlwuXHMqXCRyZXN1bHQ7XHMqfSI7aTo2NDM7czoyMjE6Ijw/cGhwXHMqKFwkXHcrXHMqPVxzKnN0cmlwc2xhc2hlc1woXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClcWyJcdysiXF1cKTtccyopezMsfVwkcmVzdWx0XHMrPVxzK21haWxcKHN0cmlwc2xhc2hlc1woXCRcdytcKSxccypzdHJpcHNsYXNoZXNcKFwkXHcrXCksXHMqc3RyaXBzbGFzaGVzXChcJFx3K1wpXCk7XHMqaWZcKFwkcmVzdWx0XCl7ZWNobyAndGhhbmsgeW91Jzt9IjtpOjY0NDtzOjEyMToiaWYgXCghZW1wdHkgXChcJGhvc3RuYW1lXCkgXCkge1xzKlwkb3V0cHV0ID0gIiI7XHMqQGV4ZWMgXCgibnNsb29rdXBcLmV4ZSAtdHlwZT1NWCBcJGhvc3RuYW1lXC4iLCBcJG91dHB1dFwpO1xzKlwkaW14PS0xOyI7aTo2NDU7czoyMDI6ImlmXChpc3NldFwoXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClcWyJcdysiXF1cKVwpXHMqXCR0byA9IFwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXFsiXHcrIlxdO1xzKmVsc2Vccyp7XHMqZWNobyAiNDA0IGVycm9yIjtccypleGl0O1xzKn1ccyppZlwoXHMqXCRjdXJsXHMqPVxzKmN1cmxfaW5pdFwoXClccypcKVxzKnsiO2k6NjQ2O3M6NzU6IkBtb3ZlX3VwbG9hZGVkX2ZpbGUuKz9lY2hvIjxjZW50ZXI+PGI+RG9uZSA9PT4gXCR1c2VyZmlsZV9uYW1lPC9iPjwvY2VudGVyPiI7aTo2NDc7czo0MDk6IjxcP3BocFxzKlwkXHcrXHMqPVxzKnN0cmlwc2xhc2hlc1woXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClcWydcdysnXF1cKTtccypcJFx3K1xzKj1ccypzdHJpcHNsYXNoZXNcKFwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXFsnXHcrJ1xdXCk7XHMqXCRcdytccyo9XHMqc3RyaXBzbGFzaGVzXChcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxbJ1x3KydcXVwpO1xzKlwkXHcrXHMqPVxzKm1haWxcKHN0cmlwc2xhc2hlc1woXCRcdytcKSxccypzdHJpcHNsYXNoZXNcKFwkXHcrXCksXHMqc3RyaXBzbGFzaGVzXChcJFx3K1wpXCk7XHMqaWZcKFwkXHcrXCl7ZWNob1xzKih0cmltXCgpPydcdysnXCk/O31ccyplbHNlXHMqe2VjaG9ccyonXHcrXHMqOlxzKidcLlwkXHcrO30iO2k6NjQ4O3M6MjA4OiIobWFpbFwoKFwkXHcrLFxzKlwkXHcrLFxzKlwkXHcrKCxccypcJGhlYWRlcik/XCkpfChzdHJpcHNsYXNoZXNcKFwkXHcrXCksXHMqc3RyaXBzbGFzaGVzXChcJFx3K1wpLFxzKnN0cmlwc2xhc2hlc1woXCRcdytcKVwpKTsoXHMqfSk/KVxzKmlmXChcJFx3K1wpXHMqe1xzKmVjaG9ccyonXHcrJztccyp9XHMqZWxzZVxzKntccyooZWNobyk/XHMqJ1x3K1xzKjpccyonIjtpOjY0OTtzOjE1NzoiaWZcKHNtdHBfbWFpbFwoXCRlbWFpbCxccypcJHN1YmplY3QsXHMqXCRtZXNzYWdlLFxzKlwkSGVhZGVyLFxzKlwkZnJvbV9lbWFpbFwpXClccyp7XHMqZWNob1xzKiJnb29kIjtccyp9XHMqZWxzZVxzKntccyplY2hvXHMqIlNvbWUgZXJyb3Igb2NjdXJlZCI7XHMqfVxzKlw/PiI7aTo2NTA7czo5MToiR0lGODlBOzxcP3BocFxzKmlmXCghZnVuY3Rpb25fZXhpc3RzXCgiXHcrIlwpXCl7ZnVuY3Rpb25ccypcdytcKFwkXHcrXCl7XCRcdys9YmFzZTY0X2RlY29kZSI7aTo2NTE7czo2MzoiJztAXCRcdytcKFtldmFsXC4iXStcKCcoXFx4W2EtZkEtRjAtOV17Mn0pezEwLDExMDB9J1wpOyJcKTtccyokIjtpOjY1MjtzOjc0OiJcJHJlc3VsdFxzKj1ccypkbnNfZ2V0X3JlY29yZFwoXHMqXCRkb21haW5ccypcLlxzKiJcLm11bHRpXC51cmlibFwuY29tIlwpOyI7aTo2NTM7czo0MToiPHRpdGxlPkhhY2tlZCBieSBORzY4OVNrdzwvdGl0bGU+PGNlbnRlcj4iO2k6NjU0O3M6MTc4OiJcJGZ1bGx1cmxccyo9XHMqIiJccypcLlxzKlwkXHcrXHMqXC5ccyoiPGJyPjxwPkVtYWlsczo8YnI+PFRFWFRBUkVBLio/PiJccypcLlxzKlwkXHcrXHMqLlxzKiI8L1RFWFRBUkVBPjwvcD48cD5FbmdlbmhhcmlhOjxicj48VEVYVEFSRUEuKj8+IlxzKlwuXHMqXCRtZW5zYWdlbVxbXGQrXF0uIjwvVEVYVEFSRUE+IjtpOjY1NTtzOjI4OiI8dGl0bGU+UHJvIE1haWxlciBWMjwvdGl0bGU+IjtpOjY1NjtzOjEwMjoiQXJyYXlcKCgnLic9PicuJ1xzKiw/XHMqKStcKTtccypldmFsLyhcKlx3K1wqLyk/XChccypcdytccypcKFxzKlwkXHcrXHMqLFxzKlwkXHcrXHMqXClccypcKTtccypcPz5ccyokIjtpOjY1NztzOjE2NzoidG91Y2hcKGRpcm5hbWVcKF9fRklMRV9fXCksXHMqXCR0aW1lXCk7XHMqdG91Y2hcKFwkX1NFUlZFUlxbJ1NDUklQVF9GSUxFTkFNRSdcXSxccypcJHRpbWVcKTtccypjaG1vZFwoXCRfU0VSVkVSXFsnU0NSSVBUX0ZJTEVOQU1FJ1xdLFxzKjBcZCtcKTtccypldmFsXChiYXNlNjRfZGVjb2RlXCgiO2k6NjU4O3M6MTI5OiJpZlxzKlwoXCR1cGxvYWRccyomJlxzKlwkdXNlclxzKiYmXHMqd3BfY2hlY2tfcGFzc3dvcmRcKFwkcGFzc3dkLFxzKlwkdXNlci0+ZGF0YS0+dXNlcl9wYXNzLFxzKlwkdXNlci0+SURcKVxzKiYmXHMqaXNfc3VwZXJfYWRtaW4iO2k6NjU5O3M6NDY6IjxcP3BocFxzKmV2YWxcKGd6aW5mbGF0ZVwoYmFzZTY0X2RlY29kZVwoIkRaWkgiO2k6NjYwO3M6Nzk6IjtccypldmFsXChcJEdMT0JBTFNcWydcdysnXF1cW1xkK1xdXChcJEdMT0JBTFNcWydcdysnXF1cW1xkK1xdXChcJFx3K1wpXClcKTtcPz4iO2k6NjYxO3M6MTQ0OiJlcnJvcl9yZXBvcnRpbmdcKHJvdW5kXChcZCtcKVwpO21iX2ludGVybmFsX2VuY29kaW5nXChfXHcrXChcZCtcKVwpO21iX3JlZ2V4X2VuY29kaW5nXChfXHcrXChcZCtcKVwpO21iX2h0dHBfb3V0cHV0XChfXGQrXChcZCtcKVwpO21iX2h0dHBfaW5wdXQiO2k6NjYyO3M6MTM4OiIsXCRcdytccyosXCRcdytccypcKTtcJFx3K1xzKj1cJFx3K1xzKlwoWyInXS4rP1siJ10sXCRcdytccyosXCRcdytccypcKTtcJFx3K1xzKj1cJFx3K1xzKlwoXCRcdytccyosXCRcdytccypcKTtcJFx3K1xzKlwoXCRcdytccypcKTtccypcPz4iO2k6NjYzO3M6MTkxOiJcJFx3K1xzKj1ccyoxO1xzKlwkXHcrXHMqPVxzKmdldF91c2VyZGF0YVwoXCRcdytcKTtccypcJFx3K1xzKj1ccypcJFx3Ky0+XHcrO1xzKndwX3NldF9jdXJyZW50X3VzZXJcKFwkXHcrXHMqLFxzKlwkXHcrXCk7XHMqd3Bfc2V0X2F1dGhfY29va2llXChcJFx3K1wpO1xzKmRvX2FjdGlvblwoJ3dwX2xvZ2luJ1xzKixccypcJFx3K1wpOyI7aTo2NjQ7czo2NDoiPFw/XHMqZXZhbFwoZ3p1bmNvbXByZXNzXChiYXNlNjRfZGVjb2RlXCgnLnsyMjAwMCwyNTAwMH0nXClcKVwpOyI7aTo2NjU7czoxOTA6ImZ1bmN0aW9uXHMqXHcrXChcJFx3KyxcJFx3KyxcJFx3K1wpXHtcJFx3Kz0iYmFzZTY0X2RlY29kZS4qP2N1cmxfaW5pdC4qPyIvd3BcXC1sb2dpblxcXC5waHAuKj8vXFwvYWRtaW5pc3RyYXRvclxcLy8iLio/cGhwbXlhZG1pbi9pIi4qP2RlZmluZVwoIl9fX05PVFNFTEZfX18nLDFcKTsuKj9pbmNsdWRlX29uY2UuKj9cKi9cfVx9XH0iO2k6NjY2O3M6MjkyOiJwaHBfdW5hbWUoKVwoXClcLic8YnI+PC9iPic7XHMqZWNob1xzKic8Zm9ybSBhY3Rpb249IiIgbWV0aG9kPSJwb3N0IiBlbmN0eXBlPSJtdWx0aXBhcnQvZm9ybS1kYXRhIiBuYW1lPSJ1cGxvYWRlciIgaWQ9InVwbG9hZGVyIj4nLio/aWZcKFxzKlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXFsnX3VwbCdcXVxzKj09XHMqIlVwbG9hZCJccypcKVxzKlx7XHMqaWZcKFxAY29weVwoXCRfRklMRVNcWydmaWxlJ1xdXFsndG1wX25hbWUnXF0sXHMqXCRfRklMRVNcWydmaWxlJ1xdXFsnbmFtZSdcXVwpIjtpOjY2NztzOjE2MToiKFwkXHcrXGQrXHtcZCtcfVxzKlwuP1xzKil7MTAsfS4rP1wkXHcrXHMqPVxzKlwkXHcrXChccyoiIlxzKixccypcJFx3K1woXCRcdytccypcKFxzKmFycmF5XChcJFx3K1xkK1x7XGQrXH1ccyosXHMqIlxcbiJcKSxccyoiIixccyoiLis/XClccypcKVxzKlwpO1xzKlwkXHcrXChcKTsiO2k6NjY4O3M6NzI6ImV2YWxcKHN0cmlwc2xhc2hlc1woYXJyYXlfcG9wXChcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVwpXClcKSI7aTo2Njk7czoxMTc6ImFzc2VydF9vcHRpb25zXChBU1NFUlRfV0FSTklORywwXCk7XHMqXCRcdys9J1swLTlhLWZBLUZdKyc7Lio/Y2hyXChoZXhkZWMuKj9cJFx3Kz0nZXZhbFwoXCRcdytcKSc7XHMqYXNzZXJ0XChcJFx3K1wpOyI7aTo2NzA7czoxMDg6IlwkXHcrXHMqPVxzKkFycmF5XChccyooJ1x3J1xzKj0+XHMqJ1x3J1xzKiw/XHMqKStcKTtccypldmFsKC9cKlteKl0rXCopPy9cKFxzKlx3K1woXCRcdytccyosXHMqXCRcdypcKVxzKlwpOyI7aTo2NzE7czo5NToiPFw/cGhwXHMqZXJyb3JfcmVwb3J0aW5nXCgwXCk7XHMqaWYgXCghaXNzZXRcKFwkX0NPT0tJRVxbJ1x3KydcXVwpXClccypkZW55XChcKTtccypcJGNvb2tpZURhdGEiO2k6NjcyO3M6MjAyOiJlcnJvcl9yZXBvcnRpbmdcKDBcKTtccypcJFx3K1xzKj1ccyoiXHd7MzJ9IjtccypcJFx3K1xzKj1ccypiYXNlbmFtZVwoX19GSUxFX19cKTtccypcJFx3K1xzKj1ccyoiXHd7MzJ9IjtccyppZlwoaXNzZXRcKFwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXFsnXHcrJ1xdXClcKVxzKntpZlwoc3RybGVuXChcJFx3K1wpXHMqPT1ccyozMlwpIjtpOjY3MztzOjEyNToiXCRsb2dpbj0iXHcrIjtccypcJFx3Kz1zdHJfcm90MTNcKCJcdysiXCk7XHMqXCRcdytccyo9XHMqc3RyX3JvdDEzXCgnXHcrJ1wpO1xzKlwkXHcrPSJcd3szMn0iO1xzKmV2YWxcKFwkbWRoXChcJG1kXChzdHJyZXZcKCciO2k6Njc0O3M6MzM6IigvXCpbXlwqXStcKi9cJFx3Kz0nW14nXSsnOyl7MzAsfSI7aTo2NzU7czoxNzA6IlwkXHcrXHMqPVxzKidbXC5wcmVnX3JlcGxhY2VcJ10rJztccypcJGNhbGxfdXNlcl9mdW5jX2FycmF5XChccypcJFx3K1xzKixccyphcnJheVwoJy9cW1x3K1xdL1x3KydccyosXHMqXCRfUkVRVUVTVFxbIlx3KyJcXVxzKixccyoiW14iXSsiXHMqXClcKTtAXHcrXChccypcJF9SRVFVRVNUXHMqXCk7IjtpOjY3NjtzOjEwOToiXCRcdytccyo9XHMqXCRcdytcKFxzKiIiXHMqLFxzKlwkXHcrXChccypcJFx3K1woXHMqYXJyYXlcKFwkXHcrXHtcZCtcfVxzKixccyoiXFxuIlxzKlwpLFxzKiIiLFxzKiJbXiJdKyJccypcKSI7aTo2Nzc7czo4MjoiXCRkZWZhdWx0X2FjdGlvbj1bRmlsZXNNYW4nXC5dKztccypcJGNvbG9yPVsnXCNkZjVcLl0rO1xzKlwkZGVmYXVsdF91c2VfYWpheD10cnVlOyI7aTo2Nzg7czo4OToiXCRcdytccyo9XHMqXCRcdytcKCcuKz8nXCk7XHMqXCRcdys9XCRcdytcKFwkXHcrXChcKVwpO1wkXHcrXChcKTtccypcJFx3K1woXCRcdyssIlwkXHcrXCgiO2k6Njc5O3M6MTQ3OiJcJFx3K1xzKj1ccyonW2Fzc2VydFwnXC5cc10rJztccypcJFx3K1xzKj1ccypzcHJpbnRmXCgnW1whXChcKWV2YWxiYXNlNjRfZGVjb2RlXHNcLlwnXStcKCIlcyJcKVwpJ1xzKixccypcJFx3K1wpO1xzKlwkXHcrXChzdHJpcHNsYXNoZXNcKFwkXHcrXClcKTsiO2k6NjgwO3M6NzY6IjxcP2Vycm9yX3JlcG9ydGluZ1woMFwpOyhcJFx3Kz0odXJsZGVjb2RlXCgpP1wkX0NPT0tJRVxbJ1x3KydcXVwpPztccyopezEwLH0iO2k6NjgxO3M6ODI6IjxcP3BocFxzKlwkXHcrPXN0cnJldlwoImVkb2NlZF80NmVzYWIiXCk7XCRcdys9IlteIl0rIjtldmFsXChcJFx3K1woXCRcdytcKVwpO1xzKiQiO2k6NjgyO3M6MTI1OiInO1wkXHcrPXN0cl9yb3QxM1woJ2ZnZV9lYmcxMydcKTtcJFx3Kz1cJFx3K1woJ29uZnI2NF9xcnBicXInXCk7XCRcdys9XCRcdytcKCcuKz8nXCk7ZXZhbFwoXCRcdytcKFwkXHcrXChcJFx3K1woXCRcdytcKVwpXClcKSI7aTo2ODM7czo4MzoiXCRfXz1oZXgyYXNjaWlcKFwkXytcKTtccypcJC49IlwkXysiO1xzKlwkLj1bZXZhbFwuIidcc10rXChcJC5cKSc7XHMqYXNzZXJ0XChcJC5cKTsiO2k6Njg0O3M6NTc6In19ZWxzZXtcJFx3Kz1AXCRfU0VSVkVSXFsoKCIifGNoclwoXGQrXCl8Ilx3IilcLj8pezEwLH1dOyI7aTo2ODU7czoyMjE6ImlmXHMqXChpc3NldFwoXCRfRklMRVNcWydcdysnXF1cWyduYW1lJ1xdXClcKVxzKntccypcJGFib2Rccyo9XHMqXCRmaWxlZGlyXC5cJHVzZXJmaWxlX25hbWU7XHMqQG1vdmVfdXBsb2FkZWRfZmlsZVwoXCR1c2VyZmlsZV90bXAsXHMqXCRhYm9kXCk7XHMqZWNobyI8Y2VudGVyPjxiPkRvbmVccyo9PT5ccypcJHVzZXJmaWxlX25hbWU8L2I+PC9jZW50ZXI+Ijtccyp9XHMqfVxzKmVsc2V7IjtpOjY4NjtzOjMzNjoiPFw/cGhwXHMqKFwkXHcrKSA9IFwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXFsnXHcrJ1xdO1xzKmVjaG8gKFwkXHcrKSA9IGlzc2V0XChcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxbJyhcdyspJ1xdXClcP2Jhc2U2NF9kZWNvZGVcKFwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXFsnXDMnXF1cKTonJztccyooXCRcdyspID0gJyc7XHMqZm9yZWFjaFwoYXJyYXlcKFwxXCkgYXMgKFwkXHcrKVwpe1xzKlw0XC49XDU7XHMqfVxzKm9iX3N0YXJ0XChcNFwpO1xzKmlmXChcMlwpe1xzKmVjaG8gXDI7XHMqfVxzKm9iX2VuZF9mbHVzaFwoXCk7IjtpOjY4NztzOjY4OiJ9fX19aWZcKFwkcT09InRoaXMtaXMtdGhlLXRlc3Qtb2YtZG9vciJcKXtcJHBhZ2U9IkRPT1JXQVlJU1dPUktUSVRMRSI7aTo2ODg7czoxNzk6ImlmXChcJFx3Kz1AZ3ppbmZsYXRlXChcJFx3K1wpXClce2lmXChpc3NldFwoXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClcWydcdysnXF1cKVwpQHNldGNvb2tpZVwoJ1x3KycsIFwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXFsnXHcrJ1xdXCk7XCRcdys9Y3JlYXRlX2Z1bmN0aW9uIjtpOjY4OTtzOjk1OiJcJFx3Kz1AZ3ppbmZsYXRlXChcJFx3K1wpXCl7XCRcdys9Y3JlYXRlX2Z1bmN0aW9uXCgnJyxcJFx3K1wpO3Vuc2V0XChcJFx3KyxcJFx3K1wpO1wkXHcrXChcKTt9fSI7aTo2OTA7czo2OToiXCRcdys9J1teJ10rJ1xeJ1teJ10rJztccypcJFx3Kz0nW14nXSsnO1xzKihcJFx3Kz0nW14nXSsnfFwkXHcrPVxkKyk7IjtpOjY5MTtzOjE4OiJGYWtlU2VuZGVyIGJ5IFBPQ1QiO2k6NjkyO3M6Njk6InByb2Z0cGQuKz9ldmFsXChcJF9bR0VUfFBPU1R8Q09PS0lFfFJFUVVFU1R8U0VSVkVSXStcW1snIl1cdytbJyJdXF1cKSI7aTo2OTM7czoxMjY6IjxcP3BocFxzKmlmXHMqXChpc3NldFxzKlwoXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClcWydcdysnXF1cKVwpXHMqe1xzKlwkXHcrPSJGaWwuKz9ccypcJGRlZmF1bHRfdXNlX2FqYXhccyo9XHMqdHJ1ZSI7aTo2OTQ7czo4NzoiXCRcdytccyo9XHMqIlx3KyI7XHMqXCRcdytccypccypcLj1ccyoiXHcrIjtccypAXCRcdytcKFwkXHcrXChcJ1thLXpBLVowLTkvPStdezEwMCwyMDB9IjtpOjY5NTtzOjMwOiI7ZXVydFxzKj1ccyp4YWphX2VzdV90bHVhZmVkXCQiO2k6Njk2O3M6MTM5OiJcJFx3K1xzKj1ccyoiLis/IjtcJFx3K1xzKj0oXHMqXCRcdytcW1xkK1xdXHMqXC4/KXs1LH07XCRcdytccyo9XHMqWyJcXGEtekEtWjAtOSgpLlxzXSs7XCRcdytccyo9XHMqIi4rPyI7XCRcdytccyo9XHMqXCRcdytccypcLlxzKiJcU3syMDB9IjtpOjY5NztzOjYxOiJcJGFycmF5XHMqPVxzKmJhc2U2NF9kZWNvZGVcKFwkYXJyYXlcKTtccypAYXNzZXJ0XChcJGFycmF5XCk7IjtpOjY5ODtzOjQ4OiI8XD9waHBccypcJGFycklkXHMqPVxzKmFycmF5XCgoJ1xkKy1cZCsnXHMqLFxzKikiO2k6Njk5O3M6NDc6Ijx0aXRsZT5ccypEYXJrIFNoZWxsXHMqPC90aXRsZT4uK2NsZWFyc3RhdGNhY2hlIjtpOjcwMDtzOjY2OiJzdHJfcmVwbGFjZVwoJ2RlZmluZVwoIlBSRU5BTUUiLCJcZCsiXCk7J1xzKixccyonZGVmaW5lXCgiUFJFTkFNRSIiO2k6NzAxO3M6Njg6IlwkQ29udGVudF9tYj1nZXRIVFRQUGFnZVwoXCRSZW1vdGVfc2VydmVyXC4iL2luZGV4XC4oaHRtbHxwaHApXD9ob3N0IjtpOjcwMjtzOjQyOiJcJHdlZmZfY2xpZW50XHMqPVxzKm5ld1xzK1RXZWZmQ2xpZW50XChcKTsiO2k6NzAzO3M6NDY6IlwkZGF0YSA9IGN1cmxfZ2V0X2Zyb21fd2VicGFnZV9vbmVfdGltZVwoXCR1cmwiO2k6NzA0O3M6MTQ5OiJcJHN1XHMqPVxzKnN0cl9yZXBsYWNlXCgnXCRuYW1lJ1xzKixccypcJG5ccyosXHMqc3RyaXBzbGFzaGVzXChccypiYXNlNjRfZGVjb2RlXChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxbXHMqJ3oyJ1xzKlxdXHMqXClccypcKVxzKlwpOyI7aTo3MDU7czo1OToiX19jcmVhdGVfaW5pdGlhbF9zZXR0aW5nc1teXCNdK1wjZ29vZ2xlLis/X19vYmZ1c2NhdGVfd3JpdGUiO2k6NzA2O3M6MTMzOiJmdW5jdGlvblxzKmlzX2Zyb21fc2VhcmNoXChcJGh0dHBfcmVmZXJlclwpXHMqe1xzKlwkZmxhZ1xzKj1ccypmYWxzZTtccypcJGh0dHBfcmVmZXJlcl9zdHJccyo9XHMqJ2dvb2dsZVwuY29cLmpwXHx5YWhvb1wuY29cLmpwXHxiaW5nIjtpOjcwNztzOjEzNjoiaWZccypcKGZpbGVfZXhpc3RzXChccyoiKFwuXC4vKStcdytcLnBocFwuc3VzcGVjdGVkIlxzKlwpXHMqXClccypyZW5hbWVcKFxzKiIoXC5cLi8pK1x3K1wucGhwXC5zdXNwZWN0ZWQiXHMqLFxzKiIoXC5cLi8pK1x3K1wucGhwIlxzKlwpOyI7aTo3MDg7czoyMDg6IlwkbWFwX2luZGV4X3NpdGVtYXBfdXJpXHMqPVxzKnNwcmludGZcKCclcyVzc2l0ZW1hcF8lZFwueG1sJ1xzKixccypcJGN1cnJlbnRVcmxccyosXHMqIlwkZGlyLyJccyosXHMqXCRzaW5pXCk7XHMqXCRtYXBfc2l0ZW1hcF9nZW51cmlfaHJlZlxzKj1ccypzcHJpbnRmXChccypcJG1hcF9zaXRlbWFwX2dlbnVyaV9saW5rX2Zvcm1hdFxzKixccypcJGN1cnJlbnRVcmwiO2k6NzA5O3M6MTE1OiJmdW5jdGlvblxzK19fZ2V0X3RlbXBsYXRlXChcKVxzKntccypcJHJvb3RfcGF0aFxzKj1ccypfX2dldF9yb290XChcKTtccypcJHRwbF9wYXRoXHMqPVxzKlwkcm9vdF9wYXRoXC4iL1NFU1NfXHd7MzJ9IjtpOjcxMDtzOjExODoiXX09QXJyYXlcKCJcdysiPT5AcGhwdmVyc2lvblwoXCksIlxceFxkK1xceFxkKyI9PiJcXHhcZCtcLlxceFxkKy0xIixcKTtlY2hvXHMqQHNlcmlhbGl6ZVwoXCR7XCRcdytcfVwpO31lbHNlaWZcKFwke1wkeyI7aTo3MTE7czoxMDk6Ii8vXHd7MywyMH1ccypmdW5jdGlvblxzK3JlcXVlc3RfdXJsX2RhdGFcKFwkdXJsXClccyp7XHMqXCRzaXRlX3VybFxzKj0uKz9wcmludFxzK1wkZGVjb2RlZDtccyp9XHMqfS8vXHd7MywyMH0iO2k6NzEyO3M6MTgxOiJmdW5jdGlvblxzK2V2YWxFbmRDbGVhblwoJlxzKlwkcFwpIHtccypcJHQgPSBnenVuY29tcHJlc3NcKGJhc2U2NF9kZWNvZGVcKFwkcFwpXCk7XHMqXCR0ID0gc3RyX3JlcGxhY2VcKGFycmF5XCgiPFw/cGhwIiwnXD8+J1wpLCcnLFwkdFwpO1xzKmV2YWxcKFwkdFwpO1xzKnVuc2V0XChcJHBcKTt1bnNldFwoXCR0XCk7IjtpOjcxMztzOjEzMzoiPGgxPiJcLnVjZmlyc3RcKFwka2V5XClcLiI8L2gxPjxicj5ccyo8YnI+IlwuXCR0ZW1wbGF0ZWltYWdlXC4iPGJyPjxicj5ccyoiXC5cJG1hcGlucGFnZXNcLiJccyoiXC5cJHBhZ2VwYXJzZVwuIjxicj5ccyoiXC5cJGxpbmtzMVwuIiI7aTo3MTQ7czoxMTY6ImZ1bmN0aW9uXHMrcHVzaFVwbG9hZGVyc1woXClccyp7XHMqZ2xvYmFsXHMqXCR1cGxvYWRlclN0YXR1c0hhbmRsZTtccypcJGRhdGFccyo9XHMqcmVhZEZpbGVPcHRcKENBQ0hFX1VQTE9BREVSX0RCXCk7IjtpOjcxNTtzOjc1OiI7XHMqXCRkZWZhdWx0X3VzZV9hamF4XHMqPVxzKmZhbHNlO1xzKlwkZGVmYXVsdF9jaGFyc2V0XHMqPS4rcHJpbnRccypldmFsXCgiO2k6NzE2O3M6MjU1OiJmdW5jdGlvblxzK1dTT3N0cmlwc2xhc2hlc1woXCRhcnJheVwpXHMqe1xzKnJldHVybiBpc19hcnJheVwoXCRhcnJheVwpXHMqXD9ccyphcnJheV9tYXBcKFsnIl1XU09zdHJpcHNsYXNoZXNbJyJdXHMqLFxzKlwkYXJyYXlcKVxzKjpccypzdHJpcHNsYXNoZXNcKFwkYXJyYXlcKTtccyp9XHMqXCRfUE9TVFxzKj1ccypXU09zdHJpcHNsYXNoZXNcKFwkX1BPU1RcKTtccypcJF9DT09LSUVccyo9XHMqV1NPc3RyaXBzbGFzaGVzXChcJF9DT09LSUVcKTsiO2k6NzE3O3M6MTMwOiJmdW5jdGlvblxzKnJlZmVyY2hlY2tcKFwkcmVmZXJccyo9XHMqIiJcKVxzKntccypyZXR1cm5ccypwcmVnX21hdGNoXCgiL1woZ29vZ2xlXC5jb1wuanBcfHlhaG9vXC5jb1wuanBcfGJpbmdcKS9zaSIsIFwkcmVmZXJcKTtccyp9IjtpOjcxODtzOjE0NzoiaWZccypcKFxzKmlzc2V0XHMqXChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFJFUVVFU1R8U0VSVkVSKVxbXHMqInRlc3RfdXJsIlxzKlxdXHMqXClccypcKVxzKntccyplY2hvXHMqImZpbGUgdGVzdCBva2F5Ijtccyp9LitQQ0xaSVBfT1BUX1JFTU9WRV9QQVRIIjtpOjcxOTtzOjE3OToiaWZccypcKFxzKmlzc2V0XChccypcJF8oR0VUfFBPU1R8UkVRVUVTVHxDT09JRXxTRVJWRVIpXFtccyoidGVzdF91cmwiXHMqXF1ccypcKVxzKlwpXHMqe1xzKmVjaG9ccysiZmlsZSB0ZXN0IG9rYXkiO1xzKn1ccypcJFx3ezEsMTB9PSJcdysiO1xzKlwkXHd7MSwxMH09J1x3Kyc7XHMqXCRcd3sxLDEwfT0iXHcrIjsiO2k6NzIwO3M6MzA6IlwkYXV0aF9wYXNzXHMqPS4rO2V2YWxcKCJcXHg2NSI7aTo3MjE7czo4OToiY2hlY2tzdWV4ZWNccysiXC5lc2NhcGVzaGVsbGFyZ1woXCRfU0VSVkVSXFsnRE9DVU1FTlRfUk9PVCdcXVwuXCRfU0VSVkVSXFsnUkVRVUVTVF9VUkknXF0iO2k6NzIyO3M6NTI6ImZ1bmN0aW9uXHMrZ2V0X2RhdGFfeWFcKFwkdXJsXCkuK3ByZWdfbWF0Y2hcKCdcI2dvZ28iO2k6NzIzO3M6Njk6Ilwkc3RyRmlsZUJvZHk9R2V0RmlsZUNvbnRlbnRcKFwkc3RyVXJsXCk7XHMqXCRzdHJGaWxlQm9keT1zdHJfcmVwbGFjZSI7aTo3MjQ7czoxODg6IlwkXHcrPWd6aW5mbGF0ZVwoYmFzZTY0X2RlY29kZVwoXCRcdytcKVwpO1xzKmZvclwoXCRpPTA7XCRpPHN0cmxlblwoXCRcdytcKTtcJGlcK1wrXClccyp7XHMqXCRcdytcW1wkaVxdXHMqPVxzKmNoclwoXHMqb3JkXChcJFx3K1xbXCRpXVwpXHMqLTFccypcKTtccyp9XHMqcmV0dXJuXHMqXCRcdys7XHMqfVxzKmV2YWxcKFx3K1woIjtpOjcyNTtzOjI4OiI8dGl0bGU+UEhQLUZJTEVTXC5NRTwvdGl0bGU+IjtpOjcyNjtzOjI3OToiaWZcKCFmdW5jdGlvbl9leGlzdHNcKCJcdysiXClcKXtmdW5jdGlvbiBcdytcKFwkXHcrXCl7XCRcdys9YmFzZTY0X2RlY29kZVwoXCRcdytcKTtcJFx3Kz0wO1wkXHcrPTA7XCRcdys9MDtcJFx3Kz1cKG9yZFwoXCRcdytcWzFcXVwpPDw4XClcK29yZFwoXCRcdytcWzJcXVwpO1wkXHcrPTM7XCRcdys9MDtcJFx3Kz0xNjtcJFx3Kz0iIjtcJFx3Kz1zdHJsZW5cKFwkXHcrXCk7XCRcdys9X19GSUxFX187XCRcdys9ZmlsZV9nZXRfY29udGVudHNcKFwkXHcrXCk7XCRcdys9MDtwcmVnX21hdGNoIjtpOjcyNztzOjE1MjoiXCRyZXFfdXJpXHMqPVxzKidodHRwOi8vJ1wuXCRyZXFfdXJpXC4iXD9yZXE9IlwudXJsZW5jb2RlXChcJGZ1bGxfdXJpXClcLiImZ3ppcD0iXC5cJGlzX2d6aXBcLiImaG9zdD1cJGhvc3QmaXA9XCRpcCZyaXA9XCRyZXZlcnNlX2lwJnVhPVwkdWEmcmVmPVwkcmVmIjsiO2k6NzI4O3M6MjE1OiJcJEdMT0JBTFNcWydfXGQrXydcXT1BcnJheVwoYmFzZTY0X2RlY29kZVwoLis/XFstXF0gU09DS0VUIEVSUk9SXFtmc29ja1xdOiB7XCRfXGQrXFtwYXRoXF19IFxbXHtcJF9cZCtcfVxdIHtcJF9cZCt9Ijt9XCRfXGQrPUZBTFNFO319aWZcKFwkX1xkKz09PUZBTFNFXCl7aWZcKFwkX1xkK1wpe3ByaW50IF9cZCtcKFxkK1wpO31cJF9cZCs9RkFMU0U7fXJldHVybiBcJF9cZCs7fSI7aTo3Mjk7czoxMzI6ImlmXChQTEFURk9STVxzKj09XHMqV09SRFBSRVNTXClccyp7XHMqaWZcKHN0cnBvc1woXCRmaWxlXHMqLFxzKid3cC1jb250ZW50J1wpXHMqPT09XHMqZmFsc2VccyomJlxzKnN0cnBvc1woXCRmaWxlXHMqLFxzKid3cC1hZG1pbidcKSI7aTo3MzA7czo2NzoiXCRsZWFmXFsndmVyc2lvbidcXT0iMlwuNyI7XHMqXCRsZWFmXFsnd2Vic2l0ZSdcXT0ibGVhZm1haWxlclwucHciOyI7aTo3MzE7czoxNDY6Im1haWxcKFwkX1BPU1RcWydlbWFpbCdcXVxzKixccypcJF9QT1NUXFsnc3ViamVjdCdcXVxzKixccypcJF9QT1NUXFsnY29udGVudCdcXVxzKixccypcJGhlYWRlcnNcKTtccyplY2hvICJCcmF2byEiO1xzKn1ccypcPz5ccyo8dGl0bGU+Qk9PTTwvdGl0bGU+IjtpOjczMjtzOjE1ODoiaWZcKG1haWxcKFwkX1BPU1RcWydlbWFpbCdcXSwgXCRfUE9TVFxbJ3N1YmplY3QnXF0sIFwkX1BPU1RcWydjb250ZW50J1xdLCBcJGhlYWRlcnNcKVwpIHtccyplY2hvICJCcmF2byEiO1xzKn1ccyplbHNlXHMqe1xzKmVjaG8gIkZhaWxlZCB0byBzZW5kIGVtYWlsXC4iO1xzKn0iO2k6NzMzO3M6MTI5OiJtYWlsXChcJF9QT1NUXFsnZW1haWwnXF1ccyosXHMqXCRfUE9TVFxbJ3N1YmplY3QnXF1ccyosXHMqXCRfUE9TVFxbJ2NvbnRlbnQnXF1ccyosXHMqXCRoZWFkZXJzXCk7XHMqfVxzKlw/PlxzKjx0aXRsZT5CT09NPC90aXRsZT4iO2k6NzM0O3M6NTA6Il5HSUY4XGQrLis/PFw/cGhwXHMqZXZhbFxzKlwoXHMqYmFzZTY0X2RlY29kZVxzKlwoIjtpOjczNTtzOjgzOiJcJFx3K1woXCRcdytcKFwkXHcrXChcJFx3K1woXCRcdytcKVwpXClcKTtccyovXCpccypHTlVccytHRU5FUkFMXHMrUFVCTElDXHMrTElDRU5TRSI7aTo3MzY7czoxODk6ImNhc2VccypbIidddXBkYXRlWyInXVxzKjpccyppZlxzKlwoXHMqZmlsZV9wdXRfY29udGVudHNccypcKFxzKl9fRklMRV9fXHMqLFxzKiBiYXNlNjRfZGVjb2RlXChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxbXHMqWyciXVx3K1snIl1ccypcXVxzKlwpXHMqXClccypcKVxzKmVjaG9ccypbJyJdT0tbJyJdOyI7aTo3Mzc7czo0NDg6IlwkXHd7MSwzMH1ccyo9XHMqc3RyX2lyZXBsYWNlXChccyoiXHd7MSwzMH0iXHMqLFxzKiIiXHMqLFxzKiJbXiJdKyJccypcKTtccypcJFx3ezEsMzB9XHMqPVxzKiJbXiJdKyJccyo7XHMqZnVuY3Rpb25ccytcd3sxLDMwfVwoXHMqXCRlcnJub1xzKixccypcJGVycnN0clxzKixccypcJGVycmZpbGVccyosXHMqXCRlcnJsaW5lXHMqXClccyp7XHMqYXJyYXlfbWFwXChccypjcmVhdGVfZnVuY3Rpb25ccypcKFxzKicnXHMqLFxzKlwkZXJyc3RyXClccyosXHMqYXJyYXlccypcKFxzKicnXHMqXClccypcKTtccyp9XHMqc2V0X2Vycm9yX2hhbmRsZXJcKFxzKidcd3sxLDMwfSdccypcKTtccypcJFx3ezEsMzB9XHMqPVxzKlwkXHd7MSwzMH1cKFxzKlwkXHd7MSwzMH1ccypcKVxzKjtccyoodXNlcnx0cmlnZ2VyKV9lcnJvclwoXHMqXCRcd3sxLDMwfVxzKixccypFX1VTRVJfRVJST1JccypcKTsiO2k6NzM4O3M6ODg6IiI7XHMqZXZhbFxzKi9cKlteKl0rXCovXHMqXChcd3sxLDMwfVxzKlwoXHMqXCRcd3sxLDMwfVxzKixccypcJFx3ezEsMzB9XHMqXClccypcKTtccypcPz4iO2k6NzM5O3M6MTA4OiIoXCRcd3sxLDQwfVxzKj1ccyonW14nXXsxLDIwMH0nO1xzKil7MTAsfVwkXHd7MSw0MH09c3RyX3JlcGxhY2VcKCdbXiddezEsNTB9JywnJywoXCRcd3sxLDQwfVtcc1wuXCldKyl7MTAsfTsiO2k6NzQwO3M6NzA6ImNoclwoXGQrXCkuKz9AXCRcd3sxLDMwfVwoXHMqQFwkXHd7MSwzMH1cKFxzKlsnIl1bXiciXXs1MDAwLH1bJyJdXClcKTsiO2k6NzQxO3M6NzI6ImNoclwoXGQrXCkuKz9AXCRcd3sxLDMwfVwoXHMqQFwkXHd7MSwzMH1cKFxzKlsnIl1bXiciXXsxMDAwLH1bJyJdXClcKVwpOyI7aTo3NDI7czoxODM6ImZ1bmN0aW9uIGFycjJodG1sXChcJGFycmF5LFxzKiZcJGFyclxzKj1ccyonXHMqJyxcJHp0YWJodG1sPScnLFwkemhlYWRlcmFycmF5PScnXClccyp7XHMqXCRhcnJheVxzKj1ccyoiYXMiXHMqXC5ccypcJF9SRVFVRVNUXFsnYXJyYXknXF07XHMqXCRzb3J0XHMqPVxzKmFycmF5XChcJF9SRVFVRVNUXFsnc29ydCdcXVwpOyI7aTo3NDM7czo5NzoiXCR3cGF1dG9wXHMqPVxzKnByZV90ZXJtX25hbWVcKFxzKlwkd3Bfa3Nlc19kYXRhXHMqLFxzKlwkd3Bfbm9uY2VccypcKTsuKlwkc2hvcnRjb2RlX3VuYXV0b3BcKFwpOyI7aTo3NDQ7czo0MjoiPHRpdGxlPlxzKkRhcmsgU2hlbGxccyo8L3RpdGxlPi4qZnNvY2tvcGVuIjtpOjc0NTtzOjk3OiI8XD9waHBccypcJFx3K1xzKj1ccypbJyJdXHd7MzJ9WyciXTtccypcJFx3K1xzKj1ccypbJyJdXCNkZjVbJyJdO1xzKlwkXHcrXHMqPVxzKlsnIl1GaWxlc01hblsnIl07IjtpOjc0NjtzOjc4OiJcJGNvZGVccyo9XHMqJ1xzKjxcP3BocFxzKlwkdXNlcl9hZ2VudF90b19maWx0ZXIgPSBhcnJheVwoIFxcJ1wjQXNrXFxzXCpKZWV2ZXMiO2k6NzQ3O3M6NTg6IlwuKFwkXHd7MSwxMH1cKCl7Nix9WyInXShcXHhbQS1GYS1mMC05XXsyfSl7MTAsMTEwMH1bIiddXCkiO2k6NzQ4O3M6MTMyOiJcJHppcFxzKj1ccypuZXdccypaaXBBcmNoaXZlO1xzKlwkcmVzXHMqPVxzKlwkemlwLT5vcGVuXChccypkaXJuYW1lXChccypfX0ZJTEVfX1xzKlwpXHMqXC5ccyonL3VwZGF0ZVwuemlwJ1xzKlwpO1xzKlwkemlwLT5leHRyYWN0VG8iO2k6NzQ5O3M6MTA4OiJwcmVnX3NwbGl0XCgiLy8iLFwkXHcrLC0xLFBSRUdfU1BMSVRfTk9fRU1QVFlcKTtcJFx3Kz1pbXBsb2RlXCgiIixhcnJheV9yZXZlcnNlXChcJFx3K1wpXCk7fTtcJFx3Kz1fX0ZJTEVfXzsiO2k6NzUwO3M6MTU1OiJcJFx3ezEsMjB9XHMqPVxzKlwkXHd7MSwyMH1ccypcKFxzKlwkXyhHRVR8UE9TVHxDT09LSUV8UkVRVUVTVHxTRVJWRVIpXHMqXFtccypcJFx3ezEsMjB9XHMqXF1ccypcKVxzKjtccypAP2V2YWxccypcKFxzKlwkXHd7MSwyMH1ccypcKVxzKjtccypcfVxzKmVsc2VccypceyI7aTo3NTE7czo0OToiPFxzKlw/XHMqcGhwXHMqL1wqXHMqV1NPXHMqXFtccyoyXHMqXC5ccypcZCtccypcXSI7aTo3NTI7czozMzoiXCRHTE9CQUxTXFsnQWxmYV9Qcm90ZWN0X1NoZWxsJ1xdIjtpOjc1MztzOjIwMjoiXCRcd3sxLDQwfVxzKj0iW14iXSoiXHMqO1xzKmVjaG9ccypcJFx3ezEsNDB9XHMqO1xzKmV4aXRccypcKFxzKlwpXHMqO1xzKlx9XHMqXCRcd3sxLDQwfVxzKj1cJFx3ezEsNDB9XHMqO1xzKlwkXHd7MSw0MH1ccyo9XHMqaXNzZXRccypcKFxzKlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXHMqXFtccyoiW14iXSoiXHMqXF1ccypcKVxzKiI7aTo3NTQ7czoyODg6ImlmXHMqXChccyppc3NldFxzKlwoXHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKidbXiddKidccypcXVxzKlwpXHMqPT09XHMqdHJ1ZVxzKlwpXHMqXHtccypDaGVja1xzKlwoXHMqXClccyo7XHMqZXhpdFxzKjtccypcfVxzKmlmXHMqXChccyppc3NldFxzKlwoXHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKidbXiddKidccypcXVxzKlwpXHMqPT09XHMqdHJ1ZVxzKlwpXHMqXHtccypTZW5kXHMqXChccypcKVxzKjtccypleGl0XHMqO1xzKiI7aTo3NTU7czoyNTM6IlwkXHd7MSw0MH1ccyo9XHMqQD9nZXRjd2RccypcKFxzKlwpXHMqO1xzKmlmXHMqXChccyppc3NldFxzKlwoXHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKidbXiddKidccypcXVxzKlwpXHMqXClccypAY2hkaXJccypcKFxzKlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXHMqXFtccyonW14nXSonXHMqXF1ccypcKVxzKjtccypcJFx3ezEsNDB9XHMqPVxzKkA/Z2V0Y3dkXHMqXChccypcKVxzKjsiO2k6NzU2O3M6Mjg6Ik1haWxlclxzK2J5XHMrU3BoaW54PC90aXRsZT4iO2k6NzU3O3M6MzI6Ijx0aXRsZT4oY1BhbmVsXHMrKT9UdXJib1xzK0ZvcmNlIjtpOjc1ODtzOjExMzoiPFw/cGhwXHMqKC8vaGVhZGVyXCgnQ29udGVudC1UeXBlOnRleHQvaHRtbDsgY2hhcnNldD11dGYtOCdcKTspPyhccypcJFtPMF9dKz0oJ1teJ10qJ3xcZCspOyl7Myx9XHMqXCRbTzBfXSs9YXJyYXkiO2k6NzU5O3M6MTQ6IlwuL1wqLS9cKi1cKi8iIjtpOjc2MDtzOjI5OiJwYXRoX3Rocm93Z2hfZmlsZXMuK2J1cmx5d29vZCI7aTo3NjE7czo3MToiXCMhL3Vzci9iaW4vcGVybFxzKy13XHMqbXlccytcJFBhc3N3b3JkPSJcdysiO1xzKlwkXHcrXHMqPVxzKlsnIl0oXGQrOykiO2k6NzYyO3M6ODg6IjxcPyhwaHApP1xzKlwkYXV0aF9wYXNzXHMqPVxzKiJbXiJdKiI7XHMqXCRHTE9CQUxTXFsnX1xkK18nXF09QXJyYXlcKGJhc2U2NF9kZWNvZGVcKFsnIl0iO2k6NzYzO3M6NzQ6ImNsYXNzXHMrYmJfcHJlc3MyLis/Y29uc3RccypTQ1JJUFRfU1JDXHMqPVxzKidkYXRhOnRleHQvamF2YXNjcmlwdDtiYXNlNjQsIjtpOjc2NDtzOjE2NDoiXCRcdytccyo9XHMqQXJyYXlcKFxzKlteO10rO1xzKlwkXHcrXFtjaHJcKFxzKlxkK1xzKlwpXHMqXVwoYmRcKFxzKlsnIl1bXiciXStbJyJdXHMqXClccypcKTtccypcJFx3K1xbXHMqY2hyXChccypcZCtccypcKVxzKlxdXChccypcdytcKFxzKlsnIl1bXiciXStbJyJdXHMqXClccypcKTsiO2k6NzY1O3M6MjE3OiJpZlxzKlwoXHMqIWNsYXNzX2V4aXN0c1xzKlwoXHMqJ1teJ10qJ1xzKixccypmYWxzZVxzKlwpXHMqXClccyo6XHMqY2xhc3NccypiYl9wcmVzXGQrXHMqXHtccypwdWJsaWNccypzdGF0aWNccypcJFx3ezEsNDB9XHMqPVxzKidbXiddKidccyo7XHMqcHVibGljXHMqc3RhdGljXHMqXCRcd3sxLDQwfVxzKj1ccyonW14nXSonXHMqOy4rZGF0YTp0ZXh0L2phdmFzY3JpcHQ7YmFzZTY0IjtpOjc2NjtzOjEwNjoifVxzKj1ccypAdW5zZXJpYWxpemVcKFxzKnNoX2RlY3J5cHRcKFxzKkBiYXNlNjRfZGVjb2RlXChccypcJHtccypcJFx3K1xzKn1cKVxzKixccypcJHtccypcJHtccyoiW14iXSsiXHMqfSI7aTo3Njc7czo2NDoiZWNob1xzK21haWxcKFwkdG8sXCR0aGVtLFwkbXNzLFwkaGVhZFwpXD9fXGQrXChcZCtcKTpfXGQrXChcZCtcKSI7aTo3Njg7czoxMjI6Imdsb2JhbFxzKlwkXHd7MSw0MH1ccyo7XHMqaWZccypcKFxzKiFpc3NldFxzKlwoXHMqXCRcd3sxLDQwfVxzKlwpXHMqXClccypcJFx3ezEsNDB9XHMqPVxzKm5ld1xzKmRvbGx5X3BsdWdpblxzKlwoXHMqXClccyo7IjtpOjc2OTtzOjY0OiI8XD9waHBccy9cKlxzKi0tXHMqZW5waHAuK31ce1xkK1x9XChFX0FMTFxeRV9OT1RJQ0VcKTtcJF9TRVJWRVJ7IjtpOjc3MDtzOjE3MjoiXCRcd3sxLDQwfVxzKj1cJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqJ1teJ10qJ1xzKlxdXHMqO1xzKmlmXHMqXChccyppbl9hcnJheVxzKlwoXHMqIndwLWNvbmZpZ1wucGhwIlxzKixccypcJFx3ezEsNDB9XHMqXClccypcKVxzKlx7XHMqZmlsZV9wdXRfY29udGVudHNcKCI7aTo3NzE7czoyMjQ6ImNoZGlyXHMqXChccypcJFx3ezEsNDB9XHMqXClccyo7XHMqXCRcd3sxLDQwfVxzKj1ccypnZXRfcmFuZF90b3VjaFxzKlwoXHMqXClccyo7XHMqd3JpdGVUb1xzKlwoXHMqXCRcd3sxLDQwfVxzKixccypiYXNlNjRfZGVjb2RlXHMqXChccypcJFx3ezEsNDB9XHMqXClccyosXHMqZmFsc2VccypcKVxzKjtccyp0b3VjaFxzKlwoXHMqXCRcd3sxLDQwfVxzKixccypcJFx3ezEsNDB9XHMqXClccyo7IjtpOjc3MjtzOjI0MjoiPFxzKm1ldGFccypodHRwLWVxdWl2XHMqPSJbXiJdKiJccypjb250ZW50XHMqPSJbXiJdKiJccyovXHMqPlxzKjxccyp0aXRsZVxzKj5ccypcI1thLXpdK1wjXHMqPFxzKi90aXRsZVxzKj5ccyo8XHMqbWV0YVxzKm5hbWVccyo9ImtleXdvcmRzIlxzKmNvbnRlbnRccyo9IlwjW2Etel0rXCMiXHMqL1xzKj5ccyo8XHMqbWV0YVxzKm5hbWVccyo9ImRlc2NyaXB0aW9uIlxzKmNvbnRlbnRccyo9IlwjW2Etel0rXCMiXHMqL1xzKj4iO2k6NzczO3M6MTE1OiI8XHMqdGl0bGVccyo+XHMqPFxzKlw/XHMqPVwkWjExOF90aXRsZVxzKlwuXHMqIlteIl0qIlxzKlwuXHMqXCRcd3sxLDQwfVxzKlxbXHMqJ1teJ10qJ1xzKlxdXHMqO1xzKlw/PjxccyovdGl0bGVccyo+IjtpOjc3NDtzOjI2NToiXCRcd3sxLDQwfVxzKj1ccypuZXdccypQY2xaaXBccypcKFxzKlwkXHd7MSw0MH1ccypcKVxzKjtccyppZlxzKlwoXHMqXCRcd3sxLDQwfS1ccyo+XHMqZXh0cmFjdFxzKlwoXHMqXClccyo9PVxzKlxkK1xzKlwpXHMqXHtccypkaWVccypcKFxzKiJbXiJdKiJccypcLlxzKlwkXHd7MSw0MH0tXHMqPlxzKmVycm9ySW5mb1xzKlwoXHMqdHJ1ZVxzKlwpXHMqXClccyo7XHMqXH1ccyplbHNlXHMqXHtccypkaWVccypcKFxzKiJbXiJdKiJccypcKVxzKjtccypcfVxzKlw/PiI7aTo3NzU7czo3ODoiXCRcd3sxLDQwfVxzKj1ccypleHBsb2RlXChccyonXHwnLChccypiYXNlNjRfZGVjb2RlXCgpezMsfVxzKlwkXHcrXHMqKFwpXHMqKSs7IjtpOjc3NjtzOjExNToiXCovXHMqKFwkXHd7MSw0MH1ccyo9XHMqJ1teJ10qJ1xzKjtccyopezMsfVwkXHcrXHMqPVxzKiIoXFxcZCspezMsfSI7XHMqKChcJFx3ezEsNDB9XHMqPVxzKidbXiddKidccyo7XHMqKXszLH18L1wqKSI7aTo3Nzc7czozNDQ6IlwkXHd7MSw0MH1ccyo9XHMqXCRcd3sxLDQwfVxzKlwoXHMqQFwkXHd7MSw0MH1ccypcKFxzKlwkXHd7MSw0MH1ccypcKFxzKlwkXHd7MSw0MH1ccypcKFxzKlwkXHd7MSw0MH1ccypcKFxzKlwkXHd7MSw0MH1ccyosXHMqJ1teJ10qJ1xzKixccyonW14nXSonXHMqXClccypcKVxzKlwpXHMqXClccypcKVxzKjtccypcJFx3ezEsNDB9XHMqPVxzKkBcJFx3ezEsNDB9XHMqXChccypcJFx3ezEsNDB9XHMqLFxzKlwkXHd7MSw0MH1ccypcKVxzKjtccypcJFx3ezEsNDB9XHMqXChccypcJFx3ezEsNDB9XHMqLFxzKlwkXHd7MSw0MH1ccypcKFxzKlwkXHd7MSw0MH1ccypcKVxzKixccyonW14nXSonXHMqXClccyo7IjtpOjc3ODtzOjM0MzoiKFxzKixccypbJyJdXF5bXiciXStbJyJdXHMqLFxzKil7MSx9WyInXVxeW14nIl0rWyInXVxzKixccyoiW14iXSoiXHMqXClccyo7XHMqaWZccypcKFxzKmluX2FycmF5XHMqXChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqWyciXVteJyJdK1snIl1ccypcXVxzKixccypcJFx3ezEsNDB9XHMqXClccypcKVxzKlx7XHMqaGVhZGVyXHMqXChccyonSFRUUC8xXC4wIDQwNCBOb3QgRm91bmQnXHMqXClccyo7XHMqZXhpdFxzKlwoXHMqXClccyo7XHMqXH1ccyplbHNlXHMqXHtccypmb3JlYWNoXHMqXChccypcJFx3ezEsNDB9XHMqYXNccypcJFx3ezEsNDB9XHMqXClccypceyI7aTo3Nzk7czo1NTU6ImlmXHMqXChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqJ1teJ10qJ1xzKlxdXHMqPT0iW14iXSoiXHMqXHxcfFxzKlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXHMqXFtccyonW14nXSonXHMqXF1ccyo9PSJbXiJdKiJccypcKVxzKnByaW50XHMqanNvbl9lbmNvZGVccypcKFxzKnNlbGZUZXN0XHMqXChccypcKVxzKlwpXHMqO1xzKmVsc2VpZlxzKlwoXHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKidbXiddKidccypcXVxzKj09IlteIl0qIlxzKlwpXHMqXHtccypcJFx3ezEsNDB9XHMqPVxzKmpzb25fZGVjb2RlXHMqXChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqJ1teJ10qJ1xzKlxdXHMqLFxzKnRydWVccypcKVxzKjtccypwcmludFxzKmpzb25fZW5jb2RlXHMqXChccyphbGV4dXNNYWlsZXJccypcKFxzKlwkXHd7MSw0MH1ccypcKVxzKlwpXHMqO1xzKlx9XHMqZWxzZVxzKlx7XHMqcHJpbnRccypqc29uX2VuY29kZVxzKlwoXHMqYXJyYXlccypcKCI7aTo3ODA7czoxNjA6IlwkX1NFU1NJT05cWydfaXBfJ1xdO1xzKi8vK1xzKlwkTE9HU1xzKj1ccyoiXFsiXHMqXC5ccypkYXRlXChccyonWS1tLWRbXjtdKztccypmaWxlX3B1dF9jb250ZW50c1woXHMqJ1teJ10rJ1xzKixccypcJExPR1NccypcLlxzKlBIUF9FT0xccyosXHMqRklMRV9BUFBFTkRccypcKTsiO2k6NzgxO3M6NDIxOiJmcFxzKj1ccypAZnNvY2tvcGVuXHMqXChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqJ1teJ10qJ1xzKlxdXHMqLFxzKlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXHMqXFtccyonW14nXSonXHMqXF1ccyosXHMqXCRcd3sxLDQwfVxzKixccypcJFx3ezEsNDB9XHMqLFxzKlxkK1xzKlwpXHMqO1xzKmlmXHMqXChccypcJFx3ezEsNDB9XHMqXClccypce1xzKkBmY2xvc2VccypcKFxzKlwkXHd7MSw0MH1ccypcKVxzKjtccypjb25uZWN0M1xzKlwoXHMqXCRcd3sxLDQwfVxzKlwuXHMqJ1teJ10qJ1xzKlwuXHMqdXJsZW5jb2RlXHMqXChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqJ1teJ10qJ1xzKlxdXHMqXClccypcKVxzKjtccypcfVxzKmV4aXRccyo7IjtpOjc4MjtzOjM2OToiaWZccypcKFxzKiFlbXB0eVxzKlwoXHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKidbXiddKidccypcXVxzKlwpXHMqXClccypce1xzKlwkXHd7MSw0MH1ccyo9XHMqXGQrXHMqO1xzKlwkXHd7MSw0MH1ccyo9XHMqXGQrXHMqO1xzKlwkXHd7MSw0MH1ccyo9XHMqYXJyYXlccypcKFxzKlwpXHMqO1xzKlwkXHd7MSw0MH1ccyo9XHMqJ1teJ10qJ1xzKjtccyppZlxzKlwoXHMqIWVtcHR5XHMqXChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqJ1teJ10qJ1xzKlxdXHMqXClccypcKVxzKlx7XHMqXCRcd3sxLDQwfVxzKlwuXHMqPVxzKiIgQU5EIFwjX19jb250ZW50XC50aXRsZSBMSUtFIjtpOjc4MztzOjM5NjoibWQ1XHMqXChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqX1xkK1xzKlwoXHMqXGQrXHMqXClccypcXVxzKlwpXHMqPT09XHMqX19QQVNTV09SRF9fXHMqXClccypce1xzKlwkXHd7MSw0MH1ccyo9XHMqYXJyYXlccypcKFxzKmZpbGVtdGltZVxzKlwoXHMqX19GSUxFX19ccypcKVxzKixccypmaWxlbXRpbWVccypcKFxzKmRpcm5hbWVccypcKFxzKl9fRklMRV9fXHMqXClccypcKVxzKlwpXHMqO1xzKlwkXHd7MSw0MH1ccyo9XHMqYmFzZW5hbWVccypcKFxzKlwkXHd7MSw0MH1ccypcW1xzKl9cZCtccypcKFxzKlxkK1xzKlwpXHMqXF1ccypcW1xzKl9cZCtccypcKFxzKlxkK1xzKlwpXHMqXF1ccypcKVxzKjtccyppZlxzKlwoXHMqbW92ZV91cGxvYWRlZF9maWxlIjtpOjc4NDtzOjM3OToiaWZccypcKFxzKm1lX2ZpbGVfcHV0X2NvbnRlbnRzXHMqXChccypcJFx3ezEsNDB9XHMqLFxzKlwkXHd7MSw0MH1ccypcKVxzKlwpXHMqXHtccypAY2htb2RccypcKFxzKlwkXHd7MSw0MH1ccyosXHMqMDQ0NFxzKlwpXHMqO1xzKmVjaG9ccyoiW14iXSoiXHMqO1xzKlx9XHMqO1xzKlx9XHMqXH1ccyplbHNlXHMqaWZccypcKFxzKlwkXHd7MSw0MH1ccyo9PVxzKidbXiddKidccypcKVxzKlx7XHMqaWZccypcKFxzKmZpbGVfZXhpc3RzXHMqXChccypcJFx3ezEsNDB9XHMqXClccypcKVxzKlx7XHMqZWNob1xzKm1lX2ZpbGVfZ2V0X2NvbnRlbnRzXHMqXChccypcJFx3ezEsNDB9XHMqXClccyo7XHMqXH1ccyplbHNlXHMqXHtccyplY2hvXHMqIlteIl0qIlxzKjtccypcfSI7aTo3ODU7czozOTY6IihcJFx3ezEwLDQwfVxzKj1ccypcZCs7XHMqKXsxMCx9Lis/YXJyYXlfcHVzaFxzKlwoXHMqXCRcd3sxLDQwfVxzKlxbXHMqXCRcd3sxLDQwfVxzKlxdXHMqLFxzKlwkXHd7MSw0MH1ccypcKVxzKjtccyppZlxzKlwoXHMqY291bnRccypcKFxzKlwkXHd7MSw0MH1ccypcW1xzKlwkXHd7MSw0MH1ccypcXVxzKlwpXHMqPlxzKnRWMTJoc0p5X1xzKlwoXHMqJ1teJ10qJ1xzKixccypcZCtccypcKVxzKlwpXHMqYXJyYXlfc2hpZnRccypcKFxzKlwkXHd7MSw0MH1ccypcW1xzKlwkXHd7MSw0MH1ccypcXVxzKlwpXHMqO1xzKlx9XHMqXH1ccyplbHNlXHMqXHtccypcJFx3ezEsNDB9XHMqXFtccypcJFx3ezEsNDB9XHMqXF1ccyo9XHMqbWljcm90aW1lXHMqXChccyp0cnVlXHMqXClccyo7XHMqXH1ccypcfSI7aTo3ODY7czo2NToiZ290b1xzKlx3K1xzKjtccypcdytccyo6XHMqXHcrXHMqOlxzKmdvdG9ccypcdys7XHMqXHcrOlxzKihcJHxpZikiO2k6Nzg3O3M6MTc6ImJ5X3JFcEVyT2s8L2ZvbnQ+IjtpOjc4ODtzOjM2NzoiPFw/cGhwXHMqXCRcd3sxLDQwfVxzKj1ccyo8XHMqPFxzKjxccypTXHMqXCNccypCRUdJTlxzKlcwUkRQUkVTU1xzKlwjXHMqPFxzKklmTW9kdWxlXHMqbW9kX3Jld3JpdGVccypcLlxzKmNccyo+XHMqXCNSZXdyaXRlRW5naW5lXHMqT25ccypcI1Jld3JpdGVCYXNlXHMqL1xzKlwjUmV3cml0ZUNvbmRccyolXHMqXHtccypSRVFVRVNUX0ZJTEVOQU1FXHMqXH1ccyohLWZccypcI1Jld3JpdGVDb25kXHMqJVxzKlx7XHMqUkVRVUVTVF9GSUxFTkFNRVxzKlx9XHMqIS1kXHMqXCNSZXdyaXRlUnVsZVxzKlwuXHMqL2luZGV4XHMqXC5ccypwaHBccypcW1xzKkxccypcXVxzKlwjXHMqPFxzKi9JZk1vZHVsZVxzKj5ccypcI1xzKkVORFxzKldvcmRQcmVzcyI7aTo3ODk7czoxMzI6InJlcXVpcmVccypfX0RJUl9fXHMqXC5ccyonW14nXSonXHMqO1xzKlwkXHd7MSw0MH1ccyo9XHMqbmV3XHMqQ2x1ZVxcUHNvY2tzZFxcQXBwXHMqXChccypcKVxzKjtccypcJFx3ezEsNDB9LVxzKj5ccypydW5ccypcKFxzKlwpXHMqOyI7aTo3OTA7czozNzc6Ilx7XHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKidbXiddKidccypcXVxzKj1ccyptZDVccypcKFxzKlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXHMqXFtccyonW14nXSonXHMqXF1ccypcKVxzKjtccypcfVxzKmlmXHMqXChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqJ1teJ10qJ1xzKlxdXHMqPT1ccypcJFx3ezEsNDB9XHMqXClccypce1xzKnNldGNvb2tpZVxzKlwoXHMqXCRcd3sxLDQwfVxzKixccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqJ1teJ10qJ1xzKlxdXHMqLFxzKnRpbWVccypcKFxzKlwpXHMqXCtccyozNjAwXHMqXClccyo7IjtpOjc5MTtzOjM3NToiaWZccypcKFxzKlx3Kzo6XHcrXHMqXChccypcdytccypcKFxzKlsnIl1bXiciXSpbIiddXHMqXClccypcKVxzKlx8XHxcdys6Olx3K1xzKlwoXHMqXHcrXHMqXChccypbIiddW14nIl0qWyInXVxzKlwpXHMqXClccypcKVxzKlx7XHMqXCRcd3sxLDQwfVxzKj1bJyJdW14iJ10qWyciXVxzKjtccypcJFx3ezEsNDB9XHMqPVxzKlwoXHMqW14oXStcKVxzKjtccypcJFx3ezEsNDB9XHMqPVxzKlwoXHMqW14oXStcKVxzKjtccypcJFx3ezEsNDB9XHMqPVsnIl1bXiInXSpbJyJdXHMqO1xzKnJldHVyblxzKlwkXHd7MSw0MH0tXHMqPlxzKlx3K1xzKlwoXHMqXClccyo7XHMqXH1ccypyZXR1cm5ccypcJFx3ezEsNDB9LVxzKj5ccypcdytccypcKFxzKlwpXHMqO1xzKlx9IjtpOjc5MjtzOjQxNToiaWZccypcKFxzKmZpbGVfZXhpc3RzXHMqXChccyoiW14iXSoiXHMqXClccypcKVxzKlx7XHMqaWZccypcKFxzKmZpbGVfZXhpc3RzXHMqXChccyoiW14iXSoiXHMqXClccypcKVxzKlx7XHMqXCRcd3sxLDQwfVxzKj1ccypzY2FuZGlyXHMqXChccyoiW14iXSoiXHMqXClccyo7XHMqZm9yZWFjaFxzKlwoXHMqXCRcd3sxLDQwfVxzKmFzXHMqXCRcd3sxLDQwfVxzKlwpXHMqXHtccyppZlxzKlwoXHMqXChccyppc19kaXJccypcKFxzKiJbXiJdKiJccypcKVxzKlwpXHMqQU5EXHMqXChccypcJFx3ezEsNDB9XHMqIT09XHMqIlteIl0qIlxzKlwpXHMqQU5EXHMqXChccypcJFx3ezEsNDB9XHMqIT09XHMqIlteIl0qIlxzKlwpXHMqXClccypce1xzKmlmXHMqXChccypmaWxlX2V4aXN0c1xzKlwoXHMqIlteIl0qIlxzKlwpXHMqXClccypceyI7aTo3OTM7czoyOTU6IjxcP3BocFxzKi9cKlxzKlBIUFxzKkVuY29kZVxzKmJ5XHMqaHR0cDovL1d3d1xzKlwuXHMqUEhQSmlhTWlccypcLlxzKkNvbS9ccypcKi9lcnJvcl9yZXBvcnRpbmdccypcKFxzKlxkK1xzKlwpXHMqO1xzKmluaV9zZXRccypcKFxzKiJbXiJdKiJccyosXHMqMFxzKlwpXHMqO1xzKmlmXHMqXChccyohZGVmaW5lZFxzKlwoXHMqJ1teJ10qJ1xzKlwpXHMqXClccypce1xzKmRlZmluZVxzKlwoXHMqJ1teJ10qJ1xzKixccypfX0ZJTEVfX1xzKlwpXHMqO1xzKmlmXHMqXChccyohZnVuY3Rpb25fZXhpc3RzXHMqXCguKz9cPz4iO2k6Nzk0O3M6MjE0OiJsb2dpblxzKlwoXHMqXClccyo7XHMqXCRcd3sxLDQwfVxzKj1ccypuZXdccypNb2JpbGVfRGV0ZWN0XHMqO1xzKmRlZmluZVxzKlwoXHMqJ1teJ10qJ1xzKixccypcJFx3ezEsNDB9LVxzKj5ccyppc01vYmlsZVxzKlwoXHMqXClccypcKVxzKjtccypkZWZpbmVccypcKFxzKidbXiddKidccyosXHMqXCRcd3sxLDQwfS1ccyo+XHMqaXNUYWJsZXRccypcKFxzKlwpXHMqXClccyo7IjtpOjc5NTtzOjU2NToiPFw/cGhwXHMqLy89Ky8vXHMqLy89K1wrXCtcK0RoYW51c2hcK1wrXCs9Ky8vXHMqLy89Ky8vXHMqLy89K1wrXCtcK0NvZGVkXHMqQnlccypBcmp1blwrXCtcKz09PS8vXHMqLy89Ky8vXHMqLy89K1wrXCtcK0FuXHMqSW5kaWFuXHMqSGFja2VyXCtcK1wrPT09PT0vL1xzKi8vPSsvL1xzKi8vPT09PVxzKkFzaHZpbi0yMDY5L09jdC0yMDEyXHMqPT09PS8vXHMqLy9ccypTZXRccypVc2VybmFtZVxzKiZccypQYXNzd29yZFxzKlwkXHd7MSw0MH1ccyo9XHMqIlteIl0qIlxzKjtccypcJFx3ezEsNDB9XHMqPVxzKiJbXiJdKiJccyo7XHMqXCRcd3sxLDQwfVxzKj1ccyoiW14iXSoiXHMqO1xzKi8vXHMqTWFsd2FyZVxzKlNpdGVccypcJFx3ezEsNDB9XHMqPVxzKiJbXiJdKiJccyo7XHMqLy9ccyoiW14iXSoiXHMqQmFzZTY0XHMqZW5jb2RlZFxzKiJbXiJdKiJccypcJFx3ezEsNDB9XHMqPVxzKiJbXiJdKiJccyo7XHMqZXZhbFxzKlwoXHMqIlteIl0qIlxzKlwuXHMqZ3p1bmNvbXByZXNzXHMqXChccypiYXNlNjRfZGVjb2RlXHMqXChccypcJFx3ezEsNDB9XHMqXClccypcKVxzKlwpXHMqO1xzKlw/PiI7aTo3OTY7czoxNTc6ImlmXHMqXChccyohY2xhc3NfZXhpc3RzXHMqXChccyonW14nXSonXHMqLFxzKmZhbHNlXHMqXClccypcKVxzKjpccypjbGFzc1xzK1x3K1xzKnsuKz9jb25zdFxzKlNDUklQVF9TUkNccyo9XHMqJ2RhdGE6dGV4dC9qYXZhc2NyaXB0O2Jhc2U2NCwuKz9NUlRfQUxMX1RSQUZGSUMiO2k6Nzk3O3M6MTA5OiI8XD9waHBccyplcnJvcl9yZXBvcnRpbmdccypcKFxzKlxkK1xzKlwpXHMqO1xzKlwkXHd7MSw0MH1ccyo9XHMqWyciXWpxdWVyeVsnIl1ccyo7XHMqXCRcd3sxLDQwfVxzKj1ccypbJyJddmFyIjtpOjc5ODtzOjI4NDoiPFw/cGhwXHMqaGVhZGVyXHMqXChccyonW14nXSonXHMqXClccyo7XHMqQHNldF90aW1lX2xpbWl0XHMqXChccypcZCtccypcKVxzKjtccypkZWZpbmVccypcKFxzKidbXiddKidccyosXHMqXGQrXHMqXC5ccyowXHMqXClccyo7XHMqZGVmaW5lXHMqXChccyonW14nXSonXHMqLFxzKidbXiddKidccypcKVxzKjtccyppZlxzKlwoXHMqZmlsZV9leGlzdHNccypcKFxzKlBBU1NXT1JEX0ZJTEVccypcKVxzKlwpXHMqXHtccypAdW5saW5rXHMqXChccypQQVNTV09SRF9GSUxFXHMqXClccyo7XHMqXH1ccyoiO2k6Nzk5O3M6MjU1OiJcfVxzKmVsc2VccyppZlxzKlwoXHMqXCRcd3sxLDQwfVxzKj09XHMqInBocCJccypcKVxzKlx7XHMqXCRcd3sxLDQwfVxzKj1ccyonW14nXSonXHMqO1xzKlx9XHMqZWxzZVxzKmlmXHMqXChccypcJFx3ezEsNDB9XHMqPT1ccyoiYXNweCJccypcKVxzKlx7XHMqXCRcd3sxLDQwfVxzKj1ccyonW14nXSonXHMqO1xzKlx9XHMqZWxzZVxzKlx7XHMqXCRcd3sxLDQwfVxzKj1ccyoiW14iXSoiXHMqO1xzKlwkXHd7MSw0MH1ccyo9XHMqIlteIl0qIlxzKjsiO2k6ODAwO3M6NDEyOiJce1xzKlwkXHd7MSw0MH1ccyo9XCRcd3sxLDQwfVxzKlxbXHMqIlteIl0qIlxzKlxdXHMqXChccyoxXHMqLFxzKlwkXHd7MSw0MH1ccypcW1xzKlxkK1xzKlxdXHMqXClccyo7XHMqXCRcd3sxLDQwfVxzKj1ccypcdytccypcKFxzKmFycmF5XHMqXChccypcJFx3ezEsNDB9XHMqXFtccypcZCtccypcXVxzKixccypcJFx3ezEsNDB9XHMqLFxzKidbXiddKidccyosXHMqJ1teJ10qJ1xzKlwpXHMqLFxzKlwkXHd7MSw0MH1ccyosXHMqMVxzKlwpXHMqO1xzKlwkXHd7MSw0MH1ccypcLlxzKj1cJFx3ezEsNDB9XHMqXFtccyoiW14iXSoiXHMqXF1ccypcKFxzKlwkXHd7MSw0MH1ccypcW1xzKiJbXiJdKiJccypcXVxzKlwuXHMqIlteIl0qIlxzKixccypcJFx3ezEsNDB9XHMqLFxzKlwkXHd7MSw0MH1ccypcKVxzKjtccypcfVxzKlx9IjtpOjgwMTtzOjE5NzoiXCRcd3sxLDQwfS1ccyo+XHMqXHcrXHMqPUBmaWxlX2dldF9jb250ZW50c1xzKlwoXHMqXCRcd3sxLDQwfS1ccyo+XHMqXHcrXHMqLFxzKmZhbHNlXHMqLFxzKlwkXHd7MSw0MH1ccypcKVxzKjtccyppZlxzKlwoXHMqXCRcd3sxLDQwfS1ccyo+XHMqXHcrXHMqPT09XHMqZmFsc2VccypcKVxzKlx7XHMqXCRcd3sxLDQwfVxzKj1ccypbXjtdK1xzKjsiO2k6ODAyO3M6Njk6IlwkXHMqL1wqW15cKl0rXCovXHMqe1xzKi9cKlteXCpdK1wqL1snIl1bXiciXStbJyJdXHMqL1wqW15cKl0rXCovXHMqfSI7aTo4MDM7czoyMjg6ImZvcGVuXHMqXChccypbIiddW14nIl0qWyInXVxzKixccypbJyJdW14iJ10qWyciXVxzKlwpXHMqO1xzKlx9XHMqZndyaXRlXHMqXChccypcJFx3ezEsNDB9XHMqLFxzKnJhd3VybGRlY29kZVxzKlwoXHMqXCRcd3sxLDQwfVxzKlxbXHMqXGQrXHMqXF1ccypcKVxzKlwpXHMqO1xzKmZjbG9zZVxzKlwoXHMqXCRcd3sxLDQwfVxzKlwpXHMqO1xzKkA/aW5jbHVkZVxzKlwoXHMqIlteIl0qIlxzKlwpXHMqOyI7aTo4MDQ7czoxNDoiT0sgQ09LIFNVS1NFU1MiO2k6ODA1O3M6Mzk6IjxcP3BocFxzKkAnXCRccypcdys9XGQrXHMqXHcrPVxkK1xzKngzPSI7aTo4MDY7czo0MjoifVxzKmlmXChcdys6Olx3K1woXHcrXCgiW2EtekEtWjA9OS9dKz09IlwpIjtpOjgwNztzOjIzNzoic3RhdGljXHMqcHVibGljXHMqZnVuY3Rpb25ccypcdytccypcKFxzKlwkXHd7MSw0MH1ccyosXHMqXCRcd3sxLDQwfVxzKixccypcJFx3ezEsNDB9XHMqXClccypce1xzKlwkXHd7MSw0MH1ccyo9XHMqXHcrXHMqXChccypbIiddW14iJ10qPVsiJ11ccypcKVxzKjtccypyZXR1cm5ccypcJFx3ezEsNDB9XHMqXChccypcJFx3ezEsNDB9XHMqLFxzKlwkXHd7MSw0MH1ccyosXHMqXCRcd3sxLDQwfVxzKlwpXHMqO1xzKlx9IjtpOjgwODtzOjEwMjoiZnVuY3Rpb25ccytzZXNzaW9uU3RhcnRcKFwkc2Vzc2lvblwpXHMqe1xzKmlmXCghZW1wdHlcKFwkc2Vzc2lvblwpXClccypyZXR1cm5ccypldmFsXChcJHNlc3Npb25cKTtccyp9IjtpOjgwOTtzOjQyOiJDb25maWdzXHMrR3JhYmJlclxzK0J5XHMrQW5vbkNvZGVyc1xzK1RlYW0iO2k6ODEwO3M6NDk6ImJhc2U2NF9kZWNvZGUoJ1VISnZjR1Z5ZEhrZ2IyWWdVbVYyYVhOcGRXMHVZMjl0JykiO2k6ODExO3M6MjIzOiJsaXN0XChcJHRvYnVmLFwkZnJvbSxcJGZyb21wd2QsXCRmcm9tbmFtZSxcJHN1YmplY3QsXCRtZXNzYWdlXCk9IHNwbGl0IFwoJzo6OicsXHMqXCRjb25hclwpO1xzKlwkdG9hciA9IHNwbGl0XCgnXFxcfFxcXHwnLFwkdG9idWZcKTtccypmb3JlYWNoIFwoXCR0b2FyXHMqYXNccypcJHRvXClccyp7XHMqbGlzdFwoXCRmcm9tbG9naW4sXCRmcm9taG9zdFwpPXNwbGl0XCgnQCcsXCRmcm9tXCk7IjtpOjgxMjtzOjI3OiI8dGl0bGU+RFwuUlwuU1xzK0R6PC90aXRsZT4iO2k6ODEzO3M6NDcyOiI7XHMqXCRbTzBfXSs9IlteIl0qIlxzKjtccypcJFx3ezEsNDB9PSJbXiJdKiJccyo7XHMqXCRcd3sxLDQwfVxzKj1cJFx3ezEsNDB9XHMqXChccyoiW14iXSoiXHMqLFxzKiJbXiJdKiJccyosXHMqIlteIl0qIlxzKlwpXHMqO1xzKlwkXHd7MSw0MH1ccyo9XCRcd3sxLDQwfVxzKlwoXHMqIlteIl0qIlxzKixccyoiW14iXSoiXHMqLFxzKiJbXiJdKiJccypcKVxzKjtccypcJFx3ezEsNDB9XHMqPVwkXHd7MSw0MH1ccypcKFxzKiJbXiJdKiJccyosXHMqXCRcd3sxLDQwfVxzKlwoXHMqXCRcd3sxLDQwfVxzKlwoXHMqIlteIl0qIlxzKixccyoiW14iXSoiXHMqLFxzKlwkXHd7MSw0MH1ccypcLlxzKlwkXHd7MSw0MH1ccypcLlxzKlwkXHd7MSw0MH1ccypcLlxzKlwkXHd7MSw0MH1ccypcKVxzKlwpXHMqXClccyo7XHMqXCRcd3sxLDQwfVxzKlwoXHMqXClccyo7XHMqZWNob1xzKlwkXHd7MSw0MH1ccypcLlxzKiJbXiJdKiJccyo7XHMqIjtpOjgxNDtzOjYyOiJhOlxkKzp7czpcZCs6Lis/PElmTW9kdWxlIG1vZF9yZXdyaXRlXC5jPlxzKlJld3JpdGVFbmdpbmVccytPbiI7aTo4MTU7czozMDoiPFw/cGhwXHMqQCdcJFxzKlx3Kz1cZCtccypcdys9IjtpOjgxNjtzOjExNDoibGlzdFwoXHMqXCR0b2J1ZlxzKixccypcJGZyb21ccyosXHMqXCRzdWJqZWN0XHMqLFxzKlwkbWVzc2FnZWZpbGVccypcKT1ccypleHBsb2RlXHMqXChccyonOjo6J1xzKixccypcJGNvbmFyXHMqXCk7IjtpOjgxNztzOjQwOiJcJFx3Kz0nW14nXXs2LH0nOydbXiddezUsfSc7KC9cKnxcJHxcKi8pIjtpOjgxODtzOjE1MzoiZWxzZWlmXHMqXChccyppc3NldFwoXHMqXCRfQ09PS0lFXFtccyonXHcrJ1xzKlxdXHMqXClccyomJlxzKiFlbXB0eVwoXHMqXCRfQ09PS0lFXFtccyonXHcrJ1xzKlxdXHMqXClccypcKVxzKntccyplY2hvXHMqaHRtbGVudGl0aWVzXChccypcKFxzKnN0cmluZ1xzKlwpIjtpOjgxOTtzOjY1OiJQaHBGaWxlQWRtaW4uKz88YVxzKmhyZWY9ImluZGV4XC5waHBcP2Rpcj08XD89XCRfR0VUXFsnZGlyJ11cPz4iPiI7aTo4MjA7czoyMzM6ImlmXHMqXChccypcJHBhc3Nccyo9PVxzKidcd3szMn0nXHMqXClccypce1xzKmlmXHMqXChccyohXCRcd3sxLDQwfVxzKj1ccypmb3BlblxzKlwoXHMqIlteIl0qIlxzKixccyoiW14iXSoiXHMqXClccypcKVxzKlx7XHMqZXhpdFxzKjtccypcfVxzKmlmXHMqXChccypmd3JpdGVccypcKFxzKlwkXHd7MSw0MH1ccyosXHMqIlteIl0qIlxzKlwpXHMqPT1ccypGQUxTRVxzKlwpXHMqXHtccypleGl0XHMqO1xzKlx9IjtpOjgyMTtzOjE4MDoiPFw/cGhwXHMqZWNob1woXHMqaHRtbGVudGl0aWVzXChccypcJF9HRVRcW1xzKidzeW1saW5rdGFyZ2V0J1xzKlxdXHMqXClccypcKTtccypcPz5ccyo8L2I+XHMqPGJyPlxzKjxpbnB1dFxzKnR5cGU9ImNoZWNrYm94IlxzKm5hbWU9InJlbGF0aXZlIlxzKnZhbHVlPSJ5ZXMiXHMqaWQ9ImNoZWNrYm94X3JlbGF0aXZlIjtpOjgyMjtzOjIxNjoiPHRpdGxlPlx3KzwvdGl0bGU+PGZvcm1ccytlbmN0eXBlPW11bHRpcGFydC9mb3JtLWRhdGFccyttZXRob2Q9cG9zdD48aW5wdXRccytuYW1lPVx3K1xzK3R5cGU9ZmlsZT48aW5wdXRccyt0eXBlPXN1Ym1pdFxzK25hbWU9XHcrPlxzKjxicj48YnI+PGlucHV0XHMrbmFtZT1wYXRoXHMrdHlwZT10ZXh0XHMrdmFsdWU9PFw/cGhwXHMrZWNob1xzK0BnZXRjd2RcKFwpO1xzKlw/Pi8+IjtpOjgyMztzOjkwOiJtYWtlaGlkZVwoJ2FjdGlvbicsICdiYWNrY29ubmVjdCdcKTtccypwXCgnPHA+J1wpO1xzKnBcKCdZb3VyIElQOidcKTtccyptYWtlaW5wdXRcKGFycmF5XCgiO2k6ODI0O3M6MTM2OiJcJEFEY29ublxzKj1ccypuZXdccyphZExEQVA7XHMqaWZcKFwkQURjb25uLT5leGlzdGluZ1VzZXJcKFwkdXNlclxbJ3VzZXJuYW1lJ1xdXClcKXtccypzZWN0aW9uXCgiQWN0aXZlXHMqRGlyZWN0b3J5IiwyXCk7XHMqY29udGVudFwoXCk7IjtpOjgyNTtzOjMzOiJcJGhlYWRlcnNccyo9XHMqIkZyb206XHMqTWFmaW9abzAiO2k6ODI2O3M6MjQzOiJcJFx3K1xzKj1ccypmaWxlX2dldF9jb250ZW50c1woXCRcdytcKTtccyp9XHMqZWxzZWlmXCghaW5fYXJyYXlcKFsnIl1leGVjWyciXVxzKixccypleHBsb2RlXChccypbJyJdLFsnIl1ccyosXHMqaW5pX2dldFwoXHMqWyciXWRpc2FibGVfZnVuY3Rpb25zWyciXVxzKlwpXHMqXClccypcKVxzKlwpXHMqe1xzKmV4ZWNcKFxzKiJ3Z2V0XHMqLU9ccyotXHMqJyJccypcLlxzKlwkXHcrXHMqXC5ccyoiJyJccyosXHMqXCRcdytcKTsiO2k6ODI3O3M6MTczOiJcJFx3K1xzKj1ccypcJGRpclwuRElSRUNUT1JZX1NFUEFSQVRPUjtccypjaG1vZFwoXCRcdytcLkRJUkVDVE9SWV9TRVBBUkFUT1JcLidpbmRleFwucGhwJywgMDY0NFwpO1xzKlwkXHcrXHMqPVxzKmZvcGVuXChcJFx3K1wuRElSRUNUT1JZX1NFUEFSQVRPUlwuJ2luZGV4XC5waHAnXHMqLFxzKiJyIlwpOyI7aTo4Mjg7czoyNToiPHRpdGxlPkNhcmRpbWFuXHMrQXNvb29vaCI7aTo4Mjk7czoxMTgwOiI8XD9waHBccypAc2V0X3RpbWVfbGltaXRccypcKFxzKlxkK1xzKlwpXHMqO1xzKkBpZ25vcmVfdXNlcl9hYm9ydFxzKlwoXHMqXGQrXHMqXClccyo7XHMqXCRcd3sxLDQwfVxzKj1ccyonW14nXSonXHMqO1xzKlwkXHd7MSw0MH1ccyo9XHMqJ1teJ10qJ1xzKjtccypcJFx3ezEsNDB9XHMqPVxzKlx3K1xzKlwoXHMqXClccyo7XHMqaWZccypcKFxzKlwkXHd7MSw0MH1ccyo9PSdbXiddKidccypcKVxzKlx7XHMqXCRcd3sxLDQwfVxzKj0nW14nXSonXHMqO1xzKlx9XHMqXCRcd3sxLDQwfVxzKj1ccypiYXNlNjRfZW5jb2RlXHMqXChccypcJFx3ezEsNDB9XHMqXClccyo7XHMqXCRcd3sxLDQwfVxzKj1ccypcZCtccyo7XHMqZnVuY3Rpb25ccypcdytccypcKFxzKlwpXHMqXHtccyppZlxzKlwoXHMqaXNzZXRccypcKFxzKlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXHMqXFtccyonW14nXSonXHMqXF1ccypcKVxzKlwpXHMqXHtccypcJFx3ezEsNDB9XHMqPVxzKlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXHMqXFtccyonW14nXSonXHMqXF1ccyo7XHMqXH1ccyplbHNlXHMqXHtccyppZlxzKlwoXHMqaXNzZXRccypcKFxzKlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXHMqXFtccyonW14nXSonXHMqXF1ccypcKVxzKlwpXHMqXHtccypcJFx3ezEsNDB9XHMqPVxzKlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXHMqXFtccyonW14nXSonXHMqXF1ccypcLlxzKidbXiddKidccypcLlxzKlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXHMqXFtccyonW14nXSonXHMqXF1ccypcW1xzKlxkK1xzKlxdXHMqO1xzKlx9XHMqZWxzZVxzKlx7XHMqXCRcd3sxLDQwfVxzKj1ccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqJ1teJ10qJ1xzKlxdXHMqXC5ccyonW14nXSonXHMqXC5ccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqJ1teJ10qJ1xzKlxdXHMqO1xzKlx9XHMqXH1ccypyZXR1cm5ccypcJFx3ezEsNDB9XHMqO1xzKlx9XHMqXCRcd3sxLDQwfVxzKj1ccyp1cmxkZWNvZGVccypcKFxzKiJbXiJdKiJccypcKVxzKjtccyouKz9ccyo7XHMqZXZhbFxzKlwoXHMqXCRcd3sxLDQwfVxzKlwoXHMqIlteIl0qIlxzKlwpXHMqXClccyo7XHMqXD8+IjtpOjgzMDtzOjE2MzoiaWZccypcKFxzKmZpbGVfZXhpc3RzXChccyoiY29uZmlnL3NldHRpbmdzXC5pbmNcLnBocCJccypcKVxzKm9yXHMqXChccyoiXC5cLi9jb25maWcvc2V0dGluZ3NcLmluY1wucGhwIlxzKlwpXHMqb3JccypcKFxzKiJcLlwuL1wuXC4vY29uZmlnL3NldHRpbmdzXC5pbmNcLnBocCJccypcKSI7aTo4MzE7czozNDoiU2luZGJhZFxzKkZpbGVccypNYW5hZ2VyXHMqVmVyc2lvbiI7aTo4MzI7czozNzoiVXBsb2FkXHMqaXNccyo8Yj5ccyo8Y29sb3I+XHMqV09SS0lORyI7aTo4MzM7czoyOTU6IjxcP3BocFxzKmlmXHMqXChccyppc3NldFxzKlwoXHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVClccypcW1xzKiJbXiJdKiJccypcXVxzKlwpXHMqXClccypcJG1haWxUb1xzKj1ccypiYXNlNjRfZGVjb2RlXHMqXChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqIlteIl0qIlxzKlxdXHMqXClccyo7LitpZlwobWFpbFwoXCRNYWlsVG9ccyosXHMqXCRNZXNzYWdlU3ViamVjdFxzKixccypcJE1lc3NhZ2VCb2R5XHMqLFxzKlwkTWVzc2FnZUhlYWRlclxzKlwpXHMqXCkiO2k6ODM0O3M6NDE6Ijx0aXRsZT5OYXZpY2F0IEhUVFAgVHVubmVsIFRlc3RlcjwvdGl0bGU+IjtpOjgzNTtzOjEwNzoiXC5ccyovc3NzXHMqXC5ccypwbFxzKjxccypsb2NhbF9ob3N0XHMqPlxzKjxccypsb2NhbF9wb3J0XHMqPlxzKlxbXHMqYXV0aF9sb2dpblxzKlwoXHMqOmF1dGhfcGFzc1xzKlwpXHMqXF0iO2k6ODM2O3M6MjI6ImV4ZWNcKCJjYXQgL2V0Yy9wYXNzd2QiO2k6ODM3O3M6NTY6IjtjbGFzc1xzKlNtYXJ0eTNccyp7XHMqcHJpdmF0ZVxzKnN0YXRpY1xzKlwkZmlsZV93aXRoX2lwIjtpOjgzODtzOjQwOiI8dGl0bGU+R2FMZXJzXHMreGgzTExccytCYWNrZDAwcjwvdGl0bGU+IjtpOjgzOTtzOjczOiJcJGRlZmF1bHRfYWN0aW9uXHMqPVxzKlsnIl1GaWxlc01hblsnIl07XHMqXCRkZWZhdWx0X3VzZV9hamF4XHMqPVxzKnRydWU7IjtpOjg0MDtzOjQwOiI8IS0tXCNpbmNsdWRlXHMqZmlsZT0iL2V0Yy9wYXNzd2QiXHMqLS0+IjtpOjg0MTtzOjU5OiJlY2hvIjxjZW50ZXI+Lis/PC9jZW50ZXI+XHMqIjtccyplY2hvXHMqJ3VuYW1lOidcLnBocF91bmFtZSI7aTo4NDI7czoxMDk6ImRpZVwoJ0VSUk9SLTQwMC1CQUQtUkVRVUVTVCdcKTtccyppZlxzKlwoaXNzZXRcKFwkX0ZJTEVTXFsnXHcrJ1xdXClcKXtccyppZlxzKlwoaXNzZXRcKFwkX1JFUVVFU1RcWydcdysnXVwpXCkiO2k6ODQzO3M6MTE0OiJlbHNlXHMqXHtccyplY2hvXHMqImluZGF0YV9lcnJvciJccyo7XHMqZXhpdFxzKjtccypcfVxzKmlmXHMqXChccyppc3NldFxzKlwoXHMqXCRfKEdFVHxQT1NUfENPT0tJRXxTRVJWRVJ8UkVRVUVTVCkiO2k6ODQ0O3M6NDcxOiJ0b3VjaFxzKlwoXHMqZGlybmFtZVxzKlwoXHMqX19GSUxFX19ccypcKVxzKixccypcJFx3ezEsNDB9XHMqXClccyo7XHMqdG91Y2hccypcKFxzKlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXHMqXFtccyonW14nXSonXHMqXF1ccyosXHMqXCRcd3sxLDQwfVxzKlwpXHMqO1xzKmlmXHMqXChccypzdWJzdHJccypcKFxzKlBIUF9PU1xzKixccyowXHMqLFxzKjNccypcKVxzKj09PVxzKidbXiddKidccypcfFx8XHMqc3Vic3RyXHMqXChccypQSFBfT1NccyosXHMqMFxzKixccyozXHMqXClccyo9PT1ccyonW14nXSonXHMqXClccypce1xzKmNobW9kXHMqXChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqJ1teJ10qJ1xzKlxdXHMqLFxzKjA0NDRccypcKVxzKjtccypjaG1vZFxzKlwoXHMqZGlybmFtZVxzKlwoXHMqX19GSUxFX19ccypcKVxzKixccyowNTU1XHMqXClccyo7XHMqXH0iO2k6ODQ1O3M6NDk6ImZ1bmN0aW9uXHMqc3RhcnRfd29ya1woXHMqXCRvZmZccyosXHMqXCR1bnRvXHMqXCkiO2k6ODQ2O3M6NDU6IlBsZ1N5c3RlbVhjYWxlbmRhckhlbHBlcjo6Z2V0SW5zdGFuY2VcKFxzKlwpOyI7aTo4NDc7czo1ODoibXlccypcJGZha2Vwcm9jXHMqPVxzKiIvdXNyL2xvY2FsL2FwYWNoZS9iaW4vaHR0cGRccyotS0tEIiI7aTo4NDg7czoxMzU6ImZ1bmN0aW9uXHMqTGltaXREb3dubG9hZFNpemVcKFxzKlwkcmVzb3VyY2VccyosXHMqXCREb3dubG9hZFNpemVccyosXHMqXCREb3dubG9hZGVkXHMqLFxzKlwkVXBsb2FkU2l6ZVxzKixccypcJFVwbG9hZGVkXHMqPVxzKm51bGxccypcKSI7aTo4NDk7czoxMDY6IjxcP3BocFxzKnJlcXVpcmVccyonY2FsbFwucGhwJztccypcJHVzZXJccyo9XHMqXCRfUE9TVFxbJ3VzZXInXF07XHMqXCRwYXNzXHMqPVxzKlwkX1BPU1RcWydwYXNzKHdvcmQpPydcXTsiO2k6ODUwO3M6NjM6IjxcP3BocFxzKmZ1bmN0aW9uIGJvdGNoZWNrXChccypcKVxzKntccypcJHNwaWRlcnNccyo9XHMqYXJyYXlcKCI7aTo4NTE7czo4NzoiPFw/cGhwXHMqcmVxdWlyZVxzKidjYWxsXC5waHAnO1xzKlwkbWQ1XHMqPVxzKm1kNVwoXHMqdW5pcWlkXChccyp0aW1lXChccypcKVxzKlwpXHMqXCk7IjtpOjg1MjtzOjMyOiJTaWduXHMrb25ccyt0b1xzK1Njb3RpYVxzK09uTGluZSI7aTo4NTM7czo0NzoiPHRpdGxlPk5hdmljYXRccypIVFRQXHMqVHVubmVsXHMqVGVzdGVyPC90aXRsZT4iO2k6ODU0O3M6NTE6Ijx0aXRsZT5ccypJbXBvdHNcLmdvdXZcLmZyXHMqLVxzKkFjY3VlaWxccyo8L3RpdGxlPiI7aTo4NTU7czoxMzk6IlwkaXBccyo9XHMqZ2V0ZW52XChccyoiUkVNT1RFX0FERFIiXHMqXCk7XHMqXCRicm93c2VyXHMqPVxzKmdldGVudlxzKlwoXHMqIkhUVFBfVVNFUl9BR0VOVCJccypcKTtccypcJG1lc3NhZ2VccypcLj1ccyoiXHMqLStcfFxzKkNDXHMqSW5mb3MiO2k6ODU2O3M6MTIzOiI8XD9ccypcJHJhbmRvbT1yYW5kXCgwLDEwMDAwMDAwMDAwMFwpO1xzKlwkbWQ1PW1kNVwoIlwkcmFuZG9tIlwpO1xzKlwkYmFzZT1iYXNlNjRfZW5jb2RlXChcJG1kNVwpO1xzKlwkZHN0PW1kNVwoIlwkYmFzZSJcKTsiO2k6ODU3O3M6NDQ6Ijx0aXRsZT5ccypIT1RNQUlMXHMqXChXMzNcLklORk9cKVxzKjwvdGl0bGU+IjtpOjg1ODtzOjEzODoiXCRpcFxzKj1ccypnZXRlbnZcKFxzKiJSRU1PVEVfQUREUiJccypcKTtccypcJGJyb3dzZXJccyo9XHMqZ2V0ZW52XHMqXChccyoiSFRUUF9VU0VSX0FHRU5UIlxzKlwpO1xzKlwkbWVzc2FnZVxzKlwuPVxzKiItK1x8XHMqRnVsbFxzKkluZm9zIjtpOjg1OTtzOjY2MDoiPFxzKlw/XHMqaWZccypcKFxzKmlzc2V0XHMqXChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqJ1teJ10qJ1xzKlxdXHMqXClccypBTkRccyohaXNzZXRccypcKFxzKlwkXyhHRVR8UE9TVHxDT09LSUV8U0VSVkVSfFJFUVVFU1QpXHMqXFtccyoiW14iXSoiXHMqXF1ccypcKVxzKlwpXHMqXHtccypzZXRjb29raWVccypcKFxzKiJbXiJdKiJccyosXHMqIlteIl0qIlxzKixccyp0aW1lXHMqXChccypcKVxzKlwrXGQrXHMqLFxzKiJbXiJdKiJccypcKVxzKjtccypcJFx3ezEsNDB9XHMqPVxzKmFycmF5XHMqXChbXildK1wpXHMqO1xzKmZvclxzKlwoXHMqXCRcd3sxLDQwfVxzKj1ccypcZCtccyo7XHMqXCRcd3sxLDQwfVxzKjxccypjb3VudFxzKlwoXHMqXCRcd3sxLDQwfVxzKlwpXHMqO1xzKlwkXHd7MSw0MH1cK1wrXHMqXClccyppZlxzKlwoXHMqc3RycG9zXHMqXChccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqJ1teJ10qJ1xzKlxdXHMqLFxzKlwkXHd7MSw0MH1ccypcW1xzKlwkXHd7MSw0MH1ccypcXVxzKlwpXHMqIT09XHMqZmFsc2VccypcKVxzKlx7XHMqaWZccypcKFxzKmlzX21vYmlsZVxzKlwoXHMqXClccypcKVxzKmV4aXRccypcKFxzKidbXiddKidccypcKVxzKjtccypcfVxzKlx9IjtpOjg2MDtzOjcwOiJ7a2V5d29yZH1ccyo8L2gxPlxzKjwvYmlnPlxzKjwvaDE+XHMqe21hbnl0ZXh0X2Jpbmd9XHMqPC9kaXY+XHMqPC9kaXY+IjtpOjg2MTtzOjE1NToiKFwkXHd7MSw0MH1ccyo9XHMqXCRcd3sxLDQwfVxzKlwoXHMqW14pXSs/XHMqXClccyo7XHMqKXs0LH1cJFx3K1xzKj1ccypcJFx3K1woXHMqXCRcdytcKFxzKlwkXHcrXHMqXClccyosXHMqXGQrXHMqXCk7XHMqXCRcdytccyo9XCRcdytcKFxzKlwkXHcrXHMqXCk7XHMqXCQiO2k6ODYyO3M6NDM6Ik1pc3RlclxzK1NweVxzKyZccytTb3VoZXlsXHMrQnlwYXNzXHMrU2hlbGwiO2k6ODYzO3M6NzQ6In1ccyplbHNlXHMqe1xzKnN5c3dyaXRlXChcJGNsaWVudFxzKixccyoiXFx4MDVcXHhGRiJccyosXHMqMlxzKlwpO1xzKn1ccyo7IjtpOjg2NDtzOjgzOiJXZWJccytTaGVsbFxzK0J5Lis/cHJlZ19yZXBsYWNlXHMqXChccyoiW14iXSoiXHMqLFxzKiJbXiJdKiJccyosXHMqIlteIl0qIlxzKlwpXHMqOyI7aTo4NjU7czoyOTE6ImlmXHMqXChccyppbnR2YWxccypcKFxzKlwkX0dFVFxzKlxbXHMqJ1teJ10qJ1xzKlxdXHMqXClccypcKVxzKlwkXHd7MSw0MH1ccyo9XHMqb2N0ZGVjXHMqXChccyppbnR2YWxccypcKFxzKlwkX0dFVFxzKlxbXHMqJ1teJ10qJ1xzKlxdXHMqXClccypcKVxzKjtccyplbHNlXHMqXCRcd3sxLDQwfVxzKj1ccypcZCtccyo7XHMqaWZccypcKFxzKmNobW9kX1JccypcKFxzKlwkXHd7MSw0MH1ccyosXHMqXCRcd3sxLDQwfVxzKlwpXHMqXClccyplY2hvXHMqIlteIl0qIlxzKlwuXHMqXCRcd3sxLDQwfVxzKjtccypcfSI7aTo4NjY7czo5MToie1xzKmVjaG9ccyoiPGI+RXhlY3V0aW9uXHMrUEhQLWNvZGU8L2I+IlxzKjtccyppZlxzKlwoXHMqZW1wdHlcKFxzKlwkZXZhbF90eHRccypcKVxzKlwpXHMqeyI7aTo4Njc7czoxMTk6ImZ1bmN0aW9uXHMqeGNhbGVuZGFyQnVmZmVyRW5kXHMqXChccypcJFx3ezEsNDB9XHMqXClccypce1xzKlwkXHd7MSw0MH1ccyo9XHMqeGNhbGVuZGFyV1BCYXNlOjpnZXRJbnN0YW5jZVxzKlwoXHMqXClccyo7IjtpOjg2ODtzOjIzODoiaWZccypcKGlzX29iamVjdFwoXCRfU0VTU0lPTlxbIl9fZGVmYXVsdCJcXVxbInVzZXIiXF1cKVxzKiYmXHMqIVwoXCRfU0VTU0lPTlxbIl9fZGVmYXVsdCJcXVxbInVzZXIiXF0tPmlkXClcKVxzKntlY2hvXHMqIlxzKjxzY3JpcHRccypsYW5ndWFnZT1KYXZhU2NyaXB0XHMqaWQ9b25EYXRlXHMqPlxzKjwvc2NyaXB0PlxzKjxzY3JpcHRccypsYW5ndWFnZT1KYXZhU2NyaXB0XHMqc3JjPVtePl0rPlxzKjwvc2NyaXB0PiI7aTo4Njk7czo4NjoiXCRcd3sxLDQwfVxzKj1ccypmb3BlblwoXHMqInRlbXAxLTFcLnBocCJccyosXHMqInciXHMqXCk7XHMqZnB1dHNcKFwkXHcrXHMqLFxzKiI8XD9waHAiO2k6ODcwO3M6MTg6IndlYmFkbWluXC5waHA8L2gxPiI7aTo4NzE7czoxNzI6ImlmXHMqXChccyohZnVuY3Rpb25fZXhpc3RzXChccyonanF1ZXJ5X0dldEFsbFdyaXRhYmxlRGlycydccypcKVxzKlwpXHMqe1xzKmZ1bmN0aW9uXHMqanF1ZXJ5X0dldEFsbFdyaXRhYmxlRGlyc1woXHMqXCRwYXJhbXNccypcKVxzKntccypnbG9iYWxccypcJGpxdWVyeV9kclxzKixccypcJGRpckxpc3QiO2k6ODcyO3M6NTg6IkBzeXN0ZW1cKCJraWxsYWxsXHMrLTlccysiXC5iYXNlbmFtZVwoIi91c3IvYmluL2hvc3QiXClcKTsiO2k6ODczO3M6MzUyOiI8XD9waHBccyppZlxzKlwoXHMqaXNzZXRccypcKFxzKlwkXHd7MSw0MH1ccypcW1xzKidbXiddKidccypcXVxzKlwpXHMqJiZccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqJ1teJ10qJ1xzKlxdXHMqPT1ccyonW14nXSonXHMqXClccypce1xzKmVjaG9ccyooY29weXxtb3ZlX3VwbG9hZGVkX2ZpbGUpXHMqXChccypcJFx3ezEsNDB9XHMqXFtccyonW14nXSonXHMqXF1ccypcW1xzKidbXiddKidccypcXVxzKixccypcJF8oR0VUfFBPU1R8Q09PS0lFfFNFUlZFUnxSRVFVRVNUKVxzKlxbXHMqJ1teJ10qJ1xzKlxdXHMqXClccyo7XHMqZXhpdFxzKjtccypcfVxzKlw/PlxzKjxccypmb3JtIjtpOjg3NDtzOjY5OiJzdHJpcG9zXChcJHBhdGhccyosXHMqJy9odHRwZG9jcy8nXHMqXClccypcK1xzKnN0cmxlblwoXHMqJy9odHRwZG9jcy8iO2k6ODc1O3M6NDE6Ijx0aXRsZT5OYXZpY2F0IEhUVFAgVHVubmVsIFRlc3RlcjwvdGl0bGU+IjtpOjg3NjtzOjc4OiJteVxzKkBwc1xzKj1ccyotY1xzKjFccyoteFxzKi14IlxzKixccyoiL3Vzci9zYmluL2FjcGlkIlxzKixccyoiL3Vzci9zYmluL2Nyb24iO2k6ODc3O3M6MTE2OiJkZWZpbmVcKCdTSEVMTF9QQVNTV09SRCdccyosXHMqXCRoYXNoZWRfcGFzc3dvcmRcKVxzKjtccypkZWZpbmVcKCdNQVhfVVBfTEVWRUxTJyxccypcZCtcKVxzKjtccyppZlwoZW1wdHlcKFwkX0NPT0tJRSI7aTo4Nzg7czoxMDc6IjtcJFx7XCRcd3sxLDQwfVx9XHMqPVxzKmdldF9vcHRpb25cKEVXUFRfUExVR0lOX1NMVUdcKTtlY2hvIlteIl0rIlxzKlwuXHMqZXNjX2F0dHJcKFwkXHtcJFx7IlteIl0rIlx9XHMqXFsiIjtpOjg3OTtzOjY0OiJXcml0ZVBheWxvYWRcKFxzKlwkbG9jYWxfcGF5bG9hZF9wYXRoXHMqLFxzKlwkcGF5bG9hZF9maWxlXHMqXCk7IjtpOjg4MDtzOjUxOiJldmFsXChnenVuY29tcHJlc3NcKGJhc2U2NF9kZWNvZGVcKCdlTnFzL2Z1UEs5dFdINDciO2k6ODgxO3M6MzE6IldhaGliXHMrTWthZG1pXHMrUHJpdjhccytNYWlsM1IiO2k6ODgyO3M6MTkyOiI8XD9waHBccypzZXNzaW9uX3N0YXJ0XChccypcKTtccypcJG1haWxccyo9XHMqXCRfU0VTU0lPTlxbJ21haWwnXF1ccyo9XHMqXCRfUE9TVFxbJ21haWwnXF07XHMqXCRwYXNzXHMqPVxzKlwkX1NFU1NJT05cWydwYXNzJ1xdXHMqPVxzKlwkX1BPU1RcWydcdysnXF07XHMqXCRJUFxzKj1ccypcJF9TRVJWRVJcWydSRU1PVEVfQUREUidcXTsiO2k6ODgzO3M6Mzc6IlJlelxzK2J5XHMrXFtccytiYWphdGF4XHMrLS1ccytTbmlwZXIiO2k6ODg0O3M6NDk6ImhpZGVccystc1xzKyIvdXNyL3NiaW4vaHR0cGQiXHMrLWRccystcFxzK2F4XC5waWQiO2k6ODg1O3M6NTM6IjpcJHtcJFx3K309cGhwX3VuYW1lXChwcmVnX3JlcGxhY2VcKCIvXF4tLyIsIiIsXCR7XCR7IjtpOjg4NjtzOjk4OiJwcmludFxzKiJTZW5kaW5nXHMqTWFpbFxzKlRvXHMqXCR0b1wuXC5cLlwuIjtccypmbHVzaFwoXCk7XHMqXCRoZWFkZXJccyo9XHMqIkZyb206XHMqXCRyZWFsbmFtZW5ldyI7aTo4ODc7czoxNTY6IjxcP3BocFxzKlwkXHd7MSw0MH1ccyo9XHMqbWQ1XHMqXChccyoiW14iXSoiXHMqXClccyo7XHMqXD9ccyo+PFw/cGhwXHMqZXZhbFxzKlwoXHMqZ3p1bmNvbXByZXNzXHMqXChccypiYXNlNjRfZGVjb2RlXHMqXChccyoiW14iXSoiXHMqXClccypcKVxzKlwpXHMqO1xzKlw/PiI7aTo4ODg7czo2NDoiXChcJFtPMF9dK1xzKixccypDVVJMT1BUX1VTRVJBR0VOVCxcXCdXSFJcXCdcKTtcJHsiXFx4W14iXSsifVxbIiI7aTo4ODk7czo4NToiXCk7XCRcdys9XCRcdytcKCcnLFwkXHcrXChcJFx3K1woIlx3KyIsIiIsXCRcdytcLlwkXHcrXC5cJFx3K1wuXCRcdytcKVwpXCk7XCRcdytcKFwpOyI7aTo4OTA7czoxMDU6IihcJFx3Kyk9J3ByZWdfcmVwbGFjZSc7KFwkXHcrKT0nZXZhbFwoYmFzZTY0X2RlY29kZVwoIlteIl0rIlwpXCk7Lio/OyhcJFx3Kyk9Ii8oXHcrKS9lIjtcMVwoXDMsXDIsJ1w0J1wpOyI7aTo4OTE7czoxNTk6IihcJFx3Kyk9J2Jhc2U2NF9kZWNvZGUnOyhcJFx3Kyk9J2NyZWF0ZV9mdW5jdGlvbic7aWZcKCFlbXB0eVwoXCRfUkVRVUVTVFxbJyhcdyspJ1xdXClcKXsoXCRcdyspPXN0cnJldlwoXCRfUkVRVUVTVFxbJ1wzJ1xdXCk7KFwkXHcrKT1cMlwoJycsXDFcKFw0XClcKTtcNVwoXCk7fSI7aTo4OTI7czo5NToiKFwkXHcrKT0iYXNzZXJ0IjtcMVwoWyd8Il1ldmFsXChnenVuY29tcHJlc3NcKGJhc2U2NF9kZWNvZGVcKFsnfCJdW14nfF4iXSsnXClcKVwpO1snfCJdXCk7ZXhpdDsiO2k6ODkzO3M6NTMyOiIoXCRcdyspPXNjYW5kaXJcKFwkX1NFUlZFUlxbJ0RPQ1VNRU5UX1JPT1QnXF1cKTtmb3JcKChcJFx3Kyk9MDtcMjxjb3VudFwoXDFcKTtcMlwrXCtcKXtpZlwoc3RyaXN0clwoXDFcW1wyXF0sJ3BocCdcKVwpeyhcJFx3Kyk9ZmlsZW10aW1lXChcJF9TRVJWRVJcWydET0NVTUVOVF9ST09UJ1xdXC4iLyJcLlwxXFtcMlxdXCk7YnJlYWs7fX10b3VjaFwoZGlybmFtZVwoX19GSUxFX19cKSxcM1wpO3RvdWNoXChcJF9TRVJWRVJcWydTQ1JJUFRfRklMRU5BTUUnXF0sXDNcKTsuKj8oXCRcdyspPW5ldyBaaXBBcmNoaXZlXChcKS4qP1w0LT5leHRyYWN0VG9cKFwkXHcrXCk7Lio/PGZvcm0gZW5jdHlwZT0ibXVsdGlwYXJ0L2Zvcm0tZGF0YSIgbWV0aG9kPSJwb3N0IiBhY3Rpb249IiI+PGxhYmVsPjxpbnB1dCBjbGFzcz0iXHcrIiB0eXBlPSJmaWxlIiBuYW1lPSJcdysiIC8+PC9sYWJlbD48YnIgLz48aW5wdXQgdHlwZT0ic3VibWl0IiBuYW1lPSJzdWJtaXQiIGNsYXNzPSJcdysiIHZhbHVlPSJcdysiIC8+PC9mb3JtPjwvYm9keT48L2h0bWw+Ijt9"));
$gX_FlexDBShe = unserialize(base64_decode("YTowOnt9"));
$gXX_FlexDBShe = unserialize(base64_decode("YTowOnt9"));
$g_ExceptFlex = unserialize(base64_decode("YTowOnt9"));
$g_AdwareSig = unserialize(base64_decode("YTowOnt9"));
$g_PhishingSig = unserialize(base64_decode("YTowOnt9"));
$g_JSVirSig = unserialize(base64_decode("YTo1MDp7aTowO3M6MTMzMToiKHZhclxzK1x3Kz1cWygiXGQrIiw/KXszLH1cXTt8ZnVuY3Rpb25ccytcdytcKFx3K1wpe3JldHVyblxzK1x3K1woXHcrXChcdytcKSwnXHcrJ1wpO1xzKn18ZnVuY3Rpb25ccypcdytccypcKFxzKlx3K1xzKlwpXHMqXHtccyp2YXJccypcdytccyo9J1teJ10qJ1xzKjtccyp2YXJccypcdytccyo9XHMqXGQrXHMqO1xzKnZhclxzKlx3K1xzKj1ccypcZCtccyo7XHMqZm9yXHMqXChccypcdytccyo9XHMqXGQrXHMqO1xzKlx3K1xzKjxccypcdytccypcLlxzKmxlbmd0aC9cZCtccyo7XHMqXHcrXCtcK1xzKlwpXHMqXHtccypcdytcKz1ccypTdHJpbmdccypcLlxzKmZyb21DaGFyQ29kZVxzKlwoXHMqXHcrXHMqXC5ccypzbGljZVxzKlwoXHMqXHcrXHMqLFxzKlx3K1wrM1xzKlwpXHMqXClccyo7XHMqXHcrXHMqPVxzKlx3K1wrM1xzKjtccypcfVxzKnJldHVyblxzKlx3K1xzKjtccypcfXxmdW5jdGlvblxzKlxkK1xzKlwoXHMqXCRcdytccyosXHMqXCRcdytccypcKVxzKlx7XHMqdmFyXHMqXCRcdytccyo9J1teJ10qJ1xzKjtccyp2YXJccypcJFx3K1xzKj1ccypcZCtccyo7XHMqdmFyXHMqXCRcdytccyo9XHMqXGQrXHMqO1xzKmZvclxzKlwoXHMqXCRcdytccyo9XHMqXGQrXHMqO1xzKlwkXHcrXHMqPFxzKlwkXHcrXHMqXC5ccypsZW5ndGhccyo7XHMqXCRcdytcK1wrXHMqXClccypce1xzKnZhclxzKlwkXHcrXHMqPVwkXHcrXHMqXC5ccypjaGFyQXRccypcKFxzKlwkXHcrXHMqXClccyo7XHMqdmFyXHMqXCRcdytccyo9XCRcdytccypcLlxzKmNoYXJDb2RlQXRccypcKFxzKjBccypcKVxzKlxeXCRcdytccypcLlxzKmNoYXJDb2RlQXRccypcKFxzKlwkXHcrXHMqXClccyo7XHMqXCRcdytccyo9XHMqU3RyaW5nXHMqXC5ccypmcm9tQ2hhckNvZGVccypcKFxzKlwkXHcrXHMqXClccyo7XHMqXCRcdytcKz1cJFx3K1xzKjtccyppZlxzKlwoXHMqXCRcdytccyo9PVwkXHcrXHMqXC5ccypsZW5ndGgtMVxzKlwpXHMqXCRcdytccyo9XHMqXGQrXHMqO1xzKmVsc2VccypcJFx3K1wrXCtccyo7XHMqXH1ccypyZXR1cm5ccypcKFxzKlwkXHcrXHMqXClccyo7XHMqXH18ZnVuY3Rpb24gXHcrXChcdyssXHcrXCl7dmFyIFx3Kz0nJzt2YXIgXHcrPTA7dmFyIFx3Kz0wO2ZvclwoXHcrPTAuKz9cdys9MDtlbHNlIFx3K1wrXCs7fXJldHVybiBcKFx3K1wpO318ZnVuY3Rpb24gXHcrXChcdytcKXt2YXIgXHcrPWRvY3VtZW50XFtcdytcKFx3K1xbXGQrXF1cKVxdXChcdytcKFx3K1xbMFxdXClcKy4rPzt9XHcrXChcdytcKFx3K1xbXGQrXF1cKVwpO3xmdW5jdGlvblxzK1x3K1woXHcrXCl7cmV0dXJuXHMrXHcrXChcdytcKFx3K1wpLCdbXiddKydcKTt9KXsyLH0iO2k6MTtzOjkzOiI8c2NyaXB0PnZhciBcdz0nJzsgc2V0VGltZW91dFwoXGQrXCk7Lis/ZGVmYXVsdF9rZXkuKz9zZV9yZS4rP2RlZmF1bHRfa2V5Lis/Zl91cmwuKz88L3NjcmlwdD4iO2k6MjtzOjExNDoiPHNjcmlwdFtePl0rPnZhciBhPS4rP1N0cmluZ1wuZnJvbUNoYXJDb2RlXChhXC5jaGFyQ29kZUF0XChpXClcXjJcKX1jPXVuZXNjYXBlXChiXCk7ZG9jdW1lbnRcLndyaXRlXChjXCk7PC9zY3JpcHQ+IjtpOjM7czoyNTQ6InZhciBcdys9XFsiMFxkezIsfSIsLis/IlxkKyJcXTtmdW5jdGlvbiBcdytcKFx3K1wpe3ZhciBcdys9ZG9jdW1lbnRcW1x3K1woXHcrXFtcZCtcXVwpXF1cKFx3K1woXHcrXFtcZCtcXVwpXCtcdytcKFx3K1xbXGQrXF1cKS4rP1N0cmluZ1wuZnJvbUNoYXJDb2RlXChcdytcLnNsaWNlXChcdyssLis/ZWxzZSBcdytcK1wrO31yZXR1cm5cKFx3K1wpO30oZnVuY3Rpb24gXHcrXChcdytcKXtyZXR1cm4gXHcrXChcdytcKFx3K1wpLCdcdysnXCk7fSk/IjtpOjQ7czoyODk6ImZ1bmN0aW9uXHNcdytcKFx3K1xzKixccypcdytcKVxzKnt2YXJcc1x3Kz0nJzt2YXJcc1x3Kz0wO3ZhclxzXHcrPTA7Zm9yXChcdys9MDtcdys8XHcrXC5sZW5ndGg7XHcrXCtcK1wpe3ZhclxzXHcrPVx3K1wuY2hhckF0XChcdytcKTt2YXJcc1x3Kz1cdytcLmNoYXJDb2RlQXRcKDBcKVxeXHcrXC5jaGFyQ29kZUF0XChcdytcKTtcdys9U3RyaW5nXC5mcm9tQ2hhckNvZGVcKFx3K1wpO1x3K1wrPVx3KztpZlwoXHcrPT1cdytcLmxlbmd0aC0xXClcdys9MDtlbHNlXHNcdytcK1wrO31yZXR1cm5cKFx3K1wpO30iO2k6NTtzOjI5MjoiZnVuY3Rpb25cc1x3K1woXHcrXCl7dmFyXHNcdys9ZG9jdW1lbnRcW1x3K1woXHcrXFtcZFxdXClcXVwoXHcrXChcdytcW1xkXF1cKVwrXHcrXChcdytcW1xkXF1cKVwrXHcrXChcdytcW1xkXF1cKVwpO1x3K1xbXHcrXChcdytcW1xkXF1cKVxdPVx3KztcdytcW1x3K1woXHcrXFtcZFxdXClcXT1cdytcKFx3K1xbXGRcXVwpO2RvY3VtZW50XFtcdytcKFx3K1xbXGRcXVwpXF1cKFx3K1woXHcrXFtcZFxdXClcKVxbXGRcXVxbXHcrXChcdytcW1xkXF1cKVxdXChcdytcKTt9XHcrXChcdytcKFx3K1xbXGQuXF1cKVwpOyI7aTo2O3M6MTgwOiJmdW5jdGlvblxzXHcrXChcdytcKVx7dmFyXHNcdys9Jyc7dmFyXHNcdys9MDt2YXJcc1x3Kz0wO2ZvclwoXHcrPTA7XHcrPFx3K1wubGVuZ3RoLzM7XHcrXCtcK1wpXHtcdytcKz1TdHJpbmdcLmZyb21DaGFyQ29kZVwoXHcrXC5zbGljZVwoXHcrLFxzXHcrXCszXClcKTtcdys9XHcrXCszO1x9cmV0dXJuXHNcdys7XH0iO2k6NztzOjk2OiJ2YXJcc1x3Kz1cWyJcZCsiLFxzIlxkKyIsIlxkKyIsXHNcIlxkKyIsIlxkKyIsXHMiXGQrIixccyJcZCsiLFxzIlxkKyIsXHMiXGQrIixccyJcZCsiLFxzIlxkKyJcXTsiO2k6ODtzOjExODoiL1wqXHd7MzJ9XCovXHMqdmFyXHMrXzB4XHcrPVxbLis/XV09ZnVuY3Rpb25cKFwpe2Z1bmN0aW9uLis/XCl9ZWxzZSB7cmV0dXJuIGZhbHNlfTtyZXR1cm4gXzB4Lis/XCk7fTt9O1xzKi9cKlx3ezMyfVwqLyI7aTo5O3M6NTA6Ii9cKlx3ezMyfVwqL1xzKjtccyp3aW5kb3dcWyJcXHhcZHsyfS4qL1wqXHd7MzJ9XCovIjtpOjEwO3M6OTI6Ii9cKlx3ezMyfVwqLztcKGZ1bmN0aW9uXChcKXt2YXJccypcdys9IiI7dmFyXHMqXHcrPSJcdysiO2Zvci4rP1wpXCk7fVwpXChcKTsvXCpcd3szMn1cKi9ccyokIjtpOjExO3M6NzI4OiIoZnVuY3Rpb24gXHcrXChcdytcKXt2YXIgXHcrPScnO3ZhciBcdys9MDt2YXIgXHcrPTA7Zm9yXChcdys9MDtcdys8XHcrXC5sZW5ndGgvXGQrO1x3K1wrXCtcKXtcdytcKz1TdHJpbmdcLmZyb21DaGFyQ29kZVwoXHcrXC5zbGljZVwoXHcrLFx3K1wrXGQrXClcKTtcdys9XHcrXCtcZCs7fXJldHVybiBcdys7fXxmdW5jdGlvbiBcdytcKFx3KyxcdytcKXt2YXIgXHcrPScnO3ZhciBcdys9MDt2YXIgXHcrPTA7Zm9yXChcdys9MDtcdys8XHcrXC5sZW5ndGg7XHcrXCtcK1wpe3ZhciBcdys9XHcrXC5jaGFyQXRcKFx3K1wpO3ZhciBcdys9XHcrXC5jaGFyQ29kZUF0XCgwXClcXlx3K1wuY2hhckNvZGVBdFwoXHcrXCk7XHcrPVN0cmluZ1wuZnJvbUNoYXJDb2RlXChcdytcKTtcdytcKz1cdys7aWZcKFx3Kz09XHcrXC5sZW5ndGgtMVwpXHcrPTA7ZWxzZSBcdytcK1wrO31yZXR1cm4gXChcdytcKTt9fGZ1bmN0aW9uIFx3K1woXHcrXCl7dmFyIFx3Kz1kb2N1bWVudFxbXHcrXChcdytcW1xkK1xdXClcXVwoXHcrXChcdytcW1xkK1xdXClcK1x3K1woXHcrXFtcZCtcXVwpXCtcdytcKFx3K1xbXGQrXF1cKVwpO1x3K1xbXHcrXChcdytcW1xkK1xdXClcXT1cdys7XHcrXFtcdytcKFx3K1xbXGQrXF1cKVxdPVx3K1woXHcrXFtcZCtcXVwpO2RvY3VtZW50XFtcdytcKFx3K1xbXGQrXF1cKVxdXChcdytcKFx3K1xbXGQrXF1cKVwpXFtcZCtcXVxbXHcrXChcdytcW1xkK11cKV1cKFx3K1wpO30pKyI7aToxMjtzOjI3MzoiPHNjcmlwdD5mdW5jdGlvbiBcdytcKFx3K1wpe3ZhciBcdys9XGQrLFx3Kz1cZCs7dmFyIFx3Kz0nXGQrLVxkKyxcZCstXGQrLis/ZnVuY3Rpb24gXHcrXChcdytcKXtccyp3aW5kb3dcLmV2YWxcKFwpO1xzKn0uKz88c2NyaXB0PmZ1bmN0aW9uIFx3K1woXCl7aWYgXChuYXZpZ2F0b3JcLnVzZXJBZ2VudFwuaW5kZXhPZlwoIk1TSUUuKz9mcm9tQ2hhckNvZGVcKFxzKlwoXHcrXC5jaGFyQ29kZUF0XChcdytcK1xkK1wpLVxkK1wpXHMqXF5ccypcdytcKVxzKlwpO319PC9zY3JpcHQ+IjtpOjEzO3M6MjMxOiJcKGZ1bmN0aW9uXChcKXt2YXJccy49IlwoXHcrXChcdytcKWZcLlx3Kyw9XHcrXC9cKVx3K1wpJ1x3K1wvXClcdytcKScuXClcdytcKCc9XClcdytcL1xbO1woXHcrXD9cITE9XHcrJ1wpXF1cdytcKFx3Kz1cdyssPVx3K1wuXHcrJz1cdytcKFx3K1woXHcrXCtcKVx3KycuPVx3K1wrXHcrXCEnXHcrIVx3KyZcdytcKFx3K1wpLVx7XHcrXChcdytcKFx3K1wuXHcrXC4uKz9ldmFsXChcdytcKTtcfVwoXClcKTsiO2k6MTQ7czoyNTg6IjxzY3JpcHQ+Lio8XCFcW0NEQVRBLip3aW5kb3dcLmFcZHsxMH1ccz1cczEuKmRvY3VtZW50XC5jb29raWVcLm1hdGNoXChuZXcuKmRlY29kZVVSSUNvbXBvbmVudC4qU3RyaW5nXC5mcm9tQ2hhckNvZGUuKm5hdmlnYXRvclwudXNlckFnZW50XC50b0xvd2VyQ2FzZS4qaGVhZFwuYXBwZW5kQ2hpbGRcKC4qO3dpbmRvd1wuYVxkezEwfS4qc3RyaW5naWZ5Lio8aWZyYW1lXHNpZC4qYVxkezEwfS4qZGlzcGxheTpcc25vbmUuKlwuaHRtbC4qPFwvaWZyYW1lPiI7aToxNTtzOjI4MToidmFyIFx3Kz0nJztzZXRUaW1lb3V0XChcZCtcKTtpZlwoZG9jdW1lbnRcLnJlZmVycmVyXC5pbmRleE9mXChsb2NhdGlvblwucHJvdG9jb2wuKz89PW51bGxcP1wodD1kb2N1bWVudC50aXRsZVwpPT1udWxsXD8nJzp0OnZcW1xkK1xdOmtcKVwpXCsnJnNlX3JlZmVycmVyPSdcK2VuY29kZVVSSUNvbXBvbmVudFwoZG9jdW1lbnRcLnJlZmVycmVyXClcKycmc291cmNlPSdcK2VuY29kZVVSSUNvbXBvbmVudFwod2luZG93XC5sb2NhdGlvblwuaG9zdFwpXClcKyciPjwnXCsnXC9zY3JpcHQ+J1wpO30iO2k6MTY7czo4MjoiPHNjcmlwdCBzcmM9Imh0dHA6Ly93ZWJzaG9wLXRvb2wtbWFuYWdlclwuaW5mby9zdGF0aXN0aWMvZ29vZ2xlYXBpc1wuanMiPjwvc2NyaXB0PiI7aToxNztzOjE0MDoiO3ZhclxzKihcdyspPVxbLio/Il07ZnVuY3Rpb25ccyooXHcrKVwoXClce3ZhclxzKlx3Kz1uYXZpZ2F0b3JcW1wxXFtcZFxdXF1cfFx8bmF2aWdhdG9yXFtcMS4qP1wyXChcKT09PVwhMCYmXCh3aW5kb3dcW1wxXFtcZFxdXF09XDFcW1xkXF1cKTsiO2k6MTg7czoxMTU6InZhclxzKihcdyspXHMqPVxbKCJcZCsiLD8pK1xdOyhmdW5jdGlvblxzKlx3K1woXHcrXClce3JldHVyblxzKlx3K1woXHcrXChcdytcKSwnXHcrJ1wpO1x9KT9cdytcKFx3K1woXDFcW1xkK1xdXClcKTsiO2k6MTk7czoxNTg6IlwvXCpcdy4rP1wuanMuKz9cKlwvO1xzKlwoXHMqZnVuY3Rpb25cKFwpXHMqe3ZhclxzXHd7OH1cPS4rP2ZvclxzKlwoXHMqdmFyXHMqXHd7OH1ccyo9Lis/U3RyaW5nXC5mcm9tQ2hhckNvZGVcKFwnXCtcd3s4fVwrXCdcKVwnXClcKVw7XH1cKVxzKlwoXClcO1wvXCouKz9cKlwvIjtpOjIwO3M6NDg4OiI8c2NyaXB0PnZhciBhPScnO3NldFRpbWVvdXRcKFxkK1wpO2Z1bmN0aW9uIHNldENvb2tpZVwoYSxiLGNcKXt2YXIgZD1uZXcgRGF0ZTtkXC5zZXRUaW1lXChkXC5nZXRUaW1lXChcKVwrXGQrXCpjXCpcZCtcKlx3K1wpO3ZhciBlPSJleHBpcmVzPSJcK2RcLnRvVVRDU3RyaW5nXChcKTtkb2N1bWVudFwuY29va2llPWFcKyI9IlwrYlwrIjsgIlwrZX1mdW5jdGlvbiBnZXRDb29raWVcKGFcKXtmb3JcKHZhciBiPWFcKyI9IixjPWRvY3VtZW50XC5jb29raWVcLnNwbGl0XCgiOyJcKSxkPTA7ZDxjXC5sZW5ndGg7ZFwrXCtcKXtmb3JcKHZhciBlPWNcW2RcXTsiICI9PWVcLmNoYXJBdFwoXGQrXCk7Lis/dD1kb2N1bWVudFwudGl0bGVcKT09bnVsbFw/Jyc6dDp2XFtcZCtcXTprXClcKSBcKyAnJnNlX3JlZmVycmVyPScgXCsgZW5jb2RlVVJJQ29tcG9uZW50XChkb2N1bWVudFwucmVmZXJyZXJcKSBcKyAnIj48JyBcKyAnL3NjcmlwdD4nXClcKVwpOzwvc2NyaXB0PiI7aToyMTtzOjgxOiI8c2NyaXB0PlxzKnRoaXNcWydldmFsJ1xdXChTdHJpbmdcWydmcm9tQ2hhckNvZGUnXF1ccypcKChcZCssPykrXClcKTtccyo8L3NjcmlwdD4iO2k6MjI7czoyNTY6InZhclxzKlx3Kz0iW14iXSsiXHMqLFxzKlx3Kz0iIlxzKixccypcdys9IiJccyosXHMqXHcrO1xzKlx3Kz1cdytcW1xzKidsZW5ndGgnXHMqXF1ccyo7XHMqZm9yXChccyppPTA7XHMqaTxcdys7XHMqaVwrXCtccypcKVxzKntccypcdytcKz1TdHJpbmdcWydmcm9tQ2hhckNvZGUnXF1ccypcKFx3K1xbJ2NoYXJDb2RlQXQnXF1cKGlcKVwrMlwpXHMqfVxzKlx3Kz10aGlzXFsndW5lc2NhcGUnXF1cKFx3K1wpO1xzKnRoaXNcWydldmFsJ1xdXChcdytcKTsiO2k6MjM7czoxNDIwOiI8c2NyaXB0PnZhciBhPScnO3NldFRpbWVvdXRcKFxkK1wpO2Z1bmN0aW9uIHNldENvb2tpZVwoYSxiLGNcKXt2YXIgZD1uZXcgRGF0ZTtkXC5zZXRUaW1lXChkXC5nZXRUaW1lXChcKVwrNjBcKmNcKjYwXCoxZTNcKTt2YXIgZT0iZXhwaXJlcz0iXCtkXC50b1VUQ1N0cmluZ1woXCk7ZG9jdW1lbnRcLmNvb2tpZT1hXCsiPSJcK2JcKyI7ICJcK2V9ZnVuY3Rpb24gZ2V0Q29va2llXChhXCl7Zm9yXCh2YXIgYj1hXCsiPSIsYz1kb2N1bWVudFwuY29va2llXC5zcGxpdFwoIjsiXCksZD0wO2Q8Y1wubGVuZ3RoO2RcK1wrXCl7Zm9yXCh2YXIgZT1jXFtkXF07IiAiPT1lXC5jaGFyQXRcKDBcKTtcKWU9ZVwuc3Vic3RyaW5nXCgxXCk7aWZcKDA9PWVcLmluZGV4T2ZcKGJcKVwpcmV0dXJuIGVcLnN1YnN0cmluZ1woYlwubGVuZ3RoLGVcLmxlbmd0aFwpfXJldHVybiBudWxsfW51bGw9PWdldENvb2tpZVwoIl9fY2Znb2lkIlwpJiZcKHNldENvb2tpZVwoIl9fY2Znb2lkIiwxLDFcKSwxPT1nZXRDb29raWVcKCJfX2NmZ29pZCJcKSYmXChzZXRDb29raWVcKCJfX2NmZ29pZCIsMiwxXCksZG9jdW1lbnRcLndyaXRlXCgnPHNjcmlwdCB0eXBlPSJ0ZXh0L2phdmFzY3JpcHQiIHNyYz0iJyBcKyAnLio/anF1ZXJ5XC5taW5cLnBocCdccypcK1xzKidcP2tleT1cdysnXHMqXCsgJyZ1dG1fY2FtcGFpZ249J1xzKlwrXHMqJ1x3KydccypcK1xzKicmdXRtX3NvdXJjZT0nXHMqXCtccyp3aW5kb3dcLmxvY2F0aW9uXC5ob3N0XHMqXCtccyonJnV0bV9tZWRpdW09J1xzKlwrXHMqJyZ1dG1fY29udGVudD0nIFwrIHdpbmRvd1wubG9jYXRpb24gXCsgJyZ1dG1fdGVybT0nXHMqXCtccyplbmNvZGVVUklDb21wb25lbnRcKFwoXChrPVwoZnVuY3Rpb25cKFwpe3ZhciBrZXl3b3Jkc1xzKj1ccyonJzt2YXIgbWV0YXMgPVxzKmRvY3VtZW50XC5nZXRFbGVtZW50c0J5VGFnTmFtZVwoJ21ldGEnXCk7aWYgXChtZXRhc1wpXHMqe2ZvclxzKlwodmFyIHg9MCx5PW1ldGFzXC5sZW5ndGg7IHg8eTsgeFwrXCtcKVxzKntpZlxzKlwobWV0YXNcW3hcXVwubmFtZVwudG9Mb3dlckNhc2VcKFwpXHMqPT1ccyoia2V5d29yZHMiXClccypce2tleXdvcmRzIFwrPSBtZXRhc1xbeFxdXC5jb250ZW50O1x9XH1cfXJldHVybiBrZXl3b3Jkc1xzKlwhPT1ccyonJ1xzKlw/IGtleXdvcmRzXHMqOlxzKm51bGw7XH1cKVwoXClcKT09bnVsbFw/XCh2PXdpbmRvd1wubG9jYXRpb25cLnNlYXJjaFwubWF0Y2hcKC91dG1fdGVybT1cKFxbXF5cJlxdXCtcKVwvXClcKT09bnVsbFw/XCh0PWRvY3VtZW50XC50aXRsZVwpPT1udWxsXD8nJzp0OnZcWzFcXTprXClcKSBcKyAnXCZzZV9yZWZlcnJlcj0nXHMqXCsgZW5jb2RlVVJJQ29tcG9uZW50XChkb2N1bWVudFwucmVmZXJyZXJcKVxzKlwrXHMqJyI+PCdccypcKyAnXC9zY3JpcHQ+J1wpXClcKTs8XC9zY3JpcHQ+IjtpOjI0O3M6NDM1OiI8c2NyaXB0XHMqdHlwZT0idGV4dC9qYXZhc2NyaXB0Ij52YXJccypcdytccyo9XHMqbmV3XHMqUmVnRXhwXCgnXHcrJ1wrJz1cKFxbXF47XF1cKVx7MSxcfSdcKTt2YXJccypcdytccyo9XHMqXHcrXC5leGVjXChkb2N1bWVudFwuY29va2llXCk7aWZcKFx3K1wpe1x3K1xzKj1ccypcdytcWzBcXVwuc3BsaXRcKCc9J1wpO1x3K1xzKj1ccypcKFx3K1xbMVxdXHMqXD9ccypcdytcWzFcXVxzKjpccypmYWxzZVwpO31lbHNle1x3K1xzKj1ccypmYWxzZTt9aWZcKFx3K1xzKiE9XHMqJ1x3KydcKXt2YXJccypcdytccyo9XHMqbmV3XHMqRGF0ZVwoXCk7XHcrXC5zZXREYXRlXChcdytcLmdldERhdGVcKFwpXCsxXCk7ZG9jdW1lbnRcLmNvb2tpZVxzKj1ccyonXHcrJ1wrJz0nXCsnXHcrJ1wrJztccypleHBpcmVzPSdcK1x3K1wudG9VVENTdHJpbmdcKFwpO308L3NjcmlwdD4iO2k6MjU7czo3NToidmFyXHMqXHd7MTAsMzB9PS4qXC5jaGFyQXRcKFxzKlx3ezUsMzB9XHMqXClccypcfVxzKmV2YWxcKFxzKlx3ezUsMzB9XHMqXCk7IjtpOjI2O3M6Nzk6InZhciBfKFx3Kyk9XFsiKFxceFthLWZBLUYwLTkiLF0rKStcXTtkb2N1bWVudFxbX1wxXFtcZCtcXV1cKChfXDFcW1xkK1xdXCs/KStcKTsiO2k6Mjc7czoxNzk6ImRvY3VtZW50XFsiXFx4NzdcXHg3MlxceDY5XFx4NzRcXHg2NSJcXVwoIlxceDNDXFx4NzNcXHg2M1xceDcyXFx4NjlcXHg3MFxceDc0XFx4MjBcXHg3M1xceDcyXFx4NjNcXHgzRFxceDIyW1xcYS16QS1aMC05XStcXHgyMlxceDNFXFx4M0NcXHgyRlxceDczXFx4NjNcXHg3MlxceDY5XFx4NzBcXHg3NFxceDNFIlwpIjtpOjI4O3M6MzQwOiI8c2NyaXB0PnZhclxzKmI9Ilx3ezEsMzB9IjtccypjPSJcd3sxLDMwfSI7XHMqZnVuY3Rpb24gc2V0Q29va2llXChccyphLGIsY1wpe1xzKnZhclxzKmRccyo9XHMqbmV3XHMqRGF0ZTtkXC5zZXRUaW1lXChccypkXC5nZXRUaW1lXChccypcKVxzKlwrXHMqXGQrXHMqXCpccypjXHMqXCpccypcZCtccypcKlxzKlx3ezEsMzB9XHMqXCk7XHMqdmFyXHMqZT0iZXhwaXJlcz0iXCtkXC50b1VUQ1N0cmluZ1woXCk7XHMqZG9jdW1lbnRcLmNvb2tpZS4rP2VuY29kZVVSSUNvbXBvbmVudFwoZG9jdW1lbnRcLnJlZmVycmVyXClccypcK1xzKiciPls8c2NyaXB0Lz4nK1xzXStcKVwpXCk7XHMqPC9zY3JpcHQ+IjtpOjI5O3M6MjUwOiI8c2NyaXB0XHMqbGFuZ3VhZ2U9IkphdmFTY3JpcHQxXC4xIlxzKnR5cGU9InRleHQvamF2YXNjcmlwdCI+XHMqPCEtLVxzKmxvY2F0aW9uXC5yZXBsYWNlXCgiaHR0cDovL3ZrY29taWlcLnJ1L3lhbmRleHh4LyJcKTtccyovLy0tPlxzKjwvc2NyaXB0PlxzKjxub3NjcmlwdD5ccyo8bWV0YSBodHRwLWVxdWl2PSJSZWZyZXNoIlxzKmNvbnRlbnQ9IjM7XHMqVVJMPWh0dHA6Ly92a2NvbWlpXC5ydS95YW5kZXh4eC8iPlxzKjwvbm9zY3JpcHQ+IjtpOjMwO3M6MjI3OiI8c2NyaXB0IHR5cGU9InRleHQvamF2YXNjcmlwdCI+XHMqaWYgXChzY3JlZW5cLndpZHRoIDw9IDQ4MFwpLitkb2N1bWVudFwud3JpdGVcKCc8c2NyaXB0IGxhbmd1YWdlPSJqYXZhc2NyaXB0Ij5kb2N1J1wrJ21lbnRcLmxvY2F0aW9uPSJodHRwOi8vcG9ydGFsLWJcLnB3L1hjVHlUcCI8L3MnXCsnY3JpcHQ+J1wpfWVsc2V7ZG9jdW1lbnRcLndyaXRlXCgnXC4nXCl9fVJcKFwpO1xzKjwvc2NyaXB0PiI7aTozMTtzOjE2MzoidmFyXHMrXzB4XHd7MSwyMH09XFtbXlxdXStcXTtccypkb2N1bWVudFxbXzB4XHcrXFtcdytcXVxdXChfMHhcdytcW1x3K1xdXFtfMHhcdytcW1x3K1xdXF1cKF8weFx3K1xbXHcrXF1cKVxbXzB4XHcrXFtcdytcXVxdXChcKVxbXzB4XHcrXFtcdytcXVxdXChfMHhcdytcW1x3K1xdXClcKSI7aTozMjtzOjQ1MDoiPFxzKnNjcmlwdFxzKj5ccypldmFsXHMqXChccypmdW5jdGlvblxzKlwoXHMqLlxzKixccyouXHMqLFxzKi5ccyosXHMqLlxzKixccyouXHMqLFxzKi5ccypcKVxzKlx7XHMqLlxzKj1ccypmdW5jdGlvblxzKlwoXHMqLlxzKlwpXHMqXHtccypyZXR1cm5ccypcKFxzKi5ccyo8XHMqLlxzKlw/XHMqIlteIl0qIjouXHMqXChccypwYXJzZUludFxzKlwoXHMqLi8uXHMqXClccypcKVxzKlwpXHMqXCtccypcKFxzKlwoXHMqLlxzKj1ccyouXHMqJVxzKi5ccypcKVxzKj5ccypcZCtccypcP1xzKlN0cmluZ1xzKlwuXHMqZnJvbUNoYXJDb2RlXHMqXChccyouXCtccypcZCtccypcKVxzKjouXHMqXC5ccyp0b1N0cmluZ1xzKlwoXHMqXGQrXHMqXClccypcKVxzKi4rP3NwbGl0XHMqXChccyonW14nXSonXHMqXClccyosXHMqXGQrXHMqLFxzKlx7XHMqXH1ccypcKVxzKlwpXHMqPFxzKi9zY3JpcHRccyo+IjtpOjMzO3M6MTY0OiJ2YXJccytcdys9XFsiMFxkezIsfSIsW15dXStcXTtmdW5jdGlvbi4rP1N0cmluZ1wuZnJvbUNoYXJDb2RlXChcdytcLnNsaWNlXChcdyssW159XSt9cmV0dXJuXHMqKFwoXHcrXCl8XHcrKTt9KGZ1bmN0aW9uIFx3K1woXHcrXCl7cmV0dXJuIFx3K1woXHcrXChcdytcKSwnXHcrJ1wpO30pPyI7aTozNDtzOjk0OiJ2YXJccysoXzB4XHcrKT1cWygiKFxceC4uKSsiXHMqLD9ccyopK1xdOy4rP2RvY3VtZW50XFtfMHhcdytcW1xkK1xdXF1cW18weFx3K1xbXGQrXF1cXVwoXHcrXCk7IjtpOjM1O3M6NDEyOiJpZlxzKlwoXHMqdHlwZW9mXHMqX3BvcHduZFxzKj09XHMqJ1teJ10qJ1xzKlwpXHMqXHtccyp2YXJccypfcG9wd25kXHMqPVxzKi0xXHMqO1xzKmZ1bmN0aW9uXHMqX3BvcHduZF9vcGVuXHMqXChccypcKVxzKlx7XHMqaWZccypcKFxzKl9wb3B3bmQhPS0xXHMqXClccypyZXR1cm5ccyo7XHMqX3BvcHduZFxzKj1ccyp3aW5kb3dccypcLlxzKm9wZW5ccypcKFxzKidbXiddKidccyosXHMqJ1teJ10qJ1xzKixccyonW14nXSonXHMqXClccyo7XHMqX3BvcHduZFxzKlwuXHMqYmx1clxzKlwoXHMqXClccyo7XHMqd2luZG93XHMqXC5ccypmb2N1c1xzKlwoXHMqXClccyo7XHMqXH1ccypcfVxzKjtccyp3aW5kb3dccypcLlxzKmFkZEV2ZW50TGlzdGVuZXJccypcKFxzKidbXiddKidccyosXHMqX3BvcHduZF9vcGVuXHMqXClccyo7IjtpOjM2O3M6OTc6IjxccypzY3JpcHRccyp0eXBlXHMqPSJbXiJdKiJccypzcmNccyo9Imh0dHA6Ly91bnNsaWRlci5jb20vdW5zbGlkZXIubWluLmpzIlxzKj5ccyo8XHMqL3NjcmlwdFxzKj4iO2k6Mzc7czoyNDk6InZhclxzKl9cdytccyo9XHMqIlteIl0qIlxzKlwrXHMqZW5jb2RlVVJJQ29tcG9uZW50XHMqXChccypfdlxzKlwpLis/X1x3K1xzKlwuXHMqb25lcnJvclxzKj1ccypmdW5jdGlvblxzKlwoXHMqXHcrXHMqXClccypce1xzKl9cdytccypcLlxzKnNyY1xzKj1ccypfXHcrXCsiW14iXSoiXCtfXHcrXHMqO1xzKl9cdytccyo9XHMqZmFsc2Vccyo7XHMqXH1ccyo7XHMqX2lccypcLlxzKnNyY1xzKj1ccypfXHcrXCsiW14iXSsiXCtfXHcrXHMqOyI7aTozODtzOjEzNjoidmFyXHMqKF8weFx3Kylccyo9XHMqXFtbXl1dK1xdO2Z1bmN0aW9uXHMqXHcrXChcKVxzKntccypcdytccypfMHhcdys9KFwxXFtcZCtcXVxzKlwrP1xzKikrO3dpbmRvd1xbXDFcW1xkK1xdXF1cKF8weFx3K1xzKlwrXHMqa2V5XCk7XHMqfSI7aTozOTtzOjEzNjoidmFyXHMqKF8weFx3Kylccyo9XHMqXFtbXl1dK1xdOyhccypcd3sxLDQwfT1cMVxbXGQrXF07KSsoZnVuY3Rpb25ccypcd1woXzB4XHcrXCl7cmV0dXJuXHMqKFwxXFtcZCtcXVwrPykrfSkrZG9jdW1lbnRcW1wxXFtcZCtdXF1cKFteO10rOyI7aTo0MDtzOjM1OToiPFxzKnNjcmlwdFxzKj5ccyp2YXJccypzXHMqPVxzKmRvY3VtZW50XHMqXC5ccypyZWZlcnJlclxzKjtccyppZlxzKlwoXHMqc1xzKlwuXHMqaW5kZXhPZlxzKlwoXHMqIlteIl0qIlxzKlwpXHMqPlxzKjBccypcfFx8XHMqc1xzKlwuXHMqaW5kZXhPZlxzKlwoXHMqIlteIl0qIlxzKlwpXHMqPlxzKjBccypcfFx8XHMqc1xzKlwuXHMqaW5kZXhPZlxzKlwoXHMqIlteIl0qIlxzKlwpXHMqPlxzKjBccypcfFx8XHMqc1xzKlwuXHMqaW5kZXhPZlxzKlwoXHMqIlteIl0qIlxzKlwpXHMqPlxzKjBccypcKVxzKlx7XHMqc2VsZlxzKlwuXHMqbG9jYXRpb25ccyo9XHMqWyciXVteIiddKlsnIl1ccyo7XHMqXH1ccyo8XHMqL3NjcmlwdFxzKj4iO2k6NDE7czo2NzoiZXZhbFwoZnVuY3Rpb25cKHAsYSxjLGssZSxyXCl7Lis/dG9uZ2ppaS4rP1wuc3BsaXRcKCdcfCdcKSwwLHt9XClcKSI7aTo0MjtzOjIwODoiPHNjcmlwdD5cdys9bmV3XHMrQXJyYXlcKFteKV0rXCk7dmFyXHMqaTtccypmb3JccypcKFxzKmlccyo9XHMqMFxzKjtccyppXHMqPD1ccypcdytcLmxlbmd0aDtccyppXCtcK1wpe1xzKmRvY3VtZW50XC53cml0ZVwoXHMqU3RyaW5nXC5mcm9tQ2hhckNvZGVcKFxzKk1hdGhcLnJvdW5kXChccypcdytcW2lcXVxzKlwpXHMqXClccypcKTtccyp9O1xzKjwvc2NyaXB0PiI7aTo0MztzOjY5OiJldmFsXChmdW5jdGlvblwocCxhLGMsayxlLHJcKXsuKz90b25namlpXHx1cy4rP3NwbGl0XCgnXHwnXCksMCx7fVwpXCkiO2k6NDQ7czoyNTU6InZhclxzKnJccyo9XHMqZG9jdW1lbnRccypcLlxzKnJlZmVycmVyXHMqO1xzKnZhclxzKmNccyo9XHMqZG9jdW1lbnRccypcLlxzKmNvb2tpZVxzKjsuKz8vL2dvb2dsZS1hbmFseXppbmcuY29tL3VyY2hpblwuanMiXHMqO1xzKnZhclxzKnRccyo9XHMqZG9jdW1lbnRccypcLlxzKmdldEVsZW1lbnRzQnlUYWdOYW1lXHMqXChccyoic2NyaXB0IlxzKlwpXHMqXFtccypcZCtccypcXVxzKjt0XC5wYXJlbnROb2RlXC5pbnNlcnRCZWZvcmVcKGUsdFwpfSI7aTo0NTtzOjg3OiI8c2NyaXB0PlxzKndpbmRvd1wuYVx3K1xzKj1ccyoxO1xzKiFmdW5jdGlvbi4rP1x3XChcd1wpfVxzKjtccypcd1woXCl9XChcKTtccyo8L3NjcmlwdD4iO2k6NDY7czo5MToiPGlmcmFtZVxzKmlkPSJhXGQrIlxzKnNyYz0iLy9bXi9dKy9mMlwuaHRtbFw/YT1cZCsiXHMqc3R5bGU9ImRpc3BsYXk6XHMqbm9uZTsiPlxzKjwvaWZyYW1lPiI7aTo0NztzOjk3OiJcKGZ1bmN0aW9uXChcKVx7XHcrPVwoIlteIl0rIlxbImNoYXJDb2RlQXQiXF1bXjtdKztcdys9IlteIl0rIlxbLitcWyJjaGFyQ29kZUF0IlxdXChbXn1dK31cKVwoXCk7IjtpOjQ4O3M6OTM6IlwoZnVuY3Rpb25cKHdpbmRvd1wpXHMqe1xzKiJ1c2VccypzdHJpY3QiXHMqO1xzKnZhclxzKk1pbmVyXHMqPVxzKmZ1bmN0aW9uLittaW5lclwuc3RhcnRcKFwpOyI7aTo0OTtzOjg3OiI8c2NyaXB0XHMrbGFuZ3VhZ2U9IkphdmFzY3JpcHQiXHMrc3JjPSJodHRwOi8vcmVjYXB0Y2hhLWluXC5wdy9cdytcLmpzIlxzKj5ccyo8L3NjcmlwdD4iO30="));
$gX_JSVirSig = unserialize(base64_decode("YTowOnt9"));
$g_SusDB = unserialize(base64_decode("YTowOnt9"));
$g_SusDBPrio = unserialize(base64_decode("YTowOnt9"));
$g_DeMapper = unserialize(base64_decode("YTo1OntzOjEwOiJ3aXphcmQucGhwIjtzOjM3OiJjbGFzcyBXZWxjb21lU3RlcCBleHRlbmRzIENXaXphcmRTdGVwIjtzOjE3OiJ1cGRhdGVfY2xpZW50LnBocCI7czozMjoiZXhlYyBDVXBkYXRlQ2xpZW50OjpVcGRhdGVVcGRhdGUiO3M6MTE6ImluY2x1ZGUucGhwIjtzOjQ3OiJpZigkYnhQcm9kdWN0Q29uZmlnWydzYWFzJ11bJ3RyaWFsX3N0b3BwZWQnXSA8PiI7czo5OiJzdGFydC5waHAiO3M6NjA6IkJYX1JPT1QuJy9tb2R1bGVzL21haW4vY2xhc3Nlcy9nZW5lcmFsL3VwZGF0ZV9kYl91cGRhdGVyLnBocCI7czoxMDoiaGVscGVyLnBocCI7czo1ODoiSlBsdWdpbkhlbHBlcjo6Z2V0UGx1Z2luKCJzeXN0ZW0iLCJvbmVjbGlja2NoZWNrb3V0X3ZtMyIpOyI7fQ=="));

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
                              
define('AI_VERSION', 'HOSTER-20171019');

////////////////////////////////////////////////////////////////////////////

$l_Res = '';

$g_Structure = array();
$g_Counter = 0;
$g_SpecificExt = false;

$g_UpdatedJsonLog = 0;
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
ini_set('pcre.backtrack_limit','1000000');
ini_set('pcre.recursion_limit','200000');
ini_set('pcre.jit','1');

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
          $tmp_content = @file_get_contents($dir . '/libraries/cms/version/version.php');
   
          if (preg_match('|const\s+RELEASE\s*=\s*\'(.+?)\'|smi', $tmp_content, $tmp_ver)) {
	      $version = $tmp_ver[1];
 
             if (preg_match('|const\s+DEV_LEVEL\s*=\s*\'(.+?)\'|smi', $tmp_content, $tmp_ver)) { 
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
          if (file_exists($dir . '/core/includes/md5_sums_vbulletin.php'))
          {
                $res = true;
                require_once($dir . '/core/includes/md5_sums_vbulletin.php');
                $version = $md5_sum_versions['vb5_connect'];
          }
          else if(file_exists($dir . '/includes/md5_sums_vbulletin.php'))
          {
                $res = true;
                require_once($dir . '/includes/md5_sums_vbulletin.php');
                $version = $md5_sum_versions['vbulletin'];
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

 	if (!BOOL_RESULT)
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
	global $g_CriticalPHP, $g_Base64, $g_Phishing, $g_CriticalJS, $g_Iframer, $g_UpdatedJsonLog, 
               $g_AddPrefix, $g_NoPrefix;

	$total_files = $GLOBALS['g_FoundTotalFiles'];
	$elapsed_time = microtime(true) - START_TIME;
	$percent = number_format($total_files ? $num * 100 / $total_files : 0, 1);
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

        $l_FN = $g_AddPrefix . str_replace($g_NoPrefix, '', $par_File); 
	$l_FN = substr($par_File, -60);

	$text = "$percent% [$l_FN] $num of {$total_files}. " . $stat;
	$text = str_pad($text, 160, ' ', STR_PAD_RIGHT);
	stdOut(str_repeat(chr(8), 160) . $text, false);


      	$data = array('self' => __FILE__, 'started' => AIBOLIT_START_TIME, 'updated' => time(), 
                            'progress' => $percent, 'time_elapsed' => $elapsed_seconds, 
                            'time_left' => round($left_time), 'files_left' => $left_files, 
                            'files_total' => $total_files, 'current_file' => substr($g_AddPrefix . str_replace($g_NoPrefix, '', $par_File), -160));

        if (function_exists('aibolit_onProgressUpdate')) { aibolit_onProgressUpdate($data); }

	if (defined('PROGRESS_LOG_FILE') && 
           (time() - $g_UpdatedJsonLog > 1)) {
                if (function_exists('json_encode')) {
             	   file_put_contents(PROGRESS_LOG_FILE, json_encode($data));
                } else {
             	   file_put_contents(PROGRESS_LOG_FILE, serialize($data));
                }

		$g_UpdatedJsonLog = time();
        }
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
		'n' => 'sc',
		'o:' => 'json_report:',
		't:' => 'php_report:',
		'z:' => 'progress:',
		'g:' => 'handler:',
		'b' => 'smart',
		'h' => 'help',
	);

	$cli_longopts = array(
		'cmd:',
		'noprefix:',
		'addprefix:',
		'scan:',
		'one-pass',
		'smart',
		'quarantine',
		'with-2check',
		'skip-cache',
		'imake',
		'icheck'
	);
	
	$cli_longopts = array_merge($cli_longopts, array_values($cli_options));

	$options = getopt(implode('', array_keys($cli_options)), $cli_longopts);

	if (isset($options['h']) OR isset($options['help']))
	{
		$memory_limit = ini_get('memory_limit');
		echo <<<HELP
AI-Bolit - Professional Malware File Scanner.

Usage: php {$_SERVER['PHP_SELF']} [OPTIONS] [PATH]
Current default path is: {$defaults['path']}

  -j, --file=FILE      		Full path to single file to check
  -l, --list=FILE      		Full path to create plain text file with a list of found malware
  -o, --json_report=FILE	Full path to create json-file with a list of found malware
  -p, --path=PATH      		Directory path to scan, by default the file directory is used
                       		Current path: {$defaults['path']}
  -m, --memory=SIZE    		Maximum amount of memory a script may consume. Current value: $memory_limit
                       		Can take shorthand byte values (1M, 1G...)
  -s, --size=SIZE      		Scan files are smaller than SIZE. 0 - All files. Current value: {$defaults['max_size_to_scan']}
  -a, --all            		Scan all files (by default scan. js,. php,. html,. htaccess)
  -d, --delay=INT      		Delay in milliseconds when scanning files to reduce load on the file system (Default: 1)
  -x, --mode=INT       		Set scan mode. 0 - for basic, 1 - for expert and 2 for paranoic.
  -k, --skip=jpg,...   		Skip specific extensions. E.g. --skip=jpg,gif,png,xls,pdf
      --scan=php,...   		Scan only specific extensions. E.g. --scan=php,htaccess,js
  -r, --report=PATH/EMAILS
  -z, --progress=FILE  		Runtime progress of scanning, saved to the file, full path required. 
  -g, --hander=FILE    		External php handler for different events, full path to php file required.
      --cmd="command [args...]"
      --smart                   Enable smart mode (skip cache files and optimize scanning)
                       		Run command after scanning
      --one-pass       		Do not calculate remaining time
      --quarantine     		Archive all malware from report
      --with-2check    		Create or use AI-BOLIT-DOUBLECHECK.php file
      --imake
      --icheck
      --idb=file	   	Integrity Check database file

      --help           		Display this help and exit

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
		(isset($options['json_report']) AND !empty($options['json_report']) AND ($file = $options['json_report']) !== false)
		OR (isset($options['o']) AND !empty($options['o']) AND ($file = $options['o']) !== false)
	)
	{
		define('JSON_FILE', $file);
	}

	if (
		(isset($options['php_report']) AND !empty($options['php_report']) AND ($file = $options['php_report']) !== false)
		OR (isset($options['t']) AND !empty($options['t']) AND ($file = $options['t']) !== false)
	)
	{
		define('PHP_FILE', $file);
	}

	if (isset($options['smart']) OR isset($options['b']))
	{
		define('SMART_SCAN', 1);
	}

	if (
		(isset($options['handler']) AND !empty($options['handler']) AND ($file = $options['handler']) !== false)
		OR (isset($options['g']) AND !empty($options['g']) AND ($file = $options['g']) !== false)
	)
	{
	        if (file_exists($file)) {
		   define('AIBOLIT_EXTERNAL_HANDLER', $file);
                }
	}

	if (
		(isset($options['progress']) AND !empty($options['progress']) AND ($file = $options['progress']) !== false)
		OR (isset($options['z']) AND !empty($options['z']) AND ($file = $options['z']) !== false)
	)
	{
		define('PROGRESS_LOG_FILE', $file);
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
		
	if (isset($options['q']) || isset($options['quite'])) 
	{
 	    $BOOL_RESULT = true;
	}

	define('BOOL_RESULT', $BOOL_RESULT);

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

	if (isset($options['n']) OR isset($options['skip-cache']))
	{
		$defaults['skip_cache'] = true;
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

    if (!defined('SMART_SCAN')) {
       define('SMART_SCAN', 1);
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
		define('NEED_REPORT', true);
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

if (defined('AIBOLIT_EXTERNAL_HANDLER')) {
   include_once(AIBOLIT_EXTERNAL_HANDLER);
   stdOut("\nLoaded external handler: " . AIBOLIT_EXTERNAL_HANDLER . "\n");
   if (function_exists("aibolit_onStart")) { aibolit_onStart(); }
}

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
		die2(stdOut("Cannot read directory '" . ROOT_PATH . "'!"));
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
function getRawJsonVuln($par_List) {
  global $g_Structure, $g_NoPrefix, $g_AddPrefix;
   $results = array();
   $l_Src = array('&quot;', '&lt;', '&gt;', '&amp;', '&#039;', '<' . '?php.');
   $l_Dst = array('"',      '<',    '>',    '&', '\'',         '<' . '?php ');

   for ($i = 0; $i < count($par_List); $i++) {
      $l_Pos = $par_List[$i]['ndx'];
      $res['fn'] = $g_AddPrefix . str_replace($g_NoPrefix, '', $g_Structure['n'][$l_Pos]);
      $res['sig'] = $par_List[$i]['id'];

      $res['ct'] = $g_Structure['c'][$l_Pos];
      $res['mt'] = $g_Structure['m'][$l_Pos];
      $res['sz'] = $g_Structure['s'][$l_Pos];
      $res['sigid'] = 'vuln_' . md5($g_Structure['n'][$l_Pos] . $par_List[$i]['id']);

      $results[] = $res; 
   }

   return $results;
}

///////////////////////////////////////////////////////////////////////////
function getRawJson($par_List, $par_Details = null, $par_SigId = null) {
  global $g_Structure, $g_NoPrefix, $g_AddPrefix;
   $results = array();
   $l_Src = array('&quot;', '&lt;', '&gt;', '&amp;', '&#039;', '<' . '?php.');
   $l_Dst = array('"',      '<',    '>',    '&', '\'',         '<' . '?php ');

   for ($i = 0; $i < count($par_List); $i++) {
       if ($par_SigId != null) {
          $l_SigId = 'id_' . $par_SigId[$i];
       } else {
          $l_SigId = 'id_n' . rand(1000000, 9000000);
       }
       


      $l_Pos = $par_List[$i];
      $res['fn'] = $g_AddPrefix . str_replace($g_NoPrefix, '', $g_Structure['n'][$l_Pos]);
      if ($par_Details != null) {
         $res['sig'] = preg_replace('|(L\d+).+__AI_MARKER__|smi', '[$1]: ...', $par_Details[$i]);
         $res['sig'] = preg_replace('/[^\x20-\x7F]/', '.', $res['sig']);
         $res['sig'] = preg_replace('/__AI_LINE1__(\d+)__AI_LINE2__/', '[$1] ', $res['sig']);
         $res['sig'] = preg_replace('/__AI_MARKER__/', ' @!!!>', $res['sig']);
         $res['sig'] = str_replace($l_Src, $l_Dst, $res['sig']);
      }

      $res['ct'] = $g_Structure['c'][$l_Pos];
      $res['mt'] = $g_Structure['m'][$l_Pos];
      $res['sz'] = $g_Structure['s'][$l_Pos];
      $res['sigid'] = $l_SigId;

      $results[] = $res; 
   }

   return $results;
}

///////////////////////////////////////////////////////////////////////////
function printList($par_List, $par_Details = null, $par_NeedIgnore = false, $par_SigId = null, $par_TableName = null) {
  global $g_Structure, $g_NoPrefix, $g_AddPrefix;
  
  $i = 0;

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
     $l_Result .= '<td class="hidd"><div class="hidd">' . 'x' . '</div></td>';
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
  
  $l_Result = "";

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
        $l_Body = preg_replace('/[^\x20-\x7F]/', '.', $l_Body);
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
						$g_SuspiciousFiles, $g_ShortListExt, $l_SkipSample;

	static $l_Buffer = '';

	$l_DirCounter = 0;
	$l_DoorwayFilesCounter = 0;
	$l_SourceDirIndex = $g_Counter - 1;

        $l_SkipSample = array();

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

      			// if folder in ignore list
      			$l_Skip = false;
      			for ($dr = 0; $dr < count($g_DirIgnoreList); $dr++) {
      				if (($g_DirIgnoreList[$dr] != '') &&
      				   preg_match('#' . $g_DirIgnoreList[$dr] . '#', $l_FileName, $l_Found)) {
      				   if (!in_array($g_DirIgnoreList[$dr], $l_SkipSample)) {
                                      $l_SkipSample[] = $g_DirIgnoreList[$dr];
                                   } else {
        		             $l_Skip = true;
                                     $l_NeedToScan = false;
                                   }
      				}
      			}


			if ($l_IsDir)
			{
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
				file_put_contents(QUEUE_FILENAME, $l_Buffer, FILE_APPEND) or die2("Cannot write to file ".QUEUE_FILENAME);
				$l_Buffer = '';
			}

		}

		closedir($l_DIRH);
	}
	
	if (($l_RootDir == ROOT_PATH) && !empty($l_Buffer)) {
		file_put_contents(QUEUE_FILENAME, $l_Buffer, FILE_APPEND) or die2("Cannot write to file " . QUEUE_FILENAME);
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
           '__AI_MARKER__' . substr($par_Content, $par_Pos, $l_RightPos - $par_Pos - 1);

  $l_Res = makeSafeFn(UnwrapObfu($l_Res));
  $l_Res = str_replace('~', '·', $l_Res);
  $l_Res = preg_replace('/\s+/smi', ' ', $l_Res);
  $l_Res = str_replace('' . '?php', '' . '?php ', $l_Res);

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
  $par_Content = preg_replace('~(\(\s*)+~', '(', $par_Content);
  $par_Content = preg_replace('~\s+~', ' ', $par_Content);
  $par_Content = str_replace($search, $replace, $par_Content);
  $par_Content = preg_replace_callback('~\bchr\(\s*([0-9a-fA-FxX]+)\s*\)~', function ($m) { return "'".chr(intval($m[1], 0))."'"; }, $par_Content );

  $par_Content = preg_replace_callback('/\\\\x([a-fA-F0-9]{1,2})/i','escapedHexToHex', $par_Content);
  $par_Content = preg_replace_callback('/\\\\([0-9]{1,3})/i','escapedOctDec', $par_Content);

  $par_Content = preg_replace('/[\'"]\s*?\.+\s*?[\'"]/smi', '', $par_Content);
  $par_Content = preg_replace('/[\'"]\s*?\++\s*?[\'"]/smi', '', $par_Content);

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

	if (strpos($par_Filename, '/bx_1c_import.php') !== false) {	
		if (strpos($par_Content, '$_GET[\'action\']=="getfiles"') !== false) {
   		   $l_Vuln['id'] = 'AFD : https://habrahabr.ru/company/dsec/blog/326166/';
   		   $l_Vuln['ndx'] = $par_Index;
   		   $g_Vulnerable[] = $l_Vuln;
   		
   		   return true;
                }
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

	if (strpos($par_Filename, 'wp-content/plugins/wp-mobile-detector/resize.php') !== false) {		
		if (strpos($par_Content, 'file_put_contents($path, file_get_contents($_REQUEST[\'src\']));') !== false) {
			$l_Vuln['id'] = 'AFU : https://www.pluginvulnerabilities.com/2016/05/31/aribitrary-file-upload-vulnerability-in-wp-mobile-detector/';
			$l_Vuln['ndx'] = $par_Index;
			$g_Vulnerable[] = $l_Vuln;
			return true;
		}
		
		return false;
	}

	if (strpos($par_Filename, 'phpmailer.php') !== false) {		
		if (strpos($par_Content, 'PHPMailer') !== false) {
                        $l_Found = preg_match('~Version:\s*(\d+)\.(\d+)\.(\d+)~', $par_Content, $l_Match);

                        if ($l_Found) {
                           $l_Version = $l_Match[1] * 1000 + $l_Match[2] * 100 + $l_Match[3];

                           if ($l_Version < 2520) {
                              $l_Found = false;
                           }
                        }

                        if (!$l_Found) {

                           $l_Found = preg_match('~Version\s*=\s*\'(\d+)\.*(\d+)\.(\d+)~', $par_Content, $l_Match);
                           if ($l_Found) {
                              $l_Version = $l_Match[1] * 1000 + $l_Match[2] * 100 + $l_Match[3];
                              if ($l_Version < 5220) {
                                 $l_Found = false;
                              }
                           }
			}


		        if (!$l_Found) {
	   		   $l_Vuln['id'] = 'RCE : CVE-2016-10045, CVE-2016-10031';
			   $l_Vuln['ndx'] = $par_Index;
			   $g_Vulnerable[] = $l_Vuln;
			   return true;
                        }
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
           $g_Base64Fragment, $g_UnixExec, $g_PhishingSigFragment, $g_PhishingFragment, $g_PhishingSig, $g_CriticalJSSig, $g_IframerFragment, $g_CMS, $defaults, $g_AdwareListFragment, 
           $g_KnownList,$g_Vulnerable, $g_CriticalFiles, $g_DeMapper;

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

                                if (function_exists('aibolit_onBigFile')) { aibolit_onBigFile($l_Filename); }

				AddResult($l_Filename, $i);

		                $l_Ext = strtolower(pathinfo($l_Filename, PATHINFO_EXTENSION));
                                if ((!AI_HOSTER) && in_array($l_Ext, $g_CriticalFiles)) {
				    $g_CriticalPHP[] = $i;
				    $g_CriticalPHPFragment[] = "BIG FILE. SKIPPED.";
				    $g_CriticalPHPSig[] = "big_1";
                                }
			}
			else
			{
				$g_TotalFiles++;

			$l_TSStartScan = microtime(true);

		$l_Ext = strtolower(pathinfo($l_Filename, PATHINFO_EXTENSION));
		if (filetype($l_Filename) == 'file') {
                   $l_Content = @file_get_contents($l_Filename);
		   if (SHORT_PHP_TAG) {
//                      $l_Content = preg_replace('|<\?\s|smiS', '<?php ', $l_Content); 
                   }

                   $l_Unwrapped = @php_strip_whitespace($l_Filename);
                }

		
                if ((($l_Content == '') || ($l_Unwrapped == '')) && ($l_Stat['size'] > 0)) {
                   $g_NotRead[] = $i;
                   if (function_exists('aibolit_onReadError')) { aibolit_onReadError($l_Filename, 'io'); }
                   AddResult('[io] ' . $l_Filename, $i);
                   return;
                }

				// ignore itself
				if (strpos($l_Content, '264215fae8356a91afdd3514567f7f50') !== false) {
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
                                      if (function_exists('aibolit_onReadError')) { aibolit_onReadError($l_Filename, 'ec'); }
                                      AddResult('[ec] ' . $l_Filename, $i);
				   }
                                }

				// critical
				$g_SkipNextCheck = false;

                                $l_DeobfType = '';
				if (!AI_HOSTER) {
                                   $l_DeobfType = getObfuscateType($l_Unwrapped);
                                }

                                if ($l_DeobfType != '') {
                                   $l_Unwrapped = deobfuscate($l_Unwrapped);
				   $g_SkipNextCheck = checkFalsePositives($l_Filename, $l_Unwrapped, $l_DeobfType);
                                } else {
     				   if (DEBUG_MODE) {
				      stdOut("\n...... NOT OBFUSCATED\n");
				   }
				}

				$l_Unwrapped = UnwrapObfu($l_Unwrapped);
				
				if ((!$g_SkipNextCheck) && CriticalPHP($l_Filename, $i, $l_Unwrapped, $l_Pos, $l_SigId))
				{
				        if ($l_Ext == 'js') {
 					   $g_CriticalJS[] = $i;
 					   $g_CriticalJSFragment[] = getFragment($l_Unwrapped, $l_Pos);
 					   $g_CriticalJSSig[] = $l_SigId;
                                        } else {
       					   $g_CriticalPHP[] = $i;
       					   $g_CriticalPHPFragment[] = getFragment($l_Unwrapped, $l_Pos);
      					   $g_CriticalPHPSig[] = $l_SigId;
                                        }

					$g_SkipNextCheck = true;
				} else {
         				if ((!$g_SkipNextCheck) && CriticalPHP($l_Filename, $i, $l_Content, $l_Pos, $l_SigId))
         				{
					        if ($l_Ext == 'js') {
         					   $g_CriticalJS[] = $i;
         					   $g_CriticalJSFragment[] = getFragment($l_Content, $l_Pos);
         					   $g_CriticalJSSig[] = $l_SigId;
                                                } else {
               					   $g_CriticalPHP[] = $i;
               					   $g_CriticalPHPFragment[] = getFragment($l_Content, $l_Pos);
      						   $g_CriticalPHPSig[] = $l_SigId;
                                                }

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
					        if ($l_Ext == 'js') {
         					   $g_CriticalJS[] = $i;
         					   $g_CriticalJSFragment[] = getFragment($l_Unwrapped, $l_Pos);
         					   $g_CriticalJSSig[] = $l_SigId;
                                                } else {
               					   $g_CriticalPHP[] = $i;
               					   $g_CriticalPHPFragment[] = getFragment($l_Unwrapped, $l_Pos);
      						   $g_CriticalPHPSig[] = $l_SigId;
                                                }

						$g_SkipNextCheck = true;
					}
			    }

				// phishing
				if (!$g_SkipNextCheck) {
					$l_Pos = Phishing($l_Filename, $i, $l_Unwrapped, $l_SigId);
					if ($l_Pos === false) {
                                            $l_Pos = Phishing($l_Filename, $i, $l_Content, $l_SigId);
                                        }

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
    	if (preg_match('#' . $l_Item . '#smiS', $l_Content, $l_Found, PREG_OFFSET_CAPTURE)) {
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
      		if (preg_match('#' . $l_Item . '#smiS', $l_Content, $l_Found, PREG_OFFSET_CAPTURE)) {
             	$l_Pos = $l_Found[0][1];
           	    //$l_SigId = myCheckSum($l_Item);
           	    $l_SigId = getSigId($l_Found);
        	    return true;
	  		}
    	}

	}

    if (AI_EXPERT < 1) {
    	foreach ($gX_FlexDBShe as $l_Item) {
      		if (preg_match('#' . $l_Item . '#smiS', $l_Content, $l_Found, PREG_OFFSET_CAPTURE)) {
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
    while (preg_match('#' . $l_Item . '#smi', $l_Content, $l_Found, PREG_OFFSET_CAPTURE, $offset)) {
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
      if (@preg_match('#' . $l_ExceptItem . '#smi', $l_FoundStrPlus, $l_Detected)) {
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
    while (preg_match('#' . $l_Item . '#smi', $l_Content, $l_Found, PREG_OFFSET_CAPTURE, $offset)) {
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
    while (preg_match('#' . $l_Item . '#smi', $l_Content, $l_Found, PREG_OFFSET_CAPTURE, $offset)) {
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
    if (preg_match('#' . $l_Item . '#smi', $l_Content, $l_Found, PREG_OFFSET_CAPTURE)) {
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
         if (function_exists('aibolit_onReadError')) { aibolit_onReadError($l_Filename, 're'); }
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

  // 264215fae8356a91afdd3514567f7f50 H24LKHGHCGHFHGKJHGKJHGGGHJ

  // need check file (by extension) ?
  $l_SkipCheck = SMART_SCAN;

  if ($l_SkipCheck) {
	  foreach($g_CriticalFiles as $l_Ext) {
  	  	if ((strpos($l_FN, $l_Ext) !== false) && (strpos($l_FN, '.js') === false)) {
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

  foreach ($g_FlexDBShe as $l_Item) {
    $offset = 0;
    while (preg_match('#' . $l_Item . '#smiS', $l_Content, $l_Found, PREG_OFFSET_CAPTURE, $offset)) {
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

if (AI_EXPERT > 0) {
  foreach ($gX_FlexDBShe as $l_Item) {
    if (preg_match('#' . $l_Item . '#smiS', $l_Content, $l_Found, PREG_OFFSET_CAPTURE)) {
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

if (AI_EXPERT > 1) {
  foreach ($gXX_FlexDBShe as $l_Item) {
    if (preg_match('#' . $l_Item . '#smiS', $l_Content, $l_Found, PREG_OFFSET_CAPTURE)) {
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

if (AI_HOSTER) return false;

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
			die2("\nCannot write report. Report dir " . REPORT_PATH . " is not writable.");
		}

		else if (!REPORT_FILE)
		{
			die2("\nCannot write report. Report filename is empty.");
		}

		else if (($file = REPORT_PATH . DIR_SEPARATOR . REPORT_FILE) AND is_file($file) AND !is_writable($file))
		{
			die2("\nCannot write report. Report file '$file' exists but is not writable.");
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


$g_DirIgnoreList = array();
$g_IgnoreList = array();
$g_UrlIgnoreList = array();
$g_KnownList = array();

$l_IgnoreFilename = $g_AiBolitAbsolutePath . '/.aignore';
$l_DirIgnoreFilename = $g_AiBolitAbsolutePath . '/.adirignore';
$l_UrlIgnoreFilename = $g_AiBolitAbsolutePath . '/.aurlignore';

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


$l_SkipMask = array(
            '/template_\w{32}.css',
            '/cache/templates/.{1,150}\.tpl\.php',
	    '/system/cache/templates_c/\w{1,40}\.php',
	    '/assets/cache/rss/\w{1,60}',
            '/cache/minify/minify_\w{32}',
            '/cache/page/\w{32}\.php',
            '/cache/object/\w{1,10}/\w{1,10}/\w{1,10}/\w{32}\.php',
            '/cache/wp-cache-\d{32}\.php',
            '/cache/page/\w{32}\.php_expire',
	    '/cache/page/\w{32}-cache-page-\w{32}\.php',
	    '\w{32}-cache-com_content-\w{32}\.php',
	    '\w{32}-cache-mod_custom-\w{32}\.php',
	    '\w{32}-cache-mod_templates-\w{32}\.php',
            '\w{32}-cache-_system-\w{32}\.php',
            '/cache/twig/\w{1,32}/\d+/\w{1,100}\.php', 
            '/autoptimize/js/autoptimize_\w{32}\.js',
            '/bitrix/cache/\w{32}\.php',
            '/bitrix/cache/.+/\w{32}\.php',
            '/bitrix/cache/iblock_find/',
            '/bitrix/managed_cache/MYSQL/user_option/[^/]+/',
            '/bitrix/cache/s1/bitrix/catalog\.section/',
            '/bitrix/cache/s1/bitrix/catalog\.element/',
            '/bitrix/cache/s1/bitrix/menu/',
            '/catalog.element/[^/]+/[^/]+/\w{32}\.php',
            '/bitrix/managed\_cache/.*/\.\w{32}\.php',
            '/core/cache/mgr/smarty/default/.{1,100}\.tpl\.php',
            '/core/cache/resource/web/resources/[0-9]{1,50}\.cache\.php',
            '/smarty/compiled/SC/.*/%%.*\.php',
            '/smarty/.{1,150}\.tpl\.php',
            '/smarty/compile/.{1,150}\.tpl\.cache\.php',
            '/files/templates_c/.{1,150}\.html\.php',
            '/uploads/javascript_global/.{1,150}\.js',
            '/assets/cache/rss/\w{32}',
	    '/assets/cache/docid_\d+_\w{32}\.pageCache\.php',
            '/t3-assets/dev/t3/.*-cache-\w{1,20}-.{1,150}\.php',
	    '/t3-assets/js/js-\w{1,30}\.js',
            '/temp/cache/SC/.*/\.cache\..*\.php',
            '/tmp/sess\_\w{32}$',
            '/assets/cache/docid\_.*\.pageCache\.php',
            '/stat/usage\_\w+\.html',
            '/stat/site\_\w+\.html',
            '/gallery/item/list/\w+\.cache\.php',
            '/core/cache/registry/.*/ext-.*\.php',
            '/core/cache/resource/shk\_/\w+\.cache\.php',
            '/webstat/awstats.*\.txt',
            '/awstats/awstats.*\.txt',
            '/awstats/.{1,80}\.pl',
            '/awstats/.{1,80}\.html',
            '/inc/min/styles_\w+\.min\.css',
            '/inc/min/styles_\w+\.min\.js',
            '/logs/error\_log\..*',
            '/logs/xferlog\..*',
            '/logs/access_log\..*',
            '/logs/cron\..*',
            '/logs/exceptions/.+\.log$',
            '/hyper-cache/[^/]+/[^/]+/[^/]+/index\.html',
            '/mail/new/[^,]+,S=[^,]+,W=.+',
            '/mail/new/[^,]=,S=.+',
            '/application/logs/\d+/\d+/\d+\.php',
            '/sites/default/files/js/js_\w{32}\.js',
            '/yt-assets/\w{32}\.css',
);

$l_SkipSample = array();

if (SMART_SCAN) {
   $g_DirIgnoreList = array_merge($g_DirIgnoreList, $l_SkipMask);
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
      if (defined('PROGRESS_LOG_FILE') && file_exists(PROGRESS_LOG_FILE)) @unlink(PROGRESS_LOG_FILE);
   }
}

QCR_Debug();

if (true) {
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
if (AI_HOSTER) {
   $g_IframerFragment = array();
   $g_Iframer = array();
   $g_Redirect = array();
   $g_Doorway = array();
   $g_EmptyLink = array();
   $g_HeuristicType = array();
   $g_HeuristicDetected = array();
   $g_WarningPHP = array();
   $g_AdwareList = array();
   $g_Phishing = array(); 
   $g_PHPCodeInside = array();
   $g_PHPCodeInsideFragment = array();
   $g_NotRead = array();
   $g_WarningPHPFragment = array();
   $g_WarningPHPSig = array();
   $g_BigFiles = array();
   $g_RedirectPHPFragment = array();
   $g_EmptyLinkSrc = array();
   $g_Base64Fragment = array();
   $g_UnixExec = array();
   $g_PhishingSigFragment = array();
   $g_PhishingFragment = array();
   $g_PhishingSig = array();
   $g_IframerFragment = array();
   $g_CMS = array();
   $g_AdwareListFragment = array(); 
   $g_Vulnerable = array();
}

 if (BOOL_RESULT && (!defined('NEED_REPORT'))) {
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

stdOut("\nLoaded signatures: " . count($g_FlexDBShe) . " / " . count($g_JSVirSig) . "\n");

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

 $l_Summary .= "</table>";

$l_ArraySummary = array();
$l_ArraySummary["redirect"] = count($g_Redirect);
$l_ArraySummary["critical_php"] = count($g_CriticalPHP);
$l_ArraySummary["critical_js"] = count($g_CriticalJS);
$l_ArraySummary["phishing"] = count($g_Phishing);
$l_ArraySummary["unix_exec"] = count($g_UnixExec);
$l_ArraySummary["iframes"] = count($g_Iframer);
$l_ArraySummary["not_read"] = count($g_NotRead);
$l_ArraySummary["base64"] = count($g_Base64);
$l_ArraySummary["heuristics"] = count($g_HeuristicDetected);
$l_ArraySummary["symlinks"] = count($g_SymLinks);
$l_ArraySummary["big_files_skipped"] = count($g_BigFiles);

 if (function_exists('json_encode')) { $l_Summary .= "<!--[json]" . json_encode($l_ArraySummary) . "[/json]-->"; }

 $l_Summary .= "<div class=details style=\"margin: 20px 20px 20px 0\">" . AI_STR_080 . "</div>\n";

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

$l_RawReport = array();

if (!AI_HOSTER) {
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
}


stdOut("Building list of shells " . count($g_CriticalPHP));

$l_RawReport['vulners'] = getRawJsonVuln($g_Vulnerable);

if (count($g_CriticalPHP) > 0) {
  $g_CriticalPHP = array_slice($g_CriticalPHP, 0, 15000);
  $l_RawReport['php_malware'] = getRawJson($g_CriticalPHP, $g_CriticalPHPFragment, $g_CriticalPHPSig);
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
  $g_CriticalJS = array_slice($g_CriticalJS, 0, 15000);
  $l_RawReport['js_malware'] = getRawJson($g_CriticalJS, $g_CriticalJSFragment, $g_CriticalJSSig);
  $l_Result .= '<div class="note_vir">' . AI_STR_018 . ' (' . count($g_CriticalJS) . ')</div><div class="crit">';
  $l_Result .= printList($g_CriticalJS, $g_CriticalJSFragment, true, $g_CriticalJSSig, 'table_vir');
  $l_PlainResult .= '[CLIENT MALWARE / JS]'  . "\n" . printPlainList($g_CriticalJS, $g_CriticalJSFragment, true, $g_CriticalJSSig, 'table_vir') . "\n";
  $l_Result .= "</div>" . PHP_EOL;

  $l_ShowOffer = true;
}

if (!AI_HOSTER) {
   stdOut("Building phishing pages " . count($g_Phishing));

   if (count($g_Phishing) > 0) {
     $l_RawReport['phishing'] = getRawJson($g_Phishing, $g_PhishingFragment, $g_PhishingSigFragment);
     $l_Result .= '<div class="note_vir">' . AI_STR_058 . ' (' . count($g_Phishing) . ')</div><div class="crit">';
     $l_Result .= printList($g_Phishing, $g_PhishingFragment, true, $g_PhishingSigFragment, 'table_vir');
     $l_PlainResult .= '[PHISHING]'  . "\n" . printPlainList($g_Phishing, $g_PhishingFragment, true, $g_PhishingSigFragment, 'table_vir') . "\n";
     $l_Result .= "</div>". PHP_EOL;

     $l_ShowOffer = true;
   }

   stdOut("Building list of iframes " . count($g_Iframer));

   if (count($g_Iframer) > 0) {
     $l_RawReport['iframer'] = getRawJson($g_Iframer, $g_IframerFragment);
     $l_ShowOffer = true;
     $l_Result .= '<div class="note_vir">' . AI_STR_021 . ' (' . count($g_Iframer) . ')</div><div class="crit">';
     $l_Result .= printList($g_Iframer, $g_IframerFragment, true);
     $l_Result .= "</div>" . PHP_EOL;

   }

   stdOut("Building list of base64s " . count($g_Base64));

   if (count($g_Base64) > 0) {
     $l_RawReport['warn_enc'] = getRawJson($g_Base64, $g_Base64Fragment);
     if (AI_EXPERT > 1) $l_ShowOffer = true;
     
     $l_Result .= '<div class="note_' . (AI_EXPERT > 1 ? 'vir' : 'warn') . '">' . AI_STR_020 . ' (' . count($g_Base64) . ')</div><div class="' . (AI_EXPERT > 1 ? 'crit' : 'warn') . '">';
     $l_Result .= printList($g_Base64, $g_Base64Fragment, true);
     $l_PlainResult .= '[ENCODED / SUSP_EXT]' . "\n" . printPlainList($g_Base64, $g_Base64Fragment, true) . "\n";
     $l_Result .= "</div>" . PHP_EOL;

   }

   stdOut("Building list of redirects " . count($g_Redirect));
   if (count($g_Redirect) > 0) {
     $l_RawReport['redirect'] = getRawJson($g_Redirect, $g_RedirectPHPFragment);
     $l_ShowOffer = true;
     $l_Result .= '<div class="note_vir">' . AI_STR_027 . ' (' . count($g_Redirect) . ')</div><div class="crit">';
     $l_Result .= printList($g_Redirect, $g_RedirectPHPFragment, true);
     $l_Result .= "</div>" . PHP_EOL;
   }


   stdOut("Building list of unread files " . count($g_NotRead));

   if (count($g_NotRead) > 0) {
     $g_NotRead = array_slice($g_NotRead, 0, AIBOLIT_MAX_NUMBER);
     $l_RawReport['not_read'] = $g_NotRead;
     $l_Result .= '<div class="note_vir">' . AI_STR_030 . ' (' . count($g_NotRead) . ')</div><div class="crit">';
     $l_Result .= printList($g_NotRead);
     $l_Result .= "</div><div class=\"spacer\"></div>" . PHP_EOL;
     $l_PlainResult .= '[SCAN ERROR / SKIPPED]' . "\n" . printPlainList($g_NotRead) . "\n\n";
   }

   stdOut("Building list of symlinks " . count($g_SymLinks));

   if (count($g_SymLinks) > 0) {
     $g_SymLinks = array_slice($g_SymLinks, 0, AIBOLIT_MAX_NUMBER);
     $l_RawReport['sym_links'] = $g_SymLinks;
     $l_Result .= '<div class="note_vir">' . AI_STR_022 . ' (' . count($g_SymLinks) . ')</div><div class="crit">';
     $l_Result .= nl2br(makeSafeFn(implode("\n", $g_SymLinks), true));
     $l_Result .= "</div><div class=\"spacer\"></div>";
   }

   stdOut("Building list of unix executables and odd scripts " . count($g_UnixExec));

   if (count($g_UnixExec) > 0) {
     $g_UnixExec = array_slice($g_UnixExec, 0, AIBOLIT_MAX_NUMBER);
     $l_RawReport['unix_exec'] = $g_UnixExec;
     $l_Result .= '<div class="note_' . (AI_EXPERT > 1 ? 'vir' : 'warn') . '">' . AI_STR_019 . ' (' . count($g_UnixExec) . ')</div><div class="' . (AI_EXPERT > 1 ? 'crit' : 'warn') . '">';
     $l_Result .= nl2br(makeSafeFn(implode("\n", $g_UnixExec), true));
     $l_PlainResult .= '[UNIX EXEC]' . "\n" . implode("\n", replacePathArray($g_UnixExec)) . "\n\n";
     $l_Result .= "</div>" . PHP_EOL;

     if (AI_EXPERT > 1) $l_ShowOffer = true;
   }
}
////////////////////////////////////
if (!AI_HOSTER) {
   $l_WarningsNum = count($g_HeuristicDetected) + count($g_HiddenFiles) + count($g_BigFiles) + count($g_PHPCodeInside) + count($g_AdwareList) + count($g_EmptyLink) + count($g_Doorway) + (count($g_WarningPHP[0]) + count($g_WarningPHP[1]) + count($g_SkippedFolders));

   if ($l_WarningsNum > 0) {
   	$l_Result .= "<div style=\"margin-top: 20px\" class=\"title\">" . AI_STR_026 . "</div>";
   }

   stdOut("Building list of links/adware " . count($g_AdwareList));

   if (count($g_AdwareList) > 0) {
     $l_RawReport['adware'] = getRawJson($g_AdwareList, $g_AdwareListFragment);
     $l_Result .= '<div class="note_warn">' . AI_STR_029 . '</div><div class="warn">';
     $l_Result .= printList($g_AdwareList, $g_AdwareListFragment, true);
     $l_PlainResult .= '[ADWARE]' . "\n" . printPlainList($g_AdwareList, $g_AdwareListFragment, true) . "\n";
     $l_Result .= "</div>" . PHP_EOL;

   }

   stdOut("Building list of heuristics " . count($g_HeuristicDetected));

   if (count($g_HeuristicDetected) > 0) {
     $l_RawReport['heuristic'] = $g_HeuristicDetected;
     $l_Result .= '<div class="note_warn">' . AI_STR_052 . ' (' . count($g_HeuristicDetected) . ')</div><div class="warn">';
     for ($i = 0; $i < count($g_HeuristicDetected); $i++) {
   	   $l_Result .= '<li>' . makeSafeFn($g_Structure['n'][$g_HeuristicDetected[$i]], true) . ' (' . get_descr_heur($g_HeuristicType[$i]) . ')</li>';
     }
     
     $l_Result .= '</ul></div><div class=\"spacer\"></div>' . PHP_EOL;
   }

   stdOut("Building list of hidden files " . count($g_HiddenFiles));
   if (count($g_HiddenFiles) > 0) {
     $g_HiddenFiles = array_slice($g_HiddenFiles, 0, AIBOLIT_MAX_NUMBER);
     $l_RawReport['hidden'] = $g_HiddenFiles;
     $l_Result .= '<div class="note_warn">' . AI_STR_023 . ' (' . count($g_HiddenFiles) . ')</div><div class="warn">';
     $l_Result .= nl2br(makeSafeFn(implode("\n", $g_HiddenFiles), true));
     $l_Result .= "</div><div class=\"spacer\"></div>" . PHP_EOL;
     $l_PlainResult .= '[HIDDEN]' . "\n" . implode("\n", replacePathArray($g_HiddenFiles)) . "\n\n";
   }

   stdOut("Building list of bigfiles " . count($g_BigFiles));
   $max_size_to_scan = getBytes(MAX_SIZE_TO_SCAN);
   $max_size_to_scan = $max_size_to_scan > 0 ? $max_size_to_scan : getBytes('1m');

   if (count($g_BigFiles) > 0) {
     $g_BigFiles = array_slice($g_BigFiles, 0, AIBOLIT_MAX_NUMBER);
     $l_RawReport['big_files'] = getRawJson($g_BigFiles);
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
     $g_EmptyLink = array_slice($g_EmptyLink, 0, AIBOLIT_MAX_NUMBER);
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
     $g_Doorway = array_slice($g_Doorway, 0, AIBOLIT_MAX_NUMBER);
     $l_RawReport['doorway'] = getRawJson($g_Doorway);
     $l_Result .= '<div class="note_warn">' . AI_STR_034 . '</div><div class="warn">';
     $l_Result .= printList($g_Doorway);
     $l_Result .= "</div>" . PHP_EOL;

   }

   stdOut("Building list of php warnings " . (count($g_WarningPHP[0]) + count($g_WarningPHP[1])));

   if (($defaults['report_mask'] & REPORT_MASK_SUSP) == REPORT_MASK_SUSP) {
      if ((count($g_WarningPHP[0]) + count($g_WarningPHP[1])) > 0) {
        $g_WarningPHP[0] = array_slice($g_WarningPHP[0], 0, AIBOLIT_MAX_NUMBER);
        $g_WarningPHP[1] = array_slice($g_WarningPHP[1], 0, AIBOLIT_MAX_NUMBER);
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
         $l_RawReport['cms'] = $g_CMS;
         $l_Result .= "<div class=\"note_warn\">" . AI_STR_037 . "<br/>";
         $l_Result .= nl2br(makeSafeFn(implode("\n", $g_CMS)));
         $l_Result .= "</div>";
    }
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

$l_Template = str_replace('@@OFFER2@@', $l_Offer2, $l_Template);

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
	die2('Report not written.');
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

// write json result
if (defined('JSON_FILE')) {	
   if ($l_FH = fopen(JSON_FILE, "w")) {
      fputs($l_FH, json_encode($l_RawReport));
      fclose($l_FH);
   }
}

// write serialized result
if (defined('PHP_FILE')) {	
   if ($l_FH = fopen(PHP_FILE, "w")) {
      fputs($l_FH, serialize($l_RawReport));
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
$code = 0;

if ($l_EC1 > 0) {
	$code = 2;
} else {
	if ($l_EC2 > 0) {
		$code = 1;
	}
}

$stat = array('php_malware' => count($g_CriticalPHP), 'js_malware' => count($g_CriticalJS), 'phishing' => count($g_Phishing));

if (function_exists('aibolit_onComplete')) { aibolit_onComplete($code, $stat); }

stdOut('Exit code ' . $code);
exit($code);

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
                        $g_UnsafeFilesFound, $g_SymLinks, $g_HiddenFiles, $g_UnixExec, $g_IgnoredExt, $g_SuspiciousFiles, $l_SkipSample;
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

      			// if folder in ignore list
      			$l_Skip = false;
      			for ($dr = 0; $dr < count($g_DirIgnoreList); $dr++) {
      				if (($g_DirIgnoreList[$dr] != '') &&
      				   preg_match('#' . $g_DirIgnoreList[$dr] . '#', $l_FileName, $l_Found)) {
      				   if (!in_array($g_DirIgnoreList[$dr], $l_SkipSample)) {
                                      $l_SkipSample[] = $g_DirIgnoreList[$dr];
                                   } else {
        		             $l_Skip = true;
                                     $l_NeedToScan = false;
                                   }
      				}
      			}
      					
			if (getRelativePath($l_FileName) == "./" . INTEGRITY_DB_FILE) $l_NeedToScan = false;

			if ($l_IsDir)
			{
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
				file_put_contents(QUEUE_FILENAME, $l_Buffer, FILE_APPEND) or die2("Cannot write to file " . QUEUE_FILENAME);
				$l_Buffer = '';
			}

		}

		closedir($l_DIRH);
	}
	
	if (($l_RootDir == ROOT_PATH) && !empty($l_Buffer)) {
		file_put_contents(QUEUE_FILENAME, $l_Buffer, FILE_APPEND) or die2("Cannot write to file ".QUEUE_FILENAME);
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
		empty($l_Buffer) or file_put_contents('compress.zlib://' . INTEGRITY_DB_FILE, $l_Buffer, FILE_APPEND) or die2("Cannot write to file " . INTEGRITY_DB_FILE);
		$l_Buffer = '';
		return;
	}

	$l_RelativePath = getRelativePath($l_FileName);
		
	$hash = is_file($l_FileName) ? hash_file('sha1', $l_FileName) : '';

	$l_Buffer .= "$l_RelativePath|$hash\n";
	
	if (strlen($l_Buffer) > 32000)
	{
		file_put_contents('compress.zlib://' . INTEGRITY_DB_FILE, $l_Buffer, FILE_APPEND) or die2("Cannot write to file " . INTEGRITY_DB_FILE);
		$l_Buffer = '';
	}
}

function load_integrity_db() {
	global $g_IntegrityDB;
	file_exists(INTEGRITY_DB_FILE) or die2('Not found ' . INTEGRITY_DB_FILE);

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
		if (!preg_match('#^(?>(?!\.[*+]|\\\\\d)(?:\\\\.|\[.+?\]|.))+$#', $s)) {
			unset($sigs[$i]);
			$tmp[] = $s;
		}
	}
	
	usort($sigs, 'strcasecmp');
	$txt = implode("\n", $sigs);

	for ($i = 24; $i >= 1; ($i > 4 ) ? $i -= 4 : --$i) {
	    $txt = preg_replace_callback('#^((?>(?:\\\\.|\\[.+?\\]|[^(\n]|\((?:\\\\.|[^)(\n])++\))(?:[*?+]\+?|\{\d+(?:,\d*)?\}[+?]?|)){' . $i . ',})[^\n]*+(?:\\n\\1(?![{?*+]).+)+#im', 'optMergePrefixes', $txt);
	}

	$sigs = array_merge(explode("\n", $txt), $tmp);
	
	optSigCheck($sigs);
}

function optMergePrefixes($m)
{
	$limit = 8000;
	
	$prefix = $m[1];
	$prefix_len = strlen($prefix);

	$len = $prefix_len;
	$r = array();

	$suffixes = array();
	foreach (explode("\n", $m[0]) as $line) {
	
	  if (strlen($line)>$limit) {
	    $r[] = $line;
	    continue;
	  }
	
	  $s = substr($line, $prefix_len);
	  $len += strlen($s);
	  if ($len > $limit) {
	    if (count($suffixes) == 1) {
	      $r[] = $prefix . $suffixes[0];
	    } else {
	      $r[] = $prefix . '(?:' . implode('|', $suffixes) . ')';
	    }
	    $suffixes = array();
	    $len = $prefix_len + strlen($s);
	  }
	  $suffixes[] = $s;
	}

	if (!empty($suffixes)) {
	  if (count($suffixes) == 1) {
	    $r[] = $prefix . $suffixes[0];
	  } else {
	    $r[] = $prefix . '(?:' . implode('|', $suffixes) . ')';
	  }
	}
	
	return implode("\n", $r);
}

function optMergePrefixes_Old($m)
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
                if (trim($sig) == "") {
                   if (DEBUG_MODE) {
                      echo("************>>>>> EMPTY\n     pattern: " . $sig . "\n");
                   }
	           unset($sigs[$k]);
		   $result = false;
                }

		if (@preg_match('#' . $sig . '#smiS', '') === false) {
			$error = error_get_last();
                        if (DEBUG_MODE) {
			   echo("************>>>>> " . $error['message'] . "\n     pattern: " . $sig . "\n");
                        }
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

	$snum = max(0, @filesize($file) - 1024) / 20;
	stdOut("\nLoaded " . ceil($snum) . " known files\n");
	
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

function die2($str) {
  if (function_exists('aibolit_onFatalError')) { aibolit_onFatalError($str); }
  die($str);
}

function checkFalsePositives($l_Filename, $l_Unwrapped, $l_DeobfType) {
  global $g_DeMapper;

  if ($l_DeobfType != '') {
     if (DEBUG_MODE) {
       stdOut("\n-----------------------------------------------------------------------------\n");
       stdOut("[DEBUG]" . $l_Filename . "\n");
       var_dump(getFragment($l_Unwrapped, $l_Pos));
       stdOut("\n...... $l_DeobfType ...........\n");
       var_dump($l_Unwrapped);
       stdOut("\n");
     }

     switch ($l_DeobfType) {
        case '_GLOBALS_': 
           foreach ($g_DeMapper as $fkey => $fvalue) {
              if (DEBUG_MODE) {
                 stdOut("[$fkey] => [$fvalue]\n");
              }

              if ((strpos($l_Filename, $fkey) !== false) &&
                  (strpos($l_Unwrapped, $fvalue) !== false)) {
                 if (DEBUG_MODE) {
                    stdOut("\n[DEBUG] *** SKIP: False Positive\n");
                 } 

                 return true;
              }
           }
        break;
     }


     return false;
  }
}

function deobfuscate_bitrix($str)
{
	global $varname,$funclist,$strlist;
	$res = $str;
	$funclist = array();
	$strlist = array();
	$res = preg_replace("|'\s*\.\s*'|smi", '', $res);
	$res = preg_replace_callback(
		'|(round\((.+?)\))|smi',
		function ($matches) {
		   return round($matches[2]);
		},
		$res
	);
	$res = preg_replace_callback(
			'|base64_decode\(\'(.*?)\'\)|smi',
			function ($matches) {
				return "'" . base64_decode($matches[1]) . "'";
			},
			$res
	);

	$res = preg_replace_callback(
			'|\'(.*?)\'|sm',
			function ($matches) {
				$temp = base64_decode($matches[1]);
				if (base64_encode($temp) === $matches[1] && preg_match('#^[ -~]*$#', $temp)) { 
				   return "'" . $temp . "'";
				} else {
				   return "'" . $matches[1] . "'";
				}
			},
			$res
	);	

	if (preg_match_all('|\$GLOBALS\[\'(.+?)\'\]\s*=\s*Array\((.+?)\);|smi', $res, $founds, PREG_SET_ORDER)) {
   	foreach($founds as $found)
   	{
   		$varname = $found[1];
   		$funclist[$varname] = explode(',', $found[2]);
   		$funclist[$varname] = array_map(function($value) { return trim($value, "'"); }, $funclist[$varname]);

   		$res = preg_replace_callback(
   				'|\$GLOBALS\[\'' . $varname . '\'\]\[(\d+)\]|smi',
   				function ($matches) {
   				   global $varname, $funclist;
   				   return $funclist[$varname][$matches[1]];
   				},
   				$res
   		);
   		
     	        $res = preg_replace('~' . quotemeta(str_replace('~', '.', $found[0])) . '~smi', '', $res);
   	}
        }
		

	if (preg_match_all('|function _+(\d+)\(\$i\){\$a=Array\((.+?)\);[^}]+}|smi', $res, $founds, PREG_SET_ORDER)) {
	foreach($founds as $found)
	{
		$strlist = explode(',', $found[2]);

		$res = preg_replace_callback(
				'|_' . $found[1] . '\((\d+)\)|smi',
				function ($matches) {
				   global $strlist;
				   return $strlist[$matches[1]];
				},
				$res
		);

  	        $res = preg_replace('~' . quotemeta(str_replace('~', '\\~', $found[0])) . '~smi', '', $res);
	}
        }

  	$res = preg_replace('~<\?(php)?\s*\?>~smi', '', $res);

	preg_match_all('~function (_+(.+?))\(\$[_0-9]+\)\{\s*static\s*\$([_0-9]+)\s*=\s*(true|false);.*?\$\3=array\((.*?)\);\s*return\s*base64_decode\(\$\3~smi', $res, $founds,PREG_SET_ORDER);
	foreach($founds as $found)
	{
		$strlist = explode("',",$found[5]);
		$res = preg_replace_callback(
				'|' . $found[1] . '\((\d+)\)|sm',
				function ($matches) {
				   global $strlist;
				   return $strlist[$matches[1]]."'";
				},
				$res
		);
				
	}

	$res = preg_replace('|;|sm', ";\n", $res);

	return $res;
}

function my_eval($matches)
{
    $string = $matches[0];
    $string = substr($string, 5, strlen($string) - 7);
    return decode($string);
}

function decode($string, $level = 0)
{
    if (trim($string) == '') return '';
    if ($level > 100) return '';

    if (($string[0] == '\'') || ($string[0] == '"')) {
        return substr($string, 1, strlen($string) - 2); //
	} elseif ($string[0] == '$') {
        return $string; //
    } else {
        $pos      = strpos($string, '(');
        $function = substr($string, 0, $pos);
		
        $arg      = decode(substr($string, $pos + 1), $level + 1);
    	if ($function == 'base64_decode') return @base64_decode($arg);
    	else if ($function == 'gzinflate') return @gzinflate($arg);
		else if ($function == 'gzuncompress') return @gzuncompress($arg);
    	else if ($function == 'strrev')  return @strrev($arg);
    	else if ($function == 'str_rot13')  return @str_rot13($arg);
    	else return $arg;
    }    
}
    
function deobfuscate_eval($str)
{
    $res = preg_replace_callback('~eval\((base64_decode|gzinflate|strrev|str_rot13|gzuncompress).*?\);~ms', "my_eval", $str);
    return $res;
}

function getEvalCode($string)
{
    preg_match("/eval\((.*?)\);/", $string, $matches);
    return (empty($matches)) ? '' : end($matches);
}
function getTextInsideQuotes($string)
{
    preg_match('/("(.*?)")/', $string, $matches);
    return (empty($matches)) ? '' : end($matches);
}

function deobfuscate_lockit($str)
{    
    $obfPHP        = $str;
    $phpcode       = base64_decode(getTextInsideQuotes(getEvalCode($obfPHP)));
    $hexvalues     = getHexValues($phpcode);
    $tmp_point     = getHexValues($obfPHP);
    $pointer1      = hexdec($tmp_point[0]);
    $pointer2      = hexdec($hexvalues[0]);
    $pointer3      = hexdec($hexvalues[1]);
    $needles       = getNeedles($phpcode);
    $needle        = $needles[count($needles) - 2];
    $before_needle = end($needles);
    
    
    $phpcode = base64_decode(strtr(substr($obfPHP, $pointer2 + $pointer3, $pointer1), $needle, $before_needle));
    return "<?php {$phpcode} ?>";
}


    function getNeedles($string)
    {
        preg_match_all("/'(.*?)'/", $string, $matches);
        
        return (empty($matches)) ? array() : $matches[1];
    }
    function getHexValues($string)
    {
        preg_match_all('/0x[a-fA-F0-9]{1,8}/', $string, $matches);
        return (empty($matches)) ? array() : $matches[0];
    }

function deobfuscate_als($str)
{
	preg_match('~__FILE__;\$[O0]+=[0-9a-fx]+;eval\(\$[O0]+\(\'([^\']+)\'\)\);return;~msi',$str,$layer1);

	preg_match('~\$[O0]+=(\$[O0]+\()+\$[O0]+,[0-9a-fx]+\),\'([^\']+)\',\'([^\']+)\'\)\);eval\(~msi',base64_decode($layer1[1]),$layer2);
    $res = explode("?>", $str);
	if (strlen($res[1])>0)
	{
		$res = substr($res[1], 380);
		$res = base64_decode(strtr($res, $layer2[2], $layer2[3]));
	}
    return "<?php {$res} ?>";
}

function deobfuscate_byterun($str)
{
	preg_match('~\$_F=__FILE__;\$_X=\'([^\']+)\';eval\(~ms',$str,$matches);
	$res = base64_decode($matches[1]);
	$res = strtr($res,'123456aouie','aouie123456');
    return "<?php {$res} ?>";
}

function deobfuscate_urldecode($str)
{
	preg_match('~(\$[O0_]+)=urldecode\("([%0-9a-f]+)"\);((\$[O0_]+=(\1\{\d+\}\.?)+;)+)~msi',$str,$matches);
	$alph = urldecode($matches[2]);
	$funcs=$matches[3];
	for($i = 0; $i < strlen($alph); $i++)
	{
		$funcs = str_replace($matches[1].'{'.$i.'}.',$alph[$i],$funcs);
		$funcs = str_replace($matches[1].'{'.$i.'}',$alph[$i],$funcs);
	}

	$str = str_replace($matches[3], $funcs, $str);
	$funcs = explode(';', $funcs);
	foreach($funcs as $func)
	{
		$func_arr = explode("=", $func);
		if (count($func_arr) == 2)
		{
			$func_arr[0] = str_replace('$', '', $func_arr[0]);
			$str = str_replace('${"GLOBALS"}["' . $func_arr[0] . '"]', $func_arr[1], $str);
		}			
	}

	return $str;
}


function formatPHP($string)
{
    $string = str_replace('<?php', '', $string);
    $string = str_replace('?>', '', $string);
    $string = str_replace(PHP_EOL, "", $string);
    $string = str_replace(";", ";\n", $string);
    return $string;
}

function deobfuscate_fopo($str)
{
    $phpcode = formatPHP($str);
    $phpcode = base64_decode(getTextInsideQuotes(getEvalCode($phpcode)));
    @$phpcode = gzinflate(base64_decode(str_rot13(getTextInsideQuotes(end(explode(':', $phpcode))))));
    $old = '';
    while (($old != $phpcode) && (strlen(strstr($phpcode, '@eval($')) > 0)) {
        $old = $phpcode;
        $funcs = explode(';', $phpcode);
		if (count($funcs) == 5) $phpcode = gzinflate(base64_decode(str_rot13(getTextInsideQuotes(getEvalCode($phpcode)))));
		else if (count($funcs) == 4) $phpcode = gzinflate(base64_decode(getTextInsideQuotes(getEvalCode($phpcode))));
    }
    
    return substr($phpcode, 2);
}

function getObfuscateType($str)
{
if (preg_match('~eval\((base64_decode|gzinflate|strrev|str_rot13|gzuncompress)~ms', $str))
        return "eval";
    if (preg_match('~\$GLOBALS\[\'_+\d+\'\]=\s*array\(base64_decode\(~msi', $str))
        return "_GLOBALS_";
    if (preg_match('~function _+\d+\(\$i\){\$a=Array~msi', $str))
        return "_GLOBALS_";
    if (preg_match('~__FILE__;\$[O0]+=[0-9a-fx]+;eval\(\$[O0]+\(\'([^\']+)\'\)\);return;~msi', $str))
        return "ALS-Fullsite";
    if (preg_match('~\$[O0]*=urldecode\(\'%66%67%36%73%62%65%68%70%72%61%34%63%6f%5f%74%6e%64\'\);\s*\$GLOBALS\[\'[O0]*\'\]=\$[O0]*~msi', $str))
        return "LockIt!";
    if (preg_match('~\$\w+="(\\\x?[0-9a-f]+){13}";@eval\(\$\w+\(~msi', $str))
        return "FOPO";
	if (preg_match('~\$_F=__FILE__;\$_X=\'([^\']+\');eval\(~ms', $str))
        return "ByteRun";
    if (preg_match('~(\$[O0_]+)=urldecode\("([%0-9a-f]+)"\);((\$[O0_]+=(\1\{\d+\}\.?)+;)+)~msi', $str))
        return "urldecode_globals";
	
}

function deobfuscate($str)
{
    switch (getObfuscateType($str)) {
        case '_GLOBALS_':
            $str = deobfuscate_bitrix($str);
            break;
        case 'eval':
            $str = deobfuscate_eval($str);
            break;
        case 'ALS-Fullsite':
            $str = deobfuscate_als($str);
            break;
        case 'LockIt!':
            $str = deobfuscate_lockit($str);
            break;
        case 'FOPO':
            $str = deobfuscate_fopo($str);
            break;
	case 'ByteRun':
            $str = deobfuscate_byterun($str);
            break;
	case 'urldecode_globals' :
            $str = deobfuscate_urldecode($str);
	    break;
    }
    
    return $str;
}
