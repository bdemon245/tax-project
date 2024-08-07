<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditVideoRequest;
use App\Http\Requests\VideoRequest;
use App\Models\Course;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

class VideoController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function videosByCourse(int $id) {
        $course = Course::where('id', $id)->first(['id', 'name']);
        $videos = $course
            ->videos()
            ->latest()
            ->latest()->get();

        return view('backend.video.viewVideo', compact('videos', 'course'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $videos = Video::latest()->latest()->get();
        $course = Course::where('id', $request->course_id)->first(['id', 'name']);

        return view('backend.video.viewVideo', compact('videos', 'course'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request) {
        $courseId = (int) $request->course_id;
        $courses = Course::latest()->latest()->get(['id', 'name']);
        $section = Video::latest()
            ->pluck('section')
            ->first();

        return view('backend.video.createVideo', compact('courses', 'courseId', 'section'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function show(Video $video) {
        return view('backend.video.showVideo', compact('video'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VideoRequest $request) {
        $course = Course::find($request->course_id);
        $courseSlug = Str::slug($course->name);
        $path = "uploads/course/videos/$courseSlug/$request->file_name";
        if (Storage::exists($request->video)) {
            // mkdir('course');
            Storage::move($request->video, 'public/'.$path);
        }
        Video::create([
            'course_id' => $course->id,
            'title' => str($request->title)->title(),
            'section' => str($request->section)->title(),
            'video' => asset('storage/'.$path),
            'description' => $request->description,
        ]);

        return back()->with([
            'message' => 'Video Created Successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id) {
        $video = Video::find($id);
        $courses = Course::latest()->latest()->get(['id', 'name']);

        return view('backend.video.editVideo', compact('video', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditVideoRequest $request, Video $video) {
        $course = Course::find($request->course_id);
        $videoPath = $video->video;
        $courseSlug = Str::slug($course->name);
        if ($request->video) {
            $path = "uploads/course/videos/$courseSlug/$request->file_name";
            if (Storage::exists($request->video)) {
                $moved = Storage::move($request->video, 'public/'.$path);
                $deleted = $moved ? deleteFile($video->video) : false;
                $videoPath = $moved & $deleted ? asset('storage/'.$path) : $video->video;
            }
        }
        $video->update([
            'course_id' => $course->id,
            'title' => str($request->title)->title(),
            'section' => str($request->section)->title(),
            'video' => $videoPath,
            'description' => $request->description,
        ]);

        return redirect(route('video.index').'?course_id=1')->with([
            'message' => 'Video Updated Successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Video $video) {
        deleteFile($video->video);
        $video->delete();

        return back()->with([
            'message' => 'Video Deleted Successfully',
            'alert-type' => 'success',
        ]);
    }

    public function videoUpload(Request $request) {
        $receiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));
        if (!$receiver->isUploaded()) {
            // file not uploaded
        }

        $fileReceived = $receiver->receive(); // receive file
        if ($fileReceived->isFinished()) {
            // file uploading is complete / all chunks are uploaded
            $file = $fileReceived->getFile(); // get file
            $extension = $file->getClientOriginalExtension();
            $name = str($file->getClientOriginalName())->replaceLast(".$extension", '');
            $fileName = str($name)->slug().'-'.timestamp().'.'.$extension; // a unique file name

            $path = $file->storeAs('/videos', $fileName, 'temp');

            return [
                'path' => "temp/$path",
                'fileName' => $fileName,
                'url' => asset('storage/temp/'.$path),
            ];
        }

        // otherwise return percentage informatoin
        $handler = $fileReceived->handler();

        return [
            'done' => $handler->getPercentageDone(),
            'status' => true,
        ];
    }
}
