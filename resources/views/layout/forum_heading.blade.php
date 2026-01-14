<div id="horizontal-tab">
    <button class="tab-option active" id="forum-tab">Forum</button>
    <button class="tab-option" id="activity-tab">Activity</button>
    @if(App\Models\Moderator::where('user_id', auth()->id())->exists() && request()->is('forum'))
        <button class="tab-option" id="mod-tab">Moderator</button>
        <button id="blocked-users-tab" class="tab-option">Blocked Users</button>
    @endif
</div>

<style>
    @media (max-width: 767px) {
    #horizontal-tab {
        display: none !important;
    }
}

</style>

