<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __('Welcome Buddy') }}
                    <p class="p-2 my-2 text-gray-900 rounded shadow-sm dark:text-gray-100">
                        Fix Asset များထိန်းသိမ်းနိုင်ရန် ရည်ရွယ်၍ crystal ကိုဖန်တီးထားခြင်းဖြစ်သည်။
                    </p>
                    <h2 class="mb-2 text-xl text-gray-500 dark:text-gray-100">Fix asset code များဖန်တီးရာတွင်
                        လုပ်ဆောင်ရမည့်
                        အဆင့်ဆင့်သည် အောက်ပါအတိုင်းဖြစ်သည်။</h2>
                    <ol>
                        <li>Fix Asset တစ်ခုအတွက် Assembly code တစ်ခုသည် မရှိမဖြစ်အရေးကြီးသည်။ </br>
                            <i>Assembly code သည် ပစ္စည်းထည့်ရန် နေရာသတ်မှတ်ခြင်းနှင့်တူသည်။ ထည့်ရမည့်နေရာမရှိပါက
                                ပစ္စည်းလည်း ရှိမည်မဟုတ်ပါ။ ထို့ကြောင့် ပစ္စည်းတစ်ခု ထားချင်လျှင် ထည့်စရာ (assembly)
                                တစ်ခုတည်ဆောက်ပါ။</i>
                        </li>
                        <li>Assembly(ထည့်စရာ ခြင်း) တစ်ခု တည်ဆောက်ပြီးလျှင် ထိုခြင်းတစ်ခုကို မည်သည့်နေရာတွင် ထားမလဲ?
                            ဆိုသော Location တစ်ခုသတ်မှတ်ရမည်။ ဘယ်သူ တာဝန်ယူမလဲ? သတ်မှတ်ပေးရမည်။
                        </li>
                        <li>
                            Assembly ထဲတွင် Product တစ်ခုစီ တည်ဆောက်၍ ထည့်ထားနိုင်သည်။
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
