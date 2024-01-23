<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductContrroller extends Controller
{
    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit', 6);
        $name = $request->input('name');
        $description = $request->input('description');
        $tags = $request->input('tags');
        $categories = $request->input('categories');
        $price_from = $request->input('price_from');
        $price_to = $request->input('price_to');

        if ($id) {
            $product = Product::with(['category', 'galleries'])->find($id);

            if ($product) {
                dd('sds');
                return ResponseFormatter::success(
                    $product,
                    'Data Product berhasil diambil'
                );
            } else {
                return ResponseFormatter::error(
                    null,
                    'Data produk tidak ada',
                    404
                );
            }
        }
        $product = Product::with(['category', 'galleries']);

        if ($name) {
            $product->where('name', 'like', '%' . $name . '%');

            // dd('abc');
        }
        if ($description) {
            $product->where('name', 'like', '%' . $description . '%');
            // dd('abcd');
        }

        if ($tags) {
            $product->where('name', 'like', '%' . $tags . '%');
            // dd('abcdf');
        }

        if ($price_from) {
            $product->where('price', '>=', $price_from);
            // dd('abcdg');
        }
        if ($price_to) {
            $product->where('price', '<=', $price_to);
            // dd('abcdh');
        }
        if ($categories) {
            $product->where('categories', $categories);
            // dd('abcdi');
        }
        // $product->get();
        // return ($product);
        // dd('ac');
        return ResponseFormatter::success(
            $product->paginate($limit),
            // $product->toSql(),

            'Data Product berhasil diambil'
        );
    }
}
