<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact Form</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/confirm.css') }}" />
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <a class="header__logo" href="/">
                FashionablyLate
            </a>
        </div>
    </header>

    <main>
        <div class="confirm__content">
            <div class="confirm__heading">
                <h2>Confirm</h2>
            </div>
            <form class="form" action="{{ route('contact.confirm') }}" method="post">
                @csrf
                <div class="confirm-table">
                    <table class="confirm-table__inner">
                        <tr class="confirm-table__row">
                        <th class="confirm-table__header">お名前</th>
                        <td class="confirm-table__text">
                            <input type="text" name="name" value="{{ $contact['last_name']}}　{{$contact['first_name'] }}"/>
                            <input type="hidden" name="last_name" value="{{$contact['last_name'] }}"/>
                            <input type="hidden" name="first_name" value="{{ $contact['first_name'] }}">
                        </td>
                        </tr>
                        <tr class="confirm-table__row">
                        <th class="confirm-table__header">性別</th>
                        <td class="confirm-table__text">
                            <input type="hidden" name="gender" value="{{ $contact['gender'] }}" />
                            @php
                            $genderText = match((int)$contact['gender']) {
                                1 => '男性',
                                2 => '女性',
                                3 => 'その他',
                                default => '',
                            };
                            @endphp
                            <span>{{ $genderText }}</span>
                        </td>
                        </tr>
                        <tr class="confirm-table__row">
                        <th class="confirm-table__header">メールアドレス</th>
                        <td class="confirm-table__text">
                            <input type="email" name="email" value="{{ $contact['email'] }}"/>
                        </td>
                        </tr>
                        <tr class="confirm-table__row">
                        <th class="confirm-table__header">電話番号</th>
                        <td class="confirm-table__text">
                            <input type="tel" name="tel" value="{{ $contact['tel1'] }} - {{ $contact['tel2'] }} - {{ $contact['tel3'] }} ">
                            <input type="hidden" name="tel1" value="{{ $contact['tel1'] }}">
                            <input type="hidden" name="tel2" value="{{ $contact['tel2'] }}">
                            <input type="hidden" name="tel3" value="{{ $contact['tel3'] }}">
                        </td>
                        </tr>
                        <tr class="confirm-table__row">
                        <th class="confirm-table__header">住所</th>
                        <td class="confirm-table__text">
                            <input type="text" name="address" value="{{ $contact['address'] }}"/>
                        </td>
                        <tr class="confirm-table__row">
                        <th class="confirm-table__header">建物名</th>
                        <td class="confirm-table__text">
                            <input type="text" name="building" value="{{ $contact['building'] }}"/>
                        </td>
                        </tr>
                        <tr class="confirm-table__row">
                        <th class="confirm-table__header">お問い合わせの種類</th>
                        <td class="confirm-table__text">
                            @php
                            $category = $categories->firstWhere('id', $contact['category_id']);
                            @endphp
                            <input type="text" name="category_id" value="{{ $category ->content }}" />
                            <input type="hidden" name="category_id" value="{{ $contact['category_id'] }}" />
                        </td>
                        </tr>
                        <tr class="confirm-table__row">
                        <th class="confirm-table__header">お問い合わせ内容</th>
                        <td class="confirm-table__text">
                            <input type="text" name="detail" value="{{ $contact['detail'] }}"/>
                        </td>
                        </tr>
                    </table>
                </div>
                <div class="form__button">
                    <button type="submit" name="action" value="submit">送信</button>
                    <button type="submit" name="action" value="back">修正</button>
                </div>
            </form>
        </div>
    </main>
</body>

</html>