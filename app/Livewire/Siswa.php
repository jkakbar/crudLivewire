<?php

namespace App\Livewire;

use App\Models\Siswa as ModelsSiswa;
use Livewire\Component;

class Siswa extends Component
{
    public $nama;
    public $email;
    public $kelas;
    public $jurusan;
    public $dataSiswa;
    public $updateData = false;
    public $id_siswa;

    public function store()
    {
        $rules = [
            'nama' => 'required',
            'email' => 'required|email|unique:siswas,email',
            'kelas' => 'required|integer|min:10|max:12',
            'jurusan' => 'required',
        ];

        $pesan = [
            'nama.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak sesuai',
            'email.unique' => 'Email telah digunakan',
            'kelas.required' => 'Kelas wajib diisi',
            'jurusan.required' => 'Jurusan wajib diisi',
        ];

        $validated = $this->validate($rules, $pesan);
        ModelsSiswa::create($validated);

        $this->reset(['nama', 'email', 'kelas', 'jurusan']);

        session()->flash('message','Data berhasil dimasukkan');
    }

    public function edit($id)
    {
        $data = ModelsSiswa::find($id);
        $this->nama = $data->nama;
        $this->email = $data->email;
        $this->kelas = $data->kelas;
        $this->jurusan = $data->jurusan;

        $this->updateData = true;
        $this->id_siswa = $id;
    }

    public function update()
    {
        $rules = [
            'nama' => 'required',
            'email' => 'required|email',
            'kelas' => 'required|integer|min:10|max:12',
            'jurusan' => 'required',
        ];

        $pesan = [
            'nama.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak sesuai',
            'kelas.required' => 'Kelas wajib diisi',
            'jurusan.required' => 'Jurusan wajib diisi',
        ];

        $validated = $this->validate($rules, $pesan);
        $data = ModelsSiswa::find($this->id_siswa);
        $data->update($validated);

        $this->reset(['nama', 'email', 'kelas', 'jurusan']);

        session()->flash('message','Data berhasil diubah');
    }

    public function delete_confirmation($id)
    {
        $this->id_siswa = $id;
    }

    public function delete()
    {
        $id = $this->id_siswa;

        ModelsSiswa::find($id)->delete();

        $this->reset(['nama', 'email', 'kelas', 'jurusan']);

        session()->flash('message','Data berhasil dihapus');

    }

    public function render()
    {
        $this->dataSiswa = ModelsSiswa::orderBy('nama', 'asc')->get();
        return view('livewire.siswa');
    }
}
