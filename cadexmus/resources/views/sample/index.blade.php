{{-- Modal content --}}
<div class="modal-content" style="color:#555">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close window">&times;</button>
        <h4 class="modal-title">Choose sample</h4>
        <form id="searchSampleForm" action="{{ route('sample.filter') }}" method="GET">
            <div class="input-group stylish-input-group">
                <input id="search-pattern" type="search" class="form-control"  placeholder="Search" >
                <span class="input-group-addon">
                    <button type="submit">
                        Search
                    </button>
                </span>
            </div>
        </form>
    </div>
    <div id="sample-list" class="modal-body">
        @include('sample.list')
    </div>
    <div class="modal-footer" style="text-align:initial">
        @include('sample.create')
    </div>
</div>
