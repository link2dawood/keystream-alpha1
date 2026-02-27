@extends('admin.layouts.app')

@section('panel')
    <!-- row end-->
    <div class="row gy-4">
        <div class="col-xxl-3 col-sm-6">
            <x-widget
                      style="3"
                      link="{{ route('admin.email.history') }}"
                      icon="las la-envelope-open"
                      title="Total Email sent"
                      value="{{ __($widget['total_email_sent']) }}"
                      bg="primary" />
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-3 col-sm-6">
            <x-widget
                      style="3"
                      link="{{ route('admin.email.history') }}?status=1"
                      icon="las la-inbox"
                      title="Total Success Email"
                      value="{{ __($widget['total_success_email_sent']) }}"
                      bg="success" />
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-3 col-sm-6">
            <x-widget
                      style="3"
                      link="{{ route('admin.email.history') }}?status=2"
                      icon="las la-envelope-open-text"
                      title="Total Scheduled Email"
                      value="{{ __($widget['total_schedule_email']) }}"
                      bg="14" />
        </div><!-- dashboard-w1 end -->
        <div class="col-xxl-3 col-sm-6">
            <x-widget
                      style="3"
                      link="{{ route('admin.email.history') }}?status=9"
                      icon="las la-comment-slash"
                      title="Total Failed Email"
                      value="{{ __($widget['total_failed_email']) }}"
                      bg="danger" />
        </div>
        <div class="col-xxl-3 col-sm-6">
            <x-widget
                      style="3"
                      link="{{ route('admin.sms.history') }}"
                      icon="las la-sms"
                      title="Total SMS Sent"
                      value="{{ __($widget['total_sms_sent']) }}"
                      bg="info" />
        </div>
        <div class="col-xxl-3 col-sm-6">
            <x-widget
                      style="3"
                      link="{{ route('admin.sms.history') }}?status=1"
                      icon="las la-sms"
                      title="Total Success SMS"
                      value="{{ __($widget['total_success_sms_sent']) }}"
                      bg="success" />
        </div>
        <div class="col-xxl-3 col-sm-6">
            <x-widget
                      style="3"
                      link="{{ route('admin.sms.history') }}?status=2"
                      icon="lar la-comment-dots"
                      title="Total Scheduled SMS"
                      value="{{ __($widget['total_schedule_sms']) }}"
                      bg="1" />
        </div>
        <div class="col-xxl-3 col-sm-6">
            <x-widget
                      style="3"
                      link="{{ route('admin.sms.history') }}?status=9"
                      icon="las la-phone-slash"
                      title="Total Failed SMS"
                      value="{{ __($widget['total_sms_fail']) }}"
                      bg="10" />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget
                      style="2"
                      link="{{ route('admin.contact.all') }}"
                      icon="fas fa-users"
                      title="Total Contact"
                      value="{{ __($widget['total_contacts']) }}"
                      color="success" />
        </div>
        <div class="col-xxl-3 col-sm-6">
            <x-widget
                      style="2"
                      link="{{ route('admin.contact.email') }}"
                      icon="las la-mail-bulk"
                      title="Total Email Contact"
                      value="{{ __($widget['total_email_contacts']) }}"
                      color="warning" />
        </div>
        <div class="col-xxl-3 col-sm-6">
            <x-widget
                      style="2"
                      link="{{ route('admin.contact.sms') }}"
                      icon="las la-phone-volume"
                      title="Total SMS Contact"
                      value="{{ __($widget['total_mobile_contacts']) }}"
                      color="success" />
        </div>
        <div class="col-xxl-3 col-sm-6">
            <x-widget
                      style="2"
                      link="{{ route('admin.contact.all') }}?status=0"
                      icon="las la-ban"
                      title="Total Banned Contact"
                      value="{{ __($widget['total_contacts']) }}"
                      color="danger" />
        </div>


        <div class="col-xxl-3 col-sm-6">
            <x-widget
                      style="2"
                      link="{{ route('admin.contact.all') }}"
                      icon="fas fa-layer-group"
                      title="Total Group"
                      value="{{ __($widget['total_groups']) }}"
                      color="info" />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget
                      style="2"
                      link="{{ route('admin.email.group.index') }}"
                      icon="las la-envelope-square"
                      title="Total Email Group"
                      value="{{ __($widget['total_email_groups']) }}"
                      color="primary" />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget
                      style="2"
                      link="{{ route('admin.sms.group.index') }}"
                      icon="las la-tty"
                      title="Total SMS Group"
                      value="{{ __($widget['total_mobile_groups']) }}"
                      color="info" />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget
                      style="2"
                      link="{{ route('admin.group.banned') }}"
                      icon="las la-ban"
                      title="Total Banned Group"
                      value="{{ __($widget['total_banned_groups']) }}"
                      color="danger" />
        </div>


    </div>

    <div class="row gy-4 mt-2">
        <div class="col-lg-12">
            <h5>@lang('Available Email Sender')</h5>
        </div>
        @foreach ($emailSender as $sender)
            <div class="col-xxl-3 col-sm-6">
                <div class="widget-six bg--white rounded-2 box--shadow2 h-100 w-100 {{ $sender }} p-3">
                    <div class="shape-icon text--warning shape-icon-2">
                        <i class="las la-envelope"></i>
                    </div>
                    <div class="widget-six__top justify-content-center border-bottom border--{{ $sender }} p-2">
                        <img src=" {{ getImage('assets/admin/images/email_sender/' . $sender . '.png') }}" alt="{{ $sender }}" class="__img gateway-thumb" alt="">
                    </div>
                    <div class="widget-six__bottom mt-3">
                        <h5>{{ __(ucfirst($sender)) }}</h5>
                        <a href="{{ route('admin.setting.notification.email') }}?sender={{ $sender }}" class="btn btn-outline--primary btn-sm">@lang('Configure')</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>


    <div class="row gy-4 mt-2">
        <div class="col-lg-12">
            <h5>@lang('Available SMS Gateway')</h5>
        </div>
        @foreach ($smsGateway as $gatWay)
            <div class="col-xl-3 col-sm-6">
                <div class="widget-six bg--white rounded-2 box--shadow2 h-100 p-3">
                    <div class="shape-icon text--warning">
                        <i class="las la-wifi"></i>
                    </div>
                    <div class="widget-six__top justify-content-center border-bottom border--{{ $gatWay }} p-2">
                        <img src="{{ getImage('assets/admin/images/sms_gatway/' . strtolower($gatWay) . '.png') }}"
                             class="gateway-thumb" alt="{{ $gatWay }}">
                    </div>
                    <div class="widget-six__bottom mt-3">
                        <h5>{{ __(ucfirst($gatWay)) }}</h5>
                        <a href="{{ route('admin.setting.notification.sms') }}?sms_method={{ $gatWay }}"
                           class="btn btn-outline--primary btn-sm">@lang('Configure')</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @include('admin.partials.cron_modal')
