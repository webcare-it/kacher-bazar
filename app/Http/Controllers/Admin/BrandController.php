<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Repository\Interface\BrandInterface;
use App\Repository\Interface\CategoryInterface;
use App\Repository\Interface\SubcategoryInterface;
use Illuminate\Http\Request;

class BrandController extends Controller
{


    protected $brand;
    protected $category;
    protected $subcategory;

    public function __construct(BrandInterface $brand, CategoryInterface $category, SubcategoryInterface $subcategory)
    {
        $this->brand = $brand;
        $this->category = $category;
        $this->subcategory = $subcategory;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.brand.index', [
            'brands' => $this->brand->getAllData()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.brand.create', [
            'categories' => $this->category->getAllData(),
            'subcategories' => $this->subcategory->getAllData(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BrandRequest $request)
    {
        $data = $request->only(['name', 'cat_id', 'sub_cat_id', 'slug']);
        $this->brand->storeOrUpdate($id = null, $data);
        return redirect()->route('brands.index')->with('success', 'Brand has been successfully created.');
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
        $brand = $this->brand->edit($id);
        $categories = $this->category->getAllData();
        $subcategories = $this->subcategory->getAllData();
        return view('admin.brand.edit', [
            'brand' => $brand,
            'categories' => $categories,
            'subcategories' => $subcategories
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BrandRequest $request, $id)
    {
        $data = $request->only(['name', 'cat_id', 'sub_cat_id', 'slug']);
        $this->brand->storeOrUpdate($id, $data);
        return redirect()->route('brands.index')->with('success', 'Brand has been successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->brand->delete($id);
        return redirect()->route('brands.index')->with('success', 'Brande has been successfully deleted.');
    }
}
