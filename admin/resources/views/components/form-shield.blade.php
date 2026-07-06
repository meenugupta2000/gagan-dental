{{-- Anti-spam: honeypot + encrypted render-time. Validated server-side via App\Support\FormShield. --}}
@once
<style>
    .fs-shield { position: absolute !important; left: -9999px !important; top: -9999px !important;
        width: 1px; height: 1px; overflow: hidden; opacity: 0; pointer-events: none; }
</style>
@endonce
<div class="fs-shield" aria-hidden="true">
    <label for="fs-website">Leave this field empty</label>
    <input type="text" id="fs-website" name="{{ \App\Support\FormShield::HONEYPOT }}" tabindex="-1" autocomplete="off" value="">
</div>
<input type="hidden" name="{{ \App\Support\FormShield::TIMESTAMP }}" value="{{ \App\Support\FormShield::token() }}">
