<?php
namespace customers\blend;

class customers extends \Blend
{
    public function __construct()
    {
        $this->label = 'Manage';
        $this->linetypes = ['customer'];
        $this->showass = ['list',];

        $this->fields = [
            (object) [
                'name' => 'clientid',
                'type' => 'text',
            ],
            (object) [
                'name' => 'name',
                'type' => 'text',
            ],
            (object) [
                'name' => 'maincontact',
                'type' => 'text',
            ],
        ];
    }
}
