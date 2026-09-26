<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $page = 'index';
        $data = Blog::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.blog.index', compact('data', 'page'));
    }

    public function create()
    {
        $page = 'create';
        $data = '';
        return view('admin.blog.index', compact('data', 'page'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:191|string',
            'description' => 'required',
            'image' => 'required',
        ]);

        if($request->file('image')){
            $image = $request->file('image');
            $fileName = date('YmdHi').'.'.$image->getClientOriginalExtension();
            $image->move('blogs', $fileName);
        }

        $blog = new Blog();
        $blog->title = $request->title;
        $blog->slug = str_replace(' ', '-', strtolower($request->title));
        $blog->description = $request->description;
        $blog->image = $fileName;
        $blog->save();
        return redirect('/blog/list')->withSuccess('Blog has been successfully created.');
    }

    public function edit(Blog $blog)
    {
        $page = 'edit';
        $data = $blog;
        return view('admin.blog.index', compact('data', 'page'));
    }

    public function update(Request $request, Blog $blog)
    {
        $this->validate($request, [
            'title' => 'required|max:191|string',
            'description' => 'required',
        ]);

        $oldImage = $blog->image;

        if($request->hasFile('image')){
            if($oldImage && file_exists('blogs/'.$oldImage)){
                unlink('blogs/'.$oldImage);
            }
            $image = $request->file('image');
            $fileName = date('YmdHi').'.'.$image->getClientOriginalExtension();
            $image->move('blogs', $fileName);
            $blog->image = $fileName;
        }

        $blog->title = $request->title;
        $blog->slug = str_replace(' ', '-', strtolower($request->title));
        $blog->description = $request->description;
        $blog->save();
        return redirect('/blog/list')->withSuccess('Blog has been successfully updated.');
    }

    public function destroy($id)
    {
        $blog = Blog::find($id);
        $blog->delete();
        return redirect('/blog/list')->withSuccess('Blog has been successfully deleted.');
    }
}
