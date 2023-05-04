<?php

namespace customers\linetype;

use simplefields\traits\SimpleFields;

class customercredit extends \jars\Linetype
{
    use SimpleFields;

    public function __construct()
    {
        $this->table = 'customercredit';

        $this->simple_date('date');
        $this->simple_string('description');

        $this->fields['amount'] = fn ($records) : string => bcadd('0', $records['/']->amount ?? '0', 2);
        $this->unfuse_fields['amount'] = fn ($line) : string => $line->amount ?? '0.00';
    }

    public function validate($line): array
    {
        $errors = parent::validate($line);

        if ($line->date == null) {
            $errors[] = 'no date';
        }

        if ($line->amount == null) {
            $errors[] = 'no amount';
        }

        return $errors;
    }
}
