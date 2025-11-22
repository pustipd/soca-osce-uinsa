<div class="mb-3 {{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name" class="form-label">{{ 'Name' }}</label>
    <input class="form-control" name="name" type="text" id="name" value="{{ isset($user->name) ? $user->name : ''}}" >
    {!! $errors->first('name', '<p class="text-danger">:message</p>') !!}
</div>
<div class="mb-3 {{ $errors->has('email') ? 'has-error' : ''}}">
    <label for="email" class="form-label">{{ 'Email' }}</label>
    <input class="form-control" name="email" type="text" id="email" value="{{ isset($user->email) ? $user->email : ''}}" >
    {!! $errors->first('email', '<p class="text-danger">:message</p>') !!}
</div>
<div class="mb-3 {{ $errors->has('password') ? 'has-error' : ''}}">
    <label for="password" class="form-label">{{ 'Password' }}</label>
    <input class="form-control" name="password" type="text" id="password" value="{{ isset($user->password) ? $user->password : ''}}" >
    {!! $errors->first('password', '<p class="text-danger">:message</p>') !!}
</div>


<div class="d-flex justify-content-between">
    <a href="#">
        <button class="btn btn-secondary">Cancel</button>
    </a>
    <input  type="submit" class="btn btn-primary me-2" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
