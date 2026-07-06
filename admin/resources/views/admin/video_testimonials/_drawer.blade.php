<form method="POST" action="{{ $action }}" data-drawer-form>
    @isset($method) @method($method) @endisset
    @include('admin.video_testimonials._form', ['submitLabel' => $submitLabel])
</form>
