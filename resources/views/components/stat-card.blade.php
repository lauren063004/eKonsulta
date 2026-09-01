<div class="stat-card">

    <div class="stat-icon {{ $color ?? '' }}">
        {{ $icon }}
    </div>

    <div class="stat-information">

        <span class="stat-label">
            {{ $label }}
        </span>

        <strong class="stat-value">
            {{ $value }}
        </strong>

        @if(isset($description))
            <small>
                {{ $description }}
            </small>
        @endif

    </div>

</div>