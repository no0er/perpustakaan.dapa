<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use App\Models\Pinjam;

class KembaliComponent extends Component
{
    use WithPagination, WithoutUrlPagination;
    
    protected $paginationTheme = 'bootstrap';
    
    // 1. WAJIB TAMBAHKAN id_pinjam DI SINI
    public $id_pinjam, $judul, $member, $tgl_kembali;

    public function render()
    {
        $layout['title'] = 'Pengembalian Buku';
        $data['pinjam'] = Pinjam::where('status', 'pinjam')->paginate(10);
        return view('livewire.kembali-component', $data)->layoutData($layout);
    }

    public function pilih($id)
    {
        $pinjam = Pinjam::find($id);
        
        if ($pinjam) {
            // 2. ISI id_pinjam supaya bisa dipakai saat klik simpan (store)
            $this->id_pinjam = $pinjam->id; 
            $this->judul = $pinjam->buku?->judul;
            $this->member = $pinjam->user?->nama; // Opsional, buat nampilin nama di modal
        }
    }

    public function store()
    {
        // Sekarang $this->id_pinjam sudah ada isinya
        $pinjam = Pinjam::find($this->id_pinjam);

        if ($pinjam) {
            $pinjam->update([
                'status' => 'kembali',
                'tgl_kembali' => date('Y-m-d')
            ]);

            session()->flash('success', 'Buku Berhasil Dikembalikan!');
            return redirect()->route('kembali'); 
        }
    }
}