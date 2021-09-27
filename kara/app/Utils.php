<?php
namespace App;


use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class Utils
{
    public static function uploadImageFile($imgFile)
    {
        $resizeWidth = 500;
        $resizeHeight = 400;
        $filenametostore = md5(md5(microtime().rand(1000,9999))). '.jpeg';

//        if (!file_exists(public_path('storage/images/origin'))) {
//            mkdir(public_path('storage/images/origin'), 0777,true);
//        }
        if (!file_exists(public_path('storage/images/resize'))) {
            mkdir(public_path('storage/images/resize'), 0777,true);
        }
        if (!file_exists(public_path('storage/images/thumbnail'))) {
            mkdir(public_path('storage/images/thumbnail'), 0777,true);
        }
        if (!file_exists(public_path('storage/images/base64'))) {
            mkdir(public_path('storage/images/base64'), 0777,true);
        }

//        $imgFile->storeAs('public/images/origin', $filenametostore);

        $img = base64_encode(file_get_contents($imgFile));
        file_put_contents(public_path("storage/images/base64/".$filenametostore),$img);

        $imgResize = Image::make($imgFile->getRealPath())->resize($resizeWidth, $resizeHeight);
        $resizePath = public_path('storage/images/resize/' . $filenametostore);
//        ->insert("assets/img/logo.png","bottom-right")
        $imgResize->save($resizePath);

        $thumbnailPath = public_path("storage/images/thumbnail/".$filenametostore);
        $imgThumbnail = Image::make($imgFile->getRealPath())->resize(60,50);
        $imgThumbnail->save($thumbnailPath);

        $filePath = MekaraConfig:: BASE_URL . "storage/images/resize/" . $filenametostore;
        return $filePath;
    }
    public static function uploadImageString($imgString)
    {
        $resizeWidth = 500;
        $resizeHeight = 400;
        $img = base64_decode($imgString);
        $filenametostore = md5(md5(microtime().rand(1000,9999))). '.jpeg';

//        if (!file_exists(public_path('storage/images/origin'))) {
//            mkdir(public_path('storage/images/origin'), 0777,true);
//        }

        if (!file_exists(public_path('storage/images/resize'))) {
            mkdir(public_path('storage/images/resize'), 0777,true);
        }
        if (!file_exists(public_path('storage/images/thumbnail'))) {
            mkdir(public_path('storage/images/thumbnail'), 0777,true);
        }
        if (!file_exists(public_path('storage/images/base64'))) {
            mkdir(public_path('storage/images/base64'), 0777,true);
        }

        file_put_contents(public_path("storage/images/base64/".$filenametostore),$imgString);

//        $imgOrigin = Image::make($img);
//        $originPath = public_path('storage/images/origin/' . $filenametostore);
//        $imgOrigin->save($originPath);

        $imgResize = Image::make($img)->resize($resizeWidth, $resizeHeight);
        $resizePath = public_path('storage/images/resize/' . $filenametostore);
//        ->insert("assets/img/logo.png","bottom-right")
        $imgResize->save($resizePath);

        $thumbnailPath = public_path("storage/images/thumbnail/".$filenametostore);
        $imgThumbnail =  Image::make($img)->resize(60,50);
        $imgThumbnail->save($thumbnailPath);

        $filePath = MekaraConfig:: BASE_URL . "storage/images/resize/" . $filenametostore;
        return $filePath;

    }
    public static function uploadImageFileBlog($imgFile)
    {
        $resizeWidth = 850;
        $resizeHeight = 450;
        $filenametostore = md5(md5(microtime().rand(1000,9999))). '.jpeg';

        if (!file_exists(public_path('storage/images/resize'))) {
            mkdir(public_path('storage/images/resize'), 0777,true);
        }
        if (!file_exists(public_path('storage/images/thumbnail'))) {
            mkdir(public_path('storage/images/thumbnail'), 0777,true);
        }

        $imgResize = Image::make($imgFile->getRealPath())->resize($resizeWidth, $resizeHeight);
        $resizePath = public_path('storage/images/resize/' . $filenametostore);
        $imgResize->save($resizePath);

        $thumbnailPath = public_path("storage/images/thumbnail/".$filenametostore);
        $imgThumbnail = Image::make($imgFile->getRealPath())->resize(60,50);
        $imgThumbnail->save($thumbnailPath);

        $filePath = MekaraConfig:: BASE_URL . "storage/images/resize/" . $filenametostore;
        return $filePath;
    }
    public static function deleteImagePost($image)
    {
        $imageName = getImageName($image);
        if ($imageName):
//            Storage::delete("public/images/origin/".$imageName);
            Storage::delete("public/images/resize/".$imageName);
            Storage::delete("public/images/thumbnail/".$imageName);
            Storage::delete("public/images/base64/".$imageName);
        endif;
    }

    
}