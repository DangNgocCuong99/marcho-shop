@php
\Assets::addStyles([
'font-roboto-quicksand',
'custom-style',
'custom-responsive',
]);

\Assets::addScripts([
'jquery-scrollup',
'custom',
]);
@endphp

@extends('layouts.master')

@section('main')
<div class="custom-container">
    <section class="makp_breadcrumb bg_image">
        <div class="banner">
            <div class="bg_overlay"></div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="breadcrumb_content text-center">
                            <h1 class="font-weight-normal">Liên hệ</h1>
                            <ul>
                                <li class="mx-1">
                                    <a href="{{ route('home') }}"><i class="fal fa-home-alt mr-1"></i>Trang chủ</a>
                                </li>
                                <li class="mx-1">
                                    <i class="fal fa-angle-right"></i>
                                </li>
                                <li class=" mx-1 active">Liên hệ</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<section class="makp_map pt-100 pb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="map_box">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.775952858684!2d105.8708348144069!3d21.00161629408142!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ac016c66cdf1%3A0xfbf946c8caec95c7!2zMTIwIFbEqW5oIFR1eSwgVsSpbmggUGjDuiwgSGFpIELDoCBUcsawbmcsIEjDoCBO4buZaSwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1630684785201!5m2!1svi!2s" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="makp_contact contact_v1">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="makp_conent_box">
                    <div class="section_titles">
                        <h2>Hãy thoải mái liên hệ với chúng tôi</h2>
                        <p>Marcho là trang web mua sắm trực tuyến các thiết kế thời trang đến từ các Nhà Thiết Kế trong và ngoài nước. Tầm nhìn của Marcho là tạo nên một địa chỉ mua sắm online đẳng cấp và chất lượng cho khách hàng yêu thời trang, và muốn thể hiển mình qua phong cách thời trang của chính mình.</p>
                    </div>
                    <div class="contact_list">
                        <div class="single_list">
                            <div class="icon">
                                <i class="fal fa-phone-alt"></i>
                            </div>
                            <div class="text">
                                <p><a href="tel:0388842605">0388842605</a></p>
                                <p><a href="tel:+84388842605">+84388842605</a></p>
                            </div>
                        </div>
                        <div class="single_list">
                            <div class="icon">
                                <i class="fal fa-map-marker-alt"></i>
                            </div>
                            <div class="text">
                                <p>120 Vĩnh Tuy Street, Hai Bà Trưng, Hà </p>
                            </div>
                        </div>
                        <div class="single_list">
                            <div class="icon">
                                <i class="fal fa-envelope-open-text"></i>
                            </div>
                            <div class="text">
                                <p><a href="mailto:yourmailaddress@gmail.com">dangngoccuong99@gmail.com</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="contact_form">
                    <h4>Thông tin liên hệ</h4>
                    <form action="{{ route('contact.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form_group">
                                    <input type="text" class="form_control" placeholder="Họ và tên" name="name" required="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form_group">
                                    <input type="email" class="form_control" placeholder="Địa chỉ email" name="email" required="">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form_group">
                                    <input type="text" class="form_control" placeholder="Tiêu đề" name="subject" required="">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form_group">
                                    <textarea class="form_control" placeholder="Để lại bình luận của bạn ở đây" name="message"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="button_box">
                                    <button class="btn btn-fill-out">Gửi tin nhắn</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection