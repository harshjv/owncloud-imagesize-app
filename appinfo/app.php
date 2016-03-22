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

$app = new Application();
$container = $app->getContainer();
$container->query('FileHook')->register();
