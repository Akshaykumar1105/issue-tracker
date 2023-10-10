<?php

namespace App\Services;

use App\Models\User;
use App\Models\Company;
use Yajra\DataTables\Facades\DataTables;
use Plank\Mediable\Facades\MediaUploader;

class HrService
{

    protected $user;
    public function __construct()
    {
        $this->user = new User();
    }

    public function index(){
        if (!auth()->user()->hasRole(config('site.role.admin'))) {
            return redirect()->route('home');
        }
        return Company::where('is_active', 1)->get();
    }

    public function store($request){
        $this->user->fill($request->all())->save();
        $this->user->assignRole('hr');
        if ($request->file('profile_img')) {
            $media =  MediaUploader::fromSource($request->file('profile_img'))->toDisk('public')
                ->toDirectory('user')->upload();
            $this->user->attachMedia($media, 'user');
        }
        return [
            'success' =>  __('messages.register'),
            'route' => route('login')
        ];
    }

    public function update($request){
        $id = auth()->user()->id;
        $user = User::find($id);
        $user->fill($request->all())->save();

        $profileImg = $request->file('profile_img');
        $oldProfile = $user->firstMedia('user');

        if ($oldProfile == '') {
            $media =  MediaUploader::fromSource($profileImg)->toDisk('public')
                ->toDirectory('user')->upload();
            $user->attachMedia($media, 'user');
        } else if ($profileImg) {
            $newFileName = pathinfo($profileImg->getClientOriginalName(), PATHINFO_FILENAME);
            MediaUploader::fromSource($profileImg)
                ->useFilename($newFileName)
                ->replace($oldProfile);
            $user->syncMedia($oldProfile, 'user');
        }

        return  [
            'success' =>  __('entity.entityUpdated', ['entity' => 'Your data']),
        ];
    }

    public function collection($companyId = null, $request){
        if ($request->listing == config('site.role.hr')) {
            //if companyId not null
            if ($companyId) {
                $query = User::with('company')->whereNull('parent_id')->where('company_id', $companyId);
            } else {
                $query = User::with('company')->whereNull('parent_id')->whereNotNull('company_id');
            }
            // fillter by company
            if ($request->filter) {
                $query->where('company_id',  $request->filter);
            }
            // $query = User::with('company')
            //     ->whereNull('parent_id')
            //     ->where(function ($query) use ($companyId) {
            //         $query->where('company_id', $companyId)
            //             ->orWhereNotNull('company_id');
            //     })
            //     ->when($request->filter, function ($query, $filter) {
            //         return $query->where('company_id', $filter);
            //     });
            return $query;
        }
    }
}
