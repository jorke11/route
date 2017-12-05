<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Operation\Parks;
use App\Models\Operation\Orders;
use Auth;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller {

    public function reservePark(Request $req) {
        $in = $req->all();
        $row = Parks::find($in["id"]);

        if (($row->available - $row->current) > 0) {
            $row->current = $row->current - 1;
            $row->save();

            $new["user_id"] = Auth::user()->id;
            $new["park_id"] = $in["id"];
            $new["status_id"] = 1;
            $new["created"] = date("Y-m-d H:i");
            $id = Orders::create($new)->id;
            return response()->json(['status' => true, "msg" => "Cupo reservado. Numero de reserva: #" . $id]);
        } else {
            return response()->json(['status' => false, "msg" => "Sin cupo disponible"], 401);
        }
    }

    public function getOrders() {

        $sql = Orders::select("orders.id", "users.name", "users.last_name", "parks.address", DB::raw("CASE WHEN orders.status_id = 1 tHEN FALSE ELSE TRUE END as status_id"), "orders.created", DB::raw("CASE WHEN orders.status_id = 1 THEN 'Nuevo' WHEN orders.status_id = 2 THEN 'Completado' ELSE 'Cancelado' END as status"))
                ->join("users", "users.id", "orders.user_id")
                ->join("parks", "parks.id", "orders.park_id");

        if (Auth::user()->role_id == 1) {
            $sql->where("orders.user_id", Auth::user()->id);
        } else {
            $parks = Parks::select("id")->where("stakeholder_id", Auth::user()->id)->get()->toArray();
            $sql->whereIn("orders.park_id", $parks);
        }

        $data = $sql->orderBy("orders.id", "desc")->get();

        return response()->json(['data' => $data]);
    }

    public function cancelOrder(Request $req) {
        $in = $req->all();
        $row = Orders::find($in["id"]);
        $row->status_id = 3;
        $row->leaved = date("Y-m-d H:i:s");
        $row->save();
        return response()->json(['status' => true, "row" => $row]);
    }

    public function ConfirmOrder(Request $req, $id) {
        $in = $req->all();
        $row = Orders::find($in["id"]);
        $row->status_id = 2;
        $row->current += 1;
        $row->leaved = date("Y-m-d H:i:s");
        $row->save();
        return response()->json(['status' => true, "row" => $row]);
    }

}
