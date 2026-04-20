<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-row-reverse justify-between h-16">

            <div class="flex justify-between w-full">
                <div class="flex items-center space-x-6 space-x-reverse">
                    <div class="shrink-0 flex items-center">
                        <a href="{{ route('dashboard') }}">
                            <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                        </a>
                    </div>

                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                      <!--  @canany(['admin','sci','access-media']) -->

                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('لوحة التحكم') }}
                        </x-nav-link>

                        <!--<x-nav-link :href="route('supplies.create')" :active="request()->routeIs('supplies.create')">
                        {{ __('تسجيل توريد') }}
                    </x-nav-link>

                    <x-nav-link :href="route('disbursements.create')" :active="request()->routeIs('disbursements.create')">
                        {{ __('سنـد صـرف') }}
                    </x-nav-link>-->

                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            @can('admin')
                            <div class="ms-3 relative">
                                <x-dropdown align="left" width="48">
                                    <x-slot name="trigger">
                                        <button
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                            <div>الجانب المالي</div>
                                            <div class="ms-1">
                                                <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </button>
                                    </x-slot>

                                    <x-slot name="content">
                                        <x-dropdown-link :href="route('supplies.create')"
                                            :active="request()->routeIs('supplies.create')"> {{ __('تسجيل توريد') }}
                                        </x-dropdown-link>
                                        <x-dropdown-link :href="route('disbursements.create')"
                                            :active="request()->routeIs('disbursements.create')"> {{ __('سند الصرف') }}
                                        </x-dropdown-link>
                                        <x-dropdown-link href="{{ route('reports.supplyTable') }}">
                                            {{ __('كشف توريد التبرعات') }} </x-dropdown-link>
                                    </x-slot>
                                </x-dropdown>
                            </div>
                            @endcan
                            <div class="hidden sm:flex sm:items-center sm:ms-6">
                                <!-- @canany(['admin','sci'])-->

                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        <button
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                            <div class="font-bold">{{ __('الرقابة والتقارير') }}</div>

                                            <div class="mr-1">
                                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </button>
                                    </x-slot>

                                    <x-slot name="content">
                                        @can('admin')
                                        <x-dropdown-link :href="route('supplies.pending')" class="text-right">
                                            {{ __('⏳ الاعتمادات المعلقة') }}
                                        </x-dropdown-link>

                                        <x-dropdown-link :href="route('supplies.rejected')" class="text-right">
                                            {{ __('❌ الاعتمادات المرفوضة') }}
                                        </x-dropdown-link>
                                        @endcan

                                        <div class="border-t border-gray-100"></div>


                                        <x-dropdown-link :href="route('reports.index')" class="text-right">
                                            {{ __('📋 سجل التقارير') }}
                                        </x-dropdown-link>
                                      <!--  @endcanany -->


                                        @can('admin')
                                        <x-dropdown-link :href="route('reports.supplies')" class="text-right">
                                            {{ __('📋 سجل المشاريع كاملة') }}
                                        </x-dropdown-link>
                                        @endcan


                                    </x-slot>
                                </x-dropdown>
                                <!-- @endcanany -->
                            </div>


                            @can('admin')
                            <x-nav-link href="{{ route('reports.supplyTable') }}">
                                {{ __('كشف توريد التبرعات') }}
                            </x-nav-link>

                            @endcan

                            @can('access-media')
                            <x-nav-link :href="route('media.index')" :active="request()->routeIs('media.index')">
                                <span class="ml-2">📢</span>
                                {{ __('السجل الإعلامي') }}
                            </x-nav-link>
                            @endcan








                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-6 space-x-reverse">


                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        @can('admin')

                        <div class="ms-3 relative">
                            
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                        <div>ادارة البيانات</div>
                                        <div class="ms-1">
                                            <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <x-dropdown-link :href="route('donors.index')"> {{ __('المتبرعون') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('currencies.index')"> {{ __('العملات') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('projects.index')"> {{ __('المشاريع') }}
                                    </x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>
                        <div class="hidden sm:flex sm:items-center sm:mr-4">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                        <div class="font-bold">{{ __('الإدارة والتحكم') }}</div>
                                        <div class="mr-1">
                                            <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <x-dropdown-link :href="route('departments.index')" class="text-right">
                                        {{ __('🏢 هيكل الإدارات') }}
                                    </x-dropdown-link>

                                    <x-dropdown-link :href="route('users.index')" class="text-right">
                                        {{ __('👥 سجل المستخدمين') }}
                                    </x-dropdown-link>

                                    <div class="border-t border-gray-100"></div>

                                    <!--<x-dropdown-link :href="route('profile.edit')" class="text-right text-xs text-gray-400">
                                  {{ __('⚙️ إعدادات الأمان والصلاحيات') }}
                                  </x-dropdown-link>-->
                                </x-slot>
                            </x-dropdown>

                        </div>
                        @endcan

                        <div class="ms-3 relative">
                            <x-dropdown align="left" width="48">
                                <x-slot name="trigger">
                                    <button
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                        <div>{{ Auth::user()->name }}</div>
                                        <div class="ms-1">
                                            <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <x-dropdown-link :href="route('profile.edit')">
                                        {{ __('الملف الشخصي') }}
                                    </x-dropdown-link>

                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault(); this.closest('form').submit();">
                                            {{ __('تسجيل الخروج') }}
                                        </x-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    </div>
                </div>

               
                <div class="-me-2 flex items-center sm:hidden">
                    <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
            <!-- روابط الجوال -->
<div class="pt-2 pb-3 space-y-1 text-right">

    <!-- لوحة التحكم -->
    <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
        لوحة التحكم
    </x-responsive-nav-link>

    <!-- الجانب المالي -->
    @can('admin')
    <div class="border-t my-2"></div>

    <div class="px-4 text-xs text-gray-400 font-bold">الجانب المالي</div>

    <x-responsive-nav-link :href="route('supplies.create')" :active="request()->routeIs('supplies.create')">
        تسجيل توريد
    </x-responsive-nav-link>

    <x-responsive-nav-link :href="route('disbursements.create')" :active="request()->routeIs('disbursements.create')">
        سند الصرف
    </x-responsive-nav-link>

    <x-responsive-nav-link :href="route('reports.supplyTable')">
        كشف توريد التبرعات
    </x-responsive-nav-link>
    @endcan

    <!-- الرقابة والتقارير -->
   <!-- @canany(['admin','sci']) -->
    <div class="border-t my-2"></div>

    <div class="px-4 text-xs text-gray-400 font-bold">الرقابة والتقارير</div>

    @can('admin')
    <x-responsive-nav-link :href="route('supplies.pending')">
        ⏳ الاعتمادات المعلقة
    </x-responsive-nav-link>

    <x-responsive-nav-link :href="route('supplies.rejected')">
        ❌ الاعتمادات المرفوضة
    </x-responsive-nav-link>
    @endcan

    <x-responsive-nav-link :href="route('reports.index')">
        📋 سجل التقارير
    </x-responsive-nav-link>

    @can('admin')
    <x-responsive-nav-link :href="route('reports.supplies')">
        📊 سجل المشاريع كاملة
    </x-responsive-nav-link>
    @endcan
    <!-- @endcanany  ->

    <!-- السجل الإعلامي -->
    @can('access-media')
    <div class="border-t my-2"></div>

    <x-responsive-nav-link :href="route('media.index')" :active="request()->routeIs('media.index')">
        📢 السجل الإعلامي
    </x-responsive-nav-link>
    @endcan

    <!-- إدارة البيانات -->
    @can('admin')
    <div class="border-t my-2"></div>

    <div class="px-4 text-xs text-gray-400 font-bold">إدارة البيانات</div>

    <x-responsive-nav-link :href="route('donors.index')">
        المتبرعون
    </x-responsive-nav-link>

    <x-responsive-nav-link :href="route('currencies.index')">
        العملات
    </x-responsive-nav-link>

    <x-responsive-nav-link :href="route('projects.index')">
        المشاريع
    </x-responsive-nav-link>

    <!-- الإدارة والتحكم -->
    <div class="border-t my-2"></div>

    <div class="px-4 text-xs text-gray-400 font-bold">الإدارة والتحكم</div>

    <x-responsive-nav-link :href="route('departments.index')">
        🏢 هيكل الإدارات
    </x-responsive-nav-link>

    <x-responsive-nav-link :href="route('users.index')">
        👥 المستخدمين
    </x-responsive-nav-link>
    @endcan

</div>

<!-- معلومات المستخدم -->
<div class="pt-4 pb-1 border-t border-gray-200">
    <div class="px-4 text-right">
        <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
    </div>

    <div class="mt-3 space-y-1">
        <x-responsive-nav-link :href="route('profile.edit')">
            الملف الشخصي
        </x-responsive-nav-link>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-responsive-nav-link :href="route('logout')"
                onclick="event.preventDefault(); this.closest('form').submit();">
                تسجيل الخروج
            </x-responsive-nav-link>
        </form>
    </div>
</div>
        </div>
    </div>
</nav>
