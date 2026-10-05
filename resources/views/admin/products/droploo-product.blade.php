@extends('admin.master')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col">
                    <div class="card radius-10 mb-0">
                        <div class="card-body">

                            @if(Session::has('success'))
                                <x-alert :message="session('success')" title="Success" type="success"></x-alert>
                            @endif
                            @if(Session::has('error'))
                                <x-alert :message="session('error')" title="Error" type="error"></x-alert>
                            @endif

                            <div class="d-flex align-items-center">
                                <div>
                                    <h5 class="mb-1">Products</h5>
                                </div>
                                @if(count($pendingProductIds ?? []) > 0)
                                    <div class="ms-auto">
                                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#importAllModal">
                                            <i class="bx bx-cloud-download"></i> Add All Products ({{ count($pendingProductIds) }})
                                        </button>
                                    </div>
                                @endif
                            </div>

                           <div class="table-responsive mt-3">
                               <table class="table align-middle mb-0">
                                   <thead class="table-light">
                                       <tr>
                                           <th width="5%">SL</th>
                                           <th width="10%">Name</th>
                                           <th width="10%">Whole Sale Price</th>
                                           <th width="10%">Status</th>
                                           <th width="10%" class="text-center">Actions</th>
                                       </tr>
                                   </thead>
                                   <tbody>
                                       @foreach ($products as $product)
                                        <tr>
                                            <td>{{ $loop->index+1 }}</td>
                                            <td>
                                                <img src="{{$imagePath.$product['image']}}" height="50" width="50" />
                                                {{ $product['name']}}
                                            </td>
                                            <td>{{ $product['wholesale_price'] }} Tk.</td>
                                            <td>
                                                @if(in_array($product['id'], $existingProductIds ?? []))
                                                    <span class="badge rounded-pill bg-success">Added</span>
                                                @else
                                                    <span class="badge rounded-pill bg-warning">Not Added</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if(in_array($product['id'], $existingProductIds ?? []))
                                                    <span class="badge rounded-pill bg-secondary">Already Added</span>
                                                @else
                                                    <a href="{{url('add-droploo-product/'.$product['id'])}}" class="badge rounded-pill bg-info">Add</a>
                                                @endif
                                            </td>
                                        </tr>
                                       @endforeach
                                   </tbody>
                               </table>
                           </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="importAllModal" tabindex="-1" data-bs-backdrop="static" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add All Products</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" id="importCloseBtn"></button>
                </div>
                <div class="modal-body">
                    <p id="importIntro">This will import <b>{{ count($pendingProductIds ?? []) }}</b> products that are not yet added, one by one. This may take a while - please keep this tab open.</p>
                    <div id="importProgressWrap" style="display:none">
                        <div class="progress mb-2"><div class="progress-bar bg-success" id="importBar" style="width:0%"></div></div>
                        <div id="importStats" class="small"></div>
                        <div id="importErrors" class="small text-danger mt-2" style="max-height:150px;overflow:auto"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="importCancelBtn" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="importStartBtn">Start Import</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function () {
            const ids = @json($pendingProductIds ?? []);
            const total = ids.length;
            const csrf = '{{ csrf_token() }}';
            let running = false, cancelled = false, finished = false;
            let added = 0, skipped = 0, failed = 0, done = 0;

            const $ = (id) => document.getElementById(id);
            const render = () => {
                $('importBar').style.width = (total ? done / total * 100 : 0) + '%';
                $('importStats').textContent = `Added: ${added}, Skipped: ${skipped}, Failed: ${failed} | ${done} / ${total}`;
            };

            $('importStartBtn').addEventListener('click', async function () {
                if (running) return;
                if (finished) { window.location.reload(); return; }
                running = true; cancelled = false;
                added = skipped = failed = done = 0;
                this.disabled = true;
                $('importIntro').style.display = 'none';
                $('importProgressWrap').style.display = '';
                $('importErrors').innerHTML = '';
                render();

                for (const id of ids) {
                    if (cancelled) break;
                    try {
                        const res = await fetch('{{ url('droploo-products/import') }}/' + id, {
                            method: 'POST',
                            headers: {'X-CSRF-TOKEN': csrf, 'Accept': 'application/json'}
                        });
                        const data = await res.json();
                        if (data.status === 'added' || data.status === 'linked') added++;
                        else if (data.status === 'skipped') skipped++;
                        else { failed++; $('importErrors').insertAdjacentHTML('beforeend', `<div>#${id} - ${data.message || 'Failed'}</div>`); }
                    } catch (e) {
                        failed++;
                        $('importErrors').insertAdjacentHTML('beforeend', `<div>#${id} - ${e.message}</div>`);
                    }
                    done++;
                    render();
                }

                running = false;
                if (!cancelled && failed === 0) {
                    window.location.reload();
                } else {
                    $('importStartBtn').disabled = false;
                    $('importStartBtn').textContent = 'Refresh';
                    finished = true;
                }
            });

            $('importCancelBtn').addEventListener('click', () => { cancelled = true; });
            $('importCloseBtn').addEventListener('click', () => { cancelled = true; });
        })();
    </script>
@endpush
