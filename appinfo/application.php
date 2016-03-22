<?php
/**
 * ownCloud - imagesize
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Harsh Vakharia <harshjv@gmail.com>
 * @copyright Harsh Vakharia 2016
 */

namespace OCA\ImageSize\AppInfo;

use OCA\ImageSize\Hook\FileHook;
use OCP\AppFramework\App;
use OCP\IContainer;

use OCA\ImageSize\Db\ImageSizeMapper;

class Application extends App {
  public function __construct () {
    parent::__construct('imagesize');
    $container = $this->getContainer();

    $container->registerService('ImageSizeMapper', function(IContainer $c){
      return new ImageSizeMapper(
        $c->query('ServerContainer')->getDb()
      );
    });

    $container->registerService('FileHook', function(IContainer $c) {
      $server = $c->query('ServerContainer');

      return new FileHook(
        $server->getRootFolder(),
        $c->query('ImageSizeMapper'),
        $server->getConfig()->getSystemValue('datadirectory')
      );
    });
  }
}
