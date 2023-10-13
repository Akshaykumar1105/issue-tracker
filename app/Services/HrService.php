<?php

namespace App\Services;

use App\Models\User;
use App\Models\Company;
use Yajra\DataTables\Facades\DataTables;
use Plank\Mediable\Facades\MediaUploader;

class HrService
{

    protected $user;
    public function __construct(){
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

    public function update($id, $request){
        $user = User::find($id);
        $user->fill($request->all());
        $user->save();

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

    public function destroy($id){
        $user = User::find($id);
        $user->delete();
        return [
            'success' => __('entity.entityDeleted', ['entity' => 'Hr']),
        ];
    }

    public function collection($companyId = null, $request){
        if ($request->listing == config('site.role.hr')) {
            if ($companyId) {
                $query = User::with('company')->whereNull('parent_id')->where('company_id', $companyId);
            } else {
                $query = User::with('company')->whereNull('parent_id')->whereNotNull('company_id');
            }
            if ($request->filter) {
                $query->where('company_id',  $request->filter);
            }
            return $query;
        }
    }
}
