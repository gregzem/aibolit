<?php
///////////////////////////////////////////////////////////////////////////
// Автор: Григорий Земсков
// Email: greg@greg.su, http://revisium.com/ai/, http://greg.su, skype: greg_zemskov

// Запрещено использовать в коммерческих целях без согласования с автором скрипта.
// Лицензия GPL v3, http://www.gnu.org/licenses/gpl.html
///////////////////////////////////////////////////////////////////////////

define('PASS', '666'); // пароль для запуска

$defaults = array(
	'path' => dirname(__FILE__),
	'scan_all_files' => 0, // полное сканирование файлов (не только .js, .php, .html, .htaccess)
	'scan_delay' => 1, // задержка в миллисекундах при сканировании файлов для снижения нагрузки на файловую систему
	'max_size_to_scan' => '10M'
);


// завернутые сигнатуры, чтобы не ругались антивирусы на PC и на хостинге
$g_DBShe = unserialize(base64_decode("YTo3Njp7aTowO3M6OTQ6IiRpbmZvIC49ICgoJHBlcm1zICYgMHgwMDQwKSA/KCgkcGVybXMgJiAweDA4MDApID8gJ3MnIDogJ3gnICkgOigoJHBlcm1zICYgMHgwODAwKSA/ICdTJyA6ICctJykiO2k6MTtzOjg0OiI8dGV4dGFyZWEgbmFtZT1cInBocGV2XCIgcm93cz1cIjVcIiBjb2xzPVwiMTUwXCI+Ii5AJF9QT1NUWydwaHBldiddLiI8L3RleHRhcmVhPjxicj4iO2k6MjtzOjEwMToiN1RNR0FIWTVLYU05bzM3Vy9HUS9mckZKZXRmcWxSR082RlNSVE1tN0lMU20zNW81ejQrdjBtY2Y0S2FIZ0tTNVkxN2VxcXZEMm1tTjhOenRleXBsTmQ2V093clFWSzQ0NUoveTAiO2k6MztzOjE2OiJjOTlmdHBicnV0ZWNoZWNrIjtpOjQ7czo4OiJjOTlzaGVsbCI7aTo1O3M6ODoicjU3c2hlbGwiO2k6NjtzOjE0OiJ0ZW1wX3I1N190YWJsZSI7aTo3O3M6NzY6IlIwbEdPRGxoSmdBV0FJQUFBQUFBQVAvLy95SDVCQVVVQUFFQUxBQUFBQUFtQUJZQUFBSXZqSStweSswUEY0aTBnVnZ6dVZ4WERub1EiO2k6ODtzOjc6ImNhc3VzMTUiO2k6OTtzOjEzOiJXU0NSSVBULlNIRUxMIjtpOjEwO3M6NDc6IkV4ZWN1dGVkIGNvbW1hbmQ6IDxiPjxmb250IGNvbG9yPSNkY2RjZGM+WyRjbWRdIjtpOjExO3M6MTE6ImN0c2hlbGwucGhwIjtpOjEyO3M6MTExOiJCREFRa0pDUXdMREJnTkRSZ3lJUndoTWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qTC93QUFSQ0FBUUFCQURBU0lBQWhFQkEiO2k6MTM7czozMDoiW0F2NGJmQ1lDUyx4S1drJCtUa1VTLHhuR2RBeFtPIjtpOjE0O3M6MTU6IkRYX0hlYWRlcl9kcmF3biI7aToxNTtzOjEwNjoiOXRaU0IwYnlCeU5UY2djMmhsYkd3Z0ppWWdMMkpwYmk5aVlYTm9JQzFwSWlrN0RRb2dJQ0JsYkhObERRb2dJQ0JtY0hKcGJuUm1LSE4wWkdWeWNpd2lVMjl5Y25raUtUc05DaUFnSUdOcyI7aToxNjtzOjg2OiJjcmxmLid1bmxpbmsoJG5hbWUpOycuJGNybGYuJ3JlbmFtZSgifiIuJG5hbWUsICRuYW1lKTsnLiRjcmxmLid1bmxpbmsoImdycF9yZXBhaXIucGhwIiI7aToxNztzOjEwNToiLzB0VlNHL1N1djBVci9oYVVZQWRuM2pNUXdiYm9jR2ZmQWVDMjlCTjl0bUJpSmRWMWxrK2pZRFU5MkM5NGpkdERpZit4T1lqRzZDTGh4MzFVbzl4OS9lQVdnc0JLNjBrSzJtTHdxenFkIjtpOjE4O3M6MTE1OiJtcHR5KCRfUE9TVFsndXInXSkpICRtb2RlIHw9IDA0MDA7IGlmICghZW1wdHkoJF9QT1NUWyd1dyddKSkgJG1vZGUgfD0gMDIwMDsgaWYgKCFlbXB0eSgkX1BPU1RbJ3V4J10pKSAkbW9kZSB8PSAwMTAwIjtpOjE5O3M6NDQ6IldUK1B7fkVXMEVyUE90blVAI0AmXmxec1AxbGRueUAjQCZuc2srcjAsR1QrIjtpOjIwO3M6Mzc6ImtsYXN2YXl2LmFzcD95ZW5pZG9zeWE9PCU9YWt0aWZrbGFzJT4iO2k6MjE7czoxMjI6Im50KShkaXNrX3RvdGFsX3NwYWNlKGdldGN3ZCgpKS8oMTAyNCoxMDI0KSkgLiAiTWIgIiAuICJGcmVlIHNwYWNlICIgLiAoaW50KShkaXNrX2ZyZWVfc3BhY2UoZ2V0Y3dkKCkpLygxMDI0KjEwMjQpKSAuICJNYiA8IjtpOjIyO3M6MzE6InMoKS5nKCkucygpLnMoKS5nKCkucygpLnMoKS5nKCkiO2k6MjM7czo4ODoiQ1Jic2tFSVMreWJLQXdjNi9PQjFqVThZMFlJTVZVaHhoYU9Jc0hBQ0J5RDB3TUFOT0hxWTVZNDhndWlCbkNoa3dQWU5Ua3hkQlJWUlpMSEZrb2pZOTZJSSI7aToyNDtzOjczOiIkcG9ydF9iaW5kX2JkX3BsPSJJeUV2ZFhOeUwySnBiaTl3WlhKc0RRb2tVMGhGVEV3OUlpOWlhVzR2WW1GemFDQXRhU0k3RFFwIjtpOjI1O3M6MTI3OiJDQjJhVFpwSURFd01qUXREUW9qTFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFEwS0kzSmxjWFZwIjtpOjI2O3M6NzoiTlREYWRkeSI7aToyNztzOjc2OiJhIGhyZWY9Ijw/ZWNobyAiJGZpc3Rpay5waHA/ZGl6aW49JGRpemluLy4uLyI/PiIgc3R5bGU9InRleHQtZGVjb3JhdGlvbjogbm9uIjtpOjI4O3M6MTE1OiJUUlVGRVJGSXNNU2s3RFFwaWFXNWtLRk1zYzI5amEyRmtaSEpmYVc0b0pFeEpVMVJGVGw5UVQxSlVMRWxPUVVSRVVsOUJUbGtwS1NCOGZDQmthV1VnSWtOaGJuUWdiM0JsYmlCd2IzSjBYRzRpT3cwS2JHIjtpOjI5O3M6Mzg6IlJvb3RTaGVsbCEnKTtzZWxmLmxvY2F0aW9uLmhyZWY9J2h0dHA6IjtpOjMwO3M6MTEzOiJtOTFkQ3dnSkdWdmRYUXBPdzBLYzJWc1pXTjBLQ1J5YjNWMElEMGdKSEpwYml3Z2RXNWtaV1lzSUNSbGIzVjBJRDBnSkhKcGJpd2dNVEl3S1RzTkNtbG1JQ2doSkhKdmRYUWdJQ1ltSUNBaEpHVnZkWCI7aTozMTtzOjkwOiI8JT1SZXF1ZXN0LlNlcnZlclZhcmlhYmxlcygic2NyaXB0X25hbWUiKSU+P0ZvbGRlclBhdGg9PCU9U2VydmVyLlVSTFBhdGhFbmNvZGUoRm9sZGVyLkRyaXYiO2k6MzI7czo3MzoiUjBsR09EbGhGQUFVQUtJQUFBQUFBUC8vLzkzZDNjREF3SWFHaGdRRUJQLy8vd0FBQUNINUJBRUFBQVlBTEFBQUFBQVVBQlFBQSI7aTozMztzOjE2MDoicHJpbnQoKGlzX3JlYWRhYmxlKCRmKSAmJiBpc193cml0ZWFibGUoJGYpKT8iPHRyPjx0ZD4iLncoMSkuYigiUiIudygxKS5mb250KCdyZWQnLCdSVycsMykpLncoMSk6KCgoaXNfcmVhZGFibGUoJGYpKT8iPHRyPjx0ZD4iLncoMSkuYigiUiIpLncoNCk6IiIpLigoaXNfd3JpdGFibCI7aTozNDtzOjE2MToiKCciJywnJnF1b3Q7JywkZm4pKS4nIjtkb2N1bWVudC5saXN0LnN1Ym1pdCgpO1wnPicuaHRtbHNwZWNpYWxjaGFycyhzdHJsZW4oJGZuKT5mb3JtYXQ/c3Vic3RyKCRmbiwwLGZvcm1hdC0zKS4nLi4uJzokZm4pLic8L2E+Jy5zdHJfcmVwZWF0KCcgJyxmb3JtYXQtc3RybGVuKCRmbikiO2k6MzU7czoxMToiemVoaXJoYWNrZXIiO2k6MzY7czo1OiJzeXBleCI7aTozNztzOjU2OiJKQCFWckAqJlJIUnd+Skx3Lkd8eGxobkxKfj8xLmJ3T2J4YlB8IVZeQ3g5/fD9eP0iUN3nYnh+UCI7aTozODtzOjg6ImNpaHNoZWxsIjtpOjM5O3M6MTI2OiJYMU5GVTFOSlQwNWJKM1I0ZEdGMWRHaHBiaWRkSUQwZ2RISjFaVHNOQ2lBZ0lDQnBaaUFvSkY5UVQxTlVXeWR5YlNkZEtTQjdEUW9nSUNBZ0lDQnpaWFJqYjI5cmFXVW9KM1I0ZEdGMWRHaGZKeTRrY20xbmNtOTFjQ3dnYlciO2k6NDA7czo2MToiSkhacGMybDBZMjkxYm5RZ1BTQWtTRlJVVUY5RFQwOUxTVVZmVmtGU1Uxc2lkbWx6YVhSeklsMDdJR2xtSyI7aTo0MTtzOjc6IkZ4Yzk5c2giO2k6NDI7czozOToiV1NPc2V0Y29va2llKG1kNSgkX1NFUlZFUlsnSFRUUF9IT1NUJ10pIjtpOjQzO3M6MTA3OiJDUWJvR2w3Zit4Y0F5VXlzeGI1bUtTNmtBV3NuUkxkUytzS2dHb1pXZHN3TEZKWlY4dFZ6WHNxK21lU1BITXhUSTNuU1VCNGZKMnZSM3IzT252WHROQXFONnduL0R0VFRpK0N1MVVPSndOTCI7aTo0NDtzOjE0MToiPC90ZD48dGQgaWQ9ZmE+WyA8YSB0aXRsZT1cIkhvbWU6ICciLmh0bWxzcGVjaWFsY2hhcnMoc3RyX3JlcGxhY2UoIlwiLCAkc2VwLCBnZXRjd2QoKSkpLiInLlwiIGlkPWZhIGhyZWY9XCJqYXZhc2NyaXB0OlZpZXdEaXIoJyIucmF3dXJsZW5jb2RlIjtpOjQ1O3M6MTY6IkNvbnRlbnQtVHlwZTogJF8iO2k6NDY7czo4NjoiPG5vYnI+PGI+JGNkaXIkY2ZpbGU8L2I+ICgiLiRmaWxlWyJzaXplX3N0ciJdLiIpPC9ub2JyPjwvdGQ+PC90cj48Zm9ybSBuYW1lPWN1cnJfZmlsZT4iO2k6NDc7czo0ODoid3NvRXgoJ3RhciBjZnp2ICcgLiBlc2NhcGVzaGVsbGFyZygkX1BPU1RbJ3AyJ10pIjtpOjQ4O3M6MjE6ImV2YWwoYmFzZTY0X2RlY29kZSgkXyI7aTo0OTtzOjE0MjoiNWpiMjBpS1c5eUlITjBjbWx6ZEhJb0pISmxabVZ5WlhJc0ltRndiM0owSWlrZ2IzSWdjM1J5YVhOMGNpZ2tjbVZtWlhKbGNpd2libWxuYldFaUtTQnZjaUJ6ZEhKcGMzUnlLQ1J5WldabGNtVnlMQ0ozWldKaGJIUmhJaWtnYjNJZ2MzUnlhWE4wY2lnayI7aTo1MDtzOjc2OiJMUzBnUkhWdGNETmtJR0o1SUZCcGNuVnNhVzR1VUVoUUlGZGxZbk5vTTJ4c0lIWXhMakFnWXpCa1pXUWdZbmtnY2pCa2NqRWdPa3c9IjtpOjUxO3M6NjU6ImlmIChlcmVnKCdeW1s6Ymxhbms6XV0qY2RbWzpibGFuazpdXSsoW147XSspJCcsICRjb21tYW5kLCAkcmVncykpIjtpOjUyO3M6MTEwOiJ2enY2ZCtpT3Z0a2QzOFRsSHU4bVFhdlhkbkpDYnBRY3BYaE5iYkxtWk9xTW9wRFplTmFsYitWS2xlZGhDanBWQU1RU1FueFZJRUNRQWZMdTVLZ0xtd0I2ZWhRUUdOU0JZanBnOWc1R2RCaWhYbyI7aTo1MztzOjQ2OiJyb3VuZCgwKzk4MzAuNCs5ODMwLjQrOTgzMC40Kzk4MzAuNCs5ODMwLjQpKT09IjtpOjU0O3M6MTI6IlBIUFNIRUxMLlBIUCI7aTo1NTtzOjEyNzoicWhEVFpJcE1jQjF4Qm9rMzMyQmpjY2ZQWHEwUXNaVS9nNGVhcEJ4VDVnaXQxckdkS3R3ZjFydDlPT2ljYy9oVGxwZUZtRWpSUmtXR1dUSlRrQ29sMFg0QXV3SlNmRmh0ZlA1ZE9nbjU2MWlsK3dremtxQ0c5ZGZUOXpxYzI3NCI7aTo1NjtzOjEyMDoiVHNOQ2lBZ0lDQnphVzR1YzJsdVgyWmhiV2xzZVNBOUlFRkdYMGxPUlZRN0RRb2dJQ0FnYzJsdUxuTnBibDl3YjNKMElEMGdhSFJ2Ym5Nb1lYUnZhU2hoY21kMld6SmRLU2s3RFFvZ0lDQWdjMmx1TG5OcGJsOWhaIjtpOjU3O3M6NTI6ImFIUjBjRG92TDJvdFpHVjJMbkoxTDJsdVpHVjRMbkJvY0Q5amNHNDlabkpoYldWelpXeHMiO2k6NTg7czo4NzoiV1RKVGtDb2wwWDRBdXdKU2ZGaHRmUDVkT2duNTYxaWwrd2t6a3FDRzlkZlQ5enFjMjc0dmVJZVNkNDFDeFVJdkhGbit0Vzc3b0Uzb2hxU3YwMUJYelQwIjtpOjU5O3M6NzE6IkhCeWIzUnZLU0I4ZkNCa2FXVW9Ja1Z5Y205eU9pQWtJVnh1SWlrN0RRcGpiMjV1WldOMEtGTlBRMHRGVkN3Z0pIQmhaR1J5IjtpOjYwO3M6MTc6IldlYiBTaGVsbCBieSBib2ZmIjtpOjYxO3M6MTY6IldlYiBTaGVsbCBieSBvUmIiO2k6NjI7czoxMToiZGV2aWx6U2hlbGwiO2k6NjM7czoyMDoiU2hlbGwgYnkgTWF3YXJfSGl0YW0iO2k6NjQ7czo4OiJOM3RzaGVsbCI7aTo2NTtzOjExOiJTdG9ybTdTaGVsbCI7aTo2NjtzOjExOiJMb2N1czdTaGVsbCI7aTo2NztzOjIyOiJwcml2YXRlIFNoZWxsIGJ5IG00cmNvIjtpOjY4O3M6MTM6Inc0Y2sxbmcgc2hlbGwiO2k6Njk7czoyMToiRmFUYUxpc1RpQ3pfRnggRngyOVNoIjtpOjcwO3M6MTI6InI1N3NoZWxsLnBocCI7aTo3MTtzOjI3OiJkZWZhdWx0X2FjdGlvbiA9ICdGaWxlc01hbiciO2k6NzI7czo0MjoiV29ya2VyX0dldFJlcGx5Q29kZSgkb3BEYXRhWydyZWN2QnVmZmVyJ10pIjtpOjczO3M6NDA6IiRmaWxlcGF0aD1AcmVhbHBhdGgoJF9QT1NUWydmaWxlcGF0aCddKTsiO2k6NzQ7czo5OiJhbnRpc2hlbGwiO2k6NzU7czo5OiJyb290c2hlbGwiO30="));
$g_SusDB = unserialize(base64_decode("YToxNDp7aTowO3M6MjA6ImluaV9nZXQoJ3NhZmVfbW9kZScpIjtpOjE7czoyMDoiaW5pX2dldCgic2FmZV9tb2RlIikiO2k6MjtzOjI4OiJldmFsKGd6aW5mbGF0ZShiYXNlNjRfZGVjb2RlIjtpOjM7czoxOToiZXZhbChiYXNlNjRfZGVjb2RlKCI7aTo0O3M6MjA6InNycGF0aDovLy4uLy4uLy4uLy4uIjtpOjU7czo3OiI8aWZyYW1lIjtpOjY7czo5OiJwaHBpbmZvKCkiO2k6NztzOjMxOiJldmFsKGd6dW5jb21wcmVzcyhiYXNlNjRfZGVjb2RlIjtpOjg7czoxODoiZXZhbChiYXNlNjRfZGVjb2RlIjtpOjk7czoxNDoiU0hPVyBEQVRBQkFTRVMiO2k6MTA7czoxNDoicG9zaXhfZ2V0cHd1aWQiO2k6MTE7czoxNzoiJGRlZmF1bHRfdXNlX2FqYXgiO2k6MTI7czoxMzoiZXZhbCh1bmVzY2FwZSI7aToxMztzOjIzOiJkb2N1bWVudC53cml0ZSh1bmVzY2FwZSI7fQ=="));
$g_AdwareSig = unserialize(base64_decode("YToxMTp7aTowO3M6MTk6Il9fbGlua2ZlZWRfcm9ib3RzX18iO2k6MTtzOjEzOiJMSU5LRkVFRF9VU0VSIjtpOjI7czoxODoiX19zYXBlX2RlbGltaXRlcl9fIjtpOjM7czoyNjoiZGlzcGVuc2VyLmFydGljbGVzLnNhcGUucnUiO2k6NDtzOjExOiJMRU5LX2NsaWVudCI7aTo1O3M6MTE6IlNBUEVfY2xpZW50IjtpOjY7czoxNToiZGIudHJ1c3RsaW5rLnJ1IjtpOjc7czoxNjoidGxfbGlua3NfZGJfZmlsZSI7aTo4O3M6MTU6IlRydXN0bGlua0NsaWVudCI7aTo5O3M6MTA6Ii0+U0xDbGllbnQiO2k6MTA7czo4MDoiaXNzZXQoJF9TRVJWRVJbJ0hUVFBfVVNFUl9BR0VOVCddKSAmJiAoJF9TRVJWRVJbJ0hUVFBfVVNFUl9BR0VOVCddID09ICdMTVBfUm9ib3QiO30="));
$g_JSVirSig = unserialize(base64_decode("YTo1OntpOjA7czo0MjoiaWYoMSl7Zj0nZicrJ3InKydvJysnbScrJ0NoJysnYXJDJysnb2RlJzt9IjtpOjE7czoxOToiLnByb3RvdHlwZS5hfWNhdGNoKCI7aToyO3M6Mjg6ImlmKFJlZi5pbmRleE9mKCcuZ29vZ2xlLicpIT0iO2k6MztzOjI2OiJldmFsKGZ1bmN0aW9uKHAsYSxjLGssZSxyKSI7aTo0O3M6NzM6ImluZGV4T2Z8aWZ8cmN8bGVuZ3RofG1zbnx5YWhvb3xyZWZlcnJlcnxhbHRhdmlzdGF8b2dvfGJpfGhwfHZhcnxhb2x8cXVlcnkiO30="));

