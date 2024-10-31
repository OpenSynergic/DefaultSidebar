<?php

namespace DefaultSidebar;

use App\Classes\Plugin;
use App\Facades\Hook;
use App\Facades\SidebarFacade;

class DefaultSidebarPlugin extends Plugin
{
    public function boot()
    {
        SidebarFacade::register($this->getSidebars());

        $this->enablePublicAsset();

        Hook::add('Frontend::Views::Head', function ($hookName, &$output){
            $output .= '<link rel="stylesheet" href="'.$this->asset('defaultsidebar.css').'">';
        });
    }

    protected function getSidebars()
    {
        $conference = app()->getCurrentConference();
        $scheduledConference = app()->getCurrentScheduledConference();
        $sidebars = [];
        
        if($scheduledConference){
            return [
                new Sidebar\SubmitNowSidebar,
                new Sidebar\RegisterNowSidebar,
                new Sidebar\CommitteeSidebar,
                new Sidebar\TopicsSidebar,
                new Sidebar\TimelineSidebar,
                new Sidebar\PreviousEventSidebar,
            ];
        }


        if($conference){
            return [];
        }

        return $sidebars;
    }
}