<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\{Component, WithFileUploads}; // use this namespace to uplade file on livewire
use Illuminate\Support\Facades\{Storage, Auth};

class Profile extends Component
{
    use WithFileUploads; // use trait for uplading files

    protected $user;
    public $nis, $nisn, $hobi, $photo, $profile; // model

    public function mount(User $user)
    {
        $this->user = $user;
        $this->nis = Auth::user()->student->nis;
        $this->nisn = Auth::user()->student->nisn;
        $this->hobi = Auth::user()->student->hobi;
        $this->profile  = Auth::user()->student->photo_profile;
    }

    public function render()
    {
        return view('livewire.profile');
    }

    public function submitProfile()
    {
        // validate
        $this->validate([
            "nis" => "max:6",
            "hobi" => "max:30",
            "photo" => "max:1024"
        ], [
            "nis.max" => "Max Angka NIS adalah 6",
            "hobi.max" => "Maximal 30 huruf",
            "photo.mimes" => "Ekstensi Yang diperbolehkan adalah png, jpg, dan jpeg",
            "photo.max" => "Max Size Foto adalah 1MB",
            "photo.image" => "File harus berupa Foto!"
        ]);

        // after validate
        if($this->photo)
        {
            if(Auth::user()->student->photo_profile !== "foto-profil.png")
            {
                Storage::delete("public/photo_profiles/" . Auth::user()->student->photo_profile);
            }
            $name_photo = uniqid() . "." . $this->photo->extension(); // give uniqe name of photo
            $this->photo->storeAs("public/photo_profiles", $name_photo); // store photo on storage
            if(Storage::exists("livewire-tmp")) { Storage::deleteDirectory("livewire-tmp"); }

            Auth::user()->student->update(["photo_profile" => $name_photo]);
            $this->profile = $name_photo;
        }

        // Store Data on Database Table
        Auth::user()->student->update([
            "nis" => $this->nis ?? '',
            "nisn" => $this->nisn ?? '',
            "hobi" => $this->hobi ?? ''
        ]);

        $this->updateValue();

        return redirect()->back();
    }

    private function updateValue()
    {
        $this->nis = Auth::user()->student->nis;
        $this->nisn = Auth::user()->student->nisn;
        $this->hobi = Auth::user()->student->hobi;
        $this->photo = null;

        $this->emit("updatePhoto");
        session()->flash("success", "Data Profil berhasil di Update!");
    }
}
