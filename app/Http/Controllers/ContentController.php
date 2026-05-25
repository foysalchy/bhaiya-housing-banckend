<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Content;
use Illuminate\Support\Facades\Log;

class ContentController extends Controller
{
    public function store(Request $request)
    {
        // ── Thumbnail ──────────────────────────────────────────────
        if ($request->hasFile('img_path')) {
            $path = $this->uploadImage($request->file('img_path'));
        } else {
            $path = null;
        }

        // ── Multiple Images ────────────────────────────────────────
        $paths = [];
        if ($request->hasFile('img_paths')) {
            foreach ($request->file('img_paths') as $file) {
                $paths[] = $this->uploadImage($file);
            }
        } else {
            $paths = null;
        }

        // ── Video ──────────────────────────────────────────────────
        $video_path = null;
        if ($request->hasFile('video_path')) {
            $video_path = $this->uploadVideo($request->file('video_path'));
        }

        // ── Extra JSON ─────────────────────────────────────────────
        $sizes     = array_values(array_filter(
            $request->input('extra_size', []),
            fn($v) => trim($v) != ''
        ));
        $sizeValue = count($sizes) == 1 ? $sizes[0] : (count($sizes) > 1 ? $sizes : null);

        $extra = json_encode([
            'status'          => $request->input('extra_status'),
            'size'            => $sizeValue,
            'building_height' => $request->input('extra_height'),
            'facing'          => $request->input('extra_facing'),
            'featured'        => $request->input('extra_featured') == 'true',
            'map_url'         => $request->input('extra_map'),
        ]);

        // ── Save ───────────────────────────────────────────────────
        Content::create([
            'type'             => $request->input('type'),
            'parent_id'        => $request->input('parent_id'),
            'name'             => $request->input('name'),
            'title'            => $request->input('title'),
            'short'            => $request->input('short'),
            'img_path'         => $path,
            'img_paths'        => json_encode($paths),
            'video_path'       => $video_path,
            'body'             => $request->input('body'),
            'body_2'           => $request->input('body_2'),
            'body_3'           => $request->input('body_3'),
            'body_4'           => $request->input('body_4'),
            'meta_title'       => $request->input('meta_title'),
            'meta_description' => $request->input('meta_description'),
            'meta_keywords'    => $request->input('meta_keywords'),
            'url'              => $request->input('url'),
            'start_date'       => $request->input('start_date'),
            'end_date'         => $request->input('end_date'),
            'location'         => $request->input('location'),
            'extra'            => $extra,
            'status'           => $request->has('status') ? 1 : 0,
        ]);

        return redirect()->back()->with('status', $request->input('type') . ' created successfully!');
    }
 public function update(Request $request)
{
    $content = Content::find($request->input('id'));

    // ── Thumbnail ──────────────────────────────────────────────
    if ($request->boolean('delete_img_path')) {
        if ($content->img_path && file_exists(public_path($content->img_path))) {
            unlink(public_path($content->img_path));
        }
        $path = null;
    } elseif ($request->hasFile('img_path')) {
        if ($content->img_path && file_exists(public_path($content->img_path))) {
            unlink(public_path($content->img_path));
        }
        $path = $this->uploadImage($request->file('img_path'));
    } else {
        $path = $content->img_path;
    }

    // ── Multiple Images ────────────────────────────────────────
    // DB থেকে existing paths নাও — json_decode false হলে empty array fallback
    $existingPaths = json_decode($content->img_paths, true);
    if (!is_array($existingPaths)) {
        $existingPaths = [];
    }

    // 1. আগে delete করো (original index দিয়ে, reorder এর আগে)
    $deleteIndexes = $request->input('delete_images', []);
    foreach ($deleteIndexes as $index) {
        $index = (int)$index;
        if (isset($existingPaths[$index])) {
            $filePath = public_path($existingPaths[$index]);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            unset($existingPaths[$index]);
        }
    }

    // 2. existing_order অনুযায়ী reorder করো
    if ($request->filled('existing_order')) {
        $order     = explode(',', $request->input('existing_order'));
        $reordered = [];
        foreach ($order as $idx) {
            $idx = (int)$idx;
            if (isset($existingPaths[$idx])) {
                $reordered[] = $existingPaths[$idx];
            }
        }
        $existingPaths = $reordered;
    } else {
        $existingPaths = array_values($existingPaths);
    }

    // 3. নতুন upload append করো
    //    hasFile() চেক করার আগে নিশ্চিত করো file আছে কিনা
    if ($request->hasFile('img_paths')) {
        $uploadedFiles = $request->file('img_paths');
        // single file হলেও array হিসেবে handle করো
        if (!is_array($uploadedFiles)) {
            $uploadedFiles = [$uploadedFiles];
        }
        foreach ($uploadedFiles as $file) {
            if ($file && $file->isValid()) {
                $existingPaths[] = $this->uploadImage($file);
            }
        }
    }

    // existingPaths empty হলেও null না করে empty array রাখো
    // তাহলে পরে আবার image add করা যাবে
    $paths = json_encode($existingPaths);

    // ── Video ──────────────────────────────────────────────────
    if ($request->boolean('delete_video')) {
        if ($content->video_path && file_exists(public_path($content->video_path))) {
            unlink(public_path($content->video_path));
        }
        $video_path = null;
    } elseif ($request->hasFile('video_path')) {
        if ($content->video_path && file_exists(public_path($content->video_path))) {
            unlink(public_path($content->video_path));
        }
        $video_path = $this->uploadVideo($request->file('video_path'));
    } else {
        $video_path = $content->video_path;
    }

    // ── Extra JSON ─────────────────────────────────────────────
    $sizes     = array_values(array_filter(
        $request->input('extra_size', []),
        fn($v) => trim($v) !== ''
    ));
    $sizeValue = count($sizes) === 1 ? $sizes[0] : (count($sizes) > 1 ? $sizes : null);

    $extra = json_encode([
        'status'          => $request->input('extra_status'),
        'size'            => $sizeValue,
        'building_height' => $request->input('extra_height'),
        'facing'          => $request->input('extra_facing'),
        'featured'        => $request->input('extra_featured') === 'true',
        'map_url'         => $request->input('extra_map'),
    ]);

    // ── Save ───────────────────────────────────────────────────
    $content->update([
        'type'             => $request->input('type'),
        'parent_id'        => $request->input('parent_id'),
        'name'             => $request->input('name'),
        'title'            => $request->input('title'),
        'short'            => $request->input('short'),
        'img_path'         => $path,
        'img_paths'        => $paths,
        'video_path'       => $video_path,
        'body'             => $request->input('body'),
        'body_2'           => $request->input('body_2'),
        'body_3'           => $request->input('body_3'),
        'body_4'           => $request->input('body_4'),
        'meta_title'       => $request->input('meta_title'),
        'meta_description' => $request->input('meta_description'),
        'meta_keywords'    => $request->input('meta_keywords'),
        'url'              => $request->input('url'),
        'start_date'       => $request->input('start_date'),
        'end_date'         => $request->input('end_date'),
        'location'         => $request->input('location'),
        'extra'            => $extra,
        'status'           => $request->input('status', 0),
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

            $extra    = json_decode($content->extra ?? '{}', true) ?? [];
            $imgPaths = json_decode($content->img_paths ?? '[]', true) ?? [];

            return view('backend.content.edit-project', compact('content', 'type', 'extra', 'imgPaths'));
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
