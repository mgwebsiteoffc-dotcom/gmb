@php($faqTitle = $faqTitle ?? 'Frequently Asked Questions')
@php($faqIntro = $faqIntro ?? 'Answers to the questions agencies and multi-location brands ask most.')
@php($faqs = $faqs ?? [])

<section class="py-16 bg-white border-t border-slate-200" id="faq">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <span class="text-xs font-extrabold text-brand-600 uppercase tracking-widest bg-brand-50 px-3 py-1 rounded-full">FAQ</span>
            <h2 class="text-2xl sm:text-3xl font-black font-display text-slate-900 mt-3">{{ $faqTitle }}</h2>
            <p class="text-slate-600 text-sm mt-2">{{ $faqIntro }}</p>
        </div>

        <div class="space-y-3">
            @foreach($faqs as $index => $faq)
                <details class="group bg-slate-50 rounded-2xl border border-slate-200 overflow-hidden {{ $index === 0 ? 'ring-1 ring-brand-200' : '' }}">
                    <summary class="flex items-center justify-between gap-4 px-5 py-4 cursor-pointer font-bold text-slate-800 text-sm sm:text-base hover:bg-brand-50/50 transition-colors">
                        <span>{{ is_array($faq) ? $faq['q'] : $faq }}</span>
                        <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 group-open:rotate-180 transition-transform flex-shrink-0"></i>
                    </summary>
                    <div class="px-5 pb-4 text-slate-600 text-sm leading-relaxed">
                        {{ is_array($faq) ? $faq['a'] : '' }}
                    </div>
                </details>
            @endforeach
        </div>
    </div>
</section>
