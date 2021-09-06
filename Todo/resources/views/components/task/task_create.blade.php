@extends('../../layouts.main')

@section('content')
    <h2>
        Create your task
    </h2>
    <form class="mt-4" method="post" action="{{ route('task.store') }}">
        @csrf

        <div class="mb-3">
            <label for="exampleInputName1" class="form-label">Title</label>
            <input type="text" class="form-control" id="exampleInputName1" name="title">
        </div>

        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Description</label>
            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="description">
        </div>

        <input type="hidden" name="user_id" value="{{ \Illuminate\Support\Facades\Auth::id() }}">

        <input type="hidden" name="is_done" value="0" />

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@stop
