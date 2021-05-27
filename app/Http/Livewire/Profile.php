<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Student;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads; // use this namespace to uplade file on livewire

class Profile extends Component
{
    use WithFileUploads; // use trait for uplading files

    private $user;
    public $nis, $nisn, $hobi, $photo, $profile;

    protected $messages = [
        "nis.max" => "Max Angka NIS adalah 4",
        "hobi.max" => "Maximal 30 huruf",
        "photo.mimes" => "Ekstensi Yang diperbolehkan adalah png, jpg, dan jpeg",
        "photo.max" => "Max Size Foto adalah 2MB",
        "photo.image" => "File harus berupa Foto!"
    ];

    public function mount(User $user)
    {
        $this->user = $user;
        $this->nis = Auth::user()->student->nis;
        $this->nisn = Auth::user()->student->nisn;
        $this->hobi = Auth::user()->student->hobi;
        $this->profile  = Auth::user()->photo_profile;
    }

    public function render()
    {
        return view('livewire.profile');
    }

    public function submitProfile()
    {
        // validate
        $this->validate([
            "nis" => "max:4",
            "hobi" => "max:30",
            "photo" => "max:2048"
        ]);

        // after validate
        if($this->photo)
        {
            if(Auth::user()->photo_profile !== "foto-profil.png")
            {
                Storage::delete("public/photo_profiles/" . Auth::user()->photo_profile);
            }

            $name_photo = uniqid() . "." . $this->photo->extension(); // give uniqe name of photo
            $this->photo->storeAs("public/photo_profiles", $name_photo); // store photo on storage
            Storage::deleteDirectory("livewire-tmp");
        }

        if($name_photo ?? false)
        {
            Auth::user()->student->user->update(["photo_profile" => $name_photo]);
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

        session()->flash("success", "Data Profil berhasil di Update!");
    }



}
