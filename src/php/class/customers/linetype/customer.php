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
                'name' => 'email',
                'type' => 'text',
                'fuse' => '{t}.email',
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
            (object) [
                'name' => 'nickname',
                'type' => 'text',
                'fuse' => '{t}.nickname',
            ],
        ];

        $this->unfuse_fields = [
            '{t}.clientid' => ':{t}_clientid',
            '{t}.name' => ':{t}_name',
            '{t}.email' => ':{t}_email',
            '{t}.address' => ':{t}_address',
            '{t}.maincontact' => ':{t}_maincontact',
            '{t}.nickname' => ':{t}_nickname',
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
