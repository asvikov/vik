<?php
namespace App\Services;

use App\Contracts\Image\ImageContract;

class ImageService implements ImageContract {

    protected $options = [
        'width' => 200,
        'height' => 200
    ];
    protected $image_resource;

    public function setOptions($options = []) {

        $merge_arr = array_merge($this->options, $options);
        $this->options = $merge_arr;
    }

    public function make($path) {

        $image_options = [];
        $image_options['path_origin'] = $path;
        $image_options['mime_type'] = mime_content_type($image_options['path_origin']);
        $get_image_size = getimagesize($image_options['path_origin']);
        $image_options['width_source'] = $get_image_size[0];
        $image_options['height_source'] = $get_image_size[1];

        switch ($image_options['mime_type']) {
            case 'image/jpeg':
                $src_img = imagecreatefromjpeg($image_options['path_origin']);
                break;
            case 'image/png':
                $src_img = imagecreatefrompng($image_options['path_origin']);
                break;
            case 'image/gif':
                $src_img = imagecreatefromgif($image_options['path_origin']);
                break;
            default:
                $src_img = imagecreatetruecolor($image_options['width'], $image_options['height']);
        }
        $this->image_resource = $src_img;
        $this->setOptions($image_options);
        return $this;
    }

    public function resize($width, $height, $callback = null) {

        $this->options['width'] = $width;
        $this->options['height'] = $height;
        return $this;
    }

    public function save($path, $quality = 90, $format = null) {

        $dst_img = imagecreatetruecolor($this->options['width'], $this->options['height']);
        $is_resized = imagecopyresized($dst_img, $this->image_resource, 0, 0, 0, 0, $this->options['width'], $this->options['height'], $this->options['width_source'], $this->options['height_source']);

        if($is_resized) {
            switch ($this->options['mime_type']) {
                case 'image/jpeg':
                    imagejpeg($dst_img, $path);
                    break;
                case 'image/png':
                    imagepng($dst_img, $path);
                    break;
                case 'image/gif':
                    imagegif($dst_img, $path);
                    break;
                default:
                    $dst_img = imagecreatetruecolor($this->options['width'], $this->options['height']);
                    imagejpeg($dst_img, $path);
            }
        }
        imagedestroy($this->image_resource);
        imagedestroy($dst_img);

        return $this;
    }
}
