<?php

namespace App\Http\Controllers\ClientController;

use App\Http\Controllers\Controller;
use App\Models\product;
use Illuminate\Http\Request;

class ProductSearchController extends Controller
{
    public function fetchData(Request $request): \Illuminate\Http\JsonResponse
    {
        $value = $request->get('value');
        $value = preg_replace('[a-zالف-ی]','',$value);
        $result = '';
        if ($value != null) {
            $data = product::where('name','like','%'.$value.'%')->orderBy('id','desc')->paginate(10);
        }else {
            $data = product::orderBy('id','desc');
        }

        $total_products = $data->count();

        foreach ($data as $getRow){
            $result .='
            <tr>
                <td>
                    <a href="/productDetails/'.$getRow->slug.'">
                        <img width = "70" src="'.str_replace('public','/storage',$getRow->image).'">
                    </a>
                </td>
                <td>
                    <a style="color: blue" href="/productDetails/'.$getRow->slug.'">'.$getRow->name.'</a>
                </td>
            </tr>';
        }

        $data = array(
            'table_data' => $result,
            'total_products' => $total_products
        );
        return response()->json($data);
    }
}
