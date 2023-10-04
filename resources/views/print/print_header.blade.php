<div class="row">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-3">
                <img style="display: block; margin: auto; width: 100px" class="" alt="LOGO" src="{{ asset('storage/setting/default_logo.png') }}"  width="150">
            </div>
            {{-- {{url('/storage/setting', $setComp['logo']  ?? '') }} --}}
            <div class="col-sm-6 text-center" style="width: 60%">
                <div style="font-weight: bolder; font-size: 24px; line-height: 24px">{{ $setComp['company_name'] ?? '' }}</div>
                <div>{{ $setComp['slogan'] ?? '' }}</div>
                <div style="font-size: 14px">@lang('cmn.address'): {{ $setComp['address'] ?? '' }}</div>
                <div style="font-size: 12px">
                    <i class="fa fa-phone"></i>@lang('cmn.phone'): {{ $setComp['phone'] ?? '' }}
                    <i class="fa fa-envelope"></i>@lang('cmn.email'): {{ $setComp['email'] ?? '' }}
                    <i class="fa fa-globe"></i>@lang('cmn.web_site'): {{ $setComp['website'] ?? '' }}
                </div>
            </div>
            <div class="col-sm-3 text-right" style="width: 20%">
                <br>
                <p style="position:relative;bottom:0;">
                    @lang('cmn.reporting_time'): <br>
                    {{ date('d M, Y h:i:s a') }}
                </p>
            </div>
        </div>
        <br>
    </div>
</div>