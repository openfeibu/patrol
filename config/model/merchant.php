<?php

return [

    /*
     * Modules .
     */
    'modules'  => ['merchant'],


    /*
     * Views for the page  .
     */
    'views'    => ['default' => 'Default', 'left' => 'Left menu', 'right' => 'Right menu'],

// Modale variables for page module.
    'merchant'     => [
        'model'        => 'App\Models\Merchant',
        'table'        => 'merchants',
        'primaryKey'   => 'id',
        'hidden'       => [],
        'visible'      => [],
        'guarded'      => ['*'],
        'fillable'     => ['id','provider_id','payment_company_id','name','merchant_sn','model','pn','sn','address','linkname','phone','province','city','created_at','updated_at'],
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
