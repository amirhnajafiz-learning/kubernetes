@extends('../layouts.main')

@section('content')
    @if(session('name'))
        <div class="alert alert-success">User {{ session('name') }} Created Successfully!</div>
    @endif

    <a href="{{ route('user.create') }}" class="btn btn-primary">Create User</a>

    @if(count($users) > 0)
        <ul class="mt-4">
            @foreach($users as $user)
                <li>{{ $user->name }} ({{ $user->email }})</li>
            @endforeach
        </ul>
    @else
        <div class="alter alert-danger">
            No users yet.
        </div>
    @endif
@stop
