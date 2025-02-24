<?php

namespace DefaultSidebar\Sidebar;

use App\Classes\Sidebar;
use App\Models\Timeline;
use Illuminate\Contracts\View\View;

class TimelineSidebar extends Sidebar
{
    protected ?string $view = 'DefaultSidebar::sidebar.timeline';

    public function getId(): string
    {
        return 'timeline';
    }

    public function getName(): string
    {
        return 'Timeline';
    }

    public function render(): View
    {
        return view($this->view, $this->getViewData());
    }

    public function getViewData(): array
    {

        $timelines = Timeline::all();

        $formattedTimelines = [];
        $today = now()->format('Y-m-d');
        $tommorow = now()->addDay()->format('Y-m-d');

        foreach ($timelines as $timeline) {
            $timelineDate = $timeline->date->format('Y-m-d');

            $modifier = match (true) {
                $timelineDate === $today => 'current_timeline',
                $timelineDate >= $tommorow => 'upcoming_timeline',
                default => 'past_timeline'
            };

            $formattedTimelines[$timeline->date->format('Y-m-d')] = [
                'modifier' => $modifier,
                'html' => $timeline->name,
            ];
        }

        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'timelines' => $formattedTimelines,
        ];
    }
}
