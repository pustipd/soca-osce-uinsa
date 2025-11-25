<div class="mb-3 {{ $errors->has('id_ujian') ? 'has-error' : ''}}">
    <label for="id_ujian" class="form-label">{{ 'Ujian' }}</label>
    <select name="id_ujian" id="id_ujian" class="form-select select2">
        <option value="" disabled selected>Pilih Ujian</option>
        @foreach ($list_ujian as $ujian)
            <option value="{{$ujian->id}}" @if (isset($indikator) && $indikator->id_ujian == $ujian->id) selected @endif>{{$ujian->nama}}</option>
        @endforeach
    </select>
    {!! $errors->first('id_ujian', '<p class="text-danger">:message</p>') !!}
</div>

<div class="mb-3 {{ $errors->has('nama') ? 'has-error' : ''}}">
    <label for="nama" class="form-label">{{ 'Nama' }}</label>
    <input class="form-control" name="nama" type="text" id="nama" value="{{ isset($indikator->nama) ? $indikator->nama : ''}}" >
    {!! $errors->first('nama', '<p class="text-danger">:message</p>') !!}
</div>

<div class="mb-3 {{ $errors->has('deskripsi') ? 'has-error' : ''}}">
    <label for="deskripsi" class="form-label">{{ 'Deskripsi' }}</label>
    <textarea class="form-control" rows="5" name="deskripsi" type="textarea" id="deskripsi" >{{ isset($indikator->deskripsi) ? $indikator->deskripsi : ''}}</textarea>
    {!! $errors->first('deskripsi', '<p class="text-danger">:message</p>') !!}
</div>
<div class="mb-3 {{ $errors->has('skormax') ? 'has-error' : ''}}">
    <label for="skormax" class="form-label">{{ 'Skor Max' }}</label>
    <input class="form-control" name="skormax" type="number" id="skormax" value="{{ isset($indikator->skormax) ? $indikator->skormax : ''}}" >
    {!! $errors->first('skormax', '<p class="text-danger">:message</p>') !!}
</div>


<div class="d-flex justify-content-between">
    <a href="{{url('soca/indikator')}}" class="btn btn-secondary">Cancel
    </a>
    <input  type="submit" class="btn btn-primary me-2" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
