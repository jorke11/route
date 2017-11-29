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

        if ($row->available > 0) {
            $row->available = $row->available - 1;
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
        $data = Orders::select("orders.id", "users.name", "users.last_name", 
                "parks.address", DB::raw("CASE WHEN orders.status_id = 1 tHEN FALSE ELSE TRUE END as status_id"), "orders.created",
                DB::raw("CASE WHEN orders.status_id = 1 THEN 'Nuevo' WHEN orders.status_id = 2 THEN 'Completado' ELSE 'Cancelado' END as status"))
                        ->join("users", "users.id", "orders.user_id")
                        ->join("parks", "parks.id", "orders.park_id")
                        ->where("orders.user_id", Auth::user()->id)
                        ->orderBy("orders.id", "desc")->get();
        return response()->json(['data' => $data]);
    }

    public function cancelOrder(Request $req, $id) {
        $row = Orders::find($id);
        $row->status_id = 3;
        $row->leaved = date("Y-m-d H:i:s");
        $row->save();
        return response()->json(['status' =>true , "row" => $row]);
    }

}
