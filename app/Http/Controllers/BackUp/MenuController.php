<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('menu.index');
    }

    public function data()
    {
        $menu=menu::orderBy('Id_Menu', 'desc')->get();

        return datatables()
            ->of($menu)
            ->addIndexColumn()
            ->addColumn('Harga', function($menu){
                return format_uang($menu->Harga);
            })
            ->addColumn('Stok', function($menu){
                return format_uang($menu->stok);
            })
            ->addColumn('aksi', function($menu){
                if (auth()->user()->level==2){
                    return '
                <div class="btn-group">
                   <button onclick="editForm(`'.route('menu.update', $menu->Id_Menu).'`)" class="btn btn-xs btn-info btn-flat btn-edit"><i class="fa fa-pencil"></i> Edit</button>
                   <button onclick="deleteData(`'.route('menu.destroy', $menu->Id_Menu).'`)" class="btn btn-xs btn-danger btn-flat btn-edit"><i class="fa fa-trash"></i> Hapus</button>
                </div>';}
                
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
       
        $menu=new menu();
        $menu = menu::create($request->all());

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $menu=menu::find($id);

        return response()->json($menu);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        $menu = menu::find($id);
        $menu->Nama_menu = $request->nama_menu;
        $menu->Harga=$request->harga;
        $menu->stok=$request->stok;
        $menu->jenis=$request->jenis;
        $menu->update();

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $menu = menu::find($id);
        $menu->delete();

        return response(null, 204);
    }
}
