<div class="mb-3 {{ $errors->has('id_kriteria') ? 'has-error' : ''}}">
    <label for="id_kriteria" class="form-label">{{ 'Kriteria' }}</label>
    <select name="id_kriteria" id="id_kriteria" class="form-select select2">
        <option value="" disabled selected>Pilih Kriteria</option>
        @foreach ($list_kriteria as $kriteria)
            <option value="{{$kriteria->id}}" @if (isset($indikator) && $kriteria->id == $indikator->id_kriteria) selected @endif>{{$kriteria->nama}}</option>
        @endforeach
    </select>
    {!! $errors->first('id_kriteria', '<p class="text-danger">:message</p>') !!}
</div>

<div class="mb-3 {{ $errors->has('nama') ? 'has-error' : ''}}">
    <label for="nama" class="form-label">{{ 'Nama' }}</label>
    <input class="form-control" name="nama" type="text" id="nama" value="{{ isset($indikator->nama) ? $indikator->nama : ''}}" >
    {!! $errors->first('nama', '<p class="text-danger">:message</p>') !!}
</div>

<h5 class="mb-3">Jenis Indikator</h5>

<div class="mb-3">
    <div class="form-check form-check-inline">
        <input type="radio" class="form-check-input" name="jenis_indikator" id="input-deskripsi" value="deskripsi" checked>
        <label class="form-check-label" for="input-deskripsi">
            Deskripsi
        </label>
    </div>
    <div class="form-check form-check-inline">
        <input type="radio" class="form-check-input" name="jenis_indikator" id="input-dokumen" value="dokumen">
        <label class="form-check-label" for="input-dokumen">
            Dokumen
        </label>
    </div>
</div>

<div id="input-form-deskripsi" class="mb-3 {{ $errors->has('deskripsi') ? 'has-error' : ''}}">
    <label for="deskripsi" class="form-label">{{ 'Deskripsi' }}</label>
    <textarea class="form-control" cols="30" rows="30" name="deskripsi" type="textarea" id="deskripsi" >{{ isset($indikator->deskripsi) ? $indikator->deskripsi : ''}}</textarea>
    {!! $errors->first('deskripsi', '<p class="text-danger">:message</p>') !!}
</div>

<div id="input-form-dokumen" class="mb-3 {{ $errors->has('dokumen') ? 'has-error' : ''}}">
    <label for="dokumen" class="form-label">{{ 'Dokumen' }}</label>
    <input type="file" class="form-control" name="dokumen" id="dokumen">
    {{-- {!! $errors->first('deskripsi', '<p class="text-danger">:message</p>') !!} --}}
</div>

<div class="mb-3 {{ $errors->has('skormax') ? 'has-error' : ''}}">
    <label for="skormax" class="form-label">{{ 'Skor Max' }}</label>
    <input class="form-control" name="skormax" type="number" id="skormax" value="{{ isset($indikator->skormax) ? $indikator->skormax : ''}}" >
    {!! $errors->first('skormax', '<p class="text-danger">:message</p>') !!}
</div>
<div class="mb-3 {{ $errors->has('bobot') ? 'has-error' : ''}}">
    <label for="bobot" class="form-label">{{ 'Bobot' }}</label>
    <input class="form-control" name="bobot" type="number" id="bobot" value="{{ isset($indikator->bobot) ? $indikator->bobot : ''}}" >
    {!! $errors->first('bobot', '<p class="text-danger">:message</p>') !!}
</div>

<div class="d-flex justify-content-between">
    <a href="{{url('osce/indikator')}}" class="btn btn-secondary">Cancel
    </a>
    <input  type="submit" class="btn btn-primary me-2" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
