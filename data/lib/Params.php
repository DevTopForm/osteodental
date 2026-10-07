<?php
namespace App;

class Params {
	private function __construct() {}

	private function __clone() {}

	public static $params = array();

	public static function init() {
		self::$params['public']['site']['protocol'] = (empty($_SERVER['HTTPS'])) ? 'http://' : 'https://';
		self::$params['public']['site']['host'] = $_SERVER['HTTP_HOST'];

		self::$params['root_path'] = $_SERVER['DOCUMENT_ROOT'] .'/';

		self::$params['adm_dir'] = 'adm';
		self::$params['adm_path'] = self::$params['root_path'] .self::$params['adm_dir'] .'/';
		self::$params['adm_http'] = '/adm';

		self::$params['adm_htdocs_dir'] = 'adm/htdocs';
		self::$params['adm_htdocs_path'] = self::$params['root_path'] .self::$params['adm_htdocs_dir'] .'/';
		self::$params['adm_htdocs_http'] = '/adm/htdocs';

		self::$params['common_dir'] = 'common';
		self::$params['common_path'] = self::$params['root_path'] .self::$params['common_dir'] .'/';
		self::$params['common_http'] = '/common';

		self::$params['common_htdocs_dir'] = 'common/htdocs';
		self::$params['common_htdocs_path'] = self::$params['root_path'] .self::$params['common_htdocs_dir'] .'/';
		self::$params['common_htdocs_http'] = '/common/htdocs';

		self::$params['cache_dir'] = 'cache';
		self::$params['cache_path'] =  self::$params['root_path'] .self::$params['cache_dir'] .'/';

		self::$params['upload_dir'] = 'upload';
		self::$params['upload_path'] = self::$params['root_path'] .self::$params['upload_dir'] .'/';
		self::$params['upload_http'] = '/' .self::$params['upload_dir'];


		self::$params['upload_images_path'] = self::$params['upload_path'] .'source/images/';
		self::$params['upload_images_http'] = self::$params['upload_http'] .'/thumbs/';
		self::$params['upload_images_http_path'] =Params::$params['root_path'].'/'.Params::$params['upload_dir'].'/thumbs/';

		self::$params['upload_files_path'] = self::$params['upload_path'] .'source/files/';
		self::$params['upload_files_http'] = self::$params['upload_http'] .'/source/files';


		self::$params['install_dir'] =  self::$params['root_path'] . 'data/install/';
		self::$params['install_modules'] =  self::$params['install_dir'] . 'modules';

		self::$params['KCFINDER'] = array(
			// GENERAL SETTINGS
		    'disabled' => false,
		    'uploadURL' => "/upload/",
		    'uploadDir' => "",
		    'theme' => "default",

		    'types' => array(
		        'filemanager' => "",
		    ),

			// IMAGE SETTINGS
		    'imageDriversPriority' => "gd imagick gmagick",
		    'jpegQuality' => 90,
		    'thumbsDir' => ".thumbs",

		    'maxImageWidth' => 2500,
		    'maxImageHeight' => 2500,

		    'thumbWidth' => 100,
		    'thumbHeight' => 100,

		    'watermark' => "",

			// DISABLE / ENABLE SETTINGS
		    'denyZipDownload' => false,
		    'denyUpdateCheck' => true,
		    'denyExtensionRename' => true,

			// PERMISSION SETTINGS
		    'dirPerms' => 0755,
		    'filePerms' => 0644,
		    'access' => array(
		        'files' => array(
		            'upload' => true,
		            'delete' => true,
		            'copy'   => true,
		            'move'   => true,
		            'rename' => true
		        ),
		        'dirs' => array(
		            'create' => true,
		            'delete' => true,
		            'rename' => true
		        )
		    ),
		    'deniedExts' => "exe com msi bat cgi pl php phps phtml php3 php4 php5 php6 py pyc pyo pcgi pcgi3 pcgi4 pcgi5 pchi6",

			// MISC SETTINGS
		    'filenameChangeChars' => array(
		        ' ' => "-",
		        ':' => "."
		    ),

		    'dirnameChangeChars' => array(
		        ' ' => "-",
		        ':' => "."
		    ),

		    'mime_magic' => "",

		    'cookieDomain' => "",
		    'cookiePath' => "",
		    'cookiePrefix' => 'KCFINDER_',

			// THE FOLLOWING SETTINGS CANNOT BE OVERRIDED WITH SESSION SETTINGS
		    '_normalizeFilenames' => false,
		    '_check4htaccess' => false,
		    '_tinyMCEPath' => self::$params['adm_htdocs_http']."/js/tinymce",

		    '_sessionVar' => "KCFINDER",
		    //'_sessionLifetime' => 30,
		    //'_sessionDir' => "/full/directory/path",
		    //'_sessionDomain' => ".mysite.com",
		    //'_sessionPath' => "/my/path",

		    //'_cssMinCmd' => "java -jar /path/to/yuicompressor.jar --type css {file}",
		    //'_jsMinCmd' => "java -jar /path/to/yuicompressor.jar --type js {file}",
		);
	}
}
?>
