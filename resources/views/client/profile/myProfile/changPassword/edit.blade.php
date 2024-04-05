@extends('client.layouts.app')

@section('titleWeb') ورود کاربری@endsection

@section('content')
    <div class="container">
        <!-- Breadcrumb Start-->
        <ul class="breadcrumb">
            <li><a href="index.html"><i class="fa fa-home"></i></a></li>
            <li><a href="login.html">حساب کاربری</a></li>
            <li><a href="register.html">ثبت نام</a></li>
        </ul>
        <!-- Breadcrumb End-->
        <div class="row">
            <!--Middle Part Start-->
            <div class="col-sm-9" id="content">
                <form class="form-horizontal" method="post" action="{{route('client.myProfile.changPassword.update')}}">
                    @csrf
                    @method('patch')
                    <fieldset id="account">
                        <legend>ویرایش رمزعبور</legend>
                        <div class="form-group required">
                            <label for="input-email" class="col-sm-2">رمز فعلی</label>
                            <div class="col-sm-10">
                                <input  type="password" class="form-control" id="input-email" placeholder="رمز فعلی" value="" name="old_password">
                            </div>
                        </div>
                        <div class="form-group required">
                            <label for="input-email" class="col-sm-2 ">رمز جدید</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" id="input-email" placeholder="رمز عبور" value="" name="password">
                            </div>
                        </div>
                        <div class="form-group required">
                            <label for="input-email" class="col-sm-2 ">تکرار رمز جدید</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" id="input-email" placeholder="تکرار رمز جدید" value="" name="password_confirmation">
                            </div>
                        </div>
                    </fieldset>
                    <fieldset id="address">
                        <div class="buttons">
                            <div class="pull-right">&nbsp;
                                <input type="submit" class="btn btn-primary" value="بروزرسانی">
                            </div>
                        </div>
                    </fieldset>
                    @include('admin.layouts.errors')
                </form>
            </div>
            <!--Middle Part End -->
        </div>
    </div>
@endsection
