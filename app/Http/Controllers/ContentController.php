<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Content;
use Illuminate\Support\Facades\Log;

class ContentController extends Controller
{
    public function store(Request $request)
    {
        if ($request->img_path) {
            $path = $this->uploadImage($request->file('img_path'));
        } else {
            $path = null;
        }
        $paths = [];

        if ($request->hasFile('img_paths')) {
            foreach ($request->file('img_paths') as $file) {
                $paths[] = $this->uploadImage($file); // upload each file
            }
        } else {
            $paths = null; // or leave as empty array []
        }
        // Video Upload Logic
        $video_path = null;
        if ($request->hasFile('video_path')) {
            $video_path = $this->uploadVideo($request->file('video_path'));
        }

        // Create a new content instance
        Content::create([
            'type' => $request->input('type'),
            'parent_id' => $request->input('parent_id'),
            'name' => $request->input('name'),
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'body_2' => $request->input('body_2'),
            'body_3' => $request->input('body_3'),
            'body_4' => $request->input('body_4'),
            'meta_title' => $request->input('meta_title'),
            'meta_description' => $request->input('meta_description'),
            'meta_keywords' => $request->input('meta_keywords'),
            'img_path' => $path,
            'video_path' => $video_path,
            'img_paths' => json_encode($paths),
            'url' => $request->input('url'),
            'start_date' => $request->input('start_date'),
            'short' => $request->input('short'),
            'end_date' => $request->input('end_date'),
            'location' => $request->input('location'),
            'extra' => $request->input('extra'),
            // 'status' => $request->input('status', 0),
            'status' => $request->has('status') ? 1 : 0,
        ]);

        return redirect()->back()->with('status', $request->input('type') . ' created successfully!');
    }
    public function update(Request $request)
    {
        $content = Content::find($request->input('id'));
        if ($request->img_path) {
            $path = $this->uploadImage($request->file('img_path'));
            if (file_exists(public_path($content->img_path))) {
                if ($content->img_path) {
                    unlink(public_path($content->img_path));
                }
            }
        } else {
            $path = $content->img_path;
        }

        $paths = json_decode($content->img_paths);
        if ($request->hasFile('img_paths')) {
            // Upload new images
            foreach ($request->file('img_paths') as $file) {
                $paths[] = $this->uploadImage($file);
            }
            $paths = json_encode($paths);
        } else {
            $paths = $content->img_paths ?? null; // keep old images if no new upload
        }
        // Video Update Logic
        if ($request->hasFile('video_path')) {
            $video_path = $this->uploadVideo($request->file('video_path'));
            // Delete old video if exists
            if ($content->video_path && file_exists(public_path($content->video_path))) {
                unlink(public_path($content->video_path));
            }
        } else {
            $video_path = $content->video_path;
        }

        // Create a new content instance
        $content->update([
            'type' => $request->input('type'),
            'parent_id' => $request->input('parent_id'),
            'name' => $request->input('name'),
            'title' => $request->input('title'),
            'short' => $request->input('short'),
            'img_paths' => $paths,

            'body' => $request->input('body'),
            'body_2' => $request->input('body_2'),
            'body_3' => $request->input('body_3'),
            'body_4' => $request->input('body_4'),
            'meta_title' => $request->input('meta_title'),
            'meta_description' => $request->input('meta_description'),
            'meta_keywords' => $request->input('meta_keywords'),
            'img_path' => $path,
            'video_path' => $video_path,
            'url' => $request->input('url'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'location' => $request->input('location'),
            'extra' => $request->input('extra'),
            // 'status' => $request->input('status', 0),
            'status' => $request->has('status') ? 1 : 0,
        ]);

        return redirect()->back()->with('status', $request->input('type') . ' updated successfully!');
    }
    public function destroy($type, $id)
    {
        // Delete the content instance
        Content::find($id)->delete();

        return redirect()->back()->with('status', $type . ' deleted successfully!');
    }
    public function edit($type, $id)
    {
        $content = Content::findOrFail($id);

        if ($type === 'project') {
            return view('backend.content.edit-project', compact('content', 'type'));
        }

        return view('backend.content.update', compact('content', 'type'));
    }
    public function create($type)
    {
        if ($type === 'project') {
            return view('backend.content.project', compact('type'));
        }

        return view('backend.content.create', compact('type'));
    }
    public function index($type)
    {
        $datas = Content::where('type', $type)->get();
        Log::info('Fetched ' . count($datas) . ' items of type ' . $datas);
        return view('backend.content.index', compact('datas', 'type'));
    }
    public function show($id)
    {
        $content = Content::find($id);
        return view('backend.content.show', compact('content'));
    }
    public function uploadImage($image)
    {
        $imageName = time() . rand(9999, 99999) . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $imageName);
        return 'images/' . $imageName;
    }
    public function uploadVideo($video)
    {
        $videoName = time() . rand(9999, 99999) . '.' . $video->getClientOriginalExtension();
        $video->move(public_path('videos'), $videoName);
        return 'videos/' . $videoName;
    }
}
