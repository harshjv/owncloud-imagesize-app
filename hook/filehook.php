<?php
namespace OCA\ImageSize\Hook;

use OC\Files\Node\Root;
use OC\Server;
use OCP\Files\Node;
use \OCP\ILogger;

use OCA\ImageSize\Db\ImageSize;
use OCA\ImageSize\Db\ImageSizeMapper;

class FileHook {
  private static $server;
  private static $root;
  private static $logger;
  private static $appName;
  private static $mapper;

  public function __construct(Server $server, Root $root, ILogger $logger, $appName, ImageSizeMapper $mapper){
    self::$mapper = $mapper;
    self::$server = $server;
    self::$root = $root;
    self::$logger = $logger;
    self::$appName = $appName;
  }

  public static function register() {
    $callback = function (Node $node) {
      $full_path = self::$server->getConfig()->getSystemValue('datadirectory') . $node->getPath();
      $p = getimagesize($full_path);

      if($p !== false) {
        list($width, $height) = $p;

        $imageSize = new ImageSize();
        $imageSize->setFileId($node->getId());
        $imageSize->setOriginalHeight($height);
        $imageSize->setOriginalWidth($width);

        self::$mapper->insert($imageSize);
      }
  		else self::log('Uploaded file is not a valid image file');
    };

    self::$root->listen('\OC\Files', 'postCreate', $callback);
  }

  static protected function getService($name) {
	  $app = new \OCA\ImageSize\AppInfo\Application();
	  return $app->getContainer()->query($name);
  }

  public static function log($message) {
    self::$logger->info($message, array('app' => self::$appName));
  }
}
