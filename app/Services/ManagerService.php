<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ManagerCredentialsEmail;
use App\Notifications\ManagerCredential;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Plank\Mediable\Facades\MediaUploader;

class ManagerService
{

    protected $user;
    public function __construct()
    {
        $this->user = new User();
    }

    public function collection($companyId = null, $request)
    {
        if ($request->role == config('site.role.admin')) {
            $data = User::with('company')->with('hrUser')->whereNotNull('parent_id')->whereNotNull('company_id');
            if ($request->filter) {
                $data->where('company_id', $request->filter);
            }
            if ($request->hr) {
                $data->where('parent_id', $request->hr);
            }
        } else {
            $id = auth()->user()->id;
            return User::where('parent_id', $id)->select('id', 'name', 'email', 'mobile');
        }
        return $data;
    }

    public function store($request){
        if (auth()->user()->hasRole('hr')) {
            $this->user->fill($request->all());
            $this->user->company_id = auth()->user()->company_id;
            $this->user->parent_id = auth()->user()->id;
        } else {
            $this->user->fill($request->all());
            $this->user->parent_id = $request->hr_id;
        }
        $this->user->save();
        $this->user->assignRole('manager');

        if ($request->file('profile_img')) {
            $media =  MediaUploader::fromSource($request->file('profile_img'))->toDisk('public')
                ->toDirectory('user')->upload();
            $this->user->attachMedia($media, 'user');
        }
        $email = $request->email;
        $password = $request->password;

        if (isset($this->user)) {
            $this->user->notify(new ManagerCredential($email, $password));
        }

        return [
            'success' =>  __('entity.entityCreated', ['entity' => 'Manager']),
            'route' => route('hr.manager.index')
        ];
    }

    public function update($id,$request){
        $update = User::where('id', $id)->first();
        $update->fill($request->all())->save();
        $profileImg = $request->file('profile_img');
        $oldProfile = $update->firstMedia('user');

        if ($profileImg) {
            $newFileName = pathinfo($profileImg->getClientOriginalName(), PATHINFO_FILENAME);
            MediaUploader::fromSource($profileImg)
                ->useFilename($newFileName)
                ->replace($oldProfile);
            $update->syncMedia($oldProfile, 'user');
        }

        return  [
            'success' =>  __('entity.entityUpdated', ['entity' => 'Your data']),
            'route' => route('hr.manager.index')
        ];
    }

    public function destroy($id){
        User::where('id', $id)->delete();
        return  response()->json([
            'success' =>  __('entity.entityDeleted', ['entity' => 'Manager'])
        ]);
    }
}