@endsection
@push('breadcrumb-plugins')
    <button class="btn btn-outline--primary btn-sm" data-bs-toggle="modal" data-bs-target="#cronModal">
        <i class="las la-server"></i>@lang('Cron Setup')
    </button>
@endpush


@push('style')
    <style>
        .gateway-thumb {
            width: 80px;
            height: 80px;
            object-fit: contain;
            margin: 0 auto;
        }

        .widget-six__bottom {
            gap: 5px 15px;
        }

        .widget-six {
            position: relative;
        }

        .widget-six .shape-icon {
            position: absolute;
            right: -30px;
            top: -32px;
            font-size: 100px;
            opacity: .09;
            transform: rotate(-135deg);
            line-height: 1;
        }

        .shape-icon.shape-icon-2 {
            transform: unset;
            right: -3px;
            top: -20px;
        }

        .click-mail {
            border-color: #d9f4fc !important;
        }

        .border--phpmail {
            border-bottom: 1px solid #6281b8 !important;
        }

        .border--smtp {
            border-bottom: 1px solid #13bf9b !important;
        }

        .border--mailjet {
            border-bottom: 1px solid #6281b8 !important;
        }

        .border--sendgrid {
            border-bottom: 1px solid #6fd4ef !important;
        }

        .border--infobip {
            border-bottom: 1px solid #ff5c15 !important;
        }

        .border--clickatell {
            border-bottom: 1px solid #8dc63f !important;
        }

        .border--messageBird {
            border-bottom: 1px solid #2581d8 !important;
        }

        .border--infobip {
            border-bottom: 1px solid #ff5c15 !important;
        }

        .border--nexmo {
            border-bottom: 1px solid #000 !important;
        }

        .border--smsBroadcast {
            border-bottom: 1px solid #e86c1f !important;
        }

        .border--twilio {
            border-bottom: 1px solid #f12e44 !important;
        }

        .border--textMagic {
            border-bottom: 1px solid #30668f !important;
        }

        .border--custom {
            border-bottom: 1px solid #000 !important;
        }

        .body-wrapper {
            overflow: hidden;
        }
    </style>
@endpush


@push('script-lib')
    <script src="{{ asset('assets/admin/js/vendor/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/vendor/chart.js.2.8.0.js') }}"></script>
    <script src="{{ asset('assets/admin/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/daterangepicker.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/charts.js') }}"></script>
@endpush

@push('style-lib')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/css/daterangepicker.css') }}">
@endpush


@push('style')
    <style>
        .apexcharts-menu {
            min-width: 120px !important;
        }
    </style>
@endpush
