<?php
namespace App\Contracts\Image;

interface ImageContract {

    public function make($path);

    public function resize($width, $height, $callback);

    public function save($path, $quality, $format);
}
