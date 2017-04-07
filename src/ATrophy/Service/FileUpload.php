<?php
// src/ATrophy/Service/FileUpload.php
namespace ATrophy\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile,
    Symfony\Component\Filesystem\Filesystem,
    Symfony\Component\HttpFoundation\Session\Session;

class FileUpload
{
    private $_filesystem;

    public function __construct(Session $session)
    {
        $this->_filesystem = new Filesystem;
        $this->_session    = $session;
    }

    public function checkUploadedImage(UploadedFile $image, $directory)
    {
        $mimeTypes = [
            "image/jpg",
            "image/jpeg",
            "image/png"
        ];

        $extensions = [
            "jpg",
            "jpeg",
            "png"
        ];

        $maxSize = 2 * 1024 * 1024;

        if( !in_array($image->getMimeType(), $mimeTypes, TRUE) ) {
            return FALSE;
        }

        if( !in_array($image->guessExtension(), $extensions, TRUE) ) {
            return FALSE;
        }

        if( $image->getSize() > $maxSize ) {
            return FALSE;
        }

        if( (disk_free_space($directory) - $image->getSize()) < $image->getSize() ) {
            return FALSE;
        }

        return TRUE;
    }

    public function saveProductImage(UploadedFile $image, $productId, $postfix = NULL)
    {
        $base = realpath(WEB_DIRECTORY . "/bundles/atrophymeat/images/store/products");

        if( !$this->checkUploadedImage($image, $base) ) {
            return FALSE;
        }

        $path = "{$base}/{$productId}";
        $name = "{$productId}{$postfix}" . "." . $image->guessExtension();

        $image->move($path, $name);

        $image  = "{$path}/{$name}";
        $thumb  = "{$path}/thumb_{$name}";
        $square = "{$path}/square_{$name}";

        //---

        $magicImage = new \Imagick();

        $magicImage->readImage($image);

        $magicImage->scaleImage(500, 500, TRUE);

        $magicImage = $this->extentImage($magicImage, 500, 500);

        $magicImage->writeImage($square);

        $magicImage->readImage($image);

        $magicImage->scaleImage(250, 150, TRUE);

        $magicImage = $this->extentImage($magicImage, 250, 150);

        $magicImage->writeImage($thumb);

        return [
            'image'       => basename($image),
            'imageSquare' => basename($square),
            'imageThumb'  => basename($thumb)
        ];
    }

    public function saveAddonImage(UploadedFile $image, $addonType, $addonId)
    {
        switch( $addonType )
        {
            case 'token':
                $directory = 'tokens';
            break;

            case 'ribbon':
                $directory = 'ribbons';
            break;

            case 'box':
                $directory = 'boxes';
            break;

            default:
                return FALSE;
            break;
        }

        $base = realpath(WEB_DIRECTORY . "/bundles/atrophymeat/images/store/addons");

        if( !$this->checkUploadedImage($image, $base) ) {
            return FALSE;
        }

        $path = "{$base}/{$directory}";
        $name = "{$addonId}." . $image->guessExtension();

        $image->move($path, $name);

        $image  = "{$path}/{$name}";

        $magicImage = new \Imagick();

        $magicImage->readImage($image);

        $magicImage->scaleImage(200, 200, TRUE);

        $magicImage = $this->extentImage($magicImage, 200, 200);

        $magicImage->writeImage($image);

        return [
            'image' => basename($image)
        ];
    }

    public function saveNewsImage(UploadedFile $image, $newsId)
    {
        $base = realpath(WEB_DIRECTORY . "/bundles/atrophymeat/images/news");

        if( !$this->checkUploadedImage($image, $base) ) {
            return FALSE;
        }

        $path = $base;
        $name = "{$newsId}." . $image->guessExtension();

        $image->move($path, $name);

        $image  = "{$path}/{$name}";
        $thumb  = "{$path}/thumb_{$name}";

        //---

        $magicImage = new \Imagick();

        $magicImage->readImage($image);

        $magicImage->scaleImage(600, 0);

        $magicImage->writeImage($image);

        $magicImage->readImage($image);

        $magicImage->scaleImage(300, 200, TRUE);

        $magicImage->setImageBackgroundColor(new \ImagickPixel('#f7f7f7'));

        $magicImage = $this->extentImage($magicImage, 300, 200);

        $magicImage->writeImage($thumb);

        return [
            'imageOriginal' => basename($image),
            'imageThumb'    => basename($thumb)
        ];
    }

