@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">2FA</div>

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
                    
                    @if(!count($data['user']->passwordSecurity))
                    <form class="form-horizontal" method="POST" action="{{ route('generate2faSecretCode') }}">
                        <p>Enable 2FA on your account.</p>
                        <p>Click the generate secret button</p>
                        <p>Enter this into google Authenticator App</p>
                        {{ csrf_field() }}
                        <div class="col-md-8 col-md-offset-2">
                            <button type="submit" class="btn btn-info">Generate Secrete Key</button>
                        </div>
                    </form>
                    @elseif(!$data['user']->passwordSecurity->google2fa_enable)
                        <p>Scan this barcode with the google Authenticator App</p>
                        <img src="{{ $data['google2FaUrl'] }}" alt="QRCode">
                        
                        <form class="form-horizontal" method="POST" action="{{ route('enable2fa') }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <input id="verify-code" type="password" class="form-control" name="verifyCode" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-info">Enable 2FA</button>
                            </div>
                    </form>
                    @elseif($data['user']->passwordSecurity->google2fa_enable)
                    <p>2FA is Enabled</p>
                    <form class="form-horizontal" method="POST" action="{{ route('disable2fa') }}">
                            {{ csrf_field() }}

                            <input type="password" class="form-controll" name="currentPassword" id="currentPassword" required>
                            <div class="form-group">
                                <button type="submit" class="btn btn-info">Disable 2FA</button>
                            </div>
                        </form>
                    @endif

            </div>
        </div>
    </div>
</div>

@endsection
