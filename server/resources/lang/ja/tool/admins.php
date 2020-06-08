<?php
return [
    'message' => [
        'error_delete'   => '削除時にエラーが発生しました。',
        'success_delete' => '削除しました。',
        'error_create'   => '登録時にエラーが発生しました。',
        'success_create' => '登録しました。',
        'error_update'   => '更新時にエラーが発生しました。',
        'success_update' => '更新しました。',
        'error_get'      => '入力した管理者が存在しません。',
    ],
    'label'   => [
        'list' => [
            'title'                      => '管理者一覧',
            'filter_title'               => '絞り込み条件',
            'filter_keyword'             => 'キーワード',
            'filter_keyword_placeholder' => '表示名など',
            'filter_search_action'       => '操作',
            'filter_search_button'       => '絞り込む',
            'table_title'                => '管理者一覧',
            'table_col_id'               => 'No',
            'table_col_name'             => '表示名',
            'table_col_username'         => 'ユーザー名',
            'table_col_updated_at'       => '更新日',
            'table_button_create'        => '新規登録',
            'table_button_edit'          => '編集',
            'table_button_delete'        => '削除',
            'table_empty_data'           => '該当するデータが存在しません。',
        ],
        'edit'  => [
            'require'                  => '（必須）',
            'title_create'             => '管理者登録',
            'title_edit'               => '管理者編集',
            'name'                     => '表示名',
            'name_placeholder'         => '試験 太郎',
            'username'                 => 'ユーザー名',
            'username_placeholder'     => 'ユーザー名',
            'password'                 => 'パスワード',
            'password_placeholder'     => 'パスワード',
            'button_generate_password' => '生成',
        ],
        'modal' => [
            'delete_title'   => '削除確認',
            'delete_confirm' => '削除しますが、よろしいですか？',
        ],
        'form'  => [
            'SAVE'   => '保存する',
            'OK'     => 'OK',
            'CANCEL' => 'キャンセル',
        ]
    ],
];
