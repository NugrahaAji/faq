@extends('layouts.admin')

@section('content')
<div class="panel-header bg-primary-gradient">
    <div class="page-inner py-5">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
            <div>
                <h2 class="text-white pb-2 fw-bold">Daftar FAQ</h2>
                <h5 class="text-white op-7 mb-2">Kelola Frequently Asked Questions</h5>
            </div>
            <div class="ml-md-auto py-2 py-md-0">
                <a href="{{ route('admin.faqs.create') }}" class="btn btn-white btn-round">
                    <i class="fa fa-plus"></i> Tambah FAQ
                </a>
            </div>
        </div>
    </div>
</div>

<div class="page-inner mt--5">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <strong>Berhasil!</strong> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        <strong>Error!</strong> {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Data FAQ</h4>
                        <div class="ml-auto">
                            <input type="text" class="form-control" id="search" placeholder="Search...">
                        </div>
                        <button class="btn btn-primary btn-round ml-2" id="filter">
                            <i class="fa fa-filter"></i> Filter
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="faq-table" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Topic</th>
                                    <th>SubTopic</th>
                                    <th>Pertanyaan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($faqs as $index => $faq)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        @if($faq->topic)
                                            <span class="badge badge-info">{{ $faq->topic->name }}</span>
                                        @else
                                            <span class="badge badge-secondary">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($faq->subTopic)
                                            <span class="badge badge-primary">{{ $faq->subTopic->name }}</span>
                                        @else
                                            <span class="badge badge-secondary">-</span>
                                        @endif
                                    </td>
                                    <td>{{ Str::limit($faq->question, 100) }}</td>
                                    <td>
                                        <div class="form-button-action">
                                            <button type="button" class="btn btn-link btn-primary btn-lg"
                                                    data-toggle="tooltip" title="View">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                            <a href="{{ route('admin.faqs.edit', $faq->id) }}"
                                               class="btn btn-link btn-warning" data-toggle="tooltip" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.faqs.destroy', $faq->id) }}"
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link btn-danger"
                                                        data-toggle="tooltip" title="Hapus"
                                                        onclick="return confirm('Yakin ingin menghapus?')">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada data FAQ</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#faq-table').DataTable();
});
</script>
@endpush
