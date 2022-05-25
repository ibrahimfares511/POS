@php
$title = 'الرئيـسـية';
@endphp
@extends('layouts.app')

@section('content')
  <div id="wrapper" class='toggled-2'>
    @include('includes.sidebar')
    <div id="page-content-wrapper">
      <main class="py-4">
        @can('صفحة القيادة')
        <section class="dashboard">
          <div class="container">
            <div class="row">
              <div class="col-xs-12 col-sm-6">
                <h1 class="page-title">
                  <span> صفحة القياده </span>
                </h1>
              </div>
              @can('البحث')
              <div class="col-xs-12 col-sm-3 mr-auto">
                <select name="" id="selectop" class='w-100'>
                  <option value="" disabled selected></option>
                  <option value="Today">Today</option>
                  <option value="Yesterday">Yesterday</option>
                  <option value="Last_Week">Last Week</option>
                  <option value="Last_Month">Last Month</option>
                  <option value="Last_Year">Last Year</option>
                  <option value="All">All</option>
                </select>
                <div class='search-select'>
                  <div class='label-Select'>
                    <label>حدد اليوم</label>
                    <span class="select-value"></span>
                    <i class="fa fa-chevron-down arrow"></i>
                  </div>
                  <div class='input-options'>
                    <ul></ul>
                  </div>
                </div>
              </div>
              @endcan
            </div>
            <div class="dash-box">
              @can('عدد الفواتير')
              <div class='box'>
                <div class="content">
                  <i class="fas fa-file-invoice fa-3x" style='color: #2ab4c0'></i>
                  <h2 style='color: #2ab4c0'><span id="foateer">{{ $data['foateer'] }}</span></h2>
                </div>
                <div class="title"> الفواتير المباعة </div>
              </div>
              @endcan
              @can('المبيعات')
              <div class='box'>
                <div class="content">
                <i class="fas fa-hand-holding-usd fa-3x" style='color:#8e44ad'></i>
                  <h2 style='color:#8e44ad'><span id="salesshow">{{ number_format($data['sales'],2) }}</span></h2>
                </div>
                <div class="title"> المبيعات </div>
              </div>
              @endcan
              @can('الاجيل')
              <div class='box'>
                <div class="content">
                <i class="fas fa-hand-holding-usd fa-3x" style='color:#8e44ad'></i>
                  <h2 style='color:#8e44ad'><span id="sales_agel">{{ number_format($data['agel'],2) }}</span></h2>
                </div>
                <div class="title"> الاجل </div>
              </div>
              @endcan
              @can('مرتجع')
              <div class='box'>
                <div class="content">
                <i class="fas fa-hand-holding-usd fa-3x" style='color:#8e44ad'></i>
                  <h2 style='color:#8e44ad'><span id="sales_back">{{ number_format($data['back'],2) }}</span></h2>
                </div>
                <div class="title"> مرتجع </div>
              </div>
              @endcan
              @can('مرتجع من حساب')
              <div class='box'>
                <div class="content">
                <i class="fas fa-hand-holding-usd fa-3x" style='color:#8e44ad'></i>
                  <h2 style='color:#8e44ad'><span id="sales_backacc">{{ number_format($data['backofcus'],2) }}</span></h2>
                </div>
                <div class="title"> مرتجع من حساب </div>
              </div>
              @endcan
              @can('فواتير الشراء')
              <div class='box'>
                <div class="content">
                <i class="fas fa-hand-holding-usd fa-3x" style='color:#8e44ad'></i>
                  <h2 style='color:#8e44ad'><span id="foateer_buy">{{ $data['foateer_buy'] }}</span></h2>
                </div>
                <div class="title"> فواتير الشراء </div>
              </div>
              @endcan
              @can('المشتريات')
              <div class='box'>
                <div class="content">
                <i class="fas fa-hand-holding-usd fa-3x" style='color:#8e44ad'></i>
                  <h2 style='color:#8e44ad'><span id="buy">{{ $data['buy'] }}</span></h2>
                </div>
                <div class="title"> المشتريات </div>
              </div>
              @endcan
              @can('مشتريات أجل')
              <div class='box'>
                <div class="content">
                <i class="fas fa-hand-holding-usd fa-3x" style='color:#8e44ad'></i>
                  <h2 style='color:#8e44ad'><span id="buy_aggel">{{ $data['buy_aggel'] }}</span></h2>
                </div>
                <div class="title"> مشتريات أجل </div>
              </div>
              @endcan
              @can('مرتجع مشتريات')
              <div class='box'>
                <div class="content">
                <i class="fas fa-hand-holding-usd fa-3x" style='color:#8e44ad'></i>
                  <h2 style='color:#8e44ad'><span id="buy_back">{{ $data['buy_back'] }}</span></h2>
                </div>
                <div class="title"> مرتجع مشتريات </div>
              </div>
              @endcan
              @can('مرتجع مشتريات اجل')
              <div class='box'>
                <div class="content">
                <i class="fas fa-hand-holding-usd fa-3x" style='color:#8e44ad'></i>
                  <h2 style='color:#8e44ad'><span id="buy_backacc">{{$data['buy_backacc']}}</span></h2>
                </div>
                <div class="title">مرتجع مشتريات أجل</div>
              </div>
              @endcan
              @can('المصروفات')
              <div class='box'>
                <div class="content">
                  <i class="fas fa-fist-raised fa-3x" style='color: #2ab4c0'></i>
                  <h2 style='color: #2ab4c0'><span id="Spending">{{ number_format($data['Spending'],2) }}</span></h2>
                </div>
                <div class="title"> المصروفات </div>
              </div>
              @endcan
              @can('التوريد')
              <div class='box'>
                <div class="content">
                  <i class="fas fa-fist-raised fa-3x" style='color: #2ab4c0'></i>
                  <h2 style='color: #2ab4c0'><span id="supply">{{ number_format($data['supply'],2) }}</span></h2>
                </div>
                <div class="title"> التوريد </div>
              </div>
              @endcan
              @can('الصرف')
              <div class='box'>
                <div class="content">
                  <i class="fas fa-fist-raised fa-3x" style='color: #2ab4c0'></i>
                  <h2 style='color: #2ab4c0'><span id="exchange">{{ number_format($data['exchange'],2)}}</span></h2>
                </div>
                <div class="title"> الصرف </div>
              </div>
              @endcan
              @can('الخزينة')
              <div class='box'>
                <div class="content">
                  <i class="fas fa-wallet fa-3x" style='color: #4b77be'></i>
                  <h2 style='color: #4b77be'><span id="total">{{ number_format($data['total'],2) }}</span></h2>
                </div>
                <div class="title"> الخزينه </div>
              </div>
              @endcan

            </div>
          </div>
        </section>
        @endcan

      </main>
    </div>
  </div>
  @include('ajax.home')
@endsection
