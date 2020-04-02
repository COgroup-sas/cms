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

    if(isset($file->ispublic) and $file->ispublic == false and !Auth::check()) :
      return abort(404);
    endif;

    return $this->showImage($file->diskname, $file->originalname);
  }

  private function showImage($path, $originalname) {
    $mime = Storage::disk(config('filesystems.cloud'))->mimeType($path);
    $data = Storage::disk(config('filesystems.cloud'))->get($path);

    return response($data, 200)
            ->header('Content-Type', $mime)
            ->header('Content-Disposition', 'attachment; filename="'. $originalname .'"')
            ->header('Access-Control-Expose-Headers', 'Content-Disposition');
  }

  public function processFileThumb($id, $width = 240, $height = 360) {
    $file = Files::select('*')->where("id", "=", $id)->first();
    $mime = explode("/", $file->mimetype);
    $ext = $mime[1];
    $mime = $mime[0];

    if($mime == "image") :
      $path = "thumbs/".$height."_".$width."_".$file->diskname;
      $data = Storage::disk(config('filesystems.cloud'))->get($file->diskname);

      if(!Storage::disk(config('filesystems.cloud'))->exists("thumbs/" . $height."_".$width."_".$file->diskname)) :
        if($width > $height || $width == $height) :
          $img = \ImageManager::make($data)->widen($width, function ($constraint) {
            $constraint->upsize();
          })->stream($ext, 60);
        else :
          $img = \ImageManager::make($data)->heighten($height, function ($constraint) {
            $constraint->upsize();
          })->stream($ext, 60);
        endif;
        Storage::disk(config('filesystems.cloud'))->put($path, $img);
      endif;
      return $this->showImage($path, $file->originalname);
    else :
      return $this->showImage($file->diskname, $file->originalname);
    endif;
  }

  public static function upload($request, $name) {
    // checking file is valid.
    if($request->file($name)->isValid()) :
      $mime = substr($request->{$name}->getClientMimeType(), 0, 5);
      $path = Storage::disk(config('filesystems.cloud'))->exists($request->{$name}->hashName());
      if($path == true) :
        return array('status' => false, 'msg' => 'files.fileexists');
      endif;
      $path = $request->{$name}->store('', config('filesystems.cloud'));
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
      $filemodel->alt = (!empty($request->input('alt'))) ? $request->input('alt') : cms_settings()->sitename;
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
    $manager = \ImageManager::make(Storage::disk(config('filesystems.cloud'))->get($file->diskname));
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
    Storage::disk(config('filesystems.cloud'))->delete($file->diskname);
  }
}
