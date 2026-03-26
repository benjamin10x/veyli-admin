<div>
    <div class="page-header">
        <div class="page-header-top">
            <div>
                <h2 class="page-title">{{ $meta['title'] }}</h2>
                <p class="page-subtitle">{{ $meta['subtitle'] }}</p>
            </div>
            <button type="button" class="btn-primary" wire:click="openCreate">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                {{ $meta['create_label'] }}
            </button>
        </div>
    </div>

    <div class="stats-grid" style="margin-bottom: 20px;">
        @foreach ($stats as $stat)
            <div class="stat-card">
                <div class="stat-icon {{ $stat['tone'] ?? 'blue' }}"></div>
                <div class="stat-info">
                    <div class="stat-label">{{ $stat['label'] }}</div>
                    <div class="stat-value">{{ $stat['value'] }}</div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="table-card">
        <div class="table-card-header">
            <div>
                <h3 class="table-card-title">{{ $meta['title'] }}</h3>
                <p class="table-card-subtitle">{{ data_get($pagination, 'total_items', 0) }} registros</p>
            </div>
            <div class="table-filters" style="display:flex; gap:12px; align-items:center; flex-wrap:wrap;">
                <div class="filter-tabs">
                    @foreach ($statusTabs as $value => $label)
                        <button type="button" class="filter-tab {{ $status === $value ? 'active' : '' }}" wire:click="$set('status', '{{ $value }}')">
                            {{ $label }}
                        </button>
                    @endforeach
                </div>
                <div class="search-box">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <input type="text" placeholder="{{ $meta['search_placeholder'] }}" wire:model.live.debounce.400ms="search">
                </div>
            </div>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    @foreach ($columns as $column)
                        <th>{{ $column['label'] }}</th>
                    @endforeach
                    <th style="width: 132px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($items as $item)
                    <tr>
                        @foreach ($columns as $column)
                            @php($value = data_get($item, $column['key']))
                            <td>
                                @if (($column['type'] ?? null) === 'badge')
                                    <span class="{{ $this->stateBadgeClass((string) $value) }}" style="{{ $this->badgeStyle($item, $column) }}">{{ $value ?: '—' }}</span>
                                @elseif (($column['type'] ?? null) === 'color')
                                    <div class="color-chip-wrap">
                                        <span class="color-chip" style="background-color: {{ $value ?: '#9ca3af' }};"></span>
                                    </div>
                                @else
                                    {{ $this->formatCell($value, $column['type'] ?? 'text') }}
                                @endif
                            </td>
                        @endforeach
                        <td>
                            <div class="table-actions">
                                <button type="button" class="action-btn" wire:click="openView({{ data_get($item, 'id') }})" title="Ver registro" aria-label="Ver registro">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </button>

                                <button type="button" class="action-btn edit" wire:click="openEdit({{ data_get($item, 'id') }})" onclick="return confirm('¿Quieres editar este registro?')" title="Editar registro" aria-label="Editar registro">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M12 20h9"></path>
                                        <path d="M16.5 3.5a2.12 2.12 0 1 1 3 3L7 19l-4 1 1-4 12.5-12.5z"></path>
                                    </svg>
                                </button>

                                @if ($quickToggle && data_get($item, 'state'))
                                    <button
                                        type="button"
                                        class="table-switch {{ data_get($item, 'state') === 'active' ? 'on' : 'off' }}"
                                        wire:click="changeStatus({{ data_get($item, 'id') }}, '{{ data_get($item, 'state') }}')"
                                        onclick="return confirm('¿Quieres {{ data_get($item, 'state') === 'active' ? 'inactivar' : 'activar' }} este registro?')"
                                        title="{{ data_get($item, 'state') === 'active' ? 'Desactivar' : 'Activar' }}"
                                        aria-label="{{ data_get($item, 'state') === 'active' ? 'Desactivar' : 'Activar' }}"
                                    >
                                        <span></span>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($columns) + 1 }}" style="text-align:center; padding: 28px 16px;">
                            No hay registros disponibles.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="resource-pagination">
            <span class="table-card-subtitle">Pagina {{ data_get($pagination, 'page', 1) }} de {{ data_get($pagination, 'total_pages', 1) }}</span>
            <div class="resource-pagination-actions">
                <button
                    type="button"
                    class="action-btn"
                    wire:click="gotoPage({{ max(1, data_get($pagination, 'page', 1) - 1) }})"
                    title="Pagina anterior"
                    aria-label="Pagina anterior"
                    @disabled(data_get($pagination, 'page', 1) <= 1)
                >
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                </button>
                <div class="resource-page-indicator">{{ data_get($pagination, 'page', 1) }}</div>
                <button
                    type="button"
                    class="action-btn"
                    wire:click="gotoPage({{ min(data_get($pagination, 'total_pages', 1), data_get($pagination, 'page', 1) + 1) }})"
                    title="Pagina siguiente"
                    aria-label="Pagina siguiente"
                    @disabled(data_get($pagination, 'page', 1) >= data_get($pagination, 'total_pages', 1))
                >
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    @if ($showModal)
        <div class="modal-overlay" style="display:flex;">
            <div class="resource-modal-card">
                <div class="modal-header">
                    <div>
                        <h3 class="modal-title">{{ $editing ? 'Editar registro' : 'Nuevo registro' }}</h3>
                        <p class="modal-subtitle">Completa los datos requeridos.</p>
                    </div>
                    <button type="button" class="modal-close" wire:click="closeModal" aria-label="Cerrar modal">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>

                <form wire:submit.prevent="save" onsubmit="return confirm('¿Deseas guardar este cambio?')">
                    <div class="resource-form-grid">
                        @foreach ($fields as $field)
                            @if (!(($field['create_only'] ?? false) && $editing))
                                <div class="{{ in_array($field['type'], ['textarea']) || ($field['full_width'] ?? false) ? 'resource-form-span ' : '' }}{{ $field['wrapper_class'] ?? '' }}">
                                    <label class="form-label">{{ $field['label'] }}</label>

                                    @if (($field['type'] ?? 'text') === 'textarea')
                                        <textarea wire:model="form.{{ $field['key'] }}" rows="3" class="form-input"></textarea>
                                    @elseif (($field['type'] ?? 'text') === 'switch')
                                        <label class="settings-switch">
                                            <input type="checkbox" wire:model="form.{{ $field['key'] }}">
                                            <span class="settings-switch-track"><span class="settings-switch-thumb"></span></span>
                                            <span class="settings-switch-copy">{{ $field['switch_label'] ?? 'Activo' }}</span>
                                        </label>
                                    @elseif (($field['type'] ?? 'text') === 'checkbox-group')
                                        @php($groups = $selectOptions[$field['key']] ?? [])
                                        <div class="permissions-panel">
                                            @foreach ($groups as $group)
                                                <div class="permission-group-card">
                                                    <div class="permission-group-title">{{ $group['label'] }}</div>
                                                    <div class="permission-check-list">
                                                        @foreach (($group['options'] ?? []) as $option)
                                                            <label class="permission-check-item">
                                                                <input type="checkbox" wire:model="form.{{ $field['key'] }}" value="{{ $option['value'] }}">
                                                                <span>{{ $option['label'] }}</span>
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @elseif (($field['type'] ?? 'text') === 'select')
                                        @php($options = $selectOptions[$field['key']] ?? [])
                                        <select wire:model="form.{{ $field['key'] }}" class="form-select">
                                            <option value="">Selecciona...</option>
                                            @foreach ($options as $option)
                                                <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
                                            @endforeach
                                        </select>
                                        @if (empty($options) && filled($field['empty_message'] ?? null))
                                            <div class="form-hint">{{ $field['empty_message'] }}</div>
                                        @endif
                                    @else
                                        <input type="{{ $field['type'] ?? 'text' }}" wire:model="form.{{ $field['key'] }}" class="form-input">
                                    @endif

                                    @error('form.'.$field['key'])
                                        <div class="form-hint text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn-secondary" wire:click="closeModal">Cancelar</button>
                        <button type="submit" class="btn-primary">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                                <polyline points="17 21 17 13 7 13 7 21"></polyline>
                                <polyline points="7 3 7 8 15 8"></polyline>
                            </svg>
                            {{ $editing ? 'Guardar cambios' : 'Crear registro' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    @if ($showDetailModal)
        <div class="modal-overlay" style="display:flex;">
            <div class="resource-modal-card resource-modal-detail">
                <div class="modal-header">
                    <div>
                        <h3 class="modal-title">Vista del registro</h3>
                        <p class="modal-subtitle">Consulta el detalle completo antes de editar o paginar.</p>
                    </div>
                    <button type="button" class="modal-close" wire:click="closeModal" aria-label="Cerrar vista">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>

                <div class="resource-detail-grid">
                    @foreach ($columns as $column)
                        <div class="resource-detail-card">
                            <div class="resource-detail-label">{{ $column['label'] }}</div>
                            <div class="resource-detail-value">
                                @php($value = data_get($detailRecord, $column['key']))
                                @if (($column['type'] ?? null) === 'badge')
                                    <span class="{{ $this->stateBadgeClass((string) $value) }}" style="{{ $this->badgeStyle($detailRecord, $column) }}">{{ $value ?: '—' }}</span>
                                @elseif (($column['type'] ?? null) === 'color')
                                    <div class="color-chip-wrap">
                                        <span class="color-chip color-chip-lg" style="background-color: {{ $value ?: '#9ca3af' }};"></span>
                                    </div>
                                @else
                                    {{ $this->formatCell($value, $column['type'] ?? 'text') }}
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-secondary" wire:click="closeModal">Cerrar</button>
                    <button type="button" class="btn-primary" wire:click="openEdit({{ data_get($detailRecord, 'id') }})">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 20h9"></path>
                            <path d="M16.5 3.5a2.12 2.12 0 1 1 3 3L7 19l-4 1 1-4 12.5-12.5z"></path>
                        </svg>
                        Editar
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
