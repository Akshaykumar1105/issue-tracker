@extends('front.layout.layout')
@section('style')
    <link rel="stylesheet" href="{{ asset('asset/css/toastr.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/pricing.css') }}">
@endsection
@section('content')
    <div class="modal applyLoanModal fade" id="issueModel" tabindex="-1" aria-labelledby="issueModelLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-bottom-0">
                    <h4 class="modal-title" id="exampleModalLabel">Raise Issue</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('issue.store') }}" id="issue" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 mb-4 pb-2">
                                <div class="form-group">
                                    <label for="title" class="form-label">Title<span
                                            class="text-danger ms-1">*</span></label>
                                    <input type="text" value="{{ old('titleIssue') }}" class="form-control shadow-none"
                                        name="title" id="title" placeholder="Enter issue title.">
                                </div>
                            </div>

                            <div class="col-lg-12 mb-4 pb-2">
                                <div class="form-group">
                                    <label for="description" class="form-label">Issue Description<span
                                            class="text-danger ms-1">*</span></label>
                                    <textarea id="description" value="{{ old('description') }}" name="description" id="description"
                                        style="display: block;width: 100%;padding: 0.375rem 0.75rem;font-size: 1rem;font-weight: 400;line-height: 1.5;background-color: #fff;background-clip: padding-box;border: 1px solid #ced4da;-webkit-appearance: none;-moz-appearance: none;appearance: none;border-radius: 0.25rem;transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;"
                                        name="form-control shadow-none" rows="4" cols="50">
                                    </textarea>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-4 pb-2">
                                <div class="form-group">
                                    <label for="company" class="form-label">Company<span
                                            class="text-danger ms-1">*</span></label>
                                    <select class="form-control" value="{{ old('company') }}" name="company_id"
                                        id="company">
                                        <option value="default">Select Company</option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-4 pb-2">
                                <div class="form-group">
                                    <label for="hr" class="form-label">Hr.<span
                                            class="text-danger ms-1">*</span></label>
                                    <select class="form-control" value="{{ old('hr') }}" name="hr_id" id="hr">
                                        <option value="defaultHr">Select Company</option>
                                        {{-- {{ $hrs }}
                                        @if (!is_null($hrs))
                                            @foreach ($hrs as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        @else
                                            <option>No users found for this company.</option>
                                        @endif --}}

                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-4 pb-2">
                                <div class="form-group">
                                    <label for="email" class="form-label">E-mail address<span
                                            class="text-danger ms-1">*</span></label>
                                    <input type="email" value="{{ old('email') }}" class="form-control shadow-none"
                                        name="email" id="email" placeholder="Enter your E-mail">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary w-100">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <section class="banner bg-tertiary position-relative overflow-hidden">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="block text-center text-lg-start pe-0 pe-xl-5">
                        <h1 class="text-capitalize mb-4">{{ __('messages.home.title') }}</h1>
                        <p class="mb-4">{{ __('messages.home.description') }}
                        </p> <a type="button" class="btn btn-primary" href="#" data-bs-toggle="modal"
                            data-bs-target="#issueModel">Create Issue<span style="font-size: 14px;"
                                class="ms-2 fas fa-arrow-right"></span></a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="ps-lg-5 text-center">
                        <img loading="lazy" decoding="async" src="{{ asset('asset/user/images/banner/banner.png') }}"
                            alt="banner image" class="w-100">
                    </div>
                </div>
            </div>
        </div>
        <div class="has-shapes">
            <svg class="shape shape-left text-light" viewBox="0 0 192 752" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M-30.883 0C-41.3436 36.4248 -22.7145 75.8085 4.29154 102.398C31.2976 128.987 65.8677 146.199 97.6457 166.87C129.424 187.542 160.139 213.902 172.162 249.847C193.542 313.799 149.886 378.897 129.069 443.036C97.5623 540.079 122.109 653.229 191 728.495"
                    stroke="currentColor" stroke-miterlimit="10" />
                <path
                    d="M-55.5959 7.52271C-66.0565 43.9475 -47.4274 83.3312 -20.4214 109.92C6.58466 136.51 41.1549 153.722 72.9328 174.393C104.711 195.064 135.426 221.425 147.449 257.37C168.829 321.322 125.174 386.42 104.356 450.559C72.8494 547.601 97.3965 660.752 166.287 736.018"
                    stroke="currentColor" stroke-miterlimit="10" />
                <path
                    d="M-80.3302 15.0449C-90.7909 51.4697 -72.1617 90.8535 -45.1557 117.443C-18.1497 144.032 16.4205 161.244 48.1984 181.915C79.9763 202.587 110.691 228.947 122.715 264.892C144.095 328.844 100.439 393.942 79.622 458.081C48.115 555.123 72.6622 668.274 141.552 743.54"
                    stroke="currentColor" stroke-miterlimit="10" />
                <path
                    d="M-105.045 22.5676C-115.506 58.9924 -96.8766 98.3762 -69.8706 124.965C-42.8646 151.555 -8.29436 168.767 23.4835 189.438C55.2615 210.109 85.9766 236.469 98.0001 272.415C119.38 336.367 75.7243 401.464 54.9072 465.604C23.4002 562.646 47.9473 675.796 116.838 751.063"
                    stroke="currentColor" stroke-miterlimit="10" />
            </svg>
            <svg class="shape shape-right text-light" viewBox="0 0 731 746" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M12.1794 745.14C1.80036 707.275 -5.75764 666.015 8.73984 629.537C27.748 581.745 80.4729 554.968 131.538 548.843C182.604 542.703 234.032 552.841 285.323 556.748C336.615 560.64 391.543 557.276 433.828 527.964C492.452 487.323 511.701 408.123 564.607 360.255C608.718 320.353 675.307 307.183 731.29 327.323"
                    stroke="currentColor" stroke-miterlimit="10" />
                <path
                    d="M51.0253 745.14C41.2045 709.326 34.0538 670.284 47.7668 635.783C65.7491 590.571 115.623 565.242 163.928 559.449C212.248 553.641 260.884 563.235 309.4 566.931C357.916 570.627 409.887 567.429 449.879 539.701C505.35 501.247 523.543 426.331 573.598 381.059C615.326 343.314 678.324 330.853 731.275 349.906"
                    stroke="currentColor" stroke-miterlimit="10" />
                <path
                    d="M89.8715 745.14C80.6239 711.363 73.8654 674.568 86.8091 642.028C103.766 599.396 150.788 575.515 196.347 570.054C241.906 564.578 287.767 573.629 333.523 577.099C379.278 580.584 428.277 577.567 465.976 551.423C518.279 515.172 535.431 444.525 582.62 401.832C621.964 366.229 681.356 354.493 731.291 372.46"
                    stroke="currentColor" stroke-miterlimit="10" />
                <path
                    d="M128.718 745.14C120.029 713.414 113.678 678.838 125.837 648.274C141.768 608.221 185.939 585.788 228.737 580.659C271.536 575.515 314.621 584.008 357.6 587.282C400.58 590.556 446.607 587.719 482.028 563.16C531.163 529.111 547.275 462.733 591.612 422.635C628.572 389.19 684.375 378.162 731.276 395.043"
                    stroke="currentColor" stroke-miterlimit="10" />
                <path
                    d="M167.564 745.14C159.432 715.451 153.504 683.107 164.863 654.519C179.753 617.046 221.088 596.062 261.126 591.265C301.164 586.452 341.473 594.402 381.677 597.465C421.88 600.527 464.95 597.872 498.094 574.896C544.061 543.035 559.146 480.942 600.617 443.423C635.194 412.135 687.406 401.817 731.276 417.612"
                    stroke="currentColor" stroke-miterlimit="10" />
                <path
                    d="M817.266 289.466C813.108 259.989 787.151 237.697 759.261 227.271C731.372 216.846 701.077 215.553 671.666 210.904C642.254 206.24 611.795 197.156 591.664 175.224C555.853 136.189 566.345 75.5336 560.763 22.8649C552.302 -56.8256 498.487 -130.133 425 -162.081"
                    stroke="currentColor" stroke-miterlimit="10" />
                <path
                    d="M832.584 276.159C828.427 246.683 802.469 224.391 774.58 213.965C746.69 203.539 716.395 202.246 686.984 197.598C657.573 192.934 627.114 183.85 606.982 161.918C571.172 122.883 581.663 62.2275 576.082 9.55873C567.62 -70.1318 513.806 -143.439 440.318 -175.387"
                    stroke="currentColor" stroke-miterlimit="10" />
                <path
                    d="M847.904 262.853C843.747 233.376 817.789 211.084 789.9 200.659C762.011 190.233 731.716 188.94 702.304 184.292C672.893 179.627 642.434 170.544 622.303 148.612C586.492 109.577 596.983 48.9211 591.402 -3.74766C582.94 -83.4382 529.126 -156.746 455.638 -188.694"
                    stroke="currentColor" stroke-miterlimit="10" />
                <path
                    d="M863.24 249.547C859.083 220.07 833.125 197.778 805.236 187.353C777.347 176.927 747.051 175.634 717.64 170.986C688.229 166.321 657.77 157.237 637.639 135.306C601.828 96.2707 612.319 35.6149 606.738 -17.0538C598.276 -96.7443 544.462 -170.052 470.974 -202"
                    stroke="currentColor" stroke-miterlimit="10" />
            </svg>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="section-title pt-4">
                        <p class="text-primary text-uppercase fw-bold mb-3">Our Services</p>
                        <h1>Our online and offline services</h1>
                        <p>Lorem ipsum dolor sit amet, consectetur adipreiscing elit. Lacus penatibus tincidunt</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 service-item">
                    <a class="text-black" href="service-details.html">
                        <div class="block"> <span class="colored-box text-center h3 mb-4">01</span>
                            <h3 class="mb-3 service-title">{{ __('messages.service.first.title') }}</h3>
                            <p class="mb-0 service-description">{{ __('messages.service.first.description') }}</p>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6 service-item">
                    <a class="text-black" href="service-details.html">
                        <div class="block"> <span class="colored-box text-center h3 mb-4">02</span>
                            <h3 class="mb-3 service-title">{{ __('messages.service.second.title') }}</h3>
                            <p class="mb-0 service-description">{{ __('messages.service.second.description') }}</p>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6 service-item">
                    <a class="text-black" href="service-details.html">
                        <div class="block"> <span class="colored-box text-center h3 mb-4">03
                            </span>
                            <h3 class="mb-3 service-title">{{ __('messages.service.third.title') }}</h3>
                            <p class="mb-0 service-description">{{ __('messages.service.third.description') }}</p>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6 service-item">
                    <a class="text-black" href="service-details.html">
                        <div class="block"> <span class="colored-box text-center h3 mb-4">04
                            </span>
                            <h3 class="mb-3 service-title">{{ __('messages.service.fourth.title') }}</h3>
                            <p class="mb-0 service-description">{{ __('messages.service.fourth.description') }}</p>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-6 service-item">
                    <a class="text-black" href="service-details.html">
                        <div class="block"> <span class="colored-box text-center h3 mb-4">
                                05
                            </span>
                            <h3 class="mb-3 service-title">Payday Loans</h3>
                            <p class="mb-0 service-description">Lorem ipsum dolor sit amet, consetetur sadipscing elitr,
                                sed diam nonumy
                                eirmod</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="homepage_tab position-relative">
        <div class="section container">
            <div class="row justify-content-center">
                <div class="col-lg-8 mb-4">
                    <div class="section-title text-center">
                        <p class="text-primary text-uppercase fw-bold mb-3">Difference Of Us</p>
                        <h1>Get Know The Basics Simple Pricing And Payments</h1>
                    </div>
                </div>
                <div class="col-lg-10">
                    <ul class="payment_info_tab nav nav-pills justify-content-center mb-4" id="pills-tab" role="tablist">
                        <li class="nav-item m-2" role="presentation"> <a
                                class="nav-link btn btn-outline-primary effect-none text-dark active"
                                id="pills-how-much-can-i-recive-tab" data-bs-toggle="pill"
                                href="#pills-how-much-can-i-recive" role="tab"
                                aria-controls="pills-how-much-can-i-recive" aria-selected="true">How Much Does It
                                Costs?</a>
                        </li>
                    </ul>
                    <div class="rounded shadow bg-white p-5 tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-how-much-can-i-recive" role="tabpanel"
                            aria-labelledby="pills-how-much-can-i-recive-tab">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card pricing-card pricing-plan-basic">
                                            <div class="card-body">
                                                <i class="mdi mdi-cube-outline pricing-plan-icon"></i>
                                                <p class="pricing-plan-title">Basic</p>
                                                <h3 class="pricing-plan-cost ml-auto">FREE</h3>
                                                <ul class="pricing-plan-features">
                                                    <li>Unlimited conferences</li>
                                                    <li>100 participants max</li>
                                                    <li>Custom Hold Music</li>
                                                    <li>10 participants max</li>
                                                </ul>
                                                <a href="#!" class="btn pricing-plan-purchase-btn">Free</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card pricing-card pricing-card-highlighted  pricing-plan-pro">
                                            <div class="card-body">
                                                <i class="mdi mdi-trophy pricing-plan-icon"></i>
                                                <p class="pricing-plan-title">Premium</p>
                                                <h3 class="pricing-plan-cost ml-auto">₹5000</h3>
                                                <ul class="pricing-plan-features">
                                                    <li>Unlimited conferences</li>
                                                    <li>100 participants max</li>
                                                    <li>Custom Hold Music</li>
                                                    <li>10 participants max</li>
                                                </ul>
                                                <a href="#!" class="btn pricing-plan-purchase-btn">Purchase</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="has-shapes">
                <svg class="shape shape-left text-light" width="290" height="709" viewBox="0 0 290 709"
                    fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M-119.511 58.4275C-120.188 96.3185 -92.0001 129.539 -59.0325 148.232C-26.0649 166.926 11.7821 174.604 47.8274 186.346C83.8726 198.088 120.364 215.601 141.281 247.209C178.484 303.449 153.165 377.627 149.657 444.969C144.34 546.859 197.336 649.801 283.36 704.673"
                        stroke="currentColor" stroke-miterlimit="10" />
                    <path
                        d="M-141.434 72.0899C-142.111 109.981 -113.923 143.201 -80.9554 161.895C-47.9878 180.588 -10.1407 188.267 25.9045 200.009C61.9497 211.751 98.4408 229.263 119.358 260.872C156.561 317.111 131.242 391.29 127.734 458.631C122.417 560.522 175.414 663.463 261.437 718.335"
                        stroke="currentColor" stroke-miterlimit="10" />
                    <path
                        d="M-163.379 85.7578C-164.056 123.649 -135.868 156.869 -102.901 175.563C-69.9331 194.256 -32.086 201.934 3.9592 213.677C40.0044 225.419 76.4955 242.931 97.4127 274.54C134.616 330.779 109.296 404.957 105.789 472.299C100.472 574.19 153.468 677.131 239.492 732.003"
                        stroke="currentColor" stroke-miterlimit="10" />
                    <path
                        d="M-185.305 99.4208C-185.982 137.312 -157.794 170.532 -124.826 189.226C-91.8589 207.919 -54.0118 215.597 -17.9666 227.34C18.0787 239.082 54.5697 256.594 75.4869 288.203C112.69 344.442 87.3706 418.62 83.8633 485.962C78.5463 587.852 131.542 690.794 217.566 745.666"
                        stroke="currentColor" stroke-miterlimit="10" />
                </svg>
                <svg class="shape shape-right text-light" width="474" height="511" viewBox="0 0 474 511"
                    fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M601.776 325.899C579.043 348.894 552.727 371.275 520.74 375.956C478.826 382.079 438.015 355.5 412.619 321.6C387.211 287.707 373.264 246.852 354.93 208.66C336.584 170.473 311.566 132.682 273.247 114.593C220.12 89.5159 155.704 108.4 99.7772 90.3769C53.1531 75.3464 16.3392 33.2759 7.65012 -14.947"
                        stroke="currentColor" stroke-miterlimit="10" />
                    <path
                        d="M585.78 298.192C564.28 319.945 539.378 341.122 509.124 345.548C469.472 351.341 430.868 326.199 406.845 294.131C382.805 262.059 369.62 223.419 352.278 187.293C334.936 151.168 311.254 115.417 275.009 98.311C224.74 74.582 163.815 92.4554 110.913 75.3971C66.8087 61.1784 31.979 21.3767 23.7639 -24.2362"
                        stroke="currentColor" stroke-miterlimit="10" />
                    <path
                        d="M569.783 270.486C549.5 290.99 526.04 310.962 497.501 315.13C460.111 320.592 423.715 296.887 401.059 266.641C378.392 236.402 365.963 199.965 349.596 165.901C333.24 131.832 310.911 98.1265 276.74 82.0034C229.347 59.6271 171.895 76.4848 122.013 60.4086C80.419 47.0077 47.5905 9.47947 39.8431 -33.5342"
                        stroke="currentColor" stroke-miterlimit="10" />
                    <path
                        d="M553.787 242.779C534.737 262.041 512.691 280.809 485.884 284.722C450.757 289.853 416.568 267.586 395.286 239.173C373.993 210.766 362.308 176.538 346.945 144.535C331.581 112.533 310.605 80.8723 278.502 65.7217C233.984 44.6979 180.006 60.54 133.149 45.4289C94.0746 32.8398 63.2303 -2.41965 55.9568 -42.8233"
                        stroke="currentColor" stroke-miterlimit="10" />
                    <path
                        d="M537.791 215.073C519.964 233.098 499.336 250.645 474.269 254.315C441.41 259.126 409.422 238.286 389.513 211.704C369.594 185.13 358.665 153.106 344.294 123.17C329.923 93.2337 310.293 63.6078 280.258 49.4296C238.605 29.7646 188.105 44.5741 144.268 30.4451C107.714 18.6677 78.8538 -14.3229 72.0543 -52.1165"
                        stroke="currentColor" stroke-miterlimit="10" />
                </svg>
            </div>
        </div>
    </section>

    <section class="section testimonials overflow-hidden bg-tertiary">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section-title text-center">
                        <p class="text-primary text-uppercase fw-bold mb-3">Our Service Holders</p>
                        <h1 class="mb-4">Trusted By 1.2K+ Peoples</h1>
                        <p class="lead mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing. egestas cursus
                            pellentesque dignissim
                            dui, congue. Vel etiam ut</p>
                    </div>
                </div>
            </div>
            <div class="row position-relative">
                <div class="col-lg-4 col-md-6 pt-1">
                    <div class="shadow rounded bg-white p-4 mt-4">
                        <div class="d-block d-sm-flex align-items-center mb-3">
                            <img loading="lazy" decoding="async"
                                src="{{ asset('asset/user/images/testimonials/01.jpg') }}" alt="Leslie Alexander"
                                class="img-fluid" width="65" height="66">
                            <div class="mt-3 mt-sm-0 ms-0 ms-sm-3">
                                <h4 class="h5 mb-1">Leslie Alexander</h4>
                                <p class="mb-0">Web Designer</p>
                            </div>
                        </div>
                        <div class="content">Lorem ipsum dolor <a href="http://google.com">@reamansimond</a> demina
                            egestas sit purus
                            felis arcu. Vitae, turpisds tortr etiam faucibus ac suspendisse.</div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 pt-1">
                    <div class="shadow rounded bg-white p-4 mt-4">
                        <div class="d-block d-sm-flex align-items-center mb-3">
                            <img loading="lazy" decoding="async"
                                src="{{ asset('asset/user/images/testimonials/02.jpg') }}" alt="Arlene McCoy"
                                class="img-fluid" width="65" height="66">
                            <div class="mt-3 mt-sm-0 ms-0 ms-sm-3">
                                <h4 class="h5 mb-1">Arlene McCoy</h4>
                                <p class="mb-0">Content Strategist</p>
                            </div>
                        </div>
                        <div class="content">Lorem ipsum dolor <a href="http://google.com">@reamansimond</a> demina
                            egestas sit purus
                            felis arcu. Vitae, turpisds tortr etiam faucibus ac suspendisse.</div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 pt-1">
                    <div class="shadow rounded bg-white p-4 mt-4">
                        <div class="d-block d-sm-flex align-items-center mb-3">
                            <img loading="lazy" decoding="async"
                                src="{{ asset('asset/user/images/testimonials/03.jpg') }}" alt="Marvin McKinney"
                                class="img-fluid" width="65" height="66">
                            <div class="mt-3 mt-sm-0 ms-0 ms-sm-3">
                                <h4 class="h5 mb-1">Marvin McKinney</h4>
                                <p class="mb-0">Video Game Writer</p>
                            </div>
                        </div>
                        <div class="content">Lorem ipsum dolor <a href="http://google.com">@reamansimond</a> demina
                            egestas sit purus
                            felis arcu. Vitae, turpisds tortr etiam faucibus ac suspendisse.</div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 pt-1">
                    <div class="shadow rounded bg-white p-4 mt-4">
                        <div class="d-block d-sm-flex align-items-center mb-3">
                            <img loading="lazy" decoding="async"
                                src="{{ asset('asset/user/images/testimonials/04.jpg') }}" alt="Devon Lane"
                                class="img-fluid" width="65" height="66">
                            <div class="mt-3 mt-sm-0 ms-0 ms-sm-3">
                                <h4 class="h5 mb-1">Devon Lane</h4>
                                <p class="mb-0">Nursing Assistant</p>
                            </div>
                        </div>
                        <div class="content">Lorem ipsum dolor <a href="http://google.com">@reamansimond</a> demina
                            egestas sit purus
                            felis arcu. Vitae, turpisds tortr etiam faucibus ac suspendisse.</div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 pt-1">
                    <div class="shadow rounded bg-white p-4 mt-4">
                        <div class="d-block d-sm-flex align-items-center mb-3">
                            <img loading="lazy" decoding="async"
                                src="{{ asset('asset/user/images/testimonials/05.jpg') }}" alt="Bessie Cooper"
                                class="img-fluid" width="65" height="66">
                            <div class="mt-3 mt-sm-0 ms-0 ms-sm-3">
                                <h4 class="h5 mb-1">Bessie Cooper</h4>
                                <p class="mb-0">Video Game Writer</p>
                            </div>
                        </div>
                        <div class="content">Lorem ipsum dolor <a href="http://google.com">@reamansimond</a> demina
                            egestas sit purus
                            felis arcu. Vitae, turpisds tortr etiam faucibus ac suspendisse.</div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 pt-1">
                    <div class="shadow rounded bg-white p-4 mt-4">
                        <div class="d-block d-sm-flex align-items-center mb-3">
                            <img loading="lazy" decoding="async"
                                src="{{ asset('asset/user/images/testimonials/06.jpg') }}" alt="Kathryn Murphy"
                                class="img-fluid" width="65" height="66">
                            <div class="mt-3 mt-sm-0 ms-0 ms-sm-3">
                                <h4 class="h5 mb-1">Kathryn Murphy</h4>
                                <p class="mb-0">Film Critic</p>
                            </div>
                        </div>
                        <div class="content">Lorem ipsum dolor <a href="http://google.com">@reamansimond</a> demina
                            egestas sit purus
                            felis arcu. Vitae, turpisds tortr etiam faucibus ac suspendisse.</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="has-shapes">
            <svg class="shape shape-left text-light" width="290" height="709" viewBox="0 0 290 709" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M-119.511 58.4275C-120.188 96.3185 -92.0001 129.539 -59.0325 148.232C-26.0649 166.926 11.7821 174.604 47.8274 186.346C83.8726 198.088 120.364 215.601 141.281 247.209C178.484 303.449 153.165 377.627 149.657 444.969C144.34 546.859 197.336 649.801 283.36 704.673"
                    stroke="currentColor" stroke-miterlimit="10" />
                <path
                    d="M-141.434 72.0899C-142.111 109.981 -113.923 143.201 -80.9554 161.895C-47.9878 180.588 -10.1407 188.267 25.9045 200.009C61.9497 211.751 98.4408 229.263 119.358 260.872C156.561 317.111 131.242 391.29 127.734 458.631C122.417 560.522 175.414 663.463 261.437 718.335"
                    stroke="currentColor" stroke-miterlimit="10" />
                <path
                    d="M-163.379 85.7578C-164.056 123.649 -135.868 156.869 -102.901 175.563C-69.9331 194.256 -32.086 201.934 3.9592 213.677C40.0044 225.419 76.4955 242.931 97.4127 274.54C134.616 330.779 109.296 404.957 105.789 472.299C100.472 574.19 153.468 677.131 239.492 732.003"
                    stroke="currentColor" stroke-miterlimit="10" />
                <path
                    d="M-185.305 99.4208C-185.982 137.312 -157.794 170.532 -124.826 189.226C-91.8589 207.919 -54.0118 215.597 -17.9666 227.34C18.0787 239.082 54.5697 256.594 75.4869 288.203C112.69 344.442 87.3706 418.62 83.8633 485.962C78.5463 587.852 131.542 690.794 217.566 745.666"
                    stroke="currentColor" stroke-miterlimit="10" />
            </svg>
            <svg class="shape shape-right text-light" width="731" height="429" viewBox="0 0 731 429"
                fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M12.1794 428.14C1.80036 390.275 -5.75764 349.015 8.73984 312.537C27.748 264.745 80.4729 237.968 131.538 231.843C182.604 225.703 234.032 235.841 285.323 239.748C336.615 243.64 391.543 240.276 433.828 210.964C492.452 170.323 511.701 91.1227 564.607 43.2553C608.718 3.35334 675.307 -9.81661 731.29 10.323"
                    stroke="currentColor" stroke-miterlimit="10" />
                <path
                    d="M51.0253 428.14C41.2045 392.326 34.0538 353.284 47.7668 318.783C65.7491 273.571 115.623 248.242 163.928 242.449C212.248 236.641 260.884 246.235 309.4 249.931C357.916 253.627 409.887 250.429 449.879 222.701C505.35 184.248 523.543 109.331 573.598 64.0588C615.326 26.3141 678.324 13.8532 731.275 32.9066"
                    stroke="currentColor" stroke-miterlimit="10" />
                <path
                    d="M89.8715 428.14C80.6239 394.363 73.8654 357.568 86.8091 325.028C103.766 282.396 150.788 258.515 196.347 253.054C241.906 247.578 287.767 256.629 333.523 260.099C379.278 263.584 428.277 260.567 465.976 234.423C518.279 198.172 535.431 127.525 582.62 84.8317C621.964 49.2292 681.356 37.4924 731.291 55.4596"
                    stroke="currentColor" stroke-miterlimit="10" />
                <path
                    d="M128.718 428.14C120.029 396.414 113.678 361.838 125.837 331.274C141.768 291.221 185.939 268.788 228.737 263.659C271.536 258.515 314.621 267.008 357.6 270.282C400.58 273.556 446.607 270.719 482.028 246.16C531.163 212.111 547.275 145.733 591.612 105.635C628.572 72.19 684.375 61.1622 731.276 78.0432"
                    stroke="currentColor" stroke-miterlimit="10" />
                <path
                    d="M167.564 428.14C159.432 398.451 153.504 366.107 164.863 337.519C179.753 300.046 221.088 279.062 261.126 274.265C301.164 269.452 341.473 277.402 381.677 280.465C421.88 283.527 464.95 280.872 498.094 257.896C544.061 226.035 559.146 163.942 600.617 126.423C635.194 95.1355 687.406 84.8167 731.276 100.612"
                    stroke="currentColor" stroke-miterlimit="10" />
            </svg>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="section-title text-center mb-5 pb-2">
                        <p class="text-primary text-uppercase fw-bold mb-3">Questions You Have</p>
                        <h1>Frequently Asked Questions</h1>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="accordion shadow rounded py-5 px-0 px-lg-4 bg-white position-relative" id="accordionFAQ">
                        <div class="accordion-item p-1 mb-2">
                            <h2 class="accordion-header accordion-button h5 border-0 active"
                                id="heading-ebd23e34fd2ed58299b32c03c521feb0b02f19d9" type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#collapse-ebd23e34fd2ed58299b32c03c521feb0b02f19d9" aria-expanded="true"
                                aria-controls="collapse-ebd23e34fd2ed58299b32c03c521feb0b02f19d9">Can I apply if my credit
                                isn&rsquo;t
                                perfect?
                            </h2>
                            <div id="collapse-ebd23e34fd2ed58299b32c03c521feb0b02f19d9"
                                class="accordion-collapse collapse border-0 show"
                                aria-labelledby="heading-ebd23e34fd2ed58299b32c03c521feb0b02f19d9"
                                data-bs-parent="#accordionFAQ">
                                <div class="accordion-body py-0 content">The difference between and premium product consist
                                    number of
                                    components, plugins, page in each. The Free versions contain only a few elements and
                                    pages that.</div>
                            </div>
                        </div>
                        <div class="accordion-item p-1 mb-2">
                            <h2 class="accordion-header accordion-button h5 border-0 "
                                id="heading-a443e01b4db47b3f4a1267e10594576d52730ec1" type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#collapse-a443e01b4db47b3f4a1267e10594576d52730ec1" aria-expanded="false"
                                aria-controls="collapse-a443e01b4db47b3f4a1267e10594576d52730ec1">How do I know that I have
                                been
                                approved?
                            </h2>
                            <div id="collapse-a443e01b4db47b3f4a1267e10594576d52730ec1"
                                class="accordion-collapse collapse border-0 "
                                aria-labelledby="heading-a443e01b4db47b3f4a1267e10594576d52730ec1"
                                data-bs-parent="#accordionFAQ">
                                <div class="accordion-body py-0 content">The difference between and premium product consist
                                    number of
                                    components, plugins, page in each. The Free versions contain only a few elements and
                                    pages that.</div>
                            </div>
                        </div>
                        <div class="accordion-item p-1 mb-2">
                            <h2 class="accordion-header accordion-button h5 border-0 "
                                id="heading-4b82be4be873c8ad699fa97049523ac86b67a8bd" type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#collapse-4b82be4be873c8ad699fa97049523ac86b67a8bd" aria-expanded="false"
                                aria-controls="collapse-4b82be4be873c8ad699fa97049523ac86b67a8bd">Do I need to fax or email
                                any
                                documents?
                            </h2>
                            <div id="collapse-4b82be4be873c8ad699fa97049523ac86b67a8bd"
                                class="accordion-collapse collapse border-0 "
                                aria-labelledby="heading-4b82be4be873c8ad699fa97049523ac86b67a8bd"
                                data-bs-parent="#accordionFAQ">
                                <div class="accordion-body py-0 content">The difference between and premium product consist
                                    number of
                                    components, plugins, page in each. The Free versions contain only a few elements and
                                    pages that.</div>
                            </div>
                        </div>
                        <div class="accordion-item p-1 mb-2">
                            <h2 class="accordion-header accordion-button h5 border-0 "
                                id="heading-3e13e9676a9cd6a6f8bfbe6e1e9fc0881ef247b3" type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#collapse-3e13e9676a9cd6a6f8bfbe6e1e9fc0881ef247b3" aria-expanded="false"
                                aria-controls="collapse-3e13e9676a9cd6a6f8bfbe6e1e9fc0881ef247b3">Do you provide loans to
                                military
                                personnel?
                            </h2>
                            <div id="collapse-3e13e9676a9cd6a6f8bfbe6e1e9fc0881ef247b3"
                                class="accordion-collapse collapse border-0 "
                                aria-labelledby="heading-3e13e9676a9cd6a6f8bfbe6e1e9fc0881ef247b3"
                                data-bs-parent="#accordionFAQ">
                                <div class="accordion-body py-0 content">The difference between and premium product consist
                                    number of
                                    components, plugins, page in each. The Free versions contain only a few elements and
                                    pages that.</div>
                            </div>
                        </div>
                        <div class="accordion-item p-1 mb-2">
                            <h2 class="accordion-header accordion-button h5 border-0 "
                                id="heading-0c2f829793a1f0562fea97120357dd2d43319164" type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#collapse-0c2f829793a1f0562fea97120357dd2d43319164" aria-expanded="false"
                                aria-controls="collapse-0c2f829793a1f0562fea97120357dd2d43319164">Can I remove footer
                                credit purchase ?
                            </h2>
                            <div id="collapse-0c2f829793a1f0562fea97120357dd2d43319164"
                                class="accordion-collapse collapse border-0 "
                                aria-labelledby="heading-0c2f829793a1f0562fea97120357dd2d43319164"
                                data-bs-parent="#accordionFAQ">
                                <div class="accordion-body py-0 content">The difference between and premium product consist
                                    number of
                                    components, plugins, page in each. The Free versions contain only a few elements and
                                    pages that.</div>
                            </div>
                        </div>
                        <div class="accordion-item p-1 mb-2">
                            <h2 class="accordion-header accordion-button h5 border-0 "
                                id="heading-8fe6730e26db16f15763887c30a614caa075f518" type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#collapse-8fe6730e26db16f15763887c30a614caa075f518" aria-expanded="false"
                                aria-controls="collapse-8fe6730e26db16f15763887c30a614caa075f518">What is the difference
                                the free
                                versions?
                            </h2>
                            <div id="collapse-8fe6730e26db16f15763887c30a614caa075f518"
                                class="accordion-collapse collapse border-0 "
                                aria-labelledby="heading-8fe6730e26db16f15763887c30a614caa075f518"
                                data-bs-parent="#accordionFAQ">
                                <div class="accordion-body py-0 content">The difference between and premium product consist
                                    number of
                                    components, plugins, page in each. The Free versions contain only a few elements and
                                    pages that.</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mt-4 mt-lg-0">
                    <div class="shadow rounded py-5 px-4 ms-0 ms-lg-4 bg-white position-relative">
                        <div class="block mx-0 mx-lg-3 mt-0">
                            <h4 class="h5">Still Have Questions?</h4>
                            <div class="content">Call Us We Will Be Happy To Help
                                <br> <a href="tel:+3301563965">+3301563965</a>
                                <br>Monday - Friday
                                <br>9AM TO 8PM Eastern Time
                            </div>
                        </div>
                        <div class="block mx-0 mx-lg-3 mt-4">
                            <h4 class="h5">Canada Office</h4>
                            <div class="content">231 Ross Street.
                                <br>K7A 1C2.
                                <br>Smiths Falls
                            </div>
                        </div>
                        <div class="block mx-0 mx-lg-3 mt-4">
                            <h4 class="h5">UK Office</h4>
                            <div class="content">57 Folkestone Road.
                                <br>AB54 5XQ,
                                <br>Winston
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script src="{{ asset('asset/js/validation.min.js') }}"></script>
    <script src="{{ asset('asset/js/toastr.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            $(document).on('change', '#company', function() {
                companyId = $(this).val();
                $.ajax({
                    url: "{{ route('home') }}",
                    type: 'get',
                    data: {
                        company: companyId
                    },
                    success: function(response) {
                        let option;
                        var hrSelect = $('#company');
                        if (response.hrs !== null && response.hrs.length > 0) {
                            $.each(response.hrs, function(index, user) {
                                option += '<option value=' + user.id + '>' + user.name +
                                    '</option>'
                                $('#hr').html(option)
                            });
                        } else {
                            // If no users are found, add a default option
                            option += '<option value=>No users found for this company.</option>'
                            $('#hr').html(option)
                        }
                    }
                });
            })

            $.validator.addMethod("valueNotEquals", function(value, element, arg) {
                return arg !== value;
            }, "Please select a company from the list.");

            $("#issue").validate({
                errorClass: "text-danger fw-normal",
                rules: {
                    title: {
                        required: true,
                    },
                    description: {
                        required: true,
                        minlength: 50
                    },
                    company_id: {
                        required: true,
                        valueNotEquals: "default"
                    },
                    email: {
                        required: true,
                        email: true,
                    },
                    hr_id: {
                        required: true,
                        valueNotEquals: "defaultHr"
                    }

                },
                messages: {
                    company_id: {
                        required: "{{ __('validation.required', ['attribute' => 'hr']) }}",
                        valueNotEquals: "{{ __('validation.valueNotEquals', ['attribute' => 'company']) }}"
                    },
                    hr_id: {
                        required: "{{ __('validation.required', ['attribute' => 'hr']) }}",
                        valueNotEquals: "{{ __('validation.valueNotEquals', ['attribute' => 'hr']) }}"
                    },
                    email: {
                        required: "{{ __('validation.required', ['attribute' => 'email']) }}",
                        email: "{{ __('validation.valid', ['attribute' => 'email']) }}",
                    },
                    title: {
                        required: "{{ __('validation.required', ['attribute' => 'title']) }}",
                        maxlength: "{{ __('validation.max_digits', ['attribute' => 'title', 'max' => '255']) }}",
                    },
                    description: {
                        required: "{{ __('validation.required', ['attribute' => 'description']) }}",
                        minlength: "{{ __('validation.min_digits', ['attribute' => 'description', 'min' => '50']) }}",
                    },
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: $(form).attr("action"),
                        type: $(form).attr("method"),
                        data: $(form).serialize(),
                        success: function(response) {
                            toastr.options = {
                                closeButton: true,
                                progressBar: true,
                            }
                            toastr.success(response.success);
                            $("#issueModel").modal("toggle");
                            form.reset();
                        },
                        error: function(xhr, status, error) {
                            var response = JSON.parse(xhr.responseText);
                            var message = response.message;
                            toastr.options = {
                                closeButton: true,
                                progressBar: true,
                            }
                            toastr.error(message);
                        },
                    })
                },
            });
        });
    </script>
@endsection
