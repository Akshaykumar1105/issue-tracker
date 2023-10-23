<?php
namespace App\Services;

use App\Models\User;
use Plank\Mediable\Facades\MediaUploader;


class ProfileService{
    public function update($request){
        $id = auth()->user()->id;
        $user = User::find($id);
        $user->fill($request->all())->save();

        $profileImg = $request->file('avatar');
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
}
?>