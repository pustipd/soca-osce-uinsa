<div class="mb-3 {{ $errors->has('id_mahasiswa') ? 'has-error' : ''}}">
    <label for="id-mahasiswa" class="form-label">{{ 'Nama Mahasiswa' }}</label>
    <select name="id_mahasiswa" id="id-mahasiswa" class="form-select select2">
        <option value="" disabled selected>Pilih Mahasiswa</option>
        @foreach ($list_mahasiswa as $mahasiswa)
            <option value="{{$mahasiswa->id}}" @if (isset($peserta) && $mahasiswa->id == $peserta->id_mahasiswa) selected @endif>{{$mahasiswa->nama}}</option>
        @endforeach
    </select>
    {!! $errors->first('id_mahasiswa', '<p class="text-danger">:message</p>') !!}
</div>
    <div class="mb-3 {{ $errors->has('id_penguji1') ? 'has-error' : ''}}">
        <label for="id-penguji1" class="form-label">{{ 'Penguji 1' }}</label>
        <select name="id_penguji1" id="id-penguji1" class="form-select select2">
            <option value="" disabled selected>Pilih Penguji 1</option>
            @foreach ($list_penguji as $penguji)
                <option value="{{$penguji->id}}" @if (isset($peserta) && $penguji->id == $peserta->id_penguji1) selected @endif>{{$penguji->nama}}</option>
            @endforeach
        </select>
        {!! $errors->first('id_penguji1', '<p class="text-danger">:message</p>') !!}
    </div>

    <div class="mb-3 {{ $errors->has('id_penguji2') ? 'has-error' : ''}}">
        <label for="id-penguji2" class="form-label">{{ 'Penguji 2' }}</label>
        <select name="id_penguji2" id="id-penguji2" class="form-select select2">
            <option value="" disabled selected>Pilih Penguji 2</option>
            @foreach ($list_penguji as $penguji)
                <option value="{{$penguji->id}}" @if (isset($peserta) && $penguji->id == $peserta->id_penguji2) selected @endif>{{$penguji->nama}}</option>
            @endforeach
        </select>
        {!! $errors->first('id_penguji2', '<p class="text-danger">:message</p>') !!}
    </div>

    <div class="mb-3 {{ $errors->has('id-ujian-soca') ? 'has-error' : ''}}">
        <label for="id-ujian-soca" class="form-label">{{ 'Jenis Ujian' }}</label>
        <select name="id_ujian_soca" id="id-ujian-soca" class="form-select select2">
            <option value="" disabled selected>Pilih Ujian</option>
            @foreach ($list_ujian as $ujian)
                <option value="{{$ujian->id}}" @if (isset($peserta) && $ujian->id == $peserta->id_ujian_soca) selected @endif>{{$ujian->nama}}</option>
            @endforeach
        </select>
        {!! $errors->first('id_ujian_soca', '<p class="text-danger">:message</p>') !!}
    </div>

    <div class="d-flex justify-content-between">
        <a href="{{url('soca/exam-scheduled/')}}" class="btn btn-secondary">Cancel
        </a>
        <input  type="submit" class="btn btn-primary me-2" value="Jadwalkan">
    </div>
