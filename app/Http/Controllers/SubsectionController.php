<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Subsection;
use Illuminate\Http\Request;

class SubsectionController extends Controller
{
    public function index()
    {

        $judul = 'SUBSECTION DASHBOARD';

        $subsection = Subsection::with('sections')->get();

        return view('layouts.sub-section.subsection-index', compact('judul', 'subsection'));
    }

    public function create()
    {

        $judul = 'SUBSECTION CREATE';

        $section = Section::orderBy('area', 'asc')->get();

        return view('layouts.sub-section.subsection-create', compact('judul', 'section'));
    }


    public function store(Request $request)
    {

        // Model 1
        // Subsection::create($request->all());

        // Model 2
        for ($i = 0; $i < count($request->title); $i++) {

            $subsect = new Subsection();
            $subsect->section_id = $request->section_id;
            $subsect->title = $request->title[$i];
            $subsect->order = $request->order[$i];
            $subsect->save();
        }

        return redirect()->route('subsection.index');
    }

    public function edit($id)
    {

        $judul = 'SUBSECTION EDIT';

        $section = Section::orderBy('area', 'asc')->get();

        $subsection = Subsection::find($id);

        return view('layouts.sub-section.subsection-edit', compact('judul', 'section', 'subsection'));
    }


    public function update(Request $request, $id)
    {

        // Model 1
        // Subsection::create($request->all());

        $subsection = Subsection::find($id);
        $subsection->section_id = $request->section_id;
        $subsection->title = $request->title;
        $subsection->order = $request->order;
        $subsection->save();

        return redirect()->route('subsection.index');
    }


    public function destroy($id)
    {
        $subsection = Subsection::find($id);
        $subsection->delete();

        return redirect()->route('subsection.index');
    }
}