////////////////////////////////////////////////////////////////////////////
$l_Res = '';

$g_Structure = array();
$g_Counter = 0;

$g_FileInfo = array();
$g_Iframer = array();
$g_PHPCodeInside = array();
$g_CriticalJS = array();

$g_TotalFolder = 0;
$g_TotalFiles = 0;

$g_FoundTotalDirs = 0;
$g_FoundTotalFiles = 0;

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
ini_set('max_execution_time', '600');
ini_set('memory_limit','256M');

/**
 * Determine php script is called from the command line interface
 * @return bool
 */
function isCli()
{
	return php_sapi_name() == 'cli';
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

	@fwrite(STDOUT, $text . ($add_lb ? "\n" : ''));
}

/**
 * Print progress
 * @param int $num Current file
 */
function printProgress($num)
{

	$total_files = $GLOBALS['g_FoundTotalFiles'];
	$elapsed_time = microtime(true) - START_TIME;
	$stat = '';
	if ($elapsed_time >= 1)
	{
		$elapsed_seconds = round($elapsed_time, 0);
		$fs = floor($num / $elapsed_seconds);
		$left_files = $total_files - $num;
		$left_time = ceil($left_files / $fs);
		$stat = '. [Avg: ' . $fs . ' files/s' . ($left_time > 0  ? ' Left: ' . seconds2Human($left_time) : '') . ']';
	}
	$text = "Scanning file $num of {$total_files}" . $stat;
	$text = str_pad($text, 75, ' ', STR_PAD_RIGHT);

	stdOut(str_repeat(chr(8), 80) . $text, false);
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

	$r .= $seconds + ($ms > 0 ? round($ms, 5) : 0) . (isCli() ? ' s' : ' сек'); //' сек' - not good for shell

	return $r;
}

