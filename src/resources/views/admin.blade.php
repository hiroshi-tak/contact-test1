<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact Form</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <a class="header__logo" href="/">
                FashionablyLate
            </a>
            @if (Auth::check())
            <form class="form" action="/logout" method="post">
                @csrf
                <button class="header-nav__button">logout</button>
            </form>
            @endif
        </div>
    </header>

    <main>
        <div class="admin-form__content">
            <div class="admin-form__heading">
                <h2>Admin</h2>
            </div>
            <div>
            <form class="search-form">
                <div class="form-group">
                    <input type="text" name="name">
                </div>
                <div class="form-group">
                    <select name="gender">
                        <option value="">選択</option>
                        <option value="male">男性</option>
                        <option value="female">女性</option>
                        <option value="female">その他</option>
                    </select>
                </div>
                <div class="form-group">
                    <select name="category_id">
                        <option value="">問い合わせの種類</option>
                        <option value="male">男性</option>
                        <option value="female">女性</option>
                        <option value="female">その他</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="date" name="date">
                </div>
                <div class="form-group buttons">
                    <button type="submit">検索</button>
                    <button type="reset">リセット</button>
                </div>
            </form>
            <div class="middle-area">

                <div class="export">
                    <a href="" class="export-btn">エクスポート</a>
                </div>

                <div class="pagination-area">
                    <label>ページネーション</label>
                    {{ $contacts->links() }}
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
                    <tr class="contacts-table__row">
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
                        <td class="contacts-table__detail">

                            <button type="button" class="btn btn-primary btn-detail" data-id="{{ $contact->id }}">
                            詳細
                            </button>

                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </main>

<!-- モーダル -->
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

<script>
document.addEventListener('DOMContentLoaded', function() {

    let currentContactId = null; // 現在表示中のIDを保持

    document.querySelectorAll('.btn-detail').forEach(button => {
        button.addEventListener('click', function() {
            currentContactId = this.dataset.id;

            fetch(`/contacts/${currentContactId}`)
                .then(res => res.json())
                .then(data => {
                    // 性別番号を文字列に変換
                    let genderText = '';
                    switch(data.gender){
                        case 1: genderText = '男性'; break;
                        case 2: genderText = '女性'; break;
                        case 3: genderText = 'その他'; break;
                        default: genderText = '未設定';
                    }

                    // モーダルにテーブル表示
                    document.getElementById('modalBody').innerHTML = `
                        <dl class="row">
                        <dt class="col-sm-4">名前</dt>
                        <dd class="col-sm-8">${data.last_name} ${data.first_name}</dd>
                        <dt class="col-sm-4">性別</dt>
                        <dd class="col-sm-8">${genderText}</dd>
                        <dt class="col-sm-4">メールアドレス</dt>
                        <dd class="col-sm-8">${data.email}</dt>
                        <dt class="col-sm-4">電話番号</dt>
                        <dd class="col-sm-8">${data.tel}</dt>
                        <dt class="col-sm-4">住所</dt>
                        <dd class="col-sm-8">${data.address}</dt>
                        <dt class="col-sm-4">建物名</dt>
                        <dd class="col-sm-8">${data.building}</dt>
                        <dt class="col-sm-4">お問い合わせの種類</dt>
                        <dt class="col-sm-8">${data.category}</dt>
                        <dt class="col-sm-4">お問い合わせ内容</dt>
                        <dd class="col-sm-8">${data.detail}</dt>
                        </dl>
                    `;

                    new bootstrap.Modal(document.getElementById('contactModal')).show();
                });
        });
    });

    // 削除ボタン
    document.getElementById('deleteButton').addEventListener('click', function() {
        if(!currentContactId) return;

        if(!confirm('本当に削除しますか？')) return;

        fetch(`/contacts/${currentContactId}`, {
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

                // モーダルを閉じる
                bootstrap.Modal.getInstance(document.getElementById('contactModal')).hide();
            } else {
                alert('削除に失敗しました');
            }
        });
    });

});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>