<?php

namespace AwemaPL\Task\User\Sections\Statuses\Models\Contracts;

interface Status
{
    /**
     * Get the user that owns the status.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user();
}