if (isCli())
{

	$cli_options = array(
		'm:' => 'memory:',
		's:' => 'size:',
		'a' => 'all',
		'd:' => 'delay:',
		'r:' => 'report:',
		'h' => 'help'
	);

	$options = getopt(implode('', array_keys($cli_options)), array_values($cli_options));

	if (isset($options['h']) OR isset($options['help']))
	{
		$memory_limit = ini_get('memory_limit');
		echo <<<HELP
AI-Bolit - Script to search for shells and other malicious software.

Usage: php {$_SERVER['PHP_SELF']} [OPTIONS] [PATH]
Current default path is: {$defaults['path']}

Mandatory arguments to long options are mandatory for short options too.
  -p, --path=PATH      Directory path to scan, by default the file directory is used
                       Current path: {$defaults['path']}
  -m, --memory=SIZE    Maximum amount of memory a script may consume. Current value: $memory_limit
                       Can take shorthand byte values (1M, 1G...)
  -s, --size=SIZE      Scan files are smaller than SIZE. 0 - All files. Current value: {$defaults['max_size_to_scan']}
  -a, --all            Scan all files (by default scan. js,. php,. html,. htaccess)
  -d, --delay=INT      delay in milliseconds when scanning files to reduce load on the file system (Default: 1)
  -r, --report=PATH    Filename of report html, by default '.2report.html'  is used, relative to scan path
                       Enter your email address if you wish to report has been sent to the email.
                       You can also specify multiple email separated by commas.
      --help           display this help and exit

HELP;
		exit;
	}

	if (
		(isset($options['memory']) AND !empty($options['memory']) AND ($memory = $options['memory']))
		OR (isset($options['m']) AND !empty($options['m']) AND ($memory = $options['m']))
	)
	{
		$memory = getBytes($memory);
		if ($memory > 0)
		{
			$defaults['memory_limit'] = $memory;
		}
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

	if (isset($options['all']) OR isset($options['a']))
	{
		$defaults['scan_all_files'] = 1;
	}

	if (
		(isset($options['report']) AND ($report = $options['report']) !== false)
		OR (isset($options['r']) AND ($report = $options['r']) !== false)
	)
	{
		define('REPORT', $report);
	}

	defined('REPORT') OR define('REPORT', '.2report.html');

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
}

// Init
define('MAX_ALLOWED_PHP_HTML_IN_DIR', 100);
define('BASE64_LENGTH', 100);

define('SCAN_ALL_FILES', (bool) $defaults['scan_all_files']);
define('SCAN_DELAY', (int) $defaults['scan_delay']);
define('MAX_SIZE_TO_SCAN', getBytes($defaults['max_size_to_scan']));

if ($defaults['memory_limit'] AND ($defaults['memory_limit'] = getBytes($defaults['memory_limit'])) > 0)
	ini_set('memory_limit', $defaults['memory_limit']);

define('START_TIME', microtime(true));

define('ROOT_PATH', realpath($defaults['path']));

if (!ROOT_PATH)
{
	die(stdOut("Directory '{$defaults['path']}' not found!"));
}
elseif(!is_readable(ROOT_PATH))
{
	die(stdOut("Cannot read directory '" . ROOT_PATH . "'!"));
}

define('CURRENT_DIR', getcwd());
chdir(ROOT_PATH);

// Check for report
if (isCli() AND REPORT !== '' AND !getEmails(REPORT))
{
	$report = str_replace('\\', '/', REPORT);
	$abs = strpos($report, '/') === 0 ? DIRECTORY_SEPARATOR : '';
	$report = array_values(array_filter(explode('/', $report)));
	$report_file = array_pop($report);
	$report_path = realpath($abs . implode(DIRECTORY_SEPARATOR, $report));

	define('REPORT_FILE', $report_file);
	define('REPORT_PATH', $report_path);

	if (REPORT_FILE AND REPORT_PATH AND is_file(REPORT_PATH . DIRECTORY_SEPARATOR . REPORT_FILE))
	{
		@unlink(REPORT_PATH . DIRECTORY_SEPARATOR . REPORT_FILE);
	}
}

ob_start();
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" >

<style type="text/css">
 body {
   font-family: Georgia;
   color: #303030;
   background: #FFFFF0;
   font-size: 12px;
   margin: 20px;
   padding: 0;
 }

 h3 {
   font-size: 27px;
   margin: 0 0;
 }

 .sec {
  font-size: 25px;
  margin-bottom: 10px;
 }


 .warn {
   color: #FF4C00;
   margin: 0 0 20px 0;
 }

 .warn .it {
   color: #FF4C00;
 }

 .warn2 {
   color: #42ADFF;
   margin: 0 0 20px 0;
 }

 .warn2 .it {
   color: #42ADFF;
 }

 .ok {
   color: #007F0E;
   margin: 0 0 20px 0;
 }

 .vir {
    color: #A00000;
    margin: 0 0 20px 0;
  }

 .vir .it {
    color: #A00000;
 }

 .disclaimer {
   font-size: 11px;
   font-family: Arial;
   color: #505050;
   margin: 10px 0 10px 0;
 }

 .thanx {
  border: 1px solid #F0F0F0;
   padding: 20px 20px 10px 20px;
  font-size: 12px;
  font-family: Arial;
  background: #FBFFBA;
 }

 .footer {
  margin: 40px 0 0 0;
 }

 .rep {
   margin: 10px 0 20px 0;
   font-size: 11px;
   font-family: Arial;
 }

 .notice
 {
  border: 1px solid cornflowerblue;
  padding: 10px;
  font-size: 12px;
  font-family: Arial;
  background: #E8F8F8;
 }

 .offer {
   position: absolute;
   width: 350px;
   right: 100px;
   top: 100px;
   background: #E08080;
   color: white;
   font-size: 11px;
   font-family: Arial;
   padding: 20px 20px 10px 20px;

 }

 .offer A {
   color: yellow;
 }

 .update {
   color: red;
   font-size: 12px;
   font-family: Arial;
   margin: 0 0 20px 0;
 }

 .tbg0 {
 }

 .tbg1 {
   background: #F0F0F0;
 }

 .it {
    font-size: 12px;
    font-family: Arial;
 }

 .ctd {
    font-size: 12px;
    font-family: Arial;
    color: #909090;
 }

 .flist {
   margin: 10px 0 30px 0;
 }

 .tbgh {
   background: #E0E0E0;
 }

 TH {
   text-align: left;
   font-size: 12px;
   font-family: Arial;
   color: #909090;
 }

 .details {
  font-size: 9px;
  font-family: Arial;
 }

 .marker
 {
    color: #FF0000;
    font-size: 16px;
    font-weight: 700;
 }

</style>
</head>
<body>

<?php

////////////////////////////////////////////////////////////////////////////
$l_Result = '';

$l_Result .= '<h3>AI-Болит v.20120422 &mdash; удаленькая искалка вредоносного ПО на хостинге.</h3><h5>Григорий Земсков, 2012, <a target=_blank href="http://revisium.com/ai/">Страница проекта на revisium.com.</a></h5>';


$l_CreationTime = filemtime(__FILE__);
if (time() - $l_CreationTime > 86400) {
  $l_Result .= '<div class="update">Проверьте обновление на сайте <a href="http://revisium.com/ai/">http://revisium.com/ai/</a>. Возможно, ваша версия скрипта уже устарела.</div>';
}


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
		if (filter_var($email[$i], FILTER_VALIDATE_EMAIL))
		{
			$r[] = $email[$i];
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
function printList($par_List, $par_Details = null) {
  global $g_Structure;

  $l_Result = '';
  $l_Result .= "<div class=\"flist\"><table cellspacing=1 cellpadding=4 border=0>";

  $l_Result .= "<tr class=\"tbgh" . ( $i % 2 ). "\">";
  $l_Result .= "<th>Путь</th>";
  $l_Result .= "<th>Дата создания</th>";
  $l_Result .= "<th>Дата модификации</th>";
  $l_Result .= "<th width=90>Размер</th>";
  $l_Result .= "</tr>";

  for ($i = 0; $i < count($par_List); $i++) {
     $l_Creat = $g_Structure['c'][$par_List[$i]] > 0 ? date("d/m/Y H:i", $g_Structure['c'][$par_List[$i]]) : '-';
     $l_Modif = $g_Structure['m'][$par_List[$i]] > 0 ? date("d/m/Y H:i", $g_Structure['m'][$par_List[$i]]) : '-';
     $l_Size = $g_Structure['s'][$par_List[$i]] > 0 ? bytes2Human($g_Structure['s'][$par_List[$i]]) : '-';

     if ($par_Details != null) {
        $l_WithMarket = preg_replace('|@AI_MARKER@|smi', '<span class="marker">|</span>', $par_Details[$i]);
        $l_Body = '<div class="details">' . $l_WithMarket . '</div>';
     } else {
        $l_Body = '';
     }

     $l_Result .= "<tr class=\"tbg" . ( $i % 2 ). "\">";
     $l_Result .= "<td><div class=\"it\">" . $g_Structure['n'][$par_List[$i]] . "</div>" . $l_Body . "</td>";
     $l_Result .= "<td><div class=\"ctd\">" . $l_Creat . "</div></td>";
     $l_Result .= "<td><div class=\"ctd\">" . $l_Modif . "</div></td>";
     $l_Result .= "<td><div class=\"ctd\">" . $l_Size . "</div></td>";
     $l_Result .= "</tr>";

  }

  $l_Result .= "</table></div>";

  return $l_Result;
}

///////////////////////////////////////////////////////////////////////////
function QCR_ScanDirectories($l_RootDir)
{
	global $g_Structure, $g_Counter, $g_Doorway, $g_FoundTotalFiles, $g_FoundTotalDirs;
	$l_DirCounter = 0;
	$l_DoorwayFilesCounter = 0;
	$l_SourceDirIndex = $g_Counter - 1;

	if ($l_DIRH = opendir($l_RootDir))
	{
		while ($l_FileName = readdir($l_DIRH))
		{

			if ($l_FileName == '.' || $l_FileName == '..') continue;

			$l_FileName = $l_RootDir . '/' . $l_FileName;

			$l_Ext = substr($l_FileName, strrpos($l_FileName, '.') + 1);

			$l_IsDir = is_dir($l_FileName);

			$l_NeedToScan = SCAN_ALL_FILES || (in_array($l_Ext, array(
				'js', 'php', 'php3',
				'php4', 'php5', 'tpl', 'inc', 'htaccess', 'html', 'htm'
			)));

			if ($l_IsDir)
			{
				$g_Structure['d'][$g_Counter] = $l_IsDir;
				$g_Structure['n'][$g_Counter] = $l_FileName;

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
					$g_Counter++;
					$g_FoundTotalFiles++;
					if (in_array($l_Ext, array(
						'php', 'php3',
						'php4', 'php5', 'html', 'htm'
					))
					)
					{
						$l_DoorwayFilesCounter++;

						if ($l_DoorwayFilesCounter > MAX_ALLOWED_PHP_HTML_IN_DIR)
						{
							$l_Doorway[] = $l_SourceDirIndex;
							$l_DoorwayFilesCounter = -655360;
						}
					}

					$l_Stat = stat($l_FileName);

					$g_Structure['d'][$g_Counter] = $l_IsDir;
					$g_Structure['n'][$g_Counter] = $l_FileName;
					$g_Structure['s'][$g_Counter] = $l_Stat['size'];
					$g_Structure['c'][$g_Counter] = $l_Stat['ctime'];
					$g_Structure['m'][$g_Counter] = $l_Stat['mtime'];
				}
			}
		}

		closedir($l_DIRH);
	}

	return $l_Structure;
}

///////////////////////////////////////////////////////////////////////////
function getFragment($par_Content, $par_Pos) {
  $l_MaxChars = 75;

  $l_PosLeft = max(0, $par_Pos - $l_MaxChars);
  $l_Len = min(strlen($par_Content) - 1, $l_MaxChars);

  $l_Res = substr($par_Content, $l_PosLeft, $l_MaxChars) .
           '@AI_MARKER@' . substr($par_Content,
           $l_PosLeft + $l_MaxChars, $l_MaxChars);


  return htmlspecialchars($l_Res);
}

///////////////////////////////////////////////////////////////////////////
function QCR_SearchPHP($src)
{
  if (strpos($src, "<?") !== false || strpos($src, "<%") !== false) {
    return true;
  }

  if (preg_match("/(<script[^>]*language\s*=\s*)('|\"|)php('|\"|)([^>]*>)/i", $src)) {
    return true;
  }

  return false;
}

///////////////////////////////////////////////////////////////////////////
function QCR_GoScan($par_Offset)
{
	global $g_Iframer, $g_SuspDir, $g_Redirect, $g_Doorway, $g_EmptyLink, $g_Structure, $g_Counter,
		   $g_WritableDirectories, $g_CriticalPHP, $g_TotalFolder, $g_TotalFiles, $g_WarningPHP, $g_AdwareList,
		   $g_CriticalPHP, $g_CriticalJS, $g_PHPCodeInside, $g_WarningPHPFragment, $g_BigFiles;

	static $_files_and_ignored = 0;

	//print "<pre>";
	//var_dump($g_Structure);
	//print "</pre>";

	for ($i = $par_Offset; $i < $g_Counter; $i++)
	{
		$l_Filename = $g_Structure['n'][$i];

		if ($g_Structure['d'][$i])
		{
			// FOLDER
			$g_TotalFolder++;

			if (is_writable($l_Filename))
			{
				$g_WritableDirectories[] = $i;
			}
		}
		else
		{
			// FILE
			if (MAX_SIZE_TO_SCAN > 0 AND $g_Structure['s'][$i] > MAX_SIZE_TO_SCAN)
			{
				$g_BigFiles[] = $i;
			}
			else
			{
				$g_TotalFiles++;

				$l_Content = implode('', file($l_Filename));

				// warnings
				$l_Pos = '';
				if (WarningPHP($l_Filename, $l_Content, $l_Pos))
				{
					$g_WarningPHP[] = $i;
					$g_WarningPHPFragment[] = getFragment($l_Content, $l_Pos);
				}

				// adware
				if (Adware($l_Filename, $l_Content))
				{
					$g_AdwareList[] = $i;
				}

				// critical
				if (CriticalPHP($l_Filename, $i, $l_Content))
				{
					$g_CriticalPHP[] = $i;
				}

				// critical JS
				if (CriticalJS($l_Filename, $i, $l_Content))
				{
					$g_CriticalJS[] = $i;
				}

				if
				(stripos($l_Filename, 'index.php') ||
					stripos($l_Filename, 'index.htm') ||
					SCAN_ALL_FILES
				)
				{
					if (stripos($l_Content, '<iframe'))
					{
						$g_Iframer[] = $i;
					}

					if (preg_match('|<a.+?>\s*</a>|smi', $l_Content, $l_Found))
					{
						$g_EmptyLink[] = $i;
					}

				}

				// check for PHP code inside any type of file
				if (stripos($l_Filename, '.php') === false)
				{
					if (QCR_SearchPHP($l_Content))
					{
						$g_PHPCodeInside[] = $i;
					}
				}

				// articles
				if (stripos($l_Filename, 'article_index'))
				{
					$g_AdwareSig[] = $i;
				}

				// htaccess
				if (stripos($l_Filename, '.htaccess'))
				{
					if (stripos($l_Content, 'index.php?name=$1') ||
						stripos($l_Content, 'index.php?m=1')
					)
					{
						$g_SuspDir[] = $i;
					}

					$l_HTAContent = preg_replace('|^\s*#.+$|m', '', $l_Content);

					if (
						preg_match_all("|RewriteRule\s+.+?\s+http://(.+?)/.+\s+[.*R=\d+.*]|smi", $l_HTAContent, $l_Found, PREG_SET_ORDER)
					)
					{
						$l_Host = str_replace('www.', '', $_SERVER['HTTP_HOST']);
						for ($j = 0; $j < sizeof($l_Found); $j++)
						{
							$l_Found[$j][1] = str_replace('www.', '', $l_Found[$j][1]);
							if ($l_Found[$j][1] != $l_Host)
							{
								$g_Redirect[] = $i;
								break;
							}
						}
					}
				}
			}
			printProgress(++$_files_and_ignored);
		} // end of if (file)

		usleep(SCAN_DELAY * 1000);

	} // end of for

}

///////////////////////////////////////////////////////////////////////////
function WarningPHP($l_FN, $l_Content, &$par_Pos)
{
  global $g_SusDB;

  $l_Res = false;

  foreach ($g_SusDB as $l_Item)
  {
    if (($par_Pos = stripos($l_Content, $l_Item)) !== false &&
	stripos($l_Content, 'GGGGHJKJHGHJKJG6789876') === false) {

       $l_Res = true;
       break;
    }
  }

  return $l_Res;
}

///////////////////////////////////////////////////////////////////////////
function Adware($l_FN, $l_Content)
{
  global $g_AdwareSig;

  $l_Res = false;

  foreach ($g_AdwareSig as $l_Item)
  {
    if (stripos($l_Content, $l_Item) && !stripos($l_Content, 'GGGGHJKJHGHJKJG6789876')) {
       $l_Res = true;
       break;
    }
  }

  return $l_Res;
}

///////////////////////////////////////////////////////////////////////////
function CriticalPHP($l_FN, $l_Index,  $l_Content)
{
  global $g_DBShe, $g_Base64;

  // GGGGHJKJHGHJKJG6789876
  $l_Res = false;

  foreach ($g_DBShe as $l_Item)
  {
    if (stripos($l_Content, $l_Item) && !stripos($l_Content, 'GGGGHJKJHGHJKJG6789876')) {
       $l_Res = true;
       break;
    }
  }

  // detect base64 suspicious
  if (preg_match('|([A-Za-z0-9+/]{' . BASE64_LENGTH . ',})|smi', $l_Content, $l_Found)
	&& (stripos($l_Content, 'eval') || stripos($l_Content, 'create_function') || stripos($l_Content, 'base64_decode'))
	&& !stripos($l_Content, 'GGGGHJKJHGHJKJG6789876')) {
     $g_Base64[] = $l_Index;
  }

  return $l_Res;
}

///////////////////////////////////////////////////////////////////////////
function CriticalJS($l_FN, $l_Index, $l_Content)
{
  global $g_JSVirSig, $g_Base64;

  // GGGGHJKJHGHJKJG6789876
  $l_Res = false;

  foreach ($g_JSVirSig as $l_Item)
  {
    if (stripos($l_Content, $l_Item)) {
       $l_Res = true;
       break;
    }
  }

  return $l_Res;
}


///////////////////////////////////////////////////////////////////////////

if ($_GET['p'] != PASS && isset($_SERVER['HTTP_HOST'])) {
  print "Запустите скрипт с паролем, который установлен в переменной PASS (в начале файла). <br/>Например, так http://ваш_сайт_и_путь_до_скрипта/ai-bolit.php?p=<b>qwe555</b>";
  exit;
}

if (!is_readable(ROOT_PATH)) {
  print "Текущая директория не доступна для чтения скрипту. Пожалуйста, укажите права на доступ <b>rwxr-xr-x</b> или с помощью командной строки <b>chmod +r имя_директории</b>";
  exit;
}

stdOut("Start scanning '" . ROOT_PATH . "'.");
QCR_ScanDirectories(ROOT_PATH);
stdOut("Founded $g_FoundTotalFiles files in $g_FoundTotalDirs directories.");
QCR_GoScan(0);

////////////////////////////////////////////////////////////////////////////

$l_Result .= "<div class=\"sec\"><b>Отчет по " . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : realpath('.')) . "</b></div>";

