@extends('admin.admin_master')
@section('admin')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Users</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">JSVN</a></li>
                            <li class="breadcrumb-item active">Users</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <!-- update user profile information -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Profile Information') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600">
                                {{ __("Update your account's profile information and email address.") }}
                            </p>
                        </div>
                        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                            @csrf
                        </form>
                        <form method="post" action="{{ route('admin.users.update') }}" class="mt-6 space-y-6">
                            @csrf
                            @method('patch')
                            <div class="row mt-3">
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label for="name">Name</label>
                                        <input class="form-control @if($errors->has('name')) is-invalid @endif" type="text" id="name" name="name" required="" value="{{ old('name', $user->name) }}" placeholder="Name">
                                        @if($errors->has('name'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('name')}}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-md-6"></div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label for="username">Username</label>
                                        <input class="form-control @if($errors->has('username')) is-invalid @endif" type="text" id="username" name="username" required="" value="{{ old('username', $user->username) }}" placeholder="Username">
                                        @if($errors->has('username'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('username')}}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-md-6"></div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label for="email">Email</label>
                                        <input class="form-control @if($errors->has('email')) is-invalid @endif" type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required="" placeholder="Email">
                                        @if($errors->has('email'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('email')}}
                                        </div>
                                        @endif
                                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                        <div>
                                            <p class="text-sm mt-2 text-gray-800">
                                                {{ __('Your email address is unverified.') }}

                                                <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    {{ __('Click here to re-send the verification email.') }}
                                                </button>
                                            </p>

                                            @if (session('status') === 'verification-link-sent')
                                            <p class="mt-2 font-medium text-sm text-green-600">
                                                {{ __('A new verification link has been sent to your email address.') }}
                                            </p>
                                            @endif
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-md-6"></div>
                                </div>
                            </div>
                            <div class="form-group text-center row mt-3">
                                <div class="col-md-3">
                                    <button class="btn btn-info w-100 waves-effect waves-light" type="submit">{{ __('Save') }}</button>
                                    @if (session('status') === 'profile-updated')
                                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">{{ __('Saved.') }}</p>
                                    @endif
                                </div>
                                <div class="col-md-3">
                                </div>
                                <div class="col-md-3">
                                </div>
                                <div class="col-md-3">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of updating user profile information -->
        <!-- start of updating current password -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Update Password') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Ensure your account is using a long, random password to stay secure.') }}
                            </p>
                        </div>
                        <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                            @csrf
                            @method('put')
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label for="current_password">Current Password</label>
                                    <input class="form-control @if($errors->updatePassword->has('current_password')) is-invalid @endif" type="password" id="current_password" name="current_password" value="{{ old('current_password') }}" required="" placeholder="Enter current password here">
                                    @if($errors->updatePassword->has('current_password'))
                                    <div class="invalid-feedback">
                                        {{ $errors->updatePassword->first('current_password')}}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label for="password">New Password</label>
                                    <input class="form-control @if($errors->updatePassword->has('password')) is-invalid @endif" type="password" id="password" name="password" value="{{ old('password') }}" required="" placeholder="Enter new password here">
                                    @if($errors->updatePassword->has('password'))
                                    <div class="invalid-feedback">
                                        {{ $errors->updatePassword->first('password')}}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input class="form-control @if($errors->updatePassword->has('password_confirmation')) is-invalid @endif" type="password" id="password_confirmation" name="password_confirmation" value="{{ old('password_confirmation') }}" required="" placeholder="Confirm your new password here">
                                    @if($errors->updatePassword->has('password_confirmation'))
                                    <div class="invalid-feedback">
                                        {{ $errors->updatePassword->first('password_confirmation')}}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group text-center row mt-3">
                                <div class="col-md-3">
                                    <button class="btn btn-info w-100 waves-effect waves-light" type="submit">{{ __('Save') }}</button>
                                    @if (session('status') === 'password-updated')
                                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">{{ __('Saved.') }}</p>
                                    @endif
                                </div>
                                <div class="col-md-3">
                                </div>
                                <div class="col-md-3">
                                </div>
                                <div class="col-md-3">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of updating current password -->
    </div>
</div>
@endsection