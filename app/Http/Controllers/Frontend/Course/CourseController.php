<?php

namespace App\Http\Controllers\Frontend\Course;

use App\Models\User;
use App\Models\Video;
use App\Models\Course;
use App\Models\Review;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\ServiceSubCategory;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::take(6)->latest()->get();
        return view('frontend.pages.course.viewAll', compact('courses'));
    }
    public function show(Course $course)
    {
        return view('frontend.pages.course.view', compact('course'));
    }

    public function videos(int $course)
    {
        $course = Course::withAvg('reviews', 'rating')
            ->withCount('reviews')->find($course);
        $videos = Video::with('users')
            ->where('course_id', $course->id)->latest()->get()->groupBy('section');
        $reviews = $course->reviews;
        $user = request()->user();
        $canReview = $user ? $user->purchased('course')->find($course->id) !== null : false;
        $descriptions = Video::where('course_id', $course->id)->latest()->get();
        return view('frontend.pages.course.showVideos', compact('videos', 'course', 'reviews', 'canReview', 'descriptions'));
    }
}