$time_tacked = seconds2Human(microtime(true) - START_TIME);

$l_Result .= "<div class=\"rep\">Известно ". count($g_DBShe) ." шелл-сигнатур.  Затрачено времени: <b>$time_tacked</b
>.<br/>Сканирование начато: " . date('d-m-Y в H:i:s', floor(START_TIME)) . ". Сканирование завершено: " . date('d-m-Y в H:i:s') . ".</div> ";

$l_Result .= "<div class=\"rep\">Всего проверено $g_TotalFolder директорий и $g_TotalFiles файлов.</div>";

$l_Result .= "<div class=\"sec\">Критические замечания</div>";

$l_ShowOffer = false;

if (count($g_CriticalPHP) > 0) {

  $l_Result .= "<div class=\"vir\">Найдены сигнатуры шелл-скрипта. Подозрение на вредоносный скрипт:";
  $l_Result .= printList($g_CriticalPHP);
  $l_Result .= "</div>";

  $l_ShowOffer = true;
} else {

  $l_Result .= '<div class="ok">Шелл-скрипты не найдены.</div>';

}

if (count($g_CriticalJS) > 0) {
  $l_Result .= "<div class=\"vir\">Найдены сигнатуры Javscript вирусов:";
  $l_Result .= printList($g_CriticalJS);
  $l_Result .= "</div>";

  $l_ShowOffer = true;
}

