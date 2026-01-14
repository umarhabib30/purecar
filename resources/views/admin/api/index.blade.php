@extends('layout.superAdminDashboard')
@section('body')
<section id="DB-container" class="container mt-4">
    <ul class="nav nav-tabs" id="apiTabs" role="tablist" style="border: none;">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview"
                type="button" role="tab" aria-controls="overview" aria-selected="true">
                <i class="fas fa-code me-2 text-gray-500"></i> DealerKIT
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="settings-tab" data-bs-toggle="tab" data-bs-target="#settings"
                type="button" role="tab" aria-controls="settings" aria-selected="false">
                <i class="fas fa-code me-2 text-gray-500"></i> Click Dealers
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="url-tab" data-bs-toggle="tab" data-bs-target="#url"
                type="button" role="tab" aria-controls="url" aria-selected="false">
                <i class="fas fa-code me-2 text-gray-500"></i> BlueCubes
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="bluesky-tab" data-bs-toggle="tab" data-bs-target="#bluesky"
                type="button" role="tab" aria-controls="bluesky" aria-selected="false">
                <i class="fas fa-code me-2 text-gray-500"></i> BlueSky
            </button>
        </li>
           <li class="nav-item" role="presentation">
            <button class="nav-link" id="mazda-tab" data-bs-toggle="tab" data-bs-target="#mazda"
                type="button" role="tab" aria-controls="mazda" aria-selected="false">
                <i class="fas fa-code me-2 text-gray-500"></i> Keyloop
            </button>
        </li>
    </ul>

    <div class="tab-content mt-3" id="apiTabsContent">
        <!-- DealerKIT Tab -->
        <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1">DealerKIT API Overview</h5>
                    <p class="mb-0">Only APIs provided by DealerKIT can be connected and integrated here.</p>
                </div>
                <div>
                    <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#connectDealerModal"
                        data-source-type="api">
                        Connect Dealer
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Dealer Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Dealer ID</th>
                             <th scope="col">All Sources</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($apiusers as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->dealer_id }}</td>
                                <td>
                                    @foreach($user->feedSources as $s)
                                        <span class="badge bg-secondary">{{ strtoupper($s->dealer_id) }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <form action="{{ route('admin.api.disconnectSource') }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="source_id" value="{{ $s->id }}">
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('Are you sure?')">
                                            Disconnect
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">No users found from API source.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Click Dealers Tab -->
        <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settings-tab">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1">Click Dealers Overview</h5>
                    <p class="mb-0">Only FTP feeds provided by Click Dealers, Spidersnet and Autoweb can be connected here.</p>
                </div>
                <div>
                    <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#connectDealerModal"
                        data-source-type="ftp_feed">
                        Connect Dealer
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Dealer Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Dealer ID</th>
                              <th scope="col">All Sources</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clickdealers as $clickdealer)
                            <tr>
                                <td>{{ $clickdealer->name }}</td>
                                <td>{{ $clickdealer->email }}</td>
                                <td>{{ $clickdealer->dealer_id }}</td>
                                <td>
                                    @foreach($clickdealer->feedSources as $s)
                                        <span class="badge bg-secondary">{{ strtoupper($s->dealer_id) }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <form action="{{ route('admin.api.disconnectSource') }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="source_id" value="{{ $s->id }}">
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('Are you sure?')">
                                            Disconnect
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">No users found from FTP feed source.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- BlueCubes Tab -->
        <div class="tab-pane fade" id="url" role="tabpanel" aria-labelledby="url-tab">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1">URL Feed Overview</h5>
                    <p class="mb-0">Connect dealers who use a direct URL feed.</p>
                </div>
                <div>
                    <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#connectDealerModal"
                        data-source-type="feed">
                        Connect Dealer
                    </button>
                </div>
            </div>

            <div class="table-responsive mt-3">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Dealer Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Dealer ID</th>
                            <th scope="col">Feed URL</th>
                              <th scope="col">All Sources</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($urlfeedusers as $feeduser)
                            <tr>
                                <td>{{ $feeduser->name }}</td>
                                <td>{{ $feeduser->email }}</td>
                                <td>{{ $feeduser->dealer_id }}</td>
                                <td>{{ $feeduser->dealer_feed_url ?? 'N/A' }}</td>
                                <td>
                                    @foreach($feeduser->feedSources as $s)
                                        <span class="badge bg-secondary">{{ strtoupper($s->dealer_id) }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <form action="{{ route('admin.api.disconnectSource') }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="source_id" value="{{ $s->id }}">
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('Are you sure?')">
                                            Disconnect
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">No users found from URL feed source.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- BlueSky Tab -->
        <div class="tab-pane fade" id="bluesky" role="tabpanel" aria-labelledby="bluesky-tab">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1">BlueSky Interactive API Overview</h5>
                    <p class="mb-0">Connect dealers using BlueSky Interactive API integration.</p>
                </div>
                <div>
                    <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#connectDealerModal"
                        data-source-type="bluesky">
                        Connect Dealer
                    </button>
                </div>
            </div>

            <div class="table-responsive mt-3">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Dealer Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Dealer ID</th>
                              <th scope="col">All Sources</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($blueskyusers as $blueskyuser)
                            <tr>
                                <td>{{ $blueskyuser->name }}</td>
                                <td>{{ $blueskyuser->email }}</td>
                                <td>{{ $blueskyuser->dealer_id }}</td>
                                <td>
                                    @foreach($blueskyuser->feedSources as $s)
                                        <span class="badge bg-secondary">{{ strtoupper($s->dealer_id) }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <form action="{{ route('admin.api.disconnectSource') }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="source_id" value="{{ $s->id }}">
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('Are you sure?')">
                                            Disconnect
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">No users found from BlueSky source.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

        <!-- mazda -->
     <div class="tab-pane fade" id="mazda" role="tabpanel" aria-labelledby="mazda-tab">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1">Keyloop Feed Overview</h5>
                    <p class="mb-0">Connect dealers who are with MAZDA.</p>
                </div>
                <div>
                    <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#connectDealerModal"
                        data-source-type="mazda">
                        Connect Dealer
                    </button>
                </div>
            </div>

            <div class="table-responsive mt-3">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Dealer Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Dealer ID</th>
                            <th scope="col">Feed URL</th>
                              <th scope="col">All Sources</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mazdausers as $mazdauser)
                            <tr>
                                <td>{{ $mazdauser->name }}</td>
                                <td>{{ $mazdauser->email }}</td>
                                <td>{{ $mazdauser->dealer_id }}</td>
                                <td>{{ $mazdauser->dealer_feed_url ?? 'N/A' }}</td>
                                <td>
                                    @foreach($mazdauser->feedSources as $s)
                                        <span class="badge bg-secondary">{{ strtoupper($s->dealer_id) }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <form action="{{ route('admin.api.disconnectSource') }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="source_id" value="{{ $s->id }}">
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('Are you sure?')">
                                            Disconnect
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">No users found from URL feed source.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
</section>

<!-- Connect Dealer Modal -->
<div class="modal fade" id="connectDealerModal" tabindex="-1" aria-labelledby="connectDealerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.api.connectDealer') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="connectDealerModalLabel">Connect Dealer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="email" class="form-label">Dealer Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="dealer_id" class="form-label">Dealer ID</label>
                        <input type="text" name="dealer_id" class="form-control" required>
                    </div>
                               
                    <div class="mb-3 d-none" id="dealer_feed_url_field">
                        <label for="dealer_feed_url" class="form-label">Dealer Feed URL</label>
                        <textarea name="dealer_feed_url" class="form-control" rows="3" placeholder="Enter feed URL here..."></textarea>
                    </div>
                    <div class="mb-3 d-none" id="dealer_api_field">
                        <label for="dealer_api_field" class="form-label">Dealer API</label>
                        <textarea name=" dealer_api_field" class="form-control" rows="3" placeholder="Enter API here..."></textarea>
                    </div>

                    <input type="hidden" name="source_type" id="source_type">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-dark">Save Dealer</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var connectDealerModal = document.getElementById('connectDealerModal');
    var feedUrlField = document.getElementById('dealer_feed_url_field');
    var apiField = document.getElementById('dealer_api_field');
    var sourceTypeInput = document.getElementById('source_type');

    connectDealerModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var sourceType = button.getAttribute('data-source-type');
        sourceTypeInput.value = sourceType;

        // Show/Hide Feed URL field (only for 'feed' type)
        if (sourceType === 'feed' || sourceType === 'mazda') {
            feedUrlField.classList.remove('d-none');
        } else {
            feedUrlField.classList.add('d-none');
        }
         if (sourceType === 'bluesky') {
            apiField.classList.remove('d-none');
        } 

    });
});
</script>

@endsection