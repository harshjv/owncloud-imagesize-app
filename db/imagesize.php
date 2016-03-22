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

use JsonSerializable;

use OCP\AppFramework\Db\Entity;

class ImageSize extends Entity implements JsonSerializable {
    protected $fileId;
    protected $originalHeight;
    protected $originalWidth;

    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'fileId' => $this->fileId,
            'originalHeight' => $this->$originalHeight,
            'originalWidth' => $this->$originalWidth
        ];
    }
}
