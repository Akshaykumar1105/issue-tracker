<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ManagerCredentialsEmail;
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

    public function collection($companyId = null, $request){
        if ($request->listing == config('site.role.manager')) {
            $data = User::with('company')->whereNotNull('parent_id');
            if ($companyId) {
                $data = User::with('company')->whereNotNull('parent_id')->where('company_id', $companyId);
            }
            if ($request->filter) {
                $data->where('company_id', $request->filter);
            }
        } else if ($companyId && $request->listing == config('site.role.manager')) {
            $data = User::where('company_id', $companyId)->whereNotNull('parent_id')->select('id', 'name', 'email', 'mobile');
        } else {
            $id = auth()->user()->id;
            return User::where('parent_id', $id)->select('id', 'name', 'email', 'mobile');
        }
        return $data;
    }

    public function store($request){
        $companyId = auth()->user()->company_id;
        $hrId = auth()->user()->id;
        // Fill the user model with data from the request
        $this->user->fill($request->all());
        // Set the company_id and parent_id attributes
        $this->user->company_id = $companyId;
        $this->user->parent_id = $hrId;
        $this->user->save();

        $this->user->assignRole('manager');

        if ($request->file('profile_img')) {
            $media =  MediaUploader::fromSource($request->file('profile_img'))->toDisk('public')
                ->toDirectory('user')->upload();
            $this->user->attachMedia($media, 'user');
        }

        $email = $request->email;
        $password = $request->password;

        Mail::to($email)->send(new ManagerCredentialsEmail($email, $password));

        return [
            'success' =>  __('entity.entityCreated', ['entity' => 'Manager']),
            'route' => route('hr.manager.index')
        ];
    }

    public function update($request, $manager){
        $update = User::where('id', $manager)->first();
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

    public function destroy($request)
    {
        User::where('id', $request->id)->delete();
        return  response()->json([
            'success' =>  __('entity.entityDeleted', ['entity' => 'Manager'])
        ]);
    }
}
