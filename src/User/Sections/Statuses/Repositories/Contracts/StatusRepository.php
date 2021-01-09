<?php

namespace AwemaPL\Task\User\Sections\Statuses\Repositories\Contracts;

use AwemaPL\Task\User\Sections\Statuses\Models\Contracts\Taskable;
use AwemaPL\Task\User\Sections\Statuses\Services\TaskStatus;
use Illuminate\Http\Request;

interface StatusRepository
{
     /**
     * Scope status
     *
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function scope($request);

    /**
     * Create status
     *
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data);

    /**
     * Update feature
     *
     * @param array $data
     * @param int $id
     *
     * @return int
     */
    public function update(array $data, $id);

    /**
     * Interrupt
     *
     * @param int $id
     * @return array
     */
    public function interrupt($id);

    /**
     * Exists
     *
     * @param string $type
     * @param Taskable|null $taskable
     * @param array $statuses
     * @return bool
     */
    public function exists(string $type, ?Taskable $taskable = null, array $statuses =[TaskStatus::QUEUED, TaskStatus::EXECUTING]): bool;
}
