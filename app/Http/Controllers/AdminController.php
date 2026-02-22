<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Place;

class AdminController extends Controller
{
    public function index()
    {
        $places = Place::all();
        return view('admin.index', compact('places'));
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        Place::create($request->all());
        return redirect('/admin');
    }

    public function edit($id)
    {
        $place = Place::findOrFail($id);
        return view('admin.edit', compact('place'));
    }

    public function update(Request $request, $id)
    {
        $place = Place::findOrFail($id);
        $place->update($request->all());
        return redirect('/admin');
    }

    public function destroy($id)
    {
        Place::findOrFail($id)->delete();
        return redirect('/admin');
    }
}
