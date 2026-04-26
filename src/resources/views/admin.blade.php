@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')
<div class="admin__content">
    <div class="admin__inner">
        <div class="admin__header">
            <h2 class="admin__title">Admin</h2>
        </div>

        <div class="search-form__container">
            <form class="search-form" action="/admin/search" method="get">
                @csrf
                <input class="search-form__item-input" type="text" name="keyword" placeholder="名前やメールアドレスを入力してください" value="{{ request('keyword') }}">
                <select class="search-form__item-select" name="gender">
                    <option value="" selected disabled>性別</option>
                    <option value="1" {{ request('gender') == '1' ? 'selected' : '' }}>男性</option>
                    <option value="2" {{ request('gender') == '2' ? 'selected' : '' }}>女性</option>
                    <option value="3" {{ request('gender') == '3' ? 'selected' : '' }}>その他</option>
                </select>
                <select class="search-form__item-select category-select" name="category_id">
                    <option value="" selected disabled>お問い合わせの種類</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->content }}</option>
                    @endforeach
                </select>
                <input class="search-form__item-date" type="date" name="date" value="{{ request('date') }}">
                <button class="search-form__button-submit" type="submit">検索</button>
                <button class="search-form__button-reset" type="button" onclick="location.href='/admin'">リセット</button>
            </form>
        </div>

        <div class="admin__actions">
            <div class="admin__export">
                <a href="{{ url('/admin/export') . '?' . http_build_query(request()->query()) }}" class="export-button">
                    エクスポート
                </a>
            </div>
            <div class="admin__pagination">
                {{ $contacts->appends(request()->query())->links() }}
            </div>
        </div>

        <div class="admin__table-container">
            <table class="admin__table">
                <tr class="admin__table-row">
                    <th class="admin__table-header">お名前</th>
                    <th class="admin__table-header">性別</th>
                    <th class="admin__table-header">メールアドレス</th>
                    <th class="admin__table-header">お問い合わせの種類</th>
                    <th class="admin__table-header"></th>
                </tr>
                @foreach ($contacts as $contact)
                <tr class="admin__table-row">
                    <td class="admin__table-item">{{ $contact->last_name }} {{ $contact->first_name }}</td>
                    <td class="admin__table-item">
                        @if($contact->gender == 1) 男性
                        @elseif($contact->gender == 2) 女性
                        @else その他 @endif
                    </td>
                    <td class="admin__table-item">{{ $contact->email }}</td>
                    <td class="admin__table-item">{{ $contact->category->content }}</td>
                    <td class="admin__table-item">
                        <button class="detail-button" onclick="openModal({{ $contact->id }})">詳細</button>

                        <div id="modal-{{ $contact->id }}" class="modal">
                            <div class="modal__content">
                                <div class="modal__header">
                                    <button class="modal__close-button" onclick="closeModal({{ $contact->id }})">×</button>
                                </div>
                                <div class="modal__body">
                                    <table class="modal__table">
                                        <tr>
                                            <th>お名前</th>
                                            <td>{{ $contact->last_name }}&nbsp;{{ $contact->first_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>性別</th>
                                            <td>@if($contact->gender == 1) 男性 @elseif($contact->gender == 2) 女性 @else その他 @endif</td>
                                        </tr>
                                        <tr>
                                            <th>メールアドレス</th>
                                            <td>{{ $contact->email }}</td>
                                        </tr>
                                        <tr>
                                            <th>電話番号</th>
                                            <td>{{ str_replace('-', '', $contact->tel) }}</td>
                                        </tr>
                                        <tr>
                                            <th>住所</th>
                                            <td>{{ $contact->address }}</td>
                                        </tr>
                                        <tr>
                                            <th>建物名</th>
                                            <td>{{ $contact->building }}</td>
                                        </tr>
                                        <tr>
                                            <th>お問い合わせの種類</th>
                                            <td>{{ $contact->category->content }}</td>
                                        </tr>
                                        <tr>
                                            <th>お問い合わせ内容</th>
                                            <td>{{ $contact->detail }}</td>
                                        </tr>
                                    </table>

                                    <form class="delete-form" action="/admin/delete" method="post">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $contact->id }}">
                                        <button type="submit" class="delete-button-real">削除</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>

<script>
    function openModal(id) {
        document.getElementById('modal-' + id).style.display = 'flex';
    }

    function closeModal(id) {
        document.getElementById('modal-' + id).style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target.className === 'modal') {
            event.target.style.display = 'none';
        }
    }
</script>
@endsection