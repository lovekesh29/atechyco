<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Guru;
use App\Models\SecurityQuestion;
use App\Models\CreditPoints;
use App\Models\Countries;
use App\Models\Subscription;
use App\Models\UserSubscriptions;
use App\Models\PaymentDetails;
use App\Models\Page;
use App\Models\CourseComment;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\CommentStatus;
use DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function dashboard(){
        $userCount = User::select(DB::raw("(COUNT(*)) as count"),DB::raw("MONTHNAME(created_at) as monthname"))
                            ->whereYear('created_at', date('Y'))
                            ->groupBy('monthname')
                            ->get();

        $guruCount = Guru::select(DB::raw("(COUNT(*)) as count"),DB::raw("MONTHNAME(created_at) as monthname"))
                            ->whereYear('created_at', date('Y'))
                            ->groupBy('monthname')
                            ->get();

        $subscriptionCount = UserSubscriptions::select(DB::raw("(COUNT(*)) as count"),DB::raw("MONTHNAME(created_at) as monthname"))
                                        ->whereYear('created_at', date('Y'))
                                        ->groupBy('monthname')
                                        ->get();

        return view('admin.dashboard', ['userCount' => $userCount, 'subscriptionCount' => $subscriptionCount, 'guruCount' => $guruCount]);
    }

    public function users(){
        $users = User::with('country')->with('referer')->withSum('commisonBalance', 'creditPoints')->get();
        //dd($users);
        return view('admin.users', ['users' => $users]);
    }
    public function gurus(){
        $gurus = Guru::with('country')->get();
        return view('admin.gurus', ['gurus' => $gurus]);
    }
    public function changeUserStatus(Request $request){
        $updatedUserStatus = ($request->userStatus == 0) ? 1 : 0;
        $userId = explode('_', $request->userId);  //since user id form frontend is with '_'. For eg user_1

        $user = User::findOrFail($userId[1]);
        $user->status = $updatedUserStatus;
        $user->save();
    }
    public function changeGuruStatus(Request $request){
        $updatedGuruStatus = ($request->guruStatus == 0) ? 1 : 0;
        $guruId = explode('_', $request->guruId);  //since user id form frontend is with '_'. For eg user_1

        $guru = Guru::findOrFail($guruId[1]);
        $guru->status = $updatedGuruStatus;
        $guru->save();
    }
    public function editUser($userId){
        $decryptedUserId = Crypt::decryptString($userId);
        $userDetails = User::with('securityQuestionDetail')->with('country')->findOrFail($decryptedUserId);
        //dd($userDetails);
        $securityQuestions = SecurityQuestion::all();
        $countries = Countries::all();
        //dd($userDetails);

        return view('admin.editUser', ['userDetails' => $userDetails, 'securityQuestions' => $securityQuestions, 'countries' => $countries]);
    }
    public function editGuru($guruId){
        $decryptedGuruId = Crypt::decryptString($guruId);
        $guruDetails = Guru::with('securityQuestionDetail')->with('country')->findOrFail($decryptedGuruId);
        //dd($userDetails);
        $securityQuestions = SecurityQuestion::all();
        $countries = Countries::all();
        //dd($userDetails);

        return view('admin.editGuru', ['guruDetails' => $guruDetails, 'securityQuestions' => $securityQuestions, 'countries' => $countries]);
    }
    public function adminEditUser(Request $request)
    {
        $rules = [
            'userId' => 'required',
            'firstName' => 'required|string|max:180',
            'lastName' => 'required|string|max:180',
            'email' => 'required|email',
            'location' => 'required|string',
            'phoneNo' => 'required|max:15|string',
            'age' => 'required|numeric|digits_between:0,100',
            'securityQuestion' => 'required|numeric',
            'securityAnswer' => 'required|string',
            'gender' => 'required|digits_between:0,2',
            'dialCode' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules, $messages = [
            'securityQuestion.numeric' => 'Invalid Security Question Selected',
            'gender.digits_between' => 'Invalid Gender Selected',
            'userId.required' => 'Invalid Request',
            'dialCode.required' => 'Invalid request'
        ]);
        if ($validator->fails()) {
            return back()
                    ->withErrors($validator)
                    ->withInput();
        }

        $userId = Crypt::decryptString($request->userId);

        User::where('id', $userId)
                ->update(['firstName' => $request->firstName,
                          'lastName' => $request->lastName,
                          'email' => $request->email,
                          'phoneNo' => '+'.$request->dialCode.$request->phoneNo,
                          'location' => $request->location,
                          'dialCode' => $request->dialCode,
                          'age' => $request->age,
                          'gender' => $request->gender,
                          'securityQuestion' => $request->securityQuestion,
                          'securityAnswer' => $request->securityAnswer ]); 

        return back()->with('status', 'User Data Updated');
    }
    public function adminEditGuru(Request $request)
    {
        $rules = [
            'guruId' => 'required',
            'firstName' => 'required|string|max:180',
            'lastName' => 'required|string|max:180',
            'email' => 'required|email',
            'location' => 'required|string',
            'phoneNo' => 'required|max:15|string',
            'age' => 'required|numeric|digits_between:0,100',
            'securityQuestion' => 'required|numeric',
            'securityAnswer' => 'required|string',
            'gender' => 'required|digits_between:0,2',
            'dialCode' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules, $messages = [
            'securityQuestion.numeric' => 'Invalid Security Question Selected',
            'gender.digits_between' => 'Invalid Gender Selected',
            'userId.required' => 'Invalid Request',
            'dialCode.required' => 'Invalid request'
        ]);
        if ($validator->fails()) {
            return back()
                    ->withErrors($validator)
                    ->withInput();
        }

        $guruId = Crypt::decryptString($request->guruId);

        Guru::where('id', $guruId)
                ->update(['firstName' => $request->firstName,
                          'lastName' => $request->lastName,
                          'email' => $request->email,
                          'phoneNo' => '+'.$request->dialCode.$request->phoneNo,
                          'location' => $request->location,
                          'dialCode' => $request->dialCode,
                          'age' => $request->age,
                          'gender' => $request->gender,
                          'securityQuestion' => $request->securityQuestion,
                          'securityAnswer' => $request->securityAnswer ]); 

        return back()->with('status', 'Guru Data Updated');
    }
    public function viewSubscriptions(){
            $subscriptions = Subscription::all();
            return view('admin.subscriptions', ['subscriptions' => $subscriptions]);
    }
    public function addSubscription(Request $request){
        if($request->name != null){
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:180',
                'validity' => 'required|numeric|min:0',
                'price' => 'required|numeric|min:0',
                'description' =>'required'
            ]);
            if ($validator->fails()) {
                return back()
                        ->withErrors($validator)
                        ->withInput();
            }

            Subscription::create([
                'name' => $request->name,
                'validity' => $request->validity,
                'price' => $request->price,
                'description' => $request->description
            ]);

            return back()->with('status', 'Subscription Added Successfull');

        } else {
            return view('admin.subscriptionForm');
        }
    }
    public function editSubscription($encryptedSubscriptionId){
        try {
            $subscriptionId = Crypt::decryptString($encryptedSubscriptionId);
        } catch (DecryptException $e) {
            abort(419);
        }

        $subscriptionDetails = Subscription::findOrFail($subscriptionId);
        return view('admin.editSubscription', ['subscriptionDetails' => $subscriptionDetails]);        
    }
    public function updateSubscription(Request $request)
    {
            $validator = Validator::make($request->all(), [
                'subscriptionId' => 'required',
                'name' => 'required|string|max:180',
                'validity' => 'required|numeric|min:0',
                'price' => 'required|numeric|min:0',
                'description' =>'required'
            ]);
            if ($validator->fails()) {
                return back()
                        ->withErrors($validator)
                        ->withInput();
            }

            try {
                $subscriptionId = Crypt::decryptString($request->subscriptionId);
            } catch (DecryptException $e) {
                abort(419);
            }
            Subscription::where('id', $subscriptionId)
                            ->update([
                                'name' => $request->name,
                                'validity' => $request->validity,
                                'price' => $request->price,
                                'description' => $request->description
                            ]);
            
            return back()->with('status', 'Subscription Updated Successfull');
    }
    public function settings()
    {
        $creditPoints = CreditPoints::first();
        return view('admin.creditPointForm', ['creditPoints' => $creditPoints]);
    }
    public function setCreditPoints(Request $request){
        $validator = Validator::make($request->all(), [
            'creditPoints' => 'required|numeric|min:0',
        ]);
        if ($validator->fails()) {
            return back()
                    ->withErrors($validator)
                    ->withInput();
        }

        CreditPoints::where('id', 1)
                      ->update(['creditPoints' => $request->creditPoints]);

        return back()->with('status', 'Credit Points Updated Successfully');

    }
    public function getTransactions(){
        $paymentDetails = PaymentDetails::with('getUser')->orderByDesc('id')->paginate(10);

        return view('admin.paymentDetails', ['paymentDetails' => $paymentDetails]);
    }

    public function getComments(){
        $comments = CourseComment::with('getUser')->with('getCourse') ->paginate(10);

        return view('admin.comments', ['comments' => $comments]);
    }

    public function changeCommentStatus(Request $request){
        $commentId = Crypt::decryptString($request->commentId);
        $updatedCommentStatus = ($request->commentStatus == 0) ? '1' : '0';

        $comment = CourseComment::with('getUser')->findOrFail($commentId);
        $comment->status = $updatedCommentStatus;
        $comment->save();


        Mail::to($comment->getUser->email)->send(new CommentStatus($comment));
        
    }

    public function showPages(){
        $pages = Page::paginate(10);


        return view('admin.pages', ['pages' => $pages]);
    }

    public function addPageForm(){
        return view('admin.addPageForm');
    }

    public function addPage(Request $request){
        $request->pageUrl = str_replace(' ', '-', $request->pageUrl);
        //// The below code will remove anything that is not a-z, 0-9 or a dot & -
        $request->pageUrl = preg_replace("/[^a-zA-Z0-9.-]/", "", $request->pageUrl);

        $validator = Validator::make($request->all(), [
            'bannerHeading' => 'required|string',
            'pageUrl' => 'required|string|unique:pages',
            'pageHeading' => 'required|string',
            'pageContent' => 'required|string',
            'metaTitle' =>'required|string',
            'metaDescription' =>'required|string',
            'bannerImage' =>'image',
            'pageImage' =>'image',
        ]);
        if ($validator->fails()) {
            return back()
                    ->withErrors($validator)
                    ->withInput();
        }

        $insertedPage = Page::create([
            'bannerHeading' => $request->bannerHeading,
            'pageUrl' => $request->pageUrl,
            'pageHeading' => $request->pageHeading,
            'pageContent' => $request->pageContent,
            'metaTitle' => $request->metaTitle,
            'metaDescription' => $request->metaDescription
        ]);
        if($request->has('bannerImage'))
        {   
            $imageName = $request->file('bannerImage')->getClientOriginalName();
            $imageName = str_replace(' ', '-', $imageName);
            //// The below code will remove anything that is not a-z, 0-9 or a dot & -
            $imageName = preg_replace("/[^a-zA-Z0-9.-]/", "", $imageName);

            $request->file('bannerImage')->storeAs('pageBanner/'.$insertedPage->id, $imageName, 'public');

            Page::where('id', $insertedPage->id)
                ->update([
                    'bannerImage' => $imageName
                ]);
        }
        if($request->has('pageImage'))
        {   
            $imageName = $request->file('pageImage')->getClientOriginalName();
            $imageName = str_replace(' ', '-', $imageName);
            //// The below code will remove anything that is not a-z, 0-9 or a dot & -
            $imageName = preg_replace("/[^a-zA-Z0-9.-]/", "", $imageName);

            $request->file('pageImage')->storeAs('pageImage/'.$insertedPage->id, $imageName, 'public');

            Page::where('id', $insertedPage->id)
                ->update([
                    'pageImage' => $imageName
                ]);
        }
        

        return redirect('/admin/pages')->with('successfull', 'Page was added successfully');


    }
    public function changePageStatus(Request $request){
        //dd($request);
        $pageId = Crypt::decryptString($request->pageId);
        $updatedPageStatus = ($request->pageStatus == 0) ? '1' : '0';

        $page = Page::findOrFail($pageId);
        $page->status = $updatedPageStatus;
        $page->save();
        
    }
    public function editPageView($encryptedPageId){
        $pageId = Crypt::decryptString($encryptedPageId);

        $pageDetails = Page::findOrFail($pageId);

        return view('admin.editPage', ['pageDetails' => $pageDetails]);
    }
    public function editPage(Request $request){
        $request->pageUrl = str_replace(' ', '-', $request->pageUrl);
        //// The below code will remove anything that is not a-z, 0-9 or a dot & -
        $request->pageUrl = preg_replace("/[^a-zA-Z0-9.-]/", "", $request->pageUrl);

        $validator = Validator::make($request->all(), [
            'pageId' => 'required',
            'oldPageUrl' => 'required',
            'bannerHeading' => 'required|string',
            'pageUrl' => 'required|string',
            'pageHeading' => 'required|string',
            'pageContent' => 'required|string',
            'metaTitle' =>'required|string',
            'metaDescription' =>'required|string',
            'bannerImage' =>'image',
            'pageImage' =>'image',
        ]);
        if ($validator->fails()) {
            return back()
                    ->withErrors($validator)
                    ->withInput();
        }

        $existingUrl = Page::where('pageUrl', $request->oldPageUrl)->value('pageUrl');

        //dd($existingUrl);

        if($existingUrl != $request->pageUrl){
            $existingUrlCount = Page::where('pageUrl', $request->pageUrl)->count();
            if($existingUrlCount > 0){
                return back()->with('error', 'This Url already Exists');
            }
        }
        


        $pageId = Crypt::decryptString($request->pageId);
        Page::where('id', $pageId)
            ->update([
                'bannerHeading' => $request->bannerHeading,
                'pageUrl' => $request->pageUrl,
                'pageHeading' => $request->pageHeading,
                'pageContent' => $request->pageContent,
                'metaTitle' => $request->metaTitle,
                'metaDescription' => $request->metaDescription
            ]);

        if($request->has('bannerImage'))
        {
            $bannerImage = Page::where('id', $pageId)->value('bannerImage');

            $imageName = $request->file('bannerImage')->getClientOriginalName();
            $imageName = str_replace(' ', '-', $imageName);
            //// The below code will remove anything that is not a-z, 0-9 or a dot & -
            $imageName = preg_replace("/[^a-zA-Z0-9.-]/", "", $imageName);

            Storage::disk('public')->delete('pageBanner/'.$pageId.'/'.$bannerImage);
            $request->file('bannerImage')->storeAs('pageBanner/'.$pageId, $imageName, 'public');

            Page::where('id', $pageId)
                    ->update([
                        'bannerImage' => $imageName,
                    ]);
        }
        if($request->has('pageImage'))
        {
            $pageImage = Page::where('id', $pageId)->value('pageImage');

            $imageName = $request->file('pageImage')->getClientOriginalName();
            $imageName = str_replace(' ', '-', $imageName);
            //// The below code will remove anything that is not a-z, 0-9 or a dot & -
            $imageName = preg_replace("/[^a-zA-Z0-9.-]/", "", $imageName);

            Storage::disk('public')->delete('pageImage/'.$pageId.'/'.$pageImage);
            $request->file('pageImage')->storeAs('pageImage/'.$pageId, $imageName, 'public');

            Page::where('id', $pageId)
                    ->update([
                        'pageImage' => $imageName,
                    ]);
        }

        return back()->with('successfull', 'Page has been updated successfully');
    }
}
