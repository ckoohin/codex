<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Major;
use Illuminate\Http\Request;

class MajorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $majors = Major::orderBy('name')->paginate(12);
        return view('admin.majors.index', compact('majors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.majors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => ['required','string','max:50','unique:majors,code'],
            'name' => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'tags' => ['nullable','array'],
            'is_active' => ['sometimes','boolean'],
        ]);
        $data['tags'] = $data['tags'] ?? [];
        $data['is_active'] = (bool)($data['is_active'] ?? true);
        Major::create($data);
        return redirect()->route('admin.majors.index')->with('ok','Đã tạo ngành');
    }

    /**
     * Display the specified resource.
     */
    public function show(Major $major)
    {
        return view('admin.majors.show', compact('major'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Major $major)
    {
        return view('admin.majors.edit', compact('major'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Major $major)
    {
        $data = $request->validate([
            'code' => ['required','string','max:50','unique:majors,code,'.$major->id],
            'name' => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'tags' => ['nullable','array'],
            'is_active' => ['sometimes','boolean'],
        ]);
        $data['tags'] = $data['tags'] ?? [];
        $data['is_active'] = (bool)($data['is_active'] ?? true);
        $major->update($data);
        return redirect()->route('admin.majors.index')->with('ok','Đã cập nhật ngành');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Major $major)
    {
        $major->delete();
        return redirect()->route('admin.majors.index')->with('ok','Đã xóa ngành');
    }
}
