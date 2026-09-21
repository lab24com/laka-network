class CWidgetLakaNetworkSwitch extends CWidget {

	onStart() {
		this._events = {
			...this._events,
			port_click: event => {
				if (this._suppressTopologyClick) {
					this._suppressTopologyClick = false;
					return;
				}
				const portLayout = event.target.closest('[data-port-layout]');
				if (portLayout !== null && this._target.contains(portLayout)) {
					this._setPortLayout(portLayout);
					return;
				}
				const zoomControl = event.target.closest('[data-topology-zoom]');
				if (zoomControl !== null && this._target.contains(zoomControl)) {
					this._applyTopologyZoom(zoomControl.closest('.laka-topology'), zoomControl.dataset.topologyZoom || 'reset');
					return;
				}
				const mapMode = event.target.closest('[data-local-map-mode]');
				if (mapMode !== null && this._target.contains(mapMode)) {
					this._setLocalMapMode(mapMode);
					return;
				}
				const inspectedNode = event.target.closest('[data-topology-endpoint],[data-topology-inspect-host]');
				if (inspectedNode !== null && this._target.contains(inspectedNode)) {
					this._openTopologyNodeModal(inspectedNode);
					return;
				}
				const endpointChoice = event.target.closest('[data-topology-endpoint-host],[data-topology-endpoint-action]');
				if (endpointChoice !== null && this._target.contains(endpointChoice)) {
					this._selectTopologyEndpoints(endpointChoice);
					return;
				}
				const neighborHead = event.target.closest('.laka-neighbor-head');
				if (neighborHead !== null && this._target.contains(neighborHead)) {
					this._toggleNeighborPanel(neighborHead.closest('.laka-neighbor-panel'));
					return;
				}
				const neighborLink = event.target.closest('.laka-neighbor-row[data-neighbor-hostid]');
				if (neighborLink !== null && this._target.contains(neighborLink)) {
					this._selectDevice(neighborLink.dataset.neighborHostid || '');
					return;
				}
				const topologyNav = event.target.closest('.laka-topology-nav');
				if (topologyNav !== null && this._target.contains(topologyNav)) {
					this._showGlobalTopology(true);
					return;
				}
				const topologyAction = event.target.closest('[data-topology-action]');
				if (topologyAction !== null && this._target.contains(topologyAction)) {
					this._handleTopologyAction(topologyAction);
					return;
				}
				const topologyEdge = event.target.closest('[data-topology-link]');
				if (topologyEdge !== null && this._target.contains(topologyEdge)) {
					this._selectTopologyLink(topologyEdge.closest('.laka-topology'), topologyEdge.dataset.topologyLink || '');
					return;
				}
				const topologyNode = event.target.closest('[data-topology-host]');
				if (topologyNode !== null && this._target.contains(topologyNode)) {
					this._selectDevice(topologyNode.dataset.topologyHost || '');
					return;
				}
				const featuredConfig = event.target.closest('.laka-featured-config-toggle');
				if (featuredConfig !== null && this._target.contains(featuredConfig)) {
					const panel = featuredConfig.closest('.laka-featured');
					panel.classList.toggle('config-open');
					featuredConfig.classList.toggle('active', panel.classList.contains('config-open'));
					return;
				}
				const featuredOption = event.target.closest('.laka-featured-port-option');
				if (featuredOption !== null && this._target.contains(featuredOption)) {
					this._toggleFeaturedInterface(featuredOption);
					return;
				}
				const featuredClear = event.target.closest('.laka-featured-clear');
				if (featuredClear !== null && this._target.contains(featuredClear)) {
					this._setFeaturedSelection(featuredClear.closest('.laka-featured'), [], true);
					return;
				}
				const viewTab = event.target.closest('.laka-view-tab');
				if (viewTab !== null && this._target.contains(viewTab)) {
					this._selectViewTab(viewTab);
					return;
				}
				const sensor = event.target.closest('.laka-sensor-card');
				if (sensor !== null && this._target.contains(sensor)) {
					this._openSensorModal(sensor);
					return;
				}
				const featuredPeriod = event.target.closest('.laka-featured-period');
				if (featuredPeriod !== null && this._target.contains(featuredPeriod)) {
					const panel = featuredPeriod.closest('.laka-featured');
					for (const button of panel.querySelectorAll('.laka-featured-period')) button.classList.remove('active');
					featuredPeriod.classList.add('active');
					panel.dataset.defaultPeriod = featuredPeriod.dataset.period || '12h';
					this._loadFeaturedCharts(panel.closest('.laka-device-pane'), true);
					return;
				}
				const navToggle = event.target.closest('.laka-nav-toggle');
				if (navToggle !== null && this._target.contains(navToggle)) {
					this._toggleDeviceNavigation(navToggle);
					return;
				}
				const deviceFilter = event.target.closest('.laka-nav-filter');
				if (deviceFilter !== null && this._target.contains(deviceFilter)) {
					this._filterDevices(deviceFilter.dataset.deviceFilter || 'all', deviceFilter);
					return;
				}
				const device = event.target.closest('.laka-device-button');
				if (device !== null && this._target.contains(device)) {
					this._selectDevice(device.dataset.hostid || '');
					return;
				}
				const toggle = event.target.closest('.laka-interface-toggle');
				if (toggle !== null && this._target.contains(toggle)) {
					this._toggleInterfaceList(toggle);
					return;
				}
				const sort = event.target.closest('.laka-sort-button');
				if (sort !== null && this._target.contains(sort)) {
					this._sortInterfaceList(sort);
					return;
				}
				const filter = event.target.closest('[data-filter]');
				if (filter !== null && this._target.contains(filter)) {
					this._applyPortFilter(filter.dataset.filter || 'all', filter);
					return;
				}
				const listRow = event.target.closest('.laka-interface-row');
				if (listRow !== null && this._target.contains(listRow)) {
					const port = this._findPortByIndex(listRow.dataset.index || '', listRow.closest('.laka-device-pane'));
					const data = port?.querySelector('.laka-port-data');
					if (data !== null && data !== undefined) this._openPortModal(data);
					return;
				}
				const port = event.target.closest('.laka-port');
				if (port === null || !this._target.contains(port)) return;
				const data = port.querySelector('.laka-port-data');
				if (data !== null) this._openPortModal(data);
			},
			interface_hover: event => {
				const row = event.target.closest('.laka-interface-row,.laka-neighbor-row[data-port-reference]');
				if (row === null || !this._target.contains(row)) return;
				const port = this._findPortByReference(row.dataset.index || row.dataset.portReference || '', row.closest('.laka-device-pane'));
				if (port === null) return;
				if (event.type === 'mouseover') {
					row.classList.add('linked-hover');
					port.classList.add('linked-hover');
				}
				else if (!row.contains(event.relatedTarget)) {
					row.classList.remove('linked-hover');
					port.classList.remove('linked-hover');
				}
			},
			interface_search: event => {
				if (event.target.matches('.laka-interface-search')) this._searchInterfaceList(event.target);
				else if (event.target.matches('.laka-device-search')) this._searchDevices(event.target);
			},
			modal_click: event => {
				const openNeighbor = event.target.closest('.laka-neighbor-open[data-hostid]');
				if (openNeighbor !== null && this._modal !== null && this._modal.contains(openNeighbor)) {
					const hostid = openNeighbor.dataset.hostid || '';
					this._closePortModal();
					this._selectDevice(hostid);
					return;
				}
				const sensorPeriod = event.target.closest('.laka-sensor-period-button');
				if (sensorPeriod !== null && this._modal !== null && this._modal.contains(sensorPeriod)) {
					for (const button of this._modal.querySelectorAll('.laka-sensor-period-button')) button.classList.remove('active');
					sensorPeriod.classList.add('active');
					this._loadSensorChart(this._activeSensorData, this._modal.querySelector('.laka-modal-box'), sensorPeriod.dataset.period || '24h');
					return;
				}
				const period = event.target.closest('.laka-period-button');
				if (period !== null && this._modal !== null && this._modal.contains(period)) {
					for (const button of this._modal.querySelectorAll('.laka-period-button')) button.classList.remove('active');
					period.classList.add('active');
					this._loadNativeChart(this._activePortData, this._modal.querySelector('.laka-modal-box'), period.dataset.period || '1h');
					return;
				}
				if (event.target === this._modal || event.target.closest('.laka-modal-close') !== null) {
					this._closePortModal();
				}
			},
			modal_keydown: event => {
				if (event.key === 'Escape') this._closePortModal();
			},
			topology_pointerdown: event => this._startTopologyPan(event),
			topology_pointermove: event => this._moveTopologyPan(event),
			topology_pointerup: event => this._endTopologyPan(event)
		};
	}

	onActivate() {
		this._applyZabbixTheme();
		this._target.addEventListener('click', this._events.port_click);
		this._target.addEventListener('mouseover', this._events.interface_hover);
		this._target.addEventListener('mouseout', this._events.interface_hover);
		this._target.addEventListener('input', this._events.interface_search);
		this._target.addEventListener('pointerdown', this._events.topology_pointerdown);
		this._target.addEventListener('pointermove', this._events.topology_pointermove);
		this._target.addEventListener('pointerup', this._events.topology_pointerup);
		this._target.addEventListener('pointercancel', this._events.topology_pointerup);
		this._restoreDeviceNavigation();
		this._restoreSelectedDevice();
		this._restoreViewTabs();
		this._restoreFeaturedSelections();
		this._restoreInterfaceListState();
		this._restoreNeighborPanels();
		this._restoreLocalMapModes();
		this._restorePortLayouts();
		this._restoreTopologyStageSizes();
		for (const panel of this._target.querySelectorAll('.laka-device-topology')) this._renderTopology(panel);
		this._observeFeaturedCharts();
		this._loadFeaturedCharts(this._target.querySelector('.laka-device-pane.active'));
	}

	onDeactivate() {
		this._target.removeEventListener('click', this._events.port_click);
		this._target.removeEventListener('mouseover', this._events.interface_hover);
		this._target.removeEventListener('mouseout', this._events.interface_hover);
		this._target.removeEventListener('input', this._events.interface_search);
		this._target.removeEventListener('pointerdown', this._events.topology_pointerdown);
		this._target.removeEventListener('pointermove', this._events.topology_pointermove);
		this._target.removeEventListener('pointerup', this._events.topology_pointerup);
		this._target.removeEventListener('pointercancel', this._events.topology_pointerup);
		if (this._featuredResizeObserver) this._featuredResizeObserver.disconnect();
		clearTimeout(this._featuredResizeTimer);
		this._closePortModal();
	}

	_applyZabbixTheme() {
		const host = this._target.closest('.dashboard-widget') || this._target.parentElement || document.body;
		const candidates = [host, host?.parentElement, document.body].filter(Boolean);
		let background = '';
		let foreground = '';
		for (const element of candidates) {
			const style = getComputedStyle(element);
			if (!foreground && style.color) foreground = style.color;
			if (!background && style.backgroundColor && !/rgba?\(0,\s*0,\s*0,\s*0\)/.test(style.backgroundColor)) {
				background = style.backgroundColor;
			}
		}
		const channels = (background.match(/[\d.]+/g) || []).slice(0, 3).map(Number);
		const luminance = channels.length === 3
			? (channels[0] * .2126 + channels[1] * .7152 + channels[2] * .0722) / 255 : 0;
		this._themeClass = luminance > .55 ? 'laka-theme-light' : 'laka-theme-dark';
		this._target.classList.remove('laka-theme-light', 'laka-theme-dark');
		this._target.classList.add(this._themeClass);
		this._target.style.setProperty('--laka-zbx-bg', background || (luminance > .55 ? '#ffffff' : '#111820'));
		this._target.style.setProperty('--laka-zbx-text', foreground || (luminance > .55 ? '#1f2d38' : '#dce6f1'));
	}

	_applyModalTheme() {
		if (this._modal === null) return;
		this._modal.classList.remove('laka-theme-light', 'laka-theme-dark');
		this._modal.classList.add(this._themeClass || 'laka-theme-dark');
	}

	_topologyStageKey(stage) {
		return `laka-topology-height-${stage.closest('.laka-topology')?.dataset.scopeHostid || 'global'}`;
	}

	_topologyPositionKey(stage) {
		return `laka-topology-position-${stage.closest('.laka-topology')?.dataset.scopeHostid || 'global'}`;
	}

	_restoreTopologyStageSizes() {
		for (const stage of this._target.querySelectorAll('.laka-topology-stage')) {
			try {
				const height = Number(localStorage.getItem(this._topologyStageKey(stage)));
				if (height >= 220 && height <= 1400) stage.style.height = `${height}px`;
			}
			catch (error) {}
		}
	}

	_restoreTopologyPosition(stage) {
		try {
			const position = JSON.parse(localStorage.getItem(this._topologyPositionKey(stage)) || '{}');
			if (Number.isFinite(position.left) && Number.isFinite(position.top)) {
				stage.scrollLeft = Math.max(0, position.left);
				stage.scrollTop = Math.max(0, position.top);
			}
		}
		catch (error) {}
	}

	_restorePortLayouts() {
		for (const root of this._target.querySelectorAll('.laka-sw[data-hostid]')) {
			let mode = 'expanded';
			try { mode = localStorage.getItem(`laka-port-layout-${root.dataset.hostid}`) || mode; }
			catch (error) {}
			this._applyPortLayout(root, ['docked', 'expanded', 'collapsed'].includes(mode) ? mode : 'expanded');
		}
	}

	_setPortLayout(button) {
		const root = button.closest('.laka-sw');
		if (root === null) return;
		const mode = button.dataset.portLayout || 'expanded';
		this._applyPortLayout(root, mode);
		try { localStorage.setItem(`laka-port-layout-${root.dataset.hostid || ''}`, mode); }
		catch (error) {}
		setTimeout(() => this._renderTopology(root.querySelector('.laka-device-topology')), 220);
	}

	_applyPortLayout(root, mode) {
		root.classList.toggle('ports-docked', mode === 'docked');
		root.classList.toggle('ports-expanded', mode === 'expanded');
		root.classList.toggle('ports-collapsed', mode === 'collapsed');
		for (const button of root.querySelectorAll('[data-port-layout]')) {
			button.classList.toggle('active', button.dataset.portLayout === mode);
		}
	}

	_startTopologyPan(event) {
		const stage = event.target.closest('.laka-topology-stage');
		if (stage === null || !this._target.contains(stage) || event.button !== 0
				|| event.target.closest('.laka-topology-node,[data-topology-link]') !== null) return;
		const box = stage.getBoundingClientRect();
		if (box.right - event.clientX < 22 && box.bottom - event.clientY < 22) return;
		this._topologyPan = {stage, pointerId: event.pointerId, x: event.clientX, y: event.clientY,
			left: stage.scrollLeft, top: stage.scrollTop, moved: false};
		stage.classList.add('panning');
		stage.setPointerCapture?.(event.pointerId);
		event.preventDefault();
	}

	_moveTopologyPan(event) {
		const pan = this._topologyPan;
		if (!pan || pan.pointerId !== event.pointerId) return;
		const dx = event.clientX - pan.x, dy = event.clientY - pan.y;
		if (Math.abs(dx) + Math.abs(dy) > 4) pan.moved = true;
		pan.stage.scrollLeft = pan.left - dx;
		pan.stage.scrollTop = pan.top - dy;
		event.preventDefault();
	}

	_endTopologyPan(event) {
		const pan = this._topologyPan;
		if (!pan || pan.pointerId !== event.pointerId) return;
		pan.stage.classList.remove('panning');
		pan.stage.releasePointerCapture?.(event.pointerId);
		this._suppressTopologyClick = pan.moved;
		if (pan.moved) {
			try { localStorage.setItem(this._topologyPositionKey(pan.stage), JSON.stringify({
				left: Math.round(pan.stage.scrollLeft), top: Math.round(pan.stage.scrollTop)
			})); }
			catch (error) {}
		}
		this._topologyPan = null;
	}

	_findPortByIndex(index, scope = null) {
		for (const port of (scope || this._target).querySelectorAll('.laka-port')) {
			if (port.dataset.index === index) return port;
		}
		return null;
	}

	_findPortByReference(reference, scope = null) {
		const wanted = String(reference || '').trim().toLowerCase();
		for (const port of (scope || this._target).querySelectorAll('.laka-port')) {
			if (String(port.dataset.index || '').toLowerCase() === wanted
					|| String(port.dataset.name || '').toLowerCase() === wanted) return port;
		}
		return null;
	}

	_restoreDeviceNavigation() {
		const console = this._target.querySelector('.laka-console');
		if (console === null) return;
		let collapsed = false;
		try { collapsed = localStorage.getItem(`${console.dataset.consoleKey}-nav`) === 'collapsed'; }
		catch (error) {}
		this._setDeviceNavigation(console, collapsed);
	}

	_toggleDeviceNavigation(toggle) {
		const console = toggle.closest('.laka-console');
		if (console === null) return;
		const collapsed = !console.classList.contains('nav-collapsed');
		this._setDeviceNavigation(console, collapsed);
		try { localStorage.setItem(`${console.dataset.consoleKey}-nav`, collapsed ? 'collapsed' : 'expanded'); }
		catch (error) {}
	}

	_setDeviceNavigation(console, collapsed) {
		console.classList.toggle('nav-collapsed', collapsed);
		const toggle = console.querySelector('.laka-nav-toggle');
		if (toggle !== null) {
			toggle.textContent = collapsed ? '≫' : '≪';
			toggle.title = collapsed ? 'Mostrar menú de equipos' : 'Ocultar menú de equipos';
		}
	}

	_filterDevices(filter, source) {
		const nav = source.closest('.laka-device-nav');
		if (nav === null) return;
		for (const button of nav.querySelectorAll('.laka-nav-filter')) button.classList.remove('active');
		source.classList.add('active');
		for (const device of nav.querySelectorAll('.laka-device-button')) {
			const health = device.dataset.health || 'unknown';
			const show = filter === 'all'
				|| filter === 'issues' && ['warning', 'unavailable'].includes(health)
				|| filter === 'unknown' && health === 'unknown'
				|| filter === 'maintenance' && health === 'maintenance';
			device.classList.toggle('filter-hidden', !show);
		}
	}

	_restoreSelectedDevice() {
		const console = this._target.querySelector('.laka-console');
		if (console === null) return;
		let hostid = '';
		try { hostid = localStorage.getItem(console.dataset.consoleKey || '') || ''; }
		catch (error) {}
		if (hostid === '__topology__') this._showGlobalTopology(false);
		else if (hostid !== '') this._selectDevice(hostid, false);
	}

	_showGlobalTopology(persist = true) {
		const console = this._target.querySelector('.laka-console');
		if (console === null) return;
		for (const button of console.querySelectorAll('.laka-device-button')) button.classList.remove('active');
		for (const pane of console.querySelectorAll('.laka-device-pane')) pane.classList.remove('active');
		console.querySelector('.laka-topology-nav')?.classList.add('active');
		const view = console.querySelector('.laka-global-topology');
		view?.classList.add('active');
		const panel = view?.querySelector('.laka-topology');
		if (panel) {
			let selectedHosts = [];
			try { selectedHosts = JSON.parse(localStorage.getItem(`${console.dataset.consoleKey}-endpoint-hosts`) || '[]'); }
			catch (error) {}
			panel.dataset.endpointHosts = JSON.stringify(Array.isArray(selectedHosts) ? selectedHosts.map(String) : []);
			try { panel.dataset.zoom = localStorage.getItem('laka-topology-zoom-global') || '1'; }
			catch (error) {}
			this._syncTopologyEndpointControls(panel);
			this._renderTopology(panel);
		}
		if (persist) {
			try { localStorage.setItem(console.dataset.consoleKey || '', '__topology__'); }
			catch (error) {}
		}
	}

	_selectDevice(hostid, persist = true) {
		const console = this._target.querySelector('.laka-console');
		if (console === null) return;
		let found = false;
		for (const button of console.querySelectorAll('.laka-device-button')) {
			const active = button.dataset.hostid === hostid;
			button.classList.toggle('active', active);
			if (active) found = true;
		}
		if (!found) return;
		console.querySelector('.laka-topology-nav')?.classList.remove('active');
		console.querySelector('.laka-global-topology')?.classList.remove('active');
		for (const pane of console.querySelectorAll('.laka-device-pane')) {
			pane.classList.toggle('active', pane.dataset.hostid === hostid);
		}
		if (persist) {
			try { localStorage.setItem(console.dataset.consoleKey || '', hostid); }
			catch (error) {}
		}
		this._restoreInterfaceListState();
		this._restoreViewTabs();
		this._restoreFeaturedSelections();
		this._restoreNeighborPanels();
		this._restorePortLayouts();
		this._renderTopology(console.querySelector('.laka-device-pane.active .laka-device-topology'));
		this._loadFeaturedCharts(console.querySelector('.laka-device-pane.active'));
	}

	_restoreNeighborPanels() {
		for (const panel of this._target.querySelectorAll('.laka-neighbor-panel')) {
			let expanded = false;
			try { expanded = localStorage.getItem(panel.dataset.storageKey || '') === '1'; }
			catch (error) {}
			panel.classList.toggle('expanded', expanded);
			panel.querySelector('.laka-neighbor-head')?.setAttribute('aria-expanded', expanded ? 'true' : 'false');
		}
	}

	_restoreLocalMapModes() {
		for (const panel of this._target.querySelectorAll('.laka-device-topology')) {
			let mode = 'both';
			try { mode = localStorage.getItem(`laka-local-map-mode-${panel.dataset.scopeHostid || ''}`) || mode; }
			catch (error) {}
			if (!['endpoints', 'links', 'both'].includes(mode)) mode = 'both';
			panel.dataset.mapMode = mode;
			try { panel.dataset.zoom = localStorage.getItem(`laka-topology-zoom-${panel.dataset.scopeHostid || ''}`) || '1'; }
			catch (error) {}
			for (const button of panel.querySelectorAll('[data-local-map-mode]')) {
				button.classList.toggle('active', button.dataset.localMapMode === mode);
			}
		}
	}

	_toggleNeighborPanel(panel) {
		if (panel === null) return;
		const expanded = !panel.classList.contains('expanded');
		panel.classList.toggle('expanded', expanded);
		panel.querySelector('.laka-neighbor-head')?.setAttribute('aria-expanded', expanded ? 'true' : 'false');
		try { localStorage.setItem(panel.dataset.storageKey || '', expanded ? '1' : '0'); }
		catch (error) {}
	}

	_restoreViewTabs() {
		for (const root of this._target.querySelectorAll('.laka-sw')) {
			let tab = 'overview';
			try { tab = localStorage.getItem(`laka-switch-tab-${root.dataset.hostid || ''}`) || tab; }
			catch (error) {}
			const button = [...root.querySelectorAll('.laka-view-tab')]
				.find(candidate => candidate.dataset.viewTab === tab) || root.querySelector('.laka-view-tab');
			if (button !== null) {
				const activeTab = button.dataset.viewTab || 'overview';
				this._setViewTab(root, activeTab);
				if (activeTab === 'topology') this._renderTopology(root.querySelector('.laka-topology'));
			}
		}
	}

	_selectViewTab(button) {
		const root = button.closest('.laka-sw');
		if (root === null) return;
		const tab = button.dataset.viewTab || 'overview';
		this._setViewTab(root, tab);
		try { localStorage.setItem(`laka-switch-tab-${root.dataset.hostid || ''}`, tab); }
		catch (error) {}
		if (tab === 'consumption') this._loadFeaturedCharts(root.closest('.laka-device-pane'), true);
		if (tab === 'topology') this._renderTopology(root.querySelector('.laka-topology'));
	}

	_setViewTab(root, tab) {
		root.dataset.activeTab = tab;
		for (const button of root.querySelectorAll('.laka-view-tab')) {
			const active = button.dataset.viewTab === tab;
			button.classList.toggle('active', active);
			button.setAttribute('aria-selected', active ? 'true' : 'false');
		}
	}

	_restoreFeaturedSelections() {
		for (const panel of this._target.querySelectorAll('.laka-featured')) {
			let selection = null;
			try {
				const stored = localStorage.getItem(panel.dataset.selectionKey || '');
				if (stored !== null) selection = JSON.parse(stored);
			}
			catch (error) {}
			if (!Array.isArray(selection)) {
				try { selection = JSON.parse(panel.dataset.defaultSelection || '[]'); }
				catch (error) { selection = []; }
			}
			this._setFeaturedSelection(panel, selection, false);
		}
	}

	_toggleFeaturedInterface(option) {
		const panel = option.closest('.laka-featured');
		if (panel === null) return;
		const selected = [...panel.querySelectorAll('.laka-featured-port-option.selected')]
			.map(button => button.dataset.interfaceKey || '');
		const key = option.dataset.interfaceKey || '';
		const position = selected.indexOf(key);
		if (position >= 0) selected.splice(position, 1);
		else {
			const maximum = Number(panel.dataset.maxCharts || 4);
			if (selected.length >= maximum) {
				option.title = `Máximo ${maximum} interfaces`;
				return;
			}
			selected.push(key);
		}
		this._setFeaturedSelection(panel, selected, true);
	}

	_setFeaturedSelection(panel, selection, persist) {
		if (panel === null) return;
		const maximum = Number(panel.dataset.maxCharts || 4);
		const available = new Set([...panel.querySelectorAll('.laka-featured-card')]
			.map(card => card.dataset.interfaceKey || ''));
		const selected = [...new Set(selection.map(String).filter(key => available.has(key)))].slice(0, maximum);
		for (const option of panel.querySelectorAll('.laka-featured-port-option')) {
			option.classList.toggle('selected', selected.includes(option.dataset.interfaceKey || ''));
		}
		for (const card of panel.querySelectorAll('.laka-featured-card')) {
			const active = selected.includes(card.dataset.interfaceKey || '');
			card.classList.toggle('selected', active);
			if (!active) card.querySelector('.laka-featured-chart')?.removeAttribute('data-loaded-period');
		}
		panel.classList.toggle('no-selection', selected.length === 0);
		if (persist) {
			try { localStorage.setItem(panel.dataset.selectionKey || '', JSON.stringify(selected)); }
			catch (error) {}
		}
		const pane = panel.closest('.laka-device-pane');
		if (pane?.classList.contains('active')) this._loadFeaturedCharts(pane, true);
	}

	_observeFeaturedCharts() {
		if (this._featuredResizeObserver) this._featuredResizeObserver.disconnect();
		if (typeof ResizeObserver === 'undefined') return;
		this._featuredResizeObserver = new ResizeObserver(entries => {
			for (const entry of entries) {
				if (!entry.target.classList.contains('laka-topology-stage') || entry.contentRect.height < 220) continue;
				try { localStorage.setItem(this._topologyStageKey(entry.target), String(Math.round(entry.contentRect.height))); }
				catch (error) {}
			}
			const chartChanged = entries.some(entry => entry.target.closest('.laka-featured-card.selected'));
			const topologyPanels = [...new Set(entries
				.map(entry => entry.target.closest('.laka-topology'))
				.filter(panel => panel !== null && panel.offsetParent !== null))];
			if (!chartChanged && topologyPanels.length === 0) return;
			clearTimeout(this._featuredResizeTimer);
			this._featuredResizeTimer = setTimeout(() => {
				if (chartChanged) this._loadFeaturedCharts(this._target.querySelector('.laka-device-pane.active'), true);
				for (const panel of topologyPanels) this._renderTopology(panel);
			}, 250);
		});
		for (const stage of this._target.querySelectorAll('.laka-featured-chart, .laka-topology-stage')) {
			this._featuredResizeObserver.observe(stage);
		}
	}

	_loadFeaturedCharts(pane, force = false) {
		if (pane === null) return;
		const panel = pane.querySelector('.laka-featured');
		if (panel === null) return;
		const period = panel.dataset.defaultPeriod || '12h';
		for (const card of panel.querySelectorAll('.laka-featured-card.selected')) {
			const stage = card.querySelector('.laka-featured-chart');
			const width = Math.max(480, Math.floor(stage?.getBoundingClientRect().width || 960));
			const height = Math.max(180, Math.floor(stage?.getBoundingClientRect().height || 200));
			const signature = `${period}-${width}-${height}`;
			if (stage === null || (!force && stage.dataset.loadedPeriod === signature)) continue;
			const itemids = [card.dataset.inItemid, card.dataset.outItemid].filter(itemid => /^\d+$/.test(itemid));
			stage.innerHTML = '';
			if (itemids.length === 0) {
				const empty = document.createElement('span');
				empty.className = 'laka-featured-empty';
				empty.textContent = 'Sin ítems de tráfico IN/OUT';
				stage.append(empty);
				continue;
			}
			stage.innerHTML = '<span class="laka-featured-loading">Cargando datos históricos…</span>';
			const url = new Curl('zabbix.php');
			url.setArgument('action', 'widget.laka_network_switch.history');
			const request = new URLSearchParams({
				hostid: card.closest('.laka-sw')?.dataset.hostid || '',
				period
			});
			if (card.dataset.inItemid) request.set('in_itemid', card.dataset.inItemid);
			if (card.dataset.outItemid) request.set('out_itemid', card.dataset.outItemid);
			const requestId = `${Date.now()}-${Math.random()}`;
			stage.dataset.requestId = requestId;
			fetch(url.getUrl(), {
				method: 'POST',
				credentials: 'same-origin',
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
					'X-Requested-With': 'XMLHttpRequest'
				},
				body: request.toString()
			})
				.then(async response => ({status: response.status, text: await response.text()}))
				.then(result => {
					if (stage.dataset.requestId !== requestId) return;
					let response = JSON.parse(result.text.replace(/^\uFEFF/, '').trim());
					if (response.body && typeof response.body === 'object') response = response.body;
					if (typeof response.main_block === 'string') response = JSON.parse(response.main_block);
					if (!response.ok) throw new Error(response.error || `Respuesta histórica inválida (HTTP ${result.status})`);
					this._renderVectorChart(stage, response.data || {}, width, height, period);
					stage.dataset.loadedPeriod = signature;
				})
				.catch(error => {
					if (stage.dataset.requestId === requestId) {
						stage.innerHTML = '';
						const message = document.createElement('span');
						message.className = 'laka-featured-empty';
						message.textContent = `No se pudo consultar el historial: ${error.message || 'error desconocido'}`;
						stage.append(message);
					}
				});
		}
	}

	_renderVectorChart(stage, data, width, height, period) {
		const inbound = Array.isArray(data.in) ? data.in : [];
		const outbound = Array.isArray(data.out) ? data.out : [];
		const all = [...inbound, ...outbound].filter(point => Array.isArray(point) && point.length >= 2);
		if (all.length === 0) {
			stage.innerHTML = '<span class="laka-featured-empty">Sin historial para este periodo.</span>';
			return;
		}
		const margin = {top: 22, right: 18, bottom: 32, left: 64};
		const plotWidth = Math.max(1, width - margin.left - margin.right);
		const plotHeight = Math.max(1, height - margin.top - margin.bottom);
		const firstClock = Math.min(...all.map(point => Number(point[0])));
		const lastClock = Math.max(...all.map(point => Number(point[0])));
		const minClock = Number(data.time_from) > 0 ? Number(data.time_from) : firstClock;
		const maxClock = Number(data.time_till) > minClock ? Number(data.time_till) : lastClock;
		const rawMax = Math.max(...all.map(point => Number(point[1]) || 0), 1);
		const magnitude = 10 ** Math.floor(Math.log10(rawMax));
		const normalized = rawMax / magnitude;
		const niceMax = (normalized <= 1 ? 1 : normalized <= 2 ? 2 : normalized <= 5 ? 5 : 10) * magnitude;
		const x = clock => margin.left + (Number(clock) - minClock) / Math.max(1, maxClock - minClock) * plotWidth;
		const y = value => margin.top + plotHeight - Math.max(0, Number(value)) / niceMax * plotHeight;
		const path = series => series.map((point, index) => `${index === 0 ? 'M' : 'L'}${x(point[0]).toFixed(1)},${y(point[1]).toFixed(1)}`).join(' ');
		const area = series => series.length === 0 ? '' : `${path(series)} L${x(series.at(-1)[0]).toFixed(1)},${margin.top + plotHeight} L${x(series[0][0]).toFixed(1)},${margin.top + plotHeight} Z`;
		let grid = '';
		for (let index = 0; index <= 4; index++) {
			const gy = margin.top + plotHeight * index / 4;
			const value = niceMax * (1 - index / 4);
			grid += `<line x1="${margin.left}" y1="${gy}" x2="${width - margin.right}" y2="${gy}" class="grid"/>`;
			grid += `<text x="${margin.left - 9}" y="${gy + 3}" text-anchor="end" class="axis-label">${this._formatRate(value)}</text>`;
		}
		for (let index = 0; index <= 6; index++) {
			const gx = margin.left + plotWidth * index / 6;
			const clock = minClock + (maxClock - minClock) * index / 6;
			grid += `<line x1="${gx}" y1="${margin.top}" x2="${gx}" y2="${margin.top + plotHeight}" class="grid vertical"/>`;
			grid += `<text x="${gx}" y="${height - 9}" text-anchor="middle" class="axis-label">${this._formatChartTime(clock, period)}</text>`;
		}
		stage.innerHTML = `<svg class="laka-vector-chart" viewBox="0 0 ${width} ${height}" role="img" aria-label="Histórico de tráfico IN y OUT">
			<g>${grid}</g>
			<path d="${area(inbound)}" class="area in"/><path d="${area(outbound)}" class="area out"/>
			<path d="${path(inbound)}" class="line in"/><path d="${path(outbound)}" class="line out"/>
			<line class="crosshair" x1="0" y1="${margin.top}" x2="0" y2="${margin.top + plotHeight}"/>
			<g class="chart-legend"><circle cx="${margin.left}" cy="10" r="4" class="legend-in"/><text x="${margin.left + 9}" y="13">IN recibido</text><circle cx="${margin.left + 98}" cy="10" r="4" class="legend-out"/><text x="${margin.left + 107}" y="13">OUT enviado</text></g>
		</svg><div class="laka-chart-tooltip"></div>`;
		const svg = stage.querySelector('svg');
		const crosshair = svg.querySelector('.crosshair');
		const tooltip = stage.querySelector('.laka-chart-tooltip');
		const nearest = (series, clock) => series.reduce((best, point) => !best || Math.abs(point[0] - clock) < Math.abs(best[0] - clock) ? point : best, null);
		svg.addEventListener('mousemove', event => {
			const bounds = svg.getBoundingClientRect();
			const localX = Math.max(margin.left, Math.min(width - margin.right, (event.clientX - bounds.left) / bounds.width * width));
			const clock = minClock + (localX - margin.left) / plotWidth * (maxClock - minClock);
			const inPoint = nearest(inbound, clock);
			const outPoint = nearest(outbound, clock);
			crosshair.setAttribute('x1', String(localX));
			crosshair.setAttribute('x2', String(localX));
			crosshair.classList.add('visible');
			tooltip.textContent = `${new Date(clock * 1000).toLocaleString()}  ·  IN ${inPoint ? this._formatRate(inPoint[1]) : 'N/D'}  ·  OUT ${outPoint ? this._formatRate(outPoint[1]) : 'N/D'}`;
			tooltip.style.left = `${Math.min(stage.clientWidth - tooltip.offsetWidth - 8, Math.max(8, event.clientX - bounds.left + 12))}px`;
			tooltip.style.top = '28px';
			tooltip.classList.add('visible');
		});
		svg.addEventListener('mouseleave', () => {
			crosshair.classList.remove('visible');
			tooltip.classList.remove('visible');
		});
	}

	_formatRate(value) {
		const number = Number(value) || 0;
		if (number >= 1e9) return `${(number / 1e9).toFixed(number >= 10e9 ? 0 : 1)} Gbps`;
		if (number >= 1e6) return `${(number / 1e6).toFixed(number >= 10e6 ? 0 : 1)} Mbps`;
		if (number >= 1e3) return `${(number / 1e3).toFixed(number >= 10e3 ? 0 : 1)} Kbps`;
		return `${number.toFixed(0)} bps`;
	}

	_formatChartTime(clock, period) {
		const date = new Date(Number(clock) * 1000);
		return period === '7d'
			? date.toLocaleDateString([], {day: '2-digit', month: '2-digit'})
			: date.toLocaleTimeString([], {hour: '2-digit', minute: '2-digit'});
	}

	_searchDevices(input) {
		const query = input.value.trim().toLocaleLowerCase();
		for (const button of this._target.querySelectorAll('.laka-device-button')) {
			button.classList.toggle('search-hidden', query !== '' && !(button.dataset.search || '').includes(query));
		}
	}

	_restoreInterfaceListState() {
		const panel = this._target.querySelector('.laka-device-pane.active .laka-interface-panel')
			|| this._target.querySelector('.laka-interface-panel');
		if (panel === null) return;
		let expanded = panel.dataset.defaultExpanded !== '0';
		try {
			const stored = localStorage.getItem(panel.dataset.storageKey || '');
			if (stored === 'expanded' || stored === 'collapsed') expanded = stored === 'expanded';
		}
		catch (error) {}
		this._setInterfaceListExpanded(panel, expanded);
	}

	_toggleInterfaceList(toggle) {
		const panel = toggle.closest('.laka-interface-panel');
		if (panel === null) return;
		const expanded = panel.classList.contains('collapsed');
		this._setInterfaceListExpanded(panel, expanded);
		try {
			localStorage.setItem(panel.dataset.storageKey || '', expanded ? 'expanded' : 'collapsed');
		}
		catch (error) {}
	}

	_setInterfaceListExpanded(panel, expanded) {
		panel.classList.toggle('collapsed', !expanded);
		const toggle = panel.querySelector('.laka-interface-toggle');
		if (toggle !== null) {
			toggle.setAttribute('aria-expanded', expanded ? 'true' : 'false');
			toggle.title = expanded ? 'Ocultar lista de interfaces' : 'Mostrar lista de interfaces';
		}
	}

	_searchInterfaceList(input) {
		const panel = input.closest('.laka-interface-panel');
		if (panel === null) return;
		const query = input.value.trim().toLocaleLowerCase();
		let count = 0;
		for (const row of panel.querySelectorAll('.laka-interface-row')) {
			const matches = query === '' || `${row.dataset.name || ''} ${row.dataset.alias || ''}`.includes(query);
			row.classList.toggle('search-hidden', !matches);
			if (matches && !row.classList.contains('filtered-out')) count++;
		}
		const result = panel.querySelector('.laka-interface-search-result');
		if (result !== null) result.textContent = `${count} interfaz${count === 1 ? '' : 'es'}`;
	}

	_sortInterfaceList(button) {
		const table = button.closest('.laka-interface-table');
		const body = table?.querySelector('tbody');
		if (body === null || body === undefined) return;
		const key = button.dataset.sort || 'name';
		const direction = button.dataset.direction === 'asc' ? 'desc' : 'asc';
		for (const other of table.querySelectorAll('.laka-sort-button')) {
			other.classList.remove('active');
			other.dataset.direction = '';
			other.querySelector('.laka-sort-indicator')?.remove();
		}
		button.classList.add('active');
		button.dataset.direction = direction;
		const indicator = document.createElement('span');
		indicator.className = 'laka-sort-indicator';
		indicator.textContent = direction === 'asc' ? '▲' : '▼';
		button.append(indicator);
		const statusRank = {up: 1, down: 2, disabled: 3, unknown: 4};
		const numericKeys = ['speed', 'in', 'out', 'util', 'errors'];
		const rows = [...body.querySelectorAll('.laka-interface-row')];
		rows.sort((a, b) => {
			let av;
			let bv;
			if (key === 'status') {
				av = statusRank[a.dataset.status] || 99;
				bv = statusRank[b.dataset.status] || 99;
			}
			else if (numericKeys.includes(key)) {
				const dataKey = key === 'util' ? 'utilValue' : (key === 'errors' ? 'errors' : `${key}Sort`);
				av = Number(a.dataset[dataKey] || 0);
				bv = Number(b.dataset[dataKey] || 0);
			}
			else {
				av = a.dataset[key] || '';
				bv = b.dataset[key] || '';
			}
			const result = typeof av === 'number' ? av - bv : av.localeCompare(bv, undefined, {numeric: true});
			return direction === 'asc' ? result : -result;
		});
		for (const row of rows) body.append(row);
	}

	onClearContents() {
		this._closePortModal();
	}

	processUpdateResponse(response) {
		super.processUpdateResponse(response);
		this._applyZabbixTheme();
		this._restoreDeviceNavigation();
		this._restoreTopologyStageSizes();
		this._restoreLocalMapModes();
		this._restorePortLayouts();
		this._restoreSelectedDevice();
		this._restoreViewTabs();
		this._restoreFeaturedSelections();
		this._restoreInterfaceListState();
		this._observeFeaturedCharts();
		this._loadFeaturedCharts(this._target.querySelector('.laka-device-pane.active'));
	}

	_openPortModal(data) {
		this._closePortModal();
		this._activePortData = data;
		this._modal = document.createElement('div');
		this._modal.className = 'laka-port-modal';
		this._applyModalTheme();
		const box = document.createElement('div');
		box.className = 'laka-modal-box';
		const head = document.createElement('div');
		head.className = 'laka-modal-head';
		const heading = document.createElement('div');
		const title = document.createElement('div');
		title.className = 'laka-modal-title';
		title.textContent = data.dataset.portTitle || 'Interface';
		const subtitle = document.createElement('div');
		subtitle.className = 'laka-modal-subtitle';
		subtitle.textContent = data.dataset.portSubtitle || '';
		heading.append(title, subtitle);
		const close = document.createElement('button');
		close.type = 'button';
		close.className = 'laka-modal-close';
		close.setAttribute('aria-label', 'Close');
		close.textContent = '×';
		head.append(heading, close);
		box.append(head);
		for (const child of data.children) box.append(child.cloneNode(true));
		this._modal.append(box);
		this._modal.addEventListener('click', this._events.modal_click);
		document.addEventListener('keydown', this._events.modal_keydown);
		document.body.append(this._modal);
		this._loadNativeChart(data, box, '1h');
	}

	_openSensorModal(sensor) {
		this._closePortModal();
		this._activeSensorData = sensor;
		this._modal = document.createElement('div');
		this._modal.className = 'laka-port-modal';
		this._applyModalTheme();
		const box = document.createElement('div');
		box.className = 'laka-modal-box';
		const head = document.createElement('div');
		head.className = 'laka-modal-head';
		const heading = document.createElement('div');
		const title = document.createElement('div');
		title.className = 'laka-modal-title';
		title.textContent = sensor.dataset.name || 'Sensor';
		const subtitle = document.createElement('div');
		subtitle.className = 'laka-modal-subtitle';
		subtitle.textContent = sensor.dataset.key || '';
		heading.append(title, subtitle);
		const close = document.createElement('button');
		close.type = 'button';
		close.className = 'laka-modal-close';
		close.textContent = '×';
		head.append(heading, close);
		box.append(head);
		const table = document.createElement('table');
		table.className = 'laka-detail-table';
		const rows = [
			['Valor actual', sensor.dataset.value || 'N/D'],
			['Última actualización', sensor.dataset.clock || 'N/D'],
			['Estado', sensor.classList.contains('critical') ? 'Crítico' : (sensor.classList.contains('warning') ? 'Advertencia' : (sensor.classList.contains('unknown') ? 'Sin datos' : 'Normal'))]
		];
		for (const [label, value] of rows) {
			const row = table.insertRow();
			const labelCell = row.insertCell();
			labelCell.textContent = label;
			const valueCell = row.insertCell();
			valueCell.textContent = value;
		}
		box.append(table);
		if ((sensor.dataset.problems || '') !== '') {
			const problems = document.createElement('div');
			problems.className = 'laka-modal-problems';
			problems.textContent = sensor.dataset.problems;
			box.append(problems);
		}
		if (sensor.dataset.numeric === '1') {
			const chart = document.createElement('div');
			chart.className = 'laka-chart';
			const chartHead = document.createElement('div');
			chartHead.className = 'laka-chart-title';
			const chartTitle = document.createElement('span');
			chartTitle.textContent = 'Histórico del sensor';
			const periods = document.createElement('div');
			periods.className = 'laka-chart-periods';
			for (const period of ['1h', '6h', '24h', '7d']) {
				const button = document.createElement('button');
				button.type = 'button';
				button.className = `laka-period-button laka-sensor-period-button${period === '24h' ? ' active' : ''}`;
				button.dataset.period = period;
				button.textContent = period;
				periods.append(button);
			}
			chartHead.append(chartTitle, periods);
			const stage = document.createElement('div');
			stage.className = 'laka-chart-stage';
			chart.append(chartHead, stage);
			box.append(chart);
		}
		this._modal.append(box);
		this._modal.addEventListener('click', this._events.modal_click);
		document.addEventListener('keydown', this._events.modal_keydown);
		document.body.append(this._modal);
		if (sensor.dataset.numeric === '1') this._loadSensorChart(sensor, box, '24h');
	}

	_loadSensorChart(sensor, box, period) {
		const stage = box.querySelector('.laka-chart-stage');
		const itemid = sensor?.dataset.itemid || '';
		if (stage === null || !/^\d+$/.test(itemid)) return;
		const periods = {'1h': 'now-1h', '6h': 'now-6h', '24h': 'now-24h', '7d': 'now-7d'};
		const url = new Curl('chart.php');
		url.setArgument('itemids', [itemid]);
		url.setArgument('from', periods[period] || periods['24h']);
		url.setArgument('to', 'now');
		url.setArgument('type', '0');
		url.setArgument('legend', '1');
		url.setArgument('resolve_macros', '1');
		url.setArgument('width', '840');
		url.setArgument('height', '220');
		stage.innerHTML = '';
		const image = document.createElement('img');
		image.alt = 'Histórico del sensor';
		image.src = url.getUrl();
		stage.append(image);
	}

	_loadNativeChart(data, box, period = '1h') {
		const stage = box.querySelector('.laka-chart-stage');
		if (stage === null) return;
		const itemids = [data.dataset.inItemid, data.dataset.outItemid]
			.filter(itemid => /^\d+$/.test(itemid));
		if (itemids.length === 0) {
			stage.innerHTML = '';
			const empty = document.createElement('div');
			empty.className = 'laka-chart-empty';
			empty.textContent = 'No se encontraron los ítems de tráfico IN/OUT.';
			stage.append(empty);
			return;
		}
		period = ['1h', '6h', '24h', '7d'].includes(period) ? period : '1h';
		stage.innerHTML = '<div class="laka-chart-empty">Consultando el historial seleccionado…</div>';
		const width = Math.max(520, Math.floor(stage.getBoundingClientRect().width || 840));
		const height = Math.max(235, Math.floor(stage.getBoundingClientRect().height || 300));
		const url = new Curl('zabbix.php');
		url.setArgument('action', 'widget.laka_network_switch.history');
		const request = new URLSearchParams({hostid: data.dataset.hostid || '', period});
		if (data.dataset.inItemid) request.set('in_itemid', data.dataset.inItemid);
		if (data.dataset.outItemid) request.set('out_itemid', data.dataset.outItemid);
		const requestId = `${period}-${Date.now()}-${Math.random()}`;
		stage.dataset.requestId = requestId;
		fetch(url.getUrl(), {
			method: 'POST', credentials: 'same-origin', cache: 'no-store',
			headers: {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8', 'X-Requested-With': 'XMLHttpRequest'},
			body: request.toString()
		})
			.then(async response => ({status: response.status, text: await response.text()}))
			.then(result => {
				if (stage.dataset.requestId !== requestId) return;
				let response = JSON.parse(result.text.replace(/^\uFEFF/, '').trim());
				if (response.body && typeof response.body === 'object') response = response.body;
				if (typeof response.main_block === 'string') response = JSON.parse(response.main_block);
				if (!response.ok) throw new Error(response.error || `Respuesta histórica inválida (HTTP ${result.status})`);
				this._renderVectorChart(stage, response.data || {}, width, height, period);
			})
			.catch(error => {
				if (stage.dataset.requestId !== requestId) return;
				stage.innerHTML = `<div class="laka-chart-empty">No se pudo consultar el historial: ${this._escapeTopology(error.message || 'error desconocido')}</div>`;
			});
	}

	_topologyData(panel) {
		try {
			return {
				hosts: JSON.parse(panel?.dataset.hosts || '[]'),
				links: JSON.parse(panel?.dataset.links || '[]'),
				endpoints: JSON.parse(panel?.dataset.endpoints || '[]')
			};
		}
		catch (error) {
			return {hosts: [], links: [], endpoints: []};
		}
	}

	_escapeTopology(value) {
		return String(value ?? '').replace(/[&<>"']/g, character => ({
			'&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;'
		})[character]);
	}

	_topologyLabel(value, maximum = 20) {
		const text = String(value ?? '');
		return text.length > maximum ? `${text.slice(0, maximum - 1)}…` : text;
	}

	_topologyDeviceType(value) {
		const text = String(value || '').toLowerCase();
		if (/phone|telefono|sip[0-9]|sep[0-9a-f]{6,}/.test(text)) return 'phone';
		if (/access[ -]?point|wireless|air-?ap|\bap[0-9_-]/.test(text)) return 'access_point';
		if (/fortigate|firewall|\basa\b|palo alto|checkpoint/.test(text)) return 'firewall';
		if (/\brouter\b|\bisr[0-9]|\basr[0-9]|mikrotik|routeros/.test(text)) return 'router';
		if (/camera|camara|dahua|hikvision/.test(text)) return 'camera';
		if (/printer|impresora|lexmark|epson|xerox|ricoh|brother|laserjet/.test(text)) return 'printer';
		if (/\bups\b|apc smart/.test(text)) return 'ups';
		if (/server|servidor|windows|linux|vmware|proxmox/.test(text)) return 'server';
		if (/\bswitch\b|catalyst|nexus|c9[0-9]{3}|sg[0-9]{3}/.test(text)) return 'switch';
		return 'endpoint';
	}

	_topologyIcon(type) {
		const icons = {
			switch: '<rect x="1" y="8" width="25" height="12" rx="2"/><path d="M5 12h2m3 0h2m3 0h2m3 0h2M5 16h2m3 0h2m3 0h2m3 0h2"/>',
			router: '<ellipse cx="14" cy="14" rx="12" ry="7"/><path d="M5 14h18M8 10l-3 4 3 4m12-8 3 4-3 4"/>',
			firewall: '<path d="M14 2l10 4v7c0 7-4 11-10 14C8 24 4 20 4 13V6l10-4z"/><path d="M8 10h12M8 15h12M11 6v4m6 0v5m-6 0v5m6-5v6"/>',
			phone: '<path d="M7 3h14l2 15H5L7 3zM8 21h12M10 7h8v6h-8z"/><path d="M9 17h1m3 0h1m3 0h1"/>',
			access_point: '<circle cx="14" cy="20" r="2"/><path d="M8 15a8 8 0 0112 0M4 11a13 13 0 0120 0M14 20v6"/>',
			server: '<rect x="4" y="3" width="20" height="8" rx="1"/><rect x="4" y="15" width="20" height="8" rx="1"/><path d="M8 7h1m3 0h8M8 19h1m3 0h8"/>',
			camera: '<path d="M3 9h16v12H3zM19 12l7-4v14l-7-4z"/><circle cx="10" cy="15" r="3"/>',
			printer: '<path d="M7 3h14v7H7zM5 11h18a3 3 0 013 3v7h-5v4H7v-4H2v-7a3 3 0 013-3zM8 18h12v5H8z"/>',
			ups: '<rect x="6" y="2" width="16" height="24" rx="2"/><circle cx="14" cy="9" r="3"/><path d="M10 18h8m-6 4h4"/>',
			endpoint: '<circle cx="14" cy="14" r="11"/><path d="M9 18c2-3 8-3 10 0M14 7v7m-3-3h6"/>'
		};
		return `<g class="laka-topology-icon" transform="translate(8,12)">${icons[type] || icons.endpoint}</g>`;
	}

	_renderTopology(panel) {
		if (panel === null) return;
		const stage = panel.querySelector('.laka-topology-stage');
		if (stage === null) return;
		let {hosts, links, endpoints} = this._topologyData(panel);
		const scopeHostid = String(panel.dataset.scopeHostid || '');
		const mapMode = panel.dataset.mapMode || 'both';
		if (scopeHostid !== '') {
			links = links.filter(link => String(link.a) === scopeHostid || String(link.b) === scopeHostid);
			endpoints = endpoints.filter(endpoint => String(endpoint.parent) === scopeHostid);
			const connected = new Set([scopeHostid]);
			if (mapMode !== 'endpoints') {
				for (const link of links) {
					connected.add(String(link.a));
					connected.add(String(link.b));
				}
			}
			hosts = hosts.filter(host => connected.has(String(host.id)));
			if (mapMode === 'endpoints') links = [];
			if (mapMode === 'links') endpoints = [];
		}
		if (hosts.length === 0) {
			stage.innerHTML = '<div class="laka-topology-empty">No hay equipos disponibles para construir la topología.</div>';
			return;
		}
		let endpointHosts = [];
		try { endpointHosts = JSON.parse(panel.dataset.endpointHosts || '[]').map(String); }
		catch (error) {}
		const visibleEndpoints = endpoints.filter(endpoint => endpointHosts.includes(String(endpoint.parent)));
		const networkNodes = hosts.map(host => ({...host, nodeId: String(host.id), endpoint: false,
			type: this._topologyDeviceType(`${host.name || ''} ${host.model || ''}`)}));
		const endpointNodes = visibleEndpoints.map(endpoint => ({...endpoint,
			nodeId: `endpoint:${endpoint.id}`, endpoint: true}));
		const allNodes = [...networkNodes, ...endpointNodes];
		const width = Math.max(760, Math.floor(stage.clientWidth || 900));
		const networkWidth = 136, networkHeight = 52, endpointWidth = 112, endpointHeight = 44;
		const cellWidth = networkWidth, cellHeight = networkHeight, xGap = 42, yGap = 72;
		const columns = Math.max(2, Math.floor((width - 60) / (cellWidth + xGap)));
		const current = panel.dataset.currentHostid || '';
		const ordered = [...allNodes].sort((a, b) => {
			if (a.endpoint !== b.endpoint) return a.endpoint ? 1 : -1;
			if (String(a.id) === current) return -1;
			if (String(b.id) === current) return 1;
			return String(a.name).localeCompare(String(b.name), undefined, {numeric: true});
		});
		const positions = new Map();
		ordered.forEach((host, index) => {
			const row = Math.floor(index / columns), column = index % columns;
			const count = Math.min(columns, ordered.length - row * columns);
			const rowWidth = count * cellWidth + Math.max(0, count - 1) * xGap;
			const itemWidth = host.endpoint ? endpointWidth : networkWidth;
			const itemHeight = host.endpoint ? endpointHeight : networkHeight;
			positions.set(String(host.nodeId), {
				x: Math.max(30, (width - rowWidth) / 2) + column * (cellWidth + xGap) + (cellWidth - itemWidth) / 2,
				y: 35 + row * (cellHeight + yGap), w: itemWidth, h: itemHeight
			});
		});
		const rows = Math.ceil(ordered.length / columns);
		const height = Math.max(scopeHostid !== '' ? 300 : 420, 70 + rows * (cellHeight + yGap));
		const hostsById = new Map(hosts.map(host => [String(host.id), host]));
		const port = (host, index) => (host?.ports || []).find(candidate =>
			String(candidate.index) === String(index) || String(candidate.name).toLowerCase() === String(index).toLowerCase());
		const edgeState = link => {
			const hostA = hostsById.get(String(link.a)), hostB = hostsById.get(String(link.b));
			const a = port(hostA, link.ai);
			const b = port(hostB, link.bi);
			if ((!a || !b) && (hostA?.health === 'unavailable' || hostB?.health === 'unavailable')) return 'down';
			if (!a || !b) return 'unknown';
			if (['down', 'disabled'].includes(a.status) || ['down', 'disabled'].includes(b.status)) return 'down';
			return a.status === 'up' && b.status === 'up' ? 'up' : 'unknown';
		};
		let edges = '';
		for (const link of links) {
			const a = positions.get(String(link.a)), b = positions.get(String(link.b));
			if (!a || !b) continue;
			const x1 = a.x + a.w / 2, y1 = a.y + a.h / 2;
			const x2 = b.x + b.w / 2, y2 = b.y + b.h / 2;
			const midY = (y1 + y2) / 2;
			const path = `M${x1},${y1} C${x1},${midY} ${x2},${midY} ${x2},${y2}`;
			const selected = panel.dataset.selectedLink === String(link.id) ? ' selected' : '';
			const id = this._escapeTopology(link.id);
			const label = this._escapeTopology(`${link.an || link.ai} ↔ ${link.bn || link.bi}`);
			edges += `<path d="${path}" class="laka-topology-edge ${edgeState(link)}${selected}" data-topology-link="${id}"/>`;
			edges += `<path d="${path}" class="laka-topology-edge-hit" data-topology-link="${id}"/>`;
			edges += `<text x="${(x1 + x2) / 2}" y="${midY - 7}" text-anchor="middle" class="laka-topology-edge-label">${label}</text>`;
		}
		for (const endpoint of visibleEndpoints) {
			const a = positions.get(String(endpoint.parent)), b = positions.get(`endpoint:${endpoint.id}`);
			if (!a || !b) continue;
			const x1 = a.x + a.w / 2, y1 = a.y + a.h / 2;
			const x2 = b.x + b.w / 2, y2 = b.y + b.h / 2;
			const midY = (y1 + y2) / 2;
			const path = `M${x1},${y1} C${x1},${midY} ${x2},${midY} ${x2},${y2}`;
			const parent = hostsById.get(String(endpoint.parent));
			const localPort = port(parent, endpoint.local_port);
			const state = ['down', 'disabled'].includes(localPort?.status) ? 'down'
				: localPort?.status === 'up' ? 'up' : 'unknown';
			edges += `<path d="${path}" class="laka-topology-edge ${state}"/>`;
		}
		let nodes = '';
		for (const host of ordered) {
			const point = positions.get(String(host.nodeId));
			const type = host.type || 'endpoint';
			if (host.endpoint) {
				const title = this._escapeTopology(`${host.name || 'Endpoint'} · ${host.ip || 'Sin IP'} · ${host.local_port || ''} ↔ ${host.remote_port || ''} · ${host.platform || ''}`);
				nodes += `<g transform="translate(${point.x},${point.y})" class="laka-topology-node laka-topology-endpoint ${this._escapeTopology(type)}" data-topology-endpoint="${this._escapeTopology(host.id)}"><title>${title}</title>`;
				nodes += `<rect width="${point.w}" height="${point.h}" rx="6"/><g transform="scale(.72)">${this._topologyIcon(type)}</g>`;
				nodes += `<text x="32" y="14" class="laka-topology-node-name">${this._escapeTopology(this._topologyLabel(host.name || 'Endpoint', 13))}</text>`;
				nodes += `<text x="35" y="28" class="laka-topology-endpoint-info">${this._escapeTopology(this._topologyLabel(host.ip || 'IP N/D', 16))}</text>`;
				nodes += `<text x="35" y="40" class="laka-topology-endpoint-info">${this._escapeTopology(this._topologyLabel(host.local_port || 'Puerto N/D', 16))}</text>`;
				nodes += `</g>`;
				continue;
			}
			const health = ['available', 'warning', 'unavailable', 'maintenance'].includes(host.health) ? host.health : 'unknown';
			const selected = String(host.id) === current ? ' current' : '';
			nodes += `<g transform="translate(${point.x},${point.y})" class="laka-topology-node ${health}${selected}" data-topology-inspect-host="${this._escapeTopology(host.id)}">`;
			nodes += `<rect width="${point.w}" height="${point.h}" rx="6"/><g transform="scale(.82)">${this._topologyIcon(type)}</g><text x="39" y="18" class="laka-topology-node-name">${this._escapeTopology(this._topologyLabel(host.name, 16))}</text>`;
			nodes += `<text x="39" y="33" class="laka-topology-node-model">${this._escapeTopology(this._topologyLabel(host.model || 'N/D', 17))}</text>`;
			nodes += `<text x="39" y="46" class="laka-topology-node-state">${Number(host.up || 0)} UP · ${Number(host.down || 0)} DOWN</text></g>`;
		}
		stage.innerHTML = `<svg class="laka-topology-svg" viewBox="0 0 ${width} ${height}" role="img" aria-label="Topología de red">${edges}${nodes}</svg>`;
		this._setTopologyActionState(panel);
		this._applyTopologyZoom(panel, 'apply');
		this._restoreTopologyPosition(stage);
	}

	_applyTopologyZoom(panel, action = 'apply') {
		if (panel === null) return;
		const stage = panel.querySelector('.laka-topology-stage');
		const svg = stage?.querySelector('.laka-topology-svg');
		if (!stage || !svg) return;
		let zoom = Number(panel.dataset.zoom || 1);
		if (action === 'in') zoom = Math.min(2.4, zoom + .2);
		else if (action === 'out') zoom = Math.max(.4, zoom - .2);
		else if (action === 'reset') zoom = 1;
		else if (action === 'fit') {
			const viewHeight = svg.viewBox?.baseVal?.height || stage.clientHeight || 1;
			zoom = Math.max(.4, Math.min(1, stage.clientHeight / viewHeight));
			stage.scrollTo({top: 0, left: 0});
		}
		panel.dataset.zoom = String(zoom);
		svg.style.width = `${zoom * 100}%`;
		svg.style.minWidth = `${Math.round(760 * zoom)}px`;
		svg.style.maxWidth = 'none';
		if (action !== 'apply') {
			try { localStorage.setItem(`laka-topology-zoom-${panel.dataset.scopeHostid || 'global'}`, String(zoom)); }
			catch (error) {}
		}
	}

	_setLocalMapMode(button) {
		const panel = button.closest('.laka-device-topology');
		if (panel === null) return;
		panel.dataset.mapMode = button.dataset.localMapMode || 'both';
		for (const candidate of panel.querySelectorAll('[data-local-map-mode]')) {
			candidate.classList.toggle('active', candidate === button);
		}
		try { localStorage.setItem(`laka-local-map-mode-${panel.dataset.scopeHostid || ''}`, panel.dataset.mapMode); }
		catch (error) {}
		this._renderTopology(panel);
	}

	_openTopologyNodeModal(node) {
		const panel = node.closest('.laka-topology');
		if (panel === null) return;
		const {hosts, links, endpoints} = this._topologyData(panel);
		const endpointId = node.dataset.topologyEndpoint;
		const hostid = node.dataset.topologyInspectHost;
		const endpoint = endpointId === undefined ? null
			: endpoints.find(candidate => String(candidate.id) === String(endpointId));
		const host = hostid === undefined ? null : hosts.find(candidate => String(candidate.id) === String(hostid));
		if (!endpoint && !host) return;
		let title = '', subtitle = '', openButton = '', protocol = 'CDP/LLDP';
		let localTitle = 'Equipo local', remoteTitle = 'Vecino descubierto';
		let localItems = [], remoteItems = [];
		if (endpoint) {
			title = endpoint.name || 'Endpoint descubierto';
			protocol = endpoint.protocol || protocol;
			subtitle = `${protocol} · ${endpoint.type || 'endpoint'}`;
			const localHost = hosts.find(candidate => String(candidate.id) === String(endpoint.parent));
			const localPort = (localHost?.ports || []).find(candidate =>
				String(candidate.name || '').toLowerCase() === String(endpoint.local_port || '').toLowerCase()
				|| String(candidate.index || '') === String(endpoint.local_port || ''));
			localItems = [
				['Hostname', localHost?.name || 'N/D'], ['Dirección IP', localHost?.ip || 'N/D'],
				['Modelo', localHost?.model || 'N/D'], ['Interfaz', endpoint.local_port || 'N/D'],
				['Estado del puerto', localPort?.status || 'N/D'], ['Tráfico IN / OUT', localPort ? `${localPort.in || 'N/D'} / ${localPort.out || 'N/D'}` : 'N/D']
			];
			remoteItems = [
				['Hostname', endpoint.name || 'N/D'], ['Dirección IP', endpoint.ip || 'N/D'],
				['Puerto remoto', endpoint.remote_port || 'N/D'], ['Plataforma', endpoint.platform || 'N/D'],
				['Software', endpoint.software || 'N/D'], ['Descripción', endpoint.description || 'N/D']
			];
			if (Number(endpoint.lastclock || 0) > 0) {
				remoteItems.push(['Último descubrimiento', new Date(Number(endpoint.lastclock) * 1000).toLocaleString()]);
			}
		}
		else {
			title = host.name || 'Equipo monitoreado';
			subtitle = `${this._topologyDeviceType(`${host.name || ''} ${host.model || ''}`)} · ${host.health || 'sin datos'}`;
			const hostLinks = links.filter(link => String(link.a) === String(host.id) || String(link.b) === String(host.id));
			const currentId = String(panel.dataset.scopeHostid || panel.dataset.currentHostid || '');
			const currentHost = hosts.find(candidate => String(candidate.id) === currentId);
			const connection = currentHost && String(currentHost.id) !== String(host.id)
				? links.find(link => [String(link.a), String(link.b)].includes(String(currentHost.id))
					&& [String(link.a), String(link.b)].includes(String(host.id))) : null;
			if (connection && currentHost) {
				const currentIsA = String(connection.a) === String(currentHost.id);
				protocol = connection.protocol || connection.source || protocol;
				localItems = [['Hostname', currentHost.name || 'N/D'], ['Dirección IP', currentHost.ip || 'N/D'],
					['Modelo', currentHost.model || 'N/D'], ['Interfaz', currentIsA ? (connection.an || connection.ai) : (connection.bn || connection.bi)],
					['Estado', currentHost.health || 'N/D']];
				remoteItems = [['Hostname', host.name || 'N/D'], ['Dirección IP', host.ip || 'N/D'], ['Modelo', host.model || 'N/D'],
					['Interfaz', currentIsA ? (connection.bn || connection.bi) : (connection.an || connection.ai)], ['Estado', host.health || 'N/D'],
					['Descripción', connection.description || 'N/D']];
			}
			else {
				localTitle = 'Equipo seleccionado';
				remoteTitle = 'Resumen de conectividad';
				localItems = [['Hostname', host.name || 'N/D'], ['Dirección IP', host.ip || 'N/D'], ['Modelo', host.model || 'N/D'],
					['Estado', host.health || 'N/D'], ['Puertos inventariados', String((host.ports || []).length)]];
				remoteItems = [['Interfaces conectadas', String(Number(host.up || 0))], ['Interfaces desconectadas', String(Number(host.down || 0))],
					['Interconexiones detectadas', String(hostLinks.length)], ['Tipo', this._topologyDeviceType(`${host.name || ''} ${host.model || ''}`)]];
			}
			openButton = `<button type="button" class="laka-neighbor-open" data-hostid="${this._escapeTopology(host.id)}">Abrir panel del equipo</button>`;
		}
		this._closePortModal();
		this._modal = document.createElement('div');
		this._modal.className = 'laka-port-modal';
		this._applyModalTheme();
		const itemHtml = items => items.map(([label, value]) => `<div class="laka-neighbor-modal-item${label === 'Descripción' ? ' full' : ''}"><span class="laka-neighbor-modal-label">${this._escapeTopology(label)}</span><span class="laka-neighbor-modal-value">${this._escapeTopology(value)}</span></div>`).join('');
		this._modal.innerHTML = `<div class="laka-modal-box"><div class="laka-modal-head"><div><div class="laka-modal-title">${this._escapeTopology(title)}</div><div class="laka-modal-subtitle">${this._escapeTopology(subtitle)}</div></div><button type="button" class="laka-modal-close" aria-label="Cerrar">×</button></div><div class="laka-neighbor-compare"><section class="laka-neighbor-side"><div class="laka-neighbor-side-title">${this._escapeTopology(localTitle)}</div><div class="laka-neighbor-side-body">${itemHtml(localItems)}</div></section><div class="laka-neighbor-bridge"><span>↔</span><span class="laka-neighbor-protocol-badge">${this._escapeTopology(String(protocol).toUpperCase())}</span></div><section class="laka-neighbor-side"><div class="laka-neighbor-side-title">${this._escapeTopology(remoteTitle)}</div><div class="laka-neighbor-side-body">${itemHtml(remoteItems)}</div></section></div>${openButton ? `<div class="laka-neighbor-modal-actions">${openButton}</div>` : ''}</div>`;
		this._modal.addEventListener('click', this._events.modal_click);
		document.addEventListener('keydown', this._events.modal_keydown);
		document.body.append(this._modal);
	}

	_selectTopologyLink(panel, linkId) {
		if (panel === null) return;
		panel.dataset.selectedLink = linkId;
		this._renderTopology(panel);
	}

	_setTopologyActionState(panel) {
		const {links} = this._topologyData(panel);
		const link = links.find(candidate => String(candidate.id) === String(panel?.dataset.selectedLink || ''));
		const selected = panel?.dataset.canManage === '1' && link?.source === 'manual';
		for (const action of ['edit', 'delete']) {
			const button = panel?.querySelector(`[data-topology-action="${action}"]`);
			if (button !== null && button !== undefined) button.disabled = !selected;
		}
	}

	_handleTopologyAction(button) {
		const panel = button.closest('.laka-topology');
		if (panel === null) return;
		const action = button.dataset.topologyAction || '';
		if (action === 'endpoints') {
			const selector = panel.querySelector('.laka-endpoint-selector');
			selector?.classList.toggle('open');
			button.classList.toggle('active', selector?.classList.contains('open'));
			return;
		}
		if (action === 'fit') {
			panel.querySelector('.laka-topology-stage')?.scrollTo({top: 0, left: 0});
			this._renderTopology(panel);
			return;
		}
		const {links} = this._topologyData(panel);
		const selected = links.find(link => String(link.id) === panel.dataset.selectedLink);
		if (action === 'add') this._openTopologyForm(panel, null);
		else if (action === 'edit' && selected) this._openTopologyForm(panel, selected);
		else if (action === 'delete' && selected) {
			if (window.confirm(`¿Eliminar el enlace ${selected.an || selected.ai} ↔ ${selected.bn || selected.bi}?`)) {
				this._deleteTopologyLink(panel, selected);
			}
		}
	}

	_selectTopologyEndpoints(choice) {
		const panel = choice.closest('.laka-topology');
		if (panel === null) return;
		let selected = [];
		try { selected = JSON.parse(panel.dataset.endpointHosts || '[]').map(String); }
		catch (error) {}
		const hostid = choice.dataset.topologyEndpointHost;
		if (hostid !== undefined) {
			selected = selected.includes(String(hostid))
				? selected.filter(candidate => candidate !== String(hostid)) : [...selected, String(hostid)];
		}
		else if (choice.dataset.topologyEndpointAction === 'all') {
			selected = [...new Set(this._topologyData(panel).endpoints.map(endpoint => String(endpoint.parent)))];
		}
		else if (choice.dataset.topologyEndpointAction === 'hide') selected = [];
		panel.dataset.endpointHosts = JSON.stringify(selected);
		const console = panel.closest('.laka-console');
		try { localStorage.setItem(`${console?.dataset.consoleKey || 'laka-topology'}-endpoint-hosts`, panel.dataset.endpointHosts); }
		catch (error) {}
		this._syncTopologyEndpointControls(panel);
		this._renderTopology(panel);
	}

	_syncTopologyEndpointControls(panel) {
		let selected = [];
		try { selected = JSON.parse(panel.dataset.endpointHosts || '[]').map(String); }
		catch (error) {}
		for (const chip of panel.querySelectorAll('[data-topology-endpoint-host]')) {
			chip.classList.toggle('active', selected.includes(String(chip.dataset.topologyEndpointHost)));
		}
		const {endpoints} = this._topologyData(panel);
		const visibleCount = endpoints.filter(endpoint => selected.includes(String(endpoint.parent))).length;
		const button = panel.querySelector('[data-topology-action="endpoints"]');
		if (button) button.textContent = `Endpoints · ${selected.length} equipos · ${visibleCount}`;
	}

	_openTopologyForm(panel, link) {
		this._closePortModal();
		const {hosts} = this._topologyData(panel);
		const current = panel.dataset.currentHostid || '';
		const selectedA = String(link?.a || current || hosts[0]?.id || '');
		const selectedB = String(link?.b || hosts.find(host => String(host.id) !== selectedA)?.id || '');
		const options = selected => hosts.map(host => `<option value="${this._escapeTopology(host.id)}"${String(host.id) === selected ? ' selected' : ''}>${this._escapeTopology(host.name)}</option>`).join('');
		this._modal = document.createElement('div');
		this._modal.className = 'laka-port-modal';
		this._applyModalTheme();
		this._modal.innerHTML = `<div class="laka-modal-box"><div class="laka-modal-head"><div><div class="laka-modal-title">${link ? 'Editar enlace' : 'Agregar enlace manual'}</div><div class="laka-modal-subtitle">Equipo e interfaz en cada extremo</div></div><button type="button" class="laka-modal-close">×</button></div>
			<div class="laka-topology-form-grid">
				<div class="laka-topology-field"><label>Equipo A</label><select data-field="host-a">${options(selectedA)}</select></div>
				<div class="laka-topology-field"><label>Equipo B</label><select data-field="host-b">${options(selectedB)}</select></div>
				<div class="laka-topology-field"><label>Interfaz A</label><select data-field="port-a"></select></div>
				<div class="laka-topology-field"><label>Interfaz B</label><select data-field="port-b"></select></div>
				<div class="laka-topology-field"><label>Tipo de enlace</label><select data-field="type"><option value="uplink">Uplink</option><option value="trunk">Trunk</option><option value="wan">WAN</option><option value="ha">HA</option><option value="fortilink">FortiLink</option><option value="other">Otro</option></select></div>
				<div class="laka-topology-field"><label>Descripción</label><input data-field="description" maxlength="255" value="${this._escapeTopology(link?.description || '')}"></div>
			</div><div class="laka-topology-form-note">La conexión se guarda como una macro del host A y queda disponible para los demás usuarios.</div><div class="laka-topology-form-actions"><button type="button" class="laka-topology-button laka-topology-cancel">Cancelar</button><button type="button" class="laka-topology-button primary laka-topology-save">Guardar enlace</button></div></div>`;
		document.body.append(this._modal);
		const hostA = this._modal.querySelector('[data-field="host-a"]');
		const hostB = this._modal.querySelector('[data-field="host-b"]');
		const fillPorts = (hostSelect, portSelect, selectedIndex) => {
			const host = hosts.find(candidate => String(candidate.id) === hostSelect.value);
			portSelect.innerHTML = (host?.ports || []).map(port => `<option value="${this._escapeTopology(port.index)}" data-name="${this._escapeTopology(port.name)}"${String(port.index) === String(selectedIndex || '') ? ' selected' : ''}>${this._escapeTopology(port.name)}${port.alias ? ' · ' + this._escapeTopology(port.alias) : ''}</option>`).join('');
		};
		const portA = this._modal.querySelector('[data-field="port-a"]');
		const portB = this._modal.querySelector('[data-field="port-b"]');
		fillPorts(hostA, portA, link?.ai);
		fillPorts(hostB, portB, link?.bi);
		this._modal.querySelector('[data-field="type"]').value = link?.type || 'uplink';
		hostA.addEventListener('change', () => fillPorts(hostA, portA, ''));
		hostB.addEventListener('change', () => fillPorts(hostB, portB, ''));
		this._modal.querySelector('.laka-modal-close').addEventListener('click', () => this._closePortModal());
		this._modal.querySelector('.laka-topology-cancel').addEventListener('click', () => this._closePortModal());
		this._modal.addEventListener('click', event => { if (event.target === this._modal) this._closePortModal(); });
		this._modal.querySelector('.laka-topology-save').addEventListener('click', () => this._saveTopologyForm(panel, link));
		document.addEventListener('keydown', this._events.modal_keydown);
	}

	_saveTopologyForm(panel, link) {
		const box = this._modal?.querySelector('.laka-modal-box');
		if (!box) return;
		box.querySelector('.laka-topology-error')?.remove();
		const field = name => box.querySelector(`[data-field="${name}"]`);
		const portA = field('port-a'), portB = field('port-b');
		const payload = {
			operation: 'save', macro_id: link?.macro_id || '', link_id: link?.id || '',
			hostid_a: field('host-a').value, hostid_b: field('host-b').value,
			port_index_a: portA.value, port_index_b: portB.value,
			port_name_a: portA.selectedOptions[0]?.dataset.name || '',
			port_name_b: portB.selectedOptions[0]?.dataset.name || '',
			link_type: field('type').value, description: field('description').value
		};
		this._topologyRequest(payload).then(response => {
			const {links} = this._topologyData(panel);
			const saved = response.data?.[0];
			if (!saved) return;
			const updated = links.filter(candidate => String(candidate.id) !== String(link?.id || saved.id));
			updated.push(saved);
			this._updateTopologyLinks(updated);
			this._closePortModal();
		}).catch(error => {
			const message = document.createElement('div');
			message.className = 'laka-topology-error';
			message.textContent = error.message || 'No se pudo guardar el enlace.';
			box.querySelector('.laka-topology-form-actions').before(message);
		});
	}

	_deleteTopologyLink(panel, link) {
		this._topologyRequest({operation: 'delete', macro_id: link.macro_id || ''})
			.then(() => this._updateTopologyLinks(this._topologyData(panel).links.filter(candidate => String(candidate.id) !== String(link.id))))
			.catch(error => window.alert(error.message || 'No se pudo eliminar el enlace.'));
	}

	_topologyRequest(payload) {
		const url = new Curl('zabbix.php');
		url.setArgument('action', 'widget.laka_network_switch.topology');
		const token = this._target.querySelector('.laka-console')?.dataset.csrfToken || '';
		return fetch(url.getUrl(), {
			method: 'POST', credentials: 'same-origin',
			headers: {'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest'},
			body: JSON.stringify({...payload, _csrf_token: token})
		}).then(async result => {
			let response = JSON.parse((await result.text()).replace(/^\uFEFF/, '').trim());
			if (response.body && typeof response.body === 'object') response = response.body;
			if (typeof response.main_block === 'string') response = JSON.parse(response.main_block);
			if (!response.ok) throw new Error(response.error || `Respuesta inválida (HTTP ${result.status})`);
			return response;
		});
	}

	_updateTopologyLinks(links) {
		for (const panel of this._target.querySelectorAll('.laka-topology')) {
			panel.dataset.links = JSON.stringify(links);
			panel.dataset.selectedLink = '';
			this._renderTopology(panel);
		}
		const count = this._target.querySelector('.laka-topology-nav-count');
		if (count) count.textContent = String(links.length);
	}

	_applyPortFilter(filter, source) {
		const root = source?.closest('.laka-sw');
		if (!root) return;
		for (const button of root.querySelectorAll('[data-filter]')) button.classList.remove('active');
		source.classList.add('active');
		let visible = 0;
		for (const port of root.querySelectorAll('.laka-port')) {
			const errors = Number(port.dataset.errors || 0) + Number(port.dataset.discards || 0);
			const utilization = Number(port.dataset.utilValue || 0);
			const show = filter === 'all'
				|| ['up', 'down', 'disabled', 'unknown'].includes(filter) && port.dataset.status === filter
				|| filter === 'problem' && port.dataset.hasProblem === '1'
				|| filter === 'error' && errors > 0
				|| filter === 'util' && utilization >= 80;
			port.classList.toggle('filtered-out', !show);
			if (show) visible++;
		}
		for (const row of root.querySelectorAll('.laka-interface-row')) {
			const errors = Number(row.dataset.errors || 0);
			const utilization = Number(row.dataset.utilValue || 0);
			const show = filter === 'all'
				|| ['up', 'down', 'disabled', 'unknown'].includes(filter) && row.dataset.status === filter
				|| filter === 'problem' && row.dataset.hasProblem === '1'
				|| filter === 'error' && errors > 0
				|| filter === 'util' && utilization >= 80;
			row.classList.toggle('filtered-out', !show);
		}
		const search = root.querySelector('.laka-interface-search');
		if (search !== null) this._searchInterfaceList(search);
		root.classList.toggle('filter-empty', visible === 0);
	}

	_closePortModal() {
		if (this._modal !== undefined && this._modal !== null) {
			this._modal.removeEventListener('click', this._events.modal_click);
			this._modal.remove();
			this._modal = null;
		}
		this._activePortData = null;
		this._activeSensorData = null;
		document.removeEventListener('keydown', this._events.modal_keydown);
	}
}
