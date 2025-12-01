
<div class="mb-3 {{ $errors->has('id_mahasiswa') ? 'has-error' : ''}}">
    <label for="id-mahasiswa" class="form-label">{{ 'Nama Mahasiswa' }}</label>
    <select name="id_mahasiswa" id="id-mahasiswa" class="form-select select2">
        <option value="" disabled selected>Pilih Mahasiswa</option>
        @foreach ($list_mahasiswa as $mahasiswa)
            <option value="{{$mahasiswa->id}}" @if (isset($peserta) && $peserta->id_mahasiswa == $mahasiswa->id) selected @endif>{{$mahasiswa->nama}}</option>
        @endforeach
    </select>
    {!! $errors->first('id_mahasiswa', '<p class="text-danger">:message</p>') !!}
</div>

<div class="mb-3 {{ $errors->has('id-ujian') ? 'has-error' : ''}}">
    <label for="id-ujian" class="form-label">{{ 'Ujian' }}</label>
    <select name="id_ujian" id="id-ujian" class="form-select select2">
        <option value="" disabled selected>Pilih Ujian</option>
        @foreach ($list_ujian as $ujian)
            <option value="{{$ujian->id}}" @if (isset($peserta) && $id_ujian == $ujian->id) selected @endif>{{$ujian->nama}}</option>
        @endforeach
    </select>
    {!! $errors->first('id_ujian', '<p class="text-danger">:message</p>') !!}
</div>

<div class="d-flex justify-content-between">
    <a href="#">
        <button class="btn btn-secondary">Cancel</button>
    </a>
    <input type="submit" class="btn btn-primary me-2" value="Jadwalkan">
</div>
