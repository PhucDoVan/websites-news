<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Language for organization screen
    |--------------------------------------------------------------------------
    */
    'message'    => [
        'create_success' => '登録しました。',
        'create_fail'    => '登録時にエラーが発生しました。',
        'update_success' => '更新しました。',
        'update_fail'    => '更新時にエラーが発生しました。',
        'delete_success' => '削除しました。',
        'delete_fail'    => '削除時にエラーが発生しました。',
        'get_error'      => '該当するデータが存在しません。',
    ],
    'label'      => [
        'list'  => [
            'title'                       => '部門管理',
            'title_filter'                => '絞り込み条件',
            'keyword_label'               => 'キーワード',
            'keyword_placeholder'         => '部門名',
            'search_label'                => '操作',
            'search_button'               => '絞り込む',
            'column_no'                   => 'No',
            'column_name'                 => '部門',
            'column_update'               => '更新日',
            'button_create'               => '新規登録',
            'button_edit'                 => '編集',
            'button_delete'               => '削除',
            'popup_delete_title'          => '削除確認',
            'popup_delete_confirm_delete' => '削除しますが',
        ],
        'edit'  => [
            'require'           => '（必須）',
            'title_create'      => '部門登録',
            'title_edit'        => '部門編集',
            'input_label'       => '部門名',
            'input_placeholder' => '部門名',
            'corporation_name'  => '法人名',
            'parent_group'      => '親部門',
        ],
        'modal' => [
            'delete_title'   => '削除確認',
            'delete_confirm' => '削除しますが、よろしいですか？',
        ],
        'form'  => [
            'SAVE'   => '保存する',
            'OK'     => 'OK',
            'CANCEL' => 'キャンセル',
        ],
    ],
    'attributes' => [
        'name' => '部門名',
    ],
];
