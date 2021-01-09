<?php

namespace AwemaPL\Task\User\Sections\Statuses\Repositories;

use AwemaPL\Task\User\Sections\Statuses\Models\Contracts\Taskable;
use AwemaPL\Task\User\Sections\Statuses\Models\Status;
use AwemaPL\Task\User\Sections\Statuses\Repositories\Contracts\StatusRepository;
use AwemaPL\Task\User\Sections\Statuses\Scopes\EloquentStatusescopes;
use AwemaPL\Repository\Eloquent\BaseRepository;
use AwemaPL\Task\User\Sections\Statuses\Services\TaskStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EloquentStatusRepository extends BaseRepository implements StatusRepository
{

    protected $searchable = [

    ];

    public function entity()
    {
        return Status::class;
    }

    public function scope($request)
    {
        // apply build-in scopes
        parent::scope($request);

        // apply custom scopes
        $this->entity = (new EloquentStatusescopes($request))->scope($this->entity);
        return $this;
    }

    /**
     * Create new role
     *
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        $data['user_id'] = $data['user_id'] ?? Auth::id();
        return Status::create($data);
    }

    /**
     * Update feature
     *
     * @param array $data
     * @param int $id
     * @param string $attribute
     *
     * @return int
     */
    public function update(array $data, $id, $attribute = 'id')
    {
        return parent::update($data, $id, $attribute);
    }

    /**
     * Interrupt
     *
     * @param int $id
     * @return array
     */
    public function interrupt($id){
        $this->update([
            'interrupt' => true,
        ], $id);
    }

    /**
     * Exists
     *
     * @param string $type
     * @param Taskable|null $taskable
     * @param array $statuses
     * @return bool
     */
    public function exists(string $type, ?Taskable $taskable = null, array $statuses =[TaskStatus::QUEUED, TaskStatus::EXECUTING]): bool{
        $query = Status::where('user_id', Auth::id())
            ->where('type', $type)
            ->whereIn('status', $statuses);
        if ($taskable){
            $query->where('taskable_type', get_class($taskable))
                ->where('taskable_id', $taskable->getKey());
        }
        return $query->exists();
    }
}
