@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
@endsection


@section('login')
<form class="header__logout" action="/logout" method="post">
    @csrf
    <button class="header__logout--submit" type="submit">logout</button>
</form>
@endsection

@section('content')
<div class="admin-form__content">
    <div class="admin-form__heading">
        <h2>Admin</h2>
    </div>
    <div>
    <form class="search-form" action="{{ route('admin.search') }}" method="get">
        <div class="form-group">
            <div class="form-text--name">
            <input type="text" name="name" placeholder="名前やメールアドレスを入力してください" value="{{ old('name') }}">
            </div>
        </div>
        <div class="form-group">
            <select name="gender">
                <option value="" hidden>性別</option>
                <option value="1">男性</option>
                <option value="2">女性</option>
                <option value="3">その他</option>
            </select>
        </div>
        <div class="form-group">
            <select name="category_id">
                <option value="" hidden>お問い合わせの種類</option>
                @foreach ($categories as $category)
                    <option value="{{ $category['id'] }}">{{ $category['content'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <input type="date" name="date" value="{{ old('date') }}">
        </div>
        <div class="form-buttons">
            <button class="form-button--submit" type="submit">検索</button>
            <a href="{{ route('admin.reset') }}" class="form-button--reset">リセット</a>
        </div>
    </form>
    <div class="middle-area">

        <div class="export">
            <a href="{{ route('admin.export', request()->query()) }}" class="export-btn">エクスポート</a>
        </div>

        <div class="pagination-wrapper ">
            <a href="{{ $contacts->url(1) }}" class="page-link">&lt;</a>
            @foreach ($contacts->getUrlRange(1, $contacts->lastPage()) as $page => $url)
                @if ($page == $contacts->currentPage())
                <span class="page-link active">{{ $page }}</span>
                @else
                <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                @endif
            @endforeach
            <a href="{{ $contacts->url($contacts->lastPage()) }}" class="page-link">&gt;</a>
        </div>
    </div>
    <div class="contacts-table">
        <table class="contacts-table__inner">
            <tr class="contacts-table__row">
                <th class="contacts-table__header">お名前</th>
                <th class="contacts-table__header">性別</th>
                <th class="contacts-table__header">メールアドレス</th>
                <th class="contacts-table__header">お問い合わせの種類</th>
                <th class="contacts-table__header"></th>
            </tr>
            @foreach ($contacts as $contact)
            <tr id="contactRow{{ $contact->id }}" class="contacts-table__row">
                <td class="contacts-table__item">
                    {{ $contact->last_name }} {{ $contact->first_name }}
                </td>
                <td class="contacts-table__item">
                    @if($contact->gender == 1)
                        男性
                    @elseif($contact->gender == 2)
                        女性
                    @else
                        その他
                    @endif
                </td>
                <td class="contacts-table__item">
                    {{ $contact->email }}
                </td>
                <td class="contacts-table__item">
                    @php
                        $category = $categories->firstWhere('id', $contact->category_id);
                    @endphp
                    {{ $category->content }}
                </td>
                <td class="contacts-table__item">
                        <button type="button" class="contacts-table_btn-detail" data-id="{{ $contact->id }}">
                        詳細
                        </button>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection

@section('modal')
<div class="modal fade" id="contactModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modalBody"></div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-danger" id="deleteButton">削除</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
//モーダル
document.addEventListener('DOMContentLoaded', function() {
    let currentContactId = null;
    const modalEl = document.getElementById('contactModal');
    const modal = new bootstrap.Modal(modalEl);

    document.querySelectorAll('.contacts-table_btn-detail').forEach(button => {
        button.addEventListener('click', function() {
            currentContactId = this.dataset.id;

            fetch(`/delete/${currentContactId}`)
                .then(res => res.json())
                .then(data => {
                    // 性別番号を文字列に変換
                    let genderText = '';
                    switch(Number(data.gender)){
                        case 1: genderText = '男性'; break;
                        case 2: genderText = '女性'; break;
                        case 3: genderText = 'その他'; break;
                        default: genderText = '未設定';
                    }

                    // モーダルにテーブル表示
                    document.getElementById('modalBody').innerHTML = `
                        <dl class="row">
                            <dt class="col-sm-4">名前</dt><dd class="col-sm-8">${data.last_name} ${data.first_name}</dd>
                            <dt class="col-sm-4">性別</dt><dd class="col-sm-8">${genderText}</dd>
                            <dt class="col-sm-4">メールアドレス</dt><dd class="col-sm-8">${data.email}</dd>
                            <dt class="col-sm-4">電話番号</dt><dd class="col-sm-8">${data.tel}</dd>
                            <dt class="col-sm-4">住所</dt><dd class="col-sm-8">${data.address}</dd>
                            <dt class="col-sm-4">建物名</dt><dd class="col-sm-8">${data.building}</dd>
                            <dt class="col-sm-4">お問い合わせの種類</dt><dd class="col-sm-8">${data.category}</dd>
                            <dt class="col-sm-4">お問い合わせ内容</dt><dd class="col-sm-8">${data.detail}</dd>
                        </dl>
                    `;

                    modal.show();
                });
        });
    });

    // 削除ボタン
    document.getElementById('deleteButton').addEventListener('click', function() {
        if(!currentContactId) return;
        if(!confirm('本当に削除しますか？')) return;

        fetch(`/delete/${currentContactId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(res => {
            if(res.ok){
                // テーブルから行を削除
                const row = document.getElementById('contactRow' + currentContactId);
                if(row) row.remove();
                modal.hide();
            } else {
                alert('削除に失敗しました');
            }
        });
    });
});

//列単位のホバー
document.addEventListener('DOMContentLoaded', () => {
    const table = document.querySelector('.contacts-table__inner');
    const headers = table.querySelectorAll('th');

    headers.forEach((th, index) => {
        th.addEventListener('mouseover', () => {
        table.querySelectorAll(`tr`).forEach(tr => {
            const cell = tr.children[index];
            if (cell) cell.style.backgroundColor = '#fff000';
        });
        });
        th.addEventListener('mouseout', () => {
        table.querySelectorAll(`tr`).forEach(tr => {
            const cell = tr.children[index];
            if (cell) cell.style.backgroundColor = '';
        });
        });
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection