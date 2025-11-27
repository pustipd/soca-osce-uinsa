
    <div class="mb-3 {{ $errors->has('id-ujian-soca') ? 'has-error' : ''}}">
        <label for="id-ujian-soca" class="form-label">{{ 'Jenis Ujian' }}</label>
        <select name="id_ujian_soca" id="id-ujian-soca" class="form-select select2">
            <option value="" disabled selected>Pilih Ujian</option>
            @foreach ($list_ujian as $ujian)
                <option value="{{$ujian->id}}" @if (isset($penguji) && $ujian->id == $penguji->id_ujian_soca) selected @endif>{{$ujian->nama}} Sesi {{$ujian->sesi}}</option>
            @endforeach
        </select>
        {!! $errors->first('id_ujian_soca', '<p class="text-danger">:message</p>') !!}
    </div>

    <div class="mb-3 {{ $errors->has('id_kriteria') ? 'has-error' : ''}}">
        <label for="id_kriteria" class="form-label">{{ 'Kriteria' }}</label>
        <select name="id_kriteria" id="id_kriteria" class="form-select select2">
            <option value="" disabled selected>Pilih Kriteria</option>
            @foreach ($list_kriteria as $kriteria)
                <option value="{{$kriteria->id}}" @if (isset($penguji) && $kriteria->id == $penguji->id_kriteria) selected @endif>{{$kriteria->nama}}</option>
            @endforeach
        </select>
        {!! $errors->first('id_kriteria', '<p class="text-danger">:message</p>') !!}
    </div>

    <div class="mb-3 {{ $errors->has('id_penguji1') ? 'has-error' : ''}}">
        <label for="id-penguji1" class="form-label">{{ 'Penguji 1' }}</label>
        <select name="id_penguji1" id="id-penguji1" class="form-select select2">
            <option value="" disabled selected>Pilih Penguji 1</option>
            @foreach ($list_penguji as $penguji)
                <option value="{{$penguji->id}}" @if (isset($penguji) && $penguji->id == $penguji->id_penguji1) selected @endif>{{$penguji->nama}}</option>
            @endforeach
        </select>
        {!! $errors->first('id_penguji1', '<p class="text-danger">:message</p>') !!}
    </div>

    <div class="mb-3 {{ $errors->has('id_penguji2') ? 'has-error' : ''}}">
        <label for="id-penguji2" class="form-label">{{ 'Penguji 2' }}</label>
        <select name="id_penguji2" id="id-penguji2" class="form-select select2">
            <option value="" disabled selected>Pilih Penguji 2</option>
            @foreach ($list_penguji as $penguji)
                <option value="{{$penguji->id}}" @if (isset($penguji) && $penguji->id == $penguji->id_penguji2) selected @endif>{{$penguji->nama}}</option>
            @endforeach
        </select>
        {!! $errors->first('id_penguji2', '<p class="text-danger">:message</p>') !!}
    </div>

    <div class="mb-3 {{ $errors->has('station') ? 'has-error' : ''}}">
        <label for="station" class="form-label">{{ 'Station' }}</label>
        <input type="number" id="station" name="station" class="form-control" value="{{isset($penguji) ? $penguji->station : ''}}">
        {!! $errors->first('station', '<p class="text-danger">:message</p>') !!}
    </div>


    <div class="d-flex justify-content-between">
        <a href="{{url('soca/penjadwalan/')}}" class="btn btn-secondary">Cancel
        </a>
        <input  type="submit" class="btn btn-primary me-2" value="Jadwalkan">
    </div>
