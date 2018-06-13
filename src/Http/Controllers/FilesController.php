<?php

namespace Cogroup\Cms\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Cogroup\Cms\Models\Files;
use Illuminate\Http\Response;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FilesController extends Controller {
  public function processFile($id) {
    $file = Files::select('*')->where("id", "=", $id)->first();

    if($file->ispublic == false and !Auth::check()) :
      return abort(404);
    endif;
    return response()->file(storage_path("app/private/".$file->folder."/".$file->diskname));
  }

  public function processFileThumb($id, $width = 240, $height = 360, $const = true) {
    $file = Files::select('*')->where("id", "=", $id)->first();
    if($file->folder == 'images') :
      if($const == true) :
        if(!file_exists(storage_path("app/files/" . $file->folder . "/thumbs/" . $height."_".$width."_".$file->diskname))) :
          $manager = \ImageManager::canvas($width, $height)
                      ->insert(
                        \ImageManager::make(storage_path("app/private/".$file->diskname))
                        ->heighten($height, function ($constraint) use ($const) {
                          if($const == true) :
                            $constraint->aspectRatio();
                          endif;
                        }), 'center'
                      )->save(storage_path("app/files/".$file->folder."/thumbs/".$height."_".$width."_".$file->diskname));
        endif;
        return response()->file(storage_path("app/files/".$file->folder."/thumbs/".$height."_".$width."_".$file->diskname));
      else :
        if(!file_exists(storage_path("app/files/" . $file->folder . "/thumbs/" . $width."_".$height."_".$file->diskname))) :
          $manager = \ImageManager::canvas($width, $height)
                      ->insert(
                        \ImageManager::make(storage_path("app/private/".$file->diskname))
                        ->widen($width, function ($constraint) use ($const) {
                          if($const == true) :
                            $constraint->aspectRatio();
                          endif;
                        }), 'center'
                      )->save(storage_path("app/files/".$file->folder."/thumbs/".$width."_".$height."_".$file->diskname));
        endif;
        return response()->file(storage_path("app/files/".$file->folder."/thumbs/".$width."_".$height."_".$file->diskname));
      endif;
    else :
      return response()->file(storage_path("app/private/".$file->diskname));
    endif;
  }

  public static function upload($request, $name) {
    // checking file is valid.
    if($request->file($name)->isValid()) :
      $mime = substr($request->{$name}->getClientMimeType(), 0, 5);
      $path = file_exists(storage_path("app/files/".$request->{$name}->hashName()));
      if($path == true) :
        return array('status' => false, 'msg' => 'files.fileexists');
      endif;
      $path = $request->{$name}->store('private');
      $path = explode("/", $path);
      $path = $path[count($path) - 1];
      $id = $request->input($name.'_id');
      $filemodel = Files::firstOrNew(['id' => $id]);
      if(!empty($id) and !is_null($id)) $filemodel->id = $id;
      $filemodel->diskname = $path;
      $filemodel->originalname = $request->{$name}->getClientOriginalName();
      $filemodel->extension = $request->{$name}->extension();
      $filemodel->size = $request->{$name}->getClientSize();
      $filemodel->mimetype = $request->{$name}->getClientMimeType();
      $filemodel->alt = (!empty($request->input('alt'))) ? $request->input('alt') : env("APP_NAME");
      if(stripos($request->{$name}->getClientMimeType(), 'image') !== false) :
        $filemodel->height = self::getAttribute($filemodel, 'height');
        $filemodel->width = self::getAttribute($filemodel, 'width');
      else :
        $filemodel->height = $filemodel->width = 0;
      endif;
      $filemodel->save();
      return array('status' => true, 'id' => $filemodel->id);
    else :
      return array('status' => false, 'msg' => 'file invalid');
    endif;
  }

  private static function getAttribute($file, $attribute) {
    $manager = \ImageManager::make(storage_path("app/private/".$file->diskname));
    return $manager->{$attribute}();
  }

  public static function getMaxSize($format = 'b') {
    $val = ini_get('upload_max_filesize');
    $val = trim($val);
    $last = strtolower($val[strlen($val)-1]);
    $val = preg_replace("/[^0-9,.]/", "", $val);
    switch($last) {
        // El modificador 'G' está disponble desde PHP 5.1.0
        case 'g':
            $val *= 1024 * 1024 * 1024; break;
        case 'm':
            $val *= 1024 * 1024; break;
        case 'k':
            $val *= 1024; break;
    }

    switch($format) :
      case 'g' : return $val / 1024 / 1024 / 1024;
      case 'm' : return $val / 1024 / 1024;
      case 'k' : return $val / 1024;
      case 'b' : return $val;
    endswitch;
  }

  public static function delete($id) {
    $file = Files::find($id);
    Files::where('id', $id)->delete();
    Storage::delete("private/".$file->folder.'/'.$file->diskname);
  }
}
