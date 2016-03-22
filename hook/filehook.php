<?php
namespace OCA\ImageSize\Hook;

use OC\Files\Node\Root;
use OCP\Files\Node;

use OCA\ImageSize\Db\ImageSize;
use OCA\ImageSize\Db\ImageSizeMapper;

class FileHook {
  protected $root;
  protected $mapper;
  protected $dataDirectory;

  /**
	 * Constructor
   *
   * @param Root $root
   * @param ImageSizeMapper $mapper
   * @param string $dataDirectory
   */
  public function __construct(Root $root, ImageSizeMapper $mapper, $dataDirectory){
    $this->root = $root;
    $this->mapper = $mapper;
    $this->dataDirectory = $dataDirectory;
  }

  public function register() {
    $ref = $this;

    $callback = function (Node $node) use($ref) {
      $ref->handlePostCreate($node);
    };

    $this->root->listen('\OC\Files', 'postCreate', $callback);
  }

  public function handlePostCreate(Node $node) {
    $full_path = $this->dataDirectory . $node->getPath();

    $attributes = getimagesize($full_path);

    // getimagesize returns false if it fails to read attributes from the given file (i.e. invalid image)
    if($attributes !== false) {
      list($width, $height) = $attributes;

      $imageSize = new ImageSize();
      $imageSize->setFileId($node->getId());
      $imageSize->setOriginalHeight($height);
      $imageSize->setOriginalWidth($width);

      $this->mapper->insert($imageSize);
    }
  }
}
