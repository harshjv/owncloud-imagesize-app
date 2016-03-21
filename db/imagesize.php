<?php
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
