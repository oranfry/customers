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

        $this->borrow['date'] = fn ($line): ?string => @$line->invoice->date;
        $this->borrow['user'] = fn ($line): ?string => @$line->invoice->user;

        $this->inlinelinks[] = (object) [
            'linetype' => 'customerinvoice',
            'tablelink' => 'customerinvoice_line',
            'property' => 'invoice',
            'reverse' => true,
            'orphanable' => true,
        ];
    }

    public function unpack($line, $oldline, $old_inlines)
    {
        $line->invoice = 'unchanged';
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
