<div x-data="modal">

    <!-- button -->
    <button type="button" class="btn btn-info" @click="toggle" onclick="scrollToTop()">View & Download All
        Documents</button>

    <!-- modal -->
    <div class="fixed inset-0 bg-[black]/60 z-[999] hidden overflow-y-auto" :class="open && '!block'">
        <div class="flex items-start justify-center min-h-screen px-4" @click.self="open = false">
            <div x-show="open" x-transition x-transition.duration.300
                class="panel border-0 p-0 rounded-lg overflow-hidden my-8" style="width: 40rem; height: 40rem;">
                <div class="flex bg-[#fbfbfb] dark:bg-[#121c2c] items-center justify-between px-5 py-3">
                    <h5 class="font-bold text-lg">Documents</h5>
                    <button type="button" class="text-white-dark hover:text-dark" @click="toggle">
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="30" height="30"
                            viewBox="0 0 48 48">
                            <linearGradient id="wRKXFJsqHCxLE9yyOYHkza_fYgQxDaH069W_gr1" x1="9.858" x2="38.142"
                                y1="9.858" y2="38.142" gradientUnits="userSpaceOnUse">
                                <stop offset="0" stop-color="#f44f5a"></stop>
                                <stop offset=".443" stop-color="#ee3d4a"></stop>
                                <stop offset="1" stop-color="#e52030"></stop>
                            </linearGradient>
                            <path fill="url(#wRKXFJsqHCxLE9yyOYHkza_fYgQxDaH069W_gr1)"
                                d="M44,24c0,11.045-8.955,20-20,20S4,35.045,4,24S12.955,4,24,4S44,12.955,44,24z">
                            </path>
                            <path
                                d="M33.192,28.95L28.243,24l4.95-4.95c0.781-0.781,0.781-2.047,0-2.828l-1.414-1.414	c-0.781-0.781-2.047-0.781-2.828,0L24,19.757l-4.95-4.95c-0.781-0.781-2.047-0.781-2.828,0l-1.414,1.414	c-0.781,0.781-0.781,2.047,0,2.828l4.95,4.95l-4.95,4.95c-0.781,0.781-0.781,2.047,0,2.828l1.414,1.414	c0.781,0.781,2.047,0.781,2.828,0l4.95-4.95l4.95,4.95c0.781,0.781,2.047,0.781,2.828,0l1.414-1.414	C33.973,30.997,33.973,29.731,33.192,28.95z"
                                opacity=".05"></path>
                            <path
                                d="M32.839,29.303L27.536,24l5.303-5.303c0.586-0.586,0.586-1.536,0-2.121l-1.414-1.414	c-0.586-0.586-1.536-0.586-2.121,0L24,20.464l-5.303-5.303c-0.586-0.586-1.536-0.586-2.121,0l-1.414,1.414	c-0.586,0.586-0.586,1.536,0,2.121L20.464,24l-5.303,5.303c-0.586,0.586-0.586,1.536,0,2.121l1.414,1.414	c0.586,0.586,1.536,0.586,2.121,0L24,27.536l5.303,5.303c0.586,0.586,1.536,0.586,2.121,0l1.414-1.414	C33.425,30.839,33.425,29.889,32.839,29.303z"
                                opacity=".07"></path>
                            <path fill="#fff"
                                d="M31.071,15.515l1.414,1.414c0.391,0.391,0.391,1.024,0,1.414L18.343,32.485	c-0.391,0.391-1.024,0.391-1.414,0l-1.414-1.414c-0.391-0.391-0.391-1.024,0-1.414l14.142-14.142	C30.047,15.124,30.681,15.124,31.071,15.515z">
                            </path>
                            <path fill="#fff"
                                d="M32.485,31.071l-1.414,1.414c-0.391,0.391-1.024,0.391-1.414,0L15.515,18.343	c-0.391-0.391-0.391-1.024,0-1.414l1.414-1.414c0.391-0.391,1.024-0.391,1.414,0l14.142,14.142	C32.876,30.047,32.876,30.681,32.485,31.071z">
                            </path>
                        </svg>
                    </button>
                </div>
                <div class="p-5">
                    <div class="mb-5" x-data="{ tab: 'allDoc' }">
                        <div>
                            <ul class="flex flex-wrap mt-3 border-b border-white-light dark:border-[#191e3a]">
                                <li>
                                    <a href="javascript:;"
                                        class="p-3.5 py-2 -mb-[1px] block border border-transparent hover:text-primary dark:hover:border-b-black"
                                        :class="{ '!border-white-light !border-b-white  text-primary dark:!border-[#191e3a] dark:!border-b-black': tab === 'allDoc' }"
                                        @click="tab = 'allDoc'">All Documents</a>
                                </li>
                                <li>
                                    <a href="javascript:;"
                                        class="p-3.5 py-2 -mb-[1px] block border border-transparent hover:text-primary dark:hover:border-[#191e3a] dark:hover:border-b-black"
                                        :class="{ '!border-white-light !border-b-white text-primary dark:!border-[#191e3a] dark:!border-b-black': tab === 'idCard' }"
                                        @click="tab = 'idCard'">Emirates ID</a>
                                </li>
                                <li>
                                    <a href="javascript:;"
                                        class="p-3.5 py-2 -mb-[1px] block border border-transparent hover:text-primary dark:hover:border-[#191e3a] dark:hover:border-b-black"
                                        :class="{ '!border-white-light !border-b-white text-primary dark:!border-[#191e3a] dark:!border-b-black': tab === 'passport' }"
                                        @click="tab = 'passport'">Passport</a>
                                </li>
                                <li>
                                    <a href="javascript:;"
                                        class="p-3.5 py-2 -mb-[1px] block border border-transparent hover:text-primary dark:hover:border-[#191e3a] dark:hover:border-b-black"
                                        :class="{ '!border-white-light !border-b-white text-primary dark:!border-[#191e3a] dark:!border-b-black': tab === 'drivingLicense' }"
                                        @click="tab = 'drivingLicense'">Driving License</a>
                                </li>
                                <li>
                                    <a href="javascript:;"
                                        class="p-3.5 py-2 -mb-[1px] block border border-transparent hover:text-primary dark:hover:border-[#191e3a] dark:hover:border-b-black"
                                        :class="{ '!border-white-light !border-b-white text-primary dark:!border-[#191e3a] dark:!border-b-black': tab === 'truckDocument' }"
                                        @click="tab = 'truckDocument'">Truck Document</a>
                                </li>
                                {{-- <li>
                                    <a href="javascript:;"
                                        class="p-3.5 py-2 -mb-[1px] block pointer-events-none text-white-light dark:text-dark">Disabled</a>
                                </li> --}}
                            </ul>
                        </div>
                        <div class="pt-5 flex-1 text-sm">
                            <div class="pt-5 flex-1 text-sm">
                                <!-- All Documents Tab -->
                                <template x-if="tab === 'allDoc'">
                                    <div class="active">
                                        @if (!empty($driver->all_documents))
                                            <div class="header">
                                                <h4 class="header-title">All Documents</h4>
                                                <a href="{{ asset('public/' . $driver->all_documents) }}" download
                                                    class="btn btn-primary download-btn">Download</a>
                                            </div>

                                            <div class="swiper-wrapper">
                                                <div class="swiper-slide">
                                                    @php
                                                        $extension = pathinfo(
                                                            $driver->all_documents,
                                                            PATHINFO_EXTENSION,
                                                        );
                                                    @endphp

                                                    @if ($extension == 'pdf')
                                                        <iframe src="{{ asset('public/' . $driver->all_documents) }}"
                                                            type="application/pdf" class="document-viewer"
                                                            alt="document"></iframe>
                                                    @else
                                                        <div class="image-container">
                                                            <img src="{{ asset('public/' . $driver->all_documents) }}"
                                                                class="image-viewer" alt="image" />
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @else
                                            <div class="header">
                                                <h4 class="header-title">No Documents Found</h4>
                                            </div>
                                        @endif
                                    </div>
                                </template>

                                <!-- Emirates ID Tab -->
                                <template x-if="tab === 'idCard'">
                                    <div class="active">
                                        @if (!empty($driver->id_card))
                                            <div class="header">
                                                <h5 class="header-title">Emirates ID</h5>
                                                <a href="{{ asset('public/' . $driver->id_card) }}" download
                                                    class="btn btn-primary download-btn">Download</a>
                                            </div>

                                            <div class="swiper-wrapper">
                                                <div class="swiper-slide">
                                                    @php
                                                        $extension = pathinfo($driver->id_card, PATHINFO_EXTENSION);
                                                    @endphp

                                                    @if ($extension == 'pdf')
                                                        <iframe src="{{ asset('public/' . $driver->id_card) }}"
                                                            type="application/pdf" class="document-viewer"
                                                            alt="document"></iframe>
                                                    @else
                                                        <div class="image-container">
                                                            <img src="{{ asset('public/' . $driver->id_card) }}"
                                                                class="image-viewer" alt="image" />
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @else
                                            <div class="header">
                                                <h5 class="header-title">No Documents Found</h5>
                                            </div>
                                        @endif
                                    </div>
                                </template>

                                <!-- Passport Tab -->
                                <template x-if="tab === 'passport'">
                                    <div class="active">
                                        @if (!empty($driver->passport))
                                            <div class="header">
                                                <h5 class="header-title">Passport</h5>
                                                <a href="{{ asset('public/' . $driver->passport) }}" download
                                                    class="btn btn-primary download-btn">Download</a>
                                            </div>

                                            <div class="swiper-wrapper">
                                                <div class="swiper-slide">
                                                    @php
                                                        $extension = pathinfo($driver->passport, PATHINFO_EXTENSION);
                                                    @endphp

                                                    @if ($extension == 'pdf')
                                                        <iframe src="{{ asset('public/' . $driver->passport) }}"
                                                            type="application/pdf" class="document-viewer"
                                                            alt="document"></iframe>
                                                    @else
                                                        <div class="image-container">
                                                            <img src="{{ asset('public/' . $driver->passport) }}"
                                                                class="image-viewer" alt="image" />
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @else
                                            <div class="header">
                                                <h5 class="header-title">No Documents Found</h5>
                                            </div>
                                        @endif
                                    </div>
                                </template>

                                <!-- Driving License Tab -->
                                <template x-if="tab === 'drivingLicense'">
                                    <div class="active">
                                        @if (!empty($driver->driving_license))
                                            <div class="header">
                                                <h5 class="header-title">Driving License</h5>
                                                <a href="{{ asset('public/' . $driver->driving_license) }}" download
                                                    class="btn btn-primary download-btn">Download</a>
                                            </div>

                                            <div class="swiper-wrapper">
                                                <div class="swiper-slide">
                                                    @php
                                                        $extension = pathinfo(
                                                            $driver->driving_license,
                                                            PATHINFO_EXTENSION,
                                                        );
                                                    @endphp

                                                    @if ($extension == 'pdf')
                                                        <iframe
                                                            src="{{ asset('public/' . $driver->driving_license) }}"
                                                            type="application/pdf" class="document-viewer"
                                                            alt="document"></iframe>
                                                    @else
                                                        <div class="image-container">
                                                            <img src="{{ asset('public/' . $driver->driving_license) }}"
                                                                class="image-viewer" alt="image" />
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @else
                                            <div class="header">
                                                <h5 class="header-title">No Documents Found</h5>
                                            </div>
                                        @endif
                                    </div>
                                </template>

                                <!-- Truck Document Tab -->
                                <template x-if="tab === 'truckDocument'">
                                    <div class="active">
                                        @if (!empty($driver->truck_document))
                                            <div class="header">
                                                <h5 class="header-title">Truck Document</h5>
                                                <a href="{{ asset('public/' . $driver->truck_document) }}" download
                                                    class="btn btn-primary download-btn">Download</a>
                                            </div>

                                            <div class="swiper-wrapper">
                                                <div class="swiper-slide">
                                                    @php
                                                        $extension = pathinfo(
                                                            $driver->truck_document,
                                                            PATHINFO_EXTENSION,
                                                        );
                                                    @endphp

                                                    @if ($extension == 'pdf')
                                                        <iframe src="{{ asset('public/' . $driver->truck_document) }}"
                                                            type="application/pdf" class="document-viewer"
                                                            alt="document"></iframe>
                                                    @else
                                                        <div class="image-container">
                                                            <img src="{{ asset('public/' . $driver->truck_document) }}"
                                                                class="image-viewer" alt="image" />
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @else
                                            <div class="header">
                                                <h5 class="header-title">No Documents Found</h5>
                                            </div>
                                        @endif
                                    </div>
                                </template>

                            </div>
                        </div>
                        {{-- <div class="flex justify-end items-center mt-8">
                        <button type="button" class="btn btn-outline-danger" @click="toggle">Discard</button>
                        <button type="button" class="btn btn-primary ltr:ml-4 rtl:mr-4" @click="toggle">Save</button>
                    </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
    </script>
