@extends('client.layouts.app')

@section('titleWeb') {{auth()->user()->name}}@endsection

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
            <h1 class=" text-center"> کاربر گرامی<b class="text-warning">{{auth()->user()->name}}</b>به پنل کاربری خود خوش آمدید </h1>
            @if (session('successPassword'))
                <h1 class=" alert alert-success text-center">{{session('successPassword')}}</h1>
            @endif
            <div class="col-sm-9" id="content">
                <form class="form-horizontal" method="post" action="{{route('client.myProfile.update')}}">
                    @csrf
                    @method('patch')
                    <fieldset id="account">
                        <legend>ویرایش اطلاعات کاربری</legend>
                        <div class="form-group required">
                            <label for="input-email" class="col-sm-2">آدرس ایمیل</label>
                            <div class="col-sm-10">
                                <input readonly type="email" class="form-control" id="input-email" placeholder="آدرس ایمیل" value="{{auth()->user()->email}}" name="email">
                            </div>
                        </div>
                        <div class="form-group required">
                            <label for="input-email" class="col-sm-2 ">نام</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="input-email" placeholder="نام" value="{{auth()->user()->name}}" name="name">
                            </div>
                        </div>
                    </fieldset>
                    <fieldset id="address">
                        <div class="buttons">
                            <div class="pull-right">&nbsp;
                                <input type="submit" class="btn btn-primary" value="بروزرسانی">
                                <a  href="{{route('client.myProfile.changPassword.edit')}}" class="btn btn-link" >تغییر رمز عبور</a>
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