    public function savePromotionImage(UploadedFile $image)
    {
        $base = realpath(WEB_DIRECTORY . "/bundles/atrophymeat/images/slider");

        if( !$this->checkUploadedImage($image, $base) ) {
            return FALSE;
        }

        $path = $base;
        $name = uniqid('', TRUE) . "." . $image->guessExtension();

        $image->move($path, $name);

        $image = "{$path}/{$name}";

        $magicImage = new \Imagick();

        $magicImage->readImage($image);

        $magicImage->scaleImage(750, 300, TRUE);

        $magicImage = $this->extentImage($magicImage, 750, 300);

        $magicImage->writeImage($image);

        return basename($image);
    }

    public function removeProductImages($productId, array $images = NULL)
    {
        $base = realpath(WEB_DIRECTORY . "/bundles/atrophymeat/images/store/products");

        if( $images ) {
            foreach ($images as $image) {
                if( empty($image) )
                    continue;

                $image = "{$base}/{$productId}/{$image}";

                if ($this->_filesystem->exists($image)) {
                    $this->_filesystem->remove($image);
                }
            }
        } else {
            $directory = "{$base}/{$productId}";

            if ($this->_filesystem->exists($directory)) {
                $this->_filesystem->remove($directory);
            }
        }
    }

    public function removeAddonImage($addonType, $image)
    {
        if( empty($image) )
            return FALSE;

        switch( $addonType )
        {
            case 'token':
                $directory = 'tokens';
            break;

            case 'ribbon':
                $directory = 'ribbons';
            break;

            case 'box':
                $directory = 'boxes';
            break;

            default:
                return FALSE;
            break;
        }

        $base = realpath(WEB_DIRECTORY . "/bundles/atrophymeat/images/store/addons");

        $image = "{$base}/{$directory}/{$image}";

        if ($this->_filesystem->exists($image)) {
            $this->_filesystem->remove($image);
        }
    }

    public function removeNewsImage(array $images)
    {
        $base = realpath(WEB_DIRECTORY . "/bundles/atrophymeat/images/news");

        foreach ($images as $image) {
            if( empty($image) )
                continue;

            $image = "{$base}/{$image}";

            if ($this->_filesystem->exists($image)) {
                $this->_filesystem->remove($image);
            }
        }
    }

    public function removePromotionImage($image)
    {
        if( empty($image) )
            return FALSE;

        $base = realpath(WEB_DIRECTORY . "/bundles/atrophymeat/images/slider");

        $image = "{$base}/{$image}";

        if ($this->_filesystem->exists($image)) {
            $this->_filesystem->remove($image);
        }
    }

    private function extentImage($magicImage, $desiredWidth, $desiredHeight)
    {
        $geometry = $magicImage->getImageGeometry();
        $width  = $geometry['width'];
        $height = $geometry['height'];

        if( $width < $desiredWidth ) {
            $twitch = ($desiredWidth - $width) / 2;
            $magicImage->extentImage($desiredWidth, $desiredHeight, 0 - $twitch, 0);
        } elseif( $height < $desiredHeight ) {
            $twitch = ($desiredHeight - $height) / 2;
            $magicImage->extentImage($desiredWidth, $desiredHeight, 0, 0 - $twitch);
        }

        return $magicImage;
    }

    public function saveUploadedFile(UploadedFile $image, $folder, $tmpFolder, $fileName)
    {
        $base = realpath(WEB_DIRECTORY . "/bundles/atrophymeat/images");

        if( !$this->checkUploadedImage($image, $base) ) {
            return FALSE;
        }

        $path = "{$base}/{$folder}/{$tmpFolder}";
        $name = $fileName . '.' . $image->guessExtension();

        $image->move($path, $name);

        if( $image->getError() ) {
            return FALSE;
        }

        return "{$tmpFolder}/{$name}";
    }

    public function transferTmpImages($orderId, $orderItems)
    {
        $base = realpath(WEB_DIRECTORY . "/bundles/atrophymeat/images");

        foreach($orderItems as $key => $item)
        {
            foreach($item['addons'] as $addonName => $addon)
            {
                if( !empty($addon['data']['image']) )
                {
                    $oldFile = $addon['data']['image'];
                    $newFile = "tmp/post_order/{$orderId}/" . basename($oldFile);

                    if(  $this->_filesystem->exists("{$base}/{$oldFile}") ) {
                        $this->_filesystem->copy("{$base}/{$oldFile}", "{$base}/{$newFile}", TRUE);
                        $orderItems[$key]['addons'][$addonName]['data']['image'] = $newFile;
                    }
                }
            }
        }

        $this->removeTmpImages();

        return $orderItems;
    }

    private function removeTmpImages()
    {
        $this->_session->start();

        $folder = $this->_session->getId();

        $directory = realpath(WEB_DIRECTORY . "/bundles/atrophymeat/images/tmp/pre_order/" . $folder);

        if( $this->_filesystem->exists($directory) ) {
            $this->_filesystem->remove($directory);
        }
    }
}