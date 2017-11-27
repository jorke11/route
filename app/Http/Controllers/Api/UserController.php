<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\Models\Operation\Parks;

class UserController extends Controller {

    public function login(Request $req) {
     
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $email = request('email');
            $user = Auth::user();
            $this->content['token'] = $user->createToken($email)->accessToken;
            $this->content['success'] = true;
            $status = 200;
        } else {
            $this->content['error'] = "Unauthorised";
            $this->content['success'] = false;
            $status = 401;
        }

        return response()->json($this->content, $status);
    }

    public function details() {
        return response()->json(['user' => Auth::user()]);
    }

    public function getPark($id) {
        $data = Parks::where("stakeholder_id", $id)->get();
        return response()->json(['data' => $data]);
    }

    public function newStakeholder(Request $req) {
        $in = $req->all();
        $in["password"] = bcrypt($in["password"]);
        $valida = User::where("email", request("email"))->get();

        if ($in["role_id"] == 2) {
            $stakeholder = "client";
        } else if ($in["role_id"] == 3) {
            $stakeholder = "proveedor";
        }

        if (count($valida) == 0) {
            User::create($in);
            return response()->json(['msg' => $stakeholder . ' creado!', "status" => true]);
        } else {
            return response()->json(['msg' => 'Email de ' . $stakeholder . ' ya existe!', "status" => false]);
        }
    }

    public function newPark(Request $req) {
        $in = $req->all();

        $res = Parks::create($in);

        if ($res) {
            $data = Parks::where("stakeholder_id", $in["stakeholder_id"])->get();
            return response()->json(['msg' => 'creado!', "status" => true, "data" => $data]);
        } else {
            return response()->json(['msg' => 'Problemas con la ejecución!', "status" => false]);
        }
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

}
