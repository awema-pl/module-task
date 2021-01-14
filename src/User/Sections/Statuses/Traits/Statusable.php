<?php

namespace AwemaPL\Task\User\Sections\Statuses\Traits;

use AwemaPL\Task\Common\Exceptions\StatusException;
use AwemaPL\Task\User\Sections\Statuses\Models\Contracts\Taskable;
use AwemaPL\Task\User\Sections\Statuses\Repositories\Contracts\StatusRepository;
use AwemaPL\Task\User\Sections\Statuses\Services\TaskStatus;
use Throwable;

trait Statusable
{
    /** @var int $statusId */
    private $statusId;

    /**
     * Add status
     *
     * @param string $type
     * @param string|null $typeKey
     * @param Taskable|null $taskable
     * @param bool $uniqueTaskable
     */
    public function addStatus(string $type, ?string $typeKey = null, ?Taskable $taskable = null, bool $uniqueTaskable = false, int $userId = null):void
    {
        $statuses = $this->getStatuses();
        if ($uniqueTaskable && $statuses->exists($type ,$taskable)){
            throw new StatusException('This task is active.', StatusException::ERROR_UNIQUE_TASK, 409, null,
                _p('task::exceptions.user.status.task_is_active', 'This task is active.'), null, false);
        }
        $data = [
            'type' =>$type,
            'type_key' =>$typeKey,
        ];
        if ($taskable){
            $data['taskable_type'] = get_class($taskable);
            $data['taskable_id'] = $taskable->getKey();
        }
        if ($userId){
            $data['user_id'] =$userId;
        }
        $status = $statuses->create($data);
        $this->statusId = $status->getKey();
    }

    /**
     * Set task status
     *
     * @param $status
     */
    public function setTaskStatus($status)
    {
        $statuses = $this->getStatuses();
        $statuses->update([
            'status' =>$status,
        ], $this->statusId);
    }

    /**
     * Set task failed
     *
     * @param Throwable $exception
     */
    public function setTaskFailed(Throwable $exception)
    {
        $statuses = $this->getStatuses();
        $statuses->update([
            'status' =>TaskStatus::FAILED,
            'error' => serialize($exception),
        ], $this->statusId);
    }

    /**
     * Get statuses
     *
     * @return StatusRepository
     */
    private function getStatuses(){
        /** @var StatusRepository $statuses */
        $statuses = app(StatusRepository::class);
        return $statuses;
    }
}
