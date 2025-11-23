
<div class="mb-3 {{ $errors->has('no_station') ? 'has-error' : ''}}">
    <label for="no_station" class="form-label">{{ 'Nomor Station' }}</label>
    <input class="form-control" name="no_station" type="number" id="no_station" value="{{ isset($station->no_station) ? $station->no_station : ''}}" >
    {!! $errors->first('no_station', '<p class="text-danger">:message</p>') !!}
</div>
<div class="mb-3 {{ $errors->has('penguji') ? 'has-error' : ''}}">
    <label for="penguji" class="form-label">{{ 'Penguji' }}</label>

    <select name="penguji" id="penguji" class="form-select">
        {{-- @if ($station && $station->id_penguji)
            @foreach ($list_penguji as $item)
                <option value="{{$item->id}}" @if ($item->id == $station->id_penguji) selected @endif>{{$item->nama}}</option>
            @endforeach
        @else --}}
            <option value="" disabled selected>Pilih Penguji</option>
            @foreach ($list_penguji as $item)
                <option value="{{$item->id}}" @if (isset($station) && $station->id_penguji == $item->id) selected @endif>{{$item->nama}}</option>
            @endforeach
        {{-- @endif --}}
    </select>

    {!! $errors->first('penguji', '<p class="text-danger">:message</p>') !!}
</div>
<div class="mb-3 {{ $errors->has('ujian') ? 'has-error' : ''}}">
    <label for="ujian" class="form-label">{{ 'Ujian' }}</label>

    <select name="ujian" id="ujian" class="form-select">
        <option value="" selected disabled>Pilih Ujian</option>
        @foreach ($list_ujian as $item)
            <option value="{{$item->id}}" @if (isset($station) && $item->id == $station->id_ujian_osce) selected @endif>{{$item->nama}}</option>
        @endforeach
    </select>

    {!! $errors->first('ujian', '<p class="text-danger">:message</p>') !!}
</div>


<div class="d-flex justify-content-between">
    <a href="{{url('osce/station')}}" class="btn btn-secondary">Cancel
    </a>
    <input  type="submit" class="btn btn-primary me-2" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
