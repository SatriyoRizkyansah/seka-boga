<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

trait HasUuidPrimaryKey
{
    use HasUuids;

    /**
     * Initialize the HasUuidPrimaryKey trait for an instance.
     *
     * @return void
     */
    public function initializeHasUuidPrimaryKey()
    {
        $this->keyType = 'string';
        $this->incrementing = false;
    }
}