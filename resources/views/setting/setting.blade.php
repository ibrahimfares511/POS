@php
$title = 'النظام';
@endphp
@extends('layouts.app')
@section('content')
  <div id="wrapper" class='toggled-2'>
    @include('includes.sidebar')
    <div id="page-content-wrapper">
        <main class="py-4">
          <section>
            <div>
              <div class="portlet price-box">
                  <div class="box-title">عملية البيع</div>
                  @if(isset($setting->salestype))
                  @if($setting->salestype == "direct")
                  <div class="box-radio">
                    <input type="radio" class='d-none radio-Button' value="direct" id='direct' name='salesopration' checked>
                    <label class="entry" for="direct">
                        <div class="circle"></div>
                        <div class="entry-label">مباشر</div>
                    </label>

                    <input type="radio" class='d-none radio-Button' value="indirect" id='indirect' name='salesopration'>
                    <label class="entry" for="indirect">
                        <div class="circle"></div>
                        <div class="entry-label">غير مباشر</div>
                    </label>
                    <div class="highlight"></div>
                  </div>
                  @else
                  <div class="box-radio">
                    <input type="radio" class='d-none radio-Button' value="direct" id='direct' name='salesopration'>
                    <label class="entry" for="direct">
                        <div class="circle"></div>
                        <div class="entry-label">مباشر</div>
                    </label>

                    <input type="radio" class='d-none radio-Button' value="indirect" id='indirect' name='salesopration' checked>
                    <label class="entry" for="indirect">
                        <div class="circle"></div>
                        <div class="entry-label">غير مباشر</div>
                    </label>
                    <div class="highlight"></div>
                  </div>
                  @endif
                  @else
                  <div class="box-radio">
                    <input type="radio" class='d-none radio-Button' value="direct" id='direct' name='salesopration' checked>
                    <label class="entry" for="direct">
                        <div class="circle"></div>
                        <div class="entry-label">مباشر</div>
                    </label>

                    <input type="radio" class='d-none radio-Button' value="indirect" id='indirect' name='salesopration'>
                    <label class="entry" for="indirect">
                        <div class="circle"></div>
                        <div class="entry-label">غير مباشر</div>
                    </label>
                    <div class="highlight"></div>
                  </div>
                  @endif
              </div>
              <br>
              <div class="portlet price-box">
                  <div class="box-title">عملية الشراء</div>
                  @if(isset($setting->buyopration))
                  @if($setting->buyopration == "direct")
                  <div class="box-radio">
                    <input type="radio" class='d-none radio-Button' value="direct" id='buydirect' name='buyopration' checked>
                    <label class="entry" for="buydirect">
                        <div class="circle"></div>
                        <div class="entry-label">مباشر</div>
                    </label>

                    <input type="radio" class='d-none radio-Button' value="indirect" id='buyindirect' name='buyopration'>
                    <label class="entry" for="buyindirect">
                        <div class="circle"></div>
                        <div class="entry-label">غير مباشر</div>
                    </label>
                    <div class="highlight"></div>
                  </div>
                  @else
                  <div class="box-radio">
                    <input type="radio" class='d-none radio-Button' value="direct" id='buydirect' name='buyopration'>
                    <label class="entry" for="buydirect">
                        <div class="circle"></div>
                        <div class="entry-label">مباشر</div>
                    </label>

                    <input type="radio" class='d-none radio-Button' value="indirect" id='buyindirect' name='buyopration' checked>
                    <label class="entry" for="buyindirect">
                        <div class="circle"></div>
                        <div class="entry-label">غير مباشر</div>
                    </label>
                    <div class="highlight"></div>
                  </div>
                  @endif
                  @else
                  <div class="box-radio">
                    <input type="radio" class='d-none radio-Button' value="direct" id='buydirect' name='buyopration' checked>
                    <label class="entry" for="buydirect">
                        <div class="circle"></div>
                        <div class="entry-label">مباشر</div>
                    </label>

                    <input type="radio" class='d-none radio-Button' value="indirect" id='buyindirect' name='buyopration'>
                    <label class="entry" for="buyindirect">
                        <div class="circle"></div>
                        <div class="entry-label">غير مباشر</div>
                    </label>
                    <div class="highlight"></div>
                  </div>
                  @endif
              </div>
              <br>
              <div class="portlet price-box">
                <div class="box-title">زيادة سعر الشراء</div>
                @if(isset($setting->buysale))
                @if($setting->buysale == "two")
                <div class="box-radio">
                  <input type="radio" class='d-none radio-Button' value="two" id='two' name='buysale' checked>
                  <label class="entry" for="two">
                      <div class="circle"></div>
                      <div class="entry-label">نسبة</div>
                  </label>

                  <input type="radio" class='d-none radio-Button' value="last" id='last' name='buysale'>
                  <label class="entry" for="last">
                      <div class="circle"></div>
                      <div class="entry-label">اخر سعر</div>
                  </label>
                  <div class="highlight"></div>
                </div>
                @else
                <div class="box-radio">
                  <input type="radio" class='d-none radio-Button' value="two" id='two' name='buysale'>
                  <label class="entry" for="two">
                      <div class="circle"></div>
                      <div class="entry-label">نسبة</div>
                  </label>

                  <input type="radio" class='d-none radio-Button' value="last" id='last' name='buysale' checked>
                  <label class="entry" for="last">
                      <div class="circle"></div>
                      <div class="entry-label">اخر سعر</div>
                  </label>
                  <div class="highlight"></div>
                </div>
                @endif
                @else
                <div class="box-radio">
                  <input type="radio" class='d-none radio-Button' value="two" id='two' name='buysale' checked>
                  <label class="entry" for="two">
                      <div class="circle"></div>
                      <div class="entry-label">نسبة</div>
                  </label>

                  <input type="radio" class='d-none radio-Button' value="last" id='last' name='buysale'>
                  <label class="entry" for="last">
                      <div class="circle"></div>
                      <div class="entry-label">اخر سعر</div>
                  </label>
                  <div class="highlight"></div>
                </div>
                @endif
            </div>
            <br>
            <div class="portlet price-box">
              <div class="box-title">زيادة سعر البيع</div>
              @if(isset($setting->salesale))
              @if($setting->salesale == "two")
              <div class="box-radio">
                <input type="radio" class='d-none radio-Button' value="two" id='twobuy' name='salesale' checked>
                <label class="entry" for="twobuy">
                    <div class="circle"></div>
                    <div class="entry-label">نسبة</div>
                </label>

                <input type="radio" class='d-none radio-Button' value="last" id='lastbuy' name='salesale'>
                <label class="entry" for="lastbuy">
                    <div class="circle"></div>
                    <div class="entry-label">اخر سعر</div>
                </label>
                <div class="highlight"></div>
              </div>
              @else
              <div class="box-radio">
                <input type="radio" class='d-none radio-Button' value="two" id='twobuy' name='salesale'>
                <label class="entry" for="twobuy">
                    <div class="circle"></div>
                    <div class="entry-label">نسبة</div>
                </label>

                <input type="radio" class='d-none radio-Button' value="last" id='lastbuy' name='salesale' checked>
                <label class="entry" for="lastbuy">
                    <div class="circle"></div>
                    <div class="entry-label">اخر سعر</div>
                </label>
                <div class="highlight"></div>
              </div>
              @endif
              @else
              <div class="box-radio">
                <input type="radio" class='d-none radio-Button' value="twobuy" id='two' name='salesale' checked>
                <label class="entry" for="twobuy">
                    <div class="circle"></div>
                    <div class="entry-label">نسبة</div>
                </label>

                <input type="radio" class='d-none radio-Button' value="last" id='lastbuy' name='salesale'>
                <label class="entry" for="lastbuy">
                    <div class="circle"></div>
                    <div class="entry-label">اخر سعر</div>
                </label>
                <div class="highlight"></div>
              </div>
              @endif
          </div>
          </div>
            <div class="title-buttons">
                <button id="save_data" class="btn btn-success">
                  <span>حــفـظ</span>
                </button>
            </div>
          </div>
          </section>
        </main>
    </div>
  </div>
@include('ajax.setting.setting')
@endsection
