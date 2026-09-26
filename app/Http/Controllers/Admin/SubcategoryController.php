<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubcategoryRequest;
use App\Models\Category;
use App\Models\Subcategory;
use App\Repository\Interface\CategoryInterface;
use App\Repository\Interface\SubcategoryInterface;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $subcategory;
    protected $category;

    public function __construct(SubcategoryInterface $subcategory, CategoryInterface $category)
    {
        $this->subcategory = $subcategory;
        $this->category = $category;
    }

    public function index()
    {
        return view('admin.subcategory.index', [
            'subcategories' => $this->subcategory->getAllData()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.subcategory.create', [
            'categories' => Category::get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubcategoryRequest $request)
    {
        $data = $request->only(['name', 'slug', 'cat_id']);
        $this->subcategory->storeOrUpdate($id = null, $data);
        return redirect()->route('subcategories.index')->with('success', 'Subcategory has been successfully created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subcategory = $this->subcategory->edit($id);
        $categories = $this->category->getAllData();
        return view('admin.subcategory.edit', compact('subcategory', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SubcategoryRequest $request, $id)
    {
        $data = $request->only(['name', 'slug', 'cat_id']);
        $this->subcategory->storeOrUpdate($id, $data);
        return redirect()->route('subcategories.index')->with('success', 'Subcategory has been successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->subcategory->delete($id);
        return redirect()->route('subcategories.index')->with('success', 'Subcategory has been successfully deleted.');
    }

    public function categoryWiseSubcategory($id)
    {
        $subcategory_name = Subcategory::with('category')->where('cat_id', $id)->get();
        return response()->json($subcategory_name, 200);
    }
}
