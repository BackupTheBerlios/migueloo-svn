<?php

/* vim: set expandtab tabstop=4 shiftwidth=4:
  +----------------------------------------------------------------------+
  | CLAROLINE version 1.3.0 $Revision: 1.1 $                             |
  +----------------------------------------------------------------------+
  | Copyright (c) 2000, 2001 Universite catholique de Louvain (UCL)      |
  +----------------------------------------------------------------------+
  | $Id: filedisplay.class.php,v 1.1 2004/08/09 21:45:36 chet Exp $  |
  +----------------------------------------------------------------------+
  | This source file is subject to the GENERAL PUBLIC LICENSE,           |
  | available through the world-wide-web at                              |
  | http://www.gnu.org/copyleft/gpl.html                                 |
  +----------------------------------------------------------------------+
  | Authors: Thomas Depraetere <depraetere@ipm.ucl.ac.be>                |
  |          Hugues Peeters    <peeters@ipm.ucl.ac.be>                   |
  |          Christophe Gesch�<gesche@ipm.ucl.ac.be>                    |
  +----------------------------------------------------------------------+
*/

class fileDisplay 
{

/**
 * Define the image to display for each file extension
 * This needs an existing image repository to works
 *
 * @author - Hugues Peeters <peeters@ipm.ucl.ac.be>
 * @param  - fileName (string) - name of a file
 * @retrun - the gif image to chose
 */

function choose_image($fileName)
{
	/*** Tables initiliasation ***/
	if (!$type || !$image) {
        $type['text'] = array( "txt" );
		$type['word'] = array("doc", "dot", "rtf", "mcw", "wps", "sxw", "txt" );
		$type['web'] = array( "htm", "html", "htx", "xml", "xsl");
        $type['web_css'] = array("css");
        $type['web_php'] = array("php", "php3", "phps", "php3s");
        $type['web_pl'] = array("pl", "pls");
        $type['web_js'] = array("js");
        $type['web_flash'] = array("swf");
        $type['image_jpg'] = array("png", "jpg", "jpeg" );
        $type['image_bmp'] = array("bmp");
        $type['image_gif'] = array("gif");
		$type['audio'] = array("wav", "mp2", "mp4", "vqf", "ogg");
        $type['audio_mp3'] = array("mp3");
        $type['audio_mid'] = array("mid", "midi");
		$type['excel'] = array("sxc", "stc", "sdc", "vor", "xls", "xlt", "xls", "xlt");
		$type['compressed'] = array("zip", "tar", "gz", "gz", "bz", "bz2");
        $type['compressed_rar'] = array("rar");
		$type['code'] = array("cpp", "c", "java" );
		$type['acrobat'] = array("pdf", "ps");
		$type['powerpoint'] = array("ppt", "pps", "sxi", "sti", "sda", "sdd");
        $type['video_avi'] = array("avi");
        $type['video_mpeg'] = array("mpg", "mpeg");
        $type['video_mov'] = array("mov");
        $type['video_ram'] = array("ram");

        $image['text'] = "mime_txt.png";
		$image['word'] = "logo_word.jpg";//"mime_doc.png";
		$image['web'] = "logo_explorer.jpg";//"mime_html.png";
        $image['web_css'] = "mime_css.png";
        $image['web_php'] = "mime_php.png";
        $image['web_pl'] = "mime_pl.png";
        $image['web_js'] = "mime_js.png";
        $image['web_flash'] = "mime_flash.png";
		$image['image_jpg'] = "logo_imagen.jpg";//"mime_jpg.png";
        $image['image_bmp'] = "logo_imagen.jpg";//"mime_bmp.png";
        $image['image_gif'] = "logo_imagen.jpg";//"mime_gif.png"; 
		$image['audio'] = "mime_wav.png";
        $image['audio_mp3'] = "mime_mp3.png";
        $image['audio_mid'] = "mime_mid.png";
		$image['excel'] = "logo_excel.jpg";//"mime_xls.png";
		$image['compressed'] = "mime_zip.png";
        $image['compressed_rar'] = "mime_rar.png";
		$image['code'] = "mime_exe.png";
		$image['acrobat'] = "logo_acrobat.jpg";//"mime_pdf.png";
		$image['powerpoint'] = "logo_power.jpg";//"mime_ppt.png";
        $image['video_avi'] = "mime_avi.png";
        $image['video_mpeg'] = "mime_mpeg.png";
        $image['video_mov'] = "mime_mov.png";
        $image['video_ram'] = "mime_ram.png";
	}

	/*** function core ***/
	if (ereg("^([[:print:]]+)\.([[:alnum:]]+)$", $fileName, $extension)) {
		$extension[2] = strtolower ($extension[2]);

		foreach( $type as $genericType => $typeList) {
			if (in_array($extension[2], $typeList)) {
				return $image[$genericType];
			}
		}
	}

	return "mime_defaut.png";
}

//------------------------------------------------------------------------------

/**
 * Transform the file size in a human readable format
 *
 * @author - ???
 * @param  - fileSize (int) - size of the file in bytes
 */

function format_file_size($fileSize) {
	if($fileSize >= 1073741824) {
		$fileSize = round($fileSize / 1073741824 * 100) / 100 . "g";
	} elseif($fileSize >= 1048576) {
		$fileSize = round($fileSize / 1048576 * 100) / 100 . "m";
	} elseif($fileSize >= 1024) {
		$fileSize = round($fileSize / 1024 * 100) / 100 . "k";
	} else {
		$fileSize = $fileSize . "b";
	}

	return $fileSize;
}

//------------------------------------------------------------------------------


/**
 * Transform a UNIX time stamp in human readable format date
 *
 * @author - Hugues Peeters <peeters@ipm.ucl.ac.be>
 * @param - date - UNIX time stamp
 */

function format_date($fileDate)
{
	return date("d.m.Y", $fileDate);
}

}

?>
