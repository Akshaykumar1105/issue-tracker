<?php

namespace App\Services;

use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Plank\Mediable\Facades\MediaUploader;

class HrService
{

    protected $user;
    public function __construct(){
        $this->user = new User();
    }

    public function store($request){
        $this->user->fill($request->all())->save();
        $this->user->assignRole('hr');
        if ($request->file('avatar')) {
            $media =  MediaUploader::fromSource($request->file('avatar'))->toDisk('public')
                ->toDirectory('user')->upload();
            $this->user->attachMedia($media, 'user');
        }
        if(!auth()->user()){
            Auth::login($this->user);
            return [
                'success' =>   __('entity.entityCreated', ['entity' => 'Hr']),
                'route' => route('hr.dashboard')
            ];
        }
        
        return [
            'success' =>   __('entity.entityCreated', ['entity' => 'Hr']),
            'route' => route('login')
        ];
    }

    public function update($id, $request){
        $user = User::find($id);
        $user->fill($request->all());
        $user->save();

        $profile = $request->file('avatar');
        $oldProfile = $user->firstMedia('user');

        if ($oldProfile == '') {
            $media =  MediaUploader::fromSource($profile)->toDisk('public')
                ->toDirectory('user')->upload();
            $user->attachMedia($media, 'user');
        } else if ($profile) {
            $newFileName = pathinfo($profile->getClientOriginalName(), PATHINFO_FILENAME);
            MediaUploader::fromSource($profile)
                ->useFilename($newFileName)
                ->replace($oldProfile);
            $user->syncMedia($oldProfile, 'user');
        }

        return  [
            'success' =>  __('entity.entityUpdated', ['entity' => 'hr ']),
        ];
    }

    public function destroy($id){
        $user = User::find($id);
        $user->getMedia('user')->delete();
        $user->delete();
        return [
            'success' => __('entity.entityDeleted', ['entity' => 'Hr']),
        ];
    }

    public function collection($companyId = null, $request){
        if (auth()->user()->hasRole('hr') == config('site.role.hr')) {
            $query = User::with('company')->whereNull('parent_id');
            if ($companyId) {
                $query->where('company_id', $companyId);
            } else {
                $query->whereNotNull('company_id');
            }
            if ($request->filter) {
                $query->where('company_id',  $request->filter);
            }
            return $query;
        }
        else{
            $query = User::with(['company', 'media'])->whereNull('parent_id');
            if ($request->filter) {
                $query->where('company_id', $request->filter);
            } else {
                $query->whereNotNull('company_id');
            }
            return $query;
        }
    }
}
