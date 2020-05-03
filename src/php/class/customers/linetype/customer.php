<?php
namespace customers\linetype;

class customer extends \Linetype
{
    function __construct()
    {
        $this->label = 'Customer';
        $this->table = 'customer';

        $this->fields = [
            (object) [
                'name' => 'clientid',
                'type' => 'text',
                'fuse' => '{t}.clientid',
            ],
            (object) [
                'name' => 'name',
                'type' => 'text',
                'fuse' => '{t}.name',
            ],
            (object) [
                'name' => 'address',
                'type' => 'multiline',
                'fuse' => '{t}.address',
            ],
            (object) [
                'name' => 'maincontact',
                'type' => 'text',
                'fuse' => '{t}.maincontact',
            ],
        ];

        $this->unfuse_fields = [
            '{t}.clientid' => ':{t}_clientid',
            '{t}.name' => ':{t}_name',
            '{t}.address' => ':{t}_address',
            '{t}.maincontact' => ':{t}_maincontact',
        ];
    }

    function validate($line) {
        $errors = [];

        if (!@$line->clientid) {
            $errors[] = 'no clientid';
        }

        if (!@$line->name) {
            $errors[] = 'no name';
        }

        return $errors;
    }
}
