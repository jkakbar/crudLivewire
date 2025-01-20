<?php

namespace App\Livewire;

use App\Models\Siswa as ModelsSiswa;
use Livewire\Component;
use Livewire\WithPagination;

class Siswa extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $nama;
    public $email;
    public $kelas;
    public $jurusan;
    public $updateData = false;
    public $id_siswa;
    public $cariSiswa;
    public $siswaSelectedID = [];
    public $sortColumn = 'nama';
    public $sortDirection = 'asc';

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
        $data = ModelsSiswa::find($this->id_siswa);

        $rules = [
            'nama' => 'required',
            'email' => 'required|email|unique:siswas,email,' . $data->id . 'id',
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
        
        $data->update($validated);

        $this->reset(['nama', 'email', 'kelas', 'jurusan']);

        session()->flash('message','Data berhasil diubah');
    }

    public function delete_confirmation($id)
    {
        if ($id != '') {
            $this->id_siswa = $id;
        }
    }

    public function delete()
    {
        if ($this->id_siswa != '') {
            $id = $this->id_siswa;
            ModelsSiswa::find($id)->delete();
        }

        if (count($this->siswaSelectedID)) {
            for($x = 0 ; $x < count($this->siswaSelectedID); $x++) {
                ModelsSiswa::find($this->siswaSelectedID[$x])->delete();
            }
        }

        $this->siswaSelectedID = [];

        $this->reset(['nama', 'email', 'kelas', 'jurusan']);

        session()->flash('message','Data berhasil dihapus');

    }

    public function resetSelectedID()
    {
        $this->siswaSelectedID = [];
    }

    public function sort($columnName)
    {
        $this->sortColumn = $columnName;
        $this->sortDirection = $this->sortDirection == 'asc' ? 'desc' : 'asc';
    }

    public function render()
    {
        if ($this->cariSiswa != null) {
            $data = ModelsSiswa::where('nama', 'like', '%' . $this->cariSiswa . '%')
            ->orWhere('email', 'like', '%' . $this->cariSiswa . '%')
            ->orWhere('kelas', 'like', '%' . $this->cariSiswa . '%')
            ->orWhere('jurusan', 'like', '%' . $this->cariSiswa . '%')
            ->orderBy($this->sortColumn, $this->sortDirection)->paginate(5);
        } else {
            $data = ModelsSiswa::orderBy($this->sortColumn, $this->sortDirection)->paginate(5);
        }
        
        return view('livewire.siswa', ['dataSiswa' => $data]);
    }
}
