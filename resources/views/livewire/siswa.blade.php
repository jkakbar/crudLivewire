<div class="container">
    @if (session()->has('message'))
    <div class="pt-3">
        <div class="alert alert-success">
            <li>{{ session('message') }}</li>
        </div>
    </div>
        
    @endif

    <!-- START FORM -->
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <form>
            <div class="mb-3 row">
                <label for="nama_siswa" class="col-sm-2 col-form-label">Nama Siswa</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" wire:model="nama">
                    @error('nama')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="mb-3 row">
                <label for="email" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" wire:model="email">
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="mb-3 row">
                <label for="kelas" class="col-sm-2 col-form-label">Kelas</label>
                <div class="col-sm-10">
                    <input type="number" min="10" max="12" class="form-control" wire:model="kelas">
                    @error('kelas')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="mb-3 row">
                <label for="jurusan" class="col-sm-2 col-form-label">Jurusan</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" wire:model="jurusan">
                    @error('jurusan')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label"></label>
                <div class="col-sm-10">
                    @if ($updateData == false)

                    <button type="button" class="btn btn-primary" name="submit" wire:click="store()">SIMPAN</button>
                    
                    @else

                    <button type="button" class="btn btn-primary" name="submit" wire:click="update()">UPDATE</button>

                    @endif
                </div>
            </div>
        </form>
    </div>
    <!-- AKHIR FORM -->

    <!-- START DATA -->
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <h1>Data Siswa</h1>

        <div class="row justify-content-end pe-2">
            <input type="text" class="form-control mb-1 w-25" placeholder="Search" wire:model.live="cariSiswa">
        </div>
        
        @if ($siswaSelectedID)
        <a wire:click="delete_confirmation('')" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">Delete {{ count($siswaSelectedID) }} Data</a>
        <a wire:click="resetSelectedID()" class="btn btn-secondary btn-sm">Reset</a>
        @endif

        <hr>
        
        <table class="table table-striped table-sortable">
            <thead>
                <tr>
                    <th></th>
                    <th class="col-md-1">No</th>
                    <th class="col-md-2 sort @if($sortColumn == 'nama') {{ $sortDirection }}  @endif" wire:click="sort('nama')">Nama</th>
                    <th class="col-md-2 sort @if($sortColumn == 'email') {{ $sortDirection }}  @endif" wire:click="sort('email')">Email</th>
                    <th class="col-md-1 sort @if($sortColumn == 'kelas') {{ $sortDirection }}  @endif" wire:click="sort('kelas')">Kelas</th>
                    <th class="col-md-3 sort @if($sortColumn == 'jurusan') {{ $sortDirection }}  @endif" wire:click="sort('jurusan')">Jurusan</th>
                    <th class="col-md-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dataSiswa as $key => $siswa)
                    
                <tr>
                    <td><input type="checkbox" wire:key="{{ $siswa->id }}" value="{{ $siswa->id }}" wire:model.live="siswaSelectedID"></td>
                    <td>{{ $dataSiswa->firstItem() + $key }}</td>
                    <td>{{ $siswa->nama }}</td>
                    <td>{{ $siswa->email }}</td>
                    <td>{{ $siswa->kelas }}</td>
                    <td>{{ $siswa->jurusan }}</td>
                    <td>
                        <a wire:click="edit({{ $siswa->id }})" class="btn btn-warning btn-sm">Edit</a>
                        <a wire:click="delete_confirmation({{ $siswa->id }})" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">Del</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $dataSiswa->links() }}
    </div>
    <!-- AKHIR DATA -->
    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Konfirmasi Delete</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah anda yakin akan menghapus data ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                    <button wire:click="delete()" type="button" class="btn btn-primary" data-bs-dismiss="modal">Iya</button>
                </div>
            </div>
        </div>
    </div>
</div>
