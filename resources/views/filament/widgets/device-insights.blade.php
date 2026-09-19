<x-filament-widgets::widget wire:poll.30s class="fm-insights-widget">
    <div class="fm-insights">
        <section class="fm-card" aria-labelledby="fm-status-title">
            <div class="fm-card-heading">
                <div>
                    <p class="fm-eyebrow">YOUR FLEET AT A GLANCE</p>
                    <h2 id="fm-status-title">Device status</h2>
                </div>
                <span class="fm-icon-tile fm-icon-blue"><x-filament::icon icon="heroicon-o-chart-pie" /></span>
            </div>
            <div class="fm-status-chart">
                <div class="fm-donut" role="img" aria-label="{{ $active }} active and {{ $inactive }} inactive devices">
                    <svg viewBox="0 0 160 160" aria-hidden="true">
                        <circle class="fm-donut-track" cx="80" cy="80" r="65" />
                        <circle class="fm-donut-value" cx="80" cy="80" r="65" pathLength="100" stroke-dasharray="{{ $activePercentage }} 100" transform="rotate(-90 80 80)" />
                    </svg>
                    <div class="fm-donut-label"><strong>{{ number_format($total) }}</strong><span>Total devices</span></div>
                </div>
                <dl class="fm-legend">
                    <div><dt><span class="fm-dot fm-dot-blue"></span>Active</dt><dd>{{ number_format($active) }}</dd></div>
                    <div><dt><span class="fm-dot fm-dot-purple"></span>Inactive</dt><dd>{{ number_format($inactive) }}</dd></div>
                    <div class="fm-active-rate"><dt>Active share</dt><dd>{{ $activePercentage }}%</dd></div>
                </dl>
            </div>
            <p class="fm-card-note">{{ $total > 0 ? 'Current device status across your fleet.' : 'Add your first device to see fleet insights.' }}</p>
        </section>

        <section class="fm-card" aria-labelledby="fm-category-title">
            <div class="fm-card-heading">
                <div>
                    <p class="fm-eyebrow">DEVICE DISTRIBUTION</p>
                    <h2 id="fm-category-title">Devices by category</h2>
                </div>
                <span class="fm-icon-tile fm-icon-purple"><x-filament::icon icon="heroicon-o-chart-bar" /></span>
            </div>
            <div class="fm-bars">
                @forelse ($categories as $category)
                    <div class="fm-bar-row">
                        <div class="fm-bar-label"><span>{{ $category['name'] }}</span><strong>{{ number_format($category['count']) }}</strong></div>
                        <div class="fm-bar-track" aria-hidden="true"><div class="fm-bar-fill" style="width: {{ round($category['count'] / $maximum * 100, 2) }}%"></div></div>
                    </div>
                @empty
                    <div class="fm-empty"><x-filament::icon icon="heroicon-o-chart-bar" /><p>No categories yet</p><span>Your device distribution will appear here.</span></div>
                @endforelse
            </div>
            <p class="fm-card-note">Device counts for each category, including uncategorized devices.</p>
        </section>
    </div>
</x-filament-widgets::widget>