if (count($g_Base64) > 0) {
  $l_ShowOffer = true;

  $l_Result .= "<div class=\"vir\">Найдены длинные зашифрованные последовательности в PHP. Подозрение на вредоносный скрипт:";
  $l_Result .= printList($g_Base64);
  $l_Result .= "</div>";

}

if (count($g_Iframer) > 0) {
  $l_ShowOffer = true;

  $l_Result .= "<div class=\"vir\">Подозрение на вредоносный скрипт:";
  $l_Result .= printList($g_Iframer);
  $l_Result .= "</div>";

}

if (count($g_SuspDir) > 0) {

  $l_Result .= "<div class=\"vir\">Скорее всего этот файл лежит в каталоге с дорвеем:";
  $l_Result .= printList($g_SuspDir);
  $l_Result .= "</div>";

} else {

  $l_Result .= '<div class="ok">Не найдено директорий c дорвеями</div>';

}

$l_Result .= "<div class=\"sec\">Предупреждения</div>";

if (count($g_Redirect) > 0) {

  $l_ShowOffer = true;
  $l_Result .= "<div class=\"warn\">Редирект на внешний сервер. Возможно, дорвей или вредоносный скрипт:";
  $l_Result .= printList($g_Redirect);
  $l_Result .= "</div>";

}

