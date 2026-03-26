<?php

namespace App\Livewire\Admin;

use App\Exceptions\ApiException;
use App\Exceptions\ApiValidationException;
use Livewire\Component;

abstract class BaseResourcePage extends Component
{
    public string $search = '';
    public string $status = 'all';
    public int $page = 1;
    public int $pageSize = 10;
    public bool $showModal = false;
    public bool $showDetailModal = false;
    public bool $editing = false;
    public ?int $editingId = null;
    public array $form = [];
    public array $detailRecord = [];

    protected array $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => 'all'],
        'page' => ['except' => 1],
    ];

    abstract protected function serviceClass(): string;

    abstract protected function pageMeta(): array;

    abstract protected function fields(): array;

    abstract protected function columns(): array;

    abstract protected function rules(): array;

    public function mount(): void
    {
        $this->resetForm();
    }

    public function updatedSearch(): void
    {
        $this->page = 1;
    }

    public function updatedStatus(): void
    {
        $this->page = 1;
    }

    public function openCreate(): void
    {
        $this->editing = false;
        $this->editingId = null;
        $this->resetForm();
        $this->showModal = true;
    }

    public function openEdit(int $id): void
    {
        try {
            $record = data_get($this->service()->find($id), 'data', []);
        } catch (ApiException $exception) {
            session()->flash('error', $exception->getMessage());

            return;
        }

        $this->editing = true;
        $this->editingId = $id;
        $this->form = $this->formFromRecord($record);
        $this->resetValidation();
        $this->showModal = true;
    }

    public function openView(int $id): void
    {
        try {
            $this->detailRecord = data_get($this->service()->find($id), 'data', []);
        } catch (ApiException $exception) {
            session()->flash('error', $exception->getMessage());

            return;
        }

        $this->showDetailModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->showDetailModal = false;
    }

    public function save(): void
    {
        $this->validate($this->rules());
        $payload = $this->normalizePayload($this->form);

        try {
            if ($this->editing && $this->editingId) {
                $this->service()->update($this->editingId, $payload);
                session()->flash('success', 'Registro actualizado correctamente.');
            } else {
                $this->service()->create($payload);
                session()->flash('success', 'Registro creado correctamente.');
            }

            $this->showModal = false;
            $this->resetForm();
        } catch (ApiValidationException $exception) {
            foreach ($exception->errors() as $field => $messages) {
                $property = "form.{$field}";

                foreach ((array) $messages as $message) {
                    $this->addError($property, $message);
                }
            }
        } catch (ApiException $exception) {
            session()->flash('error', $exception->getMessage());
        }
    }

    public function changeStatus(int $id, string $currentState): void
    {
        if (!$this->quickToggleEnabled()) {
            return;
        }

        try {
            $this->service()->patchStatus($id, $this->statePayload($this->nextState($currentState)));
            session()->flash('success', 'Estado actualizado correctamente.');
        } catch (ApiException $exception) {
            session()->flash('error', $exception->getMessage());
        }
    }

    public function gotoPage(int $page): void
    {
        $this->page = max(1, $page);
    }

    protected function service(): object
    {
        return app($this->serviceClass());
    }

    protected function quickToggleEnabled(): bool
    {
        return false;
    }

    protected function statusTabs(): array
    {
        return ['all' => 'Todos'];
    }

    protected function statePayload(string $state): array
    {
        return ['state' => $state];
    }

    protected function nextState(string $currentState): string
    {
        return $currentState === 'active' ? 'inactive' : 'active';
    }

    protected function selectOptions(): array
    {
        return [];
    }

    protected function safeSelectOptions(): array
    {
        try {
            return $this->selectOptions();
        } catch (ApiException $exception) {
            session()->flash('error', $exception->getMessage());

            return [];
        }
    }

    protected function stats(array $items, array $pagination): array
    {
        return [
            [
                'label' => 'Total registros',
                'value' => data_get($pagination, 'total_items', 0),
                'tone' => 'blue',
            ],
        ];
    }

    protected function listQuery(): array
    {
        return [
            'page' => $this->page,
            'page_size' => $this->pageSize,
            'search' => $this->search ?: null,
            'status' => $this->status !== 'all' ? $this->status : null,
        ];
    }

    protected function resetForm(): void
    {
        $this->form = [];

        foreach ($this->fields() as $field) {
            $type = $field['type'] ?? 'text';
            $this->form[$field['key']] = $field['default']
                ?? match ($type) {
                    'checkbox-group' => [],
                    'switch' => false,
                    default => '',
                };
        }

        $this->resetValidation();
    }

    protected function formFromRecord(array $record): array
    {
        $form = [];

        foreach ($this->fields() as $field) {
            $value = data_get($record, $field['record_key'] ?? $field['key']);
            $type = $field['type'] ?? 'text';

            if ($type === 'datetime-local' && filled($value)) {
                $value = substr((string) $value, 0, 16);
            }

            if ($type === 'time' && filled($value)) {
                $value = substr((string) $value, 0, 5);
            }

            if ($type === 'switch') {
                $value = $value === ($field['checked_value'] ?? 'active');
            }

            if ($type === 'checkbox-group') {
                $value = is_array($value) ? $value : [];
            }

            $form[$field['key']] = $value ?? ($field['default'] ?? '');
        }

        return $form;
    }

    protected function normalizePayload(array $form): array
    {
        $payload = [];

        foreach ($this->fields() as $field) {
            $key = $field['key'];
            $value = $form[$key] ?? null;

            if (($field['create_only'] ?? false) && $this->editing) {
                continue;
            }

            if (($field['type'] ?? 'text') === 'password' && $this->editing && blank($value)) {
                continue;
            }

            if (($field['type'] ?? 'text') === 'switch') {
                $value = $value
                    ? ($field['checked_value'] ?? 'active')
                    : ($field['unchecked_value'] ?? 'inactive');
            }

            if ($value === '' && ($field['nullable'] ?? true)) {
                $value = null;
            }

            $payload[$key] = $value;
        }

        return $payload;
    }

    public function formatCell(mixed $value, string $type = 'text'): string
    {
        if ($value === null || $value === '') {
            return '—';
        }

        return match ($type) {
            'number' => number_format((float) $value, 2),
            'datetime' => substr((string) $value, 0, 16),
            'date' => substr((string) $value, 0, 10),
            'list' => collect((array) $value)->take(3)->implode(', '),
            default => (string) $value,
        };
    }

    public function stateBadgeClass(string $state): string
    {
        return match ($state) {
            'active', 'available', 'Pendiente', 'Entregado', 'completed' => 'status-badge active',
            'inactive', 'Cancelado' => 'status-badge inactive',
            'En ruta', 'scheduled', 'on_leave' => 'status-badge pending',
            'Retrasado', 'maintenance' => 'status-badge danger',
            default => 'status-badge info',
        };
    }

    public function badgeStyle(array $item, array $column): string
    {
        $colorKey = data_get($column, 'color_key');
        $color = $colorKey ? data_get($item, $colorKey) : null;
        $rgb = $this->hexToRgb(is_string($color) ? $color : null);

        if (!$rgb) {
            return '';
        }

        return sprintf(
            'background-color: rgba(%d, %d, %d, 0.14); color: %s; border: 1px solid rgba(%d, %d, %d, 0.24);',
            $rgb['r'],
            $rgb['g'],
            $rgb['b'],
            $color,
            $rgb['r'],
            $rgb['g'],
            $rgb['b'],
        );
    }

    protected function hexToRgb(?string $color): ?array
    {
        if (!is_string($color) || !preg_match('/^#([0-9a-f]{3}|[0-9a-f]{6})$/i', $color)) {
            return null;
        }

        $hex = ltrim($color, '#');

        if (strlen($hex) === 3) {
            $hex = collect(str_split($hex))
                ->map(fn (string $value) => $value.$value)
                ->implode('');
        }

        return [
            'r' => hexdec(substr($hex, 0, 2)),
            'g' => hexdec(substr($hex, 2, 2)),
            'b' => hexdec(substr($hex, 4, 2)),
        ];
    }

    public function render()
    {
        try {
            $listing = $this->service()->list($this->listQuery());
        } catch (ApiException $exception) {
            session()->flash('error', $exception->getMessage());
            $listing = ['data' => ['items' => [], 'pagination' => ['page' => 1, 'page_size' => 10, 'total_items' => 0, 'total_pages' => 1]]];
        }

        $items = data_get($listing, 'data.items', []);
        $pagination = data_get($listing, 'data.pagination', []);

        return view('livewire.admin.resource-page', [
            'meta' => $this->pageMeta(),
            'fields' => $this->fields(),
            'columns' => $this->columns(),
            'items' => $items,
            'pagination' => $pagination,
            'stats' => $this->stats($items, $pagination),
            'statusTabs' => $this->statusTabs(),
            'selectOptions' => $this->safeSelectOptions(),
            'quickToggle' => $this->quickToggleEnabled(),
        ]);
    }
}
