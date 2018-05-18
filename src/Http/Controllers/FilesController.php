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
    return response()->file(storage_path("app/files/".$file->folder."/".$file->name));
  }

  public function processFileThumb($id, $width = 240, $height = 360, $const = true) {
    $file = Files::select('*')->where("id", "=", $id)->first();
    if($file->folder == 'images') :
      if($const == true) :
        if(!file_exists(storage_path("app/files/" . $file->folder . "/thumbs/" . $height."_".$width."_".$file->name))) :
          $manager = \ImageManager::canvas($width, $height)
                      ->insert(
                        \ImageManager::make(storage_path("app/files/".$file->folder."/".$file->name))
                        ->heighten($height, function ($constraint) use ($const) {
                          if($const == true) :
                            $constraint->aspectRatio();
                          endif;
                        }), 'center'
                      )->save(storage_path("app/files/".$file->folder."/thumbs/".$height."_".$width."_".$file->name));
        endif;
        return response()->file(storage_path("app/files/".$file->folder."/thumbs/".$height."_".$width."_".$file->name));
      else :
        if(!file_exists(storage_path("app/files/" . $file->folder . "/thumbs/" . $width."_".$height."_".$file->name))) :
          $manager = \ImageManager::canvas($width, $height)
                      ->insert(
                        \ImageManager::make(storage_path("app/files/".$file->folder."/".$file->name))
                        ->widen($width, function ($constraint) use ($const) {
                          if($const == true) :
                            $constraint->aspectRatio();
                          endif;
                        }), 'center'
                      )->save(storage_path("app/files/".$file->folder."/thumbs/".$width."_".$height."_".$file->name));
        endif;
        return response()->file(storage_path("app/files/".$file->folder."/thumbs/".$width."_".$height."_".$file->name));
      endif;
    else :
      return response()->file(storage_path("app/files/".$file->folder."/".$file->name));
    endif;
  }

  public static function upload($request, $name) {
    // getting all of the post data
    $file = array($name => $request->file($name));
    // setting up rules
    $rule = (stripos($request->{$name}->getClientMimeType(), 'image') !== false) ? 'image' : 'file';
    $rules = array($name => $rule);
    // doing the validation, passing post data, rules and the messages
    $validator = Validator::make($file, $rules);
    if ($validator->fails()) :
      return array('status' => false, 'msg' => 'validacion error');
    else :
      // checking file is valid.
      if ($request->file($name)->isValid()) :
        $mime = substr($request->{$name}->getClientMimeType(), 0, 5);
        $store = ($mime == 'image') ? 'images' : 'documents';
        $path = file_exists(storage_path("app/files/".$store."/".$request->{$name}->hashName()));
        if($path == true) :
          return array('status' => false, 'msg' => 'files.fileexists');
        endif;
        $path = $request->{$name}->store("files/".$store);
        $path = explode("/", $path);
        $path = $path[count($path) - 1];
        $id = $request->input('image_id');
        $filemodel = Files::firstOrNew(['id' => $id]);
        if(!empty($id) and !is_null($id)) $filemodel->id = $id;
        $filemodel->folder = $store;
        $filemodel->name = $path;
        $filemodel->originalname = $request->{$name}->getClientOriginalName();
        $filemodel->extension = $request->{$name}->extension();
        $filemodel->size = $request->{$name}->getClientSize();
        $filemodel->mime_type = $request->{$name}->getClientMimeType();
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
    endif;
  }

  private static function getAttribute($file, $attribute) {
    $manager = \ImageManager::make(storage_path("app/files/".$file->folder."/".$file->name));
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
    Storage::delete("files/".$file->folder.'/'.$file->name);
  }
}
