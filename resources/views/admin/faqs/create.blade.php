<!-- File: resources/views/admin/faqs/create.blade.php -->
@extends('layouts.admin')

@section('content')
<div class="panel-header bg-primary-gradient">
    <div class="page-inner py-5">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
            <div>
                <h2 class="text-white pb-2 fw-bold">Tambah FAQ</h2>
                <h5 class="text-white op-7 mb-2">Kelola Frequently Asked Questions</h5>
            </div>
        </div>
    </div>
</div>

<div class="page-inner mt--5">
    <div class="row">
        <div class="col-md-12">

            <!-- CARD 1: TOPIC & SUBTOPIC MANAGEMENT -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <!-- LEFT: Topic Section -->
                        <div class="col-md-6">
                            <h3>Kontrol Topik</h3>
                        <form action="">
                            <div class="form-group form-group-default">
                                 <div>
                                     <label>Topik</label>
                                     <input id="new_topic_name" type="text" class="form-control" placeholder="Masukkan topik">
                                 </div>
                                 <small class="text-danger d-none" id="topic_error"></small>
                             </div>
                            <div class="form-group form-group-default">
                                 <div>
                                     <label>Deskripsi</label>
                                     <input id="new_topic_name" type="text" class="form-control" placeholder="Masukkan deskripsi topik">
                                 </div>
                                 <small class="text-danger d-none" id="topic_error"></small>
                             </div>
									<button class="btn btn-success" type="submit">Submit</button>
                        </form>
                            <!-- <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="new_topic_name"
                                           placeholder="Input topic" style="border-right: none;">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" id="btn_add_topic"
                                                style="border-left: none; background: white;">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </div> -->
                            <div class="mt-5">
                                <h3>Daftar Topik</h3>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Topik</th>
                                            <th scope="col">Deskripsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($topics as $topic)
                                        <tr>
                                            <td>{{ $loop->iteration}}</td>
                                            <td>{{ $topic->name }}</td>
                                            <td>Otto</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="3"> Belum ada topik</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <!-- <div class="border rounded p-3" style="min-height: 150px; max-height: 200px; overflow-y: auto; background-color: #f8f9fa;">
                                <ul class="list-unstyled mb-0" id="topic_list">
                                    @forelse($topics as $topic)
                                        <li class="mb-2">{{ $topic->name }}</li>
                                    @empty
                                        <li class="text-muted">Belum ada topik</li>
                                    @endforelse
                                </ul>
                            </div> -->
                        </div>

                        <!-- RIGHT: SubTopic Section -->
                        <div class="col-md-6">
                            <h3>Kontrol Sub Topik</h3>
                            <form action="">
                                <div class="form-group form-group-default">
                                    <label>Pilih Topik</label>
                                    <select class="form-control" id="formGroupDefaultSelect">
                                        <option value="">Pilih Topik</option>
                                        @foreach($topics as $topic)
                                        <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group form-group-default">
                                    <div>
                                        <label>Pilih Sub Topik</label>
                                        <input id="new_subtopic_name" type="text" class="form-control" placeholder="Masukkan sub topik">
                                    </div>
                                    <small class="text-danger d-none" id="subtopic_error"></small>
                                </div>
									<button class="btn btn-success" type="submit">Submit</button>
                            </form>

                            <div class="mt-5">
                                <h3>Daftar Sub Topik</h3>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Topik</th>
                                            <th scope="col">Sub Topik</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($topics as $topic)
                                        <tr>
                                            <td>{{ $loop->iteration}}</td>
                                            <td>{{ $topic->name }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="3"> Belum ada topik</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- CARD 2: HEADER -->
            <div class="card mb-3 bg-primary-gradient">
                <div class="card-body">
                    <h3 class="mb-0 text-white">Tambah FAQ</h3>
                </div>
            </div>
            <!-- CARD 3: FAQ FORM -->
            <div class="card mb-3">
                <div class="card-body">
                    <form action="{{ route('admin.faqs.store') }}" method="POST" id="faq_form">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-group-default">
                                    <label>Pilih Topik</label>
                                    <select class="form-control  @error('topic_id') is-invalid @enderror" id="id_topic" name="topic_id" required>
                                        <option value="">Pilih Topik</option>
                                        @foreach($topics as $topic)
                                            <option value="{{ $topic->id }}" {{ old('topic_id') == $topic->id ? 'selected' : '' }}>
                                                {{ $topic->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('topic_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            <div class="col-md-6">
                                <div class="form-group form-group-default">
                                    <label>Pilih Sub Topik</label>
                                    <select class="form-control  @error('subtopic_id') is-invalid @enderror" id="sub_topic_id" name="sub_topic_id" required>
                                        <option value="">Pilih Sub Topik</option>
                                        @foreach($topics as $topic)
                                            <option value="{{ $topic->id }}" {{ old('topic_id') == $topic->id ? 'selected' : '' }}>
                                                {{ $topic->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('sub_topic_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group form-group-default">
                            <label>Pertanyaan</label>
                            <textarea class="form-control @error('question') is-invalid @enderror"
                                      name="question" rows="2"
                                      placeholder="Masukkan pertanyaan FAQ" required>{{ old('question') }}</textarea>
                            @error('question')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group form-group-default">
                            <label>Jawaban</label>
                            <textarea class="form-control @error('answer') is-invalid @enderror"
                                      id="editor" name="answer" rows="10" required>{{ old('answer') }}</textarea>
                            @error('answer')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-group-default">
                                    <label>Urutan</label>
                                    <input type="number" class="form-control" name="order"
                                           value="{{ old('order', 0) }}" min="0">
                                </div>
                                <small class="form-text text-muted">Semakin kecil angka, semakin atas urutannya</small>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <label class="">Status</label><br>
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" name="is_active" value="1"
                                               {{ old('is_active', true) ? 'checked' : '' }}>
                                        <span class="form-check-sign">Aktif</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="text-right mt-3">
                            <button type="submit" class="btn btn-primary btn-lg px-5">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/40.1.0/classic/ckeditor.js"></script>
<script>
// Initialize CKEditor with full features
let editor;
ClassicEditor
    .create(document.querySelector('#editor'), {
        toolbar: {
            items: [
                'heading', '|',
                'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', '|',
                'bold', 'italic', 'underline', 'strikethrough', 'subscript', 'superscript', '|',
                'alignment', '|',
                'numberedList', 'bulletedList', '|',
                'outdent', 'indent', '|',
                'link', 'imageUpload', 'blockQuote', 'insertTable', 'mediaEmbed', '|',
                'code', 'codeBlock', 'horizontalLine', '|',
                'undo', 'redo', '|',
                'sourceEditing'
            ],
            shouldNotGroupWhenFull: true
        },
        heading: {
            options: [
                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
            ]
        },
        fontSize: {
            options: [
                'tiny',
                'small',
                'default',
                'big',
                'huge'
            ]
        },
        fontFamily: {
            options: [
                'default',
                'Arial, Helvetica, sans-serif',
                'Courier New, Courier, monospace',
                'Georgia, serif',
                'Lucida Sans Unicode, Lucida Grande, sans-serif',
                'Tahoma, Geneva, sans-serif',
                'Times New Roman, Times, serif',
                'Trebuchet MS, Helvetica, sans-serif',
                'Verdana, Geneva, sans-serif'
            ]
        },
        link: {
            decorators: {
                toggleDownloadable: {
                    mode: 'manual',
                    label: 'Downloadable',
                    attributes: {
                        download: 'file'
                    }
                },
                openInNewTab: {
                    mode: 'manual',
                    label: 'Open in a new tab',
                    defaultValue: true,
                    attributes: {
                        target: '_blank',
                        rel: 'noopener noreferrer'
                    }
                }
            }
        },
        table: {
            contentToolbar: [
                'tableColumn',
                'tableRow',
                'mergeTableCells',
                'tableCellProperties',
                'tableProperties'
            ]
        },
        image: {
            toolbar: [
                'imageStyle:inline',
                'imageStyle:block',
                'imageStyle:side',
                '|',
                'toggleImageCaption',
                'imageTextAlternative'
            ]
        }
    })
    .then(newEditor => {
        editor = newEditor;
        console.log('CKEditor initialized successfully');
    })
    .catch(error => {
        console.error('Error initializing CKEditor:', error);
    });

// Add Topic
$('#btn_add_topic').on('click', function() {
    const topicName = $('#new_topic_name').val().trim();
    const errorEl = $('#topic_error');

    if (!topicName) {
        errorEl.text('Nama topic tidak boleh kosong!').removeClass('d-none');
        return;
    }

    $.ajax({
        url: '{{ route("admin.topics.store") }}',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            name: topicName,
            is_active: 1
        },
        success: function(response) {
            errorEl.addClass('d-none');
            $('#new_topic_name').val('');

            $.notify({
                icon: 'icon-check',
                title: 'Berhasil!',
                message: 'Topic berhasil ditambahkan',
            },{
                type: 'success',
                placement: {
                    from: "top",
                    align: "right"
                },
                time: 1000,
            });

            setTimeout(function() {
                location.reload();
            }, 1000);
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                const errors = xhr.responseJSON.errors;
                if (errors.name) {
                    errorEl.text(errors.name[0]).removeClass('d-none');
                }
            } else {
                errorEl.text('Topic sudah ada atau terjadi kesalahan').removeClass('d-none');
            }
        }
    });
});

// Load SubTopics when topic selected (for management)
$('#topic_select_for_subtopic').on('change', function() {
    const topicId = $(this).val();
    const subtopicList = $('#subtopic_list');

    if (!topicId) {
        subtopicList.html('<li class="text-muted">Pilih topic untuk melihat subtopic</li>');
        return;
    }

    subtopicList.html('<li class="text-muted">Loading...</li>');

    $.ajax({
        url: `/admin/api/subtopics/topic/${topicId}`,
        type: 'GET',
        success: function(data) {
            if (data.length > 0) {
                let html = '';
                data.forEach(function(subTopic) {
                    html += `<li class="mb-2">${subTopic.name}</li>`;
                });
                subtopicList.html(html);
            } else {
                subtopicList.html('<li class="text-muted">Belum ada subtopic</li>');
            }
        },
        error: function() {
            subtopicList.html('<li class="text-danger">Gagal memuat subtopic</li>');
        }
    });
});

// Add SubTopic
$('#btn_add_subtopic').on('click', function() {
    const topicId = $('#topic_select_for_subtopic').val();
    const subTopicName = $('#new_subtopic_name').val().trim();
    const errorEl = $('#subtopic_error');

    if (!topicId) {
        errorEl.text('Pilih topic terlebih dahulu!').removeClass('d-none');
        return;
    }

    if (!subTopicName) {
        errorEl.text('Nama subtopic tidak boleh kosong!').removeClass('d-none');
        return;
    }

    $.ajax({
        url: '{{ route("admin.subtopics.store") }}',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            topic_id: topicId,
            name: subTopicName,
            is_active: 1
        },
        success: function(response) {
            errorEl.addClass('d-none');
            $('#new_subtopic_name').val('');

            $.notify({
                icon: 'icon-check',
                title: 'Berhasil!',
                message: 'SubTopic berhasil ditambahkan',
            },{
                type: 'success',
                placement: {
                    from: "top",
                    align: "right"
                },
                time: 1000,
            });

            setTimeout(function() {
                location.reload();
            }, 1000);
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                const errors = xhr.responseJSON.errors;
                if (errors.name) {
                    errorEl.text(errors.name[0]).removeClass('d-none');
                }
            } else {
                errorEl.text('SubTopic sudah ada atau terjadi kesalahan').removeClass('d-none');
            }
        }
    });
});

// Load SubTopics for FAQ form
$('#topic_id').on('change', function() {
    const topicId = $(this).val();
    const subTopicSelect = $('#sub_topic_id');

    subTopicSelect.html('<option value="">Loading...</option>');

    if (topicId) {
        $.ajax({
            url: `/admin/api/subtopics/topic/${topicId}`,
            type: 'GET',
            success: function(data) {
                subTopicSelect.html('<option value="">Select SubTopic</option>');

                if (data.length > 0) {
                    data.forEach(function(subTopic) {
                        subTopicSelect.append(
                            `<option value="${subTopic.id}">${subTopic.name}</option>`
                        );
                    });
                } else {
                    subTopicSelect.html('<option value="">Tidak ada subtopic</option>');
                }
            },
            error: function() {
                subTopicSelect.html('<option value="">Gagal memuat subtopic</option>');
            }
        });
    } else {
        subTopicSelect.html('<option value="">Select SubTopic</option>');
    }
});

// Auto-select if old value exists
@if(old('topic_id'))
    $('#topic_id').trigger('change');
    setTimeout(function() {
        $('#sub_topic_id').val('{{ old("sub_topic_id") }}');
    }, 500);
@endif
</script>
@endpush
