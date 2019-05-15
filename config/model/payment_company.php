<?php

return [

    /*
     * Modules .
     */
    'modules'  => ['payment_company'],


    /*
     * Views for the page  .
     */
    'views'    => ['default' => 'Default', 'left' => 'Left menu', 'right' => 'Right menu'],

// Modale variables for page module.
    'payment_company'     => [
        'model'        => 'App\Models\PaymentCompany',
        'table'        => 'payment_companies',
        'primaryKey'   => 'id',
        'hidden'       => [],
        'visible'      => [],
        'guarded'      => ['*'],
        'fillable'     => ['id','name','address','linkman','phone','service_tel','auth_file'],
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
