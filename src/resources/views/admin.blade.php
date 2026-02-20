<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact Form</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}" />
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
                    <tr class="contacts-table__row">
                        <td class="contacts-table__item">
                        </td>
                        <td class="contacts-table__item">
                        </td>
                        <td class="contacts-table__item">
                        </td>
                        <td class="contacts-table__item">
                        </td>
                        <td class="contacts-table__detail">
                                <a href="#modal-" class="detail-btn">詳細</a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </main>
</body>

</html>