<?php

namespace App\Services;

use App\Jobs\ManagerCredential as JobsManagerCredential;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ManagerCredentialsEmail;
use App\Notifications\ManagerCredential;
use Exception;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Plank\Mediable\Facades\MediaUploader;

class ManagerService
{

    protected $user;
    public function __construct(){
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

        if ($request->file('avatar')) {
            $media =  MediaUploader::fromSource($request->file('avatar'))->toDisk('public')
                ->toDirectory('user')->upload();
            $this->user->attachMedia($media, 'user');
        }
        $email = $request->email;
        $password = $request->password;

        if (isset($this->user)) {
            try {
                JobsManagerCredential::dispatch($this->user, $password);
            } catch (Exception $e) {
                Log::info($e);
            }
        }

        return [
            'success' =>  __('entity.entityCreated', ['entity' => 'Manager']),
            'route' => route('hr.manager.index')
        ];
    }

    public function update($id,$request){
        $user = User::where('id', $id)->first();
        $user->fill($request->all())->save();
        $profileImg = $request->file('avatar');
        $oldProfile = $user->firstMedia('user');

        if($oldProfile){
            if ($profileImg) {
                $newFileName = pathinfo($profileImg->getClientOriginalName(), PATHINFO_FILENAME);
                MediaUploader::fromSource($profileImg)
                    ->useFilename($newFileName)
                    ->replace($oldProfile);
                $user->syncMedia($oldProfile, 'user');
            }
        }else{
            if ($request->file('avatar')) {
                $media =  MediaUploader::fromSource($request->file('avatar'))->toDisk('public')
                    ->toDirectory('user')->upload();
                $user->attachMedia($media, 'user');
            }
        }

        return  [
            'success' =>  __('entity.entityUpdated', ['entity' => 'Manager data']),
            'route' => route('hr.manager.index')
        ];
    }

    public function destroy($id){
        $user = User::where('id', $id)->first();
        $user->getMedia('user')->delete();
        $user->delete();
        return  response()->json([
            'success' =>  __('entity.entityDeleted', ['entity' => 'Manager'])
        ]);
    }
}
