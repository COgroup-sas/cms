<?php

namespace Cogroup\Cms\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Cogroup\Cms\Http\Controllers\CmsController;

class FilesController extends CmsController {
	public function index($id) {
    try {
      $identificador = Crypt::decryptString($id);
    } catch (DecryptException $e) {
      return abort(404);
    }
    
    $identificador = explode("-", $identificador);

    $shoppingcart = StoreShoppingcartModel::findOrFail($identificador[0]);
    $item         = StoreShoppingcartItemsModel::findOrFail($identificador[1]);
    $file         = SearchTableModel::findOrFail($identificador[2]);

    return Storage::disk('public')->download('demo.rar');

    if(!empty($shoppingcart) and !empty($item) and !empty($file)) :
      $properties = json_decode($item->properties);
      if(Storage::disk('local')->has('file.jpg') == true) :
        return Storage::disk('gaudi')->download($properties->ruta.$item->filename);
      else :
        $properties->size = 0;
        $item->properties = json_encode($properties);
        $item->save();
        return abort(404)
      endif;
    else :
      return abort(404);
    endif;
	}
}
