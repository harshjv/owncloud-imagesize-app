<?php

namespace OCA\ImageSize\AppInfo;

use OC\Files\View;
use OCA\ImageSize\Hook\FileHook;
use OCP\AppFramework\App;
use OCP\IContainer;

use OCA\ImageSize\Db\ImageSizeMapper;

class Application extends App {
  public function __construct () {
    parent::__construct('imagesize');
    $container = $this->getContainer();

    $container->registerService('ImageSizeMapper', function($c){
      return new ImageSizeMapper(
        $c->query('ServerContainer')->getDb()
      );
    });

    $container->registerService('FileHook', function($c) {
      $server = $c->query('ServerContainer');
      $root = $server->getRootFolder();

      return new FileHook(
        $server,
        $root,
        $c->query('Logger'),
        $c->query('AppName'),
        $c->query('ImageSizeMapper')
      );
    });

    $container->registerService('Logger', function($c) {
      return $c->query('ServerContainer')->getLogger();
    });
  }
}
