<?php declare(strict_types = 1);

$css = <<<'CSS'
.laka-sw{--green:#2ecc71;--red:#ef5350;--gray:#64748b;--blue:#42a5f5;--amber:#ffb020;color:#dce6f1;background:linear-gradient(180deg,#343f4b,#1c242d);border:1px solid #111820;border-radius:9px;padding:12px;box-shadow:inset 0 1px rgba(255,255,255,.12),0 5px 14px rgba(0,0,0,.25)}
.laka-sw-head{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:10px}.laka-sw-title{font-weight:700;letter-spacing:.03em;white-space:nowrap}.laka-device-summary{display:flex;align-items:center;justify-content:center;flex:1;flex-wrap:wrap;gap:4px 12px;font-size:10px;color:#c4d0dc}.laka-summary-item{display:inline-flex;align-items:center;gap:4px;white-space:nowrap}.laka-summary-label{color:#8fa1b3}.laka-summary-value{font-weight:700;color:#e4edf5}.laka-summary-value.ok{color:var(--green)}.laka-summary-value.warn{color:var(--amber)}.laka-summary-value.high{color:var(--red)}.laka-sw-meta{font-size:11px;color:#aebdcd}.laka-sw-badge{display:inline-flex;align-items:center;gap:5px;padding:2px 7px;border-radius:10px;background:#24303b;white-space:nowrap}.laka-sw-dot{width:7px;height:7px;border-radius:50%;background:var(--green);box-shadow:0 0 7px var(--green)}
.laka-status-legend{display:flex;align-items:center;flex-wrap:wrap;gap:6px 14px;margin:-3px 0 9px;padding:5px 8px;border-radius:5px;background:rgba(10,15,20,.38);font-size:10px;color:#c7d2dd}.laka-legend-item{display:inline-flex;align-items:center;gap:5px;white-space:nowrap}.laka-legend-dot{width:8px;height:8px;border-radius:50%;background:var(--blue);box-shadow:0 0 5px currentColor}.laka-legend-item.up .laka-legend-dot{background:var(--green);color:var(--green)}.laka-legend-item.down .laka-legend-dot{background:var(--red);color:var(--red)}.laka-legend-item.disabled .laka-legend-dot{background:var(--gray);color:var(--gray);box-shadow:none}.laka-legend-item.unknown .laka-legend-dot{background:var(--blue);color:var(--blue)}
.laka-toolbar{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:5px;margin:-4px 0 9px}.laka-filters,.laka-alert-summary{display:flex;align-items:center;flex-wrap:wrap;gap:4px}.laka-filter,.laka-summary-filter{border:1px solid #465666;border-radius:10px;padding:2px 8px;background:#17212a;color:#bfcbd6;font-size:9px;line-height:16px;cursor:pointer}.laka-filter:hover,.laka-filter.active,.laka-summary-filter:hover{border-color:#64a7d8;color:#fff;background:#263b4d}.laka-summary-filter.problem{border-color:#b27b26;color:#ffd180}.laka-summary-filter.error{border-color:#a94b49;color:#ffaaa8}.laka-summary-filter.util{border-color:#b87423;color:#ffc46b}.laka-no-match{display:none;padding:12px;text-align:center;color:#9fb0c0}.laka-sw.filter-empty .laka-no-match{display:block}
.laka-sw-member{margin-top:10px}.laka-sw-member-title{margin:0 0 5px;font-size:10px;color:#aebdcd;text-transform:uppercase;letter-spacing:.09em}.laka-sw-grid{display:grid;grid-template-columns:repeat(var(--cols),minmax(42px,1fr));gap:5px}.laka-sw-grid.auto{grid-template-columns:repeat(auto-fit,minmax(54px,1fr))}
.laka-port{position:relative;min-height:46px;padding:4px 4px 8px;color:#dce6f1;text-decoration:none;background:#0e141a;border:1px solid #34404d;border-radius:4px;overflow:visible;cursor:help;transform-origin:center;transition:transform .16s ease,box-shadow .16s ease,border-color .16s ease,background .16s ease}.laka-port:hover,.laka-port.linked-hover{z-index:100;border-color:#90a4b8;background:#131c24;transform:scale(1.18);box-shadow:0 10px 26px rgba(0,0,0,.62)}.laka-port:hover:after,.laka-port.linked-hover:after{content:attr(data-hover-label);position:absolute;z-index:105;left:50%;bottom:calc(100% + 7px);width:max-content;max-width:230px;transform:translateX(-50%);padding:5px 8px;border:1px solid #5f7182;border-radius:4px;background:#101820;color:#f3f7fa;font-size:9px;line-height:1.25;white-space:normal;text-align:center;box-shadow:0 7px 18px rgba(0,0,0,.55);pointer-events:none}.laka-port.uplink{border-color:#718096}.laka-jack{height:23px;border:1px solid #05080b;border-radius:2px;background:linear-gradient(#d8e0e8 0 18%,#090e13 19%);position:relative;overflow:hidden}.laka-port.uplink .laka-jack{background:linear-gradient(#bdc8d3 0 20%,#3f4d5c 21%);border-color:#8291a1}.laka-jack:after{content:"";position:absolute;left:6px;right:6px;bottom:3px;height:4px;background:repeating-linear-gradient(90deg,#b6c0ca 0 2px,transparent 2px 4px)}
.laka-led{position:absolute;right:6px;top:6px;width:8px;height:8px;border-radius:50%;background:var(--blue);box-shadow:0 0 8px var(--blue)}.laka-port.up{border-color:#248f52;background:#0d1915}.laka-port.up .laka-led{background:var(--green);box-shadow:0 0 8px var(--green)}.laka-port.down{border-color:#c94b49;background:#1d1113}.laka-port.down .laka-led{background:var(--red);box-shadow:0 0 9px var(--red)}.laka-port.disabled{border-color:#536171;background:#151a20;color:#8290a0}.laka-port.disabled .laka-jack{filter:brightness(.58) saturate(.4)}.laka-port.disabled .laka-led{background:var(--gray);box-shadow:none}.laka-port.unknown{border-color:#3979a9}.laka-port.has-problem:before{content:"!";position:absolute;z-index:2;left:5px;top:5px;display:flex;align-items:center;justify-content:center;width:11px;height:11px;border-radius:50%;background:var(--amber);color:#111;font-size:8px;font-weight:700;box-shadow:0 0 7px var(--amber)}.laka-port-name{text-align:center;font-size:9px;margin-top:3px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}.laka-util{position:absolute;bottom:0;left:0;height:3px;background:#38bdf8;width:var(--util);max-width:100%}.laka-util.warn{background:var(--amber)}.laka-util.high{background:var(--red)}
.laka-port{cursor:pointer}.laka-port.filtered-out,.laka-interface-row.filtered-out{display:none}.laka-port-alias{height:10px;text-align:center;font-size:8px;line-height:10px;color:#91a5b8;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}.laka-port-util-label{position:absolute;right:3px;bottom:3px;padding:0 2px;border-radius:2px;background:rgba(0,0,0,.72);color:#b9d8ea;font-size:7px;line-height:9px}
.laka-port-data{display:none}.laka-empty{padding:16px;border:1px dashed #64748b;border-radius:6px;color:#b7c4d2;text-align:center}
.laka-port-modal{position:fixed;z-index:1000000;inset:0;display:flex;align-items:center;justify-content:center;padding:12px;background:rgba(0,0,0,.64)}.laka-modal-box{width:min(920px,96vw);max-height:92vh;overflow:auto;background:#202529;border:1px solid #5b6875;border-radius:8px;box-shadow:0 18px 60px rgba(0,0,0,.7);color:#e4e8ec}.laka-modal-head{position:sticky;top:0;z-index:2;display:flex;align-items:flex-start;justify-content:space-between;gap:10px;padding:8px 12px;background:#292f34;border-bottom:1px solid #4a545e}.laka-modal-title{font-size:15px;font-weight:700;line-height:1.15;color:#fff}.laka-modal-subtitle{margin-top:2px;color:#90caf9;font-size:11px;line-height:1.15}.laka-modal-close{border:0;background:transparent;color:#c9d1d9;font-size:22px;line-height:1;cursor:pointer}.laka-modal-close:hover{color:#fff}.laka-detail-table{width:100%;border-collapse:collapse}.laka-detail-table th{padding:5px 10px;text-align:left;color:#9eb0c1;background:#252b30;border-bottom:1px solid #46505a;font-size:10px;line-height:1.15}.laka-detail-table td{padding:5px 10px;border-bottom:1px solid #3c444c;font-size:11px;line-height:1.15}.laka-detail-table tr:hover td{background:#2a3137}.laka-detail-table td:nth-child(2),.laka-detail-table td:nth-child(3),.laka-detail-table td:nth-child(4){white-space:nowrap}.laka-modal-problems{margin:8px 10px;padding:7px;border:1px solid #8b3e3e;border-radius:5px;background:#462525;color:#ffb4ab}
.laka-chart{margin:8px 10px 10px;padding:8px;border:1px solid #46515c;border-radius:6px;background:#181d21}.laka-chart-title{display:flex;justify-content:space-between;gap:10px;margin-bottom:5px;font-weight:700}.laka-chart-period{font-weight:400;color:#9eabb7}.laka-chart-stage{min-height:235px;position:relative;display:flex;align-items:center;justify-content:center;overflow:auto}.laka-chart-stage img{display:block;max-width:100%;height:auto}.laka-chart-loading,.laka-chart-empty{display:flex;min-height:220px;align-items:center;justify-content:center;color:#9eabb7}
.laka-chart-title{align-items:center}.laka-chart-periods{display:flex;gap:3px}.laka-period-button{border:1px solid #465666;border-radius:3px;padding:1px 6px;background:#202a32;color:#9eabb7;font-size:9px;cursor:pointer}.laka-period-button.active,.laka-period-button:hover{border-color:#64a7d8;color:#fff;background:#2b4355}
.laka-interface-panel{margin-top:11px;border:1px solid #344352;border-radius:6px;background:rgba(10,15,20,.43);overflow:hidden}.laka-interface-panel.collapsed .laka-interface-body{display:none}.laka-interface-panel.collapsed .laka-interface-panel-head{border-bottom:0}.laka-interface-panel-head{display:flex;align-items:center;justify-content:space-between;gap:10px;padding:6px 9px;background:#27323d;border-bottom:1px solid #3d4b58}.laka-interface-panel-title{font-size:11px;font-weight:700;color:#e4edf5}.laka-interface-head-actions{display:flex;align-items:center;gap:6px}.laka-interface-counts{font-size:8px;color:#8fa1b3;white-space:nowrap}.laka-interface-toggle{min-width:23px;height:20px;padding:0 6px;border:1px solid #526576;border-radius:4px;background:#1a252f;color:#d5e0e9;cursor:pointer}.laka-interface-toggle:hover{border-color:#64a7d8;background:#263b4d}.laka-interface-toggle-icon{display:inline-block;transition:transform .15s ease}.laka-interface-panel.collapsed .laka-interface-toggle-icon{transform:rotate(180deg)}.laka-interface-tools{display:flex;align-items:center;justify-content:space-between;gap:8px;padding:5px 8px;background:#18222b;border-bottom:1px solid #344352}.laka-interface-search{width:min(300px,55%);height:23px;padding:3px 8px;border:1px solid #475968;border-radius:4px;background:#101820;color:#e4edf5;font-size:9px}.laka-interface-search:focus{outline:0;border-color:#64a7d8;box-shadow:0 0 0 1px rgba(100,167,216,.25)}.laka-interface-search-result{font-size:8px;color:#8fa1b3}.laka-interface-scroll{max-height:250px;overflow:auto;scrollbar-color:#526475 #1a222a;scrollbar-width:thin}.laka-interface-table{width:100%;border-collapse:collapse;table-layout:fixed}.laka-interface-table th{position:sticky;top:0;z-index:2;padding:0;background:#1c2630;border-bottom:1px solid #43515f;text-align:left}.laka-sort-button{display:block;width:100%;padding:5px 7px;border:0;background:transparent;color:#91a4b6;font-size:8px;text-align:left;text-transform:uppercase;letter-spacing:.05em;cursor:pointer}.laka-sort-button:hover,.laka-sort-button.active{color:#e5edf4;background:#263542}.laka-sort-indicator{margin-left:3px;color:#64a7d8}.laka-interface-table td{padding:4px 7px;border-bottom:1px solid rgba(78,94,108,.42);font-size:9px;line-height:14px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}.laka-interface-row{cursor:pointer;transition:background .12s ease,box-shadow .12s ease}.laka-interface-row:hover,.laka-interface-row.linked-hover{background:#2a3742;box-shadow:inset 3px 0 #64a7d8}.laka-interface-row.search-hidden{display:none}.laka-interface-row:last-child td{border-bottom:0}.laka-interface-name{width:12%;font-weight:700;color:#e5edf4}.laka-interface-description{width:25%;color:#b8c6d3}.laka-interface-status{width:13%;font-weight:700}.laka-interface-status .laka-row-dot{display:inline-block;width:7px;height:7px;margin-right:5px;border-radius:50%;vertical-align:-1px}.laka-interface-row.up .laka-interface-status{color:var(--green)}.laka-interface-row.up .laka-row-dot{background:var(--green);box-shadow:0 0 5px var(--green)}.laka-interface-row.down .laka-interface-status{color:var(--red)}.laka-interface-row.down .laka-row-dot{background:var(--red);box-shadow:0 0 5px var(--red)}.laka-interface-row.disabled .laka-interface-status{color:#8c9aaa}.laka-interface-row.disabled .laka-row-dot{background:var(--gray)}.laka-interface-row.unknown .laka-interface-status{color:var(--blue)}.laka-interface-row.unknown .laka-row-dot{background:var(--blue);box-shadow:0 0 5px var(--blue)}.laka-interface-speed{width:10%;color:#b9c8d5}.laka-interface-traffic{width:11%;color:#d0dae3}.laka-interface-util{width:10%}.laka-mini-meter{display:inline-block;width:34px;height:4px;margin-right:5px;border-radius:4px;background:#111820;vertical-align:1px;overflow:hidden}.laka-mini-meter>span{display:block;height:100%;width:var(--util);background:#38bdf8}.laka-mini-meter>span.warn{background:var(--amber)}.laka-mini-meter>span.high{background:var(--red)}.laka-interface-errors{width:8%;color:#aebdca}.laka-interface-errors.has-errors{color:#ff8a87;font-weight:700}
.laka-console{display:grid;grid-template-columns:220px minmax(0,1fr);height:auto;min-height:100%;background:#111820;border:1px solid #263440;border-radius:8px;overflow:visible}.laka-device-nav{display:flex;flex-direction:column;min-width:0;background:#18222b;border-right:1px solid #344352}.laka-device-nav-head{padding:9px;border-bottom:1px solid #344352}.laka-device-nav-title{margin-bottom:6px;color:#e4edf5;font-size:11px;font-weight:700}.laka-device-search{width:100%;height:25px;padding:4px 8px;border:1px solid #465968;border-radius:4px;background:#0e151c;color:#e4edf5;font-size:9px}.laka-device-search:focus{outline:0;border-color:#64a7d8}.laka-device-nav-list{flex:1;min-height:0;overflow:auto;scrollbar-color:#526475 #1a222a;scrollbar-width:thin}.laka-device-button{box-sizing:border-box!important;display:block!important;width:100%!important;height:auto!important;min-height:52px!important;margin:0!important;padding:7px 9px!important;border:0!important;border-bottom:1px solid rgba(72,88,102,.45)!important;border-radius:0!important;background:transparent!important;color:#bac7d2!important;line-height:normal!important;text-align:left!important;text-transform:none!important;white-space:normal!important;overflow:hidden!important;appearance:none!important;cursor:pointer}.laka-device-button:hover{background:#22313d!important}.laka-device-button.active{background:#2a3d4c!important;box-shadow:inset 3px 0 #42a5f5!important;color:#fff!important}.laka-device-button.search-hidden{display:none!important}.laka-device-button-top{display:flex;align-items:center;gap:6px;min-height:14px}.laka-device-health{width:8px;height:8px;flex:0 0 auto;border-radius:50%;background:#2ecc71;box-shadow:0 0 6px #2ecc71}.laka-device-button.has-problems .laka-device-health{background:#ffb020;box-shadow:0 0 6px #ffb020}.laka-device-name{display:block;min-width:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-size:10px;font-weight:700;line-height:13px}.laka-device-model{display:block;height:11px;margin:2px 0 0 14px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;color:#8195a7;font-size:8px;line-height:11px}.laka-device-stats{display:flex!important;align-items:center;gap:7px;height:11px;margin:2px 0 0 14px!important;font-size:8px!important;line-height:11px!important;white-space:nowrap}.laka-device-up{color:#45d887}.laka-device-down{color:#ff706d}.laka-device-problem{color:#ffc15d}.laka-console-main{min-width:0;overflow:visible;background:#10171e}.laka-device-pane{display:none}.laka-device-pane.active{display:block}.laka-console-warning{padding:5px 9px;background:#4a3518;color:#ffd180;font-size:9px}.laka-device-empty{padding:24px;color:#9fb0c0;text-align:center}.laka-sw{border:0;border-radius:0;box-shadow:none;min-height:100%}
.laka-interface-scroll{max-height:var(--list-height,548px)}.laka-device-nav-title-row{display:flex;align-items:center;justify-content:space-between;gap:6px;margin-bottom:6px}.laka-device-nav-title-row .laka-device-nav-title{margin:0}.laka-nav-toggle{width:24px;height:20px;padding:0!important;border:1px solid #506373!important;border-radius:4px!important;background:#101820!important;color:#c8d5df!important;font-size:10px!important;cursor:pointer}.laka-nav-filters{display:flex;gap:3px;margin-top:5px}.laka-nav-filter{padding:2px 5px!important;border:1px solid #435564!important;border-radius:8px!important;background:#111a22!important;color:#91a4b6!important;font-size:7px!important;line-height:12px!important;cursor:pointer}.laka-nav-filter.active,.laka-nav-filter:hover{border-color:#64a7d8!important;color:#fff!important;background:#263b4d!important}.laka-console.nav-collapsed{grid-template-columns:44px minmax(0,1fr)}.laka-console.nav-collapsed .laka-device-nav-head{padding:7px 5px}.laka-console.nav-collapsed .laka-device-nav-title,.laka-console.nav-collapsed .laka-device-search,.laka-console.nav-collapsed .laka-nav-filters,.laka-console.nav-collapsed .laka-device-name,.laka-console.nav-collapsed .laka-device-model,.laka-console.nav-collapsed .laka-device-stats{display:none!important}.laka-console.nav-collapsed .laka-device-nav-title-row{justify-content:center;margin:0}.laka-console.nav-collapsed .laka-device-button{min-height:38px!important;padding:10px 17px!important}.laka-console.nav-collapsed .laka-device-health{width:10px;height:10px}.laka-device-button.filter-hidden{display:none!important}.laka-device-button[data-health="unavailable"] .laka-device-health{background:#ef5350;box-shadow:0 0 6px #ef5350}.laka-device-button[data-health="warning"] .laka-device-health{background:#ffb020;box-shadow:0 0 6px #ffb020}.laka-device-button[data-health="unknown"] .laka-device-health{background:#64748b;box-shadow:none}.laka-device-button[data-health="maintenance"] .laka-device-health{background:#42a5f5;box-shadow:0 0 6px #42a5f5}.laka-device-resource{color:#87a1b7}
.laka-featured{margin-top:11px;border:1px solid #344352;border-radius:6px;background:rgba(10,15,20,.43);overflow:hidden}.laka-featured-head{display:flex;align-items:center;justify-content:space-between;gap:10px;padding:7px 9px;background:#27323d;border-bottom:1px solid #3d4b58}.laka-featured-head-actions{display:flex;align-items:center;gap:6px}.laka-featured-title{font-size:11px;font-weight:700;color:#f1f6fa;text-transform:uppercase}.laka-featured-subtitle{margin-top:2px;color:#8fa1b3;font-size:8px}.laka-featured-periods{display:flex;gap:3px}.laka-featured-period,.laka-featured-config-toggle,.laka-featured-clear{padding:2px 7px!important;border:1px solid #465a6b!important;border-radius:4px!important;background:#17222b!important;color:#94a7b8!important;font-size:8px!important;cursor:pointer}.laka-featured-period.active,.laka-featured-period:hover,.laka-featured-config-toggle:hover,.laka-featured-config-toggle.active,.laka-featured-clear:hover{border-color:#38bdf8!important;background:#21394a!important;color:#fff!important}.laka-featured-picker{display:none;padding:7px 9px;border-bottom:1px solid #344352;background:#18232c}.laka-featured.config-open .laka-featured-picker{display:block}.laka-featured-picker-head{display:flex;align-items:center;justify-content:space-between;gap:8px;margin-bottom:6px;color:#9fb0bf;font-size:8px}.laka-featured-options{display:flex;flex-wrap:wrap;gap:4px}.laka-featured-port-option{padding:3px 7px!important;border:1px solid #435463!important;border-radius:10px!important;background:#121c24!important;color:#aab9c6!important;font-size:8px!important;cursor:pointer}.laka-featured-port-option.selected{border-color:#2ecc71!important;background:#183a2d!important;color:#eafff2!important}.laka-featured-list{display:grid;grid-template-columns:repeat(auto-fit,minmax(min(430px,100%),1fr));gap:8px;padding:8px}.laka-featured-card{display:none;min-width:0;padding:7px 9px;border:1px solid #334452;border-radius:5px;background:#17232d}.laka-featured-card.selected{display:block}.laka-featured-card-head{display:flex;align-items:flex-start;justify-content:space-between;gap:8px}.laka-featured-name{font-size:11px;font-weight:700;color:#fff}.laka-featured-alias{margin-top:2px;color:#8fb5d0;font-size:8px}.laka-featured-state{padding:2px 6px;border-radius:9px;background:#173d30;color:#45d887;font-size:8px;font-weight:700}.laka-featured-state.down{background:#482528;color:#ff7774}.laka-featured-values{display:flex;justify-content:space-between;gap:12px;margin:6px 0 2px;font-size:9px}.laka-featured-in{color:#38bdf8}.laka-featured-out{color:#ff9f43}.laka-featured-util{color:#e4edf5;font-weight:700}.laka-featured-chart{height:var(--chart-height);min-height:100px;display:flex;align-items:center;justify-content:center;overflow:hidden;border-top:1px solid #30414e}.laka-featured-chart img{display:block;max-width:100%;width:auto;height:auto;max-height:100%;object-fit:contain}.laka-featured-loading,.laka-featured-empty{color:#8fa1b3;font-size:9px}.laka-featured-foot{display:flex;justify-content:space-between;gap:8px;padding-top:3px;border-top:1px solid #30414e;color:#8294a3;font-size:8px}.laka-featured-config-empty{display:none;padding:12px;color:#8fa1b3;font-size:9px;text-align:center}.laka-featured.no-selection .laka-featured-config-empty{display:block}
.laka-sw.modern-ports .laka-sw-grid{grid-template-columns:repeat(auto-fit,38px)!important;gap:7px 6px}.laka-sw.modern-ports .laka-port{display:flex;flex-direction:column;align-items:center;justify-content:flex-start;min-height:38px;padding:2px;border:0;background:transparent!important;box-shadow:none}.laka-sw.modern-ports .laka-port:hover,.laka-sw.modern-ports .laka-port.linked-hover{transform:scale(1.3);background:#1b2731!important}.laka-sw.modern-ports .laka-port-name{order:1;width:100%;margin:0 0 4px;color:#aebdca;font-size:8px;font-weight:700;line-height:10px}.laka-sw.modern-ports .laka-jack{order:2;width:18px;height:10px;border:0;border-radius:1px;background:#2ecc71!important;box-shadow:0 0 5px rgba(46,204,113,.35)}.laka-sw.modern-ports .laka-jack:after{left:4px;right:4px;bottom:2px;height:2px;background:repeating-linear-gradient(90deg,#0b3520 0 2px,transparent 2px 3px)}.laka-sw.modern-ports .laka-port.down .laka-jack{background:#ff8a24!important;box-shadow:0 0 5px rgba(255,138,36,.32)}.laka-sw.modern-ports .laka-port.disabled .laka-jack{background:#657381!important;box-shadow:none;filter:none}.laka-sw.modern-ports .laka-port.unknown .laka-jack{background:#42a5f5!important}.laka-sw.modern-ports .laka-port.uplink .laka-jack{background:#8b5cf6!important}.laka-sw.modern-ports .laka-led,.laka-sw.modern-ports .laka-port-alias,.laka-sw.modern-ports .laka-port-util-label{display:none}.laka-sw.modern-ports .laka-util{height:2px;left:5px;right:5px;bottom:0;width:auto;max-width:none;transform:scaleX(calc(var(--util) / 100));transform-origin:left}.laka-hardware{margin-top:11px;border:1px solid #344352;border-radius:6px;background:rgba(10,15,20,.43);overflow:hidden}.laka-hardware-head{display:flex;justify-content:space-between;align-items:center;padding:7px 9px;background:#27323d;border-bottom:1px solid #3d4b58}.laka-hardware-title{color:#f1f6fa;font-size:11px;font-weight:700;text-transform:uppercase}.laka-hardware-counts{color:#8fa1b3;font-size:8px}.laka-sensor-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:7px;padding:8px}.laka-sensor-card{position:relative;min-width:0;padding:8px;border:1px solid #344654;border-radius:5px;background:#17232d;cursor:pointer}.laka-sensor-card:hover{border-color:#64a7d8;background:#1d2c37}.laka-sensor-card.ok{border-top:2px solid #2ecc71}.laka-sensor-card.warning{border-top:2px solid #ffb020}.laka-sensor-card.critical{border-top:2px solid #ef5350}.laka-sensor-card.unknown{border-top:2px solid #64748b}.laka-sensor-type{color:#8fa1b3;font-size:7px;text-transform:uppercase}.laka-sensor-name{margin-top:3px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;color:#dce6ee;font-size:9px}.laka-sensor-value{margin-top:5px;color:#fff;font-size:16px;font-weight:700}.laka-sensor-state{position:absolute;right:7px;top:7px;width:7px;height:7px;border-radius:50%;background:#2ecc71;box-shadow:0 0 5px #2ecc71}.laka-sensor-card.warning .laka-sensor-state{background:#ffb020;box-shadow:0 0 5px #ffb020}.laka-sensor-card.critical .laka-sensor-state{background:#ef5350;box-shadow:0 0 5px #ef5350}.laka-sensor-card.unknown .laka-sensor-state{background:#64748b;box-shadow:none}.laka-sensor-clock{margin-top:4px;color:#718597;font-size:7px}.laka-sensor-empty{padding:12px;color:#8fa1b3;font-size:9px;text-align:center}
.laka-sw.modern-ports .laka-port.uplink.down .laka-jack{background:#ff8a24!important}.laka-sw.modern-ports .laka-port.uplink.disabled .laka-jack{background:#657381!important}.laka-sw.modern-ports .laka-port.uplink.unknown .laka-jack{background:#42a5f5!important}
.laka-view-tabs{display:flex;align-items:center;gap:4px;margin:-2px 0 9px;padding:0 2px;border-bottom:1px solid #3a4957}.laka-view-tab{position:relative;padding:6px 10px!important;border:0!important;background:transparent!important;color:#91a5b7!important;font-size:9px!important;font-weight:600!important;cursor:pointer}.laka-view-tab:hover{color:#e5edf4!important}.laka-view-tab.active{color:#fff!important}.laka-view-tab.active:after{content:"";position:absolute;left:7px;right:7px;bottom:-1px;height:2px;background:#ef5350}.laka-tab-count{display:inline-block;margin-left:4px;padding:1px 5px;border-radius:8px;background:#263746;color:#a9bac8;font-size:7px}.laka-tab-section{display:none!important}.laka-sw[data-active-tab="overview"] .laka-section-overview,.laka-sw[data-active-tab="interfaces"] .laka-section-interfaces,.laka-sw[data-active-tab="consumption"] .laka-section-consumption,.laka-sw[data-active-tab="hardware"] .laka-section-hardware{display:flex!important}.laka-sw[data-active-tab="overview"] .laka-sw-member,.laka-sw[data-active-tab="interfaces"] .laka-interface-panel,.laka-sw[data-active-tab="consumption"] .laka-featured,.laka-sw[data-active-tab="hardware"] .laka-hardware,.laka-sw[data-active-tab="topology"] .laka-topology{display:block!important}.laka-sw.dashboard-ports .laka-sw-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(45px,52px))!important;gap:6px}.laka-sw.dashboard-ports .laka-port{display:flex;flex-direction:column;align-items:center;justify-content:center;min-height:46px;padding:5px 3px 6px;border:1px solid #246c4b;border-radius:5px;background:linear-gradient(145deg,#174733,#0f2d22);box-shadow:inset 0 1px rgba(255,255,255,.07),0 2px 5px rgba(0,0,0,.3)}.laka-sw.dashboard-ports .laka-port:hover,.laka-sw.dashboard-ports .laka-port.linked-hover{transform:translateY(-3px) scale(1.14);border-color:#6de5a5;background:linear-gradient(145deg,#205c43,#123827);box-shadow:0 9px 20px rgba(0,0,0,.55)}.laka-sw.dashboard-ports .laka-jack{display:none}.laka-sw.dashboard-ports .laka-port-name{margin:0;color:#fff;font-size:12px;font-weight:800;line-height:15px}.laka-sw.dashboard-ports .laka-port-alias{width:100%;height:10px;margin-top:3px;color:#a8c9b8;font-size:7px;line-height:10px}.laka-sw.dashboard-ports .laka-port-util-label{right:3px;bottom:3px;background:rgba(0,0,0,.35);color:#e1edf4}.laka-sw.dashboard-ports .laka-led{right:5px;top:5px;width:6px;height:6px}.laka-sw.dashboard-ports .laka-port.down{border-color:#a94835;background:linear-gradient(145deg,#673124,#3c1d18)}.laka-sw.dashboard-ports .laka-port.down:hover{border-color:#ff8a65;background:linear-gradient(145deg,#783a2b,#48211b)}.laka-sw.dashboard-ports .laka-port.disabled{border-color:#4c5864;background:linear-gradient(145deg,#39434d,#252d35);color:#8996a2}.laka-sw.dashboard-ports .laka-port.unknown{border-color:#376c91;background:linear-gradient(145deg,#244a64,#182f41)}.laka-sw.dashboard-ports .laka-port.uplink.up{border-color:#7258b5;background:linear-gradient(145deg,#493a78,#2d254b)}.laka-sw.dashboard-ports .laka-port.has-problem:before{left:3px;top:3px}.laka-sw.dashboard-ports .laka-util{height:3px}
.laka-sw[data-active-tab="interfaces"]:not(.filter-empty) .laka-no-match{display:none!important}.laka-sw[data-active-tab="interfaces"].filter-empty .laka-no-match{display:block!important}
.laka-sw.dashboard-ports .laka-port-name{order:1}.laka-sw.dashboard-ports .laka-jack{display:block;order:2;width:23px;height:12px;margin:3px auto 1px;border:1px solid rgba(255,255,255,.45);border-radius:3px 3px 5px 5px;background:rgba(4,12,16,.58)!important;box-shadow:inset 0 -2px rgba(255,255,255,.08)}.laka-sw.dashboard-ports .laka-jack:after{left:4px;right:4px;bottom:2px;height:3px;background:repeating-linear-gradient(90deg,rgba(255,255,255,.75) 0 2px,transparent 2px 4px)}.laka-sw.dashboard-ports .laka-port-alias{order:3}.laka-sw.dashboard-ports .laka-port-util-label{order:4}
.laka-featured-list{grid-template-columns:minmax(0,1fr);gap:10px}.laka-featured-card{padding:8px 10px}.laka-featured-in{color:#36d26f;font-weight:700}.laka-featured-out{color:#ff625f;font-weight:700}.laka-featured-chart{min-height:180px;align-items:stretch;justify-content:stretch}.laka-featured-chart img{width:100%;height:100%;max-width:none;max-height:none;object-fit:fill;image-rendering:auto}
.laka-featured-chart{position:relative;background:linear-gradient(180deg,rgba(27,41,52,.58),rgba(14,24,32,.25))}.laka-vector-chart{display:block;width:100%;height:100%;overflow:visible}.laka-vector-chart .grid{stroke:#536574;stroke-width:1;opacity:.38;vector-effect:non-scaling-stroke}.laka-vector-chart .grid.vertical{opacity:.18}.laka-vector-chart .axis-label{fill:#aebdca;font-size:10px;font-family:Arial,sans-serif}.laka-vector-chart .line{fill:none;stroke-width:2.2;stroke-linejoin:round;stroke-linecap:round;vector-effect:non-scaling-stroke}.laka-vector-chart .line.in{stroke:#22d3ee}.laka-vector-chart .line.out{stroke:#fb923c}.laka-vector-chart .area.in{fill:#22d3ee;opacity:.13}.laka-vector-chart .area.out{fill:#fb923c;opacity:.10}.laka-vector-chart .chart-legend text{fill:#e6edf3;font-size:10px;font-family:Arial,sans-serif}.laka-vector-chart .legend-in{fill:#22d3ee}.laka-vector-chart .legend-out{fill:#fb923c}.laka-vector-chart .crosshair{stroke:#fff;stroke-width:1;opacity:0;stroke-dasharray:4 3;pointer-events:none;vector-effect:non-scaling-stroke}.laka-vector-chart .crosshair.visible{opacity:.65}.laka-chart-tooltip{display:none;position:absolute;z-index:5;max-width:calc(100% - 16px);padding:5px 8px;border:1px solid #607789;border-radius:4px;background:rgba(9,17,24,.96);color:#f4f8fb;font-size:9px;line-height:14px;white-space:nowrap;box-shadow:0 5px 15px rgba(0,0,0,.4);pointer-events:none}.laka-chart-tooltip.visible{display:block}.laka-featured-in{color:#22d3ee}.laka-featured-out{color:#fb923c}
.laka-topology{display:none;margin-top:2px;border:1px solid #344352;border-radius:6px;background:#111b23;overflow:hidden}.laka-topology-head{display:flex;align-items:center;justify-content:space-between;gap:10px;padding:8px 10px;border-bottom:1px solid #344352;background:#26323d}.laka-topology-title{font-size:11px;font-weight:800;color:#f1f6fa;text-transform:uppercase}.laka-topology-subtitle{margin-top:2px;color:#8fa1b3;font-size:8px}.laka-topology-actions{display:flex;align-items:center;gap:4px}.laka-topology-button{padding:3px 8px!important;border:1px solid #486072!important;border-radius:4px!important;background:#16232d!important;color:#c9d7e2!important;font-size:8px!important;cursor:pointer}.laka-topology-button:hover,.laka-topology-button.active{border-color:#38bdf8!important;background:#213b4d!important;color:#fff!important}.laka-topology-button.primary{border-color:#279461!important;background:#17422f!important;color:#dcffeb!important}.laka-topology-button.danger{border-color:#a74848!important;color:#ffaaa8!important}.laka-topology-button:disabled{opacity:.4;cursor:not-allowed}.laka-topology-stage{position:relative;height:var(--topology-height,520px);min-height:220px;max-height:80vh;overflow:hidden;resize:vertical;cursor:grab;scrollbar-width:none;background-image:radial-gradient(rgba(105,130,149,.22) 1px,transparent 1px);background-size:18px 18px}.laka-topology-stage::-webkit-scrollbar{display:none}.laka-topology-stage.panning{cursor:grabbing;user-select:none}.laka-topology-svg{display:block;width:100%;min-width:760px;height:auto;min-height:460px;user-select:none}.laka-topology-edge{fill:none;stroke:#64748b;stroke-width:1.35;opacity:.88;cursor:pointer}.laka-topology-edge.up{stroke:#2ecc71}.laka-topology-edge.down{stroke:#ef5350}.laka-topology-edge.warning{stroke:#ffb020}.laka-topology-edge.selected{stroke:#38bdf8;stroke-width:3}.laka-topology-edge-hit{fill:none;stroke:transparent;stroke-width:12;cursor:pointer}.laka-topology-edge-label{fill:#dce6ef;font:10px Arial,sans-serif;paint-order:stroke;stroke:#111b23;stroke-width:4px;stroke-linejoin:round;pointer-events:none}.laka-topology-node{cursor:pointer}.laka-topology-node rect{fill:#1d2a35;stroke:#607384;stroke-width:2}.laka-topology-node.available rect{stroke:#2ecc71}.laka-topology-node.warning rect{stroke:#ffb020}.laka-topology-node.unavailable rect{stroke:#ef5350}.laka-topology-node.maintenance rect{stroke:#42a5f5}.laka-topology-node.current rect{stroke-width:4;filter:drop-shadow(0 0 6px rgba(56,189,248,.5))}.laka-topology-node-name{fill:#fff;font:700 12px Arial,sans-serif}.laka-topology-node-model{fill:#91a5b7;font:9px Arial,sans-serif}.laka-topology-node-state{fill:#9fb0bf;font:8px Arial,sans-serif}.laka-topology-empty{display:flex;min-height:220px;align-items:center;justify-content:center;color:#8fa1b3;font-size:10px}.laka-topology-legend{display:flex;align-items:center;gap:14px;padding:6px 10px;border-top:1px solid #344352;color:#91a5b7;font-size:8px}.laka-topology-legend span:before{content:"";display:inline-block;width:16px;height:2px;margin-right:5px;vertical-align:2px;background:#64748b}.laka-topology-legend .up:before{background:#2ecc71}.laka-topology-legend .down:before{background:#ef5350}.laka-topology-legend .warning:before{background:#ffb020}.laka-topology-form-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px;padding:12px}.laka-topology-field{display:flex;flex-direction:column;gap:4px}.laka-topology-field.full{grid-column:1/-1}.laka-topology-field label{color:#aebdca;font-size:10px;font-weight:700}.laka-topology-field select,.laka-topology-field input{height:30px;padding:4px 7px;border:1px solid #52616e;border-radius:4px;background:#151d24;color:#edf3f7;font-size:11px}.laka-topology-form-actions{display:flex;justify-content:flex-end;gap:6px;padding:0 12px 12px}.laka-topology-error{margin:0 12px 10px;padding:7px;border:1px solid #8c3e3e;border-radius:4px;background:#442326;color:#ffb1af;font-size:10px}.laka-topology-form-note{padding:0 12px 10px;color:#8295a5;font-size:9px}
.laka-topology-nav{display:flex!important;align-items:center!important;gap:7px!important;width:100%!important;height:34px!important;margin:0 0 7px!important;padding:6px 8px!important;border:1px solid #42647d!important;border-radius:5px!important;background:#203543!important;color:#e8f5ff!important;font-size:9px!important;font-weight:700!important;text-align:left!important;cursor:pointer}.laka-topology-nav:hover,.laka-topology-nav.active{border-color:#38bdf8!important;background:#28506a!important}.laka-topology-nav-icon{font-size:14px;color:#38bdf8}.laka-topology-nav-count{margin-left:auto;padding:1px 6px;border-radius:8px;background:#132532;color:#8edcff;font-size:8px}.laka-console.nav-collapsed .laka-topology-nav{justify-content:center;padding:5px!important}.laka-console.nav-collapsed .laka-topology-nav-label,.laka-console.nav-collapsed .laka-topology-nav-count{display:none}.laka-global-topology{display:none;min-height:100%;padding:10px}.laka-global-topology.active{display:block}.laka-global-topology .laka-topology{display:block}.laka-topology-endpoint rect{fill:#17242d;stroke:#64748b;stroke-dasharray:4 2}.laka-topology-endpoint.phone rect{stroke:#a78bfa}.laka-topology-endpoint.access_point rect{stroke:#38bdf8}.laka-topology-endpoint.firewall rect{stroke:#fb7185}.laka-topology-endpoint.camera rect{stroke:#f59e0b}.laka-topology-endpoint.server rect{stroke:#60a5fa}.laka-topology-icon{fill:none;stroke:#dce6ef;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}.laka-topology-protocol{fill:#7dd3fc;font:700 7px Arial,sans-serif}.laka-topology-endpoint-info{fill:#9fb0bf;font:8px Arial,sans-serif}.laka-topology-button.endpoint-toggle.active{border-color:#a78bfa!important;background:#382f5a!important;color:#efe9ff!important}
.laka-endpoint-selector{display:none;align-items:center;flex-wrap:wrap;gap:5px;padding:7px 10px;border-bottom:1px solid #344352;background:#18242d}.laka-endpoint-selector.open{display:flex}.laka-endpoint-selector-label{margin-right:3px;color:#9fb0bf;font-size:8px;font-weight:700}.laka-endpoint-chip{padding:3px 8px!important;border:1px solid #465a6b!important;border-radius:10px!important;background:#111b23!important;color:#aab9c6!important;font-size:8px!important;cursor:pointer}.laka-endpoint-chip:hover,.laka-endpoint-chip.active{border-color:#a78bfa!important;background:#382f5a!important;color:#fff!important}.laka-endpoint-chip.all{border-color:#387c62!important}.laka-endpoint-chip.hide{border-color:#75454c!important;color:#ffaaa8!important}
.laka-neighbor-panels{display:none!important;grid-template-columns:repeat(2,minmax(0,1fr));gap:8px;margin-top:12px}.laka-sw[data-active-tab="overview"] .laka-neighbor-panels{display:grid!important}.laka-neighbor-panel{min-width:0;border:1px solid #344352;border-radius:6px;background:rgba(10,15,20,.43);overflow:hidden}.laka-neighbor-head{display:flex;align-items:center;justify-content:space-between;width:100%;min-height:34px;padding:7px 9px!important;border:0!important;background:#26323d!important;color:#edf4f9!important;text-align:left!important;cursor:pointer}.laka-neighbor-head:hover{background:#2d3d49!important}.laka-neighbor-title{display:flex;align-items:center;gap:6px;font-size:10px;font-weight:700}.laka-neighbor-count{padding:1px 6px;border-radius:8px;background:#17242d;color:#8edcff;font-size:7px}.laka-neighbor-chevron{color:#9db0bf;font-size:10px;transition:transform .15s ease}.laka-neighbor-panel.expanded .laka-neighbor-chevron{transform:rotate(180deg)}.laka-neighbor-body{display:none;max-height:190px;overflow:auto;scrollbar-color:#526475 #1a222a;scrollbar-width:thin}.laka-neighbor-panel.expanded .laka-neighbor-body{display:block}.laka-neighbor-row{display:grid;grid-template-columns:minmax(82px,.8fr) minmax(120px,1.5fr) minmax(76px,.75fr);align-items:center;gap:7px;min-height:31px;padding:5px 8px;border-top:1px solid rgba(78,94,108,.4);color:#cbd6df;font-size:8px;cursor:default}.laka-neighbor-row:hover{background:#263642;box-shadow:inset 3px 0 #64a7d8}.laka-neighbor-row.clickable{cursor:pointer}.laka-neighbor-port{font-weight:700;color:#fff}.laka-neighbor-name{min-width:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.laka-neighbor-detail{min-width:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;color:#8fa5b7;text-align:right}.laka-neighbor-protocol{display:inline-block;margin-right:5px;padding:1px 4px;border-radius:7px;background:#19384a;color:#7dd3fc;font-size:7px;font-weight:700}.laka-neighbor-empty{padding:13px;color:#8599aa;font-size:8px;text-align:center}
.laka-device-topology{display:none!important;margin-top:6px}.laka-sw[data-active-tab="overview"] .laka-device-topology{display:block!important}.laka-device-topology .laka-topology-stage{height:var(--topology-height,420px);min-height:220px;max-height:75vh}.laka-device-topology .laka-topology-svg{min-height:300px}.laka-topology-endpoint .laka-topology-node-name{font-size:8.5px}.laka-topology-endpoint .laka-topology-endpoint-info{font-size:7px}.laka-map-mode.active{border-color:#a78bfa!important;background:#382f5a!important;color:#fff!important}.laka-neighbor-modal-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:7px;padding:12px}.laka-neighbor-modal-item{min-width:0;padding:8px 9px;border:1px solid #3c4b58;border-radius:5px;background:#172129}.laka-neighbor-modal-item.full{grid-column:1/-1}.laka-neighbor-modal-label{display:block;margin-bottom:3px;color:#8297a8;font-size:8px;text-transform:uppercase}.laka-neighbor-modal-value{display:block;overflow-wrap:anywhere;color:#edf4f8;font-size:11px;font-weight:600}.laka-neighbor-modal-actions{display:flex;justify-content:flex-end;padding:0 12px 12px}.laka-neighbor-open{padding:5px 10px!important;border:1px solid #279461!important;border-radius:4px!important;background:#17422f!important;color:#dcffeb!important;font-size:9px!important;cursor:pointer}
.laka-chart-stage{height:300px!important;align-items:stretch!important;justify-content:stretch!important;overflow:hidden!important;background:linear-gradient(180deg,rgba(27,41,52,.58),rgba(14,24,32,.25))}.laka-chart-stage .laka-vector-chart{width:100%;height:100%}
.laka-port-layout-menu{display:flex;align-items:center;gap:3px;margin-left:auto}.laka-sw:not([data-active-tab="overview"]) .laka-port-layout-menu{display:none}.laka-port-layout-label{margin-right:3px;color:#8295a5;font-size:8px}.laka-port-layout-button{min-width:24px;height:22px;padding:2px 7px!important;border:1px solid #435767!important;border-radius:4px!important;background:#14202a!important;color:#9db0bf!important;font-size:8px!important;cursor:pointer}.laka-port-layout-button:hover,.laka-port-layout-button.active{border-color:#38bdf8!important;background:#213b4d!important;color:#fff!important}.laka-ports-area{position:relative;transition:max-height .2s ease}.laka-sw.ports-docked .laka-ports-area{max-height:190px;overflow:hidden}.laka-sw.ports-docked .laka-ports-area:after{content:"";position:absolute;left:0;right:0;bottom:0;height:28px;background:linear-gradient(transparent,#202b35);pointer-events:none}.laka-sw.ports-collapsed .laka-ports-area,.laka-sw.ports-collapsed .laka-status-legend{display:none!important}
.laka-neighbor-compare{display:grid;grid-template-columns:minmax(0,1fr) 54px minmax(0,1fr);gap:10px;align-items:stretch;padding:12px}.laka-neighbor-side{min-width:0;border:1px solid #3c4b58;border-radius:6px;background:#172129;overflow:hidden}.laka-neighbor-side-title{padding:8px 10px;border-bottom:1px solid #3c4b58;background:#22313c;color:#fff;font-size:10px;font-weight:800;text-transform:uppercase}.laka-neighbor-side-body{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:7px;padding:9px}.laka-neighbor-bridge{display:flex;flex-direction:column;align-items:center;justify-content:center;gap:6px;color:#38bdf8;font-size:18px}.laka-neighbor-protocol-badge{padding:2px 6px;border:1px solid #3b718e;border-radius:9px;background:#19384a;color:#8edcff;font-size:8px;font-weight:700}
/* Zabbix theme bridge: preserve semantic state colors while inheriting the active UI palette and typography. */
.laka-theme-dark{--laka-bg:var(--laka-zbx-bg,#111820);--laka-panel:#18222b;--laka-surface:#10171e;--laka-header:#27323d;--laka-input:#0e151c;--laka-hover:#263642;--laka-border:#344352;--laka-text:var(--laka-zbx-text,#dce6f1);--laka-muted:#91a5b8;--laka-map:#101d26;--laka-dot:#284253;--laka-node:#17242d}
.laka-theme-light{--laka-bg:var(--laka-zbx-bg,#fff);--laka-panel:#f2f5f7;--laka-surface:#fff;--laka-header:#e9eef2;--laka-input:#fff;--laka-hover:#e3edf4;--laka-border:#ccd5dc;--laka-text:var(--laka-zbx-text,#1f2d38);--laka-muted:#667786;--laka-map:#f7f9fa;--laka-dot:#cbd6dd;--laka-node:#fff}
.laka-console,.laka-console button,.laka-console input,.laka-console select,.laka-port-modal,.laka-port-modal button,.laka-port-modal input,.laka-port-modal select{font-family:inherit!important}
.laka-console{background:var(--laka-bg);border-color:var(--laka-border);color:var(--laka-text)}.laka-console-main,.laka-sw{background:var(--laka-surface)!important;color:var(--laka-text)!important}.laka-device-nav{background:var(--laka-panel);border-color:var(--laka-border)}.laka-device-nav-head,.laka-device-button,.laka-status-legend,.laka-view-tabs{border-color:var(--laka-border)!important}.laka-device-nav-title,.laka-device-name,.laka-sw-title,.laka-summary-value,.laka-interface-panel-title,.laka-featured-title{color:var(--laka-text)!important}.laka-device-model,.laka-device-resource,.laka-summary-label,.laka-sw-meta,.laka-sw-member-title,.laka-interface-counts,.laka-featured-subtitle{color:var(--laka-muted)!important}.laka-device-search,.laka-interface-search{background:var(--laka-input)!important;border-color:var(--laka-border)!important;color:var(--laka-text)!important}.laka-device-button:hover,.laka-device-button.active,.laka-interface-row:hover,.laka-interface-row.linked-hover{background:var(--laka-hover)!important;color:var(--laka-text)!important}
.laka-interface-panel,.laka-featured,.laka-neighbor-panel,.laka-topology{background:var(--laka-surface)!important;border-color:var(--laka-border)!important}.laka-interface-panel-head,.laka-featured-head,.laka-neighbor-head,.laka-topology-head{background:var(--laka-header)!important;border-color:var(--laka-border)!important;color:var(--laka-text)!important}.laka-interface-tools,.laka-featured-picker,.laka-endpoint-selector{background:var(--laka-panel)!important;border-color:var(--laka-border)!important}.laka-interface-table th,.laka-interface-table td,.laka-neighbor-row{border-color:var(--laka-border)!important}.laka-interface-table th{background:var(--laka-panel)!important}.laka-sort-button,.laka-interface-description,.laka-interface-speed,.laka-interface-traffic,.laka-interface-errors{color:var(--laka-muted)!important}.laka-sort-button:hover,.laka-sort-button.active{background:var(--laka-hover)!important;color:var(--laka-text)!important}
.laka-port{background:var(--laka-surface);color:var(--laka-text);border-color:var(--laka-border)}.laka-theme-light .laka-port.up{background:#eaf6ee}.laka-theme-light .laka-port.down{background:#fdeeee}.laka-theme-light .laka-port.disabled{background:#eef1f3;color:#72808c}.laka-theme-light .laka-port.unknown{background:#edf6fc}.laka-port-alias{color:var(--laka-muted)}
.laka-topology-stage{background-color:var(--laka-map)!important;background-image:radial-gradient(var(--laka-dot) 1px,transparent 1px)!important}.laka-topology-node rect,.laka-topology-endpoint rect{fill:var(--laka-node)!important}.laka-topology-svg text,.laka-vector-chart text{font-family:inherit!important}.laka-topology-node-name,.laka-topology-node-model,.laka-topology-node-state,.laka-topology-endpoint-info{fill:var(--laka-text)!important}.laka-vector-chart .grid{stroke:var(--laka-border)!important}.laka-vector-chart .axis-label,.laka-vector-chart .chart-legend text{fill:var(--laka-text)!important}.laka-chart-stage,.laka-featured-chart{background:var(--laka-surface)!important}
.laka-port-modal .laka-modal-box{background:var(--laka-surface);border-color:var(--laka-border);color:var(--laka-text)}.laka-port-modal .laka-modal-head,.laka-port-modal .laka-detail-table th,.laka-port-modal .laka-neighbor-side-title{background:var(--laka-header);border-color:var(--laka-border)}.laka-port-modal .laka-modal-title,.laka-port-modal .laka-neighbor-modal-value,.laka-port-modal .laka-neighbor-side-title{color:var(--laka-text)}.laka-port-modal .laka-detail-table td,.laka-port-modal .laka-neighbor-side,.laka-port-modal .laka-neighbor-modal-item,.laka-port-modal .laka-chart{border-color:var(--laka-border)}.laka-port-modal .laka-neighbor-side,.laka-port-modal .laka-neighbor-modal-item,.laka-port-modal .laka-chart{background:var(--laka-panel)}.laka-port-modal .laka-detail-table tr:hover td{background:var(--laka-hover)}
/* Interface palette: neutral Zabbix surfaces with state expressed by border, LED and accent. */
.laka-interface-name,.laka-interface-description,.laka-interface-speed,.laka-interface-traffic,.laka-interface-errors{color:var(--laka-text)!important}.laka-interface-description,.laka-interface-speed,.laka-interface-traffic{opacity:.82}.laka-mini-meter{background:var(--laka-border)!important}.laka-theme-light .laka-interface-row.up{box-shadow:inset 3px 0 #2e7d32}.laka-theme-light .laka-interface-row.down{box-shadow:inset 3px 0 #d64a4a}.laka-theme-light .laka-interface-row.disabled{box-shadow:inset 3px 0 #87929c}.laka-theme-light .laka-interface-row.unknown{box-shadow:inset 3px 0 #3c8dbc}
.laka-sw.dashboard-ports .laka-port,.laka-sw.dashboard-ports .laka-port.up,.laka-sw.dashboard-ports .laka-port.down,.laka-sw.dashboard-ports .laka-port.disabled,.laka-sw.dashboard-ports .laka-port.unknown,.laka-sw.dashboard-ports .laka-port.uplink.up{background:var(--laka-panel)!important;color:var(--laka-text)!important;box-shadow:inset 0 1px rgba(255,255,255,.08),0 1px 3px rgba(0,0,0,.16)}.laka-sw.dashboard-ports .laka-port.up{border-color:#2e9d5b}.laka-sw.dashboard-ports .laka-port.down{border-color:#d6534f}.laka-sw.dashboard-ports .laka-port.disabled{border-color:#87929c}.laka-sw.dashboard-ports .laka-port.unknown{border-color:#3c8dbc}.laka-sw.dashboard-ports .laka-port.uplink.up{border-color:#8066c7}.laka-sw.dashboard-ports .laka-port-name{color:var(--laka-text)!important}.laka-sw.dashboard-ports .laka-port-alias{color:var(--laka-muted)!important}.laka-sw.dashboard-ports .laka-port:hover,.laka-sw.dashboard-ports .laka-port.linked-hover{background:var(--laka-hover)!important;box-shadow:0 6px 14px rgba(0,0,0,.22)}
/* Hardware health grouped by component. */
.laka-hardware{background:var(--laka-surface)!important;border-color:var(--laka-border)!important}.laka-hardware-head{background:var(--laka-header)!important;border-color:var(--laka-border)!important}.laka-hardware-title{color:var(--laka-text)!important}.laka-hardware-counts{color:var(--laka-muted)!important}.laka-sensor-group{border-bottom:1px solid var(--laka-border)}.laka-sensor-group:last-child{border-bottom:0}.laka-sensor-group-head{display:flex;align-items:center;gap:7px;padding:7px 9px;background:var(--laka-panel);border-bottom:1px solid var(--laka-border)}.laka-sensor-group-title{color:var(--laka-text);font-size:9px;font-weight:700;text-transform:uppercase;letter-spacing:.04em}.laka-sensor-group-count{min-width:18px;padding:1px 5px;border-radius:9px;background:var(--laka-border);color:var(--laka-text);font-size:7px;text-align:center}.laka-sensor-grid{grid-template-columns:repeat(auto-fit,minmax(210px,1fr));background:var(--laka-surface)}.laka-sensor-card{background:var(--laka-panel)!important;border-color:var(--laka-border)!important}.laka-sensor-card:hover{background:var(--laka-hover)!important}.laka-sensor-name,.laka-sensor-value{color:var(--laka-text)!important}.laka-sensor-type,.laka-sensor-clock{color:var(--laka-muted)!important}.laka-sensor-group.type-temperature .laka-sensor-group-head{box-shadow:inset 3px 0 #ef8b3a}.laka-sensor-group.type-fan .laka-sensor-group-head{box-shadow:inset 3px 0 #42a5f5}.laka-sensor-group.type-psu .laka-sensor-group-head{box-shadow:inset 3px 0 #8b5cf6}.laka-sensor-group.type-other .laka-sensor-group-head{box-shadow:inset 3px 0 #64748b}
/* Topology headings and host identity use the same visual hierarchy as Zabbix. */
.laka-topology-title{color:var(--laka-text)!important;font-family:inherit!important;font-size:13px!important;font-weight:700!important;line-height:17px!important;letter-spacing:0!important;text-transform:none!important}.laka-topology-subtitle{margin-top:3px!important;color:var(--laka-muted)!important;font-family:inherit!important;font-size:10px!important;line-height:14px!important}.laka-topology-heading{min-width:0}.laka-sw-identity{display:flex;align-items:center;flex-wrap:wrap;gap:3px 9px;min-width:210px}.laka-sw-identity .laka-sw-title{font-size:13px;line-height:17px}.laka-sw-identity-meta{display:flex;align-items:center;flex-wrap:wrap;gap:4px 8px}.laka-sw-identity-meta span{display:inline-flex;align-items:center;min-height:18px;padding:1px 6px;border:1px solid var(--laka-border);border-radius:9px;background:var(--laka-panel);color:var(--laka-muted);font-size:9px;line-height:14px;white-space:nowrap}.laka-sw-identity-meta .laka-identity-ip{color:#0275b8}.laka-theme-dark .laka-sw-identity-meta .laka-identity-ip{color:#66b9e8}
/* Zabbix-like action tones: blue for selection, green for create, red for destructive state. */
.laka-topology-button:hover,.laka-topology-button.active,.laka-topology-button.endpoint-toggle.active,.laka-map-mode.active{border-color:#0275b8!important;background:#d9edf7!important;color:#1f2d38!important}.laka-theme-dark .laka-topology-button:hover,.laka-theme-dark .laka-topology-button.active,.laka-theme-dark .laka-topology-button.endpoint-toggle.active,.laka-theme-dark .laka-map-mode.active{background:#1e455d!important;color:#e8f5ff!important}.laka-topology-button.primary{border-color:#2e7d32!important;background:#e5f4e7!important;color:#256329!important}.laka-theme-dark .laka-topology-button.primary{background:#17422f!important;color:#dcffeb!important}.laka-topology-button.danger{border-color:#d6534f!important;background:#fae9e8!important;color:#a52e2a!important}.laka-theme-dark .laka-topology-button.danger{background:#482528!important;color:#ffaaa8!important}.laka-view-tab.active:after{background:#0275b8!important}
/* Complete light-theme control palette. Avoid dark pills and keep active tab labels visible. */
.laka-theme-light .laka-view-tab{color:#506273!important;background:transparent!important}.laka-theme-light .laka-view-tab:hover{color:#0275b8!important;background:#eef5f9!important}.laka-theme-light .laka-view-tab.active{color:#0275b8!important;background:#fff!important}.laka-theme-light .laka-tab-count{background:#dce8ef!important;color:#334b5c!important}.laka-theme-light .laka-view-tab.active .laka-tab-count{background:#0275b8!important;color:#fff!important}
.laka-theme-light .laka-filter,.laka-theme-light .laka-summary-filter,.laka-theme-light .laka-nav-filter,.laka-theme-light .laka-port-layout-button,.laka-theme-light .laka-featured-period,.laka-theme-light .laka-featured-config-toggle,.laka-theme-light .laka-featured-clear,.laka-theme-light .laka-period-button,.laka-theme-light .laka-endpoint-chip,.laka-theme-light .laka-topology-button{border-color:#aebfcb!important;background:#fff!important;color:#334b5c!important;box-shadow:none!important}.laka-theme-light .laka-filter:hover,.laka-theme-light .laka-filter.active,.laka-theme-light .laka-summary-filter:hover,.laka-theme-light .laka-nav-filter:hover,.laka-theme-light .laka-nav-filter.active,.laka-theme-light .laka-port-layout-button:hover,.laka-theme-light .laka-port-layout-button.active,.laka-theme-light .laka-featured-period:hover,.laka-theme-light .laka-featured-period.active,.laka-theme-light .laka-period-button:hover,.laka-theme-light .laka-period-button.active,.laka-theme-light .laka-endpoint-chip:hover,.laka-theme-light .laka-endpoint-chip.active{border-color:#0275b8!important;background:#e5f3fa!important;color:#025b8c!important}.laka-theme-light .laka-summary-filter.problem,.laka-theme-light .laka-summary-filter.util{border-color:#d6a342!important;background:#fff8e5!important;color:#8a6200!important}.laka-theme-light .laka-summary-filter.error{border-color:#d6534f!important;background:#fae9e8!important;color:#a52e2a!important}
.laka-theme-light .laka-topology-button.primary{border-color:#2e7d32!important;background:#e5f4e7!important;color:#256329!important}.laka-theme-light .laka-topology-button.danger{border-color:#d6534f!important;background:#fae9e8!important;color:#a52e2a!important}.laka-theme-light .laka-topology-button:hover,.laka-theme-light .laka-topology-button.active,.laka-theme-light .laka-topology-button.endpoint-toggle.active,.laka-theme-light .laka-map-mode.active{border-color:#0275b8!important;background:#d9edf7!important;color:#025b8c!important}.laka-theme-light .laka-sw-badge{border:1px solid #b8c8d2;background:#eef3f6!important;color:#334b5c!important}.laka-theme-light .laka-status-legend{background:#eef3f6!important;color:#506273!important}.laka-theme-light .laka-nav-toggle{border-color:#aebfcb!important;background:#fff!important;color:#334b5c!important}.laka-theme-light .laka-topology-nav{border-color:#8fb8d1!important;background:#e5f3fa!important;color:#025b8c!important}.laka-theme-light .laka-topology-nav:hover,.laka-theme-light .laka-topology-nav.active{border-color:#0275b8!important;background:#d4ebf7!important}.laka-theme-light .laka-topology-nav-count{background:#fff!important;color:#0275b8!important}.laka-theme-light .laka-device-button.active{background:#dcecf5!important;color:#1f2d38!important;box-shadow:inset 3px 0 #0275b8!important}
/* Manual-link dialog fields must follow the modal theme, including the native option popup. */
.laka-topology-field select,.laka-topology-field input{width:100%;box-sizing:border-box;font-family:inherit!important}.laka-theme-light .laka-topology-field label{color:#506273!important}.laka-theme-light .laka-topology-field select,.laka-theme-light .laka-topology-field input{color-scheme:light;background:#fff!important;border-color:#9fb3c1!important;color:#1f2d38!important}.laka-theme-light .laka-topology-field select:focus,.laka-theme-light .laka-topology-field input:focus{outline:0;border-color:#0275b8!important;box-shadow:0 0 0 1px rgba(2,117,184,.22)}.laka-theme-light .laka-topology-field select option{background:#fff!important;color:#1f2d38!important}.laka-theme-light .laka-topology-form-note{color:#667786!important}.laka-theme-light .laka-topology-form-actions .laka-topology-cancel{border-color:#9fb3c1!important;background:#fff!important;color:#334b5c!important}.laka-theme-light .laka-topology-form-actions .laka-topology-save{border-color:#2e7d32!important;background:#e5f4e7!important;color:#256329!important}.laka-theme-dark .laka-topology-field select,.laka-theme-dark .laka-topology-field input{color-scheme:dark}.laka-theme-dark .laka-topology-field select option{background:#151d24;color:#edf3f7}
@media(max-width:900px){.laka-sw-head{flex-wrap:wrap}.laka-device-summary{order:3;flex-basis:100%;justify-content:flex-start}.laka-sw-grid{grid-template-columns:repeat(auto-fit,minmax(50px,1fr))}}
@media(max-width:700px){.laka-console{grid-template-columns:1fr}.laka-device-nav{max-height:150px;border-right:0;border-bottom:1px solid #344352}.laka-neighbor-panels{grid-template-columns:1fr}.laka-neighbor-compare{grid-template-columns:1fr}.laka-neighbor-bridge{flex-direction:row}.laka-port-layout-label{display:none}}
CSS;

$widget_data = $data;
$console_ids = array_map(static fn(array $device): string => (string) $device['host']['hostid'], $data['devices'] ?? []);
$topology_hosts = [];
foreach ($data['devices'] ?? [] as $topology_device) {
	$primary_interface = $topology_device['host']['interfaces'][0] ?? [];
	foreach ($topology_device['host']['interfaces'] ?? [] as $candidate_interface) {
		if ((int) ($candidate_interface['main'] ?? 0) === 1) {
			$primary_interface = $candidate_interface;
			break;
		}
	}
	$topology_hosts[] = [
		'id' => (string) $topology_device['host']['hostid'],
		'name' => (string) $topology_device['host']['name'],
		'ip' => trim((string) ($primary_interface['ip'] ?? '')) !== ''
			? (string) $primary_interface['ip'] : (string) ($primary_interface['dns'] ?? ''),
		'model' => (string) $topology_device['summary']['model'],
		'health' => (string) ($topology_device['health'] ?? 'unknown'),
		'up' => (int) ($topology_device['counts']['up'] ?? 0),
		'down' => (int) ($topology_device['counts']['down'] ?? 0),
		'ports' => array_map(static fn(array $port): array => [
			'index' => (string) $port['index'],
			'name' => (string) $port['name'],
			'alias' => (string) $port['alias'],
			'status' => (string) $port['status'],
			'in' => (string) $port['in_text'],
			'out' => (string) $port['out_text'],
			'util' => $port['utilization']
		], $topology_device['ports'])
	];
}
$console = (new CDiv())->addClass('laka-console')
	->setAttribute('data-console-key', 'laka-network-console-'.implode('-', $console_ids))
	->setAttribute('data-csrf-token', CCsrfTokenHelper::get('widget'));

if (empty($data['devices'])) {
	$console->addItem((new CDiv($data['message']))->addClass('laka-device-empty'));
}
else {
	$nav = (new CDiv())->addClass('laka-device-nav');
	$nav_head = (new CDiv())->addClass('laka-device-nav-head');
	$title_row = (new CDiv())->addClass('laka-device-nav-title-row');
	$title_row->addItem((new CDiv(_('Network equipment').' · '.count($data['devices'])))->addClass('laka-device-nav-title'));
	$title_row->addItem((new CTag('button', true, '≪'))->addClass('laka-nav-toggle')->setAttribute('type', 'button')
		->setAttribute('title', _('Collapse equipment menu')));
	$nav_head->addItem($title_row);
	$topology_nav = (new CTag('button', true))->addClass('laka-topology-nav')->setAttribute('type', 'button');
	$topology_nav->addItem((new CSpan('◇'))->addClass('laka-topology-nav-icon'));
	$topology_nav->addItem((new CSpan(_('Topology')))->addClass('laka-topology-nav-label'));
	$topology_nav->addItem((new CSpan((string) count($widget_data['topology_links'] ?? [])))->addClass('laka-topology-nav-count'));
	$nav_head->addItem($topology_nav);
	$nav_head->addItem((new CTag('input', false))->addClass('laka-device-search')->setAttribute('type', 'search')
		->setAttribute('placeholder', _('Search equipment...'))->setAttribute('aria-label', _('Search equipment')));
	$nav_filters = (new CDiv())->addClass('laka-nav-filters');
	foreach (['all' => _('All'), 'issues' => _('Issues'), 'unknown' => _('No data'), 'maintenance' => _('Maintenance')] as $filter => $label) {
		$filter_button = (new CTag('button', true, $label))->addClass('laka-nav-filter')
			->setAttribute('type', 'button')->setAttribute('data-device-filter', $filter);
		if ($filter === 'all') $filter_button->addClass('active');
		$nav_filters->addItem($filter_button);
	}
	$nav_head->addItem($nav_filters);
	$nav->addItem($nav_head);
	$nav_list = (new CDiv())->addClass('laka-device-nav-list');
	foreach ($data['devices'] as $device_index => $device) {
		$button = (new CTag('button', true))->addClass('laka-device-button')
			->setAttribute('type', 'button')->setAttribute('data-hostid', $device['host']['hostid'])
			->setAttribute('data-health', $device['health'] ?? 'unknown')
			->setAttribute('data-search', strtolower($device['host']['name'].' '.$device['summary']['model']));
		if ($device_index === 0) $button->addClass('active');
		if (($device['counts']['problems'] ?? 0) > 0) $button->addClass('has-problems');
		$top = (new CDiv())->addClass('laka-device-button-top');
		$top->addItem((new CSpan())->addClass('laka-device-health'));
		$top->addItem((new CSpan($device['host']['name']))->addClass('laka-device-name'));
		$button->addItem($top);
		$button->addItem((new CDiv($device['summary']['model']))->addClass('laka-device-model'));
		$stats = (new CDiv())->addClass('laka-device-stats');
		$stats->addItem((new CSpan(($device['counts']['up'] ?? 0).' UP'))->addClass('laka-device-up'));
		$stats->addItem((new CSpan(($device['counts']['down'] ?? 0).' DOWN'))->addClass('laka-device-down'));
		$stats->addItem((new CSpan('CPU '.($device['summary']['cpu'] === null ? 'N/D' : number_format((float) $device['summary']['cpu'], 0).'%')))->addClass('laka-device-resource'));
		$stats->addItem((new CSpan('RAM '.($device['summary']['memory'] === null ? 'N/D' : number_format((float) $device['summary']['memory'], 0).'%')))->addClass('laka-device-resource'));
		if (($device['counts']['problems'] ?? 0) > 0) $stats->addItem((new CSpan($device['counts']['problems'].' !'))->addClass('laka-device-problem'));
		$button->addItem($stats);
		$nav_list->addItem($button);
	}
	$nav->addItem($nav_list);
	$console->addItem($nav);
	$main = (new CDiv())->addClass('laka-console-main');
	if (!empty($data['truncated'])) $main->addItem((new CDiv(_('Showing the first 50 accessible equipment.')))->addClass('laka-console-warning'));
	$global_topology = (new CDiv())->addClass('laka-global-topology');
	$topology = (new CDiv())->addClass('laka-topology')
		->setAttribute('data-current-hostid', '')
		->setAttribute('data-can-manage', !empty($widget_data['can_manage_topology']) ? '1' : '0')
		->setAttribute('data-hosts', json_encode($topology_hosts, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE))
		->setAttribute('data-links', json_encode($widget_data['topology_links'] ?? [], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE))
		->setAttribute('data-endpoints', json_encode($widget_data['topology_endpoints'] ?? [], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE))
		->setAttribute('data-endpoint-hosts', '[]');
	$topology_head = (new CDiv())->addClass('laka-topology-head');
	$topology_heading = (new CDiv())->addClass('laka-topology-heading');
	$topology_heading->addItem((new CDiv(_('Network topology')))->addClass('laka-topology-title'));
	$topology_heading->addItem((new CDiv(_('Automatic CDP/LLDP discovery and manual links · Drag background to move · Resize from lower corner')))->addClass('laka-topology-subtitle'));
	$topology_head->addItem($topology_heading);
	$topology_actions = (new CDiv())->addClass('laka-topology-actions');
	$endpoint_toggle = (new CTag('button', true, _('Endpoints').' · '.count($widget_data['topology_endpoints'] ?? [])))
		->addClass('laka-topology-button')->addClass('endpoint-toggle')->setAttribute('type', 'button')
		->setAttribute('data-topology-action', 'endpoints');
	$topology_actions->addItem($endpoint_toggle);
	$add_link_button = (new CTag('button', true, _('Add link')))->addClass('laka-topology-button')->addClass('primary')
		->setAttribute('type', 'button')->setAttribute('data-topology-action', 'add');
	if (empty($widget_data['can_manage_topology'])) $add_link_button->setAttribute('disabled', 'disabled');
	$topology_actions->addItem($add_link_button);
	$topology_actions->addItem((new CTag('button', true, _('Edit')))->addClass('laka-topology-button')
		->setAttribute('type', 'button')->setAttribute('data-topology-action', 'edit')->setAttribute('disabled', 'disabled'));
	$topology_actions->addItem((new CTag('button', true, _('Delete')))->addClass('laka-topology-button')->addClass('danger')
		->setAttribute('type', 'button')->setAttribute('data-topology-action', 'delete')->setAttribute('disabled', 'disabled'));
	foreach ([['out', '−', _('Zoom out')], ['in', '+', _('Zoom in')], ['reset', '1:1', _('Reset zoom')], ['fit', _('Fit'), _('Fit map')]] as [$action, $label, $title]) {
		$topology_actions->addItem((new CTag('button', true, $label))->addClass('laka-topology-button')
			->setAttribute('type', 'button')->setAttribute('title', $title)->setAttribute('data-topology-zoom', $action));
	}
	$topology_head->addItem($topology_actions);
	$topology->addItem($topology_head);
	$endpoint_selector = (new CDiv())->addClass('laka-endpoint-selector');
	$endpoint_selector->addItem((new CSpan(_('Show endpoints from:')))->addClass('laka-endpoint-selector-label'));
	foreach ($topology_hosts as $topology_host) {
		$endpoint_count = count(array_filter($widget_data['topology_endpoints'] ?? [],
			static fn(array $endpoint): bool => (string) ($endpoint['parent'] ?? '') === (string) $topology_host['id']));
		if ($endpoint_count === 0) continue;
		$endpoint_selector->addItem((new CTag('button', true, $topology_host['name'].' · '.$endpoint_count))
			->addClass('laka-endpoint-chip')->setAttribute('type', 'button')
			->setAttribute('data-topology-endpoint-host', $topology_host['id']));
	}
	$endpoint_selector->addItem((new CTag('button', true, _('All')))->addClass('laka-endpoint-chip')->addClass('all')
		->setAttribute('type', 'button')->setAttribute('data-topology-endpoint-action', 'all'));
	$endpoint_selector->addItem((new CTag('button', true, _('Hide')))->addClass('laka-endpoint-chip')->addClass('hide')
		->setAttribute('type', 'button')->setAttribute('data-topology-endpoint-action', 'hide'));
	$topology->addItem($endpoint_selector);
	$topology->addItem((new CDiv())->addClass('laka-topology-stage'));
	$topology_legend = (new CDiv())->addClass('laka-topology-legend');
	foreach (['up' => _('Operational'), 'warning' => _('Warning'), 'down' => _('Down'), 'unknown' => _('No data')] as $class => $label) {
		$topology_legend->addItem((new CSpan($label))->addClass($class));
	}
	$topology->addItem($topology_legend);
	$global_topology->addItem($topology);
	$main->addItem($global_topology);
	foreach ($data['devices'] as $device_index => $device) {
		$data = $device;
		$root = (new CDiv())->addClass('laka-sw')->setAttribute('data-hostid', $device['host']['hostid'])
			->setAttribute('data-active-tab', 'overview');
		if ($data['port_visual_style'] === 1) $root->addClass('modern-ports');
		elseif ($data['port_visual_style'] === 2) $root->addClass('dashboard-ports');

if ($data['host'] === null || !$data['ports']) {
	$root->addItem((new CDiv($data['message']))->addClass('laka-empty'));
}
else {
	$host = $data['host'];
	$head = (new CDiv())->addClass('laka-sw-head');
	$identity = (new CDiv())->addClass('laka-sw-identity');
	$identity->addItem((new CDiv($host['name']))->addClass('laka-sw-title'));
	$primary_interface = $host['interfaces'][0] ?? [];
	foreach ($host['interfaces'] ?? [] as $candidate_interface) {
		if ((int) ($candidate_interface['main'] ?? 0) === 1) {
			$primary_interface = $candidate_interface;
			break;
		}
	}
	$host_ip = trim((string) ($primary_interface['ip'] ?? '')) !== ''
		? (string) $primary_interface['ip'] : trim((string) ($primary_interface['dns'] ?? ''));
	$identity_meta = (new CDiv())->addClass('laka-sw-identity-meta');
	$identity_meta->addItem((new CSpan(_('IP').': '.($host_ip !== '' ? $host_ip : 'N/D')))->addClass('laka-identity-ip'));
	$identity_meta->addItem((new CSpan(_('Location').': '.$data['summary']['location']))->addClass('laka-identity-location'));
	$identity->addItem($identity_meta);
	$head->addItem($identity);
	$summary = (new CDiv())->addClass('laka-device-summary');
	$summary_values = [
		_('Model') => $data['summary']['model'],
		_('Uptime') => $data['summary']['uptime']
	];
	foreach ($summary_values as $label => $value) {
		$item = (new CSpan())->addClass('laka-summary-item');
		$item->addItem((new CSpan($label.':'))->addClass('laka-summary-label'));
		$item->addItem((new CSpan($value))->addClass('laka-summary-value'));
		$summary->addItem($item);
	}
	foreach (['CPU' => 'cpu', _('Memory') => 'memory'] as $label => $metric) {
		$value = $data['summary'][$metric];
		$value_node = (new CSpan($value === null ? 'N/D' : number_format((float) $value, 1).'%'))
			->addClass('laka-summary-value');
		if ($value !== null) $value_node->addClass($value >= 85 ? 'high' : ($value >= 70 ? 'warn' : 'ok'));
		$item = (new CSpan())->addClass('laka-summary-item');
		$item->addItem((new CSpan($label.':'))->addClass('laka-summary-label'));
		$item->addItem($value_node);
		$summary->addItem($item);
	}
	$head->addItem($summary);
	$badge = (new CSpan())->addClass('laka-sw-badge');
	$badge->addItem((new CSpan())->addClass('laka-sw-dot'));
	$badge->addItem($host['maintenance_status'] ? _('MAINTENANCE') : _('MONITORED'));
	$head->addItem($badge);
	$root->addItem($head);
	$tabs = (new CDiv())->addClass('laka-view-tabs');
	$tab_defs = [
		['overview', _('Summary'), count($data['ports'])],
		['interfaces', _('Interfaces'), count($data['ports'])]
	];
	if ($data['show_featured_charts']) $tab_defs[] = ['consumption', _('Consumption'), null];
	if ($data['show_hardware_health']) $tab_defs[] = ['hardware', _('Hardware'), count($data['hardware_sensors'])];
	foreach ($tab_defs as [$tab_key, $tab_label, $tab_count]) {
		$tab = (new CTag('button', true, $tab_label))->addClass('laka-view-tab')
			->setAttribute('type', 'button')->setAttribute('data-view-tab', $tab_key)
			->setAttribute('role', 'tab')->setAttribute('aria-selected', $tab_key === 'overview' ? 'true' : 'false');
		if ($tab_key === 'overview') $tab->addClass('active');
		if ($tab_count !== null) $tab->addItem((new CSpan((string) $tab_count))->addClass('laka-tab-count'));
		$tabs->addItem($tab);
	}
	$port_layout_menu = (new CDiv())->addClass('laka-port-layout-menu');
	$port_layout_menu->addItem((new CSpan(_('Interface view')))->addClass('laka-port-layout-label'));
	foreach ([
		['docked', '▤', _('Dock interfaces and prioritize topology')],
		['expanded', '□', _('Expand all interfaces')],
		['collapsed', '⌃', _('Hide interfaces and expand topology area')]
	] as [$mode, $label, $title]) {
		$button = (new CTag('button', true, $label))->addClass('laka-port-layout-button')
			->setAttribute('type', 'button')->setAttribute('title', $title)
			->setAttribute('data-port-layout', $mode);
		if ($mode === 'expanded') $button->addClass('active');
		$port_layout_menu->addItem($button);
	}
	$tabs->addItem($port_layout_menu);
	$root->addItem($tabs);
	$status_counts = ['up' => 0, 'down' => 0, 'disabled' => 0, 'unknown' => 0];
	foreach ($data['ports'] as $port) {
		$status_counts[$port['status']] = ($status_counts[$port['status']] ?? 0) + 1;
	}
	$legend = (new CDiv())->addClass('laka-status-legend')->addClass('laka-tab-section')->addClass('laka-section-overview');
	foreach ([
		'up' => _('Connected'),
		'down' => _('Disconnected'),
		'disabled' => _('Administratively off'),
		'unknown' => _('No status data')
	] as $state => $label) {
		$item = (new CSpan())->addClass('laka-legend-item')->addClass($state);
		$item->addItem((new CSpan())->addClass('laka-legend-dot'));
		$item->addItem($label.': '.$status_counts[$state]);
		$legend->addItem($item);
	}
	$root->addItem($legend);

	$problem_count = $error_count = $high_util_count = 0;
	foreach ($data['ports'] as $port) {
		if ($port['problems']) $problem_count++;
		if ((float) ($port['errors_in'] ?? 0) + (float) ($port['errors_out'] ?? 0)
				+ (float) ($port['discards_in'] ?? 0) + (float) ($port['discards_out'] ?? 0) > 0) $error_count++;
		if ($port['utilization'] !== null && (float) $port['utilization'] >= 80) $high_util_count++;
	}
	$toolbar = (new CDiv())->addClass('laka-toolbar')->addClass('laka-tab-section')->addClass('laka-section-interfaces');
	$filters = (new CDiv())->addClass('laka-filters');
	foreach (['all' => _('All'), 'up' => _('Connected'), 'down' => _('Disconnected'),
		'disabled' => _('Admin off'), 'unknown' => _('No data')] as $filter => $label) {
		$button = (new CTag('button', true, $label))->addClass('laka-filter')
			->setAttribute('type', 'button')->setAttribute('data-filter', $filter);
		if ($filter === 'all') $button->addClass('active');
		$filters->addItem($button);
	}
	$alerts = (new CDiv())->addClass('laka-alert-summary');
	foreach ([['problem', _('Problems'), $problem_count], ['error', _('Errors/discards'), $error_count],
		['util', _('High utilization'), $high_util_count]] as [$filter, $label, $count]) {
		$alerts->addItem((new CTag('button', true, $label.': '.$count))->addClass('laka-summary-filter')
			->addClass($filter)->setAttribute('type', 'button')->setAttribute('data-filter', $filter));
	}
	$toolbar->addItem($filters);
	$toolbar->addItem($alerts);
	$root->addItem($toolbar);
	$root->addItem((new CDiv(_('No interfaces match this filter.')))->addClass('laka-no-match')
		->addClass('laka-tab-section')->addClass('laka-section-interfaces'));

	$groups = [];
	foreach ($data['ports'] as $port) {
		$groups[(int) $port['member']][] = $port;
	}
	$ports_area = (new CDiv())->addClass('laka-ports-area');
	foreach ($groups as $member => $ports) {
		if ((int) $data['layout_mode'] === 2) {
			usort($ports, static function(array $a, array $b): int {
				$parity = (($a['physical_number'] + 1) % 2) <=> (($b['physical_number'] + 1) % 2);
				return $parity !== 0 ? $parity : ($a['physical_number'] <=> $b['physical_number']);
			});
		}
		$section = (new CDiv())->addClass('laka-sw-member')->addClass('laka-tab-section')->addClass('laka-section-overview');
		if (count($groups) > 1) {
			$section->addItem((new CDiv(sprintf(_('Stack member %d'), $member)))->addClass('laka-sw-member-title'));
		}
		$grid = (new CDiv())->addClass('laka-sw-grid')
			->setAttribute('style', '--cols:'.(int) $data['columns']);
		if ((int) $data['layout_mode'] === 0) $grid->addClass('auto');

		foreach ($ports as $port) {
			$util = $port['utilization'];
			$util_value = $util === null ? 0 : max(0, min(100, (float) $util));
			$errors = (float) ($port['errors_in'] ?? 0) + (float) ($port['errors_out'] ?? 0);
			$discards = (float) ($port['discards_in'] ?? 0) + (float) ($port['discards_out'] ?? 0);
			$problem_names = array_column($port['problems'], 'name');
			$status_text = strtoupper($port['status']);
			$title_lines = [
				$port['name'],
				(string) $port['alias'],
				'ifIndex: '.$port['index'],
				'Estado: '.$status_text,
				'Admin / Oper: '.(string) ($port['admin'] ?? 'n/a').' / '.(string) ($port['oper'] ?? 'n/a'),
				'Velocidad: '.$port['speed_text'],
				'IN / OUT: '.$port['in_text'].' / '.$port['out_text'],
				'Utilización: '.($util === null ? 'n/a' : number_format((float) $util, 1).'%'),
				'Errores / descartes: '.$errors.' / '.$discards
			];
			if (!empty($port['status_inferred'])) $title_lines[] = 'Estado inferido por tráfico reciente';
			if ($port['vlan'] !== null && $port['vlan'] !== '') $title_lines[] = 'VLAN: '.$port['vlan'];
			if ($port['poe_status'] !== null && $port['poe_status'] !== '') $title_lines[] = 'PoE: '.$port['poe_status'];
			if ($port['poe_power'] !== null && $port['poe_power'] !== '') {
				$title_lines[] = 'Potencia PoE: '.$port['poe_power'].' '.($port['poe_power_units'] ?? '');
			}
			if ($problem_names) $title_lines[] = 'Problemas: '.implode(' | ', $problem_names);
			$card = (new CDiv())->addClass('laka-port')->addClass($port['status']);
			if ($problem_names) $card->addClass('has-problem');
			if ($port['type'] === 'uplink') $card->addClass('uplink');
			$card
				->setAttribute('title', implode("\n", $title_lines))
				->setAttribute('data-hover-label', $port['name'].' · '.(trim((string) $port['alias']) ?: _('No description')))
				->setAttribute('data-name', $port['name'])
				->setAttribute('data-alias', (string) $port['alias'])
				->setAttribute('data-index', $port['index'])
				->setAttribute('data-status', $port['status'])
				->setAttribute('data-admin', (string) ($port['admin'] ?? 'n/a'))
				->setAttribute('data-oper', (string) ($port['oper'] ?? 'n/a'))
				->setAttribute('data-speed', $port['speed_text'])
				->setAttribute('data-in', $port['in_text'])
				->setAttribute('data-out', $port['out_text'])
				->setAttribute('data-util', $util === null ? 'n/a' : number_format((float) $util, 1).'%')
				->setAttribute('data-util-value', (string) $util_value)
				->setAttribute('data-errors', (string) $errors)
				->setAttribute('data-discards', (string) $discards)
				->setAttribute('data-has-problem', $problem_names ? '1' : '0')
				->setAttribute('data-problems', implode(' | ', $problem_names));
			$card->addItem((new CDiv())->addClass('laka-jack'));
			$card->addItem((new CSpan())->addClass('laka-led'));
			$display_port_name = in_array($data['port_visual_style'], [1, 2], true) && $port['physical_number'] !== PHP_INT_MAX
				? (string) $port['physical_number'] : $port['name'];
			$card->addItem((new CDiv($display_port_name))->addClass('laka-port-name'));
			if ($data['show_alias']) {
				$card->addItem((new CDiv(trim((string) $port['alias']) ?: '—'))->addClass('laka-port-alias'));
			}
			if ($data['show_utilization']) {
				$card->addItem((new CSpan($util === null ? '—' : number_format((float) $util, 0).'%'))
					->addClass('laka-port-util-label'));
			}
			$details = (new CDiv())->addClass('laka-port-data')
				->setAttribute('data-port-title', $port['name'])
				->setAttribute('data-port-subtitle', trim((string) $port['alias']) !== '' ? $port['alias'] : _('No alias'))
				->setAttribute('data-hostid', $port['hostid'])
				->setAttribute('data-in-key', (string) ($port['in_key'] ?? ''))
				->setAttribute('data-out-key', (string) ($port['out_key'] ?? ''))
				->setAttribute('data-in-itemid', (string) ($port['in_itemid'] ?? ''))
				->setAttribute('data-out-itemid', (string) ($port['out_itemid'] ?? ''));
			$table = (new CTag('table', true))->addClass('laka-detail-table');
			$thead = new CTag('thead', true);
			$header_row = new CTag('tr', true);
			foreach ([_('Name'), _('Last check'), _('Last value'), _('Change')] as $heading) {
				$header_row->addItem(new CTag('th', true, $heading));
			}
			$thead->addItem($header_row);
			$table->addItem($thead);
			$tbody = new CTag('tbody', true);
			foreach ($port['detail_rows'] as $detail) {
				$detail_row = new CTag('tr', true);
				$detail_row->addItem(new CTag('td', true, $detail['name']));
				$detail_row->addItem(new CTag('td', true, $detail['clock'] > 0 ? date('Y-m-d H:i:s', $detail['clock']) : 'n/a'));
				$detail_row->addItem(new CTag('td', true, $detail['value']));
				$detail_row->addItem(new CTag('td', true, $detail['change']));
				$tbody->addItem($detail_row);
			}
			$table->addItem($tbody);
			$details->addItem($table);
			$chart = (new CDiv())->addClass('laka-chart');
			$chart_head = (new CDiv())->addClass('laka-chart-title');
			$chart_head->addItem(new CSpan(_('Bandwidth consumption')));
			$periods = (new CDiv())->addClass('laka-chart-periods');
			foreach (['1h' => '1h', '6h' => '6h', '24h' => '24h', '7d' => '7d'] as $period => $label) {
				$period_button = (new CTag('button', true, $label))->addClass('laka-period-button')
					->setAttribute('type', 'button')->setAttribute('data-period', $period);
				if ($period === '1h') $period_button->addClass('active');
				$periods->addItem($period_button);
			}
			$chart_head->addItem($periods);
			$chart->addItem($chart_head);
			$chart->addItem((new CDiv((new CSpan(_('Loading history...')))))->addClass('laka-chart-stage')->addClass('laka-chart-loading-wrap'));
			$details->addItem($chart);
			if ($problem_names) $details->addItem((new CDiv(implode(' | ', $problem_names)))->addClass('laka-modal-problems'));
			$card->addItem($details);
			$bar = (new CSpan())->addClass('laka-util')->setAttribute('style', '--util:'.$util_value.'%');
			if ($util_value >= 80) $bar->addClass('high'); elseif ($util_value >= 60) $bar->addClass('warn');
			$card->addItem($bar);
			$grid->addItem($card);
		}
		$section->addItem($grid);
			$ports_area->addItem($section);
		}
		$root->addItem($ports_area);

		$device_endpoints = array_values(array_filter($widget_data['topology_endpoints'] ?? [],
			static fn(array $endpoint): bool => (string) ($endpoint['parent'] ?? '') === (string) $host['hostid']));
		$device_links = array_values(array_filter($widget_data['topology_links'] ?? [],
			static fn(array $link): bool => (string) ($link['a'] ?? '') === (string) $host['hostid']
				|| (string) ($link['b'] ?? '') === (string) $host['hostid']));
		$host_names = [];
		foreach ($topology_hosts as $topology_host) $host_names[(string) $topology_host['id']] = $topology_host['name'];
		$device_topology = (new CDiv())->addClass('laka-topology')->addClass('laka-device-topology')
			->addClass('laka-tab-section')->addClass('laka-section-overview')
			->setAttribute('data-current-hostid', (string) $host['hostid'])
			->setAttribute('data-scope-hostid', (string) $host['hostid'])
			->setAttribute('data-map-mode', 'both')
			->setAttribute('data-can-manage', '0')
			->setAttribute('data-hosts', json_encode($topology_hosts, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE))
			->setAttribute('data-links', json_encode($device_links, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE))
			->setAttribute('data-endpoints', json_encode($device_endpoints, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE))
			->setAttribute('data-endpoint-hosts', json_encode([(string) $host['hostid']]));
		$device_topology_head = (new CDiv())->addClass('laka-topology-head');
		$device_topology_heading = (new CDiv())->addClass('laka-topology-heading');
		$device_topology_heading->addItem((new CDiv(_('Equipment connectivity map')))->addClass('laka-topology-title'));
		$device_topology_heading->addItem((new CDiv(_('Discovered endpoints and interconnections · Drag background to move · Resize from lower corner')))->addClass('laka-topology-subtitle'));
		$device_topology_head->addItem($device_topology_heading);
		$device_topology_actions = (new CDiv())->addClass('laka-topology-actions');
		foreach ([['endpoints', _('Endpoints')], ['links', _('Interconnections')], ['both', _('Both')]] as [$mode, $label]) {
			$mode_button = (new CTag('button', true, $label))->addClass('laka-topology-button')->addClass('laka-map-mode')
				->setAttribute('type', 'button')->setAttribute('data-local-map-mode', $mode);
			if ($mode === 'both') $mode_button->addClass('active');
			$device_topology_actions->addItem($mode_button);
		}
		foreach ([['out', '−', _('Zoom out')], ['in', '+', _('Zoom in')], ['reset', '1:1', _('Reset zoom')], ['fit', _('Fit'), _('Fit map')]] as [$action, $label, $title]) {
			$device_topology_actions->addItem((new CTag('button', true, $label))->addClass('laka-topology-button')
				->setAttribute('type', 'button')->setAttribute('title', $title)->setAttribute('data-topology-zoom', $action));
		}
		$device_topology_head->addItem($device_topology_actions);
		$device_topology->addItem($device_topology_head);
		$device_topology->addItem((new CDiv())->addClass('laka-topology-stage'));
		$device_topology_legend = (new CDiv())->addClass('laka-topology-legend');
		foreach (['up' => _('Operational'), 'warning' => _('Warning'), 'down' => _('Down'), 'unknown' => _('No data')] as $class => $label) {
			$device_topology_legend->addItem((new CSpan($label))->addClass($class));
		}
		$device_topology->addItem($device_topology_legend);
		$root->addItem($device_topology);

		if ($data['show_hardware_health']) {
			$sensors = $data['hardware_sensors'];
			$health_counts = ['ok' => 0, 'warning' => 0, 'critical' => 0, 'unknown' => 0];
			foreach ($sensors as $sensor) $health_counts[$sensor['health']]++;
			$hardware = (new CDiv())->addClass('laka-hardware')->addClass('laka-tab-section')->addClass('laka-section-hardware');
			$hardware_head = (new CDiv())->addClass('laka-hardware-head');
			$hardware_head->addItem((new CSpan(_('Hardware health')))->addClass('laka-hardware-title'));
			$hardware_head->addItem((new CSpan(
				$health_counts['ok'].' '._('OK').' · '.$health_counts['warning'].' '._('warning').' · '.
				$health_counts['critical'].' '._('critical').' · '.$health_counts['unknown'].' '._('no data')
			))->addClass('laka-hardware-counts'));
			$hardware->addItem($hardware_head);
			if (!$sensors) {
				$hardware->addItem((new CDiv(_('No temperature, fan, PSU or additional sensors matched the configured expressions.')))
					->addClass('laka-sensor-empty'));
			}
			else {
				$type_labels = ['temperature' => _('Temperature'), 'fan' => _('Fan'), 'psu' => _('Power supply'), 'other' => _('Sensor')];
				$grouped_sensors = ['temperature' => [], 'fan' => [], 'psu' => [], 'other' => []];
				foreach ($sensors as $sensor) $grouped_sensors[$sensor['type'] ?? 'other'][] = $sensor;
				foreach ($grouped_sensors as $sensor_type => $component_sensors) {
					if (!$component_sensors) continue;
					usort($component_sensors, static fn(array $a, array $b): int => strnatcasecmp($a['name'], $b['name']));
					$component_group = (new CDiv())->addClass('laka-sensor-group')->addClass('type-'.$sensor_type);
					$component_head = (new CDiv())->addClass('laka-sensor-group-head');
					$component_head->addItem((new CSpan($type_labels[$sensor_type] ?? _('Sensor')))->addClass('laka-sensor-group-title'));
					$component_head->addItem((new CSpan((string) count($component_sensors)))->addClass('laka-sensor-group-count'));
					$component_group->addItem($component_head);
					$sensor_grid = (new CDiv())->addClass('laka-sensor-grid');
					foreach ($component_sensors as $sensor) {
					$sensor_card = (new CDiv())->addClass('laka-sensor-card')->addClass($sensor['health'])
						->setAttribute('data-itemid', $sensor['itemid'])
						->setAttribute('data-numeric', $sensor['numeric'] ? '1' : '0')
						->setAttribute('data-name', $sensor['name'])->setAttribute('data-key', $sensor['key'])
						->setAttribute('data-value', $sensor['value'].' '.$sensor['units'])
						->setAttribute('data-clock', $sensor['clock'] > 0 ? date('Y-m-d H:i:s', $sensor['clock']) : 'N/D')
						->setAttribute('data-problems', implode(' | ', array_column($sensor['problems'], 'name')));
					$sensor_card->addItem((new CSpan())->addClass('laka-sensor-state'));
					$sensor_card->addItem((new CDiv($type_labels[$sensor['type']] ?? _('Sensor')))->addClass('laka-sensor-type'));
					$sensor_card->addItem((new CDiv($sensor['name']))->addClass('laka-sensor-name'));
					$sensor_card->addItem((new CDiv(trim($sensor['value'].' '.$sensor['units'])))->addClass('laka-sensor-value'));
					$sensor_card->addItem((new CDiv($sensor['clock'] > 0 ? date('Y-m-d H:i:s', $sensor['clock']) : 'N/D'))
						->addClass('laka-sensor-clock'));
					$sensor_grid->addItem($sensor_card);
					}
					$component_group->addItem($sensor_grid);
					$hardware->addItem($component_group);
				}
			}
			$root->addItem($hardware);
		}

		if ($data['show_featured_charts']) {
			$featured = (new CDiv())->addClass('laka-featured')->addClass('laka-tab-section')->addClass('laka-section-consumption')
				->setAttribute('data-default-period', $data['featured_chart_period'])
				->setAttribute('data-selection-key', 'laka-featured-interfaces-'.$host['hostid'])
				->setAttribute('data-max-charts', (string) $data['featured_chart_limit']);
			$featured_candidates = [];
			foreach ($data['ports'] as $port) {
				$in_itemid = (string) ($port['in_itemid'] ?? '');
				$out_itemid = (string) ($port['out_itemid'] ?? '');
				if (!ctype_digit($in_itemid) && !ctype_digit($out_itemid)) continue;
				$featured_candidates[] = $port;
			}
			$default_candidates = array_values(array_filter($featured_candidates,
				static fn(array $port): bool => $port['status'] === 'up'));
			if (!$default_candidates) $default_candidates = $featured_candidates;
			$default_selection = $default_candidates ? [(string) $default_candidates[0]['index']] : [];
			$featured->setAttribute('data-default-selection', json_encode($default_selection));
			$featured_head = (new CDiv())->addClass('laka-featured-head');
			$featured_heading = new CDiv();
			$featured_heading->addItem((new CDiv(_('Featured interface consumption')))->addClass('laka-featured-title'));
			$featured_heading->addItem((new CDiv(_('Inbound and outbound traffic for selected switch ports')))->addClass('laka-featured-subtitle'));
			$featured_head->addItem($featured_heading);
			$featured_periods = (new CDiv())->addClass('laka-featured-periods');
			foreach (['1h', '6h', '12h', '24h', '7d'] as $period) {
				$period_button = (new CTag('button', true, $period))->addClass('laka-featured-period')
					->setAttribute('type', 'button')->setAttribute('data-period', $period);
				if ($period === $data['featured_chart_period']) $period_button->addClass('active');
				$featured_periods->addItem($period_button);
			}
			$head_actions = (new CDiv())->addClass('laka-featured-head-actions');
			$head_actions->addItem($featured_periods);
			$head_actions->addItem((new CTag('button', true, _('Configure interfaces')))
				->addClass('laka-featured-config-toggle')->setAttribute('type', 'button'));
			$featured_head->addItem($head_actions);
			$featured->addItem($featured_head);
			$picker = (new CDiv())->addClass('laka-featured-picker');
			$picker_head = (new CDiv())->addClass('laka-featured-picker-head');
			$picker_head->addItem(new CSpan(_('Select the interfaces to graph for this equipment. The selection is independent for each switch.')));
			$picker_head->addItem((new CTag('button', true, _('Clear selection')))->addClass('laka-featured-clear')
				->setAttribute('type', 'button'));
			$picker->addItem($picker_head);
			$options = (new CDiv())->addClass('laka-featured-options');
			foreach ($featured_candidates as $port) {
				$options->addItem((new CTag('button', true, $port['name'].(trim((string) $port['alias']) !== '' ? ' · '.$port['alias'] : '')))
					->addClass('laka-featured-port-option')->setAttribute('type', 'button')
					->setAttribute('data-interface-key', (string) $port['index']));
			}
			$picker->addItem($options);
			$featured->addItem($picker);
			$featured_list = (new CDiv())->addClass('laka-featured-list');
			foreach ($featured_candidates as $port) {
				$in_itemid = (string) ($port['in_itemid'] ?? '');
				$out_itemid = (string) ($port['out_itemid'] ?? '');
				$card = (new CDiv())->addClass('laka-featured-card')
					->setAttribute('data-in-itemid', $in_itemid)->setAttribute('data-out-itemid', $out_itemid)
					->setAttribute('data-interface-key', (string) $port['index'])
					->setAttribute('style', '--chart-height:'.$data['featured_chart_height'].'px');
				$card_head = (new CDiv())->addClass('laka-featured-card-head');
				$identity = new CDiv();
				$identity->addItem((new CDiv($port['name']))->addClass('laka-featured-name'));
				$identity->addItem((new CDiv(trim((string) $port['alias']) ?: _('No description')))->addClass('laka-featured-alias'));
				$card_head->addItem($identity);
				$card_head->addItem((new CSpan(strtoupper($port['status'])))->addClass('laka-featured-state')
					->addClass($port['status'] === 'up' ? '' : 'down'));
				$card->addItem($card_head);
				$values = (new CDiv())->addClass('laka-featured-values');
				$values->addItem((new CSpan('IN ↓ '.$port['in_text']))->addClass('laka-featured-in'));
				$values->addItem((new CSpan('OUT ↑ '.$port['out_text']))->addClass('laka-featured-out'));
				$values->addItem((new CSpan($port['utilization'] === null ? '—' : number_format((float) $port['utilization'], 1).'%'))
					->addClass('laka-featured-util'));
				$card->addItem($values);
				$card->addItem((new CDiv((new CSpan(_('Loading chart...')))->addClass('laka-featured-loading')))
					->addClass('laka-featured-chart'));
				$foot = (new CDiv())->addClass('laka-featured-foot');
				$foot->addItem(new CSpan(_('Capacity').': '.$port['speed_text']));
				$foot->addItem(new CSpan(_('Errors/discards').': '.number_format(
					(float) ($port['errors_in'] ?? 0) + (float) ($port['errors_out'] ?? 0)
					+ (float) ($port['discards_in'] ?? 0) + (float) ($port['discards_out'] ?? 0), 0
				)));
				$card->addItem($foot);
				$featured_list->addItem($card);
			}
			$featured_list->addItem((new CDiv($featured_candidates
				? _('No interfaces selected. Use Configure interfaces to choose them for this switch.')
				: _('No interfaces with traffic items are available.')))->addClass('laka-featured-config-empty'));
			$featured->addItem($featured_list);
			$root->addItem($featured);
		}

		$list_panel = (new CDiv())->addClass('laka-interface-panel')->addClass('laka-tab-section')->addClass('laka-section-interfaces')
		->setAttribute('style', '--list-height:'.(24 + $data['interface_list_rows'] * 23).'px')
		->setAttribute('data-storage-key', 'laka-interface-list-'.$host['hostid'])
		->setAttribute('data-default-expanded', $data['interface_list_default'] ? '1' : '0');
	if (!$data['interface_list_default']) $list_panel->addClass('collapsed');
	$list_head = (new CDiv())->addClass('laka-interface-panel-head');
	$list_head->addItem((new CSpan(_('Interface list').' · '.count($data['ports'])))->addClass('laka-interface-panel-title'));
	$list_actions = (new CDiv())->addClass('laka-interface-head-actions');
	$list_actions->addItem((new CSpan(
		$status_counts['up'].' '._('UP').' · '.$status_counts['down'].' '._('DOWN').' · '.
		$status_counts['disabled'].' '._('ADMIN OFF')
	))->addClass('laka-interface-counts'));
	$toggle = (new CTag('button', true))->addClass('laka-interface-toggle')
		->setAttribute('type', 'button')->setAttribute('aria-expanded', $data['interface_list_default'] ? 'true' : 'false')
		->setAttribute('title', _('Show or hide interface list'));
	$toggle->addItem((new CSpan('▴'))->addClass('laka-interface-toggle-icon'));
	$list_actions->addItem($toggle);
	$list_head->addItem($list_actions);
	$list_panel->addItem($list_head);
	$list_body = (new CDiv())->addClass('laka-interface-body');
	$list_tools = (new CDiv())->addClass('laka-interface-tools');
	$list_tools->addItem((new CTag('input', false))->addClass('laka-interface-search')
		->setAttribute('type', 'search')->setAttribute('placeholder', _('Search port or description...'))
		->setAttribute('aria-label', _('Search interfaces')));
	$list_tools->addItem((new CSpan(count($data['ports']).' '._('interfaces')))->addClass('laka-interface-search-result'));
	$list_body->addItem($list_tools);
	$scroll = (new CDiv())->addClass('laka-interface-scroll');
	$list = (new CTag('table', true))->addClass('laka-interface-table');
	$thead = new CTag('thead', true);
	$head_row = new CTag('tr', true);
	foreach ([['name', _('Port')], ['alias', _('Description')], ['status', _('Status')],
		['speed', _('Speed')], ['in', _('Traffic IN')], ['out', _('Traffic OUT')],
		['util', _('Use')], ['errors', _('Errors')]] as [$sort_key, $heading]) {
		$th = new CTag('th', true);
		$button = (new CTag('button', true, $heading))->addClass('laka-sort-button')
			->setAttribute('type', 'button')->setAttribute('data-sort', $sort_key);
		if ($sort_key === 'name') {
			$button->addClass('active');
			$button->addItem((new CSpan('▲'))->addClass('laka-sort-indicator'));
		}
		$th->addItem($button);
		$head_row->addItem($th);
	}
	$thead->addItem($head_row);
	$list->addItem($thead);
	$tbody = new CTag('tbody', true);
	$status_labels = ['up' => _('Connected'), 'down' => _('Disconnected'),
		'disabled' => _('Admin off'), 'unknown' => _('No data')];
	foreach ($data['ports'] as $port) {
		$util = $port['utilization'];
		$util_value = $util === null ? 0 : max(0, min(100, (float) $util));
		$errors = (float) ($port['errors_in'] ?? 0) + (float) ($port['errors_out'] ?? 0)
			+ (float) ($port['discards_in'] ?? 0) + (float) ($port['discards_out'] ?? 0);
		$row = (new CTag('tr', true))->addClass('laka-interface-row')->addClass($port['status'])
			->setAttribute('data-index', (string) $port['index'])
			->setAttribute('data-status', $port['status'])
			->setAttribute('data-has-problem', $port['problems'] ? '1' : '0')
			->setAttribute('data-errors', (string) $errors)
			->setAttribute('data-util-value', (string) $util_value)
			->setAttribute('data-name', strtolower($port['name']))
			->setAttribute('data-alias', strtolower(trim((string) $port['alias'])))
			->setAttribute('data-speed-sort', is_numeric($port['speed'] ?? null) ? (string) $port['speed'] : '0')
			->setAttribute('data-in-sort', is_numeric($port['in'] ?? null) ? (string) $port['in'] : '0')
			->setAttribute('data-out-sort', is_numeric($port['out'] ?? null) ? (string) $port['out'] : '0')
			->setAttribute('title', $port['name'].' · '.(trim((string) $port['alias']) ?: _('No description')));
		$row->addItem((new CTag('td', true, $port['name']))->addClass('laka-interface-name'));
		$row->addItem((new CTag('td', true, trim((string) $port['alias']) ?: '—'))->addClass('laka-interface-description'));
		$status_cell = (new CTag('td', true))->addClass('laka-interface-status');
		$status_cell->addItem((new CSpan())->addClass('laka-row-dot'));
		$status_cell->addItem($status_labels[$port['status']] ?? strtoupper($port['status']));
		$row->addItem($status_cell);
		$row->addItem((new CTag('td', true, $port['speed_text']))->addClass('laka-interface-speed'));
		$row->addItem((new CTag('td', true, $port['in_text']))->addClass('laka-interface-traffic'));
		$row->addItem((new CTag('td', true, $port['out_text']))->addClass('laka-interface-traffic'));
		$util_cell = (new CTag('td', true))->addClass('laka-interface-util');
		$meter = (new CSpan())->addClass('laka-mini-meter');
		$meter_bar = (new CSpan())->setAttribute('style', '--util:'.$util_value.'%');
		if ($util_value >= 80) $meter_bar->addClass('high'); elseif ($util_value >= 60) $meter_bar->addClass('warn');
		$meter->addItem($meter_bar);
		$util_cell->addItem($meter);
		$util_cell->addItem($util === null ? '—' : number_format((float) $util, 0).'%');
		$row->addItem($util_cell);
		$error_cell = (new CTag('td', true, number_format($errors, 0)))->addClass('laka-interface-errors');
		if ($errors > 0) $error_cell->addClass('has-errors');
		$row->addItem($error_cell);
		$tbody->addItem($row);
	}
	$list->addItem($tbody);
	$scroll->addItem($list);
	$list_body->addItem($scroll);
	$list_panel->addItem($list_body);
	$root->addItem($list_panel);
}
		$pane = (new CDiv($root))->addClass('laka-device-pane')
			->setAttribute('data-hostid', $device['host']['hostid']);
		if ($device_index === 0) $pane->addClass('active');
		$main->addItem($pane);
	}
	$console->addItem($main);
}

(new CWidgetView($widget_data))
	->addItem(new CTag('style', true, $css))
	->addItem($console)
	->show();
