<?php

return [

/*
 * Modules .
 */
    'modules'  => ['order'],


/*
 * Views for the page  .
 */
    'views'    => ['default' => 'Default', 'left' => 'Left menu', 'right' => 'Right menu'],

// Modale variables for page module.
    'order'     => [
        'model'        => 'App\Models\Order',
        'table'        => 'orders',
        'primaryKey'   => 'id',
        'hidden'       => [],
        'visible'      => [],
        'guarded'      => ['*'],
        'fillable'     => ['user_id','order_sn', 'merchant_id', 'provider_id', 'payment_company_id', 'status', 'created_at', 'updated_at'],
        //'translate'    => ['name', 'image', 'order'],
        'upload_folder' => '/page/link',
        'encrypt'      => ['id'],
        'revision'     => ['name'],
        'perPage'      => '20',
        'search'        => [
            'title'  => 'like',
        ],
    ],
    'order_record'     => [
        'model'        => 'App\Models\OrderRecord',
        'table'        => 'order_records',
        'primaryKey'   => 'id',
        'hidden'       => [],
        'visible'      => [],
        'guarded'      => ['*'],
        'fillable'     => ["user_id","order_id","patrol_company","terminal_identification","model","address","linkman","phone","date","patrol_man","template","leader_phone","patrol_mode","sn","pn","door_images","address_images","inside_images","pos_images","checkstand_images","test_images","pos_is_transformational","pos_is_transformational_content","pos_is_transformational_images","pos_is_normal","pos_is_normal_content","pos_is_signed","pos_is_signed_content","business_is_true","business_is_true_content","trade_notes_is_storage_correctly","trade_notes_is_storage_correctly_content","manage_is_normal","manage_is_normal_content","cashier_mobility","cashier_mobility_content","cashier_is_disciplinary","cashier_is_disciplinary_content","cashier_band_card_operation_skills","cashier_band_card_operation_skills_content","machine_is_storage_perfectly","machine_is_storage_perfectly_content","is_take_photos","is_take_photos_content","is_settlement_of_the_day","is_settlement_of_the_day_content","charge_deposit_amount","is_standby_machine","is_standby_machine_content","is_lost","is_lost_content","is_damaged","is_damaged_content","merchant_result","status","signature_image","created_at","updated_at"],
        //'translate'    => ['name', 'image', 'order'],
        'upload_folder' => '/page/link',
        'encrypt'      => ['id'],
        'revision'     => ['name'],
        'perPage'      => '20',
        'search'        => [
            'title'  => 'like',
        ],
    ],
];
