<?php

namespace customers\linetype;

use simplefields\traits\SimpleFields;

class customerinvoiceline extends \jars\Linetype
{
    use SimpleFields;

    public function __construct()
    {
        $this->table = 'customerinvoiceline';

        $this->simple_int('num');
        $this->simple_string('description');
        $this->simple_string('moredescription');

        $this->fields['amount'] = fn ($records) : string => bcadd('0', $records['/']->amount ?? '0', 2);
        $this->unfuse_fields['amount'] = fn ($line) : string => $line->amount ?? '0.00';
    }

    public function validate($line): array
    {
        $errors = parent::validate($line);

        if (@$line->description == null) {
            $errors[] = 'no description';
        }

        return $errors;
    }
}
