<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManager;
use File;
use App\Models\Operation\Parks;
use App\Models\Operation\Orders;
use Auth;

header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');

class ParkController extends Controller {

    public function getPark($id) {
        $data = Parks::where("stakeholder_id", $id)->orderBy("id", "desc")->get();
        return response()->json(['data' => $data]);
    }

    public function getParks() {
        $data = Parks::all();
        return response()->json(['data' => $data]);
    }

    public function update(Request $req, $id) {
        $in = $req->all();

        $row = Parks::find($id);
        $row->fill($in)->save();


        if ($row) {
            $row = Parks::find($id);
            return response()->json(['msg' => 'creado!', "status" => true, "row" => $row]);
        } else {
            return response()->json(['msg' => 'Problemas con la ejecución!', "status" => false]);
        }
    }

    public function delete($id) {

        $row = Parks::find($id);
        $stakeholder_id = $row->stakeholder_id;
        $row->delete();

        if ($row) {
            $data = Parks::where("stakeholder_id", $stakeholder_id)->orderBy("id", "desc")->get();
            return response()->json(['msg' => 'Registro Borrado!', "status" => true, "data" => $data]);
        } else {
            return response()->json(['msg' => 'Problemas con la ejecución!', "status" => false]);
        }
    }

    public function newPark(Request $req) {
        $in = $req->all();

        if (!isset($in["img"])) {
            $img = '';
        } else {
            $img = $in["img"];
        }

        unset($in["img"]);
        
        $res = Parks::create($in)->id;


        if ($img != '') {
            $manager = new ImageManager(array('driver' => 'imagick'));
            $image = $manager->make($img)->widen(500);
            $path = public_path() . "/images/parks/";
            $pathsys = "images/parks/";
//        $res = File::makeDirectory($path, $mode = 0777, true, true);

            $pathsys .= $res . ".jpg";
            $path .= $res . ".jpg";
            $image->save($path);
            $in["img"] = url($pathsys);
            $row = Parks::find($res);
            $row->img = $in["img"];
            $row->save();
        }

        if ($res) {
            $data = Parks::where("stakeholder_id", $in["stakeholder_id"])->get();
            return response()->json(['msg' => 'creado!', "status" => true, "data" => $data]);
        } else {
            return response()->json(['msg' => 'Problemas con la ejecución!', "status" => false]);
        }
    }

}
