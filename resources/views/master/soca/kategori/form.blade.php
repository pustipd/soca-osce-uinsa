<div class="mb-3 {{ $errors->has('nama') ? 'has-error' : ''}}">
    <label for="nama" class="form-label">{{ 'Nama' }}</label>
    <input class="form-control" name="nama" type="text" id="nama" value="{{ isset($kategorisoca->nama) ? $kategorisoca->nama : ''}}" >
    {!! $errors->first('nama', '<p class="text-danger">:message</p>') !!}
</div>


<div class="d-flex justify-content-between">
    <a href="#">
        <button class="btn btn-secondary">Cancel</button>
    </a>
    <input  type="submit" class="btn btn-primary me-2" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
