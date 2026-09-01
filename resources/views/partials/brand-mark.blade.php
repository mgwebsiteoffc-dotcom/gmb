{{-- Untab brand mark: a browser tab being "pulled out" — many reduce into one —
     with a check badge. Purely decorative; set width/height via the `$class`. --}}
<svg
    viewBox="0 0 32 32"
    fill="none"
    xmlns="http://www.w3.org/2000/svg"
    @isset($class)class="{{ $class }}"@endisset
    @isset($attrs){!! $attrs !!}@endisset
    aria-hidden="true"
>
    {{-- Back tab (indigo, pulled out behind) --}}
    <rect x="4.5" y="5" width="13" height="13" rx="3.5" fill="#1E1B4B"/>
    <path d="M6.5 7h9a2 2 0 0 1 2 2v7" stroke="#A5B4FC" stroke-width="1.4" stroke-linecap="round" fill="none"/>

    {{-- Front tab (lavender/electric, pulled toward you) --}}
    <rect x="9" y="10" width="15" height="15" rx="4" fill="#3D47E0"/>
    <rect x="9" y="10" width="15" height="15" rx="4" stroke="#38BDF8" stroke-width="1.6" fill="none"/>

    {{-- Check badge --}}
    <circle cx="24.5" cy="24.5" r="5.5" fill="#38BDF8"/>
    <circle cx="24.5" cy="24.5" r="5.5" stroke="#0F172A" stroke-width="1.4" fill="none"/>
    <path d="M21.8 24.6l1.8 1.9 3.2-3.5" stroke="#0F172A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
</svg>
