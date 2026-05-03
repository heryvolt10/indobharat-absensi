<div>
    <div class="card">
        <div class="card-body">
            <div class="p-3 mb-4">
                @include('components.template.tb-filter')
                <div class="row divtable">
                    <table id="tb_m_table" class="table tbview main-table table-hover table-md table-striped">
                        <thead class="fw-medium">
                            <tr>
                                <th class="col-hide" width="1%">id</th>
                                <th class="print" width="3%">No</th>
                                <th class="print" wire:click="sortBy('nama')" style="cursor: pointer;">Master Data
                                    @if ($sortField === 'nama')
                                        {{ $sortDir === 'asc' ? '↑' : '↓' }}
                                    @endif
                                </th>
                                <th class="last-col sticky-col" width="5%">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data_rows as $li_data)
                                <tr wire:key="{{ $li_data->id }}">
                                    <td class="col-hide">{{ $li_data->id }}</td>
                                    <td>{{ ($data_rows->currentPage() - 1) * $data_rows->perPage() + $loop->index + 1 }}
                                    </td>
                                    <td>{{ $li_data->submenu }}</td>
                                    <td class="last-col sticky-col">
                                        <div class="btn-group btn-group-sm d-flex justify-content-center btn_index gap-1"
                                            id="baction">
                                            @if ($li_data->i_standar == '1')
                                                <a wire:navigate
                                                    href="{{ route('tbinput.index', ['refTable' => $li_data->set_table]) }}"
                                                    id="tbshow" wire:key="{{ $li_data->id }}"
                                                    class="btn btn-info rounded-1 btn_index_show"><i
                                                        class="ti ti-eye fs-1"></i></a>
                                            @else
                                                <a wire:navigate href="/{{ $li_data->url }}" id="tbshow"
                                                    wire:key="{{ $li_data->id }}"
                                                    class="btn btn-info rounded-1 btn_index_show"><i
                                                        class="ti ti-eye fs-1"></i></a>
                                            @endif

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                @include('components.template.no-data-table')
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-2 d-flex justify-content-end">
                    {{ $data_rows->onEachSide(0)->links(data: ['scrollTo' => false]) }}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // ============================= BUTTON FILTER HEAD =============================
    $(document).ready(function() {
        $(".div_btn_index_1").empty();
    });
    // ============================= BUTTON FILTER HEAD END =============================
</script>
