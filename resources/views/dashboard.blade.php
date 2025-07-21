<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                {{-- Introduction Crystal --}}
                <div class="max-w-4xl mx-auto px-4 py-8 text-gray-800">
                    <h1 class="text-3xl font-bold mb-4">📦 Welcome Buddy</h1>
                    <p class="mb-6">
                        Fix Asset များထိန်းသိမ်းနိုင်ရန် ရည်ရွယ်၍ <span
                            class="font-semibold text-blue-600">Crystal</span> ကို ဖန်တီးထားခြင်းဖြစ်သည်။
                    </p>

                    <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                        <h2 class="text-2xl font-semibold text-blue-700 mb-4">Fix Asset Code ဖန်တီးခြင်းအဆင့်များ
                        </h2>

                        <ol class="list-decimal list-inside space-y-3 text-gray-700">
                            <li>
                                <span class="font-semibold text-gray-800">Fix Asset တစ်ခုအတွက် Assembly Code တစ်ခုသည်
                                    မရှိမဖြစ်အရေးကြီးသည်။</span>
                                <p class="ml-6 text-sm text-gray-600">
                                    Assembly Code သည် ပစ္စည်းထည့်ရန်နေရာသတ်မှတ်ခြင်းနှင့် တူသည်။ ထည့်ရမည့်နေရာမရှိပါက
                                    ပစ္စည်းလည်း ရှိမည်မဟုတ်ပါ။
                                </p>
                            </li>

                            <li>
                                <span class="font-semibold text-gray-800">ထို့ကြောင့် ပစ္စည်းတစ်ခု ထားချင်လျှင် Assembly
                                    တစ်ခု တည်ဆောက်ရန် လိုအပ်သည်။</span>
                            </li>

                            <li>
                                <span class="font-semibold text-gray-800">Assembly တစ်ခုတည်ဆောက်ပြီးလျှင် -</span>
                                <ul class="list-disc list-inside ml-6 text-sm text-gray-600 space-y-2">
                                    <li>ထို Assembly ကို မည်သည့် <span class="font-medium text-gray-800">နေရာ
                                            (Location)</span> တွင် ထားမည်ကို သတ်မှတ်ရန်</li>
                                    <li>ဘယ်သူ <span class="font-medium text-gray-800">တာဝန်ယူမည်</span> ကို သတ်မှတ်ရန်
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <span class="font-semibold text-gray-800">Assembly ထဲတွင် Product တစ်ခုစီ တည်ဆောက်၍
                                    ထည့်ထားနိုင်သည်။</span>
                            </li>
                        </ol>
                    </div>
                </div>
                {{-- Product Intro --}}
                <div class="max-w-4xl mx-auto px-4 py-8 text-gray-800">
                    <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                        <h2 class="text-2xl font-semibold text-blue-700 mb-4">Assembly Product
                        </h2>

                        <ol class="list-decimal list-inside space-y-3 text-gray-700">
                            <li>
                                <span class="font-semibold text-gray-800">ဝန်းထမ်းတစ်ယောက်ချင်းစီ သို့ ကုမ္ပဏီရှိ
                                    ပိုင်ဆိုင်မှု ပစ္စည်းများကို Product တစ်ခုအဖြစ် သတ်မှတ်သည်။</span>
                                <p class="ml-6 text-sm text-gray-600">
                                    Product များကို သတ်ဆိုင်ရာ Assembly အလိုက် ထည့်သွင်းပါ။
                                </p>
                            </li>

                            <li>
                                <span class="font-semibold text-gray-800">Product တွင် အာမခံ(Warranty) ရှိပါက
                                    ထည့်သွင်းပါ။</span>
                            </li>
                            <li>
                                <span class="font-semibold text-gray-800">Product တွင် အာမခံ(Warranty) ရှိပါက
                                    ထည့်သွင်းထားပါက Voucher ကိုပါ ဓာတ်ပုံထည့်သွင်းထားရန်လိုအပ်သည်။</span>
                            </li>

                            <li>
                                <span class="font-semibold text-gray-800">Product များဟာ ရွေ့လျားခြင်း များပြားနိုင်ပါက
                                    -</span>
                                <ul class="list-disc list-inside ml-6 text-sm text-gray-600 space-y-2">
                                    <li>ထို Assembly ကို မည်သည့် <span class="font-medium text-gray-800">Assembly</span>
                                        တစ်ခုသီးသန့်ခွဲထားပါ။</li>
                                    <li>ဆိုလိုသည်မှာ Printer တစ်ခုသည် အမြဲတစေ လွှဲပြောင်းမှုဖြစ်ပေါ်နေပါက <span
                                            class="font-medium text-gray-800">Assembly Code တစ်ခု ဆောက်၍ Printer ကို
                                            ထည့်သွင်းထားပါ။</span> <i>အခြားပစ္စည်းများနှင့် ရောထားခြင်း
                                            ရှောင်ရှားပါ။</i>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <span class="font-semibold text-gray-800">သို့ဆိုလျှင် ရွှေ့လွယ်ပြောင်းလွယ်
                                    တာဝန်လွှဲနိုင်သော Assembly တစ်ခုအဖြစ် ရှိနေမည်ဖြစ်သည်။</span>
                            </li>
                            <li>
                                <span class="font-semibold text-gray-800">Product (ပစ္စည်း) နှင့်ပတ်သက်၍ တည်ရှိနေပုံ၊
                                    ထူးခြားချက်များကို မှတ်ချက်တွင် အပြည့်အစုံ ရေးသားထားရန် အရေးကြီးသည်။</span>
                                <ul class="list-disc list-inside ml-6 text-sm text-gray-600 space-y-2">
                                    <li>ဥပမာ - UPS တစ်ခုသည် Battery လဲလိုက်သည်ဆိုပါက - ဘယ်နေ့၊ ဘယ်ရက်၊ ဘာကြောင့်၊
                                        ဘာတံဆိပ် Battery လဲလိုက်ရပါသည်ဆိုတာ ထည့်ထားသင့်သည်။</li>
                                    <li>အကြောင်းမှာ နောက်ဆက်တွဲ ကိုင်တွယ်သူသည် မှတ်တမ်းကို ကြည့်ရုံမျှဖြင့် အလွယ်တကူ
                                        နားလည်နိုင်သည်။</li>
                                    <li>မိမိရေးထားသော အချက်အလက်များကို ခိုင်လုံစေချင်ပါက မှတ်တမ်းဓာတ်ပုံကိုပင်
                                        ထည့်ပေးခဲ့ပါ။ သို့မှသာ မိမိရေးသားထားသော Remark သည် မှန်ကန်တိကျခြင်းရှိပါမည်။
                                    </li>
                                </ul>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
