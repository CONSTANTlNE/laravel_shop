@php
    // Provide shared sorting helpers for blade tables.
    // Defines: $currentSortBy, $currentSortDir, $sortLink, $sortIcon
    // Only defines if not already set to avoid overriding parent scopes.
    if (!isset($currentSortBy)) {
        $currentSortBy = request()->query('sort_by', $sortBy ?? 'created_at');
    }
    if (!isset($currentSortDir)) {
        $currentSortDir = strtolower(request()->query('sort_dir', $sortDir ?? 'desc')) === 'asc' ? 'asc' : 'desc';
    }

    if (!isset($sortLink) || !is_callable($sortLink)) {
        $sortLink = function (string $col) use ($currentSortBy, $currentSortDir) {
            $dir = $currentSortBy === $col ? ($currentSortDir === 'asc' ? 'desc' : 'asc') : 'asc';
            return request()->fullUrlWithQuery(['sort_by' => $col, 'sort_dir' => $dir]);
        };
    }

    if (!isset($sortIcon) || !is_callable($sortIcon)) {
        $sortIcon = function (string $col) use ($currentSortBy, $currentSortDir) {
            if ($currentSortBy !== $col) {
                return '';
            }
            return $currentSortDir === 'asc' ? '▲' : '▼';
        };
    }
@endphp
