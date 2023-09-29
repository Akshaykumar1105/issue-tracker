<?php
namespace App\Services;

use App\Models\User;
use App\Models\Company;
use Yajra\DataTables\Facades\DataTables;
use Plank\Mediable\Facades\MediaUploader;

class HrService {

    protected $user;
    public function __construct(){
        $this->user = new User();
    }
    
    public function index(){
        $company = Company::where('is_active', 1)->get();
        if(!auth()->user()){
            return view('user.hr.register', ['companies' => $company]);
        }
        return redirect()->route('home');
    }

    public function store($request){
        $this->user->fill($request->all())->save();

        $this->user->assignRole('hr');
        
        if($request->file('profile_img')){
            $media =  MediaUploader::fromSource($request->file('profile_img'))->toDisk('public')
            ->toDirectory('user')->upload();
            $this->user->attachMedia($media, 'user');
        }
        return response()->json([
            'success' =>  __('messages.register'),
            'route' => route('login')
        ]);
    }

    public function update($request){
        $id = auth()->user()->id;
        $user = User::find($id);
        $user->fill($request->all())->save();

        $profileImg = $request->file('profile_img');
        $oldProfile = $user->firstMedia('user');
        
        if($oldProfile == ''){
            $media =  MediaUploader::fromSource($profileImg)->toDisk('public')
            ->toDirectory('user')->upload();
            $user->attachMedia($media, 'user');
        }
        
        else if ($profileImg) {
            $newFileName = pathinfo($profileImg->getClientOriginalName(), PATHINFO_FILENAME);
            MediaUploader::fromSource($profileImg)
            ->useFilename($newFileName)
            ->replace($oldProfile);
            $user->syncMedia($oldProfile, 'user');
        }

        return  response()->json([
            'success' =>  __('entity.entityUpdated', ['entity' => 'Your data']),
        ]);
    }


    public function collection($companyId = null, $request){
        if($request->listing == config('site.role.hr')){
            //if companyId not null
            if($companyId){
                $query = User::with('company')->whereNull('parent_id')->where('company_id', $companyId);
            }
            else{
                $query = User::with('company')->whereNull('parent_id')->whereNotNull('company_id');
            }

            
            // fillter by company
            if ($request->filter) {
                $query->where('company_id',  $request->filter);
            }
            return DataTables::of($query)
                ->addIndexColumn()
                ->orderColumn('name', function ($query, $order) {
                    $query->orderBy('id', $order);
                })
                ->addColumn('action', function ($row) {
                    $manager = $row->id;
                    $showManager = route('admin.user.show', ['manager' => $manager]);
                    $actionBtn = '<a href=' . $showManager . ' id="edit' . $row->id . '" data-userId="' . $row->id . '" class="view btn btn-primary btn-sm">View</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

}


