<?php

namespace App\Services;

use App\Models\Setting;

class SettingService
{
    protected array $cache = [];

    public function get(string $key, mixed $default = null): mixed
    {
        if (! array_key_exists($key, $this->cache)) {
            $this->cache[$key] = Setting::where('key', $key)->value('value');
        }

        return $this->cache[$key] ?? $default;
    }

    public function all(): array
    {
        if ($this->cache === []) {
            $this->cache = Setting::pluck('value', 'key')->toArray();
        }

        return $this->cache;
    }
}
