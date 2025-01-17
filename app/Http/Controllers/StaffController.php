<?php

namespace App\Http\Controllers;

use App\Constants\FileConstants;
use App\Exceptions\BaseException;
use App\Notifications\EventAssigned;
use App\Services\StaffService;
use App\Staff;
use Exception;
use Faker\Provider\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class StaffController extends Controller
{

    protected $staffService;

    public function __construct(StaffService $staffService)
    {
        $this->staffService = $staffService;
    }


//    /*Notification Demo*/
//    public function showNotification()
//    {
//
//        Auth::user()->notify(new EventAssigned(1));
//
//
//        foreach (Auth::user()->notifications as $notification) {
//            echo "<hr>";
//            echo $notification->data['event_id'];
//        }
//
//    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('staff.manage-staff');
    }

    public function showProfile()
    {
        return view('user.profile');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('staff.add-staff');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData=$request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        try {
            $this->staffService->create($validatedData, Auth::id());
            return redirect()->back()->with([
                'type' => 'success',
                'title' => 'Staff added successfully',
                'message' => 'The given staff has been added successfully'
            ]);
        }catch (Exception $exception) {
            return redirect()->back()->with([
                'type' => 'danger',
                'title' => 'Failed to add the staff',
                'message' => "There was some issue in adding the staff"
            ]);
        }
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
        try{
            $user=Staff::findOrFail($id)->user;

            return view('staff.view-staff')->with([
                'user' => $user
            ]);
        }catch (Exception $exception){
            return redirect()->back()->with([
                'type' => 'danger',
                'title' => 'Failed to add details',
                'message' => "There was some issue in updating the details"
            ]);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /*admin*/
    public function edit($id){

    }


    /*staff*/
    public function staffEdit()
    {
        //
        return view('staff.edit-staff');
    }

    public function fillDetails(){

        /*CHECK IF USER HAS COMPLETED REGISTRATION*/
        /*IF ALREADY COMPLETED REDIRECT TO DASHBOARD*/
        error_log(Auth::user()->staff->is_fully_registered);
        if(Auth::user()->staff->is_fully_registered){
            return redirect('/dashboard');
        }


        return view('staff.fill-details');
    }




    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function staffUpdate(Request $request, $id)
    {
        //
    }

    public function completeRegistration(Request $request)
    {



        $userValidatedData=$request->validate([

            /*DATA FOR USERS TABLE*/
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'contact_no' => 'required|digits:10',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:M,F,O',
            'password' => 'required|confirmed|min:6',
        ]);

        $staffValidatedData=$request->validate([

            /*DATA FOR STAFF TABLE*/
            'is_teaching' => 'sometimes|in:1,0',
            'is_permanent' => 'sometimes|in:1,0',
            'pan' => 'required|digits:10',
            'employee_id' => 'required',
            'date_of_joining_institute' => 'required|date',

            /*bos_chairman*/
            'is_bos_chairman' => 'sometimes|in:1,0',
            'bos_chairman_details' => 'sometimes|required',
            'bos_chairman_certificate_path' => 'sometimes|required|image|mimes:jpg,jpeg,png',

            /*bos_member*/
            'is_bos_member' => 'sometimes|in:1,0',
            'bos_member_details' => 'sometimes|nullable',
            'bos_member_certificate_path' => 'sometimes|nullable|image|mimes:jpg,jpeg,png',

            /*industry_experience*/
            'is_industry_experience' => 'sometimes|in:1,0',
            'industry_experience_years' => 'numeric',
            'industry_experience_details' => 'sometimes|nullable',
            'industry_experience_certificate_path' => 'sometimes|nullable|image|mimes:jpg,jpeg,png',

            /*subject_chairman*/
            'is_subject_chairman' => 'sometimes|in:1,0',
            'subject_chairman_details' => 'sometimes|nullable',
            'subject_chairman_certificate_path' => 'sometimes|nullable|image|mimes:jpg,jpeg,png',

            /*subject_expert*/
            'is_subject_expert' => 'sometimes|in:1,0',
            'subject_expert_details' => 'sometimes|nullable',
            'subject_expert_certificate_path' => 'sometimes|nullable|image|mimes:jpg,jpeg,png',

            /*staff_selection_committee*/
            'is_staff_selection_committee_member' => 'sometimes|in:1,0',
            'staff_selection_committee_details' => 'sometimes|nullable',
            'staff_selection_committee_certificate_path' => 'sometimes|nullable|image|mimes:jpg,jpeg,png',

            /*department_advisory_board*/
            'is_department_advisory_board' => 'sometimes|in:1,0',
            'department_advisory_board_details' => 'sometimes|nullable',
            'department_advisory_board_certificate_path' => 'sometimes|nullable|image|mimes:jpg,jpeg,png',

            /*academic_audit*/
            'is_academic_audit' => 'sometimes|in:1,0',
            'academic_audit_details' => 'sometimes|nullable',
            'academic_audit_certificate_path' => 'sometimes|nullable|image|mimes:jpg,jpeg,png',

            /*subject_expert_phd*/
            'is_subject_expert_phd' => 'sometimes|in:1,0',
            'subject_expert_phd_details' => 'sometimes|nullable',
            'subject_expert_phd_certificate_path' => 'sometimes|nullable|image|mimes:jpg,jpeg,png',

            /*other_universities_examiner*/
            'is_other_universities_examiner' => 'sometimes|in:1,0',
            'other_universities_examiner_details' => 'sometimes|nullable',
            'other_universities_examiner_certificate_path' => 'sometimes|nullable|image|mimes:jpg,jpeg,png',

            /*examination_auditor*/
            'is_examination_auditor' => 'sometimes|in:1,0',
            'examination_auditor_details' => 'sometimes|nullable',
            'examination_auditor_certificate_path' => 'sometimes|nullable|image|mimes:jpg,jpeg,png',

            /*subject_coordinator_src*/
            'is_subject_coordinator_src' => 'sometimes|in:1,0',
            'subject_coordinator_src_details' => 'sometimes|nullable',
            'subject_coordinator_src_certificate_path' => 'sometimes|nullable|image|mimes:jpg,jpeg,png',

            /*iste*/
            'is_iste' => 'sometimes|in:1,0',
            'iste_membership_id' => 'sometimes|nullable',

            /*csi*/
            'is_csi' => 'sometimes|in:1,0',
            'csi_membership_id' => 'sometimes|nullable',

            /*ieee*/
            'is_ieee' => 'sometimes|in:1,0',
            'ieee_membership_id' => 'sometimes|nullable',

            /*acm*/
            'is_acm' => 'sometimes|in:1,0',
            'acm_membership_id' => 'sometimes|nullable',
        ]);

        /*STORE ALL UPLOADED FILES AND STORE THE PATH IN THEIR RESPECTIVE VARIABLES
        $name is the name attribute used in form
        $attachment is the laravel file object
        $attachments are all the uploaded files */

        $attachments = $request->file();

        $user_id = Auth::id();
        foreach ($attachments as $name => $attachment){

            error_log($name);
            // The file name of the attachment
            $fileName = $user_id.'_'.$name.'_'.time().'.'.$attachment->getClientOriginalExtension();
            // exact path on the current machine
            $destinationPath = public_path(FileConstants::STAFF_ATTACHMENTS_PATH);
            // Moving the image
            $attachment->move($destinationPath, $fileName);
            // The relative path to the image
            $staffValidatedData[$name]= FileConstants::STAFF_ATTACHMENTS_PATH.$fileName;
            error_log($staffValidatedData[$name]);
        }

        try {
            $this->staffService->completeRegistration($userValidatedData,$staffValidatedData,Auth::id());
            return redirect('/dashboard')->with([
                'type' => 'success',
                'title' => 'Staff added successfully',
                'message' => 'The given staff has been added successfully'
            ]);
        }catch (BaseException $exception) {
            return redirect()->back()->with([
                'type' => 'danger',
                'title' => 'Failed to add the staff',
                'message' => $exception->errorMessage()
            ]);
        }
        catch (Exception $exception) {
            return redirect()->back()->with([
                'type' => 'danger',
                'title' => 'Failed to add details',
                'message' => $exception->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Returns the data for datatables.
     * @return mixed Resulting data in datatables.net format
     * @throws \Exception*
     */
    public function getRegisteredStaff()
    {

        $registeredStaff = $this->staffService->getRegisteredStaffDatatable();


        return DataTables::of($registeredStaff)
            ->addColumn('name', function(Staff $staff) {
//                Redirect to page
                return $staff->user->first_name.' '.$staff->user->middle_name.' '.$staff->user->last_name;
            })
            ->addColumn('dob', function(Staff $staff) {
//                Redirect to page
                return date('F d, Y', strtotime($staff->user->date_of_birth));
            })
            ->addColumn('email', function(Staff $staff) {
//                Redirect to page
                return $staff->user->email;
            })
            ->addColumn('contact_no', function(Staff $staff) {
//                Redirect to page
                return $staff->user->contact_no;
            })
            ->addColumn('delete', function(Staff $staff) {
                return '<button id="'.$staff->id.'" class="delete fa fa-trash btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal"></button>';
            })
            ->addColumn('edit', function(Staff $staff) {
                return '<button id="'.$staff->id.'" class="edit fa fa-pencil-alt btn-sm btn-warning" data-toggle="modal" data-target="#editModal"></button>';
            })
            ->addColumn('view', function(Staff $staff) {
                return '<a  class="view fa fa-search-plus btn-sm btn-success" href="/admin/staff/'.$staff->id.'"></a>';
            })
            ->rawColumns(['edit', 'delete', 'view'])
            ->make(true);

    }


    /**
     * Returns the data for datatables.
     * @return mixed Resulting data in datatables.net format
     * @throws \Exception*
     */
    public function getUnRegisteredStaff()
    {
        /*CURRENT USER PUBLISHED BOOKS*/
        $unRegisteredStaff = $this->staffService->getUnRegisteredStaffDatatable();

        return DataTables::of($unRegisteredStaff)
            ->addColumn('email', function(Staff $staff) {
                return $staff->user->email;
            })
            ->addColumn('delete', function(Staff $staff) {
                return '<button id="'.$staff->id.'" class="delete fa fa-trash btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal"></button>';
            })
            ->addColumn('edit', function(Staff $staff) {
                return '<button id="'.$staff->id.'" class="edit fa fa-pencil-alt btn-sm btn-warning" data-toggle="modal" data-target="#editModal"></button>';
            })
            ->rawColumns(['edit', 'delete', 'view'])
            ->make(true);
    }
}
