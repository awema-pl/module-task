<?php

namespace AwemaPL\Task\User\Sections\Statuses\Models;

use betterapp\LaravelDbEncrypter\Traits\EncryptableDbAttribute;
use Illuminate\Database\Eloquent\Model;
use AwemaPL\Task\User\Sections\Statuses\Models\Contracts\Status as StatusContract;

class Status extends Model implements StatusContract
{
    use EncryptableDbAttribute;

    /** @var array The attributes that should be encrypted/decrypted */
    protected $encryptable = [
        'api_key'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'user_id', 'taskable_id', 'taskable_type', 'type', 'type_key', 'interrupt', 'status','status_detail_key', 'status_detail_placeholders', 'error'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'taskable_id'=> 'integer',
        'interrupt' =>'boolean',
        'status_detail_placeholders' =>'array',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [];

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return config('task.database.tables.task_statuses');
    }

    /**
     * Get the user that owns the status.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo(config('auth.providers.users.model'));
    }

}
