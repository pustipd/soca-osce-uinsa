<div class="mb-3 {{ $errors->has('nama') ? 'has-error' : ''}}">
    <label for="nama" class="form-label">{{ 'Nama' }}</label>
    <input class="form-control" name="nama" type="text" id="nama" value="{{ isset($kriteria->nama) ? $kriteria->nama : ''}}" >
    {!! $errors->first('nama', '<p class="text-danger">:message</p>') !!}
</div>
<div class="mb-3 {{ $errors->has('totalnilai') ? 'has-error' : ''}}">
    <label for="totalnilai" class="form-label">{{ 'Total Nilai' }}</label>
    <input class="form-control" name="totalnilai" type="number" id="totalnilai" value="{{ isset($kriteria->totalnilai) ? $kriteria->totalnilai : ''}}" >
    {!! $errors->first('totalnilai', '<p class="text-danger">:message</p>') !!}
</div>


<div class="d-flex justify-content-between">
    <a href="#">
        <button class="btn btn-secondary">Cancel</button>
    </a>
    <input  type="submit" class="btn btn-primary me-2" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
