<?php

/** This file is part of KCFinder project
  *
  *      @desc Upload calling script
  *   @package KCFinder
  *   @version 2.51
  *    @author Pavel Tzonkov <pavelc@users.sourceforge.net>
  * @copyright 2010, 2011 KCFinder Project
  *   @license http://www.opensource.org/licenses/gpl-2.0.php GPLv2
  *   @license http://www.opensource.org/licenses/lgpl-2.1.php LGPLv2
  *      @link http://kcfinder.sunhater.com
  */

require "core/autoload.php";
$uploader = new uploader();

require getcwd() . '/../../../bootstrap/autoload.php';
$app = require_once getcwd() . '/../../../bootstrap/app.php';

$kernel = $app->make('Illuminate\Contracts\Http\Kernel');

$response = $kernel->handle(
  $request = Illuminate\Http\Request::capture()
);

$id = $app['encrypter']->decrypt($_COOKIE[$app['config']['session.cookie']]);
$app['session']->driver()->setId($id);
$app['session']->driver()->start();
if(!$app['auth']->check()){
  die('Akses Tidak Diijinkan Bro!');
}


$uploader->upload();

?>