<?php

namespace App\Livewire;

use App\Models\Buku;
use App\Models\Kategori;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class BukuComponent extends Component
{
    use WithPagination, WithoutUrlPagination;
    protected $paginationTheme = 'bootstrap';
    public $kategori, $judul, $penulis, $penerbit, $isbn, $tahun, $jumlah, $cari;
    public function render()
    {
        if ($this->cari != '') {
            $data['buku'] = Buku::where('judul', 'like', '%' . $this->cari . '%')->paginate(10);

        } else {
            $data['buku'] = Buku::paginate(10);
        }
        $data['buku'] = Buku::paginate(10);
        $data['category'] = Kategori::all();
        $layout['title'] = 'Kelola Buku';
        return view('livewire.buku-component', $data)->layoutData($layout);
    }
    public function store()
    {
        $this->validate([
            'judul' => 'required',
            'kategori' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahun' => 'required',
            'isbn' => 'required',
            'jumlah' => 'required'
        ],[
            'judul.required'=>'Judul Buku Tidak Boleh Kosong!',
            'kategori.required'=>'Kategori Buku Tidak Boleh Kosong!',
            'penulis.required'=>'Penulis Buku Tidak Boleh Kosong!',
            'penerbit.required'=>'Penerbit Buku Tidak Boleh Kosong!',
            'tahun.required'=>'Tahun Buku Tidak Boleh Kosong!',
            'isbn.required'=>'ISBN Buku Tidak Boleh Kosong!',
            'jumlah.required'=>'Jumlah Buku Tidak Boleh Kosong!'
        ]);

        Buku::create([
            'judul'=>$this->judul,
            'kategori_id'=>$this->kategori,
            'penulis'=>$this->penulis,
            'penerbit'=>$this->penerbit,
            'tahun'=>$this->tahun,
            'isbn'=>$this->isbn,
            'jumlah'=>$this->jumlah,
        ]);
        $this->reset();
        session()->flash('success', 'Berhasil Tambah');
        return redirect()->route('buku'); 
    }
}
