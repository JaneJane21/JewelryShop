<?php

namespace App\Http\Controllers;

use App\Models\Size;
use App\Models\Subtype;
use App\Models\Type;
use App\Models\Cutting;
use App\Models\Stone;
use App\Models\Brand;
use App\Models\Whome;
use App\Models\Material;
use App\Models\Sample;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    //    dd($request->all());
        $valid = Validator::make($request->all(),[
            'title'=>['required','unique:types']
        ]);
        if ($valid->fails()){
            return response()->json($valid->errors(),400);
        }
        $type = new Type();
        $type->title = $request->title;
        $type->save();
        if (!empty($request->subtypes)){
            foreach ($request->subtypes as $subtype){
                if ($subtype!=null){
                    $s = new Subtype();
                    $s->type_id = $type->id;
                    $s->title = $subtype;
                    $s->save();
                }
            }
        }
        // dd($request->sizes);
        if (!empty($request->sizes)){
            foreach ($request->sizes as $size){
                if ($size!=null){
                    $s = new Size();
                    $s->type_id = $type->id;
                    $s->number = doubleval($size);

                    $s->save();
                }
            }
            // $q = Size::all();
            // dd($q);
        }
        return response()->json('Сохранено',200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Type $type)
    {
        $types = Type::with(['subtypes','sizes'])->get();
        return response()->json($types);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Type $type, Request $request)
    {
        

        switch($request->type){
            case 'type':
                $valid = Validator::make($request->all(),[
                    'title'=>['required', 'unique:types']
                ]);
                if($valid->fails()){
                    return response()->json($valid->errors(),404);
                }
                $char = Type::query()->where('id',$request->id)->first();
                $char->title = $request->title;
                $char->update();
                break;
            case 'cutting':
                $valid = Validator::make($request->all(),[
                    'title'=>['required', 'unique:cuttings']
                ]);
                if($valid->fails()){
                    return response()->json($valid->errors(),404);
                }
                $char = Cutting::query()->where('id',$request->id)->first();
                $char->title = $request->title;
                $char->update();
                break;
            case 'stone':
                $valid = Validator::make($request->all(),[
                    'title'=>['required', 'unique:stones']
                ]);
                if($valid->fails()){
                    return response()->json($valid->errors(),404);
                }
                $char = Stone::query()->where('id',$request->id)->first();
                $char->title = $request->title;
                $char->update();
                break;
            case 'brand':
                $valid = Validator::make($request->all(),[
                    'title'=>['required', 'unique:brands']
                ]);
                if($valid->fails()){
                    return response()->json($valid->errors(),404);
                }
                $char = Brand::query()->where('id',$request->id)->first();
                $char->title = $request->title;
                $char->update();
                break;
            case 'whome':
                $valid = Validator::make($request->all(),[
                    'title'=>['required', 'unique:whomes']
                ]);
                if($valid->fails()){
                    return response()->json($valid->errors(),404);
                }
                $char = Whome::query()->where('id',$request->id)->first();
                $char->title = $request->title;
                $char->update();
                break;
            case 'material':
                $valid = Validator::make($request->all(),[
                    'title'=>['required', 'unique:materials']
                ]);
                if($valid->fails()){
                    return response()->json($valid->errors(),404);
                }
                $char = Material::query()->where('id',$request->id)->first();
                $char->title = $request->title;
                $char->update();
                break;
            case 'sample':
                $valid = Validator::make($request->all(),[
                    'title'=>['required', 'unique:samples']
                ]);
                if($valid->fails()){
                    return response()->json($valid->errors(),404);
                }
                $char = Sample::query()->where('id',$request->id)->first();
                $char->title = $request->title;
                $char->update();
                break;
        };
        return response()->json('Успешно изменено',200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Type $type)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, $type)
    {
        switch($type){
            case 'type':
                Type::find($id)->delete();
                break;
            case 'cutting':
                Cutting::find($id)->delete();
                break;
            case 'stone':
                Stone::find($id)->delete();
                break;
            case 'brand':
                Brand::find($id)->delete();
                break;
            case 'whome':
                Whome::find($id)->delete();
                break;
            case 'material':
                Material::find($id)->delete();
                break;
            case 'sample':
                Sample::find($id)->delete();
                break;
        };
        return redirect()->back();
    }
}