if (count($g_PHPCodeInside) > 0) {

  $l_ShowOffer = true;
  $l_Result .= "<div class=\"warn\">В не .php файле содержится стартовая сигнатура PHP кода. Возможно, там вредоносный код:";
  $l_Result .= printList($g_PHPCodeInside);
  $l_Result .= "</div>";

}

if (count($g_AdwareList) > 0) {
  $l_ShowOffer = true;

  $l_Result .= "<div class=\"warn\">В этих файлах размещен код по продаже ссылок. Убедитесь, что размещали его вы:";
  $l_Result .= printList($g_AdwareList);
  $l_Result .= "</div>";

}

if (count($g_EmptyLink) > 0 && SCAN_ALL_FILES) {
  $l_ShowOffer = true;

  $l_Result .= "<div class=\"warn\">В этих файлах размещены невидимые ссылки. Подозрение на ссылочный спам:<ul><li>";
  $l_Result .= printList($g_EmptyLink);
  $l_Result .= "</div>";

}

if (count($g_Doorway) > 0) {
  $l_ShowOffer = true;

  $l_Result .= "<div class=\"warn\">Найдены директории, в которых подозрительно много файлов .php или .html. Подозрение на дорвей:";
  $l_Result .= printList($g_Doorway);
  $l_Result .= "</div>";

}

