<?php
namespace customers\linetype;

class customerinvoiceline extends \jars\Linetype
{
    public function __construct()
    {
        $this->table = 'customerinvoiceline';

        $this->simple_ints('num');
        $this->simple_strings('description', 'moredescription');

        $this->fields['amount'] = fn ($records) : string => bcadd('0', $records['/']->amount ?? '0', 2);
        $this->unfuse_fields['amount'] = fn ($line) : string => $line->amount ?? '0.00';
    }

    public function validate($line)
    {
        $errors = [];

        if (@$line->description == null) {
            $errors[] = 'no description';
        }

        return $errors;
    }
}
