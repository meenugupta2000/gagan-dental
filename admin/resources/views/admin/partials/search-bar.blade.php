{{--
    Reusable admin index search bar.
    Params:
      resetRoute  – route name for the "Reset" link (required)
      placeholder – input placeholder (optional)
      search      – current search term ($search)
      status      – current status filter ($status), optional
      withStatus  – show the Active/Inactive filter (default true)
--}}
@php($hasStatus = ($withStatus ?? true))
<div class="card mb-3">
    <div class="card-body py-3">
        <form method="GET" class="row g-2 align-items-center">
            <div class="col-sm-6 {{ $hasStatus ? 'col-md-5' : 'col-md-8' }}">
                <input type="text" name="q" value="{{ $search ?? '' }}" class="form-control" placeholder="{{ $placeholder ?? 'Search…' }}">
            </div>
            @if ($hasStatus)
            <div class="col-sm-4 col-md-3">
                <select name="status" class="form-select">
                    <option value="">All statuses</option>
                    <option value="active" {{ ($status ?? '') === 'active' ? 'selected' : '' }}>Active only</option>
                    <option value="inactive" {{ ($status ?? '') === 'inactive' ? 'selected' : '' }}>Inactive only</option>
                </select>
            </div>
            @endif
            <div class="col-sm-2 col-md-2 d-flex gap-2">
                <button class="btn btn-light"><i class="bi bi-search"></i></button>
                @if (($search ?? '') !== '' || ($status ?? '') !== '')
                    <a href="{{ route($resetRoute) }}" class="btn btn-light">Reset</a>
                @endif
            </div>
        </form>
    </div>
</div>
