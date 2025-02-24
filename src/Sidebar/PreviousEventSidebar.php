<?php

namespace DefaultSidebar\Sidebar;

use App\Classes\Sidebar;
use App\Models\Enums\ScheduledConferenceState;
use App\Models\ScheduledConference;
use Illuminate\Contracts\View\View;

class PreviousEventSidebar extends Sidebar
{
    protected ?string $view = 'DefaultSidebar::sidebar.previous-event';

    public function getId(): string
    {
        return 'previous-event';
    }

    public function getName(): string
    {
        return 'Previous Event';
    }

    public function render(): View
    {
        return view($this->view, $this->getViewData());
    }

    public function getViewData(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'previousEvents' => ScheduledConference::query()
                ->withoutGlobalScopes()
                ->withoutTrashed()
                ->with('conference')
                ->where('id', '!=', app()->getCurrentScheduledConferenceId())
                ->where('conference_id', app()->getCurrentConferenceId())
                ->where('state', ScheduledConferenceState::Archived)
                ->orderBy('date_start', 'desc')
                ->take(3)
                ->get(),
        ];
    }
}
