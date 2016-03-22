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

namespace OCA\ImageSize\Db;

use OCP\IDb;
use OCP\AppFramework\Db\Mapper;

class ImageSizeMapper extends Mapper {
  public function __construct(IDb $db) {
    parent::__construct($db, 'image_size', '\OCA\ImageSize\Db\ImageSize');
  }

  public function find($file_id) {
    $sql = 'SELECT * FROM *PREFIX*image_size WHERE file_id = ?';
    return $this->findEntity($sql, [$file_id]);
  }
}
