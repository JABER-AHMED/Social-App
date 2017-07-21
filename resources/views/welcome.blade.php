@extends('layouts.master')

@section('title')
    Welcome!
@endsection

@section('content')
  @include('layouts._message');

    <div class="row">
        <div class="col-md-6">
        <h3>Sign-Up</h3>
          <form action="{{route('signup')}}" method="post">
              <div class="form-group">
                  <label for="email">Your e-mail</label>
                  <input class="form-control" type="email" name="email" id="email">
              </div>
              <div class="form-group">
                  <label for="first_name">Your FirstName</label>
                  <input class="form-control" type="text" name="first_name" id="first_name">
              </div>
              <div class="form-group">
                  <label for="password">Your Password</label>
                  <input class="form-control" type="password" name="password" id="password">
              </div>
              <div class="form-group">
                  <label for="confirm_password">Confirm Password</label>
                  <input class="form-control" type="password" name="confirm_password" id="confirm_password">
              </div>
              <button type="submit" class="btn btn-primary">SignUp</button>
              <input type="hidden" name="_token" value="{{ Session::token() }}">
          </form>
        </div>

        <div class="col-md-6">
        <h3>Sign-In</h3>
          <form action="{{route('signin')}}" method="post">
              <div class="form-group">
                  <label for="email">Your e-mail</label>
                  <input class="form-control" type="email" name="email" id="email">
              </div>
              <div class="form-group">
                  <label for="password">Your Password</label>
                  <input class="form-control" type="password" name="password" id="password">
              </div>
              <button type="submig" class="btn btn-success">SignIn</button>
              <input type="hidden" name="_token" value="{{ Session::token() }}">
          </form>
        </div>
    </div>

@endsection
