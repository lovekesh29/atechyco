<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Vimeo\Laravel\Facades\Vimeo;
use Illuminate\Support\Facades\Storage;
use App\Models\Guru;
use App\Models\Courses;
use App\Models\CourseVideo;
use App\Models\Categories;
use App\Models\SubCategories;

class CourseManagement extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function getCourses()
    {
        $courses = Courses::with('authorName')->paginate(10);
        return view('admin.courses', ['courses' => $courses]);
    }
    public function uploadCourseView(Request $request)
    {
        $guru = Guru::all();
        $categories = Categories::all();
        return view('admin.uploadCourses', ['gurus' => $guru, 'categories' => $categories]);
    }
    public function editCourseView($encryptedCourseId){
        $courseId = Crypt::decryptString($encryptedCourseId);
        $courseDetail = Courses::with('authorName')->with('getCourseSubCat')->where('id', $courseId)->first();
        //dd($courseDetail);

        $courseCategory = Categories::where('id', $courseDetail->getCourseSubCat->catId)->get();
        $courseDetail->courseCategory = $courseCategory;

        $categories = Categories::all();

        $guru = Guru::all();
        //session(['editCourse' => true]);
        return view('admin.editCourses', ['courseDetail' => $courseDetail, 'gurus' => $guru, 'categories' => $categories]);
    }
    public function uploadCourse(Request $request){
        $rules = [
            'title' => 'required',
            'author' => 'required|numeric',
            'subCatId' => 'required|numeric',
            'courseType' => 'required|numeric',
            'description' => 'required',
            'videoFiles' => 'required',
            'courseImage' => 'required|image'
        ];
        
        $validator = Validator::make($request->all(), $rules, $message =[
            'author.numeric' => 'Invalid Author Selected',
            'subCatId.numeric' => 'Invalid Subcategory Selected',
            'courseType.numeric' => 'Invalid Course Type Selected'
        ]);
        if ($validator->fails()) {
            return back()
                    ->withErrors($validator)
                    ->withInput();
        }
        $insertedCourseData = Courses::create([
            'status' => '1',
            'title' => $request->title,
            'author' => $request->author,
            'courseSubCat' => $request->subCatId,
            'courseType' => $request->courseType,
            'description' => $request->description,
            'courseImage' => 'image'
        ]);
        if($request->has('courseImage'))
        {   
            $imageName = $request->file('courseImage')->getClientOriginalName();
            $imageName = str_replace(' ', '-', $imageName);
            //// The below code will remove anything that is not a-z, 0-9 or a dot & -
            $imageName = preg_replace("/[^a-zA-Z0-9.-]/", "", $imageName);

            $request->file('courseImage')->storeAs('courseImage/'.$insertedCourseData->id, $imageName, 'public');

            Courses::where('id', $insertedCourseData->id)
                ->update([
                    'courseImage' => $imageName
                ]);
        }
        

        if($request->has('videoFiles'))
        {
            $i = 0;
            foreach($request->file('videoFiles') as $file)
            {
                $uploadVideodata[$i]['videoUrl'] = Vimeo::upload($file, array(
                    'privacy' => array(
                        'embed' => 'whitelist'
                    )
                )); 
                $uploadVideodata[$i]['courseId'] = $insertedCourseData->id;
                $uploadVideodata[$i]['videoOrder'] = $i;
                $uploadVideodata[$i]['status'] = '1';
                $i++;
            }
            CourseVideo::insert($uploadVideodata);
        }
        return redirect('/admin/courses')->with('successfull', 'Course Uploaded Successfull');
    }
    public function updateCourse(Request $request){
        $rules = [
            'courseId' => 'required',
            'title' => 'required',
            'subCatId' => 'required|numeric',
            'courseType' => 'required|numeric',
            'author' => 'required|numeric',
            'description' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules, $message =[
            'author.numeric' => 'Invalid Author Selected',
            'courseId.required' => 'Invalid Request Sent',
            'subCatId.numeric' => 'Invalid Subcategory Selected',
            'courseType.numeric' => 'Invalid Course Type Selected'
        ]);
        if ($validator->fails()) {
            return back()
                    ->withErrors($validator)
                    ->withInput();
        }
        $courseId = Crypt::decryptString($request->courseId);
        Courses::where('id', $courseId)
        ->update([
            'title' => $request->title,
            'author' => $request->author,
            'courseSubCat' => $request->subCatId,
            'courseType' => $request->courseType,
            'description' => $request->description,
        ]);
        if($request->has('videoFiles'))
        {
            $videoOrder = CourseVideo::where('courseId', $courseId)->max('videoOrder');
            $i = 0;
            $newVideoOrder = $videoOrder+1;
            foreach($request->file('videoFiles') as $file)
            {
                $uploadVideodata[$i]['videoUrl'] = Vimeo::upload($file); 
                $uploadVideodata[$i]['courseId'] = $courseId;
                $uploadVideodata[$i]['videoOrder'] = $newVideoOrder;
                $uploadVideodata[$i]['status'] = '1';
                $i++;
                $newVideoOrder++;
            }
            CourseVideo::insert($uploadVideodata);
        }
        if($request->has('courseImage'))
        {
            $courseImage = Courses::where('id', $courseId)->get('courseImage');

            $imageName = $request->file('courseImage')->getClientOriginalName();
            $imageName = str_replace(' ', '-', $imageName);
            //// The below code will remove anything that is not a-z, 0-9 or a dot & -
            $imageName = preg_replace("/[^a-zA-Z0-9.-]/", "", $imageName);

            Storage::disk('public')->delete('courseImage/'.$courseId.'/'.$courseImage[0]->courseImage);
            $request->file('courseImage')->storeAs('courseImage/'.$courseId, $imageName, 'public');

            Courses::where('id', $courseId)
                    ->update([
                        'courseImage' => $imageName,
                    ]);
        }
        return back()->with('successfull', 'Course Uploaded Successfull');

    }
    public function viewVideos($encryptedCourseId){
        $courseId = Crypt::decryptString($encryptedCourseId);

        $videosData = CourseVideo::with('getCourse')->where('courseId', $courseId)->orderBy('videoOrder')->paginate(10);
        
        return view('admin.viewVideos', ['videosData' => $videosData]);
    }
    public function videoDetailsForm($encryptedVideoUrl){
        $videoUrl = Crypt::decryptString($encryptedVideoUrl);

        $videoDetails = CourseVideo::where('videoUrl', $videoUrl)->first();
        return view('admin.videoMeta', ['videoDetails' => $videoDetails]);

        // $response = Http::withToken(config('vimeo.connections.main.access_token'))->accept('application/vnd.vimeo.*+json;version=3.4')->get('https://api.vimeo.com'.$videoUrl);

        //dd($response);
    }
    public function uploadVideoMeta(Request $request){
        $rules = [
            'videoUrl' => 'required',
            'name' => 'required|string',
            'description' => 'required',
            'videoThumbnil' => 'image',
            'videoOrder' => 'required|numeric'
        ];
        $validator = Validator::make($request->all(), $rules, $message =[
            'videoUrl.required' => 'Invalid request'
        ]);
        if ($validator->fails()) {
            return back()
                    ->withErrors($validator)
                    ->withInput();
        }

        $videoUrl = Crypt::decryptString($request->videoUrl);

        $videoDetails = CourseVideo::where('videoUrl', $videoUrl)->first();

        Vimeo::request($videoUrl, array(
            'name' => $request->name,
            'description' => $request->description,
          ), 'PATCH');

        $path = ($videoDetails->videoThumbnil == null ? null : $videoDetails->videoThumbnil);
        if($request->has('videoThumbnil'))
        {
            $videoThumbnil = $videoDetails->videoThumbnil;
            if($videoThumbnil != null)
            {
                Storage::disk('public')->delete($videoThumbnil);
            }
            $path = $request->file('videoThumbnil')->store('videoThumbnils', 'public');
        }

        CourseVideo::where('videoUrl', $videoUrl)
                ->update(['name' => $request->name,
                          'description' => $request->description,
                          'videoThumbnil' => $path,
                          'videoOrder' => $request->videoOrder]); 

        return back()->with('status', 'Video Meta Updated successfully');
    }
    public function changeCourseStatus(Request $request){
        $courseId = Crypt::decryptString($request->courseId);
        $updatedCourseStatus = ($request->courseStatus == 0) ? '1' : '0';

        $course = Courses::findOrFail($courseId);
        $course->status = $updatedCourseStatus;
        $course->save();

        CourseVideo::where('courseId', $courseId)
                    ->update([
                        'status' => $updatedCourseStatus
                    ]);
    }
    public function viewCategories(){
        $categories = Categories::paginate(10);
        return view('admin.categories', ['categories' => $categories]);
    }
    public function addCategory(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string'
        ]);
        if ($validator->fails()) {
            return back()
                    ->withErrors($validator)
                    ->withInput();
        }
        Categories::create([
            'name' => $request->name
        ]);

        return back()->with('status', 'Categories added successfully');
    }
    public function editCategory(Request $request){
        $rules = [
            'categoryId' => 'required',
            'categoryEditName' => 'required|string'
        ];
        $validator = Validator::make($request->all(), $rules, $message = [
             'categoryId.required' => 'Invalid Request',
             'categoryEditName.required' => 'Category Name is Required'
        ]);
        if ($validator->fails()) {
            return back()
                    ->withErrors($validator)
                    ->withInput();
        }

        $categoryId = Crypt::decryptString($request->categoryId);
        Categories::where('id', $categoryId)
                    ->update([
                        'name' => $request->categoryEditName
                    ]);

        return back()->with('status', 'Categories Updated successfully');
    }
    public function changeCategoryStatus(Request $request){
        $categoryId = Crypt::decryptString($request->categoryId);
        $updatedCategoryStatus = ($request->categoryStatus == 0) ? '1' : '0';

        $category = Categories::findOrFail($categoryId);
        $category->status = $updatedCategoryStatus;
        $category->save();

        SubCategories::where('catId', $categoryId)
                        ->update([
                            'status' => $updatedCategoryStatus
                        ]);

        $subCatIds = $this->getSubCatIds($categoryId);

        Courses::whereIn('courseSubCat', $subCatIds)
                    ->update([
                        'status' => $updatedCategoryStatus
                    ]);

        $courseIds = $this->getCourseIdsBySubCatId($subCatIds);

        CourseVideo::whereIn('courseId', $courseIds)
                    ->update([
                        'status' => $updatedCategoryStatus
                    ]);
    }
    public function viewSubCategories($encryptedCatId){
        $catId = Crypt::decryptString($encryptedCatId);

        $subCategories = SubCategories::where('catId', $catId)->paginate(10);

        return view('admin.subCat', ['subCategories' => $subCategories, 'catId' => $catId]);
    }
    public function addSubCategory(Request $request){
        $rules = [
            'catId' => 'required',
            'subCatName' => 'required|string'
        ];
        $validator = Validator::make($request->all(), $rules, $message = [
             'catId.required' => 'Invalid Request',
             'subCatName.required' => 'Sub Category Name is Required'
        ]);
        if ($validator->fails()) {
            return back()
                    ->withErrors($validator)
                    ->withInput();
        }

        SubCategories::create([
            'catId' => Crypt::decryptString($request->catId),
            'name' => $request->subCatName
        ]);

        return back()->with('status', 'Sub Category Updated successfully');

    }
    public function editSubCategory(Request $request){
        $rules = [
            'subCategoryId' => 'required',
            'subCategoryEditName' => 'required|string'
        ];
        $validator = Validator::make($request->all(), $rules, $message = [
             'subCategoryId.required' => 'Invalid Request',
             'subCategoryEditName.required' => 'Category Name is Required'
        ]);
        if ($validator->fails()) {
            return back()
                    ->withErrors($validator)
                    ->withInput();
        }

        $subCategoryId = Crypt::decryptString($request->subCategoryId);
        SubCategories::where('id', $subCategoryId)
                    ->update([
                        'name' => $request->subCategoryEditName
                    ]);

        return back()->with('status', 'Sub Categories Updated successfully');
    }
    public function changeSubCategoryStatus(Request $request){
        $subCategoryId = Crypt::decryptString($request->subCategoryId);
        $updatedSubCategoryStatus = ($request->subCategoryStatus == 0) ? '1' : '0';

        $subCategory = SubCategories::findOrFail($subCategoryId);
        $subCategory->status = $updatedSubCategoryStatus;
        $subCategory->save();
        

        Courses::where('courseSubCat', $subCategoryId)
                    ->update([
                        'status' => $updatedSubCategoryStatus
                    ]);

        $courseIds = $this->getCourseIdsBySubCatId($subCategoryId);

        

        CourseVideo::whereIn('courseId', $courseIds)
                    ->update([
                        'status' => $updatedSubCategoryStatus
                    ]);
    }
    public function getSubCat(Request $request){
        $subCat = SubCategories::where('catId', $request->catId)->get();

        $string = '';
        foreach($subCat as $subCat){
            $string .= '<option value="'.$subCat->id.'">'. $subCat->name.'</option>';
        }
        echo $string;
    }
}
