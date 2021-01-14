<?php

namespace AwemaPL\Task\User\Sections\Statuses\Http\Controllers;

use AwemaPL\Task\Client\Api\ConnectionValidator;
use AwemaPL\Task\Client\Api\TaskApiException;
use AwemaPL\Task\Client\TaskClient;
use AwemaPL\Task\User\Sections\Statuses\Http\Requests\WidgetStatus;
use AwemaPL\Task\User\Sections\Statuses\Models\Status;
use AwemaPL\Task\Admin\Sections\Settings\Repositories\Contracts\SettingRepository;
use AwemaPL\Auth\Controllers\Traits\RedirectsTo;
use AwemaPL\Task\User\Sections\Statuses\Http\Requests\StoreStatus;
use AwemaPL\Task\User\Sections\Statuses\Http\Requests\UpdateStatus;
use AwemaPL\Task\User\Sections\Statuses\Repositories\Contracts\StatusRepository;
use AwemaPL\Task\User\Sections\Statuses\Resources\EloquentStatus;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class StatusController extends Controller
{
    use RedirectsTo, AuthorizesRequests;

    /** @var StatusRepository $statuses */
    protected $statuses;

    /** @var SettingRepository */
    protected $settings;

    public function __construct(StatusRepository $statuses, SettingRepository $settings)
    {
        $this->statuses = $statuses;
        $this->settings = $settings;
    }

    /**
     * Display statuses
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('task::user.sections.statuses.index');
    }

    /**
     * Request scope
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function scope(Request $request)
    {
        return EloquentStatus::collection(
            $this->statuses->scope($request)
                ->isOwner()
                ->latest()->smartPaginate()
        );
    }

    /**
     * Interrupt status
     *
     * @param $id
     * @return array
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function interrupt($id)
    {
        $this->authorize('isOwner', Status::find($id));
        $this->statuses->interrupt($id);
        return notify(_p('task::notifies.user.status.status_abort_successfully', 'Status abort successfully.'));
    }

    /**
     * Widget status
     *
     * @param WidgetStatus $request
     * @return array
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function widget(WidgetStatus $request)
    {
        $userId = $request->user()->id;
        $statuses = $this->statuses->getWidgetStatuses($userId, $request->types);
        return $this->ajax($statuses);
    }
}
