<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest\saveCourseRequest;
use App\Http\Requests\CourseStudentRequest\SaveCourseStudentRequest;
use App\Http\Traits\apiResponseTrait;
use App\Models\Course;
use App\Models\Instructor;
use Illuminate\Http\Request;

class MainController extends Controller {
    use apiResponseTrait;

    public function getCoursesStudents() {

        $courses=Course::get(['id', 'title', 'description', 'images']);

        return $this->apiResponse(1, 'success', $courses);

    }

    public function createCourseStudent(SaveCourseStudentRequest $request) {
        //dd($request);
        $course=$request->user()->courses()->attach($request->course_id);

        return $this->apiResponse(1, 'Success', $course);


    }

    public function getCourseStudent(Request $request) {

        $getcourses=$request->user()->courses()->latest()->paginate();


        return $this->apiResponse(1, 'Success', $getcourses);

    }


    public function createCourse(saveCourseRequest $request) {

        $createCourses=Course::create([ 'title'=> $request->title,
                'description'=> $request->description,
                'images'=> $request->images,
                'instructor_id'=> $request->instructor_id,
                ]);


        return $this->apiResponse(1, 'Success store data', $createCourses);

    }

    public function showCourseById($id) {

        $createCourses=Course::find($id);


        return $this->apiResponse(1, 'Success', $createCourses);

    }

    public function getCoursesInstractour() {
        $courses=Course::with('instructor')->get(['id', 'title', 'description', 'images', 'instructor_id']);
        return $this->apiResponse(1, 'success get data', $courses);
    }


    public function update(saveCourseRequest $request) {
        $findCourses = Course::find($request->id);
       
        $updateCourse = $findCourses->update([ 
                'title'=> $request->title,
                'description'=> $request->description,
                'images'=> $request->images,
                'instructor_id'=> $request->instructor_id,
                ]);

                $user = $findCourses->refresh();

        return $this->apiResponse(1, 'success updated', $user);

    }
    public function delete($id) {

        $deleteCourse = Course::destroy($id);
       
       
        return $this->apiResponse(1, 'success deleted',$deleteCourse );

    }



}
