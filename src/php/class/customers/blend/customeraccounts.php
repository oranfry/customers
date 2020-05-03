<?php
namespace customers\blend;

class customeraccounts extends \Blend
{
    public function __construct()
    {
        $clientids = get_values('customer', 'clientid', null, "concat(`clientid`, ' - ', `name`)");
        ksort($clientids);

        $this->label = 'Accounts';
        $this->linetypes = ['customerinvoice', 'transaction',];
        $this->showass = ['list', 'graph',];
        $this->groupby = 'date';
        $this->past = true;
        $this->cum = true;
        $this->fields = [
            (object) [
                'name' => 'icon',
                'type' => 'icon',
                'derived' => true,
            ],
            (object) [
                'name' => 'date',
                'type' => 'date',
                'groupable' => true,
                'main' => true,
            ],
            (object) [
                'name' => 'clientid',
                'type' => 'text',
                'main' => true,
                'filteroptions' => $clientids,
            ],
            (object) [
                'name' => 'description',
                'type' => 'text',
            ],
            (object) [
                'name' => 'amount',
                'type' => 'number',
                'dp' => '2',
                'summary' => 'sum',
            ],
            (object) [
                'name' => 'file',
                'type' => 'file',
                'icon' => 'docpdf',
                'default' => '',
                'path' => 'invoice',
                'supress_header' => true,
            ],
            (object) [
                'name' => 'broken',
                'type' => 'class',
                'default' => '',
            ],
        ];
    }
}
