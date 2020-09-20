<?php
namespace customers\blend;

class customeraccounts extends \Blend
{
    public function __construct()
    {
        $customer_users = get_values('user', 'user', null, 'name');
        ksort($customer_users);

        $this->label = 'Accounts';
        $this->linetypes = ['ncustomerinvoice', 'transaction'];
        $this->hide_types = ['ncustomerinvoice' => 'customerinvoice'];
        $this->showass = ['list', 'graph'];
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
                'name' => 'user',
                'type' => 'text',
                'main' => true,
                'filteroptions' => $customer_users,
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
        $this->filters = [
            (object) [
                'field' => 'user',
                'cmp' => '=',
                'value' => array_values($customer_users),
            ],
        ];
    }
}