if (count($g_WarningPHP) > 0) {
  $l_ShowOffer = true;

  $l_Result .= "<div class=\"warn\">Скрипт использует код, которые часто используются во вредоносных скриптах:";


  $l_Result .= printList($g_WarningPHP, $g_WarningPHPFragment);
  $l_Result .= "</div>";

} else {

  $l_Result .= '<div class="ok">Подозрительные скрипты не найдены</div>';

}

if (count($g_WritableDirectories) > 0) {

  $l_Result .= "<div class=\"warn2\">Потенциально небезопасно! Директории, доступные скрипту на запись:";
  $l_Result .= printList($g_WritableDirectories);
  $l_Result .= "</div>";

} else {

  $l_Result .= '<div class="ok">Не найдено директорий, доступных на запись скриптом</div>';

}

$max_size_to_scan = getBytes(MAX_SIZE_TO_SCAN);
$max_size_to_scan = $max_size_to_scan > 0 ? $max_size_to_scan : getBytes('1m');

if (count($$g_BigFiles) > 0) {

  $l_Result .= "<div class=\"warn2\">Большие файлы (больше чем " . bytes2Human($max_size_to_scan) . "! Пропущено:";
  $l_Result .= printList($g_BigFiles);
  $l_Result .= "</div>";

} else {

  $l_Result .= '<div class="ok">Не найдено файлов больше чем ' . bytes2Human($max_size_to_scan) . '</div>';

}

