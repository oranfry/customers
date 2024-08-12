<?php

namespace customers\linetype;

use simplefields\traits\SimpleFields;

class customerinvoice extends \jars\Linetype
{
    use SimpleFields;

    public function __construct()
    {
        $this->table = 'customerinvoice';

        $this->simple_date('date');
        $this->simple_string('email');
        $this->simple_string('name');
        $this->simple_string('address');
        $this->simple_string('description');
        $this->simple_string('external_id');

        $this->fields['amount'] = fn ($records) : string => bcadd('0', $records['/']->amount ?? '0', 2);
        $this->unfuse_fields['amount'] = fn ($line) : string => $line->amount ?? '0.00';

        $this->fields['broken'] = function($records) {
            if (!@$records['/']->user) {
                return 'no user';
            }
        };

        $this->children = [
            (object) [
                'linetype' => 'customerinvoiceline',
                'property' => 'lines',
                'tablelink' => 'customerinvoice_line',
                'only_parent' => 'customerinvoice_id',
           ],
        ];
    }

    public function validate($line): array
    {
        $errors = parent::validate($line);

        if (@$line->date == null) {
            $errors[] = 'no date';
        }

        if (@$line->name == null) {
            $errors[] = 'no name';
        }

        if (@$line->address == null) {
            $errors[] = 'no address';
        }

        return $errors;
    }

    public function complete($line) : void
    {
    }
}
