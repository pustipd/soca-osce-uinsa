
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

<div class="mb-3 {{ $errors->has('id-station') ? 'has-error' : ''}}">
    <label for="id-station" class="form-label">{{ 'Station' }}</label>
    <select name="id_station" id="id-station" class="form-select select2">
        <option value="" disabled selected>Pilih Station</option>
        @foreach ($list_station as $station)
            <option value="{{$station->id}}" @if (isset($peserta) && $peserta->id_station == $station->id) selected @endif>{{$station->no_station}} ({{$station->ujianOsce->nama}})</option>
        @endforeach
    </select>
    {!! $errors->first('id_station', '<p class="text-danger">:message</p>') !!}
</div>

<div class="d-flex justify-content-between">
    <a href="#">
        <button class="btn btn-secondary">Cancel</button>
    </a>
    <input type="submit" class="btn btn-primary me-2" value="Jadwalkan">
</div>
