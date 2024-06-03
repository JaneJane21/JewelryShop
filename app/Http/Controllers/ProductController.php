<?php

namespace App\Http\Controllers;

use App\Models\Product;

use App\Models\ProductFilialSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function add_fav($id)
    {
        dd($id);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd(json_decode($request->selected_filials));
        $valid = Validator::make($request->all(),[
            'title'=>['required'],
            'price'=>['regex:/^[0-9]*[.,]?[0-9]+$/'],
            'description'=>['required'],
            'type_id'=>['required'],

            'material_id'=>['required'],
            'cutting_id'=>['required'],
            'stone_id'=>['required'],
            'whome_id'=>['required'],
            'brand_id'=>['required'],
            'sample_id'=>['required'],
        ]);
        if($valid->fails()){
            return response()->json($valid->errors(),400);
        }
        $product = new Product();
        $product->title = $request->title;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->type_id = $request->type_id;
        if($request->subtype_id){
            $product->subtype_id = $request->subtype_id;
        }
        if($request->file('images')){
            $images = '';

            // dd($request->file('images'));
            foreach($request->file('images') as $image){
                // array_push($test, $image);
                $path = $image->store('public/img');
                if($path){
                    $images.='/storage/'.$path.';';
                }
            }
            $images = substr($images, 0, -1);
            $product->images = $images;
        }
        $product->material_id = $request->material_id;
        $product->cutting_id = $request->cutting_id;
        $product->stone_id = $request->stone_id;
        $product->whome_id = $request->whome_id;
        $product->brand_id = $request->brand_id;
        $product->sample_id = $request->sample_id;
        $product->save();

        foreach(json_decode($request->selected_filials) as $key=>$filial){
            // dd($filial);
            if(isset($filial->sizes)){
                foreach($filial->sizes as $key=>$size){
                $new_filial = new ProductFilialSize();
                $new_filial->filial_id = $filial->filial_id;
                $new_filial->size_id = $size;
                $new_filial->count = $filial->counts[$key];
                $new_filial->product_id = $product->id;
                $new_filial->save();
            }
            }
            else{
                foreach($filial->counts as $count){
                    $new_filial = new ProductFilialSize();
                    $new_filial->filial_id = $filial->filial_id;
                    $new_filial->count = $count;
                    $new_filial->product_id = $product->id;
                    $new_filial->save();
                }
            }
        }

        return redirect()->route('show_products')->with('success','Успешный вход');


    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $products = Product::with(['material',
        'sample',
        'stone',
        'cutting',
        'whome',
        'type',
        'type.sizes',
        'subtype',
        'brand',
        'productfilialsizes'])->get();
        return response()->json($products);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        dd($request->all());
        $valid = Validator::make($request->all(),[
            'title'=>['required'],
            'price'=>['regex:/^[0-9]*[.,]?[0-9]+$/'],
            'description'=>['required'],
            
        ]);
        if($valid->fails()){
            return response()->json($valid->errors(),400);
        }
        $product = Product::query()->where('id',$request->id)->first();

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product,$id)
    {
        Product::find($id)->delete();
        return redirect()->back();
    }
}
