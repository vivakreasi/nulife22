<?php

namespace App;

use Validator;

class Berkas {

    /*
     *  Image
     */

    public static function getExtentionFile($objfile) {
        $result = $objfile->getMimeType();
        return explode('/', $result)[1];
    }

    public static function FileUploaded($inputFile, &$filename) {
        try {
            if (!empty($inputFile)) {
                $filename   = $inputFile->getRealPath();
            }
            return (!empty($inputFile) && $filename != '');
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function isAllowedImage($keyname, $objfile, $format, $size) {
        $data   = array($keyname => $objfile);
        $rule   = array($keyname => 'required|mimes:' . $format . '|image|max:' . $size);
        $validator = Validator::make($data, $rule);
        return (object) array(
            'Validator' => $validator,
            'Success'   => $validator->passes()
        );
    }

    public static function doUpload($objfile, $path, $filename) {
        if ($objfile->isValid()) {
            try {
                $objfile->move($path, $filename);
                return true;
            } catch (\Exception $e) {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function LoadImage($FileName) {
        $result     = (object) array('FileName' => '', 'FileType' => '');
        if ($FileName == '') { return $result; }
        if(!file_exists($FileName)){
            return $result;
        }
        if (filetype($FileName) != 'file') {
            return $result;
        }
        $InfoFile = exif_imagetype($FileName);
        if ($InfoFile != IMAGETYPE_JPEG && $InfoFile != IMAGETYPE_PNG) return $result;
        $result->FileName   = $FileName;
        $result->FileType   = ($InfoFile == IMAGETYPE_JPEG) ? 'image/jpeg' : 'image/png';
        return $result;
    }

    /*
     *  End Image
     */
}
