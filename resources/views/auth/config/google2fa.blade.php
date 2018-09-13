@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">2FA Authentication</div>

                <div class="panel-body">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{session('error')}}
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{session('success')}}
                        </div>
                    @endif
                    
                    <p>Enter the PIN from the Authenticator</p>
                        
                        <form class="form-horizontal" method="POST" action="{{ route('2faVerify') }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <input id="one_time_password" type="password" class="form-control" name="one_time_password" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-info">Proceed</button>
                            </div>
                    </form>
                    

            </div>
        </div>
    </div>
</div>

@endsection
