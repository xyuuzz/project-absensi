<?php

namespace App\Http\Livewire;

use DateTime;
use Livewire\Component;

class Home extends Component
{
    public $quotes = [
        "Mimpi Tidak Akan Pernah Menyakiti Siapapun jika dia terus bekerja tepat di belakang mimpinya untuk mewujudkanya semaksimal mungkin.",
        "Teman itu seperti bintang, kadang terlihat kadang tidak.<br>Tapi kita tahu dia selalu ada di sana.",
        "Kamu tidak akan bisa kembali ke masa lalu dan memperbaiki pangkalnya, tapi kamu bisa berubah dari sekarang dan merubah ujungnya",
        "Hidup ini bergerak cukup cepat.<br>Kalau kau tak berhenti dan melihat sekelilingmu sesekali, kau bisa melewatkanya",
        "i havent failed. i just found 10000 ways that wont work..",
        "Sebuah petualang akan memberikan anda cara baru dalam memandang kehidupan.",
        "Bermalas-malas an hanya akan membuat kamu menyesal kemudian"
    ];

    public function render()
    {
        setlocale(LC_TIME, 'id_ID.utf8');
        return view('livewire.home', [
            "quotes" => $this->quotes,
            "date" => new DateTime()
        ]);
    }
}