if (!SCAN_ALL_FILES) {
  $l_Result .= '<div class="notice"><span class="vir">[!]</span> В скрипте отключено полное сканирование файлов, проверяются только .php, .html, .htaccess. Чтобы выполнить более тщательное сканирование, <br/>поменяйте значение настройки на <b>\'scan_all_files\' => 1</b> в самом верху скрипта. Скрипт в этом случае может работать очень долго. Рекомендуется отключить на хостинге лимит по времени выполнения, либо запускать скрипт из командной строки.</div>';
}

$l_Result .= '<div class="footer"><div class="disclaimer"><span class="vir">[!]</span> Отказ от гарантий: даже если скрипт не нашел вредоносных скриптов на сайте, автор не гарантирует их полное отсутствие, а также не несет ответственности за возможные последствия работы скрипта ai-bolit.php или неоправданные ожидания пользователей относительно функциональности и возможностей.</div>';
$l_Result .= '<div class="thanx">Замечания и предложения по работе скрипта присылайте на <a href="mailto:audit@revisium.com">audit@revisium.com</a>.<p>Также буду чрезвычайно благодарен за любые упоминания скрипта ai-bolit на вашем сайте, в блоге, среди друзей, знакомых и клиентов. Ссылочку можно поставить на <a href="http://revisium.com/ai/">http://revisium.com/ai/</a>. <p>Если будут вопросы - пишите <a href="mailto:audit@revisium.com">audit@revisium.com</a>. Кстати, еще я написал <a href="http://sale.qpl.ru/">скрипт доски объявлений</a> и собрал точную <a href="http://gzq.ru/">базу IP</a> по городам России.</div>';
$l_Result .= '</div>';

if ($l_ShowOffer) {
  print '<div class="offer">' .
        'Не уверены, как правильно <b>очистить сервер от вредоносного ПО</b>? Напишите мне через <a href="http://www.revisium.com/ru/contacts/">форму на сайте</a> или на email: <a href="mailto:audit@revisium.com">audit@revisium.com</a>. Помогу за небольшое денежное вознаграждение.<p>' .
        'Если скрипт оказался вам полезен, <br><a href="http://revisium.com/ai/others.php"><b>поддержите проект материально</b></a>. Спасибо.' .
        '</div>';
}

////////////////////////////////////////////////////////////////////////////
print $l_Result;

$l_Result = ob_get_clean();

if (!isCli())
{
	echo $l_Result;
	exit;
}

if (!defined('REPORT') OR REPORT === '')
{
	die('Report not written.');
}

$emails = getEmails(REPORT);

if (!$emails)
{
	if (defined('REPORT_PATH') AND REPORT_PATH)
	{
		if (!is_writable(REPORT_PATH))
		{
			stdOut("\nCannot write report. Report dir " . REPORT_PATH . " is not writable.");
		}

		else if (!REPORT_FILE)
		{
			stdOut("\nCannot write report. Report filename is empty.");
		}

		else if (($file = REPORT_PATH . DIRECTORY_SEPARATOR . REPORT_FILE) AND is_file($file) AND !is_writable($file))
		{
			stdOut("\nCannot write report. Report file '$file' exists but is not writable.");
		}

		else
		{
			file_put_contents($file, $l_Result);
			stdOut("\nReport written to '$file'.");
		}
	}
}
else
{
	$headers = array(
		'MIME-Version: 1.0',
		'Content-type: text/html; charset=UTF-8',
		'From: ' . ($defaults['email_from'] ? $defaults['email_from'] : 'AI-Bolit@myhost')
	);

	for ($i = 0, $size = sizeof($emails); $i < $size; $i++)
	{
		@mail($emails[$i], 'AI-Bolit Report ' . date("d/m/Y H:i", time()), $l_Result, implode("\r\n", $headers));
	}

	stdOut("\nReport sended to " . implode(', ', $emails));
}

$time_taken = microtime(true) - START_TIME;
$time_taken = number_format($time_taken, 5);
stdOut("Scanning complete! Time taken: " . seconds2Human($time_taken));

