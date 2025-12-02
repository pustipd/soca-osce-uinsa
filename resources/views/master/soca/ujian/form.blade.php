<div class="mb-3 {{ $errors->has('nama') ? 'has-error' : ''}}">
    <label for="nama" class="form-label">{{ 'Nama' }}</label>
    <input class="form-control" name="nama" type="text" id="nama" value="{{ isset($ujian->nama) ? $ujian->nama : ''}}" >
    {!! $errors->first('nama', '<p class="text-danger">:message</p>') !!}
</div>
<div class="mb-3 {{ $errors->has('sesi') ? 'has-error' : ''}}">
    <label for="sesi" class="form-label">{{ 'Sesi' }}</label>
    <input class="form-control" name="sesi" type="number" id="sesi" value="{{ isset($ujian->sesi) ? $ujian->sesi : ''}}" >
    {!! $errors->first('sesi', '<p class="text-danger">:message</p>') !!}
</div>
<div class="mb-3 {{ $errors->has('waktu') ? 'has-error' : ''}}">
    <label for="waktu" class="form-label">{{ 'Waktu' }}</label>
    <input class="form-control" name="waktu" type="date" id="waktu" value="{{ isset($ujian->waktu) ? Carbon\Carbon::parse($ujian->waktu)->format("Y-m-d") : ''}}" >
    {!! $errors->first('waktu', '<p class="text-danger">:message</p>') !!}
</div>
<div class="mb-3 {{ $errors->has('id_kriteria') ? 'has-error' : ''}}">
    <label for="id_kriteria" class="form-label">{{ 'Kriteria' }}</label>
    <textarea name="kriteria" id="kriteria" cols="10" rows="5" class="form-control">{{ isset($ujian->kriteria) ? $ujian->kriteria : '' }}</textarea>
    {{-- <select name="id_kriteria" id="id_kriteria" class="form-select">
        <option value="" disabled selected>Pilih Kriteria</option>
        @foreach ($list_kriteria as $item)
            <option value="{{$item->id}}" @if (isset($ujian) && $item->id == $ujian->id_kriteria) selected @endif>{{$item->nama}}</option>
        @endforeach
    </select> --}}
    {!! $errors->first('kriteria', '<p class="text-danger">:message</p>') !!}
</div>
<div class="mb-3 {{ $errors->has('batasnilai') ? 'has-error' : ''}}">
    <label for="batasnilai" class="form-label">{{ 'Batas Nilai' }}</label>
    <input class="form-control" name="batasnilai" type="number" id="batasnilai" value="{{ isset($ujian->batasnilai) ? $ujian->batasnilai : ''}}" >
    {!! $errors->first('batasnilai', '<p class="text-danger">:message</p>') !!}
</div>
<div class="mb-3 {{ $errors->has('status') ? 'has-error' : ''}}">
    <label for="status" class="form-label">{{ 'Status' }}</label>
    <select name="status" id="status">
        <option value="" disabled selected>Pilih Status</option>
        <option value="1" @if (isset($ujian) && $ujian->status == 1) selected @endif>Aktif</option>
        <option value="0" @if (isset($ujian) && $ujian->status == 0) selected @endif>Non Aktif</option>
    </select>
    {!! $errors->first('status', '<p class="text-danger">:message</p>') !!}
</div>

<div class="d-flex justify-content-between">
    <a href="{{url('/soca/ujian')}}" class="btn btn-secondary" >Cancel
    </a>
    <input  type="submit" class="btn btn-primary me-2" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
