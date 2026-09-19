<style>
    :root {
        --fm-blue: #208CCC;
        --fm-surface: #fff;
        --fm-text: #172d43;
        --fm-muted: #62758a;
        --fm-border: #e4edf4;
        --fm-track: #edf2f7;
    }
    .dark {
        --fm-surface: #172538;
        --fm-text: #e7eff8;
        --fm-muted: #a6b6c9;
        --fm-border: #2c3d53;
        --fm-track: #25364b;
    }
    body.fi-body { background: #f3f7fb; }
    .dark body.fi-body { background: #101b2b; }
    .fi-main { max-width: 1600px; }
    .fi-topbar { border-bottom: 1px solid var(--fm-border); box-shadow: none; }
    .fi-sidebar { border-inline-end: 1px solid var(--fm-border); }
    .fi-sidebar-header, .fi-sidebar-nav { background: var(--fm-surface); }
    .fi-sidebar-item-btn { border-radius: 12px; transition: background-color .15s; }
    .fi-sidebar-item.fi-active > .fi-sidebar-item-btn { background: #e7f3fb; box-shadow: inset 3px 0 var(--fm-blue); }
    .dark .fi-sidebar-item.fi-active > .fi-sidebar-item-btn { background: #1c3d57; }
    .fi-sidebar-item.fi-active > .fi-sidebar-item-btn .fi-sidebar-item-label { color: #1476b0; font-weight: 700; }
    .dark .fi-sidebar-item.fi-active > .fi-sidebar-item-btn .fi-sidebar-item-label { color: #7dcbf5; }
    .fi-header-heading { color: var(--fm-text); letter-spacing: -.035em; }
    .fi-section, .fi-ta-ctn, .fi-wi-stats-overview-stat {
        border: 1px solid var(--fm-border);
        border-radius: 18px;
        box-shadow: 0 4px 20px rgb(24 62 94 / 3%);
    }
    .fi-section:not(.fi-section-not-contained), .fi-ta-ctn { background: var(--fm-surface); }
    .fi-ta-header-heading, .fi-section-header-heading { color: var(--fm-text); }
    .fi-ta-header, .fi-ta-header-toolbar { padding-block: 20px; }
    .fi-ta-table thead { background: #f5f9fc; }
    .dark .fi-ta-table thead { background: #1c2d41; }
    .fi-btn { border-radius: 10px; }
    .fi-input-wrp { border-radius: 10px; }
    .fm-brand { display: flex; align-items: center; gap: 10px; color: var(--fm-text); text-align: start; }
    .fm-brand-icon { display: grid; place-items: center; width: 38px; height: 38px; border-radius: 12px; color: white; background: var(--fm-blue); box-shadow: 0 4px 10px #208ccc25; }
    .fm-brand-icon svg { width: 23px; height: 23px; }
    .fm-brand strong { display: block; font-size: 16px; font-weight: 750; letter-spacing: -.025em; }
    .fm-brand small { display: block; font-size: 8px; letter-spacing: .15em; color: var(--fm-muted); margin-top: 2px; }
    .fm-hero { margin-top: 24px; position: relative; display: flex; align-items: center; justify-content: space-between; gap: 24px; overflow: hidden; border: 1px solid #208ccc26; border-radius: 22px; padding: 30px 34px; background: linear-gradient(115deg, #e4f3fc, #edf4ff 65%, #f1ecff); }
    .fm-eyebrow { color: #1774a9; font-size: 10px; font-weight: 750; letter-spacing: .14em; margin-bottom: 8px; }
    .fm-hero h2 { font-size: clamp(24px, 2.4vw, 32px); font-weight: 750; line-height: 1.2; letter-spacing: -.035em; color: #163c59; }
    .fm-hero p:last-child { margin-top: 10px; color: #4d6c84; font-size: 13px; line-height: 1.7; }
    .fm-hero-art { position: relative; flex: 0 0 110px; height: 110px; display: grid; place-items: center; }
    .fm-hero-art > svg { width: 57px; height: 57px; color: var(--fm-blue); transform: rotate(-8deg); }
    .fm-hero-orbit { position: absolute; inset: 0; background: #ffffff85; border: 1px solid #ffffff; border-radius: 30px; transform: rotate(-8deg); box-shadow: 0 12px 25px #208ccc12; }
    .fm-hero-check { position: absolute; bottom: 0; right: -5px; padding: 7px; border-radius: 50%; background: #0d9d87; border: 4px solid #eef3ff; color: white; }
    .fm-hero-check svg { width: 20px; height: 20px; }
    .dark .fm-hero { background: linear-gradient(115deg, #16374e, #202d4a 65%, #302d4a); border-color: #2c4965; }
    .dark .fm-hero h2 { color: #e0f3ff; }
    .dark .fm-hero p:last-child { color: #b8cee0; }
    .dark .fm-eyebrow { color: #83c9f2; }
    .dark .fm-hero-orbit { background: #ffffff09; border-color: #ffffff20; }
    .dark .fm-hero-check { border-color: #283149; }
    .fi-wi-stats-overview .fi-section { border: 0; border-radius: 0; box-shadow: none; background: transparent; }
    .fi-wi-stats-overview-stat { position: relative; overflow: hidden; padding: 25px; border: 1px solid #d3eafa; background: linear-gradient(120deg, #eff8fe, #fff); }
    .fi-wi-stats-overview-stat::after { content: ''; position: absolute; width: 85px; height: 85px; right: -25px; top: -25px; border-radius: 50%; background: #208ccc0d; pointer-events: none; }
    .fi-wi-stats-overview-stat-value { color: #1476b0; font-size: 36px; font-weight: 750; letter-spacing: -.045em; }
    .fi-wi-stats-overview-stat-label { color: #405d75; font-size: 13px; font-weight: 600; }
    .fi-wi-stats-overview-stat:has(.fi-color-warning) { background: linear-gradient(120deg, #fff7e8, #fff); border-color: #f5e7c9; }
    .fi-wi-stats-overview-stat:has(.fi-color-warning) .fi-wi-stats-overview-stat-value { color: #aa6910; }
    .fi-wi-stats-overview-stat:has(.fi-color-danger) { background: linear-gradient(120deg, #fff0f4, #fff); border-color: #f5dce5; }
    .fi-wi-stats-overview-stat:has(.fi-color-danger) .fi-wi-stats-overview-stat-value { color: #c1476b; }
    .fi-wi-stats-overview-stat:has(.fi-color-success) { background: linear-gradient(120deg, #eaf9f4, #fff); border-color: #cdece1; }
    .fi-wi-stats-overview-stat:has(.fi-color-success) .fi-wi-stats-overview-stat-value { color: #138368; }
    .dark .fi-wi-stats-overview-stat, .dark .fi-wi-stats-overview .fi-sc-component .fi-wi-stats-overview-stat { background: var(--fm-surface); border-color: var(--fm-border); }
    .dark .fi-wi-stats-overview-stat-label { color: #b7c9da; }
    .dark .fi-wi-stats-overview-stat-value { color: #74c6f3; }
    .dark .fi-wi-stats-overview-stat:has(.fi-color-warning) .fi-wi-stats-overview-stat-value { color: #f3c375; }
    .dark .fi-wi-stats-overview-stat:has(.fi-color-danger) .fi-wi-stats-overview-stat-value { color: #f499b2; }
    .dark .fi-wi-stats-overview-stat:has(.fi-color-success) .fi-wi-stats-overview-stat-value { color: #69d9b7; }
    .fm-insights { display: grid; grid-template-columns: 1fr 1.15fr; gap: 24px; }
    .fm-card { min-width: 0; padding: 25px; background: var(--fm-surface); border: 1px solid var(--fm-border); border-radius: 18px; box-shadow: 0 4px 20px rgb(24 62 94 / 3%); }
    .fm-card-heading { display: flex; justify-content: space-between; align-items: center; gap: 14px; margin-bottom: 22px; }
    .fm-card-heading h2 { color: var(--fm-text); font-size: 17px; font-weight: 700; letter-spacing: -.02em; }
    .fm-card-heading .fm-eyebrow { margin-bottom: 5px; font-size: 9px; }
    .fm-icon-tile { display: grid; place-items: center; width: 39px; height: 39px; flex-shrink: 0; border-radius: 12px; }
    .fm-icon-tile svg { width: 21px; height: 21px; }
    .fm-icon-blue { background: #208ccc15; color: #208ccc; }
    .fm-icon-purple { background: #8974df15; color: #8974df; }
    .fm-status-chart { display: flex; align-items: center; gap: 28px; min-height: 186px; }
    .fm-donut { position: relative; width: 180px; flex: 0 0 180px; }
    .fm-donut svg { width: 100%; height: auto; }
    .fm-donut circle { fill: none; stroke-width: 16; }
    .fm-donut-track { stroke: #a99ae7; }
    .fm-donut-value { stroke: var(--fm-blue); }
    .fm-donut-label { position: absolute; inset: 0; display: flex; flex-direction: column; justify-content: center; align-items: center; }
    .fm-donut-label strong { color: var(--fm-text); font-size: 34px; font-weight: 750; letter-spacing: -.04em; }
    .fm-donut-label span { color: var(--fm-muted); font-size: 11px; }
    .fm-legend { flex: 1; font-size: 12px; }
    .fm-legend > div { display: flex; justify-content: space-between; align-items: center; gap: 14px; padding-block: 11px; }
    .fm-legend dt { display: flex; align-items: center; gap: 8px; color: var(--fm-muted); }
    .fm-legend dd { color: var(--fm-text); font-weight: 700; font-variant-numeric: tabular-nums; }
    .fm-dot { display: inline-block; width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
    .fm-dot-blue { background: var(--fm-blue); }
    .fm-dot-purple { background: #a99ae7; }
    .fm-legend .fm-active-rate { margin-top: 6px; border-top: 1px solid var(--fm-border); }
    .fm-card-note { margin-top: 20px; color: var(--fm-muted); font-size: 11px; line-height: 1.6; }
    .fm-bars { min-height: 186px; max-height: 260px; overflow-y: auto; padding-inline-end: 5px; scrollbar-width: thin; }
    .fm-bar-row + .fm-bar-row { margin-top: 18px; }
    .fm-bar-label { display: flex; justify-content: space-between; gap: 15px; color: var(--fm-muted); font-size: 12px; margin-bottom: 9px; }
    .fm-bar-label span { overflow-wrap: anywhere; }
    .fm-bar-label strong { color: var(--fm-text); font-variant-numeric: tabular-nums; }
    .fm-bar-track { background: var(--fm-track); height: 9px; border-radius: 5px; overflow: hidden; }
    .fm-bar-fill { height: 100%; background: var(--fm-blue); border-radius: inherit; }
    .fm-bar-row:nth-child(4n + 2) .fm-bar-fill { background: #8c78dc; }
    .fm-bar-row:nth-child(4n + 3) .fm-bar-fill { background: #25b29e; }
    .fm-bar-row:nth-child(4n + 4) .fm-bar-fill { background: #eba950; }
    .fm-empty { min-height: 180px; display: flex; flex-direction: column; justify-content: center; align-items: center; color: var(--fm-muted); gap: 8px; text-align: center; }
    .fm-empty svg { width: 30px; height: 30px; color: var(--fm-blue); }
    .fm-empty p { color: var(--fm-text); font-weight: 600; }
    .fm-empty span { font-size: 12px; }
    @media (max-width: 1100px) {
        .fm-status-chart { gap: 16px; }
        .fm-donut { width: 145px; flex-basis: 145px; }
    }
    @media (max-width: 767px) {
        .fm-insights { grid-template-columns: 1fr; gap: 18px; }
        .fm-hero { padding: 24px; }
        .fm-hero-art { display: none; }
        .fm-card { padding: 22px; }
        .fm-status-chart { justify-content: space-around; }
        .fm-legend { max-width: 180px; }
    }
    @media (prefers-reduced-motion: reduce) {
        .fi-sidebar-item-btn { transition: none; }
    }
</style>
