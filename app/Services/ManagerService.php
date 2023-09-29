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
            $data = User::where('parent_id', $id)->select('id', 'name', 'email', 'mobile');
        }

        return DataTables::of($data)->with('media')->addIndexColumn()
            ->orderColumn('name', function ($query, $order) {
                $query->orderBy('id', $order);
            })
            ->addColumn('profile', function ($row) {
                $user = User::find($row->id);
                $media = $user->firstMedia('user');
                $img = asset('storage/user/' . $media->filename . '.' . $media->extension);
                $profile = '<img class="image--cover" src=' . $img . ' />';
                return $profile;
            })
            ->addColumn('action', function ($row, Request $request) {
                $editRoute = route('hr.manager.edit', ['manager' => $row->id]);
                if ($request->listing == 'manager') {
                    $actionBtn = '<p>No Action</p>';
                    return $actionBtn;
                }
                else{
                    $actionBtn = '<a href=' . $editRoute . ' id="edit' . $row->id . '" data-userId="' . $row->id . '" class="edit btn btn-success btn-sm">Edit</a> <button type="submit" data-userId="' . $row->id . '" class="delete btn btn-danger btn-sm" data-bs-toggle="modal"
                    data-bs-target="#deleteManager">Delete</button>';
                    return $actionBtn;
                }
            })
            ->rawColumns(['profile', 'action'])
            ->make(true);
    }

    public function store($request){
        $companyId = auth()->user()->company_id;
        $hrId = auth()->user()->id;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'company_id' => $companyId,
            'mobile' => $request->mobile_no,
            'parent_id' => $hrId
        ]);

        $user->assignRole('manager');

        if ($request->file('profile_img')) {
            $media =  MediaUploader::fromSource($request->file('profile_img'))->toDisk('public')
                ->toDirectory('user')->upload();
            $user->attachMedia($media, 'user');
        }

        $email = $request->email;
        $password = $request->password;

        Mail::to($email)->send(new ManagerCredentialsEmail($email, $password));

        return response()->json([
            'success' =>  __('entity.entityCreated', ['entity' => 'Manager']),
            'route' => route('hr.manager.index')
        ]);
    }


    public function edit($manager)
    {
    }

    public function update($request, $manager)
    {
        $update = User::where('id', $manager)->first();
        $update->update([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile_no,
        ]);

        $profileImg = $request->file('profile_img');
        $oldProfile = $update->firstMedia('user');


        if ($profileImg) {
            $newFileName = pathinfo($profileImg->getClientOriginalName(), PATHINFO_FILENAME);
            MediaUploader::fromSource($profileImg)
                ->useFilename($newFileName)
                ->replace($oldProfile);
            $update->syncMedia($oldProfile, 'user');
        }

        return  response()->json([
            'success' =>  __('entity.entityUpdated', ['entity' => 'Your data']),
            'route' => route('hr.manager.index')
        ]);
    }

    public function destroy($request)
    {
        User::where('id', $request->id)->delete();
        return  response()->json([
            'success' =>  __('entity.entityDeleted', ['entity' => 'Manager'])
        ]);
    }
}
