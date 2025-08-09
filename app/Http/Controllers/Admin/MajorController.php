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
            'tags' => ['nullable'],
            'is_active' => ['sometimes','boolean'],
        ]);
        // Chuẩn hoá tags: cho phép nhập chuỗi phân tách dấu phẩy hoặc mảng
        $rawTags = $request->input('tags');
        if (is_string($rawTags)) {
            $data['tags'] = array_values(array_filter(array_map(fn($t)=>trim($t), explode(',', $rawTags))));
        } elseif (is_array($rawTags)) {
            $data['tags'] = array_values(array_filter(array_map(fn($t)=>trim((string)$t), $rawTags)));
        } else {
            $data['tags'] = [];
        }
        $data['is_active'] = $request->boolean('is_active', true);
        try {
            Major::create($data);
        } catch (\Throwable $e) {
            \Log::error('Create major failed', ['error' => $e->getMessage()]);
            return back()->withInput()->withErrors(['general' => 'Không lưu được ngành. Vui lòng kiểm tra dữ liệu nhập.']);
        }
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
            'tags' => ['nullable'],
            'is_active' => ['sometimes','boolean'],
        ]);
        $rawTags = $request->input('tags');
        if (is_string($rawTags)) {
            $data['tags'] = array_values(array_filter(array_map(fn($t)=>trim($t), explode(',', $rawTags))));
        } elseif (is_array($rawTags)) {
            $data['tags'] = array_values(array_filter(array_map(fn($t)=>trim((string)$t), $rawTags)));
        } else {
            $data['tags'] = [];
        }
        $data['is_active'] = $request->boolean('is_active', true);
        try {
            $major->update($data);
        } catch (\Throwable $e) {
            \Log::error('Update major failed', ['error' => $e->getMessage()]);
            return back()->withInput()->withErrors(['general' => 'Không cập nhật được ngành.']);
        }
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
