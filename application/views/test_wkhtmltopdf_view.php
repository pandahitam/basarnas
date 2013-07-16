<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<script language="javascript">

// Check OS CLIENT
// This script sets OSName variable as follows:
// "Windows"    for all versions of Windows
// "MacOS"      for all versions of Macintosh OS
// "Linux"      for all versions of Linux
// "UNIX"       for all other UNIX flavors 
// "Unknown OS" indicates failure to detect the OS

var OSName="Unknown OS";
if (navigator.appVersion.indexOf("Win")!=-1) OSName="Windows";
if (navigator.appVersion.indexOf("Mac")!=-1) OSName="MacOS";
if (navigator.appVersion.indexOf("X11")!=-1) OSName="UNIX";
if (navigator.appVersion.indexOf("Linux")!=-1) OSName="Linux";

//document.write('Your OS: '+OSName);

</script>

<?php 
$config['paper_size'] = "A4";
$config['orientation'] = "Landscape";
$config['T'] = 15;
$config['B'] = 15;
$config['L'] = 15;
$config['R'] = 15;

$text_footer = "Dicetak Tanggal : ".$this->Functions_Model->Tanggal_Indo(date("Y-m-d")).", ";
date_default_timezone_set('Asia/Jakarta');
$text_footer .= "Jam : ".date("H:i:s").", ";
$text_footer .= "Oleh : ".$this->session->userdata("fullname_zs_simpeg");

$config['text_footer_left'] = $text_footer;
$config['footer_right_numbering'] = true;
$config['footer_line'] = true;
wkhtmltopdf_create($config, "TEST");
?>